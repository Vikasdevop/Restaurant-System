<!DOCTYPE HTML> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants and Menus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    body {
        background-color: #ffffff;
        color: #333; /* Text color */
        font-family: 'Poppins', sans-serif; /* Font style */
        margin: 0;
        padding: 0;
    }

    .container {
        margin-top: 40px; /* Space from the top for container */
    }

    h2 {
        color: #ff0000; /* Red color for the heading */
        font-weight: bold; /* Bold text */
        font-size: 2.5rem; /* Font size */
        text-align: start; /* Left align */
        margin-bottom: 10px; /* Space below heading */
    }

    .btn-primary {
        background-color: #e74c3c; /* Gradient background for button */
        border: none; /* No border */
        color: #fff; /* White text color */
        font-weight: bold; /* Bold text */
        padding: 10px 15px; /* Padding inside the button */
        font-size: 1.1rem; /* Font size */
        border-radius: 5px; /* Rounded corners */
        transition: background 0.4s ease, transform 0.3s ease, box-shadow 0.3s ease; /* Animation effects on hover */
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: ""; /* Decorative element inside the button */
        position: absolute;
        top: 0;
        left: 0;
        width: 0; /* Initially hidden */
        height: 100%; /* Full height */
        background: rgba(255, 255, 255, 0.3); /* White overlay */
        transition: width 0.5s ease; /* Animation for expansion */
        z-index: 1;
    }

    .btn-primary:hover::before {
        width: 100%; /* Expands on hover */
    }

    .btn-primary:hover {
        transform: translateY(-3px); /* Button moves up slightly on hover */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); /* Shadow effect on hover */
    }

    .restaurant-list {
        display: grid; /* Grid layout for restaurant cards */
        grid-template-columns: repeat(4, 1fr); /* 4 columns layout */
        gap: 50px; /* Space between cards */
        padding: 50px;
    }

    @media (max-width: 768px) {
        .restaurant-list {
            grid-template-columns: repeat(2, 1fr); /* 2 columns layout for smaller screens */
        }
    }

    @media (max-width: 400px) {
        .restaurant-list {
            grid-template-columns: 1fr; /* Single column layout for very small screens */
        }
    }

    .restaurant-card {
        background-color: #ecf0f1; /* Light grey background for restaurant card */
        border-radius: 8px; /* Rounded corners */
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effect */
        height: 100%;
    }

    .restaurant-card:hover {
        transform: translateY(-5px); /* Slight lift effect on hover */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); /* Deeper shadow on hover */
    }

    .restaurant-card img {
        border-radius: 5px; /* Rounded corners for image */
        max-height: 120px; /* Max height for images */
        object-fit: cover; /* Ensures the image covers the space */
        width: 100%; /* Full width */
        margin-bottom: 30px; /* Space below the image */
    }

    .restaurant-title {
        font-size: 1.6rem; /* Font size for restaurant name */
        font-weight: bold; /* Bold text */
        color: #000000; /* Black text color */
        margin: 0;
    }

    .restaurant-description {
        color: #7f8c8d; /* Light grey for description */
        font-size: 1rem; /* Font size for description */
        margin-bottom: 15px; /* Space below description */
    }
    .search-bar {
        display: inline-flex; /* Align search bar in-line with headings */
        justify-content: center;
        align-items: center;
        margin-left: 20px; /* Space between the headings and search bar */
    }

    h2, h3 {
        display: inline; /* Ensure headings are in-line */
        margin-right: 210px; /* Space between heading and search bar */
    }
    
    .search-bar input {
        width: 100%;
        max-width: 750px; /* Max width of input */
        border-radius: 5px; /* Rounded corners for input */
        padding: 12px 18px; /* Padding inside input */
        font-size: 1.1rem; /* Font size */
        border: 1.5px solid #ffffff; /* Red border */
        margin-right: 10px; /* Space between input and button */
    }

    .range-slider-container {
        text-align: center; /* Center-align the range slider */
        margin-bottom: 40px; /* Space below the slider */
    }

    .range-slider {
        width: 100%; /* Width of the range slider */
        margin: 0 auto; /* Center the slider */
    }

    .logout-btn {
        position: absolute;
        top: 20px;
        right: 40px;
    }

    .logout-btn .btn {
        background-color: #ffffff; /* White background for logout button */
        border: none; /* No border */
        padding: 5px 20px; /* Padding inside button */
        border-radius: 10px; /* Rounded corners */
        font-size: 1.1rem; /* Font size */
        font-weight: bold; /* Bold text */
        margin-left: -90px; /* Shift the button to the left */
    }

    @media (max-width: 768px) {
        .logout-btn {
            top: 10px;
            right: 10px; /* Adjust logout button position on small screens */
        }
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
</style>
</head>

<body>
    <div class="container">
        <div class="logout-btn">
            <a href="/logout" class="btn">Logout</a>
        </div>
        <a href="/CustomerUsers/dashboard" class="btn"><h2>Mealzo</h2></a>
        <div class="container mt-5">
        <h1 class="text-center">Search Restaurant</h1>
        <!-- Search Form -->
        <form action="<?= site_url('restaurants/search') ?>" method="get" class="d-flex justify-content-center mb-4">
            <input 
                type="text" 
                name="search" 
                class="form-control w-50 me-2" 
                placeholder="Search for restaurants" 
                value="<?= isset($searchQuery) ? esc($searchQuery) : '' ?>" 
                required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php if (isset($searchQuery)): ?>
            <?php if (!empty($restaurants)): ?> 
                <ul class="rs">
                <div  class = "restaurant-card">
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

        <div class="range-slider-container">
            <label for="rangeSlider">Select range (in km):</label>
            <input type="range" id="range" min="2" max="20" step="1" value="1" onchange="filterRestaurantsByDistance()" />
            <span id="distanceValue">2 km</span>
        </div>

        <div class="sidebar" style="flex: 1; padding: 20px; background-color: #f9f9f9; border-left: 1px solid #ddd;">
            <h3>Favorite Restaurants</h3>
            <ul style="list-style-type: none; padding: 0; margin: 0;">
                <?php if (!empty($favorites)): ?>
                    <?php foreach ($favorites as $restaurant): ?>
                        <li style="margin-bottom: 10px;">
                            <a href="<?= base_url('customer/viewMenu/' . $restaurant['id']) ?>" 
                                style="text-decoration: none; color: #000;">
                                <?= esc($restaurant['restaurant_name']) ?>
                            </a>                            
                        </li>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <li>No favorite restaurants added yet.</li>
                <?php endif; ?>
            </ul>
        </div>


        <div class="restaurant-list" id="restaurantList">
        <!-- <?php if (empty($restaurantMenus)): ?>
            <div class="alert alert-warning" role="alert">No restaurants found matching your search.</div>
        <?php else: ?> -->
            <?php foreach ($restaurantMenus as $restaurant): ?>
                <div class="restaurant-card" data-lat="<?= $restaurant['latitude'] ?>" data-lng="<?= $restaurant['longitude'] ?>">
                    <?php if (isset($restaurant['photo']) && !empty($restaurant['photo'])): ?>
                        <img src="<?= base_url('/' . $restaurant['photo']); ?>" alt="<?= $restaurant['restaurant_name']; ?>" class="restaurant-image">
                    <?php else: ?>
                        <img src="/public/Restaurant_photo/default.jpg" alt="Default Restaurant Image" class="img-fluid">
                    <?php endif; ?>
                    <h3 class="restaurant-title">
                        <?= $restaurant['restaurant_name'] ?>
                        <?php if (!$restaurant['status']): ?>
                            <span class="badge bg-danger">Closed</span>
                        <?php endif; ?>
                    </h3>
                    <?php if ($restaurant['is_open']==1): ?>
                        <a href="/menu/x/<?= $restaurant['id']; ?>" class="btn btn-primary">View Menu</a>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled>Restaurant is currently closed</button>
                    <?php endif; ?>

                    <?php if (session()->get('status') == 'added'): ?>
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="500">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        Added to favourites!
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        <?php session()->remove('status'); ?>
                    <?php endif; ?>

                    <?php if (session()->get('status') == 'removed'): ?>
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="500">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        Removed from favourites!
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        <?php session()->remove('status'); ?>
                        <?php endif;?>

                    <?php if ($restaurant['is_favorite']==1): ?>
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
                    filterRestaurantsByLocation(5); // Default to 5 km
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
</body>
</html>
