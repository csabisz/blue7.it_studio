<?php

include('../functions.php');

$prod=new Production;

$lang_id=$_GET['lang_id'];
$text_id=$_GET['text_id'];

echo $text=$prod->lang_api($text_id,$lang_id);

?>