<?php
session_start();
include('../functions.php');
$prod = new Production;

$_COOKIE['start']=gmdate("Y-m-d H:i:s");
$page_title="Plan-sets - Details";
include('../header2.php');
include('../menu.php');

$pls_id=$prod->xss_fix($_GET['pls_id']);

if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))		
{
    if($_COOKIE['plansets'] > 0)
	{
        	        							
    ?>
    <section class="top_section">
        <article>
        <div class="container text-center pagecontent">
            <h3 class="text-center py-4">Modify Plan-sets ID <?php echo $pls_id;?></h3>
            
            <form id="save_planset_form" name="save_planset_form" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>?pls_id=<?php echo $pls_id;?>" method="post"></form>
            <input type="hidden" name="pls_id" form="save_planset_form" value="<?php echo $pls_id;?>">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php
                    if(isset($_POST['save_btn']))
                    {
                        $save_data['pls_id'] = $prod->xss_fix($_POST['pls_id']);
                        $save_data['pls_presentation_id'] = $prod->xss_fix($_POST['pls_presentation_id']); 
                        $save_data['pls_owner'] = $prod->xss_fix($_POST['pls_owner']); 
                        $save_data['pls_owner1'] = $prod->xss_fix($_POST['pls_owner1']); 
                        $save_data['pls_name'] = $prod->xss_fix($_POST['pls_name']);
                        $save_data['pls_description'] = $prod->xss_fix($_POST['pls_description']); 
                        $save_data['pls_depth'] = $prod->xss_fix($_POST['pls_depth']);
                        $save_data['pls_width'] = $prod->xss_fix($_POST['pls_width']);
                        $save_data['pls_height'] = $prod->xss_fix($_POST['pls_height']);
                        $save_data['pls_surface'] = $prod->xss_fix($_POST['pls_surface']);
                        $save_data['pls_price'] = $prod->xss_fix($_POST['pls_price']);

                        $prod->update_planset(json_encode($save_data));
                    ?>
                    <div class="alert alert-success">
                        Saved successfully !
                    </div>
                    <meta http-equiv="refresh" content="1; url=index.php">
                    <?php
                    }
                    /*
                    if (isset($_POST['remove_btn'])) 
                    {
                        $plan_id = $_POST['plan_id'];
                        $pls_id = $_POST['pls_id'];
                    
                        $prod->delete_plan_by_id($plan_id);
                    
                    
                        ?>
                    
                        <div class="text-center">
                            <div class="alert alert-success">
                                Removed
                            </div>
                        </div>
                        <br>
                        <meta http-equiv="refresh" content="1; url=details.php?pls_id=<?php echo $pls_id; ?>">
                        <?php
                    } */

                    if(isset($_POST['upload_btn']))
                    {
                        $pls_id =$prod->xss_fix($_POST['pls_id']);;

                        $validextensionpfd = array("pdf", "jpg");
                        $validextensioncad = array("cad","dwg","ifc");
                        //upload file
                        
                        $upload_files_dir = "../../../../cseven.eu/public_html/studio/plans_architectural/";

                        $year = date("Y");


                        $output_dir = $upload_files_dir . $year . "/" . $pls_id;

                        //if(!is_array($_FILES["myfile"]["name"])) //single file
                        //{
                        $plan_object = $prod->show_all_planobjects();
                        //count($plan_object);


                        for ($i = 0; $i < count($plan_object); $i++) {
                            $plan_obj_pdf = "pdffile" . $plan_object[$i]['pl_object_ID'];
                            $plan_obj_cad = "cadfile" . $plan_object[$i]['pl_object_ID'];

                            for ($j = 0; $j < count($_FILES[$plan_obj_pdf]['name']); $j++) {

                                if (is_uploaded_file($_FILES[$plan_obj_pdf]['tmp_name'][$j])) {
                                    //$_FILES[$plan_obj]['tmp_name'];
                                    $original_file_name = $_FILES[$plan_obj_pdf]["name"][$j];

                                    $tempfile = explode(".", $original_file_name);
                                    $data["pls_id"] = $pls_id;
                                    $data["plan_object"] = $plan_object[$i]['pl_object_ID'];
                                    $data["file_type"] = strtolower(end($tempfile));

                                    if (in_array($data["file_type"], $validextensionpfd)) {

                                        $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $data["file_type"];
                                        $count_plan_object = $prod->get_plan_object_count($data["plan_object"], $data["pls_id"]);
                                        $data['file_name'] = $data["pls_id"].'a' . '.' . 'v01.' . $data["plan_object"] . '-' . ++$count_plan_object;


                                        if (!file_exists($output_dir)) {
                                            mkdir($output_dir, 0755, true);
                                        }

                                        move_uploaded_file($_FILES[$plan_obj_pdf]["tmp_name"][$j], $output_dir . "/" . $internal_file_name);
                                        //rename($_FILES[$plan_obj]['tmp_name'],$output_dir."/".$internal_file_name);
                                        $data["file_path"] = $year . "/" . $pls_id . "/" . $internal_file_name;
                                        //$prod->insert_db

                                        $prod->upload_plans(json_encode($data));
                                    }
                                }
                            }

                            for ($j = 0; $j < count($_FILES[$plan_obj_cad]['name']); $j++) {
                                if (is_uploaded_file($_FILES[$plan_obj_cad]['tmp_name'][$j])) {
                                    //$_FILES[$plan_obj]['tmp_name'];
                                    $original_file_name = $_FILES[$plan_obj_cad]["name"][$j];

                                    $tempfile = explode(".", $original_file_name);
                                    $data["pls_id"] = $pls_id;
                                    $data["plan_object"] = $plan_object[$i]['pl_object_ID'];
                                    $data["file_type"] = strtolower(end($tempfile));

                                    if (in_array($data["file_type"], $validextensioncad)) {

                                        $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $data["file_type"];


                                        if (!file_exists($output_dir)) {
                                            mkdir($output_dir, 0755, true);
                                        }

                                        move_uploaded_file($_FILES[$plan_obj_cad]["tmp_name"][$j], $output_dir . "/" . $internal_file_name);
                                        //rename($_FILES[$plan_obj]['tmp_name'],$output_dir."/".$internal_file_name);
                                        $data["file_path"] = $year . "/" . $pls_id . "/" . $internal_file_name;
                                        //$prod->insert_db

                                        $prod->upload_plans(json_encode($data));
                                    }

                                }
                            }
                        }
                    ?>
                        <div class="alert alert-success">
                        Saved successfully !
                        </div>
                    <meta http-equiv="refresh" content="1; url=index.php"> 
                    <?php
                    }
                    

                    $planset=$prod->get_planset_by_pls_id($pls_id);	
                    ?>                    
                </div>
            </div>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item active show">
                    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                        role="tab" aria-controls="pills-home" aria-selected="false">Info About Planset-set</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-files-tab" data-toggle="pill" href="#pills-files"
                        role="tab" aria-controls="pills-files" aria-selected="false">Uploaded Files</a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                     aria-labelledby="pills-home-tab">
            <div class="row">
                <div class="col-md-6">
                    <b>Plan-set name</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_name" name="pls_name" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_name'];?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Owner1 (mc_id)</b>
                </div>
                <div class="col-md-3">
                    <input type="text" id="pls_owner1" name="pls_owner1" form="save_planset_form" list="all_main_clients_suggestions" class="form-control form-control-sm" value="<?php echo $planset['pls_owner1'];?>">
                    <datalist id="all_main_clients_suggestions">
                    </datalist>
                    <script type="text/javascript">
                    $(document).ready(function(){ 
                        $('#pls_owner1').on('keyup',function(){

                            let main_client_name=$('#pls_owner1').val();
                            
                            $.ajax({
                                url: "../ajax/get_main_client_suggestions_html.php",
                                method: "get",
                                data: {main_client_name:main_client_name},
                                dataType:"html",
                                success:function(data) {
                                    $('#all_main_clients_suggestions').html(data);                                                            
                                }
                            });

                        });

                        $('#pls_owner1').on('focusout',function(){

                            let mc_id=$('#pls_owner1').val();

                            $.ajax({
                                url: "../ajax/get_main_client.php",
                                method: "get",
                                data: {mc_id:mc_id},
                                dataType:"html",
                                success:function(data) {
                                    $('#main_client_name').html(data);                                                            
                                }
                            });

                        }); 

                    });
                    </script>
                    
                </div>
                <div class="col-md-3 text-left">
                    <label id="main_client_name" for="pls_owner1"><?php 
                    $main_client=$prod->get_main_client($planset['pls_owner1']);
                            
                    echo $main_client['clientname'];
                    ?></label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Owner (client_id)</b>
                </div>
                <div class="col-md-3">
                    <input type="text" id="pls_owner" name="pls_owner" form="save_planset_form" list="all_clients_suggestions" class="form-control form-control-sm" value="<?php echo $planset['pls_owner'];?>">
                    <datalist id="all_clients_suggestions">
                    </datalist>
                    
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('#pls_owner').on('keyup',function(){

                            let name=$('#pls_owner').val();
                            
                            $.ajax({
                                url: "../ajax/get_client_suggestions_html.php",
                                method: "get",
                                data: {client_name:name},
                                dataType:"html",
                                success:function(data) {
                                    $('#all_clients_suggestions').html(data);                                                            
                                }
                            });

                        });

                        $('#pls_owner').on('focusout',function(){

                            let name=$('#pls_owner').val();

                            $.ajax({
                                url: "../ajax/get_client.php",
                                method: "get",
                                data: {uca_id:name},
                                dataType:"html",
                                success:function(data) {
                                    $('#client_name').html(data);                                                            
                                }
                            });

                        });

                    });
                    </script>
                    
                </div>
                <div class="col-md-3 text-left">
                    <label id="client_name" for="pls_owner"><?php 
                    $client=$prod->get_client($planset['pls_owner']);
                    echo $client['clientname']." - ";
                    if(!empty($client['c_last_name']))
                    {
                        echo $client['c_last_name'].", ".$client['c_first_name'];
                    }
                    else
                    {
                        echo $client['l_last_name'].", ".$client['l_first_name'];
                    }
                    ?></label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Presentation ID</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_presentation_id" name="pls_presentation_id" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_presentation_id'];?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <b>Plan-set description</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_description" name="pls_description" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_description'];?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Depth (mm)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_depth" name="pls_depth" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_depth'];?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Width (mm)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_width" name="pls_width" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_width'];?>">
                </div>
            </div><div class="row">
                <div class="col-md-6">
                    <b>Height (mm)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_height" name="pls_height" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_height'];?>">
                </div>
            </div><div class="row">
                <div class="col-md-6">
                    <b>Surface (m<sup>2</sup>)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_surface" name="pls_surface" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_surface'];?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Plan-set Price (APE)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_price" name="pls_price" form="save_planset_form" class="form-control form-control-sm" value="<?php echo $planset['pls_price'];?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" id="save_btn" name="save_btn" form="save_planset_form" class="btn btn-sm btn-primary">Save</div>
                </div>
            </div>
                
            
            <div class="tab-pane fade" id="pills-files" role="tabpanel"
                aria-labelledby="pills-files-tab">

            <br>
            <h5 class="w-100 text-center display-5 py-2 mb-4">Architectural Files</h5>


            <div class="row w-100 mx-0">

                <?php
                $plan_sp7 = $prod->get_pls_files_by_pls_id($pls_id);
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
                            <tr id="plan_file<?php echo $plan_sp7[$n]['plan_id']; ?>">
                                <td>
                                    <select class="form-control form-control-sm" name="plan_object<?php echo $plan_sp7[$n]['plan_id']; ?>" id="plan_object<?php echo $plan_sp7[$n]['plan_id']; ?>" data-plan_id="<?php echo $plan_sp7[$n]['plan_id']; ?>">
                                        <option value="">--Select--</option>
                                        <?php
                                        $plan_objects = $prod->show_all_planobjects();
                                        for($p=0;$p<count($plan_objects);$p++)
                                        {
                                        ?>
                                        <option value="<?php echo $plan_objects[$p]['pl_object_ID'];?>" <?php echo ($plan_objects[$p]['pl_object_ID']==$plan_sp7[$n]['plan_kind'])?"selected":"";?>><?php echo $prod->get_pl_obj_abbr($plan_objects[$p]['pl_object_ID'])['pl_object_abbr'];?></option>
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
                                            <option value="<?php echo $countries[$c]['a_id']; ?>" <?php echo ($countries[$c]['a_id'] == $plan_sp7[$n]['a_id']) ? "selected" : ""; ?>><?php echo $countries[$c]['area']; ?></option>
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
                                            <option value="<?php echo $languages[$l]['ln_id']; ?>" <?php echo ($languages[$l]['ln_id'] == $plan_sp7[$n]['lang_id']) ? "selected" : ""; ?>><?php echo $languages[$l]['ln_name']; ?></option>
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
                                    <button class="btn btn-danger" name="remove_btn<?php echo $plan_sp7[$n]['plan_id']; ?>" id="remove_btn<?php echo $plan_sp7[$n]['plan_id']; ?>"
                                            type="button" data-plan_id="<?php echo $plan_sp7[$n]['plan_id'];?>"><i
                                            class="fas fa-trash" ></i></button>
                                    <script type="text/javascript">
                                        $(document).ready(function () {

                                            $('#remove_btn<?php echo $plan_sp7[$n]['plan_id']; ?>').on('click', function () {
                                                if(confirm('Are you sure you want to delete this file ?'))
                                                {
                                                var plan_id = $('#remove_btn<?php echo $plan_sp7[$n]['plan_id']; ?>').data('plan_id');

                                                $.ajax({
                                                    url: "../ajax/delete_pls_file.php",
                                                    method: "post",
                                                    data: {
                                                        plan_id: plan_id                                                        
                                                    },
                                                    dataType: "html",
                                                    success: function (data) {
                                                        $('#plan_file<?php echo $plan_sp7[$n]['plan_id']; ?>').fadeOut(2000);
                                                    }
                                                 });

                                                }
                                            });

                                        });
                                    </script>
                                </td>
                                <input type="hidden" name="plan_id"
                                        value="<?php echo $plan_sp7[$n]['plan_id']; ?>" form="save_planset_form">
                                <input type="hidden" name="pls_id"
                                        value="<?php echo $plan_sp7[$n]['pls_id']; ?>" form="save_planset_form">
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

            <!-- <form name="update_form" method="post" action="details.php" enctype="multipart/form-data"> -->
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
                                    <input type="file" name="pdffilep2011[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2011[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2099[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2099[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2010[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2010[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2012[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2012[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2016[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2016[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2016[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2016[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep20-1[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep20-1[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2000[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2000[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2001[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2001[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2002[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2002[]" form="save_planset_form">
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
                                    <input type="file" name="pdffilep2003[]" form="save_planset_form">
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
                                    <input type="file" name="cadfilep2003[]" form="save_planset_form">
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
            <div class="row">
                <div class="col-md-12 text-center">
                <button type="submit" id="upload_btn" name="upload_btn" form="save_planset_form" class="btn btn-primary btn-sm">Upload</button>
                </div>
            </div>
<!--
            
             </form> -->

        </div>

            </div>
        </div>
        </article>
    </section>
    <?php
    }
    else
    {
        ?>
        <div class="text-center">				
        <div class="alert alert-danger">Access denied !</div>
        <a href="<?php echo $base_url;?>own_tasks.php" class="btn btn-danger btn-sm">Go to Own tasks</a>
        <br><br>
        </div>
    <meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>own_tasks.php">
    <?php
    
    }
}
else
{
session_unset();
session_destroy();
?>
<div class="text-center">				
    <div class="alert alert-danger">You must be logged in to view this page !</div>
    <a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
    <br><br>
</div>
<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
<?php
}		

include('../footer.php');
?>
