<?php
include('../functions.php');
$prod = new Production;

$of_id = $prod->xss_fix($_POST['of_id']);

$prod->delete_customer_file($of_id);
?>
