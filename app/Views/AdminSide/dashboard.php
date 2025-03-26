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
							<th>Order No.</th>
							<th>Name</th>
							<th>Number</th>
							<th>IEM Order</th>
							<th>Quantity</th>
							<th>Total Price</th>
                            <th>Payment Type</th>
                            <th>Order Date and Time</th>
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
            const tbody = document.querySelector(".order table tbody");
            tbody.innerHTML = "";

            if (data.length > 0) {
                data.forEach(order => {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                        <td>${order.order_id}</td>
                        <td>${order.shipping_name}</td>
                        <td>${order.shipping_phone}</td>
                        <td>
                            <img src="${order.image_url}" alt="Product Image" width="50">
                            <p>${order.product_name}</p>
                        </td>
                        <td>${order.quantity}</td>
                        <td>${order.price}</td>
                        <td>${order.payment_method}</td>
                        <td>${order.created_at}</td>
                        <td>
                            <span class="status ${order.order_status === 'completed' ? 'completed' : order.order_status === 'cancelled' ? 'pending' : 'process'}">
                                ${order.order_status}
                            </span>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="9" style="color: gray;">No recent orders!</td></tr>`;
            }
        })
        .catch(error => console.error('Error fetching recent orders:', error));
}

fetchRecentOrders();

setInterval(fetchRecentOrders, 10000);


    fetchRevenueData();
    fetchOrderStatusData();
    fetchRecentOrders();

    document.getElementById('timeframeSelect').addEventListener('change', function () {
        fetchRevenueData(this.value);
    });

    setInterval(fetchRecentOrders, 10000); 
});

</script>
</body>
</html>
