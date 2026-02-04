<?php
session_start();
include('../domenia_db3.php');
include('../functions.php');
$prod=new Production;
$domenia3=new Domenia3;
$page_title="Books";
include('../header2.php');
include('../menu.php');
?>
 <!-- </div> end main menu container -->
<div class="container-fluid">
<section class="top_section">	
		<article>
		
		<?php
		if(isset($_COOKIE['client_id']))
		{
			include('submenu.php');
			?>			
			<!-- <h3>Payments</h3>	 -->
            <p class="w-100 text-center display-4">Payments</p>
            <hr class="bg-dark" width="450px">						
			<div class="row mx-0 w-100 mb-4">
                <div class="col-4 offset-4"><a class="btn btn-primary btn-sm btn-block my-2" href="book.php?option=create">Create booking</a></div>
            </div>	
			<?php
			if(isset($_POST['create_btn']))
			{
				$bad_order_id=$prod->xss_fix($_POST['o_id']);
				$end=explode('=',$bad_order_id);
				$order_id=end($end);
				$payment_date=$prod->xss_fix($_POST['payment_date']);
				$payment_amount=$prod->xss_fix($_POST['payment_amount']);
				$payer=$prod->xss_fix($_POST['payer']);
				$bank_account=$prod->xss_fix($_POST['bank_account']);
				$reference=$prod->xss_fix($_POST['reference']);
				$currency=$prod->xss_fix($_POST['currency']);
				
				$domenia3->create_payment($order_id,$payment_date,$payment_amount,$currency,$payer,$bank_account,$reference);
				?>
				<div class="center_message">
					<div class="success">Created ! </div><br> 
					<meta http-equiv="refresh" content="5; url=book.php"> 
				</div>
				<?php
			}
			
			if(isset($_POST['save_btn']))
			{
				$payid=$prod->xss_fix($_POST['payid']);
				$order_id=$prod->xss_fix($_POST['o_id']);
				$payment_date=$prod->xss_fix($_POST['payment_date']);
				$payment_amount=$prod->xss_fix($_POST['payment_amount']);
				$payer=$prod->xss_fix($_POST['payer']);
				$bank_account=$prod->xss_fix($_POST['bank_account']);
				$reference=$prod->xss_fix($_POST['reference']);
				$currency=$prod->xss_fix($_POST['currency']);
				
				$domenia3->update_payment($payid,$order_id,$payment_date,$payment_amount,$currency,$payer,$bank_account,$reference);
				?>
				<div class="center_message">
					<div class="success">Changes saved ! </div><br> 
					<meta http-equiv="refresh" content="5; url=book.php">
				</div>
				<?php
			}
			
			$option=$_GET['option'];
			
			if($option=="modify")
			{
				$payment_id=$prod->xss_fix($_GET['payid']);
				
				$payment=$domenia3->show_payment($payment_id);
				$licence=$prod->get_licence_ids();
				
				if(isset($_GET['licenceid']))
				{
					$selected_licence=$prod->xss_fix($_GET['licenceid']);
				}
				else
				{
					$selected_licence=$prod->get_order($payment['o_id'])['lic_ID'];
					
				}
				$orders=$prod->show_order_by_licid($selected_licence);
				$bank_accounts=$prod->show_licence_account($selected_licence);
				?>
				<div class="container p-4 pagecontent bg-white">
				<form class="p-3" name="payment_save_changes" action="book.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="payid" value="<?php echo $payment_id;?>" >
				<input type="hidden" id="modify_selected_o_id" name="selected_o_id" value="<?php echo $payment['o_id'];?>" >
				<input type="hidden" id="modify_selected_licence" name="selected_licence" value="book.php?option=modify&payid=<?php echo $payment_id;?>&licenceid=<?php echo $selected_licence; ?>" >
				<input type="hidden" id="modify_selected_currency" name="selected_currency" value="<?php echo $payment['currency'];?>" >
                    <div class="form-group row">
							<div class="col-md-2" style="width:130px;">
								<label>Licence</label>
							</div>
								<div class="col-md-2">
									<b>
										<select class="form-control" id="modify_licence" name="licence" style="width:300px;" onchange="if (this.value) window.location.href=this.value">
											<option value="">Choose licence</option>
											<?php
											for($i=0;$i<count($licence);$i++)
											{
												?>
												<option value="book.php?option=modify&payid=<?php echo $payment_id;?>&licenceid=<?php echo $licence[$i]['lic_id'];?>">ID=<?php echo $licence[$i]['lic_id']." ";?><?php echo $licence[$i]['name-describing'];?></option>
												<?php
											}
											?>
										</select>
									</b>
								</div>
							
					</div>
					<div class="form-group row">					
							<div class="col-md-2" style="width:130px;">
								<label>Bank account</label>
							</div>
							<div class="col-md-2">
								<select class="form-control" name="bank_account" style="width:300px;">
									<?php
									for($i=0;$i<count($bank_accounts);$i++)
									{
										?>
										<option><?php 
										if(empty($bank_accounts[$i]['account']))
										{
											echo $bank_accounts[$i]['IBAN'];
										}
										else
										{
											echo $bank_accounts[$i]['account'];
										}
										?></option>
										<?php
									}
									?>								
								</select>
							</div>
						
					</div>
					
					<div class="form-group row">	
						<div class="col-md-2" style="width:130px;">
							<label>Order ID</label>
						</div>
						<div class="col-md-2" style="width:120px;">							
							<select class="form-control" id="modify_order_id" name="o_id" style="width:100px;">
								<option value="">None</option>
									<?php
									for($i=0;$i<count($orders);$i++)
									{
										?>
										<option value="<?php echo $orders[$i]['order_ID'];?>"><?php echo $orders[$i]['order_ID'];?></option>
										<?php
									}
									?>	
							</select>
							
							
						</div>
						<div class="col-md-1">
						<?php
						$order_price=$prod->get_order($payment['o_id']);
						$payment_amount=$domenia3->get_payment_amount($payment['o_id']);
						$total_paid=0;
						$rest=0;
						for($k=0;$k<count($payment_amount);$k++)
						{							
							$total_paid += $payment_amount[$k]['amount'];
						}
						$rest=$order_price['brut_price']-$total_paid;
						if($rest>0)
						{
						?>
							<span class="error">Unpaid</span>
						<?php
						}
						if($rest==0)
						{
						?>
							<span class="success">Paid</span>
						<?php
						}
						if($rest<0)
						{
						?>
							<span class="warning">Overpaid</span>
						<?php
						}
						?>
						</div>
						<div class="col-md-4" style="width:310px;">
							<input class="form-control" type="text" name="payer" value="<?php echo $payment['payer'];?>" style="width:300px;" >							
						</div>
						<div class="col-md-2">
							<label>Payer</label>							
						</div>
					</div>
					<div class="form-group row">						
							<div class="col-md-2" style="width:130px;">								
								<label>Amount with VAT</label>
							</div>
							
							<div class="col-md-2">
								<input class="form-control" type="text" name="payment_amount" value="<?php echo $payment['amount'];?>" style="width:150px;" >
							</div>
							<div class="col-md-2" style="width:130px;">
								<select class="form-control" id="modify_currency" name="currency" style="width:100px;">
									<option value="">-- Select --</option>
									<?php								
									$all_currencies=$prod->get_all_currencies();
									for($i=0;$i<count($all_currencies);$i++)
									{
										?>
										<option value="<?php echo $all_currencies[$i]['cur_short'];?>" <?php echo ($all_currencies[$i]['cur_short']==$payment['currency'])?"selected":""?>><?php echo $all_currencies[$i]['cur_short'];?></option>
										<?php
									}
									?>	
								</select>
							</div>		
							<div class="col-md-2" style="width:160px;">							
								<input class="form-control" type="text" id="modify_payment_date" name="payment_date" value="<?php echo $payment['date'];?>" style="width:150px;">	
							</div>	
							<div class="col-md-2">
								<label>Date of payment</label>		
							</div>
					</div>
					
					<div class="form-group row">							
						<div class="col-md-2" style="width:130px;">							
							<label>Reference</label>
						</div>
						<div class="col-md-6">
							<input class="form-control" type="text" name="reference" value="<?php echo $payment['reference'];?>" style="width:620px;">
						</div>
					</div>
					<div class="form-group row">
						<div style="width:350px; margin: auto;">
							<button name="save_btn" class="btn btn-primary btn-sm" type="submit">Save changes</button>
						</div>
					</div>									
				</form>
				</div>
				<br>
				<?php
			}
			elseif($option=="create")
			{	
				$licence=$prod->get_licence_ids();
				?>
				<div class="container" style="background-color:#a8c9ff">
						<div class="form-group row">
							<div class="col-md-2" style="width:130px;">
								<label>Licence</label>
							</div>
								<div class="col-md-2">
									<b>
										<select class="form-control" id="licence" name="licence" style="width:300px;" onchange="if (this.value) window.location.href=this.value" >
											<option value="">Choose licence</option>
											<?php
											for($i=0;$i<count($licence);$i++)
											{
												?>
												<option value="book.php?option=create&licenceid=<?php echo $licence[$i]['lic_id'];?>">ID=<?php echo $licence[$i]['lic_id']." ";?><?php echo $licence[$i]['name-describing'];?></option>
												<?php
											}
											?>
										</select>
									</b>
								</div>						
						</div>
				</div>
				<?php
				if(isset($_GET['licenceid']))
				{
					$licenceid=$prod->xss_fix($_GET['licenceid']);
                    $o_id=$prod->xss_fix($_GET['o_id']);
                    $licence=$prod->get_licence($licenceid);
					$licence_taker=$prod->get_company($licence['licence-taker']);
					$orders=$prod->show_order_by_licid($licenceid);
					$bank_accounts=$prod->show_licence_account($licenceid);
					
					if(isset($_GET['o_id']))
					{
						$clientid=$prod->get_client_by_licid_order($licenceid,$o_id);
						
					}
					else
					{
						$clientid=$prod->get_client_by_licid_order($licenceid,$orders[0]['order_ID']);
						$o_id=$orders[0]['order_ID'];
					}
					
					if(isset($_GET['amount']))
					{
						$amount=$prod->xss_fix($_GET['amount']);
					}
					else
					{
						$amount=$orders[0]['brut_price'];
                    }
                    
					?>
				<div class="container" style="background-color:#a8c9ff">
				<form name="create_booking" action="book.php" method="post" enctype="multipart/form-data">
					<input type="hidden" id="selected_licence" name="selected_licence" value="book.php?option=create&licenceid=<?php echo $licenceid; ?>" >
					<div class="form-group row">					
							<div class="col-md-2" style="width:130px;">
								<label>Bank account</label>
							</div>
							<div class="col-md-2">
								<select class="form-control" name="bank_account" style="width:300px;">
									<?php
                                    if(!empty($licence_taker['IBAN']))
                                    {
                                        ?>
                                        <option><?php echo $licence_taker['IBAN'];?></option>
                                        <?php
                                    }
                                    else
                                    {
                                        for($i=0;$i<count($bank_accounts);$i++)
                                        {
                                            ?>
                                            <option><?php 
                                            if(empty($bank_accounts[$i]['account']))
                                            {
                                                echo $bank_accounts[$i]['IBAN'];
                                            }
                                            else
                                            {
                                                echo $bank_accounts[$i]['account'];
                                            }
                                            ?></option>
                                            <?php
                                        }
                                    }
									?>								
								</select>
							</div>
						
					</div>
					
					<div class="form-group row">	
						<div class="col-md-2" style="width:130px;">
							<label>Order ID</label>
						</div>
						<div class="col-md-2" style="width:120px;">
							<select class="form-control" id="order_id" name="o_id" style="width:100px;" onchange="if (this.value) window.location.href=this.value">
								<option value="">None</option>
									<?php
									for($i=0;$i<count($orders);$i++)
									{
										?>
										<option value="book.php?option=create&licenceid=<?php echo $licenceid; ?>&amount=<?php 
										if($orders[$i]['o_special_agreement_price']==0)
										{
											echo $orders[$i]['brut_price'];
										}
										else
										{
											echo $orders[$i]['o_special_agreement_price'];
										}?>&o_id=<?php echo $orders[$i]['order_ID'];?>"><?php echo $orders[$i]['order_ID'];?></option>
										<?php
									}
									?>	
							</select>						
						</div>
						<div class="col-md-1">
						<?php
						$order_price=$prod->get_order($o_id);
                        $payment_amount=$domenia3->get_payment_amount($o_id);
                        
                        $payer=$prod->get_client($clientid['u_client_ID']);

						$total_paid=0;
						$rest=0;
						for($k=0;$k<count($payment_amount);$k++)
						{
							
							$total_paid += $payment_amount[$k]['amount'];
						}
						
						if($order_price['o_special_agreement_price']==0)
						{
							$rest=$order_price['brut_price']-$total_paid;
						}
						else
						{

                            $seller=$prod->get_licence_taker($o_id);

                            $vat=$prod->get_vat($seller['a_id']);
    
                            $o_special_agreement_price_vat=0;

                            if(!empty($seller['VAT-tax no.']))
                            {
                                
                                if(($vat['a_eu']=="1")&&($order_price['payment_way']!=9))
                                {
                                    $o_special_agreement_price_vat=(bcdiv($order_price['o_special_agreement_price']*$vat['a_vat']/100,1,2));
                                }
                                else
                                {
                                    if(($seller['a_id']==$payer['a_id'])&&($order_price['payment_way']!=9))
                                    {
                                        $o_special_agreement_price_vat=(bcdiv($order_price['o_special_agreement_price']*$vat['a_vat']/100,1,2));
                                    }
                                    else
                                    {
                                        $o_special_agreement_price_vat=0;
                                    }
                                }
                            }			
                            else
                            {
                                $o_special_agreement_price_vat=0;
                            }
    
							$rest=$order_price['o_special_agreement_price']+$o_special_agreement_price_vat-$total_paid;
						}
						if($rest>0)
						{
						?>
							<span class="error">Unpaid</span>
						<?php
						}
						if($rest==0)
						{
						?>
							<span class="success">Paid</span>
						<?php
						}
						if($rest<0)
						{
							?>
							<span class="warning">Overpaid</span>
							<?php
						}
						?>
						</div>						
						<div class="col-md-4" style="width:310px;">
							<?php						
							
							?>
							<input class="form-control" type="text" name="payer" value="<?php echo $payer['clientname'];?>" style="width:300px;" >							
						</div>
						<div class="col-md-2">
							<label>Payer</label>							
						</div>
					</div>
					<div class="form-group row">						
							<div class="col-md-2" style="width:130px;">								
								<label>Amount with VAT</label>
							</div>
							<input type="hidden" name="selected_o_id" id="selected_o_id" value="book.php?option=create&licenceid=<?php echo $licenceid; ?>&amount=<?php echo $amount;?>&o_id=<?php echo $o_id;?>" >
							<div class="col-md-2">
								<input class="form-control" type="text" name="payment_amount" value="<?php echo $amount;?>" style="width:150px;" >
							</div>
							<div class="col-md-2" style="width:130px;">
								<select class="form-control" id="currency" name="currency" style="width:100px;" >
									<option value="">-- Select --</option>
									<?php								
									$all_currencies=$prod->get_all_currencies();
									for($i=0;$i<count($all_currencies);$i++)
									{
										?>
										<option value="<?php echo $all_currencies[$i]['cur_short'];?>" <?php echo ($all_currencies[$i]['cur_id']==$order_price['cur_id'])?"selected":"";?>><?php echo $all_currencies[$i]['cur_short'];?></option>
										<?php
									}
									?>	
								</select>
							</div>		
							<div class="col-md-2" style="width:160px;">							
								<input class="form-control" type="text" id="payment_date" name="payment_date" value="" style="width:150px;">	
							</div>	
							<div class="col-md-2">
								<label>Date of payment</label>		
							</div>
					</div>
					
					<div class="form-group row">							
						<div class="col-md-2" style="width:130px;">							
							<label>Reference</label>
						</div>
						<div class="col-md-6">
							<input class="form-control" type="text" name="reference" value="" style="width:620px;">
						</div>
					</div>
					<div class="form-group row">
						<div style="width:350px; margin: auto;">
							<button name="create_btn" class="btn btn-primary btn-sm" type="submit">Create</button>
						</div>
					</div>
				</form>
				</div>
				<br>
				<?php
				}
			}
			else
			{
			?>
			<div class="container-fluid bg-white px-0">
                <table class="table table-striped text-center">
                    <thead>
                        <th scope="col">Payment ID</th>
                        <th scope="col">Date of payment</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payer</th>
                        <th scope="col">Bank account</th>
                        <th scope="col">Reference</th>
                        <th scope="col"></th>
                    </thead>
				<?php
				$payment=$domenia3->show_payments();
				
				for($i=0;$i<count($payment);$i++)
				{
                    ?>
                    <tr id="row<?php echo $payment[$i]['pay_id'];?>">
                        <td><?php echo "<b>".$payment[$i]['pay_id']."</b>"; ?></td>
                        <td><?php echo $payment[$i]['date']; ?></td>
                        <td><?php echo "<b>".$payment[$i]['o_id']."</b>"?></td>
                        <td><?php echo $payment[$i]['amount']." ".$payment[$i]['currency']; ?></td>
                        <td><?php echo $payment[$i]['payer'];?></td>
                        <td><?php echo $payment[$i]['bank_account']; ?>	</td>
                        <td><?php echo $payment[$i]['reference']; ?></td>
                        <td>
                        <a href="book.php?option=modify&payid=<?php echo $payment[$i]['pay_id'];?>" class="btn btn-primary btn-sm">Modify</a>
                        <button id="delete_btn<?php echo $payment[$i]['pay_id'];?>" data-pay_id="<?php echo $payment[$i]['pay_id'];?>" class="btn btn-sm btn-danger">X</button>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            $('#delete_btn<?php echo $payment[$i]['pay_id'];?>').click(function(){

                                if(confirm('Are you sure you want to delete this booking ?\nThis is a permanent delete !')) 
                                {
                                    $.ajax({
                                        url: "../ajax/delete_payment.php",
                                        method: "post",
                                        data: {pay_id:$(this).data('pay_id')},
                                        dataType:"html",
                                        success:function(data) {
                                            //console.log(data);	
                                            $('#row<?php echo $payment[$i]['pay_id'];?>').fadeOut(3000);
                                        }
                                    });
                                }

                            });
                        });
                        </script>
                        </td>
                    </tr>			
				<?php
				} //end for
            ?>
            </table>
			<br>
			<hr style="border:5px solid black">
            <br>
            <table class="table table-striped text-center">
                <thead>
                    <th scope="col">Order ID</th>
                    <th scope="col">Licence ID</th>
                    <th scope="col">Client name</th>
                    <th scope="col">Amount with VAT</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </thead>
            
			<!-- <div class="row w-100 mx-0 border">
				<div class="col-md-1 border-right py-1 text-center">
					<b>Order ID</b> 
				</div>				
				<div class="col-md-1 border-right py-1 text-center">
					<b>Licence ID</b>
				</div>
				<div class="col-md-2 border-right py-1 text-center">
					<b>Client name</b>
				</div>
				<div class="col-md-2 border-right py-1 text-center">
					<b>Amount with VAT</b>
				</div>
			</div> -->
			<?php
			$orders=$prod->show_1_9_orders();
			$unpaid=array();
			
			$z=0;
			for($i=0;$i<10/*count($orders)*/;$i++)
			{
				$payment_amount=$domenia3->get_payment_amount($orders[$i]['order_ID']);
				$total_paid=0;
				$rest=0;
				for($k=0;$k<count($payment_amount);$k++)
				{
					
					$total_paid += $payment_amount[$k]['amount'];
				}
				
				$o_desc_in_b3=$prod->get_o_desc_in_b3($orders[$i]['order_ID']);
				
				$o_desc_ex_b5=$prod->get_o_desc_ex_b5($orders[$i]['order_ID']);
				
				if($orders[$i]['o_special_agreement_price']==0)
				{
					$rest=$orders[$i]['brut_price']-$total_paid;
				}
				else
				{
					$rest=$orders[$i]['o_special_agreement_price']-$total_paid;
				}
				if($orders[$i]['brut_price']>$total_paid)
				{
					$unpaid[$z]['order_ID']=$orders[$i]['order_ID'];
					$unpaid[$z]['lic_ID']=$orders[$i]['lic_ID'];
					$client=$prod->get_client($orders[$i]['u_client_ID']);
					$unpaid[$z]['u_client_ID']=$orders[$i]['u_client_ID'];
					$unpaid[$z]['clientname']=$client['clientname'];
					if($orders[$i]['o_special_agreement_price']==0)
					{
						$unpaid[$z]['brut_price']=$orders[$i]['brut_price'];
					}
					else
					{
						$unpaid[$z]['brut_price']=$orders[$i]['o_special_agreement_price'];
					}
					$licence=$prod->get_licence($orders[$i]['lic_ID']);
                    //$currency=$prod->get_currency($licence['currencies']);
                    $currency=$prod->get_currency($orders[$i]['cur_id']);
					$unpaid[$z]['currency']=$currency['cur_short'];
					$unpaid[$z]['total_paid']=$total_paid;
					$unpaid[$z]['rest']=$rest;
					$z++;
				}				
			}
			
			for($i=0;$i<10/*count($unpaid)*/;$i++)//has to be made with multiple pages
			{
                ?>
                <tr>
                    <td><?php echo $unpaid[$i]['order_ID']; ?></td>
                    <td><?php echo $unpaid[$i]['lic_ID']; ?></td>
                    <td><?php echo $unpaid[$i]['clientname']; ?></td>
                    <td><?php echo $unpaid[$i]['brut_price']." ".$unpaid[$i]['currency']; ?></td>
                    <td><b>Paid : <?php echo $unpaid[$i]['total_paid']; ?></b></td>
                    <td><b>Rest : <?php echo $unpaid[$i]['rest']; ?> <span class="error">Unpaid</span>
						</b></td>
                    <td><a class="btn btn-primary btn-sm" href="invoice.php?option=create&type=simple_invoice&o_id=<?php echo $unpaid[$i]['order_ID'];?>">Preview invoice</a></td>
                </tr>
				
				<?php
				//}
			}
			?>
			</table>
			Not showing all unpaid invoices. Has to be made with multiple pages.
			</div> <!-- end fluid container -->
			<br>
			<?php
			}// end else
		}
		else
		{
			?>
			<div class="center_message">
				
				<div class="error">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
		</article>
		
</section>
</div> <!-- end container fluid -->
<script type="text/javascript" src="js/books.js"></script>
<?php include('../footer.php'); ?>