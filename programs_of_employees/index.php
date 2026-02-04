<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");
$page_title="Programs of employees";
include('../header2.php');
include('../menu.php');

?>
<section class="top_section">
	<article>
	<div class="container-fluid text-left mt-4 pt-4">
		<div class="row mx-0 w-100">
            <div class="col-md-12 border p-4">
                <?php
            if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
            {
                
                ?>
                <h3 class="text-center pb-3">Programs of employees</h3>
                
                <table id="my_company_creators">
                    
                    <thead>
                        <tr>
                        <th>Creator Name</th>
                        <th>Time left</th>
                        <th>Next Shift</th>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    $creators=$prod->show_creators($_COOKIE['lt_id']);
                    
                    $num_creators=0;
                    $num_team_creators=0;
    
                    for($i=0;$i<count($creators);$i++)
                    {
                        if($creators[$i]['u_status']=="active")
                        {
                    ?>
                    <tr class="employees_programs offline_border">
                    <td>
                    <form name="creator_login_time_form<?php echo $num_creators;?>" id="creator_login_time_form<?php echo $num_creators;?>" method="get" action="creator_login_time.php"></form>
                    <input type="hidden" name="client_id" value="<?php echo $creators[$i]['client_ID']; ?>" form="creator_login_time_form<?php echo $num_creators;?>">
                    <div class="d-inline-flex">
                        <div id="tasks_creator_bubble_<?php echo $num_team_creators;?>" class="bubble offline mr-2"></div>
                        <a href="calendar.php?client_id=<?php echo $creators[$i]['client_ID']; ?>">
                        <?php
                        if(!empty($creators[$i]['c_last_name']))
                        {
                            echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name'];
                        }
                        else
                        {
                            echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name'];
                        }
                        ?> 
                        </a>
                    </div>
                    </td>
                    <td>
                        <span id="employees_programs_time_left<?php echo $num_creators;?>"><?php 
                        $endtime=$prod->get_creator_end_time($creators[$i]['client_ID']);
                        echo $endtime['end_time'];
                        ?></span>
                    </td>
                    
                    <td>
                    <?php
			$month=date("m");
			$year=date("Y");
			$day=date("d");
			$today=$prod->get_day_name($year,$month,$day);
			
			$nr_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			
			$nextday=$day+1;
			
			if($nextday>$nr_days_in_month)
			{
                $nextday=1;$month++;
                if($month==13)
                {
                    $month="01";
                }
			}
			
			$nextday_start=$prod->get_uca_program($creators[$i]['client_ID'],$month,$year);
			
			
			if($today=="Saturday")
			{
				if($nextday<10)
				{
					if((!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
				else
				{
					if((!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                            ?></span>    
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
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
					if((!empty($nextday_start['work_start_time'.$nextday])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.$nextday]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-0".$nextday." ".$nextday_start['work_end_time'.$nextday];
                            ?></span>
                            <?php 
                        }                        
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
				else
				{
					if((!empty($nextday_start['work_start_time'.$nextday])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.$nextday]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-".$nextday." ".$nextday_start['work_end_time'.$nextday];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
			}
			?>
                    </td>
                    <td>
                        <input type="text" id="users_start_date<?php echo $num_creators;?>" name="users_start_date" value="<?php echo date("Y-m-01");?>" class="form-control form-control-sm" placeholder="Start date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                        <script type="text/javascript">
                        $('#users_start_date<?php echo $num_creators;?>').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd"
                            
                        });
                        </script>
                    </td>
                    <td>
                        <input type="text" id="users_end_date<?php echo $num_creators;?>" name="users_end_date" value="<?php echo date("Y-m-t");?>" class="form-control form-control-sm" placeholder="End date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                        <script type="text/javascript">
                        $('#users_end_date<?php echo $num_creators;?>').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd"
                            
                        });
                        </script>
                    </td>
                    <td>
                    <button class="btn btn-primary btn-sm" type="submit" form="creator_login_time_form<?php echo $num_creators;?>">View creator login time</button>
                    </td>
                    </tr>
                    <?php
                    $num_creators++;

                    $num_team_creators++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php /*
                $creators=$prod->show_creators($_COOKIE['lt_id']);
                
                $num_creators=0;
                $num_team_creators=0;

                for($i=0;$i<count($creators);$i++)
                {
                    if($creators[$i]['u_status']=="active")
                    {
                    ?>
                    <div id="all_team_creators_row<?php echo $num_team_creators;?>" class="row colorline employees_programs offline_border">
                        <form name="creator_login_time_form<?php echo $num_creators;?>" id="creator_login_time_form<?php echo $num_creators;?>" method="get" action="creator_login_time.php"></form>
                        <input type="hidden" name="client_id" value="<?php echo $creators[$i]['client_ID']; ?>" form="creator_login_time_form<?php echo $num_creators;?>">
                        <div class="col-md-2 pl-md-4">
                            <div class="d-inline-flex">
                                <div id="tasks_creator_bubble_<?php echo $num_team_creators;?>" class="bubble offline mr-2"></div>
                                <a href="calendar.php?client_id=<?php echo $creators[$i]['client_ID']; ?>">
                                <?php
                                if(!empty($creators[$i]['c_last_name']))
                                {
                                    echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name'];
                                }
                                else
                                {
                                    echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name'];
                                }
                                ?> 
                                </a>
                            </div>
                                <br>Time left: <span id="employees_programs_time_left<?php echo $num_creators;?>"><?php 
                                $endtime=$prod->get_creator_end_time($creators[$i]['client_ID']);
                                echo $endtime['end_time'];
                                ?></span>
                            
                        </div>
                        <div class="col-md-3">- Next shift: <?php
			$month=date("m");
			$year=date("Y");
			$day=date("d");
			$today=$prod->get_day_name($year,$month,$day);
			
			$nr_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			
			$nextday=$day+1;
			
			if($nextday>$nr_days_in_month)
			{
                $nextday=1;$month++;
                if($month==13)
                {
                    $month="01";
                }
			}
			
			$nextday_start=$prod->get_uca_program($creators[$i]['client_ID'],$month,$year);
			
			if($today=="Saturday")
			{
				if($nextday<10)
				{
					if((!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
				else
				{
					if((!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                            ?></span>    
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
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
					if((!empty($nextday_start['work_start_time'.$nextday])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.$nextday]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-0".$nextday." ".$nextday_start['work_end_time'.$nextday];
                            ?></span>
                            <?php 
                        }                        
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
				else
				{
					if((!empty($nextday_start['work_start_time'.$nextday])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.$nextday]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-".$nextday." ".$nextday_start['work_end_time'.$nextday];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
			}
			?>
                        </div>
                    
                        <div class="col-md-1">
                            <input type="text" id="users_start_date<?php echo $num_creators;?>" name="users_start_date" value="<?php echo date("Y-m-01");?>" class="form-control form-control-sm" placeholder="Start date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                            <script type="text/javascript">
                            $('#users_start_date<?php echo $num_creators;?>').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "yy-mm-dd"
                                
                            });
                            </script>
                        </div>
                        <div class="col-md-1">
                            <input type="text" id="users_end_date<?php echo $num_creators;?>" name="users_end_date" value="<?php echo date("Y-m-t");?>" class="form-control form-control-sm" placeholder="End date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                            <script type="text/javascript">
                            $('#users_end_date<?php echo $num_creators;?>').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "yy-mm-dd"
                                
                            });
                            </script>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary btn-sm" type="submit" form="creator_login_time_form<?php echo $num_creators;?>">View creator login time</button>
                        </div>
                    
                    </div>
                    <?php
                    $num_creators++;

                    $num_team_creators++;
                    }
                    
                } */
            
            if($_COOKIE['view_all_orders']>0)
            {
                
            ?>
            <br>
            <div class="col-md-12">
                <div class="text-danger" style="font-size:16px !important;">Creators from other companies</div>
            </div>
            <br>
            <table id="other_company_creators">
                <thead>
                    <tr>
                    <th>Creator Name</th>
                    <th>Time left</th>
                    <th>Next Shift</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            $other_creators=$prod->show_creators_other_companies($_COOKIE['lt_id']);
                	

            for($i=0;$i<count($other_creators);$i++)
            {
                if($other_creators[$i]['u_status']=="active")
                {
                    $company=$prod->get_company($other_creators[$i]['lt_id']);
                    ?>
                    <tr class="employees_programs offline_border">
                    <td>
                    <form name="creator_login_time_form<?php echo $num_creators;?>" id="creator_login_time_form<?php echo $num_creators;?>" method="get" action="creator_login_time.php"></form>
                    <input type="hidden" name="client_id" value="<?php echo $other_creators[$i]['client_ID']; ?>" form="creator_login_time_form<?php echo $num_creators;?>">
                    <div class="d-inline-flex">
                        <div id="tasks_creator_bubble_<?php echo $num_team_creators;?>" class="bubble offline mr-2"></div>
                        <a href="calendar.php?client_id=<?php echo $other_creators[$i]['client_ID']; ?>">
                        <?php
                        if(!empty($other_creators[$i]['c_last_name']))
                        {
                            echo $other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name'];
                        }
                        else
                        {
                            echo $other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name'];
                        }
                        // echo $other_creators[$i]['c_last_name']=!empty($other_creators[$i]['c_last_name'])?$other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name']:$other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name'];
                            echo $company['mailnick']=isset($company['mailnick'])?" - ".$company['mailnick']:"";
                        ?> 
                        </a>
                    </div>
                    </td>
                    <td>
                    <span id="employees_programs_time_left<?php echo $num_creators;?>"><?php 
                    $endtime=$prod->get_creator_end_time($other_creators[$i]['client_ID']);
                    echo $endtime['end_time'];
                    ?></span>
                    </td>
                    <td>
                    <?php
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
                    
                    
                    if($today=="Saturday")
                    {
                        if($nextday<10)
                        {
                            if((!empty($nextday_start['work_start_time'.($nextday+1)])))
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                                echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                                ?></span> <?php
                                if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                                {
                                    ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                                    echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                                    ?></span>
                                <?php
                                }
                            }
                            else
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                                echo "No shift";
                                ?></span>
                                <?php
                            }
                        }
                        else
                        {
                            if((!empty($nextday_start['work_start_time'.($nextday+1)])))
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                                echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                                ?></span> <?php
                                if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                                {
                                    ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                                    echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                                    ?></span>
                                <?php
                                }
                            }
                            else
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
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
                            if((!empty($nextday_start['work_start_time'.$nextday])))
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                                echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                                ?> <?php
                                if($nextday_start['work_start_time'.$nextday]!="Free")
                                {
                                    ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                                    echo $year."-".$month."-0".$nextday." ".$nextday_start['work_end_time'.$nextday];
                                    ?></span>
                                <?php
                                }
                            }
                            else
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                                echo "No shift";
                                ?></span>
                                <?php
                            }
                        }
                        else
                        {
                            if((!empty($nextday_start['work_start_time'.$nextday])))
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                                echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                                ?></span> <?php
                                if($nextday_start['work_start_time'.$nextday]!="Free")
                                {
                                    ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                                    echo $year."-".$month."-".$nextday." ".$nextday_start['work_end_time'.$nextday];
                                    ?></span>
                                <?php
                                }
                            }
                            else
                            {
                                ?>
                                <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                                echo "No shift";
                                ?></span>
                                <?php
                            }
                        }
                    }
                    ?>
                    </td>
                    <td>
                        <input type="text" id="users_start_date<?php echo $num_creators;?>" name="users_start_date" value="<?php echo date("Y-m-01");?>" class="form-control form-control-sm" placeholder="Start date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                        <script type="text/javascript">
                        $('#users_start_date<?php echo $num_creators;?>').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd"
                            
                        });
                        </script>
                    </td>
                    <td>
                    <input type="text" id="users_end_date<?php echo $num_creators;?>" name="users_end_date" value="<?php echo date("Y-m-t");?>" class="form-control form-control-sm" placeholder="End date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                    <script type="text/javascript">
                    $('#users_end_date<?php echo $num_creators;?>').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "yy-mm-dd"
                        
                    });
                    </script>
                    </td>
                    <td>
                    <button class="btn btn-primary btn-sm" type="submit" form="creator_login_time_form<?php echo $num_creators;?>">View creator login time</button>
                    </td>
                    </tr>
                    <?php
                    $num_creators++;
                    $num_team_creators++;
                }
            }
            ?>
                </tbody>
            </table>
            <input type="hidden" id="num_creators" name="num_creators" value="<?php echo $num_creators;?>">
            <?php

          
            }
            /*
            if($_COOKIE['view_all_orders']>0)
            {
                ?>
                <div class="row pl-md-4 ml-md-4 colorline">
                    <div class="col-md-12 pl-md-4 ml-md-4">
                        <div class="text-danger" style="font-size:16px !important;">Creators from other companies</div>
                    </div>
                </div>
                <?php
                $other_creators=$prod->show_creators_other_companies($_COOKIE['lt_id']);
                	

                for($i=0;$i<count($other_creators);$i++)
                {
                    if($other_creators[$i]['u_status']=="active")
                    {
                    	$company=$prod->get_company($other_creators[$i]['lt_id']);
                    ?>
                    <div id="all_team_creators_row<?php echo $num_team_creators;?>" class="row colorline employees_programs offline_border">
                        <form name="creator_login_time_form<?php echo $num_creators;?>" id="creator_login_time_form<?php echo $num_creators;?>" method="get" action="creator_login_time.php"></form>
                        <input type="hidden" name="client_id" value="<?php echo $other_creators[$i]['client_ID']; ?>" form="creator_login_time_form<?php echo $num_creators;?>">
                        <div class="col-md-2 pl-md-4">
                            <div class="d-inline-flex">
                                <div id="tasks_creator_bubble_<?php echo $num_team_creators;?>" class="bubble offline mr-2"></div>
                                <a href="calendar.php?client_id=<?php echo $other_creators[$i]['client_ID']; ?>">
                                <?php
                                if(!empty($other_creators[$i]['c_last_name']))
                                {
                                    echo $other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name'];
                                }
                                else
                                {
                                    echo $other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name'];
                                }
                                // echo $other_creators[$i]['c_last_name']=!empty($other_creators[$i]['c_last_name'])?$other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name']:$other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name'];
                                    echo $company['mailnick']=isset($company['mailnick'])?" - ".$company['mailnick']:"";
                                ?> 
                                </a>
                            </div>
                                <br>Time left: <span id="employees_programs_time_left<?php echo $num_creators;?>"><?php 
                                $endtime=$prod->get_creator_end_time($other_creators[$i]['client_ID']);
                                echo $endtime['end_time'];
                                ?></span>
                            
                        </div>
                        <div class="col-md-3"> - Next shift: <?php
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
			
			
			if($today=="Saturday")
			{
				if($nextday<10)
				{
					if((!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
				else
				{
					if((!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.($nextday+1)]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_end_time'.($nextday+1)];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
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
					if((!empty($nextday_start['work_start_time'.$nextday])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                        ?> <?php
                        if($nextday_start['work_start_time'.$nextday]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-0".$nextday." ".$nextday_start['work_end_time'.$nextday];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
				else
				{
					if((!empty($nextday_start['work_start_time'.$nextday])))
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                        ?></span> <?php
                        if($nextday_start['work_start_time'.$nextday]!="Free")
                        {
                            ?>(Your time) <br>until <span id="employees_programs_next_end<?php echo $num_creators;?>"><?php
                            echo $year."-".$month."-".$nextday." ".$nextday_start['work_end_time'.$nextday];
                            ?></span>
                        <?php
                        }
					}
					else
					{
                        ?>
                        <span id="employees_programs_next_start<?php echo $num_creators;?>"><?php
                        echo "No shift";
                        ?></span>
                        <?php
					}
				}
			}
			?>
                        </div>
                        <div class="col-md-1">
                            <input type="text" id="users_start_date<?php echo $num_creators;?>" name="users_start_date" value="<?php echo date("Y-m-01");?>" class="form-control form-control-sm" placeholder="Start date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                            <script type="text/javascript">
                            $('#users_start_date<?php echo $num_creators;?>').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "yy-mm-dd"
                                
                            });
                            </script>
                        </div>
                        <div class="col-md-1">
                            <input type="text" id="users_end_date<?php echo $num_creators;?>" name="users_end_date" value="<?php echo date("Y-m-t");?>" class="form-control form-control-sm" placeholder="End date:" autocomplete="off" form="creator_login_time_form<?php echo $num_creators;?>">
                            <script type="text/javascript">
                            $('#users_end_date<?php echo $num_creators;?>').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "yy-mm-dd"
                                
                            });
                            </script>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary btn-sm" type="submit" form="creator_login_time_form<?php echo $num_creators;?>">View creator login time</button>
                        </div>
                    </div>
                    <?php
                    $num_creators++;
                    $num_team_creators++;
                    } //active users
                    
                } //end for
            } */
                ?>
            
            </div>
        </div>
	</div>	<!-- end container -->
    <script type="text/javascript">
    $(document).ready(function(){

        
        $('#my_company_creators').DataTable( {
        "order": [[ 1, "desc" ],[ 2, "asc" ]],
        iDisplayLength: -1
        // columnDefs: [  {
        //     targets: [ 1 ],
        //     orderData: [ 1, 0 ]
        // }, {
        //     targets: [ 2 ],
        //     orderData: [ 4, 0 ]
        // } ]

        });
    
        $('#other_company_creators').DataTable( {
        "order": [[ 1, "desc" ],[ 2, "asc" ]],
        iDisplayLength: -1
        // columnDefs: [  {
        //     targets: [ 1 ],
        //     orderData: [ 1, 0 ]
        // }, {
        //     targets: [ 2 ],
        //     orderData: [ 4, 0 ]
        // } ]

        });

        var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        var num_creators=$('#num_creators').val();
        
        for(i=0;i<num_creators;i++)
        {
            //countdown timer

            if($("#employees_programs_time_left"+i).text()!="")
            {
                var employeeUTCendtime = moment.tz($('#employees_programs_time_left' + i).text(), 'UTC');
                var newendtime = employeeUTCendtime
                    .clone()
                    .tz(user_timezone)
                    .format('YYYY-MM-DD HH:mm');
                $("#employees_programs_time_left" + i).countdown(newendtime, function(event) {
                    $(this).html(event.strftime('%H:%M'));
                    $('#tasks_creator_bubble_'+i).removeClass('offline').addClass('online');
                    $("#all_team_creators_row"+i).removeClass('offline_border').addClass('online_border');

                    if($('#employees_programs_time_left'+i).text()=="00:00")
                    {
                        $('#tasks_creator_bubble_'+i).removeClass('online').addClass('offline');
                        $("#all_team_creators_row"+i).removeClass('offline_border').addClass('online_border');
                    }
                });
            }
            
            //next start time

            if(($("#employees_programs_next_start"+i).text()!="")&&($("#employees_programs_next_start"+i).text()!="No shift")&&
            ($("#employees_programs_next_start"+i).text().toLowerCase().indexOf("free") == -1)&&($("#employees_programs_next_start"+i).text().toLowerCase().indexOf("on vacation") == -1))
            {  
                var employeeUTCstarttime = moment.tz($('#employees_programs_next_start' + i).text(), 'UTC');
                var newstarttime = employeeUTCstarttime
                    .clone()
                    .tz(user_timezone)
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
                    .tz(user_timezone)
                    .format('YYYY-MM-DD, HH:mm');
                    $('#employees_programs_next_end' + i).text(nextendtime);
            }
        }
        //console.log(num_creators);
    });
    </script>
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
	</article>
</section>
<?php
include('../footer.php');
?>