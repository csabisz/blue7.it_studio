<?php
include("../functions.php");
include('../../../../domenia7.com/public_html/domenia_db2.php');

$prod=new Production;
$domenia2=new Domenia2;

$o_id=$prod->xss_fix($_GET['o_id']);

if(!empty($o_id))
{
//b5 ex 

$b5_basement=$prod->xss_fix($_GET['b5_basement']);
$b5_levels_over_ground=$prod->xss_fix($_GET['b5_levels_over_ground']);
$b5_e_length=$prod->xss_fix($_GET['b5_e_length']);
$b5_e_width=$prod->xss_fix($_GET['b5_e_width']);
$b5_environment=$prod->xss_fix($_GET['b5_environment']);
$b5_rs_id=$prod->xss_fix($_GET['b5_rs_id']);
$roof_material=$prod->xss_fix($_GET['roof_material']);
$b5_roof_color=$prod->xss_fix($_GET['b5_roof_color']);
$b5_r_tilt=$prod->xss_fix($_GET['b5_r_tilt']);
$b5_r_kneewall=$prod->xss_fix($_GET['b5_r_kneewall']);
$b5_rop_id=$prod->xss_fix($_GET['b5_rop_id']);
$b5_ww_id=$prod->xss_fix($_GET['b5_ww_id']);
$b5_wlc_id=$prod->xss_fix($_GET['b5_wlc_id']);
$b5_wc_id=$prod->xss_fix($_GET['b5_wc_id']);
$b5_door_shape_sides=$prod->xss_fix($_GET['b5_door_shape_sides']);
$b5_door_texture=$prod->xss_fix($_GET['b5_door_texture']);
$b5_door_color=$prod->xss_fix($_GET['b5_door_color']);
$b5_gc_id=$prod->xss_fix($_GET['b5_gc_id']);
$b5_garage_size=$prod->xss_fix($_GET['b5_garage_size']);

//b7 ex

$b7_basement=$prod->xss_fix($_GET['b7_basement']);
$b7_levels_over_ground=$prod->xss_fix($_GET['b7_levels_over_ground']);
$b7_e_length=$prod->xss_fix($_GET['b7_e_length']);
$b7_e_width=$prod->xss_fix($_GET['b7_e_width']);
$b7_rs_id=$prod->xss_fix($_GET['b7_rs_id']);
$b7_roof_material=$prod->xss_fix($_GET['b7_roof_material']);
$b7_roof_color=$prod->xss_fix($_GET['b7_roof_color']);
$b7_r_tilt=$prod->xss_fix($_GET['b7_r_tilt']);
$b7_r_kneewall=$prod->xss_fix($_GET['b7_r_kneewall']);
$b7_rop_id=$prod->xss_fix($_GET['b7_rop_id']);
$b7_ww_id=$prod->xss_fix($_GET['b7_ww_id']);
$b7_wlc_id=$prod->xss_fix($_GET['b7_wlc_id']);
$b7_wc_id=$prod->xss_fix($_GET['b7_wc_id']);
$b7_door_shape_sides=$prod->xss_fix($_GET['b7_door_shape_sides']);
$b7_door_texture=$prod->xss_fix($_GET['b7_door_texture']);
$b7_door_color=$prod->xss_fix($_GET['b7_door_color']);
$b7_gc_id=$prod->xss_fix($_GET['b7_gc_id']);
$b7_garage_size=$prod->xss_fix($_GET['b7_garage_size']);
$b7_environment=$prod->xss_fix($_GET['b7_environment']);

//b5 ex

if(!empty($b5_gc_id))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="gc_id";
	$ex_b5['value']=$b5_gc_id;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Garage updated !";
}

if(!empty($b5_garage_size))
{

    $ex_b5['o_id']=$o_id;
    
    if($b5_garage_size=="3x6")
    {
        $gc_length=3;
        $ex_b5['column_name']="gc_length";
        $ex_b5['value']=$gc_length;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));

        $gc_width=6;
        $ex_b5['column_name']="gc_width";
        $ex_b5['value']=$gc_width;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));

        $gc_height=2.5;
        $ex_b5['column_name']="gc_height";
        $ex_b5['value']=$gc_height;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
    }
    if($b5_garage_size=="6x6")
    {
        $gc_length=6;
        $ex_b5['column_name']="gc_length";
        $ex_b5['value']=$gc_length;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));

        $gc_width=6;
        $ex_b5['column_name']="gc_width";
        $ex_b5['value']=$gc_width;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));

        $gc_height=2.5;
        $ex_b5['column_name']="gc_height";
        $ex_b5['value']=$gc_height;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
    }
    if($b5_garage_size=="6x9")
    {
        $gc_length=6;
        $ex_b5['column_name']="gc_length";
        $ex_b5['value']=$gc_length;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));

        $gc_width=9;
        $ex_b5['column_name']="gc_width";
        $ex_b5['value']=$gc_width;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));

        $gc_height=2.5;
        $ex_b5['column_name']="gc_height";
        $ex_b5['value']=$gc_height;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
    }
	
	$result_message="Garage size updated !";
}

if(!empty($b5_door_texture))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="door_texture";
	$ex_b5['value']=$b5_door_texture;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Door texture updated !";
}

if(!empty($b5_door_shape_sides))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="dsp_id";
	$ex_b5['value']=$b5_door_shape_sides;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Door shape side updated !";
}

if(!empty($b5_basement))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="basement";
	$ex_b5['value']=$b5_basement;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Basement updated !";
}

if(!empty($b5_wc_id))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="wc_id";
	$ex_b5['value']=$b5_wc_id;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Window color updated !";
}

if(!empty($b5_levels_over_ground))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="levels_over_ground";
	$ex_b5['value']=$b5_levels_over_ground;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Levels over ground updated !";
}

if(!empty($b5_e_length))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="e_length";
	$ex_b5['value']=$b5_e_length;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Length updated !";
}

if(!empty($b5_e_width))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="e_width";
	$ex_b5['value']=$b5_e_width;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Width updated !";
}

if(!empty($b5_rs_id))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="rs_id";
	$ex_b5['value']=$b5_rs_id;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Roof shape changed !";
}

if(!empty($b5_r_tilt))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="r_tilt";
	$ex_b5['value']=$b5_r_tilt;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Roof tilt changed !";
}

if(!empty($b5_wlc_id))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="wlc_id";
	$ex_b5['value']=$b5_wlc_id;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Facade color changed !";
}

if(!empty($b5_r_kneewall))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="r_kneewall";
	$ex_b5['value']=$b5_r_kneewall;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Roof kneewall changed !";
}

if(!empty($roof_material))
{
    $all_roof_colors=$domenia2->get_roof_colors($roof_material);

    $result_message="<select id=\"roof_color\" name=\"roof_color\" class=\"form-control form-control-sm\" form=\"order_details\">";
    $result_message.="<option value=\"0\" selected>None</option>";
    for($i=0;$i<count($all_roof_colors);$i++)
    {						   
        $result_message.="<option value=\"".$all_roof_colors[$i]['rmp_id']."\">".$all_roof_colors[$i]['rmp_dbcolor']."</option>";						
    }
      
    $result_message.="</select>";
}

if(!empty($b5_roof_color))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="rmp_id";
	$ex_b5['value']=$b5_roof_color;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Roof color changed !";
}

if(!empty($b5_door_color))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="door_color";
	$ex_b5['value']=$b5_door_color;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Door color updated !";
}

if(!empty($b5_ww_id))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="ww_id";
	$ex_b5['value']=$b5_ww_id;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Facade extras changed !";
}

if(!empty($b5_rop_id))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="rop_id";
	$ex_b5['value']=$b5_rop_id;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Roof overstand changed !";
}

if(!empty($b5_environment))
{
	$ex_b5['o_id']=$o_id;
	$ex_b5['column_name']="pbp_id";
	$ex_b5['value']=$b5_environment;
	
	$prod->update_o_desc_ex_b5_column(json_encode($ex_b5));
	
	$result_message="Environment updated !";
}

//b7 ex 

if(!empty($b7_basement))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="basement";
	$ex_b7['value']=$b7_basement;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Basement updated !";
}

if(!empty($b7_levels_over_ground))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="levels_over_ground";
	$ex_b7['value']=$b7_levels_over_ground;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Levels over ground updated !";
}

if(!empty($b7_e_length))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="e_length";
	$ex_b7['value']=$b7_e_length;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Length updated !";
}

if(!empty($b7_e_width))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="e_width";
	$ex_b7['value']=$b7_e_width;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Width updated !";
}

if(!empty($b7_environment))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="pbp_id";
	$ex_b7['value']=$b7_environment;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Environment updated !";
}

if(!empty($b7_rs_id))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="rs_id";
	$ex_b7['value']=$b7_rs_id;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Roof shape changed !";
}

if(!empty($b7_r_tilt))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="r_tilt";
	$ex_b7['value']=$b7_r_tilt;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Roof tilt changed !";
}

if(!empty($b7_r_kneewall))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="r_kneewall";
	$ex_b7['value']=$b7_r_kneewall;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Roof kneewall changed !";
}

if(!empty($b7_ww_id))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="ww_id";
	$ex_b7['value']=$b5_ww_id;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Facade extras changed !";
}

if(!empty($b7_roof_material))
{
    $all_roof_colors=$domenia2->get_roof_colors($b7_roof_material);

    $result_message="<select id=\"b7_roof_color\" name=\"b7_roof_color\" class=\"form-control form-control-sm\">";
    $result_message.="<option value=\"0\" selected>None</option>";
    for($i=0;$i<count($all_roof_colors);$i++)
    {						   
        $result_message.="<option value=\"".$all_roof_colors[$i]['rmp_id']."\">".$all_roof_colors[$i]['rmp_dbcolor']."</option>";						
    }
      
    $result_message.="</select>";
}

if(!empty($b7_rop_id))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="rop_id";
	$ex_b7['value']=$b7_rop_id;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Roof overstand changed !";
}

if(!empty($b7_roof_color))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="rmp_id";
	$ex_b7['value']=$b7_roof_color;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Roof color changed !";
}

if(!empty($b7_wlc_id))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="wlc_id";
	$ex_b7['value']=$b7_wlc_id;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Facade color changed !";
}

if(!empty($b7_wc_id))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="wc_id";
	$ex_b7['value']=$b7_wc_id;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Window color updated !";
}

if(!empty($b7_door_texture))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="door_texture";
	$ex_b7['value']=$b7_door_texture;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Door texture updated !";
}

if(!empty($b7_door_shape_sides))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="dsp_id";
	$ex_b7['value']=$b7_door_shape_sides;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Door shape side updated !";
}

if(!empty($b7_door_color))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="door_color";
	$ex_b7['value']=$b7_door_color;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Door color updated !";
}

if(!empty($b7_gc_id))
{
	$ex_b7['o_id']=$o_id;
	$ex_b7['column_name']="gc_id";
	$ex_b7['value']=$b7_gc_id;
	
	$prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
	
	$result_message="Garage updated !";
}

if(!empty($b7_garage_size))
{

    $ex_b7['o_id']=$o_id;
    
    if($b7_garage_size=="3x6")
    {
        $gc_length=3;
        $ex_b7['column_name']="gc_length";
        $ex_b7['value']=$gc_length;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));

        $gc_width=6;
        $ex_b7['column_name']="gc_width";
        $ex_b7['value']=$gc_width;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));

        $gc_height=2.5;
        $ex_b7['column_name']="gc_height";
        $ex_b7['value']=$gc_height;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
    }
    if($b7_garage_size=="6x6")
    {
        $gc_length=6;
        $ex_b7['column_name']="gc_length";
        $ex_b7['value']=$gc_length;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));

        $gc_width=6;
        $ex_b7['column_name']="gc_width";
        $ex_b7['value']=$gc_width;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));

        $gc_height=2.5;
        $ex_b7['column_name']="gc_height";
        $ex_b7['value']=$gc_height;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
    }
    if($b7_garage_size=="6x9")
    {
        $gc_length=6;
        $ex_b7['column_name']="gc_length";
        $ex_b7['value']=$gc_length;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));

        $gc_width=9;
        $ex_b5['column_name']="gc_width";
        $ex_b5['value']=$gc_width;

        $prod->update_o_desc_ex_b5_column(json_encode($ex_b7));

        $gc_height=2.5;
        $ex_b7['column_name']="gc_height";
        $ex_b7['value']=$gc_height;

        $prod->update_o_desc_ex_b7_column(json_encode($ex_b7));
    }
	
	$result_message="Garage size updated !";
}

echo $result_message;

}
?>