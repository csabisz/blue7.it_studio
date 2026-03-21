<?php

if($_SESSION['view_all_orders']==1)
{
    $orders=$prod->show_finished_orders_by_on_stock($on_stock,$startpoint,$limit);
}
else
{
    //$client=$prod->get_client($_SESSION['client_id']);

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
<div class="row mx-0 w-100 mb-4" id="projectid<?php echo $orders[$i]['order_ID'];?>">
    <div class="row mx-0 w-100 bg-table-finished interface">
        <div class="col-12 col-xl-4 text-center text-xl-left">
            <div class="row mx-0 px-0 w-100">
                <div class="col-xl-2 px-0"><p class="text-xl-left projectid mb-0"><?php echo $orders[$i]['order_ID'];
                if($orders[$i]['om_id']>0)
                {
                    echo "-".$orders[$i]['om_id'];
                }
                ?></p></div>
                <div class="col-xl-10 px-0"><p class="text-center client mb-0"><?php 
                $client=$prod->get_client($orders[$i]['u_client_ID']);
                if(!empty($client['c_last_name']))
                {
                    echo $client['clientname']." - ".$client['c_first_name'].", ".$client['c_last_name'];
                }
                else
                {
                    echo $client['clientname']." - ".$client['l_first_name'].", ".$client['l_last_name'];
                }
                ?></p></div>
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
        <div class="col-12 col-xl-2 time text-center text-xl-right pt-2"><?php echo $orders[$i]['o_date'];
         if($orders[$i]['o_deadline']!="0000-00-00 00:00:00")
         {
         ?>
         <br><span class="text-danger">Deadline: <?php echo $orders[$i]['o_deadline'];?> UTC+0</span>
         <?php
         }
        ?></div>
        <div class="col-12 col-xl-4 text-xl-right text-center pt-2">
            <p class="tasks d-inline mr-xl-2 px-2 py-1"><span><?php 
            $tasks=$prod->count_finished_tasks_by_orderid_coordination($orders[$i]['order_ID']);
            echo $tasks;
            ?></span> / <span><?php
            $total_tasks=$prod->count_total_tasks_coordination($orders[$i]['order_ID']);
            echo $total_tasks;
            ?></span> task(s) finished</p> 
            <a href="https://bauvorschau.com/<?php echo $orders[$i]['order_ID'];?>" class="btn btn-primary btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline" target="_blank">Presentation</a>
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
                <a href="orderdetails.php?o_id=<?php echo $orders[$i]['order_ID'];?>" class="btn btn-sm d-inline text-white view">View details</a>
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
    <div class="row mx-0 w-100 exterior py-4">
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
            ?>"><a href="taskdetails.php?o_id=<?php echo $b5_exterior_products_with_extensions[$j]['o_id'];?>&osub_id=<?php echo $b5_exterior_products_with_extensions[$j]['osub_id'];?>&prod_id=<?php echo $b5_exterior_products_with_extensions[$j]['prod_id'];?>"><?php
            echo $b5_exterior_products_with_extensions[$j]['osub_id'].".".$b5_exterior_products_with_extensions[$j]['prod_id'];?></a></p>  
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
    <div class="row mx-0 w-100 exterior py-4">
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
    <div class="row mx-0 w-100 exterior py-4">
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
    <div class="row mx-0 w-100 exterior py-4">
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