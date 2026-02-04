<?php
include('../functions.php');

$prod=new Production;

if(!empty($_POST['orf_id']))
{
    $orf_id=$prod->xss_fix($_POST['orf_id']);
    $orf_vimeo_link=$prod->xss_fix($_POST['orf_vimeo_link']);

    $prod->update_orf_vimeo_link($orf_id,$orf_vimeo_link);
}
?>