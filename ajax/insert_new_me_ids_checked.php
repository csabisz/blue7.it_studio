<?php
include('../functions.php');
$prod = new Production;


$me_id = $_GET['new_me_id'];
$ho_id = $_GET['ho_id'];


$prod->add_new_me_id_to_ho_id($ho_id, $me_id);



?>

<div id="success_element_message" class="alert alert-success mt-4" role="alert">
    Element successfully added.
</div>

<script id="sleep_script" type="text/javascript">

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }


    async function f () {
        await sleep(2500);
        $('#success_element_message').remove()
        $('#sleep_script').remove()

    }

    f();
</script>