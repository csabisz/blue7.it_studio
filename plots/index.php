<?php
session_start();
include('../functions.php');
include('../../../../superplan7.com/public_html/functions.php');

$prod=new Production;
$sp7 = new Superplans;
$page_title="Plots";
include('../header2.php');
include('../menu.php');

$plots = $sp7->get_all_plots_reverse_order();

?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white ">
	<?php
	if(isset($_COOKIE['client_id']))
	{		
        							
		?>
        <p class="w-100 text-center display-4 pt-4">Plots</p>
        <hr class="mb-4" width="450px">
        <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
            <a href="create.php" class="btn btn-sm btn-primary mx-3 border">Add new Plot</a>      
        </div>

        <div class="row">
        <div class="col-md-12">
        <?php        
        
        ?>
        <hr class="mb-4">

        <div class="row">
            <div class="col-md-1">
                <b>ID</b>
            </div>
            <div class="col-md-2">
                <b>Owner</b>
            </div>
            <div class="col-md-1">
                <b>Plot size (m<sup>2</sup>)</b>
            </div>
            <div class="col-md-1">
                <b>Price</b>
            </div>
            <div class="col-md-1">
                <b>Country</b>
            </div>
            <div class="col-md-2">
                <b>City</b>
            </div>
            <div class="col-md-2">
                <b>Street</b>
            </div>
            <div class="col-md-1">
                <b>Nr</b>
            </div>
        </div>
        
        <?php
        for($p=0;$p<count($plots);$p++)
        {
        ?>
        <div id="row<?php echo $plots[$p]['plot_id'];?>" class="row colorline">
            <div class="col-md-1">
                <a href="details.php?plot_id=<?php echo $plots[$p]['plot_id'];?>"><?php echo $plots[$p]['plot_id'];?></a>
            </div>
            <div class="col-md-2">
                <?php 
                $client=$prod->get_client($plots[$p]['owner_id']);

                if(!empty($client['c_first_name']))
                {
                    echo $client['c_last_name'].", ".$client['c_first_name'];
                }
                else
                {
                echo $client['l_last_name'].", ".$client['l_first_name'];
                }?>
            </div>
            <div class="col-md-1">
                <?php echo $plots[$p]['size'];?>
            </div>
            <div class="col-md-1">
                <?php echo $plots[$p]['price'];?>
            </div>
            <div class="col-md-1">
                <?php 
                $country=$prod->get_country($plots[$p]['country']);
                echo $country['alpha_2'];?>
            </div>
            <div class="col-md-2">
                <?php echo $plots[$p]['city'];?>
            </div>
            <div class="col-md-2">
                <?php echo $plots[$p]['street'];?>
            </div>
            <div class="col-md-1">
                <?php echo $plots[$p]['house_no'];?>
            </div>
            <div class="col-md-1">
                <button id="id<?php echo $plots[$p]['plot_id'];?>"  data-plot_id="<?php echo $plots[$p]['plot_id'];?>" class="btn btn-danger btn-sm">X</button>
                <script type="text/javascript">
                $(document).ready(function(){

                $('#id<?php echo $plots[$p]['plot_id'];?>').click(function(){
                    if(confirm('This will permanently delete this plot !\n Are you sure you want to do this ?')) 
                    {
                        $.ajax({
                            url: "../ajax/delete_plot.php",
                            method: "post",
                            data: {plot_id:$(this).data('plot_id')},
                            dataType:"html",
                            success:function(data) {
                                console.log(data);	
                                $('#row<?php echo $plots[$p]['plot_id'];?>').fadeOut(3000);
                            }
                        });

                    }
                });

            });
                </script>
            </div>
        </div>
        <?php
        }
        ?>
        </div> <!-- end col-md-12 -->
        </div> <!-- end row -->
        <br>

	<?php		
	}
	else
	{
	?>
	<div class="center_message">				
	<div class="error text-center">You must be logged in to view this page !</div>
	<a href="../index.php" class="btn btn-danger btn-sm">Login</a>
	<br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=../index.php">
	<?php
	}
	?>
	</div>
	</article>
</section>
<?php
include('../footer.php');
?>