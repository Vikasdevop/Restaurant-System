<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Menu Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff;
      color: #000;
      font-family: Arial, sans-serif;
    }

    .container {
      background-color: ##e5e7e9;
    }

    h2 {
      color: #000000;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }

    .alert {
      background-color: #f8d7da;
      color: #721c24;
      border-color: #f5c6cb;
      border-radius: 6px;
      text-align: center;
      padding: 15px;
      font-weight: bold;
    }

    .form-label {
      color: #000;
      font-weight: bold;
      margin-bottom: 6px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #ff8a65, #ff5722);
      border: none;
      font-weight: bold;
      padding: 12px;
      border-radius: 10px;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #2980b9;
    }

    .btn-secondary {
      background: linear-gradient(135deg, #ff8a65, #ff5722);
      border: none;
      color: #000;
      font-weight: bold;
      padding: 12px;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .form-control {
      background-color: #f2f3f4;
      color: #333;
      border: 1px solid #ced4da;
      font-weight: bold;
      border-radius: 10px;
      padding: 10px;
    }

    .form-control:focus {
      background-color: #e5e7e9;
      border-color: #3498db;
      color: #333;
      box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
    }

    .container {
      max-width: 600px;
      margin: auto;
      padding: 40px;
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .d-grid {
      margin-top: 20px;
    }

    .d-grid a {
      text-align: center;
      font-weight: bold;
      color: #333;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h2>Add Menu Item</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('/menu/store') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="type" class="form-label">Menu Type:</label>
        <select name="type" class="form-control" required>
          <option value="Beverages">Beverages</option>
          <option value="Starter">Starter</option>
          <option value="Main Course">Main Course</option>
          <option value="Dessert">Dessert</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Item Name:</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" name="price" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="photo" class="form-label">Photo:</label>
        <input type="file" name="photo" class="form-control" accept="image/*" required>
      </div>

      <div class="d-grid gap-2">
        <input type="submit" value="Add Item" class="btn btn-primary">
      </div>

      <div class="d-grid gap-2 mt-3">
        <a href="<?= site_url('/menu') ?>" class="btn btn-secondary">Back</a>
      </div>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>