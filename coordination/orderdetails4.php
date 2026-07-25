<?php
session_start();
include('../functions.php');
include('../notifications.php');

$prod = new Production;
$notification = new Notifications;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

$o_id = $prod->xss_fix($_GET['o_id']);
$page_title="Coordination - ".$o_id;

include("../header2.php");
include('../menu.php');
?>

    <div class="page-content top_section">

<?php
if (isset($_COOKIE['client_id']) && ($_COOKIE['start'] < $_COOKIE['expire']))
{
if (isset($_GET['o_id']))
{


    $o_id = $prod->xss_fix($_GET['o_id']);
    $image_preview_counter = 0;
    $validextensions = array("jpeg", "jpg", "png","webp");
    $panorama = 0;

    $order = $prod->get_order($o_id);
    $o_extension = $order['o_extension'];
    $clientid = $order['u_client_ID'];
    $client = $prod->get_client($clientid);
    $licenceid = $order['lic_ID'];

    $licence_taker = $prod->get_licence_taker($o_id);

    ?>
    <input type="hidden" id="collection" name="collection" value="<?php echo $order['collection'] ?>">
<div id="header_order_id" class="" style="background-color: #FBFBFB; padding: 10px;">

    <p class="display-4 w-100 text-center mt-3"> Order ID <?php echo $o_id;
        if ($o_extension == 1) {
            ?>
            - <a href="<?php echo $_SERVER['PHP_SELF']; ?>?o_id=<?php echo $order['om_id']; ?>"
                 target="_blank"><?php echo $order['om_id']; ?></a>
            <?php
        }
        ?> - <?php echo $order['order_name']; ?></p>

    <style>
        .sticky-order{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            padding: 0px;
        }
        .sticky-order p {
            transition: font-size 0.5s;
            font-size: 2rem;
            font-weight: 500;
        }
    </style>

    <script>
        /*
        window.addEventListener("scroll", function() {
            let orderHeader = document.getElementById("header_order_id");

            if (window.pageYOffset > 0) {
                orderHeader.classList.add("sticky-order");
            } else {
                orderHeader.classList.remove("sticky-order");
            }
        });*/

    </script>
</div>

    <div style="">
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
                <p class="d-md-inline text-center mb-0 ml-4"><?php
                    if ($order['o_deadline'] != "0000-00-00 00:00:00") {
                        ?>
                        <span class="text-danger">Deadline: <input type="textbox" id="o_deadline"
                                                                   class="form-control form-control-sm text-danger d-inline"
                                                                   value="<?php echo $order['o_deadline']; ?>"
                                                                   style="width:170px;"></span>
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

                        let o_database_deadline=$('#o_deadline').val();

                        var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                        if(o_database_deadline!="No Deadline")
                        {

                            $.ajax({

                                url: "../ajax/get_order_deadline.php",
                                method: "get",
                                data: {o_deadline:o_database_deadline,client_time_zone:user_timezone},
                                dataType:"html",
                                success:function(data) {

                                    $('#o_deadline').val(data);
                                }

                            });
                        }

                        $('#o_deadline_btn').click(function () {

                            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                            $.ajax({
                                url: "../ajax/update_order_deadline.php",
                                method: "post",
                                data: {o_id:<?php echo $o_id;?>, o_deadline: $('#o_deadline').val(),client_time_zone:user_timezone},
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

                <div id="side_menu" style="display: flex; flex-direction: column; width: 200px" >
                    <style>#side_menu * {margin-top: 5px}</style>
                <a href="https://bauvorschau.com/<?php
                if ($order['om_id'] == 0) {
                    echo $o_id;
                } else {
                    echo $order['om_id'];
                } ?>/tour" class="btn btn-success btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
                   target="_blank">Presentation</a><br>
                

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
                ?>" class="btn orange btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
                   target="_blank">Checkation</a><br>
                <?php if ($o_id == 1013) {
                    ?>
                    
                    <a href="https://cseven.eu/1013ext/"
                       class="btn btn-primary btn-sm px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
                       target="_blank">Virtual reality Presentation</a>
                    <?php
                } ?>

                <input type="hidden" name="o_id" value="<?php echo $o_id; ?>">
                <input type="hidden" name="notifications" value="<?php echo $order['notifications']; ?>">
                <button class="btn btn-sm <?php echo ($order['notifications'] == 1) ? "btn-success" : "btn-dark"; ?> px-2 ml-4 mr-auto mr-md-0 ml-md-4 ml-auto d-md-inline"
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
                                    $("#notification_btn").removeClass("btn-success").addClass("btn-dark");
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
        </div>
        <div id="all_customer_files" style="width: fit-content; margin: auto;">

        </div>
        <script type="text/javascript">

        $(document).ready(function(){

            get_customer_files();

        });

        function get_customer_files()
        {
            let o_id=<?php echo $o_id;?>;

            $.ajax({
                url: "../ajax/ajax_customer_files.php",
                method: "get",
                data: {o_id:o_id},
                dataType:"html",
                success:function(data) {
                    $('#all_customer_files').html(data);
                    $("#trigger").click();
                }
            }).done(function(){

                // setTimeout(function(){imagePreview();},2000);

            });
        }

        </script>
        
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

    <div class="row mx-0 w-100" style="border-top: 4px solid #000;background: green;color:white;">
        <div class="col-md-auto">
            <b>Assign all tasks to this creator:</b>
        </div>
        <div class="col-md-2">
            <select name="creators_<?= $prod_class ?>" id="creators_<?= $prod_class ?>" class="form-control form-control-sm">
                <option value="">-- Choose creator --</option>
                
            </select>
        </div>
    </div>

    <?php
    $global_creator_counter = 0;
    include('products.php');

    }
    ?>

    <?php
}
else {
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

    <button id="trigger" style="opacity: 0;" onClick="removeBr()">

        <script>

            function removeBr() {
                $("#all_customer_files").find(".removeBr").each(function() {
                    // Remove all <br> elements within each div with class "removeBr"
                    $(this).find("br").remove();
                    $(this)[0].parentElement.style.wordBreak = "break-all";
                });
            }

            document.addEventListener("DOMContentLoaded", function() {
                removeBr(); // Call your function here
            });

        </script>

<?php require "../footer.php" ?>