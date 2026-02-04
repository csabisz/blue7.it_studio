<?php
include('../functions.php');
$prod=new Production;

$data['orf_id']=$prod->xss_fix($_POST['orf_id']);
$data['vr_link']=$prod->xss_fix($_POST['vr_link']);

if(!empty($data['orf_id']))
{
    $prod->update_vr_link(json_encode($data));
}
?>