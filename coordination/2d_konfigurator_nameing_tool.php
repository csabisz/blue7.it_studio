<?php

//From taskdetails.php at line:4544
$file = $result_files[$i];

$producers = [
  [
    'name' => 'Ikea',
    'value' => 'ikea',
  ], [
    'name' => 'Nobilia',
    'value' => 'nobilia',
  ], [
    'name' => 'Prod 1',
    'value' => 'prod_1',
  ], [
    'name' => 'Prod 2',
    'value' => 'prod 2',
  ], [
    'name' => 'Prod 3',
    'value' => 'prod_3',
  ],
  
];

$room_kinds = $prod->get_all_room_kinds_by_language(1);

$furniture_types = $prod->get_all_furniture_types_by_language(1);

$furniture_layer=$prod->get_ft_layer_from_orf_id($file['orf_id']);

$all_ft_objects=$prod->get_all_ft_objects();

$data['o_id']=$o_id;
$data['osub_id']=$osub_id;

$room_kind_special=$prod->get_all_rooms_for_this_sub_id(json_encode($data));
?>

<div class="flex flex-column mx-auto">
  <!--<button class="btn btn-primary btn-sm mt-2 mx-auto" type="button" data-toggle="modal"
          data-target="#file-properties-modal-<?= $file['orf_id'] ?>">Set Image
    Properties <?= $file['orf_id'] ?></button> -->
  <button class="btn btn-primary btn-sm mt-2 mx-auto" type="button" data-toggle="modal"
          data-target="#furniture-layer-modal-<?= $file['orf_id'] ?>">Set Furniture layer <?= $file['orf_id'] ?></button>
  <p class="mt-2"><?= explode('-', $file['orf_name'])[1] ?></p>
</div>

<?php /*
<div class="modal" id="file-properties-modal-<?= $file['orf_id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="max-width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Set Image properties</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img style="max-width: 100% !important; max-height: fit-content"
             src="<?= 'https://blue7.it/studio/result_compress_files/' . $file['orf_compress_path'] ?>"
             alt="image" loading="lazy">

        <div class="row justify-start mt-2">
          <div class="col-2">
            <div class="form-check">
              <input class="form-check-input" type="checkbox"
                     id="toggle-base-layer-<?= $file['orf_id'] ?>">
              <label class="form-check-label" for="toggle-base-layer-<?= $file['orf_id'] ?>">
                Base Layer
              </label>
            </div>
          </div>
        </div>

        <div class="row row-cols-2 mt-2">


          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="room-number-<?= $file['orf_id'] ?>" class="input-group-text">Room
                Number: </label>
            </div>
            <input style="flex: 1 1 auto" id="room-number-<?= $file['orf_id'] ?>" value="1" min="1" max="99"
                   type="number"
                   class="custom-select">
          </div>

          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="room-name-<?= $file['orf_id'] ?>" class="input-group-text">Room Kind: </label>
            </div>
            <select name="room-name" id="room-name-<?= $file['orf_id'] ?>" class="custom-select">
              <?php foreach ($room_kinds as $room_type): ?>
                <option value="<?= $room_type['text_id'] ?>"><?= $room_type['text'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="camera-view-<?= $file['orf_id'] ?>" class="input-group-text">Camera
                View: </label>
            </div>
            <select name="room-name" id="camera-view-<?= $file['orf_id'] ?>" class="custom-select">
              <option value="a">Position 1</option>
              <option value="b">Position 2</option>
              <option value="c">Position 3</option>
              <option value="d">Position 4</option>
            </select>
          </div>


        </div>

        <div class="row row-cols-2 mt-2">


          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="z-index-<?= $file['orf_id'] ?>" class="input-group-text">Z-Index: </label>
            </div>
            <input style="flex: 1 1 auto" id="z-index-<?= $file['orf_id'] ?>" value="1" min="1" max="99"
                   type="number"
                   class="custom-select">
          </div>

          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="furniture-type-<?= $file['orf_id'] ?>" class="input-group-text">Furniture
                Type: </label>
            </div>
            <select name="furniture-type" id="furniture-type-<?= $file['orf_id'] ?>" class="custom-select">
              <?php foreach ($furniture_types as $furniture_type): ?>
                <option value="<?= $furniture_type['text_id'] ?>"><?= $furniture_type['text'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>


        </div>

        <div class="row row-cols-2 mt-2">

          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="producer-<?= $file['orf_id'] ?>" class="input-group-text">Producer: </label>
            </div>
            <select name="producer" id="producer-<?= $file['orf_id'] ?>" class="custom-select">
              <?php foreach ($producers as $producer): ?>
                <option value="<?= $producer['value'] ?>"><?= $producer['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="furniture-name-<?= $file['orf_id'] ?>" class="input-group-text">Furniture Name: </label>
            </div>
            <input type="text" name="furniture-name" id="furniture-name-<?= $file['orf_id'] ?>" class="form-control"/>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save-image-props-<?= $file['orf_id'] ?>" type="button" class="btn btn-primary">Save
          changes
        </button>
      </div>
    </div>
  </div>
</div> */ ?>


<div class="modal" id="furniture-layer-modal-<?= $file['orf_id'] ?>" data-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="max-width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Set Furniture Layer properties</h5>
        <form id="save_furniture_layer_form<?= $file['orf_id']; ?>" name="save_furniture_layer_form<?= $file['orf_id']; ?>" method="post"></form>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img style="max-width: 100% !important; max-height: fit-content"
             src="<?= 'https://blue7.it/studio/result_compress_files/' . $file['orf_compress_path'] ?>"
             alt="image" loading="lazy">
        <div class="row row-cols-2 mt-2">

          <input type="hidden" name="existing_ftl_id" id="existing_ftl_id<?= $file['orf_id']; ?>" form="save_furniture_layer_form<?= $file['orf_id']; ?>" value="<?php echo $furniture_layer['ftl_id'];?>">
          <input type="hidden" name="orf_id" id="orf_id<?= $file['orf_id']; ?>" form="save_furniture_layer_form<?= $file['orf_id']; ?>" value="<?php echo $file['orf_id'];?>">
          <!--<div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="room_id<?= $file['orf_id'] ?>" class="input-group-text">ROOM_ID: </label>
            </div>
            <select class="custom-select" id="room_id<?= $file['orf_id'] ?>" name="room_id" form="save_furniture_layer_form<?= $file['orf_id']; ?>">
                <option value="">--Select--</option>
                <?php
                for($r=0;$r<count($room_kind_special);$r++)
                {
                  ?>
                  <option value="<?php echo $room_kind_special[$r]['room_id'];?>" <?php echo ($furniture_layer['rks_id']==$room_kind_special[$r]['room_id'])?"selected":"";?>><?php 
                  echo "room_id: ".$room_kind_special[$r]['room_id']." room_number: ".$room_kind_special[$r]['room_number'];
                  
                  echo " - ".$translation_text=$prod->get_translation_text(1, $room_kind_special[$r]['rk_id'])['text'];
                  ?></option>
                  <?php
                }
                ?>
            </select>
          </div> -->

          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="camera_view<?= $file['orf_id'] ?>" class="input-group-text">Camera
                View: </label>
            </div>
            <select name="camera_view" id="camera_view<?= $file['orf_id'] ?>" class="custom-select" form="save_furniture_layer_form<?= $file['orf_id']; ?>">
              <option value="">--Select--</option>
              <option value="aan" <?php echo ($furniture_layer['camera_position']=="aan")?"selected":"";?>>Direction aa-n</option>
              <option value="abn" <?php echo ($furniture_layer['camera_position']=="abn")?"selected":"";?>>Direction ab-n</option>
              <option value="bbn" <?php echo ($furniture_layer['camera_position']=="bbn")?"selected":"";?>>Direction bb-n</option>
              <option value="bcn" <?php echo ($furniture_layer['camera_position']=="bcn")?"selected":"";?>>Direction bc-n</option>
              <option value="ccn" <?php echo ($furniture_layer['camera_position']=="ccn")?"selected":"";?>>Direction cc-n</option>
              <option value="cdn" <?php echo ($furniture_layer['camera_position']=="cdn")?"selected":"";?>>Direction cd-n</option>
              <option value="ddn" <?php echo ($furniture_layer['camera_position']=="ddn")?"selected":"";?>>Direction dd-n</option>
              <option value="dan" <?php echo ($furniture_layer['camera_position']=="dan")?"selected":"";?>>Direction da-n</option>
            </select>
          </div>

          <div class="col input-group mb-3">
            <div class="input-group-prepend">
              <label for="z_index<?= $file['orf_id'] ?>" class="input-group-text">Z-Index: </label>
            </div>
            <input style="flex: 1 1 auto" id="z_index<?= $file['orf_id']; ?>" name="z_index" value="<?php echo $furniture_layer['zlevel'];?>" min="1" max="99"
                   type="number"
                   class="custom-select" form="save_furniture_layer_form<?= $file['orf_id']; ?>">
          </div>

        </div> <!--end row -->

        <!--<div class="row row-cols-2 mt-2">-->


          
        <!--</div>-->
        <div class="row row-cols-2 mt-2">
          <div class="col-md-12 input-group mb-3">
              Furniture objects: 
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-12 input-group mb-3">
            <?php 
            $fto_objects=explode(",",$furniture_layer['fto_content']);
            
            
            // for($f=0;$f<count($all_ft_objects);$f++)
            // {
            for($f=0;$f<count($fto_objects);$f++)
            {
              if(!empty($fto_objects[$f]))
              {
              if (strpos($fto_objects[$f], "(") !== false) 
              {
                $multiplicators1=explode("(",$fto_objects[$f]);              
                $ft_object=$prod->get_ft_object($multiplicators1[0]);
                $multiplicators2=explode(")",$multiplicators1[1]);
                $multiplicator=$multiplicators2[0];
              }
              else
              {
                $ft_object=$prod->get_ft_object($fto_objects[$f]);
                $multiplicator=1;
              }

              ?>
              <div class="form-check">
                <div class="d-flex">
                <input class="form-check-input" type="checkbox" value="<?= $ft_object['fto_id'];?>" name="ft_object[]" id="ft_object<?= $file['orf_id']; ?>_<?= $fto_objects[$f];?>" form="save_furniture_layer_form<?= $file['orf_id']; ?>" checked>
                <label class="form-check-label" for="ft_object<?= $file['orf_id']; ?>_<?= $fto_objects[$f];?>">
                <?= $ft_object['fto_name'];?>
                </label>
                <input type="text" name="multiplicator[]" class="form-control form-control-sm" value="<?= $multiplicator;?>" style="width:5em;" form="save_furniture_layer_form<?= $file['orf_id']; ?>">
                </div>
                <label class="form-check-label" for="ft_object<?= $file['orf_id']; ?>_<?= $fto_objects[$f];?>"><?php 
                $ft_category=$prod->get_fto_category($ft_object['fto_category']);
                echo $ft_category['text'];?></label>
              </div>              
              <?php
              }
            }            
            ?>

          </div>
          


        </div>
        <div class="row">
          <div class="col-md-auto pt-2">
            <b>Please choose the category to add more furniture objects</b>
          </div>
          <div class="col-md-3">
            <select class="custom-select" id="all_ft_objects_by_category<?= $file['orf_id']; ?>">
              <option value="">--Select--</option>
              <?php
              $ft_categories=$prod->get_all_fto_categories();
              
              for($c=0;$c<count($ft_categories);$c++)
              {
                ?>
                <option value="<?php echo $ft_categories[$c]['ftoc_id'];?>"><?php echo $ft_categories[$c]['text'];?></option>
                <?php
              }
              ?>
            </select>
            <script type="text/javascript">
              $('#all_ft_objects_by_category<?= $file['orf_id']; ?>').on('change',function(){

                let fto_category=$('#all_ft_objects_by_category<?= $file['orf_id']; ?>').val();

                $.ajax({
                  url: "<?= $base_url?>ajax/get_ft_objects_by_category_html.php",
                  method: "get",
                  data: {
                    fto_category:fto_category,
                    orf_id:<?= $file['orf_id']; ?>                   
                  },
                  dataType: "html",
                  success: function (data) {
                    $('#furniture_objects_by_category<?= $file['orf_id']; ?>').html(data);
                  }
                });
              });
            </script>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div id="furniture_objects_by_category<?= $file['orf_id']; ?>">

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save_furniture_layer<?= $file['orf_id']; ?>" name="save_furniture_layer<?= $file['orf_id']; ?>" type="button" class="btn btn-primary">Save
          changes
        </button>
      </div>
    </div>
  </div>
</div>

<script>


  var filename = "<?= $file['orf_name']?>"
  filenameArray = filename.split(' - ')[1].split('.')
  let isBaseLayer_<?=$file['orf_id']?> = false;

  console.log(filename)
  console.log(filenameArray.length)
  console.log($("#room-number-<?=$file['orf_id']?>"))
  $("#room-number-<?=$file['orf_id']?>").val(parseInt(filenameArray[0].substring(1)));
  $("#room-name-<?=$file['orf_id']?>").val(filenameArray[1]);
  $("#camera-view-<?=$file['orf_id']?>").val(filenameArray[2]);

  if (filenameArray.length === 4) {
    console.log("true")
    $("#toggle-base-layer-<?=$file['orf_id']?>").prop("checked", true);
    $("#furniture-type-<?=$file['orf_id']?>").parent().toggle();
    $("#z-index-<?=$file['orf_id']?>").parent().toggle();
    $("#producer-<?=$file['orf_id']?>").parent().toggle();
    $("#furniture-name-<?=$file['orf_id']?>").parent().toggle();
    isBaseLayer_<?=$file['orf_id']?> = true;
  } else {
    console.log("false")
    $("#z-index-<?=$file['orf_id']?>").val(filenameArray[3]);
    $("#furniture-type-<?=$file['orf_id']?>").val(filenameArray[4]);
    $("#producer-<?=$file['orf_id']?>").val(filenameArray[5]);
    $("#furniture-name-<?=$file['orf_id']?>").val(filenameArray[6]);
  }


  $("#toggle-base-layer-<?=$file['orf_id']?>").click(function () {
    $("#furniture-type-<?=$file['orf_id']?>").parent().toggle();
    $("#z-index-<?=$file['orf_id']?>").parent().toggle();
    $("#producer-<?=$file['orf_id']?>").parent().toggle();
    $("#furniture-name-<?=$file['orf_id']?>").parent().toggle();
    isBaseLayer_<?=$file['orf_id']?> = true;
  })

  $("#save-image-props-<?=$file['orf_id']?>").click(function () {

    const roomName = $("#room-name-<?=$file['orf_id']?>").val();
    const roomNumber = $("#room-number-<?=$file['orf_id']?>").val();
    const furnitureType = $("#furniture-type-<?=$file['orf_id']?>").val();
    const cameraView = $("#camera-view-<?=$file['orf_id']?>").val();
    const zIndex = $("#z-index-<?=$file['orf_id']?>").val();
    const producer = $("#producer-<?=$file['orf_id']?>").val();
    const furnitureName = $("#furniture-name-<?=$file['orf_id']?>").val();

    let orfName = 'r' + roomNumber + '.' + roomName + '.' + cameraView + '.' + zIndex + '.' + furnitureType + '.' + producer + '.' + furnitureName + '.';
    if (isBaseLayer_<?=$file['orf_id']?>) {
      orfName = 'r' + roomNumber + '.' + roomName + '.' + cameraView + '.';
    }

    $.ajax({
      url: "<?= $base_url?>ajax/update_orf_name.php",
      method: "POST",
      data: {
        orf_id: "<?=$file['orf_id']?>",
        orf_name: orfName,
        file_name_first_part: "<?=$file['o_id'] . '.' . $file['osub_id'] . '.' . $file['prod_id'] . ' - ' ?>",
        file_name_last_part: "<?=$file['orf_type_dom']?>"
      },
      dataType: "text",
      success: function (data) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'File name Updated',
          showConfirmButton: false,
          timer: 1500
        })
      }
    });
  })

  $('#save_furniture_layer<?= $file['orf_id'] ?>').click(function(){
    
    let existing_ftl_id=$('#existing_ftl_id<?= $file['orf_id']; ?>').val();
    // let rks_id=$('#rks_id<?= $file['orf_id']; ?>').val();
    // let camera_view=$('#camera_view<?= $file['orf_id']; ?>').val();
    // let z_index=$('#z_index<?= $file['orf_id']; ?>').val();
    // let ft_object=$('input[name=ft_object<?= $file['orf_id']; ?>[]]').val();
    // let multiplicator=$('input[name=multiplicator<?= $file['orf_id']; ?>[]]').val();

    if(existing_ftl_id!="")
    {

      frm= new FormData($('#save_furniture_layer_form<?= $file['orf_id']; ?>')[0]);

      $.ajax({
      url: "<?= $base_url?>ajax/update_ft_layer.php",
      method: "POST",
      data: frm,
      contentType: false, 
      processData: false,      
      success: function (data) {
        console.log(data);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Furniture layer saved',
          showConfirmButton: false,
          timer: 1500
        })
        $('#furniture-layer-modal-<?= $file['orf_id'] ?>').modal('hide');
      }
    });

    }
    else
    {
      frm= new FormData($('#save_furniture_layer_form<?= $file['orf_id']; ?>')[0]);

      $.ajax({
      url: "<?= $base_url?>ajax/add_ft_layer.php",
      method: "POST",
      data: frm,
      contentType: false, 
      processData: false,      
      success: function (data) {
        console.log(data);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Furniture layer saved',
          showConfirmButton: false,
          timer: 1500
        })
        $('#furniture-layer-modal-<?= $file['orf_id'] ?>').modal('hide');

        setTimeout(function(){window.location = "taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>"},1000); //refresh page
      }
    });

    }
  });
</script>