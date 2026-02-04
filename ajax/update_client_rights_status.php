<?php
include('../functions.php');

$prod=new Production;

$data['client_id']=$prod->xss_fix($_POST['client_id']);
$data['u_status']=$prod->xss_fix($_POST['u_status']);

$client_rights=$prod->get_client_rights($data['client_id']);

if(count($client_rights)>0)
{
    $prod->update_client_rights_status(json_encode($data));
}
else
{
    $prod->insert_client_rights_status(json_encode($data));
}
?>