<?php
session_start();
include('../../functions.php');

$prod = new Production;

$name = $prod->xss_fix($_POST['name']);
$description = $prod->xss_fix($_POST['description']);
$translation = $prod->xss_fix($_POST['translation']);

$prod->add_ftoc($name, $description, $translation);



?>