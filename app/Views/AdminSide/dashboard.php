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
		/* Download button styles */
		.btn-download {
			position: relative;
		}
		
		.download-status {
			position: absolute;
			top: 100%;
			right: 0;
			font-size: 12px;
			white-space: nowrap;
			padding: 3px 8px;
			border-radius: 3px;
			display: none;
		}
		
		.download-status.success {
			background-color: #4CAF50;
			color: white;
			display: block;
		}
		
		.download-status.error {
			background-color: #F44336;
			color: white;
			display: block;
		}
		
		.dashboard-charts {
			margin-bottom: 24px;
		}
		
		.chart-container {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
			gap: 24px;
			width: 100%;
		}

		.chart-item {
			background: #fff;
			border-radius: 20px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
			padding: 20px;
			transition: all 0.3s ease;
		}
		
		.chart-item:hover {
			transform: translateY(-3px);
			box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
		}

		.chart-item canvas {
			width: 100% !important;
			height: 300px !important;
		}
		
		.chart-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}
		
		.chart-header h5 {
			font-size: 16px;
			font-weight: 600;
			color: #333;
			margin: 0;
		}
		
		.chart-controls select {
			padding: 6px 12px;
			border-radius: 8px;
			border: 1px solid #e0e0e0;
			background: #fff;
			color: #333;
			font-size: 13px;
		}
		
		.chart-body {
			position: relative;
			height: 300px;
			width: 100%;
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
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
			gap: 20px;
		}

		.stats-container {
			width: 100%;
		}

		.stats-card {
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
		
		.stats-card.ready-made-iem {
			border-left: 5px solid #3C91E6;
		}
		
		.stats-card.accessories {
			border-left: 5px solid #FFC107;
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
		
		.stats-card.ready-made-iem .stats-header i {
			color: #3C91E6;
		}
		
		.stats-card.accessories .stats-header i {
			color: #FFC107;
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
		
		/* Dashboard KPI Cards */
		.kpi-cards {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
			gap: 20px;
			margin-bottom: 24px;
		}
		
		.kpi-card {
			background: #fff;
			border-radius: 15px;
			padding: 20px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			display: flex;
			align-items: center;
			transition: all 0.3s ease;
		}
		
		.kpi-card:hover {
			transform: translateY(-5px);
		}
		
		.kpi-icon {
			width: 60px;
			height: 60px;
			border-radius: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-right: 15px;
			font-size: 28px;
		}
		
		.kpi-content {
			flex: 1;
		}
		
		.kpi-label {
			font-size: 14px;
			color: #666;
			margin-bottom: 5px;
		}
		
		.kpi-value {
			font-size: 22px;
			font-weight: bold;
			color: #333;
			margin-bottom: 5px;
		}
		
		.kpi-trend {
			display: flex;
			align-items: center;
			font-size: 13px;
		}
		
		.trend-up {
			color: #4CAF50;
		}
		
		.trend-down {
			color: #F44336;
		}
		
		/* Custom IEM Details Card */
		.customization-details {
			margin-top: 24px;
		}
		
		.customization-card {
			background: #fff;
			border-radius: 15px;
			padding: 20px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		}
		
		.customization-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
			border-bottom: 1px solid #eee;
			padding-bottom: 15px;
		}
		
		.customization-header h3 {
			font-size: 20px;
			margin: 0;
			color: #333;
		}
		
		.customization-body {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
			gap: 20px;
		}
		
		.customization-chart-container {
			min-height: 300px;
		}
		
		.customization-stats-container {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 15px;
		}
		
		.customization-stat-item {
			background: #f8f9fa;
			border-radius: 10px;
			padding: 15px;
		}
		
		.customization-table-container {
			margin-top: 20px;
			overflow-x: auto;
		}
		
		.customization-table {
			width: 100%;
			border-collapse: collapse;
		}
		
		.customization-table th,
		.customization-table td {
			padding: 12px 15px;
			text-align: left;
			border-bottom: 1px solid #eee;
		}
		
		.customization-table th {
			background: #f5f5f5;
			font-weight: 600;
		}
		
		.customization-badge {
			display: inline-block;
			padding: 4px 8px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 500;
		}
		
		.badge-shell {
			background-color: #E1F5FE;
			color: #0288D1;
		}
		
		.badge-driver {
			background-color: #FFF8E1;
			color: #FFA000;
		}
		
		.badge-tuning {
			background-color: #E8F5E9;
			color: #388E3C;
		}
		
		/* Recent Orders Styling */
		.recent-orders-section {
			background: #fff;
			border-radius: 20px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
			padding: 20px;
			margin-bottom: 24px;
		}
		
		.section-header {
			margin-bottom: 20px;
		}
		
		.section-header h3 {
			font-size: 18px;
			font-weight: 600;
			color: #333;
			margin: 0;
		}
		
		.orders-table-container {
			overflow-x: auto;
		}
		
		.orders-table {
			width: 100%;
			border-collapse: separate;
			border-spacing: 0;
		}
		
		.orders-table th {
			background-color: #f9f9f9;
			color: #333;
			font-weight: 600;
			text-align: left;
			padding: 15px;
			border-bottom: 1px solid #eee;
			font-size: 14px;
		}
		
		.orders-table td {
			padding: 15px;
			border-bottom: 1px solid #eee;
			color: #333;
			font-size: 14px;
		}
		
		.orders-table tbody tr:hover {
			background-color: #f5f5f5;
		}
		
		.orders-table .status {
			padding: 6px 12px;
			border-radius: 50px;
			font-size: 12px;
			font-weight: 500;
			text-align: center;
			display: inline-block;
			min-width: 85px;
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
					<ul class="breadcrumb">
						<li><a href="#">Admin</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Dashboard</a></li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download'></i>
					<span class="text">Download Report</span>
					<span class="download-status"></span>
				</a>
			</div>
			
			<!-- Enhanced KPI Cards -->
			<div class="kpi-cards">
				<div class="kpi-card">
					<div class="kpi-icon" style="background: rgba(60, 145, 230, 0.1); color: #3C91E6;">
						<i class='bx bxs-calendar-check'></i>
					</div>
					<div class="kpi-content">
						<div class="kpi-label">Confirmed Orders</div>
						<div class="kpi-value"><?= $totalConfirmed ?? 0; ?></div>
						<div class="kpi-trend trend-up">
							<i class='bx bx-up-arrow-alt'></i> 12% from last month
						</div>
					</div>
				</div>
				
				<div class="kpi-card">
					<div class="kpi-icon" style="background: rgba(156, 39, 176, 0.1); color: #9c27b0;">
						<i class='bx bxs-group'></i>
					</div>
					<div class="kpi-content">
						<div class="kpi-label">Total Orders</div>
						<div class="kpi-value"><?= $totalOrders ?? 0; ?></div>
						<div class="kpi-trend trend-up">
							<i class='bx bx-up-arrow-alt'></i> 8% from last month
						</div>
					</div>
				</div>
				
				<div class="kpi-card">
					<div class="kpi-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
						<i class='bx bxs-dollar-circle'></i>
					</div>
					<div class="kpi-content">
						<div class="kpi-label">Total Sales</div>
						<div class="kpi-value"><?= ($totalRevenue > 0) ? "₱" . number_format($totalRevenue, 2) : "₱0"; ?></div>
						<div class="kpi-trend trend-up">
							<i class='bx bx-up-arrow-alt'></i> 15% from last month
						</div>
					</div>
				</div>
				
				<div class="kpi-card">
					<div class="kpi-icon" style="background: rgba(255, 193, 7, 0.1); color: #FFC107;">
						<i class='bx bxs-user-check'></i>
					</div>
					<div class="kpi-content">
						<div class="kpi-label">Customer Retention</div>
						<div class="kpi-value">87.5%</div>
						<div class="kpi-trend trend-up">
							<i class='bx bx-up-arrow-alt'></i> 3% from last month
						</div>
					</div>
				</div>
			</div>

			<!-- PRODUCT CATEGORY STATS -->
			<div class="order-type-stats">
				<div class="stats-container">
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

			<div class="dashboard-charts">
				<div class="chart-container">
					<div class="chart-item">
						<div class="chart-header">
							<h5>Revenue Report</h5>
							<div class="chart-controls">
								<select id="timeframeSelect" class="form-control">
									<option value="yearly">Yearly</option>
									<option value="monthly" selected>Monthly</option>
									<option value="weekly">Weekly</option>
								</select>
							</div>
						</div>
						<div class="chart-body">
							<canvas id="yearlyRevenueChart"></canvas>
						</div>
					</div>

					<div class="chart-item">
						<div class="chart-header">
							<h5>Order Status Breakdown</h5>
							<div class="chart-controls">
								<select id="orderStatusPeriod" class="form-control">
									<option value="all">All Time</option>
									<option value="month" selected>This Month</option>
									<option value="quarter">This Quarter</option>
								</select>
							</div>
						</div>
						<div class="chart-body">
							<canvas id="orderStatusChart"></canvas>
						</div>
					</div>
				</div>
			</div>

			<!-- RECENT ORDERS -->
			<div class="recent-orders-section">
				<div class="section-header">
					<h3>Recent Orders</h3>
				</div>
				<div class="orders-table-container">
					<table class="orders-table">
						<thead>
							<tr>
								<th>Order No.</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Quantity</th>
								<th>Total Price</th>
								<th>Payment Type</th>
								<th>Order Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody id="recentOrdersTable">
							<tr>
								<td colspan="8" style="color: gray; text-align: center; padding: 15px;">Loading recent orders...</td>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

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
									backgroundColor: 'rgba(76, 175, 80, 0.2)',
									borderColor: '#4CAF50',
									borderWidth: 2,
									pointBackgroundColor: '#4CAF50',
									pointRadius: 4,
									pointHoverRadius: 6,
									tension: 0.1,
									fill: true
								}]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								scales: {
									y: {
										beginAtZero: false,
										grid: {
											color: 'rgba(0, 0, 0, 0.05)'
										},
										ticks: {
											callback: function(value) {
												return '₱' + value.toLocaleString();
											}
										}
									},
									x: {
										grid: {
											display: false
										}
									}
								},
								plugins: {
									legend: {
										display: true,
										position: 'top',
										labels: {
											boxWidth: 12,
											usePointStyle: true,
											pointStyle: 'circle'
										}
									},
									tooltip: {
										backgroundColor: 'rgba(255, 255, 255, 0.8)',
										titleColor: '#333',
										bodyColor: '#333',
										borderColor: '#ddd',
										borderWidth: 1,
										callbacks: {
											label: function(context) {
												return '₱' + context.parsed.y.toLocaleString();
											}
										}
									}
								}
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
									backgroundColor: ['#4CAF50', '#FFC107', '#F44336', '#2196F3'],
									borderWidth: 0,
									hoverOffset: 5
								}]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								plugins: {
									legend: {
										position: 'right',
										labels: {
											padding: 20,
											boxWidth: 12,
											color: '#333',
											font: {
												size: 12
											}
										}
									},
									tooltip: {
										backgroundColor: 'rgba(255, 255, 255, 0.8)',
										titleColor: '#333',
										bodyColor: '#333',
										borderColor: '#ddd',
										borderWidth: 1,
										callbacks: {
											label: function(context) {
												const label = context.label || '';
												const value = context.parsed;
												const total = context.dataset.data.reduce((a, b) => a + b, 0);
												const percentage = Math.round((value / total) * 100);
												return `${label}: ${percentage}%`;
											}
										}
									}
								},
								cutout: '70%'
							}
						});
					});
			}
			
			// Create mock order status function for better demonstration
			function fetchOrderStatusDataDemo() {
				// This is mock data to match the screenshot
				const mockData = {
					labels: ['Completed', 'Pending', 'Shipped', 'Cancelled'],
					values: [35, 40, 25, 0] // Percentages as shown in the screenshot
				};
				
				const ctx = document.getElementById('orderStatusChart').getContext('2d');
				
				if (orderStatusChart) orderStatusChart.destroy();
				
				orderStatusChart = new Chart(ctx, {
					type: 'doughnut',
					data: {
						labels: mockData.labels,
						datasets: [{
							data: mockData.values,
							backgroundColor: ['#4CAF50', '#FFC107', '#F44336', '#2196F3'],
							borderWidth: 0,
							hoverOffset: 5
						}]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						plugins: {
							legend: {
								position: 'right',
								labels: {
									padding: 20,
									boxWidth: 12,
									color: '#333',
									font: {
										size: 12
									}
								}
							},
							tooltip: {
								backgroundColor: 'rgba(255, 255, 255, 0.8)',
								titleColor: '#333',
								bodyColor: '#333',
								borderColor: '#ddd',
								borderWidth: 1,
								callbacks: {
									label: function(context) {
										const label = context.label || '';
										const value = context.parsed;
										const total = context.dataset.data.reduce((a, b) => a + b, 0);
										const percentage = Math.round((value / total) * 100);
										return `${label}: ${percentage}%`;
									}
								}
							}
						},
						cutout: '70%'
					}
				});
			}
			
			// Function to fetch and render Custom IEM type chart
			function fetchCustomizationData() {
				// In a real environment, you would fetch this from an endpoint
				// For now, we'll use sample data
				const customizationData = {
					labels: ['Shell Type', 'Driver Config', 'Tuning Preference', 'Cable Type'],
					datasets: [
						{
							label: 'Standard Acrylic',
							backgroundColor: 'rgba(156, 39, 176, 0.7)',
							data: [42, 0, 0, 0]
						},
						{
							label: 'Premium Acrylic',
							backgroundColor: 'rgba(156, 39, 176, 0.5)',
							data: [30, 0, 0, 0]
						},
						{
							label: 'Titanium',
							backgroundColor: 'rgba(156, 39, 176, 0.3)',
							data: [28, 0, 0, 0]
						},
						{
							label: 'Single Driver',
							backgroundColor: 'rgba(60, 145, 230, 0.7)',
							data: [0, 25, 0, 0]
						},
						{
							label: 'Dual Driver',
							backgroundColor: 'rgba(60, 145, 230, 0.5)',
							data: [0, 38, 0, 0]
						},
						{
							label: 'Triple/Quad',
							backgroundColor: 'rgba(60, 145, 230, 0.3)',
							data: [0, 37, 0, 0]
						},
						{
							label: 'Neutral',
							backgroundColor: 'rgba(76, 175, 80, 0.7)',
							data: [0, 0, 28, 0]
						},
						{
							label: 'Neutral with Bass',
							backgroundColor: 'rgba(76, 175, 80, 0.5)',
							data: [0, 0, 45, 0]
						},
						{
							label: 'V-shaped',
							backgroundColor: 'rgba(76, 175, 80, 0.3)',
							data: [0, 0, 27, 0]
						},
						{
							label: 'Standard',
							backgroundColor: 'rgba(255, 193, 7, 0.7)',
							data: [0, 0, 0, 55]
						},
						{
							label: 'Premium',
							backgroundColor: 'rgba(255, 193, 7, 0.5)',
							data: [0, 0, 0, 45]
						}
					]
				};
				
				const ctx = document.getElementById('customizationTypeChart').getContext('2d');
				
				new Chart(ctx, {
					type: 'bar',
					data: customizationData,
					options: {
						indexAxis: 'y',
						plugins: {
							title: {
								display: true,
								text: 'Custom IEM Preferences'
							},
							tooltip: {
								callbacks: {
									label: function(context) {
										const label = context.dataset.label || '';
										const value = context.raw || 0;
										return `${label}: ${value}%`;
									}
								}
							}
						},
						responsive: true,
						scales: {
							x: {
								stacked: true,
								max: 100,
								title: {
									display: true,
									text: 'Percentage'
								}
							},
							y: {
								stacked: true
							}
						}
					}
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
			// Use the demo data for the screenshot match
			fetchOrderStatusDataDemo();
			fetchRecentOrders();
			fetchCustomizationData();
			
			setInterval(fetchRecentOrders, 10000);
			
			document.getElementById('timeframeSelect').addEventListener('change', function() {
				fetchRevenueData(this.value);
			});
			
			document.getElementById('orderStatusPeriod').addEventListener('change', function() {
				// Switch between real and demo data as needed
				if (this.value === 'month') {
					fetchOrderStatusDataDemo();
				} else {
					fetchOrderStatusData();
				}
			});
			
			document.getElementById('customTimeFilter').addEventListener('change', function() {
				fetchCustomizationData();
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
		// PDF generation script
document.addEventListener("DOMContentLoaded", function() {
    const downloadBtn = document.querySelector('.btn-download');
    
    if (!downloadBtn) {
        console.error("Download button not found");
        return;
    }
    
    // Create status element if not exists
    let downloadStatus = document.querySelector('.download-status');
    if (!downloadStatus) {
        downloadStatus = document.createElement('span');
        downloadStatus.className = 'download-status';
        downloadBtn.appendChild(downloadStatus);
    }
    
    downloadBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Show initial status
        downloadStatus.textContent = 'Generating...';
        downloadStatus.className = 'download-status';
        downloadStatus.style.display = 'block';
        
        // Create loading message
        const loadingMsg = document.createElement('div');
        loadingMsg.style.position = 'fixed';
        loadingMsg.style.top = '50%';
        loadingMsg.style.left = '50%';
        loadingMsg.style.transform = 'translate(-50%, -50%)';
        loadingMsg.style.padding = '15px 20px';
        loadingMsg.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        loadingMsg.style.color = 'white';
        loadingMsg.style.borderRadius = '5px';
        loadingMsg.style.zIndex = '9999';
        loadingMsg.textContent = 'Generating PDF... Please wait';
        document.body.appendChild(loadingMsg);
        
        // Use setTimeout to ensure UI is updated before heavy PDF work begins
        setTimeout(function() {
            try {
                // Check if jspdf is loaded
                if (typeof window.jspdf === 'undefined') {
                    throw new Error('jsPDF library not loaded');
                }
                
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });
                
                // Load logo
                const logoImg = new Image();
                logoImg.crossOrigin = 'Anonymous';
                logoImg.src = '<?= base_url('assets/img/logo.png') ?>';
                
                logoImg.onload = function() {
                    generatePDFContent(doc, logoImg, downloadStatus, loadingMsg);
                };
                
                logoImg.onerror = function() {
                    console.error("Error loading logo, generating PDF without logo");
                    generatePDFContent(doc, null, downloadStatus, loadingMsg);
                };
                
                // Set a timeout in case image loading hangs
                setTimeout(function() {
                    if (document.body.contains(loadingMsg)) {
                        document.body.removeChild(loadingMsg);
                        downloadStatus.textContent = 'Timeout: Please try again';
                        downloadStatus.className = 'download-status error';
                        
                        setTimeout(() => {
                            downloadStatus.style.display = 'none';
                        }, 3000);
                    }
                }, 15000);
                
            } catch (error) {
                console.error("Error starting PDF generation:", error);
                downloadStatus.textContent = 'Error: ' + error.message;
                downloadStatus.className = 'download-status error';
                
                if (document.body.contains(loadingMsg)) {
                    document.body.removeChild(loadingMsg);
                }
                
                setTimeout(() => {
                    downloadStatus.style.display = 'none';
                }, 5000);
            }
        }, 100);
    });
});

function generatePDFContent(doc, logoImg, downloadStatus, loadingMsg) {
    try {
        if (logoImg) {
            try {
                doc.addImage(logoImg, 'PNG', 80, 20, 50, 50);
            } catch (imgErr) {
                console.error("Error adding logo to PDF:", imgErr);
            }
        }
        
        doc.setFontSize(24);
        doc.setTextColor(60, 145, 230);
        doc.setFont('helvetica', 'bold');
        doc.text('INM Audio Dashboard', 105, 85, { align: 'center' });
        
        doc.setFontSize(16);
        doc.setTextColor(0, 0, 0);
        doc.setFont('helvetica', 'normal');
        doc.text('Monthly Business Performance Report', 105, 95, { align: 'center' });
        
        const today = new Date();
        const dateStr = today.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        doc.setFontSize(12);
        doc.text(`Generated on: ${dateStr}`, 105, 105, { align: 'center' });
        
        doc.addPage();
        addPageHeader(doc, logoImg);
        
        doc.setFontSize(18);
        doc.setTextColor(60, 145, 230);
        doc.setFont('helvetica', 'bold');
        doc.text('Executive Summary', 20, 30);
        
        doc.setFontSize(12);
        doc.setTextColor(0, 0, 0);
        doc.setFont('helvetica', 'bold');
        doc.text('Key Performance Indicators', 20, 40);
        doc.setFont('helvetica', 'normal');
        
        const kpiData = [
            ['Metric', 'Value', 'Monthly Change'],
            ['Total Orders', '<?= $totalOrders ?? 0; ?>', '+8%'],
            ['Confirmed Orders', '<?= $totalConfirmed ?? 0; ?>', '+12%'],
            ['Total Sales', '₱<?= number_format($totalRevenue ?? 0, 2); ?>', '+15%'],
            ['Custom IEMs', '<?= $totalCustomOrders ?? 0; ?>', '+10%'],
            ['Customer Retention', '87.5%', '+3%']
        ];
        
        doc.autoTable({
            startY: 45,
            head: [kpiData[0]],
            body: kpiData.slice(1),
            theme: 'grid',
            headStyles: {
                fillColor: [60, 145, 230],
                textColor: [255, 255, 255]
            },
            columnStyles: {
                0: { cellWidth: 60 },
                1: { cellWidth: 60, halign: 'right' },
                2: { cellWidth: 60, halign: 'right' }
            }
        });
        
        // Page 3 - Charts and Visualizations
        doc.addPage();
        addPageHeader(doc, logoImg);
        
        // Section title
        doc.setFontSize(18);
        doc.setTextColor(60, 145, 230);
        doc.setFont('helvetica', 'bold');
        doc.text('Performance Analytics', 20, 30);
        
        // Revenue Chart
        doc.setFontSize(14);
        doc.text('Monthly Revenue Trend', 20, 40);
        
        addChartToPDF(doc, 'yearlyRevenueChart', 20, 45, 170, 80, 'Revenue chart data unavailable');
        
        // Order Status Chart
        doc.setFontSize(14);
        doc.text('Order Status Distribution', 20, 140);
        
        addChartToPDF(doc, 'orderStatusChart', 20, 145, 80, 80, 'Order status chart data unavailable');
        
        // Custom IEM chart
        doc.setFontSize(14);
        doc.text('Custom IEM Analysis', 110, 140);
        
        addChartToPDF(doc, 'customizationTypeChart', 110, 145, 80, 80, 'Custom IEM data unavailable');
        
        // Page 4 - Custom IEM Details
        doc.addPage();
        addPageHeader(doc, logoImg);
        
        // Section 
        doc.setFontSize(18);
        doc.setTextColor(156, 39, 176);
        doc.setFont('helvetica', 'bold');
        doc.text('Custom IEM Insights', 20, 30);
        
        doc.setFontSize(12);
        doc.setTextColor(0, 0, 0);
        doc.setFont('helvetica', 'normal');
        
        const customIemData = [
            ['Category', 'Metric', 'Value'],
            ['Orders', 'Total Orders', '<?= $totalCustomOrders ?? 0; ?>'],
            ['Revenue', 'Total Revenue', '₱<?= ($totalCustomRevenue > 0) ? number_format($totalCustomRevenue, 2) : "0"; ?>'],
            ['Production', 'Pending', '<?= $customStats['pending_custom'] ?? 0; ?>'],
            ['Production', 'Completed', '<?= $customStats['completed_custom'] ?? 0; ?>']
        ];
        
        doc.autoTable({
            startY: 35,
            head: [customIemData[0]],
            body: customIemData.slice(1),
            theme: 'grid',
            headStyles: {
                fillColor: [156, 39, 176],
                textColor: [255, 255, 255]
            },
            columnStyles: {
                0: { cellWidth: 50 },
                1: { cellWidth: 70 },
                2: { cellWidth: 60 }
            }
        });
        
        doc.addPage();
        addPageHeader(doc, logoImg);
        
        doc.setFontSize(18);
        doc.setTextColor(60, 145, 230);
        doc.setFont('helvetica', 'bold');
        doc.text('Recent Orders Overview', 20, 30);
        
        addRecentOrdersTable(doc);
        
        addFooters(doc);
        
        doc.save('INM-Audio-Performance-Report.pdf');
        
        downloadStatus.textContent = 'Download Complete';
        downloadStatus.className = 'download-status success';
        
        setTimeout(() => {
            downloadStatus.style.display = 'none';
        }, 3000);
        
        // Remove loading message
        document.body.removeChild(loadingMsg);
        
    } catch (pdfErr) {
        console.error("Error generating PDF content:", pdfErr);
        document.body.removeChild(loadingMsg);
        
        downloadStatus.textContent = 'Error: ' + pdfErr.message;
        downloadStatus.className = 'download-status error';
        
        setTimeout(() => {
            downloadStatus.style.display = 'none';
        }, 5000);
    }
}

function addPageHeader(doc, logoImg) {
    doc.setDrawColor(60, 145, 230);
    doc.setLineWidth(0.5);
    doc.line(10, 15, 200, 15);
    
    if (logoImg) {
        try {
            doc.addImage(logoImg, 'PNG', 10, 5, 10, 10);
        } catch (err) {
            console.warn("Could not add logo to header");
        }
    }
    
    doc.setFontSize(10);
    doc.setTextColor(0, 0, 0);
    doc.text('INM Audio - Performance Report', 105, 10, { align: 'center' });
}

function addChartToPDF(doc, chartId, x, y, width, height, fallbackText) {
    try {
        const chart = document.getElementById(chartId);
        if (chart) {
            const chartImg = chart.toDataURL('image/png', 1.0);
            doc.addImage(chartImg, 'PNG', x, y, width, height);
        } else {
            doc.setFontSize(10);
            doc.setTextColor(150, 150, 150);
            doc.text(fallbackText, x + width/2, y + height/2, { align: 'center' });
        }
    } catch (chartErr) {
        console.error(`Error adding ${chartId} to PDF:`, chartErr);
        doc.setFontSize(10);
        doc.setTextColor(150, 150, 150);
        doc.text(fallbackText, x + width/2, y + height/2, { align: 'center' });
    }
}

function addRecentOrdersTable(doc) {
    try {
        const ordersTable = document.getElementById('recentOrdersTable');
        let recentOrdersData = [
            ['Order No.', 'Customer', 'Total', 'Status', 'Date']
        ];
        
        if (ordersTable) {
            const orderRows = ordersTable.querySelectorAll('tr');
            
            orderRows.forEach(row => {
                try {
                    const cells = row.querySelectorAll('td');
                    if (cells.length > 0 && !cells[0].hasAttribute('colspan')) {
                        if (cells.length >= 8) {
                            recentOrdersData.push([
                                cells[0].textContent || '',
                                cells[1].textContent || '',
                                cells[4].textContent || '',
                                cells[7].textContent.trim() || '',
                                cells[6].textContent || ''
                            ]);
                        }
                    }
                } catch (cellErr) {
                    console.error("Error processing table row:", cellErr);
                }
            });
            
            if (recentOrdersData.length === 1) {
                recentOrdersData.push(['No data available', '', '', '', '']);
            }
        } else {
            recentOrdersData.push(['Table not found', '', '', '', '']);
        }
        
        doc.autoTable({
            startY: 35,
            head: [recentOrdersData[0]],
            body: recentOrdersData.slice(1, 11), 
            theme: 'grid',
            headStyles: {
                fillColor: [60, 145, 230],
                textColor: [255, 255, 255]
            }
        });
    } catch (tableErr) {
        console.error("Error processing orders table:", tableErr);
        doc.setFontSize(12);
        doc.setTextColor(150, 150, 150);
        doc.text('Error retrieving recent orders data', 105, 50, { align: 'center' });
    }
}

// Helper function to add footers
function addFooters(doc) {
    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(10);
        doc.setTextColor(150, 150, 150);
        doc.text(`Page ${i} of ${pageCount}`, 105, 290, { align: 'center' });
        doc.text('© INM Audio 2025 - Confidential Business Report', 105, 297, { align: 'center' });
    }
}

</script>


</body>

</html>