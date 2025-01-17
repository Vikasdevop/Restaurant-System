<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurants and Menus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #ffffff;
      color: #333;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 20px;
      padding-inline-start: 5px;
    }

    h2 {
      color: #ff0000;
      font-weight: bold;
      font-size: 3rem;
      text-align: start;
      font-family: 'Poppins', sans-serif;
      letter-spacing: 1px;
      text-transform: uppercase;
      background-color: #ff5722;
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease-in-out;
      padding: 5px 0;
    }

    h2:hover {
      color: #ff0000;
      text-shadow: 4px 4px 15px rgba(0, 0, 0, 0.3);
      transform: scale(1.05);
    }

    .cart img {
      max-width: 40px;
      max-height: 40px;
      object-fit: contain;
    }

    .cart {
      margin-left: 16px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-btn {
      align-items: center;
      position: absolute;
      right: 25px;
      background-color: transparent;
      border: transparent;
    }

    .profile-btn img {
      width: 30px;
      height: 30px;
      border-radius: 5%;
      object-fit: cover;
    }

    .btn-primary {
      background-color: #e74c3c;
      border: none;
      color: #fff;
      font-weight: bold;
      padding: 10px 15px;
      font-size: 1.1rem;
      border-radius: 5px;
      transition: background 0.4s ease, transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .btn-primary::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 0;
      height: 100%;
      background: rgba(255, 255, 255, 0.3);
      transition: width 0.5s ease;
      z-index: 1;
    }

    .btn-primary:hover::before {
      width: 100%;
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .restaurant-list {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 50px;
      padding: 90px;
    }

    @media (max-width: 768px) {
      .restaurant-list {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 400px) {
      .restaurant-list {
        grid-template-columns: 1fr;
      }
    }

    .restaurant-card {
      display: flex;
      flex-direction: column;
      gap: 10px;
      background-color: #ecf0f1;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
    }

    .restaurant-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .restaurant-card img {
      border-radius: 5px;
      max-height: 120px;
      object-fit: cover;
      width: 100%;
      margin-bottom: 30px;
    }

    .restaurant-title {
      /* display: flex; */
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      font-weight: bold;
      color: #000000;
      margin: 0;
    }

    .restaurant-description {
      color: #7f8c8d;
      font-size: 1rem;
      margin-bottom: 15px;
    }

    .search-bar {
      display: inline-flex;
      justify-content: center;
      align-items: center;
      margin-left: 20px;
    }

    .search-bar input {
      width: 100%;
      max-width: 750px;
      border-radius: 5px;
      padding: 12px 18px;
      font-size: 1.1rem;
      border: 1.5px solid #ffffff;
      margin-right: 10px;
    }

    .range-slider-container {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .range-slider {
      width: 100%;
      margin: 0 auto;
    }

    .logout-btn {
      position: absolute;
      top: 20px;
      right: 40px;
    }

    .logout-btn .btn {
      background-color: #ffffff;
      border: none;
      padding: 5px 20px;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: bold;
      margin-left: -90px;
      margin-right: 20px;
    }

    .sidebar {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    .sidebar h3 {
      font-size: 20px;
      margin-bottom: 15px;
      color: #333;
    }

    .sidebar ul li {
      margin-bottom: 10px;
    }

    .sidebar ul li a {
      font-size: 16px;
      color: #007bff;
      text-decoration: none;
    }

    .sidebar ul li a:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    /* Dropdown menu styling */
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #ffffff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      padding: 10px 0;
      z-index: 1000;
    }

    .dropdown:hover .dropdown-menu {
      display: block;
    }

    .dropdown-menu .dropdown-item {
      padding: 10px 20px;
      color: #333333;
      text-decoration: none;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }

    .dropdown-menu .dropdown-item:hover {
      background-color: #f8f9fa;
      color: #000000;
    }

    .range-slider-container {
      padding: 10px 20px;
      border-top: 1px solid #e9ecef;
      margin-top: 5px;
    }

    .range-slider-container label {
      font-size: 14px;
      color: #555555;
      margin-right: 10px;
    }

    .range-slider-container select {
      padding: 5px 10px;
      font-size: 14px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .range-slider-container select:focus {
      border-color: #80bdff;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
    }

    .range-slider-container #distanceValue {
      font-weight: bold;
      margin-left: 10px;
      color: #007bff;
    }
  </style>
</head>

<body>
  <div class="container">
    <a href="/CustomerUsers/dashboard" class="btn">
      <h2>Mealzo</h2>
    </a>
    <div>
      <button class="btn btn-secondary dropdown-toggle profile-btn" type="button" id="dropdownMenuButton"
        data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?= base_url('/Restaurant_photo/customerProfile.png') ?>" alt="Profile">
      </button>
      <a href="/CustomerUsers/Payment" class="cart">
        <img src="<?= base_url('/Restaurant_photo/cart.png') ?>" alt="Cart">
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="<?= site_url('CustomerUsers/customerProfile') ?>">Profile</a></li>

        <div class="range-slider-container">
          <label for="range">Range:</label>
          <select id="range" onchange="updateDistanceValue()">
            <option value="2">2 km</option>
            <option value="3">3 km</option>
            <option value="5">5 km</option>
            <option value="7">7 km</option>
            <option value="10">10 km</option>
            <option value="15">15 km</option>
            <option value="20">20 km</option>
          </select>
          <span id="distanceValue">2 km</span>
        </div>
        <li><a class="dropdown-item" href="/logout">Log out</a></li>

        <script>
          function updateDistanceValue() {
            var distance = document.getElementById('range').value;
            document.getElementById('distanceValue').textContent = distance + ' km';
            filterRestaurantsByDistance(distance);
          }
        </script>
      </ul>
    </div>
  </div>

  <div class="input-search">
    <form action="<?= site_url('restaurants/search') ?>" method="get" class="d-flex justify-content-center mb-4">
      <input type="text" name="search" class="form-control w-50 me-2" placeholder="Search for restaurants"
        value="<?= isset($searchQuery) ? esc($searchQuery) : '' ?>" required>
      <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <?php if (isset($searchQuery)): ?>
      <?php if (!empty($restaurants)): ?>
        <ul class="rs">
          <div class="restaurant-card">
            <?php foreach ($restaurants as $restaurant): ?>
              <li class="list-group-item">
                <a href="<?= site_url('menu/x/' . $restaurant['id']) ?>">
                  <?= esc($restaurant['restaurant_name']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </div>
        </ul>
      <?php else: ?>
        <p class="text-center text-danger">No restaurants found matching your search.</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    const rangeSlider = document.getElementById('range');
    const distanceValue = document.getElementById('distanceValue');

    rangeSlider.addEventListener('input', function () {
      localStorage.setItem('sliderValue', rangeSlider.value);
      distanceValue.textContent = rangeSlider.value + ' km';
    });

    window.onload = function () {
      const savedValue = localStorage.getItem('sliderValue');
      if (savedValue !== null) {
        rangeSlider.value = savedValue;
        distanceValue.textContent = savedValue + ' km';
      }
    };
  </script>

  <div class="restaurant-list" id="restaurantList">
    <!-- <?php if (empty($restaurantMenus)): ?>
            <div class="alert alert-warning" role="alert">No restaurants found matching your search.</div>
        <?php else: ?> -->
      <?php foreach ($restaurantMenus as $restaurant): ?>
        <div class="restaurant-card" data-lat="<?= $restaurant['latitude'] ?>" data-lng="<?= $restaurant['longitude'] ?>">
          <?php if (isset($restaurant['photo']) && !empty($restaurant['photo'])): ?>
            <img src="<?= base_url('/' . $restaurant['photo']); ?>" alt="<?= $restaurant['restaurant_name']; ?>"
              class="restaurant-image">
          <?php else: ?>
            <img src="/public/Restaurant_photo/default.jpg" alt="Default Restaurant Image" class="img-fluid">
          <?php endif; ?>
          <h3 class="restaurant-title">
            <?= $restaurant['restaurant_name'] ?>
          </h3>
          <h4 class="menu">
            <?php if ($restaurant['is_open'] == 1): ?>
              <a href="/menu/x/<?= $restaurant['id']; ?>" class="btn btn-primary">View Menu</a>
            <?php else: ?>
              <button class="btn btn-secondary" disabled>Restaurant is currently closed</button>
            <?php endif; ?>
          </h4>

          <?php if (session()->get('status') == 'added'): ?>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
              <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="500">
                <div class="d-flex">
                  <div class="toast-body">
                    Added to favourites!
                  </div>
                  <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
                </div>
              </div>
            </div>
            <?php session()->remove('status'); ?>
          <?php endif; ?>

          <?php if (session()->get('status') == 'removed'): ?>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
              <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="500">
                <div class="d-flex">
                  <div class="toast-body">
                    Removed from favourites!
                  </div>
                  <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
                </div>
              </div>
            </div>
            <?php session()->remove('status'); ?>
          <?php endif; ?>

          <?php if ($restaurant['is_favorite'] == 1): ?>
            <form action="/dashboard/removeFromFavorite/<?php echo $restaurant['id']; ?>" method="post">
              <button type="submit" class="btn btn-outline-danger">Remove from Favourites</button>
            </form>
          <?php else: ?>
            <form action="/dashboard/addToFavorite/<?php echo $restaurant['id']; ?>" method="post">
              <button type="submit" class="btn btn-outline-success">Add to Favourites</button>
            </form>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <script>
    document.getElementById('range').addEventListener('input', function () {
      document.getElementById('distanceValue').innerText = this.value + ' km';
    });

    function filterRestaurantsByDistance() {
      const rangeValue = document.getElementById('range').value;
      document.getElementById('distanceValue').textContent = rangeValue + ' km';
      filterRestaurantsByLocation(rangeValue);
    }

    function filterRestaurantsByLocation(rangeValue) {
      const userLatitude = window.userLatitude;
      const userLongitude = window.userLongitude;

      if (userLatitude && userLongitude) {
        document.querySelectorAll('.restaurant-card').forEach((card) => {
          const lat = parseFloat(card.getAttribute('data-lat'));
          const lng = parseFloat(card.getAttribute('data-lng'));
          const distance = calculateDistance(userLatitude, userLongitude, lat, lng);

          if (distance <= rangeValue) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }

          const distanceElement = card.querySelector('.restaurant-distance');
          if (distanceElement) {
            distanceElement.innerText = `${distance.toFixed(2)} km`;
          }
        });
      } else {
        console.warn('User location is not available.');
      }
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371;
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    }

    function clearSearch() {
      const searchField = document.querySelector('[name="search"]');
      if (searchField) {
        searchField.value = '';
      }

      const crossButton = document.querySelector('.cross-btn');
      if (crossButton) {
        crossButton.style.display = 'none';
      }
    }

    function getUserLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            window.userLatitude = position.coords.latitude;
            window.userLongitude = position.coords.longitude;
            filterRestaurantsByLocation(5);
          },
          function (error) {
            console.error('Error getting location:', error.message);
          }
        );
      } else {
        console.warn('Geolocation is not supported by this browser.');
      }
    }

    getUserLocation();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>