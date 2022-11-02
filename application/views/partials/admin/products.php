<thead>
    <tr>
        <th>Image</th>
        <th>ID</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Sold</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($products as $product) { ?>
        <tr>
            <td><img src="<?= base_url("assets/images/{$product['main_image']}") ?>" alt="<?= $product['main_image'] ?>"></td>
            <td><?= $product['id'] ?></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['quantity'] ?></td>
            <td><?= $product['sold'] ?></td>
            <td class="action">
                <a href="#" class="edit" data-product-id="<?= $product['id'] ?>"><i class="bi bi-pencil-square"></i></a>
                <a href="<?= base_url("products/delete/{$product['id']}") ?>" class="delete"><i class="bi bi-trash3"></i></a>
            </td>
        </tr>
    <?php } ?>
</tbody>
<?php if (!empty($link_count) && $link_count > 1) { ?>
    <tfoot>
        <tr>
            <td>
                <?php if ($page != 1) { ?>
                    <a href="<?= base_url("products/index_html") ?>" class="prev-page"><i class="bi bi-chevron-left"></i></a>
                <?php } ?>
                <?php for ($i = 1; $i <= $link_count; $i++) { ?>
                    <a href="<?= base_url("products/index_html?page=$i") ?>" class="page <?= $page == $i ? "active" : '' ?>"><?= $i ?></a>
                <?php } ?>
                <?php if ($page != $link_count) { ?>
                    <a href="<?= base_url("products/index_html") ?>" class="next-page"><i class="bi bi-chevron-right"></i></a>
                <?php } ?>
            </td>
        </tr>
    </tfoot>
<?php } ?>