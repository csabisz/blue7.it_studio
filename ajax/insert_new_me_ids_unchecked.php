<?php
include('../functions.php');
$prod = new Production;


$me_id = $_GET['new_me_id'];
$ho_id = $_GET['ho_id'];


$prod->remove_me_id_from_ho_id($ho_id, $me_id);

?>

<div id="success_element_message" class="alert alert-danger mt-4" role="alert">
    Element was deleted.
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