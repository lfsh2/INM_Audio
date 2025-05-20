<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/grid.css') ?>">
    <link rel="shortcut icon" href="<?= base_url(relativePath: 'assets/img/logo.png') ?>" type="image/x-icon"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .orders-container {
            .tab-container {
                display: flex;
                justify-content: space-around;
                border-bottom: 2px solid #ddd;
                overflow: auto !important;
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
         
            #orders-table {
                height: 100% !important;
                overflow: auto !important;
            }

            .items {
                width: 100%;
                height: 100%;
                padding: 20px;
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
                        width: 150px;
                        height: 150px;
                        object-fit: cover;
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
                    padding: 10px 0;
                    display: flex;
                    justify-content: end;
                    button {
                        padding: 10px;
                        border: 1px solid red;
                        border-radius: 5px;
                        background: none;
                        color: red;
                        cursor: pointer;
                        transition: all 300ms;
                    }

                    button:hover {
                        background: red;
                        color: white;
                    }
                }
            }

            .no-orders {
                text-align: center;
                padding: 30px;
                background-color: #f9f9f9;
                border-radius: 8px;
                margin: 20px 0;
                color: #666;
            }

            .container img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 4px;
                background-color: #f0f0f0;
            }

            @media (max-width: 992px) {
                #orders-table, .items {
                    padding: 10px;
                }

                .item-card {
                    width: 100% !important;
                }

                .ibody {
                    .container {
                        flex-wrap: wrap;
                    }

                    img {
                        width: 100% !important;
                    }
                }

                .container img {
                    width: 100%;
                    height: 150px;
                }
            }
        }
    </style>
</head>
<body>
    <?php echo view("includes/header.php"); ?>

    <div class="user-likes user-main-content">
        <?php echo view(name: "UserSide/sideNav"); ?>

        <div class="orders-container user-content">
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
