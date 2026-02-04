<?php
session_start();
session_unset();
session_destroy();
include('functions.php');

$prod=new Production;

include('header2.php');
?>
<div class="container">
	<div class="text-center">
		<div class="alert alert-success">You have logged out.</div>
	</div>
	<br> <br>
	<meta http-equiv="refresh" content="1; url=<?php echo $base_url;?>index.php">
</div>
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
<?php
include('footer.php');
?>