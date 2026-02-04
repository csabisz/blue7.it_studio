<?php
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$plot_id=$_POST['plot_id'];

$plot_ids="|";

for($p=0;$p<count($plot_id);$p++)
{
    $plot_ids.=$plot_id[$p];
}
echo $plot_ids;
$prod->update_order_plot_id($o_id,$plot_ids);
?>