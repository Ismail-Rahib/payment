<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Core\Timestamp;
use Razorpay\Api\Api;
use Config\Payment;
use Twilio\Rest\Client;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment_view');
    }

    public function processPayment()
    {
        try {
            $requestBody = file_get_contents("php://input");
            $request = json_decode($requestBody, true);

            log_message('info', 'Payment Data Received: ' . json_encode($request));

            // Validate input fields
            $amount = $request['amount'] ?? null;
            $name = $request['name'] ?? null;
            $email = $request['email'] ?? null;
            $phone = $request['phone'] ?? null;

            if (!$amount || !is_numeric($amount) || $amount < 1) {
                return $this->response->setJSON(['error' => 'Invalid amount. Minimum ₹1 required.'])->setStatusCode(400);
            }

            if (!$name || !$email || !$phone) {
                return $this->response->setJSON(['error' => 'Name, Email, and Phone are required.'])->setStatusCode(400);
            }

            $paymentConfig = new Payment();
            $api = new Api($paymentConfig->razorpayKeyId, $paymentConfig->razorpaySecretKey);

            $order = $api->order->create([
                'receipt' => uniqid(),
                'amount' => $amount * 100, 
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            $this->storeTransaction('razorpay', [
                'order_id' => $order['id'],
                'amount' => $amount,
                'status' => 'pending',
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone
                ]
            ]);

            return $this->response->setJSON([
                'order_id' => $order['id'],
                'amount' => $amount,
                'currency' => 'INR',
                'message' => 'Order created successfully.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Payment processing failed', 'details' => $e->getMessage()])->setStatusCode(500);
        }
    }

    public function confirmPayment()
    {
        try {
            $requestBody = file_get_contents("php://input");
            $request = json_decode($requestBody, true);

            log_message('info', 'Confirm Payment Request: ' . json_encode($request));

            $paymentId = $request['razorpay_payment_id'] ?? null;
            $amount = $request['amount'] ?? null;
            $name = $request['name'] ?? null;
            $email = $request['email'] ?? null;
            $phone = $request['phone'] ?? null;

            if (!$paymentId || !$amount || !$name || !$email || !$phone) {
                return $this->response->setJSON(['error' => 'Invalid confirmation details'])->setStatusCode(400);
            }

            $this->storeTransaction('razorpay', [
                'payment_id' => $paymentId,
                'amount' => $amount,
                'status' => 'confirmed',
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone
                ]
            ]);

            $this->sendPaymentSMS($phone, $name, $amount, $paymentId);

            return $this->response->setJSON(['message' => 'Payment confirmed. SMS sent.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Firestore error', 'details' => $e->getMessage()])->setStatusCode(500);
        }
    }

    private function storeTransaction($gateway, $data)
    {
        try {
            $firestore = new FirestoreClient([
                'keyFilePath' => WRITEPATH . 'firestore-key.json',
            ]);

            $transactionId = uniqid('txn_', true);

            $firestore->collection('transactions')->document($transactionId)->set([
                'transaction_id' => $transactionId,
                'gateway' => $gateway,
                'data' => $data,
                'timestamp' => new Timestamp(new \DateTime())
            ]);

            log_message('info', "Transaction stored in Firestore with ID: $transactionId");
        } catch (\Exception $e) {
            log_message('error', 'Firestore transaction failed: ' . $e->getMessage());
        }
    }

    private function sendPaymentSMS($phone, $name, $amount, $paymentId)
    {
        try {
            $twilioConfig = new \Config\Twilio();
            $client = new Client($twilioConfig->sid, $twilioConfig->token);

            $message = "Hi $name, your payment of ₹$amount was successful! Payment ID: $paymentId. Thank you!";
            
            $client->messages->create($phone, [
                'from' => $twilioConfig->from,
                'body' => $message
            ]);

            log_message('info', "SMS sent to $phone: $message");
        } catch (\Exception $e) {
            log_message('error', 'Twilio SMS Error: ' . $e->getMessage());
        }
    }
}
