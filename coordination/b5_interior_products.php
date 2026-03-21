<?php

$global_column_count = 0;

$global_row_count = 0;

?>


<div class="row mx-0 w-100 interiordetails">

    <div class="row mx-0 w-100 py-2">

        <div id="column<?php echo $global_column_count; ?>" class="col-12 my-2 col-lg-4"
             style="border-bottom:2px solid #000;"> <!-- start one column -->

            <?php

            for ($k = 0;
            $k < count($b5_interior_products_with_extensions);
            $k++)

            {

            $product = $prod->get_product($b5_interior_products_with_extensions[$k]['prod_id']);


            if (($k > 0) && ($b5_interior_products_with_extensions[$k - 1]['osub_id'] != $b5_interior_products_with_extensions[$k]['osub_id']))

            {

            $global_column_count++;

            ?>

        </div> <!-- end one column -->

        <div id="column<?php echo $global_column_count; ?>" class="col-12 my-2 col-lg-4"
             style="border-bottom:2px solid #000;"> <!-- start one column -->

            <?php

            }

            ?>


            <div class="row mx-0 w-100 mb-2 <?php

            if ($b5_interior_products_with_extensions[$k]['om_id'] != 0) {

                echo "red-border";

            } ?>">

                <div id="row<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id']; ?>">

                    <div class="row w-100 mx-0 py-2 <?php

                    for ($i = 0; $i < count($allstatus); $i++) {

                        if ($allstatus[$i]['ost_id'] == $b5_interior_products_with_extensions[$k]['p_status']) {

                            echo $allstatus[$i]['ost_color'];

                        }

                    } ?>"
                         id="task<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id']; ?>">

                        <div id="fileuploader_<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id']; ?>">

                        </div>

                        <div class="col-4 my-1 text-center">

                            <div class="file-name p-2 bg-light text-dark">

                                <p class="text-danger mb-0"><strong><?php

                                        if ($b5_interior_products_with_extensions[$k]['om_id'] == 0) {

                                            echo $b5_interior_products_with_extensions[$k]['o_id'] . "." . $b5_interior_products_with_extensions[$k]['osub_id'] . "." . $b5_interior_products_with_extensions[$k]['prod_id'];

                                        } else {

                                            echo $b5_interior_products_with_extensions[$k]['om_id'] . "." . $b5_interior_products_with_extensions[$k]['osub_id'] . "." . $b5_interior_products_with_extensions[$k]['prod_id'] . "." . $b5_interior_products_with_extensions[$k]['o_id'];

                                        } ?></strong></p>


                                <p class="housemodel mb-0"><?php echo $product['prod_name']; ?></p>

                            </div>

                        </div>

                        <script type="text/javascript">

                            $(document).ready(function () {

                                $("#fileuploader_<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>").uploadFile({

                                    url: "../upload_file.php?filecategory=creatorfiles&o_id=<?php echo $b5_interior_products_with_extensions[$k]['o_id'];?>&osub_id=<?php echo $b5_interior_products_with_extensions[$k]['osub_id']; ?>&prod_id=<?php echo $b5_interior_products_with_extensions[$k]['prod_id'];?>&uca_id=<?php echo $_SESSION['client_id']; ?>",

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

                                    for ($c = 0; $c < count($customer_files); $c++) {

                                        $osub_id = substr($b5_interior_products_with_extensions[$k]['osub_id'], 1);

                                        if ($customer_files[$c]['of_position'] == $osub_id) {

                                            echo $customer_files[$c]['of_name'];

                                        }

                                    }

                                    ?>

                                </div>

                                <div class="col-12 col-xl-6 my-1 px-0 d-flex">

                                    <div class="row mx-0 w-100 align-self-center mb-0 justify-content-center d-flex ">

                                        <div class="form-group align-self-center mb-0 w-100 d-flex">

                                            <select name="creators_<?php echo $global_creator_counter; ?>"
                                                    data-prod_id="<?php echo $b5_interior_products_with_extensions[$k]['prod_id']; ?>"
                                                    id="creators_<?php echo $global_creator_counter; ?>"
                                                    data-selected_creator="<?php echo $b5_interior_products_with_extensions[$k]['uca_id']; ?>"
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


                                                $selected_creator = $prod->get_client($b5_interior_products_with_extensions[$k]['uca_id']);


                                                $creator_qualification = $prod->get_client_qualifications($selected_creator['client_ID']);

                                                $creator_right = $prod->get_client_rights($selected_creator['client_ID']);


                                                if ($creator_right['u_status'] == "active") {

                                                    ?>

                                                    <option id="creator_<?php echo $b5_interior_products_with_extensions[$k]['uca_id']; ?>"
                                                            class="walls_windows_creator_task_count offline"
                                                            data-creator_task_count="<?php

                                                            $count_working_tasks = $prod->count_working_tasks($b5_interior_products_with_extensions[$k]['uca_id']);

                                                            echo count($count_working_tasks); ?>"
                                                            value="<?php echo $b5_interior_products_with_extensions[$k]['uca_id']; ?>"
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

                                                                url: "coordination_choose_b5_in_creators.php",

                                                                method: "get",

                                                                data: {
                                                                    o_id:<?php echo $b5_interior_products_with_extensions[$k]['o_id'];?>,
                                                                    osub_id: "<?php echo $b5_interior_products_with_extensions[$k]['osub_id'];?>",
                                                                    prod_id: "<?php echo $b5_interior_products_with_extensions[$k]['prod_id'];?>"
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
                                                                o_id:<?php echo $b5_interior_products_with_extensions[$k]['o_id'];?>,
                                                                osub_id: "<?php echo $b5_interior_products_with_extensions[$k]['osub_id'];?>",
                                                                prod_id: "<?php echo $b5_interior_products_with_extensions[$k]['prod_id'];?>",
                                                                creatorid: $(this).val()
                                                            },

                                                            dataType: "html",

                                                            success: function (data) {

                                                                console.log(data);

                                                                if ($('#creators_<?php echo $global_creator_counter;?>').data("prod_id") == "p1501") {

                                                                    $('#task<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center dark-green');

                                                                    $('#product_status<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').val(4);

                                                                } else {

                                                                    $('#task<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center blue');

                                                                    $('#product_status<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').val(2);

                                                                }

                                                            }

                                                        });

                                                    });


                                                });

                                            </script>

                                            <a href="taskdetails.php?o_id=<?php echo $b5_interior_products_with_extensions[$k]['o_id']; ?>&osub_id=<?php echo $b5_interior_products_with_extensions[$k]['osub_id']; ?>&prod_id=<?php echo $b5_interior_products_with_extensions[$k]['prod_id']; ?>"
                                               class="btn btn-sm btn-primary col-5 align-self-center mx-1">Details</a>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="form-group align-self-center mb-0">

                                        <select class="form-control form-control-sm" name=""
                                                data-osub_id="<?php echo $b5_interior_products_with_extensions[$k]['osub_id']; ?>"
                                                data-prod_id="<?php echo $b5_interior_products_with_extensions[$k]['prod_id']; ?>"
                                                id="product_status<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id']; ?>">

                                            <?php

                                            for ($j = 1; $j < count($allstatus); $j++) {

                                                ?>

                                                <option value="<?php echo $allstatus[$j]['ost_id']; ?>"
                                                        data-status="<?php echo $allstatus[$j]['ost_color']; ?>" <?php echo ($allstatus[$j]['ost_id'] == $b5_interior_products_with_extensions[$k]['p_status']) ? "selected" : ""; ?>><?php echo ucfirst($allstatus[$j]['ost_name']); ?></option>

                                                <?php

                                            }

                                            ?>

                                        </select>

                                        <script type="text/javascript">

                                            $('#product_status<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').on("change", function () {

                                                var collection = $('#collection').val().split(";");

                                                var current_osub_id = $('#product_status<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').data('osub_id');

                                                var current_o_id =<?php echo $b5_interior_products_with_extensions[$k]['o_id'];?>;


                                                //console.log(collection);


                                                $.ajax({

                                                    url: "../ajax/change_product_status.php",

                                                    method: "get",

                                                    data: {
                                                        o_id:<?php echo $b5_interior_products_with_extensions[$k]['o_id'];?>,
                                                        osub_id: "<?php echo $b5_interior_products_with_extensions[$k]['osub_id'];?>",
                                                        prod_id: "<?php echo $b5_interior_products_with_extensions[$k]['prod_id'];?>",
                                                        p_status: $(this).val()
                                                    },

                                                    dataType: "html",

                                                    success: function (return_data) {

                                                        if (return_data.trim() != "no_result_files") {

                                                            var status = $('#product_status<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').val();

                                                            var clasa = $('#product_status<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?> option:selected').data('status');

                                                            $('#task<?php echo $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center ' + clasa);

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

                                        if ((substr($b5_interior_products_with_extensions[$k]['prod_id'], 1) > 1499) && (substr($b5_interior_products_with_extensions[$k]['prod_id'], 1) < 1560)) {

                                            $o_desc_in_b5 = $prod->get_o_desc_in_b5($b5_interior_products_with_extensions[$k]['o_id']);

                                            $thisproductlabc = $prod->calculateProductlabc($b5_interior_products_with_extensions[$k]['prod_id']);


                                            if ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1521") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1521_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1524") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1524_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1526") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1526_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1501") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1501_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1504") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1504_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1541") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1541_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1544") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1544_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1506") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1506_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } elseif ($b5_interior_products_with_extensions[$k]['prod_id'] == "p1546") {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $o_desc_in_b5['p1546_fac'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            } else {

                                                echo $labc = bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $thisproductlabc, 1, 2);

                                                echo "</br>";

                                                if ($labc != 0) {

                                                    echo "(" . $o_desc_in_b5['fac_labc_in_b5'] . " x " . $thisproductlabc . "=" . $labc . ")";

                                                }

                                            }

                                        }

                                        ?></p>

                                </div>

                            </div>

                        </div>

                        <?php

                        $activity = $prod->get_product_last_change($b5_interior_products_with_extensions[$k]['o_id'], $b5_interior_products_with_extensions[$k]['osub_id'], $b5_interior_products_with_extensions[$k]['prod_id']);

                        $task_full_name = $b5_interior_products_with_extensions[$k]['o_id'] . "_" . $b5_interior_products_with_extensions[$k]['osub_id'] . "_" . $b5_interior_products_with_extensions[$k]['prod_id'];


                        if (!empty($activity)) {

                            ?>

                            <div class="row">

                                <div class="col-md-12">

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
                                </div>
                            </div>

                            <?php

                        }

                        ?>

                    </div>

                </div>

                <?php

                if ($b5_interior_products_with_extensions[$k]['om_id'] != 0) {

                    $result_files = $prod->show_results($b5_interior_products_with_extensions[$k]['o_id'], $b5_interior_products_with_extensions[$k]['osub_id'], $b5_interior_products_with_extensions[$k]['prod_id']);

                } else {

                    $result_files = $prod->show_results($o_id, $b5_interior_products_with_extensions[$k]['osub_id'], $b5_interior_products_with_extensions[$k]['prod_id']);

                }

                $nv_counter = 0; //Not visible files
                $vcl_counter = 0; //Clients visible files
                $tot_counter = 0; //Total files counter

                for ($i = 0; $i < count($result_files); $i++) {

                    if ($result_files[$i]['orf_status'] == 0) {
                        $nv_counter++;
                    }
                    if ($result_files[$i]['orf_status'] == 8 || $result_files[$i]['orf_status'] == 6) {
                        $vcl_counter++;
                    }
                    $tot_counter++;

                    ?>
                    <div class="collapse"
                         id="rollout_<?php echo $task_full_name ?>">
                        <div class="row w-100 mx-0 border-top border-white <?php echo ($result_files[$i]['orf_status'] == 0) ? "grey-dark" : "light-green"; ?>"
                             id="result_file<?php echo $result_files[$i]['orf_id']; ?>">

                            <div class="col-6 px-0 py-2 text-center d-flex align-items-start">

                                <div class="row mx-0 w-100 d-flex justify-content-center align-items-start">

                                    <div class="col-10 px-0 d-flex align-items-start flex-row">

                                        <div class="justify-content-center w-100">

                                            <div class="file-name w-100 text-center d-flex flex-row justify-content-center">

                                                <p class="mb-0 pt-0 d-flex justify-content-center align-items-center"
                                                   style="font-size: 13px;">

                                                    <?php

                                                    $file_name1 = explode("-", $result_files[$i]['orf_name']);
                                                    $file_name2 = explode(".", $result_files[$i]['orf_name']);

                                                    $first_part_with_space = $file_name1[0];

                                                    $first_part = str_replace(' ', '', $first_part_with_space);

                                                    echo $first_part;

                                                    ?>

                                                    &nbsp;<input type="text" style="max-height: 18px;max-width: 70px;"
                                                                 name="file_name"
                                                                 id="file_name<?php echo $result_files[$i]['orf_id'] ?>"
                                                                 value="<?php

                                                                 $middle_part_with_space = explode('.', $file_name1[1]);

                                                                 $middle_part = str_replace(' ', '', $middle_part_with_space);

                                                                 echo $middle_part[0];

                                                                 ?>" data-file_name_first_part="<?php

                                                    echo $first_part . " - ";

                                                    ?>" data-file_name_last_part="<?php

                                                    $last_part = end($file_name2);

                                                    echo "." . $last_part;

                                                    ?>" class="form-control form-control-sm"><?php

                                                    echo "." . $last_part;

                                                    ?>
                                                </p>

                                                <div class="row w-100 mx-0 px-0 d-flex justify-content-center">
                                                    <button id="rename_btn<?php echo $result_files[$i]['orf_id'] ?>"
                                                            class="btn btn-sm btn-primary mt-1 d-inline rounded-0"
                                                            style="font-size:13px;">Rename
                                                    </button>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-2 px-0 d-flex align-items-center">

                                        <script type="text/javascript">

                                            $('#rename_btn<?php echo $result_files[$i]['orf_id']?>').click(function () {

                                                $.ajax({
                                                    url: "<?php echo $base_url;?>ajax/rename_result_file.php",
                                                    method: "post",
                                                    data: {

                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                        file_name: $('#file_name<?php echo $result_files[$i]['orf_id']?>').val(),
                                                        file_name_first_part: $('#file_name<?php echo $result_files[$i]['orf_id']?>').data('file_name_first_part'),
                                                        file_name_last_part: $('#file_name<?php echo $result_files[$i]['orf_id']?>').data('file_name_last_part')

                                                    },
                                                    dataType: "html",
                                                    success: function (data) {

                                                    }

                                                });

                                            });

                                        </script>

                                        <?php

                                        if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) {


                                            if (($result_files[$i]['prod_id'] == "p1506") || ($result_files[$i]['prod_id'] == "p1526") || ($result_files[$i]['prod_id'] == "p1546") || ($result_files[$i]['prod_id'] == "p1566")) {

                                                ?>

                                                <style>

                                                    #panorama<?php echo $image_preview_counter;?> {
                                                        width: 100%;
                                                    }

                                                </style>

                                                <script>

                                                    $(document).ready(function () {

                                                        document.getElementById('panorama<?php echo $image_preview_counter;?>').style.height = window.innerHeight * 0.7 + 'px';
                                                        document.getElementById('modal-dialog<?php echo $image_preview_counter;?>').style.height = window.innerHeight * 0.7 + 'px';
                                                        document.getElementById('modal-dialog<?php echo $image_preview_counter;?>').style.maxWidth = window.innerWidth * 0.7 + 'px';


                                                        pannellum.viewer('panorama<?php echo $image_preview_counter;?>', {

                                                            "type": "equirectangular",
                                                            "panorama": "https://cseven.eu/studio/result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom'];?>",
                                                            // "autoLoad": true

                                                        });
                                                    });

                                                </script>

                                            <?php

                                            if ($b7_interior_products_with_extensions[$k]['prod_id'][4] != '6') {

                                            if (!empty($result_files[$i]['orf_thumbnail_path']))

                                            {

                                            ?>

                                                <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                   target="_blank"><img data-toggle="modal"
                                                                        data-target="#pic360_<?php echo $image_preview_counter; ?>"
                                                                        src="../result_thumbnail_files/<?php echo $result_files[$i]['orf_thumbnail_path']; ?>"
                                                                        alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                                        width="60" heigth="33.78"
                                                                        class="img-responsive d-inline img-fluid"></a>

                                                <?php

                                            }

                                            else {

                                                ?>

                                                <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                   target="_blank"><img data-toggle="modal"
                                                                        data-target="#pic360_<?php echo $image_preview_counter; ?>"
                                                                        src="../result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                                        alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                                        width="60" heigth="33.78"
                                                                        class="img-responsive d-inline img-fluid"></a>

                                            <?php

                                            }

                                            }

                                            else {

                                            if (!empty($result_files[$i]['orf_thumbnail_path']))

                                            {

                                                ?>

                                                <img data-toggle="modal"
                                                                        data-target="#pic360_<?php echo $image_preview_counter; ?>"
                                                                        src="../result_thumbnail_files/<?php echo $result_files[$i]['orf_thumbnail_path']; ?>"
                                                                        alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                                        width="60" heigth="33.78"
                                                                        class="img-responsive d-inline img-fluid">

                                                <?php

                                            }

                                            else {

                                                ?>

                                                <img data-toggle="modal"
                                                                        data-target="#pic360_<?php echo $image_preview_counter; ?>"
                                                                        src="../result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                                        alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                                        width="60" heigth="33.78"
                                                                        class="img-responsive d-inline img-fluid">

                                            <?php

                                            }

                                            }

                                            ?>

                                                <!-- Modal -->

                                                <div class="modal fade"
                                                     id="pic360_<?php echo $image_preview_counter; ?>"
                                                     tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">

                                                    <div class="modal-dialog" role="document">

                                                        <div class="modal-content">

                                                            <div class="modal-header">

                                                                <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->

                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">

                                                                    <span aria-hidden="true">&times;</span>

                                                                </button>

                                                            </div>

                                                            <div class="modal-body">

                                                                <div id="panorama<?php echo $image_preview_counter; ?>"></div>

                                                            </div>


                                                        </div>

                                                    </div>

                                                </div>


                                            <?php

                                            }

                                            else

                                            {

                                            ?>

                                                <div id="image_tooltip_container_<?php echo $image_preview_counter; ?>">

                                                    <?php

                                                    if (!empty($result_files[$i]['orf_thumbnail_path'])) {

                                                        ?>

                                                        <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                           target="_blank"><img
                                                                    src="../result_thumbnail_files/<?php echo $result_files[$i]['orf_thumbnail_path']; ?>"
                                                                    alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                                    width="60"
                                                                    heigth="33.78" class="d-inline"></a>

                                                        <?php

                                                    } else {

                                                        ?>

                                                        <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                           target="_blank"><img class="img-fluid"
                                                                                src="../result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                                                alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                                                width="60" heigth="33.78"
                                                                                class="d-inline"></a>

                                                        <?php

                                                    }

                                                    ?>

                                                </div>

                                                <?php

                                            }

                                        }

                                        ?>

                                    </div>

                                </div>

                            </div>

                            <div class="col-6 px-0 py-2">

                                <p class="w-100 text-center mb-0" style="font-size: 12px;"><?php

                                    $creator = $prod->get_client($result_files[$i]['uca_id']);

                                    if (!empty($creator['c_last_name'])) {

                                        echo $creator['c_first_name'] . " " . $creator['c_last_name'];

                                    } else {

                                        echo $creator['l_first_name'] . " " . $creator['l_last_name'];

                                    }

                                    $uploaded_date_time = explode(" ", $result_files[$i]['orf_upload_date']);

                                    echo " " . $uploaded_date_time[0] . ", " . $uploaded_date_time[1] . " UTC+0"; ?></p>

                                <div class="w-100 d-flex justify-content-center">

                                    <div class="form-group mb-0">

                                        <select name="result_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                                                id="result_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                                                class="form-control form-control-sm">

                                            <option value="0" <?php echo ($result_files[$i]['orf_status'] == 0) ? "selected" : ""; ?>>
                                                Not visible
                                            </option>

                                            <option value="7" <?php echo ($result_files[$i]['orf_status'] == 7) ? "selected" : ""; ?>>
                                                Visible for checkers
                                            </option>

                                            <option value="8" <?php echo ($result_files[$i]['orf_status'] == 8) ? "selected" : ""; ?>>
                                                Visible for client
                                            </option>

                                        </select>

                                        <script type="text/javascript">

                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {


                                                $.ajax({

                                                    url: "../ajax/change_results_file_visibility.php",

                                                    method: "get",

                                                    data: {
                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                        orf_status: $(this).val()
                                                    },

                                                    dataType: "html",

                                                    success: function (data) {

                                                        console.log(data);

                                                        if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8) {

                                                            $('#result_file<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark").addClass("light-green");

                                                        } else {

                                                            $('#result_file<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green").addClass("grey-dark");

                                                        }

                                                    }

                                                });

                                            });

                                        </script>

                                    </div>


                                    <a href="../image.php?filecategory=creatorfiles&orfid=<?php echo $result_files[$i]['orf_id']; ?>"
                                       class="btn btn-sm btn-primary align-self-center ml-1">Download</a>


                                    <button id="delete_btn<?php echo $result_files[$i]['orf_id']; ?>"
                                            class="btn btn-sm btn-danger text-white align-self-center ml-1">x
                                    </button>

                                    <script type="text/javascript">

                                        $('#delete_btn<?php echo $result_files[$i]['orf_id']?>').click(function () {

                                            if (confirm('Are you sure want to delete ?')) {

                                                $.ajax({

                                                    url: "../ajax/delete_result_file.php",

                                                    method: "post",

                                                    data: {orf_id:<?php echo $result_files[$i]['orf_id'];?>},

                                                    dataType: "html",

                                                    success: function (data) {

                                                        console.log(data);

                                                        $('#result_file<?php echo $result_files[$i]['orf_id'];?>').fadeOut(3000);

                                                    }

                                                });

                                            }

                                        });

                                    </script>

                                </div>

                            </div>

                            <div class="col-6 px-2 py-0">

                                <p class="my-0 d-flex" style="font-size:12px;">
                                    <span class="pt-1">Title:</span>
                                    <input id="title<?php echo $result_files[$i]['orf_id']; ?>"
                                           list="img_categ2_<?php echo $result_files[$i]['orf_id']; ?>"
                                           class="form-control form-control-sm" type="text"
                                           value="<?php echo $result_files[$i]['pict_categ_name']; ?>">
                                    <?php
                                    if ((substr($result_files[$i]['prod_id'], -2) === '00') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '01') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '02') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '03') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '21') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '22') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '23') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '41') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '42') ||
                                        (substr($result_files[$i]['prod_id'], -2) === '43')
                                    ) {
                                        ?>
                                        <datalist id="img_categ2_<?php echo $result_files[$i]['orf_id']; ?>"
                                                  data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
                                            <option value="EG">EG</option>
                                            <option value="OG">OG</option>
                                            <option value="OG 1">OG 1</option>
                                            <option value="OG 2">OG 2</option>
                                            <option value="DG">DG</option>
                                            <option value="KG">KG</option>
                                        </datalist>
                                        <?php
                                    }
                                    ?>
                                    <script type="text/javascript">
                                        $('#title<?php echo $result_files[$i]['orf_id'];?>').on("keyup", function () {
                                            $.ajax({
                                                url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                method: "post",
                                                data: {
                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
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

                            <div class="col-6 px-0 py-0 text-right">

                                <p class="my-0 pr-5" style="font-size:12px;">
                                    size: <?php echo $filesize = $prod->filesize_formatted("../result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']); ?></p>

                            </div>

                        </div> <!-- end result files -->
                    </div>
                    <?php

                    $image_preview_counter++;

                }

                ?>

                <script>
                    document.getElementById("btn_rollout_<?php echo $task_full_name ?>").innerText = "Show files <?php echo $tot_counter?>";
                    document.getElementById("counter_rollout_<?php echo $task_full_name ?>").innerText = "<?php echo 'Not visible: ' . $nv_counter . ' Visible: ' . $vcl_counter?>";
                </script>
            </div>


            <?php

            $global_row_count++;

            //$global_column_count++;

            $global_creator_counter++;

            }

            ?>

        </div> <!-- end one column -->

    </div> <!-- end row -->

</div> <!-- end interior -->

