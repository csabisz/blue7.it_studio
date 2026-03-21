<?php
include('../functions.php');

$prod=new Production;

$client_id=$prod->xss_fix($_GET['client_id']);

$budgets=$prod->get_all_order_budget_for_client_id($client_id);


?>

<?php
for($i=0;$i<count($budgets);$i++)
{
    //$client=$prod->get_client($budgets[$i]['client_id']);
?>

<div class="row">
    <div class="col">&nbsp;</div>
    <div class="col">&nbsp;</div>
    <div class="col"><?php echo $budgets[$i]['budget_name'];?></div>
    <div class="col"><?php echo $budgets[$i]['budget_explanation'];?></div>
    <div class="col"><?php echo $budgets[$i]['bs_date'];?></div>
    <div class="col"><?php echo $budgets[$i]['be_date'];?></div>
    <div class="col"><?php echo $budgets[$i]['amount'];?></div>
    <div class="col">
        <?php
        $orders=$prod->get_orders_by_date_no_o_extension($client_id,$budgets[$i]['bs_date'],$budgets[$i]['be_date']);
        echo count($orders);
        ?>
    </div>
    <div class="col"><?php 
    $today=date("Y-m-d");
    if($budgets[$i]['be_date']<$today)
    {
        echo "-";
    }
    else
    {
        echo $budgets[$i]['amount']-count($orders);
    }?></div>
    <div class="col"><a href="<?php 
    echo "https://cseven.eu/studio/budget/order_budget.php?option=edit&ucm_budget_id=".$budgets[$i]['ucm_budget_id'];
    ?>" class="btn btn-primary btn-sm">Edit</a></div>
</div>
<?php
}
?>
