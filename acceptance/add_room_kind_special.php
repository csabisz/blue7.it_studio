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
		    <p class="pt-4 display-4">Add room kind special</p>
            <hr class="mb-4" width="450px">
            <?php
            if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
            {
                if(isset($_POST['save_btn']))
                {
                    $data['o_id']=$prod->xss_fix($_POST['o_id']);
                    $data['room_number']=$prod->xss_fix($_POST['room_number']);
                    $data['trans_id']=$prod->xss_fix($_POST['trans_id']);
                    $data['rks_description']=$prod->xss_fix($_POST['rks_description']);

                    if(!empty($data['o_id']))
                    {
                        $check_existing_room_kind_special=$prod->check_existing_room_kind_special(json_encode($data));
                        //print_r($check_existing_room_kind_special);
                        if(empty($check_existing_room_kind_special))
                        {
                        $prod->add_room_kind_special(json_encode($data));

                    ?>
                    <div class="alert alert-success text-center">Saved successfully !</div>
                    <meta http-equiv="refresh" content="2; url=add_room_kind_special.php?o_id=<?php echo $data['o_id']; ?>">
                    <?php
                        }
                        else
                        {
                            ?>
                            <div class="alert alert-danger text-center">Already exists ! Not Saved !</div>
                            <?php
                        }
                    }
                }
            ?>
            <form id="add_room_kind_special_form" name="add_room_kind_special_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $o_id;?>"></form>
            <div class="row border-top border-bottom mx-0 w-100">
				<div class="col-md-12 text-left pl-4 pt-3" style="background-color:#c4c4c4;">
                    <div class="row">
                        <div class="col-md-2">Order ID</div>
                        <div class="col-md-2"><input type="text" id="o_id" name="o_id" value="<?php echo $o_id;?>" class="form-control form-control-sm" form="add_room_kind_special_form" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Room number</div>
                        <div class="col-md-2"><input type="text" id="room_number" name="room_number" class="form-control form-control-sm" form="add_room_kind_special_form" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Translation id</div>
                        <div class="col-md-2">
                        <select class="form-control form-control-sm" id="trans_id" name="trans_id" form="add_room_kind_special_form" required>
                            <option value="">--Select--</option>
                            <?php
                            $room_kinds=$prod->get_all_room_kinds_by_language(1);

                            for($r=0;$r<count($room_kinds);$r++)
                            {
                                ?>
                                <option value="<?php echo $room_kinds[$r]['text_id'];?>"><?php echo $room_kinds[$r]['text'];?></option>
                                <?php
                            }
                            ?>
                        </select></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Description</div>
                        <div class="col-md-2"><input type="text" id="rks_description" name="rks_description" class="form-control form-control-sm" form="add_room_kind_special_form"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center"><button class="btn btn-sm btn-primary" id="save_btn" name="save_btn" type="submit" form="add_room_kind_special_form">Save</button></div>                        
                    </div>
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