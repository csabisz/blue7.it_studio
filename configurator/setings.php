<?php
session_start();
include('../functions.php');

$prod = new Production;

include('../header2.php');
include('../menu.php');

?>

<style>
    .no-border {
        border: 0;
        box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
    }

    .no-border:focus {
        border: 0;
        box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
    }

    .me-save-change-btn {
        transform: scale(0.65);
    }
</style>

<section class="acceptance pt-5">
    <div class="container pagecontent bg-white px-0">
        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <p class="w-100 text-center display-4 pt-4">Configurator Setings</p>
            </div>
            <div class="col-md-4"></div>
        </div>
        <?php
        if (isset($_SESSION['client_id'])) {
        ?>

        <div class="jumbotron">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="pills-model_elements-tab" data-toggle="pill"
                       href="#pills-model_elements" role="tab" aria-controls="pills-model_elements"
                       aria-selected="true">Model Elements</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="pills-materials-tab" data-toggle="pill"
                       href="#pills-materials" role="tab" aria-controls="pills-materials"
                       aria-selected="false">Materials</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="pills-manage_domains-tab" data-toggle="pill"
                       href="#pills-manage_domains" role="tab" aria-controls="pills-manage_domains"
                       aria-selected="false">Manage Domains</a>
                </li>

            </ul>


        </div>
        <div class="tab-pane fade show active" id="pills-model_elements" role="tabpanel"
             aria-label="pills-model_elements-tab">
            <div class="row mx-0 w-100">
                <div class="col-md-12 pt-4 pb-4 border">


                    <div class="col-md-6 mt-2 mb-4">
                        <input id="search_model_elements" class="form-control mr-sm-2" type="search"
                               placeholder="Search" aria-describedby="search_addon" aria-label="Search">
                    </div>

                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-1"><strong>Me_ID</strong></div>
                        <div class="col-md-3"><strong>Name</strong></div>
                        <div class="col-md-3"><strong>Data Base Name</strong></div>
                        <div class="col-md-4"><strong>Description</strong></div>
                        <div class="col-md-1"></div>
                    </div>
                    <?php
                    $model_elements = $prod->get_al_model_elements();

                    $i = 0;
                    foreach ($model_elements as $model_element) {
                        $i++;
                        ?>

                        <div class="row justify-content-center align-items-center me_row"
                             id="row_<?php echo $model_element['me_id'] ?>">
                            <div class="col-md-1">
                                <p class="m-0"><strong><?php echo $model_element['me_id'] ?></strong></p>
                            </div>
                            <div class="col-md-3 text-center">
                                <input class="form-control no-border input_me_id"
                                       id="input_name_<?php echo $model_element['me_id'] ?>"
                                       value="<?php echo $model_element['name_to_display'] ?>" type="text">
                            </div>
                            <div class="col-md-3 text-center">
                                <input class="form-control no-border input_me_db_name"
                                       id="input_db_name_<?php echo $model_element['me_id'] ?>"
                                       value="<?php echo $model_element['element_name'] ?>" type="text">
                            </div>
                            <div class="col-md-4">
                                <textarea class="no-border form-control input_me_id" name="me_description"
                                          id="input_description_<?php echo $model_element['me_id'] ?>" cols="45"
                                          rows="1"></textarea>
                            </div>
                            <div class="col-md-1">
                                <button style="display: none" id="save_btn_<?php echo $model_element['me_id'] ?>"
                                        type="button" class="btn btn-primary me-save-change-btn"><i
                                            class="fa fa-check"></i></button>
                            </div>
                        </div>
                    <?php
                    if ($i % 2 == 0) { ?>
                        <script>
                            $('#row_<?php echo $model_element['me_id']?>').css("background-color", "#c4c4c4");
                            $('#input_name_<?php echo $model_element['me_id']?>').css("background-color", "#c4c4c4");
                            $('#input_db_name_<?php echo $model_element['me_id']?>').css("background-color", "#c4c4c4");
                            $('#input_description_<?php echo $model_element['me_id']?>').css("background-color", "#c4c4c4");
                        </script>
                    <?php
                    } ?>
                        <script>
                            $(document).on('click', function (e) {
                                if (e.target.id.includes('<?php echo $model_element['me_id'] ?>')) {
                                    $('#save_btn_<?php echo $model_element['me_id'] ?>').css('display', 'block');
                                } else {
                                    $('#save_btn_<?php echo $model_element['me_id'] ?>').css('display', 'none');
                                }
                            })
                        </script>
                        <?php
                    }
                    ?>


                </div>
            </div>
        </div>

        <div class="tab-pane fade show active" id="pills-materials" role="tabpanel"
             aria-label="pills-materials-tab">
            <div class="row mx-0 w-100">

            </div>
        </div>

        <div class="tab-pane fade show active" id="pills-manage_domains" role="tabpanel"
             aria-label="pills-manage_domains-tab">
            <div class="row mx-0 w-100">

            </div>
        </div>


    </div>


    <?php
    } else {
        ?>
        <div class="container">
            <div class="center_message">
                <div class="error text-center">You must be logged in to view this page !</div>
                <a href="../login.php" class="btn btn-danger btn-sm">Login</a>
                <br><br>
            </div>
        </div>
        <meta http-equiv="refresh" content="3; url=../login.php">
        <?php
    }
    ?>


    <script>

        // Search Script


        $('#search_model_elements').on('input', function () {

            let searchValUpper = $('#search_model_elements').val().toUpperCase()

            for (let me of $('.input_me_db_name')) {
                let meValUpper = me.value.toUpperCase();

                if (meValUpper.includes(searchValUpper)) {
                    console.log(meValUpper);
                    console.log(searchValUpper);
                    console.log(me.parentElement.parentElement);
                    me.parentElement.parentElement.classList.add('d-flex');
                    me.parentElement.parentElement.classList.remove('d-none')
                } else {
                    me.parentElement.parentElement.classList.remove('d-flex')
                    me.parentElement.parentElement.classList.add('d-none');
                }
            }
        })


    //    Update model elements AJAX

        $('.me-save-change-btn').on('click', function (e) {
            let btnId = e.target.parentElement.id
        })
    </script>

