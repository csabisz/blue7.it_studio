<?php
include('../functions.php');

$prod=new Production;

$client_name=$prod->xss_fix($_GET['client_name']);

$client=$prod->get_clients_by_l_last_name_c_last_name($client_name);

for($i=0;$i<count($client);$i++)
{
    ?>
    <option value="<?php echo $client[$i]['client_ID'];?>"><?php
    echo $client[$i]['clientname']." - ";
    if(!empty($client[$i]['c_last_name']))
    {
        echo $client[$i]['c_last_name'].", ".$client[$i]['c_first_name'];
    }
    else
    {
        echo $client[$i]['l_last_name'].", ".$client[$i]['l_first_name'];
    }
    ?></option>
    <?php
}
?>