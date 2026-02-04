<?php
session_start();
include('../functions.php');

$prod=new Production;
$_SESSION['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');

$ut_id=$prod->xss_fix($_GET['ut_id']);


?>
<section class="top_section">
	<article>
	<div class="container mb-5 pagecontent bg-white px-0">
	<br>
		<?php
		if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire']))
		{
		?>	
            <h2 class="w-100 text-center mb-4">Modify Team Member</h2>
			<div>
			<?php
            if(isset($_POST['update_team_member_btn']))
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
                    'ut_id' => $prod->xss_fix($_POST['ut_id']),
                    'team_id' => $prod->xss_fix($_POST['team_id']),
                    'team_name' => $prod->xss_fix($_POST['team_name']),
                    'u_id' => $prod->xss_fix($_POST['u_id']),
                    'team_leader_quality' => $prod->xss_fix($_POST['team_leader_quality']),
                    'u_name' => $u_name
                );

                $prod->update_team_member(json_encode($update_member_data));
                ?>
                <div class="text-center">
                    <div class="alert alert-success">Updated successfully</div>
                </div>
                <meta http-equiv="refresh" content="2; url=index.php">
                <?php
            }

        $team_member=$prod->get_team_member($ut_id);
			?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>?ut_id=<?php echo $ut_id;?>" name="update_team_member_form" method="post">
            <input type="hidden" name="ut_id" id="ut_id" value="<?php echo $ut_id;?>">
			<div class="row w-100 mx-0">
                <div class="col-md-3 text-center py-2">
					<b>Team ID</b>
				</div>										
				<div class="col-md-2 text-center py-2">
					<input type="textbox" name="team_id" id="team_id" value="<?php echo $team_member['team_id'];?>" class="form-control form-control-sm">
				</div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-3 text-center py-2">
					<b>Team name</b>
				</div>										
				<div class="col-md-2 text-center py-2">
					<input type="textbox" name="team_name" id="team_name" value="<?php echo $team_member['team_name'];?>" class="form-control form-control-sm">
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
                        <option value="<?php echo $creators[$i]['client_ID'];?>" <?php echo ($creators[$i]['client_ID']==$team_member['u_id'])?"selected":"";?>><?php 
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
                    <input type="checkbox" name="team_leader_quality" id="team_leader_quality" value="1" class="form-control" <?php echo ($team_member['team_leader_quality']==1)?"checked":"";?>> 
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-2 text-center py-2">
                    
                </div>
                <div class="col-md-3 text-center py-2">
                    <button type="submit" name="update_team_member_btn" class="btn btn-sm btn-primary">Update</button>
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