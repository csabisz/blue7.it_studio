<?php
session_start();
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$notifications=$prod->xss_fix($_POST['notifications']);

if($notifications==1)
{
    echo $notifications=0;
}
elseif($notifications==0)
{
    echo $notifications=1;
}

$prod->update_o_notifications($o_id,$notifications);

?>