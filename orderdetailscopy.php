<?php
//ini_set('max_file_uploads', 150);
//session_set_cookie_params(14400,"/");
session_start();
error_reporting(0);
include('functions.php');
include('../../domenia7.com/public_html/domenia_db2.php');
include('../../blue7.it/public_html/domenia/domenia.php');
$prod=new Production;
$domenia=new Domenia;
$domenia2=new Domenia2;
$_SESSION['start']=gmdate("Y-m-d H:i:s");

include('header2.php');
include('menu.php');

?>
<section class="pt-5 acceptance">
	<article>
		<?php
		if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire']))
		{
			if(isset($_GET['orderid']))
			{
				
				$option=$prod->xss_fix($_GET['option']);
				
				/*if(isset($_POST['delete_btn']))
				{
					$orf_id=$prod->xss_fix($_POST['orf_id']);
					
					$prod->delete_creator_file($orf_id);
					?>
					<div class="center_message"> <div class="success">Image deleted !</div></div><br >
					<?php
                }	*/		
						
				if($option="changestatus")
				{
					if((isset($_GET['prod_id']))&&(isset($_GET['osub_id']))&&(isset($_GET['p_status'])))
					{
						$orderid=$prod->xss_fix($_GET['orderid']);
						$p_status=$prod->xss_fix($_GET['p_status']);
						$prod_id=$prod->xss_fix($_GET['prod_id']);
						$osub_id=$prod->xss_fix($_GET['osub_id']);
												
						$prod->update_o_prods_status($orderid,$osub_id,$prod_id,$p_status);
						
						$logged_in_user_id=$prod->get_creator($_SESSION['email']);
						$p_status_name=$prod->get_o_status_name($p_status);
						
						$prod->create_activity($logged_in_user_id['uca_id'],"changed status to ".$p_status_name['ost_name'],$o_id,$osub_id,$prod_id);
						
						if($p_status==7)
						{
							$prod->update_order_status($orderid,$o_status=7);
						}
						elseif($p_status==9)
						{
							$prod->update_order_status($orderid,$o_status=9);
						}
						
						?>
						<!-- <meta http-equiv="refresh" content="0; url=orderdetails.php?orderid=<?php echo $orderid; ?>"> -->
						<?php
					}
				}
				
				$orderid=$prod->xss_fix($_GET['orderid']);
				$order=$prod->get_order($orderid);
				$licenceid=$order['lic_ID'];
				
				$image_preview_counter=0;
				$validextensions = array("jpeg", "jpg", "png");
				
				//$creator=$prod->get_client($_SESSION['email'])['client_id'];
				
				$myproducts=$prod->creator_products($orderid,$_SESSION['client_id']);
			?>
			<div class="container text-center mb-5 pagecontent bg-white px-0">	
				<div class="left_container">					
                <h3 class="pb-2 pt-3">Own Tasks - Order ID <?php 
                if($order['om_id']==0)
                {
                    echo $orderid;
                }
                else
                {
                    echo $orderid."-".$order['om_id'];
                }
                
                echo " - ".$order['order_name'];
                
                if($order['o_deadline']!="0000-00-00 00:00:00")
                {
                ?>
                
                <span class="text-danger"> - Deadline: <span id="o_deadline"><?php 
                    echo $order['o_deadline'];?></span> UTC+0</span>

                <br><span class="text-danger">Time left: <b><span id="timeleft<?php echo $orderid;?>" class="blink"></span></b></span>
                <script type="text/javascript">
		            setInterval(function() {
                            //var deadline = new Date('<?php echo $order['o_deadline'];?>');
                            var deadline = new Date($('#o_deadline').text());
		                    var today=new Date();
		                    var diff=(new Date(deadline).getTime() - new Date(today).getTime());

		                    if(diff>(24*60*60*1000) || diff<0){
		                        $('#timeleft<?php echo $orderid;?>').removeClass('blink');
		                    }else{
		                        $('#timeleft<?php echo $orderid;?>').addClass('blink');
		                    }

		                }, 1000);
		            $(document).ready(function(){
		                // timeleft 
                        //var dateset = '<?php echo $order['o_deadline'];?>';
                        var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                        var deadline_time = moment.tz($('#o_deadline').text(),'UTC');
                        var dateset = deadline_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm:ss');
		                $('#timeleft<?php echo $orderid;?>').countdown(dateset, function(event) {
		                        //$(this).html(event.strftime('%d days %H:%M:%S'));
		                        $(this).html(event.strftime('%-D day%!D %H:%M:%S'));
		                    });

		                if($('#timeleft<?php echo $orderid;?>').text()=="00 days 00:00:00")
		                {
		                    $('#timeleft<?php echo $orderid;?>').removeClass('blink');
		                }
		            });

		        </script>
               
                <?php
                }
                ?> - Overview</h3>		
                <div class="row w-100 mx-0 d-flex justify-content-center mt-4">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                            <th scope="col">Customer remarks interior</th>
                            <th scope="col">Customer remarks exterior</th>
                            <th scope="col">Operator remarks interior</th>
                            <th scope="col">Operator remarks exterior</th>
                            <th scope="col">Environment_address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo (!empty($order['clients-extras']))?"<div style=\"color:red;\">".$order['clients-extras']."</div>":"NONE"; ?></th>
                                <td><?php echo (!empty($order['client_extras_ex_b5']))?"<div style=\"color:red;\">".$order['client_extras_ex_b5']."</div>":"NONE"; ?></td>
                                <td><?php echo (!empty($order['op-remarks']))?"<div style=\"color:red;\">".$order['op-remarks']."</div>":"NONE"; ?></td>
                                <td><?php echo (!empty($order['op_remarks_ex_b5']))?"<div style=\"color:red;\">".$order['op_remarks_ex_b5']."</div>":"NONE"; ?></td>
                                <td><?php echo (!empty($order['environment_address']))?"<div style=\"color:red;\">".$order['environment_address']."</div>":"NONE"; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="row w-100 mx-0 border-top border-bottom">
                    <div class="col-lg-2 col-md-6 col-12 offset-lg-1 border-right border-left px-0">
                        <h6 class="w-100 text-center mb-0 border-bottom">Customer remarks interior</h6>
                        <p class="w-100 text-center mb-0"><?php echo (!empty($order['clients-extras']))?"<div style=\"color:red;\">".$order['clients-extras']."</div>":"NONE"; ?></p>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12 border-right px-0">
                        <h6 class="w-100 text-center mb-0 border-bottom">Customer remarks exterior</h6>
                        <p class="w-100 text-center mb-0"><?php echo (!empty($order['client_extras_ex_b5']))?"<div style=\"color:red;\">".$order['client_extras_ex_b5']."</div>":"NONE"; ?></p> 
                    </div>
                    <div class="col-lg-2 col-md-6 col-12 border-right px-0">
                        <h6 class="w-100 text-center mb-0 border-bottom">Operator remarks interior</h6>
                        <p class="w-100 text-center mb-0"><?php echo (!empty($order['op-remarks']))?"<div style=\"color:red;\">".$order['op-remarks']."</div>":"NONE"; ?></p>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12 border-right px-0">
                        <h6 class="w-100 text-center mb-0 border-bottom">Operator remarks exterior</h6>
                        <p class="w-100 text-center mb-0"><?php echo (!empty($order['op_remarks_ex_b5']))?"<div style=\"color:red;\">".$order['op_remarks_ex_b5']."</div>":"NONE"; ?></p>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12 px-0 border-right">
                        <h6 class="w-100 text-center mb-0 border-bottom">Environment_address</h6>
                        <p class="w-100 text-center mb-0"><?php echo (!empty($order['environment_address']))?"<div style=\"color:red;\">".$order['environment_address']."</div>":"NONE"; ?></p>
                    </div>
                </div>					 -->
				<!-- <div class="row w-100 mx-0 my-1 mt-4 border-top"><div class="col-md-12"><b class="w-100 text-center">Customer remarks interior</b></div></div>
				<div class="row w-100 mx-0 border-bottom text-left pl-5 mb-3"><div class="col-md-12 text-center"><?php echo (!empty($order['clients-extras']))?"<div style=\"color:red;\">".$order['clients-extras']."</div>":"NONE"; ?></div></div>
				<div class="row w-100 mx-0 my-1"><div class="col-md-12"><b class="w-100 text-center">Customer remarks exterior</b></div></div>
				<div class="row w-100 mx-0 border-bottom text-left pl-5 mb-3"><div class="col-md-12 text-center"><?php echo (!empty($order['client_extras_ex_b5']))?"<div style=\"color:red;\">".$order['client_extras_ex_b5']."</div>":"NONE"; ?></div></div>
				<div class="row w-100 mx-0 my-1"><div class="col-md-12"><b class="w-100 text-center">Operator remarks interior</b></div></div>
				<div class="row w-100 mx-0 border-bottom text-left pl-5 mb-3"><div class="col-md-12 text-center"><?php echo (!empty($order['op-remarks']))?"<div style=\"color:red;\">".$order['op-remarks']."</div>":"NONE"; ?></div></div>
				<div class="row w-100 mx-0 my-1"><div class="col-md-12"><b class="w-100 text-center">Operator remarks exterior</b></div></div>
				<div class="row w-100 mx-0 border-bottom text-left pl-5 mb-3"><div class="col-md-12 text-center"><?php echo (!empty($order['op_remarks_ex_b5']))?"<div style=\"color:red;\">".$order['op_remarks_ex_b5']."</div>":"NONE"; ?></div></div>
				<div class="row w-100 mx-0 my-1"><div class="col-md-12"><b class="w-100 text-center">Environment_address</b></div></div>
				<div class="row w-100 mx-0 border-bottom text-left pl-5 mb-3"><div class="col-md-12 text-center"><?php echo (!empty($order['environment_address']))?"<div style=\"color:red;\">".$order['environment_address']."</div>":"NONE"; ?></div></div>	 -->
				</div>
				<br >			
				<div class="right_container">				
					<div class="row w-100 mx-0">
						<div class="col-md-3 offset-5 d-flex justify-content-center border p-3 bg-light">
                            <b class="mr-2">Customer files:</b> 
                            <a id="show_btn" href="#hidden_customer_files" class="btn btn-sm btn-danger collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="hidden_customer_files">Show</a>
                        </div>
					</div>
                        <script type="text/javascript">
                        $('#show_btn').click(function() {
                            //$(this).text('Show');
                        if($('#hidden_customer_files').is(':visible')){
                            $(this).text('Show');
                        }else{
                            $(this).text('Hide');
                        }
                        });
                        </script>
					<div id="hidden_customer_files" class="collapse border border-top-0 border-dark" aria-expanded="false">
						<?php
						$customer_files=$prod->get_customer_files($orderid);
						?>
						<div class="row w-100 mx-0 mt-4 border-top border-dark">
							<div class="col-md-3 border-right border-dark">
								<b>File name</b>
							</div>
							<div class="col-md-2">
								&nbsp;
							</div>
							<div class="col-md-2 border-right border-dark">
								<b>Note</b>
							</div>
							<div class="col-md-3">
								<b>Sub-title</b>
							</div>
						</div>
						<?php
                        //print_r($myproducts);
						for($j=0;$j<count($myproducts);$j++)
						{
							$new_subid=substr($myproducts[$j]['osub_id'],1);
							if(empty($new_subid))
							{
								$new_subid=$myproducts[$j]['osub_id'];
							}
								
						for($i=0;$i<count($customer_files);$i++)
						{					
							if($new_subid!=$old_subid)
							{
                                
							if($customer_files[$i]['of_position']==$new_subid)
							{
								
							$validextensions = array("jpeg", "jpg", "png");
							?>
							<div class="row colorline w-100 mx-0 border-top border-dark">
								<div class="col-md-3 ellipsis border-right border-dark d-flex justify-content-center">
									<span class="align-self-center" title="<?php echo $customer_files[$i]['of_name_client']; ?>"><?php echo $customer_files[$i]['of_name_client']; ?></span>
								</div>
								<div class="col-md-2">
									<?php
									$tempfile=explode(".",$customer_files[$i]['of_name_client']);
									$file_extension=strtolower(end($tempfile));
									
									if($file_extension=="pdf")
									{
									?>
									<img class="img-responsive" style="width:40px;cursor:pointer;" src="img/adobe-pdf-icon.png" alt="pdf file" >
									<?php
									}
									else
									{
									?>
									<div id="image_tooltip_container_<?php 
									if(in_array($customer_files[$i]['of_type_dom'],$validextensions))
									{
									echo $image_preview_counter;
									} 	 
									?>">									
									<img class="img-responsive" style="width:80px;cursor:pointer;" src="client_files/<?php echo $customer_files[$i]['of_path_dom'].$customer_files[$i]['of_internal_name_dom']; ?>" alt="<?php echo $customer_files[$i]['of_name_client']; ?>" >
									</div>
									<?php						
									if(in_array($customer_files[$i]['of_type_dom'],$validextensions))
									{
									?>
									<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
										<img class="img-responsive" style="width:900px" src="client_files/<?php echo $customer_files[$i]['of_path_dom'].$customer_files[$i]['of_internal_name_dom']; ?>" alt="<?php echo $customer_files[$i]['of_name_client']; ?>" >
									</div>
                                    
									<?php 
									}
									}
									?>
								</div>
								<div class="col-md-2 border-right border-dark d-flex justify-content-center">
                                    <p class="mb-0 align-self-center">
                                        <?php 
                                            $note=$customer_files[$i]['of_kind']; 
                                            if($note==1)
                                            {
                                                echo "Order! Floorplan/-s";
                                            }
                                            if($note==2)
                                            {
                                                echo "Outview-Photo";
                                            }
                                            if($note==8)
                                            {
                                                echo "NO ORDER! Only for understanding";
                                            }
                                           
                                        ?>
                                    </p>
								</div>
								<div class="col-md-3">
								<?php
								if($customer_files[$i]['of_subtitle']!="")
								{
									echo $customer_files[$i]['of_subtitle']; 
								}
								else
								{
									echo "&nbsp;";
								}
								?>
								</div>
								<div class="col-md-1 d-flex justify-content-center">
									<a href="image.php?filecategory=customerfiles&orderid=<?php echo $orderid; ?>&imageid=<?php echo $customer_files[$i]['of_id']; ?>" class="btn btn-primary btn-sm align-self-center" target="_blank">Download</a>
								</div>
							</div>
							<?php
							$image_preview_counter++;
							$old_subid=$new_subid;
                            }				
                        }		
                         
                        }
                    }

                    //showning no order files          
								
                    for($i=0;$i<count($customer_files);$i++)
                    {					                       
                        if(($customer_files[$i]['of_kind']==8)||($customer_files[$i]['of_kind']==2))
                        {
                            
                        $validextensions = array("jpeg", "jpg", "png");
                        ?>
                        <div class="row colorline border-top border-dark w-100 mx-0">
                            <div class="col-md-3 ellipsis d-flex justify-content-center border-right border-dark">
                                <span class="align-selft-center" title="<?php echo $customer_files[$i]['of_name_client']; ?>"><?php echo $customer_files[$i]['of_name_client']; ?></span>
                            </div>
                            <div class="col-md-2">
                                <?php
                                $tempfile=explode(".",$customer_files[$i]['of_name_client']);
                                $file_extension=strtolower(end($tempfile));
                                
                                if($file_extension=="pdf")
                                {
                                ?>
                                <img class="img-responsive" style="width:40px;cursor:pointer;" src="img/adobe-pdf-icon.png" alt="pdf file" >
                                <?php
                                }
                                else
                                {
                                ?>
                                <div id="image_tooltip_container_<?php 
                                if(in_array($customer_files[$i]['of_type_dom'],$validextensions))
                                {
                                echo $image_preview_counter;
                                } 	 
                                ?>">									
                                <img class="img-responsive" style="width:80px;cursor:pointer;" src="client_files/<?php echo $customer_files[$i]['of_path_dom'].$customer_files[$i]['of_internal_name_dom']; ?>" alt="<?php echo $customer_files[$i]['of_name_client']; ?>" >
                                </div>
                                <?php						
                                if(in_array($customer_files[$i]['of_type_dom'],$validextensions))
                                {
                                ?>
                                <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                    <img class="img-responsive" style="width:900px" src="client_files/<?php echo $customer_files[$i]['of_path_dom'].$customer_files[$i]['of_internal_name_dom']; ?>" alt="<?php echo $customer_files[$i]['of_name_client']; ?>" >
                                </div>
                                <?php 
                                }
                                }
                                ?>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center border-right border-dark">
                                <p class="mb-0 align-self-center">
                                <?php 
                                    $note=$customer_files[$i]['of_kind']; 
                                    if($note==1)
                                    {
                                        echo "Order! Floorplan/-s";
                                    }
                                    if($note==2)
                                    {
                                        echo "Outview-Photo";
                                    } 
                                    if($note==8)
                                    {
                                        echo "NO ORDER! Only for understanding";
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-3">
                            <?php
                            if($customer_files[$i]['of_subtitle']!="")
                            {
                                echo $customer_files[$i]['of_subtitle']; 
                            }
                            else
                            {
                                echo "&nbsp;";
                            }
                            ?>
                            </div>
                            <div class="col-md-1 d-flex justify-content-center">
                                <a href="image.php?filecategory=customerfiles&orderid=<?php echo $orderid; ?>&imageid=<?php echo $customer_files[$i]['of_id']; ?>" class="btn btn-primary btn-sm align-self-center" target="_blank">Download</a>
                            </div>
                        </div>
                        <?php
                        $image_preview_counter++;
                   
                        }				
            
                    }
                
				?>
					</div> <!-- hidden customer files -->
				</div>	
				<div class="clear"></div>
				
				<br>
				<hr>
				<br>
                <?php 
                $allstatus=$prod->showallstatus();

                $count_exterior_products=0;
                $count_interior_products=0;
                
                //print_r($myproducts);

                for($j=0;$j<count($myproducts);$j++)
                {
                    //echo substr($myproducts[$j]['prod_id'],1);
                    if((substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||(substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||(substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||(substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900))
                    {
                        
                        $count_exterior_products++;
                    }
                }

                for($j=0;$j<count($myproducts);$j++)
                {
                    
                    if((substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||(substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||(substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||(substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||(substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860))
                    {
                        //echo substr($myproducts[$j]['prod_id'],1);
                        $count_interior_products++;
                    }
                }
                ?>
				<div class="row w-100 mx-0">
					<p class="w-100 text-center"><b>Assigned tasks</b></p>
				</div>						
				<!--<div class="row w-100 mx-0 border-top border-bottom border-dark">
					<div class="col-md-3 border-right border-dark">
						<p class="w-100 text-center"><b>Order id + Description</b></p>
					</div>
					<div class="col-md-4">
						<p class="text-center w-100"><b>Status</b></p>
					</div>
					<div class="col-md-2">
					<b></b>
					</div>					
				</div> -->
                <?php
                if($count_interior_products>0)
                {
                    $column_count=0;
                ?>
                <div class="row w-100 mx-0 interiordetails my-2 interior">
                    <div class="row w-100 mx-0 py-2"> 
                        <div class="col-12 my-2 col-lg-4" style="border-bottom:2px solid #000;">
                    <?php
                    for($i=0;$i<count($myproducts);$i++)
                    {
                        if((substr($myproducts[$i]['prod_id'],1)>1300)&&(substr($myproducts[$i]['prod_id'],1)<1360)||(substr($myproducts[$i]['prod_id'],1)>1500)&&(substr($myproducts[$i]['prod_id'],1)<1560)||(substr($myproducts[$i]['prod_id'],1)>1599)&&(substr($myproducts[$i]['prod_id'],1)<1660)||(substr($myproducts[$i]['prod_id'],1)>1699)&&(substr($myproducts[$i]['prod_id'],1)<1760)||(substr($myproducts[$i]['prod_id'],1)>1799)&&(substr($myproducts[$i]['prod_id'],1)<1860))
                        {
                        $product=$prod->get_product($myproducts[$i]['prod_id']);

                        if(($column_count>0)&&($myproducts[$i-1]['osub_id']!=$myproducts[$i]['osub_id']))
                        {
                            $column_count++;
                            ?>
                            </div> <!-- end column -->
                            <div class="col-12 my-2 col-lg-4" style="border-bottom:2px solid #000;">
                            <?php
                        }
                    ?>
                            <div class="row w-100 mx-0 pb-2 mb-2 <?php 
                            for($k=0;$k<count($allstatus);$k++)
							{
								if($allstatus[$k]['ost_id']==$myproducts[$i]['p_status'])
								{
									echo $allstatus[$k]['ost_color'];
								}
							}
                            ?>" id="task<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong><?php echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];?></strong></p>
                                        <b><?php
                                        $customer_files=$prod->get_customer_files($orderid);
                                            
                                        for($j=0;$j<count($customer_files);$j++)
                                        {     
                                            if($customer_files[$j]['of_position']==substr($myproducts[$i]['osub_id'],1))
                                            {
                                                echo $customer_files[$j]['of_level']." ".$customer_files[$j]['of_name'];
                                            }
                                        }?></b>
                                        <p class="housemodel mb-0"><?php echo $product['prod_name'];?></p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b><?php
                                            for($j=1;$j<count($allstatus);$j++)
                                            {
                                                if($allstatus[$j]['ost_id']==$myproducts[$i]['p_status'])
                                                {
                                                    echo ucfirst($allstatus[$j]['ost_name']);
                                                }
                                            }?></b>
                                            <select class="form-control form-control-sm" id="product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                            <script type="text/javascript">
                                                $('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').on("change",function(){
                                                    $.ajax({
                                                    url: "../ajax/change_product_status.php",
                                                    method: "get",
                                                    data: {o_id:<?php echo $orderid;?>,osub_id:"<?php echo $myproducts[$i]['osub_id'];?>",prod_id:"<?php echo $myproducts[$i]['prod_id'];?>",p_status:$(this).val()},
                                                    dataType:"html",
                                                    success:function(data) {
                                                        console.log(data);
                                                        var status=$('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').val();
                                                        
                                                        var clasa=$('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?> option:selected').data('status');
                                                        console.log($('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?> option:selected').data('status'));
                                                        $('#task<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 pb-2 mb-2 '+clasa);
   
                                                    }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: <?php echo $labc=$prod->calculateProductlabc_by_orderid($myproducts[$i]['prod_id'],$orderid);?></p>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="taskdetails.php?o_id=<?php echo $orderid; ?>&osub_id=<?php echo $myproducts[$i]['osub_id']; ?>&prod_id=<?php echo $myproducts[$i]['prod_id']; ?>" class="btn btn-sm btn-primary">Details</a>
                                </div>
                                <?php
                                $thisfileresults=$prod->show_results($orderid,$myproducts[$i]['osub_id'],$myproducts[$i]['prod_id']);

                                if(count($thisfileresults)>0)
                                {
                                ?>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#results<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>" aria-expanded="false" aria-controls="results<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>">Result file for <?php echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];?> <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="results<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>">
                                <?php
                                
					
                                for($k=0;$k<count($thisfileresults);$k++)
                                {
                                ?>
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark"><?php echo $thisfileresults[$k]['orf_name'];?></div>
                                        <div class="col-4 px-0">
                                        <?php
                                        if(in_array($thisfileresults[$k]['orf_type_dom'],$validextensions))
                                        {
                                        ?>
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/<?php echo $thisfileresults[$k]['orf_thumbnail_path'];?>" alt="<?php echo $thisfileresults[$k]['orf_name'];?>">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=<?php echo $thisfileresults[$k]['orf_id'];?>" target="_blank">Download</a>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <p class="w-100 text-center bg-danger mt-2">No result files for <?php echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];?></p>
                                <?php
                                }
                                ?>
                            </div>
                    <?php
                        $column_count++;
                        }
                    }
                    ?>
                            <!--<div class="row w-100 mx-0 dark-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N0" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N0">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!--<div class="row w-100 mx-0 orange pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N011" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N011">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> -->
                        <!--<div class="col-12 my-2 col-lg-4"  style="border-bottom:2px solid #000;">
                            <div class="row w-100 mx-0 light-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 dark-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N0" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N0">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 orange pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N011" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N011">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 my-2 col-lg-4"  style="border-bottom:2px solid #000;">
                            <div class="row w-100 mx-0 light-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 dark-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N0" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N0">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 orange pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N011" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N011">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 orange pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.n01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N011" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N011">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end interior or exterior -->
            <?php
            } //end interior

           
            if($count_exterior_products>0)
            {
                $column_count=0;
                ?>
                <div class="row w-100 mx-0 exteriordetails my-2 exterior">
                    <div class="row w-100 mx-0 py-2"> 
                        <div class="col-12 my-2 col-lg-4" style="border-bottom:2px solid #000;">
                    <?php
                    for($i=0;$i<count($myproducts);$i++)
                    {
                        if((substr($myproducts[$i]['prod_id'],1)>1559)&&(substr($myproducts[$i]['prod_id'],1)<1600)||(substr($myproducts[$i]['prod_id'],1)>1659)&&(substr($myproducts[$i]['prod_id'],1)<1700)||(substr($myproducts[$i]['prod_id'],1)>1759)&&(substr($myproducts[$i]['prod_id'],1)<1800)||(substr($myproducts[$i]['prod_id'],1)>1859)&&(substr($myproducts[$i]['prod_id'],1)<1900))
                        {
                        $product=$prod->get_product($myproducts[$i]['prod_id']);

                        if(($column_count>0)&&($myproducts[$i-1]['osub_id']!=$myproducts[$i]['osub_id']))
                        {
                            $column_count++;
                            ?>
                            </div> <!-- end column -->
                            <div class="col-12 my-2 col-lg-4" style="border-bottom:2px solid #000;">
                            <?php
                        }
                    ?>
                            <div class="row w-100 mx-0 pb-2 mb-2 <?php 
                            for($k=0;$k<count($allstatus);$k++)
							{
								if($allstatus[$k]['ost_id']==$myproducts[$i]['p_status'])
								{
									echo $allstatus[$k]['ost_color'];
								}
							}
                            ?>" id="task<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong><?php echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];?></strong></p>
                                        <b><?php
                                        $customer_files=$prod->get_customer_files($orderid);
                                            
                                        for($j=0;$j<count($customer_files);$j++)
                                        {     
                                            if($customer_files[$j]['of_position']==substr($myproducts[$i]['osub_id'],1))
                                            {
                                                echo $customer_files[$j]['of_level']." ".$customer_files[$j]['of_name'];
                                            }
                                        }?></b>
                                        <p class="housemodel mb-0"><?php echo $product['prod_name'];?></p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b><?php
                                            for($j=1;$j<count($allstatus);$j++)
                                            {
                                                if($allstatus[$j]['ost_id']==$myproducts[$i]['p_status'])
                                                {
                                                    echo ucfirst($allstatus[$j]['ost_name']);
                                                }
                                            }?></b>
                                            <select class="form-control form-control-sm" id="product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                            <script type="text/javascript">
                                                $('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').on("change",function(){
                                                    $.ajax({
                                                    url: "../ajax/change_product_status.php",
                                                    method: "get",
                                                    data: {o_id:<?php echo $orderid;?>,osub_id:"<?php echo $myproducts[$i]['osub_id'];?>",prod_id:"<?php echo $myproducts[$i]['prod_id'];?>",p_status:$(this).val()},
                                                    dataType:"html",
                                                    success:function(data) {
                                                        console.log(data);
                                                        var status=$('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').val();
                                                        
                                                        var clasa=$('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?> option:selected').data('status');
                                                        console.log($('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?> option:selected').data('status'));
                                                        $('#task<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 pb-2 mb-2 '+clasa);
   
                                                    }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: <?php echo $labc=$prod->calculateProductlabc_by_orderid($myproducts[$i]['prod_id'],$orderid);?></p>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="taskdetails.php?o_id=<?php echo $orderid; ?>&osub_id=<?php echo $myproducts[$i]['osub_id']; ?>&prod_id=<?php echo $myproducts[$i]['prod_id']; ?>" class="btn btn-sm btn-primary">Details</a>
                                </div>
                                <?php
                                $thisfileresults=$prod->show_results($orderid,$myproducts[$i]['osub_id'],$myproducts[$i]['prod_id']);

                                if(count($thisfileresults)>0)
                                {
                                ?>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#results<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>" aria-expanded="false" aria-controls="results<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>">Result file for <?php echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];?> <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="results<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>">
                                <?php
                                
					
                                for($k=0;$k<count($thisfileresults);$k++)
                                {
                                ?>
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark"><?php echo $thisfileresults[$k]['orf_name'];?></div>
                                        <div class="col-4 px-0">
                                        <?php
                                        if(in_array($thisfileresults[$k]['orf_type_dom'],$validextensions))
                                        {
                                        ?>
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/<?php echo $thisfileresults[$k]['orf_thumbnail_path'];?>" alt="<?php echo $thisfileresults[$k]['orf_name'];?>">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=<?php echo $thisfileresults[$k]['orf_id'];?>" target="_blank">Download</a>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <p class="w-100 text-center bg-danger mt-2">No result files for <?php echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];?></p>
                                <?php
                                }
                                ?>
                            </div>
                    <?php
                        $column_count++;
                        }
                    }
                    ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end interior or exterior -->
            <?php
            } //end exterior
            ?>
                <!-- <div class="row w-100 mx-0 interiordetails my-2 exterior">
                    <div class="row w-100 mx-0 py-2">
                        <div class="col-12 my-2 col-lg-4"  style="border-bottom:2px solid #000;">
                            <div class="row w-100 mx-0 light-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 dark-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N0" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N0">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 orange pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div> -->
                                <!-- <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N011" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                
                                <div class="collapse w-100" id="filesProject1N011">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <p class="w-100 text-center bg-danger mt-2">No result files for 994.x01.p1860</p> 
                            </div>
                        </div>
                        <div class="col-12 my-2 col-lg-4"  style="border-bottom:2px solid #000;">
                            <div class="row w-100 mx-0 light-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 dark-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N0" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N0">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 orange pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N011" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N011">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 light-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 my-2 col-lg-4"  style="border-bottom:2px solid #000;">
                            <div class="row w-100 mx-0 light-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 dark-green pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N0" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N0">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 orange pb-2 mb-2" id="projectDetailsN01">
                                <div class="col-4 my-1 text-center px-0">
                                    <div class="file-name p-2 bg-light text-dark" style="font-size: 13px;">
                                        <p class="text-danger mb-0"><strong>1243.x01.p1600</strong></p>
                                        <b>L 01 Top4-OG</b>
                                        <p class="housemodel mb-0">b6_in_wall_model</p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p class="w-100 text-center mb-0">Status:</p>
                                    <div class="row w-100 mx-0">
                                        <div class="col-12 px-0">
                                            <b>Work could Start</b>
                                            <select class="form-control form-control-sm" id="product_status1237_n01_p1621" name="product_status">
							                    <option>-- Change --</option>
												<option value="4" data-status="dark-green">Work can start</option>	
												<option value="6.1" data-status="brown">At work</option>	
												<option value="7" data-status="orange">Checkable</option>	
												<option value="13" data-status="red">Can not do that</option>	
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-0">Labc: 40</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-primary">Details</button>
                                </div>
                                <button class="btn mx-auto rounded-0 btn-dark mt-2" type="button" data-toggle="collapse" data-target="#filesProject1N011" aria-expanded="false" aria-controls="filesProject1">Result file for 994.x01.p1860 <i class="fas fa-chevron-down ml-2"></i></button>
                                <div class="collapse w-100" id="filesProject1N011">
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom">
                                        <div class="col-5 px-0 text-dark">994.x01.p1863 - 1.jpg</div>
                                        <div class="col-4 px-0">
                                            <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/2019/994/994.x01.p1863/c1d9897124c290d35e9c9706649ee7645f98d2df.jpg_thumb.jpg" alt="994.x01.p1863 - 1.jpg">
                                        </div>
                                        <div class="col-3 px-0">
                                            <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&amp;orfid=13262" alt="" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
				<?php
				/*
				for($i=0;$i<count($myproducts);$i++)
				{
					//$status=$prod->check_assigned_status($orderid,$myproducts[$i]['osub_id'],$myproducts[$i]['prod_id']);
					
					$product=$prod->get_product($myproducts[$i]['prod_id']);
					?>
					<div class="assigned_task">
					<br >
					<a name="task<?php echo $i;?>"></a>
					<div id="task<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>" class="row w-100 mx-0 <?php
						
						// if($licenceid=="04903")
						// {
						// 	for($k=0;$k<count($allstatus);$k++)
						// 	{
						// 		if($allstatus[$k]['ost_id']==$myproducts[$i]['p_status'])
						// 		{
						// 			echo $allstatus[$k]['ost_color'];
						// 		}
						// 	}
						// }
						
						// if($licenceid!="04903")
						// {
							for($k=0;$k<count($allstatus);$k++)
							{
								if($allstatus[$k]['ost_id']==$myproducts[$i]['p_status'])
								{
									echo $allstatus[$k]['ost_color'];
								}
							}
						//}
							?>">
					<div class="col-md-3">
                        <p class="w-100 text-center mb-0 py-2">
                            <?php
                            if($order['om_id']==0)
                            { 
                                echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];
                            }
                            else
                            {
                                echo $order['om_id'].".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'].".".$orderid;
                            }

                            $customer_files=$prod->get_customer_files($orderid);
                                            
                            for($j=0;$j<count($customer_files);$j++)
                            {
                                
                                if($customer_files[$j]['of_position']==substr($myproducts[$i]['osub_id'],1))
                                {
                                    echo " <b>".$customer_files[$j]['of_level']." ".$customer_files[$j]['of_name']."</b>";
                                }
                            }
                            echo " ".$product['prod_name']; ?>

                        </p>
					</div>
					<div class="col-md-5">
						<div class="form-inline d-flex justify-content-center">
                            <p class="mb-0 w-100 text-center">Status:</p>
                            <b class="pr-1"><?php
							for($j=1;$j<count($allstatus);$j++)
							{
								if($allstatus[$j]['ost_id']==$myproducts[$i]['p_status'])
								{
									echo ucfirst($allstatus[$j]['ost_name']);
								}
							}
							?></b>
							<select class="form-control form-control-sm" id="product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>" name="product_status" <?php 
							
							echo ($myproducts[$i]['p_status']==8)?"disabled":"";
							
							$prod_501_status=$prod->check_assigned_status($orderid,$myproducts[$i]['osub_id'],"p1501");
							$prod_521_status=$prod->check_assigned_status($orderid,$myproducts[$i]['osub_id'],"p1521");
							$prod_541_status=$prod->check_assigned_status($orderid,$myproducts[$i]['osub_id'],"p1541");
							
							if((substr($myproducts[$i]['prod_id'],1)>1501)&&(substr($myproducts[$i]['prod_id'],1)<1508)&&($prod_501_status['p_status']!=8))
							{
								echo "disabled";
							}
							
							if((substr($myproducts[$i]['prod_id'],1)>1521)&&(substr($myproducts[$i]['prod_id'],1)<1528)&&($prod_521_status['p_status']!=8))
							{
								echo "disabled";
							}
							
							if((substr($myproducts[$i]['prod_id'],1)>1541)&&(substr($myproducts[$i]['prod_id'],1)<1548)&&($prod_541_status['p_status']!=8))
							{
								echo "disabled";
							}
							?>>
							<option>-- Change --</option>
								<?php 
								for($j=1;$j<count($allstatus);$j++)
								{
									if(($allstatus[$j]['ost_id']==4)||($allstatus[$j]['ost_id']==7)||($allstatus[$j]['ost_id']==6.1)||($allstatus[$j]['ost_id']==13))
									{
									?>
									<option value="<?php echo $allstatus[$j]['ost_id'];?>" data-status="<?php echo $allstatus[$j]['ost_color'];?>" <?php echo ($allstatus[$j]['ost_id']==$myproducts[$i]['p_status'])?"selected":"";?>><?php echo ucfirst($allstatus[$j]['ost_name']);?></option>	
									<?php
									}
								}
								?>
							</select>
                            <script type="text/javascript">
                                $('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').on("change",function(){
                                    $.ajax({
                                    url: "../ajax/change_product_status.php",
                                    method: "get",
                                    data: {o_id:<?php echo $orderid;?>,osub_id:"<?php echo $myproducts[$i]['osub_id'];?>",prod_id:"<?php echo $myproducts[$i]['prod_id'];?>",p_status:$(this).val()},
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);
                                        var status=$('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').val();
                                        
                                        // for(i=1;i<13;i++)
                                        // {
                                        //     if(status==i)
                                        //     {
                                                var clasa=$('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?> option:selected').data('status');
                                                console.log($('#product_status<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?> option:selected').data('status'));
                                                $('#task<?php echo $orderid."_".$myproducts[$i]['osub_id']."_".$myproducts[$i]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 '+clasa);
                                        //     }
                                        // }
                                        
                                    }
                                    });
                                });
                            </script>
						</div>		
					</div>
					<div class="col-md-2">
						<a class="btn btn-sm btn-primary mt-3" href="taskdetails.php?o_id=<?php echo $orderid; ?>&osub_id=<?php echo $myproducts[$i]['osub_id']; ?>&prod_id=<?php echo $myproducts[$i]['prod_id']; ?>">Details</a>
					</div>	
					<div class="col-md-1 pt-3">
						labc: <?php echo $labc=$prod->calculateProductlabc_by_orderid($myproducts[$i]['prod_id'],$orderid);?>
					</div>					
				</div> <!-- end row color -->
				
				<div style="background-color:#f0f0f0;">					
					<div class="row w-100 mx-0">
						<p class="text-center w-100 mb-0"><b>Result file for <?php echo $orderid.".".$myproducts[$i]['osub_id'].".".$myproducts[$i]['prod_id'];?></b></p>
					</div>
					
					<?php 
					$thisfileresults=$prod->show_results($orderid,$myproducts[$i]['osub_id'],$myproducts[$i]['prod_id']);
					
					
					for($k=0;$k<count($thisfileresults);$k++)
					{
						?>
						<div class="row w-100 mx-0 py-2 border-bottom border-dark">
							<div class="offset-3 col-md-3 ellipsis">
								<div id="image_tooltip_container_<?php
								if(in_array($thisfileresults[$k]['orf_type_dom'],$validextensions))
								{
									echo $image_preview_counter;
								}
								?>"><?php 
								echo $thisfileresults[$k]['orf_name'];
								?></div>
							</div>
                            <div class="col-md-2">
                                <?php
                                if($thisfileresults[$k]['orf_type_dom']=="pdf")
                                {
                                ?>
                                <img class="img-responsive" style="width:80px;cursor:pointer;" src="img/adobe-pdf-icon.png" alt="pdf file" >
                                <?php
                                }
                                if(in_array($thisfileresults[$k]['orf_type_dom'],$validextensions))
                                {
                                ?>
                                <!--<img class="img-responsive" style="width:80px;height:auto;" src="result_files/<?php echo $thisfileresults[$k]['orf_path_dom'].$thisfileresults[$k]['orf_internal_name_dom']; ?>" alt="<?php echo $thisfileresults[$k]['orf_name'];?>"> -->
                                <img class="img-responsive" style="width:80px;height:auto;" src="result_thumbnail_files/<?php echo $thisfileresults[$k]['orf_thumbnail_path'];?>" alt="<?php echo $thisfileresults[$k]['orf_name'];?>">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-2">
								<a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&orfid=<?php echo $thisfileresults[$k]['orf_id'];?>" alt="<?php echo $results[$j]['orf_name'];?>" target="_blank">Download</a>
								<?php 
											
							if(in_array($thisfileresults[$k]['orf_type_dom'],$validextensions))
							{
							?>
							<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
								<img class="img-responsive" style="width:900px;height:auto;" src="result_files/<?php echo $thisfileresults[$k]['orf_path_dom'].$thisfileresults[$k]['orf_internal_name_dom']; ?>" alt="<?php echo $thisfileresults[$k]['orf_name'];?>">
							</div>
							<?php 
							}
							?>
                            </div>
						</div>
						<?php
						$image_preview_counter++;
					}
					?>
					
					
					</div> <!-- end assigned tasks -->
				</div>
				
			<?php
				
                } 
			?>
				<br >
				<div class="finished_tasks">
				
				</div>	
				<!-- <script type="text/javascript" src="js/move_finished_tasks.js"></script> -->
				*/ ?>
					
						<!-- <div class="row">
							<div class="col-md-2">
								<strong>Result files:</strong>
							</div> 
						</div>-->
						<div class="row w-100 mx-0">
                            <p class="w-100 text-center mb-0"><b>All result files of this order so far:</b></p>
                            <hr width="350px">
						</div>	
						<br>
						<?php
						$b5_ex_results=$prod->get_b5_ex_ordered_results($orderid);					
						$b3_in_results=$prod->get_b3_in_ordered_results($orderid);					
						$b5_in_results=$prod->get_b5_in_ordered_results($orderid);
						?>
						<div class="row w-100 mx-0">
							<div class="col-md-6 px-0">
								<div class="row w-100 mx-0 border border-dark border-left-0">
									<div class="col-md-12" style="text-align:center;">
										<b>Interior</b>
									</div>
								</div>
								<div class="row w-100 mx-0 border-bottom border-dark">
									<div class="col-md-6 border-right border-dark" style="text-align:center;">
										<b>Raw files</b>
									</div>
									<div class="col-md-6 border-right border-dark" style="text-align:center;">
										<b>Client files</b>
									</div>
								</div>
								<div class="row w-100 mx-0">
									<div class="col-md-6 px-0 border-right border-dark border-bottom">	
								
								<?php
								for($i=0;$i<count($b3_in_results);$i++)
								{
									if(($b3_in_results[$i]['prod_id']=="p1301")||($b3_in_results[$i]['prod_id']=="p1321"))
									{
								?>
								<div class="row colorline w-100 mx-0 border-bottom border-dark">
									<div class="col-md-8">
									<?php
									$product=$prod->get_product($b3_in_results[$i]['prod_id']);
									echo  $b3_in_results[$i]['o_id'].".".$b3_in_results[$i]['osub_id'].".".$b3_in_results[$i]['prod_id'];
									
									for($j=0;$j<count($customer_files);$j++)
									{
										
										if($customer_files[$j]['of_position']==substr($b3_in_results[$i]['osub_id'],1))
										{
                                            echo "<p class='mb-0'><b>".$customer_files[$j]['of_level']." ".$customer_files[$j]['of_name']."</b></p>";
										}
									}
									echo $product['prod_name'];
									?>
									</div>
									<!--<div class="col-md-2">
										<?php
										if(in_array($b3_in_results[$i]['orf_type_dom'],$validextensions))
										{
										?>
										<div id="image_tooltip_container_<?php									
											echo $image_preview_counter;										
										?>">
										<img class="img-responsive" style="width:60px;height:40px;cursor:pointer;" src="result_files/<?php echo $b3_in_results[$i]['orf_path_dom'].$b3_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b3_in_results[$i]['orf_name'];?>">										
										</div>
										<?php
										}
										?>
									</div>
									<div class="col-md-5">
										<?php echo $b3_in_results[$i]['orf_name'];?>
									</div>-->
									<div class="col-md-1 d-flex justify-content-center">							
										<a class="btn btn-sm align-self-center" href="image.php?filecategory=creatorfiles&orfid=<?php echo $b3_in_results[$i]['orf_id'];?>" alt="<?php echo $b3_in_results[$i]['orf_name'];?>" target="_blank"><img src="img/download-icon.png" alt="Download" style="width:35px;"></a>
									</div>
									<?php						
									if(in_array($b3_in_results[$i]['orf_type_dom'],$validextensions))
									{
									?>
										<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
											<img class="img-responsive" style="width:900px" src="result_files/<?php echo $b3_in_results[$i]['orf_path_dom'].$b3_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b3_in_results[$i]['orf_name'];?>">
										</div>
									<?php					 
									}
									?>
								</div>
								<?php
								}
								}
								
								
								for($i=0;$i<count($b5_in_results);$i++)
								{
									if(($b5_in_results[$i]['prod_id']=="p1501")||($b5_in_results[$i]['prod_id']=="p1521")||($b5_in_results[$i]['prod_id']=="p1541"))
									{
								?>
								<div class="row colorline w-100 mx-0 border-bottom border-dark">
									<div class="col-md-8">
									<?php
									$product=$prod->get_product($b5_in_results[$i]['prod_id']);
									echo $b5_in_results[$i]['o_id'].".".$b5_in_results[$i]['osub_id'].".".$b5_in_results[$i]['prod_id'] ;
									
									for($j=0;$j<count($customer_files);$j++)
									{
										
										if($customer_files[$j]['of_position']==substr($b5_in_results[$i]['osub_id'],1))
										{
											echo " <b>".$customer_files[$j]['of_level']." ".$customer_files[$j]['of_name']."</b>";
										}
									}
									
									echo "<br> ".$product['prod_name'];
									?>
									</div>
									<!--<div class="col-md-2">
										<?php
										if(in_array($b5_in_results[$i]['orf_type_dom'],$validextensions))
										{
										?>
										<div id="image_tooltip_container_<?php
											echo $image_preview_counter;										
										?>">
										<img class="img-responsive" style="width:60px;height:40px;cursor:pointer;" src="result_files/<?php echo $b5_in_results[$i]['orf_path_dom'].$b5_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_in_results[$i]['orf_name'];?>">										
										</div>
										<?php
										}
										?>
									</div>
									<div class="col-md-5">
										<?php echo $b5_in_results[$i]['orf_name'];?>
									</div>-->
									<div class="col-md-1">							
										<a class="btn btn-sm" href="image.php?filecategory=creatorfiles&orfid=<?php echo $b5_in_results[$i]['orf_id'];?>" alt="<?php echo $b5_in_results[$i]['orf_name'];?>" target="_blank"><img src="img/download-icon.png" alt="Download" style="width:35px;"></a>
									</div>
									<?php						
									if(in_array($b5_in_results[$i]['orf_type_dom'],$validextensions))
									{
									?>
										<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
											<img class="img-responsive" style="width:900px" src="result_files/<?php echo $b5_in_results[$i]['orf_path_dom'].$b5_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_in_results[$i]['orf_name'];?>">
										</div>
									<?php					 
									}
									?>
								</div>
								<?php
								}
								}
								?>
							</div>
							
							
							<div class="col-md-6 px-0 border-right border-dark border-bottom">
								<?php
								for($i=0;$i<count($b3_in_results);$i++)
								{
									if(($b3_in_results[$i]['prod_id']!="p1301")&&($b3_in_results[$i]['prod_id']!="p1321"))
									{
								?>
								<div class="row colorline w-100 mx-0 border-bottom border-dark">
									<div class="col-md-6">
									<?php
									$product=$prod->get_product($b3_in_results[$i]['prod_id']);
									echo $b3_in_results[$i]['o_id'].".".$b3_in_results[$i]['osub_id'].".".$b3_in_results[$i]['prod_id'];
									
									for($j=0;$j<count($customer_files);$j++)
									{
										
										if($customer_files[$j]['of_position']==substr($b3_in_results[$i]['osub_id'],1))
										{
											echo " <b>".$customer_files[$j]['of_level']." ".$customer_files[$j]['of_name']."</b>";
										}
									}
									echo "<br> ".$product['prod_name'];
									?>
									</div>
									<div class="col-md-3 d-flex">
										<?php
										if(in_array($b3_in_results[$i]['orf_type_dom'],$validextensions))
										{
										?>
										<div class="d-flex" id="image_tooltip_container_<?php									
											echo $image_preview_counter;										
										?>">
										<img class="img-responsive" style="width:60px;height:40px;cursor:pointer;" class="align-self-center" src="result_files/<?php echo $b3_in_results[$i]['orf_path_dom'].$b3_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b3_in_results[$i]['orf_name'];?>">										
										</div>
										<?php
										}
										?>
									</div>
									<!--<div class="col-md-5">
										<?php echo $b3_in_results[$i]['orf_name'];?>
									</div>-->
									<div class="col-md-1">							
										<a class="btn btn-sm" href="image.php?filecategory=creatorfiles&orfid=<?php echo $b3_in_results[$i]['orf_id'];?>" alt="<?php echo $b3_in_results[$i]['orf_name'];?>" target="_blank"><img src="img/download-icon.png" alt="Download" style="width:35px;"></a>
									</div>
									<?php						
									if(in_array($b3_in_results[$i]['orf_type_dom'],$validextensions))
									{
									?>
										<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
											<img class="img-responsive" style="width:900px" src="result_files/<?php echo $b3_in_results[$i]['orf_path_dom'].$b3_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b3_in_results[$i]['orf_name'];?>">
										</div>
									<?php					 
									}
									?>
								</div>
								<?php
								}
								}
								
								
								for($i=0;$i<count($b5_in_results);$i++)
								{
									if(($b5_in_results[$i]['prod_id']!="p1501")&&($b5_in_results[$i]['prod_id']!="p1521")&&($b5_in_results[$i]['prod_id']!="p1541"))
									{
								?>
								<div class="row colorline w-100 mx-0 border-bottom border-dark">
									<div class="col-md-6">
									<?php
									$product=$prod->get_product($b5_in_results[$i]['prod_id']);
									echo $b5_in_results[$i]['o_id'].".".$b5_in_results[$i]['osub_id'].".".$b5_in_results[$i]['prod_id'];
									
									for($j=0;$j<count($customer_files);$j++)
									{
										
										if($customer_files[$j]['of_position']==substr($b5_in_results[$i]['osub_id'],1))
										{
											echo " <b>".$customer_files[$j]['of_level']." ".$customer_files[$j]['of_name']."</b>";
										}
									}
									
									echo "<br> ".$product['prod_name'];
									?>
									</div>
									<div class="col-md-3 d-flex">
										<?php
										if(in_array($b5_in_results[$i]['orf_type_dom'],$validextensions))
										{
										?>
										<div class="d-flex" id="image_tooltip_container_<?php
											echo $image_preview_counter;										
										?>">
										<img class="img-responsive" style="width:60px;height:40px;cursor:pointer;" class="align-self-center" src="result_files/<?php echo $b5_in_results[$i]['orf_path_dom'].$b5_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_in_results[$i]['orf_name'];?>">										
										</div>
										<?php
										}
										?>
									</div>
									<!--<div class="col-md-5">
										<?php echo $b5_in_results[$i]['orf_name'];?>
									</div>-->
									<div class="col-md-1">							
										<a class="btn btn-sm" href="image.php?filecategory=creatorfiles&orfid=<?php echo $b5_in_results[$i]['orf_id'];?>" alt="<?php echo $b5_in_results[$i]['orf_name'];?>" target="_blank"><img src="img/download-icon.png" alt="Download" style="width:35px;"></a>
									</div>
									<?php						
									if(in_array($b5_in_results[$i]['orf_type_dom'],$validextensions))
									{
									?>
										<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
											<img class="img-responsive" style="width:900px" src="result_files/<?php echo $b5_in_results[$i]['orf_path_dom'].$b5_in_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_in_results[$i]['orf_name'];?>">
										</div>
									<?php					 
									}
									?>
								</div>
								<?php
								}
								}
								?>
								</div>
							</div>
							
							</div> <!-- end interior -->
							
							<div class="col-md-6">
								<div class="row w-100 mx-0 border border-dark">
									<div class="col-md-12" style="text-align:center;">
										<b>Exterior</b>
									</div>
								</div>
								<div class="row w-100 mx-0 border-bottom border-dark">
									<div class="col-md-6 border-right border-dark border-left">
										<b>Raw files</b>
									</div>
									<div class="col-md-6 border-right border-dark">
										<b>Client files</b>
									</div>
								</div>
								<div class="row w-100 mx-0">
									<div class="col-md-6 px-0 border-bottom border-dark border-right border-left">
								<?php
								for($i=0;$i<count($b5_ex_results);$i++)
								{
									if(($b5_ex_results[$i]['prod_id']=="p1561")||($b5_ex_results[$i]['prod_id']=="p1562"))
									{
								?>
								<div class="row w-100 mx-0 colorline border-bottom border-dark">
									<div class="col-md-8">
									<?php
									$product=$prod->get_product($b5_ex_results[$i]['prod_id']);
									
									echo $b5_ex_results[$i]['o_id'].".".$b5_ex_results[$i]['osub_id'].".".$b5_ex_results[$i]['prod_id'];
									
									for($j=0;$j<count($customer_files);$j++)
									{
										
										if($customer_files[$j]['of_position']==substr($b5_ex_results[$i]['osub_id'],1))
										{
											echo "<p class='mb-0'><b>".$customer_files[$j]['of_level']." ".$customer_files[$j]['of_name']."</b></p>";
										}
									}
									
									echo $product['prod_name'];
									?>
									</div>
									<!-- <div class="col-md-2">
										<?php
										if(in_array($b5_ex_results[$i]['orf_type_dom'],$validextensions))
										{
										?>
										<div id="image_tooltip_container_<?php
											echo $image_preview_counter;										
										?>">
										<img class="img-responsive" style="width:60px;height:40px;cursor:pointer;" src="result_files/<?php echo $b5_ex_results[$i]['orf_path_dom'].$b5_ex_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_ex_results[$i]['orf_name'];?>">										
										</div>
										<?php
										}
										?>
									</div>
									<div class="col-md-5">
										<?php echo $b5_ex_results[$i]['orf_name'];?>
									</div> -->
									<div class="col-md-1">							
										<a class="btn btn-sm" href="image.php?filecategory=creatorfiles&orfid=<?php echo $b5_ex_results[$i]['orf_id'];?>" alt="<?php echo $b5_ex_results[$i]['orf_name'];?>" target="_blank"><img src="img/download-icon.png" alt="Download" style="width:35px;"></a>
									</div>
									<?php						
									if(in_array($b5_ex_results[$i]['orf_type_dom'],$validextensions))
									{
									?>
										<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
											<img class="img-responsive" style="width:900px" src="result_files/<?php echo $b5_ex_results[$i]['orf_path_dom'].$b5_ex_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_ex_results[$i]['orf_name'];?>">
										</div>
									<?php					 
									}
									?>
								</div>
								<?php
									}
								}
								?>
								</div>
								<div class="col-md-6 px-0 border-right border-dark border-bottom">
									<?php
								for($i=0;$i<count($b5_ex_results);$i++)
								{
									if(($b5_ex_results[$i]['prod_id']!="p1561")&&($b5_ex_results[$i]['prod_id']!="p1562"))
									{
								?>
								<div class="row colorline w-100 mx-0 border-bottom border-dark">
									<div class="col-md-6 border-right border-dark">
									<?php
									$product=$prod->get_product($b5_ex_results[$i]['prod_id']);
									
									echo $b5_ex_results[$i]['o_id'].".".$b5_ex_results[$i]['osub_id'].".".$b5_ex_results[$i]['prod_id'];
									
									for($j=0;$j<count($customer_files);$j++)
									{
										
										if($customer_files[$j]['of_position']==substr($b5_ex_results[$i]['osub_id'],1))
										{
											echo " <b>".$customer_files[$j]['of_level']." ".$customer_files[$j]['of_name']."</b>";
										}
									}
									
									echo "<br> ".$product['prod_name'];
									?>
									</div>
									<div class="col-md-3 d-flex">
										<?php
										if(in_array($b5_ex_results[$i]['orf_type_dom'],$validextensions))
										{
										?>
										<div class="d-flex" id="image_tooltip_container_<?php
											echo $image_preview_counter;										
										?>">
										<img class="img-responsive" class="align-self-center" style="width:60px;height:40px;cursor:pointer;" src="result_files/<?php echo $b5_ex_results[$i]['orf_path_dom'].$b5_ex_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_ex_results[$i]['orf_name'];?>">										
										</div>
										<?php
										}
										?>
									</div>
									<!-- <div class="col-md-5">
										<?php echo $b5_ex_results[$i]['orf_name'];?>
									</div> -->
									<div class="col-md-1">							
										<a class="btn btn-sm" href="image.php?filecategory=creatorfiles&orfid=<?php echo $b5_ex_results[$i]['orf_id'];?>" alt="<?php echo $b5_ex_results[$i]['orf_name'];?>" target="_blank"><img src="img/download-icon.png" alt="Download" style="width:35px;"></a>
									</div>
									<?php						
									if(in_array($b5_ex_results[$i]['orf_type_dom'],$validextensions))
									{
									?>
										<div id="image_tooltip_<?php echo $image_preview_counter; ?>">
											<img class="img-responsive" style="width:900px" src="result_files/<?php echo $b5_ex_results[$i]['orf_path_dom'].$b5_ex_results[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $b5_ex_results[$i]['orf_name'];?>">
										</div>
									<?php					 
									}
									?>
								</div>
								<?php
									}
								}
								?>
								</div>
							</div>
						</div>
				<br>
				
			</div> <!-- end container -->
			<br>
			<?php
			include('online_creators.php');
			}
		}// end logged in user
		else
		{
            session_unset();
            session_destroy();
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>login.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>login.php">
			<?php
		}
		?>
	</article>
</section>
<?php
include('footer.php');
?>