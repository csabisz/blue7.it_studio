<?php
//session_set_cookie_params(14400,"/");
session_start();
include('functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('header2.php');

include('menu.php');

?>
<section class="top_section">
	<article>
    <?php
    if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
    {
        ?>
	<div class="container py-3 my-4">	
    <h3 class="text-center mb-2">Activity view</h3>
	<br>
    <form name="search_activity_form" id="search_activity_form" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <div class="row">
        <div class="col-md-3">
            <select name="status" id="status" class="form-control form-control-sm">
                <option value="">--Select status--</option>
                <?php
                $all_status=$prod->showallstatus();

                for($s=0;$s<count($all_status);$s++)
                {
                ?>
                <option value="<?php echo $all_status[$s]['ost_name'];?>" <?php echo ($all_status[$s]['ost_name']==$_GET['status'])?"selected":"";?>><?php echo $all_status[$s]['ost_name'];?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="start_date" id="start_date" placeholder="Start date" value="<?php echo $prod->xss_fix($_GET['start_date']);?>" class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
            <input type="text" name="end_date" id="end_date" placeholder="End date" value="<?php echo $prod->xss_fix($_GET['end_date']);?>" class="form-control form-control-sm">
        </div>
        <script type="text/javascript">
        $('#start_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	    });

        $('#end_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	    });
        </script>
        <div class="col-md-1">
            <button class="btn btn-sm btn-primary" name="search_btn" id="search_btn" type="submit">Search</button>
        </div>
    </div>
    </form>
    <br>
		<?php
        if(isset($_GET['search_btn']))
        {
            $data['status']=$_GET['status'];
            $data['start_date']=$_GET['start_date'];
            $data['end_date']=$_GET['end_date'];

            $activity=$prod->show_activity_by_date_and_status(json_encode($data));
            ?>
            <table class="table table-striped border">
                <?php
                for($i=0;$i<count($activity);$i++)
                {
                    ?>
                    <tr>
                        <td class="pl-3">
                            <?php
                            $logged_in_user=$prod->get_client($activity[$i]['uca_id']);
                            
                            echo $activity[$i]['o_id'].".".$activity[$i]['osub_id'].".".$activity[$i]['prod_id']." on ".$activity[$i]['date']." UTC+0 ";
                            if(!empty($logged_in_user['c_last_name']))
                            {
                                echo $logged_in_user['c_first_name']." ".$logged_in_user['c_last_name'];
                            }
                            else
                            {
                                echo $logged_in_user['l_first_name']." ".$logged_in_user['l_last_name'];
                            }
                            echo " ".$activity[$i]['description'];
                            ?> 
                        </td>
                        <td>
                        <?php 
                            $o_prod=$prod->check_assigned_status($activity[$i]['o_id'],$activity[$i]['osub_id'],$activity[$i]['prod_id']);
                            //echo $o_prod['uca_id']." ";
                            $creator=$prod->get_client($o_prod['uca_id']);
                            //print_r($creator);
                            if(!empty($creator['c_last_name']))
                            {
                                echo $creator['c_last_name'].", ".$creator['c_first_name'];
                            }
                            else
                            {
                                echo $creator['l_last_name'].", ".$creator['l_first_name'];
                            }
                            ?>
                        
                        </td>
                        <td>
                        <label for="planset_description"> <a class="btn btn-secondary btn-sm" target="_blank" href="https://cseven.eu/coordination/orderdetails.php?o_id=<?php echo $activity[$i]['o_id'] ?>"><i class="fas fa-directions mr-1"></i>View on project</a>  </label>                                                      
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        else
        {
		$activity=$prod->show_all_activity();
            ?> 
            <table class="table table-striped border">
                <?php
                for($i=0;$i<count($activity);$i++)
                {
                    ?>
                    <tr>
                        <td class="pl-3">
                            <?php
                            $logged_in_user=$prod->get_client($activity[$i]['uca_id']);
                            
                            echo $activity[$i]['o_id'].".".$activity[$i]['osub_id'].".".$activity[$i]['prod_id']." on ".$activity[$i]['date']." UTC+0 ";
                            if(!empty($logged_in_user['c_last_name']))
                            {
                                echo $logged_in_user['c_first_name']." ".$logged_in_user['c_last_name'];
                            }
                            else
                            {
                                echo $logged_in_user['l_first_name']." ".$logged_in_user['l_last_name'];
                            }
                            echo " ".$activity[$i]['description'];
                            ?> 
                        </td>
                        <td>
                        <?php 
                            $o_prod=$prod->check_assigned_status($activity[$i]['o_id'],$activity[$i]['osub_id'],$activity[$i]['prod_id']);
                            //echo $o_prod['uca_id']." ";
                            $creator=$prod->get_client($o_prod['uca_id']);
                            //print_r($creator);
                            if(!empty($creator['c_last_name']))
                            {
                                echo $creator['c_last_name'].", ".$creator['c_first_name'];
                            }
                            else
                            {
                                echo $creator['l_last_name'].", ".$creator['l_first_name'];
                            }
                            ?>
                        </td>
                        <td>
                        <label for="planset_description"> <a class="btn btn-secondary btn-sm" target="_blank" href="https://cseven.eu/coordination/orderdetails.php?o_id=<?php echo $activity[$i]['o_id'] ?>"><i class="fas fa-directions mr-1"></i>View on project</a>  </label>                                                      
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
		} //end session
		else
		{
            session_unset();
            session_destroy();
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				    <a href="<?php echo $base_url;?>login.php" class="btn btn-danger px-4 btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>login.php">
			<?php
		}
		?>
	</article>
</section>
<?php
include('footer.php');
?>