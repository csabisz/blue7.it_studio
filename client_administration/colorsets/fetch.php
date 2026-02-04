<?php
include('db.php');
include('functions.php');
$query = '';
$output = array();
$query .= "SELECT * FROM u_clients_colors ";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE client_id LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR mc_id LIKE "%'.$_POST["search"]["value"].'%" ';
}

if($_POST["length"] != -1)
{
 $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
 $logo = '';
 if($row["logo"] != '')
 {
  $logo = '<img src="upload/'.$row["logo"].'" class="img-thumbnail" width="50" height="35" />';
 }
 else
 {
  $logo = '';
 }
 
 $sub_array = array();
//  $sub_array[] = $image;
if($row["mc_id"] != 0){
    $client_name = get_main_client_name($row['mc_id']);
    $sub_array[] =  $client_name['clientname'] . '('.$row['mc_id'].')'; 
    // $sub_array[] = $row["mc_id"];
    $sub_array[] = '<b>main client</b>';
    $sub_array[] = $logo;
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_1'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_1a'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_2'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_4'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_5'].'">';
    $sub_array[] = '<button type="button" name="update" id="'.$row["clc_id"].'" class="btn btn-warning btn-xs update"><i class="fas fa-edit"></i></button> <button type="button" name="delete" id="'.$row["clc_id"].'" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button>';   
}
if($row["client_id"] != 0){
    $client_name = get_client_name($row['client_id']);
    $sub_array[] =  $client_name['clientname'] . '('.$row['client_id'].')'; 
    $sub_array[] = 'simple';
    $sub_array[] = $logo;
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_1'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_1a'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_2'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_4'].'">';
    $sub_array[] = '<input disabled="" type="color" name="favcolor" value="'.$row['color_5'].'">';
    $sub_array[] = '<button type="button" name="update" id="'.$row["clc_id"].'" class="btn btn-warning btn-xs update"><i class="fas fa-edit"></i></button> <button type="button" name="delete" id="'.$row["clc_id"].'" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button>';   
} 

 $data[] = $sub_array;
}
$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  $filtered_rows,
 "recordsFiltered" => get_total_all_records(),
 "data"    => $data
);
echo json_encode($output);
?>