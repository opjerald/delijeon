<thead>
    <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Billing Address</th>
        <th>Total</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($orders as $order) { ?>
        <tr>
            <td><a href="<?= base_url("dashboard/order/{$order['id']}") ?>"><?= $order['id'] ?></a></td>
            <td><?= $order['name'] ?></td>
            <td><?= $order['date'] ?></td>
            <td><?= $order['address'] ?></td>
            <td><?= $order['total'] ?></td>
            <td class="action">
                <form class="update_status_form" action="<?= base_url("orders/ajax_update/{$order['id']}") ?>" method="POST">
                    <select name="status">
                        <option value="Order in Process" <?= $order['status'] == "Order in Process" ? "selected" : "" ?>>Order in Process</option>
                        <option value="Shipped" <?= $order['status'] == "Shipped" ? "selected" : "" ?>>Shipped</option>
                        <option value="Cancelled" <?= $order['status'] == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
                    </select>
                </form>
            </td>
        </tr>
    <?php } ?>
</tbody>
<?php if (!empty($link_count) && $link_count > 1) { ?>
    <tfoot>
        <tr>
            <td>
                <?php if ($page != 1) { ?>
                    <a href="#>" class="prev-page"><i class="bi bi-chevron-left"></i></a>
                <?php } ?>
                <?php for ($i = 1; $i <= $link_count; $i++) { ?>
                    <a href="#" class="page <?= $page == $i ? "active" : '' ?>"><?= $i ?></a>
                <?php } ?>
                <?php if ($page != $link_count) { ?>
                    <a href="#" class="next-page"><i class="bi bi-chevron-right"></i></a>
                <?php } ?>
            </td>
        </tr>
    </tfoot>
<?php } ?>