<?php
include('../functions.php');
$prod=new Production;

echo $orf_id=$prod->xss_fix($_GET['orf_id']);
echo $pict_number=$prod->xss_fix($_GET['pict_number']);


$prod->update_img_nr($orf_id,$pict_number);

?>