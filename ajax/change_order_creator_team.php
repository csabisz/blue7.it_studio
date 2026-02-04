<?php
session_start();
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);
$team_id=$prod->xss_fix($_GET['team_id']);

$prod->update_order_creator_team($o_id,$team_id);
?>