<?php

session_start();

include('../functions.php');
include('../domenia3n_db.php');


$prod=new Production;
$domenia3n=new Domenia3n;

$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Client Administration - Presentation Infos";

include('../header2.php');

include('../menu.php');



$clientid=$prod->xss_fix($_GET['clientid']);

$client=$prod->get_client($clientid);
$main_client=$prod->get_main_client($client['mc_id']);
$client_color=$prod->get_client_color($clientid);

if(!empty($main_client))
{
$main_client_color=$prod->get_main_client_colors($client['mc_id']);
}
?>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white px-0">
<?php

if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))

{

	

	?>

    <p class="w-100 text-center display-4 pt-4">

        Presentation infos for client ID <?php echo $clientid; ?>

        <br>

        <?php

        if(!empty($client['l_last_name']))

        {

            echo $client['l_first_name']." ".$client['l_last_name'];

        }

        else

        {

            echo $client['c_first_name']." ".$client['c_last_name'];

        }



        if($client['mc_id']>0)

        {

            

            echo " - Sub of: ".$main_client['clientname'];

        }

        ?>

    </p>

    <hr class="mb-4" width="450px">

    <?php

    if(isset($_POST['main_client_presentation_infos_save_btn'])) //main client 
    {
        
        $validextensions=array("jpg","jpeg","png","svg","webp");
        $logo_dir="../../../../cseven.eu/public_html/domenia/mc_logos/";

        $presentation_infos['client_id']=$prod->xss_fix($_POST['clientid2']);
        $main_client_data['mc_id']=$prod->xss_fix($_POST['mainclientid']);

        //$main_client_data['mc_logo']=$prod->xss_fix($_POST['main_client_logo_path']);
        $main_client_data['mc_logo']=$_FILES['main_client_logo_path2'];

        $main_client_presentation_infos['mc_id']=$prod->xss_fix($_POST['mainclientid']);

        $main_client_presentation_infos['color_1']=$prod->xss_fix($_POST['main_client_text_color']);
        $main_client_presentation_infos['color_2']=$prod->xss_fix($_POST['main_client_link_text_color']);
        $main_client_presentation_infos['color_1a']=$prod->xss_fix($_POST['main_client_link_hover_text_color']);
        $main_client_presentation_infos['color_3']=$prod->xss_fix($_POST['main_client_text_color3']);
        $main_client_presentation_infos['color_4']=$prod->xss_fix($_POST['main_client_picture_shadow_color']);
        $main_client_presentation_infos['color_5']=$prod->xss_fix($_POST['main_client_background_color']);
        $main_client_presentation_infos['color_6']=$prod->xss_fix($_POST['main_client_link_hover_text_color2']);
        $main_client_presentation_infos['color_7']=$prod->xss_fix($_POST['main_client_color_7']);
        $main_client_presentation_infos['color_8']=$prod->xss_fix($_POST['main_client_color_8']);
        $main_client_presentation_infos['color_9']=$prod->xss_fix($_POST['main_client_color_9']);
        $main_client_presentation_infos['color_10']=$prod->xss_fix($_POST['main_client_color_10']);
        $main_client_presentation_infos['color_11']=$prod->xss_fix($_POST['main_client_color_11']);
        $main_client_presentation_infos['font_family']=$prod->xss_fix($_POST['main_client_font_family']);
        $main_client_presentation_infos['sl_id']=$prod->xss_fix($_POST['sl_id']);
        $main_client_presentation_infos['cls_id']=$prod->xss_fix($_POST['cls_id']);

        if(!empty($_FILES["main_client_logo_path2"]["name"]))
        {

            $main_client=$prod->get_main_client($main_client_data['mc_id']);
            $original_file_name = $_FILES["main_client_logo_path2"]["name"];

            $tempfile=explode(".",$original_file_name);
            $file_extension=strtolower(end($tempfile));

            if(in_array($file_extension,$validextensions))
            {
                

                $internal_file_name="main_client_logo_mc_".str_replace(' ', '_', $client['mc_id']).".".$file_extension;
                move_uploaded_file($_FILES["main_client_logo_path2"]["tmp_name"],$logo_dir.$internal_file_name);
                $main_client_data['mc_logo']="mc_logos/".$internal_file_name;

            }

        }
    
        if(!empty($_FILES["mc_favicon_path2"]["name"]))
        {

            $main_client=$prod->get_main_client($main_client_data['mc_id']);
            $original_file_name = $_FILES["mc_favicon_path2"]["name"];

            $tempfile=explode(".",$original_file_name);
            $file_extension=strtolower(end($tempfile));

            if(in_array($file_extension,$validextensions))
            {

                //favicon stuff
                  
                $favicon_name = $original_file_name . "mc_favicon." . $file_extension;

                if (!file_exists($logo_dir)) 
                {
                    mkdir($logo_dir, 0777, true);
                }

                    $what = getimagesize($_FILES["mc_favicon_path2"]["tmp_name"]);

                    $width = $what[0];
                    $height = $what[1];

                    // $desired_width=400;
                    // $desired_height = floor($height * ($desired_width / $width));
                    $desired_height = 100;
                    //$desired_width = floor($width * ($desired_height / $height));
                    $desired_width = 100;
                    
                    switch (strtolower($what['mime'])) {
                        case 'image/png':
                            $img = imagecreatefrompng($_FILES["mc_favicon_path2"]["tmp_name"]);
                            $new = imagecreatetruecolor($desired_width, $desired_height);

                            $whiteBackground = imagecolorallocate($new, 255, 255, 255); 
                            //$color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                            imagefill($new,0,0,$whiteBackground); // fill the background with white/transparent

                            imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                            header('Content-Type: image/png');
                            imagepng($new, $logo_dir . $favicon_name);
                            break;
                        case 'image/jpeg':
                            $img = imagecreatefromjpeg($_FILES["mc_favicon_path2"]["tmp_name"]);
                            $new = imagecreatetruecolor($desired_width, $desired_height);

                            $whiteBackground = imagecolorallocate($new, 255, 255, 255); 
                            imagefill($new,0,0,$whiteBackground); // fill the background with white

                            imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                            header('Content-Type: image/jpeg');
                            imagejpeg($new, $logo_dir . $favicon_name);
                            break;
                        case 'image/webp':
                            $img = imagecreatefromjpeg($_FILES["mc_favicon_path2"]["tmp_name"]);
                            $new = imagecreatetruecolor($desired_width, $desired_height);

                            $whiteBackground = imagecolorallocate($new, 255, 255, 255); 
                            imagefill($new,0,0,$whiteBackground); // fill the background with white

                            imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                            header('Content-Type: image/jpeg');
                            imagejpeg($new, $logo_dir . $favicon_name);
                            break;
                        case 'image/gif':
                            $img = imagecreatefromgif($_FILES["mc_favicon_path2"]["tmp_name"]);
                            $new = imagecreatetruecolor($desired_width, $desired_height);

                            $whiteBackground = imagecolorallocate($new, 255, 255, 255); 
                            imagefill($new,0,0,$whiteBackground); // fill the background with white
                            
                            imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                            header('Content-Type: image/gif');
                            imagegif($new, $logo_dir . $favicon_name);
                            break;
                        default:
                            die();
                    }

                    
                    //clearing memory maybe ?
                    imagedestroy($new);
                    $what=null;
                    $width = null;
                    $height = null;
                    $img=null;
                
                $main_client_data['mc_favicon_path']="https://domenia.cseven.eu/mc_logos/".$favicon_name;
                //end favicon stuff

                // $internal_file_name="main_client_logo_mc_".str_replace(' ', '_', $client['mc_id']).".".$file_extension;
                // move_uploaded_file($_FILES["main_client_logo_path2"]["tmp_name"],$logo_dir.$internal_file_name);
                // $main_client_data['mc_logo']="mc_logos/".$internal_file_name;

            }

        }
        
    $main_client_color=$prod->get_main_client_colors($main_client_data['mc_id']);
    
    if(!empty($main_client_color))
    {

        $prod->update_main_client_color(json_encode($main_client_presentation_infos));
        if(!empty($_FILES["main_client_logo_path2"]["name"]))
        {
            $prod->update_main_client_logo(json_encode($main_client_data));
        }
        if(!empty($_FILES["mc_favicon_path2"]["name"]))
        {
            $prod->update_main_client_favicon(json_encode($main_client_data));
        }
    }
    else
    {

        $prod->create_main_client_color(json_encode($main_client_presentation_infos));
        if(!empty($_FILES["main_client_logo_path2"]["name"]))
        {
            $prod->update_main_client_logo(json_encode($main_client_data));
        }
        if(!empty($_FILES["mc_favicon_path2"]["name"]))
        {
            $prod->update_main_client_favicon(json_encode($main_client_data));
        }
    }


    ?>

    <div class="alert alert-success text-center">
        Saved successfully !
    </div>
    <meta http-equiv="refresh" content="2; url=<?php echo $_SERVER['PHP_SELF'];?>?clientid=<?php echo $presentation_infos['client_id'];?>">
    <?php 

    } //end main_client

    

    


    //start page


	?>

    <form id="client_presentation_infos_form" name="client_presentation_infos_form" method="post" action="<?php $_SERVER['PHP_SELF'];?>?clientid=<?php echo $clientid;?>" enctype="multipart/form-data"></form>
    <form id="main_client_presentation_infos_form" name="main_client_presentation_infos_form" method="post" action="<?php $_SERVER['PHP_SELF'];?>?clientid=<?php echo $clientid;?>" enctype="multipart/form-data"></form>
    <input type="hidden" name="clientid" value="<?php echo $clientid; ?>" form="client_presentation_infos_form">
    <input type="hidden" name="mainclientid" value="<?php echo $client['mc_id']; ?>" form="main_client_presentation_infos_form">
    <input type="hidden" name="clientid2" value="<?php echo $clientid; ?>" form="main_client_presentation_infos_form">
    <div class="row">
        <!-- <div class="col-md-6 text-center">
            <b>Client colors</b>
        </div> -->
        <div class="col-md-12 text-center">
            <?php
            if($client['mc_id']!=0)
            {
            ?>
            <b>Main client colors</b>
            <?php
            }
            else
            {
            ?>
            <b>No Main client colors</b>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="row">
    <!-- <div class="col-md-6">
    <?php
    if($client['mc_id']==0)
    {
    ?>
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="logo_path">Logo</label>
            <img src="<?php echo $client['logo_path'];?>" width="60" height="60">
        </div>
        <div class="col-md-8">
            <input id="logo_path" name="logo_path" type="text" class="form-control form-control-sm" placeholder="Link will be here" value="<?php echo $client['logo_path'];?>" disabled>
            Upload picture file (jpg, png, svg ...)
            <input id="logo_path2" name="logo_path2" type="file" class="form-control form-control-sm" form="client_presentation_infos_form">
        </div>
	</div>	
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="logo_path">Favicon</label>
            <img src="<?php echo $client['favicon_path'];?>" width="60" height="60">
        </div>
        <div class="col-md-8">
            <input id="favicon_path" name="favicon_path" type="text" class="form-control form-control-sm" placeholder="Link will be here" value="<?php echo $client['favicon_path'];?>" disabled>
        </div>
	</div>			
	<div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="text_color">Col. 1 (text 1)</label>
        </div>
        <div class="col-md-4">
            <input id="text_color" name="text_color" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
            if(!empty($client_color['color_1']))
            {
                echo $client_color['color_1'];
            }
            else
            {
                echo "#000000";
            }?>" style="width:10em;" form="client_presentation_infos_form">
        </div>
        <div class="col-md-4" style="background-color:<?php 
            if(!empty($client_color['color_1']))
            {
                echo $client_color['color_1'];
            }
            else
            {
                echo "#000000";
            }?>">
        </div>

	</div>

	<div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="link_text_color">Col. 2 (link basic)</label>
        </div>
        <div class="col-md-4">
            <input id="link_text_color" name="link_text_color" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
            if(!empty($client_color['color_2']))
            {
                echo $client_color['color_2'];
            }
            else
            {
                echo "#000000";
            }?>" style="width:10em;" form="client_presentation_infos_form">
        </div>
        <div class="col-md-4" style="background-color:<?php 
            if(!empty($client_color['color_2']))
            {
                echo $client_color['color_2'];
            }
            else
            {
                echo "#000000";
            }?>">
        </div>
	</div>

	<div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="link_hover_text_color2">Col. 6 (link hovered)</label>
        </div>
        <div class="col-md-4">
            <input id="link_hover_text_color2" name="link_hover_text_color2" type="text" class="form-control form-control-sm" placeholder="(Default #ffffff)" value="<?php 
            if(!empty($client_color['color_6']))
            {
                echo $client_color['color_6'];
            }
            else
            {
                echo "#939393";
            }?>" style="width:10em;" form="client_presentation_infos_form">
        </div>
        <div class="col-md-4" style="background-color:<?php 
            if(!empty($client_color['color_6']))
            {
                echo $client_color['color_6'];
            }
            else
            {
                echo "#939393";
            }?>">

        </div>

	</div>

    <div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="text_color3">Col. 3 (link clicked)</label>
        </div>
        <div class="col-md-4">
            <input id="text_color3" name="text_color3" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
            if(!empty($client_color['color_3']))
            {
                echo $client_color['color_3'];
            }
            else
            {
                echo "#24B04D";
            }?>" style="width:10em;" form="client_presentation_infos_form">
        </div>
        <div class="col-md-4" style="background-color:<?php 
            if(!empty($client_color['color_3']))
            {
                echo $client_color['color_3'];
            }
            else
            {
                echo "#24B04D";
            }?>">

        </div>
	</div>

    <div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="picture_shadow_color">Col. 4 (shadow)</label>
        </div>
        <div class="col-md-4">
            <input id="picture_shadow_color" name="picture_shadow_color" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
            if(!empty($client_color['color_4']))
            {
                echo $client_color['color_4'];
            }
            else
            {
                echo "#000000";
            }?>" style="width:10em;" form="client_presentation_infos_form">
        </div>
        <div class="col-md-4" style="background-color:<?php 
            if(!empty($client_color['color_4']))
            {
                echo $client_color['color_4'];
            }
            else
            {
                echo "#000000";
            }?>">

        </div>
	</div>
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-4">
            <label for="background_color">Col. 5 (background)</label>
        </div>
        <div class="col-md-4">
            <input id="background_color" name="background_color" type="text" class="form-control form-control-sm" placeholder="(Default #ffffff)" value="<?php 
            if(!empty($client_color['color_5']))
            {
                echo $client_color['color_5'];
            }
            else
            {
                echo "#ffffff";
            }?>" style="width:10em;" form="client_presentation_infos_form">
        </div>
        <div class="col-md-4" style="background-color:<?php 
            if(!empty($client_color['color_5']))
            {
                echo $client_color['color_5'];
            }
            else
            {
                echo "#ffffff";
            }?>">

        </div>

	</div>
    <?php
    }    
    ?>
    </div> --><!-- end client colors -->
    <?php
    if($client['mc_id']!=0)
    {
    ?>
    <div class="col-md-6">
        <div class="row w-100 mx-0 py-2">
            <div class="col-md-4">
                <label for="main_client_logo_path">Logo</label>
                <img src="https://domenia.cseven.eu/<?php
                if(!empty($main_client['mc_logo'])){
                    echo $main_client['mc_logo'];
                }
                else{
                    echo "mc_logos/logo_PLITT_real&virtual_ESTATE_Ltd..png";
                }?>" width="60" height="60">
            </div>
            <div class="col-md-8">
                <input id="main_client_logo_path" name="main_client_logo_path" type="text" class="form-control form-control-sm" placeholder="No link" value="<?php echo $main_client['mc_logo'];?>" disabled>
                Upload picture file (jpg, png, svg ...)
                <input id="main_client_logo_path2" name="main_client_logo_path2" type="file" class="form-control form-control-sm" form="main_client_presentation_infos_form">
            </div>
        </div>
    
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-5">
            <label for="main_client_text_color"><b>Text 1</b> (<i>Col. 1</i>)</label>
        </div>
        <div class="col-md-4">
            <input id="main_client_text_color" name="main_client_text_color" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
            if(!empty($main_client_color['color_1']))
            {
                echo $main_client_color['color_1'];
            }
            else
            {
                echo "#000000";
            }?>" style="width:10em;" form="main_client_presentation_infos_form">
        </div>
        <div class="col-md-1" style="background-color:<?php 
            if(!empty($main_client_color['color_1']))
            {
                echo $main_client_color['color_1'];
            }
            else
            {
                echo "#000000";
            }?>">

        </div>
    </div>
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-5">
            <label for="main_client_color_8"><b>Text 2</b> (<i>Col. 8</i>)</label>
        </div>
        <div class="col-md-4">
            <input id="main_client_color_8" name="main_client_color_8" type="text" class="form-control form-control-sm" placeholder="(Default #ffffff)" value="<?php 
            if(!empty($main_client_color['color_8']))
            {
                echo $main_client_color['color_8'];
            }
            else
            {
                echo "#ffffff";
            }?>" style="width:10em;" form="main_client_presentation_infos_form">
        </div>

        <div class="col-md-1" style="background-color:<?php 
            if(!empty($main_client_color['color_8']))
            {
                echo $main_client_color['color_8'];
            }
            else
            {
                echo "#ffffff";
            }?>">

        </div>

    </div>
    <div class="row w-100 mx-0 py-2">
            <div class="col-md-5">
                <label for="main_client_color_10"><b>Text 3</b> (<i>Col. 10</i>)</label>
            </div>
            <div class="col-md-4">
                <input id="main_client_color_10" name="main_client_color_10" type="text" class="form-control form-control-sm" placeholder="(Default #6608ef)" value="<?php 
                if(!empty($main_client_color['color_10']))
                {
                    echo $main_client_color['color_10'];
                }
                else
                {
                    echo "#000000";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>

            <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_10']))
                {
                    echo $main_client_color['color_10'];
                }
                else
                {
                    echo "#000000";
                }?>">

            </div>

        </div>
    <div class="row w-100 mx-0 py-2">
            <div class="col-md-5">
                <label for="main_client_link_text_color"><b>Link basic</b> (<i>Col. 2</i>)</label>
            </div>
            <div class="col-md-4">
                <input id="main_client_link_text_color" name="main_client_link_text_color" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
                if(!empty($main_client_color['color_2']))
                {
                    echo $main_client_color['color_2'];
                }
                else
                {
                    echo "#000000";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>

            <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_2']))
                {
                    echo $main_client_color['color_2'];
                }
                else
                {
                    echo "#000000";
                }?>">

            </div>

        </div>

        <div class="row w-100 mx-0 py-2">
            <div class="col-md-5">
                <label for="main_client_link_hover_text_color2"><b>Link hovered</b> (<i>Col. 6</i>)</label>
            </div>
            <div class="col-md-4">
                <input id="main_client_link_hover_text_color2" name="main_client_link_hover_text_color2" type="text" class="form-control form-control-sm" placeholder="(Default #24B04D)" value="<?php 
                if(!empty($main_client_color['color_6']))
                {
                    echo $main_client_color['color_6'];
                }
                else
                {
                    echo "#939393";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>

            <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_6']))
                {
                    echo $main_client_color['color_6'];
                }
                else
                {
                    echo "#939393";
                }?>">

            </div>

        </div>

        <div class="row w-100 mx-0 py-2">
            <div class="col-md-5">
                <label for="main_client_text_color3"><b>Link clicked</b> (<i>Col. 3</i>)</label>
            </div>
            <div class="col-md-4">
                <input id="main_client_text_color3" name="main_client_text_color3" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
                if(!empty($main_client_color['color_3']))
                {
                    echo $main_client_color['color_3'];
                }
                else
                {
                    echo "#24B04D";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>
            <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_3']))
                {
                    echo $main_client_color['color_3'];
                }
                else
                {
                    echo "#24B04D";
                }?>">                

            </div>

        </div>

    </div>

    <div class="col-md-6">

        	
        <div class="row w-100 mx-0 py-2">
            <div class="col-md-4">
                <label for="logo_path">Main client Favicon</label>
                <img src="<?php 
                if(!empty($main_client['mc_favicon_path']))
                {
                    echo $main_client['mc_favicon_path'];
                }
                else
                {
                    echo "https://domenia.cseven.eu/mc_logos/logo_PLITT_real&virtual_ESTATE_Ltd..png";
                }?>" width="60" height="60">
            </div>
            <div class="col-md-8">
                <input id="mc_favicon_path" name="mc_favicon_path" type="text" class="form-control form-control-sm" placeholder="Link will be here" value="<?php echo $main_client['mc_favicon_path'];?>" disabled>
                Upload favicon file (jpg, png, ico...)
                <input id="mc_favicon_path2" name="mc_favicon_path2" type="file" class="form-control form-control-sm" form="main_client_presentation_infos_form">
            </div>
        </div>	
        <div class="row w-100 mx-0 py-2">
            <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_5']))
                {
                    echo $main_client_color['color_5'];
                }
                else
                {
                    echo "#ffffff";
                }?>">

            </div>
            <div class="col-md-4">
                <input id="main_client_background_color" name="main_client_background_color" type="text" class="form-control form-control-sm" placeholder="(Default #ffffff)" value="<?php 
                if(!empty($main_client_color['color_5']))
                {
                    echo $main_client_color['color_5'];
                }
                else
                {
                    echo "#ffffff";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>
            <div class="col-md-5">
                <label for="main_client_background_color"><b>Background 1</b> (<i>Col. 5</i>)</label>
            </div>
            

            
        </div>	
        
        
        

        <div class="row w-100 mx-0 py-2">
            <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_7']))
                {
                    echo $main_client_color['color_7'];
                }
                else
                {
                    echo "#939393";
                }?>">

            </div>
            <div class="col-md-4">
                <input id="main_client_color_7" name="main_client_color_7" type="text" class="form-control form-control-sm" placeholder="(Default #765312)" value="<?php 
                if(!empty($main_client_color['color_7']))
                {
                    echo $main_client_color['color_7'];
                }
                else
                {
                    echo "#939393";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>
            <div class="col-md-5">
                <label for="main_client_color_7"><b>Background 2</b> (<i>Col. 7</i>)</label>
            </div>

        </div>
        
        <div class="row w-100 mx-0 py-2">
        <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_9']))
                {
                    echo $main_client_color['color_9'];
                }
                else
                {
                    echo "#ffffff";
                }?>">

            </div>
            <div class="col-md-4">
                <input id="main_client_color_9" name="main_client_color_9" type="text" class="form-control form-control-sm" placeholder="(Default #6608ef)" value="<?php 
                if(!empty($main_client_color['color_9']))
                {
                    echo $main_client_color['color_9'];
                }
                else
                {
                    echo "#ffffff";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>
            <div class="col-md-5">
                <label for="main_client_color_9"><b>Background 3</b> (<i>Col. 9</i>)</label>
            </div>           

        </div>

        <div class="row w-100 mx-0 py-2">
            <div class="col-md-1" style="background-color:<?php
            if(!empty($main_client_color['color_11']))
            {
                echo $main_client_color['color_11'];
            }
            else
            {
                echo "#000000";
            }?>">

            </div>
            <div class="col-md-4">
                <input id="main_client_color_11" name="main_client_color_11" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php
                if(!empty($main_client_color['color_11']))
                {
                    echo $main_client_color['color_11'];
                }
                else
                {
                    echo "#000000";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>
            <div class="col-md-5">
                <label for="main_client_color_11"><b>Background 4</b> (For Bauvorschau intern, <i>Col. 11</i>)</label>
            </div>


        </div>


        <div class="row w-100 mx-0 py-2">
            <div class="col-md-1" style="background-color:<?php 
                if(!empty($main_client_color['color_4']))
                {
                    echo $main_client_color['color_4'];
                }
                else
                {
                    echo "#000000";
                }?>">

            </div>
            <div class="col-md-4">
                <input id="main_client_picture_shadow_color" name="main_client_picture_shadow_color" type="text" class="form-control form-control-sm" placeholder="(Default #000000)" value="<?php 
                if(!empty($main_client_color['color_4']))
                {
                    echo $main_client_color['color_4'];
                }
                else
                {
                    echo "#000000";
                }?>" style="width:10em;" form="main_client_presentation_infos_form">
            </div>
            <div class="col-md-5">
                <label for="main_client_picture_shadow_color"><b>Shadow</b> (<i>Col. 4</i>)</label>
            </div>
            
            
        </div>

    </div> <!-- end main client colors -->
    <?php
    } 
    ?>
    </div> <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="row w-100 mx-0 py-2">
                <div class="col-md-5">
                    <b>Font-family</b>
                </div>
                <div class="col-md-7">
                    <input type="text" id="main_client_font_family" name="main_client_font_family" class="form-control form-control-sm" value="<?php echo $main_client_color['font_family'];?>" form="main_client_presentation_infos_form">
                </div>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <br>
    <hr class="border border-dark border-3">
   
    <div class="row w-100 mx-0">
        <div class="col-md-12 text-center">
            <b>Main clients settings for B3</b>
        </div>
    </div>
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-6 text-center">
            <div class="row">
                <div class="col-md-12">
                    <b>Shapeline</b>
                    <select name="sl_id" id="sl_id" class="form-control form-control-sm d-inline" form="main_client_presentation_infos_form" style="width:200px;">
                        <option value="">None</option>
                    <?php 
                    $all_b3_shapes=$domenia3n->get_all_b3_shapes();                    
                   
                    if(!empty($all_b3_shapes))
                    {
                        for($i=0;$i<count($all_b3_shapes);$i++)
                        {
                        ?>
                        <option value="<?php echo $all_b3_shapes[$i]['sl_id'];?>" <?php echo ($all_b3_shapes[$i]['sl_id']==$main_client_color['sl_id'])?"selected":"";?>><?php echo $all_b3_shapes[$i]['sl_id']." - ".$all_b3_shapes[$i]['sl_name'];?></option>
                        <?php
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <b>Colorset</b>
                    <select name="cls_id" id="cls_id" class="form-control form-control-sm d-inline" form="main_client_presentation_infos_form" style="width:200px;">
                        <option value="">None</option>
                    <?php             
                    $all_b3_colorset=$domenia3n->get_all_b3_colorsets();
                    
                    if(!empty($all_b3_colorset))
                    {
                        for($i=0;$i<count($all_b3_colorset);$i++)
                        {                            
                            ?>
                            <option value="<?php echo $all_b3_colorset[$i]['cls_id'];?>" <?php echo ($all_b3_colorset[$i]['cls_id']==$main_client_color['cls_id'])?"selected":"";?>><?php echo $all_b3_colorset[$i]['cls_id']." - ".$all_b3_colorset[$i]['cls_name'];?></option>
                            <?php                           
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <div id="b3_colorset_examples">
            </div>
            <script type="text/javascript">

                $(document).ready(function(){

                    load_b3_colorset_examples();

                });

                $('#sl_id').change(function(){

                    load_b3_colorset_examples();

                });

                $('#cls_id').change(function(){

                    load_b3_colorset_examples();

                });

                function load_b3_colorset_examples()
                {
                    let sl_id=$('#sl_id').val();
                    let cls_id=$('#cls_id').val();

                    if((sl_id!="")&&(cls_id!=""))
                    {

                        $.ajax({
                            url: "../ajax/get_b3_colorset_examples_html.php",
                            method: "get",
                            data: {sl_id:sl_id,cls_id:cls_id},
                            dataType:"html",
                            success:function(data) {
                                $('#b3_colorset_examples').html(data);
                            }
                        });

                    }
                }
            </script>
        </div>
    </div>
    <div class="row">
        <div class="row w-100 mx-0 py-2">
            <div class="col-md-12 text-center">
                <?php
                if($client['mc_id']!=0)
                {
                ?>
                <button id="main_client_presentation_infos_save_btn" name="main_client_presentation_infos_save_btn" class="btn btn-sm btn-primary" form="main_client_presentation_infos_form">Save for main client</button>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <br>
    <hr class="border border-dark border-3">
    <br>
    <div class="row">
        <div class="col-md-auto">
            <b>Last 3 orders for this client</b>
        </div>
        <?php
        $orders=$prod->get_client_orders($clientid,0,3);

        if(!empty($orders))
        {
            for($o=0;$o<count($orders);$o++)
            {
            ?>
            <div class="col-md-2">
                <a href="https://bauvorschau.com/<?php echo $orders[$o]['order_ID'];?>" class="btn btn-sm btn-primary" target="_blank">Order ID <?php echo $orders[$o]['order_ID'];?></a>
            </div>
            <?php
            }
        }
        ?>
    </div>
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
        <a href="<?php echo $base_url;?>login.php" class="btn btn-danger btn-sm">Login</a>
        <br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
	<?php
}
?>
</div> <!-- end container -->
</article>
</section>
<?php
include('../footer.php');
?>