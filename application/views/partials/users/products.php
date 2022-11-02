<?php foreach ($products as $product) { ?>
    <div class="product">
        <img src="<?= base_url("assets/images/{$product['main_image']}") ?>" alt="<?= $product['main_image'] ?>">
        <div class="info">
            <a href="<?= base_url("product/{$product['id']}") ?>"><?= $product['name'] ?></a>
            <p><?= $product['price'] ?></p>
            <form id="add-to-cart-form" action="<?= base_url("carts/add_to_cart") ?>" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    </div>
<?php } ?>
<?php if (!empty($link_count) && $link_count > 1) { ?>
    <section class="pagination">
        <?php if ($page != 1) { ?>
            <a href="<?= base_url("products/index_html") ?>" class="prev-page"><i class="bi bi-chevron-left"></i></a>
        <?php } ?>
        <?php for ($i = 1; $i <= $link_count; $i++) { ?>
            <a href="<?= base_url("products/index_html?page=$i") ?>" class="page <?= $page == $i ? "active" : '' ?>"><?= $i ?></a>
        <?php } ?>
        <?php if ($page != $link_count) { ?>
            <a href="<?= base_url("products/index_html") ?>" class="next-page <?= $page == $link_count ? "disable" : '' ?>"><i class="bi bi-chevron-right"></i></a>
        <?php } ?>
    </section>
<?php } ?>