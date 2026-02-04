<?php
include('../functions.php');
$prod=new Production;

$data['orf_id']=$prod->xss_fix($_POST['orf_id']);
$data['suntour_model_id']=$prod->xss_fix($_POST['suntour_model_id']);

if(!empty($data['orf_id']))
{
    $prod->update_suntour_model_id(json_encode($data));
}
?>