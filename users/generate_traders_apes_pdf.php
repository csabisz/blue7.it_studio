<?php
include('../functions.php');
$prod=new Production;

$trader=$prod->xss_fix($_POST['trader']);
$producer=$prod->xss_fix($_POST['producer']);
$traders_start_date=$prod->xss_fix($_POST['traders_start_date']);
$traders_end_date=$prod->xss_fix($_POST['traders_end_date']);
$total_apes=$prod->xss_fix($_POST['total_apes']);
$data=$_POST['html'];

$html2=base64_decode(urldecode($data));


$html = "<html>";
$html .= "<body>";
$html .= "<h2 style=\"text-align:center;\">List of work</h2>";
$html .= "For ".$trader." done by ".$producer." between ".$traders_start_date." and ".$traders_end_date." - amount ".$total_apes." APEs";
$html .= "<br><br>";

$html .=$html2; 

$html .= "<br><b>Total APEs = ".$total_apes."</b>&nbsp;";
                                
$html .= "</body></html>";


//file_put_contents("apus.html",$html);

require_once '../vendor/autoload.php';



$pdf=new \Mpdf\Mpdf();
$pdf->setAutoBottomMargin = 'stretch';
//$pdf->SetHTMLFooter($signature);
$pdf->WriteHTML($html);
$pdf->Output("apus_traders.pdf");
?>