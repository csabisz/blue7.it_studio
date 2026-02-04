<?php
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
function dblanding()
{
    $dbhost="localhost";
    $dbuser="admin_landing";
    $dbpassword="iernut2016";
    $database="admin_landing";

    $mysqli=mysqli_connect($dbhost,$dbuser,$dbpassword,$database) or die("Sorry, Can't connect to database. Try later !");
    mysqli_set_charset($mysqli,'utf8');
    
    return $mysqli;
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
    function get_client($id)
	{
		$mysqli=dblanding(); 
		$id=mysqli_real_escape_string($mysqli,$id); 
		 
		$stmt=mysqli_prepare($mysqli,"select client_id from `u_clients_colors` where   `client_id`=?");
		mysqli_stmt_bind_param($stmt,"i",$id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
    }

    function get_m_client($id)
	{
		$mysqli=dblanding(); 
		$id=mysqli_real_escape_string($mysqli,$id); 
		 
		$stmt=mysqli_prepare($mysqli,"select mc_id from `u_clients_colors` where   `mc_id`=?");
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

function get_image_name($user_id)
{
 include('db.php');
 $statement = $connection->prepare("SELECT image FROM users WHERE id = '$user_id'");
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