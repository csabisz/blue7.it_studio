<?php

include("../functions.php");

$prod = new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$client_id=$prod->xss_fix($_POST['client_id']);

$prod->assign_all_tasks_to_creator($o_id, $client_id);
?>