<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('../functions.php');
include('../../../superfloorplans.com/public_html/functions.php');
include('../../../superfloorplans.com/public_html/price_calculations.php');
include('../../../domenia7.com/public_html/domenia_db2.php');
include('../../../cseven.eu/public_html/domenia/domenia.php');
$prod=new Production;
$price=new PriceCalculations;
$domenia2=new Domenia2;
$domenia=new Domenia;
include('../header2.php');
include('../menu.php');

$client=$prod->get_client($_SESSION['client_id']);

$licence_sites=explode(";",$client['ls_ids']);
?>
<section class="acceptance pt-5">
	<article>
		<div class="container pagecontent px-0 bg-white mb-5 py-3">
            <p class="w-100 text-center display-4">Acceptance - Contracting</p>
            <hr class="mb-4" width="450px">
            <div class="row mx-0 w-100 d-flex justify-content-center">
            <?php
            include('submenu.php');
            ?></div>
            <br>
            <div style="font-size: 30px">
                <p class="text-center text-primary w-100">Acceptance of orders - Contracting </p>
            </div>
		<?php
if(isset($_SESSION['client_id']))
{				
				
if(isset($_GET['o_correction']))
{
	
	/*
	?>
	<div class="alert alert-warning">Working... Please wait...</div>
	<meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $new_order['order_ID'];?>">
	<?php */
}

if((isset($_POST['save_btn']))||(isset($_POST['accept_btn'])))				
{
	//create 
	$o_correction=$prod->xss_fix($_POST['o_correction']);
	
	
	if(!empty($o_correction))
	{
	//getting old order values
	
	$old_order=$prod->get_order($o_correction);
	
	$data['currentdatetime']=gmdate("Y-m-d H:i:s");
	$data['ls_id']=$old_order['ls_id'];
	$data['om_id']=$o_correction;
	$data['order_name']=$old_order['order_name'];
    $data['lic_ID']=$old_order['lic_ID'];
    $data['client_extras_ex_b5']=$prod->xss_fix($_POST['customer_remarks_ex_b5']);
    $data['op_remarks_ex_b5']=$prod->xss_fix($_POST['op_remarks_ex_b5']);
    $data['cur_id']=$prod->xss_fix($_POST['cur_id']);
	$data['client_language_id']=$old_order['client_language_id'];
    $data['mc_id']=$old_order['mc_id'];
    $data['cur_id']=$old_order['cur_id'];
	$data['u_client_ID']=$old_order['u_client_ID'];
	$data['collection']=$old_order['collection'];
	$data['u_prod_id']=$old_order['u_prod_id'];
	$data['o_correction']=1;
	
	$prod->create_order2(json_encode($data));
	
	$new_order=$prod->show_last_order();
	
	$old_o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_correction);
	$old_o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_correction);
	
	$old_o_desc_in_b3=$prod->get_o_desc_in_b3($o_correction);
	$old_o_desc_in_b5=$prod->get_o_desc_in_b5($o_correction);
	$old_o_desc_in_b7=$prod->get_o_desc_in_b7($o_correction);
	
	if(count($old_o_desc_ex_b5)>0)
	{
		$new_ex_b5_data['o_id']=$new_order['order_ID'];
		$new_ex_b5_data['rs_id']=$old_o_desc_ex_b5['rs_id'];
		$new_ex_b5_data['rmp_id']=$old_o_desc_ex_b5['rmp_id'];
		$new_ex_b5_data['r_tilt']=$old_o_desc_ex_b5['r_tilt'];
		$new_ex_b5_data['r_kneewall']=$old_o_desc_ex_b5['r_kneewall'];
		$new_ex_b5_data['rop_id']=$old_o_desc_ex_b5['rop_id'];
		$new_ex_b5_data['r_gutter_id']=$old_o_desc_ex_b5['r_gutter_id'];
		$new_ex_b5_data['e_length']=$old_o_desc_ex_b5['e_length'];
		$new_ex_b5_data['e_width']=$old_o_desc_ex_b5['e_width'];
		$new_ex_b5_data['wlc_id']=$old_o_desc_ex_b5['wlc_id'];		
		$new_ex_b5_data['ww_id']=$old_o_desc_ex_b5['ww_id'];
		$new_ex_b5_data['gc_id']=$old_o_desc_ex_b5['gc_id'];
		$new_ex_b5_data['gc_length']=$old_o_desc_ex_b5['gc_length'];
		$new_ex_b5_data['gc_width']=$old_o_desc_ex_b5['gc_width'];
		$new_ex_b5_data['gc_height']=$old_o_desc_ex_b5['gc_height'];
		$new_ex_b5_data['reelings_id']=$old_o_desc_ex_b5['reelings_id'];
		$new_ex_b5_data['wc_id']=$old_o_desc_ex_b5['wc_id'];
		$new_ex_b5_data['door_color']=$old_o_desc_ex_b5['door_color'];
		$new_ex_b5_data['door_texture']=$old_o_desc_ex_b5['door_texture'];
		$new_ex_b5_data['dsp_id']=$old_o_desc_ex_b5['dsp_id'];
		$new_ex_b5_data['pbp_id']=$old_o_desc_ex_b5['pbp_id'];
		$new_ex_b5_data['basement']=$old_o_desc_ex_b5['basement'];
		$new_ex_b5_data['levels_over_ground']=$old_o_desc_ex_b5['levels_over_ground'];
		
		$new_ex_b5_data['col_amount_ex_b5']=$old_o_desc_ex_b5['col_amount_ex_b5'];
		
		$prod->add_o_desc_ex_b52(json_encode($new_ex_b5_data));
	}
	if(count($old_o_desc_ex_b7)>0)
	{
		$new_ex_b7_data['o_id']=$new_order['order_ID'];
		$new_ex_b7_data['rs_id']=$old_o_desc_ex_b7['rs_id'];
		$new_ex_b7_data['rmp_id']=$old_o_desc_ex_b7['rmp_id'];
		$new_ex_b7_data['r_tilt']=$old_o_desc_ex_b7['r_tilt'];
		$new_ex_b7_data['r_kneewall']=$old_o_desc_ex_b7['r_kneewall'];
		$new_ex_b7_data['rop_id']=$old_o_desc_ex_b7['rop_id'];
		$new_ex_b7_data['r_gutter_id']=$old_o_desc_ex_b7['r_gutter_id'];
		$new_ex_b7_data['e_length']=$old_o_desc_ex_b7['e_length'];
		$new_ex_b7_data['e_width']=$old_o_desc_ex_b7['e_width'];
		$new_ex_b7_data['wlc_id']=$old_o_desc_ex_b7['wlc_id'];		
		$new_ex_b7_data['ww_id']=$old_o_desc_ex_b7['ww_id'];
		$new_ex_b7_data['gc_id']=$old_o_desc_ex_b7['gc_id'];
		$new_ex_b7_data['gc_length']=$old_o_desc_ex_b7['gc_length'];
		$new_ex_b7_data['gc_width']=$old_o_desc_ex_b7['gc_width'];
		$new_ex_b7_data['gc_height']=$old_o_desc_ex_b7['gc_height'];
		$new_ex_b7_data['reelings_id']=$old_o_desc_ex_b7['reelings_id'];
		$new_ex_b7_data['wc_id']=$old_o_desc_ex_b7['wc_id'];
		$new_ex_b7_data['door_color']=$old_o_desc_ex_b7['door_color'];
		$new_ex_b7_data['door_texture']=$old_o_desc_ex_b7['door_texture'];
		$new_ex_b7_data['dsp_id']=$old_o_desc_ex_b7['dsp_id'];
		$new_ex_b7_data['pbp_id']=$old_o_desc_ex_b7['pbp_id'];
		$new_ex_b7_data['basement']=$old_o_desc_ex_b7['basement'];
		$new_ex_b7_data['levels_over_ground']=$old_o_desc_ex_b7['levels_over_ground'];
		
		$new_ex_b7_data['col_amount_ex_b7']=$old_o_desc_ex_b7['col_amount_ex_b7'];
		
		$prod->add_o_desc_ex_b72(json_encode($new_ex_b7_data));
	}
	
	if(count($old_o_desc_in_b3)>0)
	{
		$new_in_b3_data['o_id']=$new_order['order_ID'];
		$new_in_b3_data['sl_id']=$old_o_desc_in_b3['sl_id'];
		$new_in_b3_data['cls_id']=$old_o_desc_in_b3['cls_id'];
		
		$new_in_b3_data['b3_col_amount']=$old_o_desc_in_b3['col_amount_in_b3'];
		
		$prod->add_o_desc_in_b32(json_encode($new_in_b3_data));
	}
	
	if(count($old_o_desc_in_b5)>0)
	{
		$new_in_b5_data['o_id']=$new_order['order_ID'];
		$new_in_b5_data['layout_id']=$old_o_desc_in_b5['layout_id'];
		$new_in_b5_data['window_id']=$old_o_desc_in_b5['window_id'];
		$new_in_b5_data['b5_col_amount']=$old_o_desc_in_b5['col_amount_in_b5'];
		
		$prod->add_o_desc_in_b52(json_encode($new_in_b5_data));
	}
	if(count($old_o_desc_in_b7)>0)
	{
		$new_in_b7_data['o_id']=$new_order['order_ID'];
		$new_in_b7_data['layout_id']=$old_o_desc_in_b7['layout_id'];
		$new_in_b7_data['window_id']=$old_o_desc_in_b7['window_id'];
		$new_in_b7_data['col_amount_in_b7']=$old_o_desc_in_b7['col_amount_in_b7'];
		
		$prod->add_o_desc_in_b72(json_encode($new_in_b7_data));
	}
	
	$mistakes=$_POST['mistake'];
	$amendments=$_POST['amendment'];
	
	for($i=0;$i<count($mistakes);$i++)
	{	
		$mistake=explode(".",$mistakes[$i]);
		
		$mistake_data['o_id']=$new_order['order_ID'];
		$mistake_data['om_id']=$mistake[2];
		$mistake_data['osub_id']=$mistake[3];
		$mistake_data['prod_id']=$mistake[4];
		
		$old_product_data['o_id']=$mistake_data['om_id'];
		$old_product_data['osub_id']=$mistake_data['osub_id'];
		$old_product_data['prod_id']=$mistake_data['prod_id'];
		
		$old_product=$prod->get_order_product(json_encode($old_product_data));
		$mistake_data['uca_id']=$old_product['uca_id'];
		$mistake_data['p_status']=5;
		$mistake_data['om_correction']=1;
		
		$existing_product=$prod->get_order_product(json_encode($mistake_data));
		
		if(count($existing_product)==0)
		{
			$prod->add_order_products2(json_encode($mistake_data));
		}
		else
		{
			$mistake_data['om_amendment']=$existing_product['om_amendment'];
			$prod->update_order_product(json_encode($mistake_data));
		}
	}
	
	for($i=0;$i<count($amendments);$i++)
	{		
		$amendment=explode(".",$amendments[$i]);
		
		$amendment_data['o_id']=$new_order['order_ID'];
		$amendment_data['om_id']=$amendment[2];
		$amendment_data['osub_id']=$amendment[3];
		$amendment_data['prod_id']=$amendment[4];
		
		$old_product_data['o_id']=$amendment_data['om_id'];
		$old_product_data['osub_id']=$amendment_data['osub_id'];
		$old_product_data['prod_id']=$amendment_data['prod_id'];
		
		$old_product=$prod->get_order_product(json_encode($old_product_data));
		$amendment_data['uca_id']=$old_product['uca_id'];
		$amendment_data['p_status']=5;
		$amendment_data['om_amendment']=1;
		
		$existing_product=$prod->get_order_product(json_encode($amendment_data));
		
		if(count($existing_product)==0)
		{
			$prod->add_order_products2(json_encode($amendment_data));
		}
		else
		{
			$amendment_data['om_correction']=$existing_product['om_correction'];
			$prod->update_order_product(json_encode($amendment_data));
		}
	}
	?>
	<div class="alert alert-warning">Processing... Please wait...</div>
	<?php
	}
	
	
	//update
	
	if(!empty($o_correction))
	{
		$update_data['o_id']=$new_order['order_ID'];
	}
	else
	{
		$update_data['o_id']=$prod->xss_fix($_POST['o_id']);
	}
	
	$new_order=$prod->get_order($update_data['o_id']);
	
	$update_data['om_id']=$new_order['om_id'];
	
	$old_order=$prod->get_order($update_data['om_id']);
	
	$update_data['collection']=$old_order['collection'];
	$update_data['order_name']=$prod->xss_fix($_POST['order_name']);
	$update_data['customer_remarks']=$prod->xss_fix($_POST['customer_remarks']);
    $update_data['op_remarks']=$prod->xss_fix($_POST['op_remarks']);
    $update_data['client_extras_ex_b5']=$prod->xss_fix($_POST['customer_remarks_ex_b5']);
    $update_data['op_remarks_ex_b5']=$prod->xss_fix($_POST['op_remarks_ex_b5']);
    $update_data['cur_id']=$prod->xss_fix($_POST['cur_id']);
    $update_data['client_language_id']=$prod->xss_fix($_POST['client_language_id']);
	$update_data['environment_address']=$old_order['environment_address'];
	$update_data['u_prod_id']=$old_order['u_prod_id'];
	$update_data['notifications']=$old_order['notifications'];
	$update_data['o_status']=1;
	
	$prod->update_order2(json_encode($update_data));
	
	//b5 ex
	
	$ex_b5_data['o_id']=$prod->xss_fix($_POST['o_id']);
	
	$old_o_desc_ex_b5=$prod->get_o_desc_ex_b5($ex_b5_data['o_id']);
	
	if(count($old_o_desc_ex_b5)>0)
	{
	$ex_b7_data['col_price_ex_b5']=$prod->xss_fix($_POST['col_price_ex_b5']);
	$ex_b7_data['fac_cl_ex_b5']=$prod->xss_fix($_POST['fac_cl_ex_b5']);
	$ex_b7_data['o_price_ex_b5']=$prod->xss_fix($_POST['o_price_ex_b5']);
	
	$ex_b5_data['col_apus_ex_b5']=$prod->xss_fix($_POST['col_apus_ex_b5']);
	$ex_b5_data['fac_prod_ex_b5']=$prod->xss_fix($_POST['fac_prod_ex_b5']);
	$ex_b5_data['o_apus_ex_b5']=$prod->xss_fix($_POST['o_apus_ex_b5']);
	
	$ex_b5_data['col_labc_ex_b5']=$prod->xss_fix($_POST['col_labc_ex_b5']);
	$ex_b5_data['fac_labc_ex_b5']=$prod->xss_fix($_POST['fac_labc_ex_b5']);
	$ex_b5_data['total_labcs_ex_b5']=$prod->xss_fix($_POST['total_labcs_ex_b5']);
	
	$prod->update_o_desc_ex_b52(json_encode($ex_b5_data));
	}
	
	//b7 ex
	
	$ex_b7_data['o_id']=$prod->xss_fix($_POST['o_id']);
	
	$old_o_desc_ex_b7=$prod->get_o_desc_ex_b7($ex_b7_data['o_id']);
	
	if(count($old_o_desc_ex_b7)>0)
	{
	$ex_b7_data['col_price_ex_b7']=$prod->xss_fix($_POST['col_price_ex_b7']);
	$ex_b7_data['fac_cl_ex_b7']=$prod->xss_fix($_POST['fac_cl_ex_b7']);
	$ex_b7_data['o_price_ex_b7']=$prod->xss_fix($_POST['o_price_ex_b7']);
	
	$ex_b7_data['col_apus_ex_b7']=$prod->xss_fix($_POST['col_apus_ex_b7']);
	$ex_b7_data['fac_prod_ex_b7']=$prod->xss_fix($_POST['fac_prod_ex_b7']);
	$ex_b7_data['o_apus_ex_b7']=$prod->xss_fix($_POST['o_apus_ex_b7']);
	
	$ex_b7_data['col_labc_ex_b7']=$prod->xss_fix($_POST['col_labc_ex_b7']);
	$ex_b7_data['fac_labc_ex_b7']=$prod->xss_fix($_POST['fac_labc_ex_b7']);
	$ex_b7_data['total_labcs_ex_b7']=$prod->xss_fix($_POST['total_labcs_ex_b7']);
	
	$prod->update_o_desc_ex_b72(json_encode($ex_b7_data));
	}
	
	//b3 in
	
	$in_b3_data['o_id']=$prod->xss_fix($_POST['o_id']);
	
	$old_o_desc_in_b3=$prod->get_o_desc_in_b3($in_b3_data['o_id']);
	
	if(count($old_o_desc_in_b7)>0)
	{
	$in_b3_data['col_price_in_b3']=$prod->xss_fix($_POST['col_price_in_b3']);
	$in_b3_data['fac_cl_in_b3']=$prod->xss_fix($_POST['fac_cl_in_b3']);
	$in_b3_data['o_price_in_b3']=$prod->xss_fix($_POST['o_price_in_b3']);
	
	$in_b3_data['col_apus_in_b3']=$prod->xss_fix($_POST['col_apus_in_b3']);
	$in_b3_data['fac_prod_ex_b3']=$prod->xss_fix($_POST['fac_prod_in_b3']);
	$in_b3_data['o_apus_in_b3']=$prod->xss_fix($_POST['o_apus_in_b3']);
	
	$in_b3_data['col_labc_in_b3']=$prod->xss_fix($_POST['col_labc_in_b3']);
	$in_b3_data['fac_labc_in_b3']=$prod->xss_fix($_POST['fac_labc_in_b3']);
	$in_b3_data['total_labcs_in_b3']=$prod->xss_fix($_POST['total_labcs_in_b3']);
	
	$prod->update_o_desc_in_b32(json_encode($in_b3_data));
	}
	
	//b5 in
	
	$in_b5_data['o_id']=$prod->xss_fix($_POST['o_id']);
	
	$old_o_desc_in_b5=$prod->get_o_desc_in_b5($in_b5_data['o_id']);
	
	if(count($old_o_desc_in_b5)>0)
	{
	$in_b5_data['col_price_in_b5']=$prod->xss_fix($_POST['col_price_in_b5']);
	$in_b5_data['fac_cl_in_b5']=$prod->xss_fix($_POST['fac_cl_in_b5']);
	$in_b5_data['o_price_in_b5']=$prod->xss_fix($_POST['o_price_in_b5']);
	
	$in_b5_data['col_apus_in_b5']=$prod->xss_fix($_POST['col_apus_in_b5']);
	$in_b5_data['fac_prod_in_b5']=$prod->xss_fix($_POST['fac_prod_in_b5']);
	$in_b5_data['o_apus_in_b5']=$prod->xss_fix($_POST['o_apus_in_b5']);
	
	$in_b5_data['col_labc_in_b5']=$prod->xss_fix($_POST['col_labc_in_b5']);
	$in_b5_data['fac_labc_in_b5']=$prod->xss_fix($_POST['fac_labc_in_b5']);
	$in_b5_data['total_labcs_in_b5']=$prod->xss_fix($_POST['total_labcs_in_b5']);
	
	$prod->update_o_desc_in_b52(json_encode($in_b5_data));
	}
	
	//b7 in
	
	$in_b7_data['o_id']=$prod->xss_fix($_POST['o_id']);
	
	$old_o_desc_in_b7=$prod->get_o_desc_in_b7($in_b7_data['o_id']);
	
	if(count($old_o_desc_in_b7)>0)
	{
	$in_b7_data['col_price_in_b7']=$prod->xss_fix($_POST['col_price_in_b7']);
	$in_b7_data['fac_cl_in_b7']=$prod->xss_fix($_POST['fac_cl_in_b7']);
	$in_b7_data['o_price_in_b7']=$prod->xss_fix($_POST['o_price_in_b7']);
	
	$in_b7_data['col_apus_in_b7']=$prod->xss_fix($_POST['col_apus_in_b7']);
	$in_b7_data['fac_prod_in_b7']=$prod->xss_fix($_POST['fac_prod_in_b7']);
	$in_b7_data['o_apus_in_b7']=$prod->xss_fix($_POST['o_apus_in_b7']);
	
	$in_b7_data['col_labc_in_b7']=$prod->xss_fix($_POST['col_labc_in_b7']);
	$in_b7_data['fac_labc_in_b7']=$prod->xss_fix($_POST['fac_labc_in_b7']);
	$in_b7_data['total_labcs_in_b7']=$prod->xss_fix($_POST['total_labcs_in_b7']);
	
	$prod->update_o_desc_in_b72(json_encode($in_b7_data));
	}
	?>
	<meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $update_data['o_id'];?>&status=accepted">
	<?php  
}

if(isset($_POST['delete_btn']))
{
	$of_id=$_POST['of_id'];
	
	$prod->delete_customer_file($of_id);
	?>
	<div class="center_message"> <div class="success">File deleted !</div></div><br>
	<?php
}
				
//acceptance variables

	
$o_correction=$prod->xss_fix($_GET['o_correction']);	


$o_id=$prod->xss_fix($_GET['o_id']);

			
if(isset($_GET['o_correction']))
{
	$o_id=$o_correction;
}

$order=$prod->get_order($o_id);

$old_order=$prod->get_order($order['om_id']);

$clientid=$order['u_client_ID'];
$client=$prod->get_client($clientid);


$licid=$order['lic_ID'];

$licence=$prod->get_licence($licid);



$currency=$prod->get_currency($order['cur_id'])['cur_short'];

$lic_site=$prod->get_order_website($order['ls_id']);
$cur_fac_column="cur_fac_".strtolower($currency);
$cur_factor=$lic_site[$cur_fac_column];
?>
			
<form id="order_details" name="order_details" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>?<?php 
if(isset($_GET['o_id']))
{
	echo "o_id=".$o_id; 
}
if(isset($_GET['status']))
{
	echo "&status=".$prod->xss_fix($_GET['status']);
}
if(isset($_GET['option']))
{
	echo "option=".$prod->xss_fix($_GET['option']);
}
?>"></form>

<input type="hidden" name="o_id" value="<?php echo $o_id; ?>" form="order_details">
<input type="hidden" name="o_correction" value="<?php echo $o_correction; ?>" form="order_details">
<input type="hidden" name="clientid" value="<?php echo $clientid; ?>" form="order_details">
<input type="hidden" name="licenceid" value="<?php echo $licid; ?>" form="order_details">
<input type="hidden" name="client_language_id" value="<?php echo $order['client_language_id']; ?>" form="order_details">
<input type="hidden" name="ls_id" value="<?php echo $order['ls_id']; ?>" form="order_details">
<input type="hidden" name="cur_id" value="<?php echo $order['cur_id']; ?>" form="order_details">

<div class="row w-100 mx-0">
	<div class="col-md-6 border py-2">
	<b>Website = </b> <?php 
	$website=$prod->get_order_website($order['ls_id']);
	echo $website['ls_name'];?> <br>
				
	<b>Order ID:</b> <?php echo $o_id; ?> <br>
	
	<b>Correction/Amendment to:</b> <a href="orderdetails.php?o_id=<?php echo $order['om_id'];?>&status=accepted" target="_blank"><?php echo $order['om_id'];?></a>
	<?php
	$licence_taker=$prod->get_licence_taker($o_id);				
	?>
	<br>Trader = Licence ID: <?php echo $order['lic_ID']; ?> - <?php echo $licence_taker['Company']." - ".$licence_taker['contact-persons-for-us']." - ".$licence_taker['phone']; ?>
	<br>
	
	<div class="p-1" style="background-color:#bad4ff">
		Purchaser = Client ID: <?php echo $client['client_ID']; ?> -  Enterprise: <?php echo $client['clientname']; ?> - <?php echo $client['l_title']." ".$client['l_first_name']." ".$client['l_last_name']; ?> - <?php echo $client['phone']; ?>
		<div class="inline-flex">
		- Client credibility:
		<select name="client_credibility" id="client_credibility" class="form-control form-control-sm" form="order_details" style="width:50px;" disabled>
			<option value="">-- Select --</option>
			<?php
			for($i=0;$i<10;$i++)
			{
			?>
			<option value="<?php echo $i;?>" <?php echo ($client['client_credibility']==$i)?"selected":""?>><?php echo $i;?></option>
			<?php
			}
			?>
		</select>
		</div>
	</div>
	
	<br>			
	<div class="inline-flex">
		<b class="pt-1 mr-2">Project name: </b><input type="text" class="form-control form-control-sm" name="order_name" value="<?php echo $order['order_name']; ?>" style="width:250px;" form="order_details" required>
	</div>	
	<br>
	
	</div>
	
	<div class="col-md-6 border">
		<label class="pt-4" for="allmessages">Comunications</label>
		<textarea id="allmessages" class="form-control" name="allmessages" rows="2" cols="6" placeholder="No messages yet" readonly><?php
			$allmessages=$prod->get_all_trader_purchaser_messages($o_id);
			
			for($i=0;$i<count($allmessages);$i++)
			{
				$uca_id=$allmessages[$i]['uca_id'];
				$client_id=$allmessages[$i]['client_id'];
				
				if($uca_id!=0)
				{
                    $uca_name=$prod->get_client($uca_id);
                    if(!empty($uca_name['c_last_name']))
                    {
                        echo $uca_name['c_first_name']." ".$uca_name['c_last_name'].": ".$allmessages[$i]['message']."&#13;&#10;"; //\t\n - new line
                    }
                    else
                    {
                        echo $uca_name['l_first_name']." ".$uca_name['l_last_name'].": ".$allmessages[$i]['message']."&#13;&#10;"; //\t\n - new line
                    }
				}
				if($client_id!=0)
				{
					$client_name=$prod->get_client($client_id);
					echo $client_name['c_title']." ".$client_name['c_first_name']." ".$client_name['c_last_name'].": ".$allmessages[$i]['message']."&#13;&#10;";
				}
				
			}
			?>
		</textarea>
		<br>
		<?php 
		if((!isset($_GET['status']))&&($_GET['status']!="accepted"))
		{
		?>
		<button name="accept_btn" class="btn btn-primary btn-sm" form="order_details">Accept</button>
		<?php
		}
		?>
		<a href="message_to_client.php?o_id=<?php echo $o_id; ?>" class="btn btn-warning btn-sm">Message to client</a>
		<?php
		if((!isset($_GET['status']))&&($_GET['status']!="accepted"))
		{
		?>
		<a href="index.php?orderstatus=1-9" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Reject</a>
		<?php
		}
		?>
	</div>
	
</div>	

<?php

//b5 ex
if(isset($_GET['o_correction']))
{
	$b5_ex_prods=$prod->get_b5_ex_ordered_products($order['order_ID']);
}
else
{
	$b5_ex_prods=$prod->get_b5_ex_ordered_products($old_order['order_ID']);			
}
//$new_b5_ex_prods=$prod->get_b5_ex_ordered_products($o_id);

//$o_desc_ex_b5=$prod->get_o_desc_ex_b5($order['order_ID']);
$allstatus=$prod->showallstatus();
$osub_id=0;
$global_column_count=1;

if(count($b5_ex_prods)>0)
{
?>				
<!-- b5 exterior -->
<div class="row w-100 mx-0 <?php 
if($order['o_status']==8)
{
	echo "black";
}
?>" style="background-color:#e6ffe8;">
	
<?php	
//for($k=0;$k<=$o_desc_ex_b5['col_amount_ex_b5'];$k++)
//{
?>
<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
	<div class="row w-100 mx-0" style="margin-right:5px;margin-left:5px;">
	<?php
	for($l=0;$l<count($b5_ex_prods);$l++)
	{
		/*if($b5_ex_prods[$l]['osub_id']>$osub_id)
		{
		?>
		</div> <!-- row -->
		</div> <!-- col-md-4 -->
		<?php
		if($global_column_count % 3 ==0)
		{
		?>
		<div class="row"><div class="col-md-12">&nbsp;</div></div>
		<?php
		}
		$global_column_count++;
		?>
		<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
		<div class="row" style="margin-right:5px;margin-left:5px;">
		<?php
			$osub_id++;
		}*/
		$product=$prod->get_product($b5_ex_prods[$l]['prod_id']);
		
		$product_price=$price->calculateProductPrice($b5_ex_prods[$l]['prod_id'],$cur_factor);
							
		$product_apu=$prod->calculateProductAPU($b5_ex_prods[$l]['prod_id']);
		$product_labc=$prod->calculateProductlabc($b5_ex_prods[$l]['prod_id']);
		
		$data['o_id']=$o_id;
		$data['osub_id']=$b5_ex_prods[$l]['osub_id'];
		$data['prod_id']=$b5_ex_prods[$l]['prod_id'];
		
		$new_prod_status=$prod->get_order_product(json_encode($data));
				
		//if($osub_id==$b5_ex_prods[$l]['osub_id'])
		//{
	?>	
	<div class="col-md-6" style="padding-left:3px;padding-right:3px;">
	<div style="border: 2px solid red;">
		<div class="<?php
		for($j=0;$j<count($allstatus);$j++)
		{
			if($order['o_status']>0)
			{					
				if($allstatus[$j]['ost_id']==$new_prod_status['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}
			}
			else
			{
				if($allstatus[$j]['ost_id']==$b5_ex_prods[$l]['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}
			}
		}
		?>" style="text-align:center;"><?php echo $order['om_id'].".".$b5_ex_prods[$l]['osub_id'].".".$b5_ex_prods[$l]['prod_id'].".".$o_id; ?> - <?php echo $product_price." ".$currency;?>
		</div>
		<div class="row white w-100 mx-0" style="margin:0px;">
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_prods[$l]['osub_id']."_".$b5_ex_prods[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b5_ex_prods[$l]['osub_id'].".".$b5_ex_prods[$l]['prod_id'];?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b5_ex_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b5_ex_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_correction']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_prods[$l]['osub_id']."_".$b5_ex_prods[$l]['prod_id'];?>">Correct</label>
				</div>
			</div>	
			<script type="text/javascript">
					$(document).ready(function(){
					$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_prods[$l]['osub_id']."_".$b5_ex_prods[$l]['prod_id'];?>').click(function(){
						
						if($(this).is(":checked"))
						{
							
							$.ajax({
							url: "../ajax/o_correction.php",
							method: "get",
							data: {method: "create", product: $(this).val()},
							dataType:"html",
							success:function(data) {
								console.log(data);								
							},
							error: function (xhr, ajaxOptions, thrownError) {
								console.log(xhr.status);
								console.log(thrownError);
							  }
							});
						}
						else
						{
							
							$.ajax({
							url: "../ajax/o_correction.php",
							method: "get",
							data: {method: "delete", product: $(this).val()},
							dataType:"html",
							success:function(data) {
								console.log(data);								
							},
							error: function (xhr, ajaxOptions, thrownError) {
								console.log(xhr.status);
								console.log(thrownError);
							  }
							});
						}
					});
					});
					</script>
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_prods[$l]['osub_id']."_".$b5_ex_prods[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b5" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b5_ex_prods[$l]['osub_id'].".".$b5_ex_prods[$l]['prod_id'];?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b5_ex_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b5_ex_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_amendment']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_prods[$l]['osub_id']."_".$b5_ex_prods[$l]['prod_id'];?>">Amend</label>
				<input type="hidden" id="product_<?php echo $b5_ex_prods[$l]['prod_id'];?>_price" name="product_<?php echo $b5_ex_prods[$l]['prod_id'];?>_price" class="<?php 
				
				if($new_prod_status['om_amendment']==1)
				{
					echo "prices_ex_b5";
				}
				
				?>" value="<?php echo $product_price; ?>">
					<input type="hidden" id="product_<?php echo $b5_ex_prods[$l]['prod_id'];?>_apu" name="product_<?php echo $b5_ex_prods[$l]['prod_id'];?>_apu" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "apus_ex_b5";					
				}
				?>" value="<?php echo $product_apu; ?>">
					<input type="hidden" id="product_<?php echo $b5_ex_prods[$l]['prod_id'];?>_labc" name="product_<?php echo $b5_ex_prods[$l]['prod_id'];?>_labc" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "labcs_ex_b5";					
				}
				?>" value="<?php echo $product_labc; ?>"> 
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_prods[$l]['osub_id']."_".$b5_ex_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
			</div>	
		</div>
	</div>															
	<?php
		//}
	}
	?>
	</div>
</div>
<?php
//}
?>
</div> <!-- ex b5 row -->		

<br>

<div class="row form-inline w-100 mx-0 text-center">
	<div class="col-md-12">
		<b>Trader-Purchaser: Col EX B5 = </b>
		<input class="form-control form-control-sm" type="text" name="col_price_ex_b5" id="col_price_ex_b5" value="" form="order_details" style="width:5em"> 
		<b><?php echo $currency; ?> X fac_client_ex_b5 = </b> 
		<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b5" id="fac_cl_ex_b5" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b>=</b> 
		<input type="text" class="form-control form-control-sm" name="o_price_ex_b5" id="o_price_ex_b5" value="" form="order_details" style="width:5em">
		<b><?php echo $currency; ?></b>			
		<br><br>
	</div>
</div>
<div class="row form-inline w-100 mx-0 text-center">
	<div class="col-md-12">
		<b>Producer-Trader: Col EX B5 = </b>
		<input type="text" class="form-control form-control-sm" name="col_apus_ex_b5" id="col_apus_ex_b5" value="" form="order_details" style="width:5em"> <b>APUs X fac_prod_ex_b5 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b5" id="fac_prod_ex_b5" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 		
		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b5" id="o_apus_ex_b5" value="<?php echo $o_desc_in_b5['o_apus_in_b5'];?>" form="order_details" style="width:5em"> <b>APUs</b><br><br>
	</div>
</div>			
<div class="row form-inline w-100 mx-0 text-center">
	<div class="col-md-12">
		<b>Employee-Producer: Col EX B5 = </b>
		<input type="text" class="form-control form-control-sm" name="col_labc_ex_b5" id="col_labc_ex_b5" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_ex_b5 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b5" id="fac_labc_ex_b5" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b5" id="total_labcs_ex_b5" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
	</div>
</div>
		
<?php
}
	
//b7 ex
if(isset($_GET['o_correction']))
{
	$b7_ex_prods=$prod->get_b7_ex_ordered_products($order['order_ID']);
}
else
{
	$b7_ex_prods=$prod->get_b7_ex_ordered_products($old_order['order_ID']);			
}

//$o_desc_ex_b7=$prod->get_o_desc_ex_b7($order['order_ID']);
$allstatus=$prod->showallstatus();
$osub_id=0;
$global_column_count=1;
if(count($b7_ex_prods)>0)
{
?>				
<!-- b7 exterior -->
<div class="row w-100 mx-0 <?php 
if($order['o_status']==8)
{
	echo "black";
}
?>" style="background-color:#e6ffe8;">
	
<?php	
	
	//for($k=0;$k<=$o_desc_ex_b7['col_amount_ex_b7'];$k++)
	//{
	?>
	<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
		<div class="row w-100 mx-0" style="margin-right:5px;margin-left:5px;">
		<?php
		for($l=0;$l<count($b7_ex_prods);$l++)
		{
			/*if($b7_ex_prods[$l]['osub_id']>$osub_id)
			{
			?>
			<!--</div>-->
			</div> <!-- row -->
			</div> <!-- col-md-4 -->
			<?php
			if($global_column_count % 3 ==0)
			{
			?>
			<div class="row"><div class="col-md-12">&nbsp;</div></div>
			<?php
			}
			$global_column_count++;
			?>
			<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
			<div class="row" style="margin-right:5px;margin-left:5px;">
			<?php
			}*/
			$product=$prod->get_product($b7_ex_prods[$l]['prod_id']);
			
			$product_price=$price->calculateProductPrice($b7_ex_prods[$l]['prod_id'],$cur_factor);
							
			$product_apu=$prod->calculateProductAPU($b7_ex_prods[$l]['prod_id']);
			$product_labc=$prod->calculateProductlabc($b7_ex_prods[$l]['prod_id']);
			
			$data['o_id']=$o_id;
			$data['osub_id']=$b7_ex_prods[$l]['osub_id'];
			$data['prod_id']=$b7_ex_prods[$l]['prod_id'];
			
			$new_prod_status=$prod->get_order_product(json_encode($data));
					
			//if($osub_id==$b7_ex_prods[$l]['osub_id'])
			//{
		?>		
		<div class="col-md-6" style="padding-left:3px;padding-right:3px;">
		<div style="border: 2px solid red;">
				<div class="<?php
			for($j=0;$j<count($allstatus);$j++)
			{
				if($order['o_status']>0)
				{					
					if($allstatus[$j]['ost_id']==$new_prod_status['p_status'])
					{
						echo $allstatus[$j]['ost_color'];
					}
				}
				else
				{
					if($allstatus[$j]['ost_id']==$b7_ex_prods[$l]['p_status'])
					{
						echo $allstatus[$j]['ost_color'];
					}
				}
			}
			?>" style="text-align:center;"><?php echo $order['om_id'].".".$b7_ex_prods[$l]['osub_id'].".".$b7_ex_prods[$l]['prod_id'].".".$o_id; ?> - <?php echo $product_price." ".$currency;?>
				</div>					
			<div class="row white w-100 mx-0" style="margin:0px;">
				<div class="col-md-6" style="padding:0px;">
					<div class="form-inline">
					<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_prods[$l]['osub_id']."_".$b7_ex_prods[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b7_ex_prods[$l]['osub_id'].".".$b7_ex_prods[$l]['prod_id'];?>" form="order_details" <?php
					if($order['o_status']>0)
					{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b7_ex_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b7_ex_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_correction']>0)
					{
						echo "checked";
					}
					}
					?>>
					<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_prods[$l]['osub_id']."_".$b7_ex_prods[$l]['prod_id'];?>">Correct</label>
					</div>
				</div>	
				<script type="text/javascript">
				$(document).ready(function(){
				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_prods[$l]['osub_id']."_".$b7_ex_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
				<div class="col-md-6" style="padding:0px;">
					<div class="form-inline">
					<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_prods[$l]['osub_id']."_".$b7_ex_prods[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b7" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b7_ex_prods[$l]['osub_id'].".".$b7_ex_prods[$l]['prod_id'];?>" form="order_details" <?php
					if($order['o_status']>0)
					{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b7_ex_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b7_ex_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_amendment']>0)
					{
						echo "checked";
					}
					}
					?>>
					<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_prods[$l]['osub_id']."_".$b7_ex_prods[$l]['prod_id'];?>">Amend</label>
					
					<input type="hidden" id="product_<?php echo $b7_ex_prods[$l]['prod_id'];?>_price" name="product_<?php echo $b7_ex_prods[$l]['prod_id'];?>_price" class="<?php 
				
					if($new_prod_status['om_amendment']==1)
					{
						echo "prices_ex_b7";
					}
				
				?>" value="<?php echo $product_price; ?>">
					<input type="hidden" id="product_<?php echo $b7_ex_prods[$l]['prod_id'];?>_apu" name="product_<?php echo $b7_ex_prods[$l]['prod_id'];?>_apu" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "apus_ex_b7";					
				}
				?>" value="<?php echo $product_apu; ?>">
					<input type="hidden" id="product_<?php echo $b7_ex_prods[$l]['prod_id'];?>_labc" name="product_<?php echo $b7_ex_prods[$l]['prod_id'];?>_labc" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "labcs_ex_b7";			
				}
				?>" value="<?php echo $product_labc; ?>"> 
					</div>
				</div>
				<script type="text/javascript">
				$(document).ready(function(){
				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_prods[$l]['osub_id']."_".$b7_ex_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
			</div>
		</div>		
		</div>
		<?php
			//}
		}
		?>
		
		</div>
	</div>
	<?php
	//}
	?>
</div> <!-- ex b7 row -->
<br>

<div class="row form-inline w-100 mx-0">
	<div class="col-md-12">
		<b>Trader-Purchaser: Col EX B7 = </b>
		<input class="form-control form-control-sm" type="text" name="col_price_ex_b7" id="col_price_ex_b7" value="" form="order_details" style="width:5em"> 
		<b><?php echo $currency; ?> X fac_client_ex_b7 = </b> 
		<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b7" id="fac_cl_ex_b7" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b>=</b> 
		<input type="text" class="form-control form-control-sm" name="o_price_ex_b7" id="o_price_ex_b7" value="" form="order_details" style="width:5em">
		<b><?php echo $currency; ?></b>			
		<br><br>
	</div>
</div>
<div class="row form-inline">
	<div class="col-md-12">
		<b>Producer-Trader: Col EX B7 = </b>
		<input type="text" class="form-control form-control-sm" name="col_apus_ex_b7" id="col_apus_ex_b7" value="" form="order_details" style="width:5em"> <b>APUs X fac_prod_ex_b7 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b7" id="fac_prod_ex_b7" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b7" id="o_apus_ex_b7" value="<?php echo $o_desc_in_b5['o_apus_in_b5'];?>" form="order_details" style="width:5em"> <b>APUs</b><br><br>
	</div>
</div>			
<div class="row form-inline">
	<div class="col-md-12">
		<b>Employee-Producer: Col EX B7 = </b>
		<input type="text" class="form-control form-control-sm" name="col_labc_ex_b7" id="col_labc_ex_b7" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_ex_b7 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b7" id="fac_labc_ex_b7" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b7" id="total_labcs_ex_b7" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
	</div>
</div>

<?php
}
?>
<div class="row w-100 mx-0 border py-4 border-bottom-0">
	<div class="col-md-6 border-right pl-4 text-center">
	    <b>Customer remarks : </b>
        <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php echo strip_tags($order['clients_extras_ex_b5']); ?></textarea>
	</div>		
	<div class="col-md-6 pl-4 text-center">
	    <b>Operator remarks : </b>
        <textarea name="op_remarks_ex_b5" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php echo strip_tags($order['op_remarks_ex_b5']); ?></textarea>
	</div>	
</div>
<br>
<?php
if(isset($_GET['o_correction']))
{
	$b3_in_prods=$prod->get_b3_in_ordered_products($order['order_ID']);
}
else
{
	$b3_in_prods=$prod->get_b3_in_ordered_products($old_order['order_ID']);
}

$allstatus=$prod->showallstatus();
$osub_id=1;
$global_column_count=1;

//print_r($b3_in_prods);

if(count($b3_in_prods)>0)
{
?>
<div class="row w-100 mx-0 py-2 <?php 
if($order['o_status']==8)
{
	echo "black";
}
else
{
	echo "light-grey";
}
?>">
<?php

//$o_desc_in_b3=$prod->get_o_desc_in_b3($order['order_ID']);

//r($k=1;$k<=$o_desc_in_b3['col_amount_in_b3'];$k++)
//{
?>
<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
	<div class="row w-100 mx-0" style="margin-right:5px;margin-left:5px;">
	<?php
	
	for($l=0;$l<count($b3_in_prods);$l++)
	{
		/*if($b3_in_prods[$l]['osub_id']>$osub_id)
		{
		?>
		</div>
		</div>
		<?php
		if($global_column_count % 3 ==0)
		{
		?>
		<div class="row"><div class="col-md-12">&nbsp;</div></div>
		<?php
		}
		$global_column_count++;
		?>
		<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
		<div class="row" style="margin-right:5px;margin-left:5px;">
		<?php
			$osub_id++;
		}*/
		$product=$prod->get_product($b3_in_prods[$l]['prod_id']);
		$product_price=$price->calculateProductPrice($b3_in_prods[$l]['prod_id'],$cur_factor);
							
		$product_apu=$prod->calculateProductAPU($b3_in_prods[$l]['prod_id']);
		$product_labc=$prod->calculateProductlabc($b3_in_prods[$l]['prod_id']);
		
		$data['o_id']=$o_id;
		$data['osub_id']=$b3_in_prods[$l]['osub_id'];
		$data['prod_id']=$b3_in_prods[$l]['prod_id'];
		
		$new_prod_status=$prod->get_order_product(json_encode($data));
				
		//if($osub_id==$b3_in_prods[$l]['osub_id'])
		//{
	?>		
	<div class="col-md-6" style="padding-left:3px;padding-right:3px;">
	<div style="border: 2px solid red;">
		<div class="<?php
		for($j=0;$j<count($allstatus);$j++)
		{
			if($order['o_status']>0)
			{				
				if($allstatus[$j]['ost_id']==$new_prod_status['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}
			}
			else
			{
				if($allstatus[$j]['ost_id']==$b3_in_prods[$l]['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}
			}
		}
		?>" style="text-align:center;"><?php echo $order['om_id'].".".$b3_in_prods[$l]['osub_id'].".".$b3_in_prods[$l]['prod_id'].".".$o_id; ?> - <?php echo $product_price." ".$currency;?>
		</div>
		<div class="row white" style="margin:0px;">
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b3_in_prods[$l]['osub_id'].".".$b3_in_prods[$l]['prod_id'];?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b3_in_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b3_in_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_correction']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>">Correct</label>
				</div>
			</div>	
			<script type="text/javascript">
				$(document).ready(function(){
				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b3" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b3_in_prods[$l]['osub_id'].".".$b3_in_prods[$l]['prod_id'];?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b3_in_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b3_in_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_amendment']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>">Amend</label>
				
				<input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_price" name="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_price" class="<?php 				
					if($new_prod_status['om_amendment']==1)
					{
						echo "prices_in_b3";
					}				
				?>" value="<?php echo $product_price; ?>">
					<input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_apu" name="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_apu" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "apus_in_b3";					
				}
				?>" value="<?php echo $product_apu; ?>">
					<input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_labc" name="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_labc" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "labcs_in_b3";			
				}
				?>" value="<?php echo $product_labc; ?>"> 
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
			</div>	
		</div>
	</div>															
	<?php
		//}
	}
	?>
	</div>
</div>
<?php
//}
?>
</div>	<!-- end b3 row -->

<br>

<div class="row form-inline">
	<div class="col-md-12">
		<b>Trader-Purchaser: Col IN B3 = </b>
		<input class="form-control form-control-sm" type="text" name="col_price_in_b3" id="col_price_in_b3" value="" form="order_details" style="width:5em"> 
		<b><?php echo $currency; ?> X fac_client_in_b3 = </b> 
		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b3" id="fac_cl_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_cl_in_b3']))?$o_desc_in_b3['fac_cl_in_b3']:"0.5" ;?>" form="order_details" style="width:5em"> 		
		<b>=</b> 
		<input type="text" class="form-control form-control-sm" name="o_price_in_b3" id="o_price_in_b3" value="" form="order_details" style="width:5em">
		<b><?php echo $currency; ?></b>			
		<br><br>
	</div>
</div>
<div class="row form-inline">
	<div class="col-md-12">
		<b>Producer-Trader: Col IN B3 = </b>
		<input type="text" class="form-control form-control-sm" name="col_apus_in_b3" id="col_apus_in_b3" value="" form="order_details" style="width:5em"> <b>APUs X fac_prod_in_b3 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b3" id="fac_prod_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_prod_in_b3']))?$o_desc_in_b3['fac_prod_in_b3']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b3" id="o_apus_in_b3" value="<?php echo $o_desc_in_b3['o_apus_in_b3'];?>" form="order_details" style="width:5em"> <b>APUs</b><br><br>
	</div>
</div>			
<div class="row form-inline">
	<div class="col-md-12">
		<b>Employee-Producer: Col IN B3 = </b>
		<input type="text" class="form-control form-control-sm" name="col_labc_in_b3" id="col_labc_in_b3" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b3 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b3" id="fac_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_labc_in_b3']))?$o_desc_in_b3['fac_labc_in_b3']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b3" id="total_labcs_in_b3" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
	</div>
</div>

<?php
}

//b5 in
if(isset($_GET['o_correction']))
{
	$b5_in_prods=$prod->get_b5_in_ordered_products($order['order_ID']);
}
else
{
	$b5_in_prods=$prod->get_b5_in_ordered_products($old_order['order_ID']);
}

$allstatus=$prod->showallstatus();
//$o_desc_in_b5=$prod->get_o_desc_in_b5($order['order_ID']);
$osub_id=1;
$global_column_count = 1;

if(count($b5_in_prods)>0)
{
?>
<div class="row w-100 mx-0 py-2 <?php 
if($order['o_status']==8)
{
	echo "black";
}
else
{
	echo "light-grey";
}
?>">
<?php
//for($k=1;$k<=$o_desc_in_b5['col_amount_in_b5'];$k++)
//{
?>
<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
	<div class="row" style="margin-right:5px;margin-left:5px;">
	<?php
	for($l=0;$l<count($b5_in_prods);$l++)
	{
		/*if($b5_in_prods[$l]['osub_id']>$osub_id)
		{
		?>
		</div>
		</div>
		<?php
		if($global_column_count % 3 ==0)
		{
		?>
		<div class="row"><div class="col-md-12">&nbsp;</div></div>
		<?php
		}
		$global_column_count++;
		?>
		<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
		<div class="row" style="margin-right:5px;margin-left:5px;">
		<?php
		$osub_id++;
		}*/
		$product=$prod->get_product($b5_in_prods[$l]['prod_id']);
		$product_price=$price->calculateProductPrice($b5_in_prods[$l]['prod_id'],$cur_factor);
							
		$product_apu=$prod->calculateProductAPU($b5_in_prods[$l]['prod_id']);
		$product_labc=$prod->calculateProductlabc($b5_in_prods[$l]['prod_id']);
		
		$data['o_id']=$o_id;
		$data['osub_id']=$b5_in_prods[$l]['osub_id'];
		$data['prod_id']=$b5_in_prods[$l]['prod_id'];
		
		$new_prod_status=$prod->get_order_product(json_encode($data));
		
		//if($osub_id==$b5_in_prods[$l]['osub_id'])
		//{
	?>		
	<div class="col-md-6" style="padding-left:3px;padding-right:3px;">
	<div style="border: 2px solid red;">
		<div class="<?php
		for($j=0;$j<count($allstatus);$j++)
		{
			if($order['o_status']>0)
			{				
				if($allstatus[$j]['ost_id']==$new_prod_status['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}
			}
			else
			{
				if($allstatus[$j]['ost_id']==$b5_in_prods[$l]['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}
			}
		}
		?>" style="text-align:center;"><?php echo $order['om_id'].".".$b5_in_prods[$l]['osub_id'].".".$b5_in_prods[$l]['prod_id'].".".$o_id; ?> - <?php echo $product_price." ".$currency;?>
		</div>
		<div class="row white" style="margin:0px;">
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_prods[$l]['osub_id']."_".$b5_in_prods[$l]['prod_id']; ?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b5_in_prods[$l]['osub_id'].".".$b5_in_prods[$l]['prod_id']; ?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b5_in_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b5_in_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_correction']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_prods[$l]['osub_id']."_".$b5_in_prods[$l]['prod_id']; ?>">Correct</label>
				</div>
			</div>	
			<script type="text/javascript">
				$(document).ready(function(){
				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_prods[$l]['osub_id']."_".$b5_in_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						}
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						}
						});
					}
				});
				});
				</script>
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_prods[$l]['osub_id']."_".$b5_in_prods[$l]['prod_id']; ?>" name="amendment[]" class="form-control form-control-sm product_in_b5" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b5_in_prods[$l]['osub_id'].".".$b5_in_prods[$l]['prod_id']; ?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b5_in_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b5_in_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_amendment']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_prods[$l]['osub_id']."_".$b5_in_prods[$l]['prod_id']; ?>">Amend</label>
				
				<input type="hidden" id="product_<?php echo $b5_in_prods[$l]['prod_id'];?>_price" name="product_<?php echo $b5_in_prods[$l]['prod_id'];?>_price" class="<?php 				
					if($new_prod_status['om_amendment']==1)
					{
						echo "prices_in_b5";
					}				
				?>" value="<?php echo $product_price; ?>">
					<input type="hidden" id="product_<?php echo $b5_in_prods[$l]['prod_id'];?>_apu" name="product_<?php echo $b5_in_prods[$l]['prod_id'];?>_apu" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "apus_in_b5";					
				}
				?>" value="<?php echo $product_apu; ?>">
					<input type="hidden" id="product_<?php echo $b5_in_prods[$l]['prod_id'];?>_labc" name="product_<?php echo $b5_in_prods[$l]['prod_id'];?>_labc" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "labcs_in_b5";			
				}
				?>" value="<?php echo $product_labc; ?>"> 
				
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_prods[$l]['osub_id']."_".$b5_in_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							//console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							//console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
			</div>	
		</div>
	</div>															
	<?php
		//}
	}
	?>
	</div>
</div>
<?php
//}
?>
</div> <!-- end b5 in row -->

<br>

<div class="row form-inline w-100 mx-0 text-center">
	<div class="col-md-12">
		<b>Trader-Purchaser: Col IN B5 = </b>
		<input class="form-control form-control-sm" type="text" name="col_price_in_b5" id="col_price_in_b5" value="" form="order_details" style="width:5em"> 
		<b><?php echo $currency; ?> X fac_client_in_b5 = </b> 
		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b5" id="fac_cl_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b>=</b> 
		<input type="text" class="form-control form-control-sm" name="o_price_in_b5" id="o_price_in_b5" value="" form="order_details" style="width:5em">
		<b><?php echo $currency; ?></b>			
		<br><br>
	</div>
</div>
<div class="row form-inline w-100 mx-0 text-center">
	<div class="col-md-12">
		<b>Producer-Trader: Col IN B5 = </b>
		<input type="text" class="form-control form-control-sm" name="col_apus_in_b5" id="col_apus_in_b5" value="" form="order_details" style="width:5em"> <b>APUs X fac_prod_in_b5 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b5" id="fac_prod_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b5" id="o_apus_in_b5" value="<?php echo $o_desc_in_b5['o_apus_in_b5'];?>" form="order_details" style="width:5em"> <b>APUs</b><br><br>
	</div>
</div>			
<div class="row form-inline w-100 mx-0 text-center">
	<div class="col-md-12">
		<b>Employee-Producer: Col IN B5 = </b>
		<input type="text" class="form-control form-control-sm" name="col_labc_in_b5" id="col_labc_in_b5" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b5 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b5" id="fac_labc_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b5" id="total_labcs_in_b5" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
	</div>
</div>

<?php
}

//b7 in
if(isset($_GET['o_correction']))
{
	$b7_in_prods=$prod->get_b7_in_ordered_products($order['order_ID']);
}
else
{
	$b7_in_prods=$prod->get_b7_in_ordered_products($old_order['order_ID']);
}
$allstatus=$prod->showallstatus();
//$o_desc_in_b7=$prod->get_o_desc_in_b7($order['order_ID']);
$osub_id=1;
$global_column_count=1;

if(count($b7_in_prods)>0)
{
?>
<div class="row w-100 mx-0 py-2 <?php 
if($order['o_status']==8)
{
	echo "black";
}
else
{
	echo "light-grey";
}
?>">
<?php
//for($k=1;$k<=$o_desc_in_b7['col_amount_in_b7'];$k++)
//{
?>
<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
	<div class="row" style="margin-right:5px;margin-left:5px;">
	<?php
	for($l=0;$l<count($b7_in_prods);$l++)
	{
		/*if($b7_in_prods[$l]['osub_id']>$osub_id)
		{
		?>
		</div>
		</div>
		<?php
		if($global_column_count % 3 ==0)
		{
		?>
		<div class="row"><div class="col-md-12">&nbsp;</div></div>
		<?php
		}
		$global_column_count++;
		?>
		<div class="col-md-4" style="padding-right:5px;padding-left:5px;font-size:12px;">
		<div class="row" style="margin-right:5px;margin-left:5px;">
		<?php
			$osub_id++;
		}*/
		$product=$prod->get_product($b7_in_prods[$l]['prod_id']);
		$product_price=$price->calculateProductPrice($b7_in_prods[$l]['prod_id'],$cur_factor);
							
		$product_apu=$prod->calculateProductAPU($b7_in_prods[$l]['prod_id']);
		$product_labc=$prod->calculateProductlabc($b7_in_prods[$l]['prod_id']);
		
		$o_prods_data['o_id']=$o_id;
		$o_prods_data['osub_id']=$b7_in_prods[$l]['osub_id'];
		$o_prods_data['prod_id']=$b7_in_prods[$l]['prod_id'];
		
		$new_o_prods_status=$prod->get_order_product(json_encode($o_prods_data));
				
		//if($osub_id==$b7_in_prods[$l]['osub_id'])
		//{
	?>		
	<div class="col-md-6" style="padding-left:3px;padding-right:3px;">
	<div style="border: 2px solid red;">
		<div class="<?php
		for($j=0;$j<count($allstatus);$j++)
		{
			if($order['o_status']>0)
			{					
				if($allstatus[$j]['ost_id']==$new_o_prods_status['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}

			}
			else
			{
				if($allstatus[$j]['ost_id']==$b7_in_prods[$l]['p_status'])
				{
					echo $allstatus[$j]['ost_color'];
				}
			}
		}
		?>" style="text-align:center;"><?php echo $order['om_id'].".".$b7_in_prods[$l]['osub_id'].".".$b7_in_prods[$l]['prod_id'].".".$o_id; ?> - <?php echo $product_price." ".$currency;?>
		</div>
		<div class="row white" style="margin:0px;">
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_prods[$l]['osub_id']."_".$b7_in_prods[$l]['prod_id']; ?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b7_in_prods[$l]['osub_id'].".".$b7_in_prods[$l]['prod_id']; ?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b7_in_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b7_in_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_correction']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_prods[$l]['osub_id']."_".$b7_in_prods[$l]['prod_id']; ?>">Correct</label>
				</div>
			</div>	
			<script type="text/javascript">
				$(document).ready(function(){
				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_prods[$l]['osub_id']."_".$b7_in_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
			<div class="col-md-6" style="padding:0px;">
				<div class="form-inline">
				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_prods[$l]['osub_id']."_".$b7_in_prods[$l]['prod_id']; ?>" name="amendment[]" class="form-control form-control-sm product_in_b7" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b7_in_prods[$l]['osub_id'].".".$b7_in_prods[$l]['prod_id']; ?>" form="order_details" <?php
				if($order['o_status']>0)
				{
					$o_prods_data['o_id']=$o_id;
					$o_prods_data['osub_id']=$b7_in_prods[$l]['osub_id'];
					$o_prods_data['prod_id']=$b7_in_prods[$l]['prod_id'];
					
					$o_prods=$prod->get_order_product(json_encode($o_prods_data));
					
					if($o_prods['om_amendment']>0)
					{
						echo "checked";
					}
				}
				?>>
				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_prods[$l]['osub_id']."_".$b7_in_prods[$l]['prod_id']; ?>">Amend</label>
				
				<input type="hidden" id="product_<?php echo $b7_in_prods[$l]['prod_id'];?>_price" name="product_<?php echo $b7_in_prods[$l]['prod_id'];?>_price" class="<?php 				
					if($new_prod_status['om_amendment']==1)
					{
						echo "prices_in_b7";
					}				
				?>" value="<?php echo $product_price; ?>">
					<input type="hidden" id="product_<?php echo $b7_in_prods[$l]['prod_id'];?>_apu" name="product_<?php echo $b7_in_prods[$l]['prod_id'];?>_apu" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "apus_in_b7";					
				}
				?>" value="<?php echo $product_apu; ?>">
					<input type="hidden" id="product_<?php echo $b7_in_prods[$l]['prod_id'];?>_labc" name="product_<?php echo $b7_in_prods[$l]['prod_id'];?>_labc" class="<?php 
				if($new_prod_status['om_amendment']==1)
				{
					echo "labcs_in_b7";			
				}
				?>" value="<?php echo $product_labc; ?>">
				
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_prods[$l]['osub_id']."_".$b7_in_prods[$l]['prod_id'];?>').click(function(){
					
					if($(this).is(":checked"))
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "create", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
					else
					{
						
						$.ajax({
						url: "../ajax/o_correction.php",
						method: "get",
						data: {method: "delete", product: $(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);								
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						});
					}
				});
				});
				</script>
			</div>	
		</div>
	</div>															
	<?php
		//}
	}
	?>
	</div>
</div>
<?php
//}
?>
</div> <!-- end b7 in row -->	

<br>

<div class="row form-inline">
	<div class="col-md-12">
		<b>Trader-Purchaser: Col IN B7 = </b>
		<input class="form-control form-control-sm" type="text" name="col_price_in_b7" id="col_price_in_b7" value="" form="order_details" style="width:5em"> 
		<b><?php echo $currency; ?> X fac_client_in_b7 = </b> 
		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b7" id="fac_cl_in_b7" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b>=</b> 
		<input type="text" class="form-control form-control-sm" name="o_price_in_b7" id="o_price_in_b7" value="" form="order_details" style="width:5em">
		<b><?php echo $currency; ?></b>			
		<br><br>
	</div>
</div>
<div class="row form-inline">
	<div class="col-md-12">
		<b>Producer-Trader: Col IN B7 = </b>
		<input type="text" class="form-control form-control-sm" name="col_apus_in_b7" id="col_apus_in_b7" value="" form="order_details" style="width:5em"> <b>APUs X fac_prod_in_b7 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b7" id="fac_prod_in_b7" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b7" id="o_apus_in_b7" value="<?php echo $o_desc_in_b5['o_apus_in_b5'];?>" form="order_details" style="width:5em"> <b>APUs</b><br><br>
	</div>
</div>			
<div class="row form-inline">
	<div class="col-md-12">
		<b>Employee-Producer: Col IN B7 = </b>
		<input type="text" class="form-control form-control-sm" name="col_labc_in_b7" id="col_labc_in_b7" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b7 = </b>
		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b7" id="fac_labc_in_b7" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"0.5" ;?>" form="order_details" style="width:5em"> 
		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b7" id="total_labcs_in_b7" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
	</div>
</div>

<?php
}
?>	

<br>
<div class="row w-100 mx-0 border py-4 border-bottom-0">
	<div class="col-md-6 border-right pl-4 text-center">
	    <b>Customer remarks : </b>
        <textarea name="customer_remarks" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php echo strip_tags($order['clients-extras']); ?></textarea>
	</div>		
	<div class="col-md-6 pl-4 text-center">
	    <b>Operator remarks : </b>
        <textarea name="op_remarks" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php echo strip_tags($order['op-remarks']); ?></textarea>
	</div>	
</div>	
<br>

<div class="totals py-2 border-top border-bottom border-dark" style="box-shadow: none;">
	<?php
	include('../../../domenia7.com/public_html/customer_files.php');
	?>
	<div class="row w-100 mx-0 text-center py-2">
		<div class="col-md-12 d-flex justify-content-center mb-2">
			<div class="form-inline">
				<b>Total price :</b> <input type="text" name="o_price" id="o_price" value="<?php echo $order['o_price'];?>" class="form-control form-control-sm mx-2" style="width:6em;">
				<b>	or Total special agreement price = </b> <input type="text" name="o_special_agreement_price" id="o_special_agreement_price" value="<?php echo $order['o_special_agreement_price'];?>" class="form-control form-control-sm mx-2" style="width:6em;">
			</div>
		</div>
	</div>
</div>
<br>			
<div class="row center_message w-100 mx-0">			
	<button name="save_btn" class="btn btn-primary btn-sm mx-auto" form="order_details">Save changes</button>								
</div>		

<br>
<script type="text/javascript" src="js/o_correction.js"></script>
</div> <!-- end div container -->			
<?php
	
}
else
{
	?>
	<div class="center_message">				
		<div class="error">You must be logged in to view this page !</div>
		<a href="../login.php" class="btn btn-danger btn-sm">Login</a>
		<br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=../login.php">
	<?php
}
?>
	</article>
</section>
<?php
include('../footer.php');
?>