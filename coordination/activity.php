<?php
//session_set_cookie_params(14400,"/");
session_start();
include('functions.php');
include('header2.php');
$prod=new Production;
include('menu.php');

?>
<section>
	<article>
	<div class="container">	
	<h3>Activity view</h3>
	<br />
		<?php
		if(isset($_COOKIE['client_id']))
		{
		$activity=$prod->show_all_activity();
		
			for($i=0;$i<count($activity);$i++)
			{
				?>
				<div class="row colorline">
					<div class="col-md-6">
					<?php
					$logged_in_user=$prod->get_creator_name($activity[$i]['uca_id']);
					
					echo $activity[$i]['o_id'].".".$activity[$i]['osub_id'].".".$activity[$i]['prod_id']." on ".$activity[$i]['date']." ".$logged_in_user['uca_name']." ".$activity[$i]['description'];
					?>
					</div>
				</div>
				<?php
			}
		} //end session
		else
		{
			?>
			<div class="center_message">				
				<div class="error">You must be logged in to view this page !</div>
				<a href="login.php" class="btn btn-danger btn-sm">Login</a>
				<br /><br />
			</div>
			<meta http-equiv="refresh" content="3; url=login.php">
			<?php
		}
		?>
	</article>
</section>
<?php
include('footer.php');
?>