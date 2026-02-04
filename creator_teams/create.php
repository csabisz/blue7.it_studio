<?php
session_start();
include('../functions.php');

$prod=new Production;
$_SESSION['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');

?>
<section class="top_section">
	<article>
	<div class="container mb-5 pagecontent bg-white px-0">
	<br>
		<?php
		if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire']))
		{
		?>	
            <h2 class="w-100 text-center mb-4">Add Team Member</h2>
			<div>
			<?php
            if(isset($_POST['add_team_member_btn']))
            {
                $creator=$prod->get_client($prod->xss_fix($_POST['u_id']));
                
                if(!empty($creator['c_last_name']))
                {
                    $u_name=$creator['c_first_name']." ".$creator['c_last_name'];
                }
                else
                {
                    $u_name=$creator['l_first_name']." ".$creator['l_last_name'];
                }
                $update_member_data=array(
                    'team_id' => $prod->xss_fix($_POST['team_id']),
                    'team_name' => $prod->xss_fix($_POST['team_name']),
                    'u_id' => $prod->xss_fix($_POST['u_id']),
                    'team_leader_quality' => $prod->xss_fix($_POST['team_leader_quality']),
                    'u_name' => $u_name
                );

                $prod->add_team_member(json_encode($update_member_data));
                ?>
                <div class="text-center">
                    <div class="alert alert-success">Added successfully</div>
                </div>
                <meta http-equiv="refresh" content="2; url=index.php">
                <?php
            }
			?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" name="add_team_member_form" method="post">
			<div class="row w-100 mx-0">
                <div class="col-md-3 text-center py-2">
					<b>Team ID</b>
				</div>										
				<div class="col-md-2 text-center py-2">
					<input type="textbox" name="team_id" id="team_id" value="" class="form-control form-control-sm">
				</div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-3 text-center py-2">
					<b>Team name</b>
				</div>										
				<div class="col-md-2 text-center py-2">
					<input type="textbox" name="team_name" id="team_name" value="" class="form-control form-control-sm">
				</div>
            </div>
            <div class="row w-100 mx-0">
				<div class="col-md-3 text-center py-2">
					<b>Creator</b>
				</div>
                <div class="col-md-2 text-center py-2">
					<select name="u_id" id="u_id" class="form-control form-control-sm">
                        <option value="">--Select--</option>
                        <?php 
                        $creators=$prod->get_all_creators();

                        for($i=0;$i<count($creators);$i++)
                        {
                            ?>
                        <option value="<?php echo $creators[$i]['client_ID'];?>"><?php 
                        if(!empty($creators[$i]['c_last_name']))
                        {
                            echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name'];
                        }
                        else
                        {
                            echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name'];
                        }
                        ?></option>
                            <?php
                        }
                        ?>
                    </select>
				</div>
			</div>
            <div class="row w-100 mx-0">
				<div class="col-md-3 text-center py-2">
					<b>Team leader quality</b>
				</div>
                <div class="col-md-2 text-left py-2">
                    <input type="checkbox" name="team_leader_quality" id="team_leader_quality" value="1" class="form-control"> 
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-2 text-center py-2">
                    
                </div>
                <div class="col-md-3 text-center py-2">
                    <button type="submit" name="add_team_member_btn" class="btn btn-sm btn-primary">Add</button>
                </div>
            </div>
            </form>
			</div> <!-- end div -->
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
	</div>	<!-- end container -->
	</article>
</section>

<?php
include('../footer.php');
?>