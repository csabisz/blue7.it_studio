<?php

?><?php
session_start();
include('../functions.php');

$prod = new Production;
$page_title="Furniture Set 4 Unit";
include('../header2.php');
include('../menu.php');

$all_room_kind=$prod->get_all_room_kind();
?>

  <div class="container-fluid mt-4">
    <div class="row mt-4">
      <div class="col-12 d-flex justify-content-between">
        <div>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addFurnitureLayoutModal" data-backdrop="static" data-keyboard="false">Add new Furniture set 4 unit</button>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name of s4u</th>
            <th scope="col">s4u bath</th>
            <th scope="col">s4u bedroom small</th>
            <th scope="col">s4u child</th>
            <th scope="col">s4u gym</th>
            <th scope="col">s4u hall</th>            
            <th scope="col">s4u kitchen</th>
            <th scope="col">s4u living</th>
            <th scope="col">s4u office</th>
            <th scope="col">s4u technic</th>
            <th scope="col">s4u toilet</th>            
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
include('add_furniture_layout_modal.php');


include('../footer.php');
?>