<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');

$client_id=$prod->xss_fix($_GET['client_id']);
$users_start_date=$prod->xss_fix($_GET['users_start_date']);
$users_end_date=$prod->xss_fix($_GET['users_end_date']);

$creator=$prod->get_client($client_id);
?>
<section class="top_section">
	<article>
	<div class="container text-left mt-4 pt-4">
		<div class="row mx-0 w-100">
            <div class="col-md-12 border p-4">
                <?php
        if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
        {
            ?>
            <h3 class="text-center pb-3">Login time for <?php 
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }
            ?> between <?php echo $users_start_date;?> and <?php echo $users_end_date;?></h3>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="index.php"> < Back to Programs of employees</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <b>Login time</b>
                </div>
                <div class="col-md-2">
                    <b>Logout time</b>
                </div>
                <div class="col-md-1">
                    <b>Total</b>
                </div>
                <div class="col-md-2">
                    <b>IP address</b>
                </div>
                <div class="col-md-4">
                    <b>Browser user agent</b>
                </div>
            </div>
            <?php
            $login_time=$prod->get_creator_login_time($client_id,$users_start_date,$users_end_date);
            
            $global_counter=0;

            for($i=0;$i<count($login_time);$i++)
            {
            ?>
            <div class="row colorline creator_login_times">
                <div class="col-md-2">
                    <div id="creator_start_time<?php echo $global_counter;?>"><?php echo $login_time[$i]['start_time'];?></div>
                </div>
                <div class="col-md-2">
                    <div id="creator_end_time<?php echo $global_counter;?>"><?php echo $login_time[$i]['end_time'];?></div>
                </div>
                <div class="col-md-1">
                    <?php
                    $datetime1 = new DateTime($login_time[$i]['start_time']);
                    $datetime2 = new DateTime($login_time[$i]['end_time']); 
                    $interval = $datetime1->diff($datetime2);
                    echo $interval->format('%H:%i');
                    ?>
                </div>
                <div class="col-md-2">
                    <?php echo $login_time[$i]['ip_address'];?>
                </div>
                <div class="col-md-4">
                    <?php echo $login_time[$i]['user_agent'];?>
                </div>
            </div>
            <?php
            $global_counter++;
            }
            ?>
            <script type="text/javascript">
            $(document).ready(function(){

            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            var num_creator_login_times=$('.creator_login_times').length;

            for(i=0;i<num_creator_login_times;i++)
            {
                var creatorUTCstarttime = moment.tz($('#creator_start_time' + i).text(), 'UTC');
                var newstarttime = creatorUTCstarttime
                    .clone()
                    .tz(user_timezone)
                    .format('YYYY-MM-DD, HH:mm');
                    $('#creator_start_time' + i).text(newstarttime);

                var creatorUTCendtime = moment.tz($('#creator_end_time' + i).text(), 'UTC');
                var nextendtime = creatorUTCendtime
                    .clone()
                    .tz(user_timezone)
                    .format('YYYY-MM-DD, HH:mm');
                    $('#creator_end_time' + i).text(nextendtime);
            }
            });
            </script>
            <?php
		}
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
            </div> <!-- end col-md-12 -->
        </div> <!-- end row -->
    </div>  <!-- end container -->  
	</article>
</section>
<?php
include('../footer.php');
?>