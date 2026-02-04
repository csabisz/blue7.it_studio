<?php
//session_set_cookie_params(14400,"/");
session_start();
include('functions.php');

$prod=new Production;

include('header2.php');
include('menu.php');

?>
<section>
	<article class="pt-4">
	<div class="container text-center border my-4 pt-2 pagecontent bg-white">
	<br>
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{
			
			?>
            <form id="copy_form" name="copy_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"></form>
			<div class="row">
                <div class="col-md-1">
                    <b>Order ID</b>
                </div>
                <div class="col-md-1">
                    <input type="text" name="o_id" form="copy_form" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-1">
                    <button type="submit" name="copy_btn" form="copy_form" class="btn btn-sm btn-primary">Copy</button>
                </div>
            </div>	
			<?php
            if(isset($_POST['copy_btn']))
            {
                $o_id=$prod->xss_fix($_POST['o_id']);

                $results=$prod->show_results_by_order($o_id);
                ?>
                <div class="row">
                    <div class="col-md-12">
                    <?php
                    for($i=0;$i<count($results);$i++)
                    {
                        $new_result['o_id']=4610;
                        $new_result['om_id']=$results[$i]['om_id'];
                        $new_result['osub_id'] = $results[$i]['osub_id'];
                        $new_result['prod_id'] = $results[$i]['prod_id']; 
                        $new_result['uca_id'] = $results[$i]['uca_id']; 
                        $new_result['main_picture'] = $results[$i]['main_picture']; 
                        $new_result['orf_name'] = $results[$i]['orf_name'];

                        $old_path=explode('/',$results[$i]['orf_path_dom']);
                        
                        $new_path="2021/4610/".$old_path[2]."/";

                        $new_result['orf_path_dom'] = $new_path; 
                        $new_result['orf_internal_name_dom'] = $results[$i]['orf_internal_name_dom'];
                        $new_result['orf_type_dom'] = $results[$i]['orf_type_dom']; 
                        $new_result['optimized_image_path'] = $results[$i]['optimized_image_path'];
                        $new_result['orf_thumbnail_path'] = $results[$i]['orf_thumbnail_path'];
                        $new_result['orf_compress_path'] = $results[$i]['orf_compress_path'];
                        $new_result['orf_upload_date'] = $results[$i]['orf_upload_date']; 
                        $new_result['orf_status'] = $results[$i]['orf_status'];
                        $new_result['pict_categ_name'] = $results[$i]['pict_categ_name'];
                        $new_result['pict_number'] = $results[$i]['pict_number'];

                        $prod->copy_creator_result_file(json_encode($new_result));

                        
                    }
                    echo "Everything should be copied";
                    ?>
                    </div>
                </div>
                <?php
            }
            ?>
			<?php
		}
		else
		{
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
    </div>
	</article>
</section>
<?php
include('footer.php');
?>