<?php
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$for_marketing=$prod->xss_fix($_POST['for_marketing']); //templete order id for marketing
$copy_result_files=$prod->xss_fix($_POST['copy_result_files']);

if(!empty($o_id))
{
    $order=$prod->get_order($o_id);
}

if($for_marketing!=0)
{
    $marketing_order=$prod->get_order($for_marketing);
}
if($copy_result_files!=0)
{
    $copy_result_files_order=$prod->get_order($copy_result_files);
}

if(!empty($order))
{
    if($for_marketing==0)
    {
    $create_data['ls_id']=$order['ls_id'];
    $create_data['u_client_ID']=$order['u_client_ID'];
    $create_data['lic_ID']=$order['lic_ID'];
    $create_data['order_name']=$order['order_name'];
    $create_data['o_extension']=$order['o_extension'];
    $create_data['cur_id']=$order['cur_id'];
    $create_data['client_language_id']=$order['client_language_id'];
    $create_data['on_stock']=$order['on_stock'];
    $create_data['mc_id']=$order['mc_id'];
    $create_data['collection']=$order['collection'];
    $create_data['op_remarks']=$order['op-remarks'];
    $create_data['op_remarks_ex_b5']=$order['op_remarks_ex_b5'];
    $create_data['clients_extras']=$order['clients-extras'];
    $create_data['client_extras_ex_b5']=$order['client_extras_ex_b5'];
    $create_data['environment_address']=$order['environment_address'];
    $create_data['invoice_explanations']=$order['invoice_explanations'];
    $create_data['total_special_agreement_price']=$order['o_special_agreement_price'];
    $create_data['vat_percent']=$order['vat_percent'];
    $create_data['vat_a_id']=$order['vat_a_id'];
    $create_data['u_prod_id']=$order['u_prod_id'];
    $create_data['currentdatetime']=gmdate("Y-m-d H:i:s");
    $create_data['o_status']=0;

    $prod->create_order2(json_encode($create_data));

    $last_order=$prod->show_last_order();

    $o_desc_in_b3=$prod->get_o_desc_in_b3($o_id);

    $create_b3_in_data['b3_col_amount']=$o_desc_in_b3['col_amount_in_b3'];

    $create_b3_in_data['sl_id']=$o_desc_in_b3['sl_id'];
    $create_b3_in_data['cls_id']=$o_desc_in_b3['cls_id'];

    $create_b3_in_data['p1301_fac']=$o_desc_in_b3['p1301_fac'];
    $create_b3_in_data['p1302_fac']=$o_desc_in_b3['p1302_fac'];
    $create_b3_in_data['p1321_fac']=$o_desc_in_b3['p1321_fac'];
    $create_b3_in_data['p1322_fac']=$o_desc_in_b3['p1322_fac'];

    $create_b3_in_data['fac_cl_in_b3']=$o_desc_in_b3['fac_cl_in_b3'];
    $create_b3_in_data['fac_prod_in_b3']=$o_desc_in_b3['fac_prod_in_b3'];
    $create_b3_in_data['fac_labc_in_b3']=$o_desc_in_b3['fac_labc_in_b3'];

    $create_b3_in_data['o_id']=$last_order['order_ID'];  

    $prod->add_o_desc_in_b32(json_encode($create_b3_in_data));	

    $o_desc_in_b5=$prod->get_o_desc_in_b5($o_id);

    $create_b5_in_data['b5_col_amount']=$o_desc_in_b5['col_amount_in_b5'];
    $create_b5_in_data['layout_id']=$o_desc_in_b5['layout_id'];
    $create_b5_in_data['window_id']=$o_desc_in_b5['window_id'];

    $create_b5_in_data['p1501_fac']=$o_desc_in_b5['p1501_fac'];
    $create_b5_in_data['p1502_fac']=$o_desc_in_b5['p1502_fac'];
    $create_b5_in_data['p1503_fac']=$o_desc_in_b5['p1503_fac'];
    $create_b5_in_data['p1504_fac']=$o_desc_in_b5['p1504_fac'];
    $create_b5_in_data['p1506_fac']=$o_desc_in_b5['p1506_fac'];
    $create_b5_in_data['p1507_fac']=$o_desc_in_b5['p1507_fac'];
    $create_b5_in_data['p1508_fac']=$o_desc_in_b5['p1508_fac'];

    $create_b5_in_data['p1521_fac']=$o_desc_in_b5['p1521_fac'];
    $create_b5_in_data['p1522_fac']=$o_desc_in_b5['p1522_fac'];
    $create_b5_in_data['p1523_fac']=$o_desc_in_b5['p1523_fac'];
    $create_b5_in_data['p1524_fac']=$o_desc_in_b5['p1524_fac'];
    $create_b5_in_data['p1526_fac']=$o_desc_in_b5['p1526_fac'];
    $create_b5_in_data['p1527_fac']=$o_desc_in_b5['p1527_fac'];
    $create_b5_in_data['p1528_fac']=$o_desc_in_b5['p1528_fac'];

    $create_b5_in_data['p1541_fac']=$o_desc_in_b5['p1541_fac'];
    $create_b5_in_data['p1542_fac']=$o_desc_in_b5['p1542_fac'];
    $create_b5_in_data['p1543_fac']=$o_desc_in_b5['p1543_fac'];
    $create_b5_in_data['p1544_fac']=$o_desc_in_b5['p1544_fac'];                
    $create_b5_in_data['p1546_fac']=$o_desc_in_b5['p1546_fac'];
    $create_b5_in_data['p1547_fac']=$o_desc_in_b5['p1547_fac'];
    $create_b5_in_data['p1548_fac']=$o_desc_in_b5['p1548_fac'];

    $create_b5_in_data['fac_cl_in_b5']=$o_desc_in_b5['fac_cl_in_b5'];
    $create_b5_in_data['fac_prod_in_b5']=$o_desc_in_b5['fac_prod_in_b5'];
    $create_b5_in_data['fac_labc_in_b5']=$o_desc_in_b5['fac_labc_in_b5'];

    $create_b5_in_data['o_id']=$last_order['order_ID'];

    $prod->add_o_desc_in_b52(json_encode($create_b5_in_data));				

    $o_desc_in_b6=$prod->get_o_desc_in_b6($o_id);

    $create_b6_in_data['b6_col_amount']=$o_desc_in_b6['col_amount_in_b6'];
    $create_b6_in_data['layout_id']=$o_desc_in_b6['layout_id'];
    $create_b6_in_data['window_id']=$o_desc_in_b6['window_id'];
				
    $create_b6_in_data['fac_cl_in_b6']=$o_desc_in_b6['fac_cl_in_b6'];
    $create_b6_in_data['fac_prod_in_b6']=$o_desc_in_b6['fac_prod_in_b6'];
    $create_b6_in_data['fac_labc_in_b6']=$o_desc_in_b6['fac_labc_in_b6'];

    $create_b6_in_data['p1600_fac']=$o_desc_in_b6['p1600_fac'];
    $create_b6_in_data['p1601_fac']=$o_desc_in_b6['p1601_fac'];
    $create_b6_in_data['p1602_fac']=$o_desc_in_b6['p1602_fac'];
    $create_b6_in_data['p1603_fac']=$o_desc_in_b6['p1603_fac'];
    $create_b6_in_data['p1604_fac']=$o_desc_in_b6['p1604_fac'];
    $create_b6_in_data['p1606_fac']=$o_desc_in_b6['p1606_fac'];
    $create_b6_in_data['p1607_fac']=$o_desc_in_b6['p1607_fac'];
    $create_b6_in_data['p1608_fac']=$o_desc_in_b6['p1608_fac'];

    $create_b6_in_data['p1621_fac']=$o_desc_in_b6['p1621_fac'];
    $create_b6_in_data['p1622_fac']=$o_desc_in_b6['p1622_fac'];
    $create_b6_in_data['p1623_fac']=$o_desc_in_b6['p1623_fac'];
    $create_b6_in_data['p1624_fac']=$o_desc_in_b6['p1624_fac'];
    $create_b6_in_data['p1626_fac']=$o_desc_in_b6['p1626_fac'];
    $create_b6_in_data['p1627_fac']=$o_desc_in_b6['p1627_fac'];
    $create_b6_in_data['p1628_fac']=$o_desc_in_b6['p1628_fac'];

    $create_b6_in_data['p1641_fac']=$o_desc_in_b6['p1641_fac'];
    $create_b6_in_data['p1642_fac']=$o_desc_in_b6['p1642_fac'];
    $create_b6_in_data['p1643_fac']=$o_desc_in_b6['p1643_fac'];
    $create_b6_in_data['p1644_fac']=$o_desc_in_b6['p1644_fac'];
    $create_b6_in_data['p1646_fac']=$o_desc_in_b6['p1646_fac'];
    $create_b6_in_data['p1647_fac']=$o_desc_in_b6['p1647_fac'];
    $create_b6_in_data['p1648_fac']=$o_desc_in_b6['p1648_fac'];

    $create_b6_in_data['o_id']=$last_order['order_ID'];

    $prod->add_o_desc_in_b6(json_encode($create_b6_in_data));

    $o_desc_in_b7=$prod->get_o_desc_in_b7($o_id);

    $create_b7_in_data['col_amount_in_b7']=$o_desc_in_b7['col_amount_in_b7'];
    $create_b7_in_data['layout_id']=$o_desc_in_b7['layout_id'];				
    $create_b7_in_data['window_id']=$o_desc_in_b7['window_id'];
    
    $create_b7_in_data['fac_cl_in_b7']=$o_desc_in_b7['fac_cl_in_b7'];
    $create_b7_in_data['fac_prod_in_b7']=$o_desc_in_b7['fac_prod_in_b7'];
    $create_b7_in_data['fac_labc_in_b7']=$o_desc_in_b7['fac_labc_in_b7'];

    $create_b7_in_data['p1700_fac']=$o_desc_in_b7['p1700_fac'];
    $create_b7_in_data['p1701_fac']=$o_desc_in_b7['p1701_fac'];
    $create_b7_in_data['p1702_fac']=$o_desc_in_b7['p1702_fac'];
    $create_b7_in_data['p1703_fac']=$o_desc_in_b7['p1703_fac'];
    $create_b7_in_data['p1704_fac']=$o_desc_in_b7['p1704_fac'];
    $create_b7_in_data['p1706_fac']=$o_desc_in_b7['p1706_fac'];
    $create_b7_in_data['p1707_fac']=$o_desc_in_b7['p1707_fac'];
    $create_b7_in_data['p1708_fac']=$o_desc_in_b7['p1708_fac'];

    $create_b7_in_data['p1721_fac']=$o_desc_in_b7['p1721_fac'];
    $create_b7_in_data['p1722_fac']=$o_desc_in_b7['p1722_fac'];
    $create_b7_in_data['p1723_fac']=$o_desc_in_b7['p1723_fac'];
    $create_b7_in_data['p1724_fac']=$o_desc_in_b7['p1724_fac'];
    $create_b7_in_data['p1726_fac']=$o_desc_in_b7['p1726_fac'];
    $create_b7_in_data['p1727_fac']=$o_desc_in_b7['p1727_fac'];
    $create_b7_in_data['p1728_fac']=$o_desc_in_b7['p1728_fac'];

    $create_b7_in_data['p1741_fac']=$o_desc_in_b7['p1741_fac'];
    $create_b7_in_data['p1742_fac']=$o_desc_in_b7['p1742_fac'];
    $create_b7_in_data['p1743_fac']=$o_desc_in_b7['p1743_fac'];
    $create_b7_in_data['p1744_fac']=$o_desc_in_b7['p1744_fac'];                
    $create_b7_in_data['p1746_fac']=$o_desc_in_b7['p1746_fac'];
    $create_b7_in_data['p1747_fac']=$o_desc_in_b7['p1747_fac'];
    $create_b7_in_data['p1748_fac']=$o_desc_in_b7['p1748_fac'];
  
    $create_b7_in_data['o_id']=$last_order['order_ID']; 

    $prod->add_o_desc_in_b72(json_encode($create_b7_in_data));

    $o_desc_in_b8=$prod->get_o_desc_in_b8($o_id);

    $create_b8_in_data['col_amount_in_b8']=$o_desc_in_b8['col_amount_in_b8'];
    $create_b8_in_data['layout_id']=$o_desc_in_b8['layout_id'];
    $create_b8_in_data['window_id']=$o_desc_in_b8['window_id'];
	        
    $create_b8_in_data['fac_cl_in_b8']=$o_desc_in_b8['fac_cl_in_b8'];
    $create_b8_in_data['fac_prod_in_b8']=$o_desc_in_b8['fac_prod_in_b8'];
    $create_b8_in_data['fac_labc_in_b8']=$o_desc_in_b8['fac_labc_in_b8'];

    $create_b8_in_data['p1800_fac']=$o_desc_in_b8['p1800_fac'];
    $create_b8_in_data['p1801_fac']=$o_desc_in_b8['p1801_fac'];
    $create_b8_in_data['p1802_fac']=$o_desc_in_b8['p1802_fac'];
    $create_b8_in_data['p1803_fac']=$o_desc_in_b8['p1803_fac'];
    $create_b8_in_data['p1804_fac']=$o_desc_in_b8['p1804_fac'];
    $create_b8_in_data['p1806_fac']=$o_desc_in_b8['p1806_fac'];
    $create_b8_in_data['p1807_fac']=$o_desc_in_b8['p1807_fac'];
    $create_b8_in_data['p1808_fac']=$o_desc_in_b8['p1808_fac'];

    $create_b8_in_data['p1821_fac']=$o_desc_in_b8['p1821_fac'];
    $create_b8_in_data['p1822_fac']=$o_desc_in_b8['p1822_fac'];
    $create_b8_in_data['p1823_fac']=$o_desc_in_b8['p1823_fac'];
    $create_b8_in_data['p1824_fac']=$o_desc_in_b8['p1824_fac'];
    $create_b8_in_data['p1826_fac']=$o_desc_in_b8['p1826_fac'];
    $create_b8_in_data['p1827_fac']=$o_desc_in_b8['p1827_fac'];
    $create_b8_in_data['p1828_fac']=$o_desc_in_b8['p1828_fac'];

    $create_b8_in_data['p1841_fac']=$o_desc_in_b8['p1841_fac'];
    $create_b8_in_data['p1842_fac']=$o_desc_in_b8['p1842_fac'];
    $create_b8_in_data['p1843_fac']=$o_desc_in_b8['p1843_fac'];
    $create_b8_in_data['p1844_fac']=$o_desc_in_b8['p1844_fac'];
    $create_b8_in_data['p1846_fac']=$o_desc_in_b8['p1846_fac'];
    $create_b8_in_data['p1847_fac']=$o_desc_in_b8['p1847_fac'];
    $create_b8_in_data['p1848_fac']=$o_desc_in_b8['p1848_fac'];   

    $create_b8_in_data['o_id']=$last_order['order_ID']; 

    $prod->add_o_desc_in_b8(json_encode($create_b8_in_data));

    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_id);

    $create_b5_ex_data['col_amount_ex_b5']=$o_desc_ex_b5['col_amount_ex_b5'];

    $create_b5_ex_data['fac_cl_ex_b5']=$o_desc_ex_b5['fac_cl_ex_b5'];    
    $create_b5_ex_data['fac_prod_ex_b5']=$o_desc_ex_b5['fac_prod_ex_b5'];
    $create_b5_ex_data['fac_labc_ex_b5']=$o_desc_ex_b5['fac_labc_ex_b5'];

    $create_b5_ex_data['p1561_fac']=$o_desc_ex_b5['p1561_fac'];
    $create_b5_ex_data['p1563_fac']=$o_desc_ex_b5['p1563_fac'];
    $create_b5_ex_data['p1566_fac']=$o_desc_ex_b5['p1566_fac'];

    $create_b5_ex_data['o_id']=$last_order['order_ID'];

    $prod->add_o_desc_ex_b52(json_encode($create_b5_ex_data));

    $o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_id);

    $create_b6_ex_data['col_amount_ex_b6']=$o_desc_ex_b6['col_amount_ex_b6'];

    $create_b6_ex_data['fac_cl_ex_b6']=$o_desc_ex_b6['fac_cl_ex_b6'];
    $create_b6_ex_data['fac_prod_ex_b6']=$o_desc_ex_b6['fac_prod_ex_b6'];
    $create_b6_ex_data['fac_labc_ex_b6']=$o_desc_ex_b6['fac_labc_ex_b6'];
    
    $create_b6_ex_data['p1661_fac']=$o_desc_ex_b6['p1661_fac'];
    $create_b6_ex_data['p1663_fac']=$o_desc_ex_b6['p1663_fac'];
    $create_b6_ex_data['p1666_fac']=$o_desc_ex_b6['p1666_fac'];

    $create_b6_ex_data['o_id']=$last_order['order_ID'];

    $prod->add_o_desc_ex_b6(json_encode($create_b6_ex_data));

    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_id);

    $create_b7_ex_data['col_amount_ex_b7']=$o_desc_ex_b7['col_amount_ex_b7'];

    $create_b7_ex_data['fac_cl_ex_b7']=$o_desc_ex_b7['fac_cl_ex_b7'];
    $create_b7_ex_data['fac_prod_ex_b7']=$o_desc_ex_b7['fac_prod_ex_b7'];
    $create_b7_ex_data['fac_labc_ex_b7']=$o_desc_ex_b7['fac_labc_ex_b7'];
    
    $create_b7_ex_data['p1761_fac']=$o_desc_ex_b7['p1761_fac'];
    $create_b7_ex_data['p1763_fac']=$o_desc_ex_b7['p1763_fac'];
    $create_b7_ex_data['p1766_fac']=$o_desc_ex_b7['p1766_fac'];

    $create_b7_ex_data['o_id']=$last_order['order_ID'];

    $prod->add_o_desc_ex_b72(json_encode($create_b7_ex_data));

    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_id);

    $create_b8_ex_data['col_amount_ex_b8']=$o_desc_ex_b8['col_amount_ex_b8'];

    $create_b8_ex_data['fac_cl_ex_b8']=$o_desc_ex_b8['fac_cl_ex_b8'];
    $create_b8_ex_data['fac_prod_ex_b8']=$o_desc_ex_b8['fac_prod_ex_b8'];
    $create_b8_ex_data['fac_labc_ex_b8']=$o_desc_ex_b8['fac_labc_ex_b8'];

    $create_b8_ex_data['p1861_fac']=$o_desc_ex_b8['p1861_fac'];
    $create_b8_ex_data['p1863_fac']=$o_desc_ex_b8['p1863_fac'];
    $create_b8_ex_data['p1866_fac']=$o_desc_ex_b8['p1866_fac'];

    $create_b8_ex_data['o_id']=$last_order['order_ID'];

    $prod->add_o_desc_ex_b8(json_encode($create_b8_ex_data));

    $o_desc_allproducts=$prod->get_o_infos_allproducts($o_id);

    $o_desc_allproducts_data['o_id']=$last_order['order_ID'];

    $o_desc_allproducts_data['length']=$o_desc_allproducts['length'];
    $o_desc_allproducts_data['width']=$o_desc_allproducts['width'];
    $o_desc_allproducts_data['height']=$o_desc_allproducts['height'];
    $o_desc_allproducts_data['roof_type']=$o_desc_allproducts['roof_type'];
    $o_desc_allproducts_data['roof_tilt']=$o_desc_allproducts['roof_tilt'];
    $o_desc_allproducts_data['knee_wall']=$o_desc_allproducts['knee_wall'];
    $o_desc_allproducts_data['basement']=$o_desc_allproducts['basement'];
    $o_desc_allproducts_data['levels_over_ground']=$o_desc_allproducts['levels_over_ground'];
    $o_desc_allproducts_data['stairs_id']=$o_desc_allproducts['stairs_id'];
    $o_desc_allproducts_data['rop_id']=$o_desc_allproducts['rop_id'];
    $o_desc_allproducts_data['gutter']=$o_desc_allproducts['gutter'];
    $o_desc_allproducts_data['roof_material']=$o_desc_allproducts['roof_material'];
    $o_desc_allproducts_data['wlc_id']=$o_desc_allproducts['wlc_id'];
    $o_desc_allproducts_data['ww_id']=$o_desc_allproducts['ww_id'];
    $o_desc_allproducts_data['wc_id']=$o_desc_allproducts['wc_id'];
    $o_desc_allproducts_data['door_texture']=$o_desc_allproducts['door_texture'];
    $o_desc_allproducts_data['dsp_id']=$o_desc_allproducts['door_shape_sides'];
    $o_desc_allproducts_data['door_color']=$o_desc_allproducts['door_color'];
    $o_desc_allproducts_data['gc_id']=$o_desc_allproducts['gc_id'];
    $o_desc_allproducts_data['gc_length']=$o_desc_allproducts['gc_length'];
    $o_desc_allproducts_data['gc_width']=$o_desc_allproducts['gc_width'];
    $o_desc_allproducts_data['gc_height']=$o_desc_allproducts['gc_height'];
    $o_desc_allproducts_data['pbp_id']=$o_desc_allproducts['pbp_id'];

    $prod->add_o_desc_allproducts(json_encode($o_desc_allproducts_data));

    $customer_files=$prod->get_customer_files($o_id);

    $year=date("Y");
    $new_of_path_dom=$year."/".$last_order['order_ID']."/";
    $client_files_dir = "client_files/";
    $output_dir="../".$client_files_dir.$year."/".$last_order['order_ID'];
    $result_files_dir="result_files/";
    $result_files_output_dir="../".$result_files_dir.$year."/".$last_order['order_ID'];

    if(!file_exists($output_dir)) {
        mkdir($output_dir, 0755, true);
    }

    for($i=0;$i<count($customer_files);$i++)
    {
        $add_customer_files_data['o_id'] = $last_order['order_ID'];
        $add_customer_files_data['of_kind'] = $customer_files[$i]['of_kind'];
        $add_customer_files_data['of_subtitle'] = $customer_files[$i]['of_subtitle'];
        $add_customer_files_data['of_position'] = $customer_files[$i]['of_position'];
        $add_customer_files_data['of_exterior_position'] = $customer_files[$i]['of_exterior_position'];
        $add_customer_files_data['of_name_client'] = $customer_files[$i]['of_name_client'];
        $add_customer_files_data['of_name'] = $customer_files[$i]['of_name'];
        $add_customer_files_data['of_name_ex'] = $customer_files[$i]['of_name_ex'];
        $add_customer_files_data['of_level'] = $customer_files[$i]['of_level'];
        $add_customer_files_data['of_path_dom'] = $new_of_path_dom;
        $add_customer_files_data['of_internal_name_dom'] = $customer_files[$i]['of_internal_name_dom'];
        $add_customer_files_data['of_type_dom'] = $customer_files[$i]['of_type_dom'];

        $prod->add_order_files2(json_encode($add_customer_files_data));

        copy("../".$client_files_dir.$customer_files[$i]['of_path_dom'].$customer_files[$i]['of_internal_name_dom'],"../".$client_files_dir.$new_of_path_dom.$customer_files[$i]['of_internal_name_dom']);
    }

    if($copy_result_files==1)
    {
        if(!file_exists($result_files_output_dir)) {
            mkdir($result_files_output_dir, 0755, true);
        }

        $results=$prod->show_results_by_order($o_id);
        
        for($i=0;$i<count($results);$i++)
        {
        $new_result['o_id']=$last_order['order_ID'];;
        $new_result['om_id']=$results[$i]['om_id'];
        $new_result['osub_id'] = $results[$i]['osub_id'];
        $new_result['prod_id'] = $results[$i]['prod_id']; 
        $new_result['uca_id'] = $results[$i]['uca_id']; 
        $new_result['main_picture'] = $results[$i]['main_picture']; 
        $new_result['orf_name'] = $results[$i]['orf_name'];

        $old_path=explode('/',$results[$i]['orf_path_dom']);
        
        $new_path=$year."/".$last_order['order_ID']."/".$old_path[2]."/";

        $new_result['orf_path_dom'] = $new_path; 
        $new_result['orf_internal_name_dom'] = $results[$i]['orf_internal_name_dom'];
        $new_result['orf_type_dom'] = $results[$i]['orf_type_dom']; 
        $new_result['optimized_image_path'] = $results[$i]['optimized_image_path'];
        $new_result['orf_thumbnail_path'] = $results[$i]['orf_thumbnail_path'];
        $new_result['orf_compress_path'] = $results[$i]['orf_compress_path'];
        $new_result['orf_upload_date'] = $results[$i]['orf_upload_date']; 
        $new_result['orf_status'] = $results[$i]['orf_status'];
        $new_result['pict_categ_name'] = $results[$i]['pict_categ_name'];
        $new_result['pict_number'] = $results[$i]['pict_number'];

        $prod->copy_creator_result_file(json_encode($new_result));

        if(!file_exists("../".$result_files_dir.$new_path)) {
            mkdir("../".$result_files_dir.$new_path, 0755, true);
        }

        copy("../".$result_files_dir.$results[$i]['orf_path_dom'].$results[$i]['orf_internal_name_dom'],"../".$result_files_dir.$new_path.$results[$i]['orf_internal_name_dom']);
        }
    }
    ?>
    <div class="alert alert-success">Order copied successfully ! New order ID is <a href="orderdetails.php?o_id=<?php echo $last_order['order_ID'];?>"><?php echo $last_order['order_ID'];?></a></div>
    <meta http-equiv="refresh" content="2; url=orderdetails.php?o_id=<?php echo $last_order['order_ID'];?>"> 
    <?php
    }
    else //for marketing
    {
        $create_data['ls_id']=$marketing_order['ls_id'];
        $create_data['u_client_ID']=$marketing_order['u_client_ID'];
        $create_data['lic_ID']=$marketing_order['lic_ID'];
        $create_data['order_name']=$order['order_name'];
        $create_data['o_extension']=$marketing_order['o_extension'];
        $create_data['cur_id']=$marketing_order['cur_id'];
        $create_data['client_language_id']=$marketing_order['client_language_id'];
        $create_data['on_stock']=$marketing_order['on_stock'];
        $create_data['mc_id']=$marketing_order['mc_id'];
        $create_data['collection']=$marketing_order['collection'];
        $create_data['op_remarks']="= ".$o_id." ! ".$marketing_order['op-remarks'];
        $create_data['op_remarks_ex_b5']="= ".$o_id." ! ".$marketing_order['op_remarks_ex_b5'];
        $create_data['clients_extras']=$order['clients-extras'];
        $create_data['client_extras_ex_b5']=$order['client_extras_ex_b5'];
        $create_data['environment_address']=$order['environment_address'];
        $create_data['invoice_explanations']=$marketing_order['invoice_explanations'];
        $create_data['total_special_agreement_price']=$marketing_order['o_special_agreement_price'];
        $create_data['vat_percent']=$marketing_order['vat_percent'];
        $create_data['vat_a_id']=$marketing_order['vat_a_id'];
        $create_data['u_prod_id']=$marketing_order['u_prod_id'];
        $create_data['currentdatetime']=gmdate("Y-m-d H:i:s");
        $create_data['o_status']=0;
    
        $prod->create_order2(json_encode($create_data));
    
        $last_order=$prod->show_last_order();
    
        $o_desc_in_b3=$prod->get_o_desc_in_b3($for_marketing);
    
        $create_b3_in_data['b3_col_amount']=$o_desc_in_b3['col_amount_in_b3'];
    
        $create_b3_in_data['sl_id']=$o_desc_in_b3['sl_id'];
        $create_b3_in_data['cls_id']=$o_desc_in_b3['cls_id'];
    
        $create_b3_in_data['p1301_fac']=$o_desc_in_b3['p1301_fac'];
        $create_b3_in_data['p1302_fac']=$o_desc_in_b3['p1302_fac'];
        $create_b3_in_data['p1321_fac']=$o_desc_in_b3['p1321_fac'];
        $create_b3_in_data['p1322_fac']=$o_desc_in_b3['p1322_fac'];
    
        $create_b3_in_data['fac_cl_in_b3']=$o_desc_in_b3['fac_cl_in_b3'];
        $create_b3_in_data['fac_prod_in_b3']=$o_desc_in_b3['fac_prod_in_b3'];
        $create_b3_in_data['fac_labc_in_b3']=$o_desc_in_b3['fac_labc_in_b3'];
    
        $create_b3_in_data['o_id']=$last_order['order_ID'];  
    
        $prod->add_o_desc_in_b32(json_encode($create_b3_in_data));	
    
        $o_desc_in_b5=$prod->get_o_desc_in_b5($for_marketing);
    
        $create_b5_in_data['b5_col_amount']=$o_desc_in_b5['col_amount_in_b5'];
        $create_b5_in_data['layout_id']=$o_desc_in_b5['layout_id'];
        $create_b5_in_data['window_id']=$o_desc_in_b5['window_id'];
    
        $create_b5_in_data['p1501_fac']=$o_desc_in_b5['p1501_fac'];
        $create_b5_in_data['p1502_fac']=$o_desc_in_b5['p1502_fac'];
        $create_b5_in_data['p1503_fac']=$o_desc_in_b5['p1503_fac'];
        $create_b5_in_data['p1504_fac']=$o_desc_in_b5['p1504_fac'];
        $create_b5_in_data['p1506_fac']=$o_desc_in_b5['p1506_fac'];
        $create_b5_in_data['p1507_fac']=$o_desc_in_b5['p1507_fac'];
        $create_b5_in_data['p1508_fac']=$o_desc_in_b5['p1508_fac'];
    
        $create_b5_in_data['p1521_fac']=$o_desc_in_b5['p1521_fac'];
        $create_b5_in_data['p1522_fac']=$o_desc_in_b5['p1522_fac'];
        $create_b5_in_data['p1523_fac']=$o_desc_in_b5['p1523_fac'];
        $create_b5_in_data['p1524_fac']=$o_desc_in_b5['p1524_fac'];
        $create_b5_in_data['p1526_fac']=$o_desc_in_b5['p1526_fac'];
        $create_b5_in_data['p1527_fac']=$o_desc_in_b5['p1527_fac'];
        $create_b5_in_data['p1528_fac']=$o_desc_in_b5['p1528_fac'];
    
        $create_b5_in_data['p1541_fac']=$o_desc_in_b5['p1541_fac'];
        $create_b5_in_data['p1542_fac']=$o_desc_in_b5['p1542_fac'];
        $create_b5_in_data['p1543_fac']=$o_desc_in_b5['p1543_fac'];
        $create_b5_in_data['p1544_fac']=$o_desc_in_b5['p1544_fac'];                
        $create_b5_in_data['p1546_fac']=$o_desc_in_b5['p1546_fac'];
        $create_b5_in_data['p1547_fac']=$o_desc_in_b5['p1547_fac'];
        $create_b5_in_data['p1548_fac']=$o_desc_in_b5['p1548_fac'];
    
        $create_b5_in_data['fac_cl_in_b5']=$o_desc_in_b5['fac_cl_in_b5'];
        $create_b5_in_data['fac_prod_in_b5']=$o_desc_in_b5['fac_prod_in_b5'];
        $create_b5_in_data['fac_labc_in_b5']=$o_desc_in_b5['fac_labc_in_b5'];
    
        $create_b5_in_data['o_id']=$last_order['order_ID'];
    
        $prod->add_o_desc_in_b52(json_encode($create_b5_in_data));				
    
        $o_desc_in_b6=$prod->get_o_desc_in_b6($for_marketing);
    
        $create_b6_in_data['b6_col_amount']=$o_desc_in_b6['col_amount_in_b6'];
        $create_b6_in_data['layout_id']=$o_desc_in_b6['layout_id'];
        $create_b6_in_data['window_id']=$o_desc_in_b6['window_id'];
                    
        $create_b6_in_data['fac_cl_in_b6']=$o_desc_in_b6['fac_cl_in_b6'];
        $create_b6_in_data['fac_prod_in_b6']=$o_desc_in_b6['fac_prod_in_b6'];
        $create_b6_in_data['fac_labc_in_b6']=$o_desc_in_b6['fac_labc_in_b6'];
    
        $create_b6_in_data['p1600_fac']=$o_desc_in_b6['p1600_fac'];
        $create_b6_in_data['p1601_fac']=$o_desc_in_b6['p1601_fac'];
        $create_b6_in_data['p1602_fac']=$o_desc_in_b6['p1602_fac'];
        $create_b6_in_data['p1603_fac']=$o_desc_in_b6['p1603_fac'];
        $create_b6_in_data['p1604_fac']=$o_desc_in_b6['p1604_fac'];
        $create_b6_in_data['p1606_fac']=$o_desc_in_b6['p1606_fac'];
        $create_b6_in_data['p1607_fac']=$o_desc_in_b6['p1607_fac'];
        $create_b6_in_data['p1608_fac']=$o_desc_in_b6['p1608_fac'];
    
        $create_b6_in_data['p1621_fac']=$o_desc_in_b6['p1621_fac'];
        $create_b6_in_data['p1622_fac']=$o_desc_in_b6['p1622_fac'];
        $create_b6_in_data['p1623_fac']=$o_desc_in_b6['p1623_fac'];
        $create_b6_in_data['p1624_fac']=$o_desc_in_b6['p1624_fac'];
        $create_b6_in_data['p1626_fac']=$o_desc_in_b6['p1626_fac'];
        $create_b6_in_data['p1627_fac']=$o_desc_in_b6['p1627_fac'];
        $create_b6_in_data['p1628_fac']=$o_desc_in_b6['p1628_fac'];
    
        $create_b6_in_data['p1641_fac']=$o_desc_in_b6['p1641_fac'];
        $create_b6_in_data['p1642_fac']=$o_desc_in_b6['p1642_fac'];
        $create_b6_in_data['p1643_fac']=$o_desc_in_b6['p1643_fac'];
        $create_b6_in_data['p1644_fac']=$o_desc_in_b6['p1644_fac'];
        $create_b6_in_data['p1646_fac']=$o_desc_in_b6['p1646_fac'];
        $create_b6_in_data['p1647_fac']=$o_desc_in_b6['p1647_fac'];
        $create_b6_in_data['p1648_fac']=$o_desc_in_b6['p1648_fac'];
    
        $create_b6_in_data['o_id']=$last_order['order_ID'];
    
        $prod->add_o_desc_in_b6(json_encode($create_b6_in_data));
    
        $o_desc_in_b7=$prod->get_o_desc_in_b7($for_marketing);
    
        $create_b7_in_data['col_amount_in_b7']=$o_desc_in_b7['col_amount_in_b7'];
        $create_b7_in_data['layout_id']=$o_desc_in_b7['layout_id'];				
        $create_b7_in_data['window_id']=$o_desc_in_b7['window_id'];
        
        $create_b7_in_data['fac_cl_in_b7']=$o_desc_in_b7['fac_cl_in_b7'];
        $create_b7_in_data['fac_prod_in_b7']=$o_desc_in_b7['fac_prod_in_b7'];
        $create_b7_in_data['fac_labc_in_b7']=$o_desc_in_b7['fac_labc_in_b7'];
    
        $create_b7_in_data['p1700_fac']=$o_desc_in_b7['p1700_fac'];
        $create_b7_in_data['p1701_fac']=$o_desc_in_b7['p1701_fac'];
        $create_b7_in_data['p1702_fac']=$o_desc_in_b7['p1702_fac'];
        $create_b7_in_data['p1703_fac']=$o_desc_in_b7['p1703_fac'];
        $create_b7_in_data['p1704_fac']=$o_desc_in_b7['p1704_fac'];
        $create_b7_in_data['p1706_fac']=$o_desc_in_b7['p1706_fac'];
        $create_b7_in_data['p1707_fac']=$o_desc_in_b7['p1707_fac'];
        $create_b7_in_data['p1708_fac']=$o_desc_in_b7['p1708_fac'];
    
        $create_b7_in_data['p1721_fac']=$o_desc_in_b7['p1721_fac'];
        $create_b7_in_data['p1722_fac']=$o_desc_in_b7['p1722_fac'];
        $create_b7_in_data['p1723_fac']=$o_desc_in_b7['p1723_fac'];
        $create_b7_in_data['p1724_fac']=$o_desc_in_b7['p1724_fac'];
        $create_b7_in_data['p1726_fac']=$o_desc_in_b7['p1726_fac'];
        $create_b7_in_data['p1727_fac']=$o_desc_in_b7['p1727_fac'];
        $create_b7_in_data['p1728_fac']=$o_desc_in_b7['p1728_fac'];
    
        $create_b7_in_data['p1741_fac']=$o_desc_in_b7['p1741_fac'];
        $create_b7_in_data['p1742_fac']=$o_desc_in_b7['p1742_fac'];
        $create_b7_in_data['p1743_fac']=$o_desc_in_b7['p1743_fac'];
        $create_b7_in_data['p1744_fac']=$o_desc_in_b7['p1744_fac'];                
        $create_b7_in_data['p1746_fac']=$o_desc_in_b7['p1746_fac'];
        $create_b7_in_data['p1747_fac']=$o_desc_in_b7['p1747_fac'];
        $create_b7_in_data['p1748_fac']=$o_desc_in_b7['p1748_fac'];
      
        $create_b7_in_data['o_id']=$last_order['order_ID']; 
    
        $prod->add_o_desc_in_b72(json_encode($create_b7_in_data));
    
        $o_desc_in_b8=$prod->get_o_desc_in_b8($for_marketing);
    
        $create_b8_in_data['col_amount_in_b8']=$o_desc_in_b8['col_amount_in_b8'];
        $create_b8_in_data['layout_id']=$o_desc_in_b8['layout_id'];
        $create_b8_in_data['window_id']=$o_desc_in_b8['window_id'];
                
        $create_b8_in_data['fac_cl_in_b8']=$o_desc_in_b8['fac_cl_in_b8'];
        $create_b8_in_data['fac_prod_in_b8']=$o_desc_in_b8['fac_prod_in_b8'];
        $create_b8_in_data['fac_labc_in_b8']=$o_desc_in_b8['fac_labc_in_b8'];
    
        $create_b8_in_data['p1800_fac']=$o_desc_in_b8['p1800_fac'];
        $create_b8_in_data['p1801_fac']=$o_desc_in_b8['p1801_fac'];
        $create_b8_in_data['p1802_fac']=$o_desc_in_b8['p1802_fac'];
        $create_b8_in_data['p1803_fac']=$o_desc_in_b8['p1803_fac'];
        $create_b8_in_data['p1804_fac']=$o_desc_in_b8['p1804_fac'];
        $create_b8_in_data['p1806_fac']=$o_desc_in_b8['p1806_fac'];
        $create_b8_in_data['p1807_fac']=$o_desc_in_b8['p1807_fac'];
        $create_b8_in_data['p1808_fac']=$o_desc_in_b8['p1808_fac'];
    
        $create_b8_in_data['p1821_fac']=$o_desc_in_b8['p1821_fac'];
        $create_b8_in_data['p1822_fac']=$o_desc_in_b8['p1822_fac'];
        $create_b8_in_data['p1823_fac']=$o_desc_in_b8['p1823_fac'];
        $create_b8_in_data['p1824_fac']=$o_desc_in_b8['p1824_fac'];
        $create_b8_in_data['p1826_fac']=$o_desc_in_b8['p1826_fac'];
        $create_b8_in_data['p1827_fac']=$o_desc_in_b8['p1827_fac'];
        $create_b8_in_data['p1828_fac']=$o_desc_in_b8['p1828_fac'];
    
        $create_b8_in_data['p1841_fac']=$o_desc_in_b8['p1841_fac'];
        $create_b8_in_data['p1842_fac']=$o_desc_in_b8['p1842_fac'];
        $create_b8_in_data['p1843_fac']=$o_desc_in_b8['p1843_fac'];
        $create_b8_in_data['p1844_fac']=$o_desc_in_b8['p1844_fac'];
        $create_b8_in_data['p1846_fac']=$o_desc_in_b8['p1846_fac'];
        $create_b8_in_data['p1847_fac']=$o_desc_in_b8['p1847_fac'];
        $create_b8_in_data['p1848_fac']=$o_desc_in_b8['p1848_fac'];   
    
        $create_b8_in_data['o_id']=$last_order['order_ID']; 
    
        $prod->add_o_desc_in_b8(json_encode($create_b8_in_data));
    
        $o_desc_ex_b5=$prod->get_o_desc_ex_b5($for_marketing);
    
        $create_b5_ex_data['col_amount_ex_b5']=$o_desc_ex_b5['col_amount_ex_b5'];
    
        $create_b5_ex_data['fac_cl_ex_b5']=$o_desc_ex_b5['fac_cl_ex_b5'];    
        $create_b5_ex_data['fac_prod_ex_b5']=$o_desc_ex_b5['fac_prod_ex_b5'];
        $create_b5_ex_data['fac_labc_ex_b5']=$o_desc_ex_b5['fac_labc_ex_b5'];
    
        $create_b5_ex_data['p1561_fac']=$o_desc_ex_b5['p1561_fac'];
        $create_b5_ex_data['p1563_fac']=$o_desc_ex_b5['p1563_fac'];
        $create_b5_ex_data['p1566_fac']=$o_desc_ex_b5['p1566_fac'];
    
        $create_b5_ex_data['o_id']=$last_order['order_ID'];
    
        $prod->add_o_desc_ex_b52(json_encode($create_b5_ex_data));
    
        $o_desc_ex_b6=$prod->get_o_desc_ex_b6($for_marketing);
    
        $create_b6_ex_data['col_amount_ex_b6']=$o_desc_ex_b6['col_amount_ex_b6'];
    
        $create_b6_ex_data['fac_cl_ex_b6']=$o_desc_ex_b6['fac_cl_ex_b6'];
        $create_b6_ex_data['fac_prod_ex_b6']=$o_desc_ex_b6['fac_prod_ex_b6'];
        $create_b6_ex_data['fac_labc_ex_b6']=$o_desc_ex_b6['fac_labc_ex_b6'];
        
        $create_b6_ex_data['p1661_fac']=$o_desc_ex_b6['p1661_fac'];
        $create_b6_ex_data['p1663_fac']=$o_desc_ex_b6['p1663_fac'];
        $create_b6_ex_data['p1666_fac']=$o_desc_ex_b6['p1666_fac'];
    
        $create_b6_ex_data['o_id']=$last_order['order_ID'];
    
        $prod->add_o_desc_ex_b6(json_encode($create_b6_ex_data));
    
        $o_desc_ex_b7=$prod->get_o_desc_ex_b7($for_marketing);
    
        $create_b7_ex_data['col_amount_ex_b7']=$o_desc_ex_b7['col_amount_ex_b7'];
    
        $create_b7_ex_data['fac_cl_ex_b7']=$o_desc_ex_b7['fac_cl_ex_b7'];
        $create_b7_ex_data['fac_prod_ex_b7']=$o_desc_ex_b7['fac_prod_ex_b7'];
        $create_b7_ex_data['fac_labc_ex_b7']=$o_desc_ex_b7['fac_labc_ex_b7'];
        
        $create_b7_ex_data['p1761_fac']=$o_desc_ex_b7['p1761_fac'];
        $create_b7_ex_data['p1763_fac']=$o_desc_ex_b7['p1763_fac'];
        $create_b7_ex_data['p1766_fac']=$o_desc_ex_b7['p1766_fac'];
    
        $create_b7_ex_data['o_id']=$last_order['order_ID'];
    
        $prod->add_o_desc_ex_b72(json_encode($create_b7_ex_data));
    
        $o_desc_ex_b8=$prod->get_o_desc_ex_b8($for_marketing);
    
        $create_b8_ex_data['col_amount_ex_b8']=$o_desc_ex_b8['col_amount_ex_b8'];
    
        $create_b8_ex_data['fac_cl_ex_b8']=$o_desc_ex_b8['fac_cl_ex_b8'];
        $create_b8_ex_data['fac_prod_ex_b8']=$o_desc_ex_b8['fac_prod_ex_b8'];
        $create_b8_ex_data['fac_labc_ex_b8']=$o_desc_ex_b8['fac_labc_ex_b8'];
    
        $create_b8_ex_data['p1861_fac']=$o_desc_ex_b8['p1861_fac'];
        $create_b8_ex_data['p1863_fac']=$o_desc_ex_b8['p1863_fac'];
        $create_b8_ex_data['p1866_fac']=$o_desc_ex_b8['p1866_fac'];
    
        $create_b8_ex_data['o_id']=$last_order['order_ID'];
    
        $prod->add_o_desc_ex_b8(json_encode($create_b8_ex_data));
    
        $o_desc_allproducts=$prod->get_o_infos_allproducts($o_id);
    
        $o_desc_allproducts_data['o_id']=$last_order['order_ID'];
    
        $o_desc_allproducts_data['length']=$o_desc_allproducts['length'];
        $o_desc_allproducts_data['width']=$o_desc_allproducts['width'];
        $o_desc_allproducts_data['height']=$o_desc_allproducts['height'];
        $o_desc_allproducts_data['roof_type']=$o_desc_allproducts['roof_type'];
        $o_desc_allproducts_data['roof_tilt']=$o_desc_allproducts['roof_tilt'];
        $o_desc_allproducts_data['knee_wall']=$o_desc_allproducts['knee_wall'];
        $o_desc_allproducts_data['basement']=$o_desc_allproducts['basement'];
        $o_desc_allproducts_data['levels_over_ground']=$o_desc_allproducts['levels_over_ground'];
        $o_desc_allproducts_data['stairs_id']=$o_desc_allproducts['stairs_id'];
        $o_desc_allproducts_data['rop_id']=$o_desc_allproducts['rop_id'];
        $o_desc_allproducts_data['gutter']=$o_desc_allproducts['gutter'];
        $o_desc_allproducts_data['roof_material']=$o_desc_allproducts['roof_material'];
        $o_desc_allproducts_data['wlc_id']=$o_desc_allproducts['wlc_id'];
        $o_desc_allproducts_data['ww_id']=$o_desc_allproducts['ww_id'];
        $o_desc_allproducts_data['wc_id']=$o_desc_allproducts['wc_id'];
        $o_desc_allproducts_data['door_texture']=$o_desc_allproducts['door_texture'];
        $o_desc_allproducts_data['dsp_id']=$o_desc_allproducts['door_shape_sides'];
        $o_desc_allproducts_data['door_color']=$o_desc_allproducts['door_color'];
        $o_desc_allproducts_data['gc_id']=$o_desc_allproducts['gc_id'];
        $o_desc_allproducts_data['gc_length']=$o_desc_allproducts['gc_length'];
        $o_desc_allproducts_data['gc_width']=$o_desc_allproducts['gc_width'];
        $o_desc_allproducts_data['gc_height']=$o_desc_allproducts['gc_height'];
        $o_desc_allproducts_data['pbp_id']=$o_desc_allproducts['pbp_id'];
    
        $prod->add_o_desc_allproducts(json_encode($o_desc_allproducts_data));

        $customer_files=$prod->get_customer_files($o_id);

        $year=date("Y");
        $new_of_path_dom=$year."/".$last_order['order_ID']."/";
        $client_files_dir = "client_files/";
        $output_dir="../".$client_files_dir.$year."/".$last_order['order_ID'];

        if(!file_exists($output_dir)) {
			mkdir($output_dir, 0755, true);
		}

        for($i=0;$i<count($customer_files);$i++)
        {
            $add_customer_files_data['o_id'] = $last_order['order_ID'];
            $add_customer_files_data['of_kind'] = $customer_files[$i]['of_kind'];
            $add_customer_files_data['of_subtitle'] = $customer_files[$i]['of_subtitle'];
            $add_customer_files_data['of_position'] = $customer_files[$i]['of_position'];
            $add_customer_files_data['of_exterior_position'] = $customer_files[$i]['of_exterior_position'];
            $add_customer_files_data['of_name_client'] = $customer_files[$i]['of_name_client'];
            $add_customer_files_data['of_name'] = $customer_files[$i]['of_name'];
            $add_customer_files_data['of_name_ex'] = $customer_files[$i]['of_name_ex'];
            $add_customer_files_data['of_level'] = $customer_files[$i]['of_level'];
            $add_customer_files_data['of_path_dom'] = $new_of_path_dom;
            $add_customer_files_data['of_internal_name_dom'] = $customer_files[$i]['of_internal_name_dom'];
            $add_customer_files_data['of_type_dom'] = $customer_files[$i]['of_type_dom'];

            $prod->add_order_files2(json_encode($add_customer_files_data));

            copy("../".$client_files_dir.$customer_files[$i]['of_path_dom'].$customer_files[$i]['of_internal_name_dom'],"../".$client_files_dir.$new_of_path_dom.$customer_files[$i]['of_internal_name_dom']);
        }
    
    ?>
    <div class="alert alert-success">Order copied successfully ! New order ID is <a href="orderdetails.php?o_id=<?php echo $last_order['order_ID'];?>"><?php echo $last_order['order_ID'];?></a></div>
    <meta http-equiv="refresh" content="2; url=orderdetails.php?o_id=<?php echo $last_order['order_ID'];?>"> 
    <?php
    }
}
else
{
?>
<div class="alert alert-danger">Order does not exist !</div>
<?php
}
?>