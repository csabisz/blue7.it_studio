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
	<div class="container mb-5 pagecontent bg-white px-0">
	<br>
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{
		?>	
            <h2 class="w-100 text-center mb-4">List of tasks</h2>
			<div>
			<?php
            
            $creators=$prod->get_all_creators();
			
			$num_creators=1;
            
            //getting creators team

            $check_creators_team=$prod->check_creators_team($_COOKIE['client_id']);

            $myteam=array();

            if(!empty($check_creators_team))
            {
                for($i=0;$i<count($check_creators_team);$i++)
                {
                    $myteam[]=$prod->get_team($check_creators_team[$i]['team_id']);
                }
            }
			?>
            
			<div class="row w-100 mx-0 border border-left-0 border-right-0">										
				<div class="col-md-4 border-right text-center py-2">
					<b>Name</b>
				</div>
				<div class="col-md-1 text-center py-2">
					<b>Tasks</b>
				</div>
			</div>
            
        <div id="myteam">
            <?php
            $num_team_creators=0;
            $global_counter=0;

            if(!empty($myteam))
            {
            ?>
            <br>
            <div class="row">
                <div class="col-md-12">
                <b>My team</b>
                </div>
            </div>
            <br>
            <div id="team_online_creators">
            </div>
			<?php
            }
            //showing creators team first if it has a team

        for($i=0;$i<count($myteam);$i++)
        {
            for($t=0;$t<count($myteam[$i]);$t++)
            {
                $creator=$prod->get_client($myteam[$i][$t]['u_id']);
                $creator_rights=$prod->get_client_rights($myteam[$i][$t]['u_id']);

                // print_r($creator);
                if(($creator_rights['u_status']=="active")&&($creator_rights['own_tasks']>0))
                {
                    $endtime=$prod->get_creator_end_time($creator['client_ID']);
                    ?>
                            <div class="all_team_creators colorline2">
                                <div id="all_team_creators_row<?php echo $num_team_creators;?>" class="row w-100 mx-0 border-bottom offline_border">										
                                    <div class="col-md-4 border-right py-2">
                                        <div class="d-inline-flex">
                                            <div id="tasks_creator_bubble_<?php echo $global_counter;?>" class="bubble offline mr-2"></div>
                                            <?php
                                            if(!empty($creator['c_last_name']))
                                            {
                                                echo $creator['c_first_name']." ".$creator['c_last_name'];
                                            }
                                            else
                                            {
                                                echo $creator['l_first_name']." ".$creator['l_last_name'];
                                            }
                                            echo " - ".$prod->get_company($creator['lt_id'])['mailnick'];
                                            ?> - Time left: &nbsp;<span id="creator_timeleft_<?php echo $global_counter;?>" class="task_list_creator_<?php echo $creator['client_ID'];?>"><?php
                                            
                                        
                                            echo $endtime['end_time'];?></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            Started: <span id="employees_programs_today_start<?php echo $global_counter;?>"><?php 
                                            
                                            $creator_today_start_time=$prod->get_creator_start_time($creator['client_ID']);
                                            
                                            echo $creator_today_start_time['start_time'];
                                            ?></span> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                Next: <?php
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
                                                
                                                $nextday_start=$prod->get_uca_program($creator['client_ID'],$month,$year);
                                                
                                                // 00:00 and 22:00 (UTC time) default for No shift
                                                if($today=="Friday")
                                                {
                                                    if($nextday<10)
                                                    {
                                                        if((!empty($nextday_start['work_start_time'.($nextday+2)])))
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo $year."-".$month."-0".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
                                                            ?></span> <?php
                                                            if($nextday_start['work_start_time'.($nextday+2)]!="Free")
                                                            {
                                                                ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                                echo $year."-".$month."-0".($nextday+2)." ".$nextday_start['work_end_time'.($nextday+2)];
                                                                ?></span>
                                                            <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo "No shift";
                                                            ?></span>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if((!empty($nextday_start['work_start_time'.($nextday+2)])))
                                                        {
                                                        ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo $year."-".$month."-".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
                                                            ?></span> <?php
                                                            if($nextday_start['work_start_time'.($nextday+2)]!="Free")
                                                            {
                                                                ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                                echo $year."-".$month."-".($nextday+2)." ".$nextday_start['work_end_time'.($nextday+2)];
                                                                ?></span>
                                                            <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo "No shift";
                                                            ?></span>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                elseif($today=="Saturday")
                                                {
                                                    if($nextday<10)
                                                    {
                                                        if(/*($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&*/(!empty($nextday_start['work_start_time'.($nextday+1)])))
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                                                            ?></span> <?php
                                                            if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                                                            {
                                                                ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                                echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                                                                ?></span>
                                                            <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo "No shift";
                                                            ?></span>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(/*($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&*/(!empty($nextday_start['work_start_time'.($nextday+1)])))
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                                                            ?></span> <?php
                                                            if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                                                            {
                                                                ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                                echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                                                                ?></span>    
                                                            <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo "No shift";
                                                            ?></span>
                                                            <?php
                                                        }
                                                    }
                                                    
                                                }
                                                else
                                                {
                                                    if($nextday<10)
                                                    {
                                                        if(/*($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&*/(!empty($nextday_start['work_start_time'.$nextday])))
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                                                            ?></span> <?php
                                                            if($nextday_start['work_start_time'.$nextday]!="Free")
                                                            {
                                                                ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                                echo $year."-".$month."-0".$nextday." ".$nextday_start['work_end_time'.$nextday];
                                                                ?></span>
                                                                <?php 
                                                            }                        
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo "No shift";
                                                            ?></span>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(/*($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&*/(!empty($nextday_start['work_start_time'.$nextday])))
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                                                            ?></span> <?php
                                                            if($nextday_start['work_start_time'.$nextday]!="Free")
                                                            {
                                                                ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                                echo $year."-".$month."-".$nextday." ".$nextday_start['work_end_time'.$nextday];
                                                                ?></span>
                                                            <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                            echo "No shift";
                                                            ?></span>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 py-2">
                                    <?php
                                    $count_working_tasks=$prod->count_working_tasks($creator['client_ID']);
                                    echo count($count_working_tasks); //this is not correctly calculated
                                    ?>
                                    </div>
                                    <div class="col-md-6 py-3">
                                        <?php
                                        $allstatus=$prod->showallstatus();
                                        
                                        for($j=0;$j<count($count_working_tasks);$j++)
                                        {
                                            $order=$prod->get_order($count_working_tasks[$j]['o_id']);
                                            if(($order['on_stock']!=1)&&($order['o_status']<8))
                                            {
                                        ?>	
                                            <p class="border p-inline mb-1 p-1 <?php 
                                            for($k=0;$k<count($allstatus);$k++)
                                            {
                                                if($allstatus[$k]['ost_id']==$count_working_tasks[$j]['p_status'])
                                                {
                                                    echo $allstatus[$k]['ost_color'];
                                                }
                                            }						
                                            ?>"> <a href="<?php echo $base_url;?>coordination/taskdetails.php?o_id=<?php echo $count_working_tasks[$j]['o_id'];?>&osub_id=<?php echo $count_working_tasks[$j]['osub_id'];?>&prod_id=<?php echo $count_working_tasks[$j]['prod_id'];?>"><?php echo $count_working_tasks[$j]['o_id'].".".$count_working_tasks[$j]['osub_id'].".".$count_working_tasks[$j]['prod_id'];?></a></p>
                                        <?php	
                                            }
                                        }
                                        ?>
                                        <!-- <br>
                                        <hr style="border-width:medium;border-color:black;"> 
                                        <br> -->
                                        
                                    </div>
                                </div> 
                                <div class="row w-100 mx-0" style="border-bottom:3px black solid;">
                                    <div class="col-md-12" style="<?php 
                                    if(count($count_working_tasks)>0)
                                    {
                                        echo "border-top:2px black dotted;";
                                    }
                                    ?>">
                                    <?php
                                        for($j=0;$j<count($count_working_tasks);$j++)
                                        {
                                            $order=$prod->get_order($count_working_tasks[$j]['o_id']);

                                            if(($order['on_stock']==1)&&($order['o_status']<8))
                                            {
                                        ?>	
                                            <p class="border p-inline border-warning <?php 
                                            for($k=0;$k<count($allstatus);$k++)
                                            {
                                                if($allstatus[$k]['ost_id']==$count_working_tasks[$j]['p_status'])
                                                {
                                                    echo $allstatus[$k]['ost_color'];
                                                }
                                            }						
                                            ?>" style="border-width:medium !important;width:130px;"> <a href="<?php echo $base_url;?>coordination/taskdetails.php?o_id=<?php echo $count_working_tasks[$j]['o_id'];?>&osub_id=<?php echo $count_working_tasks[$j]['osub_id'];?>&prod_id=<?php echo $count_working_tasks[$j]['prod_id'];?>"><?php echo $count_working_tasks[$j]['o_id'].".".$count_working_tasks[$j]['osub_id'].".".$count_working_tasks[$j]['prod_id'];?></a></p>
                                        <?php	
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                    $num_team_creators++;
                    $global_counter++;
                } //if user active
            } //end sub for
        } //end main for
            //print_r($creators);
            ?>
        </div> <!-- end my team -->
            <?php
            if(!empty($myteam))
            {
            ?>
            <br>
                <div style="border:3px solid #000"></div>
            <br>
            <div class="row">
                <div class="col-md-12">
                <b>Others</b>
                </div>
            </div>
            <br>
			<?php
            }
            ?>
            <div id="tasks_list_online_creators">
            </div>
        <div id="other_creators">
            <?php
			for($i=0;$i<count($creators);$i++)
			{
				if(($creators[$i]['u_status']=="active")&&($creators[$i]['own_tasks']==1))
				{
                    $endtime=$prod->get_creator_end_time($creators[$i]['client_ID']);
                    ?>
                    <div class="all_creators2 colorline2">
                    <div class="row w-100 mx-0 border-bottom">										
                        <div class="col-md-4 border-right py-2">
                            <div class="d-inline-flex">
                                <div id="tasks_creator_bubble_<?php echo $global_counter;?>" class="bubble offline mr-2"></div>
                                <?php
                                if(!empty($creators[$i]['c_last_name']))
                                {
                                    echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name'];
                                }
                                else
                                {
                                    echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name'];
                                }
                                echo " - ".$prod->get_company($creators[$i]['lt_id'])['mailnick'];
                                ?> - Time left: &nbsp;<span id="creator_timeleft_<?php echo $global_counter;?>" class="task_list_creator_<?php echo $global_counter;?>"><?php
                                
                            
                                echo $endtime['end_time'];?></span>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                Started: <span id="employees_programs_today_start<?php echo $global_counter;?>"><?php 
                                
                                $creator_today_start_time=$prod->get_creator_start_time($creators[$i]['client_ID']);
                                
                                echo $creator_today_start_time['start_time'];
                                ?></span> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    Next: <?php
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
                                            if((!empty($nextday_start['work_start_time'.($nextday+2)])))
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo $year."-".$month."-0".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
                                                ?></span> <?php
                                                if($nextday_start['work_start_time'.($nextday+2)]!="Free")
                                                {
                                                    ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                    echo $year."-".$month."-0".($nextday+2)." ".$nextday_start['work_end_time'.($nextday+2)];
                                                    ?></span>
                                                <?php
                                                }
                                            }
                                            else
                                            {
                                            ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo "No shift";
                                                ?></span>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            if((!empty($nextday_start['work_start_time'.($nextday+2)])))
                                            {
                                            ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo $year."-".$month."-".($nextday+2)." ".$nextday_start['work_start_time'.($nextday+2)];
                                                ?></span> <?php
                                                if($nextday_start['work_start_time'.($nextday+2)]!="Free")
                                                {
                                                    ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                    echo $year."-".$month."-".($nextday+2)." ".$nextday_start['work_end_time'.($nextday+2)];
                                                    ?></span>
                                                <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo "No shift";
                                                ?></span>
                                                <?php
                                            }
                                        }
                                    }
                                    elseif($today=="Saturday")
                                    {
                                        if($nextday<10)
                                        {
                                            if(/*($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&*/(!empty($nextday_start['work_start_time'.($nextday+1)])))
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                                                ?></span> <?php
                                                if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                                                {
                                                    ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                    echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                                                    ?></span>
                                                <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo "No shift";
                                                ?></span>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            if(/*($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&*/(!empty($nextday_start['work_start_time'.($nextday+1)])))
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                                                ?></span> <?php
                                                if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                                                {
                                                    ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                    echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                                                    ?></span>    
                                                <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo "No shift";
                                                ?></span>
                                                <?php
                                            }
                                        }
                                        
                                    }
                                    else
                                    {
                                        if($nextday<10)
                                        {
                                            if(/*($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&*/(!empty($nextday_start['work_start_time'.$nextday])))
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                                                ?></span> <?php
                                                if($nextday_start['work_start_time'.$nextday]!="Free")
                                                {
                                                    ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                    echo $year."-".$month."-0".$nextday." ".$nextday_start['work_end_time'.$nextday];
                                                    ?></span>
                                                    <?php 
                                                }                        
                                            }
                                            else
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo "No shift";
                                                ?></span>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            if(/*($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&*/(!empty($nextday_start['work_start_time'.$nextday])))
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                                                ?></span> <?php
                                                if($nextday_start['work_start_time'.$nextday]!="Free")
                                                {
                                                    ?>(Your time) until <span id="employees_programs_next_end<?php echo $global_counter;?>"><?php
                                                    echo $year."-".$month."-".$nextday." ".$nextday_start['work_end_time'.$nextday];
                                                    ?></span>
                                                <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <span id="employees_programs_next_start<?php echo $global_counter;?>"><?php
                                                echo "No shift";
                                                ?></span>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                //$('.task_list_creator_<?php echo $creators[$i]['client_ID'];?>').text($('.creator_timeleft_<?php echo $creators[$i]['client_ID'];?>').text());
                                });
                            </script>
                        </div>
                        <div class="col-md-1 py-2">
                        <?php
                        $count_working_tasks=$prod->count_working_tasks($creators[$i]['client_id']);
                        echo count($count_working_tasks); //this is not correctly calculated
                        ?>
                        </div>
                        <div class="col-md-6 py-3">
                            <?php
                            $allstatus=$prod->showallstatus();
                            
                            for($j=0;$j<count($count_working_tasks);$j++)
                            {
                                $order=$prod->get_order($count_working_tasks[$j]['o_id']);
                                if(($order['on_stock']!=1)&&($order['o_status']<8))
                                {
                            ?>	
                                <p class="border p-inline mb-1 p-1 <?php 
                                for($k=0;$k<count($allstatus);$k++)
                                {
                                    if($allstatus[$k]['ost_id']==$count_working_tasks[$j]['p_status'])
                                    {
                                        echo $allstatus[$k]['ost_color'];
                                    }
                                }						
                                ?>"> <a href="<?php echo $base_url;?>coordination/taskdetails.php?o_id=<?php echo $count_working_tasks[$j]['o_id'];?>&osub_id=<?php echo $count_working_tasks[$j]['osub_id'];?>&prod_id=<?php echo $count_working_tasks[$j]['prod_id'];?>"><?php echo $count_working_tasks[$j]['o_id'].".".$count_working_tasks[$j]['osub_id'].".".$count_working_tasks[$j]['prod_id'];?></a></p>
                            <?php	
                                }
                            }
                            ?>
                            <!-- <br>
                            <hr style="border-width:medium;border-color:black;"> 
                            <br> -->
                            
                        </div>
                    </div> 
                    <div class="row w-100 mx-0" style="border-bottom:3px black solid;">
                        <div class="col-md-12" style="<?php 
                        if(count($count_working_tasks)>0)
                        {
                            echo "border-top:2px black dotted;";
                        }
                        ?>">
                        <?php
                            for($j=0;$j<count($count_working_tasks);$j++)
                            {
                                $order=$prod->get_order($count_working_tasks[$j]['o_id']);

                                if(($order['on_stock']==1)&&($order['o_status']<8))
                                {
                            ?>	
                                <p class="border p-inline border-warning <?php 
                                for($k=0;$k<count($allstatus);$k++)
                                {
                                    if($allstatus[$k]['ost_id']==$count_working_tasks[$j]['p_status'])
                                    {
                                        echo $allstatus[$k]['ost_color'];
                                    }
                                }						
                                ?>" style="border-width:medium !important;width:130px;"> <a href="<?php echo $base_url;?>coordination/taskdetails.php?o_id=<?php echo $count_working_tasks[$j]['o_id'];?>&osub_id=<?php echo $count_working_tasks[$j]['osub_id'];?>&prod_id=<?php echo $count_working_tasks[$j]['prod_id'];?>"><?php echo $count_working_tasks[$j]['o_id'].".".$count_working_tasks[$j]['osub_id'].".".$count_working_tasks[$j]['prod_id'];?></a></p>
                            <?php	
                                }
                            }
                        ?>
                        </div>
                    </div>
                    </div>
                    <?php
                    $num_creators++;
                    $global_counter++;
				}
			}
			
			?>
            </div> <!-- end other_creators -->
			</div> <!-- end creators_1 -->
			<?php
			//include('../online_creators.php');
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
<script type="text/javascript">
$(document).ready(function(){
var user_timezone2 = Intl.DateTimeFormat().resolvedOptions().timeZone;

var all_creators2=$('.all_creators2').length;

for(var i=0;i<=all_creators2;i++)
{
if($('#creator_timeleft_'+i).text()!="")
{
	var creatorUTCendtime2 = moment.tz($('#creator_timeleft_'+i).text(),'UTC');
	var dateset2 = creatorUTCendtime2.clone().tz(user_timezone2).format('YYYY-MM-DD HH:mm');
	$('#creator_timeleft_'+i).countdown(dateset2, function(event2) {
		$(this).html(event2.strftime('%H:%M'));
		$('#tasks_creator_bubble_'+i).removeClass('offline').addClass('online');
        $("#all_team_creators_row"+i).removeClass('offline_border').addClass('online_border');
		  //var creator_id=$('#creator_bubble_'+i+" > .creator_id").attr("id");
		  //console.log(creator_id);
		 // $('#creator_bubble_'+i+" > #"+creator_id).val("online");
		});
	if($('#creator_timeleft_'+i).text()=="00:00")
	{
		$('#tasks_creator_bubble_'+i).removeClass('online').addClass('offline');
        $("#all_team_creators_row"+i).removeClass('offline_border').addClass('online_border');
		// var creator_id=$('#creator_bubble_'+i+" > .creator_id").attr("id");
		  //console.log(creator_id);
		//  $("#"+creator_id).val("offline");
	}
	console.log(creatorUTCendtime2);  
} 

//today start time
if($("#employees_programs_today_start"+i).text()!="")
{
    var employeeUTCtodaystarttime = moment.tz($('#employees_programs_today_start' + i).text(), 'UTC');
    var newtodaystarttime = employeeUTCtodaystarttime
        .clone()
        .tz(user_timezone2)
        .format('YYYY-MM-DD, HH:mm');
        $('#employees_programs_today_start' + i).text(newtodaystarttime+" (Your time)");
}

//next start time

if(($("#employees_programs_next_start"+i).text()!="")&&($("#employees_programs_next_start"+i).text()!="No shift")&&
    ($("#employees_programs_next_start"+i).text().toLowerCase().indexOf("free") == -1)&&
    ($("#employees_programs_next_start"+i).text().toLowerCase().indexOf("on vacation") == -1))
    {  
        var employeeUTCstarttime = moment.tz($('#employees_programs_next_start' + i).text(), 'UTC');
        var newstarttime = employeeUTCstarttime
            .clone()
            .tz(user_timezone2)
            .format('YYYY-MM-DD, HH:mm');
            $('#employees_programs_next_start' + i).text(newstarttime);
    }

    //next end time

    if(($("#employees_programs_next_end"+i).text()!="")&&($("#employees_programs_next_end"+i).text()!="No shift")&&
    ($("#employees_programs_next_end"+i).text().toLowerCase().indexOf("free") == -1)&&($("#employees_programs_next_end"+i).text().toLowerCase().indexOf("on vacation") == -1))
    {  
        var employeeUTCnextendtime = moment.tz($('#employees_programs_next_end' + i).text(), 'UTC');
        var nextendtime = employeeUTCnextendtime
            .clone()
            .tz(user_timezone2)
            .format('HH:mm');
            $('#employees_programs_next_end' + i).text(nextendtime);
    }
}


$(".online").each(function(){
    if($(this).parent().parent().parent().parent().hasClass("all_creators2"))
    {
        $(this).parent().parent().parent().parent().appendTo("#tasks_list_online_creators");
    }
});

$(".online").each(function(){
    if($(this).parent().parent().parent().parent().hasClass("all_team_creators"))
    {
        $(this).parent().parent().parent().parent().appendTo("#team_online_creators");
    }
});

}); 
</script>
<?php
include('../footer.php');
?>