<div class="modal fade" id="addFurnitureObjectModal" tabindex="-1" aria-labelledby="addFurnitureObjectModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFurnitureObjectModalLabel">Add Furniture Object</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="new_ft_objects_form" id="new_ft_objects_form" method="post">

                    <div class="form-group">
                        <label for="new_fto_name_input">Name</label>
                        <input type="text" class="form-control" id="new_fto_name_input" name="new_fto_name_input" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label for="new_fto_description_input">Description</label>
                        <input type="text" class="form-control" id="new_fto_description_input" name="new_fto_description_input" placeholder="Description">
                    </div>

                    <div class="form-group">
                        <label for="new_fto_price_input">Price</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="new_fto_price_input" name="new_fto_price_input" placeholder="0">
                            <div class="input-group-append">
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_fto_category_input">Category</label>
                        <select class="custom-select" id="new_fto_category_input" name="new_fto_category_input">
                            <option selected disabled>Choose...</option>
                            <?php foreach ($all_fto_categories as $fto_category): ?>
                                <option value="<?= $fto_category['ftoc_id'] ?>"><?= $fto_category['ftoc_description'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="new_fto_producer_input">Producer</label>
                        <select class="custom-select" id="new_fto_producer_input" name="new_fto_producer_input">
                            <option selected disabled>Choose...</option>
                            <?php foreach ($all_fto_producers as $fto_producer): ?>
                                <option value="<?= $fto_producer['ftop_id'] ?>"><?= $fto_producer['ftop_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="new_fto_trader_input">Trader</label>
                        <select class="custom-select" id="new_fto_trader_input" name="new_fto_trader_input">
                            <option selected disabled>Choose...</option>
                            <?php foreach ($all_ft_traders as $ft_trader): ?>
                                <option value="<?= $ft_trader['ftt_id'] ?>"><?= $ft_trader['ftt_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="new_link_to_trader_input">Link to trader page</label>
                        <input type="text" class="form-control" id="new_link_to_trader_input" name="new_link_to_trader_input" placeholder="Link to trader page">
                    </div>

                    <div class="form-group">
                        <label for="new_f_source_input">Furniture model's source</label>
                        <select class="custom-select" id="new_f_source_input" name="new_f_source_input">
                        <option selected disabled>Choose...</option>
                        <?php foreach ($all_f_sources as $f_source): ?>
                            <option value="<?= $f_source['fs_id'] ?>"><?= $f_source['fs_name'] ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_creator_input">Creator</label>
                        <select class="custom-select" id="new_creator_input" name="new_creator_input">
                        <option selected disabled>Choose...</option>
                        <?php foreach ($all_creators as $client): 
                            $creator_qualification=$prod->get_client_qualifications($client['client_ID']);

                            if(($creator_qualification['b5_make_object']>0)||($creator_qualification['b6_make_object']>0)||($creator_qualification['b7_make_object']>0)||($creator_qualification['b8_make_object']>0))
                            {
                            ?>
                            <option value="<?= $client['client_ID'] ?>"><?= $client['c_first_name'].", ".$client['c_last_name'] ?></option>
                        <?php
                            } 
                            endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_fs_date_input">Furniture model's date</label>
                        <input type="text" class="form-control" id="new_fs_date_input" name="new_fs_date_input" placeholder="Furniture source date">
                    </div>

                    <div class="form-group">
                        <label for="new_fs_price_input">Furniture model's price</label>
                        <div class="input-group mb-3">
                        <input type="number" class="form-control" id="new_fs_price_input" name="new_fs_price_input" placeholder="0">
                        <div class="input-group-append">
                            <span class="input-group-text">€</span>
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_fs_remarks_input">Furniture model's remarks</label>
                        <input type="text" class="form-control" id="new_fs_remarks_input" name="new_fs_remarks_input" placeholder="Furniture model's remarks">
                    </div>

                    <div class="form-group">
                        <label for="new_thumbnail_file_input">Furniture model's thumbnail</label>
                        <input type="file" class="form-control-file"  id="new_thumbnail_file_input" name="new_thumbnail_file_input">
                    </div>

                    <!--<div class="form-group">
                        <label for="new_thumbnail_input">Furniture model's thumbnail</label>
                        <input type="text" class="form-control" id="new_thumbnail_input" placeholder="Furniture model's thumbnail">
                    </div> -->

                    <div class="form-group">
                        <label for="new_owner_input">Owner</label>
                        <select class="custom-select" id="new_owner_input" name="new_owner_input">
                        <option selected disabled>Choose...</option>
                        <?php foreach ($all_owners as $owner): 
                            if(($owner['mc_id']==3)||($owner['mc_id']==8)||($owner['mc_id']==13))
                            { ?>
                            <option value="<?= $owner['mc_id'] ?>"><?= $owner['clientname'] ?></option>
                        <?php
                            }
                        endforeach; ?>
                        <option disabled>-------------------------------</option>
                        <?php foreach ($all_owners as $owner): ?>
                            <option value="<?= $owner['mc_id'] ?>"><?= $owner['clientname'] ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="save_new_ft_object" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>

  $(document).ready(function () {

    $('#new_fs_date_input').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
		
	});

    $('#save_new_ft_object').click(() => {

    frm= new FormData($('#new_ft_objects_form')[0]);

      $.ajax({
        url: '<?= $base_url ?>ajax/add_ft_object.php',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: frm,
        contentType: false, 
        processData: false,
        success: function (data) {
          $('#addFurnitureObjectModal').modal('hide');
          //getTableData()
          setTimeout(function(){window.location = "index.php"},1000); //refresh page
        }
      });
    });


  });

</script>