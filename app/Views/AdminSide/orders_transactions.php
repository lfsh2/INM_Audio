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
        #order_transaction { background-color: #d4ebf844; }
        aside nav ul #order_transaction span { opacity: 1; }
        .active { background-color:rgb(255, 255, 255); color: #fff; }
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

                <div class="btns">
                    <button onclick="switchTab('table0')" class="active">Confirm Orders</button>
                    <button onclick="switchTab('table1')">Orders</button>
                    <button onclick="switchTab('table2')">Completed</button>
                    <button onclick="switchTab('table5')">Cancelled</button>
                </div>
            </div>

            <div class="container">
                <!-- Tab Content Loop -->
                <?php 
                $tabs = [
                    'table0' => ['title' => 'Confirm Orders', 'data' => $confirmOrder],
                    'table1' => ['title' => 'Orders', 'data' => $orders],
                    'table2' => ['title' => 'Completed', 'data' => $complete],
                    'table5' => ['title' => 'Cancelled', 'data' => $cancelledOrders]
                ];
                ?>

                <?php foreach ($tabs as $tabId => $tabData): ?>
                    <div id="<?= $tabId ?>" class="tab-content <?= $tabId === 'table0' ? 'active' : '' ?>">
                        <h2><?= $tabData['title'] ?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item</th>
                                    <th>Customer</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tabData['data']) : ?>
                                    <?php foreach ($tabData['data'] as $order) : ?>
                                        <tr>
                                            <td><?= $order->order_id ?? $order->placed_order_id ?></td>
                                            <td>
                                                <img src="<?= $order->image_url ?>" alt="image">
                                                <?= $order->product_name ?>
                                            </td>
                                            <td><?= $order->firstname . " " . $order->lastname ?></td>
                                            <td><?= $order->price ?></td>
                                            <td><?= $order->quantity ?></td>
                                            <td><?= $order->total_price ?? $order->totalPrice ?></td>
                                            <td><?= $order->payment_method ?></td>
                                            <td><?= $order->order_status ?? '-' ?></td>
                                            <td><?= $order->date_placed ?? $order->created_at ?? $order->date_completed ?? $order->date_cancelled ?></td>
                                            <td>
                                                <?php if ($tabId === 'table0'): ?>
                                                    <a href="<?= base_url('/admin/order/toConfirm/'.$order->placed_order_id) ?>" class="confirm">Confirm</a>
                                                    <a href="<?= base_url('/admin/order/cancelToConfirm/'.$order->placed_order_id) ?>" class="cancel">Cancel</a>
                                                <?php elseif ($tabId === 'table1'): ?>
                                                    <a href="#" class="button1 view-button" data-target="viewOrder">View</a>
                                                    <a href="<?= base_url('/admin/order/complete/'.$order->order_id) ?>" class="button2">Complete</a>
                                                    <a href="<?= base_url('/admin/order/cancelConfirmOrder/'.$order->order_id) ?>" class="button3">Cancel</a>
                                                <?php elseif ($tabId === 'table2'): ?>
                                                    <a href="<?= base_url('/admin/order/deleteComplete/'.$order->order_id) ?>" class="button3">Delete</a>
                                                <?php elseif ($tabId === 'table5'): ?>
                                                    <a href="<?= base_url('/admin/order/cancelled/'.$order->order_id) ?>" class="button3">Delete</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="10">No placed orders</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</section>

<!-- MODALS -->
<div id="viewOrder" class="modal">
    <div class="modal-content">
        <div class="add">
            <span class="close close-gear">&times;</span>
            <h2>Order Details</h2>
            <h6>Order ID: <span id="modalOrderId">#</span></h6>
        </div>  

        <div class="content">
            <div class="item">
                <h4>Item Name</h4>
                <img src="" alt="IMAGE" id="modalImage">
            </div>
            <div class="quantity">
                <h4>Quantity</h4>
                <p id="modalQuantity"></p>
            </div>
            <div class="price">
                <h4>Price</h4>
                <p id="modalPrice"></p>
            </div>
            <div class="customer">
                <h4>Customer</h4>
                <p id="modalCustomer"></p>
            </div>
            <div class="deliver">
                <h4>Delivery Date</h4>
                <p id="modalDeliveryDate"></p>
            </div>
            <div class="payment_method">
                <h4>Payment Method</h4>
                <p id="modalPaymentMethod"></p>
            </div>
            <div class="actions">
                <a href="#" class="button2">Complete</a>
                <a href="#" class="button3">Remove</a>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });

    document.getElementById(tabId).classList.add('active');

    document.querySelectorAll('.btns button').forEach(btn => {
        btn.classList.remove('active');
    });

    document.querySelector(`[onclick="switchTab('${tabId}')"]`).classList.add('active');
}
</script>

<script src="<?= base_url('Admin/js/notifModal.js') ?>"></script>
<script src="<?= base_url('Admin/js/orderTransactions.js') ?>"></script>
<script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>
</body>
</html>
