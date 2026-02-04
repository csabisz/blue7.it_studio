<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");
$page_title="Main Client Administration - Modify";
include('../header2.php');
include('../menu.php');
?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white px-0">

<?php
if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
{
	$mc_id=$prod->xss_fix($_GET['mc_id']);
	?>
    <p class="w-100 text-center display-4 pt-4">
        Modify main client ID <?php echo $mc_id; ?>
    </p>
    <hr class="mb-4" width="450px">
	<?php 
	include('submenu.php');
	

	if(isset($_POST['save_profile_btn']))
	{
		
        $update_client_data['mc_id']=$prod->xss_fix($_POST['mc_id']);		
        $update_client_data['client_credibility']=$prod->xss_fix($_POST['client_credibility']);
        $update_client_data['price_request_at_superior']=$prod->xss_fix($_POST['price_request_at_superior'] ?? 0) ;
		$update_client_data['clientname']=$_POST['clientname'];
		$update_client_data['a_id']=$prod->xss_fix($_POST['country']);
        $update_client_data['registration']=$prod->xss_fix($_POST['registration']);
        $update_client_data['supervisory_authority']=$prod->xss_fix($_POST['supervisory_authority']);
        $update_client_data['contact_at_client']=$prod->xss_fix($_POST['contact_at_client']);
		$update_client_data['leaders_name']=$prod->xss_fix($_POST['leaders_name']);
		$update_client_data['leaders_status']=$prod->xss_fix($_POST['leaders_status']);		
		$update_client_data['phone']=$prod->xss_fix($_POST['phone']);
		$update_client_data['email']=$prod->xss_fix($_POST['email']);
		$update_client_data['VAT_tax_no']=$prod->xss_fix($_POST['VAT_tax_no']);
        $update_client_data['tax_number']=$prod->xss_fix($_POST['tax_number']);
		$update_client_data['iban']=$prod->xss_fix($_POST['iban']);
		$update_client_data['street']=$prod->xss_fix($_POST['street']);
		$update_client_data['no_or_housename']=$prod->xss_fix($_POST['no_or_housename']);
		$update_client_data['postcode']=$prod->xss_fix($_POST['postcode']);
		$update_client_data['city']=$prod->xss_fix($_POST['city']);
        $update_client_data['homepage']=$prod->xss_fix($_POST['homepage']);
        $update_client_data['remarks_internal']=$prod->xss_fix($_POST['remarks_internal']);
        $update_client_data['price_remarks']=$prod->xss_fix($_POST['price_remarks']);
		
		if((!empty($update_client_data['clientname']))&&(!empty($update_client_data['email'])))
		{
		
		$prod->update_main_client(json_encode($update_client_data));
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="text-center">
					<div class="alert alert-success">Settings updated successfully.</div>
				</div>
			</div>	
		</div>
		<meta http-equiv="refresh" content="2; url=index.php"> 
		<?php
		}		
	}
	
	
    $main_client=$prod->get_main_client($mc_id);
   
	?>
	<div class="row">
        <div class="col-md-4">
        
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4 text-right">
            
        </div>
    </div>				
	<form name="settings_form" method="post" action="modify_main_client.php?mc_id=<?php echo $mc_id;?>" enctype="multipart/form-data">
		<input type="hidden" name="mc_id" value="<?php echo $mc_id;?>">
        <div class="row w-100 mx-0 mt-4 border-top pt-4">
            <div class="col-md-6 pr-0">
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="clientname">Your enterprise/entity (name + legal category like Ltd./Inc./etc.)<div class="text-danger d-inline">*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="text" id="clientname" name="clientname" value="<?php echo $main_client['clientname'];?>" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="leaders_name">Leader's Name<div class="text-danger d-inline">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="text" id="leaders_name" name="leaders_name" value="<?php echo $main_client['leaders_name'];?>" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="leaders_status">Leader's Status</label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="text" id="leaders_status" name="leaders_status" value="<?php echo $main_client['leaders_status'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="contact_at_client">Contact at client</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="contact_at_client" name="contact_at_client" value="<?php echo $main_client['contact-at-client'];?>">
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
                        <label for="price_request_at_superior">Price request at superior ?</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="checkbox" id="price_request_at_superior" name="price_request_at_superior" value="1" <?php echo ($main_client['price_request_at_superior']==1)?"checked":"";?>>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="remarks_internal">Remarks internal</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="remarks_internal" name="remarks_internal" value="<?php echo $main_client['remarks_internal'];?>">
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
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$main_client['a_id'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
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
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$main_client['a_id'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
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
                    <input class="form-control form-control-sm" type="text" id="registration" name="registration" value="<?php echo $main_client['registration'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                    <label for="tax_number">Tax number</label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="tax_number" name="tax_number" value="<?php echo $main_client['tax_number'];?>">
                    </div>
                </div>                
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="VAT_tax_no">If in EU: VAT-ID <br>(if you have one)</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="VAT_tax_no" name="VAT_tax_no" value="<?php echo $main_client['vat-tax-no'];?>">
                    </div>
                </div>                
            </div> <!-- end col -->
            <div class="col-md-6 pl-0">
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                    <label for="supervisory_authority">Supervisory authority</label>
                    </div>
                    <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="supervisory_authority" name="supervisory_authority" value="<?php echo $main_client['supervisory_authority'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="iban">IBAN</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="iban" name="iban" value="<?php echo $main_client['iban'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="street" style="padding-right:10px;">Street</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="street" name="street" value="<?php echo $main_client['street'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="no_or_housename">No. or housename</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="no_or_housename" name="no_or_housename" value="<?php echo $main_client['no-or-housename'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="postcode">Postcode</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="postcode" name="postcode" value="<?php echo $main_client['postcode'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="city">City</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="city" name="city" value="<?php echo $main_client['city'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="homepage" style="padding-right:10px;">Homepage</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="homepage" name="homepage" value="<?php echo $main_client['homepage'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="phone">Your Phone no.</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="phone" name="phone" value="<?php echo $main_client['phone'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="email">Your E-mail address<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="email" id="email" name="email" value="<?php echo $main_client['email'];?>" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-12">
                        <label for="price_remarks">Price remarks</label>
                    </div>                    
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-12">
                        <textarea class="form-control form-control-sm" id="price_remarks" name="price_remarks" style="height:145px;"><?php echo $main_client['price_remarks'];?></textarea>
                    </div>
                </div>
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
    <script type="text/javascript">
        Cookies.remove("session_id");
        Cookies.remove("start");
        Cookies.remove("client_id");
        Cookies.remove("client");
        Cookies.remove("own_tasks");
        Cookies.remove("cdesign");
        Cookies.remove("change_vat");
        Cookies.remove("l_first_name");
        Cookies.remove("l_last_name");
        Cookies.remove("c_first_name");
        Cookies.remove("c_last_name");
        Cookies.remove("email");
        Cookies.remove("useradmin");
        Cookies.remove("programs_of_employees");
        Cookies.remove("contracting");
        Cookies.remove("bookkeeping");
        Cookies.remove("coordination");
        Cookies.remove("plansets");
        Cookies.remove("housesets");
        Cookies.remove("plots");
        Cookies.remove("view_all_orders");
        Cookies.remove("activity_view");
        Cookies.remove("apu_lists");
        Cookies.remove("examples_db");
        Cookies.remove("translations");
        Cookies.remove("company");
        Cookies.remove("lt_id");
        Cookies.remove("ip_address");
        Cookies.remove("user_agent");
        Cookies.remove("expire");
    </script>
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