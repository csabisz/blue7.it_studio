<?php
include('../functions.php');

$prod=new Production;

$data['mc_id'] = $prod->xss_fix($_POST['mc_id']);
$data['text_1_name'] = $prod->xss_fix($_POST['text_1_name']);
$data['text_1_long'] = $prod->xss_fix($_POST['text_1_long']);
$data['text_2_name'] = $prod->xss_fix($_POST['text_2_name']);
$data['text_2_long'] = $prod->xss_fix($_POST['text_2_long']); 

$existing_main_client_colors=$prod->get_main_client_colors($data['mc_id']);

if(!empty($existing_main_client_colors))
{
    $prod->update_main_client_texts(json_encode($data));
}
else
{
    $prod->create_main_client_texts(json_encode($data));
}
?>
Saved successfully !