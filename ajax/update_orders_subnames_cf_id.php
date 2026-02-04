<?php

include("../functions.php");

$prod = new Production;

$data['subo_id'] = $prod->xss_fix($_POST['subo_id']);
$data['cf_id'] = $prod->xss_fix($_POST['cf_id']);
$data['checked']=$prod->xss_fix($_POST['checked']);

$orders_subname=$prod->get_orders_subname(json_encode($data));

$new_cf="";

if(!empty($orders_subname))
{
    $cf_ids=explode(';',$orders_subname['cf_id']);

    if($data['checked']==1)
    {
        for($c=0;$c<count($cf_ids);$c++)
        {
            if($cf_ids[$c]!=$data['cf_id'])
            {
                $new_cf .= $cf_ids[$c].";";
            }  
        }
        $new_cf .= $data['cf_id'].";";
    }
    else
    {
        for($c=0;$c<count($cf_ids);$c++)
        {
            if($cf_ids[$c]!=$data['cf_id'])
            {
                $new_cf .= $cf_ids[$c].";";
            }
        }
        $new_cf .="";
    }
    $new_cf_raw=explode(';',$new_cf);

    for($c=0;$c<count($new_cf_raw);$c++)
    {
        if(!empty($new_cf_raw[$c]))
        {
            $new_cf2 .= $new_cf_raw[$c].";";
        }
    }

    $prod->change_orders_subnames_cf_id($data['subo_id'],$new_cf2);
}
?>