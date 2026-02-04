<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$on_stock=$prod->xss_fix($_POST['on_stock']);

if($on_stock==0)
{
    $prod->update_on_stock($o_id,0);
    $prod->update_materials_order($o_id,0);
}
if($on_stock==1)
{
    $prod->update_on_stock($o_id,1);
    $prod->update_materials_order($o_id,0);
}
if($on_stock==2)
{
    $prod->update_on_stock($o_id,0);
    $prod->update_materials_order($o_id,1);
}


?>