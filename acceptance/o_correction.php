<?php

//session_set_cookie_params(14400,"/acceptance");

session_start();

include('../functions.php');

include('../../../../superfloorplans.com/public_html/functions.php');

include('../../../../superfloorplans.com/public_html/price_calculations.php');

include('../../../../domenia7.com/public_html/domenia_db2.php');

include('../../../../blue7.it/public_html/domenia/domenia.php');

$prod=new Production;

$price=new PriceCalculations;

$domenia2=new Domenia2;

$domenia=new Domenia;

$page_title="Contracting - Correction/Amendment";

include('../header2.php');

include('../menu.php');


$client=$prod->get_client($_COOKIE['client_id']);



$licence_sites=explode(";",$client['ls_ids']);

?>

<section class="top_section">

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

if(isset($_COOKIE['client_id']))

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

		$data['accepted_by']=$_COOKIE['client_id'];

		$data['collection']=$old_order['collection'];

		$data['u_prod_id']=$old_order['u_prod_id'];

		$data['vat_percent']=$old_order['vat_percent'];

		$data['vat_a_id']=$old_order['vat_a_id'];

		$data['total_special_agreement_price']=$prod->xss_fix($_POST['total_special_agreement_price']);

		$data['invoice_explanations']="$prod->xss_fix($_POST['invoice_explanations'])";
		$data['o_price']=$old_order['o_price'];
		$o_correction_amendment=$prod->xss_fix($_POST['o_correction_amendment']) ?? '';

		if($o_correction_amendment=="correction")
		{
			$data['o_correction']=1;
		}
		else
		{
			$data['o_amendment']=1;
		}

		$data['vat_amount']=number_format(floor(($data['o_price'] * $data['vat_percent'] / 100)*100)/100,2, '.', '');



		if($data['total_special_agreement_price']==0)

		{

			$data['brut_price']=number_format(floor(($data['o_price'] + $data['vat_amount'])*100)/100,2, '.', '');

		}

		else

		{

			$data['brut_price']=number_format(floor(($data['o_special_agreement_price'] + $data['vat_amount'])*100)/100,2, '.', '');

		}

		$client_public_presentation=$prod->get_client($data['u_client_ID']);

		if($client_public_presentation['public_presentation']==1)
		{
			$data['public']=1;
		}
		else
		{
			$data['public']=$old_order['public'];
		}

		$prod->create_order2(json_encode($data));



		$new_order=$prod->show_last_order();



		$old_o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_correction);

		$old_o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_correction);

		$old_o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_correction);

		$old_o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_correction);



		$old_o_desc_in_b3=$prod->get_o_desc_in_b3($o_correction);

		$old_o_desc_in_b5=$prod->get_o_desc_in_b5($o_correction);

		$old_o_desc_in_b6=$prod->get_o_desc_in_b6($o_correction);

		$old_o_desc_in_b7=$prod->get_o_desc_in_b7($o_correction);

		$old_o_desc_in_b8=$prod->get_o_desc_in_b8($o_correction);



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



			$new_ex_b5_data['p1561_fac']=$old_o_desc_ex_b5['p1561_fac'] ?? 0;

			$new_ex_b5_data['p1563_fac']=$old_o_desc_ex_b5['p1563_fac'] ?? 0;

			$new_ex_b5_data['p1566_fac']=$old_o_desc_ex_b5['p1566_fac'] ?? 0;



			$prod->add_o_desc_ex_b52(json_encode($new_ex_b5_data));

		}



		if(count($old_o_desc_ex_b6)>0)

		{

			$new_ex_b6_data['o_id']=$new_order['order_ID'];

			// $new_ex_b6_data['rs_id']=$old_o_desc_ex_b6['rs_id'];

			// $new_ex_b6_data['rmp_id']=$old_o_desc_ex_b6['rmp_id'];

			// $new_ex_b6_data['r_tilt']=$old_o_desc_ex_b6['r_tilt'];

			// $new_ex_b6_data['r_kneewall']=$old_o_desc_ex_b6['r_kneewall'];

			// $new_ex_b6_data['rop_id']=$old_o_desc_ex_b6['rop_id'];

			// $new_ex_b6_data['r_gutter_id']=$old_o_desc_ex_b6['r_gutter_id'];

			// $new_ex_b6_data['e_length']=$old_o_desc_ex_b6['e_length'];

			// $new_ex_b6_data['e_width']=$old_o_desc_ex_b6['e_width'];

			// $new_ex_b6_data['wlc_id']=$old_o_desc_ex_b6['wlc_id'];

			// $new_ex_b6_data['ww_id']=$old_o_desc_ex_b6['ww_id'];

			// $new_ex_b6_data['gc_id']=$old_o_desc_ex_b6['gc_id'];

			// $new_ex_b6_data['gc_length']=$old_o_desc_ex_b6['gc_length'];

			// $new_ex_b6_data['gc_width']=$old_o_desc_ex_b6['gc_width'];

			// $new_ex_b6_data['gc_height']=$old_o_desc_ex_b6['gc_height'];

			// $new_ex_b6_data['reelings_id']=$old_o_desc_ex_b6['reelings_id'];

			// $new_ex_b6_data['wc_id']=$old_o_desc_ex_b6['wc_id'];

			// $new_ex_b6_data['door_color']=$old_o_desc_ex_b6['door_color'];

			// $new_ex_b6_data['door_texture']=$old_o_desc_ex_b6['door_texture'];

			// $new_ex_b6_data['dsp_id']=$old_o_desc_ex_b6['dsp_id'];

			// $new_ex_b6_data['pbp_id']=$old_o_desc_ex_b6['pbp_id'];

			// $new_ex_b6_data['basement']=$old_o_desc_ex_b6['basement'];

			// $new_ex_b6_data['levels_over_ground']=$old_o_desc_ex_b6['levels_over_ground'];



			$new_ex_b6_data['col_amount_ex_b6']=$old_o_desc_ex_b6['col_amount_ex_b6'] ?? 0.0;



			$new_ex_b6_data['p1661_fac']=$old_o_desc_ex_b6['p1661_fac'] ?? 1.0;

			$new_ex_b6_data['p1663_fac']=$old_o_desc_ex_b6['p1663_fac'] ?? 1.0;

			$new_ex_b6_data['p1666_fac']=$old_o_desc_ex_b6['p1666_fac'] ?? 1.0;
			$new_ex_b6_data['p166p_fac']=$old_o_desc_ex_b6['p166p_fac'] ?? 1.0;


			$prod->add_o_desc_ex_b6(json_encode($new_ex_b6_data));

		}



		if(count($old_o_desc_ex_b7)>0)

		{

			$new_ex_b7_data['o_id']=$new_order['order_ID'];

			// $new_ex_b7_data['rs_id']=$old_o_desc_ex_b7['rs_id'];

			// $new_ex_b7_data['rmp_id']=$old_o_desc_ex_b7['rmp_id'];

			// $new_ex_b7_data['r_tilt']=$old_o_desc_ex_b7['r_tilt'];

			// $new_ex_b7_data['r_kneewall']=$old_o_desc_ex_b7['r_kneewall'];

			// $new_ex_b7_data['rop_id']=$old_o_desc_ex_b7['rop_id'];

			// $new_ex_b7_data['r_gutter_id']=$old_o_desc_ex_b7['r_gutter_id'];

			// $new_ex_b7_data['e_length']=$old_o_desc_ex_b7['e_length'];

			// $new_ex_b7_data['e_width']=$old_o_desc_ex_b7['e_width'];

			// $new_ex_b7_data['wlc_id']=$old_o_desc_ex_b7['wlc_id'];

			// $new_ex_b7_data['ww_id']=$old_o_desc_ex_b7['ww_id'];

			// $new_ex_b7_data['gc_id']=$old_o_desc_ex_b7['gc_id'];

			// $new_ex_b7_data['gc_length']=$old_o_desc_ex_b7['gc_length'];

			// $new_ex_b7_data['gc_width']=$old_o_desc_ex_b7['gc_width'];

			// $new_ex_b7_data['gc_height']=$old_o_desc_ex_b7['gc_height'];

			// $new_ex_b7_data['reelings_id']=$old_o_desc_ex_b7['reelings_id'];

			// $new_ex_b7_data['wc_id']=$old_o_desc_ex_b7['wc_id'];

			// $new_ex_b7_data['door_color']=$old_o_desc_ex_b7['door_color'];

			// $new_ex_b7_data['door_texture']=$old_o_desc_ex_b7['door_texture'];

			// $new_ex_b7_data['dsp_id']=$old_o_desc_ex_b7['dsp_id'];

			// $new_ex_b7_data['pbp_id']=$old_o_desc_ex_b7['pbp_id'];

			// $new_ex_b7_data['basement']=$old_o_desc_ex_b7['basement'];

			// $new_ex_b7_data['levels_over_ground']=$old_o_desc_ex_b7['levels_over_ground'];



			$new_ex_b7_data['col_amount_ex_b7']=$old_o_desc_ex_b7['col_amount_ex_b7'] ?? 0.0;



			$new_ex_b7_data['p1761_fac']=$old_o_desc_ex_b7['p1761_fac'] ?? 1.0;

			$new_ex_b7_data['p1763_fac']=$old_o_desc_ex_b7['p1763_fac'] ?? 1.0;

			$new_ex_b7_data['p1766_fac']=$old_o_desc_ex_b7['p1766_fac'] ?? 1.0;





			$prod->add_o_desc_ex_b72(json_encode($new_ex_b7_data));

		}

		if(!empty($old_o_desc_ex_b8))
		{

			if(count($old_o_desc_ex_b8)>0)

			{

				$new_ex_b8_data['o_id']=$new_order['order_ID'];

				// $new_ex_b8_data['rs_id']=$old_o_desc_ex_b8['rs_id'];

				// $new_ex_b8_data['rmp_id']=$old_o_desc_ex_b8['rmp_id'];

				// $new_ex_b8_data['r_tilt']=$old_o_desc_ex_b8['r_tilt'];

				// $new_ex_b8_data['r_kneewall']=$old_o_desc_ex_b8['r_kneewall'];

				// $new_ex_b8_data['rop_id']=$old_o_desc_ex_b8['rop_id'];

				// $new_ex_b8_data['r_gutter_id']=$old_o_desc_ex_b8['r_gutter_id'];

				// $new_ex_b8_data['e_length']=$old_o_desc_ex_b8['e_length'];

				// $new_ex_b8_data['e_width']=$old_o_desc_ex_b8['e_width'];

				// $new_ex_b8_data['wlc_id']=$old_o_desc_ex_b8['wlc_id'];

				// $new_ex_b8_data['ww_id']=$old_o_desc_ex_b8['ww_id'];

				// $new_ex_b8_data['gc_id']=$old_o_desc_ex_b8['gc_id'];

				// $new_ex_b8_data['gc_length']=$old_o_desc_ex_b8['gc_length'];

				// $new_ex_b8_data['gc_width']=$old_o_desc_ex_b8['gc_width'];

				// $new_ex_b8_data['gc_height']=$old_o_desc_ex_b8['gc_height'];

				// $new_ex_b8_data['reelings_id']=$old_o_desc_ex_b8['reelings_id'];

				// $new_ex_b8_data['wc_id']=$old_o_desc_ex_b8['wc_id'];

				// $new_ex_b8_data['door_color']=$old_o_desc_ex_b8['door_color'];

				// $new_ex_b8_data['door_texture']=$old_o_desc_ex_b8['door_texture'];

				// $new_ex_b8_data['dsp_id']=$old_o_desc_ex_b8['dsp_id'];

				// $new_ex_b8_data['pbp_id']=$old_o_desc_ex_b8['pbp_id'];

				// $new_ex_b8_data['basement']=$old_o_desc_ex_b8['basement'];

				// $new_ex_b8_data['levels_over_ground']=$old_o_desc_ex_b8['levels_over_ground'];



				$new_ex_b8_data['col_amount_ex_b8']=$old_o_desc_ex_b8['col_amount_ex_b8'] ?? 0.0;



				$new_ex_b8_data['p1861_fac']=$old_o_desc_ex_b8['p1861_fac'] ?? 1.0;

				$new_ex_b8_data['p1863_fac']=$old_o_desc_ex_b8['p1863_fac'] ?? 1.0;

				$new_ex_b8_data['p1866_fac']=$old_o_desc_ex_b8['p1866_fac'] ?? 1.0;





				$prod->add_o_desc_ex_b8(json_encode($new_ex_b8_data));

			}

		}



		if(count($old_o_desc_in_b3)>0)

		{

			$new_in_b3_data['o_id']=$new_order['order_ID'];

			$new_in_b3_data['sl_id']=$old_o_desc_in_b3['sl_id'];

			$new_in_b3_data['cls_id']=$old_o_desc_in_b3['cls_id'];



			$new_in_b3_data['b3_col_amount']=$old_o_desc_in_b3['col_amount_in_b3'] ?? 0.0;



			$new_in_b3_data['p1301_fac']=$old_o_desc_in_b3['p1301_fac'] ?? 1.0;

			$new_in_b3_data['p1302_fac']=$old_o_desc_in_b3['p1302_fac'] ?? 1.0;

			$new_in_b3_data['p1321_fac']=$old_o_desc_in_b3['p1321_fac'] ?? 1.0;

			$new_in_b3_data['p1322_fac']=$old_o_desc_in_b3['p1322_fac'] ?? 1.0;



			$prod->add_o_desc_in_b32(json_encode($new_in_b3_data));

		}



		if(count($old_o_desc_in_b5)>0)

		{

			$new_in_b5_data['o_id']=$new_order['order_ID'];

			$new_in_b5_data['layout_id']=$old_o_desc_in_b5['layout_id'] ?? '';

			$new_in_b5_data['window_id']=$old_o_desc_in_b5['window_id'] ?? '';

			$new_in_b5_data['b5_col_amount']=$old_o_desc_in_b5['col_amount_in_b5'] ?? 0.0;



			$new_in_b5_data['p1501_fac']=$old_o_desc_in_b5['p1501_fac'] ?? 1.0;

			$new_in_b5_data['p1504_fac']=$old_o_desc_in_b5['p1504_fac'] ?? 1.0;

			$new_in_b5_data['p1506_fac']=$old_o_desc_in_b5['p1506_fac'] ?? 1.0;



			$new_in_b5_data['p1521_fac']=$old_o_desc_in_b5['p1521_fac'] ?? 1.0;

			$new_in_b5_data['p1524_fac']=$old_o_desc_in_b5['p1524_fac'] ?? 1.0;

			$new_in_b5_data['p1526_fac']=$old_o_desc_in_b5['p1526_fac'] ?? 1.0;



			$new_in_b5_data['p1541_fac']=$old_o_desc_in_b5['p1541_fac'] ?? 1.0;

			$new_in_b5_data['p1544_fac']=$old_o_desc_in_b5['p1544_fac'] ?? 1.0;

			$new_in_b5_data['p1546_fac']=$old_o_desc_in_b5['p1546_fac'] ?? 1.0;



			$prod->add_o_desc_in_b52(json_encode($new_in_b5_data));

		}



		if(count($old_o_desc_in_b6)>0)

		{

			$new_in_b6_data['o_id']=$new_order['order_ID'];

			$new_in_b6_data['layout_id']=$old_o_desc_in_b6['layout_id'] ?? '';

			$new_in_b6_data['window_id']=$old_o_desc_in_b6['window_id'] ?? '';

			$new_in_b6_data['col_amount_in_b6']=$old_o_desc_in_b6['col_amount_in_b6'] ?? 0.0;



			$new_in_b6_data['p1600_fac']=$old_o_desc_in_b6['p1600_fac'] ?? 1.0;

			$new_in_b6_data['p1601_fac']=$old_o_desc_in_b6['p1601_fac'] ?? 1.0;

			$new_in_b6_data['p1604_fac']=$old_o_desc_in_b6['p1604_fac'] ?? 1.0;

			$new_in_b6_data['p1606_fac']=$old_o_desc_in_b6['p1606_fac'] ?? 1.0;



			$new_in_b6_data['p1621_fac']=$old_o_desc_in_b6['p1621_fac'] ?? 1.0;

			$new_in_b6_data['p1624_fac']=$old_o_desc_in_b6['p1624_fac'] ?? 1.0;

			$new_in_b6_data['p1626_fac']=$old_o_desc_in_b6['p1626_fac'] ?? 1.0;



			$new_in_b6_data['p1641_fac']=$old_o_desc_in_b6['p1641_fac'] ?? 1.0;

			$new_in_b6_data['p1644_fac']=$old_o_desc_in_b6['p1644_fac'] ?? 1.0;

			$new_in_b6_data['p1646_fac']=$old_o_desc_in_b6['p1646_fac'] ?? 1.0;



			$prod->add_o_desc_in_b6(json_encode($new_in_b6_data));

		}



		if(count($old_o_desc_in_b7)>0)

		{

			$new_in_b7_data['o_id']=$new_order['order_ID'];

			$new_in_b7_data['layout_id']=$old_o_desc_in_b7['layout_id'] ?? '';

			$new_in_b7_data['window_id']=$old_o_desc_in_b7['window_id'] ?? '';

			$new_in_b7_data['col_amount_in_b7']=$old_o_desc_in_b7['col_amount_in_b7'] ?? 0.0;



			$new_in_b7_data['p1700_fac']=$old_o_desc_in_b7['p1700_fac'] ?? 1.0;

			$new_in_b7_data['p1701_fac']=$old_o_desc_in_b7['p1701_fac'] ?? 1.0;

			$new_in_b7_data['p1704_fac']=$old_o_desc_in_b7['p1704_fac'] ?? 1.0;

			$new_in_b7_data['p1706_fac']=$old_o_desc_in_b7['p1706_fac'] ?? 1.0;



			$new_in_b7_data['p1721_fac']=$old_o_desc_in_b7['p1721_fac'] ?? 1.0;

			$new_in_b7_data['p1724_fac']=$old_o_desc_in_b7['p1724_fac'] ?? 1.0;

			$new_in_b7_data['p1726_fac']=$old_o_desc_in_b7['p1726_fac'] ?? 1.0;



			$new_in_b7_data['p1741_fac']=$old_o_desc_in_b7['p1741_fac'] ?? 1.0;

			$new_in_b7_data['p1744_fac']=$old_o_desc_in_b7['p1744_fac'] ?? 1.0;

			$new_in_b7_data['p1746_fac']=$old_o_desc_in_b7['p1746_fac'] ?? 1.0;



			$prod->add_o_desc_in_b72(json_encode($new_in_b7_data));

		}


		if(!empty($old_o_desc_in_b8))
		{
			if(count($old_o_desc_in_b8)>0)

			{

				$new_in_b8_data['o_id']=$new_order['order_ID'];

				$new_in_b8_data['layout_id']=$old_o_desc_in_b8['layout_id'] ?? '';

				$new_in_b8_data['window_id']=$old_o_desc_in_b8['window_id'] ?? '';

				$new_in_b8_data['col_amount_in_b8']=$old_o_desc_in_b8['col_amount_in_b8'] ?? 0.0;



				$new_in_b8_data['p1800_fac']=$old_o_desc_in_b8['p1800_fac'] ?? 1.0;

				$new_in_b8_data['p1801_fac']=$old_o_desc_in_b8['p1801_fac'] ?? 1.0;

				$new_in_b8_data['p1804_fac']=$old_o_desc_in_b8['p1804_fac'] ?? 1.0;

				$new_in_b8_data['p1806_fac']=$old_o_desc_in_b8['p1806_fac'] ?? 1.0;



				$new_in_b8_data['p1821_fac']=$old_o_desc_in_b8['p1821_fac'] ?? 1.0;

				$new_in_b8_data['p1824_fac']=$old_o_desc_in_b8['p1824_fac'] ?? 1.0;

				$new_in_b8_data['p1826_fac']=$old_o_desc_in_b8['p1826_fac'] ?? 1.0;



				$new_in_b8_data['p1841_fac']=$old_o_desc_in_b8['p1841_fac'] ?? 1.0;

				$new_in_b8_data['p1844_fac']=$old_o_desc_in_b8['p1844_fac'] ?? 1.0;

				$new_in_b8_data['p1846_fac']=$old_o_desc_in_b8['p1846_fac'] ?? 1.0;



				$prod->add_o_desc_in_b8(json_encode($new_in_b8_data));

			}
		}


			$mistakes=$_POST['mistake'];

			$amendments=$_POST['amendment'];
			

		if(!empty($mistakes))
		{
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
		}


		if(!empty($amendments))
		{
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

				$amendment_data['p_status']=6;

				$amendment_data['om_amendment']=1;



				$existing_product=$prod->get_order_product(json_encode($amendment_data));
				

				if(empty($existing_product))

				{

					$prod->add_order_products2(json_encode($amendment_data));

				}

				else

				{

					$amendment_data['om_correction']=$existing_product['om_correction'];

					$prod->update_order_product(json_encode($amendment_data));

				}

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
	$update_data['accepted_by']=$_COOKIE['client_id'];
    $update_data['environment_address']=$old_order['environment_address'];

    $update_data['invoice_explanations']=$prod->xss_fix($_POST['invoice_explanations']);

    $update_data['vat_percent']=$old_order['vat_percent'];

    $update_data['vat_a_id']=$old_order['vat_a_id'];

	$update_data['u_prod_id']=$old_order['u_prod_id'];

    $update_data['notifications']=$old_order['notifications'];

    $update_data['o_special_agreement_price']=$prod->xss_fix($_POST['total_special_agreement_price']);


    if($update_data['o_special_agreement_price']==0)

    {

        $update_data['vat_amount']=number_format(floor(($update_data['o_price'] * $update_data['vat_percent'] / 100)*100)/100,2, '.', '');

        $update_data['brut_price']=number_format(floor(($update_data['o_price'] + $update_data['vat_amount'])*100)/100,2, '.', '');

    }

    else

    {

        $update_data['vat_amount']=number_format(floor(($update_data['o_special_agreement_price'] * $update_data['vat_percent'] / 100)*100)/100,2, '.', '');

        $update_data['brut_price']=number_format(floor(($update_data['o_special_agreement_price'] + $update_data['vat_amount'])*100)/100,2, '.', '');

    }



    if($new_order['o_status']==8)

    {

        $update_data['o_status']=8;

    }

    else

    {

        $update_data['o_status']=1;

    }


	$client_public_presentation=$prod->get_client($old_order['u_client_ID']);

	if($client_public_presentation['public_presentation']==1)
	{
		$update_data['public']=1;
	}
	else
	{
		$update_data['public']=$old_order['public'];
	}


	$prod->update_order2(json_encode($update_data));



	//b5 ex



	$ex_b5_data['o_id']=$prod->xss_fix($_POST['o_id']);



	$old_o_desc_ex_b5=$prod->get_o_desc_ex_b5($ex_b5_data['o_id']);



	if(!empty($old_o_desc_ex_b5))

	{

		$ex_b5_data['col_price_ex_b5']=$prod->xss_fix($_POST['col_price_ex_b5'] ?? 0);

		$ex_b5_data['fac_cl_ex_b5']=$prod->xss_fix($_POST['fac_cl_ex_b5'] ?? 1.0);

		$ex_b5_data['o_price_ex_b5']=$prod->xss_fix($_POST['o_price_ex_b5'] ?? 0);



		$ex_b5_data['col_apus_ex_b5']=$prod->xss_fix($_POST['col_apus_ex_b5'] ?? 0);

		$ex_b5_data['fac_prod_ex_b5']=$prod->xss_fix($_POST['fac_prod_ex_b5'] ?? 1.0);

		$ex_b5_data['o_apus_ex_b5']=$prod->xss_fix($_POST['o_apus_ex_b5'] ?? 0);



		$ex_b5_data['col_labc_ex_b5']=$prod->xss_fix($_POST['col_labc_ex_b5'] ?? 0);

		$ex_b5_data['fac_labc_ex_b5']=$prod->xss_fix($_POST['fac_labc_ex_b5'] ?? 1.0);

		$ex_b5_data['total_labcs_ex_b5']=$prod->xss_fix($_POST['total_labcs_ex_b5'] ?? 0);



		$ex_b5_data['p1561_fac']=$prod->xss_fix($_POST['p1561_fac']?? 0);

		$ex_b5_data['p1563_fac']=$prod->xss_fix($_POST['p1563_fac'] ?? 0);

		$ex_b5_data['p1566_fac']=1.0;
		


		$prod->update_o_desc_ex_b52(json_encode($ex_b5_data));

	}



    //b6 ex

	$ex_b6_data['o_id']=$prod->xss_fix($_POST['o_id']);

	$old_o_desc_ex_b6=$prod->get_o_desc_ex_b6($ex_b6_data['o_id']);

    if(!empty($old_o_desc_ex_b6))

	{

		$ex_b6_data['col_price_ex_b6']=$prod->xss_fix($_POST['col_price_ex_b6'] ?? 0.0);

		$ex_b6_data['fac_cl_ex_b6']=$prod->xss_fix($_POST['fac_cl_ex_b6'] ?? 1.0);

		$ex_b6_data['o_price_ex_b6']=$prod->xss_fix($_POST['o_price_ex_b6'] ?? 0.0);



		$ex_b6_data['col_apus_ex_b6']=$prod->xss_fix($_POST['col_apus_ex_b6'] ?? 0.0);

		$ex_b6_data['fac_prod_ex_b6']=$prod->xss_fix($_POST['fac_prod_ex_b6'] ?? 1.0);

		$ex_b6_data['o_apus_ex_b6']=$prod->xss_fix($_POST['o_apus_ex_b6'] ?? 0.0);



		$ex_b6_data['col_labc_ex_b6']=$prod->xss_fix($_POST['col_labc_ex_b6'] ?? 0.0);

		$ex_b6_data['fac_labc_ex_b6']=$prod->xss_fix($_POST['fac_labc_ex_b6'] ?? 1.0);

		$ex_b6_data['total_labcs_ex_b6']=$prod->xss_fix($_POST['total_labcs_ex_b6'] ?? 0.0);



		$ex_b6_data['p1661_fac']=1.0;

		$ex_b6_data['p1663_fac']=1.0;

		$ex_b6_data['p1666_fac']=1.0;
		$ex_b6_data['p166p_fac']=1.0;


		$prod->update_o_desc_ex_b6(json_encode($ex_b6_data));

    }



	//b7 ex



	$ex_b7_data['o_id']=$prod->xss_fix($_POST['o_id']);



	$old_o_desc_ex_b7=$prod->get_o_desc_ex_b7($ex_b7_data['o_id']);



	if(!empty($old_o_desc_ex_b7))

	{

		$ex_b7_data['col_price_ex_b7']=$prod->xss_fix($_POST['col_price_ex_b7'] ?? 0.0);

		$ex_b7_data['fac_cl_ex_b7']=$prod->xss_fix($_POST['fac_cl_ex_b7'] ?? 1.0);

		$ex_b7_data['o_price_ex_b7']=$prod->xss_fix($_POST['o_price_ex_b7'] ?? 0.0);



		$ex_b7_data['col_apus_ex_b7']=$prod->xss_fix($_POST['col_apus_ex_b7'] ?? 0.0);

		$ex_b7_data['fac_prod_ex_b7']=$prod->xss_fix($_POST['fac_prod_ex_b7'] ?? 1.0);

		$ex_b7_data['o_apus_ex_b7']=$prod->xss_fix($_POST['o_apus_ex_b7'] ?? 0.0);



		$ex_b7_data['col_labc_ex_b7']=$prod->xss_fix($_POST['col_labc_ex_b7'] ?? 0.0);

		$ex_b7_data['fac_labc_ex_b7']=$prod->xss_fix($_POST['fac_labc_ex_b7'] ?? 1.0);

		$ex_b7_data['total_labcs_ex_b7']=$prod->xss_fix($_POST['total_labcs_ex_b7'] ?? 0.0);



		$ex_b7_data['p1761_fac']=$prod->xss_fix($_POST['p1761_fac'] ?? 1.0);
		$ex_b7_data['p1762_fac']=$prod->xss_fix($_POST['p1762_fac'] ?? 1.0);
		$ex_b7_data['p1763_fac']=$prod->xss_fix($_POST['p1763_fac'] ?? 1.0);

		$ex_b7_data['p1766_fac']=$prod->xss_fix($_POST['p1766_fac'] ?? 1.0);



		$prod->update_o_desc_ex_b72(json_encode($ex_b7_data));

	}



    //b8 ex

	$ex_b8_data['o_id']=$prod->xss_fix($_POST['o_id']);
	$old_o_desc_ex_b8=$prod->get_o_desc_ex_b8($ex_b8_data['o_id']);

	if(!empty($old_o_desc_ex_b8))
	{
		if(count($old_o_desc_ex_b8)>0)

		{

			$ex_b8_data['col_price_ex_b8']=$prod->xss_fix($_POST['col_price_ex_b8'] ?? 0.0);

			$ex_b8_data['fac_cl_ex_b8']=$prod->xss_fix($_POST['fac_cl_ex_b8'] ?? 1.0);

			$ex_b8_data['o_price_ex_b8']=$prod->xss_fix($_POST['o_price_ex_b8'] ?? 0.0);



			$ex_b8_data['col_apus_ex_b8']=$prod->xss_fix($_POST['col_apus_ex_b8'] ?? 0.0);

			$ex_b8_data['fac_prod_ex_b8']=$prod->xss_fix($_POST['fac_prod_ex_b8'] ?? 1.0);

			$ex_b8_data['o_apus_ex_b8']=$prod->xss_fix($_POST['o_apus_ex_b8'] ?? 0.0);



			$ex_b8_data['col_labc_ex_b8']=$prod->xss_fix($_POST['col_labc_ex_b8'] ?? 0.0);

			$ex_b8_data['fac_labc_ex_b8']=$prod->xss_fix($_POST['fac_labc_ex_b8'] ?? 1.0);

			$ex_b8_data['total_labcs_ex_b8']=$prod->xss_fix($_POST['total_labcs_ex_b8'] ?? 0.0);



			$ex_b8_data['p1861_fac']=$prod->xss_fix($_POST['p1861_fac'] ?? 1.0);

			$ex_b8_data['p1863_fac']=$prod->xss_fix($_POST['p1863_fac'] ?? 1.0);

			$ex_b8_data['p1866_fac']=$prod->xss_fix($_POST['p1866_fac'] ?? 1.0);



			$prod->update_o_desc_ex_b8(json_encode($ex_b8_data));

		}
	}


	//b3 in



	$in_b3_data['o_id']=$prod->xss_fix($_POST['o_id']);



	$old_o_desc_in_b3=$prod->get_o_desc_in_b3($in_b3_data['o_id']);



	if(!empty($old_o_desc_in_b3))

	{

	$in_b3_data['col_price_in_b3']=$prod->xss_fix($_POST['col_price_in_b3'] ?? 0.0);

	$in_b3_data['fac_cl_in_b3']=$prod->xss_fix($_POST['fac_cl_in_b3'] ?? 1.0);

	$in_b3_data['o_price_in_b3']=$prod->xss_fix($_POST['o_price_in_b3'] ?? 0.0);



	$in_b3_data['col_apus_in_b3']=$prod->xss_fix($_POST['col_apus_in_b3'] ?? 0.0);

	$in_b3_data['fac_prod_in_b3']=$prod->xss_fix($_POST['fac_prod_in_b3'] ?? 1.0);

	$in_b3_data['o_apus_in_b3']=$prod->xss_fix($_POST['o_apus_in_b3'] ?? 0.0);



	$in_b3_data['col_labc_in_b3']=$prod->xss_fix($_POST['col_labc_in_b3'] ?? 0.0);

	$in_b3_data['fac_labc_in_b3']=$prod->xss_fix($_POST['fac_labc_in_b3'] ?? 1.0);

	$in_b3_data['total_labcs_in_b3']=$prod->xss_fix($_POST['total_labcs_in_b3'] ?? 0.0);



    $in_b3_data['p1301_fac']=$prod->xss_fix($_POST['p1301_fac'] ?? 1.0);

    $in_b3_data['p1302_fac']=$prod->xss_fix($_POST['p1302_fac'] ?? 1.0);

    $in_b3_data['p1321_fac']=$prod->xss_fix($_POST['p1321_fac'] ?? 1.0);

    $in_b3_data['p1322_fac']=$prod->xss_fix($_POST['p1322_fac'] ?? 1.0);



	$prod->update_o_desc_in_b32(json_encode($in_b3_data));

	}



	//b5 in



	$in_b5_data['o_id']=$prod->xss_fix($_POST['o_id']);



	$old_o_desc_in_b5=$prod->get_o_desc_in_b5($in_b5_data['o_id']);



	if(!empty($old_o_desc_in_b5))

	{

	$in_b5_data['col_price_in_b5']=$prod->xss_fix($_POST['col_price_in_b5'] ?? 0.0);

	$in_b5_data['fac_cl_in_b5']=$prod->xss_fix($_POST['fac_cl_in_b5'] ?? 1.0);

	$in_b5_data['o_price_in_b5']=$prod->xss_fix($_POST['o_price_in_b5'] ?? 0.0);



	$in_b5_data['col_apus_in_b5']=$prod->xss_fix($_POST['col_apus_in_b5'] ?? 0.0);

	$in_b5_data['fac_prod_in_b5']=$prod->xss_fix($_POST['fac_prod_in_b5'] ?? 1.0);

	$in_b5_data['o_apus_in_b5']=$prod->xss_fix($_POST['o_apus_in_b5'] ?? 0.0);



	$in_b5_data['col_labc_in_b5']=$prod->xss_fix($_POST['col_labc_in_b5'] ?? 0.0);

	$in_b5_data['fac_labc_in_b5']=$prod->xss_fix($_POST['fac_labc_in_b5'] ?? 1.0);

	$in_b5_data['total_labcs_in_b5']=$prod->xss_fix($_POST['total_labcs_in_b5'] ?? 0.0);



    $in_b5_data['p1501_fac']=$prod->xss_fix($_POST['p1501_fac'] ?? 1.0);

    $in_b5_data['p1504_fac']=$prod->xss_fix($_POST['p1504_fac'] ?? 1.0);

    $in_b5_data['p1506_fac']=$prod->xss_fix($_POST['p1506_fac'] ?? 1.0);



    $in_b5_data['p1521_fac']=$prod->xss_fix($_POST['p1521_fac'] ?? 1.0);

    $in_b5_data['p1524_fac']=$prod->xss_fix($_POST['p1524_fac'] ?? 1.0);

    $in_b5_data['p1526_fac']=$prod->xss_fix($_POST['p1526_fac'] ?? 1.0);



    $in_b5_data['p1541_fac']=$prod->xss_fix($_POST['p1541_fac'] ?? 1.0);

    $in_b5_data['p1544_fac']=$prod->xss_fix($_POST['p1544_fac'] ?? 1.0);

    $in_b5_data['p1546_fac']=$prod->xss_fix($_POST['p1546_fac'] ?? 1.0);



	$prod->update_o_desc_in_b52(json_encode($in_b5_data));

	}



    //b6 in



	$in_b6_data['o_id']=$prod->xss_fix($_POST['o_id']);



	$old_o_desc_in_b6=$prod->get_o_desc_in_b6($in_b6_data['o_id']);



	if(!empty($old_o_desc_in_b6))

	{

	$in_b6_data['col_price_in_b6']=$prod->xss_fix($_POST['col_price_in_b6'] ?? 0.0);

	$in_b6_data['fac_cl_in_b6']=$prod->xss_fix($_POST['fac_cl_in_b6'] ?? 1.0);

	$in_b6_data['o_price_in_b6']=$prod->xss_fix($_POST['o_price_in_b6'] ?? 0.0);



	$in_b6_data['col_apus_in_b6']=$prod->xss_fix($_POST['col_apus_in_b6'] ?? 0.0);

	$in_b6_data['fac_prod_in_b6']=$prod->xss_fix($_POST['fac_prod_in_b6'] ?? 1.0);

	$in_b6_data['o_apus_in_b6']=$prod->xss_fix($_POST['o_apus_in_b6'] ?? 0.0);



	$in_b6_data['col_labc_in_b6']=$prod->xss_fix($_POST['col_labc_in_b6'] ?? 0.0);

	$in_b6_data['fac_labc_in_b6']=$prod->xss_fix($_POST['fac_labc_in_b6'] ?? 1.0);

	$in_b6_data['total_labcs_in_b6']=$prod->xss_fix($_POST['total_labcs_in_b6'] ?? 0.0);



    $in_b6_data['p1600_fac']=$prod->xss_fix($_POST['p1600_fac'] ?? 1.0);

    $in_b6_data['p1601_fac']=$prod->xss_fix($_POST['p1601_fac'] ?? 1.0);

    $in_b6_data['p1604_fac']=$prod->xss_fix($_POST['p1604_fac'] ?? 1.0);

    $in_b6_data['p1606_fac']=$prod->xss_fix($_POST['p1606_fac'] ?? 1.0);



    $in_b6_data['p1621_fac']=$prod->xss_fix($_POST['p1621_fac'] ?? 1.0);

    $in_b6_data['p1624_fac']=$prod->xss_fix($_POST['p1624_fac'] ?? 1.0);

    $in_b6_data['p1626_fac']=$prod->xss_fix($_POST['p1626_fac'] ?? 1.0);



    $in_b6_data['p1641_fac']=$prod->xss_fix($_POST['p1641_fac'] ?? 1.0);

    $in_b6_data['p1644_fac']=$prod->xss_fix($_POST['p1644_fac'] ?? 1.0);

    $in_b6_data['p1646_fac']=$prod->xss_fix($_POST['p1646_fac'] ?? 1.0);



	$prod->update_o_desc_in_b6(json_encode($in_b6_data));

    }



	//b7 in



	$in_b7_data['o_id']=$prod->xss_fix($_POST['o_id']);



	$old_o_desc_in_b7=$prod->get_o_desc_in_b7($in_b7_data['o_id']);



	if(!empty($old_o_desc_in_b7))

	{

	$in_b7_data['col_price_in_b7']=$prod->xss_fix($_POST['col_price_in_b7'] ?? 0.0);

	$in_b7_data['fac_cl_in_b7']=$prod->xss_fix($_POST['fac_cl_in_b7'] ?? 1.0);

	$in_b7_data['o_price_in_b7']=$prod->xss_fix($_POST['o_price_in_b7'] ?? 0.0);



	$in_b7_data['col_apus_in_b7']=$prod->xss_fix($_POST['col_apus_in_b7'] ?? 0.0);

	$in_b7_data['fac_prod_in_b7']=$prod->xss_fix($_POST['fac_prod_in_b7'] ?? 1.0);

	$in_b7_data['o_apus_in_b7']=$prod->xss_fix($_POST['o_apus_in_b7'] ?? 0.0);



	$in_b7_data['col_labc_in_b7']=$prod->xss_fix($_POST['col_labc_in_b7'] ?? 0.0);

	$in_b7_data['fac_labc_in_b7']=$prod->xss_fix($_POST['fac_labc_in_b7'] ?? 1.0);

	$in_b7_data['total_labcs_in_b7']=$prod->xss_fix($_POST['total_labcs_in_b7'] ?? 0.0);



    $in_b7_data['p1700_fac']=$prod->xss_fix($_POST['p1700_fac'] ?? 1.0);

    $in_b7_data['p1701_fac']=$prod->xss_fix($_POST['p1701_fac'] ?? 1.0);

    $in_b7_data['p1704_fac']=$prod->xss_fix($_POST['p1704_fac'] ?? 1.0);

    $in_b7_data['p1706_fac']=$prod->xss_fix($_POST['p1706_fac'] ?? 1.0);



    $in_b7_data['p1721_fac']=$prod->xss_fix($_POST['p1721_fac'] ?? 1.0);

    $in_b7_data['p1724_fac']=$prod->xss_fix($_POST['p1724_fac'] ?? 1.0);

    $in_b7_data['p1726_fac']=$prod->xss_fix($_POST['p1726_fac'] ?? 1.0);



    $in_b7_data['p1741_fac']=$prod->xss_fix($_POST['p1741_fac'] ?? 1.0);

    $in_b7_data['p1744_fac']=$prod->xss_fix($_POST['p1744_fac'] ?? 1.0);

    $in_b7_data['p1746_fac']=$prod->xss_fix($_POST['p1746_fac'] ?? 1.0);



	$prod->update_o_desc_in_b72(json_encode($in_b7_data));

    }



    //b8 in



	$in_b8_data['o_id']=$prod->xss_fix($_POST['o_id']);



	$old_o_desc_in_b8=$prod->get_o_desc_in_b8($in_b8_data['o_id']);


	if(!empty($old_o_desc_in_b8))
	{
		if(count($old_o_desc_in_b8)>0)

		{

			$in_b8_data['col_price_in_b8']=$prod->xss_fix($_POST['col_price_in_b8'] ?? 0.0);

			$in_b8_data['fac_cl_in_b8']=$prod->xss_fix($_POST['fac_cl_in_b8'] ?? 1.0);

			$in_b8_data['o_price_in_b8']=$prod->xss_fix($_POST['o_price_in_b8'] ?? 0.0);



			$in_b8_data['col_apus_in_b8']=$prod->xss_fix($_POST['col_apus_in_b8'] ?? 0.0);

			$in_b8_data['fac_prod_in_b8']=$prod->xss_fix($_POST['fac_prod_in_b8'] ?? 1.0);

			$in_b8_data['o_apus_in_b8']=$prod->xss_fix($_POST['o_apus_in_b8'] ?? 0.0);



			$in_b8_data['col_labc_in_b8']=$prod->xss_fix($_POST['col_labc_in_b8'] ?? 0.0);

			$in_b8_data['fac_labc_in_b8']=$prod->xss_fix($_POST['fac_labc_in_b8'] ?? 1.0);

			$in_b8_data['total_labcs_in_b8']=$prod->xss_fix($_POST['total_labcs_in_b8'] ?? 0.0);



			$in_b8_data['p1800_fac']=$prod->xss_fix($_POST['p1800_fac'] ?? 1.0);

			$in_b8_data['p1801_fac']=$prod->xss_fix($_POST['p1801_fac'] ?? 1.0);

			$in_b8_data['p1804_fac']=$prod->xss_fix($_POST['p1804_fac'] ?? 1.0);

			$in_b8_data['p1806_fac']=$prod->xss_fix($_POST['p1806_fac'] ?? 1.0);



			$in_b8_data['p1821_fac']=$prod->xss_fix($_POST['p1821_fac'] ?? 1.0);

			$in_b8_data['p1824_fac']=$prod->xss_fix($_POST['p1824_fac'] ?? 1.0);

			$in_b8_data['p1826_fac']=$prod->xss_fix($_POST['p1826_fac'] ?? 1.0);



			$in_b8_data['p1841_fac']=$prod->xss_fix($_POST['p1841_fac'] ?? 1.0);

			$in_b8_data['p1844_fac']=$prod->xss_fix($_POST['p1844_fac'] ?? 1.0);

			$in_b8_data['p1846_fac']=$prod->xss_fix($_POST['p1846_fac'] ?? 1.0);



			$prod->update_o_desc_in_b8(json_encode($in_b8_data));

		}
	}

	if(isset($_POST['accept_btn']))
	{			
		if($new_order['notifications']==1)
		{
		?>
		<meta http-equiv="refresh" content="1; url=confirmation1.php?o_id=<?php echo $new_order['order_ID']; ?>">
		<?php
		}
		else
		{
			?>						
			<meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $update_data['o_id'];?>&status=accepted">
			<?php
		}	
	}
	else
	{
		?>						
		<meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $update_data['o_id'];?>&status=accepted">
		<?php
	}
	

	?>

	

	<?php

}



if(isset($_POST['delete_btn']))

{

	$of_id=$_POST['of_id'];



	$prod->delete_customer_file($of_id);

	?>

	<div class="text-center"> <div class="alert alert-success">File deleted !</div></div><br>

	<?php

}



//acceptance variables





$o_correction=$prod->xss_fix($_GET['o_correction']);





$o_id=$prod->xss_fix($_GET['o_id']) ?? 0;





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



<input type="hidden" id="o_id" name="o_id" value="<?php echo $o_id; ?>" form="order_details">

<input type="hidden" name="o_correction" value="<?php echo $o_correction; ?>" form="order_details">

<input type="hidden" name="clientid" value="<?php echo $clientid; ?>" form="order_details">

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_COOKIE['client_id']; ?>" form="order_details">

<input type="hidden" name="licenceid" value="<?php echo $licid; ?>" form="order_details">

<input type="hidden" name="client_language_id" value="<?php echo $order['client_language_id']; ?>" form="order_details">

<input type="hidden" name="ls_id" value="<?php echo $order['ls_id']; ?>" form="order_details">

<input type="hidden" name="cur_id" value="<?php echo $order['cur_id']; ?>" form="order_details">



<div class="row w-100 mx-0">

	<div class="col-md-6 border py-2" style="background: #c0ba55">

	<b>Website = </b> <?php

    $website=$prod->get_order_website($order['ls_id']);

    echo $website['ls_name'];?> - Accepted by <?php

    if($order['accepted_by']==0)

    {

        echo "<b>nobody</b> yet";

    }

    else

    {

        $creator=$prod->get_client($order['accepted_by']);

        echo $creator['c_last_name'].", ".$creator['c_first_name'];

    }?><br>



	<b>Order ID:</b> <?php echo $o_id; ?> <br>



	<b>Correction/Amendment to:</b> <a href="orderdetails.php?o_id=<?php echo $order['om_id'];?>&status=accepted" target="_blank"><?php echo $order['om_id'];?></a>

	<?php

	$licence_taker=$prod->get_licence_taker($o_id);

	?>

	<br>Trader = Licence ID: <?php echo $order['lic_ID']; ?> - <?php echo $licence_taker['Company']." - ".$licence_taker['contact-persons-for-us']." - ".$licence_taker['phone']; ?>

	<br>



	<div class="p-1" style="background-color:#bad4ff">

		<div class="row">
			<div class="col-md-12 d-flex">
				Purchaser = Client ID: <input type="text" class="form-control form-control-sm" name="purchaser_client_id" id="purchaser_client_id" value="<?php echo $client['client_ID']; ?>" style="width:5em;">
				&nbsp;<button id="change_purchaser_client_id_btn" class="btn btn-sm btn-primary">Change client_ID</button>

				<script type="text/javascript">
				$(document).ready(function(){
					$('#change_purchaser_client_id_btn').click(function(){

						if(confirm("Are you sure you want to change the client ID ?"))
						{
							$.ajax({
								url: "<?php echo $base_url;?>ajax/change_order_client_id.php",
								method: "post",
								data: {o_id:$('#o_id').val(),client_id:$('#purchaser_client_id').val()},
								dataType:"html",
								success:function(data) {
									console.log(data);
								}
							});
						}

					});
				});
				</script>
			</div>
			<div class="row">
				<div class="col-md-12 d-flex">
				-  Enterprise: <?php echo $client['clientname']; ?>
				<?php
				if(!empty($client['c_last_name']))
				{
					echo $client['c_title']." ".$client['c_first_name']." ".$client['c_last_name'];
				}
				else
				{
					echo $client['l_title']." ".$client['l_first_name']." ".$client['l_last_name'];
				} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 d-flex">
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
		</div>
	</div>


	<br>

	<div class="inline-flex">

		<b class="pt-1 mr-2">Project name: </b><input type="text" class="form-control form-control-sm" name="order_name" value="<?php echo $order['order_name']; ?>" style="width:250px;" form="order_details" required>

	</div>

	<br>

        <div class="form-group">

            <p class="d-inline"><b>Deadline UTC+0: </b></p>

            <input type="text" class="form-control form-control-sm text-danger d-inline" id="o_deadline" name="o_deadline" value="<?php echo $order['o_deadline']; ?>" style="width:250px;" form="order_details" autocomplete="off">

            <script type="text/javascript">

            $(document).ready(function(){

                $('#o_deadline').datetimepicker({

                    format:'Y-m-d H:i'

                });

            });

            </script>

        </div>

		<div class="form-group d-flex">

            <p class=""><b>This order is marked as : </b></p>

            <select id="o_correction_amendment" class="form-control form-control-sm " style="width:13em;" <?php if($order['om_id']==0) { ?>form="order_details"<?php }?>>
				<option value="">--Select--</option>
				<option value="correction" <?php echo ($order['o_correction']==1)?"selected":"";?>>Correction</option>
				<option value="amendment" <?php echo ($order['o_amendment']==1)?"selected":"";?>>Amendment</option>
			</select>
			<?php
			if($order['om_id']!=0)
			{
				?>
				<script type="text/javascript">

				$(document).ready(function(){

					$('#o_correction_amendment').on('change',function(){

						if(confirm('Are you sure you want to change ?'))
						{
							let correction_amendment= $('#o_correction_amendment').val();


							$.ajax({
								url: "../ajax/change_o_correction_amendment.php",
								method: "get",
								data: {correction_amendment:correction_amendment,o_id:<?php echo $o_id;?>},
								dataType:"html",
								success:function(data) {
									console.log(data);
								}
							});

						}

					});

				});

				</script>
			<?php
			}
			?>
        </div>

	</div>



	<div class="col-md-6 border">

		<label class="pt-4" for="allmessages">Comunications</label>

		<!-- <textarea id="allmessages" class="form-control" name="allmessages" rows="2" cols="6" placeholder="No messages yet" readonly><?php

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

		</textarea> -->



        <div class="row mx-0 w-100 border my-3" id="chat" style="min-height: 300px;">

        <?php



        $allmessages=$prod->get_all_trader_purchaser_messages($o_id);



        for($i=0;$i<count($allmessages);$i++)

        {

            if($allmessages[$i]['client_id']>0)

            {

                $client=$prod->get_client($allmessages[$i]['client_id']);

            }

            elseif($allmessages[$i]['uca_id']>0)

            {

                $creator=$prod->get_client($allmessages[$i]['uca_id']);

            }

        ?>

        <div class="row mx-0 w-100 d-flex pt-2 <?php

                if($allmessages[$i]['client_id']>0)

                {

                    echo "justify-content-end";

                }

                elseif($allmessages[$i]['uca_id']>0)

                {

                    echo "justify-content-start";

                }?>">

            <div class="col-8 d-flex justify-content-end text-muted <?php

                if($allmessages[$i]['client_id']>0)

                {

                    echo "clientname";

                }

                elseif($allmessages[$i]['uca_id']>0)

                {

                    echo "companyname";

                }?>" style="font-size: 14px;">

                <span class="d-inline"><i class="fas fa-user"></i></span>

                <p class="mb-0 d-inline"><?php

                //Petra Plitt (2018-06-30 08:26:44 UTC +0):

                if($allmessages[$i]['client_id']>0)

                {

                    echo $client['l_first_name']." ".$client['l_last_name'];

                }

                elseif($allmessages[$i]['uca_id']>0)

                {

                    if(!empty($creator['c_last_name']))

                    {

                        echo $creator['c_first_name']." ".$creator['c_last_name'];

                    }

                    else

                    {

                        echo $creator['l_first_name']." ".$creator['l_last_name'];

                    }

                }



                echo " (".$allmessages[$i]['msg_date']." UTC+0):"; ?></p>

            </div>

            <div class="col-8 justify-content-end <?php

                if($allmessages[$i]['client_id']>0)

                {

                    echo "clientmessage";

                }

                elseif($allmessages[$i]['uca_id']>0)

                {

                    echo "companymessage";

                }?>" style="font-size: 14px;">

                <p class="mb-0 text-right py-2">

                    <?php echo $allmessages[$i]['message']; ?>

                </p>

            </div>

        </div>

        <?php

        }

        ?>



    </div>

		<br>

		<?php

		if(!isset($_GET['status']))

		{

		?>

		<button name="accept_btn" class="btn btn-primary btn-sm" form="order_details">Accept</button>

		<?php

		}

		?>

		<a href="message_to_client.php?o_id=<?php echo $o_id; ?>" class="btn btn-warning btn-sm">Message to client</a>

		<?php

		if(!isset($_GET['status']))

		{

		?>

		<a href="index.php?orderstatus=1-9" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">Reject</a>

		<?php

		}

		?>

	</div>



</div>



<?php

if(isset($_GET['o_correction']))

{

    $b3_in_prods=$prod->get_b3_in_ordered_products($order['order_ID']);

    $b5_in_products=$prod->get_b5_in_ordered_products($order['order_ID']);

    $b6_in_products=$prod->get_b6_in_ordered_products($order['order_ID']);

    $b7_in_products=$prod->get_b7_in_ordered_products($order['order_ID']);

    $b8_in_products=$prod->get_b8_in_ordered_products($order['order_ID']);



    $b5_ex_products=$prod->get_b5_ex_ordered_products($order['order_ID']);

    $b6_ex_products=$prod->get_b6_ex_ordered_products($order['order_ID']);

    $b7_ex_products=$prod->get_b7_ex_ordered_products($order['order_ID']);

    $b8_ex_products=$prod->get_b8_ex_ordered_products($order['order_ID']);



    $o_desc_in_b3=$prod->get_o_desc_in_b3($order['order_ID']);

    $o_desc_in_b5=$prod->get_o_desc_in_b5($order['order_ID']);

    $o_desc_in_b6=$prod->get_o_desc_in_b6($order['order_ID']);

    $o_desc_in_b7=$prod->get_o_desc_in_b7($order['order_ID']);

    $o_desc_in_b8=$prod->get_o_desc_in_b8($order['order_ID']);



    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($order['order_ID']);

    $o_desc_ex_b6=$prod->get_o_desc_ex_b6($order['order_ID']);

    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($order['order_ID']);

    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($order['order_ID']);

}

else

{

    $b3_in_prods=$prod->get_b3_in_ordered_products($old_order['order_ID']);

    $b5_in_products=$prod->get_b5_in_ordered_products($old_order['order_ID']);

    $b6_in_products=$prod->get_b6_in_ordered_products($old_order['order_ID']);

    $b7_in_products=$prod->get_b7_in_ordered_products($old_order['order_ID']);

    $b8_in_products=$prod->get_b8_in_ordered_products($old_order['order_ID']);



    $b5_ex_products=$prod->get_b5_ex_ordered_products($old_order['order_ID']);

    $b6_ex_products=$prod->get_b6_ex_ordered_products($old_order['order_ID']);

    $b7_ex_products=$prod->get_b7_ex_ordered_products($old_order['order_ID']);

    $b8_ex_products=$prod->get_b8_ex_ordered_products($old_order['order_ID']);



    $o_desc_in_b3=$prod->get_o_desc_in_b3($o_id);

    $o_desc_in_b5=$prod->get_o_desc_in_b5($o_id);

    $o_desc_in_b6=$prod->get_o_desc_in_b6($o_id);

    $o_desc_in_b7=$prod->get_o_desc_in_b7($o_id);

    $o_desc_in_b8=$prod->get_o_desc_in_b8($o_id);



    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_id);

    $o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_id);

    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_id);

    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_id);

}



$allstatus=$prod->showallstatus();

$osub_id=1;

$global_column_count=1;



?>

<div class="interior">

    <div class="row w-100 mx-0 pt-4">

        <div class="col-md-2">

            <h5 class="text-success w-100 text-center">Interior</h5>

        </div>

        <div class="col-md-2">

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb3" data-target="#interiorb3" data-toggle="collapse">B3 interior - Corel</button>

        </div>

        <?php

        if($_COOKIE['lt_id']!=9)

        {

            ?>

            <div class="col-md-2" style="background-color:#c9c995;">

            <?php

            if(count($b5_in_products)==0)

            {

                ?>

                <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="inbtnb5" data-target="#interiorb5" data-toggle="collapse"><del>B5 interior - Sketchup</del></button>

                <span class="text-danger">No interior ordered</span>

                <?php

            }

            else

            {

        ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb5" data-target="#interiorb5" data-toggle="collapse">B5 interior - Sketchup</button>

        <?php

            }

            ?>

            </div>

            <?php

        }

        ?>

        <div class="col-md-2" style="background-color:#c9c995;">



            <?php

            if(count($b6_in_products)==0)

            {

            ?>

            <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="inbtnb6" data-target="#interiorb6" data-toggle="collapse"><del>B6 interior - Twinmotion</del></button>

            <span class="text-danger">No interior ordered</span>

            <?php

            }

            else

            {

            ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb6" data-target="#interiorb6" data-toggle="collapse">B6 interior - Twinmotion</button>

            <?php

            }

            ?>

        </div>

        <?php

        if($_COOKIE['lt_id']!=9)

        {

            ?>

            <div class="col-md-2" style="background-color:#a3a373;">

            <?php

            if(count($b7_in_products)==0)

            {

            ?>

            <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="inbtnb7" data-target="#interiorb7" data-toggle="collapse"><del>B7 interior - 3ds Max</del></button>

            <span class="text-danger">No interior ordered</span>

            <?php

            }

            else

            {

            ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb7" data-target="#interiorb7" data-toggle="collapse">B7 interior - 3ds Max</button>

            <?php

            }

            ?>

            </div>

            <div class="col-md-2" style="background-color:#a3a373;">

            <?php

            if(count($b8_in_products)==0)

            {

            ?>

            <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="inbtnb8" data-target="#interiorb8" data-toggle="collapse"><del>B8 interior - Lumion</del></button>

            <span class="text-danger">No interior ordered</span>

            <?php

            }

            else

            {

            ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb8" data-target="#interiorb8" data-toggle="collapse">B8 interior - Lumion</button>

            <?php

            }

            ?>

            </div>

            <?php

        }

        ?>

    </div>

<?php



if(!empty($b3_in_prods))

{

?>

<div class="col-md-12 px-0 collapse" id="interiorb3">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php



for($l=0;$l<count($b3_in_prods);$l++)

{



    $product=$prod->get_product($b3_in_prods[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b3_in_prods[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b3_in_prods[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b3_in_prods[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b3_in_prods[$l]['osub_id'];

    $data['prod_id']=$b3_in_prods[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

		?> d-inline-flex" style=""><?php echo $order['om_id'].".".$b3_in_prods[$l]['osub_id'].".".$b3_in_prods[$l]['prod_id'].".".$o_id; ?>

        <input type="text" class="form-control form-control-sm b3_in_multiplicator <?php echo $b3_in_prods[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b3_in_prods[$l]['prod_id']."_fac";?>" name="<?php echo $b3_in_prods[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b3[$b3_in_prods[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b3[$b3_in_prods[$l]['prod_id']."_fac"];

        }?>" form="order_details">

        <span class="correction_text_green">&nbsp; <?php echo $product_apu; ?></span>

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

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>">Correct &nbsp; <span class="correction_text_free" id="free">(Free)</span></label>

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



                <input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



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

    </div> <!--end box -->

<?php

    }//end if something is checked

} //end for

?>



        </div> <!-- not hidden tasks -->



        <div class="col-md-6">

            <button class="btn btn-sm btn-primary" id="b3inhiddentasks" data-target="#show_b3inhiddentasks" data-toggle="collapse" aria-expanded="<?php

            if(isset($_GET['o_correction']))

            {

                echo "true";

            }

            else

            {

                echo "false";

            }

            ?>">Show B3 Corel hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }?>" id="show_b3inhiddentasks">

<?php

for($l=0;$l<count($b3_in_prods);$l++)

{



    $product=$prod->get_product($b3_in_prods[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b3_in_prods[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b3_in_prods[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b3_in_prods[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b3_in_prods[$l]['osub_id'];

    $data['prod_id']=$b3_in_prods[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b3_in_prods[$l]['osub_id'].".".$b3_in_prods[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b3_in_multiplicator <?php echo $b3_in_prods[$l]['prod_id']."_fac";?>" id="<?php echo $b3_in_prods[$l]['prod_id']."_fac";?>" name="<?php echo $b3_in_prods[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" value="<?php

        if(empty($o_desc_in_b3[$b3_in_prods[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b3[$b3_in_prods[$l]['prod_id']."_fac"];

        }?>" form="order_details">

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

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b3_in_prods[$l]['osub_id']."_".$b3_in_prods[$l]['prod_id'];?>">Correct <span class="green" id="free">(Free)</span></label>

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



                <input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b3_in_prods[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b3hiddentasks -->

        </div> <!-- end hidden tasks -->

        </div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col IN B3 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_in_b3" id="col_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_labc_in_b3']))?$o_desc_in_b3['col_labc_in_b3']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b3 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b3" id="fac_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_labc_in_b3']))?$o_desc_in_b3['fac_labc_in_b3']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b3" id="total_labcs_in_b3" value="<?php echo (!empty($o_desc_in_b3['total_labcs_in_b3']))?$o_desc_in_b3['total_labcs_in_b3']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>

<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col IN B3 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_in_b3" id="col_apus_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_apus_in_b3']))?$o_desc_in_b3['col_apus_in_b3']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b3 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b3" id="fac_prod_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_prod_in_b3']))?$o_desc_in_b3['fac_prod_in_b3']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b3" id="o_apus_in_b3" value="<?php echo (!empty($o_desc_in_b3['o_apus_in_b3']))?$o_desc_in_b3['o_apus_in_b3']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>

<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col IN B3 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_in_b3" id="col_price_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_price_in_b3']))?$o_desc_in_b3['col_price_in_b3']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_in_b3 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b3" id="fac_cl_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_cl_in_b3']))?$o_desc_in_b3['fac_cl_in_b3']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_in_b3" id="o_price_in_b3" value="<?php echo (!empty($o_desc_in_b3['o_price_in_b3']))?$o_desc_in_b3['o_price_in_b3']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>



</div> <!-- end b3 -->

<?php

} //end b3 in





//start b5 in



if(!empty($b5_in_products))

{

?>

    <div class="col-md-12 px-0 collapse" id="interiorb5" style="background-color:#c9c995;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b5_in_products);$l++)

{

    $product=$prod->get_product($b5_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b5_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b5_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b5_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b5_in_products[$l]['osub_id'];

    $data['prod_id']=$b5_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b5_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> d-inline-flex" style="text-align:center;"><?php echo $order['om_id'].".".$b5_in_products[$l]['osub_id'].".".$b5_in_products[$l]['prod_id'].".".$o_id; ?> - <?php //echo $product_price." ".$currency;?>

        <input type="text" class="form-control form-control-sm b5_in_multiplicator <?php echo $b5_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b5_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b5_in_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b5[$b5_in_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b5[$b5_in_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b5_in_products[$l]['osub_id'].".".$b5_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b5" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b5_in_products[$l]['osub_id'].".".$b5_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b5_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b5";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b5_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b5";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b5_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b5";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if someting is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

    <button class="btn btn-sm btn-primary" id="b5inhiddentasks" data-target="#show_b5inhiddentasks" data-toggle="collapse" aria-expanded="<?php

    if(isset($_GET['o_correction']))

    {

        echo "true";

    }

    else

    {

        echo "false";

    }?>">Show B5 Sketchup hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }?>" id="show_b5inhiddentasks">

<?php

for($l=0;$l<count($b5_in_products);$l++)

{



    $product=$prod->get_product($b5_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b5_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b5_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b5_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b5_in_products[$l]['osub_id'];

    $data['prod_id']=$b5_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b5_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b5_in_products[$l]['osub_id'].".".$b5_in_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b5_in_multiplicator <?php echo $b5_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b5_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b5_in_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b5[$b5_in_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b5[$b5_in_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b5_in_products[$l]['osub_id'].".".$b5_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>">Correct <span class="green" id="free">(Free)</span></label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b5" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b5_in_products[$l]['osub_id'].".".$b5_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b5_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b5";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b5_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b5";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b5_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b5_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b5";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_in_products[$l]['osub_id']."_".$b5_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b5hiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col IN B5 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_in_b5" id="col_labc_in_b5" value="<?php echo (!empty($o_desc_in_b5['col_labc_in_b5']))?$o_desc_in_b5['col_labc_in_b5']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b5 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b5" id="fac_labc_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b5" id="total_labcs_in_b5" value="<?php echo (!empty($o_desc_in_b5['total_labcs_in_b5']))?$o_desc_in_b5['total_labcs_in_b5']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col IN B5 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_in_b5" id="col_apus_in_b5" value="<?php echo (!empty($o_desc_in_b5['col_apus_in_b5']))?$o_desc_in_b5['col_apus_in_b5']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b5 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b5" id="fac_prod_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b5" id="o_apus_in_b5" value="<?php echo (!empty($o_desc_in_b5['o_apus_in_b5']))?$o_desc_in_b5['o_apus_in_b5']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col IN B5 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_in_b5" id="col_price_in_b5" value="<?php echo (!empty($o_desc_in_b5['col_price_in_b5']))?$o_desc_in_b5['col_price_in_b5']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_in_b5 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b5" id="fac_cl_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_in_b5" id="o_price_in_b5" value="<?php echo (!empty($o_desc_in_b5['o_price_in_b5']))?$o_desc_in_b5['o_price_in_b5']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>




</div> <!-- end b5 -->

<?php

}



//end b5 in



//start b6 in



if(!empty($b6_in_products))

{

?>

    <div class="col-md-12 px-0 collapse" id="interiorb6" style="background-color:#c9c995;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b6_in_products);$l++)

{

    $product=$prod->get_product($b6_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b6_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b6_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b6_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b6_in_products[$l]['osub_id'];

    $data['prod_id']=$b6_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b6_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b6_in_products[$l]['osub_id'].".".$b6_in_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b6_in_multiplicator <?php echo $b6_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b6_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b6_in_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b6[$b6_in_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b6[$b6_in_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b6_in_products[$l]['osub_id'].".".$b6_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>">Correct <span class="green" id="free">(Free)</span></label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b6" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b6_in_products[$l]['osub_id'].".".$b6_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b6_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b6";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b6_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b6";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b6_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b6";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    } //end if something is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

    <button class="btn btn-sm btn-primary" id="b6inhiddentasks" data-target="#show_b6inhiddentasks" data-toggle="collapse" aria-expanded="<?php

    if(isset($_GET['o_correction']))

    {

        echo "true";

    }

    else

    {

        echo "false";

    }?>">Show B6 Twinmotion hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }?>" id="show_b6inhiddentasks">

<?php

for($l=0;$l<count($b6_in_products);$l++)

{



    $product=$prod->get_product($b6_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b6_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b6_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b6_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b6_in_products[$l]['osub_id'];

    $data['prod_id']=$b6_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b6_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b6_in_products[$l]['osub_id'].".".$b6_in_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b6_in_multiplicator <?php echo $b6_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b6_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b6_in_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b6[$b6_in_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b6[$b6_in_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b6_in_products[$l]['osub_id'].".".$b6_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b6" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b6_in_products[$l]['osub_id'].".".$b6_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b6_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b6";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b6_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b6";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b6_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b6_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b6";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_in_products[$l]['osub_id']."_".$b6_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b6inhiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col IN B6 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_in_b6" id="col_labc_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_labc_in_b6']))?$o_desc_in_b6['col_labc_in_b6']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b6 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b6" id="fac_labc_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_labc_in_b6']))?$o_desc_in_b6['fac_labc_in_b6']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b6" id="total_labcs_in_b6" value="<?php echo (!empty($o_desc_in_b6['total_labcs_in_b6']))?$o_desc_in_b6['total_labcs_in_b6']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col IN B6 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_in_b6" id="col_apus_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_apus_in_b6']))?$o_desc_in_b6['col_apus_in_b6']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b6 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b6" id="fac_prod_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_prod_in_b6']))?$o_desc_in_b6['fac_prod_in_b6']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b6" id="o_apus_in_b6" value="<?php echo (!empty($o_desc_in_b6['o_apus_in_b6']))?$o_desc_in_b6['o_apus_in_b6']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col IN B6 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_in_b6" id="col_price_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_price_in_b6']))?$o_desc_in_b6['col_price_in_b6']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_in_b6 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b6" id="fac_cl_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_cl_in_b6']))?$o_desc_in_b6['fac_cl_in_b6']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_in_b6" id="o_price_in_b6" value="<?php echo (!empty($o_desc_in_b6['o_price_in_b6']))?$o_desc_in_b6['o_price_in_b6']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>




</div>

<?php

}



//end b6 in





//start b7 in



if(!empty($b7_in_products))

{

?>

    <div class="col-md-12 px-0 collapse" id="interiorb7" style="background-color:#a3a373;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b7_in_products);$l++)

{

    $product=$prod->get_product($b7_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b7_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b7_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b7_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b7_in_products[$l]['osub_id'];

    $data['prod_id']=$b7_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b7_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b7_in_products[$l]['osub_id'].".".$b7_in_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b7_in_multiplicator <?php echo $b7_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b7_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b7_in_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b7[$b7_in_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b7[$b7_in_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b7_in_products[$l]['osub_id'].".".$b7_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b7" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b7_in_products[$l]['osub_id'].".".$b7_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b7_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b7";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b7_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b7";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b7_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b7";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    } //end if something is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

    <button class="btn btn-sm btn-primary" id="b7inhiddentasks" data-target="#show_b7inhiddentasks" data-toggle="collapse" aria-expanded="<?php

    if(isset($_GET['o_correction']))

    {

        echo "true";

    }

    else

    {

        echo "false";

    }?>">Show B7 3ds Max hidden tasks</button>

        <div class="col-md-12 <?php

    if(!isset($_GET['o_correction']))

    {

        echo "collapse";

    }?>" id="show_b7inhiddentasks">

<?php

for($l=0;$l<count($b7_in_products);$l++)

{



    $product=$prod->get_product($b7_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b7_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b7_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b7_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b7_in_products[$l]['osub_id'];

    $data['prod_id']=$b7_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b7_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b7_in_products[$l]['osub_id'].".".$b7_in_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b7_in_multiplicator <?php echo $b7_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b7_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b7_in_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b7[$b7_in_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b7[$b7_in_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b7_in_products[$l]['osub_id'].".".$b7_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b7" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b7_in_products[$l]['osub_id'].".".$b7_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b7_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b7";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b7_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b7";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b7_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b7_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b7";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_in_products[$l]['osub_id']."_".$b7_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b7inhiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col IN B7 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_in_b7" id="col_labc_in_b7" value="<?php echo (!empty($o_desc_in_b7['col_labc_in_b7']))?$o_desc_in_b7['col_labc_in_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b7 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b7" id="fac_labc_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_labc_in_b7']))?$o_desc_in_b7['fac_labc_in_b7']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b7" id="total_labcs_in_b7" value="<?php echo (!empty($o_desc_in_b7['total_labcs_in_b7']))?$o_desc_in_b7['total_labcs_in_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col IN B7 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_in_b7" id="col_apus_in_b7" value="<?php echo (!empty($o_desc_in_b7['col_apus_in_b7']))?$o_desc_in_b7['col_apus_in_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b7 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b7" id="fac_prod_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_prod_in_b7']))?$o_desc_in_b7['fac_prod_in_b7']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b7" id="o_apus_in_b7" value="<?php echo (!empty($o_desc_in_b7['o_apus_in_b7']))?$o_desc_in_b7['o_apus_in_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col IN B7 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_in_b7" id="col_price_in_b7" value="<?php echo (!empty($o_desc_in_b7['col_price_in_b7']))?$o_desc_in_b7['col_price_in_b7']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_in_b7 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b7" id="fac_cl_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_cl_in_b7']))?$o_desc_in_b7['fac_cl_in_b7']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_in_b7" id="o_price_in_b7" value="<?php echo (!empty($o_desc_in_b7['o_price_in_b7']))?$o_desc_in_b7['o_price_in_b7']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>




</div>

<?php

}



//end b7 in



//start b8 in



if(!empty($b8_in_products))

{

?>

    <div class="col-md-12 px-0 collapse" id="interiorb8" style="background-color:#a3a373;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b8_in_products);$l++)

{

    $product=$prod->get_product($b8_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b8_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b8_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b8_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b8_in_products[$l]['osub_id'];

    $data['prod_id']=$b8_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b8_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b8_in_products[$l]['osub_id'].".".$b8_in_products[$l]['prod_id'].".".$o_id; ?> -

         <input type="text" class="form-control form-control-sm b8_in_multiplicator <?php echo $b8_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b8_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b8_in_products[$l]['prod_id']."_fac";?>" value="<?php

         if(empty($o_desc_in_b8[$b8_in_products[$l]['prod_id']."_fac"]))

         {

            echo "1";

         }

         else

         {

            echo $o_desc_in_b8[$b8_in_products[$l]['prod_id']."_fac"];

         }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b8_in_products[$l]['osub_id'].".".$b8_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b8" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b8_in_products[$l]['osub_id'].".".$b8_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b8_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b8";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b8_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b8";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b8_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b8";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    } //end if something is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

    <button class="btn btn-sm btn-primary" id="b8inhiddentasks" data-target="#show_b8inhiddentasks" data-toggle="collapse" aria-expanded="<?php

    if(isset($_GET['o_correction']))

    {

        echo "true";

    }

    else

    {

        echo "false";

    }?>">Show B8 Lumion hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }?>" id="show_b8inhiddentasks">

<?php

for($l=0;$l<count($b8_in_products);$l++)

{



    $product=$prod->get_product($b8_in_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b8_in_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b8_in_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b8_in_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b8_in_products[$l]['osub_id'];

    $data['prod_id']=$b8_in_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b8_in_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b8_in_products[$l]['osub_id'].".".$b8_in_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b8_in_multiplicator <?php echo $b8_in_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b8_in_products[$l]['prod_id']."_fac";?>" name="<?php echo $b8_in_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_in_b8[$b8_in_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_in_b8[$b8_in_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b8_in_products[$l]['osub_id'].".".$b8_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_in_b8" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b8_in_products[$l]['osub_id'].".".$b8_in_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_in_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_in_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_price" name="product_<?php echo $b8_in_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_in_b8";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b8_in_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_in_b8";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b8_in_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b8_in_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_in_b8";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_in_products[$l]['osub_id']."_".$b8_in_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b8inhiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col IN B8 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_in_b8" id="col_labc_in_b8" value="<?php echo (!empty($o_desc_in_b8['col_labc_in_b8']))?$o_desc_in_b8['col_labc_in_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b8 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_in_b8" id="fac_labc_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_labc_in_b8']))?$o_desc_in_b8['fac_labc_in_b8']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b8" id="total_labcs_in_b8" value="<?php echo (!empty($o_desc_in_b8['total_labcs_in_b8']))?$o_desc_in_b8['total_labcs_in_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col IN B8 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_in_b8" id="col_apus_in_b8" value="<?php echo (!empty($o_desc_in_b8['col_apus_in_b8']))?$o_desc_in_b8['col_apus_in_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b8 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_in_b8" id="fac_prod_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_prod_in_b8']))?$o_desc_in_b8['fac_prod_in_b8']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b8" id="o_apus_in_b8" value="<?php echo (!empty($o_desc_in_b8['o_apus_in_b8']))?$o_desc_in_b8['o_apus_in_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col IN B8 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_in_b8" id="col_price_in_b8" value="<?php echo (!empty($o_desc_in_b8['col_price_in_b8']))?$o_desc_in_b8['col_price_in_b8']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_in_b8 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_in_b8" id="fac_cl_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_cl_in_b8']))?$o_desc_in_b8['fac_cl_in_b8']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_in_b8" id="o_price_in_b8" value="<?php echo (!empty($o_desc_in_b8['o_price_in_b8']))?$o_desc_in_b8['o_price_in_b8']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>




</div>

<?php

}



//end b8 in



?>



<div class="row w-100 mx-0 border py-4 border-bottom-0">

	<div class="col-md-6 border-right pl-4 text-center">

	    <b>New Interior Customer remarks : </b>

        <textarea name="customer_remarks" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php

        if(!isset($_GET['o_correction']))

        {

        echo strip_tags($order['clients-extras']);

        }?></textarea>

	</div>

	<div class="col-md-6 pl-4 text-center">

	    <b>New Interior Operator remarks : </b>

        <textarea name="op_remarks" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php

        if(!isset($_GET['o_correction']))

        {

        echo strip_tags($order['op-remarks']);

        }?></textarea>

	</div>

</div>



</div> <!-- end interior -->





<div class="exterior">

    <div class="row w-100 mx-0 border-top border-dark pt-4">

        <div class="col-md-2">

            <h5 class="text-success w-100 text-center ">Exterior</h5>

        </div>

        <?php

        if($_COOKIE['lt_id']!=9)

        {

        ?>

        <div class="col-md-2" style="background-color:#94ce99;">

            <?php

            if(count($b5_ex_products)==0)

            {

            ?>

            <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="exbtnb5" data-target="#exteriorb5" data-toggle="collapse"><del>B5 exterior - Sketchup</del></button>

            <br><span class="text-danger">No exterior ordered</span>

            <?php

            }

            else

            {

            ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="exbtnb5" data-target="#exteriorb5" data-toggle="collapse">B5 exterior - Sketchup</button>

            <?php

            }

            ?>

        </div>

        <?php

        }





        if($_COOKIE['lt_id']!=9)

        {

        ?>

        <div class="col-md-2" style="background-color:#94ce99;">

            <?php



            if(count($b6_ex_products)==0)

            {

            ?>

            <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="exbtnb6" data-target="#exteriorb6" data-toggle="collapse"><del>B6 exterior - Twinmotion</del></button>

            <br><span class="text-danger">No exterior ordered</span>

            <?php

            }

            else

            {

            ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="exbtnb6" data-target="#exteriorb6" data-toggle="collapse">B6 exterior - Twinmotion</button>

            <?php

            }

            ?>

        </div>

        <?php

        }

        ?>

        <div class="col-md-2" style="background-color:#6aa36f;">

            <?php

            if(count($b7_ex_products)==0)

            {

            ?>

            <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="exbtnb7" data-target="#exteriorb7" data-toggle="collapse"><del>B7 exterior - 3ds Max</del></button>

            <br><span class="text-danger">No exterior ordered</span>

            <?php

            }

            else

            {

            ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="exbtnb7" data-target="#exteriorb7" data-toggle="collapse">B7 exterior - 3ds Max</button>

            <?php

            }

            ?>

        </div>

        <div class="col-md-2" style="background-color:#6aa36f;">

            <?php

            if(count($b8_ex_products)==0)

            {

            ?>

            <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="exbtnb8" data-target="#exteriorb8" data-toggle="collapse"><del>B8 exterior - Lumion</del></button>

            <br><span class="text-danger">No exterior ordered</span>

            <?php

            }

            else

            {

            ?>

            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="exbtnb8" data-target="#exteriorb8" data-toggle="collapse">B8 exterior - Lumion</button>

            <?php

            }

            ?>

        </div>

    </div>

<?php



//start b5 ex



if(!empty($b5_ex_products))

{

?>

    <div class="col-md-12 px-0 collapse" id="exteriorb5" style="background-color:#94ce99;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b5_ex_products);$l++)

{

    $product=$prod->get_product($b5_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b5_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b5_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b5_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b5_ex_products[$l]['osub_id'];

    $data['prod_id']=$b5_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b5_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b5_ex_products[$l]['osub_id'].".".$b5_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b5_ex_multiplicator <?php echo $b5_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b5_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b5_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b5[$b5_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b5[$b5_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b5_ex_products[$l]['osub_id'].".".$b5_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b5" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b5_ex_products[$l]['osub_id'].".".$b5_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b5";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b5";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b5";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    } //end if something is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

    <button class="btn btn-sm btn-primary" id="b5exhiddentasks" data-target="#show_b5exhiddentasks" data-toggle="collapse" aria-expanded="<?php

    if(isset($_GET['o_correction']))

    {

        echo "true";

    }

    else

    {

        echo "false";

    }?>">Show B5 Sketchup hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }?>" id="show_b5exhiddentasks">

<?php

for($l=0;$l<count($b5_ex_products);$l++)

{



    $product=$prod->get_product($b5_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b5_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b5_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b5_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b5_ex_products[$l]['osub_id'];

    $data['prod_id']=$b5_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b5_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b5_ex_products[$l]['osub_id'].".".$b5_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b5_ex_multiplicator <?php echo $b5_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b5_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b5_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b5[$b5_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b5[$b5_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b5_ex_products[$l]['osub_id'].".".$b5_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b5" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b5_ex_products[$l]['osub_id'].".".$b5_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b5_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b5_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b5";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b5";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b5_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b5";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b5_ex_products[$l]['osub_id']."_".$b5_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b5exhiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col EX B5 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_ex_b5" id="col_labc_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['col_labc_ex_b5']))?$o_desc_ex_b5['col_labc_ex_b5']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_ex_b5 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b5" id="fac_labc_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['fac_labc_ex_b5']))?$o_desc_ex_b5['fac_labc_ex_b5']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b5" id="total_labcs_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['total_labcs_ex_b5']))?$o_desc_ex_b5['total_labcs_ex_b5']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col EX B5 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_ex_b5" id="col_apus_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['col_apus_ex_b5']))?$o_desc_ex_b5['col_apus_ex_b5']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_ex_b5 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b5" id="fac_prod_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['fac_prod_ex_b5']))?$o_desc_ex_b5['fac_prod_ex_b5']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b5" id="o_apus_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['o_apus_ex_b5']))?$o_desc_ex_b5['o_apus_ex_b5']:"0";?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col EX B5 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_ex_b5" id="col_price_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['col_price_ex_b5']))?$o_desc_ex_b5['col_price_ex_b5']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_ex_b5 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b5" id="fac_cl_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['fac_cl_ex_b5']))?$o_desc_ex_b5['fac_cl_ex_b5']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_ex_b5" id="o_price_ex_b5" value="<?php echo (!empty($o_desc_ex_b5['o_price_ex_b5']))?$o_desc_ex_b5['o_price_ex_b5']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>




</div>

<?php

}



//end b5 ex



//start b6 ex



if(!empty($b6_ex_products))

{

?>

    <div class="col-md-12 px-0 collapse show" id="exteriorb6" style="background-color:#94ce99;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b6_ex_products);$l++)

{

    $product=$prod->get_product($b6_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b6_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b6_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b6_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b6_ex_products[$l]['osub_id'];

    $data['prod_id']=$b6_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b6_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b6_ex_products[$l]['osub_id'].".".$b6_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b6_ex_multiplicator <?php echo $b6_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b6_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b6_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b6[$b6_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b6[$b6_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b6_ex_products[$l]['osub_id'].".".$b6_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b6" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b6_ex_products[$l]['osub_id'].".".$b6_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b6";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b6";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b6";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    } //end if something is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

<button class="btn btn-sm btn-primary" id="b6exhiddentasks" data-target="#show_b6exhiddentasks" data-toggle="collapse" aria-expanded="<?php

if(isset($_GET['o_correction']))

{

    echo "true";

}

else

{

    echo "false";

}?>">Show B6 Twinmotion hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }?>" id="show_b6exhiddentasks">

<?php

for($l=0;$l<count($b6_ex_products);$l++)

{



    $product=$prod->get_product($b6_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b6_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b6_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b6_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b6_ex_products[$l]['osub_id'];

    $data['prod_id']=$b6_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b6_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b6_ex_products[$l]['osub_id'].".".$b6_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b6_ex_multiplicator <?php echo $b6_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b6_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b6_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b6[$b6_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b6[$b6_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b6_ex_products[$l]['osub_id'].".".$b6_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b6" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b6_ex_products[$l]['osub_id'].".".$b6_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b6_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b6_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b6";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b6";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b6_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b6";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b6_ex_products[$l]['osub_id']."_".$b6_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b6exhiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col EX B6 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_ex_b6" id="col_labc_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['col_labc_ex_b6']))?$o_desc_ex_b6['col_labc_ex_b6']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_ex_b6 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b6" id="fac_labc_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_labc_ex_b6']))?$o_desc_ex_b6['fac_labc_ex_b6']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b6" id="total_labcs_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['total_labcs_ex_b6']))?$o_desc_ex_b6['total_labcs_ex_b6']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col EX B6 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_ex_b6" id="col_apus_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['col_apus_ex_b6s']))?$o_desc_ex_b6['col_apus_ex_b6s']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_ex_b6 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b6" id="fac_prod_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_prod_ex_b6']))?$o_desc_ex_b6['fac_prod_ex_b6']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b6" id="o_apus_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['o_apus_ex_b6']))?$o_desc_ex_b6['o_apus_ex_b6']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col EX B6 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_ex_b6" id="col_price_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['col_price_ex_b6']))?$o_desc_ex_b6['col_price_ex_b6']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_ex_b6 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b6" id="fac_cl_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_cl_ex_b6']))?$o_desc_ex_b6['fac_cl_ex_b6']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_ex_b6" id="o_price_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['o_price_ex_b6']))?$o_desc_ex_b6['o_price_ex_b6']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>




</div>

<?php

}



//end b6 ex



//start b7 ex



if(!empty($b7_ex_products))

{

?>

    <div class="col-md-12 px-0 collapse" id="exteriorb7" style="background-color:#6aa36f;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b7_ex_products);$l++)

{

    $product=$prod->get_product($b7_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b7_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b7_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b7_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b7_ex_products[$l]['osub_id'];

    $data['prod_id']=$b7_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b7_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b7_ex_products[$l]['osub_id'].".".$b7_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b7_ex_multiplicator <?php echo $b7_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b7_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b7_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b7[$b7_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b7[$b7_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b7_ex_products[$l]['osub_id'].".".$b7_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b7" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b7_ex_products[$l]['osub_id'].".".$b7_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b7";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b7";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b7";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    } //end if something is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

    <button class="btn btn-sm btn-primary" id="b7exhiddentasks" data-target="#show_b7exhiddentasks" data-toggle="collapse" aria-expanded="<?php

    if(isset($_GET['o_correction']))

    {

        echo "true";

    }

    else

    {

        echo "false";

    }?>">Show B7 3ds Max hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }

        ?>" id="show_b7exhiddentasks">

<?php

for($l=0;$l<count($b7_ex_products);$l++)

{



    $product=$prod->get_product($b7_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b7_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b7_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b7_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b7_ex_products[$l]['osub_id'];

    $data['prod_id']=$b7_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b7_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b7_ex_products[$l]['osub_id'].".".$b7_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b7_ex_multiplicator <?php echo $b7_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b7_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b7_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b7[$b7_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b7[$b7_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b7_ex_products[$l]['osub_id'].".".$b7_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b7" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b7_ex_products[$l]['osub_id'].".".$b7_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b7_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b7_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b7";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b7";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b7_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b7";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b7_ex_products[$l]['osub_id']."_".$b7_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b7exhiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col EX B7 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_ex_b7" id="col_labc_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['col_labc_ex_b7']))?$o_desc_ex_b7['col_labc_ex_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_ex_b7 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b7" id="fac_labc_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_labc_ex_b7']))?$o_desc_ex_b7['fac_labc_ex_b7']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b7" id="total_labcs_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['total_labcs_ex_b7']))?$o_desc_ex_b7['total_labcs_ex_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col EX B7 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_ex_b7" id="col_apus_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['col_apus_ex_b7']))?$o_desc_ex_b7['col_apus_ex_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_ex_b7 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b7" id="fac_prod_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_prod_ex_b7']))?$o_desc_ex_b7['fac_prod_ex_b7']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b7" id="o_apus_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['o_apus_ex_b7']))?$o_desc_ex_b7['o_apus_ex_b7']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col EX B7 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_ex_b7" id="col_price_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['col_price_ex_b7']))?$o_desc_ex_b7['col_price_ex_b7']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_ex_b7 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b7" id="fac_cl_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_cl_ex_b7']))?$o_desc_ex_b7['fac_cl_ex_b7']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_ex_b7" id="o_price_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['o_price_ex_b7']))?$o_desc_ex_b7['o_price_ex_b7']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>




</div>

<?php

}



//end b7 ex



//start b8 ex



if(!empty($b8_ex_products))

{

?>

    <div class="col-md-12 px-0 collapse" id="exteriorb8" style="background-color:#6aa36f;">

    <div class="row">

        <div class="col-md-6"> <!-- first column -->



<?php

for($l=0;$l<count($b8_ex_products);$l++)

{

    $product=$prod->get_product($b8_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b8_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b8_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b8_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b8_ex_products[$l]['osub_id'];

    $data['prod_id']=$b8_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==1)||($new_prod_status['om_correction']==1))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b8_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b8_ex_products[$l]['osub_id'].".".$b8_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b8_ex_multiplicator <?php echo $b8_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b8_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b8_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b8[$b8_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b8[$b8_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b8_ex_products[$l]['osub_id'].".".$b8_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b8" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b8_ex_products[$l]['osub_id'].".".$b8_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b8";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b8";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b8";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is checked

} //end for





?>

</div> <!-- not hidden tasks -->



<div class="col-md-6">

<button class="btn btn-sm btn-primary" id="b8exhiddentasks" data-target="#show_b8exhiddentasks" data-toggle="collapse" aria-expanded="<?php

if(isset($_GET['o_correction']))

{

    echo "true";

}

else

{

    echo "false";

}?>">Show B8 Lumion hidden tasks</button>

        <div class="col-md-12 <?php

        if(!isset($_GET['o_correction']))

        {

            echo "collapse";

        }?>" id="show_b8exhiddentasks">

<?php

for($l=0;$l<count($b8_ex_products);$l++)

{



    $product=$prod->get_product($b8_ex_products[$l]['prod_id']);

    $product_price=$price->calculateProductPrice($b8_ex_products[$l]['prod_id'],$cur_factor);



    $product_apu=$prod->calculateProductAPU($b8_ex_products[$l]['prod_id']);

    $product_labc=$prod->calculateProductlabc($b8_ex_products[$l]['prod_id']);



    $data['o_id']=$o_id;

    $data['osub_id']=$b8_ex_products[$l]['osub_id'];

    $data['prod_id']=$b8_ex_products[$l]['prod_id'];



    $new_prod_status=$prod->get_order_product(json_encode($data));



    if(($new_prod_status['om_amendment']==0)&&($new_prod_status['om_correction']==0))

    {

?>

<div class="col-md-6"> <!--box -->

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

				if($allstatus[$j]['ost_id']==$b8_ex_products[$l]['p_status'])

				{

					echo $allstatus[$j]['ost_color'];

				}

			}

		}

		?> text-center d-inline-flex"><?php echo $order['om_id'].".".$b8_ex_products[$l]['osub_id'].".".$b8_ex_products[$l]['prod_id'].".".$o_id; ?> -

        <input type="text" class="form-control form-control-sm b8_ex_multiplicator <?php echo $b8_ex_products[$l]['prod_id']."_fac";?>" style="width:3em;height:25px;" id="<?php echo $b8_ex_products[$l]['prod_id']."_fac";?>" name="<?php echo $b8_ex_products[$l]['prod_id']."_fac";?>" value="<?php

        if(empty($o_desc_ex_b8[$b8_ex_products[$l]['prod_id']."_fac"]))

        {

            echo "1";

        }

        else

        {

            echo $o_desc_ex_b8[$b8_ex_products[$l]['prod_id']."_fac"];

        }?>" form="order_details">

		</div>

		<div class="row white" style="margin:0px;">

			<div class="col-md-6" style="padding:0px;">

				<div class="form-inline">

				<input type="checkbox" id="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>" name="mistake[]" class="form-control form-control-sm" value="mistake.<?php echo $order['om_id'].".".$o_id.".".$b8_ex_products[$l]['osub_id'].".".$b8_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_correction']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>">Correct</label>

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#mistake_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>').click(function(){



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

				<input type="checkbox" id="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>" name="amendment[]" class="form-control form-control-sm product_ex_b8" value="amendment.<?php echo $order['om_id'].".".$o_id.".".$b8_ex_products[$l]['osub_id'].".".$b8_ex_products[$l]['prod_id'];?>" form="order_details" <?php

				if($order['o_status']>0)

				{

					$o_prods_data['o_id']=$o_id;

					$o_prods_data['osub_id']=$b8_ex_products[$l]['osub_id'];

					$o_prods_data['prod_id']=$b8_ex_products[$l]['prod_id'];



					$o_prods=$prod->get_order_product(json_encode($o_prods_data));



					if($o_prods['om_amendment']>0)

					{

						echo "checked";

					}

				}

				?>>

				<label for="amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>">Amend</label>



                <input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_price_original" value="<?php echo $product_price; ?>">

                <input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_apu_original" value="<?php echo $product_apu; ?>">

                <input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_labc_original" value="<?php echo $product_labc; ?>">



				<input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_price" name="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_price" class="<?php

					if($new_prod_status['om_amendment']==1)

					{

						echo "prices_ex_b8";

					}

				?>" value="<?php echo $product_price; ?>">

					<input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_apu" name="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_apu" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "apus_ex_b8";

				}

				?>" value="<?php echo $product_apu; ?>">

					<input type="hidden" id="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_labc" name="product_<?php echo $b8_ex_products[$l]['prod_id'];?>_labc" class="<?php

				if($new_prod_status['om_amendment']==1)

				{

					echo "labcs_ex_b8";

				}

				?>" value="<?php echo $product_labc; ?>">

				</div>

			</div>

			<script type="text/javascript">

				$(document).ready(function(){

				$('#amendment_<?php echo $order['om_id']."_".$o_id."_".$b8_ex_products[$l]['osub_id']."_".$b8_ex_products[$l]['prod_id'];?>').click(function(){



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

    </div> <!--end box -->

<?php

    }//end if something is not checked

} //end for

?>



        </div> <!-- end b8exhiddentasks -->

</div> <!-- end hidden tasks -->

</div> <!-- end row -->



<br>

<hr>

<br>




<div class="row form-inline">

	<div class="col-md-12">

		<b>Employee-Producer: Col EX B8 = </b>

		<input type="text" class="form-control form-control-sm" name="col_labc_ex_b8" id="col_labc_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['col_labc_ex_b8']))?$o_desc_ex_b8['col_labc_ex_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_ex_b8 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_labc_ex_b8" id="fac_labc_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['fac_labc_ex_b8']))?$o_desc_ex_b8['fac_labc_ex_b8']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b8" id="total_labcs_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['total_labcs_ex_b8']))?$o_desc_ex_b8['total_labcs_ex_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>

	</div>

</div>
<div class="row form-inline">

	<div class="col-md-12">

		<b>Producer-Trader: Col EX B8 = </b>

		<input type="text" class="form-control form-control-sm" name="col_apus_ex_b8" id="col_apus_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['col_apus_ex_b8']))?$o_desc_ex_b8['col_apus_ex_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_ex_b8 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_prod_ex_b8" id="fac_prod_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['fac_prod_ex_b8']))?$o_desc_ex_b8['fac_prod_ex_b8']:"0.5" ;?>" form="order_details" style="width:5em">

		<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b8" id="o_apus_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['o_apus_ex_b8']))?$o_desc_ex_b8['o_apus_ex_b8']:"0" ;?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>

	</div>

</div>

<div class="row form-inline">

	<div class="col-md-12">

		<b>Trader-Purchaser: Col EX B8 = </b>

		<input class="form-control form-control-sm" type="text" name="col_price_ex_b8" id="col_price_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['col_price_ex_b8']))?$o_desc_ex_b8['col_price_ex_b8']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?> X fac_client_ex_b8 = </b>

		<input type="text" class="form-control form-control-sm" name="fac_cl_ex_b8" id="fac_cl_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['fac_cl_ex_b8']))?$o_desc_ex_b8['fac_cl_ex_b8']:"0.5" ;?>" form="order_details" style="width:5em">

		<b>=</b>

		<input type="text" class="form-control form-control-sm" name="o_price_ex_b8" id="o_price_ex_b8" value="<?php echo (!empty($o_desc_ex_b8['o_price_ex_b8']))?$o_desc_ex_b8['o_price_ex_b8']:"0" ;?>" form="order_details" style="width:5em">

		<b><?php echo $currency; ?></b>

		<br><br>

	</div>

</div>



</div>

<?php

}



//end b8 ex

?>



<div class="row w-100 mx-0 border py-4 border-bottom-0">

	<div class="col-md-6 border-right pl-4 text-center">

	    <b>New Exterior Customer remarks : </b>

        <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php

        if(!isset($_GET['o_correction']))

        {

        echo strip_tags($order['client_extras_ex_b5']);

        }?></textarea>

	</div>

	<div class="col-md-6 pl-4 text-center">

	    <b>New Exterior Operator remarks : </b>

        <textarea name="op_remarks_ex_b5" class="form-control form-control-sm mt-2" rows="2" cols="6" form="order_details" style="width:500px"><?php

        if(!isset($_GET['o_correction']))

        {

        echo strip_tags($order['op_remarks_ex_b5']);

        }?></textarea>

	</div>

</div>



</div> <!-- end exterior -->



<br>



<div class="totals py-2 border-top border-bottom border-dark"  style="box-shadow: none;">
<div id="all_customer_files">

</div>
<script type="text/javascript">
	$(document).ready(function(){

		get_customer_files();

	});

	function get_customer_files()
	{
		let o_id=<?php echo $o_id;?>;

		$.ajax({
			url: "../ajax/ajax_customer_files.php",
			method: "get",
			data: {o_id:o_id},
			dataType:"html",
			success:function(data) {
				$('#all_customer_files').html(data);
			}
		}).done(function(){

			//setTimeout(function(){imagePreview();},2000);

		});
	}
</script>
	<?php

	//include('../../../../domenia7.com/public_html/customer_files.php');

	?>

	<?php /*<div class="row w-100 mx-0 text-center py-2">

		<div class="col-md-12 d-flex justify-content-center mb-2">

			<div class="form-inline">

				<b>Total price :</b> <input type="text" name="o_price" id="o_price" value="<?php echo $order['o_price'];?>" class="form-control form-control-sm mx-2" style="width:6em;">

				<b>	or Total special agreement price = </b> <input type="text" name="o_special_agreement_price" id="o_special_agreement_price" value="<?php echo $order['o_special_agreement_price'];?>" form="order_details" class="form-control form-control-sm mx-2" style="width:6em;">

			</div>

		</div>

	</div> */ ?>
	<div class="row" style="background: black; color: white; margin: unset;">
		<div class="col-md-12 text-center">

	</div>
    <div class="row w-100 mx-0 form-inline d-flex justify-content-center">

        <div class="col-md-8 justify-content-center" style="max-width: 55%;">

            <div class="row">

                <div class="col-md-12">

                    <label for="total_price" class="d-inline"><b>Total price = </b></label>

                    <input type="text" name="total_price" id="total_price" class="form-control form-control-sm d-inline" form="order_details" style="width:6em;" value="<?php

                    if(strpos($order['collection'],'p1001')!==false)

                    {

                        echo $order['o_price'];

                    }

                    ?>">

                    <b class="mr-1"><?php echo $currency; ?></b>

                    <b class="mr-1">or</b> <label for="total_special_agreement_price" class="d-inline"><b>Total special agreement price = </b></label>

                    <input type="text" name="total_special_agreement_price" id="total_special_agreement_price" class="form-control form-control-sm d-inline" form="order_details" style="width:6em;" value="<?php

                    echo $order['o_special_agreement_price'];

                    ?>">

                    <b><?php echo $currency; ?></b>

                    <script type="text/javascript">



                    $(document).ready(function(){



                        $('#total_special_agreement_price').on('focusout',function(){



                            let o_special_agreement_price=$('#total_special_agreement_price').val();

                            let user_id=$('#user_id').val();

                            let o_id=$('#o_id').val();



                            if(o_special_agreement_price!="")

                            {



                                $.ajax({

                                    url: "<?php echo $base_url;?>ajax/o_special_agreement_price_changed_by.php",

                                    method: "post",

                                    data: {user_id:user_id,o_id:o_id},

                                    dataType:"html",

                                    success:function(data) {

                                        console.log(data);

                                    }

                                });



                            }

                        });



                    });

                    </script>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <b>Price changed by <?php

                    if($order['o_special_agreement_price_changed_by']==0)

                    {

                        echo "nobody";

                    }

                    else

                    {

                        $creator=$prod->get_client($order['o_special_agreement_price_changed_by']);

                        echo $creator['c_last_name'].", ".$creator['c_first_name'];

                    }

                    ?></b>

                </div>

            </div>

        </div>

        <div class="col-md-2" style="flex: unset; max-width: 45%;">

            <?php

            $main_client=$prod->get_main_client($client['mc_id']);



            if(!empty($main_client))

            {

            ?>

            <textarea style="width:17vw;  height: 12vh;" class="form-control form-control-sm" name="price_remarks" id="price_remarks" data-mc_id="<?php echo $main_client['mc_id']?>" title="Main client price information" placeholder="Main client price information"><?php



            if(!empty($main_client))

            {

                echo $main_client['price_remarks'];

            }

            ?></textarea>

            <br><br>

            <?php

            }

            ?>

            <textarea style="width: 17vw; height: 12vh;" class="form-control form-control-sm" name="client_price_remarks" id="client_price_remarks" data-client_id="<?php echo $client['client_ID']?>" title="Simple client price information" placeholder="Simple client price information"><?php



            if(!empty($client))

            {

                echo $client['client_price_remarks'];

            }

            ?></textarea>

            <script type="text/javascript">

            $(document).ready(function(){



                $('#price_remarks').on('change keyup',function(){

                    $.ajax({

                        url: "../ajax/change_main_client_price_remarks.php",

                        method: "post",

                        data: {mc_id:$(this).data('mc_id'),price_remarks:$(this).val()},

                        dataType:"html",

                        success:function(data) {

                            console.log(data);

                        }

                    });

                });



                $('#client_price_remarks').on('change keyup',function(){

                    $.ajax({

                        url: "../ajax/change_simple_client_price_remarks.php",

                        method: "post",

                        data: {client_id:$(this).data('client_id'),client_price_remarks:$(this).val()},

                        dataType:"html",

                        success:function(data) {

                            console.log(data);

                        }

                    });

                });



            });

            </script>

        </div>

    </div>

    <div class="row form-inline w-100 mx-0 d-flex justify-content-center">

        <div class="col-md-12 border border-top-0 border-bottom-0 pb-2 d-flex justify-content-center py-1">

            <label for="total_apu" class="d-inline"><b>Total APEs = </b></label>

            <input type="text" name="total_apu" id="total_apu" class="form-control form-control-sm d-inline" style="width:6em;" value="<?php

            if(strpos($order['collection'],'p1001')!==false)

            {

                echo $budget_apu=$prod->calculateProductAPU("p1001");

            }

            ?>">

        </div>

    </div>

    <div class="row form-inline w-100 mx-0 d-flex justify-content-center">

        <div class="col-md-8 pt-3 d-flex justify-content-center py-1">

            <textarea class="form-control form-control-sm w-100" name="invoice_explanations" id="invoice_explanations" placeholder="Invoice explanations" form="order_details"><?php
			if(!empty($_GET['o_id']))
			{
            	echo $order['invoice_explanations'];
			}
            ?></textarea>

        </div>

    </div>

</div>

<br>

<div class="row center_message w-100 mx-0">
	<?php
	//accepted order
	if(isset($_GET['status']))
	{
	?>
	<button name="save_btn" class="btn btn-primary btn-sm mx-auto" form="order_details">Save changes</button>
	<?php
	}

	//not accepted order
	if(!isset($_GET['status']))
	{
		?>
		<button name="accept_btn" class="btn btn-primary btn-sm mx-auto" form="order_details">Accept</button>
		<?php
	}
	?>
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

		<a href="<?php echo $base_url;?>" class="btn btn-danger btn-sm">Login</a>

		<br><br>

	</div>

	<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>">

	<?php

}

?>

	</article>

</section>

<?php

include('../footer.php');

?>