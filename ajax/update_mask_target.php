<?php
session_start();
include("../functions.php");

$prod=new Production;

$data['orme_id']=$prod->xss_fix($_POST['orme_id']);
$ort_id=$_POST['ort_id'];


$existing_mask_targets=$prod->get_base_picture_mask($data['orme_id']);

$existing_ort_ids_array=explode("|",$existing_mask_targets['ort_id']);

$ort_ids="|";

$empty_existing_array=0;

print_r($existing_ort_ids_array);
print_r($ort_id);

for($t=0;$t<count($existing_ort_ids_array);$t++)
{
    if(!empty($existing_ort_ids_array[$t])) //checking if there are no targets
    {
        $empty_existing_array++;
    }
}

if($empty_existing_array>0)
{
    for($t=0;$t<count($existing_ort_ids_array);$t++)
    {
        if(!empty($existing_ort_ids_array[$t]))
        {
            if(in_array($existing_ort_ids_array[$t]."|",$ort_id))
            {
                $ort_ids.=$existing_ort_ids_array[$t]."|";
            }
        }
    }
    echo "<br>".$ort_ids;
    for($t=0;$t<count($ort_id);$t++)
    {
        if (strpos($ort_ids, "|".$ort_id[$t]) === false)
        {
            $ort_ids.=$ort_id[$t];
        }
    }
}
else
{
    for($t=0;$t<count($ort_id);$t++)
    {
        $ort_ids.=$ort_id[$t];
    }
}

echo "<br>".$ort_ids;
$data['ort_id']=$ort_ids;
$prod->update_mask_target(json_encode($data));

?>