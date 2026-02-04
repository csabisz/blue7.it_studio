<?php
session_start();
include('../functions.php');

$prod = new Production;
$page_title="Furniture Objects";
include('../header2.php');
include('../menu.php');

$all_ft_objects = $prod->get_all_ft_objects();
$all_ft_traders = $prod->get_all_ft_traders();
$all_fto_categories = $prod->get_all_fto_categories();
$all_fto_producers = $prod->get_all_fto_producers();
$all_f_sources =$prod->get_all_f_sources();
$all_owners=$prod->get_all_main_clients();
$all_creators=$prod->get_all_creators();
?>

  <div class="container-fluid mt-4">
    <div class="row mt-4">
      <div class="col-12 d-flex justify-content-between">
        <div>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addFurnitureObjectModal">Add new Furniture
            Object
          </button>
        </div>
        <div class="d-md-none d-lg-block">
          <a href="<?=$base_url?>furniture_1_objects/categories/index.php" class="btn btn-primary">Manage Categories</a>
          <button class="btn btn-primary" disabled>Add new Producer</button>
          <button class="btn btn-primary" disabled>Add new Trader</button>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Category</th>
            <th scope="col">Producer</th>
            <th scope="col">Trader</th>
            <th scope="col">Link to trader page</th>
            <th scope="col">Furniture model's source</th>
            <th scope="col">Furniture model's date</th>
            <th scope="col">Furniture model's price</th>
            <th scope="col">Furniture model's remarks</th>
            <th scope="col">Furniture model's thumbnail</th>
            <th scope="col">Owner</th>
            <th scope="col">Creator</th>
            <th scope="col">Actions</th>
          </tr>
          </thead>
          <tbody id="table-body">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function getTableData(){

      $.ajax({
        url: "ajax_get_table.php",
        type: "GET",
        success: function(result){
          $("#table-body").html(result);
        }
      });
    }

    getTableData();

    
  </script>


<?php
include('add_furniture_option_modal.php');
include('edit_furniture_option_modal.php'); 

include('../footer.php');
?>