<main class="order">
    <div class="info">
        <h3>Order ID: <?= $order['id'] ?></h3>
        <div class="shipping_info">
            <h3>Shipping Info: </h3>
            <div class="row">
                <p class="rowhead">First Name: </p>
                <p class="cell"><?= $order['shipping']->first_name ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Last Name: </p>
                <p class="cell"><?= $order['shipping']->last_name ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Address: </p>
                <p class="cell"><?= $order['shipping']->address ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Postal ID: </p>
                <p class="cell"><?= $order['shipping']->postal_code ?></p>
            </div>
            <div class="row">
                <p class="rowhead">City: </p>
                <p class="cell"><?= $order['shipping']->city ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Region: </p>
                <p class="cell"><?= $order['shipping']->region ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Country: </p>
                <p class="cell"><?= $order['shipping']->country ?></p>
            </div>
        </div>
        <div class="billing_info">
            <h3>Billing Info: </h3>
            <div class="row">
                <p class="rowhead">First Name: </p>
                <p class="cell"><?= $order['billing']->first_name ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Last Name: </p>
                <p class="cell"><?= $order['billing']->last_name ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Address: </p>
                <p class="cell"><?= $order['billing']->address ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Postal ID: </p>
                <p class="cell"><?= $order['billing']->postal_code ?></p>
            </div>
            <div class="row">
                <p class="rowhead">City: </p>
                <p class="cell"><?= $order['billing']->city ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Region: </p>
                <p class="cell"><?= $order['billing']->region ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Country: </p>
                <p class="cell"><?= $order['billing']->country ?></p>
            </div>
        </div>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item) { ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['product_name'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>P<?= $item['total'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="add_info">
            <div class="status">Status: <?= $order['status'] ?></div>
            <div class="total">
                <div class="row">
                    <p class="rowhead">Sub Total: </p>
                    <p class="cell">P<?= $order['billing']->total_payment - 50 ?></p>
                </div>
                <div class="row">
                    <p class="rowhead">Shipping Fee: </p>
                    <p class="cell">P50</p>
                </div>
                <div class="row">
                    <p class="rowhead">Total Payment: </p>
                    <p class="cell"><?= $order['billing']->total_payment ?></p>
                </div>
            </div>
        </div>
    </div>

</main>