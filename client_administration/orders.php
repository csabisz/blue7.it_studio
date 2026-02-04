<style>
    td, th {
        vertical-align: middle !important;
    }
</style>
<?php
session_start();
include('../functions.php');
include('../../../../blue7.it/public_html/domenia/domenia.php');

$prod=new Production;
$domenia=new Domenia;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Client Orders";

include('../header2.php');
include('../menu.php');

?>
<section class="top_section">
	<article>
	<?php
	if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
	{				
		$clientid=$prod->xss_fix($_GET['clientid']);
		$client=$prod->get_client($clientid);
		?>
		<div class="container-fluid px-0 pt-5">
			<h3 class="w-100 mx-0 text-center mb-5">Client orders for: <?php 
			if($client['mc_id']!=0)
			{
				$main_client=$prod->get_main_client($client['mc_id']);
			}
			echo $main_client['clientname']." - ".$client['clientname']." - ".$client['c_title']."&nbsp;".$client['c_first_name']."&nbsp;".$client['c_last_name'];
			
			?></h3>		
			<?php
            if(isset($_GET['page']))
            {
                $page=$prod->xss_fix($_GET['page']);
            }
            else
            {
                $page=1;
            }
			
			$all_client_orders=$prod->get_all_client_orders($clientid);
	
			$total_client_orders=count($all_client_orders);
	
			$limit=15;
			$startpoint=($page*$limit)-$limit;
				
			//$orders=$prod->get_client_orders($clientid,$startpoint,$limit);
			$orders=$prod->get_client_orders_without_deleted($clientid,$startpoint,$limit);
            
			$pages=count($orders);
	
			$number_of_pages=ceil($total_client_orders / $limit);
	
			?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Presentation</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created on</th>
                        <th scope="col">Project Name</th>
                        <th scope="col">Homepage</th>
                        <th scope="col">Price</th>
                        <th scope="col">Licence</th>
                        <th scope="col">Client language</th>
                        
                        <th scope="col">Details</th>  
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        for($i=0;$i<count($orders); $i++)
                        { ?>
                            <tr>
                                <th scope="row">
                                    <a href="https://blue7.it/studio/coordination/orderdetails4.php?o_id=<?php echo $orders[$i]['order_ID']; ?>" target="_blank"><?php 
                                    echo $orders[$i]['order_ID'];
                                    if($orders[$i]['om_id']!=0)
                                    {
                                        echo " - ".$orders[$i]['om_id'];
                                    }?></a>
                                </th>
                                <td scope="row">
                                    <a href="https://bauvorschau.com/<?php 
                                    if($orders[$i]['om_id']!=0)
                                    {
                                        echo $orders[$i]['om_id'];
                                    }
                                    else
                                    {
                                        echo $orders[$i]['order_ID'];
                                    } ?>" target="_blank" class="btn btn-primary btn-sm">Presentation</a>
                                    <?php
                                    if($orders[$i]['om_id']!=0)
                                    {
                                        echo "<br>Amendment";
                                    }?>
                                </td>
                                <td>
                                    <div>
                                        <?php $data = json_decode(file_get_contents("https://blue7.it/presentation/api2/order/".$orders[$i]["order_ID"]."/"."www.bauvorschau.com"."/"."12345"), TRUE);
                                            //print_r($data);
                                        ?>
                                        <img src="<?php if(!empty($data['exterior_subcategories'][0]['image_list'][0]['thumb'])){
                                            echo $data['exterior_subcategories'][0]['image_list'][0]['thumb'];
                                            //echo $data['first_image'];
                                        }else {
                                            //$data = json_decode(file_get_contents("https://blue7.it/presentation/api2/order/" . $orders[$i]["om_id"] . "/" . "www.bauvorschau.com" . "/" . "12345"), TRUE);
                                            echo $data['interior_subcategories'][0]['image_list'][0]['thumb'];
                                            //echo $data['first_image'];
                                        }
                                        ?>" alt="No Image yet">
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $products = $prod->get_prods($orders[$i]['order_ID']);

                                    $prodCount = 1;
                                    $orderProgress = 0;

                                    $status_array = [];
                                    $done_tasks = 0;
                                    if(!empty($products))
                                    {
                                        for ($p = 0; $p < count($products); $p++) 
                                        {

                                            if ($products[$p]['p_status'] != '10' && $products[$p]['p_status'] != '11' && $products[$p]['p_status'] != '12')
                                            {
                                                $prodCount += 1;

                                                if ($products[$p]['p_status'] == '1')
                                                {
                                                    $orderProgress += 0;
                                                } if ($products[$p]['p_status'] == '8')
                                                {


                                                    $done_tasks += 1;
                                                    $orderProgress += 1;


                                                } else
                                                {
                                                    $orderProgress += 0.5;
                                                }
                                            }

                                        }

                                        if (count($products) == $done_tasks) {

                                            $progress_percent = 100;
                                        }
                                        else {

                                            $progress_percent = $orderProgress * 100 / $prodCount;
                                        }
                                    }

                                    $progress_percent = (int)$progress_percent;
                                    ?>
                                    <div style="color: black; font-weight: bold;text-align:center;"><?= $progress_percent?> %</div>
                                    <div class="progress border border-primary" style="position: relative;">
                                        
                                        <div class="progress-bar <?= $progress_percent <= 100 ? 'progress-bar-striped progress-bar-animated' : ''; ?>"
                                             style="width: <?= $progress_percent; ?>%"
                                             aria-valuenow="<?= $progress_percent; ?>" aria-valuemin="0"
                                             role="progressbar"
                                             aria-valuemax="100">
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div>
                                        <?php $date_time=explode(" ",$orders[$i]['o_date']);
                                        echo $date_time[0]." ".$date_time[1];
                                        ?> UTC+0
                                    </div>
                                </td>
                                
                                <td>
                                    <?php echo $orders[$i]['order_name']; ?>
                                </td>

                                <td>
                                    <?php echo $site=$prod->get_order_website($orders[$i]['ls_id'])['ls_name']; ?>
                                </td>
                                <td>
                                    <?php 
                                    //only showing superfloorplans prices, needs to be changed in the future
                                    if($orders[$i]['o_special_agreement_price']!=0)
                                    {
                                        echo $orders[$i]['o_special_agreement_price']."&nbsp;";     
                                    }
                                    else
                                    {
                                        echo $orders[$i]['o_price']."&nbsp;"; 
                                    }
                                    $licence=$prod->get_licence($orders[$i]['lic_ID']);
                                    echo $currency=$prod->get_currency($licence['currencies'])['cur_short'];
                                    ?>
                                </td>
                                <td>
                                    <?php echo $orders[$i]['lic_ID']; ?>
                                </td>
                                <td>
                                    <?php echo $language=$prod->get_language($orders[$i]['client_language_id'])['ln_name']; ?>
                                </td>
                                <td>
                                Creators:<button id="order_creators<?php echo $orders[$i]['order_ID']; ?>" name="order_creators<?php echo $orders[$i]['order_ID']; ?>" data-show="0" class="btn btn-sm btn-primary">Show</button><br>
                                <script type="text/javascript">
                                $(document).ready(function(){

                                $("#order_creators<?php echo $orders[$i]['order_ID']; ?>").click(function(){
                                    let show=$('#order_creators<?php echo $orders[$i]['order_ID']; ?>').data('show');

                                    if(show==0)
                                    {
                                        $("#prods_creators<?php echo $orders[$i]['order_ID']; ?>").show(1000);
                                        $("#order_creators<?php echo $orders[$i]['order_ID']; ?>").data("show", 1);
                                        $("#order_creators<?php echo $orders[$i]['order_ID']; ?>").text('Hide');
                                    }
                                    else
                                    {
                                        $("#prods_creators<?php echo $orders[$i]['order_ID']; ?>").hide(1000);
                                        $("#order_creators<?php echo $orders[$i]['order_ID']; ?>").data("show", 0);
                                        $("#order_creators<?php echo $orders[$i]['order_ID']; ?>").text('Show');
                                    }
                                });

                                });
                                </script>
                                <div id="prods_creators<?php echo $orders[$i]['order_ID']; ?>" style="display:none;">
                                <?php 
                                $o_prods=$prod->get_o_prods_by_order_id($orders[$i]['order_ID']);

                                for($p=0;$p<count($o_prods);$p++)
                                {
                                    //echo $o_prods[$p]['uca_id'];
                                    $creator=$prod->get_client($o_prods[$p]['uca_id']);

                                    echo $o_prods[$p]['o_id'].".".$o_prods[$p]['osub_id'].".".$o_prods[$p]['prod_id']." ".$creator['c_last_name'].", ".$creator['c_first_name']."<br>";
                                }
                                ?></div>
                                </td>
                            </tr>
                            <?php
                        } ?>
                </tbody>
            </table>
            <div class="row w-100 mx-d-flex justify-content-center">
                <div class="center_message mt-3">
                <?php
                if($page>1)
                {
                ?>
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?clientid=<?php echo $clientid;?>&page=<?php echo $page-1;?>" class="btn btn-secondary btn-sm"><?php
                //Previous
                if(isset($selected_lang))
                {
                    $text=$domenia->get_translation_text($selected_lang,"tx_1578","x-texts")['text'];
                    if(!empty($text))
                    {
                        echo $text;
                    }
                    else
                    {
                        $text=$domenia->get_translation_text(1,"tx_1578","x-texts")['text'];
                        echo $text;
                    }
                }
                else
                {
                    $text=$domenia->get_translation_text(1,"tx_1578","x-texts")['text'];
                    echo $text;
                }?></a>
                <?php
                }
                
                for($i=1;$i<=$number_of_pages;$i++)
                {
                    if($page==$i)
                    {
                        echo $i;
                    }
                    else
                    {
                ?>
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?clientid=<?php echo $clientid;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
                <?php
                    }
                }
                
                if($pages>0)
                {
                ?>
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?clientid=<?php echo $clientid;?>&page=<?php echo $page+1;?>" class="btn btn-secondary btn-sm"><?php
                //Next
                if(isset($selected_lang))
                {
                    $text=$domenia->get_translation_text($selected_lang,"tx_1577","x-texts")['text'];
                    if(!empty($text))
                    {
                        echo $text;
                    }
                    else
                    {
                        $text=$domenia->get_translation_text(1,"tx_1577","x-texts")['text'];
                        echo $text;
                    }
                }
                else
                {
                    $text=$domenia->get_translation_text(1,"tx_1577","x-texts")['text'];
                    echo $text;
                }?></a>
                <?php
                }
                ?>
                </div>
            </div>

		<?php		
	}
	else
	{
        session_unset();
        session_destroy();
	?>
	<div class="text-center">				
	<div class="alert alert-danger">You must be logged in to view this page !</div>
	<a href="<?php echo $base_url; ?>index.php" class="btn btn-danger btn-sm">Login</a>
	<br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=<?php echo $base_url; ?>index.php">
	<?php
	}
	?>
	</article>
</section>
<?php
include('../footer.php');
?>