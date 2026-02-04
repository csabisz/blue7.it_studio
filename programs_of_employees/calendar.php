<?php

session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');


?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white mt-5 p-3 text-center">
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{
			if(isset($_GET['client_id']))
			{
				if(isset($_POST['save_btn']))
				{
					$uca_id=$prod->xss_fix($_POST['client_id']);
					$month=$prod->xss_fix($_POST['selected_month']);
					$year=$prod->xss_fix($_POST['selected_year']);
					
					$user_timezone=$_POST['user_timezone'];
                    
                    for($d=1;$d<=31;$d++)
                    {
                        if($d<10)
                        {
                            if(($_POST['work_start_time'.$d]!="Free")&&($_POST['work_start_time'.$d]!="On vacation"))
                            {
                                $start_time_data['work_start_time'.$d]=$prod->convert_date_to_utc_time($year."-".$month."-0".$d." ".$prod->xss_fix($_POST['work_start_time'.$d]),$user_timezone);
                            }
                            else
                            {
                                $start_time_data['work_start_time'.$d]=$prod->xss_fix($_POST['work_start_time'.$d]);
                            }

                            if(($_POST['work_end_time'.$d]!="Free")&&($_POST['work_end_time'.$d]!="On vacation"))
                            {
                                $end_time_data['work_end_time'.$d]=$prod->convert_date_to_utc_time($year."-".$month."-0".$d." ".$prod->xss_fix($_POST['work_end_time'.$d]),$user_timezone);
                            }
                            else
                            {
                                $end_time_data['work_end_time'.$d]=$prod->xss_fix($_POST['work_end_time'.$d]);
                            }
                        }
                        else
                        {   
                            if(($_POST['work_start_time'.$d]!="Free")&&($_POST['work_start_time'.$d]!="On vacation"))
                            {
                                $start_time_data['work_start_time'.$d]=$prod->convert_date_to_utc_time($year."-".$month."-".$d." ".$prod->xss_fix($_POST['work_start_time'.$d]),$user_timezone);
                            }
                            else
                            {
                                $start_time_data['work_start_time'.$d]=$prod->xss_fix($_POST['work_start_time'.$d]);
                            }

                            if(($_POST['work_end_time'.$d]!="Free")&&($_POST['work_end_time'.$d]!="On vacation"))
                            {
                                $end_time_data['work_end_time'.$d]=$prod->convert_date_to_utc_time($year."-".$month."-".$d." ".$prod->xss_fix($_POST['work_end_time'.$d]),$user_timezone);
                            }
                            else
                            {
                                $end_time_data['work_end_time'.$d]=$prod->xss_fix($_POST['work_end_time'.$d]);
                            }
                        }
                    }

                    

					$uca_program=$prod->check_uca_program($uca_id,$month,$year);
					//echo "nr=".count($uca_program);
					
					if(count($uca_program)>0)
					{
						$prod->update_uca_program($uca_id,$year,$month,json_encode($start_time_data),json_encode($end_time_data));
					}
					else
					{
						$prod->create_uca_program($uca_id,$year,$month,json_encode($start_time_data),json_encode($end_time_data));
					}
					
					?>
					<div class="text-center"><div class="alert alert-success">Saved successfully !</div></div>
					<meta http-equiv="refresh" content="2; url=index.php">
					<?php
				}
				
				$uca_id=$prod->xss_fix($_GET['client_id']);
				if(isset($_GET['month']))
				{
					$month=$prod->xss_fix($_GET['month']);
				}
				else
				{
					$month=date("m");
				}
				
				if(isset($_GET['year']))
				{
					$year=$prod->xss_fix($_GET['year']);
				}
				else
				{
					$year=date("Y");
				}
				//$month2=date("n");
				$creator=$prod->get_client($uca_id);
			?>
            <h3 class="py-5">Programs of employees - <?php 
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }
			//echo $my_timezone=date_default_timezone_get();
			?> - 
			<select name="months" id="months" onchange="if (this.value) window.location.href=this.value">
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=01<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="01")?"selected":"";?>>January</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=02<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="02")?"selected":"";?>>February</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=03<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="03")?"selected":"";?>>March</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=04<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="04")?"selected":"";?>>April</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=05<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="05")?"selected":"";?>>May</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=06<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="06")?"selected":"";?>>June</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=07<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="07")?"selected":"";?>>July</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=08<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="08")?"selected":"";?>>August</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=09<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="09")?"selected":"";?>>September</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=10<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="10")?"selected":"";?>>October</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=11<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="11")?"selected":"";?>>November</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?>month=12<?php echo (isset($_GET['yeah']))?"&year=".$year:"&year=".$year;?>" <?php echo ($month=="12")?"selected":"";?>>December</option>
			</select> 
			<select name="years" id="years" onchange="if (this.value) window.location.href=this.value">
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?><?php echo (isset($_GET['month']))?"month=".$month."&":"month=".$month."&";?>year=2017" <?php echo ($year==2017)?"selected":"";?>>2017</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?><?php echo (isset($_GET['month']))?"month=".$month."&":"month=".$month."&";?>year=2018" <?php echo ($year==2018)?"selected":"";?>>2018</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?><?php echo (isset($_GET['month']))?"month=".$month."&":"month=".$month."&";?>year=2019" <?php echo ($year==2019)?"selected":"";?>>2019</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?><?php echo (isset($_GET['month']))?"month=".$month."&":"month=".$month."&";?>year=2020" <?php echo ($year==2020)?"selected":"";?>>2020</option>
				<option value="calendar.php?<?php echo (isset($_GET['client_id']))?"client_id=".$uca_id."&":"";?><?php echo (isset($_GET['month']))?"month=".$month."&":"month=".$month."&";?>year=2021" <?php echo ($year==2021)?"selected":"";?>>2021</option>
			</select></h3>
			<form name="programs_of_employees_form" action="calendar.php?client_id=<?php echo $uca_id;?>&month=<?php echo $month;?>&year=<?php echo $year; ?>" method="post">
			<input type="hidden" name="client_id" value="<?php echo $uca_id;?>">
			<input type="hidden" name="selected_month" value="<?php echo $month;?>">
			<input type="hidden" name="selected_year" value="<?php echo $year;?>">
			<?php
			$nr_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$uca_program=$prod->get_uca_program($uca_id,$month,$year);
			
			?>
			<table class="mx-auto">
				<tr class="weekdays">
			<?php
			for($i=1;$i<=7;$i++)
			{
				$selected_day=$prod->get_day_name($year,$month,$i);
				?>
				<td><?php echo $selected_day;?></td>
				<?php
			}
			?>
				</tr>
            <tr>    
			<?php
			for($i=1;$i<=$nr_days_in_month;$i++)
			{
				$selected_day=$prod->get_day_name($year,$month,$i);
				$db_start_column="work_start_time".$i;
				$db_end_column="work_end_time".$i;
				?>
				<td class="days"><span ><?php echo $i; ?></span>
					<br>					
					<?php 
					if(($selected_day!="Sunday")/*&&($selected_day!="Saturday")*/)
					{	
					?>
					<div class="inline-flex">
                    <!-- <input type="text" name="work_start_time<?php echo $i;?>" list="work_start_time<?php echo $i;?>_list" id="work_start_time<?php echo $i;?>" value="<?php echo $uca_program[$db_start_column]; ?>" data-db="<?php echo $db_start_column; ?>" style="width:5em;" class="form-control form-control-sm" placeholder="Start:"> -->
                    <select id="work_start_time<?php echo $i;?>" name="work_start_time<?php echo $i;?>" class="form-control form-control-sm" style="width:6em;">
                        <option value="">Start:</option>
                        <option value="Free" <?php echo ($uca_program[$db_start_column]=="Free")?"selected":"";?>>Free</option>
                        <option value="On vacation" <?php echo ($uca_program[$db_start_column]=="On vacation")?"selected":"";?>>On vacation</option>
                        <option value="07:00" <?php echo ($uca_program[$db_start_column]=="07:00")?"selected":"";?>>07:00</option>
                        <option value="07:30" <?php echo ($uca_program[$db_start_column]=="07:30")?"selected":"";?>>07:30</option>
                        <option value="08:00" <?php echo ($uca_program[$db_start_column]=="08:00")?"selected":"";?>>08:00</option>
                        <option value="08:30" <?php echo ($uca_program[$db_start_column]=="08:30")?"selected":"";?>>08:30</option>
                        <option value="09:00" <?php echo ($uca_program[$db_start_column]=="09:00")?"selected":"";?>>09:00</option>
                        <option value="09:30" <?php echo ($uca_program[$db_start_column]=="09:30")?"selected":"";?>>09:30</option>
                        <option value="10:00" <?php echo ($uca_program[$db_start_column]=="10:00")?"selected":"";?>>10:00</option>
                        <option value="10:30" <?php echo ($uca_program[$db_start_column]=="10:30")?"selected":"";?>>10:30</option>
                        <option value="11:00" <?php echo ($uca_program[$db_start_column]=="11:00")?"selected":"";?>>11:00</option>
                        <option value="11:30" <?php echo ($uca_program[$db_start_column]=="11:30")?"selected":"";?>>11:30</option>
                        <option value="12:00" <?php echo ($uca_program[$db_start_column]=="12:00")?"selected":"";?>>12:00</option>
                        <option value="12:30" <?php echo ($uca_program[$db_start_column]=="12:30")?"selected":"";?>>12:30</option>
                        <option value="13:00" <?php echo ($uca_program[$db_start_column]=="13:00")?"selected":"";?>>13:00</option>
                        <option value="13:30" <?php echo ($uca_program[$db_start_column]=="13:30")?"selected":"";?>>13:30</option>
                        <option value="14:00" <?php echo ($uca_program[$db_start_column]=="14:00")?"selected":"";?>>14:00</option>
                        <option value="14:30" <?php echo ($uca_program[$db_start_column]=="14:30")?"selected":"";?>>14:30</option>
                        <option value="15:00" <?php echo ($uca_program[$db_start_column]=="15:00")?"selected":"";?>>15:00</option>
                        <option value="15:30" <?php echo ($uca_program[$db_start_column]=="15:30")?"selected":"";?>>15:30</option>
                        <option value="16:00" <?php echo ($uca_program[$db_start_column]=="16:00")?"selected":"";?>>16:00</option>
                    </select>
                     - 
                    <select name="work_end_time<?php echo $i;?>" id="work_end_time<?php echo $i;?>" class="form-control form-control-sm" style="width:6em;">
                        <option value="">End:</option>
                        <option value="Free" <?php echo ($uca_program[$db_end_column]=="Free")?"selected":"";?>>Free</option>
                        <option value="On vacation" <?php echo ($uca_program[$db_end_column]=="On vacation")?"selected":"";?>>On vacation</option>
                        <option value="14:00" <?php echo ($uca_program[$db_end_column]=="14:00")?"selected":"";?>>14:00</option>
                        <option value="14:30" <?php echo ($uca_program[$db_end_column]=="14:30")?"selected":"";?>>14:30</option>
                        <option value="15:00" <?php echo ($uca_program[$db_end_column]=="15:00")?"selected":"";?>>15:00</option>
                        <option value="15:30" <?php echo ($uca_program[$db_end_column]=="15:30")?"selected":"";?>>15:30</option>
                        <option value="16:00" <?php echo ($uca_program[$db_end_column]=="16:00")?"selected":"";?>>16:00</option>
                        <option value="16:30" <?php echo ($uca_program[$db_end_column]=="16:30")?"selected":"";?>>16:30</option>
                        <option value="17:00" <?php echo ($uca_program[$db_end_column]=="17:00")?"selected":"";?>>17:00</option>
                        <option value="17:30" <?php echo ($uca_program[$db_end_column]=="17:30")?"selected":"";?>>17:30</option>
                        <option value="18:00" <?php echo ($uca_program[$db_end_column]=="18:00")?"selected":"";?>>18:00</option>
                        <option value="18:30" <?php echo ($uca_program[$db_end_column]=="18:30")?"selected":"";?>>18:30</option>
                        <option value="19:00" <?php echo ($uca_program[$db_end_column]=="19:00")?"selected":"";?>>19:00</option>
                        <option value="19:30" <?php echo ($uca_program[$db_end_column]=="19:30")?"selected":"";?>>19:30</option>
                        <option value="20:00" <?php echo ($uca_program[$db_end_column]=="20:00")?"selected":"";?>>20:00</option>
                        <option value="20:30" <?php echo ($uca_program[$db_end_column]=="20:30")?"selected":"";?>>20:30</option>
                        <option value="21:00" <?php echo ($uca_program[$db_end_column]=="21:00")?"selected":"";?>>21:00</option>
                        <option value="21:30" <?php echo ($uca_program[$db_end_column]=="21:30")?"selected":"";?>>21:30</option>
                        <option value="22:00" <?php echo ($uca_program[$db_end_column]=="22:00")?"selected":"";?>>22:00</option>
                        <option value="22:30" <?php echo ($uca_program[$db_end_column]=="22:30")?"selected":"";?>>22:30</option>
                        <option value="23:00" <?php echo ($uca_program[$db_end_column]=="23:00")?"selected":"";?>>23:00</option>
                        <option value="23:30" <?php echo ($uca_program[$db_end_column]=="23:30")?"selected":"";?>>23:30</option>
                        <option value="00:00" <?php echo ($uca_program[$db_end_column]=="00:00")?"selected":"";?>>00:00</option>
                    </select>
                    <!-- <input type="text" id="work_end_time<?php echo $i;?>" name="work_end_time<?php echo $i;?>" value="<?php echo $uca_program[$db_end_column]; ?>" data-db="<?php echo $db_end_column;?>" style="width:5em;" class="form-control form-control-sm" placeholder="End:"> -->
                    <input type="hidden" id="db_work_start_time<?php echo $i;?>" value="<?php echo $uca_program[$db_start_column];?>">
                    <input type="hidden" id="db_work_end_time<?php echo $i;?>" value="<?php echo $uca_program[$db_end_column];?>">
                    </div>
                    
					<?php
					}
					?>
				</td>
				
				<?php
				if($i % 7==0)
				{
					?>
					</tr><tr>
					<?php
				}
			}
			?>
			</tr>
			</table>
			<input type="hidden" id="user_timezone" name="user_timezone" value="">
			<div class="center_message w-100 mx-0 mt-3">
				<button type="submit" name="save_btn" class="btn btn-sm btn-primary">Save</button>
			</div>
			</form>
			<script type="text/javascript">
			$(document).ready(function(){
				$.datetimepicker.setLocale('en');
				var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
				$('#user_timezone').val(user_timezone);
				
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();

				if(dd<10) {
					dd = '0'+dd
				} 

				if(mm<10) {
					mm = '0'+mm
				} 

				today = yyyy + '-' + mm + '-' + dd;
				console.log(today);
			
				
				for(var i=1;i<=31;i++)
				{
					var start_time = moment.tz(today+' '+$('#db_work_start_time'+i).val(),'UTC');
					var new_start_time = start_time.clone().tz(user_timezone).format('HH:mm');
                    //console.log(new_start_time);
					$('#work_start_time'+i+' option[value="'+new_start_time+'"]').prop("selected",true);
					
					var end_time = moment.tz(today+' '+$('#db_work_end_time'+i).val(),'UTC');
					var new_end_time = end_time.clone().tz(user_timezone).format('HH:mm');
					$('#work_end_time'+i+' option[value="'+new_end_time+'"]').prop("selected",true);
					
					/*$('#work_start_time'+i).datetimepicker({
						lang:'en',
						format:'H:i',
						datepicker:false,
						formatTime:'H:i',
						step: 15,	
						allowTimes:[
						  '7:00', '8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00','15:00', '16:00','Free'
						 ]
					});
					
					$('#work_end_time'+i).datetimepicker({
						lang:'en',
						format:'H:i',
						datepicker:false,
						formatTime:'H:i',
						step: 15,	
						allowTimes:[
						  '14:00','15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00','00:00','Free'
						 ]
					});*/
                }
			});
			</script>
			<?php
			//include('../online_creators.php');
			}
		}
		else
		{
            session_unset();
            session_destroy();
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
		</div>	<!-- end container -->
	</article>
</section>
<?php
include('../footer.php');
?>