<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('header2.php');
include('menu.php');

?>
<section class="article pt-5">
	<article>
	
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{							
				?>
			<div class="container text-center mb-5 pagecontent bg-white px-5 pb-5">
                <h3>My orders</h3>
                <hr class="mb-4" width="350px">
				<!-- <h3 class="text-center py-4">Acceptance - Contracting <?php 
				// $orderstatus=$prod->xss_fix($_GET['orderstatus']);
				$page=$prod->xss_fix($_GET['page']);
				if(!isset($_GET['page']))
				{
					$page=1;
				}
				
				$limit=15;
				$startpoint=($page*$limit)-$limit;
				
				// if($orderstatus=="0")
				// {
				// 	echo "- Orders with status 0";
				// 	$orders=$prod->show_order_requests($startpoint,$limit);
				// }
				
				// if($orderstatus=="1-9")
				// {
				// 	echo "- Orders with status 1-9";
					
				// 	if(isset($_GET['status']))
				// 	{
				// 		$status=$prod->xss_fix($_GET['status']);
				// 		$o_id=$prod->xss_fix($_GET['o_id']);
				// 		if($status=="rejected")
				// 		{
				// 			$o_status=12;
				// 			$prod->update_order_status($o_id,$o_status);
				// 			?>
				// 			<div class="center_message"><div class="error">Order deleted !</div></div>
				// 			<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9">
				// 			<?php
				// 		}
				// 	}
					
					if($page<2)
					{
						//$can_not_do_orders=$prod->show_can_not_do_orders();
						$unfinished_orders=$prod->show_client_unfinished_orders($_COOKIE['client_id']);
					}
					
					
					
					
				//}
                
                // if($orderstatus=="8")
                // {
                    
                    $finished_orders=$prod->show_client_finished_orders($_COOKIE['client_id'],$startpoint,$limit);
                    $pages=count($finished_orders);
                //}

				// if($orderstatus=="10-12")
				// {
				// 	echo "- Orders with status 10-12";
				// 	$orders=$prod->show_deleted_orders($startpoint,$limit);
				// 	$pages=count($orders);
                // } 
				?></h3> -->
				<?php
				//include('submenu.php');
				?>
				<!-- <br> <br>
				
				<div class="search_form py-2">
					<div class="row py-2 d-flex justify-content-center">
						<form name="search_form" method="get" action="index.php" class="form-inline">
						<div class="col-md-6">
							Search for Order ID: 
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control form-control-sm" id="search" name="search" required>
							<!-- <input type="hidden" name="orderstatus" value="<?php echo $orderstatus;?>"> -->
						<!--</div>
						<div class="col-md-1">
							<button type="submit" class="btn btn-primary btn-sm ml-3">Search</button>
						</div>	
						</form>
					</div>
				</div> -->
				<br>
				<?php	
			
		/*if(!empty($_GET['search']))
		{			
			$search=$prod->xss_fix($_GET['search']);
			
			$searched_order=$prod->get_order($search);

				?>
				<div class="row py-2 <?php
				if($searched_order['o_status']==0)
				{
					echo "white";
				}
				
				if($searched_order['o_status']==1)
				{
					echo "blue-light";
				}
				if($searched_order['o_status']==2)
				{
					echo "blue";
				}
				if($searched_order['o_status']==3)
				{
					echo "light-green";
				}
				
				if($searched_order['o_status']==4)
				{
					echo "dark-green";
				}
				if($searched_order['o_status']==5)
				{
					echo "yellow-light";
				}
				if($searched_order['o_status']==7)
				{
					echo "orange";
				}
				if($searched_order['o_status']==8)
				{
					echo "black";
				}
				if($searched_order['o_status']==9)
				{
					echo "red";
				}
				
				if($searched_order['o_status']==10)
				{
					echo "white";
				}
				
				if($searched_order['o_status']==12)
				{
					echo "violet";
				}
				
				
				?>">
					<div class="col-xs-1" style="width:50px;">
					<?php 
					
					echo $searched_order['order_ID'];
					if($searched_order['om_id']!=0)
					{
						echo "-".$searched_order['om_id'];
					} ?>
					</div>
					<div class="col-xs-1" style="width:80px;">
					<?php echo $searched_order['lic_ID']; ?>
					</div>
					<div class="col-xs-2">
					<?php 
					$client_id=$searched_order['u_client_ID'];
					$client=$prod->get_client($client_id);
					echo $client['clientname']; 
					
					?>
					</div>
					
					<div class="col-xs-2">
					<?php echo $searched_order['order_name']; ?>
					</div>
					<?php
					if($searched_order['o_deadline']!="0000-00-00 00:00:00")
					{
					?>
					<div class="col-xs-1">
						Deadline: <?php echo $searched_order['o_deadline']; ?> UTC
					</div>
					<?php
					}
					?>
					<div class="col-xs-1" style="width:120px;">
					<?php 
					$licid=$searched_order['lic_ID'];
					$licence=$prod->get_licence($licid);
					if($searched_order['payment_way']==9)
					{
						$cur_short="CRD";
					}
					else
					{
						$cur_short=$prod->get_currency($searched_order['cur_id'])['cur_short'];
					}
					$o_desc_ex_b5=$prod->get_o_desc_ex_b5($searched_order['order_ID']);
					$o_desc_in_b3=$prod->get_o_desc_in_b3($searched_order['order_ID']);
					$o_desc_b0=$prod->get_o_desc_b0($searched_order['order_ID']);
					$o_desc_in_b5=$prod->get_o_desc_in_b5($searched_order['order_ID']);
					
					if($searched_order['o_special_agreement_price']==0)
					{
						echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3'].$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
					}
					else
					{
						echo $searched_order['o_special_agreement_price']." ".$cur_short;
					}
					?>
					</div>
					<div class="col-xs-2" style="width:200px;">
					<?php echo $searched_order['o_date']; ?>
					</div>
					<div class="col-xs-1">
					<?php
					$ost_name=$prod->get_o_status_name($searched_order['o_status']);
					echo $ost_name['ost_name'];
					?>
					</div>
					<div class="col-md-2">
					<?php
					if($searched_order['o_correction']>0)
					{
					?>
					<a href="o_correction.php?o_id=<?php echo $searched_order['order_ID'];
					if($searched_order['o_status']>0)
					{
						echo "&status=accepted";
					}?>" class="btn btn-warning btn-sm">View details</a>
					<?php
					}
					elseif($searched_order['o_extension']>0)
					{
					?>
					<a href="o_extension.php?o_id=<?php echo $searched_order['order_ID'];
					if($searched_order['o_status']>0)
					{
						echo "&status=accepted";
					}?>" class="btn btn-warning btn-sm">View details</a>
					<?php
					}
					else
					{
					?>
					<a href="orderdetails.php?o_id=<?php echo $searched_order['order_ID'];
					if($searched_order['o_status']>0)
					{
						echo "&status=accepted";
					}
					?>" class="btn btn-warning btn-sm">
					<?php
					
					if((($searched_order['o_status']>0)&&($searched_order['o_status']<10))||(($searched_order['o_status']>9)&&($searched_order['o_status']<13)))
					{
						echo "View details";
					}
					else
					{
						echo "View details + acceptance ?";
					}
					
					?>
					</a>
					<?php 
					}
					
					if(($searched_order['o_status']>-1)&&($searched_order['o_status']<10))
					{
					?>
					<a href="index.php?orderstatus=1-9&o_id=<?php echo $searched_order['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
					<?php
					}
					?>
					</div>
				</div>
				<br>
				<?php
			
        } */
		
		
			// if($orderstatus=="1-9")
			// {
				
				//can not do orders
				
				/*for($i=0;$i<count($can_not_do_orders);$i++)
				{
					?>
					<div class="row py-2 <?php
					if($can_not_do_orders[$i]['o_status']==0)
					{
						echo "white";
					}
					
					if($can_not_do_orders[$i]['o_status']==1)
					{
						echo "blue-light";
					}
					if($can_not_do_orders[$i]['o_status']==2)
					{
						echo "blue";
					}
					if($can_not_do_orders[$i]['o_status']==3)
					{
						echo "light-green";
					}
					
					if($can_not_do_orders[$i]['o_status']==4)
					{
						echo "dark-green";
					}
					if($can_not_do_orders[$i]['o_status']==5)
					{
						echo "yellow-light";
					}
					if($can_not_do_orders[$i]['o_status']==7)
					{
						echo "orange";
					}
					if($can_not_do_orders[$i]['o_status']==8)
					{
						echo "black";
					}
					if($can_not_do_orders[$i]['o_status']==9)
					{
						echo "red";
					}
					
					if($can_not_do_orders[$i]['o_status']==10)
					{
						echo "white";
					}
					
					if($can_not_do_orders[$i]['o_status']==12)
					{
						echo "violet";
					}
					
					
					?>">
						<div class="col-xs-1" style="width:50px;">
						<?php 
						
						echo $can_not_do_orders[$i]['order_ID'];
						if($can_not_do_orders[$i]['om_id']!=0)
						{
							echo "-".$can_not_do_orders[$i]['om_id'];
						} ?>
						</div>
						<div class="col-xs-1" style="width:80px;">
						<?php echo $can_not_do_orders[$i]['lic_ID']; ?>
						</div>
						<div class="col-xs-2">
						<?php 
						$client_id=$can_not_do_orders[$i]['u_client_ID'];
						$client=$prod->get_client($client_id);
						echo $client['clientname']; 
						?>
						</div>
						
						<div class="col-xs-2">
						<?php
						if($can_not_do_orders[$i]['om_id']==0)
						{
							echo $can_not_do_orders[$i]['order_name'];
						}
						else
						{
							if($can_not_do_orders[$i]['o_extension']==1)
							{
								echo "EXTENSION<br>".$can_not_do_orders[$i]['order_name'];
							}
							if($can_not_do_orders[$i]['o_correction']==1)
							{
								echo "CORRECTION/AMENDMENT<br>".$can_not_do_orders[$i]['order_name'];
							}
						}?>
						</div>
						<?php
						if($can_not_do_orders[$i]['o_deadline']!="0000-00-00 00:00:00")
						{
						?>
						<div class="col-xs-1">
							Deadline: <?php echo $can_not_do_orders[$i]['o_deadline']; ?> UTC
						</div>
						<?php
						}
						?>
						<div class="col-xs-1" style="width:120px;">
						<?php 
						$licid=$can_not_do_orders[$i]['lic_ID'];
						$licence=$prod->get_licence($licid);
						if($can_not_do_orders[$i]['payment_way']==9)
						{
							$cur_short="CRD";
						}
						else
						{
							$cur_short=$prod->get_currency($licence['currencies'])['cur_short'];
						}
						$o_desc_ex_b5=$prod->get_o_desc_ex_b5($can_not_do_orders[$i]['order_ID']);
						$o_desc_in_b3=$prod->get_o_desc_in_b3($can_not_do_orders[$i]['order_ID']);
						$o_desc_b0=$prod->get_o_desc_b0($can_not_do_orders[$i]['order_ID']);
						$o_desc_in_b5=$prod->get_o_desc_in_b5($can_not_do_orders[$i]['order_ID']);
						
						if($can_not_do_orders[$i]['o_special_agreement_price']==0)
						{
							echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
						}
						else
						{
							echo $can_not_do_orders[$i]['o_special_agreement_price']." ".$cur_short;
						}
						?>
						</div>
						<div class="col-xs-2" style="width:200px;">
						<?php echo $can_not_do_orders[$i]['o_date']; ?>
						</div>
						<div class="col-xs-1">
						<?php
						$ost_name=$prod->get_o_status_name($can_not_do_orders[$i]['o_status']);
						echo $ost_name['ost_name'];
						?>
						</div>
						<div class="col-md-2">
						<?php
						if($can_not_do_orders[$i]['o_correction']>0)
						{
						?>
						<a href="o_correction.php?o_id=<?php echo $can_not_do_orders[$i]['order_ID'];
						if($can_not_do_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}?>" class="btn btn-warning btn-sm">View details</a>
						<?php
						}
						elseif($can_not_do_orders[$i]['o_extension']>0)
						{
						?>
						<a href="o_extension.php?o_id=<?php echo $can_not_do_orders[$i]['order_ID'];
						if($can_not_do_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}?>" class="btn btn-warning btn-sm">View details</a>
						<?php
						}
						else
						{
						?>
						<a href="orderdetails.php?o_id=<?php echo $can_not_do_orders[$i]['order_ID'];
						if($can_not_do_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}
						?>" class="btn btn-warning btn-sm">
						<?php
						
							if(($orderstatus=="1-9")||($orderstatus=="10-12"))
							{
								echo "View details";
							}
							else
							{
								echo "View details + acceptance ?";
							}
						
						?>
						</a>
						<?php 
						}
						
						if($orderstatus=="1-9")
						{
						?>
						<a href="index.php?orderstatus=1-9&o_id=<?php echo $can_not_do_orders[$i]['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
						<?php
						}
						?>
						</div>
					</div>
					<br>
					<?php
                }*/
				
				//unfinished orders
				
				for($i=0;$i<count($unfinished_orders);$i++)
				{
					?>
					<div class="row py-2 <?php
					if($unfinished_orders[$i]['o_status']==0)
					{
						echo "white";
					}
					
					if($unfinished_orders[$i]['o_status']==1)
					{
						echo "blue-light";
					}
					if($unfinished_orders[$i]['o_status']==2)
					{
						echo "blue";
					}
					if($unfinished_orders[$i]['o_status']==3)
					{
						echo "light-green";
					}
					
					if($unfinished_orders[$i]['o_status']==4)
					{
						echo "dark-green";
					}
					if($unfinished_orders[$i]['o_status']==5)
					{
						echo "yellow-light";
					}
					if($unfinished_orders[$i]['o_status']==7)
					{
						echo "orange";
					}
					if($unfinished_orders[$i]['o_status']==8)
					{
						echo "black";
					}
					if($unfinished_orders[$i]['o_status']==9)
					{
						echo "red";
					}
					
					if($unfinished_orders[$i]['o_status']==10)
					{
						echo "white";
					}
					
					if($unfinished_orders[$i]['o_status']==12)
					{
						echo "violet";
					}
					
					
					?>">
						<div class="col-md-1" style="width:100px;">
						<?php echo $unfinished_orders[$i]['order_ID'];
						if($unfinished_orders[$i]['om_id']!=0)
						{
							echo "-".$unfinished_orders[$i]['om_id'];
						}
						?></div>
						<div class="col-md-1" style="width:80px;">
						<?php echo $unfinished_orders[$i]['lic_ID']; ?>
						</div>
						<div class="col-md-2">
						<?php 
						$client_id=$unfinished_orders[$i]['u_client_ID'];
						$client=$prod->get_client($client_id);
						echo $client['clientname']; 						
						?>
						</div>					
						<div class="col-md-2">
						<?php 
						if($unfinished_orders[$i]['om_id']==0)
						{
							echo $unfinished_orders[$i]['order_name'];
						}
						else
						{
							if($unfinished_orders[$i]['o_extension']==1)
							{
								echo "EXTENSION<br>".$unfinished_orders[$i]['order_name'];
							}
							if($unfinished_orders[$i]['o_correction']==1)
							{
								echo "CORRECTION/AMENDMENT<br>".$unfinished_orders[$i]['order_name'];
							}
						}
						?>
						</div>
						<?php
						if($unfinished_orders[$i]['o_deadline']!="0000-00-00 00:00:00")
						{
						?>
						<div class="col-md-1">
							Deadline: <?php echo $unfinished_orders[$i]['o_deadline']; ?> UTC
						</div>
						<?php
						}
						?>
						<div class="col-md-1" style="width:120px;">
						<?php 
						$licid=$unfinished_orders[$i]['lic_ID'];
						$licence=$prod->get_licence($licid);
						if($unfinished_orders[$i]['payment_way']==9)
						{
							$cur_short="CRD";
						}
						else
						{
							$cur_short=$prod->get_currency($unfinished_orders[$i]['cur_id'])['cur_short'];
						}
						$o_desc_ex_b5=$prod->get_o_desc_ex_b5($unfinished_orders[$i]['order_ID']);
						$o_desc_in_b3=$prod->get_o_desc_in_b3($unfinished_orders[$i]['order_ID']);
						$o_desc_b0=$prod->get_o_desc_b0($unfinished_orders[$i]['order_ID']);
						$o_desc_in_b5=$prod->get_o_desc_in_b5($unfinished_orders[$i]['order_ID']);
						
						if($unfinished_orders[$i]['o_special_agreement_price']==0)
						{
							echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
						}
						else
						{
							echo $unfinished_orders[$i]['o_special_agreement_price']." ".$cur_short;
						}
						?>
						</div>
						<div class="col-md-2" style="width:200px;">
						<?php echo $unfinished_orders[$i]['o_date']; ?>
						</div>
						<div class="col-md-1">
						<?php
						$ost_name=$prod->get_o_status_name($unfinished_orders[$i]['o_status']);
						echo $ost_name['ost_name'];
						?>
						</div>
						<div class="col-md-2">
						<?php
						
						if($unfinished_orders[$i]['o_correction']>0)
						{
						?>
						<a href="<?php echo $base_url;?>acceptance/o_correction.php?o_id=<?php echo $unfinished_orders[$i]['order_ID'];
						if($unfinished_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}?>" class="btn btn-warning btn-sm">Details</a>
						<?php
						}
						elseif($unfinished_orders[$i]['o_extension']>0)
						{
						?>
						<a href="<?php echo $base_url;?>acceptance/o_extension.php?o_id=<?php echo $unfinished_orders[$i]['order_ID'];
						if($unfinished_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}?>" class="btn btn-warning btn-sm">Details</a>
						<?php
						}
						else
						{
						?>
						<a href="<?php echo $base_url;?>acceptance/orderdetails.php?o_id=<?php echo $unfinished_orders[$i]['order_ID'];
						if($unfinished_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}
						?>" class="btn btn-warning btn-sm">
						<?php
						
							if(($orderstatus=="1-9")||($orderstatus=="10-12"))
							{
								echo "Details";
							}
							else
							{
								echo "Details";
							}
						
						?>
						</a>
						<?php 
						}
						
						/*if($orderstatus=="1-9")
						{
						?>
						<a href="index.php?orderstatus=1-9&o_id=<?php echo $unfinished_orders[$i]['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
						<?php
                        }*/
						?>
						</div>
					</div>
					<br>
					<?php
				}
				
				
			//}
            
            
            // if($orderstatus=="8")
            // {
                //finished orders
                                
                for($i=0;$i<count($finished_orders);$i++)
                {
                    ?>
                    <div class="row py-2 <?php
                    if($finished_orders[$i]['o_status']==0)
                    {
                        echo "white";
                    }
                    
                    if($finished_orders[$i]['o_status']==1)
                    {
                        echo "blue-light";
                    }
                    if($finished_orders[$i]['o_status']==2)
                    {
                        echo "blue";
                    }
                    if($finished_orders[$i]['o_status']==3)
                    {
                        echo "light-green";
                    }
                    
                    if($finished_orders[$i]['o_status']==4)
                    {
                        echo "dark-green";
                    }
                    if($finished_orders[$i]['o_status']==5)
                    {
                        echo "yellow-light";
                    }
                    if($finished_orders[$i]['o_status']==7)
                    {
                        echo "orange";
                    }
                    if($finished_orders[$i]['o_status']==8)
                    {
                        echo "black";
                    }
                    if($finished_orders[$i]['o_status']==9)
                    {
                        echo "red";
                    }
                    
                    if($finished_orders[$i]['o_status']==10)
                    {
                        echo "white";
                    }
                    
                    if($finished_orders[$i]['o_status']==12)
                    {
                        echo "violet";
                    }
                    
                    
                    ?>">
                        <div class="col-md-1" style="width:100px;">
                        <?php echo $finished_orders[$i]['order_ID'];
                        if($finished_orders[$i]['om_id']!=0)
                        {
                            echo "-".$finished_orders[$i]['om_id'];
                        }?></div>
                        <div class="col-md-1" style="width:80px;">
                        <?php echo $finished_orders[$i]['lic_ID']; ?>
                        </div>
                        <div class="col-md-2">
                        <?php 
                        $client_id=$finished_orders[$i]['u_client_ID'];
                        $client=$prod->get_client($client_id);
                        echo $client['clientname']; 						
                        ?>
                        </div>
                        
                        <div class="col-md-2">
                        <?php
                        if($finished_orders[$i]['om_id']==0)
                        {
                            echo $finished_orders[$i]['order_name'];
                        }
                        else
                        {
                            if($finished_orders[$i]['o_extension']==1)
                            {
                                echo "EXTENSION<br>".$finished_orders[$i]['order_name'];
                            }
                            if($finished_orders[$i]['o_correction']==1)
                            {
                                echo "CORRECTION/AMENDMENT<br>".$finished_orders[$i]['order_name'];
                            }
                        } ?>
                        </div>
                        <?php
                        if($finished_orders[$i]['o_deadline']!="0000-00-00 00:00:00")
                        {
                        ?>
                        <div class="col-md-1">
                            Deadline: <?php echo $finished_orders[$i]['o_deadline']; ?> UTC
                        </div>
                        <?php
                        }
                        ?>
                        <div class="col-md-1" style="width:120px;">
                        <?php 
                        $licid=$finished_orders[$i]['lic_ID'];
                        $licence=$prod->get_licence($licid);
                        if($finished_orders[$i]['payment_way']==9)
                        {
                            $cur_short="CRD";
                        }
                        else
                        {
                            $cur_short=$prod->get_currency($licence['currencies'])['cur_short'];
                        }
                        $o_desc_ex_b5=$prod->get_o_desc_ex_b5($finished_orders[$i]['order_ID']);
                        $o_desc_in_b3=$prod->get_o_desc_in_b3($finished_orders[$i]['order_ID']);
                        $o_desc_b0=$prod->get_o_desc_b0($finished_orders[$i]['order_ID']);
                        $o_desc_in_b5=$prod->get_o_desc_in_b5($finished_orders[$i]['order_ID']);
                        
                        if($finished_orders[$i]['o_special_agreement_price']==0)
                        {
                            echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
                        }
                        else
                        {
                            echo $finished_orders[$i]['o_special_agreement_price']." ".$cur_short;
                        }
                        ?>
                        </div>
                        <div class="col-md-2" style="width:200px;">
                        <?php echo $finished_orders[$i]['o_date']; ?>
                        </div>
                        <div class="col-md-1">
                        <?php
                        $ost_name=$prod->get_o_status_name($finished_orders[$i]['o_status']);
                        echo $ost_name['ost_name'];
                        ?>
                        </div>
                        <div class="col-md-2">
                        <?php
                        if($finished_orders[$i]['o_correction']>0)
                        {
                        ?>
                        <a href="<?php echo $base_url;?>acceptance/o_correction.php?o_id=<?php echo $finished_orders[$i]['order_ID'];
                        if($finished_orders[$i]['o_status']>0)
                        {
                            echo "&status=accepted";
                        }?>" class="btn btn-warning btn-sm">Details</a>
                        <?php
                        }
                        elseif($finished_orders[$i]['o_extension']>0)
                        {
                        ?>
                        <a href="<?php echo $base_url;?>acceptance/o_extension.php?o_id=<?php echo $finished_orders[$i]['order_ID'];
                        if($finished_orders[$i]['o_status']>0)
                        {
                            echo "&status=accepted";
                        }?>" class="btn btn-warning btn-sm">Details</a>
                        <?php
                        }
                        else
                        {
                        ?>
                        <a href="<?php echo $base_url;?>acceptance/orderdetails.php?o_id=<?php echo $finished_orders[$i]['order_ID'];
                        if($finished_orders[$i]['o_status']>0)
                        {
                            echo "&status=accepted";
                        }
                        ?>" class="btn btn-warning btn-sm">
                        <?php
                        
                            if(($orderstatus=="1-9")||($orderstatus=="10-12"))
                            {
                                echo "Details";
                            }
                            else
                            {
                                echo "Details";
                            }
                        
                        ?>
                        </a>
                        <?php 
                        }
                        
                        /*if($orderstatus=="1-9")
                        {
                        ?>
                        <a href="index.php?orderstatus=1-9&o_id=<?php echo $finished_orders[$i]['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
                        <?php
                        }*/
                        ?>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            //}


			/*if(($orderstatus==0)||($orderstatus=="10-12"))
			{
				for($i=0;$i<count($orders);$i++)
				{
					?>
					<div class="row py-2 <?php
					if($orders[$i]['o_status']==0)
					{
						echo "white";
					}
					
					if($orders[$i]['o_status']==1)
					{
						echo "blue-light";
					}
					if($orders[$i]['o_status']==2)
					{
						echo "blue";
					}
					if($orders[$i]['o_status']==3)
					{
						echo "light-green";
					}
					
					if($orders[$i]['o_status']==4)
					{
						echo "dark-green";
					}
					if($orders[$i]['o_status']==5)
					{
						echo "yellow-light";
					}
					if($orders[$i]['o_status']==7)
					{
						echo "orange";
					}
					if($orders[$i]['o_status']==8)
					{
						echo "black";
					}
					if($orders[$i]['o_status']==9)
					{
						echo "red";
					}
					
					if($orders[$i]['o_status']==10)
					{
						echo "white";
					}
					
					if($orders[$i]['o_status']==12)
					{
						echo "violet";
					}
					
					
					?>">
						<div class="col-md-1" style="width:100px;">
						<?php echo $orders[$i]['order_ID'];
						if($orders[$i]['om_id']!=0)
						{
							echo "-".$orders[$i]['om_id'];
						}?>
						</div>
						<div class="col-md-1" style="width:80px;">
						<?php echo $orders[$i]['lic_ID']; ?>
						</div>
						<div class="col-md-2">
						<?php 
						$client_id=$orders[$i]['u_client_ID'];
						$client=$prod->get_client($client_id);
						echo $client['clientname']; 						
						?>
						</div>
						
						<div class="col-md-2">
						<?php echo $orders[$i]['order_name']; ?>
						</div>
						<div class="col-md-1" style="width:120px;">
						<?php 
						$licid=$orders[$i]['lic_ID'];
						$licence=$prod->get_licence($licid);
						if($orders[$i]['payment_way']==9)
						{
							$cur_short="CRD";
						}
						else
						{
							$cur_short=$prod->get_currency($licence['currencies'])['cur_short'];
						}
						
						$o_desc_ex_b5=$prod->get_o_desc_ex_b5($orders[$i]['order_ID']);
						$o_desc_in_b3=$prod->get_o_desc_in_b3($orders[$i]['order_ID']);
						$o_desc_b0=$prod->get_o_desc_b0($orders[$i]['order_ID']);
						$o_desc_in_b5=$prod->get_o_desc_in_b5($orders[$i]['order_ID']);
						
						echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short;  
						?>
						</div>
						<div class="col-md-2" style="width:200px;">
						<?php echo $orders[$i]['o_date']; ?>
						</div>
						<div class="col-md-1">
						<?php
						$ost_name=$prod->get_o_status_name($orders[$i]['o_status']);
						echo $ost_name['ost_name'];
						?>
						</div>
						<div class="col-md-2">
						<?php
						if($orders[$i]['o_correction']>0)
						{
						?>
						<a href="o_correction.php?o_id=<?php echo $orders[$i]['order_ID'];?>" class="btn btn-warning btn-sm">View details</a>
						<?php
						}
						elseif($orders[$i]['o_extension']>0)
						{
						?>
						<a href="o_extension.php?o_id=<?php echo $orders[$i]['order_ID'];?>" class="btn btn-warning btn-sm">View details</a>
						<?php
						}
						else
						{
						?>
						<a href="orderdetails.php?o_id=<?php echo $orders[$i]['order_ID'];
						if($orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}
						?>" class="btn btn-warning btn-sm">
						<?php
						
							if(($orderstatus=="1-9")||($orderstatus=="10-12"))
							{
								echo "View details";
							}
							else
							{
								echo "View details + acceptance ?";
							}
						
						?>
						</a>
						<?php 
						}
						
						if($orderstatus=="0")
						{
						?>
						<a href="index.php?orderstatus=1-9&o_id=<?php echo $orders[$i]['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
						<?php
						}
						?>
						</div>
					</div>
					<br>
					<?php
				}
            }*/
			?>
			<div class="container">
				<div class="row py-2">
					<div class="col-md-12">
						<div class="center_message">
						<?php
						if($page>1)
						{
						?>
						<a href="<?php echo $_SERVER['PHP_SELF'];?>?&page=<?php echo $page-1;?>" class="btn btn-primary btn-sm">Previous</a>
						<?php
						}
						?>
						<a href="<?php echo $_SERVER['PHP_SELF'];?>?&page=<?php echo $page;?>"><?php echo $page;?></a>
						<?php
						if($pages>0)
						{
						?>
						<a href="<?php echo $_SERVER['PHP_SELF'];?>?&page=<?php echo $page+1;?>" class="btn btn-primary btn-sm">Next</a>
						<?php
						}
						?>
						</div>
					</div>
				</div>
			</div> <!-- container -->
		</div><!-- container fluid -->
				<br>
				
				<?php
		 //include('online_creators.php'); 
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
include('footer.php');
?>