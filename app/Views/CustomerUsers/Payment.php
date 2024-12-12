<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .table {
            margin-bottom: 30px;
        }

        th {
            background-color: #f8f9fa;
        }

        td {
            text-align: center;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        #total-bill {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            color: #28a745;
        }

        .empty-cart-msg {
            text-align: center;
            font-size: 1.2rem;
            color: #ff6f61;
            margin-top: 20px;
        }

        .btn-success {
            font-size: 1.2rem;
            font-weight: bold;
            background-color: #28a745;
            border-color: #28a745;
            padding: 12px 20px;
            border-radius: 5px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn {
            font-size: 1.2rem;
            padding: 5px 10px;
            cursor: pointer;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 0 5px;
        }

        .quantity-display {
            font-size: 1.2rem;
            width: 40px;
            text-align: center;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }

            #total-bill {
                font-size: 1.2rem;
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
<!-- <script>
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    async function fetchQuantityLimit(itemId) {
        try {
            const a = menuItems.find(i=>i.id==itemId);
            return a.quantity_limit;
        } catch (error) {
            console.error('Error fetching quantity limit:', error);
            return 0;
        }
    }

    async function addToCart(itemId, itemName, itemPrice) {
        const quantityLimit = await fetchQuantityLimit(itemId);
        console.log('Quantity Limit:', quantityLimit);
        if (cart[itemId]) {
            if (cart[itemId].quantity + 1 > quantityLimit) {
                alert(`Cannot add more of this item. Available stock is ${quantityLimit}.`);
                return;
            } else {
                cart[itemId].quantity += 1;
            }
        } else {
            cart[itemId] = {
                name: itemName,
                price: itemPrice,
                quantity: 1
            };
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }

    function removeFromCart(itemId) {
        if (cart[itemId]) {
            cart[itemId].quantity -= 1;
            if (cart[itemId].quantity <= 0) {
                delete cart[itemId];
            }
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }

    function updateCart() {
        let cartTable = document.getElementById('cart-items');
        cartTable.innerHTML = '';
        let totalBill = 0;
        for (let itemId in cart) {
            let item = cart[itemId];
            let row = `<tr>
                        <td>${item.name}</td>
                        <td>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="removeFromCart(${itemId})">-</button>
                                <span class="quantity-display">${item.quantity}</span>
                                <button class="quantity-btn" onclick="addToCart(${itemId}, '${item.name}', ${item.price})">+</button>
                            </div>
                        </td>
                        <td>₹${item.price}</td>
                        <td>₹${item.price * item.quantity}</td>
                        <td><button class="btn btn-danger btn-sm" onclick="removeFromCart(${itemId})">Remove</button></td>
                    </tr>`;
            cartTable.innerHTML += row;
            totalBill += item.price * item.quantity;
        }

        document.getElementById('total-bill').innerText = '₹' + totalBill;
        if (Object.keys(cart).length === 0) {
            document.getElementById('empty-cart-msg').style.display = 'block';
        } else {
            document.getElementById('empty-cart-msg').style.display = 'none';
        }
    }

    function confirmOrder() {
        if (Object.keys(cart).length === 0) {
            alert("Your cart is empty!");
        } else {
            alert("Your order has been confirmed!");
        }
    }

    window.onload = updateCart;
</script> -->
</head>
<body>
    <div class="container">
    <a href="javascript:history.back()" class="btn btn-secondary mb-4">&lt;Back</a>
        <h1>Your Cart</h1>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php if(!empty($cartItems)): ?>
                    <?php foreach($cartItems as $item): ?>
                    <tr>
                        <td><?php echo $item['item_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['item_price']; ?></td>
                        <td><a href="/api/delete-item/<?php echo $item['cart_id'];?>" type="button" class="btn btn-danger">Delete Item</a href></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                    <td>NO ITEMS IN CART</td>
                    <tr>
                <?php endif; ?>
                <tbody id="cart-items"></tbody>
            </table>
            <p id="empty-cart-msg" class="empty-cart-msg" style="display: none;">Your cart is empty!</p>
        </div>

        <div id="total-bill"><?php echo 'Rs. '.$total; ?></div>

        <a href="#" class="btn btn-success btn-block" onclick="confirmOrder()">Confirm Order</a>
    </div>
    <div id="toast"></div>
</body>
<script>
    async function confirmOrder() {
            const response = await fetch('api/confirmPayment-api', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            });

            const data = await response.json();
            if(data.status === true){
                showToast("Payment Successful!!");
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
            else{
                showToast("Payment Failed");
            }
            
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
</html>
