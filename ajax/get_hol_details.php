<?php

include('../functions.php');
$prod=new Production;

function get_house_options_list_details($hol_id)
{
    $prod=new Production;
    $mysqli = $prod->dbsuperplan();
    $query = "SELECT * FROM `h_options_list` WHERE `hol_id`='$hol_id'";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
    return $row;
}



$hol_id=$prod->xss_fix($_GET['hol_id']);

$hol_details = get_house_options_list_details($hol_id);

    ?>
    <br>
    <p>hol_Selected: <?php echo $hol_details['hol_Selected']?></p><br>
    <p>hol_RoofShape: <?php echo $hol_details['hol_RoofShape']?></p><br>
    <p>hol_RoofTilesMain: <?php echo $hol_details['hol_RoofTilesMain']?></p><br>
    <p>hol_RoofTilesFlat: <?php echo $hol_details['hol_RoofTilesFlat']?></p><br>
    <p>hol_RoofOverstand: <?php echo $hol_details['hol_RoofOverstand']?></p><br>
    <p>hol_RoofTilt: <?php echo $hol_details['hol_RoofTilt']?></p><br>
    <p>hol_Walls: <?php echo $hol_details['hol_Walls']?></p><br>
    <p>hol_WoodApplication: <?php echo $hol_details['hol_WoodApplication']?></p><br>
    <p>hol_Gutters: <?php echo $hol_details['hol_Gutters']?></p><br>
    <p>hol_Window: <?php echo $hol_details['hol_Window']?></p><br>
    <p>hol_Doors: <?php echo $hol_details['hol_Doors']?></p><br>
    <p>hol_Garages: <?php echo $hol_details['hol_Garages']?></p><br>
    <p>hol_Fence: <?php echo $hol_details['hol_Fence']?></p><br>

    <?php
