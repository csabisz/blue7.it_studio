<?php

include("../functions.php");

$prod = new Production;

$lt_id=$prod->xss_fix($_GET['lt_id']);

$all_creators = $prod->show_creators($lt_id);

$all_other_creators = $prod->show_creators_other_companies($lt_id);

print_r($all_creators);
?>