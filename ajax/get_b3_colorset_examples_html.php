<?php
include('../functions.php');

$prod=new Production;

$sl_id=$prod->xss_fix($_GET['sl_id']);
$cls_id=$prod->xss_fix($_GET['cls_id']);

$b3_colorset_examples=$prod->get_b3_colorset_examples($sl_id,$cls_id);
?>
<div class="row">
<?php

for($i=0;$i<count($b3_colorset_examples);$i++)
{
    ?>
    <div class="col-md-3">
        
        <img class="img-responsive" src="<?php echo $b3_colorset_examples[$i]['pic_link'];?>" alt="picture link">
        
    </div>
    <?php
 
}
?>
</div>