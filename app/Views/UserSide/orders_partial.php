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
                                
                                <?php if ($order['is_custom_iem'] == 1) : ?>
                                    <p class="product-type"><strong>Type:</strong> Custom IEM</p>
                                    
                                    <?php if (!empty($order['category'])) : ?>
                                        <p class="category"><strong>Category:</strong> <?= esc($order['category']) ?></p>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    // For custom IEMs, try to extract details from the custom_details JSON
                                    if (!empty($order['custom_details'])) {
                                        $customDetails = json_decode($order['custom_details'], true);
                                        if (is_array($customDetails)) :
                                    ?>
                                        <?php if (!empty($customDetails['design_name'])) : ?>
                                            <p class="design"><strong>Design:</strong> <?= esc($customDetails['design_name']) ?></p>
                                        <?php endif; ?>
                                    <?php 
                                        endif;
                                    }
                                    ?>
                                <?php endif; ?>
        
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