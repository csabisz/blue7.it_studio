<?php
include('../functions.php');
include("../../../../cseven.eu/public_html/domenia/domenia.php");
include('../notifications.php');

$prod = new Production;
$domenia=new Domenia;
$notifications2=new Notifications;

$boss_client_id=$prod->xss_fix($_POST['boss_client_id']);
$client_language=$prod->xss_fix($_POST['client_language']);
$o_id=$prod->xss_fix($_POST['o_id']);
$price=$prod->xss_fix($_POST['price']);
$invoice_explanations=$prod->xss_fix($_POST['invoice_explanations']);

$boss=$prod->get_client($boss_client_id);
$seller=$prod->get_licence_taker($o_id);
$order=$prod->get_order($o_id);
$client=$prod->get_client($order['u_client_ID']);

if(!empty($boss))
{


$header='MIME-Version: 1.0' . "\r\n";
$header.='Content-type: text/html; charset=UTF-8' . "\r\n";
$header.="from: ".$seller['mailnick']." <".$seller['Email'].">"."\r\n";
//$header.="Reply-To: ".$client['email']."\r\n";

$message="<b>";

//hello 
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0001","x-texts2")['text'];
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
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0049","x-texts2")['text'];
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
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0050","x-texts2")['text'];
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
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0051","x-texts2")['text'];
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

if(!empty($invoice_explanations))
{
	$message.="<br><br>";
	//Explanations:   
	if(isset($client_language))
	{
		$text=$domenia->get_translation_text($client_language,"tm_0054","x-texts2")['text'];
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

	$message.="<br>";
	$message.="\"".$invoice_explanations."\"";
	$message.="<br><br>";
}

if(empty($invoice_explanations))
{
	$message.="<br><br>";
}

//The price would be (price excl. VAT) net:  
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0052","x-texts2")['text'];
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


$message.="&nbsp;".$price." EUR";



$message.="<br><br>";
//Shall we do that ?  
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0053","x-texts2")['text'];
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
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0055","x-texts2")['text'];
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
if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tm_0056","x-texts2")['text'];
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

$message.=$notifications2->add_signature($order['lic_ID'],$client_language);

$subject="";

if(isset($client_language))
{
	$text=$domenia->get_translation_text($client_language,"tx_1764","x-texts")['text'];
	if(!empty($text))
	{
		$subject=$o_id." - ".$order['order_name']." - ".$text;
	}
	else
	{
		$text=$domenia->get_translation_text(1,"tx_1764","x-texts")['text'];
		$subject=$o_id." - ".$order['order_name']." - ".$text;
	}
}
else
{
	$text=$domenia->get_translation_text(1,"tx_1764","x-texts")['text'];
	$subject=$o_id." - ".$order['order_name']." - ".$text;
}

$to=$boss['email'].",info@bauvorschau.com";

if($client['mc_id']==1)
{
	$to.=",nina.dornheim@streif.de";
}

mail($to,$subject,$message,$header);

?>
<div class="alert alert-success">
    Message sent !
</div>
<?php
}
else
{
	?>
	<div class="alert alert-danger">
    	Error ! No boss id defined !
	</div>
	<?php
}