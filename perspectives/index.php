<?php
session_start();
include('../functions.php');

$prod = new Production;

include('../header2.php');
include('../menu.php');

$prod = new Production;

$perspectives_data['o_id']=$prod->xss_fix($_GET['o_id']);
$perspectives_data['osub_id']=$prod->xss_fix($_GET['osub_id']);

$perspectives=$prod->get_all_perspectives_for_this_sub_id(json_encode($perspectives_data));


?>

  <div class="container-fluid mt-4">
    <div class="row mt-4">
      
        <div class="col-md-2">
          <button class="btn btn-primary" data-toggle="modal" data-target="#addPerspectiveModal">Create new perspective
          </button>
        </div>
        <div class="col-md-auto">
          <b>You are here: o_id <?php echo $perspectives_data['o_id'].".".$perspectives_data['osub_id'];

          $sub_names_data['o_id']=$perspectives_data['o_id'];
          $sub_names_data['o_sub_id']=$perspectives_data['osub_id'];

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
            <th scope="col">Perspective kind</th>      
            <th scope="col">Perspective name</th>
            <th scope="col">Perpective description</th>
            <th scope="col">Actions</th>
          </tr>
          </thead>
          <tbody id="table-body">
            <?php
            for($r=0;$r<count($perspectives);$r++)
            {
            ?>
          <tr id="row<?= $perspectives[$r]['per_id']; ?>">
            <th scope="row"><?= $perspectives[$r]['per_id'] ?></th>
            <td><?= $perspectives[$r]['o_id'] ?></td>
            <td><?= $perspectives[$r]['osub_id'] ?></td>
            <td><?= $perspectives[$r]['per_kind'] ?></td>
            <td><?= $perspectives[$r]['per_name'] ?></td>
            <td><?= $perspectives[$r]['per_description'] ?></td>
            <td>
            <button type="button" class="btn btn-sm btn-warning mb-md-2 mb-lg-0 edit-fto-btn" data-toggle="modal"
            data-target="#editPerspectiveModal<?= $perspectives[$r]['per_id']; ?>"                 
            >
              Edit
            </button>
            <div class="modal fade" id="editPerspectiveModal<?= $perspectives[$r]['per_id']; ?>" tabindex="-1" aria-labelledby="editPerspectiveModalLabel<?= $perspectives[$r]['per_id']; ?>"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPerspectiveModalLabel<?= $perspectives[$r]['per_id']; ?>">Edit perspective id <?= $perspectives[$r]['per_id']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="update_perspective_form" id="update_perspective_form<?php echo $perspectives[$r]['per_id'];?>" method="post">
                            <input type="hidden" name="per_id" value="<?php echo $perspectives[$r]['per_id'];?>">
                            
                            <div class="form-group">
                                <label for="update_per_kind_input">Perspective kind</label>
                                <input type="text" class="form-control" id="update_per_kind_input" name="update_per_kind_input" placeholder="Perspective kind" value="<?php echo $perspectives[$r]['per_kind'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="update_per_name_input">Perspective name</label>
                                <input type="text" class="form-control" id="update_per_name_input" name="update_per_name_input" value="<?php echo $perspectives[$r]['per_name'];?>" placeholder="Perspective name">
                            </div>
                            <div class="form-group">
                                <label for="update_per_description_input">Perspective description</label>
                                <input type="text" class="form-control" id="update_per_description_input" name="update_per_description_input" value="<?php echo $perspectives[$r]['per_description'];?>" placeholder="Perspective description">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="update_perspective_btn<?php echo $perspectives[$r]['per_id'];?>" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


        <script>

            $('#update_perspective_btn<?php echo $perspectives[$r]['per_id'];?>').click(() => {

              frm= new FormData($('#update_perspective_form<?php echo $perspectives[$r]['per_id'];?>')[0]);
          

              $.ajax({
                url: '<?= $base_url ?>ajax/update_perspective.php',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: frm,
                contentType: false, 
                processData: false,
                success: function (data) {
                  $('#editPerspectiveModal<?= $perspectives[$r]['per_id']; ?>').modal('hide');
                
                  setTimeout(function(){window.location = "index.php?o_id=<?php echo $perspectives_data['o_id'];?>&osub_id=<?php echo $perspectives_data['osub_id'];?>"},1000); //refresh page
                }
              });
            });

        </script>

            <button name="delete_btn" id="delete_btn<?= $perspectives[$r]['per_id']; ?>" data-per_id="<?= $perspectives[$r]['per_id']; ?>"
            type="button" class="btn btn-sm btn-danger delete_btn">Delete
            </button>
            <script type="text/javascript">
              $('#delete_btn<?= $perspectives[$r]['per_id']; ?>').click(function(){
                if(confirm('Are you sure you want to delete ?'))
                {
                  let per_id=$(this).data('per_id');

                  $.ajax({
                    url: "../ajax/delete_per_id.php",
                    method: "post",
                    data: {per_id:per_id},
                    dataType:"html",
                    success:function(data) {
                      	$('#row<?= $perspectives[$r]['per_id']; ?>').fadeOut(3000);
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

  <div class="modal fade" id="addPerspectiveModal" tabindex="-1" aria-labelledby="addPerspectiveModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPerspectiveModalLabel">Create new perspective</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="new_perspective_form" id="new_perspective_form" method="post">
                    <input type="hidden" name="o_id" value="<?php echo $perspectives_data['o_id'];?>">
                    <input type="hidden" name="osub_id" value="<?php echo $perspectives_data['osub_id'];?>">
                    <div class="form-group">
                        <label for="new_per_kind_input">Perspective kind</label>
                        <input type="text" class="form-control" id="new_per_kind_input" name="new_per_kind_input" placeholder="Perspective kind" required>
                    </div>
                    <div class="form-group">
                        <label for="new_per_name_input">Perspective name</label>
                        <input type="text" class="form-control" id="new_per_name_input" name="new_per_name_input" placeholder="Perspective name" required>
                    </div>
                    <div class="form-group">
                        <label for="new_per_description_input">Perspective description</label>
                        <input type="text" class="form-control" id="new_per_description_input" name="new_per_description_input" placeholder="Perspective description">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="save_perspective_btn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>

    $('#save_perspective_btn').click(() => {

      frm= new FormData($('#new_perspective_form')[0]);
   

      $.ajax({
        url: '<?= $base_url ?>ajax/create_new_perspective.php',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: frm,
        contentType: false, 
        processData: false,
        success: function (data) {
          $('#addPerspectiveModal').modal('hide');
        
          setTimeout(function(){window.location = "index.php?o_id=<?php echo $perspectives_data['o_id'];?>&osub_id=<?php echo $perspectives_data['osub_id'];?>"},1000); //refresh page
        }
      });
    });

</script>


<?php
include('../footer.php');
?>