<?php
include('../functions.php');
$prod=new Production;

$data['o_id']=$prod->xss_fix($_POST['o_id']);
$data['osub_id']=$prod->xss_fix($_POST['osub_id']);
$data['prod_id']=$prod->xss_fix($_POST['prod_id']);
$data['uca_id'] = $prod->xss_fix($_POST['uca_id']);
$data['orf_path_dom'] = $prod->xss_fix($_POST['new_iframe_link']);;
$data['orf_upload_date'] = gmdate("Y-m-d H:i:s");

$order = $prod->get_order($data['o_id']);

$data['om_id'] = $order['om_id'];

if(!empty($data['orf_path_dom']))
{
    $prod->upload_creator_result_file3(json_encode($data));
}
?>