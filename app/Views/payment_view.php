<!DOCTYPE html>
<html lang="en">

<head>
    <title>Razorpay Payment</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        var razorpayKey = "<?= (new \Config\Payment())->razorpayKeyId ?>";
    </script>

    <style>
        body {
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        #success-message {
            display: none;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    <h1 class="text-center text-primary my-4">PAYMENT GATEWAY</h1>
    <div class="container text-center">
        <h2 class="mb-4">ENTER DETAILS</h2>
        <div class="form-group">
            <label>Name:</label>
            <input type="text" id="name" class="form-control mb-3" oninput="checkFields()" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" id="email" class="form-control mb-3" oninput="checkFields()" required>
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" id="phone" class="form-control mb-3" oninput="checkFields()" required>
        </div>
        <div class="form-group" id="amount-container" style="display: none;">
            <h4>MAKE PAYMENT</h4>
            <label>Amount:</label>
            <input type="number" id="amount" class="form-control mb-3" min="1" value="10">
        </div>
        <!-- Centering the button -->
        <div class="d-flex justify-content-center">
            <button id="pay-button" class="btn btn-primary btn-lg mt-3" style="display: none;" onclick="payNow()">Pay Now</button>
        </div>
        <p id="success-message" class="text-success mt-3"></p>
    </div>

    <script>
        function getUserDetails() {
            return {
                name: document.getElementById("name").value.trim(),
                email: document.getElementById("email").value.trim(),
                phone: document.getElementById("phone").value.trim(),
                amount: parseFloat(document.getElementById("amount").value)
            };
        }

        function checkFields() {
            let user = getUserDetails();
            let payButton = document.getElementById("pay-button");
            let amountContainer = document.getElementById("amount-container");

            if (user.name && user.email && user.phone) {
                amountContainer.style.display = "block"; // Show amount field
                payButton.style.display = "block"; // Show pay button
            } else {
                amountContainer.style.display = "none"; // Hide amount field
                payButton.style.display = "none"; // Hide pay button
            }
        }

        function payNow() {
            let user = getUserDetails();
            if (!user.name || !user.email || !user.phone || user.amount < 1) {
                alert("All fields are required with a minimum amount of ₹1.");
                return;
            }

            fetch("<?= base_url('payment/process') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(user)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.order_id) {
                        var options = {
                            key: razorpayKey,
                            amount: data.amount * 100,
                            currency: data.currency,
                            name: user.name,
                            order_id: data.order_id,
                            prefill: {
                                name: user.name,
                                email: user.email,
                                contact: user.phone
                            },
                            handler: function(response) {
                                confirmPayment(response.razorpay_payment_id, user.amount);
                            }
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.error("Fetch error:", error));
        }

        function confirmPayment(paymentId, amount) {
            console.log("Confirming payment - ID:", paymentId, "Amount:", amount);

            let name = document.getElementById("name").value;
            let email = document.getElementById("email").value;
            let phone = document.getElementById("phone").value;

            fetch("<?= base_url('payment/confirm') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: paymentId,
                        amount: amount,
                        name: name,
                        email: email,
                        phone: phone
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        let successMessage = document.getElementById("success-message");
                        successMessage.innerText = "✅ Payment Successful!";
                        successMessage.style.display = "block";

                        // Clear fields after payment success
                        document.getElementById("name").value = "";
                        document.getElementById("email").value = "";
                        document.getElementById("phone").value = "";
                        document.getElementById("amount").value = "10";
                        checkFields(); // Hide amount & pay button again

                        setTimeout(() => {
                            successMessage.style.display = "none";
                        }, 5000);
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.error("Confirm payment error:", error));
        }
    </script>
</body>

</html>
