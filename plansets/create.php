<?php
session_start();
include('../functions.php');
$prod = new Production;

$_COOKIE['start']=gmdate("Y-m-d H:i:s");
$page_title="Plan-sets - Create";
include('../header2.php');
include('../menu.php');

$pls_id=$prod->xss_fix($_GET['pls_id']);

if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))		
{
    if($_COOKIE['plansets'] > 0)
	{
        	        							
    ?>
    <section class="top_section">
        <article>
        <div class="container text-center pagecontent">
            <h3 class="text-center py-4">Create New Plan-set</h3>
            <form id="save_planset_form" name="save_planset_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"></form>
            
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php
                    if(isset($_POST['save_btn']))
                    {
                        
                        $save_data['pls_presentation_id'] = $prod->xss_fix($_POST['pls_presentation_id']); 
                        $save_data['pls_owner'] = $prod->xss_fix($_POST['pls_owner']); 
                        $save_data['pls_owner1'] = $prod->xss_fix($_POST['pls_owner1']); 
                        $save_data['pls_name'] = $prod->xss_fix($_POST['pls_name']);
                        $save_data['pls_description'] = $prod->xss_fix($_POST['pls_description']); 
                        $save_data['pls_depth'] = $prod->xss_fix($_POST['pls_depth']);
                        $save_data['pls_width'] = $prod->xss_fix($_POST['pls_width']);
                        $save_data['pls_height'] = $prod->xss_fix($_POST['pls_height']);
                        $save_data['pls_surface'] = $prod->xss_fix($_POST['pls_surface']);
                        $save_data['pls_price'] = $prod->xss_fix($_POST['pls_price']);

                        $prod->save_planset(json_encode($save_data));
                    ?>
                    <div class="alert alert-success">
                        Saved successfully !
                    </div>
                    <meta http-equiv="refresh" content="1; url=index.php">
                    <?php
                    }
                    
                    
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Plan-set name</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_name" name="pls_name" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Owner1 (mc_id)</b>
                </div>
                <div class="col-md-3">
                    <input type="text" id="pls_owner1" name="pls_owner1" form="save_planset_form" list="all_main_clients_suggestions" class="form-control form-control-sm" value="">
                    <datalist id="all_main_clients_suggestions">
                    </datalist>
                    
                    <script type="text/javascript">
                    $(document).ready(function(){ 
                        $('#pls_owner1').on('keyup',function(){

                            let main_client_name=$('#pls_owner1').val();
                            
                            $.ajax({
                                url: "../ajax/get_main_client_suggestions_html.php",
                                method: "get",
                                data: {main_client_name:main_client_name},
                                dataType:"html",
                                success:function(data) {
                                    $('#all_main_clients_suggestions').html(data);                                                            
                                }
                            });

                        });

                        $('#pls_owner1').on('focusout',function(){

                            let mc_id=$('#pls_owner1').val();

                            $.ajax({
                                url: "../ajax/get_main_client.php",
                                method: "get",
                                data: {mc_id:mc_id},
                                dataType:"html",
                                success:function(data) {
                                    $('#main_client_name').html(data);                                                            
                                }
                            });

                        }); 

                    });
                    </script>
                </div>
                <div class="col-md-3 text-left">
                    <label id="main_client_name" for="pls_owner1"></label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Owner (client_id)</b>
                </div>
                <div class="col-md-3">
                    <input type="text" id="pls_owner" name="pls_owner" form="save_planset_form" list="all_clients_suggestions" class="form-control form-control-sm" value="">
                    <datalist id="all_clients_suggestions">
                    </datalist>
                    
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('#pls_owner').on('keyup',function(){

                            let name=$('#pls_owner').val();
                            
                            $.ajax({
                                url: "../ajax/get_client_suggestions_html.php",
                                method: "get",
                                data: {client_name:name},
                                dataType:"html",
                                success:function(data) {
                                    $('#all_clients_suggestions').html(data);                                                            
                                }
                            });

                        });

                        $('#pls_owner').on('focusout',function(){

                            let name=$('#pls_owner').val();

                            $.ajax({
                                url: "../ajax/get_client.php",
                                method: "get",
                                data: {uca_id:name},
                                dataType:"html",
                                success:function(data) {
                                    $('#client_name').html(data);                                                            
                                }
                            });

                        });

                    });
                    </script>
                </div>
                <div class="col-md-3 text-left">
                    <label id="client_name" for="pls_owner"></label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Presentation ID</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_presentation_id" name="pls_presentation_id" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <b>Plan-set description</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_description" name="pls_description" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Depth (mm)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_depth" name="pls_depth" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Width (mm)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_width" name="pls_width" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div><div class="row">
                <div class="col-md-6">
                    <b>Height (mm)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_height" name="pls_height" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div><div class="row">
                <div class="col-md-6">
                    <b>Surface (m<sup>2</sup>)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_surface" name="pls_surface" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <b>Plan-set Price (APE)</b>
                </div>
                <div class="col-md-6">
                    <input type="text" id="pls_price" name="pls_price" form="save_planset_form" class="form-control form-control-sm" value="">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" id="save_btn" name="save_btn" form="save_planset_form" class="btn btn-sm btn-primary">Save</div>
                </div>
            </div>
        </div>
        </article>
    </section>
    <?php
    }
    else
    {
        ?>
        <div class="text-center">				
        <div class="alert alert-danger">Access denied !</div>
        <a href="<?php echo $base_url;?>own_tasks.php" class="btn btn-danger btn-sm">Go to Own tasks</a>
        <br><br>
        </div>
    <meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>own_tasks.php">
    <?php
    
    }
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

include('../footer.php');
?>
