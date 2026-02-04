<?php
include('../functions.php');

$prod=new Production;

if((isset($_POST['o_id']))&&(isset($_POST['public'])))
{
    $o_id=$prod->xss_fix($_POST['o_id']);
    $public=$prod->xss_fix($_POST['public']);

    $prod->update_o_public($o_id,$public);
}
?>