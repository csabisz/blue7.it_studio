<?php
session_start();
include('../functions.php');

$prod = new Production;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');

$selected_client_id = $_GET['clientid'];

$client_data = $prod->get_client($selected_client_id);

$client_order_rights = $prod->get_client_order_rights($selected_client_id);

?>

    <section class="top_section">
        <article>

            <main role="main" class="container">

                <!-- Set up client first time -->
                <?php if (empty($client_order_rights)): ?>

                    <div class="jumbotron">

                        <h1>Hang on...</h1>
                        <p class="lead">The rights for this client haven't been set yet. Would you like to set them
                            now?</p>
                        <p class="lead">
                            <b>Client:</b> <?= $client_data['c_first_name'] ?> <?= $client_data['c_last_name'] ?> </p>

                        <a class="btn btn-lg btn-primary" data-toggle="modal" data-target="#defineClientRights">
                            Define rights »</a>

                        <a class="btn btn-lg btn-warning"
                           href="<?= $base_url; ?>client_administration/modify.php?clientid=<?= $selected_client_id ?>"
                           role="button">Go back</a>

                    </div>


                    <div class="modal" id="defineClientRights" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <form method="POST" action="./forms/add_user_order_rights.php">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Rights</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">


                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <button type="button" id="select-all-options-btn"
                                                        class="btn btn-sm btn-primary">
                                                    Select all
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <!-- First col -->
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="roof_type_check_box"
                                                           name="roof_type_check_box">
                                                    <label class="form-check-label" for="roof_type_check_box">
                                                        Roof Type
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="roof_material_check_box"
                                                           name="roof_material_check_box">
                                                    <label class="form-check-label" for="roof_material_check_box">
                                                        Roof Material
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="roof_tilt_check_box"
                                                           name="roof_tilt_check_box">
                                                    <label class="form-check-label" for="roof_tilt_check_box">
                                                        Roof Tilt
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="roof_overstand_check_box"
                                                           name="roof_overstand_check_box">
                                                    <label class="form-check-label" for="roof_overstand_check_box">
                                                        Roof Overtand
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="knee_wall_check_box"
                                                           name="knee_wall_check_box">
                                                    <label class="form-check-label" for="knee_wall_check_box">
                                                        Knee Wall
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="gutters_check_box"
                                                           name="gutters_check_box">
                                                    <label class="form-check-label" for="gutters_check_box">
                                                        Gutters
                                                    </label>
                                                </div>

                                            </div>

                                            <!-- Second col -->
                                            <div class="col-6">


                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="walls_material_check_box"
                                                           name="walls_material_check_box">
                                                    <label class="form-check-label" for="walls_material_check_box">
                                                        Walls Material - 1
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="walls_second_material_check_box"
                                                           name="walls_second_material_check_box">
                                                    <label class="form-check-label"
                                                           for="walls_second_material_check_box">
                                                        Walls Material - 2
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="windows_material_check_box"
                                                           name="windows_material_check_box">
                                                    <label class="form-check-label" for="windows_material_check_box">
                                                        Windows Material
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="door_material_check_box"
                                                           name="door_material_check_box">
                                                    <label class="form-check-label" for="door_material_check_box">
                                                        Door Material
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input rights-check-box" type="checkbox"
                                                           id="door_type_check_box"
                                                           name="door_type_check_box">
                                                    <label class="form-check-label" for="door_type_check_box">
                                                        Door Type
                                                    </label>
                                                </div>

                                            </div>

                                        </div>


                                        <script>
                                            const rightsCheckBoxes = document.querySelectorAll('.rights-check-box')
                                            const selectAllOptionsBtn = document.getElementById('select-all-options-btn');
                                            selectAllOptionsBtn.addEventListener('click', () => {

                                                rightsCheckBoxes.forEach(checkBox => {
                                                    checkBox.checked = true
                                                })

                                            })


                                        </script>

                                        <input type="hidden" name="client_id" value="<?= $selected_client_id ?>">

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                <?php else: ?>

                    <div class="row mt-4">
                        <h2>Rights list (probably unnecessary):</h2>
                    </div>


                    <div class="row mt-2">


                        <!-- First col -->
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="roof_type_check_box"
                                       name="roof_type_check_box"
                                    <?= ($client_order_rights['roof_type'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="roof_type_check_box">
                                    Roof Type
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="roof_material_check_box"
                                       name="roof_material_check_box"
                                    <?= ($client_order_rights['roof_material'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="roof_material_check_box">
                                    Roof Material
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="roof_tilt_check_box"
                                       name="roof_tilt_check_box"
                                    <?= ($client_order_rights['roof_tilt'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="roof_tilt_check_box">
                                    Roof Tilt
                                </label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="roof_overstand_check_box"
                                       name="roof_overstand_check_box"
                                    <?= ($client_order_rights['roof_overstand'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="roof_overstand_check_box">
                                    Roof Overtand
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="knee_wall_check_box"
                                       name="knee_wall_check_box"
                                    <?= ($client_order_rights['knee_wall'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="knee_wall_check_box">
                                    Knee Wall
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="gutters_check_box"
                                       name="gutters_check_box"
                                    <?= ($client_order_rights['gutters'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="gutters_check_box">
                                    Gutters
                                </label>
                            </div>

                        </div>

                        <!-- Second col -->
                        <div class="col-3">


                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="walls_material_check_box"
                                       name="walls_material_check_box"
                                    <?= ($client_order_rights['walls_material'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="walls_material_check_box">
                                    Walls Material - 1
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="walls_second_material_check_box"
                                       name="walls_second_material_check_box"
                                    <?= ($client_order_rights['walls_second_material'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label"
                                       for="walls_second_material_check_box">
                                    Walls Material - 2
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="windows_material_check_box"
                                       name="windows_material_check_box"
                                    <?= ($client_order_rights['windows_material'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="windows_material_check_box">
                                    Windows Material
                                </label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="door_material_check_box"
                                       name="door_material_check_box"
                                    <?= ($client_order_rights['door_material'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="door_material_check_box">
                                    Door Material
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input rights-check-box" type="checkbox"
                                       id="door_type_check_box"
                                       name="door_type_check_box"
                                    <?= ($client_order_rights['door_type'] == '1') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="door_type_check_box">
                                    Door Type
                                </label>
                            </div>


                        </div>

                    </div>

                    <div class="row mt-4">
                        <div class="col-12">

                            <div id="rights-added-success-msg" style="display: none" class="alert alert-success"
                                 role="alert">
                                Rights have been added
                            </div>

                            <div id="rights-removed-success-msg" style="display: none" class="alert alert-success"
                                 role="alert">
                                Rights have been removed
                            </div>

                            <div id="rights-error-msg" style="display: none" class="alert alert-danger"
                                 role="alert">
                                Error have been encountered
                            </div>

                        </div>
                    </div>


                    <script>
                        const rightsCheckBoxes = document.querySelectorAll('.rights-check-box')
                        const errorMsgBox = document.getElementById('rights-error-msg');


                        rightsCheckBoxes.forEach(checkBox => {

                            checkBox.addEventListener('change', () => {

                                if (checkBox.checked) {
                                    $.ajax({
                                        url: './ajax/update_client_order_right.php',
                                        data: {
                                            right: checkBox.name.slice(0, -10),
                                            state: 1,
                                            client_id: '<?=$selected_client_id?>'
                                        },
                                        method: "POST",
                                        success: function () {
                                            document.getElementById('rights-added-success-msg').style.display = 'block';
                                            window.setInterval(() => {
                                                document.getElementById('rights-added-success-msg').style.display = 'none';
                                            }, 2000);
                                        }
                                    }).fail(function () {
                                        errorMsgBox.style.display = 'block';
                                    })
                                } else {

                                    $.ajax({
                                        url: './ajax/update_client_order_right.php',
                                        data: {
                                            right: checkBox.name.slice(0, -10),
                                            state: 0,
                                            client_id: '<?=$selected_client_id?>'
                                        },
                                        method: "POST",
                                        success: function () {
                                            document.getElementById('rights-added-success-msg').style.display = 'block';
                                            window.setInterval(() => {
                                                document.getElementById('rights-added-success-msg').style.display = 'none';
                                            }, 2000);
                                        }
                                    }).fail(function () {
                                        errorMsgBox.style.display = 'block';
                                    })
                                }
                            })
                        })

                    </script>


                    <div class="row mt-4">
                        <h2>Options list for whole organisation (alternative: Specific members of it (client field)):</h2>
                    </div>

                    <style>
                        .nav-item {
                            padding: 0;
                            border-right: 0;
                            margin: 0;
                        }

                        .nav-link {
                            display: block;
                            padding: .5rem 1rem !important;
                        }
                    </style>

                    <nav>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                            <?php if ($client_order_rights['roof_type']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-roof-type-tab" data-toggle="pill"
                                       href="#pills-roof-type"
                                       role="tab" aria-controls="pills-roof-type" aria-selected="true">Roof Type</a>
                                </li>

                            <?php endif; ?>

                            <?php if ($client_order_rights['roof_material']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-roof-material-tab" data-toggle="pill"
                                       href="#pills-roof-material"
                                       role="tab" aria-controls="pills-roof-material" aria-selected="false">Roof
                                        Material</a>
                                </li>

                            <?php endif; ?>

                            <?php if ($client_order_rights['roof_tilt']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-roof-tilt-tab" data-toggle="pill"
                                       href="#pills-roof-tilt"
                                       role="tab" aria-controls="pills-roof-tilt" aria-selected="false">Roof tilt</a>
                                </li>

                            <?php endif; ?>

                            <?php if ($client_order_rights['walls_material']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-walls-material-tab" data-toggle="pill"
                                       href="#pills-walls-material"
                                       role="tab" aria-controls="pills-walls-material" aria-selected="false">Walls
                                        Materials - 1</a>
                                </li>

                            <?php endif; ?>

                            <?php if ($client_order_rights['walls_second_material']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-walls-material-tab" data-toggle="pill"
                                       href="#pills-walls-second-material"
                                       role="tab" aria-controls="pills-walls-material" aria-selected="false">Walls
                                        Materials - 2</a>
                                </li>

                            <?php endif; ?>


                            <?php if ($client_order_rights['door_material']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-door-material-tab" data-toggle="pill"
                                       href="#pills-door-material"
                                       role="tab" aria-controls="pills-door-material" aria-selected="false">Door Materials</a>
                                </li>

                            <?php endif; ?>


                            <?php if ($client_order_rights['windows_material']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-windows-material-tab" data-toggle="pill"
                                       href="#pills-windows-material"
                                       role="tab" aria-controls="pills-windows-material" aria-selected="false">Window Materials</a>
                                </li>

                            <?php endif; ?>

                            <?php if ($client_order_rights['gutters']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-gutters-tab" data-toggle="pill"
                                       href="#pills-gutters"
                                       role="tab" aria-controls="pills-gutters" aria-selected="false">Gutters</a>
                                </li>

                            <?php endif; ?>

                            <?php if ($client_order_rights['door_type']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-door-shapes-tab" data-toggle="pill"
                                       href="#pills-door-shapes"
                                       role="tab" aria-controls="pills-door-shapes" aria-selected="false">Door Shapes</a>
                                </li>

                            <?php endif; ?>


                            <?php if ($client_order_rights['plot_borders']): ?>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-plot-borders-tab" data-toggle="pill"
                                       href="#pills-plot-borders"
                                       role="tab" aria-controls="pills-plot-borders" aria-selected="false">Plot Borders</a>
                                </li>

                            <?php endif; ?>





                        </ul>
                    </nav>


                    <div class="row mt-4">
                        <div class="col-12">

                            <div id="rights-added-success-msg-lower" style="display: none" class="alert alert-success"
                                 role="alert">
                                Rights have been added
                            </div>

                            <div id="rights-removed-success-msg-lower" style="display: none" class="alert alert-success"
                                 role="alert">
                                Rights have been removed
                            </div>

                            <div id="rights-error-msg-lower" style="display: none" class="alert alert-danger"
                                 role="alert">
                                Error have been encountered
                            </div>

                        </div>
                    </div>


                    <div class="tab-content" id="pills-tabContent">

                        <?php if ($client_order_rights['roof_type']): ?>

                            <div class="tab-pane fade show active" id="pills-roof-type" role="tabpanel"
                                 aria-labelledby="pills-roof-type-tab">

                                <?php

                                $roof_shapes = $prod->get_all_roof_shapes();
                                print_r($roof_shapes[0]);
                                ?>
                                <div class="row card-grid">
                                    <?php foreach ($roof_shapes as $shape): ?>

                                        <div class="col-md-4">
                                            <div class="card mb-4 shadow-sm">
                                                <img src="https://domenia.blue7.it/<?= $shape['rs_pic'] ?>"
                                                     style="width: 200px;" alt="">
                                                <div class="d-flex justify-content-between align-items-right">
                                                    <div class="text-block">  <p class="card-text" id="roof-type-text"
                                                                               style="text-align: center !important;"><?= $shape['rs_dbname'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['rs_id'] ?>" class="roof_type"
                                                               id="select" style="margin-left: 15px; padding-bottom: 200px !important; z-index: 1000">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>


                            </div>
                        <?php endif; ?>

                        <?php if ($client_order_rights['roof_material']): ?>

                            <div class="tab-pane fade" id="pills-roof-material" role="tabpanel"
                                 aria-labelledby="pills-roof-material-tab">Roof Material

                                <?php

                                $walls_materials = $prod->get_all_roof_materials();

                                ?>
                                <div class="row card-grid">
                                    <?php foreach ($walls_materials as $shape): ?>
                                        <div class="col-md-4">
                                            <div class="card mb-4 shadow-sm" <?= (empty($shape['rmp_pic'])) ? 'style="height:50px"' : '' ?>>
                                                <?php if (!empty($shape['rmp_pic'])) : ?>
                                                    <img src="https://domenia.blue7.it/<?= $shape['rmp_pic'] ?>"
                                                           alt="">
                                                <?php endif ?>
                                                <div class="card-footer">
                                                    <form>


                                                        <label>

                                                            <div class="text-block"><p class="card-text" id="roof-type-text"
                                                                                       style="text-align: center !important;"><?= $shape['rmp_dbcolor'] ?></p>
                                                                <input type="checkbox"
                                                                       data-option-id="<?= $shape['clp_id'] ?>"
                                                                       class="roof_materials" id="select"
                                                                       style="margin-left: 15px; z-index: 1000";>
                                                        </label>
                                                    </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>


                        <?php endif; ?>

                        <?php if ($client_order_rights['roof_tilt']): ?>

                            <div class="tab-pane fade" id="pills-roof-tilt" role="tabpanel"
                                 aria-labelledby="pills-roof-tilt-tab">Roof Tilt
                            </div>
                        <?php endif; ?>

                        <?php if ($client_order_rights['walls_material']): ?>

                            <div class="tab-pane fade" id="pills-walls-material" role="tabpanel"
                                 aria-labelledby="pills-walls-material-tab">Walls Materials

                                <?php
                                $walls_materials = $prod->join_colors_on_col_pics();
                                echo $walls_materials;
                                ?>
                                <div class="row card-grid">
                                    <?php foreach ($walls_materials as $shape): ?>
                                        <div class="col-md-4">
                                            <div class="card mb-4 shadow-sm" <?= (empty($shape['clp_pic'])) ? 'style="height:50px"' : '' ?>>
                                                <?php if (!empty($shape['clp_pic'])) : ?>
                                                    <img src="https://domenia.blue7.it/<?= $shape['clp_pic'] ?>"
                                                         style="width: 200px;" alt="">
                                                <?php endif ?>
                                                <div class="d-flex justify-content-between align-items-right">
                                                    <div class="text-block"><p class="card-text" id="roof-type-text"
                                                                               style="text-align: center !important;"><?= $shape['clp_name_db'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['clp_id'] ?>"
                                                               class="walls_materials" id="select"
                                                               style="margin-left: 15px; z-index: 1000">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>


                        <?php endif; ?>



                        <?php if ($client_order_rights['walls_second_material']): ?>

                            <div class="tab-pane fade" id="pills-walls-second-material" role="tabpanel"
                                 aria-labelledby="pills-walls-second-material-tab">Walls Materials-2

                                <?php
                                $walls_materials = $prod->join_colors_on_col_pics();
                                echo $walls_materials;
                                ?>
                                <div class="row card-grid">
                                    <?php foreach ($walls_materials as $shape): ?>
                                        <div class="col-md-4">
                                            <div class="card mb-4 shadow-sm" <?= (empty($shape['clp_pic'])) ? 'style="height:50px"' : '' ?>>
                                                <?php if (!empty($shape['clp_pic'])) : ?>
                                                    <img src="https://domenia.blue7.it/<?= $shape['clp_pic'] ?>"
                                                         style="width: 200px;" alt="">
                                                <?php endif ?>
                                                <div class="d-flex justify-content-between align-items-right">
                                                    <div class="text-block"><p class="card-text" id="roof-type-text"
                                                                               style="text-align: center !important;"><?= $shape['clp_name_db'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['clp_id'] ?>"
                                                               class="walls_materials-2" id="select"
                                                               style="margin-left: 15px; z-index: 1000">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>


                        <?php endif; ?>


                        <?php if ($client_order_rights['door_material']): ?>

                            <div class="tab-pane fade" id="pills-door-material" role="tabpanel"
                                 aria-labelledby="pills-door-material-tab">Walls Materials

                                <?php
                                $walls_materials = $prod->join_colors_on_col_pics();
                                echo $walls_materials;
                                ?>
                                <div class="row card-grid">
                                    <?php foreach ($walls_materials as $shape): ?>
                                        <div class="col-md-4">
                                            <div class="card mb-4 shadow-sm" <?= (empty($shape['clp_pic'])) ? 'style="height:50px"' : '' ?>>
                                                <?php if (!empty($shape['clp_pic'])) : ?>
                                                    <img src="https://domenia.blue7.it/<?= $shape['clp_pic'] ?>"
                                                         style="width: 200px;" alt="">
                                                <?php endif ?>
                                                <div class="d-flex justify-content-between align-items-right">
                                                    <div class="text-block"><p class="card-text" id="roof-type-text"
                                                                               style="text-align: center !important;"><?= $shape['clp_name_db'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['clp_id'] ?>"
                                                               class="door_materials" id="select"
                                                               style="margin-left: 15px; z-index: 1000">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>


                        <?php endif; ?>


                        <?php if ($client_order_rights['windows_material']): ?>

                            <div class="tab-pane fade" id="pills-windows-material" role="tabpanel"
                                 aria-labelledby="pills-windows-material-tab">Walls Materials

                                <?php
                                $walls_materials = $prod->join_colors_on_col_pics();
                                echo $walls_materials;
                                ?>
                                <div class="row card-grid">
                                    <?php foreach ($walls_materials as $shape): ?>
                                        <div class="col-md-4">
                                            <div class="card mb-4 shadow-sm" <?= (empty($shape['clp_pic'])) ? 'style="height:50px"' : '' ?>>
                                                <?php if (!empty($shape['clp_pic'])) : ?>
                                                    <img src="https://domenia.blue7.it/<?= $shape['clp_pic'] ?>"
                                                         style="width: 200px;" alt="">
                                                <?php endif ?>
                                                <div class="d-flex justify-content-between align-items-right">
                                                    <div class="text-block"><p class="card-text" id="roof-type-text"
                                                                               style="text-align: center !important;"><?= $shape['clp_name_db'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['clp_id'] ?>"
                                                               class="windows_materials" id="select"
                                                               style="margin-left: 15px; z-index: 1000">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>


                        <?php endif; ?>


                        <?php if ($client_order_rights['gutters']): ?>

                    <div class="tab-pane fade" id="pills-gutters" role="tabpanel"
                         aria-labelledby="pills-gutters-tab">Walls Materials

                        <?php
                        $gut = $prod->get_all_gutters();
                        echo $gut
                        ?>
                        <div class="row card-grid">
                            <?php foreach ($gut as $shape): ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm" style="height: 280px">
                                        <?php if (!empty($shape['gut_pic'])) : ?>
                                            <img src="https://domenia.blue7.it/<?= $shape['gut_pic'] ?>"
                                                 style="width: 200px;" alt="">
                                        <?php endif ?>
                                        <div class="card-footer" style="">
                                            <footer>
                                            <form>
                                                <label>

                                                    <div class="text-block" style="margin-left: -25px; margin-bottom: 20px;"><p class="card-text" id="roof-type-text"
                                                                               style="text-align: center !important;"><?= $shape['gut_name_db'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['gut_id'] ?>"
                                                               class="gutters" id="select"
                                                               style="margin-left: 15px; z-index: 1000";>
                                                </label>
                                        </div>

                                        </form>

                                    </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                     </pre>
                        </div>
                    </div>


                <?php endif; ?>


                <?php if ($client_order_rights['door_type']): ?>

                    <div class="tab-pane fade" id="pills-door-shapes" role="tabpanel"
                         aria-labelledby="pills-door-shapes-tab">Door Shapes

                        <?php
                        $door = $prod->get_all_door_shapes();
                        print_r($door[0]);
                        ?>
                        <div class="row card-grid">
                            <?php foreach ($door as $shape): ?>
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm" id="door_shapes">
                                    <?= (empty($shape['dsp_pic'])) ? '&nbsp&nbsp&nbsp&nbspIMG &nbspMissing' : '' ?>
                                    <?php if (!empty($shape['dsp_pic'])) : ?>
                                        <img src="https://domenia.blue7.it/<?= $shape['dsp_pic'] ?>"
                                             style="width: 100px; object-fit: fill" alt="">
                                    <?php endif ?>
                                    <div class="card-footer" style="">
                                        <footer>
                                            <form>
                                                <label>
                                                    <div class="text-block" style="margin-left: -25px; margin-bottom: 20px;">
                                                        <p class="card-text" id="roof-type-text"
                                                           style="text-align: center !important;"><?= $shape['ds_name_db'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['ds_id'] ?>"
                                                               class="door_shapes" id="select"
                                                               style="margin-left: 15px; z-index: 1000";>
                                                </label>
                                    </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                        </pre>
                    </div>
                    </div>


                <?php endif; ?>

                <?php if ($client_order_rights['plot_borders']): ?>

                    <div class="tab-pane fade" id="pills-plot-borders" role="tabpanel"
                         aria-labelledby="pills-plot-borders-tab">Plot Borders

                        <?php
                        $plot_borders = $prod->get_all_plot_borders();
                        print_r($plot_borders[0]);
                        ?>
                        <div class="row card-grid">
                            <?php foreach ($plot_borders as $shape): ?>
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm" id="door_shapes">
                                    <?= (empty($shape['dsp_pic'])) ? '&nbsp&nbsp&nbsp&nbspIMG &nbspMissing' : '' ?>
                                    <?php if (!empty($shape['dsp_pic'])) : ?>
                                        <img src="https://domenia.blue7.it/<?= $shape['dsp_pic'] ?>"
                                             style="width: 100px; object-fit: fill" alt="">
                                    <?php endif ?>
                                    <div class="card-footer" style="">
                                        <footer>
                                            <form>
                                                <label>
                                                    <div class="text-block" style="margin-left: -25px; margin-bottom: 20px;">
                                                        <p class="card-text" id="roof-type-text"
                                                           style="text-align: center !important;"><?= $shape['ds_name_db'] ?></p>
                                                        <input type="checkbox"
                                                               data-option-id="<?= $shape['ds_id'] ?>"
                                                               class="door-shapes" id="select"
                                                               style="margin-left: 15px; z-index: 1000";>
                                                </label>
                                    </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                        </pre>
                    </div>
                    </div>


                <?php endif; ?>



                    </div>

                <?php endif; ?>


            </main>


        </article>
    </section>
    <pre></pre>
    <!--<script>-->
    <!---->
    <!--    const roofTypeSelect = document.querySelectorAll("select-box");-->
    <!--    function selectRoof(){-->
    <!---->
    <!--        roofTypeSelect.forEach(selectbox=>{-->
    <!--       selectbox.addEventListener('change', () =>{-->
    <!--           if(selectbox.checked) {-->
    <!--               console.log("aaa");-->
    <!--           }-->
    <!--    });-->
    <!--    });}-->
    <!--</script>-->


    <script>


        function selectRights() {

            roofCheckBoxes.forEach(checkBox => {
                checkBox.addEventListener('change', () => {

                    let data = {
                        right: checkBox.dataset.right,
                        option_id: checkBox.dataset.optionId,
                        client_id: '<?=$selected_client_id?>'
                    };

                    if (checkBox.checked) {

                        data.state = 1;


                        $.ajax({
                            url: './ajax/test.php',

                            data: data,
                            method: "POST",
                            success: function () {
                                console.log("Working");
                                document.getElementById('rights-added-success-msg').style.display = 'block';
                                window.setInterval(() => {
                                    document.getElementById('rights-added-success-msg').style.display = 'none';
                                }, 2000);
                            }
                        }).fail(function () {
                            console.log("failed");
                            error.style.display = 'block';
                        })
                    } else {
                        data.state = 0;
                        $.ajax({
                            url: './ajax/test.php',
                            data: data,
                            method: "POST",
                            success: function () {
                                document.getElementById('rights-added-success-msg').style.display = 'block';
                                window.setInterval(() => {
                                    document.getElementById('rights-added-success-msg').style.display = 'none';
                                }, 2000);
                            }
                        }).fail(function () {
                            error.style.display = 'block';
                        })
                    }
                })
            })
        }

        const arr = [
            'walls_materials-2',
            'walls_materials',
            'roof_type',
            'door_materials',
            'windows_materials',
            'roof_materials',
            'gutters',
            'door_shapes'
        ];


        arr.forEach(el=>{
            selectWallMaterial(el)
        })




        function selectWallMaterial(checkboxVar) {

            const loopVar = document.querySelectorAll("." + checkboxVar);

            loopVar.forEach(checkBox => {
                checkBox.addEventListener('change', () => {

                    let data = {
                        right: checkboxVar,
                        option_id: checkBox.dataset.optionId,
                        client_id: '<?=$selected_client_id?>'
                    };

                    if (checkBox.checked) {

                        data.state = 1;

                        let count = 2000;
                        $.ajax({
                            url: './ajax/test.php',

                            data: data,
                            method: "POST",
                            success: function () {
                                 document.getElementById('rights-added-success-msg-lower').style.display = 'block';
                                 window.setTimeout(() => {

                                    document.getElementById('rights-added-success-msg-lower').style.display = 'none';




                                }, count);

                                //     clearTimeout(count);
                                // console.log("ceva2");


                            }
                        }).fail(function () {
                            console.log("failed");
                            error.style.display = 'block';
                        })
                    } else {
                        data.state = 0;
                        $.ajax({
                            url: './ajax/test.php',
                            data: data,
                            method: "POST",
                            success: function () {
                                document.getElementById('rights-removed-success-msg-lower').style.display = 'block';
                                window.setInterval(() => {
                                    document.getElementById('rights-removed-success-msg-lower').style.display = 'none';
                                }, 2000);
                            }
                        }).fail(function () {
                            error.style.display = 'block';
                        })
                    }
                })
            })
        }


    </script>


<?php
include('../footer.php');
?>