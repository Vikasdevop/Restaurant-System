<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $type ?> Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a, #333);
            color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 5%;
        }

        h2 {
            color: #4ecdc4;
            text-align: center;
            margin-bottom: 40px;
        }

        .card {
            background-color: #222;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .card img {
            border-radius: 15px;
            height: 200px; /* Set a fixed height */
            width: 100%; /* Ensure the image covers the width of the card */
            object-fit: cover; /* Ensure aspect ratio is maintained while filling the area */
        }

        .card-title {
            color: #4ecdc4;
        }

        .card-text {
            color: #f1f1f1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4ecdc4, #1f4037);
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1f4037;
            transform: translateY(-3px);
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center"><?= $type ?> Menu</h2>

        <div class="mb-3">
            <a href="<?= site_url('/menu') ?>" class="btn btn-secondary">Back</a>
        </div>

        <div class="row">
            <?php foreach ($items as $item): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?= base_url('uploads/menu_photos/' . $item['photo']) ?>" class="card-img-top" alt="<?= $item['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item['name'] ?></h5>
                            <p class="card-text">Price: <?= $item['price'] ?> INR</p>
                            <form action="<?= site_url('/menu/add') ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="name" value="<?= $item['name'] ?>">
                                <input type="hidden" name="price" value="<?= $item['price'] ?>">
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
