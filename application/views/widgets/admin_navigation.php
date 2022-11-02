<nav class="admin">
    <div class="container">
        <h1 class="nav-title"><a href="<?= base_url("dashboard/products") ?>">Delijeon</a></h1>
        <ul>
            <?php foreach ($menus as $key => $menu) { ?>
                <li>
                    <a href="<?= base_url($menu['url']) ?>" <?= $key == 2 ? "class='btn'" : "" ?>><?= $menu['name'] ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>