<?php
session_start();

include("../functions.php");

$prod=new Production;

$unfinished_startpoint=$prod->xss_fix($_GET['start']);
$unfinished_limit=$prod->xss_fix($_GET['limit']);

//getting creator's team
$creator_team=$prod->check_creators_team($_COOKIE['client_id']);

$allstatus=$prod->showallstatus();
?>

<div id="unfinished_team_orders">

<input type="hidden" name="my_team" id="my_team" value="<?php echo $creator_team[0]['team_id'];?>">



</div>

<?php
// echo $unfinished_startpoint;
// echo " ".$unfinished_limit;
if($_COOKIE['view_all_orders']==1)
{
    if($materials_orders==0)
    {
        $orders=$prod->show_unfinished_orders_by_on_stock_limit($on_stock,$unfinished_startpoint,$unfinished_limit);
    }
    else
    {
        $orders=$prod->show_unfinished_materials_orders($materials_orders);
    }
}

else

{

    $lic_ids_array=array();



    for($l=0;$l<count($licences);$l++)

    {

        $lic_ids_array[]=$licences[$l]['lic_id'];

    }

    //print_r($lic_ids_array);

    $orders=$prod->show_unfinished_orders_by_lic_ids_on_stock($lic_ids_array,$on_stock);

}

echo count($orders);

for($i=0;$i<count($orders);$i++)
{

?>

<div class="row mx-0 w-100 px-3 mb-2" id="projectid<?php echo $orders[$i]['order_ID'];?>">

    <div class="row mx-0 w-100 bg-table interface">

        <div class="col-12 col-xl-4 text-center text-xl-left pr-0 pl-1 d-flex flex-row jusity-content-center">

            <div class="row mx-0 px-0 w-100">

                <div class="col-xl-8 px-0 d-flex flex-column justify-content-center">

                    <p class="text-left client mb-0">

                        <?php

                        if(($orders[$i]['commission']!="com_000")&&(!empty($orders[$i]['commission'])))

                        {

                        ?>

                        <i class="fa fa-star" aria-hidden="true" style="color:goldenrod;"></i>

                        <?php

                        }

                        ?>

                        <strong>

                            <?php echo $orders[$i]['order_ID'];

                                if($orders[$i]['om_id']>0)

                                {

                                    echo "-".$orders[$i]['om_id'];

                                }

                            ?>

                        </strong>

                    <?php 

                    $client=$prod->get_client($orders[$i]['u_client_ID']);

                    if(!empty($client['c_last_name']))

                    {
                        ?>
                        <a href="<?php echo $base_url;?>client_administration/orders.php?clientid=<?php echo $orders[$i]['u_client_ID'];?>" target="_blank" title="Search orders for this client"><?php echo $client['clientname']." - ".$client['c_last_name'].", ".$client['c_first_name'];?></a>
                        <?php
                    }

                    else

                    {
                        ?>
                        <a href="<?php echo $base_url;?>client_administration/orders.php?clientid=<?php echo $orders[$i]['u_client_ID'];?>" target="_blank" title="Search orders for this client"><?php echo $client['clientname']." - ".$client['l_last_name'].", ".$client['l_first_name'];?></a>
                        <?php
                    }

                    ?></p>

                    <div class="row w-100 mx-0 px-0">

                        <div class="col-md-auto px-0">
                            Producer: <?php

                            echo $prod->get_company($orders[$i]['u_prod_id'])['mailnick'];

                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $plot_ids_array=explode('|',$orders[$i]['plot_id']);
                            
                            if((!empty($plot_ids_array))&&(!empty($orders[$i]['plot_id'])))
                            {
                            ?>
                            Plot ID: <a href="index.php?search_option=plot_id&search=<?php echo $plot_ids_array[1];?>"><?php echo $plot_ids_array[1];?></a> 
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>

                <div class="col-4  px-0">

                        <div class="">
                            <?php /*
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
                            */
                            
                            ?>
                            <span id="utc_date_time<?php echo $orders[$i]['order_ID']; ?>"><?php echo $orders[$i]['o_date']; ?> UTC+0</span><br>
                            <button id="show_client_time_btn<?php echo $orders[$i]['order_ID']; ?>" type="button" class="btn btn-secondary">Show client time</button>
                            <div id="client_time_row<?php echo $orders[$i]['order_ID']; ?>" class="d-none">
                                <b><span id="client_date_time<?php echo $orders[$i]['order_ID']; ?>">loading...</span> Client</b><br>
                                <span id="local_date_time<?php echo $orders[$i]['order_ID']; ?>">loading...</span> Yours
                            </div>
                            <script type="text/javascript">
                               $('#show_client_time_btn<?php echo $orders[$i]['order_ID']; ?>').click(function(){

                                    $('#client_time_row<?php echo $orders[$i]['order_ID']; ?>').removeClass('d-none');                                    

                                    let o_date=$('#utc_date_time<?php echo $orders[$i]['order_ID']; ?>').text();
                                    let timezone=Intl.DateTimeFormat().resolvedOptions().timeZone;
                                    let client_timezone="<?php echo $client['timezone'];?>";

                                    setTimeout(function () {

                                        $.ajax({
                                            url: "../ajax/convert_utc_to_local_date_time_default_format.php",
                                            method: "get",
                                            data: {o_date:o_date,timezone:timezone},
                                            dataType:"html",
                                            success:function(data) {
                                                $('#local_date_time<?php echo $orders[$i]['order_ID']; ?>').html(data);	
                                            }
                                        });

                                    }, 1000);

                                    setTimeout(function () {

                                        $.ajax({
                                            url: "../ajax/convert_utc_to_local_date_time_default_format.php",
                                            method: "get",
                                            data: {o_date:o_date,timezone:client_timezone},
                                            dataType:"html",
                                            success:function(data) {
                                                $('#client_date_time<?php echo $orders[$i]['order_ID']; ?>').html(data);	
                                            }
                                        });

                                    }, 3000);

                                });
                            </script> 
                        </div>

                </div>

            </div>

            </div>

            <div class="col-12 col-xl-2 text-center d-flex justify-content-center align-items-center flex-column px-0">

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

            <p class="mb-0" style="font-size: 14px;">CORRECTION/AMENDMENT</p>

            <?php   

            }

            ?>

            <p class="projectname mb-0"><b><?php echo $orders[$i]['order_name'];?></b></p>

            </div>

        <div class="col-12 col-xl-2 time d-flex flex-column justify-content-center align-items-center pb-1 px-0">

                <?php 

                    if($orders[$i]['o_deadline']!="0000-00-00 00:00:00")

                    {
                ?>
                    <span class="text-danger">

                        <input type="textbox" id="o_deadline_utc<?php echo $orders[$i]['order_ID'];?>" class="form-control form-control-sm text-danger d-inline" value="<?php 
                        
                        echo $orders[$i]['o_deadline']." UTC + 0"; ?>" style="width:220px;">
                        <input type="hidden" id="o_deadline<?php echo $orders[$i]['order_ID'];?>" value="<?php echo $orders[$i]['o_deadline']?>">
                        <input type="hidden" id="new_o_deadline<?php echo $orders[$i]['order_ID'];?>" name="new_o_deadline<?php echo $orders[$i]['order_ID'];?>" value="<?php echo $new_o_deadline=$prod->get_deadline_without_weekends($orders[$i]['o_deadline']);?>"> 

                        <button id="o_deadline_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-danger d-inline">Save</button><br> 
                        <span id="deadline_local_time<?php echo $orders[$i]['order_ID'];?>"></span> Yours
                        <script type="text/javascript">
                            $(document).ready(function(){

                                let o_deadline=$('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val();
                                let timezone=Intl.DateTimeFormat().resolvedOptions().timeZone;

                                setTimeout(function () {
                                $.ajax({
                                    url: "../ajax/convert_utc_to_local_date_time_default_format.php",
                                    method: "get",
                                    data: {o_date:o_deadline,timezone:timezone},
                                    dataType:"html",
                                    success:function(data) {
                                        $('#deadline_local_time<?php echo $orders[$i]['order_ID']; ?>').html(data);
                                        
                                        countdown_timeleft<?=$orders[$i]['order_ID']?>();
                                    }
                                });

                                }, 4000);

                            });
                        </script>
                    </span>

                <?php

                }

                else

                {

                    ?>

                    <!--<br><span class="text-success">No Deadline</span> -->

                    <span><input type="textbox" id="o_deadline_utc<?php echo $orders[$i]['order_ID'];?>" class="form-control form-control-sm text-success d-inline nodeadline" value="No Deadline" style="width:220px;">
                    <input type="hidden" id="o_deadline<?php echo $orders[$i]['order_ID'];?>" value="<?php echo $orders[$i]['o_deadline']?>">
                    <input type="hidden" id="new_o_deadline<?php echo $orders[$i]['order_ID'];?>" name="new_o_deadline<?php echo $orders[$i]['order_ID'];?>" value="<?php echo $new_o_deadline=$prod->get_deadline_without_weekends($orders[$i]['o_deadline']);?>"> 
                    <button id="o_deadline_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-success d-inline">Save</button></span>
                    <?php

                }

            ?>

        </div>

        <script type="text/javascript">

            

            //deadline

            $('#o_deadline_utc<?php echo $orders[$i]['order_ID'];?>').datetimepicker({

                format:'Y-m-d H:i'

            });

            
            $('#o_deadline_utc<?php echo $orders[$i]['order_ID'];?>').on('change',function(){

                let current_deadline=$(this).val();

                if((current_deadline!="")||(current_deadline!="No Deadline"))
                {
                    $(this).val(current_deadline+" UTC + 0");
                    $('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val(current_deadline);
                }
            });


            function countdown_timeleft<?=$orders[$i]['order_ID']?>()
            {

                // timeleft 

                var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                if(($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val()!="")&&($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val()!="No Deadline"))

                {

                    //var deadline_time = moment.tz($('#new_o_deadline<?php echo $orders[$i]['order_ID'];?>').val(),'UTC');
                    //var deadline_time = moment.tz($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val(),'UTC');
                    //console.log(deadline_time);
                    //var dateset = deadline_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm:ss');
                    //console.log(dateset);
                    var dateset = $('#deadline_local_time<?php echo $orders[$i]['order_ID'];?>').text();

                        $('#timeleft<?php echo $orders[$i]['order_ID'];?>').countdown(dateset, function(event) {

                            //$(this).html(event.strftime('%d days %H:%M:%S'));

                            $(this).html(event.strftime('%-D day%!D %H:%M:%S')); 

                        });

                }



                var countdown_timeleft=$('#timeleft<?php echo $orders[$i]['order_ID'];?>').text();

                var countdown_date_array=countdown_timeleft.split(" ");

                var countdown_day=countdown_date_array[0];



                if(countdown_day>=3)

                {

                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass().addClass('blink text-success');

                    $('#o_deadline<?php echo $orders[$i]['order_ID'];?>').removeClass("text-danger").addClass('text-success');

                    $('#o_deadline_btn<?php echo $orders[$i]['order_ID'];?>').removeClass("btn-danger").addClass('btn-success');

                }



                if((countdown_day<3)&&(countdown_day>=2))

                {

                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass().addClass('blink text-dark');

                    $('#o_deadline<?php echo $orders[$i]['order_ID'];?>').removeClass("text-danger text-success").addClass('text-dark');

                    $('#o_deadline_btn<?php echo $orders[$i]['order_ID'];?>').removeClass("btn-danger btn-success").addClass('btn-dark');

                }



                if((countdown_day<2)&&(countdown_day>=1))

                {

                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass().addClass('blink text-orange');

                    $('#o_deadline<?php echo $orders[$i]['order_ID'];?>').removeClass("text-warning text-danger text-success").addClass('text-orange');

                    $('#o_deadline_btn<?php echo $orders[$i]['order_ID'];?>').removeClass("btn-success btn-warning btn-danger").addClass('btn-orange');

                }



                if(countdown_day<1)

                {

                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass().addClass('blink text-danger');

                    if(!$('#o_deadline<?php echo $orders[$i]['order_ID'];?>').hasClass("nodeadline")){

                        $('#o_deadline<?php echo $orders[$i]['order_ID'];?>').removeClass("text-warning text-orange text-danger").addClass('text-danger');

                        $('#o_deadline_btn<?php echo $orders[$i]['order_ID'];?>').removeClass("btn-danger btn-warning btn-orange").addClass('btn-danger');

                    }

                }



                if($('#timeleft<?php echo $orders[$i]['order_ID'];?>').text()=="00 days 00:00:00")
                {

                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass('blink');

                }

            }

            
            setInterval(function blinktimer<?php echo $orders[$i]['order_ID'];?>() {

            //var deadline = new Date($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val());

            //var deadline = moment.tz($('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val(),'UTC');

            var deadline =$('#deadline_local_time<?php echo $orders[$i]['order_ID'];?>').text();
            
            if(deadline!="")
            {
                var today=new Date();

                var diff=(new Date(deadline).getTime() - new Date(today).getTime());

                if(diff>(24*60*60*1000) || diff<0){

                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').removeClass('blink');

                }else{

                    $('#timeleft<?php echo $orders[$i]['order_ID'];?>').addClass('blink');

                    //console.log(diff);

                }
            }
            }, 1000);


            $('#o_deadline_btn<?php echo $orders[$i]['order_ID'];?>').click(function(){
                    
                    var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                    $.ajax({

                        url: "../ajax/update_order_deadline.php",

                        method: "post",

                        data: {o_id:<?php echo $orders[$i]['order_ID'];?>,o_deadline:$('#o_deadline<?php echo $orders[$i]['order_ID'];?>').val(),client_time_zone:user_timezone},

                        dataType:"html",

                        success:function(data) {

                            // console.log(data);	

                            countdown_timeleft<?=$orders[$i]['order_ID']?>();

                        }

                    });

                });

        </script>

        <div class="col-12 col-xl-4 text-xl-right text-center d-flex flex-row align-items-center px-0">

            <div class="row w-100 mx-0 px-0">

                <div class="col-12 d-flex flex-row align-items-center justify-content-start px-0">

                    <span class="text-left pl-xl-2"><b><span id="timeleft<?php echo $orders[$i]['order_ID'];?>" class="blink"></span></b></span>

                    <a href="orderdetails4.php?o_id=<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-primary d-inline mr-1  ml-auto">

                        Details

                    </a>

                    <a href="https://bauvorschau.com/<?php 
                    if($orders[$i]['om_id']==0)
                    {
                        echo $orders[$i]['order_ID'];
                    }
                    else
                    {
                        echo $orders[$i]['om_id'];
                    }?>" class="btn btn-success btn-sm mr-1 d-md-inline" target="_blank">
                        Presentation
                    </a>
                    <button id="public_private_btn<?php echo $orders[$i]['order_ID'];?>" data-public="<?php echo $orders[$i]['public'];?>" class="btn btn-sm d-inline mr-1 <?php echo ($orders[$i]['public']==1)?"btn-success":"btn-danger";?>">

                        <?php echo ($orders[$i]['public']==1)?"Public":"Private";?>

                    </button>

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
                    <a href="https://bauvorschau.com/production/<?php
                    if($orders[$i]['om_id']==0)
                    {
                        echo $orders[$i]['order_ID'];
                    }
                    else
                    {
                        echo $orders[$i]['om_id'];
                    }
                    
                    $existing_token=$prod->get_token($_COOKIE['client_id']);
                    if(!empty($existing_token))
                    {
                        echo "/?token=" . $existing_token['token'];
                    }
                    ?>" class="btn orange btn-sm d-md-inline"
                    target="_blank">Checkation</a>
                            
                    
                    <select id="multiple_status<?php echo $orders[$i]['order_ID'];?>" class="form-control form-control-sm <?php 
                    if(($orders[$i]['on_stock']==0)&&($orders[$i]['materials_order']==0))
                    {
                        echo "light-green";
                    }

                    if(($orders[$i]['on_stock']==1)&&($orders[$i]['materials_order']==0))
                    { 
                        echo "yellow-light";
                    }
                    ?>">                        
                        <option value="0" class="light-green" <?php 
                        if(($orders[$i]['on_stock']==0)&&($orders[$i]['materials_order']==0))
                        { 
                            echo "selected";
                        }?>>Normal</option>
                        <option value="1" class="yellow-light" <?php 
                        if(($orders[$i]['on_stock']==1)&&($orders[$i]['materials_order']==0))
                        { 
                            echo "selected";
                        }?>>On stock</option>
                        <option value="2" <?php 
                        if(($orders[$i]['on_stock']==0)&&($orders[$i]['materials_order']==1))
                        { 
                            echo "selected";
                        }?>>Materials Order</option>
                    </select>
                    <?php /* <button id="on_stock_btn<?php echo $orders[$i]['order_ID'];?>" data-on_stock="<?php echo $orders[$i]['on_stock'];?>" class="btn btn-sm <?php echo ($orders[$i]['on_stock']==0)?"btn-success":"btn-warning";?> d-inline mr-1">

                        <?php echo ($orders[$i]['on_stock']==0)?"Put On stock":"Put on normal";?>

                    </button> */ ?>

                    <script type="text/javascript">
                         $("#multiple_status<?php echo $orders[$i]['order_ID'];?>").click(function(){
                            
                            $.ajax({

                                url: "../ajax/update_on_stock.php",

                                method: "post",

                                data: {o_id:<?php echo $orders[$i]['order_ID'];?>,on_stock:$(this).val()},

                                dataType:"html",

                                success:function(data) {

                                    console.log(data);	
                                  						

                                },

                                error: function (xhr, ajaxOptions, thrownError) {

                                    console.log(xhr.status);

                                    console.log(thrownError);

                                }

                                });  

                         });
                        /*
                        $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").click(function(){

                            if(confirm('Are you sure you want to change the status?')) 

                            {



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

                                        $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").html("Put on normal");

                                        //$("#on_stock_btn").removeClass("btn-danger").addClass("btn-success");

                                        $('#projectid<?php echo $orders[$i]['order_ID'];?>').fadeOut(2000);

                                    }								

                                },

                                error: function (xhr, ajaxOptions, thrownError) {

                                    console.log(xhr.status);

                                    console.log(thrownError);

                                }

                                });

                                

                            }



                        }); */

                    </script>

                                <button id="show_with_creators_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm mr-1 btn-light">Creators</button>

                                <script type="text/javascript">

                                $("#show_with_creators_btn<?php echo $orders[$i]['order_ID'];?>").click(function(){

                                    $(".assigned_creator_name<?php echo $orders[$i]['order_ID'];?>").toggleClass('d-none');

                                    

                                    var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;



                                    $(".assigned_creator_name<?php echo $orders[$i]['order_ID'];?>").each(function(){

                                        let uca_id=$(this).data('uca_id');
                                        let o_id=$(this).data('o_id');
                                        let osub_id=$(this).data('osub_id');
                                        let prod_id=$(this).data('prod_id');

                                        if((uca_id!="")&&(uca_id!=undefined))
                                        {
                                            $.ajax({

                                                url: "../ajax/get_client.php",
                                                method: "get",
                                                data: {uca_id:uca_id},
                                                dataType:"html",
                                                success:function(data) {												

                                                    $("#assigned_creator_name"+o_id+"_"+osub_id+"_"+prod_id).html(data);

                                                }

                                            });
                                        }

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

                                

                                <button id="delete_order_btn<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm btn-danger d-inline">x</button>

                                <script type="text/javascript">

                                $('#delete_order_btn<?php echo $orders[$i]['order_ID'];?>').click(function(){

                                    if(confirm('Are you sure want to delete ?'))

                                    {

                                    $.ajax({

                                    url: "../ajax/delete_order.php",

                                    method: "post",

                                    data: {o_id:<?php echo $orders[$i]['order_ID'];?>,client_id:<?php echo $_COOKIE['client_id'];?>},

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

        </div>

            

    </div>

    

<div class="row mx-0 w-100" style="border-bottom: 1px solid #000;">            

<?php
//start b1 interior

$b1_interior_products_with_extensions=$prod->get_b1_interior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b1_interior_products_with_extensions))
{
    if(count($b1_interior_products_with_extensions)>0)
    {

        ?>

        <div class="row mx-0 w-100" style="background-color:#fff">

            <div class="col-lg-4 col-12 px-2 colorline">   

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b1_interior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b1_interior_products_with_extensions[$j]['osub_id']!=$b1_interior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 colorline"> 

                <?php    

                }

            ?>    
            <?php 
                    if($subo_name_counter==0)
                    {
                        ?><span><b><?php
                    $subo_data['o_id']=$b1_interior_products_with_extensions[$j]['o_id'];
                    $subo_data['o_sub_id']=$b1_interior_products_with_extensions[$j]['osub_id'];

                    $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                    
                    echo $subo_name['subo_name'];
                    $subo_name_counter++;
                    ?></b></span><br><?php
                    }
                    ?>
                <p class="p-1 float-left m-1 <?php

                for($s=0;$s<count($allstatus);$s++)

                {

                    if($allstatus[$s]['ost_id']==$b1_interior_products_with_extensions[$j]['p_status'])

                    {

                        echo $allstatus[$s]['ost_color'];

                    }

                }



                if($b1_interior_products_with_extensions[$j]['om_id']!=0)

                {

                    echo " red-border";

                }

                ?>">
                <a id="taskdetails<?php 
                echo $b1_interior_products_with_extensions[$j]['o_id']."_".$b1_interior_products_with_extensions[$j]['osub_id']."_".$b1_interior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b1_interior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b1_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b1_interior_products_with_extensions[$j]['prod_id'];
                ?>" data-uca_id="<?php 
                echo $b1_interior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b1_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b1_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b1_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 

                ?>" class="<?php 
                $check_tracking_data['o_id']=$b1_interior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b1_interior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b1_interior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b1_interior_products_with_extensions[$j]['osub_id'].".".$b1_interior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php 
                echo $orders[$i]['order_ID']."_".$b1_interior_products_with_extensions[$j]['osub_id']."_".$b1_interior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php 
                echo $orders[$i]['order_ID'];?>" data-osub_id="<?php 
                echo $b1_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b1_interior_products_with_extensions[$j]['prod_id'];?>" class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b1_interior_products_with_extensions[$j]['uca_id'];
                ?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b1_interior_products_with_extensions[$j]['uca_id']);

                echo $endtime['end_time'];

                ?>"></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b1_interior_products_with_extensions[$j]['o_id']."_".$b1_interior_products_with_extensions[$j]['osub_id']."_".$b1_interior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b1_interior_products_with_extensions[$j]['o_id']."_".$b1_interior_products_with_extensions[$j]['osub_id']."_".$b1_interior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>    
                </p>

                <?php

                }

                ?>

            </div>

        </div>

        <?php

    }
}
//end b1 interior

//start b3 interior



$b3_interior_products_with_extensions=$prod->get_b3_interior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b3_interior_products_with_extensions))
{
    if(count($b3_interior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100" style="background-color:#fff">

            <div class="col-lg-4 col-12 px-2 colorline">   

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b3_interior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b3_interior_products_with_extensions[$j]['osub_id']!=$b3_interior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 colorline"> 

                <?php    

                }

            ?>    
                <?php 
                //echo $subo_name_counter;
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                    if($b3_interior_products_with_extensions[$j]['om_id']==0)
                    {
                        $subo_data['o_id']=$b3_interior_products_with_extensions[$j]['o_id'];
                    }
                    else
                    {
                        $subo_data['o_id']=$b3_interior_products_with_extensions[$j]['om_id'];
                    }

                    $subo_data['o_sub_id']=$b3_interior_products_with_extensions[$j]['osub_id'];

                    $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                    
                    echo $subo_name['subo_name'];
                    $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">            
                <a id="taskdetails<?php 
                echo $b3_interior_products_with_extensions[$j]['o_id']."_".$b3_interior_products_with_extensions[$j]['osub_id']."_".$b3_interior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b3_interior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b3_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b3_interior_products_with_extensions[$j]['prod_id'];
                ?>" data-uca_id="<?php 
                echo $b3_interior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b3_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b3_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b3_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 

                ?>" class="<?php 
                $check_tracking_data['o_id']=$b3_interior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b3_interior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b3_interior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b3_interior_products_with_extensions[$j]['osub_id'].".".$b3_interior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php 
                echo $orders[$i]['order_ID']."_".$b3_interior_products_with_extensions[$j]['osub_id']."_".$b3_interior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php 
                echo $orders[$i]['order_ID'];?>" data-osub_id="<?php 
                echo $b3_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b3_interior_products_with_extensions[$j]['prod_id'];?>" class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b3_interior_products_with_extensions[$j]['uca_id'];
                ?>" data-creator_end_time="<?php 

                //showing creator's end time



                $endtime=$prod->get_creator_end_time($b3_interior_products_with_extensions[$j]['uca_id']);

                if(!empty($endtime['end_time']))
                {
                    echo $endtime['end_time'];
                }
                else
                {
                    echo "";
                }

                ?>"></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b3_interior_products_with_extensions[$j]['o_id']."_".$b3_interior_products_with_extensions[$j]['osub_id']."_".$b3_interior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b3_interior_products_with_extensions[$j]['o_id']."_".$b3_interior_products_with_extensions[$j]['osub_id']."_".$b3_interior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>    
                </p>

                <?php

                }

                ?>

            </div>

        </div>

        <?php

    }
}


    //end b3 interior



//start b5 interior



$b5_interior_products_with_extensions=$prod->get_b5_interior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b5_interior_products_with_extensions))
{
    if(count($b5_interior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100" style="background-color:#fff">

            <div class="col-lg-4 col-12 px-2 colorline">   

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b5_interior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b5_interior_products_with_extensions[$j]['osub_id']!=$b5_interior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 colorline"> 

                <?php    

                }

            ?>    
                <?php 
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                $subo_data['o_id']=$b5_interior_products_with_extensions[$j]['o_id'];
                $subo_data['o_sub_id']=$b5_interior_products_with_extensions[$j]['osub_id'];

                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                
                echo $subo_name['subo_name'];
                $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">            
                <a id="taskdetails<?php 
                echo $b5_interior_products_with_extensions[$j]['o_id']."_".$b5_interior_products_with_extensions[$j]['osub_id']."_".$b5_interior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b5_interior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b5_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b5_interior_products_with_extensions[$j]['prod_id'];?>" data-uca_id="<?php 
                echo $b5_interior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b5_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b5_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b5_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 

                ?>" class="<?php 
                $check_tracking_data['o_id']=$b5_interior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b5_interior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b5_interior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b5_interior_products_with_extensions[$j]['osub_id'].".".$b5_interior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php 
                echo $orders[$i]['order_ID']."_".$b5_interior_products_with_extensions[$j]['osub_id']."_".$b5_interior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php 
                echo $orders[$i]['order_ID'];
                ?>" data-osub_id="<?php
                echo $b5_interior_products_with_extensions[$j]['osub_id']; ?>" data-prod_id="<?php 
                echo $b5_interior_products_with_extensions[$j]['prod_id'];
                ?>" class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b5_interior_products_with_extensions[$j]['uca_id'];?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b5_interior_products_with_extensions[$j]['uca_id']);

                echo $endtime['end_time'];

                ?>"></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b5_interior_products_with_extensions[$j]['o_id']."_".$b5_interior_products_with_extensions[$j]['osub_id']."_".$b5_interior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b5_interior_products_with_extensions[$j]['o_id']."_".$b5_interior_products_with_extensions[$j]['osub_id']."_".$b5_interior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>     
            </p>

                <?php

            }

                ?>

            </div>

        </div>

        <?php

    }
}

    //end b5 interior



//start b6 interior



$b6_interior_products_with_extensions=$prod->get_b6_interior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b6_interior_products_with_extensions))
{
    if(count($b6_interior_products_with_extensions)>0)
    {

        ?>

        <div class="row mx-0 w-100" style="background-color:#fff">

            <div class="col-lg-4 col-12 px-2 colorline">   

            <?php

            for($j=0;$j<count($b6_interior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b6_interior_products_with_extensions[$j]['osub_id']!=$b6_interior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 colorline"> 

                <?php    

                }

            ?>    
                <?php 
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                $subo_data['o_id']=$b6_interior_products_with_extensions[$j]['o_id'];
                $subo_data['o_sub_id']=$b6_interior_products_with_extensions[$j]['osub_id'];

                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                
                echo $subo_name['subo_name'];
                $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">
                <a id="taskdetails<?php 
                echo $b6_interior_products_with_extensions[$j]['o_id']."_".$b6_interior_products_with_extensions[$j]['osub_id']."_".$b6_interior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b6_interior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b6_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b6_interior_products_with_extensions[$j]['prod_id'];?>" data-uca_id="<?php 
                echo $b6_interior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b6_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b6_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b6_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 

                ?>" class="<?php 
                $check_tracking_data['o_id']=$b6_interior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b6_interior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b6_interior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b6_interior_products_with_extensions[$j]['osub_id'].".".$b6_interior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php 
                echo $orders[$i]['order_ID']."_".$b6_interior_products_with_extensions[$j]['osub_id']."_".$b6_interior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php 
                echo $orders[$i]['order_ID'];
                ?>" data-osub_id="<?php 
                echo $b6_interior_products_with_extensions[$j]['osub_id'];?>" data-prod-id="<?php 
                echo $b6_interior_products_with_extensions[$j]['prod_id'];?>" class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php
                echo $b6_interior_products_with_extensions[$j]['uca_id']; ?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b6_interior_products_with_extensions[$j]['uca_id']);

                echo $endtime['end_time'];

                ?>"></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b6_interior_products_with_extensions[$j]['o_id']."_".$b6_interior_products_with_extensions[$j]['osub_id']."_".$b6_interior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b6_interior_products_with_extensions[$j]['o_id']."_".$b6_interior_products_with_extensions[$j]['osub_id']."_".$b6_interior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>    
            </p>

                <?php

                }

                ?>

            </div>

        </div>

        <?php

    }
}


    //end b6 interior



//start b7 interior



$b7_interior_products_with_extensions=$prod->get_b7_interior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b7_interior_products_with_extensions))
{
    if(count($b7_interior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100" style="background-color:#fff">

            <div class="col-lg-4 col-12 px-2 colorline">   

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b7_interior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b7_interior_products_with_extensions[$j]['osub_id']!=$b7_interior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 colorline"> 

                <?php    

                }

            ?>    
                <?php 
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                $subo_data['o_id']=$b7_interior_products_with_extensions[$j]['o_id'];
                $subo_data['o_sub_id']=$b7_interior_products_with_extensions[$j]['osub_id'];

                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                if(!empty($subo_name['subo_name']))
                {
                echo $subo_name['subo_name'];
                }
                $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">
                <a id="taskdetails<?php 
                echo $b7_interior_products_with_extensions[$j]['o_id']."_".$b7_interior_products_with_extensions[$j]['osub_id']."_".$b7_interior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b7_interior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b7_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b7_interior_products_with_extensions[$j]['prod_id'];?>" data-uca_id="<?php 
                echo $b7_interior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b7_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b7_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b7_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
                
                ?>" class="<?php 
                $check_tracking_data['o_id']=$b7_interior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b7_interior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b7_interior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b7_interior_products_with_extensions[$j]['osub_id'].".".$b7_interior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php 
                echo $orders[$i]['order_ID']."_".$b7_interior_products_with_extensions[$j]['osub_id']."_".$b7_interior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php 
                echo $orders[$i]['order_ID'];
                ?>" data-osub_id="<?php 
                echo $b7_interior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b7_interior_products_with_extensions[$j]['prod_id'];?>" class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b7_interior_products_with_extensions[$j]['uca_id'];
                ?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b7_interior_products_with_extensions[$j]['uca_id']);
                if(!empty($endtime['end_time']))
                {
                            echo $endtime['end_time'];
                }
                else
                {
                    echo "";
                }
                ?>"></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b7_interior_products_with_extensions[$j]['o_id']."_".$b7_interior_products_with_extensions[$j]['osub_id']."_".$b7_interior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b7_interior_products_with_extensions[$j]['o_id']."_".$b7_interior_products_with_extensions[$j]['osub_id']."_".$b7_interior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>    
            </p>

                <?php

                }

                ?>

            </div>

        </div>

        <?php

    }
}


    //end b7 interior



//start b8 interior



$b8_interior_products_with_extensions=$prod->get_b8_interior_products_with_extensions($orders[$i]['order_ID']);



if(!empty($b8_interior_products_with_extensions))
{
if(count($b8_interior_products_with_extensions)>0)

{

    ?>

    <div class="row mx-0 w-100" style="background-color:#fff">

        <div class="col-lg-4 col-12 px-2 colorline">   

        <?php
        $subo_name_counter=0;
        for($j=0;$j<count($b8_interior_products_with_extensions);$j++)

        {

            if(($j>0)&&($b8_interior_products_with_extensions[$j]['osub_id']!=$b8_interior_products_with_extensions[$j-1]['osub_id']))

            {
                $subo_name_counter=0;
            ?>

            </div> <!-- end column -->

            <div class="col-lg-4 col-12 px-2 colorline"> 

            <?php    

            }

        ?>    
        <?php 
            if($subo_name_counter==0)
            {
                ?><span><b><?php
            $subo_data['o_id']=$b8_interior_products_with_extensions[$j]['o_id'];
            $subo_data['o_sub_id']=$b8_interior_products_with_extensions[$j]['osub_id'];

            $subo_name=$prod->check_existing_subid(json_encode($subo_data));
            
            echo $subo_name['subo_name'];
            $subo_name_counter++;
            ?></b></span><br><?php
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

            ?>">            
            <a id="taskdetails<?php 
            echo $b8_interior_products_with_extensions[$j]['o_id']."_".$b8_interior_products_with_extensions[$j]['osub_id']."_".$b8_interior_products_with_extensions[$j]['prod_id'];
            ?>" data-o_id="<?php 
            echo $b8_interior_products_with_extensions[$j]['o_id'];
            ?>" data-osub_id="<?php 
            echo $b8_interior_products_with_extensions[$j]['osub_id'];
            ?>" data-prod_id="<?php 
            echo $b8_interior_products_with_extensions[$j]['prod_id'];?>" data-uca_id="<?php 
            echo $b8_interior_products_with_extensions[$j]['uca_id'];
            ?>" href="taskdetails.php?o_id=<?php 
            echo $b8_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
            echo $b8_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
            echo $b8_interior_products_with_extensions[$j]['prod_id'];?>" title="<?php 

            ?>" class="<?php 
            $check_tracking_data['o_id']=$b8_interior_products_with_extensions[$j]['o_id'];
            $check_tracking_data['osub_id']=$b8_interior_products_with_extensions[$j]['osub_id'];
            $check_tracking_data['prod_id']=$b8_interior_products_with_extensions[$j]['prod_id'];
            $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

            $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
            
            if(!empty($checking_user_tracking_taskdetails))
            {
                echo "blinking_text";
            }
            ?>"><?php

            echo $b8_interior_products_with_extensions[$j]['osub_id'].".".$b8_interior_products_with_extensions[$j]['prod_id'];?>

            <br><span id="assigned_creator_name<?php 
            echo $orders[$i]['order_ID']."_".$b8_interior_products_with_extensions[$j]['osub_id']."_".$b8_interior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php 
            echo $orders[$i]['order_ID'];
            ?>" data-osub_id="<?php echo $b8_interior_products_with_extensions[$j]['osub_id'];?>" data-prod-id="<?php 
            echo $b8_interior_products_with_extensions[$j]['prod_id'];?>" class="d-none assigned_creator_name<?php 
            echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
            echo $b8_interior_products_with_extensions[$j]['uca_id'];?>" data-creator_end_time="<?php 

            //showing creator's end time

            $endtime=$prod->get_creator_end_time($b8_interior_products_with_extensions[$j]['uca_id']);

            echo $endtime['end_time'];

            ?>"></span></a>
            <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b8_interior_products_with_extensions[$j]['o_id']."_".$b8_interior_products_with_extensions[$j]['osub_id']."_".$b8_interior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b8_interior_products_with_extensions[$j]['o_id']."_".$b8_interior_products_with_extensions[$j]['osub_id']."_".$b8_interior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
            </script>    
        </p>

            <?php

            }

            ?>

        </div>

    </div>

    <?php

}
}


    //end b8 interior

    ?>    
</div> <!-- end interior -->

<div class="row mx-0 w-100 interior border-bot mb-2">

<?php

//start b1 exterior 



$b1_exterior_products_with_extensions=$prod->get_b1_exterior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b1_exterior_products_with_extensions))
{
    if(count($b1_exterior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100 exterior">

            <div class="col-lg-4 col-12  px-2 ">

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b1_exterior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b1_exterior_products_with_extensions[$j]['osub_id']!=$b1_exterior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 "> 

                <?php    

                }

            ?>    
                <?php 
                    if($subo_name_counter==0)
                    {
                        ?><span><b><?php
                    $subo_data['o_id']=$b1_exterior_products_with_extensions[$j]['o_id'];
                    $subo_data['o_sub_id']=$b1_exterior_products_with_extensions[$j]['osub_id'];

                    $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                    
                    echo $subo_name['subo_name'];
                    $subo_name_counter++;
                    ?></b></span><br><?php
                    }
                    ?>
                <p class="p-1 float-left m-1 <?php

                for($s=0;$s<count($allstatus);$s++)

                {

                    if($allstatus[$s]['ost_id']==$b1_exterior_products_with_extensions[$j]['p_status'])

                    {

                        echo $allstatus[$s]['ost_color'];

                    }

                }

                

                if($b1_exterior_products_with_extensions[$j]['om_id']!=0)

                {

                    echo " red-border";

                }

                ?>">
                <a id="taskdetails<?php 
                echo $b1_exterior_products_with_extensions[$j]['o_id']."_".$b1_exterior_products_with_extensions[$j]['osub_id']."_".$b1_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b1_exterior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b1_exterior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b1_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-uca_id="<?php 
                echo $b1_exterior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b1_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b1_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b1_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
                
                ?>" class=""><?php

                echo $b1_exterior_products_with_extensions[$j]['osub_id'].".".$b1_exterior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php
                echo $orders[$i]['order_ID']."_".$b1_exterior_products_with_extensions[$j]['osub_id']."_".$b1_exterior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php
                echo $orders[$i]['order_ID'];?>" data-osub_id="<?php
                echo $b1_exterior_products_with_extensions[$j]['osub_id']; ?>" data-prod_id="<?php 
                echo $b1_exterior_products_with_extensions[$j]['prod_id']?>"
                class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b1_exterior_products_with_extensions[$j]['uca_id'];?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b1_exterior_products_with_extensions[$j]['uca_id']);

                echo $endtime['end_time'];



                ?>"><?php
            
                ?></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b1_exterior_products_with_extensions[$j]['o_id']."_".$b1_exterior_products_with_extensions[$j]['osub_id']."_".$b1_exterior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b1_exterior_products_with_extensions[$j]['o_id']."_".$b1_exterior_products_with_extensions[$j]['osub_id']."_".$b1_exterior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>
                </p>  

            <?php

            }

            ?>    

            </div>

        </div> <!-- end exterior -->

        <?php

    }
}
//end b1 exterior

    //start b5 exterior 



$b5_exterior_products_with_extensions=$prod->get_b5_exterior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b5_exterior_products_with_extensions))
{
    if(count($b5_exterior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100 exterior">

            <div class="col-lg-4 col-12  px-2 ">

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b5_exterior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b5_exterior_products_with_extensions[$j]['osub_id']!=$b5_exterior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 "> 

                <?php    

                }

            ?>    
            <?php 
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                    if($b5_exterior_products_with_extensions[$j]['om_id']==0)
                    {
                        $subo_data['o_id']=$b5_exterior_products_with_extensions[$j]['o_id'];
                    }
                    else
                    {
                        $subo_data['o_id']=$b5_exterior_products_with_extensions[$j]['om_id'];
                    }
                $subo_data['o_sub_id']=$b5_exterior_products_with_extensions[$j]['osub_id'];

                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                
                echo $subo_name['subo_name'];
                $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">
                <a id="taskdetails<?php 
                echo $b5_exterior_products_with_extensions[$j]['o_id']."_".$b5_exterior_products_with_extensions[$j]['osub_id']."_".$b5_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b5_exterior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b5_exterior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b5_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-uca_id="<?php 
                echo $b5_exterior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b5_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b5_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b5_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
                
                ?>" class="<?php 
                $check_tracking_data['o_id']=$b5_exterior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b5_exterior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b5_exterior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b5_exterior_products_with_extensions[$j]['osub_id'].".".$b5_exterior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php
                echo $orders[$i]['order_ID']."_".$b5_exterior_products_with_extensions[$j]['osub_id']."_".$b5_exterior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php
                echo $orders[$i]['order_ID'];?>" data-osub_id="<?php
                echo $b5_exterior_products_with_extensions[$j]['osub_id']; ?>" data-prod_id="<?php 
                echo $b5_exterior_products_with_extensions[$j]['prod_id']?>"
                class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b5_exterior_products_with_extensions[$j]['uca_id'];?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b5_exterior_products_with_extensions[$j]['uca_id']);

                echo $endtime['end_time'];



                ?>"><?php
            
                ?></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b5_exterior_products_with_extensions[$j]['o_id']."_".$b5_exterior_products_with_extensions[$j]['osub_id']."_".$b5_exterior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b5_exterior_products_with_extensions[$j]['o_id']."_".$b5_exterior_products_with_extensions[$j]['osub_id']."_".$b5_exterior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>
                </p>  

            <?php

            }

            ?>    

            </div>

        </div> <!-- end exterior -->

        <?php

    }
}


    //end b5 exterior



    //start b6 exterior 



$b6_exterior_products_with_extensions=$prod->get_b6_exterior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b6_exterior_products_with_extensions))
{
    if(count($b6_exterior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100 exterior">

            <div class="col-lg-4 col-12 px-2 ">

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b6_exterior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b6_exterior_products_with_extensions[$j]['osub_id']!=$b6_exterior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 "> 

                <?php    

                }

            ?>    
            <?php 
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                    if($b6_exterior_products_with_extensions[$j]['om_id']==0)
                    {
                        $subo_data['o_id']=$b6_exterior_products_with_extensions[$j]['o_id'];
                    }
                    else
                    {
                        $subo_data['o_id']=$b6_exterior_products_with_extensions[$j]['om_id'];
                    }
                $subo_data['o_sub_id']=$b6_exterior_products_with_extensions[$j]['osub_id'];

                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                
                echo $subo_name['subo_name'];
                $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">            
                <a id="taskdetails<?php 
                echo $b6_exterior_products_with_extensions[$j]['o_id']."_".$b6_exterior_products_with_extensions[$j]['osub_id']."_".$b6_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b6_exterior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b6_exterior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b6_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-uca_id="<?php
                echo $b6_exterior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b6_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b6_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b6_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 
                
                ?>" class="<?php 
                $check_tracking_data['o_id']=$b6_exterior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b6_exterior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b6_exterior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");

                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b6_exterior_products_with_extensions[$j]['osub_id'].".".$b6_exterior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php
                echo $orders[$i]['order_ID']."_".$b6_exterior_products_with_extensions[$j]['osub_id']."_".$b6_exterior_products_with_extensions[$j]['prod_id']; ?>" data-o_id="<?php
                echo $orders[$i]['order_ID'];?>" data-osub_id="<?php echo $b6_exterior_products_with_extensions[$j]['osub_id'];?>" data-prod_id="<?php 
                echo $b6_exterior_products_with_extensions[$j]['prod_id']?>" data-uca_id="<?php 
                echo $b6_exterior_products_with_extensions[$j]['uca_id'];?>"
                class="d-none assigned_creator_name<?php echo $orders[$i]['order_ID'];?>" data-creator_end_time=<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b6_exterior_products_with_extensions[$j]['uca_id']);

                if(!empty($endtime['end_time']))
                {
                    echo $endtime['end_time'];
                }
                else
                {
                    echo "";
                }

                ?>><?php
                ?></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b6_exterior_products_with_extensions[$j]['o_id']."_".$b6_exterior_products_with_extensions[$j]['osub_id']."_".$b6_exterior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b6_exterior_products_with_extensions[$j]['o_id']."_".$b6_exterior_products_with_extensions[$j]['osub_id']."_".$b6_exterior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script>    
            </p>  

            <?php

            }

            ?>    

            </div>

        </div> <!-- end exterior -->

        <?php

    }
}


    //end b6 exterior



    //start b7 exterior 



$b7_exterior_products_with_extensions=$prod->get_b7_exterior_products_with_extensions($orders[$i]['order_ID']);


if(!empty($b7_exterior_products_with_extensions))
{
    if(count($b7_exterior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100 exterior">

            <div class="col-lg-4 col-12 px-2 ">

            <?php
            $subo_name_counter=0;
            for($j=0;$j<count($b7_exterior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b7_exterior_products_with_extensions[$j]['osub_id']!=$b7_exterior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2"> 

                <?php    

                }

            ?>    
            <?php 
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                $subo_data['o_id']=$b7_exterior_products_with_extensions[$j]['o_id'];
                $subo_data['o_sub_id']=$b7_exterior_products_with_extensions[$j]['osub_id'];

                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                
                echo $subo_name['subo_name'];
                $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">            
                <a id="taskdetails<?php 
                echo $b7_exterior_products_with_extensions[$j]['o_id']."_".$b7_exterior_products_with_extensions[$j]['osub_id']."_".$b7_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b7_exterior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b7_exterior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b7_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-uca_id="<?php echo $b7_exterior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b7_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b7_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b7_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 

                ?>" class="<?php 
                $check_tracking_data['o_id']=$b7_exterior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b7_exterior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b7_exterior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");
    
                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b7_exterior_products_with_extensions[$j]['osub_id'].".".$b7_exterior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php 
                echo $orders[$i]['order_ID']."_".$b7_exterior_products_with_extensions[$j]['osub_id']."_".$b7_exterior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php 
                echo $orders[$i]['order_ID'];?>" data-osub_id="<?php 
                echo $b7_exterior_products_with_extensions[$j]['osub_id'];?>" data-prod_id="<?php 
                echo $b7_exterior_products_with_extensions[$j]['prod_id'];?>" class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b7_exterior_products_with_extensions[$j]['uca_id'];?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b7_exterior_products_with_extensions[$j]['uca_id']);

                echo $endtime['end_time'];

                ?>"></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b7_exterior_products_with_extensions[$j]['o_id']."_".$b7_exterior_products_with_extensions[$j]['osub_id']."_".$b7_exterior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b7_exterior_products_with_extensions[$j]['o_id']."_".$b7_exterior_products_with_extensions[$j]['osub_id']."_".$b7_exterior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script> 
                </p>  

            <?php

            }

            ?>    

            </div>

        </div> <!-- end exterior -->

        <?php

    }
}
 

     //end b7 exterior



     //start b8 exterior 



$b8_exterior_products_with_extensions=$prod->get_b8_exterior_products_with_extensions($orders[$i]['order_ID']);

if(!empty($b8_exterior_products_with_extensions))
{
    if(count($b8_exterior_products_with_extensions)>0)

    {

        ?>

        <div class="row mx-0 w-100 exterior">

            <div class="col-lg-4 col-12 px-2 ">

            <?php
                $subo_name_counter=0;
            for($j=0;$j<count($b8_exterior_products_with_extensions);$j++)

            {

                if(($j>0)&&($b8_exterior_products_with_extensions[$j]['osub_id']!=$b8_exterior_products_with_extensions[$j-1]['osub_id']))

                {
                    $subo_name_counter=0;
                ?>

                </div> <!-- end column -->

                <div class="col-lg-4 col-12 px-2 "> 

                <?php    

                }

            ?>    
            <?php 
                if($subo_name_counter==0)
                {
                    ?><span><b><?php
                $subo_data['o_id']=$b8_exterior_products_with_extensions[$j]['o_id'];
                $subo_data['o_sub_id']=$b8_exterior_products_with_extensions[$j]['osub_id'];

                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                
                echo $subo_name['subo_name'];
                $subo_name_counter++;
                ?></b></span><br><?php
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

                ?>">             
                <a id="taskdetails<?php 
                echo $b8_exterior_products_with_extensions[$j]['o_id']."_".$b8_exterior_products_with_extensions[$j]['osub_id']."_".$b8_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-o_id="<?php 
                echo $b8_exterior_products_with_extensions[$j]['o_id'];
                ?>" data-osub_id="<?php 
                echo $b8_exterior_products_with_extensions[$j]['osub_id'];
                ?>" data-prod_id="<?php 
                echo $b8_exterior_products_with_extensions[$j]['prod_id'];
                ?>" data-uca_id="<?php 
                echo $b8_exterior_products_with_extensions[$j]['uca_id'];
                ?>" href="taskdetails.php?o_id=<?php 
                echo $b8_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php 
                echo $b8_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php 
                echo $b8_exterior_products_with_extensions[$j]['prod_id'];?>" title="<?php 

                ?>" class="<?php 
                $check_tracking_data['o_id']=$b8_exterior_products_with_extensions[$j]['o_id'];
                $check_tracking_data['osub_id']=$b8_exterior_products_with_extensions[$j]['osub_id'];
                $check_tracking_data['prod_id']=$b8_exterior_products_with_extensions[$j]['prod_id'];
                $check_tracking_data['date_visited']=gmdate("Y-m-d H:i:s");
    
                $checking_user_tracking_taskdetails=$prod->get_valid_user_tracking_taskdetails(json_encode($check_tracking_data));
                
                if(!empty($checking_user_tracking_taskdetails))
                {
                    echo "blinking_text";
                }
                ?>"><?php

                echo $b8_exterior_products_with_extensions[$j]['osub_id'].".".$b8_exterior_products_with_extensions[$j]['prod_id'];?>

                <br><span id="assigned_creator_name<?php 
                echo $orders[$i]['order_ID']."_".$b8_exterior_products_with_extensions[$j]['osub_id']."_".$b8_exterior_products_with_extensions[$j]['prod_id'];?>" data-o_id="<?php
                echo $orders[$i]['order_ID'];?>" data-osub_id="<?php 
                echo $b8_exterior_products_with_extensions[$j]['osub_id'];?>" data-prod_id="<?php 
                echo $b8_exterior_products_with_extensions[$j]['prod_id'];?>" class="d-none assigned_creator_name<?php 
                echo $orders[$i]['order_ID'];?>" data-uca_id="<?php 
                echo $b8_exterior_products_with_extensions[$j]['uca_id'];?>" data-creator_end_time="<?php 

                //showing creator's end time

                $endtime=$prod->get_creator_end_time($b8_exterior_products_with_extensions[$j]['uca_id']);

                echo $endtime['end_time'];

                ?>"></span></a>
                <script type="text/javascript">
                    $(document).ready(function(){

                    $('#taskdetails<?php echo $b8_exterior_products_with_extensions[$j]['o_id']."_".$b8_exterior_products_with_extensions[$j]['osub_id']."_".$b8_exterior_products_with_extensions[$j]['prod_id']; ?>').hover(function(){
                        let o_id=$(this).data('o_id');
                        let osub_id=$(this).data('osub_id');
                        let prod_id=$(this).data('prod_id');
                        let uca_id=$(this).data('uca_id');
                        
                        $.ajax({

                            url: "../ajax/get_creator_activity.php",
                            method: "get",
                            data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                            dataType:"html",
                            success:function(data) {

                                $('#taskdetails<?php echo $b8_exterior_products_with_extensions[$j]['o_id']."_".$b8_exterior_products_with_extensions[$j]['osub_id']."_".$b8_exterior_products_with_extensions[$j]['prod_id']; ?>').attr('title',data);

                            }

                            });
                    });

                });
                </script> 
                </p>  

            <?php

            }

            ?>    

            </div>

        </div> <!-- end exterior -->

        <?php

    }
}
 

     //end b8 exterior

    ?>    

</div>

</div>

<?php

}

?>