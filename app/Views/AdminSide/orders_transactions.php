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
        
        /* Custom IEM order styling */
        .custom-iem-order {
            background-color: #f0f7ff;
            border-left: 3px solid #007bff;
        }
        
        .custom-iem-label {
            color: #007bff;
        }
        
        .category-badge {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
        }
        
        .custom-details-preview {
            margin: 5px 0;
        }
        
        .view-details-btn, .view-full-btn {
            padding: 2px 5px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            margin-top: 5px;
            display: inline-block;
            text-decoration: none;
        }
        
        .view-full-btn {
            background-color: #28a745;
            margin-left: 5px;
        }
        
        .view-details-btn:hover {
            background-color: #0069d9;
        }
        
        .view-full-btn:hover {
            background-color: #218838;
            color: white;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 5px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
        .custom-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .custom-details-table th,
        .custom-details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .custom-details-table th {
            background-color: #f2f2f2;
        }
        
        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #ccc;
            vertical-align: middle;
            margin-right: 5px;
        }
        
        /* Status notification styles */
        .status-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 9999;
            display: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .status-notification.success {
            background-color: #28a745;
        }
        
        .status-notification.error {
            background-color: #dc3545;
        }
        
        /* Status-specific row styling */
        .status-updated {
            animation: highlight 2s;
        }
        
        @keyframes highlight {
            0% { background-color: rgba(255, 255, 0, 0.5); }
            100% { background-color: transparent; }
        }
        
        .status-pending td:nth-child(5) {
            color: #ffc107;
            font-weight: bold;
        }
        
        .status-shipped td:nth-child(5) {
            color: #17a2b8;
            font-weight: bold;
        }
        
        .status-delivered td:nth-child(5) {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-complete td:nth-child(5) {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-cancelled td:nth-child(5) {
            color: #dc3545;
            font-weight: bold;
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            margin-left: 5px;
            animation: spin 1s infinite linear;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

                    <table id="ordersTable">
                        <thead>
                            <tr>
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
                                <tr class="<?= isset($order['is_custom_iem']) && $order['is_custom_iem'] == 1 ? 'custom-iem-order' : '' ?>">
                                    <!--    <td><?= $order['order_id'] ?></td> -->
                                    <td><?= $order['shipping_name'] ?></td>
                                    <td>
                                        <?php if (isset($order['is_custom_iem']) && $order['is_custom_iem'] == 1): ?>
                                            <strong class="custom-iem-label">Custom IEM:</strong> <?= esc($order['product_name']) ?>
                                            
                                            <?php if (isset($order['custom_details'])): ?>
                                                <?php $customDetails = json_decode($order['custom_details'], true); ?>
                                                <?php if (is_array($customDetails)): ?>
                                                    <div class="custom-details-preview">
                                                        <?php if (!empty($customDetails['category'])): ?>
                                                            <span class="category-badge"><?= esc($customDetails['category']) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <button class="view-details-btn" data-details='<?= json_encode($customDetails) ?>'>View Design</button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <strong>Product:</strong> <?= esc($order['product_name'] ?? 'Unknown Product') ?>
                                        <?php endif; ?>
                                        
                                        <a href="<?= base_url('admin/order_details/' . $order['order_id']) ?>" class="view-full-btn">View Details</a>
                                    </td>
                                    <td>₱<?= number_format($order['price'], 2) ?></td>
                                    <td><?= $order['quantity'] ?></td>
                                    <td>
                                        <select class="order-status" data-id="<?= $order['order_id'] ?>">
                                            <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="to ship" <?= $order['order_status'] == 'to ship' ? 'selected' : '' ?>>To Ship</option>
                                            <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="complete" <?= $order['order_status'] == 'complete' ? 'selected' : '' ?>>Complete</option>
                                            <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </td>
                                    <td><?= ucfirst($order['payment_method']) ?></td>
                                    <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                                    <td class="actions">
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
                            function showNotification(message, type) {
                                if ($('#status-notification').length === 0) {
                                    $('body').append('<div id="status-notification" class="status-notification"></div>');
                                }
                                
                                const notification = $('#status-notification');
                                notification.removeClass('success error');
                                notification.addClass(type);
                                notification.text(message);
                                notification.fadeIn();
                                
                                setTimeout(function() {
                                    notification.fadeOut();
                                }, 3000);
                            }
                            
                            $(".order-status").change(function() {
                                var orderId = $(this).data("id");
                                var newStatus = $(this).val();
                                var statusSelect = $(this);
                                var csrfName = "<?= csrf_token() ?>";
                                var csrfHash = "<?= csrf_hash() ?>";
                                
                                statusSelect.prop('disabled', true);
                                statusSelect.after('<span class="loading-spinner">⟳</span>');

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
                                        statusSelect.prop('disabled', false);
                                        statusSelect.next('.loading-spinner').remove();
                                        
                                        if (response.success) {
                                            const row = statusSelect.closest('tr');
                                            row.addClass('status-updated');
                                            setTimeout(function() {
                                                row.removeClass('status-updated');
                                            }, 2000);
                                            
                                            showNotification(response.message, 'success');
                                            
                                            updateRowStyling(row, response.new_status);
                                        } else {
                                            showNotification("Error: " + response.message, 'error');
                                        }
                                    },
                                    error: function(xhr) {
                                        statusSelect.prop('disabled', false);
                                        statusSelect.next('.loading-spinner').remove();
                                        
                                        showNotification("Failed to update order status.", 'error');
                                        console.error(xhr.responseText);
                                    }
                                });
                            });
                            
                            function updateRowStyling(row, status) {
                                row.removeClass('status-pending status-shipped status-delivered status-complete status-cancelled');
                                
                                row.addClass('status-' + status.replace(' ', '-'));
                            }
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

    <div id="customIEMModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Custom IEM Details</h2>
            <div id="customIEMDetails"></div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("customIEMModal");
        const closeBtn = document.getElementsByClassName("close")[0];
        const detailsContainer = document.getElementById("customIEMDetails");

        document.querySelectorAll('.view-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                const detailsJSON = this.getAttribute('data-details');
                const details = JSON.parse(detailsJSON);
                
                let detailsHTML = `
                    <h3>${details.design_name}</h3>
                    <p><strong>Category:</strong> ${details.category}</p>
                    
                    <table class="custom-details-table">
                        <tr>
                            <th>Component</th>
                            <th>Color</th>
                            <th>Material</th>
                        </tr>
                        <tr>
                            <td>Left Shell</td>
                            <td><span class="color-preview" style="background-color: ${details.left_color}"></span>${details.left_color}</td>
                            <td rowspan="4">${details.material}</td>
                        </tr>
                        <tr>
                            <td>Right Shell</td>
                            <td><span class="color-preview" style="background-color: ${details.right_color}"></span>${details.right_color}</td>
                        </tr>
                        <tr>
                            <td>Left Faceplate</td>
                            <td><span class="color-preview" style="background-color: ${details.left_faceplate_color}"></span>${details.left_faceplate_color}</td>
                        </tr>
                        <tr>
                            <td>Right Faceplate</td>
                            <td><span class="color-preview" style="background-color: ${details.right_faceplate_color}"></span>${details.right_faceplate_color}</td>
                        </tr>
                    </table>
                    
                    <p><strong>Size:</strong> ${details.size}</p>
                `;
                
                detailsContainer.innerHTML = detailsHTML;
                modal.style.display = "block";
            });
        });

        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>