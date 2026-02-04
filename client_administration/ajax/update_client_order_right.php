<?php

include '../../functions.php';

$prod = new Production();

$prod->update_client_order_right($_POST['right'], $_POST['state'], 'u_' . $_POST['client_id']);

?>


<div id="rights-removed-success-msg-lower" style="display: none" class="alert alert-success"
     role="alert">
    Rights have been removed
</div>