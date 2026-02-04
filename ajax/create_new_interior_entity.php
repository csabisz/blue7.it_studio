<?php
session_start();
include("../functions.php");

$prod=new Production;

$save_interior_entity_data['o_id']=$prod->xss_fix($_POST['o_id']);
$save_interior_entity_data['e_n_level']=$prod->xss_fix($_POST['new_e_n_level_input']);
$save_interior_entity_data['e_n_name']=$prod->xss_fix($_POST['new_e_n_name_input']);
$save_interior_entity_data['e_n_size_total']=$prod->xss_fix($_POST['new_e_n_size_total_input']);
$save_interior_entity_data['e_n_size_usable']=$prod->xss_fix($_POST['new_e_n_size_usable_input']);
$save_interior_entity_data['e_n_price']=$prod->xss_fix($_POST['new_e_n_price_input']);
$save_interior_entity_data['e_n_status']=$prod->xss_fix($_POST['new_e_n_status_input']);

if(!empty($save_interior_entity_data['o_id']))
{
    $prod->add_interior_entities(json_encode($save_interior_entity_data));
}
?>