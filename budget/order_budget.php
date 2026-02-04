<?php
session_set_cookie_params(14400,"/");
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
include('../menu.php');

?>
<section>
	<article>
	<div class="container-fluid px-5 pt-5">
		<?php
		if(isset($_COOKIE['client_id']))
		{			
			if(isset($_GET['option']))
			{
				$option=$prod->xss_fix($_GET['option']);
			}
			else
			{
				$option="";
			}
			?>
			
			<div class="row w-100 mx-0">
                <a class="btn btn-warning btn-sm align-self-center ml-auto mr-3" href="../budget/credits_budget.php">Give credits budget</a> |
                <a class="btn btn-warning btn-sm align-self-center mr-auto ml-3" href="../budget/order_budget.php">Give order budget</a>
                <p class="w-100 text-center pt-3 display-4">Order budget <?php if($option=="create"){ echo "- Create budget"; }?></p>
                <a class="btn btn-primary btn-sm mb-5 mx-auto" href="../budget/order_budget.php?option=create">Create order budget</a>
            </div>
			<?php
			if($option=="create")
			{
				if(isset($_POST['create_budget_btn']))
				{
					$budget_title=$prod->xss_fix($_POST['budget_title']);
					$budget_description=$prod->xss_fix($_POST['budget_description']);
					$amount=$prod->xss_fix($_POST['amount']);
					$client_id=$prod->xss_fix($_POST['client_id']);
					$bs_date=$prod->xss_fix($_POST['bs_date']);
					$be_date=$prod->xss_fix($_POST['be_date']);
					
					$prod->create_order_budget($budget_title,$budget_description,$amount,$client_id,$bs_date,$be_date);
					
					?>
					<div class="text-center alert-success">				
						Budget created !
					</div>	
					<meta http-equiv="refresh" content="2; url=order_budget.php">
					<?php
				}
				else
				{
			?>
			<form id="create_budget_form" name="create_budget_form" action="<?php echo $_SERVER['PHP_SELF']."?option=create";?>" method="post"></form>
			<div class="row mx-0 w-100">
                <div class="col-6 offset-3 border py-4 bg-white">
                    <div class="row w-100 mx-0">
                    <div class="col-md-8 offset-2">
                        <p class="mb-2"><b>Budget title</b></p>
                    </div>
                    <div class="col-md-8 offset-2 mb-3">
                        <input type="text" id="budget_title" name="budget_title" form="create_budget_form" class="form-control form-control-sm" required>
                    </div>				
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-8 offset-2">
                        <p class="mb-2"><b>Budget description</b></p>
                    </div>
                    <div class="col-md-8 offset-2 mb-3">
                        <input type="text" id="budget_description" name="budget_description" form="create_budget_form" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-8 offset-2">
                        <p class="mb-2"><b>Amount</b></p>
                    </div>
                    <div class="col-md-8 offset-2 mb-3">
                        <input type="text" id="amount" name="amount" form="create_budget_form" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-8 offset-2">
                        <p class="mb-2"><b>Client</b></p>
                    </div>
                    <div class="col-md-8 offset-2 mb-3">
                        <?php
                        $allclients=$prod->get_all_clients();
                        ?>
                        <select id="client_id" name="client_id" form="create_budget_form" class="form-control form-control-sm" required>
                            <option value="">None</option>
                            <?php
                            for($i=0;$i<count($allclients);$i++)
                            {
                                if($allclients[$i]['c_status']=="active")
                                {
                                    ?>
                                    <option value="<?php echo $allclients[$i]['client_ID'];?>"><?php echo $allclients[$i]['clientname'];?> - <?php 
                                    echo $allclients[$i]['c_last_name'].", ".$allclients[$i]['c_first_name'];
                                    ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-8 offset-2">
                        <p class="mb-2"><b>Budget start date</b></p>
                    </div>
                    <div class="col-md-8 offset-2 mb-3">
                        <input type="text" id="bs_date" name="bs_date" form="create_budget_form" class="form-control form-control-sm" autocomplete="off" required>
                    </div>
                </div>
                <div class="row w-100 mx-0 mb-3">
                    <div class="col-md-8 offset-2">
                        <p class="mb-2"><b>Budget end date</b></p>
                    </div>
                    <div class="col-md-8 offset-2">
                        <input type="text" id="be_date" name="be_date" form="create_budget_form" class="form-control form-control-sm" autocomplete="off" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-8 offset-2" style="text-align:center;">
                        <button id="create_budget_btn" name="create_budget_btn" form="create_budget_form" class="btn btn-primary btn-sm align-self-center btn-block">Create</button> 
                    </div>
                </div>
                </div>
            </div>
			<br>
			<script type="text/javascript" src="js/budget.js"></script>
			<?php
				}
			}
			elseif($option=="edit")
			{
				if(isset($_GET['ucm_budget_id']))
				{
					if(isset($_POST['update_budget_btn']))
					{
						$ucm_budget_id=$prod->xss_fix($_POST['ucm_budget_id']);
						$budget_title=$prod->xss_fix($_POST['budget_title']);
						$budget_description=$prod->xss_fix($_POST['budget_description']);
						$amount=$prod->xss_fix($_POST['amount']);
						$client_id=$prod->xss_fix($_POST['client_id']);
						$bs_date=$prod->xss_fix($_POST['update_bs_date']);
						$be_date=$prod->xss_fix($_POST['update_be_date']);
						
						$prod->update_order_budget($ucm_budget_id,$budget_title,$budget_description,$amount,$client_id,$bs_date,$be_date);
						?>
						<div class="text-center alert-success">				
							Budget updated !
						</div>	
						<br>
						<meta http-equiv="refresh" content="2; url=order_budget.php">
						<?php
					}
					else
					{
						
					$ucm_budget_id=$prod->xss_fix($_GET['ucm_budget_id']);
					
					$budget=$prod->get_order_budget($ucm_budget_id);
				?>	
		<form id="update_budget_form" name="update_budget_form" action="<?php echo $_SERVER['PHP_SELF']."?option=edit&ucm_budget_id=".$ucm_budget_id;?>" method="post"></form>
			<input type="hidden" name="ucm_budget_id" value="<?php echo $ucm_budget_id;?>" form="update_budget_form">
			<div class="row mx-0 w-100">
                <div class="col-6 offset-3 border py-4 bg-white">
                    <div class="row w-100 mx-0">
                    <div class="col-md-8 offset-2">
                        <p class="mb-2"><b>Budget title</b></p>
                    </div>
                    <div class="col-md-8 offset-2 mb-3">
                        <input type="text" id="budget_title" name="budget_title" value="<?php echo $budget['budget_name'];?>" form="update_budget_form" class="form-control form-control-sm" required>
                    </div>				
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-8 offset-2">
                            <p class="mb-2"><b>Budget description</b></p>
                        </div>
                        <div class="col-md-8 offset-2 mb-3">
                            <input type="text" id="budget_description" name="budget_description" value="<?php echo $budget['budget_explanation'];?>" form="update_budget_form" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-8 offset-2">
                            <p class="mb-2"><b>Amount</b></p>
                        </div>
                        <div class="col-md-8 offset-2 mb-3">
                            <input type="text" id="amount" name="amount" value="<?php echo $budget['amount'];?>" form="update_budget_form" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-8 offset-2">
                            <p class="mb-2"><b>Client</b></p>
                        </div>
                        <div class="col-md-8 offset-2 mb-3">
                            <?php
                            $allclients=$prod->get_all_clients();
                            ?>
                            <select id="client_id2" name="client_id2" form="update_budget_form" class="form-control form-control-sm" disabled>
                                <option value="">None</option>
                                <?php
                                for($i=0;$i<count($allclients);$i++)
                                {
                                ?>
                                <option value="<?php echo $allclients[$i]['client_ID'];?>" <?php echo ($allclients[$i]['client_ID']==$budget['client_id'])?"selected":"";?>><?php echo $allclients[$i]['clientname'];?> - <?php 
                                if(!empty($allclients[$i]['c_last_name']))
                                {
                                    echo $allclients[$i]['c_last_name'].", ".$allclients[$i]['c_first_name'];
                                }
                                else
                                {
                                    echo $allclients[$i]['l_last_name'].", ".$allclients[$i]['l_first_name'];
                                }?></option>

                                <?php
                                }
                                ?>
                            </select>
                            <input type="hidden" id="client_id" name="client_id" value="<?php echo $budget['client_id'];?>" form="update_budget_form">
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-8 offset-2">
                            <p class="mb-2"><b>Budget start date</b></p>
                        </div>
                        <div class="col-md-8 offset-2 mb-3">
                            <input type="text" id="update_bs_date" name="update_bs_date" value="<?php echo $budget['bs_date'];?>" form="update_budget_form" autocomplete="off" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-8 offset-2">
                            <p class="mb-2"><b>Budget end date</b></p>
                        </div>
                        <div class="col-md-8 offset-2 mb-3">
                            <input type="text" id="update_be_date" name="update_be_date" value="<?php echo $budget['be_date'];?>" form="update_budget_form" autocomplete="off" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-8 offset-2" style="text-align:center;">
                            <button id="update_budget_btn" name="update_budget_btn" form="update_budget_form" class="btn btn-primary btn-sm btn-block align-self-center">Update</button> 
                        </div>
                    </div>
                </div>
            </div>
			<br>
			<script type="text/javascript" src="js/budget.js"></script>
			<?php
				}
			}
			}
			else
			{
				
            ?>
            <div class="row">                
                <div class="col"><b>Username</b></div>
                <div class="col"><b>Main User</b></div>
                <div class="col"><b>Budget name</b></div>
                <div class="col"><b>Budget description</b></div>
                <div class="col"><b>Start date</b></div>
                <div class="col"><b>End date</b></div>
                <div class="col"><b>Amount</b></div>
                <div class="col"><b>Booked</b></div>
                <div class="col"><b>Free</b></div>
                <div class="col"></div>
            </div>     
			<?php
			
			//$budgets=$prod->get_all_order_budget();
			$budgets=$prod->get_all_clients_ordered_by_clientname();

			for($i=0;$i<count($budgets);$i++)
			{
				$newest_budget=$prod->get_order_budget_by_client_id($budgets[$i]['client_ID']);
                ?>
                <div class="row colorline2">
                    <div class="col"><span id="client_name_infos<?php echo $budgets[$i]['client_ID'];?>" style="color:blue;cursor:pointer;"><?php                 
                    echo $budgets[$i]['c_last_name'].", ".$budgets[$i]['c_first_name'];                
                    ?></a></div>
                    <div id="clientname<?php echo $budgets[$i]['client_ID'];?>" class="col"><?php echo $budgets[$i]['clientname']; ?></div>
                    
                    <?php
                    if(!empty($newest_budget))
                    {
                    ?>            

                    <div id="budget_name<?php echo $budgets[$i]['client_ID'];?>" class="col"><?php echo $newest_budget[0]['budget_name'];?></div>
                    <div id="budget_explanation<?php echo $budgets[$i]['client_ID'];?>" class="col"><?php echo $newest_budget[0]['budget_explanation'];?></div>
                    <div id="bs_date<?php echo $budgets[$i]['client_ID'];?>" class="col"><?php echo $newest_budget[0]['bs_date'];?></div>
                    <div id="be_date<?php echo $budgets[$i]['client_ID'];?>" class="col"><?php echo $newest_budget[0]['be_date'];?></div>
                    <div id="anount<?php echo $budgets[$i]['client_ID'];?>" class="col"><?php echo $newest_budget[0]['amount'];?></div>
                    <div id="count_orders<?php echo $budgets[$i]['client_ID'];?>" class="col">
                        <?php
                        $orders=$prod->get_orders_by_date_no_o_extension($budgets[$i]['client_ID'],$newest_budget[0]['bs_date'],$newest_budget[0]['be_date']);
                        echo count($orders);
                        ?>
                    </div>
                    <div id="difference_orders<?php echo $budgets[$i]['client_ID'];?>" class="col"><?php 
                    $today=date("Y-m-d");
                    if($newest_budget[0]['be_date']<$today)
                    {
                        echo "-";
                    }
                    else
                    {
                        echo $newest_budget[0]['amount']-count($orders);
                    }?></div>
                    <div id="edit_btn_col<?php echo $budgets[$i]['client_ID'];?>" class="col"><a href="<?php 
                    echo $_SERVER['PHP_SELF']."?option=edit&ucm_budget_id=".$newest_budget[0]['ucm_budget_id'];
                    ?>" class="btn btn-primary btn-sm">Edit</a></div>
                    
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="col text-danger">No running budget</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <?php
                    }
                    ?>
                    
                </div>
                <div id="more_budget_infos<?php echo $budgets[$i]['client_ID'];?>" class="d-none">
                    
                </div>
                <script type="text/javascript">
                    $('#client_name_infos<?php echo $budgets[$i]['client_ID'];?>').click(function(){

                        $('#more_budget_infos<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        
                        $('#budget_name<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#budget_explanation<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#bs_date<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#be_date<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#anount<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#count_orders<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#difference_orders<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#edit_btn_col<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");
                        $('#clientname<?php echo $budgets[$i]['client_ID'];?>').toggleClass("d-none");

                        $.ajax({
                        url: "../ajax/get_clients_all_budgets.php",
                        method: "get",
                        data: {client_id:<?php echo $budgets[$i]['client_ID'];?>},
                        dataType:"html",
                        success:function(data) {
                            console.log(data);
                            $('#more_budget_infos<?php echo $budgets[$i]['client_ID'];?>').html(data);
                        }
                        });

                    });
                </script>
                <?php
			}
			}
            ?>
			<?php
		}
		else
		{
			?>
			<div class="center_message">				
				<div class="error">You must be logged in to view this page !</div>
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