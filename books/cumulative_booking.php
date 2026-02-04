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
<section class="top_section mx-5">	
		<article class="pagecontent px-0 py-4 bg-white">
		<?php
		if(isset($_COOKIE['client_id']))
		{
			include('submenu.php');
			?>
            <p class="display-4 w-100 text-center">Cumulative Booking</p>
					<hr>
					<br>
					<form name="cumulative_booking" method="post" enctype="multipart/form-data" action="cumulative_booking.php">
					<div class="row w-100 mx-0 d-flex justify-content-center">
						<div class="col-md-2 d-flex">					
							<select id="main_client" name="main_client" class="form-control form-control-sm align-self-center mt-3" style="width:200px;" required>
								<option value="">-- Select main client --</option>	
								<?php
								$main_clients=$prod->get_all_main_clients();
								for($i=0;$i<count($main_clients);$i++)
								{
								?>
								<option value="<?php echo $main_clients[$i]['mc_id'];?>" <?php echo ($main_clients[$i]['mc_id']==$_POST['main_client'])?"selected":""?>><?php echo $main_clients[$i]['clientname'];?></option>	
								<?php
								}
							?>
							</select>
						</div>
						
						
						
					
						<div class="col-md-2">
							<div class="form-group">
								<label for="startdate">Start date:</label>
								<input type="text" name="order_start_date" id="order_start_date" class="form-control form-control-sm" value="<?php echo (isset($_POST['order_start_date'])?$_POST['order_start_date']:"");?>" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="enddate">End date:</label>
								<input type="text" name="order_end_date" id="order_end_date" class="form-control form-control-sm" value="<?php echo (isset($_POST['order_end_date'])?$_POST['order_end_date']:"");?>" required>
							</div>
						</div>
						<div class="col-md-2 d-flex">
							<button type="submit" name="show_orders_btn" class="btn btn-sm btn-primary align-self-center mt-3">Show orders</button>
						</div>
					</div>	
					<script type="text/javascript">
					$('#order_start_date').datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat: "yy-mm-dd"						
					});
					
					$('#order_end_date').datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat: "yy-mm-dd"						
					});
					</script>
					<br>
					<?php
					if(isset($_POST['show_orders_btn']))
					{
						$mc_id=$prod->xss_fix($_POST['main_client']);
						$order_start_date=$prod->xss_fix($_POST['order_start_date']);
						$order_end_date=$prod->xss_fix($_POST['order_end_date']);
						
						$cumulative_order=$prod->get_all_cumulative_orders($mc_id,$order_start_date,$order_end_date);
						
						$total_brut_price=0;
						
						?>
						<div class="row">
							<div class="col-md-1">
								<b>Order ID</b>
							</div>
							<div class="col-md-2">
								<b>Date</b>
							</div>
							<div class="col-md-2">
								<b>Project name</b>
							</div>
							<div class="col-md-2">
								<b>by</b>
							</div>
							<div class="col-md-2">
								<b>Brut price</b>
							</div>
						</div>
						<?php
						for($i=0;$i<count($cumulative_order);$i++)
						{
							?>
						<div class="row">
							<div class="col-md-1">
								<?php echo $cumulative_order[$i]['order_ID'];?>
							</div>
							<div class="col-md-2">
								<?php echo $cumulative_order[$i]['o_date'];?>
							</div>
							<div class="col-md-2">
								<?php echo $cumulative_order[$i]['order_name'];?>
							</div>
							<div class="col-md-2">
								<?php 
								$client=$prod->get_client($cumulative_order[$i]['u_client_ID']);						
								echo $client['l_title']." ".$client['l_first_name']." ".$client['l_last_name'];?>
							</div>
							<div class="col-md-2">
								<?php
								$licence=$prod->get_licence($cumulative_order[$i]['lic_ID']);
								$cur_short=$prod->get_currency($licence['currencies'])['cur_short'];
								
								echo $cumulative_order[$i]['brut_price']."&nbsp;".$cur_short;	
								$total_brut_price +=$cumulative_order[$i]['brut_price'];
								?>
							</div>
						</div>	
							<?php
						}
						?>
						<br>
						<div class="row">
							<div class="col-md-12">
							<b>Total = <?php echo $total_brut_price;?></b>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-2">
								<div class="form-inline">
								Payer <input type="text" name="payer" class="form-control form-control-sm">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-inline">
								Date of payment <input type="text" id="date_of_payment" name="date_of_payment" class="form-control form-control-sm">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-inline">
								Bank account <input type="text" name="bank_account" class="form-control form-control-sm"> 
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-inline">
								Reference <input type="text" name="reference" class="form-control form-control-sm">
								</div>
							</div>
							<div class="col-md-1">
								<button type="submit" class="btn btn-sm btn-primary">Create booking</button>
							</div>
						</div>
						<br>
						<?php
					}
					?>
					<script type="text/javascript">
					$('#date_of_payment').datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat: "yy-mm-dd"						
					});

					</script>
					<?php
		}
		else
		{
			?>
			<div class="center_message">
				
				<div class="error">You must be logged in to view this page !</div>
				<a href="../login.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=../login.php">
			<?php
		}
		?>
		</article>
		
</section>
</div> <!-- end container fluid -->
<script type="text/javascript" src="js/books.js"></script>
<?php include('../footer.php'); ?>