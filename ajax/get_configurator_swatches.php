<style>
  .form-control:focus, .form-control:focus {
    box-shadow: none;
  }
</style>

<?php

include('../functions.php');
$prod = new Production;


$option = $_GET['cm_id'];
$ho_id = $_GET['ho_id'];

$url = 'https://bauvorschau.com/index.php/api/all_configurator_swatches/' . $ho_id . '/' . $option;
$swatches = json_decode(file_get_contents($url), 'true');

$swatches_in_row = 0;


foreach ($swatches as $swatch) {

  if ($swatches_in_row === 0) {
    print '<div class="row p-2 m-4 justify-content-center">';
  }

  $swatch_name = '';
  $swatch_pic = '';
  $swatch_id_name = '';
  $swatch_table = '';

  if ($option === 'Walls') {
    $swatch_pic = $swatch['clp_pic'];
    $swatch_name = $swatch['clp_name_db'];
    $swatch_id_name = 'ho_wa_id';
    $swatch_table = 'ho_walls';

  }
  if ($option === 'Windows') {
    $swatch_pic = $swatch['clp_pic'];
    $swatch_name = $swatch['clp_name_db'];
    $swatch_id_name = 'ho_wi_id';
    $swatch_table = 'ho_windows';
  }
  if ($option === 'Doors') {
    $swatch_pic = $swatch['clp_pic'];
    $swatch_name = $swatch['clp_name_db'];
    $swatch_id_name = 'ho_d_id';
    $swatch_table = 'ho_doors';
  }
  if ($option === 'WallsSecond') {
    $swatch_pic = $swatch['clp_pic'];
    $swatch_name = $swatch['clp_name_db'];
    $swatch_id_name = 'ho_ws_id';
    $swatch_table = 'ho_walls-second';
  }
  if ($option === 'Gutters') {
    $swatch_pic = $swatch['gut_pic'];
    $swatch_name = $swatch['gut_name_db'];
    $swatch_id_name = 'ho_gu_id';
    $swatch_table = 'ho_gutters';
  }
  if ($option === 'RoofTiles') {
    $swatch_pic = $swatch['rmp_pic'];
    $swatch_name = $swatch['text'];
    $swatch_id_name = 'ho_rt_id';
    $swatch_table = 'ho_roof-tiles';
  }
  if ($option === 'RoofShape') {
    $swatch_pic = $swatch['rs_pic'];
    $swatch_name = $swatch['text'];
    $swatch_id_name = 'ho_rs_id';
    $swatch_table = 'ho_roof-shape';
  }
  if ($option === 'Fence') {
    $swatch_pic = $swatch['pbp_pic'];
    $swatch_name = $swatch['text'];
    $swatch_id_name = 'ho_f_id';
    $swatch_table = 'ho_fence';
  }
  if ($option === 'DoorsPosition') {
    $swatch_pic = $swatch['dsp_pic'];
    $swatch_name = $swatch['text'];
    $swatch_id_name = 'ho_dp_id';
    $swatch_table = 'ho_door-position';
  }
  if ($option === 'Garages') {
    $swatch_pic = $swatch['cp_pic'];
    $swatch_name = $swatch['text'];
    $swatch_id_name = 'ho_ga_id';
    $swatch_table = 'ho_garages';
  }
  if ($option === 'RoofOverstand') {
    $swatch_pic = $swatch['rop_pic'];
    $swatch_name = $swatch['text'];
    $swatch_id_name = 'ho_ro_id';
    $swatch_table = 'ho_roof-overstand';
  }

  $swatch_id = $swatch[$swatch_id_name];


  ?>

  <div class="col-sm-4">
    <div class="card h-100 w-100 shadow-sm">
      <img class="mt-3 rounded"
           src="https://domenia.cseven.eu/<?php echo $swatch_pic ?>"
           alt="">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center text-wrap">
          <p class="btn btn-sm btn-outline-secondary "><?php echo $swatch_name ?></p>

        </div>
        <div class="d-flex justify-content-between align-items-center">
          <?php if ($swatch['status'] == '0') { ?>
            <button id="activate_sw_<?php echo $swatch_id ?>" type="button" class="btn btn-sm btn-outline-secondary">
              Activate
            </button>
          <?php } else { ?>
            <button id="deactivate_sw_<?php echo $swatch_id ?>" type="button" class="btn btn-sm btn-outline-danger">
              Deactivate
            </button>
          <?php } ?>

          <?php if ($swatch['status'] == '1') { ?>
            <span id="sw-badge-<?= $swatch_id ?>" class="badge badge-success">Active</span>
          <?php } else { ?>
            <span id="sw-badge-<?= $swatch_id ?>" class="badge badge-danger">Disabled</span>
          <?php } ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text">Price</span>
            </div>
            <input class="form-control btn-outline-secondary w-25"
                   value="<?php echo $swatch['price'] ?>" id="price_input_<?php echo $swatch_id ?>">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="update_price<?php echo $swatch_id ?>">Update
              </button>
            </div>
          </div>
        </div>

        <?php if ($option === 'RoofShape') { ?>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Roof Tilt</span>
              </div>
              <input class="form-control btn-outline-secondary w-25"
                     value="<?php echo $swatch['tilt'] ?>">
              <small class="mt-1">*Be careful! This model may not provide multiple roof shapes*</small>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <script>
    $("#update_price<?php echo $swatch_id ?>").click(function () {
      console.log('Changed');
      $.ajax({
        url: '../ajax/change_configurator_price.php',
        method: 'GET',
        data: {
          ho_id: '<?php echo $ho_id ?>',
          table: '<?php echo $swatch_table ?>',
          item_id_name: '<?php echo $swatch_id_name ?>',
          item_id: '<?php echo $swatch_id ?>',
          price: $("#price_input_<?php echo $swatch_id?>").val()
        },
        dataType: 'html',
        success: function (data) {
          $('#swatches_container').prepend(data);
        }
      });
    });

    $("#deactivate_sw_<?php echo $swatch_id ?>").click(function () {
      console.log('Deaactivated');
      let ho_id = '<?php echo $ho_id ?>';
      let table = '<?php echo $swatch_table ?>';
      let item_id_name = '<?php echo $swatch_id_name ?>';
      let item_id = '<?php echo $swatch_id ?>';
      let status = 0;

      ajax(ho_id, table, item_id_name, item_id, status)
    });

    $("#activate_sw_<?php echo $swatch_id ?>").click(function () {
      console.log('Activated');
      let ho_id = '<?php echo $ho_id ?>';
      let table = '<?php echo $swatch_table ?>';
      let item_id_name = '<?php echo $swatch_id_name ?>';
      let item_id = '<?php echo $swatch_id ?>';
      let status = 1;


      ajax(ho_id, table, item_id_name, item_id, status)
    });

    function ajax(ho_id, table, item_id_name, item_id, status) {
      $.ajax({
        url: '../ajax/activate_configurator_swatch.php',
        method: 'GET',
        data: {
          ho_id: ho_id,
          table: table,
          item_id_name: item_id_name,
          item_id: item_id,
          status: status
        },
        dataType: 'html',
        success: function (data) {
          $.ajax({
            url: '../ajax/get_configurator_swatches.php',
            method: 'get',
            data: {
              cm_id: $('#menu_item option:selected').val(),
              ho_id: $('#ho_id').val(),
              conf_type: configuratorType
            },
            dataType: 'html',
            success: function (data) {
              $('#swatches_container').html(data);
            }
          });

        }
      });
    }


  </script>

  <?php

  $swatches_in_row++;

  if ($swatches_in_row === 3) {
    print '</div>';
    $swatches_in_row = 0;

  }

}

?>
