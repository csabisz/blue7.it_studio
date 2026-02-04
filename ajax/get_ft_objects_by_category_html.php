<?php
include('../functions.php');
$prod = new Production;

$fto_category=$prod->xss_fix($_GET['fto_category']);
$orf_id=$prod->xss_fix($_GET['orf_id']);
$base_url="https://blue7.it/studio/";

$ft_objects=$prod->get_all_ft_objects_by_category($fto_category);


?>
<table class="table table-bordered table-striped">
<thead class="thead-dark">
    <tr>
    <th scop="col">#</th>
    <th scop="col">Thumbnail</th>
    <th scop="col">Multiplicator</th>
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
    <td><input type="checkbox" class="form-check-input" name="ft_object[]" value="<?php echo $ft_objects[$f]['fto_id'];?>" form="save_furniture_layer_form<?= $orf_id; ?>"></td>
    <td><img src="<?php echo $base_url.$ft_objects[$f]['fs_thumbnail'];?>" alt="thumbnail" style="width:100px;height:100px;"></td>
    <td><input type="text" class="form-control form-control-sm text-center" name="multiplicator[]" value="" style="width:5em;" form="save_furniture_layer_form<?= $orf_id; ?>"></td>
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