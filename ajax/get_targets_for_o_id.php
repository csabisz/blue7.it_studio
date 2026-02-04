<?php
include('../functions.php');

$prod=new Production;
$base_url="https://blue7.it/studio/";

$o_id=$prod->xss_fix($_GET['o_id']);

$targets=$prod->get_all_targets_for_o_id($o_id);
                                    
for($t=0;$t<count($targets);$t++)
{
    ?>
    <div class="row" id="targets_row<?php echo $targets[$t]['ort_id'];?>">
        <div class="col-md-1">
            <b><?php echo $targets[$t]['ort_id'];?></b>
        </div>
        <div class="col-md-3">
            <input type="text" id="ort_url<?php echo $targets[$t]['ort_id'];?>" data-ort_id="<?php echo $targets[$t]['ort_id'];?>" name="ort_url<?php echo $targets[$t]['ort_id'];?>" class="form-control form-control-sm" value="<?php echo $targets[$t]['ort_url'];?>" placeholder="Add url with https://">
            <script type="text/javascript">
                $('#ort_url<?php echo $targets[$t]['ort_id'];?>').on('focusout',function(){

                    let ort_id=$(this).data('ort_id');
                    let ort_url=$(this).val();

                    $.ajax({
                        url: "<?php echo $base_url;?>ajax/update_ort_url.php",
                        method: "post",
                        data: {ort_id:ort_id,
                            ort_url:ort_url
                        },
                        dataType:"html",
                        success:function(data) {
                            
                        }
                    });
                });
            </script>
        </div>
        <div class="col-md-2">
            <input type="text" id="second_ort_url<?php echo $targets[$t]['ort_id'];?>" data-ort_id="<?php echo $targets[$t]['ort_id'];?>" name="second_ort_url<?php echo $targets[$t]['ort_id'];?>" class="form-control form-control-sm" value="<?php echo $targets[$t]['second_ort_url'];?>" placeholder="Second part url">
            <script type="text/javascript">
                $('#second_ort_url<?php echo $targets[$t]['ort_id'];?>').on('focusout',function(){

                    let ort_id=$(this).data('ort_id');
                    let second_ort_url=$(this).val();

                    $.ajax({
                        url: "<?php echo $base_url;?>ajax/update_second_ort_url.php",
                        method: "post",
                        data: {ort_id:ort_id,
                            second_ort_url:second_ort_url
                        },
                        dataType:"html",
                        success:function(data) {
                            
                        }
                    });
                });
            </script>
        </div>
        <div class="col-md-5">
            <input type="text" id="ort_text<?php echo $targets[$t]['ort_id'];?>" data-ort_id="<?php echo $targets[$t]['ort_id'];?>" name="ort_text<?php echo $targets[$t]['ort_id'];?>" class="form-control form-control-sm" value="<?php echo $targets[$t]['ort_text'];?>">
            <script type="text/javascript">
                $('#ort_text<?php echo $targets[$t]['ort_id'];?>').on('focusout',function(){

                    let ort_id=$(this).data('ort_id');
                    let ort_text=$(this).val();

                    $.ajax({
                        url: "<?php echo $base_url;?>ajax/update_ort_text.php",
                        method: "post",
                        data: {ort_id:ort_id,
                            ort_text:ort_text
                        },
                        dataType:"html",
                        success:function(data) {
                            
                        }
                    });
                });
            </script>
        </div>
        <div class="col-md-1">
            <button id="del_target_btn<?php echo $targets[$t]['ort_id'];?>" data-ort_id="<?php echo $targets[$t]['ort_id'];?>" class="btn btn-sm btn-danger">X</button>
            <script type="text/javascript">
                $('#del_target_btn<?php echo $targets[$t]['ort_id'];?>').click(function(){
                    if(confirm('Are you sure you want to delete ?'))
                    {
                        let ort_id=$(this).data('ort_id');

                        $.ajax({
                        url: "<?php echo $base_url;?>ajax/delete_ort_url.php",
                        method: "post",
                        data: {
                            ort_id:ort_id                            
                        },
                        dataType:"html",
                        success:function(data) {
                            $('#targets_row<?php echo $targets[$t]['ort_id'];?>').fadeOut(2000);
                        }
                    });
                    }
                });
            </script>
        </div>
    </div>
    <?php
}
?>
