<?php
session_start();

include("../functions.php");

$prod=new Production;

include('../header2.php');
include('../menu.php');

if(isset($_GET['o_id']))
{
$o_id=$prod->xss_fix($_GET['o_id']);
$order=$prod->get_order($o_id);
?>
<div class="container">
<?php
$b3_interior_products_with_extensions=$prod->get_b3_interior_products_with_extensions($o_id);
        
if(count($b3_interior_products_with_extensions)>0)
{
    for($i=0;$i<count($b3_interior_products_with_extensions);$i++)
    {
    ?>
    <div class="row">
        <div class="col-md-3">
        <?php 
        echo $b3_interior_products_with_extensions[$i]['o_id'].".".$b3_interior_products_with_extensions[$i]['osub_id'].".".$b3_interior_products_with_extensions[$i]['prod_id'];
        $product=$prod->get_product($b3_interior_products_with_extensions[$i]['prod_id']);
        echo " ".$product['prod_name'];
        ?>
        </div>
    </div>
    <?php        
    }
}

//end b3_interior_products_with_extensions

$b5_interior_products_with_extensions=$prod->get_b5_interior_products_with_extensions($o_id);
// echo count($b5_interior_products_with_extensions);
if(count($b5_interior_products_with_extensions)>0)
{
    
    for($k=0;$k<count($b5_interior_products_with_extensions);$k++)
    {
        
    ?>
    <div class="row">
        <div class="col-md-2">
        <?php 
        echo $b5_interior_products_with_extensions[$k]['o_id'].".".$b5_interior_products_with_extensions[$k]['osub_id'].".".$b5_interior_products_with_extensions[$k]['prod_id'];
        $product=$prod->get_product($b5_interior_products_with_extensions[$k]['prod_id']);
        echo " ".$product['prod_name'];
        echo " Assigned to ".$b5_interior_products_with_extensions[$k]['uca_id'];
        ?>
        </div>
        <div class="col-md-3">
        <?php
        $all_creators=$prod->show_creators($order['u_prod_id']);
        $all_other_creators=$prod->show_creators_other_companies($order['u_prod_id']);
        
        //print_r($all_creators);
        $first_found_creator=0;
        $found_uca_id=array();

        for($i=0;$i<count($all_creators);$i++)
        {
            $client_qualifications=$prod->get_client_qualifications($all_creators[$i]['client_ID']);
            //$creator_right=$prod->get_creator_right($all_creators[$i]['uca_id']);
            
            if($all_creators[$i]['u_status']=="active")
            {
                if($b5_interior_products_with_extensions[$k]['prod_id']=="p1501")
                {
                    if(($client_qualifications['b5_walls']>0)||($client_qualifications['b5_windows_doors']>0))
                    {      
                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_creators[$i]['client_ID']; 
                    echo " ".$all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($b5_interior_products_with_extensions[$k]['uca_id']==0))
                    {
                        $found_uca_id[]=$all_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }
                    }
                }	
                
                


                if(($b5_interior_products_with_extensions[$k]['prod_id']=="p1521")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1541"))
                {
                    if($client_qualifications['b5_furniture']>0)
                    {                
                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_creators[$i]['client_ID'];
                    echo " ".$all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }

                    }
                }

                if(((substr($b5_interior_products_with_extensions[$k]['prod_id'],1)>1501)&&(substr($b5_interior_products_with_extensions[$k]['prod_id'],1)<1506))||((substr($b5_interior_products_with_extensions[$k]['prod_id'],1)>1521)&&(substr($b5_interior_products_with_extensions[$k]['prod_id'],1)<1526))||((substr($b5_interior_products_with_extensions[$k]['prod_id'],1)>1541)&&(substr($b5_interior_products_with_extensions[$k]['prod_id'],1)<1546)))
                {
                    if($client_qualifications['b5_render_stills']>0)
                    {                
                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_creators[$i]['client_ID'];
                    echo " ".$all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }

                    }
                }


                if(($b5_interior_products_with_extensions[$k]['prod_id']=="p1506")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1526")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1546"))
                {
                    if($client_qualifications['b5_render_360']>0)
                    {                
                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_creators[$i]['client_ID'];
                    echo " ".$all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }

                    }
                }	

                if(($b5_interior_products_with_extensions[$k]['prod_id']=="p1507")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1527")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1547"))
                {
                    if($client_qualifications['b5_render_movie']>0)
                    {
                
                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_creators[$i]['client_ID'];
                    echo " ".$all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name'];
                    echo "<br>";     
                    
                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }

                    }
                }

            }
        }
        
        $other_resources_counter=0;
        
        for($i=0;$i<count($all_other_creators);$i++)
        {
            $client_qualifications=$prod->get_client_qualifications($all_other_creators[$i]['client_ID']);
            //$creator_right=$prod->get_creator_right($all_other_creators[$i]['uca_id']);
            
            
            if($all_other_creators[$i]['u_status']=="active")
            {
                if($b5_interior_products_with_extensions[$k]['prod_id']=="p1501")
                {														
                    if(($client_qualifications['b5_walls']>0)||($client_qualifications['b5_windows_doors']>0))
                    {	
                        if($other_resources_counter==0)
                        {
                            ?>
                            <span style="color:red;">Resources from other companies</span><br>
                            <?php
                            $other_resources_counter++;
                        }

                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_other_creators[$i]['client_ID'];
                    echo " ".$all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($b5_interior_products_with_extensions[$k]['uca_id']==0))
                    {
                        $found_uca_id[]=$all_other_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }
                    }
                }
                
                

                if(($b5_interior_products_with_extensions[$k]['prod_id']=="p1521")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1541"))
                {														
                    if($client_qualifications['b5_furniture']>0)
                    {	
                        if($other_resources_counter==0)
                        {
                            ?>
                            <span style="color:red;">Resources from other companies</span><br>
                            <?php
                            $other_resources_counter++;
                        }
                
                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_other_creators[$i]['client_ID'];
                    echo " ".$all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_other_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }

                    }
                }	

                if(((substr($b5_interior_products_with_extensions[$k]['prod_id'],1)>1501)&&(substr($b5_interior_products_with_extensions[$k]['prod_id'],1)<1506))||((substr($b5_interior_products_with_extensions[$k]['prod_id'],1)>1521)&&(substr($b5_interior_products_with_extensions[$k]['prod_id'],1)<1526))||((substr($b5_interior_products_with_extensions[$k]['prod_id'],1)>1541)&&(substr($b5_interior_products_with_extensions[$k]['prod_id'],1)<1546)))
                {														
                    if($client_qualifications['b5_render_stills']>0)
                    {	
                        if($other_resources_counter==0)
                        {
                            ?>
                            <span style="color:red;">Resources from other companies</span><br>
                            <?php
                            $other_resources_counter++;
                        }
                
                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_other_creators[$i]['client_ID'];
                    echo " ".$all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_other_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }

                    }
                }	

                if(($b5_interior_products_with_extensions[$k]['prod_id']=="p1506")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1526")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1546"))
                {														
                    if($client_qualifications['b5_render_360']>0)
                    {	
                        if($other_resources_counter==0)
                        {
                            ?>
                            <span style="color:red;">Resources from other companies</span><br>
                            <?php
                            $other_resources_counter++;
                        }                
                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_other_creators[$i]['client_ID'];
                    echo " ".$all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_other_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }

                    }
                }	

                if(($b5_interior_products_with_extensions[$k]['prod_id']=="p1507")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1527")||($b5_interior_products_with_extensions[$k]['prod_id']=="p1547"))
                {														
                    if($client_qualifications['b5_render_movie']>0)
                    {	
                        if($other_resources_counter==0)
                        {
                            ?>
                            <span style="color:red;">Resources from other companies</span><br>
                            <?php
                            $other_resources_counter++;
                        }
            
                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                    echo "tasks=".count($count_working_tasks);
                    echo " id=".$all_other_creators[$i]['client_ID'];
                    echo " ".$all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'];
                    echo "<br>";

                    if((count($count_working_tasks)==0)&&($first_found_creator==0))
                    {
                        $found_uca_id[]=$all_other_creators[$i]['client_ID'];
                        $first_found_creator++;
                    }
                    }
                }

            }
        }
        
        ?>
        </div>
        <div class="col-md-3">
        <?php
        
        rsort($found_uca_id);
        echo $found_uca_id[0];
        ?>
        </div>
        <?php
        /*
        <div class="col-md-3">
        Found creators <?php
        

        // for($j=0;$j<count($found_uca_id);$j++)
        // {
            ?>
            <div class="possible_creators<?php echo $k;?>" data-uca_id="<?php echo $found_uca_id;?>"><?php
            echo $found_uca_id;?>
            </div>
        
        <div id="end_time_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id;?>"><?php
        $endtime=$prod->get_creator_end_time($found_uca_id);
        echo $endtime['end_time']; 
        ?></div>
        <div id="timezone_date_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id;?>"></div>
        <script type="text/javascript">
        $(document).ready(function(){
        var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        var creatorUTCendtime = moment.tz($('#end_time_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id;?>').text(), 'UTC');
        console.log(creatorUTCendtime);
        var dateset = creatorUTCendtime
            .clone()
            .tz(user_timezone)
            .format('YYYY-MM-DD HH:mm');
        $('#timezone_date_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id;?>').text(dateset);
        console.log(dateset);
        });
        </script>
        <?php
        //}
        ?>
        </div>
        <div class="col-md-2">
        <?php
        for($j=0;$j<count($found_uca_id);$j++)
        {
        ?>    
            <div id="client_time_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>"></div>
            time left: <div id="time_left_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>"></div>
        
        
        <script type="text/javascript">
        $(document).ready(function()
                   
        var countDownDate = new Date($("#timezone_date_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>").text()).getTime();
        
        // Get todays date and time
        var now = new Date().getTime();
            
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        var totalminutesleft=(hours * 60) + minutes;

        $("#time_left_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>").text(totalminutesleft);
        });
        </script>
        <?php    
        }
        ?>
        </div>
        <div class="col-md-1">
        work time: <div id="work_time<?php echo $k;?>"><?php
        
        echo $labc=$prod->calculateProductlabc_by_orderid($b5_interior_products_with_extensions[$k]['prod_id'],$b5_interior_products_with_extensions[$k]['o_id']);
        ?>
            </div>
        </div>
        <div class="col-md-1">
        <?php
        for($j=0;$j<count($found_uca_id);$j++)
        {
        ?>
        difference: 
        <div id="difference_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>" class="difference_<?php echo $k;?>"></div>
        <script type="text/javascript">
        $(document).ready(function(){

        var fulldate = new Date();
        var year = fulldate.getFullYear();
        var month = fulldate.getMonth();
        var day = fulldate.getDay();  
        
        var fulldate=year+"-"+month+"-"+day;
        var time_left = new Date(fulldate+" "+ $("#time_left_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>").text()).getTime();
        
        // Get todays date and time
        var now = new Date(fulldate+" 00:<?php echo $labc;?>").getTime();
            
        // Find the distance between now and the count down date
        var distance = time_left - now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        var totaldifference=$("#time_left_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>").text()-$('#work_time<?php echo $k;?>').text();

        $("#difference_<?php echo $k;?>_<?php echo $j;?>_<?php echo $found_uca_id[$j];?>").text(totaldifference);
        });
        </script>
        <?php
        }
        ?>
        Chosen creator: <div id="chosen_creator<?php echo $k;?>"></div>
        
        </div> */ ?>
    </div>
    <?php        
    }
}

//end b5_interior_products_with_extensions

$b7_interior_products_with_extensions=$prod->get_b7_interior_products_with_extensions($o_id);

if(count($b7_interior_products_with_extensions)>0)
{
    //include('b7_interior_products.php');
}

$b5_exterior_products_with_extensions=$prod->get_b5_exterior_products_with_extensions($o_id);

if(count($b5_exterior_products_with_extensions)>0)
{
    // include('b5_exterior_products.php');
}

$b7_exterior_products_with_extensions=$prod->get_b7_exterior_products_with_extensions($o_id);

if(count($b7_exterior_products_with_extensions)>0)
{
    // include('b7_exterior_products.php');
}

} //isset o_id
?>


</div> <!-- end container -->
<script type="text/javascript">
        var difference_array=new Array();
        //console.log("<?php echo $k;?>");
        // console.log($(".difference_<?php echo $k;?>").children());

        var lista=$('body').find('div.difference_0');
         console.log(lista[0]);

        // for(d=0;d<$(".difference_<?php echo $k;?>").length;d++)
        // {

        //     difference_array[d]=parseInt($(".difference_<?php echo $k;?>").text());
        //     //console.log($(".difference_<?php echo $k;?>").text());
        // }
        lista.each(function(){
            
            console.log($(this).text());
        })
       // $('#chosen_creator<?php echo $k;?>').text(Math.max(difference_array));
        </script>
<script type="text/javascript">
// var currentTime = new Date().getTime();

// var difference = currentTime ;

// console.log(difference);
</script>
<?php
include('../footer.php');
?>