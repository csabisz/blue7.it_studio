<?php
session_start();
include('../functions.php');
include('../../../../blue7.it/public_html/domenia/domenia.php');

$prod=new Production;
$domenia=new Domenia;

$base_url="https://blue7.it/studio/";
$o_id=$prod->xss_fix($_GET['o_id']);
?>

<div class="col-md-12 px-0">
	<!-- new file uploader -->
	
	<div class="row w-100 mx-0 text-center mb-4">
		<div class="col-md-2">
			<p class="col text-center w-100 text-success mb-0" style="display: flex; align-items: center; justify-content: flex-start; "><b class="border-bottom pb-2 d-flex" style="color: #3478dc" ><?php
			//Customer files:
			if(isset($selected_lang))
			{
				$text=$domenia->get_translation_text($selected_lang,"tx_1571","x-texts")['text'];
				if(!empty($text))
				{
					echo $text;
				}
				else
				{
					$text=$domenia->get_translation_text(1,"tx_1571","x-texts")['text'];
					echo $text;
				}
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tx_1571","x-texts")['text'];
				echo $text;
			}?></b>
			</p> 
		</div>
		<div class="col-md-3">
			<button type="button" id="choose_customer_files_btn" data-toggle="modal" data-target="#choose_customer_files_modal" data-backdrop="static" data-keyboard="false" class="btn btn-sm btn-warning">Choose customer files...</button>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="choose_customer_files_modal" tabindex="-1" role="dialog" aria-labelledby="choose_customer_filesLabel" aria-hidden="true" >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" style="background-color:#C4A484;">
			<div class="modal-header">
				<h5 class="modal-title" id="choose_customer_filesLabel">Choose customer files</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body choose-customer-files-modal-body">
				
				<div id="customer_files_rows">
					<form id="upload_customer_files_form" name="upload_customer_files_form"  method="post" enctype="multipart/form-data"></form>
					<div class="row">
						<div class="col-md-3">
							<input type="file" name="customer_files_myfile[]" class="form-control form-control-sm" form="upload_customer_files_form">
						</div>
						<div class="col-md-2">
						<select id="customer_files_of_kind0" name="customer_files_of_kind[]" class="form-control form-control-sm" form="upload_customer_files_form">
							<option>Error ! Choose an option</option>
							<option value="1" selected>Order! Main file</option>
							<option value="8">NO ORDER! Only for understanding</option>
							<option value="2">Outview-Photo</option>
						</select>
						</div>
						<div class="col-md-2">
							<input type="text" placeholder="Title Intern" class="form-control form-control-sm" list="customer_files_predefined_subtitles0" id="customer_files_of_subtitle0" name="customer_files_of_subtitle[]" form="upload_customer_files_form">

							<datalist id="customer_files_predefined_subtitles0">
								<option value="floorplan-l-1">
								<option value="floorplan-l00">
								<option value="floorplan-l01">
								<option value="floorplan-l02">
								<option value="floorplans-all">
								<option value="map-area">
								<option value="map-plot">
								<option value="photo">
								<option value="section-1-1">
								<option value="section-2-2">
								<option value="section-3-3">
								<option value="section-4-4">
								<option value="view-1-1">
								<option value="view-2-2">
								<option value="view-3-3">
								<option value="view-4-4">
							</datalist>
						</div>
						<div class="col-md-2">
							<button id="assign_to_subids_btn0" type="button" class="btn btn-sm btn-primary">Assign to subIDs</button>
							<div id="customer_files_selected_subids0_text">								
							</div>
							<input type="hidden" id="customer_files_selected_subids0" name="customer_files_selected_subids[]" value="" form="upload_customer_files_form">
							<script type="text/javascript">
							$('#assign_to_subids_btn0').click(function(){
								//$('#choose_customer_files_modal').modal('hide');
								$('#customer_files_subidModal0').modal('show');
							});
							</script>
							<!-- Modal -->
							<div class="modal fade" id="customer_files_subidModal0" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="customer_files_subidModalLabel0" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="customer_files_subidModalLabel0">Assign to subIDs</h5>
										<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button> -->
									</div>
									<div class="modal-body">
										<?php
										$all_subids=$prod->get_all_subids_by_o_id($o_id);
										?>
										<div class="row">
											<div class="col-md-6">
												<b>Interior</b>
											</div>
											<div class="col-md-6">
												<b>Exterior</b>
											</div>
										</div> 
										<div class="row">
											<div class="col-md-6">
												<?php
												$subids_counter=0;
												for($i=0;$i<count($all_subids);$i++)
												{
													
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'n') !== false)
														{
															?>
															<input type="checkbox" id="subo_id_cbx_0_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_0" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
															<label for="subo_id_cbx_0_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
															<?php
															
														}
														?>
														</div> <!-- end col-md-12 -->
													</div> <!--end interior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->
											<div class="col-md-6"><?php
												
												for($i=0;$i<count($all_subids);$i++)
												{            
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'x') !== false)
														{
														?>
														<input type="checkbox" id="subo_id_cbx_0_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_0" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
														<label for="subo_id_cbx_0_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
														<?php
														}
														?></div> <!-- end col-md-12 -->
													</div> <!-- end exterior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->       
										</div> <!-- end row -->

									</div>
									<div class="modal-footer">
										<button id="customer_files_subid_close_btn0" type="button" class="btn btn-secondary">Close</button>
										<script type="text/javascript">
										$('#customer_files_subid_close_btn0').click(function(){

											let selectedValues = [];
											$('.customer_files_subo_id_cbx_0').each(function(){
												if($(this).is(':checked')){
													selectedValues.push($(this).val());
												}
											});
											
											$('#customer_files_selected_subids0_text').html(selectedValues.join(','));
											$('#customer_files_selected_subids0').val(selectedValues.join(','));
											$('#customer_files_subidModal0').modal('hide');

											});
										</script>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<select id="customer_files_level0" name="customer_files_level[]" class="form-control form-control-sm" style="width:5em;" form="upload_customer_files_form">
									<option value="??? unknown;">??? unknown</option>
									<?php
									for($z=-4;$z<0;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=0;$z<10;$z++)
									{
										?>
									<option value="<?php echo "L 0".$z;?>" <?php echo ($z==0)?"selected":"";?>><?php echo "L 0".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=10;$z<100;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<input type="file" name="customer_files_myfile[]" class="form-control form-control-sm" form="upload_customer_files_form">
						</div>
						<div class="col-md-2">
						<select id="customer_files_of_kind1" name="customer_files_of_kind[]" class="form-control form-control-sm" form="upload_customer_files_form">
							<option>Error ! Choose an option</option>
							<option value="1" selected>Order! Main file</option>
							<option value="8">NO ORDER! Only for understanding</option>
							<option value="2">Outview-Photo</option>
						</select>
						</div>
						<div class="col-md-2">
							<input type="text" placeholder="Title Intern" class="form-control form-control-sm" list="customer_files_predefined_subtitles1" id="customer_files_of_subtitle1" name="customer_files_of_subtitle[]" form="upload_customer_files_form">

							<datalist id="customer_files_predefined_subtitles1">
								<option value="floorplan-l-1">
								<option value="floorplan-l00">
								<option value="floorplan-l01">
								<option value="floorplan-l02">
								<option value="floorplans-all">
								<option value="map-area">
								<option value="map-plot">
								<option value="photo">
								<option value="section-1-1">
								<option value="section-2-2">
								<option value="section-3-3">
								<option value="section-4-4">
								<option value="view-1-1">
								<option value="view-2-2">
								<option value="view-3-3">
								<option value="view-4-4">
							</datalist>
						</div>
						<div class="col-md-2">
							<button id="assign_to_subids_btn1" type="button" class="btn btn-sm btn-primary">Assign to subIDs</button>
							<div id="customer_files_selected_subids1_text">								
							</div>
							<input type="hidden" id="customer_files_selected_subids1" name="customer_files_selected_subids[]" value="" form="upload_customer_files_form">
							<script type="text/javascript">
							$('#assign_to_subids_btn1').click(function(){
								//$('#choose_customer_files_modal').modal('hide');
								$('#customer_files_subidModal1').modal('show');
							});
							</script>
							<!-- Modal -->
							<div class="modal fade" id="customer_files_subidModal1" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="customer_files_subidModalLabel1" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="customer_files_subidModalLabel1">Assign to subIDs</h5>
										<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button> -->
									</div>
									<div class="modal-body">
										<?php
										$all_subids=$prod->get_all_subids_by_o_id($o_id);
										?>
										<div class="row">
											<div class="col-md-6">
												<b>Interior</b>
											</div>
											<div class="col-md-6">
												<b>Exterior</b>
											</div>
										</div> 
										<div class="row">
											<div class="col-md-6">
												<?php
												$subids_counter=0;
												for($i=0;$i<count($all_subids);$i++)
												{
													
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'n') !== false)
														{
															?>
															<input type="checkbox" id="subo_id_cbx_1_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_1" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
															<label for="subo_id_cbx_1_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
															<?php
															
														}
														?>
														</div> <!-- end col-md-12 -->
													</div> <!--end interior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->
											<div class="col-md-6"><?php
												
												for($i=0;$i<count($all_subids);$i++)
												{            
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'x') !== false)
														{
														?>
														<input type="checkbox" id="subo_id_cbx_1_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_1" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
														<label for="subo_id_cbx_1_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
														<?php
														}
														?></div> <!-- end col-md-12 -->
													</div> <!-- end exterior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->       
										</div> <!-- end row -->

									</div>
									<div class="modal-footer">
										<button id="customer_files_subid_close_btn1" type="button" class="btn btn-secondary">Close</button>
										<script type="text/javascript">
										$('#customer_files_subid_close_btn1').click(function(){

											let selectedValues = [];
											$('.customer_files_subo_id_cbx_1').each(function(){
												if($(this).is(':checked')){
													selectedValues.push($(this).val());
												}
											});
											
											$('#customer_files_selected_subids1_text').html(selectedValues.join(','));
											$('#customer_files_selected_subids1').val(selectedValues.join(','));
											$('#customer_files_subidModal1').modal('hide');

											});
										</script>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<select id="customer_files_level1" name="customer_files_level[]" class="form-control form-control-sm" style="width:5em;" form="upload_customer_files_form">
									<option value="??? unknown;">??? unknown</option>
									<?php
									for($z=-4;$z<0;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=0;$z<10;$z++)
									{
										?>
									<option value="<?php echo "L 0".$z;?>" <?php echo ($z==0)?"selected":"";?>><?php echo "L 0".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=10;$z<100;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<input type="file" name="customer_files_myfile[]" class="form-control form-control-sm" form="upload_customer_files_form">
						</div>
						<div class="col-md-2">
						<select id="customer_files_of_kind2" name="customer_files_of_kind[]" class="form-control form-control-sm" form="upload_customer_files_form">
							<option>Error ! Choose an option</option>
							<option value="1" selected>Order! Main file</option>
							<option value="8">NO ORDER! Only for understanding</option>
							<option value="2">Outview-Photo</option>
						</select>
						</div>
						<div class="col-md-2">
							<input type="text" placeholder="Title Intern" class="form-control form-control-sm" list="customer_files_predefined_subtitles2" id="customer_files_of_subtitle2" name="customer_files_of_subtitle[]" form="upload_customer_files_form">

							<datalist id="customer_files_predefined_subtitles2">
								<option value="floorplan-l-1">
								<option value="floorplan-l00">
								<option value="floorplan-l01">
								<option value="floorplan-l02">
								<option value="floorplans-all">
								<option value="map-area">
								<option value="map-plot">
								<option value="photo">
								<option value="section-1-1">
								<option value="section-2-2">
								<option value="section-3-3">
								<option value="section-4-4">
								<option value="view-1-1">
								<option value="view-2-2">
								<option value="view-3-3">
								<option value="view-4-4">
							</datalist>
						</div>
						<div class="col-md-2">
							<button id="assign_to_subids_btn2" type="button" class="btn btn-sm btn-primary">Assign to subIDs</button>
							<div id="customer_files_selected_subids2_text">								
							</div>
							<input type="hidden" id="customer_files_selected_subids2" name="customer_files_selected_subids[]" value="" form="upload_customer_files_form">
							<script type="text/javascript">
							$('#assign_to_subids_btn2').click(function(){
								//$('#choose_customer_files_modal').modal('hide');
								$('#customer_files_subidModal2').modal('show');
							});
							</script>
							<!-- Modal -->
							<div class="modal fade" id="customer_files_subidModal2" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="customer_files_subidModalLabel2" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="customer_files_subidModalLabel2">Assign to subIDs</h5>
										<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button> -->
									</div>
									<div class="modal-body">
										<?php
										$all_subids=$prod->get_all_subids_by_o_id($o_id);
										?>
										<div class="row">
											<div class="col-md-6">
												<b>Interior</b>
											</div>
											<div class="col-md-6">
												<b>Exterior</b>
											</div>
										</div> 
										<div class="row">
											<div class="col-md-6">
												<?php
												$subids_counter=0;
												for($i=0;$i<count($all_subids);$i++)
												{
													
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'n') !== false)
														{
															?>
															<input type="checkbox" id="subo_id_cbx_2_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_2" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
															<label for="subo_id_cbx_2_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
															<?php
															
														}
														?>
														</div> <!-- end col-md-12 -->
													</div> <!--end interior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->
											<div class="col-md-6"><?php
												
												for($i=0;$i<count($all_subids);$i++)
												{            
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'x') !== false)
														{
														?>
														<input type="checkbox" id="subo_id_cbx_2_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_2" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
														<label for="subo_id_cbx_2_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
														<?php
														}
														?></div> <!-- end col-md-12 -->
													</div> <!-- end exterior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->       
										</div> <!-- end row -->

									</div>
									<div class="modal-footer">
										<button id="customer_files_subid_close_btn2" type="button" class="btn btn-secondary">Close</button>
										<script type="text/javascript">
										$('#customer_files_subid_close_btn2').click(function(){

											let selectedValues = [];
											$('.customer_files_subo_id_cbx_2').each(function(){
												if($(this).is(':checked')){
													selectedValues.push($(this).val());
												}
											});
											
											$('#customer_files_selected_subids2_text').html(selectedValues.join(','));
											$('#customer_files_selected_subids2').val(selectedValues.join(','));
											$('#customer_files_subidModal2').modal('hide');

											});
										</script>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<select id="customer_files_level2" name="customer_files_level[]" class="form-control form-control-sm" style="width:5em;" form="upload_customer_files_form">
									<option value="??? unknown;">??? unknown</option>
									<?php
									for($z=-4;$z<0;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=0;$z<10;$z++)
									{
										?>
									<option value="<?php echo "L 0".$z;?>" <?php echo ($z==0)?"selected":"";?>><?php echo "L 0".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=10;$z<100;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<input type="file" name="customer_files_myfile[]" class="form-control form-control-sm" form="upload_customer_files_form">
						</div>
						<div class="col-md-2">
						<select id="customer_files_of_kind3" name="customer_files_of_kind[]" class="form-control form-control-sm" form="upload_customer_files_form">
							<option>Error ! Choose an option</option>
							<option value="1" selected>Order! Main file</option>
							<option value="8">NO ORDER! Only for understanding</option>
							<option value="2">Outview-Photo</option>
						</select>
						</div>
						<div class="col-md-2">
							<input type="text" placeholder="Title Intern" class="form-control form-control-sm" list="customer_files_predefined_subtitles3" id="customer_files_of_subtitle3" name="customer_files_of_subtitle[]" form="upload_customer_files_form">

							<datalist id="customer_files_predefined_subtitles3">
								<option value="floorplan-l-1">
								<option value="floorplan-l00">
								<option value="floorplan-l01">
								<option value="floorplan-l02">
								<option value="floorplans-all">
								<option value="map-area">
								<option value="map-plot">
								<option value="photo">
								<option value="section-1-1">
								<option value="section-2-2">
								<option value="section-3-3">
								<option value="section-4-4">
								<option value="view-1-1">
								<option value="view-2-2">
								<option value="view-3-3">
								<option value="view-4-4">
							</datalist>
						</div>
						<div class="col-md-2">
							<button id="assign_to_subids_btn3" type="button" class="btn btn-sm btn-primary">Assign to subIDs</button>
							<div id="customer_files_selected_subids3_text">								
							</div>
							<input type="hidden" id="customer_files_selected_subids3" name="customer_files_selected_subids[]" value="" form="upload_customer_files_form">
							<script type="text/javascript">
							$('#assign_to_subids_btn3').click(function(){
								//$('#choose_customer_files_modal').modal('hide');
								$('#customer_files_subidModal3').modal('show');
							});
							</script>
							<!-- Modal -->
							<div class="modal fade" id="customer_files_subidModal3" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="customer_files_subidModalLabel3" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="customer_files_subidModalLabel3">Assign to subIDs</h5>
										<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button> -->
									</div>
									<div class="modal-body">
										<?php
										$all_subids=$prod->get_all_subids_by_o_id($o_id);
										?>
										<div class="row">
											<div class="col-md-6">
												<b>Interior</b>
											</div>
											<div class="col-md-6">
												<b>Exterior</b>
											</div>
										</div> 
										<div class="row">
											<div class="col-md-6">
												<?php
												$subids_counter=0;
												for($i=0;$i<count($all_subids);$i++)
												{
													
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'n') !== false)
														{
															?>
															<input type="checkbox" id="subo_id_cbx_3_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_3" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
															<label for="subo_id_cbx_3_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
															<?php
															
														}
														?>
														</div> <!-- end col-md-12 -->
													</div> <!--end interior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->
											<div class="col-md-6"><?php
												
												for($i=0;$i<count($all_subids);$i++)
												{            
													?>
													<div class="row">
														<div class="col-md-12"><?php
														if(strpos($all_subids[$i]['o_sub_id'], 'x') !== false)
														{
														?>
														<input type="checkbox" id="subo_id_cbx_3_<?php echo $subids_counter;?>" class="form-input customer_files_subo_id_cbx_3" value="<?php echo $all_subids[$i]['o_sub_id'];?>">
														<label for="subo_id_cbx_3_<?php echo $subids_counter;?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
														<?php
														}
														?></div> <!-- end col-md-12 -->
													</div> <!-- end exterior row -->
													
													<?php
													$subids_counter++;
												}
												?>
											</div> <!-- end col-md-6 -->       
										</div> <!-- end row -->

									</div>
									<div class="modal-footer">
										<button id="customer_files_subid_close_btn3" type="button" class="btn btn-secondary">Close</button>
										<script type="text/javascript">
										$('#customer_files_subid_close_btn3').click(function(){

											let selectedValues = [];
											$('.customer_files_subo_id_cbx_3').each(function(){
												if($(this).is(':checked')){
													selectedValues.push($(this).val());
												}
											});
											
											$('#customer_files_selected_subids3_text').html(selectedValues.join(','));
											$('#customer_files_selected_subids3').val(selectedValues.join(','));
											$('#customer_files_subidModal3').modal('hide');

											});
										</script>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<select id="customer_files_level3" name="customer_files_level[]" class="form-control form-control-sm" style="width:5em;" form="upload_customer_files_form">
									<option value="??? unknown;">??? unknown</option>
									<?php
									for($z=-4;$z<0;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=0;$z<10;$z++)
									{
										?>
									<option value="<?php echo "L 0".$z;?>" <?php echo ($z==0)?"selected":"";?>><?php echo "L 0".$z;?></option>
									<?php
									}
									?>
									<?php
									for($z=10;$z<100;$z++)
									{
										?>
									<option value="<?php echo "L ".$z;?>"><?php echo "L ".$z;?></option>
									<?php
									}
									?>
							</select>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-12 text-left">
						<button id="add_more_customer_files_btn" type="button" class="btn btn-sm btn-primary">Add more files</button>
					</div>
				</div> -->
				<div class="row">
					<div class="col-md-12">
						<div id="upload_customer_files_loading_spinner" class="d-none">
							<img src="<?php echo $base_url;?>img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
						</div>
						<div id="upload_customer_files_message" class="text-center"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="choose_customer_files_close_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="start_upload_customer_files_btn" type="button" class="btn btn-success">Start upload</button>
				<script type="text/javascript">
				$('#choose_customer_files_close_btn').click(function(){
					setTimeout(function(){

							get_customer_files();

							},1000);
				});

				$('#start_upload_customer_files_btn').click(function(){

					$('#upload_customer_files_loading_spinner').removeClass('d-none');

					$('#upload_customer_files_message').html("");
					let formData2= new FormData($('#upload_customer_files_form')[0]);

					$.ajax({

						url: "<?php echo $base_url;?>upload_files_beta.php?filecategory=newcustomerfiles&o_id=<?php echo $o_id;?>",

						type: 'POST',

						data: formData2,

						cache: false,

						processData: false,

						contentType: false,

						enctype: 'multipart/form-data',

						dataType:"html",

						success:function(data) {

							

						}

					}).done(function(data){



						html = data;           

						$('#upload_customer_files_loading_spinner').addClass('d-none');

						$('#upload_customer_files_message').html(html);
						$('#upload_customer_files_message').fadeIn().delay('3000').fadeOut();

						setTimeout(function(){

							$('#choose_customer_files_modal').modal('hide');

						},1000);

						setTimeout(function(){

							get_customer_files();

							},2000);

					});

					});
				</script>
			</div>
			</div>
		</div>
		</div>
		<div class="col-md-auto">
			<input type="checkbox" id="do_not_recreate_jpg_checkbox" name="do_not_recreate_jpg_checkbox" class="products" value="<?php echo (!empty($order['do_not_recreate_jpg_on_file_delete']))?$order['do_not_recreate_jpg_on_file_delete']:"0";?>">
			<label for="do_not_recreate_jpg_checkbox" class="ml-2 text-danger font-weight-bold">Do not recreate JPG files from PDF files on customer file delete</label>
			<script type="text/javascript">
			$('#do_not_recreate_jpg_checkbox').click(function(){
				if($(this).is(':checked'))
				{
					$('#do_not_recreate_jpg_checkbox').val('1');
					let do_not_recreate_jpg_on_file_delete=1;
					let o_id=<?php echo $o_id;?>;

					$.ajax({

						url: "<?php echo $base_url;?>ajax/update_do_not_recreate_jpg_on_file_delete.php",
						method: "post",
						data: {do_not_recreate_jpg_on_file_delete:do_not_recreate_jpg_on_file_delete,o_id:o_id},
						dataType:"html",
						success:function(data) {
							console.log(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						}
					});

				}
				else
				{
					$('#do_not_recreate_jpg_checkbox').val('0');

					let do_not_recreate_jpg_on_file_delete=0;
					let o_id=<?php echo $o_id;?>;
					
					$.ajax({

						url: "<?php echo $base_url;?>ajax/update_do_not_recreate_jpg_on_file_delete.php",
						method: "post",
						data: {do_not_recreate_jpg_on_file_delete:do_not_recreate_jpg_on_file_delete,o_id:o_id},
						dataType:"html",
						success:function(data) {
							console.log(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						}
					});
				}
			});
			</script>
		</div>
	</div>

<?php /*
<div class="row w-100 mx-0 text-center mb-4">
	<div class="col-md-6">
		<p class="col text-center w-100 text-success mb-0" style="display: flex; align-items: center; justify-content: flex-start; "><b class="border-bottom pb-2 d-flex" style="color: #3478dc" ><?php
		//Customer files:
		if(isset($selected_lang))
		{
			$text=$domenia->get_translation_text($selected_lang,"tx_1571","x-texts")['text'];
			if(!empty($text))
			{
				echo $text;
			}
			else
			{
				$text=$domenia->get_translation_text(1,"tx_1571","x-texts")['text'];
				echo $text;
			}
		}
		else
		{
			$text=$domenia->get_translation_text(1,"tx_1571","x-texts")['text'];
			echo $text;
		}?></b>
		</p> 
	</div>
	<div class="col-md-6" style="display: flex; align-items: center; justify-content: center; ">
	
		<form id="upload_customer_files_form" name="upload_customer_files_form"  method="post" enctype="multipart/form-data"></form>
		<input type="file" name="myfile[]" class="form-control form-control-sm" form="upload_customer_files_form" multiple>
		<button id="start_upload_btn" type="button" class="btn btn-sm btn-success" disabled>Start upload</button>
	
	</div>
	<div class="col-md-12">
		<div id="loading_spinner" class="d-none">
			<img src="<?php echo $base_url;?>img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
		</div>
		<div id="upload_customer_files_message" class="text-center"></div>
	</div>
	<script type="text/javascript">
		$('#start_upload_btn').click(function(){

			$('#loading_spinner').removeClass('d-none');

			$('#upload_customer_files_message').html("");
			let formData= new FormData($('#upload_customer_files_form')[0]);

			$.ajax({

				url: "<?php echo $base_url;?>upload_files_beta.php?filecategory=customerfiles&o_id=<?php echo $o_id;?>",

				type: 'POST',

				data: formData,

				cache: false,

				processData: false,

				contentType: false,

				enctype: 'multipart/form-data',

				dataType:"html",

				success:function(data) {

					console.log(data);

				}

			}).done(function(data){



				html = data;           

				$('#loading_spinner').addClass('d-none');

				$('#upload_customer_files_message').html(html);
				$('#upload_customer_files_message').fadeIn().delay('3000').fadeOut();
				setTimeout(function(){

					get_customer_files();

					},1000);

			});
		});
	</script>
</div> 
*/ ?>


    <?php
$customer_files=$prod->get_customer_files($o_id);

?>
<div class="row w-100 mx-0 border-top border-dark bg-light border-bottom" style="border-left: 1px solid black; border-right: 1px solid black">
	<div class="col-md-2 border-right pt-3 border-dark">
		<b><?php
		?>Title Client</b>
	</div>
	<?php
	if(isset($_COOKIE['client_id']))
	{
	?>
	<div class="col-md-1 border-right pt-3 border-dark">
		<b>File</b>
	</div>
	<div class="col-md-2 border-right pt-3 border-dark">
		<b>Note</b>
	</div>
	<div class="col-md-2 border-right pt-3 border-dark">
		<b style="font-size: 13px;">Title Intern<br>(english)</b>
	</div>
	<div class="col-md-2 border-right pt-3 border-dark" style="max-width: 8vw;">
		<b>Interior/Exterior Sub-ID</b>
	</div>
    <div class="col-md-1 border-right pt-3 border-dark">
        <b>Level</b>
    </div>

    <div class="col-md-1 pt-3">
        <p class="d-flex">
            <span><i class="fas fa-3x fa-file-download"></i></span>
            <a href="../image.php?filecategory=customerfiles&download-all=<?php echo $o_id;?>" class="btn btn-sm btn-primary">Download all</a>
        </p>
    </div>
	<?php
	}
	?>
</div>
<?php
function formatSizeUnits($bytes) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = floor(log($bytes, 1024));

    return sprintf('%.2f', $bytes / pow(1024, $i)) . ' ' . $units[$i];
}

for($i=0;$i<count($customer_files);$i++)
{
	if($customer_files[$i]['of_type_dom']!="pdf")
    {
		$validextensions = array("jpeg", "jpg", "png","webp");
		?>
		<div id="client_file_row<?php echo $customer_files[$i]['of_id'];?>" class="row colorline w-100 mx-0 border-bottom border-dark " style="border-left: 1px solid black; border-right: 1px solid black">
			<div class="col-md-2 border-right border-dark py-3 ">
				<span class="removeBr" title="<?php echo $customer_files[$i]['of_name_client']; ?>"><?php //echo $customer_files[$i]['of_name_client'];
				mb_internal_encoding("UTF-8");
				$chunkSize = 10;
				$length = strlen($customer_files[$i]['of_name_client']);

				for ($c = 0; $c < $length; $c += $chunkSize)
				{
					$chunk = substr($customer_files[$i]['of_name_client'], $c, $chunkSize);
					echo $chunk . "<br>";
				}
				?></span>
			</div>
			<div class="col-md-1 border-right border-dark py-3">
				<div id="customer_image_tooltip_container_<?php



				if(in_array($customer_files[$i]['of_type_dom'],$validextensions))
				{
					echo $i;
				}
				?>">
                    <?php
                    // Define the function to format file size

                    $file_path2 = '../client_files/' . $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom'];


                    if($customer_files[$i]['of_type_dom'] == "pdf") {
                        ?>
                        <img src="<?php echo $base_url;?>img/adobe-pdf-icon.png" alt="<?php echo $customer_files[$i]['of_name_client'];?>" style="width:60px;">
                        <?php
                        $file_path = $base_url . 'img/adobe-pdf-icon.png';
                    } 
					elseif($customer_files[$i]['of_type_dom'] == "docx") 
					{

                        ?>
                        <img src="<?php echo $base_url;?>img/microsoft-word-icon.png" alt="<?php echo $customer_files[$i]['of_name_client'];?>" style="width:60px;">
                        <?php
                        $file_path = $base_url . 'img/microsoft-word-icon.png';

                    }
					elseif($customer_files[$i]['of_type_dom'] == "pptx") 
					{

                        ?>
                        <img src="<?php echo $base_url;?>img/microsoft-powerpoint-icon.png" alt="<?php echo $customer_files[$i]['of_name_client'];?>" style="width:60px;">
                        <?php
                        $file_path = $base_url . 'img/microsoft-powerpoint-icon.png';

                    }
					elseif($customer_files[$i]['of_type_dom'] == "dxf") 
					{
                        ?>
                        <img src="<?php echo $base_url;?>img/dxf_icon.jpg" alt="<?php echo $customer_files[$i]['of_name_client'];?>" style="width:60px;">
                        <?php
                        $file_path = $base_url . 'img/dxf_icon.jpg';

                    }
					elseif(in_array($customer_files[$i]['of_type_dom'], $validextensions)) 
					{
                        $file_path = $base_url . 'client_files/' . $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom'];

                        ?>
                        <img src="<?php echo $file_path; ?>" class="img-responsive" alt="<?php echo $customer_files[$i]['of_name_client'];?>" style="width:60px;">
                        <?php
                    }
					
					if(file_exists($file_path2))
					{
						$file_size = filesize($file_path2);
						$file_size_formatted = formatSizeUnits($file_size); // Format the file size
						echo "$file_size_formatted";
					}
					else
					{
						echo "File not found";
					}
                    ?>
                </div>
			</div>
			<?php
			if(isset($_COOKIE['client_id']))
			{
			?>
			<div class="col-md-2 border-right border-dark py-3">
			<select id="change_note<?php echo $i;?>" name="change_note" class="form-control form-control-sm">
				<option>Error ! Choose an option</option>
				<option value="<?php echo $customer_files[$i]['of_id']; ?>;1;" <?php echo ($customer_files[$i]['of_kind']==1)?"selected":"";?>>Order! Main file</option>
				<option value="<?php echo $customer_files[$i]['of_id']; ?>;8;" <?php echo ($customer_files[$i]['of_kind']==8)?"selected":"";?>>NO ORDER! Only for understanding</option>
				<option value="<?php echo $customer_files[$i]['of_id']; ?>;2;" <?php echo ($customer_files[$i]['of_kind']==2)?"selected":"";?>>Outview-Photo</option>
			</select>
			<script type="text/javascript">
			$('#change_note<?php echo $i;?>').change(function(){
				$.ajax({
				url: "<?php echo $base_url;?>ajax/change_customer_file.php",
				method: "get",
				data: {change_note:$(this).val(),option:"change_note"},
				dataType:"html",
				success:function(data) {
					console.log(data);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				}
				});

			});
			</script>
			<?php
				if(strpos($customer_files[$i]['of_internal_name_dom'],'pdfid_')!==false)
				{
					?>
					<div class="row">
						<div class="col-md-12 text-center">
							<?php
							// $filename_array=explode('.jpg',$customer_files[$i]['of_name_client']);

							// $filename_array[0]=str_replace('_LB_','(',$filename_array[0]);
							// $filename_array[0]=str_replace('_RB_',')',$filename_array[0]);
							// $filename_array[0]=str_replace('_',' ',$filename_array[0]);

							$pdf_array=explode('pdfid_',$customer_files[$i]['of_internal_name_dom']);
							$pdf_id_array=explode('_',$pdf_array[1]);
							//echo $pdf_array[1];

							$pdf_first_part_array=explode('.pdf',$pdf_array[1]);

							//echo $pdf_first_part_array[0];
							$pdf_file=$prod->get_customer_pdf_file($customer_files[$i]['o_id'],$pdf_first_part_array[0].".pdf");
							?>
							<a href="<?php
							//if(!empty($pdf_id_array))
							if(!empty($pdf_file))
							{
							?>
							../image.php?filecategory=customerfiles&imageid=<?php //echo $pdf_id_array[0];
							echo $pdf_file['of_id'];
							}
							else
							{
								echo "#";
							}?>" target="_blank">
								<img src="<?php echo $base_url;?>img/adobe-pdf-icon.png" alt="<?php echo $customer_files[$i]['of_name_client'];?>" style="width:60px;">
							</a>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<div class="col-md-2 border-right border-dark py-3">
				<input type="text" placeholder="Title Intern" class="form-control form-control-sm" list="predefined_subtitles<?php echo $i;?>" id="of_subtitle<?php echo $i;?>" name="of_subtitle<?php echo $i;?>" data-of_id="<?php echo $customer_files[$i]['of_id'];?>" value="<?php echo $customer_files[$i]['of_subtitle'];?>">

				<datalist id="predefined_subtitles<?php echo $i;?>">
					<option value="floorplan-l-1">
					<option value="floorplan-l00">
					<option value="floorplan-l01">
					<option value="floorplan-l02">
					<option value="floorplans-all">
					<option value="map-area">
					<option value="map-plot">
					<option value="photo">
					<option value="section-1-1">
					<option value="section-2-2">
					<option value="section-3-3">
					<option value="section-4-4">
					<option value="view-1-1">
					<option value="view-2-2">
					<option value="view-3-3">
					<option value="view-4-4">
				</datalist>

				<script type="text/javascript">
					$('#of_subtitle<?php echo $i;?>').on('focusout',function(){

						let of_id=$(this).data('of_id');
						let title_intern=$(this).val();

						$.ajax({

						url: "<?php echo $base_url;?>ajax/update_customer_files_title_intern.php",
						method: "post",
						data: {of_id:of_id,title_intern:title_intern},
						dataType:"html",
						success:function(data) {
							console.log(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(thrownError);
						}
						});

					});
				</script>
			</div>
			<?php
			}
			?>
			<!-- <div class="col-md-6 px-0">
				<div class="row mx-0 w-100"> -->
					<div class="col-md-2 border-right border-dark py-3" style="max-width: 8vw;">
						<?php
						if(isset($_COOKIE['client_id']))
						{
							?>
						<input type="hidden" name="of_name" id="of_name<?php echo $i;?>" data-of_id="<?php echo $customer_files[$i]['of_id'];?>" class="form-control form-control-sm d-inline" value="<?php echo $customer_files[$i]['of_name'];?>">
						<button id="assign_btn<?php echo $i;?>" class="btn btn-sm btn-primary">Assign to subIDs</button>
						<div class="row" style="width: fit-content; margin: auto;">
							<div class="col-md-12 text-center">
								<div id="selected_sub_ids<?php echo $customer_files[$i]['of_id'];?>">
						<?php
						$all_subids=$prod->get_all_subids_by_o_id($o_id);

						for($a=0;$a<count($all_subids);$a++)
						{


							if (strpos($all_subids[$a]['cf_id'], $customer_files[$i]['of_id']) !== false)
							{
								echo $all_subids[$a]['o_sub_id'].", ";
							}


						}
						?>
							</div>
							</div>
						</div>
						<script type="text/javascript">
						$("#assign_btn<?php echo $i;?>").click(function(){

						$.ajax({
							url: "<?php echo $base_url;?>ajax/get_assigned_subids_html.php",
							method: "get",
							data: {
								of_id:$("#of_name<?php echo $i;?>").data('of_id'),
								o_id:<?php echo $o_id;?>
							},
							dataType:"html",
							success:function(data) {

								$('.assign-file-modal-body').html(data);

								$('#subidModal').modal('show');
							},
							error: function (xhr, ajaxOptions, thrownError) {
								console.log(xhr.status);
								console.log(thrownError);
							}
							});

						});
						</script>
					</div>
					<div class="col-md-1 border-right border-dark py-3">
					<select id="change_level<?php echo $i;?>" name="change_level" class="form-control form-control-sm" style="width:5em;">
							<option value="<?php echo $customer_files[$i]['of_id']; ?>;??? unknown;">??? unknown</option>
							<?php
							for($z=-4;$z<0;$z++)
							{
								?>
							<option value="<?php echo $customer_files[$i]['of_id']; ?>;<?php echo "L ".$z;?>;" <?php echo ("L ".$z==$customer_files[$i]['of_level'])?"selected":"";?>><?php echo "L ".$z;?></option>
							<?php
							}
							?>
							<?php
							for($z=0;$z<10;$z++)
							{
								?>
							<option value="<?php echo $customer_files[$i]['of_id']; ?>;<?php echo "L 0".$z;?>;" <?php echo ("L 0".$z==$customer_files[$i]['of_level'])?"selected":"";?>><?php echo "L 0".$z;?></option>
							<?php
							}
							?>
							<?php
							for($z=10;$z<100;$z++)
							{
								?>
							<option value="<?php echo $customer_files[$i]['of_id']; ?>;<?php echo "L ".$z;?>;" <?php echo ("L ".$z==$customer_files[$i]['of_level'])?"selected":"";?>><?php echo "L ".$z;?></option>
							<?php
							}
							?>
					</select>
						<script type="text/javascript">
						$('#change_level<?php echo $i;?>').change(function(){
							$.ajax({
							url: "<?php echo $base_url;?>ajax/change_customer_file.php",
							method: "get",
							data: {change_level:$(this).val(),option:"change_level"},
							dataType:"html",
							success:function(data) {
								console.log(data);
							},
							error: function (xhr, ajaxOptions, thrownError) {
								console.log(xhr.status);
								console.log(thrownError);
							}
							});

						});
						</script>
					</div>

					<?php
					}
					?>
					<div class="col-md-1 py-3">
						<form name="deletecreatorfile<?php echo $customer_files[$i]['of_id'];?>" action="<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $o_id;
						if(isset($_GET['status']))
						{
							echo "&status=".$_GET['status'];
						}
						?>" method="post" class="form-inline">
							<a href="../image.php?filecategory=customerfiles&imageid=<?php echo $customer_files[$i]['of_id']; ?>" class="btn btn-primary btn-sm d-inline" target="_blank"><i class="fas fa-arrow-circle-down"></i></a>
							<?php
							// AI button for valid image types
							if(in_array($customer_files[$i]['of_type_dom'], array('jpeg','jpg','png','webp'))):
								$ai_image_url = $base_url . 'client_files/' . $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom'];
							?>
							<button type="button"
									class="btn btn-info btn-sm d-inline ai-url-trigger"
									data-image-url="<?php echo htmlspecialchars($ai_image_url); ?>"
									title="AI Image Generation">
								<i class="fas fa-magic"></i>
							</button>
							<?php endif; ?>
							<?php
							if(isset($_COOKIE['client_id']))
							{
							?>
							<input type="hidden" name="of_id" value="<?php echo $customer_files[$i]['of_id'];?>" >
							<button type="button" id="delete_btn<?php echo $customer_files[$i]['of_id']; ?>" name="delete_btn" class="btn btn-danger btn-sm d-inline" title="Delete this file"><i class="fas fa-trash"></i></button>
							<script type="text/javascript">
							$('#delete_btn<?php echo $customer_files[$i]['of_id']; ?>').click(function(){

								if(confirm('Are you sure you want to delete ?'))
								{
									$.ajax({
										url: "../ajax/delete_client_file.php",
										method: "post",
										data: {of_id:<?php echo $customer_files[$i]['of_id']; ?>},
										dataType:"html",
										success:function(data) {
											console.log(data);
										}
									}).done(function(){
										$('#client_file_row<?php echo $customer_files[$i]['of_id']; ?>').fadeOut(3000);
									});


								}
							});
							</script>
							<?php
							}
							?>
						</form>

					</div>


		</div>
		<?php
	} //end if
} //end for
?>
</div>

<!-- Modal -->
<div class="modal fade" id="subidModal" tabindex="-1" role="dialog" aria-labelledby="subidModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="subidModalLabel">Assign to subIDs</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body assign-file-modal-body">

      </div>
      <div class="modal-footer">
        <button id="subid_close_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<script type="text/javascript">
		$('#subid_close_btn').click(function(){

			let o_id=<?php echo $o_id;?>;
			let cf_id=$('#this_of_id').val();

		$.ajax({
            url: "<?php echo $base_url;?>ajax/get_existing_assigned_osub_ids_html.php",
            method: "get",
            data: {
                o_id: o_id,
                of_id:cf_id
                },
            dataType:"html",
            success:function(data) {
                $('#selected_sub_ids'+cf_id).html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }

            });

			});
		</script>
      </div>
    </div>
  </div>
</div>
<div id="grey-background" style="background-color: #c4c4c4;">
<script type="text/javascript">

setTimeout(function() {
	let selectedPanoramaDiv = document.getElementById("panorama");
	let overlay = document.getElementById("fullscreen-overlay");

	// Select all elements with the class 'popup-trigger'
	var popupTriggers = document.querySelectorAll('img.img-responsive');
	// var popupTriggers = document.querySelectorAll('img:not(#fullscreen-image):not(.configurator_pictures)');
	// popupTriggers = document.querySelectorAll('img:not(#fullscreen-image):not(.door_shapes)');
	console.log(popupTriggers);


	popupTriggers.forEach(function(popupTrigger) {
		var popup = createPopup(popupTrigger);
		var popupImage = popup.querySelector('.popup-image');

		console.log("test");
		console.log(popupTriggers[0])
		popupTrigger.addEventListener('mousemove', function(event) {

			var x = event.clientX;
			var y = event.clientY + window.scrollY; // Adjust for scroll position

			// Adjust position if the popup goes out of viewport horizontally
			if (x + popup.offsetWidth > window.innerWidth) {
				x = window.innerWidth - popup.offsetWidth;
			}
			// Adjust position if the popup goes out of viewport vertically, considering scroll position
			if (y + popup.offsetHeight > window.innerHeight + window.scrollY) {
				y = window.innerHeight + window.scrollY - popup.offsetHeight;
			}


			popup.style.display = 'flex';
			popup.style.left = '50%';
			popup.style.transform = 'translateX(-50%)';
			popup.style.top = y + 'px';

			let imageDiv = document.getElementsByClassName("popup-image");

			imageDiv[0].style.display = "block";
			popupImage.src = popupTrigger.src;
		});

		popupTrigger.addEventListener('mouseout', function() {
			popup.style.display = 'none';
		});
	});


	function createPopup(trigger) {
		console.log(trigger);
		var popup = document.createElement('div');
		popup.className = 'popup';
		popup.style.flexDirection = "column";
		popup.innerHTML = '<img style="width: 0;" src="your-image.jpg" class="popup-image">';

		// Append the popup element to the body element
		document.body.appendChild(popup);

		return popup;
	}
}, 3000);

</script>

<!-- AI Image Modal Iframe Overlay -->
<div id="aiModalOverlay" class="ai-modal-overlay" style="display: none;">
	<iframe id="aiModalIframe" src="" allow="clipboard-write"></iframe>
</div>

<style>
	.ai-modal-overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.5);
		z-index: 9999;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.ai-modal-overlay iframe {
		width: 100%;
		max-width: 1440px;
		height: 90vh;
		max-height: 800px;
		border: none;
		border-radius: 8px;
		box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
	}
</style>

<script type="text/javascript">
(function() {
	'use strict';

	// AI Modal handling for customer files
	const aiModalOverlay = document.getElementById('aiModalOverlay');
	const aiModalIframe = document.getElementById('aiModalIframe');

	// Event delegation for AI buttons
	document.addEventListener('click', function(e) {
		const aiButton = e.target.closest('.ai-url-trigger');
		if (!aiButton) return;

		e.preventDefault();
		const imageUrl = aiButton.dataset.imageUrl;

		if (!imageUrl) {
			console.error('No image URL provided');
			return;
		}

		// Build iframe URL with o_id for Save to Task dropdowns
		const iframeUrl = '/studio/i_frames/ai_image_modal_url.php?image_url=' +
			encodeURIComponent(imageUrl) + '&o_id=<?php echo intval($o_id); ?>&token=customer_files';

		// Show overlay and load iframe
		aiModalIframe.src = iframeUrl;
		aiModalOverlay.style.display = 'flex';
	});

	// Close on overlay background click
	aiModalOverlay.addEventListener('click', function(e) {
		if (e.target === aiModalOverlay) {
			aiModalOverlay.style.display = 'none';
			aiModalIframe.src = '';
		}
	});

	// Listen for postMessage events from iframe
	window.addEventListener('message', function(event) {
		if (!event.data || event.data.type !== 'ai-modal-event') return;

		const { event: eventName, data } = event.data;

		switch (eventName) {
			case 'close':
				aiModalOverlay.style.display = 'none';
				aiModalIframe.src = '';
				break;

			case 'imageSaved':
				// Close modal and optionally refresh the page
				aiModalOverlay.style.display = 'none';
				aiModalIframe.src = '';
				// Optionally reload customer files section
				if (typeof get_customer_files === 'function') {
					setTimeout(get_customer_files, 500);
				}
				break;

			case 'error':
				console.error('AI Modal Error:', data.message);
				break;

			default:
				console.log('AI Modal Event:', eventName, data);
		}
	});

	// ESC key to close modal
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && aiModalOverlay.style.display !== 'none') {
			aiModalOverlay.style.display = 'none';
			aiModalIframe.src = '';
		}
	});
})();
</script>