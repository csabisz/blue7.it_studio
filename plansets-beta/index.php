<?php
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
include('../menu.php');
$plansets = $prod->get_all_houses_types();
print '<pre>';
print_r($plansets);
print '</pre>';
$prod->get_all_plansets();
 ?>

?>


<div class="container mt-4">
    <div class="row">
        <div class="col-10">
            <div class="card" style="height: 200px">
                
                
                
            </div>
        </div>
    </div>
</div>

<?php
include('../footer.php');
?>