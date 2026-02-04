<?php
session_start();
include('../functions.php');

$prod=new Production;

$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$o_id=$prod->xss_fix($_GET['o_id']);

include('../header2.php');
include('../menu.php');

$client=$prod->get_client($_COOKIE['client_id']);
?>
<section class="top_section">
	<article>
		<div class="container text-center pagecontent bg-white px-0">
		    <p class="pt-4 display-4">Edit room kind special</p>
            <hr class="mb-4" width="450px">
            <?php
            if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
            {
                
            ?>
            <form id="add_room_kind_special_form" name="add_room_kind_special_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $o_id;?>"></form>
            <div class="row border-top border-bottom mx-0 w-100">
				<div class="col-md-12 text-left pl-4 pt-3" style="background-color:#c4c4c4;">
                    <div class="row">
                        <div class="col-md-2"><b>Order ID</b></div>
                        <div class="col-md-2"><b>Room number</b></div>
                        <div class="col-md-2"><b>Translation id</b></div>
                        <div class="col-md-4"><b>Description</b></div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <?php
                    $room_kind_special=$prod->get_all_room_kind_special($o_id);

                    for($r=0;$r<count($room_kind_special);$r++)
                    {
                    ?>
                    <div class="row" id="room_kind_special<?php echo $room_kind_special[$r]['rks_id'];?>">
                        <div class="col-md-2"><?php echo $room_kind_special[$r]['o_id'];?></div>
                        <div class="col-md-2"><?php echo $room_kind_special[$r]['room_number'];?></div>
                        <div class="col-md-2"><?php 
                        echo $translation_text=$prod->get_translation_text(1, $room_kind_special[$r]['rm_tx'])['text'];?></div>
                        <div class="col-md-4"><?php echo $room_kind_special[$r]['rks_description'];?></div>
                        <div class="col-md-2">
                            <a href="update_room_kind_special.php?rks_id=<?php echo $room_kind_special[$r]['rks_id'];?>" class="btn btn-sm btn-primary">Change</a> 
                            <button id="del_btn<?php echo $room_kind_special[$r]['rks_id'];?>" name="del_btn<?php echo $room_kind_special[$r]['rks_id'];?>" data-rks_id="<?php echo $room_kind_special[$r]['rks_id'];?>" type="button" class="btn btn-sm btn-danger">X</button></div>
                    </div>
                    <script type="text/javascript">
                        $('#del_btn<?php echo $room_kind_special[$r]['rks_id'];?>').click(function(){

                            if(confirm('Are you sure you want to delete ?'))
                            {
                                let rks_id=$('#del_btn<?php echo $room_kind_special[$r]['rks_id'];?>').data('rks_id');

                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/delete_room_kind_special.php",
                                    method: "post",
                                    data: { rks_id:rks_id },
                                    dataType:"html",
                                    success:function(data) {

                                        $('#room_kind_special<?php echo $room_kind_special[$r]['rks_id'];?>').fadeOut(3000);	

                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                    });
                                
                            }
                        });
                    </script>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            else
            {
                session_unset();
                session_destroy();
                ?>
                <div class="text-center">				
                    <div class="error">You must be logged in to view this page !</div>
                    <a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
                    <br ><br >
                </div>
                <meta http-equiv="refresh" content="2; url=<?php echo $base_url;?>index.php">
                <?php
            }
            ?>
        </div>
    </article>
</section>
<?php
include('../footer.php');
?>