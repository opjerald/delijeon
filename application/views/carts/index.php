<main class="cart">
    <div class="products">
        <h3>Products</h3>
        <?php foreach ($products as $product) { ?>
            <div class="product">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <img src="<?= base_url("assets/images/{$product['main_image']}") ?>" alt="<?= $product['main_image'] ?>">
                <div class="info">
                    <h3><?= $product['name'] ?></h3>
                    <small class="price">P<span class="product_price_<?= $product['id'] ?>"><?= $product['price'] ?></span> </small>
                    <p class="total_quantity total_quantity_<?= $product['id'] ?>">Total Quantity: <?= $product['product_quantity'] ?></p>
                    <div class="quantity">
                        <button data-id="<?= $product['id'] ?>" class="btn minus"> - </button>
                        <input id="<?= $product['id'] ?>-input-quantity" data-id="<?= $product['id'] ?>" data-init-quantity="<?= $product['cart_quantity'] ?>" class="qty" type="number" value="<?= $product['cart_quantity'] ?>">
                        <button data-id="<?= $product['id'] ?>" class="btn add"> + </button>
                    </div>
                    <small class="total">Total: P<span class="total_product_price product_total_price_<?= $product['id'] ?>"><?= $product['price'] * $product['cart_quantity'] ?></span></small>
                </div>
                <form id="remove-product-form" action="<?= base_url("carts/remove_product") ?>" method="POST">
                    <input type="hidden" name="cart_id" value="<?= $product['id'] ?>">
                    <button type="submit"><i class="bi bi-x"></i></button>
                </form>
            </div>
        <?php } ?>
        <div class="footer">
            <?php if (!empty($products)) { ?>
                <button class="btn btn-update">Update Cart</button>
            <?php } ?>
        </div>
    </div>
    <div class="summary">
        <h3>Order Summary</h3>
        <div class="info">
            <p class="subtotal">Subtotal: P<span class="total_price"><?= $total_price ?></span></p>
            <small>Shipping, taxes, and discounts will be calculated at checkout.</small>
            <a href="<?= base_url('carts/checkout?method=information') ?>" class="btn">Proceed to Checkout</a>
            <a href="<?= base_url('shop') ?>" class="btn">Continue Shopping</a>
        </div>
    </div>
</main>