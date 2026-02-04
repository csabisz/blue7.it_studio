<?php
session_start();
include('../functions.php');
include('../../../superplan7.com/public_html/functions.php');

$prod=new Production;
$sp7=new Superplans;

include('../header2.php');
include('../menu.php');

$o_id=$prod->xss_fix($_GET['o_id']);

$planset_order=$prod->get_planset_order($o_id);

$house=$prod->get_planset2($planset_order['house_id']);

$order=$prod->get_order($house['presentation_id']);

$symbol=$sp7->get_currency($planset_order['cur_id'])['currency_short'];
?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white ">
	<?php
	if(isset($_COOKIE['client_id']))
	{		
        							
		?>
        <p class="w-100 text-center display-4 pt-4">Plan Orders</p>  
        <hr class="mb-4" width="450px">
        <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
            <a href="index.php" class="btn btn-sm bg-dark text-white mx-3 border">Go to Plansets</a>
            <a href="orders.php" class="btn btn-sm btn-primary mx-3 border">Orders</a>            
        </div>

        <div class="row">
        <div class="col-md-12">
        <?php
        if(isset($_POST['save_btn']))
        {
            
            $data['order_id']=$prod->xss_fix($_POST['o_id']);
            $data['plans_amount']=$prod->xss_fix($_POST['plans_amount']);
            $data['order_price']=$prod->xss_fix($_POST['order_price']);
            $data['total_price']=$prod->xss_fix($_POST['total_price']);

            $prod->update_order_plansets(json_encode($data));
            ?>
            <div class="alert alert-success text-center">Saved successfully !</div>
            <meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $data['order_id']; ?>">
            <?php
        }
        else
        {
        ?>
        <form id="create_order" name="create_order" action="<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $planset_order['order_id'];?>" method="post">
        <input type="hidden" name="o_id" value="<?php echo $planset_order['order_id'];?>">
        <input type="hidden" id="client_id" name="client_id" value="<?php echo $planset_order['client_id'];?>">
        <input type="hidden" name="currency" value="<?php echo $planset_order['cur_id'];?>">
        <div class="row w-100 mx-0">
        
            <h1 class="w-100 text-center mb-4">Order ID <?php echo $o_id;?></h1> 
            <table class="table text-center">
                    <thead class="d-invisible d-lg-visible">
                        <tr>
                        <th scope="col"> </th>
                        <th scope="col">House Name</th>
                        <th scope="col">Nr. house plans</th>
                        <th scope="col">Plan Minimum Price</th>
                        <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="d-invisible d-lg-visible">
                        <tr>
                            <?php
                            
                            //$main_picture=$sp7->get_o_result($sp7_details2['presentation_id']); ?>
                            <!-- <td><img src="/img/1-startseite.jpg" alt="" width="160px" height="90px"></td> -->
                            <td>
                            <?php /* for($j=0;$j<count($main_picture);$j++) {
                               if ((strpos($main_picture[$j]['orf_name'], '- 1.jpg') !== false)&&(strpos($main_picture[$j]['osub_id'], 'x') !== false) || (strpos($main_picture[$j]['orf_name'], '- 1.png') !== false)) { //php string contains substring                               
                                
                            ?> <img width="160px" height="90px"  src="https://cseven.eu/result_files/<?php echo $main_picture[$j]['orf_path_dom'].$main_picture[$j]['orf_internal_name_dom'];?>" alt="" class="img-fluid">
                           <?php }} */?>
                            </td>
                            <td><?php echo $order['order_name']; ?></td>
                            <td>
                                <div class="d-flex justify-content-center">
                                <input type="text" id="plans_amount" name="plans_amount" value="<?php echo $planset_order['plans_amount'];?>" class="form-control form-control-sm" style="width:5em;margin:auto;">
                                <?php
                                if($planset_order['ordered_item']==2)
                                {
                                    ?>
                                    x <?php echo $planset_order['factorial'];?>
                                    <input type="hidden" id="factorial" name="factorial" value="<?php echo $planset_order['factorial'];?>">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <input type="hidden" id="factorial" name="factorial" value="<?php echo $planset_order['factorial'];?>">
                                    <?php
                                }?>
                                <script type="text/javascript">
                                $(document).ready(function(){

                                    $('#plans_amount').on('change keyup',function(){
                                        let order_price=$('#order_price').val();
                                        let total_price=0;

                                        total_price=$(this).val() * order_price;
                                        $('#total_price').val(total_price);
                                        $('#total_price_text').text(total_price);

                                        var minutes = 30;
                                        current_date.setTime(current_date.getTime() + (minutes * 60 * 1000));

                                
                                        $.removeCookie("plans_amount", { path: '/' });
                                        $.removeCookie("total_price", { path: '/' });

                                        $.cookie("plans_amount", $(this).val(), {expires: current_date, path:'/'});
                                        $.cookie("total_price", total_price, {expires: current_date, path:'/'});
                                            
                                       
                                    });
                                });
                                </script>
                                </div|>
                            </td>
                            <td><?php 
                            //echo number_format($selected_price, 0, ',','.'); 
                            echo $planset_order['order_price'];
                            ?><?php echo " ". $symbol; ?> </td>
                            <div class="row w-100 mx-0 d-lg-none d-block mt-4">
                                <div class="list-group w-100">
                                    <div class="list-group-item">
                                        <div class="row mx-0 w-100">                                        
                                            <div class="col-12 pt-2 text-center"><?php echo $order['order_name']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group w-100 mb-4" id="projectid1">
                                    <div class="list-group-item bg-warning">
                                        <div class="row mx-0 w-100">
                                            <div class="col-12 text-center text-white">
                                            <span id="order_price_text"><?php 
                                            //echo number_format($selected_price, 0, ',','.');
                                            echo $planset_order['order_price'];
                                             ?></span><?php echo " ". $symbol; ?>
                                            <input type="hidden" id="order_price" name="order_price" value="<?php 
                                            //echo number_format($selected_price, 0, ',','.');
                                            echo $planset_order['order_price'];
                                            ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <td><span id="total_price_text"><?php 
                            //echo number_format($selected_price, 0, ',','.'); 
                            echo $planset_order['total_price'];
                            ?></span><?php echo " ". $symbol;?>
                            <input type="hidden" id="total_price" name="total_price" value="<?php 
                            //echo number_format($selected_price, 0, ',','.');
                            echo $planset_order['total_price'];
                            ?>">
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <div class="row w-100 mx-0 my-3 pb-5">
            <div class="col-lg-6 col-12">
                <table class="table text-left">
                         <?php 
                         $building_company_id = $sp7->get_building_company_id($house['presentation_id']); 
                         $bulding_company = $sp7->get_building_company_data($building_company_id); 
                        //  echo $bulding_company['mc_id'];
                        // echo "<pre>";
                        //  print_r($bulding_company);
                        //  echo "</pre>";
                         ?>
                        
                        <tbody>
                         <tr>
                            <td><b>Company:</b></td> 
                            <td><?php echo $bulding_company['clientname'] ?></td>   
                         </tr>
                         <tr>
                            <td><b>City:</b></td> 
                            <td><?php echo $bulding_company['city'] ?></td>      
                         </tr>
                         <tr>
                            <td><b>Homepage:</b></td> 
                            <td><a target="_blank" href="<?php echo $bulding_company['homepage'] ?>"><?php echo $bulding_company['homepage'] ?></a></td>
                         </tr> 
                         
                        </tbody>
                </table>
            </div> 
        </div>
        <div class="row w-100 mx-0 my-3 pb-5">
            <div class="col-md-12 text-center">
                <button type="submit" name="save_btn" id="save_btn" class="btn btn-sm btn-primary">Save</button>
            </div>
        </div>
        </form>
        <?php
        }
        ?>
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