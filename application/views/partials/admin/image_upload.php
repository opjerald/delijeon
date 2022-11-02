<div class="img_card">
    <i class="bi bi-grip-horizontal"></i>
    <div class="img">
        <img src="<?= base_url("assets/images/$file_name") ?>" alt="images" class="tbl-image">
        <p><?= $file_name ?></p>
    </div>
    <div class="action">
        <button type="button"><i class="bi bi-trash-fill remove"></i></button>
        <label><input type="checkbox" name="main" id="chk_main"> Main</label>
    </div>
</div>