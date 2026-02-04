<?php

$ho_id = $_GET['ho_id'];

$menu_items = json_decode(file_get_contents('https://bauvorschau.com/api/configurator_check_menu/' . $ho_id), true);
foreach ($menu_items as $menu_item) {
    ?>
    <option value="<?php echo $menu_item['name']; ?>">
        <?php echo $menu_item['name']; ?></option>
    <?php
} ?>