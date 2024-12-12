<!DOCTYPE html>
<html lang="en">
<head>
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Roboto', sans-serif;
            padding: 20px;
        }

        .container {
            background-color: #e5e7e9;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
        }

        h1 {
            text-align: center;
            font-size: 2.2rem;
            color: #333333;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .category-btn {
            width: 100%;
            margin-bottom: 10px;
            background-color: #fffafa;
            border: none;
            border-radius: 5px;
            padding: 10px;
            color: #000000;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .category-btn:hover {
            background-color: #fffafa;
            cursor: pointer;
        }

        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card img {
            border-radius: 8px 8px 0 0;
            max-height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 1.15rem;
            color: #333;
            font-weight: bold;
        }

        .card-text {
            font-size: 0.95rem;
            color: #666;
        }

        .btn-add-to-cart {
            background-color: #ff6f61;
            color: #fff;
            font-weight: bold;
            border-radius: 20px;
            padding: 8px 16px;
            transition: background-color 0.3s;
            border: none;
        }

        .btn-add-to-cart:hover {
            background-color: #ff8f85;
            cursor: pointer;
        }

        .btn-back, .cart-button {
            display: inline-block;
            background-color: #ff6f61;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            padding: 8px 16px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn-back:hover, .cart-button:hover {
            background-color: #ff8f85;
        }
        
        .cart img {
            max-width: 40px;
            max-height: 40px;
            object-fit: contain;
        }

        .cart-container {
            margin-top: 30px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-container h3 {
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        .table-responsive {
            margin-top: 15px;
        }

        .table th, .table td {
            text-align: center;
            padding: 10px;
        }

        #total-bill {
            font-size: 1.4rem;
            color: #ff6f61;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }

        .empty-cart-msg {
            color: #666;
            font-style: italic;
            text-align: center;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn {
            background-color: #ff6f61;
            color: #fff;
            border: none;
            padding: 5px 12px;
            font-weight: bold;
            border-radius: 5px;
            margin: 0 3px;
            transition: background-color 0.3s;
        }

        .quantity-btn:hover {
            background-color: #ff8f85;
        }

        .quantity-display {
            font-weight: bold;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .card img {
                max-height: 150px;
            }
        }

        #toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }
    </style>
    <script>
        const menuItems = <?php echo json_encode($menus); ?>;

        async function fetchQuantityLimit(itemId) {
            try {
                const item = menuItems.find(i => i.id == itemId);
                return item ? item.quantity_limit : 0;
            } catch (error) {
                console.error('Error fetching quantity limit:', error);
                return 0;
            }
        }

        // async function addToCart(itemId, itemName, itemPrice) {
        //     const quantityLimit = await fetchQuantityLimit(itemId);

        //     let cart = JSON.parse(localStorage.getItem('cart')) || {};

        //     if (cart[itemId]) {
        //         if (cart[itemId].quantity + 1 > quantityLimit) {
        //             alert(`Cannot add more of this item. Available stock is ${quantityLimit}.`);
        //             return;
        //         } else {
        //             cart[itemId].quantity += 1;
        //         }
        //     } else {
        //         cart[itemId] = {
        //             name: itemName,
        //             price: itemPrice,
        //             quantity: 1
        //         };
        //     }

        //     localStorage.setItem('cart', JSON.stringify(cart));
        //     updateCartQuantityDisplay(itemId);
        // }


        async function addToCart(itemId, itemName, itemPrice) {
            const response = await fetch('api/add-item', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    'itemId': itemId,
                    'itemName': itemName,
                    'itemPrice': itemPrice
                }),
            });

            const data = await response.json();
            showToast("Item added successfully");
        }

        function updateCartQuantityDisplay(itemId) {
            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            const item = cart[itemId];
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            if (quantityElement) {
                quantityElement.textContent = item ? item.quantity : 0;
            }
        }

        function decreaseQuantity(itemId) {
            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            if (cart[itemId] && cart[itemId].quantity > 1) {
                cart[itemId].quantity -= 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartQuantityDisplay(itemId);
            }
        }

        function increaseQuantity(itemId) {
            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            fetchQuantityLimit(itemId).then(quantityLimit => {
                if (cart[itemId] && cart[itemId].quantity < quantityLimit) {
                    cart[itemId].quantity += 1;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartQuantityDisplay(itemId);
                }
            });
        }

        function showMenu(category) {
            const filteredItems = category === 'all' ? menuItems : menuItems.filter(item => item.type === category);
            let menuHTML = '';
            filteredItems.forEach(item => {
                menuHTML += `
                    <div class="col-md-3">
                        <div class="card">
                            <img src="<?= base_url('uploads/menu_photos/') . '${item.photo}' ?>" alt="${item.name}">
                            <div class="card-body">
                                <h5 class="card-title">${item.name}</h5>
                                <p class="card-text">Price: ₹${item.price}</p>
                                <!--<div class="quantity-controls">
                                    <button class="quantity-btn" onclick="decreaseQuantity(${item.id})">-</button>
                                    <span id="quantity-${item.id}" class="quantity-display">0</span>
                                    <button class="quantity-btn" onclick="increaseQuantity(${item.id})">+</button>
                                </div>--!>
                                <button class="btn btn-add-to-cart" onclick="addToCart(${item.id}, '${item.name}', ${item.price})">Add to Cart</button>
                            </div>
                        </div>
                    </div>`;
            });

            document.getElementById('menu-items').innerHTML = menuHTML;
        }

        function showToast(message) {
            var toast = document.getElementById("toast");
            toast.innerHTML = message;
            toast.style.visibility = "visible";

            setTimeout(function() {
                toast.style.visibility = "hidden";
            }, 3000);
        }
    </script>
</head>

<body onload="showMenu('all')">
    <div class="container">
        <a href="/CustomerUsers/Payment" class="cart">
            <img src="<?= base_url('/Restaurant_photo/cart.png') ?>" alt="Cart">
        </a>
        <a href="/CustomerUsers/dashboard" class="btn-back">Go Back</a>

        <h1>Menu</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="category-btn" onclick="showMenu('all')">All items</button>
                    </li>
                    <li class="nav-item">
                        <button class="category-btn" onclick="showMenu('Beverages')">Beverages</button>
                    </li>
                    <li class="nav-item">
                        <button class="category-btn" onclick="showMenu('Starter')">Starter</button>
                    </li>
                    <li class="nav-item">
                        <button class="category-btn" onclick="showMenu('Main Course')">Main Course</button>
                    </li>
                    <li class="nav-item">
                        <button class="category-btn" onclick="showMenu('Dessert')">Dessert</button>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="row" id="menu-items"></div>
    </div>
    <div id="toast"></div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
