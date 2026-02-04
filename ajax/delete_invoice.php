<?php
session_start();
include('../functions.php');

$prod=new Production;

$i_id=$prod->xss_fix($_POST['i_id']);
$lic_id=$prod->xss_fix($_POST['licenceid']);
$deleted=0;
$invoice=$prod->get_invoice_by_invid($lic_id,$i_id);

$file_path="../invoices/".$invoice['i_pdf_path'].$invoice['i_pdf_name'];

if(file_exists($file_path))
{
    unlink($file_path); //deleting pdf file
    $deleted=1;
}

if($deleted==1)
{
    $prod->delete_invoice($lic_id,$i_id); //deleting from db
}
?>