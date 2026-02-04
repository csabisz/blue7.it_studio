<div class="container">
<header>
	<nav>
		<ul class="nav nav-inline">
			<li class="nav-item"><a href="index.php">Home</a></li>
		<?php
		if(($_SESSION['uca_power']=="c")||($_SESSION['uca_power']=="a"))
		{
		?>
			<li class="nav-item"><a href="acceptance/index.php">Acceptance - Contracting</a></li>
			<li class="nav-item"><a href="books/index.php">BookKeeping</a></li>
		<?php
		}
		if(($_SESSION['uca_power']=="d")||($_SESSION['uca_power']=="a")||($_SESSION['uca_power']=="c"))
		{
		?>
			<li class="nav-item"><a href="coordination/index.php">Coordination</a></li>
			<li class="nav-item"><a href="index.php">Own tasks</a></li>
		<?php
		}
		?>
			<li class="nav-item" style="float:right;">Logged in as 
			<?php
			//$books=new BookKeeping;
			if(isset($_SESSION['username']))
			{
				/*
				if($_SESSION['rank']==1)
				{
					$verify_email=$prod->verify_licence_taker_email($_SESSION['email']);
				}
				else
				{
					$verify_email=$prod->verify_creator_email($_SESSION['email']);
				}
				
				if($verify_email==1)
				{
				*/
				echo $_SESSION['producer']." - ".$_SESSION['username'];
				/*}
				else
				{
					?>
					<div class="center_message"><div class="error">Session expired...</div></div>
					<meta http-equiv="refresh" content="1; url=login.php">
					<?php
				}
				*/
			}
			?>
			<a href="../logout.php">Logout</a></li>
		</ul>
	</nav>
</header>
</div>
<hr />
<!-- end main menu -->