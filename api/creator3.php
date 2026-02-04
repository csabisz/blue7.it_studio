<?php

include("../functions.php");

$prod = new Production;



$client_time_zone = $_GET['timezone'];

$uca_id = $_GET['uca_id'];



function is_working_today($time)

{



    date_default_timezone_set('UTC');



    if (new DateTime($time) < new DateTime()) {



        return false;

    } else {

        return true;

    }

} 





/* function get_shift_end_client_time_zone($time, $client_time_zone)

{



    date_default_timezone_set('GMT');



    $GMT_time = date_create($time);



    date_default_timezone_set($client_time_zone);





    $client_time = date('Y-m-d H:i:s', date_timestamp_get($GMT_time));



    return $client_time;





} */





$today_working_hours = $prod->get_todays_working_hours_gm($uca_id)['end_time'];


//$CREATOR['shifts']['today_working_hours']=$today_working_hours;


date_default_timezone_set('GMT');



$current_time = time();

$working_hours_time = strtotime($today_working_hours);

$delta_time_stamp = $working_hours_time-$current_time;

$delta_time = date("H:i", $delta_time_stamp);





$server_day = date('d');

$server_month = date('m');

$server_year = date('Y');





$creator_shifts = $prod->get_uca_program($uca_id, $server_month, $server_year);



if ($server_day[0] == 0) $day = $server_day[1]; else $day = $server_day;



$next_day=++$day;
$next_day_dayname=date('l',strtotime($server_year.'-'.$server_month.'-'.$next_day));

if(($next_day_dayname=="Saturday")||($next_day_dayname=="Sunday"))
{
    ++$next_day;
}

if(!empty($creator_shifts['work_start_time' . $next_day]))
{
$userTimezone = new DateTimeZone($client_time_zone);
$utcTimezone = new DateTimeZone('UTC');
$databaseStartDateTime=$server_year.'-'.$server_month.'-'.$next_day. ' ' .  $creator_shifts['work_start_time' . $next_day] . ':00';
$myDateTime = new DateTime($databaseStartDateTime, $utcTimezone);
$offset = $userTimezone->getOffset($myDateTime);
$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
$myDateTime->add($myInterval);
$startresult = $myDateTime->format('Y-m-d H:i:s');
}

if(!empty($creator_shifts['work_end_time' . $next_day]))
{
$userTimezone = new DateTimeZone($client_time_zone);
$utcTimezone = new DateTimeZone('UTC');
$databaseEndDateTime=$server_year.'-'.$server_month.'-'.$next_day. ' ' .  $creator_shifts['work_end_time' . $next_day] . ':00';
$myDateTime = new DateTime($databaseEndDateTime, $utcTimezone);
$offset = $userTimezone->getOffset($myDateTime);
$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
$myDateTime->add($myInterval);
$endresult = $myDateTime->format('Y-m-d H:i:s');
}
//if (!empty($creator_shifts['work_start_time' . $day]) && !empty($creator_shifts['work_end_time' . $day])){

    //if (strtotime($server_day . '-' . $server_month . '-' . $server_year . ' ' . $creator_shifts['work_start_time'] . ":00") < $current_time){

        //if (!empty($creator_shifts['work_start_time' . $day++])){

            //$CREATOR['shifts']['next']['start'] = get_shift_end_client_time_zone($server_year.'-'.$server_month.'-'.$server_day. ' ' .  $creator_shifts['work_start_time' . $day++] . ':00', $client_time);

            //$CREATOR['shifts']['next']['end'] = get_shift_end_client_time_zone($server_year.'-'.$server_month.'-'.$server_day. ' ' .  $creator_shifts['work_end_time' . $day++] . ':00', $client_time);

            $CREATOR['shifts']['next']['start'] = $startresult;
            $CREATOR['shifts']['next']['end'] = $endresult;

        //}



    //}

//}



if (empty($CREATOR['shifts']['next']['end'])){

    //while (empty($creator_shifts['work_start_time' . $day]) && empty($creator_shifts['work_end_time' . $day])) {

        //if ($day > 31) {

            $CREATOR['shifts']['next']['start'] = 'No shift';

            $CREATOR['shifts']['next']['end'] = 'No shift';

            $CREATOR['shifts']['debug'] = true;

            //break;

        //}

        //$day++;

    //}

}


/*
if ($CREATOR['shifts']['next']['start'] != 'No shift') {



    $CREATOR['shifts']['next']['start'] = array();

    $CREATOR['shifts']['next']['end'] = array();



    $CREATOR['shifts']['next']['start'] = get_shift_end_client_time_zone($server_year.'-'.$server_month.'-'.$server_day. ' ' .  $creator_shifts['work_start_time' . $day] . ':00', $client_time);

    $CREATOR['shifts']['next']['end'] = get_shift_end_client_time_zone($server_year.'-'.$server_month.'-'.$server_day. ' ' .  $creator_shifts['work_end_time' . $day] . ':00', $client_time);



}*/





if (is_working_today($today_working_hours)){

    //goNext

    //$CREATOR['shifts']['to_day']['end'] = get_shift_end_client_time_zone($today_working_hours, $client_time);

    $CREATOR['shifts']['today']['left'] = $delta_time;

    $CREATOR['shifts']['today']['work'] = true;

}else{

    //findNextShift

    $CREATOR['shifts']['today']['end'] = 'No shift';

    $CREATOR['shifts']['today']['left'] = 'No shift';



}







header('Content-type:application/json');

print json_encode($CREATOR);





