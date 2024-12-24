<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }

    .container {
        margin-top: 50px;
        max-width: 600px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-section {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: bold;
        color: #555;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
    }

    .btn-primary {
        background: linear-gradient(90deg, #007bff, #0056b3);
        border: none;
        color: #fff;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #0056b3, #007bff);
    }

    .btn-secondary {
        border: none;
        background-color: #6c757d;
        color: #fff;
    }

    .alert {
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }

    .text-center {
        text-align: center;
    }

    .d-grid {
        margin-top: 20px;
    }

    @media (max-width: 576px) {
        .btn-primary {
            width: 100%;
        }

        .btn-secondary {
            width: 100%;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" action="/dashboard/CustomerUpdateprofile" enctype="multipart/form-data">
            <?= csrf_field() ?>

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

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-50">Update Profile</button>
            </div>
        </form>
        <div class="d-grid gap-2 mt-3">
            <a href="<?= site_url('CustomerUsers/dashboard') ?>" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
