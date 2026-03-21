<?php
session_start();
include('../functions.php');

$prod = new Production;

$base_url = "https://cseven.eu/studio/";

$all_furniture_set_4_units = $prod->get_all_furniture_set_4_units();
$all_room_kind=$prod->get_all_room_kind();

for($l=0;$l<count($all_furniture_set_4_units);$l++)
{
?>
<tr id="row<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>">
    <td scope="row"><?= $all_furniture_set_4_units[$l]['ft_3_id'] ?></td>
    <td><?= $all_furniture_set_4_units[$l]['ft_3_name'] ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['bath'])['ltr_name']; ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['bedroom'])['ltr_name']; ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['child'])['ltr_name']; ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['gym'])['ltr_name']; ?></td>    
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['hall'])['ltr_name']; ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['kitchen'])['ltr_name']; ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['living'])['ltr_name']; ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['office'])['ltr_name']; ?></td>
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['technic'])['ltr_name']; ?></td>    
    <td><?php echo $room=$prod->get_lt_2_sets_4_rooms($all_furniture_set_4_units[$l]['toilet'])['ltr_name']; ?></td>    
    <td>
      <button type="button" class="btn btn-sm btn-warning mb-md-2 mb-lg-0 edit-fto-btn" data-toggle="modal"
              data-target="#editFurnitureLayoutModal<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>"              
      >
        Edit
      </button>
      <?php include('edit_furniture_layout_modal.php'); ?>
      <button id="delete_btn<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>" name="delete_btn" data-ft_3_id="<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>"
              type="button" class="btn btn-sm btn-danger delete_btn">Delete
      </button>
      <script type="text/javascript">
    $("#editFurnitureLayoutModal<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>" ).on('shown.bs.modal', function(){
    
      let ft_3_id=<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>;
      let saved_ft_objects="<?= $all_furniture_set_4_units[$l]['ft_objects']; ?>";

      $.ajax({
        url: "../ajax/get_existing_fto_categories_on_edit_page.php",
        method: "get",
        data: {
          ft_3_id:ft_3_id,
          saved_ft_objects:saved_ft_objects
        },
        dataType:"html",
        success:function(result) {
          	
        }
      }).done(function(result){
        $('#accordion_furniture_objects<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>').html(result);
      });

    });

    $('#delete_btn<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>').click(function(){
      if(confirm('Are you sure you want to delete ?'))
      {
        let ft_3_id=$(this).data("ft_3_id");

        $.ajax({
        url: "../ajax/delete_furniture_set_4_units.php",
        method: "post",
        data: {
          ft_3_id:ft_3_id          
        },
        dataType:"html",
        success:function(result) {
          	
        }
      }).done(function(result){
        $('#row<?= $all_furniture_set_4_units[$l]['ft_3_id']; ?>').fadeOut(2000);
      });

        
      }
    });
      </script>
    </td>
  </tr>
<?php
}
?>