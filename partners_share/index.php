<?php
session_start();

include('../functions.php');

$prod=new Production;
$_SESSION['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');
?>

<?php 

$from = date('Y-m-d', strtotime('first day of last month'));
$to = date('Y-m-d', strtotime('last day of last month'));
$partners = $prod->get_all_partners();

?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="top_section">
	<article>
	<div class="container mb-5 pagecontent bg-white px-5 pb-5">
	<br><br>
		<?php if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire'])) {
			if($_SESSION['useradmin'] > 0)
			{
				 ?>

        	<!--  -->
            <div class="row">
				<div class="col">
					<div class="btn-toolbar">
						<div class="btn-group">
						    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#findShares">Find All Shares</button>
					  	</div>

					  	<div class="btn-group ml-3">
						    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#findByUser">Find by Partner</button>
					  	</div>

					</div>
				</div>

				<div class="modal fade" id="findShares" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form action="find.php" method="get">
								<div class="modal-header">
									<h5 class="modal-title">Find Shares</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group">
									    <label for="from">From:</label>
									    <input type="text" class="form-control" name="from" autocomplete="off" id="from" placeholder="" value="<?=$from?>">
								  </div>

								  <div class="form-group">
									    <label for="to">To:</label>
									    <input type="text" class="form-control" name="to" autocomplete="off" id="to" placeholder="" value="<?=$to?>">
								  </div>
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
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">Find</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</form>
						</div>
					</div>
				</div>


				<div class="modal fade" id="findByUser" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form action="find_by_partner.php" method="get">
								<div class="modal-header">
									<h5 class="modal-title">Find Shares by Partner</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group">
									    <label for="from2">From:</label>
									    <input type="text" class="form-control" autocomplete="off" name="from" id="from2" placeholder="" value="<?=$from?>">
								  	</div>

								  	<div class="form-group">
									    <label for="to2">To:</label>
									    <input type="text" class="form-control" autocomplete="off" name="to" id="to2" placeholder="" value="<?=$to?>">
								  	</div>

								  	<div class="form-group">
										<label for="partner">Partner: </label>
										<input list="partners" class="form-control" autocomplete="off" id="partner" name="partner">
										<datalist id="partners">
											<?php foreach($partners as $partner):?>
										    	<option value="<?=$partner['email']?>">
										    <?php endforeach;?>
										</datalist>

										<div class="col m-0 p-0">
											<div id="sponsor_message"></div>
										</div>
										<script type="text/javascript">

				                            $('#partner').change(function(){
				                                check_sponsor();
				                            });

				                            function check_sponsor()
				                            {
				                                $.ajax({
				                                    type: 'POST',
				                                    url: 'ajax/check_partner.php',
				                                    data: {sponsor: $('#partner').val()},
				                                    success: function(data){
				                                        $('#sponsor_message').html(data);
				                                    }
				                                });
				                            }
				                        </script>	
					                </div>

								  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
								  	<script type="text/javascript">
		                                $(document).ready(function(){
		                                    $('#from2').datepicker({
		                                        changeMonth: true,
		                                        changeYear: true,
		                                        yearRange: "-100:+0",
		                                        dateFormat: "yy-mm-dd"
		                                    });

		                                    $('#to2').datepicker({
		                                        changeMonth: true,
		                                        changeYear: true,
		                                        yearRange: "-100:+0",
		                                        dateFormat: "yy-mm-dd"
		                                    });
		                                });
	                                </script>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">Find</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
            <!--  -->

        <?php 
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