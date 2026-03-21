<?php
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
include('../menu.php');
?>
<section class="top_section">
    <article>
        <div class="container pagecontent bg-white px-0">
            <?php
	if(isset($_COOKIE['client_id']))
	{									
		?>
            <p class="w-100 text-center display-4 pt-4">New House-set</p>
            <hr class="mb-4" width="450px">
            <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
                <a href="index.php" class="btn btn-sm btn-primary mx-3 border">List of House-sets</a>
            </div>
            <?php 
	include('submenu.php'); 
	if(isset($_POST['create_btn']))
	{		
			    
        $general_info['planset_id'] = $prod->xss_fix($_POST['planset_id'] ?? 0); 
        $general_info['house_name'] = $prod->xss_fix($_POST['house_name'] ?? ''); 
        $general_info['presentation_id'] = $prod->xss_fix($_POST['presentation_id'] ?? 0); 
        $general_info['material_id'] = $prod->xss_fix($_POST['material_id'] ?? 0);
        $general_info['price_building'] = $prod->xss_fix($_POST['price_building'] ?? 0); 
        $general_info['b_price_1'] = $prod->xss_fix($_POST['b_price_1'] ?? 0);
        $general_info['b_price_2'] = $prod->xss_fix($_POST['b_price_2'] ?? 0);
        $general_info['b_price_3'] = $prod->xss_fix($_POST['b_price_3'] ?? 0);
        $general_info['b_price_4'] = $prod->xss_fix($_POST['b_price_4'] ?? 0);
        $general_info['b_price_5'] = $prod->xss_fix($_POST['b_price_5'] ?? 0);
        $general_info['building_company'] = $prod->xss_fix($_POST['building_company'] ?? 0);
        $general_info['mc_id'] = $prod->get_client($prod->xss_fix($_POST['building_company']))['mc_id'];  
        $general_info['house_description'] = $prod->xss_fix($_POST['house_description'] ?? '');

        $prod->add_houseset_general_info(json_encode($general_info));
        ?>
        <div class="alert alert-success" role="alert">
            <p class="text-center">House-set Added </p>
        </div>
        <br>
        <meta http-equiv="refresh" content="3; url=index.php">
        <?php  
	}
?>
            <br><br>
            <form name="register_form" method="post" action="create.php" enctype="multipart/form-data">
            <iv class="row mx-0 w-100">
                <div class="col-md-12 pt-4 pb-4 border">
                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="planset_id">Planset ID
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="input-group input-group-sm col-md-6">
                            <input class="form-control" type="text"
                                    id="planset_id" name="planset_id"
                                    value="">
                            
                        </div>
                        <div class="col-md-3">
                            <?php
                            $planset = $prod->get_planset_by_pls_id($houseset['planset_id']);

                            echo $planset['pls_name'];
                            ?>
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="house_name">House name
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="house_name" name="house_name"
                                    value="">
                        </div>
                    </div>
                    
                    <!-- <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="owner">Planset from <?php //echo $_POST['owner']; ?>
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <select class="custom-select" name="owner">
                                <option value="">None</option>
                                <?php
                                $owner = $prod->get_owner();
                                for ($i = 0; $i < count($owner); $i++) {
                                    if (!empty($owner[$i]['l_first_name'])) {
                                        ?>
                                        <option value="<?php echo $owner[$i]['client_ID']; ?>" <?php if (($houseset['pls_owner']) == $owner[$i]['client_ID']) {
                                            echo 'selected';
                                        } ?>><?php echo $owner[$i]['l_last_name'];
                                            echo ' ';
                                            echo $owner[$i]['l_first_name']; ?></option>
                                        <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div> -->
                    <!--<div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="mc_id">Main client
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $main_client = $prod->get_main_client($houseset['mc_id']);
                            echo $main_client['clientname'];
                            ?>
                        </div>
                    </div> -->
                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="presentation_id">Presentation ID</label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="presentation_id" name="presentation_id"
                                    value="">
                        </div>
                    </div>

                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="price_building">Building Price
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="price_building" name="price_building"
                                    value="">
                        </div>
                    </div>


                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="b_price_1">Bausatz Price (b_price_1)
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="b_price_1" name="b_price_1"
                                    value="">
                        </div>
                    </div>


                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="b_price_2">Ausbauhaus Price (b_price_2)
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="b_price_2" name="b_price_2"
                                    value="">
                        </div>
                    </div>


                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="b_price_3">Technikfertig Price (b_price_3)
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="b_price_3" name="b_price_3"
                                    value="">
                        </div>
                    </div>

                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="b_price_4">Nearly done Price (b_price_4)
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="b_price_4" name="b_price_4"
                                    value="">
                        </div>
                    </div>

                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="b_price_5">Schlüsselfertig Price (b_price_5)
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" type="text"
                                    id="b_price_5" name="b_price_5"
                                    value="">
                        </div>
                    </div>

                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="building_company">Building Company
                                <div class="error" style="display:inline-flex;">&nbsp;*</div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <select class="custom-select" name="building_company">
                                <option value="0">None</option>
                                <?php

                                $building_company = $prod->get_building_company2();
                                // print_r($building_company);
                                for ($i = 0; $i < count($building_company); $i++) {
                                    if (!empty($building_company[$i]['clientname'])) {
                                        ?>
                                        <option value="<?php echo $building_company[$i]['builders_id']; ?>" <?php if (($houseset['builders_id']) == $building_company[$i]['builders_id']) {
                                            echo 'selected';
                                        } ?>><?php echo $building_company[$i]['clientname']; ?></option>
                                        <?php
                                    }
                                } ?>
                            </select>

                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="col-md-4 offset-1">
                            <label for="house_description">Description </label>
                        </div>
                        <div class="col-md-6">
                            <textarea class="form-control form-control-sm"
                                        name="house_description" id="house_description"
                                        cols="10"
                                        rows="10"></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row w-100 mx-0 mt-3 d-flex justify-content-center">
                <div class="col-md-2 d-flex justify-content-end">
                    <div class="center_message w-100">
                        <button type="submit" name="create_btn"
                            class="btn btn-primary btn-sm btn-block">Create</button>
                    </div>
                </div>
            </div>
            </form>
            <br>

            <?php		
	}
	else
	{
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
            <div class="center_message">
                <div class="error">You must be logged in to view this page !</div>
                <a href="../index.php" class="btn btn-danger btn-sm">Login</a>
                <br><br>
            </div>
            <meta http-equiv="refresh" content="3; url=../index.php">
            <?php
	}
	?>
        </div>
    </article>
</section>
<?php
include('../footer.php');
?>