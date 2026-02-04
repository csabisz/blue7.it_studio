<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
// include('../../../superfloorplans.com/public_html/functions.php');
// include('../../../superfloorplans.com/public_html/price_calculations.php');
include("../../../../blue7.it/public_html/domenia/domenia.php");
include("../notifications.php");

//$price=new PriceCalculations;
$domenia=new Domenia;
$notification=new Notifications;

if((isset($_COOKIE['client_id']))&&(isset($_GET['o_id'])))
{
$o_id=$prod->xss_fix($_GET['o_id']);
$order=$prod->get_order($o_id);
$uca_id=$_COOKIE['client_id'];

$clientid=$order['u_client_ID'];
$client=$prod->get_client($clientid);
$licence=$prod->get_licence($order['lic_ID']);
$budget=$prod->get_o_desc_b0($order['order_ID']);

//$lic_sites=$prod->get_lic_site($order['ls_id']);

if($order['payment_way']==9)
{
	$currency="CRD";
}
else
{
	$currency=$prod->get_currency($order['cur_id'])['cur_short'];
}
$seller=$prod->get_licence_taker($o_id);



$lic_site=$prod->get_order_website($order['ls_id']);
$language=array();
$language[]=$order['client_language_id'];

$message="<b>";
//Dear
if(isset($language[0]))
{
	$text=$domenia->get_translation_text($language[0],"tm_0001","x-texts2")['text'];
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

$message.="&nbsp;";
if(!empty($client['c_last_name']))
{
    $message.=$client['c_first_name']." ".$client['c_last_name']."</b>";
}
else
{
    $message.=$client['l_first_name']." ".$client['l_last_name']."</b>";
}
$message.="<br><br>";
//you ordered via our webpage 
if($order['om_id']==0) //we show this text if it's not amendment or correction
{
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0006","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0006","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0006","x-texts2")['text'];
		$message.=$text;
	}
	$message.="&nbsp;".$lic_site['ls_name'].":";
	$message.="<br><br>";
}

$message.="<b>";
//Order ID 
if(isset($language[0]))
{
	$text=$domenia->get_translation_text($language[0],61,"x-texts")['text'];
	if(!empty($text))
	{
		$message.=$text;
	}
	else
	{
		$text=$domenia->get_translation_text(1,61,"x-texts")['text'];
		$message.=$text;
	}
}
else
{
	$text=$domenia->get_translation_text(1,61,"x-texts")['text'];
	$message.=$text;
}

$message.="&nbsp;".$o_id."</b>,&nbsp;";
//done on 
if(isset($language[0]))
{
	$text=$domenia->get_translation_text($language[0],"tm_0003","x-texts2")['text'];
	if(!empty($text))
	{
		$message.=$text;
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0003","x-texts2")['text'];
		$message.=$text;
	}
}
else
{
	$text=$domenia->get_translation_text(1,"tm_0003","x-texts2")['text'];
	$message.=$text;
}

$message.="&nbsp;<b>";
$date_time=explode(" ",$order['o_date']);
$message.=$date_time[0].", ".$date_time[1]."</b>,";



if($order['om_id']!=0)
{
	$message.="<br><br>";
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tx_1765","x-texts")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tx_1765","x-texts")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tx_1765","x-texts")['text'];
		$message.=$text;
	}

	$message.="&nbsp;".$order['om_id'].".";
}

$message.="<br><br>";

$message.="<b>";
//Project name:
if(isset($language[0]))
{
	$text=$domenia->get_translation_text($language[0],62,"x-texts")['text'];
	if(!empty($text))
	{
		$message.=$text;
	}
	else
	{
		$text=$domenia->get_translation_text(1,62,"x-texts")['text'];
		$message.=$text;
	}
}
else
{
	$text=$domenia->get_translation_text(1,62,"x-texts")['text'];
	$message.=$text;
}
$message.="</b> ".$order['order_name'];

$message.="<br><br>";

if(isset($language[0]))
{
	$text=$domenia->get_translation_text($language[0],"tm_0048","x-texts2")['text'];
	if(!empty($text))
	{
		$message.=$text;
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0048","x-texts2")['text'];
		$message.=$text;
	}
}
else
{
	$text=$domenia->get_translation_text(1,"tm_0048","x-texts2")['text'];
	$message.=$text;
}

$message.="<br>";

$o_desc_in_b3=$prod->get_o_desc_in_b3($o_id);

$o_desc_in_b5=$prod->get_o_desc_in_b5($o_id);
$o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_id);

$o_desc_in_b6=$prod->get_o_desc_in_b6($o_id);
$o_desc_ex_b6=$prod->get_o_desc_ex_b6($o_id);

$o_desc_in_b7=$prod->get_o_desc_in_b7($o_id);
$o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_id);

$o_desc_in_b8=$prod->get_o_desc_in_b8($o_id);
$o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_id);

//$cur_factor=$prod->get_cur_factor($o_id)['cur_fac'];
$cur_factor=$lic_site['cur_fac_'.strtolower($currency)];


if(($client['client_credibility']!=9)&&($client['mc_id']>=0))
{
	if($order['payment_way']==9)
	{
		$price_b3_in_uf_floorplan=$prod->calculateProductAPU("p1301");
        $price_b3_in_uf_total_2D=$prod->calculateProductAPU("p1302");
		
        $price_b3_in_liv_floorplan=$prod->calculateProductAPU("p1321");
        $price_b3_in_liv_total_2D=$prod->calculateProductAPU("p1322");

		$price_b5_uf_model=$prod->calculateProductAPU("p1501");
		$price_b5_uf_2dtotal=$prod->calculateProductAPU("p1502");
		$price_b5_uf_3dtotal=$prod->calculateProductAPU("p1503");
		$price_b5_uf_details_in=$prod->calculateProductAPU("p1504");
		$price_b5_uf_details_out=$prod->calculateProductAPU("p1505");
		$price_b5_uf_video=$prod->calculateProductAPU("p1507");
		$price_b5_uf_360=$prod->calculateProductAPU("p1506");

		$price_b5_liv_layer=$prod->calculateProductAPU("p1521");
		$price_b5_liv_2dtotal=$prod->calculateProductAPU("p1522");
		$price_b5_liv_3dtotal=$prod->calculateProductAPU("p1523");
		$price_b5_liv_details_in=$prod->calculateProductAPU("p1524");
		$price_b5_liv_details_out=$prod->calculateProductAPU("p1525");
		$price_b5_liv_video=$prod->calculateProductAPU("p1527");
		$price_b5_liv_360=$prod->calculateProductAPU("p1526");

		$price_b5_business_layer=$prod->calculateProductAPU("p1541");
		$price_b5_business_2dtotal=$prod->calculateProductAPU("p1542");
		$price_b5_business_3dtotal=$prod->calculateProductAPU("p1543");
		$price_b5_business_details_in=$prod->calculateProductAPU("p1544");
		$price_b5_business_details_out=$prod->calculateProductAPU("p1545");
		$price_b5_business_video=$prod->calculateProductAPU("p1547");
		$price_b5_business_360=$prod->calculateProductAPU("p1546");
        $price_b5_in_bus_details_one=$prod->calculateProductAPU("p1548");
        
		$price_b5_ex_house_model=$prod->calculateProductAPU("p1561");
		$price_b5_ex_house_plot_combination=$prod->calculateProductAPU("p1562");
		$price_b5_ex_house_3D=$prod->calculateProductAPU("p1563");
        $price_b5_ex_360=$prod->calculateProductAPU("p1566");
        $price_b5_ex_video_standard_environment=$prod->calculateProductAPU("p1567");

		$price_b5_ex_plot_model=$prod->calculateProductAPU("p1581");
		$price_b5_ex_plot_2D=$prod->calculateProductAPU("p1582");
		$price_b5_ex_plot_3D=$prod->calculateProductAPU("p1583");
        
        $price_b6_uf_model=$prod->calculateProductAPU("p1601");
		$price_b6_uf_2dtotal=$prod->calculateProductAPU("p1602");
		$price_b6_uf_3dtotal=$prod->calculateProductAPU("p1603");
		$price_b6_uf_details_in=$prod->calculateProductAPU("p1604");
		$price_b6_uf_details_out=$prod->calculateProductAPU("p1605");
		$price_b6_uf_video=$prod->calculateProductAPU("p1607");
		$price_b6_uf_360=$prod->calculateProductAPU("p1606");
        $price_b6_uf_vr=$prod->calculateProductAPU("p1608");

		$price_b6_liv_layer=$prod->calculateProductAPU("p1621");
		$price_b6_liv_2dtotal=$prod->calculateProductAPU("p1622");
		$price_b6_liv_3dtotal=$prod->calculateProductAPU("p1623");
		$price_b6_liv_details_in=$prod->calculateProductAPU("p1624");
		$price_b6_liv_details_out=$prod->calculateProductAPU("p1625");
		$price_b6_liv_video=$prod->calculateProductAPU("p1627");
		$price_b6_liv_360=$prod->calculateProductAPU("p1626");
        $price_b6_liv_vr=$prod->calculateProductAPU("p1628");

		$price_b6_business_layer=$prod->calculateProductAPU("p1641");
		$price_b6_business_2dtotal=$prod->calculateProductAPU("p1642");
		$price_b6_business_3dtotal=$prod->calculateProductAPU("p1643");
		$price_b6_business_details_in=$prod->calculateProductAPU("p1644");
		$price_b6_business_details_out=$prod->calculateProductAPU("p1645");
		$price_b6_business_video=$prod->calculateProductAPU("p1647");
        $price_b6_business_360=$prod->calculateProductAPU("p1646");
        $price_b6_business_vr=$prod->calculateProductAPU("p1648");

        $price_b6_ex_house_model=$prod->calculateProductAPU("p1661");
		$price_b6_ex_house_plot_combination=$prod->calculateProductAPU("p1662");
		$price_b6_ex_house_3D=$prod->calculateProductAPU("p1663");
        $price_b6_ex_360=$prod->calculateProductAPU("p1666");
        $price_b6_ex_video_standard_environment=$prod->calculateProductAPU("p1667");
        $price_b6_ex_vr=$prod->calculateProductAPU("p1668");

		$price_b6_ex_plot_model=$prod->calculateProductAPU("p1681");
		$price_b6_ex_plot_2D=$prod->calculateProductAPU("p1682");
        $price_b6_ex_plot_3D=$prod->calculateProductAPU("p1683");
        
		$price_b7_uf_model=$prod->calculateProductAPU("p1701");
		$price_b7_uf_2dtotal=$prod->calculateProductAPU("p1702");
		$price_b7_uf_3dtotal=$prod->calculateProductAPU("p1703");
		$price_b7_uf_details_in=$prod->calculateProductAPU("p1704");
		$price_b7_uf_details_out=$prod->calculateProductAPU("p1705");
		$price_b7_uf_video=$prod->calculateProductAPU("p1707");
		$price_b7_uf_360=$prod->calculateProductAPU("p1706");
        $price_b7_uf_vr=$prod->calculateProductAPU("p1708");

		$price_b7_liv_layer=$prod->calculateProductAPU("p1721");
		$price_b7_liv_2dtotal=$prod->calculateProductAPU("p1722");
		$price_b7_liv_3dtotal=$prod->calculateProductAPU("p1723");
		$price_b7_liv_details_in=$prod->calculateProductAPU("p1724");
		$price_b7_liv_details_out=$prod->calculateProductAPU("p1725");
		$price_b7_liv_video=$prod->calculateProductAPU("p1727");
		$price_b7_liv_360=$prod->calculateProductAPU("p1726");
        $price_b7_liv_vr=$prod->calculateProductAPU("p1728");

		$price_b7_business_layer=$prod->calculateProductAPU("p1741");
		$price_b7_business_2dtotal=$prod->calculateProductAPU("p1742");
		$price_b7_business_3dtotal=$prod->calculateProductAPU("p1743");
		$price_b7_business_details_in=$prod->calculateProductAPU("p1744");
		$price_b7_business_details_out=$prod->calculateProductAPU("p1745");
		$price_b7_business_video=$prod->calculateProductAPU("p1747");
        $price_b7_business_360=$prod->calculateProductAPU("p1746");
        $price_b7_business_vr=$prod->calculateProductAPU("p1748");

        $price_b7_ex_house_model=$prod->calculateProductAPU("p1761");
		$price_b7_ex_house_plot_combination=$prod->calculateProductAPU("p1762");
		$price_b7_ex_house_3D=$prod->calculateProductAPU("p1763");
        $price_b7_ex_360=$prod->calculateProductAPU("p1766");
        $price_b7_ex_video_standard_environment=$prod->calculateProductAPU("p1767");
        $price_b7_ex_vr=$prod->calculateProductAPU("p1768");

		$price_b7_ex_plot_model=$prod->calculateProductAPU("p1781");
		$price_b7_ex_plot_2D=$prod->calculateProductAPU("p1782");
        $price_b7_ex_plot_3D=$prod->calculateProductAPU("p1783");
        
        $price_b8_uf_model=$prod->calculateProductAPU("p1801");
		$price_b8_uf_2dtotal=$prod->calculateProductAPU("p1802");
		$price_b8_uf_3dtotal=$prod->calculateProductAPU("p1803");
		$price_b8_uf_details_in=$prod->calculateProductAPU("p1804");
		$price_b8_uf_details_out=$prod->calculateProductAPU("p1805");
		$price_b8_uf_video=$prod->calculateProductAPU("p1807");
		$price_b8_uf_360=$prod->calculateProductAPU("p1806");
        $price_b8_uf_vr=$prod->calculateProductAPU("p1808");

		$price_b8_liv_layer=$prod->calculateProductAPU("p1821");
		$price_b8_liv_2dtotal=$prod->calculateProductAPU("p1822");
		$price_b8_liv_3dtotal=$prod->calculateProductAPU("p1823");
		$price_b8_liv_details_in=$prod->calculateProductAPU("p1824");
		$price_b8_liv_details_out=$prod->calculateProductAPU("p1825");
		$price_b8_liv_video=$prod->calculateProductAPU("p1827");
		$price_b8_liv_360=$prod->calculateProductAPU("p1826");
        $price_b8_liv_vr=$prod->calculateProductAPU("p1828");

		$price_b8_business_layer=$prod->calculateProductAPU("p1841");
		$price_b8_business_2dtotal=$prod->calculateProductAPU("p1842");
		$price_b8_business_3dtotal=$prod->calculateProductAPU("p1843");
		$price_b8_business_details_in=$prod->calculateProductAPU("p1844");
		$price_b8_business_details_out=$prod->calculateProductAPU("p1845");
		$price_b8_business_video=$prod->calculateProductAPU("p1847");
        $price_b8_business_360=$prod->calculateProductAPU("p1846");
        $price_b8_business_vr=$prod->calculateProductAPU("p1848");

        $price_b8_ex_house_model=$prod->calculateProductAPU("p1861");
		$price_b8_ex_house_plot_combination=$prod->calculateProductAPU("p1862");
		$price_b8_ex_house_3D=$prod->calculateProductAPU("p1863");
        $price_b8_ex_360=$prod->calculateProductAPU("p1866");
        $price_b8_ex_video_standard_environment=$prod->calculateProductAPU("p1867");
        $price_b8_ex_vr=$prod->calculateProductAPU("p1868");

		$price_b8_ex_plot_model=$prod->calculateProductAPU("p1881");
		$price_b8_ex_plot_2D=$prod->calculateProductAPU("p1882");
		$price_b8_ex_plot_3D=$prod->calculateProductAPU("p1883");
	}
	else
	{
        $price_b3_in_uf_floorplan=$prod->calculateProductPrice($order['ls_id'],"p1301",$cur_factor);
        $price_b3_in_uf_total_2D=$prod->calculateProductPrice($order['ls_id'],"p1302",$cur_factor);

		$price_b3_in_liv_floorplan=$prod->calculateProductPrice($order['ls_id'],"p1321",$cur_factor);	
        $price_b3_in_liv_total_2D=$prod->calculateProductPrice($order['ls_id'],"p1322",$cur_factor);
        
		$price_b5_uf_model=$prod->calculateProductPrice($order['ls_id'],"p1501",$cur_factor);
		$price_b5_uf_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1502",$cur_factor);
		$price_b5_uf_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1503",$cur_factor);
		$price_b5_uf_details_in=$prod->calculateProductPrice($order['ls_id'],"p1504",$cur_factor);
		$price_b5_uf_details_out=$prod->calculateProductPrice($order['ls_id'],"p1505",$cur_factor);
		$price_b5_uf_video=$prod->calculateProductPrice($order['ls_id'],"p1507",$cur_factor);
		$price_b5_uf_360=$prod->calculateProductPrice($order['ls_id'],"p1506",$cur_factor);
        $price_b5_uf_vr=$prod->calculateProductPrice($order['ls_id'],"p1508",$cur_factor);

		$price_b5_liv_layer=$prod->calculateProductPrice($order['ls_id'],"p1521",$cur_factor);
		$price_b5_liv_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1522",$cur_factor);
		$price_b5_liv_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1523",$cur_factor);
		$price_b5_liv_details_in=$prod->calculateProductPrice($order['ls_id'],"p1524",$cur_factor);
		$price_b5_liv_details_out=$prod->calculateProductPrice($order['ls_id'],"p1525",$cur_factor);
		$price_b5_live_video=$prod->calculateProductPrice($order['ls_id'],"p1527",$cur_factor);
		$price_b5_liv_360=$prod->calculateProductPrice($order['ls_id'],"p1526",$cur_factor);
        $price_b5_liv_vr=$prod->calculateProductPrice($order['ls_id'],"p1528",$cur_factor);

		$price_b5_business_layer=$prod->calculateProductPrice($order['ls_id'],"p1541",$cur_factor);
		$price_b5_business_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1542",$cur_factor);
		$price_b5_business_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1543",$cur_factor);
		$price_b5_business_details_in=$prod->calculateProductPrice($order['ls_id'],"p1544",$cur_factor);
		$price_b5_business_details_out=$prod->calculateProductPrice($order['ls_id'],"p1545",$cur_factor);
		$price_b5_business_video=$prod->calculateProductPrice($order['ls_id'],"p1547",$cur_factor);
		$price_b5_business_360=$prod->calculateProductPrice($order['ls_id'],"p1546",$cur_factor);
        $price_b5_in_bussines_vr=$prod->calculateProductPrice($order['ls_id'],"p1548",$cur_factor);
        
		$price_b5_ex_house_model=$prod->calculateProductPrice($order['ls_id'],"p1561",$cur_factor);
		$price_b5_ex_house_plot_combination=$prod->calculateProductPrice($order['ls_id'],"p1562",$cur_factor);
		$price_b5_ex_house_3D=$prod->calculateProductPrice($order['ls_id'],"p1563",$cur_factor);
        $price_b5_ex_360=$prod->calculateProductPrice($order['ls_id'],"p1566",$cur_factor);
        $price_b5_ex_video_standard_environment=$prod->calculateProductPrice($order['ls_id'],"p1567",$cur_factor);
        $price_b5_ex_vr=$prod->calculateProductPrice($order['ls_id'],"p1568",$cur_factor);

		$price_b5_ex_plot_model=$prod->calculateProductPrice($order['ls_id'],"p1581",$cur_factor);
		$price_b5_ex_plot_2D=$prod->calculateProductPrice($order['ls_id'],"p1582",$cur_factor);
		$price_b5_ex_plot_3D=$prod->calculateProductPrice($order['ls_id'],"p1583",$cur_factor);
        
        $price_b6_uf_model=$prod->calculateProductPrice($order['ls_id'],"p1601",$cur_factor);
		$price_b6_uf_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1602",$cur_factor);
		$price_b6_uf_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1603",$cur_factor);
		$price_b6_uf_details_in=$prod->calculateProductPrice($order['ls_id'],"p1604",$cur_factor);
		$price_b6_uf_details_out=$prod->calculateProductPrice($order['ls_id'],"p1605",$cur_factor);
		$price_b6_uf_video=$prod->calculateProductPrice($order['ls_id'],"p1607",$cur_factor);
		$price_b6_uf_360=$prod->calculateProductPrice($order['ls_id'],"p1606",$cur_factor);
        $price_b6_uf_vr=$prod->calculateProductPrice($order['ls_id'],"p1608",$cur_factor);

		$price_b6_liv_layer=$prod->calculateProductPrice($order['ls_id'],"p1621",$cur_factor);
		$price_b6_liv_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1622",$cur_factor);
		$price_b6_liv_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1623",$cur_factor);
		$price_b6_liv_details_in=$prod->calculateProductPrice($order['ls_id'],"p1624",$cur_factor);
		$price_b6_liv_details_out=$prod->calculateProductPrice($order['ls_id'],"p1625",$cur_factor);
		$price_b6_live_video=$prod->calculateProductPrice($order['ls_id'],"p1627",$cur_factor);
		$price_b6_liv_360=$prod->calculateProductPrice($order['ls_id'],"p1626",$cur_factor);
        $price_b6_liv_vr=$prod->calculateProductPrice($order['ls_id'],"p1628",$cur_factor);

		$price_b6_business_layer=$prod->calculateProductPrice($order['ls_id'],"p1641",$cur_factor);
		$price_b6_business_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1642",$cur_factor);
		$price_b6_business_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1643",$cur_factor);
		$price_b6_business_details_in=$prod->calculateProductPrice($order['ls_id'],"p1644",$cur_factor);
		$price_b6_business_details_out=$prod->calculateProductPrice($order['ls_id'],"p1645",$cur_factor);
		$price_b6_business_video=$prod->calculateProductPrice($order['ls_id'],"p1647",$cur_factor);
        $price_b6_business_360=$prod->calculateProductPrice($order['ls_id'],"p1646",$cur_factor);
        $price_b6_business_vr=$prod->calculateProductPrice($order['ls_id'],"p1648",$cur_factor);

        $price_b6_ex_house_model=$prod->calculateProductPrice($order['ls_id'],"p1661",$cur_factor);
		$price_b6_ex_house_plot_combination=$prod->calculateProductPrice($order['ls_id'],"p1662",$cur_factor);
		$price_b6_ex_house_3D=$prod->calculateProductPrice($order['ls_id'],"p1663",$cur_factor);
        $price_b6_ex_360=$prod->calculateProductPrice($order['ls_id'],"p1666",$cur_factor);
        $price_b6_ex_video_standard_environment=$prod->calculateProductPrice($order['ls_id'],"p1667",$cur_factor);
        $price_b6_ex_vr=$prod->calculateProductPrice($order['ls_id'],"p1668",$cur_factor);

		$price_b6_ex_plot_model=$prod->calculateProductPrice($order['ls_id'],"p1681",$cur_factor);
		$price_b6_ex_plot_2D=$prod->calculateProductPrice($order['ls_id'],"p1682",$cur_factor);
        $price_b6_ex_plot_3D=$prod->calculateProductPrice($order['ls_id'],"p1683",$cur_factor);
        
		$price_b7_uf_model=$prod->calculateProductPrice($order['ls_id'],"p1701",$cur_factor);
		$price_b7_uf_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1702",$cur_factor);
		$price_b7_uf_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1703",$cur_factor);
		$price_b7_uf_details_in=$prod->calculateProductPrice($order['ls_id'],"p1704",$cur_factor);
		$price_b7_uf_details_out=$prod->calculateProductPrice($order['ls_id'],"p1705",$cur_factor);
		$price_b7_uf_video=$prod->calculateProductPrice($order['ls_id'],"p1707",$cur_factor);
		$price_b7_uf_360=$prod->calculateProductPrice($order['ls_id'],"p1706",$cur_factor);
        $price_b7_uf_vr=$prod->calculateProductPrice($order['ls_id'],"p1708",$cur_factor);

		$price_b7_liv_layer=$prod->calculateProductPrice($order['ls_id'],"p1721",$cur_factor);
		$price_b7_liv_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1722",$cur_factor);
		$price_b7_liv_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1723",$cur_factor);
		$price_b7_liv_details_in=$prod->calculateProductPrice($order['ls_id'],"p1724",$cur_factor);
		$price_b7_liv_details_out=$prod->calculateProductPrice($order['ls_id'],"p1725",$cur_factor);
		$price_b7_live_video=$prod->calculateProductPrice($order['ls_id'],"p1727",$cur_factor);
		$price_b7_liv_360=$prod->calculateProductPrice($order['ls_id'],"p1726",$cur_factor);
        $price_b7_liv_vr=$prod->calculateProductPrice($order['ls_id'],"p1728",$cur_factor);

		$price_b7_business_layer=$prod->calculateProductPrice($order['ls_id'],"p1741",$cur_factor);
		$price_b7_business_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1742",$cur_factor);
		$price_b7_business_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1743",$cur_factor);
		$price_b7_business_details_in=$prod->calculateProductPrice($order['ls_id'],"p1744",$cur_factor);
		$price_b7_business_details_out=$prod->calculateProductPrice($order['ls_id'],"p1745",$cur_factor);
		$price_b7_business_video=$prod->calculateProductPrice($order['ls_id'],"p1747",$cur_factor);
        $price_b7_business_360=$prod->calculateProductPrice($order['ls_id'],"p1746",$cur_factor);
        $price_b7_business_vr=$prod->calculateProductPrice($order['ls_id'],"p1748",$cur_factor);

        $price_b7_ex_house_model=$prod->calculateProductPrice($order['ls_id'],"p1761",$cur_factor);
		$price_b7_ex_house_plot_combination=$prod->calculateProductPrice($order['ls_id'],"p1762",$cur_factor);
		$price_b7_ex_house_3D=$prod->calculateProductPrice($order['ls_id'],"p1763",$cur_factor);
        $price_b7_ex_360=$prod->calculateProductPrice($order['ls_id'],"p1766",$cur_factor);
        $price_b7_ex_video_standard_environment=$prod->calculateProductPrice($order['ls_id'],"p1767",$cur_factor);
        $price_b7_ex_vr=$prod->calculateProductPrice($order['ls_id'],"p1768",$cur_factor);

		$price_b7_ex_plot_model=$prod->calculateProductPrice($order['ls_id'],"p1781",$cur_factor);
		$price_b7_ex_plot_2D=$prod->calculateProductPrice($order['ls_id'],"p1782",$cur_factor);
        $price_b7_ex_plot_3D=$prod->calculateProductPrice($order['ls_id'],"p1783",$cur_factor);
        
        $price_b8_uf_model=$prod->calculateProductPrice($order['ls_id'],"p1801",$cur_factor);
		$price_b8_uf_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1802",$cur_factor);
		$price_b8_uf_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1803",$cur_factor);
		$price_b8_uf_details_in=$prod->calculateProductPrice($order['ls_id'],"p1804",$cur_factor);
		$price_b8_uf_details_out=$prod->calculateProductPrice($order['ls_id'],"p1805",$cur_factor);
		$price_b8_uf_video=$prod->calculateProductPrice($order['ls_id'],"p1807",$cur_factor);
		$price_b8_uf_360=$prod->calculateProductPrice($order['ls_id'],"p1806",$cur_factor);
        $price_b8_uf_vr=$prod->calculateProductPrice($order['ls_id'],"p1808",$cur_factor);

		$price_b8_liv_layer=$prod->calculateProductPrice($order['ls_id'],"p1821",$cur_factor);
		$price_b8_liv_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1822",$cur_factor);
		$price_b8_liv_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1823",$cur_factor);
		$price_b8_liv_details_in=$prod->calculateProductPrice($order['ls_id'],"p1824",$cur_factor);
		$price_b8_liv_details_out=$prod->calculateProductPrice($order['ls_id'],"p1825",$cur_factor);
		$price_b8_live_video=$prod->calculateProductPrice($order['ls_id'],"p1827",$cur_factor);
		$price_b8_liv_360=$prod->calculateProductPrice($order['ls_id'],"p1826",$cur_factor);
        $price_b8_liv_vr=$prod->calculateProductPrice($order['ls_id'],"p1828",$cur_factor);

		$price_b8_business_layer=$prod->calculateProductPrice($order['ls_id'],"p1841",$cur_factor);
		$price_b8_business_2dtotal=$prod->calculateProductPrice($order['ls_id'],"p1842",$cur_factor);
		$price_b8_business_3dtotal=$prod->calculateProductPrice($order['ls_id'],"p1843",$cur_factor);
		$price_b8_business_details_in=$prod->calculateProductPrice($order['ls_id'],"p1844",$cur_factor);
		$price_b8_business_details_out=$prod->calculateProductPrice($order['ls_id'],"p1845",$cur_factor);
		$price_b8_business_video=$prod->calculateProductPrice($order['ls_id'],"p1847",$cur_factor);
        $price_b8_business_360=$prod->calculateProductPrice($order['ls_id'],"p1846",$cur_factor);
        $price_b8_business_vr=$prod->calculateProductPrice($order['ls_id'],"p1848",$cur_factor);

        $price_b8_ex_house_model=$prod->calculateProductPrice($order['ls_id'],"p1861",$cur_factor);
		$price_b8_ex_house_plot_combination=$prod->calculateProductPrice($order['ls_id'],"p1862",$cur_factor);
		$price_b8_ex_house_3D=$prod->calculateProductPrice($order['ls_id'],"p1863",$cur_factor);
        $price_b8_ex_360=$prod->calculateProductPrice($order['ls_id'],"p1866",$cur_factor);
        $price_b8_ex_video_standard_environment=$prod->calculateProductPrice($order['ls_id'],"p1867",$cur_factor);
        $price_b8_ex_vr=$prod->calculateProductPrice($order['ls_id'],"p1868",$cur_factor);

		$price_b8_ex_plot_model=$prod->calculateProductPrice($order['ls_id'],"p1881",$cur_factor);
		$price_b8_ex_plot_2D=$prod->calculateProductPrice($order['ls_id'],"p1882",$cur_factor);
        $price_b8_ex_plot_3D=$prod->calculateProductPrice($order['ls_id'],"p1883",$cur_factor);
        
	}
}


if(($client['client_credibility']<=3)&&($client['client_credibility']>=0)&&($client['mc_id']==0))
{

	$message.="<br><br>";
	//The total price is:
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0008","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0008","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0008","x-texts2")['text'];
		$message.=$text;
	}

	
	
	$message.="<br><br>";
	
	$message.="<table border=\"0\">";
	$message.="<tr><td>";
    
    if($order['o_special_agreement_price']==0)
    {
        $message.=(!empty($o_desc_in_b3['o_price_in_b3'])?$o_desc_in_b3['o_price_in_b3']:"");
        if(($o_desc_in_b3['o_price_in_b3']!=0)&&($o_desc_in_b5['o_price_in_b5']!=0))
        {
            $message.= " + ";
        }
        $message.=(!empty($o_desc_in_b5['o_price_in_b5'])?$o_desc_in_b5['o_price_in_b5']:"");
        if((($o_desc_in_b5['o_price_in_b5']!=0)&&($o_desc_ex_b5['o_price_ex_b5']!=0))||(($o_desc_in_b3['o_price_in_b3']!=0)&&($o_desc_ex_b5['o_price_ex_b5']!=0)))
        {
            $message.= " + ";
        }
        $message.=(!empty($o_desc_ex_b5['o_price_ex_b5'])?$o_desc_ex_b5['o_price_ex_b5']:"")." = </td>";
        
        $message.="<td>".($o_desc_in_b3['o_price_in_b3'] + $o_desc_in_b5['o_price_in_b5'] + $o_desc_ex_b5['o_price_ex_b5'])." ".$currency."</td></tr>";
    }
    else
    {
        $message.= $order['o_special_agreement_price']." = </td>".$order['o_special_agreement_price']." ".$currency."</td></tr>";
    }
	$vat=$prod->get_vat($seller['a_id']);
    
    $o_special_agreement_price_vat=0;

	$message .="<tr style=\"text-decoration:underline\"><td>";
	
	if(!empty($seller['VAT-tax no.']))
	{
		
		if(($vat['a_eu']=="1")&&($order['payment_way']!=9))
		{
			$message.="<b>";
			//VAT 
			if(isset($language[0]))
			{
				$text=$domenia->get_translation_text($language[0],52,"x-texts")['text'];
				if(!empty($text))
				{
					$message.=$text;
				}
				else
				{
					$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
					$message.=$text;
				}
			}
			else
			{
				$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
				$message.=$text;
			}
            $message.="&nbsp;".$vat['a_vat']."% (".$vat['area']."): </b></td><td>";
            if($order['o_special_agreement_price']==0)
            {
                $message.=(bcdiv(($o_desc_in_b3['o_price_in_b3'] + $o_desc_in_b5['o_price_in_b5'] + $o_desc_in_b6['o_price_in_b6'] + $o_desc_in_b7['o_price_in_b7'] + $o_desc_in_b8['o_price_in_b8'] + $o_desc_ex_b5['o_price_ex_b5'] + $o_desc_ex_b6['o_price_ex_b6'] + $o_desc_ex_b7['o_price_ex_b7'] + $o_desc_ex_b8['o_price_ex_b8'])*$vat['a_vat']/100,1,2))." ".$currency;
            }
            else
            {
                $message.=(bcdiv($order['o_special_agreement_price']*$vat['a_vat']/100,1,2))." ".$currency;
                $o_special_agreement_price_vat=(bcdiv($order['o_special_agreement_price']*$vat['a_vat']/100,1,2));
            }
		}
		else
		{
			if(($seller['a_id']==$client['a_id'])&&($order['payment_way']!=9))
			{
				$message.="<b>";
				//VAT 
				if(isset($language[0]))
				{
					$text=$domenia->get_translation_text($language[0],52,"x-texts")['text'];
					if(!empty($text))
					{
						$message.=$text;
					}
					else
					{
						$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
						$message.=$text;
					}
				}
				else
				{
					$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
					$message.=$text;
				}
                $message.="&nbsp;".$vat['a_vat']."% (".$vat['area']."): </b></td><td>";
                if($order['o_special_agreement_price']==0)
                {
                    $message.=(bcdiv(($o_desc_in_b3['o_price_in_b3'] + $o_desc_in_b5['o_price_in_b5'] + $o_desc_in_b6['o_price_in_b6'] + $o_desc_in_b7['o_price_in_b7'] + $o_desc_in_b8['o_price_in_b8'] + $o_desc_ex_b5['o_price_ex_b5'] + $o_desc_ex_b6['o_price_ex_b6'] + $o_desc_ex_b7['o_price_ex_b7'] + $o_desc_ex_b8['o_price_ex_b8'])*$vat['a_vat']/100,1,2))." ".$currency;
                }
                else
                {
                    $message.=(bcdiv($order['o_special_agreement_price']*$vat['a_vat']/100,1,2))." ".$currency;
                    $o_special_agreement_price_vat=(bcdiv($order['o_special_agreement_price']*$vat['a_vat']/100,1,2));
                }
			}
			else
			{
			$message.="<b>";
			//VAT
			if(isset($language[0]))
			{
				$text=$domenia->get_translation_text($language[0],52,"x-texts")['text'];
				if(!empty($text))
				{
					$message.=$text;
				}
				else
				{
					$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
					$message.=$text;
				}
			}
			else
			{
				$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
				$message.=$text;
			}
			$message.="&nbsp; 0%: </b></td><td>";
			$message.="0 ".$currency."</div>";
			}
		}
	}			
	else
	{
		$message.="<b>";
		//VAT 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],52,"x-texts")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,52,"x-texts")['text'];
			$message.=$text;
		}
		$message.="&nbsp; 0%: </b></td><td>";
		$message.="0 ".$currency."</div>";
	}
	$message.="</td></tr>";		
	$message.="<tr><td>";
	
	$message.="<b>";
	//Sum: 
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0010","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0010","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0010","x-texts2")['text'];
		$message.=$text;
	}
    $message.="</td><td>";
    if($order['o_special_agreement_price']==0)
    {
        $message.=$order['brut_price']." ".$currency."</b></td></tr>";
    }
    else
    {
        $message.=($order['o_special_agreement_price']+$o_special_agreement_price_vat)." ".$currency."</b></td></tr>";
    }
	$message.="</table>";	
	
	if($order['payment_way']!=9)
	{
		$message.="<br>";
	//Please pay that amount asap to our accounts"
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0011","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0011","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0011","x-texts2")['text'];
		$message.=$text;
	}
	
	//$message.="<br><br><b>".$seller['IBAN']."&nbsp;(IBAN) <br>".$seller['Bank_name']."<br> Swift code: ".$seller['BIC_SWIFT']."</b>";
	$message.="<br><br>";
	
	$lic_accounts=$prod->show_licence_account($order['lic_ID']);
	
	for($i=0;$i<count($lic_accounts);$i++)
	{
		$message.="<b>".$lic_accounts[$i]['bank']."<br>";
		
		if(!empty($lic_accounts[$i]['IBAN']))
		{
			$message.=$lic_accounts[$i]['IBAN']."&nbsp;(IBAN) <br>";
			
			if(!empty($lic_accounts[$i]['BIC/SWIFT']))
			{
				$message.="Swift code: ".$lic_accounts[$i]['BIC/SWIFT']."<br>";
			}
		}
		
		if(!empty($lic_accounts[$i]['account']))
		{
			$message.=$lic_accounts[$i]['account']."<br>";
		}
		
		$message.="</b>";
		if((count($lic_accounts)-1)!=$i)
		{
			//or
			if(isset($language[0]))
			{
				$text=$domenia->get_translation_text($language[0],"tm_0035","x-texts2")['text'];
				if(!empty($text))
				{
					$message.="<br>".$text;
				}
				else
				{
					$text=$domenia->get_translation_text(1,"tm_0035","x-texts2")['text'];
					$message.="<br>".$text;
				}
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0035","x-texts2")['text'];
				$message.="<br>".$text;
			}
			
		}
		$message.="<br>";
	}
	
	} //$budget check
}

if(($client['client_credibility']>=4)&&($client['client_credibility']<=6)&&($client['mc_id']==0))
{
	$message.="<br><b>";
	//Sum: 
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0010","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0010","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0010","x-texts2")['text'];
		$message.=$text;
    }
    if($order['o_special_agreement_price']==0)
    {
	    $message.=$order['brut_price']." ".$currency."</b>";
    }
    else
    {
        $message.=($order['o_special_agreement_price']+$o_special_agreement_price_vat)." ".$currency."</b>";
    }
    
	if($order['payment_way']!=9)
	{
	$message.="<br><br>";
	//if you want you may pay now or later to our accounts"
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0014","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0014","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0014","x-texts2")['text'];
		$message.=$text;
	}
	
	$message.="<br><br>";
	
	
	$lic_accounts=$prod->show_licence_account($order['lic_ID']);
	
	for($i=0;$i<count($lic_accounts);$i++)
	{
		$message.="<b>".$lic_accounts[$i]['bank']."<br>";
		
		if(!empty($lic_accounts[$i]['IBAN']))
		{
			$message.=$lic_accounts[$i]['IBAN']."&nbsp;(IBAN) <br>";
			
			if(!empty($lic_accounts[$i]['BIC/SWIFT']))
			{
				$message.="Swift code: ".$lic_accounts[$i]['BIC/SWIFT']."<br><br>";
			}
		}
		
		if(!empty($lic_accounts[$i]['account']))
		{
			$message.=$lic_accounts[$i]['account'];
		}
		
		$message.="</b>";
		if((count($lic_accounts)-1)!=$i)
		{
			//or
			if(isset($language[0]))
			{
				$text=$domenia->get_translation_text($language[0],"tm_0035","x-texts2")['text'];
				if(!empty($text))
				{
					$message.="<br>".$text;
				}
				else
				{
					$text=$domenia->get_translation_text(1,"tm_0035","x-texts2")['text'];
					$message.="<br>".$text;
				}
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0035","x-texts2")['text'];
				$message.="<br>".$text;
			}
			
		}
		$message.="<br>";
	}
	} //budget check
}

if(($client['client_credibility']<=3)&&($client['client_credibility']>=0)&&($client['mc_id']==0))
{	

	if($order['payment_way']!=9)
	{
		$message.="<br>";
	//Fyi:
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0012","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0012","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0012","x-texts2")['text'];
		$message.=$text;
	}
	
	$message.="<br><br>";
	//We will only send you an invoice after you have paid. That is due to tax reasons.
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0019","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0019","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0019","x-texts2")['text'];
		$message.=$text;
	}
	$message.="<br><br>";
	//We will normally not start to work until you have paid.
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0020","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0020","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0020","x-texts2")['text'];
		$message.=$text;
	}
	$message.="<br>";
	//But we are entitled to start with our work before. This might happen if we have some free capacities and no better use of them.
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0021","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0021","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0021","x-texts2")['text'];
		$message.=$text;
	}
	$message.="<br><br>";
	//Even if we work before your payment and even give you access to the results.
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0022","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0022","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0022","x-texts2")['text'];
		$message.=$text;
	}
	$message.="<br>";
	//You get the right to use the product only after you paid !
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0023","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0023","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0023","x-texts2")['text'];
		$message.=$text;
	}
	$message.="<br><br>";
	//Thanks for your trust !
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0024","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0024","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0024","x-texts2")['text'];
		$message.=$text;
	}
	}
}

if($order['payment_way']==9)
{
	$total_budget=$prod->get_o_desc_b0_by_client($order['u_client_ID']);
	$total_client_credits=0;
	for($i=0;$i<count($total_budget);$i++)
	{
		$total_client_credits +=$total_budget[$i]['col_amount_b0'];
	}
	
	$message .="<br>";
	//We deducted 
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0037","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0037","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0037","x-texts2")['text'];
		$message.=$text;
	}
	$message.="&nbsp;".((-1)*$budget['col_amount_b0'])."&nbsp;";
	//credits from your budget.
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0038","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0038","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0038","x-texts2")['text'];
		$message.=$text;
	}
	$message .="<br>";
	//You have
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0039","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0039","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0039","x-texts2")['text'];
		$message.=$text;
	}
	$message .="&nbsp;".$total_client_credits."&nbsp;";
	//credits left.
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0040","x-texts2")['text'];
		if(!empty($text))
		{
			$message.=$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0040","x-texts2")['text'];
			$message.=$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0040","x-texts2")['text'];
		$message.=$text;
	}
}

$message.="<br><b>";
//kind regards
if(isset($language[0]))
{
	$text=$domenia->get_translation_text($language[0],"tm_0033","x-texts2")['text'];
	if(!empty($text))
	{
		$message.=$text;
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0033","x-texts2")['text'];
		$message.=$text;
	}
}
else
{
	$text=$domenia->get_translation_text(1,"tm_0033","x-texts2")['text'];
	$message.=$text;
}
		
$message.="</b><br><br>";
//The team of 
if(isset($language[0]))
{
	$text=$domenia->get_translation_text($language[0],"tm_0025","x-texts2")['text'];
	if(!empty($text))
	{
		$message.=$text;
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0025","x-texts2")['text'];
		$message.=$text;
	}
}
else
{
	$text=$domenia->get_translation_text(1,"tm_0025","x-texts2")['text'];
	$message.=$text;
}
$message.="&nbsp;".$seller['Company'];

//require('../_signature.php');

$message.=$notification->add_signature($order['lic_ID'],$language[0]);

$to=$client['email'];
//$to.=",info@bauvorschau.com";
//$to.=",bauvorschau@immovisualisierung.de,".$seller['Email'];
$to.=",".$seller['Email'];

if(!empty($client['additional_emails']))
{
	$to .=",".$client['additional_emails'];
}

$header='MIME-Version: 1.0' . "\r\n";
$header.='Content-type: text/html; charset=UTF-8' . "\r\n";
$header.="from: ".$seller['mailnick']." <".$seller['Email'].">"."\r\n";
$header.="Reply-To: ".$client['email']."\r\n";

if($order['om_id']==0)
{
	//Order accepted
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tm_0005","x-texts2")['text'];
		if(!empty($text))
		{
			$subject=$o_id." - ".$order['order_name']." - ".$text;
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0005","x-texts2")['text'];
			$subject=$o_id." - ".$order['order_name']." - ".$text;
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tm_0005","x-texts2")['text'];
		$subject=$o_id." - ".$order['order_name']." - ".$text;
	}
}
else
{
	//amendment
	if(isset($language[0]))
	{
		$text=$domenia->get_translation_text($language[0],"tx_1770","x-texts")['text'];
		if(!empty($text))
		{
			$subject=$o_id." - ".html_entity_decode($text,ENT_QUOTES,"UTF-8")." - ".$order['order_name'];
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tx_1770","x-texts")['text'];
			$subject=$o_id." - ".html_entity_decode($text,ENT_QUOTES,"UTF-8")." - ".$order['order_name'];
		}
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tx_1770","x-texts")['text'];
		$subject=$o_id." - ".html_entity_decode($text,ENT_QUOTES,"UTF-8")." - ".$order['order_name'];
	}
}
//echo $message;
mail($to,$subject,$message,$header);

$prod->send_trader_purchaser_message($o_id,$uca_id,$message);
?>
<div class="container">
	<div class="success">Sending accept message to client...</div>
	<meta http-equiv="refresh" content="1; url=index.php?orderstatus=1-9"> 
</div>
<?php
}
?>