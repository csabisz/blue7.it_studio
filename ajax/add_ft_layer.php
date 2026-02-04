<?php
include('../functions.php');
$prod = new Production;

$save_data['orf_id'] =$prod->xss_fix($_POST['orf_id']);
$save_data['rks_id'] = $prod->xss_fix($_POST['rks_id']);
$save_data['camera_view'] = $prod->xss_fix($_POST['camera_view']);
$save_data['z_index']=  $prod->xss_fix($_POST['z_index']);
$save_data['ft_object'] = $_POST['ft_object'];
$save_data['multiplicator'] = $_POST['multiplicator'];
   
$check_existing_ft_layer=$prod->get_ft_layer_from_orf_id($save_data['orf_id']);

if(empty($check_existing_ft_layer))
{
    for($o=0;$o<count($save_data['ft_object']);$o++)
    {
        for($m=0;$m<count($save_data['ft_object']);$m++)
        {
            if($o==$m)
            {
                if(empty($save_data['multiplicator'][$m]))
                {
                    $save_data['multiplicator'][$m]=1;
                }

                $fto_content .= $save_data['ft_object'][$o]."(".$save_data['multiplicator'][$m]."),";
            }
        }
    }

    $save_data['fto_content']=$fto_content;

    $prod->add_ft_layers(json_encode($save_data));
}
else
{
    echo "An unexpected error occured ! Refresh the page and try again !";
}
?>