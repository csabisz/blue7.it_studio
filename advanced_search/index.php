<?php
session_start();

include("../functions.php");
include('../../../../domenia7.com/public_html/domenia_db2.php');

$prod=new Production;
$domenia2=new Domenia2;

$_SESSION['start']=gmdate("Y-m-d H:i:s");

include("../headerCoordination3.php");
include('../menu.php');

$client=$prod->get_client($_SESSION['client_id']);

$licence_sites=explode(";",$client['ls_ids']);

$licences=$prod->get_licences($_SESSION['lt_id']);

$on_stock=$prod->xss_fix($_GET['on_stock']);

if(empty($on_stock))
{
    $on_stock=0;
}

?>

<div id="coordination" class="page-content">
    <div class="container-fluid px-0" style="background: #000000;">
       <?php
        if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire']))
        {
       ?>
    
        <div class="row pt-2 pb-2">
            <div class="col-md-12 text-center text-white">
                <h4>Advanced search</h4>
            </div>
        </div>

        <hr class="mt-0" style="border: 2px solid #fff; width: 100%;">

        <div class="row mx-0 w-100 px-3 mb-2">
            <div class="row mx-0 w-100 bg-table">
                <div class="col-md-1">
                    Depth:
                </div>
                <div class="col-md-1">
                    <input type="text" id="length" name="length" class="form-control form-control-sm"> 
                </div>
                <div class="col-md-1">
                    Width:
                </div>
                <div class="col-md-1">
                    <input type="text" id="width" name="width" class="form-control form-control-sm"> 
                </div>
                <div class="col-md-1">
                    Roof shape:
                </div>
                <div class="col-md-1">
                <?php
					$roof_shapes=$domenia2->get_all_roof_shapes();
					
					?>
					<select id="rs_id" name="rs_id" class="form-control form-control-sm">
						<option value="">None</option>
						<?php
						for($i=0;$i<count($roof_shapes);$i++)
						{							
						?>
						<option value="<?php echo $roof_shapes[$i]['rs_id'];?>"><?php echo $roof_shapes[$i]['rs_dbname'];?></option>
						<?php							
						}
						?>
					</select>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function(){
            
            $('#length').on('keyup',function(){
                let length=$('#length').val();
                let width=$('#width').val();
                let rs_id=$('#rs_id option:selected').val();

                if(length!="")
                {
                    get_orders(length,width,rs_id);
                }
            });

            $('#width').on('keyup',function(){
                let length=$('#length').val();
                let width=$('#width').val();
                let rs_id=$('#rs_id option:selected').val();

                if(width!="")
                {
                    get_orders(length,width,rs_id);
                }
            });

            $('#rs_id').on('change',function(){
                let length=$('#length').val();
                let width=$('#width').val();
                let rs_id=$('#rs_id option:selected').val();
                //console.log(rs_id);
                if(rs_id!="")
                {
                    get_orders(length,width,rs_id);
                }
            });


        });

        function get_orders(search_length,search_width,search_roof_shape)
        {
            console.log(search_roof_shape);
            $.ajax({
                url: "search_orders.php",
                method: "get",
                data: {length:search_length,width:search_width,roof_shape:search_roof_shape},
                dataType:"html",
                success:function(data) {
                    $('#projects').html(data);	
                }
            });
        }
        </script>
        <div id="projects">
          
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
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
        <?php
        }
?>
    </div>
</div>

<?php include("../footer.php");?>