<?php

include('../functions.php');
$prod = new Production;


$ho_id = $_GET['ho_id'];
$table = $_GET['table'];
$item_id_name = $_GET['item_id_name'];
$item_id = $_GET['item_id'];
$status = $_GET['status'];

$prod->activate_configurator_swatch($ho_id, $table, $item_id_name, $item_id, $status);

?>

<div id="success_status_msg" class="alert alert-success mt-4" role="alert">
    Swatch status changed;
</div>






