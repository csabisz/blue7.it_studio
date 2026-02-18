<?php
include('functions.php');
$prod = new Production;

$filecategory = $_GET['filecategory'];
$year = date("Y");
$upload_date = gmdate("Y-m-d H:i:s");

// if (isset($_FILES["myfile"])) 
// {
    $ret = array();

    if ($filecategory == "creatorfiles") 
    {

        $watermark_streif="img/watermark_streif.png";

        $orderid = $prod->xss_fix($_GET['o_id']);
        $osub_id = $prod->xss_fix($_GET['osub_id']);
        $prod_id = $prod->xss_fix($_GET['prod_id']);
        $uca_id = $prod->xss_fix($_GET['uca_id']);

        if(!empty($_POST['chosen_classification_id']))
        {
            $chosen_classification_id=$_POST['chosen_classification_id'];
        }
        else
        {
            if(!is_array($_FILES["myfile"]["name"]))
            {
                $chosen_classification_id="";
            }
            else
            {
                $chosen_classification_id=array();
            }            
        }
        if(!empty($_POST['chosen_shape_id']))
        {
            $chosen_shape_id=$_POST['chosen_shape_id'];
        }
        else
        {
            if(!is_array($_FILES["myfile"]["name"]))
            {
                $chosen_shape_id="";
            }
            else
            {
                $chosen_shape_id=array();
            }
        }
        if(!empty($_POST['chosen_main_img_id']))
        {
            $chosen_main_img_id=$_POST['chosen_main_img_id'];
        }
        else
        {
            if(!is_array($_FILES["myfile"]["name"]))
            {
                $chosen_main_img_id="";
            }
            else
            {
                $chosen_main_img_id=array();
            }
        }

        $order = $prod->get_order($orderid);
        
        $result_files_dir = "result_files/";

        $thumbnail_files_dir = "result_thumbnail_files/";
        $compress_files_dir = "result_compress_files/";

        $thumbnail_output_dir = $thumbnail_files_dir . $year . "/" . $orderid . "/" . $orderid . "." . $osub_id . "." . $prod_id;
        $compress_output_dir = $compress_files_dir . $year . "/" . $orderid . "/" . $orderid . "." . $osub_id . "." . $prod_id;
        $file_path = $year . "/" . $orderid . "/" . $orderid . "." . $osub_id . "." . $prod_id . "/";

        $output_dir = $result_files_dir . $year . "/" . $orderid . "/" . $orderid . "." . $osub_id . "." . $prod_id;
        $thumbnail_file_path = $year . "/" . $orderid . "/" . $orderid . "." . $osub_id . "." . $prod_id . "/";
        $compress_file_path = $year . "/" . $orderid . "/" . $orderid . "." . $osub_id . "." . $prod_id . "/";

        $validextensions = array("jpg", "jpeg","webp", "png","eps", "pdf", "svg", "exr", "psd", "txt","dwg");

        $thumbnail_validextensions = array("jpg", "jpeg", "png");
        $compress_validextensions = array("jpg", "jpeg", "png");


        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0777, true);
        }

        if ((strpos($prod_id, "p1301") !== false) || (strpos($prod_id, "p1321") !== false)) {
            $validextensions = array("cdr", "dwg","skp","layout");
        }

        if ((strpos($prod_id, "p1501") !== false) || (strpos($prod_id, "p1521") !== false) || (strpos($prod_id, "p1541") !== false) || 
        (strpos($prod_id, "p1561") !== false) || (strpos($prod_id, "p1562") !== false) || (strpos($prod_id, "p1581") !== false)) {
            $validextensions = array("skp","tm" ,"max", "fbx","ifc","glb","gltf", "dwg","dxf");
        }

        if ((strpos($prod_id, "p1600") !== false) || (strpos($prod_id, "p1660") !== false)) {
            $validextensions = array("skp", "c4d", "fbx","ifc");
        }

        if ((strpos($prod_id, "p1700") !== false) || (strpos($prod_id, "p1760") !== false)) {
            $validextensions = array("skp", "max", "c4d", "fbx","ifc");
        }
        if ((strpos($prod_id, "p1800") !== false) || (strpos($prod_id, "p1860") !== false)) {
            $validextensions = array("skp", "max", "c4d", "ls9", "tm", "fbx","ifc");
        }
        if ((strpos($prod_id, "p1601") !== false) || (strpos($prod_id, "p1621") !== false) || (strpos($prod_id, "p1641") !== false) || 
        (strpos($prod_id, "p1661") !== false) || (strpos($prod_id, "p1662") !== false) || (strpos($prod_id, "p1681") !== false)) {
            $validextensions = array("c4d","tm" ,"skp", "fbx","ifc");
        }
        if ((strpos($prod_id, "p1801") !== false) || (strpos($prod_id, "p1821") !== false) || 
        (strpos($prod_id, "p1841") !== false) || (strpos($prod_id, "p1861") !== false) || (strpos($prod_id, "p1862") !== false) || 
        (strpos($prod_id, "p1881") !== false)) {
            $validextensions = array("skp","tm", "ls9", "fbx","ifc");
        }
        if ((strpos($prod_id, "p1701") !== false) || (strpos($prod_id, "p1721") !== false) || (strpos($prod_id, "p1741") !== false) || (strpos($prod_id, "p1761") !== false) || (strpos($prod_id, "p1762") !== false) || (strpos($prod_id, "p1781") !== false)) {
            $validextensions = array("max", "c4d", "skp", "fbx","ifc","dwg");
        }
        if ((strpos($prod_id, "p1867") !== false) || (strpos($prod_id, "p1767") !== false) || (strpos($prod_id, "p1667") !== false) || (strpos($prod_id, "p1567") !== false) ||
            (strpos($prod_id, "p1507") !== false) || (strpos($prod_id, "p1527") !== false) || (strpos($prod_id, "p1547") !== false) ||
            (strpos($prod_id, "p1607") !== false) || (strpos($prod_id, "p1627") !== false) || (strpos($prod_id, "p1647") !== false) ||
            (strpos($prod_id, "p1707") !== false) || (strpos($prod_id, "p1727") !== false) || (strpos($prod_id, "p1747") !== false) ||
            (strpos($prod_id, "p1807") !== false) || (strpos($prod_id, "p1827") !== false) || (strpos($prod_id, "p1847") !== false)) {
            $validextensions = array("mp4", "mov");
        }
        if ((strpos($prod_id, "p1108") !== false) || (strpos($prod_id, "p1168") !== false) || (strpos($prod_id, "p1508") !== false) || (strpos($prod_id, "p1528") !== false) || (strpos($prod_id, "p1548") !== false) || (strpos($prod_id, "p1568") !== false) || (strpos($prod_id, "p1608") !== false) || (strpos($prod_id, "p1628") !== false) || (strpos($prod_id, "p1648") !== false) || (strpos($prod_id, "p1668") !== false) || (strpos($prod_id, "p1708") !== false) || (strpos($prod_id, "p1728") !== false) || (strpos($prod_id, "p1748") !== false) || (strpos($prod_id, "p1768") !== false) || (strpos($prod_id, "p1768") !== false) || (strpos($prod_id, "p1868") !== false)) {
            $validextensions = array("zip", "mp4", "mov");
        }
        if ((strpos($prod_id, "p156x") !== false) || (strpos($prod_id, "p166x") !== false) ||
            (strpos($prod_id, "p176x") !== false) || (strpos($prod_id, "p186x") !== false)) {
            $validextensions = array("fbx", "glb");
        }

        if ((strpos($prod_id, "p156y") !== false) || (strpos($prod_id, "p166y") !== false) ||
            (strpos($prod_id, "p176y") !== false) || (strpos($prod_id, "p186y") !== false)) {
            $validextensions = array("jpg", "jpeg","png");
        }

        //	This is for custom errors;
        /*	$custom_error= array();
            $custom_error['jquery-upload-file-error']="File already exists";
            echo json_encode($custom_error);
            die();
        */
        $error = $_FILES["myfile"]["error"];
        //You need to handle  both cases
        //If Any browser does not support serializing of multiple files using FormData()

        $uploaded_files = $prod->show_results($orderid, $osub_id, $prod_id);

        $nr_files = count($uploaded_files);
        /*
        if (!is_array($_FILES["myfile"]["name"])) //single file
        {
            ++$nr_files;

            $original_file_name = $_FILES["myfile"]["name"];

            $tempfile = explode(".", $original_file_name);
            $file_extension = strtolower(end($tempfile));

            if (in_array($file_extension, $validextensions)) {
                if ($file_extension != "zip") //no zip file
                {
                    $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;


                    if ($order['om_id'] == 0) {
                        $original_file_name = $orderid . "." . $osub_id . "." . $prod_id . " - " . $nr_files . "." . $file_extension;
                        $thumbnail_file_name = $internal_file_name . "_thumb." . $file_extension;
                        $compress_file_name = $internal_file_name . "_compress." . $file_extension;
                    } else {
                        $original_file_name = $order['om_id'] . "." . $osub_id . "." . $prod_id . " - " . $nr_files . "." . $file_extension;
                        $thumbnail_file_name = $internal_file_name . "_thumb." . $file_extension;
                        $compress_file_name = $internal_file_name . "_compress." . $file_extension;
                    }

                   
                    
                    //thumbnail stuff
                    if (in_array($file_extension, $thumbnail_validextensions)) 
                    {
                        if (!file_exists($thumbnail_output_dir)) {
                            mkdir($thumbnail_output_dir, 0777, true);
                        }
                        
                        $what = getimagesize($_FILES["myfile"]["tmp_name"]);

                        $width = $what[0];
                        $height = $what[1];

                        // $desired_width=400;
                        // $desired_height = floor($height * ($desired_width / $width));
                        $desired_height = 145;
                        $desired_width = floor($width * ($desired_height / $height));


                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($new, true);
                                $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                imagefill($new, 0, 0, $color);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                imagepng($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($new, true);
                                imageresolution($new, 72);
                                header('Content-Type: image/jpeg');
                                imagejpeg($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);

                               
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                imagegif($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
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
                    }
                    //end thumbnail stuff

                    //compresing stuff
                    if (in_array($file_extension, $compress_validextensions)) 
                    {
                        if (!file_exists($compress_output_dir)) {
                            mkdir($compress_output_dir, 0777, true);
                        }

                        $quality = 90;
                        $png_quality=8;

                        $what = getimagesize($_FILES["myfile"]["tmp_name"]);

                        $width = $what[0];
                        $height = $what[1];

                        if(substr_compare($prod_id, '6', -1) === 0)
                        {
                            if(($width>6000)&&($height>3000))
                            {
                                $desired_width = 6000;
                                $desired_height = 3000;

                                switch (strtolower($what['mime'])) {
                                    case 'image/png':
                                        $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"]);
                                        $new = imagecreatetruecolor($desired_width, $desired_height);
                                        imagesavealpha($new, true);
                                        $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                        imagefill($new, 0, 0, $color);
                                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/png');
                                        imagepng($new, $compress_output_dir . "/" . $compress_file_name, $png_quality);
                                        break;
                                    case 'image/jpeg':
                                        $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                        $new = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        imageinterlace($new, true);
                                        imageresolution($new, 72);
                                        header('Content-Type: image/jpeg');
                                        imagejpeg($new, $compress_output_dir . "/" . $compress_file_name, $quality);
                                        break;
                                    case 'image/gif':
                                        $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                        $new = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/gif');
                                        imagegif($new, $compress_output_dir . "/" . $compress_file_name);
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

                            }
                            elseif(($width<=6000)&&($height<=3000))
                            {
                                $desired_width = $width;
                                $desired_height = $height;

                                switch (strtolower($what['mime'])) {
                                    case 'image/png':
                                        $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"]);
                                        $new = imagecreatetruecolor($desired_width, $desired_height);
                                        imagesavealpha($new, true);
                                        $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                        imagefill($new, 0, 0, $color);
                                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/png');
                                        imagepng($new, $compress_output_dir . "/" . $compress_file_name, $png_quality);
                                        break;
                                    case 'image/jpeg':
                                        $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                        $new = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        imageinterlace($new, true);
                                        imageresolution($new, 72);
                                        header('Content-Type: image/jpeg');
                                        imagejpeg($new, $compress_output_dir . "/" . $compress_file_name,$quality);
                                        break;
                                   
                                    case 'image/gif':
                                        $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                        $new = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/gif');
                                        imagegif($new, $compress_output_dir . "/" . $compress_file_name);
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
                            }
                        }
                        else
                        {
                        $first_divider=$width / 1920;
                        $second_divider=$height / 1080;

                        if($first_divider>$second_divider)
                        {
                            $new_divider=$first_divider;
                        }   
                        else
                        {
                            $new_divider=$second_divider;
                        }
                        
                        $desired_height = $height/$new_divider;
                        $desired_width = $width/$new_divider;


                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($new, true);
                                $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                imagefill($new, 0, 0, $color);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                imagepng($new, $compress_output_dir . "/" . $compress_file_name, $png_quality);
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($new, true);
                                imageresolution($new, 72);
                                header('Content-Type: image/jpeg');
                                imagejpeg($new, $compress_output_dir . "/" . $compress_file_name, $quality);

                                break;
                           
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                imagegif($new, $compress_output_dir . "/" . $compress_file_name);
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
                        }
                    }
                    //end compress stuff

                    // purification start
                    if(
                    (substr_compare($prod_id, '3', -1) === 0 )||
                    (substr_compare($prod_id, '4', -1) === 0 )||
                    (substr_compare($prod_id, 'y', -1) === 0 )
                    ) //$string, $substring, -$length
                    {
                        $quality = 100;
                        $png_quality=6; // 0 no compression, 9 high compression

                        $what = getimagesize($_FILES["myfile"]["tmp_name"]);

                        $width = $what[0];
                        $height = $what[1];
                        
                        $desired_height = $height; //just to not change the variables in the functions we let it like it is
                        $desired_width = $width;


                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($new, true);
                                $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                imagefill($new, 0, 0, $color);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                imagepng($new, $output_dir . "/" . $internal_file_name, $png_quality);
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($new, true);
                                imageresolution($new, 72);
                                header('Content-Type: image/jpeg');
                                imagejpeg($new, $output_dir . "/" . $internal_file_name, $quality);

                               
                                break;
                            case 'image/webp':
                                move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . "/" . $internal_file_name);
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                imagegif($new, $output_dir . "/" . $internal_file_name);
                                break;
                            default:
                                die();
                        }

                      
                        
                        //imagejpeg($new, $output_dir . "/" . $internal_file_name, $quality);
                        //clearing memory maybe ?
                        imagedestroy($new);
                        $what=null;
                        $width = null;
                        $height = null;
                        $img=null;
                    }
                    elseif(substr_compare($prod_id, '6', -1) === 0 )
                    {
                        $quality = 99;
                        $png_quality=8; // 0 no compression, 9 high compression

                        $what = getimagesize($_FILES["myfile"]["tmp_name"]);

                        $width = $what[0];
                        $height = $what[1];
                        
                        
                        $desired_height = $height; //just to not change the variables in the functions we let it like it is
                        $desired_width = $width;


                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($new, true);
                                $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                imagefill($new, 0, 0, $color);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                imagepng($new, $output_dir . "/" . $internal_file_name, $png_quality);
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageresolution($new, 72);
                                imageinterlace($new, true);
                                header('Content-Type: image/jpeg');
                                imagejpeg($new, $output_dir . "/" . $internal_file_name, $quality);
                                break;
                           
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                imagegif($new, $output_dir . "/" . $internal_file_name);
                                break;
                            default:
                                die();
                        }
               
                        //clearing memory maybe ?
                        imagedestroy($new);
                        $what=null;
                       
                        $img=null;
                       
                    }                    
                    else
                    {
                        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . "/" . $internal_file_name);
                    }

                    

                    $data['o_id'] = $orderid;
                    $data['uca_id'] = $uca_id;
                    $data['om_id'] = $order['om_id'];
                    $data['osub_id'] = $osub_id;
                    $data['prod_id'] = $prod_id;
                    $data['config_level'] = $chosen_classification_id;
                    if((empty($chosen_main_img_id))&&(empty($chosen_shape_id)))
                    {
                        $data['pict_categ_name'] = "";
                    }
                    else
                    {
                        $data['pict_categ_name'] = $chosen_main_img_id.".".$chosen_shape_id;
                    }
                    
                    $data['orf_name'] = $original_file_name;
                    $data['orf_internal_name_dom'] = $internal_file_name;
                    $data['orf_type_dom'] = $file_extension;
                    $data['orf_path_dom'] = $file_path;
                    $data['orf_upload_date'] = $upload_date;
                    $data['orf_status'] = 0;
                    if (in_array($file_extension, $thumbnail_validextensions)) {
                        $data['orf_thumbnail_path'] = $thumbnail_file_path . $thumbnail_file_name;
                    } else {
                        $data['orf_thumbnail_path'] = "";
                    }
                    if (in_array($file_extension, $compress_validextensions)) {
                        $data['orf_compress_path'] = $compress_file_path . $compress_file_name;
                    } else {
                        $data['orf_compress_path'] = "";
                    }

                    $prod->upload_creator_result_file3(json_encode($data));

        

                    $ret[] = $internal_file_name;
                } else {
                    $zip = new ZipArchive;
                    if ($zip->open($_FILES["myfile"]["tmp_name"]) === TRUE) {
                        $zip->extractTo($output_dir . "/");
                        $zip->close();
                    }

                    $data['o_id'] = $orderid;
                    $data['uca_id'] = $uca_id;
                    $data['om_id'] = $order['om_id'];
                    $data['osub_id'] = $osub_id;
                    $data['prod_id'] = $prod_id;
                    $data['config_level'] = $chosen_classification_id;
                    if((empty($chosen_main_img_id))&&(empty($chosen_shape_id)))
                    {
                        $data['pict_categ_name'] = "";
                    }
                    else
                    {
                        $data['pict_categ_name'] = $chosen_main_img_id.".".$chosen_shape_id;
                    }
                    $data['orf_name'] = "index.html";
                    $data['orf_internal_name_dom'] = "index.html";
                    $data['orf_type_dom'] = "html";
                    $data['orf_path_dom'] = $file_path;
                    $data['orf_upload_date'] = $upload_date;
                    $data['orf_thumbnail_path'] = "";
                    $data['orf_compress_path'] = "";


                    $prod->upload_creator_result_file3(json_encode($data));

                    $latest_orf_id=$prod->show_results_by_date_reverse_order($orderid, $osub_id, $prod_id);

                    $configurator_plus_data['o_id_full']=$orderid.".".$osub_id.".".$prod_id;
                    $configurator_plus_data['orf_id']=$latest_orf_id[0]['orf_id'];
                    $configurator_plus_data['pa_id']=$chosen_classification_id;
                    $configurator_plus_data['pa_symbol']=$chosen_shape_id;
                    $configurator_plus_data['connected_to']=$chosen_main_img_id;

                    //$prod->insert_o_results_configurator_plus(json_encode($configurator_plus_data));

                    $check_o_results_configurator_plus=$prod->get_o_results_configurator_plus($configurator_plus_data['orf_id']);

                    if(!empty($check_o_results_configurator_plus))
                    {
                        $prod->update_o_results_configurator_plus(json_encode($configurator_plus_data));
                    }
                    else
                    {
                        $prod->insert_o_results_configurator_plus(json_encode($configurator_plus_data));
                    }
                }
            } else {
                $custom_error = array();
                $custom_error['jquery-upload-file-error'] = "Invalid uploaded file for this category. Contact administrator for instructions.";
                echo json_encode($custom_error);
                die();
            }
        } */
        // else  //Multiple files, file[]
        // {
            $fileCount = count($_FILES["myfile"]["name"]);
            ++$nr_files;
            //print_r($_FILES);
            for ($i = 0; $i < $fileCount; $i++) 
            {
                $original_file_name = $_FILES["myfile"]["name"][$i];

                
                $tempfile = explode(".", $original_file_name);
                $file_extension = strtolower(end($tempfile));

                if (in_array($file_extension, $validextensions)) 
                {

                    $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

                    if ($order['om_id'] == 0) 
                    {
                        $original_file_name = $orderid . "." . $osub_id . "." . $prod_id . " - " . $nr_files . "." . $file_extension;
                        $thumbnail_file_name = $internal_file_name . "_thumb." . $file_extension;
                        $compress_file_name = $internal_file_name . "_compress." . $file_extension;
                    } 
                    else 
                    {
                        $original_file_name = $order['om_id'] . "." . $osub_id . "." . $prod_id . " - " . $nr_files . "." . $file_extension;
                        $compress_file_name = $internal_file_name . "_compress." . $file_extension;
                    }

                    //thumbnail stuff
                    if (in_array($file_extension, $thumbnail_validextensions)) 
                    {
                        if (!file_exists($thumbnail_output_dir)) {
                            mkdir($thumbnail_output_dir, 0777, true);
                        }

                        $what = getimagesize($_FILES["myfile"]["tmp_name"][$i]);

                        $width = $what[0];
                        $height = $what[1];

                        $desired_width = 145;
                        $desired_height = floor($height * ($desired_width / $width));

                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                $thumbnail_new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($thumbnail_new, true);
                                $color = imagecolorallocatealpha($thumbnail_new, 0, 0, 0, 127);
                                imagefill($thumbnail_new, 0, 0, $color);
                                imagecopyresampled($thumbnail_new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                imagepng($thumbnail_new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                $thumbnail_new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($thumbnail_new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($thumbnail_new, true);
                                imageresolution($thumbnail_new, 72);
                                header('Content-Type: image/jpeg');
                                imagejpeg($thumbnail_new, $thumbnail_output_dir . "/" . $thumbnail_file_name);                                
                                break;
                            case 'image/webp':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                $thumbnail_new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($thumbnail_new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($thumbnail_new, true);
                                imageresolution($thumbnail_new, 72);
                                header('Content-Type: image/webp');
                                imagejpeg($thumbnail_new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                $thumbnail_new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($thumbnail_new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                imagegif($thumbnail_new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            default:
                                die();
                        }

                        //imagejpeg($thumbnail_new, $thumbnail_output_dir . "/" . $thumbnail_file_name);

                        // imagedestroy($thumbnail_new);
                        // $what=null;
                        // $width = null;
                        // $height = null;
                        // $img=null;
                    }
                    //end thumbnail stuff


                    //compress stuff
                    if (in_array($file_extension, $compress_validextensions)) 
                    {
                        if (!file_exists($compress_output_dir)) {
                            mkdir($compress_output_dir, 0777, true);
                        }

                        $quality = 90;
                        $png_quality=8;

                        $what = getimagesize($_FILES["myfile"]["tmp_name"][$i]);

                        $width = $what[0];
                        $height = $what[1];

                        if(substr_compare($prod_id, '6', -1) === 0)
                        {
                            if(($width>=6000)&&($height>=3000))
                            {
                                echo $desired_width = 6000;
                                $desired_height = 3000;

                                switch (strtolower($what['mime'])) {
                                    case 'image/png':
                                        $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                        $compress_new1 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagesavealpha($compress_new1, true);
                                        $color = imagecolorallocatealpha($compress_new1, 0, 0, 0, 127);
                                        imagefill($compress_new1, 0, 0, $color);
                                        imagecopyresampled($compress_new1, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/png');
                                        imagepng($compress_new1, $compress_output_dir . "/" . $compress_file_name, $png_quality);
                                        break;
                                    case 'image/jpeg':
                                        $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                        $compress_new1 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($compress_new1, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        imageinterlace($compress_new1, true);
                                        imageresolution($compress_new1, 72);
                                        header('Content-Type: image/jpeg');
                                        imagejpeg($compress_new1, $compress_output_dir . "/" . $compress_file_name, $quality);
                                        break;
                                    case 'image/webp':
                                        $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                        $compress_new1 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($compress_new1, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        imageinterlace($compress_new1, true);
                                        imageresolution($compress_new1, 72);
                                        header('Content-Type: image/webp');
                                        imagejpeg($compress_new1, $compress_output_dir . "/" . $compress_file_name);
                                        break;
                                    case 'image/gif':
                                        $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                        $compress_new1 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($compress_new1, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/gif');
                                        imagegif($compress_new1, $compress_output_dir . "/" . $compress_file_name);
                                        break;
                                    default:
                                        die();
                                }

                                
                                // imagedestroy($compress_new1);
                                // $what=null;
                                // $width = null;
                                // $height = null;
                                // $img=null;
                            }
                            if(($width<6000)&&($height<3000))
                            {
                                

                                $desired_width = $width;
                                $desired_height = $height;

                                switch (strtolower($what['mime'])) {
                                    case 'image/png':
                                        $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                        $compress_new2 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagesavealpha($compress_new2, true);
                                        $color = imagecolorallocatealpha($compress_new2, 0, 0, 0, 127);
                                        imagefill($compress_new2, 0, 0, $color);
                                        imagecopyresampled($compress_new2, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/png');
                                        imagepng($compress_new2, $compress_output_dir . "/" . $compress_file_name, $png_quality);
                                        break;
                                    case 'image/jpeg':
                                        $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                        $compress_new2 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($compress_new2, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        imageinterlace($compress_new2, true);
                                        imageresolution($compress_new2, 72);
                                        header('Content-Type: image/jpeg');
                                        imagejpeg($compress_new2, $compress_output_dir . "/" .$compress_file_name, $quality);
                                        break;
                                    case 'image/webp':
                                        $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                        $compress_new2 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($compress_new2, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        imageinterlace($compress_new2, true);
                                        imageresolution($compress_new2, 72);
                                        header('Content-Type: image/webp');
                                        imagejpeg($compress_new2, $compress_output_dir . "/" . $compress_file_name);
                                        break;
                                    case 'image/gif':
                                        $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                        $compress_new2 = imagecreatetruecolor($desired_width, $desired_height);
                                        imagecopyresampled($compress_new2, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                        header('Content-Type: image/gif');
                                        imagegif($compress_new2, $compress_output_dir . "/" . $compress_file_name);
                                        break;
                                    default:
                                        die();
                                }

                                
                                // imagedestroy($new);
                                // $what=null;
                                // $width = null;
                                // $height = null;
                                // $img=null;
                            }
                        }
                        else
                        {
                            $first_divider=$width / 1920;
                            $second_divider=$height / 1080;

                            if($first_divider>$second_divider)
                            {
                                $new_divider=$first_divider;
                            }   
                            else
                            {
                                $new_divider=$second_divider;
                            }

                            $desired_width = (int)round($width/$new_divider);
                            $desired_height = (int)round($height/$new_divider);

                            switch (strtolower($what['mime'])) {
                                case 'image/png':
                                    $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                    $compress_new3 = imagecreatetruecolor($desired_width, $desired_height);
                                    imagesavealpha($compress_new3, true);
                                    $color = imagecolorallocatealpha($compress_new3, 0, 0, 0, 127);
                                    imagefill($compress_new3, 0, 0, $color);
                                    imagecopyresampled($compress_new3, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                    header('Content-Type: image/png');
                                    imagepng($compress_new3, $compress_output_dir . "/" . $compress_file_name, $png_quality);
                                    break;
                                case 'image/jpeg':
                                    $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                    $compress_new3 = imagecreatetruecolor($desired_width, $desired_height);
                                    imagecopyresampled($compress_new3, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                    imageinterlace($compress_new3, true);
                                    imageresolution($compress_new3, 72);
                                    header('Content-Type: image/jpeg');
                                    imagejpeg($compress_new3, $compress_output_dir . "/" .$compress_file_name, $quality);
                                    break;
                                case 'image/webp':
                                    $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                    $compress_new3 = imagecreatetruecolor($desired_width, $desired_height);
                                    imagecopyresampled($compress_new3, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                    imageinterlace($compress_new3, true);
                                    imageresolution($compress_new3, 72);
                                    header('Content-Type: image/webp');
                                    imagejpeg($compress_new3, $compress_output_dir . "/" . $compress_file_name);
                                    break;
                                case 'image/gif':
                                    $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                    $compress_new3 = imagecreatetruecolor($desired_width, $desired_height);
                                    imagecopyresampled($compress_new3, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                    header('Content-Type: image/gif');
                                    imagegif($compress_new3, $compress_output_dir . "/" . $compress_file_name);
                                    break;
                                default:
                                    die();
                            }

                            
                            // imagedestroy($compress_new3);
                            // $what=null;
                            // $width = null;
                            // $height = null;
                            // $img=null;
                        }
                    }
                    //end compress stuff

                    if(
                    (substr_compare($prod_id, '3', -1) === 0 )||
                    (substr_compare($prod_id, '4', -1) === 0 )||
                    (substr_compare($prod_id, 'y', -1) === 0 )
                    ) //$string, $substring, -$length
                    {
                        $quality = 100;
                        $png_quality=6; // 0 no compression, 9 high compression

                        $what = getimagesize($_FILES["myfile"]["tmp_name"][$i]);

                        $width = $what[0];
                        $height = $what[1];
                        
                        $desired_height = $height; //just to not change the variables in the functions we let it like it is
                        $desired_width = $width;


                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($new, true);
                                $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                imagefill($new, 0, 0, $color);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                imagepng($new, $output_dir . "/" . $internal_file_name, $png_quality);
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($new, true);
                                imageresolution($new, 72);
                                header('Content-Type: image/jpeg');
                                imagejpeg($new, $output_dir . "/" . $internal_file_name, $quality);
                                break;
                            case 'image/webp':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($new, true);
                                imageresolution($new, 72);
                                header('Content-Type: image/webp');
                                imagejpeg($new, $output_dir . "/" . $internal_file_name);
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                imagegif($new, $output_dir . "/" . $internal_file_name);
                                break;
                            default:
                                die();
                        }

                      
                    
                        //clearing memory maybe ?
                        // imagedestroy($new);
                        // $what=null;
                        // $width = null;
                        // $height = null;
                        // $img=null;
                    }
                    elseif(substr_compare($prod_id, '6', -1) === 0)
                    {
                        $quality = 99;
                        $png_quality=8; // 0 no compression, 9 high compression

                        $what = getimagesize($_FILES["myfile"]["tmp_name"][$i]);

                        $width = $what[0];
                        $height = $what[1];

                        $desired_height = $height; //just to not change the variables in the functions we let it like it is
                        $desired_width = $width;


                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                $compress_new4 = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($compress_new4, true);
                                $color = imagecolorallocatealpha($compress_new4, 0, 0, 0, 127);
                                imagefill($compress_new4, 0, 0, $color);
                                imagecopyresampled($compress_new4, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                imagepng($compress_new4, $output_dir . "/" . $internal_file_name, $png_quality);
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                $compress_new4 = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($compress_new4, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($compress_new4, true);
                                imageresolution($compress_new4, 72);
                                header('Content-Type: image/jpeg');
                                imagejpeg($compress_new4, $output_dir . "/" . $internal_file_name, $quality);
                                break;
                            case 'image/webp':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $compress_new4 = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($compress_new4, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                imageinterlace($compress_new4, true);
                                imageresolution($compress_new4, 72);
                                header('Content-Type: image/webp');
                                imagejpeg($compress_new4, $output_dir . "/" . $internal_file_name);
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                $compress_new4 = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($compress_new4, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                imagegif($compress_new4, $output_dir . "/" . $internal_file_name);
                                break;
                            default:
                                die();
                        }

                      
                    
                        //clearing memory maybe ?
                        // imagedestroy($compress_new4);
                        // $what=null;
                        // $width = null;
                        // $height = null;
                        // $img=null;
                        
                    }
                    else
                    {
                        move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . "/" . $internal_file_name);
                    }
                    

                    $data['o_id'] = $orderid;
                    $data['uca_id'] = $uca_id;
                    $data['om_id'] = $order['om_id'];
                    $data['osub_id'] = $osub_id;
                    $data['prod_id'] = $prod_id;
                    if(!empty($chosen_classification_id[$i]))
                    {
                        $data['config_level'] = $chosen_classification_id[$i];
                    }
                    else
                    {
                        $data['config_level'] ="";
                    }
                    if((empty($chosen_main_img_id))&&(empty($chosen_shape_id)))
                    {
                        $data['pict_categ_name'] = "";
                    }
                    else
                    {
                        $data['pict_categ_name'] = $chosen_main_img_id[$i].".".$chosen_shape_id[$i];
                    }
                    $data['orf_name'] = $original_file_name;
                    

                    $data['orf_internal_name_dom'] = $internal_file_name;
                    $data['orf_type_dom'] = $file_extension;
                    $data['orf_path_dom'] = $file_path;
                    $data['orf_upload_date'] = $upload_date;
                    $data['orf_status'] = 0;
                    if (in_array($file_extension, $thumbnail_validextensions)) {
                        $data['orf_thumbnail_path'] = $thumbnail_file_path . $thumbnail_file_name;
                    }
                    if (in_array($file_extension, $compress_validextensions)) {
                        echo $data['orf_compress_path'] = $compress_file_path . $compress_file_name;
                    }
                    

                    $prod->upload_creator_result_file3(json_encode($data));

                    $latest_orf_id=$prod->show_results_by_date_reverse_order($orderid, $osub_id, $prod_id);

                    $configurator_plus_data['o_id_full']=$orderid.".".$osub_id.".".$prod_id;
                    $configurator_plus_data['orf_id']=$latest_orf_id[0]['orf_id'];
                    if(!empty($chosen_classification_id[$i]))
                    {
                        $configurator_plus_data['pa_id']=$chosen_classification_id[$i];
                    }
                    else
                    {
                        $configurator_plus_data['pa_id']="";
                    }
                    if(!empty($chosen_shape_id[$i]))
                    {
                        $configurator_plus_data['pa_symbol']=$chosen_shape_id[$i];
                    }
                    else
                    {
                        $configurator_plus_data['pa_symbol']="";
                    }
                    if(!empty($chosen_main_img_id[$i]))
                    {
                        $configurator_plus_data['connected_to']=$chosen_main_img_id[$i];
                    }
                    else
                    {
                        $configurator_plus_data['connected_to']="0";
                    }

                   

                    $check_o_results_configurator_plus=$prod->get_o_results_configurator_plus($configurator_plus_data['orf_id']);

                    if(!empty($check_o_results_configurator_plus))
                    {
                        $prod->update_o_results_configurator_plus(json_encode($configurator_plus_data));
                    }
                    else
                    {
                        $prod->insert_o_results_configurator_plus(json_encode($configurator_plus_data));
                    }

                    $ret[] = $internal_file_name;
                } else {
                    $custom_error = array();
                    $custom_error['jquery-upload-file-error'] = "Invalid uploaded file for this category. Contact administrator for instructions.";
                    echo json_encode($custom_error);
                    die();
                }
            }

        //}
    }

    /*if ($filecategory == "customerfiles") 
    {

        $orderid = $_GET['o_id'];

        $client_files_dir = "client_files/";

        $output_dir = $client_files_dir . $year . "/" . $orderid;

        $file_path = $year . "/" . $orderid . "/";

        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0755, true);
        }

        //	This is for custom errors;
        /*	$custom_error= array();
            $custom_error['jquery-upload-file-error']="File already exists";
            echo json_encode($custom_error);
            die();
        
        $error = $_FILES["myfile"]["error"];
        //You need to handle  both cases
        //If Any browser does not support serializing of multiple files using FormData()
        if (!is_array($_FILES["myfile"]["name"])) //single file
        {

            $original_file_name = $_FILES["myfile"]["name"];

            $tempfile = explode(".", $original_file_name);
            $file_extension = strtolower(end($tempfile));
            $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . "/" . $internal_file_name);

            $prod->add_order_files($orderid, $of_kind, $of_subtitle, $of_position = 1, $of_exterior_position = 1, $original_file_name, $file_path, $internal_file_name, $file_extension);

            $ret[] = $internal_file_name;
        } else  //Multiple files, file[]
        {
            $fileCount = count($_FILES["myfile"]["name"]);
            for ($i = 0; $i < $fileCount; $i++) {
                $original_file_name = $_FILES["myfile"]["name"][$i];

                $tempfile = explode(".", $original_file_name);
                $file_extension = strtolower(end($tempfile));
                $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

                move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . "/" . $internal_file_name);

                $of_position = 0;
                $of_exterior_position = 0;

                if ($i == 0) {
                    $of_position = 1;
                    $of_exterior_position = 1;
                }
                $prod->add_order_files($orderid, $of_kind, $of_subtitle, $of_position, $of_exterior_position, $original_file_name, $file_path, $internal_file_name, $file_extension);

                $ret[] = $internal_file_name;
            }

        }
    }*/


    if($filecategory=="customerfiles")
	{

		$orderid=$_GET['o_id'];

		$client_files_dir = "client_files/";

		$output_dir=$client_files_dir.$year."/".$orderid;

		$file_path=$year."/".$orderid."/";

		if(!file_exists($output_dir)) {
			mkdir($output_dir, 0755, true);
		}

        
		$error =$_FILES["myfile"]["error"];
		//You need to handle  both cases
		//If Any browser does not support serializing of multiple files using FormData()
		if(!is_array($_FILES["myfile"]["name"])) //single file
		{

			$original_file_name = $_FILES["myfile"]["name"];

			$tempfile=explode(".",$original_file_name);
			$file_extension=strtolower(end($tempfile));
			$internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

			move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir."/".$internal_file_name);

			$prod->add_order_files($orderid,$of_kind,$of_subtitle,$of_position=1,$of_exterior_position=1,$original_file_name,$file_path,$internal_file_name,$file_extension);

            if($file_extension=="pdf")
            {
                $new_customer_file=$prod->get_newest_customer_pdf_file($orderid);

                $original_file_name=str_replace('(','_LB_',$original_file_name);
                $original_file_name=str_replace(')','_RB_',$original_file_name);
                $original_file_name=str_replace(' ','_',$original_file_name);
                $original_file_name=str_replace('&','_n_',$original_file_name);

                $jpg_tmp=$output_dir."/tmp/";
                if(!file_exists($jpg_tmp)) {
                    mkdir($jpg_tmp, 0755, true);
                }

                $cmd = "convert -density 200 -quality 80 -sharpen 0x1.0 -alpha remove ".$output_dir."/".$internal_file_name." ".$jpg_tmp.$internal_file_name."_".$original_file_name.".jpg";

                exec($cmd); // convert pdf to jpg

                $jpg_files_array=scandir($jpg_tmp);

                for($f=0;$f<count($jpg_files_array);$f++)
                {
                    if(strpos($jpg_files_array[$f], '.jpg') !== false)
                    {
                        rename($jpg_tmp.$jpg_files_array[$f],$output_dir."/"."pdfid_".$jpg_files_array[$f]);

                        $prod->add_order_files($orderid,$of_kind,$of_subtitle,$of_position=1,$of_exterior_position=1,$jpg_files_array[$f],$file_path,"pdfid_".$jpg_files_array[$f],"jpg");
                    }
                }
            }

			$ret[]= $internal_file_name;
		}
		else  //Multiple files, file[]
		{
		  $fileCount = count($_FILES["myfile"]["name"]);
		  for($i=0; $i < $fileCount; $i++)
		  {
			$original_file_name = $_FILES["myfile"]["name"][$i];
            $of_level="";
            $of_kind=0;
            if(str_contains(strtolower($original_file_name), "eg"))
            {
                $of_level="L 00";
                $of_subtitle="floorplan-l00";
                $of_kind=1;
            }

            if(str_contains(strtolower($original_file_name), "og"))
            {
                $of_level="L 01";
                $of_subtitle="floorplan-l01";
                $of_kind=1;
            }

            if(str_contains(strtolower($original_file_name), "dg"))
            {
                $of_level="L 01";
                $of_subtitle="floorplan-l01";
                $of_kind=1;
            }

            if(str_contains(strtolower($original_file_name), "kg"))
            {
                $of_level="L -1";
                $of_subtitle="floorplan-l-1";
                $of_kind=1;
            }

			$tempfile=explode(".",$original_file_name);
			$file_extension=strtolower(end($tempfile));
			$internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

			move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir."/".$internal_file_name);

            $of_position=0;
            $of_exterior_position=0;

            if($i==0)
            {
                $of_position=1;
                $of_exterior_position=1;
            }
			$prod->add_order_files($orderid,$of_level,($of_kind ?? '0'),($of_subtitle ?? ''),$of_position,$of_exterior_position,$original_file_name,$file_path,$internal_file_name,$file_extension);

            if($file_extension=="pdf")
            {
                $new_customer_file=$prod->get_newest_customer_pdf_file($orderid);

                $original_file_name=str_replace('(','_LB_',$original_file_name);
                $original_file_name=str_replace(')','_RB_',$original_file_name);
                $original_file_name=str_replace(' ','_',$original_file_name);                
                $original_file_name=str_replace('&','_n_',$original_file_name); 

                $jpg_tmp=$output_dir."/tmp/";
                if(!file_exists($jpg_tmp)) {
                    mkdir($jpg_tmp, 0777, true);
                }

                $cmd = "convert -density 200 -quality 80 -sharpen 0x1.0 -alpha remove ".$output_dir."/".$internal_file_name." ".$jpg_tmp.$internal_file_name."_".$original_file_name.".jpg";

                exec($cmd); // convert pdf to jpg

                $jpg_files_array=scandir($jpg_tmp);

                for($f=0;$f<count($jpg_files_array);$f++)
                {
                    if(strpos($jpg_files_array[$f], '.jpg') !== false)
                    {
                        rename($jpg_tmp.$jpg_files_array[$f],$output_dir."/".$jpg_files_array[$f]);

                        //$prod->add_order_files($orderid,$of_kind,$of_subtitle,$of_position=1,$of_exterior_position=1,$jpg_files_array[$f],$file_path,"pdfid_".$jpg_files_array[$f],"jpg");
                        $prod->add_order_files($orderid,$of_level,$of_kind,$of_subtitle,$of_position=1,$of_exterior_position=1,$jpg_files_array[$f],$file_path,$jpg_files_array[$f],"jpg");
                    }
                }
            }
            
			//$ret[]= $internal_file_name;
		  }

		}
	}

    if($filecategory=="newcustomerfiles")
	{
		$orderid=$_GET['o_id'];

		$client_files_dir = "client_files/";

		$output_dir=$client_files_dir.$year."/".$orderid;

		$file_path=$year."/".$orderid."/";        
        
		if(!file_exists($output_dir)) {
			mkdir($output_dir, 0777, true);
		}

		if(is_array($_FILES["customer_files_myfile"]["name"])) 		 
		{
		  $fileCount = count($_FILES["customer_files_myfile"]["name"]); //it gets all input file html fiels, even the empty ones
		  for($i=0; $i < $fileCount; $i++)
		  {
			$original_file_name = $_FILES["customer_files_myfile"]["name"][$i];
            if(!empty($original_file_name))
            {
                $of_level=$_POST["customer_files_level"][$i];
                $of_subtitle=$_POST["customer_files_of_subtitle"][$i];
                $of_kind=$_POST["customer_files_of_kind"][$i];
                $temp_assigned_subids=$_POST["customer_files_selected_subids"][$i];

                $tempfile=explode(".",$original_file_name);
                $file_extension=strtolower(end($tempfile));
                $internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

                move_uploaded_file($_FILES["customer_files_myfile"]["tmp_name"][$i],$output_dir."/".$internal_file_name);

                $of_position=0;
                $of_exterior_position=0;

                if($i==0)
                {
                    $of_position=1;
                    $of_exterior_position=1;
                }

                $add_customer_files_data=array(
                    'o_id' => $orderid,
                    'of_level' => ($of_level ?? ''),
                    'of_kind' => ($of_kind ?? '0'),
                    'of_subtitle' => ($of_subtitle ?? ''),
                    'of_position' => $of_position,
                    'of_exterior_position' => $of_exterior_position,
                    'of_name_client' => $original_file_name,
                    'of_path_dom' => $file_path,
                    'of_internal_name_dom' => $internal_file_name,
                    'of_type_dom' => $file_extension,
                    'temp_assigned_subids' => $temp_assigned_subids
                );

                $prod->add_order_files2(json_encode($add_customer_files_data));

                if($file_extension=="pdf")
                {
                    $new_customer_file=$prod->get_newest_customer_pdf_file($orderid);

                    $original_file_name=str_replace('(','_LB_',$original_file_name);
                    $original_file_name=str_replace(')','_RB_',$original_file_name);
                    $original_file_name=str_replace(' ','_',$original_file_name);                
                    $original_file_name=str_replace('&','_n_',$original_file_name); 

                    $jpg_tmp=$output_dir."/tmp/";
                    if(!file_exists($jpg_tmp)) {
                        mkdir($jpg_tmp, 0777, true);
                    }

                    $cmd = "convert -density 200 -quality 80 -sharpen 0x1.0 -alpha remove ".$output_dir."/".$internal_file_name." ".$jpg_tmp.$internal_file_name."_".$original_file_name.".jpg";

                    exec($cmd); // convert pdf to jpg

                    $jpg_files_array=scandir($jpg_tmp);

                    for($f=0;$f<count($jpg_files_array);$f++)
                    {
                        if(strpos($jpg_files_array[$f], '.jpg') !== false)
                        {
                            rename($jpg_tmp.$jpg_files_array[$f],$output_dir."/".$jpg_files_array[$f]);

                            $add_customer_files_data2=array(
                                'o_id' => $orderid,
                                'of_level' => ($of_level ?? ''),
                                'of_kind' => ($of_kind ?? '0'),
                                'of_subtitle' => ($of_subtitle ?? ''),
                                'of_position' => '1',
                                'of_exterior_position' => '1',
                                'of_name_client' => $jpg_files_array[$f],
                                'of_path_dom' => $file_path,
                                'of_internal_name_dom' => $jpg_files_array[$f],
                                'of_type_dom' => 'jpg',
                                'temp_assigned_subids' => $temp_assigned_subids
                            );
            
                            $prod->add_order_files2(json_encode($add_customer_files_data2));
                            //$prod->add_order_files($orderid,$of_kind,$of_subtitle,$of_position=1,$of_exterior_position=1,$jpg_files_array[$f],$file_path,"pdfid_".$jpg_files_array[$f],"jpg");
                            //$prod->add_order_files($orderid,($of_level ?? ''),($of_kind ?? '0'),($of_subtitle ?? ''),$of_position=1,$of_exterior_position=1,$jpg_files_array[$f],$file_path,$jpg_files_array[$f],"jpg");
                        }
                    }
                }
            }
			
		  }

		}


        $all_customer_files=$prod->get_customer_files($orderid);

        for($c=0;$c<count($all_customer_files);$c++)
        {
            $o_sub_id_array=explode(',',$all_customer_files[$c]['temp_assigned_subids']);

            for($s=0;$s<count($o_sub_id_array);$s++)
            {
                if(!empty($o_sub_id_array[$s]))
                {
                    $data=array(
                        'o_id' => $orderid,
                        'o_sub_id' => $o_sub_id_array[$s]
                    );

                    $existing_subid=$prod->check_existing_subid(json_encode($data));

                    if(!empty($existing_subid))
                    {
                        if(!str_contains(strtolower($existing_subid['cf_id']), $all_customer_files[$c]['of_id']))
                        {
                            $prod->change_orders_subnames_cf_id($existing_subid['subo_id'],$existing_subid['cf_id'].$all_customer_files[$c]['of_id'].";");
                        }
                    }
                    else
                    {
                        $add_data=array(
                            'o_id' => $orderid,
                            'o_sub_id' => $o_sub_id_array[$s],
                            'cf_id' => $all_customer_files[$c]['of_id'].';'
                        );

                        $prod->add_sub_id_to_customer_file(json_encode($add_data));
                    }
                }
            }

            

            
            //$existing_orders_subnames=$prod->get_all_orders_subnames_by_o_id_o_sub_id_cf_id($o_id, $o_sub_id, $cf_id)
        }
	}

    if ($filecategory == "correction_needed_files") 
    {
        $o_id = $_GET['o_id'];
        $osub_id = $_GET['osub_id'];
        $prod_id = $_GET['prod_id'];
        $uca_id = $_GET['uca_id'];

        $correction_needed_files_dir = "correction_needed_files/";

        $output_dir = $correction_needed_files_dir . $year . "/" . $o_id . "/" . $o_id . "." . $osub_id . "." . $prod_id;
        $file_path = $year . "/" . $o_id . "/" . $o_id . "." . $osub_id . "." . $prod_id . "/";

        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0755, true);
        }

        //	This is for custom errors;
        /*	$custom_error= array();
            $custom_error['jquery-upload-file-error']="File already exists";
            echo json_encode($custom_error);
            die();
        */
        $error = $_FILES["myfile"]["error"];
        //You need to handle  both cases
        //If Any browser does not support serializing of multiple files using FormData()
        if (!is_array($_FILES["myfile"]["name"])) //single file
        {

            $original_file_name = $_FILES["myfile"]["name"];

            $tempfile = explode(".", $original_file_name);
            $file_extension = strtolower(end($tempfile));
            $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . "/" . $internal_file_name);

            $prod->upload_correction_needed_file($o_id, $osub_id, $prod_id, $uca_id, $original_file_name, $file_path, $internal_file_name, $upload_date);

            $ret[] = $internal_file_name;
        } 
        else  //Multiple files, file[]
        {
            $fileCount = count($_FILES["myfile"]["name"]);
            for ($i = 0; $i < $fileCount; $i++) {
                $original_file_name = $_FILES["myfile"]["name"][$i];

                $tempfile = explode(".", $original_file_name);
                $file_extension = strtolower(end($tempfile));
                $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

                move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . "/" . $internal_file_name);

                $prod->upload_correction_needed_file($o_id, $osub_id, $prod_id,$uca_id, $original_file_name, $file_path, $internal_file_name, $upload_date);

                $ret[] = $internal_file_name;
            }

        }
    }

    if ($filecategory == "optimized_files") 
    {

        $orf_id = $prod->xss_fix($_GET['orf_id']);

        $creator_file = $prod->get_creator_file($orf_id); //checking if there is a not optimized result file uploaded

        if (!empty($creator_file)) {
            $o_id = $creator_file['o_id'];
            $osub_id = $creator_file['osub_id'];
            $prod_id = $creator_file['prod_id'];

            $optimized_files_dir = "optimized_result_files/";

            $output_dir = $optimized_files_dir . $year . "/" . $o_id . "/" . $o_id . "." . $osub_id . "." . $prod_id;
            $file_path = $year . "/" . $o_id . "/" . $o_id . "." . $osub_id . "." . $prod_id . "/";

            if (!file_exists($output_dir)) {
                mkdir($output_dir, 0755, true);
            }

            //	This is for custom errors;
            /*	$custom_error= array();
                $custom_error['jquery-upload-file-error']="File already exists";
                echo json_encode($custom_error);
                die();
            */
            $error = $_FILES["myfile"]["error"];
            //You need to handle  both cases
            //If Any browser does not support serializing of multiple files using FormData()
            if (!is_array($_FILES["myfile"]["name"])) //single file
            {
                //has to be checked if there is an optimized file already uploaded
                if (!empty($creator_file['optimized_image_path'])) {
                    //delete old optimized file before upload new
                    if (file_exists($creator_file['optimized_image_path'])) {
                        unlink($creator_file['optimized_image_path']);
                    }
                }

                $original_file_name = $_FILES["myfile"]["name"];

                //$tempfile=explode(".",$original_file_name);
                //$file_extension=strtolower(end($tempfile));
                //$internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

                move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . "/" . $original_file_name);

                //$prod->upload_correction_needed_file($o_id,$osub_id,$prod_id,$uca_id,$original_file_name,$file_path,$internal_file_name,$upload_date);
                $prod->update_optimized_result_file_path($orf_id, $output_dir . "/" . $original_file_name);
                //$ret[]= $internal_file_name;
            }
            //else  //Multiple files, file[]
            //{
            //$fileCount = count($_FILES["myfile"]["name"]);
            //for($i=0; $i < $fileCount; $i++)
            //{
            //$original_file_name = $_FILES["myfile"]["name"][$i];

            // $tempfile=explode(".",$original_file_name);
            // $file_extension=strtolower(end($tempfile));
            // $internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

            //move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir."/".$original_file_name);

            //$prod->upload_correction_needed_file($o_id,$osub_id,$prod_id,$original_file_name,$file_path,$internal_file_name,$upload_date);

            //$ret[]= $internal_file_name;

            //     $prod->update_optimized_result_file_path($orf_id,$output_dir."/".$original_file_name);
            // }

            //}
        }
    }

    /*if($filecategory=="example_files")
    {
        $layout_id=$_GET['layout_id'];
        $window_id=$_GET['window_id'];
        $table_name=$_GET['table_name'];

        //delete older file

        $layout=$prod->get_layout($layout_id,$window_id);

        if(file_exists("../superfloorplans.com/".$layout[$table_name]))
        {
            unlink("../superfloorplans.com/".$layout[$table_name]);
        }

        $layouts_dir="../superfloorplans.com/layouts/";

        $output_dir=$layouts_dir."/".$layout_id."/".$window_id."/";
        $file_path="layouts/".$layout_id."/".$window_id."/";

        if(!file_exists($output_dir)) {
            mkdir($output_dir, 0755, true);
        }

    //	This is for custom errors;
    /*	$custom_error= array();
        $custom_error['jquery-upload-file-error']="File already exists";
        echo json_encode($custom_error);
        die();
    */
    /*$error =$_FILES["myfile"]["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData()
    if(!is_array($_FILES["myfile"]["name"])) //single file
    {

        $original_file_name = $_FILES["myfile"]["name"];

        $tempfile=explode(".",$original_file_name);
        $file_extension=strtolower(end($tempfile));
        $internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir."/".$internal_file_name);

        $prod->update_layout($layout_id,$window_id,$table_name,$file_path.$internal_file_name);

        $ret[]= $internal_file_name;
    }
    else  //Multiple files, file[]
    {
      $fileCount = count($_FILES["myfile"]["name"]);
      for($i=0; $i < $fileCount; $i++)
      {
        $original_file_name = $_FILES["myfile"]["name"][$i];

        $tempfile=explode(".",$original_file_name);
        $file_extension=strtolower(end($tempfile));
        $internal_file_name = sha1(uniqid(mt_rand(), true)).'.'. $file_extension;

        move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir."/".$internal_file_name);

        $prod->update_layout($layout_id,$window_id,$table_name,$file_path.$internal_file_name);

        $ret[]= $internal_file_name;
      }

    }
} */

    //echo json_encode($ret);
//}
?>
