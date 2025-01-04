<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Favorite Restaurant</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="Favorite">
    <?php if (!empty($favorites)): ?>
      <?php foreach ($favorite as $restaurant): ?>
        <a href="<?= base_url('menu/x/' . $restaurant['id']) ?>">
          <?= esc($restaurant['resstaurant_name']) ?>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <li>No added favorite Restaurant</li>
    <?php endif; ?>
  </div>
</body>

</html>