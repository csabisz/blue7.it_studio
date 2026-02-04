<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('../functions.php');

$prod = new Production;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

$page_title="Client Administration";

include('../header2.php');
include('../menu.php');

?>
    <section class="top_section">
        <article>
            <?php
            if (isset($_COOKIE['client_id']) && ($_COOKIE['start'] < $_COOKIE['expire'])) {
                ?>
                <div class="container-fluid bg-white">
                    <!-- <h3>Clients</h3> -->
                    <p class="pt-4 w-100 display-4 text-center">Clients</p>
                    <hr width="450px">
                    <?php
                    include('submenu.php');

                    if(isset($_GET['order_by']))
                    {
                        $order_by = $prod->xss_fix($_GET['order_by']);
                    }
                    else
                    {
                        $order_by = "id";
                    }
                    $clients=array();
                    $creators=array();
                    
                    if (($order_by == "id") || ($order_by == "")) {
                        if ($_COOKIE['view_all_orders'] == 1) {
                            $clients = $prod->get_all_clients_by_id();
                        } else {
                            $ls_ids_array = array();
                            $licences = $prod->get_licences($_COOKIE['lt_id']);


                            for ($l = 0; $l < count($licences); $l++) {
                                $ls_ids_string .= $licences[$l]['homepages_for_sale'];

                            }
                            $ls_ids_array = array_values(array_unique(explode(";", $ls_ids_string)));

                            for ($l = 0; $l < count($ls_ids_array); $l++) {
                                if (!empty($ls_ids_array[$l])) {
                                    $ls_ids_array[$l] = $ls_ids_array[$l] . ";";
                                }
                            }

                            $creators = $prod->show_creators_order_by_id($_COOKIE['lt_id']);

                            $clients = $prod->show_clients_by_ls_ids_order_by_id($ls_ids_array);
                        }

                    } elseif ($order_by == "enterprise") {
                        if ($_COOKIE['view_all_orders'] == 1) {
                            $clients = $prod->get_all_clients_by_enterprise();
                        } else {
                            $ls_ids_array = array();
                            $licences = $prod->get_licences($_COOKIE['lt_id']);


                            for ($l = 0; $l < count($licences); $l++) {
                                $ls_ids_string .= $licences[$l]['homepages_for_sale'];

                            }
                            $ls_ids_array = array_values(array_unique(explode(";", $ls_ids_string)));

                            for ($l = 0; $l < count($ls_ids_array); $l++) {
                                if (!empty($ls_ids_array[$l])) {
                                    $ls_ids_array[$l] = $ls_ids_array[$l] . ";";
                                }
                            }

                            $creators = $prod->show_creators_order_by_enterprise($_COOKIE['lt_id']);
                            $clients = $prod->show_clients_by_ls_ids_order_by_enterprise($ls_ids_array);
                        }
                    }

                    ?>


                    <div class="col" id="searchbar" style="width: 23%; margin-left: 614px">
                        <div class="float-center">
                            <input id="searchBar" class="form-control mr-sm-2" type="text" placeholder="Search By Name"
                                   aria-label="Search By Name">
                        </div>
                    </div>

                        <div class="col" style="width: 44%; float: right" id="checkboxes">
                        <div class="float-center">
                            <div id="dont_show_inactive_block" data-role="fieldcontain" class="checkboxes">
                                <label for="dont_show_inactive">Don't show inactive clients</label>
                                <input id="dont_show_inactive" name="dont_show_inactive" type="checkbox"
                                       onclick="dont_show_inactive()"/>
                            </div>
                        </div>

                            <div id="show_only_inactive_block" data-role="fieldcontain" class="checkboxes">
                                <label for="show_only_inactive">Show only inactive clients</label>
                                <input id="show_only_inactive" name="show_only_inactive" type="checkbox"
                                       onclick="show_only_inactive()"/>
                            </div>

                    </div>





                <table class="table table-striped mt-5"
                       style="font-size: 13px; overflow-y: auto;height: 520px; display: block; border-collapse: separate; border-spacing: 0;">
                    <thead class="text-center">
                    <tr>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">ClientID</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Enterprise</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Main Client</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Registered on</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Country</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Contact</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Position</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Status</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Phone</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">E-mail</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    //clients

                    for ($i = 0; $i < count($clients); $i++) {
                        if ($clients[$i]['c_status'] == "active") {
                            ?>
                            <tr id="client<?php echo $clients[$i]['client_ID']; ?>"
                                data-client-name="<?= (!empty($clients[$i]['c_last_name'])) ? $clients[$i]['c_last_name'] . $clients[$i]['c_first_name'] : $clients[$i]['l_last_name'] . $clients[$i]['l_first_name'] ?>"
                                data-active="<?php if ($clients[$i]['c_status'] === "active") {
                                    echo "true";

                                } else {
                                    echo "false";
                                } ?>"
                                class="text-center clients
                            <?php
                                if ($clients[$i]['c_status'] != "active") {
                                    echo "violet";
                                } ?>">
                                <th class="py-2 px-0" scope="row"><?php echo $clients[$i]['client_ID']; ?></th>
                                <td class="py-2 px-0"><?php echo $clients[$i]['clientname']; ?></td>
                                <td class="py-2 px-0">
                                    <?php
                                    $main_client = $prod->get_main_client($clients[$i]['mc_id']);
                                    if ($clients[$i]['mc_id'] != 0) {
                                        echo $main_client['clientname'];
                                    } else {
                                        echo "Own client";
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <p class="w-100 mb-0 text-center"><?php $date_time = explode(" ", $clients[$i]['date_registered']);
                                        echo $date_time[0] . "" . $date_time[1]; ?></p>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $prod->get_country($clients[$i]['a_id'])['area']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php
                                    if (!empty($clients[$i]['c_last_name'])) {
                                        echo $clients[$i]['c_last_name'] . ", " . $clients[$i]['c_first_name'];
                                    } else {
                                        echo $clients[$i]['l_last_name'] . ", " . $clients[$i]['l_first_name'];
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['specials']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['contact_status']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['phone']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['email']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <!-- <form class="w-100 text-center align-self-center" name="delete_client<?php echo $clients[$i]['client_ID']; ?>" method="post" action="index.php">-->
                                    <input type="hidden" name="clientid"
                                           value="<?php echo $clients[$i]['client_ID']; ?>">
                                    <a href="modify.php?clientid=<?php echo $clients[$i]['client_ID']; ?>"
                                       class="btn btn-sm btn-primary p-0">Modify</a>
                                    <?php
                                    if ($_COOKIE['client_id'] == 160) {
                                        ?>
                                        <a href="#" class="btn btn-sm btn-primary p-0">Login as</a>
                                        <?php
                                    }
                                    ?>
                                    <a href="orders.php?clientid=<?php echo $clients[$i]['client_ID']; ?>"
                                       class="btn btn-sm btn-warning p-0" target="_blank">View orders</a>
                                    <?php
                                    if ($clients[$i]['c_status'] == "active") {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $clients[$i]['client_ID']; ?>"
                                                name="active_inactive_btn"
                                                data-client-id="<?php echo $clients[$i]['client_ID']; ?>"
                                                class="p-0 btn btn-success btn-sm">Active
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $clients[$i]['client_ID']; ?>"
                                                name="active_inactive_btn"
                                                data-client-id="<?php echo $clients[$i]['client_ID']; ?>"
                                                class="p-0 btn violet btn-sm">Inactive
                                        </button>
                                        <?php
                                    }
                                    ?>
                                    <button type="button" name="delete_btn"
                                            id="delete_btn<?php echo $clients[$i]['client_ID']; ?>"
                                            data-delete_client_id="<?php echo $clients[$i]['client_ID']; ?>"
                                            class="btn btn-danger btn-sm p-0">X
                                    </button>
                                    <!--</form> -->
                                    <script type="text/javascript">
                                        $('#delete_btn<?php echo $clients[$i]['client_ID'];?>').click(function () 
                                        {
                                            if(confirm('Are you sure want do delete ?'))
                                            {
                                                $.ajax({
                                                    url: "../ajax/delete_client.php",
                                                    method: "post",
                                                    data: {client_id:$(this).data("delete_client_id")},
                                                    dataType:"html",
                                                    success:function(data) {
                                                        $('#client<?php echo $clients[$i]['client_ID'];?>').fadeOut(2000);
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                console.log(xhr.status);
                                                console.log(thrownError);
                                            }
                                            });

                                            }
                                            //alert("You are not allowed to delete clients !\n Contact an administrator if you really want to delete someone !")
                                        });

                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").click(function () {
                                            $.ajax({
                                                url: "../ajax/change_client_status.php",
                                                method: "post",
                                                data: {
                                                    client_id: $(this).data("client-id"),
                                                    option: "change_client_status"
                                                },
                                                dataType: "html",
                                                success: function (data) {
                                                    //console.log(data);
                                                    $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").html(data);
                                                    if (data == "Inactive") {
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").removeClass().addClass('p-0 btn violet btn-sm');
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").parent().parent().removeClass().addClass('text-center violet');
                                                    } else {
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").removeClass().addClass('p-0 btn btn-success btn-sm');
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").parent().parent().removeClass('violet').addClass('text-center');
                                                    }
                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    console.log(xhr.status);
                                                    console.log(thrownError);
                                                }
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <?php
                        }
                    }

                    //creators

                    for ($i = 0; $i < count($creators); $i++) {
                        if ($creators[$i]['c_status'] == "active") {
                            ?>
                            <tr id="client<?php echo $creators[$i]['client_ID']; ?>" class="text-center clients <?php
                            if ($creators[$i]['c_status'] != "active") {
                                echo "violet";
                            } ?>">
                                <th class="py-2 px-0" scope="row"><?php echo $creators[$i]['client_ID']; ?></th>
                                <td class="py-2 px-0"><?php echo $creators[$i]['clientname']; ?></td>
                                <td class="py-2 px-0">
                                    <?php
                                    $main_client = $prod->get_main_client($creators[$i]['mc_id']);
                                    if ($creators[$i]['mc_id'] != 0) {
                                        echo $main_client['clientname'];
                                    } else {
                                        echo "Own client";
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <p class="w-100 mb-0 text-center"><?php $date_time = explode(" ", $creators[$i]['date_registered']);
                                        echo $date_time[0] . "" . $date_time[1]; ?></p>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $prod->get_country($creators[$i]['a_id'])['area']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php
                                    if (!empty($creators[$i]['c_last_name'])) {
                                        echo $creators[$i]['c_last_name'] . ", " . $creators[$i]['c_first_name'];
                                    } else {
                                        echo $creators[$i]['l_last_name'] . ", " . $creators[$i]['l_first_name'];
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['specials']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['contact_status']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['phone']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['email']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <form class="w-100 text-center align-self-center"
                                          name="delete_client<?php echo $creators[$i]['client_ID']; ?>" method="post"
                                          action="index.php">
                                        <input type="hidden" name="clientid"
                                               value="<?php echo $creators[$i]['client_ID']; ?>">
                                        <a href="modify.php?clientid=<?php echo $creators[$i]['client_ID']; ?>"
                                           class="btn btn-sm btn-primary p-0">Modify</a>
                                        <a href="orders.php?clientid=<?php echo $creators[$i]['client_ID']; ?>"
                                           class="btn btn-sm btn-warning p-0" target="_blank">View orders</a>
                                        <?php
                                        if ($creators[$i]['c_status'] == "active") {
                                            ?>
                                            <button type="button"
                                                    id="active_inactive_btn<?php echo $creators[$i]['client_ID']; ?>"
                                                    name="active_inactive_btn"
                                                    data-client-id="<?php echo $creators[$i]['client_ID']; ?>"
                                                    class="p-0 btn btn-success btn-sm">Active
                                            </button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="button"
                                                    id="active_inactive_btn<?php echo $creators[$i]['client_ID']; ?>"
                                                    name="active_inactive_btn"
                                                    data-client-id="<?php echo $creators[$i]['client_ID']; ?>"
                                                    class="p-0 btn violet btn-sm">Inactive
                                            </button>
                                            <?php
                                        }
                                        ?>
                                        <button type="button" name="delete_btn"
                                            id="delete_btn<?php echo $creators[$i]['client_ID']; ?>"
                                            data-delete_client_id="<?php echo $creators[$i]['client_ID']; ?>"
                                            class="btn btn-danger btn-sm p-0">X
                                        </button>
                                    </form>
                                    <script type="text/javascript">
                                        $('#delete_btn<?php echo $creators[$i]['client_ID'];?>').click(function () 
                                        {
                                            if(confirm('Are you sure want do delete ?'))
                                            {
                                                $.ajax({
                                                    url: "../ajax/delete_client.php",
                                                    method: "post",
                                                    data: {client_id:$(this).data("delete_client_id")},
                                                    dataType:"html",
                                                    success:function(data) {
                                                        $('#client<?php echo $creators[$i]['client_ID'];?>').fadeOut(2000);
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                console.log(xhr.status);
                                                console.log(thrownError);
                                            }
                                            });

                                            }
                                            //alert("You are not allowed to delete clients !\n Contact an administrator if you really want to delete someone !")
                                        });

                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").click(function () {
                                            $.ajax({
                                                url: "../ajax/change_client_status.php",
                                                method: "post",
                                                data: {
                                                    client_id: $(this).data("client-id"),
                                                    option: "change_client_status"
                                                },
                                                dataType: "html",
                                                success: function (data) {
                                                    //console.log(data);
                                                    $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").html(data);
                                                    if (data == "Inactive") {
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").removeClass().addClass('p-0 btn violet btn-sm');
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").parent().parent().parent().removeClass().addClass('text-center violet');
                                                    } else {
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").removeClass().addClass('p-0 btn btn-success btn-sm');
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").parent().parent().parent().removeClass().addClass('text-center');
                                                    }
                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    console.log(xhr.status);
                                                    console.log(thrownError);
                                                }
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <?php
                        }
                    }

                    //inactive clients

                    for ($i = 0; $i < count($clients); $i++) {
                        if ($clients[$i]['c_status'] != "active") {
                            ?>
                            <tr id="client<?php echo $clients[$i]['client_ID']; ?>" class="text-center clients <?php
                            if ($clients[$i]['c_status'] != "active") {
                                echo "violet";
                            } ?>"
                                data-active="<?php if ($clients[$i]['c_status'] === "active") {
                                    echo "true";

                                } else {
                                    echo "false";
                                } ?>">


                                <th class="py-2 px-0" scope="row"><?php echo $clients[$i]['client_ID']; ?></th>
                                <td class="py-2 px-0"><?php echo $clients[$i]['clientname']; ?></td>
                                <td class="py-2 px-0">
                                    <?php
                                    $main_client = $prod->get_main_client($clients[$i]['mc_id']);
                                    if ($clients[$i]['mc_id'] != 0) {
                                        echo $main_client['clientname'];
                                    } else {
                                        echo "Main client";
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <p class="w-100 mb-0 text-center"><?php $date_time = explode(" ", $clients[$i]['date_registered']);
                                        echo $date_time[0] . "" . $date_time[1]; ?></p>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $prod->get_country($clients[$i]['a_id'])['area']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php
                                    if (!empty($clients[$i]['c_last_name'])) {
                                        echo $clients[$i]['c_last_name'] . ", " . $clients[$i]['c_first_name'];
                                    } else {
                                        echo $clients[$i]['l_last_name'] . ", " . $clients[$i]['l_first_name'];
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['specials']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['contact_status']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['phone']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $clients[$i]['email']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <!--<form class="w-100 text-center align-self-center" name="delete_client<?php echo $clients[$i]['client_ID']; ?>" method="post" action="index.php">-->
                                    <input type="hidden" name="clientid"
                                           value="<?php echo $clients[$i]['client_ID']; ?>">
                                    <a href="modify.php?clientid=<?php echo $clients[$i]['client_ID']; ?>"
                                       class="btn btn-sm btn-primary p-0">Modify</a>
                                    <a href="orders.php?clientid=<?php echo $clients[$i]['client_ID']; ?>"
                                       class="btn btn-sm btn-warning p-0" target="_blank">View orders</a>
                                    <?php
                                    if ($clients[$i]['c_status'] == "active") {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $clients[$i]['client_ID']; ?>"
                                                name="active_inactive_btn"
                                                data-client-id="<?php echo $clients[$i]['client_ID']; ?>"
                                                class="p-0 btn btn-success btn-sm">Active
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $clients[$i]['client_ID']; ?>"
                                                name="active_inactive_btn"
                                                data-client-id="<?php echo $clients[$i]['client_ID']; ?>"
                                                class="p-0 btn violet btn-sm">Inactive
                                        </button>
                                        <?php
                                    }
                                    ?>
                                    <button type="button" name="delete_btn"
                                            id="delete_btn<?php echo $clients[$i]['client_ID']; ?>"
                                            data-delete_client_id="<?php echo $clients[$i]['client_ID']; ?>"
                                            class="btn btn-danger btn-sm p-0">X
                                        </button>
                                    <!-- </form> -->
                                    <script type="text/javascript">
                                        $('#delete_btn<?php echo $clients[$i]['client_ID'];?>').click(function () 
                                        {
                                            if(confirm('Are you sure want do delete ?'))
                                            {
                                                $.ajax({
                                                    url: "../ajax/delete_client.php",
                                                    method: "post",
                                                    data: {client_id:$(this).data("delete_client_id")},
                                                    dataType:"html",
                                                    success:function(data) {
                                                        $('#client<?php echo $clients[$i]['client_ID'];?>').fadeOut(2000);
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                console.log(xhr.status);
                                                console.log(thrownError);
                                            }
                                            });

                                            }
                                            //alert("You are not allowed to delete clients !\n Contact an administrator if you really want to delete someone !")
                                        });

                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").click(function () {
                                            $.ajax({
                                                url: "../ajax/change_client_status.php",
                                                method: "post",
                                                data: {
                                                    client_id: $(this).data("client-id"),
                                                    option: "change_client_status"
                                                },
                                                dataType: "html",
                                                success: function (data) {
                                                    //console.log(data);
                                                    $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").html(data);
                                                    if (data == "Inactive") {
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").removeClass().addClass('p-0 btn violet btn-sm');
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").parent().parent().parent().removeClass().addClass('text-center violet');
                                                    } else {
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").removeClass().addClass('p-0 btn btn-success btn-sm');
                                                        $("#active_inactive_btn<?php echo $clients[$i]['client_ID'];?>").parent().parent().parent().removeClass().addClass('text-center');
                                                    }
                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    console.log(xhr.status);
                                                    console.log(thrownError);
                                                }
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <?php
                        }
                    }

                    //inactive creators

                    for ($i = 0; $i < count($creators); $i++) {
                        if ($creators[$i]['c_status'] != "active") {
                            ?>
                            <tr id="client<?php echo $creators[$i]['client_ID']; ?>" class="text-center clients<?php
                            if ($creators[$i]['c_status'] != "active") {
                                echo "violet";
                            } ?>">
                                <th class="py-2 px-0" scope="row"><?php echo $creators[$i]['client_ID']; ?></th>
                                <td class="py-2 px-0"><?php echo $creators[$i]['clientname']; ?></td>
                                <td class="py-2 px-0">
                                    <?php
                                    $main_client = $prod->get_main_client($creators[$i]['mc_id']);
                                    if ($creators[$i]['mc_id'] != 0) {
                                        echo $main_client['clientname'];
                                    } else {
                                        echo "Main client";
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <p class="w-100 mb-0 text-center"><?php $date_time = explode(" ", $creators[$i]['date_registered']);
                                        echo $date_time[0] . "" . $date_time[1]; ?></p>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $prod->get_country($creators[$i]['a_id'])['area']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php
                                    if (!empty($creators[$i]['c_last_name'])) {
                                        echo $creators[$i]['c_last_name'] . ", " . $creators[$i]['c_first_name'];
                                    } else {
                                        echo $creators[$i]['l_last_name'] . ", " . $creators[$i]['l_first_name'];
                                    } ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['specials']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['contact_status']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['phone']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $creators[$i]['email']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <form class="w-100 text-center align-self-center"
                                          name="delete_client<?php echo $creators[$i]['client_ID']; ?>" method="post"
                                          action="index.php">
                                        <input type="hidden" name="clientid"
                                               value="<?php echo $creators[$i]['client_ID']; ?>">
                                        <a href="modify.php?clientid=<?php echo $creators[$i]['client_ID']; ?>"
                                           class="btn btn-sm btn-primary p-0">Modify</a>
                                        <a href="orders.php?clientid=<?php echo $creators[$i]['client_ID']; ?>"
                                           class="btn btn-sm btn-warning p-0" target="_blank">View orders</a>
                                        <?php
                                        if ($creators[$i]['c_status'] == "active") {
                                            ?>
                                            <button type="button"
                                                    id="active_inactive_btn<?php echo $creators[$i]['client_ID']; ?>"
                                                    name="active_inactive_btn"
                                                    data-client-id="<?php echo $creators[$i]['client_ID']; ?>"
                                                    class="p-0 btn btn-success btn-sm">Active
                                            </button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="button"
                                                    id="active_inactive_btn<?php echo $creators[$i]['client_ID']; ?>"
                                                    name="active_inactive_btn"
                                                    data-client-id="<?php echo $creators[$i]['client_ID']; ?>"
                                                    class="p-0 btn violet btn-sm">Inactive
                                            </button>
                                            <?php
                                        }
                                        ?>
                                        <button type="submit" name="delete_btn" class="btn btn-danger btn-sm p-0"
                                                onclick="return confirm('Are you sure want do delete ?')">X
                                        </button>
                                    </form>
                                    <script type="text/javascript">
                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").click(function () {
                                            $.ajax({
                                                url: "../ajax/change_client_status.php",
                                                method: "post",
                                                data: {
                                                    client_id: $(this).data("client-id"),
                                                    option: "change_client_status"
                                                },
                                                dataType: "html",
                                                success: function (data) {
                                                    //console.log(data);
                                                    $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").html(data);
                                                    if (data == "Inactive") {
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").removeClass().addClass('p-0 btn violet btn-sm');
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").parent().parent().parent().removeClass().addClass('text-center violet');
                                                    } else {
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").removeClass().addClass('p-0 btn btn-success btn-sm');
                                                        $("#active_inactive_btn<?php echo $creators[$i]['client_ID'];?>").parent().parent().parent().removeClass().addClass('text-center');
                                                    }
                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    console.log(xhr.status);
                                                    console.log(thrownError);
                                                }
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php
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

    <script>



        const clients = document.querySelectorAll('.clients')
        const searchBar = document.getElementById('searchBar');
        searchBar.addEventListener('input', (e) => {

            const searchingFor = searchBar.value.toLowerCase()


            clients.forEach((client) => {
                if (client.dataset.clientName.toLowerCase().includes(searchingFor)) {
                    client.style.display = ''
                } else {
                    client.style.display = 'none'
                }
            })

            console.log(searchBar.value)
        })
        ////////////////////////////////////

        let dont_show_inactive_checkbox = document.getElementById('dont_show_inactive')
        let show_only_inactive_checkbox = document.getElementById('show_only_inactive')



        function dont_show_inactive() {

            if(show_only_inactive_checkbox.checked===true) { show_only_inactive_checkbox.checked=false;}
            if (dont_show_inactive_checkbox.checked) {
                console.log('Chceked')

                dont_show_inactive_checkbox.addEventListener('change', () => {


                    clients.forEach((client) => {
                        if (client.dataset.active === "true") {
                            client.style.display = ''
                        } else {
                            client.style.display = 'none'
                        }
                    })
                });
            } else {
                dont_show_inactive_checkbox.addEventListener('change', () => {
                    clients.forEach((client) => client.style.display = '')
                });
            }
        }


        function show_only_inactive() {

            if(dont_show_inactive_checkbox.checked===true) { dont_show_inactive_checkbox.checked=false;}



            if (show_only_inactive_checkbox.checked) {
                console.log('show only inactives is : Checked');

                show_only_inactive_checkbox.addEventListener('change', () => {


                    clients.forEach((client) => {
                        if (client.dataset.active === "false") {
                            client.style.display = ''
                        } else {
                            client.style.display = 'none'
                        }
                    })
                });
            } else {
                show_only_inactive_checkbox.addEventListener('change', () => {
                    clients.forEach((client) => client.style.display = '')
                });
            }
        }



    </script>

<?php
include('../footer.php');
?>