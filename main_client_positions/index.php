<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('../functions.php');

$prod = new Production;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

$page_title="Main Client Positions";

include('../header2.php');
include('../menu.php');

?>
    <section class="top_section">
        <article>
            <?php
            if (isset($_COOKIE['client_id']) && ($_COOKIE['start'] < $_COOKIE['expire'])) {
                ?>
                <div class="container bg-white shadow">
                    <!-- <h3>Clients</h3> -->
                    <p class="pt-4 w-100 display-4 text-center">Main Client Positions</p>
                    <hr width="450px">
                    <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">                        
                        <a href="create.php" class="btn btn-sm btn-primary mx-4 border">Create new main client position</a>                        
                    </div>
                <table class="table table-striped mt-5"
                       style="font-size: 13px; overflow-y: auto;height: 520px; display: block; border-collapse: separate; border-spacing: 0;">
                    <thead class="text-center">
                    <tr>
                        
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Main Client</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Position number</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Boss Client id</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">Name</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white">E-mail</th>
                        <th style="position: sticky; top: -10px;" scope="col" class="bg-white"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $all_client_bosses=$prod->get_all_client_bosses();

                    for ($i = 0; $i < count($all_client_bosses); $i++) 
                    {
                        $client=$prod->get_client($all_client_bosses[$i]['boss_c_id']);
                            ?>
                            <tr id="client<?php echo $all_client_bosses[$i]['ucb_id']; ?>" class="text-center clients">
                                <td class="py-2" scope="row"><?php 
                                $main_cient=$prod->get_main_client($all_client_bosses[$i]['mc_id']);
                                echo $main_cient['clientname']; ?></td>
                                <td class="py-2"><?php echo $all_client_bosses[$i]['position_nr']; ?></td>
                                <td class="py-2">
                                    <?php
                                    echo $all_client_bosses[$i]['boss_c_id'];
                                     ?>
                                </td>
                                <td class="py-2">
                                    <?php
                                    echo $client['c_last_name'].", ".$client['c_first_name'];
                                    ?>
                                </td>
                                <td class="py-2">
                                    <?php
                                    echo $client['email'];
                                    ?>
                                </td>
                                <td class="py-2">
                                    <a href="modify.php?ucb_id=<?php echo $all_client_bosses[$i]['ucb_id']; ?>" class="btn btn-sm btn-primary">Modify</a>
                                    <button id="delete_btn<?php echo $all_client_bosses[$i]['ucb_id']; ?>" data-ucb_id="<?php echo $all_client_bosses[$i]['ucb_id']; ?>" type="button" class="btn btn-sm btn-danger">X</button>
                                </td>
                                
                                    <!--</form> -->
                                    <script type="text/javascript">
                                        $('#delete_btn<?php echo $all_client_bosses[$i]['ucb_id'];?>').click(function () 
                                        {
                                            if(confirm('Are you sure want do delete ?'))
                                            {
                                                $.ajax({
                                                    url: "../ajax/delete_main_client_position.php",
                                                    method: "post",
                                                    data: {ucb_id:$(this).data("ucb_id")},
                                                    dataType:"html",
                                                    success:function(data) {
                                                        $('#client<?php echo $all_client_bosses[$i]['ucb_id'];?>').fadeOut(2000);
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                console.log(xhr.status);
                                                console.log(thrownError);
                                            }
                                            });

                                            }
                                            
                                        });

                                        
                                    </script>
                                </td>
                            </tr>
                            <?php
                        
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

<?php
include('../footer.php');
?>