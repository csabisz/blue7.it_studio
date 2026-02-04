<?php
//header("Content-type: image/jpeg");

include('functions.php');
include('domenia_db3.php');
$domenia3=new Domenia3;
$mc=new Production;

$local_document_root="/home/adminhdd/domains/blue7.it/public_html/studio";

if(isset($_GET['filecategory']))
{
	$filecategory=$mc->xss_fix($_GET['filecategory']);
	
	if($filecategory=="customerfiles")
	{
        if(isset($_GET['download-all']))
        {
			
            $o_id=$mc->xss_fix($_GET['download-all']);

            $zip = new ZipArchive();
            $zipFilePath = './tmp/'.md5(time().uniqid()).'.zip';
            $zip->open($zipFilePath, ZIPARCHIVE::OVERWRITE | ZIPARCHIVE::CREATE);
               
            $customer_files=$mc->get_customer_files($o_id); //table o_files

            for($i=0;$i<count($customer_files);$i++)
            {
                $path=$local_document_root."/client_files/".$customer_files[$i]['of_path_dom'].$customer_files[$i]['of_internal_name_dom'];
            
                $filesize=filesize($path);
                $file=$customer_files[$i]['of_name_client'];
                $tempfile=explode(".",$file);
        
                $file_extension=strtolower(end($tempfile));
                $file_basename=basename($file,".".$file_extension);        

                $zip->addFile($path, $file_basename.'.'.$file_extension);
            }

            $zip->close();

            header("Content-length: ".filesize($zipFilePath));
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=$zipFilePath");

            readfile($zipFilePath);

        } 
        else 
        {

		$imageid=$mc->xss_fix($_GET['imageid']);

		$result_files=$mc->get_customer_file($imageid);
		
		$path=$local_document_root."/client_files/".$result_files['of_path_dom'].$result_files['of_internal_name_dom'];
		$filesize=filesize($path);
		
        header("Content-length: ".$filesize);
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".$result_files['of_name_client']."\""); 
        readfile($path);
        }
	}
	
	if($filecategory=="creatorfiles")
	{
        if(isset($_GET['download-all'])){
			
            $o_id=$mc->xss_fix($_GET['download-all']);

            $all_finished_result_files=$mc->get_finished_result_files($o_id); //table o_results

            $zip = new ZipArchive();
            $zipFilePath = './tmp/'.md5(time().uniqid()).'.zip';
            $zip->open($zipFilePath, ZIPARCHIVE::OVERWRITE | ZIPARCHIVE::CREATE);
               

            for($j=0;$j<count($all_finished_result_files);$j++)
            {
                $customer_files=$mc->get_customer_files($all_finished_result_files[$j]['o_id']); //table o_files

                $internal_name="";

                //getting internal name
                for($i=0;$i<count($customer_files);$i++)
                {
                    $osub_id=substr($all_finished_result_files[$j]['osub_id'],1);

                    //checking if it is interior internal name

                    if(strpos($all_finished_result_files[$j]['osub_id'], 'n') !== false)
                    {
                        if($customer_files[$i]['of_position']==$osub_id)
                        {
                            $internal_name=$customer_files[$i]['of_name'];
                        }
                    }
                    else
                    {
                        if($customer_files[$i]['of_exterior_position']==$osub_id)
                        {
                            $internal_name=$customer_files[$i]['of_name_ex'];
                        }
                    }
                }

                $path=$local_document_root."/result_files/".$all_finished_result_files[$j]['orf_path_dom'].$all_finished_result_files[$j]['orf_internal_name_dom'];
            
                $filesize=filesize($path);
                $file=$all_finished_result_files[$j]['orf_name'];
                $tempfile=explode(".",$file);
        
                $file_extension=strtolower(end($tempfile));
                $file_basename=basename($file,".".$file_extension);        
        
                //adding internal name
        
                if(!empty($internal_name))
                {
                    $file_basename.=" - ".$internal_name;
                }
        
                //adding category name
        
                if(!empty($all_finished_result_files[$j]['pict_categ_name']))
                {
                    $file_basename.=" - ".$all_finished_result_files[$j]['pict_categ_name'];
                }

                $zip->addFile($path, $file_basename.'.'.$file_extension);
            }

            $zip->close();

            header("Content-length: ".filesize($zipFilePath));
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=$zipFilePath");

            readfile($zipFilePath);

		} 
        else 
        {

		$orfid=$mc->xss_fix($_GET['orfid']);
		
		$result_files=$mc->get_creator_file($orfid);
        $customer_files=$mc->get_customer_files($result_files['o_id']);
        
        $internal_name="";

        //getting internal name
        for($i=0;$i<count($customer_files);$i++)
        {
            $osub_id=substr($result_files['osub_id'],1);

            //checking if it is interior internal name

            if(strpos($result_files['osub_id'], 'n') !== false)
            {
                if($customer_files[$i]['of_position']==$osub_id)
                {
                    $internal_name=$customer_files[$i]['of_name'];
                }
            }
            else
            {
                if($customer_files[$i]['of_exterior_position']==$osub_id)
                {
                    $internal_name=$customer_files[$i]['of_name_ex'];
                }
            }
        }
        
        //$path=$local_document_root."/result_files/".$result_files['orf_path_dom'].$result_files['orf_internal_name_dom'];
        $path=$local_document_root."/result_files/".$result_files['orf_path_dom'].$result_files['orf_internal_name_dom'];
        $filesize=filesize($path);
        
        $file=$result_files['orf_name'];
        $tempfile=explode(".",$file);

        $file_extension=strtolower(end($tempfile));
        $file_basename=basename($file,".".$file_extension);        

        //adding internal name

        if(!empty($internal_name))
        {
            $file_basename.=" - ".$internal_name;
        }

        //adding category name

        if(!empty($result_files['pict_categ_name']))
        {
            $file_basename.=" - ".$result_files['pict_categ_name'];
        }

		header("Content-length: ".$filesize);
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"".$file_basename.".".$file_extension."\""); 

        readfile($path);
        //echo $path;
        }
	}
	
	if($filecategory=="correction_needed_files")
	{
		$cnf_id=$mc->xss_fix($_GET['cnf_id']);
		
		$result_files=$mc->get_correction_needed_file($cnf_id);
		
		$path=$local_document_root."/correction_needed_files/".$result_files['cnf_path_dom'].$result_files['cnf_internal_name_dom'];
		$filesize=filesize($path);
		header("Content-length: ".$filesize);
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"".$result_files['cnf_name']."\""); 

		readfile($path);

	}
	
	if($filecategory=="invoice")
	{
		$invoice_id=$mc->xss_fix($_GET['invoiceid']);
		$licence_id=$mc->xss_fix($_GET['licenceid']);
		$invoice=$domenia3->get_invoice_by_invid($licence_id,$invoice_id);
		
		$path=$local_document_root."/invoices/".$invoice['i_pdf_path'].$invoice['i_pdf_name'];
		$filesize=filesize($path);
		
		header("Content-length: ".$filesize);
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"invoice".$invoice['i_id']."-".$licence_id.".pdf\""); 
		
		readfile($path);
	}
}
?>

