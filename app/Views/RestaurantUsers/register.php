<!DOCTYPE HTML> 
<html lang="en">  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <style>
        body {background-color: #f4f6f7; font-family: 'Poppins', sans-serif; color: #333; }
        .container { margin-top: 5%; }
        .card { background-color: #ffffff; border-radius: 15px; padding: 40px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); border: 1px solid #ddd; }
        h2 { font-weight: 600; color: #e74c3c; text-align: center; margin-bottom: 30px; }
        .btn-primary { background: linear-gradient(135deg, #e74c3c, #c0392b); border: none; transition: background-color 0.3s ease, transform 0.3s ease; }
        .btn-primary:hover { background-color: #c0392b; transform: translateY(-3px); }
        .form-label, .alert, .text-center a { color: #333; font-weight: bold; }
        .form-control { background-color: #f9f9f9; color: #333; border: 1px solid #ddd; border-radius: 10px; }
        .form-control:focus { border-color: #e74c3c; box-shadow: 0 0 5px rgba(231, 76, 60, 0.5); }
        
        .iti__country-name { display: none; }
        .iti__flag-container { width: 100px !important; }
        .alert { border-radius: 10px; }
        .text-center a { color: #e74c3c; font-weight: 700; }
        .text-center a:hover { text-decoration: none; color: #c0392b; }
    </style>
    <!-- <script src="https://www.google.com/recaptcha/api.js?render=6LdynngqAAAAAJFgUVP9AdohzfvK_1sK5z8lOLzX"></script> -->
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h2>Restaurant Register</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('/register_restaurant') ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="restaurant_name" class="form-label">Restaurant Name:</label>
                            <input type="text" name="restaurant_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <small id="emailHelp" class="form-text text-danger" style="display:none;">Invalid email format.</small>
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number:</label>
                            <input id="phone_number" type="tel" name="phone_number" class="form-control" required placeholder="Phone Number">
                            <input type="hidden" name="country_code" id="country_code" required>
                            <small id="phoneHelp" class="form-text text-danger" style="display:none;">Phone number must be 10 to 15 digits.</small>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo:</label>
                            <input type="file" name="photo"  id = "photo" accept = "photo/*" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <small id="passwordHelp" class="form-text text-danger" style="display:none;">Password must be at least 6 characters, with one number and one special character.</small>
                        </div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                        <div class="d-grid gap-2">
                            <input type="submit" value="Register" class="btn btn-primary">
                        </div>

                        <!-- <input type="hidden" id="recaptcha_token" name="recaptcha_token"> -->
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
            let isValid = true;

            const email = document.getElementById("email").value;
            const emailHelp = document.getElementById("emailHelp");
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                emailHelp.style.display = "block";
                isValid = false;
            } else {
                emailHelp.style.display = "none";
            }

            const phoneNumber = document.getElementById("phone_number").value.replace(/\D/g, '');
            const phoneHelp = document.getElementById("phoneHelp");
            if (phoneNumber.length < 10 || phoneNumber.length > 15) {
                phoneHelp.style.display = "block";
                isValid = false;
            } else {
                phoneHelp.style.display = "none";
            }

            const password = document.getElementById("password").value;
            const passwordHelp = document.getElementById("passwordHelp");
            const passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{6,}$/;
            if (!passwordPattern.test(password)) {
                passwordHelp.style.display = "block";
                isValid = false;
            } else {
                passwordHelp.style.display = "none";
            }

            // grecaptcha.ready(function() {
            //     grecaptcha.execute('6LdynngqAAAAAJFgUVP9AdohzfvK_1sK5z8lOLzX', { action: 'submit' }).then(function(token) {
            //         document.getElementById('recaptcha_token').value = token;
            //         document.forms[0].submit();
            //         });
            //     });
            //     return false;
            }
        // Get the user's current location using geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Get the coordinates
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Set the hidden fields with the coordinates
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            }, function(error) {
                console.log("Error getting location: " + error.message);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
