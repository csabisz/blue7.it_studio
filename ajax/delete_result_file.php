<?php
include('../functions.php');
$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);

if(!empty($orf_id))
{
    $prod->delete_creator_file($orf_id);
    $prod->delete_o_results_configurator_plus($orf_id);
}
?>