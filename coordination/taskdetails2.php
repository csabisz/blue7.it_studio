<?php
//session_set_cookie_params(14400,"/");
session_start();

include('../functions.php');
include('../../../../domenia7.com/public_html/domenia_db2.php');
include('../notifications.php');
include('../../../../blue7.it/public_html/domenia/domenia.php');

//$domenia=new Domenia;
$domenia2 = new Domenia2;
$prod = new Production;
$notification = new Notifications;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

$picture_website = "https://domenia.blue7.it/";

$page_title="Task Details";

include('../header2.php');
include('../menu.php');

?>
    <style>
        img.broken_image_main, img.broken_door_shape_image {
            position: relative;
            width: 100px!important;
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

        img.broken_image_main::before {
            content: 'Choose main picture';
        }

        img.broken_door_shape_image::before {
            content: 'Choose door shape';
        }
    </style>

    <section class="acceptance pt-5">
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
                    $_POST = array();
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

                    /*if($licenceid=="04903")
				{
					$prod->assign_to_creator($o_id,$osub_id,$prod_id,$creatorid,$p_fac_ct=1,$p_fac_ca=1,2);
				}

				if($licenceid!="04903")
				{*/
                    /*
					$prod->assign_to_creator($o_id,$osub_id,$prod_id,$creatorid,1,1,2);

					$logged_in_user_id=$prod->get_creator($_COOKIE['email']);
					$creator_name=$prod->get_creator_name($creatorid);
					$prod->create_activity($logged_in_user_id['uca_id'],"assigned to ".$creator_name['uca_name'],$o_id,$osub_id,$prod_id);


					$prod->update_order_status($o_id,$o_status=2);
					*/

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
                $room_id = $prod->xss_fix($_GET['room_id']);

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
                            $subid_data['o_id']=$o_id;
                            $subid_data['o_sub_id']=$osub_id;

                            $subo_name=$prod->check_existing_subid(json_encode($subid_data));

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
                                        <?php if ($product['current_creator'])
                                        { ?>

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


                                    for ($i = 0; $i < count($all_creators); $i++)
                                    {
                                        $creator_qualification = $prod->get_client_qualifications($all_creators[$i]['client_ID']);
                                        $creator_right = $prod->get_client_rights($all_creators[$i]['client_ID']);

                                        if ($creator_right['u_status'] == "active") {
                                            if($prod_id == "p1103")
                                            {
                                                if ($creator_qualification['b1_floorplans'] > 0)
                                                {
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

                                            if($prod_id == "p1104")
                                            {
                                                if ($creator_qualification['b1_pictures'] > 0)
                                                {
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
                                            if($prod_id == "p1106")
                                            {
                                                if ($creator_qualification['b1_360'] > 0)
                                                {
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
                                            if($prod_id == "p1108")
                                            {
                                                if ($creator_qualification['b1_videos'] > 0)
                                                {
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

                                            if ($prod_id == "p1301")
                                            {
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

                                            if($prod_id == "p1163")
                                            {
                                                if ($creator_qualification['b1_pictures'] > 0)
                                                {
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
                                            if($prod_id == "p1166")
                                            {
                                                if ($creator_qualification['b1_360'] > 0)
                                                {
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
                                            if ($prod_id == "p1168")
                                            {
                                                if ($creator_qualification['b1_videos'] > 0)
                                                {
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

                                            if(
                                                ($prod_id == "p116b")||(substr($prod_id, -2)=="gb")
                                                )
                                            {
                                                if ($creator_qualification['b1_base_picture'] > 0)
                                                {
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

                                            if(
                                                ($prod_id == "p116m")||(substr($prod_id, -2)=="gm")
                                            )
                                            {
                                                if ($creator_qualification['b1_masks'] > 0)
                                                {
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

                                            if ($prod_id == "p116t")
                                            {
                                                if ($creator_qualification['b1_targets'] > 0)
                                                {
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

                                            if(
                                                (substr($prod_id, -2)=="8s")||(substr($prod_id, -2)=="gs")
                                            )
                                            {
                                                if ($creator_qualification['b1_suntour_model'] > 0)
                                                {
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

                                            if ((substr($prod_id, -3)=="10v")||(substr($prod_id, -3)=="16v"))
                                            {
                                                if ($creator_qualification['b1_vr'] > 0)
                                                {
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
                                    for ($i = 0; $i < count($all_other_creators); $i++)
                                    {
                                        $creator_qualification = $prod->get_client_qualifications($all_other_creators[$i]['client_ID']);
                                        $creator_right = $prod->get_client_rights($all_other_creators[$i]['client_ID']);

                                        if ($creator_right['u_status'] == "active") {
                                            if($prod_id == "p1103")
                                            {
                                                if ($creator_qualification['b1_floorplans'] > 0)
                                                {
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

                                            if($prod_id == "p1104")
                                            {
                                                if ($creator_qualification['b1_pictures'] > 0)
                                                {
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
                                            if($prod_id == "p1106")
                                            {
                                                if ($creator_qualification['b1_360'] > 0)
                                                {
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

                                            if($prod_id == "p1108")
                                            {
                                                if ($creator_qualification['b1_videos'] > 0)
                                                {
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

                                            if ($prod_id == "p1301")
                                            {
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

                                            if ($prod_id == "p1163")
                                            {
                                                if($creator_qualification['b1_pictures'] > 0)
                                                {
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


                                            if ($prod_id == "p1166")
                                            {
                                                if($creator_qualification['b1_360'] > 0)
                                                {
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

                                            if ($prod_id == "p1168")
                                            {
                                                if($creator_qualification['b1_videos'] > 0)
                                                {
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

                                            if(
                                                ($prod_id == "p116b")||(substr($prod_id, -2)=="gb")
                                            )
                                            {
                                                if($creator_qualification['b1_base_picture'] > 0)
                                                {
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

                                            if( 
                                                ($prod_id == "p116m")||(substr($prod_id, -2)=="gm")
                                            )
                                            {
                                                if($creator_qualification['b1_masks'] > 0)
                                                {
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

                                            if ($prod_id == "p116t")
                                            {
                                                if($creator_qualification['b1_targets'] > 0)
                                                {
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

                                            if(
                                                (substr($prod_id, -2)=="8s")||(substr($prod_id, -2)=="gs")
                                            )
                                            {
                                                if($creator_qualification['b1_suntour_model'] > 0)
                                                {
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

                                            if ((substr($prod_id, -3)=="10v")||(substr($prod_id, -3)=="16v"))
                                            {
                                                if($creator_qualification['b1_vr'] > 0)
                                                {
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


                                // } else {

                                //     console.log("Already Loaded");

                                // }

                                $('#creators_0').on("change", function ()
                                {

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

                                $client = $prod->get_client($last_activity['uca_id']);

                                echo $client['c_first_name'] . " " . $client['c_last_name'] . " " . $last_activity['description'] . " on " . $last_activity['date'];
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

                            $tutorial_ids = array();

                            for ($i = 0; $i < count($product_cdws_ids); $i++) {
                                $tutorial_cdws_id = $prod->get_product_tutorials($product_cdws_ids[$i]);

                                for ($j = 0; $j < count($tutorial_cdws_id); $j++) {
                                    $tutorial_ids[] = $tutorial_cdws_id[$j]['t_id'];
                                }

                            }

                            $tutorial_ids = array_values(array_unique($tutorial_ids));
                            $tutorial_counter = 0;

                            $tutorials = array();

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
                                <a href="../image.php?filecategory=customerfiles&download-all=<?php echo $o_id;?>" class="btn btn-sm btn-primary">Download all</a>
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
                    if ((substr($prod_id, 1) > 1500) && (substr($prod_id, 1) < 1560)) 
                    {
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
                    if(((substr($prod_id, 1) > 1300) && (substr($prod_id, 1) < 1360)))
                    {
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

                                            $(document).ready(function(){

                                                load_b3_colorset_examples();

                                            });

                                            function load_b3_colorset_examples()
                                            {
                                                let sl_id=$('#sl_id').text();
                                                let cls_id=$('#cls_id').text();

                                                if((sl_id!="")&&(cls_id!=""))
                                                {

                                                    $.ajax({
                                                        url: "../ajax/get_b3_colorset_examples_html.php",
                                                        method: "get",
                                                        data: {sl_id:sl_id,cls_id:cls_id},
                                                        dataType:"html",
                                                        success:function(data) {
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
                        ((substr($prod_id, 1) > 1300) && (substr($prod_id, 1) < 1360))||
                    ((substr($prod_id, 1) > 1560) && (substr($prod_id, 1) < 1599)) || ((substr($prod_id, 1) > 1660) && (substr($prod_id, 1) < 1699)) ||
                    ((substr($prod_id, 1) > 1760) && (substr($prod_id, 1) < 1799)) || ((substr($prod_id, 1) > 1860) && (substr($prod_id, 1) < 1899))
                    )
                    {
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

                                if($o_desc_allproducts['photovoltaic']==1)
                                {
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

                    include('../result_files.php');
                    ?>
                    


                    
                    <div class="row mx-0 w-100 border-top mt-5 border-dark dark-gray">
                        <div class="col-md-6 border-right border-dark pt-3">
                            <p class="w-100 text-center mb-0">Send message to creator: <?php
                                if (!empty($producer_name['c_first_name'])) {
                                    echo $producer_name['c_last_name'] . ", " . $producer_name['c_first_name'];
                                } else {
                                    echo $producer_name['l_last_name'] . ", " . $producer_name['l_first_name'];
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

                                <div class="row w-100 mx-0" style="flex-direction: column;height: min-content;  max-width: 14vw;" >
                                    <div class="col-md-2 text-truncate" style="flex: unset !important; max-width: unset !important; text-align: left;">
                                        <?php
                                        echo $correction_needed_files[$j]['cnf_name'];
                                        ?>
                                    </div>
                                    <div class="col-md-3" style="max-width: 100% !important; margin-bottom:1vh;">
                                        <input type="text" id="cnf_custom_internal_name<?php echo $correction_needed_files[$j]['cnf_id'];?>" class="form-control form-control-sm" placeholder="Internal name" value="<?php echo $correction_needed_files[$j]['cnf_custom_internal_name'];?>">
                                        <script type="text/javascript">
                                            $('#cnf_custom_internal_name<?php echo $correction_needed_files[$j]['cnf_id'];?>').on('focusout',function(){

                                                let cnf_id=<?php echo $correction_needed_files[$j]['cnf_id'];?>;
                                                let cnf_custom_internal_name=$(this).val();

                                                $.ajax({
                                                    url: "../ajax/update_cnf_custom_internal_name.php",
                                                    method: "post",
                                                    data: {cnf_id:cnf_id,cnf_custom_internal_name:cnf_custom_internal_name},
                                                    dataType:"html",
                                                    success:function(data) {
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
                                <div id="fileuploader"></div>
                                <p style="text-align: left; font-weight: bold;">Already uploaded:</p>
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
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <!-- <script type='text/javascript' src='../acceptance/js/acceptance.js'></script> -->
                </div> <!--end task details container -->
                <?php
                $user_tracking_data['client_id']=$_COOKIE['client_id'];
                $user_tracking_data['o_id']=$o_id;

                $prod->delete_user_tracking_page(json_encode($user_tracking_data));

                $insert_data['client_id']=$_COOKIE['client_id'];
                $insert_data['o_id']=$o_id;
                $insert_data['osub_id']=$osub_id;
                $insert_data['prod_id']=$prod_id;
                $insert_data['date_visited']=gmdate("Y-m-d H:i:s",strtotime(gmdate("Y-m-d H:i:s")." +5 minutes"));

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
<?php

include('../footer.php');
?>