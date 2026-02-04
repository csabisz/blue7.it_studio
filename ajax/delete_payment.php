<?php
session_start();
include('../functions.php');
include('../domenia_db3.php');

$prod=new Production;
$domenia3=new Domenia3;

$pay_id=$prod->xss_fix($_POST['pay_id']);

$domenia3->delete_payment($pay_id); //deleting from db
?>