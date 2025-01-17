<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Roboto', sans-serif;
      padding: 20px;
      color: #333;
    }

    .container {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    h1 {
      font-size: 1.8rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    .table {
      margin-bottom: 20px;
      text-align: center;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      vertical-align: middle;
      font-size: 1rem;
      padding: 12px;
      border: 1px solid #ddd;
    }

    .table th {
      background-color: #fff;
      color: #000;
      font-weight: bold;
      text-transform: uppercase;
      font-weight: 500;
    }

    .table td {
      color: #555;
    }

    .table .btn {
      font-size: 0.9rem;
      padding: 6px 12px;
      border-radius: 4px;
    }

    .btn-danger {
      background-color: #e74c3c;
      border: none;
      color: #fff;
    }

    .btn-danger:hover {
      background-color: #c0392b;
    }

    .btn-success {
      background-color: #27ae60;
      border: none;
      color: #fff;
    }

    .btn-success:hover {
      background-color: #218c52;
    }

    #total-bill {
      font-size: 1.4rem;
      font-weight: bold;
      text-align: right;
      color: #333;
      margin-top: 20px;
    }

    #toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #333;
      color: white;
      padding: 10px 20px;
      border-radius: 4px;
      display: none;
      z-index: 1050;
    }
  </style>
</head>

<body>
  <div class="container">
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
        <?php if (!empty($cartItems)): ?>
          <?php foreach ($cartItems as $item): ?>
            <tr id="item-row-<?php echo $item['cart_id']; ?>">
              <td><?php echo $item['item_name']; ?></td>
              <td>
                <button
                  onclick="updateQuantity(<?php echo $item['cart_id']; ?>, -1, <?php echo $item['item_price']; ?>, <?php echo $item['item_id']; ?>, '-1')"
                  class="btn btn-sm btn-secondary">-</button>
                <span id="quantity-<?php echo $item['cart_id']; ?>"><?php echo $item['quantity']; ?></span>
                <button
                  onclick="updateQuantity(<?php echo $item['cart_id']; ?>, 1, <?php echo $item['item_price']; ?>, <?php echo $item['item_id']; ?>, '+1')"
                  class="btn btn-sm btn-secondary">+</button>
              </td>
              <td id="price-<?php echo $item['cart_id']; ?>"><?php echo $item['item_price'] * $item['quantity']; ?></td>
              <td><a href="/api/delete-item/<?php echo $item['cart_id']; ?>" type="button" class="btn btn-danger">Delete</a>
              </td>
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

  async function updateQuantity(cartId, change, itemPrice, itemId, query) {
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
      setTimeout(function () {
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

    setTimeout(function () {
      toast.style.visibility = "hidden";
    }, 3000);
  }
</script>

</html>