<section class="hero">
    <div>
        <h1><?= $selected_menu['hero'] ?></h1>
        <div class="path">
            <small><a href="<?= base_url('products') ?>">Home</a></small>
            <small>/</small>
            <small> <a href="<?= base_url(strtolower($selected_menu['menu'])) ?>"><?= $selected_menu['menu'] ?></a></small>
        </div>
    </div>
</section>