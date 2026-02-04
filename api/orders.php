<?php

include('../functions.php');
header('Content-Type: application/json');
$prod = new Production;

$o_id = $prod->xss_fix($_GET["o_id"]);

$order_products = $prod->get_all_products_with_extensions($o_id);
$order_data = $prod->get_order($o_id);

//Defining arrays for sorting products
foreach ($order_products as $product) {
    $o_id = $product['o_id'];
    $prod_id = $product['prod_id'];
    $osub_id = $product['osub_id'];

    (strpos($prod_id, 'p11') !== false && strpos($osub_id, 'g') !== false) ? $result['general']['b1'][$osub_id] = array() : null;

    (strpos($prod_id, 'p11') !== false && strpos($osub_id, 'n') !== false) ? $result['interior']['b1'][$osub_id] = array() : null;
    (strpos($prod_id, 'p11') !== false && strpos($osub_id, 'x') !== false) ? $result['exterior']['b1'][$osub_id] = array() : null;

    (strpos($prod_id, 'p13') !== false && strpos($osub_id, 'n') !== false) ? $result['interior']['b3'][$osub_id] = array() : null;
    (strpos($prod_id, 'p13') !== false && strpos($osub_id, 'x') !== false) ? $result['exterior']['b3'][$osub_id] = array() : null;

    (strpos($prod_id, 'p15') !== false && strpos($osub_id, 'n') !== false) ? $result['interior']['b5'][$osub_id] = array() : null;
    (strpos($prod_id, 'p15') !== false && strpos($osub_id, 'x') !== false) ? $result['exterior']['b5'][$osub_id] = array() : null;

    (strpos($prod_id, 'p16') !== false && strpos($osub_id, 'n') !== false) ? $result['interior']['b6'][$osub_id] = array() : null;
    (strpos($prod_id, 'p16') !== false && strpos($osub_id, 'x') !== false) ? $result['exterior']['b6'][$osub_id] = array() : null;

    (strpos($prod_id, 'p17') !== false && strpos($osub_id, 'n') !== false) ? $result['interior']['b7'][$osub_id] = array() : null;
    (strpos($prod_id, 'p17') !== false && strpos($osub_id, 'x') !== false) ? $result['exterior']['b7'][$osub_id] = array() : null;

    (strpos($prod_id, 'p18') !== false && strpos($osub_id, 'n') !== false) ? $result['interior']['b8'][$osub_id] = array() : null;
    (strpos($prod_id, 'p18') !== false && strpos($osub_id, 'x') !== false) ? $result['exterior']['b8'][$osub_id] = array() : null;


}



foreach ($order_products as $product) {

    $o_id = $product['o_id'];
    $prod_id = $product['prod_id'];
    $osub_id = $product['osub_id'];

    $product['task_class_name'] = $o_id . '_' . $osub_id . '_' . $prod_id;
    $product['task_full_name'] = $o_id . '.' . $osub_id . '.' . $prod_id;

    //General
    $product['prod_name'] = $prod->get_product($prod_id)['prod_name'];
    $product['ost_color'] = $prod->get_status_like($product['p_status'])['ost_color'];
    $product['u_prod_id'] = $order_data['u_prod_id'];


    //Comment
    $activity = $prod->get_product_last_change($o_id, $osub_id, $prod_id);

    $client = $prod->get_client($activity['uca_id']);
    $client_name = (!empty($client['c_last_name'])) ? $client['c_first_name'] . ' ' . $client['c_last_name']:"";

    $product['comment'] = (!empty($activity)) ? $client_name . ' ' . $activity['description'] . ' on ' . $activity['date'] : null;

    //Customer Files
    $product['customer_files'] = '';
    foreach ($prod->get_customer_files_by_sub_id($o_id, substr($osub_id, 1)) as $customer_file) {
        $product['customer_files'] = $product['customer_files'] . $customer_file["of_name"];
    }

    $product['result_files'] = $prod->show_results($o_id, $osub_id, $prod_id);

    //Creator
    $selected_creator = $prod->get_client($product['uca_id']);
    $creator_qualification = $prod->get_client_qualifications($selected_creator['client_ID']);
    $creator_active = $prod->get_client_rights($selected_creator['client_ID'])['u_status'];


    if($creator_active) $product['current_creator'] = $selected_creator['c_first_name'] . ' ' . $selected_creator['c_last_name'];


    //Sorting

    (strpos($prod_id, 'p11') !== false && strpos($osub_id, 'g') !== false) ? array_push($result['general']['b1'][$osub_id], $product) : null;

    (strpos($prod_id, 'p11') !== false && strpos($osub_id, 'n') !== false) ? array_push($result['interior']['b1'][$osub_id], $product) : null;
    (strpos($prod_id, 'p11') !== false && strpos($osub_id, 'x') !== false) ? array_push($result['exterior']['b1'][$osub_id], $product) : null;

    (strpos($prod_id, 'p13') !== false && strpos($osub_id, 'n') !== false) ? array_push($result['interior']['b3'][$osub_id], $product) : null;
    (strpos($prod_id, 'p13') !== false && strpos($osub_id, 'x') !== false) ? array_push($result['exterior']['b3'][$osub_id], $product) : null;

    (strpos($prod_id, 'p15') !== false && strpos($osub_id, 'n') !== false) ? array_push($result['interior']['b5'][$osub_id], $product) : null;
    (strpos($prod_id, 'p15') !== false && strpos($osub_id, 'x') !== false) ? array_push($result['exterior']['b5'][$osub_id], $product) : null;

    (strpos($prod_id, 'p16') !== false && strpos($osub_id, 'n') !== false) ? array_push($result['interior']['b6'][$osub_id], $product) : null;
    (strpos($prod_id, 'p16') !== false && strpos($osub_id, 'x') !== false) ? array_push($result['exterior']['b6'][$osub_id], $product) : null;

    (strpos($prod_id, 'p17') !== false && strpos($osub_id, 'n') !== false) ? array_push($result['interior']['b7'][$osub_id], $product) : null;
    (strpos($prod_id, 'p17') !== false && strpos($osub_id, 'x') !== false) ? array_push($result['exterior']['b7'][$osub_id], $product) : null;

    (strpos($prod_id, 'p18') !== false && strpos($osub_id, 'n') !== false) ? array_push($result['interior']['b8'][$osub_id], $product) : null;
    (strpos($prod_id, 'p18') !== false && strpos($osub_id, 'x') !== false) ? array_push($result['exterior']['b8'][$osub_id], $product) : null;


}


print json_encode($result);




