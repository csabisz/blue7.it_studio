<?php
include('../functions.php');
$prod = new Production;

$fto_category=$prod->xss_fix($_GET['fto_category']);
$flt_id=$prod->xss_fix($_GET['flt_id']);

$ltr_id=$prod->xss_fix($_GET['ltr_id']);

$base_url="https://blue7.it/studio/";

$ft_objects=$prod->get_all_ft_objects_by_category($fto_category);
$saved_ft_objects=explode(";",$prod->xss_fix($_GET['saved_ft_objects']));
?>
<table class="table table-bordered table-striped">
<thead class="thead-dark">
    <tr>
    <th scop="col">#</th>
    <th scop="col">Thumbnail</th>
    <th scop="col">Name</th>
    <th scop="col">Trader</th>
    <th scop="col">Producer</th>
    </tr>
</thead>    
<tbody>
    <?php 
    for ($f=0;$f<count($ft_objects);$f++)
    {
    ?>
    <tr>
    <td><input type="checkbox" class="form-check-input" style="margin-left:0;" name="edit_ft_object[]" value="<?php echo $ft_objects[$f]['fto_id'];?>" form="edit_lt_room_form<?= $ltr_id; ?>" <?php 
    for($o=0;$o<count($saved_ft_objects);$o++)
    {
        if($saved_ft_objects[$o]==$ft_objects[$f]['fto_id'])
        {
            echo "checked";
        }
    }
    ?>></td>
    <td><img src="<?php echo $base_url.$ft_objects[$f]['fs_thumbnail'];?>" alt="thumbnail" style="width:100px;height:100px;"></td>
    <td><?php echo $ft_objects[$f]['fto_name'];?></td>
    <td><?php 
    $ft_trader=$prod->get_ft_trader($ft_objects[$f]['ft_trader']);
    echo $ft_trader['clientname']; ?></td>
    <td><?php 
    $fto_producer=$prod->get_fto_producer($ft_objects[$f]['fto_producer']);
    echo $fto_producer['ftop_name'];?></td>
    </tr>
    <?php
    }
    ?>
</tbody>
</table>