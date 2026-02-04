<?php 

function upload_image()
{
 if(isset($_FILES["user_image"]))
 {
  $extension = explode('.', $_FILES['user_image']['name']);
  $new_name = rand() . '.' . $extension[1];
  $destination = './upload/' . $new_name;
  move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
  return $new_name;
 }
}

function get_image_name($client_id)
{
 include('db.php');
 $statement = $connection->prepare("select logo from `u_clients_colors` where  (`mc_id`='$client_id' or `client_id`='$client_id' )");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row["image"];
 }
} 
function get_total_all_records()
{
 include('db.php');
 $statement = $connection->prepare("SELECT * FROM u_clients_colors");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}
?>