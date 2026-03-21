<?php
session_start();
include('../functions.php');

$prod = new Production;

$id = $_GET['id'];

$houseset = $prod->get_planset2($id);

$page_title="House-sets ";

if(!empty($houseset['house_name']))
{
  $page_title.=" - ".$houseset['house_name'];
}
include('../header2.php');
include('../menu.php');
$Houuse_id = $prod->xss_fix($_GET['id']);
?>

<?php
if (isset($_POST['updatebtn'])) 
{ //check if form was submitted

  $general_info['house_name'] = $prod->xss_fix($_POST['planset_name']);
  $general_info['owner'] = $prod->xss_fix($_POST['owner'] ?? 0);
  $general_info['mc_id'] = $prod->get_client($prod->xss_fix($_POST['building_company']))['mc_id'];
  $general_info['planset_id'] = $prod->xss_fix($_POST['planset_id']);
  $general_info['object_type'] = $prod->xss_fix($_POST['object_type'] ?? 0);
  $general_info['presentation_id'] = $prod->xss_fix($_POST['presentation_id'] ?? 0);
  $general_info['material_id'] = $prod->xss_fix($_POST['material_id'] ?? 0);
  $general_info['house_description'] = $prod->xss_fix($_POST['planset_description'] ?? '');

  $general_info['base_price'] = $prod->xss_fix($_POST['base_price'] ?? 0);
  $general_info['price_building'] = $prod->xss_fix($_POST['price_building'] ?? 0);
  $general_info['b_price_1'] = $prod->xss_fix($_POST['b_price_1'] ?? 0);
  $general_info['b_price_2'] = $prod->xss_fix($_POST['b_price_2'] ?? 0);
  $general_info['b_price_3'] = $prod->xss_fix($_POST['b_price_3'] ?? 0);
  $general_info['b_price_4'] = $prod->xss_fix($_POST['b_price_4'] ?? 0);
  $general_info['b_price_5'] = $prod->xss_fix($_POST['b_price_5'] ?? 0);

  $general_info['building_company'] = $prod->xss_fix($_POST['building_company'] ?? 0);
  $general_info['id'] = $prod->xss_fix($_POST['id']);

  $measures_order['length'] = $prod->xss_fix($_POST['length'] ?? 0);
  $measures_order['width'] = $prod->xss_fix($_POST['width'] ?? 0);
  $measures_order['surface'] = $prod->xss_fix($_POST['surface'] ?? 0);
  $measures_order['height'] = $prod->xss_fix($_POST['height'] ?? 0);
  $measures_order['sqm_usable_space'] = $prod->xss_fix($_POST['sqm_usable_space'] ?? 0);
  $measures_order['stories'] = $prod->xss_fix($_POST['stories'] ?? 0);
  $measures_order['id'] = $prod->xss_fix($_POST['id']);

  $about_order['presentation_id'] = $prod->xss_fix($_POST['presentation_id']);
  $about_order['roof_type'] = $prod->xss_fix($_POST['roof_type']);
  $about_order['roof_tilt'] = $prod->xss_fix($_POST['roof_tilt']);
  $about_order['stairs'] = $prod->xss_fix($_POST['stairs']);
  $about_order['rooms'] = $prod->xss_fix($_POST['rooms']);
  $about_order['bedrooms'] = $prod->xss_fix($_POST['bedrooms']);
  $about_order['bathrooms'] = $prod->xss_fix($_POST['bathrooms']);
  $about_order['knee_wall'] = $prod->xss_fix($_POST['knee_wall']);
  $about_order['build_in_garag'] = $prod->xss_fix($_POST['build_in_garag']);
  $about_order['id'] = $prod->xss_fix($_POST['id']);

  $prod->edit_planset_general_info(json_encode($general_info));
  $prod->edit_planset_measures_info(json_encode($measures_order));
  $prod->edit_planset_about_order(json_encode($about_order));


  ?>
  <div class="alert alert-success" role="alert">
    <p class="text-center">Saved </p>
  </div>
  <meta http-equiv="refresh" content="1; url=details.php?id=<?php echo $Houuse_id;?>">
  <?php
}
$validextensionpfd = array("pdf", "jpg");
$validextensioncad = array("cad", "ifc", "dwg");
//upload file
$housesets = $prod->get_all_plansets();
$upload_files_dir = "../../../../cseven.eu/public_html/studio/plans_architectural/";

$year = date("Y");


$output_dir = $upload_files_dir . $year . "/" . $Houuse_id;

//if(!is_array($_FILES["myfile"]["name"])) //single file
//{
$plan_object = $prod->show_all_planobjects();
$plan_object_count = count($plan_object);

if(!empty($plan_object))
{
  for ($i = 0; $i < $plan_object_count; $i++) 
  {
    $plan_obj_pdf = "pdffile" . $plan_object[$i]['pl_object_ID'];
    $plan_obj_cad = "cadfile" . $plan_object[$i]['pl_object_ID'];

    if(!empty($_FILES))
    {
      for ($j = 0; $j < count($_FILES[$plan_obj_pdf]['name']); $j++) 
      {

        if (is_uploaded_file($_FILES[$plan_obj_pdf]['tmp_name'][$j])) {
          //$_FILES[$plan_obj]['tmp_name'];
          $original_file_name = $_FILES[$plan_obj_pdf]["name"][$j];

          $tempfile = explode(".", $original_file_name);
          $data["house_id"] = $Houuse_id;
          $data["plan_object"] = $plan_object[$i]['pl_object_ID'];
          $data["file_type"] = strtolower(end($tempfile));

          if (in_array($data["file_type"], $validextensionpfd)) {

            $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $data["file_type"];
            $count_plan_object = $prod->get_plan_object_count($data["plan_object"], $data["house_id"]);
            $data['file_name'] = $data["house_id"] . 'b' . '.' . 'v01.' . $data["plan_object"] . '-' . ++$count_plan_object;


            if (!file_exists($output_dir)) {
              mkdir($output_dir, 0755, true);
            }

            move_uploaded_file($_FILES[$plan_obj_pdf]["tmp_name"][$j], $output_dir . "/" . $internal_file_name);
            //rename($_FILES[$plan_obj]['tmp_name'],$output_dir."/".$internal_file_name);
            $data["file_path"] = $year . "/" . $Houuse_id . "/" . $internal_file_name;
            //$prod->insert_db

            $prod->upload_plans(json_encode($data));
          }
        }
      }

      for ($j = 0; $j < count($_FILES[$plan_obj_cad]['name']); $j++) 
      {
        if (is_uploaded_file($_FILES[$plan_obj_cad]['tmp_name'][$j])) {
          //$_FILES[$plan_obj]['tmp_name'];
          $original_file_name = $_FILES[$plan_obj_cad]["name"][$j];

          $tempfile = explode(".", $original_file_name);
          $data["house_id"] = $Houuse_id;
          $data["plan_object"] = $plan_object[$i]['pl_object_ID'];
          $data["file_type"] = strtolower(end($tempfile));

          if (in_array($data["file_type"], $validextensioncad)) {

            $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $data["file_type"];


            if (!file_exists($output_dir)) {
              mkdir($output_dir, 0755, true);
            }

            move_uploaded_file($_FILES[$plan_obj_cad]["tmp_name"][$j], $output_dir . "/" . $internal_file_name);
            //rename($_FILES[$plan_obj]['tmp_name'],$output_dir."/".$internal_file_name);
            $data["file_path"] = $year . "/" . $Houuse_id . "/" . $internal_file_name;
            //$prod->insert_db

            $prod->upload_plans(json_encode($data));
          }

        }
      }
    }
  }
}
// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";

// print_r($data);
if(!empty($houseset['presentation_id']))
{
$o_info_of_prod = $prod->get_o_infos_allproducts($houseset['presentation_id']);
}
else
{
  $o_info_of_prod = array();
}
?>

  <style>
    #pills-tab .nav-link {
      padding: .5rem 1rem !important;
    }
  </style>
  <section class="top_section">
    <article>
      <div class="container pagecontent bg-white px-0">
        <?php
        if (isset($_COOKIE['client_id'])) 
        {
          ?>
          <p class="w-100 text-center display-4 pt-4"> <?php echo $plan_sp7[$n]['house_id']; ?> House-set
            Details: <?php echo (!empty($houseset['planset_name']))?$houseset['planset_name']:'';
            echo $houseset['house_id']; ?></p>
          <hr class="mb-4" width="450px">
          <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
            <a href="create.php" class="btn btn-sm btn-primary mx-3 border">Add new House-set</a>
            <a href="index.php" class="btn btn-sm btn-primary mx-3 border">List of House-sets</a>
          </div>
          <div class="jumbotron">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>"
                  enctype="multipart/form-data" method="post">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item">
                  <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                     role="tab" aria-controls="pills-home">General
                    Information</a>
                </li>

                <!-- Mouving to Plansets -->
                <li class="nav-item">
                  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                     role="tab" aria-controls="pills-profile" aria-selected="false">Info About House-set
                    ID</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-files-tab" data-toggle="pill" href="#pills-files"
                     role="tab" aria-controls="pills-files" aria-selected="false">Uploaded Files</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-configurator-tab" data-toggle="pill"
                     href="#pills-configurator" role="tab" aria-controls="pills-configurator"
                     aria-selected="false">Konfigurator</a>
                </li>
              </ul>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade  show active" id="pills-home" role="tabpanel"
                     aria-labelledby="pills-home-tab">
                  <div class="row mx-0 w-100">
                    <div class="col-md-12 pt-4 pb-4 border">

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="planset_name">House name
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="planset_name" name="planset_name"
                                 value="<?php echo $houseset['house_name']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="planset_name">Planset ID
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="input-group input-group-sm col-md-6">
                          <input class="form-control" type="text"
                                 id="planset_id" name="planset_id"
                                 value="<?php echo $houseset['planset_id']; ?>">
                          <div class="input-group-append">
                            <a href="https://cseven.eu/studio/plansets/details.php?pls_id=<?= $houseset['planset_id'] ?>"
                               class="btn">Go to planset</a>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <?php
                          $planset = $prod->get_planset_by_pls_id($houseset['planset_id']);

                          echo $planset['pls_name'];
                          ?>
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="object_type">Object type</label>
                        </div>
                        <div class="col-md-6">
                        <select id="object_type" name="object_type" class="form-control form-control-sm">
                              <option value="0">--Object type--</option>
                              <?php
                              $all_object_types=$prod->get_all_object_types();
                              for($o=0;$o<count($all_object_types);$o++)
                              {
                                  ?>
                                  <option value="<?php echo $all_object_types[$o]['ot_id'];?>" <?php echo ($all_object_types[$o]['ot_id']==$houseset['object_type'])?"selected":"";?>><?php echo $all_object_types[$o]['ot_description'];?></option>
                                  <?php
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="presentation_id">Example ID</label>
                        </div>
                        <div class="col-md-5">
                          <input class="form-control form-control-sm" type="text"
                                 id="presentation_id" name="presentation_id"
                                 value="<?php echo $houseset['presentation_id']; ?>">
                        </div>
                        <div class="col-md-2">
                          <?php
                          if(!empty($houseset['presentation_id']))
                          {
                          ?>
                          <a href="http://bauvorschau.com/<?php echo $houseset['presentation_id']; ?>" target="_blank" class="btn btn-sm btn-primary">Presentation</a>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="material_id">Material for new order ID</label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="material_id" name="material_id"
                                 value="<?php echo $houseset['material_id']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="price_building">Building Price
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="price_building" name="price_building"
                                 value="<?php echo $houseset['price_building']; ?>">
                        </div>
                      </div>


                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="b_price_1">Bausatz Price (b_price_1)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="b_price_1" name="b_price_1"
                                 value="<?php echo $houseset['b_price_1']; ?>">
                        </div>
                      </div>


                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="b_price_2">Ausbauhaus Price (b_price_2)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="b_price_2" name="b_price_2"
                                 value="<?php echo $houseset['b_price_2']; ?>">
                        </div>
                      </div>


                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="b_price_3">Technikfertig Price (b_price_3)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="b_price_3" name="b_price_3"
                                 value="<?php echo $houseset['b_price_3']; ?>">
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="b_price_4">Nearly done Price (b_price_4)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="b_price_4" name="b_price_4"
                                 value="<?php echo $houseset['b_price_4']; ?>">
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="b_price_5">Schlüsselfertig Price (b_price_5)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="b_price_5" name="b_price_5"
                                 value="<?php echo $houseset['b_price_5']; ?>">
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="building_company">Building Company
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <select class="custom-select" name="building_company">
                            <option value="0">None</option>
                            <?php

                            $building_company = $prod->get_building_company2();
                            // print_r($building_company);
                            for ($i = 0; $i < count($building_company); $i++) {
                              if (!empty($building_company[$i]['clientname'])) {
                                ?>
                                <option
                                  value="<?php echo $building_company[$i]['builders_id']; ?>" <?php if (($houseset['builders_id']) == $building_company[$i]['builders_id']) {
                                  echo 'selected';
                                } ?>><?php echo $building_company[$i]['clientname']; ?></option>
                                <?php
                              }
                            } ?>
                          </select>

                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="planset_description">Description </label>
                        </div>
                        <div class="col-md-6">
                                                    <textarea class="form-control form-control-sm"
                                                              name="planset_description" id="planset_description"
                                                              cols="10"
                                                              rows="10"><?php echo $houseset['house_description']; ?></textarea>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
                <div class="tab-pane fade" id="pills-files" role="tabpanel"
                     aria-labelledby="pills-files-tab">

                  <br>
                  <h5 class="w-100 text-center display-5 py-2 mb-4">Architectural Files</h5>


                  <div class="row w-100 mx-0">

                    <?php
                    $plan_sp7 = $prod->get_plans_sp7($houseset['house_id']);
                    // print_r($plan_sp7);
                    // echo $houseset['house_id'];
                    ?>
                    <h5 class="w-100 text-center display-5 py-2 mb-4">Uploaded
                      Files: <?php echo count($plan_sp7);
                      echo $plan_obj_abbr = $prod->get_pl_obj_abbr($plan_sp7['plan_kind']); ?></h5>
                    <table class="table table-hover">
                      <?php if (count($plan_sp7) > 0) { ?>
                        <thead>
                        <tr>
                          <th>Plan's object</th>
                          <th>File Name</th>
                          <th>Title</th>
                          <th>File type</th>
                          <th>Country/Area</th>
                          <th>Language</th>
                          <th>Link to file</th>
                          <th>Remove</th>
                        </tr>
                        </thead>
                      <?php } ?>
                      <tbody>
                      <?php

                      $countries = $prod->show_areas();
                      $languages = $prod->get_all_languages();

                      for ($n = 0; $n < count($plan_sp7); $n++) {

                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                          <tr id="pls_row<?php echo $plan_sp7[$n]['plan_id']; ?>">
                            <td>
                              <select class="form-control form-control-sm"
                                      name="plan_object<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      id="plan_object<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      data-plan_id="<?php echo $plan_sp7[$n]['plan_id']; ?>">
                                <option value="">--Select--</option>
                                <?php
                                $plan_objects = $prod->show_all_planobjects();
                                for ($p = 0; $p < count($plan_objects); $p++) {
                                  ?>
                                  <option
                                    value="<?php echo $plan_objects[$p]['pl_object_ID']; ?>" <?php echo ($plan_objects[$p]['pl_object_ID'] == $plan_sp7[$n]['plan_kind']) ? "selected" : ""; ?>><?php echo $prod->get_pl_obj_abbr($plan_objects[$p]['pl_object_ID'])['pl_object_abbr']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                              <script type="text/javascript">
                                $(document).ready(function () {

                                  $('#plan_object<?php echo $plan_sp7[$n]['plan_id']; ?>').on('change', function () {

                                    var plan_id = $(this).data('plan_id');

                                    $.ajax({
                                      url: "../ajax/change_plan_object_kind.php",
                                      method: "post",
                                      data: {
                                        plan_id: plan_id,
                                        plan_kind: $(this).val()
                                      },
                                      dataType: "html",
                                      success: function (data) {

                                      }
                                    });

                                  });

                                });
                              </script>
                            </td>
                            <td>
                              <input type="text"
                                     data-plan_id="<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                     id="file_name<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                     name="file_name"
                                     value="<?php echo $plan_sp7[$n]['file_name']; ?>"
                                     class="form-control form-control-sm text-center">
                              <script type="text/javascript">
                                $(document).ready(function () {

                                  $('#file_name<?php echo $plan_sp7[$n]['plan_id'];?>').on('change focusout', function () {

                                    var plan_id = $(this).data('plan_id');

                                    $.ajax({
                                      url: "../ajax/rename_plan_object_file_name.php",
                                      method: "post",
                                      data: {
                                        plan_id: plan_id,
                                        file_name: $(this).val()
                                      },
                                      dataType: "html",
                                      success: function (data) {

                                      }
                                    });

                                  });

                                });
                              </script>
                            </td>
                            <td>
                              <input type="text"
                                     data-plan_id="<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                     id="title<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                     name="title"
                                     value="<?php echo $plan_sp7[$n]['title']; ?>"
                                     class="form-control form-control-sm text-center">
                              <script type="text/javascript">
                                $(document).ready(function () {

                                  $('#title<?php echo $plan_sp7[$n]['plan_id'];?>').on('change focusout', function () {

                                    var plan_id = $(this).data('plan_id');

                                    $.ajax({
                                      url: "../ajax/rename_plan_object_title.php",
                                      method: "post",
                                      data: {
                                        plan_id: plan_id,
                                        title: $(this).val()
                                      },
                                      dataType: "html",
                                      success: function (data) {

                                      }
                                    });

                                  });

                                });
                              </script>
                            </td>
                            <td>
                              <label for="planset_description"> <?php echo $plan_sp7[$n]['filetype']; ?>  </label>
                            </td>
                            <td>
                              <select id="country<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      data-plan_id="<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      class="form-control form-control-sm">
                                <option value="">--Select--</option>
                                <?php
                                for ($c = 0; $c < count($countries); $c++) {
                                  ?>
                                  <option
                                    value="<?php echo $countries[$c]['a_id']; ?>" <?php echo ($countries[$c]['a_id'] == $plan_sp7[$n]['a_id']) ? "selected" : ""; ?>><?php echo $countries[$c]['area']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                              <script type="text/javascript">
                                $(document).ready(function () {

                                  $('#country<?php echo $plan_sp7[$n]['plan_id'];?>').on('change', function () {

                                    var plan_id = $(this).data('plan_id');

                                    $.ajax({
                                      url: "../ajax/change_plan_object_country.php",
                                      method: "post",
                                      data: {
                                        plan_id: plan_id,
                                        a_id: $(this).val()
                                      },
                                      dataType: "html",
                                      success: function (data) {

                                      }
                                    });

                                  });

                                });
                              </script>
                            </td>
                            <td>
                              <select id="language<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      data-plan_id="<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      class="form-control form-control-sm">
                                <option value="">--Select--</option>
                                <?php
                                for ($l = 0; $l < count($languages); $l++) {
                                  ?>
                                  <option
                                    value="<?php echo $languages[$l]['ln_id']; ?>" <?php echo ($languages[$l]['ln_id'] == $plan_sp7[$n]['lang_id']) ? "selected" : ""; ?>><?php echo $languages[$l]['ln_name']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                              <script type="text/javascript">
                                $(document).ready(function () {

                                  $('#language<?php echo $plan_sp7[$n]['plan_id'];?>').on('change', function () {

                                    var plan_id = $(this).data('plan_id');

                                    $.ajax({
                                      url: "../ajax/change_plan_object_language.php",
                                      method: "post",
                                      data: {
                                        plan_id: plan_id,
                                        lang_id: $(this).val()
                                      },
                                      dataType: "html",
                                      success: function (data) {

                                      }
                                    });

                                  });

                                });
                              </script>
                            </td>
                            <td>
                              <label for="planset_description"> <a
                                  class="btn btn-secondary btn-sm" target="_blank"
                                  href="http://cseven.eu/studio/plans_architectural/<?php echo $plan_sp7[$n]['file_path']; ?>"><i
                                    class="fas fa-directions mr-1"></i>View File</a>
                              </label>
                            </td>
                            <td>
                              <button class="btn btn-danger" name="remove_btn<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      id="remove_btn<?php echo $plan_sp7[$n]['plan_id']; ?>" data-plan_id="<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                      type="button" aria-expanded="true"><i
                                  class="fas fa-trash"></i></button>
                              <script type="text/javascript">
                                $(document).ready(function () {

                                  $('#remove_btn<?php echo $plan_sp7[$n]['plan_id']; ?>').on('click', function () {
                                    if (confirm('Are you sure you want to delete ?')) {
                                           let plan_id = $(this).data('plan_id');

                                           $.ajax({
                                               url: "../ajax/delete_pls_file.php",
                                               method: "post",
                                               data: {
                                                   plan_id: plan_id                                                   
                                               },
                                               dataType: "html",
                                               success: function (data) {
                                                  $('#pls_row<?php echo $plan_sp7[$n]['plan_id']; ?>').fadeOut(2000);
                                               }
                                           });

                                    }
                                  });

                                });
                              </script>
                            </td>
                            <input type="hidden" name="plan_id"
                                   value="<?php echo $plan_sp7[$n]['plan_id']; ?>">
                            <input type="hidden" name="house_id"
                                   value="<?php echo $plan_sp7[$n]['house_id']; ?>">
                          </tr>
                        </form>
                        <?php
                      }
                      if (count($plan_sp7) == 0) { ?>

                        <div class="container">
                          <div class="row">
                            <div class="col-md-12 mt-2">
                              <div class="alert alert-warning" role="alert">
                                <p class="text-center">no uploaded files yet</p>
                              </div>
                            </div>
                          </div>
                        </div>

                      <?php } ?>
                      </tbody>
                    </table>
                    

                  </div>
                  


                  <br>
                  <h5 class="w-100 text-center display-5 py-2 mb-4">Upload new Files</h5>

                  
                  <table class="table table-hover" id="uploadFiles">
                    <thead>
                    <th>Plan object name</th>
                    <th>PDF/JPG file</th>
                    <th>CAD file</th>
                    </thead>
                    <tbody>
                    <tr>
                      <td>p2011 / Section</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2011">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2011[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2011">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2011[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2099 / Others</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2099">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2099[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2099">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2099[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2010 / Foundation</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2010">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2010[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2010">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2010[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2012 / Roofplan</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2012">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2012[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2012">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2012[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2016 / Construction details</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2016">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2016[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfile2016">
                            <label class="file-upload">
                              <input type="file" name="cadfile2016[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2017 / Electrics</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2016">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2016[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2016">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2016[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p20-1 / fp level -1</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep20-1">
                            <label class="file-upload">
                              <input type="file" name="pdffilep20-1[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep20-1">
                            <label class="file-upload">
                              <input type="file" name="cadfilep20-1[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2000 / fp level +/-0</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2000">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2000[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2000">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2000[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2001 / fp level +1</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2001">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2001[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2001">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2001[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2002 / fp level +2</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2002">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2002[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6" id="cadfilep2002">
                            <label class="file-upload">
                              <input type="file" name="cadfilep2002[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>p2003 / fp level +3 or higher</td>

                      <td>
                        <div class="row">
                          <div class="col-md-6" id="pdffilep2003">
                            <label class="file-upload">
                              <input type="file" name="pdffilep2003[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <label class="file-upload" id="cadfilep2003">
                              <input type="file" name="cadfilep2003[]"/>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <a class="text-white addFiles btn btn-sm btn-primary">
                              <i class="fas fa-plus"></i>
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                    </tbody>
                  </table>


                  <div class="row w-100 mx-0 mt-3 d-flex justify-content-center">
                    <div class="col-md-2 d-flex justify-content-end">
                      <div class="center_message w-100">
                        <!-- <button type="submit" name="create_btn" class="btn btn-primary btn-sm btn-block">Create</button>			 -->
                      </div>
                    </div>
                  </div>
                  <!-- </form> -->

                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                     aria-labelledby="pills-profile-tab">

                  <div class="row mx-0 w-100">
                    <div class="col-md-12 pt-4 pb-4 border">

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="length">Depth (cm)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text" id="length"
                                 name="length"
                                 value="<?php echo $houseset['length']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="width">Width (cm)</label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text" id="width"
                                 name="width" value="<?php echo $houseset['width']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="surface">Surface (&#13217;)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text" id="surface"
                                 name="surface"
                                 value="<?php echo $houseset['surface']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="height">Height (cm)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text" id="height"
                                 name="height"
                                 value="<?php echo $houseset['height']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="knee_wall">Knee_wall (cm)
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text" id="knee_wall"
                                 name="knee_wall"
                                 value="<?php echo $o_info_of_prod['knee_wall']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="sqm_usable_space">Square m usable space
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text" id="sqm_usable_space"
                                 name="sqm_usable_space"
                                 value="<?php echo $houseset['sqm_usable_space']; ?>">
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="stories">Stories
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <select class="custom-select" name="stories" id="stories">
                            <option value="0">-- Choose --</option>
                            <option value="1" <?php echo ($houseset['stories'] == 1) ? "selected" : ""; ?>>1</option>
                            <option value="1.5" <?php echo ($houseset['stories'] == 1.5) ? "selected" : ""; ?>>1.5
                            </option>
                            <option value="2" <?php echo ($houseset['stories'] == 2) ? "selected" : ""; ?>>2</option>
                            <option value="2.5" <?php echo ($houseset['stories'] == 2.5) ? "selected" : ""; ?>>2.5
                            </option>
                            <option value="3+" <?php echo ($houseset['stories'] == "3+") ? "selected" : ""; ?>>3+
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="roof_type">Roof Type <?php echo $_POST['roof_type']; ?>
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <!-- <input class="form-control form-control-sm" type="text" id="roof_type" name="roof_type" value="<?php echo $o_info_of_prod['roof_type']; ?>" > -->
                          <select class="custom-select" name="roof_type">
                            <option value="">Roof type option</option>
                            <?php
                            $shapes = $prod->get_all_roof_shapes();
                            for ($i = 0; $i < count($shapes); $i++) {

                              ?>
                              <option
                                value="<?php echo $shapes[$i]['rs_id']; ?>" <?php if (($o_info_of_prod['roof_type']) == $shapes[$i]['rs_id']) {
                                echo 'selected';
                              } ?>><?php echo $shapes[$i]['rs_dbname']; ?></option>
                              <?php
                            } ?>
                          </select>
                        </div>
                      </div>
                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="roof_tilt">Roof Tilt
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="roof_tilt" name="roof_tilt"
                                 value="<?php echo $o_info_of_prod['roof_tilt']; ?>">
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="st_id">Stairs
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <!-- <input class="form-control form-control-sm" type="text" id="roof_type" name="roof_type" value="<?php echo $o_info_of_prod['stairs_id']; ?>" > -->
                          <select class="custom-select" name="stairs">
                            <option value="">Stairs type</option>
                            <?php
                            $stairs = $prod->get_all_type_of_stairs();
                            for ($i = 0; $i < count($stairs); $i++) {
                              ?>
                              <option
                                value="<?php echo $stairs[$i]['st_id']; ?>" <?php if (($o_info_of_prod['stairs_id']) == $stairs[$i]['st_id']) {
                                echo 'selected';
                              } ?>><?php echo $stairs[$i]['st_name']; ?></option>
                              <?php
                            } ?>
                          </select>
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="rooms">Rooms
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text" id="rooms"
                                 name="rooms" value="<?php echo $o_info_of_prod['rooms']; ?>">
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="bedrooms">Bed Rooms
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="bedrooms" name="bedrooms"
                                 value="<?php echo $o_info_of_prod['bedrooms']; ?>">
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="bathrooms">Bath Rooms
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="bathrooms" name="bathrooms"
                                 value="<?php echo $o_info_of_prod['bathrooms']; ?>">
                        </div>
                      </div>

                      <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                          <label for="build_in_garag">Built in Garage
                            <div class="error" style="display:inline-flex;">&nbsp;*</div>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <input class="form-control form-control-sm" type="text"
                                 id="build_in_garag" name="build_in_garag"
                                 value="<?php echo $o_info_of_prod['build_in_garag']; ?>">
                        </div>
                      </div>


                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="pills-configurator" role="tabpanel"
                     aria-labelledby="pills-configurator-tab">

                  <?php
                  $hos = $prod->get_ho_id($Houuse_id);
                  if (!empty($hos)) { ?>

                    <div class="row w-100 mx-0 mt-4">
                      <div class="col-md-4 offset-1">
                        <label for="owner">House order
                          <div class="error" style="display:inline-flex;">&nbsp;*</div>
                        </label>
                      </div>

                      <div class="col-md-6">
                        <select class="custom-select" name="ho_id" id="ho_id">
                          <option value="">None</option>
                          <?php

                          foreach ($hos as $ho) {
                            ?>
                            <option value="<?php echo $ho['ho_id']; ?>">
                              <?= $ho['description'] . ' - ' . $ho['ho_id'] ?></option>
                            <?php
                          } ?>
                        </select>
                      </div>
                    </div>

                    <script>
                      $("#ho_id").change(function () {
                        if ($(this).val() !== '') {
                          console.log('WORK')
                          $.ajax({
                            url: '../ajax/get_configurator_menu_items.php',
                            method: 'get',
                            data: {
                              ho_id: $('#ho_id').val()
                            },
                            dataType: 'html',
                            success: function (data) {
                              $('#menu_item').html(data);
                              $("#menu_item").val($("#menu_item option:first").val());
                              getSwatches()
                            }
                          });
                        }
                      });
                    </script>

                    <div class="row w-100 mx-0 mt-3">
                      <div class="col-md-4 offset-1">
                        <label for="owner">Menu option
                          <div class="error" style="display:inline-flex;">&nbsp;*</div>
                        </label>
                      </div>
                      <div class="col-md-6">
                        <select class="custom-select" name="menu_item" id="menu_item">
                        </select>
                      </div>
                    </div>

                    <div class="row w-100 mx-0 mt-4">
                      <div class="col-md-3">
                        <button type="button" id="2d-konfigurator"
                                class="btn btn-lg btn-primary">2D
                          Konfigurator
                        </button>
                      </div>

                      <div class="col-md-3 offset-6">
                        <button type="button" id="3d-konfigurator"
                                class="btn btn-lg btn-primary disabled">3D
                          Konfigurator
                        </button>
                      </div>
                    </div>

                    <div id="swatches_container">
                    </div>

                  <?php } else { ?>

                    <div class="bg-light p-5 rounded">
                      <h1>Activate House-set</h1>
                      <p class="lead">
                        There is no any house option in our system for this house-set.
                        Click on button below to add standard set of options for this house
                      </p>
                      <button type="button" id="create_ho" class="btn btn-lg btn-primary">
                        Activate
                      </button>
                      <div id="activate_msg"></div>
                    </div>

                    <?php $prod->get_last_ho_id();
                  } ?>

                </div>
              </div>
              <div class="text-center mt-4">
                <input type="hidden" name="id" value="<?php echo $Houuse_id; ?>"/>
                <button class="btn btn-primary" name="updatebtn" type="submit">Update</button>
              </div>
            </form>
          </div>


          <?php
        } 
        else 
        {
          ?>
          <script type="text/javascript">
            Cookies.remove("session_id");
            Cookies.remove("start");
            Cookies.remove("client_id");
            Cookies.remove("client");
            Cookies.remove("own_tasks");
            Cookies.remove("cdesign");
            Cookies.remove("change_vat");
            Cookies.remove("l_first_name");
            Cookies.remove("l_last_name");
            Cookies.remove("c_first_name");
            Cookies.remove("c_last_name");
            Cookies.remove("email");
            Cookies.remove("useradmin");
            Cookies.remove("programs_of_employees");
            Cookies.remove("contracting");
            Cookies.remove("bookkeeping");
            Cookies.remove("coordination");
            Cookies.remove("plansets");
            Cookies.remove("housesets");
            Cookies.remove("plots");
            Cookies.remove("view_all_orders");
            Cookies.remove("activity_view");
            Cookies.remove("apu_lists");
            Cookies.remove("examples_db");
            Cookies.remove("translations");
            Cookies.remove("company");
            Cookies.remove("lt_id");
            Cookies.remove("ip_address");
            Cookies.remove("user_agent");
            Cookies.remove("expire");
          </script>
          <div class="container">
            <div class="center_message">
              <div class="error text-center">You must be logged in to view this page !</div>
              <a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
              <br><br>
            </div>
          </div>
          <meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
          <?php
        }
        ?>
      </div>
    </article>
  </section>


  <script>
    $('#create_ho').on('click', function () {
      $.ajax({
        url: '../ajax/create_ho.php',
        method: 'GET',
        data: {
          house_id: <?php echo $houseset['house_id']?>
        },
        dataType: 'html',
        success: function (data) {
          $('#activate_msg').html(data);
          window.location.reload()
        }
      })
    })


    let configuratorType = '2d'

    $("#2d-konfigurator").on("click", function () {
      configuratorType = "2d";
      console.log(configuratorType);
      getSwatches();

    })

    $("#3d-konfigurator").on("click", function () {
      configuratorType = "3d";
      console.log(configuratorType);
      getSwatches();

    })

    console.log(configuratorType);


    function getSwatches() {

      ajax();

      $("#menu_item").change(function () {
        ajax();
      });

      $("#ho_id").change(function () {
        ajax();
      });

      function ajax() {
        if ($("#menu_item").val() !== '' && $('#ho_id').val() !== '') {
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
      }
    }


  </script>
<?php
include('../footer.php');
?>