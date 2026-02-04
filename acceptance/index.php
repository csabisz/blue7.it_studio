<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Contracting";

include('../header2.php');
include('../menu.php');

$client=$prod->get_client($_COOKIE['client_id']);

$licence_sites=explode(";",$client['ls_ids']);
if(isset($_GET['on_stock']))
{
	$on_stock=$prod->xss_fix($_GET['on_stock']);
}
else
{
    $on_stock=0;
}

$_SESSION['redirect_once']=0;
$licences=$prod->get_licences($_COOKIE['lt_id']);
// print_r($licence_sites);
?>
<section class="top_section">
	<article>
	
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{
			if($_COOKIE['contracting'] > 0)
			{							
				?>
			<div class="container-fluid text-center">
				<h3 class="text-center py-4">Acceptance - Contracting <?php
				if(isset($_GET['orderstatus']))
				{
					$orderstatus=$prod->xss_fix($_GET['orderstatus']);
				}
				else
				{
					$orderstatus=0;
				}
				
				if(!isset($_GET['page']))
				{
					$page=1;
				}
				else
				{
					$page=$prod->xss_fix($_GET['page']);
				}
				$limit=15;
				$startpoint=($page*$limit)-$limit;
                $pages=0;
                //$unfinished_orders="";

				if($orderstatus=="0")
				{
                    echo "- Orders with status 0";
                    if(isset($_GET['status']))
					{
						$status=$prod->xss_fix($_GET['status']);
						$o_id=$prod->xss_fix($_GET['o_id']);
						if($status=="rejected")
						{
							$o_status=12;
							$prod->update_order_status($o_id,$o_status);
							$prod->create_activity($_COOKIE['client_id'],"deleted order",$o_id,"","");
							?>
							<div class="alert alert-danger text-center">Order deleted !</div>
							<meta http-equiv="refresh" content="1; url=index.php?orderstatus=0">
							<?php
						}
                    }
                    
                    if($_COOKIE['view_all_orders']==1)
                    {
                        $orders=$prod->show_order_requests($startpoint,$limit);
                    }
                    else
                    {
                        //$orders=$prod->show_order_requests_by_ls_id($licence_sites[0],$startpoint,$limit);//1 website for now

                        $lic_ids_array=array();

                        for($l=0;$l<count($licences);$l++)
                        {
                            $lic_ids_array[]=$licences[$l]['lic_id'];
                        }
                        $orders=$prod->show_order_requests_by_lic_ids($lic_ids_array,$startpoint,$limit);
                    }
				}
				
				if($orderstatus=="1-9")
				{
					echo "- Orders with status 1-9";
					
					if(isset($_GET['status']))
					{
						$status=$prod->xss_fix($_GET['status']);
						$o_id=$prod->xss_fix($_GET['o_id']);
						if($status=="rejected")
						{
							$o_status=12;
							$prod->update_order_status($o_id,$o_status);
							$prod->create_activity($_COOKIE['client_id'],"deleted order",$o_id,"","");
							?>
							<div class="alert alert-danger text-center">Order deleted !</div>
							<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9">
							<?php
						}
					}
					$u3=array();
					if($page<2)
					{
                        if($_COOKIE['view_all_orders']==1)
                        {
                            $can_not_do_orders=$prod->show_can_not_do_orders();
                            
                            //$unfinished_orders=$prod->show_unfinished_orders();
                            $unfinished_orders=$prod->show_unfinished_orders_by_on_stock($on_stock);
                        }
                        else
                        {
                            /*for($u=0;$u<count($licence_sites);$u++)
                            {
                                if(!empty($licence_sites[$u]))
                                {
                                    // echo $licence_sites[$u];
                                    //$unfinished_orders=$prod->show_unfinished_orders_by_ls_id($licence_sites[$u]);
                                    $unfinished_orders=$prod->show_unfinished_orders_by_ls_id_on_stock($licence_sites[$u],$on_stock);
                                    // print_r($temp_unfinished_orders);
                                    $u3=array_merge($u3,$unfinished_orders);
                                }
                            }*/
                            $lic_ids_array=array();

                            for($l=0;$l<count($licences);$l++)
                            {
                                $lic_ids_array[]=$licences[$l]['lic_id'];
                            }
                            //print_r($lic_ids_array);
                            $unfinished_orders=$prod->show_unfinished_orders_by_lic_ids_on_stock($lic_ids_array,$on_stock);
                            //print_r($unfinished_orders);
                        }
					}
					
					//print_r($unfinished_orders);
					
					
				}
                
                if($orderstatus=="8")
                {
                    if($_COOKIE['view_all_orders']==1)
                    {
                        $finished_orders=$prod->show_finished_orders($startpoint,$limit);
                    }
                    else
                    {
                        //$finished_orders=$prod->show_finished_orders_by_ls_id($licence_sites[0],$startpoint,$limit);
                        $lic_ids_array=array();

                        for($l=0;$l<count($licences);$l++)
                        {
                            $lic_ids_array[]=$licences[$l]['lic_id'];
                        }
                        //print_r($lic_ids_array);
                        $finished_orders=$prod->show_finished_orders_by_lic_ids($lic_ids_array,$startpoint,$limit);
                        
                    }
                    $pages=count($finished_orders);
                }

				if($orderstatus=="10-12")
				{
                    echo "- Orders with status 10-12";
                    if($_COOKIE['view_all_orders']==1)
                    {
                        $orders=$prod->show_deleted_orders($startpoint,$limit);
                    }
                    else
                    {
                        $lic_ids_array=array();

                        for($l=0;$l<count($licences);$l++)
                        {
                            $lic_ids_array[]=$licences[$l]['lic_id'];
                        }

                        $orders=$prod->show_deleted_orders_by_lic_ids($lic_ids_array,$startpoint,$limit);
                    }
					$pages=count($orders);
				}
				?></h3>
				<?php
                include('submenu.php');
                
				?>
				<br> <br>
				<div class="d-none"></div>
				<div class="search_form py-2">
					<div class="row py-2 d-flex justify-content-center">
						<form name="search_form" method="get" action="index.php" class="form-inline">
						<div class="col-md-6">
							Search for Order ID: 
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control form-control-sm" id="search" name="search" required>
							<!-- <input type="hidden" name="orderstatus" value="<?php echo $orderstatus;?>"> -->
						</div>
						<div class="col-md-1">
							<button type="submit" class="btn btn-primary btn-sm ml-3">Search</button>
						</div>	
						</form>
					</div>
				</div>
				<br>
				<?php	
			
		if(!empty($_GET['search']))
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
				if($searched_order['o_status']==6.1)
				{
					echo "brown";
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
					<div class="col-md-1">
					<?php 
					
					echo $searched_order['order_ID'];
					if($searched_order['om_id']!=0)
					{
						echo "-".$searched_order['om_id'];
					} ?>
					</div>
					<div class="col-md-1">
					<?php echo $searched_order['lic_ID']; ?>
					</div>
					<div class="col-md-1">
					<?php 
					$client_id=$searched_order['u_client_ID'];
					$client=$prod->get_client($client_id);
					echo $client['clientname']; 
					echo "<br>".$client['c_first_name']. " ".$client['c_last_name'];
					?>
					</div>
					
					<div class="col-md-2">
					<?php echo $searched_order['order_name']; ?>
					</div>
					
					<div class="col-md-1">
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
					
					if($searched_order['o_special_agreement_price']=="")
					{
                        //echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3'].$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
                        echo $searched_order['brut_price']." ".$cur_short;
					}
					else
					{
						echo $searched_order['o_special_agreement_price']." ".$cur_short;
					}
					?>
					</div>
					<div class="col-md-2">
					<?php echo $searched_order['o_date']; ?>
					</div>
					<div class="col-md-1">
					<?php
					$ost_name=$prod->get_o_status_name($searched_order['o_status']);
					echo $ost_name['ost_name'];
					?>
					</div>
					<div class="col-md-2">
					<?php
					if(($searched_order['o_correction']>0)||($searched_order['o_amendment']>0))
					{
					?>
					<a href="o_correction.php?o_id=<?php echo $searched_order['order_ID'];
					if($searched_order['o_status']>0)
					{
						echo "&status=accepted";
					}?>" class="btn btn-warning btn-sm">View details</a>
					<button id="marketing_copy_btn<?php echo $searched_order['om_id'];?>" name="marketing_copy_btn<?php echo $searched_order['om_id'];?>" data-toggle="modal" data-target="#copy_order<?php echo $searched_order['om_id'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>
						
					<div class="modal fade" id="copy_order<?php echo $searched_order['om_id'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $searched_order['om_id'];?>" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="ModalLabel<?php echo $searched_order['om_id'];?>">Are you sure you want to create a copy ?</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="copy_order_message<?php echo $searched_order['om_id'];?>"></div>
							<input type="hidden" name="o_id<?php echo $searched_order['om_id'];?>" id="o_id<?php echo $searched_order['om_id'];?>" value="<?php echo $searched_order['om_id'];?>">
							<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $searched_order['om_id'];?>" name="for_marketing<?php echo $searched_order['om_id'];?>" value="4388">
							<label class="form-check-label text-dark" for="for_marketing<?php echo $searched_order['om_id'];?>">for Marketing ?</label>
							<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $searched_order['om_id'];?>" name="copy_result_files<?php echo $searched_order['om_id'];?>" value="4388">
							<label class="form-check-label text-dark" for="copy_result_files<?php echo $searched_order['om_id'];?>">Copy also result files ?</label>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" name="start_copy_btn<?php echo $searched_order['om_id'];?>" id="start_copy_btn<?php echo $searched_order['om_id'];?>" class="btn btn-primary">Start copying</button>
						</div>
						</div>
					</div>
					</div>
					<script type="text/javascript">
					$(document).ready(function(){
						$('#start_copy_btn<?php echo $searched_order['om_id'];?>').click(function(){
							let for_marketing=$('#for_marketing<?php echo $searched_order['om_id'];?>').val();
							let o_id=$('#o_id<?php echo $searched_order['om_id'];?>').val();

							if(o_id!="")
							{
							// if(confirm('Are you sure you want to create a copy ?'))
							// {
								if($('#for_marketing<?php echo $searched_order['om_id'];?>').prop("checked") == false)
								{
									for_marketing=0;
								}

								//console.log(for_marketing);
								
								$.ajax({
									url: "../ajax/create_order_copy.php",
									method: "post",
									data: {o_id:o_id,for_marketing:for_marketing},
									dataType:"html",
									success:function(data) {
										$('#copy_order_message<?php echo $searched_order['om_id'];?>').html(data);	
									}
								}); 
								
							//}
							}
							else
							{
								alert('Error ! Order ID can not be empty !');
							} 
						});
					});
					</script>
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

					<button id="marketing_copy_btn<?php echo $searched_order['om_id'];?>" name="marketing_copy_btn<?php echo $searched_order['om_id'];?>" data-toggle="modal" data-target="#copy_order<?php echo $searched_order['om_id'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>
						
					<div class="modal fade" id="copy_order<?php echo $searched_order['om_id'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $searched_order['om_id'];?>" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="ModalLabel<?php echo $searched_order['om_id'];?>">Are you sure you want to create a copy ?</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="copy_order_message<?php echo $searched_order['om_id'];?>"></div>
							<input type="hidden" name="o_id<?php echo $searched_order['om_id'];?>" id="o_id<?php echo $searched_order['om_id'];?>" value="<?php echo $searched_order['om_id'];?>">
							<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $searched_order['om_id'];?>" name="for_marketing<?php echo $searched_order['om_id'];?>" value="4388">
							<label class="form-check-label text-dark" for="for_marketing<?php echo $searched_order['om_id'];?>">for Marketing ?</label>
							<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $searched_order['om_id'];?>" name="copy_result_files<?php echo $searched_order['om_id'];?>" value="4388">
							<label class="form-check-label text-dark" for="copy_result_files<?php echo $searched_order['om_id'];?>">Copy also result files ?</label>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" name="start_copy_btn<?php echo $searched_order['om_id'];?>" id="start_copy_btn<?php echo $searched_order['om_id'];?>" class="btn btn-primary">Start copying</button>
						</div>
						</div>
					</div>
					</div>
					<script type="text/javascript">
					$(document).ready(function(){
						$('#start_copy_btn<?php echo $searched_order['om_id'];?>').click(function(){
							let for_marketing=$('#for_marketing<?php echo $searched_order['om_id'];?>').val();
							let o_id=$('#o_id<?php echo $searched_order['om_id'];?>').val();

							if(o_id!="")
							{
							// if(confirm('Are you sure you want to create a copy ?'))
							// {
								if($('#for_marketing<?php echo $searched_order['om_id'];?>').prop("checked") == false)
								{
									for_marketing=0;
								}

								//console.log(for_marketing);
								
								$.ajax({
									url: "../ajax/create_order_copy.php",
									method: "post",
									data: {o_id:o_id,for_marketing:for_marketing},
									dataType:"html",
									success:function(data) {
										$('#copy_order_message<?php echo $searched_order['om_id'];?>').html(data);	
									}
								}); 
								
							//}
							}
							else
							{
								alert('Error ! Order ID can not be empty !');
							} 
						});
					});
					</script>

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

					<button id="marketing_copy_btn<?php echo $searched_order['order_ID'];?>" name="marketing_copy_btn<?php echo $searched_order['order_ID'];?>" data-toggle="modal" data-target="#copy_order<?php echo $searched_order['order_ID'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>

					<div class="modal fade" id="copy_order<?php echo $searched_order['order_ID'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $searched_order['order_ID'];?>" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="ModalLabel<?php echo $searched_order['order_ID'];?>">Are you sure you want to create a copy ?</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="copy_order_message<?php echo $searched_order['order_ID'];?>"></div>
							<div class="row">
							<div class="col-md-6">
							<input type="hidden" name="o_id<?php echo $searched_order['order_ID'];?>" id="o_id<?php echo $searched_order['order_ID'];?>" value="<?php echo $searched_order['order_ID'];?>">
							<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $searched_order['order_ID'];?>" name="for_marketing<?php echo $searched_order['order_ID'];?>" value="4388">
							<label class="form-check-label text-dark" for="for_marketing<?php echo $searched_order['order_ID'];?>">for Marketing ?</label>
							</div>
							<div class="col-md-auto">
							<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $searched_order['order_ID'];?>" name="copy_result_files<?php echo $searched_order['order_ID'];?>" value="1">
							<label class="form-check-label text-dark" for="copy_result_files<?php echo $searched_order['order_ID'];?>">Copy also result files ?</label>
							</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" name="start_copy_btn<?php echo $searched_order['order_ID'];?>" id="start_copy_btn<?php echo $searched_order['order_ID'];?>" class="btn btn-primary">Start copying</button>
						</div>
						</div>
					</div>
					</div>
					<script type="text/javascript">
					$(document).ready(function(){
						$('#start_copy_btn<?php echo $searched_order['order_ID'];?>').click(function(){
							let for_marketing=$('#for_marketing<?php echo $searched_order['order_ID'];?>').val();
							let copy_result_files=$('#copy_result_files<?php echo $searched_order['order_ID'];?>').val();
							let o_id=$('#o_id<?php echo $searched_order['order_ID'];?>').val();

							if(o_id!="")
							{
							
								if($('#for_marketing<?php echo $searched_order['order_ID'];?>').prop("checked") == false)
								{
									for_marketing=0;
								}
								if($('#copy_result_files<?php echo $searched_order['order_ID'];?>').prop("checked") == false)
								{
									copy_result_files=0;
								}
								
								
								$.ajax({
									url: "../ajax/create_order_copy.php",
									method: "post",
									data: {o_id:o_id,for_marketing:for_marketing,copy_result_files:copy_result_files},
									dataType:"html",
									success:function(data) {
										$('#copy_order_message<?php echo $searched_order['order_ID'];?>').html(data);	
									}
								}); 
								
							
							}
							else
							{
								alert('Error ! Order ID can not be empty !');
							} 
						});
					});
					</script>
					<?php 
					}
					
					if(($searched_order['o_status']>-1)&&($searched_order['o_status']<10))
					{
					?>
					<a href="index.php?orderstatus=0&o_id=<?php echo $searched_order['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
					<a href="add_room_kind_special.php?o_id=<?php echo $searched_order['order_ID']; ?>" class="btn btn-primary btn-sm">Make RKS_ID</a>

					<button class="btn btn-sm <?php echo ($searched_order['notifications'] == 1) ? "btn-success" : "btn-dark"; ?> px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
							id="notification_btn<?php echo $searched_order['order_ID']; ?>" data-o_id="<?php echo $searched_order['order_ID']; ?>" data-notifications="<?php echo $searched_order['notifications'];?>">Notifications
						<span> <?php echo ($searched_order['notifications'] == 1) ? "are ON" : "are OFF"; ?></span></button>
					<script type="text/javascript">
						$("#notification_btn<?php echo $searched_order['order_ID']; ?>").click(function () {
							$.ajax({
								url: "../ajax/update_notification.php",
								method: "post",
								data: {
									o_id: $(this).data('o_id'),
									notifications: $(this).data('notifications')
								},
								dataType: "html",
								success: function (data) {
									//console.log(data);
									if (data == 0) {
										$("#notification_btn<?php echo $searched_order['order_ID']; ?>").data("notifications","0");
										$("#notification_btn<?php echo $searched_order['order_ID']; ?>").html("Notifications <span>are OFF</span>");
										$("#notification_btn<?php echo $searched_order['order_ID']; ?>").removeClass("btn-success").addClass("btn-dark");
									} else {
										$("#notification_btn<?php echo $searched_order['order_ID']; ?>").data("notifications","1");
										$("#notification_btn<?php echo $searched_order['order_ID']; ?>").html("Notifications <span>are ON</span>");
										$("#notification_btn<?php echo $searched_order['order_ID']; ?>").removeClass("btn-dark").addClass("btn-success");
									}
								},
								error: function (xhr, ajaxOptions, thrownError) {
									console.log(xhr.status);
									console.log(thrownError);
								}
							});
						});
					</script>

					<?php
					$room_kind_special=$prod->get_all_room_kind_special($searched_order['order_ID']);

					if(!empty($room_kind_special))
					{
					?>
					<a href="edit_room_kind_special.php?o_id=<?php echo $searched_order['order_ID']; ?>" class="btn btn-primary btn-sm">Edit RKS_ID</a>
					<?php
					}

					}
					?>
					</div>
                    <?php
					if($searched_order['o_deadline']!="0000-00-00 00:00:00")
					{
					?>
					<div class="col-md-1 text-danger">
						Deadline: <?php echo $searched_order['o_deadline']; ?> UTC
					</div>
					<?php
					}
					?>
				</div>
				<br>
				<?php
			
		}
		
		
			if($orderstatus=="1-9")
			{
				
				//can not do orders
				
				for($i=0;$i<count($can_not_do_orders);$i++)
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
					if($can_not_do_orders[$i]['o_status']==6.1)
					{
						echo "brown";
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
						<div class="col-xs-1">
						<?php 
						$client_id=$can_not_do_orders[$i]['u_client_ID'];
						$client=$prod->get_client($client_id);
						echo $client['clientname']; 
						echo "<br>".$client['c_first_name']. " ".$client['c_last_name'];
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
							if(($can_not_do_orders[$i]['o_correction']==1)||($can_not_do_orders[$i]['o_amendment']==1))
							{
								echo "CORRECTION/AMENDMENT<br>".$can_not_do_orders[$i]['order_name'];
							}
						}?>
						</div>
						
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
                            //echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short;
                            echo $can_not_do_orders[$i]['brut_price']." ".$cur_short; 
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
						if(($can_not_do_orders[$i]['o_correction']>0)||($can_not_do_orders[$i]['o_amendment']>0))
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
                        <?php
						if($can_not_do_orders[$i]['o_deadline']!="0000-00-00 00:00:00")
						{
						?>
						<div class="col-xs-1 text-danger">
							Deadline: <?php echo $can_not_do_orders[$i]['o_deadline']; ?> UTC
						</div>
						<?php
						}
						?>
					</div>
					<br>
					<?php
				}
				
				//unfinished orders
				//print_r($unfinished_orders);
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
					if($unfinished_orders[$i]['o_status']==6.1)
					{
						echo "brown";
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
						<div class="col-md-1">
						<?php 
						$client_id=$unfinished_orders[$i]['u_client_ID'];
						$client=$prod->get_client($client_id);
						echo $client['clientname']; 	
						echo "<br>".$client['c_first_name']. " ".$client['c_last_name'];					
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
							if(($unfinished_orders[$i]['o_correction']==1)||($unfinished_orders[$i]['o_amendment']==1))
							{
								echo "AMENDMENT<br>".$unfinished_orders[$i]['order_name'];
							}
						}
						?>
						</div>
						
						<div class="col-md-1" style="width:120px;font-size:14px;">
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
						/* $o_desc_ex_b5=$prod->get_o_desc_ex_b5($unfinished_orders[$i]['order_ID']);
						$o_desc_in_b3=$prod->get_o_desc_in_b3($unfinished_orders[$i]['order_ID']);
						$o_desc_b0=$prod->get_o_desc_b0($unfinished_orders[$i]['order_ID']);
						$o_desc_in_b5=$prod->get_o_desc_in_b5($unfinished_orders[$i]['order_ID']); */
						
						if($unfinished_orders[$i]['o_special_agreement_price']=="")
						{
                            //echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
                            echo "NET: ".$unfinished_orders[$i]['o_price']." ".$cur_short; 
                            echo "<br>";
                            echo "BRUT: ".$unfinished_orders[$i]['brut_price']." ".$cur_short; 
						}
						else
						{
                            echo "NET: ".$unfinished_orders[$i]['o_special_agreement_price']." ".$cur_short;
                            echo "<br>";
                            echo "BRUT: ".$unfinished_orders[$i]['brut_price']." ".$cur_short;
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
						
						if(($unfinished_orders[$i]['o_correction']>0)||($unfinished_orders[$i]['o_amendment']>0))
						{
						?>
						<a href="o_correction.php?o_id=<?php echo $unfinished_orders[$i]['order_ID'];
						if($unfinished_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}?>" class="btn btn-warning btn-sm">View details</a>

						<button id="marketing_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" name="marketing_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" data-toggle="modal" data-target="#copy_order<?php echo $unfinished_orders[$i]['om_id'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>
						
						<div class="modal fade" id="copy_order<?php echo $unfinished_orders[$i]['om_id'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $unfinished_orders[$i]['om_id'];?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="ModalLabel<?php echo $unfinished_orders[$i]['om_id'];?>">Are you sure you want to create a copy ?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="copy_order_message<?php echo $unfinished_orders[$i]['om_id'];?>"></div>
								<div class="row">
									<div class="col-md-6">
									<input type="hidden" name="o_id<?php echo $unfinished_orders[$i]['om_id'];?>" id="o_id<?php echo $unfinished_orders[$i]['om_id'];?>" value="<?php echo $unfinished_orders[$i]['om_id'];?>">
									<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>" name="for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>" value="4388">
									<label class="form-check-label text-dark" for="for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>">for Marketing ?</label>
									</div>
									<div class="col-md-auto">
									<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>" name="copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>" value="1">
									<label class="form-check-label text-dark" for="copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>">Copy also result files ?</label>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" name="start_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" id="start_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" class="btn btn-primary">Start copying</button>
							</div>
							</div>
						</div>
						</div>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#start_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>').click(function(){
								let for_marketing=$('#for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>').val();
								let copy_result_files=$('#copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>').val();
								let o_id=$('#o_id<?php echo $unfinished_orders[$i]['om_id'];?>').val();

								if(o_id!="")
								{
								
									if($('#for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>').prop("checked") == false)
									{
										for_marketing=0;
									}
									if($('#copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>').prop("checked") == false)
									{
										copy_result_files=0;
									}
									
									
									$.ajax({
										url: "../ajax/create_order_copy.php",
										method: "post",
										data: {o_id:o_id,for_marketing:for_marketing,copy_result_files:copy_result_files},
										dataType:"html",
										success:function(data) {
											$('#copy_order_message<?php echo $unfinished_orders[$i]['om_id'];?>').html(data);	
										}
									}); 
									
								
								}
								else
								{
									alert('Error ! Order ID can not be empty !');
								} 
							});
						});
						</script>

						<?php
						} //end correction
						elseif($unfinished_orders[$i]['o_extension']>0)
						{
						?>
						<a href="o_extension.php?o_id=<?php echo $unfinished_orders[$i]['order_ID'];
						if($unfinished_orders[$i]['o_status']>0)
						{
							echo "&status=accepted";
						}?>" class="btn btn-warning btn-sm">View details</a>

						<button id="marketing_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" name="marketing_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" data-toggle="modal" data-target="#copy_order<?php echo $unfinished_orders[$i]['om_id'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>
						
						<div class="modal fade" id="copy_order<?php echo $unfinished_orders[$i]['om_id'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $unfinished_orders[$i]['om_id'];?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="ModalLabel<?php echo $unfinished_orders[$i]['om_id'];?>">Are you sure you want to create a copy ?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="copy_order_message<?php echo $unfinished_orders[$i]['om_id'];?>"></div>
								<div class="row">
								<div class="col-md-6">
									<input type="hidden" name="o_id<?php echo $unfinished_orders[$i]['om_id'];?>" id="o_id<?php echo $unfinished_orders[$i]['om_id'];?>" value="<?php echo $unfinished_orders[$i]['om_id'];?>">
									<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>" name="for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>" value="4388">
									<label class="form-check-label text-dark" for="for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>">for Marketing ?</label>
								</div>
								<div class="col-md-auto">
									<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>" name="copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>" value="1">
									<label class="form-check-label text-dark" for="copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>">Copy also result files ?</label>
								</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" name="start_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" id="start_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>" class="btn btn-primary">Start copying</button>
							</div>
							</div>
						</div>
						</div>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#start_copy_btn<?php echo $unfinished_orders[$i]['om_id'];?>').click(function(){
								let for_marketing=$('#for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>').val();
								let copy_result_files=$('#copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>').val();
								let o_id=$('#o_id<?php echo $unfinished_orders[$i]['om_id'];?>').val();

								if(o_id!="")
								{
								
									if($('#for_marketing<?php echo $unfinished_orders[$i]['om_id'];?>').prop("checked") == false)
									{
										for_marketing=0;
									}
									if($('#copy_result_files<?php echo $unfinished_orders[$i]['om_id'];?>').prop("checked") == false)
									{
										copy_result_files=0;
									}
									
									
									$.ajax({
										url: "../ajax/create_order_copy.php",
										method: "post",
										data: {o_id:o_id,for_marketing:for_marketing,copy_result_files:copy_result_files},
										dataType:"html",
										success:function(data) {
											$('#copy_order_message<?php echo $unfinished_orders[$i]['om_id'];?>').html(data);	
										}
									}); 
									
								
								}
								else
								{
									alert('Error ! Order ID can not be empty !');
								} 
							});
						});
						</script>

						<?php
						} //end exception
						else
						{
						?>
						<a href="orderdetails.php?o_id=<?php echo $unfinished_orders[$i]['order_ID'];
						if($unfinished_orders[$i]['o_status']>0)
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
						<button id="marketing_copy_btn<?php echo $unfinished_orders[$i]['order_ID'];?>" name="marketing_copy_btn<?php echo $unfinished_orders[$i]['order_ID'];?>" data-toggle="modal" data-target="#copy_order<?php echo $unfinished_orders[$i]['order_ID'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>
						
						<div class="modal fade" id="copy_order<?php echo $unfinished_orders[$i]['order_ID'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $unfinished_orders[$i]['order_ID'];?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="ModalLabel<?php echo $unfinished_orders[$i]['order_ID'];?>">Are you sure you want to create a copy ?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="copy_order_message<?php echo $unfinished_orders[$i]['order_ID'];?>"></div>
								<div class="row">
									<div class="col-md-6">
										<input type="hidden" name="o_id<?php echo $unfinished_orders[$i]['order_ID'];?>" id="o_id<?php echo $unfinished_orders[$i]['order_ID'];?>" value="<?php echo $unfinished_orders[$i]['order_ID'];?>">
										<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $unfinished_orders[$i]['order_ID'];?>" name="for_marketing<?php echo $unfinished_orders[$i]['order_ID'];?>" value="4388">
										<label class="form-check-label text-dark" for="for_marketing<?php echo $unfinished_orders[$i]['order_ID'];?>">for Marketing ?</label>
									</div>
									<div class="col-md-auto">
										<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $unfinished_orders[$i]['order_ID'];?>" name="copy_result_files<?php echo $unfinished_orders[$i]['order_ID'];?>" value="1">
										<label class="form-check-label text-dark" for="copy_result_files<?php echo $unfinished_orders[$i]['order_ID'];?>">Copy also result files ?</label>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" name="start_copy_btn<?php echo $unfinished_orders[$i]['order_ID'];?>" id="start_copy_btn<?php echo $unfinished_orders[$i]['order_ID'];?>" class="btn btn-primary">Start copying</button>
							</div>
							
							</div>
						</div>
						</div>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#start_copy_btn<?php echo $unfinished_orders[$i]['order_ID'];?>').click(function(){
								let for_marketing=$('#for_marketing<?php echo $unfinished_orders[$i]['order_ID'];?>').val();
								let copy_result_files=$('#copy_result_files<?php echo $unfinished_orders[$i]['order_ID'];?>').val();
								let o_id=$('#o_id<?php echo $unfinished_orders[$i]['order_ID'];?>').val();

								if(o_id!="")
								{
								
									if($('#for_marketing<?php echo $unfinished_orders[$i]['order_ID'];?>').prop("checked") == false)
									{
										for_marketing=0;
									}

									if($('#copy_result_files<?php echo $unfinished_orders[$i]['order_ID'];?>').prop("checked") == false)
									{
										copy_result_files=0;
									}
									//console.log(for_marketing);
									
									$.ajax({
										url: "../ajax/create_order_copy.php",
										method: "post",
										data: {o_id:o_id,for_marketing:for_marketing,copy_result_files:copy_result_files},
										dataType:"html",
										success:function(data) {
											$('#copy_order_message<?php echo $unfinished_orders[$i]['order_ID'];?>').html(data);	
										}
									}); 
									
								
								}
								else
								{
									alert('Error ! Order ID can not be empty !');
								} 
							});
						});
						</script>
						<?php 
						}
						
						if($orderstatus=="1-9")
						{
						?>
						<a href="index.php?orderstatus=<?php echo $orderstatus;?>&o_id=<?php echo $unfinished_orders[$i]['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
						<a href="add_room_kind_special.php?o_id=<?php echo $unfinished_orders[$i]['order_ID']; ?>" class="btn btn-primary btn-sm">Make RKS_ID</a>

						
					<button class="btn btn-sm <?php echo ($unfinished_orders[$i]['notifications'] == 1) ? "btn-success" : "btn-dark"; ?> px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
							id="notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>" data-o_id="<?php echo $unfinished_orders[$i]['order_ID']; ?>" data-notifications="<?php echo $unfinished_orders[$i]['notifications'];?>">Notifications
						<span> <?php echo ($unfinished_orders[$i]['notifications'] == 1) ? "are ON" : "are OFF"; ?></span></button>
					<script type="text/javascript">
						$("#notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>").click(function () {
							$.ajax({
								url: "../ajax/update_notification.php",
								method: "post",
								data: {
									o_id: $(this).data('o_id'),
									notifications: $(this).data('notifications')
								},
								dataType: "html",
								success: function (data) {
									//console.log(data);
									if (data == 0) {
										$("#notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>").data("notifications","0");
										$("#notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>").html("Notifications <span>are OFF</span>");
										$("#notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>").removeClass("btn-success").addClass("btn-dark");
									} else {
										$("#notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>").data("notifications","1");
										$("#notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>").html("Notifications <span>are ON</span>");
										$("#notification_btn<?php echo $unfinished_orders[$i]['order_ID']; ?>").removeClass("btn-dark").addClass("btn-success");
									}
								},
								error: function (xhr, ajaxOptions, thrownError) {
									console.log(xhr.status);
									console.log(thrownError);
								}
							});
						});
					</script>

						<?php
						$room_kind_special=$prod->get_all_room_kind_special($unfinished_orders[$i]['order_ID']);

						if(!empty($room_kind_special))
						{
						?>
						<a href="edit_room_kind_special.php?o_id=<?php echo $unfinished_orders[$i]['order_ID']; ?>" class="btn btn-primary btn-sm">Edit RKS_ID</a>
						<?php
						}

						}
						?>
						</div>
                        <?php
						if($unfinished_orders[$i]['o_deadline']!="0000-00-00 00:00:00")
						{
						?>
						<div class="col-md-1 text-danger">
							Deadline: <?php echo $unfinished_orders[$i]['o_deadline']; ?> UTC
						</div>
						<?php
						}
						?>
					</div>
					<br>
					<?php
				}
				
				
			}
            
            
            if($orderstatus=="8")
            {
                //finished orders
                //print_r($finished_orders);  
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
					if($finished_orders[$i]['o_status']==6.1)
                    {
                        echo "brown";
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
                        <div class="col-md-1">
                        <?php 
                        $client_id=$finished_orders[$i]['u_client_ID'];
                        $client=$prod->get_client($client_id);
                        echo $client['clientname']; 	
						echo "<br>".$client['c_first_name']. " ".$client['c_last_name'];					
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
                            if(($finished_orders[$i]['o_correction']==1)||($finished_orders[$i]['o_amendment']==1))
                            {
                                echo "CORRECTION/AMENDMENT<br>".$finished_orders[$i]['order_name'];
                            }
                        } ?>
                        </div>
                        
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
                            //echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
                            echo $finished_orders[$i]['brut_price']." ".$cur_short;
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
                        if(($finished_orders[$i]['o_correction']>0)||($finished_orders[$i]['o_amendment']>0))
                        {
                        ?>
                        <a href="o_correction.php?o_id=<?php echo $finished_orders[$i]['order_ID'];
                        if($finished_orders[$i]['o_status']>0)
                        {
                            echo "&status=accepted";
                        }?>" class="btn btn-warning btn-sm">View details</a>

						<button id="marketing_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" name="marketing_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" data-toggle="modal" data-target="#copy_order<?php echo $finished_orders[$i]['om_id'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>
						
						<div class="modal fade" id="copy_order<?php echo $finished_orders[$i]['om_id'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $finished_orders[$i]['om_id'];?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="ModalLabel<?php echo $finished_orders[$i]['om_id'];?>">Are you sure you want to create a copy ?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="copy_order_message<?php echo $finished_orders[$i]['om_id'];?>"></div>
								<input type="hidden" name="o_id<?php echo $finished_orders[$i]['om_id'];?>" id="o_id<?php echo $finished_orders[$i]['om_id'];?>" value="<?php echo $finished_orders[$i]['om_id'];?>">
								<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $finished_orders[$i]['om_id'];?>" name="for_marketing<?php echo $finished_orders[$i]['om_id'];?>" value="4388">
								<label class="form-check-label text-dark" for="for_marketing<?php echo $finished_orders[$i]['om_id'];?>">for Marketing ?</label>
								<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $finished_orders[$i]['om_id'];?>" name="copy_result_files<?php echo $finished_orders[$i]['om_id'];?>" value="4388">
								<label class="form-check-label text-dark" for="copy_result_files<?php echo $finished_orders[$i]['om_id'];?>">Copy also result files ?</label>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" name="start_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" id="start_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" class="btn btn-primary">Start copying</button>
							</div>
							</div>
						</div>
						</div>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#start_copy_btn<?php echo $finished_orders[$i]['om_id'];?>').click(function(){
								let for_marketing=$('#for_marketing<?php echo $finished_orders[$i]['om_id'];?>').val();
								let o_id=$('#o_id<?php echo $finished_orders[$i]['om_id'];?>').val();

								if(o_id!="")
								{
								// if(confirm('Are you sure you want to create a copy ?'))
								// {
									if($('#for_marketing<?php echo $finished_orders[$i]['om_id'];?>').prop("checked") == false)
									{
										for_marketing=0;
									}

									//console.log(for_marketing);
									
									$.ajax({
										url: "../ajax/create_order_copy.php",
										method: "post",
										data: {o_id:o_id,for_marketing:for_marketing},
										dataType:"html",
										success:function(data) {
											$('#copy_order_message<?php echo $finished_orders[$i]['om_id'];?>').html(data);	
										}
									}); 
									
								//}
								}
								else
								{
									alert('Error ! Order ID can not be empty !');
								} 
							});
						});
						</script>
                        <?php
                        }
                        elseif($finished_orders[$i]['o_extension']>0)
                        {
                        ?>
                        <a href="o_extension.php?o_id=<?php echo $finished_orders[$i]['order_ID'];
                        if($finished_orders[$i]['o_status']>0)
                        {
                            echo "&status=accepted";
                        }?>" class="btn btn-warning btn-sm">View details</a>

						<button id="marketing_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" name="marketing_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" data-toggle="modal" data-target="#copy_order<?php echo $finished_orders[$i]['om_id'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>
						
						<div class="modal fade" id="copy_order<?php echo $finished_orders[$i]['om_id'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $finished_orders[$i]['om_id'];?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="ModalLabel<?php echo $finished_orders[$i]['om_id'];?>">Are you sure you want to create a copy ?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="copy_order_message<?php echo $finished_orders[$i]['om_id'];?>"></div>
								<input type="hidden" name="o_id<?php echo $finished_orders[$i]['om_id'];?>" id="o_id<?php echo $finished_orders[$i]['om_id'];?>" value="<?php echo $finished_orders[$i]['om_id'];?>">
								<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $finished_orders[$i]['om_id'];?>" name="for_marketing<?php echo $finished_orders[$i]['om_id'];?>" value="4388">
								<label class="form-check-label text-dark" for="for_marketing<?php echo $finished_orders[$i]['om_id'];?>">for Marketing ?</label>
								<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $finished_orders[$i]['om_id'];?>" name="copy_result_files<?php echo $finished_orders[$i]['om_id'];?>" value="4388">
								<label class="form-check-label text-dark" for="copy_result_files<?php echo $finished_orders[$i]['om_id'];?>">Copy also result files ?</label>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" name="start_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" id="start_copy_btn<?php echo $finished_orders[$i]['om_id'];?>" class="btn btn-primary">Start copying</button>
							</div>
							</div>
						</div>
						</div>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#start_copy_btn<?php echo $finished_orders[$i]['om_id'];?>').click(function(){
								let for_marketing=$('#for_marketing<?php echo $finished_orders[$i]['om_id'];?>').val();
								let o_id=$('#o_id<?php echo $finished_orders[$i]['om_id'];?>').val();

								if(o_id!="")
								{
								// if(confirm('Are you sure you want to create a copy ?'))
								// {
									if($('#for_marketing<?php echo $finished_orders[$i]['om_id'];?>').prop("checked") == false)
									{
										for_marketing=0;
									}

									//console.log(for_marketing);
									
									$.ajax({
										url: "../ajax/create_order_copy.php",
										method: "post",
										data: {o_id:o_id,for_marketing:for_marketing},
										dataType:"html",
										success:function(data) {
											$('#copy_order_message<?php echo $finished_orders[$i]['om_id'];?>').html(data);	
										}
									}); 
									
								//}
								}
								else
								{
									alert('Error ! Order ID can not be empty !');
								} 
							});
						});
						</script>
                        <?php
                        }
                        else
                        {
                        ?>
                        <a href="orderdetails.php?o_id=<?php echo $finished_orders[$i]['order_ID'];
                        if($finished_orders[$i]['o_status']>0)
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
						<button id="marketing_copy_btn<?php echo $finished_orders[$i]['order_ID'];?>" name="marketing_copy_btn<?php echo $finished_orders[$i]['order_ID'];?>" data-toggle="modal" data-target="#copy_order<?php echo $finished_orders[$i]['order_ID'];?>" data-backdrop="static" data-keyboard="false" title="Make a copy for marketing" class="btn btn-sm btn-primary">Make a Copy</button>

						<div class="modal fade" id="copy_order<?php echo $finished_orders[$i]['order_ID'];?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel<?php echo $finished_orders[$i]['order_ID'];?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="ModalLabel<?php echo $finished_orders[$i]['order_ID'];?>">Are you sure you want to create a copy ?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="copy_order_message<?php echo $finished_orders[$i]['order_ID'];?>"></div>
								<input type="hidden" name="o_id<?php echo $finished_orders[$i]['order_ID'];?>" id="o_id<?php echo $finished_orders[$i]['order_ID'];?>" value="<?php echo $finished_orders[$i]['order_ID'];?>">
								<input type="checkbox" class="form-check-input" id="for_marketing<?php echo $finished_orders[$i]['order_ID'];?>" name="for_marketing<?php echo $finished_orders[$i]['order_ID'];?>" value="4388">
								<label class="form-check-label text-dark" for="for_marketing<?php echo $finished_orders[$i]['order_ID'];?>">for Marketing ?</label>
								<input type="checkbox" class="form-check-input" id="copy_result_files<?php echo $finished_orders[$i]['order_ID'];?>" name="copy_result_files<?php echo $finished_orders[$i]['order_ID'];?>" value="4388">
								<label class="form-check-label text-dark" for="copy_result_files<?php echo $finished_orders[$i]['order_ID'];?>">Copy also result files ?</label>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" name="start_copy_btn<?php echo $finished_orders[$i]['order_ID'];?>" id="start_copy_btn<?php echo $finished_orders[$i]['order_ID'];?>" class="btn btn-primary">Start copying</button>
							</div>
							</div>
						</div>
						</div>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#start_copy_btn<?php echo $finished_orders[$i]['order_ID'];?>').click(function(){
								let for_marketing=$('#for_marketing<?php echo $finished_orders[$i]['order_ID'];?>').val();
								let o_id=$('#o_id<?php echo $finished_orders[$i]['order_ID'];?>').val();

								if(o_id!="")
								{
								// if(confirm('Are you sure you want to create a copy ?'))
								// {
									if($('#for_marketing<?php echo $finished_orders[$i]['order_ID'];?>').prop("checked") == false)
									{
										for_marketing=0;
									}

									//console.log(for_marketing);
									
									$.ajax({
										url: "../ajax/create_order_copy.php",
										method: "post",
										data: {o_id:o_id,for_marketing:for_marketing},
										dataType:"html",
										success:function(data) {
											$('#copy_order_message<?php echo $finished_orders[$i]['order_ID'];?>').html(data);	
										}
									}); 
									
								//}
								}
								else
								{
									alert('Error ! Order ID can not be empty !');
								} 
							});
						});
						</script>
                        <?php 
                        }
                        
                        if($orderstatus=="1-9")
                        {
                        ?>
                        <a href="index.php?orderstatus=<?php echo $orderstatus;?>&o_id=<?php echo $finished_orders[$i]['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
						<a href="add_room_kind_special.php?o_id=<?php echo $finished_orders[$i]['order_ID']; ?>" class="btn btn-primary btn-sm">Make RKS_ID</a>

						<button class="btn btn-sm <?php echo ($finished_orders[$i]['notifications'] == 1) ? "btn-success" : "btn-dark"; ?> px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
							id="notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>" data-o_id="<?php echo $finished_orders[$i]['order_ID']; ?>" data-notifications="<?php echo $finished_orders[$i]['notifications'];?>">Notifications
						<span> <?php echo ($finished_orders[$i]['notifications'] == 1) ? "are ON" : "are OFF"; ?></span></button>
					<script type="text/javascript">
						$("#notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>").click(function () {
							$.ajax({
								url: "../ajax/update_notification.php",
								method: "post",
								data: {
									o_id: $(this).data('o_id'),
									notifications: $(this).data('notifications')
								},
								dataType: "html",
								success: function (data) {
									//console.log(data);
									if (data == 0) {
										$("#notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>").data("notifications","0");
										$("#notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>").html("Notifications <span>are OFF</span>");
										$("#notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>").removeClass("btn-success").addClass("btn-dark");
									} else {
										$("#notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>").data("notifications","1");
										$("#notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>").html("Notifications <span>are ON</span>");
										$("#notification_btn<?php echo $finished_orders[$i]['order_ID']; ?>").removeClass("btn-dark").addClass("btn-success");
									}
								},
								error: function (xhr, ajaxOptions, thrownError) {
									console.log(xhr.status);
									console.log(thrownError);
								}
							});
						});
					</script>
					
						<?php
						$room_kind_special=$prod->get_all_room_kind_special($finished_orders[$i]['order_ID']);

						if(!empty($room_kind_special))
						{
						?>
						<a href="edit_room_kind_special.php?o_id=<?php echo $finished_orders[$i]['order_ID']; ?>" class="btn btn-primary btn-sm">Edit RKS_ID</a>
                        <?php
						}

                        }
                        ?>
                        </div>
                        <?php
                        if($finished_orders[$i]['o_deadline']!="0000-00-00 00:00:00")
                        {
                        ?>
                        <div class="col-md-1 text-danger">
                            Deadline: <?php echo $finished_orders[$i]['o_deadline']; ?> UTC
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <br>
                    <?php
                }
            }


			if(($orderstatus==0)||($orderstatus=="10-12"))
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
					if($orders[$i]['o_status']==6.1)
					{
						echo "brown";
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
						<div class="col-md-1">
						<?php 
						$client_id=$orders[$i]['u_client_ID'];
						$client=$prod->get_client($client_id);
						echo $client['clientname']; 	
						echo "<br>".$client['c_first_name']. " ".$client['c_last_name'];					
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
						
                        //echo $o_desc_b0['o_price_b0']+$o_desc_in_b5['o_price_in_b5']+$o_desc_ex_b5['o_price_ex_b5']+$o_desc_in_b3['o_price_in_b3']+$o_desc_in_b7['o_price_in_b7']." ".$cur_short; 
                        if($orders[$i]['o_special_agreement_price']==0)
                        {
                            echo $orders[$i]['brut_price']." ".$cur_short;
                        }
                        else
                        {
                            echo $orders[$i]['o_special_agreement_price']." ".$cur_short; 
                        }
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
						if(($orders[$i]['o_correction']>0)||($orders[$i]['o_amendment']>0))
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
						<a href="index.php?orderstatus=<?php echo $orderstatus;?>&o_id=<?php echo $orders[$i]['order_ID']; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Delete</a>
						<?php
						}
						?>
						</div>
					</div>
					<br>
					<?php
				}
			}
			?>
			<div class="container">
				<div class="row py-2">
					<div class="col-md-12">
						<div class="center_message">
						<?php
						if($page>1)
						{
						?>
						<a href="index.php?orderstatus=<?php echo (isset($orderstatus))?$orderstatus:"0";?>&page=<?php echo $page-1;?>" class="btn btn-primary btn-sm">Previous</a>
						<?php
						}
						?>
						<a href="index.php?orderstatus=<?php echo (isset($orderstatus))?$orderstatus:"0";?>&page=<?php echo $page;?>"><?php echo $page;?></a>
						<?php
						if($pages>0)
						{
						?>
						<a href="index.php?orderstatus=<?php echo (isset($orderstatus))?$orderstatus:"0";?>&page=<?php echo $page+1;?>" class="btn btn-primary btn-sm">Next</a>
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
		 //include('../online_creators.php'); 
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