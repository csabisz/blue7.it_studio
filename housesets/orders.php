<?php
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
include('../menu.php');

$plan_orders=$prod->get_all_plan_orders();

?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white ">
	<?php
	if(isset($_COOKIE['client_id']))
	{		
        							
		?>
        <p class="w-100 text-center display-4 pt-4">Plan-set Orders</p>  
        <hr class="mb-4" width="450px">
        <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
            <a href="index.php" class="btn btn-sm bg-dark text-white mx-3 border">Go to House-sets</a>
            <a href="orders.php" class="btn btn-sm btn-primary mx-3 border">Orders</a>            
        </div>

        <div class="row">
        <div class="col-md-12">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Planset ID</th>
                    <th>Project name</th>
                    <th>Client</th>
                    
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
        <?php
        //print_r($plan_orders);

        for($i=0;$i<count($plan_orders);$i++)
        {
            ?>
            <tr>
                <td><?php echo $plan_orders[$i]['order_id'];?></td>
                <td><?php echo $plan_orders[$i]['house_id'];?></td>
                <td><?php 
                $o_id=$prod->get_planset2($plan_orders[$i]['house_id']);

                $order=$prod->get_order($o_id['presentation_id']);
                echo $order['order_name'];
                ?></td>
                <td><?php 
                
                $client=$prod->get_client($plan_orders[$i]['client_id']);
                
                echo $client['clientname']." - ".$client['c_last_name'].", ".$client['c_first_name'];
                ?></td>
               
                <td>
                <a href="order_details.php?o_id=<?php echo $plan_orders[$i]['order_id'];?>" class="btn btn-sm btn-primary">Details</a>
                <button name="delete_btn" id="delete_btn" class="btn btn-sm btn-danger">X</button></td>
            </tr>
            <?php
        }
        ?>
            </tbody>
        </table>
        </div>
        </div>
        <br>

	<?php		
	}
	else
	{
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
	<div class="center_message">				
	<div class="error text-center">You must be logged in to view this page !</div>
	<a href="../index.php" class="btn btn-danger btn-sm">Login</a>
	<br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=../index.php">
	<?php
	}
	?>
	</div>
	</article>
</section>
<?php
include('../footer.php');
?>