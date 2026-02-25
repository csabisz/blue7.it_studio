<?php
session_start();
include('../functions.php');
//include('../../../superfloorplans.com/public_html/functions.php');
//include('../../../superfloorplans.com/public_html/price_calculations.php');
include('../../../../domenia7.com/public_html/domenia_db2.php');
include('../../../../blue7.it/public_html/domenia/domenia.php');
include('../../../../superplan7.com/public_html/functions.php');
include('../domenia3n_db.php');
include('../notifications.php');

$prod=new Production;
$notifications2=new Notifications;
$domenia2=new Domenia2;
$domenia3n=new Domenia3n;
$domenia=new Domenia;
$sp7=new Superplans;

$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Contracting - Details";

include('../header2.php');
include('../menu.php');

$client=$prod->get_client($_COOKIE['client_id']);

$licence_sites=explode(";",$client['ls_ids']);
?>
<style>
    .products {
        -ms-transform: scale(2); /* IE */
        -moz-transform: scale(2); /* FF */
        -webkit-transform: scale(2); /* Safari and Chrome */
        -o-transform: scale(2); /* Opera */
        transform: scale(2);
    }
</style>
<script type="text/javascript" src="<?php echo $base_url;?>js/tinymce/tinymce.min.js"></script>

<section class="top_section">
	<article>
		<div class="container text-center pagecontent bg-white px-0">
		    <p class="pt-4 display-4">Acceptance - Contracting</p>
            <hr class="mb-4" width="450px">
		    <?php
		        include('submenu.php');
		    ?>
		    <div class="py-2 row mx-0 w-100 mt-4" style="font-size: 30px">
                <p class="text-center text-primary w-100">Acceptance of orders - Contracting </p>
		    </div>
		    <?php
if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
{
	                if((isset($_GET['o_id']))||(isset($_GET['option'])))
	                {
                        if(isset($_GET['option']))
                        {
		                    $option=$prod->xss_fix($_GET['option']);
                        }
                        else
                        {
                            $option="";
                        }

		                if(isset($_GET['status']))
		                {
			                $status=$prod->xss_fix($_GET['status']);
			                $o_id=$prod->xss_fix($_GET['o_id']);
			                if($status=="rejected")
			                {
				                $o_status=12;
				                $prod->update_order_status($o_id,$o_status);
                                ?>
                                <div class="text-center"><div class="alert alert-success">Order rejected !</div></div>
                                <meta http-equiv="refresh" content="1; url=index.php?orderstatus=10-12">
                                <?php
			                }
		                }	
				
                        if((isset($_POST['save_btn']))||(isset($_POST['accept_btn']))||(isset($_POST['temp_save_btn'])))
                        {
	                        ?>	
	                     <div class="alert alert-warning">	
		                    Processing... Please wait... 
	                    </div>	
	                    <?php
					
$update_data['o_id']=$prod->xss_fix($_POST['o_id']);

$order=$prod->get_order($update_data['o_id']);
$client_public_presentation=$prod->get_client($order['u_client_ID']);

if($client_public_presentation['public_presentation']==1)
{
    $update_data['public']=1;
}
else
{
    $update_data['public']=$order['public'];
}

$update_data['order_name']=$prod->xss_fix($_POST['order_name']);
$update_data['o_deadline_utc']=(!empty($_POST['o_deadline']))?$prod->xss_fix($_POST['o_deadline']):"0000-00-00 00:00:00";
$update_data['cur_id']=$prod->xss_fix($_POST['cur_id']);
$update_data['client_language_id']=$prod->xss_fix($_POST['client_language_id']);				
$update_data['collection']=$prod->xss_fix($_POST['collection']);
$update_data['u_prod_id']=$prod->xss_fix($_POST['producers']);					
$update_data['customer_remarks']=$prod->xss_fix($_POST['customer_remarks']);
$update_data['op_remarks']=$prod->xss_fix($_POST['op_remarks']);
$update_data['client_extras_ex_b5']=$prod->xss_fix($_POST['customer_remarks_ex_b5']);
$update_data['op_remarks_ex_b5']=$prod->xss_fix($_POST['op_remarks_ex_b5']);
$update_data['environment_address']=$_POST['environment_address'];
$update_data['longitude']=$prod->xss_fix($_POST['longitude']);
$update_data['latitude']=$prod->xss_fix($_POST['latitude']);
$update_data['suntour']=0;
if(($update_data['longitude']!=0)&&($update_data['latitude']!=0))
{
    $update_data['suntour']=1;
}

$update_data['invoice_explanations']=$prod->xss_fix($_POST['invoice_explanations']);
$update_data['geoportal_link']=$prod->xss_fix($_POST['geoportal_link']);
$update_data['earth_link']=$prod->xss_fix($_POST['earth_link']);
$update_data['show_on_map']=$prod->xss_fix($_POST['show_on_map']);
$update_data['vr_link']=$prod->xss_fix($_POST['vr_link']);
$update_data['street_view_link']=$prod->xss_fix($_POST['street_view_link']);
//$update_data['google_earth_link']=$prod->xss_fix($_POST['google_earth_link']);
$update_data['o_price']=$prod->xss_fix($_POST['total_price']);
$update_data['o_special_agreement_price']=$prod->xss_fix($_POST['total_special_agreement_price']);					
$update_data['vat_percent']=$prod->xss_fix($_POST['vat_percent']);
$update_data['vat_a_id']=$prod->xss_fix($_POST['vat_a_id']);
//$update_data['plot_id']=$prod->xss_fix($_POST['plot_id']);
$update_data['house_id']=$prod->xss_fix($_POST['house_id']);
if(!empty($_POST['commission']))
{
    $update_data['commission']=$prod->xss_fix($_POST['commission']);
}
else
{
    $update_data['commission']=0;
}

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

if($order['o_status']==8)
{
    $update_data['o_status']=8;
}
elseif(isset($_POST['temp_save_btn']))
{
    $update_data['o_status']=0;
}
else
{
    $update_data['o_status']=1;
}

$update_data['st_id']=$prod->xss_fix($_POST['st_id1']);
//b1 in

$update_in_b1_data['o_id']=$update_data['o_id'];

$update_in_b1_data['col_amount_in_b1']=(!empty($_POST['col_amount1_in_b1'])?$prod->xss_fix($_POST['col_amount1_in_b1']):"1");

$update_in_b1_data['p1103_fac']=(!empty($_POST['p1103_fac'])?$prod->xss_fix($_POST['p1103_fac']):"1");
$update_in_b1_data['p1104_fac']=(!empty($_POST['p1104_fac'])?$prod->xss_fix($_POST['p1104_fac']):"1");
$update_in_b1_data['p1106_fac']=(!empty($_POST['p1106_fac'])?$prod->xss_fix($_POST['p1106_fac']):"1");
$update_in_b1_data['p1108_fac']=(!empty($_POST['p1108_fac'])?$prod->xss_fix($_POST['p1108_fac']):"1");

$update_in_b1_data['col_price_in_b1']=(!empty($_POST['col_price_in_b1'])?$prod->xss_fix($_POST['col_price_in_b1']):"1");
$update_in_b1_data['fac_cl_in_b1']=(!empty($_POST['fac_cl_in_b1'])?$prod->xss_fix($_POST['fac_cl_in_b1']):"1.0");
$update_in_b1_data['o_price_in_b1']=(!empty($_POST['o_price_in_b1'])?$prod->xss_fix($_POST['o_price_in_b1']):"0");
					
$update_in_b1_data['col_apus_in_b1']=(!empty($_POST['col_apus_in_b1'])?$prod->xss_fix($_POST['col_apus_in_b1']):"1");
$update_in_b1_data['fac_prod_in_b1']=(!empty($_POST['fac_prod_in_b1'])?$prod->xss_fix($_POST['fac_prod_in_b1']):"1");
$update_in_b1_data['o_apus_in_b1']=(!empty($_POST['o_apus_in_b1'])?$prod->xss_fix($_POST['o_apus_in_b1']):"1");
					
$update_in_b1_data['col_labc_in_b1']=(!empty($_POST['col_labc_in_b1'])?$prod->xss_fix($_POST['col_labc_in_b1']):"1");
$update_in_b1_data['fac_labc_in_b1']=(!empty($_POST['fac_labc_in_b1'])?$prod->xss_fix($_POST['fac_labc_in_b1']):"1");
$update_in_b1_data['total_labcs_in_b1']=(!empty($_POST['total_labcs_in_b1'])?$prod->xss_fix($_POST['total_labcs_in_b1']):"1");

//b3 in

$update_in_b3_data['o_id']=$update_data['o_id'];
$update_in_b3_data['sl_id']=(!empty($_POST['sl_id'])?$prod->xss_fix($_POST['sl_id']):"");
$update_in_b3_data['cls_id']=(!empty($_POST['cls_id'])?$prod->xss_fix($_POST['cls_id']):"");

$update_in_b3_data['col_amount_in_b3']=(!empty($_POST['col_amount1_in_b3'])?$prod->xss_fix($_POST['col_amount1_in_b3']):"1");

$update_in_b3_data['p1301_fac']=(!empty($_POST['p1301_fac'])?$prod->xss_fix($_POST['p1301_fac']):"1");
$update_in_b3_data['p1302_fac']=(!empty($_POST['p1302_fac'])?$prod->xss_fix($_POST['p1302_fac']):"1");
$update_in_b3_data['p1321_fac']=(!empty($_POST['p1321_fac'])?$prod->xss_fix($_POST['p1321_fac']):"1");
$update_in_b3_data['p1322_fac']=(!empty($_POST['p1322_fac'])?$prod->xss_fix($_POST['p1322_fac']):"1");

$update_in_b3_data['col_price_in_b3']=(!empty($_POST['col_price_in_b3'])?$prod->xss_fix($_POST['col_price_in_b3']):"1");
$update_in_b3_data['fac_cl_in_b3']=(!empty($_POST['fac_cl_in_b3'])?$prod->xss_fix($_POST['fac_cl_in_b3']):"1");
$update_in_b3_data['o_price_in_b3']=(!empty($_POST['o_price_in_b3'])?$prod->xss_fix($_POST['o_price_in_b3']):"1");
					
$update_in_b3_data['col_apus_in_b3']=(!empty($_POST['col_apus_in_b3'])?$prod->xss_fix($_POST['col_apus_in_b3']):"1");
$update_in_b3_data['fac_prod_in_b3']=(!empty($_POST['fac_prod_in_b3'])?$prod->xss_fix($_POST['fac_prod_in_b3']):"1");
$update_in_b3_data['o_apus_in_b3']=(!empty($_POST['o_apus_in_b3'])?$prod->xss_fix($_POST['o_apus_in_b3']):"1");
					
$update_in_b3_data['col_labc_in_b3']=(!empty($_POST['col_labc_in_b3'])?$prod->xss_fix($_POST['col_labc_in_b3']):"1");
$update_in_b3_data['fac_labc_in_b3']=(!empty($_POST['fac_labc_in_b3'])?$prod->xss_fix($_POST['fac_labc_in_b3']):"1");
$update_in_b3_data['total_labcs_in_b3']=(!empty($_POST['total_labcs_in_b3'])?$prod->xss_fix($_POST['total_labcs_in_b3']):"1");

//b5 in

$update_in_b5_data['o_id']=$update_data['o_id'];

$update_in_b5_data['layout_id']=(!empty($_POST['b5_selected_layoutline'])?$prod->xss_fix($_POST['b5_selected_layoutline']):"1");
$update_in_b5_data['window_id']=0;

$update_in_b5_data['col_amount_in_b5']=(!empty($_POST['col_amount1_in_b5'])?$prod->xss_fix($_POST['col_amount1_in_b5']):"1");					

$update_in_b5_data['p1501_fac']=(!empty($_POST['p1501_fac'])?$prod->xss_fix($_POST['p1501_fac']):"1");
$update_in_b5_data['p1502_fac']=(!empty($_POST['p1502_fac'])?$prod->xss_fix($_POST['p1502_fac']):"1");
$update_in_b5_data['p1503_fac']=(!empty($_POST['p1503_fac'])?$prod->xss_fix($_POST['p1503_fac']):"1");
$update_in_b5_data['p1504_fac']=(!empty($_POST['p1504_fac'])?$prod->xss_fix($_POST['p1504_fac']):"1");
$update_in_b5_data['p1506_fac']=(!empty($_POST['p1506_fac'])?$prod->xss_fix($_POST['p1506_fac']):"1");
$update_in_b5_data['p1507_fac']=(!empty($_POST['p1507_fac'])?$prod->xss_fix($_POST['p1507_fac']):"1");
$update_in_b5_data['p1508_fac']=(!empty($_POST['p1508_fac'])?$prod->xss_fix($_POST['p1508_fac']):"1");

$update_in_b5_data['p1521_fac']=(!empty($_POST['p1521_fac'])?$prod->xss_fix($_POST['p1521_fac']):"1");
$update_in_b5_data['p1522_fac']=(!empty($_POST['p1522_fac'])?$prod->xss_fix($_POST['p1522_fac']):"1");
$update_in_b5_data['p1523_fac']=(!empty($_POST['p1523_fac'])?$prod->xss_fix($_POST['p1523_fac']):"1");
$update_in_b5_data['p1524_fac']=(!empty($_POST['p1524_fac'])?$prod->xss_fix($_POST['p1524_fac']):"1");
$update_in_b5_data['p1526_fac']=(!empty($_POST['p1526_fac'])?$prod->xss_fix($_POST['p1526_fac']):"1");
$update_in_b5_data['p1527_fac']=(!empty($_POST['p1527_fac'])?$prod->xss_fix($_POST['p1527_fac']):"1");
$update_in_b5_data['p1528_fac']=(!empty($_POST['p1528_fac'])?$prod->xss_fix($_POST['p1528_fac']):"1");

$update_in_b5_data['p1541_fac']=(!empty($_POST['p1541_fac'])?$prod->xss_fix($_POST['p1541_fac']):"1");
$update_in_b5_data['p1542_fac']=(!empty($_POST['p1542_fac'])?$prod->xss_fix($_POST['p1542_fac']):"1");
$update_in_b5_data['p1543_fac']=(!empty($_POST['p1543_fac'])?$prod->xss_fix($_POST['p1543_fac']):"1");
$update_in_b5_data['p1544_fac']=(!empty($_POST['p1544_fac'])?$prod->xss_fix($_POST['p1544_fac']):"1");
$update_in_b5_data['p1546_fac']=(!empty($_POST['p1546_fac'])?$prod->xss_fix($_POST['p1546_fac']):"1");
$update_in_b5_data['p1547_fac']=(!empty($_POST['p1547_fac'])?$prod->xss_fix($_POST['p1547_fac']):"1");
$update_in_b5_data['p1548_fac']=(!empty($_POST['p1548_fac'])?$prod->xss_fix($_POST['p1548_fac']):"1");

$update_in_b5_data['col_price_in_b5']=(!empty($_POST['col_price_in_b5'])?$prod->xss_fix($_POST['col_price_in_b5']):"1");
$update_in_b5_data['fac_cl_in_b5']=(!empty($_POST['fac_cl_in_b5'])?$prod->xss_fix($_POST['fac_cl_in_b5']):"1");
$update_in_b5_data['o_price_in_b5']=(!empty($_POST['o_price_in_b5'])?$prod->xss_fix($_POST['o_price_in_b5']):"1");

$update_in_b5_data['col_apus_in_b5']=(!empty($_POST['col_apus_in_b5'])?$prod->xss_fix($_POST['col_apus_in_b5']):"1");
$update_in_b5_data['fac_prod_in_b5']=(!empty($_POST['fac_prod_in_b5'])?$prod->xss_fix($_POST['fac_prod_in_b5']):"1");
$update_in_b5_data['o_apus_in_b5']=(!empty($_POST['o_apus_in_b5'])?$prod->xss_fix($_POST['o_apus_in_b5']):"1");

$update_in_b5_data['col_labc_in_b5']=(!empty($_POST['col_labc_in_b5'])?$prod->xss_fix($_POST['col_labc_in_b5']):"1");
$update_in_b5_data['fac_labc_in_b5']=(!empty($_POST['fac_labc_in_b5'])?$prod->xss_fix($_POST['fac_labc_in_b5']):"1");
$update_in_b5_data['total_labcs_in_b5']=(!empty($_POST['total_labcs_in_b5'])?$prod->xss_fix($_POST['total_labcs_in_b5']):"1");				

//b6 in

$update_in_b6_data['o_id']=$update_data['o_id'];

$update_in_b6_data['layout_id']=(!empty($_POST['b6_selected_layoutline'])?$prod->xss_fix($_POST['b6_selected_layoutline']):"1");
$update_in_b6_data['window_id']=0;

$update_in_b6_data['b6_col_amount']=(!empty($_POST['col_amount1_in_b6'])?$prod->xss_fix($_POST['col_amount1_in_b6']):"1");					

$update_in_b6_data['p1600_fac']=1;
$update_in_b6_data['p1601_fac']=(!empty($_POST['p1601_fac'])?$prod->xss_fix($_POST['p1601_fac']):"1");
$update_in_b6_data['p1604_fac']=(!empty($_POST['p1604_fac'])?$prod->xss_fix($_POST['p1604_fac']):"1");
$update_in_b6_data['p1621_fac']=(!empty($_POST['p1621_fac'])?$prod->xss_fix($_POST['p1621_fac']):"1");
$update_in_b6_data['p1624_fac']=(!empty($_POST['p1624_fac'])?$prod->xss_fix($_POST['p1624_fac']):"1");
$update_in_b6_data['p1641_fac']=(!empty($_POST['p1641_fac'])?$prod->xss_fix($_POST['p1641_fac']):"1");
$update_in_b6_data['p1644_fac']=(!empty($_POST['p1644_fac'])?$prod->xss_fix($_POST['p1644_fac']):"1");
$update_in_b6_data['p1606_fac']=(!empty($_POST['p1606_fac'])?$prod->xss_fix($_POST['p1606_fac']):"1");
$update_in_b6_data['p1626_fac']=(!empty($_POST['p1626_fac'])?$prod->xss_fix($_POST['p1626_fac']):"1");
$update_in_b6_data['p1646_fac']=(!empty($_POST['p1646_fac'])?$prod->xss_fix($_POST['p1646_fac']):"1");

$update_in_b6_data['col_price_in_b6']=(!empty($_POST['col_price_in_b6'])?$prod->xss_fix($_POST['col_price_in_b6']):"1");
$update_in_b6_data['fac_cl_in_b6']=(!empty($_POST['fac_cl_in_b6'])?$prod->xss_fix($_POST['fac_cl_in_b6']):"1");
$update_in_b6_data['o_price_in_b6']=(!empty($_POST['o_price_in_b6'])?$prod->xss_fix($_POST['o_price_in_b6']):"1");

$update_in_b6_data['col_apus_in_b6']=(!empty($_POST['col_apus_in_b6'])?$prod->xss_fix($_POST['col_apus_in_b6']):"1");
$update_in_b6_data['fac_prod_in_b6']=(!empty($_POST['fac_prod_in_b6'])?$prod->xss_fix($_POST['fac_prod_in_b6']):"1");
$update_in_b6_data['o_apus_in_b6']=(!empty($_POST['o_apus_in_b6'])?$prod->xss_fix($_POST['o_apus_in_b6']):"1");

$update_in_b6_data['col_labc_in_b6']=(!empty($_POST['col_labc_in_b6'])?$prod->xss_fix($_POST['col_labc_in_b6']):"1");
$update_in_b6_data['fac_labc_in_b6']=(!empty($_POST['fac_labc_in_b6'])?$prod->xss_fix($_POST['fac_labc_in_b6']):"1");
$update_in_b6_data['total_labcs_in_b6']=(!empty($_POST['total_labcs_in_b6'])?$prod->xss_fix($_POST['total_labcs_in_b6']):"0");

//b7 in

$update_in_b7_data['o_id']=$update_data['o_id'];

$update_in_b7_data['layout_id']=(!empty($_POST['b7_selected_layoutline'])?$prod->xss_fix($_POST['b7_selected_layoutline']):"1");
$update_in_b7_data['window_id']=0;

$update_in_b7_data['col_amount_in_b7']=(!empty($_POST['col_amount1_in_b7'])?$prod->xss_fix($_POST['col_amount1_in_b7']):"1");

$update_in_b7_data['p1700_fac']=1;
$update_in_b7_data['p1701_fac']=(!empty($_POST['p1701_fac'])?$prod->xss_fix($_POST['p1701_fac']):"1");
$update_in_b7_data['p1702_fac']=(!empty($_POST['p1702_fac'])?$prod->xss_fix($_POST['p1702_fac']):"1");
$update_in_b7_data['p1703_fac']=(!empty($_POST['p1703_fac'])?$prod->xss_fix($_POST['p1703_fac']):"1");
$update_in_b7_data['p1704_fac']=(!empty($_POST['p1704_fac'])?$prod->xss_fix($_POST['p1704_fac']):"1");
$update_in_b7_data['p1706_fac']=(!empty($_POST['p1706_fac'])?$prod->xss_fix($_POST['p1706_fac']):"1");
$update_in_b7_data['p1707_fac']=(!empty($_POST['p1707_fac'])?$prod->xss_fix($_POST['p1707_fac']):"1");
$update_in_b7_data['p1708_fac']=(!empty($_POST['p1708_fac'])?$prod->xss_fix($_POST['p1708_fac']):"1");

$update_in_b7_data['p1721_fac']=(!empty($_POST['p1721_fac'])?$prod->xss_fix($_POST['p1721_fac']):"1");
$update_in_b7_data['p1722_fac']=(!empty($_POST['p1722_fac'])?$prod->xss_fix($_POST['p1722_fac']):"1");
$update_in_b7_data['p1723_fac']=(!empty($_POST['p1723_fac'])?$prod->xss_fix($_POST['p1723_fac']):"1");
$update_in_b7_data['p1724_fac']=(!empty($_POST['p1724_fac'])?$prod->xss_fix($_POST['p1724_fac']):"1");
$update_in_b7_data['p1726_fac']=(!empty($_POST['p1726_fac'])?$prod->xss_fix($_POST['p1726_fac']):"1");
$update_in_b7_data['p1727_fac']=(!empty($_POST['p1727_fac'])?$prod->xss_fix($_POST['p1727_fac']):"1");
$update_in_b7_data['p1728_fac']=(!empty($_POST['p1728_fac'])?$prod->xss_fix($_POST['p1728_fac']):"1");

$update_in_b7_data['p1741_fac']=(!empty($_POST['p1741_fac'])?$prod->xss_fix($_POST['p1741_fac']):"1");
$update_in_b7_data['p1742_fac']=(!empty($_POST['p1742_fac'])?$prod->xss_fix($_POST['p1742_fac']):"1");
$update_in_b7_data['p1743_fac']=(!empty($_POST['p1743_fac'])?$prod->xss_fix($_POST['p1743_fac']):"1");
$update_in_b7_data['p1744_fac']=(!empty($_POST['p1744_fac'])?$prod->xss_fix($_POST['p1744_fac']):"1");
$update_in_b7_data['p1746_fac']=(!empty($_POST['p1746_fac'])?$prod->xss_fix($_POST['p1746_fac']):"1");
$update_in_b7_data['p1747_fac']=(!empty($_POST['p1747_fac'])?$prod->xss_fix($_POST['p1747_fac']):"1");
$update_in_b7_data['p1748_fac']=(!empty($_POST['p1748_fac'])?$prod->xss_fix($_POST['p1748_fac']):"1");

$update_in_b7_data['col_price_in_b7']=(!empty($_POST['col_price_in_b7'])?$prod->xss_fix($_POST['col_price_in_b7']):"1");
$update_in_b7_data['fac_cl_in_b7']=(!empty($_POST['fac_cl_in_b7'])?$prod->xss_fix($_POST['fac_cl_in_b7']):"1");
$update_in_b7_data['o_price_in_b7']=(!empty($_POST['o_price_in_b7'])?$prod->xss_fix($_POST['o_price_in_b7']):"1");

$update_in_b7_data['col_apus_in_b7']=(!empty($_POST['col_apus_in_b7'])?$prod->xss_fix($_POST['col_apus_in_b7']):"1");
$update_in_b7_data['fac_prod_in_b7']=(!empty($_POST['fac_prod_in_b7'])?$prod->xss_fix($_POST['fac_prod_in_b7']):"1");
$update_in_b7_data['o_apus_in_b7']=(!empty($_POST['o_apus_in_b7'])?$prod->xss_fix($_POST['o_apus_in_b7']):"1");

$update_in_b7_data['col_labc_in_b7']=(!empty($_POST['col_labc_in_b7'])?$prod->xss_fix($_POST['col_labc_in_b7']):"1");
$update_in_b7_data['fac_labc_in_b7']=(!empty($_POST['fac_labc_in_b7'])?$prod->xss_fix($_POST['fac_labc_in_b7']):"1");
$update_in_b7_data['total_labcs_in_b7']=(!empty($_POST['total_labcs_in_b7'])?$prod->xss_fix($_POST['total_labcs_in_b7']):"0");

//b8 in

$update_in_b8_data['o_id']=$update_data['o_id'];

if(!empty($_POST['b8_selected_layoutline']))
{
    $update_in_b8_data['layout_id']=$prod->xss_fix($_POST['b8_selected_layoutline']);
}
else
{
    $update_in_b8_data['layout_id']="";
}
$update_in_b8_data['window_id']=0;

$update_in_b8_data['col_amount_in_b8']=(!empty($_POST['col_amount1_in_b8'])?$prod->xss_fix($_POST['col_amount1_in_b8']):"1");

$update_in_b8_data['p1800_fac']=1;
$update_in_b8_data['p1801_fac']=(!empty($_POST['p1801_fac'])?$prod->xss_fix($_POST['p1801_fac']):"1");
$update_in_b8_data['p1802_fac']=(!empty($_POST['p1802_fac'])?$prod->xss_fix($_POST['p1802_fac']):"1");
$update_in_b8_data['p1803_fac']=(!empty($_POST['p1803_fac'])?$prod->xss_fix($_POST['p1803_fac']):"1");
$update_in_b8_data['p1804_fac']=(!empty($_POST['p1804_fac'])?$prod->xss_fix($_POST['p1804_fac']):"1");
$update_in_b8_data['p1806_fac']=(!empty($_POST['p1806_fac'])?$prod->xss_fix($_POST['p1806_fac']):"1");
$update_in_b8_data['p1807_fac']=(!empty($_POST['p1807_fac'])?$prod->xss_fix($_POST['p1807_fac']):"1");
$update_in_b8_data['p1808_fac']=(!empty($_POST['p1808_fac'])?$prod->xss_fix($_POST['p1808_fac']):"1");

$update_in_b8_data['p1821_fac']=(!empty($_POST['p1821_fac'])?$prod->xss_fix($_POST['p1821_fac']):"1");
$update_in_b8_data['p1822_fac']=(!empty($_POST['p1822_fac'])?$prod->xss_fix($_POST['p1822_fac']):"1");
$update_in_b8_data['p1823_fac']=(!empty($_POST['p1823_fac'])?$prod->xss_fix($_POST['p1823_fac']):"1");
$update_in_b8_data['p1824_fac']=(!empty($_POST['p1824_fac'])?$prod->xss_fix($_POST['p1824_fac']):"1");
$update_in_b8_data['p1826_fac']=(!empty($_POST['p1826_fac'])?$prod->xss_fix($_POST['p1826_fac']):"1");
$update_in_b8_data['p1827_fac']=(!empty($_POST['p1827_fac'])?$prod->xss_fix($_POST['p1827_fac']):"1");
$update_in_b8_data['p1828_fac']=(!empty($_POST['p1828_fac'])?$prod->xss_fix($_POST['p1828_fac']):"1");

$update_in_b8_data['p1841_fac']=(!empty($_POST['p1841_fac'])?$prod->xss_fix($_POST['p1841_fac']):"1");
$update_in_b8_data['p1842_fac']=(!empty($_POST['p1842_fac'])?$prod->xss_fix($_POST['p1842_fac']):"1");
$update_in_b8_data['p1843_fac']=(!empty($_POST['p1843_fac'])?$prod->xss_fix($_POST['p1843_fac']):"1");
$update_in_b8_data['p1844_fac']=(!empty($_POST['p1844_fac'])?$prod->xss_fix($_POST['p1844_fac']):"1");
$update_in_b8_data['p1846_fac']=(!empty($_POST['p1846_fac'])?$prod->xss_fix($_POST['p1846_fac']):"1");
$update_in_b8_data['p1847_fac']=(!empty($_POST['p1847_fac'])?$prod->xss_fix($_POST['p1847_fac']):"1");
$update_in_b8_data['p1848_fac']=(!empty($_POST['p1848_fac'])?$prod->xss_fix($_POST['p1848_fac']):"1");

$update_in_b8_data['col_price_in_b8']=(!empty($_POST['col_price_in_b8'])?$prod->xss_fix($_POST['col_price_in_b8']):"1");
$update_in_b8_data['fac_cl_in_b8']=(!empty($_POST['fac_cl_in_b8'])?$prod->xss_fix($_POST['fac_cl_in_b8']):"1");
$update_in_b8_data['o_price_in_b8']=(!empty($_POST['o_price_in_b8'])?$prod->xss_fix($_POST['o_price_in_b8']):"1");

$update_in_b8_data['col_apus_in_b8']=(!empty($_POST['col_apus_in_b8'])?$prod->xss_fix($_POST['col_apus_in_b8']):"1");
$update_in_b8_data['fac_prod_in_b8']=(!empty($_POST['fac_prod_in_b8'])?$prod->xss_fix($_POST['fac_prod_in_b8']):"1");
$update_in_b8_data['o_apus_in_b8']=(!empty($_POST['o_apus_in_b8'])?$prod->xss_fix($_POST['o_apus_in_b8']):"1");

$update_in_b8_data['col_labc_in_b8']=(!empty($_POST['col_labc_in_b8'])?$prod->xss_fix($_POST['col_labc_in_b8']):"1");
$update_in_b8_data['fac_labc_in_b8']=(!empty($_POST['fac_labc_in_b8'])?$prod->xss_fix($_POST['fac_labc_in_b8']):"1");
$update_in_b8_data['total_labcs_in_b8']=(!empty($_POST['total_labcs_in_b8'])?$prod->xss_fix($_POST['total_labcs_in_b8']):"1");

//b1 g 

$update_g_b1_data['o_id']=$update_data['o_id'];

$update_g_b1_data['col_price_g_b1']=(!empty($_POST['col_price_g_b1'])?$prod->xss_fix($_POST['col_price_g_b1']):"1");
$update_g_b1_data['fac_cl_g_b1']=(!empty($_POST['fac_cl_g_b1'])?$prod->xss_fix($_POST['fac_cl_g_b1']):"1");
$update_g_b1_data['o_price_g_b1']=(!empty($_POST['o_price_g_b1'])?$prod->xss_fix($_POST['o_price_g_b1']):"1");

$update_g_b1_data['p11g8_fac']=(!empty($_POST['p11g8_fac'])?$prod->xss_fix($_POST['p11g8_fac']):"1");
$update_g_b1_data['p11g3_fac']=(!empty($_POST['p11g3_fac'])?$prod->xss_fix($_POST['p11g3_fac']):"1");
$update_g_b1_data['p11g6_fac']=(!empty($_POST['p11g6_fac'])?$prod->xss_fix($_POST['p11g6_fac']):"1");
$update_g_b1_data['p11gb_fac']=(!empty($_POST['p11gb_fac'])?$prod->xss_fix($_POST['p11gb_fac']):"1");
$update_g_b1_data['p11gm_fac']=(!empty($_POST['p11gm_fac'])?$prod->xss_fix($_POST['p11gm_fac']):"1");
$update_g_b1_data['p11gt_fac']=(!empty($_POST['p11gt_fac'])?$prod->xss_fix($_POST['p11gt_fac']):"1");
$update_g_b1_data['p11gs_fac']=(!empty($_POST['p11gs_fac'])?$prod->xss_fix($_POST['p11gs_fac']):"1");

$update_g_b1_data['col_apus_g_b1']=(!empty($_POST['col_apus_g_b1'])?$prod->xss_fix($_POST['col_apus_g_b1']):"1");
$update_g_b1_data['fac_prod_g_b1']=(!empty($_POST['fac_prod_g_b1'])?$prod->xss_fix($_POST['fac_prod_g_b1']):"1");
$update_g_b1_data['o_apus_g_b1']=(!empty($_POST['o_apus_g_b1'])?$prod->xss_fix($_POST['o_apus_g_b1']):"1");

$update_g_b1_data['col_labc_g_b1']=(!empty($_POST['col_labc_g_b1'])?$prod->xss_fix($_POST['col_labc_g_b1']):"1");
$update_g_b1_data['fac_labc_g_b1']=(!empty($_POST['fac_labc_g_b1'])?$prod->xss_fix($_POST['fac_labc_g_b1']):"1");
$update_g_b1_data['total_labcs_g_b1']=(!empty($_POST['total_labcs_g_b1'])?$prod->xss_fix($_POST['total_labcs_g_b1']):"1");

$update_g_b1_data['col_amount_g_b1']=(!empty($_POST['col_amount1_g_b1'])?$prod->xss_fix($_POST['col_amount1_g_b1']):"0");

//b1 ex 

$update_ex_b1_data['o_id']=$update_data['o_id'];
$update_ex_b1_data['levels_over_ground']=(!empty($_POST['b1_levels_over_ground'])?$prod->xss_fix($_POST['b1_levels_over_ground']):"0");

$update_ex_b1_data['col_price_ex_b1']=(!empty($_POST['col_price_ex_b1'])?$prod->xss_fix($_POST['col_price_ex_b1']):"1");
$update_ex_b1_data['fac_cl_ex_b1']=(!empty($_POST['fac_cl_ex_b1'])?$prod->xss_fix($_POST['fac_cl_ex_b1']):"1");
$update_ex_b1_data['o_price_ex_b1']=(!empty($_POST['o_price_ex_b1'])?$prod->xss_fix($_POST['o_price_ex_b1']):"1");

$update_ex_b1_data['p1168_fac']=(!empty($_POST['p1168_fac'])?$prod->xss_fix($_POST['p1168_fac']):"1");
$update_ex_b1_data['p1163_fac']=(!empty($_POST['p1163_fac'])?$prod->xss_fix($_POST['p1163_fac']):"1");
$update_ex_b1_data['p1166_fac']=(!empty($_POST['p1166_fac'])?$prod->xss_fix($_POST['p1166_fac']):"1");
$update_ex_b1_data['p1181_fac']=(!empty($_POST['p1181_fac'])?$prod->xss_fix($_POST['p1181_fac']):"1");
$update_ex_b1_data['p116b_fac']=(!empty($_POST['p116b_fac'])?$prod->xss_fix($_POST['p116b_fac']):"1");
$update_ex_b1_data['p116m_fac']=(!empty($_POST['p116m_fac'])?$prod->xss_fix($_POST['p116m_fac']):"1");
$update_ex_b1_data['p116t_fac']=(!empty($_POST['p116t_fac'])?$prod->xss_fix($_POST['p116t_fac']):"1");
$update_ex_b1_data['p118s_fac']=(!empty($_POST['p118s_fac'])?$prod->xss_fix($_POST['p118s_fac']):"1");

$update_ex_b1_data['col_apus_ex_b1']=(!empty($_POST['col_apus_ex_b1'])?$prod->xss_fix($_POST['col_apus_ex_b1']):"1");
$update_ex_b1_data['fac_prod_ex_b1']=(!empty($_POST['fac_prod_ex_b1'])?$prod->xss_fix($_POST['fac_prod_ex_b1']):"1");
$update_ex_b1_data['o_apus_ex_b1']=(!empty($_POST['o_apus_ex_b1'])?$prod->xss_fix($_POST['o_apus_ex_b1']):"1");

$update_ex_b1_data['col_labc_ex_b1']=(!empty($_POST['col_labc_ex_b1'])?$prod->xss_fix($_POST['col_labc_ex_b1']):"1");
$update_ex_b1_data['fac_labc_ex_b1']=(!empty($_POST['fac_labc_ex_b1'])?$prod->xss_fix($_POST['fac_labc_ex_b1']):"1");
$update_ex_b1_data['total_labcs_ex_b1']=(!empty($_POST['total_labcs_ex_b1'])?$prod->xss_fix($_POST['total_labcs_ex_b1']):"1");

$update_ex_b1_data['col_amount_ex_b1']=(!empty($_POST['col_amount1_ex_b1'])?$prod->xss_fix($_POST['col_amount1_ex_b1']):"0");

//b5 ex

$update_ex_b5_data['o_id']=$update_data['o_id'];
$update_ex_b5_data['levels_over_ground']=(!empty($_POST['b1_levels_over_ground'])?$prod->xss_fix($_POST['b1_levels_over_ground']):"0");
$update_ex_b5_data['col_price_ex_b5']=(!empty($_POST['col_price_ex_b5'])?$prod->xss_fix($_POST['col_price_ex_b5']):"1");
$update_ex_b5_data['fac_cl_ex_b5']=(!empty($_POST['fac_cl_ex_b5'])?$prod->xss_fix($_POST['fac_cl_ex_b5']):"1");
$update_ex_b5_data['o_price_ex_b5']=(!empty($_POST['o_price_ex_b5'])?$prod->xss_fix($_POST['o_price_ex_b5']):"1");

$update_ex_b5_data['p1561_fac']=(!empty($_POST['p1561_fac'])?$prod->xss_fix($_POST['p1561_fac']):"1");
$update_ex_b5_data['p1563_fac']=(!empty($_POST['p1563_fac'])?$prod->xss_fix($_POST['p1563_fac']):"1");
$update_ex_b5_data['p1566_fac']=(!empty($_POST['p1566_fac'])?$prod->xss_fix($_POST['p1566_fac']):"1");
$update_ex_b5_data['p1581_fac']=(!empty($_POST['p1581_fac'])?$prod->xss_fix($_POST['p1581_fac']):"1");

$update_ex_b5_data['col_apus_ex_b5']=(!empty($_POST['col_apus_ex_b5'])?$prod->xss_fix($_POST['col_apus_ex_b5']):"1");
$update_ex_b5_data['fac_prod_ex_b5']=(!empty($_POST['fac_prod_ex_b5'])?$prod->xss_fix($_POST['fac_prod_ex_b5']):"1");
$update_ex_b5_data['o_apus_ex_b5']=(!empty($_POST['o_apus_ex_b5'])?$prod->xss_fix($_POST['o_apus_ex_b5']):"1");

$update_ex_b5_data['col_labc_ex_b5']=(!empty($_POST['col_labc_ex_b5'])?$prod->xss_fix($_POST['col_labc_ex_b5']):"1");
$update_ex_b5_data['fac_labc_ex_b5']=(!empty($_POST['fac_labc_ex_b5'])?$prod->xss_fix($_POST['fac_labc_ex_b5']):"1");
$update_ex_b5_data['total_labcs_ex_b5']=(!empty($_POST['total_labcs_ex_b5'])?$prod->xss_fix($_POST['total_labcs_ex_b5']):"1");

$update_ex_b5_data['col_amount_ex_b5']=(!empty($_POST['col_amount1_ex_b5'])?$prod->xss_fix($_POST['col_amount1_ex_b5']):"0");

//$update_ex_b5_data['levels_over_ground']=$prod->xss_fix($_POST['b5_levels_over_ground']);

//b6 ex

$update_ex_b6_data['o_id']=$update_data['o_id'];
$update_ex_b6_data['col_price_ex_b6']=(!empty($_POST['col_price_ex_b6'])?$prod->xss_fix($_POST['col_price_ex_b6']):"1");
$update_ex_b6_data['fac_cl_ex_b6']=(!empty($_POST['fac_cl_ex_b6'])?$prod->xss_fix($_POST['fac_cl_ex_b6']):"1");
$update_ex_b6_data['o_price_ex_b6']=(!empty($_POST['o_price_ex_b6'])?$prod->xss_fix($_POST['o_price_ex_b6']):"1");

$update_ex_b6_data['p1661_fac']=(!empty($_POST['p1661_fac'])?$prod->xss_fix($_POST['p1661_fac']):"1");
$update_ex_b6_data['p1663_fac']=(!empty($_POST['p1663_fac'])?$prod->xss_fix($_POST['p1663_fac']):"1");
$update_ex_b6_data['p1666_fac']=(!empty($_POST['p1666_fac'])?$prod->xss_fix($_POST['p1666_fac']):"1");
$update_ex_b6_data['p166p_fac']=(!empty($_POST['p166p_fac'])?$prod->xss_fix($_POST['p166p_fac']):"1");
$update_ex_b6_data['p1681_fac']=(!empty($_POST['p1681_fac'])?$prod->xss_fix($_POST['p1681_fac']):"1");

$update_ex_b6_data['col_apus_ex_b6']=(!empty($_POST['col_apus_ex_b6'])?$prod->xss_fix($_POST['col_apus_ex_b6']):"1");
$update_ex_b6_data['fac_prod_ex_b6']=(!empty($_POST['fac_prod_ex_b6'])?$prod->xss_fix($_POST['fac_prod_ex_b6']):"1");
$update_ex_b6_data['o_apus_ex_b6']=(!empty($_POST['o_apus_ex_b6'])?$prod->xss_fix($_POST['o_apus_ex_b6']):"1");

$update_ex_b6_data['col_labc_ex_b6']=(!empty($_POST['col_labc_ex_b6'])?$prod->xss_fix($_POST['col_labc_ex_b6']):"1");
$update_ex_b6_data['fac_labc_ex_b6']=(!empty($_POST['fac_labc_ex_b6'])?$prod->xss_fix($_POST['fac_labc_ex_b6']):"1");
$update_ex_b6_data['total_labcs_ex_b6']=(!empty($_POST['total_labcs_ex_b6'])?$prod->xss_fix($_POST['total_labcs_ex_b6']):"1");

$update_ex_b6_data['col_amount_ex_b6']=(!empty($_POST['col_amount1_ex_b6'])?$prod->xss_fix($_POST['col_amount1_ex_b6']):"0");

//$update_ex_b6_data['levels_over_ground']=$prod->xss_fix($_POST['b5_levels_over_ground']);

					
//b7 ex

$update_ex_b7_data['o_id']=$update_data['o_id'];


$update_ex_b7_data['col_price_ex_b7']=(!empty($_POST['col_price_ex_b7'])?$prod->xss_fix($_POST['col_price_ex_b7']):"1");
$update_ex_b7_data['fac_cl_ex_b7']=(!empty($_POST['fac_cl_ex_b7'])?$prod->xss_fix($_POST['fac_cl_ex_b7']):"1");
$update_ex_b7_data['o_price_ex_b7']=(!empty($_POST['o_price_ex_b7'])?$prod->xss_fix($_POST['o_price_ex_b7']):"1");

$update_ex_b7_data['p1761_fac']=(!empty($_POST['p1761_fac'])?$prod->xss_fix($_POST['p1761_fac']):"1");
$update_ex_b7_data['p1762_fac']=(!empty($_POST['p1762_fac'])?$prod->xss_fix($_POST['p1762_fac']):"1");
$update_ex_b7_data['p1763_fac']=(!empty($_POST['p1763_fac'])?$prod->xss_fix($_POST['p1763_fac']):"1");
$update_ex_b7_data['p1766_fac']=(!empty($_POST['p1766_fac'])?$prod->xss_fix($_POST['p1766_fac']):"1");
$update_ex_b7_data['p1781_fac']=(!empty($_POST['p1781_fac'])?$prod->xss_fix($_POST['p1781_fac']):"1");

$update_ex_b7_data['col_apus_ex_b7']=(!empty($_POST['col_apus_ex_b7'])?$prod->xss_fix($_POST['col_apus_ex_b7']):"1");
$update_ex_b7_data['fac_prod_ex_b7']=(!empty($_POST['fac_prod_ex_b7'])?$prod->xss_fix($_POST['fac_prod_ex_b7']):"1");
$update_ex_b7_data['o_apus_ex_b7']=(!empty($_POST['o_apus_ex_b7'])?$prod->xss_fix($_POST['o_apus_ex_b7']):"1");

$update_ex_b7_data['col_labc_ex_b7']=(!empty($_POST['col_labc_ex_b7'])?$prod->xss_fix($_POST['col_labc_ex_b7']):"1");
$update_ex_b7_data['fac_labc_ex_b7']=(!empty($_POST['fac_labc_ex_b7'])?$prod->xss_fix($_POST['fac_labc_ex_b7']):"1");
$update_ex_b7_data['total_labcs_ex_b7']=(!empty($_POST['total_labcs_ex_b7'])?$prod->xss_fix($_POST['total_labcs_ex_b7']):"1");

$update_ex_b7_data['col_amount_ex_b7']=(!empty($_POST['col_amount1_ex_b7'])?$prod->xss_fix($_POST['col_amount1_ex_b7']):"0");

//b8 ex

$update_ex_b8_data['o_id']=$update_data['o_id'];


$update_ex_b8_data['col_price_ex_b8']=(!empty($_POST['col_price_ex_b8'])?$prod->xss_fix($_POST['col_price_ex_b8']):"1");
$update_ex_b8_data['fac_cl_ex_b8']=(!empty($_POST['fac_cl_ex_b8'])?$prod->xss_fix($_POST['fac_cl_ex_b8']):"1");
$update_ex_b8_data['o_price_ex_b8']=(!empty($_POST['o_price_ex_b8'])?$prod->xss_fix($_POST['o_price_ex_b8']):"1");

$update_ex_b8_data['p1861_fac']=(!empty($_POST['p1861_fac'])?$prod->xss_fix($_POST['p1861_fac']):"1");
$update_ex_b8_data['p1863_fac']=(!empty($_POST['p1863_fac'])?$prod->xss_fix($_POST['p1863_fac']):"1");
$update_ex_b8_data['p1866_fac']=(!empty($_POST['p1866_fac'])?$prod->xss_fix($_POST['p1866_fac']):"1");
$update_ex_b8_data['p1881_fac']=(!empty($_POST['p1881_fac'])?$prod->xss_fix($_POST['p1881_fac']):"1");

$update_ex_b8_data['col_apus_ex_b8']=(!empty($_POST['col_apus_ex_b8'])?$prod->xss_fix($_POST['col_apus_ex_b8']):"1");
$update_ex_b8_data['fac_prod_ex_b8']=(!empty($_POST['fac_prod_ex_b8'])?$prod->xss_fix($_POST['fac_prod_ex_b8']):"1");
$update_ex_b8_data['o_apus_ex_b8']=(!empty($_POST['o_apus_ex_b8'])?$prod->xss_fix($_POST['o_apus_ex_b8']):"1");

$update_ex_b8_data['col_labc_ex_b8']=(!empty($_POST['col_labc_ex_b8'])?$prod->xss_fix($_POST['col_labc_ex_b8']):"1");
$update_ex_b8_data['fac_labc_ex_b8']=(!empty($_POST['fac_labc_ex_b8'])?$prod->xss_fix($_POST['fac_labc_ex_b8']):"1");
$update_ex_b8_data['total_labcs_ex_b8']=(!empty($_POST['total_labcs_ex_b8'])?$prod->xss_fix($_POST['total_labcs_ex_b8']):"1");

$update_ex_b8_data['col_amount_ex_b8']=(!empty($_POST['col_amount1_ex_b8'])?$prod->xss_fix($_POST['col_amount1_ex_b8']):"0");

if (strpos($update_data['collection'], 'p1501') === false) 
{	
	$update_in_b5_data['col_amount_in_b5']=0;
	$update_in_b5_data['fac_cl_in_b5']=0;
	$update_in_b5_data['layout_id']=0;
	$update_in_b5_data['window_id']=0;
}

if (strpos($update_data['collection'], 'p1601') === false) 
{	
	$update_in_b6_data['col_amount_in_b6']=0;
	$update_in_b6_data['fac_cl_in_b6']=0;
	$update_in_b6_data['layout_id']=0;
	$update_in_b6_data['window_id']=0;
}

if (strpos($update_data['collection'], 'p1701') === false) 
{	
	$update_in_b7_data['col_amount_in_b7']=0;
	$update_in_b7_data['fac_cl_in_b7']=0;
	$update_in_b7_data['layout_id']=0;
	$update_in_b7_data['window_id']=0;
}

if (strpos($update_data['collection'], 'p1801') === false) 
{	
	$update_in_b8_data['col_amount_in_b8']=0;
	$update_in_b8_data['fac_cl_in_b8']=0;
	$update_in_b8_data['layout_id']=0;
	$update_in_b8_data['window_id']=0;
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

$update_data['accepted_by']=$_COOKIE['client_id'];

if(isset($_GET['status']))
{
    if($_GET['status']!="accepted")
    {
        $update_data['accepted_by']=$_COOKIE['client_id'];
    }
    else
    {
        $update_data['accepted_by']=$order['accepted_by'];
    }
}


$prod->update_order2(json_encode($update_data));

$o_desc_in_b1=$prod->get_o_desc_in_b1($update_data['o_id']);

if(!empty($o_desc_in_b1))
{
    $prod->update_o_desc_in_b1(json_encode($update_in_b1_data));
}
else
{
    $prod->add_o_desc_in_b1(json_encode($update_in_b1_data));
}

$o_desc_in_b3=$prod->get_o_desc_in_b3($update_data['o_id']);

if(!empty($o_desc_in_b3))
{
    $prod->update_o_desc_in_b32(json_encode($update_in_b3_data));
}
else
{
    $prod->add_o_desc_in_b32(json_encode($update_in_b3_data));
}

$o_desc_in_b5=$prod->get_o_desc_in_b5($update_data['o_id']);

if(!empty($o_desc_in_b5))
{
    $prod->update_o_desc_in_b52(json_encode($update_in_b5_data));
}
else
{
    $prod->add_o_desc_in_b52(json_encode($update_in_b5_data));
}



$o_desc_in_b6=$prod->get_o_desc_in_b6($update_data['o_id']);

if(!empty($o_desc_in_b6))
{
    $prod->update_o_desc_in_b6(json_encode($update_in_b6_data));
}
else
{
    $prod->add_o_desc_in_b6(json_encode($update_in_b6_data));
}

$o_desc_in_b7=$prod->get_o_desc_in_b7($update_data['o_id']);

if(!empty($o_desc_in_b7))
{
    $prod->update_o_desc_in_b72(json_encode($update_in_b7_data));
}
else
{
    $prod->add_o_desc_in_b72(json_encode($update_in_b7_data));
}

$prod->update_o_desc_in_b8(json_encode($update_in_b8_data));

$o_desc_ex_b1=$prod->get_o_desc_ex_b1($update_data['o_id']);

if(!empty($o_desc_ex_b1))
{
    $prod->update_o_desc_ex_b1(json_encode($update_ex_b1_data));
}
else
{
    $prod->add_o_desc_ex_b1(json_encode($update_ex_b1_data));
}

$o_desc_g_b1=$prod->get_o_desc_g_b1($update_data['o_id']);

if(!empty($o_desc_g_b1))
{
    $prod->update_o_desc_g_b1(json_encode($update_g_b1_data));
}
else
{
    $prod->add_o_desc_g_b1(json_encode($update_g_b1_data));
}

$o_desc_ex_b5=$prod->get_o_desc_ex_b5($update_data['o_id']);

if(!empty($o_desc_ex_b5))
{
    $prod->update_o_desc_ex_b52(json_encode($update_ex_b5_data));
}
else
{
    $prod->add_o_desc_ex_b52(json_encode($update_ex_b5_data));
}



$o_desc_ex_b6=$prod->get_o_desc_ex_b6($update_data['o_id']);

if(!empty($o_desc_ex_b6))
{
    $prod->update_o_desc_ex_b6(json_encode($update_ex_b6_data));
}
else
{
    $prod->add_o_desc_ex_b6(json_encode($update_ex_b6_data));
}

$o_desc_ex_b7=$prod->get_o_desc_ex_b7($update_data['o_id']);

if(!empty($o_desc_ex_b7))
{
    $prod->update_o_desc_ex_b72(json_encode($update_ex_b7_data));
}
else
{
    $prod->add_o_desc_ex_b72(json_encode($update_ex_b7_data));
}

if(!empty($o_desc_ex_b7))
{
    $prod->update_o_desc_ex_b8(json_encode($update_ex_b8_data));
}
else
{
    $prod->add_o_desc_ex_b8(json_encode($update_ex_b8_data));
}
//$prod->update_o_desc_b0($update_data['o_id'],-$total_price); probably not used

$o_desc_allproducts=$prod->get_o_infos_allproducts($update_data['o_id']);
if(!empty($o_desc_allproducts))
{
    $update_o_desc_allproducts['o_id']=$update_data['o_id'];
    $update_o_desc_allproducts['basement']=$prod->xss_fix($_POST['basement']);
    $update_o_desc_allproducts['levels_over_ground']=$prod->xss_fix($_POST['levels_over_ground']);
    $update_o_desc_allproducts['length']=$prod->xss_fix($_POST['e_length']);
    $update_o_desc_allproducts['width']=$prod->xss_fix($_POST['e_width']);
    $update_o_desc_allproducts['roof_type']=$prod->xss_fix($_POST['rs_id']);
    $update_o_desc_allproducts['roof_tilt']=$prod->xss_fix($_POST['r_tilt']);
    $update_o_desc_allproducts['stairs_id']=$prod->xss_fix($_POST['st_id1']);
    $update_o_desc_allproducts['knee_wall']=$prod->xss_fix($_POST['r_kneewall']);
    $update_o_desc_allproducts['rop_id']=$prod->xss_fix($_POST['rop_id']);
    $update_o_desc_allproducts['roof_material']=$prod->xss_fix($_POST['roof_color']);
    $facade_color_1=$prod->xss_fix($_POST['facade_color_1']);
    $facade_color_2=$prod->xss_fix($_POST['facade_color_2']);
    $update_o_desc_allproducts['wlc_id']=$facade_color_1.";".$facade_color_2.";";
    $update_o_desc_allproducts['ww_id']=$prod->xss_fix($_POST['ww_id']);
    $update_o_desc_allproducts['wc_id']=$prod->xss_fix($_POST['wc_id']);
    $update_o_desc_allproducts['gutter']=$prod->xss_fix($_POST['gutter']);
    $update_o_desc_allproducts['door_texture']=$prod->xss_fix($_POST['door_texture']);
    $update_o_desc_allproducts['dsp_id']=$prod->xss_fix($_POST['door_shape_sides']);
    $update_o_desc_allproducts['door_color']=$prod->xss_fix($_POST['door_color']);
    $update_o_desc_allproducts['gc_id']=$prod->xss_fix($_POST['gc_id']);
    $update_o_desc_allproducts['pbp_id']=$prod->xss_fix($_POST['environment']);
    
    $garage_size=$prod->xss_fix($_POST['garage_size']);
    
    $garage_array=explode(' ',$garage_size);
   
        $update_o_desc_allproducts['gc_length']=(float) $garage_array[0];
        $update_o_desc_allproducts['gc_width']=(float) $garage_array[1];
        // if($garage_size=="3x6")
        // {
        //     $update_o_desc_allproducts['gc_length']=3;
        //     $update_o_desc_allproducts['gc_width']=6;
        // }
        // if($garage_size=="6x6")
        // {
        //     $update_o_desc_allproducts['gc_length']=6;
        //     $update_o_desc_allproducts['gc_width']=6;
        // }
        // if($garage_size=="6x9")
        // {
        //     $update_o_desc_allproducts['gc_length']=6;
        //     $update_o_desc_allproducts['gc_width']=9;
        // }
        $update_o_desc_allproducts['gc_height']=2.5;
    

    $prod->update_o_desc_allproducts(json_encode($update_o_desc_allproducts));
}
else
{
    $add_o_desc_allproducts_data['o_id']=$update_data['o_id'];
    $add_o_desc_allproducts_data['stairs_id']=$prod->xss_fix($_POST['st_id1'] ?? '0');
    $add_o_desc_allproducts_data['basement']=$prod->xss_fix($_POST['basement'] ?? 0);
    $add_o_desc_allproducts_data['levels_over_ground']=$prod->xss_fix($_POST['levels_over_ground'] ?? 0);
    $add_o_desc_allproducts_data['length']=$prod->xss_fix($_POST['e_length'] ?? 0);
    $add_o_desc_allproducts_data['width']=$prod->xss_fix($_POST['e_width'] ?? 0);
    $add_o_desc_allproducts_data['roof_type']=$prod->xss_fix($_POST['rs_id'] ?? '');
    $add_o_desc_allproducts_data['roof_tilt']=$prod->xss_fix($_POST['r_tilt'] ?? '');
    $add_o_desc_allproducts_data['knee_wall']=$prod->xss_fix($_POST['r_kneewall'] ?? '');
    $add_o_desc_allproducts_data['rop_id']=$prod->xss_fix($_POST['rop_id'] ?? '');
    $add_o_desc_allproducts_data['roof_material']=$prod->xss_fix($_POST['roof_color'] ?? '');
    $facade_color_1=$prod->xss_fix($_POST['facade_color_1'] ?? '');
    $facade_color_2=$prod->xss_fix($_POST['facade_color_2'] ?? '');
    $add_o_desc_allproducts_data['wlc_id']=$facade_color_1.";".$facade_color_2.";";
    $add_o_desc_allproducts_data['ww_id']=$prod->xss_fix($_POST['ww_id'] ?? '');
    $add_o_desc_allproducts_data['wc_id']=$prod->xss_fix($_POST['wc_id'] ?? '');
    $add_o_desc_allproducts_data['door_texture']=$prod->xss_fix($_POST['door_texture'] ?? '');
    $add_o_desc_allproducts_data['dsp_id']=$prod->xss_fix($_POST['door_shape_sides'] ?? '');
    $add_o_desc_allproducts_data['door_color']=$prod->xss_fix($_POST['door_color'] ?? '');
    $add_o_desc_allproducts_data['gc_id']=$prod->xss_fix($_POST['gc_id'] ?? '');
    $add_o_desc_allproducts_data['pbp_id']=$prod->xss_fix($_POST['environment'] ?? '');
    
    $garage_size=$prod->xss_fix($_POST['garage_size'] ?? '');
    
    $garage_array=explode(' ',$garage_size);

        $add_o_desc_allproducts_data['gc_length']=(float) $garage_array[0];
        $add_o_desc_allproducts_data['gc_width']=(float) $garage_array[1];
    // if(!empty($garage_size))
    // {
        // if($garage_size=="3x6")
        // {
        //     $add_o_desc_allproducts_data['gc_length']=3;
        //     $add_o_desc_allproducts_data['gc_width']=6;
        // }
        // if($garage_size=="6x6")
        // {
        //     $add_o_desc_allproducts_data['gc_length']=6;
        //     $add_o_desc_allproducts_data['gc_width']=6;
        // }
        // if($garage_size=="6x9")
        // {
        //     $add_o_desc_allproducts_data['gc_length']=6;
        //     $add_o_desc_allproducts_data['gc_width']=9;
        // }
        $add_o_desc_allproducts_data['gc_height']=2.5;
    //}
    $prod->add_o_desc_allproducts(json_encode($add_o_desc_allproducts_data));
}
$collection=explode(';',$update_data['collection']); 

//$prod->delete_products_by_o_id($o_id); // <== resetting coordination products

if(!empty($update_in_b1_data['col_amount_in_b1']))
{
	for($i=1;$i<=$update_in_b1_data['col_amount_in_b1'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if(((substr($collection[$j],1)>1100)&&(substr($collection[$j],1)<1160))||(substr($collection[$j], -3) == '10v'))		
			{
				$b1_in_prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$b1_in_prod_data['osub_id']="n0".$i;
				}
				else
				{
					$b1_in_prod_data['osub_id']="n".$i;
				}
				$b1_in_prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($b1_in_prod_data));
				
				if(empty($o_prod))
				{
					$add_b1_in_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b1_in_o_prods['osub_id']="n0".$i;
					}
					else
					{
						$add_b1_in_o_prods['osub_id']="n".$i;
					}
					$add_b1_in_o_prods['prod_id']=$collection[$j];
					$add_b1_in_o_prods['om_id']=$order['om_id'];

					if(substr($collection[$j],1)==1104)
					{
						$add_b1_in_o_prods['p_status']=3;						
						$prod->add_order_products2(json_encode($add_b1_in_o_prods));
					}
					else
					{
						$add_b1_in_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b1_in_o_prods));
					}
				}
			}
		}
	}
}

if(!empty($update_in_b3_data['col_amount_in_b3']))
{
	for($i=1;$i<=$update_in_b3_data['col_amount_in_b3'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1300)&&(substr($collection[$j],1)<1360))		
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
				
				if(empty($o_prod))
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

if(!empty($update_in_b5_data['col_amount_in_b5']))
{
	for($i=1;$i<=$update_in_b5_data['col_amount_in_b5'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1500)&&(substr($collection[$j],1)<1560)||($collection[$j]=="p150z")||($collection[$j]=="p150y")||($collection[$j]=="p152z")||($collection[$j]=="p152y")||($collection[$j]=="p154z")||($collection[$j]=="p154y"))		
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
				
				if(empty($o_prod))
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

if(!empty($update_in_b6_data['col_amount_in_b6']))
{
	for($i=1;$i<=$update_in_b6_data['col_amount_in_b6'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
           
			if((substr($collection[$j],1)>1600)&&(substr($collection[$j],1)<1660)||($collection[$j]=="p162z")||($collection[$j]=="p162y"))		
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
				
				if(empty($o_prod))
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

					if(substr($collection[$j],1)==1601)
					{
						$add_b6_in_o_prods['p_status']=3;
						$prod->add_order_products2(json_encode($add_b6_in_o_prods));
						$add_b6_in_o_prods['prod_id']="p1600";
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

if(!empty($update_in_b7_data['col_amount_in_b7']))
{
	for($i=1;$i<=$update_in_b7_data['col_amount_in_b7'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1700)&&(substr($collection[$j],1)<1760)||($collection[$j]=="p170z")||($collection[$j]=="p170y")||($collection[$j]=="p172z")||($collection[$j]=="p172y")||($collection[$j]=="p174z")||($collection[$j]=="p174y"))		
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
				
				if(empty($o_prod))
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

if(!empty($update_in_b8_data['col_amount_in_b8']))
{
	for($i=1;$i<=$update_in_b8_data['col_amount_in_b8'];$i++)
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
				
				if(empty($o_prod))
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

if(!empty($update_ex_b1_data['col_amount_ex_b1']))
{
	for($i=1;$i<=$update_ex_b1_data['col_amount_ex_b1'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1160)&&(substr($collection[$j],1)<1300)||
            ($collection[$j]=="p116b")||($collection[$j]=="p116m")||($collection[$j]=="p116t")||
            ($collection[$j]=="p118s")||(substr($collection[$j], -3) == '16v'))
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
				
				if(empty($o_prod))
				{
                   
					$add_b1_ex_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b1_ex_o_prods['osub_id']="x0".$i;
					}	
					else
					{
						$add_b1_ex_o_prods['osub_id']="x".$i;
					}
					$add_b1_ex_o_prods['prod_id']=$collection[$j];
					$add_b1_ex_o_prods['om_id']=$order['om_id'];
					
                    $add_b1_ex_o_prods['p_status']=1;
                    $prod->add_order_products2(json_encode($add_b1_ex_o_prods));
					
				}
			}
		}
	}
}

if(!empty($update_g_b1_data['col_amount_g_b1']))
{
	for($i=1;$i<=$update_g_b1_data['col_amount_g_b1'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if(
            ($collection[$j]=="p11gb")||($collection[$j]=="p11gm")||($collection[$j]=="p11gt")||
            ($collection[$j]=="p11gs"))
			{			
				$prod_data['o_id']=$update_data['o_id'];
				if($i<10)
				{
					$prod_data['osub_id']="g0".$i;
				}
				else
				{
					$prod_data['osub_id']="g".$i;
				}
				
				$prod_data['prod_id']=$collection[$j];
				
				$o_prod=$prod->get_order_product(json_encode($prod_data));
				
				if(empty($o_prod))
				{
                   
					$add_b1_g_o_prods['o_id']=$update_data['o_id'];
					if($i<10)
					{
						$add_b1_g_o_prods['osub_id']="g0".$i;
					}	
					else
					{
						$add_b1_g_o_prods['osub_id']="g".$i;
					}
					$add_b1_g_o_prods['prod_id']=$collection[$j];
					$add_b1_g_o_prods['om_id']=$order['om_id'];
					
                    $add_b1_g_o_prods['p_status']=1;
                    $prod->add_order_products2(json_encode($add_b1_g_o_prods));
					
				}
			}
		}
	}
}

if(!empty($update_ex_b5_data['col_amount_ex_b5']))
{
	for($i=1;$i<=$update_ex_b5_data['col_amount_ex_b5'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1560)&&(substr($collection[$j],1)<1600)||($collection[$j]=="p156x")||($collection[$j]=="p156z")||($collection[$j]=="p156y"))
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
				
				if(empty($o_prod))
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

if(!empty($update_ex_b6_data['col_amount_ex_b6']))
{
	for($i=1;$i<=$update_ex_b6_data['col_amount_ex_b6'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{ 
            
			if((substr($collection[$j],1)>1660)&&(substr($collection[$j],1)<1700)||($collection[$j]=="p166x")||($collection[$j]=="p166z")||($collection[$j]=="p166y")||($collection[$j]=="p168s")||($collection[$j]=="p166p"))
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
                
				if(empty($o_prod))
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
						// $add_b6_ex_o_prods['prod_id']="p1660";
						// $prod->add_order_products2(json_encode($add_b6_ex_o_prods));
					}
					else
					{
                        $add_b6_ex_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b6_ex_o_prods));
					}
                }
            }
		}
	}
}

if(!empty($update_ex_b7_data['col_amount_ex_b7']))
{
	for($i=1;$i<=$update_ex_b7_data['col_amount_ex_b7'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1760)&&(substr($collection[$j],1)<1800)||($collection[$j]=="p176x")||($collection[$j]=="p176z")||($collection[$j]=="p176y"))
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
                
				if(empty($o_prod))
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
                        $add_b7_ex_o_prods['p_status']=1;
						$prod->add_order_products2(json_encode($add_b7_ex_o_prods));
					}
				}
			}
		}
	}
}
    
if(!empty($update_ex_b8_data['col_amount_ex_b8']))
{
	for($i=1;$i<=$update_ex_b8_data['col_amount_ex_b8'];$i++)
	{
		for($j=0;$j<count($collection);$j++)
		{
			if((substr($collection[$j],1)>1860)&&(substr($collection[$j],1)<1900)||($collection[$j]=="p186x")||($collection[$j]=="p186z")||($collection[$j]=="p186y"))
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
                
				if(empty($o_prod))
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
                        $add_b8_ex_o_prods['p_status']=1;
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
		<meta http-equiv="refresh" content="1; url=confirmation1.php?o_id=<?php echo $update_data['o_id']; ?>">
		<?php
		}
		else
		{
			?>						
			<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9">
			<?php
		}	
	}
	else
	{
		?>						
		<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9">
		<?php
	}					
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
				
				
				
				
				/* if(isset($_POST['delete_btn']))
				{
					$of_id=$_POST['of_id'];
					
					$prod->delete_customer_file($of_id);
					?>
					<div class="alert alert-success text-center">File deleted !</div><br>
					<?php
				} */
				
				if(isset($_POST['rename_btn']))
				{
					$of_id=$_POST['of_id'];
					$of_name=$_POST['of_name'];
					
					$prod->rename_client_file($of_id,$of_name);

				}
				
				if($option=="change_note")
				{
					$of_id=$_GET['of_id'];
					$of_kind=$_GET['of_kind'] ?? 0;
					
					$prod->change_of_kind($of_id,$of_kind);
				}
				
				if($option=="change_position")
				{
					$of_id=$_GET['of_id'];
					$of_position=$_GET['of_position'];
					
					$prod->change_of_position($of_id,$of_position);
				}
				
				if($option=="change_level")
				{
					$of_id=$_GET['of_id'];
					$of_level=$_GET['of_level'];
					
					$prod->change_of_level($of_id,$of_level);
                }
				if(isset($_GET['option']))
				{
					$option=$prod->xss_fix($_GET['option']);
				}
				else
				{
					$option="";
				}
				
			
$o_id=$prod->xss_fix($_GET['o_id']);

//acceptance variables

$order=$prod->get_order($o_id);

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
			
<input type="hidden" id="o_id" name="o_id" value="<?php echo $o_id; ?>" form="order_details">
<input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid; ?>" form="order_details">
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_COOKIE['client_id']; ?>" form="order_details">
<input type="hidden" name="licenceid" value="<?php echo $licid; ?>" form="order_details">
<input type="hidden" name="cur_id" value="<?php echo $order['cur_id']; ?>" form="order_details">
<input type="hidden" name="client_language_id" value="<?php echo $order['client_language_id']; ?>" form="order_details">
			<div class="row border-top border-bottom mx-0 w-100">
				<div class="col-md-6 text-left pl-4 border-right pt-3" style="background-color:#c4c4c4;">
				<p class="w-100 mb-2"><b>Website = </b> <?php 
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
                }?></p>
							
				<p class="mb-2">
                <b>Order ID:</b> <a href="<?php echo $_SERVER['PHP_SELF']?>?o_id=<?php echo $o_id; 
				if(isset($_GET['status']))
				{
					echo "&status=".$prod->xss_fix($_GET['status']);
				}?>"><?php echo $o_id; ?></a>  <?php 
				if($order['om_id']==0)
				{
					if(isset($_GET['status']))
					{
					?>	
					<a href="o_extension.php?o_extension=<?php echo $o_id;
						
					?>" class="btn btn-primary btn-sm ml-2">Add order extension</a>	
					
					<a href="o_correction.php?o_correction=<?php echo $o_id;
						
					?>" class="btn btn-primary btn-sm">Add order correction/amendment</a>
					<?php
					}
				}
				else
				{
				?>
					<b>Extension to:</b> <?php echo $order['o_extension'];
				
				}
	
				$licence_taker=$prod->get_licence_taker($o_id);				
				?>
                </p>
                <input id="utc_date_time" type="hidden" value="<?php echo $order['o_date'];?>">
                <b>Date:</b> <span id=""><?php 
                
                $date_array=explode(' ',$order['o_date']);
                echo $date_array[0].", ".$date_array[1];
                ?></span> UTC + 0 = <b>yours:</b> <span id="local_date_time">loading...</span><br>
                <script type="text/javascript">
                    $(document).ready(function(){
                        
                        let o_date=$('#utc_date_time').val();
                        let timezone=Intl.DateTimeFormat().resolvedOptions().timeZone;

                        $.ajax({
                            url: "../ajax/convert_utc_to_local_date_time.php",
                            method: "get",
                            data: {o_date:o_date,timezone:timezone},
                            dataType:"html",
                            success:function(data) {
                                $('#local_date_time').html(data);	
                            }
                        });

                    });
                </script>
                <div class="row">
                    <div class="col-md-12 d-flex">
                Trader = Licence ID: <input type="text" id="lic_id" name="lic_id" value="<?php echo $order['lic_ID']; ?>" class="form-control form-control-sm" style="width:5em;">&nbsp; 
                <button id="change_lic_id_btn" class="btn btn-sm btn-primary">Change Licence ID</button>
                    </div>
                </div>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#change_lic_id_btn').click(function(){

                        if(confirm("Are you sure you want to change the Licence ID ?\nAlso the page will refresh, any other changes will not be saved !"))
                        {
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/change_order_licence_id.php",
                                method: "post",
                                data: {o_id:$('#o_id').val(),lic_id:$('#lic_id').val()},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);	
                                }
                            });

                            setTimeout(function(){window.location="orderdetails.php?o_id="+$('#o_id').val()+"&status=accepted"},2000);
                        }

                    });
                });
                </script>
                - <?php echo $licence_taker['Company']." - ".$licence_taker['contact-persons-for-us']." - ".$licence_taker['phone']; ?>
				
				<div class="p-2 mt-2" style="background-color:#bad4ff">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                        Purchaser = Client ID: <input type="text" class="form-control form-control-sm" name="purchaser_client_id" id="purchaser_client_id" value="<?php echo $client['client_ID']; ?>" style="width:5em;"> 
                        &nbsp;<button id="change_purchaser_client_id_btn" class="btn btn-sm btn-primary">Change client_ID</button>
                        </div>
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
                        -  Enterprise: <?php echo $client['clientname']; ?>, Sub: <a href="<?php echo $base_url;?>client_administration/modify.php?clientid=<?php echo $client['client_ID']; ?>" target="_blank"><?php 
                        if(!empty($client['c_last_name']))
                        {
                            echo $client['c_title']." ".$client['c_first_name']." ".$client['c_last_name'];
                        }
                        else
                        {
                            echo $client['l_title']." ".$client['l_first_name']." ".$client['l_last_name'];
                        } ?></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex">
                        - Client credibility:
                        <select name="client_credibility" id="client_credibility" class="form-control form-control-sm ml-2" form="order_details" style="width:50px;" disabled>
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
                        &nbsp; - <?php echo (!empty($client['phone']))?$client['phone']:"No phone number saved !"; ?>    
                        </div>
                    </div>
				</div>
				
				<script type="text/javascript">
				$(document).ready(function(){
					 $('#purchaser').on('input',function() {
					var opt = $('option[value="'+$(this).val()+'"]');					
					var clientid=opt.attr('id');				
					$('input[name="clientid"]').val(clientid);			
				  });
				});
				</script>
				<br>			
				<div class="form-group">
					<p class="d-inline"><b>Project name: </b></p>
                    <input type="text" class="form-control form-control-sm d-inline" name="order_name" value="<?php echo str_replace("\"","",$order['order_name']); ?>" style="width:250px;" form="order_details" required>
				
                        
                </div>
                <div class="form-group">
                    <p class="d-inline"><b>Real address for the environment: </b></p>
                    <textarea id="environment_address2" name="environment_address2" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                    <script type="text/javascript">
                        

                        tinymce.init({

                            selector:'textarea#environment_address2',

                            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',



                            imagetools_cors_hosts: ['picsum.photos'],



                            menubar: 'file edit view insert format tools table help',



                            toolbar: 'undo redo | bold italic underline strikethrough |   fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',



                            toolbar_sticky: false,



                            autosave_ask_before_unload: false,



                            autosave_interval: "30s",



                            autosave_prefix: "{path}{query}-{id}-",



                            autosave_restore_when_empty: false,



                            autosave_retention: "2m",



                            image_advtab: true,



                            content_css: '//www.tiny.cloud/css/codepen.min.css',

                            // apply_source_formatting : false,                
                            // verify_html : false,

                            link_list: [



                                { title: 'My page 1', value: 'http://www.tinymce.com' },



                                { title: 'My page 2', value: 'http://www.moxiecode.com' }



                            ],



                            image_list: [



                                { title: 'My page 1', value: 'http://www.tinymce.com' },



                                { title: 'My page 2', value: 'http://www.moxiecode.com' }



                            ],



                            image_class_list: [



                                { title: 'None', value: '' },



                                { title: 'Some class', value: 'class-name' }



                            ],



                            importcss_append: true,



                            height: 300,



                            file_picker_callback: function (callback, value, meta) {



                                /* Provide file and text for the link dialog */



                                if (meta.filetype === 'file') {



                                    callback('https://www.google.com/logos/google.jpg', { text: 'My text' });



                                }







                                /* Provide image and alt text for the image dialog */



                                if (meta.filetype === 'image') {



                                    callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });



                                }







                                /* Provide alternative source and posted for the media dialog */



                                if (meta.filetype === 'media') {



                                    callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });



                                }



                            },



                            templates: [



                                { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },



                                { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },



                                { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }



                            ],



                            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',



                            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',



                            //height: 600,



                            image_caption: true,



                            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',



                            noneditable_noneditable_class: "mceNonEditable",



                            toolbar_mode: 'sliding',



                            contextmenu: "link image imagetools table"

                            });

                            $(document).ready(function() {
                                tinymce.get('environment_address2').on('change focusout',function(){
                                //$("textarea[name=environment_address]").val($('#environment_address2').val());

                                let message = tinymce.get('environment_address2').getContent();

                                $("textarea[name=environment_address]").val(message);

                                });
                            });
                    </script>
                </div>			
				<div class="form-group">
                    <p class="d-inline"><b>Latitude: </b></p>
                    <input type="text" class="form-control form-control-sm d-inline" name="latitude" value="<?php echo $order['latitude']; ?>" style="width:150px;" form="order_details">
                    <p class="d-inline"><b>Longitude: </b></p>
                    <input type="text" class="form-control form-control-sm d-inline" name="longitude" value="<?php echo $order['longitude']; ?>" style="width:150px;" form="order_details">                    
                </div>
                
                <?php
                if(($order['longitude']!=0)&&($order['latitude']!=0))
                {
                ?>
                <div class="form-group">
                    <?php /*<p class="d-inline"><a href="https://app.shadowmap.org/?lat=<?php echo $order['latitude']; ?>&lng=<?php echo $order['longitude']; ?>=&zoom=15&basemap=map&time=1662559750832&vq=2" target="_blank">Autogenerated suntour</a></p>
                    |*/?> <p class="d-inline"><a href="https://www.google.ro/maps/place/Germany/@<?php echo $order['latitude']; ?>,<?php echo $order['longitude']; ?>,17z" target="_blank">Autogenerated Google Maps</a></p>
                </div>
                <?php
                }
                ?>
                <div class="form-group">
                    <p class="d-inline"><b>Used for map: </b></p>                    
                    <select class="form-control form-control-sm d-inline" name="show_on_map" form="order_details" style="width:150px;">
                        <option value="0" <?php echo ($order['show_on_map']==0)?"selected":""?>>No</option>
                        <option value="1" <?php echo ($order['show_on_map']==1)?"selected":""?>>Yes</option>
                    </select>                    
                </div>
                <div class="form-group">
                    <p class="d-inline">Earth link ?</p>
                    <input type="text" class="form-control form-control-sm d-inline" name="earth_link" value="<?php echo $order['earth_link']; ?>" placeholder="Add google earth link for this order" style="width:400px;" form="order_details">
                </div>
                <div class="form-group">
                    <p class="d-inline"><a href="https://www.geoportal.de/Anwendungen/Geoportale%20der%20L%C3%A4nder.html" target="_blank">Geoportal</a></p>
                    <input type="text" class="form-control form-control-sm d-inline" name="geoportal_link" value="<?php echo $order['geoportal_link']; ?>" placeholder="Add geoportal link for this order" style="width:400px;" form="order_details">
                </div>
                <?php /*
                <div class="form-group">
                    <p class="d-inline">Google Earth link</p>
                    <input type="text" class="form-control form-control-sm d-inline" name="google_earth_link" value="<?php echo $order['google_earth_link']; ?>" placeholder="Add Google Earth link" style="width:400px;" form="order_details">
                </div>*/ ?>
                <div class="form-group">
                    <p class="d-inline">Street View Link</p>
                    <input type="text" class="form-control form-control-sm d-inline" name="street_view_link" value="<?php echo $order['street_view_link']; ?>" placeholder="Add Street View link" style="width:400px;" form="order_details">
                </div>
                <div class="form-group">
                    <p class="d-inline">VR Link</p>
                    <input type="text" class="form-control form-control-sm d-inline" name="vr_link" value="<?php echo $order['vr_link']; ?>" placeholder="Add VR link for this order" style="width:400px;" form="order_details">
                </div>
                <?php
                // if($order['o_deadline']!="0000-00-00 00:00:00")
                // {
                ?>
                <div class="form-group">
					<p class="d-inline"><b>Deadline UTC+0: </b></p>
                    <input type="text" class="form-control form-control-sm text-danger d-inline" id="o_deadline" name="o_deadline" value="<?php 
                    if($order['o_deadline']!="0000-00-00 00:00:00")
                    {
                        echo $order['o_deadline'];
                    }?>" style="width:250px;" form="order_details" autocomplete="off">
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('#o_deadline').datetimepicker({
                            format:'Y-m-d H:i'
                        });
                    });
                    </script>
                </div>

                <div class="form-group form-inline">
					<p class="mb-0"><b>Add to specific plot: </b></p>
                    <input type="text" class="form-control form-control-sm" id="existing_plot_id" name="existing_plot_id" value="<?php echo $order['plot_id'];?>"
                    data-toggle="modal" data-target="#editPlotModal<?= $o_id; ?>">
                    <div class="modal fade" id="editPlotModal<?= $o_id; ?>" tabindex="-1" aria-labelledby="editPlotModalLabel<?= $o_id; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPlotModalLabel<?= $o_id; ?>">Choose plots for Order ID <?= $o_id; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form name="update_plots_form" id="update_plots_form" method="post">
                                        <input type="hidden" name="o_id" value="<?php echo $o_id;?>">
                                        <?php
                                        $all_plots=$prod->get_all_plots_reverse_order_by_id();
                                        $existing_plot_ids=explode("|",$order['plot_id']);
                                        
                                        for($p=0;$p<count($all_plots);$p++)
                                        {
                                        ?>
                                        <div class="form-group">
                                            <input type="checkbox" class="form-control plot_ids" id="plot_id<?php 
                                            echo $all_plots[$p]['plot_id'];?>" name="plot_id[]" value="<?php 
                                            echo $all_plots[$p]['plot_id']."|";?>" <?php 
                                            if(in_array($all_plots[$p]['plot_id'],$existing_plot_ids))
                                            {
                                                echo "checked";
                                            }
                                            ?>>&nbsp;
                                            <label for="update_plot_id">ID <?php echo $all_plots[$p]['plot_id'];?></label>
                                            &nbsp;<span><?php echo $all_plots[$p]['city'];?>, <?php echo $all_plots[$p]['postcode'];?>, <?php 
                                            echo $all_plots[$p]['street'];?>, <?php echo $all_plots[$p]['house_no'];?></span>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="save_plots_btn<?php echo $o_id;?>" class="btn btn-primary">Save changes</button>
                                    <script type="text/javascript">
                                        $('#save_plots_btn<?php echo $o_id;?>').click(function(){
                                            
                                            formData= new FormData($('#update_plots_form')[0]);

                                            $.ajax({
                                                url: "<?php echo $base_url;?>ajax/update_order_plot_id.php",
                                                type: 'POST',
                                                data: formData,
                                                cache: false,
                                                dataType: 'text',
                                                processData: false, 
                                                contentType: false,
                                                enctype: 'multipart/form-data',
                                                dataType:"html",
                                                success:function(data) {
                                                    $('#existing_plot_id').val(data);
                                                    $('#editPlotModal<?= $o_id; ?>').modal('hide');	
                                                }
                                            });

                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $('#existing_plot_id').focusin(function(){
                            $(this).attr("readonly","readonly");
                        });

                        $('#existing_plot_id').focusout(function(){
                            $(this).removeAttr("readonly");
                        });

                    </script>
                    <?php /*<select class="form-control form-control-sm" name="plot_id" form="order_details">
                        <option value="0">No</option>
                        <?php
                        $plots=$sp7->get_all_plots_by_owner_id($client['client_ID']);

                        for($p=0;$p<count($plots);$p++)
                        {
                            ?>
                            <option value="<?php echo $plots[$p]['plot_id'];?>" <?php echo ($plots[$p]['plot_id']==$order['plot_id'])?"selected":"";?>><?php echo $plots[$p]['size']." m&sup2;</sup> - ".$plots[$p]['city']." - ".$plots[$p]['street'].", ".$plots[$p]['house_no'];?></option>
                            <?php
                        }
                        ?>
                    </select> */ ?>
                </div>
                <?php
                $existing_plot_ids=explode("|",$order['plot_id']);
                
                if((!empty($existing_plot_ids))&&(!empty($order['plot_id'])))
                {
                ?>
                <div class="form-group form-inline">
                    <div class="row">
                        <div class="col-md-12">
                            <b>Linked order_ids:</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                            <?php
                            $plot_orders=$prod->get_all_orders_by_plot_id($existing_plot_ids[1]); //here it checks only 1 plot,sometimes there are more plots

                            for($p=0;$p<count($plot_orders);$p++)
                            {
                            ?>
                            <a href="https://blue7.it/studio/acceptance/orderdetails.php?o_id=<?php 
                            echo $plot_orders[$p]['order_ID'];?>&status=accepted" class="btn btn-sm btn-primary" target="_blank">Order <?php 
                            echo $plot_orders[$p]['order_ID'];?></a>
                            <?php
                            }
                            ?>
                            </p>
                            
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="form-group form-inline">
                    <p class="mb-0"><b>House_id: </b></p>
                    <select class="form-control form-control-sm" id="house_id" name="house_id" form="order_details" style="width:300px;">
                        <option value="0">No</option>
                        <?php
                        /* $houses=$sp7->get_all_house_types_by_building_company($client['client_ID']);

                        for($p=0;$p<count($houses);$p++)
                        {
                            ?>
                            <option value="<?php echo $houses[$p]['house_id'];?>" <?php echo ($houses[$p]['house_id']==$order['house_id'])?"selected":"";?>><?php echo $houses[$p]['house_name'];?></option>
                            <?php
                        } */
                        
                        if($client['mc_id']!=0) //showing only main client houses
                        {
                            $builder=$prod->get_builder_from_mc_id($client['mc_id']);

                            $main_client_houses=$prod->get_house_types_by_builders_id($builder['builders_id']);

                            for($h=0;$h<count($main_client_houses);$h++)
                            {
                                ?>
                                <option value="<?php echo $main_client_houses[$h]['house_id'];?>" <?php echo ($main_client_houses[$h]['house_id']==$order['house_id'])?"selected":"";?>><?php echo $main_client_houses[$h]['house_id']." - ".$main_client_houses[$h]['house_name'];?></option>
                                <?php
                            }
                        } 
                        ?>
                    </select>
                    <div id="presentation_link">
                        
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            get_presentation_link_from_house_id();
                        });

                        $('#house_id').on('change',function(){
                            get_presentation_link_from_house_id();
                        });

                        function get_presentation_link_from_house_id()
                        {
                            let house_id=$('#house_id').val();
                            console.log(house_id);

                            if(house_id!=0)
                            {
                            $.ajax({
                                url: "../ajax/get_presentation_link_from_house_id.php",
                                method: "get",
                                data: {house_id:house_id},
                                dataType:"html",
                                success:function(data) {
                                    
                                    $('#presentation_link').html(data);
                                }
                            });
                            }
                            else
                            {
                                $('#presentation_link').html("");
                            }
                        }
                    </script>
                </div>    
                <div class="form-group">
					<p class="d-inline"><b>Homepage URL (<span class="text-danger">for subdomains</span>): </b></p>
                    <input type="text" class="form-control form-control-sm d-inline" id="homepage_url" name="homepage_url" data-o_id="<?php echo $o_id;?>" value="<?php echo $order['homepage_url'];?>" style="width:250px;" form="order_details" placeholder="subdomain.domain.com without http:// in front" autocomplete="off">
                    <!--<button type="button" name="generate_homepage_btn" id="generate_homepage_btn" data-o_id="<?php echo $o_id;?>" class="btn btn-sm btn-primary">Generate</button> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="homepage_message">
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                    $('#homepage_url').on('change',function(){
                        
                        let o_id=$(this).data('o_id');
                        let homepage_url=$(this).val();                        

                        $.ajax({
                            url: "../ajax/update_order_homepage_url.php",
                            method: "post",
                            data: {o_id:o_id,homepage_url:homepage_url},
                            dataType:"html",
                            success:function(data) {
                                console.log(data);	
                            }
                        });
                        
                    });

                    $('#generate_homepage_btn').click(function(){
                        if(confirm('Are you sure the homepage url is correct ?'))
                        {
                            let o_id=$(this).data('o_id');
                            let homepage_url=$('#homepage_url').val(); 

                            if(homepage_url!="")
                            {
                            $.ajax({
                            url: "../ajax/generate_homepage.php",
                            method: "post",
                            data: {o_id:o_id,homepage_url:homepage_url},
                            dataType:"html",
                            success:function(data) {
                                console.log(data);	
                            }
                            }).done(function(result){
                                $('#homepage_message').html(result);
                            })
                            }
                            else
                            {
                                alert('Warning ! Homepage URL is empty ! Nothing generated !');
                            }
                        }
                    })
                    </script>
                </div>
                <div class="form-group">
					<p class="d-inline"><b>Mainpage URL (<span class="text-danger">for domains</span>): </b></p>
                    <input type="text" class="form-control form-control-sm d-inline" id="domain_homepage_url" name="domain_homepage_url" data-o_id="<?php echo $o_id;?>" value="<?php echo $order['domain_homepage_url'];?>" style="width:250px;" form="order_details" placeholder="domain.com without http:// in front" autocomplete="off">
                    <!--<button type="button" name="generate_domain_homepage_btn" id="generate_domain_homepage_btn" data-o_id="<?php echo $o_id;?>" class="btn btn-sm btn-primary">Generate</button>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="domain_homepage_message">
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                    $('#domain_homepage_url').on('change',function(){
                        
                        let o_id=$(this).data('o_id');
                        let domain_homepage_url=$(this).val();                        

                        $.ajax({
                            url: "../ajax/update_order_domain_homepage_url.php",
                            method: "post",
                            data: {o_id:o_id,domain_homepage_url:domain_homepage_url},
                            dataType:"html",
                            success:function(data) {
                                console.log(data);	
                            }
                        });
                        
                    });

                    $('#generate_domain_homepage_btn').click(function(){
                        if(confirm('Are you sure the mainpage url is correct ?'))
                        {
                            let o_id=$(this).data('o_id');
                            let domain_homepage_url=$('#domain_homepage_url').val(); 

                            if(domain_homepage_url!="")
                            {
                            $.ajax({
                            url: "../ajax/generate_domain_homepage.php",
                            method: "post",
                            data: {o_id:o_id,domain_homepage_url:domain_homepage_url},
                            dataType:"html",
                            success:function(data) {
                                console.log(data);	
                            }
                            }).done(function(result){
                                $('#domain_homepage_message').html(result);
                            })
                            }
                            else
                            {
                                alert('Warning ! Homepage URL is empty ! Nothing generated !');
                            }
                        }
                    })
                    </script>
                </div>
                <?php
                $main_client=$prod->get_main_client($order['mc_id']);
                $commissions=$prod->get_all_commissions();
             

                if($main_client['commission']!="com_000")
                {
                ?>
                <div class="form-group form-inline">
                <p class="mb-0"><b>Commission </b></p>
                    
                    <select id="commission" name="commission" class="form-control form-control-sm" form="order_details">
                        <?php
                        for($c=0;$c<count($commissions);$c++)
                        {
                            if(($main_client['commission']=="?")||($order['mc_id']==0))
                            {
                                if($commissions[$c]['com_currency']==0)
                                {
                                    ?>
                                    <option value="<?php echo $commissions[$c]['com_id'];?>" <?php echo ($order['commission']==$commissions[$c]['com_id'])?"selected":"";?>><?php 
                                    if($commissions[$c]['com_id']=="com_000")
                                    {
                                        echo "No commission";
                                    }
                                    else
                                    {
                                        echo $commissions[$c]['com_percent']. " % + ".$commissions[$c]['com_fix'];
                                    }?></option>
                                    <?php
                                }

                                if($order['cur_id']==$commissions[$c]['com_currency'])
                                {
                                    ?>
                                    <option value="<?php echo $commissions[$c]['com_id'];?>" <?php echo ($order['commission']==$commissions[$c]['com_id'])?"selected":"";?>><?php 
                                    if($commissions[$c]['com_id']=="com_000")
                                    {
                                        echo "No commission";
                                    }
                                    else 
                                    //if($commissions[$c]['com_id']!="com_000")
                                    {
                                        echo $commissions[$c]['com_percent']. " % + ".$commissions[$c]['com_fix'];
                                    }?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                if($main_client['commission']==$commissions[$c]['com_id'])
                                {
                                    // if($order['cur_id']==$commissions[$c]['com_currency'])
                                    // {
                                        ?>
                                        <option value="<?php echo $commissions[$c]['com_id'];?>" <?php echo ($order['commission']==$commissions[$c]['com_id'])?"selected":"";?>><?php 
                                        if($commissions[$c]['com_id']=="com_000")
                                        {
                                            echo "No commission";
                                        }
                                        else
                                        {
                                            echo $commissions[$c]['com_percent']. " % + ".$commissions[$c]['com_fix'];
                                        }?></option>
                                        <?php
                                    // }
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
				<?php
                }
                ?>
                <div class="form-group">
                    <a href="<?php echo $base_url;?>entities_interior/index.php?o_id=<?php echo $o_id;?>" class="btn btn-sm btn-primary" target="_blank">Add/Remove Entities</a>
                    <button class="btn btn-sm btn-primary" name="temp_save_btn" form="order_details" title="<?php if((isset($_GET['status']))&&($_GET['status']=="accepted")){ echo "Button disabled. Order is accepted.";} ?>" <?php if((isset($_GET['status']))&&($_GET['status']=="accepted")){ echo "disabled";}?>>Save</button>
                </div>
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
					<b>Communications</b>
					<?php
                   /* $allmessages=$prod->get_all_trader_purchaser_messages($o_id);

                    for($i=0;$i<count($allmessages);$i++)
                    {
                        if($allmessages[$i]['client_id']>0)
                        {
                            $client=$prod->get_client($allmessages[$i]['client_id']);
                        }
                        elseif($allmessages[$i]['uca_id']>0)
                        {
                            $creator=$prod->get_creator_name($allmessages[$i]['uca_id']);
                        }
                    ?>
                    <div class="row colorline">
                        <div class="col-md-12">
                        <?php
                        if($allmessages[$i]['client_id']>0)
                        {
                            echo "<b>".$client['l_first_name']." ".$client['l_last_name']."</b>";
                        }
                        elseif($allmessages[$i]['uca_id']>0)
                        {
                            echo "<b>".$creator['uca_name']."</b>";
                        }

                        echo " (<b>".$allmessages[$i]['msg_date']." UTC +0</b>): ".$allmessages[$i]['message'];
                        ?>
                        </div>
                    </div>
                    <?php
                    } */
                    ?>
					<br>
					<?php 
					if(!isset($_GET['status']))
					{
                        //$_GET['status']="not_accepted";

                        // if($_GET['status']!="accepted")
                        // {
                            ?>
                            <?php /*<div class=" d-inline">
                                <form id="update_notifications_form" class="d-inline" name="update_notifications_form" action="orderdetails.php?<?php 					
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
                                    <button class="btn btn-sm mb-1 <?php echo ($order['notifications']==1)?"btn-success":"btn-danger";?>" type="submit" name="notifications_btn" form="update_notifications_form">Notifications <?php echo ($order['notifications']==1)?"are ON":"are OFF";?></button>
                                </form>
                            </div>*/?>
                            <button name="accept_btn" id="accept_btn1" class="btn btn-primary btn-sm p-1 mx-2 border border-dark" form="order_details" disabled>Accept <i class="fas fa-clipboard-check ml-2"></i></button>
					        <?php
                        // }
					}
					?>

                    <button class="btn btn-sm <?php echo ($order['notifications'] == 1) ? "btn-success" : "btn-dark"; ?> px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
							id="notification_btn<?php echo $order['order_ID']; ?>" data-o_id="<?php echo $order['order_ID']; ?>" data-notifications="<?php echo $order['notifications'];?>">Notifications
						<span> <?php echo ($order['notifications'] == 1) ? "are ON" : "are OFF"; ?></span></button>
					<script type="text/javascript">
						$("#notification_btn<?php echo $order['order_ID']; ?>").click(function () {
							$.ajax({
								url: "../ajax/update_notification.php",
								method: "post",
								data: {
									o_id: $(this).data('o_id'),
									notifications: $(this).data('notifications')
								},
								dataType: "html",
								success: function (data) {
									//console.log(data);
									if (data == 0) {
										$("#notification_btn<?php echo $order['order_ID']; ?>").data("notifications","0");
										$("#notification_btn<?php echo $order['order_ID']; ?>").html("Notifications <span>are OFF</span>");
										$("#notification_btn<?php echo $order['order_ID']; ?>").removeClass("btn-success").addClass("btn-dark");
									} else {
										$("#notification_btn<?php echo $order['order_ID']; ?>").data("notifications","1");
										$("#notification_btn<?php echo $order['order_ID']; ?>").html("Notifications <span>are ON</span>");
										$("#notification_btn<?php echo $order['order_ID']; ?>").removeClass("btn-dark").addClass("btn-success");
									}
								},
								error: function (xhr, ajaxOptions, thrownError) {
									console.log(xhr.status);
									console.log(thrownError);
								}
							});
						});
					</script>

                    <a href="https://bauvorschau.com/<?php echo $o_id;?>" class="btn btn-warning btn-sm" target="_blank">Presentation</a>
					<a href="message_to_client.php?o_id=<?php echo $o_id; ?>" class="btn btn-warning btn-sm p-1 mx-2 border border-dark">Message to client <i class="fas fa-envelope ml-2"></i></a>
					<?php
					if((!isset($_GET['status']))/*&&($_GET['status']!="accepted")*/)
					{
					?>
					<a href="orderdetails.php?o_id=<?php echo $o_id; ?>&clientid=<?php echo $clientid; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm p-1 mx-2 border border-dark">Reject <i class="fas fa-user-times ml-2"></i></a>
					<?php
					}
					?>
                    <div class="row mx-0 w-100 border my-3" id="chat" style="min-height: 900px;">
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
				</div>
				
			</div>			
            <?php
            $collection=explode(';',$order['collection']);			
			if($order['payment_way']==9)
			{
				$currency="CRD";
			}
			else
			{
				$currency=$prod->get_currency($order['cur_id'])['cur_short'];
			}

            $o_desc_g_b1=$prod->get_o_desc_g_b1($o_id);
            ?>
			<div class="row m-0" style="background-color: #c4c4c4;">
                    <div class="row">
                        <div class="col-md-1">
                            <h5 class="text-success w-100 text-center">All</h5>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-sm btn-success text-white px-3 ml-1" data-target="#general_b1" data-toggle="collapse" aria-expanded="false">B1</button>
                        </div>
                    </div>
                    <div id="general_b1" class="row w-100 collapse" style="background-color: #d3d3d3;">
                        <div class="col-md-12 border-bottom border-dark">
                            <div class="row w-100 mx-0 border-top" >
                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <p class="d-inline mr-3 mb-0"><b>Amount of subIDs: </b></p>
                                        <input type="text" class="form-control form-control-sm" name="col_amount_general0" id="col_amount_general0" form="order_details" value="<?php 
                                            if(!empty($o_desc_g_b1['col_amount_g_b1']))
                                            {
                                                echo $o_desc_g_b1['col_amount_g_b1'];
                                            }
                                            else
                                            {
                                                echo "0";
                                            }
                                        ?>" style="width:5em">
                                    </div>
                                </div>					
                            </div>
                            <br>
                            
                            <div class="row w-100 mx-0">
                                <script type="text/javascript">
                                    $(document).ready(function(){

                                        $.ajax({
                                            url: "../ajax/create_orders_subnames_general_html.php",
                                            method: "post",
                                            data: {o_id:<?php echo $o_id;?>,total_general_amount:$('#col_amount_general0').val()},
                                            dataType:"html",
                                            success:function(data) {
                                                $('#general_osn_texts').html(data);										
                                            }
                                        });

                                    });

                                    $('#col_amount_general0').on('change focusout',function(){

                                        $.ajax({
                                            url: "../ajax/create_orders_subnames_general_html.php",
                                            method: "post",
                                            data: {o_id:<?php echo $o_id;?>,total_general_amount:$('#col_amount_general0').val()},
                                            dataType:"html",
                                            success:function(data) {
                                                $('#general_osn_texts').html(data);										
                                            }
                                        });

                                    });
                                </script>
                                <div class="col-md-12 justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12 d-inline" id="general_osn_texts">
                                            <?php
                                            $all_subids=$prod->get_all_subids_by_o_id($o_id);

                                            for($i=0;$i<count($all_subids);$i++)
                                            {
                                                if (strpos($all_subids[$i]['o_sub_id'], 'g') !== false) 
                                                {
                                                    ?>
                                                    <div id="row_subname<?php echo $all_subids[$i]['subo_id'];?>" class="row">                                        
                                                        <div class="col-md-2">
                                                            <?php
                                                            echo $all_subids[$i]['o_sub_id']."&nbsp;";
                                                            ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" list="general_subid_list<?php echo $all_subids[$i]['subo_id'];?>" id="subo_id<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" value="<?php echo $all_subids[$i]['subo_name'];?>" placeholder="Name" class="form-control form-control-sm">                                        
                                                            <script type="text/javascript">
                                                                $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                                                                    $.ajax({
                                                                        url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                                                        method: "get",
                                                                        data: {
                                                                            subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                                            all_subname:$(this).val(),
                                                                            option:"rename_all_osn_file"},
                                                                        dataType:"html",
                                                                        success:function(data) {
                                                                            console.log(data);										
                                                                        },
                                                                        error: function (xhr, ajaxOptions, thrownError) {
                                                                            console.log(xhr.status);
                                                                            console.log(thrownError);
                                                                        }
                                                                        
                                                                    }); 
                                                                });
                                                            </script>
                                                        </div>
                                                    
                                                        <div class="col-md-2">
                                                            <select id="object_type<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="form-control form-control-sm">
                                                                <option value="">--Object type--</option>
                                                                <?php
                                                                $all_object_types=$prod->get_all_object_types();
                                                                for($o=0;$o<count($all_object_types);$o++)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $all_object_types[$o]['ot_id'];?>" <?php echo ($all_object_types[$o]['ot_id']==$all_subids[$i]['object_type'])?"selected":"";?>><?php echo $all_object_types[$o]['ot_description'];?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <script type="text/javascript">
                                                                $('#object_type<?php echo $all_subids[$i]['subo_id'];?>').on('change',function(){
                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                                                    method: "get",
                                                                    data: {
                                                                        subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                                        object_type:$(this).val(),
                                                                        option:"change_object_type"},
                                                                    dataType:"html",
                                                                    success:function(data) {
                                                                        console.log(data);										
                                                                    },
                                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                                        console.log(xhr.status);
                                                                        console.log(thrownError);
                                                                    }
                                                                    
                                                                }); 
                                                            });
                                                            </script>                                            
                                                        </div>                                        
                                                        <div class="col-md-2">
                                                            <textarea class="form-control form-control-sm" id="subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" placeholder="Explanation" style="height: 30px;"><?php 
                                                            echo $all_subids[$i]['subo_more_infos'];?></textarea>
                                                            <script type="text/javascript">
                                                                $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                                                                    $.ajax({
                                                                        url: "<?php echo $base_url;?>ajax/change_orders_subnames_more_infos.php",
                                                                        method: "get",
                                                                        data: {
                                                                            subo_id: $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                                            all_subo_more_infos:$(this).val(),
                                                                            option:"rename_all_more_infos"
                                                                        },
                                                                        dataType:"html",
                                                                        success:function(data) {
                                                                            console.log(data);										
                                                                        },
                                                                        error: function (xhr, ajaxOptions, thrownError) {
                                                                            console.log(xhr.status);
                                                                            console.log(thrownError);
                                                                        }
                                                                        
                                                                    }); 
                                                                });
                                                            </script>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" id="del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="btn btn-sm btn-danger">X</button>
                                                            <script type="text/javascript">
                                                            $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').click(function(){
                                                                if(confirm('Are you sure want to delete ?'))
                                                                {
                                                                    $.ajax({
                                                                        url: "<?php echo $base_url;?>ajax/delete_orders_subnames.php",
                                                                        method: "post",
                                                                        data: {
                                                                            subo_id: $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                                            },
                                                                        dataType:"html",
                                                                        success:function(data) {
                                                                            $('#row_subname<?php echo $all_subids[$i]['subo_id'];?>').fadeOut(3000);										
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
                                            }
                                            ?>                              
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>                       
				
                        <div class="row w-100 mx-0">
                            <?php
                                

                                $lic_sites=$prod->get_lic_site($order['ls_id']);				
                
                                $ls_prods=explode(';',$lic_sites['ls_prods']);
                                
                                $cur_factor=$lic_sites['cur_fac_'.strtolower($currency)];                               
                                
                                $b1_g_products=array();

                                $b1_g_columns=3;
                                $b1_g_lines=ceil(3 / $b1_g_columns);
                                $counter=1;

                                for($i=0;$i<count($ls_prods);$i++)
                                {
                                    if(strpos($ls_prods[$i], 'g') !== false)
                                    {
                                        if(!empty($ls_prods[$i]))
                                        {
                                        $b1_g_products[]=$ls_prods[$i];
                                        }
                                    }
                                }


                                for($i=0;$i<count($b1_g_products);$i++)
                                {
                                    if(!empty($b1_g_products[$i]))
                                    {
                                        $product=$prod->get_product($b1_g_products[$i]);
                                        if($order['payment_way']==9)
                                        {
                                            $product_price=$prod->calculateProductAPU($b1_g_products[$i]);
                                        }
                                        else
                                        {
                                            $product_price=$prod->calculateProductPrice($order['ls_id'],$b1_g_products[$i],$cur_factor);
                                        }
                                        $product_apu=$prod->calculateProductAPU($b1_g_products[$i]);
                                        $product_labc=$prod->calculateProductlabc($b1_g_products[$i]);
                                        
                                        if($counter==1)
                                        {
                                            ?>
                                            <div class="col-md-4">
                                            <?php
                                        }
                                        ?>
                                        <div class="row w-100 mx-0 my-1">					
                                            <div class="<?php 
                                                for($j=0;$j<count($collection);$j++)
                                                {
                                                    if($b1_g_products[$i]==$collection[$j])
                                                    {
                                                        echo "active_layout p-1";
                                                    }
                                                }							
                                                ?>">
                                                <input class="products product_g_b1 checkbox mr-2" type="checkbox" name="<?php echo $b1_g_products[$i]; ?>" id="<?php echo $b1_g_products[$i]; ?>" value="<?php echo $b1_g_products[$i]; ?>" <?php 
                                                for($j=0;$j<count($collection);$j++)
                                                {
                                                    if($b1_g_products[$i]==$collection[$j])
                                                    {
                                                        echo "checked";
                                                    }
                                                }
                                                ?>> 
                                                <label for="<?php echo $b1_g_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                                //echo $product_price." ".$currency; 
                                                echo $product_apu." APE";?></label>					
                                                <input type="hidden" id="product_<?php echo $b1_g_products[$i];?>_price" name="product_<?php echo $b1_g_products[$i];?>_price" class="<?php 
                                                for($j=0;$j<count($collection);$j++)
                                                {
                                                    if($b1_g_products[$i]==$collection[$j])
                                                    {
                                                        echo "prices_g_b1";
                                                    }
                                                }
                                                ?>" value="<?php echo $product_price; ?>">
                                                <input type="hidden" id="product_<?php echo $b1_g_products[$i];?>_apu" name="product_<?php echo $b1_g_products[$i];?>_apu" class="<?php 
                                                for($j=0;$j<count($collection);$j++)
                                                {
                                                    if($b1_g_products[$i]==$collection[$j])
                                                    {
                                                        echo "apus_g_b1";
                                                    }
                                                }
                                                ?>" value="<?php echo $product_apu; ?>">
                                                <input type="hidden" id="product_<?php echo $b1_g_products[$i];?>_labc" name="product_<?php echo $b1_g_products[$i];?>_labc" class="<?php 
                                                for($j=0;$j<count($collection);$j++)
                                                {
                                                    if($b1_g_products[$i]==$collection[$j])
                                                    {
                                                        echo "labcs_g_b1";
                                                    }
                                                }
                                                ?>" value="<?php echo $product_labc; ?>">

                                                <input type="hidden" id="product_<?php echo $b1_g_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                                <input type="hidden" id="product_<?php echo $b1_g_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                                <input type="hidden" id="product_<?php echo $b1_g_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                                <?php
                                                if(($b1_g_products[$i]=="p11g3")||($b1_g_products[$i]=="p11g6")||($b1_g_products[$i]=="p11g8")||
                                                ($b1_g_products[$i]=="p11gb")||($b1_g_products[$i]=="p11gm")||($b1_g_products[$i]=="p11gt")||($b1_g_products[$i]=="p11gs"))
                                                {
                                                ?>
                                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b1_g_multiplicator" form="order_details" id="<?php echo $b1_g_products[$i]; ?>_fac" name="<?php echo $b1_g_products[$i]; ?>_fac" value="<?php 
                                                echo ($o_desc_g_b1[$b1_g_products[$i]."_fac"]!=0)?$o_desc_g_b1[$b1_g_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                                <?php
                                                }                                    
                                                ?>
                                            </div>						
                                        </div>	
                                        <?php
                                        if(($counter%$b1_g_lines==0)&&($counter>0))
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
                                <br>
                                
                    
                            <div class="row form-inline w-100 mx-0 border-bottom border-dark">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <b>Employee-Producer: Col G B1 = </b>
                                    <input type="text" class="form-control form-control-sm" name="col_labc_g_b1" id="col_labc_g_b1" value="<?php echo (!empty($o_desc_g_b1['col_labc_g_b1']))?$o_desc_g_b1['col_labc_g_b1']:"1";?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_g_b1 = </b>
                                    <input type="text" class="form-control form-control-sm" name="fac_labc_g_b1" id="fac_labc_g_b1" value="<?php echo (!empty($o_desc_g_b1['fac_labc_g_b1']))?$o_desc_g_b1['fac_labc_g_b1']:"1";?>" form="order_details" style="width:5em"> 
                                    <b>X Amount: </b><input type="text" class="form-control form-control-sm" name="col_amount3_g_b1" id="col_amount3_g_b1" form="order_details" value="<?php echo (!empty($o_desc_g_b1['col_amount_g_b1']))?$o_desc_g_b1['col_amount_g_b1']:"1";?>" style="width:5em">
                                    <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_g_b1" id="total_labcs_g_b1" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                                </div>
                            </div>
                            <div class="row form-inline w-100 mx-0">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <b>Producer-Trader: Col G B1 = </b>
                                    <input type="text" class="form-control form-control-sm" name="col_apus_g_b1" id="col_apus_g_b1" value="<?php echo (!empty($o_desc_g_b1['col_apus_g_b1']))?$o_desc_g_b1['col_apus_g_b1']:"1";?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_g_b1 = </b>
                                    <input type="text" class="form-control form-control-sm" name="fac_prod_g_b1" id="fac_prod_g_b1" value="<?php echo (!empty($o_desc_g_b1['fac_prod_g_b1']))?$o_desc_g_b1['fac_prod_g_b1']:"1";?>" form="order_details" style="width:5em"> 
                                    <b>X Amount: </b><input type="text" class="form-control form-control-sm" name="col_amount2_g_b1" id="col_amount2_g_b1" form="order_details" value="<?php echo (!empty($o_desc_g_b1['col_amount_g_b1']))?$o_desc_g_b1['col_amount_g_b1']:"1";?>" style="width:5em">
                                    <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_g_b1" id="o_apus_g_b1" value="<?php echo (!empty($o_desc_g_b1['o_apus_g_b1']))?$o_desc_g_b1['o_apus_g_b1']:"0";?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                                </div>
                            </div>			
                            <div class="row form-inline w-100 mx-0">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <b>Trader-Purchaser: Col G B1 = </b>
                                    <input class="form-control form-control-sm" type="text" name="col_price_g_b1" id="col_price_g_b1" value="<?php echo (!empty($o_desc_g_b1['col_price_g_b1']))?$o_desc_g_b1['col_price_g_b1']:"1"; ?>" form="order_details" style="width:5em"> 
                                    <b><?php echo $currency; ?> X fac_client_g_b1 = </b> 
                                    <input type="text" class="form-control form-control-sm" name="fac_cl_g_b1" id="fac_cl_g_b1" value="<?php echo (!empty($o_desc_g_b1['fac_cl_g_b1']))?$o_desc_g_b1['fac_cl_g_b1']:"1";?>" form="order_details" style="width:5em"> 
                                    <b> X Amount:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_g_b1" id="col_amount1_g_b1" form="order_details" value="<?php echo (!empty($o_desc_g_b1['col_amount_g_b1']))?$o_desc_g_b1['col_amount_g_b1']:"1";?>" style="width:5em"> 
                                    <b>=</b> 
                                    <input type="text" class="form-control form-control-sm" name="o_price_g_b1" id="o_price_g_b1" value="<?php echo $o_desc_g_b1['o_price_g_b1']; ?>" form="order_details" style="width:5em" >
                                    <b><?php echo $currency; ?></b>			
                                    <br><br>
                                </div>
                            </div>
                            <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">                        
                                <div class="col-md-4">
                                    <div class="form-group d-inline">
                                        <p><b>Customer remarks general: </b></p>
                                        <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group d-inline">
                                        <p><b>Operator remarks general: </b></p>
                                        <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                                    </div>
                                </div>	                                
                            </div>
                        </div>    
                

                    </div> <!-- end collapse -->
            </div>

			<p class="w-100 text-center my-2 pt-3">Customer ordered collections with these products:	</p>
			<?php 
			
			
			//$cur_factor=$licence['cur_fac'];
            
            
			if(strpos($order['collection'],'p1001')!==false)
			{
			?>
			<br>
			<div class="budget">
				<b>Amount of credits: <?php echo $budget['col_amount_b0'];?></b>
			</div>
			<?php
			}
			$o_desc_ex_b1=$prod->get_o_desc_ex_b1($o_id);
            $o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_id);
            $o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_id);
            $o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_id);
            $o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_id);
				?>
				<br>
<div class="container pagecontent px-0">
				<div class="interior" style="box-shadow: none;">
				
				<?php
				
				
				$lic_sites=$prod->get_lic_site($order['ls_id']);		
				
                
                $ls_prods=explode(';',$lic_sites['ls_prods']);
                
                $cur_factor=$lic_sites['cur_fac_'.strtolower($currency)];
                
				$columns=3;
                $b1_columns=4;
				$lines=ceil(count($ls_prods) / $columns)-1;
				
                $b1_in_products=array();
				$b1_ex_products=array();

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
                    if((substr($ls_prods[$i],1)>1100)&&(substr($ls_prods[$i],1)<1160)||(substr($ls_prods[$i], -2) == '0v'))
					{
						if(!empty($ls_prods[$i]))
						{
						$b1_in_products[]=$ls_prods[$i];
						}
					}

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
					
					if((substr($ls_prods[$i],1)>1500)&&(substr($ls_prods[$i],1)<1560)||($ls_prods[$i]=="p150x")||($ls_prods[$i]=="p150z")||($ls_prods[$i]=="p150y")||($ls_prods[$i]=="p152x")||($ls_prods[$i]=="p152z")||($ls_prods[$i]=="p152y")||($ls_prods[$i]=="p154x")||($ls_prods[$i]=="p154z")||($ls_prods[$i]=="p154y"))
					{
						if(!empty($ls_prods[$i]))
						{
						$b5_in_products[]=$ls_prods[$i];
						}
					}
                    
                    if((substr($ls_prods[$i],1)>=1600)&&(substr($ls_prods[$i],1)<1660)||($ls_prods[$i]=="p162x")||($ls_prods[$i]=="p162z")||($ls_prods[$i]=="p162y"))
					{
						if(!empty($ls_prods[$i]))
						{
						$b6_in_products[]=$ls_prods[$i];
						}
                    }
                    
                    if(($ls_prods[$i]=="p1163")||($ls_prods[$i]=="p1166")||($ls_prods[$i]=="p1168")||
                    ($ls_prods[$i]=="p116b")||($ls_prods[$i]=="p116m")||($ls_prods[$i]=="p116t")||
                    ($ls_prods[$i]=="p118s")||(substr($ls_prods[$i], -2) == '6v')&&
                    ((substr($ls_prods[$i], -2) !="gb")||(substr($ls_prods[$i], -2) !="gm")||
                    (substr($ls_prods[$i], -2) != "gt")||(substr($ls_prods[$i], -2) !="gs")
                    )
                    )
					{
						if(!empty($ls_prods[$i]))
						{
						$b1_ex_products[]=$ls_prods[$i];
						}
					}

					if((substr($ls_prods[$i],1)>1560)&&(substr($ls_prods[$i],1)<1600)||($ls_prods[$i]=="p156x")||($ls_prods[$i]=="p156z")||($ls_prods[$i]=="p156y"))
					{
						if(!empty($ls_prods[$i]))
						{
						$b5_ex_products[]=$ls_prods[$i];
						}
					}
                    
                    if((substr($ls_prods[$i],1)>1660)&&(substr($ls_prods[$i],1)<1700)||($ls_prods[$i]=="p166x")||($ls_prods[$i]=="p166z")||($ls_prods[$i]=="p166y")||($ls_prods[$i]=="p168s")||($ls_prods[$i]=="p166p"))
					{
						if(!empty($ls_prods[$i]))
						{
						$b6_ex_products[]=$ls_prods[$i];
						}
                    }

					if((substr($ls_prods[$i],1)>=1700)&&(substr($ls_prods[$i],1)<1760)||($ls_prods[$i]=="p170x")||($ls_prods[$i]=="p170z")||($ls_prods[$i]=="p170y")||($ls_prods[$i]=="p172x")||($ls_prods[$i]=="p172z")||($ls_prods[$i]=="p172y")||($ls_prods[$i]=="p174x")||($ls_prods[$i]=="p174z")||($ls_prods[$i]=="p174y"))
					{
            
						if(!empty($ls_prods[$i]))
						{

						$b7_in_products[]=$ls_prods[$i];
						}
					}
                    
                    if((substr($ls_prods[$i],1)>=1800)&&(substr($ls_prods[$i],1)<1860))
					{
						if(!empty($ls_prods[$i]))
						{
						$b8_in_products[]=$ls_prods[$i];
						}
                    }
                    
					if((substr($ls_prods[$i],1)>1760)&&(substr($ls_prods[$i],1)<1800)||($ls_prods[$i]=="p176x")||($ls_prods[$i]=="p176z")||($ls_prods[$i]=="p176y"))
					{
						if(!empty($ls_prods[$i]))
						{
						$b7_ex_products[]=$ls_prods[$i];
						}
                    }
                    
                    if((substr($ls_prods[$i],1)>1860)&&(substr($ls_prods[$i],1)<1900)||($ls_prods[$i]=="p186x")||($ls_prods[$i]=="p186z")||($ls_prods[$i]=="p186y"))
					{
						if(!empty($ls_prods[$i]))
						{
						$b8_ex_products[]=$ls_prods[$i];
						}
					}
				}
				
				$interior=0;
				
				
					for($i=0;$i<count($collection);$i++)
					{
						if(($collection[$i]=="p1501")||($collection[$i]=="p1301")||($collection[$i]=="p1601")||($collection[$i]=="p1701")||($collection[$i]=="p1801"))
						{
							$interior++;
						}
                    }
                    
// this part is working				
if($interior>0)
{
                    $o_desc_in_b1=$prod->get_o_desc_in_b1($o_id);
					$o_desc_in_b3=$prod->get_o_desc_in_b3($o_id);
                    $o_desc_in_b5=$prod->get_o_desc_in_b5($o_id);
                    $o_desc_in_b6=$prod->get_o_desc_in_b6($o_id);
                    $o_desc_in_b7=$prod->get_o_desc_in_b7($o_id);
                    $o_desc_in_b8=$prod->get_o_desc_in_b8($o_id);

                   // echo count($b8_in_products);
				?>
                <div style="background-color:#FFFFD7;">
				<div class="row w-100 mx-0 border-top">
                    <div class="col-md-4">
                    <div class="form-inline">
                        <p class="d-inline mr-3 mb-0"><b>Amount of interior subIDs: </b></p>
                        <input type="text" class="form-control form-control-sm" name="col_amount0" id="col_amount0" form="order_details" value="<?php 
						
						// if(!isset($_COOKIE['col_amount0']))
						// {
							$amount=1;
							if((empty($o_desc_in_b1['col_amount_in_b1']))&&
                            (empty($o_desc_in_b3['col_amount_in_b3']))&&
                            (empty($o_desc_in_b5['col_amount_in_b5']))&&
                            (empty($o_desc_in_b6['col_amount_in_b6']))&&
                            (empty($o_desc_in_b7['col_amount_in_b7']))&&
                            (empty($o_desc_in_b8['col_amount_in_b8'])))
							{
								echo "1";
							}
							else
							{
                                if(!empty($o_desc_in_b1))
                                {
                                    if($o_desc_in_b1['col_amount_in_b1']>0)
                                    {
                                        echo $o_desc_in_b1['col_amount_in_b1'];
                                        $amount++;
                                    }
                                }
                                if($amount==1)
								{
								if($o_desc_in_b3['col_amount_in_b3']>0)
								{
									echo $o_desc_in_b3['col_amount_in_b3'];
									$amount++;
								}
                                }
								if($amount==1)
								{
									if($o_desc_in_b5['col_amount_in_b5']>0)
									{
										echo $o_desc_in_b5['col_amount_in_b5'];
										$amount++;
									}
                                }
                                if($amount==1)
								{
									if($o_desc_in_b6['col_amount_in_b6']>0)
									{
										echo $o_desc_in_b6['col_amount_in_b6'];
										$amount++;
									}
								}
								if($amount==1)
								{
									if($o_desc_in_b7['col_amount_in_b7']>0)
									{
										echo $o_desc_in_b7['col_amount_in_b7'];
										$amount++;
									}
                                }
                                if($amount==1)
								{
									if($o_desc_in_b8['col_amount_in_b8']>0)
									{
										echo $o_desc_in_b8['col_amount_in_b8'];
										$amount++;
									}
								}
							}
						// }
						// else
						// {
							
						// 	echo $_COOKIE['col_amount0'];
						// }
						?>" style="width:5em">
                        </div>
                    </div>
					<div class="col-md-5">
						<h5 class="mb-0 pt-2 text-success">Interior</h5>
                        <hr width="300px" class="bg-dark"> 
					</div>
				</div>
				<br>
                <div class="row w-100 mx-0">
                        <div class="col-md-auto">
                            &nbsp;
                        </div>
                        <div class="col-md-2">
                            <b>Name</b>
                        </div>
                        <div class="col-md-2">
                            <b>Object kind</b>
                        </div>
                        <div class="col-md-1">
                            <b>Entity info</b>
                        </div>
                        <div class="col-md-1">
                            <b>Stairs</b>
                        </div>
                        <div class="col-md-2">
                            <b>Rooms</b>
                        </div>
                        <div class="col-md-1">
                            <b>Connection id</b>
                        </div>
                        <div class="col-md-2">
                            <b>Explanations</b>
                        </div>
                    
                    
                </div>
				<div class="row w-100 mx-0">
                    <script type="text/javascript">
                        $(document).ready(function(){
                            /*
                            $.ajax({
                                url: "../ajax/create_orders_subnames_interior_html.php",
                                method: "post",
                                data: {o_id:<?php echo $o_id;?>,total_interior_amount:$('#col_amount0').val()},
                                dataType:"html",
                                success:function(data) {
                                    $('#interior_osn_texts').html(data);										
                                }
                            });*/

                        });

                        $('#col_amount0').on('change focusout',function(){

                            $.ajax({
                                url: "../ajax/create_orders_subnames_interior_html.php",
                                method: "post",
                                data: {o_id:<?php echo $o_id;?>,total_interior_amount:$('#col_amount0').val()},
                                dataType:"html",
                                success:function(data) {
                                    $('#interior_osn_texts').html(data);										
                                }
                            });

                        });
                    </script>
                    <div class="col-md-12 justify-content-center">
                        <div class="row">
                            <div class="col-md-12 d-inline" id="interior_osn_texts">
                                <?php
                            $all_subids=$prod->get_all_subids_by_o_id($o_id);

                                for($i=0;$i<count($all_subids);$i++)
                                {
                                    if (strpos($all_subids[$i]['o_sub_id'], 'n') !== false) 
                                    {
                                        ?>
                                        <div id="row_subname<?php echo $all_subids[$i]['subo_id'];?>" class="row">
                                        
                                            <div class="col-md-2">
                                            <?php
                                            echo $all_subids[$i]['o_sub_id']."&nbsp;";
                                            ?>
                                            </div>
                                        <div class="col-md-2">
                                    <input type="text" list="interior_subid_list<?php echo $all_subids[$i]['subo_id'];?>" id="subo_id<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" value="<?php echo $all_subids[$i]['subo_name'];?>" placeholder="Name" class="form-control form-control-sm">
                                    <datalist id="interior_subid_list<?php echo $all_subids[$i]['subo_id'];?>">
                                        <option value="Grundrisse">
                                        <option value="Innen">
                                    </datalist>
                                    <script type="text/javascript">
                                        

                                    $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                                        $.ajax({
                                            url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                            method: "get",
                                            data: {
                                                subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                interior_subname:$(this).val(),
                                                option:"rename_interior_osn_file"},
                                            dataType:"html",
                                            success:function(data) {
                                                console.log(data);										
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                console.log(xhr.status);
                                                console.log(thrownError);
                                            }
                                            
                                        }); 
                                    });
                                    </script>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <select id="object_type<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="form-control form-control-sm">
                                                <option value="">--Object type--</option>
                                                <?php
                                                $all_object_types=$prod->get_all_object_types();
                                                for($o=0;$o<count($all_object_types);$o++)
                                                {
                                                    ?>
                                                    <option value="<?php echo $all_object_types[$o]['ot_id'];?>" <?php echo ($all_object_types[$o]['ot_id']==$all_subids[$i]['object_type'])?"selected":"";?>><?php echo $all_object_types[$o]['ot_description'];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <script type="text/javascript">
                                                $('#object_type<?php echo $all_subids[$i]['subo_id'];?>').on('change',function(){
                                                $.ajax({
                                                    url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                                    method: "get",
                                                    data: {
                                                        subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                        object_type:$(this).val(),
                                                        option:"change_object_type"},
                                                    dataType:"html",
                                                    success:function(data) {
                                                        console.log(data);										
                                                    },
                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                        console.log(xhr.status);
                                                        console.log(thrownError);
                                                    }
                                                    
                                                }); 
                                            });
                                            </script>                                            
                                        </div>
                                        <div class="col-md-2">
                                            <?php /*<div class="form-inline">
                                            <p class="mb-0 mr-3">
                                            <b><?php
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
                                            </p>
                                            <?php
                                            */
                                            $stairs=$domenia3n->get_all_stairs();
                                            
                                            ?>
                                            <select id="st_id0" name="st_id0" class="form-control form-control-sm" <?php
                                            if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
                                                <option value="">--Stairs--</option>
                                                <?php
                                                for($s=0;$s<count($stairs);$s++)
                                                {
                                                ?>
                                                <option value="<?php echo $stairs[$s]['st_id'];?>" <?php echo ($order['st_id']==$stairs[$s]['st_id'])?"selected":"";?>><?php echo $stairs[$s]['st_name'];?></option>
                                                <?php							
                                                }
                                                ?>
                                            </select>
                                            
                                        </div>
                                        <div class="col-md-2">
                                            <a href="<?php echo $base_url;?>rooms/index.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $all_subids[$i]['o_sub_id']?>" class="btn btn-sm btn-success" target="_blank" >(0):Edit or create</a>
                                        </div>
                                        <div class="col-md-2">
                                            <textarea class="form-control form-control-sm" id="subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" placeholder="Explanation" style="height: 30px;"><?php 
                                            echo $all_subids[$i]['subo_more_infos'];?></textarea>
                                            <script type="text/javascript">
                                                $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                                                    $.ajax({
                                                        url: "<?php echo $base_url;?>ajax/change_orders_subnames_more_infos.php",
                                                        method: "get",
                                                        data: {
                                                            subo_id: $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                            interior_subo_more_infos:$(this).val(),
                                                            option:"rename_interior_more_infos"
                                                        },
                                                        dataType:"html",
                                                        success:function(data) {
                                                            console.log(data);										
                                                        },
                                                        error: function (xhr, ajaxOptions, thrownError) {
                                                            console.log(xhr.status);
                                                            console.log(thrownError);
                                                        }
                                                        
                                                    }); 
                                                });
                                            </script>
                                        </div>
                                        <div class="col-md-1">
                                        <button type="button" id="del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="btn btn-sm btn-danger">X</button>
                                        <script type="text/javascript">
                                        $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').click(function(){
                                            if(confirm('Are you sure want to delete ?'))
                                            {
                                                $.ajax({
                                                    url: "<?php echo $base_url;?>ajax/delete_orders_subnames.php",
                                                    method: "post",
                                                    data: {
                                                        subo_id: $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                                        },
                                                    dataType:"html",
                                                    success:function(data) {
                                                        $('#row_subname<?php echo $all_subids[$i]['subo_id'];?>').fadeOut(3000);										
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
                                }
                                ?>                              
                            </div>
                           
                        </div>
                    </div>
				    </div>
				</div>
				<hr class="bg-dark">
				
                <div class="row mx-0 w-100 border-top border-bottom pt-3 d-flex justify-content-center" id="b1intopen" style="background-color:#c9c995;">
                    <!-- <p class="d-inline ml-auto">This client has not chosen a b5 interior product. </p> -->
                    <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb1" data-toggle="collapse" id="b1intbtnopen">B1 interior</button></p>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('#b1intopen').css('display','');
                    });

                    $('#b1intbtnopen').click(function(){
                        setTimeout(function(){$('#b1intopen').css('display','')},1000);
                    });
                    </script>
                </div>
                <?php
                if(count($b1_in_products)>0)
			    {   
				
				?>	
				<div class="col-md-12 collapse <?php
                    if((strpos($order['collection'], 'p1103') !== false) || (strpos($order['collection'], 'p1104') !== false))
                    {
                        echo "show";
                    }?>" id="interiorb1" style="background-color:#c9c995;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b1_in_lines=ceil(count($b1_in_products) / $b1_columns);
                    $counter=1;
                    for($i=0;$i<count($b1_in_products);$i++)
                    {
                        if(!empty($b1_in_products[$i]))
                        {
                            $product=$prod->get_product($b1_in_products[$i]);
                            if($order['payment_way']==9)
                            {
                                $product_price=$prod->calculateProductAPU($b1_in_products[$i]);
                            }
                            else
                            {
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b1_in_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b1_in_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b1_in_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                
                                for($j=0;$j<count($collection);$j++)
                                {
                                    
                                    if($b1_in_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout";
                                        
                                    }
                                    
                                }							
                                ?>">
                                    <input class="products product_in_b1 checkbox mx-2" type="checkbox" name="<?php echo $b1_in_products[$i]; ?>" id="<?php echo $b1_in_products[$i]; ?>" value="<?php echo $b1_in_products[$i]; ?>" <?php 
                                        
                                        for($j=0;$j<count($collection);$j++)
                                        {
                                            
                                            if($b1_in_products[$i]==$collection[$j])
                                            {
                                                echo "checked";
                                                
                                            }
                                            
                                        }							
                                        ?>> 
                                    <label for="<?php echo $b1_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                    //echo $product_price." ".$currency; 
                                    echo $product_apu." APE";?></label>	
                                    
                                    <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

                                    <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_price" name="product_<?php echo $b1_in_products[$i];?>_price" class="<?php 
                                    
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        
                                        if($b1_in_products[$i]==$collection[$j])
                                        {
                                            echo "prices_in_b1";
                                            
                                        }
                                        
                                    }
                                    ?>" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_apu" name="product_<?php echo $b1_in_products[$i];?>_apu" class="<?php 
                                    
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        
                                        if($b1_in_products[$i]==$collection[$j])
                                        {
                                            echo "apus_in_b1";
                                            
                                        }
                                            
                                    }
                                    ?>" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_labc" name="product_<?php echo $b1_in_products[$i];?>_labc" class="<?php 
                                    
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        
                                        if($b1_in_products[$i]==$collection[$j])
                                        {
                                            echo "labcs_in_b1";
                                            
                                        }
                                            
                                    }
                                    ?>" value="<?php echo $product_labc; ?>"> 
                                    <?php
                                    // if(($b1_in_products[$i]=="p1501")||($b1_in_products[$i]=="p1504")||($b1_in_products[$i]=="p1506")||($b1_in_products[$i]=="p1521")||($b1_in_products[$i]=="p1524")||($b1_in_products[$i]=="p1526")||($b1_in_products[$i]=="p1541")||($b1_in_products[$i]=="p1544")||($b1_in_products[$i]=="p1546"))
                                    // { // we show to all now
                                    ?>
                                    <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b1_in_multiplicator" form="order_details" id="<?php echo $b1_in_products[$i]; ?>_fac" name="<?php echo $b1_in_products[$i]; ?>_fac" value="<?php echo (!empty($o_desc_in_b1[$b1_in_products[$i]."_fac"]))?$o_desc_in_b1[$b1_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                    <?php 
                                    //}
                                    ?>
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b1_in_lines==0)&&($counter>0))
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
                                
                        <div class="row form-inline w-100 mx-0 border-bottom border-dark">
                            <div class="col-md-12">
                                <b>Employee-Producer: Col IN B1 = </b>
                                <input type="text" class="form-control form-control-sm" name="col_labc_in_b1" id="col_labc_in_b1" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b1 = </b>
                                <input type="text" class="form-control form-control-sm" name="fac_labc_in_b1" id="fac_labc_in_b1" value="<?php echo (!empty($o_desc_in_b1['fac_labc_in_b1']))?$o_desc_in_b1['fac_labc_in_b1']:"1";?>" form="order_details" style="width:5em"> 
                                <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b1" id="col_amount3_in_b1" form="order_details" value="<?php echo (!empty($o_desc_in_b1['col_amount_in_b1']))?$o_desc_in_b1['col_amount_in_b1']:"1";?>" style="width:5em" >
                                <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b1" id="total_labcs_in_b1" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                            </div>
                        </div>
                        
                        <div class="row form-inline w-100 mx-0">
                            <div class="col-md-12">
                                <b>Producer-Trader: Col IN B1 = </b>
                                <input type="text" class="form-control form-control-sm" name="col_apus_in_b1" id="col_apus_in_b1" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b1 = </b>
                                <input type="text" class="form-control form-control-sm" name="fac_prod_in_b1" id="fac_prod_in_b1" value="<?php echo (!empty($o_desc_in_b1['fac_prod_in_b1']))?$o_desc_in_b1['fac_prod_in_b1']:"1";?>" form="order_details" style="width:5em"> 
                                <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b1" id="col_amount2_in_b1" form="order_details" value="<?php echo (!empty($o_desc_in_b1['col_amount_in_b1']))?$o_desc_in_b1['col_amount_in_b1']:"1";?>" style="width:5em" >
                                <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b1" id="o_apus_in_b1" value="<?php echo $o_desc_in_b1['o_apus_in_b1'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
                            </div>
                        </div>			
                        <div class="row form-inline w-100 mx-0 my-1">
                            <div class="col-md-12 d-flex justify-content-center">
                                <b>Trader-Purchaser: Col IN B1 = </b>
                                <input class="form-control form-control-sm" type="text" name="col_price_in_b1" id="col_price_in_b1" value="" form="order_details" style="width:5em"> 
                                <b><?php echo $currency; ?> X fac_client_in_b1 = </b> 
                                <input type="text" class="form-control form-control-sm" name="fac_cl_in_b1" id="fac_cl_in_b1" value="<?php echo (!empty($o_desc_in_b1['fac_cl_in_b1']))?$o_desc_in_b1['fac_cl_in_b1']:"1";?>" form="order_details" style="width:5em"> 
                                <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b1" id="col_amount1_in_b1" form="order_details" value="<?php echo (!empty($o_desc_in_b1['col_amount_in_b1']))?$o_desc_in_b1['col_amount_in_b1']:"1";?>" style="width:5em" > 
                                <b>=</b> 
                                <input type="text" class="form-control form-control-sm" name="o_price_in_b1" id="o_price_in_b1" value="<?php echo (!empty($o_desc_in_b1['o_price_in_b1']))?$o_desc_in_b1['o_price_in_b1']:"0";?>" form="order_details" style="width:5em">
                                <b><?php echo $currency; ?></b>			
                                <br><br>
                            </div>
                        </div>
                        <br>
				</div> <!-- end col-md-12 -->
                
                <?php               
			
        }
        ?>
                <div class="row mx-0 w-100 justify-content-center pt-3" id="b3intopen" style="">
					<!--<p class="d-inline">This client has not chosen a b3 interior product. </p> -->
					<p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb3" data-toggle="collapse" id="b3intbtnopen">B3 interior - Corel</button></p>
				</div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#b3intopen').css('display','');
                    });

                    $('#b3intbtnopen').click(function(){
                        setTimeout(function(){$('#b3intopen').css('display','')},1000);
                    });
                </script>
				<?php
            if(count($b3_in_products)>0)
            {
					
					?>
				<div class="col-md-12 px-0 collapse <?php
                    if (strpos($order['collection'], 'p1301') !== false) 
                    {
                        echo "show";
                    }?>" id="interiorb3" style="background-color:#eeeec3;">
                    <div class="row mx-0">
                        <div class="col-md-12 d-flex text-left">
                            <b>Amount of floorplans</b> <input id="b3_main_fac" type="text" class="form-control form-control-sm" style="width:3em;" value="<?php echo ($o_desc_in_b3[$b3_in_products[0]."_fac"]!=0)?$o_desc_in_b3[$b3_in_products[0]."_fac"]:"1";?>">
                        </div>
                    </div>
					<div class="row w-100 mx-0">
					<?php
					$b3_in_lines=ceil(count($b3_in_products) / $columns);
					$counter=1;
					for($i=0;$i<count($b3_in_products);$i++)
					{
						if(!empty($b3_in_products[$i]))
						{
							$product=$prod->get_product($b3_in_products[$i]);
							if(!empty($budget)>0)
							{
								$product_price=$prod->calculateProductAPU($b3_in_products[$i]);
							}
							else
							{
								$product_price=$prod->calculateProductPrice($order['ls_id'],$b3_in_products[$i],$cur_factor);
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
							<div class="row w-100 mx-0 my-1">					
								<div class="<?php 
								for($j=0;$j<count($collection);$j++)
								{
									if($b3_in_products[$i]==$collection[$j])
									{
										echo "active_layout"; 
									}
								}							
								?>">
									<input class="products product_in_b3 checkbox" type="checkbox" name="<?php echo $b3_in_products[$i]; ?>" id="<?php echo $b3_in_products[$i]; ?>" value="<?php echo $b3_in_products[$i]; ?>" <?php 
									for($j=0;$j<count($collection);$j++)
									{
										if($b3_in_products[$i]==$collection[$j])
										{
											echo "checked";
										}
									}							
									?>> 
									<label for="<?php echo $b3_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                    //echo $product_price." ".$currency; 
                                    echo $product_apu." APE";
                                    ?></label>

                                    <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                                 <?php
                                if(($b3_in_products[$i]=="p1301")||($b3_in_products[$i]=="p1321")||($b3_in_products[$i]=="p1302")||($b3_in_products[$i]=="p1322"))
                                { 
                                ?>
                                <!--<span class="text-danger font-weight-bold">X</span> --><input type="hidden" class="form-control form-control-sm d-inline px-2 b3_in_multiplicator" form="order_details" id="<?php echo $b3_in_products[$i]; ?>_fac" name="<?php echo $b3_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b3[$b3_in_products[$i]."_fac"]!=0)?$o_desc_in_b3[$b3_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                <?php 
                                }
                                ?> 
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
                    <?php
                    $main_client_colors=$prod->get_main_client_colors($client['mc_id']);
                    ?>
					<div class="row w-100 mx-0 pt-2">
						<div class="col-md-6">
							<div class="form-group">
                                <p class="d-inline mb-0">
                                    <b>Shapeline</b>
                                </p>
                                <select name="sl_id" id="sl_id" class="form-control form-control-sm d-inline" form="order_details" style="width:200px;">
								<option value="">None</option>
							<?php 
							$all_b3_shapes=$domenia3n->get_all_b3_shapes();
							
							for($i=0;$i<count($all_b3_shapes);$i++)
							{
							?>
							<option value="<?php echo $all_b3_shapes[$i]['sl_id'];?>" <?php 
                            //echo ($all_b3_shapes[$i]['sl_id']==$o_desc_in_b3['sl_id'])?"selected":"";
                            echo ($all_b3_shapes[$i]['sl_id']==$main_client_colors['sl_id'])?"selected":"";

                            ?>><?php echo $all_b3_shapes[$i]['sl_id']." - ".$all_b3_shapes[$i]['sl_name'];?></option>
							<?php
							}
							?>
							</select>
                            </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
                                <p class="d-inline mb-0">
                                    <b>Colorset</b>
                                </p>
                                    <select name="cls_id" id="cls_id" class="form-control form-control-sm d-inline" form="order_details" style="width:200px;">
                                        <option value="">None</option>
                                    <?php 
                                    
                                    $all_b3_colorset=$domenia3n->get_all_b3_colorsets();
                                    
                                    for($i=0;$i<count($all_b3_colorset);$i++)
                                    {
                                    ?>
                                    <option value="<?php echo $all_b3_colorset[$i]['cls_id'];?>" <?php 
                                    //echo ($all_b3_colorset[$i]['cls_id']==$o_desc_in_b3['cls_id'])?"selected":"";
                                    echo ($all_b3_colorset[$i]['cls_id']==$main_client_colors['cls_id'])?"selected":"";?>><?php echo $all_b3_colorset[$i]['cls_id']." - ".$all_b3_colorset[$i]['cls_name'];?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                
                            </div>
						</div>
					</div>
					
					<br>
					
                    <div class="row form-inline">
						<div class="col-md-12">
							<b>Employee-Producer: Col IN B3 = </b>
							<input type="text" class="form-control form-control-sm" name="col_labc_in_b3" id="col_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_labc_in_b3']))?$o_desc_in_b3['col_labc_in_b3']:0;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b3 = </b>
							<input type="text" class="form-control form-control-sm" name="fac_labc_in_b3" id="fac_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_labc_in_b3']))?$o_desc_in_b3['fac_labc_in_b3']:"1";?>" form="order_details" style="width:5em"> 
							<b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b3" id="col_amount3_in_b3" form="order_details" value="<?php echo (!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:"1";?>" style="width:5em" >
							<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b3" id="total_labcs_in_b3" value="<?php echo (!empty($o_desc_in_b3['total_labcs_in_b3']))?$o_desc_in_b3['total_labcs_in_b3']:"0";?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
						</div>
					</div>
					<div class="row form-inline">
						<div class="col-md-12">
							<b>Producer-Trader: Col IN B3 = </b>
							<input type="text" class="form-control form-control-sm" name="col_apus_in_b3" id="col_apus_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_apus_in_b3']))?$o_desc_in_b3['col_apus_in_b3']:0;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b3 = </b>
							<input type="text" class="form-control form-control-sm" name="fac_prod_in_b3" id="fac_prod_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_prod_in_b3']))?$o_desc_in_b3['fac_prod_in_b3']:"1";?>" form="order_details" style="width:5em"> 
							<b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b3" id="col_amount2_in_b3" form="order_details" value="<?php echo (!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:"0";?>" style="width:5em" >
							<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b3" id="o_apus_in_b3" value="<?php echo (!empty($o_desc_in_b3['o_apus_in_b3']))?$o_desc_in_b3['o_apus_in_b3']:"0";?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
						</div>
					</div>			
					<div class="row form-inline">
						<div class="col-md-12">
							<b>Trader-Purchaser: Col IN B3 = </b>
							<input class="form-control form-control-sm" type="text" name="col_price_in_b3" id="col_price_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_price_in_b3']))?$o_desc_in_b3['col_price_in_b3']:0;?>" form="order_details" style="width:5em"> 
							<b><?php echo $currency; ?> X fac_client_in_b3 = </b> 
							<input type="text" class="form-control form-control-sm" name="fac_cl_in_b3" id="fac_cl_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_cl_in_b3']))?$o_desc_in_b3['fac_cl_in_b3']:"1";?>" form="order_details" style="width:5em"> 
							<b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b3" id="col_amount1_in_b3" form="order_details" value="<?php echo (!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:"0";?>" style="width:5em" > 
							<b>=</b> 
							<input type="text" class="form-control form-control-sm" name="o_price_in_b3" id="o_price_in_b3" value="<?php echo (!empty($o_desc_in_b3['o_price_in_b3']))?$o_desc_in_b3['o_price_in_b3']:"0";?>" form="order_details" style="width:5em">
							<b><?php echo $currency; ?></b>			
							<br><br>
						</div>
					</div>
					
					<br>
            
					<hr style="border:2px solid brown;">
							
				</div>			
			<?php	
            }
            ?>
            <br>
            <div class="row mx-0 w-100 border-top border-bottom pt-3 d-flex justify-content-center" id="b5intopen" style="background-color:#c9c995;">
				<!-- <p class="d-inline ml-auto">This client has not chosen a b5 interior product. </p> -->
				<p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb5" data-toggle="collapse" id="b5intbtnopen">B5 interior - Skp/V-Ray</button></p>
			</div>
            <script type="text/javascript">
                $('#b5intbtnopen').click(function(){
                    
                    //$('#b5intopen').css('display','block');
                    setTimeout(function(){$('#b5intopen').css('display','')},1000);
                });
            </script>
            <?php
			if(count($b5_in_products)>0)
			{   
				$layout_id=$o_desc_in_b5['layout_id'];
				$window_id=$o_desc_in_b5['window_id'];
				?>	
				<div class="col-md-12 collapse <?php
                if (strpos($order['collection'], 'p1501') !== false) 
                {
                    echo "show";
                }?>" id="interiorb5" style="background-color:#c9c995;">
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
							$product_price=$prod->calculateProductPrice($order['ls_id'],$b5_in_products[$i],$cur_factor);
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
						<div class="row w-100 mx-0 my-1">					
							<div class="<?php 
							
							for($j=0;$j<count($collection);$j++)
							{
								
								if($b5_in_products[$i]==$collection[$j])
								{
									echo "active_layout";
									
								}
								
							}							
							?>">
								<input class="products product_in_b5 checkbox mx-2" type="checkbox" name="<?php echo $b5_in_products[$i]; ?>" id="<?php echo $b5_in_products[$i]; ?>" value="<?php echo $b5_in_products[$i]; ?>" <?php 
									
									for($j=0;$j<count($collection);$j++)
									{
										
										if($b5_in_products[$i]==$collection[$j])
										{
											echo "checked";
											
										}
										
									}							
									?>> 
								<label for="<?php echo $b5_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php                                
                                //echo $product_price." ".$currency; 
                                echo $product_apu." APE";
                                ?></label>	
                                
                                <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                                <?php
                                // if(($b5_in_products[$i]=="p1501")||($b5_in_products[$i]=="p1504")||($b5_in_products[$i]=="p1506")||($b5_in_products[$i]=="p1521")||($b5_in_products[$i]=="p1524")||($b5_in_products[$i]=="p1526")||($b5_in_products[$i]=="p1541")||($b5_in_products[$i]=="p1544")||($b5_in_products[$i]=="p1546"))
                                // { // we show to all now
                                ?>
                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_in_multiplicator" form="order_details" id="<?php echo $b5_in_products[$i]; ?>_fac" name="<?php echo $b5_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b5[$b5_in_products[$i]."_fac"]!=0)?$o_desc_in_b5[$b5_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                <?php 
                                //}
                                ?>
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
				<div class="row w-100 mx-0 mb-4">
					<div class="col-md-12 d-flex justify-content-center">
						<div id="b5_nav" class="nav nav-inline">
							<p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                            <?php 
                            $layout=$domenia->get_layout2($layout_id); 
									
							$layoutline=$domenia->get_layouts_by_quality_id2("b5");
							
							for($i=0;$i<count($layoutline);$i++)
							{
								?>
								<a href="#b5_layouts" class="nav-item <?php
								if($layout_id==$layoutline[$i]['l_id'])
								{
									echo "active-layoutline";
								}
								?>" title="<?php echo $layoutline[$i]['l_id'];?>">
									<div class="colorbox b5_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                                    echo $window['window_color']; ?>;border: 10px solid <?php                     
                                    $floor_color=$domenia3n->get_b5_colorset($layoutline[$i]['set_colors']);
                                    echo $floor_color['cl1_floor'];?>">
									</div>
								</a>					
								<?php							
							}
							?>
						</div>
						<input type="hidden" name="b5_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
					</div>
				</div> <!-- end row -->
                <?php
			
			
			// if(count($b5_in_products)>0)
			// {
				
			?>
            <div class="row form-inline w-100 mx-0 border-bottom border-dark">
				<div class="col-md-12">
					<b>Employee-Producer: Col IN B5 = </b>
					<input type="text" class="form-control form-control-sm" name="col_labc_in_b5" id="col_labc_in_b5" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b5 = </b>
					<input type="text" class="form-control form-control-sm" name="fac_labc_in_b5" id="fac_labc_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"1";?>" form="order_details" style="width:5em"> 
					<b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b5" id="col_amount3_in_b5" form="order_details" value="<?php echo $o_desc_in_b5['col_amount_in_b5'];/*echo (!empty($o_desc_in_b5['col_amount_in_b5']))?$o_desc_in_b5['col_amount_in_b5']:"1";*/?>" style="width:5em" >
					<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b5" id="total_labcs_in_b5" value="<?php echo (!empty($o_desc_in_b5['total_labcs_in_b5']))?$o_desc_in_b5['total_labcs_in_b5']:"0";?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
				</div>
			</div>
			
			<div class="row form-inline w-100 mx-0">
				<div class="col-md-12">
					<b>Producer-Trader: Col IN B5 = </b>
					<input type="text" class="form-control form-control-sm" name="col_apus_in_b5" id="col_apus_in_b5" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b5 = </b>
					<input type="text" class="form-control form-control-sm" name="fac_prod_in_b5" id="fac_prod_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"1";?>" form="order_details" style="width:5em"> 
					<b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b5" id="col_amount2_in_b5" form="order_details" value="<?php echo $o_desc_in_b5['col_amount_in_b5'];/* echo (!empty($o_desc_in_b5['col_amount_in_b5']))?$o_desc_in_b5['col_amount_in_b5']:"1";*/?>" style="width:5em" >
					<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b5" id="o_apus_in_b5" value="<?php echo (!empty($o_desc_in_b5['o_apus_in_b5']))?$o_desc_in_b5['o_apus_in_b5']:"0";?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
				</div>
			</div>			
			<div class="row form-inline w-100 mx-0 my-1">
				<div class="col-md-12 d-flex justify-content-center">
					<b>Trader-Purchaser: Col IN B5 = </b>
					<input class="form-control form-control-sm" type="text" name="col_price_in_b5" id="col_price_in_b5" value="" form="order_details" style="width:5em"> 
					<b><?php echo $currency; ?> X fac_client_in_b5 = </b> 
					<input type="text" class="form-control form-control-sm" name="fac_cl_in_b5" id="fac_cl_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"1";?>" form="order_details" style="width:5em"> 
					<b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b5" id="col_amount1_in_b5" form="order_details" value="<?php echo $o_desc_in_b5['col_amount_in_b5'];/*echo (!empty($o_desc_in_b5['col_amount_in_b5']))?$o_desc_in_b5['col_amount_in_b5']:"1";*/?>" style="width:5em" > 
					<b>=</b> 
					<input type="text" class="form-control form-control-sm" name="o_price_in_b5" id="o_price_in_b5" value="<?php echo (!empty($o_desc_in_b5['o_price_in_b5']))?$o_desc_in_b5['o_price_in_b5']:"0";?>" form="order_details" style="width:5em">
					<b><?php echo $currency; ?></b>			
					<br><br>
				</div>
			</div>
				<br>
				</div> <!-- end col-md-12 -->     
                <?php
                
			
        }
        ?>
        <div class="row mx-0 w-100 justify-content-center pt-3" id="b6intopen" style="background-color:#8e8e48;">
            <!-- <p class="d-inline">This client has not chosen a b7 interior product. </p> -->
            <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb6" data-toggle="collapse" id="b6intbtnopen">B6 interior - Twinmotion</button></p>
        </div>
        <?php
            //start b6 

            if(count($b6_in_products)>0)
			{   
            ?>
                
                <?php
                if(!empty($o_desc_in_b6['layout_id']))
                {
				    $layout_id=$o_desc_in_b6['layout_id'];
                }
                else
                {
                    $layout_id="";
                }
                if(!empty($o_desc_in_b6['window_id']))
                {
                    $window_id=$o_desc_in_b6['window_id'];
                }
                else
                {
                    $window_id="";
                }
				?>	
				<div class="col-md-12 collapse <?php
                if (strpos($order['collection'], 'p1601') !== false) 
                {
                    echo "show";
                }?>" id="interiorb6" style="background-color:#8e8e48;">
               
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
							$product_price=$prod->calculateProductPrice($order['ls_id'],$b6_in_products[$i],$cur_factor);
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
						<div class="row w-100 mx-0 my-1">					
							<div class="<?php 
							
							for($j=0;$j<count($collection);$j++)
							{
								
								if($b6_in_products[$i]==$collection[$j])
								{
									echo "active_layout";
									
								}
								
							}							
							?>">
								<input class="products product_in_b6 checkbox mx-2" type="checkbox" name="<?php echo $b6_in_products[$i]; ?>" id="<?php echo $b6_in_products[$i]; ?>" value="<?php echo $b6_in_products[$i]; ?>" <?php 
									
									for($j=0;$j<count($collection);$j++)
									{
										
										if($b6_in_products[$i]==$collection[$j])
										{
											echo "checked";
											
										}
										
									}							
									?>> 
								<label for="<?php echo $b6_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                //echo $product_price." ".$currency; 
                                echo $product_apu." APE";
                                ?></label>	
                                
                                <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                                <?php
                                // if(($b6_in_products[$i]=="p1600")||($b6_in_products[$i]=="p1601")||($b6_in_products[$i]=="p1604")||($b6_in_products[$i]=="p1606")||($b6_in_products[$i]=="p1621")||($b6_in_products[$i]=="p1624")||($b6_in_products[$i]=="p1626")||($b6_in_products[$i]=="p1641")||($b6_in_products[$i]=="p1644")||($b6_in_products[$i]=="p1646"))
                                // { 
                                ?>
                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b6_in_multiplicator" form="order_details" id="<?php echo $b6_in_products[$i]; ?>_fac" name="<?php echo $b6_in_products[$i]; ?>_fac" value="<?php echo (!empty($o_desc_in_b6[$b6_in_products[$i]."_fac"]))?$o_desc_in_b6[$b6_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                <?php 
                                //}
                                ?>
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
				<div class="row w-100 mx-0 mb-4">
					<div class="col-md-12 d-flex justify-content-center">
						<div id="b6_nav" class="nav nav-inline">
							<p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                            <?php 
                            $layout=$domenia->get_layout2($layout_id); 
									
							$layoutline=$domenia->get_layouts_by_quality_id2("b6");
							
							for($i=0;$i<count($layoutline);$i++)
							{
								?>
								<a href="#b6_layouts" class="nav-item <?php
								if($layout_id==$layoutline[$i]['l_id'])
								{
									echo "active-layoutline";
								}
								?>" title="<?php echo $layoutline[$i]['l_id'];?>">
									<div class="colorbox b6_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                                    echo $window['window_color']; ?>;border: 10px solid <?php                     
                                    $floor_color=$domenia3n->get_b6_colorset($layoutline[$i]['set_colors']);
                                    echo $floor_color['cl1_floor'];?>">
									</div>
								</a>					
								<?php							
							}
							?>
						</div>
						<input type="hidden" name="b6_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
					</div>
				</div> <!-- end row -->
                <?php
			
			
			// if(count($b6_in_products)>0)
			// {
				
			?>
            <div class="row form-inline w-100 mx-0">
				<div class="col-md-12">
					<b>Employee-Producer: Col IN B6 = </b>
					<input type="text" class="form-control form-control-sm" name="col_labc_in_b6" id="col_labc_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_labc_in_b6']))?$o_desc_in_b6['col_labc_in_b6']:"0";?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b6 = </b>
					<input type="text" class="form-control form-control-sm" name="fac_labc_in_b6" id="fac_labc_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_labc_in_b6']))?$o_desc_in_b6['fac_labc_in_b6']:"1";?>" form="order_details" style="width:5em"> 
					<b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b6" id="col_amount3_in_b6" form="order_details" value="<?php echo (!empty($o_desc_in_b6['col_amount_in_b6']))?$o_desc_in_b6['col_amount_in_b6']:"1";?>" style="width:5em" >
					<b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b6" id="total_labcs_in_b6" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
				</div>
			</div>
			<div class="row form-inline w-100 mx-0">
				<div class="col-md-12">
					<b>Producer-Trader: Col IN B6 = </b>
					<input type="text" class="form-control form-control-sm" name="col_apus_in_b6" id="col_apus_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_apus_in_b6']))?$o_desc_in_b6['col_apus_in_b6']:"0";?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b6 = </b>
					<input type="text" class="form-control form-control-sm" name="fac_prod_in_b6" id="fac_prod_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_prod_in_b6']))?$o_desc_in_b6['fac_prod_in_b6']:"1";?>" form="order_details" style="width:5em"> 
					<b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b6" id="col_amount2_in_b6" form="order_details" value="<?php echo (!empty($o_desc_in_b6['col_amount_in_b6']))?$o_desc_in_b6['col_amount_in_b6']:"1";?>" style="width:5em" >
					<b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b6" id="o_apus_in_b6" value="<?php echo $o_desc_in_b6['o_apus_in_b6'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
				</div>
			</div>			
			<div class="row form-inline w-100 mx-0 my-1">
				<div class="col-md-12 d-flex justify-content-center">
					<b>Trader-Purchaser: Col IN B6 = </b>
					<input class="form-control form-control-sm" type="text" name="col_price_in_b6" id="col_price_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_price_in_b6']))?$o_desc_in_b6['col_price_in_b6']:"0";?>" form="order_details" style="width:5em"> 
					<b><?php echo $currency; ?> X fac_client_in_b6 = </b> 
					<input type="text" class="form-control form-control-sm" name="fac_cl_in_b6" id="fac_cl_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_cl_in_b6']))?$o_desc_in_b6['fac_cl_in_b6']:"1";?>" form="order_details" style="width:5em"> 
					<b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b6" id="col_amount1_in_b6" form="order_details" value="<?php echo (!empty($o_desc_in_b6['col_amount_in_b6']))?$o_desc_in_b6['col_amount_in_b6']:"1";?>" style="width:5em" > 
					<b>=</b> 
					<input type="text" class="form-control form-control-sm" name="o_price_in_b6" id="o_price_in_b6" value="<?php echo (!empty($o_desc_in_b6['o_price_in_b6']))?$o_desc_in_b6['o_price_in_b6']:"0";?>" form="order_details" style="width:5em">
					<b><?php echo $currency; ?></b>			
					<br><br>
				</div>
			</div>
				<br>
				</div> <!-- end col-md-12 -->
                    
                <?php
            
			//}
        } 
            ?>
            <div class="row mx-0 w-100 justify-content-center pt-3" id="b7intopen" style="background-color:#5c5c2f;">
                <!-- <p class="d-inline">This client has not chosen a b7 interior product. </p> -->
                <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb7" data-toggle="collapse" id="b7intbtnopen">B7 interior - 3ds Max</button></p>
            </div>
            <script type="text/javascript">
                $('#b7intbtnopen').click(function(){
                    setTimeout(function(){$('#b7intopen').css('display','')},1000);
                });
            </script>
            <?php
			//start b7 in
			
			if(count($b7_in_products)>0)
			{
                ?>
                
                <?php
                if(!empty($o_desc_in_b7['layout_id']))
                {
				    $layout_id=$o_desc_in_b7['layout_id'];
                }
                else
                {
                    $layout_id="";
                }
                if(!empty($o_desc_in_b7['window_id']))
                {
                    $window_id=$o_desc_in_b7['window_id'];
                }
                else
                {
                    $window_id="";
                }
				?>	
				<div class="col-md-12 collapse <?php
                if (strpos($order['collection'], 'p1701') !== false) 
                {
                    echo "show";
                }?>" id="interiorb7" style="background-color:#5c5c2f;">
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b7_in_products[$i],$cur_factor);
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
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                
                                for($j=0;$j<count($collection);$j++)
                                {
                                    
                                    if($b7_in_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout";
                                        
                                    }
                                    
                                }							
                                ?>">
                                    <input class="products product_in_b7 checkbox mx-2" type="checkbox" name="<?php echo $b7_in_products[$i]; ?>" id="<?php echo $b7_in_products[$i]; ?>" value="<?php echo $b7_in_products[$i]; ?>" <?php 
                                        
                                        for($j=0;$j<count($collection);$j++)
                                        {
                                            
                                            if($b7_in_products[$i]==$collection[$j])
                                            {
                                                echo "checked";
                                                
                                            }
                                            
                                        }							
                                        ?>> 
                                    <label for="<?php echo $b7_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                    //echo $product_price." ".$currency;
                                    echo $product_apu." APE"; 
                                    ?></label>					

                                    <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                                    <?php
                                    // if(($b7_in_products[$i]=="p1700")||($b7_in_products[$i]=="p1701")||($b7_in_products[$i]=="p1704")||($b7_in_products[$i]=="p1706")||($b7_in_products[$i]=="p1721")||($b7_in_products[$i]=="p1724")||($b7_in_products[$i]=="p1726")||($b7_in_products[$i]=="p1741")||($b7_in_products[$i]=="p1744")||($b7_in_products[$i]=="p1746"))
                                    // {
                                    ?>
                                    <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b7_in_multiplicator" form="order_details" id="<?php echo $b7_in_products[$i]; ?>_fac" name="<?php echo $b7_in_products[$i]; ?>_fac" value="<?php echo (!empty($o_desc_in_b7[$b7_in_products[$i]."_fac"]))?$o_desc_in_b7[$b7_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                    <?php
                                    //}
                                    ?>
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
                            <div id="b7_nav" class="nav nav-inline">
                                <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                                <?php $layout=$domenia->get_layout2($layout_id); 
                                        
                                $layoutline=$domenia->get_layouts_by_quality_id2("b7");
                                
                                for($i=0;$i<count($layoutline);$i++)
                                {
                                    ?>
                                    <a href="#b7_layouts" class="nav-item <?php
                                    if($layout_id==$layoutline[$i]['l_id'])
                                    {
                                        echo "active-layoutline";
                                    }
                                    ?>" title="<?php echo $layoutline[$i]['l_id'];?>">
                                        <div class="colorbox b7_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                                        echo $window['window_color']; ?>;border: 10px solid <?php 
                                        $floor_color=$domenia3n->get_b7_colorset($layoutline[$i]['set_colors']);
                                        echo $floor_color['cl1_floor'];?>">
                                        </div>
                                    </a>					
                                    <?php							
                                }
                                ?>
                            </div>
                            <input type="hidden" name="b7_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
                        </div>
                    </div> <!-- end row -->
                    <br>
                    
                    <?php
                
                ?>                
                <br>	    
                <?php
                	
                // if(count($b7_in_products)>0)
                // {
                    
                ?>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12">
                        <b>Employee-Producer: Col IN B7 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_in_b7" id="col_labc_in_b7" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b7 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_in_b7" id="fac_labc_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_labc_in_b7']))?$o_desc_in_b7['fac_labc_in_b7']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b7" id="col_amount3_in_b7" form="order_details" value="<?php echo $o_desc_in_b7['col_amount_in_b7'];/*echo (!empty($o_desc_in_b7['col_amount_in_b7']))?$o_desc_in_b7['col_amount_in_b7']:"1";*/?>" style="width:5em" >
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b7" id="total_labcs_in_b7" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12">
                        <b>Producer-Trader: Col IN B7 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_in_b7" id="col_apus_in_b7" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b7 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_in_b7" id="fac_prod_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_prod_in_b7']))?$o_desc_in_b7['fac_prod_in_b7']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b7" id="col_amount2_in_b7" form="order_details" value="<?php echo $o_desc_in_b7['col_amount_in_b7']; /*echo (!empty($o_desc_in_b7['col_amount_in_b7']))?$o_desc_in_b7['col_amount_in_b7']:"1";*/?>" style="width:5em" >
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b7" id="o_apus_in_b7" value="<?php echo $o_desc_in_b7['o_apus_in_b7'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline w-100 mx-0 mt-2">
                    <div class="col-md-12">
                        <b>Trader-Purchaser: Col IN B7 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_in_b7" id="col_price_in_b7" value="" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_in_b7 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_in_b7" id="fac_cl_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_cl_in_b7']))?$o_desc_in_b7['fac_cl_in_b7']:"1";?>" form="order_details" style="width:5em"> 
                        <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b7" id="col_amount1_in_b7" form="order_details" value="<?php echo $o_desc_in_b7['col_amount_in_b7'];/* echo (!empty($o_desc_in_b7['col_amount_in_b7']))?$o_desc_in_b7['col_amount_in_b7']:"1";*/?>" style="width:5em" > 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_in_b7" id="o_price_in_b7" value="" form="order_details" style="width:5em">
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
            </div> <!-- end col-md-12 -->
                <?php
        }           

            ?>
            <div class="row mx-0 w-100 justify-content-center pt-3" id="b8intopen" style="background-color:#a3a373;">
                <!-- <p class="d-inline">This client has not chosen a b7 interior product. </p> -->
                <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb8" data-toggle="collapse" id="b8intbtnopen">B8 interior - Lumion</button></p>
            </div>
            <?php
            //start b8 in
			
			if(count($b8_in_products)>0)
			{
                ?>
                
                <?php
				$layout_id=$o_desc_in_b8['layout_id'];
				$window_id=$o_desc_in_b8['window_id'];
				?>	
                <div class="col-md-12 collapse <?php
                    if (strpos($order['collection'], 'p1801') !== false) 
                    {
                        echo "show";
                    }?>" id="interiorb8" style="background-color:#a3a373;">
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
                                    $product_price=$prod->calculateProductPrice($order['ls_id'],$b8_in_products[$i],$cur_factor);
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
                                <div class="row w-100 mx-0 my-1">					
                                    <div class="<?php 
                                    
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        
                                        if($b8_in_products[$i]==$collection[$j])
                                        {
                                            echo "active_layout";
                                            
                                        }
                                        
                                    }							
                                    ?>">
                                        <input class="products product_in_b8 checkbox mx-2" type="checkbox" name="<?php echo $b8_in_products[$i]; ?>" id="<?php echo $b8_in_products[$i]; ?>" value="<?php echo $b8_in_products[$i]; ?>" <?php 
                                            
                                            for($j=0;$j<count($collection);$j++)
                                            {
                                                
                                                if($b8_in_products[$i]==$collection[$j])
                                                {
                                                    echo "checked";
                                                    
                                                }
                                                
                                            }							
                                            ?>> 
                                        <label for="<?php echo $b8_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                        //echo $product_price." ".$currency; 
                                        echo $product_apu." APE";
                                        ?></label>					

                                        <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                        <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                        <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                                        <?php
                                        // if(($b8_in_products[$i]=="p1800")||($b8_in_products[$i]=="p1801")||($b8_in_products[$i]=="p1804")||($b8_in_products[$i]=="p1806")||($b8_in_products[$i]=="p1821")||($b8_in_products[$i]=="p1824")||($b8_in_products[$i]=="p1826")||($b8_in_products[$i]=="p1841")||($b8_in_products[$i]=="p1844")||($b8_in_products[$i]=="p1846"))
                                        // {
                                        ?>
                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b8_in_multiplicator" form="order_details" id="<?php echo $b8_in_products[$i]; ?>_fac" name="<?php echo $b8_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b8[$b8_in_products[$i]."_fac"]!=0)?$o_desc_in_b8[$b8_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                        <?php
                                        //}
                                        ?>
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
                                <div id="b8_nav" class="nav nav-inline">
                                    <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                                    <?php $layout=$domenia->get_layout2($layout_id); 
                                            
                                    $layoutline=$domenia->get_layouts_by_quality_id2("b8");
                                    
                                    for($i=0;$i<count($layoutline);$i++)
                                    {
                                        ?>
                                        <a href="#b8_layouts" class="nav-item <?php
                                        if($layout_id==$layoutline[$i]['l_id'])
                                        {
                                            echo "active-layoutline";
                                        }
                                        ?>" title="<?php echo $layoutline[$i]['l_id'];?>">
                                            <div class="colorbox b8_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                                            echo $window['window_color']; ?>;border: 10px solid <?php 
                                            $floor_color=$domenia3n->get_b8_colorset($layoutline[$i]['set_colors']);
                                            echo $floor_color['cl1_floor'];?>">
                                            </div>
                                        </a>					
                                        <?php							
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="b8_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
                            </div>
                        </div> <!-- end row -->
                        <br>
                        
                        <?php
                    
                    ?>
                    
                    <br>	
                
                    <?php
                        
                    // if(count($b8_in_products)>0)
                    // {
                        
                    ?>
                    <div class="row form-inline w-100 mx-0">
                        <div class="col-md-12">
                            <b>Employee-Producer: Col IN B8 = </b>
                            <input type="text" class="form-control form-control-sm" name="col_labc_in_b8" id="col_labc_in_b8" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b8 = </b>
                            <input type="text" class="form-control form-control-sm" name="fac_labc_in_b8" id="fac_labc_in_b8" value="<?php echo $o_desc_in_b8['fac_labc_in_b8'];?>" form="order_details" style="width:5em"> 
                            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b8" id="col_amount3_in_b8" form="order_details" value="<?php echo $o_desc_in_b8['col_amount_in_b8'];/*echo (!empty($o_desc_in_b8['col_amount_in_b8']))?$o_desc_in_b8['col_amount_in_b8']:"1";*/?>" style="width:5em" >
                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b8" id="total_labcs_in_b8" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                        </div>
                    </div>
                    
                    <div class="row form-inline w-100 mx-0">
                        <div class="col-md-12">
                            <b>Producer-Trader: Col IN B8 = </b>
                            <input type="text" class="form-control form-control-sm" name="col_apus_in_b8" id="col_apus_in_b8" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b8 = </b>
                            <input type="text" class="form-control form-control-sm" name="fac_prod_in_b8" id="fac_prod_in_b8" value="<?php echo $o_desc_in_b8['fac_prod_in_b8'];/*echo (!empty($o_desc_in_b8['fac_prod_in_b8']))?$o_desc_in_b8['fac_prod_in_b8']:"1";*/?>" form="order_details" style="width:5em"> 
                            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b8" id="col_amount2_in_b8" form="order_details" value="<?php echo $o_desc_in_b8['col_amount_in_b8']; /*echo (!empty($o_desc_in_b8['col_amount_in_b8']))?$o_desc_in_b8['col_amount_in_b8']:"1";*/?>" style="width:5em" >
                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b8" id="o_apus_in_b8" value="<?php echo $o_desc_in_b8['o_apus_in_b8'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
                        </div>
                    </div>			
                    <div class="row form-inline w-100 mx-0 mt-2">
                        <div class="col-md-12">
                            <b>Trader-Purchaser: Col IN B8 = </b>
                            <input class="form-control form-control-sm" type="text" name="col_price_in_b8" id="col_price_in_b8" value="" form="order_details" style="width:5em"> 
                            <b><?php echo $currency; ?> X fac_client_in_b8 = </b> 
                            <input type="text" class="form-control form-control-sm" name="fac_cl_in_b8" id="fac_cl_in_b8" value="<?php echo $o_desc_in_b8['fac_cl_in_b8'];/*echo (!empty($o_desc_in_b8['fac_cl_in_b8']))?$o_desc_in_b8['fac_cl_in_b8']:"1";*/?>" form="order_details" style="width:5em"> 
                            <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b8" id="col_amount1_in_b8" form="order_details" value="<?php echo $o_desc_in_b8['col_amount_in_b8'];/* echo (!empty($o_desc_in_b8['col_amount_in_b8']))?$o_desc_in_b8['col_amount_in_b8']:"1";*/?>" style="width:5em" > 
                            <b>=</b> 
                            <input type="text" class="form-control form-control-sm" name="o_price_in_b8" id="o_price_in_b8" value="" form="order_details" style="width:5em">
                            <b><?php echo $currency; ?></b>			
                            <br><br>
                        </div>
                    </div>
                </div> <!-- end col-md-12 -->
                <?php
            }
            ?>

                <div class="row w-100 mx-0 pb-5">
                    <div class="col-md-6">
                        <p><b>Customer remarks interior : </b></p>
                        <textarea name="customer_remarks" class="form-control form-control-sm d-inline" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['clients-extras']); ?></textarea>
                    </div>		
                    <div class="col-md-6">
                        <p><b>Operator remarks interior: </b></p>
                        <textarea name="op_remarks" class="form-control form-control-sm d-inline" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['op-remarks']); ?></textarea>
                    </div>	
                </div>
                <?php

}
else
{
    $b1_in_products=array();
    $b1_ex_products=array();

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
        if((substr($ls_prods[$i],1)>1100)&&(substr($ls_prods[$i],1)<1160))
        {
            if(!empty($ls_prods[$i]))
            {
            $b1_in_products[]=$ls_prods[$i];
            }
        }

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
        
        if(($ls_prods[$i]=="p1163")||($ls_prods[$i]=="p1166")||($ls_prods[$i]=="p1168")||($ls_prods[$i]=="p116b")||
        ($ls_prods[$i]=="p116m")||($ls_prods[$i]=="p116t")||($ls_prods[$i]=="p118s")&&
        ((substr($ls_prods[$i], -2) !="gb")||(substr($ls_prods[$i], -2) !="gm")||
        (substr($ls_prods[$i], -2) != "gt")||(substr($ls_prods[$i], -2) !="gs")
        )
        )
        {
            if(!empty($ls_prods[$i]))
            {
            $b1_ex_products[]=$ls_prods[$i];
            }
        }

        if((substr($ls_prods[$i],1)>1560)&&(substr($ls_prods[$i],1)<1600)||($ls_prods[$i]=="p156x")||($ls_prods[$i]=="p156z")||($ls_prods[$i]=="p156y")||($ls_prods[$i]=="p158s"))
        {
            if(!empty($ls_prods[$i]))
            {
            $b5_ex_products[]=$ls_prods[$i];
            }
        }
       
        if((substr($ls_prods[$i],1)>=1600)&&(substr($ls_prods[$i],1)<1660))
        {
            if(!empty($ls_prods[$i]))
            {
                
            $b6_in_products[]=$ls_prods[$i];
            }
        }
        
        if((substr($ls_prods[$i],1)>1660)&&(substr($ls_prods[$i],1)<1700)||($ls_prods[$i]=="p166x")||($ls_prods[$i]=="p166z")||($ls_prods[$i]=="p166y")||($ls_prods[$i]=="p168s")||($ls_prods[$i]=="p166p"))
        {
            if(!empty($ls_prods[$i]))
            {
            $b6_ex_products[]=$ls_prods[$i];
            }
        }
        
        if((substr($ls_prods[$i],1)>=1700)&&(substr($ls_prods[$i],1)<1760))
        {
            if(!empty($ls_prods[$i]))
            {
            $b7_in_products[]=$ls_prods[$i];
            }
        }
        
        if((substr($ls_prods[$i],1)>=1800)&&(substr($ls_prods[$i],1)<1860))
        {
            if(!empty($ls_prods[$i]))
            {
            $b8_in_products[]=$ls_prods[$i];
            }
        }
        
        if((substr($ls_prods[$i],1)>1760)&&(substr($ls_prods[$i],1)<1800)||($ls_prods[$i]=="p176x")||($ls_prods[$i]=="p176z")||($ls_prods[$i]=="p176y"))
        {
            if(!empty($ls_prods[$i]))
            {
            $b7_ex_products[]=$ls_prods[$i];
            }
        }
        
        if((substr($ls_prods[$i],1)>1860)&&(substr($ls_prods[$i],1)<1900)||($ls_prods[$i]=="p186x")||($ls_prods[$i]=="p186z")||($ls_prods[$i]=="p186y"))
        {
            if(!empty($ls_prods[$i]))
            {
            $b8_ex_products[]=$ls_prods[$i];
            }
        }
    }
    
    $interior=0;
        
    if(count($b1_in_products)>0)
    {
        $interior++;
    }

    if(count($b3_in_products)>0)
    {
        $interior++;
    }
    if(count($b5_in_products)>0)
    {
        $interior++;
    }
    if(count($b6_in_products)>0)
    {
        $interior++;
    }
    if(count($b7_in_products)>0)
    {
        $interior++;
    }
    
    if(count($b8_in_products)>0)
    {
        $interior++;
    }
?>
<div class="row">
    <div class="col-md-12">						
        <div class="error">No Interior</div>						
    </div>
</div>
<div class="interior" style="box-shadow: none;">
<div class="row w-100 mx-0 pt-4">
        <div class="col-md-1">
            <h5 class="text-success w-100 text-center">Interior</h5>
        </div>
        <div class="col-md-1">
            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb1" data-target="#interiorb1" data-toggle="collapse">B1 interior</button>
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
                <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="inbtnb5" data-target="#interiorb5" data-toggle="collapse"><del>B5 interior - Skp/V-Ray</del></button>
                <span class="text-danger">Not for this website</span>
                <?php
            }
            else
            {
        ?>
            <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb5" data-target="#interiorb5" data-toggle="collapse">B5 interior - Skp/V-Ray</button>
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
            <span class="text-danger">Not for this website</span>
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
            <span class="text-danger">Not for this website</span>
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
            <span class="text-danger">Not for this website</span>
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
<hr width="300px" class="bg-secondary">
    <div class="row w-100 mx-0">
        <div class="col-md-4 d-flex justify-content-center">
        <div class="form-inline"><b class="mr-2">Amount of interior subIDs : </b><input type="text" class="form-control form-control-sm" name="col_amount0" id="col_amount0" form="order_details" value="<?php 						
            // if(!isset($_COOKIE['col_amount0']))
            // {
                echo "1";
            // }						
            // else
            // {
            //     echo $_COOKIE['col_amount0'];
            // }
            ?>" style="width:5em"></div>
        </div>
        <!--<div class="col-md-4 d-flex justify-content-center">
            <div class="row">
                <div class="col-md-12 text-center">
                    <b>Interior sub names</b>
                </div>
            </div>
        </div> -->
    </div> <!-- end row -->
    <div class="row w-100 mx-0">
        <script type="text/javascript">
        $(document).ready(function(){

            $.ajax({
                url: "../ajax/create_orders_subnames_interior_html.php",
                method: "post",
                data: {o_id:<?php echo $o_id;?>,total_interior_amount:$('#col_amount0').val()},
                dataType:"html",
                success:function(data) {
                    $('#interior_osn_texts').html(data);										
                }
            });

        });

        $('#col_amount0').on('change focusout',function(){

            $.ajax({
                url: "../ajax/create_orders_subnames_interior_html.php",
                method: "post",
                data: {o_id:<?php echo $o_id;?>,total_interior_amount:$('#col_amount0').val()},
                dataType:"html",
                success:function(data) {
                    $('#interior_osn_texts').html(data);										
                }
            });

        });
    </script>
    <div class="col-md-12 justify-content-center">
        <div class="row">
            <div class="col-md-12 d-inline" id="interior_osn_texts">
                <?php
            $all_subids=$prod->get_all_subids_by_o_id($o_id);

                for($i=0;$i<count($all_subids);$i++)
                {
                    if (strpos($all_subids[$i]['o_sub_id'], 'n') !== false) 
                    {
                        ?>
                        <div id="row_subname<?php echo $all_subids[$i]['subo_id'];?>" class="row">
                            
                            <div class="col-md-2">
                            <?php
                            echo $all_subids[$i]['o_sub_id']."&nbsp;";
                            ?>
                            </div>
                        <div class="col-md-2">
                    <input type="text" list="interior_subid_list<?php echo $all_subids[$i]['subo_id'];?>" id="subo_id<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" value="<?php echo $all_subids[$i]['subo_name'];?>" placeholder="Name" class="form-control form-control-sm">
                    <datalist id="interior_subid_list<?php echo $all_subids[$i]['subo_id'];?>">
                        <option value="Grundrisse">
                        <option value="Innen">
                    </datalist>
                    <script type="text/javascript">
                    

                    $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                            method: "get",
                            data: {
                                subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                interior_subname:$(this).val(),
                                option:"rename_interior_osn_file"},
                            dataType:"html",
                            success:function(data) {
                                console.log(data);										
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                console.log(xhr.status);
                                console.log(thrownError);
                            }
                            
                        }); 
                    });
                    </script>
                        </div>
                        
                        <div class="col-md-2">
                            <select id="object_type<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="form-control form-control-sm">
                                <option value="">--Object type--</option>
                                <?php
                                $all_object_types=$prod->get_all_object_types();
                                for($o=0;$o<count($all_object_types);$o++)
                                {
                                    ?>
                                    <option value="<?php echo $all_object_types[$o]['ot_id'];?>" <?php echo ($all_object_types[$o]['ot_id']==$all_subids[$i]['object_type'])?"seelected":"";?>><?php echo $all_object_types[$o]['ot_description'];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $('#object_type<?php echo $all_subids[$i]['subo_id'];?>').on('change',function(){
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                    method: "get",
                                    data: {
                                        subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                        object_type:$(this).val(),
                                        option:"change_object_type"},
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);										
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                    
                                }); 
                            });
                            </script>
                        </div>
                        <div class="col-md-2">
                            <?php /* <div class="form-inline">
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
                            <?php */
                            $stairs=$domenia3n->get_all_stairs();
                            
                            ?>
                            <select id="st_id0" name="st_id0" class="form-control form-control-sm" form="order_details">
                                <option value="">--Stairs--</option>
                                <?php
                                for($s=0;$s<count($stairs);$s++)
                                {							
                                ?>
                                <option value="<?php echo $stairs[$s]['st_id']?>"><?php echo $stairs[$s]['st_name'];?></option>
                                <?php								
                                }
                                ?>
                            </select><!-- <img src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/256/sign-question-icon.png" width="40"> -->
                            
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo $base_url;?>rooms/index.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $all_subids[$i]['o_sub_id']?>" class="btn btn-sm btn-success" target="_blank" >(0)Edit or create</a>
                        </div>
                        <div class="col-md-2">
                            <textarea class="form-control form-control-sm" id="subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" placeholder="Explanation" style="height: 30px;"><?php 
                            echo $all_subids[$i]['subo_more_infos'];?></textarea>
                            <script type="text/javascript">
                            $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_orders_subnames_more_infos.php",
                                    method: "get",
                                    data: {
                                        subo_id: $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                        interior_subo_more_infos:$(this).val(),
                                        option:"rename_interior_more_infos"
                                    },
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);										
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                    
                                }); 
                            });
                        </script>
                        </div>
                        <div class="col-md-1">
                        <button type="button" id="del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="btn btn-sm btn-danger">X</button>
                        <script type="text/javascript">
                        $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').click(function(){
                            if(confirm('Are you sure want to delete ?'))
                            {
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/delete_orders_subnames.php",
                                    method: "post",
                                    data: {
                                        subo_id: $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                        },
                                    dataType:"html",
                                    success:function(data) {
                                        $('#row_subname<?php echo $all_subids[$i]['subo_id'];?>').fadeOut(3000);										
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
                }
                ?>                              
            </div>
            
        </div>
    </div>
    </div>
    <hr>
<?php
if(count($b1_in_products)>0)
{
    $o_desc_in_b1=$prod->get_o_desc_in_b1($o_id);
        ?>
        <div class="col-md-12 px-0 collapse <?php
        if((strpos($order['collection'], 'p1103') !== false)||(strpos($order['collection'], 'p1104') !== false))
        {
            echo "show";
        }?>" id="interiorb1" style="background-color:#eeeec3">
        <div class="row w-100 mx-0">
            <div class="col-md-12">
            Amount of floorplans <input type="text">
            </div>
        </div>
        <div class="row w-100 mx-0">
        <?php
        $b1_in_lines=ceil(count($b1_in_products) / $columns);
        $counter=1;
        for($i=0;$i<count($b1_in_products);$i++)
        {
            if(!empty($b1_in_products[$i]))
            {
                $product=$prod->get_product($b1_in_products[$i]);
                if(!empty($budget))
                {
                    if(count($budget)>0)
                    {
                        $product_price=$prod->calculateProductAPU($b1_in_products[$i]);
                    }
                    
                }
                else
                {
                    $product_price=$prod->calculateProductPrice($order['ls_id'],$b1_in_products[$i],$cur_factor);
                }
                $product_apu=$prod->calculateProductAPU($b1_in_products[$i]);
                $product_labc=$prod->calculateProductlabc($b1_in_products[$i]);
                
                if($counter==1)
                {
                    ?>
                    <div class="col-md-4">
                    <?php
                }
                ?>
                <div class="row w-100 mx-0 my-1">					
                    <div class="<?php 
                    for($j=0;$j<count($collection);$j++)
                    {
                        if($b1_in_products[$i]==$collection[$j])
                        {
                            echo "active_layout"; 
                        }
                    }							
                    ?>">
                        <input class="products product_in_b1 checkbox" type="checkbox" name="<?php echo $b1_in_products[$i]; ?>" id="<?php echo $b1_in_products[$i]; ?>" value="<?php echo $b1_in_products[$i]; ?>" <?php 
                        for($j=0;$j<count($collection);$j++)
                        {
                            if($b1_in_products[$i]==$collection[$j])
                            {
                                echo "checked";
                            }
                        }							
                        ?>> 
                        <label for="<?php echo $b1_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                        //echo $product_price." ".$currency; 
                        echo $product_apu." APE";?></label>					

                        <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                        <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                        <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

                        <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_price" name="product_<?php echo $b1_in_products[$i];?>_price" class="<?php 
                    for($j=0;$j<count($collection);$j++)
                    {
                        if($b1_in_products[$i]==$collection[$j])
                        {
                            echo "prices_in_b1";
                        }
                    }
                    ?>" value="<?php echo $product_price; ?>">
                        <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_apu" name="product_<?php echo $b1_in_products[$i];?>_apu" class="<?php 
                    for($j=0;$j<count($collection);$j++)
                    {
                        if($b1_in_products[$i]==$collection[$j])
                        {
                            echo "apus_in_b1";
                        }
                    }
                    ?>" value="<?php echo $product_apu; ?>">
                        <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_labc" name="product_<?php echo $b1_in_products[$i];?>_labc" class="<?php 
                    for($j=0;$j<count($collection);$j++)
                    {
                        if($b1_in_products[$i]==$collection[$j])
                        {
                            echo "labcs_in_b1";
                        }
                    }
                    ?>" value="<?php echo $product_labc; ?>"> 

                    <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b1_in_multiplicator" form="order_details" id="<?php echo $b1_in_products[$i]; ?>_fac" name="<?php echo $b1_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b1[$b1_in_products[$i]."_fac"]!=0)?$o_desc_in_b1[$b1_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">

                    </div>						
                </div>	
                <?php
                if(($counter%$b1_in_lines==0)&&($counter>0))
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
        <div class="row w-100 mx-0 pt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <p class="d-inline mb-0">
                        <b>Shapeline</b>
                    </p>
                    <select name="sl_id" id="sl_id" class="form-control form-control-sm d-inline" form="order_details" style="width:200px;">
                    <option value="">None</option>
                <?php 
                //$all_b1_shapes=$domenia3n->get_all_b1_shapes();
                if(!empty($all_b1_shapes))
                {
                    for($i=0;$i<count($all_b1_shapes);$i++)
                    {
                    ?>
                    <option value="<?php echo $all_b1_shapes[$i]['sl_id'];?>" <?php echo ($all_b1_shapes[$i]['sl_id']==$o_desc_in_b3['sl_id'])?"selected":"";?>><?php echo $all_b1_shapes[$i]['sl_id']." - ".$all_b1_shapes[$i]['sl_name'];?></option>
                    <?php
                    }
                }
                ?>
                </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <p class="d-inline mb-0">
                        <b>Colorset</b>
                    </p>
                        <select name="cls_id" id="cls_id" class="form-control form-control-sm d-inline" form="order_details" style="width:200px;">
                            <option value="">None</option>
                        <?php 
                        
                        //$all_b1_colorset=$domenia3n->get_all_b1_colorsets();
                        if(!empty($all_b1_colorset))
                        {
                            for($i=0;$i<count($all_b1_colorset);$i++)
                            {
                            ?>
                            <option value="<?php echo $all_b1_colorset[$i]['cls_id'];?>" <?php echo ($all_b1_colorset[$i]['cls_id']==$o_desc_in_b3['cls_id'])?"selected":"";?>><?php echo $all_b1_colorset[$i]['cls_id']." - ".$all_b1_colorset[$i]['cls_name'];?></option>
                            <?php
                            }
                        }
                        ?>
                        </select>
                    
                </div>
            </div>
        </div>
        
        <br>
        
        <div class="row form-inline">
            <div class="col-md-12">
                <b>Employee-Producer: Col IN B1 = </b>
                <input type="text" class="form-control form-control-sm" name="col_labc_in_b1" id="col_labc_in_b1" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b1 = </b>
                <input type="text" class="form-control form-control-sm" name="fac_labc_in_b1" id="fac_labc_in_b1" value="<?php echo $o_desc_in_b1['fac_labc_in_b1'];/*echo (!empty($o_desc_in_b1['fac_labc_in_b1']))?$o_desc_in_b1['fac_labc_in_b1']:"1";*/?>" form="order_details" style="width:5em"> 
                <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b1" id="col_amount3_in_b1" form="order_details" value="<?php echo $o_desc_in_b1['col_amount_in_b1'];/*echo (!empty($o_desc_in_b1['col_amount_in_b1']))?$o_desc_in_b1['col_amount_in_b1']:"1";*/?>" style="width:5em" >
                <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b1" id="total_labcs_in_b1" value="<?php echo $o_desc_in_b1['total_labcs_in_b1'];?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
            </div>
        </div>
        <div class="row form-inline">
            <div class="col-md-12">
                <b>Producer-Trader: Col IN B1 = </b>
                <input type="text" class="form-control form-control-sm" name="col_apus_in_b1" id="col_apus_in_b1" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b1 = </b>
                <input type="text" class="form-control form-control-sm" name="fac_prod_in_b1" id="fac_prod_in_b1" value="<?php echo $o_desc_in_b1['fac_prod_in_b1']; /*echo (!empty($o_desc_in_b1['fac_prod_in_b1']))?$o_desc_in_b1['fac_prod_in_b1']:"1";*/?>" form="order_details" style="width:5em"> 
                <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b1" id="col_amount2_in_b1" form="order_details" value="<?php echo $o_desc_in_b1['col_amount_in_b1']; /*echo (!empty($o_desc_in_b1['col_amount_in_b1']))?$o_desc_in_b1['col_amount_in_b1']:"1";*/?>" style="width:5em" >
                <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b1" id="o_apus_in_b1" value="<?php echo $o_desc_in_b1['o_apus_in_b1'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
            </div>
        </div>			
        <div class="row form-inline">
            <div class="col-md-12">
                <b>Trader-Purchaser: Col IN B1 = </b>
                <input class="form-control form-control-sm" type="text" name="col_price_in_b1" id="col_price_in_b1" value="" form="order_details" style="width:5em"> 
                <b><?php echo $currency; ?> X fac_client_in_b1 = </b> 
                <input type="text" class="form-control form-control-sm" name="fac_cl_in_b1" id="fac_cl_in_b1" value="<?php echo $o_desc_in_b1['fac_cl_in_b1']; /*echo (!empty($o_desc_in_b1['fac_cl_in_b1']))?$o_desc_in_b1['fac_cl_in_b1']:"1";*/?>" form="order_details" style="width:5em"> 
                <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b1" id="col_amount1_in_b1" form="order_details" value="<?php echo $o_desc_in_b1['col_amount_in_b1']; /*echo (!empty($o_desc_in_b1['col_amount_in_b1']))?$o_desc_in_b1['col_amount_in_b1']:"1";*/?>" style="width:5em" > 
                <b>=</b> 
                <input type="text" class="form-control form-control-sm" name="o_price_in_b1" id="o_price_in_b1" value="<?php echo (!empty($o_desc_in_b1['o_price_in_b1']))?$o_desc_in_b1['o_price_in_b1']:"0";?>" form="order_details" style="width:5em">
                <b><?php echo $currency; ?></b>			
                <br><br>
            </div>
        </div>
        
        <br>
        <hr style="border:2px solid brown;">              
               
        </div>		

<br>

<?php	
}
?>
    <div class="row mx-0 w-100 justify-content-center pt-3" id="b3intopen" style="display: ;">
        <!--<p class="d-inline">This client has not chosen a b3 interior product. </p> -->
        <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb3" data-toggle="collapse" id="b3intbtnopen">B3 interior - Corel</button></p>
    </div>
<?php
if(count($b3_in_products)>0)
{
        
        ?>
        <div class="col-md-12 px-0 collapse <?php
        if (strpos($order['collection'], 'p1301') !== false) 
        {
            echo "show";
        }?>" id="interiorb3" style="background-color:#eeeec3">
        <div class="row w-100 mx-0">
            <div class="col-md-12">
            Amount of floorplans <input type="text">
            </div>
        </div>
        <div class="row w-100 mx-0">
        <?php
        $b3_in_lines=ceil(count($b3_in_products) / $columns);
        $counter=1;
        for($i=0;$i<count($b3_in_products);$i++)
        {
            if(!empty($b3_in_products[$i]))
            {
                $product=$prod->get_product($b3_in_products[$i]);
                if(!empty($budget))
                {
                    if(count($budget)>0)
                    {
                        $product_price=$prod->calculateProductAPU($b3_in_products[$i]);
                    }
                    
                }
                else
                {
                    $product_price=$prod->calculateProductPrice($order['ls_id'],$b3_in_products[$i],$cur_factor);
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
                <div class="row w-100 mx-0 my-1">					
                    <div class="<?php 
                    for($j=0;$j<count($collection);$j++)
                    {
                        if($b3_in_products[$i]==$collection[$j])
                        {
                            echo "active_layout"; 
                        }
                    }							
                    ?>">
                        <input class="products product_in_b3 checkbox" type="checkbox" name="<?php echo $b3_in_products[$i]; ?>" id="<?php echo $b3_in_products[$i]; ?>" value="<?php echo $b3_in_products[$i]; ?>" <?php 
                        for($j=0;$j<count($collection);$j++)
                        {
                            if($b3_in_products[$i]==$collection[$j])
                            {
                                echo "checked";
                            }
                        }							
                        ?>> 
                        <label for="<?php echo $b3_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                        //echo $product_price." ".$currency; 
                        echo $product_apu." APE";?></label>					

                        <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                        <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                        <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
        <div class="row w-100 mx-0 pt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <p class="d-inline mb-0">
                        <b>Shapeline</b>
                    </p>
                    <select name="sl_id" id="sl_id" class="form-control form-control-sm d-inline" form="order_details" style="width:200px;">
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
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <p class="d-inline mb-0">
                        <b>Colorset</b>
                    </p>
                        <select name="cls_id" id="cls_id" class="form-control form-control-sm d-inline" form="order_details" style="width:200px;">
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
        </div>
        
        <br>
       
        <div class="row form-inline">
            <div class="col-md-12">
                <b>Employee-Producer: Col IN B3 = </b>
                <input type="text" class="form-control form-control-sm" name="col_labc_in_b3" id="col_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_labc_in_b3']))?$o_desc_in_b3['col_labc_in_b3']:0;?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b3 = </b>
                <input type="text" class="form-control form-control-sm" name="fac_labc_in_b3" id="fac_labc_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_labc_in_b3']))?$o_desc_in_b3['fac_labc_in_b3']:"1";?>" form="order_details" style="width:5em"> 
                <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b3" id="col_amount3_in_b3" form="order_details" value="<?php echo (!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:"0";?>" style="width:5em" >
                <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b3" id="total_labcs_in_b3" value="<?php echo (!empty($o_desc_in_b3['total_labcs_in_b3']))?$o_desc_in_b3['total_labcs_in_b3']:"0";?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
            </div>
        </div>
        <div class="row form-inline">
            <div class="col-md-12">
                <b>Producer-Trader: Col IN B3 = </b>
                <input type="text" class="form-control form-control-sm" name="col_apus_in_b3" id="col_apus_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_apus_in_b3']))?$o_desc_in_b3['col_apus_in_b3']:0;?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b3 = </b>
                <input type="text" class="form-control form-control-sm" name="fac_prod_in_b3" id="fac_prod_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_prod_in_b3']))?$o_desc_in_b3['fac_prod_in_b3']:"1";?>" form="order_details" style="width:5em"> 
                <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b3" id="col_amount2_in_b3" form="order_details" value="<?php echo (!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:"0";?>" style="width:5em" >
                <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b3" id="o_apus_in_b3" value="<?php echo (!empty($o_desc_in_b3['o_apus_in_b3']))?$o_desc_in_b3['o_apus_in_b3']:"0";?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
            </div>
        </div>			
        <div class="row form-inline">
            <div class="col-md-12">
                <b>Trader-Purchaser: Col IN B3 = </b>
                <input class="form-control form-control-sm" type="text" name="col_price_in_b3" id="col_price_in_b3" value="<?php echo (!empty($o_desc_in_b3['col_price_in_b3']))?$o_desc_in_b3['col_price_in_b3']:0;?>" form="order_details" style="width:5em"> 
                <b><?php echo $currency; ?> X fac_client_in_b3 = </b> 
                <input type="text" class="form-control form-control-sm" name="fac_cl_in_b3" id="fac_cl_in_b3" value="<?php echo (!empty($o_desc_in_b3['fac_cl_in_b3']))?$o_desc_in_b3['fac_cl_in_b3']:"1";?>" form="order_details" style="width:5em"> 
                <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b3" id="col_amount1_in_b3" form="order_details" value="<?php echo (!empty($o_desc_in_b3['col_amount_in_b3']))?$o_desc_in_b3['col_amount_in_b3']:"0";?>" style="width:5em" > 
                <b>=</b> 
                <input type="text" class="form-control form-control-sm" name="o_price_in_b3" id="o_price_in_b3" value="<?php echo (!empty($o_desc_in_b3['o_price_in_b3']))?$o_desc_in_b3['o_price_in_b3']:"0";?>" form="order_details" style="width:5em">
                <b><?php echo $currency; ?></b>			
                <br><br>
            </div>
        </div>
        
        <br>
    
       
        <hr style="border:2px solid brown;">
                
              
        </div>		

<br>

<?php	
}
?>
    <div class="row mx-0 w-100 border-top border-bottom pt-3 d-flex justify-content-center" id="b5intopen" style="background-color:#c9c995;">
        <!-- <p class="d-inline ml-auto">This client has not chosen a b5 interior product. </p> -->
        <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb5" data-toggle="collapse" id="b5intbtnopen">B5 interior - Skp/V-Ray</button></p>
    </div>
<?php
if(!empty($b5_in_products))
{   
    $layout_id=$o_desc_in_b5['layout_id'];
    $window_id=$o_desc_in_b5['window_id'];
    ?>	
    <div class="col-md-12 collapse <?php
    if (strpos($order['collection'], 'p1501') !== false) 
    {
        echo "show";
    }?>" id="interiorb5" style="background-color:#c9c995;">
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
                $product_price=$prod->calculateProductPrice($order['ls_id'],$b5_in_products[$i],$cur_factor);
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
            <div class="row w-100 mx-0 my-1">					
                <div class="<?php 
                
                for($j=0;$j<count($collection);$j++)
                {
                    
                    if($b5_in_products[$i]==$collection[$j])
                    {
                        echo "active_layout";
                        
                    }
                    
                }							
                ?>">
                    <input class="products product_in_b5 checkbox mx-2" type="checkbox" name="<?php echo $b5_in_products[$i]; ?>" id="<?php echo $b5_in_products[$i]; ?>" value="<?php echo $b5_in_products[$i]; ?>" <?php 
                        
                        for($j=0;$j<count($collection);$j++)
                        {
                            
                            if($b5_in_products[$i]==$collection[$j])
                            {
                                echo "checked";
                                
                            }
                            
                        }							
                        ?>> 
                    <label for="<?php echo $b5_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                    //echo $product_price." ".$currency; 
                    echo $product_apu." APE";?></label>	
                    
                    <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                    <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                    <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                    <?php
                    if(($b5_in_products[$i]=="p1501")||($b5_in_products[$i]=="p1504")||($b5_in_products[$i]=="p1506")||($b5_in_products[$i]=="p1521")||($b5_in_products[$i]=="p1521")||($b5_in_products[$i]=="p1524")||($b5_in_products[$i]=="p1526")||($b5_in_products[$i]=="p1541")||($b5_in_products[$i]=="p1544")||($b5_in_products[$i]=="p1546"))
                    { 
                    ?>
                    <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_in_multiplicator" form="order_details" id="<?php echo $b5_in_products[$i]; ?>_fac" name="<?php echo $b5_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b5[$b5_in_products[$i]."_fac"]!=0)?$o_desc_in_b5[$b5_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                    <?php 
                    }
                    ?>
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
    <div class="row w-100 mx-0 mb-4">
        <div class="col-md-12 d-flex justify-content-center">
            <div id="b5_nav" class="nav nav-inline">
                <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                <?php 
                $layout=$domenia->get_layout2($layout_id); 
                        
                $layoutline=$domenia->get_layouts_by_quality_id2("b5");
                
                for($i=0;$i<count($layoutline);$i++)
                {
                    ?>
                    <a href="#b5_layouts" class="nav-item <?php
                    if($layout_id==$layoutline[$i]['l_id'])
                    {
                        echo "active-layoutline";
                    }
                    ?>" title="<?php echo $layoutline[$i]['l_id'];?>">
                        <div class="colorbox b5_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                        echo $window['window_color']; ?>;border: 10px solid <?php                     
                        $floor_color=$domenia3n->get_b5_colorset($layoutline[$i]['set_colors']);
                        echo $floor_color['cl1_floor'];?>">
                        </div>
                    </a>					
                    <?php							
                }
                ?>
            </div>
            <input type="hidden" name="b5_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
        </div>
    </div> <!-- end row -->
    <?php


// if(count($b5_in_products)>0)
// {
    
?>
<div class="row form-inline w-100 mx-0 border-bottom border-dark">
    <div class="col-md-12">
        <b>Employee-Producer: Col IN B5 = </b>
        <input type="text" class="form-control form-control-sm" name="col_labc_in_b5" id="col_labc_in_b5" value="" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b5 = </b>
        <input type="text" class="form-control form-control-sm" name="fac_labc_in_b5" id="fac_labc_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_labc_in_b5']))?$o_desc_in_b5['fac_labc_in_b5']:"1";?>" form="order_details" style="width:5em"> 
        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b5" id="col_amount3_in_b5" form="order_details" value="<?php echo $o_desc_in_b5['col_amount_in_b5'];/*echo (!empty($o_desc_in_b5['col_amount_in_b5']))?$o_desc_in_b5['col_amount_in_b5']:"1";*/?>" style="width:5em" >
        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b5" id="total_labcs_in_b5" value="<?php echo (!empty($o_desc_in_b5['total_labcs_in_b5']))?$o_desc_in_b5['total_labcs_in_b5']:"0";?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
    </div>
</div>
<div class="row form-inline w-100 mx-0">
    <div class="col-md-12">
        <b>Producer-Trader: Col IN B5 = </b>
        <input type="text" class="form-control form-control-sm" name="col_apus_in_b5" id="col_apus_in_b5" value="" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b5 = </b>
        <input type="text" class="form-control form-control-sm" name="fac_prod_in_b5" id="fac_prod_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_prod_in_b5']))?$o_desc_in_b5['fac_prod_in_b5']:"1";?>" form="order_details" style="width:5em"> 
        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b5" id="col_amount2_in_b5" form="order_details" value="<?php echo $o_desc_in_b5['col_amount_in_b5'];/* echo (!empty($o_desc_in_b5['col_amount_in_b5']))?$o_desc_in_b5['col_amount_in_b5']:"1";*/?>" style="width:5em" >
        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b5" id="o_apus_in_b5" value="<?php echo (!empty($o_desc_in_b5['o_apus_in_b5']))?$o_desc_in_b5['o_apus_in_b5']:"0";?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
    </div>
</div>			
<div class="row form-inline w-100 mx-0 my-1">
    <div class="col-md-12 d-flex justify-content-center">
        <b>Trader-Purchaser: Col IN B5 = </b>
        <input class="form-control form-control-sm" type="text" name="col_price_in_b5" id="col_price_in_b5" value="<?php echo (!empty($o_desc_in_b5['col_price_in_b5']))?$o_desc_in_b5['col_price_in_b5']:"0";?>" form="order_details" style="width:5em"> 
        <b><?php echo $currency; ?> X fac_client_in_b5 = </b> 
        <input type="text" class="form-control form-control-sm" name="fac_cl_in_b5" id="fac_cl_in_b5" value="<?php echo (!empty($o_desc_in_b5['fac_cl_in_b5']))?$o_desc_in_b5['fac_cl_in_b5']:"1";?>" form="order_details" style="width:5em"> 
        <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b5" id="col_amount1_in_b5" form="order_details" value="<?php echo (!empty($o_desc_in_b5['col_amount_in_b5']))?$o_desc_in_b5['col_amount_in_b5']:"1";?>" style="width:5em" > 
        <b>=</b> 
        <input type="text" class="form-control form-control-sm" name="o_price_in_b5" id="o_price_in_b5" value="<?php echo (!empty($o_desc_in_b5['o_price_in_b5']))?$o_desc_in_b5['o_price_in_b5']:"0";?>" form="order_details" style="width:5em">
        <b><?php echo $currency; ?></b>			
        <br><br>
    </div>
</div>
    <br>
    </div> <!-- end col-md-12 -->
    <?php
   
//}
}
//start b6 
?>
<div class="row mx-0 w-100 justify-content-center pt-3" id="b6intopen" style="background-color:#8e8e48;">
    <!-- <p class="d-inline">This client has not chosen a b7 interior product. </p> -->
    <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#interiorb6" data-toggle="collapse" id="b6intbtnopen">B6 interior - Twinmotion</button></p>
</div>
<?php
if(!empty($b6_in_products))
{   
    $layout_id=$o_desc_in_b6['layout_id'];
    $window_id=$o_desc_in_b6['window_id'];
    ?>	
    <div class="col-md-12 collapse <?php
    if (strpos($order['collection'], 'p1601') !== false) 
    {
        echo "show";
    }?>" id="interiorb6" style="background-color:#8e8e48;">
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
                $product_price=$prod->calculateProductPrice($order['ls_id'],$b6_in_products[$i],$cur_factor);
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
            <div class="row w-100 mx-0 my-1">					
                <div class="<?php 
                
                for($j=0;$j<count($collection);$j++)
                {
                    
                    if($b6_in_products[$i]==$collection[$j])
                    {
                        echo "active_layout";
                        
                    }
                    
                }							
                ?>">
                    <input class="products product_in_b6 checkbox mx-2" type="checkbox" name="<?php echo $b6_in_products[$i]; ?>" id="<?php echo $b6_in_products[$i]; ?>" value="<?php echo $b6_in_products[$i]; ?>" <?php 
                        
                        for($j=0;$j<count($collection);$j++)
                        {
                            
                            if($b6_in_products[$i]==$collection[$j])
                            {
                                echo "checked";
                                
                            }
                            
                        }							
                        ?>> 
                    <label for="<?php echo $b6_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                    //echo $product_price." ".$currency;
                    echo $product_apu." APE"; ?></label>	
                    
                    <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                    <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                    <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                    <?php
                    if(($b6_in_products[$i]=="p1601")||($b6_in_products[$i]=="p1604")||($b6_in_products[$i]=="p1606")||($b6_in_products[$i]=="p1621")||($b6_in_products[$i]=="p1624")||($b6_in_products[$i]=="p1626")||($b6_in_products[$i]=="p1641")||($b6_in_products[$i]=="p1644")||($b6_in_products[$i]=="p1646"))
                    { 
                    ?>
                    <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b6_in_multiplicator" form="order_details" id="<?php echo $b6_in_products[$i]; ?>_fac" name="<?php echo $b6_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b6[$b6_in_products[$i]."_fac"]!=0)?$o_desc_in_b6[$b6_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                    <?php 
                    }
                    ?>
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
    <div class="row w-100 mx-0 mb-4">
        <div class="col-md-12 d-flex justify-content-center">
            <div id="b6_nav" class="nav nav-inline">
                <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                <?php 
                $layout=$domenia->get_layout2($layout_id); 
                        
                $layoutline=$domenia->get_layouts_by_quality_id2("b6");
                
                for($i=0;$i<count($layoutline);$i++)
                {
                    ?>
                    <a href="#b6_layouts" class="nav-item <?php
                    if($layout_id==$layoutline[$i]['l_id'])
                    {
                        echo "active-layoutline";
                    }
                    ?>" title="<?php echo $layoutline[$i]['l_id'];?>">
                        <div class="colorbox b6_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                        echo $window['window_color']; ?>;border: 10px solid <?php                     
                        $floor_color=$domenia3n->get_b6_colorset($layoutline[$i]['set_colors']);
                        echo $floor_color['cl1_floor'];?>">
                        </div>
                    </a>					
                    <?php							
                }
                ?>
            </div>
            <input type="hidden" name="b6_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
        </div>
    </div> <!-- end row -->
    <?php


// if(count($b6_in_products)>0)
// {
    
?>
<div class="row form-inline w-100 mx-0 border-bottom border-dark">
    <div class="col-md-12">
        <b>Employee-Producer: Col IN B6 = </b>
        <input type="text" class="form-control form-control-sm" name="col_labc_in_b6" id="col_labc_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_labc_in_b6']))?$o_desc_in_b6['col_labc_in_b6']:"0";?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b6 = </b>
        <input type="text" class="form-control form-control-sm" name="fac_labc_in_b6" id="fac_labc_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_labc_in_b6']))?$o_desc_in_b6['fac_labc_in_b6']:"1";?>" form="order_details" style="width:5em"> 
        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b6" id="col_amount3_in_b6" form="order_details" value="<?php (!empty($o_desc_in_b6['col_amount_in_b6']))?$o_desc_in_b6['col_amount_in_b6']:"1";?>" style="width:5em" >
        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b6" id="total_labcs_in_b6" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
    </div>
</div>
<div class="row form-inline w-100 mx-0">
    <div class="col-md-12">
        <b>Producer-Trader: Col IN B6 = </b>
        <input type="text" class="form-control form-control-sm" name="col_apus_in_b6" id="col_apus_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_apus_in_b6']))?$o_desc_in_b6['col_apus_in_b6']:"0";?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b6 = </b>
        <input type="text" class="form-control form-control-sm" name="fac_prod_in_b6" id="fac_prod_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_prod_in_b6']))?$o_desc_in_b6['fac_prod_in_b6']:"1";?>" form="order_details" style="width:5em"> 
        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b6" id="col_amount2_in_b6" form="order_details" value="<?php echo (!empty($o_desc_in_b6['col_amount_in_b6']))?$o_desc_in_b6['col_amount_in_b6']:"1";?>" style="width:5em" >
        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b6" id="o_apus_in_b6" value="<?php echo $o_desc_in_b6['o_apus_in_b6'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
    </div>
</div>			
<div class="row form-inline w-100 mx-0 my-1">
    <div class="col-md-12 d-flex justify-content-center">
        <b>Trader-Purchaser: Col IN B6 = </b>
        <input class="form-control form-control-sm" type="text" name="col_price_in_b6" id="col_price_in_b6" value="<?php echo (!empty($o_desc_in_b6['col_price_in_b6']))?$o_desc_in_b6['col_price_in_b6']:"0";?>" form="order_details" style="width:5em"> 
        <b><?php echo $currency; ?> X fac_client_in_b6 = </b> 
        <input type="text" class="form-control form-control-sm" name="fac_cl_in_b6" id="fac_cl_in_b6" value="<?php echo (!empty($o_desc_in_b6['fac_cl_in_b6']))?$o_desc_in_b6['fac_cl_in_b6']:"1";?>" form="order_details" style="width:5em"> 
        <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b6" id="col_amount1_in_b6" form="order_details" value="<?php echo (!empty($o_desc_in_b6['col_amount_in_b6']))?$o_desc_in_b6['col_amount_in_b6']:"1";?>" style="width:5em" > 
        <b>=</b> 
        <input type="text" class="form-control form-control-sm" name="o_price_in_b6" id="o_price_in_b6" value="<?php echo (!empty($o_desc_in_b6['o_price_in_b6']))?$o_desc_in_b6['o_price_in_b6']:"0"; ?>" form="order_details" style="width:5em">
        <b><?php echo $currency; ?></b>			
        <br><br>
    </div>
</div>
    <br>
    </div> <!-- end col-md-12 -->
    <br>	             
    <?php

//}
} 
?>

<?php
//start b7 in

if(!empty($b7_in_products))
{
    $layout_id=$o_desc_in_b7['layout_id'];
    $window_id=$o_desc_in_b7['window_id'];
    ?>	
    <div class="col-md-12 collapse <?php
    if (strpos($order['collection'], 'p1701') !== false) 
    {
        echo "show";
    }?>" id="interiorb7" style="background-color:#a3a373;">
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
                    $product_price=$prod->calculateProductPrice($order['ls_id'],$b7_in_products[$i],$cur_factor);
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
                <div class="row w-100 mx-0 my-1">					
                    <div class="<?php 
                    
                    for($j=0;$j<count($collection);$j++)
                    {
                        
                        if($b7_in_products[$i]==$collection[$j])
                        {
                            echo "active_layout";
                            
                        }
                        
                    }							
                    ?>">
                        <input class="products product_in_b7 checkbox mx-2" type="checkbox" name="<?php echo $b7_in_products[$i]; ?>" id="<?php echo $b7_in_products[$i]; ?>" value="<?php echo $b7_in_products[$i]; ?>" <?php 
                            
                            for($j=0;$j<count($collection);$j++)
                            {
                                
                                if($b7_in_products[$i]==$collection[$j])
                                {
                                    echo "checked";
                                    
                                }
                                
                            }							
                            ?>> 
                        <label for="<?php echo $b7_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                        //echo $product_price." ".$currency; 
                        echo $product_apu." APE";?></label>					

                        <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                        <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                        <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                        <?php
                        if(($b7_in_products[$i]=="p1701")||($b7_in_products[$i]=="p1704")||($b7_in_products[$i]=="p1706")||($b7_in_products[$i]=="p1721")||($b7_in_products[$i]=="p1724")||($b7_in_products[$i]=="p1726")||($b7_in_products[$i]=="p1741")||($b7_in_products[$i]=="p1744")||($b7_in_products[$i]=="p1746"))
                        {
                        ?>
                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b7_in_multiplicator" form="order_details" id="<?php echo $b7_in_products[$i]; ?>_fac" name="<?php echo $b7_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b7[$b7_in_products[$i]."_fac"]!=0)?$o_desc_in_b7[$b7_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                        <?php
                        }
                        ?>
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
                <div id="b7_nav" class="nav nav-inline">
                    <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                    <?php $layout=$domenia->get_layout2($layout_id); 
                            
                    $layoutline=$domenia->get_layouts_by_quality_id2("b7");
                    
                    for($i=0;$i<count($layoutline);$i++)
                    {
                        ?>
                        <a href="#b7_layouts" class="nav-item <?php
                        if($layout_id==$layoutline[$i]['l_id'])
                        {
                            echo "active-layoutline";
                        }
                        ?>" title="<?php echo $layoutline[$i]['l_id'];?>">
                            <div class="colorbox b7_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                            echo $window['window_color']; ?>;border: 10px solid <?php 
                            $floor_color=$domenia3n->get_b7_colorset($layoutline[$i]['set_colors']);
                            echo $floor_color['cl1_floor'];?>">
                            </div>
                        </a>					
                        <?php							
                    }
                    ?>
                </div>
                <input type="hidden" name="b7_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
            </div>
        </div> <!-- end row -->
        <br>
        
        <?php
    
    ?>
    
    <br>	
    
    <?php
        
    // if(count($b7_in_products)>0)
    // {
        
    ?>
    <div class="row form-inline w-100 mx-0">
        <div class="col-md-12">
            <b>Employee-Producer: Col IN B7 = </b>
            <input type="text" class="form-control form-control-sm" name="col_labc_in_b7" id="col_labc_in_b7" value="<?php echo (!empty($o_desc_in_b7['col_labc_in_b7']))?$o_desc_in_b7['col_labc_in_b7']:"0";?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b7 = </b>
            <input type="text" class="form-control form-control-sm" name="fac_labc_in_b7" id="fac_labc_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_labc_in_b7']))?$o_desc_in_b7['fac_labc_in_b7']:"1";?>" form="order_details" style="width:5em"> 
            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b7" id="col_amount3_in_b7" form="order_details" value="<?php echo (!empty($o_desc_in_b7['col_amount_in_b7']))?$o_desc_in_b7['col_amount_in_b7']:"1";?>" style="width:5em" >
            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b7" id="total_labcs_in_b7" value="<?php echo (!empty($o_desc_in_b7['total_labcs_in_b7']))?$o_desc_in_b7['total_labcs_in_b7']:"0";?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
        </div>
    </div>
    <div class="row form-inline w-100 mx-0">
        <div class="col-md-12">
            <b>Producer-Trader: Col IN B7 = </b>
            <input type="text" class="form-control form-control-sm" name="col_apus_in_b7" id="col_apus_in_b7" value="<?php echo (!empty($o_desc_in_b7['col_apus_in_b7']))?$o_desc_in_b7['col_apus_in_b7']:"0";?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b7 = </b>
            <input type="text" class="form-control form-control-sm" name="fac_prod_in_b7" id="fac_prod_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_prod_in_b7']))?$o_desc_in_b7['fac_prod_in_b7']:"1";?>" form="order_details" style="width:5em"> 
            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b7" id="col_amount2_in_b7" form="order_details" value="<?php echo (!empty($o_desc_in_b7['col_amount_in_b7']))?$o_desc_in_b7['col_amount_in_b7']:"1";?>" style="width:5em" >
            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b7" id="o_apus_in_b7" value="<?php echo (!empty($o_desc_in_b7['o_apus_in_b7']))?$o_desc_in_b7['o_apus_in_b7']:"0";?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
        </div>
    </div>			
    <div class="row form-inline w-100 mx-0 mt-2">
        <div class="col-md-12">
            <b>Trader-Purchaser: Col IN B7 = </b>
            <input class="form-control form-control-sm" type="text" name="col_price_in_b7" id="col_price_in_b7" value="<?php echo (!empty($o_desc_in_b7['col_price_in_b7']))?$o_desc_in_b7['col_price_in_b7']:"0";?>" form="order_details" style="width:5em"> 
            <b><?php echo $currency; ?> X fac_client_in_b7 = </b> 
            <input type="text" class="form-control form-control-sm" name="fac_cl_in_b7" id="fac_cl_in_b7" value="<?php echo (!empty($o_desc_in_b7['fac_cl_in_b7']))?$o_desc_in_b7['fac_cl_in_b7']:"1";?>" form="order_details" style="width:5em"> 
            <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b7" id="col_amount1_in_b7" form="order_details" value="<?php echo (!empty($o_desc_in_b7['col_amount_in_b7']))?$o_desc_in_b7['col_amount_in_b7']:"0";?>" style="width:5em" > 
            <b>=</b> 
            <input type="text" class="form-control form-control-sm" name="o_price_in_b7" id="o_price_in_b7" value="<?php echo (!empty($o_desc_in_b7['o_price_in_b7']))?$o_desc_in_b7['o_price_in_b7']:"0";?>" form="order_details" style="width:5em">
            <b><?php echo $currency; ?></b>			
            <br><br>
        </div>
    </div>
</div> <!-- end col-md-12 -->
    <?php
}

//start b8 in

if(!empty($b8_in_products))
{
    $layout_id=$o_desc_in_b8['layout_id'];
    $window_id=$o_desc_in_b8['window_id'];
    ?>	
    <div class="col-md-12 collapse <?php
    if (strpos($order['collection'], 'p1801') !== false) 
    {
        echo "show";
    }?>" id="interiorb8" style="background-color:#a3a373;">
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
                    $product_price=$prod->calculateProductPrice($order['ls_id'],$b8_in_products[$i],$cur_factor);
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
                <div class="row w-100 mx-0 my-1">					
                    <div class="<?php 
                    
                    for($j=0;$j<count($collection);$j++)
                    {
                        
                        if($b8_in_products[$i]==$collection[$j])
                        {
                            echo "active_layout";
                            
                        }
                        
                    }							
                    ?>">
                        <input class="products product_in_b8 checkbox mx-2" type="checkbox" name="<?php echo $b8_in_products[$i]; ?>" id="<?php echo $b8_in_products[$i]; ?>" value="<?php echo $b8_in_products[$i]; ?>" <?php 
                            
                            for($j=0;$j<count($collection);$j++)
                            {
                                
                                if($b8_in_products[$i]==$collection[$j])
                                {
                                    echo "checked";
                                    
                                }
                                
                            }							
                            ?>> 
                        <label for="<?php echo $b8_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                        //echo $product_price." ".$currency; 
                        echo $product_apu." APE";?></label>					

                        <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                        <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                        <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">

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
                        <?php
                        if(($b8_in_products[$i]=="p1801")||($b8_in_products[$i]=="p1804")||($b8_in_products[$i]=="p1806")||($b8_in_products[$i]=="p1821")||($b8_in_products[$i]=="p1824")||($b8_in_products[$i]=="p1826")||($b8_in_products[$i]=="p1841")||($b8_in_products[$i]=="p1844")||($b8_in_products[$i]=="p1846"))
                        {
                        ?>
                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b8_in_multiplicator" form="order_details" id="<?php echo $b8_in_products[$i]; ?>_fac" name="<?php echo $b8_in_products[$i]; ?>_fac" value="<?php echo ($o_desc_in_b8[$b8_in_products[$i]."_fac"]!=0)?$o_desc_in_b8[$b8_in_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                        <?php
                        }
                        ?>
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
                <div id="b8_nav" class="nav nav-inline">
                    <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>
                    <?php $layout=$domenia->get_layout2($layout_id); 
                            
                    $layoutline=$domenia->get_layouts_by_quality_id2("b8");
                    
                    for($i=0;$i<count($layoutline);$i++)
                    {
                        ?>
                        <a href="#b8_layouts" class="nav-item <?php
                        if($layout_id==$layoutline[$i]['l_id'])
                        {
                            echo "active-layoutline";
                        }
                        ?>" title="<?php echo $layoutline[$i]['l_id'];?>">
                            <div class="colorbox b8_layout" style="background-color:<?php $window=$prod->get_window($layoutline[$i]['window_id']);
                            echo $window['window_color']; ?>;border: 10px solid <?php 
                            $floor_color=$domenia3n->get_b8_colorset($layoutline[$i]['set_colors']);
                            echo $floor_color['cl1_floor'];?>">
                            </div>
                        </a>					
                        <?php							
                    }
                    ?>
                </div>
                <input type="hidden" name="b8_selected_layoutline" value="<?php echo $layout['l_id'];?>" form="order_details">
            </div>
        </div> <!-- end row -->
        <br>
        
        <?php
    
    ?>
    
    <br>	
    
    <?php
        
    // if(count($b8_in_products)>0)
    // {
        
    ?>
    <div class="row form-inline w-100 mx-0">
        <div class="col-md-12">
            <b>Employee-Producer: Col IN B8 = </b>
            <input type="text" class="form-control form-control-sm" name="col_labc_in_b8" id="col_labc_in_b8" value="<?php echo (!empty($o_desc_in_b8['col_labc_in_b8']))?$o_desc_in_b8['col_labc_in_b8']:"0";?>" form="order_details" style="width:5em"> <b>labcs X fac_labc_in_b8 = </b>
            <input type="text" class="form-control form-control-sm" name="fac_labc_in_b8" id="fac_labc_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_labc_in_b8']))?$o_desc_in_b8['fac_labc_in_b8']:"1";?>" form="order_details" style="width:5em"> 
            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b8" id="col_amount3_in_b8" form="order_details" value="<?php echo (!empty($o_desc_in_b8['col_amount_in_b8']))?$o_desc_in_b8['col_amount_in_b8']:"1";?>" style="width:5em" >
            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b8" id="total_labcs_in_b8" value="<?php echo (!empty($o_desc_in_b8['total_labcs_in_b8']))?$o_desc_in_b8['total_labcs_in_b8']:"0";?>" form="order_details" style="width:5em"> <b>labcs</b><br><br>
        </div>
    </div>
    <div class="row form-inline w-100 mx-0">
        <div class="col-md-12">
            <b>Producer-Trader: Col IN B8 = </b>
            <input type="text" class="form-control form-control-sm" name="col_apus_in_b8" id="col_apus_in_b8" value="<?php echo (!empty($o_desc_in_b8['col_apus_in_b8']))?$o_desc_in_b8['col_apus_in_b8']:"0";?>" form="order_details" style="width:5em"> <b>APEs X fac_prod_in_b8 = </b>
            <input type="text" class="form-control form-control-sm" name="fac_prod_in_b8" id="fac_prod_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_prod_in_b8']))?$o_desc_in_b8['fac_prod_in_b8']:"1";?>" form="order_details" style="width:5em"> 
            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b8" id="col_amount2_in_b8" form="order_details" value="<?php echo (!empty($o_desc_in_b8['col_amount_in_b8']))?$o_desc_in_b8['col_amount_in_b8']:"1";?>" style="width:5em" >
            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b8" id="o_apus_in_b8" value="<?php echo $o_desc_in_b8['o_apus_in_b8'];?>" form="order_details" style="width:5em"> <b>APEs</b><br><br>
        </div>
    </div>			
    <div class="row form-inline w-100 mx-0 mt-2">
        <div class="col-md-12">
            <b>Trader-Purchaser: Col IN B8 = </b>
            <input class="form-control form-control-sm" type="text" name="col_price_in_b8" id="col_price_in_b8" value="<?php echo (!empty($o_desc_in_b8['col_price_in_b8']))?$o_desc_in_b8['col_price_in_b8']:"0";?>" form="order_details" style="width:5em"> 
            <b><?php echo $currency; ?> X fac_client_in_b8 = </b> 
            <input type="text" class="form-control form-control-sm" name="fac_cl_in_b8" id="fac_cl_in_b8" value="<?php echo (!empty($o_desc_in_b8['fac_cl_in_b8']))?$o_desc_in_b8['fac_cl_in_b8']:"1";?>" form="order_details" style="width:5em"> 
            <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b8" id="col_amount1_in_b8" form="order_details" value="<?php echo (!empty($o_desc_in_b8['col_amount_in_b8']))?$o_desc_in_b8['col_amount_in_b8']:"1";?>" style="width:5em" > 
            <b>=</b> 
            <input type="text" class="form-control form-control-sm" name="o_price_in_b8" id="o_price_in_b8" value="<?php echo (!empty($o_desc_in_b8['o_price_in_b8']))?$o_desc_in_b8['o_price_in_b8']:"0";?>" form="order_details" style="width:5em">
            <b><?php echo $currency; ?></b>			
            <br><br>
        </div>
    </div>
</div> <!-- end col-md-12 -->
    <?php
}
?>

    <div class="row w-100 mx-0 pb-5">
        <div class="col-md-6">
            <p><b>Customer remarks interior : </b></p>
            <textarea name="customer_remarks" class="form-control form-control-sm d-inline" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['clients-extras']); ?></textarea>
        </div>		
        <div class="col-md-6">
            <p><b>Operator remarks interior: </b></p>
            <textarea name="op_remarks" class="form-control form-control-sm d-inline" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['op-remarks']); ?></textarea>
        </div>	
    </div>
			
			<?php		
} //else
                    
?>

</div>
</div>
<!-- end interrior -->	

<div class="container pagecontent bg-white px-0">
<div class="exterior border-top border-dark" style="box-shadow: none;">
<input type="hidden" id="option" name="option" value="<?php echo (!empty($option))?$option:"";?>">
<?php
$exterior=0;


if((!empty($o_desc_ex_b1['col_amount_ex_b1']))||
(!empty($o_desc_ex_b5['col_amount_ex_b5']))||
(!empty($o_desc_ex_b6['col_amount_ex_b6']))||
(!empty($_desc_ex_b7['col_amount_ex_b7']))||
(!empty($o_desc_ex_b8['col_amount_ex_b8']>0)))
{
$exterior++;
}

if($exterior>0)
{
    ?>				
    <div class="row w-100 mx-0">
    <div class="col-md-12">
        <h5 class="mb-0 pt-2 text-success text-center">Exterior</h5>
        <hr class="bg-dark" width="300px"> 
    </div>
    </div>
    <a id="exterior"></a>
    <!-- <div class="center_message"> <div class="success"><?php echo (!empty($result_message))?$result_message:"";?></div></div> -->
    <br>
    <div class="row w-100 mx-0">
    <div class="col-md-4 d-flex justify-content-center">
            <p class="d-inline mr-3 mb-0">
                <b>Amount of exterior subIDs: </b> <!-- exterior exists -->
            </p>
            <input type="textbox" name="col_amount0_ex" id="col_amount0_ex" class="form-control form-control-sm" style="width:5em;" value="<?php
            $amount=1;
            if(($o_desc_ex_b5['col_amount_ex_b5']==0)&&($o_desc_ex_b6['col_amount_ex_b6']==0)&&($o_desc_ex_b7['col_amount_ex_b7']==0)&&($o_desc_ex_b8['col_amount_ex_b8']==0))
            {
                echo "1";
            }
            else
            {               
                if($o_desc_ex_b5['col_amount_ex_b5']>0)
                {
                    echo $o_desc_ex_b5['col_amount_ex_b5'];
                    $amount++;
                }
                if($amount==1)
                {
                    if($o_desc_ex_b6['col_amount_ex_b6']>0)
                    {
                        echo $o_desc_ex_b6['col_amount_ex_b6'];
                        $amount++;
                    }
                }
                if($amount==1)
                {
                    if($o_desc_ex_b7['col_amount_ex_b7']>0)
                    {
                        echo $o_desc_ex_b7['col_amount_ex_b7'];
                        $amount++;
                    }
                }
                if($amount==1)
                {
                    if($o_desc_ex_b8['col_amount_ex_b8']>0)
                    {
                        echo $o_desc_ex_b8['col_amount_ex_b8'];
                        $amount++;
                    }
                }
            }?>">
        </div>
        <script type="text/javascript">
            $(document).ready(function(){

                $.ajax({
                    url: "../ajax/create_orders_subnames_exterior_html.php",
                    method: "post",
                    data: {o_id:<?php echo $o_id;?>,total_exterior_amount:$('#col_amount0_ex').val()},
                    //data:$("interior_osn_form").serialize(),
                    dataType:"html",
                    success:function(data) {
                        $('#exterior_osn_texts').html(data);										
                    }
                });

            });

            $('#col_amount0_ex').on('change focusout',function(){
                $.ajax({
                    url: "../ajax/create_orders_subnames_exterior_html.php",
                    method: "post",
                    data: {o_id:<?php echo $o_id;?>,total_exterior_amount:$('#col_amount0_ex').val()},
                    //data:$("interior_osn_form").serialize(),
                    dataType:"html",
                    success:function(data) {
                        $('#exterior_osn_texts').html(data);										
                    }
                });
            });
        </script>
        <div class="col-md-4 text-center">
            <b>Exterior sub names</b>
        </div>
        <div class="col-md-4 text-center">
            
        </div>
    </div> <!-- end row -->
    <div class="row w-100 mx-0">
        <div class="col-md-12 justify-content-center">           
            <div class="row">
                <div class="col-md-12 d-inline" id="exterior_osn_texts">
                <?php
                    $all_subids=$prod->get_all_subids_by_o_id($o_id);

                    for($i=0;$i<count($all_subids);$i++)
                    {
                        if (strpos($all_subids[$i]['o_sub_id'], 'x') !== false) 
                        {
                            ?>
                            <div id="row<?php echo $all_subids[$i]['subo_id'];?>" class="row">
                                
                                <div class="col-md-2">
                            <?php
                            echo $all_subids[$i]['o_sub_id']."&nbsp;";
                            ?>
                                </div>
                            <div class="col-md-2">
                        <input type="text" id="subo_id<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" value="<?php echo $all_subids[$i]['subo_name'];?>" placeholder="Name" class="form-control form-control-sm">
                        <datalist id="exterior_subid_list<?php echo $all_subids[$i]['subo_id'];?>">
                            <option value="Außen">
                            <option value="Ansichten">
                        </datalist>
                        <button type="button" class="btn btn-sm btn-danger">X</button>
                        <script type="text/javascript">
                        

                        $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                method: "get",
                                data: {
                                    subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                    exterior_subname:$(this).val(),
                                    option:"rename_exterior_osn_file"},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);										
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(xhr.status);
                                    console.log(thrownError);
                                }
                                
                            }); 
                        });
                    
                        </script>
                        </div>
                        
                        <div class="col-md-2">
                            <select id="object_type<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="form-control form-control-sm">
                                <option value="">--Object type--</option>
                                <?php
                                $all_object_types=$prod->get_all_object_types();
                                for($o=0;$o<count($all_object_types);$o++)
                                {
                                    ?>
                                    <option value="<?php echo $all_object_types[$o]['ot_id'];?>" <?php echo ($all_object_types[$o]['ot_id']==$all_subids[$i]['object_type'])?"selected":"";?>><?php echo $all_object_types[$o]['ot_description'];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $('#object_type<?php echo $all_subids[$i]['subo_id'];?>').on('change',function(){
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                    method: "get",
                                    data: {
                                        subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                        object_type:$(this).val(),
                                        option:"change_object_type"},
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);										
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                    
                                }); 
                            });
                            </script>
                        </div>
                        <div class="col-md-2">
                        <a href="<?php echo $base_url;?>perspectives/index.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $all_subids[$i]['o_sub_id'];?>" class="btn btn-sm btn-success" target="_blank" >Perspectives(<?php 
                        $perspectives_data['o_id']=$o_id;
                        $perspectives_data['osub_id']=$all_subids[$i]['o_sub_id'];
                        
                        $perspectives=$prod->get_all_perspectives_for_this_sub_id(json_encode($perspectives_data));
                    
                        echo count($perspectives);
                        ?>):Edit or create</a>
                        </div>
                        <div class="col-md-2">
                            <textarea class="form-control form-control-sm" id="subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" placeholder="Explanation" style="height: 30px;"><?php 
                            echo $all_subids[$i]['subo_more_infos'];?></textarea>
                            <script type="text/javascript">
                                $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                                    $.ajax({
                                        url: "<?php echo $base_url;?>ajax/change_orders_subnames_more_infos.php",
                                        method: "get",
                                        data: {
                                            subo_id: $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                            exterior_subo_more_infos:$(this).val(),
                                            option:"rename_exterior_more_infos"
                                        },
                                        dataType:"html",
                                        success:function(data) {
                                            console.log(data);										
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(thrownError);
                                        }
                                        
                                    }); 
                                });
                            </script>
                        </div>
                        <div class="col-md-1">
                            <button type="button" id="del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="btn btn-sm btn-danger">X</button>
                            <script type="text/javascript">
                            $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').click(function(){
                                if(confirm('Are you sure want to delete ?'))
                                {
                                    $.ajax({
                                        url: "<?php echo $base_url;?>ajax/delete_orders_subnames.php",
                                        method: "post",
                                        data: {
                                            subo_id: $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                            },
                                        dataType:"html",
                                        success:function(data) {
                                            $('#row_subname<?php echo $all_subids[$i]['subo_id'];?>').fadeOut(3000);										
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
                    }
                    ?>                               
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php
    
    $o_desc_allproducts=$prod->get_o_infos_allproducts($o_id);
    ?>
                
    <div class="row w-100 mx-0">
        <div class="col-md-12 d-flex justify-content-center">
            <table class="short_order" style="border: 5px solid green;">
                <tr style="background: #d4eed1;">
                    <td class="border border-success p-2 text-center">
                        <b><?php
					//Basement:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1553","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1553","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1553","x-texts")['text'];
						echo $text;
					}
					?></b><br>
					<div class="form-inline d-flex justify-content-center">
						<input type="text" id="basement" name="basement" value="<?php echo (!empty($o_desc_allproducts['basement']))?$o_desc_allproducts['basement']:0;?>" class="form-control form-control-sm" style="width:6em;" <?php
						if(($_COOKIE['contracting'])<1) {echo "disabled";}  
						?> form="order_details">
					</div>
					<script type="text/javascript">
					/* $(document).ready(function() {
					$('#basement').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance_allproducts.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,basement:$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						}
						});
					});
					}); */
					</script>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Levels over ground:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1554","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1554","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1554","x-texts")['text'];
						echo $text;
					}?></b><br>
					<div class="form-inline d-flex justify-content-center">
						<input type="text" id="levels_over_ground" name="levels_over_ground" value="<?php 
							echo (!empty($o_desc_allproducts['levels_over_ground']))?$o_desc_allproducts['levels_over_ground']:0;
						?>" class="form-control form-control-sm" style="width:6em;" <?php
						if(($_COOKIE['contracting'])<1) {echo "disabled";} ?> form="order_details">										
					</div>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
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
					}?></b><br>
					<?php
					$stairs=$domenia3n->get_all_stairs();
					
					?>
					<select id ="st_id1" name="st_id1" class="form-control form-control-sm" <?php
					if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
						<option value="">None</option>
						<?php
						for($i=0;$i<count($stairs);$i++)
						{
						?>
						<option value="<?php echo $stairs[$i]['st_id'];?>" <?php echo ($o_desc_allproducts['stairs_id']==$stairs[$i]['st_id'])?"selected":"";?>><?php //echo $stairs[$i]['st_name'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$stairs[$i]['st_name_world'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$stairs[$i]['st_name_world'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$stairs[$i]['st_name_world'],"x-texts")['text'];
							echo $text;
						}
						?></option>
						<?php							
						}
						?>
					</select>
				</td>
				<td class="border border-success p-2 text-center">					
					<b><?php
					//Initial Length in cm:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1556","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1556","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1556","x-texts")['text'];
						echo $text;
					}?></b><br>
					<div class="form-inline d-flex justify-content-center">
						<input type="text" id="e_length" name="e_length" value="<?php echo $o_desc_allproducts['length'];?>" class="form-control form-control-sm" style="width:6em;" <?php
						if(($_COOKIE['contracting'])<1){ echo "disabled";}?> form="order_details">
					</div>
				</td>
				<td class="border border-success p-2 text-center">				
					<b><?php
					//Initial Width in cm:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1557","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1557","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1557","x-texts")['text'];
						echo $text;
					}?></b><br>
					<div class="form-inline d-flex justify-content-center">
						<input type="text" id="e_width" name="e_width" value="<?php echo $o_desc_allproducts['width'];?>" class="form-control form-control-sm" style="width:6em;" <?php
						if(($_COOKIE['contracting'])<1) {echo "disabled";} ?> form="order_details"> 
					</div>
				</td>			
			</tr>
			<tr style="background: #d4eed1;">
				<td class="border border-success p-2 text-center">
					<b><?php
					//Roof shape:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1558","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1558","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1558","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php
					$roof_shapes=$domenia2->get_all_roof_shapes();
					$roofshape=$domenia2->get_roof_shape($o_desc_allproducts['roof_type']);
					?>
					<select id="rs_id" name="rs_id" class="form-control form-control-sm" <?php
					if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
						<option value="">None</option>
						<?php
						for($i=0;$i<count($roof_shapes);$i++)
						{							
						?>
						<option value="<?php echo $roof_shapes[$i]['rs_id'];?>" <?php echo ($roofshape['rs_id']==$roof_shapes[$i]['rs_id'])?"selected":"";?>><?php echo $roof_shapes[$i]['rs_dbname'];?></option>
						<?php							
						}
						?>
					</select>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Roof tilt:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1559","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1559","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1559","x-texts")['text'];
						echo $text;
					}?></b><br>
					<div class="form-inline d-flex justify-content-center">
						<input type="text" id="r_tilt" name="r_tilt" value="<?php echo $o_desc_allproducts['roof_tilt'];?>" class="form-control form-control-sm" style="width:6em;" <?php
						if(($_COOKIE['contracting'])<1){echo "disabled";}			
						?> form="order_details">
						<?php
						/*if(($_COOKIE['contracting'])>0)
						{
						?>
						<button type="submit" id="b5_r_tilt_set_btn" name="b5_r_tilt_set_btn" class="btn btn-success btn-sm ml-2" form="b5_r_tilt_form">Set</button>
						<?php
						}*/
						?>
					</div>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Knee wall height in cm:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1560","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1560","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1560","x-texts")['text'];
						echo $text;
					}?></b><br>
					<div class="form-inline d-flex justify-content-center">
						<input type="text" id="r_kneewall" name="r_kneewall" value="<?php echo $o_desc_allproducts['knee_wall'];?>" class="form-control form-control-sm" style="width:6em;" <?php
						if(($_COOKIE['contracting'])<1){echo "disabled";}			
						?> form="order_details">
					</div>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Roof overstand:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1561","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1561","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1561","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php
					
					$selected_roof_overstand=$domenia2->get_roof_overstand_pic_by_id($o_desc_allproducts['rop_id']);
					
					$roof_overstand=$domenia2->get_all_roof_overstand();					
					?>
					<select id="rop_id" name="rop_id" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="">None</option>
					<?php
					for($i=0;$i<count($roof_overstand);$i++)
					{
						$roof_overstand_pic=$domenia2->get_roof_overstand_picture($roof_overstand[$i]['ro_id']);
					?>
						
						<option value="" style="font-weight:bold;"><?php echo $roof_overstand[$i]['ro_name_db'];?></option>
						<?php
						for($j=0;$j<count($roof_overstand_pic);$j++)
						{
							
							?>
							<option value="<?php echo $roof_overstand_pic[$j]['rop_id'];?>" style="text-indent:20px;" <?php echo ($roof_overstand_pic[$j]['rop_id']==$selected_roof_overstand['rop_id'])?"selected":"";?>><?php //echo $roof_overstand_pic[$j]['ro_look_db'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$roof_overstand_pic[$j]['ro_look_world'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$roof_overstand_pic[$j]['ro_look_world'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$roof_overstand_pic[$j]['ro_look_world'],"x-texts")['text'];
							echo $text;
						}
						?></option>
							<?php
						
						}
					}
					?>
					</select>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Roof tiles:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1562","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1562","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1562","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php
					$selected_roofcolor=$domenia2->get_roof_color_by_id($o_desc_allproducts['roof_material']);
                    if(!empty($selected_roofcolor['rm_id']))
                    {
					    $selected_rooftile=$domenia2->get_roof_material($selected_roofcolor['rm_id']);
                    }
                    else
                    {
                        $selected_rooftile['rm_id']="";
                    }

					$roof_materials=$domenia2->get_all_roof_materials();
					?>
					<select id="roof_material" name="roof_material" class="form-control form-control-sm" style="width:12em;" <?php
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					
					?>>
						<option value="" style="font-weight:bold">None</option>
						<?php
						for($i=0;$i<count($roof_materials);$i++)
						{
						?>
						<option value="<?php echo $roof_materials[$i]['rm_id'];?>" <?php echo ($roof_materials[$i]['rm_id']==$selected_rooftile['rm_id'])?"selected":"";?>><?php echo $roof_materials[$i]['rm_dbname'];?></option>
						<?php
						}
						?>
					</select>
                    <script type="text/javascript">
					$(document).ready(function() {

					$('#roof_material').on("change",function(){	
						$.ajax({
						url: "<?php echo $base_url;?>ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,roof_material:$(this).val()},
						dataType:"html",
						success:function(data) {
							//console.log(data);
                            $('#selected_roof_color').html(data);

                            /* $('#b5_roof_color').on("change",function(){	
                                
                                $.ajax({
                                url: "../ajax/acceptance.php",
                                method: "get",
                                data: {o_id:<?php echo $o_id;?>,b5_roof_color:$(this).val()},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);										
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(xhr.status);
                                    console.log(thrownError);
                                }
                                
                                });
                            }); */
                        
                    
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});
					});
					</script>
				</td>
				
			</tr>
			<tr style="background: #d4eed1;">
				<td class="border border-success p-2 text-center">
					<b><?php
					//Roof color:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1563","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1563","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1563","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php
					
					//for($j=0;$j<count($roof_materials);$j++)
					//{
                    //$all_roof_colors=$domenia2->get_roof_colors($roof_materials[$j]['rm_id']);
                    if(!empty($selected_roofcolor['rm_id']))
                    {
                        $all_roof_colors=$domenia2->get_roof_colors($selected_roofcolor['rm_id']);
                    }
                    else
                    {
                        $all_roof_colors=array();
                    }
					?>
                    <div id="selected_roof_color">
					<select id="roof_color" name="roof_color" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					
					?> form="order_details">
						<option value="">None</option>
						<?php
						for($i=0;$i<count($all_roof_colors);$i++)
						{						
							?>
							<option value="<?php echo $all_roof_colors[$i]['rmp_id'];?>" <?php echo ($all_roof_colors[$i]['rmp_id']==$selected_roofcolor['rmp_id'])?"selected":"";?>><?php echo $all_roof_colors[$i]['rmp_dbcolor']; ?></option>
							<?php							
						}
						?>
					</select>
                    </div>
                    <script type="text/javascript">
					/* $(document).ready(function() {

					$('#b5_roof_color').on("change",function(){	
                       
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_roof_color:$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					}); 
					});*/
                    
                    /*
                    
                     $(function(){
                        // get stored value or make it empty string if not available
                        $('#b5_roof_color').on("change",function(){

                        var selected = $('body').find('#b5_roof_color option:selected').val();
                        localStorage.setItem('selected', selected );

                        var storedValue = localStorage.getItem('selected') || '';

                        console.log(selected);

                        });
                        
                       
                        $('.ProductDetails select').change(function () {
                            // store current value
                            var currValue = $(this).val();
                            localStorage.setItem('prod-detail', currValue );
                            // now reload and all this code runs again
                            location.reload();
                        })
                        // set stored value when page loads
                        .val(storedValue) 

                    }); */
					</script>
					<?php							
					//}
					?>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Facade color/-s:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1564","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1564","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1564","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php 
					$colors=explode(";",$o_desc_allproducts['wlc_id']);
					$all_color_pictures=$domenia2->get_all_color_pictures();
					?>
					<div class="inline-flex">
                        <p class="mb-0 mr-1 d-inline">1.</p>
                     <select id="facade_color_1" name="facade_color_1" class="form-control form-control-sm d-inline mb-1" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="">None</option>
						<?php
						for($i=0;$i<count($all_color_pictures);$i++)
						{
						?>
						<option value="<?php echo $all_color_pictures[$i]['clp_id'];?>" <?php echo ($all_color_pictures[$i]['clp_id']==$colors[0])?"selected":"";?>><?php echo $all_color_pictures[$i]['clp_name_db'];?></option>
						<?php
						}
						?>
					   </select>
					</div>   
					<br>   
					<div class="inline-flex">
                        <p class="mb-0 d-inline mr-1">2.</p>
                     <select id="facade_color_2" name="facade_color_2" class="form-control form-control-sm d-inline" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="">None</option>
							<?php
							for($i=0;$i<count($all_color_pictures);$i++)
							{
							?>
						<option value="<?php echo $all_color_pictures[$i]['clp_id'];?>" <?php echo ($all_color_pictures[$i]['clp_id']==$colors[1])?"selected":"";?>><?php echo $all_color_pictures[$i]['clp_name_db'];?></option>
							<?php
							}
							?>
					   </select>
					</div>
                    <script type="text/javascript">
					/*$(document).ready(function() {
					$('#b5_facade_color_1').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_wlc_id:$(this).val()+";"+$('#b5_facade_color_2').val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});

                    $('#b5_facade_color_2').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_wlc_id:$('#b5_facade_color_1').val()+";"+$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});

					}); */
					</script>							
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Facade extras:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1565","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1565","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1565","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php
					$wallwoods=$domenia2->get_all_wall_wood();
					$selected_woodwall_pic=$domenia2->get_wall_wood_pic_by_id($o_desc_allproducts['ww_id']);
					
					?>
					<select id="ww_id" name="ww_id" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					
					?> form="order_details">
						<option value="" style="font-weight:bold;">None</option>
					<?php
					for($i=0;$i<count($wallwoods);$i++)
					{
					?>							
						<option value="" style="font-weight:bold;"><?php echo $wallwoods[$i]['ww_name_db'];?></option>
						<?php
						$woodwall_pic=$domenia2->get_all_wall_wood_pic_by_id($wallwoods[$i]['ww_id']);
						for($j=0;$j<count($woodwall_pic);$j++)
						{						
						?>
						<option value="<?php echo $woodwall_pic[$j]['wwp_id'];	?>" style="text-indent:20px;" <?php echo ($woodwall_pic[$j]['wwp_id']==$selected_woodwall_pic['wwp_id'])?"selected":"";?>><?php //echo $woodwall_pic[$j]['wwp_name_db'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$woodwall_pic[$j]['wwp_name_world'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$woodwall_pic[$j]['wwp_name_world'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$woodwall_pic[$j]['wwp_name_world'],"x-texts")['text'];
							echo $text;
						}
						?></option>
						<?php							
						}
						?>
					<?php
					}
					?>
					</select>
                    <script type="text/javascript">
					/*$(document).ready(function() {
					$('#b5_ww_id').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_ww_id:$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});
					}); */
					</script>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Window frames color
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1566","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1566","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1566","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php
                    if(!empty($o_desc_allproducts['wc_id']))
                    {
                        $windowcolor=$domenia2->get_color($o_desc_allproducts['wc_id']);
                    }
                    else
                    {
                        $windowcolor['col_id']="";
                    }

					$allcolors=$domenia2->get_all_colors();
					?>
					<select id="wc_id" name="wc_id" class="form-control form-control-sm" <?php
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="" style="font-weight:bold;">None</option>
						<?php
						for($i=0;$i<count($allcolors);$i++)
						{				
                            if(($allcolors[$i]['col_id']=="col_7016")||($allcolors[$i]['col_id']=="col_0001")||($allcolors[$i]['col_id']=="col_8007")||($allcolors[$i]['col_id']=="clp_9999"))
                            {		
                                ?>
                                <option value="<?php echo $allcolors[$i]['col_id'];	?>" <?php echo ($allcolors[$i]['col_id']==$windowcolor['col_id'])?"selected":"";?>><?php echo $allcolors[$i]['col_name_db'];?></option>
                                <?php
                            }							
						}
						?>
                        <option value="" style="font-weight:bold;">--------------------</option>
                        <?php
						for($i=0;$i<count($allcolors);$i++)
						{		
                            if((($allcolors[$i]['col_id']!="col_7016")&&($allcolors[$i]['col_id']!="col_0001")&&($allcolors[$i]['col_id']!="col_8007")&&($allcolors[$i]['col_id']!="clp_9999"))&&(!empty($allcolors[$i]['col_name_db'])))
                            {				
						?>
						<option value="<?php echo $allcolors[$i]['col_id'];	?>" <?php echo ($allcolors[$i]['col_id']==$windowcolor['col_id'])?"selected":"";?>><?php echo $allcolors[$i]['col_name_db'];?></option>
                        <?php
                            }							
						}
						?>
					</select>
                    <script type="text/javascript">
					/*$(document).ready(function() {
					$('#b5_wc_id').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_wc_id:$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});
					}); */
					</script>
				</td>
				<td class="border border-success p-2 text-center" >
					<b><?php 
					//Entrance door-shape + extensions
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1568","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1568","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1568","x-texts")['text'];
						echo $text;
					}?></b><br>
					<select id="door_texture" name="door_texture" class="form-control form-control-sm mb-1" <?php
					if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
						<option value="">None</option>
						<?php 
						$all_door_textures=$domenia2->get_all_door_textures();
						
						for($i=0;$i<count($all_door_textures);$i++)
						{
							$doorshape=$domenia2->get_door_shape($all_door_textures[$i]['ds_id']);						
						?>
						<option value="<?php echo $all_door_textures[$i]['dsp_id'];	?>" <?php echo($o_desc_allproducts['door_texture']==$all_door_textures[$i]['dsp_id'])?"selected":"";?>><?php //echo $doorshape['ds_name_db'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$doorshape['ds_name_world'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$doorshape['ds_name_world'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$doorshape['ds_name_world'],"x-texts")['text'];
							echo $text;
						}
						?></option>
						<?php													
						}
						?>
					</select>
					<script type="text/javascript">
					/*$(document).ready(function() {
					$('#b5_door_texture').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_door_texture:$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});
					}); */
					</script>
					<select  id="door_shape_sides" name="door_shape_sides" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					
					?> form="order_details">
						<option value="">None</option>
						<?php
						$all_door_shape_sides=$domenia2->get_all_door_shape_sides2();
						
						for($i=0;$i<count($all_door_shape_sides);$i++)
						{
							$doorshapeside=$domenia2->get_door_shape_sides($all_door_shape_sides[$i]['dss_id']);						
						?>
						<option value="<?php echo $all_door_shape_sides[$i]['dsp_id'];?>" <?php echo ($o_desc_allproducts['dsp_id']==$all_door_shape_sides[$i]['dsp_id'])?"selected":"";?>><?php //echo $doorshapeside['dss_name_db'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$doorshapeside['dss_name_world'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$doorshapeside['dss_name_world'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$doorshapeside['dss_name_world'],"x-texts")['text'];
							echo $text;
						}
						?></option>
						<?php							
						}
						?>
					</select>
                    <script type="text/javascript">
					/*$(document).ready(function() {
					$('#b5_door_shape_sides').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_door_shape_sides:$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});
					}); */
					</script>
				</td>				
			</tr>
			<tr style="background: #d4eed1;">
				<td class="border border-success p-2 text-center">
					<b><?php
					//Entrance door - color
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1567","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1567","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1567","x-texts")['text'];
						echo $text;
					}?></b><br>
					<select id="door_color" name="door_color" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details"> 
						<option value="">None</option>
						<?php
						$door_color=$domenia2->get_color($o_desc_allproducts['door_color']);
						
						for($i=0;$i<count($allcolors);$i++)
						{
                            if(($allcolors[$i]['col_id']=="col_7016")||($allcolors[$i]['col_id']=="col_0001")||($allcolors[$i]['col_id']=="col_8007")||($allcolors[$i]['col_id']=="clp_9999"))
                            {
						?>
						<option value="<?php echo $allcolors[$i]['col_id'];	?>" <?php echo ($allcolors[$i]['col_id']==$door_color['col_id'])?"selected":"";?>><?php echo $allcolors[$i]['col_name_db'];?></option>
                        <?php
                            }							
                        }
                        ?>
                        <option value="" style="font-style:bold;">--------------------------</option>
                        <?php
                        for($i=0;$i<count($allcolors);$i++)
						{
                            if((($allcolors[$i]['col_id']!="col_7016")&&($allcolors[$i]['col_id']!="col_0001")&&($allcolors[$i]['col_id']!="col_8007")&&($allcolors[$i]['col_id']!="clp_9999"))&&(!empty($allcolors[$i]['col_name_db'])))
                            {
						?>
						<option value="<?php echo $allcolors[$i]['col_id'];	?>" <?php echo ($allcolors[$i]['col_id']==$door_color['col_id'])?"selected":"";?>><?php echo $allcolors[$i]['col_name_db'];?></option>
                        <?php
                            }							
						}
						?>
					</select>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Garage/Carport:
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1569","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1569","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1569","x-texts")['text'];
						echo $text;
					}?></b><br>
					<?php 
					$all_garage=$domenia2->get_all_garage();
					?>
					<select id="gc_id" name="gc_id" class="form-control form-control-sm mb-1" <?php
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option>None</option>
						<?php
						for($i=0;$i<count($all_garage);$i++)
						{
						?>
						<option value="<?php echo $all_garage[$i]['cp_id'];	?>" <?php echo ($all_garage[$i]['cp_id']==$o_desc_allproducts['gc_id'])?"selected":"";?>><?php //echo $all_garage[$i]['cp_name_db'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$all_garage[$i]['cp_name_world'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$all_garage[$i]['cp_name_world'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$all_garage[$i]['cp_name_world'],"x-texts")['text'];
							echo $text;
						}
						?></option>
						<?php							
						}
						?>
					</select>
                    <input type="text" id="garage_size" name="garage_size" class="form-control form-control-sm" value="<?php echo $o_desc_allproducts['gc_length']."m ".$o_desc_allproducts['gc_width']."m";?>" <?php if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
					<!-- <select id="garage_size" name="garage_size" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="">None</option>
						<option value="3x6" <?php 
						if(($o_desc_allproducts['gc_length']==3)&&($o_desc_allproducts['gc_width']==6)){echo "selected";}?>>3 m x 6 m</option>
						<option value="6x6" <?php 
						if(($o_desc_allproducts['gc_length']==6)&&($o_desc_allproducts['gc_width']==6)){echo "selected";}?>>6 m x 6 m</option>
						<option value="6x9" <?php 
						if(($o_desc_allproducts['gc_length']==6)&&($o_desc_allproducts['gc_width']==9)){echo "selected";}?>>6 m x 9 m</option>
						
					</select> -->
                    <script type="text/javascript">
					/*$(document).ready(function() {
					$('#b5_garage_size').on("change",function(){	
						$.ajax({
						url: "../ajax/acceptance.php",
						method: "get",
						data: {o_id:<?php echo $o_id;?>,b5_garage_size:$(this).val()},
						dataType:"html",
						success:function(data) {
							console.log(data);										
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						  }
						
						});
					});
					}); */
					</script>
				</td>
				<td class="border border-success p-2 text-center">
					<b><?php
					//Environment
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"tx_1570","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"tx_1570","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"tx_1570","x-texts")['text'];
						echo $text;
					}?></b><br>
					<select id="environment" name="environment" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="">None</option>
						<?php
						
						$all_environment_pictures=$domenia2->get_all_plot_pictures();
						
						for($i=0;$i<count($all_environment_pictures);$i++)
						{							
						?>
						<option value="<?php echo $all_environment_pictures[$i]['pbp_id'];?>" <?php echo ($all_environment_pictures[$i]['pbp_id']==$o_desc_allproducts['pbp_id'])?"selected":"";?>><?php //echo $all_environment_pictures[$i]['pbp_look_db'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$all_environment_pictures[$i]['pbp_look_world'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$all_environment_pictures[$i]['pbp_look_world'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$all_environment_pictures[$i]['pbp_look_world'],"x-texts")['text'];
							echo $text;
						}
						?></option>
						<?php							
						}
						?>
					</select>	
				</td>
                <td class="border border-success p-2 text-center">
					<b><?php
					//Gutters
					if(isset($selected_lang))
					{
						$text=$domenia->get_translation_text($selected_lang,"cm_008","x-texts")['text'];
						if(!empty($text))
						{
							echo $text;
						}
						else
						{
							$text=$domenia->get_translation_text(1,"cm_008","x-texts")['text'];
							echo $text;
						}
					}
					else
					{
						$text=$domenia->get_translation_text(1,"cm_008","x-texts")['text'];
						echo $text;
					}?></b><br>
					<select id="gutter" name="gutter" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="">None</option>
						<?php
						
						$all_gutters=$domenia2->get_all_gutters();
						
						for($i=0;$i<count($all_gutters);$i++)
						{							
						?>
						<option value="<?php echo $all_gutters[$i]['gut_id'];?>" <?php echo ($all_gutters[$i]['gut_id']==$o_desc_allproducts['gutter'])?"selected":"";?>><?php //echo $all_gutters[$i]['pbp_look_db'];
						if(isset($selected_lang))
						{
							$text=$domenia->get_translation_text($selected_lang,$all_gutters[$i]['gut_id'],"x-texts")['text'];
							if(!empty($text))
							{
								echo $text;
							}
							else
							{
								$text=$domenia->get_translation_text(1,$all_gutters[$i]['gut_id'],"x-texts")['text'];
								echo $text;
							}
						}
						else
						{
							$text=$domenia->get_translation_text(1,$all_gutters[$i]['gut_id'],"x-texts")['text'];
							echo $text;
						}
						?></option>
						<?php							
						}
						?>
					</select>	
				</td>
                <td class="border border-success p-2 text-center">
                    <b>Photovoltaic</b>
                    <select id="photovoltaic" name="photovoltaic" class="form-control form-control-sm" <?php 
					if(($_COOKIE['contracting'])<1){echo "disabled";}
					?> form="order_details">
						<option value="">None</option>						
						<option value="1" <?php echo (1==$o_desc_allproducts['photovoltaic'])?"selected":"";?>>Yes</option>
						<option value="0" <?php echo (0==$o_desc_allproducts['photovoltaic'])?"selected":"";?>>No</option>
					</select>
                </td>
			</tr>
		</table>
	</div>
</div>

			<br>
			<div class="col-md-12 border-top border-dark py-3 px-0">
			<?php
			if(!empty($b3_ex_products))
			{
				?>	
                <div class="row mx-0 w-100 justify-content-center pt-3" id="b3extopen">
					<!-- <p class="d-inline">This client has not chosen a b3 exterior product. </p> -->
					<p class="d-inline pl-4 mb-0"> Do you want to add a b3 product? <button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb3" data-toggle="collapse" id="b3extbtnopen">Add</button></p>
				</div>
				<div class="collapse" id="exteriorb3">
                    <div class="row w-100 mx-0">
                    <?php
                    $b3_ex_lines=ceil(count($b3_ex_products) / $columns);
                    $counter=1;
                    for($i=0;$i<count($b3_ex_products);$i++)
                    {
                        if(!empty($b3_ex_products[$i]))
                        {
                            $product=$prod->get_product($b3_ex_products[$i]);
                            if($order['payment_way']==9)
                            {
                                $product_price=$prod->calculateProductAPU($b3_ex_products[$i]);
                            }
                            else
                            {
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b3_ex_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b3_ex_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b3_ex_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b3_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?>">
                                    <input class="products product_ex_b3 checkbox" type="checkbox" name="<?php echo $b3_ex_products[$i]; ?>" id="<?php echo $b3_ex_products[$i]; ?>" value="<?php echo $b3_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b3_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                    //echo $product_price." ".$currency; 
                                    echo $product_apu." APE";?></label>					
                                    <input type="hidden" id="product_<?php echo $b3_ex_products[$i];?>_price" name="product_<?php echo $b3_ex_products[$i];?>_price" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "prices_ex_b3";
                                        }
                                    }
                                    ?>" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b3_ex_products[$i];?>_apu" name="product_<?php echo $b3_ex_products[$i];?>_apu" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "apus_ex_b3";
                                        }
                                    }
                                    ?>" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b3_ex_products[$i];?>_labc" name="product_<?php echo $b3_ex_products[$i];?>_labc" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "labcs_ex_b3";
                                        }
                                    }
                                    ?>" value="<?php echo $product_labc; ?>"> 
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b3_ex_lines==0)&&($counter>0))
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
                <?php
                }
                ?>
                <?php
                
                if(count($b3_ex_products)>0)
                {
                ?>
                <div class="row form-inline w-100 mx-0 border-bottom border-dark">
                    <b>Employee-Producer: Col EX B3 = </b>
                    <input type="text" class="form-control form-control-sm" name="col_labc_ex_b3" id="col_labc_ex_b3" value="" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b3 = </b>
                    <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b3" id="fac_labc_ex_b3" value="<?php echo ($order['fac_labc_ex_b3']!=0)?$order['fac_labc_ex_b3']:"1";?>" form="order_details" style="width:5em"> 
                    <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="ex_b3_col_amount3" id="ex_b3_col_amount3" form="order_details" value="<?php echo $plans_amount;?>" style="width:5em">
                    <b> = </b> <input type="text" class="form-control form-control-sm" name="total_ex_b3_labcs" id="total_ex_b3_labcs" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                </div>
                <div class="row form-inline">
                    <b>Producer-Trader: Col EX B3 = </b>
                    <input type="text" class="form-control form-control-sm" name="col_apus_ex_b3" id="col_apus_ex_b3" value="<?php echo $order['col_apus_ex_b3'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b3 = </b>
                    <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b3" id="fac_prod_ex_b3" value="<?php echo $order['fac_prod_ex_b3'];?>" form="order_details" style="width:5em" > 
                    <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="ex_b3_col_amount1" id="ex_b3_col_amount1" form="order_details" value="<?php echo $plans_amount;?>" style="width:5em" >
                    <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b3" id="o_apus_ex_b3" value="<?php echo $order['o_apus_ex_b3'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                </div>			
                <div class="row form-inline">
                    <b>Trader-Purchaser: Col EX B3 = </b>
                    <input class="form-control form-control-sm" type="text" name="col_price_ex_b3" id="col_price_ex_b3" value="<?php echo $order['col_price_ex_b3']; ?>" form="order_details" style="width:5em" > 
                    <b><?php echo $currency; ?> X fac_client_ex_b3 = </b> 
                    <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b3" id="fac_cl_ex_b3" value="<?php echo $order['fac_cl_ex_b3'];?>" form="order_details" style="width:5em" > 
                    <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="b5_col_amount2" id="b5_col_amount2" form="order_details" value="<?php echo $plans_amount;?>" style="width:5em" > 
                    <b>=</b> 
                    <input type="text" class="form-control form-control-sm" name="o_price_ex_b3" id="o_price_ex_b3" value="<?php echo $order['o_price_ex_b3']; ?>" form="order_details" style="width:5em">
                    <b><?php echo $currency; ?></b>			
                    <br ><br >
                </div>
                
                <br><br>
                <?php
                }
                ?>
            </div>
           

            <?php

            //start b1 ex 
			 
			if(count($b1_ex_products)>0)
			{
                $o_desc_ex_b1=$prod->get_o_desc_ex_b1($o_id);
				?>
                <div class="row mx-0 w-100 justify-content-center pt-3" id="b1extopen" style="background-color:#c2f1c6;">
					<!-- <p class="d-inline">This client has not chosen a b1 exterior product. </p> -->
					<p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb1" data-toggle="collapse" id="b1extbtnopen">B1 exterior</button></p>
				</div>
				<div class="collapse <?php
                if((strpos($order['collection'], 'p1163') !== false)||
                (strpos($order['collection'], 'p116b') !== false)||
                (strpos($order['collection'], 'p116m') !== false)||
                (strpos($order['collection'], 'p116t') !== false)||
                (strpos($order['collection'], 'p118s') !== false)
                )
                {
                    echo "show";
                }?>" id="exteriorb1" style="background-color:#c2f1c6;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b1_ex_columns=3;
                    $b1_ex_lines=ceil(3 / $b1_ex_columns);
                    $counter=1;
                    for($i=0;$i<count($b1_ex_products);$i++)
                    {
                        if(!empty($b1_ex_products[$i]))
                        {
                            $product=$prod->get_product($b1_ex_products[$i]);
                            if($order['payment_way']==9)
                            {
                                $product_price=$prod->calculateProductAPU($b1_ex_products[$i]);
                            }
                            else
                            {
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b1_ex_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b1_ex_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b1_ex_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b1_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?>">
                                    <input class="products product_ex_b1 checkbox mr-2" type="checkbox" name="<?php echo $b1_ex_products[$i]; ?>" id="<?php echo $b1_ex_products[$i]; ?>" value="<?php echo $b1_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b1_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b1_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                    //echo $product_price." ".$currency; 
                                    echo $product_apu." APE";?></label>					
                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_price" name="product_<?php echo $b1_ex_products[$i];?>_price" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b1_ex_products[$i]==$collection[$j])
                                        {
                                            echo "prices_ex_b1";
                                        }
                                    }
                                    ?>" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_apu" name="product_<?php echo $b1_ex_products[$i];?>_apu" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b1_ex_products[$i]==$collection[$j])
                                        {
                                            echo "apus_ex_b1";
                                        }
                                    }
                                    ?>" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_labc" name="product_<?php echo $b1_ex_products[$i];?>_labc" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b1_ex_products[$i]==$collection[$j])
                                        {
                                            echo "labcs_ex_b1";
                                        }
                                    }
                                    ?>" value="<?php echo $product_labc; ?>">

                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <?php
                                    if(($b1_ex_products[$i]=="p1163")||($b1_ex_products[$i]=="p1166")||($b1_ex_products[$i]=="p1168")||
                                    ($b1_ex_products[$i]=="p116b")||($b1_ex_products[$i]=="p116m")||($b1_ex_products[$i]=="p116t")||($b1_ex_products[$i]=="p118s"))
                                    {
                                    ?>
                                    <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b1_ex_multiplicator" form="order_details" id="<?php echo $b1_ex_products[$i]; ?>_fac" name="<?php echo $b1_ex_products[$i]; ?>_fac" value="<?php 
                                    echo (!empty($o_desc_ex_b1[$b1_ex_products[$i]."_fac"]))?$o_desc_ex_b1[$b1_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                    <?php
                                    }                                    
                                    ?>
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b1_ex_lines==0)&&($counter>0))
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
                <?php
                
                if(count($b1_ex_products)>0)
                {
                    $o_desc_ex_b1=$prod->get_o_desc_ex_b1($o_id);
                ?>
                <div class="row form-inline w-100 mx-0 border-bottom border-dark">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Employee-Producer: Col EX B1 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b1" id="col_labc_ex_b1" value="<?php echo (!empty($o_desc_ex_b1['col_labc_ex_b1']))?$o_desc_ex_b1['col_labc_ex_b1']:"1";?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b1 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b1" id="fac_labc_ex_b1" value="<?php echo (!empty($o_desc_ex_b1['fac_labc_ex_b1']))?$o_desc_ex_b1['fac_labc_ex_b1']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b1" id="col_amount3_ex_b1" form="order_details" value="<?php echo (!empty($o_desc_ex_b1['col_amount_ex_b1']))?$o_desc_ex_b1['col_amount_ex_b1']:"1";?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b1" id="total_labcs_ex_b1" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Producer-Trader: Col EX B1 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b1" id="col_apus_ex_b1" value="<?php echo (!empty($o_desc_ex_b1['col_apus_ex_b1']))?$o_desc_ex_b1['col_apus_ex_b1']:"1";?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b1 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b1" id="fac_prod_ex_b1" value="<?php echo (!empty($o_desc_ex_b1['fac_prod_ex_b1']))?$o_desc_ex_b1['fac_prod_ex_b1']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b1" id="col_amount2_ex_b1" form="order_details" value="<?php echo (!empty($o_desc_ex_b1['col_amount_ex_b1']))?$o_desc_ex_b1['col_amount_ex_b1']:"1";?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b1" id="o_apus_ex_b1" value="<?php echo $o_desc_ex_b1['o_apus_ex_b1'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Trader-Purchaser: Col EX B1 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b1" id="col_price_ex_b1" value="<?php echo (!empty($o_desc_ex_b1['col_price_ex_b1']))?$o_desc_ex_b1['col_price_ex_b1']:"1"; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b1 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b1" id="fac_cl_ex_b1" value="<?php echo (!empty($o_desc_ex_b1['fac_cl_ex_b1']))?$o_desc_ex_b1['fac_cl_ex_b1']:"1";?>" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b1" id="col_amount1_ex_b1" form="order_details" value="<?php echo (!empty($o_desc_ex_b1['col_amount_ex_b1']))?$o_desc_ex_b1['col_amount_ex_b1']:"1";?>" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b1" id="o_price_ex_b1" value="<?php echo $o_desc_ex_b1['o_price_ex_b1']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b1" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b1" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                </div>
                <?php 
                
            }


			//start b5 ex 
			 
			if(count($b5_ex_products)>0)
			{
				?>
                <div class="row mx-0 w-100 justify-content-center pt-3" id="b5extopen" style="background-color:#94ce99;">
					<!-- <p class="d-inline">This client has not chosen a b5 exterior product. </p> -->
					<p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb5" data-toggle="collapse" id="b5extbtnopen">B5 exterior - Skp/V-Ray</button></p>
				</div>
				<div class="collapse <?php
                if (strpos($order['collection'], 'p1561') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb5" style="background-color:#94ce99;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b5_ex_columns=3;
                    $b5_ex_lines=ceil(3 / $b5_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b5_ex_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b5_ex_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b5_ex_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4 text-left">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b5_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b5 checkbox mr-2" type="checkbox" name="<?php echo $b5_ex_products[$i]; ?>" id="<?php echo $b5_ex_products[$i]; ?>" value="<?php echo $b5_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b5_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b5_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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

                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php 
                                            //echo $product_price." ".$currency; 
                                            echo $product_apu." APE";?>
                                            <?php
                                            if(($b5_ex_products[$i]=="p1561")||($b5_ex_products[$i]=="p1566"))
                                            {
                                            ?>
                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_ex_multiplicator" form="order_details" id="<?php echo $b5_ex_products[$i]; ?>_fac" name="<?php echo $b5_ex_products[$i]; ?>_fac" value="<?php 
                                            echo ($o_desc_ex_b5[$b5_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b5[$b5_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                            = <div id="<?php echo $b5_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b5[$b5_ex_products[$i]."_fac"]; ?></div>
                                            <?php
                                            }
                                            if($b5_ex_products[$i]=="p1581")
                                            {
                                            ?>
                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_ex_multiplicator" form="order_details" id="<?php echo $b5_ex_products[$i]; ?>_fac" name="<?php echo $b5_ex_products[$i]; ?>_fac" value="<?php 
                                            echo ($o_desc_ex_b5[$b5_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b5[$b5_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                            = <div id="<?php echo $b5_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b5[$b5_ex_products[$i]."_fac"]; ?></div>
                                            <?php
                                            }
                                            if($b5_ex_products[$i]=="p1563")
                                            {
                                            ?>
                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_ex_multiplicator" form="order_details" id="<?php echo $b5_ex_products[$i]; ?>_fac" name="<?php echo $b5_ex_products[$i]; ?>_fac" value="<?php 
                                            echo ($o_desc_ex_b5[$b5_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b5[$b5_ex_products[$i]."_fac"]:"3";?>" style="width:3em;" title="Multiplicator">
                                            = <div id="<?php echo $b5_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b5[$b5_ex_products[$i]."_fac"]; ?></div>
                                            <?php
                                            }
                                            ?> 
                                        </div>
                                    </div>
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b5_ex_lines==0)&&($counter>0))
                            {
                                ?>
                                </div>
                                <div class="col-md-4 text-left">
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
                <?php
                
                if(count($b5_ex_products)>0)
                {
                ?>
                <div class="row form-inline w-100 mx-0 border-bottom border-dark">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Employee-Producer: Col EX B5 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b5" id="col_labc_ex_b5" value="<?php echo $o_desc_ex_b5['col_labc_ex_b5'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b5 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b5" id="fac_labc_ex_b5" value="<?php echo $o_desc_ex_b5['fac_labc_ex_b5'];/*echo ($o_desc_ex_b5['fac_labc_ex_b5']!=0)?$o_desc_ex_b5['fac_labc_ex_b5']:"1";*/?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b5" id="col_amount3_ex_b5" form="order_details" value="<?php echo $o_desc_ex_b5['col_amount_ex_b5'];?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b5" id="total_labcs_ex_b5" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Producer-Trader: Col EX B5 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b5" id="col_apus_ex_b5" value="<?php echo $o_desc_ex_b5['col_apus_ex_b5'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b5 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b5" id="fac_prod_ex_b5" value="<?php echo $o_desc_ex_b5['fac_prod_ex_b5'];/*echo (!empty($o_desc_ex_b5['fac_prod_ex_b5']))?$o_desc_ex_b5['fac_prod_ex_b5']:"1";*/?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b5" id="col_amount2_ex_b5" form="order_details" value="<?php echo $o_desc_ex_b5['col_amount_ex_b5'];?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b5" id="o_apus_ex_b5" value="<?php echo $o_desc_ex_b5['o_apus_ex_b5'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Trader-Purchaser: Col EX B5 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b5" id="col_price_ex_b5" value="<?php echo $o_desc_ex_b5['col_price_ex_b5']; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b5 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b5" id="fac_cl_ex_b5" value="<?php echo $o_desc_ex_b5['fac_cl_ex_b5'];/*echo (!empty($o_desc_ex_b5['fac_cl_ex_b5']))?$o_desc_ex_b5['fac_cl_ex_b5']:"1";*/?>" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b5" id="col_amount1_ex_b5" form="order_details" value="<?php echo $o_desc_ex_b5['col_amount_ex_b5'];?>" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b5" id="o_price_ex_b5" value="<?php echo $o_desc_ex_b5['o_price_ex_b5']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['environment_address']); ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                </div>
                <?php 
                
            }
            
			
            ?>
                <div class="row mx-0 w-100 justify-content-center pt-3"  id="b6extopen" style="background-color:#94ce99;">
                    <!-- <p class="d-inline">This client has not chosen a b7 exterior product. </p> -->
                    <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb6" data-toggle="collapse" id="b6extbtnopen">B6 exterior - Twinmotion</button></p>
                </div>
            <?php
            //start b6 ex

            if(count($b6_ex_products)>0)
			{
                ?>
				<div class="collapse <?php
                if (strpos($order['collection'], 'p1661') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb6" style="background-color:#94ce99;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b6_ex_columns=3;
                    //$b6_ex_lines=ceil(count($b6_ex_products) / $b6_ex_columns);
                    $b6_ex_lines=ceil(3 / $b6_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b6_ex_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b6_ex_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b6_ex_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4 text-left">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b6_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b6 checkbox mr-2" type="checkbox" name="<?php echo $b6_ex_products[$i]; ?>" id="<?php echo $b6_ex_products[$i]; ?>" value="<?php echo $b6_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b6_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b6_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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
                                    
                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php                                             
                                            echo $product_apu." APE"; ?>
                                            <?php
                                            if(($b6_ex_products[$i]=="p1661")||($b6_ex_products[$i]=="p1663")||($b6_ex_products[$i]=="p1666")||($b6_ex_products[$i]=="p1681")||($b6_ex_products[$i]=="p166p"))
                                            {
                                            ?>
                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b6_ex_multiplicator" form="order_details" id="<?php echo $b6_ex_products[$i]; ?>_fac" name="<?php echo $b6_ex_products[$i]; ?>_fac" value="<?php 
                                            echo (!empty($o_desc_ex_b6[$b6_ex_products[$i]."_fac"]))?$o_desc_ex_b6[$b6_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                            = <div id="<?php echo $b6_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b6[$b6_ex_products[$i]."_fac"]; ?></div>
                                            <?php
                                            }
                                            ?> 
                                        </div>
                                    </div>
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b6_ex_lines==0)&&($counter>0))
                            {
                                ?>
                                </div>
                                <div class="col-md-4 text-left">
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
                <?php
                if(count($b6_ex_products)>0)
                {
                ?>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Employee-Producer: Col EX B6 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b6" id="col_labc_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['col_labc_ex_b6']))?$o_desc_ex_b6['col_labc_ex_b6']:"1";?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b6 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b6" id="fac_labc_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_labc_ex_b6']))?$o_desc_ex_b6['fac_labc_ex_b6']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b6" id="col_amount3_ex_b6" form="order_details" value="<?php echo (!empty($o_desc_ex_b6['col_amount_ex_b6']))?$o_desc_ex_b6['col_amount_ex_b6']:"1";?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b6" id="total_labcs_ex_b6" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Producer-Trader: Col EX B6 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b6" id="col_apus_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['col_apus_ex_b6']))?$o_desc_ex_b6['col_apus_ex_b6']:"1";?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b6 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b6" id="fac_prod_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_prod_ex_b6']))?$o_desc_ex_b6['fac_prod_ex_b6']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b6" id="col_amount2_ex_b6" form="order_details" value="<?php echo (!empty($o_desc_ex_b6['col_amount_ex_b6']))?$o_desc_ex_b6['col_amount_ex_b6']:"1";?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b6" id="o_apus_ex_b6" value="<?php echo $o_desc_ex_b6['o_apus_ex_b6'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Trader-Purchaser: Col EX B6 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b6" id="col_price_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['col_price_ex_b6']))?$o_desc_ex_b6['col_price_ex_b6']:"1"; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b6 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b6" id="fac_cl_ex_b6" value="<?php echo (!empty($o_desc_ex_b6['fac_cl_ex_b6']))?$o_desc_ex_b6['fac_cl_ex_b6']:"1";?>" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b6" id="col_amount1_ex_b6" form="order_details" value="<?php echo (!empty($o_desc_ex_b6['col_amount_ex_b6']))?$o_desc_ex_b6['col_amount_ex_b6']:"1";?>" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b6" id="o_price_ex_b6" value="<?php echo $o_desc_ex_b6['o_price_ex_b6']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                </div>
                <?php 
                
            }
            ?>
            <div class="row mx-0 w-100 justify-content-center pt-3"  id="b7extopen" style="background-color:#6aa36f;">
                <!-- <p class="d-inline">This client has not chosen a b7 exterior product. </p> -->
                <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb7" data-toggle="collapse" id="b7extbtnopen">B7 exterior - 3ds Max</button></p>
            </div>

            <?php
             //start b7 ex 
			if(count($b7_ex_products)>0)
			{
				?>
                
				<div class="collapse <?php
                if (strpos($order['collection'], 'p1761') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb7" style="background-color:#6aa36f;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b7_ex_columns=3;
                    $b7_ex_lines=ceil(3 / $b7_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b7_ex_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b7_ex_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b7_ex_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4 text-left">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b7_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b7 checkbox mr-2" type="checkbox" name="<?php echo $b7_ex_products[$i]; ?>" id="<?php echo $b7_ex_products[$i]; ?>" value="<?php echo $b7_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b7_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b7_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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

                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php 
                                            //echo $product_price." ".$currency; 
                                            echo $product_apu." APE";?>
                                            <?php
                                            if(($b7_ex_products[$i]=="p1761")||($b7_ex_products[$i]=="p1763")||($b7_ex_products[$i]=="p1766")||($b7_ex_products[$i]=="p1781"))
                                            {
                                                ?>
                                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b7_ex_multiplicator" form="order_details" id="<?php echo $b7_ex_products[$i]; ?>_fac" name="<?php echo $b7_ex_products[$i]; ?>_fac" value="<?php 
                                                echo (!empty($o_desc_ex_b7[$b7_ex_products[$i]."_fac"]))?$o_desc_ex_b7[$b7_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                                = <div id="<?php echo $b7_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b7[$b7_ex_products[$i]."_fac"]; ?></div>
                                                <?php
                                            }
                                            ?> 
                                        </div>
                                    </div>
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b7_ex_lines==0)&&($counter>0))
                            {
                                ?>
                                </div>
                                <div class="col-md-4 text-left">
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
                //$plans_amount=$order['b5_col_amount'];
                ?>
               
                
                <?php
                if(count($b7_ex_products)>0)
                {
                ?>
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Employee-Producer: Col EX B7 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b7" id="col_labc_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['col_labc_ex_b7']))?$o_desc_ex_b7['col_labc_ex_b7']:"1";?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b7 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b7" id="fac_labc_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_labc_ex_b7']))?$o_desc_ex_b7['fac_labc_ex_b7']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b7" id="col_amount3_ex_b7" form="order_details" value="<?php echo (!empty($o_desc_ex_b7['col_amount_ex_b7']))?$o_desc_ex_b7['col_amount_ex_b7']:"1";?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b7" id="total_labcs_ex_b7" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                        </div>
                </div>
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Producer-Trader: Col EX B7 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b7" id="col_apus_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['col_apus_ex_b7']))?$o_desc_ex_b7['col_apus_ex_b7']:"1";?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b7 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b7" id="fac_prod_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_prod_ex_b7']))?$o_desc_ex_b7['fac_prod_ex_b7']:"1";?>" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b7" id="col_amount2_ex_b7" form="order_details" value="<?php echo (!empty($o_desc_ex_b7['col_amount_ex_b7']))?$o_desc_ex_b7['col_amount_ex_b7']:"1";?>" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b7" id="o_apus_ex_b7" value="<?php echo $o_desc_ex_b7['o_apus_ex_b7'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Trader-Purchaser: Col EX B7 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b7" id="col_price_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['col_price_ex_b7']))?$o_desc_ex_b7['col_price_ex_b7']:"1"; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b7 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b7" id="fac_cl_ex_b7" value="<?php echo (!empty($o_desc_ex_b7['fac_cl_ex_b7']))?$o_desc_ex_b7['fac_cl_ex_b7']:"1";?>" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b7" id="col_amount1_ex_b7" form="order_details" value="<?php echo (!empty($o_desc_ex_b7['col_amount_ex_b7']))?$o_desc_ex_b7['col_amount_ex_b7']:"1";?>" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b7" id="o_price_ex_b7" value="<?php echo $o_desc_ex_b7['o_price_ex_b7']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                        
                    <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                    </div>
				
			<?php 
            }
            ?>
            <div class="row mx-0 w-100 justify-content-center pt-3"  id="b8extopen" style="background-color:#6aa36f;">
                <!-- <p class="d-inline">This client has not chosen a b8 exterior product. </p> -->
                <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb8" data-toggle="collapse" id="b8extbtnopen">B8 exterior - Lumion</button></p>
            </div>
            <?php

             //start b8 ex 
			if(count($b8_ex_products)>0)
			{
				?>
                
                <div class="collapse <?php 
                if (strpos($order['collection'], 'p1861') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb8" style="background-color:#6aa36f;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b8_ex_columns=3;
                    // $b8_ex_lines=ceil(count($b8_ex_products) / $b8_ex_columns);
                    $b8_ex_lines=ceil(3 / $b8_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b8_ex_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b8_ex_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b8_ex_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4 text-left">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b8_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b8 checkbox mr-2" type="checkbox" name="<?php echo $b8_ex_products[$i]; ?>" id="<?php echo $b8_ex_products[$i]; ?>" value="<?php echo $b8_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b8_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b8_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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

                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php                                     
                                            echo $product_apu." APE"; ?>
                                            <?php
                                            if(($b8_ex_products[$i]=="p1861")||($b8_ex_products[$i]=="p1863")||($b8_ex_products[$i]=="p1866")||($b8_ex_products[$i]=="p1881"))
                                            {
                                                ?>
                                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b8_ex_multiplicator" form="order_details" id="<?php echo $b8_ex_products[$i]; ?>_fac" name="<?php echo $b8_ex_products[$i]; ?>_fac" value="<?php echo ($o_desc_ex_b8[$b8_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b8[$b8_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                                = <div id="<?php echo $b8_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b8[$b8_ex_products[$i]."_fac"]; ?></div>
                                                <?php
                                            }
                                            ?>  
                                        </div>
                                    </div>
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b8_ex_lines==0)&&($counter>0))
                            {
                                ?>
                                </div>
                                <div class="col-md-4 text-left">
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
                //$plans_amount=$order['b5_col_amount'];
                ?>
               
                
                <?php
                if(count($b8_ex_products)>0)
                {
                    ?>
                    <div class="row form-inline">
                        <div class="col-md-12">
                            <b>Employee-Producer: Col EX B8 = </b>
                            <input type="text" class="form-control form-control-sm" name="col_labc_ex_b8" id="col_labc_ex_b8" value="<?php echo $o_desc_ex_b8['col_labc_ex_b8'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b8 = </b>
                            <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b8" id="fac_labc_ex_b8" value="<?php echo $o_desc_ex_b8['fac_labc_ex_b8'];/*echo ($o_desc_ex_b8['fac_labc_ex_b8']!=0)?$o_desc_ex_b8['fac_labc_ex_b8']:"1";*/?>" form="order_details" style="width:5em"> 
                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b8" id="col_amount3_ex_b8" form="order_details" value="<?php echo $o_desc_ex_b8['col_amount_ex_b8'];?>" style="width:5em">
                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b8" id="total_labcs_ex_b8" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                            </div>
                    </div>
                    <div class="row form-inline">
                        <div class="col-md-12">
                            <b>Producer-Trader: Col EX B8 = </b>
                            <input type="text" class="form-control form-control-sm" name="col_apus_ex_b8" id="col_apus_ex_b8" value="<?php echo $o_desc_ex_b8['col_apus_ex_b8'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b8 = </b>
                            <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b8" id="fac_prod_ex_b8" value="<?php echo $o_desc_ex_b8['fac_prod_ex_b8'];/*echo (!empty($o_desc_ex_b8['fac_prod_ex_b8']))?$o_desc_ex_b8['fac_prod_ex_b8']:"1";*/?>" form="order_details" style="width:5em"> 
                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b8" id="col_amount2_ex_b8" form="order_details" value="<?php echo $o_desc_ex_b8['col_amount_ex_b8'];?>" style="width:5em">
                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b8" id="o_apus_ex_b8" value="<?php echo $o_desc_ex_b8['o_apus_ex_b8'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                        </div>
                    </div>			
                    <div class="row form-inline">
                        <div class="col-md-12">
                            <b>Trader-Purchaser: Col EX B8 = </b>
                            <input class="form-control form-control-sm" type="text" name="col_price_ex_b8" id="col_price_ex_b8" value="<?php echo $o_desc_ex_b8['col_price_ex_b8']; ?>" form="order_details" style="width:5em"> 
                            <b><?php echo $currency; ?> X fac_client_ex_b8 = </b> 
                            <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b8" id="fac_cl_ex_b8" value="<?php echo $o_desc_ex_b8['fac_cl_ex_b8'];?>" form="order_details" style="width:5em"> 
                            <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b8" id="col_amount1_ex_b8" form="order_details" value="<?php echo $o_desc_ex_b8['col_amount_ex_b8'];?>" style="width:5em"> 
                            <b>=</b> 
                            <input type="text" class="form-control form-control-sm" name="o_price_ex_b8" id="o_price_ex_b8" value="<?php echo $o_desc_ex_b8['o_price_ex_b8']; ?>" form="order_details" style="width:5em" >
                            <b><?php echo $currency; ?></b>			
                            <br><br>
                        </div>
                    </div>
                            
                        <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                            <div class="col-md-4">
                                <div class="form-group d-inline">
                                    <p><b>Real address for the environment: </b></p>
                                    <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                                </div>
                            </div>	
                            <div class="col-md-4">
                                <div class="form-group d-inline">
                                    <p><b>Customer remarks exterior: </b></p>
                                    <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group d-inline">
                                    <p><b>Operator remarks exterior: </b></p>
                                    <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                                </div>
                            </div>	
                            <a id="customerfiles"></a>
                        </div>
                        </div>
                    <br>
                    <?php 
			    }
			
}
else
{
?>
</div>
<div class="container pagecontent px-0 border-top-0 pt-3">
<div class="row w-100 mx-0">
    <div class="col-md-12">
        <div class="error">No Exterior</div>
    </div>
</div>
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
        <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="exbtnb5" data-target="#exteriorb5" data-toggle="collapse"><del>B5 exterior - Skp/V-Ray</del></button>
        <br><span class="text-danger">Not for this website</span>
        <?php
        }
        else
        {
        ?>
        <button class="btn btn-sm btn-success text-white px-3 ml-1" id="exbtnb5" data-target="#exteriorb5" data-toggle="collapse">B5 exterior - Skp/V-Ray</button>
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
        <br><span class="text-danger">Not for this website</span>
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
        <br><span class="text-danger">Not for this website</span>
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
        <br><span class="text-danger">Not for this website</span>
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
<hr width="300px" class="bg-secondary">

    <a id="exterior"></a>
   
    <br>
    <div class="row w-100 mx-0">
        <div class="col-md-4 d-flex justify-content-center">
                <p class="d-inline mr-3 mb-0">
                    <b>Amount of exterior subIDs: </b> <!-- exterior does not exists -->
                </p>
                <input type="textbox" name="col_amount0_ex" id="col_amount0_ex" class="form-control form-control-sm" style="width:5em;" value="<?php
                $amount=1;
                if(($o_desc_ex_b5['col_amount_ex_b5']==0)&&($o_desc_ex_b6['col_amount_ex_b6']==0)&&($o_desc_ex_b7['col_amount_ex_b7']==0)&&($o_desc_ex_b8['col_amount_ex_b8']==0))
                {
                    echo "1";
                }
                else
                {               
                    if($o_desc_ex_b5['col_amount_ex_b5']>0)
                    {
                        echo $o_desc_ex_b5['col_amount_ex_b5'];
                        $amount++;
                    }
                    if($amount==1)
                    {
                        if($o_desc_ex_b6['col_amount_ex_b6']>0)
                        {
                            echo $o_desc_ex_b6['col_amount_ex_b6'];
                            $amount++;
                        }
                    }
                    if($amount==1)
                    {
                        if($o_desc_ex_b7['col_amount_ex_b7']>0)
                        {
                            echo $o_desc_ex_b7['col_amount_ex_b7'];
                            $amount++;
                        }
                    }
                    if($amount==1)
                    {
                        if($o_desc_ex_b8['col_amount_ex_b8']>0)
                        {
                            echo $o_desc_ex_b8['col_amount_ex_b8'];
                            $amount++;
                        }
                    }
                }?>">
            </div>
            <script type="text/javascript">
                $(document).ready(function(){

                    $.ajax({
                        url: "../ajax/create_orders_subnames_exterior_html.php",
                        method: "post",
                        data: {o_id:<?php echo $o_id;?>,total_exterior_amount:$('#col_amount0_ex').val()},
                        //data:$("interior_osn_form").serialize(),
                        dataType:"html",
                        success:function(data) {
                            $('#exterior_osn_texts').html(data);										
                        }
                    });
                    
                });

                $('#col_amount0_ex').on('focusout',function(){

                    $.ajax({
                        url: "../ajax/create_orders_subnames_exterior_html.php",
                        method: "post",
                        data: {o_id:<?php echo $o_id;?>,total_exterior_amount:$('#col_amount0_ex').val()},
                        //data:$("interior_osn_form").serialize(),
                        dataType:"html",
                        success:function(data) {
                            $('#exterior_osn_texts').html(data);										
                        }
                    });

                });
            </script>
        <div class="col-md-4 text-center">
            <b>Exterior sub names</b>
        </div>
        <div class="col-md-4 text-center">
        </div>
    </div> <!--emd row2 -->
    <div class="row w-100 mx-0">            
        <div class="col-md-12 justify-content-center">
            <div class="row">
                <div class="col-md-12 d-inline" id="exterior_osn_texts">
                    <?php
                    $all_subids=$prod->get_all_subids_by_o_id($o_id);

                    for($i=0;$i<count($all_subids);$i++)
                    {
                        if (strpos($all_subids[$i]['o_sub_id'], 'x') !== false) 
                        {
                            ?>
                            <div class="row">
                            
                                <div class="col-md-1">
                            <?php
                            echo $all_subids[$i]['o_sub_id']."&nbsp;";
                            ?>
                                </div>
                                <div class="col-md-2">
                            <input type="text" list="exterior_subid_list<?php echo $all_subids[$i]['subo_id'];?>" id="subo_id<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" value="<?php echo $all_subids[$i]['subo_name'];?>" placeholder="Name" class="form-control form-control-sm">
                            <datalist id="exterior_subid_list<?php echo $all_subids[$i]['subo_id'];?>">
                                <option value="Außen">
                                <option value="Ansichten">
                            </datalist>
                        <script type="text/javascript">
                        

                        $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                method: "get",
                                data: {
                                    subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                    exterior_subname:$(this).val(),
                                    option:"rename_exterior_osn_file"},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);										
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(xhr.status);
                                    console.log(thrownError);
                                }
                                
                            }); 
                        });
                    
                        </script>
                        </div>
                        <div class="col-md-2">
                            <select  id="object_type<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="form-control form-control-sm">
                                <option value="">--Object type--</option>
                                <?php
                                $all_object_types=$prod->get_all_object_types();
                                for($o=0;$o<count($all_object_types);$o++)
                                {
                                    ?>
                                    <option value="<?php echo $all_object_types[$o]['ot_id'];?>" <?php echo ($all_object_types[$o]['ot_id']==$all_subids[$i]['object_type'])?"selected":"";?>><?php echo $all_object_types[$o]['ot_description'];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $('#object_type<?php echo $all_subids[$i]['subo_id'];?>').on('change',function(){
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                                    method: "get",
                                    data: {
                                        subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                        object_type:$(this).val(),
                                        option:"change_object_type"},
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);										
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                    
                                }); 
                            });
                            </script>
                        </div>
                        <div class="col-md-2">
                            <textarea class="form-control form-control-sm" id="subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" placeholder="Explanation" style="height: 30px;"><?php 
                            echo $all_subids[$i]['subo_more_infos'];?></textarea>
                            <script type="text/javascript">
                            $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_orders_subnames_more_infos.php",
                                    method: "get",
                                    data: {
                                        subo_id: $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                                        exterior_subo_more_infos:$(this).val(),
                                        option:"rename_exterior_more_infos"
                                    },
                                    dataType:"html",
                                    success:function(data) {
                                        console.log(data);										
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                    
                                }); 
                            });
                        </script>
                        </div>
                        
                        </div>
                        <?php
                        }
                    }
                    ?>                              
                </div>
            </div>
        </div>
    </div>
    <br>
    

			<br>
			<div class="col-md-12 border-top border-dark py-3 px-0">
			<?php
			if(count($b3_ex_products)>0)
			{
				?>	
                <!-- <div class="row mx-0 w-100 justify-content-center pt-3" id="b3extopen">
					
					<p class="d-inline pl-4 mb-0"> Do you want to add a b3 product? <button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb3" data-toggle="collapse" id="b3extbtnopen">Add</button></p>
				</div> -->
				<div class="collapse" id="exteriorb3">
                    <div class="row w-100 mx-0">
                    <?php
                    $b3_ex_lines=ceil(count($b3_ex_products) / $columns);
                    $counter=1;
                    for($i=0;$i<count($b3_ex_products);$i++)
                    {
                        if(!empty($b3_ex_products[$i]))
                        {
                            $product=$prod->get_product($b3_ex_products[$i]);
                            if($order['payment_way']==9)
                            {
                                $product_price=$prod->calculateProductAPU($b3_ex_products[$i]);
                            }
                            else
                            {
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b3_ex_products[$i],$cur_factor);
                            }
                            $product_apu=$prod->calculateProductAPU($b3_ex_products[$i]);
                            $product_labc=$prod->calculateProductlabc($b3_ex_products[$i]);
                            
                            if($counter==1)
                            {
                                ?>
                                <div class="col-md-4">
                                <?php
                            }
                            ?>
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b3_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?>">
                                    <input class="products product_ex_b3 checkbox" type="checkbox" name="<?php echo $b3_ex_products[$i]; ?>" id="<?php echo $b3_ex_products[$i]; ?>" value="<?php echo $b3_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b3_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php 
                                    //echo $product_price." ".$currency; 
                                    echo $product_apu." APE";?></label>					
                                    <input type="hidden" id="product_<?php echo $b3_ex_products[$i];?>_price" name="product_<?php echo $b3_ex_products[$i];?>_price" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "prices_ex_b3";
                                        }
                                    }
                                    ?>" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b3_ex_products[$i];?>_apu" name="product_<?php echo $b3_ex_products[$i];?>_apu" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "apus_ex_b3";
                                        }
                                    }
                                    ?>" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b3_ex_products[$i];?>_labc" name="product_<?php echo $b3_ex_products[$i];?>_labc" class="<?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b3_ex_products[$i]==$collection[$j])
                                        {
                                            echo "labcs_ex_b3";
                                        }
                                    }
                                    ?>" value="<?php echo $product_labc; ?>"> 
                                </div>						
                            </div>	
                            <?php
                            if(($counter%$b3_ex_lines==0)&&($counter>0))
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
                <?php
                }
                ?>
                <?php
                
                if(count($b3_ex_products)>0)
                {
                ?>
                <div class="row form-inline w-100 mx-0 border-bottom border-dark">
                    <b>Employee-Producer: Col EX B3 = </b>
                    <input type="text" class="form-control form-control-sm" name="col_labc_ex_b3" id="col_labc_ex_b3" value="" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b3 = </b>
                    <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b3" id="fac_labc_ex_b3" value="1" form="order_details" style="width:5em"> 
                    <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="ex_b3_col_amount3" id="ex_b3_col_amount3" form="order_details" value="<?php echo $plans_amount;?>" style="width:5em">
                    <b> = </b> <input type="text" class="form-control form-control-sm" name="total_ex_b3_labcs" id="total_ex_b3_labcs" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                </div>
                <div class="row form-inline">
                    <b>Producer-Trader: Col EX B3 = </b>
                    <input type="text" class="form-control form-control-sm" name="col_apus_ex_b3" id="col_apus_ex_b3" value="<?php echo $order['col_apus_ex_b3'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b3 = </b>
                    <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b3" id="fac_prod_ex_b3" value="1" form="order_details" style="width:5em" > 
                    <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="ex_b3_col_amount1" id="ex_b3_col_amount1" form="order_details" value="<?php echo $plans_amount;?>" style="width:5em" >
                    <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b3" id="o_apus_ex_b3" value="<?php echo $order['o_apus_ex_b3'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                </div>			
                <div class="row form-inline">
                    <b>Trader-Purchaser: Col EX B3 = </b>
                    <input class="form-control form-control-sm" type="text" name="col_price_ex_b3" id="col_price_ex_b3" value="<?php echo $order['col_price_ex_b3']; ?>" form="order_details" style="width:5em" > 
                    <b><?php echo $currency; ?> X fac_client_ex_b3 = </b> 
                    <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b3" id="fac_cl_ex_b3" value="1" form="order_details" style="width:5em" > 
                    <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="b5_col_amount2" id="b5_col_amount2" form="order_details" value="<?php echo $plans_amount;?>" style="width:5em" > 
                    <b>=</b> 
                    <input type="text" class="form-control form-control-sm" name="o_price_ex_b3" id="o_price_ex_b3" value="<?php echo $order['o_price_ex_b3']; ?>" form="order_details" style="width:5em">
                    <b><?php echo $currency; ?></b>			
                    <br ><br >
                </div>
                
                <br><br>
                <?php
                }
                ?>
            </div>
           

            <?php
			//start b5 ex 
			 
			if(count($b5_ex_products)>0)
			{
				?>
               
				<div class="collapse <?php
                if (strpos($order['collection'], 'p1561') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb5" style="background-color:#94ce99;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b5_ex_columns=3;
                    $b5_ex_lines=ceil(3 / $b5_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b5_ex_products[$i],$cur_factor);
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
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b5_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b5 checkbox mr-2" type="checkbox" name="<?php echo $b5_ex_products[$i]; ?>" id="<?php echo $b5_ex_products[$i]; ?>" value="<?php echo $b5_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b5_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b5_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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

                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php                                              
                                            echo $product_apu." APE";?>
                                            <?php
                                            if(($b5_ex_products[$i]=="p1561")||($b5_ex_products[$i]=="p1563")||($b5_ex_products[$i]=="p1566")||($b5_ex_products[$i]=="p1581"))
                                            {
                                                ?>
                                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_ex_multiplicator" form="order_details" id="<?php echo $b5_ex_products[$i]; ?>_fac" name="<?php echo $b5_ex_products[$i]; ?>_fac" value="<?php echo ($o_desc_ex_b5[$b5_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b5[$b5_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                                = <div id="<?php echo $b5_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b5[$b5_ex_products[$i]."_fac"]; ?></div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
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
                ?>
                <?php
                if(count($b5_ex_products)>0)
                {
                ?>
                <div class="row form-inline w-100 mx-0 border-bottom border-dark">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Employee-Producer: Col EX B5 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b5" id="col_labc_ex_b5" value="<?php echo $o_desc_ex_b5['col_labc_ex_b5'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b5 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b5" id="fac_labc_ex_b5" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b5" id="col_amount3_ex_b5" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b5" id="total_labcs_ex_b5" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Producer-Trader: Col EX B5 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b5" id="col_apus_ex_b5" value="<?php echo $o_desc_ex_b5['col_apus_ex_b5'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b5 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b5" id="fac_prod_ex_b5" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b5" id="col_amount2_ex_b5" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b5" id="o_apus_ex_b5" value="<?php echo $o_desc_ex_b5['o_apus_ex_b5'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Trader-Purchaser: Col EX B5 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b5" id="col_price_ex_b5" value="<?php echo $o_desc_ex_b5['col_price_ex_b5']; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b5 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b5" id="fac_cl_ex_b5" value="1" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b5" id="col_amount1_ex_b5" form="order_details" value="1" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b5" id="o_price_ex_b5" value="<?php echo $o_desc_ex_b5['o_price_ex_b5']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                </div>
                <?php 
                
            }
            
            
			?>
			<div class="row mx-0 w-100 justify-content-center pt-3"  id="b6extopen" style="background-color:#94ce99;">
                <!-- <p class="d-inline">This client has not chosen a b7 exterior product. </p> -->
                <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb6" data-toggle="collapse" id="b6extbtnopen">B6 exterior - Twinmotion</button></p>
            </div>
            <?php
            

            //start b6 ex

            if(count($b6_ex_products)>0)
			{
                ?>
				<div class="collapse <?php
                if (strpos($order['collection'], 'p1661') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb6" style="background-color:#94ce99;">
                    <div class="row w-100 mx-0">
                    <?php
                    $b6_ex_columns=3;
                    //$b6_ex_lines=ceil(count($b6_ex_products) / $b6_ex_columns);
                    $b6_ex_lines=ceil(3 / $b6_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b6_ex_products[$i],$cur_factor);
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
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b6_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b6 checkbox mr-2" type="checkbox" name="<?php echo $b6_ex_products[$i]; ?>" id="<?php echo $b6_ex_products[$i]; ?>" value="<?php echo $b6_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b6_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b6_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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
                                    
                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php 
                                            echo $product_apu." APE";?>
                                            <?php
                                            if(($b6_ex_products[$i]=="p1661")||($b6_ex_products[$i]=="p1663")||($b6_ex_products[$i]=="p1666")||($b6_ex_products[$i]=="p1681")||($b6_ex_products[$i]=="p166p"))
                                            {
                                                ?>
                                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b6_ex_multiplicator" form="order_details" id="<?php echo $b6_ex_products[$i]; ?>_fac" name="<?php echo $b6_ex_products[$i]; ?>_fac" value="<?php echo ($o_desc_ex_b6[$b6_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b6[$b6_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                                = <div id="<?php echo $b6_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b6[$b6_ex_products[$i]."_fac"]; ?></div>
                                                <?php
                                            }
                                            ?> 
                                        </div>
                                    </div>
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
                <?php
                if(count($b6_ex_products)>0)
                {
                ?>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Employee-Producer: Col EX B6 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b6" id="col_labc_ex_b6" value="<?php echo $o_desc_ex_b6['col_labc_ex_b6'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b6 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b6" id="fac_labc_ex_b6" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b6" id="col_amount3_ex_b6" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b6" id="total_labcs_ex_b6" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                    </div>
                </div>
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Producer-Trader: Col EX B6 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b6" id="col_apus_ex_b6" value="<?php echo $o_desc_ex_b6['col_apus_ex_b6'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b6 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b6" id="fac_prod_ex_b6" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b6" id="col_amount2_ex_b6" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b6" id="o_apus_ex_b6" value="<?php echo $o_desc_ex_b6['o_apus_ex_b6'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline w-100 mx-0">
                    <div class="col-md-12 d-flex justify-content-center">
                        <b>Trader-Purchaser: Col EX B6 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b6" id="col_price_ex_b6" value="<?php echo $o_desc_ex_b6['col_price_ex_b6']; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b6 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b6" id="fac_cl_ex_b6" value="1" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b6" id="col_amount1_ex_b6" form="order_details" value="1" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b6" id="o_price_ex_b6" value="<?php echo $o_desc_ex_b6['o_price_ex_b6']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                </div>
                <?php 
                
            }
            ?>


            <?php
             //start b7 ex 
			if(count($b7_ex_products)>0)
			{
				?>                
                <div class="collapse <?php
                if (strpos($order['collection'], 'p1761') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb7" style="background-color:#6aa36f;">
                    <div class="row w-100 mx-0 mt-4">
                    <?php
                    $b7_ex_columns=3;
                    $b7_ex_lines=ceil(3 / $b7_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b7_ex_products[$i],$cur_factor);
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
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b7_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b7 checkbox mr-2" type="checkbox" name="<?php echo $b7_ex_products[$i]; ?>" id="<?php echo $b7_ex_products[$i]; ?>" value="<?php echo $b7_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b7_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b7_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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

                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php 
                                            
                                            echo $product_apu." APE";?>
                                            <?php
                                            if(($b7_ex_products[$i]=="p1761")||($b7_ex_products[$i]=="p1763")||($b7_ex_products[$i]=="p1766")||($b7_ex_products[$i]=="p1781"))
                                            {
                                                ?>
                                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b7_ex_multiplicator" form="order_details" id="<?php echo $b7_ex_products[$i]; ?>_fac" name="<?php echo $b7_ex_products[$i]; ?>_fac" value="<?php echo ($o_desc_ex_b7[$b7_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b7[$b7_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                                = <div id="<?php echo $b7_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b7[$b7_ex_products[$i]."_fac"]; ?></div>
                                                <?php
                                            }
                                            ?> 
                                        </div>
                                    </div>
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
                //$plans_amount=$order['b5_col_amount'];
                ?>
               
                
                <?php
                if(count($b7_ex_products)>0)
                {
                ?>
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Employee-Producer: Col EX B7 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b7" id="col_labc_ex_b7" value="<?php echo $o_desc_ex_b7['col_labc_ex_b7'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b7 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b7" id="fac_labc_ex_b7" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b7" id="col_amount3_ex_b7" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b7" id="total_labcs_ex_b7" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                        </div>
                </div>
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Producer-Trader: Col EX B7 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b7" id="col_apus_ex_b7" value="<?php echo $o_desc_ex_b7['col_apus_ex_b7'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b7 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b7" id="fac_prod_ex_b7" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b7" id="col_amount2_ex_b7" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b7" id="o_apus_ex_b7" value="<?php echo $o_desc_ex_b7['o_apus_ex_b7'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Trader-Purchaser: Col EX B7 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b7" id="col_price_ex_b7" value="<?php echo $o_desc_ex_b7['col_price_ex_b7']; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b7 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b7" id="fac_cl_ex_b7" value="1" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b7" id="col_amount1_ex_b7" form="order_details" value="1" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b7" id="o_price_ex_b7" value="<?php echo $o_desc_ex_b7['o_price_ex_b7']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                        
                    <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                    </div>
				<br>
			<?php 
            }
            ?>
            <div class="row mx-0 w-100 justify-content-center pt-3"  id="b8extopen" style="background-color:#6aa36f;">
                <!-- <p class="d-inline">This client has not chosen a b8 exterior product. </p> -->
                <p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb8" data-toggle="collapse" id="b8extbtnopen">B8 exterior - Lumion</button></p>
            </div>
            <?php
             //start b8 ex 
			if(count($b8_ex_products)>0)
			{
				?>
                <!-- <div class="row mx-0 w-100 justify-content-center pt-3"  id="b8extopen">
					
					<p class="d-inline pl-4"><button class="btn btn-sm btn-success text-white px-5 ml-1" data-target="#exteriorb8" data-toggle="collapse" id="b8extbtnopen">B8 exterior - Lumion</button></p>
				</div> -->
                <div class="collapse <?php
                if (strpos($order['collection'], 'p1861') !== false) 
                {
                    echo "show";
                }?>" id="exteriorb8" style="background-color:#6aa36f;">
                    <div class="row w-100 mx-0 mt-4">
                    <?php
                    $b8_ex_columns=3;
                    // $b8_ex_lines=ceil(count($b8_ex_products) / $b8_ex_columns);
                    $b8_ex_lines=ceil(3 / $b8_ex_columns);
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
                                $product_price=$prod->calculateProductPrice($order['ls_id'],$b8_ex_products[$i],$cur_factor);
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
                            <div class="row w-100 mx-0 my-1">					
                                <div class="<?php 
                                for($j=0;$j<count($collection);$j++)
                                {
                                    if($b8_ex_products[$i]==$collection[$j])
                                    {
                                        echo "active_layout p-1";
                                    }
                                }							
                                ?> w-100">
                                    <input class="products product_ex_b8 checkbox mr-2" type="checkbox" name="<?php echo $b8_ex_products[$i]; ?>" id="<?php echo $b8_ex_products[$i]; ?>" value="<?php echo $b8_ex_products[$i]; ?>" <?php 
                                    for($j=0;$j<count($collection);$j++)
                                    {
                                        if($b8_ex_products[$i]==$collection[$j])
                                        {
                                            echo "checked";
                                        }
                                    }
                                    ?>> 
                                    <label for="<?php echo $b8_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?></label>					
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

                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_price_original" value="<?php echo $product_price; ?>">
                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_apu_original" value="<?php echo $product_apu; ?>">
                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_labc_original" value="<?php echo $product_labc; ?>">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <?php                                             
                                            echo $product_apu." APE"; ?>
                                            <?php
                                            if(($b8_ex_products[$i]=="p1861")||($b8_ex_products[$i]=="p1863")||($b8_ex_products[$i]=="p1866")||($b8_ex_products[$i]=="p1881"))
                                            {
                                                ?>
                                                <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b8_ex_multiplicator" form="order_details" id="<?php echo $b8_ex_products[$i]; ?>_fac" name="<?php echo $b8_ex_products[$i]; ?>_fac" value="<?php echo ($o_desc_ex_b8[$b8_ex_products[$i]."_fac"]!=0)?$o_desc_ex_b8[$b8_ex_products[$i]."_fac"]:"1";?>" style="width:3em;" title="Multiplicator">
                                                = <div id="<?php echo $b8_ex_products[$i]; ?>_fac_total"><?php echo $product_apu * $o_desc_ex_b8[$b8_ex_products[$i]."_fac"]; ?></div>
                                                <?php
                                            }
                                            ?>  
                                        </div>
                                    </div>
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
                //$plans_amount=$order['b5_col_amount'];
                ?>
               
                
                <?php
                if(count($b8_ex_products)>0)
                {
                ?>
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Employee-Producer: Col EX B8 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_labc_ex_b8" id="col_labc_ex_b8" value="<?php echo $o_desc_ex_b8['col_labc_ex_b8'];?>" form="order_details" style="width:5em" > <b>labcs X fac_labc_ex_b8 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b8" id="fac_labc_ex_b8" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b8" id="col_amount3_ex_b8" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b8" id="total_labcs_ex_b8" value="" form="order_details" style="width:5em"> <b>labcs</b><br><br>
                        </div>
                </div>
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Producer-Trader: Col EX B8 = </b>
                        <input type="text" class="form-control form-control-sm" name="col_apus_ex_b8" id="col_apus_ex_b8" value="<?php echo $o_desc_ex_b8['col_apus_ex_b8'];?>" form="order_details" style="width:5em" > <b>APEs X fac_prod_ex_b8 = </b>
                        <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b8" id="fac_prod_ex_b8" value="1" form="order_details" style="width:5em"> 
                        <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b8" id="col_amount2_ex_b8" form="order_details" value="1" style="width:5em">
                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b8" id="o_apus_ex_b8" value="<?php echo $o_desc_ex_b8['o_apus_ex_b8'];?>" form="order_details" style="width:5em" > <b>APEs</b><br><br>
                    </div>
                </div>			
                <div class="row form-inline">
                    <div class="col-md-12">
                        <b>Trader-Purchaser: Col EX B8 = </b>
                        <input class="form-control form-control-sm" type="text" name="col_price_ex_b8" id="col_price_ex_b8" value="<?php echo $o_desc_ex_b8['col_price_ex_b8']; ?>" form="order_details" style="width:5em"> 
                        <b><?php echo $currency; ?> X fac_client_ex_b8 = </b> 
                        <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b8" id="fac_cl_ex_b8" value="1" form="order_details" style="width:5em"> 
                        <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b8" id="col_amount1_ex_b8" form="order_details" value="1" style="width:5em"> 
                        <b>=</b> 
                        <input type="text" class="form-control form-control-sm" name="o_price_ex_b8" id="o_price_ex_b8" value="<?php echo $o_desc_ex_b8['o_price_ex_b8']; ?>" form="order_details" style="width:5em" >
                        <b><?php echo $currency; ?></b>			
                        <br><br>
                    </div>
                </div>
                        
                    <div class="row mx-0 w-100 d-flex justify-content-center border-top border-dark pt-3">
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Real address for the environment: </b></p>
                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo $order['environment_address']; ?></textarea>
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Customer remarks exterior: </b></p>
                                <textarea name="customer_remarks_ex_b5" class="form-control form-control-sm" rows="2" cols="6" form="order_details"><?php echo htmlspecialchars($order['client_extras_ex_b5']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-inline">
                                <p><b>Operator remarks exterior: </b></p>
                                <textarea name="op_remarks_ex_b5" class="form-control form-control-sm" form="order_details"><?php echo htmlspecialchars($order['op_remarks_ex_b5']); ?></textarea>
                            </div>
                        </div>	
                        <a id="customerfiles"></a>
                    </div>
                    </div>
				<br>
			<?php 
			}

            
            $o_desc_allproducts=$prod->get_o_infos_allproducts($o_id);
            ?>
        <div id="remarks_ex_row">
            <div class="row w-100 mx-0 my-2">
                <div class="col-md-12 d-flex justify-content-center">
                    <table class="short_order" style="border: 5px solid green;">
                        <tr style="background: #d4eed1;">
                            <td class="border border-success p-2 text-center">
                                <b><?php
                            //Basement:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1553","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1553","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1553","x-texts")['text'];
                                echo $text;
                            }
                            ?></b><br>
                            <div class="form-inline d-flex justify-content-center">
                                <input type="text" id="basement" name="basement" value="<?php echo (!empty($o_desc_allproducts['basement']))?$o_desc_allproducts['basement']:0;?>" class="form-control form-control-sm" style="width:6em;" <?php
                                if(($_COOKIE['contracting'])<1) {echo "disabled";}  
                                ?> form="order_details">
                            </div>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Levels over ground:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1554","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1554","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1554","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <div class="form-inline d-flex justify-content-center">
                                <input type="text" id="levels_over_ground" name="levels_over_ground" value="<?php 
                                    echo (!empty($o_desc_allproducts['levels_over_ground']))?$o_desc_allproducts['levels_over_ground']:0;
                                ?>" class="form-control form-control-sm" style="width:6em;" <?php
                                if(($_COOKIE['contracting'])<1) {echo "disabled";} ?> form="order_details">										
                            </div>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
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
                            }?></b><br>
                            <?php
                            $stairs=$domenia3n->get_all_stairs();
                            
                            ?>
                            <select id ="st_id1" name="st_id1" class="form-control form-control-sm" <?php
                            if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
                                <option value="">None</option>
                                <?php
                                for($i=0;$i<count($stairs);$i++)
                                {
                                ?>
                                <option value="<?php echo $stairs[$i]['st_id'];?>" <?php echo ($o_desc_allproducts['stairs_id']==$stairs[$i]['st_id'])?"selected":"";?>><?php //echo $stairs[$i]['st_name'];
                                if(isset($selected_lang))
                                {
                                    $text=$domenia->get_translation_text($selected_lang,$stairs[$i]['st_name_world'],"x-texts")['text'];
                                    if(!empty($text))
                                    {
                                        echo $text;
                                    }
                                    else
                                    {
                                        $text=$domenia->get_translation_text(1,$stairs[$i]['st_name_world'],"x-texts")['text'];
                                        echo $text;
                                    }
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,$stairs[$i]['st_name_world'],"x-texts")['text'];
                                    echo $text;
                                }
                                ?></option>
                                <?php							
                                }
                                ?>
                            </select>
                        </td>
                        <td class="border border-success p-2 text-center">					
                            <b><?php
                            //Initial Length in cm:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1556","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1556","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1556","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <div class="form-inline d-flex justify-content-center">
                                <input type="text" id="e_length" name="e_length" value="<?php echo $o_desc_allproducts['length'];?>" class="form-control form-control-sm" style="width:6em;" <?php
                                if(($_COOKIE['contracting'])<1){ echo "disabled";}?> form="order_details">
                            </div>
                        </td>
                        <td class="border border-success p-2 text-center">				
                            <b><?php
                            //Initial Width in cm:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1557","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1557","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1557","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <div class="form-inline d-flex justify-content-center">
                                <input type="text" id="e_width" name="e_width" value="<?php echo $o_desc_allproducts['width'];?>" class="form-control form-control-sm" style="width:6em;" <?php
                                if(($_COOKIE['contracting'])<1) {echo "disabled";} ?> form="order_details"> 
                            </div>
                        </td>			
                    </tr>
                    <tr style="background: #d4eed1;">
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Roof shape:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1558","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1558","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1558","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php
                            $roof_shapes=$domenia2->get_all_roof_shapes();
                            $roofshape=$domenia2->get_roof_shape($o_desc_allproducts['roof_type']);
                            ?>
                            <select id="rs_id" name="rs_id" class="form-control form-control-sm" <?php
                            if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
                                <option value="">None</option>
                                <?php
                                for($i=0;$i<count($roof_shapes);$i++)
                                {							
                                ?>
                                <option value="<?php echo $roof_shapes[$i]['rs_id'];?>" <?php echo ($roofshape['rs_id']==$roof_shapes[$i]['rs_id'])?"selected":"";?>><?php echo $roof_shapes[$i]['rs_dbname'];?></option>
                                <?php							
                                }
                                ?>
                            </select>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Roof tilt:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1559","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1559","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1559","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <div class="form-inline d-flex justify-content-center">
                                <input type="text" id="r_tilt" name="r_tilt" value="<?php echo $o_desc_allproducts['roof_tilt'];?>" class="form-control form-control-sm" style="width:6em;" <?php
                                if(($_COOKIE['contracting'])<1){echo "disabled";}			
                                ?> form="order_details">
                            </div>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Knee wall height in cm:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1560","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1560","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1560","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <div class="form-inline d-flex justify-content-center">
                                <input type="text" id="r_kneewall" name="r_kneewall" value="<?php echo $o_desc_allproducts['knee_wall'];?>" class="form-control form-control-sm" style="width:6em;" <?php
                                if(($_COOKIE['contracting'])<1){echo "disabled";}			
                                ?> form="order_details">
                            </div>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Roof overstand:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1561","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1561","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1561","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php
                            
                            $selected_roof_overstand=$domenia2->get_roof_overstand_pic_by_id($o_desc_allproducts['rop_id']);
                            
                            $roof_overstand=$domenia2->get_all_roof_overstand();					
                            ?>
                            <select id="rop_id" name="rop_id" class="form-control form-control-sm" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details">
                                <option value="">None</option>
                            <?php
                            for($i=0;$i<count($roof_overstand);$i++)
                            {
                                $roof_overstand_pic=$domenia2->get_roof_overstand_picture($roof_overstand[$i]['ro_id']);
                            ?>
                                
                                <option value="" style="font-weight:bold;"><?php echo $roof_overstand[$i]['ro_name_db'];?></option>
                                <?php
                                for($j=0;$j<count($roof_overstand_pic);$j++)
                                {
                                    
                                    ?>
                                    <option value="<?php echo $roof_overstand_pic[$j]['rop_id'];?>" style="text-indent:20px;" <?php echo ($roof_overstand_pic[$j]['rop_id']==$selected_roof_overstand['rop_id'])?"selected":"";?>><?php //echo $roof_overstand_pic[$j]['ro_look_db'];
                                if(isset($selected_lang))
                                {
                                    $text=$domenia->get_translation_text($selected_lang,$roof_overstand_pic[$j]['ro_look_world'],"x-texts")['text'];
                                    if(!empty($text))
                                    {
                                        echo $text;
                                    }
                                    else
                                    {
                                        $text=$domenia->get_translation_text(1,$roof_overstand_pic[$j]['ro_look_world'],"x-texts")['text'];
                                        echo $text;
                                    }
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,$roof_overstand_pic[$j]['ro_look_world'],"x-texts")['text'];
                                    echo $text;
                                }
                                ?></option>
                                    <?php
                                
                                }
                            }
                            ?>
                            </select>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Roof tiles:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1562","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1562","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1562","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php
                            $selected_roofcolor=$domenia2->get_roof_color_by_id($o_desc_allproducts['roof_material']);
                            $selected_rooftile=$domenia2->get_roof_material($selected_roofcolor['rm_id']);
                            
                            $roof_materials=$domenia2->get_all_roof_materials();
                            ?>
                            <select id="roof_material" name="roof_material" class="form-control form-control-sm" style="width:12em;" <?php
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            
                            ?>>
                                <option value="" style="font-weight:bold">None</option>
                                <?php
                                for($i=0;$i<count($roof_materials);$i++)
                                {
                                ?>
                                <option value="<?php echo $roof_materials[$i]['rm_id'];?>" <?php echo ($roof_materials[$i]['rm_id']==$selected_rooftile['rm_id'])?"selected":"";?>><?php echo $roof_materials[$i]['rm_dbname'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                            $(document).ready(function() {
        
                            $('#roof_material').on("change",function(){	
                                $.ajax({
                                url: "<?php echo $base_url;?>ajax/acceptance.php",
                                method: "get",
                                data: {o_id:<?php echo $o_id;?>,roof_material:$(this).val()},
                                dataType:"html",
                                success:function(data) {
                                    //console.log(data);
                                    $('#selected_roof_color').html(data);
        
                                    /* $('#b5_roof_color').on("change",function(){	
                                        
                                        $.ajax({
                                        url: "../ajax/acceptance.php",
                                        method: "get",
                                        data: {o_id:<?php echo $o_id;?>,b5_roof_color:$(this).val()},
                                        dataType:"html",
                                        success:function(data) {
                                            console.log(data);										
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(thrownError);
                                        }
                                        
                                        });
                                    }); */
                                
                            
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(xhr.status);
                                    console.log(thrownError);
                                  }
                                
                                });
                            });
                            });
                            </script>
                        </td>
                        
                    </tr>
                    <tr style="background: #d4eed1;">
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Roof color:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1563","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1563","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1563","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php
                            
                            //for($j=0;$j<count($roof_materials);$j++)
                            //{
                            //$all_roof_colors=$domenia2->get_roof_colors($roof_materials[$j]['rm_id']);
                            $all_roof_colors=$domenia2->get_roof_colors($selected_roofcolor['rm_id']);
                            ?>
                            <div id="selected_roof_color">
                            <select id="roof_color" name="roof_color" class="form-control form-control-sm" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            
                            ?> form="order_details">
                                <option value="">None</option>
                                <?php
                                for($i=0;$i<count($all_roof_colors);$i++)
                                {						
                                    ?>
                                    <option value="<?php echo $all_roof_colors[$i]['rmp_id'];?>" <?php echo ($all_roof_colors[$i]['rmp_id']==$selected_roofcolor['rmp_id'])?"selected":"";?>><?php echo $all_roof_colors[$i]['rmp_dbcolor']; ?></option>
                                    <?php							
                                }
                                ?>
                            </select>
                            </div>
                           
                            <?php							
                            //}
                            ?>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Facade color/-s:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1564","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1564","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1564","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php 
                            $colors=explode(";",$o_desc_allproducts['wlc_id']);
                            $all_color_pictures=$domenia2->get_all_color_pictures();
                            ?>
                            <div class="inline-flex">
                                <p class="mb-0 mr-1 d-inline">1.</p>
                             <select id="facade_color_1" name="facade_color_1" class="form-control form-control-sm d-inline mb-1" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details">
                                <option value="">None</option>
                                <?php
                                for($i=0;$i<count($all_color_pictures);$i++)
                                {
                                ?>
                                <option value="<?php echo $all_color_pictures[$i]['clp_id'];?>" <?php echo ($all_color_pictures[$i]['clp_id']==$colors[0])?"selected":"";?>><?php echo $all_color_pictures[$i]['clp_name_db'];?></option>
                                <?php
                                }
                                ?>
                               </select>
                            </div>   
                            <br>   
                            <div class="inline-flex">
                                <p class="mb-0 d-inline mr-1">2.</p>
                             <select id="facade_color_2" name="facade_color_2" class="form-control form-control-sm d-inline" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details">
                                <option value="">None</option>
                                    <?php
                                    for($i=0;$i<count($all_color_pictures);$i++)
                                    {
                                    ?>
                                <option value="<?php echo $all_color_pictures[$i]['clp_id'];?>" <?php echo ($all_color_pictures[$i]['clp_id']==$colors[1])?"selected":"";?>><?php echo $all_color_pictures[$i]['clp_name_db'];?></option>
                                    <?php
                                    }
                                    ?>
                               </select>
                            </div>			
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Facade extras:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1565","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1565","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1565","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php
                            $wallwoods=$domenia2->get_all_wall_wood();
                            $selected_woodwall_pic=$domenia2->get_wall_wood_pic_by_id($o_desc_allproducts['ww_id']);
                            
                            ?>
                            <select id="ww_id" name="ww_id" class="form-control form-control-sm" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            
                            ?> form="order_details">
                                <option value="" style="font-weight:bold;">None</option>
                            <?php
                            for($i=0;$i<count($wallwoods);$i++)
                            {
                            ?>							
                                <option value="" style="font-weight:bold;"><?php echo $wallwoods[$i]['ww_name_db'];?></option>
                                <?php
                                $woodwall_pic=$domenia2->get_all_wall_wood_pic_by_id($wallwoods[$i]['ww_id']);
                                for($j=0;$j<count($woodwall_pic);$j++)
                                {						
                                ?>
                                <option value="<?php echo $woodwall_pic[$j]['wwp_id'];	?>" style="text-indent:20px;" <?php echo ($woodwall_pic[$j]['wwp_id']==$selected_woodwall_pic['wwp_id'])?"selected":"";?>><?php //echo $woodwall_pic[$j]['wwp_name_db'];
                                if(isset($selected_lang))
                                {
                                    $text=$domenia->get_translation_text($selected_lang,$woodwall_pic[$j]['wwp_name_world'],"x-texts")['text'];
                                    if(!empty($text))
                                    {
                                        echo $text;
                                    }
                                    else
                                    {
                                        $text=$domenia->get_translation_text(1,$woodwall_pic[$j]['wwp_name_world'],"x-texts")['text'];
                                        echo $text;
                                    }
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,$woodwall_pic[$j]['wwp_name_world'],"x-texts")['text'];
                                    echo $text;
                                }
                                ?></option>
                                <?php							
                                }
                                ?>
                            <?php
                            }
                            ?>
                            </select>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Window frames color
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1566","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1566","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1566","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php
                            $windowcolor=$domenia2->get_color($o_desc_allproducts['wc_id']);
                            $allcolors=$domenia2->get_all_colors();
                            ?>
                            <select id="wc_id" name="wc_id" class="form-control form-control-sm" <?php
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details">
                                <option value="" style="font-weight:bold;">None</option>
                                <?php
                                for($i=0;$i<count($allcolors);$i++)
                                {						
                                ?>
                                <option value="<?php echo $allcolors[$i]['col_id'];	?>" <?php echo ($allcolors[$i]['col_id']==$windowcolor['col_id'])?"selected":"";?>><?php echo $allcolors[$i]['col_name_db'];?></option>
                                <?php							
                                }
                                ?>
                            </select>
                        </td>
                        <td class="border border-success p-2 text-center" >
                            <b><?php 
                            //Entrance door-shape + extensions
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1568","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1568","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1568","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <select id="door_texture" name="door_texture" class="form-control form-control-sm mb-1" <?php
                            if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
                                <option value="">None</option>
                                <?php 
                                $all_door_textures=$domenia2->get_all_door_textures();
                                
                                for($i=0;$i<count($all_door_textures);$i++)
                                {
                                    $doorshape=$domenia2->get_door_shape($all_door_textures[$i]['ds_id']);						
                                ?>
                                <option value="<?php echo $all_door_textures[$i]['dsp_id'];	?>" <?php echo($o_desc_allproducts['door_texture']==$all_door_textures[$i]['dsp_id'])?"selected":"";?>><?php //echo $doorshape['ds_name_db'];
                                if(isset($selected_lang))
                                {
                                    $text=$domenia->get_translation_text($selected_lang,$doorshape['ds_name_world'],"x-texts")['text'];
                                    if(!empty($text))
                                    {
                                        echo $text;
                                    }
                                    else
                                    {
                                        $text=$domenia->get_translation_text(1,$doorshape['ds_name_world'],"x-texts")['text'];
                                        echo $text;
                                    }
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,$doorshape['ds_name_world'],"x-texts")['text'];
                                    echo $text;
                                }
                                ?></option>
                                <?php													
                                }
                                ?>
                            </select>
                            <select  id="door_shape_sides" name="door_shape_sides" class="form-control form-control-sm" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            
                            ?> form="order_details">
                                <option value="">None</option>
                                <?php
                                $all_door_shape_sides=$domenia2->get_all_door_shape_sides2();
                                
                                for($i=0;$i<count($all_door_shape_sides);$i++)
                                {
                                    $doorshapeside=$domenia2->get_door_shape_sides($all_door_shape_sides[$i]['dss_id']);						
                                ?>
                                <option value="<?php echo $all_door_shape_sides[$i]['dsp_id'];?>" <?php echo ($o_desc_allproducts['dsp_id']==$all_door_shape_sides[$i]['dsp_id'])?"selected":"";?>><?php //echo $doorshapeside['dss_name_db'];
                                if(isset($selected_lang))
                                {
                                    $text=$domenia->get_translation_text($selected_lang,$doorshapeside['dss_name_world'],"x-texts")['text'];
                                    if(!empty($text))
                                    {
                                        echo $text;
                                    }
                                    else
                                    {
                                        $text=$domenia->get_translation_text(1,$doorshapeside['dss_name_world'],"x-texts")['text'];
                                        echo $text;
                                    }
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,$doorshapeside['dss_name_world'],"x-texts")['text'];
                                    echo $text;
                                }
                                ?></option>
                                <?php							
                                }
                                ?>
                            </select>
                        </td>				
                    </tr>
                    <tr style="background: #d4eed1;">
                        <td class="border border-success p-2 text-center" style="border-bottom: 5px solid green!important;">
                            <b><?php
                            //Entrance door - color
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1567","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1567","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1567","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <select id="door_color" name="door_color" class="form-control form-control-sm" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details"> 
                                <option value="">None</option>
                                <?php
                                $door_color=$domenia2->get_color($o_desc_allproducts['door_color']);
                                
                                for($i=0;$i<count($allcolors);$i++)
                                {
                                ?>
                                <option value="<?php echo $allcolors[$i]['col_id'];	?>" <?php echo ($allcolors[$i]['col_id']==$door_color['col_id'])?"selected":"";?>><?php echo $allcolors[$i]['col_name_db'];?></option>
                                <?php							
                                }
                                ?>
                            </select>
                        </td>
                        <td class="border border-success p-2 text-center">
                            <b><?php
                            //Garage/Carport:
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1569","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1569","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1569","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <?php 
                            $all_garage=$domenia2->get_all_garage();
                            ?>
                            <select id="gc_id" name="gc_id" class="form-control form-control-sm mb-1" <?php
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details">
                                <option>None</option>
                                <?php
                                for($i=0;$i<count($all_garage);$i++)
                                {
                                ?>
                                <option value="<?php echo $all_garage[$i]['cp_id'];	?>" <?php echo ($all_garage[$i]['cp_id']==$o_desc_allproducts['gc_id'])?"selected":"";?>><?php //echo $all_garage[$i]['cp_name_db'];
                                if(isset($selected_lang))
                                {
                                    $text=$domenia->get_translation_text($selected_lang,$all_garage[$i]['cp_name_world'],"x-texts")['text'];
                                    if(!empty($text))
                                    {
                                        echo $text;
                                    }
                                    else
                                    {
                                        $text=$domenia->get_translation_text(1,$all_garage[$i]['cp_name_world'],"x-texts")['text'];
                                        echo $text;
                                    }
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,$all_garage[$i]['cp_name_world'],"x-texts")['text'];
                                    echo $text;
                                }
                                ?></option>
                                <?php							
                                }
                                ?>
                            </select>
                            <input type="text" id="garage_size" name="garage_size" class="form-control form-control-sm" value="<?php echo $o_desc_allproducts['gc_length']."m ".$o_desc_allproducts['gc_width']." m";?>" <?php if(($_COOKIE['contracting'])<1){echo "disabled";}?> form="order_details">
                            <!-- <select id="garage_size" name="garage_size" class="form-control form-control-sm" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details">
                                <option value="">None</option>
                                <option value="3x6" <?php 
                                if(($o_desc_allproducts['gc_length']==3)&&($o_desc_allproducts['gc_width']==6)){echo "selected";}?>>3 m x 6 m</option>
                                <option value="6x6" <?php 
                                if(($o_desc_allproducts['gc_length']==6)&&($o_desc_allproducts['gc_width']==6)){echo "selected";}?>>6 m x 6 m</option>
                                <option value="6x9" <?php 
                                if(($o_desc_allproducts['gc_length']==6)&&($o_desc_allproducts['gc_width']==9)){echo "selected";}?>>6 m x 9 m</option>
                                
                            </select> -->
                        </td>
                        <td class="border border-success p-2 text-center" style="border-right: 5px solid green!important;">
                            <b><?php
                            //Environment
                            if(isset($selected_lang))
                            {
                                $text=$domenia->get_translation_text($selected_lang,"tx_1570","x-texts")['text'];
                                if(!empty($text))
                                {
                                    echo $text;
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,"tx_1570","x-texts")['text'];
                                    echo $text;
                                }
                            }
                            else
                            {
                                $text=$domenia->get_translation_text(1,"tx_1570","x-texts")['text'];
                                echo $text;
                            }?></b><br>
                            <select id="environment" name="environment" class="form-control form-control-sm" <?php 
                            if(($_COOKIE['contracting'])<1){echo "disabled";}
                            ?> form="order_details">
                                <option value="">None</option>
                                <?php
                                
                                $all_environment_pictures=$domenia2->get_all_plot_pictures();
                                
                                for($i=0;$i<count($all_environment_pictures);$i++)
                                {							
                                ?>
                                <option value="<?php echo $all_environment_pictures[$i]['pbp_id'];?>" <?php echo ($all_environment_pictures[$i]['pbp_id']==$o_desc_allproducts['pbp_id'])?"selected":"";?>><?php //echo $all_environment_pictures[$i]['pbp_look_db'];
                                if(isset($selected_lang))
                                {
                                    $text=$domenia->get_translation_text($selected_lang,$all_environment_pictures[$i]['pbp_look_world'],"x-texts")['text'];
                                    if(!empty($text))
                                    {
                                        echo $text;
                                    }
                                    else
                                    {
                                        $text=$domenia->get_translation_text(1,$all_environment_pictures[$i]['pbp_look_world'],"x-texts")['text'];
                                        echo $text;
                                    }
                                }
                                else
                                {
                                    $text=$domenia->get_translation_text(1,$all_environment_pictures[$i]['pbp_look_world'],"x-texts")['text'];
                                    echo $text;
                                }
                                ?></option>
                                <?php							
                                }
                                ?>
                            </select>	
                        </td>
                    </tr>
                </table>
            </div>
        </div>
</div>
<?php
}
?>
			<br>	
			</div> <!-- end exterior -->
			    <input type="hidden" id="collection" name="collection" value="<?php echo $order['collection']; ?>" form="order_details">
			<br>
            <?php
            $current_timestamp = strtotime($order['o_date']);

            // Get the current Unix timestamp in GMT
            $current_time = time();

            // Calculate the difference in seconds
            $difference = $current_time - $current_timestamp;

            // Check if the difference is less than 10 minutes (600 seconds)
            if ($difference < 600) 
            {
            ?>
            <div class="row">
                <div class="col-md-12 text-center text-warning">                    
                    <b>Warning, some work with the saving of the customer files is still in process. This might take 2 - 10 minutes</b>
                </div>
            </div>
            <?php
            }
            ?>
			<div id="all_customer_files">
                
            </div>
            <script type="text/javascript">
            
            $(document).ready(function(){
                
                check_and_convert_pdf_to_jpg_customer_files();
                setTimeout(function(){get_customer_files();},2000);
                
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
                        	
                    }
                }).done(function(data){
                    $('#all_customer_files').html(data);
                    //setTimeout(function(){imagePreview();},2000);

                });
            }
                
            function check_and_convert_pdf_to_jpg_customer_files()
            {

                let o_id=<?php echo $o_id;?>;

                $.ajax({
                    url: "../ajax/ajax_check_and_convert_pdf_to_jpg_customer_files.php",
                    method: "get",
                    data: {o_id:o_id},
                    dataType:"html",
                    success:function(data) {
                        	
                    }
                }).done(function(data){
                    $('#all_customer_files').html(data);
                    //setTimeout(function(){imagePreview();},2000);

                });

            }

            </script>
			<div class="totals">
			<?php
			//include('../../../../domenia7.com/public_html/customer_files.php');
			
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

            if($order['no_upload_files']==1)
            {
			?>
            <div class="row">
                <div class="col-md-12 text-center text-danger">
                    <b>The customer did not want to upload a file</b>
                </div>
            </div>
            <?php
            }
            ?>
			<input type="hidden" id="vat_percent" name="vat_percent" form="order_details" value="<?php echo $vat_percent;?>"> 
			<input type="hidden" id="vat_a_id" name="vat_a_id" form="order_details" value="<?php echo $vat_a_id;?>">
            
			<div class="row w-100 mx-0" style="background-color:#000;color: white; padding-top:2vh; padding-bottom:2vh; margin: 1vh 0;">
                <div class="col-md-8 text-left" style="">
                    <?php
                    $main_client=$prod->get_main_client($client['mc_id']);
                    if(!empty($main_client))
                    {
                    ?>
                    <span>Info about the main client: <b><?php echo $main_client['clientname'];?></b></span>
                    <textarea rows="10" class="form-control form-control-sm" name="price_remarks" id="price_remarks" data-mc_id="<?php echo $main_client['mc_id']?>" title="Main client price information" placeholder="Main client price information"><?php 
                    
                    if(!empty($main_client))
                    {
                        echo $main_client['price_remarks'];
                    }
                    ?></textarea>
                    <br>
                    <?php
                    }
                    ?>
                    <span>Info about the subclient: <b><?php echo $client['c_last_name'].", ".$client['c_first_name'];?></b></span>
                    <textarea rows="2" class="form-control form-control-sm" name="client_price_remarks" id="client_price_remarks" data-client_id="<?php echo $client['client_ID']?>" title="Simple client price information" placeholder="Simple client price information"><?php 
                    
                    if(!empty($client))
                    {
                        echo $client['client_price_remarks'];
                    }
                    ?></textarea>
                    <script type="text/javascript">
                    /*
                    $(document).ready(function(){

                        $('#price_remarks').on('change keyup',function(){
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/change_main_client_price_remarks.php",
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
                                url: "<?php echo $base_url;?>ajax/change_simple_client_price_remarks.php",
                                method: "post",
                                data: {client_id:$(this).data('client_id'),client_price_remarks:$(this).val()},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);	
                                }
                            });
                        });

                    }); */
                    </script>
                </div>
                <div class="col-md-4" style="">
                    <span style="font-weight: bold;">Pricing:</span>
                    <div class="row">
                        <div class="col-md-12 text-left">

                            <label for="total_apu" class="d-inline"><b>Total APEs = <span id="total_apu"><?php 
                            if(strpos($order['collection'],'p1001')!==false)
                            {
                                echo $budget_apu=$prod->calculateProductAPU("p1001");
                            }
                            ?></span>,</b></label>
                            <br>
                            <!--<input type="text" name="total_apu" id="total_apu" class="form-control form-control-sm d-inline" style="width:6em;" value=""> -->
                            <label for="total_price" class="d-inline"><b>Price after APEs = <span id="total_price"><?php
                            if(strpos($order['collection'],'p1001')!==false)
                            {
                                echo $order['o_price'];
                            }
                            ?></span></b></label>
                            
                            <input type="hidden" name="total_price" id="total_price2" form="order_details"  value="<?php 
                            if(strpos($order['collection'],'p1001')!==false)
                            {
                                echo $order['o_price'];
                            }
                            ?>">
                            <b class="mr-1"><?php echo $currency; ?></b>
                            <br>
                            <label for="total_special_agreement_price" class="d-inline"><b>Agreed price = </b></label>
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
                        <div class="col-md-12 text-left" style="width: 26vw;">
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

                            <div class="row form-inline w-100 mx-0 d-flex justify-content-left" style="width: 28vw !important;">
                                <div class="col-md-8 p-0 d-flex justify-content-left" style="max-width: unset !important;color:#fff;">
                                    <textarea class="form-control form-control-sm w-100" name="invoice_explanations" id="invoice_explanations" placeholder="Invoice explanations" form="order_details" style="height: 220px;"><?php
                                        if(!empty($order['invoice_explanations']))
                                        {
                                            echo $order['invoice_explanations'];
                                        }
                                        else
                                        {
                                            if(!empty($order['environment_address']))
                                            {
                                                if (str_contains($order['environment_address'], 'only')) 
                                                {
                                                    echo "Haus und Bauplatz";
                                                }
                                                if (str_contains($order['environment_address'], 'and neighbours')) 
                                                {
                                                    echo "Haus, Bauplatz und Nachbarn";
                                                }
                                            }
                                            else
                                            {
                                                echo "Haus";
                                            }
                                        }
                                        ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    
                    if($main_client['price_request_at_superior']==1)
                    {
                        ?>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <?php
                                $client_boss=$prod->get_main_client_boss_by_position_nr($client['specials']);
                                $boss=$prod->get_client($client_boss['boss_c_id']);
                                ?>
                                <button type="button" id="price_request_at_superior_btn" data-boss_client_id="<?php echo $boss['client_ID'];?>" data-client_language="<?php echo $order['client_language_id'];?>" data-o_id="<?php echo $o_id;?>" data-toggle="modal" data-target="#pricerequestModal<?= $o_id; ?>" class="btn btn-sm btn-danger">Preview price request to superior</button>
                                <script type="text/javascript">
                                    $('#price_request_at_superior_btn').click(function()
                                    {
                                        let price=$('#total_special_agreement_price').val();
                                        let invoice_explanations=$('#invoice_explanations').val();

                                        $('#preview_price').html(price);
                                        $('#preview_invoice_explanations').html("\""+invoice_explanations+"\"");

                                        if(invoice_explanations=="")
                                        {
                                            $('#check_explanations').addClass('d-none');
                                        }
                                        else
                                        {
                                            $('#check_explanations').removeClass('d-none');
                                        }

                                    });
                                </script>
                                <div class="modal fade" id="pricerequestModal<?= $o_id; ?>" tabindex="-1" aria-labelledby="pricerequestModalLabel<?= $o_id; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="pricerequestModalLabel<?= $o_id; ?>">Price request email preview</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-dark text-left">
                                                <?php
                                                
                                                $seller=$prod->get_licence_taker($o_id);
                                                $message="";
                                                $message.="<b>From:</b> ".$seller['Email']."<br>";
                                                $message.="<b>To:</b> info@bauvorschau.de,".$boss['email'];
                                                if($client['mc_id']==1)
                                                {
                                                    $message.=",nina.dornheim@streif.de";
                                                }
                                                $message.="<br><br>";
                                                $message.="<b>";
                                                //hello 
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0001","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0001","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0001","x-texts2")['text'];
                                                    $message.=$text;
                                                }
                                                
                                                $message.="&nbsp;".	$boss['c_first_name']." ".$boss['c_last_name'].",</b>";
                                                $message.="<br><br>";
                                                
                                                //We received the order 
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0049","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0049","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0049","x-texts2")['text'];
                                                    $message.=$text;
                                                }
                                                
                                                $message.="&nbsp;<b>".$o_id."&nbsp;, ".$order['order_name']."</b>&nbsp;";
                                                
                                                //from 
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0050","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0050","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0050","x-texts2")['text'];
                                                    $message.=$text;
                                                }
                                                
                                                $message.="&nbsp;".$client['c_first_name']." ".$client['c_last_name']."&nbsp;";
                                                
                                                //and shall produce (list of pictures, panoramas,etc.)  
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0051","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0051","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0051","x-texts2")['text'];
                                                    $message.=$text;
                                                }
                                                
                                                $message.="<div id=\"check_explanations\" class=\"\">";
                                                    $message.="<br><br>";
                                                    //Explanations:   
                                                    if(isset($order['client_language_id']))
                                                    {
                                                        $text=$domenia->get_translation_text($order['client_language_id'],"tm_0054","x-texts2")['text'];
                                                        if(!empty($text))
                                                        {
                                                            $message.=$text;
                                                        }
                                                        else
                                                        {
                                                            $text=$domenia->get_translation_text(1,"tm_0054","x-texts2")['text'];
                                                            $message.=$text;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0054","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                    
                                                    $message.="<div id=\"preview_invoice_explanations\"></div>";
                                                
                                                    $message.="</div>";
                                                

                                                $message.="<br>";
                                                $message.="<div class=\"d-flex\">";
                                                //The price would be (price excl. VAT) net:  
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0052","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0052","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0052","x-texts2")['text'];
                                                    $message.=$text;
                                                }
                                                
                                                
                                                $message.="&nbsp;<div id=\"preview_price\"></div>&nbsp;EUR";
                                                $message.="</div>";
                                                
                                                
                                                $message.="<br>";
                                                //Shall we do that ?  
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0053","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0053","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0053","x-texts2")['text'];
                                                    $message.=$text;
                                                }
                                                
                                                $message.="<br><br><b>";
                                                //Beste Grüße  
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0055","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0055","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0055","x-texts2")['text'];
                                                    $message.=$text;
                                                }

                                                $message.="</b><br><br>";
                                                //Das Team der Bauvorschau  
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tm_0056","x-texts2")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $message.=$text;
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tm_0056","x-texts2")['text'];
                                                        $message.=$text;
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tm_0056","x-texts2")['text'];
                                                    $message.=$text;
                                                }

                                                $message.=$notifications2->add_signature($order['lic_ID'],$order['client_language_id']); 

                                                $subject="";
                                                
                                                if(isset($order['client_language_id']))
                                                {
                                                    $text=$domenia->get_translation_text($order['client_language_id'],"tx_1764","x-texts")['text'];
                                                    if(!empty($text))
                                                    {
                                                        $subject=$text." ".$order['order_name'];
                                                    }
                                                    else
                                                    {
                                                        $text=$domenia->get_translation_text(1,"tx_1764","x-texts")['text'];
                                                        $subject=$text." ".$order['order_name'];
                                                    }
                                                }
                                                else
                                                {
                                                    $text=$domenia->get_translation_text(1,"tx_1764","x-texts")['text'];
                                                    $subject=$text." ".$order['order_name'];
                                                }

                                                echo "<b>Subject:</b> ".$order['order_ID']." - ".$subject."<br>";
                                                echo $message;
                                                ?>

                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <div id="price_request_at_superior_message">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" id="send_preview_btn<?php echo $o_id;?>" data-boss_client_id="<?php echo $boss['client_ID'];?>" data-client_language="<?php echo $order['client_language_id'];?>" data-o_id="<?php echo $o_id;?>" class="btn btn-primary">Send</button>
                                                <script type="text/javascript">
                                                    $(document).ready(function(){
                                                        let price=$('#total_special_agreement_price').val();
                                                        let invoice_explanations=$('#invoice_explanations').val();

                                                        $('#preview_price').html(price);
                                                        $('#preview_invoice_explanations').html("\""+invoice_explanations+"\"");

                                                    });

                                                    $('#send_preview_btn<?php echo $o_id;?>').click(function()
                                                    {
                                                        let boss_client_id=$(this).data('boss_client_id');
                                                        let client_language=$(this).data('client_language');
                                                        let o_id=$(this).data('o_id');
                                                        let price=$('#total_special_agreement_price').val();
                                                        let invoice_explanations=$('#invoice_explanations').val();

                                                        

                                                        if(boss_client_id!="")
                                                        {
                                                            $.ajax({
                                                                url: "<?php echo $base_url;?>ajax/send_price_request_to_superior.php",
                                                                method: "post",
                                                                data: {boss_client_id:boss_client_id,client_language:client_language,o_id:o_id,price:price,invoice_explanations:invoice_explanations},
                                                                dataType:"html",
                                                                success:function(data) {
                                                                    $('#price_request_at_superior_message').html(data);

                                                                    setTimeout(function(){$('#pricerequestModal<?= $o_id; ?>').modal('hide')},3000);
                                                                }
                                                            });
                                                        }
                                                        else
                                                        {
                                                            let html = "<div class=\"alert alert-danger\">";
                                                            html += "Error ! No boss id defined !";
                                                            html += "</div>";

                                                            $('#price_request_at_superior_message').html(html);
                                                        }

                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-sm btn-primary" name="temp_save_btn" title="<?php if((isset($_GET['status']))&&($_GET['status']=="accepted")){ echo "Button disabled. Order is accepted.";}?>" form="order_details" <?php if((isset($_GET['status']))&&($_GET['status']=="accepted")){ echo "disabled";} ?>>Save</button>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>                
			</div>
			<!-- <div class="row form-inline w-100 mx-0 d-flex justify-content-center">
				<div class="col-md-12 border border-top-0 border-bottom-0 pb-2 d-flex justify-content-center py-1">
					
				</div>
			</div> -->

			<input type="hidden" name="cur_fac" id="cur_fac" value="<?php echo $cur_factor; ?>" form="order_details">
			<input type="hidden" name="budget" id="budget" value="<?php
			if(strpos($order['collection'],'p1001')!==false)
			{
				echo "1";
			}?>" form="order_details">

			<div class="row form-inline w-100 mx-0" style="background-color: #6c2b2b; padding-top:2vh; padding-bottom: 2vh;">
                <span style="color: white; position: absolute; padding-left:2%;">Final Step:</span>
				<div class="col-md-12 pb-2 border-bottom-0 d-flex justify-content-center py-1 pt-3" style="background-color: #6c2b2b;color:#fff; align-items: center;">
					<b><span style="font-size:14px;">Producer:&nbsp;&nbsp;&nbsp;</span></b>
					<input form="order_details" type="hidden" id="producerid" name="producerid"  value="<?php
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
                    <a href="message_to_client.php?o_id=<?php echo $o_id; ?>" class="btn btn-warning btn-sm border" style="margin-left: 2vh;   display: flex;
                        align-items: center;">Message to client <i class="fas fa-envelope ml-2"></i></a>
                    <?php
                    if((!isset($_GET['status']))/*&&($_GET['status']!="accepted")*/)
                    {
                    ?>
                    <a href="orderdetails.php?o_id=<?php echo $o_id; ?>&clientid=<?php echo $clientid; ?>&status=rejected" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm border" style="    display: flex;
                        align-items: center;">Reject <i class="fas fa-user-times ml-2"></i></a>
                    <?php
                    }
                    ?>

                    <button class="btn btn-sm <?php echo ($order['notifications'] == 1) ? "btn-success" : "btn-dark"; ?> px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
							id="notification2_btn<?php echo $order['order_ID']; ?>" data-o_id="<?php echo $order['order_ID']; ?>" data-notifications="<?php echo $order['notifications'];?>">Notifications
						<span> <?php echo ($order['notifications'] == 1) ? "are ON" : "are OFF"; ?></span></button>
					<script type="text/javascript">
						$("#notification2_btn<?php echo $order['order_ID']; ?>").click(function () {
							$.ajax({
								url: "../ajax/update_notification.php",
								method: "post",
								data: {
									o_id: $(this).data('o_id'),
									notifications: $(this).data('notifications')
								},
								dataType: "html",
								success: function (data) {
									//console.log(data);
									if (data == 0) {
										$("#notification2_btn<?php echo $order['order_ID']; ?>").data("notifications","0");
										$("#notification2_btn<?php echo $order['order_ID']; ?>").html("Notifications <span>are OFF</span>");
										$("#notification2_btn<?php echo $order['order_ID']; ?>").removeClass("btn-success").addClass("btn-dark");
									} else {
										$("#notification2_btn<?php echo $order['order_ID']; ?>").data("notifications","1");
										$("#notification2_btn<?php echo $order['order_ID']; ?>").html("Notifications <span>are ON</span>");
										$("#notification2_btn<?php echo $order['order_ID']; ?>").removeClass("btn-dark").addClass("btn-success");
									}
								},
								error: function (xhr, ajaxOptions, thrownError) {
									console.log(xhr.status);
									console.log(thrownError);
								}
							});
						});
					</script>

                    <?php
                    //accepted order
                    if(isset($_GET['status']))
                    {
                    ?>
                    <br><button name="save_btn" class="btn btn-primary btn-sm" form="order_details">Save changes</button>
                    <?php
                    }

                    //not accepted order
                    if((!isset($_GET['status']))/*&&($_GET['status']!="accepted")*/)
                    {
                    ?>
                    <br>
                    <input id="confirmed_price" type="checkbox" class="checkbox" type="checkbox" value="1"><label for="confirmed_price">Price is confirmed ?</label>
                    <script type="text/javascript">
                        $('#confirmed_price').click(function(){
                            if(confirm('Are you sure the client confirmed the price ?'))
                            {
                                $('#accept_btn1').prop('disabled',false);
                                $('#accept_btn2').prop('disabled',false);

                                $(this).prop("checked",true);
                            }
                            else
                            {
                                $(this).prop("checked",false);
                                $('#accept_btn1').prop('disabled',true);
                                $('#accept_btn2').prop('disabled',true);
                            }
                        });
                    </script>
                    <button name="accept_btn" id="accept_btn2" class="btn btn-primary btn-sm border" form="order_details" disabled>Accept <i class="fas fa-clipboard-check ml-2"></i></button>
                    <?php
                    }
                    ?>

				</div>
			</div>
            </div> <!-- end grey background from customer files -->
			</div> <!-- all_customer_files -->
			<br>
			</div> <!-- end div container -->	
            <script type='text/javascript' src='js/acceptance.js'></script>	
            <script type="text/javascript">
            $(document).ready(function()
            {
                if($("#producers option:selected" ).val()=="")
                {
                    $('#producers option[value="3"]').prop("selected", true);
                }
            });
            </script>	
			<?php
		}
}
else
{
    session_unset();
    session_destroy();
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
        <div class="error">You must be logged in to view this page !</div>
        <a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
        <br ><br >
    </div>
    <meta http-equiv="refresh" content="2; url=<?php echo $base_url;?>index.php">
    <?php
}
?>
	</article> 
	
	<!-- <script type='text/javascript' src='js/create_order.js'></script>-->
</section>
<?php
include('../footer.php');
?>