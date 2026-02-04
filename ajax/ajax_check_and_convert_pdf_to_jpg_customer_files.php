<?php
session_start();
include('../functions.php');
//include('../../../../blue7.it/public_html/domenia/domenia.php');

$prod=new Production;
//$domenia=new Domenia;

$base_url="https://blue7.it/studio/";
$o_id=$prod->xss_fix($_GET['o_id']);

$client_files_dir="/home/adminhdd/domains/blue7.it/public_html/studio/client_files/".date("Y")."/".$o_id;

if(is_dir($client_files_dir))
{
    $scanned_directory = array_diff(scandir($client_files_dir), array('..', '.'));
    $scanned_directory=array_values($scanned_directory);

    //check for existing pdf files
    $pdf_files=array();
    $file_counter=0;
    for($s=0;$s<count($scanned_directory);$s++)
    {
        $tempfile=explode(".",$scanned_directory[$s]);
		$file_extension=strtolower(end($tempfile));

        if($file_extension=="pdf")
        {
            $pdf_files[$file_counter++]=$scanned_directory[$s];
        }
    }

    $pdf_has_to_be_converted=array();
    $pdf_converter_counter=0;
    for($p=0;$p<count($pdf_files);$p++)
    {
        $pdf_tempfile=explode("_",$pdf_files[$p]);
        
        $found_at_least_one_jpg=0;

        for($s=0;$s<count($scanned_directory);$s++) //check if 1 converted jpg file exists
        {
            $tempfile=explode(".",$scanned_directory[$s]);
            $file_extension=strtolower(end($tempfile));

            if($file_extension!="pdf")
            {
                if((strpos($scanned_directory[$s], $pdf_tempfile[0]) !== false)&&($found_at_least_one_jpg==0))
                {
                    $found_at_least_one_jpg=1;
                }
            }
        }

        if($found_at_least_one_jpg==0)
        {
            $pdf_has_to_be_converted[$pdf_converter_counter++]=$pdf_files[$p];
        }
    }

    for($p=0;$p<count($pdf_has_to_be_converted);$p++)
    {
        //$cmd = "convert -density 200 -quality 80 -sharpen 0x1.0 -alpha remove ".$client_files_dir."/".$pdf_has_to_be_converted[$p]." ".$client_files_dir."/"."pdfid_".$pdf_has_to_be_converted[$p].".jpg";
        $cmd = "convert -density 200 -quality 80 -sharpen 0x1.0 -alpha remove ".$client_files_dir."/".$pdf_has_to_be_converted[$p]." ".$client_files_dir."/".$pdf_has_to_be_converted[$p].".jpg";
        exec($cmd); // convert pdf to jpg
    }

    $scanned_directory = array_diff(scandir($client_files_dir), array('..', '.','tmp'));
    $scanned_directory=array_values($scanned_directory);

    //check for existing pdf files
    
    for($s=0;$s<count($scanned_directory);$s++)
    {
        $existing_client_file=$prod->get_customer_file_by_internal_name($o_id,$scanned_directory[$s]);

        if(empty($existing_client_file))
        {
            $tempfile=explode(".",$scanned_directory[$s]);
            $file_extension=strtolower(end($tempfile));
        
            $file_info = array(
                'o_id' => $o_id,
                'of_kind' => "0",
                'of_subtitle' => "",
                'of_position' => 1,
                'of_name_client' => $scanned_directory[$s],
                'of_path_dom' => date("Y") . "/" . $o_id . "/",
                'of_internal_name_dom' => $scanned_directory[$s],
                'of_type_dom' => $file_extension
            );

            $prod->add_order_files2(json_encode($file_info));
        }
    }
}
?>