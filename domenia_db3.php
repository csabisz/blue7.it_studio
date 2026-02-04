<?php
class Domenia3
{
	public function dbconnect()
	{
		$dbhost="localhost";
		$dbuser="adminhdd_domenia0";
		$dbpassword="p@MjdhfBSmbXWv68";
		$database="adminhdd_domenia0";

		$mysqli=mysqli_connect($dbhost,$dbuser,$dbpassword,$database) or die("Sorry, Can't connect to database. Try later !");
		mysqli_set_charset($mysqli,'utf8');
		
		return $mysqli;
	}
	
	public function create_invoice($licence_id,$invoice_id,$order_id,$i_date,$mc_id,$client_id,$net,$vat,$vat_percent)
	{
		$mysqli=$this->dbconnect();
        $licence_id=mysqli_real_escape_string($mysqli,$licence_id ?? "0");
        $invoice_id=mysqli_real_escape_string($mysqli,$invoice_id ?? "0");
		$order_id=mysqli_real_escape_string($mysqli,$order_id ?? "");
		$i_date=mysqli_real_escape_string($mysqli,$i_date ?? "0");
        $client_id=mysqli_real_escape_string($mysqli,$client_id ?? "0");
        $mc_id=mysqli_real_escape_string($mysqli,$mc_id ?? "0");
		$net=mysqli_real_escape_string($mysqli,$net ?? "0");
		$vat=mysqli_real_escape_string($mysqli,$vat ?? "0");
		$vat_percent=mysqli_real_escape_string($mysqli,$vat_percent ?? "0");
		
		$create_invoice_sql="insert into `".$licence_id."_i`(`invoice_id`,`o_id`,`i_date`,`mc_id`,`c_id`,`i_net`,`i_vat`,`i_vat_percent`) values('$invoice_id','$order_id','$i_date','$mc_id','$client_id','$net','$vat','$vat_percent')";
		
		$create_invoice_result=mysqli_query($mysqli,$create_invoice_sql) or die(mysqli_error($mysqli));
		
		mysqli_close($mysqli);
		
		if($create_invoice_result)
		{
			return "OK";
		}
		else
		{
			return "ERROR";
		}
	}
	
	public function upload_invoice_pdf($licence_id,$invoice_id,$i_pdf_path,$i_pdf_name)
	{
		$mysqli=$this->dbconnect();
		$licence_id=mysqli_real_escape_string($mysqli,$licence_id ?? "");
		$invoice_id=mysqli_real_escape_string($mysqli,$invoice_id ?? "");
		$i_pdf_path=mysqli_real_escape_string($mysqli,$i_pdf_path ?? "");
		$i_pdf_name=mysqli_real_escape_string($mysqli,$i_pdf_name ?? "");
		
		$stmt=mysqli_prepare($mysqli,"update `".$licence_id."_i` set `i_pdf_path`=?, `i_pdf_name`=? where `i_id`=?");
		mysqli_stmt_bind_param($stmt,"sss",$i_pdf_path,$i_pdf_name,$invoice_id);
		
		mysqli_stmt_execute($stmt);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
	}
    
    public function save_invoice_pdf($data)
    {
        $mysqli=$this->dbconnect();
        $data=json_decode($data);
        
        $type=mysqli_real_escape_string($mysqli,$data->type ?? "");
        $myinvoice=$data->myinvoice;
        $licence_id=mysqli_real_escape_string($mysqli,$data->licence_id ?? "0");
        $order_id=mysqli_real_escape_string($mysqli,$data->o_id ?? "0");
        $client_id=mysqli_real_escape_string($mysqli,$data->client_id ?? "0");        
        $notice_txt=mysqli_real_escape_string($mysqli,$data->notice_txt ?? "");
        $invoice_date=mysqli_real_escape_string($mysqli,$data->inv_date ?? "0000-00-00");

        $invoice=$this->get_last_invoice($licence_id);
        $invoice_id=$invoice['invoice_id'];
        $i_id=$invoice['i_id'];

        $body=str_replace("<input id=\"invoice_id\" name=\"invoice_id\" type=\"text\" class=\"form-control form-control-sm\" style=\"width:15em;\" form=\"create_invoice\" required>",$invoice_id,$myinvoice);
        $body=str_replace("<input id=\"invoice_date\" name=\"invoice_date\" type=\"text\" class=\"form-control form-control-sm\" style=\"width:10em;\" form=\"create_invoice\" required>",$invoice_date,$body);
        
        $body=str_replace("Bitte bezahlen Sie den noch ausstehenden Betrag binnen 7 Werktagen an uns wie folgt:","",$body); 
        $body=str_replace("<textarea name=\"notice_txt\" id=\"notice_txt\" cols=\"40\" rows=\"3\" class=\"form-control form-control-sm\" form=\"create_invoice\">",$notice_txt,$body);
        $body=str_replace("</textarea>","",$body);
        

        $body=str_replace("<body>","<body style=\"font-size:12px;\">",$body);
        
		if($type=="simple_invoice")
		{
			file_put_contents("../books/temp/invoice_ord".$order_id.".html",$body);
		}
		else
		{
			file_put_contents("../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".html",$body);
		}
		//create pdf file
		
		$signature=file_get_contents("temp/signature.html");
		
		require_once '../vendor/autoload.php';                                

        $pdf=new \Mpdf\Mpdf();

        $pdf->setAutoBottomMargin = 'stretch';
        if($type=="simple_invoice")
		{
            $pdf->SetHTMLFooter('{PAGENO}/{nb}');
        }
        else
        {
            $pdf->SetHTMLFooter($signature.' - {PAGENO}/{nb}');
        }
		$pdf->WriteHTML($body);
		if($type=="simple_invoice")
		{
			$pdf->Output("../books/temp/invoice_ord".$order_id.".pdf");
		}
		else
		{
			$pdf->Output("../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".pdf");
		}
		//upload pdf to database
		
		//$pdf_file=addslashes(file_get_contents("../books/temp/invoice_ord".$order_id.".pdf"));
		$invoices_dir = "../invoices/";
		$year=date("Y");
		$output_dir=$invoices_dir.$year."/".$licence_id."/".$i_id;
		$file_path=$year."/".$licence_id."/".$i_id."/";
		
		if(!file_exists($output_dir)) 
		{
			mkdir($output_dir, 0777, true);
		}
		if($type=="simple_invoice")
		{
			$filename2="../books/temp/invoice_ord".$order_id.".pdf";
		}
		else
		{
			$filename2="../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".pdf";
		}
		
		$newfilename = sha1(uniqid(mt_rand(), true)).'.pdf';							
		rename($filename2,$output_dir."/".$newfilename);
		
		$this->upload_invoice_pdf($licence_id,$i_id,$file_path,$newfilename);
		
		
		
		//opening pdf file as binary
		
		/* $attach_pdf_file=fopen($output_dir."/".$newfilename,"r");
		$file_size=filesize($output_dir."/".$newfilename);
		$content=fread($attach_pdf_file,$file_size);
		fclose($attach_pdf_file);
		
		$content=chunk_split(base64_encode($content));
		$filename="invoice".$licence_id."-".$invoice_id.".pdf";
		
		$body=str_replace("<div style=\"position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;float: left;width: 33.333333%;\">","<div>",$body);
		
		$message = "--".$uid."\r\n";
		$message .= "Content-type:text/html; charset=UTF-8\r\n";
		$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$message .= $body."\r\n\r\n";
		$message .= "--".$uid."\r\n";
		$message .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; 
		$message .= "Content-Transfer-Encoding: base64\r\n";
		$message .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$message .= $content."\r\n";
		$message .= "--".$uid."--";
			
		//sending email
		
		$success=mail($to,$subiect,$message,$header);
		if (!$success) {
			$errorMessage = error_get_last()['message'];
		} */
		
		//clearing out temp files
		if($type=="simple_invoice")
		{
			unlink("../books/temp/invoice_ord".$order_id.".html");
		}
		else
		{
			unlink("../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".html");
			unlink("../books/temp/cumulative_invoice.html");
		} 
		
		unlink("../books/temp/signature.html");
		
		//return $errorMessage;	
    }

	public function send_invoice_email($type,$licence_id,$order_id,$client_id,$licence_taker_name,$licence_taker_email,$client_email,$myinvoice)
	{
		$to=$licence_taker_email.",".$client_email;
		//$to=$client_email;
		
		//email headers 
		
		$uid=md5(uniqid(time()));
		
		$header ='MIME-Version: 1.0' . "\r\n";
	    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n";
		$header .="From: ".$licence_taker_name." <".$licence_taker_email.">";
		
		$invoice_id=$this->get_invoice_id($licence_id,$order_id,$client_id)['i_id'];
		$subiect="Invoice NO. ".$invoice_id;
		
		$body=str_replace("(Will be given after submitting this invoice)",$invoice_id,$myinvoice);
		$body=str_replace("<body>","<body style=\"font-size:12px;\">",$body);
		if($type=="simple_invoice")
		{
			file_put_contents("../books/temp/invoice_ord".$order_id.".html",$body);
		}
		else
		{
			file_put_contents("../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".html",$body);
		}
		//create pdf file
		
		$signature=file_get_contents("temp/signature.html");
		
		require('../mpdf/mpdf.php');
		$pdf=new mPDF();
		$pdf->setAutoBottomMargin = 'stretch';
		$pdf->SetHTMLFooter($signature);
		$pdf->WriteHTML($body);
		if($type=="simple_invoice")
		{
			$pdf->Output("../books/temp/invoice_ord".$order_id.".pdf");
		}
		else
		{
			$pdf->Output("../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".pdf");
		}
		//upload pdf to database
		
		//$pdf_file=addslashes(file_get_contents("../books/temp/invoice_ord".$order_id.".pdf"));
		$invoices_dir = "../invoices/";
		$year=date("Y");
		$output_dir=$invoices_dir.$year."/".$licence_id."/".$invoice_id;
		$file_path=$year."/".$licence_id."/".$invoice_id."/";
		
		if(!file_exists($output_dir)) 
		{
			mkdir($output_dir, 0777, true);
		}
		if($type=="simple_invoice")
		{
			$filename2="../books/temp/invoice_ord".$order_id.".pdf";
		}
		else
		{
			$filename2="../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".pdf";
		}
		
		$newfilename = sha1(uniqid(mt_rand(), true)).'.pdf';							
		rename($filename2,$output_dir."/".$newfilename);
		
		$this->upload_invoice_pdf($licence_id,$invoice_id,$file_path,$newfilename);
		
		
		
		//opening pdf file as binary
		
		$attach_pdf_file=fopen($output_dir."/".$newfilename,"r");
		$file_size=filesize($output_dir."/".$newfilename);
		$content=fread($attach_pdf_file,$file_size);
		fclose($attach_pdf_file);
		
		$content=chunk_split(base64_encode($content));
		$filename="invoice".$licence_id."-".$invoice_id.".pdf";
		
		$body=str_replace("<div style=\"position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;float: left;width: 33.333333%;\">","<div>",$body);
		
		$message = "--".$uid."\r\n";
		$message .= "Content-type:text/html; charset=UTF-8\r\n";
		$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$message .= $body."\r\n\r\n";
		$message .= "--".$uid."\r\n";
		$message .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; 
		$message .= "Content-Transfer-Encoding: base64\r\n";
		$message .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$message .= $content."\r\n";
		$message .= "--".$uid."--";
			
		//sending email
		
		$success=mail($to,$subiect,$message,$header);
		if (!$success) {
			$errorMessage = error_get_last()['message'];
		}
		
		//clearing out temp files
		if($type=="simple_invoice")
		{
			unlink("../books/temp/invoice_ord".$order_id.".html");
		}
		else
		{
			unlink("../books/temp/cumulative_invoice".$licence_id."-".$invoice_id.".html");
			unlink("../books/temp/cumulative_invoice.html");
		}
		
		unlink("../books/temp/signature.html");
		
		return $errorMessage;				
	}
	
	public function get_invoice_id($licence_id,$order_id,$client_id)
	{
		$mysqli=$this->dbconnect();
		$get_invoice_id="select * from `".$licence_id."_i` where `o_id`='$order_id' and `c_id`='$client_id'";
		$get_invoice_result=mysqli_query($mysqli,$get_invoice_id) or die(mysqli_error($mysqli));
		$row=mysqli_fetch_array($get_invoice_result,MYSQLI_ASSOC);
		
		mysqli_close($mysqli);
		
		return $row;
	}
    
    public function get_last_invoice($licence_id)
	{
		$mysqli=$this->dbconnect();
		$get_invoice_id="select * from `".$licence_id."_i` order by `i_id` desc limit 0,1";
		$get_invoice_result=mysqli_query($mysqli,$get_invoice_id) or die(mysqli_error($mysqli));
		$row=mysqli_fetch_array($get_invoice_result,MYSQLI_ASSOC);
		
		mysqli_close($mysqli);
		
		return $row;
    }
    
	public function show_invoices($licence_id)
	{
		$mysqli=$this->dbconnect();
		$show_invoices_sql="select * from `".$licence_id."_i` order by `i_date` desc";
		$show_invoices_result=mysqli_query($mysqli,$show_invoices_sql) or die(mysqli_error($mysqli));
		$rows=array();
		
		while($row=mysqli_fetch_array($show_invoices_result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		mysqli_close($mysqli);
		
		return $rows;
	}
	
	public function show_payments()
	{
		$mysqli=$this->dbconnect();
		$show_payments_sql="select * from `payments` order by `pay_id` desc";
		$show_payments_result=mysqli_query($mysqli,$show_payments_sql) or die(mysqli_error($mysqli));
		$rows=array();
		
		while($row=mysqli_fetch_array($show_payments_result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		mysqli_close($mysqli);
		
		return $rows;
	}
	
	public function show_payment($payment_id)
	{
		$mysqli=$this->dbconnect();
		$payment_id=mysqli_real_escape_string($mysqli,$payment_id);
		$show_payment_sql="select * from `payments` where `pay_id`='$payment_id'";
		$show_payment_result=mysqli_query($mysqli,$show_payment_sql) or die(mysqli_error($mysqli));
		$row=mysqli_fetch_array($show_payment_result,MYSQLI_ASSOC);
		
		mysqli_close($mysqli);
		
		return $row;
	}
    
    public function delete_payment($payment_id)
	{
        $mysqli=$this->dbconnect();
        
        $payment_id=mysqli_real_escape_string($mysqli,$payment_id);
        
        $show_payment_sql="delete from `payments` where `pay_id`='$payment_id'";
        
        $show_payment_result=mysqli_query($mysqli,$show_payment_sql) or die(mysqli_error($mysqli));
		
		mysqli_close($mysqli);

    }
    
	public function update_payment($payid,$orderid,$payment_date,$payment_amount,$currency,$payer,$bank_account,$reference)
	{
		$mysqli=$this->dbconnect();
		$update_payment_sql="update `payments` set `o_id`='$orderid',`date`='$payment_date', `amount`='$payment_amount', `currency`='$currency',`payer`='$payer', `bank_account`='$bank_account', `reference`='$reference' where `pay_id`='$payid'";
		$update_payment_result=mysqli_query($mysqli,$update_payment_sql) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);
	}
	
	public function create_payment($order_id,$payment_date,$payment_amount,$currency,$payer,$bank_account,$reference)
	{
		$mysqli=$this->dbconnect();
		$create_payment_sql="insert into `payments`(`date`,`o_id`,`amount`,`currency`,`payer`,`bank_account`,`reference`) values('$payment_date','$order_id','$payment_amount','$currency','$payer','$bank_account','$reference')";
		$create_payment_result=mysqli_query($mysqli,$create_payment_sql) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);
	}
	
	public function get_payment_amount($orderid)
	{
		$mysqli=$this->dbconnect();
		$get_payment_amount_sql="select * from `payments` where `o_id`='$orderid'";
		$get_payment_amount_result=mysqli_query($mysqli,$get_payment_amount_sql) or die(mysqli_error($mysql));
		$rows=array();
		
		while($row=mysqli_fetch_array($get_payment_amount_result,MYSQLI_BOTH))
		{
			$rows[]=$row;
		}
		mysqli_close($mysqli);
		
		return $rows;
	}
	
	public function get_invoice_by_invid($lic_id,$i_id)
	{
		$mysqli=$this->dbconnect();
		$lic_id=mysqli_real_escape_string($mysqli,$lic_id);
		$i_id=mysqli_real_escape_string($mysqli,$i_id);
		
		$get_invoice_sql="select * from `".$lic_id."_i` where `i_id`='$i_id'";
		$get_invoice_result=mysqli_query($mysqli,$get_invoice_sql) or die(mysqli_error($mysqli));
		$row=mysqli_fetch_array($get_invoice_result,MYSQLI_BOTH);
		
		mysqli_close($mysqli);
		
		return $row;
	}
	
	function get_invoice_client_id($licence_id,$order_id,$client_id)
	{
		$mysqli=$this->dbconnect();
		$licence_id=mysqli_real_escape_string($mysqli,$licence_id);
		$order_id=mysqli_real_escape_string($mysqli,$order_id);
		$client_id=mysqli_real_escape_string($mysqli,$client_id);
		
		$stmt=mysqli_prepare($mysqli,"select * from `".$licence_id."_i` where `o_id`=? and `c_id`=?");
		mysqli_stmt_bind_param($stmt,"ii",$order_id,$client_id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
	}
}
?>