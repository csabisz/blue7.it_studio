<?php
include('../functions.php');

$prod=new Production;

if((isset($_POST['o_id']))&&(isset($_POST['suntour'])))
{
    $o_id=$prod->xss_fix($_POST['o_id']);
    $suntour=$prod->xss_fix($_POST['suntour']);

    $prod->update_o_suntour($o_id,$suntour);
}
?>