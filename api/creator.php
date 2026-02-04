<?php

include("../functions.php");

$prod = new Production;



$client_time_zone = $_GET['timezone'];

$uca_id = $_GET['uca_id'];


$CREATOR['shifts']['uca_id']=$uca_id;
$CREATOR['shifts']['client_time_zone']=$client_time_zone;

$today_working_hours = $prod->get_todays_working_hours_gm($uca_id)['end_time'];


//$CREATOR['shifts']['today_working_hours']=$today_working_hours;


date_default_timezone_set('UTC');



$current_time = time();

$working_hours_time = strtotime($today_working_hours);

$delta_time_stamp = $working_hours_time-$current_time;

$delta_time = date("H:i", $delta_time_stamp);


$CREATOR['shifts']['today_working_hours']=$today_working_hours;

if (!empty($today_working_hours)){

    //goNext

    //$CREATOR['shifts']['to_day']['end'] = get_shift_end_client_time_zone($today_working_hours, $client_time);

    $CREATOR['shifts']['today']['left'] = $delta_time;

    $CREATOR['shifts']['today']['work'] = true;

}else{

    //findNextShift

    $CREATOR['shifts']['today']['end'] = 'No shift';

    $CREATOR['shifts']['today']['left'] = 'No shift';



}

$server_day = date('d');

$server_month = date('m');

$server_year = date('Y');





$creator_shifts = $prod->get_uca_program($uca_id, $server_month, $server_year);



if ($server_day[0] == 0) $day = $server_day[1]; else $day = $server_day;

if(!empty($today_working_hours))
{
    $start_today=++$day;
    $found_time=0;

    while ($found_time==0) 
    {
        $CREATOR['shifts']['start_today'.$start_today]=$start_today;

        if ($start_today <= 31) 
        {
            if($creator_shifts['work_start_time' . $start_today]!="21:00")
            {
            if(!empty($creator_shifts['work_start_time' . $start_today]))
            {
            $userTimezone = new DateTimeZone($client_time_zone);
            $utcTimezone = new DateTimeZone('UTC');
            $databaseStartDateTime=$server_year.'-'.$server_month.'-'.$start_today. ' ' .  $creator_shifts['work_start_time' . $start_today] . ':00';
            $mystartDateTime = new DateTime($databaseStartDateTime, $utcTimezone);
            $startoffset = $userTimezone->getOffset($mystartDateTime);
            $mystartInterval=DateInterval::createFromDateString((string)$startoffset . 'seconds');
            $mystartDateTime->add($mystartInterval);
            $startresult = $mystartDateTime->format('Y-m-d H:i:s');
            $found_time++;
            }

            if(!empty($creator_shifts['work_end_time' . $start_today]))
            {
            $userTimezone = new DateTimeZone($client_time_zone);
            $utcTimezone = new DateTimeZone('UTC');
            $databaseEndDateTime=$server_year.'-'.$server_month.'-'.$start_today. ' ' .  $creator_shifts['work_end_time' . $start_today] . ':00';
            $myendDateTime = new DateTime($databaseEndDateTime, $utcTimezone);
            $endoffset = $userTimezone->getOffset($myendDateTime);
            $myendInterval=DateInterval::createFromDateString((string)$endoffset . 'seconds');
            $myendDateTime->add($myendInterval);
            $endresult = $myendDateTime->format('Y-m-d H:i:s');
            $found_time++;
            }

            $CREATOR['shifts']['next']['start'] = $startresult;
            $CREATOR['shifts']['next']['end'] = $endresult;
            }
        }
        else
        {
            $found_time++;
            $CREATOR['shifts']['next']['start'] = "No shift";
            $CREATOR['shifts']['next']['end'] = "No shift";
        }
        $start_today++;

    }
}
else
{
    $start_today=$day;
    $found_time=0;

    while ($found_time==0) 
    {
        $CREATOR['shifts']['start_today'.$start_today]=$start_today;

        if ($start_today <= 31) 
        {
            if($creator_shifts['work_start_time' . $start_today]!="21:00")
            {
            if(!empty($creator_shifts['work_start_time' . $start_today]))
            {
            $userTimezone = new DateTimeZone($client_time_zone);
            $utcTimezone = new DateTimeZone('UTC');
            $databaseStartDateTime=$server_year.'-'.$server_month.'-'.$start_today. ' ' .  $creator_shifts['work_start_time' . $start_today] . ':00';
            $mystartDateTime = new DateTime($databaseStartDateTime, $utcTimezone);
            $startoffset = $userTimezone->getOffset($mystartDateTime);
            $mystartInterval=DateInterval::createFromDateString((string)$startoffset . 'seconds');
            $mystartDateTime->add($mystartInterval);
            $startresult = $mystartDateTime->format('Y-m-d H:i:s');
            $found_time++;
            }

            if(!empty($creator_shifts['work_end_time' . $start_today]))
            {
            $userTimezone = new DateTimeZone($client_time_zone);
            $utcTimezone = new DateTimeZone('UTC');
            $databaseEndDateTime=$server_year.'-'.$server_month.'-'.$start_today. ' ' .  $creator_shifts['work_end_time' . $start_today] . ':00';
            $myendDateTime = new DateTime($databaseEndDateTime, $utcTimezone);
            $endoffset = $userTimezone->getOffset($myendDateTime);
            $myendInterval=DateInterval::createFromDateString((string)$endoffset . 'seconds');
            $myendDateTime->add($myendInterval);
            $endresult = $myendDateTime->format('Y-m-d H:i:s');
            $found_time++;
            }

            $CREATOR['shifts']['next']['start'] = $startresult;
            $CREATOR['shifts']['next']['end'] = $endresult;
            }
        }
        else
        {
            $found_time++;
            $CREATOR['shifts']['next']['start'] = "No shift";
            $CREATOR['shifts']['next']['end'] = "No shift";
        }
        $start_today++;

    }
}

header('Content-type:application/json');

print json_encode($CREATOR);