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
                    <?php foreach ($cart_items as $item) : ?>
                        <div class="card">
                            <input type="checkbox" class="itemCheckbox" name="selected_items[]" value="<?= esc($item['cart_item_id']) ?>">
                            <div class="img-block">
                                <img src="<?= esc($item['image_url']) ?>" alt="">
                            </div>

                            <div class="card-info">
                                <div class="card-top">
                                    <h2><?= esc($item['product_name']) ?></h2>
                                    <p>Quantity: <?= esc($item['quantity']) ?></p>
                                </div>

                                <div class="card-bottom">
                                    <a href="<?= base_url('/cart/delete/' . $item['cart_item_id']) ?>">Delete</a>
                                    <p>₱<?= esc(number_format($item['price'], 2)) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

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
                    <form id="checkoutForm" action="<?= base_url('/checkout') ?>" method="post">
                        <input type="hidden" name="total_price" id="totalPrice" value="<?= esc($totalPrice) ?>">
                        <input type="hidden" name="total_quantity" id="totalQuantity" value="<?= esc($totalQuantity) ?>">
                        <div id="selectedItemsContainer"></div> 

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
    document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".itemCheckbox");
    const totalItemsSpan = document.querySelector(".details span:nth-child(2)");
    const subtotalSpan = document.querySelector(".details span:last-child");
    const totalPriceSpan = document.querySelector(".total p span:last-child");
    const totalQuantityInput = document.getElementById("totalQuantity");
    const totalPriceInput = document.getElementById("totalPrice");
    const checkoutForm = document.getElementById("checkoutForm");
    const selectedItemsContainer = document.getElementById("selectedItemsContainer");

    function updateSummary() {
        let totalItems = 0;
        let totalPrice = 0;

        selectedItemsContainer.innerHTML = "";

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                let card = checkbox.closest(".card");
                let price = parseFloat(card.querySelector(".card-bottom p").textContent.replace("₱", "").replace(",", ""));
                let quantity = parseInt(card.querySelector(".card-top p").textContent.replace("Quantity: ", ""));

                totalItems += quantity;
                totalPrice += price;

                let hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "selected_items[]";
                hiddenInput.value = checkbox.value;
                selectedItemsContainer.appendChild(hiddenInput);
            }
        });

        totalItemsSpan.textContent = `${totalItems} item${totalItems !== 1 ? "s" : ""}`;
        subtotalSpan.textContent = `₱${totalPrice.toFixed(2)}`;
        totalPriceSpan.textContent = `₱${totalPrice.toFixed(2)}`;

        totalQuantityInput.value = totalItems;
        totalPriceInput.value = totalPrice;
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateSummary);
    });

    checkoutForm.addEventListener("submit", function (e) {
        let selectedItems = document.querySelectorAll('input[name="selected_items[]"]');
        if (selectedItems.length === 0) {
            alert("Please select at least one item to checkout.");
            e.preventDefault();
        }
    });

    updateSummary();
});

</script>


</body>

</html>