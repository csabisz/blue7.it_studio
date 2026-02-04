<?php
include('../functions.php');
$prod=new Production;

$data['orf_id']=$prod->xss_fix($_POST['orf_id']);
$data['config_level']=$prod->xss_fix($_POST['config_level']);
$data['o_id_full']=$prod->xss_fix($_POST['o_id']).".".$prod->xss_fix($_POST['osub_id']).".".$prod->xss_fix($_POST['prod_id']);

$prod->update_orf_id_config_level(json_encode($data));

$o_results_configurator_plus=$prod->get_o_results_configurator_plus($data['orf_id']);

if(!empty($o_results_configurator_plus))
{
    $prod->update_o_results_configurator_plus(json_encode($data));
}
else
{
    $prod->insert_o_results_configurator_plus(json_encode($data));
}
?>