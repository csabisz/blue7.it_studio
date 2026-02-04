<?php
include("../functions.php");

$prod=new Production;


$save_interior_entity_data['e_n_id']=$prod->xss_fix($_POST['e_n_id']);
$save_interior_entity_data['e_n_level']=$prod->xss_fix($_POST['update_e_n_level_input']);
$save_interior_entity_data['e_n_name']=$prod->xss_fix($_POST['update_e_n_name_input']);
$save_interior_entity_data['e_n_size_total']=$prod->xss_fix($_POST['update_e_n_size_total_input']);
$save_interior_entity_data['e_n_size_usable']=$prod->xss_fix($_POST['update_e_n_size_usable_input']);
$save_interior_entity_data['e_n_price']=$prod->xss_fix($_POST['update_e_n_price_input']);
$save_interior_entity_data['e_n_status']=$prod->xss_fix($_POST['update_e_n_status_input']);

$prod->update_interior_entity(json_encode($save_interior_entity_data));
?>