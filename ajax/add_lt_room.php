<?php
include('../functions.php');
$prod = new Production;

$new_ft_layout['ltr_name']=$prod->xss_fix($_POST['new_ltr_name']);
$new_ft_layout['ltr_description']=$prod->xss_fix($_POST['new_ltr_description']);
$ft_objects=$_POST['new_ft_object'];
$rk_ids=$_POST['new_rk_ids'];

$new_ft_layout['ft_objects']="";
$new_ft_layout['rk_ids']="";

for($o=0;$o<count($ft_objects);$o++)
{
    if(!empty($ft_objects[$o]))
    {
        $new_ft_layout['ft_objects'] .=$ft_objects[$o].";";
    }
}

for($o=0;$o<count($rk_ids);$o++)
{
    if(!empty($rk_ids[$o]))
    {
        $new_ft_layout['rk_ids'] .=$rk_ids[$o].";";
    }
}

$prod->add_lt_room(json_encode($new_ft_layout));
?>