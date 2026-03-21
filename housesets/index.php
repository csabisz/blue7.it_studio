<?php
session_start();
include('../functions.php');

$prod=new Production;

$page_title="House-sets";

include('../header2.php');
include('../menu.php');
//$housesets = $prod->get_all_houses_types();
$housesets=array();
?>
<section class="top_section">
	<article>
	<div class="container pagecontent" style="background-color:#bcbcbc;">
	<?php
	if(isset($_COOKIE['client_id']))
	{		
        if(isset($_GET['search_btn']))
        {
            
            $housesets_data['depth1']=$prod->xss_fix($_GET['depth1']);
            $housesets_data['depth2']=$prod->xss_fix($_GET['depth2']);

            $housesets_data['surface1']=$prod->xss_fix($_GET['surface1']);
            $housesets_data['surface2']=$prod->xss_fix($_GET['surface2']);

            $housesets_data['width1']=$prod->xss_fix($_GET['width1']);
            $housesets_data['width2']=$prod->xss_fix($_GET['width2']);

            $housesets_data['height1']=$prod->xss_fix($_GET['height1']);
            $housesets_data['height2']=$prod->xss_fix($_GET['height2']);

            $housesets_data['stories1']=$prod->xss_fix($_GET['stories1']);
            $housesets_data['stories2']=$prod->xss_fix($_GET['stories2']);

            $housesets_data['roof_tilt1']=$prod->xss_fix($_GET['roof_tilt1']);
            $housesets_data['roof_tilt2']=$prod->xss_fix($_GET['roof_tilt2']);

            $housesets_data['building_company']=$prod->xss_fix($_GET['building_company']);

            $housesets_data['order_option']=$prod->xss_fix($_GET['order_option']);
            $housesets_data['order_id']=$prod->xss_fix($_GET['order_id']);

            $housesets_data['order_by']=$prod->xss_fix($_GET['order_by']);

            if(
            ((!empty($housesets_data['depth1']))&&(!empty($housesets_data['depth2'])))||
            ((!empty($housesets_data['surface1']))&&(!empty($housesets_data['surface2'])))||
            ((!empty($housesets_data['width1']))&&(!empty($housesets_data['width2'])))||
            ((!empty($housesets_data['height1']))&&(!empty($housesets_data['height2'])))||
            ((!empty($housesets_data['stories1']))&&(!empty($housesets_data['stories2'])))||
            ((!empty($housesets_data['roof_tilt1']))&&(!empty($housesets_data['roof_tilt2'])))||
            (!empty($housesets_data['order_id']))||
            (!empty($housesets_data['building_company']))
            )
            {
                $housesets=$prod->get_all_house_types_by_parameters(json_encode($housesets_data));
                
            }
        }							
		?>
        <p class="w-100 text-center display-4 pt-4">House-sets</p>  
        <hr class="mb-4" width="450px">
        <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
            <a href="create.php" class="btn btn-sm btn-primary mx-3 border">Add new House-set</a>
            <a href="translations.php" class="btn btn-sm btn-primary mx-3 border">Translations</a>            
            <a href="orders.php" class="btn btn-sm btn-primary mx-3 border">Orders</a>
        </div>
        <div class="row">
            <form id="search_houseset_form" name="search_houseset_form" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>"></form>
            <div class="col">
                <input type="text" id="depth1" name="depth1" placeholder="Min depth(cm)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['depth1'];
                ?>">
                <input type="text" id="depth2" name="depth2" placeholder="Max depth(cm)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['depth2'];
                ?>">
                <br>
                <input type="text" id="surface1" name="surface1" placeholder="Min surface(㎡)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['surface1'];
                ?>">
                <input type="text" id="surface2" name="surface2" placeholder="Max surface(㎡)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['surface2'];
                ?>">
            </div>
            <div class="col">
                <input type="text" id="width1" name="width1" placeholder="Min width(cm)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['width1'];
                ?>">
                <input type="text" id="width2" name="width2" placeholder="Max width(cm)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['width2'];
                ?>">
                <br>
                <input type="text" id="height1" name="height1" placeholder="Min height(cm)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['height1'];
                ?>">
                <input type="text" id="height2" name="height2" placeholder="Max height(cm)" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['height2'];
                ?>">
            </div>
            <div class="col">
                <input type="text" id="roof_tilt1" name="roof_tilt1" placeholder="Min roof tilt" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['roof_tilt1'];
                ?>">
                <input type="text" id="roof_tilt2" name="roof_tilt2" placeholder="Max roof tilt" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['roof_tilt2'];
                ?>">
                <br>
                <input type="text" id="stories1" name="stories1" placeholder="Min stories" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['stories1'];
                ?>">
                <input type="text" id="stories2" name="stories2" placeholder="Max stories" class="form-control form-control-sm" form="search_houseset_form" value="<?php 
                echo $housesets_data['stories2'];
                ?>">
                
            </div>
            
            <div class="col">
                <select id="building_company" name="building_company" class="form-control form-control-sm" form="search_houseset_form" required>
                    <option value="">--Building company--</option>
                    <?php
                    $building_company = $prod->get_building_company2();
                    
                    for ($i = 0; $i < count($building_company); $i++) 
                    {
                        if (!empty($building_company[$i]['clientname'])) 
                        {
                            if($building_company[$i]['c_status']=="active")
                            {
                            ?>
                            <option value="<?php echo $building_company[$i]['builders_id']; ?>" <?php echo ($building_company[$i]['builders_id']==$housesets_data['building_company'])?"selected":"";?>><?php echo $building_company[$i]['clientname']; ?></option>
                            <?php
                            }
                        }
                    }
                    ?>
                    <option value="">-------------------------------</option>
                    <?php
                    for ($i = 0; $i < count($building_company); $i++) 
                    {
                        if (!empty($building_company[$i]['clientname'])) 
                        {
                            if($building_company[$i]['c_status']=="inactive")
                            {
                            ?>
                            <option value="<?php echo $building_company[$i]['builders_id']; ?>" <?php echo ($building_company[$i]['builders_id']==$housesets_data['building_company'])?"selected":"";?>><?php echo $building_company[$i]['clientname']; ?></option>
                            <?php
                            }
                        }
                    }?>
                </select>
                <br>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                    <select id="order_option" name="order_option" class="form-control form-control-sm" form="search_houseset_form">                   
                        <option value="example_id">Example ID</option>
                        <option value="material_id">Material ID</option>        
                    </select>
                    <input type="text" id="order_id" name="order_id" placeholder="Example or material ID" class="form-control form-control-sm" form="search_houseset_form" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    Order by <br>
                    <select id="order_by" name="order_by" class="form-control form-control-sm" form="search_houseset_form">                   
                        <option value="house_id" <?php echo ($_GET['order_by']=="house_id")?"selected":"";?>>House ID</option>
                        <option value="house_name" <?php 
                        if(
                            ($_GET['order_by']=="house_name")||(empty($_GET['order_by']))
                            )
                        {
                            echo "selected";
                        }
                        ?>>House name</option>        
                    </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <button id="search_btn" name="search_btn" class="btn btn-sm btn-primary" type="submit" form="search_houseset_form" value="search_btn">Search</button>
            </div>
        </div>
        <br>
        <div class="row">
        <div class="col-md-12">
        <?php 
        if(isset($_POST['status']))
        { 
            $stat = $_POST['status'];           
            $pres_id = $_POST['house_id'];
            $prod->change_planset_status($stat,$pres_id);
            ?>        
            <div class="text-center">
                <div class="alert alert-success">
                    House-set status changed!
                </div>
            </div>
            <br>
            <meta http-equiv="refresh" content="1; url=index.php">
        <?php
        }

       
        if (isset($_POST['remove_btn'])){
            $pres_id = $_POST['pres_id'];
            $house_id = $_POST['house_id'];
            
            $prod->delete_from_plansets($house_id);
            $prod->delete_from_planset_spseven($house_id);
            $prod->delete_from_o_infos_all_prod($pres_id);
            
            
        ?>
        
        <div class="text-center">
            <div class="alert alert-success">
                House-set Removed
            </div>
        </div>
        <br>
        <meta http-equiv="refresh" content="2; url=/plansets/index.php">
        <?php
            }
        ?>
        </div>
        <?php 
            
            for($i=0;$i<count($housesets);$i++)
            {
                ?>
                <div class="col-sm-4 mb-2">
                    <div class="card w-100 h-100">
                    <div class="card-body text-center">
                        <form class="d-inline" name="plan_form<?php echo $i; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="POST">
                            <h5 class="card-title "><?php echo $housesets[$i]['house_name']; ?></h5>
                            <p><b>House ID: <?php echo $housesets[$i]['house_id']; ?></b></p>
                            <?php 
                            $data = json_decode(file_get_contents("https://cseven.eu/presentation/api2/order/".$housesets[$i]['presentation_id']."/"."www.bauvorschau.com"."/"."12345"), TRUE);                                        
                            ?>
                            <img src="<?php 
                            if(!empty($data['exterior_subcategories'][0]['image_list'][0]['compress']))
                            {                                        
                                echo $data['first_image'];
                            }
                            
                            ?>" alt="No Image">
                            <br><br>
                            <a href="details.php?id=<?php echo $housesets[$i]['house_id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i>Edit</a>    
                            <input type="hidden" name="pres_id" value="<?php echo $housesets[$i]['presentation_id']; ?>">         
                            <input type="hidden" name="house_id" value="<?php echo $housesets[$i]['house_id']; ?>">         
                            <button class="btn btn-danger" name="remove_btn" onclick="return confirm('Are you sure want do delete ?')" type="submit"><i class="fas fa-trash"></i></button>
                            <p class="card-text"><?php echo $housesets[$i]['house_description']; ?></p>
                            <?php
                            if(!empty($housesets[$i]['presentation_id']))
                            {
                            ?>
                            <p class="m-0"><a href="https://bauvorschau.com/<?php echo $housesets[$i]['presentation_id']; ?>" target="_blank">Example ID: <?php echo $housesets[$i]['presentation_id']; ?></a></p>
                            <?php
                            }

                            if(!empty($housesets[$i]['material_id']))
                            {
                            ?>                    
                            <p class="m-0"><a href="https://bauvorschau.com/<?php echo $housesets[$i]['material_id']; ?>" target="_blank">Material ID: <?php echo $housesets[$i]['material_id']; ?></a></p>
                            <?php 
                            }
                            ?>
                        </form>
                    </div>
                    <?php 
                    $plan_sp7 = $prod->get_plans_sp7($housesets[$i]['house_id']);
                    // $tof = $prod->get_tof_by_house_id($housesets[$i]['house_id']);
                    ?>
                    <p class="w-100 text-center display-5 pt-2">Uploaded architectural files: 
                    <?php 
                        
                        echo " "; echo count($plan_sp7); 
                        echo $plan_obj_abbr = $prod->get_pl_obj_abbr($plan_sp7['plan_kind']);  
                        $pdfnr=0; $cadnr = 0;
                        for ($y=0; $y < count($plan_sp7); $y++) { 
                            if($plan_sp7[$y]['filetype']=="pdf") $pdfnr++;
                            if($plan_sp7[$y]['filetype']=="cad") $cadnr++;
                        }
                        echo "<br>";
                        if(count($plan_sp7)!=0){ echo "PDFfiles: " . $pdfnr; echo " - CADfiles: " .$cadnr; }
                    ?></p> 
                    </div>
                </div> 
                <?php 
        } 
        ?>
        </div>
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
	<div class="error text-center">You must be logged in to view this page !</div>
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