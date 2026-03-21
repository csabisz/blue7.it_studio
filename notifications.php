<?php
class Notifications
{
	public function add_signature($licenceid,$selected_lang)
	{
		
		$prod=new Production;
		
		$domenia=new Domenia;
		
		$licence=$prod->get_licence($licenceid);

		//$licence_taker=$prod->get_licence_taker($orderid);
		$licence_taker=$prod->get_company($licence['licence-taker']);

		$signature="<br><br>";
		$signature.="<hr>";
		$signature.="<b>".$licence_taker['Company']."</b>"."<br>";
		$signature.=$licence_taker['leader-title'].": ".$licence_taker['leader-names']."<br>";
		$signature.=$licence_taker['street']." ".$licence_taker['No. or housename']."<br>";
		$signature.=$licence_taker['postcode']." ".$licence_taker['City/town']."<br>";
		
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,$licence_taker['text_id'],"x-texts")['text'];
			if(!empty($text))
			{
				$signature.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,$licence_taker['text_id'],"x-texts")['text'];
				$signature.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,$licence_taker['text_id'],"x-texts")['text'];
			$signature.=$text;
		}
		
		$signature.="<br>";
		
		

        if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"55","x-texts")['text'];
			if(!empty($text))
			{
				$signature.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"55","x-texts")['text'];
				$signature.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"55","x-texts")['text'];
			$signature.=$text;
		}
        
        $signature.=" ".$licence_taker['VAT-tax no.']."<br>";

        if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tx_1719","x-texts")['text'];
			if(!empty($text))
			{
				$signature.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tx_1719","x-texts")['text'];
				$signature.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tx_1719","x-texts")['text'];
			$signature.=$text;
        }
        
        $signature.=" ".$licence_taker['registration']."<br>";
		$signature.=$licence_taker['phone']."<br>";
		$signature.="<a style='color: black !important'>".$licence_taker['Email']."</a>"."<br>";
		$signature.="<b><a style='color: black !important;'>".$licence_taker['Homepage']."</a></b>";
		
		return $signature;
	}
    
    public function add_streif_signature($mc_id,$start_date,$end_date,$selected_lang)
	{
		$prod=new Production;
		
        $main_client=$prod->get_main_client($mc_id);

		$signature="<br>";
		$signature.="<hr>";
		$signature.=$main_client['clientname']." - ".$start_date." - ".$end_date;
		
		return $signature;
    }
    
	public function send_streif2_order_confirmation($o_id,$selected_lang)
	{
		$prod=new Production;
		$domenia=new Domenia;
		
		$order=$prod->get_order($o_id);

		$clientid=$order['u_client_ID'];
		$client=$prod->get_client($clientid);
		$licence=$prod->get_licence($order['lic_ID']);
		$currency=$prod->get_currency($licence['currencies'])['cur_short'];
		$seller=$prod->get_licence_taker($o_id);
		
		$message="<b>";
		//Dear or Hello
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0001","x-texts2")['text'];
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
		//Your order is sent. 
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tx_0003","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tx_0003","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tx_0003","x-texts2")['text'];
			$message.=$text;
		}
		
		$message.="<br>";
		//We will check whether it is done properly and you will soon get either an acceptance or some request or directly a message that the order is done.";
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0002","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0002","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0002","x-texts2")['text'];
			$message.=$text;
		}
		
		$message.="<br><br><b>";
		//Order ID 
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"61","x-texts")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"61","x-texts")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"61","x-texts")['text'];
			$message.=$text;
		}
		
		$message.="&nbsp;".$o_id."</b>, ";
		//done on 
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0003","x-texts2")['text'];
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
		
		if(!empty($seller['timezone']))
		{
			$tz = new DateTimeZone($seller['timezone']);
		}
		else
		{
			$tz = new DateTimeZone('Europe/Berlin');
		}

		$this_year_october=date("Y-m-d", strtotime("last saturday of october"));
  		$this_year_march=date("Y-m-d", strtotime("last saturday of march"));

		$date = new \DateTime($order['o_date']);
		$date->setTimezone($tz);
		if(($order['o_date']<$this_year_october)&&($order['o_date']>$this_year_march))
		{
			$date->modify('+ 1 hour');
		}
		$new_date=$date->format('Y-m-d H:i:s');

		$message.="&nbsp;<b>".$new_date."</b>,";
		$message.="<br><br><b>";
		//Projectname:
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"62","x-texts")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"62","x-texts")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"62","x-texts")['text'];
			$message.=$text;
		}
		
		$message.="</b> ".$order['order_name'];
		
		$message.="<br><br><b>";
		//kind regards
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0033","x-texts2")['text'];
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
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0025","x-texts2")['text'];
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
	
		$signature=$this->add_signature($order['lic_ID'],$selected_lang);
		$message.=$signature;

		$to=$client['email'];
		//$to.=",bauvorschau@immovisualisierung.de,".$seller['Email'];
		$to.=",".$seller['Email'];

        $header='MIME-Version: 1.0' . "\r\n";
		$header.='Content-type: text/html; charset=UTF-8' . "\r\n";
		$header.="from: ".$seller['mailnick']." <".$seller['Email'].">"."\r\n";
		$header.="Reply-To: ".$client['email']."\r\n";

		//Order confirmation
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0004","x-texts2")['text'];
			if(!empty($text))
			{
				$subject=$o_id." - ".$order['order_name']." - ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0004","x-texts2")['text'];
				$subject=$o_id." - ".$order['order_name']." - ".$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0004","x-texts2")['text'];
			$subject=$o_id." - ".$order['order_name']." - ".$text;
		}

		
		mail($to,$subject,$message,$header);
	}

	//this functions is not used (probably) - in future move notification functions here maybe ?
	public function buy_budget_notification($client_id,$o_id,$selected_lang)
	{
		$prod=new Production;
		$domenia=new Domenia;
		
		$order=$prod->get_order($o_id);
		$budget=$prod->get_o_desc_b0($o_id);
		
		$licence=$prod->get_licence($order['lic_ID']);
		$currency=$prod->get_currency($licence['currencies'])['cur_short'];
		$area=$prod->get_vat($order['vat_a_id']);
		$client=$prod->get_client($client_id);
		$lic_site=$prod->get_order_website($order['ls_id']);
		$seller=$prod->get_licence_taker_by_lic_id($order['lic_ID']);
		
        $message="<b>";
		//Dear
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0001","x-texts2")['text'];
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
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0006","x-texts2")['text'];
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
		$message.="&nbsp;".$lic_site['ls_name']." :";

		$message .="<br><br>";
		
		$message .="<table border=\"0\">";
		
		$message .="<tr>";
		$message .="<td>";
		$message .="Amount of credits";
		$message .="</td>";
		$message .="<td>";
		$message .=$budget['col_amount_b0'];
		$message .="</td>";
		$message .="</tr>";
		
		$message .="<tr>";
		$message .="<td>";
		$message .="Net price";
		$message .="</td>";
		$message .="<td>";
		$message .=$order['o_price']."&nbsp;".$currency;
		$message .="</td>";
		$message .="</tr>";
		
		$message .="<tr>";
		$message .="<td>";
		
		//VAT 
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,52,"x-texts")['text'];
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
		$message .="&nbsp;".$order['vat_percent']." % (".$area['area'].")";
		$message .="</td>";
		$message .="<td>";
		$message .=$order['vat_amount']."&nbsp;".$currency;
		$message .="</td>";
		$message .="</tr>";
		
		$message .="<tr>";
		$message .="<td>";
		//The total price is:
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0008","x-texts2")['text'];
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
		$message .="</td>";
		$message .="<td>";
		$message .=$order['brut_price']."&nbsp;".$currency;
		$message .="</td>";
		$message .="</tr>";
		
		$message .="</table>";
		
		$message .="<br>";
		
		//Please pay that amount asap to our accounts"
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0011","x-texts2")['text'];
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
				if(isset($selected_lang))
				{
					$text=$domenia->get_translation_text($selected_lang,"tm_0035","x-texts2")['text'];
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
	
		$message.="<br><b>";
		//kind regards
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0033","x-texts2")['text'];
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
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0025","x-texts2")['text'];
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
	
		$signature=$this->add_signature($order['lic_ID'],$selected_lang);
		$message.=$signature;

		$to=$client['email'];
		//$to.=",bauvorschau@immovisualisierung.de,".$seller['Email'];
		$to.=",".$seller['Email'];

        $header='MIME-Version: 1.0' . "\r\n";
		$header.='Content-type: text/html; charset=UTF-8' . "\r\n";
		$header.="from: ".$seller['mailnick']." <".$seller['Email'].">"."\r\n";
		$header.="Reply-To: ".$client['email']."\r\n";

		//Order confirmation
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tm_0004","x-texts2")['text'];
			if(!empty($text))
			{
				$subject="Budget - ".$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0004","x-texts2")['text'];
				$subject="Budget - ".$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0004","x-texts2")['text'];
			$subject="Budget - ".$text;
		}

		//echo $message;
		mail($to,$subject,$message,$header);
	}

	//this functions is not used (probably)
    /*public function send_streif2_order_done($o_id)
    {
        echo 'order DONE EMAIL;';
        exit;
        $prod=new Production;

        $order=$prod->get_order($o_id);

        $clientid=$order['u_client_ID'];
        $client=$prod->get_client($clientid);
        $licence=$prod->get_licence($order['lic_ID']);
        $currency=$prod->get_currency($licence['currencies'])['cur_short'];
        $seller=$prod->get_licence_taker($o_id);

        $message ="<br><br><b>Order ID ".$o_id."</b>, done on <b>".$order['o_date']."</b>,";
        $message.="<br><br><b>Projectname:</b> ".$order['order_name'];

        $message="<b>Dear ".$client['l_first_name']." ".$client['l_last_name']."</b>";
        $message.="<br><br>Your order is done!!!.";

        //$signature=$this->add_signature($order['lic_ID']);
        $message.=$signature;

        $to=$client['email'];
		$to.=",info@bauvorschau.com";
		
        $header='MIME-Version: 1.0' . "\r\n";
        $header.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $header.="from: ".$seller['mailnick']." <".$seller['Email'].">";

        $subiect="Order confirmation";

        //echo $message;
        mail($to,$subiect,$message,$header);
    } */
	
	public function send_product_done_message($o_id)
	{
		$prod=new Production;
		include_once('../../../../cseven.eu/public_html/domenia/domenia.php');
		$domenia=new Domenia;
		
		$order=$prod->get_order($o_id);
        $uca_id=$_COOKIE['client_id'];
        
		$clientid=$order['u_client_ID'];
		$client=$prod->get_client($clientid);
		//$currency=$prod->get_currency($o_id)['cur_short'];
		$seller=$prod->get_licence_taker($o_id);
		
		$lic_site=$prod->get_order_website($order['ls_id']);
		$language=array(); //might be more than 1 language ?
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
		//The files to the project 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0026","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0026","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0026","x-texts2")['text'];
			$message.=$text;
		}
		$message.="&nbsp;<b>".$order['order_name']."</b>&nbsp;";
		//are now ready and are available for download under 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0027","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0027","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0027","x-texts2")['text'];
			$message.=$text;
		}
		$message.=" <a href=\"http://".$lic_site['ls_name']."\" target=\"_blank\">".$lic_site['ls_name']."</a>.";
		$message.="<br>";
		$message.="<br>";
		//Link to the automatically generated online presentation: 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0047","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0047","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0047","x-texts2")['text'];
			$message.=$text;
		}
		$message.=" <a href=\"https://bauvorschau.com/".$o_id."\" target=\"_blank\">www.bauvorschau.com/".$o_id."</a>.";
		$message.="<br>";
		$message.="<br>";
		//We hope everything fits. Otherwise we are waiting for corrections.
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0028","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0028","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0028","x-texts2")['text'];
			$message.=$text;
		}
		$message.="<br><br><b>";
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
		$message.="&nbsp;".$seller['Company']."</b>";

		$signature=$this->add_signature($order['lic_ID'],$language[0]);
		$message.=$signature;

		$to=$client['email'];
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

		$subject="";
		//Order 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],61,"x-texts")['text'];
			if(!empty($text))
			{
				$subject.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,61,"x-texts")['text'];
				$subject.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,61,"x-texts")['text'];
			$subject.=$text;
		}
		$subject.=" ".$o_id." - ".$order['order_name']." - ";
		//is finished
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0029","x-texts2")['text'];
			if(!empty($text))
			{
				$subject.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0029","x-texts2")['text'];
				$subject.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0029","x-texts2")['text'];
			$subject.=$text;
		}
		
        //echo $message;
        //echo $to." ".$subject;
        if(@mail($to,$subject,$message,$header))
        {
            echo "Mail Sent Successfully";
            $prod->send_trader_purchaser_message($o_id,$uca_id,$message);
        }
        else
        {
            echo "Mail Not Sent";
        }
	}
	
	public function send_product_done_message_amendment($om_id,$o_id)
	{
		$prod=new Production;
		include_once('../../../../cseven.eu/public_html/domenia/domenia.php');
		$domenia=new Domenia;
		
		$order=$prod->get_order($o_id);
        $uca_id=$_COOKIE['client_id'];
        
		$clientid=$order['u_client_ID'];
		$client=$prod->get_client($clientid);
		//$currency=$prod->get_currency($o_id)['cur_short'];
		$seller=$prod->get_licence_taker($o_id);
		
		$lic_site=$prod->get_order_website($order['ls_id']);
		$language=array(); //might be more than 1 language ?
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
		//The change request files 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tx_1766","x-texts")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tx_1766","x-texts")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tx_1766","x-texts")['text'];
			$message.=$text;
		}
		$message.="&nbsp;".$o_id."&nbsp;";

		//to your project 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tx_1767","x-texts")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tx_1767","x-texts")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tx_1767","x-texts")['text'];
			$message.=$text;
		}

		$message.="&nbsp;<b>".$order['order_name']."</b>&nbsp;";
		$message.="(".$om_id.")&nbsp;";
		//are now ready and are available for download under 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0027","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0027","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0027","x-texts2")['text'];
			$message.=$text;
		}
		$message.=" <a href=\"http://".$lic_site['ls_name']."\" target=\"_blank\">".$lic_site['ls_name']."</a>.";
		$message.="<br>";
		$message.="<br>";
		//Link to the automatically generated online presentation: 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0047","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0047","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0047","x-texts2")['text'];
			$message.=$text;
		}
		$message.=" <a href=\"https://bauvorschau.com/".$om_id."\" target=\"_blank\">www.bauvorschau.com/".$om_id."</a>.";
		$message.="<br>";
		$message.="<br>";
		//We hope everything fits. Otherwise we are waiting for corrections.
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0028","x-texts2")['text'];
			if(!empty($text))
			{
				$message.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0028","x-texts2")['text'];
				$message.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0028","x-texts2")['text'];
			$message.=$text;
		}
		$message.="<br><br><b>";
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
		$message.="&nbsp;".$seller['Company']."</b>";

		$signature=$this->add_signature($order['lic_ID'],$language[0]);
		$message.=$signature;

		$to=$client['email'];
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

		$subject="";
		//Order 
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],61,"x-texts")['text'];
			if(!empty($text))
			{
				$subject.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,61,"x-texts")['text'];
				$subject.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,61,"x-texts")['text'];
			$subject.=$text;
		}
		$subject.=" ".$o_id." - ".$order['order_name']." ";
		//is finished
		if(isset($language[0]))
		{
			$text=$domenia->get_translation_text($language[0],"tm_0029","x-texts2")['text'];
			if(!empty($text))
			{
				$subject.=$text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tm_0029","x-texts2")['text'];
				$subject.=$text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tm_0029","x-texts2")['text'];
			$subject.=$text;
		}
		
        //echo $message;
        //echo $to." ".$subject;
        if(@mail($to,$subject,$message,$header))
        {
            echo "Mail Sent Successfully";
            $prod->send_trader_purchaser_message($o_id,$uca_id,$message);
        }
        else
        {
            echo "Mail Not Sent";
        }
	}

	function send_client_trader_message_notification($data)
	{
		$prod=new Production;
		
		$data=json_decode($data);
		
		$o_id=$data->o_id;
		$clientid=$data->clientid;
		$message=$data->message;
		$selected_lang=$data->selected_lang;
		
		$client=$prod->get_client($clientid);
        $seller=$prod->get_licence_taker($o_id);

		$to=$client['email'];
		//$to.=",bauvorschau@immovisualisierung.de,".$seller['Email'];
		$to.=",".$seller['Email'];

		$header='MIME-Version: 1.0' . "\r\n";
        $header.='Content-type: text/html; charset=UTF-8' . "\r\n";
        if(!empty($client['c_last_name']))
        {
            $header.="from: ".$client['c_last_name']." ".$client['c_first_name']." <".$client['email'].">"."\r\n";
        }
        else
        {
		    $header.="from: ".$client['l_last_name']." ".$client['l_first_name']." <".$client['email'].">"."\r\n";
        }

		$header.="Reply-To: ".$client['email']."\r\n";

		$subject="Client message regarding order ".$o_id;
		
		
		
		//echo $message;
		mail($to,$subject,$message,$header);
	}
	
	function send_client_account_recovery_email($site,$email,$recovery_string)
	{
		$name=$site." Account Recovery";
		$from="noreply@".$site;
		$subject="Account Password Reset";
		$to=$email;
		
		$message="<a href=\"http://".$site."/recover.php?recovery_string=".$recovery_string."\" target=\"_blank\">Click here to reset your password.</a>";
		
		$header='MIME-Version: 1.0' . "\r\n";
		$header.='Content-type: text/html; charset=UTF-8' . "\r\n";
		$header.="from: ".$name." <".$from.">";

		
		$body="<p>".$message."</p>";
		mail($to,$subject,$body,$header);
		
		//return $message_sent;
    }
    
    public function send_trader_purchaser_email($o_id,$message)
    {
        $prod=new Production;

        $o_id=$prod->xss_fix($_GET['o_id']);
        $order=$prod->get_order($o_id);
        
        $clientid=$order['u_client_ID'];
        $client=$prod->get_client($clientid);
        
        $licence_taker=$prod->get_licence_taker($o_id);


        $name=$licence_taker['mailnick'];
		$from=$licence_taker['Email'];;
		$subject="Message about ".$o_id." - ".$order['order_name'];
		$to=$client['email'];
		
		//$message="<a href=\"http://".$site."/recover.php?recovery_string=".$recovery_string."\" target=\"_blank\">Click here to reset your password.</a>";
		
		$header='MIME-Version: 1.0' . "\r\n";
		$header.='Content-type: text/html; charset=UTF-8' . "\r\n";
		$header.="from: ".$name." <".$from.">";

		
        $body="<p>".$message."</p>";

        $signature=$this->add_signature($order['lic_ID'],"1");
        $body.=$signature;
        
		mail($to,$subject,$body,$header);
    }
}
?>