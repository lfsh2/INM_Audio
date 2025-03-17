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
            <h3><?= $totalPlaced ?? 0; ?></h3>
            <p>New Orders</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-group'></i>
        <span class="text">
            <h3><?= $totalOrders ?? 0; ?></h3>
            <p>Orders</p>
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


		<!-- CHART -->
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
            <canvas id="productTrendsChart"></canvas>
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
							<th>User</th>
							<th>Gear</th>
							<th>Base Price</th>
							<th>Total Price</th>
							<th>Date Order</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($recentOrders)) : ?>
							<?php foreach ($recentOrders as $recent) : ?>
								<tr>
									<td>
										<img src="data:image/jpeg;base64,<?= base64_encode($recent['profile_pic'] ?? '') ?>" alt="">
										<p><?= $recent['firstname'] . " " . $recent['lastname'] ?></p>
									</td>
									<td>
										<img src="<?= $recent['image_url'] ?? '' ?>" alt="">
										<p><?= $recent['product_name'] ?? '' ?></p>
									</td>
									<td><?= $recent['basePrice'] ?? 0 ?></td>
									<td><?= $recent['totalPrice'] ?? 0 ?></td>
									<td><?= $recent['dateOrder'] ?? 'N/A' ?></td>
									<td>
									<?php if (in_array(($recent['order_status'] ?? ''), ['complete', 'completed'])) : ?>
										<span class="status completed"><?= $recent['order_status'] ?></span>
										<?php elseif (($recent['order_status'] ?? '') == "cancelled") : ?>
											<span class="status pending"><?= $recent['order_status'] ?></span>
										<?php else : ?>
											<span class="status process"><?= $recent['order_status'] ?? 'In Progress' ?></span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="6" style="color: gray;">No recent orders!</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
	<!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="<?= base_url('Admin/js/notifModal.js') ?>"></script>
<script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
    let revenueChart;
    let pieChart;

    function fetchRevenueData(timeframe = 'yearly') {
        fetch(`<?= base_url('/admin/chart-data/revenue') ?>?timeframe=${timeframe}`)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('yearlyRevenueChart').getContext('2d');

                if (revenueChart) {
                    revenueChart.destroy();
                }

                revenueChart = new Chart(ctx, {
                    type: 'line', 
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: `${timeframe.charAt(0).toUpperCase() + timeframe.slice(1)} Revenue`,
                            data: data.values,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: '#4CAF50',
                            borderWidth: 3,
                            pointBackgroundColor: '#4CAF50',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#4CAF50'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: '#333',
                                    font: { size: 14 }
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: '#4CAF50',
                                bodyColor: '#fff',
                                borderColor: '#4CAF50',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            x: { ticks: { color: '#333' } },
                            y: {
                                beginAtZero: true,
                                ticks: { color: '#333' }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Error fetching revenue data:", error));
    }

    function fetchOrderStatusData() {
        fetch("<?= base_url('/admin/chart-data/order-status') ?>")
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('productTrendsChart').getContext('2d');

                if (pieChart) {
                    pieChart.destroy();
                }

                pieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Order Status',
                            data: data.values,
                            backgroundColor: [
                                '#4CAF50',  
                                '#FFC107',  
                                '#F44336'   
                            ],
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#333',
                                    font: { size: 14 }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#4CAF50',
                                bodyColor: '#fff',
                                borderColor: '#4CAF50',
                                borderWidth: 1
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Error fetching order status data:", error));
    }

    fetchRevenueData();
    fetchOrderStatusData();

    document.getElementById('timeframeSelect').addEventListener('change', function () {
        fetchRevenueData(this.value);
    });
});

</script>
</body>
</html>
