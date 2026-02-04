<?php
include('../functions.php');

$prod=new Production;

$msg_id=$prod->xss_fix($_POST['msg_id']);
$message=$prod->xss_fix($_POST['message']);
$user_id=$prod->xss_fix($_POST['user_id']);

$prod->update_creator_message($msg_id,$message,$user_id);

echo "Message updated!";
?>