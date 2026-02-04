<?php

$o_ids="";

$cumulative_orders="<br><br><br>";
$cumulative_orders.="<div style=\"margin:auto;width:200px;font-weight:bold;\">Total: ".$total_price2." ".$currency."</div>";
$cumulative_orders.="<br><br><br>";

$cumulative_orders.="<table style=\"width:700px;margin:auto;\">";
$cumulative_orders.="<tr>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="Liste ID";
$cumulative_orders.="</th>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="Laufende Pakete";
$cumulative_orders.="</th>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="HV";
$cumulative_orders.="</th>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="Position";
$cumulative_orders.="</th>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="Pos. Summe";
$cumulative_orders.="</th>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="Datum";
$cumulative_orders.="</th>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="Einzel-summen";
$cumulative_orders.="</th>";

$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
$cumulative_orders.="Erläuterung";
$cumulative_orders.="</th>";



$cumulative_orders.="</tr>";

$pos_sum="";
/* $cumulative_orders.="<tr>";
$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">&nbsp;</th>";
$cumulative_orders.="<th style=\"border:1px solid #000;padding:5px;\">";
//Net price:
$text="";
for($z=0;$z<count($language);$z++)
{
	$text.=$domenia->get_translation_text($language[$z],65,"x-texts")['text'];
	if($z<count($language)-1) $text.=" / ";
}

$cumulative_orders.=$text."</th>";
$cumulative_orders.="</tr>"; */


	for($i=0;$i<count($cumulative_order);$i++)
	{
		$licence=$prod->get_licence($cumulative_order[$i]['lic_ID']);
		$cur_short=$prod->get_currency($licence['currencies'])['cur_short'];
		
		$client_id=$cumulative_order[$i]['u_client_ID'];
		$client=$prod->get_client($client_id);
		
		// $o_desc_in_b3=$prod->get_o_desc_in_b3($cumulative_order[$i]['order_ID']);
		// $o_desc_ex_b5=$prod->get_o_desc_ex_b5($cumulative_order[$i]['order_ID']);
	
	$cumulative_orders.="<tr>";
		$cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
			//order number
			/* $text="";
			for($z=0;$z<count($language);$z++)
			{
				$text.=$domenia->get_translation_text($language[$z],61,"x-texts")['text'];
				if($z<count($language)-1) $text.=" / ";
			}
			
			$cumulative_orders.=$text; */
            $cumulative_orders.=$cumulative_order[$i]['order_ID'];
            if($cumulative_order[$i]['om_id']!=0)
            {
                $cumulative_orders.="-".$cumulative_order[$i]['om_id'];
            }
			//date
			/* $text="";
			for($z=0;$z<count($language);$z++)
			{
				$text.=$domenia->get_translation_text($language[$z],60,"x-texts")['text'];
				if($z<count($language)-1) $text.=" / ";
			}
            $cumulative_orders.=$text; */
    $cumulative_orders.="</td>";
    
    $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";

            //project name
			/* $text="";
			for($z=0;$z<count($language);$z++)
			{
				$text.=$domenia->get_translation_text($language[$z],62,"x-texts")['text'];
				if($z<count($language)-1) $text.=" / ";
			}
            $cumulative_orders.=$text; */
            $checking_o_prods=$prod->get_o_prods_by_order_id($cumulative_order[$i]['order_ID']);

            

            // for($o=0;$o<count($checking_o_prods);$o++)
            // {
            //     if($checking_o_prods[$o]['om_amendment']==1)
            //     {
            //         $info_text="ÄNDERUNG";
            //     }
            // }

            // if($cumulative_order[$i]['o_extension']==1)
            // {
            //     $cumulative_orders.="EXTENSION";
            // }
            // if($cumulative_order[$i]['o_correction']==1)
            // {
            //     $cumulative_orders.=$info_text;
            // }
            if($cumulative_order[$i]['o_extension']==1)
            {
                $info_text="EXTENSION";
            }
            if($cumulative_order[$i]['o_correction']==1)
            {
                $info_text="KORREKTUR";
            }

            if($cumulative_order[$i]['o_amendment']==1)
            {
                $info_text="ÄNDERUNGSAUFTRAG";
            }

            if($cumulative_order[$i]['om_id']!=0)
            {
                $cumulative_orders.=$cumulative_order[$i]['order_name'];
                $cumulative_orders.="<br>".$info_text;
            }
            else
            {
                $cumulative_orders.="<b>".$cumulative_order[$i]['order_name']."</b>";
            }

    $cumulative_orders.="</td>";
    
    $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
			//by
			/* $text="";
			for($z=0;$z<count($language);$z++)
			{
				$text.=$domenia->get_translation_text($language[$z],80,"x-texts")['text'];
				if($z<count($language)-1) $text.=" / ";
			}
			$cumulative_orders.=$text; */
			
			$cumulative_orders.=$client['c_first_name']." ".$client['c_last_name'];
			
			
    $cumulative_orders.="</td>";

    $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";

			if(!empty($client['specials']))
			{
				//position
				/*$text="";
				for($z=0;$z<count($language);$z++)
				{
					$text.=$domenia->get_translation_text($language[$z],79,"x-texts")['text'];
					if($z<count($language)-1) $text.=" / ";
				}
				$cumulative_orders.=$text; */
                //$cumulative_orders.=$client['specials'];
                $cumulative_orders.=$client['specials'];
            }
    $cumulative_orders.="</td>";

    $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
    $cumulative_orders.="</td>";

    $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
		$cumulative_orders.=$cumulative_order[$i]['o_date']; 
    $cumulative_orders.="</td>";
    
    $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";

		// if($cumulative_order[$i]['o_special_agreement_price']==0)
		// {
		// 	$cumulative_orders.=($cumulative_order[$i]['o_price']+$o_desc_in_b3['o_price_in_b3']+$o_desc_ex_b5['o_price_ex_b5'])." ".$cur_short;
		// }
		// else
		// {
            $temporary_price=number_format($cumulative_order[$i]['o_special_agreement_price'], 2, ',', '.');

            $cumulative_orders.=$temporary_price." ".$cur_short;
            
            $pos_sum.=$cumulative_order[$i]['o_special_agreement_price'].";";
        //}
    $cumulative_orders.="</td>";

    

    $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
    // if($cumulative_order[$i]['om_id']==0)
    // {
		$cumulative_orders.=$cumulative_order[$i]['invoice_explanations']; 
    // }
    // else
    // {
    //     $cumulative_orders.="";
    // }
    $cumulative_orders.="</td>";

   

	$cumulative_orders.="</tr>";
	
    $o_ids .=$cumulative_order[$i]['order_ID'].";";
    
    if(($i>=0)&&($cumulative_order[$i]['specials']!=$cumulative_order[$i+1]['specials']))
    {
        $cumulative_orders.="<tr style=\"border-bottom:3px solid #000;\">";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
		$cumulative_orders.="&nbsp;"; 
        $cumulative_orders.="</td>";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
		$cumulative_orders.="&nbsp;"; 
        $cumulative_orders.="</td>";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
		$cumulative_orders.="&nbsp;"; 
        $cumulative_orders.="</td>";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;color:red;font-weight:bold;\">";
		$cumulative_orders.=$cumulative_order[$i]['specials']; 
        $cumulative_orders.="</td>";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;color:red;font-weight:bold;\">";

        $temp_sum=explode(";",$pos_sum);
        $sum=array_sum($temp_sum);

        $temporary_sum=number_format($sum, 2, ',', '.');

        $cumulative_orders.=$temporary_sum; 
        $pos_sum="";

        $cumulative_orders.="</td>";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
		$cumulative_orders.="&nbsp;"; 
        $cumulative_orders.="</td>";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
		$cumulative_orders.="&nbsp;"; 
        $cumulative_orders.="</td>";

        $cumulative_orders.="<td style=\"border:1px solid #000;padding:5px;\">";
		$cumulative_orders.="&nbsp;"; 
        $cumulative_orders.="</td>";
        
        $cumulative_orders.="</tr>";
    }

	}

$cumulative_orders.="</table>";
?>