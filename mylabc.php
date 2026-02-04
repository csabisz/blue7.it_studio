<?php
//session_set_cookie_params(14400,"/");
session_start();
include('functions.php');
$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="My labc";

include('header2.php');

include('menu.php');

?>
<section class="top_section">
	<article>
	<div class="container-fluid">
	<?php
	if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
	{
	?>		
    <br>
<?php		
    if(isset($_GET['page']))
    {
        $page=$prod->xss_fix($_GET['page']);
			
			if($page=="users")
			{
				$creators=$prod->show_creators($_COOKIE['lt_id']);
                $other_creators=$prod->show_creators_other_companies($_COOKIE['lt_id']);

				if(isset($_POST['selected_user']))
				{
					$selected_user=$_POST['selected_user'];
				}
				?>  
				
					<div class="row mx-0 w-100">
                        <div class="col-md-3 border p-4 bg-white">
                            <form class="p-2" name="show_users" class="text-left" action="<?php echo $_SERVER['PHP_SELF'];?>?page=users" method="post">
                            <p class="mb-0 text-left">Selected user:</p> 
                            <select name="selected_user" class="form-control form-control-sm mb-3">
                                <option value="<?php echo $_COOKIE['client_id']; ?>"><?php 
                                if(!empty($_COOKIE['c_last_name']))
                                {
                                    echo $_COOKIE['c_first_name']." ".$_COOKIE['c_last_name'];
                                }
                                else
                                {
                                    echo $_COOKIE['l_first_name']." ".$_COOKIE['l_last_name'];
                                } ?></option>
                            </select>
							<p class="mb-0 text-left">Start date:</p>	
                            <input class="form-control form-control-sm mb-3" id="users_start_date" name="users_start_date" type="text" value="<?php echo (isset($_POST['users_start_date']))?($_POST['users_start_date']):date("Y-m-01"); ?>" autocomplete="off">
							<p class="mb-0 text-left">End date:</p>	
							 <input class="form-control form-control-sm mb-3" id="users_end_date" name="users_end_date" type="text" value="<?php echo (isset($_POST['users_end_date']))?($_POST['users_end_date']):date("Y-m-t"); ?>" autocomplete="off">
                            <button id="show_btn" name="show_btn" class="btn btn-primary btn-sm float-right px-4 btn-block mb-3">Show</button>
                        </form>
                        <?php
                        if(isset($_POST['show_btn']))
				        {
                        ?>
                        <b>Total labc = <span id="total_labc"></span></b> <b> -- Total APUs = <span id="total_apus"></span></b>
                        <br><br>
                        <div style="border: black 3px solid;"></div>
                        <br>
                        <div style="display:inline-flex;">List of work &nbsp;<a href="<?php echo $base_url;?>users/apus_creators.pdf" target="_blank" class="btn btn-sm btn-primary">View pdf for list of work</a></div>
                        <br><br>
                        <?php
                        }
                        ?>
                        </div>
                        <?php
				if(isset($_POST['show_btn']))
				{
					$selected_user=$_POST['selected_user'];
					$users_start_date=$_POST['users_start_date'];
					$users_end_date=$_POST['users_end_date'];
					
					$creator=$prod->get_client($selected_user);
					
					$user_products=$prod->get_user_products_by_date($selected_user,$users_start_date,$users_end_date);
					
					$html = "<html>";
					$html .= "<style>";
					$html .= ".work_list_table th, .work_list_table td{";
					$html .= "padding: 0px 3px 0px 3px;";
					$html .= "}";
					$html .= "</style>";
					$html .= "<body>";
					$html .= "<h2 style=\"text-align:center;\">List of work</h2>";
                    $html .= "For ";
                    if(!empty($creator['c_last_name']))
                    {
                        $html .=$creator['c_first_name']." ".$creator['c_last_name'];
                    }
                    else
                    {
                        $html .=$creator['l_first_name']." ".$creator['l_last_name'];
                    }
                    $html .=" between ".$users_start_date." and ".$users_end_date;
                    //$html .=" - amount ... APUs";
					$html .="<br><br>";
					?>

            <div class="col-md-9">
                <div style="overflow-y: scroll;height:750px">
					<table class="work_list_table">
						<tr>
							<!-- <th>Order ID</th> -->
							<th>Order date</th>
							<th>Project name</th>
							<th>Products</th>
							<th>labc</th>
                            <th>APUs</th>
							<th>Finished date</th>
						</tr>
                    
					<?php
					
					$html .="<table class=\"work_list_table\">";
					$html .="<tr>";
					//$html .="<th>Order ID</th>";
					$html .="<th>Order date</th>";
					$html .="<th>Project name</th>";
					$html .="<th>Products</th>";
                    $html .="<th>labc</th>";
                    $html .="<th>APUs</th>";
					$html .="<th>Finished date</th>";
					$html .="</tr>";
					
					$total_apus=array();
					$total_labc=array();
					
					for($i=0;$i<count($user_products);$i++)
					{
						$order=$prod->get_order($user_products[$i]['o_id']);
						$html .= "<tr class=\"colorline\">";
						?>
						<tr class="colorline">
							<td><?php 
							$html .= "<td>";
							echo $order['o_date'];
							$html .= $order['o_date'];
							$html .= "</td>";
							?></td>
							<td><?php 
							$html .= "<td>";
							echo $order['order_name'];
							$html .= $order['order_name'];
							$html .= "</td>";
							?></td>
							<td><?php 
                            $html .= "<td>";
                            ?>
                            <a href="https://bauvorschau.com/<?php echo $user_products[$i]['o_id'];?>" target="_blank"><?php
                            echo $user_products[$i]['o_id'].".".$user_products[$i]['osub_id'].".".$user_products[$i]['prod_id'];
                            ?></a><?php

							$html .= $user_products[$i]['o_id'].".".$user_products[$i]['osub_id'].".".$user_products[$i]['prod_id'];
							$html .= "</td>";
							?></td>
							<td class="labc"><?php 
							$html .= "<td class=\"labc\">";
							
                            if((substr($user_products[$i]['prod_id'],1)>1300)&&(substr($user_products[$i]['prod_id'],1)<1360))
                            {
                                $o_desc_in_b3=$prod->get_o_desc_in_b3($user_products[$i]['o_id']);

                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1301")
                                {
                                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1301_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1301_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1302")
                                {
                                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1302_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1302_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1321")
                                {
                                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1321_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1321_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1322")
                                {
                                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1322_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1322_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1499)&&(substr($user_products[$i]['prod_id'],1)<1560))
                            {
                                $o_desc_in_b5=$prod->get_o_desc_in_b5($user_products[$i]['o_id']);
    
                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);
    
                                if($user_products[$i]['prod_id']=="p1501")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1501_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1501_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1504")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1504_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1504_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1521")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductlabc,1,2);  

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1521_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1521_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1524")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductlabc,1,2);  

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1524_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1524_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1541")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1541_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1541_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1544")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1544_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1544_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1506")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1506_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1506_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;        
                                }
                                elseif($user_products[$i]['prod_id']=="p1526")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1526_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1526_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;   
                                }
                                elseif($user_products[$i]['prod_id']=="p1546")
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1546_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1546_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;            
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;                        
                                }
                                
                            }
                            
                            if((substr($user_products[$i]['prod_id'],1)>1599)&&(substr($user_products[$i]['prod_id'],1)<1660))
                            {
                                $o_desc_in_b6=$prod->get_o_desc_in_b6($user_products[$i]['o_id']);
    
                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);
    
                                if($user_products[$i]['prod_id']=="p1600")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1600_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1600_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1601")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1601_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1601_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1604")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1604_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1604_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1624")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductlabc,1,2);  

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1624_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1624_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1641")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1641_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1641_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1644")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1644_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1644_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1606")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1606_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1606_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;        
                                }
                                elseif($user_products[$i]['prod_id']=="p1626")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1626_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1626_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;   
                                }
                                elseif($user_products[$i]['prod_id']=="p1646")
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1646_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1646_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;            
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;                        
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1699)&&(substr($user_products[$i]['prod_id'],1)<1760))
                            {
                                $o_desc_in_b7=$prod->get_o_desc_in_b7($user_products[$i]['o_id']);
    
                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);
    
                                if($user_products[$i]['prod_id']=="p1700")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1700_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1700_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1701")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1701_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1701_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1704")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1704_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1704_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                }
                                elseif($user_products[$i]['prod_id']=="p1721")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductlabc,1,2);  

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1721_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1721_fac']." x ".$thisproductlabc." = ".$labc;
                                    $total_labc[]=$labc; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1724")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductlabc,1,2);  

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1724_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1724_fac']." x ".$thisproductlabc." = ".$labc;
                                    $total_labc[]=$labc; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1741")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1741_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1741_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1744")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductlabc,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1744_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1744_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1706")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1706_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1706_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;        
                                }
                                elseif($user_products[$i]['prod_id']=="p1726")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1726_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1726_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;   
                                }
                                elseif($user_products[$i]['prod_id']=="p1746")
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1746_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1746_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;            
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $thisproductlabc,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;                        
                                }
                                
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1559)&&(substr($user_products[$i]['prod_id'],1)<1590))
                            {
                                $o_desc_ex_b5=$prod->get_o_desc_ex_b5($user_products[$i]['o_id']);

                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1561")
                                {
                                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1561_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1561_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1563")
                                {
                                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1563_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1563_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1566")
                                {
                                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1566_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1566_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                            }

                            if(((substr($user_products[$i]['prod_id'],1)>1659)&&(substr($user_products[$i]['prod_id'],1)<1690))||($user_products[$i]['prod_id']=="p166p"))
                            {
                                $o_desc_ex_b6=$prod->get_o_desc_ex_b6($user_products[$i]['o_id']);

                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1661")
                                {
                                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1661_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1661_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1663")
                                {
                                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1663_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1663_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1666")
                                {
                                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1666_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1666_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                                elseif($user_products[$i]['prod_id']=="p166p")
                                {
                                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p166p_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p166p_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1759)&&(substr($user_products[$i]['prod_id'],1)<1790))
                            {
                                $o_desc_ex_b7=$prod->get_o_desc_ex_b7($user_products[$i]['o_id']);

                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1761")
                                {
                                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1761_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1761_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1763")
                                {
                                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1763_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1763_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1766")
                                {
                                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1766_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1766_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1859)&&(substr($user_products[$i]['prod_id'],1)<1890))
                            {
                                $o_desc_ex_b8=$prod->get_o_desc_ex_b8($user_products[$i]['o_id']);

                                $thisproductlabc=$prod->calculateProductlabc($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1861")
                                {
                                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1861_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1861_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1863")
                                {
                                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductlabc,1,2);
                                    
                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1863_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1863_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1866")
                                {
                                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1866_fac']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1866_fac']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                                else
                                {
                                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductlabc,1,2);

                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$thisproductlabc." = ".$labc;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$thisproductlabc." = ".$labc;

                                    $total_labc[]=$labc;
                                    
                                }
                            }

							
							$html .= "</td>";?></td>
                            <td>
                            <?php
                            $html .= "<td>";
                            if((substr($user_products[$i]['prod_id'],1)>1300)&&(substr($user_products[$i]['prod_id'],1)<1360))
                            {
                                $o_desc_in_b3=$prod->get_o_desc_in_b3($user_products[$i]['o_id']);

                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1301")
                                {
                                    $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1301_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1301_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1302")
                                {
                                    $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1302_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1302_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1321")
                                {
                                    $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1321_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1321_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1322")
                                {
                                    $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1322_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$o_desc_in_b3['p1322_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b3['fac_labc_in_b3']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b3['fac_labc_in_b3']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1499)&&(substr($user_products[$i]['prod_id'],1)<1560))
                            {
                                $o_desc_in_b5=$prod->get_o_desc_in_b5($user_products[$i]['o_id']);
    
                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);
    
                                if($user_products[$i]['prod_id']=="p1501")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1501_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1501_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1504")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1504_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1504_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1521")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1521_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1521_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1524")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1524_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1524_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1541")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1541_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1541_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1544")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1544_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1544_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1506")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1506_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1506_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;        
                                }
                                elseif($user_products[$i]['prod_id']=="p1526")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1526_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1526_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;   
                                }
                                elseif($user_products[$i]['prod_id']=="p1546")
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1546_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1546_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;            
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b5['fac_labc_in_b5']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b5['fac_labc_in_b5']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;                        
                                }
                                
                            }
                            
                            if((substr($user_products[$i]['prod_id'],1)>1599)&&(substr($user_products[$i]['prod_id'],1)<1660))
                            {
                                $o_desc_in_b6=$prod->get_o_desc_in_b6($user_products[$i]['o_id']);
    
                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);
    
                                if($user_products[$i]['prod_id']=="p1600")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1600_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1600_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1601")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1601_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1601_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1604")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1604_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1604_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1621")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1621_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1621_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1624")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1624_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1624_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1641")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1641_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1641_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1644")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1644_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1644_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1606")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1606_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1606_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;        
                                }
                                elseif($user_products[$i]['prod_id']=="p1626")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1626_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1626_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;   
                                }
                                elseif($user_products[$i]['prod_id']=="p1646")
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1646_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1646_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;            
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b6['fac_labc_in_b6']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b6['fac_labc_in_b6']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;                        
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1699)&&(substr($user_products[$i]['prod_id'],1)<1760))
                            {
                                $o_desc_in_b7=$prod->get_o_desc_in_b7($user_products[$i]['o_id']);
    
                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);
    
                                if($user_products[$i]['prod_id']=="p1700")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1700_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1700_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1701")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1701_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1701_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1704")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1704_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1704_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1721")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1721_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1721_fac']." x ".$thisproductAPU." = ".$apu;
                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1724")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1724_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1724_fac']." x ".$thisproductAPU." = ".$apu;
                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1741")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1741_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1741_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1744")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1744_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1744_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1706")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1706_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1706_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;        
                                }
                                elseif($user_products[$i]['prod_id']=="p1726")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1726_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1726_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;   
                                }
                                elseif($user_products[$i]['prod_id']=="p1746")
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1746_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1746_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;            
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b7['fac_labc_in_b7']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;                        
                                }
                                
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1799)&&(substr($user_products[$i]['prod_id'],1)<1860))
                            {
                                $o_desc_in_b8=$prod->get_o_desc_in_b8($user_products[$i]['o_id']);
    
                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);
    
                                if($user_products[$i]['prod_id']=="p1800")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1800_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1800_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1801")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1801_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1801_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1804")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1804_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1804_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                }
                                elseif($user_products[$i]['prod_id']=="p1821")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1821_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1821_fac']." x ".$thisproductAPU." = ".$apu;
                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1824")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);  

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1824_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1824_fac']." x ".$thisproductAPU." = ".$apu;
                                    $total_apus[]=$apu; 
                                }
                                elseif($user_products[$i]['prod_id']=="p1841")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1841_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1841_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1844")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2); 

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1844_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1844_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;    
                                }
                                elseif($user_products[$i]['prod_id']=="p1806")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1806_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1806_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;        
                                }
                                elseif($user_products[$i]['prod_id']=="p1826")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1826_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1826_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;   
                                }
                                elseif($user_products[$i]['prod_id']=="p1846")
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1846_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1846_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;            
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $thisproductAPU,1,2);

                                    echo $o_desc_in_b8['fac_labc_in_b8']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;                        
                                }
                                
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1559)&&(substr($user_products[$i]['prod_id'],1)<1590))
                            {
                                $o_desc_ex_b5=$prod->get_o_desc_ex_b5($user_products[$i]['o_id']);

                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1561")
                                {
                                    $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1561_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1561_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1563")
                                {
                                    $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1563_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1563_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1566")
                                {
                                    $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1566_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1566_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b5['fac_prod_ex_b5']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b5['fac_prod_ex_b5']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                            }

                            if(((substr($user_products[$i]['prod_id'],1)>1659)&&(substr($user_products[$i]['prod_id'],1)<1690))||($user_products[$i]['prod_id']=="p166p"))
                            {
                                $o_desc_ex_b6=$prod->get_o_desc_ex_b6($user_products[$i]['o_id']);

                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1661")
                                {
                                    $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1661_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1661_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1663")
                                {
                                    $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1663_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1663_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1666")
                                {
                                    $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1666_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1666_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                                elseif($user_products[$i]['prod_id']=="p166p")
                                {
                                    $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p166p_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p166p_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p166p_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b6['fac_prod_ex_b6']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b6['fac_prod_ex_b6']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1759)&&(substr($user_products[$i]['prod_id'],1)<1790))
                            {
                                $o_desc_ex_b7=$prod->get_o_desc_ex_b7($user_products[$i]['o_id']);

                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1761")
                                {
                                    $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1761_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1761_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1763")
                                {
                                    $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1763_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1763_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1766")
                                {
                                    $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1766_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1766_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b7['fac_prod_ex_b7']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b7['fac_prod_ex_b7']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                            }

                            if((substr($user_products[$i]['prod_id'],1)>1859)&&(substr($user_products[$i]['prod_id'],1)<1890))
                            {
                                $o_desc_ex_b8=$prod->get_o_desc_ex_b8($user_products[$i]['o_id']);

                                $thisproductAPU=$prod->calculateProductAPU($user_products[$i]['prod_id']);

                                if($user_products[$i]['prod_id']=="p1861")
                                {
                                    $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1861_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1861_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1863")
                                {
                                    $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);
                                    
                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1863_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1863_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                
                                }
                                elseif($user_products[$i]['prod_id']=="p1866")
                                {
                                    $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1866_fac']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1866_fac']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                                else
                                {
                                    $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);

                                    echo $o_desc_ex_b8['fac_prod_ex_b8']." x ".$thisproductAPU." = ".$apu;
                                    $html.= $o_desc_ex_b8['fac_prod_ex_b8']." x ".$thisproductAPU." = ".$apu;

                                    $total_apus[]=$apu;
                                    
                                }
                            }
                            $html .= "</td>";
                            ?>
                            </td>
							<td><?php 
							$html .= "<td>";
							echo $user_products[$i]['prod_finish_date'];
							$html .= $user_products[$i]['prod_finish_date'];
							$html .= "</td>";
							$html .= "</tr>";
							?></td>
						</tr>
                    
						<?php
					}
					?>
                   
					</table>
                    </div>
                </div>
					<?php
					$html .= "</table>";
					
					$tot_labc=0;
                    $tot_apus=0;

					for($i=0;$i<count($total_labc);$i++)
					{
						$tot_labc = $tot_labc + $total_labc[$i];
					}
					for($i=0;$i<count($total_apus);$i++)
					{
						$tot_apus = $tot_apus + $total_apus[$i];
					}
                    $html .= "<b>Total labc = ".$tot_labc."</b>";
                    $html .= " <b>Total APUs = ".$tot_apus."</b>";
					$html .= "</body></html>";
					
					?>
                    
                    <input type="hidden" name="tot_labc" id="tot_labc" value="<?php echo $tot_labc;?>">
                    <input type="hidden" name="tot_apus" id="tot_apus" value="<?php echo $tot_apus;?>">
                    <?php
					//file_put_contents("apus.html",$html);
					
					require('./mpdf/mpdf.php');
					$pdf=new mPDF();
					$pdf->setAutoBottomMargin = 'stretch';
					//$pdf->SetHTMLFooter($signature);
					$pdf->WriteHTML($html);
					$pdf->Output("./users/apus_creators.pdf");
					
					?>
				
					<br>
					
				<?php
				}            
                ?>
            </div> <!-- end row -->
			<?php
				
            } //page users
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
	<script type="text/javascript" src="users/js/users.js"></script>
</section>
<?php
include('footer.php');
?>