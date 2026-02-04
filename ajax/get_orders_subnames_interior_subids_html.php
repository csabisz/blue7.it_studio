<?php
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);

$all_interior_subids=$prod->get_all_orders_subnames_interior_subids($o_id);
?>
<option value="">None</option>
<?php
for($i=0;$i<count($all_interior_subids);$i++)
{
?>
<option value="<?php echo $all_interior_subids[$i]['osub_id'];?>" data-osn_id="<?php echo $all_interior_subids[$i]['osn_id'];?>"><?php echo $all_interior_subids[$i]['osub_id'];?></option>
<?php
}
?>