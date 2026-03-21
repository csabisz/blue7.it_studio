<?php
//ini_set('max_file_uploads', 150);
//session_set_cookie_params(14400,"/");
session_start();
error_reporting(0);
include('functions.php');
include('../../../domenia7.com/public_html/domenia_db2.php');
include('../../../cseven.eu/public_html/domenia/domenia.php');
$prod=new Production;
$domenia=new Domenia;
$domenia2=new Domenia2;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('header2.php');
include('menu.php');

?>
<section class="top_section">
	<article>
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
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
						
						$logged_in_user_id=$prod->get_creator($_COOKIE['email']);
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
				
				//$creator=$prod->get_client($_COOKIE['email'])['client_id'];
				
				$myproducts=$prod->creator_products($orderid,$_COOKIE['client_id']);
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
                <div class="row w-100 mx-0 ">
                    <div class="col-md-12 m-0 p-0">
                        <?php
                        if($order['mc_id']==1)
                        {
                        ?>
                        <img src="img/streif_logo_background.png" style="height:40px;width:100%;">
                        <?php
                        }
                        if($order['mc_id']==4)
                        {
                        ?>
                        <img src="img/bodenseehaus_logo_background.png" style="height:40px;width:100%;">
                        <?php
                        }
                        ?>
                    </div>
                </div>	
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
                                <th scope="row"><?php echo (!empty($order['clients-extras']))?"<div style=\"color:red;text-align:left;\">".nl2br($order['clients-extras'])."</div>":"NONE"; ?></th>
                                <td><?php echo (!empty($order['client_extras_ex_b5']))?"<div style=\"color:red;text-align:left;\">".nl2br($order['client_extras_ex_b5'])."</div>":"NONE"; ?></td>
                                <td><?php echo (!empty($order['op-remarks']))?"<div style=\"color:red;text-align:left;\">".nl2br($order['op-remarks'])."</div>":"NONE"; ?></td>
                                <td><?php echo (!empty($order['op_remarks_ex_b5']))?"<div style=\"color:red;text-align:left;\">".nl2br($order['op_remarks_ex_b5'])."</div>":"NONE"; ?></td>
                                <td><?php echo (!empty($order['environment_address']))?"<div style=\"color:red;text-align:left;\">".nl2br($order['environment_address'])."</div>":"NONE"; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
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
                            <div class="col-md-1">
								<a href="image.php?filecategory=customerfiles&download-all=<?php echo $orderid;?>" class="btn btn-sm btn-primary">Download all</a>
							</div>
						</div>
						<?php
                        //print_r($myproducts);
						for($j=0;$j<count($myproducts);$j++)
						{
							$new_subid=substr($myproducts[$i]['osub_id'],1);
							if(empty($new_subid))
							{
								$new_subid=$myproducts[$i]['osub_id'];
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
                    //echo substr($myproducts[$i]['prod_id'],1);
                    if(
                        (substr($myproducts[$j]['prod_id'],1)>1559)&&(substr($myproducts[$j]['prod_id'],1)<1600)||
                        (substr($myproducts[$j]['prod_id'],1)>1159)&&(substr($myproducts[$j]['prod_id'],1)<1300)||
                        ($myproducts[$j]['prod_id']=="p116b")||($myproducts[$j]['prod_id']=="p116m")||
                        (substr($myproducts[$j]['prod_id'], -2)=="gb")||(substr($myproducts[$j]['prod_id'], -2)=="gt")||
                        (substr($myproducts[$j]['prod_id'], -2)=="gs")||(substr($myproducts[$j]['prod_id'], -2)=="gm")||
                        ($myproducts[$j]['prod_id']=="p116t")||(substr($myproducts[$j]['prod_id'], -2)=="8s")||(substr($myproducts[$j]['prod_id'], -3)=="16v")||
                        ($myproducts[$j]['prod_id']=="p156x")||($myproducts[$j]['prod_id']=="p156y")||
                        ($myproducts[$j]['prod_id']=="p156z")||
                    (substr($myproducts[$j]['prod_id'],1)>1659)&&(substr($myproducts[$j]['prod_id'],1)<1700)||
                    ($myproducts[$j]['prod_id']=="p166x")||($myproducts[$j]['prod_id']=="p166y")||($myproducts[$j]['prod_id']=="p166z")||($myproducts[$j]['prod_id']=="p166p")||
                    (substr($myproducts[$j]['prod_id'],1)>1759)&&(substr($myproducts[$j]['prod_id'],1)<1800)||
                    ($myproducts[$j]['prod_id']=="p176x")||($myproducts[$j]['prod_id']=="p176y")||($myproducts[$j]['prod_id']=="p176z")||
                    (substr($myproducts[$j]['prod_id'],1)>1859)&&(substr($myproducts[$j]['prod_id'],1)<1900)||
                    ($myproducts[$j]['prod_id']=="p186x")||($myproducts[$j]['prod_id']=="p186y")||($myproducts[$j]['prod_id']=="p186z")
                    )
                    {
                        
                        $count_exterior_products++;
                    }
                }

                for($j=0;$j<count($myproducts);$j++)
                {
                    
                    if(
                        (substr($myproducts[$j]['prod_id'],1)>1100)&&(substr($myproducts[$j]['prod_id'],1)<1160)||
                        (substr($myproducts[$j]['prod_id'],1)>1300)&&(substr($myproducts[$j]['prod_id'],1)<1360)||
                    (substr($myproducts[$j]['prod_id'],1)>1500)&&(substr($myproducts[$j]['prod_id'],1)<1560)||
                    (substr($myproducts[$j]['prod_id'],1)>1599)&&(substr($myproducts[$j]['prod_id'],1)<1660)||
                    (substr($myproducts[$j]['prod_id'],1)>1699)&&(substr($myproducts[$j]['prod_id'],1)<1760)||
                    (substr($myproducts[$j]['prod_id'],1)>1799)&&(substr($myproducts[$j]['prod_id'],1)<1860)||(substr($myproducts[$j]['prod_id'], -3)=="10v")||
                    ($myproducts[$j]['prod_id']=="p150x")||($myproducts[$j]['prod_id']=="p150y")||($myproducts[$j]['prod_id']=="p150z")||
                    ($myproducts[$j]['prod_id']=="p152x")||($myproducts[$j]['prod_id']=="p152y")||($myproducts[$j]['prod_id']=="p152z")||
                    ($myproducts[$j]['prod_id']=="p154x")||($myproducts[$j]['prod_id']=="p154y")||($myproducts[$j]['prod_id']=="p154z")||
                    ($myproducts[$j]['prod_id']=="p160x")||($myproducts[$j]['prod_id']=="p160y")||($myproducts[$j]['prod_id']=="p160z")||
                    ($myproducts[$j]['prod_id']=="p162x")||($myproducts[$j]['prod_id']=="p162y")||($myproducts[$j]['prod_id']=="p162z")||
                    ($myproducts[$j]['prod_id']=="p164x")||($myproducts[$j]['prod_id']=="p164y")||($myproducts[$j]['prod_id']=="p164z")||
                    ($myproducts[$j]['prod_id']=="p170x")||($myproducts[$j]['prod_id']=="p170y")||($myproducts[$j]['prod_id']=="p170z")||
                    ($myproducts[$j]['prod_id']=="p172x")||($myproducts[$j]['prod_id']=="p172y")||($myproducts[$j]['prod_id']=="p172z")||
                    ($myproducts[$j]['prod_id']=="p174x")||($myproducts[$j]['prod_id']=="p174y")||($myproducts[$j]['prod_id']=="p174z")||
                    ($myproducts[$j]['prod_id']=="p180x")||($myproducts[$j]['prod_id']=="p180y")||($myproducts[$j]['prod_id']=="p180z")||
                    ($myproducts[$j]['prod_id']=="p182x")||($myproducts[$j]['prod_id']=="p182y")||($myproducts[$j]['prod_id']=="p182z")||
                    ($myproducts[$j]['prod_id']=="p184x")||($myproducts[$j]['prod_id']=="p184y")||($myproducts[$j]['prod_id']=="p184z")
                    )
                    {
                        //echo substr($myproducts[$j]['prod_id'],1);
                        $count_interior_products++;
                    }
                }
                ?>
				<div class="row w-100 mx-0">
					<p class="w-100 text-center"><b>Assigned tasks</b></p>
				</div>			 
                <?php
                if($count_interior_products>0)
                {
                    $column_count=0;
                ?>
                <div class="row w-100 mx-0 interiordetails my-2 interior">
                    <div class="row w-100 mx-0 py-2"> 
                        <div class="col-12 my-2 col-md-5" style="border-bottom:2px solid #000;">
                    <?php
                    for($i=0;$i<count($myproducts);$i++)
                    {
                        if(
                            (substr($myproducts[$i]['prod_id'],1)>1100)&&(substr($myproducts[$i]['prod_id'],1)<1160)||
                            (substr($myproducts[$i]['prod_id'],1)>1300)&&(substr($myproducts[$i]['prod_id'],1)<1360)||
                        (substr($myproducts[$i]['prod_id'],1)>1500)&&(substr($myproducts[$i]['prod_id'],1)<1560)||
                        (substr($myproducts[$i]['prod_id'],1)>1599)&&(substr($myproducts[$i]['prod_id'],1)<1660)||
                        (substr($myproducts[$i]['prod_id'],1)>1699)&&(substr($myproducts[$i]['prod_id'],1)<1760)||
                        (substr($myproducts[$i]['prod_id'],1)>1799)&&(substr($myproducts[$i]['prod_id'],1)<1860)||(substr($myproducts[$i]['prod_id'], -3)=="10v")||
                        ($myproducts[$i]['prod_id']=="p150x")||($myproducts[$i]['prod_id']=="p150y")||($myproducts[$i]['prod_id']=="p150z")||
                        ($myproducts[$i]['prod_id']=="p152x")||($myproducts[$i]['prod_id']=="p152y")||($myproducts[$i]['prod_id']=="p152z")||
                        ($myproducts[$i]['prod_id']=="p154x")||($myproducts[$i]['prod_id']=="p154y")||($myproducts[$i]['prod_id']=="p154z")||
                        ($myproducts[$i]['prod_id']=="p160x")||($myproducts[$i]['prod_id']=="p160y")||($myproducts[$i]['prod_id']=="p160z")||
                        ($myproducts[$i]['prod_id']=="p162x")||($myproducts[$i]['prod_id']=="p162y")||($myproducts[$i]['prod_id']=="p162z")||
                        ($myproducts[$i]['prod_id']=="p164x")||($myproducts[$i]['prod_id']=="p164y")||($myproducts[$i]['prod_id']=="p164z")||
                        ($myproducts[$i]['prod_id']=="p170x")||($myproducts[$i]['prod_id']=="p170y")||($myproducts[$i]['prod_id']=="p170z")||
                        ($myproducts[$i]['prod_id']=="p172x")||($myproducts[$i]['prod_id']=="p172y")||($myproducts[$i]['prod_id']=="p172z")||
                        ($myproducts[$i]['prod_id']=="p174x")||($myproducts[$i]['prod_id']=="p174y")||($myproducts[$i]['prod_id']=="p174z")||
                        ($myproducts[$i]['prod_id']=="p180x")||($myproducts[$i]['prod_id']=="p180y")||($myproducts[$i]['prod_id']=="p180z")||
                        ($myproducts[$i]['prod_id']=="p182x")||($myproducts[$i]['prod_id']=="p182y")||($myproducts[$i]['prod_id']=="p182z")||
                        ($myproducts[$i]['prod_id']=="p184x")||($myproducts[$i]['prod_id']=="p184y")||($myproducts[$i]['prod_id']=="p184z")
                        )
                        {
                        $product=$prod->get_product($myproducts[$i]['prod_id']);

                        if(($column_count>0)&&($myproducts[$i-1]['osub_id']!=$myproducts[$i]['osub_id']))
                        {
                            $column_count++;
                            ?>
                            </div> <!-- end column -->
                            <div class="col-12 my-2 col-md-5" style="border-bottom:2px solid #000;">
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
                                                    url: "<?php echo $base_url;?>ajax/change_product_status.php",
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
                                    <p class="mb-0">Labc: <?php //echo $labc=$prod->calculateProductlabc_by_orderid($myproducts[$i]['prod_id'],$orderid);

                                    if((substr($myproducts[$i]['prod_id'],1)>1300)&&(substr($myproducts[$i]['prod_id'],1)<1368))
                                    {
                                        //calclualting b3 interior labc
                                        $o_desc_in_b3=$prod->get_o_desc_in_b3($myproducts[$i]['o_id']);    
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']); 
                                        
                                        if($myproducts[$i]['prod_id']=="p1301")
                                        {
                                        echo $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductlabc,1,2);
                                        echo "</br>";
                                        if($labc!=0){
                                            echo "(" . $o_desc_in_b3['fac_labc_in_b3']. " x ".$o_desc_in_b3['p1301_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        }
                                        if($myproducts[$i]['prod_id']=="p1302")
                                        {
                                        echo $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductlabc,1,2);
                                        echo "</br>";
                                        if($labc!=0){
                                            echo "(" . $o_desc_in_b3['fac_labc_in_b3']. " x ".$o_desc_in_b3['p1302_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        }
                                        if($myproducts[$i]['prod_id']=="p1321")
                                        {
                                        echo $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductlabc,1,2);
                                        echo "</br>";
                                        if($labc!=0){
                                            echo "(" . $o_desc_in_b3['fac_labc_in_b3']. " x ".$o_desc_in_b3['p1321_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        }
                                        if($myproducts[$i]['prod_id']=="p1322")
                                        {
                                        echo $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductlabc,1,2);
                                        echo "</br>";
                                        if($labc!=0){
                                            echo "(" . $o_desc_in_b3['fac_labc_in_b3']. " x ".$o_desc_in_b3['p1322_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        }
                                    }

                                    if((substr($myproducts[$i]['prod_id'],1)>1499)&&(substr($myproducts[$i]['prod_id'],1)<1560)
                                    ($myproducts[$i]['prod_id']=="p150x")||($myproducts[$i]['prod_id']=="p150y")||($myproducts[$i]['prod_id']=="p150z")||
                                    ($myproducts[$i]['prod_id']=="p152x")||($myproducts[$i]['prod_id']=="p152y")||($myproducts[$i]['prod_id']=="p152z")||
                                    ($myproducts[$i]['prod_id']=="p154x")||($myproducts[$i]['prod_id']=="p154y")||($myproducts[$i]['prod_id']=="p154z"))
                                    {
                                        //calculating b5 interior labc
                                        $o_desc_in_b5=$prod->get_o_desc_in_b5($myproducts[$i]['o_id']);    
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']); 
                                        if($myproducts[$i]['prod_id']=="p1521")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1521_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                            }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1524")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1524_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                            }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1526")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1526_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1501")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1501_fac']." x ".$thisproductlabc. "=" . $labc . ")";    
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1504")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1504_fac']." x ".$thisproductlabc. "=" . $labc . ")";    
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1541")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1541_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1544")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1544_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1506")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1506_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1546")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1546_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        else{
                                            echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5']  * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                    }

                                    if((substr($myproducts[$i]['prod_id'],1)>1599)&&(substr($myproducts[$i]['prod_id'],1)<1660)||
                                    ($myproducts[$i]['prod_id']=="p160x")||($myproducts[$i]['prod_id']=="p160y")||($myproducts[$i]['prod_id']=="p160z")||
                                    ($myproducts[$i]['prod_id']=="p162x")||($myproducts[$i]['prod_id']=="p162y")||($myproducts[$i]['prod_id']=="p162z")||
                                    ($myproducts[$i]['prod_id']=="p164x")||($myproducts[$i]['prod_id']=="p164y")||($myproducts[$i]['prod_id']=="p164z"))
                                    {
                                        //calculating b6 interior labc
                                        $o_desc_in_b6=$prod->get_o_desc_in_b6($myproducts[$i]['o_id']);    
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']); 

                                        if($myproducts[$i]['prod_id']=="p1621")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1621_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1624")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1624_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1626")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1626_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1600")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1600_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1601")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1601_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1604")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1604_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1641")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1641_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1644")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1644_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1606")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1606_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1646")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1646_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }
                                        }
                                        else{
                                            echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6']  * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                    }

                                    if((substr($myproducts[$i]['prod_id'],1)>1699)&&(substr($myproducts[$i]['prod_id'],1)<1760)||
                                    ($myproducts[$i]['prod_id']=="p170x")||($myproducts[$i]['prod_id']=="p170y")||($myproducts[$i]['prod_id']=="p170z")||
                                    ($myproducts[$i]['prod_id']=="p172x")||($myproducts[$i]['prod_id']=="p172y")||($myproducts[$i]['prod_id']=="p172z")||
                                    ($myproducts[$i]['prod_id']=="p174x")||($myproducts[$i]['prod_id']=="p174y")||($myproducts[$i]['prod_id']=="p174z"))
                                    {
                                        //calculating b7 interior labc
                                        $o_desc_in_b7=$prod->get_o_desc_in_b7($myproducts[$i]['o_id']);
                            
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);
                            
                                        if($myproducts[$i]['prod_id']=="p1700")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1700_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }
                                        }
                                        if($myproducts[$i]['prod_id']=="p1701")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1701_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1704")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1704_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1721")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductlabc,1,2);  
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1721_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1724")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductlabc,1,2);  
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1724_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1741")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1741_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }   
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1744")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1744_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }   
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1706")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductlabc,1,2);
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1706_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1726")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductlabc,1,2);
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1726_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }  
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1746")
                                        {
                                            echo $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductlabc,1,2);
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1746_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }            
                                        }
                                        else
                                        {
                                            $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b7['fac_labc_in_b7']." x ".$thisproductlabc." = ".$labc;
                                                                   
                                        }
                                        
                                    }

                                    if((substr($myproducts[$i]['prod_id'],1)>1799)&&(substr($myproducts[$i]['prod_id'],1)<1860)||
                                    ($myproducts[$i]['prod_id']=="p180x")||($myproducts[$i]['prod_id']=="p180y")||($myproducts[$i]['prod_id']=="p180z")||
                                    ($myproducts[$i]['prod_id']=="p182x")||($myproducts[$i]['prod_id']=="p182y")||($myproducts[$i]['prod_id']=="p182z")||
                                    ($myproducts[$i]['prod_id']=="p184x")||($myproducts[$i]['prod_id']=="p184y")||($myproducts[$i]['prod_id']=="p184z"))
                                    {
                                        //calculating b8 interior labc
                                        $o_desc_in_b8=$prod->get_o_desc_in_b8($myproducts[$i]['o_id']);
                            
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);
                            
                                        if($myproducts[$i]['prod_id']=="p1800")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1800_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }  
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1801")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1801_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }  
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1804")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1804_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            } 
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1821")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductlabc,1,2);  
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1821_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            } 
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1824")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductlabc,1,2);  
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1824_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            } 
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1841")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1841_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }     
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1844")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductlabc,1,2); 
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1844_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }     
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1806")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductlabc,1,2);
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1806_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }         
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1826")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductlabc,1,2);
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1826_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }   
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1846")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductlabc,1,2);
                            
                                            echo "<br>";
                                            if($labc!=0){
                                                echo "(" . $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1846_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                            }             
                                        }
                                        else
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$thisproductlabc." = ".$labc;
                                                                   
                                        }
                                        
                                    }


                                    if(((substr($myproducts[$i]['prod_id'],1)>1559)&&(substr($myproducts[$i]['prod_id'],1)<1590))||($myproducts[$i]['prod_id']=="p156x")||($myproducts[$i]['prod_id']=="p156y")||($myproducts[$i]['prod_id']=="p156z"))
                                    {
                                        //calculating b5 exterior labc
                                        $o_desc_ex_b5=$prod->get_o_desc_ex_b5($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1561")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                                echo "(".$o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1561_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1563")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                                echo "(".$o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1563_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1566")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1566_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b5['fac_prod_ex_b5']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }

                                    if(((substr($myproducts[$i]['prod_id'],1)>1659)&&(substr($myproducts[$i]['prod_id'],1)<1690))||($myproducts[$i]['prod_id']=="p166x")||($myproducts[$i]['prod_id']=="p166y")||($myproducts[$i]['prod_id']=="p166z")||($myproducts[$i]['prod_id']=="p166p"))
                                    {
                                        //calculating b6 exterior labc
                                        $o_desc_ex_b6=$prod->get_o_desc_ex_b6($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1661")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1661_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1663")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1663_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1666")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1666_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b6['fac_prod_ex_b6']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }

                                    if(((substr($myproducts[$i]['prod_id'],1)>1759)&&(substr($myproducts[$i]['prod_id'],1)<1790))||($myproducts[$i]['prod_id']=="p176x")||($myproducts[$i]['prod_id']=="p176y")||($myproducts[$i]['prod_id']=="p176z"))
                                    {
                                        //calculating b7 exterior labc
                                        $o_desc_ex_b7=$prod->get_o_desc_ex_b7($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1761")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1761_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1763")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1763_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1766")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1766_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b7['fac_prod_ex_b7']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }

                                    if(((substr($myproducts[$i]['prod_id'],1)>1859)&&(substr($myproducts[$i]['prod_id'],1)<1890))||($myproducts[$i]['prod_id']=="p186x")||($myproducts[$i]['prod_id']=="p186y")||($myproducts[$i]['prod_id']=="p186z"))
                                    {
                                        //calculating b8 exterior labc
                                        $o_desc_ex_b8=$prod->get_o_desc_ex_b8($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1861")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1861_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1863")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1863_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1866")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1866_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b8['fac_prod_ex_b8']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }
                                    ?></p>
                                </div>
                                <div class="col-3">
                                    test
                                </div>
                                <div class="col-3 text-right">
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
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom <?php 
                                    if($thisfileresults[$k]['orf_status']==8)
                                    {
                                        echo "light-green";
                                    }
                                    ?>">
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
            } //end interior

           
            if($count_exterior_products>0)
            {
                $column_count=0;
                ?>
                <div class="row w-100 mx-0 exteriordetails my-2 exterior">
                    <div class="row w-100 mx-0 py-2"> 
                        <div class="col-12 my-2 col-md-5" style="border-bottom:2px solid #000;">
                    <?php
                    for($i=0;$i<count($myproducts);$i++)
                    {
                        if(
                            (substr($myproducts[$i]['prod_id'],1)>1159)&&(substr($myproducts[$i]['prod_id'],1)<1300)||
                            ($myproducts[$i]['prod_id']=="p116b")||($myproducts[$i]['prod_id']=="p116m")||
                            ($myproducts[$i]['prod_id']=="p116t")||(substr($myproducts[$i]['prod_id'], -2)=="8s")||
                            (substr($myproducts[$i]['prod_id'], -2)=="gb")||(substr($myproducts[$i]['prod_id'], -2)=="gm")||
                            (substr($myproducts[$i]['prod_id'], -2)=="gt")||(substr($myproducts[$i]['prod_id'], -2)=="gs")||
                            (substr($myproducts[$i]['prod_id'],1)>1559)&&(substr($myproducts[$i]['prod_id'],1)<1600)||
                            ($myproducts[$i]['prod_id']=="p156x")||($myproducts[$i]['prod_id']=="p156y")||
                            ($myproducts[$i]['prod_id']=="p156z")||(substr($myproducts[$i]['prod_id'], -3)=="16v")||
                        (substr($myproducts[$i]['prod_id'],1)>1659)&&(substr($myproducts[$i]['prod_id'],1)<1700)||
                        ($myproducts[$i]['prod_id']=="p166x")||($myproducts[$i]['prod_id']=="p166y")||($myproducts[$i]['prod_id']=="p166z")||($myproducts[$i]['prod_id']=="p166p")||
                        (substr($myproducts[$i]['prod_id'],1)>1759)&&(substr($myproducts[$i]['prod_id'],1)<1800)||
                        ($myproducts[$i]['prod_id']=="p176x")||($myproducts[$i]['prod_id']=="p176y")||($myproducts[$i]['prod_id']=="p176z")||
                        (substr($myproducts[$i]['prod_id'],1)>1859)&&(substr($myproducts[$i]['prod_id'],1)<1900)||
                        ($myproducts[$i]['prod_id']=="p186x")||($myproducts[$i]['prod_id']=="p186y")||($myproducts[$i]['prod_id']=="p186z"))
                        {
                        $product=$prod->get_product($myproducts[$i]['prod_id']);

                        if(($column_count>0)&&($myproducts[$i-1]['osub_id']!=$myproducts[$i]['osub_id']))
                        {
                            $column_count++;
                            ?>
                            </div> <!-- end column -->
                            <div class="col-12 my-2 col-md-5" style="border-bottom:2px solid #000;">
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
                                                    url: "<?php echo $base_url;?>ajax/change_product_status.php",
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
                                <div class="col-4 text-center">
                                    <p class="mb-0">Labcs: <?php 
                                    //echo "ddddd"; echo $labc=$prod->calculateProductlabc_by_orderid($myproducts[$i]['prod_id'],$orderid);
                                    
                                    if((substr($myproducts[$i]['prod_id'],1)>1300)&&(substr($myproducts[$i]['prod_id'],1)<1368))
                                    {
                                        //calclualting b3 interior labc
                                        $o_desc_in_b3=$prod->get_o_desc_in_b3($myproducts[$i]['o_id']);    
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']); 
                                        echo $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3']   * $thisproductlabc,1,2);
                                        echo "</br>";
                                        if($labc!=0){
                                            echo "(" . $o_desc_in_b3['fac_labc_in_b3']. " x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        
                                    }

                                    if((substr($myproducts[$i]['prod_id'],1)>1499)&&(substr($myproducts[$i]['prod_id'],1)<1560)||
                                    ($myproducts[$i]['prod_id']=="p150x")||($myproducts[$i]['prod_id']=="p150y")||($myproducts[$i]['prod_id']=="p150z")||
                                    ($myproducts[$i]['prod_id']=="p152x")||($myproducts[$i]['prod_id']=="p152y")||($myproducts[$i]['prod_id']=="p152z")||
                                    ($myproducts[$i]['prod_id']=="p154x")||($myproducts[$i]['prod_id']=="p154y")||($myproducts[$i]['prod_id']=="p154z"))
                                    {
                                        //calculating b5 interior labc
                                        $o_desc_in_b5=$prod->get_o_desc_in_b5($myproducts[$i]['o_id']);    
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']); 
                                        if($myproducts[$i]['prod_id']=="p1524")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1524_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1526")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1526_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1504")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1504_fac']." x ".$thisproductlabc. "=" . $labc . ")";    
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1544")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1544_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1506")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1506_fac']." x ".$thisproductlabc. "=" . $labc . ")";  
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1546")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$o_desc_in_b5['p1546_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        else{
                                            echo $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5']  * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b5['fac_labc_in_b5']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                    }

                                    if((substr($myproducts[$i]['prod_id'],1)>1599)&&(substr($myproducts[$i]['prod_id'],1)<1660)
                                    ($myproducts[$i]['prod_id']=="p160x")||($myproducts[$i]['prod_id']=="p160y")||($myproducts[$i]['prod_id']=="p160z")||
                                    ($myproducts[$i]['prod_id']=="p162x")||($myproducts[$i]['prod_id']=="p162y")||($myproducts[$i]['prod_id']=="p162z")||
                                    ($myproducts[$i]['prod_id']=="p164x")||($myproducts[$i]['prod_id']=="p164y")||($myproducts[$i]['prod_id']=="p164z")
                                    )
                                    {
                                        //calculating b6 interior labc
                                        $o_desc_in_b6=$prod->get_o_desc_in_b6($myproducts[$i]['o_id']);    
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']); 
                                        if($myproducts[$i]['prod_id']=="p1624")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1624_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1626")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1626_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1604")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1604_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1644")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1644_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        } 
                                        elseif($myproducts[$i]['prod_id']=="p1606")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1606_fac']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1646")
                                        {
                                           echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$o_desc_in_b6['p1646_fac']." x ".$thisproductlabc. "=" . $labc . ")";         
                                        }
                                        }
                                        else{
                                            echo $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6']  * $thisproductlabc,1,2);  
                                           echo "</br>";
                                           if($labc!=0){
                                               echo "(" . $o_desc_in_b6['fac_labc_in_b6']." x ".$thisproductlabc. "=" . $labc . ")"; 
                                        }
                                        }
                                    }

                                    if((substr($myproducts[$i]['prod_id'],1)>1699)&&(substr($myproducts[$i]['prod_id'],1)<1760)
                                    ($myproducts[$i]['prod_id']=="p170x")||($myproducts[$i]['prod_id']=="p170y")||($myproducts[$i]['prod_id']=="p170z")||
                                    ($myproducts[$i]['prod_id']=="p172x")||($myproducts[$i]['prod_id']=="p172y")||($myproducts[$i]['prod_id']=="p172z")||
                                    ($myproducts[$i]['prod_id']=="p174x")||($myproducts[$i]['prod_id']=="p174y")||($myproducts[$i]['prod_id']=="p174z"))
                                    {
                                        //calculating b7 interior labc
                                        $o_desc_in_b7=$prod->get_o_desc_in_b7($myproducts[$i]['o_id']);
                            
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);
                            
                                        if($myproducts[$i]['prod_id']=="p1704")
                                        {
                                            $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductlabc,1,2); 
                            
                                            echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1704_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1704_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1724")
                                        {
                                            $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductlabc,1,2);  
                            
                                            echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1724_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1724_fac']." x ".$thisproductlabc." = ".$labc;
                                            $total_labc[]=$labc; 
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1744")
                                        {
                                            $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductlabc,1,2); 
                            
                                            echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1744_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1744_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;    
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1706")
                                        {
                                            $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1706_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1706_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1726")
                                        {
                                            $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1726_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b7['fac_labc_in_b7']." x ".$o_desc_in_b7['p1726_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;   
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1746")
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

                                    if((substr($myproducts[$i]['prod_id'],1)>1799)&&(substr($myproducts[$i]['prod_id'],1)<1860)
                                    ($myproducts[$i]['prod_id']=="p180x")||($myproducts[$i]['prod_id']=="p180y")||($myproducts[$i]['prod_id']=="p180z")||
                                    ($myproducts[$i]['prod_id']=="p182x")||($myproducts[$i]['prod_id']=="p182y")||($myproducts[$i]['prod_id']=="p182z")||
                                    ($myproducts[$i]['prod_id']=="p184x")||($myproducts[$i]['prod_id']=="p184y")||($myproducts[$i]['prod_id']=="p184z"))
                                    {
                                        //calculating b8 interior labc
                                        $o_desc_in_b8=$prod->get_o_desc_in_b8($myproducts[$i]['o_id']);
                            
                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);
                            
                                        if($myproducts[$i]['prod_id']=="p1804")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductlabc,1,2); 
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1804_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1804_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1824")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductlabc,1,2);  
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1824_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1824_fac']." x ".$thisproductlabc." = ".$labc;
                                            $total_labc[]=$labc; 
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1844")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductlabc,1,2); 
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1844_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1844_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;    
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1806")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1806_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1806_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1826")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1826_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1826_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;   
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1846")
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1846_fac']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$o_desc_in_b8['p1846_fac']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;            
                                        }
                                        else
                                        {
                                            $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $thisproductlabc,1,2);
                            
                                            echo $o_desc_in_b8['fac_labc_in_b8']." x ".$thisproductlabc." = ".$labc;
                                            $html.= $o_desc_in_b8['fac_labc_in_b8']." x ".$thisproductlabc." = ".$labc;
                            
                                            $total_labc[]=$labc;                        
                                        }
                                        
                                    }


                                    if(((substr($myproducts[$i]['prod_id'],1)>1559)&&(substr($myproducts[$i]['prod_id'],1)<1590))||($myproducts[$i]['prod_id']=="p156x")||($myproducts[$i]['prod_id']=="p156y")||($myproducts[$i]['prod_id']=="p156z"))
                                    {
                                        //calculating b5 exterior labc
                                        $o_desc_ex_b5=$prod->get_o_desc_ex_b5($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1563")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                        if($labc!=0)
                                        {
                                            echo "(".$o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1563_fac']." x ".$thisproductlabc." = ".$labc.")";
                                        }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1566")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b5['fac_prod_ex_b5']." x ".$o_desc_ex_b5['p1566_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b5['fac_prod_ex_b5']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }
                                    
                                    if(((substr($myproducts[$i]['prod_id'],1)>1659)&&(substr($myproducts[$i]['prod_id'],1)<1690))||($myproducts[$i]['prod_id']=="p166x")||($myproducts[$i]['prod_id']=="p166y")||($myproducts[$i]['prod_id']=="p166z")||($myproducts[$i]['prod_id']=="p166p"))
                                    {
                                        //calculating b6 exterior
                                        $o_desc_ex_b6=$prod->get_o_desc_ex_b6($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1663")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1663_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1666")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b6['fac_prod_ex_b6']." x ".$o_desc_ex_b6['p1666_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b6['fac_prod_ex_b6']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }

                                    if(((substr($myproducts[$i]['prod_id'],1)>1759)&&(substr($myproducts[$i]['prod_id'],1)<1790))||($myproducts[$i]['prod_id']=="p176x")||($myproducts[$i]['prod_id']=="p176y")||($myproducts[$i]['prod_id']=="p176z"))
                                    {
                                        //calculating b7 exterior
                                        $o_desc_ex_b7=$prod->get_o_desc_ex_b7($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1763")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1763_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1766")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b7['fac_prod_ex_b7']." x ".$o_desc_ex_b7['p1766_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b7['fac_prod_ex_b7']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }

                                    if(((substr($myproducts[$i]['prod_id'],1)>1859)&&(substr($myproducts[$i]['prod_id'],1)<1890))||($myproducts[$i]['prod_id']=="p186x")||($myproducts[$i]['prod_id']=="p186y")||($myproducts[$i]['prod_id']=="p186z"))
                                    {
                                        //calculating b8 exterior
                                        
                                        $o_desc_ex_b8=$prod->get_o_desc_ex_b8($myproducts[$i]['o_id']);

                                        $thisproductlabc=$prod->calculateProductlabc($myproducts[$i]['prod_id']);

                                        if($myproducts[$i]['prod_id']=="p1863")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1863_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                        
                                        }
                                        elseif($myproducts[$i]['prod_id']=="p1866")
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b8['fac_prod_ex_b8']." x ".$o_desc_ex_b8['p1866_fac']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductlabc,1,2);
                                            echo "<br>";
                                            if($labc!=0)
                                            {
                                            echo "(".$o_desc_ex_b8['fac_prod_ex_b8']." x ".$thisproductlabc." = ".$labc.")";
                                            }
                                            
                                        }
                                    }
                                    ?></p>
                                </div>
                                <div class="col-6 d-flex">
                                    <input type="checkbox" id="no_result_file<?php echo $orderid;?>_<?php echo $myproducts[$i]['osub_id']; ?>_<?php echo $myproducts[$i]['prod_id'];?>" class="form-control-sm form-control" value="1" style="width: 2vw;" <?php
                                    $found_no_result_file=0;
                                    $all_results=$prod->show_results($orderid, $myproducts[$i]['osub_id'], $myproducts[$i]['prod_id']);

                                    for($f=0;$f<count($all_results);$f++)
                                    {
                                        if(($found_no_result_file==0)&&($all_results[$f]['no_result_file']==1))
                                        {
                                            echo "checked";
                                            $found_no_result_file++;
                                        }
                                    }
                                    ?>>
                                    <label class="form-check-label" for="no_result_file<?php echo $orderid;?>_<?php echo $myproducts[$i]['osub_id']; ?>_<?php echo $myproducts[$i]['prod_id'];?>" style="width: fit-content;">No result file shall be uploaded</label>
                                    <script type="text/javascript">
                                        $('#no_result_file<?php echo $orderid;?>_<?php echo $myproducts[$i]['osub_id']; ?>_<?php echo $myproducts[$i]['prod_id'];?>').click(function(){

                                            let o_id=<?php echo $orderid;?>;
                                            let osub_id="<?php echo $myproducts[$i]['osub_id']; ?>";
                                            let prod_id="<?php echo $myproducts[$i]['prod_id'];?>";
                                            let uca_id=<?php echo $_COOKIE['client_id'];?>;

                                            if($(this).is(':checked'))
                                            {
                                                $.ajax({
                                                        url: "<?php echo $base_url;?>ajax/create_no_result_file.php",
                                                        method: "post",
                                                        data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                                                        dataType:"html",
                                                        success:function(data) {

                                                        }
                                                    });


                                            }
                                            else
                                            {
                                                $.ajax({
                                                        url: "<?php echo $base_url;?>ajax/delete_no_result_file.php",
                                                        method: "post",
                                                        data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id},
                                                        dataType:"html",
                                                        success:function(data) {

                                                        }
                                                    });
                                            }

                                        });
                                    </script>
                                </div>
                                <div class="col-2 text-right">
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
                                    <div class="row w-100 mx-0 d-flex justify-content-center align-items-center bg-light border-bottom <?php 
                                    if($thisfileresults[$k]['orf_status']==8)
                                    {
                                        echo "light-green";
                                    }
                                    ?>">
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
			//include('online_creators.php');
			}
		}// end logged in user
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