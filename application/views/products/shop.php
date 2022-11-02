<main class="shop">
    <div class="controls">
        <form id="search-form" action="<?= base_url('products/index_html') ?>" class="search">
            <p>Search: </p>
            <input type="text" name="name" placeholder="Product name...">
        </form>
        <h3>Categories</h3>
        <ul class="categories">
            <li><a href="#" data-id="">All</a></li>
            <?php foreach ($categories as $category) { ?>
                <li><a href="#" data-id="<?= $category['id'] ?>"><?= $category['name'] ?>(<?= $category['total_product'] ?>)</a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="items-header">
        <h2 class="category-name">All</h2>
        <form id="paginate-number-form" action="<?= base_url('products/index_html') ?>">
            <p>Paginated By: </p>
            <select id="item-per-page" name="item_per_page">
                <option value="3">3</option>
                <option value="9">9</option>
                <option value="12">12</option>
                <option value="15">15</option>
            </select>
        </form>
        <form id="order-form" action="<?= base_url('products/index_html') ?>">
            <p>Order: </p>
            <select id="select-order" name="order">
                <option value="ASC">Price: Low to High</option>
                <option value="DESC">Price: High to Low</option>
            </select>
        </form>
    </div>
    <div class="items"></div>
</main>