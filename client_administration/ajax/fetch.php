<?php 
include'db.php';


$colors = get_colors();
$output = array();
$data = array();
for ($i=0; $i < count($colors); $i++) 
{ 
    $sub_array = array();
    if(!empty($colors[$i]['mc_id'])){
        $client_name = get_main_client_name($colors[$i]['mc_id']);
        $sub_array[] =  $client_name['clientname'] . '('.$colors[$i]['mc_id'].')';  
        $sub_array[] = 'main client';
        $sub_array[] = $colors[$i]['logo'];
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_1'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_1a'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_2'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_4'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_5'].'">';
        $sub_array[] = '<button type="button" name="update" id="'.$colors[$i]['mc_id'].'" class="btn btn-warning btn-xs update">Update</button> <button type="button" name="delete" id="'.$colors[$i]['mc_id'].'" class="btn btn-danger btn-xs delete">Delete</button>';

    }
    if(!empty($colors[$i]['client_id'])){
        $client_name = get_client_name($colors[$i]['client_id']);
        $sub_array[] = $client_name['clientname'] . '('.$colors[$i]['client_id'].')';
        $sub_array[] = 'simple';
        $sub_array[] = $colors[$i]['logo'];
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_1'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_1a'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_2'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_4'].'">';
        $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$colors[$i]['color_5'].'">';
        $sub_array[] = '<button type="button" name="update" id="'.$colors[$i]['client_id'].'" class="btn btn-warning btn-xs update">Update</button> <button type="button" name="delete" id="'.$colors[$i]['client_id'].'" class="btn btn-danger btn-xs delete">Delete</button>';
    }
    
     $data[] = $sub_array;
}
 

$output = array(
    // "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  count($colors),
    "recordsFiltered" => count($data),
    "data"    => $data
   );
   echo json_encode($output); 