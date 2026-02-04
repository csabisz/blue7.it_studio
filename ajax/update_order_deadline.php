<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$o_deadline=$prod->xss_fix($_POST['o_deadline']);
$client_time_zone=$prod->xss_fix($_POST['client_time_zone']);

//converting to UTC time

$userTimezone = new DateTimeZone($client_time_zone);
$utcTimezone = new DateTimeZone('UTC');

$mystartDateTime = new DateTime($o_deadline, $utcTimezone);
$startoffset = $userTimezone->getOffset($mystartDateTime);
$mystartInterval=DateInterval::createFromDateString((string)$startoffset . 'seconds');
$mystartDateTime->sub($mystartInterval);
$startresult = $mystartDateTime->format('Y-m-d H:i:s');


//$prod->update_o_deadline($o_id,$startresult);
$prod->update_o_deadline($o_id,$o_deadline);
?>