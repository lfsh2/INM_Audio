<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="<?= base_url('Admin/css/dashboard1.css') ?>">
	<link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
	<title>Dashboard</title>
	<style>
		.chart-container {
			display: flex;
			gap: 20px;
			width: 100%;
		}

		.chart-item {
			flex: 1;
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			padding: 20px;
		}

		.chart-item canvas {
			width: 100% !important;
			height: 300px !important;
		}

		.status.delivered {
			background-color: #4CAF50;
			color: white;
		}

		.status.pending {
			background-color: #FFC107;
			color: black;
		}

		.status.cancelled {
			background-color: #F44336;
			color: white;
		}

		.status.shipped {
			background-color: #2196F3;
			color: white;
		}

		/* Custom IEM Stats Styling */
		.order-type-stats {
			margin-bottom: 20px;
		}

		.stats-container {
			display: flex;
			gap: 20px;
			width: 100%;
		}

		.stats-card {
			flex: 1;
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			padding: 20px;
			transition: transform 0.3s ease;
		}

		.stats-card:hover {
			transform: translateY(-5px);
		}

		.stats-card.custom-iem {
			border-left: 5px solid #9c27b0;
		}

		.stats-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 15px;
			border-bottom: 1px solid #eee;
			padding-bottom: 10px;
		}

		.stats-header h3 {
			margin: 0;
			color: #333;
			font-size: 18px;
		}

		.stats-header i {
			font-size: 24px;
			color: #3C91E6;
		}

		.stats-card.custom-iem .stats-header i {
			color: #9c27b0;
		}

		.stats-body {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 15px;
		}

		.stat-item {
			display: flex;
			flex-direction: column;
		}

		.stat-label {
			font-size: 14px;
			color: #666;
			margin-bottom: 5px;
		}

		.stat-value {
			font-size: 18px;
			font-weight: bold;
			color: #333;
		}
	</style>
</head>

<body>

	<!-- SIDEBAR -->
	<?php echo view('AdminSide/includes/sideNav1') ?>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<?php echo view('AdminSide/includes/topNavbar') ?>

		<!-- MAIN -->
		<main class="dashboard">
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb"></ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download'></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3><?= $totalConfirmed ?? 0; ?></h3>
						<p>Confirmed Orders</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3><?= $totalOrders ?? 0; ?></h3>
						<p>Total Orders</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle'></i>
					<span class="text">
						<h3><?= ($totalRevenue > 0) ? "₱" . number_format($totalRevenue, 2) : "₱0"; ?></h3>
						<p>Total Sales</p>
					</span>
				</li>
			</ul>

			<!-- CUSTOM IEM STATS -->
			<div class="order-type-stats">
				<div class="stats-container">
					<div class="stats-card">
						<div class="stats-header">
							<h3>Regular Products</h3>
							<i class='bx bxs-package'></i>
						</div>
						<div class="stats-body">
							<div class="stat-item">
								<span class="stat-label">Orders:</span>
								<span class="stat-value"><?= $totalRegularOrders ?? 0; ?></span>
							</div>
							<div class="stat-item">
								<span class="stat-label">Revenue:</span>
								<span class="stat-value"><?= ($totalRegularRevenue > 0) ? "₱" . number_format($totalRegularRevenue, 2) : "₱0"; ?></span>
							</div>
						</div>
					</div>

					<div class="stats-card custom-iem">
						<div class="stats-header">
							<h3>Custom IEMs</h3>
							<i class='bx bxs-earbuds'></i>
						</div>
						<div class="stats-body">
							<div class="stat-item">
								<span class="stat-label">Orders:</span>
								<span class="stat-value"><?= $totalCustomOrders ?? 0; ?></span>
							</div>
							<div class="stat-item">
								<span class="stat-label">Revenue:</span>
								<span class="stat-value"><?= ($totalCustomRevenue > 0) ? "₱" . number_format($totalCustomRevenue, 2) : "₱0"; ?></span>
							</div>
							<div class="stat-item">
								<span class="stat-label">Pending:</span>
								<span class="stat-value"><?= $customStats['pending_custom'] ?? 0; ?></span>
							</div>
							<div class="stat-item">
								<span class="stat-label">Completed:</span>
								<span class="stat-value"><?= $customStats['completed_custom'] ?? 0; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- CHARTS -->
			<div class="table-data chart">
				<div class="chart-container">
					<div class="chart-item">
						<h5>Revenue Report</h5>
						<select id="timeframeSelect">
							<option value="yearly">Yearly</option>
							<option value="monthly">Monthly</option>
							<option value="weekly">Weekly</option>
						</select>
						<canvas id="yearlyRevenueChart"></canvas>
					</div>

					<div class="chart-item">
						<h5>Order Status Breakdown</h5>
						<canvas id="orderStatusChart"></canvas>
					</div>
				</div>
			</div>

			<!-- RECENT ORDERS -->
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Order No.</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Product</th>
								<th>Quantity</th>
								<th>Total Price</th>
								<th>Payment Type</th>
								<th>Order Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody id="recentOrdersTable">
							<tr>
								<td colspan="9" style="color: gray;">Loading recent orders...</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</main>
	</section>

	<script src="<?= base_url('Admin/js/notifModal.js') ?>"></script>
	<script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			let revenueChart, orderStatusChart;

			function fetchRevenueData(timeframe = 'yearly') {
				fetch(`<?= base_url('/admin/chart-data/revenue') ?>?timeframe=${timeframe}`)
					.then(response => response.json())
					.then(data => {
						const ctx = document.getElementById('yearlyRevenueChart').getContext('2d');

						if (revenueChart) revenueChart.destroy();

						revenueChart = new Chart(ctx, {
							type: 'line',
							data: {
								labels: data.labels,
								datasets: [{
									label: `${timeframe.charAt(0).toUpperCase() + timeframe.slice(1)} Revenue`,
									data: data.values,
									backgroundColor: 'rgba(54, 162, 235, 0.2)',
									borderColor: '#4CAF50',
									borderWidth: 3
								}]
							}
						});
					});
			}

			function fetchOrderStatusData() {
				fetch("<?= base_url('/admin/chart-data/order-status') ?>")
					.then(response => response.json())
					.then(data => {
						const ctx = document.getElementById('orderStatusChart').getContext('2d');

						if (orderStatusChart) orderStatusChart.destroy();

						orderStatusChart = new Chart(ctx, {
							type: 'doughnut',
							data: {
								labels: data.labels,
								datasets: [{
									data: data.values,
									backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
								}]
							}
						});
					});
			}

			function fetchRecentOrders() {
				fetch("<?= base_url('/admin/chart-data/recent-orders') ?>")
					.then(response => response.json())
					.then(data => {
						const tbody = document.getElementById("recentOrdersTable");
						tbody.innerHTML = "";

						if (data.length > 0) {
							data.forEach(order => {
								let statusClass = '';
								switch (order.order_status.toLowerCase()) {
									case 'delivered':
										statusClass = 'delivered';
										break;
									case 'pending':
										statusClass = 'pending';
										break;
									case 'cancelled':
										statusClass = 'cancelled';
										break;
									case 'shipped':
										statusClass = 'shipped';
										break;
									default:
										statusClass = 'pending';
								}

								tbody.innerHTML += `
                        <tr>
                            <td>${order.order_id}</td>
                            <td>${order.shipping_name}</td>
                            <td>${order.shipping_phone}</td>
                            <td>
                                <img src="${order.image_url}" alt="Product Image" width="50">
                                <p>${order.product_name}</p>
                            </td>
                            <td>${order.quantity}</td>
                            <td>₱${parseFloat(order.price * order.quantity).toFixed(2)}</td>
                            <td>${order.payment_method}</td>
                            <td>${order.created_at}</td>
                            <td>
                                <span class="status ${statusClass}">${order.order_status}</span>
                            </td>
                        </tr>
                    `;
							});
						} else {
							tbody.innerHTML = `<tr><td colspan="9" style="color: gray;">No recent orders!</td></tr>`;
						}
					});
			}


			fetchRevenueData();
			fetchOrderStatusData();
			fetchRecentOrders();
			setInterval(fetchRecentOrders, 10000);
			document.getElementById('timeframeSelect').addEventListener('change', function() {
				fetchRevenueData(this.value);
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
	<script>
		document.addEventListener("DOMContentLoaded", function() {
    const downloadBtn = document.querySelector('.btn-download');
    downloadBtn.addEventListener('click', function(e) {
        e.preventDefault(); 

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(20);
        doc.text('Dashboard Report', 20, 20);

        doc.setFontSize(16);
        doc.text('Confirmed Orders: <?= $totalConfirmed ?? 0; ?>', 20, 30);
        doc.text('Total Orders: <?= $totalOrders ?? 0; ?>', 20, 40);
        doc.text('Total Sales: ₱<?= number_format($totalRevenue ?? 0, 2); ?>', 20, 50);

        const revenueChart = document.getElementById('yearlyRevenueChart');
        const orderStatusChart = document.getElementById('orderStatusChart');
        
        doc.addImage(revenueChart.toDataURL('image/png'), 'PNG', 20, 60, 160, 90); 
        doc.addImage(orderStatusChart.toDataURL('image/png'), 'PNG', 20, 160, 160, 90);

        doc.save('dashboard-report.pdf');
    });
});

	</script>

</body>

</html>