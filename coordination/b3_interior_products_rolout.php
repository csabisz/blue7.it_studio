<?php

$global_column_count = 0;

?>

<div class="row mx-0 w-100 interiordetails">

    <div class="row mx-0 w-100 py-2">

        <div class="col-12 my-2 col-lg-4" style="border-bottom:2px solid #000;"> <!-- start one column -->

            <?php

            for ($k = 0;
            $k < count($b3_interior_products_with_extensions);
            $k++)

            {

            $product = $prod->get_product($b3_interior_products_with_extensions[$k]['prod_id']);


            if (($k > 0) && ($b3_interior_products_with_extensions[$k - 1]['osub_id'] != $b3_interior_products_with_extensions[$k]['osub_id']))

            {

            $global_column_count++;

            ?>

        </div> <!-- end one column -->

        <div class="col-12 my-2 col-lg-4" style="border-bottom:2px solid #000;"> <!-- start one column -->

            <?php

            }

            ?>


            <div class="row mx-0 w-100 mb-2 <?php

            if ($b3_interior_products_with_extensions[$k]['om_id'] != 0) {

                echo "red-border";

            } ?>">

                <div id="row<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id']; ?>">

                    <div class="row w-100 mx-0 py-2 <?php

                    for ($i = 0; $i < count($allstatus); $i++) {

                        if ($allstatus[$i]['ost_id'] == $b3_interior_products_with_extensions[$k]['p_status']) {

                            echo $allstatus[$i]['ost_color'];

                        }

                    } ?>"
                         id="task<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id']; ?>">

                        <div id="fileuploader_<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id']; ?>">

                        </div>

                        <div class="col-4 my-1 text-center">

                            <div class="file-name p-2 bg-light text-dark">

                                <p class="text-danger mb-0"><strong><?php

                                        if ($b3_interior_products_with_extensions[$k]['om_id'] == 0) {

                                            echo $b3_interior_products_with_extensions[$k]['o_id'] . "." . $b3_interior_products_with_extensions[$k]['osub_id'] . "." . $b3_interior_products_with_extensions[$k]['prod_id'];

                                        } else {

                                            echo $b3_interior_products_with_extensions[$k]['om_id'] . "." . $b3_interior_products_with_extensions[$k]['osub_id'] . "." . $b3_interior_products_with_extensions[$k]['prod_id'] . "." . $b3_interior_products_with_extensions[$k]['o_id'];

                                        } ?></strong></p>


                                <p class="housemodel mb-0"><?php echo $product['prod_name']; ?></p>

                            </div>

                        </div>

                        <script type="text/javascript">

                            $(document).ready(function () {

                                $("#fileuploader_<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>").uploadFile({

                                    url: "../upload_file.php?filecategory=creatorfiles&o_id=<?php echo $b3_interior_products_with_extensions[$k]['o_id'];?>&osub_id=<?php echo $b3_interior_products_with_extensions[$k]['osub_id']; ?>&prod_id=<?php echo $b3_interior_products_with_extensions[$k]['prod_id'];?>&uca_id=<?php echo $_SESSION['client_id']; ?>",

                                    fileName: "myfile",

                                    showAbort: true,

                                    showStatusAfterSuccess: true,

                                    showStatusAfterError: true,

                                    statusBarWidth: 500,

                                    dragdropWidth: 500,

                                    //uploadStr:"",

                                    afterUploadAll: function () {

                                        //setTimeout(function(){window.location = "taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>"},1000);

                                    }

                                });


                                $('body').find('div.ajax-file-upload').each(function () {

                                    $(this).css('display', 'none').parent().addClass('text-center text-dark border-dark py-2 my-1').parent().parent().addClass('d-flex justify-content-center');

                                });


                            });

                        </script>

                        <div class="col-8 my-1">

                            <div class="row mx-0">

                                <div class="col-12 col-xl-6 my-1 d-flex justify-content-center">

                                    <?php
                                    /*$interior_orders_subnames=$prod->get_all_orders_subnames_interior_subids($o_id);

                                    for($c=0;$c<count($interior_orders_subnames);$c++)
                                    {
                                        if($interior_orders_subnames[$c]['osub_id']==$b3_interior_products_with_extensions[$k]['osub_id'])
                                        {
                                            echo $interior_orders_subnames[$c]['osn_text'];
                                        }

                                    }*/

                                    for ($c = 0; $c < count($customer_files); $c++) {

                                        $osub_id = substr($b3_interior_products_with_extensions[$k]['osub_id'], 1);

                                        if ($customer_files[$c]['of_position'] == $osub_id) {

                                            echo $customer_files[$c]['of_name'];

                                        }

                                    }

                                    ?>

                                </div>

                                <div class="col-12 col-xl-6 my-1 px-0 d-flex">

                                    <div class="row mx-0 w-100 align-self-center mb-0 justify-content-center d-flex ">

                                        <div class="form-group align-self-center w-100 mb-0 d-flex">

                                            <select name="creators_<?php echo $global_creator_counter; ?>"
                                                    data-prod_id="<?php echo $b3_interior_products_with_extensions[$k]['prod_id']; ?>"
                                                    id="creators_<?php echo $global_creator_counter; ?>"
                                                    data-selected_creator="<?php echo $b3_interior_products_with_extensions[$k]['uca_id']; ?>"
                                                    class="creator col-7 form-control form-control-sm align-self-center">

                                                <option value="">-- Choose creator
                                                    ----------------------------------------------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <option value="">------------------------------------- Loading
                                                    -----------------------------------
                                                </option>

                                                <?php

                                                //getting single creator on page load


                                                $selected_creator = $prod->get_client($b3_interior_products_with_extensions[$k]['uca_id']);


                                                $creator_qualification = $prod->get_client_qualifications($selected_creator['client_ID']);

                                                $creator_right = $prod->get_client_rights($selected_creator['client_ID']);


                                                if ($creator_right['u_status'] == "active") {

                                                    ?>

                                                    <option id="creator_<?php echo $b3_interior_products_with_extensions[$k]['uca_id']; ?>"
                                                            class="offline" data-creator_task_count="<?php

                                                    $count_working_tasks = $prod->count_working_tasks($b3_interior_products_with_extensions[$k]['uca_id']);

                                                    echo count($count_working_tasks); ?>"
                                                            value="<?php echo $b3_interior_products_with_extensions[$k]['uca_id']; ?>"
                                                            selected><?php

                                                        if (!empty($selected_creator['c_last_name'])) {

                                                            echo $selected_creator['c_first_name'] . " " . $selected_creator['c_last_name'] . " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")";

                                                            echo " - left: - next: ";

                                                        } else {

                                                            echo $selected_creator['l_first_name'] . " " . $selected_creator['l_last_name'] . " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")";

                                                            echo " - left: - next: ";

                                                        } ?> </option>


                                                    <?php

                                                }

                                                ?>

                                            </select>

                                            <script type="text/javascript">

                                                $(document).ready(function () {


                                                    var counter = 0;


                                                    $('#creators_<?php echo $global_creator_counter;?>').on("click", function () {


                                                        if (counter == 0) {


                                                            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;


                                                            $.ajax({

                                                                url: "coordination_choose_b3_in_creators.php",

                                                                method: "get",

                                                                data: {
                                                                    o_id:<?php echo $b3_interior_products_with_extensions[$k]['o_id'];?>,
                                                                    osub_id: "<?php echo $b3_interior_products_with_extensions[$k]['osub_id'];?>",
                                                                    prod_id: "<?php echo $b3_interior_products_with_extensions[$k]['prod_id'];?>"
                                                                },

                                                                dataType: "html",

                                                                success: function (data) {


                                                                    var html = [];


                                                                    html.push("<option value=\"\">-- Choose creator --</option>");


                                                                    $(data).each(function () {

                                                                        var creator_start_time = $(this).data("creator_start_time");

                                                                        var creator_end_time = $(this).data("creator_end_time");

                                                                        var original_text = $(this).text();

                                                                        var creator_id = $(this).val();


                                                                        var creatorUTCstarttime = moment.tz(creator_start_time, 'UTC');

                                                                        var creator_start_dateset = creatorUTCstarttime

                                                                            .clone()

                                                                            .tz(user_timezone)

                                                                            .format('YYYY-MM-DD, HH:mm');


                                                                        //console.log(creator_start_dateset);


                                                                        var creatorUTCendtime = moment.tz(creator_end_time, 'UTC');

                                                                        var creator_end_dateset = creatorUTCendtime

                                                                            .clone()

                                                                            .tz(user_timezone)

                                                                            .format('YYYY-MM-DD HH:mm');


                                                                        var today = new Date();


                                                                        var time_diff = (new Date(creator_end_dateset).getTime() - new Date(today).getTime());


                                                                        var seconds = time_diff / 1000;

                                                                        // 2- Extract hours:

                                                                        var hours = parseInt(seconds / 3600); // 3,600 seconds in 1 hour

                                                                        seconds = seconds % 3600; // seconds remaining after extracting hours

                                                                        // 3- Extract minutes:

                                                                        var minutes = parseInt(seconds / 60); // 60 seconds in 1 minute

                                                                        // 4- Keep only seconds not extracted to minutes:

                                                                        seconds = seconds % 60;


                                                                        var offline_online = "offline";


                                                                        if (creator_id != "") {

                                                                            if (time_diff > 0) {

                                                                                offline_online = "online";

                                                                                if (creator_start_dateset != "Invalid date") {

                                                                                    html.push("<option class=\"" + offline_online + "\" value=\"" + creator_id + "\">" + original_text + " - left: " + hours + ":" + minutes + " - next: " + creator_start_dateset + "</option>");


                                                                                } else {

                                                                                    html.push("<option class=\"" + offline_online + "\" value=\"" + creator_id + "\">" + original_text + " - left: " + hours + ":" + minutes + " - next: No shift</option>");

                                                                                }

                                                                            } else {

                                                                                if (creator_start_dateset != "Invalid date") {

                                                                                    if (creator_id != "Resources from other companies") {

                                                                                        html.push("<option class=\"" + offline_online + "\" value=\"" + creator_id + "\">" + original_text + " - left: No shift - next: " + creator_start_dateset + "</option>");

                                                                                    } else {

                                                                                        html.push("<option class=\"text-danger font-weight-bold\" value=\"" + creator_id + "\">" + original_text + "</option>");

                                                                                    }

                                                                                } else {

                                                                                    if (creator_id != "Resources from other companies") {

                                                                                        html.push("<option class=\"" + offline_online + "\" value=\"" + creator_id + "\">" + original_text + " - left: No shift - next: No shift</option>");

                                                                                    } else {

                                                                                        html.push("<option class=\"text-danger font-weight-bold\" value=\"" + creator_id + "\">" + original_text + "</option>");

                                                                                    }

                                                                                }

                                                                            }

                                                                        }


                                                                    });


                                                                    $('#creators_<?php echo $global_creator_counter;?>').html(html);

                                                                }

                                                            });


                                                            counter++;

                                                        }

                                                    });


                                                    $('#creators_<?php echo $global_creator_counter;?>').on("change", function () {

                                                        $.ajax({

                                                            url: "../ajax/assign_creator.php",

                                                            method: "get",

                                                            data: {
                                                                o_id:<?php echo $b3_interior_products_with_extensions[$k]['o_id'];?>,
                                                                osub_id: "<?php echo $b3_interior_products_with_extensions[$k]['osub_id'];?>",
                                                                prod_id: "<?php echo $b3_interior_products_with_extensions[$k]['prod_id'];?>",
                                                                creatorid: $(this).val()
                                                            },

                                                            dataType: "html",

                                                            success: function (data) {

                                                                //console.log(data);

                                                                if ($('#creators_<?php echo $global_creator_counter;?>').data('prod_id') == "p1301") {

                                                                    $('#task<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center dark-green');

                                                                    $('#product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').val(4);

                                                                } else {

                                                                    $('#task<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center blue');

                                                                    $('#product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').val(2);

                                                                }

                                                            }

                                                        });

                                                    });


                                                });

                                            </script>

                                            <a href="taskdetails.php?o_id=<?php echo $b3_interior_products_with_extensions[$k]['o_id']; ?>&osub_id=<?php echo $b3_interior_products_with_extensions[$k]['osub_id']; ?>&prod_id=<?php echo $b3_interior_products_with_extensions[$k]['prod_id']; ?>"
                                               class="btn btn-sm btn-primary col-5 align-self-center mx-1">Details</a>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6 text-center">

                                    <div class="form-group align-self-center mb-0">

                                        <select class="form-control form-control-sm" name=""
                                                data-osub_id="<?php echo $b3_interior_products_with_extensions[$k]['osub_id']; ?>"
                                                data-prod_id="<?php echo $b3_interior_products_with_extensions[$k]['prod_id']; ?>"
                                                id="product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id']; ?>">

                                            <?php

                                            for ($j = 1; $j < count($allstatus); $j++) {

                                                ?>

                                                <option value="<?php echo $allstatus[$j]['ost_id']; ?>"
                                                        data-status="<?php echo $allstatus[$j]['ost_color']; ?>" <?php echo ($allstatus[$j]['ost_id'] == $b3_interior_products_with_extensions[$k]['p_status']) ? "selected" : ""; ?>><?php echo ucfirst($allstatus[$j]['ost_name']); ?></option>

                                                <?php

                                            }

                                            ?>

                                        </select>

                                        <script type="text/javascript">

                                            $('#product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').on("change", function () {

                                                var collection = $('#collection').val().split(";");

                                                var current_osub_id = $('#product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').data('osub_id');

                                                var current_o_id =<?php echo $b3_interior_products_with_extensions[$k]['o_id'];?>;


                                                $.ajax({

                                                    url: "../ajax/change_product_status.php",

                                                    method: "get",

                                                    data: {
                                                        o_id:<?php echo $b3_interior_products_with_extensions[$k]['o_id'];?>,
                                                        osub_id: "<?php echo $b3_interior_products_with_extensions[$k]['osub_id'];?>",
                                                        prod_id: "<?php echo $b3_interior_products_with_extensions[$k]['prod_id'];?>",
                                                        p_status: $(this).val()
                                                    },

                                                    dataType: "html",

                                                    success: function (return_data) {

                                                        console.log(return_data);

                                                        if (return_data.trim() != "no_result_files") {


                                                            var status = $('#product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').val();


                                                            var clasa = $('#product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?> option:selected').data('status');

                                                            //console.log($('#product_status<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?> option:selected').data('status'));

                                                            $('#task<?php echo $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 ' + clasa);

                                                        } else {

                                                            alert("Upload raw file first !");

                                                        }


                                                    }

                                                });

                                            });

                                        </script>

                                    </div>

                                </div>


                                <div class="col-6 text-center">

                                    <p class="mb-0">labc: <?php

                                        if ((substr($b3_interior_products_with_extensions[$k]['prod_id'], 1) > 1300) && (substr($b3_interior_products_with_extensions[$k]['prod_id'], 1) < 1360)) {

                                            $o_desc_in_b3 = $prod->get_o_desc_in_b3($b3_interior_products_with_extensions[$k]['o_id']);


                                            $thisproductlabc = $prod->calculateProductlabc($b3_interior_products_with_extensions[$k]['prod_id']);


                                            if ($b3_interior_products_with_extensions[$k]['prod_id'] == "p1301") {

                                                echo $labc = bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b3['fac_labc_in_b3'] . " x " . $o_desc_in_b3['p1301_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            }

                                            if ($b3_interior_products_with_extensions[$k]['prod_id'] == "p1302") {

                                                echo $labc = bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b3['fac_labc_in_b3'] . " x " . $o_desc_in_b3['p1302_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            }

                                            if ($b3_interior_products_with_extensions[$k]['prod_id'] == "p1321") {

                                                echo $labc = bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b3['fac_labc_in_b3'] . " x " . $o_desc_in_b3['p1321_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            }

                                            if ($b3_interior_products_with_extensions[$k]['prod_id'] == "p1322") {

                                                echo $labc = bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b3['fac_labc_in_b3'] . " x " . $o_desc_in_b3['p1322_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            }

                                        }

                                        ?></p>

                                </div>

                            </div>

                        </div>

                        <?php

                        $activity = $prod->get_product_last_change($b3_interior_products_with_extensions[$k]['o_id'], $b3_interior_products_with_extensions[$k]['osub_id'], $b3_interior_products_with_extensions[$k]['prod_id']);

                        $task_full_name = $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];

                        if (!empty($activity)) {

                            ?>

                            <div class="row">

                                <div class="col-md-12 text-center">

                                    <p style="font-size:14px;">

                                        <?php

                                        $creator = $prod->get_client($activity['uca_id']);

                                        if (!empty($creator['c_last_name'])) {

                                            echo $creator['c_first_name'] . " " . $creator['c_last_name'];

                                        } else {

                                            echo $creator['l_first_name'] . " " . $creator['l_last_name'];

                                        }

                                        echo " " . $activity['description'] . " on " . $activity['date'];

                                        ?></p>

                                </div>


                            </div>

                            <div class="row w-100">
                                <div class="col-6 d-flex justify-content-end">
                                    <p id="counter_rollout_<?php echo $task_full_name ?>" style="font-size: 14px"></p>
                                </div>

                                <div class="col-6">
                                    <button id="btn_rollout_<?php echo $task_full_name ?>"
                                            class="btn-sm btn btn-primary text-center" data-toggle="collapse"
                                            href="#rollout_<?php echo $task_full_name ?>" role="button"
                                            aria-expanded="false"
                                            aria-controls="rollout_<?php echo $task_full_name ?>">
                                    </button>

                                    <script>

                                        <?php

                                        $o_id = $b3_interior_products_with_extensions[$k]['o_id'];
                                        $osub_id = $b3_interior_products_with_extensions[$k]['osub_id'];
                                        $prod_id = $b3_interior_products_with_extensions[$k]['prod_id'];
                                        ?>

                                        $('#btn_rollout_<?php echo $task_full_name ?>').click(function () {

                                            console.log('Function')

                                            $.ajax({
                                                url: "../ajax/get_task_images.php",
                                                method: "GET",
                                                data: {
                                                    o_id: "<?php echo $o_id ?>",
                                                    osub_id: "<?php echo $osub_id ?>",
                                                    prod_id: "<?php echo $prod_id ?>",
                                                    k: "<?php echo $k ?>",
                                                },

                                                dataType: "html",

                                                success: function (return_data) {
                                                    $("#rollout_<?php echo $task_full_name ?>").html(return_data);
                                                }
                                            })

                                        })


                                    </script>
                                </div>
                            </div>


                            <?php

                        }

                        ?>

                    </div>

                </div>



                    <div class="collapse"
                         id="rollout_<?php echo $task_full_name ?>">


                    </div>



            </div>
            <?php

            //$global_column_count++;

            $global_creator_counter++;

            }

            ?>

        </div> <!-- end one column -->

    </div> <!-- end row -->

</div> <!-- end interior -->