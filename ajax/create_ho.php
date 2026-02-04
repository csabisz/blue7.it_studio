<?php

include("../functions.php");

$prod = new Production;

$house_id = $_GET['house_id'];

$prod->create_ho($house_id);

print "House-set Created";
