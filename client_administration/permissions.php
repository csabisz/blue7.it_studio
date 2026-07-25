<?php
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Client Administration - Creator Permissions";

include('../header2.php');
include('../menu.php');
?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white px-0">
	<?php
	if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
	{			
		$client_id=$prod->xss_fix($_GET['client_id']);
		?>
        <p class="w-100 text-center display-4 pt-4">Modify creator ID <?php echo $client_id;?></p>
        <hr class="mb-4" width="450px">
<?php 
	include('submenu.php');
	
	if(isset($_POST['save_btn']))
	{
		$update_creator_data['client_id']=$prod->xss_fix($_POST['client_id']);
		//$lt_id=$prod->xss_fix($_POST['lt_id']);
		$rights_data['uca_name']=$prod->xss_fix($_POST['uca_name']);
		//$uca_address=$prod->xss_fix($_POST['uca_address']);
		//$uca_email=$prod->xss_fix($_POST['uca_email']);
		//$phone=$prod->xss_fix($_POST['phone']);
		//$password=$prod->xss_fix($_POST['password']);
		//$password2=$prod->xss_fix($_POST['password2']);
		
		$all_rights=$_POST['rights'];
	
		/*$user_admin=0;
		$contracting=0;
		$bookkeeping=0;
		$coordination=0;
		$activity_view=0;
		$apu_list=0;
		$examples_db=0;
		$tutorials=0;*/
		
		for($i=0;$i<count($all_rights);$i++)
		{
			if(!empty($all_rights[$i]))
			{
                if($all_rights[$i]=="own_tasks")
				{
					$rights_data['own_tasks']=1;
                }
                if($all_rights[$i]=="client")
				{
					$rights_data['client']=1;
                }
				if($all_rights[$i]=="user_admin")
				{
					$rights_data['user_admin']=1;
                }
				if($all_rights[$i]=="main_client_admin")
				{
					$rights_data['main_client_admin']=1;
                }
				if($all_rights[$i]=="cdesign")
				{
					$rights_data['cdesign']=1;
                }
				if($all_rights[$i]=="cmeasures")
				{
					$rights_data['cmeasures']=1;
                }
				if($all_rights[$i]=="change_vat")
				{
					$rights_data['change_vat']=1;
                }
                if($all_rights[$i]=="programs_of_employees")
				{
					$rights_data['programs_of_employees']=1;
				}
				if($all_rights[$i]=="contracting")
				{
					$rights_data['contracting']=1;
				}
				if($all_rights[$i]=="bookkeeping")
				{
					$rights_data['bookkeeping']=1;
				}
				if($all_rights[$i]=="coordination")
				{
					$rights_data['coordination']=1;
                }
				if($all_rights[$i]=="qualified_for_all_tasks")
				{
					$rights_data['qualified_for_all_tasks']=1;
				}
				if($all_rights[$i]=="housesets")
				{
					$rights_data['housesets']=1;
                }
                if($all_rights[$i]=="plansets")
				{
					$rights_data['plansets']=1;
                }
                if($all_rights[$i]=="plots")
				{
					$rights_data['plots']=1;
				}
                if($all_rights[$i]=="view_all_orders")
				{
					$rights_data['view_all_orders']=1;
				}
				if($all_rights[$i]=="activity_view")
				{
					$rights_data['activity_view']=1;
				}
				if($all_rights[$i]=="apu_list")
				{
					$rights_data['APU_lists']=1;
				}
				if($all_rights[$i]=="examples_db")
				{
					$rights_data['examples_db']=1;
				}
				if($all_rights[$i]=="tutorials")
				{
					$rights_data['tutorials']=1;
				}
			}
        }
        
		//$rights_data['u_status']=$prod->xss_fix($_POST['u_status']);
		
		$qualifications_data['b1_floorplans']=$prod->xss_fix($_POST['b1_floorplans']);
		$qualifications_data['b1_pictures']=$prod->xss_fix($_POST['b1_pictures']);
		$qualifications_data['b1_360']=$prod->xss_fix($_POST['b1_360']);
		$qualifications_data['b1_videos']=$prod->xss_fix($_POST['b1_videos']);
		$qualifications_data['b1_base_picture']=$prod->xss_fix($_POST['b1_base_picture']);
		$qualifications_data['b1_masks']=$prod->xss_fix($_POST['b1_masks']);
		$qualifications_data['b1_targets']=$prod->xss_fix($_POST['b1_targets']);
		$qualifications_data['b1_suntour_model']=$prod->xss_fix($_POST['b1_suntour_model']);
		$qualifications_data['b1_vr']=$prod->xss_fix($_POST['b1_vr']);

		$qualifications_data['b3_walls']=$prod->xss_fix($_POST['b3_walls']);
		$qualifications_data['b3_windows_doors']=$prod->xss_fix($_POST['b3_windows_doors']);
		$qualifications_data['b3_furniture']=$prod->xss_fix($_POST['b3_furniture']);
        $qualifications_data['b3_check']=$prod->xss_fix($_POST['b3_check']);
        
		$qualifications_data['b5_make_object']=$prod->xss_fix($_POST['b5_make_object']);
		$qualifications_data['b5_walls']=$prod->xss_fix($_POST['b5_walls']);
		$qualifications_data['b5_windows_doors']=$prod->xss_fix($_POST['b5_windows_doors']);
		$qualifications_data['b5_furniture']=$prod->xss_fix($_POST['b5_furniture']);
		$qualifications_data['b5_environment']=$prod->xss_fix($_POST['b5_environment']);
		$qualifications_data['b5_render_stills']=$prod->xss_fix($_POST['b5_render_stills']);
        $qualifications_data['b5_render_360']=$prod->xss_fix($_POST['b5_render_360']);
        $qualifications_data['b5_render_slideshow']=$prod->xss_fix($_POST['b5_render_slideshow']);
        $qualifications_data['b5_render_movie']=$prod->xss_fix($_POST['b5_render_movie']);
        $qualifications_data['b5_2d_configurator']=$prod->xss_fix($_POST['b5_2d_configurator']);
        $qualifications_data['b5_2d_konfig_renders']=$prod->xss_fix($_POST['b5_2d_konfig_renders']);
        $qualifications_data['b5_3d_configurator']=$prod->xss_fix($_POST['b5_3d_configurator']);
        $qualifications_data['b5_vr']=$prod->xss_fix($_POST['b5_vr']);
		$qualifications_data['b5_check']=$prod->xss_fix($_POST['b5_check']);
        
		$qualifications_data['b6_make_object']=$prod->xss_fix($_POST['b6_make_object']);
        $qualifications_data['b6_walls']=$prod->xss_fix($_POST['b6_walls']);
		$qualifications_data['b6_windows_doors']=$prod->xss_fix($_POST['b6_windows_doors']);
		$qualifications_data['b6_furniture']=$prod->xss_fix($_POST['b6_furniture']);
		$qualifications_data['b6_environment']=$prod->xss_fix($_POST['b6_environment']);
		$qualifications_data['b6_render_stills']=$prod->xss_fix($_POST['b6_render_stills']);
        $qualifications_data['b6_render_360']=$prod->xss_fix($_POST['b6_render_360']);
        $qualifications_data['b6_render_slideshow']=$prod->xss_fix($_POST['b6_render_slideshow']);
        $qualifications_data['b6_render_movie']=$prod->xss_fix($_POST['b6_render_movie']);
        $qualifications_data['b6_2d_configurator']=$prod->xss_fix($_POST['b6_2d_configurator']);
		$qualifications_data['b6_premium_pictures']=$prod->xss_fix($_POST['b6_premium_pictures']);
        $qualifications_data['b6_2d_konfig_renders']=$prod->xss_fix($_POST['b6_2d_konfig_renders']);
        $qualifications_data['b6_3d_configurator']=$prod->xss_fix($_POST['b6_3d_configurator']);
        $qualifications_data['b6_vr']=$prod->xss_fix($_POST['b6_vr']);
        $qualifications_data['b6_check']=$prod->xss_fix($_POST['b6_check']);
        
		$qualifications_data['b7_make_object']=$prod->xss_fix($_POST['b7_make_object']);
		$qualifications_data['b7_walls']=$prod->xss_fix($_POST['b7_walls']);
		$qualifications_data['b7_windows_doors']=$prod->xss_fix($_POST['b7_windows_doors']);
		$qualifications_data['b7_furniture']=$prod->xss_fix($_POST['b7_furniture']);
		$qualifications_data['b7_environment']=$prod->xss_fix($_POST['b7_environment']);
		$qualifications_data['b7_render_stills']=$prod->xss_fix($_POST['b7_render_stills']);
        $qualifications_data['b7_render_360']=$prod->xss_fix($_POST['b7_render_360']);
        $qualifications_data['b7_render_slideshow']=$prod->xss_fix($_POST['b7_render_slideshow']);
        $qualifications_data['b7_render_movie']=$prod->xss_fix($_POST['b7_render_movie']);
		$qualifications_data['b7_in_2d_configurator']=$prod->xss_fix($_POST['b7_in_2d_configurator']);
        $qualifications_data['b7_in_2d_konfig_renders']=$prod->xss_fix($_POST['b7_in_2d_konfig_renders']);
        $qualifications_data['b7_2d_configurator']=$prod->xss_fix($_POST['b7_2d_configurator']);
        $qualifications_data['b7_2d_konfig_renders']=$prod->xss_fix($_POST['b7_2d_konfig_renders']);
        $qualifications_data['b7_3d_configurator']=$prod->xss_fix($_POST['b7_3d_configurator']);
        $qualifications_data['b7_vr']=$prod->xss_fix($_POST['b7_vr']);
        $qualifications_data['b7_check']=$prod->xss_fix($_POST['b7_check']);
        
		$qualifications_data['b8_make_object']=$prod->xss_fix($_POST['b8_make_object']);
        $qualifications_data['b8_walls']=$prod->xss_fix($_POST['b8_walls']);
		$qualifications_data['b8_windows_doors']=$prod->xss_fix($_POST['b8_windows_doors']);
		$qualifications_data['b8_furniture']=$prod->xss_fix($_POST['b8_furniture']);
		$qualifications_data['b8_environment']=$prod->xss_fix($_POST['b8_environment']);
		$qualifications_data['b8_render_stills']=$prod->xss_fix($_POST['b8_render_stills']);
        $qualifications_data['b8_render_360']=$prod->xss_fix($_POST['b8_render_360']);
        $qualifications_data['b8_render_slideshow']=$prod->xss_fix($_POST['b8_render_slideshow']);
        $qualifications_data['b8_render_movie']=$prod->xss_fix($_POST['b8_render_movie']);
        $qualifications_data['b8_2d_configurator']=$prod->xss_fix($_POST['b8_2d_configurator']);
        $qualifications_data['b8_2d_konfig_renders']=$prod->xss_fix($_POST['b8_2d_konfig_renders']);
        $qualifications_data['b8_3d_configurator']=$prod->xss_fix($_POST['b8_3d_configurator']);
        $qualifications_data['b8_vr']=$prod->xss_fix($_POST['b8_vr']);
		$qualifications_data['b8_check']=$prod->xss_fix($_POST['b8_check']);
		
		$english_usa=$prod->xss_fix($_POST['english_usa']);
		$french=$prod->xss_fix($_POST['french']);
		$spanish=$prod->xss_fix($_POST['spanish']);
		$hungarian=$prod->xss_fix($_POST['hungarian']);
		$romanian=$prod->xss_fix($_POST['romanian']);
		$english_uk=$prod->xss_fix($_POST['english_uk']);
        $german=$prod->xss_fix($_POST['german']);
        $bulgarian=$prod->xss_fix($_POST['bulgarian']);
		$russian=$prod->xss_fix($_POST['russian']);
		$chinese=$prod->xss_fix($_POST['chinese']);
		$turkish=$prod->xss_fix($_POST['turkish']);
        $ucrainian=$prod->xss_fix($_POST['ucrainian']);
        $serbocroatian=$prod->xss_fix($_POST['serbocroatian']);

		$trans_languages=$_POST['trans_languages'] ?? [];
		
		for($i=0;$i<count($trans_languages);$i++)
		{
			if(!empty($trans_languages))
			{
				$trans_language.=$trans_languages[$i].";";
			}
		}		
            
            $rights_data['client_id']=$update_creator_data['client_id'];
            $rights_data['trans_languages']=$trans_language;
            $qualifications_data['client_id']=$update_creator_data['client_id'];

            $client_rights=$prod->get_client_rights($update_creator_data['client_id']);

            if(count($client_rights)>0)
            {
                $prod->update_client_rights(json_encode($rights_data));
            }
            else
            {
                $prod->add_client_rights(json_encode($rights_data));
            }

            $client_qualifications=$prod->get_client_qualifications($update_creator_data['client_id']);

            if(count($client_qualifications)>0)
            {
			    $prod->update_client_qualifications(json_encode($qualifications_data));
            }
            else
            {
                $prod->add_client_qualifications(json_encode($qualifications_data));
            }

			$prod->delete_creator_languages($update_creator_data['client_id']);
			
			if(!empty($english_usa))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],1,$english_usa);
			}
			if(!empty($french))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],33,$french);
			}
			if(!empty($spanish))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],34,$spanish);
			}
			if(!empty($hungarian))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],36,$hungarian);
			}
			if(!empty($romanian))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],40,$romanian);
			}
			if(!empty($english_uk))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],44,$english_uk);
			}
			if(!empty($german))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],49,$german);
            }
            if(!empty($bulgarian))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],7,$bulgarian);
			}
			if(!empty($russian))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],7,$russian);
			}
			if(!empty($chinese))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],86,$chinese);
			}
			if(!empty($turkish))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],90,$turkish);
            }
            if(!empty($ucrainian))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],380,$ucrainian);
            }
            if(!empty($serbocroatian))
			{
				$prod->add_creator_languages($update_creator_data['client_id'],381,$serbocroatian);
			}
			?>
			<div class="text-center">
				<div class="alert alert-success">
					Update successful !
				</div>	
			</div>
			<br>
			<meta http-equiv="refresh" content="2; url=index.php"> 
			<?php
		//}				
	}
	
$creator=$prod->get_client($client_id);

?>
<br>
<form name="update_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?client_id=<?php echo $client_id;?>" enctype="multipart/form-data">
<input type="hidden" name="client_id" value="<?php echo $client_id;?>">
	<div class="row mx-0 w-100">
        <div class="col-md-12 pt-4 border border-left-0">
            <div class="row w-100 mx-0">
                <div class="col-md-2">
                    <label for="uca_name">Creator's name<div class="error" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-2">
                    <input class="form-control form-control-sm" type="text" id="uca_name" name="uca_name" value="<?php 
                    if(!empty($creator['c_first_name']))
                    {
                        echo $creator['c_first_name']." ".$creator['c_last_name'];
                    }
                    else
                    {
                        echo $creator['l_first_name']." ".$creator['l_last_name'];
                    }?>">
                </div>
				<div class="col-md-2">
                    <label for="email">Creator's email<div class="error" style="display:inline-flex;">&nbsp;*</div></label>
                </div>
                <div class="col-md-2">
                    <input class="form-control form-control-sm" type="email" id="uca_email" name="uca_email" value="<?php echo $creator['email'];?>" readonly>
                </div>
				<div class="col-md-2">
                    <label for="email">Phone</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control form-control-sm" type="text" id="phone" name="phone" value="<?php echo $creator['phone'];?>" readonly>
                </div>
            </div>            								
        </div>
        <div class="col-md-12 py-2 border border-right-0">
            <div class="row w-100 mx-0">
                <div class="col-md-12">
                    <b>Rights</b>
                </div>
            </div>
            <?php
            $rights=$prod->get_client_rights($client_id);
            ?>
             <div class="row w-100 mx-0">
                <div class="col-md-6">
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="client" class="form-control form-control-sm mr-3" id="client" name="rights[]" <?php echo ($rights['client']>0)?"checked":"";?>>
							<label for="client">Client on cseven</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="own_tasks" class="form-control form-control-sm mr-3" id="own_tasks" name="rights[]" <?php echo ($rights['own_tasks']>0)?"checked":"";?>>
							<label for="own_tasks">Own tasks</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="user_admin" class="form-control form-control-sm mr-3" id="user_admin" name="rights[]" <?php echo ($rights['user_admin']>0)?"checked":"";?>>
							<label for="user_admin">User admin</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="main_client_admin" class="form-control form-control-sm mr-3" id="main_client_admin" name="rights[]" <?php echo ($rights['main_client_admin']>0)?"checked":"";?>>
							<label for="main_client_admin">Main client admin</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="programs_of_employees" class="form-control form-control-sm mr-3" id="programs_of_employees" name="rights[]" <?php echo ($rights['programs_of_employees']>0)?"checked":"";?>>
							<label for="programs_of_employees">Programs of employees</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="contracting" class="form-control form-control-sm mr-3" id="contracting" name="rights[]" <?php echo ($rights['contracting']>0)?"checked":"";?>>
							<label for="contracting">Contracting</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="cdesign" class="form-control form-control-sm mr-3" id="cdesign" name="rights[]" <?php echo ($rights['cdesign']>0)?"checked":"";?>>
							<label for="cdesign">Client design</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="cmeasures" class="form-control form-control-sm mr-3" id="cmeasures" name="rights[]" <?php echo ($rights['cmeasures']>0)?"checked":"";?>>
							<label for="cmeasures">Client measures</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-inline">
							<input type="checkbox" value="bookkeeping" class="form-control form-control-sm mr-3" id="bookkeeping" name="rights[]" <?php echo ($rights['bookkeeping']>0)?"checked":"";?>>
							<label for="bookkeeping">Bookkeeping</label>
						</div>
					</div>
                </div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="change_vat" class="form-control form-control-sm mr-3" id="change_vat" name="rights[]" <?php echo ($rights['change_vat']>0)?"checked":"";?>>
							<label for="change_vat">Change Country VAT</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="coordination" class="form-control form-control-sm mr-3" id="coordination" name="rights[]" <?php echo ($rights['coordination']>0)?"checked":"";?>>
							<label for="coordination">Coordination</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="qualified_for_all_tasks" class="form-control form-control-sm mr-3" id="qualified_for_all_tasks" name="rights[]" <?php echo ($rights['qualified_for_all_tasks']>0)?"checked":"";?>>
							<label for="qualified_for_all_tasks">Qualified for all tasks</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="housesets" class="form-control form-control-sm mr-3" id="housesets" name="rights[]" <?php echo ($rights['housesets']>0)?"checked":"";?>>
							<label for="plansets">House-sets</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="plansets" class="form-control form-control-sm mr-3" id="plansets" name="rights[]" <?php echo ($rights['plansets']>0)?"checked":"";?>>
							<label for="plansets">Plan-sets</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="plots" class="form-control form-control-sm mr-3" id="plots" name="rights[]" <?php echo ($rights['plots']>0)?"checked":"";?>>
							<label for="plansets">Plots</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="activity_view" class="form-control form-control-sm mr-3" id="activity_view" name="rights[]" <?php echo ($rights['activity_view']>0)?"checked":"";?>>
							<label for="activity_view">Activity view</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="apu_list" class="form-control form-control-sm mr-3" id="apu_list" name="rights[]" <?php echo ($rights['APU_lists']>0)?"checked":"";?>>
							<label for="apu_list">APU list</label>
                		</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-inline">
							<input type="checkbox" value="examples_db" class="form-control form-control-sm mr-3" id="examples_db" name="rights[]" <?php echo ($rights['examples_db']>0)?"checked":"";?>>
							<label for="examples_db">Examples DB</label>
						</div>
					</div>
					<?php
					if(($_COOKIE['client_id']==160)||($_COOKIE['client_id']==287)||($_COOKIE['client_id']==304)||($_COOKIE['client_id']==328))
					{
					?>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="view_all_orders" class="form-control form-control-sm mr-3" id="view_all_orders" name="rights[]" <?php echo ($rights['view_all_orders']>0)?"checked":"";?>>
							<label for="view_all_orders">View all orders</label>
						</div>
					</div>
					<?php
					}
					else
					{
					?>
					<div class="row">
						<div class="col-md-12 form-inline">
							<input type="checkbox" value="view_all_orders" class="form-control form-control-sm mr-3" id="view_all_orders" name="rights[]" disabled="disabled" <?php echo ($rights['view_all_orders']>0)?"checked":"";?>>
							<label for="view_all_orders">View all orders</label>
							<?php
							if($rights['view_all_orders']>0)
							{
							?>
							<input type="hidden" value="view_all_orders" name="rights[]">
							<?php
							}
							?>
						</div>
					</div>
					<?php
					}
					?>
					<div class="row">
						<div class="col-md-6 form-inline">
							<input type="checkbox" value="tutorials" class="form-control form-control-sm mr-3" id="tutorials" name="rights[]" <?php echo ($rights['tutorials']>0)?"checked":"";?>>
							<label for="tutorials">Tutorials</label>
						</div>
					</div>
                </div>
        </div>
    </div>
	<div class="col-md-12 px-0">
		<div class="row w-100 mx-0 py-2">
			<div class="col-md-12" style="text-align:center;">
				<b>Qualifications</b>
			</div>
		</div>
		<?php 
		$qualifications=$prod->get_client_qualifications($client_id);
		?>
		<div class="row w-100 mx-0 border border-left-0 border-right-0">
			<div class="col-md-4 border-bottom px-0 d-flex flex-column">
			<div class="row w-100 mx-0 border-bottom py-1">
					<div class="col-md-12" style="text-align:center;">
						<b>B1</b>
					</div>	
				</div>
				<div class="row w-100 mx-0 pt-4 pb-1">
					<div class="col-md-6 text-right">
						Floorplans
					</div>	
					<div class="col-md-6">
						<input type="text" id="b1_floorplans" name="b1_floorplans" value="<?php echo $qualifications['b1_floorplans'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
				</div>
				<div class="row w-100 mx-0 pb-1">
					<div class="col-md-6 text-right">
						Camera Pictures
					</div>	
					<div class="col-md-6">
						<input type="text" id="b1_pictures" name="b1_pictures" value="<?php echo $qualifications['b1_pictures'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Panoramas 360
					</div>	
					<div class="col-md-6">
						<input type="text" id="b1_360" name="b1_360" value="<?php echo $qualifications['b1_360'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Videos
					</div>	
					<div class="col-md-4">
						<input type="text" id="b1_videos" name="b1_videos" value="<?php echo $qualifications['b1_videos'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
                </div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Base Picture
					</div>	
					<div class="col-md-4">
						<input type="text" id="b1_base_picture" name="b1_base_picture" value="<?php echo $qualifications['b1_base_picture'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
                </div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Masks
					</div>	
					<div class="col-md-4">
						<input type="text" id="b1_masks" name="b1_masks" value="<?php echo $qualifications['b1_masks'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
                </div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Targets
					</div>	
					<div class="col-md-4">
						<input type="text" id="b1_targets" name="b1_targets" value="<?php echo $qualifications['b1_targets'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
                </div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Suntour Model
					</div>	
					<div class="col-md-4">
						<input type="text" id="b1_suntour_model" name="b1_suntour_model" value="<?php echo $qualifications['b1_suntour_model'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
                </div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Virtual Reality
					</div>	
					<div class="col-md-4">
						<input type="text" id="b1_vr" name="b1_vr" value="<?php echo $qualifications['b1_vr'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
                </div>
				<div class="row w-100 mx-0 border-top-0 border-bottom py-1">
					<div class="col-md-12" style="text-align:center;">
						<b>B3</b>
					</div>	
				</div>
				<div class="row w-100 mx-0 pt-4 pb-1">
					<div class="col-md-6 text-right">
						Walls
					</div>	
					<div class="col-md-6">
						<input type="text" id="b3_walls" name="b3_walls" value="<?php echo $qualifications['b3_walls'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Windows - Doors
					</div>	
					<div class="col-md-6">
						<input type="text" id="b3_windows_doors" name="b3_windows_doors" value="<?php echo $qualifications['b3_windows_doors'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Furniture
					</div>	
					<div class="col-md-4">
						<input type="text" id="b3_furniture" name="b3_furniture" value="<?php echo $qualifications['b3_furniture'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
                </div>
                <div class="row w-100 mx-0 py-1 mb-4">
					<div class="col-md-6 text-right">
						Check
					</div>	
					<div class="col-md-4">
						<input type="text" id="b3_check" name="b3_check" value="<?php echo $qualifications['b3_check'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>	
				</div>
			</div>
			<div class="col-md-4 border border-top-0 px-0">
				<div class="row w-100 mx-0 border-bottom py-1">
					<div class="col-md-12" style="text-align:center;">
						<b>B5</b>
					</div>
				</div>	
				<div class="row w-100 mx-0 pt-4 pb-1">
					<div class="col-md-6 text-right">
						Make object
					</div>	
					<div class="col-md-4">
						<input type="text" id="b5_make_object" name="b5_make_object" value="<?php echo $qualifications['b5_make_object'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 pb-1">
					<div class="col-md-6 text-right">
						Walls
					</div>	
					<div class="col-md-4">
						<input type="text" id="b5_walls" name="b5_walls" value="<?php echo $qualifications['b5_walls'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Windows - Doors
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_windows_doors" name="b5_windows_doors" value="<?php echo $qualifications['b5_windows_doors'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Furniture layer
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_furniture" name="b5_furniture" value="<?php echo $qualifications['b5_furniture'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Environment
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_environment" name="b5_environment" value="<?php echo $qualifications['b5_environment'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render stills
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_render_stills" name="b5_render_stills" value="<?php echo $qualifications['b5_render_stills'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render 360
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_render_360" name="b5_render_360" value="<?php echo $qualifications['b5_render_360'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render slideshow
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_render_slideshow" name="b5_render_slideshow" value="<?php echo $qualifications['b5_render_slideshow'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render movie
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_render_movie" name="b5_render_movie" value="<?php echo $qualifications['b5_render_movie'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
                        3D configurator-X
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_3d_configurator" name="b5_3d_configurator" value="<?php echo $qualifications['b5_3d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						2D Config renders-Y
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_2d_konfig_renders" name="b5_2d_konfig_renders" value="<?php echo $qualifications['b5_2d_konfig_renders'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						2D configurator-Z
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_2d_configurator" name="b5_2d_configurator" value="<?php echo $qualifications['b5_2d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Virtual reality
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_vr" name="b5_vr" value="<?php echo $qualifications['b5_vr'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 pt-1 pb-4">
					<div class="col-md-6 text-right">
						Check
					</div>	
					<div class="col-md-6">
						<input type="text" id="b5_check" name="b5_check" value="<?php echo $qualifications['b5_check'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
			</div>
			<div class="col-md-4 border-bottom px-0">
				<div class="row w-100 mx-0 py-1 border-bottom">
					<div class="col-md-12" style="text-align:center;">
						<b>B6</b>
					</div>
				</div>
				<div class="row w-100 mx-0 pt-4 pb-1">
					<div class="col-md-6 text-right">
						Make objects
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_make_object" name="b6_make_object" value="<?php echo $qualifications['b6_make_object'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 pb-1">
					<div class="col-md-6 text-right">
						Walls
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_walls" name="b6_walls" value="<?php echo $qualifications['b6_walls'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Windows - Doors
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_windows_doors" name="b6_windows_doors" value="<?php echo $qualifications['b6_windows_doors'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Furniture layer
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_furniture" name="b6_furniture" value="<?php echo $qualifications['b6_furniture'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Environment
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_environment" name="b6_environment" value="<?php echo $qualifications['b6_environment'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render stills
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_render_stills" name="b6_render_stills" value="<?php echo $qualifications['b6_render_stills'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render 360
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_render_360" name="b6_render_360" value="<?php echo $qualifications['b6_render_360'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render slideshow
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_render_slideshow" name="b6_render_slideshow" value="<?php echo $qualifications['b6_render_slideshow'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render movie
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_render_movie" name="b6_render_movie" value="<?php echo $qualifications['b6_render_movie'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
                        3D configurator-X
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_3d_configurator" name="b6_3d_configurator" value="<?php echo $qualifications['b6_3d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						2D Config renders-Y
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_2d_konfig_renders" name="b6_2d_konfig_renders" value="<?php echo $qualifications['b6_2d_konfig_renders'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						2D configurator-Z
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_2d_configurator" name="b6_2d_configurator" value="<?php echo $qualifications['b6_2d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Premium pictures
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_premium_pictures" name="b6_premium_pictures" value="<?php echo $qualifications['b6_premium_pictures'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Virtual reality
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_vr" name="b6_vr" value="<?php echo $qualifications['b6_vr'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Check
					</div>	
					<div class="col-md-6">
						<input type="text" id="b6_check" name="b6_check" value="<?php echo $qualifications['b6_check'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
			</div>
		</div>
        <br>
        <div class="row w-100 mx-0 border border-left-0 border-right-0">
			<div class="col-md-4 border-bottom px-0">
				<div class="row w-100 mx-0 py-1 border-bottom">
					<div class="col-md-12" style="text-align:center;">
						<b>B7</b>
					</div>
				</div>
				<div class="row w-100 mx-0 pt-4 pb-1">
					<div class="col-md-6 text-right">
						Make object
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_make_object" name="b7_make_object" value="<?php echo $qualifications['b7_make_object'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 pb-1">
					<div class="col-md-6 text-right">
						Walls
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_walls" name="b7_walls" value="<?php echo $qualifications['b7_walls'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Windows - Doors
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_windows_doors" name="b7_windows_doors" value="<?php echo $qualifications['b7_windows_doors'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Furniture layer
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_furniture" name="b7_furniture" value="<?php echo $qualifications['b7_furniture'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Environment
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_environment" name="b7_environment" value="<?php echo $qualifications['b7_environment'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render stills
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_render_stills" name="b7_render_stills" value="<?php echo $qualifications['b7_render_stills'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render 360
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_render_360" name="b7_render_360" value="<?php echo $qualifications['b7_render_360'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render slideshow
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_render_slideshow" name="b7_render_slideshow" value="<?php echo $qualifications['b7_render_slideshow'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render movie
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_render_movie" name="b7_render_movie" value="<?php echo $qualifications['b7_render_movie'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						IN 2D Config renders-Y
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_in_2d_konfig_renders" name="b7_in_2d_konfig_renders" value="<?php echo $qualifications['b7_in_2d_konfig_renders'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						IN 2D configurator-Z
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_in_2d_configurator" name="b7_in_2d_configurator" value="<?php echo $qualifications['b7_in_2d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
                        EX 3D configurator-X
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_3d_configurator" name="b7_3d_configurator" value="<?php echo $qualifications['b7_3d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						EX 2D Config renders-Y
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_2d_konfig_renders" name="b7_2d_konfig_renders" value="<?php echo $qualifications['b7_2d_konfig_renders'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						EX 2D configurator-Z
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_2d_configurator" name="b7_2d_configurator" value="<?php echo $qualifications['b7_2d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Virtual reality
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_vr" name="b7_vr" value="<?php echo $qualifications['b7_vr'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Check
					</div>	
					<div class="col-md-6">
						<input type="text" id="b7_check" name="b7_check" value="<?php echo $qualifications['b7_check'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
			</div>
            <div class="col-md-4 border-bottom px-0">
				<div class="row w-100 mx-0 py-1 border-bottom">
					<div class="col-md-12" style="text-align:center;">
						<b>B8</b>
					</div>
				</div>
				<div class="row w-100 mx-0 pt-4 pb-1">
					<div class="col-md-6 text-right">
						Make object
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_make_object" name="b8_make_object" value="<?php echo $qualifications['b8_make_object'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 pb-1">
					<div class="col-md-6 text-right">
						Walls
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_walls" name="b8_walls" value="<?php echo $qualifications['b8_walls'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Windows - Doors
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_windows_doors" name="b8_windows_doors" value="<?php echo $qualifications['b8_windows_doors'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Furniture layer
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_furniture" name="b8_furniture" value="<?php echo $qualifications['b8_furniture'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Environment
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_environment" name="b8_environment" value="<?php echo $qualifications['b8_environment'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render stills
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_render_stills" name="b8_render_stills" value="<?php echo $qualifications['b8_render_stills'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render 360
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_render_360" name="b8_render_360" value="<?php echo $qualifications['b8_render_360'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render slideshow
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_render_slideshow" name="b8_render_slideshow" value="<?php echo $qualifications['b8_render_slideshow'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
                </div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Render movie
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_render_movie" name="b8_render_movie" value="<?php echo $qualifications['b8_render_movie'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
                </div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
                        3D configurator-X
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_3d_configurator" name="b8_3d_configurator" value="<?php echo $qualifications['b8_3d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						2D Config renders-Y
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_2d_konfig_renders" name="b8_2d_konfig_renders" value="<?php echo $qualifications['b8_2d_konfig_renders'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						2D configurator-Z
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_2d_configurator" name="b8_2d_configurator" value="<?php echo $qualifications['b8_2d_configurator'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
                <div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Virtual Reality
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_vr" name="b8_vr" value="<?php echo $qualifications['b8_vr'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
				<div class="row w-100 mx-0 py-1">
					<div class="col-md-6 text-right">
						Check
					</div>	
					<div class="col-md-6">
						<input type="text" id="b8_check" name="b8_check" value="<?php echo $qualifications['b8_check'];?>" class="form-control form-control-sm" style="width:6em;">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row w-100 mx-0 border-bottom">
		<div class="col-md-6 px-0 border-right">
			<div class="row w-100 mx-0 border-bottom py-2">
				<div class="col-md-12" style="text-align:center;">
					<b>Language skill levels</b>
				</div>
			</div>
            <div class="row w-100 mx-0 pt-4 pb-1">
				<div class="col-md-6 text-right">
					Bulgarian
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="bulgarian" name="bulgarian" value="<?php
					$language_skills=$prod->get_client_languages($client_id,359);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Chinese
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="chinese" name="chinese" value="<?php
					$language_skills=$prod->get_client_languages($client_id,86);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					English (UK)
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="english_uk" name="english_uk" value="<?php
					$language_skills=$prod->get_client_languages($client_id,44);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
			<div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					English (USA)
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="english_usa" name="english_usa" value="<?php
					$language_skills=$prod->get_client_languages($client_id,1);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
			<div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					French
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="french" name="french" value="<?php
					$language_skills=$prod->get_client_languages($client_id,33);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					German
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="german" name="german" value="<?php
					$language_skills=$prod->get_client_languages($client_id,49);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Hungarian
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="hungarian" name="hungarian" value="<?php
					$language_skills=$prod->get_client_languages($client_id,36);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Italian
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="italian" name="italian" value="<?php
					$language_skills=$prod->get_client_languages($client_id,39);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Romanian
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="romanian" name="romanian" value="<?php
					$language_skills=$prod->get_client_languages($client_id,40);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Russian
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="russian" name="russian" value="<?php
					$language_skills=$prod->get_client_languages($client_id,7);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
			<div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Spanish
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="spanish" name="spanish" value="<?php
					$language_skills=$prod->get_client_languages($client_id,34);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
            </div>
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Turkish
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="turkish" name="turkish" value="<?php
					$language_skills=$prod->get_client_languages($client_id,90);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>
			<div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Ucrainian
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="ucrainian" name="ucrainian" value="<?php
					$language_skills=$prod->get_client_languages($client_id,380);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>	
            <div class="row w-100 mx-0 py-1">
				<div class="col-md-6 text-right">
					Serbocroatian
				</div>
				<div class="col-md-6" style="text-align:center;">
					<input type="text" id="serbocroatian" name="serbocroatian" value="<?php
					$language_skills=$prod->get_client_languages($client_id,381);
					echo $language_skills['skills_level'];
					?>" class="form-control form-control-sm" style="width:6em;">
				</div>
			</div>		 
		</div>
		<div class="col-md-6 px-0">
			<div class="row w-100 mx-0 py-2 border-bottom">
				<div class="col-md-12 text-center">
					<b>Access to translation languages</b>
				</div>
			</div>
			<?php
            $all_languages=$prod->get_all_languages();
            
			$creator_languages=explode(";",$rights['trans_languages']);
            //print_r($creator_languages);
            
			for($i=0;$i<count($all_languages);$i++)
			{				
			?>
			<div class="row w-100 mx-0 d-flex justify-content-center">
				<div class="col-md-6 form-inline">
					<input type="checkbox" value="<?php echo $all_languages[$i]['ln_id'];?>" class="form-control form-control-sm mr-3" id="<?php echo $all_languages[$i]['ln_id'];?>" name="trans_languages[]" <?php 
					for($j=0;$j<count($creator_languages);$j++)
					{
						if(!empty($creator_languages[$j]))
						{
							echo ($all_languages[$i]['ln_id']==$creator_languages[$j])?"checked":"";
						}
					}
					?>>					
					<label for="<?php echo $all_languages[$i]['ln_id'];?>"><?php echo $all_languages[$i]['ln_name'];?></label>
				</div>
			</div>
			<?php				
			}
			?>
		</div>
	</div>
	<div class="row w-100 mx-0 pt-3">
		<div class="col-md-6 mx-auto d-flex justify-content-center">
			<div class="center_message">
				<button type="submit" name="save_btn" class="btn btn-primary btn-sm mb-5">Save changes</button>			
			</div>
		</div>
	</div>	
</form>

<?php 
/*if(isset($_POST['save_password_btn']))
{
	$creatorid=$prod->xss_fix($_POST['creatorid']);
	
	$new_password=$_POST['new_password'];
	$new_password2=$_POST['new_password2'];

	//$check_existing_password=$prod->get_client($client_id);

	
if($new_password!=$new_password2)
{
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="center_message">
				<div class="error">
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
			<div class="center_message">
				<div class="error">
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
	$prod->update_creator_password($creatorid,$new_password);
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="center_message">
				<div class="success">
					Password successfully changed.
				</div>
			</div>	
		</div>
	</div>
	<meta http-equiv="refresh" content="2; url=index.php">
	<?php
}
}
?>
<a name="change_password"></a>
<div class="container">
	<form name="change_password_form" method="post" action="modify.php?creatorid=<?php echo $creatorid;?>#change_password" enctype="multipart/form-data">
		    <input type="hidden" name="creatorid" value="<?php echo $creatorid; ?>">
			<div class="row mx-0 w-100">
                <div class="col-4 mx-auto my-2 border py-4">
                    <div class="row w-100 mx-0 d-flex justify-content-center">
                    <div class="form-group w-100">
                        <label for="new_password">New Password</label>
                        <input class="form-control form-control-sm" type="password" id="new_password" name="new_password" required>
                    </div>
                    </div>
                    <div class="row w-100 mx-0 d-flex justify-content-center">
                        <div class="form-group w-100">
                            <label for="new_password2">Confirm new password</label>
                            <input class="form-control form-control-sm" type="password" id="new_password2" name="new_password2" required>
                        </div>
                    </div>
                    <div class="center_message row w-100 mx-0 d-flex justify-content-center">
                        <button type="submit" name="save_password_btn" class="btn btn-primary btn-sm btn-block">Save changes</button>			
                    </div>
                </div>
            </div>			
	</form>
</div>	
<br>	
	<?php	*/	
	}
	else
	{
        session_unset();
        session_destroy();
	?>
	<div class="text-center">				
	<div class="alert alert-danger">You must be logged in to view this page !</div>
	<a href="<?php echo $base_url;?>login.php" class="btn btn-danger btn-sm">Login</a>
	<br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>login.php">
	<?php
	}
	?>
	</div>
	</article>
</section>
<?php
include('../footer.php');
?>