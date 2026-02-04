<?php
//session_set_cookie_params(14400,"/");
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
include('../menu.php');

$option="";
?>
<section>
	<article>
	<div class="container">
		<?php
		if(isset($_COOKIE['client_id']))
		{
			
            ?>
            <div class="row w-100 mx-0 mt-5">
                <a class="btn btn-warning btn-sm align-self-center ml-auto mr-3" href="../budget/credits_budget.php">Give credits budget</a> |
                <a class="btn btn-warning btn-sm align-self-center mr-auto ml-3" href="../budget/order_budget.php">Give order budget</a>
                <p class="w-100 text-center pt-3 display-4">Credits budget <?php if($option=="create"){ echo "- Create budget"; }?></p>
            </div>
			<?php
			
			?>
	
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
	</div>	<!-- end container -->
	</article>
</section>
<?php
include('../footer.php');
?>