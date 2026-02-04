<?php
session_set_cookie_params(36000,"/"); // 10 hours session so that people are not logged out when they close the browser
session_start();
include('functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Own Tasks";

include('header2.php');
include('menu.php');

?>
<section class="top_section">
	<article>
	<div class="container text-center mb-5 pagecontent bg-white px-5 pb-5">
	<br><br>
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{
			if((isset($_POST['work_start_time']))&&(isset($_POST['work_end_time'])))
			{
				$work_start_time=$prod->xss_fix($_POST['startUTCtime']);
				$work_end_time=$prod->xss_fix($_POST['endUTCtime']);
                
                $_COOKIE['expire']=$work_end_time;

                $creator_end_time=$prod->get_creator_end_time($_COOKIE['client_id']);

                if(!empty($creator_end_time))
                {
                    $prod->update_working_hours($creator_end_time['cwh_id'],$creator_end_time['start_time'],$work_end_time,$_COOKIE['ip_address'],$_COOKIE['user_agent']);
                }
                else
                {
                    $prod->insert_working_hours($_COOKIE['client_id'],$work_start_time,$work_end_time,$_COOKIE['ip_address'],$_COOKIE['user_agent']);
                }
            }
            
            /*
            if((!empty($_POST['next_startUTCtime']))&&(!empty($_POST['next_endUTCtime'])))
            {
                $next_startUTCtime=$prod->xss_fix($_POST['next_startUTCtime']);
                $next_endUTCtime=$prod->xss_fix($_POST['next_endUTCtime']);

                $utc_startdate=explode(" ",$next_startUTCtime);
                $utc_enddate=explode(" ",$next_endUTCtime);

                $utc_date=explode("-",$utc_startdate[0]);

                $next_starttime=$utc_startdate[1];
                $next_endtime=$utc_enddate[1];

                $uca_program=$prod->get_uca_program($_COOKIE['client_id'],$utc_date[1],$utc_date[0]);

                if(!empty($uca_program))
                {
                    $prod->update_next_day_program($_COOKIE['client_id'],$utc_date[0],$utc_date[1],intval($utc_date[2]),$next_starttime,$next_endtime);
                }
                else
                {
                    $prod->insert_next_day_program($_COOKIE['client_id'],$utc_date[0],$utc_date[1],intval($utc_date[2]),$next_starttime,$next_endtime);
                }
            }*/

			?>
            <h3>Own tasks</h3>
            
            <hr class="mb-4" width="350px">

            <div class="row">
                <div class="col-md-12">
                <form name="search_from" id="search_from" method="get" action="" class="form-inline w-100">
                    <div class="col-xl-8 col-12 col-md-4 d-flex justify-content-center align-items-center flex-row pr-2 py-1">
                        <p class="mx-2 text-dark mb-0 text-right w-75">
                            <strong class="text-dark">Search for</strong>      
                        </p>
                        <select name="search_option" class="form-control form-control-sm">
                            <option value="o_id">Order ID:</option> 
                            <option value="order_name">Order Name:</option>
                            <option value="plot_id">Plot ID:</option>  
                        </select>
                    </div>
                    <div class="col-xl-4 col-8 col-md-4 d-flex align-items-center px-0">
                        <div class="input-group">
                            <input type="text" class="form-control-sm form-control" name="search" value="">
                            <div class="input-group-append" onclick="document.getElementById('search_from').submit();">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
			<?php
			
			//$_COOKIE['lt_id']=$prod->get_creator($_COOKIE['email'])['lt_id'];
			
			
			if(!isset($_GET['page']))
			{
				$page=1;
			}
			else
            {
                $page=$prod->xss_fix($_GET['page']);
            }
			$limit=10;
			$startpoint=($page*$limit)-$limit; 
			
			//$orders=$prod->show_creator_orders($_COOKIE['email']);
			if($page<2)
			{
				//$can_not_do_orders=$prod->show_can_not_do_orders();
				$unfinished_orders=$prod->show_creator_unfinished_orders($_COOKIE['client_id']);
			}

			if($page>1)
            {
			    $finished_orders=$prod->show_creator_finished_orders($_COOKIE['client_id'],$startpoint,$limit);
            }
            $pages=0;
            if(!empty($finished_orders))
            {
			    $pages=count($finished_orders);	
            }
            //start search 

            if(isset($_GET['search']))
            {

                $search=$prod->xss_fix($_GET['search']);
                $search_option=$prod->xss_fix($_GET['search_option']);

                if($search_option=="o_id")
                {
                    if(is_numeric($search))
                    {
                        
                        $search_orders[]=$prod->show_creator_search_orders_by_o_id($_COOKIE['client_id'],$search);
                        
                    }
                }
                elseif($search_option=="order_name")
                {
                    
                    $search_orders=$prod->show_creator_search_orders_by_order_name($_COOKIE['client_id'],$search); //getting the first client id for now
                    
                }
                // elseif($search_option=="plot_id")
                // {
                    
                //     $search_orders[]=$prod->show_creator_search_orders_by_plot_id($_COOKIE['client_id'],$search); 
                    
                // }
                //print_r($search_orders);

                for($i=0;$i<count($search_orders);$i++)
                {
                    $o_status=$prod->get_order($search_orders[$i]['o_id']);
                    
                    if(($o_status['o_status']<=8)&&($o_status['on_stock']!=1))
                    {
                        ?>
                        <div class="row light-grey w-100 mx-0 mt-2 py-2">
                            <div class="col-md-1">
                                Order ID <?php echo $search_orders[$i]['o_id']; 
                                if($o_status['om_id']!=0)
                                {
                                    echo "-".$o_status['om_id'];
                                }?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $o_status['order_name']; ?>
                                <br>
                                <?php
                                $plot_ids_array=explode('|',$o_status['plot_id']);
                                
                                if((!empty($plot_ids_array))&&(!empty($o_status['plot_id'])))
                                {
                                ?>
                                Plot ID: <a href="own_tasks.php?search_option=plot_id&search=<?php echo $plot_ids_array[1];?>"><?php echo $plot_ids_array[1];?></a> 
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            if($o_status['o_deadline']!="0000-00-00 00:00:00")
                            {
                            ?>
                            <div class="col-md-4">
                            <span class="text-danger">Deadline: <span id="o_deadline<?php echo $search_orders[$i]['o_id'];?>"><?php 
                                echo $o_status['o_deadline'];?></span> UTC+0</span>
                            <input type="hidden" id="new_o_deadline<?php echo $search_orders[$i]['o_id'];?>" name="new_o_deadline<?php echo $search_orders[$i]['o_id'];?>" value="<?php
                            echo $new_o_deadline=$prod->get_deadline_without_weekends($o_status['o_deadline']);
                            ?>">
                            <br><span class="text-danger">Time left: <b><span id="timeleft<?php echo $search_orders[$i]['o_id'];?>" class="blink"></span></b></span>
                            <script type="text/javascript">
                                setInterval(function() {
                                        //var deadline = new Date($("#o_deadline<?php echo $search_orders[$i]['o_id'];?>").text());
                                        var deadline=moment.tz($('#new_o_deadline<?php echo $search_orders[$i]['o_id'];?>').text(),'UTC');
                                        var today=new Date();
                                        var diff=(new Date(deadline).getTime() - new Date(today).getTime());

                                        if(diff>(24*60*60*1000) || diff<0){
                                            $('#timeleft<?php echo $search_orders[$i]['o_id'];?>').removeClass('blink');
                                        }else{
                                            $('#timeleft<?php echo $search_orders[$i]['o_id'];?>').addClass('blink');
                                        }

                                    }, 1000);
                                $(document).ready(function(){
                                    // timeleft 
                                    //var dateset = '<?php echo $o_status['o_deadline'];?>';
                                    countdown_timeleft<?=$search_orders[$i]['o_id']?>();
                                });

                                function countdown_timeleft<?=$search_orders[$i]['o_id']?>(){

                                    var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                if(($('#new_o_deadline<?php echo $search_orders[$i]['o_id'];?>').val()!="")&&($('#new_o_deadline<?php echo $search_orders[$i]['o_id'];?>').val()!="No Deadline"))
                                {
                                    var deadline_time = moment.tz($('#new_o_deadline<?php echo $search_orders[$i]['o_id'];?>').val(),'UTC');
                                    var dateset = deadline_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm:ss');
                                    $('#timeleft<?php echo $search_orders[$i]['o_id'];?>').countdown(dateset, function(event) {
                                            //$(this).html(event.strftime('%d days %H:%M:%S'));
                                            $(this).html(event.strftime('%-D day%!D %H:%M:%S'));
                                        });
                                }
                                
                                    if($('#timeleft<?php echo $search_orders[$i]['o_id'];?>').text()=="0 days 00:00:00")
                                    {
                                        $('#timeleft<?php echo $search_orders[$i]['o_id'];?>').removeClass('blink');
                                    }

                                }
                            </script>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="col-md-2 pt-1">
                                <?php 
                                $tasks_available=$prod->count_available_tasks_by_orderid($search_orders[$i]['o_id'],$_COOKIE['client_id']);
                                //if($tasks_available>0)
                                //{
                                    ?>
                                    <span class="dark-green p-1 border"><?php echo $tasks_available." task(s) available";?></span>
                                    <?php
                                //}
                                ?>
                            </div>
                            <div class="col-md-3">
                                <a href="orderdetails.php?orderid=<?php echo $search_orders[$i]['o_id'];?>" class="btn blue-light btn-sm border">View details</a>
                                <a href="https://bauvorschau.com/<?php echo $search_orders[$i]['o_id'];?>" class="btn btn-primary btn-sm border" target="_blank">Presentation</a>
                                
                                <?php
                                if($o_status['on_stock']==1)
                                {
                                ?>
                                <a href="#" class="btn btn-warning btn-sm border">On stock</a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!-- <div class="row w-100 mx-0">
                            <div style="border:2px solid blue"></div>
                        </div> -->
                        <div class="row w-100 mx-0 mb-2 bg-light cd">
                        <?php
                        $myproducts=$prod->creator_products($search_orders[$i]['o_id'],$_COOKIE['client_id']);
                        $allstatus=$prod->showallstatus();

                        $count_general_products=0;
                        $count_exterior_products=0;
                        $count_interior_products=0;
                        
                        //print_r($myproducts);

                        for($j=0;$j<count($myproducts);$j++)
                        {
                            //echo substr($myproducts[$j]['prod_id'],1);
                            if(
                                (substr($myproducts[$j]['prod_id'], -3)=="1gb")||(substr($myproducts[$j]['prod_id'], -3)=="1gm")||(substr($myproducts[$j]['prod_id'], -3)=="1gt")
                            )
                            {
                                
                                $count_general_products++;
                            }
                        }

                        for($j=0;$j<count($myproducts);$j++)
                        {
                            //echo substr($myproducts[$j]['prod_id'],1);
                            if(
                            (substr($myproducts[$j]['prod_id'],1)>1159)&&(substr($myproducts[$j]['prod_id'],1)<1559)||
                            ($myproducts[$j]['prod_id']=="p116b")||($myproducts[$j]['prod_id']=="p116m")||
                            
                            ($myproducts[$j]['prod_id']=="p116t")||(substr($myproducts[$j]['prod_id'], -2)=="8s")||(substr($myproducts[$j]['prod_id'], -3)=="16v")||
                            (substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||
                            ($myproducts[$j]['prod_id']=="p156x")||($myproducts[$j]['prod_id']=="p156y")||($myproducts[$j]['prod_id']=="p156z")||
                            ($myproducts[$j]['prod_id']=="p166x")||($myproducts[$j]['prod_id']=="p166y")||($myproducts[$j]['prod_id']=="p166z")||($myproducts[$j]['prod_id']=="p166p")||
                            ($myproducts[$j]['prod_id']=="p176x")||($myproducts[$j]['prod_id']=="p176y")||($myproducts[$j]['prod_id']=="p176z")||
                            ($myproducts[$j]['prod_id']=="p186x")||($myproducts[$j]['prod_id']=="p186y")||($myproducts[$j]['prod_id']=="p186z")||
                            (substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||
                            (substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||
                            (substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900)
                            )
                            {
                                
                                $count_exterior_products++;
                            }
                        }

                        for($j=0;$j<count($myproducts);$j++)
                        {
                            
                            if(
                            (substr($myproducts[$j]['prod_id'],1)>1100)&&(substr($myproducts[$j]['prod_id'],1)<1160)||
                            (substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||
                            (substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||
                            (substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||
                            (substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||
                            (substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860)||
                            (substr($myproducts[$j]['prod_id'], -3)=="10v")
                            )
                            {
                                //echo substr($myproducts[$j]['prod_id'],1);
                                $count_interior_products++;
                            }
                        }

                        if($count_general_products>0)
                        {
                            $column_count=0;
                            ?>
                            <div class="row w-100 mx-0 creators_exterior">
                                <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 ">
                                    <?php
                                    
                                    for($j=0;$j<count($myproducts);$j++)
                                    {
                                        if(
                                            (substr($myproducts[$j]['prod_id'], -3)=="1gb")||(substr($myproducts[$j]['prod_id'], -3)=="1gm")||(substr($myproducts[$j]['prod_id'], -3)=="1gt")
                                        )
                                        {
                                            if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                                            {
                                                $column_count++;
                                            ?>
                                            </div> <!-- end column -->
                                            <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 "> 
                                            <?php    
                                            }
                                            
                                        ?>
                                        <p class="float-left">
                                        <a href="taskdetails.php?o_id=<?php echo $search_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                            for($k=0;$k<count($allstatus);$k++)
                                            {
                                                if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                                {
                                                    echo $allstatus[$k]['ost_color'];
                                                }
                                            }						
                                            ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                                        </p>
                                        <?php
                                        $column_count++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                       
                        if($count_exterior_products>0)
                        {
                            $column_count=0;
                            ?>
                            <div class="row w-100 mx-0 creators_exterior">
                                <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 ">
                                    <?php
                                    
                                    for($j=0;$j<count($myproducts);$j++)
                                    {
                                        if(
                                            (substr($myproducts[$j]['prod_id'],1)>1159)&&(substr($myproducts[$j]['prod_id'],1)<1559)||
                                            ($myproducts[$j]['prod_id']=="p116b")||($myproducts[$j]['prod_id']=="p116m")||
                                            ($myproducts[$j]['prod_id']=="p116t")||(substr($myproducts[$j]['prod_id'], -2)=="8s")||(substr($myproducts[$j]['prod_id'], -3)=="16v")||
                                            (substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||
                                        ($myproducts[$j]['prod_id']=="p156x")||($myproducts[$j]['prod_id']=="p156y")||($myproducts[$j]['prod_id']=="p156z")||
                                        ($myproducts[$j]['prod_id']=="p166x")||($myproducts[$j]['prod_id']=="p166y")||($myproducts[$j]['prod_id']=="p166z")||($myproducts[$j]['prod_id']=="p166p")||
                                        ($myproducts[$j]['prod_id']=="p176x")||($myproducts[$j]['prod_id']=="p176y")||($myproducts[$j]['prod_id']=="p176z")||
                                        ($myproducts[$j]['prod_id']=="p186x")||($myproducts[$j]['prod_id']=="p186y")||($myproducts[$j]['prod_id']=="p186z")||
                                        (substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||
                                        (substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||
                                        (substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900)
                                        )
                                        {
                                            if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                                            {
                                                $column_count++;
                                            ?>
                                            </div> <!-- end column -->
                                            <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 "> 
                                            <?php    
                                            }
                                            
                                        ?>
                                        <p class="float-left">
                                        <a href="taskdetails.php?o_id=<?php echo $search_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                            for($k=0;$k<count($allstatus);$k++)
                                            {
                                                if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                                {
                                                    echo $allstatus[$k]['ost_color'];
                                                }
                                            }						
                                            ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                                        </p>
                                        <?php
                                        $column_count++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }

                        if($count_interior_products>0)
                        {
                            $column_count=0;
                            ?>
                            <div class="col-md-4 text-left py-3 pl-4 colorline">
                                <?php
                                for($j=0;$j<count($myproducts);$j++)
                                {
                                    if(
                                        (substr($myproducts[$j]['prod_id'],1)>1100)&&(substr($myproducts[$j]['prod_id'],1)<1160)||
                                        (substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||
                                        (substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||
                                        (substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||
                                        (substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||
                                        (substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860)||
                                        (substr($myproducts[$j]['prod_id'], -3)=="10v")
                                        )
                                    {
                                        if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                                        {
                                            $column_count++;
                                        ?>
                                        </div> <!-- end column -->
                                        <div class="col-md-4 text-left py-3 pl-4 colorline"> 
                                        <?php    
                                        }
                                        
                                    ?>
                                    <p class="float-left">
                                    <a href="taskdetails.php?o_id=<?php echo $search_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                        for($k=0;$k<count($allstatus);$k++)
                                        {
                                            if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                            {
                                                echo $allstatus[$k]['ost_color'];
                                            }
                                        }						
                                        ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                                    </p>
                                    <?php
                                        $column_count++;
                                    }
                                }
                                ?>
                            </div>
                        
                            <?php
                        }
                        ?>
                            <br>
                        </div>
                        <?php
                    }
                }

            }
            else
            {

            //end search
            //start unfinished
        
			for($i=0;$i<count($unfinished_orders);$i++)
			{
				$o_status=$prod->get_order($unfinished_orders[$i]['o_id']);
				
				if(($o_status['o_status']<8)&&($o_status['on_stock']!=1))
				{
				    ?>
                    <div class="row light-grey w-100 mx-0 mt-2 py-2">
                        <div class="col-md-1">
                                    Order ID <?php echo $unfinished_orders[$i]['o_id']; 
                                    if($o_status['om_id']!=0)
                                    {
                                        echo "-".$o_status['om_id'];
                                    }?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $o_status['order_name']; ?>
                            <br>
                            <?php
                            $plot_ids_array=explode('|',$o_status['plot_id']);
                            
                            if((!empty($plot_ids_array))&&(!empty($o_status['plot_id'])))
                            {
                            ?>
                            Plot ID: <a href="own_tasks.php?search_option=plot_id&search=<?php echo $plot_ids_array[1];?>"><?php echo $plot_ids_array[1];?></a> 
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        if($o_status['o_deadline']!="0000-00-00 00:00:00")
                        {
                        ?>
                        <div class="col-md-4">
                        <span class="text-danger">Deadline: <span id="o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>"><?php 
                            echo $o_status['o_deadline'];?></span> UTC+0</span>
                        <input type="hidden" id="new_o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>" name="new_o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>" value="<?php
                        echo $new_o_deadline=$prod->get_deadline_without_weekends($o_status['o_deadline']);
                        ?>">
                        <br><span class="text-danger">Time left: <b><span id="timeleft<?php echo $unfinished_orders[$i]['o_id'];?>" class="blink"></span></b></span>
                        <script type="text/javascript">
                            setInterval(function() {
                                    //var deadline = new Date($("#o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>").text());
                                    var deadline=moment.tz($('#new_o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>').text(),'UTC');
                                    var today=new Date();
                                    var diff=(new Date(deadline).getTime() - new Date(today).getTime());

                                    if(diff>(24*60*60*1000) || diff<0){
                                        $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').removeClass('blink');
                                    }else{
                                        $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').addClass('blink');
                                    }

                                }, 1000);
                            $(document).ready(function(){
                                // timeleft 
                                //var dateset = '<?php echo $o_status['o_deadline'];?>';
                                countdown_timeleft<?=$unfinished_orders[$i]['o_id']?>();
                            });

                            function countdown_timeleft<?=$unfinished_orders[$i]['o_id']?>(){

                                var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                            if(($('#new_o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>').val()!="")&&($('#new_o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>').val()!="No Deadline"))
                            {
                                var deadline_time = moment.tz($('#new_o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>').val(),'UTC');
                                var dateset = deadline_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm:ss');
                                $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').countdown(dateset, function(event) {
                                        //$(this).html(event.strftime('%d days %H:%M:%S'));
                                        $(this).html(event.strftime('%-D day%!D %H:%M:%S'));
                                    });
                            }
                            
                                if($('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').text()=="0 days 00:00:00")
                                {
                                    $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').removeClass('blink');
                                }

                            }
                        </script>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="col-md-2 pt-1">
                            <?php 
                            $tasks_available=$prod->count_available_tasks_by_orderid($unfinished_orders[$i]['o_id'],$_COOKIE['client_id']);
                            //if($tasks_available>0)
                            //{
                                ?>
                                <span class="dark-green p-1 border"><?php echo $tasks_available." task(s) available";?></span>
                                <?php
                            //}
                            ?>
                        </div>
                        <div class="col-md-3">
                            <a href="orderdetails.php?orderid=<?php echo $unfinished_orders[$i]['o_id'];?>" class="btn blue-light btn-sm border">View details</a>
                            <a href="https://bauvorschau.com/<?php echo $unfinished_orders[$i]['o_id'];?>" class="btn btn-primary btn-sm border" target="_blank">Presentation</a>
                            
                            <?php
                            if($o_status['on_stock']==1)
                            {
                            ?>
                            <a href="#" class="btn btn-warning btn-sm border">On stock</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- <div class="row w-100 mx-0">
                        <div style="border:2px solid blue"></div>
                    </div> -->
                    <div class="row w-100 mx-0 mb-2 bg-light cd">
                    <?php
                    $myproducts=$prod->creator_products($unfinished_orders[$i]['o_id'],$_COOKIE['client_id']);
                    $allstatus=$prod->showallstatus();

                    $count_general_products=0;
                    $count_exterior_products=0;
                    $count_interior_products=0;
                    
                    //print_r($myproducts);

                    for($j=0;$j<count($myproducts);$j++)
                    {
                        //echo substr($myproducts[$j]['prod_id'],1);
                        if(
                            (substr($myproducts[$j]['prod_id'], -3)=="1gb")||(substr($myproducts[$j]['prod_id'], -3)=="1gm")||(substr($myproducts[$j]['prod_id'], -3)=="1gt")
                            )
                        {                            
                            $count_general_products++;
                        }
                    }

                    for($j=0;$j<count($myproducts);$j++)
                    {
                        //echo substr($myproducts[$j]['prod_id'],1);
                        if(
                            (substr($myproducts[$j]['prod_id'],1)>1159)&&(substr($myproducts[$j]['prod_id'],1)<1559)||
                            ($myproducts[$j]['prod_id']=="p116b")||($myproducts[$j]['prod_id']=="p116m")||
                            ($myproducts[$j]['prod_id']=="p116t")||(substr($myproducts[$j]['prod_id'], -2)=="8s")||(substr($myproducts[$j]['prod_id'], -3)=="16v")||
                            (substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||
                            ($myproducts[$j]['prod_id']=="p156x")||($myproducts[$j]['prod_id']=="p156y")||
                            ($myproducts[$j]['prod_id']=="p156z")||($myproducts[$j]['prod_id']=="p166x")||
                            ($myproducts[$j]['prod_id']=="p166y")||($myproducts[$j]['prod_id']=="p166z")||($myproducts[$j]['prod_id']=="p166p")||
                            ($myproducts[$j]['prod_id']=="p176x")||($myproducts[$j]['prod_id']=="p176y")||
                            ($myproducts[$j]['prod_id']=="p176z")||($myproducts[$j]['prod_id']=="p186x")||
                            ($myproducts[$j]['prod_id']=="p186y")||($myproducts[$j]['prod_id']=="p186z")||
                            (substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||
                            (substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||
                            (substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900))
                        {
                            
                            $count_exterior_products++;
                        }
                    }

                    for($j=0;$j<count($myproducts);$j++)
                    {
                        
                        if(
                            (substr($myproducts[$j]['prod_id'],1)>1100)&&(substr($myproducts[$j]['prod_id'],1)<1160)||
                            (substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||
                        (substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||
                        (substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||
                        (substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||
                        (substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860)||
                        (substr($myproducts[$j]['prod_id'], -3)=="10v")||
                        ($myproducts[$j]['prod_id']=="p150x")||($myproducts[$j]['prod_id']=="p150y")||($myproducts[$j]['prod_id']=="p150z")||
                        ($myproducts[$j]['prod_id']=="p152x")||($myproducts[$j]['prod_id']=="p152y")||($myproducts[$j]['prod_id']=="p152z")||
                        ($myproducts[$j]['prod_id']=="p154x")||($myproducts[$j]['prod_id']=="p154y")||($myproducts[$j]['prod_id']=="p154z")||
                        ($myproducts[$j]['prod_id']=="p160x")||($myproducts[$j]['prod_id']=="p160y")||($myproducts[$j]['prod_id']=="p160z")||
                        ($myproducts[$j]['prod_id']=="p162x")||($myproducts[$j]['prod_id']=="p162y")||($myproducts[$j]['prod_id']=="p162z")||
                        ($myproducts[$j]['prod_id']=="p164x")||($myproducts[$j]['prod_id']=="p164y")||($myproducts[$j]['prod_id']=="p164z")||
                        ($myproducts[$j]['prod_id']=="p170x")||($myproducts[$j]['prod_id']=="p170y")||($myproducts[$j]['prod_id']=="p170z")||
                        ($myproducts[$j]['prod_id']=="p172x")||($myproducts[$j]['prod_id']=="p172y")||($myproducts[$j]['prod_id']=="p172z")||
                        ($myproducts[$j]['prod_id']=="p174x")||($myproducts[$j]['prod_id']=="p174y")||($myproducts[$j]['prod_id']=="p174z")||
                        ($myproducts[$j]['prod_id']=="p180x")||($myproducts[$j]['prod_id']=="p180y")||($myproducts[$j]['prod_id']=="p180z")||
                        ($myproducts[$j]['prod_id']=="p182x")||($myproducts[$j]['prod_id']=="p182y")||($myproducts[$j]['prod_id']=="p182z")||
                        ($myproducts[$j]['prod_id']=="p184x")||($myproducts[$j]['prod_id']=="p184y")||($myproducts[$j]['prod_id']=="p184z")
                        )
                        {
                            //echo substr($myproducts[$j]['prod_id'],1);
                            $count_interior_products++;
                        }
                    }

                    if($count_general_products>0)
                    {
                        $column_count=0;
                        ?>
                        <div class="row w-100 mx-0 creators_exterior">
                            <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 ">
                                <?php
                                
                                for($j=0;$j<count($myproducts);$j++)
                                {
                                    if(
                                        (substr($myproducts[$j]['prod_id'], -3)=="1gb")||(substr($myproducts[$j]['prod_id'], -3)=="1gm")||(substr($myproducts[$j]['prod_id'], -3)=="1gt")
                                        )
                                    {
                                        if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                                        {
                                            $column_count++;
                                        ?>
                                        </div> <!-- end column -->
                                        <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 "> 
                                        <?php    
                                        }
                                        
                                        ?>
                                        <p class="float-left">
                                        <a href="taskdetails.php?o_id=<?php echo $unfinished_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                            for($k=0;$k<count($allstatus);$k++)
                                            {
                                                if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                                {
                                                    echo $allstatus[$k]['ost_color'];
                                                }
                                            }						
                                            ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                                        </p>
                                        <?php
                                        $column_count++;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }

                    if($count_exterior_products>0)
                    {
                        $column_count=0;
                        ?>
                        <div class="row w-100 mx-0 creators_exterior">
                            <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 ">
                                <?php
                                $subo_name_counter=0;
                                for($j=0;$j<count($myproducts);$j++)
                                {
                                    if(
                                    (substr($myproducts[$j]['prod_id'],1)>1159)&&(substr($myproducts[$j]['prod_id'],1)<1159)||
                                    ($myproducts[$j]['prod_id']=="p116b")||($myproducts[$j]['prod_id']=="p116m")||
                                    ($myproducts[$j]['prod_id']=="p116t")||(substr($myproducts[$j]['prod_id'], -2)=="8s")||(substr($myproducts[$j]['prod_id'], -3)=="16v")||
                                    (substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||
                                    ($myproducts[$j]['prod_id']=="p156x")||($myproducts[$j]['prod_id']=="p156y")||($myproducts[$j]['prod_id']=="p156z")||
                                    ($myproducts[$j]['prod_id']=="p166x")||($myproducts[$j]['prod_id']=="p166y")||($myproducts[$j]['prod_id']=="p166z")||($myproducts[$j]['prod_id']=="p166p")||
                                    ($myproducts[$j]['prod_id']=="p176x")||($myproducts[$j]['prod_id']=="p176y")||($myproducts[$j]['prod_id']=="p176z")||
                                    ($myproducts[$j]['prod_id']=="p186x")||($myproducts[$j]['prod_id']=="p186y")||($myproducts[$j]['prod_id']=="p186z")||
                                    (substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||
                                    (substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||
                                    (substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900))
                                    {
                                        if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                                        {
                                            $column_count++;
                                            $subo_name_counter=0;
                                        ?>
                                        </div> <!-- end column -->
                                        <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 "> 
                                        <?php    
                                        }
                                        
                                    ?>
                                    <?php 
                                    if($subo_name_counter==0)
                                    {
                                        ?><span><b><?php
                                        if($myproducts[$j]['om_id']==0)
                                        {
                                            $subo_data['o_id']=$myproducts[$j]['o_id'];
                                        }
                                        else
                                        {
                                            $subo_data['o_id']=$myproducts[$j]['om_id'];
                                        }
                                    $subo_data['o_sub_id']=$myproducts[$j]['osub_id'];

                                    $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                                    
                                    echo $subo_name['subo_name'];
                                    $subo_name_counter++;
                                    ?></b></span><br><?php
                                    }
                                    ?>
                                    <p class="float-left">
                                    <a href="taskdetails.php?o_id=<?php echo $unfinished_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                        for($k=0;$k<count($allstatus);$k++)
                                        {
                                            if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                            {
                                                echo $allstatus[$k]['ost_color'];
                                            }
                                        }						
                                        ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                                    </p>
                                    <?php
                                    $column_count++;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }

                    if($count_interior_products>0)
                    {
                        $column_count=0;
                        ?>
                        <div class="col-md-4 text-left py-3 pl-4 colorline">
                            <?php
                            $subo_name_counter=0;
                            for($j=0;$j<count($myproducts);$j++)
                            {
                                if(
                                (substr($myproducts[$j]['prod_id'],1)>1100)&&(substr($myproducts[$j]['prod_id'],1)<1159)||
                                (substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||
                                (substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||
                                (substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||
                                (substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||
                                (substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860)||(substr($myproducts[$j]['prod_id'], -3)=="10v")||
                                ($myproducts[$j]['prod_id']=="p150x")||($myproducts[$j]['prod_id']=="p150y")||($myproducts[$j]['prod_id']=="p150z")||
                                ($myproducts[$j]['prod_id']=="p152x")||($myproducts[$j]['prod_id']=="p152y")||($myproducts[$j]['prod_id']=="p152z")||
                                ($myproducts[$j]['prod_id']=="p154x")||($myproducts[$j]['prod_id']=="p154y")||($myproducts[$j]['prod_id']=="p154z")||
                                ($myproducts[$j]['prod_id']=="p160x")||($myproducts[$j]['prod_id']=="p160y")||($myproducts[$j]['prod_id']=="p160z")||
                                ($myproducts[$j]['prod_id']=="p162x")||($myproducts[$j]['prod_id']=="p162y")||($myproducts[$j]['prod_id']=="p162z")||
                                ($myproducts[$j]['prod_id']=="p164x")||($myproducts[$j]['prod_id']=="p164y")||($myproducts[$j]['prod_id']=="p164z")||
                                ($myproducts[$j]['prod_id']=="p170x")||($myproducts[$j]['prod_id']=="p170y")||($myproducts[$j]['prod_id']=="p170z")||
                                ($myproducts[$j]['prod_id']=="p172x")||($myproducts[$j]['prod_id']=="p172y")||($myproducts[$j]['prod_id']=="p172z")||
                                ($myproducts[$j]['prod_id']=="p174x")||($myproducts[$j]['prod_id']=="p174y")||($myproducts[$j]['prod_id']=="p174z")||
                                ($myproducts[$j]['prod_id']=="p180x")||($myproducts[$j]['prod_id']=="p180y")||($myproducts[$j]['prod_id']=="p180z")||
                                ($myproducts[$j]['prod_id']=="p182x")||($myproducts[$j]['prod_id']=="p182y")||($myproducts[$j]['prod_id']=="p182z")||
                                ($myproducts[$j]['prod_id']=="p184x")||($myproducts[$j]['prod_id']=="p184y")||($myproducts[$j]['prod_id']=="p184z")
                                )
                                {
                                    if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                                    {
                                        $column_count++;
                                        $subo_name_counter=0;
                                    ?>
                                    </div> <!-- end column -->
                                    <div class="col-md-4 text-left py-3 pl-4 colorline"> 
                                    <?php    
                                    }
                                    
                                ?>
                                <?php 
                                    if($subo_name_counter==0)
                                    {
                                        ?><span><b><?php
                                        if($myproducts[$j]['om_id']==0)
                                        {
                                            $subo_data['o_id']=$myproducts[$j]['o_id'];
                                        }
                                        else
                                        {
                                            $subo_data['o_id']=$myproducts[$j]['om_id'];
                                        }
                                    $subo_data['o_sub_id']=$myproducts[$j]['osub_id'];

                                    $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                                    
                                    echo $subo_name['subo_name'];
                                    $subo_name_counter++;
                                    ?></b></span><br><?php
                                    }
                                    ?>
                                <p class="float-left">
                                <a href="taskdetails.php?o_id=<?php echo $unfinished_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                    for($k=0;$k<count($allstatus);$k++)
                                    {
                                        if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                        {
                                            echo $allstatus[$k]['ost_color'];
                                        }
                                    }						
                                    ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                                </p>
                                <?php
                                    $column_count++;
                                }
                            }
                            ?>
                        </div>
                    
                        <?php
                    }
                    ?>
                    <br>
                    </div>
                    <?php
				}
			}
            
            ?>
           
            <?php
            //showing on stock orders lower
            $stock_line=0;

            for($i=0;$i<count($unfinished_orders);$i++)
			{
				$o_status=$prod->get_order($unfinished_orders[$i]['o_id']);
				
				if(($o_status['o_status']<8)&&($o_status['on_stock']==1))
				{
                    if($stock_line==0)
                    {
                ?>
            <hr style="border: 5px solid yellow ;">
            <?php
            $stock_line++;
                    }
            ?>
			<div class="row light-grey w-100 mx-0 mt-2 py-2">
				<div class="col-md-1">
                Order ID <?php echo $unfinished_orders[$i]['o_id']; 
                if($o_status['om_id']!=0)
                {
                    echo "-".$o_status['om_id'];
                }?>
                </div>
                <div class="col-md-2">
                    <?php echo $o_status['order_name'];?>
                </div>
                <?php
                if($o_status['o_deadline']!="0000-00-00 00:00:00")
                {
                ?>
                <div class="col-md-2">
                <span class="text-danger">Deadline: <span id="o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>"><?php 
                    echo $o_status['o_deadline'];?></span> UTC+0</span>
                    <br><span class="text-danger">Time left: <b><span id="timeleft<?php echo $unfinished_orders[$i]['o_id'];?>" class="blink"></span></b></span>
                </div>
                <script type="text/javascript">
		            setInterval(function() {
                            //var deadline = new Date($("#o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>").text());
                            var deadline=moment.tz($('#o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>').text(),'UTC');
		                    var today=new Date();
		                    var diff=(new Date(deadline).getTime() - new Date(today).getTime());

		                    if(diff>(24*60*60*1000) || diff<0){
		                        $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').removeClass('blink');
		                    }else{
		                        $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').addClass('blink');
		                    }

		                }, 1000);
		            $(document).ready(function(){
		                // timeleft 
                        //var dateset = '<?php echo $o_status['o_deadline'];?>';
                        countdown_timeleft<?=$unfinished_orders[$i]['o_id']?>();
		            });

                    function countdown_timeleft<?=$unfinished_orders[$i]['o_id']?>(){

                        var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                        var deadline_time = moment.tz($('#o_deadline<?php echo $unfinished_orders[$i]['o_id'];?>').text(),'UTC');
                        var dateset = deadline_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm:ss');
                        $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').countdown(dateset, function(event) {
                                //$(this).html(event.strftime('%d days %H:%M:%S'));
                                $(this).html(event.strftime('%-D day%!D %H:%M:%S'));
                            });

                        if($('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').text()=="00 days 00:00:00")
                        {
                            $('#timeleft<?php echo $unfinished_orders[$i]['o_id'];?>').removeClass('blink');
                        }

                    }
		        </script>
                <?php
                }
                ?>
				<div class="col-md-2 pt-1">
					<?php 
					$tasks_available=$prod->count_available_tasks_by_orderid($unfinished_orders[$i]['o_id'],$_COOKIE['client_id']);
					//if($tasks_available>0)
					//{
						?>
						<span class="dark-green p-1 border"><?php echo $tasks_available." task(s) available";?></span>
						<?php
					//}
					?>
				</div>
				<div class="col-md-4">
				    <a href="orderdetails.php?orderid=<?php echo $unfinished_orders[$i]['o_id'];?>" class="btn blue-light btn-sm border">View details</a>
				    <a href="https://bauvorschau.com/<?php echo $unfinished_orders[$i]['o_id'];?>" class="btn btn-primary btn-sm border" target="_blank">Presentation</a>
                    
                    <?php
                    if($o_status['on_stock']==1)
                    {
                    ?>
                    <a href="#" class="btn btn-warning btn-sm border">On stock</a>
                    <?php
                    }
                    ?>
				</div>
			</div>
			<!-- <div class="row w-100 mx-0">
				<div style="border:2px solid blue"></div>
            </div> -->
        <div class="row w-100 mx-0 mb-2 bg-light cd">
            <?php
            $myproducts=$prod->creator_products($unfinished_orders[$i]['o_id'],$_COOKIE['client_id']);
            $allstatus=$prod->showallstatus();
            
            $count_exterior_products=0;
            $count_interior_products=0;

            

            for($j=0;$j<count($myproducts);$j++)
            {
                if((substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||($myproducts[$j]['prod_id']=="p156x")||
                ($myproducts[$j]['prod_id']=="p156y")||($myproducts[$j]['prod_id']=="p156z")||($myproducts[$j]['prod_id']=="p166x")||($myproducts[$j]['prod_id']=="p166p")||
                ($myproducts[$j]['prod_id']=="p166y")||($myproducts[$j]['prod_id']=="p166z")||($myproducts[$j]['prod_id']=="p176x")||
                ($myproducts[$j]['prod_id']=="p176y")||($myproducts[$j]['prod_id']=="p176z")||($myproducts[$j]['prod_id']=="p186x")||
                ($myproducts[$j]['prod_id']=="p186y")||($myproducts[$j]['prod_id']=="p186z")||(substr($myproducts[$j]['prod_id'], -3)=="16v")||
                (substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||
                (substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||
                (substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900))
                {
                    $count_exterior_products++;
                }
            }
            
            for($j=0;$j<count($myproducts);$j++)
            {
                if(
                (substr($myproducts[$j]['prod_id'],1)>1100)&&(substr($myproducts[$j]['prod_id'],1)<1160)||
                (substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||
                (substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||
                (substr($myproducts[$j]['prod_id'], -3)=="10v")||
                ($myproducts[$j]['prod_id']=="p150x")||($myproducts[$j]['prod_id']=="p150y")||($myproducts[$j]['prod_id']=="p150z")||
                ($myproducts[$j]['prod_id']=="p152x")||($myproducts[$j]['prod_id']=="p152y")||($myproducts[$j]['prod_id']=="p152z")||
                ($myproducts[$j]['prod_id']=="p154x")||($myproducts[$j]['prod_id']=="p154y")||($myproducts[$j]['prod_id']=="p154z")||
                (substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||
                ($myproducts[$j]['prod_id']=="p160x")||($myproducts[$j]['prod_id']=="p160y")||($myproducts[$j]['prod_id']=="p160z")||
                ($myproducts[$j]['prod_id']=="p162x")||($myproducts[$j]['prod_id']=="p162y")||($myproducts[$j]['prod_id']=="p162z")||
                ($myproducts[$j]['prod_id']=="p164x")||($myproducts[$j]['prod_id']=="p164y")||($myproducts[$j]['prod_id']=="p164z")||
                (substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||
                ($myproducts[$j]['prod_id']=="p170x")||($myproducts[$j]['prod_id']=="p170y")||($myproducts[$j]['prod_id']=="p170z")||
                ($myproducts[$j]['prod_id']=="p172x")||($myproducts[$j]['prod_id']=="p172y")||($myproducts[$j]['prod_id']=="p172z")||
                ($myproducts[$j]['prod_id']=="p174x")||($myproducts[$j]['prod_id']=="p174y")||($myproducts[$j]['prod_id']=="p174z")||
                (substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860)||
                ($myproducts[$j]['prod_id']=="p180x")||($myproducts[$j]['prod_id']=="p180y")||($myproducts[$j]['prod_id']=="p180z")||
                ($myproducts[$j]['prod_id']=="p182x")||($myproducts[$j]['prod_id']=="p182y")||($myproducts[$j]['prod_id']=="p182z")||
                ($myproducts[$j]['prod_id']=="p184x")||($myproducts[$j]['prod_id']=="p184y")||($myproducts[$j]['prod_id']=="p184z")
                )
                {
                    $count_interior_products++;
                }
            }

           

            if($count_exterior_products>0)
            {
                $column_count=0;
            ?>
            <div class="row w-100 mx-0 creators_exterior">
                <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4 ">
					<?php
								
					for($j=0;$j<count($myproducts);$j++)
					{
                        if(
                        (substr($myproducts[$j]['prod_id'],1)>1159)&&(substr($myproducts[$j]['prod_id'],1)<1159)||
                        ($myproducts[$j]['prod_id']=="p116b")||($myproducts[$j]['prod_id']=="p116m")||
                        ($myproducts[$j]['prod_id']=="p116t")||(substr($myproducts[$j]['prod_id'], -2)=="8s")||(substr($myproducts[$j]['prod_id'], -3)=="16v")||
                        (substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||
                        ($myproducts[$j]['prod_id']=="p156x")||($myproducts[$j]['prod_id']=="p156y")||($myproducts[$j]['prod_id']=="p156z")||
                        ($myproducts[$j]['prod_id']=="p166x")||($myproducts[$j]['prod_id']=="p166y")||($myproducts[$j]['prod_id']=="p166z")||($myproducts[$j]['prod_id']=="p166p")||
                        ($myproducts[$j]['prod_id']=="p176x")||($myproducts[$j]['prod_id']=="p176y")||($myproducts[$j]['prod_id']=="p176z")||
                        ($myproducts[$j]['prod_id']=="p186x")||($myproducts[$j]['prod_id']=="p186y")||($myproducts[$j]['prod_id']=="p186z")||
                        (substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||
                        (substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||
                        (substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900))
                        {
                            if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                            {
                                $column_count++;
                            ?>
                            </div> <!-- end column -->
                            <div id="column<?php echo $column_count;?>" class="col-md-4 text-left py-3 pl-4"> 
                            <?php    
                            }
                            ?>
                        
                            <p class="float-left">
                            <a href="taskdetails.php?o_id=<?php echo $unfinished_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                for($k=0;$k<count($allstatus);$k++)
                                {
                                    if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                    {
                                        echo $allstatus[$k]['ost_color'];
                                    }
                                }						
                                ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                            </p>
                        <?php
                            $column_count++;
                        }
					}
					?>
				</div>
            </div> 
            <?php
            }

            if($count_interior_products>0)
            {
                $column_count=0;
            ?>
			<!--<div class="row w-100 mx-0 mb-2 bg-light cd"> -->
				<div class="col-md-4 text-left py-3 pl-4 colorline">
					<?php
					$myproducts=$prod->creator_products($unfinished_orders[$i]['o_id'],$_COOKIE['client_id']);
					$allstatus=$prod->showallstatus();
					
					for($j=0;$j<count($myproducts);$j++)
					{
                        if(
                        (substr($myproducts[$j]['prod_id'],1)>1100)&&(substr($myproducts[$j]['prod_id'],1)<1160)||
                        (substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||
                        (substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||
                        (substr($myproducts[$j]['prod_id'], -3)=="10v")||
                        ($myproducts[$j]['prod_id']=="p150x")||($myproducts[$j]['prod_id']=="p150y")||($myproducts[$j]['prod_id']=="p150z")||
                        ($myproducts[$j]['prod_id']=="p152x")||($myproducts[$j]['prod_id']=="p152y")||($myproducts[$j]['prod_id']=="p152z")||
                        ($myproducts[$j]['prod_id']=="p154x")||($myproducts[$j]['prod_id']=="p154y")||($myproducts[$j]['prod_id']=="p154z")||
                        (substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||
                        ($myproducts[$j]['prod_id']=="p160x")||($myproducts[$j]['prod_id']=="p160y")||($myproducts[$j]['prod_id']=="p160z")||
                        ($myproducts[$j]['prod_id']=="p162x")||($myproducts[$j]['prod_id']=="p162y")||($myproducts[$j]['prod_id']=="p162z")||
                        ($myproducts[$j]['prod_id']=="p164x")||($myproducts[$j]['prod_id']=="p164y")||($myproducts[$j]['prod_id']=="p164z")||
                        (substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||
                        ($myproducts[$j]['prod_id']=="p170x")||($myproducts[$j]['prod_id']=="p170y")||($myproducts[$j]['prod_id']=="p170z")||
                        ($myproducts[$j]['prod_id']=="p172x")||($myproducts[$j]['prod_id']=="p172y")||($myproducts[$j]['prod_id']=="p172z")||
                        ($myproducts[$j]['prod_id']=="p174x")||($myproducts[$j]['prod_id']=="p174y")||($myproducts[$j]['prod_id']=="p174z")||
                        (substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860)||
                        ($myproducts[$j]['prod_id']=="p180x")||($myproducts[$j]['prod_id']=="p180y")||($myproducts[$j]['prod_id']=="p180z")||
                        ($myproducts[$j]['prod_id']=="p182x")||($myproducts[$j]['prod_id']=="p182y")||($myproducts[$j]['prod_id']=="p182z")||
                        ($myproducts[$j]['prod_id']=="p184x")||($myproducts[$j]['prod_id']=="p184y")||($myproducts[$j]['prod_id']=="p184z")
                        )
                        {
                            if(($column_count>0)&&($myproducts[$j]['osub_id']!=$myproducts[$j-1]['osub_id']))
                            {
                                $column_count++;
                            ?>
                            </div> <!-- end column -->
                            <div class="col-md-4 text-left py-3 pl-4 colorline"> 
                            <?php    
                            }
                            ?>
                            <p class="float-left">
                            <a href="taskdetails.php?o_id=<?php echo $unfinished_orders[$i]['o_id'];?>&osub_id=<?php echo $myproducts[$j]['osub_id'];?>&prod_id=<?php echo $myproducts[$j]['prod_id'];?>" class="p-1 border <?php 
                                for($k=0;$k<count($allstatus);$k++)
                                {
                                    if($allstatus[$k]['ost_id']==$myproducts[$j]['p_status'])
                                    {
                                        echo $allstatus[$k]['ost_color'];
                                    }
                                }						
                                ?>"><?php echo $myproducts[$j]['osub_id'].".".$myproducts[$j]['prod_id'];?></a>
                            </p>
                            <?php
                            $column_count++;
                        }
					}
					?>
				</div>
			<!--</div> -->
			<br>
                <?php
            }
            ?>
        </div>
        <?php
        }
    }
            //end unfinished
            //start finished
			if(!empty($finished_orders))
            {
                for($i=0;$i<count($finished_orders);$i++)
                {
                    $o_status=$prod->get_order($finished_orders[$i]['o_id']);
                    if($o_status['o_status']==8)
                    {
                        ?>
                        <div class="row w-100 radius mx-0 py-2 
                            <?php
                            if($o_status['o_status']==0)
                            {
                                echo "white";
                            }
                            
                            if($o_status['o_status']==1)
                            {
                                echo "blue-light";
                            }
                            
                            if($o_status['o_status']==2)
                            {
                                echo "blue";
                            }
                            if($o_status['o_status']==3)
                            {
                                echo "light-green";
                            }
                            
                            if($o_status['o_status']==4)
                            {
                                echo "dark-green";
                            }
                            if($o_status['o_status']==5)
                            {
                                echo "yellow-light";
                            }
                            if($o_status['o_status']==6)
                            {
                                echo "yellow";
                            }
                            
                            if($o_status['o_status']==7)
                            {
                                echo "orange";
                            }
                            if($o_status['o_status']==8)
                            {
                                echo "black";
                            }
                            if($o_status['o_status']==9)
                            {
                                echo "red";
                            }
                            
                            if($o_status['o_status']==10)
                            {
                                echo "white";
                            }
                            
                            if($o_status['o_status']==12)
                            {
                                echo "violet";
                            }
                            ?>">
                            <div class="col-md-1">
                                Order ID <?php echo $finished_orders[$i]['o_id']; 
                                if($o_status['om_id']!=0)
                                {
                                    echo "-".$o_status['om_id'];
                                }?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $o_status['order_name']; ?>
                            </div>
                            <?php
                            if($o_status['o_deadline']!="0000-00-00 00:00:00")
                            {
                            ?>
                            <div class="col-md-4">
                            <span class="text-danger">Deadline: <?php 
                                echo $o_status['o_deadline'];?> UTC+0</span>
                            </div>
                            <?php
                            }
                            ?>
                            <!-- <div class="col-md-2">
                                <?php 
                                $tasks_available=$prod->count_available_tasks_by_orderid($finished_orders[$i]['o_id'],$_COOKIE['client_id']);
                                if($tasks_available>0)
                                {
                                    ?>
                                    <span class="dark-green"><?php echo $tasks_available." task(s) available";?></span>
                                    <?php
                                }
                                ?>
                            </div> -->
                            <div class="col-md-5 d-flex justify-content-end">
                            <a href="orderdetails.php?orderid=<?php echo $finished_orders[$i]['o_id'];?>" class="btn blue-light btn-sm mr-2" style="color:black !important">View details</a>
                            <a href="https://bauvorschau.com/<?php echo $finished_orders[$i]['o_id'];?>" class="btn btn-primary btn-sm" target="_blank">Presentation</a>
                            
                            </div>
                        </div>
                        <br>
                        <?php
                    }
                }
            }      
        } //end no search
			?>

			<br>
			
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="center_message">
                                <?php
                                if($page>1)
                                {
                                ?>
                                <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $page-1;?>" class="btn btn-primary btn-sm">Previous</a>
                                <?php
                                }
                                ?>
                                <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $page;?>"><?php echo $page;?></a>
                                <?php
                                if($pages>=0)
                                {
                                ?>
                                <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $page+1;?>" class="btn btn-primary btn-sm">Next</a>
                                <?php
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container -->
			
                    <?php
                    $check_existing_working_hours=$prod->check_existing_working_hours($_COOKIE['client_id']);
                    $creator_end_time=$prod->get_creator_end_time($_COOKIE['client_id']);
                    $work_start_time=date("Y-m-d H:m:s");
                    ?>

                    <script type="text/javascript">
                        $(document).ready(function(){

                            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                            
                            var initial_work_end_date_time=moment.tz($('#today_endUTCtime').val(),'UTC');
                            var new_work_end_date_time=initial_work_end_date_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm');
                            
                            $('#work_end_time').val(new_work_end_date_time);

                            $('#startUTCtime').val($('#work_start_time').val());
                            
                            $.datetimepicker.setLocale('en');

                            $('#work_end_time').datetimepicker({
                                lang:'en',
                                format:'Y-m-d H:i',
                                formatDate:'Y-m-d',
                                formatTime:'H:i',
                                step: 30,
                                allowTimes:[
                                    '14:00','14:30','15:00','15:30', '16:00', '16:30','17:00','17:30', '18:00', '18:30','19:00', '19:30','20:00','20:30', '21:00','21:30', '22:00','22:30', '23:00','23:30','00:00'
                                    ],
                                onShow:function( ct ){
                                this.setOptions({
                                    minDate:jQuery('#work_start_time').val()?jQuery('#work_start_time').val():false,
                                    
                                })
                                },
                                
                            });

                            <?php
                            if($_COOKIE['start']<$creator_end_time['end_time'])
                            {
                                ?>
                                $('#choose_working_hours').modal('hide');
                                <?php
                            }
                            else
                            {
                                ?>
                                $('#choose_working_hours').modal('show');
                                <?php
                            }
                            ?>
                        });
                    </script>

                    <div class="modal fade" id="choose_working_hours" tabindex="-1" aria-labelledby="choose_working_hours_label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="choose_working_hours_label">Choose today's working hours:</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    
                                    <form id="choose_working_hours_form" name="choose_working_hours_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"></form>
                                    <input type="hidden" name="startUTCtime" id="startUTCtime" value="" form="choose_working_hours_form">
                                    <input type="hidden" name="endUTCtime" id="endUTCtime" value="" form="choose_working_hours_form">

                                    <div class="row">
                                        <!-- <div class="col-md-12">
                                            Start: <input type="text" class="form-control form-control-sm" id="work_start_time" name="work_start_time" value="<?php echo gmdate("Y-m-d H:i")?>" autocomplete="off" required>
                                        </div> -->
                                        <input type="hidden" id="work_start_time" name="work_start_time" value="<?php echo gmdate("Y-m-d H:i");?>" form="choose_working_hours_form">
                                        <input type="hidden" id="today_endUTCtime" name="today_endUTCtime" value="<?php 
                                        $month=date("m");
                                        $year=date("Y");
                                        $day_number=date("d")+1-1;
                                        $day=date("d");

                                        $today_end_time=$prod->get_uca_program($_COOKIE['client_id'],$month,$year);

                                        $today_db_end_column="work_end_time".$day_number;
                                        
                                        if(!empty($today_end_time[$today_db_end_column]))
                                        {
                                            echo $year."-".$month."-".$day." ".$today_end_time[$today_db_end_column];
                                        }
                                        ?>" form="choose_working_hours_form">
                                        <div class="col-md-12">
                                            End time: <input type="text" class="form-control form-control-sm" id="work_end_time" name="work_end_time" value="" autocomplete="off" required form="choose_working_hours_form">
                                        </div>	
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="save_work_time_btn" id="save_work_time_btn" class="btn btn-primary" form="choose_working_hours_form">Save changes</button>
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            setTimeout(function(){

                                                if($('#work_end_time').val()!="")
                                                {
                                                    var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                                    var selected_end_date=moment.tz($('#work_end_time').val(),user_timezone)
                                                    var selected_utc_end_time=selected_end_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                                    $('#endUTCtime').val(selected_utc_end_time);
                                                }
                                                
                                            }, 1000);
                                        });

                                        $('#work_end_time').on('change focuskeyup paste mouseup',function(){

                                            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                            var selected_end_date=moment.tz($('#work_end_time').val(),user_timezone)
                                            var selected_utc_end_time=selected_end_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                            $('#endUTCtime').val(selected_utc_end_time);
                                            
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end modal -->
                    <?php
                    /*
                    //$check_existing_working_hours=$prod->check_existing_working_hours($_COOKIE['client_id']);
                    $creator_end_time=$prod->get_creator_end_time($_COOKIE['client_id']);
                    //$work_start_time=date("Y-m-d H:m:s");
                    ?>
                    <input type="hidden" name="startUTCtime" id="startUTCtime" value="" form="choose_working_hours_form">
                    <input type="hidden" name="endUTCtime" id="endUTCtime" value="" form="choose_working_hours_form">	
                    <div id="choose_working_hours" title="Choose working hours">
                        <form id="choose_working_hours_form" name="choose_working_hours_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                
                            <div class="row">
                                <div class="col-md-12 text-success">
                                    Choose today's working hours:
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-12">
                                    Start: <input type="text" class="form-control form-control-sm" id="work_start_time" name="work_start_time" value="<?php echo gmdate("Y-m-d H:i")?>" autocomplete="off" required>
                                </div> -->
                                <input type="hidden" id="work_start_time" name="work_start_time" value="<?php echo gmdate("Y-m-d H:i");?>">
                                <input type="hidden" id="today_endUTCtime" name="today_endUTCtime" value="<?php 
                                $month=date("m");
                                $year=date("Y");
                                $day_number=date("d")+1-1;
                                $day=date("d");

                                $today_end_time=$prod->get_uca_program($_COOKIE['client_id'],$month,$year);

                                $today_db_end_column="work_end_time".$day_number;
                                
                                if(!empty($today_end_time[$today_db_end_column]))
                                {
                                    echo $year."-".$month."-".$day." ".$today_end_time[$today_db_end_column];
                                }
                                ?>">
                                <div class="col-md-12">
                                    End time: <input type="text" class="form-control form-control-sm" id="work_end_time" name="work_end_time" value="" autocomplete="off" required>
                                </div>	
                            </div>
                            <?php
                            
                            $today=$prod->get_day_name($year,$month,$day);
                            
                            $nr_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            
                            $nextday=$day+1;
                            
                            if($nextday>$nr_days_in_month)
                            {
                                $nextday=1;$month++;
                                if($month==13)
                                {
                                    $month="01";
                                    $year=date("Y")+1;
                                }
                            }

                            $uca_program=$prod->get_uca_program($_COOKIE['client_id'],$month,$year);

                            //print_r($uca_program);

                            //echo $nextday." ".$month;
                            
                            $next_day_name=$prod->get_day_name($year,$month,$nextday);

                            $db_start_column="work_start_time".$nextday;
                            $db_end_column="work_end_time".$nextday;
                            
                            if(!empty($uca_program))
                            {
                                if((($uca_program[$db_start_column]=="22:00")&&($uca_program[$db_end_column]=="22:00"))||(($uca_program[$db_start_column]=="00:00")&&($uca_program[$db_end_column]=="00:00"))||((empty($uca_program[$db_start_column]))&&(empty($uca_program[$db_end_column]))))
                                {
                                    ?>
                                    <input type="hidden" name="next_startUTCtime" id="next_startUTCtime" value="">
                                    <input type="hidden" name="next_endUTCtime" id="next_endUTCtime" value="">
                                    <input type="hidden" name="next_working_date" id="next_working_date" value="<?php 
                                    // if($nextday<10)
                                    // {
                                    //     echo $year."-".$month."-0".$nextday;
                                    // }
                                    // else
                                    // {
                                        echo $year."-".$month."-".$nextday;
                                    //}?>">
                                    <div class="row">
                                        <div class="col-md-12 text-danger">
                                            Choose next day's working hours:
                                        </div>
                                    </div>	
                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                            <input type="text" class="form-control form-control-sm" name="next_start_time" id="next_start_time" placeholder="Start time">
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <input type="text" class="form-control form-control-sm" name="next_end_time" id="next_end_time" placeholder="End time">
                                        </div>
                                    </div>	
                                    <?php
                                }
                            }
                            ?>
                            <button type="submit" name="ok_btn" style="position:absolute;top:-1000px;">OK</button>
                        </form>	
			        </div>
			
                    <script type="text/javascript">
                            $(document).ready(function(){				
                            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                            
                            var initial_work_end_date_time=moment.tz($('#today_endUTCtime').val(),'UTC');
                            var new_work_end_date_time=initial_work_end_date_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm');
                            
                            $('#work_end_time').val(new_work_end_date_time);

                            $('#startUTCtime').val($('#work_start_time').val());

                            /*$('#work_start_time').on('change keyup paste mouseup',function(){
                                var selected_start_date=moment.tz($('#work_start_time').val(),user_timezone);
                                var selected_utc_start_time=selected_start_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                $('#startUTCtime').val(selected_utc_start_time);
                            });*//*
                            
                            $('#next_start_time').on('change',function(){
                                
                            
                                var next_selected_start_date=moment.tz($('#next_start_time').val(),user_timezone);
                                var next_selected_utc_start_time=next_selected_start_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                $('#next_startUTCtime').val(next_selected_utc_start_time);
                            
                            });
                                
                            $('#next_end_time').on('change',function(){
                            
                                    var next_selected_end_date=moment.tz($('#next_end_time').val(),user_timezone)
                                    var selected_utc_end_time=next_selected_end_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                    $('#next_endUTCtime').val(selected_utc_end_time);
                            
                            });

                            $('#work_end_time').on('change keyup paste mouseup',function(){
                                var selected_end_date=moment.tz($('#work_end_time').val(),user_timezone)
                                var selected_utc_end_time=selected_end_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                $('#endUTCtime').val(selected_utc_end_time);
                            });

                            $('#choose_working_hours_form').validate();
                            
                            $( "#choose_working_hours" ).dialog({
                                autoOpen: <?php 
                                if($_COOKIE['start']<$creator_end_time['end_time'])
                                {    
                                    echo "false";
                                }
                                else
                                {
                                    echo "true";
                                }?>, 
                                width: 400,
                                height: 300,
                                modal: true,
                                buttons: [
                                {
                                    text: "OK",
                                    click: function() {
                                        /*var selected_start_date=moment.tz($('#work_start_time').val(),user_timezone);
                                        var selected_utc_start_time=selected_start_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                        alert($('#startUTCtime').val(selected_utc_start_time));
                                        
                                        var selected_end_date=moment.tz($('#work_end_time').val(),user_timezone)
                                        var selected_utc_end_time=selected_end_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
                                        alert($('#endUTCtime').val(selected_utc_end_time));
                                *//*
                                        $("#choose_working_hours_form").submit();							
                                        },
                                    type: "submit",
                                    form: "choose_working_hours_form"
                                },
                                {
                                    text:"Cancel",
                                    click: function() {$(this).dialog("close");}
                                },
                                ]
                                });
                                /*$( "#choose_creators_btn_<?php echo $row['o_id']; ?>" ).click(function() {
                                $( "#choose_creators_dialog_<?php echo $row['o_id']; ?>" ).dialog( "open" );*//*
                            
                            
                            $.datetimepicker.setLocale('en');
                            /*$('#work_start_time').datetimepicker({
                                lang:'en',
                                format:'Y-m-d H:i',
                                formatDate:'Y-m-d',
                                formatTime:'H:i',
                                step: 30,
                                allowTimes:[
                                    '7:00', '8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00','15:00', '16:00'
                                    ],
                                onShow:function( ct ){
                                this.setOptions({
                                    maxDate:jQuery('#work_end_time').val()?jQuery('#work_end_time').val():false,
                                    
                                })
                                },
                                
                            });*//*
                            $('#work_end_time').datetimepicker({
                                lang:'en',
                                format:'Y-m-d H:i',
                                formatDate:'Y-m-d',
                                formatTime:'H:i',
                                step: 30,
                                allowTimes:[
                                    '14:00','14:30','15:00','15:30', '16:00', '16:30','17:00','17:30', '18:00', '18:30','19:00', '19:30','20:00','20:30', '21:00','21:30', '22:00','22:30', '23:00','23:30','00:00'
                                    ],
                                onShow:function( ct ){
                                this.setOptions({
                                    minDate:jQuery('#work_start_time').val()?jQuery('#work_start_time').val():false,
                                    
                                })
                                },
                                
                            });


                            var tomorrow=new Date();

                            tomorrow.setDate(tomorrow.getDate()+1);

                            $('#next_start_time').datetimepicker({
                                startDate:tomorrow,
                                lang:'en',
                                format:'Y-m-d H:i',
                                formatDate:'Y-m-d',
                                formatTime:'H:i',
                                step: 30,
                                allowTimes:[
                                    '7:00','7:30','8:00','8:30', '9:00', '9:30','10:00','10:30', '11:00', '11:30','12:00', '12:30','13:00','13:30', '14:00','14:30', '15:00','15:30', '16:00','16:30'
                                    ],
                                /*onShow:function( ct ){
                                this.setOptions({
                                    minDate:tomorrow,
                                    
                                })
                                },*//*
                                
                            });

                            $('#next_end_time').datetimepicker({
                                // startDate:tomorrow,
                                lang:'en',
                                format:'Y-m-d H:i',
                                formatDate:'Y-m-d',
                                formatTime:'H:i',
                                step: 30,
                                allowTimes:[
                                    '14:00','14:30','15:00','15:30', '16:00', '16:30','17:00','17:30', '18:00', '18:30','19:00', '19:30','20:00','20:30', '21:00','21:30', '22:00','22:30', '23:00','23:30','00:00'
                                    ],
                                onShow:function( ct ){
                                this.setOptions({
                                    minDate:jQuery('#next_start_time').val()?jQuery('#next_start_time').val():false,
                                    
                                })
                                },
                                
                            });
                        });
                    </script> */ ?>
			</div>	<!-- end container -->
			<?php
			//include('online_creators.php');
		}
		else
		{
            session_unset();
            session_destroy();
			?>
            <script type="text/javascript">
                Cookies.remove("session_id");
                Cookies.remove("start");
                Cookies.remove("client_id");
                Cookies.remove("client");
                Cookies.remove("own_tasks");
                Cookies.remove("cdesign");
                Cookies.remove("change_vat");
                Cookies.remove("l_first_name");
                Cookies.remove("l_last_name");
                Cookies.remove("c_first_name");
                Cookies.remove("c_last_name");
                Cookies.remove("email");
                Cookies.remove("useradmin");
                Cookies.remove("programs_of_employees");
                Cookies.remove("contracting");
                Cookies.remove("bookkeeping");
                Cookies.remove("coordination");
                Cookies.remove("plansets");
                Cookies.remove("housesets");
                Cookies.remove("plots");
                Cookies.remove("view_all_orders");
                Cookies.remove("activity_view");
                Cookies.remove("apu_lists");
                Cookies.remove("examples_db");
                Cookies.remove("translations");
                Cookies.remove("company");
                Cookies.remove("lt_id");
                Cookies.remove("ip_address");
                Cookies.remove("user_agent");
                Cookies.remove("expire");
            </script>
			<div class="center_message">				
				<div class="error">You must be logged in to view this page !</div>
				<a href="index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=index.php">
			<?php
		}
		?>
	</article>
</section>
<?php
include('footer.php');
?>