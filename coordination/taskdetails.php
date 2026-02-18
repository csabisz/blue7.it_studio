<?php
//session_set_cookie_params(14400,"/");
session_start();

include('../functions.php');
include('../../../../domenia7.com/public_html/domenia_db2.php');
include('../notifications.php');
include('../../../../blue7.it/public_html/domenia/domenia.php');
include('./ai_config/includes/config_functions.php');

//$domenia=new Domenia;
$domenia2 = new Domenia2;
$prod = new Production;
$notification = new Notifications;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

$picture_website = "https://domenia.blue7.it/";

$page_title = "Task Details";

include('../header2.php');
include('../menu.php');

?>
    <style>
        img.broken_image_main, img.broken_door_shape_image {
            position: relative;
            width: 100px !important;
        }

        img.broken_image_main::before, img.broken_door_shape_image::before {
            content: 'Choose main picture';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #E1E6EA;
        }

        img.broken_image_main[alt=""]::before {
            content: 'Choose main picture';
        }

        img.broken_image_main[alt="Exterior"]::before {
            content: 'Exterior';
        }

        img.broken_image_main[alt="Interior"]::before {
            content: 'Interior';
        }

        img.broken_image_main[alt="Original"]::before {
            content: 'Original';
        }

        /* Other styles */

        img.broken_door_shape_image[alt=""]::before {
            content: 'Choose symbol';
        }

        img.broken_door_shape_image[alt="Exterior"]::before {
            content: 'Exterior';
        }

        img.broken_door_shape_image[alt="Interior"]::before {
            content: 'Interior';
        }

        img.broken_door_shape_image[alt="Original"]::before {
            content: 'Original';
        }
    </style>

    <section class="top_section">
        <article>
            <?php
            if (isset($_COOKIE['client_id']) && ($_COOKIE['start'] < $_COOKIE['expire'])) {

                if (isset($_GET['option'])) {
                    $option = $prod->xss_fix($_GET['option']);
                } else {
                    $option = "";
                }

            if (isset($_POST['send_message_btn'])) {
                $o_id = $prod->xss_fix($_POST['o_id']);
                $osub_id = $prod->xss_fix($_POST['osub_id']);
                $prod_id = $prod->xss_fix($_POST['prod_id']);
                $message = $prod->xss_fix($_POST['message']);
                $user_id = $prod->xss_fix($_POST['user_id']);

                $prod->insert_message($o_id, $osub_id, $prod_id, $user_id, $message);
                $_POST = [];
                ?>
            <meta http-equiv="refresh"
                  content="0; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                <?php
            }

                if (isset($_POST['remarks_internal_btn'])) {
                    $client_ID = $prod->xss_fix($_POST['client_ID']);
                    $remarks_internal = $prod->xss_fix($_POST['remarks_internal']);

                    $prod->update_client_remarks_internal($client_ID, $remarks_internal);
                }

                if (isset($_POST['main_client_remarks_internal_btn'])) {
                    $mc_id = $prod->xss_fix($_POST['mc_id']);
                    $main_client_remarks_internal = $prod->xss_fix($_POST['main_client_remarks_internal']);

                    $prod->update_main_client_remarks_internal($mc_id, $main_client_remarks_internal);
                }

            if (isset($_POST['cnf_delete_btn'])) {
                $cnf_id = $_POST['cnf_id'];

                $prod->delete_correction_needed_file($cnf_id);
                ?>
                <div class="alert alert-success text-center">
                    Image deleted !
                </div><br>
                <?php
            }

                /* if (isset($_POST['res_delete_btn'])) {
                    $orf_id = $prod->xss_fix($_POST['orf_id']);

                    $prod->delete_creator_file($orf_id);
                    ?>
                    <div class="alert alert-success text-center">
                        Image deleted !
                    </div><br>
                    <?php
                } */

            if ((isset($option)) && ($option == "change_result_files_visibility")) {
                $orf_id = $prod->xss_fix($_GET['orf_id']);
                $orf_status = $prod->xss_fix($_GET['orf_status']);
                $o_id = $prod->xss_fix($_GET['o_id']);
                $osub_id = $prod->xss_fix($_GET['osub_id']);
                $prod_id = $prod->xss_fix($_GET['prod_id']);

                $prod->update_o_results_status($orf_id, $orf_status);

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

                if (($prod_id == "p1501") && ($p_status == 8)) {
                    $prod->update_the_other_o_prods_status($o_id, $osub_id, $prod_id);
                    $prod->update_order_status($o_id, $o_status = 4);
                }

                if (($prod_id == "p1521") && ($p_status == 8)) {
                    $prod->update_the_other_o_prods_status($o_id, $osub_id, $prod_id);
                    $prod->update_order_status($o_id, $o_status = 4);
                }

                if (($prod_id == "p1541") && ($p_status == 8)) {
                    $prod->update_the_other_o_prods_status($o_id, $osub_id, $prod_id);
                    $prod->update_order_status($o_id, $o_status = 4);
                }

                $check_if_results = $prod->show_results($o_id, $osub_id, $prod_id);

            if ((count($check_if_results) == 0) && ($p_status != 8)) {
                $prod->update_o_prods_status($o_id, $osub_id, $prod_id, $p_status);
                $prod->update_order_status($o_id, $o_status = 4);
                ?>
            <meta http-equiv="refresh"
                  content="0; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                <?php
            } elseif ((count($check_if_results) > 0) && ($p_status == 8)) {
                $prod->update_o_prods_status($o_id, $osub_id, $prod_id, $p_status);
                //$prod->auto_update_o_results_status($o_id,$osub_id,$prod_id,$p_status);
                ?>
            <meta http-equiv="refresh"
                  content="0; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                <?php
            } elseif ((count($check_if_results) > 0) && ($p_status != 8)) {
                $prod->update_o_prods_status($o_id, $osub_id, $prod_id, $p_status);
                ?>
            <meta http-equiv="refresh"
                  content="0; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                <?php
            } elseif ((count($check_if_results) == 0) && ($p_status == 8)) {
            if (($prod_id == "p1562") || ($prod_id == "p1581") || ($prod_id == "p1762") || ($prod_id == "p1781")) {
                $prod->update_o_prods_status($o_id, $osub_id, $prod_id, $p_status);
                //$prod->auto_update_o_results_status($o_id,$osub_id,$prod_id,$p_status);
                ?>
            <meta http-equiv="refresh"
                  content="0; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                <?php
            } else {
                ?>
                <div class="center_message">
                    <div class="error">
                        There are no result files.
                    </div>
                </div>
                <?php
            }
            } else //might not need this else ?
            {
                ?>
                <div class="center_message">
                    <div class="error">
                        There are no result files.
                    </div>
                </div>
                <?php
            }

                if ($p_status == 1) {
                    $prod->update_order_status($o_id, $o_status = 1);
                } elseif ($p_status == 2) {
                    $prod->update_order_status($o_id, $o_status = 2);
                } elseif ($p_status == 3) {
                    $prod->update_order_status($o_id, $o_status = 3);
                } elseif ($p_status == 4) {
                    $prod->update_order_status($o_id, $o_status = 4);
                } elseif ($p_status == 5) {
                    $prod->update_order_status($o_id, $o_status = 5);
                } elseif ($p_status == 6) {
                    $prod->update_order_status($o_id, $o_status = 6);
                } elseif ($p_status == 7) {
                    $prod->update_order_status($o_id, $o_status = 7);
                }

                $num_products = count($prod->get_prods($o_id));
                $num_finished_products = count($prod->get_finished_number_prods($o_id, 8));

                if ($num_products == $num_finished_products) {
                    $prod->update_order_status($o_id, 8);

                    //send done message
                    $order = $prod->get_order($o_id);

                    if ($order['notifications'] == 1) {
                        $notification->send_product_done_message($o_id);
                    }
                }

                //$logged_in_user_id=$prod->get_creator($_COOKIE['email']);
                $p_status_name = $prod->get_o_status_name($p_status);

                $prod->create_activity($_COOKIE['client_id'], "changed status to " . $p_status_name['ost_name'], $o_id, $osub_id, $prod_id);
            }

            if ((isset($option)) && ($option == "assign")) {
                $o_id = $prod->xss_fix($_GET['o_id']);
                $osub_id = $prod->xss_fix($_GET['osub_id']);
                $prod_id = $prod->xss_fix($_GET['prod_id']);
                $creatorid = $prod->xss_fix($_GET['creatorid']);

                $order = $prod->get_order($o_id);
                $licenceid = $order['lic_ID'];



                if (($prod_id == "p1501") || ($prod_id == "p1701")) {
                    $prod->assign_to_creator($o_id, $osub_id, $prod_id, $creatorid, 1, 1, 4);
                } else {
                    $check_p_status = $prod->check_assigned_status($o_id, $osub_id, $prod_id);

                    if ($check_p_status['p_status'] == 3) {
                        $prod->assign_to_creator($o_id, $osub_id, $prod_id, $creatorid, 1, 1, 4);
                    } else {
                        $prod->assign_to_creator($o_id, $osub_id, $prod_id, $creatorid, 1, 1, 2);
                    }
                }
                //$logged_in_user_id=$prod->get_creator($_COOKIE['email']);
                $creator_name = $prod->get_client($creatorid);
                $prod->create_activity($_COOKIE['client_id'], "assigned to " . $creator_name['l_first_name'] . " " . $creator_name['l_last_name'], $o_id, $osub_id, $prod_id);


                $prod->update_order_status($o_id, $o_status = 2);
                ?>
            <meta http-equiv="refresh"
                  content="0; url=taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                <?php
                /*}
            }*/
            }

                //start taskdetails

                $o_id = $prod->xss_fix($_GET['o_id']);
                $osub_id = $prod->xss_fix($_GET['osub_id']);
                $prod_id = $prod->xss_fix($_GET['prod_id']);

                if (isset($_GET['room_id'])) {
                    $room_id = $prod->xss_fix($_GET['room_id']);
                } else {
                    $room_id = 0;
                }

                if (isset($_GET['orf_id'])) {
                    $orf_id = $prod->xss_fix($_GET['orf_id']);
                } else {
                    $orf_id = 0;
                }

                $order = $prod->get_order($o_id);
                $allstatus = $prod->showallstatus();
                $product = $prod->get_product($prod_id);

                $producer = $prod->check_assigned_status($o_id, $osub_id, $prod_id);
                $producer_name = $prod->get_client($producer['uca_id']);

                $o_desc_ex_b5 = $prod->get_o_desc_ex_b5($o_id);

                $o_desc_allproducts = $prod->get_o_infos_allproducts($o_id);

                $order_client = $prod->get_client($order['u_client_ID']);
                $main_client = $prod->get_main_client($order['mc_id']);


                ?>
                <div class="container text-center mb-5 pagecontent bg-white px-0" style="font-size:14px;">
                    <br>
                    <div class="row w-100 mx-0 d-flex pt-2 justify-content-center">
                        <a href="index.php" class="btn btn-success btn-sm mx-2"><= Go back to Coordination </a> |
                        <a href="orderdetails4.php?o_id=<?php echo $o_id; ?>" class="btn btn-success btn-sm mx-2"><= Go
                            back to Coordination for this order</a>
                        <h2><?php echo $order['order_name']; ?></h2>
                        <h2 class="w-100 pb-2">Details on
                            Task <?php echo $o_id . "." . $osub_id . "." . $prod_id; ?> - <?php
                            $subid_data['o_id'] = $o_id;
                            $subid_data['o_sub_id'] = $osub_id;

                            $subo_name = $prod->check_existing_subid(json_encode($subid_data));

                            echo $subo_name['subo_name'];
                            ?></h2>
                    </div>
                    <div id="task<?php echo $o_id . "_" . $osub_id . "_" . $prod_id; ?>"
                         class="row mx-0 w-100 py-3 <?php

                         for ($i = 0; $i < count($allstatus); $i++) {
                             if ($allstatus[$i]['ost_id'] == $producer['p_status']) {
                                 echo $allstatus[$i]['ost_color'];
                             }
                         }
                         ?>">
                        <div class="col-md-3 pt-1">
                            <?php echo $o_id . "." . $osub_id . "." . $prod_id . "<br>";
                            $customer_files = $prod->get_customer_files($o_id);

                            for ($j = 0; $j < count($customer_files); $j++) {

                                if ($customer_files[$j]['of_position'] == substr($osub_id, 1)) {
                                    echo $customer_files[$j]['of_level'] . " " . $customer_files[$j]['of_name'];
                                }
                            }
                            echo " " . $product['prod_name']; ?>
                        </div>
                        <div class="col-md-4 pt-1">
                            <div class="form-inline"><p class="mb-0 d-inline mr-2">Assigned to : </p>

                                <select name="creators" id="creators_0" class="form-control form-control-sm"
                                        style="max-width:225px;">
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
                                    <?php

                                    $all_creators = $prod->show_creators($order['u_prod_id']);
                                    $all_other_creators = $prod->show_creators_other_companies($order['u_prod_id']);


                                    for ($i = 0; $i < count($all_creators); $i++) {
                                        $creator_qualification = $prod->get_client_qualifications($all_creators[$i]['client_ID']);
                                        $creator_right = $prod->get_client_rights($all_creators[$i]['client_ID']);

                                        if ($creator_right['u_status'] == "active") {
                                            if ($prod_id == "p1103") {
                                                if ($creator_qualification['b1_floorplans'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_floorplans'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1104") {
                                                if ($creator_qualification['b1_pictures'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_pictures'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }
                                            if ($prod_id == "p1106") {
                                                if ($creator_qualification['b1_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }
                                            if ($prod_id == "p1108") {
                                                if ($creator_qualification['b1_videos'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_videos'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1301") {
                                                if (($creator_qualification['b3_walls'] > 0) || ($creator_qualification['b3_windows_doors'] > 0)) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b3_walls'] . ")(" . $creator_qualification['b3_windows_doors'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1321") {
                                                if ($creator_qualification['b3_furniture'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b3_furniture'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1302") || ($prod_id == "p1322")) {

                                                ?>
                                                <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                        class="offline"
                                                        value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                    if (!empty($all_creators[$i]['c_last_name'])) {
                                                        echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (1)";
                                                    } else {
                                                        echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (1)";
                                                    } ?><?php

                                                    ?></option>
                                                <?php

                                            }

                                            if ($prod_id == "p1501") {
                                                if (($creator_qualification['b5_walls'] > 0) || ($creator_qualification['b5_windows_doors'] > 0)) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1521") || ($prod_id == "p1541")) {
                                                if ($creator_qualification['b5_furniture'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_furniture'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1501) && (substr($prod_id, 1) < 1506)) || ((substr($prod_id, 1) > 1521) && (substr($prod_id, 1) < 1526)) || ((substr($prod_id, 1) > 1541) && (substr($prod_id, 1) < 1546))) {
                                                if ($creator_qualification['b5_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_render_stills'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1506") || ($prod_id == "p1526") || ($prod_id == "p1546")) {
                                                if ($creator_qualification['b5_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_render_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1507") || ($prod_id == "p1527") || ($prod_id == "p1547")) {
                                                if ($creator_qualification['b5_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_render_slideshow'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (($prod_id == "p1508") || ($prod_id == "p1528") || ($prod_id == "p1548")) {
                                                if ($creator_qualification['b5_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1163") {
                                                if ($creator_qualification['b1_pictures'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_pictures'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }
                                            if ($prod_id == "p1166") {
                                                if ($creator_qualification['b1_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }
                                            if ($prod_id == "p1168") {
                                                if ($creator_qualification['b1_videos'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_videos'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (
                                                    ($prod_id == "p116b") || (substr($prod_id, -2) == "gb")
                                            ) {
                                                if ($creator_qualification['b1_base_picture'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_base_picture'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (
                                                    ($prod_id == "p116m") || (substr($prod_id, -2) == "gm")
                                            ) {
                                                if ($creator_qualification['b1_masks'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_masks'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p116t") {
                                                if ($creator_qualification['b1_targets'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_targets'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (
                                                    (substr($prod_id, -2) == "8s") || (substr($prod_id, -2) == "gs")
                                            ) {
                                                if ($creator_qualification['b1_suntour_model'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_suntour_model'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ((substr($prod_id, -3) == "10v") || (substr($prod_id, -3) == "16v")) {
                                                if ($creator_qualification['b1_vr'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b1_vr'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1561") {
                                                if (($creator_qualification['b5_walls'] > 0) || ($creator_qualification['b5_windows_doors'] > 0)) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p156z") {
                                                if ($creator_qualification['b5_2d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_2d_configurator'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p156y") {
                                                if ($creator_qualification['b5_2d_konfig_renders'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_2d_konfig_renders'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p156x") {
                                                if ($creator_qualification['b5_3d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_3d_configurator'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ((substr($prod_id, 1) > 1561) && (substr($prod_id, 1) < 1565) || ((substr($prod_id, 1) > 1581) && (substr($prod_id, 1) < 1590))) {
                                                if ($creator_qualification['b5_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }

                                                        echo " (" . $creator_qualification['b5_render_stills'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1566") {
                                                if ($creator_qualification['b5_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_render_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1567") {
                                                if ($creator_qualification['b5_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_render_slideshow'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1568") {
                                                if ($creator_qualification['b5_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1581") {
                                                if ($creator_qualification['b5_environment'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b5_environment'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1600") {
                                                if ($creator_qualification['b6_walls'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_walls'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_walls'] . ")";
                                                        } ?> </option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1601") {
                                                if (($creator_qualification['b6_walls'] > 0) || ($creator_qualification['b6_windows_doors'] > 0)) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } ?> </option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1621") || ($prod_id == "p1641")) {
                                                if ($creator_qualification['b6_furniture'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_furniture'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_furniture'] . ")";
                                                        } ?> </option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1601) && (substr($prod_id, 1) < 1606)) || ((substr($prod_id, 1) > 1621) && (substr($prod_id, 1) < 1626)) || ((substr($prod_id, 1) > 1641) && (substr($prod_id, 1) < 1646))) {
                                                if ($creator_qualification['b6_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_render_stills'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_render_stills'] . ")";
                                                        } ?> </option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1606") || ($prod_id == "p1626") || ($prod_id == "p1646")) {
                                                if ($creator_qualification['b6_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_render_360'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_render_360'] . ")";
                                                        } ?> </option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1607") || ($prod_id == "p1627") || ($prod_id == "p1647")) {
                                                if ($creator_qualification['b6_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (($prod_id == "p1608") || ($prod_id == "p1628") || ($prod_id == "p1648")) {
                                                if ($creator_qualification['b6_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_render_movie'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1661") {
                                                if (($creator_qualification['b6_walls'] > 0) || ($creator_qualification['b6_windows_doors'] > 0)) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p166z") {
                                                if ($creator_qualification['b6_2d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_2d_configurator'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_2d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p166y") {
                                                if ($creator_qualification['b6_2d_konfig_renders'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_2d_konfig_renders'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_2d_konfig_renders'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p166x") {
                                                if ($creator_qualification['b6_3d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_3d_configurator'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_3d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1661) && (substr($prod_id, 1) < 1665)) || ((substr($prod_id, 1) > 1681) && (substr($prod_id, 1) < 1690))) {
                                                if ($creator_qualification['b6_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'] . " (" . $creator_qualification['b6_render_stills'] . ")";
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'] . " (" . $creator_qualification['b6_render_stills'] . ")";
                                                        }
                                                        ?> </option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1666") {
                                                if ($creator_qualification['b6_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b6_render_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1667") {
                                                if ($creator_qualification['b6_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b6_render_slideshow'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1668") {
                                                if ($creator_qualification['b6_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b6_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1681") {
                                                if ($creator_qualification['b6_environment'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b6_environment'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1700") {
                                                if ($creator_qualification['b7_walls'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_walls'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1701") {
                                                if ($creator_qualification['b7_windows_doors'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_windows_doors'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1721") || ($prod_id == "p1741")) {
                                                if ($creator_qualification['b7_furniture'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_furniture'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1701) && (substr($prod_id, 1) < 1706)) || ((substr($prod_id, 1) > 1721) && (substr($prod_id, 1) < 1726)) || ((substr($prod_id, 1) > 1741) && (substr($prod_id, 1) < 1746))) {
                                                if ($creator_qualification['b7_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_stills'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1706") || ($prod_id == "p1726") || ($prod_id == "p1746")) {
                                                if ($creator_qualification['b7_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (($prod_id == "p1707") || ($prod_id == "p1727") || ($prod_id == "p1747")) {
                                                if ($creator_qualification['b7_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_slideshow'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1708") || ($prod_id == "p1728") || ($prod_id == "p1748")) {
                                                if ($creator_qualification['b7_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1760") {
                                                if ($creator_qualification['b7_walls'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_walls'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1761") {
                                                if ($creator_qualification['b7_windows_doors'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_windows_doors'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p176z") {
                                                if ($creator_qualification['b7_2d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_2d_configurator'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p176y") {
                                                if ($creator_qualification['b7_2d_konfig_renders'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_2d_konfig_renders'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p176x") {
                                                if ($creator_qualification['b7_3d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_3d_configurator'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1761) && (substr($prod_id, 1) < 1765)) || ((substr($prod_id, 1) > 1781) && (substr($prod_id, 1) < 1790))) {
                                                if ($creator_qualification['b7_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_stills'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1766") {
                                                if ($creator_qualification['b7_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1767") {
                                                if ($creator_qualification['b7_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_slideshow'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1768") {
                                                if ($creator_qualification['b7_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1781") {
                                                if ($creator_qualification['b7_environment'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b7_environment'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1800") {
                                                if ($creator_qualification['b8_walls'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_walls'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1801") {
                                                if ($creator_qualification['b8_windows_doors'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_windows_doors'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1821") || ($prod_id == "p1841")) {
                                                if ($creator_qualification['b8_furniture'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_furniture'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1801) && (substr($prod_id, 1) < 1806)) || ((substr($prod_id, 1) > 1821) && (substr($prod_id, 1) < 1826)) || ((substr($prod_id, 1) > 1841) && (substr($prod_id, 1) < 1846))) {
                                                if ($creator_qualification['b8_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_stills'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1806") || ($prod_id == "p1826") || ($prod_id == "p1846")) {
                                                if ($creator_qualification['b8_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (($prod_id == "p1807") || ($prod_id == "p1827") || ($prod_id == "p1847")) {
                                                if ($creator_qualification['b8_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_slideshow'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1808") || ($prod_id == "p1828") || ($prod_id == "p1848")) {
                                                if ($creator_qualification['b8_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1860") {
                                                if ($creator_qualification['b8_walls'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_walls'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1861") {
                                                if ($creator_qualification['b8_windows_doors'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_windows_doors'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p186z") {
                                                if ($creator_qualification['b8_2d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_2d_configurator'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p186y") {
                                                if ($creator_qualification['b8_2d_konfig_renders'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_2d_konfig_renders'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p186x") {
                                                if ($creator_qualification['b8_3d_configurator'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_3d_configurator'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1861) && (substr($prod_id, 1) < 1865)) || ((substr($prod_id, 1) > 1881) && (substr($prod_id, 1) < 1890))) {
                                                if ($creator_qualification['b8_render_stills'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_stills'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1866") {
                                                if ($creator_qualification['b8_render_360'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_360'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1867") {
                                                if ($creator_qualification['b8_render_slideshow'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_slideshow'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1868") {
                                                if ($creator_qualification['b8_render_movie'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1881") {
                                                if ($creator_qualification['b8_environment'] > 0) {
                                                    ?>
                                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_creators[$i]['c_last_name'])) {
                                                            echo $all_creators[$i]['c_first_name'] . " " . $all_creators[$i]['c_last_name'];
                                                        } else {
                                                            echo $all_creators[$i]['l_first_name'] . " " . $all_creators[$i]['l_last_name'];
                                                        }
                                                        echo " (" . $creator_qualification['b8_environment'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                        }
                                    }

                                    $other_resources_counter = 0;
                                    for ($i = 0; $i < count($all_other_creators); $i++) {
                                        $creator_qualification = $prod->get_client_qualifications($all_other_creators[$i]['client_ID']);
                                        $creator_right = $prod->get_client_rights($all_other_creators[$i]['client_ID']);

                                        if ($creator_right['u_status'] == "active") {
                                            if ($prod_id == "p1103") {
                                                if ($creator_qualification['b1_floorplans'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_floorplans'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_floorplans'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1104") {
                                                if ($creator_qualification['b1_pictures'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_pictures'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_pictures'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }
                                            if ($prod_id == "p1106") {
                                                if ($creator_qualification['b1_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1108") {
                                                if ($creator_qualification['b1_videos'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_videos'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_videos'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1301") {
                                                if (($creator_qualification['b3_walls'] > 0) || ($creator_qualification['b3_windows_doors'] > 0)) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b3_walls'] . ")(" . $creator_qualification['b3_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b3_walls'] . ")(" . $creator_qualification['b3_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1321") {
                                                if ($creator_qualification['b3_furniture'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b3_furniture'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b3_furniture'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1302") || ($prod_id == "p1322")) {
                                                if ($other_resources_counter == 0) {
                                                    ?>
                                                    <option style="color:red;">Resources from other companies</option>
                                                    <?php
                                                    $other_resources_counter++;
                                                }
                                                ?>
                                                <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                        class="offline"
                                                        value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                    if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                        echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (1)";
                                                    } else {
                                                        echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (1)";
                                                    } ?><?php

                                                    ?></option>
                                                <?php

                                            }

                                            if ($prod_id == "p1501") {
                                                if (($creator_qualification['b5_walls'] > 0) || ($creator_qualification['b5_windows_doors'] > 0)) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1521") || ($prod_id == "p1541")) {
                                                if ($creator_qualification['b5_furniture'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_furniture'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_furniture'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1501) && (substr($prod_id, 1) < 1506)) || ((substr($prod_id, 1) > 1521) && (substr($prod_id, 1) < 1526)) || ((substr($prod_id, 1) > 1541) && (substr($prod_id, 1) < 1546))) {
                                                if ($creator_qualification['b5_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_stills'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_stills'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1506") || ($prod_id == "p1526") || ($prod_id == "p1546")) {
                                                if ($creator_qualification['b5_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1507") || ($prod_id == "p1527") || ($prod_id == "p1547")) {
                                                if ($creator_qualification['b5_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (($prod_id == "p1508") || ($prod_id == "p1528") || ($prod_id == "p1548")) {
                                                if ($creator_qualification['b5_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_movie'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1163") {
                                                if ($creator_qualification['b1_pictures'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_pictures'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_pictures'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1166") {
                                                if ($creator_qualification['b1_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1168") {
                                                if ($creator_qualification['b1_videos'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_videos'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_videos'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (
                                                    ($prod_id == "p116b") || (substr($prod_id, -2) == "gb")
                                            ) {
                                                if ($creator_qualification['b1_base_picture'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_base_picture'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_base_picture'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (
                                                    ($prod_id == "p116m") || (substr($prod_id, -2) == "gm")
                                            ) {
                                                if ($creator_qualification['b1_masks'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_masks'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_masks'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p116t") {
                                                if ($creator_qualification['b1_targets'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_targets'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_targets'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (
                                                    (substr($prod_id, -2) == "8s") || (substr($prod_id, -2) == "gs")
                                            ) {
                                                if ($creator_qualification['b1_suntour_model'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_suntour_model'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_suntour_model'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ((substr($prod_id, -3) == "10v") || (substr($prod_id, -3) == "16v")) {
                                                if ($creator_qualification['b1_vr'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_vr'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b1_vr'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1561") {
                                                if (($creator_qualification['b5_walls'] > 0) || ($creator_qualification['b5_windows_doors'] > 0)) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_walls'] . ")(" . $creator_qualification['b5_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p156z") {
                                                if ($creator_qualification['b5_2d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_2d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_2d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p156y") {
                                                if ($creator_qualification['b5_2d_konfig_renders'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_2d_konfig_renders'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_2d_konfig_renders'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p156x") {
                                                if ($creator_qualification['b5_3d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_3d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_3d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (((substr($prod_id, 1) > 1561) && (substr($prod_id, 1) < 1565)) || ((substr($prod_id, 1) > 1581) && (substr($prod_id, 1) < 1590))) {
                                                if ($creator_qualification['b5_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_stills'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_stills'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1566") {
                                                if ($creator_qualification['b5_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1567") {
                                                if ($creator_qualification['b5_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1568") {
                                                if ($creator_qualification['b5_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_movie'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1581") {
                                                if ($creator_qualification['b5_environment'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_environment'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b5_environment'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1601") {
                                                if (($creator_qualification['b6_walls'] > 0) || ($creator_qualification['b6_windows_doors'] > 0)) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1621") || ($prod_id == "p1641")) {
                                                if ($creator_qualification['b6_furniture'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_furniture'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_furniture'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1601) && (substr($prod_id, 1) < 1606)) || ((substr($prod_id, 1) > 1621) && (substr($prod_id, 1) < 1626)) || ((substr($prod_id, 1) > 1641) && (substr($prod_id, 1) < 1646))) {
                                                if ($creator_qualification['b6_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_stills'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_stills'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1606") || ($prod_id == "p1626") || ($prod_id == "p1646")) {
                                                if ($creator_qualification['b6_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1607") || ($prod_id == "p1627") || ($prod_id == "p1647")) {
                                                if ($creator_qualification['b6_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (($prod_id == "p1608") || ($prod_id == "p1628") || ($prod_id == "p1648")) {
                                                if ($creator_qualification['b6_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_movie'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1660") {
                                                if ($creator_qualification['b6_walls'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_walls'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_walls'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1661") {
                                                if (($creator_qualification['b6_walls'] > 0) || ($creator_qualification['b6_windows_doors'] > 0)) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_walls'] . ")(" . $creator_qualification['b6_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p166z") {
                                                if ($creator_qualification['b6_2d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_2d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_2d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p166y") {
                                                if ($creator_qualification['b6_2d_konfig_renders'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_2d_konfig_renders'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_2d_konfig_renders'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p166x") {
                                                if ($creator_qualification['b6_3d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_3d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_3d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (((substr($prod_id, 1) > 1661) && (substr($prod_id, 1) < 1665)) || ((substr($prod_id, 1) > 1681) && (substr($prod_id, 1) < 1690))) {
                                                if ($creator_qualification['b6_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_stills'] . ")"; ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1666") {
                                                if ($creator_qualification['b6_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1667") {
                                                if ($creator_qualification['b6_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1668") {
                                                if ($creator_qualification['b6_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_movie'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1681") {
                                                if ($creator_qualification['b6_environment'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_environment'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b6_environment'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1700") {
                                                if ($creator_qualification['b7_walls'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_walls'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_walls'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1701") {
                                                if ($creator_qualification['b7_windows_doors'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1721") || ($prod_id == "p1741")) {
                                                if ($creator_qualification['b7_furniture'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_furniture'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_furniture'] . ")";
                                                        } ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1701) && (substr($prod_id, 1) < 1706)) || ((substr($prod_id, 1) > 1721) && (substr($prod_id, 1) < 1726)) || ((substr($prod_id, 1) > 1741) && (substr($prod_id, 1) < 1746))) {
                                                if ($creator_qualification['b7_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_stills'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_stills'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1706") || ($prod_id == "p1726") || ($prod_id == "p1746")) {
                                                if ($creator_qualification['b7_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1707") || ($prod_id == "p1727") || ($prod_id == "p1747")) {
                                                if ($creator_qualification['b7_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1708") || ($prod_id == "p1728") || ($prod_id == "p1748")) {
                                                if ($creator_qualification['b7_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_movie'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1760") {
                                                if ($creator_qualification['b7_walls'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_walls'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_walls'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1761") {
                                                if ($creator_qualification['b7_windows_doors'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p176z") {
                                                if ($creator_qualification['b7_2d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_2d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_2d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p176y") {
                                                if ($creator_qualification['b7_2d_konfig_renders'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_2d_konfig_renders'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_2d_konfig_renders'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p176x") {
                                                if ($creator_qualification['b7_3d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_3d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_3d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1761) && (substr($prod_id, 1) < 1765)) || ((substr($prod_id, 1) > 1781) && (substr($prod_id, 1) < 1790))) {
                                                if ($creator_qualification['b7_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_stills'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_stills'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1766") {
                                                if ($creator_qualification['b7_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1767") {
                                                if ($creator_qualification['b7_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1768") {
                                                if ($creator_qualification['b7_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_movie'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1781") {
                                                if ($creator_qualification['b7_environment'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_environment'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b7_environment'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1800") {
                                                if ($creator_qualification['b8_walls'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_walls'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_walls'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1801") {
                                                if ($creator_qualification['b8_windows_doors'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1821") || ($prod_id == "p1841")) {
                                                if ($creator_qualification['b8_furniture'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_furniture'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_furniture'] . ")";
                                                        } ?></option>
                                                    <?php
                                                }
                                            }


                                            if (((substr($prod_id, 1) > 1801) && (substr($prod_id, 1) < 1806)) || ((substr($prod_id, 1) > 1821) && (substr($prod_id, 1) < 1826)) || ((substr($prod_id, 1) > 1841) && (substr($prod_id, 1) < 1846))) {
                                                if ($creator_qualification['b8_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_stills'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_stills'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1806") || ($prod_id == "p1826") || ($prod_id == "p1846")) {
                                                if ($creator_qualification['b8_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1807") || ($prod_id == "p1827") || ($prod_id == "p1847")) {
                                                if ($creator_qualification['b8_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if (($prod_id == "p1808") || ($prod_id == "p1828") || ($prod_id == "p1848")) {
                                                if ($creator_qualification['b8_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_movie'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1860") {
                                                if ($creator_qualification['b8_walls'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_walls'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_walls'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1861") {
                                                if ($creator_qualification['b8_windows_doors'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_windows_doors'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_windows_doors'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p186z") {
                                                if ($creator_qualification['b8_2d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_2d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_2d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p186y") {
                                                if ($creator_qualification['b8_2d_konfig_renders'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_2d_konfig_renders'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_2d_konfig_renders'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p186x") {
                                                if ($creator_qualification['b8_3d_configurator'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_3d_configurator'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_3d_configurator'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if (((substr($prod_id, 1) > 1861) && (substr($prod_id, 1) < 1865)) || ((substr($prod_id, 1) > 1881) && (substr($prod_id, 1) < 1890))) {
                                                if ($creator_qualification['b8_render_stills'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_stills'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_stills'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }


                                            if ($prod_id == "p1866") {
                                                if ($creator_qualification['b8_render_360'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_360'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_360'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1867") {
                                                if ($creator_qualification['b8_render_slideshow'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_slideshow'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_slideshow'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1868") {
                                                if ($creator_qualification['b8_render_movie'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_movie'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_render_movie'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                            if ($prod_id == "p1881") {
                                                if ($creator_qualification['b8_environment'] > 0) {
                                                    if ($other_resources_counter == 0) {
                                                        ?>
                                                        <option style="color:red;">Resources from other companies
                                                        </option>
                                                        <?php
                                                        $other_resources_counter++;
                                                    }
                                                    ?>
                                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>"
                                                            class="offline"
                                                            value="<?php echo $all_other_creators[$i]['client_ID']; ?>" <?php echo ($producer['uca_id'] == $all_other_creators[$i]['client_ID']) ? "selected" : "" ?>><?php
                                                        if (!empty($all_other_creators[$i]['c_last_name'])) {
                                                            echo $all_other_creators[$i]['c_first_name'] . " " . $all_other_creators[$i]['c_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_environment'] . ")";
                                                        } else {
                                                            echo $all_other_creators[$i]['l_first_name'] . " " . $all_other_creators[$i]['l_last_name'] . " - " . $prod->get_company($all_other_creators[$i]['lt_id'])['mailnick'] . " (" . $creator_qualification['b8_environment'] . ")";
                                                        } ?><?php

                                                        ?></option>
                                                    <?php
                                                }
                                            }

                                        }
                                    }

                                    ?>
                                </select>
                                <script>

                                    // if (document.getElementById('creators_0').dataset.loaded === 'false')
                                    // {
                                    $('#creators_0').click(function () {


                                        console.log(this.dataset);


                                        this.dataset.loaded = 'true';


                                        $.ajax({

                                            url: '../api/creators.php',

                                            method: 'get',

                                            data: {

                                                o_id: '<?=$o_id?>',

                                                osub_id: '<?=$osub_id?>',

                                                prod_id: '<?=$prod_id?>',

                                                u_prod_id: '<?=$order['u_prod_id']?>',

                                                timezone: Intl.DateTimeFormat().resolvedOptions().timeZone

                                            },

                                            dataType: 'json',

                                            success: function (data) {

                                                //console.log(data);

                                                let select = document.getElementById('creators_0');
                                                let selectedValue = select.value;


                                                while (select.firstChild) {

                                                    select.removeChild(select.firstChild);

                                                }


                                                function createOptions(creators) {

                                                    if (!creators || typeof creators !== 'object') {
                                                        return;
                                                    }

                                                    for (let key in creators) {

                                                        let creator = creators[key];
                                                        let option = document.createElement('option');


                                                        // if (creator.client_ID === data.selected) {

                                                        //     option.selected = true;

                                                        // }

                                                        /*
                                                        if(creator) {
                                                            if(creator.shifts) {
                                                                if(creator.shifts.today) {
                                                                    if (creator.shifts.today.work) {

                                                                        option.style.backgroundColor = 'green';

                                                                        option.style.color = 'white';

                                                                    }
                                                                }
                                                            }
                                                        }*/

                                                        option.appendChild(document.createTextNode(creator.c_first_name + ' ' + creator.c_last_name));

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

                                                if (selectedValue) {
                                                    select.value = selectedValue;
                                                }
                                            }

                                        });

                                    });


                                    // } else {

                                    //     console.log("Already Loaded");

                                    // }

                                    $('#creators_0').on("change", function () {

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


                                                $('#task<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center blue');


                                                $('#product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').val(2);


                                            }


                                        });


                                    });

                                </script>
                                <script type="text/javascript">

                                    /*$('#creators_0').on("change", function () {
                                        $.ajax({
                                            url: "../ajax/assign_creator.php",
                                            method: "get",
                                            data: {
                                                o_id:<?php echo $o_id;?>,
                                                osub_id: "<?php echo $osub_id;?>",
                                                prod_id: "<?php echo $prod_id;?>",
                                                creatorid: $(this).val()
                                            },
                                            dataType: "html",
                                            success: function (data) {
                                                console.log(data);
                                                $('#task<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').removeClass().addClass('row w-100 mx-0 py-3 blue');
                                                $('#product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').val(2);
                                            }
                                        });
                                    });*/
                                </script>
                            </div>
                        </div>
                        <div class="col-md-3 pt-1">
                            <div class="form-inline"><p class="mb-0 d-inline mr-2">Status : </p>
                                <select name="product_status"
                                        id="product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id; ?>"
                                        class="form-control form-control-sm" style="width:170px;">
                                    <?php
                                    for ($i = 1; $i < count($allstatus); $i++) {
                                        ?>
                                        <option value="<?php echo $allstatus[$i]['ost_id']; ?>"
                                                data-status="<?php echo $allstatus[$i]['ost_color']; ?>" <?php echo ($allstatus[$i]['ost_id'] == $producer['p_status']) ? "selected" : ""; ?>><?php echo ucfirst($allstatus[$i]['ost_name']); ?></option>
                                        <?php
                                    }
                                    ?>

                                </select>
                                <script type="text/javascript">
                                    $('#product_status<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').on("change", function () {
                                        $.ajax({
                                            url: "../ajax/change_product_status.php",
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
                                                $('#task<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>').removeClass().addClass('row w-100 mx-0 py-3 ' + clasa);
                                                //     }
                                                // }

                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-md-2 pt-2">
                            labc: <?php echo $labc = $prod->calculateProductlabc_by_orderid($prod_id, $o_id); ?>
                        </div>
                        <div class="row w-100">
                            <div class="col-md-9 text-center">
                                <?php
                                $last_activity = $prod->get_product_last_change($o_id, $osub_id, $prod_id);

                                if (!empty($last_activity)) {
                                    $client = $prod->get_client($last_activity['uca_id']);

                                    echo $client['c_first_name'] . " " . $client['c_last_name'] . " " . $last_activity['description'] . " on " . $last_activity['date'];
                                } else {
                                    echo "No activity found";
                                }
                                ?>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#statusdetailsModal">More status change details
                                </button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="statusdetailsModal" tabindex="-1" role="dialog"
                                 aria-labelledby="statusdetailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-dark" id="statusdetailsModalLabel">More status
                                                change details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped border">
                                                <tbody>
                                                <?php
                                                $all_activity = $prod->get_this_product_all_changes($o_id, $osub_id, $prod_id);

                                                for ($a = 0; $a < count($all_activity); $a++) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-dark"><?php
                                                            $client = $prod->get_client($all_activity[$a]['uca_id']);

                                                            echo $client['c_first_name'] . " " . $client['c_last_name'] . " " . $all_activity[$a]['description'] . " on " . $all_activity[$a]['date'];
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row w-100 mx-0">
                        <div class="col-md-6 pt-2 pb-5 border-right border-bottom px-0">
                            <p class="mb-0 w-100 text-center"><b>Client remarks interior</b></p>
                            <div class="row w-100 mx-0 border-bottom pb-2 pl-4">
                                <p class="w-100 mb-0 <?php echo (!empty($order['clients-extras'])) ? "text-left text-danger" : "text-center"; ?>"><?php echo (!empty($order['clients-extras'])) ? nl2br($order['clients-extras']) : "NONE"; ?></p>
                            </div>
                            <p class="mb-0 w-100 text-center"><b>Client remarks exterior</b></p>
                            <div class="row w-100 mx-0 border-bottom pb-2 pl-4">
                                <p class="w-100 mb-0 <?php echo (!empty($order['client_extras_ex_b5'])) ? "text-left text-danger" : "text-center"; ?>">
                                    <?php echo (!empty($order['client_extras_ex_b5'])) ? nl2br($order['client_extras_ex_b5']) : "NONE"; ?>
                                </p>
                            </div>
                            <p class="mb-0 w-100 text-center"><b>Operator remarks interior</b></p>
                            <div class="row w-100 mx-0 border-bottom pb-2 pl-4">
                                <p class="w-100 mb-0 <?php echo (!empty($order['op-remarks'])) ? "text-left text-danger" : "text-center"; ?>">
                                    <?php echo (!empty($order['op-remarks'])) ? nl2br($order['op-remarks']) : "NONE"; ?>
                                </p>
                            </div>
                            <p class="mb-0 w-100 text-center"><b>Operator remarks exterior</b></p>
                            <div class="row w-100 mx-0 border-bottom pb-2 pl-4">
                                <p class="w-100 mb-0 <?php echo (!empty($order['op_remarks_ex_b5'])) ? "text-left text-danger" : "text-center"; ?>">
                                    <?php echo (!empty($order['op_remarks_ex_b5'])) ? nl2br($order['op_remarks_ex_b5']) : "NONE"; ?>
                                </p>
                            </div>
                            <p class="w-100 mb-0 text-center"><b>Environment address</b></p>
                            <div class="row w-100 mx-0 border-bottom pb-2 pl-4">
                                <p class="w-100  text-danger mb-0 <?php echo (!empty($order['environment_address'])) ? "text-left text-danger" : "text-center" ?>">
                                    <?php echo (!empty($order['environment_address'])) ? nl2br($order['environment_address']) : "NONE"; ?>
                                </p>
                            </div>
                            <div class="row w-100 mx-0">
                                <div class="col-md-12 mb-3">
                                    <p class="mb-0 w-100 text-center"><b>Tutorials</b></p>
                                </div>
                            </div>
                            <?php

                            //echo $client['mc_id']." - ".$tutorial['main_client_ID'];

                            $product_cdws_ids = explode(',', $product['cdws_ids']);

                            //print_r($product_cdws_ids);

                            $tutorial_ids = [];

                            for ($i = 0; $i < count($product_cdws_ids); $i++) {
                                $tutorial_cdws_id = $prod->get_product_tutorials($product_cdws_ids[$i]);

                                for ($j = 0; $j < count($tutorial_cdws_id); $j++) {
                                    $tutorial_ids[] = $tutorial_cdws_id[$j]['t_id'];
                                }

                            }

                            $tutorial_ids = array_values(array_unique($tutorial_ids));
                            $tutorial_counter = 0;

                            $tutorials = [];

                            foreach ($tutorial_ids as $t) {
                                $tutorials[] = $prod->get_tutorial_by_id($t);
                            }

                            $col = array_column($tutorials, "t_title");
                            array_multisort($col, SORT_ASC, SORT_NATURAL | SORT_FLAG_CASE, $tutorials);

                            //print_r($tutorials);
                            //print_r($tutorial_ids);
                            for ($t = 0; $t < count($tutorials); $t++) {
                                $main_client_ids = explode(";", $tutorials[$t]['main_client_ID']);
                                $client_ids = explode(";", $tutorials[$t]['client_ID']);

                                if ($tutorials[$t]['language_of_order'] == $order['client_language_id']) {
                                    if (strpos($tutorials[$t]['main_client_ID'], '0;') !== false) //contains 0;
                                    {

                                    } elseif (strpos($tutorials[$t]['main_client_ID'], '0;') === false) //does not contain 0;
                                    {
                                        // print_r($main_client_ids);
                                        for ($j = 0; $j < count($main_client_ids); $j++) {
                                            //echo $main_client_ids[$j]." ".$client['mc_id'];
                                            if (($main_client_ids[$j] == $order['mc_id']) && (!empty($main_client_ids[$j]))) {
                                                ?>
                                                <div class="row w-100 mx-0">
                                                    <div class="col-md-6 offset-3 bg-danger border border-dark">
                                                        <div>
                                                            <a title="<?php echo $tutorials[$t]['t_description']; ?>"
                                                               href="<?php echo $tutorials[$t]['t_link']; ?>"
                                                               target="_blank"
                                                               style="color:white;"><?php echo $tutorials[$t]['t_title']; ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    //echo $tutorial['cdws_ids'];

                                    if ((strpos($tutorials[$t]['client_ID'], $client['client_ID'] . ';') !== false) || ($tutorials[$t]['client_ID'] == "all;")) //contains client id;
                                    {

                                        ?>
                                        <div class="row w-100 mx-0">
                                            <div class="col-md-6 offset-3 border border-dark">
                                                <div style="<?php echo ($tutorials[$t]['client_ID'] != "all;") ? "background-color:red" : ""; ?>">
                                                    <a title="<?php echo $tutorials[$t]['t_description']; ?>"
                                                       href="<?php echo $tutorials[$t]['t_link']; ?>" target="_blank"
                                                       style="<?php echo ($tutorials[$t]['client_ID'] != "all;") ? "color:white;" : ""; ?>"><?php echo $tutorials[$t]['t_title']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php

                                    }
                                }

                                //tutorials for all languages

                                if ($tutorials[$t]['language_of_order'] == 0) {
                                    if (strpos($tutorials[$t]['main_client_ID'], '0;') !== false) //contains 0;
                                    {
                                        /*for($j=0;$j<count($main_client_ids);$j++)
                        {
                        if(($main_client_ids[$j]==$client['mc_id'])||($main_client_ids[$j]!=$client['mc_id']))
                        {
                            if($tutorial_counter==0)
                            {
                        ?>
                        <div class="row w-100 mx-0">
                            <div class="col-md-6 offset-3 border-dark border bg-light py-2">
                                <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank"><?php echo $tutorial['t_title'];?></a>
                            </div>
                        </div>
                        <?php
                        $tutorial_counter++;
                            }
                        }
                        }
                        $tutorial_counter=0; */
                                    } elseif (strpos($tutorials[$t]['main_client_ID'], '0;') === false) //does not contain 0;
                                    {
                                        // print_r($main_client_ids);
                                        for ($j = 0; $j < count($main_client_ids); $j++) {
                                            //echo $main_client_ids[$j]." ".$order['mc_id'];
                                            if (($main_client_ids[$j] == $order['mc_id']) && (!empty($main_client_ids[$j]))) {
                                                ?>
                                                <div class="row w-100 mx-0">
                                                    <div class="col-md-6 offset-3 bg-danger border border-dark">
                                                        <div>
                                                            <a title="<?php echo $tutorials[$t]['t_description']; ?>"
                                                               href="<?php echo $tutorials[$t]['t_link']; ?>"
                                                               target="_blank"
                                                               style="color:white;"><?php echo $tutorials[$t]['t_title']; ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    //echo $tutorial['cdws_ids'];

                                    if ((strpos($tutorials[$t]['client_ID'], $client['client_ID'] . ';') !== false) || ($tutorials[$t]['client_ID'] == "all;")) //contains client id;
                                    {

                                        ?>
                                        <div class="row w-100 mx-0">
                                            <div class="col-md-6 offset-3 border border-dark">
                                                <div style="<?php echo ($tutorials[$t]['client_ID'] != "all;") ? "background-color:red" : ""; ?>">
                                                    <a title="<?php echo $tutorials[$t]['t_description']; ?>"
                                                       href="<?php echo $tutorials[$t]['t_link']; ?>" target="_blank"
                                                       style="<?php echo ($tutorials[$t]['client_ID'] != "all;") ? "color:white;" : ""; ?>"><?php echo $tutorials[$t]['t_title']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php

                                    }

                                }
                            }
                            /*foreach($tutorial_ids as $t)
				{

					$tutorial=$prod->get_tutorial_by_id($t);
                    //print_r($tutorial);
                    $main_client_ids=explode(";",$tutorial['main_client_ID']);
                    $client_ids=explode(";",$tutorial['client_ID']);

                    //tutorials for specific language

                    //print_r($tutorial);
                    if($tutorial['language_of_order']==$order['client_language_id'])
                    {
					if(strpos($tutorial['main_client_ID'], '0;') !== false) //contains 0;
					{
                        for($j=0;$j<count($main_client_ids);$j++)
                        {
						if(($main_client_ids[$j]==$client['mc_id'])||($main_client_ids[$j]!=$client['mc_id']))
						{
                            if($tutorial_counter==0)
                            {
						?>
						<div class="row w-100 mx-0">
							<div class="col-md-6 offset-3 border-dark border bg-light py-2">
								<a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank"><?php echo $tutorial['t_title'];?></a>
							</div>
						</div>
						<?php
                        $tutorial_counter++;
                            }
                        }
                        }
                        $tutorial_counter=0;
					}

					elseif(strpos($tutorial['main_client_ID'], '0;') === false) //does not contain 0;
					{
                       // print_r($main_client_ids);
                        for($j=0;$j<count($main_client_ids);$j++)
                        {
                            //echo $main_client_ids[$j]." ".$client['mc_id'];
                            if(($main_client_ids[$j]==$order['mc_id'])&&(!empty($main_client_ids[$j])))
                            {
                            ?>
                            <div class="row w-100 mx-0">
                                <div class="col-md-6 offset-3 bg-danger border border-dark">
                                    <div>
                                        <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank" style="color:white;"><?php echo $tutorial['t_title'];?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                        }
					}
                    //echo $tutorial['cdws_ids'];

					if((strpos($tutorial['client_ID'], $client['client_ID'].';') !== false)||($tutorial['client_ID']=="all;")) //contains client id;
					{

						?>
						<div class="row w-100 mx-0">
							<div class="col-md-6 offset-3 border border-dark">
                                <div style="<?php echo ($tutorial['client_ID']!="all;")?"background-color:red":"";?>">
                                    <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank" style="<?php echo ($tutorial['client_ID']!="all;")?"color:white;":"";?>"><?php echo $tutorial['t_title'];?></a>
                                </div>
							</div>
						</div>
						<?php

                    }
                }

                //tutorials for all languages

                if($tutorial['language_of_order']==0)
                {
                 if(strpos($tutorial['main_client_ID'], '0;') !== false) //contains 0;
                {
                    /*for($j=0;$j<count($main_client_ids);$j++)
                    {
                    if(($main_client_ids[$j]==$client['mc_id'])||($main_client_ids[$j]!=$client['mc_id']))
                    {
                        if($tutorial_counter==0)
                        {
                    ?>
                    <div class="row w-100 mx-0">
                        <div class="col-md-6 offset-3 border-dark border bg-light py-2">
                            <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank"><?php echo $tutorial['t_title'];?></a>
                        </div>
                    </div>
                    <?php
                    $tutorial_counter++;
                        }
                    }
                    }
                    $tutorial_counter=0;
                }

                elseif(strpos($tutorial['main_client_ID'], '0;') === false) //does not contain 0;
                {
                   // print_r($main_client_ids);
                    for($j=0;$j<count($main_client_ids);$j++)
                    {
                        //echo $main_client_ids[$j]." ".$order['mc_id'];
                        if(($main_client_ids[$j]==$order['mc_id'])&&(!empty($main_client_ids[$j])))
                        {
                        ?>
                        <div class="row w-100 mx-0">
                            <div class="col-md-6 offset-3 bg-danger border border-dark">
                                <div>
                                    <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank" style="color:white;"><?php echo $tutorial['t_title'];?></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                }
                //echo $tutorial['cdws_ids'];

                if((strpos($tutorial['client_ID'], $client['client_ID'].';') !== false)||($tutorial['client_ID']=="all;")) //contains client id;
                {

                    ?>
                    <div class="row w-100 mx-0">
                        <div class="col-md-6 offset-3 border border-dark">
                            <div style="<?php echo ($tutorial['client_ID']!="all;")?"background-color:red":"";?>">
                                <a title="<?php echo $tutorial['t_description'];?>" href="<?php echo $tutorial['t_link'];?>" target="_blank" style="<?php echo ($tutorial['client_ID']!="all;")?"color:white;":"";?>"><?php echo $tutorial['t_title'];?></a>
                            </div>
                        </div>
                    </div>
                    <?php

                }
            }

				} */
                            ?>
                            <br>
                            <?php /*
                            $customer_files = $prod->get_customer_files($o_id);
                            ?>
                            <div class="row w-100 mx-0">
                                <div class="row w-100 mx-0 border-bottom border-dark">
                                    <p class="w-100 mb-0 text-center"><b>This is the relevant:</b></p>
                                </div>
                            </div>
                            <div class="row w-100 mx-0 border-bottom border-dark">
                                <div class="col-md-2">
                                    <p class="w-100 mb-0 text-center"><b>Internal name</b></p>
                                </div>

                                <div class="col-md-2 border-left border-dark">
                                    &nbsp;
                                </div>
                                <div class="col-md-1">
                                    &nbsp;
                                </div>
                                <?php /*
                                if (strpos($osub_id, 'n') !== false) {
                                    ?>
                                    <div class="col-md-1 border-right border-dark">
                                        <p class="w-100 mb-0 text-center"><b>In Sub-id</b></p>
                                    </div>
                                    <?php
                                }
                                if (strpos($osub_id, 'x') !== false) {
                                    ?>
                                    <div class="col-md-1 border-right border-dark">
                                        <p class="w-100 mb-0 text-center"><b>Ex Sub-id</b></p>
                                    </div>
                                    <?php
                                } */ /*
                                ?>

                                <!-- <div class="col-md-3 border-left border-dark">
                                    <p class="w-100 mb-0 text-center"><b>Note</b></p>
                                </div> -->
                                <div class="col-md-4 border-left border-dark">
                                    <p class="w-100 mb-0 text-center"><b>File name</b></p>
                                </div>
                            </div>
                            <?php */
                            /*
                            $validextensions = array("jpeg", "jpg", "png");
                            $image_preview_counter = 0;

                            for ($i = 0; $i < count($customer_files); $i++) {
                                if (((substr($osub_id, 1) == $customer_files[$i]['of_position']) && (strpos($osub_id, 'n') !== false)) || ((substr($osub_id, 1) == $customer_files[$i]['of_exterior_position']) && (strpos($osub_id, 'x') !== false))) {
                                    ?>
                                    <div class="row colorline mx-0 w-100 border-bottom border-dark">
                                        <div class="col-md-3 ellipsis py-1">
                                            <span title="<?php echo $customer_files[$i]['of_name_client']; ?>"><?php echo $customer_files[$i]['of_name_client']; ?></span>
                                        </div>
                                        <?php
                                        $tempfile = explode(".", $customer_files[$i]['of_name_client']);
                                        $file_extension = strtolower(end($tempfile));

                                        if ($file_extension == "pdf") {
                                            ?>
                                            <div class="col-md-2 border-dark py-1">
                                                <img class="img-responsive" style="width:40px;cursor:pointer;"
                                                     src="../img/adobe-pdf-icon.png" alt="pdf file">
                                            </div>
                                            <?php
                                        } else {

                                            if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                                                ?>
                                                <div class="col-md-2 py-1">
                                                    <div id="image_tooltip_container_<?php
                                                    echo $image_preview_counter;
                                                    ?>"><img class="img-responsive" style="width:60px;cursor:pointer;"
                                                             src="../client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }

                                        if (strpos($osub_id, 'n') !== false) {
                                            ?>
                                            <div class="col-md-1 py-1 border-left border-dark">
                                                <?php echo $customer_files[$i]['of_position']; ?>
                                            </div>
                                            <?php
                                        }
                                        if (strpos($osub_id, 'x') !== false) {
                                            ?>
                                            <div class="col-md-1 py-1 border-left border-dark">
                                                <?php echo $customer_files[$i]['of_exterior_position']; ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-md-2 py-1 border-left border-dark">
                                            <?php
                                            if (strpos($osub_id, 'n') !== false) {
                                                echo $customer_files[$i]['of_name'];
                                            } else {
                                                echo $customer_files[$i]['of_name_ex'];
                                            } ?>
                                        </div>
                                        <div class="col-md-2 ellipsis py-1 border-left border-dark">
                                            <?php
                                            $note = $customer_files[$i]['of_kind'];
                                            if ($note == 1) {
                                                echo "Order! Main file";
                                            }
                                            if ($note == 8) {
                                                echo "NO ORDER! Only for understanding";
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-2 py-1">
                                            <a href="../image.php?filecategory=customerfiles&imageid=<?php echo $customer_files[$i]['of_id']; ?>"
                                               class="btn btn-primary btn-sm mr-1" target="_blank">Download</a>
                                        </div>
                                        <?php
                                        if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                                                        class="img-responsive" width="600"
                                                        src="../client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $image_preview_counter++;
                                }
                            }
                            ?>
                            <br>
                            New version for subIDs
                            <br>
                            <?php

                            */
                            //new sub id check
                            /*
                            $subnames_data['o_id'] = $o_id;
                            $subnames_data['o_sub_id'] = $osub_id;

                            $validextensions = array("jpeg", "jpg", "png");
                            $image_preview_counter = 0;

                            $orders_subnames = $prod->check_existing_subid(json_encode($subnames_data));

                            $all_sub_id_customer_files = explode(';', $orders_subnames['cf_id']);


                            for ($i = 0; $i < count($all_sub_id_customer_files); $i++)
                            {
                                if (!empty($all_sub_id_customer_files[$i])) {
                                    $customer_file = $prod->get_customer_file($all_sub_id_customer_files[$i]);
                                    ?>
                                    <div class="row colorline mx-0 w-100 border-bottom border-dark">
                                        <div class="col-md-2">
                                        <?php echo $customer_file['of_subtitle']; ?>
                                        </div>

                                        <?php
                                        $tempfile = explode(".", $customer_file['of_name_client']);
                                        $file_extension = strtolower(end($tempfile));

                                        if ($file_extension == "pdf") {
                                            ?>
                                            <div class="col-md-2 border-left border-dark py-1">
                                                <img class="img-responsive" style="width:40px;cursor:pointer;"
                                                src="../img/adobe-pdf-icon.png" alt="pdf file">
                                            </div>
                                            <?php
                                        } else {

                                        if (in_array($customer_file['of_type_dom'], $validextensions))
                                        {
                                            ?>
                                            <div class="col-md-2 border-left border-dark py-1">
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>"><img class="img-responsive" style="width:60px;cursor:pointer;"
                                                        src="../client_files/<?php echo $customer_file['of_path_dom'] . $customer_file['of_internal_name_dom']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                        }

                                        } */
                            /*
                            if (strpos($osub_id, 'n') !== false) {
                                ?>
                                <div class="col-md-1 py-1 border-left border-dark">
                                    <?php echo $customer_file['of_position']; ?>
                                </div>
                                <?php
                            }
                            if (strpos($osub_id, 'x') !== false) {
                                ?>
                                <div class="col-md-1 py-1 border-left border-dark">
                                    <?php echo $customer_file['of_exterior_position']; ?>
                                </div>
                                <?php
                            } */ /*
                                        ?>
                                        <div class="col-md-2 py-1 border-left border-dark">
                                            <?php
                                            if (strpos($osub_id, 'n') !== false) {
                                                echo $customer_file['of_name'];
                                            } else {
                                                echo $customer_file['of_name_ex'];
                                            } ?>
                                        </div> <?php */  /* ?>
                                        <div class="col-md-2 ellipsis py-1 border-left border-dark">
                                            <?php
                                            $note = $customer_file['of_kind'];
                                            if ($note == 1) {
                                                echo "Order! Main file";
                                            }
                                            if ($note == 8) {
                                                echo "NO ORDER! Only for understanding";
                                            }
                                            ?>
                                        </div> <?php *//* ?>
                                        <div class="col-md-1 py-1 border-right border-dark">
                                            <a href="../image.php?filecategory=customerfiles&imageid=<?php echo $customer_file['of_id']; ?>"
                                            class="btn btn-primary btn-sm mr-1" target="_blank"><i class="fas fa-arrow-circle-down"></i></a>
                                        </div>
                                        <?php
                                        if (in_array($customer_file['of_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                                                        class="img-responsive" width="600"
                                                        src="../client_files/<?php echo $customer_file['of_path_dom'] . $customer_file['of_internal_name_dom']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-md-4 ellipsis py-1">
                                            <span title="<?php echo $customer_file['of_name_client']; ?>"><?php echo $customer_file['of_name_client']; ?></span>
                                        </div>
                                    </div>
                                    <?php
                                    $image_preview_counter++;
                                }
                            } */
                            include('relevant_customer_files.php');

                            //showing shapeline and colorset for b3


                            ?>
                        </div> <!-- end col -->

                        <div class="col-md-6 px-0 dark-gray">
                            <div class="row w-100 mx-0 border-bottom border-dark">
                                <div class="col-md-6">
                                    <p class="w-100 mb-0 text-center"><b>Customer files:</b></p>
                                </div>
                                <div class="col-md-6">
                                    <a href="../image.php?filecategory=customerfiles&download-all=<?php echo $o_id; ?>" class="btn btn-sm btn-primary">Download all</a>
                                </div>
                            </div>

                            <?php
                            include('customer_files.php');
                            ?>
                        </div>
                    </div>

                    <div class="row w-100 mx-0 bg-light border-top border-dark pt-4">
                        <?php
                        if ($order['mc_id'] != 0) {
                            ?>
                            <div class="col-md-6 mb-2 text-left pl-5 pb-2">
                                <b>Special for this main client (<?php echo strtoupper($main_client['clientname']); ?>
                                    ):</b>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-6 text-left pl-5 pb-2">
                            <b>Special for this subclient (<?php
                                if (!empty($order_client['clientname'])) {
                                    echo strtoupper($order_client['clientname'] . " - " . $order_client['c_last_name'] . ", " . $order_client['c_first_name']);
                                } else {
                                    echo strtoupper($order_client['l_first_name'] . " " . $order_client['l_last_name']);
                                } ?>):</b>
                        </div>
                    </div>
                    <div class="row w-100 mx-0 bg-light pb-4">
                        <?php
                        if ($order['mc_id'] != 0) {

                            ?>
                            <div class="col-md-6 pl-5">
                                <form name="main_client_remarks_internal_form"
                                      action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>"
                                      method="post" class="form-inline">
                                    <input type="hidden" name="mc_id" value="<?php echo $main_client['mc_id']; ?>">
                                    <textarea name="main_client_remarks_internal" class="form-control form-control-sm"
                                              style="color:red;width:90%;min-height:100px;"><?php echo $main_client['remarks_internal']; ?></textarea>
                                    <button type="submit" id="main_client_remarks_internal_btn"
                                            name="main_client_remarks_internal_btn" class="btn btn-sm btn-primary ml-2">
                                        Set
                                    </button>
                                </form>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-6 pl-5">
                            <form name="remarks_internal_form"
                                  action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>"
                                  method="post" class="form-inline">
                                <input type="hidden" name="client_ID" value="<?php echo $order['u_client_ID']; ?>">
                                <textarea name="remarks_internal" class="form-control form-control-sm"
                                          style="color:red;width:90%;min-height:100px;"><?php echo $order_client['remarks_internal']; ?></textarea>
                                <button type="submit" id="remarks_internal_btn" name="remarks_internal_btn"
                                        class="btn btn-sm btn-primary ml-2">Set
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php
                    if ((substr($prod_id, 1) > 1500) && (substr($prod_id, 1) < 1560)) {
                        ?>
                        <div class="row w-100 mx-0 bg-light">
                            <p class="d-inline mb-0 pt-2 ml-5"><b>Layoutline: </b></p>
                            <?php
                            $order = $prod->get_order($o_id);
                            $client = $prod->get_client($order['u_client_ID']);

                            $layout_id = $order['layout_id'];
                            $window_id = $order['window_id'];
                            $layout = $prod->get_layout($layout_id, "b5", $window_id);
                            $layoutline_name = $layout['layoutline_name'];
                            $floor_color = $layout['set_colors'];
                            ?>
                            <div class="colorbox" style="background-color:<?php $window = $prod->get_window($window_id);
                            echo $window['window_color']; ?>;border: 10px solid <?php echo $floor_color; ?>"></div>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if (((substr($prod_id, 1) > 1300) && (substr($prod_id, 1) < 1360))) {
                        $o_desc_in_b3 = $prod->get_o_desc_in_b3($o_id);

                        if (!empty($o_desc_in_b3)) {
                            ?>
                            <div class="itemselected dark-gray">
                                <div class="w-100 row pl-4 mx-0 productselected d-flex justify-content-center mb-2 py-4 border-top border-bottom border-secondary">
                                    <div class="row w-100">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center">
                                                    <b>Shapeline:</b> &nbsp;<div id="sl_id"><?php echo $o_desc_in_b3['sl_id']; ?></div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center">
                                                    <b>Colorset:</b> &nbsp;<div id="cls_id"><?php echo $o_desc_in_b3['cls_id']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="b3_colorset_examples">
                                            </div>
                                        </div>
                                        <script type="text/javascript">

                                            $(document).ready(function () {

                                                load_b3_colorset_examples();

                                            });

                                            function load_b3_colorset_examples() {
                                                let sl_id = $('#sl_id').text();
                                                let cls_id = $('#cls_id').text();

                                                if ((sl_id != "") && (cls_id != "")) {

                                                    $.ajax({
                                                        url: "../ajax/get_b3_colorset_examples_html.php",
                                                        method: "get",
                                                        data: {sl_id: sl_id, cls_id: cls_id},
                                                        dataType: "html",
                                                        success: function (data) {
                                                            $('#b3_colorset_examples').html(data);
                                                        }
                                                    });

                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }

                    if (
                            ((substr($prod_id, 1) > 1300) && (substr($prod_id, 1) < 1360)) ||
                            ((substr($prod_id, 1) > 1560) && (substr($prod_id, 1) < 1599)) || ((substr($prod_id, 1) > 1660) && (substr($prod_id, 1) < 1699)) ||
                            ((substr($prod_id, 1) > 1760) && (substr($prod_id, 1) < 1799)) || ((substr($prod_id, 1) > 1860) && (substr($prod_id, 1) < 1899))
                    ) {
                        //include('../../domenia7.com/short_order_description.php');
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
                                            <img src="<?php echo $picture_website . $all_roof_shapes[$i]['rs_pic']; ?>"
                                                 class="img-responsive img-fluid d-block mr-auto ml-auto">
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
                                <span><?php
                                    if (empty($o_desc_allproducts['roof_tilt'])) {
                                        echo "None";
                                    } else {
                                        echo $o_desc_allproducts['roof_tilt'] . "°";
                                    } ?></span>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="mywidth product row6" data-position="4"><p
                                            class="text-center text-success mb-0">
                                        <strong>Kneewall</strong>
                                    </p>
                                    <span class="icon-cheked">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                                    <div class="text-center">
                                <span><?php
                                    echo $o_desc_allproducts['knee_wall'];
                                    ?></span>
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
                                            <strong><?php echo $o_desc_allproducts['length']; ?></strong></p>
                                        <p class="text-center text-secondary mt-1 mb-0">Depth (cm)</p>
                                        <p class="text-center text-dark mb-0">
                                            <strong><?php echo $o_desc_allproducts['width']; ?></strong></p>
                                        <?php
                                    } else {
                                        ?>
                                        <p class="text-center text-dark mb-0"><strong>Check floorplans</strong></p>
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
                                                Front door color
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

                                if ($o_desc_allproducts['photovoltaic'] == 1) {
                                    ?>
                                    <div class="mywidth product row19" data-position="20"><p
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

                                //print_r($garage);

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
                                                 class="img-fluid d-block mr-auto ml-auto" alt=""
                                                 style="width:80px !important;">
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
                    ?>

                    <div class="row w-100 mx-0">
                        <div class="col-md-12">
                            <p class="w-100 text-center"><b><a id="all_uploaded_result_files">Result file(s) for <?php echo $o_id . "." . $osub_id . "." . $prod_id; ?> - <?php
                                        $subid_data['o_id'] = $o_id;
                                        $subid_data['o_sub_id'] = $osub_id;

                                        $subo_name = $prod->check_existing_subid(json_encode($subid_data));

                                        echo $subo_name['subo_name'];
                                        ?></a></b></p>
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-7">
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>#all_uploaded_result_files" class="btn btn-sm btn-primary">All files</a>
                            <?php
                            $all_base_pictures = $prod->get_all_base_pictures_for_this_osub_id($o_id, $osub_id, $prod_id);

                            for ($b = 0; $b < count($all_base_pictures); $b++) {
                                ?>
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>&orf_id=<?php echo $all_base_pictures[$b]['orf_id']; ?>#all_uploaded_result_files" class=""><img alt="base pic <?php echo $b; ?>" src="<?php echo $base_url . "result_thumbnail_files/" . $all_base_pictures[$b]['orf_thumbnail_path']; ?>"></a>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-auto p-0">
                            <a href="../image.php?filecategory=creatorfiles&download-all=<?php echo $o_id; ?>" class="btn btn-sm btn-success">Download all</a>
                        </div>
                        <div class="col-md-auto p-0">
                            <a href="https://bauvorschau.com/production/<?php
                            if ($order['om_id'] == 0) {
                                echo $o_id;
                            } else {
                                echo $order['om_id'];
                            } 
                            
                            $existing_token=$prod->get_token($_COOKIE['client_id']);
                            if(!empty($existing_token))
                            {
                                echo "/?token=" . $existing_token['token'];
                            }
                            ?>" target="_blank" class="btn btn-sm orange">Checkation</a>
                        </div>
                        <div class="col-md-auto p-0">
                            <a href="https://bauvorschau.com/<?php
                            if ($order['om_id'] == 0) {
                                echo $o_id;
                            } else {
                                echo $order['om_id'];
                            } ?>/tour<?php 
                            
                            $existing_token=$prod->get_token($_COOKIE['client_id']);
                            if(!empty($existing_token))
                            {
                                echo "/?token=" . $existing_token['token'];
                            }
                            ?>" target="_blank" class="btn btn-sm btn-success">Presentation</a>
                        </div>
                        
                    </div>
                    <?php
                    if (strpos($osub_id, 'n') !== false) {
                        ?>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>" class="btn btn-sm btn-primary">Total</a>
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>&room_id=0" class="btn btn-sm btn-primary">Unspecified</a>
                                <?php
                                $room_data['o_id'] = $o_id;
                                $room_data['osub_id'] = $osub_id;

                                $all_rooms = $prod->get_all_rooms_for_this_sub_id(json_encode($room_data));
                                for ($r = 0; $r < count($all_rooms); $r++) {
                                    ?>
                                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>&room_id=<?php echo $all_rooms[$r]['room_id']; ?>" class="btn btn-sm btn-primary">R <?php
                                        echo $all_rooms[$r]['room_number']; ?> - <?php echo $all_rooms[$r]['room_name'];
                                        ?></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <br>
                        <?php
                    }

                    //result files start here
                    if (
                            (substr($prod_id, -2) == "6m") || (substr($prod_id, -2) == "gm")
                    ) {
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
                            $base_picture_results = $prod->show_results($o_id, $osub_id, substr($prod_id, 0, 4) . "b");

                            for ($b = 0; $b < count($base_picture_results); $b++) {
                                ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="../result_compress_files/<?php echo $base_picture_results[$b]['orf_compress_path']; ?>" target="_blank"><img src="../result_compress_files/<?php echo $base_picture_results[$b]['orf_compress_path']; ?>" alt="<?php echo $base_picture_results[$b]['orf_name']; ?>" class="img-fluid"></a>
                                        <?php echo $base_picture_results[$b]['pict_categ_name']; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <div id="masks<?php echo $base_picture_results[$b]['orf_id']; ?>"></div>
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <button id="new_mask_btn<?php echo $base_picture_results[$b]['orf_id']; ?>" data-orf_id="<?php echo $base_picture_results[$b]['orf_id']; ?>" data-o_id="<?php echo $base_picture_results[$b]['o_id']; ?>" class="btn btn-sm btn-primary">New mask 4 this picture</button>
                                                <script type="text/javascript">
                                                    $('#new_mask_btn<?php echo $base_picture_results[$b]['orf_id'];?>').click(function () {
                                                        let orf_id = $(this).data('orf_id');
                                                        let o_id = $(this).data('o_id');

                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/create_masks_for_orf_id.php",
                                                            method: "post",
                                                            data: {
                                                                orf_id: orf_id
                                                            },
                                                            dataType: "html",
                                                            success: function (data) {

                                                                get_masks_for_orf_id(orf_id, o_id);

                                                            }
                                                        });

                                                    });

                                                    $(document).ready(function () {
                                                        get_masks_for_orf_id(<?php echo $base_picture_results[$b]['orf_id'];?>,<?php echo $base_picture_results[$b]['o_id'];?>);
                                                    });

                                                    function get_masks_for_orf_id(orf_id, o_id) {
                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/get_masks_for_orf_id.php",
                                                            method: "GET",
                                                            data: {
                                                                orf_id: orf_id,
                                                                o_id: o_id
                                                            },
                                                            dataType: "html",
                                                            success: function (data) {
                                                                $('#masks' + orf_id).html(data);

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

                    if (substr($prod_id, -2) == "6t") {
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
                                    <button id="new_targets_btn" data-o_id="<?php echo $o_id; ?>" class="btn btn-sm btn-primary">New target</button>
                                    <script type="text/javascript">
                                        $('#new_targets_btn').click(function () {
                                            let o_id = $(this).data('o_id');

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

                                        $(document).ready(function () {
                                            get_targets_for_o_id(<?php echo $o_id;?>);
                                        });

                                        function get_targets_for_o_id(o_id) {
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

                    if (
                            (substr($prod_id, -2) == "8s") || (substr($prod_id, -2) == "gs")
                    ) {
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
                                    echo $o_id; ?>" data-osub_id="<?php
                                    echo $osub_id; ?>" data-prod_id="<?php
                                    echo $prod_id; ?>" data-uca_id="<?php
                                    echo $_COOKIE['client_id']; ?>" class="btn btn-sm btn-primary">New suntour model
                                    </button>
                                    <script type="text/javascript">
                                        $('#new_suntour_model_btn').click(function () {
                                            let o_id = $(this).data('o_id');
                                            let osub_id = $(this).data('osub_id');
                                            let prod_id = $(this).data('prod_id');
                                            let uca_id = $(this).data('uca_id');

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

                                                    get_suntour_models(o_id, osub_id, prod_id);

                                                }
                                            });

                                        });

                                        $(document).ready(function () {
                                            get_suntour_models(<?php echo $o_id;?>, "<?php echo $osub_id;?>", "<?php echo $prod_id;?>");
                                        });

                                        function get_suntour_models(o_id, osub_id, prod_id) {
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

                    if (substr($prod_id, -1) == "v") {
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
                                    echo $o_id; ?>" data-osub_id="<?php
                                    echo $osub_id; ?>" data-prod_id="<?php
                                    echo $prod_id; ?>" data-uca_id="<?php
                                    echo $_COOKIE['client_id']; ?>" class="btn btn-sm btn-primary">New VR link
                                    </button>
                                    <script type="text/javascript">
                                        $('#new_vr_link_btn').click(function () {
                                            let o_id = $(this).data('o_id');
                                            let osub_id = $(this).data('osub_id');
                                            let prod_id = $(this).data('prod_id');
                                            let uca_id = $(this).data('uca_id');

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

                                                    get_vr_links(o_id, osub_id, prod_id);

                                                }
                                            });

                                        });

                                        $(document).ready(function () {
                                            get_vr_links(<?php echo $o_id;?>, "<?php echo $osub_id;?>", "<?php echo $prod_id;?>");
                                        });

                                        function get_vr_links(o_id, osub_id, prod_id) {
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

                    if (
                            (substr($prod_id, -2) != "6t") && (substr($prod_id, -2) != "6m") && (substr($prod_id, -2) != "8s") && (substr($prod_id, -1) != "v") &&
                            (substr($prod_id, -2) != "gt") && (substr($prod_id, -2) != "gm") && (substr($prod_id, -2) != "gs")
                    ) {
                        ?>
                        <div class="col-md-12">
                            <?php
                            //$result_files = $prod->show_results_with_rooms($o_id, $osub_id, $prod_id,$room_id);
                            // print_r($result_files);
                            if (!empty($orf_id)) {
                                $result_files = $prod->show_results_from_base_picture($o_id, $osub_id, $prod_id, $orf_id);
                                //echo "order from base picture";
                            } else {
                                $result_files = $prod->show_results_with_rooms($o_id, $osub_id, $prod_id, $room_id);
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
                                if ((substr($prod_id, -1) === '8')) {
                                    ?>
                                    <div class="col-2 border-right border-dark px-0">External link</div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-2 border-right border-dark px-0">&nbsp;</div>
                                    <?php
                                }
                                ?>
                                <!--<div class="col-2 border-right border-dark px-0"></div> -->
                                <?php /* <div class="col-1 border-right border-dark px-0">Img Nr</div> */ ?>
                                <div class="col-5 border-right border-dark px-0">Customer View</div>
                            </div>
                        </div> <!--end table header -->
                        <div class="col-md-12">
                            <?php
                            if (
                                    ($prod_id != "p168s") || (substr($prod_id, -2) != "gs")
                            ) {

                                for ($i = 0; $i < count($result_files); $i++) {

                                    if ($result_files[$i]['no_result_file'] != 1) {
                                        ?>
                                        <div class="row w-100 mx-0 border-dark dark-gray" style="border-color:#000;border-style:solid;border-bottom-width: 3px;border-left-width: 1px;border-right-width: 1px;border-top-width: 1px;" id="result_file_row<?php echo $result_files[$i]['orf_id']; ?>">
                                            <div class="col-md-3 border-right border-dark px-0 py-1">
                                                <div class="d-flex">

                                                    <?php if (substr($result_files[$i]['prod_id'], -2) == '2y'): ?>

                                                        <?php include '2d_konfigurator_nameing_tool.php'; ?>

                                                    <?php else: ?>

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

                                                    <?php endif; ?>

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
                                                                // Swal.fire({
                                                                //     position: 'center',
                                                                //     icon: 'success',
                                                                //     title: 'File name Updated',
                                                                //     showConfirmButton: false,
                                                                //     timer: 1500
                                                                // })
                                                            }
                                                        });
                                                    });
                                                </script>
                                                <?php
                                                $pict_categ_name = $prod->get_pict_categ_name($result_files[$i]['orf_name']);
                                                ?>
                                                <form class="" action="<?php echo $base_url . htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
                                                    <?php
                                                    if (substr($result_files[$i]['prod_id'], -1) === 'y') {
                                                        ?>
                                                        <div class="row">
                                                            <?php
                                                            $configurator_pictures = $prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                                            $pict_categ_name_array = explode(".", $result_files[$i]['pict_categ_name']);
                                                            $countMainImage = 0;
                                                            $countDoorShapeImage = 0;

                                                            $o_results_configurator_plus = $prod->get_o_results_configurator_plus($result_files[$i]['orf_id']);

                                                            if ($result_files[$i]['orf_type_dom'] == "jpg") {
                                                                ?>

                                                                <div class="col-md-auto text-truncate">

                                                                    <div id="change_existing_classification<?php echo $result_files[$i]['orf_id'] ?>" class="existing_classification">
                                                                        <?php
                                                                        if (!empty($result_files[$i]['config_level'])) {
                                                                            $picture_area = $prod->get_picture_area($result_files[$i]['config_level']);
                                                                            echo (!empty($picture_area['pa_description'])) ? $picture_area['pa_description'] : "Classify ?";
                                                                        } else {
                                                                            echo "Classify ?";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <script type="text/javascript">
                                                                        $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').hover(function () {

                                                                            $(this).css('cursor', 'pointer');

                                                                        });

                                                                    </script>
                                                                    <input type="hidden" name="pa_id" id="pa_id<?php echo $result_files[$i]['orf_id'] ?>" value="<?php echo $o_results_configurator_plus['pa_id']; ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <img id="selected_shape_picture<?php echo $result_files[$i]['orf_id']; ?>" src="<?php
                                                                    $door_shapes_pictures = $prod->get_all_door_shapes();

                                                                    for ($p = 0; $p < count($door_shapes_pictures); $p++) {
                                                                        if ($pict_categ_name_array[1] == $door_shapes_pictures[$p]['dsp_id']) {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/" . $door_shapes_pictures[$p]['dsp_pic'];
                                                                        }
                                                                    }

                                                                    $roof_shapes_pictures = $prod->get_all_roof_shapes();

                                                                    for ($p = 0; $p < count($roof_shapes_pictures); $p++) {
                                                                        if ($pict_categ_name_array[1] == $roof_shapes_pictures[$p]['rs_id']) {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/" . $roof_shapes_pictures[$p]['rs_pic'];
                                                                        }
                                                                    }

                                                                    $gutters_shapes_pictures = $prod->get_all_gutters();

                                                                    for ($p = 0; $p < count($gutters_shapes_pictures); $p++) {
                                                                        if ($pict_categ_name_array[1] == $gutters_shapes_pictures[$p]['gut_id']) {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/" . $gutters_shapes_pictures[$p]['gut_pic'];
                                                                        }
                                                                    }
                                                                    ?>" alt="<?php
                                                                    if (strpos($o_results_configurator_plus['pa_symbol'], "_org") === false) {
                                                                        echo ucfirst($o_results_configurator_plus['pa_symbol']);
                                                                    } elseif (strpos($o_results_configurator_plus['pa_symbol'], "_org") !== false) {
                                                                        echo "Original";
                                                                    } else {
                                                                        echo "What is it ?";
                                                                    }
                                                                    ?>" class="door_shapes <?php
                                                                    if ($countDoorShapeImage === 0) echo 'broken_door_shape_image' ?>" data-pa_id="<?php echo $o_results_configurator_plus['pa_id']; ?>" style="width:50px;height:50px;" whidth="50" height="50">
                                                                </div>
                                                                <?php
                                                            }

                                                            if ($result_files[$i]['orf_type_dom'] != "jpg") {
                                                                ?>
                                                                <!-- <div class="float-left" style=""> -->
                                                                <div class="col-md-3" style="">
                                                                    <img id="selected_configurator_picture<?php echo $result_files[$i]['orf_id'] ?>" src="<?php
                                                                    for ($p = 0; $p < count($configurator_pictures); $p++) {
                                                                        if ($pict_categ_name_array[0] == $configurator_pictures[$p]['orf_id']) {
                                                                            $countMainImage++;
                                                                            echo $base_url . "result_thumbnail_files/" . $configurator_pictures[$p]['orf_thumbnail_path'];
                                                                        }
                                                                    }
                                                                    ?>" alt="Choose main picture" class="configurator_pictures <?php if ($countMainImage === 0) echo 'broken_image_main' ?>" style="width:50px;height:50px;">
                                                                    <script type="text/javascript">
                                                                        <?php
                                                                        if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                                                        {
                                                                        ?>
                                                                        $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                                                                            $('#picture_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                                                                        });

                                                                        $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').hover(function () {
                                                                            $(this).css('cursor', 'pointer');
                                                                        });
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </script>
                                                                </div>
                                                                <!-- <div class="float-right" style="display: flex;"> -->
                                                                <div class="col-md-auto text-truncate">

                                                                    <div id="change_existing_classification<?php echo $result_files[$i]['orf_id'] ?>" class="existing_classification">
                                                                        <?php
                                                                        if (!empty($result_files[$i]['config_level'])) {
                                                                            $picture_area = $prod->get_picture_area($result_files[$i]['config_level']);
                                                                            echo (!empty($picture_area['pa_description'])) ? $picture_area['pa_description'] : "Classify ?";
                                                                        } else {
                                                                            echo "Classify ?";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <script type="text/javascript">
                                                                        $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').hover(function () {

                                                                            $(this).css('cursor', 'pointer');

                                                                        });

                                                                    </script>
                                                                    <input type="hidden" name="pa_id" id="pa_id<?php echo $result_files[$i]['orf_id'] ?>" value="<?php echo $result_files[$i]['config_level']; ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <img id="selected_shape_picture<?php echo $result_files[$i]['orf_id']; ?>" src="<?php
                                                                    $door_shapes_pictures = $prod->get_all_door_shapes();

                                                                    for ($p = 0; $p < count($door_shapes_pictures); $p++) {
                                                                        if ($pict_categ_name_array[1] == $door_shapes_pictures[$p]['dsp_id']) {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/" . $door_shapes_pictures[$p]['dsp_pic'];
                                                                        }
                                                                    }

                                                                    $roof_shapes_pictures = $prod->get_all_roof_shapes();

                                                                    for ($p = 0; $p < count($roof_shapes_pictures); $p++) {
                                                                        if ($pict_categ_name_array[1] == $roof_shapes_pictures[$p]['rs_id']) {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/" . $roof_shapes_pictures[$p]['rs_pic'];
                                                                        }
                                                                    }

                                                                    $gutters_shapes_pictures = $prod->get_all_gutters();

                                                                    for ($p = 0; $p < count($gutters_shapes_pictures); $p++) {
                                                                        if ($pict_categ_name_array[1] == $gutters_shapes_pictures[$p]['gut_id']) {
                                                                            $countDoorShapeImage++;
                                                                            echo "https://domenia.blue7.it/" . $gutters_shapes_pictures[$p]['gut_pic'];
                                                                        }
                                                                    }
                                                                    ?>" alt="<?php

                                                                    if (strpos($o_results_configurator_plus['pa_symbol'], "_org") === false) {
                                                                        echo ucfirst($o_results_configurator_plus['pa_symbol']);
                                                                    } elseif (strpos($o_results_configurator_plus['pa_symbol'], "_org") !== false) {
                                                                        echo "Original";
                                                                    } else {
                                                                        echo "What is it ?";
                                                                    } ?>" class="door_shapes <?php
                                                                    if ($countDoorShapeImage === 0) echo 'broken_door_shape_image' ?>" data-pa_id="<?php echo $$o_results_configurator_plus['pa_id']; ?>" style="width:50px;height:50px;" whidth="50" height="50">
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
                                                                $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').click(function () {
                                                                    $('#existing_classifyModal<?php echo $result_files[$i]['orf_id'];?>').modal('show');
                                                                });
                                                            </script>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="existing_classifyModal<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="existing_classifyModalLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
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
                                                                            $all_classifications = $prod->get_all_picture_areas();
                                                                            $classification_counter = 0;
                                                                            for ($s = 0; $s < count($all_classifications); $s++) {
                                                                                if (substr($all_classifications[$s]['pa_id'], -1) == "1") {
                                                                                    ?>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input" type="radio" name="pa_id[]" id="existing_pa_id_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $classification_counter; ?>" value="<?php
                                                                                                echo $all_classifications[$s]['pa_id']; ?>" data-pa_description="<?php echo $all_classifications[$s]['pa_description']; ?>" <?php
                                                                                                echo ($all_classifications[$s]['pa_id'] == $result_files[$i]['config_level']) ? "checked" : "";
                                                                                                ?>>
                                                                                                <label class="form-check-label" for="existing_pa_id_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $classification_counter; ?>">
                                                                                                    <?php echo $all_classifications[$s]['pa_id']; ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <?php echo $all_classifications[$s]['pa_description']; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <script type="text/javascript">
                                                                                        $('#existing_pa_id_<?php echo $result_files[$i]['orf_id'];?>_<?php echo $classification_counter;?>').click(function () {
                                                                                            let pa_id = $(this).val();
                                                                                            let pa_description = $(this).data('pa_description');
                                                                                            let o_id =<?php echo $o_id;?>;
                                                                                            let osub_id = "<?php echo $osub_id;?>";
                                                                                            let prod_id = "<?php echo $prod_id;?>";
                                                                                            let orf_id =<?php echo $result_files[$i]['orf_id'];?>;

                                                                                            $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').text(pa_description);
                                                                                            $('#pa_id<?php echo $result_files[$i]['orf_id']?>').val(pa_id);

                                                                                            $.ajax({
                                                                                                url: "<?php echo $base_url;?>ajax/update_orf_id_config_level.php",
                                                                                                method: "post",
                                                                                                data: {o_id: o_id, osub_id: osub_id, prod_id: prod_id, orf_id: orf_id, config_level: pa_id},
                                                                                                dataType: "html",
                                                                                                success: function (data) {


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
                                                                            $configurator_pictures = $prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);

                                                                            for ($p = 0; $p < count($configurator_pictures); $p++) {
                                                                                ?>
                                                                                <div class="row p-3">
                                                                                    <div class="col-md-6">
                                                                                        <img id="configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id']; ?>" class="configurator_pictures <?php if ($pict_categ_name_array[0] == $configurator_pictures[$p]['orf_id']) {
                                                                                            echo "configurator_pictures_clicked";
                                                                                        } ?>" src="<?php echo $base_url . "result_thumbnail_files/" . $configurator_pictures[$p]['orf_thumbnail_path']; ?>" data-orf_id="<?php echo $configurator_pictures[$p]['orf_id']; ?>" alt="No picture">
                                                                                        <script type="text/javascript">


                                                                                            $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');

                                                                                            });

                                                                                            $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').click(function () {

                                                                                                $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').attr('value', $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').data('orf_id'));

                                                                                                $('.configurator_pictures').removeClass('configurator_pictures_clicked');
                                                                                                $(this).addClass('configurator_pictures_clicked');


                                                                                                let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".dsp_002";
                                                                                                //let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                                                                let img_categ = img_categ1;


                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                        img_categ: img_categ
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function () {

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
                                                                                    if ($result_files[$i]['config_level'] == "pa0000") {

                                                                                        ?>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Interior" data-base_render_id="interior" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Interior
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Exterior" data-base_render_id="exterior" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Exterior
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">
                                                                                            $('.original_shape').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');
                                                                                            });
                                                                                        </script>
                                                                                        <br>
                                                                                        <script type="text/javascript">
                                                                                            $('.shape_pictures').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');
                                                                                            });

                                                                                            $('.shape_pictures').click(function () {
                                                                                                let srcValue = $(this).attr('src');
                                                                                                let altValue = $(this).attr('alt');

                                                                                                // $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
                                                                                                // $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
                                                                                                // $('#chosen_shape_id<?php echo $f;?>').val($(this).data('base_render_id'));

                                                                                                $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                $(this).addClass('shape_pictures_clicked');


                                                                                                //let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                let img_categ2 = $(this).data('base_render_id');
                                                                                                let orf_id = $(this).data('orf_id');


                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id: orf_id,
                                                                                                        img_categ: img_categ2
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function () {


                                                                                                    $('#selected_shape_picture' + orf_id).attr('src', srcValue);
                                                                                                    $('#selected_shape_picture' + orf_id).attr('alt', altValue);

                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id: orf_id,
                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                            osub_id: "<?php echo $osub_id;?>",
                                                                                                            prod_id: "<?php echo $prod_id;?>",
                                                                                                            pa_symbol: img_categ2,
                                                                                                            connected_to: 0,
                                                                                                            pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function () {


                                                                                                    });

                                                                                                });

                                                                                                // $('#new_upload_btn').removeClass('btn-default');
                                                                                                // $('#new_upload_btn').addClass('btn-success');
                                                                                                // $("#new_upload_btn").prop("disabled", false);
                                                                                            });

                                                                                        </script>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0001") {

                                                                                        ?>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Interior" data-base_render_id="interior" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Interior
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Exterior" data-base_render_id="exterior" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Exterior
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">
                                                                                            $('.original_shape').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');
                                                                                            });
                                                                                        </script>
                                                                                        <br>
                                                                                        <script type="text/javascript">
                                                                                            $('.shape_pictures').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');
                                                                                            });

                                                                                            $('.shape_pictures').click(function () {
                                                                                                let srcValue = $(this).attr('src');
                                                                                                let altValue = $(this).attr('alt');

                                                                                                // $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
                                                                                                // $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
                                                                                                // $('#chosen_shape_id<?php echo $f;?>').val($(this).data('base_render_id'));

                                                                                                $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                $(this).addClass('shape_pictures_clicked');


                                                                                                //let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                                let img_categ2 = $(this).data('base_render_id');
                                                                                                let orf_id = $(this).data('orf_id');


                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id: orf_id,
                                                                                                        img_categ: img_categ2
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function () {


                                                                                                    $('#selected_shape_picture' + orf_id).attr('src', srcValue);
                                                                                                    $('#selected_shape_picture' + orf_id).attr('alt', altValue);

                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id: orf_id,
                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                            osub_id: "<?php echo $osub_id;?>",
                                                                                                            prod_id: "<?php echo $prod_id;?>",
                                                                                                            pa_symbol: img_categ2,
                                                                                                            connected_to: 0,
                                                                                                            pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function () {


                                                                                                    });

                                                                                                });


                                                                                            });

                                                                                        </script>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0110") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'wall_area_main_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0111") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'wall_area_main_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0120") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'wall_area_2_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0121") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'wall_area_2_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0130") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'wall_area_3_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0131") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'wall_area_3_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0140") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'floor_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0141") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'floor_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0180") {
                                                                                        $door_shape_pictures = $prod->get_all_door_shapes();
                                                                                        $door_shape_counter = 0;
                                                                                        for ($p = 0; $p < count($door_shape_pictures); $p++) {
                                                                                            if (($door_shape_pictures[$p]['dsp_color_db'] == "blue dark") && (!empty($door_shape_pictures[$p]['dsp_pic'])) && ($door_shape_counter < 4)) {
                                                                                                ?>
                                                                                                <div class="row p-3">
                                                                                                    <div class="col-md-6">
                                                                                                        <img id="door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php
                                                                                                        echo $door_shape_pictures[$p]['dsp_id']; ?>" class="door_shape_pictures <?php
                                                                                                        if ($pict_categ_name_array[1] == $door_shape_pictures[$p]['dsp_id']) {
                                                                                                            echo "door_shape_pictures_clicked";
                                                                                                        } ?>" src="<?php
                                                                                                        echo "https://domenia.blue7.it/" . $door_shape_pictures[$p]['dsp_pic']; ?>" data-dsp_id="<?php
                                                                                                        echo $door_shape_pictures[$p]['dsp_id']; ?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                                        <script type="text/javascript">


                                                                                                            $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').hover(function () {
                                                                                                                $(this).css('cursor', 'pointer');

                                                                                                            });

                                                                                                            $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').click(function () {

                                                                                                                //$('#selected_door_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('value',$('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').data('dsp_id'));

                                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                                $(this).addClass('door_shape_pictures_clicked');


                                                                                                                let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                                let img_categ2 = $(this).data('dsp_id');
                                                                                                                let img_categ = img_categ1 + img_categ2;


                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                                    method: "post",
                                                                                                                    data: {
                                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                        img_categ: img_categ
                                                                                                                    },
                                                                                                                    dataType: "html",
                                                                                                                    success: function (data) {

                                                                                                                    }
                                                                                                                }).done(function () {

                                                                                                                    let srcValue = $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').attr('src');
                                                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                                    $.ajax({
                                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                        method: "post",
                                                                                                                        data: {
                                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                                            osub_id: "<?php echo $osub_id;?>",
                                                                                                                            prod_id: "<?php echo $prod_id;?>",
                                                                                                                            pa_symbol: img_categ2,
                                                                                                                            connected_to: img_categ1,
                                                                                                                            pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                        },
                                                                                                                        dataType: "html",
                                                                                                                        success: function (data) {

                                                                                                                        }
                                                                                                                    }).done(function () {


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

                                                                                    if ($result_files[$i]['config_level'] == "pa0181") {
                                                                                        $door_shape_pictures = $prod->get_all_door_shapes();
                                                                                        $door_shape_counter = 0;
                                                                                        for ($p = 0; $p < count($door_shape_pictures); $p++) {
                                                                                            if (($door_shape_pictures[$p]['dsp_color_db'] == "blue dark") && (!empty($door_shape_pictures[$p]['dsp_pic'])) && ($door_shape_counter < 4)) {
                                                                                                ?>
                                                                                                <div class="row p-3">
                                                                                                    <div class="col-md-6">
                                                                                                        <img id="door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php
                                                                                                        echo $door_shape_pictures[$p]['dsp_id']; ?>" class="door_shape_pictures <?php
                                                                                                        if ($pict_categ_name_array[1] == $door_shape_pictures[$p]['dsp_id']) {
                                                                                                            echo "door_shape_pictures_clicked";
                                                                                                        } ?>" src="<?php
                                                                                                        echo "https://domenia.blue7.it/" . $door_shape_pictures[$p]['dsp_pic']; ?>" data-dsp_id="<?php
                                                                                                        echo $door_shape_pictures[$p]['dsp_id']; ?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                                        <script type="text/javascript">


                                                                                                            $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').hover(function () {
                                                                                                                $(this).css('cursor', 'pointer');

                                                                                                            });

                                                                                                            $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').click(function () {

                                                                                                                //$('#selected_door_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('value',$('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').data('dsp_id'));

                                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                                $(this).addClass('door_shape_pictures_clicked');


                                                                                                                let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                                let img_categ2 = $(this).data('dsp_id');
                                                                                                                let img_categ = img_categ1 + img_categ2;


                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                                    method: "post",
                                                                                                                    data: {
                                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                        img_categ: img_categ
                                                                                                                    },
                                                                                                                    dataType: "html",
                                                                                                                    success: function (data) {

                                                                                                                    }
                                                                                                                }).done(function () {

                                                                                                                    let srcValue = $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').attr('src');
                                                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                                    $.ajax({
                                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                                        method: "post",
                                                                                                                        data: {
                                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                                            osub_id: "<?php echo $osub_id;?>",
                                                                                                                            prod_id: "<?php echo $prod_id;?>",
                                                                                                                            pa_symbol: img_categ2,
                                                                                                                            connected_to: img_categ1,
                                                                                                                            pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                        },
                                                                                                                        dataType: "html",
                                                                                                                        success: function (data) {

                                                                                                                        }
                                                                                                                    }).done(function () {


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

                                                                                    if ($result_files[$i]['config_level'] == "pa0170") {
                                                                                        $roof_shape_pictures = $prod->get_all_roof_shapes();

                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });


                                                                                                    $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'rs_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php
                                                                                    for ($r = 0;
                                                                                    $r < count($roof_shape_pictures);
                                                                                    $r++)
                                                                                    {
                                                                                    ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">

                                                                                                <img id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id']; ?>" src="<?php
                                                                                                echo "https://domenia.blue7.it/" . $roof_shape_pictures[$r]['rs_pic']; ?>" data-rs_id="<?php
                                                                                                echo $roof_shape_pictures[$r]['rs_id']; ?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">


                                                                                            $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');

                                                                                            });

                                                                                            $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').click(function () {


                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                $(this).addClass('door_shape_pictures_clicked');


                                                                                                let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                let img_categ2 = $(this).data('rs_id');
                                                                                                let img_categ = img_categ1 + img_categ2;


                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                        img_categ: img_categ
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function () {

                                                                                                    let srcValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').attr('src');
                                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                            osub_id: "<?php echo $osub_id;?>",
                                                                                                            prod_id: "<?php echo $prod_id;?>",
                                                                                                            pa_symbol: img_categ2,
                                                                                                            connected_to: img_categ1,
                                                                                                            pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function () {


                                                                                                    });

                                                                                                });

                                                                                            });

                                                                                        </script>
                                                                                        <?php

                                                                                    }
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0171") {
                                                                                        $roof_shape_pictures = $prod->get_all_roof_shapes();

                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });


                                                                                                    $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'rs_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                        /*
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

                                                                                        }*/
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0150") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'skirting_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0151") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#skirting_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_skirting_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'skirting_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0160") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'electric_switches_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0161") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#electric_switches_picture_<?php echo $result_files[$i]['orf_id']; ?>_electric_switches_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'electric_switches_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0190") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'window_frames_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0191") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#window_frames_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_frames_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'window_frames_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0200") {
                                                                                        $gutters_shape_pictures = $prod->get_all_gutters();

                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });


                                                                                                    $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'gut_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php
                                                                                    for ($r = 0;
                                                                                    $r < count($gutters_shape_pictures);
                                                                                    $r++)
                                                                                    {
                                                                                    ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">

                                                                                                <img id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id']; ?>" src="<?php
                                                                                                echo "https://domenia.blue7.it/" . $gutters_shape_pictures[$r]['gut_pic']; ?>" data-gut_id="<?php
                                                                                                echo $gutters_shape_pictures[$r]['gut_id']; ?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">


                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');

                                                                                            });

                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').click(function () {


                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                $(this).addClass('door_shape_pictures_clicked');


                                                                                                let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                let img_categ2 = $(this).data('gut_id');
                                                                                                let img_categ = img_categ1 + img_categ2;


                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                        img_categ: img_categ
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function () {

                                                                                                    let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').attr('src');
                                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                            osub_id: "<?php echo $osub_id;?>",
                                                                                                            prod_id: "<?php echo $prod_id;?>",
                                                                                                            pa_symbol: img_categ2,
                                                                                                            connected_to: img_categ1,
                                                                                                            pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function () {


                                                                                                    });

                                                                                                });

                                                                                            });

                                                                                        </script>
                                                                                        <?php

                                                                                    }
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0201") {
                                                                                        $gutters_shape_pictures = $prod->get_all_gutters();

                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });


                                                                                                    $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'gut_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php
                                                                                    for ($r = 0;
                                                                                    $r < count($gutters_shape_pictures);
                                                                                    $r++)
                                                                                    {
                                                                                    ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">

                                                                                                <img id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id']; ?>" src="<?php
                                                                                                echo "https://domenia.blue7.it/" . $gutters_shape_pictures[$r]['gut_pic']; ?>" data-gut_id="<?php
                                                                                                echo $gutters_shape_pictures[$r]['gut_id']; ?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <script type="text/javascript">


                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').hover(function () {
                                                                                                $(this).css('cursor', 'pointer');

                                                                                            });

                                                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').click(function () {


                                                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                                                $(this).addClass('door_shape_pictures_clicked');


                                                                                                let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                let img_categ2 = $(this).data('gut_id');
                                                                                                let img_categ = img_categ1 + img_categ2;


                                                                                                $.ajax({
                                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                    method: "post",
                                                                                                    data: {
                                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                        img_categ: img_categ
                                                                                                    },
                                                                                                    dataType: "html",
                                                                                                    success: function (data) {

                                                                                                    }
                                                                                                }).done(function () {

                                                                                                    let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').attr('src');
                                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                                    $.ajax({
                                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                                        method: "post",
                                                                                                        data: {
                                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                            o_id:<?php echo $o_id;?>,
                                                                                                            osub_id: "<?php echo $osub_id;?>",
                                                                                                            prod_id: "<?php echo $prod_id;?>",
                                                                                                            pa_symbol: img_categ2,
                                                                                                            connected_to: img_categ1,
                                                                                                            pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                        },
                                                                                                        dataType: "html",
                                                                                                        success: function (data) {

                                                                                                        }
                                                                                                    }).done(function () {


                                                                                                    });

                                                                                                });

                                                                                            });

                                                                                        </script>
                                                                                        <?php

                                                                                    }
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0210") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'window_sills_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa0211") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#window_sills_picture_<?php echo $result_files[$i]['orf_id']; ?>_window_sills_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'window_sills_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1010") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_1_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1011") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_1_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1020") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_2_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1021") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_2_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1030") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_3_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1031") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_3_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1040") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_4_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1041") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_4_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1050") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_5_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1051") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_5_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_5_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_5_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1060") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_6_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1061") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_6_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_6_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_6_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1070") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_7_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


                                                                                                            });

                                                                                                        });

                                                                                                    });

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }

                                                                                    if ($result_files[$i]['config_level'] == "pa1071") {
                                                                                        ?>
                                                                                        <div class="row p-3">
                                                                                            <div class="col-md-6">
                                                                                                <div id="extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                                                    Original
                                                                                                </div>
                                                                                                <script type="text/javascript">
                                                                                                    $('.original_shape').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');
                                                                                                    });

                                                                                                    $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').hover(function () {
                                                                                                        $(this).css('cursor', 'pointer');

                                                                                                    });

                                                                                                    $('#extra_layer_7_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_7_org').click(function () {


                                                                                                        $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                                                        $(this).addClass('shape_pictures_clicked');


                                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".";
                                                                                                        let img_categ2 = 'extra_layer_7_org';
                                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                                        $.ajax({
                                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                                            method: "post",
                                                                                                            data: {
                                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                                img_categ: img_categ
                                                                                                            },
                                                                                                            dataType: "html",
                                                                                                            success: function (data) {

                                                                                                            }
                                                                                                        }).done(function () {

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
                                                                                                                    osub_id: "<?php echo $osub_id;?>",
                                                                                                                    prod_id: "<?php echo $prod_id;?>",
                                                                                                                    pa_symbol: img_categ2,
                                                                                                                    connected_to: img_categ1,
                                                                                                                    pa_id: "<?php echo $result_files[$i]['config_level'];?>"
                                                                                                                },
                                                                                                                dataType: "html",
                                                                                                                success: function (data) {

                                                                                                                }
                                                                                                            }).done(function () {


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
                                                    } elseif (substr($result_files[$i]['prod_id'], -1) === 'z') {
                                                        $pict_categ_name_array = explode(".", $result_files[$i]['pict_categ_name']);
                                                        ?>
                                                        <input id="img_categ_part2<?php echo $result_files[$i]['orf_id']; ?>" class="form-control" type="text" value="<?php echo $pict_categ_name_array[2]; ?>" style="">
                                                        <?php
                                                    } else {
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
                                                            ($result_files[$i]['prod_id'] == "p1863") || ($result_files[$i]['prod_id'] == "p1883")) {
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

                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').hover(function () {
                                                        $(this).css('cursor', 'pointer');
                                                    });
                                                    <?php
                                                    }
                                                    ?>
                                                    $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').on("keyup focusout change", function () {

                                                        <?php
                                                        if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                                        {
                                                        ?>
                                                        let img_categ = $(this).val() + ".total";
                                                        <?php
                                                        }
                                                        elseif(substr($result_files[$i]['prod_id'], -1) === 'z')
                                                        {
                                                        ?>
                                                        let img_categ1 = $(this).val() + ".colors.";
                                                        let img_categ2 = $('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                        let img_categ = img_categ1 + img_categ2;
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        let img_categ = $(this).val();
                                                        <?php
                                                        }
                                                        ?>
                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                            method: "post",
                                                            data: {
                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                img_categ: img_categ
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

                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".colors.";
                                                        let img_categ2 = $('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                        let img_categ = img_categ1 + img_categ2;

                                                        $.ajax({
                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                            method: "post",
                                                            data: {
                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                img_categ: img_categ
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
                                                if (
                                                        ((substr($prod_id, 1) > 1100) && (substr($prod_id, 1) < 1160)) ||
                                                        ((substr($prod_id, 1) > 1299) && (substr($prod_id, 1) < 1360)) ||
                                                        ((substr($prod_id, 1) > 1499) && (substr($prod_id, 1) < 1560)) ||
                                                        ((substr($prod_id, 1) > 1599) && (substr($prod_id, 1) < 1660)) ||
                                                        ((substr($prod_id, 1) > 1699) && (substr($prod_id, 1) < 1760)) ||
                                                        ((substr($prod_id, 1) > 1799) && (substr($prod_id, 1) < 1860)) ||
                                                        (substr($prod_id, -2) == "2y")
                                                ) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <b>Assign to room number:</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control form-control-sm" id="room_id<?php echo $result_files[$i]['orf_id']; ?>" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" name="room_id">
                                                                <option value="0">Unspecified</option>
                                                                <?php
                                                                $rooms_data['o_id'] = $o_id;
                                                                $rooms_data['osub_id'] = $osub_id;

                                                                $rooms = $prod->get_all_rooms_for_this_sub_id(json_encode($rooms_data));

                                                                for ($r = 0; $r < count($rooms); $r++) {
                                                                    ?>
                                                                    <option value="<?php echo $rooms[$r]['room_id']; ?>" <?php echo ($rooms[$r]['room_id'] == $result_files[$i]['room_id']) ? "selected" : ""; ?>><?php
                                                                        echo $rooms[$r]['room_number'] . " - ";
                                                                        echo $translation = $prod->get_translation_text(1, $rooms[$r]['rk_id'])['text'];
                                                                        ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <script type="text/javascript">
                                                                $('#room_id<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                    let orf_id = $(this).data('orf_id');
                                                                    let room_id = $(this).val();

                                                                    $.ajax({
                                                                        url: "../ajax/assign_room_id_to_result_file.php",
                                                                        method: "post",
                                                                        data: {
                                                                            orf_id: orf_id,
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
                                                if (
                                                        (substr($prod_id, -2) == "6b") || (substr($prod_id, -2) == "gb")
                                                ) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <b>Assign to perspective:</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control form-control-sm" id="per_id<?php echo $result_files[$i]['orf_id']; ?>" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" name="per_id">
                                                                <option value="0">Unspecified</option>
                                                                <?php
                                                                $perspective_data['o_id'] = $o_id;
                                                                $perspective_data['osub_id'] = $osub_id;

                                                                $perspective = $prod->get_all_perspectives_for_this_sub_id(json_encode($perspective_data));

                                                                for ($r = 0; $r < count($perspective); $r++) {
                                                                    ?>
                                                                    <option value="<?php echo $perspective[$r]['per_id']; ?>" <?php echo ($perspective[$r]['per_id'] == $result_files[$i]['per_id']) ? "selected" : ""; ?>><?php
                                                                        echo $perspective[$r]['per_kind'];
                                                                        ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <script type="text/javascript">
                                                                $('#per_id<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                    let orf_id = $(this).data('orf_id');
                                                                    let per_id = $(this).val();

                                                                    $.ajax({
                                                                        url: "../ajax/assign_per_id_to_result_file.php",
                                                                        method: "post",
                                                                        data: {
                                                                            orf_id: orf_id,
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
                                                            if (substr($result_files[$i]['prod_id'], -1) === 'y') {
                                                                echo $result_files[$i]['orf_id'];
                                                            } ?>
                                                            <div id="image_tooltip_container_<?php
                                                            echo $image_preview_counter;
                                                            ?>">
                                                                <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                                     src="../result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                                                     alt="<?php echo $result_files[$i]['orf_name']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo $filesize = $prod->filesize_formatted("../result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']); ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else { ?>

                                                    <?php
                                                    $file_path = $result_files[$i]['orf_internal_name_dom'];

                                                    // Get the file extension
                                                    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

                                                    // Define an array of supported file extensions and their corresponding icon filenames
                                                    $extension_icons = [
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
                                                            'txt' => 'txt_icon.jpg',
                                                        // Add more extensions and their corresponding icons as needed
                                                    ];

                                                    // Check if the file extension is in the extension_icons array
                                                    if (array_key_exists($file_extension, $extension_icons)) {
                                                        // Construct the src attribute with the corresponding icon filename
                                                        $icon_src = "img/" . $extension_icons[$file_extension];
                                                        // Output the img tag with the constructed src attribute
                                                        echo "<img class='img-responsive' style='width:60px;cursor:pointer;' src='../$icon_src' alt='File icon'>";
                                                    } else {
                                                        // If the file extension is not supported, use a default icon
                                                        echo "<img class='img-responsive' style='width:60px;cursor:pointer;' src='img/default-icon.png' alt='Default file icon'>";
                                                    }
                                                    ?>

                                                    <?php echo $filesize = $prod->filesize_formatted("../result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']); ?>
                                                <?php }
                                                ?>
                                                <form name="deletecreatorfile"
                                                      action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>"
                                                      method="post">
                                                    <input type="hidden" name="orf_id"
                                                           value="<?php echo $result_files[$i]['orf_id']; ?>">

                                                    <a href="../image.php?filecategory=creatorfiles&orfid=<?php echo $result_files[$i]['orf_id']; ?>"
                                                       alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                                       class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-down mr-2"></i>Download</a>

                                                    <button type="button" id="res_delete_btn<?php echo $result_files[$i]['orf_id']; ?>" name="res_delete_btn" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i></button>
                                                    <script type="text/javascript">
                                                        $('#res_delete_btn<?php echo $result_files[$i]['orf_id']; ?>').click(function () {
                                                            let orf_id = $(this).data("orf_id");

                                                            if (confirm('Are you sure want do delete ?')) {

                                                                $.ajax({
                                                                    url: "../ajax/delete_result_file.php",
                                                                    method: "post",
                                                                    data: {orf_id: orf_id},
                                                                    dataType: "html",
                                                                    success: function (data) {
                                                                        $('#result_file_row<?php echo $result_files[$i]['orf_id']; ?>').fadeOut(3000);
                                                                    }
                                                                });

                                                            }
                                                        });
                                                    </script>
                                                </form>


                                            </div>
                                            <div class="col-md-2 border-right border-dark px-0 py-1 flex-column d-flex px-4">
                                                <?php
                                                if (substr($result_files[$i]['prod_id'], -1) === 'z') {
                                                    $configurator_pictures = $prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                                    $pict_categ_name_array = explode(".", $result_files[$i]['pict_categ_name']);

                                                    ?>
                                                    <img id="selected_configurator_picture<?php echo $result_files[$i]['orf_id'] ?>" src="<?php
                                                    for ($p = 0; $p < count($configurator_pictures); $p++) {
                                                        if ($pict_categ_name_array[0] == $configurator_pictures[$p]['orf_id']) {
                                                            echo $base_url . "result_thumbnail_files/" . $configurator_pictures[$p]['orf_thumbnail_path'];
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
                                                                    $configurator_pictures = $prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);

                                                                    for ($p = 0; $p < count($configurator_pictures); $p++) {
                                                                        ?>
                                                                        <div class="row p-3">
                                                                            <div class="col-md-6">
                                                                                <img id="configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id']; ?>" class="configurator_pictures <?php if ($pict_categ_name_array[0] == $configurator_pictures[$p]['orf_id']) {
                                                                                    echo "configurator_pictures_clicked";
                                                                                } ?>" src="<?php echo $base_url . "result_thumbnail_files/" . $configurator_pictures[$p]['orf_thumbnail_path']; ?>" data-orf_id="<?php echo $configurator_pictures[$p]['orf_id']; ?>" alt="No picture">
                                                                                <script type="text/javascript">


                                                                                    $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').hover(function () {
                                                                                        $(this).css('cursor', 'pointer');

                                                                                    });

                                                                                    $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').click(function () {

                                                                                        $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').attr('value', $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').data('orf_id'));

                                                                                        $('.configurator_pictures').removeClass('configurator_pictures_clicked');
                                                                                        $(this).addClass('configurator_pictures_clicked');


                                                                                        let img_categ1 = $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val() + ".colors.";
                                                                                        let img_categ2 = $('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                                                        let img_categ = img_categ1 + img_categ2;


                                                                                        $.ajax({
                                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                            method: "post",
                                                                                            data: {
                                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                                img_categ: img_categ
                                                                                            },
                                                                                            dataType: "html",
                                                                                            success: function (data) {

                                                                                            }
                                                                                        }).done(function () {

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
                                                        if((substr($result_files[$i]['prod_id'], -1) === 'z') || (substr($result_files[$i]['prod_id'], -1) === 'y'))
                                                        {
                                                        ?>
                                                        $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                                                            $('#picture_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                                                        });

                                                        $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').hover(function () {
                                                            $(this).css('cursor', 'pointer');
                                                        });
                                                        <?php
                                                        }
                                                        ?>
                                                    </script>
                                                    <?php
                                                }

                                                if ((substr($prod_id, -1) !== '8') && (substr($prod_id, -1) !== '7')) {

                                                    if ($result_files[$i]['orf_type_dom'] == 'jpg' or $result_files[$i]['orf_type_dom'] == 'jpeg' or $result_files[$i]['orf_type_dom'] == 'png'): ?>
                                                        <?php if ($result_files[$i]['orf_compress_path']): ?>
                                                            <a target="_blank"
                                                               href="https://blue7.it/studio/result_compress_files/<?= $result_files[$i]['orf_compress_path'] ?>"
                                                               class="btn btn-primary btn-sm mt-2">Compressed file</a>
                                                            <?php echo $filesize = $prod->filesize_formatted("../result_compress_files/" . $result_files[$i]['orf_compress_path']); ?>
                                                        <?php else: ?>
                                                            <p class="text-danger text-sm">Please reupload file, compressed copy is
                                                                missing!</p>
                                                        <?php endif; ?>

                                                        <?php if (hasPromptForProduct($result_files[$i]['prod_id'])): ?>
                                                            <!-- AI Image Generation Button -->
                                                            <button class="btn btn-info btn-sm mt-auto mb-4 ai-modal-trigger"
                                                                    data-orf-id="<?php echo $result_files[$i]['orf_id']; ?>">
                                                                AI
                                                            </button>
                                                        <?php endif; ?>

                                                    <?php endif;
                                                } else {
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="orf_youtube_link<?php echo $result_files[$i]['orf_id']; ?>">www.youtube.com/embed/</label>
                                                        <input type="text" class="form-control form-control-sm" title="Add only the last 11 characters" placeholder="Add only the last 11 characters" id="orf_youtube_link<?php echo $result_files[$i]['orf_id']; ?>" name="orf_youtube_link<?php echo $result_files[$i]['orf_id']; ?>" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" value="<?php
                                                        if (!empty($result_files[$i]['orf_youtube_link'])) {
                                                            //echo $result_files[$i]['orf_youtube_link'];
                                                            $youtube_link = explode("/embed/", $result_files[$i]['orf_youtube_link']);
                                                            echo $youtube_link[1];
                                                        }
                                                        ?>">
                                                        <script type="text/javascript">
                                                            $('#orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                let orf_id = $(this).data('orf_id');
                                                                let orf_youtube_link = "";

                                                                if ($(this).val() != "") {
                                                                    orf_youtube_link = "https://www.youtube.com/embed/" + $(this).val();
                                                                }

                                                                $.ajax({
                                                                    url: "../ajax/change_youtube_link.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id: orf_id,
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
                                                        <label for="orf_vimeo_link<?php echo $result_files[$i]['orf_id']; ?>">player.vimeo.com/video/</label>
                                                        <input type="text" class="form-control form-control-sm" title="Add only the last 11 characters" placeholder="Add only the last 11 characters" id="orf_vimeo_link<?php echo $result_files[$i]['orf_id']; ?>" name="orf_vimeo_link<?php echo $result_files[$i]['orf_id']; ?>" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" value="<?php
                                                        if (!empty($result_files[$i]['orf_vimeo_link'])) {
                                                            //echo $result_files[$i]['orf_vimeo_link'];
                                                            $video_link = explode("/video/", $result_files[$i]['orf_vimeo_link']);
                                                            echo $video_link[1];
                                                        }
                                                        ?>">
                                                        <script type="text/javascript">
                                                            $('#orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                                                let orf_id = $(this).data('orf_id');
                                                                let orf_vimeo_link = "";

                                                                if ($(this).val() != "") {
                                                                    orf_vimeo_link = "https://player.vimeo.com/video/" + $(this).val();
                                                                }

                                                                $.ajax({
                                                                    url: "../ajax/change_vimeo_link.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id: orf_id,
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
                                                                    ($result_files[$i]['prod_id'] != "p186y") && ($result_files[$i]['prod_id'] != "p186z")) {
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

                                                            if (
                                                                    (substr($result_files[$i]['prod_id'], -1) == 'y') || (substr($result_files[$i]['prod_id'], -1) == 'z')
                                                            ) {
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
                                                                    url: "../ajax/change_results_file_visibility.php",
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
                                                                        } else if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 6) {
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("yellow");
                                                                        } else {
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
                                                        <input type="checkbox" id="result_file_verified<?php echo $result_files[$i]['orf_id']; ?>" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" name="result_file_verified" class="form-check-input" style="width:100%;height:20px;" title="Verified by creator" value="1" <?php
                                                        echo ($result_files[$i]['result_file_verified'] == 1) ? "checked" : "";
                                                        ?>>
                                                        <script type="text/javascript">

                                                            $('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').click(function () {

                                                                let orf_id = $(this).data('orf_id');
                                                                let result_file_verified = 0;

                                                                if ($('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').is(":checked")) {
                                                                    result_file_verified = 1;
                                                                }

                                                                $.ajax({
                                                                    url: "../ajax/change_result_file_verified.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id: orf_id,
                                                                        result_file_verified: result_file_verified
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {
                                                                        if ($('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').is(":checked")) {
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val(8);

                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("light-green");

                                                                            $.ajax({
                                                                                url: "../ajax/change_results_file_visibility.php",
                                                                                method: "get",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    orf_status: 8
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            });


                                                                        } else {
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val(0);

                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");

                                                                            $.ajax({
                                                                                url: "../ajax/change_results_file_visibility.php",
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
                                                if (($result_files[$i]['prod_id'] == "p1322") || ($result_files[$i]['prod_id'] == "1302")) {
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
                                                                        url: "../ajax/change_hover_file_visibility.php",
                                                                        method: "get",
                                                                        data: {
                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                            hover_status: $(this).val()
                                                                        },
                                                                        dataType: "html",
                                                                        success: function (data) {
                                                                            if (($('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8) {
                                                                                $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                                $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("red");
                                                                            } else {
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
                                                                        url: "../ajax/show_in_panorama_visibility.php",
                                                                        method: "get",
                                                                        data: {
                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                            show_in_panorama_status: $(this).val()
                                                                        },
                                                                        dataType: "html",
                                                                        success: function (data) {
                                                                            if (($('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').val()) == 8) {
                                                                                $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                                $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').addClass("red");
                                                                            } else {
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
                                                <div class="row" style="position:absolute;bottom:0;">
                                                    <div class="col-md-4">
                                                        <b>Building status</b>
                                                    </div>
                                                    <div class="col-md-4">
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
                                                                    ($result_files[$i]['prod_id'] != "p186y") && ($result_files[$i]['prod_id'] != "p186z")) {
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
                                                                    url: "../ajax/change_bd_status_file_visibility.php",
                                                                    method: "get",
                                                                    data: {
                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                        bd_status: $(this).val()
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {
                                                                        if (($('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8) {
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue-light");
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("blue");
                                                                        } else if (($('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 7) {
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue");
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("blue-light");
                                                                        } else {
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue");
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue-light");
                                                                            $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="col-md-2">
                                                    <a href="https://bauvorschau.com/production/<?php
                                                        if ($order['om_id'] == 0) {
                                                            echo $o_id;
                                                        } else {
                                                            echo $order['om_id'];
                                                        } 
                                                        if (
                                                            (substr($result_files[$i]['prod_id'], -2) === '02') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '03') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '04') ||
                                                            
                                                            (substr($result_files[$i]['prod_id'], -2) === '22') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '23') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '24') ||

                                                            
                                                            (substr($result_files[$i]['prod_id'], -2) === '42') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '43') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '44') ||

                                                            (substr($result_files[$i]['prod_id'], -2) === '62') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '63') ||
                                                            (substr($result_files[$i]['prod_id'], -2) === '64') 
                                                    ) 
                                                    {
                                                        echo "/tour/";
                                                    }
                                                    if (
                                                        (substr($result_files[$i]['prod_id'], -2) === '06') ||                                                       
                                                        
                                                        (substr($result_files[$i]['prod_id'], -2) === '26') ||
                                                        
                                                        (substr($result_files[$i]['prod_id'], -2) === '46') ||                                                       

                                                        (substr($result_files[$i]['prod_id'], -2) === '66') 
                                                       
                                                    ) 
                                                    {
                                                        echo "/panorama/";
                                                    }
                                                    if (
                                                        (substr($result_files[$i]['prod_id'], -2) === '07') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '08') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '27') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '28') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '47') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '48') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '67') ||
                                                        (substr($result_files[$i]['prod_id'], -2) === '68')
                                                    )
                                                    {
                                                        echo "/video/";
                                                    }

                                                    echo $osub_id . "/";
                                                    
                                                    $existing_token=$prod->get_token($_COOKIE['client_id']);
                                                    if(!empty($existing_token))
                                                    {
                                                        echo "/?token=" . $existing_token['token'];
                                                    }
                                                        ?>" target="_blank" class="btn btn-sm orange">Checkation</a>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <?php
                                            if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) {
                                                ?>
                                                <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                                                            class="img-responsive" style="width:900px;"
                                                            src="../result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
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

                        if (
                                (($prod_id != "p168s") || (substr($prod_id, -2) != "gs"))
                        ) {
                            if (substr($prod_id, -1) !== 'y') {
                                ?>
                                <div class="col-md-12">

                                    <div class="row w-100 mx-0 d-flex justify-content-center mt-3">
                                        <?php /*
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
                                                url: "../upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id']; ?>",
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

                                                    setTimeout(function () {

                                                        var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                                        window.location.href = redirectToURL;
                                                        window.location.reload(true);

                                                    }, 1000);
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


                                    </script> */ ?>
                                        <div class="col-md-8" style="display: flex; align-items: center;">
                                            <form id="upload_result_files_form" name="upload_result_files_form" method="post" enctype="multipart/form-data"></form>
                                            <input type="file" name="myfile[]" class="form-control form-control-sm" form="upload_result_files_form" multiple>
                                        </div>
                                        <div class="col-md-4">
                                            <button id="start_upload_btn" type="button" class="btn btn-sm btn-success">Start upload</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="loading_spinner" class="d-none">
                                            <img src="<?php echo $base_url; ?>img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
                                        </div>
                                        <div id="upload_result_files_message" class="text-center"></div>
                                    </div>
                                    <script type="text/javascript">
                                        $('#start_upload_btn').click(function () {

                                            $('#loading_spinner').removeClass('d-none');

                                            $('#upload_result_files_message').html("");
                                            let formData = new FormData($('#upload_result_files_form')[0]);

                                            $.ajax({

                                                url: "../upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id']; ?>",

                                                type: 'POST',

                                                data: formData,

                                                cache: false,

                                                processData: false,

                                                contentType: false,

                                                enctype: 'multipart/form-data',

                                                dataType: "html",

                                                success: function (data) {

                                                    console.log(data);

                                                }

                                            }).done(function (data) {


                                                html = data;

                                                $('#loading_spinner').addClass('d-none');

                                                $('#upload_result_files_message').html(html);
                                                $('#upload_result_files_message').fadeIn().delay('3000').fadeOut();
                                                setTimeout(function () {
                                                    var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                                    window.location.href = redirectToURL;
                                                    window.location.reload(true);
                                                }, 2000);

                                            });
                                        });
                                    </script>
                                </div>
                                <?php
                            }
                        }


                    } //end 6m 6t

                    if (substr($prod_id, -1) === 'y') //classification upload
                    {
                        ?>
                        <div class="col-md-12 border my-3 py-2">
                            <form name="new_upload_file" id="new_upload_file" method="post" enctype="multipart/form-data"></form>
                            <div id="new_uploaded_files">
                                <?php
                                for ($f = 0; $f < 3; $f++) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="file" name="myfile[]" class="form-control form-control-sm" form="new_upload_file">
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-sm btn-warning" id="classify_btn<?php echo $f; ?>" data-toggle="modal"
                                                    data-target="#classifyModal<?php echo $f; ?>">Classify
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="classifyModal<?php echo $f; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="classifyModalLabel<?php echo $f; ?>" aria-hidden="true">
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
                                                            $all_classifications = $prod->get_all_picture_areas();
                                                            $classification_counter = 0;
                                                            for ($s = 0; $s < count($all_classifications); $s++) {
                                                                if (substr($all_classifications[$s]['pa_id'], -1) == "1") {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio" name="pa_id[]" id="pa_id_<?php echo $f; ?>_<?php echo $classification_counter; ?>" value="<?php
                                                                                echo $all_classifications[$s]['pa_id']; ?>" data-pa_description="<?php echo $all_classifications[$s]['pa_description']; ?>">
                                                                                <label class="form-check-label" for="pa_id_<?php echo $f; ?>_<?php echo $classification_counter; ?>">
                                                                                    <?php echo $all_classifications[$s]['pa_id']; ?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <?php echo $all_classifications[$s]['pa_description']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <script type="text/javascript">
                                                                        $('#pa_id_<?php echo $f;?>_<?php echo $classification_counter;?>').click(function () {
                                                                            let pa_id = $(this).val();
                                                                            let pa_description = $(this).data('pa_description');
                                                                            let f =<?php echo $f;?>;

                                                                            $('#chosen_clasification_text<?php echo $f;?>').text(pa_description);
                                                                            $('#chosen_classification_id<?php echo $f;?>').val(pa_id);

                                                                            if (pa_id == "pa0-10") {
                                                                                $('#what_btn<?php echo $f;?>').addClass('d-none');
                                                                                $('#main_img_btn<?php echo $f;?>').addClass('d-none');
                                                                                $('#new_upload_btn').removeClass('btn-default');
                                                                                $('#new_upload_btn').addClass('btn-success');
                                                                                $("#new_upload_btn").prop("disabled", false);
                                                                            } else {
                                                                                $('#what_btn<?php echo $f;?>').removeClass('d-none');
                                                                                $('#main_img_btn<?php echo $f;?>').removeClass('d-none');

                                                                                let mc_id =<?php echo $order['mc_id']?>;

                                                                                $.ajax({
                                                                                    url: "../ajax/get_u_clients_main_options_html.php",
                                                                                    method: "get",
                                                                                    data: {mc_id: mc_id, pa_id: pa_id, f: f},
                                                                                    dataType: "html",
                                                                                    success: function (data) {

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
                                            <div id="chosen_clasification_text<?php echo $f; ?>">
                                            </div>
                                            <input type="hidden" name="chosen_classification_id[]" id="chosen_classification_id<?php echo $f; ?>" value="" form="new_upload_file">
                                        </div>
                                        <div class="col-md-auto">
                                            <button class="btn btn-sm btn-warning d-none" id="what_btn<?php echo $f; ?>" data-toggle="modal"
                                                    data-target="#whatModal<?php echo $f; ?>">What shall be shown ?
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="whatModal<?php echo $f; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="whatModalLabel<?php echo $f; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="whatModalLabel<?php echo $f; ?>">Choose what shall be shown ?</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="what_option_is_it<?php echo $f; ?>">
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
                                            <img id="chosen_shape_img<?php echo $f; ?>" class="img-fluid" src="" alt="" style="width:60px;height:auto;">
                                            <input type="hidden" name="chosen_shape_id[]" id="chosen_shape_id<?php echo $f; ?>" value="" form="new_upload_file">
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-sm btn-warning d-none" id="main_img_btn<?php echo $f; ?>" data-toggle="modal"
                                                    data-target="#main_imgModal<?php echo $f; ?>">Main image
                                            </button>

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
                                                            $main_pictures = $prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);

                                                            for ($p = 0; $p < count($main_pictures); $p++) {
                                                                ?>
                                                                <div class="row p-3">
                                                                    <div class="col-md-6">
                                                                        <img id="main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id']; ?>" class="configurator_pictures <?php //if($pict_categ_name_array[0]==$main_pictures[$p]['orf_id']){echo "configurator_pictures_clicked";}
                                                                        ?>" src="<?php echo $base_url . "result_thumbnail_files/" . $main_pictures[$p]['orf_thumbnail_path']; ?>" data-orf_id="<?php echo $main_pictures[$p]['orf_id']; ?>" alt="No picture">
                                                                        <script type="text/javascript">


                                                                            $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').hover(function () {
                                                                                $(this).css('cursor', 'pointer');

                                                                            });

                                                                            $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').click(function () {


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
                                            <img id="chosen_main_img<?php echo $f; ?>" class="img-fluid" src="" style="width:60px;height:auto;">
                                            <input type="hidden" name="chosen_main_img_id[]" id="chosen_main_img_id<?php echo $f; ?>" value="" form="new_upload_file">
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
                                        <img src="<?php echo $base_url; ?>img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-sm btn-default" id="new_upload_btn" form="new_upload_file" type="button" disabled>Start Upload</button>
                                    <script type="text/javascript">
                                        $('#new_upload_btn').click(function () {
                                            $('#loading_spinner').removeClass('d-none');
                                            formData = new FormData($('#new_upload_file')[0]);

                                            $.ajax({
                                                url: "../upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id;?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id'];?>",
                                                type: 'POST',
                                                data: formData,
                                                cache: false,
                                                dataType: 'text',
                                                processData: false,
                                                contentType: false,
                                                enctype: 'multipart/form-data',
                                                dataType: "html",
                                                success: function (data) {
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
                                    $found_no_result_file = 0;

                                    for ($i = 0; $i < count($result_files); $i++) {
                                        if (($found_no_result_file == 0) && ($result_files[$i]['no_result_file'] == 1)) {
                                            echo "checked";
                                            $found_no_result_file++;
                                        }
                                    }
                                    ?>>
                                    <label class="form-check-label" for="no_result_file" style="width: fit-content;">No result file shall be uploaded</label>
                                    <script type="text/javascript">
                                        $('#no_result_file').click(function () {

                                            let o_id =<?php echo $o_id;?>;
                                            let osub_id = "<?php echo $osub_id; ?>";
                                            let prod_id = "<?php echo $prod_id;?>";
                                            let uca_id =<?php echo $_COOKIE['client_id'];?>;

                                            if ($(this).is(':checked')) {
                                                $.ajax({
                                                    url: "../ajax/create_no_result_file.php",
                                                    method: "post",
                                                    data: {o_id: o_id, osub_id: osub_id, prod_id: prod_id, uca_id: uca_id},
                                                    dataType: "html",
                                                    success: function (data) {

                                                    }
                                                });


                                            } else {
                                                $.ajax({
                                                    url: "../ajax/delete_no_result_file.php",
                                                    method: "post",
                                                    data: {o_id: o_id, osub_id: osub_id, prod_id: prod_id},
                                                    dataType: "html",
                                                    success: function (data) {

                                                    }
                                                });
                                            }

                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mx-0 w-100 border-top mt-5 border-dark dark-gray">
                        <div class="col-md-6 border-right border-dark pt-3">
                            <p class="w-100 text-center mb-0">Send message to creator: <?php
                                if (!empty($producer_name['c_first_name'])) {
                                    echo $producer_name['c_last_name'] . ", " . $producer_name['c_first_name'];
                                }
                                ?></p>
                            <form name="send_message" class="d-flex" method="post"
                                  action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>">
                                <input type="hidden" name="o_id" value="<?php echo $o_id; ?>">
                                <input type="hidden" name="osub_id" value="<?php echo $osub_id; ?>">
                                <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>">
                                <input type="hidden" name="user_id" value="<?= $_COOKIE['client_id']; ?>">
                                <!--<pre>
                    	<?php //print_r($_COOKIE);
                                ?>
                    </pre>-->
                                <?php
                                $messages = $prod->show_all_messages($o_id, $osub_id, $prod_id);

                                ?>
                                <div class="container all_messages">
                                    <div class="row mb-3">
                                        <div class="col-md-12 d-flex">
                                            <textarea class="form-control form-control-sm d-inline" name="message"
                                                      placeholder="Type message..." required></textarea>
                                            <button name="send_message_btn"
                                                    class="btn btn-sm btn-primary d-inline ml-2 align-self-center mb-4 mt-3">
                                                Send
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-0 mb-3" id="bottomChat">
                                        <?php
                                        for ($i = 0; $i < count($messages); $i++) {
                                            ?>
                                            <div class="row w-100 mx-0 p-2 text-center colorline2"
                                                 id="message_row_<?php echo $messages[$i]['msg_id']; ?>">
                                                <?php
                                                $user_name = $prod->get_client($messages[$i]['user_id']);
                                                ?>
                                                <div class="col-xs-11 pl-3">
                                                    <b><?php
                                                        if (!empty($user_name['c_last_name'])) {
                                                            echo $user_name['c_last_name'] . ", " . $user_name['c_first_name'];
                                                        } else {
                                                            echo $user_name['l_last_name'] . ", " . $user_name['l_first_name'];
                                                        } ?></b> (<?php echo $messages[$i]['date']; ?> UTC+0):
                                                    <span id="message_id_<?php echo $messages[$i]['msg_id']; ?>"><?php echo $messages[$i]['message']; ?></span>
                                                </div>
                                                <div class="col-xs-1">
                                                    <button type="button"
                                                            class="btn btn-sm btn-primary pr-0 pl-0 pt-0 pb-0 ml-3"
                                                            id="msg_btn_<?php echo $messages[$i]['msg_id']; ?>">Edit
                                                    </button>
                                                </div>
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
                                                            data-msg_id="<?php echo $messages[$i]['msg_id']; ?>">Save
                                                    </button>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $("#msg_btn_<?php echo $messages[$i]['msg_id'];?>").click(function () {
                                                    $("#message_row_<?php echo $messages[$i]['msg_id'];?>").removeClass().addClass("row w-100 mx-0 py-2 colorline2 d-none");
                                                    $("#new_row_message_<?php echo $messages[$i]['msg_id'];?>").removeClass().addClass("row w-100 mx-0 py-2 colorline2");
                                                    $("#new_message_<?php echo $messages[$i]['msg_id'];?>").val($("#message_id_<?php echo $messages[$i]['msg_id'];?>").text());
                                                });
                                                $("#new_msg_btn_<?php echo $messages[$i]['msg_id'];?>").click(function () {
                                                    $.ajax({
                                                        url: "../ajax/update_creator_message.php",
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
                                            </script>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 pt-3" style="display: flex; align-items: center; flex-direction: column-reverse; height: max-content;">
                            <!--                            <div class="row w-100 mx-0">-->
                            <!--                                <p class="w-100 mb-0 text-center"><b>Uploaded correction hints:</b></p>-->
                            <!--                            </div>-->
                            <!--                            <div class="row w-100 mx-0">-->
                            <!--                                <div class="col-md-6">-->
                            <!--                                  <p class="text-left pl-5 mb-0 w-100"><b>File name:</b></p>-->
                            <!--                                </div>-->
                            <!--                                <div class="col-md-3">-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <div class="" style="display: grid; grid-template-columns: 2fr 2fr;">
                                <?php
                                $correction_needed_files = $prod->get_correction_needed_files($o_id, $osub_id, $prod_id);

                                for ($j = 0; $j < count($correction_needed_files); $j++) {
                                    ?>

                                    <div class="row w-100 mx-0" style="flex-direction: column;height: min-content;  max-width: 14vw;">
                                        <div class="col-md-2 text-truncate" style="flex: unset !important; max-width: unset !important; text-align: left;">
                                            <?php
                                            echo $correction_needed_files[$j]['cnf_name'];
                                            ?>
                                        </div>
                                        <div class="col-md-3" style="max-width: 100% !important; margin-bottom:1vh;">
                                            <input type="text" id="cnf_custom_internal_name<?php echo $correction_needed_files[$j]['cnf_id']; ?>" class="form-control form-control-sm" placeholder="Internal name" value="<?php echo $correction_needed_files[$j]['cnf_custom_internal_name']; ?>">
                                            <script type="text/javascript">
                                                $('#cnf_custom_internal_name<?php echo $correction_needed_files[$j]['cnf_id'];?>').on('focusout', function () {

                                                    let cnf_id =<?php echo $correction_needed_files[$j]['cnf_id'];?>;
                                                    let cnf_custom_internal_name = $(this).val();

                                                    $.ajax({
                                                        url: "../ajax/update_cnf_custom_internal_name.php",
                                                        method: "post",
                                                        data: {cnf_id: cnf_id, cnf_custom_internal_name: cnf_custom_internal_name},
                                                        dataType: "html",
                                                        success: function (data) {
                                                            //console.log(data);
                                                        }
                                                    });

                                                });
                                            </script>
                                        </div>
                                        <?php
                                        $tempfile = explode(".", $correction_needed_files[$j]['cnf_internal_name_dom']);
                                        $file_extension = strtolower(end($tempfile));

                                        if ($file_extension == "pdf") {
                                            ?>
                                            <div class="col-md-2">
                                                <img class="img-responsive" style="width:40px;"
                                                     src="../img/adobe-pdf-icon.png" alt="adobe-pdf-icon">
                                            </div>
                                            <?php
                                        }

                                        if ($file_extension == "dxf") {
                                            ?>
                                            <div class="col-md-2">
                                                <img class="img-responsive" style="width:40px;"
                                                     src="../img/dxf_icon.jpg" alt="dxf-icon">
                                            </div>
                                            <?php
                                        }

                                        if (in_array($file_extension, $validextensions)) {
                                            ?>
                                            <div class="image_div">
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>" style="">
                                                    <img class="img-responsive" style="width:60px;cursor:pointer;"
                                                         src="../correction_needed_files/<?php echo $correction_needed_files[$j]['cnf_path_dom'] . $correction_needed_files[$j]['cnf_internal_name_dom']; ?>"
                                                         alt="<?php echo $$correction_needed_files[$j]['cnf_name']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-md-4" style="flex: unset !important; max-width: 100%; display: flex; justify-content: center;">
                                            <form name="delete_file_form"
                                                  style="display: flex"
                                                  action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>"
                                                  method="post">
                                                <input type="hidden" name="cnf_id"
                                                       value="<?php echo $correction_needed_files[$j]['cnf_id']; ?>">
                                                <a href="../image.php?filecategory=correction_needed_files&cnf_id=<?php echo $correction_needed_files[$j]['cnf_id']; ?>"
                                                   class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-down mr-2"></i></a>
                                                <button type="submit" name="cnf_delete_btn" title="Delete file"
                                                        href="../image.php?filecategory=correction_needed_files&cnf_id=<?php echo $correction_needed_files[$j]['cnf_id']; ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure want to delete ?')">X
                                                </button>
                                            </form>
                                        </div>
                                        <?php
                                        if (in_array($file_extension, $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                                                        class="img-responsive" style="width:900px;"
                                                        src="../correction_needed_files/<?php echo $correction_needed_files[$j]['cnf_path_dom'] . $correction_needed_files[$j]['cnf_internal_name_dom']; ?>"
                                                        alt="<?php echo $correction_needed_files[$j]['cnf_name']; ?>"></div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>

                            <div class="col-md-6" style="max-width: 100%;">
                                <!-- <div id="fileuploader"></div> -->
                                <div class="row">
                                    <input type="file" name="myfile[]" class="form-control form-control-sm" form="upload_result_files_form" multiple="">
                                    <button id="start_upload_hints_btn" type="button" class="btn btn-sm btn-success" aria-expanded="true">Start upload hints</button>
                                </div>
                                <div class="row">
                                <p style="text-align: left; font-weight: bold;">Already uploaded:</p>
                                </div>
                                <?php /*
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $("#fileuploader").uploadFile({
                                            url: "../upload_files_beta.php?filecategory=correction_needed_files&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id']; ?>",
                                            fileName: "myfile",
                                            showAbort: true,
                                            data: "",
                                            autoSubmit: true,
                                            showStatusAfterSuccess: true,
                                            showStatusAfterError: true,
                                            uploadStr: "Upload files with correction hints",
                                            statusBarWidth: 300,
                                            dragdropWidth: 500,
                                            done: function (data) {
                                                console.log("a");
                                            }
                                        });

                                    });
                            </script> */ ?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <!-- <script type='text/javascript' src='../acceptance/js/acceptance.js'></script> -->
                </div> <!--end task details container -->
            <?php
            $user_tracking_data['client_id'] = $_COOKIE['client_id'];
            $user_tracking_data['o_id'] = $o_id;

            $prod->delete_user_tracking_page(json_encode($user_tracking_data));

            $insert_data['client_id'] = $_COOKIE['client_id'];
            $insert_data['o_id'] = $o_id;
            $insert_data['osub_id'] = $osub_id;
            $insert_data['prod_id'] = $prod_id;
            $insert_data['date_visited'] = gmdate("Y-m-d H:i:s", strtotime(gmdate("Y-m-d H:i:s") . " +5 minutes"));

            $prod->insert_user_tracking_page(json_encode($insert_data));

            include('../online_creators.php');
            }
            else
            {
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

    <!-- AI Image Modal Iframe Overlay -->
    <div id="aiImageModalOverlay" class="ai-modal-overlay" style="display: none;">
        <iframe id="aiImageModalIframe" src="" allow="clipboard-write"></iframe>
    </div>

    <style>
        .ai-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ai-modal-overlay iframe {
            width: 100%;
            max-width: 1440px;
            height: 90vh;
            max-height: 800px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
    </style>

    <script>
        (function() {
            'use strict';

            const overlay = document.getElementById('aiImageModalOverlay');
            const iframe = document.getElementById('aiImageModalIframe');

            // Handle AI modal trigger clicks using event delegation
            document.addEventListener('click', function(e) {
                const trigger = e.target.closest('.ai-modal-trigger');
                if (!trigger) return;

                const orfId = trigger.dataset.orfId;
                if (!orfId) return;

                // Generate a simple token
                const token = 'task_' + Date.now();

                // Set iframe source and show overlay
                iframe.src = '/studio/i_frames/ai_image_modal.php?orf_id=' + encodeURIComponent(orfId) + '&token=' + encodeURIComponent(token);
                overlay.style.display = 'flex';

                // Prevent body scroll when modal is open
                document.body.style.overflow = 'hidden';
            });

            // Close modal when clicking overlay background
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeAiModal();
                }
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && overlay.style.display !== 'none') {
                    closeAiModal();
                }
            });

            // Listen for postMessage events from iframe
            window.addEventListener('message', function(e) {
                if (!e.data || e.data.type !== 'ai-modal-event') return;

                const { event: eventName, data } = e.data;

                switch (eventName) {
                    case 'close':
                        closeAiModal();
                        break;

                    case 'imageGenerated':
                        console.log('AI Image generated:', data);
                        break;

                    case 'imageSaved':
                        console.log('AI Image saved to task:', data);
                        closeAiModal();
                        window.location.reload(true);
                        break;

                    case 'error':
                        console.error('AI Modal error:', data);
                        break;

                    case 'ready':
                        console.log('AI Modal ready for orf_id:', data.orf_id);
                        break;
                }
            });

            function closeAiModal() {
                overlay.style.display = 'none';
                iframe.src = '';
                document.body.style.overflow = '';
            }
        })();
    </script>

<?php

include('../footer.php');
?>