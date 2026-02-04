<?php
include('../functions.php');
$prod = new Production;

$ft_3_id = $prod->xss_fix($_POST['ft_3_id']);

$prod->delete_furniture_set_4_units($ft_3_id);
?>