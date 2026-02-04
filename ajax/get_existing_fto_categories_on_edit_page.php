<?php
include('../functions.php');
$prod = new Production;

$flt_id=$prod->xss_fix($_GET['flt_id']);
$saved_ft_objects=explode(";",$prod->xss_fix($_GET['saved_ft_objects']));
$base_url="https://blue7.it/studio/";
$ltr_id=$prod->xss_fix($_GET['ltr_id']);

$ft_categories=$prod->get_all_fto_categories();

for($c=0;$c<count($ft_categories);$c++)
{
    $ft_objects=$prod->get_all_ft_objects_by_category($ft_categories[$c]['ftoc_id']);
    ?>
    <div class="card-header" id="edit_heading_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>">
    <h5 class="mb-0">
        <button class="btn btn-link" type="button" id="edit_category_title_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>" data-flt_id="<?= $flt_id; ?>" data-ltr_id="<?= $ltr_id; ?>" data-saved_ft_objects="<?php echo $prod->xss_fix($_GET['saved_ft_objects']);?>" data-ftoc_id="<?php echo $ft_categories[$c]['ftoc_id'];?>" data-toggle="collapse" data-target="#edit_collapse_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>" aria-expanded="true" aria-controls="edit_collapse_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>">
        <?php echo $ft_categories[$c]['text'];?>
        </button>
    </h5>
    </div>

    <div id="edit_collapse_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>" class="collapse <?php
    for($f=0;$f<count($ft_objects);$f++)
    {
        for($o=0;$o<count($saved_ft_objects);$o++)
        {
        if($saved_ft_objects[$o]==$ft_objects[$f]['fto_id'])
        {
            echo "show";
        }
        }
    }
    ?>" aria-labelledby="edit_heading_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>" <?php //data-parent="#accordion_furniture_objects" ?>>
    <div id="edit_category_content_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>" class="card-body">

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
            <td><input type="checkbox" class="form-check-input" style="margin-left:0;" name="edit_ft_object[]" value="<?php echo $ft_objects[$f]['fto_id'];?>" form="edit_ft_layout_form<?= $flt_id; ?>" <?php 
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

    </div>
    <script type="text/javascript">
    $('#edit_category_title_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>').click(function(){

        let fto_category=$(this).data('ftoc_id');
        let saved_ft_objects=$(this).data('saved_ft_objects');
        let flt_id=$(this).data('flt_id');
        let ltr_id=$(this).data('ltr_id');

        $.ajax({
        url: "<?= $base_url?>ajax/get_ft_objects_by_category_html_for_layouts_edit_page.php",
        method: "get",
        data: {
            fto_category:fto_category,
            saved_ft_objects:saved_ft_objects,
            flt_id:flt_id,
            ltr_id:ltr_id
        },
        dataType: "html",
        success: function (data) {
            $('#edit_category_content_<?= $flt_id; ?>_<?php echo $ft_categories[$c]['ftoc_id'];?>').html(data);
        }
        });
    });
    </script>
    </div>
<?php
}
?> 