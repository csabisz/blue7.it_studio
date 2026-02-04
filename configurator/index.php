<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Configurator</h1>
<?php
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
include('../menu.php');
$planset = $prod->get_all_plansets();

?>
<section class="acceptance pt-5">
    <article>
        <div class="container pagecontent bg-white ">
            <?php
	if(isset($_SESSION['client_id']))
	{

		?>
            <p class="w-100 text-center display-4 pt-4">Configurator Plansets</p>
            <hr class="mb-4" width="450px">
            <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
                <a href="/plansets/create.php" class="btn btn-sm btn-primary mx-3 border">Add new Planset</a>
                <a href="/plansets/translations.php" class="btn btn-sm btn-primary mx-3 border">Translations</a>
                <a href="/configurator/setings.php" class="btn btn-sm btn-primary mx-3 border">Main Settings</a>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php
        if(isset($_POST['configurator_status'])){
            $stat = $_POST['configurator_status'];
            $pres_id = $_POST['house_id'];
            $prod->change_planset_status_for_configurator($stat,$pres_id);


                    ?>

                    <div class="text-center">
                        <div class="alert alert-success">
                            Planset status changed!
                        </div>
                    </div>
                    <br>
                    <meta http-equiv="refresh" content="1; url=/configurator/index.php">
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
                            Planset Removed
                        </div>
                    </div>
                    <br>
                    <meta http-equiv="refresh" content="2; url=/plansets/index.php">
                    <?php
            }
        ?>
                </div>
                <?php

            for($i=0;$i<count($planset);$i++){
        ?>
                <div class="col-sm-4 mb-2">
                    <div class="card">
                        <div class="card-body text-center">
                            <form class="d-inline" name="plan_form<?php echo $i; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="POST">
                                <h5 class="card-title "><?php echo $planset[$i]['house_name']; ?></h5>
                                <p><b>House ID: <?php echo $planset[$i]['house_id']; ?></b>  </p>
                                <p class="card-text"><?php echo $planset[$i]['house_description']; ?></p>
                                <p>Presentation ID: <?php echo $planset[$i]['presentation_id']; ?>  </p>
                                <a href="details.php?id=<?php echo $planset[$i]['house_id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i>Edit</a>
                                <input type="hidden" name="pres_id" value="<?php echo $planset[$i]['presentation_id']; ?>">
                                <input type="hidden" name="house_id" value="<?php echo $planset[$i]['house_id']; ?>">
                                <button class="btn btn-danger" name="remove_btn" onclick="return confirm('Are you sure want do delete ?')" type="submit"><i class="fas fa-trash"></i></button>

                                <div class="d-flex flex-row align-items-center justify-content-center mt-2">
                                    <p class="mb-0">Activate for configurator ?</p>
                                    <div class="boxes float-right px-4">
                                        <input type="hidden" name="configurator_status" id="configurator_status-<?php echo $i ?>" value="<?php echo $planset[$i]['configurator']; ?>">
                                        <input type="checkbox"  value="<?php echo $planset[$i]['configurator']; ?>" class="checked" onclick="check('box-<?php echo $i ?>')
                            " id="box-<?php echo $i ?>">
                                        <label for="box-<?php echo $i ?>"></label>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <?php
            $plan_sp7 = $prod->get_plans_sp7($planset[$i]['house_id']);
                        // $tof = $prod->get_tof_by_house_id($planset[$i]['house_id']);
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
        } ?>
            </div>
            <br>

            <?php
	}
	else
	{
	?>
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
</body>
</html>