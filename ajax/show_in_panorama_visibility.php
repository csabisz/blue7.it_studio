<?php
include('../functions.php');
$prod=new Production;

echo $orf_id=$prod->xss_fix($_GET['orf_id']);
echo $show_in_panorama_status=$prod->xss_fix($_GET['show_in_panorama_status']);


$prod->update_o_results_show_in_panorama_status($orf_id,$show_in_panorama_status);

?>