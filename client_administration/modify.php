<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Client Administration - Modify";

include('../header2.php');
include('../menu.php');
?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white px-0">

<?php
if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
{
	$clientid=$prod->xss_fix($_GET['clientid']);
	?>
    <p class="w-100 text-center display-4 pt-4">
        Modify client ID <?php echo $clientid; ?>
    </p>
    <hr class="mb-4" width="450px">
	<?php 
	include('submenu.php');
	

	if(isset($_POST['save_profile_btn']))
	{
		$update_client_data['client_id']=$prod->xss_fix($_POST['clientid']);
        $update_client_data['mc_id']=$prod->xss_fix($_POST['mc_id'] ?? '0');
        $update_client_data['lt_id']=$prod->xss_fix($_POST['lt_id'] ?? '0');
		$update_client_data['specials']=$prod->xss_fix($_POST['specials'] ?? '');
        $update_client_data['client_credibility']=$prod->xss_fix($_POST['client_credibility'] ?? '0');
        $update_client_data['referrer']=$prod->xss_fix($_POST['referrer'] ?? '0');
        $update_client_data['partner_since']=$prod->xss_fix($_POST['partner_since'] ?? '0000-00-00');
		$update_client_data['ls_ids']=$prod->xss_fix($_POST['ls_ids'] ?? '');
		$update_client_data['clientname']=$_POST['clientname'] ?? '';
		$update_client_data['country']=$prod->xss_fix($_POST['country'] ?? '0');
        $update_client_data['registration']=$prod->xss_fix($_POST['registration'] ?? '');
        $update_client_data['supervisors']=$prod->xss_fix($_POST['supervisors'] ?? '');
		$update_client_data['l_title']=$prod->xss_fix($_POST['l_title'] ?? "");
		$update_client_data['l_first_name']=$prod->xss_fix($_POST['l_first_name'] ?? '');
		$update_client_data['l_middle_name']=$prod->xss_fix($_POST['l_middle_name'] ?? '');
		$update_client_data['l_last_name']=$prod->xss_fix($_POST['l_last_name'] ?? '');
		$update_client_data['l_gender']=$prod->xss_fix($_POST['l_gender'] ?? '');
		$update_client_data['leaders_status']=$prod->xss_fix($_POST['leaders_status'] ?? '');
        $update_client_data['contact_status']=$prod->xss_fix($_POST['contact_status'] ?? '');
		$update_client_data['c_title']=$prod->xss_fix($_POST['c_title'] ?? '');
		$update_client_data['c_first_name']=$prod->xss_fix($_POST['c_first_name'] ?? '');
		$update_client_data['c_middle_name']=$prod->xss_fix($_POST['c_middle_name'] ?? '');
		$update_client_data['c_last_name']=$prod->xss_fix($_POST['c_last_name'] ?? '');
		$update_client_data['c_gender']=$prod->xss_fix($_POST['c_gender'] ?? '');
		$update_client_data['phone']=$prod->xss_fix($_POST['phone'] ?? '');
		$update_client_data['email']=$prod->xss_fix($_POST['email'] ?? '');
        $update_client_data['additional_emails']=$prod->xss_fix($_POST['additional_emails'] ?? '');
		$update_client_data['VAT_tax_no']=$prod->xss_fix($_POST['VAT_tax_no'] ?? '');
		$update_client_data['iban']=$prod->xss_fix($_POST['iban'] ?? '');
		$update_client_data['street']=$prod->xss_fix($_POST['street'] ?? '');
		$update_client_data['no_or_housename']=$prod->xss_fix($_POST['no_or_housename'] ?? '');
		$update_client_data['postcode']=$prod->xss_fix($_POST['postcode'] ?? '');
		$update_client_data['city']=$prod->xss_fix($_POST['city'] ?? '');
        $update_client_data['homepage']=$prod->xss_fix($_POST['homepage'] ?? '');
        $update_client_data['client_price_remarks']=$prod->xss_fix($_POST['client_price_remarks'] ?? '');
        $update_client_data['remarks_internal']=$prod->xss_fix($_POST['remarks_internal'] ?? '');
        $update_client_data['see_all_orders']=$prod->xss_fix($_POST['see_all_orders'] ?? '0');
        $update_client_data['house_owner']=$prod->xss_fix($_POST['house_owner'] ?? '0');
        $update_client_data['public_presentation']=$prod->xss_fix($_POST['public_presentation'] ?? '0');
		$update_client_data['c_status']=$prod->xss_fix($_POST['c_status'] ?? '');
		
		if((!empty($update_client_data['clientname']))&&(!empty($update_client_data['email'])))
		{
            if(!empty($_FILES['profile_picture_path']))
            {
                $profile_picture_files_dir = "../client_profile_picture_files/";

                $validextensions = array("jpg", "jpeg", "png");

                $output_dir = $profile_picture_files_dir . $update_client_data['client_id'];

                if (!file_exists($output_dir)) 
                {
                    mkdir($output_dir, 0755, true);
                }

                $original_file_name = $_FILES["profile_picture_path"]["name"];

                $tempfile = explode(".", $original_file_name);
                $file_extension = strtolower(end($tempfile));

                if (in_array($file_extension, $validextensions)) 
                {
                    $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

                    move_uploaded_file($_FILES["profile_picture_path"]["tmp_name"], $output_dir . "/" . $internal_file_name);

                    $profile_picture_link="client_profile_picture_files/".$update_client_data['client_id']."/".$internal_file_name;

                    $prod->update_client_profile_picture($update_client_data['client_id'],$profile_picture_link);
                }
            }

		$prod->update_client2(json_encode($update_client_data));
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="text-center">
					<div class="alert alert-success">Settings updated successfully.</div>
				</div>
			</div>	
		</div>
		<meta http-equiv="refresh" content="2; url=modify.php?clientid=<?php echo $update_client_data['client_id'];?>"> 
		<?php
		}		
	}
	
	
    $client=$prod->get_client($clientid);
   
	?>
	<div class="row">
        <div class="col-md-4">
        
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4 text-right">
            
        </div>
    </div>				
	<form name="settings_form" method="post" action="modify.php?clientid=<?php echo $clientid;?>" enctype="multipart/form-data">
		<input type="hidden" name="clientid" value="<?php echo $clientid;?>">
        <div class="row w-100 mx-0 mt-4 border-top pt-4">
            <div class="col-md-6 pr-0">
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="clientname">Your enterprise/entity (name + legal category like Ltd./Inc./etc.)<div class="text-danger d-inline">*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="text" id="clientname" name="clientname" value="<?php echo $client['clientname'];?>" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="mc_id">Main client<div class="text-danger d-inline">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                        <select id="mc_id" name="mc_id" class="form-control form-control-sm border-danger" required>
                        <option value="">-- Select --</option> 
                        <option value="0" <?php echo (0==$client['mc_id'])?"selected":""; ?>>Own client</option>
                        <?php
                        $mainclients=$prod->get_all_main_clients();

                        for($i=0;$i<count($mainclients);$i++)
                        {
                            ?>
                            <option value="<?php echo $mainclients[$i]['mc_id'];?>" <?php echo ($mainclients[$i]['mc_id']==$client['mc_id'])?"selected":""; ?>><?php echo "Sub of: ".$mainclients[$i]['clientname'];?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="lt_id">Licence taker (select only if it is a creator)</label>
                    </div>
                    <div class="col-md-5">
                        <select id="lt_id" name="lt_id" class="form-control form-control-sm border-success">
                        <option value="0">-- Select --</option>              
                        <?php
                        $licence_takers=$prod->show_all_licence_takers();
                            
                        for($i=0;$i<count($licence_takers);$i++)
                        {
                            ?>
                            <option value="<?php echo $licence_takers[$i]['lt_id'];?>" <?php echo ($client['lt_id']==$licence_takers[$i]['lt_id'])?"selected":"";?>><?php echo $licence_takers[$i]['Company'];?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="specials">Position</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="specials" name="specials" value="<?php echo $client['specials'];?>">
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
                            <option value="<?php echo $i;?>" <?php echo ($i==$client['client_credibility'])?"selected":""; ?>><?php echo $i;?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="referrer">Referrer</label>
                    </div>
                    <div class="col-md-5">
                        <select id="referrer" name="referrer" class="form-control form-control-sm">
                        <option value="0">None</option>
                        <?php
                        $referrers=$prod->get_all_active_clients();

                        for($i=0;$i<count($referrers);$i++)
                        {
                            ?>
                            <option value="<?php echo $referrers[$i]['client_ID'];?>" <?php echo ($referrers[$i]['client_ID']==$client['referrer_id'])?"selected":""; ?>><?php echo $referrers[$i]['c_last_name'].", ".$referrers[$i]['c_first_name'];?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="partner_since">Partner since</label>
                    </div>
                    <div class="col-md-5">
                        <input id="partner_since" name="partner_since" class="form-control form-control-sm" value="<?php echo $client['partner_since'] ?? '0000-00-00';?>">
                        <script type="text/javascript">
                        $('#partner_since').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd"
                        });
                        </script>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="specials">Website</label><div class="text-danger" style="display:inline-flex;">&nbsp;*</div>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="text" id="ls_ids" name="ls_ids" value="<?php echo $client['ls_ids'];?>" required>
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
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$client['a_id'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
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
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$client['a_id'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
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
                    <input class="form-control form-control-sm" type="text" id="registration" name="registration" value="<?php echo $client['registration'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="VAT_tax_no">If in EU: VAT-ID <br>(if you have one)</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="VAT_tax_no" name="VAT_tax_no" value="<?php echo $client['vat_tax_no'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="iban">Supervisors</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="supervisors" name="supervisors" value="<?php echo $client['supervisors'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="iban">IBAN</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="iban" name="iban" value="<?php echo $client['iban'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="street" style="padding-right:10px;">Street</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="street" name="street" value="<?php echo $client['street'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="no_or_housename">No. or housename</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="no_or_housename" name="no_or_housename" value="<?php echo $client['no_or_housename'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="postcode">Postcode</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="postcode" name="postcode" value="<?php echo $client['postcode'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="city">City</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="city" name="city" value="<?php echo $client['city'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="homepage" style="padding-right:10px;">Homepage</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="homepage" name="homepage" value="<?php echo $client['homepage'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="phone">Your Phone no.</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="phone" name="phone" value="<?php echo $client['phone'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="email">Your E-mail address<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="email" id="email" name="email" value="<?php echo $client['email'];?>" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="additional_emails">Additional E-mail address(es)</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="additional_emails" name="additional_emails" placeholder="Separated by comma !" value="<?php echo $client['additional_emails'];?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-0">
            <?php /*<div class="row w-100 mx-0">
                    <div class="col-md-12">
                        <label>Your main representative's name</label>
                    </div>
                </div>	
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="l_title">Title</label>
                    </div>
                    <div class="col-md-5">
                        <select id="l_title" name="l_title" class="form-control form-control-sm">
                        <option value="">-- Select --</option>
                        <option value="Dr" <?php echo ($client['l_title']=="Dr")?"selected":""; ?>>Dr</option>
                        <option value="Miss" <?php echo ($client['l_title']=="Miss")?"selected":""; ?>>Miss</option>
                        <option value="Mr" <?php echo ($client['l_title']=="Mr")?"selected":""; ?>>Mr</option>
                        <option value="Mrs" <?php echo ($client['l_title']=="Mrs")?"selected":""; ?>>Mrs</option>
                        <option value="Ms" <?php echo ($client['l_title']=="Ms")?"selected":""; ?>>Ms</option>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="l_first_name">First name<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="text" id="l_first_name" name="l_first_name" value="<?php echo $client['l_first_name'];?>" required>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="l_middle_name">Middle name</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="l_middle_name" name="l_middle_name" value="<?php echo $client['l_middle_name'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="l_last_name">Last name<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm border-danger" type="text" id="l_last_name" name="l_last_name" value="<?php echo $client['l_last_name'];?>" required>
                    </div>
                </div>	
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="l_gender">Gender</label>
                    </div>
                    <div class="col-md-5">
                        <select id="l_gender" name="l_gender" class="form-control form-control-sm">
                        <option>-- Select --</option>
                        <option <?php echo ($client['l_gender']=="Male")?"selected":""; ?>>Male</option>
                        <option <?php echo ($client['l_gender']=="Female")?"selected":""; ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="leaders_status">Status (e.g. president, <br>director, administrator, etc.)</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="leaders_status" name="leaders_status" value="<?php echo $client['leaders_status'];?>">
                    </div>
                </div> */ ?>
                <div class="row w-100 mx-0">
                    <div class="col-md-12">
                        <label>Who is our main contact person / who exactly are you?</label>
                    </div>	
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="c_title">Title</label>
                    </div>
                    <div class="col-md-5">
                        <select id="c_title" name="c_title" class="form-control form-control-sm">
                        <option value="">-- Select --</option>
                        <option value="Dr" <?php echo ($client['c_title']=="Dr")?"selected":""; ?>>Dr</option>
                        <option value="Miss" <?php echo ($client['c_title']=="Miss")?"selected":""; ?>>Miss</option>
                        <option value="Mr" <?php echo ($client['c_title']=="Mr")?"selected":""; ?>>Mr</option>
                        <option value="Mrs" <?php echo ($client['c_title']=="Mrs")?"selected":""; ?>>Mrs</option>
                        <option value="Ms" <?php echo ($client['c_title']=="Ms")?"selected":""; ?>>Ms</option>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="c_first_name">First name</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="c_first_name" name="c_first_name" value="<?php echo $client['c_first_name'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="c_middle_name">Middle name</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="c_middle_name" name="c_middle_name" value="<?php echo $client['c_middle_name'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="c_last_name">Last name</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="c_last_name" name="c_last_name" value="<?php echo $client['c_last_name'];?>">
                    </div>
                </div>
                
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="c_gender">Gender</label>
                    </div>
                    <div class="col-md-5">
                        <select id="c_gender" name="c_gender" class="form-control form-control-sm">
                        <option>-- Select --</option>
                        <option <?php echo ($client['c_gender']=="Male")?"selected":""; ?>>Male</option>
                        <option <?php echo ($client['c_gender']=="Female")?"selected":""; ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="contact_status">Contact Status</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="contact_status" name="contact_status" value="<?php echo $client['contact_status'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="remarks_internal">Remarks internal</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" id="remarks_internal" name="remarks_internal" value="<?php echo $client['remarks_internal'];?>">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <label for="profile_picture">Profile picture</label>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control form-control-sm" type="text" value="<?php echo $client['profile_picture_path'];?>" disabled>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-5">
                        <img id="profile_picture_img" src="<?php echo $base_url.$client['profile_picture_path'];?>" alt="profile_picture" style="width:100px;height:auto;">
                        <button id="delete_profile_picture_btn" data-client_id="<?php echo $client['client_ID'];?>" type="button" class="btn btn-sm btn-danger">X</button>
                        <script type="text/javascript">
                            $('#delete_profile_picture_btn').click(function(){
                                if(confirm('Are you sure you want to delete the profile picture ?'))
                                {
                                    let client_id=$(this).data('client_id');

                                    $.ajax({
                                        url: "../ajax/delete_client_profile_picture.php",
                                        method: "post",
                                        data: {client_id:client_id},
                                        dataType:"html",
                                        success:function(data) {
                                            $('#profile_picture_img').fadeOut(3000);
                                        }
                                    });

                                }
                            });
                        </script>
                    </div>
                    <div class="col-md-5">
                        <input type="file" class="form-control form-control-sm" id="profile_picture_path" name="profile_picture_path">
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-12">
                        <hr class="border-bottom border-dark">
                    </div>
                </div>
                
                <div class="row w-100 mx-0 <?php echo ($client['c_status']=="active")?"light-green":"light-grey";?>">
                    <div class="col-md-5">
                        <label for="c_status">Client Status</label>
                    </div>
                    <div class="col-md-5">
                        <select id="c_status" name="c_status" class="form-control form-control-sm">
                        <option>-- Select --</option>
                        <option <?php echo ($client['c_status']=="active")?"selected":""; ?>>active</option>
                        <option <?php echo ($client['c_status']=="inactive")?"selected":""; ?>>inactive</option>
                        </select>
                    </div>
                </div>
                <div class="row w-100 mx-0 colorline">
                    <div class="col-md-12">
                        <input class="form-control form-control-sm" type="checkbox" id="see_all_orders" name="see_all_orders" value="1" <?php echo ($client['see_all_orders']==1)?"checked":"";?>>
                        <label for="see_all_orders">Administrator 4 his organization?</label>
                    </div>
                    <!-- <div class="col-md-auto p-0 m-0">
                        
                    </div> -->
                    
                </div>
                
                <div class="row w-100 mx-0 colorline">
                    <div class="col-md-2">
                        <input class="form-control form-control-sm" type="checkbox" id="house_owner" name="house_owner" value="1" <?php echo ($client['house_owner']==1)?"checked":"";?>>
                    </div>
                    <div class="col-md-5 p-0 m-0">
                        <label for="house_owner">Planset owner ?</label>
                    </div>
                    
                </div>
                
                <div class="row w-100 mx-0 colorline">
                    <div class="col-md-2">          
                    <input class="form-control form-control-sm" type="checkbox" id="public_presentation" name="public_presentation" value="1" <?php echo ($client['public_presentation']==1)?"checked":"";?>>
                    </div>   
                    <div class="col-md-auto p-0 m-0">          
                    Presentation public by default?
                    </div>
                                    
                </div>
                <div class="row w-100 mx-0 colorline">
                    <div class="col-md-2">          
                    <input class="form-control form-control-sm" type="checkbox" id="checkation_access" name="checkation_access" value="1" <?php echo ($client['checkation_access']==1)?"checked":"";?>>
                    </div> 
                    <div class="col-md-auto p-0 m-0">          
                    Access to checkation ?
                    </div>
                                      
                </div>
                
                <?php
                if($client['see_all_orders']==1)
                {
                ?>
                <div class="row w-100 mx-0 mt-2">
                    <div class="col-md-5 pl-4">
                    <a href="client_order_rights.php?clientid=<?php echo $clientid;?>" class="btn btn-sm btn-warning">Modify order rights 4 his organization</a>
                    </div>
                </div>
                <?php
                }
                ?>                
                <div class="row w-100 mx-0">
                    <div class="col-md-12 pl-4">
                        Price remarks
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-12">
                        <textarea class="form-control form-control-sm" id="client_price_remarks" name="client_price_remarks" style="height: 115px;"><?php echo $client['client_price_remarks']?></textarea>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-md-12">
                        <hr class="border-bottom border-dark">
                    </div>
                </div>
                <?php
                $client_rights=$prod->get_client_rights($client['client_ID']);
                ?>
                <div id="creator_status_row" class="row w-100 mx-0 <?php echo ($client_rights['u_status']=="active")?"light-green":"light-grey";?>">
                    <div class="col-md-5">
                        <label for="c_status">Creator Status</label>
                    </div>
                    <div class="col-md-5">
                        <select id="u_status" name="u_status" class="form-control form-control-sm">
                            <option>-- Select --</option>
                            <option <?php echo ($client_rights['u_status']=="active")?"selected":""; ?>>active</option>
                            <option <?php echo ($client_rights['u_status']=="inactive")?"selected":""; ?>>inactive</option>
                        </select>
                    </div>
                </div>
                <div id="permissions_row" class="row w-100 mx-0 <?php echo ($client_rights['u_status']=="active")?"":"d-none";?>">
                    <div class="col-md-5">          
                    </div>
                    <div class="col-md-5">
                        <div id="permission_btn"><a href="permissions.php?client_id=<?php echo $clientid;?>" class="btn btn-sm btn-danger">Grant creator permissions</a></div>
                    </div>   
                </div>     
                <script type="text/javascript">
                $("#c_status").on("change",function()
                {
                    if($(this).val()=="active")
                    {
                        $(this).parent().parent().removeClass('light-grey').addClass("light-green");
                       
                    }
                    else
                    {
                        $(this).parent().parent().removeClass('light-green').addClass("light-grey");                   
                    }
                });

                $('#u_status').on("change",function()
                {
                    if($(this).val()=="active")
                    {
                        $(this).parent().parent().removeClass('light-grey').addClass("light-green");
                        $('#permissions_row').removeClass('d-none');
                        $.ajax({
                            url: "../ajax/update_client_rights_status.php",
                            method: "post",
                            data: {client_id:<?php echo $client['client_ID'];?>,u_status:$(this).val()},
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
                        $(this).parent().parent().removeClass('light-green').addClass("light-grey");
                        $('#permissions_row').addClass('d-none');
                        $.ajax({
                            url: "../ajax/update_client_rights_status.php",
                            method: "post",
                            data: {client_id:<?php echo $client['client_ID'];?>,u_status:$(this).val()},
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
		<div class="row w-100 mx-0">
			<div class="col-md-3 mx-auto">
				<div class="text-center">
					<button type="submit" name="save_profile_btn" class="btn btn-primary btn-sm btn-block mt-3">Save changes</button>			
				</div>
			</div>
		</div>
	</form>
	<br>
	<hr>
	<br>
	<?php 
	if(isset($_POST['save_password_btn']))
	{
		$client_id=$prod->xss_fix($_POST['clientid']);
		
		$new_password=$_POST['new_password'];
		$new_password2=$_POST['new_password2'];

		//$check_existing_password=$prod->get_client($client_id);

		
			if($new_password!=$new_password2)
			{
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<div class="alert alert-danger">
								The new passwords do not match.<br>
								The password was not changed.
							</div>	
						</div>
					</div>
				</div>	
				<?php
			}
			elseif(strlen($new_password)<8)
			{
			?>
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<div class="alert alert-danger">
								The new password is too short.<br>
								The password should be more than 8 characters long.
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			else
			{
				$prod->update_client_password($client_id,$new_password);
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<div class="alert alert-success">
								Password successfully changed.
							</div>
						</div>	
					</div>
				</div>
				<?php
			}
	}
	?>
	<a name="change_password"></a>
	<div class="container pb-5">
		<div class="col-md-6 border mx-auto d-flex justify-content-center py-4">
            <form name="change_password_form" method="post" action="modify.php?clientid=<?php echo $clientid;?>#change_password" enctype="multipart/form-data">
                <input type="hidden" name="clientid" value="<?php echo $clientid; ?>">
                    <div class="row w-100 mx-0">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input class="form-control form-control-sm" type="password" id="new_password" name="new_password" required>
                        </div>
                    </div>
                    <div class="row w-100 mx-0">
                        <div class="form-group">
                            <label for="new_password2">Confirm new password</label>
                            <input class="form-control form-control-sm" type="password" id="new_password2" name="new_password2" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="save_password_btn" class="btn btn-primary btn-sm btn-block">Save changes</button>
                    </div>
            </form>
        </div>
	</div>				
	
	<br>
	<div id="choose_ls_ids" title="Choose websites">
	<?php 
	$ls_ids=$prod->get_all_websites();
	
	for($i=0;$i<count($ls_ids);$i++)
	{
	?>
	<div class="row">
		<input type="checkbox" id="site<?php echo $i;?>" name="site<?php echo $i;?>" class="sites" value="<?php echo $ls_ids[$i]['ls_id'];?>" <?php echo (strpos($client['ls_ids'],$ls_ids[$i]['ls_id'].";")!==false)?"checked":""?>>
		<label for="site<?php echo $i;?>"><?php echo $ls_ids[$i]['ls_name'];?></label>
	</div>
	<?php
	}
	?>
    </div>
<script type="text/javascript">
$('#ls_ids').focusin(function(){
	$(this).attr("readonly","readonly");
});

$('#ls_ids').focusout(function(){
	$(this).removeAttr("readonly");
});

$( "#choose_ls_ids" ).dialog({
	autoOpen: false, 
	modal: true,
	buttons: [
	{
		text: "OK",
		click: function() {
			var all_sites=$('.sites').length;
			
			var site="";
			
			for(var i=0;i<all_sites;i++)
			{
				if($('#site'+i).is(":checked"))
				{
					site +=$('#site'+i).val()+";";
				}
				
			}
			console.log(site);
			$('#ls_ids').val(site);
			$(this).dialog("close");
		},
		type: "button"
		/*form: "dialog_form_<?php //echo $row['o_id']; ?>"*/
	},
	{
		text:"Cancel",
		click: function() {$(this).dialog("close");}
	},
	]
	});
	$( "#ls_ids" ).click(function() {
	$( "#choose_ls_ids" ).dialog( "open" );
});
</script>
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