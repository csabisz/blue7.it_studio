<?php
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$user_id=$prod->xss_fix($_POST['user_id']);

$prod->update_o_special_agreement_price_changed_by($o_id,$user_id);

?>