<?php
session_start();
include('../functions.php');

$prod = new Production;

$base_url = "https://cseven.eu/studio/";

$all_lt_rooms = $prod->get_all_lt_rooms();
$all_room_kind=$prod->get_all_room_kind();

for($l=0;$l<count($all_lt_rooms);$l++)
{
?>
<tr id="row<?= $all_lt_rooms[$l]['ltr_id']; ?>">
    <th scope="row"><?= $all_lt_rooms[$l]['ltr_id'] ?></th>
    <td><?= $all_lt_rooms[$l]['ltr_name'] ?></td>
    <td><?= $all_lt_rooms[$l]['ltr_description'] ?></td>
    <td><?php     
    $rk_ids=explode(";",$all_lt_rooms[$l]['rk_ids']); 
    
    for($r=0;$r<count($rk_ids);$r++)
    {
      if(!empty($rk_ids[$r]))
      {
        $room_kind=$prod->get_room_kind($rk_ids[$r]);
       
        echo $room_kind['rk_name_english'].", ";
      }
    }
    ?></td>
    <td><?php 
    
    $ft_objects=explode(";",$all_lt_rooms[$l]['ft_objects']);
    
    for($o=0;$o<count($ft_objects);$o++)
    {
      if(!empty($ft_objects[$o]))
      {
        $ft_object=$prod->get_ft_object($ft_objects[$o]);
        
        ?>
        <img src="<?= $base_url.$ft_object['fs_thumbnail'] ?>" alt="thumbnail" style="width:100px;height:auto;">
        <?php
      }
    }
    ?></td>
    <td>
      <button type="button" class="btn btn-sm btn-warning mb-md-2 mb-lg-0 edit-fto-btn" data-toggle="modal"
              data-target="#editFurnitureLayoutModal<?= $all_lt_rooms[$l]['ltr_id']; ?>"              
      >
        Edit
      </button>
      <?php include('edit_furniture_layout_modal.php'); ?>
      <button id="delete_btn<?= $all_lt_rooms[$l]['ltr_id']; ?>" name="delete_btn" data-ltr_id="<?= $all_lt_rooms[$l]['ltr_id']; ?>"
              type="button" class="btn btn-sm btn-danger delete_btn">Delete
      </button>
      <script type="text/javascript">
    $("#editFurnitureLayoutModal<?= $all_lt_rooms[$l]['ltr_id']; ?>" ).on('shown.bs.modal', function(){
    
      let ltr_id=<?= $all_lt_rooms[$l]['ltr_id']; ?>;
      let saved_ft_objects="<?= $all_lt_rooms[$l]['ft_objects']; ?>";

      $.ajax({
        url: "../ajax/get_existing_fto_categories_on_edit_page.php",
        method: "get",
        data: {
          ltr_id:ltr_id,
          saved_ft_objects:saved_ft_objects
        },
        dataType:"html",
        success:function(result) {
          	
        }
      }).done(function(result){
        $('#accordion_furniture_objects<?= $all_lt_rooms[$l]['ltr_id']; ?>').html(result);
      });

    });

    $('#delete_btn<?= $all_lt_rooms[$l]['ltr_id']; ?>').click(function(){
      if(confirm('Are you sure you want to delete ?'))
      {
        let ltr_id=$(this).data("ltr_id");

        $.ajax({
        url: "../ajax/delete_ft_layout.php",
        method: "post",
        data: {
          ltr_id:ltr_id          
        },
        dataType:"html",
        success:function(result) {
          	
        }
      }).done(function(result){
        $('#row<?= $all_lt_rooms[$l]['ltr_id']; ?>').fadeOut(2000);
      });

        
      }
    });
      </script>
    </td>
  </tr>
<?php
}
?>