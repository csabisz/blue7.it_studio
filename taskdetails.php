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
//$base_url="https://new.blue7.it/studio/";

include('header2.php');
include('menu.php');

$o_id = $prod->xss_fix($_GET['o_id']);
$order = $prod->get_order($o_id);
?>
    <section class="top_section">
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
                if(isset($_GET['option']))
                {
                    $option = $prod->xss_fix($_GET['option']);
                }
                else
                {
                    $option = null;
                }

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

                /*if(isset($_POST['delete_btn']))
			{
				$orf_id=$prod->xss_fix($_POST['orf_id']);

				$prod->delete_creator_file($orf_id);
				?>
				<div class="center_message"> <div class="success">Image deleted !</div></div><br />
				<?php
			}	*/

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

                        <?php


                        /*$all_results=$prod->show_results_by_order($o_id);


                            for($j=0;$j<count($all_results);$j++)
                            {
                                ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php
                                        $product2=$prod->get_product($all_results[$j]['prod_id']);
                                        echo $all_results[$j]['o_id'].".".$all_results[$j]['osub_id'].".".$all_results[$j]['prod_id']." ".$product2['prod_name'];
                                        ?>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="image_tooltip_container_<?php
                                        if(in_array($all_results[$j]['orf_type_dom'],$validextensions))
                                        {
                                            echo $image_preview_counter;
                                        }
                                        ?>">
                                        <?php echo $all_results[$j]['orf_name'];?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-primary btn-sm" href="image.php?filecategory=creatorfiles&orfid=<?php echo $all_results[$j]['orf_id'];?>" alt="<?php echo $all_results[$j]['orf_name'];?>" target="_blank">View result file</a>
                                    </div>
                                    <?php
                                    if(in_array($all_results[$j]['orf_type_dom'],$validextensions))
                                    {
                                    ?>
                                        <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                            <img class="img-responsive" style="width:900px" src="result_files/<?php echo $all_results[$j]['orf_path_dom'].$all_results[$j]['orf_internal_name_dom']; ?>" alt="<?php echo $all_results[$j]['orf_name'];?>">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                $image_preview_counter++;
                            }	*/
                        ?>

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

//                                                            print '<pre style="text-align:left;">';
//                                                            print print_r($o_desc_allproducts['roof_type']);
//                                                            print '</pre>';

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
                                                     alt="<?php echo (!empty($roof_color['rmp_colorname']))?$roof_color['rmp_colorname']:""; ?>">
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
                                <?php /*
                                $customer_files = $prod->get_customer_files($o_id);

                                ?>
                                <div class="row w-100 mx-0 border border-dark bg-white">
                                    <div class="col-md-4 border-right border-dark">
                                        <b>File name</b>
                                    </div>
                                    <div class="col-md-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-3">
                                        <b>Note</b>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="image.php?filecategory=customerfiles&download-all=<?php echo $o_id; ?>"
                                           class="btn btn-sm btn-primary">Download all</a>
                                    </div>
                                </div>
                                <?php
                                $osub_id_number = substr($osub_id, 1);
                                for ($i = 0; $i < count($customer_files); $i++) {
                                    if ($customer_files[$i]['of_position'] == $osub_id_number) {
                                        ?>
                                        <div class="row colorline border border-dark w-100 mx-0">
                                            <div class="col-md-4 ellipsis pt-4">
                                                <span title="<?php echo $customer_files[$i]['of_name_client']; ?>">
                                            <?php echo $customer_files[$i]['of_name_client']; ?>
                                                </span>
                                            </div>
                                            <div class="col-md-2">
                                                <?php
                                                $tempfile = explode(".", $customer_files[$i]['of_name_client']);
                                                $file_extension = strtolower(end($tempfile));

                                                if ($file_extension == "pdf") {
                                                    ?>
                                                    <img class="img-responsive" style="width:40px;cursor:pointer;"
                                                         src="img/adobe-pdf-icon.png" alt="pdf file">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div id="image_tooltip_container_<?php
                                                    if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                                                        echo $image_preview_counter;
                                                    }
                                                    ?>">
                                                        <img class="img-responsive" style="width:80px;cursor:pointer;"
                                                             src="client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
                                                    </div>
                                                    <?php
                                                    if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                                                        ?>
                                                        <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                            <img class="img-responsive" width="60"
                                                                 src="client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-3 pt-4">
                                                <?php
                                                $note = $customer_files[$i]['of_kind'];
                                                if ($note == 1) {
                                                    echo "Order! Floorplan/-s";
                                                }
                                                if ($note == 8) {
                                                    echo "NO ORDER! Only for understanding";
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-3 pt-4">
                                                <a href="image.php?filecategory=customerfiles&imageid=<?php echo $customer_files[$i]['of_id']; ?>"
                                                   class="btn btn-primary btn-sm" target="_blank">Download</a>
                                            </div>
                                        </div>
                                        <?php
                                        $image_preview_counter++;
                                    }
                                }

                                for ($i = 0; $i < count($customer_files); $i++) {
                                    if (($customer_files[$i]['of_kind'] == 8) || ($customer_files[$i]['of_kind'] == 2)) {
                                        ?>
                                        <div class="row colorline border border-dark w-100 mx-0">
                                            <div class="col-md-4 ellipsis pt-4">
                                                <span title="<?php echo $customer_files[$i]['of_name_client']; ?>">
                                            <?php echo $customer_files[$i]['of_name_client']; ?>
                                                </span>
                                            </div>
                                            <div class="col-md-2">
                                                <?php
                                                $tempfile = explode(".", $customer_files[$i]['of_name_client']);
                                                $file_extension = strtolower(end($tempfile));

                                                if ($file_extension == "pdf") {
                                                    ?>
                                                    <img class="img-responsive" style="width:40px;cursor:pointer;"
                                                         src="img/adobe-pdf-icon.png" alt="pdf file">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div id="image_tooltip_container_<?php
                                                    if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                                                        echo $image_preview_counter;
                                                    }
                                                    ?>">
                                                        <img class="img-responsive" style="width:80px;cursor:pointer;"
                                                             src="client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
                                                    </div>
                                                    <?php
                                                    if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                                                        ?>
                                                        <div id="image_tooltip_<?php echo $image_preview_counter; ?>">
                                                            <img class="img-responsive" width="60"
                                                                 src="client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-3 pt-4">
                                                <?php
                                                $note = $customer_files[$i]['of_kind'];
                                                if ($note == 1) {
                                                    echo "Order! Floorplan/-s";
                                                }
                                                if ($note == 8) {
                                                    echo "NO ORDER! Only for understanding";
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-3 pt-4">
                                                <a href="image.php?filecategory=customerfiles&imageid=<?php echo $customer_files[$i]['of_id']; ?>"
                                                   class="btn btn-primary btn-sm" target="_blank">Download</a>
                                            </div>
                                        </div>
                                        <?php
                                        $image_preview_counter++;
                                    }
                                } */
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

                    //new result file upload
                    if(
                    (substr($prod_id, -2)=="6m")||(substr($prod_id, -2)=="gm")
                    )
                    {
                        ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <b>Base picture</b>
                                </div>
                                <div class="col-md-4">
                                    <b>Mask coordinates</b>
                                </div>

                                <div class="col-md-1">
                                </div>
                            </div>
                            <?php
                            $base_picture_results = $prod->show_results($o_id, $osub_id, substr($prod_id, 0,4)."b");

                            for($b=0;$b<count($base_picture_results);$b++)
                            {
                                ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="../result_compress_files/<?php echo $base_picture_results[$b]['orf_compress_path'];?>" target="_blank"><img src="../result_compress_files/<?php echo $base_picture_results[$b]['orf_compress_path'];?>" alt="<?php echo $base_picture_results[$b]['orf_name'];?>" class="img-fluid"></a>
                                        <?php echo $base_picture_results[$b]['pict_categ_name'];?>
                                    </div>
                                    <div class="col-md-10">
                                        <div id="masks<?php echo $base_picture_results[$b]['orf_id'];?>"></div>
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <button id="new_mask_btn<?php echo $base_picture_results[$b]['orf_id'];?>" data-orf_id="<?php echo $base_picture_results[$b]['orf_id'];?>" data-o_id="<?php echo $base_picture_results[$b]['o_id'];?>" class="btn btn-sm btn-primary">New mask 4 this picture</button>
                                                <script type="text/javascript">
                                                    $('#new_mask_btn<?php echo $base_picture_results[$b]['orf_id'];?>').click(function(){
                                                        let orf_id=$(this).data('orf_id');
                                                        let o_id=$(this).data('o_id');

                                                        $.ajax({
                                                        url: "<?php echo $base_url;?>ajax/create_masks_for_orf_id.php",
                                                        method: "post",
                                                        data: {
                                                            orf_id: orf_id
                                                        },
                                                        dataType: "html",
                                                        success: function (data) {

                                                            get_masks_for_orf_id(orf_id,o_id);

                                                        }
                                                        });

                                                    });

                                                    $(document).ready(function(){
                                                        get_masks_for_orf_id(<?php echo $base_picture_results[$b]['orf_id'];?>,<?php echo $base_picture_results[$b]['o_id'];?>);
                                                    });

                                                    function get_masks_for_orf_id(orf_id,o_id)
                                                    {
                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/get_masks_for_orf_id.php",
                                                            method: "GET",
                                                            data: {
                                                                orf_id: orf_id,
                                                                o_id:o_id
                                                            },
                                                            dataType: "html",
                                                            success: function (data) {
                                                            $('#masks'+orf_id).html(data);

                                                            }
                                                        });
                                                    }

                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div style="border-width: 3px;border-style: solid;"></div>
                                <br>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }

                    if(substr($prod_id, -2)=="6t")
                    {
                        ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1">
                                    <b>Target ID</b>
                                </div>
                                <div class="col-md-5">
                                    <b>Link</b>
                                </div>
                                <div class="col-md-5">
                                    <b>Text 4 hover</b>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                            <div id="targets">

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="new_targets_btn" data-o_id="<?php echo $o_id;?>" class="btn btn-sm btn-primary">New target</button>
                                    <script type="text/javascript">
                                        $('#new_targets_btn').click(function(){
                                            let o_id=$(this).data('o_id');

                                            $.ajax({
                                            url: "<?php echo $base_url;?>ajax/create_targets_for_o_id.php",
                                            method: "post",
                                            data: {
                                                o_id: o_id
                                            },
                                            dataType: "html",
                                            success: function (data) {

                                                get_targets_for_o_id(o_id);

                                            }
                                            });

                                        });

                                        $(document).ready(function(){
                                            get_targets_for_o_id(<?php echo $o_id;?>);
                                        });

                                        function get_targets_for_o_id(o_id)
                                        {
                                            $.ajax({
                                                url: "<?php echo $base_url;?>ajax/get_targets_for_o_id.php",
                                                method: "GET",
                                                data: {
                                                    o_id: o_id
                                                },
                                                dataType: "html",
                                                success: function (data) {

                                                    $('#targets').html(data);

                                                }
                                            });
                                        }

                                    </script>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                    if(
                        (substr($prod_id, -2)=="8s")||(substr($prod_id, -2)=="gs")
                        )
                    {
                        ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-5">
                                    <b>Suntour model ID</b>
                                </div>
                                <div class="col-md-5">
                                    <b>Customer view</b>
                                </div>
                            </div>
                            <div id="suntour_models">
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                        <button id="new_suntour_model_btn" data-o_id="<?php
                                        echo $o_id;?>" data-osub_id="<?php
                                        echo $osub_id;?>" data-prod_id="<?php
                                        echo $prod_id;?>" data-uca_id="<?php
                                        echo $_COOKIE['client_id'];?>" class="btn btn-sm btn-primary">New suntour model</button>
                                        <script type="text/javascript">
                                            $('#new_suntour_model_btn').click(function(){
                                                let o_id=$(this).data('o_id');
                                                let osub_id=$(this).data('osub_id');
                                                let prod_id=$(this).data('prod_id');
                                                let uca_id=$(this).data('uca_id');

                                                $.ajax({
                                                url: "<?php echo $base_url;?>ajax/create_suntour_model.php",
                                                method: "post",
                                                data: {
                                                    o_id: o_id,
                                                    osub_id: osub_id,
                                                    prod_id: prod_id,
                                                    uca_id: uca_id
                                                },
                                                dataType: "html",
                                                success: function (data) {

                                                    get_suntour_models(o_id,osub_id,prod_id);

                                                }
                                                });

                                            });

                                            $(document).ready(function(){
                                                get_suntour_models(<?php echo $o_id;?>,"<?php echo $osub_id;?>","<?php echo $prod_id;?>");
                                            });

                                            function get_suntour_models(o_id,osub_id,prod_id)
                                            {
                                                $.ajax({
                                                    url: "<?php echo $base_url;?>ajax/get_suntour_models.php",
                                                    method: "GET",
                                                    data: {
                                                        o_id: o_id,
                                                        osub_id: osub_id,
                                                        prod_id: prod_id
                                                    },
                                                    dataType: "html",
                                                    success: function (data) {

                                                        $('#suntour_models').html(data);

                                                    }
                                                });
                                            }

                                        </script>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }

                    if(substr($prod_id, -1)=="v")
                    {
                        ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-5">
                                    <b>VR link</b>
                                </div>
                                <div class="col-md-5">
                                    <b>Customer view</b>
                                </div>
                            </div>
                            <div id="vr_links">
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                        <button id="new_vr_link_btn" data-o_id="<?php
                                        echo $o_id;?>" data-osub_id="<?php
                                        echo $osub_id;?>" data-prod_id="<?php
                                        echo $prod_id;?>" data-uca_id="<?php
                                        echo $_COOKIE['client_id'];?>" class="btn btn-sm btn-primary">New VR link</button>
                                        <script type="text/javascript">
                                            $('#new_vr_link_btn').click(function(){
                                                let o_id=$(this).data('o_id');
                                                let osub_id=$(this).data('osub_id');
                                                let prod_id=$(this).data('prod_id');
                                                let uca_id=$(this).data('uca_id');

                                                $.ajax({
                                                url: "<?php echo $base_url;?>ajax/create_vr_link.php",
                                                method: "post",
                                                data: {
                                                    o_id: o_id,
                                                    osub_id: osub_id,
                                                    prod_id: prod_id,
                                                    uca_id: uca_id
                                                },
                                                dataType: "html",
                                                success: function (data) {

                                                    get_vr_links(o_id,osub_id,prod_id);

                                                }
                                                });

                                            });

                                            $(document).ready(function(){
                                                get_vr_links(<?php echo $o_id;?>,"<?php echo $osub_id;?>","<?php echo $prod_id;?>");
                                            });

                                            function get_vr_links(o_id,osub_id,prod_id)
                                            {
                                                $.ajax({
                                                    url: "<?php echo $base_url;?>ajax/get_vr_links.php",
                                                    method: "GET",
                                                    data: {
                                                        o_id: o_id,
                                                        osub_id: osub_id,
                                                        prod_id: prod_id
                                                    },
                                                    dataType: "html",
                                                    success: function (data) {

                                                        $('#vr_links').html(data);

                                                    }
                                                });
                                            }

                                        </script>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }

                    if(
                        (substr($prod_id, -2)!="6t")&&(substr($prod_id, -2)!="6m")&&(substr($prod_id, -2)!="8s")&&(substr($prod_id, -1)!="v")&&
                        (substr($prod_id, -2)!="gt")&&(substr($prod_id, -2)!="gm")&&(substr($prod_id, -2)!="gs")
                        )
                    {
                        ?>
                        <div class="col-md-12">
                            <?php
                            
                            if(!empty($orf_id))
                            {
                                $result_files = $prod->show_results_from_base_picture($o_id, $osub_id, $prod_id,$orf_id);
                                //echo "order from base picture";
                            }
                            else
                            {
                                $result_files = $prod->show_results_with_rooms($o_id, $osub_id, $prod_id,$room_id="");
                                //echo "normal y task";
                            }

                            $count_prev_img = 0;
                            for ($i = 0; $i < count($result_files); $i++) {
                                $count_prev_img = 0;

                                if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) {
                                    $count_prev_img++;
                                }
                            }
                            ?>
                            <div class="row mx-0 w-100 border-top border-dark">
                                <div class="col-3 border-right border-left border-dark px-0">Name + Title</div>
                                <div class="col-2 border-right border-dark px-0">Image</div>
                                <?php
                                if((substr($prod_id, -1) === '8'))
                                {
                                    ?>
                                    <div class="col-2 border-right border-dark px-0">External link</div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-2 border-right border-dark px-0">&nbsp;</div>
                                    <?php
                                }
                                ?>                              
                                
                                <div class="col-5 border-right border-dark px-0">Customer View</div>
                            </div>
                        </div> <!--end table header -->
                        <div class="col-md-12">
                            <?php
                            if(
                                ($prod_id!="p168s")||(substr($prod_id, -2)!="gs")
                                )
                            {

                                for ($i = 0; $i < count($result_files); $i++)
                                {

                                    if($result_files[$i]['no_result_file']!=1)
                                    {
                                        ?>
                                        <div class="row w-100 mx-0 border-dark dark-gray" style="border-color:#000;border-style:solid;border-bottom-width: 3px;border-left-width: 1px;border-right-width: 1px;border-top-width: 1px;" id="result_file_row<?php echo $result_files[$i]['orf_id']; ?>">
                                            <div class="col-md-3 border-right border-dark px-0 py-1">
                                                <div class="d-flex">

                                                    <?php if(substr($result_files[$i]['prod_id'], -2) == '2y'):?>

                                                        <?php include '2d_konfigurator_nameing_tool.php'; ?>

                                                    <?php else:?>

                                                    <?php

                                                    $file_name1 = explode("-", $result_files[$i]['orf_name']);
                                                    $file_name2 = explode(".", $result_files[$i]['orf_name']);

                                                    $input_file_name = explode('.', $file_name1[1]);
                                                    unset($input_file_name[count($input_file_name) - 1]);
                                                    $input_file_name = implode('.', $input_file_name);
                                                    $input_file_name = str_replace(' ', '', $input_file_name);

                                                    $first_part_with_space = $file_name1[0];
                                                    $first_part = str_replace(' ', '', $first_part_with_space);

                                                    echo $first_part . " - ";
                                                    ?>
                                                    &nbsp;<input type="text" id="orf_name<?php echo $result_files[$i]['orf_id']; ?>"
                                                                class="form-control form-control-sm"
                                                                data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>"
                                                                value="<?php echo $input_file_name ?>" data-file_name_first_part="<?php
                                                    echo $first_part . " - ";
                                                    ?>" data-file_name_last_part="<?php
                                                    $last_part = end($file_name2);
                                                    echo "." . $last_part;
                                                    ?>" style="width:9em;"><?php
                                                    echo "." . $last_part;
                                                    ?>

                                                    <?php endif;?>

                                                </div>

                                                <?php
                                                $creator = $prod->get_client($result_files[$i]['uca_id']);
                                                if (!empty($creator['c_last_name'])) {
                                                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                                                } else {
                                                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                                                }
                                                ?>

                                                <?php echo $result_files[$i]['orf_upload_date'] . " UTC+0"; ?>
                                                <script type="text/javascript">
                                                    $('#orf_name<?php echo $result_files[$i]['orf_id'];?>').on('blur', function () {
                                                        var orf_id = $(this).data("orf_id");
                                                        var orf_name = $(this).val();
                                                        var file_name_first_part = $(this).data("file_name_first_part");
                                                        var file_name_last_part = $(this).data("file_name_last_part");

                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/update_orf_name.php",
                                                            method: "POST",
                                                            data: {
                                                                orf_id: orf_id,
                                                                orf_name: orf_name,
                                                                file_name_first_part: file_name_first_part,
                                                                file_name_last_part: file_name_last_part
                                                            },
                                                            dataType: "text",
                                                            success: function (data) {
                                                                
                                                            }
                                                        });
                                                    });
                                                </script>
                                                <?php
                                                $pict_categ_name = $prod->get_pict_categ_name($result_files[$i]['orf_name']);
                                                ?>
                                                <form class="" action="<?php echo $base_url . htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
                                                    <?php
                                                    if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                                    {
                                                        ?>
                                                        <div class="row">
                                                            <?php
                                                            $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                                            $pict_categ_name_array=explode(".",$result_files[$i]['pict_categ_name']);                                                       
                                                            $countMainImage = 0;
                                                            $countDoorShapeImage = 0;

                                                            $o_results_configurator_plus=$prod->get_o_results_configurator_plus($result_files[$i]['orf_id']);

                                                            if($result_files[$i]['orf_type_dom']=="jpg")
                                                            {
                                                                ?>
                                                            
                                                                <div class="col-md-auto text-truncate">
                                                                
                                                                    <div id="change_existing_classification<?php echo $result_files[$i]['orf_id']?>" class="existing_classification">    
                                                                        <?php
                                                                        if(!empty($result_files[$i]['config_level']))
                                                                        {
                                                                            $picture_area=$prod->get_picture_area($result_files[$i]['config_level']);
                                                                            echo (!empty($picture_area['pa_description']))?$picture_area['pa_description']:"Classify ?";
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "Classify ?";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <script type="text/javascript">
                                                                        $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                                                            
                                                                            $(this).css('cursor','pointer'); 
                                                                                                                                        
                                                                        });

                                                                    </script>        
                                                                    <input type="hidden" name="pa_id" id="pa_id<?php echo $result_files[$i]['orf_id']?>" value="<?php echo $o_results_configurator_plus['pa_id']; ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <img id="selected_shape_picture<?php echo $result_files[$i]['orf_id'];?>" src="<?php 
                                                                    $door_shapes_pictures=$prod->get_all_door_shapes();

                                                                    for($p=0;$p<count($door_shapes_pictures);$p++)
                                                                    {
                                                                        if($pict_categ_name_array[1]==$door_shapes_pictures[$p]['dsp_id'])
                                                                        {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/".$door_shapes_pictures[$p]['dsp_pic'];
                                                                        }
                                                                    }

                                                                    $roof_shapes_pictures=$prod->get_all_roof_shapes();

                                                                    for($p=0;$p<count($roof_shapes_pictures);$p++)
                                                                    {
                                                                        if($pict_categ_name_array[1]==$roof_shapes_pictures[$p]['rs_id'])
                                                                        {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/".$roof_shapes_pictures[$p]['rs_pic'];
                                                                        }
                                                                    }

                                                                    $gutters_shapes_pictures=$prod->get_all_gutters();

                                                                    for($p=0;$p<count($gutters_shapes_pictures);$p++)
                                                                    {
                                                                        if($pict_categ_name_array[1]==$gutters_shapes_pictures[$p]['gut_id'])
                                                                        {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/".$gutters_shapes_pictures[$p]['gut_pic'];
                                                                        }
                                                                    }
                                                                    ?>" alt="<?php 
                                                                    if(strpos($o_results_configurator_plus['pa_symbol'],"_org")=== false)
                                                                    {
                                                                        echo ucfirst($o_results_configurator_plus['pa_symbol']);
                                                                    }                                                                
                                                                    elseif(strpos($o_results_configurator_plus['pa_symbol'],"_org")!== false)
                                                                    {
                                                                        echo "Original";
                                                                    }
                                                                    else
                                                                    { 
                                                                        echo "What is it ?";
                                                                    }                                                            
                                                                    ?>" class="door_shapes <?php 
                                                                    if($countDoorShapeImage === 0) echo 'broken_door_shape_image' ?>" data-pa_id="<?php echo $o_results_configurator_plus['pa_id']; ?>" style="width:50px;height:50px;" whidth="50" height="50">
                                                                </div>
                                                                <?php
                                                            }

                                                            if($result_files[$i]['orf_type_dom']!="jpg")
                                                            {
                                                                ?>
                                                                <!-- <div class="float-left" style=""> -->
                                                                <div class="col-md-3" style="">
                                                                    <img id="selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>" src="<?php 
                                                                    for($p=0;$p<count($configurator_pictures);$p++)
                                                                    {
                                                                        if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id'])
                                                                        {
                                                                            $countMainImage++;
                                                                            echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];
                                                                        }
                                                                    }
                                                                    ?>" alt="Choose main picture" class="configurator_pictures <?php if($countMainImage === 0) echo 'broken_image_main' ?>" style="width:50px;height:50px;">
                                                                    <script type="text/javascript">
                                                                        <?php
                                                                        if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                                                        {
                                                                            ?>
                                                                            $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                                                                                $('#picture_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                                                                            });    

                                                                            $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                                                                    $(this).css('cursor','pointer');                                                    
                                                                            });
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </script>
                                                                </div>
                                                                <!-- <div class="float-right" style="display: flex;"> -->
                                                                <div class="col-md-auto text-truncate">
                                                            
                                                                    <div id="change_existing_classification<?php echo $result_files[$i]['orf_id']?>" class="existing_classification">    
                                                                        <?php
                                                                        if(!empty($result_files[$i]['config_level']))
                                                                        {
                                                                            $picture_area=$prod->get_picture_area($result_files[$i]['config_level']);
                                                                            echo (!empty($picture_area['pa_description']))?$picture_area['pa_description']:"Classify ?";
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "Classify ?";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <script type="text/javascript">
                                                                        $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                                                            
                                                                            $(this).css('cursor','pointer'); 
                                                                                                                                        
                                                                        });

                                                                    </script>        
                                                                    <input type="hidden" name="pa_id" id="pa_id<?php echo $result_files[$i]['orf_id']?>" value="<?php echo $result_files[$i]['config_level']; ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <img id="selected_shape_picture<?php echo $result_files[$i]['orf_id'];?>" src="<?php 
                                                                    $door_shapes_pictures=$prod->get_all_door_shapes();

                                                                    for($p=0;$p<count($door_shapes_pictures);$p++)
                                                                    {
                                                                        if($pict_categ_name_array[1]==$door_shapes_pictures[$p]['dsp_id'])
                                                                        {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/".$door_shapes_pictures[$p]['dsp_pic'];
                                                                        }
                                                                    }

                                                                    $roof_shapes_pictures=$prod->get_all_roof_shapes();

                                                                    for($p=0;$p<count($roof_shapes_pictures);$p++)
                                                                    {
                                                                        if($pict_categ_name_array[1]==$roof_shapes_pictures[$p]['rs_id'])
                                                                        {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/".$roof_shapes_pictures[$p]['rs_pic'];
                                                                        }
                                                                    }

                                                                    $gutters_shapes_pictures=$prod->get_all_gutters();

                                                                    for($p=0;$p<count($gutters_shapes_pictures);$p++)
                                                                    {
                                                                        if($pict_categ_name_array[1]==$gutters_shapes_pictures[$p]['gut_id'])
                                                                        {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/".$gutters_shapes_pictures[$p]['gut_pic'];
                                                                        }
                                                                    }
                                                                    ?>" alt="<?php 
                                                                    
                                                                    if(strpos($o_results_configurator_plus['pa_symbol'],"_org")=== false)
                                                                    {
                                                                        echo ucfirst($o_results_configurator_plus['pa_symbol']);
                                                                    }                                                                
                                                                    elseif(strpos($o_results_configurator_plus['pa_symbol'],"_org")!== false)
                                                                    {
                                                                        echo "Original";
                                                                    }
                                                                    else
                                                                    { 
                                                                        echo "What is it ?";
                                                                    } ?>" class="door_shapes <?php 
                                                                    if($countDoorShapeImage === 0) echo 'broken_door_shape_image' ?>" data-pa_id="<?php echo $$o_results_configurator_plus['pa_id']; ?>" style="width:50px;height:50px;" whidth="50" height="50">
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <input id="img_categ<?php echo $result_files[$i]['orf_id']; ?>"
                                                            data-id1="<?php echo $result_files[$i]['orf_id']; ?>"
                                                            class="form-control" type="hidden"
                                                            value="<?php 
                                                            echo $pict_categ_name_array[0];                                                
                                                                ?>">
                                                            <script type="text/javascript">
                                                                $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').click(function(){
                                                                    $('#existing_classifyModal<?php echo $result_files[$i]['orf_id'];?>').modal('show');
                                                                });
                                                            </script>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="existing_classifyModal<?php echo $result_files[$i]['orf_id'];?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="existing_classifyModalLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="existing_classifyModalLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose clasification</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">                                                    
                                                                        <?php
                                                                        $all_classifications=$prod->get_all_picture_areas();
                                                                        $classification_counter=0;
                                                                        for($s=0;$s<count($all_classifications);$s++)
                                                                        {
                                                                            if(substr($all_classifications[$s]['pa_id'], -1)=="1")
                                                                            {
                                                                                    ?>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input" type="radio" name="pa_id[]" id="existing_pa_id_<?php echo $result_files[$i]['orf_id'];?>_<?php echo $classification_counter;?>" value="<?php 
                                                                                                echo $all_classifications[$s]['pa_id'];?>" data-pa_description="<?php echo $all_classifications[$s]['pa_description'];?>" <?php 
                                                                                                echo ($all_classifications[$s]['pa_id']==$result_files[$i]['config_level'])?"checked":"";
                                                                                                ?>>
                                                                                                <label class="form-check-label" for="existing_pa_id_<?php echo $result_files[$i]['orf_id'];?>_<?php echo $classification_counter;?>">
                                                                                                    <?php echo $all_classifications[$s]['pa_id'];?>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <?php echo $all_classifications[$s]['pa_description'];?>
                                                                                        </div>                                                    
                                                                                    </div>
                                                                                    <script type="text/javascript">
                                                                                        $('#existing_pa_id_<?php echo $result_files[$i]['orf_id'];?>_<?php echo $classification_counter;?>').click(function(){
                                                                                            let pa_id=$(this).val();
                                                                                            let pa_description=$(this).data('pa_description');
                                                                                            let o_id=<?php echo $o_id;?>;
                                                                                            let osub_id="<?php echo $osub_id;?>";
                                                                                            let prod_id="<?php echo $prod_id;?>";
                                                                                            let orf_id=<?php echo $result_files[$i]['orf_id'];?>;

                                                                                            $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').text(pa_description);
                                                                                            $('#pa_id<?php echo $result_files[$i]['orf_id']?>').val(pa_id);

                                                                                            $.ajax({
                                                                                                url: "<?php echo $base_url;?>ajax/update_orf_id_config_level.php",
                                                                                                method: "post",
                                                                                                data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,orf_id:orf_id,config_level:pa_id},
                                                                                                dataType:"html",
                                                                                                success:function(data) {

                                                                                                    

                                                                                                }
                                                                                            });

                                                                                            
                                                                                        });
                                                                                    </script>
                                                                                    <?php
                                                                                    $classification_counter++;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end Modal -->
                                                            <script type="text/javascript">
                                                                $('#existing_classifyModal<?php echo $result_files[$i]['orf_id'];?>').on('hidden.bs.modal', function () {
                                                                    setTimeout(function () {
                                                                                                
                                                                        var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                                                        window.location.href = redirectToURL;
                                                                        window.location.reload(true);

                                                                    }, 100);
                                                                });
                                                            </script>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="picture_select<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose picture</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php
                                                                        $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                                                        
                                                                        for($p=0;$p<count($configurator_pictures);$p++)
                                                                        {
                                                                            ?>
                                                                            <div class="row p-3">
                                                                                <div class="col-md-6">
                                                                                    <img id="configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>" class="configurator_pictures <?php if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id']){echo "configurator_pictures_clicked";}?>" src="<?php echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];?>" data-orf_id="<?php echo $configurator_pictures[$p]['orf_id'];?>" alt="No picture">
                                                                                    <script type="text/javascript">
                                                                                        

                                                                                        $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').hover(function(){
                                                                                            $(this).css('cursor','pointer');
                                                                                            
                                                                                        });

                                                                                        $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').click(function(){
                                                                                            
                                                                                            $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').attr('value',$('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').data('orf_id'));
                                                                                            
                                                                                            $('.configurator_pictures').removeClass('configurator_pictures_clicked');
                                                                                            $(this).addClass('configurator_pictures_clicked');
                                                                                            
                                                                                            
                                                                                                let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".dsp_002";
                                                                                                //let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                                                                let img_categ=img_categ1;
                                                                                            
                                                                                            
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                        img_categ:img_categ
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function(){

                                                                                                    let srcValue = $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').attr('src');
                                                                                                    $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                });

                                                                                        });

                                                                                    </script>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="door_shape_select<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="door_shape_selectLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="door_shape_selectLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose what shall be shown</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <?php
                                                                                if($result_files[$i]['config_level']=="pa0000")
                                                                                {
                                                                                    
                                                                                    ?>
                                                                                    <div class="row">    
                                                                                        <div class="col-md-6">            
                                                                                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Interior" data-base_render_id="interior" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Interior
                                                                                            </div>                
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Exterior" data-base_render_id="exterior" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Exterior
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <script type="text/javascript">
                                                                                        $('.original_shape').hover(function(){
                                                                                            $(this).css('cursor','pointer');                        
                                                                                        });
                                                                                    </script>
                                                                                    <br>
                                                                                    <script type="text/javascript">
                                                                                        $('.shape_pictures').hover(function(){
                                                                                            $(this).css('cursor','pointer');                        
                                                                                        });
                                                                                
                                                                                        $('.shape_pictures').click(function(){
                                                                                            let srcValue = $(this).attr('src');
                                                                                            let altValue = $(this).attr('alt');
                                                                                
                                                                                            
                                                                                
                                                                                            $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                            $(this).addClass('shape_pictures_clicked');
                                                                                            
                                                                                            
                                                                                            
                                                                                            let img_categ2=$(this).data('base_render_id');
                                                                                            let orf_id=$(this).data('orf_id');
                                                                                            
                                                                                        
                                                                                            $.ajax({
                                                                                                url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                method: "post",
                                                                                                data: {
                                                                                                    orf_id:orf_id,
                                                                                                    img_categ:img_categ2
                                                                                                },
                                                                                                dataType: "html",
                                                                                                success: function (data) {

                                                                                                }
                                                                                            }).done(function(){

                                                                    
                                                                                                $('#selected_shape_picture'+orf_id).attr('src', srcValue);
                                                                                                $('#selected_shape_picture'+orf_id).attr('alt', altValue);

                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id:orf_id,
                                                                                                        o_id:<?php echo $o_id;?>,
                                                                                                        osub_id:"<?php echo $osub_id;?>",
                                                                                                        prod_id:"<?php echo $prod_id;?>",
                                                                                                        pa_symbol:img_categ2,
                                                                                                        connected_to:0,
                                                                                                        pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function(){

                                                                                                    
                                                                                                });
                                                                                                
                                                                                            });

                                                                                            
                                                                                        });
                                                                                
                                                                                    </script>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0001")
                                                                                {
                                                                                    
                                                                                    ?>
                                                                                    <div class="row">    
                                                                                        <div class="col-md-6">            
                                                                                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Interior" data-base_render_id="interior" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Interior
                                                                                            </div>                
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Exterior" data-base_render_id="exterior" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Exterior
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <script type="text/javascript">
                                                                                        $('.original_shape').hover(function(){
                                                                                            $(this).css('cursor','pointer');                        
                                                                                        });
                                                                                    </script>
                                                                                    <br>
                                                                                    <script type="text/javascript">
                                                                                        $('.shape_pictures').hover(function(){
                                                                                            $(this).css('cursor','pointer');                        
                                                                                        });
                                                                                
                                                                                        $('.shape_pictures').click(function(){
                                                                                            let srcValue = $(this).attr('src');
                                                                                            let altValue = $(this).attr('alt');
                                                                                
                                                                                            
                                                                                
                                                                                            $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                            $(this).addClass('shape_pictures_clicked');
                                                                                            
                                                                                            
                                                                                            
                                                                                            let img_categ2=$(this).data('base_render_id');
                                                                                            let orf_id=$(this).data('orf_id');
                                                                                            
                                                                                        
                                                                                            $.ajax({
                                                                                                url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                method: "post",
                                                                                                data: {
                                                                                                    orf_id:orf_id,
                                                                                                    img_categ:img_categ2
                                                                                                },
                                                                                                dataType: "html",
                                                                                                success: function (data) {

                                                                                                }
                                                                                            }).done(function(){

                                                                    
                                                                                                $('#selected_shape_picture'+orf_id).attr('src', srcValue);
                                                                                                $('#selected_shape_picture'+orf_id).attr('alt', altValue);

                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id:orf_id,
                                                                                                        o_id:<?php echo $o_id;?>,
                                                                                                        osub_id:"<?php echo $osub_id;?>",
                                                                                                        prod_id:"<?php echo $prod_id;?>",
                                                                                                        pa_symbol:img_categ2,
                                                                                                        connected_to:0,
                                                                                                        pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function(){

                                                                                                    
                                                                                                });
                                                                                                
                                                                                            });

                                                                                            
                                                                                        });
                                                                                
                                                                                    </script>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0110")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='wall_area_main_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').attr('src');
                                                                                                            let altValue = $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0111")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='wall_area_main_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').attr('src');
                                                                                                            let altValue = $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0120")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='wall_area_2_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').attr('src');
                                                                                                            let altValue = $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0121")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='wall_area_2_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').attr('src');
                                                                                                            let altValue = $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0130")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='wall_area_3_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').attr('src');
                                                                                                            let altValue = $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0131")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='wall_area_3_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').attr('src');
                                                                                                            let altValue = $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0140")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='floor_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('src');
                                                                                                            let altValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0141")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='floor_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('src');
                                                                                                            let altValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0180")
                                                                                {
                                                                                    $door_shape_pictures=$prod->get_all_door_shapes();
                                                                                    $door_shape_counter=0;
                                                                                    for($p=0;$p<count($door_shape_pictures);$p++)
                                                                                    {
                                                                                        if(($door_shape_pictures[$p]['dsp_color_db']=="blue dark")&&(!empty($door_shape_pictures[$p]['dsp_pic']))&&($door_shape_counter<4))
                                                                                        {
                                                                                            ?>
                                                                                            <div class="row p-3">
                                                                                                <div class="col-md-6">
                                                                                                    <img id="door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php 
                                                                                                    echo $door_shape_pictures[$p]['dsp_id'];?>" class="door_shape_pictures <?php 
                                                                                                    if($pict_categ_name_array[1]==$door_shape_pictures[$p]['dsp_id']){echo "door_shape_pictures_clicked";}?>" src="<?php 
                                                                                                    echo "https://domenia.blue7.it/".$door_shape_pictures[$p]['dsp_pic'];?>" data-dsp_id="<?php 
                                                                                                    echo $door_shape_pictures[$p]['dsp_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                                    <script type="text/javascript">
                                                                                                        

                                                                                                        $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').hover(function(){
                                                                                                            $(this).css('cursor','pointer');
                                                                                                            
                                                                                                        });

                                                                                                        $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').click(function(){
                                                                                                            
                                                                                                            //$('#selected_door_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('value',$('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').data('dsp_id'));
                                                                                                            
                                                                                                            $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                            $(this).addClass('door_shape_pictures_clicked');
                                                                                                            
                                                                                                            
                                                                                                                let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                                let img_categ2=$(this).data('dsp_id');
                                                                                                                let img_categ=img_categ1+img_categ2;
                                                                                                            
                                                                                                            
                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                                    method: "post",
                                                                                                                    data: {
                                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                        img_categ:img_categ
                                                                                                                    },
                                                                                                                    dataType: "html",
                                                                                                                    success: function (data) {

                                                                                                                    }
                                                                                                                }).done(function(){

                                                                                                                    let srcValue = $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').attr('src');
                                                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                                    $.ajax({
                                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                        method: "post",
                                                                                                                        data: {
                                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                                            osub_id:"<?php echo $osub_id;?>",
                                                                                                                            prod_id:"<?php echo $prod_id;?>",
                                                                                                                            pa_symbol:img_categ2,
                                                                                                                            connected_to:img_categ1,
                                                                                                                            pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                        },
                                                                                                                        dataType: "html",
                                                                                                                        success: function (data) {

                                                                                                                        }
                                                                                                                    }).done(function(){

                                                                                                                        
                                                                                                                    });

                                                                                                                });

                                                                                                        });

                                                                                                    </script>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php
                                                                                            $door_shape_counter++;
                                                                                        }    
                                                                                    }
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0181")
                                                                                {
                                                                                    $door_shape_pictures=$prod->get_all_door_shapes();
                                                                                    $door_shape_counter=0;
                                                                                    for($p=0;$p<count($door_shape_pictures);$p++)
                                                                                    {
                                                                                        if(($door_shape_pictures[$p]['dsp_color_db']=="blue dark")&&(!empty($door_shape_pictures[$p]['dsp_pic']))&&($door_shape_counter<4))
                                                                                        {
                                                                                            ?>
                                                                                            <div class="row p-3">
                                                                                                <div class="col-md-6">
                                                                                                    <img id="door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php 
                                                                                                    echo $door_shape_pictures[$p]['dsp_id'];?>" class="door_shape_pictures <?php 
                                                                                                    if($pict_categ_name_array[1]==$door_shape_pictures[$p]['dsp_id']){echo "door_shape_pictures_clicked";}?>" src="<?php 
                                                                                                    echo "https://domenia.blue7.it/".$door_shape_pictures[$p]['dsp_pic'];?>" data-dsp_id="<?php 
                                                                                                    echo $door_shape_pictures[$p]['dsp_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                                    <script type="text/javascript">
                                                                                                        

                                                                                                        $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').hover(function(){
                                                                                                            $(this).css('cursor','pointer');
                                                                                                            
                                                                                                        });

                                                                                                        $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').click(function(){
                                                                                                            
                                                                                                            //$('#selected_door_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('value',$('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').data('dsp_id'));
                                                                                                            
                                                                                                            $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                            $(this).addClass('door_shape_pictures_clicked');
                                                                                                            
                                                                                                            
                                                                                                                let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                                let img_categ2=$(this).data('dsp_id');
                                                                                                                let img_categ=img_categ1+img_categ2;
                                                                                                            
                                                                                                            
                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                                    method: "post",
                                                                                                                    data: {
                                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                        img_categ:img_categ
                                                                                                                    },
                                                                                                                    dataType: "html",
                                                                                                                    success: function (data) {

                                                                                                                    }
                                                                                                                }).done(function(){

                                                                                                                    let srcValue = $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').attr('src');
                                                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                                    $.ajax({
                                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                        method: "post",
                                                                                                                        data: {
                                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                                            osub_id:"<?php echo $osub_id;?>",
                                                                                                                            prod_id:"<?php echo $prod_id;?>",
                                                                                                                            pa_symbol:img_categ2,
                                                                                                                            connected_to:img_categ1,
                                                                                                                            pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                        },
                                                                                                                        dataType: "html",
                                                                                                                        success: function (data) {

                                                                                                                        }
                                                                                                                    }).done(function(){

                                                                                                                        
                                                                                                                    });

                                                                                                                });

                                                                                                        });

                                                                                                    </script>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php
                                                                                            $door_shape_counter++;
                                                                                        }    
                                                                                    }
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0170")
                                                                                {
                                                                                    $roof_shape_pictures=$prod->get_all_roof_shapes();
                                                                                    
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });


                                                                                                $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='rs_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').attr('src');
                                                                                                            let altValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });

                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                    for($r=0;$r<count($roof_shape_pictures);$r++)
                                                                                    {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                
                                                                                                <img id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>" src="<?php 
                                                                                            echo "https://domenia.blue7.it/".$roof_shape_pictures[$r]['rs_pic'];?>" data-rs_id="<?php 
                                                                                            echo $roof_shape_pictures[$r]['rs_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">
                                                                                                        

                                                                                            $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').hover(function(){
                                                                                                $(this).css('cursor','pointer');
                                                                                                
                                                                                            });

                                                                                            $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').click(function(){
                                                                                                
                                                                                                
                                                                                                
                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                $(this).addClass('door_shape_pictures_clicked');
                                                                                                
                                                                                                
                                                                                                    let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                    let img_categ2=$(this).data('rs_id');
                                                                                                    let img_categ=img_categ1+img_categ2;
                                                                                                
                                                                                                
                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                            img_categ:img_categ
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function(){

                                                                                                        let srcValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').attr('src');
                                                                                                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                o_id:<?php echo $o_id;?>,
                                                                                                                osub_id:"<?php echo $osub_id;?>",
                                                                                                                prod_id:"<?php echo $prod_id;?>",
                                                                                                                pa_symbol:img_categ2,
                                                                                                                connected_to:img_categ1,
                                                                                                                pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            
                                                                                                        });

                                                                                                    });

                                                                                            });

                                                                                        </script>
                                                                                        <?php
                                                                                        
                                                                                    }
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0171")
                                                                                {
                                                                                    $roof_shape_pictures=$prod->get_all_roof_shapes();
                                                                                    
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });


                                                                                                $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='rs_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').attr('src');
                                                                                                            let altValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });

                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                    
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0150")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='skirting_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').attr('src');
                                                                                                            let altValue = $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0151")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='skirting_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').attr('src');
                                                                                                            let altValue = $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0160")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='electric_switches_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').attr('src');
                                                                                                            let altValue = $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0161")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='electric_switches_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').attr('src');
                                                                                                            let altValue = $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0190")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='window_frames_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').attr('src');
                                                                                                            let altValue = $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0191")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='window_frames_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').attr('src');
                                                                                                            let altValue = $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0200")
                                                                                {
                                                                                    $gutters_shape_pictures=$prod->get_all_gutters();
                                                                                    
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });


                                                                                                $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='gut_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').attr('src');
                                                                                                            let altValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });

                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                    for($r=0;$r<count($gutters_shape_pictures);$r++)
                                                                                    {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                
                                                                                                <img id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>" src="<?php 
                                                                                            echo "https://domenia.blue7.it/".$gutters_shape_pictures[$r]['gut_pic'];?>" data-gut_id="<?php 
                                                                                            echo $gutters_shape_pictures[$r]['gut_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">
                                                                                                        

                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').hover(function(){
                                                                                                $(this).css('cursor','pointer');
                                                                                                
                                                                                            });

                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').click(function(){
                                                                                                
                                                                                                
                                                                                                
                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                $(this).addClass('door_shape_pictures_clicked');
                                                                                                
                                                                                                
                                                                                                    let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                    let img_categ2=$(this).data('gut_id');
                                                                                                    let img_categ=img_categ1+img_categ2;
                                                                                                
                                                                                                
                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                            img_categ:img_categ
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function(){

                                                                                                        let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').attr('src');
                                                                                                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                o_id:<?php echo $o_id;?>,
                                                                                                                osub_id:"<?php echo $osub_id;?>",
                                                                                                                prod_id:"<?php echo $prod_id;?>",
                                                                                                                pa_symbol:img_categ2,
                                                                                                                connected_to:img_categ1,
                                                                                                                pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            
                                                                                                        });

                                                                                                    });

                                                                                            });

                                                                                        </script>
                                                                                        <?php
                                                                                        
                                                                                    }
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0201")
                                                                                {
                                                                                    $gutters_shape_pictures=$prod->get_all_gutters();
                                                                                    
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });


                                                                                                $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='gut_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').attr('src');
                                                                                                            let altValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });

                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                    for($r=0;$r<count($gutters_shape_pictures);$r++)
                                                                                    {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                
                                                                                                <img id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>" src="<?php 
                                                                                            echo "https://domenia.blue7.it/".$gutters_shape_pictures[$r]['gut_pic'];?>" data-gut_id="<?php 
                                                                                            echo $gutters_shape_pictures[$r]['gut_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">
                                                                                                        

                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').hover(function(){
                                                                                                $(this).css('cursor','pointer');
                                                                                                
                                                                                            });

                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').click(function(){
                                                                                                
                                                                                                
                                                                                                
                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                $(this).addClass('door_shape_pictures_clicked');
                                                                                                
                                                                                                
                                                                                                    let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                    let img_categ2=$(this).data('gut_id');
                                                                                                    let img_categ=img_categ1+img_categ2;
                                                                                                
                                                                                                
                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                            img_categ:img_categ
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function(){

                                                                                                        let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').attr('src');
                                                                                                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                o_id:<?php echo $o_id;?>,
                                                                                                                osub_id:"<?php echo $osub_id;?>",
                                                                                                                prod_id:"<?php echo $prod_id;?>",
                                                                                                                pa_symbol:img_categ2,
                                                                                                                connected_to:img_categ1,
                                                                                                                pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            
                                                                                                        });

                                                                                                    });

                                                                                            });

                                                                                        </script>
                                                                                        <?php
                                                                                        
                                                                                    }
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0210")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='window_sills_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').attr('src');
                                                                                                            let altValue = $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa0211")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='window_sills_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').attr('src');
                                                                                                            let altValue = $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1010")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_1_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1011")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_1_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1020")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_2_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1021")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_2_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1030")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_3_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1031")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_3_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1040")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_4_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1041")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_4_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1050")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_5_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1051")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_5_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1060")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_6_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1061")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_6_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1070")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_7_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                if($result_files[$i]['config_level']=="pa1071")
                                                                                {                                                                        
                                                                                    ?>
                                                                                    <div class="row p-3">
                                                                                        <div class="col-md-6">                                                                                
                                                                                            <div id="extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                Original
                                                                                            </div>
                                                                                            <script type="text/javascript">
                                                                                                $('.original_shape').hover(function(){
                                                                                                    $(this).css('cursor','pointer');                        
                                                                                                });

                                                                                                $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').hover(function(){
                                                                                                    $(this).css('cursor','pointer');
                                                                                                    
                                                                                                });

                                                                                                $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').click(function(){                                                                                       
                                                                                                    
                                                                                                    
                                                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                    $(this).addClass('shape_pictures_clicked');
                                                                                                    
                                                                                                    
                                                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                        let img_categ2='extra_layer_7_org';
                                                                                                        let img_categ=img_categ1+img_categ2;
                                                                                                    
                                                                                                    
                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ:img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function(){

                                                                                                            let srcValue = $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').attr('src');
                                                                                                            let altValue = $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').attr('alt');
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                                                            $.ajax({
                                                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                method: "post",
                                                                                                                data: {
                                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                    o_id:<?php echo $o_id;?>,
                                                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                                                    pa_symbol:img_categ2,
                                                                                                                    connected_to:img_categ1,
                                                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function(){

                                                                                                                
                                                                                                            });
                                                                                                            
                                                                                                        });

                                                                                                });

                                                                                            </script>        
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }

                                                                                ?>
                                                                            </div>                                    
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                        <?php
                                                    }
                                                    elseif(substr($result_files[$i]['prod_id'], -1) === 'z')
                                                    {
                                                        $pict_categ_name_array=explode(".",$result_files[$i]['pict_categ_name']);
                                                        ?>
                                                        <input id="img_categ_part2<?php echo $result_files[$i]['orf_id']; ?>" class="form-control" type="text" value="<?php echo $pict_categ_name_array[2];?>" style="">
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <input id="img_categ<?php echo $result_files[$i]['orf_id']; ?>"
                                                            list="img_categ2" data-id1="<?php echo $result_files[$i]['orf_id']; ?>"
                                                            class="form-control" type="text"
                                                            value="<?php echo $result_files[$i]['pict_categ_name']; ?>">
                                                        <?php
                                                    }

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
                                                        <datalist id="img_categ2"
                                                                data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
                                                            <option value="EG">EG</option>
                                                            <option value="OG">OG</option>
                                                            <option value="OG 1">OG 1</option>
                                                            <option value="DG">DG</option>
                                                            <option value="KG">KG</option>
                                                        </datalist>
                                                        <?php
                                                    }

                                                    if ((substr($result_files[$i]['prod_id'], -2) === '04') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '06') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '24') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '26')
                                                    ) {
                                                        ?>
                                                        <datalist id="img_categ2"
                                                        data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
                                                        <option value="Bad">Bad</option>
                                                        <option value="Büro">Büro</option>
                                                        <option value="Essen">Essen</option>
                                                        <option value="Flur">Flur</option>
                                                        <option value="Hobby">Hobby</option>
                                                        <option value="Küche">Küche</option>
                                                        <option value="Schlafen">Schlafen</option>
                                                        <option value="WC">WC</option>
                                                        <option value="WEK">WEK</option>
                                                        <option value="Wohnen">Wohnen</option>
                                                        </datalist>
                                                        <?php
                                                    }

                                                    if (($result_files[$i]['prod_id'] == "p1563") || ($result_files[$i]['prod_id'] == "p1583") ||
                                                        ($result_files[$i]['prod_id'] == "p1663") || ($result_files[$i]['prod_id'] == "p1683") ||
                                                        ($result_files[$i]['prod_id'] == "p1763") || ($result_files[$i]['prod_id'] == "p1783") ||
                                                        ($result_files[$i]['prod_id'] == "p1863") || ($result_files[$i]['prod_id'] == "p1883")) 
                                                    {
                                                        ?>
                                                        <datalist id="img_categ2"
                                                                data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
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
                                                    ?>
                                                </form>

                                                <script type="text/javascript">
                                                    <?php
                                                    if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                                    {
                                                        ?>
                                                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                                                            $('#door_shape_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                                                        });    

                                                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                                                $(this).css('cursor','pointer');                                                    
                                                        });
                                                        <?php
                                                    }                                        
                                                    ?>
                                                    $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').on("keyup focusout change", function () {

                                                        <?php
                                                        if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                                        {
                                                            ?>
                                                            let img_categ=$(this).val()+".total";
                                                            <?php
                                                        }
                                                        elseif(substr($result_files[$i]['prod_id'], -1) === 'z')
                                                        {
                                                            ?>
                                                            let img_categ1=$(this).val()+".colors.";
                                                            let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                            let img_categ=img_categ1+img_categ2;
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            let img_categ=$(this).val();
                                                            <?php
                                                        }
                                                        ?>
                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                            method: "post",
                                                            data: {
                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                img_categ:img_categ
                                                            },
                                                            dataType: "html",
                                                            success: function (data) {

                                                            }
                                                        });
                                                    });

                                                    <?php
                                                    if(substr($result_files[$i]['prod_id'], -1) === 'z')
                                                    {
                                                    ?>
                                                    $('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').on("keyup focusout", function () {
                                                        
                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".colors.";
                                                        let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                        let img_categ=img_categ1+img_categ2;
                                                        
                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                            method: "post",
                                                            data: {
                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                img_categ:img_categ
                                                            },
                                                            dataType: "html",
                                                            success: function (data) {

                                                            }
                                                        });
                                                        });
                                                    <?php
                                                    }
                                                    ?>
                                                </script>
                                                <?php
                                                if(
                                                ((substr($prod_id,1)>1100)&&(substr($prod_id,1)<1160))||
                                                ((substr($prod_id,1)>1299)&&(substr($prod_id,1)<1360))||
                                                ((substr($prod_id,1)>1499)&&(substr($prod_id,1)<1560))||
                                                ((substr($prod_id,1)>1599)&&(substr($prod_id,1)<1660))||
                                                ((substr($prod_id,1)>1699)&&(substr($prod_id,1)<1760))||
                                                ((substr($prod_id,1)>1799)&&(substr($prod_id,1)<1860))||
                                                (substr($prod_id, -2)=="2y")
                                                )
                                                {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <b>Assign to room number:</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control form-control-sm" id="room_id<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" name="room_id">
                                                                <option value="0">Unspecified</option>
                                                                <?php
                                                                $rooms_data['o_id']=$o_id;
                                                                $rooms_data['osub_id']=$osub_id;

                                                                $rooms=$prod->get_all_rooms_for_this_sub_id(json_encode($rooms_data));

                                                                for($r=0;$r<count($rooms);$r++)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $rooms[$r]['room_id'];?>" <?php echo ($rooms[$r]['room_id']==$result_files[$i]['room_id'])?"selected":"";?>><?php
                                                                    echo $rooms[$r]['room_number']." - ";
                                                                    echo $translation=$prod->get_translation_text(1, $rooms[$r]['rk_id'])['text'];
                                                                    ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <script type="text/javascript">
                                                            $('#room_id<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                let orf_id=$(this).data('orf_id');
                                                                let room_id=$(this).val();

                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/assign_room_id_to_result_file.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id:orf_id,
                                                                        room_id: room_id
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {

                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if(
                                                (substr($prod_id, -2)=="6b")||(substr($prod_id, -2)=="gb")
                                                )
                                                {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <b>Assign to perspective:</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control form-control-sm" id="per_id<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" name="per_id">
                                                                <option value="0">Unspecified</option>
                                                                <?php
                                                                $perspective_data['o_id']=$o_id;
                                                                $perspective_data['osub_id']=$osub_id;

                                                                $perspective=$prod->get_all_perspectives_for_this_sub_id(json_encode($perspective_data));

                                                                for($r=0;$r<count($perspective);$r++)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $perspective[$r]['per_id'];?>" <?php echo ($perspective[$r]['per_id']==$result_files[$i]['per_id'])?"selected":"";?>><?php
                                                                    echo $perspective[$r]['per_kind'];
                                                                    ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <script type="text/javascript">
                                                            $('#per_id<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                let orf_id=$(this).data('orf_id');
                                                                let per_id=$(this).val();

                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/assign_per_id_to_result_file.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id:orf_id,
                                                                        per_id: per_id
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {

                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="col-md-2 border-right border-dark px-0 py-1">
                                                <?php
                                                if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <?php 
                                                        if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                                        {
                                                            echo $result_files[$i]['orf_id'];
                                                        } ?>
                                                    <div id="image_tooltip_container_<?php
                                                    echo $image_preview_counter;
                                                    ?>">
                                                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                            src="<?php echo $base_url;?>result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                            alt="<?php echo $result_files[$i]['orf_name']; ?>">
                                                    </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <?php echo $filesize = $prod->filesize_formatted("result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']); ?>
                                                    </div>
                                                    </div>
                                                    <?php
                                                } else { ?>

                                                    <?php
                                                    $file_path = $result_files[$i]['orf_internal_name_dom'];

                                                    // Get the file extension
                                                    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

                                                    // Define an array of supported file extensions and their corresponding icon filenames
                                                    $extension_icons = array(
                                                        'dxf' => 'dxf_icon.jpg',
                                                        'jpeg' => 'jpg_icon.png',
                                                        'jpg' => 'jpg_icon.png',
                                                        'png' => 'png_icon.png',
                                                        'gif' => 'gif_icon.png',
                                                        'dwg' => 'dwg_icon.jpg',
                                                        'eps' => 'eps_icon.webp',
                                                        'pdf' => 'pdf_icon.jpg',
                                                        'svg' => 'svg_icon.png',
                                                        'cdr' => 'cdr_icon.jpg',
                                                        'skp' => 'skp_icon.jpg',
                                                        'txt' => 'txt_icon.jpg'
                                                        // Add more extensions and their corresponding icons as needed
                                                    );

                                                        // Check if the file extension is in the extension_icons array
                                                    if (array_key_exists($file_extension, $extension_icons)) {
                                                        // Construct the src attribute with the corresponding icon filename
                                                        $icon_src = $base_url."img/" . $extension_icons[$file_extension];
                                                        // Output the img tag with the constructed src attribute
                                                        echo "<img class='img-responsive' style='width:60px;cursor:pointer;' src='$icon_src' alt='File icon'>";
                                                    } else {
                                                        // If the file extension is not supported, use a default icon
                                                        echo "<img class='img-responsive' style='width:60px;cursor:pointer;' src='img/default-icon.png' alt='Default file icon'>";
                                                    }
                                                    ?>

                                                    <?php echo $filesize = $prod->filesize_formatted("result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']); ?>
                                                <?php }
                                                ?>
                                                <form name="deletecreatorfile"
                                                    action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>"
                                                    method="post">
                                                    <input type="hidden" name="orf_id"
                                                        value="<?php echo $result_files[$i]['orf_id']; ?>">

                                                    <a href="<?php echo $base_url;?>image.php?filecategory=creatorfiles&orfid=<?php echo $result_files[$i]['orf_id']; ?>"
                                                    alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-down mr-2"></i>Download</a>

                                                    <button type="button" id="res_delete_btn<?php echo $result_files[$i]['orf_id']; ?>" name="res_delete_btn" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i></button>
                                                    <script type="text/javascript">
                                                    $('#res_delete_btn<?php echo $result_files[$i]['orf_id']; ?>').click(function(){
                                                        let orf_id=$(this).data("orf_id");

                                                        if(confirm('Are you sure want do delete ?'))
                                                        {

                                                            $.ajax({
                                                                url: "<?php echo $base_url;?>ajax/delete_result_file.php",
                                                                method: "post",
                                                                data: {orf_id:orf_id},
                                                                dataType:"html",
                                                                success:function(data) {
                                                                    $('#result_file_row<?php echo $result_files[$i]['orf_id']; ?>').fadeOut(3000);
                                                                }
                                                            });

                                                        }
                                                    });
                                                    </script>
                                                </form>


                                                

                                            </div>
                                            <div class="col-md-2 border-right border-dark px-0 py-1">                                    
                                                <?php
                                                if(substr($result_files[$i]['prod_id'], -1) === 'z')
                                                {
                                                    $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                                    $pict_categ_name_array=explode(".",$result_files[$i]['pict_categ_name']);                                                       
                                                    
                                                    ?>
                                                    <img id="selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>" src="<?php 
                                                    for($p=0;$p<count($configurator_pictures);$p++)
                                                    {
                                                        if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id'])
                                                        {
                                                            echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];
                                                        }
                                                    }
                                                    ?>" alt="Choose picture" class="configurator_pictures" style="width:50px;height:50px;">
                                                    
                                                    <input id="img_categ<?php echo $result_files[$i]['orf_id']; ?>"
                                                    data-id1="<?php echo $result_files[$i]['orf_id']; ?>"
                                                    class="form-control" type="hidden"
                                                    value="<?php 
                                                    echo $pict_categ_name_array[0];                                                
                                                        ?>" style="width:6em"><span class="pl-2 pt-2 pr-2"></span>
                                                    

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="picture_select<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose picture</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php
                                                                    $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                                                    
                                                                    for($p=0;$p<count($configurator_pictures);$p++)
                                                                    {
                                                                        ?>
                                                                        <div class="row p-3">
                                                                            <div class="col-md-6">
                                                                                <img id="configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>" class="configurator_pictures <?php if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id']){echo "configurator_pictures_clicked";}?>" src="<?php echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];?>" data-orf_id="<?php echo $configurator_pictures[$p]['orf_id'];?>" alt="No picture">
                                                                                <script type="text/javascript">
                                                                                    

                                                                                    $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').hover(function(){
                                                                                        $(this).css('cursor','pointer');
                                                                                        
                                                                                    });

                                                                                    $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').click(function(){
                                                                                        
                                                                                        $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').attr('value',$('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').data('orf_id'));
                                                                                        
                                                                                        $('.configurator_pictures').removeClass('configurator_pictures_clicked');
                                                                                        $(this).addClass('configurator_pictures_clicked');
                                                                                        
                                                                                        
                                                                                            let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".colors.";
                                                                                            let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                                                            let img_categ=img_categ1+img_categ2;
                                                                                        
                                                                                        
                                                                                            $.ajax({
                                                                                                url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                method: "post",
                                                                                                data: {
                                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                    img_categ:img_categ
                                                                                                },
                                                                                                dataType: "html",
                                                                                                success: function (data) {

                                                                                                }
                                                                                            }).done(function(){

                                                                                                let srcValue = $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').attr('src');
                                                                                                $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                                            });

                                                                                    });

                                                                                </script>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script type="text/javascript">
                                                            <?php
                                                            if((substr($result_files[$i]['prod_id'], -1) === 'z')||(substr($result_files[$i]['prod_id'], -1) === 'y'))
                                                            {
                                                                ?>
                                                                $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                                                                    $('#picture_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                                                                });    

                                                                $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                                                        $(this).css('cursor','pointer');                                                    
                                                                });
                                                                <?php
                                                            }
                                                            ?>
                                                        </script>
                                                    <?php
                                                }

                                                if((substr($prod_id, -1) !== '8')&&(substr($prod_id, -1) !== '7'))
                                                {

                                                    if ($result_files[$i]['orf_type_dom'] == 'jpg' or $result_files[$i]['orf_type_dom'] == 'jpeg' or $result_files[$i]['orf_type_dom'] == 'png'): ?>
                                                        <?php if ($result_files[$i]['orf_compress_path']): ?>
                                                            <a target="_blank"
                                                            href="<?php echo $base_url;?>result_compress_files/<?= $result_files[$i]['orf_compress_path'] ?>"
                                                            class="btn btn-primary btn-sm mt-2">Compressed file</a>
                                                            <?php echo $filesize = $prod->filesize_formatted("result_compress_files/" . $result_files[$i]['orf_compress_path']); ?>
                                                        <?php else: ?>
                                                            <p class="text-danger text-sm">Please reupload file, compressed copy is
                                                                missing!</p>
                                                        <?php endif; ?>
                                                    <?php endif; 

                                                
                                                }
                                                else
                                                {
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>">www.youtube.com/embed/</label>
                                                        <input type="text" class="form-control form-control-sm" title="Add only the last 11 characters" placeholder="Add only the last 11 characters" id="orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>" name="orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" value="<?php
                                                        if(!empty($result_files[$i]['orf_youtube_link']))
                                                        {
                                                            //echo $result_files[$i]['orf_youtube_link'];
                                                            $youtube_link=explode("/embed/",$result_files[$i]['orf_youtube_link']);
                                                            echo $youtube_link[1];
                                                        }
                                                        ?>">
                                                        <script type="text/javascript">
                                                            $('#orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                let orf_id=$(this).data('orf_id');
                                                                let orf_youtube_link="";

                                                                if($(this).val()!="")
                                                                {
                                                                    orf_youtube_link="https://www.youtube.com/embed/"+$(this).val();
                                                                }

                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/change_youtube_link.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id:orf_id,
                                                                        orf_youtube_link: orf_youtube_link
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {

                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>">player.vimeo.com/video/</label>
                                                        <input type="text" class="form-control form-control-sm" title="Add only the last 11 characters" placeholder="Add only the last 11 characters" id="orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>" name="orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" value="<?php
                                                        if(!empty($result_files[$i]['orf_vimeo_link']))
                                                        {
                                                            //echo $result_files[$i]['orf_vimeo_link'];
                                                            $video_link=explode("/video/",$result_files[$i]['orf_vimeo_link']);
                                                            echo $video_link[1];
                                                        }
                                                        ?>">
                                                        <script type="text/javascript">
                                                            $('#orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                let orf_id=$(this).data('orf_id');
                                                                let orf_vimeo_link="";

                                                                if($(this).val()!="")
                                                                {
                                                                    orf_vimeo_link="https://player.vimeo.com/video/"+$(this).val();
                                                                }

                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/change_vimeo_link.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id:orf_id,
                                                                        orf_vimeo_link: orf_vimeo_link
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {

                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <!--<div class="col-md-2 border-right border-dark px-0 py-1">

                                            </div> -->

                                            <div class="col-md-5 border-dark px-3 py-1">
                                                <?php

                                                // if(strpos($result_files[$i]['prod_id'], "p11") !== false)
                                                // {
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>Building status</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <select id="bd_status_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                                                        name="bd_status_files_visibility"
                                                        class="form-control form-control-sm <?php echo ($result_files[$i]['bd_status'] == 8) ? "blue" : ""; ?>">
                                                    <option value="0" <?php echo ($result_files[$i]['bd_status'] == 0) ? "selected" : ""; ?>>
                                                        Not visible
                                                    </option>
                                                    <?php
                                                    if (($result_files[$i]['prod_id'] != "p156y") && ($result_files[$i]['prod_id'] != "p156z") &&
                                                        ($result_files[$i]['prod_id'] != "p166y") && ($result_files[$i]['prod_id'] != "p166z") &&
                                                        ($result_files[$i]['prod_id'] != "p176y") && ($result_files[$i]['prod_id'] != "p176z") &&
                                                        ($result_files[$i]['prod_id'] != "p186y") && ($result_files[$i]['prod_id'] != "p186z")) 
                                                    {
                                                        ?>
                                                        <option value="7" <?php echo ($result_files[$i]['bd_status'] == 7) ? "selected" : ""; ?>>
                                                            Visible for production
                                                        </option>
                                                        <option value="8" <?php echo ($result_files[$i]['bd_status'] == 8) ? "selected" : ""; ?>>
                                                            Visible to the customer
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                    </select>
                                                <script type="text/javascript">
                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/change_bd_status_file_visibility.php",
                                                            method: "get",
                                                            data: {
                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                bd_status: $(this).val()
                                                            },
                                                            dataType: "html",
                                                            success: function (data) {
                                                                if(($('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8)
                                                                {
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue-light");
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("blue");
                                                                }
                                                                else if(($('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 7)
                                                                {
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue");
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("blue-light");
                                                                }
                                                                else
                                                                {
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue");
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue-light");
                                                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <b>Sales status</b>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <select id="result_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                                                                name="result_files_visibility"
                                                                class="form-control form-control-sm <?php
                                                                echo ($result_files[$i]['orf_status'] == 1) ? "grey" : "";
                                                                echo ($result_files[$i]['orf_status'] == 8) ? "light-green" : "";
                                                                echo ($result_files[$i]['orf_status'] == 6) ? "yellow" : "";
                                                                ?>">
                                                            <option value="0" <?php echo ($result_files[$i]['orf_status'] == 0) ? "selected" : ""; ?>>
                                                                Not visible
                                                            </option>
                                                            <?php
                                                            if (($result_files[$i]['prod_id'] != "p156y") && ($result_files[$i]['prod_id'] != "p156z") &&
                                                                ($result_files[$i]['prod_id'] != "p166y") && ($result_files[$i]['prod_id'] != "p166z") &&
                                                                ($result_files[$i]['prod_id'] != "p176y") && ($result_files[$i]['prod_id'] != "p176z") &&
                                                                ($result_files[$i]['prod_id'] != "p186y") && ($result_files[$i]['prod_id'] != "p186z")) 
                                                            {
                                                                ?>
                                                                <option value="1" <?php echo ($result_files[$i]['orf_status'] == 1) ? "selected" : ""; ?>>
                                                                    Old
                                                                </option>
                                                                <option value="7" <?php echo ($result_files[$i]['orf_status'] == 7) ? "selected" : ""; ?>>
                                                                    Visible for production
                                                                </option>
                                                                <option value="8" <?php echo ($result_files[$i]['orf_status'] == 8) ? "selected" : ""; ?>>
                                                                    Visible to the customer
                                                                </option>
                                                                <?php
                                                            }

                                                            if(
                                                                (substr($result_files[$i]['prod_id'], -1) == 'y')||(substr($result_files[$i]['prod_id'], -1) == 'z')
                                                                )
                                                            {
                                                                ?>
                                                                <option value="7" <?php echo ($result_files[$i]['orf_status'] == 7) ? "selected" : ""; ?>>
                                                                    Visible for production
                                                                </option>
                                                                <option value="6" <?php echo ($result_files[$i]['orf_status'] == 6) ? "selected" : ""; ?>>
                                                                    Configurator-2D
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <script type="text/javascript">
                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/change_results_file_visibility.php",
                                                                    method: "get",
                                                                    data: {
                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                        orf_status: $(this).val()
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {
                                                                        if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8) {
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("light-green");
                                                                        } else if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 7) {
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("orange");
                                                                        }
                                                                        else if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 6) {
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("yellow");
                                                                        }
                                                                        else {
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                    </div>
                                                    <div class="col-md-1">
                                                        <input type="checkbox" id="result_file_verified<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" name="result_file_verified" class="form-check-input" style="width:100%;height:20px;" title="Verified by creator" value="1" <?php
                                                        echo ($result_files[$i]['result_file_verified']==1)?"checked":"";
                                                        ?>>
                                                        <script type="text/javascript">

                                                            $('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').click(function(){

                                                                let orf_id=$(this).data('orf_id');
                                                                let result_file_verified=0;

                                                                if($('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').is(":checked"))
                                                                {
                                                                    result_file_verified=1;
                                                                }

                                                                $.ajax({
                                                                url: "<?php echo $base_url;?>ajax/change_result_file_verified.php",
                                                                method: "post",
                                                                data: {
                                                                    orf_id:orf_id,
                                                                    result_file_verified: result_file_verified
                                                                },
                                                                dataType: "html",
                                                                success: function (data) {
                                                                    if($('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').is(":checked"))
                                                                    {
                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val(8);

                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("light-green");

                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/change_results_file_visibility.php",
                                                                            method: "get",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                orf_status: 8
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        });


                                                                    }
                                                                    else
                                                                    {
                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val(0);

                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");

                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/change_results_file_visibility.php",
                                                                            method: "get",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                orf_status: 0
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                            });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                                <?php
                                                if (($result_files[$i]['prod_id'] == "p1322") || ($result_files[$i]['prod_id'] == "1302"))
                                                {
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>Show in tour</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <select id="hover_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                                                            name="hover_files_visibility"
                                                            class="form-control form-control-sm <?php echo ($result_files[$i]['hover_status'] == 8) ? "red" : ""; ?>">
                                                            <option value="0" <?php echo ($result_files[$i]['hover_status'] == 0) ? "selected" : ""; ?>>
                                                                Not visible
                                                            </option>
                                                            <option value="8" <?php echo ($result_files[$i]['hover_status'] == 8) ? "selected" : ""; ?>>
                                                                Visible
                                                            </option>
                                                    </select>
                                                    <script type="text/javascript">
                                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                                                            $.ajax({
                                                                url: "<?php echo $base_url;?>ajax/change_hover_file_visibility.php",
                                                                method: "get",
                                                                data: {
                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                    hover_status: $(this).val()
                                                                },
                                                                dataType: "html",
                                                                success: function (data) {
                                                                    if (($('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8)
                                                                    {
                                                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("red");
                                                                    }
                                                                    else
                                                                    {
                                                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("red");
                                                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                                                    }
                                                                }
                                                            });
                                                        });
                                                    </script>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>Show in panorama</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <select id="show_in_panorama<?php echo $result_files[$i]['orf_id']; ?>"
                                                            name="show_in_panorama"
                                                            class="form-control form-control-sm <?php echo ($result_files[$i]['show_in_panorama_status'] == 8) ? "red" : ""; ?>">
                                                            <option value="0" <?php echo ($result_files[$i]['show_in_panorama_status'] == 0) ? "selected" : ""; ?>>
                                                                Not visible
                                                            </option>
                                                            <option value="8" <?php echo ($result_files[$i]['show_in_panorama_status'] == 8) ? "selected" : ""; ?>>
                                                                Visible
                                                            </option>
                                                    </select>
                                                    <script type="text/javascript">
                                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                                                            $.ajax({
                                                                url: "<?php echo $base_url;?>ajax/show_in_panorama_visibility.php",
                                                                method: "get",
                                                                data: {
                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                    show_in_panorama_status: $(this).val()
                                                                },
                                                                dataType: "html",
                                                                success: function (data) {
                                                                    if (($('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').val()) == 8)
                                                                    {
                                                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').addClass("red");
                                                                    }
                                                                    else
                                                                    {
                                                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').removeClass("red");
                                                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                                                    }
                                                                }
                                                            });
                                                        });
                                                    </script>

                                                    </div>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div> <!-- end row -->
                                            <?php
                                            if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) 
                                            {
                                                ?>
                                                <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                                                            class="img-responsive" style="width:900px;"
                                                            src="<?php echo $base_url;?>result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                            alt="<?php echo $result_files[$i]['orf_name']; ?>"></div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        $image_preview_counter++;
                                    }
                                } //end for
                            }

                            ?>
                        </div>
                        <?php

                        if(
                            (($prod_id!="p168s")||(substr($prod_id, -2)!="gs"))
                        )                    
                        {
                            if(substr($prod_id, -1) !== 'y')
                            {
                                ?>
                                <div class="col-md-12">
                                    <div class="row w-100 mx-0 d-flex justify-content-center mt-3">
                                        <div class="col-md-8">
                                            <form id="upload_result_files_form" name="upload_result_files_form"  method="post" enctype="multipart/form-data"></form>
                                            <input type="file" name="myfile[]" class="form-control form-control-sm" form="upload_result_files_form" multiple>
                                        </div>
                                        <div class="col-md-4">
                                            <button id="start_upload_btn" type="button" class="btn btn-sm btn-success">Start upload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="loading_spinner" class="d-none">
                                        <img src="<?php echo $base_url;?>img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
                                    </div>
                                    <div id="upload_result_files_message" class="text-center"></div>
                                </div>
                                <script type="text/javascript">
                                    $('#start_upload_btn').click(function(){

                                        $('#loading_spinner').removeClass('d-none');

                                        $('#upload_result_files_message').html("");
                                        let formData= new FormData($('#upload_result_files_form')[0]);

                                        $.ajax({

                                            url: "<?php echo $base_url;?>upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id']; ?>",

                                            type: 'POST',

                                            data: formData,

                                            cache: false,

                                            processData: false,

                                            contentType: false,

                                            enctype: 'multipart/form-data',

                                            dataType:"html",

                                            success:function(data) {

                                                console.log(data);

                                            }

                                        }).done(function(data){



                                            html = data;           

                                            $('#loading_spinner').addClass('d-none');

                                            $('#upload_result_files_message').html(html);
                                            $('#upload_result_files_message').fadeIn().delay('3000').fadeOut();
                                            setTimeout(function(){
                                                var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                                window.location.href = redirectToURL;
                                                window.location.reload(true);                                                
                                                },2000);

                                        });
                                    });
                                </script>
                                <?php
                                /*
                                ?>
                                <div class="col-md-12">

                                    <div class="row w-100 mx-0 d-flex justify-content-center mt-3">
                                        <div class="col-md-8">

                                            <div id="fileuploader_<?php echo $o_id . "_" . $osub_id . "_" . $prod_id; ?>"></div>
                                        </div>
                                        <div class="col-md-4" style="display: flex; align-items: center;">

                                            <div id="fileuploader_message"></div>
                                            <button id="start_upload_btn" type="button" class="btn btn-sm btn-success">Start upload</button>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function () {

                                                let file_upload_obj=$("#fileuploader_<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>").uploadFile({
                                                    url: "<?php echo $base_url;?>upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id']; ?>",
                                                    fileName: "myfile",
                                                    showAbort: true,
                                                    showStatusAfterSuccess: true,
                                                    showStatusAfterError: true,
                                                    statusBarWidth: 350,
                                                    dragdropWidth: 350,
                                                    autoSubmit:false,
                                                    uploadStr: "Upload result files",
                                                    extraHTML:function()
                                                    {
                                                            console.log($('.ajax-file-upload-filename').text());

                                                            var html = "<div><b>Test test<br>";
                                                            html += "<b>test test";
                                                            html += "</div>";
                                                            return html;
                                                    },
                                                    afterUploadAll: function (data) {
                                                        /*
                                                        setTimeout(function () {
                                                            
                                                            var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                                            window.location.href = redirectToURL;
                                                            window.location.reload(true);

                                                        }, 1000);*//*
                                                    }
                                                });



                                                $("#start_upload_btn").click(function()
                                                {
                                                    console.log($("input[name=myfile]"));
                                                    file_upload_obj.startUpload();
                                                    // setTimeout(function () {
                                                    //         window.location = "taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>"
                                                    // }, 3000);
                                                });

                                            });


                                        </script>
                                    </div>
                                    
                                </div>
                                <?php
                                    */
                            }
                        }


                    } //end 6m 6t
                    
                    if(substr($prod_id, -1) === 'y') //classification upload
                    {
                        ?>
                        <div class="col-md-12 border my-3 py-2">
                            <form name="new_upload_file" id="new_upload_file" method="post" enctype="multipart/form-data"></form>
                            <div id="new_uploaded_files">
                                <?php
                                for($f=0;$f<3;$f++)
                                {
                                ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="file" name="myfile[]" class="form-control form-control-sm" form="new_upload_file">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-warning" id="classify_btn<?php echo $f;?>" data-toggle="modal"
                                        data-target="#classifyModal<?php echo $f;?>">Classify</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="classifyModal<?php echo $f;?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="classifyModalLabel<?php echo $f; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="classifyModalLabel<?php echo $f; ?>">Choose clasification</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">                                                    
                                                    <?php
                                                    $all_classifications=$prod->get_all_picture_areas();
                                                    $classification_counter=0;
                                                    for($s=0;$s<count($all_classifications);$s++)
                                                    {
                                                        if(substr($all_classifications[$s]['pa_id'], -1)=="1")
                                                        {
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="pa_id[]" id="pa_id_<?php echo $f;?>_<?php echo $classification_counter;?>" value="<?php 
                                                                        echo $all_classifications[$s]['pa_id'];?>" data-pa_description="<?php echo $all_classifications[$s]['pa_description'];?>">
                                                                        <label class="form-check-label" for="pa_id_<?php echo $f;?>_<?php echo $classification_counter;?>">
                                                                            <?php echo $all_classifications[$s]['pa_id'];?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php echo $all_classifications[$s]['pa_description'];?>
                                                                </div>                                                    
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('#pa_id_<?php echo $f;?>_<?php echo $classification_counter;?>').click(function(){
                                                                    let pa_id=$(this).val();
                                                                    let pa_description=$(this).data('pa_description');
                                                                    let f=<?php echo $f;?>;

                                                                    $('#chosen_clasification_text<?php echo $f;?>').text(pa_description);
                                                                    $('#chosen_classification_id<?php echo $f;?>').val(pa_id);

                                                                    if(pa_id=="pa0-10")
                                                                    {
                                                                        $('#what_btn<?php echo $f;?>').addClass('d-none');
                                                                        $('#main_img_btn<?php echo $f;?>').addClass('d-none');
                                                                        $('#new_upload_btn').removeClass('btn-default');
                                                                        $('#new_upload_btn').addClass('btn-success');
                                                                        $("#new_upload_btn").prop("disabled", false);
                                                                    }
                                                                    else
                                                                    {
                                                                        $('#what_btn<?php echo $f;?>').removeClass('d-none');
                                                                        $('#main_img_btn<?php echo $f;?>').removeClass('d-none');

                                                                        let mc_id=<?php echo $order['mc_id']?>;

                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/get_u_clients_main_options_html.php",
                                                                            method: "get",
                                                                            data: {mc_id:mc_id,pa_id:pa_id,f:f},
                                                                            dataType:"html",
                                                                            success:function(data) {

                                                                                $('#what_option_is_it<?php echo $f;?>').html(data);
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            </script>
                                                            <?php
                                                            $classification_counter++;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                                </div>
                                                </div>
                                            </div>
                                        </div> <!-- end Modal -->
                                    </div>
                                    <div class="col-md-auto">
                                        <div id="chosen_clasification_text<?php echo $f;?>">
                                        </div>
                                        <input type="hidden" name="chosen_classification_id[]" id="chosen_classification_id<?php echo $f;?>" value="" form="new_upload_file">
                                    </div>
                                    <div class="col-md-auto">
                                        <button class="btn btn-sm btn-warning d-none" id="what_btn<?php echo $f;?>" data-toggle="modal"
                                        data-target="#whatModal<?php echo $f;?>">What shall be shown ?</button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="whatModal<?php echo $f;?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="whatModalLabel<?php echo $f; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="whatModalLabel<?php echo $f; ?>">Choose what shall be shown ?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">                                                    
                                                    <div id="what_option_is_it<?php echo $f;?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                                </div>
                                                </div>
                                            </div>
                                        </div> <!-- end Modal -->

                                    </div>
                                    <div class="col-md-2">
                                        <img id="chosen_shape_img<?php echo $f;?>" class="img-fluid" src="" alt="" style="width:60px;height:auto;">
                                        <input type="hidden" name="chosen_shape_id[]" id="chosen_shape_id<?php echo $f;?>" value="" form="new_upload_file">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-warning d-none" id="main_img_btn<?php echo $f;?>" data-toggle="modal"
                                        data-target="#main_imgModal<?php echo $f;?>">Main image</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="main_imgModal<?php echo $f; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="main_imgModalLabel<?php echo $f; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="main_imgModalLabel<?php echo $f; ?>">Choose main picture</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    $main_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                                    
                                                    for($p=0;$p<count($main_pictures);$p++)
                                                    {
                                                        ?>
                                                        <div class="row p-3">
                                                            <div class="col-md-6">
                                                                <img id="main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>" class="configurator_pictures <?php //if($pict_categ_name_array[0]==$main_pictures[$p]['orf_id']){echo "configurator_pictures_clicked";}?>" src="<?php echo $base_url."result_thumbnail_files/".$main_pictures[$p]['orf_thumbnail_path'];?>" data-orf_id="<?php echo $main_pictures[$p]['orf_id'];?>" alt="No picture">
                                                                <script type="text/javascript">
                                                                    

                                                                    $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').hover(function(){
                                                                        $(this).css('cursor','pointer');
                                                                        
                                                                    });

                                                                    $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').click(function(){
                                                                                                                                        

                                                                        let srcValue = $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').attr('src');
                                                                        $('#chosen_main_img<?php echo $f;?>').attr('src', srcValue);
                                                                        $('#chosen_main_img_id<?php echo $f;?>').val($(this).data('orf_id'));   
                                                                        $('#new_upload_btn').removeClass('btn-default');
                                                                        $('#new_upload_btn').addClass('btn-success');
                                                                        $("#new_upload_btn").prop("disabled", false);
                                                                    });

                                                                </script>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                                </div>
                                                </div>
                                            </div>
                                        </div><!-- end modal -->
                                    </div>
                                    <div class="col-md-2">
                                        <img id="chosen_main_img<?php echo $f;?>" class="img-fluid" src="" style="width:60px;height:auto;">
                                        <input type="hidden" name="chosen_main_img_id[]" id="chosen_main_img_id<?php echo $f;?>" value="" form="new_upload_file">
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <button class="btn btn-sm btn-primary">Add more files</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div id="loading_spinner" class="d-none">
                                        <img src="<?php echo $base_url;?>img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-sm btn-default" id="new_upload_btn" form="new_upload_file" type="button" disabled>Start Upload</button>
                                    <script type="text/javascript">
                                        $('#new_upload_btn').click(function(){
                                            $('#loading_spinner').removeClass('d-none');
                                            formData= new FormData($('#new_upload_file')[0]);

                                            $.ajax({
                                                url: "<?php echo $base_url;?>upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id;?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id'];?>",
                                                type: 'POST',
                                                data: formData,
                                                cache: false,
                                                dataType: 'text',
                                                processData: false, 
                                                contentType: false,
                                                enctype: 'multipart/form-data',
                                                dataType:"html",
                                                success:function(data) {
                                                    console.log(data);	
                                                    $('#loading_spinner').addClass('d-none');
                                                    setTimeout(function () {
                                                    
                                                        var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                                        window.location.href = redirectToURL;
                                                        window.location.reload(true);

                                                    }, 1000);
                                                }
                                            });

                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                        ?>

                    <div class="row"> <!-- no result file -->
                        <div class="col-md-12">
                            <div class="form-check" style="display: flex; flex-direction: column">
                                <div style="width: fit-content;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;">
                                <input type="checkbox" id="no_result_file" class="form-control-sm form-control" value="1" style="width: 2vw;" <?php
                                $found_no_result_file=0;

                                for($i=0;$i<count($result_files);$i++)
                                {
                                    if(($found_no_result_file==0)&&($result_files[$i]['no_result_file']==1))
                                    {
                                        echo "checked";
                                        $found_no_result_file++;
                                    }
                                }
                                ?>>
                                <label class="form-check-label" for="no_result_file" style="width: fit-content;">No result file shall be uploaded</label>
                                <script type="text/javascript">
                                    $('#no_result_file').click(function(){

                                        let o_id=<?php echo $o_id;?>;
                                        let osub_id="<?php echo $osub_id; ?>";
                                        let prod_id="<?php echo $prod_id;?>";
                                        let uca_id=<?php echo $_COOKIE['client_id'];?>;

                                        if($(this).is(':checked'))
                                        {
                                            $.ajax({
                                                    url: "<?php echo $base_url;?>ajax/create_no_result_file.php",
                                                    method: "post",
                                                    data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                                                    dataType:"html",
                                                    success:function(data) {

                                                    }
                                                });


                                        }
                                        else
                                        {
                                            $.ajax({
                                                    url: "<?php echo $base_url;?>ajax/delete_no_result_file.php",
                                                    method: "post",
                                                    data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id},
                                                    dataType:"html",
                                                    success:function(data) {

                                                    }
                                                });
                                        }

                                    });
                                </script>
                                    </div>
                            </div>
                        </div>
                    </div>

                        <div class="row w-100 mx-0 dark-gray"> <!-- message to coordinator start -->
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