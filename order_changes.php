<?php
//session_set_cookie_params(14400,"/");
session_start();
include('functions.php');

$prod=new Production;
$_SESSION['start']=gmdate("Y-m-d H:i:s");

include('header2.php');
include('menu.php');

?>
<section class="top_section">
	<article>
	<div class="container py-3 my-4">	
    <h3 class="text-center mb-2">List of task changes</h3>
	<br>
		<?php
		if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire']))
		{
    
            $allstatus=$prod->showallstatus();
			$creators=$prod->show_creators($_SESSION['lt_id']);
			$other_creators=$prod->show_creators_other_companies($_SESSION['lt_id']);
			$num_creators=1;
			
			?>
            
			<div class="row w-100 mx-0 border border-left-0 border-right-0">										
				<div class="col-md-4 border-right text-center py-2">
					<b>Name</b>
				</div>
				<div class="col-md-1 border-right text-center py-2">
					<b>Company</b>
				</div>
				<div class="col-md-1 text-center py-2">
					<b>Changes</b>
				</div>
			</div>
        <?php    
            for($i=0;$i<count($creators);$i++)
            {
                if($creators[$i]['u_status']=="active")
                {
                ?>
                <div class="row colorline all_creators2 w-100 mx-0 border-bottom">										
                    <div class="col-md-4 border-right py-2">
                        <div style="display:inline-flex">
                            <div id="tasks_creator_bubble_<?php echo $num_creators;?>" class="mr-2"></div>
                            <?php
                            if(!empty($creators[$i]['c_last_name']))
                            {
                                echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name'];
                            }
                            else
                            {
                                echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name'];
                            }
                            ?>
                        </div>
                        
                    </div>
                    <div class="col-md-1 border-right py-2">
                    <?php
                    echo $prod->get_company($creators[$i]['lt_id'])['mailnick'];
                    ?> 
                    </div>
                    <div class="col-md-6 py-3">
                        <div id="conversation">
                        <?php
                       
                       $activity=$prod->get_activity_from_uca_id($creators[$i]['client_ID']);

                       for($j=0;$j<count($activity);$j++)
                       {
                       ?>
                        <div class="row">
                        <div class="col-md-12">
                        <p class="border p-inline mb-1 p-1 <?php 
                            
                            $o_prods=$prod->check_assigned_status($activity[$j]['o_id'],$activity[$j]['osub_id'],$activity[$j]['prod_id']);

                            for($k=0;$k<count($allstatus);$k++)
                            {
                                if($allstatus[$k]['ost_id']==$o_prods['p_status'])
                                {
                                    echo $allstatus[$k]['ost_color'];
                                }
                            }						
                            ?>">
                        <a href="<?php echo $base_url;?>coordination/taskdetails.php?o_id=<?php echo $activity[$j]['o_id'];?>&osub_id=<?php echo $activity[$j]['osub_id'];?>&prod_id=<?php echo $activity[$j]['prod_id']?>"><?php
                        echo $activity[$j]['o_id'].".".$activity[$j]['osub_id'].".".$activity[$j]['prod_id'];
                        ?></a></p>
                        <?php
                        echo " on ".$activity[$j]['date']." UTC+0 ";
                        echo $activity[$j]['description'];
                        ?>
                        </div>
                        </div>
                       <?php 
                       }
                        ?>
                        </div>
                    </div>
                </div> 
                <?php
                $num_creators++;
                }
            }
            
            for($i=0;$i<count($other_creators);$i++)
            {
                if($other_creators[$i]['u_status']=="active")
                {
                ?>
                <div class="row colorline all_creators2 w-100 mx-0 border-bottom">
                
                    <div class="col-md-4 border-right py-2">
                        <div style="display:inline-flex">
                        <div id="tasks_creator_bubble_<?php echo $num_creators;?>" class="mr-2"></div>
                        <?php
                        if(!empty($other_creators[$i]['c_last_name']))
                        {
                            echo $other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name'];
                        }
                        else
                        {
                            echo $other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name'];
                        }
                        ?>
                        </div>
                       
                    </div>
                    <div class="col-md-1 border-right py-2">
                    <?php
                    echo $prod->get_company($other_creators[$i]['lt_id'])['mailnick'];
                    ?>
                    </div>		
                    <div class="col-md-6 py-3">
                        <div id="conversation">
                        <?php
                         $activity=$prod->get_activity_from_uca_id($other_creators[$i]['client_ID']);

                         for($j=0;$j<count($activity);$j++)
                         {
                         ?>
                          <div class="row">
                          <div class="col-md-12">
                          <p class="border p-inline mb-1 p-1 <?php 
                            
                            $o_prods=$prod->check_assigned_status($activity[$j]['o_id'],$activity[$j]['osub_id'],$activity[$j]['prod_id']);

                            for($k=0;$k<count($allstatus);$k++)
                            {
                                if($allstatus[$k]['ost_id']==$o_prods['p_status'])
                                {
                                    echo $allstatus[$k]['ost_color'];
                                }
                            }						
                            ?>">
                          <a href="<?php echo $base_url;?>coordination/taskdetails.php?o_id=<?php echo $activity[$j]['o_id'];?>&osub_id=<?php echo $activity[$j]['osub_id'];?>&prod_id=<?php echo $activity[$j]['prod_id']?>"><?php
                          echo $activity[$j]['o_id'].".".$activity[$j]['osub_id'].".".$activity[$j]['prod_id'];
                          ?></a></p>

                          <?php
                          echo " on ".$activity[$j]['date']." UTC+0 ";
                          echo $activity[$j]['description'];
                          ?>
                          </div>
                          </div>
                         <?php 
                         }
                        ?>
                        </div>
                    </div>
                </div>
                <?php
                $num_creators++;
                }
            }
		} //end session
		else
		{
            session_unset();
            session_destroy();
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				    <a href="<?php echo $base_url;?>index.php" class="btn btn-danger px-4 btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
	</article>
</section>
<?php
include('footer.php');
?>