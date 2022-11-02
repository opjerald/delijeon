<nav class="users">
    <div class="container">
        <ul class="menu">
            <?php foreach ($menus as $menu) { ?>
                <?php if ($menu == 'title') { ?>
                    <li>
                        <h2 class="title"><a href="<?= base_url('home') ?>">Delijeon</a></h2>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="<?= base_url($menu['url']) ?>" <?= explode('(', $menu['name'])[0] == $selected_menu['menu'] ? "class='selected'" : "" ?>>
                            <i class="<?= $menu['icon'] ?>"> </i>
                            <small><?= $menu['name'] ?></small>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</nav>