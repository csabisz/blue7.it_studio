<?php

include('../functions.php');
$prod=new Production;

function get_house_options_list($ho_id)
{
    $prod=new Production;
    $mysqli = $prod->dbsuperplan();
    $query = "SELECT * FROM `h_options_list` WHERE `ho_id`='$ho_id'";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $rows[] = $row;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
    return $rows;
}



$ho_id=$prod->xss_fix($_GET['ho_id']);

$hol = get_house_options_list($ho_id);

?>
    <option value="">--Select--</option>
<?php

for ($i=0;$i<count($hol);$i++){
    ?>
    <option value="<?php echo $hol[$i]['hol_id']?>"><?php echo $hol[$i]['hol_id']?></option>
    <?php
}
