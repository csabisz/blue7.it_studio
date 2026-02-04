<?php
include('../functions.php');

$prod=new Production;

$main_client_name=$prod->xss_fix($_GET['main_client_name']);

$main_clients=$prod->get_main_client_by_clientname($main_client_name);

for($i=0;$i<count($main_clients);$i++)
{
    ?>
    <option value="<?php echo $main_clients[$i]['mc_id'];?>"><?php
    echo $main_clients[$i]['clientname'];    
    ?></option>
    <?php
}
?>