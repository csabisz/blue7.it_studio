<?php
session_start();

if(!isset($_GET['from']) || !isset($_GET['to'])) {

	header('Location: https://cseven.eu/partners_share/index.php');
}

include('../functions.php');

$prod=new Production;
$_SESSION['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');
?>

<?php 

$from = $_GET['from'];
$to = $_GET['to'];
$orders = $prod->get_orders_by_daterange($from, $to);
$shares=build_shares($orders);

function get_percent_of($percent, $num) {

		return ($percent / 100) * $num;
	}

function array_flatten($array) { 

	if (!is_array($array)) { 

		return false; 
	} 

	$result = []; 

	foreach ($array as $key => $value) { 

		if (is_array($value)) { 

			$result = array_merge($result, array_flatten($value)); 
		} 
		else { 

			$result[$key] = $value; 
		} 
	} 

	return $result; 
} 

function get_ref_chain($user_id, $depth = 0) {

		global $prod;

		$chain = [];
		$max_level = 4;
		
		if($depth<$max_level) {

			$user = $prod->get_user_by_id($user_id);
			$chain[$depth] = $user['client_ID'];
			$chain['parrent_'.$depth] = ($user['referrer_id']) ? get_ref_chain($user['referrer_id'], ++$depth) : [];
		}

		return $chain;
	}

function build_shares($orders)  {	

	/**/

		global $prod;

		$options = [

			'generation_1_percent' => 10,
			'generation_2_percent' => 5,
			'generation_3_percent' => 3,
			'generation_4_percent' => 2,
		];

		$c=0;
		$shares=[];
		foreach ($orders as $order) {

			$ref_chain = array_flatten(get_ref_chain($order['u_client_ID']));

			if(isset($ref_chain[1])) {

				//print_r($ref_chain);
				//echo 'orderID='.$order->id.'<br>';

				$shares[$c]['order'] = [

								'id' => $order['order_ID'],
								'user_id' => $order['u_client_ID'],
								'email' => $prod->get_user_by_id($order['u_client_ID'])['email'],
								'order_name' => $order['order_name'],
								'total_price' => $order['o_price'] == 0 ? $order['o_special_agreement_price'] : $order['o_price'],
								'created_at' => $order['o_date'],
								'order_price' => $order['o_price'],
								'o_special_agreement_price' => $order['o_special_agreement_price'],
								'vat_percent' => $order['vat_percent'],
							    'vat_amount' => $order['vat_amount'],
							    'vat_a_id' => $order['vat_a_id'],
							    'brut_price' => $order['brut_price']
							];

				$generations=[];

				$partner = $prod->get_user_by_id($ref_chain[0]);

				$g = 0;
				$pre_counter = 1;
				$post_counter = 4;

				if($partner['partner_since'] !== null) {

					if(strtotime($order['o_date']) > strtotime($partner['partner_since'])) {

						//echo $partner->username.' is partner since '.$partner->partner_since.'. Ordered at '.$order->created_at.'.<br>';

						$pre_counter = 0;
						//$post_counter = 4;
					}
					
				}

				for($i=$pre_counter; $i<=$post_counter; $i++) {
					

					if(isset($ref_chain[$i])) {

						$g++;

						//echo '1. g='.$g. ' i='.$i.'<br>';

						$user = $prod->get_user_by_id($ref_chain[$i]);
						
						$generations[$g]['user'] = [

									'id' => $user['client_ID'],
									'email' => $user['email'],
									// 'name' => $user->name,
									// 'lastname' => $user->lastname,
								];

						$generations[$g]['generation'] = $g;

						$percent = 0;

						switch ($g) {
							case 4:
								$percent = $options['generation_4_percent'];
								break;
							case 3:
								$percent = $options['generation_3_percent'];
								break;
							case 2:
								$percent = $options['generation_2_percent'];
								break;
							case 1:
								$percent = $options['generation_1_percent'];
								break;
							
							// default:
							// 	$percent = $options->generation_1_percent;
							// 	break;
						}

						$generations[$g]['percent'] = $percent;
						$generations[$g]['share'] = get_percent_of($percent, $order['o_price'] != 0 ? $order['o_price'] : $order['o_special_agreement_price']);
						
					}

				}

				//echo 'End of 1 loop. g='.$g.'<br>';
				

				for($i=count($generations)+1; $i<=$post_counter; $i++) {

					if($g<=6) {

						$g++;

						//echo '2. g='.$g.' i='.$i.'<br>';

						$user = $this->user_model->get_user_by_id($ref_chain[count($ref_chain)-1]);
						
						$generations[$g]['user'] = [

									'id' => $user['client_ID'],
									'email' => $user['email'],
									// 'name' => $user->name,
									// 'lastname' => $user->lastname,
								];

						$generations[$g]['generation'] = $g;

						$percent = 0;

						switch ($g) {
							case 4:
								$percent = $options->generation_4_percent;
								break;
							case 3:
								$percent = $options->generation_3_percent;
								break;
							case 2:
								$percent = $options->generation_2_percent;
								break;
							case 1:
								$percent = $options->generation_1_percent;
								break;
							
							// default:
							// 	$percent = $options->generation_1_percent;
							// 	break;
						}

						$generations[$g]['percent'] = $percent;
						$generations[$g]['share'] = get_percent_of($percent, $order['o_price'] != 0 ? $order['o_price'] : $order['o_special_agreement_price']);
						
					}
				}

				if(isset($generations)) {

					$shares[$c]['generations'] = $generations;
				}
			}

			$c++;
			
		}

		return $shares;
		/**/
}

?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="top_section">
	<article>
	<div class="container mb-5 pagecontent bg-white px-5 pb-5">
	<br><br>
		<?php if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire'])) { ?>

        	<!--  -->
            <div class="row">
				<div class="card-body">
					<div class="row">
						<form class="" method="get">
							<div class="form-inline">
								<div class="form-group">
								    <label class="m-3" for="from">From: </label>
								    <input type="text" class="form-control" name="from" autocomplete="off" id="from" placeholder="" value="<?=$from?>">
							  	</div>

							  	<div class="form-group ml-3">
								    <label class="m-3" for="to">To: </label>
								    <input type="text" class="form-control" name="to" autocomplete="off" id="to" placeholder="" value="<?=$to?>">
							  	</div>

							  	<div class="form-group ml-3"><button type="submit" class="btn btn-primary">Set</button></div>

							  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
							  	<script type="text/javascript">
				            	$(document).ready(function(){
				                    $('#from').datepicker({
				                        changeMonth: true,
				                        changeYear: true,
				                        yearRange: "-100:+0",
				                        dateFormat: "yy-mm-dd"
				                    });

				                    $('#to').datepicker({
				                        changeMonth: true,
				                        changeYear: true,
				                        yearRange: "-100:+0",
				                        dateFormat: "yy-mm-dd"
				                    });
				                });

				                </script>
							</div>
						</form>
					</div>
					<!-- <div class="row">
						<form method="get">
							<div class="form-inline">
								<input type="hidden" name="from" value="<?=$_GET['from']?>">
								<input type="hidden" name="to" value="<?=$_GET['to']?>">
								<div class="form-group ml-3"><button type="submit" name="savePDF" class="btn btn-primary"><?=($pdf) ? 'Save' : 'Save'?> PDF</button></div>

								<?php if($pdf): ?>
									<div class="form-group ml-3"><a href="<?=base_url().$pdf?>" class="btn btn-success">Open PDF</a></div>
								<?php endif;?>
							</div>
						</form>
					</div> -->
					<div class="row m-1">
						<table id="top_row_total"></table>
				        <script type="text/javascript">
				        $(document).ready(function(){
				            $('#top_row_total').html($('#bottom_row_total').html());
				            $('#top_row_total').addClass('table m-5 table-sm w-auto');
				        });
				        </script>

						<?php 
						$totals=[];
						$users_totals=[];
						?>
						<?php $c=0;?>

						<?=(empty($shares)) ? '<div class="alert alert-warning w-100">Not found shares for this period.</div>' : '';?>

						<?php //print_r($shares);?>

						<?php foreach($shares as $share) { ?>

								<div class="card w-100 mb-3">
									<div class="card-body">
										<div class="row">
											<div class="col">

												<table class="table table-sm">
													<tbody>
														<tr>
															<th style="width: 30%" scope="row">Buyer: <a href="#"><?=$share['order']['email']?></a></th>
															<td ><a href="#">id<?=$share['order']['id']?></a></td>

															<th style="width: 30%" scope="row">Seller: </th>
															<td>
																<?php
																	foreach($share['generations'] as $generation) {
																		
																		echo '<a href="#">'.$generation['user']['email'].'</a>';
																		break;
																	}

																?>
															</td>
														</tr>
														<tr>
															<th scope="row">Order Price: </th>
															<td><?=$share['order']['total_price']?> EUR</td>

															<th scope="row">Ordered at: </th>
															<td><?=$share['order']['created_at']?></td>
														</tr>

														<?php 
														$totals = [];
														?>
														<?php foreach($share['generations'] as $generation) { ?>
															<?php if($generation['generation'] <= 4):?>
															<tr class="striped">
																<th scope="row" colspan="2"><b>Relation <?=$generation['generation'].', '.$generation['percent'].'%, <a href="$">'.$generation['user']['email']?>'s</a> share: </b></th>
																<td>(<?=$generation['percent']?>/100) * <?=$share['order']['total_price']?> = <b><?=$generation['share']?> EUR</b></td>
																<td></td>
															</tr>
															<?php endif;?>
														<?php } ?>

													</tbody>
												</table>

												<?php 
												$totals[$c] = [];
												?>
												<?php foreach($share['generations'] as $generation) { ?>

												<?php 
												if(array_key_exists($generation['user']['id'], $totals[$c])) {

													array_push($totals[$c][$generation['user']['id']]['totals'], $generation['share']);
												}
												else {

													$totals[$c][$generation['user']['id']]['id']=$generation['user']['id'];
													$totals[$c][$generation['user']['id']]['email']=$generation['user']['email'];
													$totals[$c][$generation['user']['id']]['totals']=[$generation['share']];
												}
												?>
												<?php } ?>

														<?php foreach($totals[$c] as $total) { ?>
																<?php
																	if(count($total['totals'])>1) {

																		$c=1;
																		foreach($total['totals'] as $sum) {

																			//echo $sum.(($c < count($total['totals'])) ? ' + ' : '');
																			//echo (($c === count($total['totals'])) ? ' = ' : '');
																			$c++;
																		}
																	}

																	$users_totals[$total['id']]['id'] = $total['id'];
																	$users_totals[$total['id']]['email'] = $total['email'];
																	$users_totals[$total['id']]['totals'][] = array_sum($total['totals']);

																	//array_push($users_totals[$total['id']]['totals'], array_sum($total['totals'])); 

																	//echo '<b>'.array_sum($total['totals']).'</b>'; 
																?>
															<!-- </td>
														</tr> -->
														<?php } ?>
													<!-- </tbody>
												</table> -->
												
											</div>
										</div>
									</div>
								</div>
							<?php $c++;?>
							<?php } ?>

							<?php if(!empty($users_totals)):?>
							<table id="bottom_row_total" class="table m-5 table-sm w-auto">
								<thead>
									<tr>
										<th colspan="2" scope="col"><h4><b>Total</b></h4><p style="display:inline">For period </p><p class="font-weight-light" style="display:inline"><?=$from.' - '.$to?></p></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									function compareByName($a, $b) {
									  return strcmp(strtolower($a["email"]), strtolower($b["email"]));
									}
									usort($users_totals, 'compareByName');
									?>
									<?php
									foreach ($users_totals as $user_total):
									?>
									<tr>
										<th><a href="#"><?=$user_total['email']?></a></th>
										<td><?=number_format(array_sum($user_total['totals']), 2, '.', ' ')?></td>
									</tr>
									<?php endforeach;?>

								</tbody>
							</table>
							<?php endif;?>

					</div>
				</div>
			</div>
            <!--  -->

        <?php 
    	}
    	else{

            session_unset();
            session_destroy();
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
    </div>	<!-- end container -->
	</article>
</section>

<?php
include('../footer.php');
?>