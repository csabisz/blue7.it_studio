<?php
session_start();
include("../functions.php");

$prod=new Production;

$data['orme_id']=$prod->xss_fix($_POST['orme_id']);
$data['plot_id']=$prod->xss_fix($_POST['plot_id']);

$prod->update_mask_plot(json_encode($data));

?>