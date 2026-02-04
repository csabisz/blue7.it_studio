<?php
error_reporting(E_ALL); 
include('db.php');
include('functions.php');
function upload_image()
{
 if(isset($_FILES["client_image"]))
 {
  $extension = explode('.', $_FILES['client_image']['name']);
  $new_name = rand() . '.' . $extension[1];
  $destination = './upload/' . $new_name;
  move_uploaded_file($_FILES['client_image']['tmp_name'], $destination);
  return $new_name;
 }
}
if(isset($_POST["operation"]))
{
 if($_POST["operation"] == "Add")
 { 
    
    if(($_POST["category_id"]=='c'))
    {
        $image = '';
    if($_FILES["client_image"]["name"] != '')
    {
        $image = upload_image();
    }
        $statement = $connection->prepare("INSERT INTO u_clients_colors ( client_id, color_1,color_1a, color_2 , color_4, color_5, logo ) 
    VALUES ( :client_id, :color_1, :color_1a, :color_2,  :color_4, :color_5, :logo )");
    $result = $statement->execute(
    array(
    ':client_id' => $_POST["client_id"],
    ':color_1' => $_POST["text_color"],
    ':color_1a' => $_POST["hover_color"],
    ':color_2' => $_POST["link_color"],
    ':color_4' => $_POST["picture_shadow_color"],
    ':color_5' => $_POST["background_color"] ,
    ':logo' => $image
    )
    );
    }
    elseif(($_POST["category_id"]=="mc"))
    {
        $image = '';
    if($_FILES["client_image"]["name"] != '')
    {
        $image = upload_image();
    }
        $statement = $connection->prepare("INSERT INTO u_clients_colors ( mc_id, color_1,color_1a, color_2 , color_4, color_5, logo ) 
    VALUES ( :client_id, :color_1, :color_1a, :color_2,  :color_4, :color_5, :logo )");
    $result = $statement->execute(
    array(
    ':client_id' => $_POST["client_id"],
    ':color_1' => $_POST["text_color"],
    ':color_1a' => $_POST["hover_color"],
    ':color_2' => $_POST["link_color"],
    ':color_4' => $_POST["picture_shadow_color"],
    ':color_5' => $_POST["background_color"] ,
    ':logo' => $image
    )
    );
    }
    

  echo count($result);

  if(empty($result))
  {
      echo $_POST["category_id"];
  }
  else{
    echo 'Data not Inserted';
  }
 } 

 if($_POST["operation"] == "Edit")
 {
  $image = '';
  if($_FILES["client_image"]["name"] != '')
  {
   $image = upload_image();
  }
  else
  {
   $image = $_POST["hidden_client_image"];
  }
if((get_client($_POST["client_id"]) != 0)&&($_POST["category_id"]=='c'))
{
    $statement = $connection->prepare(
        "UPDATE u_clients_colors 
        SET client_id = :client_id, mc_id=' ',  color_1 = :color_1, color_1a = :color_1a, color_2 = :color_2, color_4 = :color_4, color_5 = :color_5  , logo = :logo
        WHERE ( clc_id = :idhid && client_id = :client_id )
        "
       );
       $result = $statement->execute(
        array(
         ':client_id' => $_POST["client_id"], 
         ':color_1' => $_POST["text_color"],
         ':color_1a' => $_POST["hover_color"],
         ':color_2' => $_POST["link_color"],
         ':color_4' => $_POST["picture_shadow_color"],
         ':color_5' => $_POST["background_color"] ,
         ':logo' => $image,
         ':idhid' => $_POST["idhid"] ,

        )
       );
       
}
if((get_client($_POST["client_id"]) != 0)&&($_POST["category_id"]=='mc'))
{
    $statement = $connection->prepare(
        "UPDATE u_clients_colors 
        SET client_id = ' ', mc_id=:client_id,  color_1 = :color_1, color_1a = :color_1a, color_2 = :color_2, color_4 = :color_4, color_5 = :color_5  , logo = :logo
        WHERE ( clc_id = :idhid && client_id = :client_id )
        "
       );
       $result = $statement->execute(
        array(
         ':client_id' => $_POST["client_id"], 
         ':color_1' => $_POST["text_color"],
         ':color_1a' => $_POST["hover_color"],
         ':color_2' => $_POST["link_color"],
         ':color_4' => $_POST["picture_shadow_color"],
         ':color_5' => $_POST["background_color"] ,
         ':logo' => $image,
         ':idhid' => $_POST["idhid"] ,

        )
       );
} 
if((get_m_client($_POST["client_id"]) != 0)&&($_POST["category_id"]=='mc'))
{
    $statement = $connection->prepare(
        "UPDATE u_clients_colors 
        SET mc_id=:client_id, client_id='',  color_1 = :color_1, color_1a = :color_1a, color_2 = :color_2, color_4 = :color_4, color_5 = :color_5  , logo = :logo
        WHERE ( clc_id = :idhid && client_id = :client_id )
        "
       );
       $result = $statement->execute(
        array(
         ':client_id' => $_POST["client_id"], 
         ':color_1' => $_POST["text_color"],
         ':color_1a' => $_POST["hover_color"],
         ':color_2' => $_POST["link_color"],
         ':color_4' => $_POST["picture_shadow_color"],
         ':color_5' => $_POST["background_color"] ,
         ':logo' => $image,
         ':idhid' => $_POST["idhid"] ,

        )
       );
       echo $_POST["category_id"];
    //    print_r(get_m_client($_POST["client_id"]) );
}
if((get_m_client($_POST["client_id"]) != 0)&&($_POST["category_id"]=='c'))
{
    $statement = $connection->prepare(
        "UPDATE u_clients_colors 
        SET  mc_id= ' ',  client_id = :client_id, color_1 = :color_1, color_1a = :color_1a, color_2 = :color_2, color_4 = :color_4, color_5 = :color_5  , logo = :logo
        WHERE ( clc_id = :idhid && client_id = :client_id )
        "
       );
       $result = $statement->execute(
        array(
         ':client_id' => $_POST["client_id"], 
         ':color_1' => $_POST["text_color"],
         ':color_1a' => $_POST["hover_color"],
         ':color_2' => $_POST["link_color"],
         ':color_4' => $_POST["picture_shadow_color"],
         ':color_5' => $_POST["background_color"] ,
         ':logo' => $image,
         ':idhid' => $_POST["idhid"] ,

        )
       );
}
// else
// {
//     $statement = $connection->prepare(
//         "UPDATE u_clients_colors 
//         SET mc_id = :client_id, client_id='', color_1 = :color_1, color_1a = :color_1a, color_2 = :color_2, color_4 = :color_4, color_5 = :color_5  , logo = :logo
//         WHERE (clc_id = :idhid && mc_id = :client_id)
//         "
//        );
//        $result = $statement->execute(
//         array(
//          ':client_id' => $_POST["client_id"],
//          ':color_1' => $_POST["text_color"],
//          ':color_1a' => $_POST["hover_color"],
//          ':color_2' => $_POST["link_color"],
//          ':color_4' => $_POST["picture_shadow_color"],
//          ':color_5' => $_POST["background_color"] ,
//          ':logo' => $image,
//          ':idhid' => $_POST["idhid"] 
//         )
//        );
// }
  
  if(!empty($result))
  {
    // echo get_m_client($_POST["client_id"]["client_id"]);
  }
}
 
}

?>
   