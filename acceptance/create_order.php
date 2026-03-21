<?php
session_start();

include('../functions.php');
include('../../../../domenia7.com/public_html/domenia_db2.php');
include('../../../../cseven.eu/public_html/domenia/domenia.php');
include('../../../../superfloorplans.com/public_html/functions.php');
include('../../../../superfloorplans.com/public_html/price_calculations.php');
include('../domenia3n_db.php');


$prod=new Production;
$price=new PriceCalculations;
$domenia2=new Domenia2;
$domenia=new Domenia;
$domenia3n=new Domenia3n;

$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Create Order";

include('../header2.php');

include('../menu.php');



$selected_lang=1;





?>

<section class="top_section">

    <article>

        <div class="container text-center pagecontent bg-white px-0">

            <p class="pt-4 display-4">Acceptance - Contracting</p>

            <hr class="mb-4" width="450px">

            <?php

            include('submenu.php');

            ?>

            <br> <br>

            <div class="py-2 row mx-0 w-100 mt-2" style="font-size: 30px;"><p class="text-center text-primary w-100">Create new order</p></div>

            <?php

            if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
            {

            if(isset($_POST['create_btn']))
            {

                ?>

                <div class="text-center">

                    <div class="alert alert-warning">Processing... Please wait... </div>

                </div>

                <?php

                $create_data['ls_id']=$prod->xss_fix($_POST['ls_id']);
                $create_data['u_client_ID']=$prod->xss_fix($_POST['purchaser']);
                $create_data['lic_ID']=$prod->xss_fix($_POST['licenceid']);
                $create_data['order_name']=$prod->xss_fix($_POST['order_name']);
                if(!empty($_POST['o_extension']))
                {
                    $create_data['o_extension']=$prod->xss_fix($_POST['o_extension']);
                }
                else
                {
                    $create_data['o_extension']='0';
                }
                $create_data['cur_id']=$prod->xss_fix($_POST['cur_id']);
                $create_data['client_language_id']=$prod->xss_fix($_POST['client_language']);
                $create_data['on_stock']=$prod->xss_fix($_POST['on_stock']);
                if(!empty($_POST['o_deadline']))
                {
                    $create_data['o_deadline_utc']=$prod->xss_fix($_POST['o_deadline']);
                }
                else
                {
                    $create_data['o_deadline_utc']='0000-00-00 00:00:00';
                }
                
                $create_data['mc_id']=$prod->get_client($create_data['u_client_ID'])['mc_id'];
                $create_data['no_upload_files']=$prod->xss_fix($_POST['no_upload_files']);
                $create_data['collection']=$prod->xss_fix($_POST['collection'] ?? 'p1301;p1321;p1322;p1561;p1562;p1563;p1581');

                //b1 in

                if(
                    (strpos($create_data['collection'],'p1103') !== false)||
                    (strpos($create_data['collection'],'p1104') !== false)||
                    (strpos($create_data['collection'],'p1106') !== false)||
                    (strpos($create_data['collection'],'p1108') !== false)
                )
                {
                    $create_b1_in_data['col_amount_in_b1']=$prod->xss_fix($_POST['col_amount1_in_b1'] ?? 0);
                }

                else
                {
                    $create_b1_in_data['col_amount_in_b1']=0;
                }


                $create_b1_in_data['col_price_in_b1']=$prod->xss_fix($_POST['col_price_in_b1'] ?? 0.0);
                $create_b1_in_data['fac_cl_in_b1']=$prod->xss_fix($_POST['fac_cl_in_b1'] ?? 1.0);
                $create_b1_in_data['o_price_in_b1']=$prod->xss_fix($_POST['o_price_in_b1'] ?? 0.0);

                $create_b1_in_data['col_apus_in_b1']=$prod->xss_fix($_POST['col_apus_in_b1'] ?? 0.0);
                $create_b1_in_data['fac_prod_in_b1']=$prod->xss_fix($_POST['fac_prod_in_b1'] ?? 1.0);
                $create_b1_in_data['o_apus_in_b1']=$prod->xss_fix($_POST['o_apus_in_b1'] ?? 0.0);

                $create_b1_in_data['col_labc_in_b1']=$prod->xss_fix($_POST['col_labc_in_b1'] ?? 0.0);
                $create_b1_in_data['total_labcs_in_b1']=$prod->xss_fix($_POST['total_labcs_in_b1'] ?? 0.0);
                $create_b1_in_data['fac_labc_in_b1']=$prod->xss_fix($_POST['fac_labc_in_b1'] ?? 1.0);

                //b3 in

                if(strpos($create_data['collection'],'p1301') !== false)
                {
                    $create_b3_in_data['b3_col_amount']=$prod->xss_fix($_POST['col_amount1_in_b3'] ?? 0);
                }

                else
                {
                    $create_b3_in_data['b3_col_amount']=1;
                }

                $create_b3_in_data['sl_id']=$prod->xss_fix($_POST['sl_id'] ?? '');
                $create_b3_in_data['cls_id']=$prod->xss_fix($_POST['cls_id'] ?? '');

                $create_b3_in_data['p1301_fac']=$prod->xss_fix($_POST['p1301_fac'] ?? 1.0);
                $create_b3_in_data['p1302_fac']=$prod->xss_fix($_POST['p1302_fac'] ?? 1.0);
                $create_b3_in_data['p1321_fac']=$prod->xss_fix($_POST['p1321_fac'] ?? 1.0);
                $create_b3_in_data['p1322_fac']=$prod->xss_fix($_POST['p1322_fac'] ?? 1.0);

                $create_b3_in_data['col_price_in_b3']=$prod->xss_fix($_POST['col_price_in_b3'] ?? 0.0);
                $create_b3_in_data['fac_cl_in_b3']=$prod->xss_fix($_POST['fac_cl_in_b3'] ?? 1.0);
                $create_b3_in_data['o_price_in_b3']=$prod->xss_fix($_POST['o_price_in_b3'] ?? 0.0);

                $create_b3_in_data['col_apus_in_b3']=$prod->xss_fix($_POST['col_apus_in_b3'] ?? 0.0);
                $create_b3_in_data['fac_prod_in_b3']=$prod->xss_fix($_POST['fac_prod_in_b3'] ?? 1.0);
                $create_b3_in_data['o_apus_in_b3']=$prod->xss_fix($_POST['o_apus_in_b3'] ?? 0.0);

                $create_b3_in_data['col_labc_in_b3']=$prod->xss_fix($_POST['col_labc_in_b3'] ?? 0.0);
                $create_b3_in_data['total_labcs_in_b3']=$prod->xss_fix($_POST['total_labcs_in_b3'] ?? 0.0);
                $create_b3_in_data['fac_labc_in_b3']=$prod->xss_fix($_POST['fac_labc_in_b3'] ?? 1.0);


                //b5 in

                $create_b5_in_data['layout_id']=$prod->xss_fix($_POST['b5_selected_layoutline'] ?? '0');

                if(strpos($create_data['collection'],'p1501') !== false)
                {
                    $create_b5_in_data['b5_col_amount']=$prod->xss_fix($_POST['col_amount1_in_b5'] ?? 0);
                }

                else

                {

                    $create_b5_in_data['b5_col_amount']=1;

                }

                $create_b5_in_data['col_price_in_b5']=$prod->xss_fix($_POST['col_price_in_b5'] ?? 0.0);

                $create_b5_in_data['fac_cl_in_b5']=$prod->xss_fix($_POST['fac_cl_in_b5'] ?? 1.0);

                $create_b5_in_data['o_price_in_b5']=$prod->xss_fix($_POST['o_price_in_b5'] ?? 0.0);



                $create_b5_in_data['p1501_fac']=$prod->xss_fix($_POST['p1501_fac'] ?? 1.0);

                $create_b5_in_data['p1502_fac']=$prod->xss_fix($_POST['p1502_fac'] ?? 1.0);

                $create_b5_in_data['p1503_fac']=$prod->xss_fix($_POST['p1503_fac'] ?? 1.0);

                $create_b5_in_data['p1504_fac']=$prod->xss_fix($_POST['p1504_fac'] ?? 1.0);

                $create_b5_in_data['p1506_fac']=$prod->xss_fix($_POST['p1506_fac'] ?? 1.0);

                $create_b5_in_data['p1507_fac']=$prod->xss_fix($_POST['p1507_fac'] ?? 1.0);

                $create_b5_in_data['p1508_fac']=$prod->xss_fix($_POST['p1508_fac'] ?? 1.0);



                $create_b5_in_data['p1521_fac']=$prod->xss_fix($_POST['p1521_fac'] ?? 1.0);

                $create_b5_in_data['p1522_fac']=$prod->xss_fix($_POST['p1522_fac'] ?? 1.0);

                $create_b5_in_data['p1523_fac']=$prod->xss_fix($_POST['p1523_fac'] ?? 1.0);

                $create_b5_in_data['p1524_fac']=$prod->xss_fix($_POST['p1524_fac'] ?? 1.0);

                $create_b5_in_data['p1526_fac']=$prod->xss_fix($_POST['p1526_fac'] ?? 1.0);

                $create_b5_in_data['p1527_fac']=$prod->xss_fix($_POST['p1527_fac'] ?? 1.0);

                $create_b5_in_data['p1528_fac']=$prod->xss_fix($_POST['p1528_fac'] ?? 1.0);



                $create_b5_in_data['p1541_fac']=$prod->xss_fix($_POST['p1541_fac'] ?? 1.0);

                $create_b5_in_data['p1542_fac']=$prod->xss_fix($_POST['p1542_fac'] ?? 1.0);

                $create_b5_in_data['p1543_fac']=$prod->xss_fix($_POST['p1543_fac'] ?? 1.0);

                $create_b5_in_data['p1544_fac']=$prod->xss_fix($_POST['p1544_fac'] ?? 1.0);

                $create_b5_in_data['p1546_fac']=$prod->xss_fix($_POST['p1546_fac'] ?? 1.0);

                $create_b5_in_data['p1547_fac']=$prod->xss_fix($_POST['p1547_fac'] ?? 1.0);

                $create_b5_in_data['p1548_fac']=$prod->xss_fix($_POST['p1548_fac'] ?? 1.0);



                $create_b5_in_data['col_apus_in_b5']=$prod->xss_fix($_POST['col_apus_in_b5'] ?? 0.0);

                $create_b5_in_data['fac_prod_in_b5']=$prod->xss_fix($_POST['fac_prod_in_b5'] ?? 1.0);

                $create_b5_in_data['o_apus_in_b5']=$prod->xss_fix($_POST['o_apus_in_b5'] ?? 0.0);



                $create_b5_in_data['col_labc_in_b5']=$prod->xss_fix($_POST['col_labc_in_b5'] ?? 0.0);

                $create_b5_in_data['total_labc_in_b5']=$prod->xss_fix($_POST['total_labcs_in_b5'] ?? 0.0);

                $create_b5_in_data['fac_labc_in_b5']=$prod->xss_fix($_POST['fac_labc_in_b5'] ?? 1.0);



                //b6 in

                $create_b6_in_data['layout_id']=$prod->xss_fix($_POST['b6_selected_layoutline'] ?? '0');



                if(strpos($create_data['collection'],'p1601') !== false)

                {

                    $create_b6_in_data['b6_col_amount']=$prod->xss_fix($_POST['col_amount1_in_b6'] ?? 0);

                }

                else

                {

                    $create_b6_in_data['b6_col_amount']=0;

                }

                $create_b6_in_data['col_price_in_b6']=$prod->xss_fix($_POST['col_price_in_b6'] ?? 0.0);

                $create_b6_in_data['fac_cl_in_b6']=$prod->xss_fix($_POST['fac_cl_in_b6'] ?? 1.0);

                $create_b6_in_data['o_price_in_b6']=$prod->xss_fix($_POST['o_price_in_b6'] ?? 0.0);



                $create_b6_in_data['p1600_fac']=$prod->xss_fix($_POST['p1600_fac'] ?? 1.0);

                $create_b6_in_data['p1601_fac']=$prod->xss_fix($_POST['p1601_fac'] ?? 1.0);

                $create_b6_in_data['p1602_fac']=$prod->xss_fix($_POST['p1602_fac'] ?? 1.0);

                $create_b6_in_data['p1603_fac']=$prod->xss_fix($_POST['p1603_fac'] ?? 1.0);

                $create_b6_in_data['p1604_fac']=$prod->xss_fix($_POST['p1604_fac'] ?? 1.0);

                $create_b6_in_data['p1606_fac']=$prod->xss_fix($_POST['p1606_fac'] ?? 1.0);

                $create_b6_in_data['p1607_fac']=$prod->xss_fix($_POST['p1607_fac'] ?? 1.0);

                $create_b6_in_data['p1608_fac']=$prod->xss_fix($_POST['p1608_fac'] ?? 1.0);



                $create_b6_in_data['p1621_fac']=$prod->xss_fix($_POST['p1621_fac'] ?? 1.0);

                $create_b6_in_data['p1622_fac']=$prod->xss_fix($_POST['p1622_fac'] ?? 1.0);

                $create_b6_in_data['p1623_fac']=$prod->xss_fix($_POST['p1623_fac'] ?? 1.0);

                $create_b6_in_data['p1624_fac']=$prod->xss_fix($_POST['p1624_fac'] ?? 1.0);

                $create_b6_in_data['p1626_fac']=$prod->xss_fix($_POST['p1626_fac'] ?? 1.0);

                $create_b6_in_data['p1627_fac']=$prod->xss_fix($_POST['p1627_fac'] ?? 1.0);

                $create_b6_in_data['p1628_fac']=$prod->xss_fix($_POST['p1628_fac'] ?? 1.0);



                $create_b6_in_data['p1641_fac']=$prod->xss_fix($_POST['p1641_fac'] ?? 1.0);

                $create_b6_in_data['p1642_fac']=$prod->xss_fix($_POST['p1642_fac'] ?? 1.0);

                $create_b6_in_data['p1643_fac']=$prod->xss_fix($_POST['p1643_fac'] ?? 1.0);

                $create_b6_in_data['p1644_fac']=$prod->xss_fix($_POST['p1644_fac'] ?? 1.0);

                $create_b6_in_data['p1646_fac']=$prod->xss_fix($_POST['p1646_fac'] ?? 1.0);

                $create_b6_in_data['p1647_fac']=$prod->xss_fix($_POST['p1647_fac'] ?? 1.0);

                $create_b6_in_data['p1648_fac']=$prod->xss_fix($_POST['p1648_fac'] ?? 1.0);



                $create_b6_in_data['col_apus_in_b6']=$prod->xss_fix($_POST['col_apus_in_b6'] ?? 0.0);

                $create_b6_in_data['fac_prod_in_b6']=$prod->xss_fix($_POST['fac_prod_in_b6'] ?? 1.0);

                $create_b6_in_data['o_apus_in_b6']=$prod->xss_fix($_POST['o_apus_in_b6'] ?? 0.0);



                $create_b6_in_data['col_labc_in_b6']=$prod->xss_fix($_POST['col_labc_in_b6'] ?? 0.0);

                $create_b6_in_data['total_labc_in_b6']=$prod->xss_fix($_POST['total_labcs_in_b6'] ?? 0.0);

                $create_b6_in_data['fac_labc_in_b6']=$prod->xss_fix($_POST['fac_labc_in_b6'] ?? 1.0);



                //b7 in



                $create_b7_in_data['layout_id']=$prod->xss_fix($_POST['b7_selected_layoutline'] ?? '0');



                if(strpos($create_data['collection'],'p1701') !== false)

                {

                    $create_b7_in_data['col_amount_in_b7']=$prod->xss_fix($_POST['col_amount1_in_b7'] ?? 0);

                }

                else

                {

                    $create_b7_in_data['col_amount_in_b7']=0;

                }

                $create_b7_in_data['col_price_in_b7']=$prod->xss_fix($_POST['col_price_in_b7'] ?? 0.0);

                $create_b7_in_data['fac_cl_in_b7']=$prod->xss_fix($_POST['fac_cl_in_b7'] ?? 1.0);

                $create_b7_in_data['o_price_in_b7']=$prod->xss_fix($_POST['o_price_in_b7'] ?? 0.0);



                $create_b7_in_data['p1700_fac']=$prod->xss_fix($_POST['p1700_fac'] ?? 1.0);

                $create_b7_in_data['p1701_fac']=$prod->xss_fix($_POST['p1701_fac'] ?? 1.0);

                $create_b7_in_data['p1702_fac']=$prod->xss_fix($_POST['p1702_fac'] ?? 1.0);

                $create_b7_in_data['p1703_fac']=$prod->xss_fix($_POST['p1703_fac'] ?? 1.0);

                $create_b7_in_data['p1704_fac']=$prod->xss_fix($_POST['p1704_fac'] ?? 1.0);

                $create_b7_in_data['p1706_fac']=$prod->xss_fix($_POST['p1706_fac'] ?? 1.0);

                $create_b7_in_data['p1707_fac']=$prod->xss_fix($_POST['p1707_fac'] ?? 1.0);

                $create_b7_in_data['p1708_fac']=$prod->xss_fix($_POST['p1708_fac'] ?? 1.0);



                $create_b7_in_data['p1721_fac']=$prod->xss_fix($_POST['p1721_fac'] ?? 1.0);

                $create_b7_in_data['p1722_fac']=$prod->xss_fix($_POST['p1722_fac'] ?? 1.0);

                $create_b7_in_data['p1723_fac']=$prod->xss_fix($_POST['p1723_fac'] ?? 1.0);

                $create_b7_in_data['p1724_fac']=$prod->xss_fix($_POST['p1724_fac'] ?? 1.0);

                $create_b7_in_data['p1726_fac']=$prod->xss_fix($_POST['p1726_fac'] ?? 1.0);

                $create_b7_in_data['p1727_fac']=$prod->xss_fix($_POST['p1727_fac'] ?? 1.0);

                $create_b7_in_data['p1728_fac']=$prod->xss_fix($_POST['p1728_fac'] ?? 1.0);



                $create_b7_in_data['p1741_fac']=$prod->xss_fix($_POST['p1741_fac'] ?? 1.0);

                $create_b7_in_data['p1742_fac']=$prod->xss_fix($_POST['p1742_fac'] ?? 1.0);

                $create_b7_in_data['p1743_fac']=$prod->xss_fix($_POST['p1743_fac'] ?? 1.0);

                $create_b7_in_data['p1744_fac']=$prod->xss_fix($_POST['p1744_fac'] ?? 1.0);

                $create_b7_in_data['p1746_fac']=$prod->xss_fix($_POST['p1746_fac'] ?? 1.0);

                $create_b7_in_data['p1747_fac']=$prod->xss_fix($_POST['p1747_fac'] ?? 1.0);

                $create_b7_in_data['p1748_fac']=$prod->xss_fix($_POST['p1748_fac'] ?? 1.0);



                $create_b7_in_data['col_apus_in_b7']=$prod->xss_fix($_POST['col_apus_in_b7'] ?? 0.0);

                $create_b7_in_data['fac_prod_in_b7']=$prod->xss_fix($_POST['fac_prod_in_b7'] ?? 1.0);

                $create_b7_in_data['o_apus_in_b7']=$prod->xss_fix($_POST['o_apus_in_b7'] ?? 0.0);



                $create_b7_in_data['col_labc_in_b7']=$prod->xss_fix($_POST['col_labc_in_b7'] ?? 0.0);

                $create_b7_in_data['total_labc_in_b7']=$prod->xss_fix($_POST['total_labcs_in_b7'] ?? 0.0);

                $create_b7_in_data['fac_labc_in_b7']=$prod->xss_fix($_POST['fac_labc_in_b7'] ?? 1.0);



                //b8 in



                $create_b8_in_data['layout_id']=$prod->xss_fix($_POST['b8_selected_layoutline'] ?? '0');



                if(strpos($create_data['collection'],'p1801') !== false)

                {

                    $create_b8_in_data['col_amount_in_b8']=$prod->xss_fix($_POST['col_amount1_in_b8'] ?? 0);

                }

                else

                {

                    $create_b8_in_data['col_amount_in_b8']=0;

                }

                $create_b8_in_data['col_price_in_b8']=$prod->xss_fix($_POST['col_price_in_b8'] ?? 0.0);

                $create_b8_in_data['fac_cl_in_b8']=$prod->xss_fix($_POST['fac_cl_in_b8'] ?? 1.0);

                $create_b8_in_data['o_price_in_b8']=$prod->xss_fix($_POST['o_price_in_b8'] ?? 0.0);



                $create_b8_in_data['p1800_fac']=$prod->xss_fix($_POST['p1800_fac'] ?? 1.0);

                $create_b8_in_data['p1801_fac']=$prod->xss_fix($_POST['p1801_fac'] ?? 1.0);

                $create_b8_in_data['p1802_fac']=$prod->xss_fix($_POST['p1802_fac'] ?? 1.0);

                $create_b8_in_data['p1803_fac']=$prod->xss_fix($_POST['p1803_fac'] ?? 1.0);

                $create_b8_in_data['p1804_fac']=$prod->xss_fix($_POST['p1804_fac'] ?? 1.0);

                $create_b8_in_data['p1806_fac']=$prod->xss_fix($_POST['p1806_fac'] ?? 1.0);

                $create_b8_in_data['p1807_fac']=$prod->xss_fix($_POST['p1807_fac'] ?? 1.0);

                $create_b8_in_data['p1808_fac']=$prod->xss_fix($_POST['p1808_fac'] ?? 1.0);



                $create_b8_in_data['p1821_fac']=$prod->xss_fix($_POST['p1821_fac'] ?? 1.0);

                $create_b8_in_data['p1822_fac']=$prod->xss_fix($_POST['p1822_fac'] ?? 1.0);

                $create_b8_in_data['p1823_fac']=$prod->xss_fix($_POST['p1823_fac'] ?? 1.0);

                $create_b8_in_data['p1824_fac']=$prod->xss_fix($_POST['p1824_fac'] ?? 1.0);

                $create_b8_in_data['p1826_fac']=$prod->xss_fix($_POST['p1826_fac'] ?? 1.0);

                $create_b8_in_data['p1827_fac']=$prod->xss_fix($_POST['p1827_fac'] ?? 1.0);

                $create_b8_in_data['p1828_fac']=$prod->xss_fix($_POST['p1828_fac'] ?? 1.0);



                $create_b8_in_data['p1841_fac']=$prod->xss_fix($_POST['p1841_fac'] ?? 1.0);

                $create_b8_in_data['p1842_fac']=$prod->xss_fix($_POST['p1842_fac'] ?? 1.0);

                $create_b8_in_data['p1843_fac']=$prod->xss_fix($_POST['p1843_fac'] ?? 1.0);

                $create_b8_in_data['p1844_fac']=$prod->xss_fix($_POST['p1844_fac'] ?? 1.0);

                $create_b8_in_data['p1846_fac']=$prod->xss_fix($_POST['p1846_fac'] ?? 1.0);

                $create_b8_in_data['p1847_fac']=$prod->xss_fix($_POST['p1847_fac'] ?? 1.0);

                $create_b8_in_data['p1848_fac']=$prod->xss_fix($_POST['p1848_fac'] ?? 1.0);



                $create_b8_in_data['col_apus_in_b8']=$prod->xss_fix($_POST['col_apus_in_b8'] ?? 0.0);

                $create_b8_in_data['fac_prod_in_b8']=$prod->xss_fix($_POST['fac_prod_in_b8'] ?? 1.0);

                $create_b8_in_data['o_apus_in_b8']=$prod->xss_fix($_POST['o_apus_in_b8'] ?? 0.0);



                $create_b8_in_data['col_labc_in_b8']=$prod->xss_fix($_POST['col_labc_in_b8'] ?? 0.0);

                $create_b8_in_data['total_labc_in_b8']=$prod->xss_fix($_POST['total_labcs_in_b8'] ?? 0.0);

                $create_b8_in_data['fac_labc_in_b8']=$prod->xss_fix($_POST['fac_labc_in_b8'] ?? 1.0);



                //b5 ex


                $create_b1_ex_data['col_price_ex_b1']=$prod->xss_fix($_POST['col_price_ex_b1'] ?? 0.0);

                $create_b1_ex_data['fac_cl_ex_b1']=$prod->xss_fix($_POST['fac_cl_ex_b1'] ?? 1.0);



                if(
                    (strpos($create_data['collection'],'p1163') !== false)||
                    (strpos($create_data['collection'],'p1166') !== false)||
                    (strpos($create_data['collection'],'p1168') !== false)||
                    (strpos($create_data['collection'],'p116b') !== false)||
                    (strpos($create_data['collection'],'p116m') !== false)||
                    (strpos($create_data['collection'],'p116t') !== false)
                )
                {

                    $create_b1_ex_data['col_amount_ex_b1']=$prod->xss_fix($_POST['col_amount1_ex_b1'] ?? 0);

                }

                else

                {

                    $create_b1_ex_data['col_amount_ex_b1']=0;

                }



                $create_b1_ex_data['o_price_ex_b1']=$prod->xss_fix($_POST['o_price_ex_b1'] ?? 0.0);


                $create_b1_ex_data['col_apus_ex_b1']=$prod->xss_fix($_POST['col_apus_ex_b1'] ?? 0.0);
                $create_b1_ex_data['fac_prod_ex_b1']=$prod->xss_fix($_POST['fac_prod_ex_b1'] ?? 1.0);
                $create_b1_ex_data['o_apus_ex_b1']=$prod->xss_fix($_POST['o_apus_ex_b1'] ?? 0.0);

                $create_b1_ex_data['col_labc_ex_b1']=$prod->xss_fix($_POST['col_labc_ex_b1'] ?? 0.0);
                $create_b1_ex_data['fac_labc_ex_b1']=$prod->xss_fix($_POST['fac_labc_ex_b1'] ?? 1.0);
                $create_b1_ex_data['total_labcs_ex_b1']=$prod->xss_fix($_POST['total_labcs_ex_b1'] ?? 0.0);



                //b5 ex



                $create_b5_ex_data['col_price_ex_b5']=$prod->xss_fix($_POST['col_price_ex_b5'] ?? 0.0);

                $create_b5_ex_data['fac_cl_ex_b5']=$prod->xss_fix($_POST['fac_cl_ex_b5'] ?? 1.0);



                if(strpos($create_data['collection'],'p1561') !== false)

                {

                    $create_b5_ex_data['col_amount_ex_b5']=$prod->xss_fix($_POST['col_amount1_ex_b5'] ?? 0);

                }

                else

                {

                    $create_b5_ex_data['col_amount_ex_b5']=1;

                }



                $create_b5_ex_data['o_price_ex_b5']=$prod->xss_fix($_POST['o_price_ex_b5'] ?? 0.0);



                $create_b5_ex_data['p1561_fac']=$prod->xss_fix($_POST['p1561_fac'] ?? 1.0);

                $create_b5_ex_data['p1563_fac']=$prod->xss_fix($_POST['p1563_fac'] ?? 1.0);

                $create_b5_ex_data['p1566_fac']=$prod->xss_fix($_POST['p1566_fac'] ?? 1.0);



                $create_b5_ex_data['col_apus_ex_b5']=$prod->xss_fix($_POST['col_apus_ex_b5'] ?? 0.0);

                $create_b5_ex_data['fac_prod_ex_b5']=$prod->xss_fix($_POST['fac_prod_ex_b5'] ?? 1.0);

                $create_b5_ex_data['o_apus_ex_b5']=$prod->xss_fix($_POST['o_apus_ex_b5'] ?? 0.0);



                $create_b5_ex_data['col_labc_ex_b5']=$prod->xss_fix($_POST['col_labc_ex_b5'] ?? 0.0);

                $create_b5_ex_data['fac_labc_ex_b5']=$prod->xss_fix($_POST['fac_labc_ex_b5'] ?? 1.0);

                $create_b5_ex_data['total_labcs_ex_b5']=$prod->xss_fix($_POST['total_labcs_ex_b5'] ?? 0.0);





                //b6 ex



                $create_b6_ex_data['col_price_ex_b6']=$prod->xss_fix($_POST['col_price_ex_b6'] ?? 0.0);

                $create_b6_ex_data['fac_cl_ex_b6']=$prod->xss_fix($_POST['fac_cl_ex_b6'] ?? 1.0);



                if(strpos($create_data['collection'],'p1661') !== false)

                {

                    $create_b6_ex_data['col_amount_ex_b6']=$prod->xss_fix($_POST['col_amount1_ex_b6'] ?? 0);

                }

                else

                {

                    $create_b6_ex_data['col_amount_ex_b6']=0;

                }



                $create_b6_ex_data['o_price_ex_b6']=$prod->xss_fix($_POST['o_price_ex_b6'] ?? 0.0);



                $create_b6_ex_data['p1661_fac']=$prod->xss_fix($_POST['p1661_fac'] ?? 1.0);

                $create_b6_ex_data['p1663_fac']=$prod->xss_fix($_POST['p1663_fac'] ?? 1.0);

                $create_b6_ex_data['p1666_fac']=$prod->xss_fix($_POST['p1666_fac'] ?? 1.0);



                $create_b6_ex_data['col_apus_ex_b6']=$prod->xss_fix($_POST['col_apus_ex_b6'] ?? 0.0);

                $create_b6_ex_data['fac_prod_ex_b6']=$prod->xss_fix($_POST['fac_prod_ex_b6'] ?? 1.0);

                $create_b6_ex_data['o_apus_ex_b6']=$prod->xss_fix($_POST['o_apus_ex_b6'] ?? 0.0);



                $create_b6_ex_data['col_labc_ex_b6']=$prod->xss_fix($_POST['col_labc_ex_b6'] ?? 0.0);

                $create_b6_ex_data['fac_labc_ex_b6']=$prod->xss_fix($_POST['fac_labc_ex_b6'] ?? 1.0);

                $create_b6_ex_data['total_labcs_ex_b6']=$prod->xss_fix($_POST['total_labcs_ex_b6'] ?? 0.0);







                $create_b7_ex_data['col_price_ex_b7']=$prod->xss_fix($_POST['col_price_ex_b7'] ?? 0.0);

                $create_b7_ex_data['fac_cl_ex_b7']=$prod->xss_fix($_POST['fac_cl_ex_b7'] ?? 1.0);



                if(strpos($create_data['collection'],'p1761') !== false)

                {

                    $create_b7_ex_data['col_amount_ex_b7']=$prod->xss_fix($_POST['col_amount1_ex_b7'] ?? 0);

                }

                else

                {

                    $create_b7_ex_data['col_amount_ex_b7']=0;

                }

                $create_b7_ex_data['o_price_ex_b7']=$prod->xss_fix($_POST['o_price_ex_b7'] ?? 0.0);



                $create_b7_ex_data['p1761_fac']=$prod->xss_fix($_POST['p1761_fac'] ?? 1.0);

                $create_b7_ex_data['p1763_fac']=$prod->xss_fix($_POST['p1763_fac'] ?? 1.0);

                $create_b7_ex_data['p1766_fac']=$prod->xss_fix($_POST['p1766_fac'] ?? 1.0);



                $create_b7_ex_data['col_apus_ex_b7']=$prod->xss_fix($_POST['col_apus_ex_b7'] ?? 0.0);

                $create_b7_ex_data['fac_prod_ex_b7']=$prod->xss_fix($_POST['fac_prod_ex_b7'] ?? 1.0);

                $create_b7_ex_data['o_apus_ex_b7']=$prod->xss_fix($_POST['o_apus_ex_b7'] ?? 0.0);



                $create_b7_ex_data['col_labc_ex_b7']=$prod->xss_fix($_POST['col_labc_ex_b7'] ?? 0.0);

                $create_b7_ex_data['fac_labc_ex_b7']=$prod->xss_fix($_POST['fac_labc_ex_b7'] ?? 1.0);

                $create_b7_ex_data['total_labcs_ex_b7']=$prod->xss_fix($_POST['total_labcs_ex_b7'] ?? 0.0);



                // B8 EX

                $create_b8_ex_data['col_price_ex_b8']=$prod->xss_fix($_POST['col_price_ex_b8'] ?? 0.0);

                $create_b8_ex_data['fac_cl_ex_b8']=$prod->xss_fix($_POST['fac_cl_ex_b8'] ?? 1.0);







                if(strpos($create_data['collection'],'p1861') !== false)

                {

                    $create_b8_ex_data['col_amount_ex_b8']=$prod->xss_fix($_POST['col_amount1_ex_b8'] ?? 0);

                }

                else

                {

                    $create_b8_ex_data['col_amount_ex_b8']=0;

                }

                $create_b8_ex_data['o_price_ex_b8']=$prod->xss_fix($_POST['o_price_ex_b8'] ?? 0.0);



                $create_b8_ex_data['p1861_fac']=$prod->xss_fix($_POST['p1861_fac'] ?? 1.0);
                $create_b8_ex_data['p1863_fac']=$prod->xss_fix($_POST['p1863_fac'] ?? 1.0);
                $create_b8_ex_data['p1866_fac']=$prod->xss_fix($_POST['p1866_fac'] ?? 1.0);

                $create_b8_ex_data['col_apus_ex_b8']=$prod->xss_fix($_POST['col_apus_ex_b8'] ?? 0.0);
                $create_b8_ex_data['fac_prod_ex_b8']=$prod->xss_fix($_POST['fac_prod_ex_b8'] ?? 1.0);
                $create_b8_ex_data['o_apus_ex_b8']=$prod->xss_fix($_POST['o_apus_ex_b8'] ?? 0.0);

                $create_b8_ex_data['col_labc_ex_b8']=$prod->xss_fix($_POST['col_labc_ex_b8'] ?? 0.0);
                $create_b8_ex_data['fac_labc_ex_b8']=$prod->xss_fix($_POST['fac_labc_ex_b8'] ?? 1.0);
                $create_b8_ex_data['total_labcs_ex_b8']=$prod->xss_fix($_POST['total_labcs_ex_b8'] ?? 0.0);


                $create_data['clients_extras']=$prod->xss_fix($_POST['customer_remarks_in'] ?? '');
                $create_data['op_remarks']=$prod->xss_fix($_POST['op_remarks_in'] ?? '');

                $create_data['client_extras_ex_b5']=$prod->xss_fix($_POST['customer_remarks_ex'] ?? '');
                $create_data['op_remarks_ex_b5']=$prod->xss_fix($_POST['op_remarks_ex'] ?? '');
                $create_data['environment_address']=$prod->xss_fix($_POST['environment_address'] ?? '');
                $create_data['o_price']=$prod->xss_fix($_POST['total_price'] ?? 0.0);
                $create_data['total_special_agreement_price']=$prod->xss_fix($_POST['total_special_agreement_price'] ?? 0.0);
                $create_data['vat_percent']=$prod->xss_fix($_POST['vat_percent'] ?? 0.0);
                $create_data['vat_a_id']=$prod->xss_fix($_POST['vat_a_id']);
                $create_data['vat_amount']=number_format(floor(($create_data['o_price'] * $create_data['vat_percent'] / 100)*100)/100,2, '.', '');
                $create_data['brut_price']=number_format(floor(($create_data['o_price'] + $create_data['vat_amount'])*100)/100,2, '.', '');
                $create_data['u_prod_id']=$prod->xss_fix($_POST['producers'] ?? 0);
                $create_data['currentdatetime']=gmdate("Y-m-d H:i:s");
                $create_data['o_status']=0;

                $create_data['public']=0;

                $public_order=$prod->get_client($create_data['u_client_ID'])['public_presentation'];

                if($public_order==1)
                {
                    $create_data['public']=1;
                }
                
                $prod->create_order2(json_encode($create_data));
                
                $last_order=$prod->show_last_order();

                $create_b1_in_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_in_b1(json_encode($create_b1_in_data));

                $create_b3_in_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_in_b32(json_encode($create_b3_in_data));

                $create_b5_in_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_in_b52(json_encode($create_b5_in_data));

                $create_b6_in_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_in_b6(json_encode($create_b6_in_data));

                $create_b1_ex_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_ex_b1(json_encode($create_b1_ex_data));

                $create_b5_ex_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_ex_b52(json_encode($create_b5_ex_data));

                $create_b6_ex_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_ex_b6(json_encode($create_b6_ex_data));

                $create_b7_in_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_in_b72(json_encode($create_b7_in_data));

                $create_b8_in_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_in_b8(json_encode($create_b8_in_data));

                $create_b7_ex_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_ex_b72(json_encode($create_b7_ex_data));

                $create_b8_ex_data['o_id']=$last_order['order_ID'];
                $prod->add_o_desc_ex_b8(json_encode($create_b8_ex_data));

                $o_desc_allproducts_data['o_id']=$last_order['order_ID'];
                $o_desc_allproducts_data['length']=$prod->xss_fix($_POST['e_length'] ?? 0.0);
                $o_desc_allproducts_data['width']=$prod->xss_fix($_POST['e_width'] ?? 0.0);
                $o_desc_allproducts_data['roof_type']=$prod->xss_fix($_POST['rs_id'] ?? '');
                $o_desc_allproducts_data['roof_tilt']=$prod->xss_fix($_POST['r_tilt'] ?? '');
                $o_desc_allproducts_data['knee_wall']=$prod->xss_fix($_POST['r_kneewall'] ?? '');
                $o_desc_allproducts_data['basement']=$prod->xss_fix($_POST['basement'] ?? 0);
                $o_desc_allproducts_data['levels_over_ground']=$prod->xss_fix($_POST['levels_over_ground'] ?? 0);
                $o_desc_allproducts_data['stairs_id']=$prod->xss_fix($_POST['st_id0'] ?? '');
                $o_desc_allproducts_data['rop_id']=$prod->xss_fix($_POST['rop_id'] ?? '');
                $o_desc_allproducts_data['roof_material']=$prod->xss_fix($_POST['roof_color'] ?? '');
                $b5_facade_color_1=$prod->xss_fix($_POST['facade_color_1'] ?? '');
                $b5_facade_color_2=$prod->xss_fix($_POST['facade_color_2'] ?? '');
                $o_desc_allproducts_data['wlc_id']=$b5_facade_color_1.";".$b5_facade_color_2.";";
                $o_desc_allproducts_data['ww_id']=$prod->xss_fix($_POST['ww_id'] ?? '');
                $o_desc_allproducts_data['wc_id']=$prod->xss_fix($_POST['wc_id'] ?? '');
                $o_desc_allproducts_data['door_texture']=$prod->xss_fix($_POST['door_texture'] ?? '');
                $o_desc_allproducts_data['dsp_id']=$prod->xss_fix($_POST['door_shape_sides'] ?? '');
                $o_desc_allproducts_data['door_color']=$prod->xss_fix($_POST['door_color'] ?? '');
                $o_desc_allproducts_data['gc_id']=$prod->xss_fix($_POST['gc_id'] ?? '');
                $b5_garage_size=$prod->xss_fix($_POST['garage_size'] ?? '');

                if($b5_garage_size=="3x6")
                {

                    $o_desc_allproducts_data['gc_length']=3;

                    $o_desc_allproducts_data['gc_width']=6;

                }

                if($b5_garage_size=="6x6")

                {

                    $o_desc_allproducts_data['gc_length']=6;

                    $o_desc_allproducts_data['gc_width']=6;

                }

                if($b5_garage_size=="6x9")

                {

                    $o_desc_allproducts_data['gc_length']=6;

                    $o_desc_allproducts_data['gc_width']=9;

                }



                $o_desc_allproducts_data['pbp_id']=$prod->xss_fix($_POST['environment'] ?? '');

                
                $prod->add_o_desc_allproducts(json_encode($o_desc_allproducts_data));

                



                $collection=explode(';',$create_data['collection']);


                if(!empty($create_b1_in_data['col_amount_in_b1']))
                {
                    for($i=1;$i<=$create_b1_in_data['col_amount_in_b1'];$i++)
                    {
                        for($j=0;$j<count($collection);$j++)
                        {

                            if((substr($collection[$j],1)>1100)&&(substr($collection[$j],1)<1160))

                            {

                                $add_b1_in_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)
                                {
                                    $add_b1_in_o_prods['osub_id']="n0".$i;
                                }
                                else
                                {
                                    $add_b1_in_o_prods['osub_id']="n".$i;
                                }

                                $add_b1_in_o_prods['prod_id']=$collection[$j];

                                $add_b1_in_o_prods['p_status']=1;

                                $prod->add_order_products2(json_encode($add_b1_in_o_prods));

                            }

                        }

                    }

                }


                if(!empty($create_b3_in_data['b3_col_amount']))

                {

                    for($i=1;$i<=$create_b3_in_data['b3_col_amount'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1300)&&(substr($collection[$j],1)<1500))

                            {

                                $add_b3_in_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)

                                {

                                    $add_b3_in_o_prods['osub_id']="n0".$i;

                                }

                                else

                                {

                                    $add_b3_in_o_prods['osub_id']="n".$i;

                                }

                                $add_b3_in_o_prods['prod_id']=$collection[$j];



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

                                /*if(substr($collection[$j],1)==1301)

								{

									$prod->add_order_products($last_order['order_ID'],$i,$collection[$j],$p_status=3);

								}

								else

								{

									$prod->add_order_products($last_order['order_ID'],$i,$collection[$j],$p_status=1);

								}*/

                            }

                        }

                    }

                }



                if(!empty($create_b5_in_data['b5_col_amount']))

                {

                    for($i=1;$i<=$create_b5_in_data['b5_col_amount'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1500)&&(substr($collection[$j],1)<1560))

                            {

                                $add_b5_in_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)

                                {



                                    $add_b5_in_o_prods['osub_id']="n0".$i;

                                }

                                else

                                {

                                    $add_b5_in_o_prods['osub_id']="n".$i;

                                }

                                $add_b5_in_o_prods['prod_id']=$collection[$j];





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







                if(!empty($create_b6_in_data['col_amount_in_b6']))

                {

                    for($i=1;$i<=$create_b6_in_data['col_amount_in_b6'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1600)&&(substr($collection[$j],1)<1660))

                            {

                                $add_b6_in_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)

                                {

                                    $add_b6_in_o_prods['osub_id']="n0".$i;

                                }

                                else

                                {

                                    $add_b6_in_o_prods['osub_id']="n".$i;

                                }

                                $add_b6_in_o_prods['prod_id']=$collection[$j];



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



                if(!empty($create_b7_in_data['col_amount_in_b7']))

                {

                    for($i=1;$i<=$create_b7_in_data['col_amount_in_b7'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1700)&&(substr($collection[$j],1)<1760))

                            {

                                $add_b7_in_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)

                                {

                                    $add_b7_in_o_prods['osub_id']="n0".$i;

                                }

                                else

                                {

                                    $add_b7_in_o_prods['osub_id']="n".$i;

                                }

                                $add_b7_in_o_prods['prod_id']=$collection[$j];



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



                if(!empty($create_b8_in_data['col_amount_in_b8']))

                {

                    for($i=1;$i<=$create_b8_in_data['col_amount_in_b8'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1800)&&(substr($collection[$j],1)<1860))

                            {

                                $add_b8_in_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)

                                {

                                    $add_b8_in_o_prods['osub_id']="n0".$i;

                                }

                                else

                                {

                                    $add_b8_in_o_prods['osub_id']="n".$i;

                                }

                                $add_b8_in_o_prods['prod_id']=$collection[$j];



                                if(substr($collection[$j],1)==1801)

                                {

                                    $add_b8_in_o_prods['p_status']=3;

                                    $prod->add_order_products2(json_encode($add_b8_in_o_prods));

                                    $add_b8_in_o_prods['prod_id']="p1700";

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

                if(!empty($create_b1_ex_data['col_amount_ex_b1']))
                {
                    for($i=1;$i<=$create_b1_ex_data['col_amount_ex_b1'];$i++)
                    {

                        for($j=0;$j<count($collection);$j++)
                        {

                            if((substr($collection[$j],1)>1160)&&(substr($collection[$j],1)<1300))
                            {

                                $add_b1_ex_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)
                                {
                                    $add_b1_ex_o_prods['osub_id']="x0".$i;
                                }
                                else
                                {
                                    $add_b1_ex_o_prods['osub_id']="x".$i;
                                }

                                $add_b1_ex_o_prods['prod_id']=$collection[$j];

                                $add_b1_ex_o_prods['p_status']=1;

                                $prod->add_order_products2(json_encode($add_b1_ex_o_prods));

                            }

                        }

                    }

                }

                if(!empty($create_b5_ex_data['col_amount_ex_b5']))
                {
                    for($i=1;$i<=$create_b5_ex_data['col_amount_ex_b5'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1560)&&(substr($collection[$j],1)<1600)||($collection[$j]=="p156x")||($collection[$j]=="p156z")||($collection[$j]=="p156y"))

                            {

                                $add_b5_ex_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)

                                {

                                    $add_b5_ex_o_prods['osub_id']="x0".$i;

                                }

                                else

                                {

                                    $add_b5_ex_o_prods['osub_id']="x".$i;

                                }

                                $add_b5_ex_o_prods['prod_id']=$collection[$j];



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



                if(!empty($create_b6_ex_data['col_amount_ex_b6']))

                {

                    for($i=1;$i<=$create_b6_ex_data['col_amount_ex_b6'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1660)&&(substr($collection[$j],1)<1700)||
                                ($collection[$j]=="p166x")||($collection[$j]=="p166z")||($collection[$j]=="p166y")
                            )

                            {

                                $add_b6_ex_o_prods['o_id']=$last_order['order_ID'];

                                if($i<10)

                                {

                                    $add_b6_ex_o_prods['osub_id']="x0".$i;

                                }

                                else

                                {

                                    $add_b6_ex_o_prods['osub_id']="x".$i;

                                }

                                $add_b6_ex_o_prods['prod_id']=$collection[$j];



                                if(substr($collection[$j],1)==1661)

                                {

                                    $add_b6_ex_o_prods['p_status']=3;

                                    $prod->add_order_products2(json_encode($add_b6_ex_o_prods));

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



                if(!empty($create_b7_ex_data['col_amount_ex_b7']))

                {

                    for($i=1;$i<$create_b7_ex_data['col_amount_ex_b7'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1760)&&(substr($collection[$j],1)<1800)||($collection[$j]=="p176x")||($collection[$j]=="p176z")||($collection[$j]=="p176y"))

                            {

                                $add_b7_ex_o_prods['o_id']=$last_order['order_ID'];

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





                if(!empty($create_b8_ex_data['col_amount_ex_b8']))

                {

                    for($i=1;$i<$create_b8_ex_data['col_amount_ex_b8'];$i++)

                    {

                        for($j=0;$j<count($collection);$j++)

                        {

                            if((substr($collection[$j],1)>1760)&&(substr($collection[$j],1)<1800)||($collection[$j]=="p186x")||($collection[$j]=="p186z")||($collection[$j]=="p186y"))

                            {

                                $add_b8_ex_o_prods['o_id']=$last_order['order_ID'];

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



                                if(substr($collection[$j],1)==1761)

                                {

                                    $add_b8_ex_o_prods['p_status']=3;

                                    $prod->add_order_products2(json_encode($add_b8_ex_o_prods));

                                    $add_b8_ex_o_prods['prod_id']="p1760";

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

                ?>

                <meta http-equiv="refresh" content="1; url=orderdetails.php?o_id=<?php echo $last_order['order_ID'];?>">

                <?php

            }





            $ls_id=$prod->xss_fix($_GET['ls_id']);

            $client_language=$prod->xss_fix($_GET['client_language']);

            $selected_currency=$prod->xss_fix($_GET['currency']);



            if(isset($_COOKIE['allclients']))

            {

                $allclients=$_COOKIE['allclients'];

            }

            else

            {

                $allclients=$prod->get_all_clients();

            }



            ?>



            <form id="create_order_form" name="create_order_form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>"></form>

            <input type="hidden" name="ls_id" value="<?php echo $ls_id; ?>" form="create_order_form">

            <input type="hidden" name="o_extension" value="<?php echo $o_extension; ?>" form="create_order_form">

            <input type="hidden" name="cur_id" value="<?php echo $selected_currency; ?>" form="create_order_form">

            <input type="hidden" name="client_language" value="<?php echo $client_language; ?>" form="create_order_form">



            <div class="row mx-0 w-100">

                <div class="col-md-8 offset-md-2 border p-4" style="background-color:#c5c5c5">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div id="copy_order_message">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <b class="mr-2">Make a copy of order ID = </b>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="order_id_copy" name="order_id_copy" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" class="form-check-input" id="for_marketing" name="for_marketing" value="4388">
                                    <label class="form-check-label" for="for_marketing">for Marketing ?</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="form-check-input" id="copy_result_files" name="copy_result_files" value="4388">
                                    <label class="form-check-label" for="copy_result_files">Copy also result files ?</label>
                                </div>
                                <div class="col-md-1">
                                    <button id="copy_btn" id="copy_btn" class="btn btn-sm btn-primary">Start copying</button> &nbsp;
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#copy_btn').click(function(){
                                            let for_marketing=$('#for_marketing').val();
                                            let o_id=$('#order_id_copy').val();

                                            if(o_id!="")
                                            {
                                                if(confirm('Are you sure you want to create a copy ?'))
                                                {
                                                    if($('#for_marketing').prop("checked") == false)
                                                    {
                                                        for_marketing=0;
                                                    }

                                                    //console.log(for_marketing);

                                                    $.ajax({
                                                        url: "../ajax/create_order_copy.php",
                                                        method: "post",
                                                        data: {o_id:o_id,for_marketing:for_marketing},
                                                        dataType:"html",
                                                        success:function(data) {
                                                            $('#copy_order_message').html(data);
                                                        }
                                                    });

                                                }
                                            }
                                            else
                                            {
                                                alert('Order ID can not be empty !');
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <div class="inline-flex my-2">

                                <?php

                                //$all_websites=$prod->get_all_websites();

                                ?>

                                <b class="mr-2">Website = </b>

                                <select id="lic_sites" onchange="if (this.value) window.location.href=this.value" class="form-control form-control-sm" style="width:250px">

                                    <option value="">-- Select website --</option>

                                    <?php



                                    /*if($_COOKIE['lt_id']==9)

                {

                    $all_websites=explode(";",$client['ls_ids']);



                    for($i=0;$i<count($all_websites);$i++)

                    {

                        if(!empty($all_websites[$i]))

                        {

                            $website=$prod->get_order_website($all_websites[$i]);

                    ?>

                    <option value="create_order.php?ls_id=<?php echo $all_websites[$i]; ?>" <?php echo ($ls_id==$all_websites[$i])?"selected":""; ?>><?php echo $website['ls_name']; ?></option>

                    <?php

                        }

                    }

                }

                else

                {*/

                                    //echo $_COOKIE['lt_id'];

                                    if($_COOKIE['view_all_orders']==1)

                                    {

                                        $licences=$prod->get_licences2($_COOKIE['lt_id']);

                                    }

                                    else

                                    {

                                        $licences=$prod->get_licences($_COOKIE['lt_id']);

                                    }



                                    //print_r($licences);

                                    for($w=0;$w<count($licences);$w++)

                                    {

                                        if(!empty($licences[$w]['homepages_for_sale']))

                                        {

                                            $all_websites=explode(";",$licences[$w]['homepages_for_sale']);

                                            // print_r($all_websites);

                                            for($k=0;$k<count($all_websites);$k++)

                                            {

                                                if(!empty($all_websites[$k]))

                                                {

                                                    $websites.=$all_websites[$k].";";

                                                }

                                            }

                                        }

                                    }

                                    echo $websites;

                                    $all_websites2=explode(";",$websites);



                                    $all_websites=array_values(array_unique($all_websites2));



                                    $website_counter=0;



                                    for($w=0;$w<count($all_websites);$w++)

                                    {

                                        if((!empty($all_websites[$w]))&&($all_websites[$w]!="s099"))

                                        {

                                            $website=$prod->get_order_website($all_websites[$w]);

                                            $alphabetical_websites[$website_counter]['ls_id']=$website['ls_id'];

                                            $alphabetical_websites[$website_counter]['ls_name']=$website['ls_name'];

                                            $website_counter++;

                                        }

                                    }



                                    /* function compareByName($alphabetical_websites, $b) {

                        return strcmp($alphabetical_websites["ls_name"], $b["ls_name"]);

                      }*/

                                    usort($alphabetical_websites, 'compareSiteByName');





                                    //print_r($alphabetical_websites);



                                    for($w=0;$w<count($alphabetical_websites);$w++)

                                    {



                                        //language 0



                                        $licence_languages=$prod->get_licences_by_lic_sites_id($alphabetical_websites[$w]['ls_id']);



                                        $all_extracted_languages="";

                                        for($l=0;$l<count($licence_languages);$l++)

                                        {

                                            $all_extracted_languages.=$licence_languages[$l]['languages_on_page'];



                                        }



                                        $extracted_languages=explode(';',$all_extracted_languages);



                                        $all_languages=array_values(array_unique($extracted_languages));



                                        $language_counter=0;

                                        //$alphabetical_languages=array();

                                        for($l=0;$l<count($all_languages);$l++)

                                        {

                                            if(!empty($all_languages[$l]))

                                            {

                                                $language=$prod->get_language($all_languages[$l]);

                                                $alphabetical_languages[$language_counter]['ln_id']=$language['ln_id'];

                                                $alphabetical_languages[$language_counter]['ln_name']=$language['ln_name'];

                                                $language_counter++;

                                            }

                                        }



                                        usort($alphabetical_languages,'compareLanguageByName');





                                        //currency 0



                                        $licence_currencies=$prod->get_currencies_from_licences($alphabetical_websites[$w]['ls_id'],$alphabetical_languages[0]['ln_id']);



                                        $all_extracted_currencies="";



                                        for($c=0;$c<count($licence_currencies);$c++)

                                        {

                                            $all_extracted_currencies.=$licence_currencies[$c]['currencies'];

                                        }



                                        $extracted_currencies=explode(';',$all_extracted_currencies);



                                        $all_currencies=array_values(array_unique($extracted_currencies));



                                        $currency_counter=0;

                                        //$alphabetical_currencies=array();

                                        for($c=0;$c<count($all_currencies);$c++)

                                        {

                                            if(!empty($all_currencies[$c]))

                                            {

                                                $currency2=$prod->get_currency($all_currencies[$c]);

                                                $alphabetical_currencies[$currency_counter]['cur_id']=$currency2['cur_id'];

                                                $alphabetical_currencies[$currency_counter]['cur_short']=$currency2['cur_short'];

                                                $currency_counter++;

                                            }

                                        }



                                        usort($alphabetical_currencies,'compareCurrencyByName');







                                        ?>

                                        <option value="create_order.php?ls_id=<?php echo $alphabetical_websites[$w]['ls_id']; ?>&client_language=<?php echo $alphabetical_languages[0]['ln_id']; ?>&currency=<?php echo $alphabetical_currencies[0]['cur_id']; ?>" <?php

                                        if(empty($ls_id)&&($w==0)) //this condition might not be necessary

                                        {

                                            echo "selected";

                                        }

                                        elseif($ls_id==$alphabetical_websites[$w]['ls_id'])

                                        {

                                            echo "selected";

                                        } ?>><?php echo $alphabetical_websites[$w]['ls_name']; ?></option>

                                        <?php

                                        //}

                                    }

                                    //}

                                    ?>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="row w-100 mx-0">

                        <div class="col-md-6">

                            <div class="my-2 d-inline">

                                <?php

                                //$all_languages=$prod->get_all_languages();

                                // echo $_COOKIE['preselected_languages'];

                                // print_r($all_languages);



                                $licence_languages=$prod->get_licences_by_lic_sites_id($ls_id);

                                //print_r($licence_languages);

                                $all_extracted_languages="";

                                for($l=0;$l<count($licence_languages);$l++)

                                {

                                    $all_extracted_languages.=$licence_languages[$l]['languages_on_page'];



                                }



                                $extracted_languages=explode(';',$all_extracted_languages);



                                $all_languages=array_values(array_unique($extracted_languages));



                                $language_counter=0;

                                $alphabetical_languages=array();

                                for($l=0;$l<count($all_languages);$l++)

                                {

                                    if(!empty($all_languages[$l]))

                                    {

                                        $language=$prod->get_language($all_languages[$l]);

                                        $alphabetical_languages[$language_counter]['ln_id']=$language['ln_id'];

                                        $alphabetical_languages[$language_counter]['ln_name']=$language['ln_name'];

                                        $language_counter++;

                                    }

                                }



                                usort($alphabetical_languages,'compareLanguageByName');

                                ?>

                                <b class="mr-2 d-inline">Client's language = </b>

                                <select id="client_language" onchange="if (this.value) window.location.href=this.value" class="form-control form-control-sm w-50 d-inline">

                                    <option value="">-- Select language --</option>

                                    <?php



                                    for($i=0;$i<count($alphabetical_languages);$i++)

                                    {

                                        /*if($_COOKIE['lt_id']==9)

                    {

                        if(in_array($all_languages[$i]['ln_id'],$_COOKIE['preselected_languages']))

                        {

                    ?>

                    <option value="create_order.php?ls_id=<?php echo $ls_id;?>&client_language=<?php echo $all_languages[$i]['ln_id']; ?>" <?php echo ($client_language==$all_languages[$i]['ln_id'])?"selected":""; ?>><?php echo $all_languages[$i]['ln_name']; ?></option>

                    <?php

                    //Licence ID: 04902 - PLITT real&virtual ESTATE Ltd. -Niederlassung Deutschland- - Plitt Petra - +49/ 9131-918876-0

                        }

                    }

                    else

                    {*/

                                        if(!empty($alphabetical_languages[$i]['ln_id']))

                                        {

                                            //$language=$prod->get_language($alphabetical_languages[$i]);

                                            ?>

                                            <option value="create_order.php?ls_id=<?php echo $ls_id;?>&client_language=<?php echo $alphabetical_languages[$i]['ln_id']; ?>" <?php echo ($client_language==$alphabetical_languages[$i]['ln_id'])?"selected":""; ?>><?php echo $alphabetical_languages[$i]['ln_name']; ?></option>

                                            <?php

                                        }

                                    }

                                    ?>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="my-2 d-inline">

                                <?php

                                //$all_currencies=$prod->get_all_currencies();



                                $licence_currencies=$prod->get_currencies_from_licences($ls_id,$client_language);



                                $all_extracted_currencies="";



                                for($c=0;$c<count($licence_currencies);$c++)

                                {

                                    $all_extracted_currencies.=$licence_currencies[$c]['currencies'];

                                }



                                $extracted_currencies=explode(';',$all_extracted_currencies);



                                $all_currencies=array_values(array_unique($extracted_currencies));



                                $currency_counter=0;

                                $alphabetical_currencies=array();

                                for($c=0;$c<count($all_currencies);$c++)

                                {

                                    if(!empty($all_currencies[$c]))

                                    {

                                        $currency2=$prod->get_currency($all_currencies[$c]);

                                        $alphabetical_currencies[$currency_counter]['cur_id']=$currency2['cur_id'];

                                        $alphabetical_currencies[$currency_counter]['cur_short']=$currency2['cur_short'];

                                        $currency_counter++;

                                    }

                                }



                                usort($alphabetical_currencies,'compareCurrencyByName');



                                ?>

                                <b class="mr-2 d-inline">Currency = </b>

                                <select id="currency" onchange="if (this.value) window.location.href=this.value" class="form-control form-control-sm w-50 d-inline">

                                    <option value="">-- Select currency --</option>

                                    <?php

                                    for($i=0;$i<count($alphabetical_currencies);$i++)

                                    {

                                        /*if($_COOKIE['lt_id']==9)

                    {

                        if(in_array($all_currencies[$i]['cur_id'],$_COOKIE['preselected_currencies']))

                        {

                        ?>

                        <option value="create_order.php?ls_id=<?php echo $ls_id;?>&client_language=<?php echo $client_language; ?>&currency=<?php echo $all_currencies[$i]['cur_id']; ?>" <?php echo ($selected_currency==$all_currencies[$i]['cur_id'])?"selected":""; ?>><?php echo $all_currencies[$i]['cur_short']; ?></option>

                        <?php

                        }

                    }

                    else

                    {*/





                                        //print_r($currency2);

                                        ?>

                                        <option value="create_order.php?ls_id=<?php echo $ls_id;?>&client_language=<?php echo $client_language; ?>&currency=<?php echo $alphabetical_currencies[$i]['cur_id']; ?>" <?php echo ($selected_currency==$alphabetical_currencies[$i]['cur_id'])?"selected":""; ?>><?php echo $alphabetical_currencies[$i]['cur_short']; ?></option>

                                        <?php





                                    }

                                    ?>

                                </select>

                            </div>

                        </div>

                    </div>



                    <div class="row w-100 mx-0">

                        <div class="col-md-12">

                            <div class="my-2">

                                <b class="mr-2 d-inline">Trader licence = </b>

                                <p class="w-100 text-center mb-0 py-2">

                                    <?php

                                    if((!empty($ls_id))&&(!empty($client_language))&&(!empty($selected_currency)))

                                    {

                                        $lt_id=$prod->get_licence2($ls_id.";",$client_language.";",$selected_currency.";");

                                        $licence_taker=$prod->get_company($lt_id['licence-taker']);

                                        $licenceid=$lt_id['lic_id'];

                                        echo $licenceid." ".$licence_taker['Company']." - ".$licence_taker['leader-names']." - ".$licence_taker['phone'];

                                    }

                                    ?>

                                </p>

                            </div>

                        </div>

                    </div>



                    <div class="row w-100 mx-0">

                        <div class="col-md-12">

                            <div class="inline-flex my-2" style="flex-direction: column; width: 100%;">
                                    <div class="d-flex">
                                <b class="mr-2" style="width:20%">Purchaser = </b> <?php

                                //print_r($_COOKIE['allclients']);

                                ?>
                                <input type="text" id="purchaser2" list="purchaser_list" name="purchaser2" class="form-control form-control-sm" form="create_order_form" style="width: 80%;" required>
                                    </div>
                                        <datalist id="purchaser_list">
                                    <?php

                                    for($i=0;$i<count($allclients);$i++)
                                    {
                                        if($allclients[$i]['c_status']=="active")
                                        {


                                            if(strpos($allclients[$i]['ls_ids'],$ls_id) !== false)
                                            {
                                                ?>

                                                <option value="<?php echo $allclients[$i]['client_ID']." - "; 
                                                
                                                if(!empty($allclients[$i]['c_last_name']))
                                                {

                                                    echo $allclients[$i]['clientname']." - ".$allclients[$i]['c_last_name'].", ".$allclients[$i]['c_first_name'];

                                                }
                                                else
                                                {
                                                    echo $allclients[$i]['clientname']." - ".$allclients[$i]['l_last_name'].", ".$allclients[$i]['l_first_name'];

                                                }
                                                ?>" <?php

                                                if(($_COOKIE['lt_id']==9)&&($allclients[$i]['client_ID']==327))
                                                {

                                                    echo "selected";

                                                } ?>><?php

                                                    if(!empty($allclients[$i]['c_last_name']))
                                                    {

                                                        echo $allclients[$i]['clientname']." - ".$allclients[$i]['c_last_name'].", ".$allclients[$i]['c_first_name'];

                                                    }
                                                    else
                                                    {
                                                        echo $allclients[$i]['clientname']." - ".$allclients[$i]['l_last_name'].", ".$allclients[$i]['l_first_name'];

                                                    }

                                                    ?></option>

                                                <?php

                                            }

                                        }

                                    }

                                    ?>
                                </datalist>
                                <input type="hidden" id="purchaser" name="purchaser" value="" form="create_order_form">
                                <div id="purchaser_name"></div>



                                <script type="text/javascript">
                                            //  var input = document.getElementById("purchaser");
                                            //  var purchaserNameDiv = document.getElementById("purchaser_name");


                                            //  input.addEventListener("input", function(event) {
                                            //      var selectedOption = event.target.list.querySelector('option[value="' + event.target.value + '"]');
                                            //      var selectedText = selectedOption ? selectedOption.textContent : "";
                                            //      purchaserNameDiv.textContent = selectedText;
                                            //  });




                                    $(document).ready(function(){
                                        // $('#purchaser').on('change',function(){
                                        // 	console.log('entered');

                                        let optionsList = document.querySelectorAll('#clientOption');

                                        optionsList.forEach(function(option) {
                                            option.addEventListener('click', function() {
                                                console.log("susss")
                                            })
                                            // console.log(option);
                                        });




                                        // });




                                        $('#purchaser2').on("change focusout",function(){
                                            let purchaser_text=$(this).val();
                                            let purchaser_array_text=purchaser_text.split("-");
                                            $('#purchaser').val(purchaser_array_text[0].trim());

                                            //console.log($('#purchaser_list')[0]);
                                            //$('#purchaser_name').html();

                                            $.ajax({

                                                url: "../ajax/get_simple_client_price_remarks.php",

                                                method: "get",

                                                data: {purchaser:$('#purchaser').val()},

                                                dataType:"html",

                                                success:function(data) {

                                                    $('#client_price_remarks').val(data);

                                                }

                                            });



                                            $.ajax({

                                                url: "../ajax/get_main_client_price_remarks.php",

                                                method: "get",

                                                data: {purchaser:$('#purchaser').val()},

                                                dataType:"html",

                                                success:function(data) {

                                                    $('#price_remarks').val(data);

                                                }

                                            });



                                        });

                                    });

                                </script>

                            </div>

                        </div>

                    </div>

                    <div class="row w-100 mx-0">

                        <div class="col-md-6">

                            <div class="d-flex my-2">

                                <b class="mr-2 w-75">Project name: </b>

                                <input type="text" class="form-control form-control-sm" form="create_order_form" name="order_name" value="<?php echo (isset($_GET['o_extension']))?"Order extension for: ".$order['order_name']:"";?>" required>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="d-flex my-2">

                                <b class="mr-2 w-75">On stock ?</b>

                                <select name="on_stock" form="create_order_form" class="form-control form-control-sm">

                                    <option value="0">No</option>

                                    <option value="1">Yes</option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="row w-100 mx-0">

                        <div class="col-md-6">

                            <div class="d-flex my-2">

                                <b class="mr-2 w-75">Deadline UTC+0: </b>

                                <input type="text" class="form-control form-control-sm" form="create_order_form" id="o_deadline" name="o_deadline" value="" autocomplete="off">

                                <script type="text/javascript">

                                    $(document).ready(function(){

                                        $('#o_deadline').datetimepicker({

                                            format:'Y-m-d H:i'

                                        });

                                    });

                                </script>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <br>

            <?php



            $lic_sites=$prod->get_lic_site($ls_id);



            $licence=$prod->get_licence($licenceid);



            $currency=$prod->get_currency($selected_currency)['cur_short'];



            $cur_factor=$lic_sites['cur_fac_'.strtolower($currency)];





            if(!empty($licenceid))

            {

            //getting products from the licence site







            $ls_prods=explode(';',$lic_sites['ls_prods']);



            $columns=3;

            $lines=ceil(count($ls_prods) / $columns)-1;



            //print_r($ls_prods);

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

                if((substr($ls_prods[$i],1)>1160)&&(substr($ls_prods[$i],1)<1300)||($ls_prods[$i]=="p116b")||($ls_prods[$i]=="p116m")||($ls_prods[$i]=="p116t"))

                {

                    if(!empty($ls_prods[$i]))

                    {

                        $b1_ex_products[]=$ls_prods[$i];

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



                if((substr($ls_prods[$i],1)>1560)&&(substr($ls_prods[$i],1)<1600)||($ls_prods[$i]=="p156x")||($ls_prods[$i]=="p156z")||($ls_prods[$i]=="p156y"))

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



                if((substr($ls_prods[$i],1)>1660)&&(substr($ls_prods[$i],1)<1700)||($ls_prods[$i]=="p166x")||($ls_prods[$i]=="p166z")||($ls_prods[$i]=="p166y"))

                {

                    if(!empty($ls_prods[$i]))

                    {

                        $b6_ex_products[]=$ls_prods[$i];

                    }

                }



                if((substr($ls_prods[$i],1)>=1700)&&(substr($ls_prods[$i],1)<1760)||($ls_prods[$i]=="p170x")||($ls_prods[$i]=="p170z")||($ls_prods[$i]=="p170y")||($ls_prods[$i]=="p172x")||($ls_prods[$i]=="p172z")||
                    ($ls_prods[$i]=="p172y")||($ls_prods[$i]=="p174x")||($ls_prods[$i]=="p174z")||($ls_prods[$i]=="p174y"))

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

            //print_r($b7_ex_products);

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

            //print_r($ls_prods);  echo "<br>";

            //print_r($b6_in_products);

            ?>

            <input type="hidden" name="licenceid" value="<?php echo $licenceid; ?>" form="create_order_form">

            <?php
            /*
            <div class="row">

                <div class="col-md-12">

                    Customer ordered collections with these products !

                </div>

            </div> */ ?>

            <br>



            <?php
            /*
            if($interior>0)

            {

                ?>

                <div class="interior" style="box-shadow: none;">

                    <div class="row w-100 mx-0 pt-4">

                        <div class="col-md-2">

                            <h5 class="text-success w-100 text-center">Interior</h5>

                        </div>

                        <div class="col-md-5 d-flex justify-content-center">

                            <div class="form-inline"><b class="mr-2">Amount of interior subIDs : </b><input type="text" class="form-control form-control-sm" name="col_amount0" id="col_amount0" form="create_order_form" value="<?php

                                if(!isset($_COOKIE['col_amount0']))

                                {

                                    echo "1";

                                }

                                else

                                {

                                    echo $_COOKIE['col_amount0'];

                                }

                                ?>" style="width:5em"></div>

                        </div>

                        <div class="col-md-5 d-flex justify-content-center">

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

                                <select id ="st_id0" name="st_id0" class="form-control form-control-sm" form="create_order_form">

                                    <option value="">None</option>

                                    <?php

                                    for($i=0;$i<count($stairs);$i++)

                                    {

                                        ?>

                                        <option value="<?php echo $stairs[$i]['st_id']?>"><?php echo $stairs[$i]['st_name'];?></option>

                                        <?php

                                    }

                                    ?>

                                </select><!-- <img src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/256/sign-question-icon.png" width="40"> -->

                            </div>

                        </div>



                    </div> <!-- end row -->

                    <hr width="300px" class="bg-secondary">



                    <div class="row w-100 mx-0">
                        <!-- interior buttons here -->
                        <div class="col-md-2">
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

                                    <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="inbtnb7" data-target="#interiorb7" data-toggle="collapse"><del>B7 interior - Top quality</del></button>

                                    <span class="text-danger">Not for this website</span>

                                    <?php

                                }

                                else

                                {

                                    ?>

                                    <button class="btn btn-sm btn-success text-white px-3 ml-1" id="inbtnb7" data-target="#interiorb7" data-toggle="collapse">B7 interior - Top quality</button>

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

                    </div> <!-- end row -->

                    <hr>


                    <?php

                    if(count($b1_in_products)>0)

                    {

                        ?>

                        <div class="col-md-12 px-0 collapse" id="interiorb1">

                            <div class="row mx-0">

                                <div class="col-md-12 d-flex text-left">

                                    <b>Amount of floorplans</b> <input id="b1_main_fac" type="text" class="form-control form-control-sm" style="width:3em;" value="1">

                                </div>

                            </div>

                            <div class="row w-100 mx-0 pl-4">



                                <?php

                                $b1_in_lines=ceil(count($b1_in_products) / $columns);

                                $counter=1;

                                for($i=0;$i<count($b1_in_products);$i++)

                                {

                                if(!empty($b1_in_products[$i]))

                                {

                                $product=$prod->get_product($b1_in_products[$i]);

                                if(count($budget)>0)

                                {

                                    $product_price=$prod->calculateProductAPU($b1_in_products[$i]);

                                }

                                else

                                {

                                    $product_price=$price->calculateProductPrice($b1_in_products[$i],$cur_factor);

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

                                        <div class="">

                                            <input class="products product_in_b1 checkbox mr-2" type="checkbox" name="<?php echo $b1_in_products[$i]; ?>" id="<?php echo $b1_in_products[$i]; ?>" value="<?php echo $b1_in_products[$i]; ?>">

                                            <label for="<?php echo $b1_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <?php echo $product_price." ".$currency; ?></label>







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



                                            <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_original_price" value="<?php echo $product_price; ?>">

                                            <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b1_in_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                            <?php

                                            if(($b1_in_products[$i]=="p1301")||($b1_in_products[$i]=="p1302")||($b1_in_products[$i]=="p1321")||($b1_in_products[$i]=="p1322"))

                                            {

                                                ?>

                                                <!--<span class="text-danger font-weight-bold">X</span> --><input type="hidden" class="form-control form-control-sm d-inline px-2 b1_in_multiplicator" form="create_order_form" id="<?php echo $b1_in_products[$i]; ?>_fac" name="<?php echo $b1_in_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                                <?php

                                            }

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
                            
                            <?php

                            if(count($b1_in_products)>0)

                            {

                                ?>
                                <div class="row form-inline w-100 mx-0 ">

                                    <div class="col-md-12">

                                        <b>Employee-Producer: Col IN B1 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_labc_in_b1" id="col_labc_in_b1" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_in_b1 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_labc_in_b1" id="fac_labc_in_b1" value="1" form="create_order_form" style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b1" id="col_amount3_in_b1" form="create_order_form" value="1" style="width:5em" >

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b1" id="total_labcs_in_b1" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0">

                                    <div class="col-md-12">

                                        <b>Producer-Trader: Col IN B1 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_apus_in_b1" id="col_apus_in_b1" value="" form="create_order_form" style="width:5em"> <b>APEs X fac_prod_in_b1 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_prod_in_b1" id="fac_prod_in_b1" value="1" form="create_order_form" style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b1" id="col_amount2_in_b1" form="create_order_form" value="1" style="width:5em" >

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b1" id="o_apus_in_b1" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                    </div>

                                </div>


                                <div class="row form-inline w-100 mx-0 border-bottom border-dark">

                                    <div class="col-md-12">

                                        <b>Trader-Purchaser: Col IN B1 = </b>

                                        <input class="form-control form-control-sm" type="text" name="col_price_in_b1" id="col_price_in_b1" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?> X fac_client_in_b1 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_cl_in_b1" id="fac_cl_in_b1" value="1" form="create_order_form" style="width:5em">

                                        <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b1" id="col_amount1_in_b1" form="create_order_form" value="1" style="width:5em" >

                                        <b>=</b>

                                        <input type="text" class="form-control form-control-sm" name="o_price_in_b1" id="o_price_in_b1" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?></b>

                                        <br><br>

                                    </div>

                                </div>

                                <?php

                            }

                            ?>



                        </div>

                        <?php

                    } //end b1_in_products

                    ?>


                    <?php

                    if(count($b3_in_products)>0)

                    {

                        ?>

                        <div class="col-md-12 px-0 collapse" id="interiorb3">

                            <div class="row mx-0">

                                <div class="col-md-12 d-flex text-left">

                                    <b>Amount of floorplans</b> <input id="b3_main_fac" type="text" class="form-control form-control-sm" style="width:3em;" value="1">

                                </div>

                            </div>

                            <div class="row w-100 mx-0 pl-4">



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

                                    <div class="row w-100 mx-0 my-1">

                                        <div class="">

                                            <input class="products product_in_b3 checkbox mr-2" type="checkbox" name="<?php echo $b3_in_products[$i]; ?>" id="<?php echo $b3_in_products[$i]; ?>" value="<?php echo $b3_in_products[$i]; ?>">

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



                                            <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_original_price" value="<?php echo $product_price; ?>">

                                            <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b3_in_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                            <?php

                                            if(($b3_in_products[$i]=="p1301")||($b3_in_products[$i]=="p1302")||($b3_in_products[$i]=="p1321")||($b3_in_products[$i]=="p1322"))

                                            {

                                                ?>

                                                <!--<span class="text-danger font-weight-bold">X</span> --><input type="hidden" class="form-control form-control-sm d-inline px-2 b3_in_multiplicator" form="create_order_form" id="<?php echo $b3_in_products[$i]; ?>_fac" name="<?php echo $b3_in_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

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

                            <div class="row w-100 mx-0 mb-4">

                                <div class="col-md-6">

                                    <p class="d-inline mr-2"><b>Shapeline</b></p>

                                    <select name="sl_id" id="sl_id" class="form-control form-control-sm d-inline" form="create_order_form" style="width:200px;">

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

                                    <p class="d-inline mr-2"><b>Colorset</b></p>

                                    <select name="cls_id" id="cls_id" class="form-control form-control-sm d-inline" form="create_order_form" style="width:200px;">

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



                            <?php

                            if(count($b3_in_products)>0)

                            {

                                ?>

                                <div class="row form-inline w-100 mx-0 ">

                                    <div class="col-md-12">

                                        <b>Employee-Producer: Col IN B3 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_labc_in_b3" id="col_labc_in_b3" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_in_b3 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_labc_in_b3" id="fac_labc_in_b3" value="1" form="create_order_form" style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b3" id="col_amount3_in_b3" form="create_order_form" value="1" style="width:5em" >

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b3" id="total_labcs_in_b3" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0">

                                    <div class="col-md-12">

                                        <b>Producer-Trader: Col IN B3 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_apus_in_b3" id="col_apus_in_b3" value="" form="create_order_form" style="width:5em"> <b>APEs X fac_prod_in_b3 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_prod_in_b3" id="fac_prod_in_b3" value="1" form="create_order_form" style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b3" id="col_amount2_in_b3" form="create_order_form" value="1" style="width:5em" >

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b3" id="o_apus_in_b3" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0 border-bottom border-dark">

                                    <div class="col-md-12">

                                        <b>Trader-Purchaser: Col IN B3 = </b>

                                        <input class="form-control form-control-sm" type="text" name="col_price_in_b3" id="col_price_in_b3" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?> X fac_client_in_b3 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_cl_in_b3" id="fac_cl_in_b3" value="1" form="create_order_form" style="width:5em">

                                        <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b3" id="col_amount1_in_b3" form="create_order_form" value="1" style="width:5em" >

                                        <b>=</b>

                                        <input type="text" class="form-control form-control-sm" name="o_price_in_b3" id="o_price_in_b3" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?></b>

                                        <br><br>

                                    </div>

                                </div>

                                <?php

                            }

                            ?>

                            <!-- <br>

                        -->

                        </div>

                        <?php

                    } //end b3_in_products

                    ?>



                    <?php

                    if(count($b5_in_products)>0)

                    {



                        ?>

                        <div class="col-md-12 collapse" id="interiorb5" style="background-color:#c9c995;">

                            <div class="row w-100 mx-0 pl-4">

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

                                            <input class="products product_in_b5 checkbox mr-2" type="checkbox" name="<?php echo $b5_in_products[$i]; ?>" id="<?php echo $b5_in_products[$i]; ?>" value="<?php echo $b5_in_products[$i]; ?>" <?php



                                            for($j=0;$j<count($collection);$j++)

                                            {



                                                if($b5_in_products[$i]==$collection[$j])

                                                {

                                                    echo "checked";



                                                }



                                            }

                                            ?>>

                                            <label for="<?php echo $b5_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b5_in_products[$i];?>_original_price"><?php echo $product_price;?></span> <?php echo $currency; ?></label>

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



                                            <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b5_in_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                            <?php

                                            // if(($b5_in_products[$i]=="p1501")||($b5_in_products[$i]=="p1504")||($b5_in_products[$i]=="p1506")||($b5_in_products[$i]=="p1521")||($b5_in_products[$i]=="p1524")||($b5_in_products[$i]=="p1526")||($b5_in_products[$i]=="p1541")||($b5_in_products[$i]=="p1544")||($b5_in_products[$i]=="p1546"))

                                            // {

                                            ?>

                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_in_multiplicator" form="create_order_form" id="<?php echo $b5_in_products[$i]; ?>_fac" name="<?php echo $b5_in_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                            <?php

                                            //}

                                            ?>

                                        </div>

                                    </div>

                                    <?php

                                    if(($counter%$b5_in_lines==0)&&($counter>0))

                                    {

                                    ?>

                                </div> <!-- end cold-md-4 -->

                                <div class="col-md-4">

                                    <?php

                                    }

                                    $counter++;

                                    }

                                    }

                                    ?>

                                </div> <!-- end cold-md-4 -->

                            </div> <!-- end row -->





                            <div class="row w-100 mx-0 pt-3 border-bottom border-dark">

                                <div class="col-md-12 d-flex justify-content-center">

                                    <div id="b5_nav" class="nav nav-inline">



                                        <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>

                                        <?php //$layout=$prod->get_layout($layout_id,"b5",$window_id);



                                        $layoutline=$domenia->get_layouts_by_quality_id2("b5");;



                                        for($i=0;$i<count($layoutline);$i++)

                                        {

                                            ?>

                                            <a href="#b5_layouts" class="nav-item" title="<?php echo $layoutline[$i]['l_id'];?>">

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

                                    <input type="hidden" name="b5_selected_layoutline" value="" form="create_order_form">

                                </div>

                                <?php

                                if(count($b5_in_products)>0)

                                {

                                    ?>

                                    <br>

                                    <div class="row form-inline w-100 mx-0">

                                        <div class="col-md-12">

                                            <b>Employee-Producer: Col IN B5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_labc_in_b5" id="col_labc_in_b5" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_in_b5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_labc_in_b5" id="fac_labc_in_b5" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b5" id="col_amount3_in_b5"  value="1" style="width:5em" >

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b5" id="total_labcs_in_b5" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0">

                                        <div class="col-md-12">

                                            <b>Producer-Trader: Col IN B5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_apus_in_b5" id="col_apus_in_b5" value="" form="create_order_form" style="width:5em"> <b>APEs X fac_prod_in_b5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_prod_in_b5" id="fac_prod_in_b5" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b5" id="col_amount2_in_b5" form="create_order_form" value="1" style="width:5em" >

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b5" id="o_apus_in_b5" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0 pt-3">

                                        <div class="col-md-12">

                                            <b>Trader-Purchaser: Col IN B5 = </b>

                                            <input class="form-control form-control-sm" type="text" name="col_price_in_b5" id="col_price_in_b5" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?> X fac_client_in_b5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_cl_in_b5" id="fac_cl_in_b5" value="1" form="create_order_form" style="width:5em">

                                            <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b5" id="col_amount1_in_b5" form="create_order_form" value="1" style="width:5em" >

                                            <b>=</b>

                                            <input type="text" class="form-control form-control-sm" name="o_price_in_b5" id="o_price_in_b5" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?></b>

                                            <br><br>

                                        </div>

                                    </div>

                                    <?php

                                }?>

                            </div> <!-- end row -->

                        </div>

                        <?php

                    } //end b5_in_products



                    //start b6_in_products



                    if(count($b6_in_products)>0)

                    {



                        ?>

                        <div class="col-md-12 collapse" id="interiorb6" style="background-color:#c9c995;">

                            <div class="row w-100 mx-0 pl-4">

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

                                            <input class="products product_in_b6 checkbox mr-2" type="checkbox" name="<?php echo $b6_in_products[$i]; ?>" id="<?php echo $b6_in_products[$i]; ?>" value="<?php echo $b6_in_products[$i]; ?>" <?php



                                            for($j=0;$j<count($collection);$j++)

                                            {



                                                if($b6_in_products[$i]==$collection[$j])

                                                {

                                                    echo "checked";

                                                }



                                            }

                                            ?>>

                                            <label for="<?php echo $b6_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b6_in_products[$i];?>_original_price"><?php echo $product_price;?></span> <?php echo $currency; ?></label>

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



                                            <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b6_in_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                            <?php

                                            // if(($b6_in_products[$i]=="p1600")||($b6_in_products[$i]=="p1601")||($b6_in_products[$i]=="p1604")||($b6_in_products[$i]=="p1606")||($b6_in_products[$i]=="p1621")||($b6_in_products[$i]=="p1624")||($b6_in_products[$i]=="p1626")||($b6_in_products[$i]=="p1641")||($b6_in_products[$i]=="p1644")||($b6_in_products[$i]=="p1646"))

                                            // {

                                            ?>

                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b6_in_multiplicator" form="create_order_form" id="<?php echo $b6_in_products[$i]; ?>_fac" name="<?php echo $b6_in_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                            <?php

                                            //}

                                            ?>

                                        </div>

                                    </div>

                                    <?php

                                    if(($counter%$b6_in_lines==0)&&($counter>0))

                                    {

                                    ?>

                                </div> <!-- end cold-md-4 -->

                                <div class="col-md-4">

                                    <?php

                                    }

                                    $counter++;

                                    }

                                    }

                                    ?>

                                </div> <!-- end cold-md-4 -->

                            </div> <!-- end row -->





                            <div class="row w-100 mx-0 pt-3 border-bottom border-dark">

                                <div class="col-md-12 d-flex justify-content-center">

                                    <div id="b6_nav" class="nav nav-inline">



                                        <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>

                                        <?php //$layout=$prod->get_layout($layout_id,"b5",$window_id);



                                        $layoutline=$domenia->get_layouts_by_quality_id2("b6");



                                        for($i=0;$i<count($layoutline);$i++)

                                        {

                                            ?>

                                            <a href="#b6_layouts" class="nav-item" title="<?php echo $layoutline[$i]['l_id'];?>">

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

                                    <input type="hidden" name="b6_selected_layoutline" value="" form="create_order_form">

                                </div>

                                <?php

                                if(count($b6_in_products)>0)

                                {

                                    ?>

                                    <br>

                                    <div class="row form-inline w-100 mx-0 pt-3">

                                        <div class="col-md-12">

                                            <b>Employee-Producer: Col IN B6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_labc_in_b6" id="col_labc_in_b6" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_in_b6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_labc_in_b6" id="fac_labc_in_b6" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b6" id="col_amount3_in_b6"  value="1" style="width:5em" >

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b6" id="total_labcs_in_b6" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0">

                                        <div class="col-md-12">

                                            <b>Producer-Trader: Col IN B6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_apus_in_b6" id="col_apus_in_b6" value="" form="create_order_form" style="width:5em"> <b>APEs X fac_prod_in_b6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_prod_in_b6" id="fac_prod_in_b6" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b6" id="col_amount2_in_b6" form="create_order_form" value="1" style="width:5em" >

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b6" id="o_apus_in_b6" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0 ">

                                        <div class="col-md-12">

                                            <b>Trader-Purchaser: Col IN B6 = </b>

                                            <input class="form-control form-control-sm" type="text" name="col_price_in_b6" id="col_price_in_b6" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?> X fac_client_in_b6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_cl_in_b6" id="fac_cl_in_b6" value="1" form="create_order_form" style="width:5em">

                                            <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b6" id="col_amount1_in_b6" form="create_order_form" value="1" style="width:5em" >

                                            <b>=</b>

                                            <input type="text" class="form-control form-control-sm" name="o_price_in_b6" id="o_price_in_b6" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?></b>

                                            <br><br>

                                        </div>

                                    </div>

                                    <?php
                                }
                                ?>

                            </div> <!-- end row -->

                        </div>

                        <?php

                    } //end b6_in_products





                    //start b7_in_products

                    if(count($b7_in_products)>0)

                    {



                        ?>

                        <div class="col-md-12 collapse" id="interiorb7" style="background-color:#a3a373;">

                            <div class="row w-100 mx-0 pl-4">

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

                                    <div class="row w-100 mx-0 my-1">

                                        <div class="">

                                            <input class="products product_in_b7 checkbox mr-2" type="checkbox" name="<?php echo $b7_in_products[$i]; ?>" id="<?php echo $b7_in_products[$i]; ?>" value="<?php echo $b7_in_products[$i]; ?>">

                                            <label for="<?php echo $b7_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b7_in_products[$i];?>_original_price"><?php echo $product_price;?></span> <?php echo $currency; ?></label>

                                            <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_price" name="product_<?php echo $b7_in_products[$i];?>_price" class="" value="<?php echo $product_price; ?>">

                                            <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_apu" name="product_<?php echo $b7_in_products[$i];?>_apu" class="" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_labc" name="product_<?php echo $b7_in_products[$i];?>_labc" class="" value="<?php echo $product_labc; ?>">



                                            <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b7_in_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                            <?php

                                            // if(($b7_in_products[$i]=="p1700")||($b7_in_products[$i]=="p1701")||($b7_in_products[$i]=="p1704")||($b7_in_products[$i]=="p1706")||($b7_in_products[$i]=="p1721")||($b7_in_products[$i]=="p1724")||($b7_in_products[$i]=="p1726")||($b7_in_products[$i]=="p1741")||($b7_in_products[$i]=="p1744")||($b7_in_products[$i]=="p1746"))

                                            // {

                                            ?>

                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b7_in_multiplicator" form="create_order_form" id="<?php echo $b7_in_products[$i]; ?>_fac" name="<?php echo $b7_in_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                            <?php

                                            //}

                                            ?>

                                        </div>	<!-- end active_layout -->

                                    </div>	<!-- end row -->

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



                            <div class="row w-100 mx-0 pt-3">

                                <div class="col-md-12 d-flex justify-content-center">

                                    <div id="b7_nav" class="nav nav-inline">

                                        <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>

                                        <?php //$layout=$prod->get_layout($layout_id,"b7",$window_id);



                                        $layoutline=$domenia->get_layouts_by_quality_id2("b7");



                                        for($i=0;$i<count($layoutline);$i++)

                                        {

                                            ?>

                                            <a href="#b7_layouts" class="nav-item" title="<?php echo $layoutline[$i]['l_id'];?>">

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

                                    <input type="hidden" name="b7_selected_layoutline" value="" form="create_order_form">

                                </div>

                            </div>



                            <br>



                            <?php

                            if(count($b7_in_products)>0)

                            {

                                ?>

                                <div class="row form-inline w-100 mx-0 mt-3">

                                    <div class="col-md-12">

                                        <b>Employee-Producer: Col IN B7 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_labc_in_b7" id="col_labc_in_b7" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_in_b7 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_labc_in_b7" id="fac_labc_in_b7" value="1" form="create_order_form" style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b7" id="col_amount3_in_b7" form="create_order_form" value="1" style="width:5em">

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b7" id="total_labcs_in_b7" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0">

                                    <div class="col-md-12">

                                        <b>Producer-Trader: Col IN B7 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_apus_in_b7" id="col_apus_in_b7" value="" form="create_order_form" style="width:5em"> <b>APEs X fac_prod_in_b7 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_prod_in_b7" id="fac_prod_in_b7" value="1" form="create_order_form"  style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b7" id="col_amount2_in_b7" form="create_order_form"  value="1" style="width:5em">

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b7" id="o_apus_in_b7" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0 ">

                                    <div class="col-md-12">

                                        <b>Trader-Purchaser: Col IN B7 = </b>

                                        <input class="form-control form-control-sm" type="text" name="col_price_in_b7" id="col_price_in_b7" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?> X fac_client_in_b7 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_cl_in_b7" id="fac_cl_in_b7" value="1" form="create_order_form" style="width:5em">

                                        <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b7" id="col_amount1_in_b7" form="create_order_form" value="1" style="width:5em">

                                        <b>=</b>

                                        <input type="text" class="form-control form-control-sm" name="o_price_in_b7" id="o_price_in_b7" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?></b>

                                        <br><br>

                                    </div>

                                </div>

                                <?php

                            }

                            ?>

                        </div>

                        <?php

                    } //end b7_in_products





                    //start b8_in_products

                    if(count($b8_in_products)>0)

                    {



                        ?>

                        <div class="col-md-12 collapse" id="interiorb8" style="background-color:#a3a373;">

                            <div class="row w-100 mx-0 pl-4">

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

                                    <div class="row w-100 mx-0 my-1">

                                        <div class="">

                                            <input class="products product_in_b8 checkbox mr-2" type="checkbox" name="<?php echo $b8_in_products[$i]; ?>" id="<?php echo $b8_in_products[$i]; ?>" value="<?php echo $b8_in_products[$i]; ?>">

                                            <label for="<?php echo $b8_in_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b8_in_products[$i];?>_original_price"><?php echo $product_price;?></span> <?php echo $currency; ?></label>

                                            <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_price" name="product_<?php echo $b8_in_products[$i];?>_price" class="" value="<?php echo $product_price; ?>">

                                            <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_apu" name="product_<?php echo $b8_in_products[$i];?>_apu" class="" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_labc" name="product_<?php echo $b8_in_products[$i];?>_labc" class="" value="<?php echo $product_labc; ?>">



                                            <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                            <input type="hidden" id="product_<?php echo $b8_in_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                            <?php

                                            // if(($b8_in_products[$i]=="p1800")||($b8_in_products[$i]=="p1801")||($b8_in_products[$i]=="p1804")||($b8_in_products[$i]=="p1806")||($b8_in_products[$i]=="p1821")||($b8_in_products[$i]=="p1824")||($b8_in_products[$i]=="p1826")||($b8_in_products[$i]=="p1841")||($b8_in_products[$i]=="p1844")||($b8_in_products[$i]=="p1846"))

                                            // {

                                            ?>

                                            <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b8_in_multiplicator" form="create_order_form" id="<?php echo $b8_in_products[$i]; ?>_fac" name="<?php echo $b8_in_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                            <?php

                                            //}

                                            ?>

                                        </div>	<!-- end active_layout -->

                                    </div>	<!-- end row -->

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



                            <div class="row w-100 mx-0 pt-3">

                                <div class="col-md-12 d-flex justify-content-center">

                                    <div id="b7_nav" class="nav nav-inline">

                                        <p class="mb-0 mt-2 mr-2"><b>Layoutline: </b></p>

                                        <?php //$layout=$prod->get_layout($layout_id,"b7",$window_id);



                                        $layoutline=$domenia->get_layouts_by_quality_id2("b8");



                                        for($i=0;$i<count($layoutline);$i++)

                                        {

                                            ?>

                                            <a href="#b7_layouts" class="nav-item" title="<?php echo $layoutline[$i]['l_id'];?>">

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

                                    <input type="hidden" name="b8_selected_layoutline" value="" form="create_order_form">

                                </div>

                            </div>



                            <br>



                            <?php

                            if(count($b8_in_products)>0)

                            {

                                ?>
                                <div class="row form-inline w-100 mx-0">

                                    <div class="col-md-12">

                                        <b>Employee-Producer: Col IN B8 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_labc_in_b8" id="col_labc_in_b8" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_in_b8 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_labc_in_b8" id="fac_labc_in_b8" value="1" form="create_order_form" style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount3_in_b8" id="col_amount3_in_b8" form="create_order_form" value="1" style="width:5em">

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_in_b8" id="total_labcs_in_b8" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0">

                                    <div class="col-md-12">

                                        <b>Producer-Trader: Col IN B8 = </b>

                                        <input type="text" class="form-control form-control-sm" name="col_apus_in_b8" id="col_apus_in_b8" value="" form="create_order_form" style="width:5em"> <b>APEs X fac_prod_in_b8 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_prod_in_b8" id="fac_prod_in_b8" value="1" form="create_order_form"  style="width:5em">

                                        <b>X Amount of subIDs: </b><input type="text" class="form-control form-control-sm" name="col_amount2_in_b8" id="col_amount2_in_b8" form="create_order_form"  value="1" style="width:5em">

                                        <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_in_b8" id="o_apus_in_b8" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0 mt-3">

                                    <div class="col-md-12">

                                        <b>Trader-Purchaser: Col IN B8 = </b>

                                        <input class="form-control form-control-sm" type="text" name="col_price_in_b8" id="col_price_in_b8" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?> X fac_client_in_b8 = </b>

                                        <input type="text" class="form-control form-control-sm" name="fac_cl_in_b8" id="fac_cl_in_b8" value="1" form="create_order_form" style="width:5em">

                                        <b> X Amount of subIDs:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_in_b8" id="col_amount1_in_b8" form="create_order_form" value="1" style="width:5em">

                                        <b>=</b>

                                        <input type="text" class="form-control form-control-sm" name="o_price_in_b8" id="o_price_in_b8" value="" form="create_order_form" style="width:5em">

                                        <b><?php echo $currency; ?></b>

                                        <br><br>

                                    </div>

                                </div>

                                <?php

                            }

                            ?>

                        </div>

                        <?php

                    } //end b8_in_products



                    ?>



                    <div id="remarks_in_row" class="row mx-0 w-100 py-4 d-none">

                        <div class="form-group">

                            <div class="col-md-12">

                                <p class="mb-1"><b>Customer remarks interior : </b></p>

                                <textarea name="customer_remarks_in" class="form-control form-control-sm" rows="2" cols="6"  form="create_order_form" style="width:500px"></textarea>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-md-12">

                                <p class="mb-1"><b>Operator remarks interior: </b></p>

                                <textarea name="op_remarks_in" class="form-control form-control-sm" rows="2" cols="6" form="create_order_form"  style="width:500px"></textarea>

                            </div>

                        </div>

                    </div>

                </div> <!-- end interior -->

                <?php

            }*/


            /*   
            ?>



            <div class="exterior border-bottom border-dark" style="box-shadow: none;">



                <?php
                
                $exterior=0;

                if(count($b1_ex_products)>0)
                {
                    $exterior++;
                }

                if(count($b3_ex_products)>0)
                {
                    $exterior++;
                }

                if(count($b5_ex_products)>0)

                {

                    $exterior++;

                }

                if(count($b6_ex_products)>0)

                {

                    $exterior++;

                }

                if(count($b7_ex_products)>0)

                {

                    $exterior++;

                }

                if(count($b8_ex_products)>0)

                {

                    $exterior++;

                }*/


                /*
                if($exterior>0)

                {

                    ?>

                    <div class="row w-100 mx-0 border-top border-dark pt-4">

                        <div class="col-md-2">

                            <h5 class="text-success w-100 text-center ">Exterior</h5>

                        </div>
                        <div class="col-md-5 d-flex justify-content-center">
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
                    </div><!-- end row -->
                    <hr width="300px" class="bg-secondary">
                    <div class="row w-100 ml-1">
                        <!-- exterior buttons -->
                        <div class="col-md-2">

                            <?php

                            if(count($b1_ex_products)==0)

                            {

                                ?>

                                <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="exbtnb1" data-target="#exteriorb1" data-toggle="collapse"><del>B1 exterior</del></button>

                                <br><span class="text-danger">Not for this website</span>

                                <?php

                            }

                            else

                            {

                                ?>

                                <button class="btn btn-sm btn-success text-white px-3 ml-1" id="exbtnb1" data-target="#exteriorb1" data-toggle="collapse">B1 exterior</button>

                                <?php

                            }

                            ?>

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





                        // if($_COOKIE['lt_id']!=9)

                        // {

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

                        //}

                        ?>

                        <div class="col-md-2" style="background-color:#6aa36f;">

                            <?php

                            if(count($b7_ex_products)==0)

                            {

                                ?>

                                <button class="btn btn-sm btn-success text-danger px-3 ml-1" id="exbtnb7" data-target="#exteriorb7" data-toggle="collapse"><del>B7 exterior - Top quality</del></button>

                                <br><span class="text-danger">Not for this website</span>

                                <?php

                            }

                            else

                            {

                                ?>

                                <button class="btn btn-sm btn-success text-white px-3 ml-1" id="exbtnb7" data-target="#exteriorb7" data-toggle="collapse">B7 exterior - Top quality</button>

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
                    </div><!-- end row -->



                    <a id="exterior"></a>

                    <div class="center_message"> <div class="success"><?php echo (!empty($result_message))?$result_message:"";?></div></div>
                    <?php

                    if(count($b1_ex_products)>0)
                    {

                        ?>

                        <div class="collapse" id="exteriorb1" style="background-color:#94ce99;">

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

                                    $product_price=$price->calculateProductPrice($b1_ex_products[$i],$cur_factor);

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

                                <div class="">

                                    <input class="products product_ex_b1 checkbox mr-2" type="checkbox" name="<?php echo $b1_ex_products[$i]; ?>" id="<?php echo $b1_ex_products[$i]; ?>" value="<?php echo $b1_ex_products[$i]; ?>" <?php



                                    ?>>

                                    <label for="<?php echo $b1_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b1_ex_products[$i];?>_original_price"><?php echo $product_price;?></span><?php echo " ".$currency; ?></label>

                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_price" name="product_<?php echo $b1_ex_products[$i];?>_price" class="<?php



                                    ?>" value="<?php echo $product_price; ?>">

                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_apu" name="product_<?php echo $b1_ex_products[$i];?>_apu" class="<?php



                                    ?>" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_labc" name="product_<?php echo $b1_ex_products[$i];?>_labc" class="<?php



                                    ?>" value="<?php echo $product_labc; ?>">



                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b1_ex_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                    <?php

                                    if(($b1_ex_products[$i]=="p1561")||($b1_ex_products[$i]=="p1566"))

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b1_ex_multiplicator" form="create_order_form" id="<?php echo $b1_ex_products[$i]; ?>_fac" name="<?php echo $b1_ex_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }



                                    if($b1_ex_products[$i]=="p1563")

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b1_ex_multiplicator" form="create_order_form" id="<?php echo $b1_ex_products[$i]; ?>_fac" name="<?php echo $b1_ex_products[$i]; ?>_fac" value="3" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }

                                    ?>

                                </div>

                            </div>

                            <?php

                            if(($counter%$b1_ex_lines==0)&&($counter>0))

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

                                <?php

                                if(count($b1_ex_products)>0)

                                {

                                    ?>


                                    <div class="row form-inline w-100 mx-0 text-center pt-3">

                                        <div class="col-md-12">

                                            <b>Employee-Producer: Col EX B1 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_labc_ex_b1" id="col_labc_ex_b1" value="" form="create_order_form" style="width:5em" > <b>labcs X fac_labc_ex_b1 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b1" id="fac_labc_ex_b1" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b1" id="col_amount3_ex_b1" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b1" id="total_labcs_ex_b1" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                        </div>

                                    </div>
                                    <div class="row form-inline w-100 mx-0 text-center">

                                        <div class="col-md-12">

                                            <b>Producer-Trader: Col EX B1 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_apus_ex_b1" id="col_apus_ex_b1" value="" form="create_order_form" style="width:5em" > <b>APEs X fac_prod_ex_b1 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b1" id="fac_prod_ex_b1" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b1" id="col_amount2_ex_b1" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b1" id="o_apus_ex_b1" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0 text-center ">

                                        <div class="col-md-12">

                                            <b>Trader-Purchaser: Col EX B1 = </b>

                                            <input class="form-control form-control-sm" type="text" name="col_price_ex_b1" id="col_price_ex_b1" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?> X fac_client_ex_b1 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b1" id="fac_cl_ex_b1" value="1" form="create_order_form" style="width:5em">

                                            <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b1" id="col_amount1_ex_b1" form="create_order_form" value="1" style="width:5em">

                                            <b>=</b>

                                            <input type="text" class="form-control form-control-sm" name="o_price_ex_b1" id="o_price_ex_b1" value="" form="create_order_form" style="width:5em" >

                                            <b><?php echo $currency; ?></b>

                                            <br><br>

                                        </div>

                                    </div>





                                    <?php

                                }?>



                            </div> <!-- end row -->

                        </div> <!-- div collapse -->



                        <?php

                    } //end b1 ex products


                    if(count($b5_ex_products)>0)

                    {

                        ?>

                        <div class="collapse" id="exteriorb5" style="background-color:#94ce99;">

                            <div class="row w-100 mx-0">

                                <?php

                                $b5_ex_columns=3;

                                //$b5_ex_lines=ceil(count($b5_ex_products) / $b5_ex_columns);

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

                            <div class="row w-100 mx-0 my-1">

                                <div class="">

                                    <input class="products product_ex_b5 checkbox mr-2" type="checkbox" name="<?php echo $b5_ex_products[$i]; ?>" id="<?php echo $b5_ex_products[$i]; ?>" value="<?php echo $b5_ex_products[$i]; ?>" <?php



                                    ?>>

                                    <label for="<?php echo $b5_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b5_ex_products[$i];?>_original_price"><?php echo $product_price;?></span><?php echo " ".$currency; ?></label>

                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_price" name="product_<?php echo $b5_ex_products[$i];?>_price" class="<?php



                                    ?>" value="<?php echo $product_price; ?>">

                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_apu" name="product_<?php echo $b5_ex_products[$i];?>_apu" class="<?php



                                    ?>" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_labc" name="product_<?php echo $b5_ex_products[$i];?>_labc" class="<?php



                                    ?>" value="<?php echo $product_labc; ?>">



                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b5_ex_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                    <?php

                                    if(($b5_ex_products[$i]=="p1561")||($b5_ex_products[$i]=="p1566"))

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_ex_multiplicator" form="create_order_form" id="<?php echo $b5_ex_products[$i]; ?>_fac" name="<?php echo $b5_ex_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }



                                    if($b5_ex_products[$i]=="p1563")

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b5_ex_multiplicator" form="create_order_form" id="<?php echo $b5_ex_products[$i]; ?>_fac" name="<?php echo $b5_ex_products[$i]; ?>_fac" value="3" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }

                                    ?>

                                </div>

                            </div>

                            <?php

                            if(($counter%$b5_ex_lines==0)&&($counter>0))

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

                                <?php

                                if(count($b5_ex_products)>0)

                                {

                                    ?>

                                    <div class="row form-inline w-100 mx-0 text-center pt-3">

                                        <div class="col-md-12">

                                            <b>Employee-Producer: Col EX B5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_labc_ex_b5" id="col_labc_ex_b5" value="" form="create_order_form" style="width:5em" > <b>labcs X fac_labc_ex_b5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b5" id="fac_labc_ex_b5" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b5" id="col_amount3_ex_b5" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b5" id="total_labcs_ex_b5" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                        </div>

                                    </div>



                                    <div class="row form-inline w-100 mx-0 text-center">

                                        <div class="col-md-12">

                                            <b>Producer-Trader: Col EX B5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_apus_ex_b5" id="col_apus_ex_b5" value="" form="create_order_form" style="width:5em" > <b>APEs X fac_prod_ex_b5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b5" id="fac_prod_ex_b5" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b5" id="col_amount2_ex_b5" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b5" id="o_apus_ex_b5" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0 text-center ">

                                        <div class="col-md-12">

                                            <b>Trader-Purchaser: Col EX B5 = </b>

                                            <input class="form-control form-control-sm" type="text" name="col_price_ex_b5" id="col_price_ex_b5" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?> X fac_client_ex_b5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b5" id="fac_cl_ex_b5" value="1" form="create_order_form" style="width:5em">

                                            <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b5" id="col_amount1_ex_b5" form="create_order_form" value="1" style="width:5em">

                                            <b>=</b>

                                            <input type="text" class="form-control form-control-sm" name="o_price_ex_b5" id="o_price_ex_b5" value="" form="create_order_form" style="width:5em" >

                                            <b><?php echo $currency; ?></b>

                                            <br><br>

                                        </div>

                                    </div>

                                    <?php

                                }?>



                            </div> <!-- end row -->

                        </div> <!-- div collapse -->



                        <?php

                    } //end b5 ex products





                    //start b6 ex products



                    if(count($b6_ex_products)>0)

                    {

                        ?>

                        <div class="collapse border-top border-dark" id="exteriorb6" style="background-color:#94ce99;">

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

                            <div class="row w-100 mx-0 my-1">

                                <div class="">

                                    <input class="products product_ex_b6 checkbox mr-2" type="checkbox" name="<?php echo $b6_ex_products[$i]; ?>" id="<?php echo $b6_ex_products[$i]; ?>" value="<?php echo $b6_ex_products[$i]; ?>" <?php



                                    ?>>

                                    <label for="<?php echo $b6_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b6_ex_products[$i];?>_original_price"><?php echo $product_price;?></span><?php echo " ".$currency; ?></label>

                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_price" name="product_<?php echo $b6_ex_products[$i];?>_price" class="<?php



                                    ?>" value="<?php echo $product_price; ?>">

                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_apu" name="product_<?php echo $b6_ex_products[$i];?>_apu" class="<?php



                                    ?>" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_labc" name="product_<?php echo $b6_ex_products[$i];?>_labc" class="<?php



                                    ?>" value="<?php echo $product_labc; ?>">



                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b6_ex_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                    <?php

                                    if(($b6_ex_products[$i]=="p1661")||($b6_ex_products[$i]=="p1666"))

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b6_ex_multiplicator" form="create_order_form" id="<?php echo $b6_ex_products[$i]; ?>_fac" name="<?php echo $b6_ex_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }



                                    if($b6_ex_products[$i]=="p1663")

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b6_ex_multiplicator" form="create_order_form" id="<?php echo $b6_ex_products[$i]; ?>_fac" name="<?php echo $b6_ex_products[$i]; ?>_fac" value="3" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }

                                    ?>

                                </div>

                            </div>

                            <?php

                            if(($counter%$b6_ex_lines==0)&&($counter>0))

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

                                <?php

                                if(count($b6_ex_products)>0)

                                {

                                    ?>

                                    <div class="row form-inline w-100 mx-0 text-center pt-3">

                                        <div class="col-md-12">

                                            <b>Employee-Producer: Col EX B6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_labc_ex_b6" id="col_labc_ex_b6" value="" form="create_order_form" style="width:5em" > <b>labcs X fac_labc_ex_b6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b6" id="fac_labc_ex_b6" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b6" id="col_amount3_ex_b6" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b6" id="total_labcs_ex_b6" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                        </div>

                                    </div>
                                    <div class="row form-inline w-100 mx-0 text-center">

                                        <div class="col-md-12">

                                            <b>Producer-Trader: Col EX B6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_apus_ex_b6" id="col_apus_ex_b6" value="" form="create_order_form" style="width:5em" > <b>APEs X fac_prod_ex_b5 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b6" id="fac_prod_ex_b6" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b6" id="col_amount2_ex_b6" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b6" id="o_apus_ex_b6" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0 text-center ">

                                        <div class="col-md-12">

                                            <b>Trader-Purchaser: Col EX B6 = </b>

                                            <input class="form-control form-control-sm" type="text" name="col_price_ex_b6" id="col_price_ex_b6" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?> X fac_client_ex_b6 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b6" id="fac_cl_ex_b6" value="1" form="create_order_form" style="width:5em">

                                            <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b6" id="col_amount1_ex_b6" form="create_order_form" value="1" style="width:5em">

                                            <b>=</b>

                                            <input type="text" class="form-control form-control-sm" name="o_price_ex_b6" id="o_price_ex_b6" value="" form="create_order_form" style="width:5em" >

                                            <b><?php echo $currency; ?></b>

                                            <br><br>

                                        </div>

                                    </div>

                                    <?php

                                }?>



                            </div> <!-- end row -->

                        </div> <!-- div collapse -->



                        <?php

                    }



                    //end b6 ex products

                    ?>

                    <!-- <hr class="bg-dark" width="100%"> -->

                    <?php

                    if(count($b7_ex_products)>0)

                    {

                        ?>

                        <div class="collapse border-top border-dark" id="exteriorb7" style="background-color:#6aa36f;">

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

                            <div class="row w-100 mx-0 my-1">

                                <div class="<?php



                                ?>">

                                    <input class="products product_ex_b7 checkbox mr-2" type="checkbox" name="<?php echo $b7_ex_products[$i]; ?>" id="<?php echo $b7_ex_products[$i]; ?>" value="<?php echo $b7_ex_products[$i]; ?>" <?php



                                    ?>>

                                    <label for="<?php echo $b7_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b7_ex_products[$i];?>_original_price"><?php echo $product_price;?></span><?php echo " ".$currency; ?></label>

                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_price" name="product_<?php echo $b7_ex_products[$i];?>_price" class="<?php



                                    ?>" value="<?php echo $product_price; ?>">

                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_apu" name="product_<?php echo $b7_ex_products[$i];?>_apu" class="<?php



                                    ?>" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_labc" name="product_<?php echo $b7_ex_products[$i];?>_labc" class="<?php



                                    ?>" value="<?php echo $product_labc; ?>">



                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b7_ex_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                    <?php

                                    if(($b7_ex_products[$i]=="p1761")||($b7_ex_products[$i]=="p1766"))

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b7_ex_multiplicator" form="create_order_form" id="<?php echo $b7_ex_products[$i]; ?>_fac" name="<?php echo $b7_ex_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }



                                    if($b7_ex_products[$i]=="p1763")

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b7_ex_multiplicator" form="create_order_form" id="<?php echo $b7_ex_products[$i]; ?>_fac" name="<?php echo $b7_ex_products[$i]; ?>_fac" value="3" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }

                                    ?>

                                </div>

                            </div>

                            <?php

                            if(($counter%$b7_ex_lines==0)&&($counter>0))

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

                                <?php

                                if(count($b7_ex_products)>0)

                                {

                                    ?>

                                    <div class="row form-inline w-100 mx-0 pt-3">

                                        <div class="col-md-12">

                                            <b>Employee-Producer: Col EX B7 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_labc_ex_b7" id="col_labc_ex_b7" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_ex_b7 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b7" id="fac_labc_ex_b7" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b7" id="col_amount3_ex_b7" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b7" id="total_labcs_ex_b7" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                        </div>

                                    </div>



                                    <div class="row form-inline w-100 mx-0">

                                        <div class="col-md-12">

                                            <b>Producer-Trader: Col EX B7 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_apus_ex_b7" id="col_apus_ex_b7" value="" form="create_order_form" style="width:5em" > <b>APEs X fac_prod_ex_b7 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b7" id="fac_prod_ex_b7" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b7" id="col_amount2_ex_b7" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b7" id="o_apus_ex_b7" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0 ">

                                        <div class="col-md-12">

                                            <b>Trader-Purchaser: Col EX B7 = </b>

                                            <input class="form-control form-control-sm" type="text" name="col_price_ex_b7" id="col_price_ex_b7" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?> X fac_client_ex_b7 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b7" id="fac_cl_ex_b7" value="1" form="create_order_form"  style="width:5em">

                                            <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b7" id="col_amount1_ex_b7" form="create_order_form" value="1" style="width:5em">

                                            <b>=</b>

                                            <input type="text" class="form-control form-control-sm" name="o_price_ex_b7" id="o_price_ex_b7" value="" form="create_order_form" style="width:5em" >

                                            <b><?php echo $currency; ?></b>

                                            <br><br>

                                        </div>

                                    </div>

                                    <?php

                                }

                                ?>

                            </div> <!-- end row -->

                        </div>

                        <?php

                    }



                    //b8 ex



                    if(count($b8_ex_products)>0)

                    {

                        ?>

                        <div class="collapse border-top border-dark" id="exteriorb8" style="background-color:#6aa36f;">

                            <div class="row w-100 mx-0">

                                <?php

                                $b8_ex_columns=3;

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

                            <div class="row w-100 mx-0 my-1">

                                <div class="<?php



                                ?>">

                                    <input class="products product_ex_b8 checkbox mr-2" type="checkbox" name="<?php echo $b8_ex_products[$i]; ?>" id="<?php echo $b8_ex_products[$i]; ?>" value="<?php echo $b8_ex_products[$i]; ?>" <?php



                                    ?>>

                                    <label for="<?php echo $b8_ex_products[$i]; ?>"><?php echo $product['prod_name']; ?> - <span id="product_<?php echo $b8_ex_products[$i];?>_original_price"><?php echo $product_price;?></span><?php echo " ".$currency; ?></label>

                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_price" name="product_<?php echo $b8_ex_products[$i];?>_price" class="<?php



                                    ?>" value="<?php echo $product_price; ?>">

                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_apu" name="product_<?php echo $b8_ex_products[$i];?>_apu" class="<?php



                                    ?>" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_labc" name="product_<?php echo $b8_ex_products[$i];?>_labc" class="<?php



                                    ?>" value="<?php echo $product_labc; ?>">

                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_original_apu" value="<?php echo $product_apu; ?>">

                                    <input type="hidden" id="product_<?php echo $b8_ex_products[$i];?>_original_labc" value="<?php echo $product_labc; ?>">



                                    <?php

                                    if(($b8_ex_products[$i]=="p1861")||($b8_ex_products[$i]=="p1866"))

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b8_ex_multiplicator" form="create_order_form" id="<?php echo $b8_ex_products[$i]; ?>_fac" name="<?php echo $b8_ex_products[$i]; ?>_fac" value="1" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }



                                    if($b8_ex_products[$i]=="p1863")

                                    {

                                        ?>

                                        <span class="text-danger font-weight-bold">X</span> <input type="text" class="form-control form-control-sm d-inline px-2 b8_ex_multiplicator" form="create_order_form" id="<?php echo $b8_ex_products[$i]; ?>_fac" name="<?php echo $b8_ex_products[$i]; ?>_fac" value="3" style="width:3em;" title="Multiplicator">

                                        <?php

                                    }

                                    ?>

                                </div>

                            </div>

                            <?php

                            if(($counter%$b8_ex_lines==0)&&($counter>0))

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



                                <?php

                                if(count($b8_ex_products)>0)

                                {

                                    ?>

                                    <div class="row form-inline w-100 mx-0 pt-3">

                                        <div class="col-md-12">

                                            <b>Employee-Producer: Col EX B8 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_labc_ex_b8" id="col_labc_ex_b8" value="" form="create_order_form" style="width:5em"> <b>labcs X fac_labc_ex_b8 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_labc_ex_b8" id="fac_labc_ex_b8" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount3_ex_b8" id="col_amount3_ex_b8" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="total_labcs_ex_b8" id="total_labcs_ex_b8" value="" form="create_order_form" style="width:5em"> <b>labcs</b><br><br>

                                        </div>

                                    </div>


                                    <div class="row form-inline w-100 mx-0">

                                        <div class="col-md-12">

                                            <b>Producer-Trader: Col EX B8 = </b>

                                            <input type="text" class="form-control form-control-sm" name="col_apus_ex_b8" id="col_apus_ex_b8" value="" form="create_order_form" style="width:5em" > <b>APEs X fac_prod_ex_b8 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_prod_ex_b8" id="fac_prod_ex_b8" value="1" form="create_order_form" style="width:5em">

                                            <b>X Amount of houses: </b><input type="text" class="form-control form-control-sm" name="col_amount2_ex_b8" id="col_amount2_ex_b8" form="create_order_form" value="1" style="width:5em">

                                            <b> = </b> <input type="text" class="form-control form-control-sm" name="o_apus_ex_b8" id="o_apus_ex_b8" value="" form="create_order_form" style="width:5em"> <b>APEs</b><br><br>

                                        </div>

                                    </div>

                                    <div class="row form-inline w-100 mx-0 ">

                                        <div class="col-md-12">

                                            <b>Trader-Purchaser: Col EX B8 = </b>

                                            <input class="form-control form-control-sm" type="text" name="col_price_ex_b8" id="col_price_ex_b8" value="" form="create_order_form" style="width:5em">

                                            <b><?php echo $currency; ?> X fac_client_ex_b8 = </b>

                                            <input type="text" class="form-control form-control-sm" name="fac_cl_ex_b8" id="fac_cl_ex_b8" value="1" form="create_order_form"  style="width:5em">

                                            <b> X Amount of houses:</b> <input type="text" class="form-control form-control-sm" name="col_amount1_ex_b8" id="col_amount1_ex_b8" form="create_order_form" value="1" style="width:5em">

                                            <b>=</b>

                                            <input type="text" class="form-control form-control-sm" name="o_price_ex_b8" id="o_price_ex_b8" value="" form="create_order_form" style="width:5em" >

                                            <b><?php echo $currency; ?></b>

                                            <br><br>

                                        </div>

                                    </div>

                                    <?php

                                }

                                ?>

                            </div> <!-- end row -->

                        </div>

                        <?php

                    }



                }*/



                //$plans_amount=$order['b5_col_amount'];

                /*
                ?>

                <div id="remarks_ex_row" class="container pagecontent bg-white px-0 d-none">

                    <br>

                    <?php

                    include('../../../../domenia7.com/public_html/create_order_short_order_description_general.php');

                    ?>

                    <div class="row mx-0 w-100 py-5">

                        <div class="col-md-4">

                            <div class="form-group">

                                <b>Real address for the environment: </b>

                                <textarea name="environment_address" class="form-control form-control-sm" rows="2" cols="6" form="create_order_form"></textarea>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <b>Customer remarks exterior: </b>

                                <textarea name="customer_remarks_ex" class="form-control form-control-sm" rows="2" cols="6" form="create_order_form"></textarea>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <b>Operator remarks exterior: </b>

                                <textarea name="op_remarks_ex" class="form-control form-control-sm" form="create_order_form"></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- <br> -->

                <a id="customerfiles"></a>



                <!-- <br> -->

            </div> <!-- end exterior -->
            <?php
            */
            ?>

            <div class="container pagecontent px-0 bg-white">

                <input type="hidden" id="collection" name="collection" value="p1301;p1321;p1322;p1561;p1562;p1563;p1581" form="create_order_form">

                <input type="hidden" name="cur_fac" id="cur_fac" value="<?php echo $licence['cur_fac']; ?>" form="create_order_form" >





                <!-- <div class="error pt-4 w-100 text-center">Customer files can be uploaded only on the next page</div> -->

                <div class="row pt-4 w-100 text-center mb-5">

                    <p class="text-center w-100 text-success mb-0"><b class="border-bottom pb-2">Upload files:</b></p>

                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-12 text-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="no_upload_files" name="no_upload_files" form="create_order_form" checked>
                            <label class="form-check-label text-danger" for="no_upload_files">
                                You can upload files only after you create the order
                            </label>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $('#no_upload_files').click(function(){
                        if($('#no_upload_files').is(':checked'))
                        {
                            $('#client_file_1').prop('required',false);
                        }
                        else
                        {
                            $('#client_file_1').prop('required',true);
                        }
                    });
                </script>
                
                <br>



                <div class="totals w-100 row mx-0">

                    <div class="col-md-12 p-4">

                        <?php

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



                        // if($order['payment_way']==9)

                        // {

                        //     $vat_percent=0;

                        // }

                        ?>

                        <input type="hidden" id="vat_percent" name="vat_percent" form="create_order_form" value="<?php echo $vat_percent;?>">

                        <input type="hidden" id="vat_a_id" name="vat_a_id" form="create_order_form" value="<?php echo $vat_a_id;?>">

                        <?php 
                        /*
                        <div class="row form-inline w-100 mx-0 my-2">

                            <div class="col-md-8">

                                <div class="row">

                                    <div class="col-md-12">

                                        <label for="total_price" class="d-inline"><b>Total price = </b></label>

                                        <input type="text" name="total_price" id="total_price" class="form-control form-control-sm d-inline" form="create_order_form" style="width:6em;" value="<?php

                                        if(strpos($order['collection'],'p1001')!==false)

                                        {

                                            echo $order['o_price'];

                                        }

                                        ?>">

                                        <b class="d-inline"><?php echo $currency; ?></b>

                                        <b class="d-inline">or</b>

                                        <label for="total_special_agreement_price" class="d-inline"><b>Total special agreement price = </b></label>

                                        <input type="text" name="total_special_agreement_price" id="total_special_agreement_price" class="form-control form-control-sm d-inline" form="create_order_form" style="width:6em;" value="<?php

                                        echo (isset($_COOKIE['total_special_agreement_price']))?$_COOKIE['total_special_agreement_price']:"";

                                        ?>">

                                        <b class="d-inline"><?php echo $currency; ?></b>

                                    </div>

                                </div>

                                <div class="row form-inline w-100 mx-0 my-2">

                                    <div class="col-md-12">

                                        <label for="total_apu" class="d-inline"><b>Total APUs = </b></label>

                                        <input type="text" name="total_apu" id="total_apu" class="form-control form-control-sm d-inline" style="width:6em;" value="<?php

                                        if(strpos($order['collection'],'p1001')!==false)

                                        {

                                            echo $budget_apu=$prod->calculateProductAPU("p1001");

                                        }

                                        ?>">

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-2">

                                <?php

                                $main_client=$prod->get_main_client($client['mc_id']);



                                if(!empty($main_client))

                                {

                                    ?>

                                    <textarea class="form-control form-control-sm" name="price_remarks" id="price_remarks" data-mc_id="<?php echo $main_client['mc_id']?>" title="Main client price information" placeholder="Main client price information"><?php



                                        if(!empty($main_client))

                                        {

                                            echo $main_client['price_remarks'];

                                        }

                                        ?></textarea>

                                    <br><br>

                                    <?php

                                }

                                ?>

                                <textarea class="form-control form-control-sm" name="client_price_remarks" id="client_price_remarks" data-client_id="<?php echo $client['client_ID']?>" title="Simple client price information" placeholder="Simple client price information"><?php



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

                        </div> */ ?>

                        <?php
                        /*
                        <div class="row form-inline w-100 mx-0 my-2 pt-2">

                            <div class="col-md-12">

                                <b>Producer for this order:</b>

                                <input  type="hidden" id="producerid2" name="producerid2" value="<?php

                                //$creators_company=$prod->get_creators_company($_COOKIE['email']);



                                //echo $creators_company['lt_id'];

                                echo $lt_id['licence-taker'];

                                ?>">



                                <select  id="producers" name="producers" class="form-control form-control-sm" style="width:300px" form="create_order_form" required>

                                    <option value="">-= Choose =-</option>

                                    <?php

                                    $producers=$prod->get_licence($licenceid);

                                    $u_producers=explode(';',$producers['uprod_id']);

                                    for($i=0;$i<count($u_producers)-1;$i++)

                                    {

                                        ?>

                                        <option value="<?php echo $u_producers[$i]; ?>" <?php echo ($i==0)?"selected":"";?>><?php echo $prod->get_company($u_producers[$i])['Company']; ?></option>

                                        <?php

                                    }

                                    ?>

                                </select>

                            </div>

                        </div> */ ?>

                        <div class="row center_message w-100 mx-0 d-flex justify-content-center">

                            <button name="create_btn" class="btn btn-primary btn-sm mt-2" form="create_order_form" type="submit">Create new order</button>

                        </div>

                    </div>

                    <br>

                </div> <!-- end totals -->

            </div>

        </div> <!-- end div container -->

        <br>

        <script type='text/javascript' src='js/create_order.js'></script>

        <?php

        }

        //}

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

        ?>

    </article>

    <!-- <script type='text/javascript' src='js/acceptance.js'></script> -->



