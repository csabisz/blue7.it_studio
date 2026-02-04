<?php
//session_set_cookie_params(14400,"/");
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');

include('../menu.php');

?>
<section>
	<article>
    <?php
    if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
    {
        ?>
	<div class="container py-3 my-4">	
    <h3 class="text-center mb-2">Change Country VAT</h3>
	<br>
    
		<?php
        
		$areas=$prod->show_areas();
            ?> 
            <table class="table table-striped border">
                <tr>
                    <th>Country</th>
                    <th>Short</th>
                    <th>VAT</th>
                    <th>VAT Since</th>
                    <th>EU ?</th>
                    <th>EU IN</th>
                    <th>EU OUT</th>
                    <th>&nbsp;</th>
                </tr>
                <?php
                for($i=0;$i<count($areas);$i++)
                {
                    ?>
                    <tr>
                        <td class="pl-3">
                        <?php
                           echo $areas[$i]['area'];
                        ?>
                        </td>
                        <td>
                            <input type="text" id="alpha_2<?php echo $areas[$i]['a_id'];?>" name="alpha_2<?php echo $areas[$i]['a_id'];?>" value="<?php echo $areas[$i]['alpha_2'];?>" class="form-control form-control-sm" readonly>
                        </td>
                        <td>
                            <input type="text" id="a_vat<?php echo $areas[$i]['a_id'];?>" name="a_vat<?php echo $areas[$i]['a_id'];?>" value="<?php echo $areas[$i]['a_vat'];?>" class="form-control form-control-sm">
                        </td>
                        <td>
                            <input type="text" id="vat_since<?php echo $areas[$i]['a_id'];?>" name="vat_since<?php echo $areas[$i]['a_id'];?>" value="<?php echo $areas[$i]['vat_since'];?>" class="form-control form-control-sm">
                            <script type="text/javascript">
                            $('#vat_since<?php echo $areas[$i]['a_id'];?>').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd"
                            });
                            </script>
                        </td>
                        <td>
                            <input type="checkbox" id="a_eu<?php echo $areas[$i]['a_id'];?>" name="a_eu<?php echo $areas[$i]['a_id'];?>" value="<?php echo $areas[$i]['a_eu'];?>" class="form-check-input" <?php echo ($areas[$i]['a_eu']==1)?"checked":"";?>>
                        </td>
                        <td>
                            <input type="text" id="eu_in<?php echo $areas[$i]['a_id'];?>" name="eu_in<?php echo $areas[$i]['a_id'];?>" value="<?php echo $areas[$i]['eu_in'];?>" class="form-control form-control-sm">
                            <script type="text/javascript">
                            $('#eu_in<?php echo $areas[$i]['a_id'];?>').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd"
                            });

                            </script>
                        </td>
                        <td>
                            <input type="text" id="eu_out<?php echo $areas[$i]['a_id'];?>" name="eu_out<?php echo $areas[$i]['a_id'];?>" value="<?php echo $areas[$i]['eu_out'];?>" class="form-control form-control-sm">
                            <script type="text/javascript">
                            $('#eu_out<?php echo $areas[$i]['a_id'];?>').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd"
                            });

                            </script>
                        </td>
                        <td>
                            <button id="save_btn<?php echo $areas[$i]['a_id']; ?>" name="save_btn<?php echo $areas[$i]['a_id']; ?>" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#saveModal">Save</button>
                            <script type="text/javascript">
                            $(document).ready(function(){

                                $('#save_btn<?php echo $areas[$i]['a_id'];?>').click(function(){
                                    
                                    let a_vat=$('#a_vat<?php echo $areas[$i]['a_id'];?>').val();
                                    let vat_since=$('#vat_since<?php echo $areas[$i]['a_id'];?>').val();
                                    let a_eu=0;
                                    let eu_in=$('#eu_in<?php echo $areas[$i]['a_id'];?>').val();
                                    let eu_out=$('#eu_out<?php echo $areas[$i]['a_id'];?>').val();
                                    let a_id=<?php echo $areas[$i]['a_id'];?>;

                                    if($('#a_eu<?php echo $areas[$i]['a_id'];?>').is(':checked'))
                                    {
                                        a_eu=1;
                                    }
                                    
                                    $.ajax({
                                        url: "../ajax/update_area.php",
                                        method: "post",
                                        data: {
                                            a_vat:a_vat,
                                            vat_since:vat_since,
                                            a_eu:a_eu,
                                            eu_in:eu_in,
                                            eu_out:eu_out,
                                            a_id:a_id
                                        },
                                        dataType:"html",
                                        success:function(data) {
                                            setTimeout(function(){$('#saveModal').modal('hide')},2000);	
                                        }
                                    });

                                });
                            });

                            </script>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="saveModalLabel">Saving area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="alert alert-success">Data successfully saved</div>
                    </div>
                    <div class="modal-footer">
                    
                    </div>
                    </div>
                </div>
            </div>

            <?php
        
		} //end session
		else
		{
            session_unset();
            session_destroy();
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				    <a href="<?php echo $base_url;?>login.php" class="btn btn-danger px-4 btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>login.php">
			<?php
		}
		?>
	</article>
</section>
<?php
include('footer.php');
?>