<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$do_not_recreate_jpg_on_file_delete=$prod->xss_fix($_POST['do_not_recreate_jpg_on_file_delete']);

if(!empty($o_id))
{
    $prod->update_do_not_recreate_jpg_on_file_delete($o_id,$do_not_recreate_jpg_on_file_delete);
}
?>