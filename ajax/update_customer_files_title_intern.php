<?php
include("../functions.php");

$prod=new Production;

$of_id=$prod->xss_fix($_POST['of_id']);
$title_intern=$prod->xss_fix($_POST['title_intern']);

$prod->update_customer_files_title_intern($of_id,$title_intern);

?>