<?php
include('functions.php');
$mc=new Production;

//header("Content-type: image/png");

if(isset($_GET['filecategory']))
{
	$filecategory=$mc->xss_fix($_GET['filecategory']);
	
	if($filecategory=="creatorfiles")
	{
		$orfid=$mc->xss_fix($_GET['orfid']);
		
		$result_files=$mc->get_creator_file($orfid);
		
		$path=$_SERVER['DOCUMENT_ROOT']."/result_files/".$result_files['orf_path_dom'].$result_files['orf_internal_name_dom'];
		$filesize=filesize($path);
		
		//header("Content-type: image/jpg");
		
		//$img = imagecreatefromjpeg($path);
		//imagejpeg($img);
		//imagedestroy($img);
		
		$imgData = base64_encode(file_get_contents($path));

		// Format the image SRC:  data:{mime};base64,{data};
		$src = 'data: '.mime_content_type($path).';base64,'.$imgData;

		?>
		
		<img src="<?php echo $src; ?>" style="width:800px;" alt="popup_image">
		<?php
	}
	
	if($filecategory=="customerfiles")
	{
		$ofid=$mc->xss_fix($_GET['ofid']);
		
		$result_files=$mc->get_customer_file($ofid);
		
		$path=$_SERVER['DOCUMENT_ROOT']."/client_files/".$result_files['of_path_dom'].$result_files['of_internal_name_dom'];
		$filesize=filesize($path);
		
		//header("Content-type: image/jpg");
		
		//$img = imagecreatefromjpeg($path);
		//imagejpeg($img);
		//imagedestroy($img);
		
		$imgData = base64_encode(file_get_contents($path));

		// Format the image SRC:  data:{mime};base64,{data};
		$src = 'data: '.mime_content_type($path).';base64,'.$imgData;

		?>
		
		<img src="<?php echo $src; ?>" style="width:800px;" alt="popup_image">
		<?php
	}
}
?>
