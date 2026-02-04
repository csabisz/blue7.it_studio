<?php
session_start();
include('../functions.php');
include('../notifications.php');

$prod=new Production;
$notification=new Notifications;

$o_id=$prod->xss_fix($_GET['o_id']);
$osub_id=$prod->xss_fix($_GET['osub_id']);
$prod_id=$prod->xss_fix($_GET['prod_id']);
$p_status=$prod->xss_fix($_GET['p_status']);

//echo $o_id."_".$osub_id."_".$prod_id."_".$p_status;

if(($prod_id=="p1301")&&($p_status==8))
{
	$prod->update_the_other_o_prods_status($o_id,$osub_id,$prod_id);
	$prod->update_order_status($o_id,$o_status=4);
}

if(($prod_id=="p1501")&&($p_status==8))
{
	$prod->update_the_other_o_prods_status($o_id,$osub_id,$prod_id);
	$prod->update_order_status($o_id,$o_status=4);
}

if(($prod_id=="p1701")&&($p_status==8))
{
	$prod->update_the_other_o_prods_status($o_id,$osub_id,$prod_id);
	$prod->update_order_status($o_id,$o_status=4);
}


if(($prod_id=="p1521")&&($p_status==8))
{
	$prod->update_the_other_o_prods_status($o_id,$osub_id,$prod_id);
	$prod->update_order_status($o_id,$o_status=4);
}

if(($prod_id=="p1721")&&($p_status==8))
{
	$prod->update_the_other_o_prods_status($o_id,$osub_id,$prod_id);
	$prod->update_order_status($o_id,$o_status=4);
}

if(($prod_id=="p1541")&&($p_status==8))
{
	$prod->update_the_other_o_prods_status($o_id,$osub_id,$prod_id);
	$prod->update_order_status($o_id,$o_status=4);
}

if(($prod_id=="p1741")&&($p_status==8))
{
	$prod->update_the_other_o_prods_status($o_id,$osub_id,$prod_id);
	$prod->update_order_status($o_id,$o_status=4);
}

if((substr($prod_id, -2)=="6m")||(substr($prod_id, -2)=="6t"))
{
	$prod->update_o_prods_status($o_id,$osub_id,$prod_id,$p_status);
}

$check_if_results=$prod->show_results($o_id,$osub_id,$prod_id);

if((count($check_if_results)==0)&&($p_status!=8))
{
	$prod->update_o_prods_status($o_id,$osub_id,$prod_id,$p_status);					
}
elseif((count($check_if_results)>0)&&($p_status==8))
{				
	$prod->update_o_prods_status($o_id,$osub_id,$prod_id,$p_status);	
    //$prod->auto_update_o_results_status($o_id,$osub_id,$prod_id,$p_status);
    //echo $o_id."_".$osub_id."_".$prod_id."_".$p_status;
    echo "checking if there is 1 visible result if not setting automatically 1";
}
elseif((count($check_if_results)>0)&&($p_status!=8))
{				
	$prod->update_o_prods_status($o_id,$osub_id,$prod_id,$p_status);	
}
elseif((count($check_if_results)==0)&&($p_status==8))
{
	if(($prod_id=="p1562")||($prod_id=="p1581")||($prod_id=="p1762")||($prod_id=="p1781"))
	{
		$prod->update_o_prods_status($o_id,$osub_id,$prod_id,$p_status);	
		//$prod->auto_update_o_results_status($o_id,$osub_id,$prod_id,$p_status);
    }
    elseif(($prod_id=="p1301")||($prod_id=="p1501")||($prod_id=="p1600")||($prod_id=="p1601")||($prod_id=="p1700")||($prod_id=="p1701")||($prod_id=="p1800")||($prod_id=="p1801"))
    {
        
        //$check_if_p1301=$prod->show_results($o_id,$osub_id,"p1301");
        $check_if_p1321=$prod->show_results($o_id,$osub_id,"p1321");
        $check_if_p1521=$prod->show_results($o_id,$osub_id,"p1521");
        $check_if_p1541=$prod->show_results($o_id,$osub_id,"p1541");
        $check_if_p1621=$prod->show_results($o_id,$osub_id,"p1621");
        $check_if_p1641=$prod->show_results($o_id,$osub_id,"p1641");
        $check_if_p1721=$prod->show_results($o_id,$osub_id,"p1721");
        $check_if_p1741=$prod->show_results($o_id,$osub_id,"p1741");
        $check_if_p1821=$prod->show_results($o_id,$osub_id,"p1821");
        $check_if_p1841=$prod->show_results($o_id,$osub_id,"p1841");

        if((count($check_if_p1321)>0)||(count($check_if_p1521)>0)||(count($check_if_p1541)>0)||(count($check_if_p1621)>0)||(count($check_if_p1641)>0)||(count($check_if_p1721)>0)||(count($check_if_p1741)>0)||(count($check_if_p1821)>0)||(count($check_if_p1841)>0))
        {
            $prod->update_o_prods_status($o_id,$osub_id,$prod_id,$p_status);
        }
    }
	else
	{							
		?>
no_result_files
		<?php
	}	
}
else
{						
	?>
no_result_files					
	<?php
}	

if($p_status==1)
{
	$prod->update_order_status($o_id,$o_status=1);
}
elseif($p_status==2)
{
	$prod->update_order_status($o_id,$o_status=2);
}
elseif($p_status==3)
{
	$prod->update_order_status($o_id,$o_status=3);
}
elseif($p_status==4)
{
	$prod->update_order_status($o_id,$o_status=4);
}
elseif($p_status==5)
{
	$prod->update_order_status($o_id,$o_status=5);
}
elseif($p_status==6)
{
	$prod->update_order_status($o_id,$o_status=6);
}
elseif($p_status==7)
{
	$prod->update_order_status($o_id,$o_status=7);
}


$num_products=count($prod->get_prods($o_id));
$num_finished_products=count($prod->get_finished_number_prods($o_id,8));
$num_deleted_products=count($prod->get_finished_number_prods($o_id,12));
$dismissed_before_products=count($prod->get_finished_number_prods($o_id,10));
$dismissed_after_products=count($prod->get_finished_number_prods($o_id,11));

$total_finished_products=$num_finished_products + $num_deleted_products+ $dismissed_before_products+ $dismissed_after_products;

echo $num_products." / ".$total_finished_products;

if(($num_products==$num_finished_products)||($num_products==$total_finished_products))
{
	$prod->update_order_status($o_id,8);
	
	//send done message
	$order=$prod->get_order($o_id);
	
	if($order['notifications']==1)
	{
        if($num_finished_products>0)
        {
			if($order['om_id']==0)
			{
				$notification->send_product_done_message($o_id);
				echo "message should have been sent";
			}
			else
			{
				$notification->send_product_done_message_amendment($order['om_id'],$o_id);
				echo "message should have been sent";
			}
        }
	}
}
 
$logged_in_user_id=$prod->get_client($_COOKIE['client_id']);
$p_status_name=$prod->get_o_status_name($p_status);

$prod->create_activity($logged_in_user_id['client_ID'],"changed status to ".$p_status_name['ost_name'],$o_id,$osub_id,$prod_id);
?>