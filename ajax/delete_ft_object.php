<?php
include('../functions.php');
$prod = new Production;

$fto_id = $prod->xss_fix($_POST['fto_id']);

$existing_ft_object = $prod->get_ft_object($fto_id);

if(!empty($existing_ft_object['fs_thumbnail']))
{
    if(file_exists("../".$existing_ft_object['fs_thumbnail']))
    {
        unlink("../".$existing_ft_object['fs_thumbnail']); //delete old file
    }
}

$prod->delete_ft_object($fto_id);
?>