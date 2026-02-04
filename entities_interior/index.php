<?php
session_start();
include('../functions.php');

$prod = new Production;

include('../header2.php');
include('../menu.php');

$prod = new Production;

$o_id=$prod->xss_fix($_GET['o_id']);

$all_interior_entities=$prod->get_all_interior_entities($o_id);
$all_entities_status=$prod->get_all_entities_status();
?>

  <div class="container-fluid mt-4">
    <div class="row mt-4">
      
        <div class="col-md-1">
          <button class="btn btn-primary" data-toggle="modal" data-target="#addInteriorEntityModal">Create new entity
          </button>
        </div>
        <div class="col-md-auto">
          <b>You are here: o_id <?php echo $o_id;
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
            <th scope="col">Level</th>
            <th scope="col">Name</th>
            <th scope="col">Total size</th>      
            <th scope="col">Usable size</th>
            <th scope="col">Price</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
          </thead>
          <tbody id="table-body">
            <?php
            for($e=0;$e<count($all_interior_entities);$e++)
            {
            ?>
          <tr id="row<?= $all_interior_entities[$e]['e_n_id']; ?>">
            <th scope="row"><?= $all_interior_entities[$e]['e_n_id']; ?></th>
            <td><?= $all_interior_entities[$e]['o_id']; ?></td>
            <td><?= $all_interior_entities[$e]['e_n_level']; ?></td>
            <td><?= $all_interior_entities[$e]['e_n_name']; ?></td>
            <td><?= $all_interior_entities[$e]['e_n_size_total']; ?></td>
            
            <td><?= $all_interior_entities[$e]['e_n_size_usable'] ?></td>
            <td><?= $all_interior_entities[$e]['e_n_price'] ?></td>
            <td><?php             
            echo $entity_status=$prod->get_entities_status($all_interior_entities[$e]['e_n_status'])['est_name']; ?></td>
            <td>
            <button type="button" class="btn btn-sm btn-warning mb-md-2 mb-lg-0 edit-fto-btn" data-toggle="modal"
            data-target="#editInteriorEntitiesModal<?= $all_interior_entities[$e]['e_n_id']; ?>"                 
            >
              Edit
            </button>
            <div class="modal fade" id="editInteriorEntitiesModal<?= $all_interior_entities[$e]['e_n_id']; ?>" tabindex="-1" aria-labelledby="editEntityModalLabel<?= $all_interior_entities[$e]['e_n_id']; ?>"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEntityModalLabel<?= $all_interior_entities[$e]['e_n_id']; ?>">Edit entity id <?= $all_interior_entities[$e]['e_n_id']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="update_entity_form" id="update_entity_form<?php echo $all_interior_entities[$e]['e_n_id'];?>" method="post">
                            <input type="hidden" name="e_n_id" value="<?php echo $all_interior_entities[$e]['e_n_id'];?>">
                            
                            <div class="form-group">
                                <label for="update_e_n_level_input">Level</label>
                                <input type="text" class="form-control" id="update_e_n_level_input" name="update_e_n_level_input" placeholder="Level" value="<?php echo $all_interior_entities[$e]['e_n_level'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="update_e_n_level_input">Name</label>
                                <input type="text" class="form-control" id="update_e_n_name_input" name="update_e_n_name_input" placeholder="Name" value="<?php echo $all_interior_entities[$e]['e_n_name'];?>">
                            </div>                               
                            <div class="form-group">
                                <label for="update_e_n_size_total_input">Total size</label>
                                <input type="text" class="form-control" id="update_e_n_size_total_input" name="update_e_n_size_total_input" value="<?php echo $all_interior_entities[$e]['e_n_size_total'];?>" placeholder="Total size">
                            </div>
                            <div class="form-group">
                                <label for="update_e_n_size_usable_input">Usable size</label>
                                <input type="text" class="form-control" id="update_e_n_size_usable_input" name="update_e_n_size_usable_input" value="<?php echo $all_interior_entities[$e]['e_n_size_usable'];?>" placeholder="Usable size">
                            </div>
                            <div class="form-group">
                                <label for="update_e_n_price_input">Price</label>
                                <input type="text" class="form-control" id="update_e_n_price_input" name="update_e_n_price_input" value="<?php echo $all_interior_entities[$e]['e_n_price'];?>" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <label for="update_e_n_status_input">Status</label>
                                <select class="custom-select" id="update_e_n_status_input" name="update_e_n_status_input" required>
                                    <option selected disabled>Choose...</option>
                                    <?php foreach ($all_entities_status as $entity_status): ?>
                                        <option value="<?= $entity_status['est_id']; ?>" <?php echo ($all_interior_entities[$e]['e_n_status']==$entity_status['est_id'])?"selected":"";?>><?= $entity_status['est_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="save_interior_entity_btn<?php echo $all_interior_entities[$e]['e_n_id'];?>" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


        <script>

            $('#save_interior_entity_btn<?php echo $all_interior_entities[$e]['e_n_id'];?>').click(() => {

              frm= new FormData($('#update_entity_form<?php echo $all_interior_entities[$e]['e_n_id'];?>')[0]);
          

              $.ajax({
                url: '<?= $base_url ?>ajax/update_interior_entity.php',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: frm,
                contentType: false, 
                processData: false,
                success: function (data) {
                  $('#editInteriorEntitiesModal<?= $all_interior_entities[$e]['e_n_id']; ?>').modal('hide');
                
                  setTimeout(function(){window.location = "index.php?o_id=<?php echo $o_id;?>"},1000); //refresh page
                }
              });
            });

        </script>

            <button name="delete_btn" id="delete_btn<?= $all_interior_entities[$e]['e_n_id']; ?>" data-e_n_id="<?= $all_interior_entities[$e]['e_n_id']; ?>"
            type="button" class="btn btn-sm btn-danger delete_btn">Delete
            </button>
            <script type="text/javascript">
              $('#delete_btn<?= $all_interior_entities[$e]['e_n_id']; ?>').click(function(){
                if(confirm('Are you sure you want to delete ?'))
                {
                  let e_n_id=$(this).data('e_n_id');

                  $.ajax({
                    url: "../ajax/delete_e_n_id.php",
                    method: "post",
                    data: {e_n_id:e_n_id},
                    dataType:"html",
                    success:function(data) {
                      	$('#row<?= $all_interior_entities[$e]['e_n_id']; ?>').fadeOut(3000);
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

  <div class="modal fade" id="addInteriorEntityModal" tabindex="-1" aria-labelledby="addInteriorEntityModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInteriorEntityModalLabel">Create new entity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="new_interior_entity_form" id="new_interior_entity_form" method="post">
                    <input type="hidden" name="o_id" value="<?php echo $o_id;?>">                    
                    <div class="form-group">
                        <label for="new_e_n_level_input">Level</label>
                        <input type="text" class="form-control" id="new_e_n_level_input" name="new_e_n_level_input" placeholder="Level">
                    </div>
                    <div class="form-group">
                        <label for="new_e_n_name_input">Name</label>
                        <input type="text" class="form-control" id="new_e_n_name_input" name="new_e_n_name_input" placeholder="Name">
                    </div>                      
                    <div class="form-group">
                        <label for="new_e_n_size_total_input">Total size</label>
                        <input type="text" class="form-control" id="new_e_n_size_total_input" name="new_e_n_size_total_input" placeholder="Total size">
                    </div>
                    <div class="form-group">
                        <label for="new_e_n_size_usable_input">Usable size</label>
                        <input type="text" class="form-control" id="new_e_n_size_usable_input" name="new_e_n_size_usable_input" placeholder="Usable size">
                    </div>
                    <div class="form-group">
                        <label for="new_e_n_price_input">Price</label>
                        <input type="text" class="form-control" id="new_e_n_price_input" name="new_e_n_price_input" placeholder="Price">
                    </div>
                    <div class="form-group">
                        <label for="new_e_n_status_input">Status</label>
                        <select class="custom-select" id="new_e_n_status_input" name="new_e_n_status_input">
                            <option selected disabled>Choose...</option>
                            <?php foreach ($all_entities_status as $entity_status): ?>
                                <option value="<?= $entity_status['est_id'] ?>"><?= $entity_status['est_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="save_interior_entity_btn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>

    $('#save_interior_entity_btn').click(() => {

      frm= new FormData($('#new_interior_entity_form')[0]);
   

      $.ajax({
        url: '<?= $base_url ?>ajax/create_new_interior_entity.php',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: frm,
        contentType: false, 
        processData: false,
        success: function (data) {
          $('#addInteriorEntityModal').modal('hide');
        
          setTimeout(function(){window.location = "index.php?o_id=<?php echo $o_id;?>"},1000); //refresh page
        }
      });
    });

</script>


<?php
include('../footer.php');
?>