<?php
include('../functions.php');
$prod=new Production;

$data['orf_id']=$prod->xss_fix($_POST['orf_id']);
$data['o_id_full']=$prod->xss_fix($_POST['o_id']).".".$prod->xss_fix($_POST['osub_id']).".".$prod->xss_fix($_POST['prod_id']);
$data['pa_id']=$prod->xss_fix($_POST['pa_id']);
$data['pa_symbol']=$prod->xss_fix($_POST['pa_symbol']);
$data['connected_to']=$prod->xss_fix($_POST['connected_to']);

$check_o_results_configurator_plus=$prod->get_o_results_configurator_plus($data['orf_id']);

if(!empty($check_o_results_configurator_plus))
{
    $prod->update_o_results_configurator_plus(json_encode($data));
}
else
{
    $prod->insert_o_results_configurator_plus(json_encode($data));
}
?>