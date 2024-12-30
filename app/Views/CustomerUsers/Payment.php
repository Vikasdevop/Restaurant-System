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
                    <tr id="item-row-<?php echo $item['cart_id']; ?>">
                        <td><?php echo $item['item_name']; ?></td>
                        <td>
                            <button onclick="updateQuantity(<?php echo $item['cart_id']; ?>, -1, <?php echo $item['item_price']; ?>, <?php echo $item['item_id']; ?>, '-1')" class="btn btn-sm btn-secondary">-</button>
                            <span id="quantity-<?php echo $item['cart_id']; ?>"><?php echo $item['quantity']; ?></span>
                            <button onclick="updateQuantity(<?php echo $item['cart_id']; ?>, 1, <?php echo $item['item_price']; ?>, <?php echo $item['item_id']; ?>, '+1')" class="btn btn-sm btn-secondary">+</button>
                        </td>
                        <td id="price-<?php echo $item['cart_id']; ?>"><?php echo $item['item_price'] * $item['quantity']; ?></td>
                        <td><a href="/api/delete-item/<?php echo $item['cart_id'];?>" type="button" class="btn btn-danger">Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">NO ITEMS IN CART</td>
                    </tr>
                <?php endif; ?>
                <tbody id="cart-items"></tbody>
            </table>
            <p id="empty-cart-msg" class="empty-cart-msg" style="display: none;">Your cart is empty!</p>
        </div>

        <div id="total-bill">Total: Rs. <span id="total-amount"><?php echo $total; ?></span></div>

        <a href="#" class="btn btn-success btn-block" onclick="confirmOrder()">Confirm Order</a>
    </div>

    <div id="toast"></div>
</body>

<script>
    async function fetchQuantityLimit(itemId) { 
        try {
            const a = menuItems.find(i => i.id == itemId);
            return a.quantity_limit;
        } catch (error) {
            console.error('Error fetching quantity limit:', error);
            return 0;
        }
    }

    async function updateQuantity(cartId, change, itemPrice, itemId, query){
        const response = await fetch('api/updateItem', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                'itemId': itemId,
                'cartId': cartId,
                'query': query
            }),
        })
        window.location.reload()
    }

    function updateTotalAmount() {
        const priceElements = document.querySelectorAll('[id^="price-"]');
        let total = 0;
        priceElements.forEach(priceElement => {
            total += parseFloat(priceElement.textContent);
        });
        document.getElementById('total-amount').textContent = total;
    }

    async function confirmOrder() {
        const response = await fetch('api/confirmPayment-api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        });

        const data = await response.json();
        if (data.status === true) {
            showToast("Payment Successful!!");
            setTimeout(function() {
                location.reload();
            }, 1000);
        } else {
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
