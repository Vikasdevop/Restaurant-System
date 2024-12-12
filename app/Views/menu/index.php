<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu</title>
<link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">    
<style>
        html, body { 
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
            color: #000000;
        }

        .container {
            margin-top: 40px;
            padding: 5px;
        }

        h3 {
            font-size: 2.5rem;
            text-align: start;
            font-weight: bold;
            color: #ff0000;
            margin-bottom: 10px;
        }

        .inline-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: static; /* Prevent overlap */
            margin-bottom: 20px; /* Space below the header */
            padding: 10px; /* Consistent spacing */
            background-color: white;
        }

        .inline-header a.add-btn,
        .inline-header form,
        .inline-header a.logout-btn {
            display: inline-block;
        }

        .inline-header a.add-btn {
            color: #000;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .add-btn:hover {
            background-color: #000;
            color: #fff;
        }

        .inline-header a.profile img {
            width: 80px;
            height: 80px;
            border-radius: 5%;
            object-fit: cover;
        }

        .inline-header form {
            display: flex;
            gap: 10px;
        }

        .form-label {
            color: black;
        }

        .inline-header select, 
        .inline-header button {
            padding: 5px 5px;
            width: 130px;
            border: 3px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .inline-header button {
            background: #ff0000;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .inline-header a.logout-btn {
            position: static; /* Reset position to avoid overlap */
            margin-left: auto; /* Align to the right */
            color: #000;
            background: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: background 0.3s ease;
        }

        .inline-header a.logout-btn:hover {
            color: #fff;
            background: #000;
        }

        .menu-grid-container {
            margin: 50px auto;
            padding: 50px;
            max-width: 1200px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 40px;
        }

        .menu-item {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 7px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .menu-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .menu-item img {
            border-radius: 5px;
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            margin-bottom: 30px;
        }

        .menu-item-content {
            padding: 10px;
            text-align: center;
        }

        .menu-item-content h5 {
            font-size: 25px;
            font-weight: bold;
            color: #000;
            margin: 0 0 10px;
        }

        .menu-item-content p {
            font-size: 25px;
            color: #555;
            margin-bottom: 15px;
        }

        .menu-item-content .price {
            display: block;
            font-size: 20px;
            color: #ff7a18;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .quantity-input label {
            font-size: 20px;
            font-weight: 500;
            margin-right: 10px;
        }

        .quantity-input {
            display: grid;
            align-items: center;
            gap: 10px;
        }

        .quantity-input label {
            color: black;
        }

        .quantity-input input[type="number"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
        }

        .quantity-input button {
            width: 100%;
            padding: 8px 15px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .quantity-input button:hover {
            background: #555;
        }

        .quantity-input-1 {
            display: flex;
            gap: 5px;
        }

        .menu-item-content .action-btn {
            background-color: #ff0000;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .menu-item-content .action-btn:hover {
            background-color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="inline-header">
            <h3>Menu</h3>
            <a href="<?= site_url('/menu/add') ?>" class="add-btn">+ Add New Item</a>
            <a href="<?= site_url('/menu/profile') ?>" class="profile">
                <img src="<?= base_url('/Restaurant_photo/Profile.jpg')?>" alt="Profile">
            </a>
            <form method="POST" action="<?= site_url('/restaurant/toggle_status'); ?>">
                <?= csrf_field(); ?>
                <input type="hidden" name="restaurant_name" value="<?php echo $restaurant_name; ?>">
                <label for="is_open" class="form-label">Restaurant Status:</label>
                <select name="is_open" id="is_open" class="form-select">
                    <option value="1" <?= $is_open ? 'selected' : ''; ?>>Open</option>
                    <option value="0" <?= !$is_open ? 'selected' : ''; ?>>Closed</option>
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
            <a href="<?= site_url('/logout') ?>" class="logout-btn">Logout</a>
        </header>

        <div class="menu-grid-container">
            <div class="menu-grid">
                <?php if (!empty($currentMenuItems)): ?>
                    <?php foreach ($currentMenuItems as $item): ?>
                        <div class="menu-item">
                            <img src="<?= base_url('uploads/menu_photos/' . esc($item['photo'])) ?>" alt="<?= esc($item['name']) ?>">
                            <div class="menu-item-content">
                                <h5><?= esc($item['name']) ?></h5>
                                <div class="menu-item-details">
                                    <span class="price">₹<?= esc($item['price']) ?></span>
                                </div>
                                <div class="quantity-input">
                                    <form action="<?= base_url('/cart/getItemQuantityLimit') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>"> 
                                        <label for="quantity_limit">Limit:</label>
                                        <div class="quantity-input-1">
                                            <input type="number" name="quantity_limit" id="quantity_limit" min="1" value="<?= $item['quantity_limit'] ?? '' ?>">
                                            <button type="submit">Set</button>
                                        </div>
                                    </form>
                                </div>
                                <div>
                                    <form action="<?= site_url('/menu/delete/' . esc($item['id'])) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="action-btn">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No menu items available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
