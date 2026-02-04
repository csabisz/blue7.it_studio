<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Create Main Client Position";

include('../header2.php');
include('../menu.php');
?>
<section  class="top_section">
	<article>
	<div class="container pagecontent bg-white px-0">
	<?php
	if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
	{									
		?>
        <p class="w-100 text-center display-4 pt-3">New Main Client Position</p>
        <hr class="mb-4" width="450px">
		<?php 
			

			if(isset($_POST['create_btn']))
			{
                $register_data['ucb_id']=$prod->xss_fix($_POST['ucb_id']);
				$register_data['mc_id']=$prod->xss_fix($_POST['mc_id']);
				$register_data['position_nr']=$prod->xss_fix($_POST['position']);
				$register_data['boss_c_id']=$prod->xss_fix($_POST['boss_c_id']);				
				
				$prod->update_main_client_position(json_encode($register_data));
				
				?>
				<div class="text-center">
					<div class="alert alert-success">
						Saved successfully !
					</div>	
				</div>
				<br>
				<meta http-equiv="refresh" content="2; url=index.php"> 
				<?php
								
			}

            $ucb_id=$prod->xss_fix($_GET['ucb_id']);

            $main_client_position=$prod->get_main_client_position($ucb_id);
		?>

		<form name="update_form" id="update_form" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?ucb_id=<?php echo $ucb_id;?>" enctype="multipart/form-data"></form>
			<div class="row mx-0 w-100 my-2 border py-4">
				<div class="col-md-6 pr-0">            
					<div class="row w-100 mx-0">
						<div class="col-md-5">
							<label for="mc_id">Main client<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
						</div>
						<div class="col-md-5">
                            <input type="hidden" name="ucb_id" value="<?php echo $ucb_id;?>" form="update_form">
							<select id="mc_id" name="mc_id" class="form-control form-control-sm border-danger" form="update_form" required>
							<option value="">-- Select --</option>
							<option value="0">Main client</option>
							<?php
							$mainclients=$prod->get_all_main_clients();

							for($i=0;$i<count($mainclients);$i++)
							{
								?>
								<option value="<?php echo $mainclients[$i]['mc_id'];?>" <?php echo ($main_client_position['mc_id']==$mainclients[$i]['mc_id'])?"selected":"";?>><?php echo $mainclients[$i]['clientname'];?></option>
								<?php
							}
							?>
							</select>
						</div>
					</div>
					<div class="row w-100 mx-0">
						<div class="col-md-5">
							<label for="position">Position<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
						</div>
						<div class="col-md-5">
							<input class="form-control form-control-sm border-danger" type="text" id="position" name="position" value="<?php echo $main_client_position['position_nr'];?>" form="update_form">
						</div>
					</div>            
					<div class="row w-100 mx-0">
						<div class="col-md-5">
							<label for="boss_c_id">Boss ID<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
						</div>
						<div class="col-md-5">
							<input type="text" id="boss_c_id2" list="boss_c_id_list" name="boss_c_id2" class="form-control form-control-sm border-danger" value="<?php 
                            $client=$prod->get_client($main_client_position['boss_c_id']);

                            echo $client['client_ID']." - ".$client['clientname']." - ".$client['c_last_name'].", ".$client['c_first_name'];
                            ?>" form="" required>                
							<datalist id="boss_c_id_list">
								<?php
								$allclients=$prod->get_all_clients();
								for($i=0;$i<count($allclients);$i++)
								{
									if($allclients[$i]['c_status']=="active")
									{
				
										?>

											<option value="<?php echo $allclients[$i]['client_ID']." - "; 
											
											if(!empty($allclients[$i]['c_last_name']))
											{

												echo $allclients[$i]['clientname']." - ".$allclients[$i]['c_last_name'].", ".$allclients[$i]['c_first_name'];

											}
											else
											{
												echo $allclients[$i]['clientname']." - ".$allclients[$i]['l_last_name'].", ".$allclients[$i]['l_first_name'];

											}
											?>" <?php

											if(($_COOKIE['lt_id']==9)&&($allclients[$i]['client_ID']==327))
											{

												echo "selected";

											} ?>><?php

												if(!empty($allclients[$i]['c_last_name']))
												{

													echo $allclients[$i]['clientname']." - ".$allclients[$i]['c_last_name'].", ".$allclients[$i]['c_first_name'];

												}
												else
												{
													echo $allclients[$i]['clientname']." - ".$allclients[$i]['l_last_name'].", ".$allclients[$i]['l_first_name'];

												}

												?></option>

											<?php

									}

								}

								?>
							</datalist>
							<input type="hidden" id="boss_c_id" name="boss_c_id" value="<?php echo $main_client_position['boss_c_id'];?>" form="update_form">
							<div id="boss_c_id_name"></div>
						</div>
					</div>        
												
				</div>
				
			</div>
			<div class="row w-100 mx-0">
				<div class="col-md-12 d-flex justify-content-center">
					<div class="center_message">
						<button type="submit" name="create_btn" class="btn btn-primary btn-sm" form="update_form">Update</button>			
					</div>
				</div>
			</div>	
			<script type="text/javascript">
				$('#boss_c_id2').on("change focusout",function(){
					let boss_c_id2_text=$(this).val();
					let boss_c_id2_array_text=boss_c_id2_text.split("-");
					$('#boss_c_id').val(boss_c_id2_array_text[0].trim());
				});
			</script>
		<br>
		<?php		
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
		<a href="<?php echo $base_url; ?>index.php" class="btn btn-danger btn-sm">Login</a>
		<br><br>
		</div>
		<meta http-equiv="refresh" content="3; url=<?php echo $base_url; ?>index.php">
		<?php
	}
	?>
	</div>
	</article>
</section>
<?php
include('../footer.php');
?>