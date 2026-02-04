<div class="modal fade" id="addFurnitureLayoutModal" tabindex="-1" aria-labelledby="addFurnitureLayoutModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFurnitureLayoutModalLabel">Add Furniture Layout 4 Rooms</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="new_lt_rooms_form" id="new_lt_rooms_form" method="post"></form>

                    <div class="form-group">
                        <label for="new_ltr_name"><b>Name</b></label>
                        <input type="text" class="form-control" id="new_ltr_name" name="new_ltr_name" placeholder="Name" form="new_lt_rooms_form">
                    </div>

                    <div class="form-group">
                        <label for="new_ltr_description"><b>Description</b></label>
                        <input type="text" class="form-control" id="new_ltr_description" name="new_ltr_description" placeholder="Description" form="new_lt_rooms_form">
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <b>Choose rooms kind</b>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                        <?php
                        for($r=0;$r<count($all_room_kind);$r++)
                        {
                        ?>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                            <input type="checkbox" class="form-check-input" id="rk_id<?php echo $all_room_kind[$r]['rk_id'];?>" style="margin-left:-1rem" name="new_rk_ids[]" value="<?php echo $all_room_kind[$r]['rk_id'];?>" form="new_lt_rooms_form">
                            <label for="rk_id<?php echo $all_room_kind[$r]['rk_id'];?>"><?php                
                            echo $translation_text=$prod->get_translation_text(1, $all_room_kind[$r]['rk_tx'])['text'];
                            ?></label>
                            </div>
                        </div>
                        <?php
                        }
                        ?>    
                            </div>
                        </div>                    
                    </div>
                    <div class="row">
                    <div class="col-md-auto pt-2">
                        <b>Please choose the category to add more furniture objects</b>
                    </div>
                    </div>
                    <div class="row">
                        <div class="accordion w-100" id="accordion_furniture_objects">
                        <?php
                        $ft_categories=$prod->get_all_fto_categories();
                        
                        for($c=0;$c<count($ft_categories);$c++)
                        {
                            ?>
                            <div class="card-header" id="heading<?php echo $ft_categories[$c]['ftoc_id'];?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" id="category_title<?php echo $ft_categories[$c]['ftoc_id'];?>" data-ftoc_id="<?php echo $ft_categories[$c]['ftoc_id'];?>" data-toggle="collapse" data-target="#collapse<?php echo $ft_categories[$c]['ftoc_id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $ft_categories[$c]['ftoc_id'];?>">
                                <?php echo $ft_categories[$c]['text'];?>
                                </button>
                            </h5>
                            </div>

                            <div id="collapse<?php echo $ft_categories[$c]['ftoc_id'];?>" class="collapse" aria-labelledby="heading<?php echo $ft_categories[$c]['ftoc_id'];?>" <?php //data-parent="#accordion_furniture_objects" ?>>
                            <div id="category_content<?php echo $ft_categories[$c]['ftoc_id'];?>" class="card-body">
                            
                            </div>
                            <script type="text/javascript">
                            $('#category_title<?php echo $ft_categories[$c]['ftoc_id'];?>').click(function(){

                                let fto_category=$(this).data('ftoc_id');

                                $.ajax({
                                url: "<?= $base_url?>ajax/get_ft_objects_by_category_html_for_layouts.php",
                                method: "get",
                                data: {
                                    fto_category:fto_category,
                                                    
                                },
                                dataType: "html",
                                success: function (data) {
                                    $('#category_content<?php echo $ft_categories[$c]['ftoc_id'];?>').html(data);
                                }
                                });
                            });
                            </script>
                            </div>
                        <?php
                        }
                        ?>                        
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="save_new_lt_room" class="btn btn-primary" form="new_lt_rooms_form">Save changes</button>
            </div>
            
        </div>
    </div>
</div>


<script>

  $(document).ready(function () {

    

    $('#save_new_lt_room').click(() => {

        frm= new FormData($('#new_lt_rooms_form')[0]);

      $.ajax({
        url: '<?= $base_url ?>ajax/add_lt_room.php',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: frm,
        contentType: false, 
        processData: false,
        success: function (data) {
            $('#addFurnitureLayoutModal').modal('hide');
            
            setTimeout(function(){window.location = "index.php"},1000); //refresh page
        }
      });
    });


  });

</script>