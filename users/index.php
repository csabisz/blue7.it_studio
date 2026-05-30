<?php
//session_set_cookie_params(14400,"/");
session_start();
include('../functions.php');
$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");
$page_title="APEs";
include('../header2.php');

include('../menu.php');

?>
<section class="top_section">
	<article>
	<div class="container-fluid">
	<?php
	if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
	{
        if ($_COOKIE['useradmin'] > 0)
        {
	?>		
    <br>
    <div class="text-center" style="font-size:18px"><a href="index.php?page=users" <?php if((isset($_GET['page']))&&($_GET['page']=="users")) { ?> style="text-decoration:underline;font-weight:bold;" <?php } ?>>APEs: Creators</a> | <a href="index.php?page=traders&calc_method=new" <?php if((isset($_GET['page']))&&($_GET['page']=="traders")) { ?> style="text-decoration:underline;font-weight:bold;" <?php } ?>>APEs: Traders</a>
    </div>
	<br>
		<?php		
		if(isset($_GET['page']))
		{
			$page=$prod->xss_fix($_GET['page']);
            $calc_method=$prod->xss_fix($_GET['calc_method']);
            
			if($page=="users")
			{
				$creators=$prod->show_creators($_COOKIE['lt_id']);
                $other_creators=$prod->show_creators_other_companies($_COOKIE['lt_id']);

				if(isset($_GET['selected_user']))
				{
					$selected_user=$prod->xss_fix($_GET['selected_user']);
                }
                
                if(isset($_GET['selected_producer']))
				{
					$selected_producer=$prod->xss_fix($_GET['selected_producer']);
                }

                $licences=$prod->get_licence_ids();
                
                $uprod_ids="";

                for($p=0;$p<count($licences);$p++)
                {
                    if(!empty($licences[$p]['uprod_id']))
                    {
                        $uprod_id.=$licences[$p]['uprod_id'];
                    }
                }

                $all_producers2=explode(";",$uprod_id);
                
                $all_producers=array_values(array_unique($all_producers2));

				?>  
				<div class="row mx-0 w-100 text-center">
                    <div class="col-md-6">
                        <a href="index.php?page=users&selected_producer=<?php echo (isset($_GET['selected_producer']))?$prod->xss_fix($_GET['selected_producer']):"3";?>&selected_user=<?php echo (isset($_GET['selected_user']))?$prod->xss_fix($_GET['selected_user']):"all_creators";?>&users_start_date=<?php echo date("Y-m-01", strtotime($prod->xss_fix($_GET['users_start_date'])." -1 month" ));?>&users_end_date=<?php 
                        $last_month=date("Y-m-d", strtotime($prod->xss_fix($_GET['users_start_date'])." -1 month" ));
                        $d = new DateTime($last_month); 
                        echo $d->format( 'Y-m-t' );     
                        ?>&show_btn=">< Previous month</a>
                    </div>
                    <div class="col-md-6">
                        <a href="index.php?page=users&selected_producer=<?php echo (isset($_GET['selected_producer']))?$prod->xss_fix($_GET['selected_producer']):"3";?>&selected_user=<?php echo (isset($_GET['selected_user']))?$prod->xss_fix($_GET['selected_user']):"all_creators";?>&users_start_date=<?php 
                        echo date("Y-m-01", strtotime($prod->xss_fix($_GET['users_start_date'])." +1 month" ));
                        ?>&users_end_date=<?php 
                        $next_month=date("Y-m-d", strtotime($prod->xss_fix($_GET['users_end_date'])." +1 month" ));
                        $d = new DateTime($next_month); 
                        echo $d->format( 'Y-m-t' ); 
                        ?>&show_btn=">Next month ></a>
                    </div>
                </div>
					<div class="row mx-0 w-100">
                        <div class="col-md-3 border p-4 bg-white">
                            <form class="p-2" name="show_users" class="text-left" action="index.php?page=users" method="get">
                            <input type="hidden" name="page" value="users">
                            <p class="mb-0 text-left">
                                Select producer:
                            </p>
                            <select id="selected_producer" name="selected_producer" class="form-control form-control-sm mb-3">
                                <!--<option value="">--Choose--</option> -->
                                <?php
                                for($i=0;$i<count($all_producers);$i++)
                                {
                                    if(!empty($all_producers[$i]))
                                    {
                                    $producer=$prod->get_company($all_producers[$i]);
                                ?>	
                                    <option value="<?php echo $producer['lt_id'];?>" <?php echo ($producer['lt_id']==$selected_producer)?"selected":""; ?>><?php echo $producer['mailnick']?></option>
                                <?php
                                    }	
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                            $(document).ready(function(){
                                $("#selected_producer").change(function(){
                                $.ajax({
                                    url: "../ajax/users_get_creators_from_lt_id.php",
                                    method: "get",
                                    data: {lt_id:$("#selected_producer option:selected").val()},
                                    dataType:"html",
                                    success:function(data) {
                                        //console.log(data);
                                        $("#selected_user").html(data);
                                    }
                                    });
                                });
                            });
                            </script>
                            <p class="mb-0 text-left">Select user:</p> 
                            <select id="selected_user" name="selected_user" class="form-control form-control-sm mb-3" required>
                                <!--<option value="">--Choose--</option> -->
                                <option value="all_creators" <?php echo ("all_creators"==$selected_user)?"selected":""; ?>>--All creators--</option>
                                <?php 
                                for($i=0;$i<count($creators);$i++)
                                {
                                    $licence_taker=$prod->get_company($creators[$i]['lt_id']);
                                ?>
                                <option value="<?php echo $creators[$i]['client_ID']; ?>" <?php echo ($creators[$i]['client_ID']==$selected_user)?"selected":""; ?>><?php 
                                if(!empty($creators[$i]['c_last_name']))
                                {
                                    echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name']." - ".$licence_taker['mailnick'];
                                }
                                else
                                {
                                    echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name']." - ".$licence_taker['mailnick'];
                                } ?></option>
                                <?php
                                }
                                ?>
                                <option value="" style="color:red;">Resources from other companies</option>
                                <?php
                                for($i=0;$i<count($other_creators);$i++)
                                {
                                    $licence_taker=$prod->get_company($other_creators[$i]['lt_id']);
                                ?>
                                <option value="<?php echo $other_creators[$i]['client_ID']; ?>" <?php echo ($other_creators[$i]['client_ID']==$selected_user)?"selected":""; ?>><?php 
                                if(!empty($other_creators[$i]['c_last_name']))
                                {
                                    echo $other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name']." - ".$licence_taker['mailnick'];
                                }
                                else
                                {
                                    echo $other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name']." - ".$licence_taker['mailnick'];
                                } ?></option>
                                <?php
                                }
                                ?>
                            </select>
							<p class="mb-0 text-left">Start date:</p>	
                            <input class="form-control form-control-sm mb-3" id="users_start_date" name="users_start_date" type="text" value="<?php echo (isset($_GET['users_start_date']))?($_GET['users_start_date']):date("Y-m-01"); ?>" autocomplete="off" required>
							<p class="mb-0 text-left">End date:</p>	
							 <input class="form-control form-control-sm mb-3" id="users_end_date" name="users_end_date" type="text" value="<?php echo (isset($_GET['users_end_date']))?($_GET['users_end_date']):date("Y-m-t"); ?>" autocomplete="off" required>
                            <button id="show_btn" name="show_btn" class="btn btn-primary btn-sm float-right px-4 btn-block mb-3">Show</button>
                        </form>
                    <?php
                    if(isset($_GET['show_btn']))
                    {
                    ?>
                        <b>Total labc = <span id="total_labc"></span></b> <b> -- Total APEs = <span id="total_apus"></span></b>
                        <br><br>
                        <div style="border: black 3px solid;"></div>
                        <br>
                        <?php
                        if($selected_user=="all_creators")
                        {
                        ?>
                        <div style="display:inline-flex;">List of work &nbsp;<a href="pdf/all_creators_labcs_apus<?php
                        $start_d = new DateTime($_GET['users_start_date']);
                        $start_d->modify( 'first day of - 1 month' );
                        echo $start_d->format( 'Y-m-d' );

                        echo "_";
                        $end_d = new DateTime($_GET['users_end_date']);
                        $end_d->modify( 'last day of - 1 month' );
                        echo $end_d->format( 'Y-m-d' );

                        echo ".pdf";
                        //echo date('Y-m-01', strtotime($_GET['users_start_date']." - 1 month"))."_".date("Y-m-t",strtotime($_GET['users_end_date']." - 1 month")).".pdf";
                        ?>" target="_blank" class="btn btn-sm btn-primary">labcs/APEs generated on <?php echo date('Y-m-01', strtotime($_GET['users_start_date']));?></a></div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div style="display:inline-flex;">List of work &nbsp;<a href="apus_creators.pdf" target="_blank" class="btn btn-sm btn-primary">View pdf for list of work</a></div>
                        <?php
                        }
                        ?>
                        <br><br>
                    <?php
                    }
                    ?>
                        </div>
                    

            
                        <?php
				if(isset($_GET['show_btn']))
				{
					$selected_user=$prod->xss_fix($_GET['selected_user']);
					$users_start_date=$prod->xss_fix($_GET['users_start_date']);
					$users_end_date=$prod->xss_fix($_GET['users_end_date']);
                    $selected_producer=$prod->xss_fix($_GET['selected_producer']);
                    
					if($selected_user!="all_creators")
				    {
                        include("single_creator_labcs.php");
                    }
                    else
                    {
                        include("all_creators_labcs.php");
                    }
				}
                ?>
                
			    <?php	
				
			} //page users
			
			if($page=="traders")
			{
                ?>
                <div class="row">
                    
                    <div class="col-md-6 text-right">
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?<?php 
                    if(!empty($page))
                    {
                        echo "&page=".$page;
                    }
                    echo "&calc_method=new";?>" <?php
                    if($calc_method=="new")
                    {
                    ?>
                    style="text-decoration:underline;font-weight:bold;"<?php
                    } ?>>New calculations (after single tasks)</a>
                    </div>
                    <div class="col-md-6 text-right">
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?<?php 
                    if(!empty($page))
                    {
                        echo "&page=".$page;
                    }
                    echo "&calc_method=old";
                    ?>" <?php
                    if($calc_method=="old")
                    {
                    ?>
                    style="text-decoration:underline;font-weight:bold;"<?php 
                    } ?>>Old calculations (after main producer)</a>
                    </div>
                </div>
                <?php

                if($calc_method=="old")
                {

                    $traders=$prod->show_all_licence_takers();	
                    $licences=$prod->get_licence_ids();
                    
                    $uprod_ids="";

                    for($p=0;$p<count($licences);$p++)
                    {
                        if(!empty($licences[$p]['uprod_id']))
                        {
                            $uprod_id.=$licences[$p]['uprod_id'];
                        }
                    }

                    $all_producers2=explode(";",$uprod_id);
                    
                    $all_producers=array_values(array_unique($all_producers2));

                    //print_r($all_producers);

                    if(isset($_POST['selected_trader']))
                    {
                        $selected_trader=$_POST['selected_trader'];
                    }
                    if(isset($_POST['selected_producer']))
                    {
                        $selected_producer=$_POST['selected_producer'];
                    }
                    ?>				
               
					<div class="row mx-0 w-100">
                        <div class="col-md-3 border bg-white py-4">
                            <form class="p-3" name="show_traders" action="index.php?page=traders&calc_method=old" method="post">
                            <p class="mb-0 text-left">
                                Select trader: 
                            </p>
                            <select name="selected_trader" class="form-control form-control-sm mb-3">
                                <option value="">--Choose--</option>
                                <?php 
                                for($i=0;$i<count($traders);$i++)
                                {
                                    $all_licences=$prod->get_licences($traders[$i]['lt_id']);

                                if(!empty($all_licences))
                                {
                                ?>
                                <option value="<?php echo $traders[$i]['lt_id']; ?>" <?php echo ($traders[$i]['lt_id']==$selected_trader)?"selected":""; ?>><?php 
                                
                                    echo $traders[$i]['mailnick']." - "; 
                                    
                                    for($l=0;$l<count($all_licences);$l++)
                                    {
                                        echo $all_licences[$l]['lic_id'].";";
                                    }?></option>
                                <?php
                                }
                                }
                                ?>
                            </select>
                            <p class="mb-0 text-left">
                                Select producer:
                            </p>
                            <select name="selected_producer" class="form-control form-control-sm mb-3">
                                <option>--Choose--</option>
                                <?php
                                for($i=0;$i<count($all_producers);$i++)
                                {
                                    if(!empty($all_producers[$i]))
                                    {
                                    $producer=$prod->get_company($all_producers[$i]);
                                ?>	
                                    <option value="<?php echo $producer['lt_id'];?>" <?php echo ($producer['lt_id']==$selected_producer)?"selected":""; ?>><?php echo $producer['mailnick']?></option>
                                <?php
                                    }	
                                }
                                ?>
                            </select>
							<p class="mb-0 text-left">Start date:</p>
                            <input class="form-control form-control-sm mb-3" id="traders_start_date" name="traders_start_date" type="text" value="<?php echo (isset($_POST['traders_start_date']))?($_POST['traders_start_date']):date("Y-m-01"); ?>" autocomplete="off">
                             <p class="text-left mb-0">End date:</p>
							 <input class="form-control form-control-sm mb-3" id="traders_end_date" name="traders_end_date" type="text" value="<?php echo (isset($_POST['traders_end_date']))?($_POST['traders_end_date']):date("Y-m-t"); ?>" autocomplete="off">
                            <button name="show_btn" class="btn btn-primary btn-sm float-right px-4 btn-block mb-3">Show</button>
                        </form>
                        <?php
                        if(isset($_POST['show_btn']))
                        {
                        ?>
                        <br>
                        <div style="border: black 3px solid; "></div>
                        <br>
                
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <b>Total APEs = <span id="total_apus"></span></b>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div style="display:inline-flex;">List of work &nbsp;<a href="apus_traders.pdf" target="_blank" class="btn btn-sm btn-primary">View pdf for list of work</a></div>
                            </div>
                        </div>
                        <br>
                        <?php
                        }
                        ?>
                        </div>
                        <?php
                    if(isset($_POST['show_btn']))
                    {
                        $selected_trader=$_POST['selected_trader'];
                        $selected_producer=$_POST['selected_producer'];
                        $traders_start_date=$_POST['traders_start_date'];
                        $traders_end_date=$_POST['traders_end_date'];
                        
                        $trader=$prod->get_company($selected_trader);
                        $producer=$prod->get_company($selected_producer);
                        $orders=$prod->get_trader_producer_orders_by_date($trader['lt_id'],$producer['lt_id'],$traders_start_date,$traders_end_date); 
                        
                        $total_apus_with_fac_prod=array();    

                        for($i=0;$i<count($orders);$i++)
                        {	
                            $products=$prod->get_o_prods_by_order_id($orders[$i]['order_ID']);
                            
                                    
                            for($p=0;$p<count($products);$p++)
                            {
                                if((substr($products[$p]['prod_id'],1)>1300)&&(substr($products[$p]['prod_id'],1)<1360))
                                {
                                    $o_desc_in_b3=$prod->get_o_desc_in_b3($products[$p]['o_id']);
                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1301")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2);
                                        }     
                                    }
                                    elseif($products[$p]['prod_id']=="p1302")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2);     
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1321")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);   
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1322")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2);     
                                        }
                                    }
                                    else
                                    { 
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }

                                if((substr($products[$p]['prod_id'],1)>1499)&&(substr($products[$p]['prod_id'],1)<1560))
                                {
                                    $o_desc_in_b5=$prod->get_o_desc_in_b5($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1501")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2);     
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1504")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2);     
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1521")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);   
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1524")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);   
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1541")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2);   
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1544")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2);     
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1506")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);        
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1526")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);   
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1546")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);            
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $thisproductAPU,1,2);                        
                                        }
                                    }
                                    
                                }

                                if((substr($products[$p]['prod_id'],1)>1599)&&(substr($products[$p]['prod_id'],1)<1660))
                                {
                                    $o_desc_in_b6=$prod->get_o_desc_in_b6($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1600")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2);
                                        }
                                    
                                    }
                                    elseif($products[$p]['prod_id']=="p1601")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2);
                                        }
                                    
                                    }
                                    elseif($products[$p]['prod_id']=="p1604")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2);
                                        }
                                    
                                    }
                                    elseif($products[$p]['prod_id']=="p1621")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);
                                        }
                                    
                                    }
                                    elseif($products[$p]['prod_id']=="p1624")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1641")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2);                
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1644")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2);                
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1606")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1626")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);                         
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1646")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2); 
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $thisproductAPU,1,2);                      
                                        }
                                    }
                                    
                                }

                                if((substr($products[$p]['prod_id'],1)>1699)&&(substr($products[$p]['prod_id'],1)<1760))
                                {
                                    $o_desc_in_b7=$prod->get_o_desc_in_b7($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1700")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2);                                
                                        }
                                    }
                                    if($products[$p]['prod_id']=="p1701")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2);                                
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1704")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2);                                
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1721")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1724")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1741")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2);  
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1744")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2);  
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1706")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1726")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1746")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);      
                                        }
                                    }
                                    else
                                    {           
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    
                                }

                                if((substr($products[$p]['prod_id'],1)>1799)&&(substr($products[$p]['prod_id'],1)<1860))
                                {
                                    $o_desc_in_b8=$prod->get_o_desc_in_b8($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1800")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2);                                
                                        }
                                    }
                                    if($products[$p]['prod_id']=="p1801")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2);                                
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1804")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2);                                
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1821")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1824")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1841")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2);  
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1844")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2);  
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1806")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1826")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1846")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);      
                                        }
                                    }
                                    else
                                    {           
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $thisproductAPU,1,2);
                                    }
                                    
                                }

                                if(((substr($products[$p]['prod_id'],1)>1560)&&(substr($products[$p]['prod_id'],1)<1590))||($products[$p]['prod_id']=="p156x")||($products[$p]['prod_id']=="p156z"))
                                {
                                    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);
                                    
                                    if($products[$p]['prod_id']=="p1561")
                                    {            
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {   
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);                               
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1563")
                                    {    
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {           
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);                               
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1566")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);                           
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);                           
                                        }
                                    }
                                }

                                if(((substr($products[$p]['prod_id'],1)>1659)&&(substr($products[$p]['prod_id'],1)<1699))||($products[$p]['prod_id']=="p166x")||($products[$p]['prod_id']=="p166z")||($products[$p]['prod_id']=="p166p"))
                                {
                                    $o_desc_ex_b6=$prod->get_o_desc_ex_b6($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1661")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);                     
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1663")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);                     
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1666")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p166p")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);                          
                                        }
                                    }
                                }

                                if(((substr($products[$p]['prod_id'],1)>1759)&&(substr($products[$p]['prod_id'],1)<1799))||($products[$p]['prod_id']=="p176x")||($products[$p]['prod_id']=="p176z"))
                                {
                                    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1761")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);                            
                                        }
                                    }
                                    if($products[$p]['prod_id']=="p1763")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);                            
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1766")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);                       
                                        }
                                    }
                                    else
                                    {       
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {         
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);                          
                                        }
                                    }
                                }

                                if(((substr($products[$p]['prod_id'],1)>1859)&&(substr($products[$p]['prod_id'],1)<1899))||($products[$p]['prod_id']=="p186x")||($products[$p]['prod_id']=="p186z"))
                                {
                                    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);
                                    
                                    if($products[$p]['prod_id']=="p1861")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1863")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);                    
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1866")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);                     
                                        }
                                    }
                                    else
                                    {             
                                        if($products[$p]['om_correction']==1)
                                        {
                                            $total_apus_with_fac_prod[]=0;
                                        }   
                                        else
                                        {         
                                        $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);              
                                        }
                                    }
                                }
                            }
                        }
                            $html = "<html>";
                            $html .= "<body>";
                            $html .= "<h2 style=\"text-align:center;\">List of work</h2>";
                            $html .= "For ".$trader['Company']." done by ".$producer['Company']." between ".$traders_start_date." and ".$traders_end_date." - amount ".array_sum($total_apus_with_fac_prod)." APUs";
                            $html .= "<br><br>";
                            ?>
                        
                            <?php 
                        
                            $tot_apus=array_sum($total_apus_with_fac_prod);
                            //$tot_labc=0;
                            //$tot_capc=0;
                            //print_r($total_apus);
                            
                            ?>
                            <br>
                        
                            <input type="hidden" name="tot_apus" id="tot_apus" value="<?php echo $tot_apus;?>">
                            <div class="col-md-9">
                                <div style="overflow-y:scroll;height:650px;">
                                    <table style="border:1px solid #000;">
                                        <tr style="border: 1px solid #000;">
                                            <th style="border: 1px solid #000;">Order date</th>
                                            <th style="border: 1px solid #000;">Products</th>
                                            <th style="border: 1px solid #000;">Multiplicator</th>
                                            <th style="border: 1px solid #000;">Basic APEs</th>
                                            <th style="border: 1px solid #000;">Difficulty factor</th>
                                            <th style="border: 1px solid #000;">Total APEs</th>
                                            <th style="border: 1px solid #000;">&nbsp;</th>
                                            <th style="border: 1px solid #000;">Project name</th>
                                        </tr>
                        <?php
                        $html .="<table style=\"border:1px solid #000;\">";
                        $html .="<tr style=\"border: 1px solid #000;\">";
                        $html .="<th style=\"border: 1px solid #000;\">Order date</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Products</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Multiplicator</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Basic APEs</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Difficulty factor</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Total APEs</th>";
                        $html .="<th style=\"border: 1px solid #000;\">&nbsp;</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Project name</th>";
                        $html .="</tr>";

                        
                            for($i=0;$i<count($orders);$i++)
                            {	
                                $products=$prod->get_o_prods_by_order_id($orders[$i]['order_ID']);

                                for($p=0;$p<count($products);$p++)
                                {
                            ?>
                            <tr <?php
                            if($p==0)
                            {
                            ?>
                            style="border-top: 1px solid #000;border-left: 1px solid #000;"<?php
                            }?>>

                            <?php
                            $html .="<tr ";
                            if($p==0)
                            { 
                            $html .="style=\"border-top: 1px solid #000;border-left: 1px solid #000;\"";
                            }
                            $html .=">";
                            ?>
                                <td <?php
                                if($p==0)
                                {
                                ?>
                                style="border-top: 1px solid #000;"
                                <?php
                                }
                                ?>>

                                <?php
                                $html .="<td ";
                                if($p==0)
                                {
                                $html .="style=\"border-top: 1px solid #000;\"";
                                }
                                $html .=">";

                                
                                if($p==0)
                                {
                                $date_without_time=explode(" ",$orders[$i]['o_date']);
                                echo $date_without_time[0];
                                $html .= $date_without_time[0];
                                }
                                ?>
                                </td>
                                <td style="border: 1px solid #000;">
                                <?php
                                $html .="</td>";
                                $html .="<td style=\"border: 1px solid #000;\">";

                                $products=$prod->get_o_prods_by_order_id($orders[$i]['order_ID']);
                                
                                echo $products[$p]['o_id'].".".$products[$p]['osub_id'].".".$products[$p]['prod_id'];
                                $html .= $products[$p]['o_id'].".".$products[$p]['osub_id'].".".$products[$p]['prod_id'];
                                ?>
                                </td>
                                <td style="border: 1px solid #000;text-align:center;">
                                    <?php
                                $html .="</td>";
                                $html .="<td style=\"border: 1px solid #000;text-align:center;\">";
                            
                                if((substr($products[$p]['prod_id'],1)>1300)&&(substr($products[$p]['prod_id'],1)<1360))
                                {
                                    $o_desc_in_b3=$prod->get_o_desc_in_b3($products[$p]['o_id']);

                                    if($products[$p]['prod_id']=="p1301")
                                    {
                                        echo $o_desc_in_b3['p1301_fac'];
                                        $html .= $o_desc_in_b3['p1301_fac'];
                                    }
                                    elseif($products[$p]['prod_id']=="p1302")
                                    {
                                        echo $o_desc_in_b3['p1302_fac'];
                                        $html .= $o_desc_in_b3['p1302_fac'];
                                    }
                                    elseif($products[$p]['prod_id']=="p1321")
                                    {
                                        echo $o_desc_in_b3['p1321_fac'];
                                        $html .= $o_desc_in_b3['p1321_fac'];
                                    }
                                    elseif($products[$p]['prod_id']=="p1322")
                                    {
                                        echo $o_desc_in_b3['p1322_fac'];
                                        $html .= $o_desc_in_b3['p1322_fac'];
                                    }
                                    else
                                    {
                                        //echo "1";
                                    }         
                                }
                                
                                    if((substr($products[$p]['prod_id'],1)>1499)&&(substr($products[$p]['prod_id'],1)<1560))
                                    {
                                        $o_desc_in_b5=$prod->get_o_desc_in_b5($products[$p]['o_id']);

                                        if($products[$p]['prod_id']=="p1501")
                                        {
                                            echo $o_desc_in_b5['p1501_fac'];
                                            $html .= $o_desc_in_b5['p1501_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1504")
                                        {
                                            echo $o_desc_in_b5['p1504_fac'];
                                            $html .= $o_desc_in_b5['p1504_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1521")
                                        {
                                            echo $o_desc_in_b5['p1521_fac'];
                                            $html .= $o_desc_in_b5['p1521_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1524")
                                        {
                                            echo $o_desc_in_b5['p1524_fac'];
                                            $html .= $o_desc_in_b5['p1524_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1541")
                                        {
                                            echo $o_desc_in_b5['p1541_fac'];
                                            $html .= $o_desc_in_b5['p1541_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1544")
                                        {
                                            echo $o_desc_in_b5['p1544_fac'];
                                            $html .= $o_desc_in_b5['p1544_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1506")
                                        {
                                            echo $o_desc_in_b5['p1506_fac'];
                                            $html .= $o_desc_in_b5['p1506_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1526")
                                        {
                                            echo $o_desc_in_b5['p1526_fac'];
                                            $html .= $o_desc_in_b5['p1526_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1546")
                                        {
                                            echo $o_desc_in_b5['p1546_fac'];
                                            $html .= $o_desc_in_b5['p1546_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }         
                                    }

                                    if((substr($products[$p]['prod_id'],1)>1599)&&(substr($products[$p]['prod_id'],1)<1660))
                                    {
                                        $o_desc_in_b6=$prod->get_o_desc_in_b6($products[$p]['o_id']);

                                        if($products[$p]['prod_id']=="p1600")
                                        {
                                            echo $o_desc_in_b6['p1600_fac'];
                                            $html .= $o_desc_in_b6['p1600_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1601")
                                        {
                                            echo $o_desc_in_b6['p1601_fac'];
                                            $html .= $o_desc_in_b6['p1601_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1604")
                                        {
                                            echo $o_desc_in_b6['p1604_fac'];
                                            $html .= $o_desc_in_b6['p1604_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1621")
                                        {
                                            echo $o_desc_in_b6['p1621_fac'];
                                            $html .= $o_desc_in_b6['p1621_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1624")
                                        {
                                            echo $o_desc_in_b6['p1624_fac'];
                                            $html .= $o_desc_in_b6['p1624_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1641")
                                        {
                                            echo $o_desc_in_b6['p1641_fac'];
                                            $html .= $o_desc_in_b6['p1641_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1644")
                                        {
                                            echo $o_desc_in_b6['p1644_fac'];
                                            $html .= $o_desc_in_b6['p1644_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1606")
                                        {
                                            echo $o_desc_in_b6['p1606_fac'];
                                            $html .= $o_desc_in_b6['p1606_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1626")
                                        {
                                            echo $o_desc_in_b6['p1626_fac'];
                                            $html .= $o_desc_in_b6['p1626_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1646")
                                        {
                                            echo $o_desc_in_b6['p1646_fac'];
                                            $html .= $o_desc_in_b6['p1646_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }  
                                    }

                                    if((substr($products[$p]['prod_id'],1)>1699)&&(substr($products[$p]['prod_id'],1)<1760))
                                    {
                                        $o_desc_in_b7=$prod->get_o_desc_in_b7($products[$p]['o_id']);

                                        if($products[$p]['prod_id']=="p1700")
                                        {
                                            echo $o_desc_in_b7['p1700_fac'];
                                            $html .= $o_desc_in_b7['p1700_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1701")
                                        {
                                            echo $o_desc_in_b7['p1701_fac'];
                                            $html .= $o_desc_in_b7['p1701_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1704")
                                        {
                                            echo $o_desc_in_b7['p1704_fac'];
                                            $html .= $o_desc_in_b7['p1704_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1721")
                                        {
                                            echo $o_desc_in_b7['p1721_fac'];
                                            $html .= $o_desc_in_b7['p1721_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1724")
                                        {
                                            echo $o_desc_in_b7['p1724_fac'];
                                            $html .= $o_desc_in_b7['p1724_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1741")
                                        {
                                            echo $o_desc_in_b7['p1741_fac'];
                                            $html .= $o_desc_in_b7['p1741_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1744")
                                        {
                                            echo $o_desc_in_b7['p1744_fac'];
                                            $html .= $o_desc_in_b7['p1744_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1706")
                                        {
                                            echo $o_desc_in_b7['p1706_fac'];
                                            $html .= $o_desc_in_b7['p1706_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1726")
                                        {
                                            echo $o_desc_in_b7['p1726_fac'];
                                            $html .= $o_desc_in_b7['p1726_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1746")
                                        {
                                            echo $o_desc_in_b7['p1746_fac'];
                                            $html .= $o_desc_in_b7['p1746_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }   
                                    }

                                    if((substr($products[$p]['prod_id'],1)>1799)&&(substr($products[$p]['prod_id'],1)<1860))
                                    {
                                        $o_desc_in_b8=$prod->get_o_desc_in_b8($products[$p]['o_id']);

                                        if($products[$p]['prod_id']=="p1800")
                                        {
                                            echo $o_desc_in_b8['p1800_fac'];
                                            $html .= $o_desc_in_b8['p1800_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1801")
                                        {
                                            echo $o_desc_in_b8['p1801_fac'];
                                            $html .= $o_desc_in_b8['p1801_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1804")
                                        {
                                            echo $o_desc_in_b8['p1804_fac'];
                                            $html .= $o_desc_in_b8['p1804_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1821")
                                        {
                                            echo $o_desc_in_b8['p1821_fac'];
                                            $html .= $o_desc_in_b8['p1821_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1824")
                                        {
                                            echo $o_desc_in_b8['p1824_fac'];
                                            $html .= $o_desc_in_b8['p1824_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1841")
                                        {
                                            echo $o_desc_in_b8['p1841_fac'];
                                            $html .= $o_desc_in_b8['p1841_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1844")
                                        {
                                            echo $o_desc_in_b8['p1844_fac'];
                                            $html .= $o_desc_in_b8['p1844_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1806")
                                        {
                                            echo $o_desc_in_b8['p1806_fac'];
                                            $html .= $o_desc_in_b8['p1806_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1826")
                                        {
                                            echo $o_desc_in_b8['p1826_fac'];
                                            $html .= $o_desc_in_b8['p1826_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1846")
                                        {
                                            echo $o_desc_in_b8['p1846_fac'];
                                            $html .= $o_desc_in_b8['p1846_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }   
                                    }

                                    if(((substr($products[$p]['prod_id'],1)>1560)&&(substr($products[$p]['prod_id'],1)<1590))||($products[$p]['prod_id']=="p156x")||($products[$p]['prod_id']=="p156z"))
                                    {
                                        $o_desc_ex_b5=$prod->get_o_desc_ex_b5($products[$p]['o_id']);

                                        if($products[$p]['prod_id']=="p1561")
                                        {
                                            echo $o_desc_ex_b5['p1561_fac'];
                                            $html .= $o_desc_ex_b5['p1561_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1563")
                                        {
                                            echo $o_desc_ex_b5['p1563_fac'];
                                            $html .= $o_desc_ex_b5['p1563_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1566")
                                        {
                                            echo $o_desc_ex_b5['p1566_fac'];
                                            $html .= $o_desc_ex_b5['p1566_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }
                                    }

                                    if(((substr($products[$p]['prod_id'],1)>1659)&&(substr($products[$p]['prod_id'],1)<1699))||($products[$p]['prod_id']=="p166x")||($products[$p]['prod_id']=="p166z")||($products[$p]['prod_id']=="p166p"))
                                    {
                                        $o_desc_ex_b6=$prod->get_o_desc_ex_b6($products[$p]['o_id']);

                                        if($products[$p]['prod_id']=="p1661")
                                        {
                                            echo $o_desc_ex_b6['p1661_fac'];
                                            $html .= $o_desc_ex_b6['p1661_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1663")
                                        {
                                            echo $o_desc_ex_b6['p1663_fac'];
                                            $html .= $o_desc_ex_b6['p1663_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1666")
                                        {
                                            echo $o_desc_ex_b6['p1666_fac'];
                                            $html .= $o_desc_ex_b6['p1666_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p166p")
                                        {
                                            echo $o_desc_ex_b6['p166p_fac'];
                                            $html .= $o_desc_ex_b6['p166p_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }
                                    }

                                    if(((substr($products[$p]['prod_id'],1)>1759)&&(substr($products[$p]['prod_id'],1)<1799))||($products[$p]['prod_id']=="p176x")||($products[$p]['prod_id']=="176z"))
                                    {
                                        $o_desc_ex_b7=$prod->get_o_desc_ex_b7($products[$p]['o_id']);

                                        if($products[$p]['prod_id']=="p1761")
                                        {
                                            echo $o_desc_ex_b7['p1761_fac'];
                                            $html .= $o_desc_ex_b7['p1761_fac'];
                                        }
                                        if($products[$p]['prod_id']=="p1763")
                                        {
                                            echo $o_desc_ex_b7['p1763_fac'];
                                            $html .= $o_desc_ex_b7['p1763_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1766")
                                        {
                                            echo $o_desc_ex_b7['p1766_fac'];
                                            $html .= $o_desc_ex_b7['p1766_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }
                                    }

                                    if(((substr($products[$p]['prod_id'],1)>1859)&&(substr($products[$p]['prod_id'],1)<1899))||($products[$p]['prod_id']=="p186x")||($products[$p]['prod_id']=="p186z"))
                                    {
                                        $o_desc_ex_b8=$prod->get_o_desc_ex_b8($products[$p]['o_id']);
                                        
                                        if($products[$p]['prod_id']=="p1861")
                                        {
                                            echo $o_desc_ex_b8['p1861_fac'];
                                            $html .= $o_desc_ex_b8['p1861_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1863")
                                        {
                                            echo $o_desc_ex_b8['p1863_fac'];
                                            $html .= $o_desc_ex_b8['p1863_fac'];
                                        }
                                        elseif($products[$p]['prod_id']=="p1866")
                                        {
                                            echo $o_desc_ex_b8['p1866_fac'];
                                            $html .= $o_desc_ex_b8['p1866_fac'];
                                        }
                                        else
                                        {
                                            //echo "1";
                                        }
                                    }
                                    ?>
                                </td>
                                <td style="border: 1px solid #000;">
                                    <?php
                                $html .="</td>";
                                $html .="<td style=\"border: 1px solid #000;\">";

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);
            
                                    echo $thisproductAPU;
                                    $html .= $thisproductAPU;      
                                    ?>
                                </td>
                                <td style="border: 1px solid #000;text-align:center;">
                                    <?php
                                    $html .="</td>";
                                    $html .="<td style=\"border: 1px solid #000;text-align:center;\">";

                                    if((substr($products[$p]['prod_id'],1)>1300)&&(substr($products[$p]['prod_id'],1)<1360))
                                    {
                                        $o_desc_in_b3=$prod->get_o_desc_in_b3($products[$p]['o_id']);      
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {                                 
                                            echo $o_desc_in_b3['fac_prod_in_b3'];
                                            $html .= $o_desc_in_b3['fac_prod_in_b3'];
                                        }
                                    }
                                    if((substr($products[$p]['prod_id'],1)>1499)&&(substr($products[$p]['prod_id'],1)<1560))
                                    {
                                        $o_desc_in_b5=$prod->get_o_desc_in_b5($products[$p]['o_id']);
        
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_in_b5['fac_prod_in_b5'];
                                        $html .= $o_desc_in_b5['fac_prod_in_b5'];
                                        }
                                    }

                                    if((substr($products[$p]['prod_id'],1)>1599)&&(substr($products[$p]['prod_id'],1)<1660))
                                    {
                                        $o_desc_in_b6=$prod->get_o_desc_in_b6($products[$p]['o_id']);

                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_in_b6['fac_prod_in_b6'];   
                                        $html .= $o_desc_in_b6['fac_prod_in_b6'];  
                                        }
                                    }
                                    if((substr($products[$p]['prod_id'],1)>1699)&&(substr($products[$p]['prod_id'],1)<1760))
                                    {
                                        $o_desc_in_b7=$prod->get_o_desc_in_b7($products[$p]['o_id']);

                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_in_b7['fac_prod_in_b7'];
                                        $html .= $o_desc_in_b7['fac_prod_in_b7'];
                                        }
                                    }

                                    if((substr($products[$p]['prod_id'],1)>1799)&&(substr($products[$p]['prod_id'],1)<1860))
                                    {
                                        $o_desc_in_b8=$prod->get_o_desc_in_b8($products[$p]['o_id']);

                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_in_b8['fac_prod_in_b8'];
                                        $html .= $o_desc_in_b8['fac_prod_in_b8'];
                                        }
                                    }

                                    if(((substr($products[$p]['prod_id'],1)>1560)&&(substr($products[$p]['prod_id'],1)<1590))||($products[$p]['prod_id']=="p156x")||($products[$p]['prod_id']=="p156z"))
                                    {
                                        $o_desc_ex_b5=$prod->get_o_desc_ex_b5($products[$p]['o_id']);

                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_ex_b5['fac_prod_ex_b5'];
                                        $html .= $o_desc_ex_b5['fac_prod_ex_b5'];
                                        }
                                    }

                                    if(((substr($products[$p]['prod_id'],1)>1659)&&(substr($products[$p]['prod_id'],1)<1699))||($products[$p]['prod_id']=="p166x")||($products[$p]['prod_id']=="p166z")||($products[$p]['prod_id']=="p166p"))
                                    {
                                        $o_desc_ex_b6=$prod->get_o_desc_ex_b6($products[$p]['o_id']);

                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_ex_b6['fac_prod_ex_b6'];
                                        $html .= $o_desc_ex_b6['fac_prod_ex_b6'];
                                        }
                                    }

                                    if(((substr($products[$p]['prod_id'],1)>1759)&&(substr($products[$p]['prod_id'],1)<1799))||($products[$p]['prod_id']=="p176x")||($products[$p]['prod_id']="p176z"))
                                    {
                                        $o_desc_ex_b7=$prod->get_o_desc_ex_b7($products[$p]['o_id']);

                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_ex_b7['fac_prod_ex_b7'];
                                        $html .= $o_desc_ex_b7['fac_prod_ex_b7'];
                                        }
                                    }

                                    if((substr($products[$p]['prod_id'],1)>1859)&&(substr($products[$p]['prod_id'],1)<1899))
                                    {
                                        $o_desc_ex_b8=$prod->get_o_desc_ex_b8($products[$p]['o_id']);
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo $o_desc_ex_b8['fac_prod_ex_b8'];
                                        $html .= $o_desc_ex_b8['fac_prod_ex_b8'];
                                        }
                                    }
                                    ?>
                                </td>
                                <td style="border: 1px solid #000;color:red;">
                                <?php
                                $html .="</td>";
                                $html .="<td style=\"border: 1px solid #000;color:red;\">";

                                if((substr($products[$p]['prod_id'],1)>1300)&&(substr($products[$p]['prod_id'],1)<1360))
                                {
                                    $o_desc_in_b3=$prod->get_o_desc_in_b3($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);
                                            
                                    if($products[$p]['prod_id']=="p1301")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1302")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1321")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1322")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }
                                if((substr($products[$p]['prod_id'],1)>1499)&&(substr($products[$p]['prod_id'],1)<1560))
                                {
                                    $o_desc_in_b5=$prod->get_o_desc_in_b5($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1501")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1504")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1521")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1524")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1541")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1544")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1506")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1526")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1546")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $thisproductAPU,1,2);
                                        }
                                    }       
                                }

                                if((substr($products[$p]['prod_id'],1)>1599)&&(substr($products[$p]['prod_id'],1)<1660))
                                {
                                    $o_desc_in_b6=$prod->get_o_desc_in_b6($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1600")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1601")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1604")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1621")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1624")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1641")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1644")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1606")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1626")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1646")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }

                                if((substr($products[$p]['prod_id'],1)>1699)&&(substr($products[$p]['prod_id'],1)<1760))
                                {
                                    $o_desc_in_b7=$prod->get_o_desc_in_b7($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1700")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1701")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1704")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1721")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1724")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1741")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1744")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1706")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1726")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1746")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }

                                if((substr($products[$p]['prod_id'],1)>1799)&&(substr($products[$p]['prod_id'],1)<1860))
                                {
                                    $o_desc_in_b8=$prod->get_o_desc_in_b8($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1800")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1801")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1804")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1821")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1824")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1841")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1844")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1806")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1826")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1846")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }

                                if(((substr($products[$p]['prod_id'],1)>1560)&&(substr($products[$p]['prod_id'],1)<1590))||($products[$p]['prod_id']=="p156x")||($products[$p]['prod_id']=="p156z"))
                                {
                                    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1561")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1563")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1566")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }

                                if(((substr($products[$p]['prod_id'],1)>1659)&&(substr($products[$p]['prod_id'],1)<1699))||($products[$p]['prod_id']=="p166x")||($products[$p]['prod_id']=="p166z")||($products[$p]['prod_id']=="p166p"))
                                {
                                    $o_desc_ex_b6=$prod->get_o_desc_ex_b6($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1661")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1663")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1666")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p166p")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }

                                if(((substr($products[$p]['prod_id'],1)>1759)&&(substr($products[$p]['prod_id'],1)<1799))||($products[$p]['prod_id']=="p176x")||($products[$p]['prod_id']=="p176z"))
                                {
                                    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);

                                    if($products[$p]['prod_id']=="p1761")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1763")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1766")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }

                                if(((substr($products[$p]['prod_id'],1)>1859)&&(substr($products[$p]['prod_id'],1)<1899))||($products[$p]['prod_id']=="p186x")||($products[$p]['prod_id']=="p186z"))
                                {
                                    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($products[$p]['o_id']);

                                    $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);
                                    
                                    if($products[$p]['prod_id']=="p1861")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1863")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    elseif($products[$p]['prod_id']=="p1866")
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);
                                        }
                                    }
                                    else
                                    {
                                        if($products[$p]['om_correction']==1)
                                        {
                                            echo "0";
                                            $html .= "0";
                                        }   
                                        else
                                        {
                                        echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);
                                        $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);
                                        }
                                    }
                                }
                                ?>
                                </td>
                                <?php
                                $html .="</td>";
                                ?>
                                <?php
                                // if(($products[$p]['om_amendment']==1)||($products[$p]['om_correction']==1))
                                // {
                                    $html .="<td style=\"border-top: 1px solid #000;border-right: 1px solid #000;\">";
                                ?>
                                <td style="border-top: 1px solid #000;border-right: 1px solid #000;">
                                <?php
                                if($products[$p]['om_amendment']==1)
                                {
                                    echo "Amendment";
                                    $html .="Amendment";
                                }
                                if($products[$p]['om_correction']==1)
                                {
                                    echo " Correction";
                                    $html .=" Correction";
                                }
                                if(($products[$p]['om_amendment']==0)&&($products[$p]['om_correction']==0))
                                {
                                    echo "New";
                                    $html .="New";
                                }
                                ?>
                                </td>
                                <?php
                                $html .="</td>";

                                //}
                                ?>
                                <td <?php
                                if($p==0)
                                {
                                ?>
                                style="border-top: 1px solid #000;"
                                <?php
                                }
                                ?>>
                                <?php
                                $html .="<td ";
                                if($p==0)
                                {
                                
                                $html .="style=\"border-top: 1px solid #000;\"";
                            
                                }
                                $html .=">";

                                if($p==0)
                                {
                                    if($orders[$i]['o_correction']==1)
                                    {
                                        echo "CORRECTION/AMENDMENT ".$orders[$i]['order_name'];
                                        $html .= "CORRECTION/AMENDMENT ".$orders[$i]['order_name'];
                                    }
                                    else
                                    {
                                        echo $orders[$i]['order_name'];
                                        $html .= $orders[$i]['order_name'];
                                    }
                                }
                                ?>
                                </td>
                            </tr>
                            <?php    
                            $html .="</td>";
                            $html .="</tr>";
                                } //products for
                            } //orders for
                            ?>
                        </table>
                        </div>
                        </div>    
                        <?php
                        $html .="</table>";

                        $html .= "<br><b>Total APEs = ".$tot_apus."</b>&nbsp;";
                        
                        $html .= "</body></html>";
                        
                        
                        //file_put_contents("apus.html",$html);
                        
                        require('../mpdf/mpdf.php');
                        $pdf=new mPDF();
                        $pdf->setAutoBottomMargin = 'stretch';
                        //$pdf->SetHTMLFooter($signature);
                        $pdf->WriteHTML($html);
                        $pdf->Output("apus_traders.pdf");
                        ?>
                        <br>
                        <?php
                        }//post save btn            
                        ?>
                        </div> <!-- end row -->
                        <?php
                } //end old calculations
                
                if($calc_method=="new")
                {

                    $traders=$prod->show_all_licence_takers();	
                    $licences=$prod->get_licence_ids();
                    
                    $uprod_ids="";
    
                    for($p=0;$p<count($licences);$p++)
                    {
                        if(!empty($licences[$p]['uprod_id']))
                        {
                            $uprod_id.=$licences[$p]['uprod_id'];
                        }
                    }
    
                    $all_producers2=explode(";",$uprod_id);
                    
                    $all_producers=array_values(array_unique($all_producers2));
    
                    //print_r($all_producers);

                    if(isset($_POST['selected_trader']))
                    {
                        $selected_trader=$_POST['selected_trader'];
                    }
                    if(isset($_POST['selected_producer']))
                    {
                        $selected_producer=$_POST['selected_producer'];
                    }
                    ?>				
            
                    <div class="row mx-0 w-100">
                    <div class="col-md-3 border bg-white py-4">
                        <form class="p-3" name="show_traders" action="index.php?page=traders&calc_method=new" method="post">
                        <p class="mb-0 text-left">
                            Select trader: 
                        </p>
                        <select name="selected_trader" class="form-control form-control-sm mb-3">
                            <option value="">--Choose--</option>
                            <?php 
                            for($i=0;$i<count($traders);$i++)
                            {
                                $all_licences=$prod->get_licences($traders[$i]['lt_id']);

                                if(!empty($all_licences))
                                {
                            ?>
                            <option value="<?php echo $traders[$i]['lt_id']; ?>" <?php echo ($traders[$i]['lt_id']==$selected_trader)?"selected":""; ?>><?php 
                            
                            
                                echo $traders[$i]['mailnick']." - "; 
                                
                                for($l=0;$l<count($all_licences);$l++)
                                {
                                    echo $all_licences[$l]['lic_id'].";";
                                }?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <p class="mb-0 text-left">
                            Select producer:
                        </p>
                        <select name="selected_producer" class="form-control form-control-sm mb-3">
                            <option>--Choose--</option>
                            <?php
                            for($i=0;$i<count($all_producers);$i++)
                            {
                                if(!empty($all_producers[$i]))
                                {
                                $producer=$prod->get_company($all_producers[$i]);
                            ?>	
                                <option value="<?php echo $producer['lt_id'];?>" <?php echo ($producer['lt_id']==$selected_producer)?"selected":""; ?>><?php echo $producer['mailnick']?></option>
                            <?php
                                }	
                            }
                            ?>
                        </select>
                        <p class="mb-0 text-left">Start date:</p>
                        <input class="form-control form-control-sm mb-3" id="traders_start_date" name="traders_start_date" type="text" value="<?php echo (isset($_POST['traders_start_date']))?($_POST['traders_start_date']):date("Y-m-01"); ?>" autocomplete="off">
                            <p class="text-left mb-0">End date:</p>
                            <input class="form-control form-control-sm mb-3" id="traders_end_date" name="traders_end_date" type="text" value="<?php echo (isset($_POST['traders_end_date']))?($_POST['traders_end_date']):date("Y-m-t"); ?>" autocomplete="off">
                        <button name="show_btn" class="btn btn-primary btn-sm float-right px-4 btn-block mb-3">Show</button>
                    </form>
                    <?php
                    if(isset($_POST['show_btn']))
                    {
                    ?>
                    <br>
                    <div style="border: black 3px solid; "></div>
                    <br>
            
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <b>Total APEs = <span id="total_apus"></span></b>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div style="display:inline-flex;">List of work &nbsp;<a href="apus_traders.pdf" target="_blank" class="btn btn-sm btn-primary">View pdf for list of work</a></div>
                        </div>
                    </div>
                    <br>
                    <?php
                    }
                    ?>
                    </div>
                    <?php
                    if(isset($_POST['show_btn']))
                    {
                            $selected_trader=$_POST['selected_trader'];
                            $selected_producer=$_POST['selected_producer'];
                            $traders_start_date=$_POST['traders_start_date'];
                            $traders_end_date=$_POST['traders_end_date'];
                            
                            $trader=$prod->get_company($selected_trader);
                            $producer=$prod->get_company($selected_producer);
                            //$orders=$prod->get_trader_orders_by_date($trader['lt_id'],$traders_start_date,$traders_end_date); 
                            $orders=$prod->get_trader_orders_by_finish_date($trader['lt_id'],$traders_start_date,$traders_end_date); 
                            $total_apus_with_fac_prod=array();    
                            
                        for($i=0;$i<count($orders);$i++)
                        {	
                            //$products=$prod->get_o_prods_by_order_id($orders[$i]['order_ID']);
                            
                                    
                            // for($p=0;$p<count($products);$p++)
                            // {
                                $creator=$prod->get_client($orders[$i]['uca_id']);
                                if($creator['lt_id']==$selected_producer)
                                {
                                    if((substr($orders[$i]['prod_id'],1)>1100)&&(substr($orders[$i]['prod_id'],1)<1160))
                                    {
                                        $o_desc_in_b1=$prod->get_o_desc_in_b1($orders[$i]['o_id']);
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1103")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1103_fac'] * $thisproductAPU,1,2);
                                            }     
                                        }
                                        elseif($orders[$i]['prod_id']=="p1104")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1104_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1106")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1106_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1108")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1108_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        else
                                        { 
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $thisproductAPU,1,2);
                                            }
                                        }
                                    }

                                    if((substr($orders[$i]['prod_id'],1)>1300)&&(substr($orders[$i]['prod_id'],1)<1360))
                                    {
                                        $o_desc_in_b3=$prod->get_o_desc_in_b3($orders[$i]['o_id']);
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1301")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2);
                                            }     
                                        }
                                        elseif($orders[$i]['prod_id']=="p1302")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1321")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1322")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        else
                                        { 
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                            }
                                        }
                                    }
            
                                    if((substr($orders[$i]['prod_id'],1)>1499)&&(substr($orders[$i]['prod_id'],1)<1560))
                                    {
                                        $o_desc_in_b5=$prod->get_o_desc_in_b5($products[$p]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($products[$p]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1501")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1502")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1502_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1503")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1503_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1504")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1506")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1507")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1507_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1508")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1508_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1521")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1522")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1522_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1523")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1523_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1524")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1526")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1527")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1527_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1528")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1528_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1541")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2);   
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1542")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1542_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1543")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1543_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1544")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2);     
                                            }
                                        }                                        
                                        elseif($orders[$i]['prod_id']=="p1546")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);            
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1547")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1547_fac'] * $thisproductAPU,1,2);            
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1548")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1548_fac'] * $thisproductAPU,1,2);            
                                            }
                                        }
                                        else
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $thisproductAPU,1,2);                        
                                            }
                                        }
                                        
                                    }
            
                                    if((substr($orders[$i]['prod_id'],1)>1599)&&(substr($orders[$i]['prod_id'],1)<1660))
                                    {
                                        $o_desc_in_b6=$prod->get_o_desc_in_b6($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1600")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2);
                                            }
                                        
                                        }
                                        elseif($orders[$i]['prod_id']=="p1601")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2);
                                            }
                                        
                                        }
                                        elseif($orders[$i]['prod_id']=="p1604")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2);
                                            }
                                        
                                        }
                                        elseif($orders[$i]['prod_id']=="p1606")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1621")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);
                                            }
                                        
                                        }
                                        elseif($orders[$i]['prod_id']=="p1624")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1626")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);                         
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1641")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2);                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1644")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2);                
                                            }
                                        }
                                        
                                        
                                        elseif($orders[$i]['prod_id']=="p1646")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2); 
                                            }
                                        }
                                        else
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $thisproductAPU,1,2);                      
                                            }
                                        }
                                        
                                    }
            
                                    if((substr($orders[$i]['prod_id'],1)>1699)&&(substr($orders[$i]['prod_id'],1)<1760))
                                    {
                                        $o_desc_in_b7=$prod->get_o_desc_in_b7($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1700")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1701")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1703")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1704")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1706")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1707")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1707_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1708")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1708_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1721")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1722")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1722_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1723")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1723_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1724")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1726")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1727")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1728")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1741")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1742")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1742_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1743")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1743_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1744")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        
                                        
                                        elseif($orders[$i]['prod_id']=="p1746")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);      
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1747")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1747_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1748")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1748_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        else
                                        {           
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        
                                    }
            
                                    if((substr($orders[$i]['prod_id'],1)>1799)&&(substr($orders[$i]['prod_id'],1)<1860))
                                    {
                                        $o_desc_in_b8=$prod->get_o_desc_in_b8($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1800")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1801")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1802")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1802_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1803")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1803_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1804")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2);                                
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1806")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1807")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1807_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1808")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1808_fac'] * $thisproductAPU,1,2);
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1821")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1822")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1822_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1823")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1823_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1824")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1826")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1827")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1827_fac'] * $thisproductAPU,1,2);    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1828")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1828_fac'] * $thisproductAPU,1,2);    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1841")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1842")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1842_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1843")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1843_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1844")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2);  
                                            }
                                        }
                                        
                                        
                                        elseif($orders[$i]['prod_id']=="p1846")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);      
                                            }
                                        }
                                        else
                                        {           
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $thisproductAPU,1,2);
                                        }
                                        
                                    }
            
                                    if(
                                        ((substr($orders[$i]['prod_id'],1)>1160)&&(substr($orders[$i]['prod_id'],1)<1200))||
                                    ($orders[$i]['prod_id']=="p116b")||
                                    ($orders[$i]['prod_id']=="p116m")||
                                    ($orders[$i]['prod_id']=="p116t")||
                                    ($orders[$i]['prod_id']=="p118s")
                                    )
                                    {
                                        $o_desc_ex_b1=$prod->get_o_desc_ex_b1($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
                                        
                                        if($orders[$i]['prod_id']=="p1163")
                                        {            
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {   
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1163_fac'] * $thisproductAPU,1,2);                               
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1166")
                                        {    
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {           
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1166_fac'] * $thisproductAPU,1,2);                               
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1168")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1168_fac'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p116b")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116b_fac'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p116m")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116m_fac'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p116t")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116t_fac'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p118s")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p118s_fac'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                        else
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                                $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b1'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                    }

                                    if(((substr($orders[$i]['prod_id'],1)>1560)&&(substr($orders[$i]['prod_id'],1)<1600))||($orders[$i]['prod_id']=="p156x")||($orders[$i]['prod_id']=="p156y")||($orders[$i]['prod_id']=="p156z"))
                                    {
                                        $o_desc_ex_b5=$prod->get_o_desc_ex_b5($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
                                        
                                        if($orders[$i]['prod_id']=="p1561")
                                        {            
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {   
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);                               
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1563")
                                        {    
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {           
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);                               
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1566")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                        else
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);                           
                                            }
                                        }
                                    }
            
                                    if(((substr($orders[$i]['prod_id'],1)>1659)&&(substr($orders[$i]['prod_id'],1)<1700))||($orders[$i]['prod_id']=="p166x")||($orders[$i]['prod_id']=="p166y")||($orders[$i]['prod_id']=="p166z")||($orders[$i]['prod_id']=="p166p"))
                                    {
                                        $o_desc_ex_b6=$prod->get_o_desc_ex_b6($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1661")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);                     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1663")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);                     
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1666")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p166p")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        else
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);                          
                                            }
                                        }
                                    }
            
                                    if(((substr($orders[$i]['prod_id'],1)>1759)&&(substr($orders[$i]['prod_id'],1)<1800))||($orders[$i]['prod_id']=="p176x")||($orders[$i]['prod_id']=="p176y")||($orders[$i]['prod_id']=="p176z"))
                                    {
                                        $o_desc_ex_b7=$prod->get_o_desc_ex_b7($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                        if($orders[$i]['prod_id']=="p1761")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);                            
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1763")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);                            
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1766")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);                       
                                            }
                                        }
                                        else
                                        {       
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {         
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);                          
                                            }
                                        }
                                    }
            
                                    if(((substr($orders[$i]['prod_id'],1)>1859)&&(substr($orders[$i]['prod_id'],1)<1900))||($orders[$i]['prod_id']=="p186x")||($orders[$i]['prod_id']=="p186y")||($orders[$i]['prod_id']=="p186z"))
                                    {
                                        $o_desc_ex_b8=$prod->get_o_desc_ex_b8($orders[$i]['o_id']);            
                                        $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
                                        
                                        if($orders[$i]['prod_id']=="p1861")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1863")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);                    
                                            }
                                        }
                                        elseif($orders[$i]['prod_id']=="p1866")
                                        {
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);                     
                                            }
                                        }
                                        else
                                        {             
                                            if($orders[$i]['om_correction']==1)
                                            {
                                                $total_apus_with_fac_prod[]=0;
                                            }   
                                            else
                                            {         
                                            $total_apus_with_fac_prod[]=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);              
                                            }
                                        }
                                    }
                                }
                            //}
                        }
                        $html = "<html>";
                        $html .= "<body>";
                        $html .= "<h2 style=\"text-align:center;\">List of work</h2>";
                        $html .= "For ".$trader['Company']." done by ".$producer['Company']." between ".$traders_start_date." and ".$traders_end_date." - amount ".array_sum($total_apus_with_fac_prod)." APUs";
                        $html .= "<br><br>";
                        
                        $tot_apus=array_sum($total_apus_with_fac_prod);
                        //$tot_labc=0;
                        //$tot_capc=0;
                        //print_r($total_apus);
                        
                        ?>
                        <br>
                        
                        <input type="hidden" name="tot_apus" id="tot_apus" value="<?php echo $tot_apus;?>">
                        <div class="col-md-9">                            
                            <div style="overflow-y:scroll;height:650px;">
                            <table class="table" id="traders_apes_table" style="border:1px solid #000;">
                                <thead style="position: sticky; top: -1px; background: #FBFBFB">
                                    <tr style="border: 1px solid #000;">
                                        <th style="border: 1px solid #000;">Order date</th>
                                        <th style="border: 1px solid #000;">Products</th>
                                        <th style="border: 1px solid #000;">Nr.</th>
                                        <th style="border: 1px solid #000;">Basic <br>APEs</th>
                                        <th style="border: 1px solid #000;">Difficulty <br>factor</th>
                                        <th style="border: 1px solid #000;">Total <br>APEs</th>
                                        <th style="border: 1px solid #000;">Creator</th>
                                        <th style="border: 1px solid #000;">&nbsp;</th>
                                        <th style="border: 1px solid #000;">Project name</th>
                                    </tr>  
                                </thead>
                                <tbody style="overflow-y:scroll;height:650px;">
                        <?php
                        $html .="<table style=\"border:1px solid #000;\">";
                        $html .="<tr style=\"border: 1px solid #000;\">";
                        $html .="<th style=\"border: 1px solid #000;\">Order date</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Products</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Nr.</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Basic <br>APEs</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Difficulty <br>factor</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Total <br>APEs</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Creator ID</th>";
                        $html .="<th style=\"border: 1px solid #000;\">&nbsp;</th>";
                        $html .="<th style=\"border: 1px solid #000;\">Project name</th>";
                        $html .="</tr>";
        
                        $p=0;
                        for($i=0;$i<count($orders);$i++)
                        {	
                            //$products=$prod->get_o_prods_by_order_id($orders[$i]['order_ID']);

                            // for($p=0;$p<count($products);$p++)
                            // {
                                $creator=$prod->get_client($orders[$i]['uca_id']);
                                
                                if($creator['lt_id']==$selected_producer)
                                {

                                    if(($orders[$i]['order_ID']!=$orders[$i-1]['order_ID'])&&($i>0))
                                    {
                                        $p=0;
                                    }
                                    
                                    ?>
                                    <tr data-p="<?php echo $p;?>" <?php
                                    if($p==0)
                                    {
                                    ?>
                                    style="border-top: 1px solid #000;border-left: 1px solid #000;"<?php
                                    }?>>
            
                                    <?php
                                    $html .="<tr ";
                                    if($p==0)
                                    { 
                                    $html .="style=\"border-top: 1px solid #000;border-left: 1px solid #000;\"";
                                    }
                                    $html .=">";
                                    ?>
                                        <td <?php
                                        if($p==0)
                                        {
                                        ?>
                                        style="border-top: 1px solid #000;"
                                        <?php
                                        }
                                        ?>>
            
                                        <?php
                                        $html .="<td ";
                                        if($p==0)
                                        {
                                        $html .="style=\"border-top: 1px solid #000;\"";
                                        }
                                        $html .=">";
            
                                        
                                        if($p==0)
                                        {
                                        $date_without_time=explode(" ",$orders[$i]['o_date']);
                                        echo $date_without_time[0];
                                        $html .= $date_without_time[0];
                                        }
                                        ?>
                                        </td>
                                        <td style="border: 1px solid #000;">
                                        <?php
                                        $html .="</td>";
                                        $html .="<td style=\"border: 1px solid #000;\">";
            
                                        //$products=$prod->get_o_prods_by_order_id($orders[$i]['order_ID']);
                                        
                                        echo $orders[$i]['o_id'].".".$orders[$i]['osub_id'].".".$orders[$i]['prod_id'];
                                        $html .= $orders[$i]['o_id'].".".$orders[$i]['osub_id'].".".$orders[$i]['prod_id'];
                                        ?>
                                        </td>
                                        <td style="border: 1px solid #000;text-align:center;">
                                            <?php
                                        $html .="</td>";
                                        $html .="<td style=\"border: 1px solid #000;text-align:center;\">";
                                    
                                            if((substr($orders[$i]['prod_id'],1)>1100)&&(substr($orders[$i]['prod_id'],1)<1160))
                                            {
                                                $o_desc_in_b1=$prod->get_o_desc_in_b1($orders[$i]['o_id']);
                
                                                if($orders[$i]['prod_id']=="p1103")
                                                {
                                                    echo $o_desc_in_b1['p1103_fac'];
                                                    $html .= $o_desc_in_b1['p1103_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1104")
                                                {
                                                    echo $o_desc_in_b1['p1104_fac'];
                                                    $html .= $o_desc_in_b1['p1104_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1106")
                                                {
                                                    echo $o_desc_in_b1['p1106_fac'];
                                                    $html .= $o_desc_in_b1['p1106_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1108")
                                                {
                                                    echo $o_desc_in_b1['p1108_fac'];
                                                    $html .= $o_desc_in_b1['p1108_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }         
                                            }

                                            if((substr($orders[$i]['prod_id'],1)>1300)&&(substr($orders[$i]['prod_id'],1)<1360))
                                            {
                                                $o_desc_in_b3=$prod->get_o_desc_in_b3($orders[$i]['o_id']);
                
                                                if($orders[$i]['prod_id']=="p1301")
                                                {
                                                    echo $o_desc_in_b3['p1301_fac'];
                                                    $html .= $o_desc_in_b3['p1301_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1302")
                                                {
                                                    echo $o_desc_in_b3['p1302_fac'];
                                                    $html .= $o_desc_in_b3['p1302_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1321")
                                                {
                                                    echo $o_desc_in_b3['p1321_fac'];
                                                    $html .= $o_desc_in_b3['p1321_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1322")
                                                {
                                                    echo $o_desc_in_b3['p1322_fac'];
                                                    $html .= $o_desc_in_b3['p1322_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }         
                                            }
                                        
                                            if((substr($orders[$i]['prod_id'],1)>1499)&&(substr($orders[$i]['prod_id'],1)<1560))
                                            {
                                                $o_desc_in_b5=$prod->get_o_desc_in_b5($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1501")
                                                {
                                                    echo $o_desc_in_b5['p1501_fac'];
                                                    $html .= $o_desc_in_b5['p1501_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1504")
                                                {
                                                    echo $o_desc_in_b5['p1504_fac'];
                                                    $html .= $o_desc_in_b5['p1504_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1521")
                                                {
                                                    echo $o_desc_in_b5['p1521_fac'];
                                                    $html .= $o_desc_in_b5['p1521_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1524")
                                                {
                                                    echo $o_desc_in_b5['p1524_fac'];
                                                    $html .= $o_desc_in_b5['p1524_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1541")
                                                {
                                                    echo $o_desc_in_b5['p1541_fac'];
                                                    $html .= $o_desc_in_b5['p1541_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1544")
                                                {
                                                    echo $o_desc_in_b5['p1544_fac'];
                                                    $html .= $o_desc_in_b5['p1544_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1506")
                                                {
                                                    echo $o_desc_in_b5['p1506_fac'];
                                                    $html .= $o_desc_in_b5['p1506_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1526")
                                                {
                                                    echo $o_desc_in_b5['p1526_fac'];
                                                    $html .= $o_desc_in_b5['p1526_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1546")
                                                {
                                                    echo $o_desc_in_b5['p1546_fac'];
                                                    $html .= $o_desc_in_b5['p1546_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }         
                                            }
            
                                            if((substr($orders[$i]['prod_id'],1)>1599)&&(substr($orders[$i]['prod_id'],1)<1660))
                                            {
                                                $o_desc_in_b6=$prod->get_o_desc_in_b6($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1600")
                                                {
                                                    echo $o_desc_in_b6['p1600_fac'];
                                                    $html .= $o_desc_in_b6['p1600_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1601")
                                                {
                                                    echo $o_desc_in_b6['p1601_fac'];
                                                    $html .= $o_desc_in_b6['p1601_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1604")
                                                {
                                                    echo $o_desc_in_b6['p1604_fac'];
                                                    $html .= $o_desc_in_b6['p1604_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1621")
                                                {
                                                    echo $o_desc_in_b6['p1621_fac'];
                                                    $html .= $o_desc_in_b6['p1621_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1624")
                                                {
                                                    echo $o_desc_in_b6['p1624_fac'];
                                                    $html .= $o_desc_in_b6['p1624_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1641")
                                                {
                                                    echo $o_desc_in_b6['p1641_fac'];
                                                    $html .= $o_desc_in_b6['p1641_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1644")
                                                {
                                                    echo $o_desc_in_b6['p1644_fac'];
                                                    $html .= $o_desc_in_b6['p1644_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1606")
                                                {
                                                    echo $o_desc_in_b6['p1606_fac'];
                                                    $html .= $o_desc_in_b6['p1606_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1626")
                                                {
                                                    echo $o_desc_in_b6['p1626_fac'];
                                                    $html .= $o_desc_in_b6['p1626_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1646")
                                                {
                                                    echo $o_desc_in_b6['p1646_fac'];
                                                    $html .= $o_desc_in_b6['p1646_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }  
                                            }
            
                                            if((substr($orders[$i]['prod_id'],1)>1699)&&(substr($orders[$i]['prod_id'],1)<1760))
                                            {
                                                $o_desc_in_b7=$prod->get_o_desc_in_b7($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1700")
                                                {
                                                    echo $o_desc_in_b7['p1700_fac'];
                                                    $html .= $o_desc_in_b7['p1700_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1701")
                                                {
                                                    echo $o_desc_in_b7['p1701_fac'];
                                                    $html .= $o_desc_in_b7['p1701_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1704")
                                                {
                                                    echo $o_desc_in_b7['p1704_fac'];
                                                    $html .= $o_desc_in_b7['p1704_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1721")
                                                {
                                                    echo $o_desc_in_b7['p1721_fac'];
                                                    $html .= $o_desc_in_b7['p1721_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1724")
                                                {
                                                    echo $o_desc_in_b7['p1724_fac'];
                                                    $html .= $o_desc_in_b7['p1724_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1741")
                                                {
                                                    echo $o_desc_in_b7['p1741_fac'];
                                                    $html .= $o_desc_in_b7['p1741_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1744")
                                                {
                                                    echo $o_desc_in_b7['p1744_fac'];
                                                    $html .= $o_desc_in_b7['p1744_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1706")
                                                {
                                                    echo $o_desc_in_b7['p1706_fac'];
                                                    $html .= $o_desc_in_b7['p1706_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1726")
                                                {
                                                    echo $o_desc_in_b7['p1726_fac'];
                                                    $html .= $o_desc_in_b7['p1726_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1746")
                                                {
                                                    echo $o_desc_in_b7['p1746_fac'];
                                                    $html .= $o_desc_in_b7['p1746_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }   
                                            }
            
                                            if((substr($orders[$i]['prod_id'],1)>1799)&&(substr($orders[$i]['prod_id'],1)<1860))
                                            {
                                                $o_desc_in_b8=$prod->get_o_desc_in_b8($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1800")
                                                {
                                                    echo $o_desc_in_b8['p1800_fac'];
                                                    $html .= $o_desc_in_b8['p1800_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1801")
                                                {
                                                    echo $o_desc_in_b8['p1801_fac'];
                                                    $html .= $o_desc_in_b8['p1801_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1804")
                                                {
                                                    echo $o_desc_in_b8['p1804_fac'];
                                                    $html .= $o_desc_in_b8['p1804_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1821")
                                                {
                                                    echo $o_desc_in_b8['p1821_fac'];
                                                    $html .= $o_desc_in_b8['p1821_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1824")
                                                {
                                                    echo $o_desc_in_b8['p1824_fac'];
                                                    $html .= $o_desc_in_b8['p1824_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1841")
                                                {
                                                    echo $o_desc_in_b8['p1841_fac'];
                                                    $html .= $o_desc_in_b8['p1841_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1844")
                                                {
                                                    echo $o_desc_in_b8['p1844_fac'];
                                                    $html .= $o_desc_in_b8['p1844_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1806")
                                                {
                                                    echo $o_desc_in_b8['p1806_fac'];
                                                    $html .= $o_desc_in_b8['p1806_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1826")
                                                {
                                                    echo $o_desc_in_b8['p1826_fac'];
                                                    $html .= $o_desc_in_b8['p1826_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1846")
                                                {
                                                    echo $o_desc_in_b8['p1846_fac'];
                                                    $html .= $o_desc_in_b8['p1846_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }   
                                            }
            
                                            if(
                                                ((substr($orders[$i]['prod_id'],1)>1160)&&(substr($orders[$i]['prod_id'],1)<1200))||
                                                ($orders[$i]['prod_id']=="p116b")||
                                                ($orders[$i]['prod_id']=="p116m")||
                                                ($orders[$i]['prod_id']=="p116t")||
                                                ($orders[$i]['prod_id']=="p118s")
                                                )
                                            {
                                                $o_desc_ex_b1=$prod->get_o_desc_ex_b1($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1163")
                                                {
                                                    echo $o_desc_ex_b1['p1163_fac'];
                                                    $html .= $o_desc_ex_b1['p1163_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1166")
                                                {
                                                    echo $o_desc_ex_b1['p1166_fac'];
                                                    $html .= $o_desc_ex_b1['p1166_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1168")
                                                {
                                                    echo $o_desc_ex_b1['p1168_fac'];
                                                    $html .= $o_desc_ex_b1['p1168_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p116b")
                                                {
                                                    echo $o_desc_ex_b1['p116b_fac'];
                                                    $html .= $o_desc_ex_b1['p116b_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p116m")
                                                {
                                                    echo $o_desc_ex_b1['p116m_fac'];
                                                    $html .= $o_desc_ex_b1['p116m_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p116t")
                                                {
                                                    echo $o_desc_ex_b1['p116t_fac'];
                                                    $html .= $o_desc_ex_b1['p116t_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p118s")
                                                {
                                                    echo $o_desc_ex_b1['p118s_fac'];
                                                    $html .= $o_desc_ex_b1['p118s_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }
                                            }

                                            if(((substr($orders[$i]['prod_id'],1)>1560)&&(substr($orders[$i]['prod_id'],1)<1600))||($orders[$i]['prod_id']=="p156x")||($orders[$i]['prod_id']=="p156y")||($orders[$i]['prod_id']=="p156z"))
                                            {
                                                $o_desc_ex_b5=$prod->get_o_desc_ex_b5($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1561")
                                                {
                                                    echo $o_desc_ex_b5['p1561_fac'];
                                                    $html .= $o_desc_ex_b5['p1561_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1563")
                                                {
                                                    echo $o_desc_ex_b5['p1563_fac'];
                                                    $html .= $o_desc_ex_b5['p1563_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1566")
                                                {
                                                    echo $o_desc_ex_b5['p1566_fac'];
                                                    $html .= $o_desc_ex_b5['p1566_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }
                                            }
            
                                            if(((substr($orders[$i]['prod_id'],1)>1659)&&(substr($orders[$i]['prod_id'],1)<1700))||($orders[$i]['prod_id']=="p166x")||($orders[$i]['prod_id']=="p166y")||($orders[$i]['prod_id']=="p166z")||($orders[$i]['prod_id']=="p166p"))
                                            {
                                                $o_desc_ex_b6=$prod->get_o_desc_ex_b6($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1661")
                                                {
                                                    echo $o_desc_ex_b6['p1661_fac'];
                                                    $html .= $o_desc_ex_b6['p1661_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1663")
                                                {
                                                    echo $o_desc_ex_b6['p1663_fac'];
                                                    $html .= $o_desc_ex_b6['p1663_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1666")
                                                {
                                                    echo $o_desc_ex_b6['p1666_fac'];
                                                    $html .= $o_desc_ex_b6['p1666_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p166p")
                                                {
                                                    echo $o_desc_ex_b6['p166p_fac'];
                                                    $html .= $o_desc_ex_b6['p166p_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }
                                            }
            
                                            if(((substr($orders[$i]['prod_id'],1)>1759)&&(substr($orders[$i]['prod_id'],1)<1800))||($orders[$i]['prod_id']=="p176x")||($orders[$i]['prod_id']=="p176y")||($orders[$i]['prod_id']=="p176z"))
                                            {
                                                $o_desc_ex_b7=$prod->get_o_desc_ex_b7($orders[$i]['o_id']);
            
                                                if($orders[$i]['prod_id']=="p1761")
                                                {
                                                    echo $o_desc_ex_b7['p1761_fac'];
                                                    $html .= $o_desc_ex_b7['p1761_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1763")
                                                {
                                                    echo $o_desc_ex_b7['p1763_fac'];
                                                    $html .= $o_desc_ex_b7['p1763_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1766")
                                                {
                                                    echo $o_desc_ex_b7['p1766_fac'];
                                                    $html .= $o_desc_ex_b7['p1766_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }
                                            }
            
                                            if(((substr($orders[$i]['prod_id'],1)>1859)&&(substr($orders[$i]['prod_id'],1)<1900))||($orders[$i]['prod_id']=="p186x")||($orders[$i]['prod_id']=="p186y")||($orders[$i]['prod_id']=="p186z"))
                                            {
                                                $o_desc_ex_b8=$prod->get_o_desc_ex_b8($orders[$i]['o_id']);
                                                
                                                if($orders[$i]['prod_id']=="p1861")
                                                {
                                                    echo $o_desc_ex_b8['p1861_fac'];
                                                    $html .= $o_desc_ex_b8['p1861_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1863")
                                                {
                                                    echo $o_desc_ex_b8['p1863_fac'];
                                                    $html .= $o_desc_ex_b8['p1863_fac'];
                                                }
                                                elseif($orders[$i]['prod_id']=="p1866")
                                                {
                                                    echo $o_desc_ex_b8['p1866_fac'];
                                                    $html .= $o_desc_ex_b8['p1866_fac'];
                                                }
                                                else
                                                {
                                                    //echo "1";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #000;text-align:right;">
                                            <?php
                                        $html .="</td>";
                                        $html .="<td style=\"border: 1px solid #000;text-align:right\">";
            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
                    
                                            echo bcdiv($thisproductAPU,1,2);
                                            $html .= bcdiv($thisproductAPU,1,2);      
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #000;text-align:center;">
                                            <?php
                                            $html .="</td>";
                                            $html .="<td style=\"border: 1px solid #000;text-align:center;\">";
            
                                            if((substr($orders[$i]['prod_id'],1)>1100)&&(substr($orders[$i]['prod_id'],1)<1160))
                                            {
                                                $o_desc_in_b1=$prod->get_o_desc_in_b1($orders[$i]['o_id']);      
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {                                 
                                                    echo $o_desc_in_b1['fac_prod_in_b1'];
                                                    $html .= $o_desc_in_b1['fac_prod_in_b1'];
                                                }
                                            }

                                            if((substr($orders[$i]['prod_id'],1)>1300)&&(substr($orders[$i]['prod_id'],1)<1360))
                                            {
                                                $o_desc_in_b3=$prod->get_o_desc_in_b3($orders[$i]['o_id']);      
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {                                 
                                                    echo $o_desc_in_b3['fac_prod_in_b3'];
                                                    $html .= $o_desc_in_b3['fac_prod_in_b3'];
                                                }
                                            }
                                            if((substr($orders[$i]['prod_id'],1)>1499)&&(substr($orders[$i]['prod_id'],1)<1560))
                                            {
                                                $o_desc_in_b5=$prod->get_o_desc_in_b5($orders[$i]['o_id']);
                
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_in_b5['fac_prod_in_b5'];
                                                $html .= $o_desc_in_b5['fac_prod_in_b5'];
                                                }
                                            }
            
                                            if((substr($orders[$i]['prod_id'],1)>1599)&&(substr($orders[$i]['prod_id'],1)<1660))
                                            {
                                                $o_desc_in_b6=$prod->get_o_desc_in_b6($orders[$i]['o_id']);
            
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_in_b6['fac_prod_in_b6'];   
                                                $html .= $o_desc_in_b6['fac_prod_in_b6'];  
                                                }
                                            }
                                            if((substr($orders[$i]['prod_id'],1)>1699)&&(substr($orders[$i]['prod_id'],1)<1760))
                                            {
                                                $o_desc_in_b7=$prod->get_o_desc_in_b7($orders[$i]['o_id']);
            
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_in_b7['fac_prod_in_b7'];
                                                $html .= $o_desc_in_b7['fac_prod_in_b7'];
                                                }
                                            }
            
                                            if((substr($orders[$i]['prod_id'],1)>1799)&&(substr($orders[$i]['prod_id'],1)<1860))
                                            {
                                                $o_desc_in_b8=$prod->get_o_desc_in_b8($orders[$i]['o_id']);
            
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_in_b8['fac_prod_in_b8'];
                                                $html .= $o_desc_in_b8['fac_prod_in_b8'];
                                                }
                                            }
            
                                            if(
                                                ((substr($orders[$i]['prod_id'],1)>1160)&&(substr($orders[$i]['prod_id'],1)<1200))||
                                                ($orders[$i]['prod_id']=="p116b")||
                                                ($orders[$i]['prod_id']=="p116m")||
                                                ($orders[$i]['prod_id']=="p116t")||
                                                ($orders[$i]['prod_id']=="p118s")
                                                )
                                            {
                                                $o_desc_ex_b1=$prod->get_o_desc_ex_b1($orders[$i]['o_id']);
            
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_ex_b1['fac_prod_ex_b1'];
                                                $html .= $o_desc_ex_b1['fac_prod_ex_b1'];
                                                }
                                            }

                                            if(((substr($orders[$i]['prod_id'],1)>1560)&&(substr($orders[$i]['prod_id'],1)<1600))||($orders[$i]['prod_id']=="p156x")||($orders[$i]['prod_id']=="p156y")||($orders[$i]['prod_id']=="p156z"))
                                            {
                                                $o_desc_ex_b5=$prod->get_o_desc_ex_b5($orders[$i]['o_id']);
            
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_ex_b5['fac_prod_ex_b5'];
                                                $html .= $o_desc_ex_b5['fac_prod_ex_b5'];
                                                }
                                            }
            
                                            if(((substr($orders[$i]['prod_id'],1)>1659)&&(substr($orders[$i]['prod_id'],1)<1700))||($orders[$i]['prod_id']=="p166x")||($orders[$i]['prod_id']=="p166y")||($orders[$i]['prod_id']=="p166z")||($orders[$i]['prod_id']=="p166p"))
                                            {
                                                $o_desc_ex_b6=$prod->get_o_desc_ex_b6($orders[$i]['o_id']);
            
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_ex_b6['fac_prod_ex_b6'];
                                                $html .= $o_desc_ex_b6['fac_prod_ex_b6'];
                                                }
                                            }
            
                                            if(((substr($orders[$i]['prod_id'],1)>1759)&&(substr($orders[$i]['prod_id'],1)<1800))||($orders[$i]['prod_id']=="p176x")||($orders[$i]['prod_id']=="p176y")||($orders[$i]['prod_id']=="p176z"))
                                            {
                                                $o_desc_ex_b7=$prod->get_o_desc_ex_b7($orders[$i]['o_id']);
            
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_ex_b7['fac_prod_ex_b7'];
                                                $html .= $o_desc_ex_b7['fac_prod_ex_b7'];
                                                }
                                            }
            
                                            if(((substr($orders[$i]['prod_id'],1)>1859)&&(substr($orders[$i]['prod_id'],1)<1900))||($orders[$i]['prod_id']=="p186x")||($orders[$i]['prod_id']=="p186y")||($orders[$i]['prod_id']=="p186z"))
                                            {
                                                $o_desc_ex_b8=$prod->get_o_desc_ex_b8($orders[$i]['o_id']);
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo $o_desc_ex_b8['fac_prod_ex_b8'];
                                                $html .= $o_desc_ex_b8['fac_prod_ex_b8'];
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #000;color:red;text-align:right;">
                                        <?php
                                        $html .="</td>";
                                        $html .="<td style=\"border: 1px solid #000;color:red;text-align:right;\">";
            
                                        if((substr($orders[$i]['prod_id'],1)>1100)&&(substr($orders[$i]['prod_id'],1)<1160))
                                        {
                                            $o_desc_in_b1=$prod->get_o_desc_in_b1($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
                                                    
                                            if($orders[$i]['prod_id']=="p1103")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1103_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1103_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1104")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1104_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1104_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1106")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1106_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1106_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1108")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1108_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b1['fac_prod_in_b1'] * $o_desc_in_b1['p1108_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }

                                        if((substr($orders[$i]['prod_id'],1)>1300)&&(substr($orders[$i]['prod_id'],1)<1360))
                                        {
                                            $o_desc_in_b3=$prod->get_o_desc_in_b3($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
                                                    
                                            if($orders[$i]['prod_id']=="p1301")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1302")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1321")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1322")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b3['fac_prod_in_b3'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
                                        if((substr($orders[$i]['prod_id'],1)>1499)&&(substr($orders[$i]['prod_id'],1)<1560))
                                        {
                                            $o_desc_in_b5=$prod->get_o_desc_in_b5($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1501")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1504")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1521")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1524")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1541")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1544")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1506")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1526")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1546")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b5['fac_prod_in_b5'] * $thisproductAPU,1,2);
                                                }
                                            }       
                                        }
            
                                        if((substr($orders[$i]['prod_id'],1)>1599)&&(substr($orders[$i]['prod_id'],1)<1660))
                                        {
                                            $o_desc_in_b6=$prod->get_o_desc_in_b6($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1600")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1601")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1604")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1621")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1624")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1641")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1644")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1606")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1626")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1646")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b6['fac_prod_in_b6'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
            
                                        if((substr($orders[$i]['prod_id'],1)>1699)&&(substr($orders[$i]['prod_id'],1)<1760))
                                        {
                                            $o_desc_in_b7=$prod->get_o_desc_in_b7($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1700")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1701")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1704")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1721")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1724")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1741")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1744")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1706")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1726")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1746")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b7['fac_prod_in_b7'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
            
                                        if((substr($orders[$i]['prod_id'],1)>1799)&&(substr($orders[$i]['prod_id'],1)<1860))
                                        {
                                            $o_desc_in_b8=$prod->get_o_desc_in_b8($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1800")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1801")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1804")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1821")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1824")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1841")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1844")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1806")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1826")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1846")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_in_b8['fac_prod_in_b8'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
            
                                        if(
                                            ((substr($orders[$i]['prod_id'],1)>1160)&&(substr($orders[$i]['prod_id'],1)<1200))||
                                            ($orders[$i]['prod_id']=="p116b")||
                                            ($orders[$i]['prod_id']=="p116m")||
                                            ($orders[$i]['prod_id']=="p116t")||
                                            ($orders[$i]['prod_id']=="p118s")
                                            )
                                        {
                                            $o_desc_ex_b1=$prod->get_o_desc_ex_b1($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1163")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1163_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1163_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1168")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1168_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1168_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1166")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1166_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p1166_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p116b")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116b_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116b_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p116m")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116m_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116m_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p116t")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116t_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p116t_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p118s")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p118s_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b1['fac_prod_ex_b1'] * $o_desc_ex_b1['p118s_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }

                                        if(((substr($orders[$i]['prod_id'],1)>1560)&&(substr($orders[$i]['prod_id'],1)<1600))||($orders[$i]['prod_id']=="p156x")||($orders[$i]['prod_id']=="p156y")||($orders[$i]['prod_id']=="p156z"))
                                        {
                                            $o_desc_ex_b5=$prod->get_o_desc_ex_b5($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1561")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1563")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1566")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
            
                                        if(((substr($orders[$i]['prod_id'],1)>1659)&&(substr($orders[$i]['prod_id'],1)<1700))||($orders[$i]['prod_id']=="p166x")||($orders[$i]['prod_id']=="p166y")||($orders[$i]['prod_id']=="p166z")||($orders[$i]['prod_id']=="p166p"))
                                        {
                                            $o_desc_ex_b6=$prod->get_o_desc_ex_b6($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1661")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1663")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1666")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p166p")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
            
                                        if(((substr($orders[$i]['prod_id'],1)>1759)&&(substr($orders[$i]['prod_id'],1)<1800))||($orders[$i]['prod_id']=="p176x")||($orders[$i]['prod_id']=="p176y")||($orders[$i]['prod_id']=="p176z"))
                                        {
                                            $o_desc_ex_b7=$prod->get_o_desc_ex_b7($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
            
                                            if($orders[$i]['prod_id']=="p1761")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1763")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1766")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
            
                                        if(((substr($orders[$i]['prod_id'],1)>1859)&&(substr($orders[$i]['prod_id'],1)<1900))||($orders[$i]['prod_id']=="p186x")||($orders[$i]['prod_id']=="p186y")||($orders[$i]['prod_id']=="p186z"))
                                        {
                                            $o_desc_ex_b8=$prod->get_o_desc_ex_b8($orders[$i]['o_id']);            
                                            $thisproductAPU=$prod->calculateProductAPU($orders[$i]['prod_id']);
                                            
                                            if($orders[$i]['prod_id']=="p1861")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1863")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            elseif($orders[$i]['prod_id']=="p1866")
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);
                                                }
                                            }
                                            else
                                            {
                                                if($orders[$i]['om_correction']==1)
                                                {
                                                    echo "0";
                                                    $html .= "0";
                                                }   
                                                else
                                                {
                                                echo bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);
                                                $html .= bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);
                                                }
                                            }
                                        }
                                        ?>
                                        </td>
                                        <?php
                                        $html .="</td>";
                                        $html .="<td style=\"border-top: 1px solid #000;border-right: 1px solid #000;text-align:center;\">";
                                        ?>
                                        <td style="border-top: 1px solid #000;border-right: 1px solid #000;text-align:center;">
                                            <?php echo $orders[$i]['uca_id'];
                                            $html .=$orders[$i]['uca_id'];
                                            ?>
                                        </td>
                                        <?php
                                        $html .="</td>";
                                        
                                        $html .="<td style=\"border-top: 1px solid #000;border-right: 1px solid #000;text-align:center;\">";
                                        ?>
                                        <td style="border-top: 1px solid #000;border-right: 1px solid #000;text-align:center;">
                                        <?php
                                        if($orders[$i]['om_amendment']==1)
                                        {
                                            echo "Amendment";
                                            $html .="Amendment";
                                        }
                                        if($orders[$i]['om_correction']==1)
                                        {
                                            echo " Correction";
                                            $html .=" Correction";
                                        }
                                        if(($orders[$i]['om_amendment']==0)&&($orders[$i]['om_correction']==0))
                                        {
                                            echo "New";
                                            $html .="New";
                                        }
                                        ?>
                                        </td>
                                        <?php
                                        $html .="</td>";
            
                                        //}
                                        ?>
                                        <td <?php
                                        if($p==0)
                                        {
                                        ?>
                                        style="border-top: 1px solid #000;"
                                        <?php
                                        }
                                        ?>>
                                        <?php
                                        $html .="<td ";
                                        if($p==0)
                                        {
                                        
                                        $html .="style=\"border-top: 1px solid #000;\"";
                                    
                                        }
                                        $html .=">";
            
                                        if($p==0)
                                        {
                                            if($orders[$i]['o_correction']==1)
                                            {
                                                echo "CORRECTION/AMENDMENT ".$orders[$i]['order_name'];
                                                $html .= "CORRECTION/AMENDMENT ".$orders[$i]['order_name'];
                                            }
                                            else
                                            {
                                                echo $orders[$i]['order_name'];
                                                $html .= $orders[$i]['order_name'];
                                            }
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    <?php    
                                    $html .="</td>";
                                    $html .="</tr>";
                                    $p++;
                                } //if creator==lt_id
                            //} //products for
                        } //orders for
                                    ?>
                                        </tbody>
                                        </table>
                                    </div> 
                                </div>    
                                <?php
                                $html .="</table>";
            
                                $html .= "<br><b>Total APEs = ".$tot_apus."</b>&nbsp;";
                                
                                $html .= "</body></html>";
                                
                                
                                //file_put_contents("apus.html",$html);
                                
                                require_once '../vendor/autoload.php';

                                

                                $pdf=new \Mpdf\Mpdf();
                                $pdf->setAutoBottomMargin = 'stretch';
                                //$pdf->SetHTMLFooter($signature);
                                $pdf->WriteHTML($html);
                                $pdf->Output("apus_traders.pdf");
                                ?>
                                <br>
                                
                            <?php
                        
                    }//post save btn            
                        ?>
                        </div> <!-- end row --> 
                        <?php
                } //end mew calculations



			} //page producers
		} //isset page	
        }
        else
        {
            ?>
            <div class="text-center">				
            <div class="alert alert-danger">Access denied !</div>
            <a href="<?php echo $base_url;?>own_tasks.php" class="btn btn-danger btn-sm">Go to Own tasks</a>
            <br><br>
            </div>
        <meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>own_tasks.php">
        <?php
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
	<script type="text/javascript" src="js/users.js"></script>
</section>
<?php
include('../footer.php');
?>