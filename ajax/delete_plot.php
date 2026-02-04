<?php
session_start();
include('../functions.php');

$prod=new Production;

$plot_id=$prod->xss_fix($_POST['plot_id']);

$prod->delete_plot($plot_id);
?>