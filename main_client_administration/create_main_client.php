<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");
$page_title="Main Client Administration - Create";
include('../header2.php');
include('../menu.php');
?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white px-0">

<?php
if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
{
	
	?>
    <p class="w-100 text-center display-4 pt-4">
        Create a new main client
    </p>
    <hr class="mb-4" width="450px">
	<?php 
	include('submenu.php');
	

	if(isset($_POST['save_profile_btn']))
	{
		
        
        $create_client_data['client_credibility']=$prod->xss_fix($_POST['client_credibility']);
		$create_client_data['clientname']=$_POST['clientname'];
		$create_client_data['a_id']=$prod->xss_fix($_POST['country']);
        $create_client_data['registration']=$prod->xss_fix($_POST['registration']);
        $create_client_data['supervisory_authority']=$prod->xss_fix($_POST['supervisory_authority']);
        $create_client_data['contact_at_client']=$prod->xss_fix($_POST['contact_at_client']);
		$create_client_data['leaders_name']=$prod->xss_fix($_POST['leaders_name']);
		$create_client_data['leaders_status']=$prod->xss_fix($_POST['leaders_status']);		
		$create_client_data['phone']=$prod->xss_fix($_POST['phone']);
		$create_client_data['email']=$prod->xss_fix($_POST['email']);
		$create_client_data['VAT_tax_no']=$prod->xss_fix($_POST['VAT_tax_no']);
		$create_client_data['iban']=$prod->xss_fix($_POST['iban']);
		$create_client_data['street']=$prod->xss_fix($_POST['street']);
		$create_client_data['no_or_housename']=$prod->xss_fix($_POST['no_or_housename']);
		$create_client_data['postcode']=$prod->xss_fix($_POST['postcode']);
		$create_client_data['city']=$prod->xss_fix($_POST['city']);
        $create_client_data['homepage']=$prod->xss_fix($_POST['homepage']);
        $create_client_data['remarks_internal']=$prod->xss_fix($_POST['remarks_internal']);
        $create_client_data['price_remarks']=$prod->xss_fix($_POST['price_remarks']);
		
		if((!empty($create_client_data['clientname']))&&(!empty($create_client_data['email'])))
		{
		
		$prod->create_main_client(json_encode($create_client_data));
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="text-center">
					<div class="alert alert-success">Settings saved successfully.</div>
				</div>
			</div>	
		</div>
		<meta http-equiv="refresh" content="2; url=index.php"> 
		<?php
		}		
	}
	   
	?>
	<div class="row">
        <div class="col-md-4">
        
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4 text-right">
            
        </div>
    </div>				
	<form name="settings_form" method="post" action="create_main_client.php" enctype="multipart/form-data">
		
        <div class="row w-100 mx-0 mt-4 border-top pt-4">
            <div class="col-md-6 pr-0">
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="clientname">Your enterprise/entity (name + legal category like Ltd./Inc./etc.)<div class="text-danger d-inline">*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="text" id="clientname" name="clientname" value="" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="leaders_name">Leader's Name<div class="text-danger d-inline">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="text" id="leaders_name" name="leaders_name" value="" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="leaders_status">Leader's Status</label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="text" id="leaders_status" name="leaders_status" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="contact_at_client">Contact at client</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="contact_at_client" name="contact_at_client" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="client_credibility">Client credibility</label>
                    </div>
                    <div class="col-md-5">
                        <select id="client_credibility" name="client_credibility" class="form-control form-control-sm">
                        <option value="0">0</option>
                        <?php
                        for($i=1;$i<10;$i++)
                        {
                            ?>
                            <option value="<?php echo $i;?>" <?php echo ($i==$main_client['client_credibility'])?"selected":""; ?>><?php echo $i;?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="remarks_internal">Remarks internal</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="remarks_internal" name="remarks_internal" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="country">Country<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                        <select id="country" name="country" class="form-control form-control-sm border-danger" required>
                        <option value="">-- Select --</option>
                        <?php
                        $areas=$prod->show_areas();

                        for($i=0;$i<count($areas);$i++)
                        {
                            if(($areas[$i]['a_id']==5)||($areas[$i]['a_id']==18)||($areas[$i]['a_id']==36)||($areas[$i]['a_id']==1)||($areas[$i]['a_id']==28)||($areas[$i]['a_id']==21)||($areas[$i]['a_id']==37)||($areas[$i]['a_id']==29))
                            {
                            ?>
                            <option value="<?php echo $areas[$i]['a_id'];?>"><?php echo $areas[$i]['area'];?></option>
                            <?php
                            }
                        }
                        ?>
                        <option value="">--------------------------------</option>
                        <?php
                        for($i=0;$i<count($areas);$i++)
                        {
                            if(($areas[$i]['a_id']!=5)&&($areas[$i]['a_id']!=18)&&($areas[$i]['a_id']!=36)&&($areas[$i]['a_id']!=1)&&($areas[$i]['a_id']!=28)&&($areas[$i]['a_id']!=21)&&($areas[$i]['a_id']!=37)&&($areas[$i]['a_id']!=29))
                            {
                            ?>					
                            <option value="<?php echo $areas[$i]['a_id'];?>"><?php echo $areas[$i]['area'];?></option>
                            <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                    <label for="registration">Registered as enterprise? <br>If: Place + no.</label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="registration" name="registration" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                    <label for="supervisory_authority">Supervisory authority</label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="supervisory_authority" name="supervisory_authority" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="VAT_tax_no">If in EU: VAT-ID <br>(if you have one)</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="VAT_tax_no" name="VAT_tax_no" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="price_remarks">Price remarks</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="price_remarks" name="price_remarks" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="iban">IBAN</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="iban" name="iban" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="street" style="padding-right:10px;">Street</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="street" name="street" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="no_or_housename">No. or housename</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="no_or_housename" name="no_or_housename" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="postcode">Postcode</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="postcode" name="postcode" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="city">City</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="city" name="city" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="homepage" style="padding-right:10px;">Homepage</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="homepage" name="homepage" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="phone">Your Phone no.</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="phone" name="phone" value="">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="email">Your E-mail address<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="email" id="email" name="email" value="" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-0">
                
            </div>	
		</div>			
		<div class="row w-100 mx-0">
			<div class="col-md-3 mx-auto">
				<div class="text-center">
					<button type="submit" name="save_profile_btn" class="btn btn-primary btn-sm btn-block mt-3">Save changes</button>			
				</div>
			</div>
		</div>
	</form>
	<br>
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
</article>
</section>
<?php
include('../footer.php');
?>