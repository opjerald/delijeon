<main class="dashboard">
    <div class="controls">
        <form id="search_form" class="form__group input">
            <input type="text" class="form__field" placeholder="something" id='search' name="name" />
            <label for="search" class="form__label">Search by Name</label>
        </form>
        <button type="button" class="trigger">Add New Product</button>
    </div>
    <table class="products">
    </table>
</main>
<!-- Add Modal -->
<div class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add new product</h2>
            <span class="close-button"><i class="bi bi-x"></i></span>
        </div>
        <form id="add_form" class="modal-body" action="<?= base_url("products/save") ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="">
            <div class="fields">
                <div class="form__group input">
                    <input type="text" class="form__field field" placeholder="something" id='search' name="name" />
                    <label for="name" class="form__label">Name</label>
                </div>
                <div class="form_group input">
                    <textarea name="description" class="form__field" placeholder="Description" id="description" name="description"></textarea>
                </div>
                <div class="form_group input">
                    <div class="dropdown">
                        <div class="form__group input">
                            <input type="hidden" name="category_id" value="">
                            <input type="text" class="form__field dropdown_input field" placeholder="something" name="category" id='category' readonly />
                            <label for="category" class="form__label">Category</label>
                        </div>
                        <div class="options">
                            <?php foreach ($categories as $category) { ?>
                                <div class="option">
                                    <p class="value" data-value="<?= $category['id'] ?>"><?= $category['name'] ?></p>
                                    <div class="actions">
                                        <i class="bi bi-pencil-square"></i>
                                        <i class="bi bi-trash3"></i>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="form__group input">
                    <input type="text" class="form__field" placeholder="something" id='price' name="price" />
                    <label for="price" class="form__label">Unit Price</label>
                </div>
                <div class="form__group input">
                    <input type="text" class="form__field" placeholder="something" id='quantity' name="quantity" />
                    <label for="quantity" class="form__label">Quantity</label>
                </div>
                <div class="form__group input">
                    <input type="text" class="form__field field" placeholder="something" id='new_category' name="new_category" />
                    <label for="new_category" class="form__label">New Category</label>
                </div>
                <button type="submit">Add Pastry</button>
            </div>
            <div class="images">
                <div class="upload">
                    <label for="file">Images:</label>
                    <input type="hidden" name="main" value="chocolate-cake.jpg">
                    <input type="file" name="files[]" id="img_upload" multiple accept=".png, .jpg, .gif">
                </div>
                <div class="img_sets"></div>
            </div>
        </form>
    </div>
</div>