<?php
include('../functions.php');
$prod = new Production;

$edit_lt_room['ltr_id']=$prod->xss_fix($_POST['edit_ltr_id']);
$edit_lt_room['ltr_name']=$prod->xss_fix($_POST['edit_ltr_name']);
$edit_lt_room['ltr_description']=$prod->xss_fix($_POST['edit_ltr_description']);
$ft_objects=$_POST['edit_ft_object'];
$rk_ids=$_POST['edit_rk_ids'];

$edit_lt_room['ft_objects']="";
$edit_lt_room['rk_ids']="";

for($o=0;$o<count($ft_objects);$o++)
{
    if(!empty($ft_objects[$o]))
    {
        $edit_lt_room['ft_objects'] .=$ft_objects[$o].";";
    }
}

for($o=0;$o<count($rk_ids);$o++)
{
    if(!empty($rk_ids[$o]))
    {
        $edit_lt_room['rk_ids'] .=$rk_ids[$o].";";
    }
}

$prod->edit_lt_room(json_encode($edit_lt_room));
?>