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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>

    <title>Custom IEM Order Details</title>
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

        .order-details-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .order-header h2 {
            margin: 0;
            color: #333;
        }

        .order-status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #ffeeba;
            color: #856404;
        }

        .status-to-ship {
            background-color: #b8daff;
            color: #004085;
        }

        .status-shipped {
            background-color: #c3e6cb;
            color: #155724;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .status-complete {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .order-info, .customer-info, .payment-info, .custom-iem-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }

        .order-info h3, .customer-info h3, .payment-info h3, .custom-iem-details h3 {
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
        }

        .info-value {
            flex: 1;
        }

        .action-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .action-buttons button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .update-status-btn {
            background-color: #007bff;
            color: white;
        }

        .print-btn {
            background-color: #28a745;
            color: white;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
        }

        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #ccc;
            vertical-align: middle;
            margin-right: 5px;
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

        #canvas-container {
            width: 100%;
            height: 300px;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Status update modal */
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
            max-width: 500px;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .status-select {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .update-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .update-btn:hover {
            background-color: #0069d9;
        }
    </style>
</head>

<body>
    <?php echo view('AdminSide/includes/notifModal') ?>
    <?php echo view('AdminSide/includes/sideNav1') ?>

    <section id="content">
        <?php echo view('AdminSide/includes/topNavbar') ?>

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Custom IEM Order Details</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a href="<?= base_url('admin/orders_transactions') ?>">Orders</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Order #<?= $order['order_id'] ?></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="order-details-container">
                <div class="order-header">
                    <h2>Order #<?= $order['order_id'] ?></h2>
                    <div class="order-status status-<?= strtolower(str_replace(' ', '-', $order['order_status'])) ?>">
                        <?= ucfirst($order['order_status']) ?>
                    </div>
                </div>

                <div class="order-details-grid">
                    <div class="order-info">
                        <h3>Order Information</h3>
                        <div class="info-row">
                            <div class="info-label">Order ID:</div>
                            <div class="info-value"><?= $order['order_id'] ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Order Date:</div>
                            <div class="info-value"><?= date('F j, Y g:i A', strtotime($order['created_at'])) ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Status:</div>
                            <div class="info-value"><?= ucfirst($order['order_status']) ?></div>
                        </div>
                        <?php if (!empty($order['date_completed'])): ?>
                        <div class="info-row">
                            <div class="info-label">Completed Date:</div>
                            <div class="info-value"><?= date('F j, Y g:i A', strtotime($order['date_completed'])) ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($order['delivery_date'])): ?>
                        <div class="info-row">
                            <div class="info-label">Delivery Date:</div>
                            <div class="info-value"><?= date('F j, Y g:i A', strtotime($order['delivery_date'])) ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($order['date_cancelled'])): ?>
                        <div class="info-row">
                            <div class="info-label">Cancelled Date:</div>
                            <div class="info-value"><?= date('F j, Y g:i A', strtotime($order['date_cancelled'])) ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <div class="info-label">Order Reference:</div>
                            <div class="info-value"><?= $customDetails['order_reference'] ?? 'N/A' ?></div>
                        </div>
                    </div>

                    <div class="customer-info">
                        <h3>Customer Information</h3>
                        <div class="info-row">
                            <div class="info-label">Customer ID:</div>
                            <div class="info-value"><?= $order['user_id'] ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Name:</div>
                            <div class="info-value"><?= $order['shipping_name'] ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Phone:</div>
                            <div class="info-value"><?= $order['shipping_phone'] ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Shipping Address:</div>
                            <div class="info-value"><?= $order['shipping_address'] ?></div>
                        </div>
                    </div>

                    <div class="payment-info">
                        <h3>Payment Information</h3>
                        <div class="info-row">
                            <div class="info-label">Payment Method:</div>
                            <div class="info-value"><?= ucfirst($order['payment_method']) ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Price:</div>
                            <div class="info-value">₱<?= number_format($order['price'], 2) ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Quantity:</div>
                            <div class="info-value"><?= $order['quantity'] ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Total Amount:</div>
                            <div class="info-value">₱<?= number_format($order['price'] * $order['quantity'], 2) ?></div>
                        </div>
                    </div>

                    <div class="custom-iem-details">
                        <h3>Custom IEM Details</h3>
                        <div class="info-row">
                            <div class="info-label">Design Name:</div>
                            <div class="info-value"><?= $customDetails['design_name'] ?? 'N/A' ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Category:</div>
                            <div class="info-value"><?= $customDetails['category'] ?? 'N/A' ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Material:</div>
                            <div class="info-value"><?= $customDetails['material'] ?? 'N/A' ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Size:</div>
                            <div class="info-value"><?= $customDetails['size'] ?? 'N/A' ?></div>
                        </div>
                        
                        <table class="custom-details-table">
                            <tr>
                                <th>Component</th>
                                <th>Color</th>
                            </tr>
                            <tr>
                                <td>Left Shell</td>
                                <td>
                                    <?php if (isset($customDetails['left_color'])): ?>
                                    <span class="color-preview" style="background-color: <?= $customDetails['left_color'] ?>"></span>
                                    <?= $customDetails['left_color'] ?>
                                    <?php else: ?>
                                    N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Right Shell</td>
                                <td>
                                    <?php if (isset($customDetails['right_color'])): ?>
                                    <span class="color-preview" style="background-color: <?= $customDetails['right_color'] ?>"></span>
                                    <?= $customDetails['right_color'] ?>
                                    <?php else: ?>
                                    N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Left Faceplate</td>
                                <td>
                                    <?php if (isset($customDetails['left_faceplate_color'])): ?>
                                    <span class="color-preview" style="background-color: <?= $customDetails['left_faceplate_color'] ?>"></span>
                                    <?= $customDetails['left_faceplate_color'] ?>
                                    <?php else: ?>
                                    N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Right Faceplate</td>
                                <td>
                                    <?php if (isset($customDetails['right_faceplate_color'])): ?>
                                    <span class="color-preview" style="background-color: <?= $customDetails['right_faceplate_color'] ?>"></span>
                                    <?= $customDetails['right_faceplate_color'] ?>
                                    <?php else: ?>
                                    N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        
                        <?php if (isset($customDetails['left_faceplate_texture']) || isset($customDetails['right_faceplate_texture'])): ?>
                        <h4>Faceplate Textures</h4>
                        <div class="info-row">
                            <div class="info-label">Left Faceplate:</div>
                            <div class="info-value"><?= $customDetails['left_faceplate_texture'] ?? 'None' ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Right Faceplate:</div>
                            <div class="info-value"><?= $customDetails['right_faceplate_texture'] ?? 'None' ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div id="canvas-container"></div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button class="update-status-btn" id="updateStatusBtn">Update Status</button>
                    <button class="print-btn" onclick="window.print()">Print Order</button>
                    <button class="back-btn" onclick="window.location.href='<?= base_url('admin/orders_transactions') ?>'">Back to Orders</button>
                </div>
            </div>
        </main>
    </section>

    <!-- Status Update Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Order Status</h2>
            <form id="updateStatusForm">
                <input type="hidden" id="orderId" value="<?= $order['order_id'] ?>">
                <select id="orderStatus" class="status-select">
                    <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="to ship" <?= $order['order_status'] == 'to ship' ? 'selected' : '' ?>>To Ship</option>
                    <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                    <option value="complete" <?= $order['order_status'] == 'complete' ? 'selected' : '' ?>>Complete</option>
                    <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
                <button type="submit" class="update-btn">Update Status</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('Admin/js/notifModal.js') ?>"></script>
    <script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>
    <script>
        // 3D Model Rendering
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById('canvas-container');
            
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(renderer.domElement);
            
            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.autoRotate = true;
            controls.autoRotateSpeed = 2.0;
            
            const light = new THREE.AmbientLight(0xffffff, 1.5);
            scene.add(light);
            
            const loader = new THREE.GLTFLoader();
            loader.load('<?= base_url('assets/models/iem2.glb') ?>', function(gltf) {
                const iemModel = gltf.scene;
                
                // Apply colors from the custom details
                <?php if (isset($customDetails['left_color'])): ?>
                const leftColor = new THREE.Color('<?= $customDetails['left_color'] ?>');
                <?php endif; ?>
                
                <?php if (isset($customDetails['right_color'])): ?>
                const rightColor = new THREE.Color('<?= $customDetails['right_color'] ?>');
                <?php endif; ?>
                
                <?php if (isset($customDetails['left_faceplate_color'])): ?>
                const leftFaceplateColor = new THREE.Color('<?= $customDetails['left_faceplate_color'] ?>');
                <?php endif; ?>
                
                <?php if (isset($customDetails['right_faceplate_color'])): ?>
                const rightFaceplateColor = new THREE.Color('<?= $customDetails['right_faceplate_color'] ?>');
                <?php endif; ?>
                
                // Apply colors to the model (this is a simplified example)
                // In a real implementation, you would need to identify the specific meshes in your model
                // and apply the colors accordingly
                
                scene.add(iemModel);
                camera.position.set(0, 0, 3);
                animate();
            });
            
            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
        });
        
        // Status Modal
        const modal = document.getElementById("statusModal");
        const btn = document.getElementById("updateStatusBtn");
        const span = document.getElementsByClassName("close")[0];
        
        btn.onclick = function() {
            modal.style.display = "block";
        }
        
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
        // Update Status Form
        document.getElementById("updateStatusForm").addEventListener("submit", function(e) {
            e.preventDefault();
            
            const orderId = document.getElementById("orderId").value;
            const status = document.getElementById("orderStatus").value;
            
            $.ajax({
                url: "<?= base_url('admin/update_order_status') ?>",
                type: "POST",
                data: {
                    order_id: orderId,
                    order_status: status,
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
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
                error: function() {
                    alert("Failed to update order status.");
                }
            });
        });
    </script>
</body>

</html>
