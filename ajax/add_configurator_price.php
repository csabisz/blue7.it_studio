<?php

include('../functions.php');
$prod = new Production;


$ho_id = $_GET['ho_id'];
$table = $_GET['table'];
$item_id_name = $_GET['item_id_name'];
$item_id = $_GET['item_id'];
//$mm_id = $_GET['mm_id'];
$price = $_GET['price'];

$prod->add_configurator_price($ho_id, $table, $item_id_name, $item_id, $price);

?>

<div id="success_price_msg" class="alert alert-success mt-4" role="alert">
    Swatch added
</div>

<script type="text/javascript">

    // function sleep(ms) {
    //     return new Promise(resolve => setTimeout(resolve, ms));
    // }
    //
    //
    // async function f () {
    //     await sleep(2500);
    //     $('#success_price_msg').remove()
    //
    // }

    // f();
</script>




