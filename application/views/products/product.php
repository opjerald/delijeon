<main class="product">
    <div class="images">
        <?php foreach ($product['images'] as $images) { ?>
            <?php if ($images->is_main == 1) { ?>
                <img src="<?= base_url("assets/images/{$images->file_name}") ?>" alt="<?= $images->file_name ?>" id="main">
            <?php } ?>
        <?php } ?>
        <div class="list-images">
            <?php foreach ($product['images'] as $images) { ?>
                <img src="<?= base_url("assets/images/{$images->file_name}") ?>" alt="<?= $images->file_name ?>" class="image">
            <?php } ?>
        </div>
    </div>
    <div class="info">
        <h1><?= $product['name'] ?></h1>
        <p><?= $product['description'] ?> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam nobis, odit enim at iusto ab eum voluptas animi molestias qui.</p>
        <form action="<?= base_url("carts/add_to_cart") ?>" method="post" id="add-to-cart-form">
            <input type="hidden" id="category-id" value="<?= $product['category_id'] ?>">
            <div class="row">
                <p class="rowhead">Price:</p>
                <p class="cell">P<?= $product['price'] ?></p>
            </div>
            <div class="row">
                <p class="rowhead">Availability:</p>
                <p class="cell"><span class="total_quantity"><?= $product['quantity'] ?></span> pieces available</p>
            </div>
            <div class="row">
                <p class="rowhead">Quantity:</p>
                <div class="quantity">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="button" data-id="<?= $product['id'] ?>" class="btn minus"> - </button>
                    <input id="input-quantity" data-id="<?= $product['id'] ?>" type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>">
                    <button type="button" data-id="<?= $product['id'] ?>" class="btn add"> + </button>
                </div>
            </div>
            <button type="submit">Add to Cart</button>
        </form>
    </div>
</main>