<?php
session_start();
include('../../functions.php');

$prod=new Production;
$_SESSION['start']=gmdate("Y-m-d H:i:s");

include('../../header2.php');
include('../../menu.php');
// include('ajax/db.php');
?>
<section class="acceptance pt-5">
    <article>
        <div class="container pagecontent bg-white px-0">
            <?php
	if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire']))
	{									
		?>
            <!-- <h3 class="w-100 text-center display-5 pt-3">Clients colors Administration</h3> -->
            <hr class="mb-4" width="450px">
            <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
                <a href="index.php" class="btn btn-sm btn-warning mx-4 border">Clients Administration </a>
               
            </div>

            <div class="row">
                <div class="col-12">
                
                    <div class="table-responsive">
                        <br />
                        <div align="right">
                            <button type="button" id="create_button" data-toggle="modal" data-target="#colormodal"
                                class="btn btn-primary ">Create new color</button>
                        </div>
                        <br /><br />
                        <table id="client_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="">Client(id)</th>
                                    <th width="">Client Type</th>
                                    <th width="">Logo</th>
                                    <th width="">Text</th>
                                    <th width="">Hover</th>
                                    <th width="">link</th>
                                    <th width="">Picture Shadow</th>
                                    <th width="">Background</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead> 
                        </table>

                    </div>
                </div>
            </div>
            <?php		
	}
	else
	{
        session_unset();
        session_destroy();
	?>
            <div class="center_message">
                <div class="error">You must be logged in to view this page !</div>
                <a href="../../login.php" class="btn btn-danger btn-sm">Login</a>
                <br><br>
            </div>
            <meta http-equiv="refresh" content="3; url=../../login.php">
            <?php
	}
    ?>

        </div>
    </article>
</section>

 

<div id="colormodal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form method="post" id="client_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new color</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <label>Enter Client ID</label>
                    <input type="text" name="client_id" id="client_id" class="form-control" />
                    <br />
                    <label>Enter Text Color</label>
                    <input type="text" name="text_color" id="text_color" class="form-control" />
                    <label>Enter Hover Color</label>
                    <input type="text" name="hover_color" id="hover_color" class="form-control" />
                    <label>Enter Link Color</label>
                    <input type="text" name="link_color" id="link_color" class="form-control" />
                    <label>Enter Picture Shadow Color</label>
                    <input type="text" name="picture_shadow_color" id="picture_shadow_color" class="form-control" />
                    <label>Enter Background Color</label>
                    <input type="text" name="background_color" id="background_color" class="form-control" />
                    <label>Client Type</label>
                    <select name="category_id" class="form-control" id="categories_options_html">  
                        <option value="c">simple</option> 
                        <option value="mc">main client</option> 
                    </select> 
                    <br />
                    <label class="label-client-logo">Select Client logo</label>
                    <input type="file" name="client_image" id="client_image" />
                    <span id="client_uploaded_image"></span>
                </div>
                <div class="modal-footer">
                <input type="hidden" id="idhid" name="idhid">
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
 
<script type="text/javascript" language="javascript" >
$(document).ready(function(){
 $('#create_button').click(function(){
  $('#client_form')[0].reset();
  $('.modal-title').text("New Colorset");
  $('#action').val("Add");
  $('#operation').val("Add");
  $('#user_uploaded_image').html('');
 });
 
 var dataTable = $('#client_data').DataTable({
  "processing":true,
  "serverSide":true,
  "order":[],
  "ajax":{
   url:"fetch.php",
   type:"POST"
  },
  "columnDefs":[
   {
    "targets":[0,1,2,3],
    "orderable":false,
   },
  ],

 });

 $(document).on('submit', '#client_form', function(event){
  event.preventDefault();
  var client_id = $('#client_id').val();
  var color_1 = $('#text_color').val(); 
  if(client_id != '' && color_1 != '')
  {
   $.ajax({
    url:"insert.php",
    method:'POST',
    data:new FormData(this),
    contentType:false,
    processData:false,
    success:function(data)
    {
     alert(data);
     $('#client_form')[0].reset();
     $('#colormodal').modal('hide');
     dataTable.ajax.reload();
    }
   });
  }
  else
  {
   alert("Both Fields are Required");
  }
 });
 
 $(document).on('click', '.update', function(){
  var id = $(this).attr("id");
  $.ajax({
   url:"fetch_single.php",
   method:"POST",
   data:{id:id},
   dataType:"json",
   success:function(data)
   {  
    $('#colormodal').modal('show'); 
    $('.modal-title').text("Edit Colorset"); 
    $('.label-client-logo').text("Select new client logo");
    $('#client_id').val(data.client_id);
    $('#text_color').val(data.color_1);
    $('#hover_color').val(data.color_1a);
    $('#link_color').val(data.color_2);
    $('#picture_shadow_color').val(data.color_4);
    $('#background_color').val(data.color_5);
    $('#client_uploaded_image').html(data.client_image);
    $('#idhid').val(data.idhid);
    $('#categories_options_html').val(data.category);
    $('#action').val("Edit");
    $('#operation').val("Edit");
   }
  })
 });
 
 $(document).on('click', '.delete', function(){
  var user_id = $(this).attr("id");
  if(confirm("Are you sure you want to delete this?"))
  {
   $.ajax({
    url:"delete.php",
    method:"POST",
    data:{user_id:user_id},
    success:function(data)
    {
     alert(data);
     dataTable.ajax.reload();
    }
   });
  }
  else
  {
   return false; 
  }
 });
 
 
});
</script>