<?php
session_start();
include('../functions.php');
include('../../../../superfloorplans.com/public_html/functions.php');
include('../../../../superfloorplans.com/public_html/price_calculations.php');
include('../../../../domenia7.com/public_html/domenia_db2.php');
include('../../../../cseven.eu/public_html/domenia/domenia.php');
include('../domenia3n_db.php');

$prod=new Production;
$price=new PriceCalculations;
$domenia2=new Domenia2;
$domenia3n=new Domenia3n;
$domenia=new Domenia;
include('../header2.php');
include('../menu.php');

?>
<section class="top_section">
	<article>
		<div class="container pagecontent px-0 bg-white">
            <p class="w-100 text-center display-4 pt-2">Acceptance - Contracting</p>
            <hr class="mb-4" width="450px">
            <div class="row w-100 mx-0 d-flex justify-content-center">
                <?php
                include('submenu.php');
                ?>
            </div>
		<div class="pt-3" style="font-size: 30px;">
            <p class="text-center text-primary w-100 mb-0">Acceptance of orders - Contracting </p>
        </div>
		<?php
if(isset($_COOKIE['client_id']))
{
	//if((isset($_GET['o_id']))||(isset($_GET['option'])))
	//{
//if(isset($_GET['o_extension']))
//{
	
	/*
	?>
	<div class="alert alert-warning">Working... Please wait...</div>
	<meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $new_order['order_ID'];?>">
	<?php */
//}


$option=$prod->xss_fix($_GET['option']);
				
if(isset($_GET['status']))
{
	$status=$prod->xss_fix($_GET['status']);
	$o_id=$prod->xss_fix($_GET['o_id']);
	if($status=="rejected")
	{
		$o_status=12;
		$prod->update_order_status($o_id,$o_status);
		?>
		<div class="center_message"><div class="error">Order rejected !</div></div>
		<meta http-equiv="refresh" content="1; url=index.php?orderstatus=10-12">
		<?php
	}
}	

if((isset($_POST['save_btn']))||(isset($_POST['accept_btn'])))
{

//create

$o_extension=$prod->xss_fix($_POST['o_extension']);

if(!empty($o_extension))
{	
//getting old order values

$old_order=$prod->get_order($o_extension);

$data['currentdatetime']=gmdate("Y-m-d H:i:s");
$data['ls_id']=$old_order['ls_id'];
$data['om_id']=$o_extension;
$data['order_name']=$old_order['order_name'];
$data['st_id']=$old_order['st_id'];
$data['lic_ID']=$old_order['lic_ID'];
$data['client_language_id']=$old_order['client_language_id'];
$data['mc_id']=$old_order['mc_id'];
$data['cur_id']=$old_order['cur_id'];
$data['u_client_ID']=$old_order['u_client_ID'];
$data['collection']=$old_order['collection'];
$data['u_prod_id']=$old_order['u_prod_id'];
$data['o_extension']=1;

$prod->create_order2(json_encode($data));

$new_order=$prod->show_last_order();

$old_o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_extension);
$old_o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_extension);
$old_o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_extension);
$old_o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_extension);

$old_o_desc_in_b3=$prod->get_o_desc_in_b3($o_extension);
$old_o_desc_in_b5=$prod->get_o_desc_in_b5($o_extension);
$old_o_desc_in_b6=$prod->get_o_desc_in_b6($o_extension);
$old_o_desc_in_b7=$prod->get_o_desc_in_b7($o_extension);
$old_o_desc_in_b8=$prod->get_o_desc_in_b8($o_extension);

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
if(count($old_o_desc_ex_b6)>0)
{
	$new_ex_b6_data['o_id']=$new_order['order_ID'];
	$new_ex_b6_data['rs_id']=$old_o_desc_ex_b6['rs_id'];
	$new_ex_b6_data['rmp_id']=$old_o_desc_ex_b6['rmp_id'];
	$new_ex_b6_data['r_tilt']=$old_o_desc_ex_b6['r_tilt'];
	$new_ex_b6_data['r_kneewall']=$old_o_desc_ex_b6['r_kneewall'];
	$new_ex_b6_data['rop_id']=$old_o_desc_ex_b6['rop_id'];
	$new_ex_b6_data['r_gutter_id']=$old_o_desc_ex_b6['r_gutter_id'];
	$new_ex_b6_data['e_length']=$old_o_desc_ex_b6['e_length'];
	$new_ex_b6_data['e_width']=$old_o_desc_ex_b6['e_width'];
	$new_ex_b6_data['wlc_id']=$old_o_desc_ex_b6['wlc_id'];		
	$new_ex_b6_data['ww_id']=$old_o_desc_ex_b6['ww_id'];
	$new_ex_b6_data['gc_id']=$old_o_desc_ex_b6['gc_id'];
	$new_ex_b6_data['gc_length']=$old_o_desc_ex_b6['gc_length'];
	$new_ex_b6_data['gc_width']=$old_o_desc_ex_b6['gc_width'];
	$new_ex_b6_data['gc_height']=$old_o_desc_ex_b6['gc_height'];
	$new_ex_b6_data['reelings_id']=$old_o_desc_ex_b6['reelings_id'];
	$new_ex_b6_data['wc_id']=$old_o_desc_ex_b6['wc_id'];
	$new_ex_b6_data['door_color']=$old_o_desc_ex_b6['door_color'];
	$new_ex_b6_data['door_texture']=$old_o_desc_ex_b6['door_texture'];
	$new_ex_b6_data['dsp_id']=$old_o_desc_ex_b6['dsp_id'];
	$new_ex_b6_data['pbp_id']=$old_o_desc_ex_b6['pbp_id'];
	$new_ex_b6_data['basement']=$old_o_desc_ex_b6['basement'];
	$new_ex_b6_data['levels_over_ground']=$old_o_desc_ex_b6['levels_over_ground'];
	
	$new_ex_b6_data['col_amount_ex_b6']=$old_o_desc_ex_b6['col_amount_ex_b6'];
	
	$prod->add_o_desc_ex_b6(json_encode($new_ex_b6_data));
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
if(count($old_o_desc_ex_b8)>0)
{
	$new_ex_b8_data['o_id']=$new_order['order_ID'];
	$new_ex_b8_data['rs_id']=$old_o_desc_ex_b8['rs_id'];
	$new_ex_b8_data['rmp_id']=$old_o_desc_ex_b8['rmp_id'];
	$new_ex_b8_data['r_tilt']=$old_o_desc_ex_b8['r_tilt'];
	$new_ex_b8_data['r_kneewall']=$old_o_desc_ex_b8['r_kneewall'];
	$new_ex_b8_data['rop_id']=$old_o_desc_ex_b8['rop_id'];
	$new_ex_b8_data['r_gutter_id']=$old_o_desc_ex_b8['r_gutter_id'];
	$new_ex_b8_data['e_length']=$old_o_desc_ex_b8['e_length'];
	$new_ex_b8_data['e_width']=$old_o_desc_ex_b8['e_width'];
	$new_ex_b8_data['wlc_id']=$old_o_desc_ex_b8['wlc_id'];		
	$new_ex_b8_data['ww_id']=$old_o_desc_ex_b8['ww_id'];
	$new_ex_b8_data['gc_id']=$old_o_desc_ex_b8['gc_id'];
	$new_ex_b8_data['gc_length']=$old_o_desc_ex_b8['gc_length'];
	$new_ex_b8_data['gc_width']=$old_o_desc_ex_b8['gc_width'];
	$new_ex_b8_data['gc_height']=$old_o_desc_ex_b8['gc_height'];
	$new_ex_b8_data['reelings_id']=$old_o_desc_ex_b8['reelings_id'];
	$new_ex_b8_data['wc_id']=$old_o_desc_ex_b8['wc_id'];
	$new_ex_b8_data['door_color']=$old_o_desc_ex_b8['door_color'];
	$new_ex_b8_data['door_texture']=$old_o_desc_ex_b8['door_texture'];
	$new_ex_b8_data['dsp_id']=$old_o_desc_ex_b8['dsp_id'];
	$new_ex_b8_data['pbp_id']=$old_o_desc_ex_b8['pbp_id'];
	$new_ex_b8_data['basement']=$old_o_desc_ex_b8['basement'];
	$new_ex_b8_data['levels_over_ground']=$old_o_desc_ex_b8['levels_over_ground'];
	
	$new_ex_b8_data['col_amount_ex_b8']=$old_o_desc_ex_b8['col_amount_ex_b8'];
	
	$prod->add_o_desc_ex_b8(json_encode($new_ex_b8_data));
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
if(count($old_o_desc_in_b6)>0)
{
	$new_in_b6_data['o_id']=$new_order['order_ID'];
	$new_in_b6_data['layout_id']=$old_o_desc_in_b6['layout_id'];
	$new_in_b6_data['window_id']=$old_o_desc_in_b6['window_id'];
	$new_in_b6_data['b6_col_amount']=$old_o_desc_in_b6['col_amount_in_b6'];
	
	$prod->add_o_desc_in_b6(json_encode($new_in_b6_data));
}
if(count($old_o_desc_in_b7)>0)
{
	$new_in_b7_data['o_id']=$new_order['order_ID'];
	$new_in_b7_data['layout_id']=$old_o_desc_in_b7['layout_id'];
	$new_in_b7_data['window_id']=$old_o_desc_in_b7['window_id'];
	$new_in_b7_data['col_amount_in_b7']=$old_o_desc_in_b7['col_amount_in_b7'];
	
	$prod->add_o_desc_in_b72(json_encode($new_in_b7_data));
}
if(count($old_o_desc_in_b8)>0)
{
	$new_in_b8_data['o_id']=$new_order['order_ID'];
	$new_in_b8_data['layout_id']=$old_o_desc_in_b8['layout_id'];
	$new_in_b8_data['window_id']=$old_o_desc_in_b8['window_id'];
	$new_in_b8_data['col_amount_in_b8']=$old_o_desc_in_b8['col_amount_in_b8'];
	
	$prod->add_o_desc_in_b8(json_encode($new_in_b8_data));
}	
}
//update 

if(!empty($o_extension))
{
	$update_data['o_id']=$new_order['order_ID'];
}	
else
{
	$update_data['o_id']=$prod->xss_fix($_POST['o_id']);
}
$order=$prod->get_order($update_data['o_id']);

$in_old_amount=$prod->xss_fix($_POST['in_old_amount']);
$ex_old_amount=$prod->xss_fix($_POST['ex_old_amount']);
//$clientid=$prod->xss_fix($_POST['clientid']);
//$licenceid=$prod->xss_fix($_POST['licenceid']);
//$o_extension=$prod->xss_fix($_POST['o_extension']);
$update_data['order_name']=$prod->xss_fix($_POST['order_name']);				
$update_data['collection']=$prod->xss_fix($_POST['collection']);
$update_data['u_prod_id']=$prod->xss_fix($_POST['producers']);					
$update_data['customer_remarks']=$prod->xss_fix($_POST['customer_remarks']);
$update_data['op_remarks']=$prod->xss_fix($_POST['op_remarks']);
$update_data['client_extras_ex_b5']=$prod->xss_fix($_POST['customer_remarks_ex_b5']);
$update_data['op_remarks_ex_b5']=$prod->xss_fix($_POST['op_remarks_ex_b5']);
$update_data['environment_address']=$prod->xss_fix($_POST['environment_address']);
$update_data['invoice_explanations']=$prod->xss_fix($_POST['invoice_explanations']);
$update_data['o_price']=$prod->xss_fix($_POST['total_price']);
$update_data['o_special_agreement_price']=$prod->xss_fix($_POST['total_special_agreement_price']);					
$update_data['vat_percent']=$prod->xss_fix($_POST['vat_percent']);
$update_data['vat_a_id']=$prod->xss_fix($_POST['vat_a_id']);
$update_data['vat_amount']=number_format(floor(($update_data['o_price'] * $update_data['vat_percent'] / 100)*100)/100,2, '.', '');
$update_data['brut_price']=number_format(floor(($update_data['o_price'] + $update_data['vat_amount'])*100)/100,2, '.', '');
$update_data['o_status']=1;
$update_data['st_id']=$prod->xss_fix($_POST['st_id0']);

//b3 in

$update_in_b3_data['o_id']=$update_data['o_id'];
$update_in_b3_data['sl_id']=$prod->xss_fix($_POST['sl_id']);
$update_in_b3_data['cls_id']=$prod->xss_fix($_POST['cls_id']);

$update_in_b3_data['col_amount_in_b3']=$prod->xss_fix($_POST['col_amount1_in_b3']);

$update_in_b3_data['col_price_in_b3']=$prod->xss_fix($_POST['col_price_in_b3']);
$update_in_b3_data['fac_cl_in_b3']=$prod->xss_fix($_POST['fac_cl_in_b3']);
$update_in_b3_data['o_price_in_b3']=$prod->xss_fix($_POST['o_price_in_b3']);
					
$update_in_b3_data['col_apus_in_b3']=$prod->xss_fix($_POST['col_apus_in_b3']);
$update_in_b3_data['fac_prod_in_b3']=$prod->xss_fix($_POST['fac_prod_in_b3']);
$update_in_b3_data['o_apus_in_b3']=$prod->xss_fix($_POST['o_apus_in_b3']);
					
$update_in_b3_data['col_labc_in_b3']=$prod->xss_fix($_POST['col_labc_in_b3']);
$update_in_b3_data['fac_labc_in_b3']=$prod->xss_fix($_POST['fac_labc_in_b3']);
$update_in_b3_data['total_labcs_in_b3']=$prod->xss_fix($_POST['total_labcs_in_b3']);

//b5 in

$update_in_b5_data['o_id']=$update_data['o_id'];
$selected_layoutline=$prod->xss_fix($_POST['b5_selected_layoutline']);
$b5_layout=explode(";",$selected_layoutline);

$b5_layoutline=$prod->get_layout_by_name($b5_layout[0],$b5_layout[2],$b5_layout[1]);

$update_in_b5_data['layout_id']=$b5_layoutline['id'];
$update_in_b5_data['window_id']=$b5_layoutline['window_id'];

$update_in_b5_data['col_amount_in_b5']=$prod->xss_fix($_POST['col_amount1_in_b5']);					

$update_in_b5_data['col_price_in_b5']=$prod->xss_fix($_POST['col_price_in_b5']);
$update_in_b5_data['fac_cl_in_b5']=$prod->xss_fix($_POST['fac_cl_in_b5']);
$update_in_b5_data['o_price_in_b5']=$prod->xss_fix($_POST['o_price_in_b5']);

$update_in_b5_data['col_apus_in_b5']=$prod->xss_fix($_POST['col_apus_in_b5']);
$update_in_b5_data['fac_prod_in_b5']=$prod->xss_fix($_POST['fac_prod_in_b5']);
$update_in_b5_data['o_apus_in_b5']=$prod->xss_fix($_POST['o_apus_in_b5']);

$update_in_b5_data['col_labc_in_b5']=$prod->xss_fix($_POST['col_labc_in_b5']);
$update_in_b5_data['fac_labc_in_b5']=$prod->xss_fix($_POST['fac_labc_in_b5']);
$update_in_b5_data['total_labcs_in_b5']=$prod->xss_fix($_POST['total_labcs_in_b5']);				

//b6 in

$update_in_b6_data['o_id']=$update_data['o_id'];
$selected_layoutline=$prod->xss_fix($_POST['b6_selected_layoutline']);
$b6_layout=explode(";",$selected_layoutline);

$b6_layoutline=$prod->get_layout_by_name($b6_layout[0],$b6_layout[2],$b6_layout[1]);

$update_in_b6_data['layout_id']=$b6_layoutline['id'];
$update_in_b6_data['window_id']=$b6_layoutline['window_id'];

$update_in_b6_data['col_amount_in_b6']=$prod->xss_fix($_POST['col_amount1_in_b6']);					

$update_in_b6_data['col_price_in_b6']=$prod->xss_fix($_POST['col_price_in_b6']);
$update_in_b6_data['fac_cl_in_b6']=$prod->xss_fix($_POST['fac_cl_in_b6']);
$update_in_b6_data['o_price_in_b6']=$prod->xss_fix($_POST['o_price_in_b6']);

$update_in_b6_data['col_apus_in_b6']=$prod->xss_fix($_POST['col_apus_in_b6']);
$update_in_b6_data['fac_prod_in_b6']=$prod->xss_fix($_POST['fac_prod_in_b6']);
$update_in_b6_data['o_apus_in_b6']=$prod->xss_fix($_POST['o_apus_in_b6']);

$update_in_b6_data['col_labc_in_b6']=$prod->xss_fix($_POST['col_labc_in_b6']);
$update_in_b6_data['fac_labc_in_b6']=$prod->xss_fix($_POST['fac_labc_in_b6']);
$update_in_b6_data['total_labcs_in_b6']=$prod->xss_fix($_POST['total_labcs_in_b6']);

//b7 in

$update_in_b7_data['o_id']=$update_data['o_id'];
$selected_layoutline=$prod->xss_fix($_POST['b7_selected_layoutline']);
$b7_layout=explode(";",$selected_layoutline);

$b7_layoutline=$prod->get_layout_by_name($b7_layout[0],$b7_layout[2],$b7_layout[1]);

$update_in_b7_data['layout_id']=$b7_layoutline['id'];
$update_in_b7_data['window_id']=$b7_layoutline['window_id'];

$update_in_b7_data['col_amount_in_b7']=$prod->xss_fix($_POST['col_amount1_in_b7']);

$update_in_b7_data['col_price_in_b7']=$prod->xss_fix($_POST['col_price_in_b7']);
$update_in_b7_data['fac_cl_in_b7']=$prod->xss_fix($_POST['fac_cl_in_b7']);
$update_in_b7_data['o_price_in_b7']=$prod->xss_fix($_POST['o_price_in_b7']);

$update_in_b7_data['col_apus_in_b7']=$prod->xss_fix($_POST['col_apus_in_b7']);
$update_in_b7_data['fac_prod_in_b7']=$prod->xss_fix($_POST['fac_prod_in_b7']);
$update_in_b7_data['o_apus_in_b7']=$prod->xss_fix($_POST['o_apus_in_b7']);

$update_in_b7_data['col_labc_in_b7']=$prod->xss_fix($_POST['col_labc_in_b7']);
$update_in_b7_data['fac_labc_in_b7']=$prod->xss_fix($_POST['fac_labc_in_b7']);
$update_in_b7_data['total_labcs_in_b7']=$prod->xss_fix($_POST['total_labcs_in_b7']);

//b8 in

$update_in_b8_data['o_id']=$update_data['o_id'];
$selected_layoutline=$prod->xss_fix($_POST['b8_selected_layoutline']);
$b8_layout=explode(";",$selected_layoutline);

$b8_layoutline=$prod->get_layout_by_name($b8_layout[0],$b8_layout[2],$b8_layout[1]);

$update_in_b8_data['layout_id']=$b8_layoutline['id'];
$update_in_b8_data['window_id']=$b8_layoutline['window_id'];

$update_in_b8_data['col_amount_in_b8']=$prod->xss_fix($_POST['col_amount1_in_b8']);

$update_in_b8_data['col_price_in_b8']=$prod->xss_fix($_POST['col_price_in_b8']);
$update_in_b8_data['fac_cl_in_b8']=$prod->xss_fix($_POST['fac_cl_in_b8']);
$update_in_b8_data['o_price_in_b8']=$prod->xss_fix($_POST['o_price_in_b8']);

$update_in_b8_data['col_apus_in_b8']=$prod->xss_fix($_POST['col_apus_in_b8']);
$update_in_b8_data['fac_prod_in_b8']=$prod->xss_fix($_POST['fac_prod_in_b8']);
$update_in_b8_data['o_apus_in_b8']=$prod->xss_fix($_POST['o_apus_in_b8']);

$update_in_b8_data['col_labc_in_b8']=$prod->xss_fix($_POST['col_labc_in_b8']);
$update_in_b8_data['fac_labc_in_b8']=$prod->xss_fix($_POST['fac_labc_in_b8']);
$update_in_b8_data['total_labcs_in_b8']=$prod->xss_fix($_POST['total_labcs_in_b8']);

//b5 ex

$update_ex_b5_data['o_id']=$update_data['o_id'];
$update_ex_b5_data['col_price_ex_b5']=$prod->xss_fix($_POST['col_price_ex_b5']);
$update_ex_b5_data['fac_cl_ex_b5']=$prod->xss_fix($_POST['fac_cl_ex_b5']);
$update_ex_b5_data['o_price_ex_b5']=$prod->xss_fix($_POST['o_price_ex_b5']);

$update_ex_b5_data['col_apus_ex_b5']=$prod->xss_fix($_POST['col_apus_ex_b5']);
$update_ex_b5_data['fac_prod_ex_b5']=$prod->xss_fix($_POST['fac_prod_ex_b5']);
$update_ex_b5_data['o_apus_ex_b5']=$prod->xss_fix($_POST['o_apus_ex_b5']);

$update_ex_b5_data['col_labc_ex_b5']=$prod->xss_fix($_POST['col_labc_ex_b5']);
$update_ex_b5_data['fac_labc_ex_b5']=$prod->xss_fix($_POST['fac_labc_ex_b5']);
$update_ex_b5_data['total_labcs_ex_b5']=$prod->xss_fix($_POST['total_labcs_ex_b5']);

$update_ex_b5_data['col_amount_ex_b5']=$prod->xss_fix($_POST['col_amount1_ex_b5']);

$update_ex_b5_data['levels_over_ground']=$prod->xss_fix($_POST['b5_levels_over_ground']);
		
//b6 ex

$update_ex_b6_data['o_id']=$update_data['o_id'];
$update_ex_b6_data['col_price_ex_b6']=$prod->xss_fix($_POST['col_price_ex_b6']);
$update_ex_b6_data['fac_cl_ex_b6']=$prod->xss_fix($_POST['fac_cl_ex_b6']);
$update_ex_b6_data['o_price_ex_b6']=$prod->xss_fix($_POST['o_price_ex_b6']);

$update_ex_b6_data['col_apus_ex_b6']=$prod->xss_fix($_POST['col_apus_ex_b6']);
$update_ex_b6_data['fac_prod_ex_b6']=$prod->xss_fix($_POST['fac_prod_ex_b6']);
$update_ex_b6_data['o_apus_ex_b6']=$prod->xss_fix($_POST['o_apus_ex_b6']);

$update_ex_b6_data['col_labc_ex_b6']=$prod->xss_fix($_POST['col_labc_ex_b6']);
$update_ex_b6_data['fac_labc_ex_b6']=$prod->xss_fix($_POST['fac_labc_ex_b6']);
$update_ex_b6_data['total_labcs_ex_b6']=$prod->xss_fix($_POST['total_labcs_ex_b6']);

$update_ex_b6_data['col_amount_ex_b6']=$prod->xss_fix($_POST['col_amount1_ex_b6']);

$update_ex_b6_data['levels_over_ground']=$prod->xss_fix($_POST['b6_levels_over_ground']);

//b7 ex

$update_ex_b7_data['o_id']=$update_data['o_id'];
$update_ex_b7_data['levels_over_ground']=$prod->xss_fix($_POST['b7_levels_over_ground']);

$update_ex_b7_data['col_price_ex_b7']=$prod->xss_fix($_POST['col_price_ex_b7']);
$update_ex_b7_data['fac_cl_ex_b7']=$prod->xss_fix($_POST['fac_cl_ex_b7']);
$update_ex_b7_data['o_price_ex_b7']=$prod->xss_fix($_POST['o_price_ex_b7']);

$update_ex_b7_data['col_apus_ex_b7']=$prod->xss_fix($_POST['col_apus_ex_b7']);
$update_ex_b7_data['fac_prod_ex_b7']=$prod->xss_fix($_POST['fac_prod_ex_b7']);
$update_ex_b7_data['o_apus_ex_b7']=$prod->xss_fix($_POST['o_apus_ex_b7']);

$update_ex_b7_data['col_labc_ex_b7']=$prod->xss_fix($_POST['col_labc_ex_b7']);
$update_ex_b7_data['fac_labc_ex_b7']=$prod->xss_fix($_POST['fac_labc_ex_b7']);
$update_ex_b7_data['total_labcs_ex_b7']=$prod->xss_fix($_POST['total_labcs_ex_b7']);

$update_ex_b7_data['col_amount_ex_b7']=$prod->xss_fix($_POST['col_amount1_ex_b7']);

//b8 ex

$update_ex_b8_data['o_id']=$update_data['o_id'];
$update_ex_b8_data['levels_over_ground']=$prod->xss_fix($_POST['b8_levels_over_ground']);

$update_ex_b8_data['col_price_ex_b8']=$prod->xss_fix($_POST['col_price_ex_b8']);
$update_ex_b8_data['fac_cl_ex_b8']=$prod->xss_fix($_POST['fac_cl_ex_b8']);
$update_ex_b8_data['o_price_ex_b8']=$prod->xss_fix($_POST['o_price_ex_b8']);

$update_ex_b8_data['col_apus_ex_b8']=$prod->xss_fix($_POST['col_apus_ex_b8']);
$update_ex_b8_data['fac_prod_ex_b8']=$prod->xss_fix($_POST['fac_prod_ex_b8']);
$update_ex_b8_data['o_apus_ex_b8']=$prod->xss_fix($_POST['o_apus_ex_b8']);

$update_ex_b8_data['col_labc_ex_b8']=$prod->xss_fix($_POST['col_labc_ex_b8']);
$update_ex_b8_data['fac_labc_ex_b8']=$prod->xss_fix($_POST['fac_labc_ex_b8']);
$update_ex_b8_data['total_labcs_ex_b8']=$prod->xss_fix($_POST['total_labcs_ex_b8']);

$update_ex_b8_data['col_amount_ex_b8']=$prod->xss_fix($_POST['col_amount1_ex_b8']);


if (strpos($update_data['collection'], 'p1501') === false) 
{	
	$update_in_b5_data['col_amount_in_b5']=0;
	$update_in_b5_data['fac_cl_in_b5']=0;
	$update_in_b5_data['layout_id']=0;
	$update_in_b5_data['window_id']=0;
}

if (strpos($update_data['collection'], 'p1301') === false) 
{	
	$update_in_b3_data['col_amount_in_b3']=0;
	$update_in_b3_data['col_price_in_b3']=0;
	$update_in_b3_data['fac_cl_in_b3']=0;
	$update_in_b3_data['o_price_in_b3']=0;
	$update_in_b3_data['col_apus_in_b3']=0;
	$update_in_b3_data['fac_prod_in_b3']=0;
	$update_in_b3_data['o_apus_in_b3']=0;
	$update_in_b3_data['col_labc_in_b3']=0;
	$update_in_b3_data['fac_labc_in_b3']=0;
	$update_in_b3_data['total_labcs_in_b3']=0;
	
}


$prod->update_order2(json_encode($update_data));

$prod->update_o_desc_in_b32(json_encode($update_in_b3_data));
$prod->update_o_desc_in_b52(json_encode($update_in_b5_data));
$prod->update_o_desc_in_b6(json_encode($update_in_b6_data));
$prod->update_o_desc_in_b72(json_encode($update_in_b7_data));
$prod->update_o_desc_in_b8(json_encode($update_in_b8_data));

$prod->update_o_desc_ex_b52(json_encode($update_ex_b5_data));
$prod->update_o_desc_ex_b6(json_encode($update_ex_b6_data));
$prod->update_o_desc_ex_b72(json_encode($update_ex_b7_data));
$prod->update_o_desc_ex_b8(json_encode($update_ex_b8_data));

$prod->update_o_desc_b0($update_data['o_id'],-$total_price);

$collection=explode(';',$update_data['collection']); 


if($update_in_b3_data['col_amount_in_b3']!=0)
{
	for($i=$in_old_amount+1;$i<=$in_old_amount+$update_in_b3_data['col_amount_in_b3'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1300)&&(substr($collection[$j],1)<1500))		
			{
				$b3_in_prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$b3_in_prod_data['osub_id']="n0".$i;
				}
				else
				{
					$b3_in_prod_data['osub_id']="n".$i;
				}
				$b3_in_prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($b3_in_prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b3_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b3_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b3_in_o_prods['osub_id']="n".$i;
					}
					$add_b3_in_o_prods['prod_id']=$collection[$j];
					$add_b3_in_o_prods['om_id']=$order['om_id'];
					$add_b3_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1301)
					{
						$add_b3_in_o_prods['p_status']=3;						
						$prod->add_order_products2(json_encode($add_b3_in_o_prods));
					}
					else
					{
						$add_b3_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b3_in_o_prods));
					}
				}
			}
		}
	}
}
else
{
	for($i=1;$i<=$in_old_amount;$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1300)&&(substr($collection[$j],1)<1500))		
			{
				$b3_in_prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$b3_in_prod_data['osub_id']="n0".$i;
				}
				else
				{
					$b3_in_prod_data['osub_id']="n".$i;
				}
				$b3_in_prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($b3_in_prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b3_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b3_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b3_in_o_prods['osub_id']="n".$i;
					}
					$add_b3_in_o_prods['prod_id']=$collection[$j];
					$add_b3_in_o_prods['om_id']=$order['om_id'];
					$add_b3_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1301)
					{
						$add_b3_in_o_prods['p_status']=3;						
						$prod->add_order_products2(json_encode($add_b3_in_o_prods));
					}
					else
					{
						$add_b3_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b3_in_o_prods));
					}
				}
			}
		}
	}
}

if($update_in_b5_data['col_amount_in_b5']!=0)
{	
	for($i=$in_old_amount+1;$i<=$in_old_amount+$update_in_b5_data['col_amount_in_b5'];$i++)
	{		
		for($j=0;$j<count($collection);$j++)
		{			
			if((substr($collection[$j],1)>1500)&&(substr($collection[$j],1)<1560))		
			{
				
				$b5_in_prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					
					$b5_in_prod_data['osub_id']="n0".$i;
				}
				else
				{
					$b5_in_prod_data['osub_id']="n".$i;
				}
				$b5_in_prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($b5_in_prod_data));
				//echo $b5_in_prod_data['o_id'].".".$b5_in_prod_data['osub_id'].".".$b5_in_prod_data['prod_id'].".".count($o_prod)."<br>";
				if(count($o_prod)==0)
				{
					$add_b5_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						
						$add_b5_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b5_in_o_prods['osub_id']="n".$i;
					}
					$add_b5_in_o_prods['prod_id']=$collection[$j];
					$add_b5_in_o_prods['om_id']=$order['om_id'];
					$add_b5_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1501)
					{
						$add_b5_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b5_in_o_prods));	
					}
					else
					{
						$add_b5_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b5_in_o_prods));
					}
				}
			}			
		}		
	}
}
else
{
	for($i=1;$i<=$in_old_amount;$i++)
	{		
		for($j=0;$j<count($collection);$j++)
		{			
			if((substr($collection[$j],1)>1500)&&(substr($collection[$j],1)<1560))		
			{
				
				$b5_in_prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					
					$b5_in_prod_data['osub_id']="n0".$i;
				}
				else
				{
					$b5_in_prod_data['osub_id']="n".$i;
				}
				$b5_in_prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($b5_in_prod_data));
				//echo $b5_in_prod_data['o_id'].".".$b5_in_prod_data['osub_id'].".".$b5_in_prod_data['prod_id'].".".count($o_prod)."<br>";
				if(count($o_prod)==0)
				{
					$add_b5_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						
						$add_b5_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b5_in_o_prods['osub_id']="n".$i;
					}
					$add_b5_in_o_prods['prod_id']=$collection[$j];
					$add_b5_in_o_prods['om_id']=$order['om_id'];
					$add_b5_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1501)
					{
						$add_b5_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b5_in_o_prods));	
					}
					else
					{
						$add_b5_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b5_in_o_prods));
					}
				}
			}			
		}		
	}
}

if($update_in_b6_data['col_amount_in_b6']!=0)
{	
	for($i=$in_old_amount+1;$i<=$in_old_amount+$update_in_b6_data['col_amount_in_b6'];$i++)
	{		
		for($j=0;$j<count($collection);$j++)
		{			
			if((substr($collection[$j],1)>1600)&&(substr($collection[$j],1)<1660))		
			{
				
				$b6_in_prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					
					$b6_in_prod_data['osub_id']="n0".$i;
				}
				else
				{
					$b6_in_prod_data['osub_id']="n".$i;
				}
				$b6_in_prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($b6_in_prod_data));
				//echo $b6_in_prod_data['o_id'].".".$b6_in_prod_data['osub_id'].".".$b6_in_prod_data['prod_id'].".".count($o_prod)."<br>";
				if(count($o_prod)==0)
				{
					$add_b6_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						
						$add_b6_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b6_in_o_prods['osub_id']="n".$i;
					}
					$add_b6_in_o_prods['prod_id']=$collection[$j];
					$add_b6_in_o_prods['om_id']=$order['om_id'];
					$add_b6_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1601)
					{
						$add_b6_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b6_in_o_prods));	
					}
					else
					{
						$add_b6_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b6_in_o_prods));
					}
				}
			}			
		}		
	}
}
else
{
	for($i=1;$i<=$in_old_amount;$i++)
	{		
		for($j=0;$j<count($collection);$j++)
		{			
			if((substr($collection[$j],1)>1600)&&(substr($collection[$j],1)<1660))		
			{
				
				$b6_in_prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					
					$b6_in_prod_data['osub_id']="n0".$i;
				}
				else
				{
					$b6_in_prod_data['osub_id']="n".$i;
				}
				$b6_in_prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($b6_in_prod_data));
				//echo $b6_in_prod_data['o_id'].".".$b6_in_prod_data['osub_id'].".".$b6_in_prod_data['prod_id'].".".count($o_prod)."<br>";
				if(count($o_prod)==0)
				{
					$add_b6_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						
						$add_b6_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b6_in_o_prods['osub_id']="n".$i;
					}
					$add_b6_in_o_prods['prod_id']=$collection[$j];
					$add_b6_in_o_prods['om_id']=$order['om_id'];
					$add_b6_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1601)
					{
						$add_b6_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b6_in_o_prods));	
					}
					else
					{
						$add_b6_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b6_in_o_prods));
					}
				}
			}			
		}		
	}
}

if($update_in_b7_data['col_amount_in_b7']!=0)
{
	for($i=$in_old_amount+1;$i<=$in_old_amount+$update_in_b7_data['col_amount_in_b7'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1700)&&(substr($collection[$j],1)<1760))		
			{
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b7_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b7_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b7_in_o_prods['osub_id']="n".$i;
					}
					$add_b7_in_o_prods['prod_id']=$collection[$j];
					$add_b7_in_o_prods['om_id']=$order['om_id'];
					$add_b7_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1701)
					{
						$add_b7_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b7_in_o_prods));
						$add_b7_in_o_prods['prod_id']="p1700";
						$prod->add_order_products2(json_encode($add_b7_in_o_prods));
					}
					else
					{
						$add_b7_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b7_in_o_prods));
					}
				}
			}
		}
	}
}
else
{
    for($i=1;$i<=$in_old_amount;$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1700)&&(substr($collection[$j],1)<1760))		
			{
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b7_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b7_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b7_in_o_prods['osub_id']="n".$i;
					}
					$add_b7_in_o_prods['prod_id']=$collection[$j];
					$add_b7_in_o_prods['om_id']=$order['om_id'];
					$add_b7_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1701)
					{
						$add_b7_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b7_in_o_prods));
						$add_b7_in_o_prods['prod_id']="p1700";
						$prod->add_order_products2(json_encode($add_b7_in_o_prods));
					}
					else
					{
						$add_b7_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b7_in_o_prods));
					}
				}
			}
		}
	}
}

if($update_in_b8_data['col_amount_in_b8']!=0)
{
	for($i=$in_old_amount+1;$i<=$in_old_amount+$update_in_b8_data['col_amount_in_b8'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1800)&&(substr($collection[$j],1)<1860))		
			{
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b8_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b8_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b8_in_o_prods['osub_id']="n".$i;
					}
					$add_b8_in_o_prods['prod_id']=$collection[$j];
					$add_b8_in_o_prods['om_id']=$order['om_id'];
					$add_b8_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1801)
					{
						$add_b8_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b8_in_o_prods));
						$add_b8_in_o_prods['prod_id']="p1800";
						$prod->add_order_products2(json_encode($add_b8_in_o_prods));
					}
					else
					{
						$add_b8_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b8_in_o_prods));
					}
				}
			}
		}
	}
}
else
{
    for($i=1;$i<=$in_old_amount;$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1800)&&(substr($collection[$j],1)<1860))		
			{
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b8_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b8_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b8_in_o_prods['osub_id']="n".$i;
					}
					$add_b8_in_o_prods['prod_id']=$collection[$j];
					$add_b8_in_o_prods['om_id']=$order['om_id'];
					$add_b8_in_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1801)
					{
						$add_b8_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b8_in_o_prods));
						$add_b8_in_o_prods['prod_id']="p1800";
						$prod->add_order_products2(json_encode($add_b8_in_o_prods));
					}
					else
					{
						$add_b8_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b8_in_o_prods));
					}
				}
			}
		}
	}
}

if($update_ex_b5_data['col_amount_ex_b5']!=0)
{
	for($i=$ex_old_amount+1;$i<=$ex_old_amount+$update_ex_b5_data['col_amount_ex_b5'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1560)&&(substr($collection[$j],1)<1700))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="x0".$i;
				}
				else
				{
					$prod_data['osub_id']="x".$i;
				}
				
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b5_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b5_ex_o_prods['osub_id']="x0".$i;
					}	
					else
					{
						$add_b5_ex_o_prods['osub_id']="x".$i;
					}
					$add_b5_ex_o_prods['prod_id']=$collection[$j];
					$add_b5_ex_o_prods['om_id']=$order['om_id'];
					$add_b5_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1561)
					{
						$add_b5_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b5_ex_o_prods));
					}
					else
					{
						$add_b5_ex_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b5_ex_o_prods));
					}
				}
			}
		}
	}
}
else
{
    for($i=1;$i<=$ex_old_amount;$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1560)&&(substr($collection[$j],1)<1700))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="x0".$i;
				}
				else
				{
					$prod_data['osub_id']="x".$i;
				}
				
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));
				
				if(count($o_prod)==0)
				{
					$add_b5_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b5_ex_o_prods['osub_id']="x0".$i;
					}	
					else
					{
						$add_b5_ex_o_prods['osub_id']="x".$i;
					}
					$add_b5_ex_o_prods['prod_id']=$collection[$j];
					$add_b5_ex_o_prods['om_id']=$order['om_id'];
					$add_b5_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1561)
					{
						$add_b5_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b5_ex_o_prods));
					}
					else
					{
						$add_b5_ex_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b5_ex_o_prods));
					}
				}
			}
		}
	}
}

if($update_ex_b6_data['col_amount_ex_b6']!=0)
{
	for($i=$ex_old_amount+1;$i<=$ex_old_amount+$update_ex_b6_data['col_amount_ex_b6'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1660)&&(substr($collection[$j],1)<1700))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));								
				
				if(count($o_prod)==0)
				{
					$add_b6_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b6_ex_o_prods['osub_id']="x0".$i;
					}
					else
					{
						$add_b6_ex_o_prods['osub_id']="x".$i;
					}
					$add_b6_ex_o_prods['prod_id']=$collection[$j];
					$add_b6_ex_o_prods['om_id']=$order['om_id'];
					$add_b6_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1661)
					{
						$add_b6_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b6_ex_o_prods));
						$add_b6_ex_o_prods['prod_id']="p1660";
						$prod->add_order_products2(json_encode($add_b6_ex_o_prods));
					}
					else
					{
						$prod->add_order_products2(json_encode($add_b6_ex_o_prods));
					}
				}
			}
		}
	}
}
else
{
    for($i=1;$i<=$ex_old_amount;$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1660)&&(substr($collection[$j],1)<1700))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));								
				
				if(count($o_prod)==0)
				{
					$add_b6_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b6_ex_o_prods['osub_id']="x0".$i;
					}
					else
					{
						$add_b6_ex_o_prods['osub_id']="x".$i;
					}
					$add_b6_ex_o_prods['prod_id']=$collection[$j];
					$add_b6_ex_o_prods['om_id']=$order['om_id'];
					$add_b6_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1661)
					{
						$add_b6_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b6_ex_o_prods));
						$add_b6_ex_o_prods['prod_id']="p1660";
						$prod->add_order_products2(json_encode($add_b6_ex_o_prods));
					}
					else
					{
						$prod->add_order_products2(json_encode($add_b6_ex_o_prods));
					}
				}
			}
		}
	}
}

if($update_ex_b7_data['col_amount_ex_b7']!=0)
{
	for($i=$ex_old_amount+1;$i<=$ex_old_amount+$update_ex_b7_data['col_amount_ex_b7'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1760)&&(substr($collection[$j],1)<1800))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));								
				
				if(count($o_prod)==0)
				{
					$add_b7_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b7_ex_o_prods['osub_id']="x0".$i;
					}
					else
					{
						$add_b7_ex_o_prods['osub_id']="x".$i;
					}
					$add_b7_ex_o_prods['prod_id']=$collection[$j];
					$add_b7_ex_o_prods['om_id']=$order['om_id'];
					$add_b7_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1761)
					{
						$add_b7_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b7_ex_o_prods));
						$add_b7_ex_o_prods['prod_id']="p1760";
						$prod->add_order_products2(json_encode($add_b7_ex_o_prods));
					}
					else
					{
						$prod->add_order_products2(json_encode($add_b7_ex_o_prods));
					}
				}
			}
		}
	}
}
else
{
    for($i=1;$i<=$ex_old_amount;$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1760)&&(substr($collection[$j],1)<1800))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));								
				
				if(count($o_prod)==0)
				{
					$add_b7_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b7_ex_o_prods['osub_id']="x0".$i;
					}
					else
					{
						$add_b7_ex_o_prods['osub_id']="x".$i;
					}
					$add_b7_ex_o_prods['prod_id']=$collection[$j];
					$add_b7_ex_o_prods['om_id']=$order['om_id'];
					$add_b7_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1761)
					{
						$add_b7_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b7_ex_o_prods));
						$add_b7_ex_o_prods['prod_id']="p1760";
						$prod->add_order_products2(json_encode($add_b7_ex_o_prods));
					}
					else
					{
						$prod->add_order_products2(json_encode($add_b7_ex_o_prods));
					}
				}
			}
		}
	}
}
		
if($update_ex_b8_data['col_amount_ex_b8']!=0)
{
	for($i=$ex_old_amount+1;$i<=$ex_old_amount+$update_ex_b8_data['col_amount_ex_b8'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1860)&&(substr($collection[$j],1)<1900))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));								
				
				if(count($o_prod)==0)
				{
					$add_b8_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b8_ex_o_prods['osub_id']="x0".$i;
					}
					else
					{
						$add_b8_ex_o_prods['osub_id']="x".$i;
					}
					$add_b8_ex_o_prods['prod_id']=$collection[$j];
					$add_b8_ex_o_prods['om_id']=$order['om_id'];
					$add_b8_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1861)
					{
						$add_b8_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b8_ex_o_prods));
						$add_b8_ex_o_prods['prod_id']="p1860";
						$prod->add_order_products2(json_encode($add_b8_ex_o_prods));
					}
					else
					{
						$prod->add_order_products2(json_encode($add_b8_ex_o_prods));
					}
				}
			}
		}
	}
}
else
{
    for($i=1;$i<=$ex_old_amount;$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1860)&&(substr($collection[$j],1)<1900))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="n0".$i;
				}
				else
				{
					$prod_data['osub_id']="n".$i;
				}
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));								
				
				if(count($o_prod)==0)
				{
					$add_b8_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b8_ex_o_prods['osub_id']="x0".$i;
					}
					else
					{
						$add_b8_ex_o_prods['osub_id']="x".$i;
					}
					$add_b8_ex_o_prods['prod_id']=$collection[$j];
					$add_b8_ex_o_prods['om_id']=$order['om_id'];
					$add_b8_ex_o_prods['om_extension']=1;
					
					if(substr($collection[$j],1)==1861)
					{
						$add_b8_ex_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b8_ex_o_prods));
						$add_b8_ex_o_prods['prod_id']="p1860";
						$prod->add_order_products2(json_encode($add_b8_ex_o_prods));
					}
					else
					{
						$prod->add_order_products2(json_encode($add_b8_ex_o_prods));
					}
				}
			}
		}
	}
}

if(isset($_POST['accept_btn']))
{			
	if($order['notifications']==1)
	{
	?>
	<meta http-equiv="refresh" content="1; url=confirmation1.php?o_id=<?php echo $o_id; ?>">
	<?php
	}
	else
	{
		?>						
		<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9">
		<?php
	}	
}
/*else
{
	?>						
	<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9">
	<?php
}*/				
?>
<div class="alert alert-warning">Processing... Please wait...</div>
<!-- <meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $update_data['o_id'];?>&status=accepted">  -->
<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9">
<?php
}

if(isset($_POST['notifications_btn']))
{
	$o_id=$prod->xss_fix($_POST['o_id']);
	$notifications=$prod->xss_fix($_POST['notifications']);
	
	if($notifications==1)
	{
		$notifications=0;
	}
	elseif($notifications==0)
	{
		$notifications=1;
	}
	
	$prod->update_o_notifications($o_id,$notifications);
		
	//$result_message="Notifications updated !";					
}
	
	
//page start
	
$o_extension=$prod->xss_fix($_GET['o_extension']);
	
$option=$prod->xss_fix($_GET['option']);

if(isset($_GET['o_extension']))
{
	$o_id=$o_extension;
}
else
{
	$o_id=$prod->xss_fix($_GET['o_id']);
}

$order=$prod->get_order($o_id);

$old_order=$prod->get_order($order['om_id']);

$clientid=$order['u_client_ID'];
$client=$prod->get_client($clientid);


$licid=$order['lic_ID'];

$licence=$prod->get_licence($licid);

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
<input type="hidden" name="clientid" value="<?php echo $clientid; ?>" form="order_details">
<input type="hidden" name="licenceid" value="<?php echo $licid; ?>" form="order_details">
<input type="hidden" name="o_extension" value="<?php echo $o_extension;?>" form="order_details">
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_COOKIE['client_id']; ?>" form="order_details">

<div class="row w-100 mx-0 border-top border-bottom">
    <div class="col-md-6 py-2 border-right">
        <b>Website = </b> <?php 
        $website=$prod->get_order_website($order['ls_id']);
        echo $website['ls_name'];?> <br>
                    
        <b>Order ID:</b> <a href="orderdetails.php?o_id=<?php echo $o_id; 
        if(isset($_GET['status']))
        {
            echo "&status=".$prod->xss_fix($_GET['status']);
        }?>" target="_blank"><?php echo $o_id; ?></a>  <?php 
        if($order['om_id']==0)
        {
            if(isset($_GET['status']))
            {
            ?>	
            <a href="o_extension.php?o_extension=<?php echo $o_id;
                
            ?>" class="btn btn-primary btn-sm" onclick="return confirm('This process will create a new Order ID !\n Are you sure you want to continue ?')">Add order extension</a>	
            
            <a href="o_correction.php?o_correction=<?php echo $o_id;
                
            ?>" class="btn btn-primary btn-sm" onclick="return confirm('This process will create a new Order ID !\n Are you sure you want to continue ?')">Add order correction/amendment</a>
            <?php
            }
        }
        else
        {
        ?>
            <b>Extension to:</b> <a href="orderdetails.php?o_id=<?php echo $order['om_id'];?>&status=accepted" target="_blank"><?php echo $order['om_id'];?></a>
        <?php
        }

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
            <b>Project name: </b>
            <input type="text" class="form-control form-control-sm ml-1" name="order_name" value="<?php echo $order['order_name']; ?>" style="width:250px;" form="order_details" required>
            <form id="update_notifications_form" class="d-inline ml-2" name="update_notifications_form" action="<?php echo $_SERVER['PHP_SELF'];?>?<?php 					
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
                ?>" method="post">
                    <input type="hidden" name="o_id" value="<?php echo $o_id;?>" form="update_notifications_form">
                    <input type="hidden" name="notifications" value="<?php echo $order['notifications'];?>" form="update_notifications_form">
                    <button class="btn btn-sm <?php echo ($order['notifications']==1)?"btn-default":"btn-danger";?>" type="submit" name="notifications_btn" form="update_notifications_form">Notifications <?php echo ($order['notifications']==1)?"are ON":"are OFF";?></button>
            </form>
        </div>	
        <br>
        <?php
        //checking if client used credits for this order
        $budget=$prod->get_o_desc_b0($order['order_ID']);

        if($order['payment_way']==9)
        {
                        
        if(count($budget)>0)
        {
            $total_budget=$prod->get_o_desc_b0_by_client($order['u_client_ID']);
            $total_client_credits=0;
            for($i=0;$i<count($total_budget);$i++)
            {
                $total_client_credits +=$total_budget[$i]['col_amount_b0'];
            }
        ?>
        <br>
        <div class="error">
        Used <?php echo (-1)*$budget['col_amount_b0'];?> credits for this order. Remaining credits = <?php echo $total_client_credits;?>
        </div>
        <?php
        }
        }
        ?>
        <br>	
    </div>
    
	<div class="col-md-6">
		<label for="allmessages">Comunications</label>
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
		<!-- <a href="orderdetails.php?o_id=<?php echo $o_id; ?>&clientid=<?php echo $clientid; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Reject</a> -->
		<?php
		}
		?>
	</div>
</div>				
    <p class="w-100 text-center pt-2">
        Customer ordered collections with these products:		
    </p>	
			
			<?php 
			$collection=explode(';',$order['collection']);		
			$old_collection=explode(';',$old_order['collection']);
			
			if($order['payment_way']==9)
			{
				$currency="CRD";
			}
			else
			{
				$currency=$prod->get_currency($licence['currencies'])['cur_short'];
			}
			
			$cur_factor=$licence['cur_fac'];
			
			if(strpos($order['collection'],'p1001')!==false)
			{
			?>
			<br>
			<div class="budget">
				<b>Amount of credits: <?php echo $budget['col_amount_b0'];?></b>
			</div>
			<?php
			}
			
			$o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_id);
			$o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_id);
			$o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_id);
			$o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_id);

			if(isset($_GET['o_extension']))
			{
				$old_o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_id);
				$old_o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_id);
				$old_o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_id);
				$old_o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_id);
			}
			else
			{
				$old_o_desc_ex_b5=$prod->get_o_desc_ex_b5($order['om_id']);
				$old_o_desc_ex_b6=$prod->get_o_desc_ex_b6($order['om_id']);
				$old_o_desc_ex_b7=$prod->get_o_desc_ex_b7($order['om_id']);
				$old_o_desc_ex_b8=$prod->get_o_desc_ex_b8($order['om_id']);
			}
				?>
				<br>
				<div class="interior" style="box-shadow: none;">
				
				<?php
				
				
				$lic_sites=$prod->get_lic_site($order['ls_id']);		
				
				
				$ls_prods=explode(';',$lic_sites['ls_prods']);
				
				$columns=3;
				$lines=ceil(count($ls_prods) / $columns)-1;
				
				
				$b3_in_products=array();
				$b3_ex_products=array();
				
				$b5_in_products=array();
				$b5_ex_products=array();
				
				$b6_in_products=array();
				$b6_ex_products=array();

				$b7_in_products=array();
				$b7_ex_products=array();
				
				$b8_in_products=array();
				$b8_ex_products=array();

				for($i=0;$i<count($ls_prods);$i++)
				{
					if((substr($ls_prods[$i],1)>1300)&&(substr($ls_prods[$i],1)<1360))
					{
						if(!empty($ls_prods[$i]))
						{
						$b3_in_products[]=$ls_prods[$i];
						}
					}
					
					if((substr($ls_prods[$i],1)>1360)&&(substr($ls_prods[$i],1)<1500))
					{
						if(!empty($ls_prods[$i]))
						{
						$b3_ex_products[]=$ls_prods[$i];
						}
					}
					
					if((substr($ls_prods[$i],1)>1500)&&(substr($ls_prods[$i],1)<1560))
					{
						if(!empty($ls_prods[$i]))
						{
						$b5_in_products[]=$ls_prods[$i];
						}
					}
					
					if((substr($ls_prods[$i],1)>1560)&&(substr($ls_prods[$i],1)<1600))
					{
						if(!empty($ls_prods[$i]))
						{
						$b5_ex_products[]=$ls_prods[$i];
						}
					}

					if((substr($ls_prods[$i],1)>1600)&&(substr($ls_prods[$i],1)<1660))
					{
						if(!empty($ls_prods[$i]))
						{
						$b6_in_products[]=$ls_prods[$i];
						}
					}

					if((substr($ls_prods[$i],1)>1660)&&(substr($ls_prods[$i],1)<1700))
					{
						if(!empty($ls_prods[$i]))
						{
						$b6_ex_products[]=$ls_prods[$i];
						}
					}

					
					
					if((substr($ls_prods[$i],1)>1700)&&(substr($ls_prods[$i],1)<1760))
					{
						if(!empty($ls_prods[$i]))
						{
						$b7_in_products[]=$ls_prods[$i];
						}
					}
					
					if((substr($ls_prods[$i],1)>1760)&&(substr($ls_prods[$i],1)<1800))
					{
						if(!empty($ls_prods[$i]))
						{
						$b7_ex_products[]=$ls_prods[$i];
						}
					}

					if((substr($ls_prods[$i],1)>1800)&&(substr($ls_prods[$i],1)<1860))
					{
						if(!empty($ls_prods[$i]))
						{
						$b8_in_products[]=$ls_prods[$i];
						}
					}
					
					if((substr($ls_prods[$i],1)>1860)&&(substr($ls_prods[$i],1)<1900))
					{
						if(!empty($ls_prods[$i]))
						{
						$b8_ex_products[]=$ls_prods[$i];
						}
					}

				}
				
				$interior=1;
				
				
					for($i=0;$i<count($collection);$i++)
					{
						if((count($b3_in_products)>0)||(count($b5_in_products)>0)||(count($b6_in_products)>0)||(count($b7_in_products)>0)||(count($b8_in_products)>0))
						{
							$interior++;
						}
					}
				
				if($interior>0)
				{
					$o_desc_in_b3=$prod->get_o_desc_in_b3($o_id);
					$o_desc_in_b5=$prod->get_o_desc_in_b5($o_id);
					$o_desc_in_b6=$prod->get_o_desc_in_b6($o_id);
					$o_desc_in_b7=$prod->get_o_desc_in_b7($o_id);
					$o_desc_in_b8=$prod->get_o_desc_in_b8($o_id);
					
					if(isset($_GET['o_extension']))
					{
						$old_o_desc_in_b3=$prod->get_o_desc_in_b3($o_id);
						$old_o_desc_in_b5=$prod->get_o_desc_in_b5($o_id);
						$old_o_desc_in_b6=$prod->get_o_desc_in_b6($o_id);
						$old_o_desc_in_b7=$prod->get_o_desc_in_b7($o_id);
						$old_o_desc_in_b8=$prod->get_o_desc_in_b8($o_id);
					}
					else
					{
						$old_o_desc_in_b3=$prod->get_o_desc_in_b3($order['om_id']);
						$old_o_desc_in_b5=$prod->get_o_desc_in_b5($order['om_id']);
						$old_o_desc_in_b6=$prod->get_o_desc_in_b6($order['om_id']);
						$old_o_desc_in_b7=$prod->get_o_desc_in_b7($order['om_id']);
						$old_o_desc_in_b8=$prod->get_o_desc_in_b8($order['om_id']);
					}
				?>
				<div class="row w-100 mx-0">
					<div class="col-md-12">
						<div class="error text-center w-100 text-success">
                            <h5 class="mb-0 pt-2 text-success">Interior</h5>
                            <hr width="300px" class="bg-dark">
                        </div>
					</div>
				</div>
				<br>
				<div class="row w-100 mx-0">
					<div class="col-md-6 d-flex justify-content-center">
						<div class="form-inline"><b class="mr-2">Amount of plans: <span style="color:red;"><?php 
						$amount=1;
							if(($old_o_desc_in_b3['col_amount_in_b3']==0)&&($old_o_desc_in_b5['col_amount_in_b5']==0)&&($old_o_desc_in_b7['col_amount_in_b7']==0))
							{
								echo "1";
							}
							else
							{
								if($old_o_desc_in_b3['col_amount_in_b3']>0)
								{
									echo $old_o_desc_in_b3['col_amount_in_b3'];
									$amount++;
								}
								if($amount==1)
								{
									if($old_o_desc_in_b5['col_amount_in_b5']>0)
									{
										echo $old_o_desc_in_b5['col_amount_in_b5'];
										$amount++;
									}
								}
								if($amount==1)
								{
									if($old_o_desc_in_b7['col_amount_in_b7']>0)
									{
										echo $old_o_desc_in_b7['col_amount_in_b7'];
										$amount++;
									}
								}
							}
						?></span> + </b>
						<input type="hidden" id="in_old_amount" name="in_old_amount" value="<?php
                        
						$amount=1;
						if(($old_o_desc_in_b3['col_amount_in_b3']==0)&&($old_o_desc_in_b5['col_amount_in_b5']==0)&&($old_o_desc_in_b7['col_amount_in_b7']==0))
						{
							echo "0";
						}
						else
						{
							if($old_o_desc_in_b3['col_amount_in_b3']>0)
							{
								echo $old_o_desc_in_b3['col_amount_in_b3'];
								$amount++;
							}
							if($amount==1)
							{
								if($old_o_desc_in_b5['col_amount_in_b5']>0)
								{
									echo $old_o_desc_in_b5['col_amount_in_b5'];
									$amount++;
								}
							}
							if($amount==1)
							{
								if($old_o_desc_in_b7['col_amount_in_b7']>0)
								{
									echo $old_o_desc_in_b7['col_amount_in_b7'];
									$amount++;
								}
							}
							}?>" form="order_details">
						<input type="text" class="form-control form-control-sm" name="col_amount0" id="col_amount0" form="order_details" value="<?php
                        echo "0";
						?>" style="width:5em" required>
						</div>
					</div>
					<div class="col-md-6 d-flex justify-content-center">
					<div class="form-inline">
					<b class="mr-2"><?php
					//Stairs:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1555","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1555","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1555","x-texts")['text'];
						echo $text;
					}?></b>
					<?php
					$stairs=$domenia3n->get_all_stairs();
					
					?>
					<select id ="st_id0" name="st_id0" class="form-control form-control-sm" <?php
					if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
						<option value="">None</option>
						<?php
						for($i=0;$i<count($stairs);$i++)
						{
						?>
						<option value="<?php echo $stairs[$i]['st_id'];?>" <?php echo ($order['st_id']==$stairs[$i]['st_id'])?"selected":"";?>><?php echo $stairs[$i]['st_name'];?></option>
						<?php							
						}
						?>
					</select>
					</div>
					</div>
				</div>
				
				<hr>
				<br>
				<?php
			if(count($b3_in_products)>0)
			{
					
					?>
					<div class="col-md-12">
					<div class="row w-100 mx-0">
					<?php
					$b3_in_lines=ceil(count($b3_in_products) / $columns);
					$counter=1;
					for($i=0;$i<count($b3_in_products);$i++)
					{
						if(!empty($b3_in_products[$i]))
						{
							$product=$prod->get_product($b3_in_products[$i]);
							if(count($budget)>0)
							{
								$product_price=$prod->calculateProductAPU($b3_in_products[$i]);
							}
							else
							{
								$product_price=$price->calculateProductPrice($b3_in_products[$i],$cur_factor);
							}
							$product_apu=$prod->calculateProductAPU($b3_in_products[$i]);
							$product_labc=$prod->calculateProductlabc($b3_in_products[$i]);
							
							if($counter==1)
							{
								?>
								<div class="col-md-4">
								<?php
							}
							?>
							<div class="row w-100 mx-0">					
								<div class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b3_in_products[$i]==$collection[$j])
									{
                                        if($order['om_id']==0)
                                        {
                                            echo "active_layout text-danger p-1 my-1";
                                        }
                                        else
                                        {
                                            echo "active_layout red_border p-1 my-1";
                                        }
									}
									
								}
								for($j=0;$j<count($old_collection);$j++)
								{
									if($b3_in_products[$i]==$old_collection[$j])
									{
										echo "active_layout text-danger p-1 my-1";
									}
									
									
								}	
								?>">
									<input class="products product_in_b3 checkbox" type="checkbox" name="<?php echo $b3_in_products[$i]; ?>" id="<?php echo $b3_in_products[$i]; ?>" value="<?php echo $b3_in_products[$i]; ?>" <?php 
									for($j=0;$j<count($collection);$j++)
									{
										if($b3_in_products[$i]==$collection[$j])
										{
                                            if($order['om_id']==0)
                                            {
                                                echo "checked disabled";
                                            }
                                            else
                                            {
                                                echo "checked";
                                            }
										}
									}							
									?>> 
									<label for="<?php echo $b3_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
									<input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_price" name="product_<?php echo $b3_in_products[$i];?>_price" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b3_in_products[$i]==$collection[$j])
									{
										echo "prices_in_b3";
									}
								}
								?>" value="<?php echo $product_price; ?>">
									<input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_apu" name="product_<?php echo $b3_in_products[$i];?>_apu" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b3_in_products[$i]==$collection[$j])
									{
										echo "apus_in_b3";
									}
								}
								?>" value="<?php echo $product_apu; ?>">
									<input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_labc" name="product_<?php echo $b3_in_products[$i];?>_labc" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b3_in_products[$i]==$collection[$j])
									{
										echo "labcs_in_b3";
									}
								}
								?>" value="<?php echo $product_labc; ?>"> 
								</div>						
							</div>	
							<?php
							if(($counter%$b3_in_lines==0)&&($counter>0))
							{
								?>
								</div> <!-- end col-md-4 -->
								<div class="col-md-4">
								<?php
							}
							$counter++;
						}
					}
					?>
					</div> <!-- end col-md-4 -->
					</div> <!-- end row -->
					<br>
					<div class="row w-100 mx-0">
						<div class="col-md-6">
							<b>Shapeline</b>
						</div>
						<div class="col-md-6">
							<b>Colorset</b>
						</div>
					</div>
					<div class="row w-100 mx-0">
						<div class="col-md-6">
							<select name="sl_id" id="sl_id" class="form-control form-control-sm" form="order_details" style="width:200px;">
								<option value="">None</option>
							<?php 
							$all_b3_shapes=$domenia3n->get_all_b3_shapes();
							
							for($i=0;$i<count($all_b3_shapes);$i++)
							{
							?>
							<option value="<?php echo $all_b3_shapes[$i]['sl_id'];?>" <?php echo ($all_b3_shapes[$i]['sl_id']==$o_desc_in_b3['sl_id'])?"selected":"";?>><?php echo $all_b3_shapes[$i]['sl_id']." - ".$all_b3_shapes[$i]['sl_name'];?></option>
							<?php
							}
							?>
							</select>
						</div>
						<div class="col-md-6">
							<select name="cls_id" id="cls_id" class="form-control form-control-sm" form="order_details" style="width:200px;">
								<option value="">None</option>
							<?php 
							
							$all_b3_colorset=$domenia3n->get_all_b3_colorsets();
							
							for($i=0;$i<count($all_b3_colorset);$i++)
							{
							?>
							<option value="<?php echo $all_b3_colorset[$i]['cls_id'];?>" <?php echo ($all_b3_colorset[$i]['cls_id']==$o_desc_in_b3['cls_id'])?"selected":"";?>><?php echo $all_b3_colorset[$i]['cls_id']." - ".$all_b3_colorset[$i]['cls_name'];?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					
					<br>
					<?php
					if(count($b3_in_products)>0)
					{
					?>
					<div class="row form-inline w-100 mx-0 text-center">
						<div class="col-md-12">
							<b>Employee-Producer: Col IN B3 = </b>
							<input type="text" class="form-control form-control-sm" name="col_labc_in_b3" id="col_labc_in_b3" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b3 = </b>
							<input type="text" class="form-control form-control-sm" name="fac_labc_in_b3" id="fac_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_labc_in_b3']))?$o_desc_in_b3['fac_labc_in_b3']:"1";?>" form="order_details" style="width:5em"> 
							<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b3['col_amount_in_b3']))?$old_o_desc_in_b3['col_amount_in_b3']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b3" id="col_amount3_in_b3" form="order_details" value="<?php echo /*(!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:*/"0";?>" style="width:5em" required>
							<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b3" id="total_labcs_in_b3" value="<?php echo $o_desc_in_b3['total_labcs_in_b3'];?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
						</div>
					</div>
					<div class="row form-inline w-100 mx-0 text-center">
						<div class="col-md-12">
							<b>Producer-Trader: Col IN B3 = </b>
							<input type="text" class="form-control form-control-sm" name="col_apus_in_b3" id="col_apus_in_b3" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b3 = </b>
							<input type="text" class="form-control form-control-sm" name="fac_prod_in_b3" id="fac_prod_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_prod_in_b3']))?$o_desc_in_b3['fac_prod_in_b3']:"1";?>" form="order_details" style="width:5em"> 
							<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b3['col_amount_in_b3']))?$old_o_desc_in_b3['col_amount_in_b3']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b3" id="col_amount2_in_b3" form="order_details" value="<?php echo /*(!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:*/"0";?>" style="width:5em" required>
							<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b3" id="o_apus_in_b3" value="<?php echo $o_desc_in_b3['o_apus_in_b3'];?>" form="order_details" style="width:5em"> <b>APUs</b><br><br>
						</div>
					</div>
					<div class="row form-inline w-100 mx-0 text-center">
						<div class="col-md-12">
							<b>Trader-Purchaser: Col IN B3 = </b>
							<input class="form-control form-control-sm" type="text" name="col_price_in_b3" id="col_price_in_b3" value="" form="order_details" style="width:5em"> 
							<b><?php echo $currency; ?> X fac_client_in_b3 = </b> 
							<input type="text" class="form-control form-control-sm" name="fac_cl_in_b3" id="fac_cl_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_cl_in_b3']))?$o_desc_in_b3['fac_cl_in_b3']:"1";?>" form="order_details" style="width:5em"> 
							<b> X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b3['col_amount_in_b3']))?$old_o_desc_in_b3['col_amount_in_b3']:"0";?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b3" id="col_amount1_in_b3" form="order_details" value="<?php echo /*(!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:*/"0";?>" style="width:5em" required> 
							<b>=</b> 
							<input type="text" class="form-control form-control-sm" name="o_price_in_b3" id="o_price_in_b3" value="<?php echo $o_desc_in_b3['o_price_in_b3'];?>" form="order_details" style="width:5em">
							<b><?php echo $currency; ?></b>			
							<br><br>
						</div>
					</div>					
					
					
					<br><br>
					<hr style="border:2px solid brown;">
					<br>
					<?php
					}			
					?>				
					<br>
					<?php	
			}

			if(count($b5_in_products)>0)
			{
				$layout_id=$o_desc_in_b5['layout_id'];
				$window_id=$o_desc_in_b5['window_id'];
				
				?>	
				
				<div class="col-md-12">
				<div class="row w-100 mx-0">
				<?php
				$b5_in_lines=ceil(count($b5_in_products) / $columns);
				$counter=1;
				for($i=0;$i<count($b5_in_products);$i++)
				{
					if(!empty($b5_in_products[$i]))
					{
						$product=$prod->get_product($b5_in_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b5_in_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b5_in_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b5_in_products[$i]);
						$product_labc=$prod->calculateProductlabc($b5_in_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row w-100 mx-0">					
							<div class="<?php 
							//echo $old_order['collection'];
							for($j=0;$j<count($collection);$j++)
							{							
								if($b5_in_products[$i]==$collection[$j])
								{
                                    if($order['om_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";									
                                    }
								}																				
							}	
							
							for($j=0;$j<count($old_collection);$j++)
							{							
								if($b5_in_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";									
								}																				
							}							
							?>">
								<input class="products product_in_b5 checkbox" type="checkbox" name="<?php echo $b5_in_products[$i]; ?>" id="<?php echo $b5_in_products[$i]; ?>" value="<?php echo $b5_in_products[$i]; ?>" <?php 
									
									for($j=0;$j<count($collection);$j++)
									{
										
										if($b5_in_products[$i]==$collection[$j])
										{
                                            if($order['om_id']==0)
                                            {
                                                echo "checked disabled";
                                            }
                                            else
                                            {
                                                echo "checked";
                                            }
											
										}
										
									}							
									?>> 
								<label for="<?php echo $b5_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_price" name="product_<?php echo $b5_in_products[$i];?>_price" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b5_in_products[$i]==$collection[$j])
									{
										echo "prices_in_b5";
										
									}
									
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_apu" name="product_<?php echo $b5_in_products[$i];?>_apu" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b5_in_products[$i]==$collection[$j])
									{
										echo "apus_in_b5";
										
									}
										
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_labc" name="product_<?php echo $b5_in_products[$i];?>_labc" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b5_in_products[$i]==$collection[$j])
									{
										echo "labcs_in_b5";
										
									}
										
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b5_in_lines==0)&&($counter>0))
						{
							?>
							</div> <!-- end col-md-4 -->
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div> <!-- end col-md-4 -->
				</div> <!-- end row -->
				<br>
				<a id="b5_layouts"></a>
				<div class="row w-100 mx-0">
					<div class="col-md-12 d-flex justify-content-center">
						<div class="nav nav-inline">
							<b>Layoutline: </b>
							<?php $layout=$prod->get_layout($layout_id,"b5",$window_id); 
									
							$layoutline=$prod->get_layouts_by_quality_id("b5");
							
							for($i=0;$i<count($layoutline);$i++)
							{
								?>
								<a href="#b5_layouts" class="nav-item <?php
								if(($layout_id==$layoutline[$i]['id'])&&($window_id==$layoutline[$i]['window_id']))
								{
									echo "active-layoutline";
								}
								?>" title="<?php echo $layoutline[$i]['layoutline_name'].";".$layoutline[$i]['window_id'].";b5;";?>">
									<div class="colorbox b5_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
									echo $window['window_color']; ?>;border: 10px solid <?php echo $layoutline[$i]['set_colors'];?>">
									</div>
								</a>					
								<?php							
							}
							?>
						</div>
						<input type="hidden" name="b5_selected_layoutline" value="<?php echo $layout['layoutline_name'].";".$layout['window_id'].";b5;";?>" form="order_details">
					</div>
				</div> <!-- end row -->
				<br>
				</div> <!-- end col-md-12 -->
				<?php
			}
			?>
			<br>
			<?php
			if(count($b5_in_products)>0)
			{
				?>
				<div class="row form-inline w-100 mx-0 text-center">
					<div class="row form-inline w-100 mx-0 text-center">
						<div class="col-md-12">
							<b>Employee-Producer: Col IN B5 = </b>
							<input type="text" class="form-control form-control-sm" name="col_labc_in_b5" id="col_labc_in_b5" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b5 = </b>
							<input type="text" class="form-control form-control-sm" name="fac_labc_in_b5" id="fac_labc_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"1";?>" form="order_details" style="width:5em"> 
							<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b5['col_amount_in_b5']))?$old_o_desc_in_b5['col_amount_in_b5']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b5" id="col_amount3_in_b5" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
							<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b5" id="total_labcs_in_b5" value="<?php echo $o_desc_in_b5['total_labcs_in_b5'];?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
						</div>
					</div>
					<div class="row form-inline w-100 mx-0 text-center">
						<div class="col-md-12">
							<b>Producer-Trader: Col IN B5 = </b>
							<input type="text" class="form-control form-control-sm" name="col_apus_in_b5" id="col_apus_in_b5" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b5 = </b>
							<input type="text" class="form-control form-control-sm" name="fac_prod_in_b5" id="fac_prod_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"1";?>" form="order_details" style="width:5em"> 
							<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b5['col_amount_in_b5']))?$old_o_desc_in_b5['col_amount_in_b5']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b5" id="col_amount2_in_b5" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
							<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b5" id="o_apus_in_b5" value="<?php echo $o_desc_in_b5['o_apus_in_b5'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
						</div>
					</div>
					<div class="col-md-12">
						<b>Trader-Purchaser: Col IN B5 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_in_b5" id="col_price_in_b5" value="" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_in_b5 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_in_b5" id="fac_cl_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"1";?>" form="order_details" style="width:5em"> 
						<b> X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b5['col_amount_in_b5']))?$old_o_desc_in_b5['col_amount_in_b5']:"0";?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b5" id="col_amount1_in_b5" form="order_details" value="<?php echo "0";?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_in_b5" id="o_price_in_b5" value="<?php echo $o_desc_in_b5['o_price_in_b5'];?>" form="order_details" style="width:5em">
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>

				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php	
			}

			if(count($b6_in_products)>0)
			{
				$layout_id=$o_desc_in_b6['layout_id'];
				$window_id=$o_desc_in_b6['window_id'];
				
				
				?>	
				
				<div class="col-md-12">
				<div class="row w-100 mx-0">
				<?php
				$b6_in_lines=ceil(count($b6_in_products) / $columns);
				$counter=1;
				for($i=0;$i<count($b6_in_products);$i++)
				{
					if(!empty($b6_in_products[$i]))
					{
						$product=$prod->get_product($b6_in_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b6_in_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b6_in_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b6_in_products[$i]);
						$product_labc=$prod->calculateProductlabc($b6_in_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row w-100 mx-0">					
							<div class="<?php 
							
							for($j=0;$j<count($collection);$j++)
							{							
								if($b6_in_products[$i]==$collection[$j])
								{
                                    if($order['om_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";									
                                    }
								}																				
							}	
							
							for($j=0;$j<count($old_collection);$j++)
							{							
								if($b6_in_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";									
								}																				
							}							
							?>">
								<input class="products product_in_b6 checkbox" type="checkbox" name="<?php echo $b6_in_products[$i]; ?>" id="<?php echo $b6_in_products[$i]; ?>" value="<?php echo $b6_in_products[$i]; ?>" <?php 
									
									for($j=0;$j<count($collection);$j++)
									{
										
										if($b6_in_products[$i]==$collection[$j])
										{
                                            if($order['om_id']==0)
                                            {
                                                echo "checked disabled";
                                            }
                                            else
                                            {
                                                echo "checked";
                                            }
											
										}
										
									}							
									?>> 
								<label for="<?php echo $b6_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_price" name="product_<?php echo $b6_in_products[$i];?>_price" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b6_in_products[$i]==$collection[$j])
									{
										echo "prices_in_b6";
										
									}
									
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_apu" name="product_<?php echo $b6_in_products[$i];?>_apu" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b6_in_products[$i]==$collection[$j])
									{
										echo "apus_in_b6";
										
									}
										
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_labc" name="product_<?php echo $b6_in_products[$i];?>_labc" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b6_in_products[$i]==$collection[$j])
									{
										echo "labcs_in_b6";
										
									}
										
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b6_in_lines==0)&&($counter>0))
						{
							?>
							</div> <!-- end col-md-4 -->
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div> <!-- end col-md-4 -->
				</div> <!-- end row -->
				<br>
				<a id="b6_layouts"></a>
				<div class="row w-100 mx-0">
					<div class="col-md-12 d-flex justify-content-center">
						<div class="nav nav-inline">
							<b>Layoutline: </b>
							<?php $layout=$prod->get_layout($layout_id,"b6",$window_id); 
									
							$layoutline=$prod->get_layouts_by_quality_id("b6");
							
							for($i=0;$i<count($layoutline);$i++)
							{
								?>
								<a href="#b6_layouts" class="nav-item <?php
								if(($layout_id==$layoutline[$i]['id'])&&($window_id==$layoutline[$i]['window_id']))
								{
									echo "active-layoutline";
								}
								?>" title="<?php echo $layoutline[$i]['layoutline_name'].";".$layoutline[$i]['window_id'].";b6;";?>">
									<div class="colorbox b6_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
									echo $window['window_color']; ?>;border: 10px solid <?php echo $layoutline[$i]['set_colors'];?>">
									</div>
								</a>					
								<?php							
							}
							?>
						</div>
						<input type="hidden" name="b6_selected_layoutline" value="<?php echo $layout['layoutline_name'].";".$layout['window_id'].";b6;";?>" form="order_details">
					</div>
				</div> <!-- end row -->
				<br>
				</div> <!-- end col-md-12 -->
				<?php
			}
			?>
			<br>
			<?php
			if(count($b6_in_products)>0)
			{
				?>
				<div class="row form-inline w-100 mx-0 text-center">
					<div class="col-md-12">
						<b>Employee-Producer: Col IN B6 = </b>
						<input type="text" class="form-control form-control-sm" name="col_labc_in_b6" id="col_labc_in_b6" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b6 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_labc_in_b6" id="fac_labc_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_labc_in_b6']))?$o_desc_in_b6['fac_labc_in_b6']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b6['col_amount_in_b6']))?$old_o_desc_in_b6['col_amount_in_b6']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b6" id="col_amount3_in_b6" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b6" id="total_labcs_in_b6" value="<?php echo $o_desc_in_b6['total_labcs_in_b6'];?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0 text-center">
					<div class="col-md-12">
						<b>Producer-Trader: Col IN B6 = </b>
						<input type="text" class="form-control form-control-sm" name="col_apus_in_b6" id="col_apus_in_b6" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b6 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_prod_in_b6" id="fac_prod_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_prod_in_b6']))?$o_desc_in_b6['fac_prod_in_b6']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b6['col_amount_in_b6']))?$old_o_desc_in_b6['col_amount_in_b6']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b6" id="col_amount2_in_b6" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b6" id="o_apus_in_b6" value="<?php echo $o_desc_in_b6['o_apus_in_b6'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0 text-center">
					<div class="col-md-12">
						<b>Trader-Purchaser: Col IN B6 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_in_b6" id="col_price_in_b6" value="" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_in_b6 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_in_b6" id="fac_cl_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_cl_in_b6']))?$o_desc_in_b6['fac_cl_in_b6']:"1";?>" form="order_details" style="width:5em"> 
						<b> X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b6['col_amount_in_b6']))?$old_o_desc_in_b6['col_amount_in_b6']:"0";?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b6" id="col_amount1_in_b6" form="order_details" value="<?php echo "0";?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_in_b6" id="o_price_in_b6" value="<?php echo $o_desc_in_b6['o_price_in_b6'];?>" form="order_details" style="width:5em">
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>			
				
				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php	
			}

			//start b7 in
			
			if(count($b7_in_products)>0)
			{
				$layout_id=$o_desc_in_b7['layout_id'];
				$window_id=$o_desc_in_b7['window_id'];
				?>	
				<div class="col-md-12">
				<div class="row w-100 mx-0">
				<?php
				$b7_in_lines=ceil(count($b7_in_products) / $columns);
				$counter=1;
				for($i=0;$i<count($b7_in_products);$i++)
				{
					if(!empty($b7_in_products[$i]))
					{
						$product=$prod->get_product($b7_in_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b7_in_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b7_in_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b7_in_products[$i]);
						$product_labc=$prod->calculateProductlabc($b7_in_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row">					
							<div class="<?php 
							
							for($j=0;$j<count($collection);$j++)
							{							
								if($b7_in_products[$i]==$collection[$j])
								{
                                    if($order['im_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";									
                                    }
								}								
							}	
							for($j=0;$j<count($old_collection);$j++)
							{								
								if($b7_in_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";									
								}								
							}
							?>">
								<input class="products product_in_b7 checkbox" type="checkbox" name="<?php echo $b7_in_products[$i]; ?>" id="<?php echo $b7_in_products[$i]; ?>" value="<?php echo $b7_in_products[$i]; ?>" <?php 
									
									for($j=0;$j<count($collection);$j++)
									{
										
										if($b7_in_products[$i]==$collection[$j])
										{
                                            if($order['om_id']==0)
                                            {
                                                echo "checked";
                                            }
                                            else
                                            {
                                                echo "checked disabled";										
                                            }
										}
										
									}							
									?>> 
								<label for="<?php echo $b7_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_price" name="product_<?php echo $b7_in_products[$i];?>_price" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b7_in_products[$i]==$collection[$j])
									{
										echo "prices_in_b7";
										
									}
									
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_apu" name="product_<?php echo $b7_in_products[$i];?>_apu" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b7_in_products[$i]==$collection[$j])
									{
										echo "apus_in_b7";
										
									}
										
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_labc" name="product_<?php echo $b7_in_products[$i];?>_labc" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b7_in_products[$i]==$collection[$j])
									{
										echo "labcs_in_b7";
										
									}
										
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b7_in_lines==0)&&($counter>0))
						{
							?>
							</div> <!-- end col-md-4 -->
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div> <!-- end col-md-4 -->
				</div> <!-- end row -->
				<br>
				<a id="b7_layouts"></a>
				<div class="row w-100 mx-0">
					<div class="col-md-12 d-flex justify-content-center">
						<div class="nav nav-inline">
							<b>Layoutline: </b>
							<?php $layout=$prod->get_layout($layout_id,"b7",$window_id); 
									
							$layoutline=$prod->get_layouts_by_quality_id("b7");
							
							for($i=0;$i<count($layoutline);$i++)
							{
								?>
								<a href="#b7_layouts" class="nav-item <?php
								if(($layout_id==$layoutline[$i]['id'])&&($window_id==$layoutline[$i]['window_id']))
								{
									echo "active-layoutline";
								}
								?>" title="<?php echo $layoutline[$i]['layoutline_name'].";".$layoutline[$i]['window_id'].";b7;";?>">
									<div class="colorbox b7_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
									echo $window['window_color']; ?>;border: 10px solid <?php echo $layoutline[$i]['set_colors'];?>">
									</div>
								</a>					
								<?php							
							}
							?>
						</div>
						<input type="hidden" name="b7_selected_layoutline" value="<?php echo $layout['layoutline_name'].";".$layout['window_id'].";b7;";?>" form="order_details">
					</div>
				</div> <!-- end row -->
				<br>
				</div> <!-- end col-md-12 -->
				<?php
			}
			?>
			<br>
			<?php
			if(count($b7_in_products)>0)
			{
				
				?>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Employee-Producer: Col IN B7 = </b>
						<input type="text" class="form-control form-control-sm" name="col_labc_in_b7" id="col_labc_in_b7" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b7 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_labc_in_b7" id="fac_labc_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_labc_in_b7']))?$o_desc_in_b7['fac_labc_in_b7']:"1" ;?>" form="order_details" style="width:5em"> 
						<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b7['col_amount_in_b7']))?$old_o_desc_in_b7['col_amount_in_b7']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b7" id="col_amount3_in_b7" form="order_details" value="<?php echo "0" ;?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b7" id="total_labcs_in_b7" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Producer-Trader: Col IN B7 = </b>
						<input type="text" class="form-control form-control-sm" name="col_apus_in_b7" id="col_apus_in_b7" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b7 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_prod_in_b7" id="fac_prod_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_prod_in_b7']))?$o_desc_in_b7['fac_prod_in_b7']:"1" ;?>" form="order_details" style="width:5em"> 
						<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b7['col_amount_in_b7']))?$old_o_desc_in_b7['col_amount_in_b7']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b7" id="col_amount2_in_b7" form="order_details" value="<?php echo "0" ;?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b7" id="o_apus_in_b7" value="<?php echo $o_desc_in_b7['o_apus_in_b7'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Trader-Purchaser: Col IN B7 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_in_b7" id="col_price_in_b7" value="" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_in_b7 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_in_b7" id="fac_cl_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_cl_in_b7']))?$o_desc_in_b7['fac_cl_in_b7']:"1" ;?>" form="order_details" style="width:5em"> 
						<b> X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b7['col_amount_in_b7']))?$old_o_desc_in_b7['col_amount_in_b7']:"0";?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b7" id="col_amount1_in_b7" form="order_details" value="<?php echo "0"; ?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_in_b7" id="o_price_in_b7" value="" form="order_details" style="width:5em">
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>
							
				
				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php
			}

			if(count($b8_in_products)>0)
			{
				$layout_id=$o_desc_in_b8['layout_id'];
				$window_id=$o_desc_in_b8['window_id'];
				?>	
				<div class="col-md-12">
				<div class="row w-100 mx-0">
				<?php
				$b8_in_lines=ceil(count($b8_in_products) / $columns);
				$counter=1;
				for($i=0;$i<count($b8_in_products);$i++)
				{
					if(!empty($b8_in_products[$i]))
					{
						$product=$prod->get_product($b8_in_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b8_in_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b8_in_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b8_in_products[$i]);
						$product_labc=$prod->calculateProductlabc($b8_in_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row">					
							<div class="<?php 
							
							for($j=0;$j<count($collection);$j++)
							{							
								if($b8_in_products[$i]==$collection[$j])
								{
                                    if($order['im_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";									
                                    }
								}								
							}	
							for($j=0;$j<count($old_collection);$j++)
							{								
								if($b8_in_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";									
								}								
							}
							?>">
								<input class="products product_in_b8 checkbox" type="checkbox" name="<?php echo $b8_in_products[$i]; ?>" id="<?php echo $b8_in_products[$i]; ?>" value="<?php echo $b8_in_products[$i]; ?>" <?php 
									
									for($j=0;$j<count($collection);$j++)
									{
										
										if($b8_in_products[$i]==$collection[$j])
										{
                                            if($order['om_id']==0)
                                            {
                                                echo "checked";
                                            }
                                            else
                                            {
                                                echo "checked disabled";										
                                            }
										}
										
									}							
									?>> 
								<label for="<?php echo $b8_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_price" name="product_<?php echo $b8_in_products[$i];?>_price" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b8_in_products[$i]==$collection[$j])
									{
										echo "prices_in_b8";
										
									}
									
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_apu" name="product_<?php echo $b8_in_products[$i];?>_apu" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b8_in_products[$i]==$collection[$j])
									{
										echo "apus_in_b8";
										
									}
										
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_labc" name="product_<?php echo $b8_in_products[$i];?>_labc" class="<?php 
								
								for($j=0;$j<count($collection);$j++)
								{
									
									if($b8_in_products[$i]==$collection[$j])
									{
										echo "labcs_in_b8";
										
									}
										
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b8_in_lines==0)&&($counter>0))
						{
							?>
							</div> <!-- end col-md-4 -->
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div> <!-- end col-md-4 -->
				</div> <!-- end row -->
				<br>
				<a id="b8_layouts"></a>
				<div class="row w-100 mx-0">
					<div class="col-md-12 d-flex justify-content-center">
						<div class="nav nav-inline">
							<b>Layoutline: </b>
							<?php $layout=$prod->get_layout($layout_id,"b8",$window_id); 
									
							$layoutline=$prod->get_layouts_by_quality_id("b8");
							
							for($i=0;$i<count($layoutline);$i++)
							{
								?>
								<a href="#b8_layouts" class="nav-item <?php
								if(($layout_id==$layoutline[$i]['id'])&&($window_id==$layoutline[$i]['window_id']))
								{
									echo "active-layoutline";
								}
								?>" title="<?php echo $layoutline[$i]['layoutline_name'].";".$layoutline[$i]['window_id'].";b8;";?>">
									<div class="colorbox b8_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
									echo $window['window_color']; ?>;border: 10px solid <?php echo $layoutline[$i]['set_colors'];?>">
									</div>
								</a>					
								<?php							
							}
							?>
						</div>
						<input type="hidden" name="b8_selected_layoutline" value="<?php echo $layout['layoutline_name'].";".$layout['window_id'].";b8;";?>" form="order_details">
					</div>
				</div> <!-- end row -->
				<br>
				</div> <!-- end col-md-12 -->
				<?php
			}
			?>			
			<br>	
			<?php
			if(count($b8_in_products)>0)
			{				
				?>
				<div class="row form-inline w-100 mx-0 text-center">
					<div class="col-md-12">
						<b>Employee-Producer: Col IN B8 = </b>
						<input type="text" class="form-control form-control-sm" name="col_labc_in_b8" id="col_labc_in_b8" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b8 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_labc_in_b8" id="fac_labc_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_labc_in_b8']))?$o_desc_in_b8['fac_labc_in_b8']:"1" ;?>" form="order_details" style="width:5em"> 
						<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b8['col_amount_in_b8']))?$old_o_desc_in_b8['col_amount_in_b8']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b8" id="col_amount3_in_b8" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b8" id="total_labcs_in_b8" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0 text-center">
					<div class="col-md-12">
						<b>Producer-Trader: Col IN B8 = </b>
						<input type="text" class="form-control form-control-sm" name="col_apus_in_b8" id="col_apus_in_b8" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b8 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_prod_in_b8" id="fac_prod_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_prod_in_b8']))?$o_desc_in_b8['fac_prod_in_b8']:"1" ;?>" form="order_details" style="width:5em"> 
						<b>X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b8['col_amount_in_b8']))?$old_o_desc_in_b8['col_amount_in_b8']:"0";?></span> + </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b8" id="col_amount2_in_b8" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b8" id="o_apus_in_b8" value="<?php echo $o_desc_in_b8['o_apus_in_b8'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0 text-center">
					<div class="col-md-12">
						<b>Trader-Purchaser: Col IN B8 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_in_b8" id="col_price_in_b8" value="" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_in_b8 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_in_b8" id="fac_cl_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_cl_in_b8']))?$o_desc_in_b8['fac_cl_in_b8']:"1" ;?>" form="order_details" style="width:5em"> 
						<b> X Amount of plans: <span style="color:red"><?php echo (!empty($old_o_desc_in_b8['col_amount_in_b8']))?$old_o_desc_in_b8['col_amount_in_b8']:"0";?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b8" id="col_amount1_in_b8" form="order_details" value="<?php echo "0";?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_in_b8" id="o_price_in_b8" value="" form="order_details" style="width:5em">
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>
							
				
				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php
			}
			?>
			<div class="row w-100 mx-0">
				<div class="col-md-6 text-center">
					<b>Customer remarks interior : </b>
                    <textarea name="customer_remarks" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php echo strip_tags($order['clients-extras']); ?></textarea>
				</div>		
				<div class="col-md-6 text-center">
					<b>Operator remarks interior: </b>
                    <textarea name="op_remarks" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php echo strip_tags($order['op-remarks']); ?></textarea>
				</div>	
			</div>
			
			<?php
			}
			else
			{
			?>
			<div class="row w-100 mx-0 text-center">
				<div class="col-md-12">						
					<div class="error">No Interior</div>						
				</div>
			</div>
			<?php
			}
				
			?>
				<br>
			</div> <!-- end interrior -->	
			
			
			<div class="exterior" style="box-shadow: none;">
			<input type="hidden" id="option" name="option" value="<?php echo $prod->xss_fix($_GET['option']);?>">
			<?php
			$exterior=0;
			
			
			if((count($o_desc_ex_b5)>0)||(count($o_desc_ex_b7)>0))
			{
				$exterior++;
			}
			
			if($exterior>0)
			{
			?>				
			<div class="row w-100 mx-0">
				<div class="col-md-12">
                    <h5 class="mb-0 pt-2 text-success text-center">Exterior</h5>
                    <hr width="300px" class="bg-dark">
				</div>
			</div>
			<a id="exterior"></a>
			<div class="center_message"> <div class="success"><?php echo (!empty($result_message))?$result_message:"";?></div></div>
			<br>
			<?php
			include('../../../domenia7.com/public_html/short_order_description.php');
			?>
			<br>
			<div class="col-md-12">
			<?php			
			
			//start b5 ex 
			
			if(count($b5_ex_products)>0)
			{
				?>
				<div class="row w-100 mx-0">
				<?php
				$b5_ex_columns=2;
				$b5_ex_lines=ceil(count($b5_ex_products) / $b5_ex_columns);
				$counter=1;
				for($i=0;$i<count($b5_ex_products);$i++)
				{
					if(!empty($b5_ex_products[$i]))
					{
						$product=$prod->get_product($b5_ex_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b5_ex_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b5_ex_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b5_ex_products[$i]);
						$product_labc=$prod->calculateProductlabc($b5_ex_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row">					
							<div class="<?php 
							for($j=0;$j<count($collection);$j++)
							{
								if($b5_ex_products[$i]==$collection[$j])
								{
                                    if($order['om_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";
                                    }
								}
							}
							
							for($j=0;$j<count($old_collection);$j++)
							{
								if($b5_ex_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";
								}
							}
							?>">
								<input class="products product_ex_b5 checkbox" type="checkbox" name="<?php echo $b5_ex_products[$i]; ?>" id="<?php echo $b5_ex_products[$i]; ?>" value="<?php echo $b5_ex_products[$i]; ?>" <?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b5_ex_products[$i]==$collection[$j])
									{
                                        if($order['om_id']==0)
                                        {
                                            echo "checked disabled";
                                        }
                                        else
                                        {
                                            echo "checked";
                                        }
									}
								}
								?>> 
								<label for="<?php echo $b5_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_price" name="product_<?php echo $b5_ex_products[$i];?>_price" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b5_ex_products[$i]==$collection[$j])
									{
										echo "prices_ex_b5";
									}
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_apu" name="product_<?php echo $b5_ex_products[$i];?>_apu" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b5_ex_products[$i]==$collection[$j])
									{
										echo "apus_ex_b5";
									}
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_labc" name="product_<?php echo $b5_ex_products[$i];?>_labc" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b5_ex_products[$i]==$collection[$j])
									{
										echo "labcs_ex_b5";
									}
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b5_ex_lines==0)&&($counter>0))
						{
							?>
							</div>
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div>
				</div>
				<br>
				<?php
			}
		
			if(count($b5_ex_products)>0)
			{
				?>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Employee-Producer: Col EX B5 = </b>
						<input type="text" class="form-control form-control-sm" name="col_labc_ex_b5" id="col_labc_ex_b5" value="<?php echo $o_desc_ex_b5['col_labc_ex_b5'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b5 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b5" id="fac_labc_ex_b5" value="<?php echo ($o_desc_ex_b5['fac_labc_ex_b5']!=0)?$o_desc_ex_b5['fac_labc_ex_b5']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b5['col_amount_ex_b5'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount3_ex_b5" id="col_amount3_ex_b5" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b5" id="total_labcs_ex_b5" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Producer-Trader: Col EX B5 = </b>
						<input type="text" class="form-control form-control-sm" name="col_apus_ex_b5" id="col_apus_ex_b5" value="<?php echo $o_desc_ex_b5['col_apus_ex_b5'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b5 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b5" id="fac_prod_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['fac_prod_ex_b5']))?$o_desc_ex_b5['fac_prod_ex_b5']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b5['col_amount_ex_b5'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount2_ex_b5" id="col_amount2_ex_b5" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b5" id="o_apus_ex_b5" value="<?php echo $o_desc_ex_b5['o_apus_ex_b5'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Trader-Purchaser: Col EX B5 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_ex_b5" id="col_price_ex_b5" value="<?php echo $o_desc_ex_b5['col_price_ex_b5']; ?>" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_ex_b5 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b5" id="fac_cl_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['fac_cl_ex_b5']))?$o_desc_ex_b5['fac_cl_ex_b5']:"1";?>" form="order_details" style="width:5em"> 
						<b> X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b5['col_amount_ex_b5'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b5" id="col_amount1_ex_b5" form="order_details" value="<?php echo "0";?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_ex_b5" id="o_price_ex_b5" value="<?php echo $o_desc_ex_b5['o_price_ex_b5']; ?>" form="order_details" style="width:5em" >
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>				
				
				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php 
			}
			//start b6 ex
			
			if(count($b6_ex_products)>0)
			{
				?>
				<div class="row w-100 mx-0">
				<?php
				$b6_ex_columns=2;
				$b6_ex_lines=ceil(count($b6_ex_products) / $b6_ex_columns);
				$counter=1;
				for($i=0;$i<count($b6_ex_products);$i++)
				{
					if(!empty($b6_ex_products[$i]))
					{
						$product=$prod->get_product($b6_ex_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b6_ex_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b6_ex_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b6_ex_products[$i]);
						$product_labc=$prod->calculateProductlabc($b6_ex_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row w-100 mx-0">					
							<div class="<?php 
							for($j=0;$j<count($collection);$j++)
							{
								if($b6_ex_products[$i]==$collection[$j])
								{
                                    if($order['om_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";
                                    }
								}
							}	
							for($j=0;$j<count($old_collection);$j++)
							{
								if($b6_ex_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";
								}
							}
							?>">
								<input class="products product_ex_b6 checkbox" type="checkbox" name="<?php echo $b6_ex_products[$i]; ?>" id="<?php echo $b6_ex_products[$i]; ?>" value="<?php echo $b6_ex_products[$i]; ?>" <?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b6_ex_products[$i]==$collection[$j])
									{
                                        if($order['om_id']==0)
                                        {
                                            echo "checked";
                                        }
                                        else
                                        {
                                            echo "checked disabled";
                                        }
									}
								}
								?>> 
								<label for="<?php echo $b6_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_price" name="product_<?php echo $b6_ex_products[$i];?>_price" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b6_ex_products[$i]==$collection[$j])
									{
										echo "prices_ex_b6";
									}
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_apu" name="product_<?php echo $b6_ex_products[$i];?>_apu" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b6_ex_products[$i]==$collection[$j])
									{
										echo "apus_ex_b6";
									}
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_labc" name="product_<?php echo $b6_ex_products[$i];?>_labc" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b6_ex_products[$i]==$collection[$j])
									{
										echo "labcs_ex_b6";
									}
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b6_ex_lines==0)&&($counter>0))
						{
							?>
							</div>
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div>
				</div>
				<br>
				<?php
			}
			?>
			<br>
			<?php
			if(count($b6_ex_products)>0)
			{
				?>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Employee-Producer: Col EX B6 = </b>
						<input type="text" class="form-control form-control-sm" name="col_labc_ex_b6" id="col_labc_ex_b6" value="<?php echo $o_desc_ex_b6['col_labc_ex_b6'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b6 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b6" id="fac_labc_ex_b6" value="<?php echo ($o_desc_ex_b6['fac_labc_ex_b6']!=0)?$o_desc_ex_b6['fac_labc_ex_b6']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b6['col_amount_ex_b6'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount3_ex_b6" id="col_amount3_ex_b6" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b6" id="total_labcs_ex_b6" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Producer-Trader: Col EX B6 = </b>
						<input type="text" class="form-control form-control-sm" name="col_apus_ex_b6" id="col_apus_ex_b6" value="<?php echo $o_desc_ex_b6['col_apus_ex_b6'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b6 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b6" id="fac_prod_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_prod_ex_b6']))?$o_desc_ex_b6['fac_prod_ex_b6']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b6['col_amount_ex_b6'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount2_ex_b6" id="col_amount2_ex_b6" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b6" id="o_apus_ex_b6" value="<?php echo $o_desc_ex_b6['o_apus_ex_b6'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Trader-Purchaser: Col EX B6 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_ex_b6" id="col_price_ex_b6" value="<?php echo $o_desc_ex_b6['col_price_ex_b6']; ?>" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_ex_b6 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b6" id="fac_cl_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_cl_ex_b6']))?$o_desc_ex_b6['fac_cl_ex_b6']:"1";?>" form="order_details" style="width:5em"> 
						<b> X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b6['col_amount_ex_b6'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b6" id="col_amount1_ex_b6" form="order_details" value="<?php echo "0";?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_ex_b6" id="o_price_ex_b6" value="<?php echo $o_desc_ex_b6['o_price_ex_b6']; ?>" form="order_details" style="width:5em" >
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>							
				
				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php 
			}

			//start b7 ex
			
			if(count($b7_ex_products)>0)
			{
				?>
				<div class="row w-100 mx-0">
				<?php
				$b7_ex_columns=2;
				$b7_ex_lines=ceil(count($b7_ex_products) / $b7_ex_columns);
				$counter=1;
				for($i=0;$i<count($b7_ex_products);$i++)
				{
					if(!empty($b7_ex_products[$i]))
					{
						$product=$prod->get_product($b7_ex_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b7_ex_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b7_ex_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b7_ex_products[$i]);
						$product_labc=$prod->calculateProductlabc($b7_ex_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row w-100 mx-0">					
							<div class="<?php 
							for($j=0;$j<count($collection);$j++)
							{
								if($b7_ex_products[$i]==$collection[$j])
								{
                                    if($order['om_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";
                                    }
								}
							}	
							for($j=0;$j<count($old_collection);$j++)
							{
								if($b7_ex_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";
								}
							}
							?>">
								<input class="products product_ex_b7 checkbox" type="checkbox" name="<?php echo $b7_ex_products[$i]; ?>" id="<?php echo $b7_ex_products[$i]; ?>" value="<?php echo $b7_ex_products[$i]; ?>" <?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b7_ex_products[$i]==$collection[$j])
									{
                                        if($order['om_id']==0)
                                        {
                                            echo "checked";
                                        }
                                        else
                                        {
                                            echo "checked disabled";
                                        }
									}
								}
								?>> 
								<label for="<?php echo $b7_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_price" name="product_<?php echo $b7_ex_products[$i];?>_price" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b7_ex_products[$i]==$collection[$j])
									{
										echo "prices_ex_b7";
									}
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_apu" name="product_<?php echo $b7_ex_products[$i];?>_apu" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b7_ex_products[$i]==$collection[$j])
									{
										echo "apus_ex_b7";
									}
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_labc" name="product_<?php echo $b7_ex_products[$i];?>_labc" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b7_ex_products[$i]==$collection[$j])
									{
										echo "labcs_ex_b7";
									}
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b7_ex_lines==0)&&($counter>0))
						{
							?>
							</div>
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div>
				</div>
				<br>
				<?php
			}
			?>
			<br>
			<?php
			if(count($b7_ex_products)>0)
			{
				?>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Employee-Producer: Col EX B7 = </b>
						<input type="text" class="form-control form-control-sm" name="col_labc_ex_b7" id="col_labc_ex_b7" value="<?php echo $o_desc_ex_b7['col_labc_ex_b7'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b7 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b7" id="fac_labc_ex_b7" value="<?php echo ($o_desc_ex_b7['fac_labc_ex_b7']!=0)?$o_desc_ex_b7['fac_labc_ex_b7']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b7['col_amount_ex_b7'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount3_ex_b7" id="col_amount3_ex_b7" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b7" id="total_labcs_ex_b7" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Producer-Trader: Col EX B7 = </b>
						<input type="text" class="form-control form-control-sm" name="col_apus_ex_b7" id="col_apus_ex_b7" value="<?php echo $o_desc_ex_b7['col_apus_ex_b7'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b7 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b7" id="fac_prod_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_prod_ex_b7']))?$o_desc_ex_b7['fac_prod_ex_b7']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b7['col_amount_ex_b7'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount2_ex_b7" id="col_amount2_ex_b7" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b7" id="o_apus_ex_b7" value="<?php echo $o_desc_ex_b7['o_apus_ex_b7'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Trader-Purchaser: Col EX B7 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_ex_b7" id="col_price_ex_b7" value="<?php echo $o_desc_ex_b7['col_price_ex_b7']; ?>" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_ex_b7 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b7" id="fac_cl_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_cl_ex_b7']))?$o_desc_ex_b7['fac_cl_ex_b7']:"1";?>" form="order_details" style="width:5em"> 
						<b> X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b7['col_amount_ex_b7'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b7" id="col_amount1_ex_b7" form="order_details" value="<?php echo "0";?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_ex_b7" id="o_price_ex_b7" value="<?php echo $o_desc_ex_b7['o_price_ex_b7']; ?>" form="order_details" style="width:5em" >
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>							
				
				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php 
			}

			//start b8 ex

			if(count($b8_ex_products)>0)
			{
				?>
				<div class="row w-100 mx-0">
				<?php
				$b8_ex_columns=2;
				$b8_ex_lines=ceil(count($b8_ex_products) / $b8_ex_columns);
				$counter=1;
				for($i=0;$i<count($b8_ex_products);$i++)
				{
					if(!empty($b8_ex_products[$i]))
					{
						$product=$prod->get_product($b8_ex_products[$i]);
						if($order['payment_way']==9)
						{
							$product_price=$prod->calculateProductAPU($b8_ex_products[$i]);
						}
						else
						{
							$product_price=$price->calculateProductPrice($b8_ex_products[$i],$cur_factor);
						}
						$product_apu=$prod->calculateProductAPU($b8_ex_products[$i]);
						$product_labc=$prod->calculateProductlabc($b8_ex_products[$i]);
						
						if($counter==1)
						{
							?>
							<div class="col-md-4">
							<?php
						}
						?>
						<div class="row w-100 mx-0">					
							<div class="<?php 
							for($j=0;$j<count($collection);$j++)
							{
								if($b8_ex_products[$i]==$collection[$j])
								{
                                    if($order['om_id']==0)
                                    {
                                        echo "active_layout text-danger p-1 my-1";
                                    }
                                    else
                                    {
                                        echo "active_layout red_border p-1 my-1";
                                    }
								}
							}	
							for($j=0;$j<count($old_collection);$j++)
							{
								if($b8_ex_products[$i]==$old_collection[$j])
								{
									echo "active_layout text-danger p-1 my-1";
								}
							}
							?>">
								<input class="products product_ex_b8 checkbox" type="checkbox" name="<?php echo $b8_ex_products[$i]; ?>" id="<?php echo $b8_ex_products[$i]; ?>" value="<?php echo $b8_ex_products[$i]; ?>" <?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b8_ex_products[$i]==$collection[$j])
									{
                                        if($order['om_id']==0)
                                        {
                                            echo "checked";
                                        }
                                        else
                                        {
                                            echo "checked disabled";
                                        }
									}
								}
								?>> 
								<label for="<?php echo $b8_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>					
								<input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_price" name="product_<?php echo $b8_ex_products[$i];?>_price" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b8_ex_products[$i]==$collection[$j])
									{
										echo "prices_ex_b8";
									}
								}
								?>" value="<?php echo $product_price; ?>">
								<input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_apu" name="product_<?php echo $b8_ex_products[$i];?>_apu" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b8_ex_products[$i]==$collection[$j])
									{
										echo "apus_ex_b8";
									}
								}
								?>" value="<?php echo $product_apu; ?>">
								<input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_labc" name="product_<?php echo $b8_ex_products[$i];?>_labc" class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b8_ex_products[$i]==$collection[$j])
									{
										echo "labcs_ex_b8";
									}
								}
								?>" value="<?php echo $product_labc; ?>"> 
							</div>						
						</div>	
						<?php
						if(($counter%$b8_ex_lines==0)&&($counter>0))
						{
							?>
							</div>
							<div class="col-md-4">
							<?php
						}
						$counter++;
					}
				}
				?>
				</div>
				</div>
				<br>
				<?php
			}
			?>
			<br>
			<?php
			if(count($b8_ex_products)>0)
			{
				?>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Employee-Producer: Col EX B8 = </b>
						<input type="text" class="form-control form-control-sm" name="col_labc_ex_b8" id="col_labc_ex_b8" value="<?php echo $o_desc_ex_b8['col_labc_ex_b8'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b8 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b8" id="fac_labc_ex_b8" value="<?php echo ($o_desc_ex_b8['fac_labc_ex_b8']!=0)?$o_desc_ex_b8['fac_labc_ex_b8']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b8['col_amount_ex_b8'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount3_ex_b8" id="col_amount3_ex_b8" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b8" id="total_labcs_ex_b8" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Producer-Trader: Col EX B8 = </b>
						<input type="text" class="form-control form-control-sm" name="col_apus_ex_b8" id="col_apus_ex_b8" value="<?php echo $o_desc_ex_b8['col_apus_ex_b8'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b8 = </b>
						<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b8" id="fac_prod_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['fac_prod_ex_b8']))?$o_desc_ex_b8['fac_prod_ex_b8']:"1";?>" form="order_details" style="width:5em"> 
						<b>X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b8['col_amount_ex_b8'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount2_ex_b8" id="col_amount2_ex_b8" form="order_details" value="<?php echo "0";?>" style="width:5em" required>
						<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b8" id="o_apus_ex_b8" value="<?php echo $o_desc_ex_b8['o_apus_ex_b8'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
					</div>
				</div>
				<div class="row form-inline w-100 mx-0">
					<div class="col-md-12">
						<b>Trader-Purchaser: Col EX B8 = </b>
						<input class="form-control form-control-sm" type="text" name="col_price_ex_b8" id="col_price_ex_b8" value="<?php echo $o_desc_ex_b8['col_price_ex_b8']; ?>" form="order_details" style="width:5em"> 
						<b><?php echo $currency; ?> X fac_client_ex_b8 = </b> 
						<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b8" id="fac_cl_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['fac_cl_ex_b8']))?$o_desc_ex_b8['fac_cl_ex_b8']:"1";?>" form="order_details" style="width:5em"> 
						<b> X Amount of houses: <span style="color:red;"><?php echo $old_o_desc_ex_b8['col_amount_ex_b8'];?></span> + </b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b8" id="col_amount1_ex_b8" form="order_details" value="<?php echo "0";?>" style="width:5em" required> 
						<b>=</b> 
						<input type="text" class="form-control form-control-sm" name="o_price_ex_b8" id="o_price_ex_b8" value="<?php echo $o_desc_ex_b8['o_price_ex_b8']; ?>" form="order_details" style="width:5em" >
						<b><?php echo $currency; ?></b>			
						<br><br>
					</div>
				</div>							
				
				<br><br>
				<hr style="border:2px solid brown;">
				<br>
				<?php 
			}
			?>
			
            <div class="row mx-0 w-100">
                <div class="col-4">
                    <div class="form-group text-center">
						<b class="text-center">Real address for the environment: </b>
                        <textarea name="environment_address" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details"><?php echo strip_tags($order['environment_address']); ?></textarea>                    
                    </div> 
                </div>
                <div class="col-4">
                    <div class="form-group text-center">
						<b class="text-center">Customer remarks exterior: </b>
                        <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details"><?php echo strip_tags($order['client_extras_ex_b5']); ?></textarea>                  
                    </div> 
                </div>
                <div class="col-4">
                    <div class="form-group text-center">
						<b class="text-center">Operator remarks exterior: </b>
                        <textarea name="op_remarks_ex_b5" class="form-control form-control-sm mt-2" form="order_details"><?php echo $order['op_remarks_ex_b5']; ?></textarea>
                    </div> 
                </div>
            </div>
				<a id="customerfiles"></a>
				
				<br>
				
			<input type="hidden" id="ex_old_amount" name="ex_old_amount" value="<?php 
			if($old_o_desc_ex_b5['col_amount_ex_b5']>0)
			{
				echo $old_o_desc_ex_b5['col_amount_ex_b5'];
			}
			if($old_o_desc_ex_b7['col_amount_ex_b7']>0)
			{
				echo $old_o_desc_ex_b7['col_amount_ex_b7'];
			}
			?>" form="order_details">
			<?php
			}
			else
			{
			?>
			<div class="row w-100 mx-0 text-center">
				<div class="col-md-12">
					<div class="error">No Exterior</div>
				</div>
			</div>
			<?php
			}
			?>
			<br>	
			</div> <!-- end exterior -->
			<input type="hidden" id="collection" name="collection" value="<?php echo $order['collection']; ?>" form="order_details">
			<br>
			
			<div class="totals w-100 mx-0 text-center">
                <?php
                include('../../../domenia7.com/public_html/customer_files.php');
                
                $vat=$prod->get_vat($licence_taker['a_id']);
                
                if(!empty($licence_taker['VAT-tax no.']))
                {
                    if($vat['a_eu']=="1")
                    {					
                        $vat_percent=$vat['a_vat'];		
                        $vat_a_id=$vat['a_id'];
                    }
                    else
                    {
                        if($licence_taker['a_id']==$client['a_id'])
                        {						
                            $vat_percent=$vat['a_vat']; 
                            $vat_a_id=$vat['a_id'];
                        }
                        else
                        {										
                            $vat_percent=0;					
                        }
                    }
                }
                else
                {						
                    $vat_percent=0;
                }
                
                if($order['payment_way']==9)
                {
                    $vat_percent=0;
                }
                ?>
                <input type="hidden" id="vat_percent" name="vat_percent" form="order_details" value="<?php echo $vat_percent;?>"> 
                <input type="hidden" id="vat_a_id" name="vat_a_id" form="order_details" value="<?php echo $vat_a_id;?>">
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-8 offset-2 border py-4">
                        <label for="total_price" class="d-inline"><b>Total price = </b></label>
                        <input type="text" name="total_price" id="total_price" class="form-control form-control-sm d-inline" form="order_details" style="width:6em;" value="<?php 
                        if(strpos($order['collection'],'p1001')!==false)
                        {
                            echo $order['o_price'];
                        }
                        ?>">
                        <b class="d-inline"><?php echo $currency; ?></b>
                        <b class="d-inline mx-1">or</b> 
                        <label for="total_special_agreement_price" class="d-inline"><b>Total special agreement price = </b></label>
                        <input type="text" name="total_special_agreement_price" id="total_special_agreement_price" class="form-control form-control-sm d-inline" form="order_details" style="width:6em;" value="<?php 
                        echo (isset($_COOKIE['total_special_agreement_price']))?$_COOKIE['total_special_agreement_price']:$order['o_special_agreement_price'];
                        ?>">
                        <b class="d-inline"><?php echo $currency; ?></b>
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-8 offset-2 border py-4">
                        <label for="total_apu" class="d-inline"><b>Total APUs = </b></label>
                        <input type="text" name="total_apu" id="total_apu" class="form-control form-control-sm d-inline" style="width:6em;" value="<?php 
                        if(strpos($order['collection'],'p1001')!==false)
                        {
                            echo $budget_apu=$prod->calculateProductAPU("p1001");
                        }
                        ?>">
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0 d-flex justify-content-center">
					<div class="col-md-8 border border-bottom-0 pt-3 d-flex justify-content-center py-1" style="background-color:#000;color:#fff;">
						<textarea class="form-control form-control-sm w-100" name="invoice_explanations" id="invoice_explanations" placeholder="Invoice explanations" form="order_details"><?php
						echo $order['invoice_explanations'];
						?></textarea>
					</div>
				</div>
                <input type="hidden" name="cur_fac" id="cur_fac" value="<?php echo $cur_factor; ?>" form="order_details">				
                <input type="hidden" name="budget" id="budget" value="<?php 
                if(strpos($order['collection'],'p1001')!==false)
                {
                    echo "1";
                }?>" form="order_details">
                
                <div class="row form-inline w-100 mx-0">		
                    <div class="col-md-8 offset-2 py-4 border">
                        <b>Producer for this order:</b>
                        <input form="order_details" type="hidden" id="producerid" name="producerid" value="<?php 
                        $creators_company=$prod->get_creators_company($_COOKIE['email']);
                        
                        if($order['u_prod_id']>0)
                        {
                            echo $order['u_prod_id'];
                        }
                        else
                        {
                            echo $creators_company['lt_id']; 
                        }
                        ?>">
                        
                        <select form="order_details" id="producers" name="producers" class="form-control form-control-sm" style="width:300px" form="order_details" required>
                            <option value="">-= Choose =-</option>
                                <?php		
                                
                                $producers=$prod->get_licence($licid);
                                $u_producers=explode(';',$producers['uprod_id']);
                                for($i=0;$i<count($u_producers)-1;$i++)
                                {						
                                ?>
                                    <option value="<?php echo $u_producers[$i]; ?>"><?php echo $prod->get_company($u_producers[$i])['Company']; ?></option>
                                <?php
                                }
                                ?>
                        </select>
                    </div>	
                </div>
                
                
                <div class="row center_message w-100 mx-0 d-flex justify-content-center mt-3">
                <?php
                //accepted order
                if(isset($_GET['status']))
                {	
                ?>
                <br><button name="save_btn" class="btn btn-primary btn-sm mx-2 border" form="order_details">Save changes <i class="fas fa-save ml-2"></i></button>
                <?php			
                }
                
                //not accepted order
                if((!isset($_GET['status']))&&($_GET['status']!="accepted"))
                {
                ?>
                <br><button name="accept_btn" class="btn btn-primary btn-sm mx-2 border" form="order_details">Accept <i class="fas fa-check-square ml-2"></i></button>
                <?php
                }
                ?>
                <a href="message_to_client.php?o_id=<?php echo $o_id; ?>" class="btn btn-warning btn-sm mx-2 border">Message to client <i class="fas fa-envelope ml-2"></i></a>
                <?php
                if((!isset($_GET['status']))&&($_GET['status']!="accepted"))
                {
                ?>
                <a href="orderdetails.php?o_id=<?php echo $o_id; ?>&clientid=<?php echo $clientid; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Reject <i class="fas fa-trash ml-2"></i></a>
                <?php
                }
                
                //create new order
                if($option=="create_order")
                {	
                ?>
                <br><button name="create_btn" class="btn btn-primary btn-sm" form="order_details">Create order <i class="fas fa-plus-square ml-2"></i></button>
                <?php			
                }
                ?>
                </div>		
                <br>
			</div>
			<br>
			</div> <!-- end div container -->			
			<?php
			//}
		}
		else
		{
			?>
			<div class="center_message">				
				<div class="error">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br ><br >
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
	</article>
	<script type='text/javascript' src='js/o_extension.js'></script>
	<!-- <script type='text/javascript' src='js/create_order.js'></script> -->
</section>
<?php
include('../footer.php');
?>