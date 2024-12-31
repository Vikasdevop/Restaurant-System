<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $type ?> Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2><?= $type ?> Menu</h2>

    <div class="row">
      <?php foreach ($items as $item): ?>
        <div class="col-md-4 mb-3">
          <div class="card">
            <img src="<?= base_url('path/to/photos/' . $item['photo']) ?>" class="card-img-top"
              alt="<?= $item['name'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $item['name'] ?></h5>
              <p class="card-text">Price: <?= $item['price'] ?> </p>
              <form action="<?= site_url('/menu/add') ?>" method="post">
                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                <input type="hidden" name="item_name" value="<?= $item['name'] ?>">
                <button type="submit" class="btn btn-primary">Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>