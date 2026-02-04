<?php
include('../functions.php');

$prod=new Production;

$timezone=$prod->xss_fix($_GET['timezone']);
$endtime=$prod->get_creator_end_time($_GET['uca_id']);

$now = date_create(null, timezone_open('Europe/Bucharest'));
$future_date = date_create($endtime['end_time']);

$interval = date_diff($future_date,$now);

// echo $now->format("h:i "); 
echo $interval->format("%h:%i"); 
?>