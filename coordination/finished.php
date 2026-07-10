<?php



if($_COOKIE['view_all_orders']==1)

{

    $orders=$prod->show_finished_orders_by_on_stock($on_stock,$startpoint,$limit);
    
}

else

{

    //$client=$prod->get_client($_COOKIE['client_id']);



    //$licence_sites=explode(";",$client['ls_ids']);



   // for($l=0;$l<count($licence_sites);$l++)

    //{



    //$orders=$prod->show_finished_orders_by_ls_id_on_stock($licence_sites[0],$startpoint,$limit,$on_stock); //1 website for now

    //}

    $lic_ids_array=array();



    for($l=0;$l<count($licences);$l++)

    {

        $lic_ids_array[]=$licences[$l]['lic_id'];

    }

    //print_r($lic_ids_array);

    $orders=$prod->show_finished_orders_by_lic_ids_on_stock($lic_ids_array,$startpoint,$limit,$on_stock);

}







$pages=count($orders);



for($i=0;$i<count($orders);$i++)

{

?>

<div class="row mx-0 w-100 px-3 mb-2" id="projectid<?php echo $orders[$i]['order_ID'];?>">

    <div class="row mx-0 w-100 bg-table-finished interface">

        <div class="col-12 col-xl-4 text-center text-xl-left d-flex align-items-center">

            <div class="row mx-0 px-0 w-100">

                <div class="col-xl-6 px-0">

                    <p class="text-xl-left projectid mb-0">

                    <?php

                    /*if($orders[$i]['special_order']==1)

                    {

                    ?>

                    <i class="fa fa-star" aria-hidden="true" style="color:goldenrod;"></i>

                    <?php

                    }*/

                    ?>

                    <?php echo $orders[$i]['order_ID'];

                    if($orders[$i]['om_id']>0)

                    {

                        echo "-".$orders[$i]['om_id'];

                    }

                    ?></p>
                    <div class="row">
                        <div class="col-md-6">
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

                <div class="col-xl-6 px-0"><p class="text-center client mb-0"><?php 

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

                ?></p></div>

            </div>

            </div>

            <div class="col-12 col-xl-2 text-center d-flex align-items-center flex-column">

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

        <div class="col-12 col-xl-2 time text-center text-xl-right pt-2 d-flex align-items-center"><?php echo $orders[$i]['o_date'];

         if($orders[$i]['o_deadline']!="0000-00-00 00:00:00")

         {

         ?>

         <br><span class="text-danger">Deadline: <?php echo $orders[$i]['o_deadline'];?> UTC+0</span>

         <?php

         }

        ?></div>

        <div class="col-12 col-xl-4 text-xl-right text-center pt-2">

            <div class="row w-100 mx-0">

                <div class="col-3 px-0 d-flex align-items-center justify-content-center flex-column">

                    <p class="mb-0 w-100 text-left tasksTextFinished">

                            <strong>

                                <?php 

                                    $tasks=$prod->count_finished_tasks_by_orderid_coordination($orders[$i]['order_ID']);

                                    echo $tasks;

                                ?>

                            </strong> 

                            /

                            <strong>

                                <?php

                                    $total_tasks=$prod->count_total_tasks_coordination($orders[$i]['order_ID']);

                                    echo $total_tasks;

                                ?>

                            </strong>

                            &nbsp; task(s) finished

                        </p>

                    <div class="tasks d-inline rounded-pill w-100 bg-white mb-1" style="height: 10px;">

                        <div class="children finished rounded-pill" style="width: <?php echo ($tasks * 100)/$total_tasks ?>%; height: 100%; position: absolute; top: 0; left: 0; background: #2A6911; z-index: 1;">

                        </div>

                    </div>

                </div>

                <div class="col-9">

                <a href="orderdetails4.php?o_id=<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm d-inline text-white btn-primary ml-4 ml-md-4 ml-auto">Details</a>

                <a href="https://bauvorschau.com/<?php 
                if($orders[$i]['om_id']==0)
                {
                    echo $orders[$i]['order_ID'];
                }
                else
                {
                    echo $orders[$i]['om_id'];
                }?>" class="btn btn-success btn-sm px-2 mr-auto mr-md-0 d-md-inline" target="_blank">Presentation</a>
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

            
                
                <!--<button id="on_stock_btn<?php echo $orders[$i]['order_ID'];?>" data-on_stock="<?php echo $orders[$i]['on_stock'];?>" class="btn btn-sm <?php echo ($orders[$i]['on_stock']==1)?"btn-warning":"btn-success";?> d-inline"><?php echo ($orders[$i]['on_stock']==0)?"Put On stock":"Put On Normal";?></button>-->
                <select id="multiple_status<?php echo $orders[$i]['order_ID'];?>" style="width:15em;" class="d-inline form-control form-control-sm <?php 
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

                                    $("#on_stock_btn<?php echo $orders[$i]['order_ID'];?>").html("Put On Normal");

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



                });*/

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

    

    <?php

    //start b5 exterior 



    $b5_exterior_products_with_extensions=$prod->get_b5_exterior_products_with_extensions($orders[$i]['order_ID']);



    if(count($b5_exterior_products_with_extensions)>0)

    {

    ?>

    <div class="row mx-0 w-100 exterior">

        <div class="col-lg-4 col-12 px-2 ">

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

            ?>"><a id="taskdetails<?php 
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
            echo $b5_exterior_products_with_extensions[$j]['prod_id'];?>" title="" class="<?php 
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

            ?>"><a href="taskdetails.php?o_id=<?php echo $b6_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b6_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b6_exterior_products_with_extensions[$j]['prod_id'];?>"><?php

            echo $b6_exterior_products_with_extensions[$j]['osub_id'].".".$b6_exterior_products_with_extensions[$j]['prod_id'];?></a></p>  

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

            <div class="col-lg-4 col-12 px-2 "> 

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

            ?>"><a href="taskdetails.php?o_id=<?php echo $b7_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b7_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b7_exterior_products_with_extensions[$j]['prod_id'];?>"><?php

            echo $b7_exterior_products_with_extensions[$j]['osub_id'].".".$b7_exterior_products_with_extensions[$j]['prod_id'];?></a></p>  

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

            ?>"><a href="taskdetails.php?o_id=<?php echo $b8_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b8_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b8_exterior_products_with_extensions[$j]['prod_id'];?>"><?php

            echo $b8_exterior_products_with_extensions[$j]['osub_id'].".".$b8_exterior_products_with_extensions[$j]['prod_id'];?></a></p>  

        <?php

        }

        ?>    

        </div>

    </div> <!-- end exterior -->

    <?php

    }



    //end b8 exterior

    ?>        

    

    <div class="row mx-0 w-100 interior border-bot mb-2">

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

            ?>"><a href="taskdetails.php?o_id=<?php echo $b3_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b3_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b3_interior_products_with_extensions[$j]['prod_id'];?>"><?php

            echo $b3_interior_products_with_extensions[$j]['osub_id'].".".$b3_interior_products_with_extensions[$j]['prod_id'];?></a></p>

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

            ?>"><a href="taskdetails.php?o_id=<?php echo $b5_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b5_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b5_interior_products_with_extensions[$j]['prod_id'];?>"><?php

            echo $b5_interior_products_with_extensions[$j]['osub_id'].".".$b5_interior_products_with_extensions[$j]['prod_id'];?></a></p>

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

        ?>"><a href="taskdetails.php?o_id=<?php echo $b6_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b6_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b6_interior_products_with_extensions[$j]['prod_id'];?>"><?php

        echo $b6_interior_products_with_extensions[$j]['osub_id'].".".$b6_interior_products_with_extensions[$j]['prod_id'];?></a></p>

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

        ?>"><a href="taskdetails.php?o_id=<?php echo $b7_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b7_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b7_interior_products_with_extensions[$j]['prod_id'];?>"><?php

        echo $b7_interior_products_with_extensions[$j]['osub_id'].".".$b7_interior_products_with_extensions[$j]['prod_id'];?></a></p>

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

        ?>"><a href="taskdetails.php?o_id=<?php echo $b8_interior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b8_interior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b8_interior_products_with_extensions[$j]['prod_id'];?>"><?php

        echo $b8_interior_products_with_extensions[$j]['osub_id'].".".$b8_interior_products_with_extensions[$j]['prod_id'];?></a></p>

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