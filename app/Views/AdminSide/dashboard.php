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
</body>

</html>