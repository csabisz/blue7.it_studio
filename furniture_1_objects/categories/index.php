<?php
session_start();
include('../../functions.php');

$prod = new Production;

include('../../header2.php');
include('../../menu.php');

$all_ft_objects = $prod->get_all_ft_objects();
$all_ft_traders = $prod->get_all_ft_traders();
$all_fto_categories = $prod->get_all_fto_categories();
$all_fto_producers = $prod->get_all_fto_producers();


?>

  <script src="<?=$base_url?>furniture_1_objects/js/sortableTable.js"></script>

  <div class="container mt-4">
    <div class="row mt-4">
      <div class="col-12 d-flex justify-content-between">
        <div>
          <button class="btn btn-primary" data-toggle="modal" data-target="#add-modal">
            <i class="fa-solid fa-plus"></i>
            Add new Category
          </button>
        </div>
        <div class="d-md-none d-lg-block">
          <a href="<?= $base_url ?>furniture_1_objects/index.php" class="btn btn-primary">
            Furniture Objects
          </a>
          <button class="btn btn-primary" disabled>Add new Producer</button>
          <button class="btn btn-primary" disabled>Add new Trader</button>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-3">

        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-search"></i></span>
          </div>
          <input oninput="searchTable(0, this.value)" type="text" class="form-control" placeholder="Search By ID">
        </div>

      </div>

      <div class="col-3">

        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-search"></i></span>
          </div>
          <input oninput="searchTable(1, this.value)" type="text" class="form-control" placeholder="Search By Name">
        </div>

      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <table class="table table-bordered table-striped" id="table">
          <thead class="thead-dark">
          <tr>
            <th onclick="sortTable(0, 'number')" scope="col"><a href="#" >#</a></th>
            <th onclick="sortTable(1, 'text')" scope="col"><a href="#" >Name</a></th>
            <th scope="col">Description</th>
            <th scope="col">Translation (German)</th>
            <th scope="col" class="text-right">Actions</th>
          </tr>
          </thead>
          <tbody id="table-body">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function getTableData() {

      $.ajax({
        url: "ajax_get_table.php",
        type: "GET",
        success: function (result) {
          $("#table-body").html(result);
        }
      });
    }

    getTableData();
    
  </script>




<?php
include('add_category_modal.php');
include('edit_category_modal.php');

include('../footer.php');
?>