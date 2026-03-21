<?php
session_start();
include('../../functions.php');
include('../../notifications.php');

$prod = new Production;
$notification = new Notifications;
$_SESSION['start'] = gmdate("Y-m-d H:i:s");

include("../../header2.php");
include('../../menu.php');
?>

    <div class="page-content">

<?php
if (isset($_SESSION['client_id']) && ($_SESSION['start'] < $_SESSION['expire']))
{
if (isset($_GET['o_id']))
{


    $o_id = $prod->xss_fix($_GET['o_id']);
    $image_preview_counter = 0;
    $validextensions = array("jpeg", "jpg", "png");
    $panorama = 0;

    $order = $prod->get_order($o_id);
    $o_extension = $order['o_extension'];
    $clientid = $order['u_client_ID'];
    $client = $prod->get_client($clientid);
    $licenceid = $order['lic_ID'];

    $licence_taker = $prod->get_licence_taker($o_id);

    ?>
    <input type="hidden" id="collection" name="collection" value="<?php echo $order['collection'] ?>">
    <p class="display-4 w-100 text-center mt-3"> Order ID <?php echo $o_id;
        if ($o_extension == 1) {
            ?>
            - <a href="<?php echo $_SERVER['PHP_SELF']; ?>?o_id=<?php echo $order['om_id']; ?>"
                 target="_blank"><?php echo $order['om_id']; ?></a>
            <?php
        }
        ?> - <?php echo $order['order_name']; ?></p>
    <div style="overflow-y:scroll;height:720px;min-height:1050px;">
    <div class="page-content pb-0">
        <div class="row w-100 mx-0 project-details d-flex justify-content-center pb-4">
            <div class="col-md-4">
                <p class="mb-0"><?php echo $order['o_date']; ?> (UTC+0)</p>
                <p class="mb-0">Licence ID <?php echo $licenceid . " - " . $licence_taker['Company']; ?></p>
                <p class="mb-0 d-inline">Purchaser: <?php echo $client['client_ID']; ?> -
                    Enterprise: <?php echo $client['clientname']; ?> - <?php
                    if (!empty($client['c_last_name'])) {
                        echo $client['c_last_name'] . ", " . $client['c_first_name'];
                    } else {
                        echo $client['l_last_name'] . ", " . $client['l_first_name'];
                    } ?> - <?php echo $client['phone']; ?></p>
            </div>
            <div class="col-md-4" id="conversation">
                <p class="mb-0 mb-xl-2"><strong>Conversations:</strong></p>
                <?php
                $allmessages = $prod->get_all_trader_purchaser_messages($o_id);

                for ($i = 0; $i < count($allmessages); $i++) {
                    if ($allmessages[$i]['client_id'] > 0) {
                        $client = $prod->get_client($allmessages[$i]['client_id']);
                    } elseif ($allmessages[$i]['uca_id'] > 0) {
                        $creator = $prod->get_client($allmessages[$i]['uca_id']);
                    }
                    ?>
                    <p class="mb-0 mb-xl-2"><?php
                        if ($allmessages[$i]['client_id'] > 0) {
                            echo "<b>" . $client['l_first_name'] . " " . $client['l_last_name'] . "</b>";
                        } elseif ($allmessages[$i]['uca_id'] > 0) {
                            if (!empty($creator['c_last_name'])) {
                                echo "<b>" . $creator['c_first_name'] . " " . $creator['c_last_name'] . "</b>";
                            } else {
                                echo "<b>" . $creator['l_first_name'] . " " . $creator['l_last_name'] . "</b>";
                            }
                        }

                        echo " (<b>" . $allmessages[$i]['msg_date'] . " UTC +0</b>): " . $allmessages[$i]['message'];
                        ?></p>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-4">
                <p class="d-md-inline text-center mb-0"><?php
                    if ($order['o_deadline'] != "0000-00-00 00:00:00") {
                        ?>
                        <span class="text-danger">Deadline: <input type="textbox" id="o_deadline"
                                                                   class="form-control form-control-sm text-danger d-inline"
                                                                   value="<?php echo $order['o_deadline']; ?>"
                                                                   style="width:170px;"> UTC+0</span>
                        <input type="hidden" id="new_o_deadline" name="new_o_deadline" value="<?php
                        echo $new_o_deadline = $prod->get_deadline_without_weekends($order['o_deadline']);
                        ?>">
                        <button id="o_deadline_btn" class="btn btn-sm btn-danger d-inline">Save</button>
                        <br><span class="text-danger">Time left: <b><span id="timeleft" class="blink"></span></b></span>
                        <?php
                    } else {
                        ?>
                        <input type="textbox" id="o_deadline" class="form-control form-control-sm text-success d-inline"
                               value="No Deadline" style="width:170px;"> UTC+0
                        <button id="o_deadline_btn" class="btn btn-sm btn-success d-inline">Save</button>
                        <?php
                    }
                    ?></p>

                <script type="text/javascript">
                    setInterval(function () {
                        //var deadline = new Date($('#o_deadline').val());
                        var deadline = moment.tz($('#o_deadline').val(), 'UTC');
                        var today = new Date();
                        var diff = (new Date(deadline).getTime() - new Date(today).getTime());
                        if (diff > (24 * 60 * 60 * 1000) || diff < 0) {
                            $('#timeleft').removeClass('blink');
                        } else {
                            $('#timeleft').addClass('blink');
                        }
                    }, 1000);

                    function countdown_timeleft() {
                        // timeleft
                        var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                        if ($('#o_deadline').val() != "") {
                            //var dateset = $('#o_deadline').val();
                            var deadline_time = moment.tz($('#new_o_deadline').val(), 'UTC');
                            var dateset = deadline_time.clone().tz(user_timezone).format('YYYY-MM-DD HH:mm:ss');
                            $('#timeleft').countdown(dateset, function (event) {
                                //$(this).html(event.strftime('%d days %H:%M:%S'));
                                $(this).html(event.strftime('%-D day%!D %H:%M:%S'));
                            });
                        }

                        if ($('#timeleft').text() == "00 days 00:00:00") {
                            $('#timeleft').removeClass('blink');
                        }
                    }

                    $(document).ready(function () {
                        countdown_timeleft();

                        $('#o_deadline').datetimepicker({
                            format: 'Y-m-d H:i'
                        });

                        $('#o_deadline_btn').click(function () {
                            $.ajax({
                                url: "../ajax/update_order_deadline.php",
                                method: "post",
                                data: {o_id:<?php echo $o_id;?>, o_deadline: $('#o_deadline').val()},
                                dataType: "html",
                                success: function (data) {
                                    console.log(data);
                                    countdown_timeleft();
                                }
                            });
                        });
                    });
                </script>
                <br>
                <a href="https://bauvorschau.com/<?php
                if ($order['om_id'] == 0) {
                    echo $o_id;
                } else {
                    echo $order['om_id'];
                } ?>" class="btn btn-warning btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
                   target="_blank">Presentation for clients</a><br>


                
                <?php if ($o_id == 1013) {
                    ?>
                    
                    <a href="https://cseven.eu/1013ext/"
                       class="btn btn-primary btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
                       target="_blank">Virtual reality Presentation</a>
                    <?php
                } ?>

                <input type="hidden" name="o_id" value="<?php echo $o_id; ?>">
                <input type="hidden" name="notifications" value="<?php echo $order['notifications']; ?>">
                <button class="btn btn-sm btn-danger px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
                        id="notification_btn">Notifications
                    <span> <?php echo ($order['notifications'] == 1) ? "are ON" : "are OFF"; ?></span></button>
                <script type="text/javascript">
                    $("#notification_btn").click(function () {
                        $.ajax({
                            url: "../ajax/update_notification.php",
                            method: "post",
                            data: {
                                o_id: $("input[name=o_id").val(),
                                notifications: $("input[name=notifications").val()
                            },
                            dataType: "html",
                            success: function (data) {
                                //console.log(data);	
                                if (data == 0) {
                                    $("input[name=notifications").val(0);
                                    $("#notification_btn").html("Notifications <span>are OFF</span>");
                                    $("#notification_btn").removeClass("btn-success").addClass("btn-danger");
                                } else {
                                    $("input[name=notifications").val(1);
                                    $("#notification_btn").html("Notifications <span>are ON</span>");
                                    $("#notification_btn").removeClass("btn-danger").addClass("btn-success");
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                console.log(xhr.status);
                                console.log(thrownError);
                            }
                        });
                    });
                </script>
                <br>
                <input type="hidden" name="on_stock" value="<?php echo $order['on_stock']; ?>">
                <button id="on_stock_btn"
                        class="btn btn-sm <?php echo ($order['on_stock'] == 0) ? "btn-success" : "btn-warning"; ?> px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"><?php echo ($order['on_stock'] == 0) ? "Normal! Put On Stock" : "Put On Normal"; ?></button>
                <script type="text/javascript">
                    $("#on_stock_btn").click(function () {
                        $.ajax({
                            url: "../ajax/update_on_stock.php",
                            method: "post",
                            data: {o_id: $("input[name=o_id").val(), on_stock: $("input[name=on_stock").val()},
                            dataType: "html",
                            success: function (data) {
                                console.log(data);
                                if (data == 0) {
                                    $("input[name=on_stock").val(0);
                                    $("#on_stock_btn").html("Normal! Put On Stock");
                                    $("#on_stock_btn").removeClass("btn-warning").addClass("btn-success");
                                } else {
                                    $("input[name=on_stock").val(1);
                                    $("#on_stock_btn").html("On Stock");
                                    $("#on_stock_btn").removeClass("btn-success").addClass("btn-warning");
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                console.log(xhr.status);
                                console.log(thrownError);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <?php
        $customer_files = $prod->get_customer_files($o_id);
        $lines = ceil(count($customer_files) / 2);

        ?>
        <div class="row mx-0 w-100 customers-files mt-3">
            <h4 class="w-100 text-center pl-4 text-secondary mb-3"><strong>Customer files:</strong></h4>
            <div class="col-xl-6 px-0 border-right border-secondary">
                <div class="row mx-0 w-100 title-row">
                    <div class="col-2">
                        <p class="text-center text-dark my-2"><strong>File Name</strong></p>
                    </div>
                    <div class="col-2">
                        <p class="text-center text-dark my-2"><strong>Note</strong></p>
                    </div>
                    <div class="col-1 px-0">
                        <p class="text-center text-dark my-2"><strong>Sub-title</strong></p>
                    </div>
                    <div class="col-1 px-0">
                        <p class="text-center my-2"><strong>In Sub-ID</strong></p>
                    </div>
                    <div class="col-1 px-0">
                        <p class="text-center my-2"><strong>Ex Sub-ID</strong></p>
                    </div>
                    <div class="col-3">
                        <p class="text-center my-2"><strong>Level</strong></p>
                    </div>
                    <div class="col-2">
                        <p class="text-center my-2">
                            <strong>Internal Name</strong>
                        </p>
                    </div>
                </div>
                <?php
                for ($i = 0;
                $i < count($customer_files);
                $i++)
                {

                if ($i == $lines)
                {

                ?>
            </div> <!-- end col 1 -->
            <div class="col-xl-6 px-0 border-left border-secondary">
                <div class="row mx-0 w-100 title-row">
                    <div class="col-2">
                        <p class="text-center text-dark my-2"><strong>File Name</strong></p>
                    </div>
                    <div class="col-2">
                        <p class="text-center text-dark my-2"><strong>Note</strong></p>
                    </div>
                    <div class="col-1 px-0">
                        <p class="text-center text-dark my-2"><strong>Sub-title</strong></p>
                    </div>
                    <div class="col-1 px-0">
                        <p class="text-center my-2"><strong>In Sub-ID</strong></p>
                    </div>
                    <div class="col-1 px-0">
                        <p class="text-center my-2"><strong>Ex Sub-ID</strong></p>
                    </div>
                    <div class="col-3">
                        <p class="text-center my-2"><strong>Level</strong></p>
                    </div>
                    <div class="col-2">
                        <p class="text-center my-2"><strong>Internal Name</strong></p>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="row mx-0 w-100 costomer-item py-2">
                    <div class="col-md-2 col-12 d-flex justify-content-md-start justify-content-center pl-4 pl-md-1 py-2 py-md-0">
                        <p class="text-center d-inline ellipsis align-self-center mb-0"><?php echo $customer_files[$i]['of_name_client']; ?></p>
                        <?php
                        if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                            ?>
                            <div id="customer_image_tooltip_container_<?php echo $image_preview_counter; ?>">
                                <img src="../client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>"
                                     class="img-responsive d-inline pl-2 cursor-pointer"
                                     alt="<?php echo $customer_files[$i]['of_name_client']; ?>" width="40" height="30">
                            </div>
                            <!--<script type="text/javascript">
                                $('#customer_image_tooltip_container_<?php
                            echo $image_preview_counter;
                            ?>').qtip({
                                    content: {
                                        text: '<img src="../img/loading.gif" alt="Loading...">', // The text to use whilst the AJAX request is loading
                                        ajax: {
                                            url: '../show_popup_image.php', // URL to the local file
                                            type: 'GET', // POST or GET
                                            data: {filecategory:'customerfiles',ofid:'<?php echo $customer_files[$i]['of_id']; ?>'} // Data to pass along with your request
                                        }
                                    },
                                    position: {
                                        target: $(window),
                                        my: 'center', 
                                        at: 'center'
                                    },
                                    show: { delay: 1000 },
                                    hide: { delay: 3000 },
                                    /*style: { /*classes: 'mytooltip', 
                                        tip: {
                                            width: 800,
                                            height: 600
                                        } }*/
                                });
                                </script> -->
                            <?php
                            $image_preview_counter++;
                        } elseif ($customer_files[$i]['of_type_dom'] == "pdf") {
                            ?>
                            <img src="../img/adobe-pdf-icon.png" class="d-inline pl-2"
                                 alt="<?php echo $customer_files[$i]['of_name_client']; ?>" width="40" height="30">
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-2 col-12 d-flex">
                        <div class="form-group w-100 align-self-center mb-0">
                            <select name="change_note<?php echo $i; ?>" id="change_note<?php echo $i; ?>"
                                    class="form-control form-control-sm">
                                <option>Error ! Choose an option</option>
                                <option value="<?php echo $customer_files[$i]['of_id']; ?>;1;" <?php echo ($customer_files[$i]['of_kind'] == 1) ? "selected" : ""; ?>>
                                    Order! Main file
                                </option>
                                <option value="<?php echo $customer_files[$i]['of_id']; ?>;8;" <?php echo ($customer_files[$i]['of_kind'] == 8) ? "selected" : ""; ?>>
                                    NO ORDER! Only for understanding
                                </option>
                                <option value="<?php echo $customer_files[$i]['of_id']; ?>;2;" <?php echo ($customer_files[$i]['of_kind'] == 2) ? "selected" : ""; ?>>
                                    Outview-Photo
                                </option>
                            </select>
                            <script type="text/javascript">
                                $('#change_note<?php echo $i;?>').change(function () {
                                    $.ajax({
                                        url: "<?php echo $base_url;?>ajax/change_customer_file.php",
                                        method: "get",
                                        data: {change_note: $(this).val(), option: "change_note"},
                                        dataType: "html",
                                        success: function (data) {
                                            console.log(data);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(thrownError);
                                        }
                                    });

                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-1 col-12 d-none d-md-block pl-4 pl-md-0">
                        <p class="text-center mb-0 align-self-center"><?php
                            if ($customer_files[$i]['of_subtitle'] == "") {
                                echo "&nbsp;";
                            } else {
                                echo $customer_files[$i]['of_subtitle'];
                            }
                            ?></p>
                    </div>
                    <div class="col-md-1 col-12 pl-4 pl-md-0 d-flex">
                        <div class="form-group w-100 align-self-center mb-0">
                            <select name="change_position<?php echo $i; ?>" id="change_position<?php echo $i; ?>"
                                    data-of_id="<?php echo $customer_files[$i]['of_id']; ?>"
                                    class="form-control form-control-sm">
                                <?php
                                for ($z = 0; $z < 100; $z++) {
                                    ?>
                                    <option value="<?php echo $z; ?>" <?php echo ($z == $customer_files[$i]['of_position']) ? "selected" : ""; ?>><?php echo $z; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $('#change_position<?php echo $i;?>').change(function () {
                                    $.ajax({
                                        url: "../ajax/change_customer_file.php",
                                        method: "get",
                                        data: {
                                            change_position: $(this).val(),
                                            of_id: $(this).data('of_id'),
                                            option: "change_position"
                                        },
                                        dataType: "html",
                                        success: function (data) {
                                            console.log(data);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(thrownError);
                                        }
                                    });

                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-1 col-12 pl-4 pl-md-0 d-flex">
                        <div class="form-group w-100 align-self-center mb-0">
                            <select name="change_position<?php echo $i; ?>"
                                    id="change_exterior_position<?php echo $i; ?>"
                                    data-of_id="<?php echo $customer_files[$i]['of_id']; ?>"
                                    class="form-control form-control-sm">
                                <?php
                                for ($z = 0; $z < 100; $z++) {
                                    ?>
                                    <option value="<?php echo $z; ?>" <?php echo ($z == $customer_files[$i]['of_exterior_position']) ? "selected" : ""; ?>><?php echo $z; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $('#change_exterior_position<?php echo $i;?>').change(function () {
                                    $.ajax({
                                        url: "../ajax/change_customer_file.php",
                                        method: "get",
                                        data: {
                                            change_exterior_position: $(this).val(),
                                            of_id: $(this).data('of_id'),
                                            option: "change_exterior_position"
                                        },
                                        dataType: "html",
                                        success: function (data) {
                                            console.log(data);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(thrownError);
                                        }
                                    });

                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content-md-center pb-2 pb-md-0 col-12 d-flex justify-content-center pl-4 pl-md-0">
                        <div class="form-group d-inline mb-0 align-self-center w-100">
                            <select name="change_level<?php echo $i; ?>" id="change_level<?php echo $i; ?>"
                                    class="form-control form-control-sm d-inline">
                                <?php
                                for ($z = -4; $z < 0; $z++) {
                                    ?>
                                    <option value="<?php echo $customer_files[$i]['of_id']; ?>;<?php echo "L " . $z; ?>;" <?php echo ("L " . $z == $customer_files[$i]['of_level']) ? "selected" : ""; ?>><?php echo "L " . $z; ?></option>
                                    <?php
                                }
                                ?>
                                <?php
                                for ($z = 0; $z < 10; $z++) {
                                    ?>
                                    <option value="<?php echo $customer_files[$i]['of_id']; ?>;<?php echo "L 0" . $z; ?>;" <?php echo ("L 0" . $z == $customer_files[$i]['of_level']) ? "selected" : ""; ?>><?php echo "L 0" . $z; ?></option>
                                    <?php
                                }
                                ?>
                                <?php
                                for ($z = 10; $z < 100; $z++) {
                                    ?>
                                    <option value="<?php echo $customer_files[$i]['of_id']; ?>;<?php echo "L " . $z; ?>;" <?php echo ("L " . $z == $customer_files[$i]['of_level']) ? "selected" : ""; ?>><?php echo "L " . $z; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $('#change_level<?php echo $i;?>').change(function () {
                                    $.ajax({
                                        url: "../ajax/change_customer_file.php",
                                        method: "get",
                                        data: {change_level: $(this).val(), option: "change_level"},
                                        dataType: "html",
                                        success: function (data) {
                                            console.log(data);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(thrownError);
                                        }
                                    });

                                });
                            </script>
                        </div>
                        <a href="../image.php?filecategory=customerfiles&imageid=<?php echo $customer_files[$i]['of_id']; ?>"
                           class="btn btn-sm btn-secondary align-self-center ml-1">Download</a>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center pb-2 pb-md-0 col-12 pl-4 pl-md-0">
                        <div class="form-group d-inline align-self-center ml-2 mb-0">
                            <input type="hidden" name="of_id" id="of_id<?php echo $i; ?>"
                                   value="<?php echo $customer_files[$i]['of_id']; ?>">
                            <input type="text" name="of_name" id="of_name<?php echo $i; ?>"
                                   class="form-control form-control-sm"
                                   value="<?php echo $customer_files[$i]['of_name']; ?>" placeholder="Interior">
                            <input type="text" name="of_name_ex" id="of_name_ex<?php echo $i; ?>"
                                   class="form-control form-control-sm"
                                   value="<?php echo $customer_files[$i]['of_name_ex']; ?>" placeholder="Exterior">
                        </div>
                        <!-- <button type="button" name="rename_btn" id="rename_btn<?php echo $i; ?>" class="btn btn-sm btn-secondary d-inline align-self-center ml-2" disabled>Name</button> -->
                        <script type="text/javascript">
                            $('#rename_btn<?php echo $i;?>').click(function () {
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_customer_file.php",
                                    method: "get",
                                    data: {
                                        of_id: $("#of_id<?php echo $i;?>").val(),
                                        of_name: $("#of_name<?php echo $i;?>").val(),
                                        of_name_ex: $("#of_name_ex<?php echo $i;?>").val(),
                                        option: "rename_customer_file"
                                    },
                                    dataType: "html",
                                    success: function (data) {
                                        console.log(data);
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <?php
                }
                ?>
            </div> <!-- end col 1 -->
        </div> <!-- end customer files -->
    </div>
    <div class="row mx-0 w-100 customer-remarks text-center pt-2 bg-light border-top">
        <div class="col-xl-2 col-12">
            <p class="mb-0 mb-xl-2"><strong>Customer remarks interior</strong></p>
            <?php
            if (empty($order['clients-extras'])) {
                ?>
                <p class="mb-0 mb-xl-2">NONE</p>
                <?php
            } else {
                ?>
                <p class="text-danger text-left mb-0 mb-xl-2"><?php echo nl2br($order['clients-extras']); ?></p>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-2 col-12">
            <p class="mb-0 mb-xl-2"><strong>Operator remarks interior</strong></p>
            <?php
            if (empty($order['op-remarks'])) {
                ?>
                <p class="mb-0 mb-xl-2">NONE</p>
                <?php
            } else {
                ?>
                <p class="text-danger text-left mb-0 mb-xl-2"><?php echo nl2br($order['op-remarks']); ?></p>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-3 col-12">
            <p class="mb-0 mb-xl-2"><strong>Customer remarks exterior</strong></p>
            <?php
            if (empty($order['client_extras_ex_b5'])) {
                ?>
                <p class="mb-0 mb-xl-2">NONE</p>
                <?php
            } else {
                ?>
                <p class="text-danger text-left mb-0 mb-xl-2"><?php echo nl2br($order['client_extras_ex_b5']); ?></p>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-3 col-12">
            <p class="mb-0 mb-xl-2"><strong>Operator remarks exterior</strong></p>
            <?php
            if (empty($order['op_remarks_ex_b5'])) {
                ?>
                <p class="mb-0 mb-xl-2">NONE</p>
                <?php
            } else {
                ?>
                <p class="text-danger text-left mb-0 mb-xl-2"><?php echo nl2br($order['op_remarks_ex_b5']); ?></p>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-2 col-12">
            <p class="mb-0 mb-xl-2"><strong>Environment_address</strong></p>
            <?php
            if (empty($order['environment_address'])) {
                ?>
                <p class="mb-0 mb-xl-2">NONE</p>
                <?php
            } else {
                ?>
                <p class="text-danger text-left mb-0 mb-xl-2"><?php echo nl2br($order['environment_address']); ?></p>
                <?php
            }
            ?>
        </div>
    </div>

    <?php
    include('test.php');
    }//end o_id

    //include('../online_creators.php');
    ?>

    <?php
}
else {
    session_unset();
    session_destroy();
    ?>
    <div class="alert alert-danger">
        You must be logged in to view this page !
        <a href="<?php echo $base_url; ?>index.php" class="btn btn-danger btn-sm">Login</a>
        <br><br>
    </div>
    <meta http-equiv="refresh" content="3; url=<?php echo $base_url; ?>index.php">
    <?php
}
?>
    <!-- </div> -->
    </div>


<?php require "../../footer.php" ?>