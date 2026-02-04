<?php
include('../functions.php');

$prod=new Production;

$house_id=$prod->xss_fix($_GET['house_id']);

if($house_id!=0)
{
$house_type=$prod->get_house_type($house_id);
?>
<a href="https://bauvorschau.com/<?php echo $house_type['presentation_id'];?>" class="btn btn-sm btn-primary" target="_blank">Presentation</a>
<?php
}
?>