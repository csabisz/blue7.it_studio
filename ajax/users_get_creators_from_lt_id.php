<?php
session_start();
include("../functions.php");

$prod=new Production;

$lt_id=$prod->xss_fix($_GET['lt_id']);

if(!empty($lt_id))
{
    $creators=$prod->show_creators($lt_id);
}
else
{
    $creators=$prod->show_creators($_COOKIE['lt_id']);
    $other_creators=$prod->show_creators_other_companies($_COOKIE['lt_id']);
}

if(!empty($creators))
{
    ?>
    <option value="">--Choose--</option>
    <option value="all_creators">--All creators--</option>
    <?php
    for($i=0;$i<count($creators);$i++)
    {
        $licence_taker=$prod->get_company($creators[$i]['lt_id']);
    ?>
    <option value="<?php echo $creators[$i]['client_ID']; ?>" <?php echo ($creators[$i]['client_ID']==$selected_user)?"selected":""; ?>><?php 
    if(!empty($creators[$i]['c_last_name']))
    {
        echo $creators[$i]['c_first_name']." ".$creators[$i]['c_last_name']." - ".$licence_taker['mailnick'];
    }
    else
    {
        echo $creators[$i]['l_first_name']." ".$creators[$i]['l_last_name']." - ".$licence_taker['mailnick'];
    } ?></option>
    <?php
    }
}

if(!empty($other_creators))
{
    ?>
    <option value="" style="color:red;">Resources from other companies</option>
    <?php
    for($i=0;$i<count($other_creators);$i++)
    {
        $licence_taker=$prod->get_company($other_creators[$i]['lt_id']);
    ?>
    <option value="<?php echo $other_creators[$i]['client_ID']; ?>" <?php echo ($other_creators[$i]['client_ID']==$selected_user)?"selected":""; ?>><?php 
    if(!empty($other_creators[$i]['c_last_name']))
    {
        echo $other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name']." - ".$licence_taker['mailnick'];
    }
    else
    {
        echo $other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name']." - ".$licence_taker['mailnick'];
    } ?></option>
    <?php
    }
}
?>
