<?php
//session_set_cookie_params(14400,"/");
session_start();
include('functions.php');
include('../../../domenia7.com/public_html/domenia_db2.php');
include('../../../blue7.it/public_html/domenia/domenia.php');
include('domenia3n_db.php');

$domenia = new Domenia;
$domenia2 = new Domenia2;
$domenia3n = new Domenia3n;
$prod = new Production;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

$picture_website = "https://domenia.blue7.it/";
$base_url="https://blue7.it/studio/";

include('header2.php');
include('menu.php');

$o_id = $prod->xss_fix($_GET['o_id']);
$order = $prod->get_order($o_id);
?>
    <section class="pt-5 acceptance">
        <?php
        if($order['house_id']!=0)
        {
            ?>
            <div class="row">
                <div class="col-md-12 text-center text-danger" style="font-size:18px;">
                    <b>There is a houseset connected !</b>
                </div>
            </div>
            <br>
            <?php
        }
        ?>
        <article>
            <?php
            if (isset($_COOKIE['client_id']) && ($_COOKIE['start'] < $_COOKIE['expire'])) {
                $option = $_GET['option'];

                if (isset($_POST['send_message_btn'])) {
                    $o_id = $prod->xss_fix($_POST['o_id']);
                    $osub_id = $prod->xss_fix($_POST['osub_id']);
                    $prod_id = $prod->xss_fix($_POST['prod_id']);
                    $message = $prod->xss_fix($_POST['message']);
                    $user_id = $prod->xss_fix($_POST['user_id']);

                    $prod->insert_message($o_id, $osub_id, $prod_id, $user_id, $message);
                    ?>
                    <meta http-equiv="refresh"
                          content="0; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                    <?php
                }

                if ((isset($option)) && ($option == "changestatus")) {
                    $o_id = $prod->xss_fix($_GET['o_id']);
                    $osub_id = $prod->xss_fix($_GET['osub_id']);
                    $prod_id = $prod->xss_fix($_GET['prod_id']);
                    $p_status = $prod->xss_fix($_GET['p_status']);

                    $prod->update_o_prods_status($o_id, $osub_id, $prod_id, $p_status);

                    if ($p_status == 7) {
                        $prod->update_order_status($o_id, $o_status = 7);
                    }
                    if ($p_status == 9) {
                        $prod->update_order_status($o_id, $o_status = 9);
                    }
                    ?>
                    <meta http-equiv="refresh"
                          content="1; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                    <?php
                }

                if (isset($_POST['result_file_rename_btn'])) {
                    $orf_id = $prod->xss_fix($_POST['orf_id']);
                    $orf_name = $prod->xss_fix($_POST['result_filename']);

                    $prod->result_file_rename($orf_id, $orf_name);
                }

               

//start taskdetails

                $o_id = $prod->xss_fix($_GET['o_id']);
                $osub_id = $prod->xss_fix($_GET['osub_id']);
                $prod_id = $prod->xss_fix($_GET['prod_id']);

                $order = $prod->get_order($o_id);
                $allstatus = $prod->showallstatus();
                $product = $prod->get_product($prod_id);

                $producer = $prod->check_assigned_status($o_id, $osub_id, $prod_id);
                $producer_name = $prod->get_client($producer['uca_id']);

                $o_desc_ex_b5 = $prod->get_o_desc_ex_b5($o_id);
                $o_desc_allproducts = $prod->get_o_infos_allproducts($o_id);

                $order_client = $prod->get_client($order['u_client_ID']);
                $main_client = $prod->get_main_client($order['mc_id']);

                $image_preview_counter = 0;
                $validextensions = array("jpeg", "jpg", "png","webp");
                ?>

                <div class="row w-100 mx-0">

                    <div class="col-lg-2 col-sm-12 col-12">
                        <p class="w-100 text-center"><b>Finished exterior files:</b></p>
                        <button class="btn btn-block btn-sm btn-dark mb-2" data-toggle="collapse"
                                data-target="#finishedExterior" aria-expanded="true">Finished exterior files!
                            <strong><span>Hide</span></strong></button>
                        <?php
                        //b5 exterior
                        $b5_ex_results = $prod->get_b5_ex_results_with_extensions($o_id);

                        for ($j = 0; $j < count($b5_ex_results); $j++) {
                            if ($b5_ex_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row w-100 mx-0 colorline <?php
                                if ($b5_ex_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedExterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center ">
                                                <?php
                                                //$product_name=$prod->get_product($b5_ex_results[$j]['prod_id']);
                                                //echo $b5_ex_results[$j]['o_id'].".".$b5_ex_results[$j]['osub_id'].".".$b5_ex_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b5_ex_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b5_ex_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b5_ex_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b5_ex_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b5_ex_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b5_ex_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <?php
                                            if (in_array($b5_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b5_ex_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b5_ex_results[$j]['orf_path_dom'] . $b5_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b5_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b5_ex_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b5_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (in_array($b5_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b5_ex_results[$j]['orf_path_dom'] . $b5_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b5_ex_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }

                        //b6 exterior
                        $b6_ex_results = $prod->get_b6_ex_results_with_extensions($o_id);

                        for ($j = 0; $j < count($b6_ex_results); $j++) {
                            if ($b6_ex_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row w-100 mx-0 colorline <?php
                                if ($b6_ex_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedExterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center">
                                                <?php
                                                //$product_name=$prod->get_product($b5_ex_results[$j]['prod_id']);
                                                //echo $b5_ex_results[$j]['o_id'].".".$b5_ex_results[$j]['osub_id'].".".$b5_ex_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b6_ex_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b6_ex_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b6_ex_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b6_ex_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b6_ex_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b6_ex_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <?php
                                            if (in_array($b6_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b6_ex_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b6_ex_results[$j]['orf_path_dom'] . $b6_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b6_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b6_ex_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b6_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (in_array($b6_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b6_ex_results[$j]['orf_path_dom'] . $b6_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b6_ex_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }

                        //b7 exterior
                        $b7_ex_results = $prod->get_b7_ex_results_with_extensions($o_id);

                        for ($j = 0; $j < count($b7_ex_results); $j++) {
                            if ($b7_ex_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row w-100 mx-0 colorline <?php
                                if ($b7_ex_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedExterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center">
                                                <?php
                                                //$product_name=$prod->get_product($b5_ex_results[$j]['prod_id']);
                                                //echo $b5_ex_results[$j]['o_id'].".".$b5_ex_results[$j]['osub_id'].".".$b5_ex_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b7_ex_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b7_ex_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b7_ex_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b7_ex_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b7_ex_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b7_ex_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <?php
                                            if (in_array($b7_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b7_ex_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b7_ex_results[$j]['orf_path_dom'] . $b7_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b7_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b7_ex_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b7_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (in_array($b7_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b7_ex_results[$j]['orf_path_dom'] . $b7_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b7_ex_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }


                        //b8 exterior
                        $b8_ex_results = $prod->get_b8_ex_results_with_extensions($o_id);

                        for ($j = 0; $j < count($b8_ex_results); $j++) {
                            if ($b8_ex_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row w-100 mx-0 colorline <?php
                                if ($b8_ex_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedExterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center">
                                                <?php
                                                //$product_name=$prod->get_product($b5_ex_results[$j]['prod_id']);
                                                //echo $b5_ex_results[$j]['o_id'].".".$b5_ex_results[$j]['osub_id'].".".$b5_ex_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b8_ex_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b8_ex_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b8_ex_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b8_ex_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b8_ex_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b8_ex_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <?php
                                            if (in_array($b8_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b8_ex_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b8_ex_results[$j]['orf_path_dom'] . $b8_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b8_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b8_ex_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b8_ex_results[$j]['orf_name']; ?>">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (in_array($b8_ex_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b8_ex_results[$j]['orf_path_dom'] . $b8_ex_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b8_ex_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }
                        ?>

                    </div>

                    <div class="col-lg-8 col-sm-12 col-12 text-center mb-5 bg-white px-0 container pagecontent"
                         style="font-size:14px;">
                        <br>
                        <div class="row w-100 mx-0 d-flex justify-content-center pt-3">
                            <a href="orderdetails.php?orderid=<?php echo $o_id; ?>" class="btn btn-success btn-sm"><= Go
                                back to all Tasks</a>
                            <h5 class="ml-2 pt-1">
                                <b>Details on Task <?php
                                    if ($order['om_id'] == 0) {
                                        echo $o_id . "." . $osub_id . "." . $prod_id;
                                    } else {
                                        echo $order['om_id'] . "." . $osub_id . "." . $prod_id . "." . $o_id;
                                    } ?></b>
                            </h5>
                            <a href="https://bauvorschau.com/<?php echo $o_id; ?>"
                               class="btn btn-primary btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
                               target="_blank">Presentation</a>
                        </div>

                        <div class="row w-100 mx-0 ">
                            <div class="col-md-12 m-0 p-0">
                                <?php
                                if ($order['mc_id'] == 1) {
                                    ?>
                                    <img src="img/streif_logo_background.png" class="img-fluid" style="max-height:40px;width:100%;">
                                    <?php
                                }
                                if ($order['mc_id'] == 4) {
                                    ?>
                                    <img src="img/bodenseehaus_logo_background.png" class="img-fluid" style="max-height:40px;width:100%;">
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div id="task<?php echo $o_id . "_" . $osub_id . "_" . $prod_id; ?>"
                             class="row w-100 mx-0 py-3 mb-2 <?php
                             for ($i = 0; $i < count($allstatus); $i++) {
                                 if ($allstatus[$i]['ost_id'] == $producer['p_status']) {
                                     echo $allstatus[$i]['ost_color'];
                                 }
                             }
                             ?>">
                            <div class="col-md-3 pt-2">
                                <?php
                                if ($order['om_id'] == 0) {
                                    echo $o_id . "." . $osub_id . "." . $prod_id;
                                } else {
                                    echo $order['om_id'] . "." . $osub_id . "." . $prod_id . "." . $o_id;
                                }

                                $customer_files = $prod->get_customer_files($o_id);

                                for ($j = 0; $j < count($customer_files); $j++) {

                                    if ($customer_files[$j]['of_position'] == substr($osub_id, 2)) {
                                        echo $customer_files[$j]['of_level'] . " " . $customer_files[$j]['of_name'];
                                    }
                                }
                                echo " " . $product['prod_name']; ?>
                            </div>
                            <div class="col-md-3">
                                <div class="form-inline pt-1">
                                    <p class="d-inline mb-0 mr-2">Assigned to:</p>
                                    <select name="creators" id="creators" class="form-control form-control-sm" disabled>

                                        <?php
                                        //$creators=$prod->get_client($_COOKIE['client_id']);

                                        // for($i=0;$i<count($creators);$i++)
                                        // {
                                        ?>
                                        <option><?php
                                            if (!empty($producer_name['c_last_name'])) {
                                                echo $producer_name['c_first_name'] . " " . $producer_name['c_last_name'];
                                            } else {
                                                echo $producer_name['l_first_name'] . " " . $producer_name['l_last_name'];
                                            } ?></option>
                                        <?php
                                        // }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="pt-2">Project name: <?php echo $order['order_name']; ?></div>
                                <div class="pt-2">Sub ID: <?php echo $osub_id.":"; 

                                $subo_data['o_id']=$o_id;
                                $subo_data['o_sub_id']=$osub_id;

                                $subo_name=$prod->check_existing_subid(json_encode($subo_data));
                                
                                echo " ".$subo_name['subo_name'];
                                ?></div>
                            </div>
                            <div class="col-md-4 pt-1">
                                <div class="form-inline"><p class="d-inline mr-1 mb-0">Status:</p> <b><?php
                                        for ($i = 1; $i < count($allstatus); $i++) {
                                            if ($allstatus[$i]['ost_id'] == $producer['p_status']) {
                                                echo ucfirst($allstatus[$i]['ost_name']);
                                            }
                                        }
                                        ?></b>
                                    <select name="product_status"
                                            id="product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id; ?>"
                                            class="form-control form-control-sm" <?php
                                    echo ($producer['p_status'] == 8) ? "disabled" : "";

                                    $prod_501_status = $prod->check_assigned_status($o_id, $osub_id, "p1501");
                                    $prod_521_status = $prod->check_assigned_status($o_id, $osub_id, "p1521");
                                    $prod_541_status = $prod->check_assigned_status($o_id, $osub_id, "p1541");

                                    if ((substr($prod_id, 1) > 1501) && (substr($prod_id, 1) < 1508) && ($prod_501_status['p_status'] != 8)) {
                                        echo "disabled";
                                    }

                                    if ((substr($prod_id, 1) > 1521) && (substr($prod_id, 1) < 1528) && ($prod_521_status['p_status'] != 8)) {
                                        echo "disabled";
                                    }

                                    if ((substr($prod_id, 1) > 1541) && (substr($prod_id, 1) < 1548) && ($prod_541_status['p_status'] != 8)) {
                                        echo "disabled";
                                    }
                                    ?>>
                                        <option>-- Change --</option>
                                        <?php
                                        for ($i = 1; $i < count($allstatus); $i++) {
                                            if (($allstatus[$i]['ost_id'] == 4) || ($allstatus[$i]['ost_id'] == 7) || ($allstatus[$i]['ost_id'] == 6.1) || ($allstatus[$i]['ost_id'] == 13)) {
                                                ?>
                                                <option value="<?php echo $allstatus[$i]['ost_id']; ?>"
                                                        data-status="<?php echo $allstatus[$i]['ost_color']; ?>" <?php echo ($allstatus[$i]['ost_id'] == $producer['p_status']) ? "selected" : ""; ?>><?php echo ucfirst($allstatus[$i]['ost_name']); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                    <script type="text/javascript">
                                        $('#product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').on("change", function () {
                                            $.ajax({
                                                url: "<?php echo $base_url;?>ajax/change_product_status.php",
                                                method: "get",
                                                data: {
                                                    o_id:<?php echo $o_id;?>,
                                                    osub_id: "<?php echo $osub_id;?>",
                                                    prod_id: "<?php echo $prod_id;?>",
                                                    p_status: $(this).val()
                                                },
                                                dataType: "html",
                                                success: function (data) {
                                                    console.log(data);
                                                    var status = $('#product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').val();

                                                    // for(i=1;i<13;i++)
                                                    // {
                                                    //     if(status==i)
                                                    //     {
                                                    var clasa = $('#product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?> option:selected').data('status');
                                                    console.log($('#product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?> option:selected').data('status'));
                                                    $('#task<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').removeClass().addClass('row w-100 mx-0 py-3 mb-2 ' + clasa);
                                                    //     }
                                                    // }

                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                       

                        <div class="row w-100 mx-0">
                            <div class="col-md-12 justify-content-center" style="<?php
                            if ((substr($prod_id, 1) > 1500) && (substr($prod_id, 1) < 1560)) {
                                echo "text-align:center;padding-top:8px;";
                            }
                            ?>">
                                <?php

                                if (((substr($prod_id, 1) > 1300) && (substr($prod_id, 1) < 1360)) || ((substr($prod_id, 1) > 1560) && (substr($prod_id, 1) < 1599)) || ((substr($prod_id, 1) > 1660) && (substr($prod_id, 1) < 1699)) || ((substr($prod_id, 1) > 1760) && (substr($prod_id, 1) < 1799)) || ((substr($prod_id, 1) > 1860) && (substr($prod_id, 1) < 1899))) {
                                    
                                    //}
                                    ?>
                                    <div class="itemselected dark-gray">
                                        <div class="w-100 row pl-4 mx-0 productselected d-flex justify-content-center mb-2 py-4 border-top border-bottom border-secondary">
                                            <?php
                                            $all_roof_shapes = $domenia2->get_all_roof_shapes();

                                            for ($i = 0; $i < count($all_roof_shapes); $i++) {
                                                if ($all_roof_shapes[$i]['rs_id'] == $o_desc_allproducts['roof_type']) {
                                                    ?>
                                                    <div class="mywidth product row1" data-position="1">
                                                        <p class="text-center text-success mb-0">
                                                            <strong>Roof shape:</strong>
                                                        </p>
                                                        <img class="img-responsive"
                                                             src="<?php echo $picture_website . $all_roof_shapes[$i]['rs_pic']; ?>"
                                                             class="img-fluid d-block mr-auto ml-auto" alt="">
                                                        <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>

                                                        <div class="clear"></div>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            $roof_color = $domenia2->get_roof_color_by_id($o_desc_allproducts['roof_material']);
                                            ?>
                                            <div class="mywidth product row2" data-position="2">
                                                <p class="text-center text-success mb-0">
                                                    <strong>Roof Material:</strong>
                                                </p>
                                                <img class="img-responsive"
                                                     src="<?php echo $picture_website . $roof_color['rmp_pic']; ?>"
                                                     class="img-fluid d-block mr-auto ml-auto"
                                                     alt="<?php echo $roof_color['rmp_colorname']; ?>">
                                                <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>

                                                <div class="clear"></div>
                                            </div>

                                            <div class="mywidth product row5" data-position="3"><p
                                                        class="text-center text-success mb-0">
                                                    <strong class="mt-4 pt-4">Roof inclination:</strong>
                                                </p>
                                                <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                <div class="text-center">
                                                    <span><?php echo $o_desc_allproducts['roof_tilt']; ?>°</span>
                                                </div>
                                                <div class="clear"></div>
                                            </div>

                                            <div class="mywidth product row6" data-position="4"><p
                                                        class="text-center text-success mb-0">
                                                    <strong>Kniestock</strong>
                                                </p>
                                                <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                <div class="text-center">
                                                    <span><?php echo $o_desc_allproducts['knee_wall']; ?></span>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            <?php
                                            $roof_overstand = $domenia2->get_all_roof_overstand();

                                            for ($i = 0; $i < count($roof_overstand); $i++) {
                                                $roof_overstand_pic = $domenia2->get_roof_overstand_picture($roof_overstand[$i]['ro_id']);
                                                for ($j = 0; $j < count($roof_overstand_pic); $j++) {
                                                    if ($roof_overstand_pic[$j]['rop_id'] == $o_desc_allproducts['rop_id']) {
                                                        ?>
                                                        <div class="mywidth product row7" data-position="5"><p
                                                                    class="text-center text-success mb-0">
                                                                <strong>Eaves</strong>
                                                            </p>
                                                            <img class="img-responsive"
                                                                 src="<?php echo $picture_website . $roof_overstand_pic[$j]['rop_pic']; ?>"
                                                                 class="img-fluid d-block mr-auto ml-auto" alt="">
                                                            <span class="icon-cheked">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </span>

                                                            <div class="clear"></div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>

                                            <div class="mywidth product row8 input" data-position="6"><p
                                                        class="text-center text-success mb-0">
                                                    <strong class="">
                                                        External Dimensions
                                                    </strong>
                                                </p>
                                                <?php
                                                if ((!empty($o_desc_allproducts['length'])) && (!empty($o_desc_allproducts['width']))) {
                                                    ?>
                                                    <p class="text-center text-secondary mt-1 mb-0">Lenght (cm)</p>
                                                    <p class="text-center text-dark mb-0">
                                                        <strong><?php echo $o_desc_allproducts['length']; ?></strong>
                                                    </p>
                                                    <p class="text-center text-secondary mt-1 mb-0">Depth (cm)</p>
                                                    <p class="text-center text-dark mb-0">
                                                        <strong><?php echo $o_desc_allproducts['width']; ?></strong></p>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <p class="text-center text-dark mb-0"><strong>Check
                                                            floorplans</strong></p>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <?php
                                            $gutters = $domenia2->get_all_gutters();

                                            for ($i = 0; $i < count($gutters); $i++) {
                                                if ($gutters[$i]['gut_id'] == $o_desc_allproducts['gutter']) {
                                                    ?>
                                                    <div class="mywidth product row9" data-position="7"><p
                                                                class="text-center text-success mb-0">
                                                            <strong class="">
                                                                Facades
                                                            </strong>
                                                        </p>
                                                        <img class="img-responsive"
                                                             src="<?php echo $picture_website . $gutters[$i]['gut_pic']; ?>"
                                                             class="img-fluid d-block mr-auto ml-auto"
                                                             alt="<?php echo $gutters[$i]['gut_name_db']; ?>">
                                                        <span class="icon-cheked">
                            <i class="fas fa-check-circle text-success"></i>
                        </span>

                                                        <div class="clear"></div>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            $all_colors = $domenia2->get_all_color_pictures();

                                            $color = explode(';', $o_desc_allproducts['wlc_id']);
                                            for ($i = 0; $i < count($all_colors); $i++) {
                                                if ($all_colors[$i]['clp_id'] == $color[0]) {
                                                    ?>
                                                    <div class="mywidth product row10" data-position="8"><p
                                                                class="text-center text-success mb-0">
                                                            <strong>1. Colour</strong>
                                                        </p>
                                                        <img class="img-responsive"
                                                             src="<?php echo $picture_website . $all_colors[$i]['clp_pic']; ?>"
                                                             class="img-fluid border border-secondary d-block mr-auto ml-auto"
                                                             alt="<?php echo $all_colors[$i]['clp_pic']; ?>">
                                                        <span class="icon-cheked">
                            <i class="fas fa-check-circle text-success"></i>
                        </span>
                                                        <div class="text-center pb-4">
                                                            <span><?php echo $all_colors[$i]['clp_name_db']; ?></span>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            for ($i = 0; $i < count($all_colors); $i++) {
                                                if ($all_colors[$i]['clp_id'] == $color[1]) {
                                                    ?>
                                                    <div class="mywidth product row11" data-position="9"><p
                                                                class="text-center text-success mb-0">
                                                            <strong>2. Colour</strong>
                                                        </p>
                                                        <img class="img-responsive"
                                                             src="<?php echo $picture_website . $all_colors[$i]['clp_pic']; ?>"
                                                             class="img-fluid border border-secondary d-block mr-auto ml-auto"
                                                             alt="<?php echo $all_colors[$i]['clp_pic']; ?>">
                                                        <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                        <div class="text-center pb-4">
                                                            <span><?php echo $all_colors[$i]['clp_name_db']; ?></span>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            $wall_wood = $domenia2->get_all_wall_wood_pictures();

                                            for ($i = 0; $i < count($wall_wood); $i++) {
                                                if ($wall_wood[$i]['wwp_id'] == $o_desc_allproducts['ww_id']) {
                                                    ?>
                                                    <div class="mywidth product row12 px-0" data-position="10"><p
                                                                class="text-center text-success mb-0">
                                                            <strong>Wood applications</strong>
                                                        </p>
                                                        <img class="img-responsive"
                                                             src="<?php echo $picture_website . $wall_wood[$i]['wwp_pic'] ?>"
                                                             class="img-fluid d-block mr-auto ml-auto" alt="Copper">
                                                        <span class="icon-cheked">
                                    <i class="fas fa-check-circle text-success"></i>
                                </span>
                                                        <div class="text-center">
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            if ($o_desc_allproducts['wc_id'] == "col_0001") {
                                                ?>
                                                <div class="mywidth product row15" data-position="11"><p
                                                            class="text-center text-success mb-0">
                                                        <strong class="">
                                                            Window
                                                        </strong>
                                                    </p>
                                                    <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                    <div class="text-center pb-4">
                                                        <span>White</span>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <?php
                                            } elseif ($o_desc_allproducts['wc_id'] == "col_8007") {
                                                ?>
                                                <div class="mywidth product row15" data-position="11"><p
                                                            class="text-center text-success mb-0">
                                                        <strong class="">
                                                            Window
                                                        </strong>
                                                    </p>
                                                    <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                    <div class="text-center pb-4">
                                                        <span>Holzoptik</span>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <?php
                                            } elseif ($o_desc_allproducts['wc_id'] == "col_7016") {
                                                ?>
                                                <div class="mywidth product row15" data-position="11"><p
                                                            class="text-center text-success mb-0">
                                                        <strong class="">
                                                            Window
                                                        </strong>
                                                    </p>
                                                    <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                    <div class="text-center pb-4">
                                                        <span>Anthrazit</span>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <?php
                                            }

                                            if ($o_desc_allproducts['door_color'] == $o_desc_allproducts['wc_id']) {
                                                ?>
                                                <div class="mywidth product row16" data-position="12"><p
                                                            class="text-center text-success mb-0">
                                                        <strong class="">
                                                            Front door (HT)
                                                        </strong>
                                                    </p>
                                                    <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                    <div class="text-center py-4">
                                                        <span>Like windows</span>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <?php
                                            }

                                            $door_shapes = $domenia2->get_all_door_shapes();

                                            for ($i = 0; $i < count($door_shapes); $i++) {
                                                $door_color = $domenia2->get_door_colors($door_shapes[$i]['ds_id']);

                                                for ($j = 0; $j < count($door_color); $j++) {
                                                    if ($door_color[$j]['dsp_id'] == $o_desc_allproducts['door_texture']) {
                                                        ?>
                                                        <div class="mywidth product row17" data-position="13"><p
                                                                    class="text-center text-success mb-0">
                                                                <strong>Door forms</strong>
                                                            </p>
                                                            <img class="img-responsive"
                                                                 src="<?php echo $picture_website . $door_color[$j]['dsp_pic']; ?>"
                                                                 class="img-fluid d-block mr-auto ml-auto" alt="">
                                                            <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>

                                                            <div class="clear"></div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            $door_shape_sides = $domenia2->get_all_door_shapes_sides();

                                            for ($i = 0; $i < count($door_shape_sides); $i++) {
                                                $door_panel_color = $domenia2->get_door_shape_colors($door_shape_sides[$i]['dss_id']);

                                                for ($j = 0; $j < count($door_panel_color); $j++) {
                                                    if ($door_panel_color[$j]['dsp_id'] == $o_desc_allproducts['dsp_id']) {
                                                        ?>
                                                        <div class="mywidth product row18" data-position="14"><p
                                                                    class="text-center text-success mb-0">
                                                                <strong>Side panels</strong>
                                                            </p>
                                                            <img class="img-responsive"
                                                                 src="<?php echo $picture_website . $door_panel_color[$j]['dsp_pic']; ?>"
                                                                 class="img-fluid d-block mr-auto ml-auto" alt="">
                                                            <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>

                                                            <div class="clear"></div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            if($o_desc_allproducts['photovoltaic']==1)
                                            {
                                                ?>
                                                <div class="mywidth product row19" data-position="15"><p
                                                            class="text-center text-success mb-0">
                                                        <strong class="">
                                                            Photovoltaic
                                                        </strong>
                                                    </p>
                                                    <img class="img-responsive"
                                                            src="<?php echo $picture_website; ?>images/photovoltaic/photovoltaik.png"
                                                            class="img-fluid d-block mr-auto ml-auto" alt="">
                                                    <span class="icon-cheked">
                                                            <i class="fas fa-check-circle text-success"></i>
                                                        </span>

                                                    <div class="clear"></div>
                                                </div>
                                                <?php
                                            }
                                            $plot_border = $domenia2->get_all_plot_border();

                                            for ($i = 0; $i < count($plot_border); $i++) {
                                                $plot_picture = $domenia2->get_plot_picture($plot_border[$i]['pb_id']);

                                                for ($j = 0; $j < count($plot_picture); $j++) {
                                                    if ($plot_picture[$j]['pbp_id'] == $o_desc_allproducts['pbp_id']) {
                                                        ?>
                                                        <div class="mywidth product row19" data-position="15"><p
                                                                    class="text-center text-success mb-0">
                                                                <strong class="">
                                                                    Building Site
                                                                </strong>
                                                            </p>
                                                            <img class="img-responsive"
                                                                 src="<?php echo $picture_website . $plot_picture[$j]['pbp_pic']; ?>"
                                                                 class="img-fluid d-block mr-auto ml-auto" alt="">
                                                            <span class="icon-cheked">
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                </span>

                                                            <div class="clear"></div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }


                                            $garage = $domenia2->get_all_garage();

                                            for ($i = 0; $i < count($garage); $i++) {
                                                if ($garage[$i]['cp_id'] == $o_desc_allproducts['gc_id']) {
                                                    ?>

                                                    <div class="mywidth product row13" data-position="16"><p
                                                                class="text-center text-success mb-0">
                                                            <strong class="">
                                                                Parking area
                                                            </strong>
                                                        </p>
                                                        <img class="img-responsive"
                                                             src="<?php echo $picture_website . $garage[$i]['cp_pic']; ?>"
                                                             class="img-fluid d-block mr-auto ml-auto" alt="">
                                                        <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                        <div class="text-center pb-4">
                                                            <span><?php echo $garage[$i]['cp_name_db']; ?></span>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                            <div class="mywidth product row14 input" data-position="17"><p
                                                        class="text-center text-success mb-0">
                                                    <strong> Dimensions car range</strong>
                                                </p>

                                                <p class="text-center text-secondary mt-1 mb-0"> Width (m)</p>
                                                <p class="text-center text-dark mb-0">
                                                    <strong><?php echo $o_desc_allproducts['gc_width']; ?></strong></p>
                                                <p class="text-center text-secondary mt-1 mb-0"> Depth (m)</p>
                                                <p class="text-center text-dark mb-0">
                                                    <strong><?php echo $o_desc_allproducts['gc_length']; ?></strong></p>
                                            </div>


                                            <div class="mywidth product row13" data-position="16">
                                                <p class="text-center text-success mb-0">
                                                    <strong>
                                                        Environment address
                                                    </strong>
                                                </p>
                                                <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                                <div class="text-center pb-4 ellipsis">
                                <span title="<?php
                                echo (!empty($order['environment_address'])) ? nl2br($order['environment_address']) : "NONE"; ?>"><?php
                                    echo (!empty($order['environment_address'])) ? nl2br($order['environment_address']) : "NONE"; ?></span>
                                                </div>
                                                <div class="clear"></div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }


                                if ((substr($prod_id, 1) > 1500) && (substr($prod_id, 1) < 1560)) {
                                    $o_desc_in_b5 = $prod->get_o_desc_in_b5($o_id);
                                    //$order=$prod->get_order($o_id);
                                    //$client=$prod->get_client($order['u_client_ID']);

                                    $layout_id = $o_desc_in_b5['layout_id'];
                                    $window_id = $o_desc_in_b5['window_id'];
                                    $layout = $prod->get_layout($layout_id, "b5", $window_id);
                                    $layoutline_name = $layout['layoutline_name'];
                                    $floor_color = $layout['set_colors'];
                                    ?>
                                    <!-- <div class="colorbox" style="background-color:<?php $window = $prod->get_window($window_id);
                                    echo $window['window_color']; ?>;border: 10px solid <?php echo $floor_color; ?>">				 -->
                                    <!-- </div> -->
                                    <?php
                                    // echo "<p class='mb-0 pt-2'>".$layoutline_name."</p>";
                                }

                                if ((substr($prod_id, 1) > 1300) && (substr($prod_id, 1) < 1360)) {
                                    $o_desc_in_b3 = $prod->get_o_desc_in_b3($o_id);
                                    ?>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-3">
                                            <b>Shapeline</b>
                                        </div>
                                        <div class="col-md-3">

                                            <select name="sl_id" id="sl_id" class="form-control form-control-sm">
                                                <option value="">None</option>
                                                <?php
                                                $all_b3_shapes = $domenia3n->get_all_b3_shapes();

                                                for ($i = 0; $i < count($all_b3_shapes); $i++) {
                                                    ?>
                                                    <option value="<?php echo $all_b3_shapes[$i]['sl_id']; ?>" <?php echo ($all_b3_shapes[$i]['sl_id'] == $o_desc_in_b3['sl_id']) ? "selected" : ""; ?>><?php echo $all_b3_shapes[$i]['sl_id'] . " - " . $all_b3_shapes[$i]['sl_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!--</div>
                            <div class="row w-100 mx-0 mb-2"> -->
                                        <div class="col-md-3">
                                            <b>Colorset</b>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="cls_id" id="cls_id" class="form-control form-control-sm">
                                                <option value="">None</option>
                                                <?php

                                                $all_b3_colorset = $domenia3n->get_all_b3_colorsets();

                                                for ($i = 0; $i < count($all_b3_colorset); $i++) {
                                                    ?>
                                                    <option value="<?php echo $all_b3_colorset[$i]['cls_id']; ?>" <?php echo ($all_b3_colorset[$i]['cls_id'] == $o_desc_in_b3['cls_id']) ? "selected" : ""; ?>><?php echo $all_b3_colorset[$i]['cls_id'] . " - " . $all_b3_colorset[$i]['cls_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                        <!--
                            <hr>
                            <br> -->

                        <div class="row w-100 mx-0">
                            <div class="col-md-6 border border-left-0 border-dark pb-4 pt-2">
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 text-center"><b>Customer remarks interior</b></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 <?php echo (!empty($order['clients-extras'])) ? "text-left" : "text-center"; ?> pl-5 border-bottom border-dark text-primary"><?php echo (!empty($order['clients-extras'])) ? nl2br($order['clients-extras']) : "<p class='text-dark mb-0'>NONE</p>"; ?></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 text-center"><b>Customer remarks exterior</b></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 <?php echo (!empty($order['client_extras_ex_b5'])) ? "text-left" : "text-center"; ?> pl-5 border-bottom border-dark text-primary"><?php echo (!empty($order['client_extras_ex_b5'])) ? nl2br($order['client_extras_ex_b5']) : "<p class='text-dark mb-0'>NONE</p>"; ?></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 text-center"><b>Operator remarks interior</b></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 <?php echo (!empty($order['op-remarks'])) ? "text-left" : "text-center"; ?> pl-5 border-bottom border-dark text-primary"><?php echo (!empty($order['op-remarks'])) ? nl2br($order['op-remarks']) : "<p class='mb-0 text-dark'>NONE</p>"; ?></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 text-center"><b>Operator remarks exterior</b></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 <?php echo (!empty($order['op_remarks_ex_b5'])) ? "text-left" : "text-center"; ?> pl-5 border-bottom border-dark text-primary"><?php echo (!empty($order['op_remarks_ex_b5'])) ? nl2br($order['op_remarks_ex_b5']) : "<p class='mb-0 text-dark'>NONE</p>"; ?></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 text-center"><b>Environment_address</b></div>
                                </div>                                
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 <?php echo (!empty($order['environment_address'])) ? "text-left" : "text-center"; ?> pl-5 border-bottom border-dark text-primary"><?php echo (!empty($order['environment_address'])) ? nl2br($order['environment_address']) : "<p class='mb-0 text-dark'>NONE</p>"; ?></div>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12 text-success text-center pl-5 border-bottom border-dark" style="font-size:22px;">
                                        <b>Commision: <?php 
                                        if(!empty($order['commission']))
                                        {
                                            $commission=$prod->get_commission($order['commission']);
                                            echo $commission['4creators'];
                                        }
                                        else
                                        {
                                            echo "None";
                                        }
                                        ?></b>
                                    </div>
                                </div>
                                <div class="row w-100 mx-0 border-bottom border-dark">
                                    <?php
                                    if(($order['latitude']!=0)&&($order['longitude']!=0))
                                    {
                                    ?>
                                    <div class="col-md-4">
                                        <a href="https://app.shadowmap.org/?lat=<?php echo $order['latitude']; ?>&lng=<?php echo $order['longitude']; ?>=&zoom=15&basemap=map&time=1662559750832&vq=2" target="_blank">Suntour Link</a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="https://www.google.ro/maps/place/Germany/@<?php echo $order['latitude']; ?>,<?php echo $order['longitude']; ?>,17z" target="_blank">Google Maps Link</a>
                                    </div>
                                    <?php
                                    }

                                    if(!empty($order['geoportal_link']))
                                    {
                                    ?>
                                    <div class="col-md-4">
                                        <a href="<?php echo $order['geoportal_link']?>" target="_blank">Geoportal Link</a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="row w-100 mx-0">
                                    <div class="col-md-12">
                                        <b>Tutorials</b>
                                    </div>
                                </div>
                                <?php

                                $product_cdws_ids = explode(',', $product['cdws_ids']);

                                $tutorial_ids = array();

                                for ($i = 0; $i < count($product_cdws_ids); $i++) {
                                    $tutorial_cdws_id = $prod->get_product_tutorials($product_cdws_ids[$i]);

                                    for ($j = 0; $j < count($tutorial_cdws_id); $j++) {
                                        $tutorial_ids[] = $tutorial_cdws_id[$j]['t_id'];
                                    }
                                }

                                $tutorial_ids = array_unique($tutorial_ids);
                                $tutorial_counter = 0;

                                foreach ($tutorial_ids as $t) {
                                    $tutorial = $prod->get_tutorial_by_id($t);
                                    $main_client_ids = explode(";", $tutorial['main_client_ID']);

                                    //tutorials for specific language

                                    if ($tutorial['language_of_order'] == $order['client_language_id']) {
                                        if (strpos($tutorial['main_client_ID'], '0;') !== false) //contains 0
                                        {
                                            /* for($j=0;$j<count($main_client_ids);$j++)
                                            {
                                            if(($main_client_ids[$j]==$client['mc_id'])||($main_client_ids[$j]!=$client['mc_id']))
                                            {
                                                if($tutorial_counter==0)
                                                {
                                            ?>
                                            <div class="row w-100 mx-0">
                                                <div class="col-md-6 offset-3 border border-dark">
                                                    <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank"><?php echo $tutorial['t_title'];?></a>
                                                </div>
                                            </div>
                                            <?php
                                                $tutorial_counter++;
                                                }
                                            }
                                            }
                                            $tutorial_counter=0; */
                                        } elseif (strpos($tutorial['main_client_ID'], '0;') === false) {
                                            for ($j = 0; $j < count($main_client_ids); $j++) {
                                                if (($main_client_ids[$j] == $client['mc_id']) && (!empty($main_client_ids[$j]))) {
                                                    ?>
                                                    <div class="row w-100 mx-0">
                                                        <div class="col-md-6 offset-3 border border-dark">
                                                            <div style="background-color:red">
                                                                <a title="<?php echo $tutorial['t_description']; ?>"
                                                                   href="<?php echo $tutorial['t_link']; ?>"
                                                                   target="_blank"
                                                                   style="color:white;"><?php echo $tutorial['t_title']; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }

                                        if ((strpos($tutorial['client_ID'], $client['client_ID'] . ';') !== false) || ($tutorial['client_ID'] == "all;")) //contains 0;
                                        {

                                            ?>
                                            <div class="row w-100 mx-0">
                                                <div class="col-md-6 offset-3 border border-dark">
                                                    <div style="<?php echo ($tutorial['client_ID'] != "all;") ? "background-color:red" : ""; ?>">
                                                        <a title="<?php echo $tutorial['t_description']; ?>"
                                                           href="<?php echo $tutorial['t_link']; ?>" target="_blank"
                                                           style="<?php echo ($tutorial['client_ID'] != "all;") ? "color:white;" : ""; ?>"><?php echo $tutorial['t_title']; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                        }
                                    }

                                    //tutorials for all languages

                                    if ($tutorial['language_of_order'] == 0) {
                                        if (strpos($tutorial['main_client_ID'], '0;') !== false) {
                                            /*for($j=0;$j<count($main_client_ids);$j++)
                                            {
                                            if(($main_client_ids[$j]==$client['mc_id'])||($main_client_ids[$j]!=$client['mc_id']))
                                            {
                                                if($tutorial_counter==0)
                                                {
                                            ?>
                                            <div class="row w-100 mx-0">
                                                <div class="col-md-6 offset-3 border border-dark">
                                                    <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank"><?php echo $tutorial['t_title'];?></a>
                                                </div>
                                            </div>
                                            <?php
                                                $tutorial_counter++;
                                                }
                                            }
                                            }
                                            $tutorial_counter=0; */
                                        } elseif (strpos($tutorial['main_client_ID'], '0;') === false) {
                                            for ($j = 0; $j < count($main_client_ids); $j++) {
                                                if (($main_client_ids[$j] == $client['mc_id']) && (!empty($main_client_ids[$j]))) {
                                                    ?>
                                                    <div class="row w-100 mx-0">
                                                        <div class="col-md-6 offset-3 border border-dark">
                                                            <div style="background-color:red">
                                                                <a title="<?php echo $tutorial['t_description']; ?>"
                                                                   href="<?php echo $tutorial['t_link']; ?>"
                                                                   target="_blank"
                                                                   style="color:white;"><?php echo $tutorial['t_title']; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }

                                        if ((strpos($tutorial['client_ID'], $client['client_ID'] . ';') !== false) || ($tutorial['client_ID'] == "all;")) //contains 0;
                                        {

                                            ?>
                                            <div class="row w-100 mx-0">
                                                <div class="col-md-6 offset-3 border border-dark">
                                                    <div style="<?php echo ($tutorial['client_ID'] != "all;") ? "background-color:red" : ""; ?>">
                                                        <a title="<?php echo $tutorial['t_description']; ?>"
                                                           href="<?php echo $tutorial['t_link']; ?>" target="_blank"
                                                           style="<?php echo ($tutorial['client_ID'] != "all;") ? "color:white;" : ""; ?>"><?php echo $tutorial['t_title']; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                        }
                                    }

                                }
                                ?>
                                
                                <br>
                                <?php
                                $customer_files = $prod->get_customer_files($o_id);
                                ?>
                                <div class="row w-100 mx-0">
                                    <div class="row w-100 mx-0 border-bottom border-dark">
                                        <p class="w-100 mb-0 text-center"><b>This is the relevant part of the client´s files:</b></p>
                                    </div>
                                </div> <?php 
                            include('coordination/relevant_customer_files.php');
                                //showing shapeline and colorset for b3

                                $o_desc_in_b3 = $prod->get_o_desc_in_b3($o_id);

                                if (!empty($o_desc_in_b3)) {
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Shapeline:</b> <?php echo $o_desc_in_b3['sl_id']; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <b>Colorset:</b> <?php echo $o_desc_in_b3['cls_id']; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-6 dark-gray pt-4">
                                <div class="row w-100 mx-0 border border-dark bg-white">
                                    <div class="col-md-6">
                                        <p class="w-100 text-center"><b>Customer files:</b></p>
                                    </div>
                                    <div class="col-md-6">
                                    <a href="image.php?filecategory=customerfiles&download-all=<?php echo $o_id;?>" class="btn btn-sm btn-primary">Download all</a>
                                    </div>
                                </div>
                                <?php 
                                include('coordination/customer_files.php');

                                if($order['house_id']!=0)
                                {
                                $house_type=$prod->get_house_type($order['house_id']);
                                ?>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <a href="https://bauvorschau.com/<?php echo $house_type['presentation_id'];?>" class="btn btn-sm yellow" target="_blank">Example Presentation for this houseset = <?php echo $house_type['house_id']." - ".$house_type['house_name'];?></a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <a href="materials.php?o_id=<?php echo $house_type['material_id'];?>" class="btn btn-sm dark-green" target="_blank">Materials for this houseset = <?php echo $house_type['house_id']." - ".$house_type['house_name'];?></a>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                           
                        </div>

                        <div class="row w-100 mx-0 pt-2 bg-light">
                            <?php
                            if ($order['mc_id'] != 0) 
                            {
                                
                                ?>
                                <div class="col-md-6 d-flex">
                                    <img src="https://domenia.blue7.it/<?php
                                if(!empty($main_client['mc_logo'])){
                                    echo $main_client['mc_logo'];
                                }?>" alt="main_client_logo" style="width:100%;height:auto;">
                                    <p class="w-100 text-center"><b>Special for this main-client
                                            (<?php echo strtoupper($main_client['clientname']); ?>):</b></p>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-6">
                                <p class="w-100 text-center">
                                    <b>Special for this sub-client (<?php
                                        if (!empty($order_client['clientname'])) {
                                            echo strtoupper($order_client['clientname'] . " - " . $order_client['c_last_name'] . ", " . $order_client['c_first_name']);
                                        } else {
                                            echo strtoupper($order_client['l_first_name'] . " " . $order_client['l_last_name']);
                                        } ?>):</b>
                                </p>
                            </div>
                        </div>
                        <div class="row w-100 mx-0 bg-light border-bottom border-dark pb-2">
                            <?php
                            if ($order['mc_id'] != 0) {
                                $main_client_color=$prod->get_main_client_colors($order['mc_id']);
                                
                                ?>
                                <div class="col-md-6 text-center" style="color:<?php echo $main_client_color['color_3'];?>;">
                                    <?php echo nl2br($main_client['remarks_internal']); ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-6 text-center" style="color:red;">
                                <?php echo nl2br($order_client['remarks_internal']); ?>
                            </div>

                        </div>
                        <?php
                        if ((substr($prod_id, 1) > 1500) && (substr($prod_id, 1) < 1560)) {
                            ?>
                            <div class="row w-100 mx-0 pt-2 d-flex justify-content-center">

                                <div class="col-md-3 d-flex justify-content-end">
                                    <p class="mb-0 pt-2">
                                        <b>Layout: </b>
                                    </p>
                                </div>
                                <div class="col-md-2 d-flex justify-content-start">
                                    <?php
                                    $o_desc_in_b5 = $prod->get_o_desc_in_b5($o_id);

                                    $layout_id = $o_desc_in_b5['layout_id'];
                                    $window_id = $o_desc_in_b5['window_id'];
                                    $layout = $prod->get_layout($layout_id, "b5", $window_id);
                                    $layoutline_name = $layout['layoutline_name'];
                                    $floor_color = $layout['set_colors'];
                                    ?>
                                    <div class="colorbox"
                                         style="background-color:<?php $window = $prod->get_window($window_id);
                                         echo $window['window_color']; ?>;border: 10px solid <?php echo $floor_color; ?>"></div>
                                    <?php
                                    echo "<p class='mb-0 pt-2'>" . $layoutline_name . "</p>";
                                    ?>
                                </div>

                            </div>
                            <?php
                        }
                        ?>

                        <div id="result_files"></div>
                        <?php

                        include('result_files.php');
                        
                        ?>
                        <div class="row w-100 mx-0 dark-gray">
                            <div class="col-md-12">
                                <form name="send_message" method="post"
                                      action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                                    <input type="hidden" name="o_id" value="<?php echo $o_id; ?>">
                                    <input type="hidden" name="osub_id" value="<?php echo $osub_id; ?>">
                                    <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $_COOKIE['client_id']; ?>">

                                    <!-- <p class="mb-0 pt-4">Send message to coordinator:</p> -->
                                    <?php
                                    $messages = $prod->show_all_messages($o_id, $osub_id, $prod_id);

                                    ?>
                                    <div class="container all_messages">
                                        <?php
                                        for ($i = 0; $i < count($messages); $i++) {

                                            ?>
                                            <div class="row colorline">
                                                <div class="col-xs-12"
                                                     id="message_row_<?php echo $messages[$i]['msg_id']; ?>">
                                                    <?php
                                                    $user_name = $prod->get_client($messages[$i]['user_id']);
                                                    ?>
                                                    <b><span style="color:red;"><?php
                                                        if (!empty($user_name['c_last_name'])) {
                                                            echo $user_name['c_first_name'] . " " . $user_name['c_last_name'];
                                                        } else {
                                                            echo $user_name['l_first_name'] . " " . $user_name['l_last_name'];
                                                        } ?></span></b> (<?php echo $messages[$i]['date']; ?> UTC+0): <span
                                                            id="message_id_<?php echo $messages[$i]['msg_id']; ?>"><?php echo $messages[$i]['message']; ?></span>
                                                </div>
                                                <?php if ($messages[$i]['user_id'] == $_COOKIE['client_id']): ?>
                                                    <div class="col-xs-1">
                                                        <button type="button"
                                                                class="btn btn-sm btn-primary pr-0 pl-0 pt-0 pb-0 ml-3"
                                                                id="msg_btn_<?php echo $messages[$i]['msg_id']; ?>">Edit
                                                        </button>
                                                    </div>
                                                    <div id="new_row_message_<?php echo $messages[$i]['msg_id']; ?>"
                                                         class="row d-none w-100 mx-0 p-2 text-center">
                                                        <div class="col-xs-11 col-md-11">
                                                            <input type="text"
                                                                   id="new_message_<?php echo $messages[$i]['msg_id']; ?>"
                                                                   name="new_message_<?php echo $messages[$i]['msg_id']; ?>"
                                                                   class="form-control form-control-sm" text="">
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-primary pr-0 pl-0 pt-0 pb-0"
                                                                    id="new_msg_btn_<?php echo $messages[$i]['msg_id']; ?>"
                                                                    data-msg_id="<?php echo $messages[$i]['msg_id']; ?>">
                                                                Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        $("#msg_btn_<?php echo $messages[$i]['msg_id'];?>").click(function () {
                                                            $("#message_row_<?php echo $messages[$i]['msg_id'];?>").removeClass().addClass("row w-100 mx-0 py-2 colorline2 d-none");
                                                            $("#msg_btn_<?php echo $messages[$i]['msg_id'];?>").removeClass().addClass("d-none");
                                                            $("#new_row_message_<?php echo $messages[$i]['msg_id'];?>").removeClass().addClass("row w-100 mx-0 py-2 colorline2");
                                                            $("#new_message_<?php echo $messages[$i]['msg_id'];?>").val($("#message_id_<?php echo $messages[$i]['msg_id'];?>").text());

                                                            $("#new_msg_btn_<?php echo $messages[$i]['msg_id'];?>").click(function () {
                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/update_creator_message.php",
                                                                    method: "post",
                                                                    data: {
                                                                        msg_id: $(this).data("msg_id"),
                                                                        message: $("#new_message_<?php echo $messages[$i]['msg_id'];?>").val(),
                                                                        user_id: $('input[name=user_id]').val()
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {
                                                                        console.log(data);
                                                                        location.reload(true);
                                                                    },
                                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                                        console.log(xhr.status);
                                                                        console.log(thrownError);
                                                                    }
                                                                });

                                                            });
                                                        });
                                                    </script>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <br>
                                    <textarea class="form-control d-inline form-control-sm w-75" name="message" rows="2"
                                              cols="50" placeholder="Type a message to coordinator..." required></textarea>
                                    <div class="center_message d-inline">
                                        <button name="send_message_btn" class="btn btn-sm btn-primary d-inline mb-5">
                                            Send
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12 text-center dark-gray pb-4">
                            <div class="row w-100 mx-0 text-left">
                                <div class="col-6 pl-3"><b>Uploaded correction hints:</b></div>
                            </div>
                            <div class="row w-100 mx-0 text-left">
                                <div class="col-md-6 pl-3">
                                    <b>File name:</b>
                                </div>
                                <div class="col-md-3 pl-3">
                                </div>
                            </div>
                            <?php
                            $correction_needed_files = $prod->get_correction_needed_files($o_id, $osub_id, $prod_id);

                            for ($j = 0; $j < count($correction_needed_files); $j++) {
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                        echo $correction_needed_files[$j]['cnf_name'];
                                        ?>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="../image.php?filecategory=correction_needed_files&cnf_id=<?php echo $correction_needed_files[$j]['cnf_id']; ?>"
                                           class="btn btn-primary btn-sm">Download</a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                    </div>

                    <div class="col-lg-2 col-sm-12 col-12">
                        <p class="w-100 text-center"><b>Finished interior files:</b></p>
                        <button class="btn btn-sm btn-dark btn-block mb-2" data-toggle="collapse"
                                data-target="#finishedInterior" aria-expanded="true">Finished interior files!
                            <strong><span>Hide</span></strong></button>
                        <?php
                        //b3 interior
                        $b3_in_results = $prod->get_b3_in_ordered_results($o_id);

                        for ($j = 0; $j < count($b3_in_results); $j++) {
                            if ($b3_in_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row colorline w-100 mx-0 <?php
                                if ($b3_in_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedInterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center mb-0">
                                                <?php
                                                //$product_name=$prod->get_product($b3_in_results[$j]['prod_id']);
                                                //echo $b3_in_results[$j]['o_id'].".".$b3_in_results[$j]['osub_id'].".".$b3_in_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b3_in_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b3_in_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b3_in_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b3_in_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <?php
                                            if (in_array($b3_in_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b3_in_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b3_in_results[$j]['orf_path_dom'] . $b3_in_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b3_in_results[$j]['orf_name']; ?>">
                                                             
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b3_in_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b3_in_results[$j]['orf_name']; ?>">
                                                             
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b3_in_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b3_in_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <?php
                                        if (in_array($b3_in_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b3_in_results[$j]['orf_path_dom'] . $b3_in_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b3_in_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }
                        ?>

                        <?php
                        //b5 interior
                        $b5_in_results = $prod->get_b5_in_ordered_results($o_id);

                        for ($j = 0; $j < count($b5_in_results); $j++) {
                            if ($b5_in_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row colorline w-100 mx-0 <?php
                                if ($b5_in_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedInterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center mb-0">
                                                <?php
                                                //$product_name=$prod->get_product($b5_in_results[$j]['prod_id']);
                                                //echo $b5_in_results[$j]['o_id'].".".$b5_in_results[$j]['osub_id'].".".$b5_in_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b5_in_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b5_in_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b5_in_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b5_in_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array($b5_in_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>

                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b5_in_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b5_in_results[$j]['orf_path_dom'] . $b5_in_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b5_in_results[$j]['orf_name']; ?>">
                                                            
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b5_in_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b5_in_results[$j]['orf_name']; ?>">
                                                            
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b5_in_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b5_in_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <?php
                                        if (in_array($b5_in_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b5_in_results[$j]['orf_path_dom'] . $b5_in_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b5_in_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }


                        //b6 interior
                        $b6_in_results = $prod->get_b6_in_results_with_extensions($o_id);

                        for ($j = 0; $j < count($b6_in_results); $j++) {
                            if ($b6_in_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row colorline w-100 mx-0 <?php
                                if ($b6_in_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedInterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center mb-0">
                                                <?php
                                                //$product_name=$prod->get_product($b5_in_results[$j]['prod_id']);
                                                //echo $b5_in_results[$j]['o_id'].".".$b5_in_results[$j]['osub_id'].".".$b5_in_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b6_in_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b6_in_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b6_in_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b6_in_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array($b6_in_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>

                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b6_in_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b6_in_results[$j]['orf_path_dom'] . $b6_in_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b6_in_results[$j]['orf_name']; ?>">
                                                              
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b6_in_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b6_in_results[$j]['orf_name']; ?>">
                                                              
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b6_in_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b6_in_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <?php
                                        if (in_array($b6_in_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b6_in_results[$j]['orf_path_dom'] . $b6_in_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b6_in_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }

                        //b7 interior
                        $b7_in_results = $prod->get_b7_in_results_with_extensions($o_id);

                        for ($j = 0; $j < count($b7_in_results); $j++) {
                            if ($b7_in_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row colorline w-100 mx-0 <?php
                                if ($b7_in_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedInterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center mb-0">
                                                <?php
                                                //$product_name=$prod->get_product($b5_in_results[$j]['prod_id']);
                                                //echo $b5_in_results[$j]['o_id'].".".$b5_in_results[$j]['osub_id'].".".$b5_in_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b7_in_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b7_in_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b7_in_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b7_in_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array($b7_in_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>

                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b7_in_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b7_in_results[$j]['orf_path_dom'] . $b7_in_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b7_in_results[$j]['orf_name']; ?>">
                                                             
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b7_in_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b7_in_results[$j]['orf_name']; ?>">
                                                             
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b7_in_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b7_in_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <?php
                                        if (in_array($b7_in_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b7_in_results[$j]['orf_path_dom'] . $b7_in_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b7_in_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }


                        //b8 interior
                        $b8_in_results = $prod->get_b8_in_results_with_extensions($o_id);

                        for ($j = 0; $j < count($b8_in_results); $j++) {
                            if ($b8_in_results[$j]['orf_status'] != 7) {
                                ?>
                                <div class="row colorline w-100 mx-0 <?php
                                if ($b8_in_results[$j]['orf_status'] == 8) {
                                    echo "border border-success";
                                }
                                ?> collapse show" id="finishedInterior">
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-12">
                                            <p class="w-100 text-center mb-0">
                                                <?php
                                                //$product_name=$prod->get_product($b5_in_results[$j]['prod_id']);
                                                //echo $b5_in_results[$j]['o_id'].".".$b5_in_results[$j]['osub_id'].".".$b5_in_results[$j]['prod_id']." ".$product_name['prod_name'];
                                                echo $b8_in_results[$j]['orf_name'];
                                                ?><br>
                                                <?php
                                                $creator = $prod->get_client($b8_in_results[$j]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>
                                                <br>
                                                <?php echo $b8_in_results[$j]['orf_upload_date']; ?>
                                                <br>
                                                <?php
                                                if ($b8_in_results[$j]['orf_status'] == 8) {
                                                    ?>
                                                    <span class="text-success">Visible to client</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="text-danger">Not visible to client</span>
                                                    <?php
                                                }
                                                ?>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0">
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array($b8_in_results[$j]['orf_type_dom'], $validextensions)) {
                                                ?>

                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>">
                                                    <?php
                                                    if (empty($b8_in_results[$j]['orf_thumbnail_path'])) {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_files/<?php echo $b8_in_results[$j]['orf_path_dom'] . $b8_in_results[$j]['orf_internal_name_dom']; ?>"
                                                             alt="<?php echo $b8_in_results[$j]['orf_name']; ?>">
                                                             
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="result_thumbnail_files/<?php echo $b8_in_results[$j]['orf_thumbnail_path']; ?>"
                                                             alt="<?php echo $b8_in_results[$j]['orf_name']; ?>">
                                                             
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center my-2">
                                            <a class="btn btn-primary btn-sm align-self-center"
                                               href="image.php?filecategory=creatorfiles&orfid=<?php echo $b8_in_results[$j]['orf_id']; ?>"
                                               alt="<?php echo $b8_in_results[$j]['orf_name']; ?>" target="_blank">Download</a>
                                        </div>
                                        <?php
                                        if (in_array($b8_in_results[$j]['orf_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                <img class="img-responsive" style="width:60px"
                                                     src="result_files/<?php echo $b8_in_results[$j]['orf_path_dom'] . $b8_in_results[$j]['orf_internal_name_dom']; ?>"
                                                     alt="<?php echo $b8_in_results[$j]['orf_name']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div> <!-- end row -->
                                </div>
                                <?php
                                $image_preview_counter++;
                            }
                        }

                        ?>
                    </div>


                </div>

                <!--end task details container -->

                <!-- <script type='text/javascript' src='../acceptance/js/acceptance.js'></script> -->
                <?php
                //include('online_creators.php');
            } else {
                session_unset();
                session_destroy();
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
                <div class="text-center">
                    <div class="alert alert-danger">You must be logged in to view this page !</div>
                    <a href="<?php echo $base_url; ?>index.php" class="btn btn-danger btn-sm">Login</a>
                    <br><br>
                </div>
                <meta http-equiv="refresh" content="3; url=<?php echo $base_url; ?>index.php">
                <?php
            }
            ?>
        </article>
    </section>
<?php
include('footer.php');
?>