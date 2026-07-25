<?php

include("../functions.php");

$prod = new Production;

$lt_id=$prod->xss_fix($_GET['lt_id']);

$all_creators = $prod->show_creators($lt_id);

$all_other_creators = $prod->show_creators_other_companies($lt_id);
?>
<option style="font-weight: bold; background-color: grey; color: white;">-- Choose creator --</option>
<?php
for($c=0;$c<count($all_creators);$c++)
{
    ?>
    <option value="<?php echo $all_creators[$c]['client_ID'];?>"><?php  
    $creator_name = $all_creators[$c]['c_first_name'];
    if(!empty($all_creators[$c]['c_middle_name'])) $creator_name .= ' ' . $all_creators[$c]['c_middle_name'];
    $creator_name .= ' ' . $creator['c_last_name'];

    echo $creator_name;
    ?></option>
<?php
}
?>
<option disabled="" style="font-weight: bold; background-color: grey; color: white;">Other Companies</option>
<?php
for($c=0;$c<count($all_other_creators);$c++)
{
    ?>
    <option value="<?php echo $all_other_creators[$c]['client_ID'];?>"><?php  
    $creator_name = $all_other_creators[$c]['c_first_name'];
    if(!empty($all_other_creators[$c]['c_middle_name'])) $creator_name .= ' ' . $all_other_creators[$c]['c_middle_name'];
    $creator_name .= ' ' . $creator['c_last_name'];

    echo $creator_name;
    ?></option>
<?php
}
?>