<div class="modal fade" id="editFurnitureLayoutModal<?= $all_lt_rooms[$l]['ltr_id']; ?>" tabindex="-1" data-backdrop="static" aria-labelledby="editFurnitureLayoutModalLabel<?= $all_lt_rooms[$l]['ltr_id']; ?>"
     aria-hidden="true">
  <div class="modal-dialog modal-xl" style="max-width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editFurnitureLayoutModalLabel<?= $all_lt_rooms[$l]['ltr_id']; ?>">Edit Furniture Layout <?= $all_lt_rooms[$l]['ltr_id']; ?>: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit_lt_room_form<?= $all_lt_rooms[$l]['ltr_id']; ?>" name="edit_lt_room_form<?= $all_lt_rooms[$l]['ltr_id']; ?>" method="post" enctype="multipart/form-data"></form>

          <div class="form-group">
            <label for="edit_ltr_name">Name</label>
            <input type="text" class="form-control" id="edit_ltr_name" name="edit_ltr_name" value="<?= $all_lt_rooms[$l]['ltr_name']; ?>" placeholder="Name" form="edit_lt_room_form<?= $all_lt_rooms[$l]['ltr_id']; ?>">
          </div>

          <div class="form-group">
            <label for="edit_ltr_description">Description</label>
            <input type="text" class="form-control" id="edit_ltr_description" name="edit_ltr_description" value="<?= $all_lt_rooms[$l]['ltr_description']; ?>" placeholder="Description" form="edit_lt_room_form<?= $all_lt_rooms[$l]['ltr_id']; ?>">
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
              $rk_ids=explode(";",$all_lt_rooms[$l]['rk_ids']);

              for($r=0;$r<count($all_room_kind);$r++)
              {
              ?>
              <div class="col-md-4">
                  <div class="form-group mb-0">
                  <input type="checkbox" class="form-check-input" id="rk_id<?php echo $all_room_kind[$r]['rk_id'];?>" style="margin-left:-1rem" name="edit_rk_ids[]" value="<?php echo $all_room_kind[$r]['rk_id'];?>" form="edit_lt_room_form<?= $all_lt_rooms[$l]['ltr_id']; ?>" <?php 
                  for($k=0;$k<count($rk_ids);$k++)
                  {
                    if($all_room_kind[$r]['rk_id']==$rk_ids[$k])
                    {
                      echo "checked";
                    }
                  }
                  ?>>
                  <label for="rk_id<?php echo $all_room_kind[$r]['rk_id'];?>"><?php                
                  //echo $translation_text=$prod->get_translation_text(1, $all_room_kind[$r]['rk_tx'])['text'];
                  echo $all_room_kind[$r]['rk_name_english'];
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
              <div class="accordion w-100" id="accordion_furniture_objects<?= $all_lt_rooms[$l]['ltr_id']; ?>">
                                 
              </div> 
          </div>
      </div>
      <input type="hidden" name="edit_ltr_id" value="<?= $all_lt_rooms[$l]['ltr_id']; ?>" form="edit_lt_room_form<?= $all_lt_rooms[$l]['ltr_id']; ?>">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save_edit_lt_room<?= $all_lt_rooms[$l]['ltr_id']; ?>" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {


    $('#save_edit_lt_room<?= $all_lt_rooms[$l]['ltr_id']; ?>').click(() => {

      frm= new FormData($('#edit_lt_room_form<?= $all_lt_rooms[$l]['ltr_id']; ?>')[0]);


      $.ajax({
        url: '<?= $base_url ?>/ajax/edit_lt_room.php',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: frm,
        contentType: false, 
        processData: false,
        success: function (data) {
          $('#editFurnitureLayoutModal<?= $all_lt_rooms[$l]['ltr_id']; ?>').modal('hide');
          setTimeout(function(){window.location = "index.php"},1000); 
        }
      });
    });

    

  });

</script>
