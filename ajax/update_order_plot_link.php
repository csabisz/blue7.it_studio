<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$plot_link=$prod->xss_fix($_POST['plot_link']);

$prod->update_order_plot_link($o_id,$plot_link);

?>