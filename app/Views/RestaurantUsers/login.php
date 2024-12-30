<!DOCTYPE html>
<html lang="en"> 
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    body {
        background-image: url('<?= base_url('/Restaurant_photo/back.png')?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10;
        height: 100vh;
        overflow: hidden;
    }

    .card {
        background-color: #d0d3d4;
        border-radius: 15px;
        padding: 30px 40px;
        margin-left: 800px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 50%;
        text-align: center;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 40px rgba(255, 99, 71, 0.3);
    }

    .logo {
        margin-bottom: 20px;
    }

    .logo img {
        width: 100px;
        border-radius: 5%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #000000;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
    }

    .form-label {
        color: #333;
        font-weight: 500;
    }

    .form-control,
    .btn-primary {
        border-radius: 8px;
        padding: 12px;
    }

    .form-control:focus {
        border-color: #ffffff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background: #000000;
        color: #fff;
        font-size: 18px;
        margin-top: 20px;
        padding: 12px 20px;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #515a5a;
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(255, 69, 0, 0.3);
    }

    .login-option-box {
        background: #e74c3c;
        border-radius: 10px;
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        cursor: pointer;
        padding: 20px 15px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 10px 0;
        width: 100%;
    }

    .login-option-box:hover {
        background: #e74c3c;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        transform: scale(1.05);
    }

    .modal-content {
        background: #FFFFFF;
        border-radius: 15px;
        color: #555;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    a {
        color: #0049a7;
        text-decoration: none;
        font-weight: 1200;
        transition: color 0.3s ease;
    }

    a:hover {
        color: #FF4500;
        text-decoration: underline;
    }
</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="logo">
                <img src="<?= base_url('/Restaurant_photo/logo.jpg')?>" alt="Logo"> <!-- Replace with your logo URL -->
            </div>

            <h2>Welcome Back</h2>
            <form id="loginForm" action="/login" method="post">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="login-as-heading">Login As:</div>
                <div class="boxy">
                    <select name = "role" id = "login as" required>
                        <option value = "Restaurant">Restaurant</option>
                        <option value = "Customer">Customer</option>
                        <!-- <option value = "Admin">Admin</option> -->
                    </select>
                </div>
                <div class="g-recaptcha my-3" data-sitekey="6Lc1cqkqAAAAADicwuGMDwNyWn-MKXUA8eHY4yKl"></div>
                <button type="submit" class="btn btn-primary w-100"><span>Login</span></button>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register here</a></p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register As</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <button onclick="window.location.href='/register'" class="btn btn-primary">Restaurant</button>
                    <button onclick="window.location.href='/customer/register'" class="btn btn-primary">Customer</button>
                    <!-- <button onclick="window.location.href='/Admin/register'" class="btn btn-primary">Admin</button> -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
