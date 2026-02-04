<?php 

 

  function dbsuperplan(){
    $dbhost="localhost";
    $dbuser="admin_superplan";
    $dbpassword="zg5{/m}5m9-CEA*r";
    $database="admin_superplan";

    $mysqli=mysqli_connect($dbhost,$dbuser,$dbpassword,$database) or die("are u joking?! there is no DB connection.");
    mysqli_set_charset($mysqli,'utf8');
    
    return $mysqli;
}

function admin_landing(){
    $dbhost="localhost";
    $dbuser="admin_landing";
    $dbpassword="iernut2016";
    $database="admin_landing";

    $mysqli=mysqli_connect($dbhost,$dbuser,$dbpassword,$database) or die("are u joking?! there is no DB connection.");
    mysqli_set_charset($mysqli,'utf8');
    
    return $mysqli;
}

function dbconnect()
	{
		$dbhost="localhost";
		$dbuser="admin_domenia1";
		$dbpassword="iernut2016";
		$database="admin_domenia1";

		$mysqli=mysqli_connect($dbhost,$dbuser,$dbpassword,$database) or die("Sorry, Can't connect to database. Try later !");
		mysqli_set_charset($mysqli,'utf8');
		
		return $mysqli;
    } 
    function create_color_set($data)
	{ 
        $mysqli=admin_landing();  
		$clientid=mysqli_real_escape_string($mysqli,$data['client_id']);
		$text=mysqli_real_escape_string($mysqli,$data['text']); 
        
        $sql = "insert into u_clients_colors(client_id,color_1) values($clientid,$text)";
        $stmt=mysqli_prepare($mysqli,$sql); 
        
        mysqli_stmt_bind_param($stmt,"is",$clientid,$text);
        mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);		
		mysqli_close($mysqli);
	}

    function get_client_name($id)
	{
		$mysqli=dbconnect(); 
		$id=mysqli_real_escape_string($mysqli,$id); 
		 
		$stmt=mysqli_prepare($mysqli,"select clientname from `u_clients` where   `client_ID`=?");
		mysqli_stmt_bind_param($stmt,"i",$id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
    }
 
function get_main_client_name($id)
	{
		$mysqli=dbconnect(); 
		$id=mysqli_real_escape_string($mysqli,$id); 
		 
		$stmt=mysqli_prepare($mysqli,"select clientname from `u_clients_main` where   `mc_id`=?");
		mysqli_stmt_bind_param($stmt,"i",$id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
    }
function get_colors()
	{
		$mysqli=admin_landing(); 
        $query="SELECT * FROM `u_clients_colors`"; 
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); 
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;     
        } 
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

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

// function get_image_name($user_id)
// {
//  include('db.php');
//  $statement = $connection->prepare("SELECT image FROM users WHERE id = '$user_id'");
//  $statement->execute();
//  $result = $statement->fetchAll();
//  foreach($result as $row)
//  {
//   return $row["image"];
//  }
// }
function get_image_name($id)
	{
		$mysqli=dbsuperplan(); 
		$id=mysqli_real_escape_string($mysqli,$id); 
		
		$stmt=mysqli_prepare($mysqli,"select logo from `u_clients_colors` where  (`mc_id`=? or `client_id`=? )");
		mysqli_stmt_bind_param($stmt,"i",$id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
    }

function get_total_all_records()
{
 include('db.php');
 $statement = $connection->prepare("SELECT * FROM users");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}

?>