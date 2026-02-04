<?php
$products = json_decode(file_get_contents("http://blue7.it/studio/api/orders.php?o_id=4141"));

print_r($products);

$Url="https://blue7.it/studio/api/orders.php?o_id=4141";

function url_get_contents($Url) 
{
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


$products=json_decode(url_get_contents($Url),true);

print_r($products);
?>