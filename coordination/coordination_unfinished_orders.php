<?php

//getting creator's team

$creator_team=$prod->check_creators_team($_SESSION['client_id']);
?>
<div id="unfinished_team_orders">
<input type="hidden" name="my_team" id="my_team" value="<?php echo $creator_team[0]['team_id'];?>">

</div>
<script type="text/javascript">
$(document).ready(function(){
    //showing team orders first
    var my_team=$('#my_team').val();

    $('.teams').each(function(){
        current_team=$(this).val();
        if(my_team==current_team)
        {
            $(this).parent().parent().parent().parent().parent().parent().parent().parent().appendTo($('#unfinished_team_orders'));
        }
    });
});
</script>
<hr style="border:2px solid #000;">
<?php
if($_SESSION['view_all_orders']==1)
{
    $orders=$prod->show_unfinished_orders_by_on_stock($on_stock);
}
else
{
    //$client=$prod->get_client($_SESSION['client_id']);

    //$licence_sites=explode(";",$client['ls_ids']);

    //for($l=0;$l<count($licence_sites);$l++)
   // {

    //$orders=$prod->show_unfinished_orders_by_ls_id_on_stock($licence_sites[0],$on_stock); //1 website for now
    //}
    $lic_ids_array=array();

    for($l=0;$l<count($licences);$l++)
    {
        $lic_ids_array[]=$licences[$l]['lic_id'];
    }
    //print_r($lic_ids_array);
    $orders=$prod->show_unfinished_orders_by_lic_ids_on_stock($lic_ids_array,$on_stock);
}

for($i=0;$i<count($orders);$i++)
{
?>
<div class="row mx-0 w-100 mb-4" id="projectid<?php echo $orders[$i]['order_ID'];?>">
    <div class="row mx-0 w-100 bg-table interface">
        <div class="col-12 col-xl-3 text-center text-xl-left">
            <div class="row mx-0 px-0 w-100">
                <div class="col-xl-12 px-0">
                    <p class="text-left client mb-0">
                    <?php echo $orders[$i]['order_ID'];
                    if($orders[$i]['om_id']>0)
                    {
                        echo "-".$orders[$i]['om_id'];
                    }
                    ?>
                    <?php 
                    $client=$prod->get_client($orders[$i]['u_client_ID']);
                    if(!empty($client['c_last_name']))
                    {
                        echo $client['clientname']." - ".$client['c_first_name'].", ".$client['c_last_name'];
                    }
                    else
                    {
                        echo $client['clientname']." - ".$client['l_first_name'].", ".$client['l_last_name'];
                    }
                    ?></p>
                    <span class="text-danger">Time left: <b><span id="timeleft<?php echo $orders[$i]['order_ID'];?>" class="blink"></span></b></span>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Producer: <?php
                            echo $prod->get_company($orders[$i]['u_prod_id'])['mailnick'];
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="d-inline-flex">
                                <span>Team: </span>
                                <select id="creator_team<?php echo $orders[$i]['order_ID'];?>" class="form-control form-control-sm teams">
                                    <option value="">-- Select --</option>
                                    <?php
                                    $all_creator_teams=$prod->get_all_teams($orders[$i]['u_prod_id']);
                                    for($t=0;$t<count($all_creator_teams);$t++)
                                    {
                                    ?>
                                    <option value="<?php echo $all_creator_teams[$t]['team_id'];?>" <?php echo ($all_creator_teams[$t]['team_id']==$orders[$i]['team_id'])?"selected":"";?>><?php echo $all_creator_teams[$t]['team_name'];?></option>
                                    <?php
                                    }
                                    ?>
                                    <option value="">----------------------</option>
                                    <?php
                                    $all_other_creator_teams=$prod->get_all_other_teams($orders[$i]['u_prod_id']);
                                    for($t=0;$t<count($all_other_creator_teams);$t++)
                                    {
                                    ?>
                                    <option value="<?php echo $all_other_creator_teams[$t]['team_id'];?>" <?php echo ($all_other_creator_teams[$t]['team_id']==$orders[$i]['team_id'])?"selected":"";?>><?php echo $all_other_creator_teams[$t]['team_name'];?> - <?php echo $prod->get_company($all_other_creator_teams[$t]['lt_id'])['mailnick'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#creator_team<?php echo $orders[$i]['order_ID'];?>').on('change',function(){
                                        $.ajax({
                                            url: "../ajax/change_order_creator_team.php",
                                            method: "get",
                                            data: {o_id:<?php echo $orders[$i]['order_ID'];?>,team_id:$(this).val()},
                                            dataType:"html",
                                            success:function(data) {
                                  
                                            }
                                        });
                                    });
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-xl-2 text-center">
            <?php
            if($orders[$i]['o_extension']==1)
            {
            ?>    
            <p class="mb-0">EXTENSION</p>
            <?php    
            }    

            if($orders[$i]['o_correction']==1)
            {
            ?>    
            <p class="mb-0">CORRECTION/AMENDMENT</p>
            <?php   
            }
            ?>
            <p class="projectname mb-0"><?php echo $orders[$i]['order_name'];?></p>
            
            </div>
        <div class="col-12 col-xl-3 time text-center text-xl-right pt-2"><?php echo $orders[$i]['o_date'];
        if($orders[$i]['o_deadline']!="0000-00-00 00:00:00")
        {
        ?>
            <!-- <br><span class="text-danger">Deadline: <?php echo $orders[$i]['o_deadline'];?> UTC+0</span> -->
            <br><span class="text-danger">Deadline: <input type="textbox" id="o_deadline<?php echo $orders[$i]['order_ID'];?>" class="form-control form-control-sm text-danger d-inline" value="<?php echo $orders[$i]['o_deadline']; ?>" style="width:170px;"> UTC+0
            <input type="hidden" id="new_o_deadline<?php echo $orders[$i]['order_ID'];?>" name="new_o_deadline<?php echo $orders[$i]['order_ID'];?>" value="<?php
            echo $new_o_deadline=$prod->get_deadline_without_weekends($orders[$i]['o_deadline']);
            ?>">
            <button id="o_deadline_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-danger d-inline">Save</button> </span>
            
        <?php
        }
        else
        {
            ?>
            <!--<br><span class="text-success">No Deadline</span> -->
            <br><span><input type="textbox" id="o_deadline<?php echo $orders[$i]['order_ID'];?>" class="form-control form-control-sm text-success d-inline" value="No Deadline" style="width:170px;"> UTC+0
            <button id="o_deadline_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-success d-inline">Save</button></span>
            <?php
        }
        ?></div>
        <script type="text/javascript">
            setInterval(function blinktimer<?php echo $orders[$i]['order_ID'];?>() {
                    // var deadline = new Date($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val());
                    var deadline = moment.tz($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val(),'UTC');
                    var today=new Date();
                    var diff=(new Date(deadline).getTime() - new Date(today).getTime());
                    if(diff>(24*60*60*1000) || diff<0){
                        $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass('blink');
                    }else{
                        $('#timeleft<?php echo $orders[$i]['order_ID'];?>').addClass('blink');
                        //console.log(diff);
                    }
                }, 1000);

            function countdown_timeleft<?=$orders[$i]['order_ID']?>(){
                // timeleft 
                var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                if(($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val()!="")&&($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val()!="No Deadline"))
                {
                    var deadline_time = moment.tz($('#new_o_deadline<?php echo $orders[$i]['order_ID'];?>').val(),'UTC');
                    var dateset = deadline_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm:ss');
                            //var dateset = $('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val();
                        $('#timeleft<?php echo $orders[$i]['order_ID'];?>').countdown(dateset, function(event) {
                            //$(this).html(event.strftime('%d days %H:%M:%S'));
                            $(this).html(event.strftime('%-D day%!D %H:%M:%S')); 
                        });
                }

                if($('#timeleft<?php echo $orders[$i]['order_ID'];?>').text()=="00 days 00:00:00")
                {
                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass('blink');
                }
            }
            

            $(document).ready(function(){
                countdown_timeleft<?=$orders[$i]['order_ID']?>();
                //deadline
                $('#o_deadline<?php echo $orders[$i]['order_ID'];?>').datetimepicker({
                    format:'Y-m-d H:i'
                    });

                $('#o_deadline_btn<?php echo $orders[$i]['order_ID'];?>').click(function(){
                    $.ajax({
                        url: "../ajax/update_order_deadline.php",
                        method: "post",
                        data: {o_id:<?php echo $orders[$i]['order_ID'];?>,o_deadline:$('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val()},
                        dataType:"html",
                        success:function(data) {
                            // console.log(data);	
                            countdown_timeleft<?=$orders[$i]['order_ID']?>();
                        }
                    });
                });
            });
        </script>
        <div class="col-12 col-xl-4 text-xl-right text-center pt-2"> 
            <p class="tasks d-inline mr-xl-2 px-2 py-1"><span><?php 
            $tasks=$prod->count_finished_tasks_by_orderid_coordination($orders[$i]['order_ID']);
            echo $tasks;
            ?></span> / <span><?php
            $total_tasks=$prod->count_total_tasks_coordination($orders[$i]['order_ID']);
            echo $total_tasks;
            ?></span> task(s) finished</p>
            <a href="https://blue7.it/<?php echo $orders[$i]['order_ID'];?>"  class="btn btn-primary btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline" target="_blank">Presentation</a>
                <button id="on_stock_btn<?php echo $orders[$i]['order_ID'];?>" data-on_stock="<?php echo $orders[$i]['on_stock'];?>" class="btn btn-sm btn-warning d-inline"><?php echo ($orders[$i]['on_stock']==0)?"Put On stock":"On stock";?></button>
                <script type="text/javascript">
                    $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").click(function(){
                        $.ajax({
                            url: "../ajax/update_on_stock.php",
                            method: "post",
                            data: {o_id:<?php echo $orders[$i]['order_ID'];?>,on_stock:$(this).data("on_stock")},
                            dataType:"html",
                            success:function(data) {
                                console.log(data);	
                                if(data==0)
                                {
                                    $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").data("on_stock","0");
                                    $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").html("Put On Stock");
                                    //$("#on_stock_btn").removeClass("btn-success").addClass("btn-danger");
                                    $('#projectid<?php echo $orders[$i]['order_ID'];?>').fadeOut(2000);
                                }	
                                else
                                {
                                    $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").data("on_stock","1");
                                    $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").html("On Stock");
                                    //$("#on_stock_btn").removeClass("btn-danger").addClass("btn-success");
                                    $('#projectid<?php echo $orders[$i]['order_ID'];?>').fadeOut(2000);
                                }								
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                console.log(xhr.status);
                                console.log(thrownError);
                            }
                            });
                    });
                </script>
                <button id="public_private_btn<?php echo $orders[$i]['order_ID'];?>" data-public="<?php echo $orders[$i]['public'];?>" class="btn btn-sm d-inline <?php echo ($orders[$i]['public']==1)?"btn-success":"btn-danger";?>"><?php echo ($orders[$i]['public']==1)?"Public":"Private";?></button>
                <script type="text/javascript">
                $("#public_private_btn<?php echo $orders[$i]['order_ID'];?>").click(function(){
                    if(confirm('Are you sure that this is what the client wants ?')) 
                    {
                        if($(this).data("public")==1)
                        {
                            $(this).data("public","0");
                            $(this).removeClass("btn-success");
                            $(this).addClass("btn-danger");
                            $(this).text("Private");
                            $.ajax({
                                url: "../ajax/change_public_private_order.php",
                                method: "post",
                                data: {o_id:<?php echo $orders[$i]['order_ID'];?>,public:0},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);	
                                }
                            });
                        }
                        else
                        {
                            $(this).data("public","1");
                            $(this).removeClass("btn-danger");
                            $(this).addClass("btn-success");
                            $(this).text("Public");
                            $.ajax({
                                url: "../ajax/change_public_private_order.php",
                                method: "post",
                                data: {o_id:<?php echo $orders[$i]['order_ID'];?>,public:1},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);	
                                }
                            });
                        }
                    }
                });
                </script>
                <button id="show_with_creators_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-default">Show with creators</button>
                <script type="text/javascript">
                $("#show_with_creators_btn<?php echo $orders[$i]['order_ID'];?>").click(function(){
                    $(".assigned_creator_name<?php echo $orders[$i]['order_ID'];?>").toggleClass('d-none');
                    
                    var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                    $(".assigned_creator_name<?php echo $orders[$i]['order_ID'];?>").each(function(){

                    var creator_end_time=$(this).data("creator_end_time");

                    var creatorUTCendtime = moment.tz(creator_end_time, 'UTC');
                    var creator_end_dateset = creatorUTCendtime
                        .clone()
                        .tz(user_timezone)
                        .format('YYYY-MM-DD HH:mm');
                    
                    var today=new Date();
                    
                    var time_diff=(new Date(creator_end_dateset).getTime() - new Date(today).getTime());                  

                    if(time_diff>0)
                    {
                        $(this).addClass("green-border");
                    }
                    });
                });
                </script>
                <a href="orderdetails.php?o_id=<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-primary d-inline">View details</a>
                <button id="delete_order_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-danger d-inline">x</button>
                <script type="text/javascript">
                $('#delete_order_btn<?php echo $orders[$i]['order_ID'];?>').click(function(){
                    if(confirm('Are you sure want to delete ?'))
                    {
                    $.ajax({
                    url: "../ajax/delete_order.php",
                    method: "post",
                    data: {o_id:<?php echo $orders[$i]['order_ID'];?>},
                    dataType:"html",
                    success:function(data) {												
                        $('#projectid<?php echo $orders[$i]['order_ID'];?>').fadeOut(3000);
                    }
                    });
                    }
                });
                </script>
            </div>
            
    </div>
    
    <?php
    //start b5 exterior 

    $b5_exterior_products_with_extensions=$prod->get_b5_exterior_products_with_extensions($orders[$i]['order_ID']);

    if(count($b5_exterior_products_with_extensions)>0)
    {
    ?>
    <div class="row mx-0 w-100 exterior">
        <div class="col-lg-4 col-12  px-2 ">
        <?php
        for($j=0;$j<count($b5_exterior_products_with_extensions);$j++)
        {
            if(($j>0)&&($b5_exterior_products_with_extensions[$j]['osub_id']!=$b5_exterior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 "> 
            <?php    
            }
        ?>    
            <p class="p-1 float-left m-1 <?php
            for($s=0;$s<count($allstatus);$s++)
			{
				if($allstatus[$s]['ost_id']==$b5_exterior_products_with_extensions[$j]['p_status'])
				{
					echo $allstatus[$s]['ost_color'];
				}
            }
            
            if($b5_exterior_products_with_extensions[$j]['om_id']!=0)
            {
                echo " red-border";
            }
            ?>"><a href="taskdetails.php?o_id=<?php echo $b5_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b5_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b5_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
            $creator=$prod->get_client($b5_exterior_products_with_extensions[$j]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }

            $activity=$prod->get_product_last_change($b5_exterior_products_with_extensions[$j]['o_id'],$b5_exterior_products_with_extensions[$j]['osub_id'],$b5_exterior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($activity_creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
            ?>"><?php
            echo $b5_exterior_products_with_extensions[$j]['osub_id'].".".$b5_exterior_products_with_extensions[$j]['prod_id'];?>
            <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
            //showing creator's end time

            $endtime=$prod->get_creator_end_time($b5_exterior_products_with_extensions[$j]['uca_id']);
            echo $endtime['end_time'];

            ?>"><?php
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }
            ?></span></a></p>  
        <?php
        }
        ?>    
        </div>
    </div> <!-- end exterior -->
    <?php
    }

    //end b5 exterior

    //start b6 exterior 

    $b6_exterior_products_with_extensions=$prod->get_b6_exterior_products_with_extensions($orders[$i]['order_ID']);

    if(count($b6_exterior_products_with_extensions)>0)
    {
    ?>
    <div class="row mx-0 w-100 exterior">
        <div class="col-lg-4 col-12 px-2 ">
        <?php
        for($j=0;$j<count($b6_exterior_products_with_extensions);$j++)
        {
            if(($j>0)&&($b6_exterior_products_with_extensions[$j]['osub_id']!=$b6_exterior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 "> 
            <?php    
            }
        ?>    
            <p class="p-1 float-left m-1 <?php
            for($s=0;$s<count($allstatus);$s++)
			{
				if($allstatus[$s]['ost_id']==$b6_exterior_products_with_extensions[$j]['p_status'])
				{
					echo $allstatus[$s]['ost_color'];
				}
            }
            
            if($b6_exterior_products_with_extensions[$j]['om_id']!=0)
            {
                echo " red-border";
            }
            ?>"><a href="taskdetails.php?o_id=<?php echo $b6_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b6_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b6_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
            $creator=$prod->get_client($b6_exterior_products_with_extensions[$j]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }

            $activity=$prod->get_product_last_change($b6_exterior_products_with_extensions[$j]['o_id'],$b6_exterior_products_with_extensions[$j]['osub_id'],$b6_exterior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($activity_creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
            ?>"><?php
            echo $b6_exterior_products_with_extensions[$j]['osub_id'].".".$b6_exterior_products_with_extensions[$j]['prod_id'];?>
            <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time=<?php 
            //showing creator's end time

            $endtime=$prod->get_creator_end_time($b6_exterior_products_with_extensions[$j]['uca_id']);
            echo $endtime['end_time'];
            ?>><?php
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }?></span></a></p>  
        <?php
        }
        ?>    
        </div>
    </div> <!-- end exterior -->
    <?php
    }

    //end b6 exterior

    //start b7 exterior 

     $b7_exterior_products_with_extensions=$prod->get_b7_exterior_products_with_extensions($orders[$i]['order_ID']);

     if(count($b7_exterior_products_with_extensions)>0)
     {
     ?>
     <div class="row mx-0 w-100 exterior">
         <div class="col-lg-4 col-12 px-2 ">
         <?php
         for($j=0;$j<count($b7_exterior_products_with_extensions);$j++)
         {
            if(($j>0)&&($b7_exterior_products_with_extensions[$j]['osub_id']!=$b7_exterior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2"> 
            <?php    
            }
         ?>    
             <p class="p-1 float-left m-1 <?php
             for($s=0;$s<count($allstatus);$s++)
             {
                 if($allstatus[$s]['ost_id']==$b7_exterior_products_with_extensions[$j]['p_status'])
                 {
                     echo $allstatus[$s]['ost_color'];
                 }
             }
             
             if($b7_exterior_products_with_extensions[$j]['om_id']!=0)
             {
                 echo " red-border";
             }
             ?>"><a href="taskdetails.php?o_id=<?php echo $b7_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b7_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b7_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
             $creator=$prod->get_client($b7_exterior_products_with_extensions[$j]['uca_id']);
             if(!empty($creator['c_last_name']))
             {
                 echo $creator['c_first_name']." ".$creator['c_last_name'];
             }
             else
             {
                 echo $creator['l_first_name']." ".$creator['l_last_name'];
             }

            $activity=$prod->get_product_last_change($b7_exterior_products_with_extensions[$j]['o_id'],$b7_exterior_products_with_extensions[$j]['osub_id'],$b7_exterior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($activity_creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
             ?>"><?php
             echo $b7_exterior_products_with_extensions[$j]['osub_id'].".".$b7_exterior_products_with_extensions[$j]['prod_id'];?>
             <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
             //showing creator's end time

            $endtime=$prod->get_creator_end_time($b7_exterior_products_with_extensions[$j]['uca_id']);
            echo $endtime['end_time'];
            ?>"><?php
             if(!empty($creator['c_last_name']))
             {
                 echo $creator['c_first_name']." ".$creator['c_last_name'];
             }
             else
             {
                 echo $creator['l_first_name']." ".$creator['l_last_name'];
             }?></span></a></p>  
         <?php
         }
         ?>    
         </div>
     </div> <!-- end exterior -->
     <?php
     }
 
     //end b7 exterior

     //start b8 exterior 

     $b8_exterior_products_with_extensions=$prod->get_b8_exterior_products_with_extensions($orders[$i]['order_ID']);

     if(count($b8_exterior_products_with_extensions)>0)
     {
     ?>
     <div class="row mx-0 w-100 exterior">
         <div class="col-lg-4 col-12 px-2 ">
         <?php
         for($j=0;$j<count($b8_exterior_products_with_extensions);$j++)
         {
            if(($j>0)&&($b8_exterior_products_with_extensions[$j]['osub_id']!=$b8_exterior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 "> 
            <?php    
            }
         ?>    
             <p class="p-1 float-left m-1 <?php
             for($s=0;$s<count($allstatus);$s++)
             {
                 if($allstatus[$s]['ost_id']==$b8_exterior_products_with_extensions[$j]['p_status'])
                 {
                     echo $allstatus[$s]['ost_color'];
                 }
             }
             
             if($b8_exterior_products_with_extensions[$j]['om_id']!=0)
             {
                 echo " red-border";
             }
             ?>"><a href="taskdetails.php?o_id=<?php echo $b8_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b8_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b8_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
             $creator=$prod->get_client($b8_exterior_products_with_extensions[$j]['uca_id']);
             if(!empty($creator['c_last_name']))
             {
                 echo $creator['c_first_name']." ".$creator['c_last_name'];
             }
             else
             {
                 echo $creator['l_first_name']." ".$creator['l_last_name'];
             }

            $activity=$prod->get_product_last_change($b8_exterior_products_with_extensions[$j]['o_id'],$b8_exterior_products_with_extensions[$j]['osub_id'],$b8_exterior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($activity_creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
             ?>"><?php
             echo $b8_exterior_products_with_extensions[$j]['osub_id'].".".$b8_exterior_products_with_extensions[$j]['prod_id'];?>
             <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
             //showing creator's end time

             $endtime=$prod->get_creator_end_time($b8_exterior_products_with_extensions[$j]['uca_id']);
             echo $endtime['end_time'];
             ?>"><?php
             if(!empty($creator['c_last_name']))
             {
                 echo $creator['c_first_name']." ".$creator['c_last_name'];
             }
             else
             {
                 echo $creator['l_first_name']." ".$creator['l_last_name'];
             }?></span></a></p>  
         <?php
         }
         ?>    
         </div>
     </div> <!-- end exterior -->
     <?php
     }
 
     //end b8 exterior
    ?>        
    
    <div class="row mx-0 w-100 interior border-bot mb-4">
    <?php
    //start b3 interior

    $b3_interior_products_with_extensions=$prod->get_b3_interior_products_with_extensions($orders[$i]['order_ID']);

    if(count($b3_interior_products_with_extensions)>0)
    {
    ?>
    <div class="row mx-0 w-100">
        <div class="col-lg-4 col-12 px-2 colorline">   
        <?php
        for($j=0;$j<count($b3_interior_products_with_extensions);$j++)
        {
            if(($j>0)&&($b3_interior_products_with_extensions[$j]['osub_id']!=$b3_interior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 colorline"> 
            <?php    
            }
        ?>    
            <p class="p-1 float-left m-1 <?php
            for($s=0;$s<count($allstatus);$s++)
            {
                if($allstatus[$s]['ost_id']==$b3_interior_products_with_extensions[$j]['p_status'])
                {
                    echo $allstatus[$s]['ost_color'];
                }
            }

            if($b3_interior_products_with_extensions[$j]['om_id']!=0)
            {
                echo " red-border";
            }
            ?>"><a href="taskdetails.php?o_id=<?php echo $b3_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b3_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b3_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
            $creator=$prod->get_client($b3_interior_products_with_extensions[$j]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }

            $activity=$prod->get_product_last_change($b3_interior_products_with_extensions[$j]['o_id'],$b3_interior_products_with_extensions[$j]['osub_id'],$b3_interior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($activity_creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
            ?>"><?php
            echo $b3_interior_products_with_extensions[$j]['osub_id'].".".$b3_interior_products_with_extensions[$j]['prod_id'];?>
            <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
            //showing creator's end time

            $endtime=$prod->get_creator_end_time($b3_interior_products_with_extensions[$j]['uca_id']);
            echo $endtime['end_time'];
            ?>"><?php
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }?></span></a></p>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }

    //end b3 interior

    //start b5 interior

    $b5_interior_products_with_extensions=$prod->get_b5_interior_products_with_extensions($orders[$i]['order_ID']);

    if(count($b5_interior_products_with_extensions)>0)
    {
    ?>
    <div class="row mx-0 w-100">
        <div class="col-lg-4 col-12 px-2 colorline">   
        <?php
        for($j=0;$j<count($b5_interior_products_with_extensions);$j++)
        {
            if(($j>0)&&($b5_interior_products_with_extensions[$j]['osub_id']!=$b5_interior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 colorline"> 
            <?php    
            }
        ?>    
            <p class="p-1 float-left m-1 <?php
            for($s=0;$s<count($allstatus);$s++)
            {
                if($allstatus[$s]['ost_id']==$b5_interior_products_with_extensions[$j]['p_status'])
                {
                    echo $allstatus[$s]['ost_color'];
                }
            }

            if($b5_interior_products_with_extensions[$j]['om_id']!=0)
            {
                echo " red-border";
            }
            ?>"><a href="taskdetails.php?o_id=<?php echo $b5_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b5_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b5_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
            $creator=$prod->get_client($b5_interior_products_with_extensions[$j]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }

            $activity=$prod->get_product_last_change($b5_interior_products_with_extensions[$j]['o_id'],$b5_interior_products_with_extensions[$j]['osub_id'],$b5_interior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
            ?>"><?php
            echo $b5_interior_products_with_extensions[$j]['osub_id'].".".$b5_interior_products_with_extensions[$j]['prod_id'];?>
            <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
             //showing creator's end time

             $endtime=$prod->get_creator_end_time($b5_interior_products_with_extensions[$j]['uca_id']);
             echo $endtime['end_time'];
             ?>"><?php
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }?></span></a></p>
            <?php
        }
            ?>
        </div>
    </div>
    <?php
    }

    //end b5 interior

    //start b6 interior

    $b6_interior_products_with_extensions=$prod->get_b6_interior_products_with_extensions($orders[$i]['order_ID']);

    if(count($b6_interior_products_with_extensions)>0)
    {
    ?>
    <div class="row mx-0 w-100">
        <div class="col-lg-4 col-12 px-2 colorline">   
        <?php
        for($j=0;$j<count($b6_interior_products_with_extensions);$j++)
        {
            if(($j>0)&&($b6_interior_products_with_extensions[$j]['osub_id']!=$b6_interior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 colorline"> 
            <?php    
            }
        ?>    
            <p class="p-1 float-left m-1 <?php
            for($s=0;$s<count($allstatus);$s++)
            {
                if($allstatus[$s]['ost_id']==$b6_interior_products_with_extensions[$j]['p_status'])
                {
                    echo $allstatus[$s]['ost_color'];
                }
            }

            if($b6_interior_products_with_extensions[$j]['om_id']!=0)
            {
                echo " red-border";
            }
            ?>"><a href="taskdetails.php?o_id=<?php echo $b6_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b6_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b6_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
            $creator=$prod->get_client($b6_interior_products_with_extensions[$j]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }

            $activity=$prod->get_product_last_change($b6_interior_products_with_extensions[$j]['o_id'],$b6_interior_products_with_extensions[$j]['osub_id'],$b6_interior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($activity_creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
            ?>"><?php
            echo $b6_interior_products_with_extensions[$j]['osub_id'].".".$b6_interior_products_with_extensions[$j]['prod_id'];?>
            <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
             //showing creator's end time

             $endtime=$prod->get_creator_end_time($b6_interior_products_with_extensions[$j]['uca_id']);
             echo $endtime['end_time'];
             ?>"><?php
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }?></span></a></p>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }

    //end b6 interior

    //start b7 interior

    $b7_interior_products_with_extensions=$prod->get_b7_interior_products_with_extensions($orders[$i]['order_ID']);

    if(count($b7_interior_products_with_extensions)>0)
    {
    ?>
    <div class="row mx-0 w-100">
        <div class="col-lg-4 col-12 px-2 colorline">   
        <?php
        for($j=0;$j<count($b7_interior_products_with_extensions);$j++)
        {
            if(($j>0)&&($b7_interior_products_with_extensions[$j]['osub_id']!=$b7_interior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 colorline"> 
            <?php    
            }
        ?>    
            <p class="p-1 float-left m-1 <?php
            for($s=0;$s<count($allstatus);$s++)
            {
                if($allstatus[$s]['ost_id']==$b7_interior_products_with_extensions[$j]['p_status'])
                {
                    echo $allstatus[$s]['ost_color'];
                }
            }

            if($b7_interior_products_with_extensions[$j]['om_id']!=0)
            {
                echo " red-border";
            }
            ?>"><a href="taskdetails.php?o_id=<?php echo $b7_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b7_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b7_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
            $creator=$prod->get_client($b7_interior_products_with_extensions[$j]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }

            $activity=$prod->get_product_last_change($b7_interior_products_with_extensions[$j]['o_id'],$b7_interior_products_with_extensions[$j]['osub_id'],$b7_interior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
            ?>"><?php
            echo $b7_interior_products_with_extensions[$j]['osub_id'].".".$b7_interior_products_with_extensions[$j]['prod_id'];?>
            <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
            //showing creator's end time

            $endtime=$prod->get_creator_end_time($b7_interior_products_with_extensions[$j]['uca_id']);
            echo $endtime['end_time'];
            ?>"><?php
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }
            ?></span></a></p>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }

    //end b7 interior

    //start b8 interior

    $b8_interior_products_with_extensions=$prod->get_b8_interior_products_with_extensions($orders[$i]['order_ID']);

    if(count($b8_interior_products_with_extensions)>0)
    {
    ?>
    <div class="row mx-0 w-100">
        <div class="col-lg-4 col-12 px-2 colorline">   
        <?php
        for($j=0;$j<count($b8_interior_products_with_extensions);$j++)
        {
            if(($j>0)&&($b8_interior_products_with_extensions[$j]['osub_id']!=$b8_interior_products_with_extensions[$j-1]['osub_id']))
            {
            ?>
            </div> <!-- end column -->
            <div class="col-lg-4 col-12 px-2 colorline"> 
            <?php    
            }
        ?>    
            <p class="p-1 float-left m-1 <?php
            for($s=0;$s<count($allstatus);$s++)
            {
                if($allstatus[$s]['ost_id']==$b8_interior_products_with_extensions[$j]['p_status'])
                {
                    echo $allstatus[$s]['ost_color'];
                }
            }

            if($b8_interior_products_with_extensions[$j]['om_id']!=0)
            {
                echo " red-border";
            }
            ?>"><a href="taskdetails.php?o_id=<?php echo $b8_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b8_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b8_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
            $creator=$prod->get_client($b8_interior_products_with_extensions[$j]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }

            $activity=$prod->get_product_last_change($b8_interior_products_with_extensions[$j]['o_id'],$b8_interior_products_with_extensions[$j]['osub_id'],$b8_interior_products_with_extensions[$j]['prod_id']);

            if(!empty($activity))
            {
                $activity_creator=$prod->get_client($activity['uca_id']);
                if(!empty($activity_creator['c_last_name']))
                {
                    echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
                }
                else
                {
                    echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
                }
                echo " ".$activity['description']." on ".$activity['date'];
            }
            ?>"><?php
            echo $b8_interior_products_with_extensions[$j]['osub_id'].".".$b8_interior_products_with_extensions[$j]['prod_id'];?>
            <br><span class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time="<?php 
            //showing creator's end time

            $endtime=$prod->get_creator_end_time($b8_interior_products_with_extensions[$j]['uca_id']);
            echo $endtime['end_time'];
            ?>"><?php
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }
            ?></span></a></p>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }

    //end b8 interior
    ?>
        </div>
</div>
<?php
}
?>