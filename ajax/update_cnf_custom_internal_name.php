<?php
include('../functions.php');

$prod=new Production;

$cnf_id=$prod->xss_fix($_POST['cnf_id']);
$cnf_custom_internal_name=$prod->xss_fix($_POST['cnf_custom_internal_name']);

$prod->update_cnf_custom_internal_name($cnf_id,$cnf_custom_internal_name);

?>