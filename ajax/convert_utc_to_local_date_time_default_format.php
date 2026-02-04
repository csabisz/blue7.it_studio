<?php
session_start();
include('../functions.php');

$prod=new Production;

$o_date=$prod->xss_fix($_GET['o_date']);
$timezone=$prod->xss_fix($_GET['timezone']);

// Create DateTime object from UTC string
$utcDateTime = new DateTime($o_date, new DateTimeZone('UTC'));

// Set local timezone
$localTimeZone = new DateTimeZone($timezone);

// Set UTC timezone
$utcTimeZone = new DateTimeZone('UTC');

// Convert UTC DateTime to local DateTime
$localDateTime = $utcDateTime->setTimezone($localTimeZone);

// Format local DateTime as desired
echo $localDateString = $localDateTime->format('Y-m-d H:i:s');

// $date_time_array=explode(' ',$localDateString);

// echo "<b>".$date_time_array[0]."</b>, ";
// echo $date_time_array[1];
?>