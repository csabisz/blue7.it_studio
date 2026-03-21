<?php

$Url="https://cseven.eu/studio/api/orders.php?o_id=" . $o_id;

function url_get_contents($Url) 
{
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

$products=json_decode(url_get_contents($Url),true);
// print_r($products);
$allstatus = $prod->showallstatus();

foreach ($products as $side => $product_side) {

    ?>

    <div class="row mx-0 w-100 <?php ($side === 'interior') ? print 'interiordetails' : print 'exterior'; ?>">



        <?php foreach ($product_side as $product_type) { ?>



            <div class="row mx-0 w-100 py-2">



                <?php foreach ($product_type as $product_sub_id) { ?>

                    <div class="col-12 my-2 col-lg-4" style="border-bottom:2px solid #000;">



                        <?php foreach ($product_sub_id as $product) { ?>



                            <?php



                            $o_id = $product['o_id'];

                            $prod_id = $product['prod_id'];

                            $osub_id = $product['osub_id'];

                            $prod_class = $product['task_class_name'];



                            ?>



                            <div class="row mx-0 w-100 mb-3 <?php ($product['om_id'] != 0) ? print 'red-border' : print ''; ?>">



                                <div id="row<?= $prod_class ?>" class="w-100">



                                    <div id="task<?= $prod_class ?>" style="border-radius: 10px"

                                         class="row w-100 mx-0 py-2 <?= $product['ost_color'] ?>">

                                        <!--<div id="fileuploader_<?= $prod_class ?>"></div> -->



                                        <div class="col-4 my-1 text-center">



                                            <div class="file-name p-2 bg-light text-dark" style="border-radius: 5px">



                                                <p class="text-danger mb-0">

                                                    <strong><?php ($product['om_id'] == 0) ? print $product['task_full_name'] : print $product['task_full_name'] . '.' . $product['om_id']; ?></strong>

                                                </p>

                                                <p class="housemodel mb-0"><?= $product['prod_name']; ?></p>



                                            </div>



                                        </div>



                                        <script type="text/javascript">

                                            /*

                                            $(document).ready(function () {



                                                $("#fileuploader_<?=$prod_class; ?>").uploadFile({



                                                    url: "../upload_file.php?filecategory=creatorfiles&o_id=<?=$o_id?>&osub_id=<?=$osub_id?>&prod_id=<?=$prod_id?>&uca_id=<?=$_SESSION['client_id']?>",



                                                    fileName: "myfile",



                                                    showAbort: true,



                                                    showStatusAfterSuccess: true,



                                                    showStatusAfterError: true,



                                                    statusBarWidth: 500,



                                                    dragdropWidth: 500,



                                                });





                                                $('body').find('div.ajax-file-upload').each(function () {



                                                    $(this).css('display', 'none').parent().addClass('text-center text-dark border-dark py-2 my-1').parent().parent().addClass('d-flex justify-content-center');



                                                });





                                            }) */



                                        </script>





                                        <div class="col-8 my-1">



                                            <div class="row mx-0">
                                            <div class="col-6 d-flex justify-content-end">

                                                <p id="counter_rollout_<?= $prod_class ?>" style="font-size: 14px"></p>

                                                </div>



                                                <div class="col-6">

                                                <button id="btn_rollout_<?= $prod_class ?>"

                                                        class="btn-sm btn btn-primary text-center"

                                                        data-toggle="collapse"

                                                        href="#rollout_<?= $prod_class ?>" role="button"

                                                        aria-expanded="false"

                                                        aria-controls="rollout_<?= $prod_class ?>">

                                                </button>

                                                </div>
                                                <?php /*

                                                <!-- Customer Files -->

                                                <div class="col-3 col-xl-3 my-1 d-flex justify-content-center">

                                                    <?= $product['customer_files'] ?><br>
                                                    <?php 
                                                    $subid_data['o_id']=$product['o_id'];
                                                    $subid_data['o_sub_id']=$product['osub_id'];

                                                    $subo_name=$prod->check_existing_subid(json_encode($subid_data));

                                                    echo $subo_name['subo_name'];
                                                    ?>                      
                                                </div>



                                                <!-- Display creators -->

                                                <div class="col-12 col-xl-6 my-1 px-0 d-flex">



                                                    <div class="row mx-0 w-100 align-self-center mb-0 justify-content-center d-flex ">



                                                        <div class="form-group align-self-center w-100 mb-0 d-flex">

                                                            <div class="col-12">
                                                                    

                                                            <select name="creators_<?= $prod_class ?>"

                                                                    data-prod_id="<?= $prod_id; ?>"

                                                                    id="creators_<?= $prod_class ?>"

                                                                    data-selected_creator="<?= $product['uca_id'] ?>"

                                                                    data-loaded="false"

                                                                    class="creator form-control form-control-sm align-self-center" disabled>





                                                                <?php if ($product['current_creator']) { ?>

                                                                    <option value="">-- Choose creator -----------------------------------------------------------------------------------------</option>

                                                                    <option id="creator_<?= $product['uca_id']; ?>"

                                                                            class="offline"

                                                                            data-creator_task_count="<?= count($prod->count_working_tasks($product['uca_id'])); ?>"

                                                                            value="<?= $product['uca_id'] ?>"

                                                                            selected><?= $product['current_creator'] ?>

                                                                    </option>

                                                                    <option>Loading...</option>





                                                                <?php } else { ?>



                                                                    <option value="">-- Choose creator -----------------------------------------------------------------------------------------</option>



                                                                <?php } ?>



                                                                <script>
                                                                    // console.log(document.getElementById('creators_<?=$prod_class?>').dataset);
                                                                    if (document.getElementById('creators_<?=$prod_class?>').dataset.loaded === 'false') {



                                                                        $('#creators_<?=$prod_class?>').click(function () {


                                                                            // console.log(this.dataset);
                                                                            

                                                                            this.dataset.loaded = 'true';



                                                                            $.ajax({

                                                                                url: '../api/creators.php',

                                                                                method: 'get',

                                                                                data: {

                                                                                    o_id: '<?=$o_id?>',

                                                                                    osub_id: '<?=$osub_id?>',

                                                                                    prod_id: '<?=$prod_id?>',

                                                                                    u_prod_id: '<?=$product['u_prod_id']?>',

                                                                                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone

                                                                                },

                                                                                dataType: 'json',

                                                                                success: function (data) {

                                                                                    //console.log(data);

                                                                                    let select = document.getElementById('creators_<?=$prod_class?>');



                                                                                    while (select.firstChild) {

                                                                                        select.removeChild(select.firstChild);

                                                                                    }



                                                                                    function createOptions(creators) {

                                                                                        for (let creator of creators) {



                                                                                            let option = document.createElement('option');



                                                                                            if (creator.client_ID === data.selected) {

                                                                                                option.selected = true;

                                                                                            }

                                                                                            if(creator) {
                                                                                                if(creator.shifts) {
                                                                                                    if(creator.shifts.today) {
                                                                                                        if (creator.shifts.today.work) {

                                                                                                            option.style.backgroundColor = 'green';

                                                                                                            option.style.color = 'white';

                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                            option.appendChild(document.createTextNode(creator.text));

                                                                                            option.value = creator.client_ID;

                                                                                            select.appendChild(option);



                                                                                        }

                                                                                    }


                                                                                    let option = document.createElement('option');

                                                                                    option.appendChild(document.createTextNode("-- Choose creator --"));

                                                                                    option.disabled = false;

                                                                                    option.style.fontWeight = 'bold';

                                                                                    option.style.backgroundColor = 'grey';

                                                                                    option.style.color = 'white';

                                                                                    select.appendChild(option);





                                                                                    createOptions(data.main_company);



                                                                                    option = document.createElement('option');

                                                                                    option.appendChild(document.createTextNode("Other Companies"));

                                                                                    option.disabled = true;

                                                                                    option.style.fontWeight = 'bold';

                                                                                    option.style.backgroundColor = 'grey';

                                                                                    option.style.color = 'white';

                                                                                    select.appendChild(option);


                                                                                    createOptions(data.other_companies);



                                                                                }



                                                                            });





                                                                        });



                                                                    } else {



                                                                        console.log("Already Loaded")



                                                                    }



                                                                    $('#creators_<?=$prod_class?>').on("change", function () {

                                                                        //console.log(this.selected)



                                                                        $.ajax({



                                                                            url: "../ajax/assign_creator.php",



                                                                            method: "get",



                                                                            data: {

                                                                                o_id: <?=$o_id;?>,

                                                                                osub_id: "<?=$osub_id;?>",

                                                                                prod_id: "<?=$prod_id;?>",

                                                                                creatorid: $(this).val()

                                                                            },



                                                                            dataType: "html",



                                                                            success: function (data) {



                                                                                $('#task<?=$prod_class?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center blue');



                                                                                $('#product_status<?=$prod_class?>').val(2);



                                                                            }



                                                                        });



                                                                    });

                                                                </script>



                                                            </select>

                                                            </div>

                                                            <!--<a href="taskdetails.php?o_id=<?= $o_id ?>&osub_id=<?= $osub_id ?>&prod_id=<?= $prod_id ?>"

                                                               class="btn btn-sm btn-primary col-5 align-self-center mx-1">Details</a> -->



                                                        </div>



                                                    </div>

                                                </div>



                                                <!-- Order Status -->

                                                <div class="col-6 text-center">



                                                    <div class="form-group align-self-center mb-0">



                                                        <select class="form-control form-control-sm"

                                                                data-osub_id="<?= $osub_id ?>"

                                                                data-prod_id="<?= $prod_id ?>"

                                                                id="product_status<?= $prod_class ?>" disabled>



                                                            <?php foreach ($allstatus as $status) { ?>



                                                                <option value="<?= $status['ost_id'] ?>"

                                                                        data-status="<?= $status['ost_color'] ?>"

                                                                    <?= ($status['ost_id'] == $product['p_status']) ? "selected" : "" ?>><?= ucfirst($status['ost_name']) ?>

                                                                </option>



                                                            <?php } ?>



                                                        </select>



                                                        <script type="text/javascript">



                                                            $('#product_status<?=$prod_class?>').on("change", function () {



                                                                var collection = $('#collection').val().split(";");



                                                                var current_osub_id = $('#product_status<?=$prod_class?>').data('osub_id');



                                                                var current_o_id = <?=$o_id?>;





                                                                $.ajax({



                                                                    url: "../ajax/change_product_status.php",



                                                                    method: "get",



                                                                    data: {

                                                                        o_id: <?=$o_id?>,

                                                                        osub_id: "<?=$osub_id?>",

                                                                        prod_id: "<?=$prod_id?>",

                                                                        p_status: $(this).val()

                                                                    },



                                                                    dataType: "html",



                                                                    success: function (return_data) {



                                                                        console.log(return_data);



                                                                        if (return_data.trim() != "no_result_files") {





                                                                            var status = $('#product_status<?=$prod_class?>').val();





                                                                            var clasa = $('#product_status<?=$prod_class?> option:selected').data('status');



                                                                            //console.log($('#product_status<?=$prod_class?> option:selected').data('status'));



                                                                            $('#task<?=$prod_class?>').removeClass().addClass('row w-100 mx-0 py-2 ' + clasa);



                                                                        } else {



                                                                            alert("Upload raw file first !");



                                                                        }





                                                                    }



                                                                });



                                                            });



                                                        </script>





                                                    </div>



                                                </div>



                                                <!--Label Credits Calculation-->

                                                <div class="col-6 text-center">



                                                    <p class="mb-0">labc: <?php





                                                        $thisproductlabc = $prod->calculateProductlabc($prod_id);



                                                        $side='';

                                                        $prod_kind = $prod_id[2];

                                                        if ($osub_id[0] == 'n') {

                                                            $side = 'labc_in';

                                                        }

                                                        if ($osub_id[0] == 'x') {

                                                            $side = 'labc_ex';

                                                        }



                                                        $o_desc = $prod->get_o_desc($o_id, $osub_id, $prod_id);



                                                        $labc = 0;

                                                        if (!empty($o_desc[$prod_id . '_fac'])){

                                                            $labc = bcdiv($o_desc['fac_'.$side.'_b' . $prod_kind] * $o_desc[$prod_id . '_fac'] * $thisproductlabc, 1, 2);

                                                            echo $labc;

                                                            echo '</br>';

                                                            if ($labc != 0) {

                                                                echo "(" . $o_desc['fac_'.$side.'_b' . $prod_kind] . " x " . $o_desc[$prod_id . '_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                            }

                                                        }else{

                                                            $labc = bcdiv($o_desc['fac_'.$side.'_b' . $prod_kind] * $thisproductlabc, 1, 2);

                                                            echo $labc;

                                                            echo '</br>';

                                                            if ($labc != 0) {

                                                                echo "(" . $o_desc['fac_'.$side.'_b' . $prod_kind] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                            }

                                                        }





                                                        ?></p>



                                                </div> */ ?>



                                            </div>



                                        </div>



                                        <!-- Task Comment -->

                                        <?php /* if (!empty($product['comment'])) { ?>

                                            <div class="row">

                                                <div class="col-md-12 text-center">

                                                    <p style="font-size:14px;"><?= $product['comment'] ?></p>

                                                </div>

                                            </div>

                                        <?php } */ ?>



                                        <!-- Order Files -->

                                        <div class="row w-100">

                                            

                                        </div>



                                    </div>



                                </div>



                                <!-- File -->

                                <?php



                                $nv_counter = 0; //Not visible files

                                $vcl_counter = 0; //Clients visible files

                                $tot_counter = 0; //Total files counter



                                foreach ($product['result_files'] as $file) {



                                    if ($file['orf_status'] == 0) {

                                        $nv_counter++;

                                    }

                                    if ($file['orf_status'] == 8 || $file['orf_status'] == 6) {

                                        $vcl_counter++;

                                    }

                                    $tot_counter++;



                                    ?>

                                    <div id="rollout_<?= $prod_class ?>" class="collapse">

                                        <div class="row w-100 mx-0 border-top border-white <?php echo ($file['orf_status'] == 0) ? "grey-dark" : "light-green"; ?>"

                                             id="result_file<?php echo $file['orf_id']; ?>"

                                             style="padding: 10px; margin-top: 3px; border-radius: 5px">



                                            <div class="col-6 py-2 text-center px-0 d-flex align-items-start">
                                                <?php
                                                if($file['prod_id']!="p168s")
                                                {
                                                ?>
                                                <div class="row mx-0 w-100 d-flex justify-content-center align-items-start">



                                                    <div class="col-2 p-0 d-flex align-items-center">



                                                        <!-- Picture, if exist -->

                                                        <?php if (in_array($file['orf_type_dom'], $validextensions)) { ?>

                                                            <div id="image_tooltip_container_<?php echo $image_preview_counter; ?>">



                                                                <?php if (!empty($file['orf_thumbnail_path'])) { ?>



                                                                    <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $file['orf_path_dom'] . $file['orf_internal_name_dom']; ?>"

                                                                       target="_blank"><img

                                                                                src="result_thumbnail_files/<?php echo $file['orf_thumbnail_path']; ?>"

                                                                                alt="<?php echo $file['orf_name']; ?>"

                                                                                width="60"

                                                                                heigth="33.78"

                                                                                class="img-responsive d-inline img-fluid"></a>



                                                                <?php } else { ?>



                                                                    <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $file['orf_path_dom'] . $file['orf_internal_name_dom']; ?>"

                                                                       target="_blank"><img

                                                                                src="result_files/<?php echo $file['orf_path_dom'] . $file['orf_internal_name_dom']; ?>"

                                                                                alt="<?php echo $file['orf_name']; ?>"

                                                                                width="60"

                                                                                heigth="33.78"

                                                                                class="img-responsive d-inline img-fluid"></a>



                                                                <?php } ?>

                                                            </div>

                                                        <?php } ?>

                                                    </div>



                                                    <!-- File Name -->

                                                    <div class="col-10 px-0 d-flex align-items-center flex-row">



                                                        <div class="justify-content-center w-100">



                                                            <div class="file-name w-100 text-center d-flex flex-column justify-content-center">



                                                                <p class="mb-0 pt-0 d-flex justify-content-center align-items-center"

                                                                   style="font-size: 13px;">



                                                                    <?php



                                                                    $file_name1 = explode("-", $file['orf_name']);



                                                                    $file_name2 = explode(".", $file['orf_name']);





                                                                    $first_part_with_space = $file_name1[0];



                                                                    $first_part = str_replace(' ', '', $first_part_with_space);



                                                                    echo $first_part;



                                                                    ?>



                                                                    <input type="text"

                                                                           style="max-height: 18px;max-width: 70px;"

                                                                           name="file_name"

                                                                           id="file_name<?php echo $file['orf_id'] ?>"

                                                                           value="<?php



                                                                           $middle_part_with_space = explode('.', $file_name1[1]);



                                                                           $middle_part = str_replace(' ', '', $middle_part_with_space);



                                                                           echo $middle_part[0];



                                                                           ?>" data-file_name_first_part="<?php



                                                                    echo $first_part . " - ";



                                                                    ?>" data-file_name_last_part="<?php



                                                                    $last_part = end($file_name2);



                                                                    echo "." . $last_part;



                                                                    ?>" class="form-control form-control-sm" disabled><?php



                                                                    echo "." . $last_part;



                                                                    ?>



                                                                </p>

                                                                <div class="row w-100 mx-0 px-0 d-flex justify-content-center">

                                                                    <!--<button id="rename_btn<?php echo $file['orf_id'] ?>"

                                                                            class="btn btn-sm btn-primary mt-1 d-inline rounded-0"

                                                                            style="font-size: 13px;">Rename

                                                                    </button> -->

                                                                </div>

                                                                <script type="text/javascript">

                                                                    /*

                                                                    $('#rename_btn<?php echo $file['orf_id']?>').click(function () {



                                                                        $.ajax({

                                                                            url: "<?php echo $base_url;?>ajax/rename_result_file.php",

                                                                            method: "post",

                                                                            data: {

                                                                                orf_id:<?php echo $file['orf_id'];?>,

                                                                                file_name: $('#file_name<?php echo $file['orf_id']?>').val(),

                                                                                file_name_first_part: $('#file_name<?php echo $file['orf_id']?>').data('file_name_first_part'),

                                                                                file_name_last_part: $('#file_name<?php echo $file['orf_id']?>').data('file_name_last_part')

                                                                            },



                                                                            dataType: "html",

                                                                            success: function (data) {



                                                                            }



                                                                        });



                                                                    }); */



                                                                </script>

                                                            </div>



                                                        </div>



                                                    </div>



                                                </div>
                                                <?php
                                                }
                                                else
                                                {
                                                   ?>
                                                   <input type="text" class="form-control form-control-sm" value="<?php echo $file['orf_path_dom'];?>">
                                                   <?php
                                                }
                                                ?>
                                            </div>



                                            <!-- Creator Name, Upload Date, Status -->

                                            <div class="col-6 px-0 py-2">



                                                <p class="w-100 text-center mb-0" style="font-size: 12px;"><?php



                                                    $creator = $prod->get_client($file['uca_id']);



                                                    if (!empty($creator['c_last_name'])) {



                                                        echo $creator['c_first_name'] . " " . $creator['c_last_name'];



                                                    } else {



                                                        echo $creator['l_first_name'] . " " . $creator['l_last_name'];



                                                    }



                                                    $uploaded_date_time = explode(" ", $file['orf_upload_date']);



                                                    echo " " . $uploaded_date_time[0] . ", " . $uploaded_date_time[1] . " UTC+0"; ?></p>



                                                <div class="w-100 d-flex justify-content-center">



                                                    <div class="form-group mb-0">



                                                        <select name="result_files_visibility<?php echo $file['orf_id']; ?>"

                                                                id="result_files_visibility<?php echo $file['orf_id']; ?>"

                                                                class="form-control form-control-sm" disabled>



                                                            <option value="0" <?php echo ($file['orf_status'] == 0) ? "selected" : ""; ?>>

                                                                Not visible

                                                            </option>



                                                            <option value="6" <?php echo ($file['orf_status'] == 6) ? "selected" : ""; ?>>

                                                                2d Configurator

                                                            </option>



                                                            <option value="7" <?php echo ($file['orf_status'] == 7) ? "selected" : ""; ?>>

                                                                Visible for checkers

                                                            </option>



                                                            <option value="8" <?php echo ($file['orf_status'] == 8) ? "selected" : ""; ?>>

                                                                Visible for client

                                                            </option>



                                                        </select>



                                                        <script type="text/javascript">

                                                        /*

                                                            $('#result_files_visibility<?php echo $file['orf_id'];?>').on("change", function () {



                                                                $.ajax({



                                                                    url: "../ajax/change_results_file_visibility.php",



                                                                    method: "get",



                                                                    data: {

                                                                        orf_id:<?php echo $file['orf_id'];?>,

                                                                        orf_status: $(this).val()

                                                                    },



                                                                    dataType: "html",



                                                                    success: function (data) {



                                                                        if (($('#result_files_visibility<?php echo $file['orf_id'];?>').val()) == 8) {



                                                                            $('#result_file<?php echo $file['orf_id'];?>').removeClass("grey-dark").addClass("light-green");



                                                                        } else {



                                                                            $('#result_file<?php echo $file['orf_id'];?>').removeClass("light-green").addClass("grey-dark");



                                                                        }



                                                                    }



                                                                });



                                                            }); */



                                                        </script>



                                                    </div>

                                                    <?php
                                                    if($file['prod_id']!="p168s")
                                                    {
                                                    ?>
                                                    <a href="../image.php?filecategory=creatorfiles&orfid=<?php echo $file['orf_id']; ?>"

                                                       class="btn btn-sm btn-primary align-self-center ml-1">Download</a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <!--<button id="delete_btn<?php echo $file['orf_id']; ?>"

                                                            class="btn btn-sm btn-danger text-white align-self-center ml-1">

                                                        x

                                                    </button> -->



                                                    <script type="text/javascript">

                                                        /*

                                                        $('#delete_btn<?php echo $file['orf_id']?>').click(function () {



                                                            if (confirm('Are you sure want to delete ?')) {



                                                                $.ajax({



                                                                    url: "../ajax/delete_result_file.php",



                                                                    method: "post",



                                                                    data: {orf_id:<?php echo $file['orf_id'];?>},



                                                                    dataType: "html",



                                                                    success: function (data) {



                                                                        $('#result_file<?php echo $file['orf_id'];?>').fadeOut(3000);



                                                                    }



                                                                });



                                                            }



                                                        }); */



                                                    </script>



                                                </div>



                                            </div>



                                            <!-- Title -->

                                            <div class="col-6 px-2 py-0">



                                                <p class="my-0 d-flex" style="font-size:12px;">

                                                    <span class="pt-1 d-flex">Title:</span>

                                                    <input id="title<?php echo $file['orf_id']; ?>"

                                                           list="img_categ2_<?php echo $file['orf_id']; ?>"

                                                           class="form-control form-control-sm" type="text"

                                                           value="<?php echo $file['pict_categ_name']; ?>" disabled>

                                                    <?php

                                                    if ((substr($file['prod_id'], -2) === '00') ||

                                                        (substr($file['prod_id'], -2) === '01') ||

                                                        (substr($file['prod_id'], -2) === '02') ||

                                                        (substr($file['prod_id'], -2) === '03') ||

                                                        (substr($file['prod_id'], -2) === '21') ||

                                                        (substr($file['prod_id'], -2) === '22') ||

                                                        (substr($file['prod_id'], -2) === '23') ||

                                                        (substr($file['prod_id'], -2) === '41') ||

                                                        (substr($file['prod_id'], -2) === '42') ||

                                                        (substr($file['prod_id'], -2) === '43')

                                                    ) {

                                                        ?>

                                                        <datalist id="img_categ2_<?php echo $file['orf_id']; ?>"

                                                                  data-id1="<?php echo $file['orf_id']; ?>">

                                                            <option value="EG">EG</option>

                                                            <option value="OG">OG</option>

                                                            <option value="OG 1">OG 1</option>

                                                            <option value="OG 2">OG 2</option>

                                                            <option value="DG">DG</option>

                                                            <option value="KG">KG</option>

                                                        </datalist>

                                                        <?php

                                                    }

                                                    if ((substr($file['prod_id'], -2) === '63') ||
                                                        (substr($file['prod_id'], -2) === '83') )
                                                     {
                                                        ?>
                                                        <datalist id="img_categ2_<?php echo $file['orf_id']; ?>"
                                                                  data-id1="<?php echo $file['orf_id']; ?>">
                                                                    <option value="1-2-terra">1-2-terra</option>
                                                                    <option value="1-2-normal">1-2-normal</option>
                                                                    <option value="1-2-plus">1-2-plus</option>
                                                                    <option value="1-2-top">1-2-top</option>
                                                                    <option value="2-3-terra">2-3-terra</option>
                                                                    <option value="2-3-normal">2-3-normal</option>
                                                                    <option value="2-3-plus">2-3-plus</option>
                                                                    <option value="2-3-top">2-3-top</option>
                                                                    <option value="3-4-terra">3-4-terra</option>
                                                                    <option value="3-4-normal">3-4-normal</option>
                                                                    <option value="3-4-plus">3-4-plus</option>
                                                                    <option value="3-4-top">3-4-top</option>
                                                                    <option value="4-1-terra">4-1-terra</option>
                                                                    <option value="4-1-normal">4-1-normal</option>
                                                                    <option value="4-1-plus">4-1-plus</option>
                                                                    <option value="4-1-top">4-1-top</option>
                                                        </datalist>
                                                        <?php
                                                    }


                                                    if ((substr($file['prod_id'], -1) === 'y'))

                                                     {

                                                        ?>

                                                        <datalist id="img_categ2_<?php echo $file['orf_id']; ?>"

                                                                  data-id1="<?php echo $file['orf_id']; ?>">

                                                            <option value="fs.total">fs.total</option>

                                                            <option value="bs.total">bs.total</option>

                                                            <option value="fs.dsp_002">fs.dsp_002</option>

                                                            <option value="fs.dsp_004">fs.dsp_004</option>

                                                            <option value="fs.dsp_008">fs.dsp_008</option>

                                                            <option value="fs.dsp_010">fs.dsp_010</option>

                                                            <option value="fs.rm_001">fs.rm_001</option>

                                                            <option value="fs.rm_002">fs.rm_002</option>

                                                            <option value="fs.rm_003">fs.rm_003</option>

                                                            <option value="bs.rm_001">fs.rm_001</option>

                                                            <option value="bs.rm_002">fs.rm_002</option>

                                                            <option value="bs.rm_003">fs.rm_003</option>

                                                        </datalist>

                                                        <?php

                                                    }



                                                    if ((substr($file['prod_id'], -1) === 'z'))

                                                     {

                                                        ?>

                                                        <datalist id="img_categ2_<?php echo $file['orf_id']; ?>"

                                                                  data-id1="<?php echo $file['orf_id']; ?>">

                                                            <option value="fs.color">fs.color</option>

                                                            <option value="bs.color">bs.color</option>

                                                            <option value="fs.dsp_svg">fs.dsp_svg</option>

                                                            <option value="bs.dsp_svg">bs.dsp_svg</option>

                                                            <option value="fs.rm_svg">fs.rm_svg</option>

                                                            <option value="bs.rm_svg">bs.rm_svg</option>

                                                        </datalist>

                                                        <?php

                                                    }

                                                    ?>

                                                    <script type="text/javascript">

                                                        $('#title<?php echo $file['orf_id'];?>').on("keyup", function () {

                                                            console.log($(this).val)

                                                            $.ajax({

                                                                url: "<?php echo $base_url;?>ajax/img_categ_set.php",

                                                                method: "post",

                                                                data: {

                                                                    orf_id:<?php echo $file['orf_id'];?>,

                                                                    img_categ: $(this).val()

                                                                },

                                                                dataType: "html",

                                                                success: function (data) {



                                                                }

                                                            });

                                                        });

                                                    </script>

                                                </p>



                                            </div>



                                            <!--File Size -->

                                            <div class="col-6 px-0 py-0 text-right">



                                                <p class="my-0 pr-5" style="font-size:12px;">

                                                    size: <?php echo $filesize = $prod->filesize_formatted("result_files/" . $file['orf_path_dom'] . $file['orf_internal_name_dom']); ?></p>



                                            </div>





                                        </div>



                                    </div>

                                    <?php $image_preview_counter++;

                                } ?>





                                <script>

                                    document.getElementById("btn_rollout_<?=$prod_class ?>").innerText = "Show files <?php echo $tot_counter?>";

                                    document.getElementById("counter_rollout_<?=$prod_class?>").innerText = "<?php echo 'Not visible: ' . $nv_counter . ' Visible: ' . $vcl_counter?>";

                                </script>





                            </div>





                        <?php } ?>



                    </div>



                <?php } ?>



            </div>



        <?php } ?>





    </div>



<?php } ?>