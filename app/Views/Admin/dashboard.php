<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="ml-auto">
      <a href="<?= base_url('/logout') ?>" class="btn btn-danger">Logout</a>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="mb-4">Manage Restaurants</h2>

    <?php if (session()->getFlashdata('message')): ?>
      <div class="alert alert-success">
        <?= session()->getFlashdata('message') ?>
      </div>
    <?php endif; ?>

    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Restaurant Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($restaurant) && count($restaurant) > 0): ?>
          <?php foreach ($restaurant as $restaurant): ?>
            <tr>
              <td><?= $restaurant['id'] ?></td>
              <td><?= $restaurant['restaurant_name'] ?></td>
              <td><?= $restaurant['email'] ?></td>
              <td><?= $restaurant['phone_number'] ?></td>
              <td>
                <img src="<?= base_url('/' . $restaurant['photo']); ?>" alt="photo" style="width: 120px; height: auto;">
              </td>
              <td>
                <form action="<?= base_url('Admin/deleteRestaurant/' . $restaurant['id']) ?>" method="post"
                  onsubmit="return confirm('Are you sure you want to delete this restaurant?');">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">No Restaurants Found</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>