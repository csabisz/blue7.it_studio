<?php
include("../functions.php");

$prod=new Production;

$update_client_measures['ucm_id'] = $prod->xss_fix($_POST['ucm_id']);
$update_client_measures['mc_id'] = $prod->xss_fix($_POST['mc_id']);
$update_client_measures['wall_height'] = $prod->xss_fix($_POST['wall_height']);
$update_client_measures['wall_out_thickness'] = $prod->xss_fix($_POST['wall_out_thickness']);
$update_client_measures['wall_in_thickness'] = $prod->xss_fix($_POST['wall_in_thickness']);
$update_client_measures['wall_middle_thickness'] = $prod->xss_fix($_POST['wall_middle_thickness']);
$update_client_measures['windows_top'] = $prod->xss_fix($_POST['windows_top']);
$update_client_measures['in_doors_top'] = $prod->xss_fix($_POST['in_doors_top']);
$update_client_measures['ex_doors_top'] = $prod->xss_fix($_POST['ex_doors_top']);
$update_client_measures['foundation'] = $prod->xss_fix($_POST['foundation']);
$update_client_measures['ceiling'] = $prod->xss_fix($_POST['ceiling']);


if(!empty($update_client_measures['ucm_id']))
{
    $prod->update_client_measures(json_encode($update_client_measures));
    ?>
    <div class="alert alert-success">Saved successfully !</div>
    <?php
}
else
{
    ?>
    <div class="alert alert-danger">Error saving data !</div>
    <?php
}
?>