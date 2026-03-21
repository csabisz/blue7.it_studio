<?php
session_start();
include('../functions.php');
include('../../../../superplan7.com/public_html/functions.php');

$prod=new Production;
$sp7 = new Superplans;

include('../header2.php');
include('../menu.php');

$plot_id = $prod->xss_fix($_GET['plot_id']);

$plot=$sp7->get_plot($plot_id);
?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white ">
	<?php
	if(isset($_COOKIE['client_id']))
	{		
        							
		?>
        <p class="w-100 text-center display-4 pt-4"> Details of PLOT_ID <?php echo $plot_id;?></p>
        <p class="text-center"><a href="index.php"><-Back to plots</a></p>
        <div class="row">
        <div class="col-md-12">
        <?php 
        if(isset($_POST['save_btn']))
        { 
            $plot_data['plot_id']=$prod->xss_fix($_POST['plot_id']);           
            $plot_data['owner_id']=$prod->xss_fix($_POST['owner_id']);
            $plot_data['size']=$prod->xss_fix($_POST['size']);
            $plot_data['price']=$prod->xss_fix($_POST['price']);
            $plot_data['country']=$prod->xss_fix($_POST['country']);
            $plot_data['city']=$prod->xss_fix($_POST['city']);
            $plot_data['postcode']=$prod->xss_fix($_POST['postcode']);
            $plot_data['street']=$prod->xss_fix($_POST['street']);
            $plot_data['house_no']=$prod->xss_fix($_POST['house_no']);

            /*$o_id=$prod->xss_fix($_POST['o_id']);

            if(!empty($o_id))
            {
                $prod->update_order_plot_id($o_id,$plot_id);
            } */

            $sp7->update_plot(json_encode($plot_data));
            ?>
            <div class="alert alert-success text-center">
                Plot updated !
            </div>
            
            <br>
            <meta http-equiv="refresh" content="1; url=details.php?plot_id=<?php echo $plot_data['plot_id'];?>">
        <?php
        }
        ?>
        <hr class="mb-4">

        <form name="update_plot_form" action="<?php echo $_SERVER['PHP_SELF'];?>?plot_id=<?php echo $plot_id;?>" method="post">
        <input type="hidden" name="plot_id" value="<?php echo $plot_id;?>">
        <div class="row">
            <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <b>Owner</b>
            </div>
            <div class="col-md-6">
                <select name="owner_id" class="form-control form-control-sm"> 
                    <option value="">--Select--</option>
                    <?php
                    $all_clients=$prod->get_all_active_clients();

                    for($i=0;$i<count($all_clients);$i++)
                    {
                    ?>
                    <option value="<?php echo $all_clients[$i]['client_ID'];?>" <?php echo($all_clients[$i]['client_ID']==$plot['owner_id'])?"selected":"";?>><?php
                    if(!empty($all_clients[$i]['c_first_name']))
                    {
                        echo $all_clients[$i]['clientname']." - ".$all_clients[$i]['c_last_name'].", ".$all_clients[$i]['c_first_name'];
                    }
                    elseif(!empty($all_clients[$i]['l_last_name']))
                    {
                        echo $all_clients[$i]['clientname']." - ".$all_clients[$i]['l_last_name'].", ".$all_clients[$i]['l_first_name'];
                    }
                    else
                    {
                        echo $all_clients[$i]['clientname'];
                    }?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b>Plot size (m<sup>2</sup>)</b>
            </div>
            <div class="col-md-6">
                <input name="size" type="text" class="form-control formc-ontrol-sm" value="<?php echo $plot['size'];?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b>Price</b>
            </div>
            <div class="col-md-6">
                <input name="price" type="text" class="form-control formc-ontrol-sm" value="<?php echo $plot['price'];?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b>Country</b>
            </div>
            <div class="col-md-6">
                <select name="country" class="form-control form-control-sm">
                    <option value="">--Select--</option>
                    <?php
                    /*$countries=$prod->show_areas();

                    for($c=0;$c<count($countries);$c++)
                    {
                        ?>
                        <option value="<?php echo $countries[$c]['a_id'];?>" <?php echo ($countries[$c]['a_id']==$plot['country'])?"selected":"";?>><?php echo $countries[$c]['area'];?></option>
                        <?php
                    } */
                    ?>
                     
                        <?php
                        $areas=$prod->show_areas();

                        for($i=0;$i<count($areas);$i++)
                        {
                            if(($areas[$i]['a_id']==5)||($areas[$i]['a_id']==18)||($areas[$i]['a_id']==36)||($areas[$i]['a_id']==1)||($areas[$i]['a_id']==28)||($areas[$i]['a_id']==21)||($areas[$i]['a_id']==37)||($areas[$i]['a_id']==29))
                            {
                            ?>
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$plot['country'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
                            <?php
                            }
                        }
                        ?>
                        <option value="">--------------------------------</option>
                        <?php
                        for($i=0;$i<count($areas);$i++)
                        {
                            if(($areas[$i]['a_id']!=5)&&($areas[$i]['a_id']!=18)&&($areas[$i]['a_id']!=36)&&($areas[$i]['a_id']!=1)&&($areas[$i]['a_id']!=28)&&($areas[$i]['a_id']!=21)&&($areas[$i]['a_id']!=37)&&($areas[$i]['a_id']!=29))
                            {
                            ?>					
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$plot['country'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
                            <?php
                            }
                        }
                        ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b>City</b>
            </div>
            <div class="col-md-6">
                <input type="text" name="city" class="form-control formc-ontrol-sm" value="<?php echo $plot['city'];?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b>Postcode</b>
            </div>
            <div class="col-md-6">
                <input type="text" name="postcode" class="form-control formc-ontrol-sm" value="<?php echo $plot['postcode'];?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b>Street</b>
            </div>
            <div class="col-md-6">
                <input type="text" name="street" class="form-control formc-ontrol-sm" value="<?php echo $plot['street'];?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b>House nr.</b>
            </div>
            <div class="col-md-6">
                <input type="text" name="house_no" class="form-control formc-ontrol-sm" value="<?php echo $plot['house_no'];?>">
            </div>
        </div>
        </div> <!--end col-md-6 -->

        <div class="col-md-6">
            <!--<div class="row">
            <div class="col-md-7">
                <b>Link this plot to a new order_id</b>
            </div>
            <div class="col-md-2">
                <input type="text" name="o_id" value="" class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>-->
            
            <div class="row">
                <div class="col-md-12">
                    <b>Linked order_ids:</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>
                    <?php
                    $plot_orders=$prod->get_all_orders_by_plot_id($plot_id);

                    for($p=0;$p<count($plot_orders);$p++)
                    {
                    ?>
                    <a href="https://cseven.eu/studio/acceptance/orderdetails.php?o_id=<?php 
                    echo $plot_orders[$p]['order_ID'];?>&status=accepted" class="btn btn-sm btn-primary" target="_blank">Order <?php 
                    echo $plot_orders[$p]['order_ID'];?></a>
                    <?php
                    }
                    ?>
                    </p>
                    <script type="text/javascript">
                    /* $(document).ready(function(){
                        $('input[name=order_ids]').click(function(){
                            var o_id=$(this).data('o_id');
                            var plot_id=$(this).data('plot_id');
                            
                            if($(this).is(":checked"))
                            {
                                $.ajax({
                                    url: "../ajax/update_order_plot_id.php",
                                    method: "get",
                                    data: {o_id:o_id,plot_id:plot_id},
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);	
                                    }
                                });
                            }
                            else
                            {
                                $.ajax({
                                    url: "../ajax/update_order_plot_id.php",
                                    method: "get",
                                    data: {o_id:o_id,plot_id:"0"},
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);	
                                    }
                                });
                            }
                        });
                    }); */
                    </script>
                </div>
            </div>
        </div> <!--end col-md-6 -->
        </div> <!-- end row -->

        <div class="row">
           <div class="col-md-12 text-center">
                <button type="submit" name="save_btn" class="btn btn-sm btn-primary">Save</button>
           </div>
        </div>
        </form>
        </div> <!-- end col-md-12 -->
        </div> <!-- end row -->
        <br>

	<?php		
	}
	else
	{
	?>
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