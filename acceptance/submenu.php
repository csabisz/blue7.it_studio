<?php
if($_COOKIE['contracting']>0)
{

if($_COOKIE['view_all_orders']==1)
{
    $order_requests=$prod->show_all_order_request_orders();
    //$can_not_do_orders=$prod->show_can_not_do_orders();
    //$unfinished_orders=$prod->show_unfinished_orders();
    $finished_orders2=$prod->show_all_finished_orders();
    $deleted_orders=$prod->show_all_deleted_orders();
}
else
{
    $order_requests=$prod->show_all_order_requests_by_ls_id($licence_sites[0]);//1 website for now
    //$unfinished_orders=$prod->show_unfinished_orders_by_ls_id($licence_sites[0]);//1 website for now
    $finished_orders2=$prod->show_all_finished_orders_by_ls_id($licence_sites[0]);
    $deleted_orders=$prod->show_all_deleted_orders_by_ls_id($licence_sites[0]);
}
?>
<a class="btn btn-sm border border" href="create_order.php?<?php 

//preselected website

if($_COOKIE['view_all_orders']==1)
{
    $licences2=$prod->get_licences2($_COOKIE['lt_id']);
}
else
{
    $licences2=$prod->get_licences($_COOKIE['lt_id']);
}

//print_r($licences);
$websites="";
for($w=0;$w<count($licences2);$w++)
{
    if(!empty($licences2[$w]['homepages_for_sale']))
    {
        $all_websites2=explode(";",$licences2[$w]['homepages_for_sale']);
        // print_r($all_websites);
        for($k=0;$k<count($all_websites2);$k++)
        {
            if(!empty($all_websites2[$k]))
            {
                $websites.=$all_websites2[$k].";";
            }
        }
    }
}

$all_websites3=explode(";",$websites);

$all_websites=array_values(array_unique($all_websites3));

$website_counter=0;

for($w=0;$w<count($all_websites);$w++)
{
    if((!empty($all_websites[$w]))&&($all_websites[$w]!="s099"))
    {  
        $website=$prod->get_order_website($all_websites[$w]);
        $alphabetical_websites[$website_counter]['ls_id']=$website['ls_id'];
        $alphabetical_websites[$website_counter]['ls_name']=$website['ls_name'];
        $website_counter++;
    }
}


usort($alphabetical_websites, 'compareSiteByName');

//preselected language

$licence_languages=$prod->get_licences_by_lic_sites_id($alphabetical_websites[0]['ls_id']);

for($l=0;$l<count($licence_languages);$l++)
{
    $all_extracted_languages.=$licence_languages[$l]['languages_on_page'];

}
$extracted_languages=explode(';',$all_extracted_languages);

$all_languages=array_values(array_unique($extracted_languages));

//preselected currency

$licence_currencies=$prod->get_currencies_from_licences($alphabetical_websites[0]['ls_id'],$all_languages[0]);         

for($c=0;$c<count($licence_currencies);$c++)
{
    $all_extracted_currencies.=$licence_currencies[$c]['currencies'];
}

$extracted_currencies=explode(';',$all_extracted_currencies);

$all_currencies=array_values(array_unique($extracted_currencies));

$currency_counter=0;

for($c=0;$c<count($all_currencies);$c++)
{
    if(!empty($all_currencies[$c]))
    {
    $currency2=$prod->get_currency($all_currencies[$c]);
    $alphabetical_currencies[$currency_counter]['cur_id']=$currency2['cur_id'];
    $alphabetical_currencies[$currency_counter]['cur_short']=$currency2['cur_short'];
    $currency_counter++;
    }
}

usort($alphabetical_currencies,'compareCurrencyByName');

if($alphabetical_websites[0]['ls_id']=="s011")
{
    echo "ls_id=".$alphabetical_websites[0]['ls_id']."&client_language=49&currency=2"; //miviso default language and currency
}
else
{
    echo "ls_id=".$alphabetical_websites[0]['ls_id']."&client_language=".$all_languages[0]."&currency=".$alphabetical_currencies[0]['cur_id'];
}
?>">Create new order</a> |
<a class="btn blue-light btn-sm border border" href="index.php?orderstatus=0">Orders to accept (<?php echo count($order_requests);?>)</a> | 
<a class="btn btn-primary btn-sm border border" href="index.php?orderstatus=1-9&on_stock=0">Orders in progress (<?php 
//echo count($unfinished_orders);
if($_COOKIE['view_all_orders']==1)
{
    $orders_in_progress=$prod->show_unfinished_orders_by_on_stock(0);
    echo count($orders_in_progress);
}
else
{
    $orders_in_progress=$prod->show_unfinished_orders_by_ls_id_on_stock($licence_sites[0],0);
    echo count($orders_in_progress);
}
?>)</a> | 
<a class="btn btn-warning btn-sm border border" href="index.php?orderstatus=1-9&on_stock=1">Orders on stock (<?php 
if($_COOKIE['view_all_orders']==1)
{
    $orders_in_progress=$prod->show_unfinished_orders_by_on_stock(1);
    echo count($orders_in_progress);
}
else
{
    $orders_in_progress=$prod->show_unfinished_orders_by_ls_id_on_stock($licence_sites[0],1);
    echo count($orders_in_progress);
}

?>)</a> | 
<a class="btn black btn-sm border border" href="index.php?orderstatus=8">Orders done (<?php echo count($finished_orders2);?>)</a> |
<a class="btn purple btn-sm border border" href="index.php?orderstatus=10-12">Orders deleted (<?php echo count($deleted_orders);?>)</a> |

<a class="btn green btn-sm border border" href="<?php echo $base_url;?>budget/credits_budget.php">Give credits budget</a> |
<a class="btn light-green btn-sm border border" href="<?php echo $base_url;?>budget/order_budget.php">Give order budget</a> 
<?php
}
?>