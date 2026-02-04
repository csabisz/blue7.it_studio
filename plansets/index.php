<?php
session_start();
include('../functions.php');
$prod = new Production;
$page_title="Plan-sets";
$_COOKIE['start']=gmdate("Y-m-d H:i:s");
include('../header2.php');
include('../menu.php');



if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))		
{
    if($_COOKIE['plansets'] > 0)
	{
        $plansets=$prod->get_all_plansets();		        							
    ?>
    <section class="top_section">
        <article>
        <div class="container-fluid text-center">
            <h3 class="text-center py-4">Plan-sets</h3>
            <div class="row">
                <div class="col-md-2">
                    <a href="create.php" class="btn btn-sm btn-primary">Create New Plan-set</a>
                </div>
            </div>
            <br>
            <div class="row">
                    <div class="col-md-1">
                        <b>PLS_ID</b>
                    </div>
                    <div class="col-md-1">
                        <b>Presentation ID</b>
                    </div>
                    <div class="col-md-2">
                        <b>Owner1 (mc_id)</b>
                    </div>
                    <div class="col-md-2">
                        <b>Owner (client_id)</b>
                    </div>
                    <div class="col-md-2">
                        <b>Plan-set name</b>
                    </div>
                    <div class="col-md-1">
                       <b>Plan-set Price</b>
                    </div>
                    <div class="col-md-1">
                        &nbsp;
                    </div>
                </div>
            <?php
            for($i=0;$i<count($plansets);$i++)
            {
                ?>
                <div class="row colorline">
                    <div class="col-md-1">
                        <?php
                        echo $plansets[$i]['pls_id'];
                        ?>
                    </div>
                    <div class="col-md-1">
                        <?php
                        echo $plansets[$i]['pls_presentation_id'];
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        if($plansets[$i]['pls_owner1']!=0)
                        {
                            $main_client=$prod->get_main_client($plansets[$i]['pls_owner1']);

                            echo $main_client['clientname'];
                        }
                        else
                        {
                            echo "No owner";
                        }
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        if($plansets[$i]['pls_owner']!=0)
                        {
                            $client=$prod->get_client($plansets[$i]['pls_owner']);
                            
                            if(!empty($client['c_last_name']))
                            {
                                echo $client['c_last_name'].", ".$client['c_first_name'];
                            }
                            else
                            {
                                echo $client['l_last_name'].", ".$client['l_first_name'];
                            }
                        }
                        else
                        {
                            echo "No owner";
                        }
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        echo $plansets[$i]['pls_name'];
                        ?>
                    </div>
                    <div class="col-md-1">
                        <?php
                        echo $plansets[$i]['pls_price'];
                        ?>
                    </div>
                    <div class="col-md-1">
                        <a href="details.php?pls_id=<?php echo $plansets[$i]['pls_id'];?>" class="btn btn-sm btn-primary">Details</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        </article>
    </section>
    <?php
    }
    else
    {
        ?>
        <div class="text-center">				
        <div class="alert alert-danger">Access denied !</div>
        <a href="<?php echo $base_url;?>own_tasks.php" class="btn btn-danger btn-sm">Go to Own tasks</a>
        <br><br>
        </div>
    <meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>own_tasks.php">
    <?php
    
    }
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

include('../footer.php');
?>
