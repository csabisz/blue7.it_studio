<?php

include '../../functions.php';

$prod = new Production;

$data = [
    'client_id' => 'u_' . $_POST['client_id'],
    'roof_type' => isset($_POST['roof_type_check_box']) ? '1' : '0',
    'roof_material' => isset($_POST['roof_material_check_box'])? '1' : '0',
    'roof_tilt' => isset($_POST['roof_tilt_check_box'])? '1' : '0',
    'roof_overstand' => isset($_POST['roof_overstand_check_box'])? '1' : '0',
    'knee_wall' => isset($_POST['knee_wall_check_box'])? '1' : '0',
    'gutters' => isset($_POST['gutters_check_box'])? '1' : '0',
    'walls_material' => isset($_POST['walls_material_check_box'])? '1' : '0',
    'walls_second_material' => isset($_POST['walls_second_material_check_box'])? '1' : '0',
    'windows_material' => isset($_POST['windows_material_check_box'])? '1' : '0',
    'door_material' => isset($_POST['door_material_check_box'])? '1' : '0',
    'door_type' => isset($_POST['door_type_check_box'])? '1' : '0',
];

print '<pre style="text-align:left;">';
print print_r($data);
print '</pre>';



$prod->add_client_order_rights($data);
