<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('../functions.php');

$prod = new Production;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");
$page_title="Main Client Administration";
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
                    <p class="pt-4 w-100 display-4 text-center">Main Clients</p>
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
                    $main_clients=array();
                    $creators=array();
                    
                    if (($order_by == "id") || ($order_by == "")) {
                        if ($_COOKIE['view_all_orders'] == 1) {
                            $main_clients = $prod->get_all_clients_by_id();
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

                            $main_clients = $prod->show_clients_by_ls_ids_order_by_id($ls_ids_array);
                        }

                    } elseif ($order_by == "enterprise") {
                        if ($_COOKIE['view_all_orders'] == 1) {
                            $main_clients = $prod->get_all_clients_by_enterprise();
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
                            $main_clients = $prod->show_clients_by_ls_ids_order_by_enterprise($ls_ids_array);
                        }
                    }
                    $main_clients=$prod->get_all_active_inactive_main_clients();
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
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Main ClientID</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Main Client Name</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Leader's Name</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Leader's Status</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Contact at client</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Country</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Phone</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">E-mail</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white"></th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    <?php

                    //clients

                    for ($i = 0; $i < count($main_clients); $i++) {
                        if ($main_clients[$i]['inactive'] == 0) 
                        {
                            ?>
                            <tr id="client<?php echo $main_clients[$i]['mc_id']; ?>"
                                data-client-name="<?= (!empty($main_clients[$i]['c_last_name'])) ? $main_clients[$i]['c_last_name'] . $main_clients[$i]['c_first_name'] : ""; ?>"
                                data-active="<?php if ($main_clients[$i]['inactive'] === 0) {
                                    echo "true";

                                } else {
                                    echo "false";
                                } ?>"
                                class="text-center clients
                            <?php
                                if ($main_clients[$i]['inactive'] != 0) {
                                    echo "violet";
                                } ?>">
                                <th class="py-2 px-0" scope="row"><?php echo $main_clients[$i]['mc_id']; ?></th>
                                <td class="py-2 px-0"><?php echo $main_clients[$i]['clientname']; ?></td>
                                <td class="py-2 px-0"><?php echo $main_clients[$i]['leaders_name']; ?></td>
                                <td class="py-2 px-0">
                                <?php echo $main_clients[$i]['leaders_status']; ?>
                                </td>
                                <td class="py-2 px-0">
                                <?php echo $main_clients[$i]['contact-at-client']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $prod->get_country($main_clients[$i]['a_id'])['area']; ?>
                                </td>
                               
                                <td class="py-2 px-0">
                                    <?php echo $main_clients[$i]['phone']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $main_clients[$i]['email']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php
                                    $single_client=$prod->get_clients_by_mc_id($main_clients[$i]['mc_id']);?>
                                    <a href="modify_main_client.php?mc_id=<?php echo $main_clients[$i]['mc_id']; ?>"
                                       class="btn btn-sm btn-primary p-0">Modify</a>
                                    <a href="../client_administration/presentation_infos.php?clientid=<?php echo $single_client[0]['client_ID'];?>" class="btn btn-sm btn-primary p-0">Design</a>
                                    <a href="texts.php?mc_id=<?php echo $main_clients[$i]['mc_id']; ?>" class="btn btn-sm btn-primary p-0">Texts</a>
                                    <a href="options_materials.php?mc_id=<?php echo $main_clients[$i]['mc_id']; ?>" class="btn btn-sm btn-primary p-0">Options</a>
                                    <?php
                                    if ($main_clients[$i]['inactive'] == 0) {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $main_clients[$i]['mc_id']; ?>"
                                                name="active_inactive_btn"
                                                data-mc_id="<?php echo $main_clients[$i]['mc_id']; ?>"
                                                class="p-0 btn btn-success btn-sm">Active
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $main_clients[$i]['mc_id']; ?>"
                                                name="active_inactive_btn"
                                                data-mc_id="<?php echo $main_clients[$i]['mc_id']; ?>"
                                                class="p-0 btn violet btn-sm">Inactive
                                        </button>
                                        <?php
                                    }
                                    ?>
                                    <button type="button" id="del_btn<?php echo $main_clients[$i]['mc_id']; ?>" class="btn btn-sm btn-danger pb-0 pt-0">X</button>
                                    <!--</form> -->
                                    <script type="text/javascript">
                                        $('#del_btn<?php echo $main_clients[$i]['mc_id']; ?>').click(function(){

                                            if(confirm('Are you sure ?'))
                                            {
                                                $.ajax({
                                                    url: "../ajax/delete_main_client.php",
                                                    method: "post",
                                                    data: {mc_id:$(this).data("mc_id")},
                                                    dataType:"html",
                                                    success:function(data) {
                                                    $('#client<?php echo $main_clients[$i]['mc_id'];?>').fadeOut(2000);
                                                    },
                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                        console.log(xhr.status);
                                                        console.log(thrownError);
                                                    }
                                                    });
                                            }

                                        });

                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").click(function () {
                                            $.ajax({
                                                url: "../ajax/change_main_client_status.php",
                                                method: "post",
                                                data: {
                                                    mc_id: $(this).data("mc_id"),
                                                    option: "change_main_client_status"
                                                },
                                                dataType: "html",
                                                success: function (data) {
                                                    //console.log(data);
                                                    $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").html(data);
                                                    if (data == "Inactive") {
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").removeClass().addClass('p-0 btn violet btn-sm');
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").parent().parent().removeClass().addClass('text-center violet');
                                                    } else {
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").removeClass().addClass('p-0 btn btn-success btn-sm');
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").parent().parent().removeClass('violet').addClass('text-center');
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
                    ?><?php
                    for ($i = 0; $i < count($main_clients); $i++) 
                    {
                        if ($main_clients[$i]['inactive'] != 0)
                        {
                            ?>
                            <tr class="text-center clients <?php
                            if ($main_clients[$i]['inactive'] != 0) {
                                echo "violet";
                            } ?>"
                                data-active="<?php if ($main_clients[$i]['inactive'] === 0) {
                                    echo "true";

                                } else {
                                    echo "false";
                                } ?>" id="client<?php echo $main_clients[$i]['mc_id']; ?>">


                                <th class="py-2 px-0" scope="row"><?php echo $main_clients[$i]['mc_id']; ?></th>
                                <td class="py-2 px-0"><?php echo $main_clients[$i]['clientname']; ?></td>
                                <td class="py-2 px-0">
                                <?php echo $main_clients[$i]['leaders_name']; ?>
                                </td>
                                <td class="py-2 px-0">
                                <?php echo $main_clients[$i]['leaders_status']; ?>
                                </td>
                                <td class="py-2 px-0">
                                <?php echo $main_clients[$i]['contact-at-client']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $prod->get_country($main_clients[$i]['a_id'])['area']; ?>
                                </td>  
                                <td>                              
                                    <?php echo $main_clients[$i]['phone']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <?php echo $main_clients[$i]['email']; ?>
                                </td>
                                <td class="py-2 px-0">
                                    <input type="hidden" name="mc_id" value="<?php echo $main_clients[$i]['mc_id']; ?>">
                                    <a href="modify_main_client.php?mc_id=<?php echo $main_clients[$i]['mc_id']; ?>"
                                       class="btn btn-sm btn-primary p-0">Modify</a>
                                    
                                    <?php
                                    if ($main_clients[$i]['inactive'] == 0) {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $main_clients[$i]['mc_id']; ?>"
                                                name="active_inactive_btn"
                                                data-mc_id="<?php echo $main_clients[$i]['mc_id']; ?>"
                                                class="p-0 btn btn-success btn-sm">Active
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button"
                                                id="active_inactive_btn<?php echo $main_clients[$i]['mc_id']; ?>"
                                                name="active_inactive_btn"
                                                data-mc_id="<?php echo $main_clients[$i]['mc_id']; ?>"
                                                class="p-0 btn violet btn-sm">Inactive
                                        </button>
                                        <?php
                                    }
                                    ?>                                 
                                    <button type="button" id="del_btn<?php echo $main_clients[$i]['mc_id']; ?>" data-mc_id="<?php echo $main_clients[$i]['mc_id']; ?>" class="btn btn-sm btn-danger pb-0 pt-0">X</button>
                                    <script type="text/javascript">
                                        $('#del_btn<?php echo $main_clients[$i]['mc_id']; ?>').click(function(){

                                            if(confirm('Are you sure ?'))
                                            {
                                                $.ajax({
                                                    url: "../ajax/delete_main_client.php",
                                                    method: "post",
                                                    data: {mc_id:$(this).data("mc_id")},
                                                    dataType:"html",
                                                    success:function(data) {
                                                    $('#client<?php echo $main_clients[$i]['mc_id'];?>').fadeOut(2000);
                                                    },
                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                        console.log(xhr.status);
                                                        console.log(thrownError);
                                                    }
                                                    });
                                            }
                                        });

                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").click(function () {
                                            $.ajax({
                                                url: "../ajax/change_main_client_status.php",
                                                method: "post",
                                                data: {
                                                    mc_id: $(this).data("mc_id"),
                                                    option: "change_main_client_status"
                                                },
                                                dataType: "html",
                                                success: function (data) {
                                                    
                                                    $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").html(data);
                                                    if (data == "Inactive") {
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").removeClass().addClass('p-0 btn violet btn-sm');
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").parent().parent().parent().removeClass().addClass('text-center violet');
                                                    } else {
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").removeClass().addClass('p-0 btn btn-success btn-sm');
                                                        $("#active_inactive_btn<?php echo $main_clients[$i]['mc_id'];?>").parent().parent().parent().removeClass().addClass('text-center');
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

        <!--    Clients search    -->


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