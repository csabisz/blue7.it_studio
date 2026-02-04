<?php
include('../functions.php');
$prod = new Production;

$flt_id = $prod->xss_fix($_POST['flt_id']);

$prod->delete_ft_layout($flt_id);
?>