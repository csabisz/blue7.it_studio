<?php
session_start();
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);
$correction_amendment=$prod->xss_fix($_GET['correction_amendment']);

if(!empty($o_id))
{
    
if($correction_amendment=="correction")
{
    $prod->update_o_correction($o_id, 1);
    $prod->update_o_amendment($o_id, 0);
}
else
{
    $prod->update_o_correction($o_id, 0);
    $prod->update_o_amendment($o_id, 1);
}

}

?>