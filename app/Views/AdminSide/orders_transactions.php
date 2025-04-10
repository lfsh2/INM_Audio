<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('Admin/css/orderTransactions.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Admin/css/dashboard1.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= base_url('Admin/css/notifModal.css') ?>">

    <title>Orders | Transactions</title>
    <style>
        * {
            box-sizing: border-box;
        }
        #order_transaction {
            background-color: #d4ebf844;
        }

        aside nav ul #order_transaction span {
            opacity: 1;
        }

        .active {
            background-color: rgb(255, 255, 255);
            color: #fff;
        }
    </style>
</head>

<body>

    <?php echo view('AdminSide/includes/notifModal') ?>
    <?php echo view('AdminSide/includes/sideNav1') ?>

    <section id="content">
        <?php echo view('AdminSide/includes/topNavbar') ?>

        <main class="order-transaction">
            <div class="head-title">
                <div class="left">
                    <h1>Order | Transactions</h1>
                </div>
            </div>

            <div class="admin-table">
                <div class="tabs">
                    <h2>Order Details</h2>


                    <!-- Filters -->
                    <div class="filters">
                        <input type="text" id="searchBox" placeholder="Search orders...">
                        <select id="filterStatus">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <input type="date" id="filterDate">
                        <button onclick="exportCSV()" class="csv">Export CSV</button>
                        <button onclick="exportPDF()" class="pdf">Export PDF</button>
                    </div>

                    <!-- Orders Table -->
                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <!--   <th>Order ID</th> -->
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Date</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <!--    <td><?= $order['order_id'] ?></td> -->
                                    <td><?= $order['shipping_name'] ?></td>
                                    <td><?= $order['product_name'] ?></td>
                                    <td>$<?= number_format($order['price'], 2) ?></td>
                                    <td><?= $order['quantity'] ?></td>
                                    <td>
                                        <select class="order-status" data-id="<?= $order['order_id'] ?>">
                                            <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </td>
                                    <td><?= ucfirst($order['payment_method']) ?></td>
                                    <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                                    <td class="delete">
                                        <button class="delete-btn" data-id="<?= $order['order_id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="<?= base_url('Admin/js/notifModal.js') ?>"></script>
                    <script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>
                    <script>
                        $(document).ready(function() {
                            $(".delete-btn").click(function() {
                                var orderId = $(this).data("id");
                                if (confirm("Are you sure you want to delete this order?")) {
                                    window.location.href = "<?= base_url('admin/delete_order/') ?>" + orderId;
                                }
                            });


                            $("#searchBox").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#ordersTable tbody tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                                });
                            });

                            $("#filterStatus").on("change", function() {
                                var value = $(this).val().toLowerCase();
                                $("#ordersTable tbody tr").each(function() {
                                    var status = $(this).find("td:nth-child(5)").text().toLowerCase();
                                    $(this).toggle(value === "" || status === value);
                                });
                            });

                            $("#filterDate").on("change", function() {
                                var value = $(this).val();
                                $("#ordersTable tbody tr").each(function() {
                                    var date = $(this).find("td:nth-child(7)").text();
                                    $(this).toggle(value === "" || date.startsWith(value));
                                });
                            });
                        });
                    </script>
                    <script>
                        $(document).ready(function() {
                            $(".order-status").change(function() {
                                var orderId = $(this).data("id");
                                var newStatus = $(this).val();
                                var csrfName = "<?= csrf_token() ?>";
                                var csrfHash = "<?= csrf_hash() ?>";

                                $.ajax({
                                    url: "<?= base_url('admin/update_order_status') ?>",
                                    type: "POST",
                                    data: {
                                        order_id: orderId,
                                        order_status: newStatus,
                                        [csrfName]: csrfHash
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.success) {
                                            alert(response.message);
                                            location.reload(); 
                                        } else {
                                            alert("Error: " + response.message);
                                        }
                                    },
                                    error: function(xhr) {
                                        alert("Failed to update order status.");
                                        console.error(xhr.responseText);
                                    }
                                });
                            });
                        });
                    </script>
                    
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const notificationBell = document.getElementById("notificationBell");
			const notificationDropdown = document.getElementById("notificationDropdown");
			const notificationList = document.getElementById("notificationList");
			const notificationCount = document.getElementById("notificationCount");

			function fetchLowStockNotifications() {
				fetch("<?= base_url('/admin/notifications/low-stock') ?>")
					.then(response => response.json())
					.then(data => {
						notificationList.innerHTML = "";
						let count = data.length;

						if (count > 0) {
							notificationCount.textContent = count;
							notificationCount.style.display = "inline-block";
							data.forEach(item => {
								notificationList.innerHTML += `
									<li>
										⚠️ <b>${item.product_name}</b> is low on stock: ${item.stock_quantity} left!
									</li>`;
							});
						} else {
							notificationCount.style.display = "none";
							notificationList.innerHTML = `<li>No stock alerts</li>`;
						}
					});
			}

			notificationBell.addEventListener("click", () => {
				notificationDropdown.classList.toggle("hidden");
			});

			fetchLowStockNotifications();
			setInterval(fetchLowStockNotifications, 60000);
		});
	</script>

</body>

</html>