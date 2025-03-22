<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=" <?= base_url('assets/css/cart.css') ?>">
    <link rel="stylesheet" href=" <?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href=" <?= base_url('assets/css/footer.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Cart</title>
    <script defer src="<?= base_url('assets/js/script.js') ?>"></script>
    <style>
        .total-checkout {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-size: 18px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .total-checkout:hover {
        background-color: #45a049;
        transform: translateY(-3px); 
    }

    .total-checkout:active {
        background-color: #3e8e41;
        transform: scale(0.95);
    }
    textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
}
input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    </style>
</head>

<body>
    <!-- this includes header.php file on every website that has this code -->
    <!-- @PHP CODE -->
    <?php echo view("includes/header.php"); ?>
    <!-- @PHP CODE -->

    <!-- MAIN CONTENT - USER CART -->
    <div class="cart">
        <div class="title">
            <h2>Cart</h2>
        </div>

        <div class="carts">
            <div class="cart-container">
                <form action="" class="card-block" id="cartForm" method="get">
                    <?php if (isset($cart_items) && !empty($cart_items)) : ?>
                        <?php ?>
                        <?php foreach ($cart_items as $item) : ?>
                            <div class="card">
                                <div class="img-block">
                                    <img src="<?= esc($item['image_url']) ?>" alt="">
                                </div>

                                <div class="card-info">
                                    <div class="card-top">
                                        <h2><?= $item['product_name'] ?></h2>
                                        <p>Quantity: <?= esc($item['quantity']) ?></p>
                                    </div>

                                    <div class="card-bottom">
                                        <a href="<?= base_url('/cart/delete/' . $item['cart_item_id']) ?>">Delete</a>
                                        <p>₱<?= esc(number_format($item['price'], 2)) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-card">
                            <p>Your cart is empty</p>
                            <a href="<?= base_url('/shop') ?>" id="empty" class="empty">Buy now</a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>

            <div class="order-summary">
                <div class="summary">
                    <h2>Summary</h2>

                    <div class="details">
                        <p><span>Total Item</span> <span><?= esc($totalQuantity) ?> item<?= ($totalQuantity !== 1) ? 's' : '' ?></span></p>
                        <p><span>Subtotal</span> <span>₱<?= esc(number_format($totalPrice, 2)) ?></span></p>
                        <p><span>Shipping and Handling</span> <span>₱0.00</span></p>
                    </div>
                </div>

                <div class="total">
                    <p><span>Subtotal</span> <span>₱<?= esc(number_format($totalPrice, 2)) ?></span></p>
                    <form action="<?= base_url('/checkout') ?>" method="post">
                        <input type="hidden" name="total_price" value="<?= esc($totalPrice) ?>">
                        <input type="hidden" name="total_quantity" value="<?= esc($totalQuantity) ?>">

                        <label for="name">Full Name:</label>
                        <input type="text" name="shipping_name" id="name" placeholder="Enter your full name" required>

                        <label for="address">Shipping Address: </label>
                        <textarea name="shipping_address" id="address" rows="3" placeholder="Enter your full address" required></textarea>

                        <button type="submit" class="total-checkout">🛒 Check Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("includes/footer.php"); ?>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.itemCheckbox');
            const deleteBtn = document.getElementById('deleteBtn');

            function toggleDeleteButton() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                deleteBtn.style.display = anyChecked ? 'block' : 'none';
            }

            selectAll.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleDeleteButton();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleDeleteButton);
            });

            deleteBtn.addEventListener('click', function() {
                let selectedItems = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedItems.push(checkbox.value);
                    }
                });

                if (selectedItems.length > 0) {
                    if (confirm('Are you sure you want to delete the selected items?')) {
                        fetch('<?php echo base_url('cart/deleteItems'); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    selected_items: selectedItems
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Items deleted successfully!');
                                    location.reload();
                                } else {
                                    alert('Error deleting items.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                }
            });
        });
    </script>
</body>

</html>