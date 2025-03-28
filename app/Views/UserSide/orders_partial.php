<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($filteredOrders)) : ?>
            <?php foreach ($filteredOrders as $order) : ?>
                <tr>
                    <td><?= esc($order['order_id']) ?></td>
                    <td><?= esc($order['product_id']) ?></td>
                    <td><?= esc($order['quantity']) ?></td>
                    <td>$<?= esc($order['price']) ?></td>
                    <td>
                        <span class="status <?= esc($order['order_status']) ?>">
                            <i class="
    <?= ($order['order_status'] === 'delivered') ? 'fa-solid fa-check-circle delivered' : (($order['order_status'] === 'cancelled') ? 'fa-solid fa-times-circle cancelled' : (($order['order_status'] === 'shipped') ? 'fa-solid fa-truck shipped' : 'fa-solid fa-hourglass-half pending')); ?>">
                            </i>

                            <?= ucfirst(esc($order['order_status'])) ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-cancel cancel-btn"
                            data-order-id="<?= $order['order_id'] ?>"
                            <?= ($order['order_status'] !== 'pending') ? 'disabled' : '' ?>>
                            Cancel
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">No <?= ucfirst($status) ?> Orders.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>