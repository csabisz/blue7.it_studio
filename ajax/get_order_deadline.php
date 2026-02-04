<?php
include("../functions.php");

$prod=new Production;

$o_deadline=$prod->xss_fix($_GET['o_deadline']);
$client_time_zone=$prod->xss_fix($_GET['client_time_zone']);

//converting to client time

$userTimezone = new DateTimeZone($client_time_zone);
$utcTimezone = new DateTimeZone('UTC');

$mystartDateTime = new DateTime($o_deadline, $utcTimezone);
$startoffset = $userTimezone->getOffset($mystartDateTime);
$mystartInterval=DateInterval::createFromDateString((string)$startoffset . 'seconds');
$mystartDateTime->add($mystartInterval);
echo $startresult = $mystartDateTime->format('Y-m-d H:i:s');
?>