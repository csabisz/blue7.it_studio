<div class="online_creators">	
	<div class="online_creators_title">
		Online creators - Your local time<div id="minimize_button"><i class="fas fa-plus-circle"></i></div>
	</div>		
	<div class="box text-left">				
	<?php 
	$creators=$prod->show_creators($_SESSION['lt_id']);
	//$walls_doors_windows_creators=$prod->get_walls_doors_windows_creators_default_company($_SESSION['lt_id']);
	//$furnishing_creators=$prod->get_furnishing_creators_default_company($_SESSION['lt_id']);
	//$render_still_creators=$prod->get_render_still_creators_default_company($_SESSION['lt_id']);
	//$server_date=date("Y-m-d");
	$creator_counter=0;
	
	for($i=0;$i<count($creators);$i++)
	{		
		if($creators[$i]['c_status']=="active")
		{
		$endtime=$prod->get_creator_end_time($creators[$i]['client_ID']);
	?>
		<div class="colorline all_creators pl-2 py-1">
			<div class="inline-flex">
                <b><?php 
                if(!empty($creators[$i]['c_last_name']))
                {
                    echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name'];
                }
                else
                {
                    echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name'];
                }?></b>
				
				<div id="creator_bubble_<?php echo $creator_counter;?>" class="bubble offline">
					<input type="hidden" id="<?php echo $creators[$i]['client_ID'];?>" class="creator_id" name="uca_<?php echo $creators[$i]['client_ID'];?>" value="offline">
				</div>
				- Time left: &nbsp;<span id="timeleft_<?php echo $creator_counter;?>" class="timeleft_<?php echo $creators[$i]['client_ID'];?>"><?php
					echo $endtime['end_time'];
					?></span>
			</div>	
			<br>
			<div class="inline-flex">
			- Next time starting at: &nbsp;<span id="timestart_<?php echo $creator_counter;?>" class="timestart_<?php echo $creators[$i]['client_ID'];?>"><?php
			$month=date("m");
			$year=date("Y");
			$day=date("d");
			$today=$prod->get_day_name($year,$month,$day);
			
			$nr_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			
			$nextday=$day+1;
			
			if($nextday>$nr_days_in_month)
			{
				$nextday=1;$month++;
			}
			
			$nextday_start=$prod->get_uca_program($creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
			if($today=="Friday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+2)]!="00:00")&&($nextday_start['work_start_time'.($nextday+2)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+2)])))
					{
						echo $year."-".$month."-0".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+2)]!="00:00")&&($nextday_start['work_start_time'.($nextday+2)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+2)])))
					{
						echo $year."-".$month."-".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
					}
					else
					{
						echo "No shift";
					}
				}
			}
			elseif($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
			?></span>
			</div>
		</div>		
	<?php
	$creator_counter++;
		}
	}			
	?>	
		<div class="row">
			<div class="col-md-12">
				<div class="text-danger pl-3" style="font-size:18px !important;"><b>Creators from other companies</b></div>
			</div>
		</div>
	<?php 
	$other_creators=$prod->show_creators_other_companies($_SESSION['lt_id']);
	//$walls_doors_windows_creators=$prod->get_walls_doors_windows_creators_default_company($_SESSION['lt_id']);
	//$furnishing_creators=$prod->get_furnishing_creators_default_company($_SESSION['lt_id']);
	//$render_still_creators=$prod->get_render_still_creators_default_company($_SESSION['lt_id']);
	//$server_date=date("Y-m-d");
	
	for($i=0;$i<count($other_creators);$i++)
	{		
		if($other_creators[$i]['c_status']=="active")
		{
		$endtime=$prod->get_creator_end_time($other_creators[$i]['client_ID']);
	?>
		<div class="colorline all_creators pl-2 py-1">
			<div class="inline-flex">
                <b><?php 
                if(!empty($other_creators[$i]['c_last_name']))
                {
                    echo $other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name']." - ".$prod->get_company($other_creators[$i]['lt_id'])['mailnick'];
                }
                else
                {
                    echo $other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name']." - ".$prod->get_company($other_creators[$i]['lt_id'])['mailnick'];
                }?></b>
				<div id="creator_bubble_<?php echo $creator_counter;?>" class="bubble offline">
					<input type="hidden" id="<?php echo $other_creators[$i]['client_ID'];?>" class="creator_id" name="uca_<?php echo $other_creators[$i]['client_ID'];?>" value="offline">
				</div>			
				- Time left: &nbsp;<span id="timeleft_<?php echo $creator_counter;?>" class="timeleft_<?php echo $other_creators[$i]['client_ID'];?>"><?php
					echo $endtime['end_time'];
					?></span>
			</div>	
			<br>
			<div class="inline-flex">
			- Next time starting at:&nbsp;<span id="timestart_<?php echo $creator_counter;?>" class="timestart_<?php echo $other_creators[$i]['client_ID'];?>"><?php
			$month=date("m");
			$year=date("Y");
			$day=date("d");
			$today=$prod->get_day_name($year,$month,$day);
			
			$nr_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			
			$nextday=$day+1;
			
			if($nextday>$nr_days_in_month)
			{
				$nextday=1;$month++;
			}
			
			$nextday_start=$prod->get_uca_program($other_creators[$i]['client_ID'],$month,$year);
			
			if($today=="Friday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+2)]!="00:00")&&($nextday_start['work_start_time'.($nextday+2)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+2)])))
					{
						echo $year."-".$month."-0".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+2)]!="00:00")&&($nextday_start['work_start_time'.($nextday+2)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+2)])))
					{
						echo $year."-".$month."-".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
					}
					else
					{
						echo "No shift";
					}
				}
			}
			elseif($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
			?></span>
			</div>
		</div>		
	<?php
	$creator_counter++;
		}
	}			
	?>		
	</div>
</div>