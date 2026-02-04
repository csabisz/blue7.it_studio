<?php
session_start();
include('../functions.php');

$prod = new Production;

include('../header2.php');
include('../menu.php');
$Houuse_id = $_GET['id'];
if (isset($_POST['remove_btn'])) {
    $plan_id = $_POST['plan_id'];
    $house_id = $_POST['house_id'];

    $prod->delete_plan_by_id($plan_id);


    ?>

    <div class="text-center">
        <div class="alert alert-success">
            Removed
        </div>
    </div>
    <br>
    <meta http-equiv="refresh" content="1; url=/plansets/details.php?id=<?php echo $house_id ?>">
    <?php
}
?>
</div>
<?php
if (isset($_POST['updatebtn'])) { //check if form was submitted

    $general_info['house_name'] = $_POST['planset_name'];
    $general_info['owner'] = $_POST['owner'];
    $general_info['mc_id'] = $prod->get_client($general_info['owner'])['mc_id'];
    $general_info['presentation_id'] = $_POST['presentation_id'];
    $general_info['house_description'] = $_POST['planset_description'];
    $general_info['base_price'] = $_POST['base_price'];
    $general_info['price_building'] = $_POST['price_building'];
    $general_info['building_company'] = $_POST['building_company'];
    $general_info['id'] = $_POST['id'];


    $prod->edit_planset_general_info(json_encode($general_info));


    ?>
    <div class="alert alert-success" role="alert">
        <p class="text-center">Saved </p>
    </div>
    <?php
}

$id = $_GET['id'];

$planset = $prod->get_planset2($id);

?>
<section class="acceptance pt-5">
    <article>
        <div class="container pagecontent bg-white px-0">
            <?php
            if (isset($_SESSION['client_id'])) {
                ?>
                <div class="row justify-content-center">
                    <div class="col-md-4 mt-4"><a href="create.php"
                                                  class="btn btn-sm btn-primary mx-3 border justify-content-center">Add
                            new House
                            ID</a>
                    </div>
                    <div class="col-md-4"><p
                                class="w-100 text-center display-4 pt-4"> <?php echo $plan_sp7[$n]['house_id']; ?> House
                            ID: <?php echo $planset['planset_name'];
                            echo $planset['house_id']; ?></p></div>
                    <div class="col-md-4 mt-4 justify-text-center"><a href="index.php"
                                                                      class="btn btn-sm btn-primary mx-3 border">List of
                            House
                            IDs</a>
                    </div>
                </div>

                <hr class="mb-4" width="450px">
                <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
                </div>
                <div class="jumbotron">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>"
                          enctype="multipart/form-data" method="post">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                                   aria-controls="pills-home" aria-selected="false">General Information to
                                    ID: <?php echo $id; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-configurator-tab" data-toggle="pill"
                                   href="#pills-configurator" role="tab" aria-controls="pills-configurator"
                                   aria-selected="true">Configurator Setings</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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
                                                       value="<?php echo $planset['house_name']; ?>">
                                            </div>
                                        </div>
                                        <div class="row w-100 mx-0">
                                            <div class="col-md-4 offset-1">
                                                <label for="owner">Owner <?php echo $_POST['owner']; ?>
                                                    <div class="error" style="display:inline-flex;">&nbsp;*</div>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="custom-select" name="owner">
                                                    <option value="">None</option>
                                                    <?php
                                                    $owner = $prod->get_owner();
                                                    for ($i = 0; $i < count($owner); $i++) {
                                                        if (!empty($owner[$i]['l_first_name'])) {
                                                            ?>
                                                            <option value="<?php echo $owner[$i]['client_ID']; ?>" <?php if (($planset['pls_owner']) == $owner[$i]['client_ID']) {
                                                                echo 'selected';
                                                            } ?>><?php echo $owner[$i]['l_last_name'];
                                                                echo ' ';
                                                                echo $owner[$i]['l_first_name']; ?></option>
                                                            <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row w-100 mx-0">
                                            <div class="col-md-4 offset-1">
                                                <label for="mc_id">Main client
                                                    <div class="error" style="display:inline-flex;">&nbsp;*</div>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <?php
                                                $main_client = $prod->get_main_client($planset['mc_id']);
                                                echo $main_client['clientname'];
                                                /*

                                                    <select class="custom-select" name="mc_id">
                                                    <option value="0">Own client</option>
                                                    <?php
                                                        $main_client = $prod->get_all_main_clients();

                                                        for($i=0;$i<count($main_client);$i++)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $main_client[$i]['mc_id']; ?>" <?php echo ($planset['mc_id']==$main_client[$i]['mc_id'])?"selected":"";?>><?php echo $main_client[$i]['clientname'];?></option>
                                                        <?php
                                                        }?>
                                                    </select>
                                                    */ ?>
                                            </div>
                                        </div>
                                        <div class="row w-100 mx-0">
                                            <div class="col-md-4 offset-1">
                                                <label for="presentation_id">Presentation ID</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control form-control-sm" type="text"
                                                       id="presentation_id" name="presentation_id"
                                                       value="<?php echo $planset['presentation_id']; ?>">
                                            </div>
                                        </div>
                                        <div class="row w-100 mx-0">
                                            <div class="col-md-4 offset-1">
                                                <label for="base_price">Base Price
                                                    <div class="error" style="display:inline-flex;">&nbsp;*</div>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control form-control-sm" type="text" id="base_price"
                                                       name="base_price" value="<?php echo $planset['base_price']; ?>">
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
                                                       value="<?php echo $planset['price_building']; ?>">
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
                                                    $building_company = $prod->get_building_company();
                                                    // print_r($building_company);
                                                    for ($i = 0; $i < count($building_company); $i++) {
                                                        if (!empty($building_company[$i]['clientname'])) {
                                                            ?>
                                                            <option value="<?php echo $building_company[$i]['client_ID']; ?>" <?php if (($planset['building_company_id']) == $building_company[$i]['client_ID']) {
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
                                                          name="planset_description" id="planset_description" cols="10"
                                                          rows="10"><?php echo $planset['house_description']; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade show active" id="pills-configurator" role="tabpanel"
                                 aria-label="pills-configurator-tab">
                                <div class="row mx-0 w-100">
                                    <div class="col-md-12 pt-4 pb-4 border">

                                        <?php

                                        $h_o_id = $prod->get_ho_id($id);
                                        $configurator_menu_items = $prod->get_all_configurator_menu_items();

                                        //                                        $option = $prod->get_configurator_options();

                                        //                                        print ('<pre>');
                                        //                                        print_r($h_o_id);
                                        //                                        print_r($option);
                                        //                                        print ('</pre>');
                                        ?>

                                        <label>Select House Options List ID</label>
                                        <select class="custom-select" id="ho_id" name="ho_id">
                                            <option value="">--Select--</option>
                                            <?php foreach ($h_o_id as $value) { ?>

                                                <option value="<?php echo $value['ho_id'] ?>"><?php echo $value['ho_id'] ?></option>

                                            <?php } ?>
                                        </select>

                                        <div style="display: none" class="row mt-4" id="ho_btns">
                                            <div class="col-md-2">
                                                <button type="button" id="model_default_elements_btn"
                                                        class="btn btn-light">Default model elements
                                                </button>
                                                <script>
                                                    $('#model_default_elements_btn').click(function () {
                                                        console.log('clicked');
                                                        $('#model_default_elements').toggleClass('d-none');;
                                                        $(this).toggleClass('btn-light');
                                                        $(this).toggleClass('btn-primary');
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                        <div class="d-none" id="model_default_elements">

                                        </div>


                                        <label class="mt-4">Select House Options Category</label>
                                        <select class="custom-select" id="cm_id" name="cm_id">
                                            <option value="">--Select--</option>
                                            <?php foreach ($configurator_menu_items as $value) { ?>

                                                <option value="<?php echo $value['cm_id'] ?>"><?php echo $value['name'] ?></option>

                                            <?php } ?>
                                        </select>


                                        <div id="test_container">

                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <input id="house_id" type="hidden" name="id" value="<?php echo $planset['house_id']; ?>"/>
                            <button class="btn btn-primary" name="updatebtn" type="submit">Update</button>
                        </div>
                    </form>
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
        </div>
    </article>
</section>
<?php
include('../footer.php');
?>

<script type="text/javascript">
    $("#ho_id").change(function () {
        console.log('CHANGED');
        console.log($(this).val());
        if ($(this).val() !== '') {
            $.ajax({
                url: "../ajax/get_ho_default_elements.php",
                method: "get",
                data: {ho_id: $("#ho_id option:selected").val(), h_id: $('#house_id').val()},
                dataType: "html",
                success: function (data) {
                    $("#model_default_elements").html(data);
                }
            });
        }
        if ($('#model_default_elements').html() !== '') {
            $('#model_default_elements').html = '';
            $('#ho_btns').css('display', 'block')
        }
        console.log($('#model_default_elements').html())
    });
    /*

    //
    // $("#hol_id").change(function (){
    //     if ($(this).val() !== ''){
    //         $.ajax({
    //             url: '../ajax/get_hol_details2.php',
    //             method: 'get',
    //             data: {hol_id: $('#hol_id option:selected').val()},
    //             dataType: 'html',
    //             success: function (data) {
    //                 $('#test_container').html(data);
    //             }
    //         });
    //     }
    // });
    //
    */

    $("#cm_id").change(function () {
        if ($(this).val() !== '') {
            $.ajax({
                url: '../ajax/get_hol_details2.php',
                method: 'get',
                data: {cm_id: $('#cm_id option:selected').val(), h_id: $('#house_id').val()},
                dataType: 'html',
                success: function (data) {
                    $('#test_container').html(data);
                }
            });
        }
    });


</script>