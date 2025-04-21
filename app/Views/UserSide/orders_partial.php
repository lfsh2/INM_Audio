<div class="items">
    <?php if (!empty($filteredOrders)) : ?>
        <?php foreach ($filteredOrders as $order) : ?>
            <div class="item-card">
                <div class="item ihead">
                    <p class="shop-name">INM_Audio</p>
                    
                    <span class="status <?= esc($order['order_status']) ?>">
                        <i class="<?= ($order['order_status'] === 'delivered') ? 'fa-solid fa-check-circle' : 
                            (($order['order_status'] === 'cancelled') ? 'fa-solid fa-times-circle' : 
                            (($order['order_status'] === 'shipped') ? 'fa-solid fa-truck' : 
                            'fa-solid fa-hourglass-half')); ?>"></i>
    
                        <?= ucfirst(esc($order['order_status'])) ?>
                    </span>
                </div>
    
                <div class="item ibody">
                    <div class="container">
                        <?php if (!empty($order['image_url'])) : ?>
                            <img src="<?= $order['image_url'] ?>" alt="<?= esc($order['product_name']) ?>">
                        <?php else : ?>
                            <img src="<?= base_url('/assets/images/placeholder.jpg') ?>" alt="No Image Available">
                        <?php endif; ?>
    
                        <div class="block">
                            <div class="sub-info">
                                <h4><?= esc($order['product_name'] ?? 'Product #'.$order['product_id']) ?></h4>
        
                                <div class="group">
                                    <?php if (!empty($order['color'])) : ?>
                                        <p><?= esc($order['color']) ?></p>
                                    <?php endif; ?>
                                    <p><i>x<?= esc($order['quantity']) ?></i></p>
                                </div>
                            </div>
    
                            <p class="price">₱<?= esc($order['price']) ?></p>
                        </div>
                    </div>
    
                    <p class="total">Total <?= esc($order['quantity']) ?> item: <strong>₱<?= number_format($order['quantity'] * $order['price'], 2) ?></strong></p>
                </div>
    
                <div class="item ibottom">
                    <button class="btn-cancel cancel-btn"
                        data-order-id="<?= $order['order_id'] ?>"
                        <?= ($order['order_status'] !== 'pending') ? 'disabled' : '' ?>>
                        <?= ($order['order_status'] === 'pending') ? 'Cancel Order' : 'No Action Available' ?>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="no-orders">
            <p>No <?= ucfirst($status) ?> orders found.</p>
        </div>
    <?php endif; ?>
</div>

<style>
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

@media (max-width: 480px) {
    .container img {
        width: 100%;
        height: 150px;
    }
}
</style>