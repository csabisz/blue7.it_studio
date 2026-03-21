<?php
include('../functions.php');
$prod=new Production;

$data['length']=$prod->xss_fix($_GET['length']);
$data['width']=$prod->xss_fix($_GET['width']);
$data['roof_shape']=$prod->xss_fix($_GET['roof_shape']);

$orders=$prod->advanced_search_orders(json_encode($data));

for($i=0;$i<count($orders);$i++)
{
    $order=$prod->get_order($orders[$i]['o_id']);

    if($order['o_status']<=8)
    {
?>
<div class="row mx-0 w-100 bg-table interface">
        <div class="col-12 col-xl-4 text-center text-xl-left pr-0 pl-1 d-flex flex-row jusity-content-center">
            <div class="row mx-0 px-0 w-100">
                <div class="col-xl-8 px-0 d-flex flex-column justify-content-center">
                    <p class="text-left client mb-0">
                        <strong>
                            <?php echo $orders[$i]['o_id'];
                                if($order['om_id']>0)
                                {
                                    echo "-".$order['om_id'];
                                }
                            ?>
                        </strong>
                    <?php 
                    $client=$prod->get_client($order['u_client_ID']);
                    if(!empty($client['c_last_name']))
                    {
                        echo $client['clientname']." - ".$client['c_last_name'].", ".$client['c_first_name'];
                    }
                    else
                    {
                        echo $client['clientname']." - ".$client['l_last_name'].", ".$client['l_first_name'];
                    }
                    ?></p>
                    <div class="row w-100 mx-0 px-0">
                        <div class="col-md-12 px-0">
                            <b><?php echo $order['o_date']; ?></b>
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
            <div class="col-12 col-xl-2 text-center d-flex justify-content-center align-items-center flex-column px-0">
            <?php
            if($order['o_extension']==1)
            {
            ?>    
            <p class="mb-0">EXTENSION</p>
            <?php    
            }    

            if($order['o_correction']==1)
            {
            ?>    
            <p class="mb-0" style="font-size: 14px;">CORRECTION/AMENDMENT</p>
            <?php   
            }
            ?>
            <p class="projectname mb-0"><b><?php echo $order['order_name'];?></b></p>
            </div>
        
        
            <div class="col-12 col-xl-4 text-xl-right text-center d-flex flex-row align-items-center px-0">
                <div class="row w-100 mx-0 px-0">
                    <div class="col-12 d-flex flex-row align-items-center justify-content-start px-0">
                        
                        
                        <a href="https://bauvorschau.com/<?php echo $orders[$i]['o_id'];?>" class="btn view text-white btn-sm mr-1 d-md-inline" target="_blank" style="background: #f0ad4e;">
                            Presentation
                        </a>
                    </div>
                </div>
            </div>
            
    </div>
<?php
    } // end checking if order is not deleted
}
?>