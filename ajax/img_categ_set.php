<?php
include('../functions.php');
$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);
$img_categ=$prod->xss_fix($_POST['img_categ']);

$prod->update_img_categ($orf_id,$img_categ);

?>