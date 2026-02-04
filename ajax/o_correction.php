<?php
include("../functions.php");
$prod=new Production;

$method=$prod->xss_fix($_GET['method']);
$product=$prod->xss_fix($_GET['product']);

$value=explode(".",$product);

if($method=="create")
{
	$main_o_prods_data['o_id']=$value[1];
	$main_o_prods_data['osub_id']=$value[3];
	$main_o_prods_data['prod_id']=$value[4];
	
	$main_o_prods=$prod->get_order_product(json_encode($main_o_prods_data));
	
	if(!empty($main_o_prods))
	{
	if(count($main_o_prods)>0)
	{
		echo $existing_data['o_id']=$value[2];
		echo $existing_data['osub_id']=$value[3];
		echo $existing_data['prod_id']=$value[4];
		
		$existing_product=$prod->get_order_product(json_encode($existing_data));
		
		if(empty($existing_product))		
		{
		//adding new value
		
			$mistake_data['o_id']=$value[2];
			$mistake_data['om_id']=$value[1];
			$mistake_data['osub_id']=$value[3];
			$mistake_data['prod_id']=$value[4];
			
			$mistake_data['uca_id']=$main_o_prods['uca_id'];
			$mistake_data['p_status']=5;
			
			$prod->add_order_products2(json_encode($mistake_data));
			echo " Added new prod";
		}
		
		$existing_product=$prod->get_order_product(json_encode($existing_data));
		
		if($value[0]=="mistake")
		{
			$update_data['om_correction']=1;
			$update_data['om_amendment']=$existing_product['om_amendment'];
			echo " Updated correction";
		}
		
		if($value[0]=="amendment")
		{			
			$update_data['om_amendment']=1;			
			$update_data['om_correction']=$existing_product['om_correction'];
			echo " Updated amendment";
		}
		
		$update_data['o_id']=$value[2];
		$update_data['om_id']=$value[1];
		$update_data['osub_id']=$value[3];
		$update_data['prod_id']=$value[4];
		
		$prod->update_order_product(json_encode($update_data));
	}
	}
}

if($method=="delete")
{
	$delete_data['o_id']=$value[2];
	$delete_data['om_id']=$value[1];
	$delete_data['osub_id']=$value[3];
	$delete_data['prod_id']=$value[4];
	
	$existing_product=$prod->get_order_product(json_encode($delete_data));
	
	if(!empty($existing_product))
	{
		if($value[0]=="mistake")
		{
			$update_data['om_correction']=0;
			$update_data['om_amendment']=$existing_product['om_amendment'];
			echo " Deleted correction";
		}
		
		if($value[0]=="amendment")
		{			
			$update_data['om_amendment']=0;			
			$update_data['om_correction']=$existing_product['om_correction'];
			echo " Deleted amendment";
		}
		
		$update_data['o_id']=$value[2];
		$update_data['om_id']=$value[1];
		$update_data['osub_id']=$value[3];
		$update_data['prod_id']=$value[4];
			
		$prod->update_order_product(json_encode($update_data));
		
		$existing_product=$prod->get_order_product(json_encode($delete_data)); //checking if amendment and correction is 0
		echo $existing_product['om_id'];
		if(($existing_product['om_correction']==0)&&($existing_product['om_amendment']==0)&&($existing_product['om_extension']==0)&&($existing_product['om_id']!=0))
		{
			//echo $existing_product['o_id'].".".$existing_product['osub_id'].".".$existing_product['prod_id'];
			$prod->delete_order_product(json_encode($delete_data));	
			echo $existing_product['o_id'].".".$existing_product['osub_id'].".".$existing_product['prod_id'].".".$existing_product['om_id']." Deleted all";
		}
	}
}
?>