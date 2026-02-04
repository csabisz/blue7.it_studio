<div class="modal fade" id="add-modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Furniture Object Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form>

          <div class="form-group">
            <label for="new-name">Name</label>
            <input type="text" class="form-control" id="new-name" placeholder="Name">
          </div>

          <div class="form-group">
            <label for="new-translation">Translation (DE)</label>
            <input type="text" class="form-control" id="new-translation" placeholder="Translation">
            <small class="ml-2">May be added later</small>
          </div>

          <div class="form-group">
            <label for="new-translation">Description</label>
            <input type="text" class="form-control" id="new-description" placeholder="Description">
          </div>

        </form>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save-new-category" class="btn btn-primary">Save changes</button>
      </div>

    </div>
  </div>
</div>


<script>

  $(document).ready(function () {

    $('#save-new-category').click(() => {

      $.ajax({
        url: '<?= $base_url ?>furniture_objects/categories/ajax_add_category.php',
        type: 'POST',
        data: {
          name: $('#new-name').val(),
          description: $('#new-description').val() !== '' ? $('#new-description').val() : $('#new-name').val(),
          translation: $('#new-translation').val(),
        },
        success: function () {
          $('#add-modal').modal('hide');

          Swal.fire({
            title: 'Success',
            text: 'Furniture Object added successfully',
            type: 'success',
            confirmButtonText: 'OK'
          });

          //wat a second
          setTimeout(() => {
            getTableData()

          }, 1000);

        },
        error: function () {
          Swal.fire({
            title: 'Error',
            text: 'Something went wrong',
            type: 'error',
            confirmButtonText: 'OK'
          });
        }
      });
    });


  });

</script>