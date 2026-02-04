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
            <h2 class="w-100 text-center mb-4">Teams - <a href="create.php">Add new member</a></h2>
			<div>
			<?php
            $allteams=$prod->get_all_creator_teams();
			?>
            
			<div class="row w-100 mx-0 border border-left-0 border-right-0">
                <div class="col-md-1 border-right text-center py-2">
					<b>Team ID</b>
				</div>										
				<div class="col-md-3 border-right text-center py-2">
					<b>Team Name</b>
				</div>
				<div class="col-md-3 border-right text-center py-2">
					<b>Creator</b>
				</div>
                <div class="col-md-3 text-center py-2">
					
				</div>
			</div>
            <?php
            for($i=0;$i<count($allteams);$i++)
            {
            ?>
            <div id="team_member<?php echo $allteams[$i]['ut_id'];?>" class="row w-100 mx-0">
                <div class="col-md-1 text-center py-2">
                <?php echo $allteams[$i]['team_id'];?>
                </div>
                <div class="col-md-3 text-center py-2">
                <?php echo $allteams[$i]['team_name'];?>
                </div>
                <div class="col-md-3 text-center py-2">
                <?php 
                $creator=$prod->get_client($allteams[$i]['u_id']);
                if(!empty($creator['c_last_name']))
                {
                    echo $creator['c_first_name']." ".$creator['c_last_name'];
                }
                else
                {
                    echo $creator['l_first_name']." ".$creator['l_last_name'];
                }
                
                if($allteams[$i]['team_leader_quality']==1)
                {
                    ?>
                    <img src="<?php echo $base_url;?>img/team_leader.jpg" width="20" height="20">
                    <?php
                }
                ?>
                
                </div>
                <div class="col-md-3 text-center py-2">
                    <a href="modify.php?ut_id=<?php echo $allteams[$i]['ut_id'];?>" class="btn btn-sm btn-primary">Modify</a>
                    <button name="team_delete_btn" id="team_delete_btn<?php echo $allteams[$i]['ut_id'];?>" class="btn btn-sm btn-danger">X</button>
                    <script type="text/javascript">
                    $("#team_delete_btn<?php echo $allteams[$i]['ut_id'];?>").click(function(){
                        if(confirm('Are you sure want to delete ?'))
                        {
                            $.ajax({
                                url: "../ajax/delete_team_member.php",
                                method: "post",
                                data: {ut_id:<?php echo $allteams[$i]['ut_id'];?>},
                                dataType:"html",
                                success:function(data) {
                                    //console.log(data);	
                                    $('#team_member<?php echo $allteams[$i]['ut_id'];?>').fadeOut(2000);
                                    								
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(xhr.status);
                                    console.log(thrownError);
                                }
                                });
                        }
                    });
                    </script>
                </div>
            </div>
            <?php
            }
            ?>
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
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
	</div>	<!-- end container -->
	</article>
</section>

<?php
include('../footer.php');
?>