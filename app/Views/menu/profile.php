<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .container:hover {
            transform: scale(1.01);
            box-shadow: 0 15px 40px rgba(255, 99, 71, 0.3);
        }


        h2 {
            color: #000;
            font-weight: bold;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #000;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background-color: #000;
            color: white;
            font-weight: 600;
        }

        .alert {
            border-radius: 8px;
        }

        button {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
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

        <form method="post" action="/menu/updateProfile" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="restaurant_name" class="form-label">Restaurant Name</label>
                <input type="text" name="restaurant_name" id="restaurant_name" class="form-control" 
                       value="<?= isset($restaurant['restaurant_name']) ? $restaurant['restaurant_name'] : '' ?>" 
                       required minlength="3" maxlength="50">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" 
                       value="<?= isset($restaurant['email']) ? $restaurant['email'] : '' ?>" 
                       required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo:</label>
                <input type="file" name="photo"  id ="photo" accept=".jpg, .jpeg, .png" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" 
                       value="<?= isset($restaurant['phone_number']) ? $restaurant['phone_number'] : '' ?>" 
                       required minlength="10" pattern="\d+">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="8">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-50">Update Profile</button>
            </div>
        </form>
        <div class="d-grid gap-2 mt-3">
            <a href="<?= site_url('/menu') ?>" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
