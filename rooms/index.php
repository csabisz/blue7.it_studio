<?php
session_start();
include('../functions.php');

$prod = new Production;

include('../header2.php');
include('../menu.php');

$prod = new Production;

$rooms_data['o_id']=$prod->xss_fix($_GET['o_id']);
$rooms_data['osub_id']=$prod->xss_fix($_GET['osub_id']);

$rooms=$prod->get_all_rooms_for_this_sub_id(json_encode($rooms_data));

$all_room_kinds=$prod->get_all_room_kind();
?>

  <div class="container-fluid mt-4">
    <div class="row mt-4">
      
        <div class="col-md-1">
          <button class="btn btn-primary" data-toggle="modal" data-target="#addRoomModal">Create new room
          </button>
        </div>
        <div class="col-md-auto">
          <b>You are here: o_id <?php echo $rooms_data['o_id'].".".$rooms_data['osub_id'];

          $sub_names_data['o_id']=$rooms_data['o_id'];
          $sub_names_data['o_sub_id']=$rooms_data['osub_id'];

          $subo_name=$prod->check_existing_subid(json_encode($sub_names_data));

          if(!empty($subo_name))
          {
            echo " - ".$subo_name['subo_name'];
          }
          ?></b>
        </div>      
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Order ID</th>
            <th scope="col">Sub id</th>
            <th scope="col">Room number</th>      
            <th scope="col">Room kind</th>
            <th scope="col">Room name</th>
            <th scope="col">Room description</th>
            <th scope="col">Actions</th>
          </tr>
          </thead>
          <tbody id="table-body">
            <?php
            for($r=0;$r<count($rooms);$r++)
            {
            ?>
          <tr id="row<?= $rooms[$r]['room_id']; ?>">
            <th scope="row"><?= $rooms[$r]['room_id'] ?></th>
            <td><?= $rooms[$r]['o_id'] ?></td>
            <td><?= $rooms[$r]['osub_id'] ?></td>
            <td><?= $rooms[$r]['room_number'] ?></td>
            
            <td><?php 
            echo $translation=$prod->get_translation_text(1, $rooms[$r]['rk_id'])['text'];
            ?></td>
            <td><?= $rooms[$r]['room_name'] ?></td>
            <td><?= $rooms[$r]['room_description'] ?></td>
            <td>
            <button type="button" class="btn btn-sm btn-warning mb-md-2 mb-lg-0 edit-fto-btn" data-toggle="modal"
            data-target="#editFurnitureObjectModal<?= $rooms[$r]['room_id']; ?>"                 
            >
              Edit
            </button>
            <div class="modal fade" id="editFurnitureObjectModal<?= $rooms[$r]['room_id']; ?>" tabindex="-1" aria-labelledby="editRoomModalLabel<?= $rooms[$r]['room_id']; ?>"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoomModalLabel<?= $rooms[$r]['room_id']; ?>">Edit room id <?= $rooms[$r]['room_id']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="update_rooms_form" id="update_rooms_form<?php echo $rooms[$r]['room_id'];?>" method="post">
                            <input type="hidden" name="room_id" value="<?php echo $rooms[$r]['room_id'];?>">
                            
                            <div class="form-group">
                                <label for="update_room_number_input">Room number</label>
                                <input type="text" class="form-control" id="update_room_number_input" name="update_room_number_input" placeholder="Room number" value="<?php echo $rooms[$r]['room_number'];?>" required>
                            </div>

                            <div class="form-group">
                                <label for="update_room_kind_input">Room kind</label>
                                <select class="custom-select" id="update_room_kind_input" name="update_room_kind_input" required>
                                    <option selected disabled>Choose...</option>
                                    <?php foreach ($all_room_kinds as $room_kind): ?>
                                        <option value="<?= $room_kind['rk_id']; ?>" <?php echo ($rooms[$r]['rk_id']==$room_kind['rk_id'])?"selected":"";?>><?= $room_kind['rk_name_english'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="update_room_name_input">Room name</label>
                                <input type="text" class="form-control" id="update_room_name_input" name="update_room_name_input" value="<?php echo $rooms[$r]['room_name'];?>" placeholder="Room name">
                            </div>
                            <div class="form-group">
                                <label for="update_room_description_input">Room description</label>
                                <input type="text" class="form-control" id="update_room_description_input" name="update_room_description_input" value="<?php echo $rooms[$r]['room_description'];?>" placeholder="Room description">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="save_room_btn<?php echo $rooms[$r]['room_id'];?>" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


        <script>

            $('#save_room_btn<?php echo $rooms[$r]['room_id'];?>').click(() => {

              frm= new FormData($('#update_rooms_form<?php echo $rooms[$r]['room_id'];?>')[0]);
          

              $.ajax({
                url: '<?= $base_url ?>ajax/update_room.php',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: frm,
                contentType: false, 
                processData: false,
                success: function (data) {
                  $('#editFurnitureObjectModal<?= $rooms[$r]['room_id']; ?>').modal('hide');
                
                  setTimeout(function(){window.location = "index.php?o_id=<?php echo $rooms_data['o_id'];?>&osub_id=<?php echo $rooms_data['osub_id'];?>"},1000); //refresh page
                }
              });
            });

        </script>

            <button name="delete_btn" id="delete_btn<?= $rooms[$r]['room_id']; ?>" data-room_id="<?= $rooms[$r]['room_id']; ?>"
            type="button" class="btn btn-sm btn-danger delete_btn">Delete
            </button>
            <script type="text/javascript">
              $('#delete_btn<?= $rooms[$r]['room_id']; ?>').click(function(){
                if(confirm('Are you sure you want to delete ?'))
                {
                  let room_id=$(this).data('room_id');

                  $.ajax({
                    url: "../ajax/delete_room_id.php",
                    method: "post",
                    data: {room_id:room_id},
                    dataType:"html",
                    success:function(data) {
                      	$('#row<?= $rooms[$r]['room_id']; ?>').fadeOut(3000);
                    }
                  });
                }
              });
            </script>
            </td>
          </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">Create new room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="new_rooms_form" id="new_rooms_form" method="post">
                    <input type="hidden" name="o_id" value="<?php echo $rooms_data['o_id'];?>">
                    <input type="hidden" name="osub_id" value="<?php echo $rooms_data['osub_id'];?>">
                    <div class="form-group">
                        <label for="new_room_number_input">Room number</label>
                        <input type="text" class="form-control" id="new_room_number_input" name="new_room_number_input" placeholder="Room number" required>
                    </div>

                    <div class="form-group">
                        <label for="new_room_kind_input">Room kind</label>
                        <select class="custom-select" id="new_room_kind_input" name="new_room_kind_input" required>
                            <option selected disabled>Choose...</option>
                            <?php foreach ($all_room_kinds as $room_kind): ?>
                                <option value="<?= $room_kind['rk_id'] ?>"><?= $room_kind['rk_name_english'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_room_name_input">Room name</label>
                        <input type="text" class="form-control" id="new_room_name_input" name="new_room_name_input" placeholder="Room name" required>
                    </div>
                    <div class="form-group">
                        <label for="new_room_description_input">Room description</label>
                        <input type="text" class="form-control" id="new_room_description_input" name="new_room_description_input" placeholder="Room description" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="save_room_btn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>

    $('#save_room_btn').click(() => {

      frm= new FormData($('#new_rooms_form')[0]);
   

      $.ajax({
        url: '<?= $base_url ?>ajax/create_new_room.php',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: frm,
        contentType: false, 
        processData: false,
        success: function (data) {
          $('#addRoomModal').modal('hide');
        
          setTimeout(function(){window.location = "index.php?o_id=<?php echo $rooms_data['o_id'];?>&osub_id=<?php echo $rooms_data['osub_id'];?>"},1000); //refresh page
        }
      });
    });

</script>


<?php
include('../footer.php');
?>