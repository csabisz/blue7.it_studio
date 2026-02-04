<?php
include('../functions.php');
$prod=new Production;

$data['orf_id']=$prod->xss_fix($_POST['orf_id']);
$data['orf_path_dom']=$prod->xss_fix($_POST['iframe_link']);

if(!empty($data['orf_path_dom']))
{
    $prod->update_iframe_link(json_encode($data));
}
?>