<?php

if(isset($_GET['check_invoice_btn']))
{
?>
<meta http-equiv="refresh" content="0; url=check_invoice_template.php?<?php echo http_build_query($_GET); ?>">
<?php
}

session_start();
include('../functions.php');
include('../domenia_db3.php');
include('../notifications.php');
include('../../../../superfloorplans.com/public_html/functions.php');
include('../../../../superfloorplans.com/public_html/price_calculations.php');
include('../../../../cseven.eu/public_html/domenia/domenia.php');

$prod=new Production;
$price=new PriceCalculations;
$domenia3=new Domenia3;
$notification=new Notifications;
$domenia=new Domenia;

$page_title="Books";

include('../header2.php');


if(isset($_POST['create_btn']))
{
    $data['type']=$prod->xss_fix($_POST['type']);
    $data['o_id']=$prod->xss_fix($_POST['o_id']) ?? "0";
    $order=$prod->get_order($data['o_id']);

    if($data['type']=="simple_invoice")
	{
        
        $data['licence_id']=$order['lic_ID'];
        $data['invoice_id']=$prod->xss_fix($_POST['invoice_id']);
    }
    else
    {
        $data['licence_id']=$prod->xss_fix($_POST['licence_id']);
        $data['invoice_id']=$prod->xss_fix($_POST['invoice_id']);
    }
	
    $data['client_id']=$prod->xss_fix($_POST['client_id']) ?? "0"; 
    $data['mc_id']=$prod->xss_fix($_POST['mc_id']) ?? "0";
    
    
    $data['notice_txt']=$prod->xss_fix($_POST['notice_txt']) ?? "";

	$net=$prod->xss_fix($_POST['net'] ?? "0");
	$vat=$prod->xss_fix($_POST['vat'] ?? "0");
	$vat_percent=$prod->xss_fix($_POST['vat_percent'] ?? "0");
	$data['inv_date']=$prod->xss_fix($_POST['invoice_date'] ?? "0000-00-00");

	
    
    $domenia3->create_invoice($data['licence_id'],$data['invoice_id'],$data['o_id'],$data['inv_date'],$data['mc_id'],$data['client_id'],$net,$vat,$vat_percent);
    
	$licence_taker_email=$prod->xss_fix($_POST['licence_taker_email']) ?? "";
	$client_email=$prod->xss_fix($_POST['client_email']) ?? "";
	$licence_taker_name=$prod->xss_fix($_POST['licence_taker_name']) ?? "";
	if($data['type']=="simple_invoice")
	{
		$data['myinvoice']=file_get_contents("temp/invoice_ord".$data['o_id'].".html");
	}
	else
	{
		$data['myinvoice']=file_get_contents("temp/cumulative_invoice.html");
	}

	//$errorMessage=$domenia3->send_invoice_email($type,$licence_id,$o_id,$client_id,$licence_taker_name,$licence_taker_email,$client_email,$myinvoice);
    $domenia3->save_invoice_pdf(json_encode($data));

	
    ?>
    <div class="text-center">				
        <div class="alert alert-success">Invoice created ! </div>
        <meta http-equiv="refresh" content="2; url=invoice.php">	
    </div>
    <?php
	include('../footer.php');
	
}
else //end POST
{
	//echo http_build_query($_GET);
$type=$prod->xss_fix($_GET['type']);
$clientid=$prod->xss_fix($_GET['u_client']);
$mc_id=$prod->xss_fix($_GET['main_client']);

$licenceid=$prod->xss_fix($_GET['licenceid']);
// $licence=$prod->get_licence($licenceid);
// $currency=$prod->get_currency($licence['currencies'])['cur_short'];	

if($type=="cumulative_invoice")
{
	//$mc_id=$prod->xss_fix($_GET['main_client']);
	$invoice_start_date=$prod->xss_fix($_GET['invoice_start_date']);
	$invoice_end_date=$prod->xss_fix($_GET['invoice_end_date']);
    
    if($mc_id!="")
    {
        $cumulative_order=$prod->get_all_cumulative_orders($mc_id,$invoice_start_date,$invoice_end_date);
    }
    else
    {
        $cumulative_order=$prod->get_all_cumulative_orders_simple_client($clientid,$invoice_start_date,$invoice_end_date);
    }
}				

if($cumulative_order[0]['lic_ID']!=$licenceid)
{
    ?>
    <div class="text-danger">Warning ! The selected licence id is different from the orders licence id !</div>
    <?php
}
$licence=$prod->get_licence($cumulative_order[0]['lic_ID']);
$currency=$prod->get_currency($licence['currencies'])['cur_short'];

$o_id=$prod->xss_fix($_GET['o_id']) ?? "0";
$order=$prod->get_order($o_id);

if($type=="simple_invoice")
{
	
    $o_desc_in_b3=$prod->get_o_desc_in_b3($o_id);
    $o_desc_in_b5=$prod->get_o_desc_in_b5($o_id);
    $o_desc_in_b7=$prod->get_o_desc_in_b7($o_id);
    $o_desc_in_b8=$prod->get_o_desc_in_b8($o_id);
    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($o_id);
    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($o_id);
    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($o_id);
	$clientid=$order['u_client_ID'];
	$licenceid=$order['lic_ID'];
}
else
{
	$licenceid=$prod->xss_fix($_GET['licenceid']);
}	

$language=array();
$language=$_GET['language'];

// for($i=0;$i<count($language);$i++)
// {
// 	$language[$i]=$prod->xss_fix($language[$i]);
// }

if($type=="simple_invoice")
{
	$licence_taker=$prod->get_licence_taker($o_id);
}
else
{
	$licence_taker=$prod->get_licence_taker_by_lic_id($licenceid);
}


$invoice="<meta charset=\"utf-8\">";
$invoice.="<body>";
$invoice.="<div class=\"row\">";
$invoice.="<div style=\"position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;float: left;width: 33.333333%;\">";

$licence_taker_main_client=$prod->get_main_client($licence['main_client']);

$invoice.="<img src=\"https://domenia.cseven.eu/".$licence_taker_main_client['mc_logo']."\" alt=\"main_client_logo_missing\">";

$invoice.="<h3>".$licence_taker['Company']."</h3>";				

$invoice.=$licence_taker['leader-title'].": ".$licence_taker['leader-names']."<br>";
$invoice.=$licence_taker['street']." ".$licence_taker['No. or housename']."<br>";
$invoice.=$licence_taker['postcode']." ".$licence_taker['City/town']."<br>";
$invoice.=$prod->get_country($licence_taker['a_id'])['area'];
$invoice.="<br><br>";

$invoice.="<b>";
//Registriert under: 
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],"tx_1730","x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}
$invoice.=$text; 
$invoice.=" </b><br>";

$invoice.=$licence_taker['registration']."<br><br>";

$invoice.="<b>";

//VAT Registration Number: 
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],55,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text; 

$invoice.=" </b><br>";
$invoice.=$licence_taker['VAT-tax no.']."<br>";
$invoice.="<br>";

$invoice.="<b>";

//Tax number: 
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],"tx_1754","x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text; 

$invoice.=" </b><br>";
$invoice.=$licence_taker['tax_number']."<br><br>";
$invoice.="<b>E-mail: </b>";
$invoice.="<br>";
$invoice.=$licence_taker['Email']."<br>";
?>

<?php
$invoice.="</div>";
$invoice.="<div class=\"col-md-6\">";
$invoice.="<h1>";
//Invoice
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],54,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}
$invoice.=$text;

$invoice.="</h1><br>";
			

//To
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],56,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

$invoice.="<br>";
if($type=="simple_invoice")
{
	$client=$prod->get_client($clientid);

    $invoice.="<b>".$client['clientname']."</b><br>";
    if(!empty($client['leaders_status']))
    {
        $invoice.=$client['leaders_status'].": ";
    }			
	$invoice.=$client['l_first_name']." ".$client['l_last_name']."<br>";
	$invoice.=$client['street']." ".$client['no-or-housename']."<br>";
	$invoice.="<b>".$client['postcode']." ".$client['city']."</b><br>";
	$invoice.=$prod->get_country($client['a_id'])['area']."<br><br>";				
}
else
{
	if($mc_id!="")
	{
		$main_client=$prod->get_main_client($mc_id);
		
		$invoice.="<b>".$main_client['clientname']."</b><br>";			
		$invoice.=$main_client['leaders_status'].": ".$main_client['leaders_name']."<br>";
		$invoice.=$main_client['street']." ".$main_client['no-or-housename']."<br>";
		$invoice.="<b>".$main_client['postcode']." ".$main_client['city']."</b><br>";
		$invoice.=$prod->get_country($main_client['a_id'])['area']."<br><br>";
	}
	else
	{
		
		$client=$prod->get_client($clientid);

		$invoice.="<b>".$client['clientname']."</b><br>";
		if(!empty($client['leaders_status']))
		{
			$invoice.=$client['leaders_status'].": ";
		}			
		$invoice.=$client['l_first_name']." ".$client['l_last_name']."<br>";
		$invoice.=$client['street']." ".$client['no-or-housename']."<br>";
		$invoice.="<b>".$client['postcode']." ".$client['city']."</b><br>";
		$invoice.=$prod->get_country($client['a_id'])['area']."<br><br>";
	}
}
?>

<?php
$invoice.="<b>";
//Client ID: 
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],77,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}
$invoice.=$text;
$invoice.=" </b>&nbsp;";

if($type=="simple_invoice")
{
	$invoice.=$client['client_ID'];
}
else
{
    if($mc_id!="")
    {
        $invoice.="mc_10".$mc_id;
    }
    if($clientid!="")
    {
        $invoice.="client_10".$clientid;
    }
}

$invoice.="<br>";

$invoice.="<b>";
//Clients VAT ID: 
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],57,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}
$invoice.=$text;
$invoice.=" </b><br>";

if($type=="simple_invoice")
{
	if(!empty($client['vat-tax-no']))
	{
		$invoice.=$client['vat-tax-no']."<br><br>" ;
	}
	else
	{
		//You have not saved a VAT-ID in our database
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],58,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
		$invoice.="<br><br>";
	}
}
else
{
	if(!empty($main_client['vat-tax-no']))
	{
		$invoice.=$main_client['vat-tax-no']."<br><br>" ;
	}
	else
	{
		//You have not saved a VAT-ID in our database
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],58,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
        $invoice.="<br><br>";
        
	}
}

$invoice.="<b>";
//Invoice no:
$text="";
for($z=0;$z<count($language);$z++)
{	
$text.=$domenia->get_translation_text($language[$z],59,"x-texts")['text'];
if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

$invoice.=" </b><br><input id=\"invoice_id\" name=\"invoice_id\" type=\"text\" class=\"form-control form-control-sm\" style=\"width:15em;\" form=\"create_invoice\" required><br><br>";

$invoice.="<b>";
//Date:
$text="";
for($z=0;$z<count($language);$z++)
{
$text.=$domenia->get_translation_text($language[$z],60,"x-texts")['text'];
if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

$invoice.="	</b>&nbsp;";
//$invoice_date=date("d.m.Y");
$invoice.="<input id=\"invoice_date\" name=\"invoice_date\" type=\"text\" class=\"form-control form-control-sm\" style=\"width:10em;\" form=\"create_invoice\" required>";
//$invoice.=$invoice_date;
$invoice.="<script type=\"text/javascript\">";
$invoice.="$('#invoice_date').datepicker({";
	$invoice.="	changeMonth: true,";
	$invoice.="changeYear: true,";
	$invoice.="dateFormat: \"yy-mm-dd\"";	
	$invoice.="}).datepicker(\"setDate\", new Date());";
	$invoice.="</script>";
?>

<?php
$invoice.="<br><br>";
	
if($type=="simple_invoice")
{
    $invoice.="<b>";
    //Order number:
    $text="";
    for($z=0;$z<count($language);$z++)
    {
    $text.=$domenia->get_translation_text($language[$z],61,"x-texts")['text'];
    if($z<count($language)-1) $text.=" / ";
    }

    $invoice.=$text;

    $invoice.=" </b><br>";

	$invoice.=$order['order_ID']."<br><br>";
}
else
{
    $invoice.="<b>";
    //Order numbers:
    $text="";
    for($z=0;$z<count($language);$z++)
    {
    $text.=$domenia->get_translation_text($language[$z],"tx_1729","x-texts")['text'];
    if($z<count($language)-1) $text.=" / ";
    }

    $invoice.=$text;

    $invoice.=" </b><br>";

	$text="";
    
    // for($z=0;$z<count($language);$z++)
	// {
	// $text.=$domenia->get_translation_text($language[$z],78,"x-texts")['text'];
	// if($z<count($language)-1) $text.=" / ";
    // }
    
    for($z=0;$z<count($language);$z++)
	{
	$text.=$domenia->get_translation_text($language[$z],"tx_1731","x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
    }
    
	$invoice.=$text."<br><br>";
}	





if($type=="simple_invoice")
{
    $invoice.="<b>";
    //Your project name: 
    $text="";
    for($z=0;$z<count($language);$z++)
    {
        $text.=$domenia->get_translation_text($language[$z],62,"x-texts")['text'];
        if($z<count($language)-1) $text.=" / ";
    }
    $invoice.=$text;

    $invoice.=" </b><br>";
    $invoice.=$order['order_name']."<br><br>";
    
    $invoice.="<b>";
    //Your collection contained:
    $text="";
    for($z=0;$z<count($language);$z++)
    {
        $text.=$domenia->get_translation_text($language[$z],63,"x-texts")['text'];
        if($z<count($language)-1) $text.=" / ";
    }

    $invoice.=$text;

    $invoice.=" </b><br>";
$cur_factor=$prod->get_cur_factor($o_id)['cur_fac'];

$price_b3_in_uf_floorplan=$price->calculateProductPrice("p1301",$cur_factor);
$price_b3_in_live_floorplan=$price->calculateProductPrice("p1321",$cur_factor);

$price_uf_model=$price->calculateProductPrice("p1501",$cur_factor);
$price_uf_2dtotal=$price->calculateProductPrice("p1502",$cur_factor);
$price_uf_3dtotal=$price->calculateProductPrice("p1503",$cur_factor);
$price_uf_details_in=$price->calculateProductPrice("p1504",$cur_factor);
$price_uf_details_out=$price->calculateProductPrice("p1505",$cur_factor);
$price_uf_360=$price->calculateProductPrice("p1506",$cur_factor);
$price_uf_video=$price->calculateProductPrice("p1507",$cur_factor);

$price_live_layer=$price->calculateProductPrice("p1521",$cur_factor);
$price_live_2dtotal=$price->calculateProductPrice("p1522",$cur_factor);
$price_live_3dtotal=$price->calculateProductPrice("p1523",$cur_factor);
$price_live_details_in=$price->calculateProductPrice("p1524",$cur_factor);
$price_live_details_out=$price->calculateProductPrice("p1525",$cur_factor);
$price_liv_360=$price->calculateProductPrice("p1526",$cur_factor);
$price_live_video=$price->calculateProductPrice("p1527",$cur_factor);

$price_business_layer=$price->calculateProductPrice("p1541",$cur_factor);
$price_business_2dtotal=$price->calculateProductPrice("p1542",$cur_factor);
$price_business_3dtotal=$price->calculateProductPrice("p1543",$cur_factor);
$price_business_details_in=$price->calculateProductPrice("p1544",$cur_factor);
$price_business_details_out=$price->calculateProductPrice("p1545",$cur_factor);
$price_business_360=$price->calculateProductPrice("p1546",$cur_factor);
$price_business_video=$price->calculateProductPrice("p1547",$cur_factor);

$price_b5_ex_house_model=$price->calculateProductPrice("p1561",$cur_factor);
$price_b5_ex_house_plot_combination=$price->calculateProductPrice("p1562",$cur_factor);
$price_b5_ex_house_3D=$price->calculateProductPrice("p1563",$cur_factor);

$price_b5_ex_plot_model=$price->calculateProductPrice("p1581",$cur_factor);
$price_b5_ex_plot_2D=$price->calculateProductPrice("p1582",$cur_factor);
$price_b5_ex_plot_3D=$price->calculateProductPrice("p1583",$cur_factor);

$price_b7_in_uf_model=$price->calculateProductPrice("p1701",$cur_factor);
$price_b7_in_uf_2dtotal=$price->calculateProductPrice("p1702",$cur_factor);
$price_b7_in_uf_3dtotal=$price->calculateProductPrice("p1703",$cur_factor);
$price_b7_in_uf_details_in=$price->calculateProductPrice("p1704",$cur_factor);
$price_b7_in_uf_details_out=$price->calculateProductPrice("p1705",$cur_factor);
$price_b7_in_uf_360=$price->calculateProductPrice("p1706",$cur_factor);
$price_b7_in_uf_video=$price->calculateProductPrice("p1707",$cur_factor);

$price_b7_in_liv_layer=$price->calculateProductPrice("p1721",$cur_factor);
$price_b7_in_liv_2dtotal=$price->calculateProductPrice("p1722",$cur_factor);
$price_b7_in_liv_3dtotal=$price->calculateProductPrice("p1723",$cur_factor);
$price_b7_in_liv_details_in=$price->calculateProductPrice("p1724",$cur_factor);
$price_b7_in_liv_details_out=$price->calculateProductPrice("p1725",$cur_factor);
$price_b7_in_liv_360=$price->calculateProductPrice("p1726",$cur_factor);
$price_b7_in_liv_video=$price->calculateProductPrice("p1727",$cur_factor);

$price_b7_in_business_layer=$price->calculateProductPrice("p1741",$cur_factor);
$price_b7_in_business_2dtotal=$price->calculateProductPrice("p1742",$cur_factor);
$price_b7_in_business_3dtotal=$price->calculateProductPrice("p1743",$cur_factor);
$price_b7_in_business_details_in=$price->calculateProductPrice("p1744",$cur_factor);
$price_b7_in_business_details_out=$price->calculateProductPrice("p1745",$cur_factor);
$price_b7_in_business_360=$price->calculateProductPrice("p1746",$cur_factor);
$price_b7_in_business_video=$price->calculateProductPrice("p1747",$cur_factor);

$price_b7_ex_house_model=$price->calculateProductPrice("p1761",$cur_factor);
$price_b7_ex_house_plot_combination=$price->calculateProductPrice("p1762",$cur_factor);
$price_b7_ex_house_3D=$price->calculateProductPrice("p1763",$cur_factor);

$price_b7_ex_plot_model=$price->calculateProductPrice("p1781",$cur_factor);
$price_b7_ex_plot_2D=$price->calculateProductPrice("p1782",$cur_factor);
$price_b7_ex_plot_3D=$price->calculateProductPrice("p1783",$cur_factor);

$collection=explode(';',$order['collection']);

//echo $collection[0];
for($i=0;$i<count($collection)-1;$i++)
{
	//$prices=explode("-",$collection[$i]);
	//echo $prices[0];echo $prices[1];
	
	if($collection[$i]=="p1301")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],22,"x-texts")['text'];
	
			if($z<count($language)-1) $text.=" / ";
        }
        
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b3_in_uf_floorplan." ".$currency." - ".$o_desc_in_b3['p1301_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b3['p1301_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1321")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$prod->get_translation_text($language[$z],22)['text'];
			
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b3_in_live_floorplan." ".$currency." - ".$o_desc_in_b3['p1321_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b3['p1321_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1561")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$prod->get_translation_text($language[$z],187)['text'];
			
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b5_ex_house_model." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1562")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],189,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,189,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b5_ex_house_plot_combination." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1563")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],188,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,188,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b5_ex_house_3D." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1581")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],190,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,190,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b5_ex_plot_model." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1582")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],191,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,191,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b5_ex_plot_2D." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1583")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],192,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,192,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b5_ex_plot_3D." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1501")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],22,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_uf_model." ".$currency." - ".$o_desc_in_b5['p1501_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1501_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1502")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],23,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_uf_2dtotal." ".$currency." - ".$o_desc_in_b5['p1502_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1502_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1503")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],24,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_uf_3dtotal." ".$currency." - ".$o_desc_in_b5['p1503_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1503_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1504")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],25,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_uf_details_in." ".$currency." - ".$o_desc_in_b5['p1504_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1504_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1505")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],26,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_uf_details_out." ".$currency." - ".$o_desc_in_b5['p1505_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1505_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1506")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],186,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_uf_360." ".$currency." - ".$o_desc_in_b5['p1506_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1506_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1507")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],27,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_uf_video." ".$currency." - ".$o_desc_in_b5['p1507_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1507_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1521")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],50,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_live_layer." ".$currency." - ".$o_desc_in_b5['p1521_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1521_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1522")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{	
			$text.=$domenia->get_translation_text($language[$z],23,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_live_2dtotal." ".$currency." - ".$o_desc_in_b5['p1522_fac']."<br>";			
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1522_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1523")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{	
			$text.=$domenia->get_translation_text($language[$z],24,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_live_3dtotal." ".$currency." - ".$o_desc_in_b5['p1523_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1523_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1524")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],25,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_live_details_in." ".$currency." - ".$o_desc_in_b5['p1524_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1524_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1525")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],26,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_live_details_out." ".$currency." - ".$o_desc_in_b5['p1525_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1525_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1526")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],186,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_liv_360." ".$currency." - ".$o_desc_in_b5['p1526_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1526_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1527")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],27,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_live_video." ".$currency." - ".$o_desc_in_b5['p1527_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1527_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1541")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],50,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_business_layer." ".$currency." - ".$o_desc_in_b5['p1541_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1541_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1542")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],23,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_business_2dtotal." ".$currency." - ".$o_desc_in_b5['p1542_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1542_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1543")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],24,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_business_3dtotal." ".$currency." - ".$o_desc_in_b5['p1543_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1543_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1544")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],25,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_business_details_in." ".$currency." - ".$o_desc_in_b5['p1544_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1544_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1545")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],26,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_business_details_out." ".$currency." - ".$o_desc_in_b5['p1545_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1545_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1546")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],186,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_business_360." ".$currency." - ".$o_desc_in_b5['p1546_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1546_fac']."<br>";
		}
	}
	
	if($collection[$i]=="p1547")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],27,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_business_video." ".$currency." - ".$o_desc_in_b5['p1547_fac']."<br>";
		}
		else
		{
			$invoice.="- ".$text." - ".$o_desc_in_b5['p1547_fac']."<br>";
		}
    }
    
    //start b7 interior

    if($collection[$i]=="p1701")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],22,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_uf_model." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1702")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],23,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_uf_2dtotal." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1703")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],24,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_uf_3dtotal." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1704")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],25,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_uf_details_in." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1705")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],26,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_uf_details_out." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1706")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],186,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_uf_360." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1707")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],27,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_uf_video." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1721")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],50,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_liv_layer." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1722")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{	
			$text.=$domenia->get_translation_text($language[$z],23,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_liv_2dtotal." ".$currency."<br>";			
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1723")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{	
			$text.=$domenia->get_translation_text($language[$z],24,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_liv_3dtotal." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1724")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],25,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_liv_details_in." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1725")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],26,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_liv_details_out." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1726")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],186,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_liv_360." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1727")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],27,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_liv_video." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1741")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],50,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_business_layer." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1742")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],23,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_business_2dtotal." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1743")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],24,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_business_3dtotal." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1744")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],25,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_business_details_in." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1745")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],26,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_business_details_out." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1746")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],186,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_business_360." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1747")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],27,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_in_business_video." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
    }
    
    //start b7 exterior

    if($collection[$i]=="p1761")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$prod->get_translation_text($language[$z],187)['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,187,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_ex_house_model." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1762")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],189,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,189,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_ex_house_plot_combination." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1763")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],188,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,188,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_ex_house_3D." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1781")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],190,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,190,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_ex_plot_model." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1782")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],191,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,191,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_ex_plot_2D." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
	if($collection[$i]=="p1783")
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],192,"x-texts")['text'];
			/*if(!empty($text))
			{
				$invoice.="- ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,192,"x-texts")['text'];
				$invoice.="- ".$text;
			}*/
			if($z<count($language)-1) $text.=" / ";
		}
		if($order['o_special_agreement_price']==0)
		{
			$invoice.="- ".$text." - ".$price_b7_ex_plot_3D." ".$currency."<br>";
		}
		else
		{
			$invoice.="- ".$text."<br>";
		}
	}
	
}

}
else
{
	// $text="";
	// for($z=0;$z<count($language);$z++)
	// {
	// 	$text.=$domenia->get_translation_text($language[$z],78,"x-texts")['text'];
	// 	if($z<count($language)-1) $text.=" / ";
	// }
	// $invoice .=$text;
}

if($type=="simple_invoice")
{

$invoice.="<br><br>";
$invoice.="<b>";
//Amount of collections/ old plans: 
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],64,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

$invoice.=" </b><br>";

	
	if(!empty($o_desc_in_b3['col_amount_in_b3']))
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],"tm_0030","x-texts2")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		$invoice.=$text."&nbsp;".$o_desc_in_b3['col_amount_in_b3']."<br>";
    }
    if(!empty($o_desc_in_b5['col_amount_in_b5']))
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],"tm_0031","x-texts2")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		$invoice.=$text."&nbsp;".$o_desc_in_b5['col_amount_in_b5']."<br>";
    }
    if(!empty($o_desc_in_b7['col_amount_in_b7']))
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],"tm_0041","x-texts2")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		$invoice.=$text."&nbsp;".$o_desc_in_b7['col_amount_in_b7']."<br>";
	}
	if(!empty($o_desc_ex_b5['col_amount_ex_b5']))
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],"tm_0032","x-texts2")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		$invoice .=$text."&nbsp;".$o_desc_ex_b5['col_amount_ex_b5']."<br>";
    }
    if(!empty($o_desc_ex_b7['col_amount_ex_b7']))
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],"tm_0042","x-texts2")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		$invoice .=$text."&nbsp;".$o_desc_ex_b7['col_amount_ex_b7']."<br>";
	}
	/*if(!empty($order['b5_col_amount']))
	{
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],"tm_0031","x-texts2")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		$invoice.=$text."&nbsp;".$order['b5_col_amount']."<br>";
    }*/
    $invoice.="<br><br>";
}
else
{
	// $text="";
	// for($z=0;$z<count($language);$z++)
	// {
	// $text.=$domenia->get_translation_text($language[$z],78,"x-texts")['text'];
	// if($z<count($language)-1) $text.=" / ";
	// }
	// $invoice.=$text;
}

$invoice.="<b>";
//Net price:
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],65,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

$invoice.=" </b><br>";
$total_price=0;
if($type=="simple_invoice")
{
	if($order['o_special_agreement_price']==0)
	{
		$total_price=$order['o_price']+$o_desc_in_b3['o_price_in_b3']+$o_desc_ex_b5['o_price_ex_b5'];
	}
	else
	{
		$total_price=$order['o_special_agreement_price'];
    }
    
    $total_price2=number_format($total_price, 2, ',', '.');

    $invoice.=$total_price2." ".$currency."<br><br>";
}
else
{
	for($i=0;$i<count($cumulative_order);$i++)
	{
        $total_price +=$cumulative_order[$i]['o_special_agreement_price'];
	}
    
    $total_price2=number_format($total_price, 2, ',', '.');

    $invoice.=$total_price2." ".$currency."<br><br>";
}

?>

<?php
$vat=$prod->get_vat($licence_taker['a_id']);
$main_client_vat=$prod->get_vat($main_client['a_id']);
$vat_value=0;
$vat_percent=0;

if($type=="simple_invoice")
{
	if((!empty($licence_taker['VAT-tax no.']))&&($licence_taker['VAT_collector']=="yes"))
	{
		// if($order['o_special_agreement_price']==0)
		// {
            if($vat['a_eu']=="1")
            {
                $invoice.="<b>";
                //VAT 
                $text="";
                for($z=0;$z<count($language);$z++)
                {
                    $text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
                    if($z<count($language)-1) $text.=" / ";
                }
                
                $invoice.=$text;
                
                $invoice.=" ".$vat['a_vat']." %: </b>";
                $vat_percent=$vat['a_vat'];

               // $vat_value=(bcdiv($total_price * $vat['a_vat']/100,1,2));

                $vat_value=$total_price * $vat['a_vat']/100;

                $vat_value2=number_format($vat_value, 2, ',', '.');

                $invoice.=$vat_value2." ".$currency."<br><br>";
            }
            else
            {
                if($licence_taker['a_id']==$client['a_id'])
                {
                    $invoice.="<b>";
                    //VAT
                    $text="";
                    for($z=0;$z<count($language);$z++)
                    {
                        $text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
                        if($z<count($language)-1) $text.=" / ";
                    }
                    
                    $invoice.=$text;
                    
                    $invoice.=" ".$vat['a_vat']." %: </b>";
                    $vat_percent=$vat['a_vat'];
                    //$vat_value=(bcdiv($total_price * $vat['a_vat']/100,1,2));
                    
                    $vat_value=$total_price * $vat['a_vat']/100;

                    $vat_value2=number_format($vat_value, 2, ',', '.');

                    $invoice.=$vat_value2." ".$currency."<br><br>";
                }
                else
                {
                $invoice.="<b>";
                //VAT 
                $text="";
                for($z=0;$z<count($language);$z++)
                {
                    $text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
                    if($z<count($language)-1) $text.=" / ";
                }
                
                $invoice.=$text;
                
                $invoice.=" ".$vat_percent." %: </b>";

                $vat_value2=number_format($vat_value, 2, ',', '.');

                $invoice.=$vat_value2." ".$currency."<br><br>";
                }
            }
		/*}
		else
		{
			$invoice.="<b>";
			//VAT 
			$text="";
			for($z=0;$z<count($language);$z++)
			{
				$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
				if($z<count($language)-1) $text.=" / ";
			}
			
			$invoice.=$text;
			
			$invoice.=" ".$vat_percent." %: </b>";
			$invoice.=$vat_value." ".$currency."<br><br>";
		} */
	}			
	else
	{
		$invoice.="<b>";
		//VAT
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
		
        $invoice.=" ".$vat_percent." %: </b>";
        
        $vat_value2=number_format($vat_value, 2, ',', '.');

		$invoice.=$vat_value2." ".$currency."<br><br>";
	}
}
else
{
	/*if((!empty($licence_taker['VAT-tax no.']))&&($licence_taker['VAT_collector']=="yes"))
	{
		
		if($vat['a_eu']=="1")
		{
			$invoice.="<b>";
			//VAT 
			$text="";
			for($z=0;$z<count($language);$z++)
			{
				$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
				if($z<count($language)-1) $text.=" / ";
			}
			
			$invoice.=$text;
			
			$invoice.=" ".$vat['a_vat']." %: </b>";
			$vat_percent=$vat['a_vat'];
            //$vat_value=(bcdiv($total_price * $vat['a_vat']/100,1,2));
            
            $vat_value=$total_price * $vat['a_vat']/100;

            $vat_value2=number_format($vat_value, 2, ',', '.');

			$invoice.=$vat_value2." ".$currency."<br><br>";
		}
		else
		{
			if($licence_taker['a_id']==$main_client['a_id'])
			{
				$invoice.="<b>";
				//VAT
				$text="";
				for($z=0;$z<count($language);$z++)
				{
					$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
					if($z<count($language)-1) $text.=" / ";
				}
				
				$invoice.=$text;
				
				$invoice.=" ".$vat['a_vat']." %: </b>";
				$vat_percent=$vat['a_vat'];
                //$vat_value=(bcdiv($total_price * $vat['a_vat']/100,1,2));
                
                $vat_value=$total_price * $vat['a_vat']/100;

                $vat_value2=number_format($vat_value, 2, ',', '.');

				$invoice.=$vat_value2." ".$currency."<br><br>";
			}
			else
			{
				$invoice.="<b>";
				//VAT 
				$text="";
				for($z=0;$z<count($language);$z++)
				{
					$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
					if($z<count($language)-1) $text.=" / ";
				}
				
				$invoice.=$text;
				
				$invoice.=" ".$vat_percent." %: </b>";
				
				$vat_value2=number_format($vat_value, 2, ',', '.');

				$invoice.=$vat_value2." ".$currency."<br><br>";
			}
		}
		
	}			
	else
	{
		$invoice.="<b>";
		//VAT
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
		
        $invoice.=" ".$vat_percent." %: </b>";
        
        $vat_value2=number_format($vat_value, 2, ',', '.');

		$invoice.=$vat_value2." ".$currency."<br><br>";
	}*/
	

	if($licence_taker['a_id']==$main_client['a_id'])
	{
		$invoice.="<b>";
		//VAT
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
		
		$invoice.=" ".$vat['a_vat']." %: </b>";
		$vat_percent=$vat['a_vat'];
		//$vat_value=(bcdiv($total_price * $vat['a_vat']/100,1,2));
		
		$vat_value=$total_price * $vat['a_vat']/100;

		$vat_value2=number_format($vat_value, 2, ',', '.');

		$invoice.=$vat_value2." ".$currency."<br><br>";
	}
	elseif(($licence_taker['a_eu']!=1)&&($main_client['a_eu']!=1)) //no vat
	{
		$invoice.="<b>";
		//VAT
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
		
        $invoice.=" ".$vat_percent." %: </b>";
        
        $vat_value2=number_format($vat_value, 2, ',', '.');

		$invoice.=$vat_value2." ".$currency."<br><br>";
	}
	elseif(!empty($main_client['vat-tax-no'])) //no vat
	{
		$invoice.="<b>";
		//VAT
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
		
        $invoice.=" ".$vat_percent." %: </b>";
        
        $vat_value2=number_format($vat_value, 2, ',', '.');

		$invoice.=$vat_value2." ".$currency."<br><br>";
	}
	else
	{
		$invoice.="<b>";
		//VAT
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text.=$domenia->get_translation_text($language[$z],52,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		}
		
		$invoice.=$text;
		
		$invoice.=" ".$vat['a_vat']." %: </b>";
		$vat_percent=$vat['a_vat'];
		//$vat_value=(bcdiv($total_price * $vat['a_vat']/100,1,2));
		
		$vat_value=$total_price * $vat['a_vat']/100;

		$vat_value2=number_format($vat_value, 2, ',', '.');

		$invoice.=$vat_value2." ".$currency."<br><br>";
	}
}
?>

<?php
$invoice.="<span style=\"text-decoration:underline;\">";
//Amount you have to pay (brut price):
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],66,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

if($type=="simple_invoice")
{

	if($order['o_special_agreement_price']==0)
	{
		$invoice.="&nbsp;<b>";
		$brut_price=($total_price + $vat_value);
		
		$brut_price=number_format($brut_price, 2, ',', '.');

		$invoice.=$brut_price." ".$currency."</b></span><br><br>";
	}
	else
	{
		$invoice.="&nbsp;<b>";
		$brut_price=($order['o_special_agreement_price']+$vat_value);

		$brut_price=number_format($brut_price, 2, ',', '.');

		$invoice.=$brut_price." ".$currency."</b></span><br><br>";
	}	

}
else
{
    if($order['o_special_agreement_price']==0)
    {
        $invoice.="&nbsp;<b>";
        
        $brut_price=($total_price + $vat_value);
        
        $brut_price=number_format($brut_price, 2, ',', '.');

        $invoice.=$brut_price." ".$currency."</b></span><br><br>";
    }
    else
    {
        $invoice.="&nbsp;<b>";
        $brut_price=($order['o_special_agreement_price']+$vat_value);

        $brut_price=number_format($brut_price, 2, ',', '.');

        $invoice.=$brut_price." ".$currency."</b></span><br><br>";
    }	
}

$invoice.="<b>";
//Way of Payment/ CARD:
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],67,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

$invoice.="</b>";

$invoice.="<br><br>";

if($type=="simple_invoice")
{

//$order_price=$prod->get_order($o_id);
$bank_accounts=$prod->show_licence_account($licenceid);
$payment_amount=$domenia3->get_payment_amount($o_id);
$total_paid=0;
$rest=0;
for($k=0;$k<count($payment_amount);$k++)
{	
	$total_paid += $payment_amount[$k]['amount'];
}

if($order['o_special_agreement_price']==0)
{
	$rest=$order['brut_price']-$total_paid;
}
else
{
	$rest=$order['o_special_agreement_price']-$total_paid;
}
if($rest>0)
{
	//If payment is done but there is something left:
	//You paid as follows:
	$text="";
	for($z=0;$z<count($language);$z++)
	{
		$text.=$domenia->get_translation_text($language[$z],72,"x-texts")['text'];
		if($z<count($language)-1) $text.=" / ";
	}
	
	$invoice.=$text;
	$invoice.=" <br>";
	
	$invoice.=$total_paid." ".$currency;
	
	$invoice.="<br>";
	for($k=0;$k<count($payment_amount);$k++)
	{
		
		//on
		$text="";
		for($z=0;$z<count($language);$z++)
		{
			$text=$domenia->get_translation_text($language[$z],73,"x-texts")['text'];
			if($z<count($language)-1) $text.=" / ";
		
		
		$invoice.=$text;
		
		$invoice.=" <b>".$payment_amount[$k]['date']."</b>";
		
		//an amount of 
		
			$text=$domenia->get_translation_text($language[$z],74,"x-texts")['text'];
		
		
		$invoice.=$text;
		
		$invoice.="<b>".$payment_amount[$k]['amount']." ".$payment_amount[$k]['currency']."</b>";
		
		//to our account
		
		
			$text.=$domenia->get_translation_text($language[$z],69,"x-texts")['text'];
		
		$invoice.=$text;
		
		$invoice.=" <b>".$payment_amount[$k]['bank_account']."</b>";
		
		//with the reference 
		
			$text.=$domenia->get_translation_text($language[$z],70,"x-texts")['text'];
		
		
		$invoice.=$text;
		
		$invoice.="<b>".$payment_amount[$k]['reference']."</b><br>";
		}
	}
	$invoice.="<br>";
	//Thus you have to pay a rest of 
	$text="";
	for($z=0;$z<count($language);$z++)
	{
		$text.=$domenia->get_translation_text($language[$z],75,"x-texts")['text'];
		if($z<count($language)-1) $text.=" / ";
	}
	
	$invoice.=$text;
	
	$invoice.="<br><b>".$rest." ".$currency."</b><br><br>"; 
	
	//If payment shall be made based on this invoice: Please pay within 7 working days to one of our accounts below:
	$text="";
	for($z=0;$z<count($language);$z++)
	{
		$text=$domenia->get_translation_text($language[$z],76,"x-texts")['text'];
        $invoice.=$text;	
        $invoice.=" <br><br>";
        /*for($k=0;$k<count($bank_accounts);$k++)
        {
            if(empty($bank_accounts[$k]['account']))
            {
                $invoice.="<b>".$bank_accounts[$k]['IBAN']."</b><br>";
            }
            else
            {
                $invoice.="<b>(Paypal) ".$bank_accounts[$k]['account']."</b><br>";
            }
        }*/
        if(!empty($licence_taker['IBAN']))
        {
            $invoice.=$licence_taker['IBAN']." ".$licence_taker['Bank_name'];
        }
        else
        {
            for($k=0;$k<count($bank_accounts);$k++)
            {
                if(empty($bank_accounts[$k]['account']))
                {
                    $invoice.="<b>".$bank_accounts[$k]['IBAN']." ".$bank_accounts[$k]['bank']."</b><br>";
                }
                else
                {
                    $invoice.="<b>(Paypal) ".$bank_accounts[$k]['account']."</b><br>";
                }
            }
        }
        $invoice.=" <br>";
    }
}
else
{
	//If payment is done and there is nothing left:
	//Your payment was done on 
	$text="";
	for($z=0;$z<count($language);$z++)
	{
		$text=$domenia->get_translation_text($language[$z],68,"x-texts")['text'];
		//if($z<count($language)-1) $text.=" / ";
	
	
	$invoice.=$text;
	
	$invoice.=" <b>".$payment_amount[0]['date']."</b> ";
	//to our account 
	
	//for($z=0;$z<count($language);$z++)
	//{
		$text=$domenia->get_translation_text($language[$z],69,"x-texts")['text'];
		//if($z<count($language)-1) $text.=" / ";
	//}
	$invoice.=$text;
	
	$invoice.=" <b>".$payment_amount[0]['bank_account']."</b> ";
	//with the reference 
	$text="";
	//for($z=0;$z<count($language);$z++)
	//{
		$text=$domenia->get_translation_text($language[$z],70,"x-texts")['text'];
		//if($z<count($language)-1) $text.=" / ";
	//}
	
	$invoice.=$text;
	
	$invoice.=" <b>".$payment_amount[0]['reference']."</b><br><br>";
	}
}
}
else
{
    $text="";
	for($z=0;$z<count($language);$z++)
	{
        $text=$domenia->get_translation_text($language[$z],76,"x-texts")['text'];
        //echo "<textarea name=\"notice_txt\" id=\"notice_txt\" cols=\"40\" rows=\"3\" class=\"form-control form-control-sm\" form=\"create_invoice\"></textarea>";	
        $invoice.="<textarea name=\"notice_txt\" id=\"notice_txt\" cols=\"40\" rows=\"3\" class=\"form-control form-control-sm\" form=\"create_invoice\">".$text."</textarea>";	
        $invoice.=" <br><br>";
        /*for($k=0;$k<count($bank_accounts);$k++)
        {
            if(empty($bank_accounts[$k]['account']))
            {
                $invoice.="<b>".$bank_accounts[$k]['IBAN']."</b><br>";
            }
            else
            {
                $invoice.="<b>(Paypal) ".$bank_accounts[$k]['account']."</b><br>";
            }
        }*/
        if(!empty($licence_taker['IBAN']))
        {
            
            $invoice.="<b><i>".$licence_taker['Bank_name']."</i></b><br>";
            $invoice.="<b><i>IBAN: ".$licence_taker['IBAN']."</i></b>";
        }
        else
        {
            for($k=0;$k<count($bank_accounts);$k++)
            {
                if(empty($bank_accounts[$k]['account']))
                {
                    $invoice.="<b>".$bank_accounts[$k]['IBAN']." ".$bank_accounts[$k]['bank']."</b><br>";
                }
                else
                {
                    $invoice.="<b>(Paypal) ".$bank_accounts[$k]['account']."</b><br>";
                }
            }
        }
        $invoice.=" <br>";
    }
}

$invoice.="<br>";
//Kind regards

$invoice.="<b>";
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],71,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$invoice.=$text;

$invoice.="</b><br><br>";
$invoice.=$licence_taker['leader-names'];
?>

<?php
$invoice.="</div>";
$invoice.="</div> <!-- end row -->";

//adding with space
if($type!="simple_invoice")
{
$invoice.="<table border=\"0\">";

$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";
$invoice.="<tr><td>&nbsp;</td></tr>";

$invoice.="</table>";
}

$signature=$notification->add_streif_signature($mc_id,$invoice_start_date,$invoice_end_date,$order['client_language_id']);

file_put_contents("temp/signature.html",$signature);

$invoice2=$invoice.$signature;

if($type=="cumulative_invoice")
{
	require('cumulative_invoice.php');
}

//$invoice2.="</body>";
$invoice2.=$cumulative_orders."</body>";
$invoice.=$cumulative_orders."</body>";

echo $invoice2;



if($type=="simple_invoice")
{
	file_put_contents("temp/invoice_ord".$order['order_ID'].".html",$invoice);
}
else
{
	file_put_contents("temp/cumulative_invoice.html",$invoice);
}

?>		
<form id="create_invoice" name="create_invoice" method="post" action="invoice_template.php">
	<input type="hidden" name="licence_id" value="<?php echo $licenceid; ?>">
	<input type="hidden" name="client_id" value="<?php echo ($clientid!="")?$clientid:"0"; ?>">
    <input type="hidden" name="mc_id" value="<?php echo ($mc_id!="")?$mc_id:""; ?>">
	<input type="hidden" name="o_id" value="<?php echo ($type=="simple_invoice")?$o_id:$o_ids; ?>">

	
	<input type="hidden" name="licence_taker_email" value="<?php echo $licence_taker['Email']; ?>">
	<input type="hidden" name="licence_taker_name" value="<?php echo $licence_taker['mailnick']; ?>">
	<input type="hidden" name="client_email" value="<?php echo ($type=="simple_invoice")?$client['email']:$main_client['email']; ?>">
	<input type="hidden" name="vat" value="<?php echo $vat_value; ?>">
	<input type="hidden" name="vat_percent" value="<?php echo $vat_percent; ?>">
	<input type="hidden" name="net" value="<?php echo $total_price; ?>">
	<input type="hidden" name="type" value="<?php echo $type;?>">
    <br>
	<div class="text-center">
		<button type="submit" name="create_btn" class="btn btn-primary btn-sm">Save and create PDF invoice</button>
	</div>	
</form>
<?php
}
?>