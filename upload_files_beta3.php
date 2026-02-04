<?php
include('functions.php');
$prod = new Production;

$filecategory = $_GET['filecategory'];
$year = date("Y");
$upload_date = gmdate("Y-m-d H:i:s");

if (isset($_FILES["myfile"])) {
    $ret = array();

    if ($filecategory == "creatorfiles") {

        $orderid = $prod->xss_fix($_GET['o_id']);
        $osub_id = $prod->xss_fix($_GET['osub_id']);
        $prod_id = $prod->xss_fix($_GET['prod_id']);
        $uca_id = $prod->xss_fix($_GET['uca_id']);

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

        $validextensions = array("jpg", "jpeg", "png","eps", "pdf", "svg", "exr", "psd", "dwg", "txt");

        $thumbnail_validextensions = array("jpg", "jpeg", "png");
        $compress_validextensions = array("jpg", "jpeg", "png");


        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0755, true);
        }

        if ((strpos($prod_id, "p1301") !== false) || (strpos($prod_id, "p1321") !== false)) {
            $validextensions = array("cdr");
        }

        if ((strpos($prod_id, "p1501") !== false) || (strpos($prod_id, "p1521") !== false) || (strpos($prod_id, "p1541") !== false) || (strpos($prod_id, "p1561") !== false) || (strpos($prod_id, "p1562") !== false) || (strpos($prod_id, "p1581") !== false)) {
            $validextensions = array("skp", "max", "fbx");
        }

        if ((strpos($prod_id, "p1600") !== false) || (strpos($prod_id, "p1660") !== false)) {
            $validextensions = array("skp", "c4d", "fbx");
        }

        if ((strpos($prod_id, "p1700") !== false) || (strpos($prod_id, "p1760") !== false)) {
            $validextensions = array("skp", "max", "c4d", "fbx");
        }
        if ((strpos($prod_id, "p1800") !== false) || (strpos($prod_id, "p1860") !== false)) {
            $validextensions = array("skp", "max", "c4d", "ls9", "tm", "fbx");
        }
        if ((strpos($prod_id, "p1601") !== false) || (strpos($prod_id, "p1621") !== false) || (strpos($prod_id, "p1641") !== false) || (strpos($prod_id, "p1661") !== false) || (strpos($prod_id, "p1662") !== false) || (strpos($prod_id, "p1681") !== false)) {
            $validextensions = array("c4d", "skp", "fbx");
        }
        if ((strpos($prod_id, "p1801") !== false) || (strpos($prod_id, "p1821") !== false) || (strpos($prod_id, "p1841") !== false) || (strpos($prod_id, "p1861") !== false) || (strpos($prod_id, "p1862") !== false) || (strpos($prod_id, "p1881") !== false)) {
            $validextensions = array("skp", "ls9", "tm", "fbx");
        }
        if ((strpos($prod_id, "p1701") !== false) || (strpos($prod_id, "p1721") !== false) || (strpos($prod_id, "p1741") !== false) || (strpos($prod_id, "p1761") !== false) || (strpos($prod_id, "p1762") !== false) || (strpos($prod_id, "p1781") !== false)) {
            $validextensions = array("max", "c4d", "skp", "fbx");
        }
        if ((strpos($prod_id, "p1867") !== false) || (strpos($prod_id, "p1767") !== false) || (strpos($prod_id, "p1667") !== false) || (strpos($prod_id, "p1567") !== false) ||
            (strpos($prod_id, "p1507") !== false) || (strpos($prod_id, "p1527") !== false) || (strpos($prod_id, "p1547") !== false) ||
            (strpos($prod_id, "p1607") !== false) || (strpos($prod_id, "p1627") !== false) || (strpos($prod_id, "p1647") !== false) ||
            (strpos($prod_id, "p1707") !== false) || (strpos($prod_id, "p1727") !== false) || (strpos($prod_id, "p1747") !== false) ||
            (strpos($prod_id, "p1807") !== false) || (strpos($prod_id, "p1827") !== false) || (strpos($prod_id, "p1847") !== false)) {
            $validextensions = array("mp4", "mov");
        }
        if ((strpos($prod_id, "p1508") !== false) || (strpos($prod_id, "p1528") !== false) || (strpos($prod_id, "p1548") !== false) || (strpos($prod_id, "p1568") !== false) || (strpos($prod_id, "p1608") !== false) || (strpos($prod_id, "p1628") !== false) || (strpos($prod_id, "p1648") !== false) || (strpos($prod_id, "p1668") !== false) || (strpos($prod_id, "p1708") !== false) || (strpos($prod_id, "p1728") !== false) || (strpos($prod_id, "p1748") !== false) || (strpos($prod_id, "p1768") !== false) || (strpos($prod_id, "p1768") !== false) || (strpos($prod_id, "p1868") !== false)) {
            $validextensions = array("zip", "mp4", "mov");
        }
        if ((strpos($prod_id, "p156x") !== false) || (strpos($prod_id, "p166x") !== false) ||
            (strpos($prod_id, "p176x") !== false) || (strpos($prod_id, "p186x") !== false)) {
            $validextensions = array("fbx", "glb");
        }

        if ((strpos($prod_id, "p156y") !== false) || (strpos($prod_id, "p166y") !== false) ||
            (strpos($prod_id, "p176y") !== false) || (strpos($prod_id, "p186y") !== false)) {
            $validextensions = array("jpg", "jpeg");
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
                        $original_file_name = $order['om_id'] . "." . $osub_id . "." . $prod_id . "." . $orderid . " - " . $nr_files . "." . $file_extension;
                        $thumbnail_file_name = $internal_file_name . "_thumb." . $file_extension;
                        $compress_file_name = $internal_file_name . "_compress." . $file_extension;
                    }

                    

                    //thumbnail stuff
                    if (in_array($file_extension, $thumbnail_validextensions)) {
                        if (!file_exists($thumbnail_output_dir)) {
                            mkdir($thumbnail_output_dir, 0755, true);
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
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/jpeg');
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                break;
                            default:
                                die();
                        }

                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                imagepng($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            case 'image/jpeg':
                                imagejpeg($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            case 'image/gif':
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
                    if (in_array($file_extension, $compress_validextensions)) {
                        if (!file_exists($compress_output_dir)) {
                            mkdir($compress_output_dir, 0755, true);
                        }

                        $quality = 99;

                        $what = getimagesize($_FILES["myfile"]["tmp_name"]);

                        $width = $what[0];
                        $height = $what[1];

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
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/jpeg');
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                break;
                            default:
                                die();
                        }

                        
                        imagejpeg($new, $compress_output_dir . "/" . $compress_file_name, $quality);
                        //clearing memory maybe ?
                        imagedestroy($new);
                        $what=null;
                        $width = null;
                        $height = null;
                        $img=null;
                    }
                    //end compress stuff


                    move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . "/" . $internal_file_name);

                    $data['o_id'] = $orderid;
                    $data['uca_id'] = $uca_id;
                    $data['om_id'] = $order['om_id'];
                    $data['osub_id'] = $osub_id;
                    $data['prod_id'] = $prod_id;
                    $data['orf_name'] = $original_file_name;
                    $data['orf_internal_name_dom'] = $internal_file_name;
                    $data['orf_type_dom'] = $file_extension;
                    $data['orf_path_dom'] = $file_path;
                    $data['orf_upload_date'] = $upload_date;
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

//                    echo json_encode($data);

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
                    $data['orf_name'] = "index.html";
                    $data['orf_internal_name_dom'] = "index.html";
                    $data['orf_type_dom'] = "html";
                    $data['orf_path_dom'] = $file_path;
                    $data['orf_upload_date'] = $upload_date;
                    $data['orf_thumbnail_path'] = "";
                    $data['orf_compress_path'] = "";


                    $prod->upload_creator_result_file3(json_encode($data));
                }
            } else {
                $custom_error = array();
                $custom_error['jquery-upload-file-error'] = "Invalid uploaded file for this category. Contact administrator for instructions.";
                echo json_encode($custom_error);
                die();
            }
        } else  //Multiple files, file[]
        {
            $fileCount = count($_FILES["myfile"]["name"]);
            ++$nr_files;

            for ($i = 0; $i < $fileCount; $i++) {
                $original_file_name = $_FILES["myfile"]["name"][$i];

                $tempfile = explode(".", $original_file_name);
                $file_extension = strtolower(end($tempfile));

                if (in_array($file_extension, $validextensions)) {

                    $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

                    if ($order['om_id'] == 0) {
                        $original_file_name = $orderid . "." . $osub_id . "." . $prod_id . " - " . $nr_files . "." . $file_extension;
                        $thumbnail_file_name = $internal_file_name . "_thumb." . $file_extension;
                        $compress_file_name = $internal_file_name . "_compress." . $file_extension;
                    } else {
                        $original_file_name = $order['om_id'] . "." . $osub_id . "." . $prod_id . "." . $orderid . " - " . $nr_files . "." . $file_extension;
                        $compress_file_name = $internal_file_name . "_compress." . $file_extension;
                    }

                    //thumbnail stuff
                    if (in_array($file_extension, $thumbnail_validextensions)) {
                        if (!file_exists($thumbnail_output_dir)) {
                            mkdir($thumbnail_output_dir, 0755, true);
                        }

                        $what = getimagesize($_FILES["myfile"]["tmp_name"][$i]);

                        $width = $what[0];
                        $height = $what[1];

                        $desired_width = 145;
                        $desired_height = floor($height * ($desired_width / $width));

                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($new, true);
                                $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                imagefill($new, 0, 0, $color);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/jpeg');
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                break;
                            default:
                                die();
                        }

                        //imagejpeg($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);

                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                imagepng($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            case 'image/jpeg':
                                imagejpeg($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            case 'image/gif':
                                imagegif($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                                break;
                            default:
                                die();
                        }

                        imagedestroy($new);
                        $what=null;
                        $width = null;
                        $height = null;
                        $img=null;
                    }
                    //end thumbnail stuff


                    //compress stuff
                    if (in_array($file_extension, $compress_validextensions)) {
                        if (!file_exists($compress_output_dir)) {
                            mkdir($compress_output_dir, 0755, true);
                        }

                        $quality = 99;
                        $what = getimagesize($_FILES["myfile"]["tmp_name"][$i]);

                        $width = $what[0];
                        $height = $what[1];

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

                        $desired_width = $width/$new_divider;
                        $desired_height = $height/$new_divider;

                        switch (strtolower($what['mime'])) {
                            case 'image/png':
                                $img = imagecreatefrompng($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagesavealpha($new, true);
                                $color = imagecolorallocatealpha($new, 0, 0, 0, 127);
                                imagefill($new, 0, 0, $color);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/png');
                                break;
                            case 'image/jpeg':
                                $img = imagecreatefromjpeg($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/jpeg');
                                break;
                            case 'image/gif':
                                $img = imagecreatefromgif($_FILES["myfile"]["tmp_name"][$i]);
                                $new = imagecreatetruecolor($desired_width, $desired_height);
                                imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                                header('Content-Type: image/gif');
                                break;
                            default:
                                die();
                        }

                        imagejpeg($new, $compress_output_dir . "/" . $compress_file_name, $quality);
                        imagedestroy($new);
                    }
                    //end compress stuff


                    move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . "/" . $internal_file_name);

                    $data['o_id'] = $orderid;
                    $data['uca_id'] = $uca_id;
                    $data['om_id'] = $order['om_id'];
                    $data['osub_id'] = $osub_id;
                    $data['prod_id'] = $prod_id;
                    $data['orf_name'] = $original_file_name;
                    $data['orf_internal_name_dom'] = $internal_file_name;
                    $data['orf_type_dom'] = $file_extension;
                    $data['orf_path_dom'] = $file_path;
                    $data['orf_upload_date'] = $upload_date;
                    if (in_array($file_extension, $thumbnail_validextensions)) {
                        $data['orf_thumbnail_path'] = $thumbnail_file_path . $thumbnail_file_name;
                    }
                    if (in_array($file_extension, $compress_validextensions)) {
                        $data['orf_compress_path'] = $compress_file_path . $compress_file_name;
                    }
                    //$prod->upload_creator_result_file($orderid,$osub_id,$prod_id,$original_file_name,$internal_file_name,$file_extension,$file_path,$upload_date);

                    $prod->upload_creator_result_file3(json_encode($data));

                    $ret[] = $internal_file_name;
                } else {
                    $custom_error = array();
                    $custom_error['jquery-upload-file-error'] = "Invalid uploaded file for this category. Contact administrator for instructions.";
                    echo json_encode($custom_error);
                    die();
                }
            }

        }
    }

    if ($filecategory == "customerfiles") {

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
    }

    if ($filecategory == "correction_needed_files") {
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
        } else  //Multiple files, file[]
        {
            $fileCount = count($_FILES["myfile"]["name"]);
            for ($i = 0; $i < $fileCount; $i++) {
                $original_file_name = $_FILES["myfile"]["name"][$i];

                $tempfile = explode(".", $original_file_name);
                $file_extension = strtolower(end($tempfile));
                $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

                move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . "/" . $internal_file_name);

                $prod->upload_correction_needed_file($o_id, $osub_id, $prod_id, $original_file_name, $file_path, $internal_file_name, $upload_date);

                $ret[] = $internal_file_name;
            }

        }
    }

    if ($filecategory == "optimized_files") {

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

    echo json_encode($ret);
}
?>
