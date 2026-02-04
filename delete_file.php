<?php
include('functions.php');

$output_dir = "client_files/";
$year=date("Y");

$o_id=$_GET['o_id'];
$filecategory=$_GET['filecategory'];

if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{
	$fileName =$_POST['name'];
	$fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files	
	$filePath = $output_dir.$year."/".$o_id."/".$fileName;
	if (file_exists($filePath)) 
	{
        unlink($filePath);
    }
	echo "Deleted File ".$fileName."<br>";
}

?>