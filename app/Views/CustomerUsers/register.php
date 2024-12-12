<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

    <style>
    body {
        background: linear-gradient(135deg, #ff6b6b, #fff8f0);
        font-family: 'Poppins', sans-serif;
        color: #333;
    }
    .container {
        margin-top: 5%;
    }
    .card {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    h2 {
        font-weight: 600;
        color: #ff4d4d;
        text-align: center;
        margin-bottom: 30px;
    }
    .form-label {
        font-weight: bold;
        color: #000;
    }
    .form-control {
        background-color: #f9f9f9;
        color: #000;
        border: 1px solid #ddd;
        font-weight: bold;
    }
    .form-control::placeholder {
        color: #b0b0b0;
    }
    .form-control:focus {
        background-color: #f9f9f9;
        color: #000;
        border-color: #ff4d4d;
    }
    .btn-primary {
        background: linear-gradient(135deg, #ff4d4d, #ff1a1a);
        border: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #ff1a1a;
        transform: translateY(-3px);
    }
    .alert {
        margin-top: 20px;
        font-size: 14px;
        background-color: #ff4d4d;
        color: #fff;
    }
    .form-section {
        margin-bottom: 20px;
    }
    .iti__country-name {
        display: none;
    }
    </style>

    <script src="https://www.google.com/recaptcha/api.js?render=6LdynngqAAAAAJFgUVP9AdohzfvK_1sK5z8lOLzX"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h2>Customer Registration</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form id="registration-form" action="/customerRegisterUser" method="post" onsubmit="return validateForm()">
                        <div class="form-section">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required pattern="[A-Za-z\s]+" title="Name should only contain letters and spaces.">
                        </div>

                        <div class="form-section">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required title="Please enter a valid email address.">
                        </div>

                        <div class="form-section">
                            <label for="phone_number" class="form-label">Phone Number:</label>
                            <input id="phone_number" type="tel" name="phone_number" class="form-control" required placeholder="Phone Number">
                            <input type="hidden" name="country_code" id="country_code" required>
                        </div>

                        <div class="form-section">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" required minlength="8" title="Password must be at least 8 characters long.">
                        </div>

                        <!-- <input type="hidden" id="recaptcha-token" name="g-recaptcha-response"> -->

                        <div class="d-grid gap-2">
                            <input type="submit" value="Register" class="btn btn-primary">
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="/login">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInput = document.querySelector("#phone_number");
        const iti = intlTelInput(phoneInput, {
            initialCountry: "auto",
            separateDialCode: true,
            geoIpLookup: function(success, failure) {
                fetch("https://ipinfo.io?token=YOUR_TOKEN_HERE")
                    .then(response => response.json())
                    .then(data => success(data.country))
                    .catch(() => success("US"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        phoneInput.addEventListener("countrychange", function() {
            const countryData = iti.getSelectedCountryData();
            document.getElementById("country_code").value = countryData.dialCode;
        });

        function validateForm() {
            if (!iti.isValidNumber()) {
                alert("Please enter a valid phone number.");
                return false;
            }

        //     grecaptcha.ready(function() {
        //         grecaptcha.execute('6LdynngqAAAAAJFgUVP9AdohzfvK_1sK5z8lOLzX', { action: 'register' }).then(function(token) {
        //             document.getElementById('recaptcha-token').value = token;
        //             document.getElementById('registration-form').submit();
        //         });
        //     });

        //     return false;
        // }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
