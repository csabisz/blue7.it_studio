<?php
//session_set_cookie_params(14400,"/books");
session_start();
include('../functions.php');
include('../domenia_db3.php');
$prod=new Production;
$domenia3=new Domenia3;

$page_title="Books";

include('../header2.php');
include('../menu.php');

//$price=new PriceCalculations;

?>
<div class="container-fluid">
<section class="top_section">
		<article class="container pagecontent bg-white px-0">
		<?php
		if(isset($_COOKIE['client_id']))
		{
			include('submenu.php');
			if(isset($_GET['option']))
			{
				$option=$_GET['option'];
				
								
				if($option=="create")
				{
				
				$type=$prod->xss_fix($_GET['type']);
				
					if(isset($_GET['o_id'])&&($type=="simple_invoice"))
					{
						if(isset($_POST['submit_btn']))
						{
							
							$licence_id=$_POST['licence_id'];
							$client_id=$_POST['client_id'];
							$order_id=$_POST['order_id'];
							$net=$_POST['net'];
							$vat=$_POST['vat'];
							$vat_percent=$_POST['vat_percent'];
							$inv_date=$_POST['invoice_date'];
							
							$result=$domenia3->create_invoice($licence_id,$order_id,$inv_date,$client_id,$net,$vat,$vat_percent);
							
							$licence_taker_email=$_POST['licence_taker_email'];
							$client_email=$_POST['client_email'];
							$licence_taker_name=$_POST['licence_taker_name'];
							$myinvoice=file_get_contents("temp/invoice_ord".$order_id.".html");
							
							
							//$domenia3->send_invoice_email($licence_id,$order_id,$client_id,$licence_taker_name,$licence_taker_email,$client_email,$myinvoice);
							
							if($result=="OK")
							{
								?>
								<div class="center_message">				
									<div class="success">Invoice created !</div>
									<meta http-equiv="refresh" content="5; url=index.php">				
								</div>
								<?php
							}
							else
							{
								?>
								<div class="center_message">				
									<div class="error">There were some errors. Invoice not created !</div>
									<meta http-equiv="refresh" content="5; url=index.php">				
								</div>
								<?php
							}					
						}
						?>
					<h3 class="w-100 text-center">Preview Invoice</h3>
					<hr>
					
					<?php
					
					$o_id=$prod->xss_fix($_GET['o_id']);			
					$order=$prod->get_order($o_id);
					$licenceid=$order['lic_ID'];
					$licence=$prod->get_licence($licenceid);
					
					?>
					<form name="create_invoice" method="post" enctype="multipart/form-data" action="invoice_template.php?option=create&type=simple_invoice">
					<p class="text-center w-100 mb-0">
                        Licence <input type="text" name="licenceid" value="<?php echo $licenceid;?>" class="form-control form-control-sm"> is in this language: <?php 
                        $licence_languages=explode(";",$licence['languages_on_page']);
                        for($i=0;$i<count($licence_languages);$i++)
                        {
                            if(!empty($licence_languages[$i]))
                            {
                                echo $prod->get_language($licence_languages[$i])['ln_name']." ";
                            }
                        } ?>
                        <input type="hidden" id="licence_language" value="<?php echo $licence['languages_on_page'];?>" >
                    </p>
					
                    <p class="w-100 text-center mb-0">
                        Client chose this language: <?php 
                        echo $client_language=$prod->get_language($order['client_language_id'])['ln_name'];
                        ?>
                    </p>
                    <p class="w-100 text-center mb-0">
                        Client chose this currency: <?php 
                        echo $currency=$prod->get_currency($order['cur_id'])['cur_short'];
                        ?>
                    </p>
                    <br>
					<input type="hidden" id="client_language" value="<?php echo $order['client_language_id'];?>" >
					
					<br>
					<p class="w-100 text-center">
                        <b>Create invoices in these languages: </b>
                    </p>
				
					<div class="form-group form-inline d-flex justify-content-center">
                        <input class="form-control mr-1" type="checkbox" id="English-US" name="language[]" value="1" >
                        <label class="mr-3" for="English-US">English-US</label>
                        <input class="form-control mr-1" type="checkbox" id="German" name="language[]" value="49" >
                        <label class="mr-3" for="German">German</label>
                        <input class="form-control mr-1" type="checkbox" id="Russian" name="language[]" value="7" >
                        <label class="mr-3" for="Russian">Russian</label>
                        <input class="form-control mr-1" type="checkbox" id="Spanish" name="language[]" value="34" >
                        <label class="mr-3" for="Spanish">Spanish</label>
                        <input class="form-control mr-1" type="checkbox" id="Romanian" name="language[]" value="40" >
                        <label class="mr-3" for="Romanian">Romanian</label>
                        <input class="form-control mr-1" type="checkbox" id="Hungarian" name="language[]" value="36" >
                        <label class="mr-3" for="Hungarian">Hungarian</label>
						<input type="hidden" name="o_id" value="<?php echo $_GET['o_id']; ?>" >
						<input type="hidden" name="clientid" value="<?php echo $_GET['clientid'];?>" >
						<!-- <input type="hidden" name="licenceid" value="<?php echo $_GET['licenceid'];?>" > -->
					</div>
					
					<div class="center_message w-100 d-flex justify-content-center">
						<button type="submit" name="submit_btn" class="btn btn-primary btn-sm mb-5">Preview invoice !</button>
					</div>
					</form>
					<script type="text/javascript" src="js/autoselect_checkbox.js"></script>
					</div> <!-- end fluid container -->
					<br><br><!--end create -->
				<?php
					}
					
					if($type=="cumulative_invoice")
					{						
						$mc_id=$prod->xss_fix($_GET['mc_id']) ?? "0";
						$licenceid="04902";
						$client_language_id=49;
						$licence=$prod->get_licence($licenceid);
					?>
                    <p class="display-4 w-100 text-center">Preview Cumulative Invoice</p>
					<hr>
					<br>
					<form name="create_cumulative_invoice" method="get" enctype="multipart/form-data" action="invoice_template.php?option=create&type=cumulative_invoice">
					<input type="hidden" name="option" value="create">
					<input type="hidden" name="type" value="cumulative_invoice">
					<div class="row w-100 mx-0 d-flex justify-content-center">
						<div class="col-md-3 pt-4 d-flex">					
							<input list="u_client" id="client_id" name="u_client" class="form-control form-control-sm" style="width:7em;" placeholder="Simple client" autocomplete="off" required>
							<datalist id="u_client">
								<?php			
								$active_clients=$prod->get_all_active_clients();								
								
								for($i=0;$i<count($active_clients);$i++)
								{
								?>
								<option value="<?php echo $active_clients[$i]['client_ID'];?>"><?php 
								if((!empty($active_clients[$i]['c_last_name']))&&(!empty($active_clients[$i]['c_first_name'])))
								{
								echo $active_clients[$i]['c_last_name'].", ".$active_clients[$i]['c_first_name'];
								}?></option>	
								<?php
								}
								?>
							</datalist>
							<span id="clientname"></span>
						</div>
						<div class="col-md-3 pt-4 d-flex">
							<input list="main_client" id="mc_id" name="main_client" class="form-control form-control-sm" style="width:8em;" autocomplete="off" placeholder="Main client" required>
							<datalist id="main_client">
								<?php
								$main_clients=$prod->get_all_main_clients();
								for($i=0;$i<count($main_clients);$i++)
								{
								?>
								<option value="<?php echo $main_clients[$i]['mc_id'];?>"><?php echo $main_clients[$i]['clientname'];?></option>	
								<?php
								}
								?>
							</datalist>
							<span id="companyname"></span>
						</div>
						<script type="text/javascript">
                        $('#mc_id').on('change',function(){
                        
                        if($('#mc_id').val()!="")
						{
                            $('#client_id').removeAttr('required');

							$.ajax({
								url: "../ajax/get_main_client.php",
								method: "get",
								data: {mc_id:$('#mc_id').val()},
								dataType:"html",
								success:function(data) {
									$('#companyname').text(data);	
								}
							});

                        }

                        });                        

                        $('#client_id').on('change',function(){

						if($('#client_id').val()!="")
						{
                            $('#mc_id').removeAttr('required');

							$.ajax({
								url: "../ajax/get_client.php",
								method: "get",
								data: {uca_id:$('#client_id').val()},
								dataType:"html",
								success:function(data) {
									$('#clientname').text(data);	
								}
							});
                        }

                        });
                        </script>
						<div class="col-md-2">
							<div class="form-inline">
								<label>Start date:</label>
								<input type="text" name="invoice_start_date" id="invoice_start_date" value="<?php echo date("Y-m-01");?>" class="form-control form-control-sm" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-inline">
								<label>End date:</label>
								<input type="text" name="invoice_end_date" id="invoice_end_date" value="<?php echo date("Y-m-t");?>" class="form-control form-control-sm" autocomplete="off" required>
							</div>
						</div>
					</div>	
					<script type="text/javascript">
					$('#invoice_start_date').datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat: "yy-mm-dd"						
					});
					
					$('#invoice_end_date').datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat: "yy-mm-dd"						
					});
					</script>
					<br>
                    
                    <p class="w-100 justify-content-center mb-0 d-flex">
                        Licence <input type="text" list="licenceids" name="licenceid" value="<?php echo $licenceid;?>" class="form-control form-control-sm" style="width:100px;" autocomplete="off"> is in this language: <?php echo $licence_language=$prod->get_language($licence['languages_on_page'])['ln_name']; ?>
                        <?php
                        $licenceids=$prod->get_licence_ids();
                        ?>
                        <datalist id="licenceids">
                            <?php
                            for($l=0;$l<count($licenceids);$l++)
                            {
                            ?>
                            <option value="<?php echo $licenceids[$l]['lic_id'];?>">
                            <?php
                            }
                            ?>
                        </datalist>
                        <input type="hidden" id="licence_language" value="<?php echo $licence['languages_on_page'];?>" >
                    </p>
                
                    <p class="w-100 text-center">
                        Client chose this language: <?php 
                        echo $client_language=$prod->get_language($client_language_id)['ln_name'];
                        ?>
                    </p>
					
                    <br><br>
					<input type="hidden" id="client_language" value="<?php echo $client_language_id;?>" >
						
					<div class="row w-100 mx-0">
						<div class="col-md-12 text-center">
							<b class="pl-4">Create invoices in these languages: </b>
					
							<div class="form-group form-inline pl-4 d-flex justify-content-center">
								<input class="form-control mx-2" type="checkbox" id="English-US" name="language[]" value="1" <?php echo ($client_language_id==1)?"checked":"";?>><label for="English-US">English-US</label>
								<input class="form-control mx-2" type="checkbox" id="German" name="language[]" value="49" <?php echo ($client_language_id==49)?"checked":"";?>><label for="German">German</label>
								<input class="form-control mx-2" type="checkbox" id="Russian" name="language[]" value="7" <?php echo ($client_language_id==7)?"checked":"";?>><label for="Russian">Russian</label>
								<input class="form-control mx-2" type="checkbox" id="Spanish" name="language[]" value="34" <?php echo ($client_language_id==34)?"checked":"";?>><label for="Spanish">Spanish</label>
								<input class="form-control mx-2" type="checkbox" id="Romanian" name="language[]" value="40" <?php echo ($client_language_id==40)?"checked":"";?>><label for="Romanian">Romanian</label>
								<input class="form-control mx-2" type="checkbox" id="Hungarian" name="language[]" value="36" <?php echo ($client_language_id==36)?"checked":"";?>><label for="Hungarian">Hungarian</label>
			
								<!-- <input type="hidden" name="licenceid" value="<?php echo $licenceid;?>" > -->
							</div>
						
							<div class="center_message w-100 row mx-0 pl-3">
                                <button type="submit" name="check_invoice_btn" class="btn btn-danger btn-sm mx-auto mb-5">Check invoice !</button>
                                <button type="submit" name="preview_invoice_btn" class="btn btn-primary btn-sm mx-auto mb-5">Preview invoice !</button>
							</div>
						</div>
					</div>
					</form>
					<br>
					<?php
					}
					
				} //create
			} //option
			else
			{
			?>
            <p class="display-4 w-100 text-center">Invoiced:</p>
            <table id="invoice_table" class="table table-striped">
                <thead>
                    <th scope="col">Invoice nr.</th>
                    <th scope="col">Invoice date</th>
                    <th scope="col">Order ID-Licence ID</th>
                    <th scope="col">Client name</th>
                    <th scope="col">Net amount</th>
                    <th scope="col">VAT</th>
                    <th scope="col">Brut amount</th>
                    <th scope="col"></th>
                </thead>
           
			<?php
			$licences=$prod->get_licence_ids();
			
			$new_data=array();
			$new_data_counter=0;

			for($i=0;$i<count($licences);$i++)
			{
				$licence_id=$licences[$i]['lic_id'];
				$invoices=$domenia3->show_invoices($licence_id);
				$currency=$prod->get_currency($licences[$i]['currencies'])['cur_short'];
			
			for($j=0;$j<count($invoices);$j++)
			{
                ?>
                <tr id="row<?php echo $invoices[$j]['i_id']."_".$licences[$i]['lic_id']; ?>">
                    <td><?php echo $invoices[$j]['invoice_id']; ?></td>
                    <td><?php echo $invoices[$j]['i_date']; ?></td>
                    <td class="ellipsis" style="width:150px;display:block;">
                    <span title="<?php echo $licences[$i]['lic_id']."<br>-".$invoices[$j]['o_id']; ?>"><?php echo $licences[$i]['lic_id']."<br>-".$invoices[$j]['o_id']; ?></span>
                    </td>
                    <td><?php 
                    $client=$prod->get_client($invoices[$j]['c_id']);
                    echo $client['clientname']; ?></td>
                    <td><?php echo $invoices[$j]['i_net']." ".$currency; ?></td>
                    <td><?php echo "( ".$invoices[$j]['i_vat_percent']." %) ".$invoices[$j]['i_vat']." ".$currency; ?></td>
                    <td><?php echo $invoices[$j]['i_net']+$invoices[$j]['i_vat']." ".$currency; ?></td>
                    <td><a class="btn btn-primary btn-sm" href="../image.php?filecategory=invoice&invoiceid=<?php echo $invoices[$j]['i_id']; ?>&licenceid=<?php echo $licences[$i]['lic_id']; ?>"><i class="fas fa-file-download mr-1"></i> View invoice</a>
                    <button id="delete_btn<?php echo $invoices[$j]['i_id']."_".$licences[$i]['lic_id']; ?>" data-i_id="<?php echo $invoices[$j]['i_id']; ?>" data-licenceid="<?php echo $licences[$i]['lic_id']; ?>" name="delete_btn<?php echo $invoices[$j]['i_id']; ?>" class="btn btn-sm btn-danger">X</button>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('#delete_btn<?php echo $invoices[$j]['i_id']."_".$licences[$i]['lic_id']; ?>').click(function(){

                            if(confirm('Are you sure you want to delete this invoice ?\nThis is a permanent delete !')) 
                            {
                                $.ajax({
                                    url: "../ajax/delete_invoice.php",
                                    method: "post",
                                    data: {i_id:$(this).data('i_id'),licenceid:$(this).data('licenceid')},
                                    dataType:"html",
                                    success:function(data) {
                                        //console.log(data);	
                                        $('#row<?php echo $invoices[$j]['i_id']."_".$licences[$i]['lic_id']; ?>').fadeOut(3000);
                                    }
                                });
                            }

                        });
                    });
                    </script>
                    </td>
                </tr>			
				<?php
				$new_data[$new_data_counter]=$invoices[$j];
				$new_data[$new_data_counter]['lic_id']=$licences[$i]['lic_id'];
				$new_data_counter++;
			}
			}

			
			?>
            </table>
			<script type="text/javascript">
				$(document).ready(function(){

        
				$('#invoice_table').DataTable({

				"order": [[ 1, "desc" ]],
				iDisplayLength: -1

				});

				});
			</script>
			<br>
			<?php
			//print_r($new_data);
			} //no create
		
		} //logged in
		else
		{
			?>
			<div class="center_message">
				
				<div class="error">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br> <br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
		</article>
	
</section>
<?php
include('../footer.php');
?>