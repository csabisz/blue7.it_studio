<?php
include('db.php');
include('functions.php');
if(isset($_POST["id"]))
{
 $output = array();
 $statement = $connection->prepare(
  "SELECT * FROM u_clients_colors 
  WHERE clc_id = '".$_POST["id"]."' 
  LIMIT 1"
 );
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
    if($row["mc_id"] != 0)
    {
        $output["idhid"] = $row["clc_id"];
        $output["category"] = 'mc';
        $output["client_id"] = $row["mc_id"];
        $output["color_1"] = $row["color_1"];
        $output["color_1a"] = $row["color_1a"];
        $output["color_2"] = $row["color_2"];
        $output["color_4"] = $row["color_4"];
        $output["color_5"] = $row["color_5"];
        if($row["logo"] != '')
        {
        $output['client_image'] = '<img src="upload/'.$row["logo"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_client_image" value="'.$row["logo"].'" />';
        }
        else
        {
        $output['client_image'] = '<input type="hidden" name="hidden_client_image" value="" />';
        }
    }
    elseif($row["client_id"] != 0)
    { 
        $output["idhid"] = $row["clc_id"];
        $output["category"] = 'c';
        $output["client_id"] = $row["client_id"];
        $output["color_1"] = $row["color_1"];
        $output["color_1a"] = $row["color_1a"];
        $output["color_2"] = $row["color_2"];
        $output["color_4"] = $row["color_4"];
        $output["color_5"] = $row["color_5"];
        if($row["logo"] != '')
        {
        $output['client_image'] = '<img src="upload/'.$row["logo"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_client_image" value="'.$row["logo"].'" />';
        }
        else
        {
        $output['client_image'] = '<input type="hidden" name="hidden_client_image" value="" />';
        }
    }
 }
 echo json_encode($output);
}
?>