<?php
include('../functions.php');
$prod = new Production;

$data['name'] = $prod->xss_fix($_POST['new_fto_name_input']);
$data['description'] = $prod->xss_fix($_POST['new_fto_description_input']);
$data['price'] = $prod->xss_fix($_POST['new_fto_price_input']);
$data['category'] = $prod->xss_fix($_POST['new_fto_category_input']);
$data['producer'] = $prod->xss_fix($_POST['new_fto_producer_input']);
$data['trader'] = $prod->xss_fix($_POST['new_fto_trader_input']);
$data['ftto_page']=$prod->xss_fix($_POST['new_link_to_trader_input']);
$data['f_source']=$prod->xss_fix($_POST['new_f_source_input']);
$data['fs_date']=$prod->xss_fix($_POST['new_fs_date_input']);
$data['fs_price']=$prod->xss_fix($_POST['new_fs_price_input']);
$data['fs_remarks']=$prod->xss_fix($_POST['new_fs_remarks_input']);
$data['owner'] = $prod->xss_fix($_POST['new_owner_input']);
$data['creator'] = $prod->xss_fix($_POST['new_creator_input']);


$result_files_dir="../furniture_model_files/";

$year=date("Y");
$validextensions=array("jpg","jpeg","png");
$output_dir=$result_files_dir.$year;
$furniture_model_files="furniture_model_files/".$year;

if(!file_exists($output_dir)) {
    mkdir($output_dir, 0755, true);
}

$original_file_name = $_FILES["new_thumbnail_file_input"]["name"];

$tempfile=explode(".",$original_file_name);
$file_extension=strtolower(end($tempfile));

if(in_array($file_extension,$validextensions))
{
    $internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

    $what = getimagesize($_FILES["new_thumbnail_file_input"]["tmp_name"]);

    $width=$what[0];
    $height=$what[1];

    $desired_height = 100;
    $desired_width=floor( $width * ($desired_height / $height));


    switch(strtolower($what['mime']))
    {
        case 'image/png':
            $img = imagecreatefrompng($_FILES["new_thumbnail_file_input"]["tmp_name"]);
            $new = imagecreatetruecolor($desired_width,$desired_height);
            imagecopyresampled($new,$img,0,0,0,0,$desired_width,$desired_height,$width,$height);
            header('Content-Type: image/png');
        break;
        case 'image/jpeg':
            $img = imagecreatefromjpeg($_FILES["new_thumbnail_file_input"]["tmp_name"]);
            $new = imagecreatetruecolor($desired_width,$desired_height);
            imagecopyresampled($new,$img,0,0,0,0,$desired_width,$desired_height,$width,$height);
            header('Content-Type: image/jpeg');
        break;
        case 'image/gif':
            $img = imagecreatefromgif($_FILES["new_thumbnail_file_input"]["tmp_name"]);
            $new = imagecreatetruecolor($desired_width,$desired_height);
            imagecopyresampled($new,$img,0,0,0,0,$desired_width,$desired_height,$width,$height);
            header('Content-Type: image/gif');
        break;
        default: die();
    }

    imagejpeg($new,$output_dir."/".$internal_file_name);
    imagedestroy($new);

    //move_uploaded_file($_FILES["new_thumbnail_file_input"]["tmp_name"],$output_dir."/".$internal_file_name);

    $data['fs_thumbnail']=$furniture_model_files."/".$internal_file_name;
}


$prod->add_ft_object(json_encode($data));
?>