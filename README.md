# 💳 Payment Gateway & confimation sms with details in CodeIgniter 4 🚀  

This project integrates **Razorpay** for payment processing and **Twilio** for payment confirmation in **CodeIgniter 4 (CI4)**.  

### 🔹 **How It Works:**   
1. **Payment Processing:** After entering details, users can proceed to payment via **Razorpay**.  
2. **Transaction Storage:** Payment details (email, phone, name, amount, transaction ID, timestamp) are stored in **Firestore**.  
3. **Payment Confirmation:** A confirmation SMS is sent to the user via **Twilio**.  

---

## ✨ Features  
- 💳 **Payment Gateway using Razorpay**  
- 🗄 **Firestore for Storing Transaction Details**  
- 🎯 **Dashboard Access after Successful Payment**  
- 🔄 **Automatic Payment Confirmation via SMS**  

---

## 📌 Prerequisites  
Ensure you have the following installed:  
- ✅ PHP 8.2+  
- ✅ Composer  
- ✅ CodeIgniter 4  
- ✅ Twilio Account (for SMS)  
- ✅ Razorpay Account (for Payments)  
- ✅ Firebase Firestore (for storing transactions)  
- ✅ XAMPP or any local server environment  

---

## ⚡ Setup Instructions  

### 1️⃣ Get Required API Credentials 🔑  

#### **Twilio Setup**  
1. Sign up at [Twilio](https://www.twilio.com/).
2. install sdk.  
3. Verify your phone number 📞.  
4. Get a free Twilio phone number.  
5. Copy your **Twilio SID**, **Auth Token**, and **Phone Number**.
6. add keys in config file. 

#### **Razorpay Setup**  
1. Sign up at [Razorpay](https://razorpay.com/).
2. install sdk .
3. Create an API Key and Secret replace in config.  

#### **Firebase Firestore Setup**  
1. Go to [Firebase Console](https://console.firebase.google.com/).  
2. Create a new project and enable Firestore.
3. install sdk.
4. Get your **Firestore credentials JSON file** replace in writable folder.  

---

## 🛠️ Usage
1. Open `http://localhost:8080/payment` in your browser.
2. Enter your details.
3. click pay 🔑.
4. choose payemnt method(acc no., card etc) 🏆.
5. check in firestore for details 🚪.
6. check for confirmation message in phone.
7. 
### 2️⃣ Clone the Repository  
```sh
git clone https://github.com/Ismail-Rahib/payment-gateway.git
cd payment-gateway

## 📜 License
This project is open-source under the [MIT License](LICENSE).

