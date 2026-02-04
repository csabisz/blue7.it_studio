<?php
//session_set_cookie_params(14400,"/books");
session_start();
include('../functions.php');
include('../domenia_db3.php');
$prod=new Production;
$domenia3=new Domenia3;

$page_title="Books";

include('../header2.php');
include('../menu.php');

?>
<div class="container-fluid">
<section class="top_section">
	
		<article class="mx-5">
		<?php
		if(isset($_COOKIE['client_id']))
		{
			include('submenu.php');
		?>
            <p class="display-4 w-100 text-center">Orders ready and open to make an invoice</p>
			<br>
			<?php
			
			$orders=$prod->show_1_9_orders();
			$paid=array();
			$unpaid=array();
			$overpaid=array();
			
			$z=0;
			for($i=0;$i<count($orders);$i++)
			{
				$payment_amount=$domenia3->get_payment_amount($orders[$i]['order_ID']);
				$total_paid=0;
				$rest=0;
				for($k=0;$k<count($payment_amount);$k++)
				{
					
					$total_paid += $payment_amount[$k]['amount'];
				}
                //echo $total_paid." ".$orders[$i]['o_price']."<br>";
                if($orders[$i]['o_special_agreement_price']==0)
                {
                    $rest=$orders[$i]['brut_price']-$total_paid;
                    if($orders[$i]['brut_price']==$total_paid)
                    {
                        $paid[$z]['order_ID']=$orders[$i]['order_ID'];
                        $paid[$z]['lic_ID']=$orders[$i]['lic_ID'];
                        $client=$prod->get_client($orders[$i]['u_client_ID']);
                        $paid[$z]['u_client_ID']=$orders[$i]['u_client_ID'];
                        $paid[$z]['clientname']=$client['clientname'];
                        $paid[$z]['brut_price']=$orders[$i]['brut_price'];
                        $licence=$prod->get_licence($orders[$i]['lic_ID']);
                        $currency=$prod->get_currency($licence['currencies']);
                        $paid[$z]['currency']=$currency['cur_short'];
                        $paid[$z]['total_paid']=$total_paid;
                        $paid[$z]['rest']=$rest;
                        $z++;
                    }
                }
                else
                {
                    $seller=$prod->get_licence_taker($orders[$i]['order_ID']);
                    $client=$prod->get_client($orders[$i]['u_client_ID']);

                    $vat=$prod->get_vat($seller['a_id']);

                    $o_special_agreement_price_vat=0;

                    if(!empty($seller['VAT-tax no.']))
                    {
                        
                        if(($vat['a_eu']=="1")&&($orders[$i]['payment_way']!=9))
                        {
                            $o_special_agreement_price_vat=(bcdiv($orders[$i]['o_special_agreement_price']*$vat['a_vat']/100,1,2));
                        }
                        else
                        {
                            if(($seller['a_id']==$client['a_id'])&&($orders[$i]['payment_way']!=9))
                            {
                                $o_special_agreement_price_vat=(bcdiv($orders[$i]['o_special_agreement_price']*$vat['a_vat']/100,1,2));
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

                    $rest=$orders[$i]['o_special_agreement_price']+$o_special_agreement_price_vat-$total_paid;

                    if(($orders[$i]['o_special_agreement_price']+$o_special_agreement_price_vat)==$total_paid)
                    {
                        $paid[$z]['order_ID']=$orders[$i]['order_ID'];
                        $paid[$z]['lic_ID']=$orders[$i]['lic_ID'];
                        
                        $paid[$z]['u_client_ID']=$orders[$i]['u_client_ID'];
                        $paid[$z]['clientname']=$client['clientname'];
                        $paid[$z]['brut_price']=$orders[$i]['o_special_agreement_price']+$o_special_agreement_price_vat;
                        $licence=$prod->get_licence($orders[$i]['lic_ID']);
                        $currency=$prod->get_currency($licence['currencies']);
                        $paid[$z]['currency']=$currency['cur_short'];
                        $paid[$z]['total_paid']=$total_paid;
                        $paid[$z]['rest']=$rest;
                        $z++;
                    }
                }
			}
			
			$z=0;
			for($i=0;$i<count($orders);$i++)
			{
				$payment_amount=$domenia3->get_payment_amount($orders[$i]['order_ID']);
				$total_paid=0;
				$rest=0;
				for($k=0;$k<count($payment_amount);$k++)
				{
					
					$total_paid += $payment_amount[$k]['amount'];
				}
                
                if($orders[$i]['o_special_agreement_price']==0)
                {
                    $rest=$orders[$i]['brut_price']-$total_paid;
                    if($orders[$i]['brut_price']<$total_paid)
                    {
                        $overpaid[$z]['order_ID']=$orders[$i]['order_ID'];
                        $overpaid[$z]['lic_ID']=$orders[$i]['lic_ID'];
                        $client=$prod->get_client($orders[$i]['u_client_ID']);
                        $overpaid[$z]['u_client_ID']=$orders[$i]['u_client_ID'];
                        $overpaid[$z]['clientname']=$client['clientname'];
                        $overpaid[$z]['brut_price']=$orders[$i]['brut_price'];
                        $licence=$prod->get_licence($orders[$i]['lic_ID']);
                        $currency=$prod->get_currency($licence['currencies']);
                        $overpaid[$z]['currency']=$currency['cur_short'];
                        $overpaid[$z]['total_paid']=$total_paid;
                        $overpaid[$z]['rest']=$rest;
                        $z++;
                    }
                }
                else
                {
                    $seller=$prod->get_licence_taker($orders[$i]['order_ID']);
                    $client=$prod->get_client($orders[$i]['u_client_ID']);
                    
                    $vat=$prod->get_vat($seller['a_id']);

                    $o_special_agreement_price_vat=0;

                    if(!empty($seller['VAT-tax no.']))
                    {
                        
                        if(($vat['a_eu']=="1")&&($orders[$i]['payment_way']!=9))
                        {
                            $o_special_agreement_price_vat=(bcdiv($orders[$i]['o_special_agreement_price']*$vat['a_vat']/100,1,2));
                        }
                        else
                        {
                            if(($seller['a_id']==$client['a_id'])&&($orders[$i]['payment_way']!=9))
                            {
                                $o_special_agreement_price_vat=(bcdiv($orders[$i]['o_special_agreement_price']*$vat['a_vat']/100,1,2));
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
                    
                    $rest=$orders[$i]['o_special_agreement_price']+$o_special_agreement_price_vat-$total_paid;

                    if(($orders[$i]['o_special_agreement_price']+$o_special_agreement_price_vat)<$total_paid)
                    {
                        $overpaid[$z]['order_ID']=$orders[$i]['order_ID'];
                        $overpaid[$z]['lic_ID']=$orders[$i]['lic_ID'];
                        
                        $overpaid[$z]['u_client_ID']=$orders[$i]['u_client_ID'];
                        $overpaid[$z]['clientname']=$client['clientname'];
                        $overpaid[$z]['brut_price']=$orders[$i]['o_special_agreement_price']+$o_special_agreement_price_vat;
                        $licence=$prod->get_licence($orders[$i]['lic_ID']);
                        $currency=$prod->get_currency($licence['currencies']);
                        $overpaid[$z]['currency']=$currency['cur_short'];
                        $overpaid[$z]['total_paid']=$total_paid;
                        $overpaid[$z]['rest']=$rest;
                        $z++;
                    }
                }
			}
			
            ?>
            <table class="table table-striped text-center">
                <thead>
                    <th>Order ID</th>
                    <th>Licence ID</th>
                    <th>Client name</th>
                    <th>Amount with VAT</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </thead>
			<?php
			for($i=0;$i<count($paid);$i++)
			{
				$invoice=$domenia3->get_invoice_id($paid[$i]['lic_ID'],$paid[$i]['order_ID'],$paid[$i]['u_client_ID']);
				if($paid[$i]['order_ID']!=$invoice['o_id'])
				{
                ?>
                <tr>
                    <td><?php echo $paid[$i]['order_ID']; ?></td>
                    <td><?php echo $paid[$i]['lic_ID']; ?></td>
                    <td><?php echo $paid[$i]['clientname']; ?></td>
                    <td><?php echo $paid[$i]['brut_price']." ".$paid[$i]['currency']; ?></td>
                    <td>Paid : <?php echo $paid[$i]['total_paid']; ?></td>
                    <td>Rest : <?php echo $paid[$i]['rest']; ?> Paid</td>
                    <td><a class="btn btn-primary btn-sm align-self-center" href="invoice.php?option=create&type=simple_invoice&o_id=<?php echo $paid[$i]['order_ID'];?>">Preview invoice</a></td>
                </tr>
				<?php
				}
			}
            ?>
            </table>
			<br>
			<hr style="border:5px solid black" />
			<br>
			<?php
           
			for($i=0;$i<count($overpaid);$i++)
			{
				//if(!empty($unpaid[$i]['order_ID']))
				//{
				?>
				<div class="row colorline">
					<div class="col-md-1">
						<?php echo $overpaid[$i]['order_ID']; ?>
					</div>
					<div class="col-md-1">
						<?php echo $overpaid[$i]['lic_ID']; ?>
					</div>
					<div class="col-md-2">
						<?php echo $overpaid[$i]['clientname']; ?>
					</div>
					<div class="col-md-2" style="width:150px;">
						<?php echo $overpaid[$i]['brut_price']." ".$overpaid[$i]['currency']; ?>
					</div>
					<div class="col-md-2" style="width:130px;">					
							<strong>Paid : <?php echo $overpaid[$i]['total_paid']; ?></strong>
					</div>
					<div class="col-md-3" style="width:200px;">
						<strong>Rest : <?php echo $overpaid[$i]['rest']; ?> <span class="text-warning">Overpaid</span>
						</strong>	
					</div>
					<div class="col-md-2">
						<a class="btn btn-primary btn-sm" href="invoice.php?option=create&type=simple_invoice&o_id=<?php echo $overpaid[$i]['order_ID'];?>">Preview invoice</a>
					</div>	
				</div>
				<?php
				//}
			}
			?>
				<br> 
		<?php
		} //logged in
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
<?php
include('../footer.php');
?>