<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

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
        <p class="w-100 text-center display-4 pt-3">New customer registration</p>
        <hr class="mb-4" width="450px">
<?php 
	include('submenu.php');
	
	if(isset($_POST['register_btn']))
	{
		$register_data['clientname']=$prod->xss_fix($_POST['clientname']);
		$register_data['country']=$prod->xss_fix($_POST['country'] ?? "");
		$register_data['registration']=$prod->xss_fix($_POST['registration'] ?? "");
		$register_data['l_title']=$prod->xss_fix($_POST['l_title'] ?? "");
		if($register_data['l_title']=="-- Select --"){$register_data['l_title']="";}
		$register_data['l_first_name']=$prod->xss_fix($_POST['l_first_name'] ?? "");
		$register_data['l_middle_name']=$prod->xss_fix($_POST['l_middle_name'] ?? "");
		$register_data['l_last_name']=$prod->xss_fix($_POST['l_last_name'] ?? "");
		$register_data['l_gender']=$prod->xss_fix($_POST['l_gender'] ?? "");
		if($register_data['l_gender']=="-- Select --"){$register_data['l_gender']="";}
		$register_data['leaders_status']=$prod->xss_fix($_POST['leaders_status'] ?? "");
        $register_data['contact_status']=$prod->xss_fix($_POST['contact_status'] ?? "");
		$register_data['c_title']=$prod->xss_fix($_POST['c_title'] ?? "");
		if($register_data['c_title']=="-- Select --"){$register_data['c_title']="";}
		$register_data['c_first_name']=$prod->xss_fix($_POST['c_first_name'] ?? "");
		$register_data['c_middle_name']=$prod->xss_fix($_POST['c_middle_name'] ?? "");
		$register_data['c_last_name']=$prod->xss_fix($_POST['c_last_name'] ?? "");
		$register_data['c_gender']=$prod->xss_fix($_POST['c_gender'] ?? "");
		if($register_data['c_gender']=="-- Select --"){$register_data['c_gender']="";}
		$register_data['phone']=$prod->xss_fix($_POST['phone'] ?? "");
		$register_data['email']=$prod->xss_fix($_POST['email']);
        $register_data['additional_emails']=$prod->xss_fix($_POST['additional_emails'] ?? "");
		$register_data['VAT_tax_no']=$prod->xss_fix($_POST['VAT_tax_no'] ?? "");
		$register_data['iban']=$prod->xss_fix($_POST['iban'] ?? "");
		$register_data['street']=$prod->xss_fix($_POST['street'] ?? "");
		$register_data['no_or_housename']=$prod->xss_fix($_POST['no_or_housename'] ?? "");
		$register_data['postcode']=$prod->xss_fix($_POST['postcode'] ?? "");
		$register_data['city']=$prod->xss_fix($_POST['city'] ?? "");
		$register_data['password']=$prod->xss_fix($_POST['password'] );
		$register_data['password2']=$prod->xss_fix($_POST['password2'] );
		$register_data['homepage']=$prod->xss_fix($_POST['homepage'] ?? "");
		$register_data['mc_id']=$prod->xss_fix($_POST['mc_id'] ?? "0");
		$register_data['specials']=$prod->xss_fix($_POST['specials'] ?? "");
		$register_data['client_credibility']=$prod->xss_fix($_POST['client_credibility'] ?? "0");
		$register_data['ls_ids']=$prod->xss_fix($_POST['ls_ids'] ?? "");
		$register_data['date_registered']=gmdate("Y-m-d H:i:s");
		$register_data['timezone']=$prod->xss_fix($_POST['timezone'] ?? "");

		$_COOKIE['clientname']=$register_data['clientname'];
		$_COOKIE['country']=$register_data['country'];
		$_COOKIE['registration']=$register_data['registration'];
		$_COOKIE['l_title']=$register_data['l_title'];
		$_COOKIE['l_first_name']=$register_data['l_first_name'];
		$_COOKIE['l_middle_name']=$register_data['l_middle_name'];
		$_COOKIE['l_last_name']=$register_data['l_last_name'];
		$_COOKIE['l_gender']=$register_data['l_gender'];
		$_COOKIE['leaders_status']=$register_data['leaders_status'];
        $_COOKIE['contact_status']=$register_data['contact_status'];
		$_COOKIE['c_title']=$register_data['c_title'];
		$_COOKIE['c_first_name']=$register_data['c_first_name'];
		$_COOKIE['c_middle_name']=$register_data['c_middle_name'];
		$_COOKIE['c_last_name']=$register_data['c_last_name'];
		$_COOKIE['c_gender']=$register_data['c_gender'];
		$_COOKIE['phone']=$register_data['phone'];
		$_COOKIE['registered_email']=$register_data['email'];
        $_COOKIE['additionals_emails']=$register_data['additional_emails'];
		$_COOKIE['VAT_tax_no']=$register_data['VAT_tax_no'];
		$_COOKIE['iban']=$register_data['iban'];
		$_COOKIE['street']=$register_data['street'];
		$_COOKIE['no_or_housename']=$register_data['no_or_housename'];
		$_COOKIE['postcode']=$register_data['postcode'];
		$_COOKIE['city']=$register_data['city'];				
		$_COOKIE['homepage']=$register_data['homepage'];
		$_COOKIE['timezone']=$register_data['timezone'];

		$verify_existing_email=$prod->verify_existing_email($register_data['email']);

		if($verify_existing_email>0)
		{
			$verify_existing_email_error="<div class=\"row\">";
			$verify_existing_email_error.="<div class=\"col-md-12\">";
			$verify_existing_email_error.="<div class=\"error\">";
			$verify_existing_email_error.="E-mail address already exists in the database !<br>";
			$verify_existing_email_error.="If you have forgotten your password, you can recover it by clicking <a href=\"recover.php\">here.</a>";
			$verify_existing_email_error.="</div>";
			$verify_existing_email_error.="</div>";
			$verify_existing_email_error.="</div>";		
		}
		elseif($register_data['password']!=$register_data['password2'])
		{
			$password_error="<div class=\"row\">";
			$password_error.="<div class=\"col-md-12\">";
			$password_error.="<div class=\"error\">";
			$password_error.="Passwords do not match !";
			$password_error.="</div>";
			$password_error.="</div>";
			$password_error.="</div>";
		}
		elseif(strlen($register_data['password'])<8)
		{
			$password_error="<div class=\"row\">";
			$password_error.="<div class=\"col-md-12\">";
			$password_error.="<div class=\"error\">";
			$password_error.="The new password is too short.<br>";
			$password_error.="Password should be more than 8 characters long.";
			$password_error.="</div>";
			$password_error.="</div>";
			$password_error.="</div>";						
		}				
		elseif((!empty($register_data['clientname']))&&(!empty($register_data['email'])))
		{
			
            $prod->customer_register2(json_encode($register_data));
			$_COOKIE['clientname']="";
			$_COOKIE['country']="";
			$_COOKIE['registration']="";
			$_COOKIE['l_title']="";
			$_COOKIE['l_first_name']="";
			$_COOKIE['l_middle_name']="";
			$_COOKIE['l_last_name']="";
			$_COOKIE['l_gender']="";
			$_COOKIE['leaders_status']="";
            $_COOKIE['contact_status']="";
			$_COOKIE['c_title']="";
			$_COOKIE['c_first_name']="";
			$_COOKIE['c_middle_name']="";
			$_COOKIE['c_last_name']="";
			$_COOKIE['c_gender']="";
			$_COOKIE['phone']="";
			$_COOKIE['registered_email']="";
            $_COOKIE['additional_emails']="";
			$_COOKIE['VAT_tax_no']="";
			$_COOKIE['iban']="";
			$_COOKIE['street']="";
			$_COOKIE['no_or_housename']="";
			$_COOKIE['postcode']="";
			$_COOKIE['city']="";				
			$_COOKIE['homepage']="";
            $_COOKIE['timezone']="";
			?>
			<div class="text-center">
				<div class="alert alert-success">
					Registration successful !
				</div>	
			</div>
			<br>
			<meta http-equiv="refresh" content="2; url=index.php"> 
			<?php
		}				
	}
?>

<form name="register_form" method="post" action="create.php" enctype="multipart/form-data">
	<div class="row mx-0 w-100 my-2 border py-4">
        <div class="col-md-6 pr-0">
            <div class="row w-100 mx-0 mb-2">
                <div class="col-md-5">
                    <label for="clientname">Your enterprise / entity <br>(name + legal category like Ltd./ Inc. / etc.)<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-5 d-flex">
                    <input class="form-control form-control-sm align-self-center border-danger" type="text" id="clientname" name="clientname" value="<?php echo (isset($_COOKIE['clientname']))?$_COOKIE['clientname']:"";?>" required>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="mc_id">Main client<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-5">
                    <select id="mc_id" name="mc_id" class="form-control form-control-sm border-danger" required>
                    <option value="">-- Select --</option>
                    <option value="0">Main client</option>
                    <?php
                    $mainclients=$prod->get_all_main_clients();

                    for($i=0;$i<count($mainclients);$i++)
                    {
                        ?>
                        <option value="<?php echo $mainclients[$i]['mc_id'];?>"><?php echo $mainclients[$i]['clientname'];?></option>
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
                    <input class="form-control form-control-sm" type="text" id="specials" name="specials" value="">
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
                        <option value="<?php echo $i;?>" <?php echo ($i==9)?"selected":""; ?>><?php echo $i;?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="ls_ids">Website</label><div class="text-danger" style="display:inline-flex;">&nbsp;*</div>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="text" id="ls_ids" name="ls_ids" value="" required>
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
                            if(($areas[$i]['a_id']==5)||($areas[$i]['a_id']==18)||($areas[$i]['a_id']==36)||($areas[$i]['a_id']==1)||($areas[$i]['a_id']==28)||($areas[$i]['a_id']==37)||($areas[$i]['a_id']==29))
                            {
                            ?>
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$_COOKIE['country'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
                            <?php
                            }
                        }
                        ?>
                        <option value="">--------------------------------</option>
                        <?php
                        for($i=0;$i<count($areas);$i++)
                        {
                            if(($areas[$i]['a_id']!=5)&&($areas[$i]['a_id']!=18)&&($areas[$i]['a_id']!=36)&&($areas[$i]['a_id']!=1)&&($areas[$i]['a_id']!=28)&&($areas[$i]['a_id']!=37)&&($areas[$i]['a_id']!=29))
                            {
                            ?>
                            <option value="<?php echo $areas[$i]['a_id'];?>" <?php echo ($areas[$i]['a_id']==$_COOKIE['country'])?"selected":""; ?>><?php echo $areas[$i]['area'];?></option>
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
                    <input class="form-control form-control-sm" type="text" id="registration" name="registration" value="<?php echo (isset($_COOKIE['registration']))?$_COOKIE['registration']:"";?>">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="VAT_tax_no">If in EU: VAT-ID <br>(if you have one)</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="VAT_tax_no" name="VAT_tax_no" value="<?php echo (isset($_COOKIE['VAT_tax_no']))?$_COOKIE['VAT_tax_no']:"";?>">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="iban">IBAN</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="iban" name="iban" value="<?php echo (isset($_COOKIE['iban']))?$_COOKIE['iban']:"";?>">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="street" style="padding-right:10px;">Street name</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="street" name="street" value="<?php echo (isset($_COOKIE['street']))?$_COOKIE['street']:"";?>" >
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="no_or_housename">Street no. or housename</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="no_or_housename" name="no_or_housename" value="<?php echo (isset($_COOKIE['no_or_housename']))?$_COOKIE['no_or_housename']:"";?>" >
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="postcode">Postcode</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="postcode" name="postcode" value="<?php echo (isset($_COOKIE['postcode']))?$_COOKIE['postcode']:"";?>">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="city">City</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="city" name="city" value="<?php echo (isset($_COOKIE['city']))?$_COOKIE['city']:"";?>">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="homepage" style="padding-right:10px;">Homepage</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="homepage" name="homepage" value="<?php echo (isset($_COOKIE['homepage']))?$_COOKIE['homepage']:"";?>">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="phone">Your Phone no.</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="phone" name="phone" value="<?php echo (isset($_COOKIE['phone']))?$_COOKIE['phone']:"";?>">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="email">Your E-mail address<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="email" id="email" name="email" value="<?php echo (isset($_COOKIE['registered_email']))?$_COOKIE['registered_email']:"";?>" required>
                    
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="additional_emails">Additional E-mail address(es)</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="additional_emails" name="additional_emails" value="<?php echo (isset($_COOKIE['additional_emails']))?$_COOKIE['additional_emails']:"";?>">                    
                </div>
            </div>
            <?php 
            if(!empty($verify_existing_email_error))
            {
            echo $verify_existing_email_error;
            }
            ?>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="password">Password<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="password" id="password" name="password" required>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="password2">Confirm password<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="password" id="password2" name="password2" required>
                </div>
            </div>	
            <?php
            if(!empty($password_error))
            {
            echo $password_error;
            }
            ?>									
        </div>
        <div class="col-md-6 pl-0">
            <?php /*<div class="row w-100 mx-0">
                <div class="col-md-12">
                    <label>Your main representative is:</label>
                </div>
            </div>	
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="l_title">Title</label>
                </div>
                <div class="col-md-5">
                    <select id="l_title" name="l_title" class="form-control form-control-sm">
                        <option>-- Select --</option>
                        <option <?php echo ($_COOKIE['l_title']=="Dr")?"selected":""; ?>>Dr</option>								
                        <option <?php echo ($_COOKIE['l_title']=="Mr")?"selected":""; ?>>Mr</option>
                        <option <?php echo ($_COOKIE['l_title']=="Mrs")?"selected":""; ?>>Mrs</option>
                        <option <?php echo ($_COOKIE['l_title']=="Ms")?"selected":""; ?>>Ms</option>
                    </select>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="l_first_name">First name<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="text" id="l_first_name" name="l_first_name" value="" required>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="l_middle_name">Middle name</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="l_middle_name" name="l_middle_name" value="">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="l_last_name">Last name<div class="text-danger" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm border-danger" type="text" id="l_last_name" name="l_last_name" value="" required>
                </div>
            </div>	
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="l_gender">Gender</label>
                </div>
                <div class="col-md-5">
                    <select id="l_gender" name="l_gender" class="form-control form-control-sm">
                        <option>-- Select --</option>
                        <option <?php echo ($_COOKIE['l_gender']=="Male")?"selected":""; ?>>Male</option>
                        <option <?php echo ($_COOKIE['l_gender']=="Female")?"selected":""; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="leaders_status">Status (e.g. president, <br>director, administrator, etc.)</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="leaders_status" name="leaders_status" value="<?php echo (isset($_COOKIE['leaders_status']))?$_COOKIE['leaders_status']:"";?>">
                </div>
            </div>
            <br><br> */ ?>
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
                        <option>-- Select --</option>
                        <option <?php echo ($_COOKIE['c_title']=="Dr")?"selected":""; ?>>Dr</option>
                        <option <?php echo ($_COOKIE['c_title']=="Mr")?"selected":""; ?>>Mr</option>
                        <option <?php echo ($_COOKIE['c_title']=="Mrs")?"selected":""; ?>>Mrs</option>
                        <option <?php echo ($_COOKIE['c_title']=="Ms")?"selected":""; ?>>Ms</option>
                    </select>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="c_first_name">First name</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="c_first_name" name="c_first_name" value="">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="c_middle_name">Middle name</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="c_middle_name" name="c_middle_name" value="">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="c_last_name">Last name</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="c_last_name" name="c_last_name" value="">
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="c_gender">Gender</label>
                </div>
                <div class="col-md-5">
                    <select id="c_gender" name="c_gender" class="form-control form-control-sm">
                        <option>-- Select --</option>
                        <option <?php echo ($_COOKIE['c_gender']=="Male")?"selected":""; ?>>Male</option>
                        <option <?php echo ($_COOKIE['c_gender']=="Female")?"selected":""; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="row w-100 mx-0">
                <div class="col-md-5">
                    <label for="contact_status">Contact Status</label>
                </div>
                <div class="col-md-5">
                    <input class="form-control form-control-sm" type="text" id="contact_status" name="contact_status" value="<?php echo (isset($_COOKIE['contact_status']))?$_COOKIE['contact_status']:"";?>">
                    <input type="hidden" id="timezone" name="timezone" value="">
                </div>
            </div>
        </div>
    </div>
	<div class="row w-100 mx-0">
		<div class="col-md-12 d-flex justify-content-center">
			<div class="center_message">
				<button type="submit" name="register_btn" class="btn btn-primary btn-sm">Register</button>			
			</div>
		</div>
	</div>	
</form>
<br>
<div id="choose_ls_ids" title="Choose websites">
	<?php 
	$ls_ids=$prod->get_all_websites();
	
	for($i=0;$i<count($ls_ids);$i++)
	{
	?>
	<div class="row">
		<input type="checkbox" id="site<?php echo $i;?>" name="site<?php echo $i;?>" class="sites" value="<?php echo $ls_ids[$i]['ls_id'];?>">
		<label for="site<?php echo $i;?>"><?php echo $ls_ids[$i]['ls_name'];?></label>
	</div>
	<?php
	}
	?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    let timezone=Intl.DateTimeFormat().resolvedOptions().timeZone;

    $('#timezone').val(timezone);  
});  

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
			console.log(all_sites);
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
		/*form: "dialog_form_<?php echo $row['o_id']; ?>"*/
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
	<a href="<?php echo $base_url; ?>index.php" class="btn btn-danger btn-sm">Login</a>
	<br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=<?php echo $base_url; ?>index.php">
	<?php
	}
	?>
	</div>
	</article>
</section>
<?php
include('../footer.php');
?>