<?php
//session_set_cookie_params(14400,"/");
session_start();
include('functions.php');

$prod=new Production;

include('header2.php');
include('menu.php');

?>
<section class="top_section">
	<article class="pt-4">
	<div class="container text-center border my-4 pt-2 pagecontent bg-white">
	<br>
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{
			if(isset($_POST['save_btn']))
			{
				$cwh_id=$prod->xss_fix($_POST['cwh_id']);
				$work_start_time=$prod->xss_fix($_POST['startUTCtime']);
				$work_end_time=$prod->xss_fix($_POST['endUTCtime']);
                
                //$_COOKIE['start']=gmdate("Y-m-d H:i:s");
                $_COOKIE['expire']=$work_end_time;

				$prod->update_working_hours($cwh_id,$work_start_time,$work_end_time);
				?>
				<div class="alert alert-success text-center">
					Working hours updated. 
				</div>
				<meta http-equiv="refresh" content="2; url=profile.php">
				<?php
			}
			?>
			<h3>My profile</h3>
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                <div class="">Logged in as <?php	
                    if(!empty($_COOKIE['c_last_name']))
                    {
                        echo $_COOKIE['c_first_name']." ".$_COOKIE['c_last_name'];
                    }
                    else
                    {
                        echo $_COOKIE['l_first_name']." ".$_COOKIE['l_last_name'];
                    }			
                ?>
                <a href="<?php echo $base_url;?>logout.php">Logout</a>
                </div>
                </div>
			</div>
			<?php
			$get_todays_working_hours=$prod->get_todays_working_hours($_COOKIE['client_id']);
			
			if(count($get_todays_working_hours)>0)
			{
			?>
				
			<div class="row w-100 mx-0">
				<div class="col-md-12 text-center">
					<form id="choose_working_hours_form" name="choose_working_hours_form" action="profile.php" method="post">
						<input type="hidden" name="cwh_id" value="<?php echo $get_todays_working_hours['cwh_id']; ?>">		
						<input type="hidden" name="startUTCtime" id="startUTCtime" value="<?php echo $get_todays_working_hours['start_time'];?>">
						<input type="hidden" name="endUTCtime" id="endUTCtime" value="<?php echo $get_todays_working_hours['end_time'];?>">						
						<div class="row mt-3">					
							<div class="col-md-2">
								<!--<label for="work_start_time">Start:</label> 
								<input type="text" class="form-control form-control-sm" id="work_start_time" name="work_start_time" value="" style="width:200px;" required>
                                -->
                                Working hours
                               
							</div>
							<div class="col-md-3">		
                                <div class="d-inline">				
                                    <label for="work_end_time">End:</label> 
                                    <input type="text" class="form-control form-control-sm" id="work_end_time" name="work_end_time" value="" style="width:200px;" required>
                                </div>
							</div>	
                            <div class="col-md-3 pt-4 pl-0">
								<div class="center_message mt-1">
									<button type="submit" name="save_btn" class="btn btn-primary btn-sm mr-4">Save changes</button>
								</div>
							</div>
						</div>
					</form>	
				</div>
			</div>	
            
			<br>
			
			<script type="text/javascript">
				$(document).ready(function(){		
					var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
					
					var startUTCtime=moment.tz($('#startUTCtime').val(),'UTC');
					var endUTCtime=moment.tz($('#endUTCtime').val(),'UTC');
					
					//var start_local_time = startUTCtime.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm');
					var end_local_time = endUTCtime.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm');
					
					//$('#work_start_time').val(start_local_time);
					$('#work_end_time').val(end_local_time);
					//console.log(startUTCtime);
					//console.log(endUTCtime);
					
					/*$('#work_start_time').on('change keyup paste mouseup',function(){
						var selected_start_date=moment.tz($('#work_start_time').val(),user_timezone);
						var selected_utc_start_time=selected_start_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
						$('#startUTCtime').val(selected_utc_start_time);
					});*/
					
					$('#work_end_time').on('change keyup paste mouseup',function(){
						var selected_end_date=moment.tz($('#work_end_time').val(),user_timezone)
						var selected_utc_end_time=selected_end_date.clone().tz('UTC').format('YYYY-MM-DD HH:mm');
						$('#endUTCtime').val(selected_utc_end_time);
					});					
					
					$.datetimepicker.setLocale('en');
					/*$('#work_start_time').datetimepicker({
						lang:'en',
						format:'Y-m-d H:i',
						formatDate:'Y-m-d',
						formatTime:'H:i',
						step: 15
					});*/
					$('#work_end_time').datetimepicker({
						lang:'en',
						format:'Y-m-d H:i',
						formatDate:'Y-m-d',
						formatTime:'H:i',
						step: 15
					});
					
					
				});
			</script>
			<?php
			}
			?>
            <!--<div class="row">
                <div class="col-md-3">
                <?php echo $_COOKIE['start'];?>
                </div>
                <div class="col-md-3">
                <?php echo $_COOKIE['expire'];?>
                </div>
            </div>-->
			<div class="row d-flex justify-content-center my-5">
				<div class="col-md-6 border py-2">
					<form name="change_password" action="profile.php" method="post">
						<div class="row d-flex justify-content-center my-4">
							<div class="col-md-12">
								<h3>Change password:</h3>
							</div>	
						</div>
                        <?php
                        if(isset($_POST['change_password_btn']))
                        {
                            $new_password1=$_POST['new_password1'];
                            $new_password2=$_POST['new_password2'];
                            
                            if(strlen($new_password1)<7)
                            {
                                ?>
                                <div class="alert alert-danger">Password too short.</div>
                                <?php        
                            }
                            elseif($new_password1!=$new_password2)
                            {
                                ?>
                                <div class="alert alert-danger">Passwords do not match.</div>
                                <?php        
                            }
                            else
                            {
                                $prod->update_client_password($_COOKIE['client_id'],$new_password1);
                                ?>
                                <div class="alert alert-success">Password changed</div>
                                <meta http-equiv="refresh" content="2; url=<?php echo $base_url;?>logout.php">
                                <?php
                            }
                        
                        }
                        ?>
						<!--<div class="row d-flex justify-content-center">
							<div class="col-md-6">
								<label for="current_password">Current password:</label>
								<input type="password" id="current_password" name="current_password" class="form-control form-control-sm">
							</div>
						</div> -->
						<div class="row d-flex justify-content-center">
							<div class="col-md-6">
								<label for="new_password1">New password:</label>
								<input type="password" id="new_password1" name="new_password1" class="form-control form-control-sm">
							</div>
						</div>
						<div class="row d-flex justify-content-center">
							<div class="col-md-6">
								<label for="new_password2">Confirm new password:</label>
								<input type="password" id="new_password2" name="new_password2" class="form-control form-control-sm">
							</div>
						</div>
						<div class="row d-flex justify-content-center my-3">
							<div class="col-md-6">
								<div class="center_message">
									<button type="submit" id="change_password_btn" name="change_password_btn" class="btn btn-primary btn-sm btn-block">Change password</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			</div>
			<?php include('online_creators.php'); ?>
				<!-- end container -->
			<?php
		}
		else
		{
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