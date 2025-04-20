<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/grid.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .orders-container {
            /* max-width: 1000px; */
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .tab-container {
            display: flex;
            justify-content: space-around;
            border-bottom: 2px solid #ddd;
            margin-bottom: 15px;
            margin-top: 20px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .tab.active {
            border-bottom: 3px solid #007BFF;
            color: #007BFF;
        }
     
        .items {
            width: 100%;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 20px;

            .item-card {
                width: 70%;
                margin: auto;
                padding: 10px 20px;
                border-radius: 10px;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            }

            .item {
                width: 100%;
                margin: 10px 0;
            }

            .ihead {
                padding: 10px 0;
                display: flex;
                justify-content: space-between;

                .shop-name {
                    font-weight: bold;
                }
            }

            .ibody {
                .container {
                    width: 100%;
                    padding: 10px 0;
                    display: flex;
                    justify-content: space-between;
                    align-content: start;
                    gap: 20px;
                }
                
                img {
                    height: 150px;
                    border: 1px solid red;
                    object-fit: contain;
                    aspect-ratio: 1/1;
                }

                .block {
                    flex-grow: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }

                .group {
                    width: 100%;
                    margin-top: 5px;
                    display: flex;
                    justify-content: space-between;
                    color: #acacac;
                }

                .price, .total {
                    margin-top: 5px;
                    text-align: right;
                }
            }
            .ibottom {
                display: flex;
                justify-content: end;
                button {
                    padding: 10px;
                    border: 1px solid red;
                    border-radius: 5px;
                    background: none;
                    color: red;
                    cursor: pointer;
                }
            }
        }
    </style>
</head>
<body>

<?php echo view("includes/header.php"); ?>
<div class="user-likes user-main-content">

<?php echo view("UserSide/sideNav"); ?>


<div class="orders-container">
    <h2 style="text-align:center;">Manage Orders</h2>

    <div class="tab-container">
        <div class="tab active" data-status="pending">Pending</div>
        <div class="tab" data-status="shipped">Shipped</div>
        <div class="tab" data-status="delivered">Delivered</div>
        <div class="tab" data-status="cancelled">Cancelled</div>
    </div>

    <div id="orders-table">
        <?php
            $status = 'pending';
            $filteredOrders = array_filter($orders, fn($order) => $order['order_status'] === $status);
            include 'orders_partial.php';
        ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.tab').click(function() {
        $('.tab').removeClass('active');
        $(this).addClass('active');
        const status = $(this).data('status');
        
        $('#orders-table').html('<div class="loading">Loading orders...</div>');
        
        $.ajax({
            url: "<?= base_url('/user/fetchOrders') ?>",
            method: "POST",
            data: { order_status: status },
            success: function(response) {
                $('#orders-table').html(response);
            },
            error: function() {
                $('#orders-table').html('<div class="error">Failed to load orders. Please try again.</div>');
            }
        });
    });

    $(document).on("click", ".cancel-btn", function() {
        const orderId = $(this).data("order-id");
        if (confirm("Are you sure you want to cancel this order?")) {
            $.post("<?= base_url('/user/cancelOrder') ?>", 
                { order_id: orderId }, 
                function(response) {
                    alert(response.message);
                    // Refresh current tab content
                    $('.tab.active').click();
                }, 
                "json"
            ).fail(function() {
                alert("Failed to cancel order. Please try again.");
            });
        }
    });
});
</script>

</body>
</html>
