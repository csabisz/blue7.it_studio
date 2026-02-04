<?php

include('../functions.php');
$prod = new Production;


$table = $_GET['table'];
$item_id_name = $_GET['item_id_name'];
$item_id = $_GET['item_id'];
$price = $_GET['price'];

$prod->change_configurator_price($table, $item_id_name, $item_id, $price);

?>

<div id="success_price_msg" class="alert alert-success mt-4" role="alert">
    Price has been successfully changed
</div>

    <script type="text/javascript">

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }


        async function f () {
            await sleep(2500);
            $('#success_price_msg').remove()

        }

        f();
    </script>




