<?php
include('../functions.php');

$prod=new Production;
$base_url="https://cseven.eu/studio/";

$orf_id=$prod->xss_fix($_GET['orf_id']);
$o_id=$prod->xss_fix($_GET['o_id']);

$masks=$prod->get_all_masks_for_orf_id($orf_id);
                                    
for($m=0;$m<count($masks);$m++)
{
    ?>
    <div class="row" id="mask_pictures_row<?php echo $masks[$m]['orme_id'];?>">
        <div class="col-md-12">

        <div class="row w-100">
            <div class="col-md-5">
                <input type="text" id="mask_coordinates<?php echo $masks[$m]['orme_id'];?>" data-orme_id="<?php echo $masks[$m]['orme_id'];?>" name="mask_coordinates<?php echo $masks[$m]['orme_id'];?>" class="form-control form-control-sm" value="<?php echo $masks[$m]['mask_coordinates'];?>">
                <script type="text/javascript">
                    $('#mask_coordinates<?php echo $masks[$m]['orme_id'];?>').on('focusout',function(){

                        let orme_id=$(this).data('orme_id');
                        let mask_coordinates=$(this).val();

                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/update_mask_coordinates.php",
                            method: "post",
                            data: {orme_id:orme_id,
                                mask_coordinates:mask_coordinates
                            },
                            dataType:"html",
                            success:function(data) {
                                
                            }
                        });
                    });
                </script>
            </div>
            <div class="col-md-auto">
                <b>Plot:</b>
            </div>
            <div class="col-md-4">
                <select id="plot<?php echo $masks[$m]['orme_id'];?>" data-orme_id="<?php echo $masks[$m]['orme_id'];?>" name="plot<?php echo $masks[$m]['orme_id'];?>" class="form-control form-control-sm">
                    <option value="0">--Select--</option>
                    <?php 
                    $plots=$prod->get_all_plots();
                                        
                    for($p=0;$p<count($plots);$p++)
                    {
                        ?>
                        <option value="<?php echo $plots[$p]['plot_id'];?>" <?php echo ($plots[$p]['plot_id']==$masks[$m]['plot_id'])?"selected":"";?>><?php echo "ID: ".$plots[$p]['plot_id']." ".$plots[$p]['city'].", ".$plots[$p]['street'].", ".$plots[$p]['house_no'];?></option>
                        <?php
                    }
                    ?>
                </select>
                <script type="text/javascript">
                    $('#plot<?php echo $masks[$m]['orme_id'];?>').on('change',function(){

                        let orme_id=$(this).data('orme_id');
                        let plot_id=$(this).val();

                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/update_mask_plot.php",
                            method: "post",
                            data: {orme_id:orme_id,
                                plot_id:plot_id
                            },
                            dataType:"html",
                            success:function(data) {
                                
                            }
                        });
                    });
                </script>
            </div> 
            <div class="col-md-1">
                <button id="del_mask_btn<?php echo $masks[$m]['orme_id'];?>" data-orme_id="<?php echo $masks[$m]['orme_id'];?>" class="btn btn-sm btn-danger">X</button>
                <script type="text/javascript">
                    $('#del_mask_btn<?php echo $masks[$m]['orme_id'];?>').click(function(){
                        if(confirm('Are you sure you want to delete ?'))
                        {
                            let orme_id=$(this).data('orme_id');

                            $.ajax({
                            url: "<?php echo $base_url;?>ajax/delete_mask_coordinates.php",
                            method: "post",
                            data: {
                                orme_id:orme_id                            
                            },
                            dataType:"html",
                            success:function(data) {
                                $('#mask_pictures_row<?php echo $masks[$m]['orme_id'];?>').fadeOut(2000);
                            }
                        });
                        }
                    });
                </script>
            </div>
        </div>
                    
        <div class="row">
            <div class="col-md-3">
                <b>Direct targets:</b>
            </div>
            <!-- <div id="targets_row<?php echo $masks[$m]['orme_id'];?>"> -->
            <?php
            //$targets=$prod->get_all_targets_for_o_id($o_id);
            $existing_target_ids=explode("|",$masks[$m]['ort_id']);
            
            for($t=0;$t<count($existing_target_ids);$t++)
            {
                if(!empty($existing_target_ids[$t]))
                {
                    $target=$prod->get_target_url($existing_target_ids[$t])
            ?>
            <div class="col-md-3">
                <span class="text-primary" style="cursor:pointer" data-toggle="modal" data-target="#editTargetModal<?= $masks[$m]['orme_id']; ?>"><?php 
                echo $target['ort_id'].": ".$target['second_ort_url']." ".$target['ort_text'];
                ?></span>
            </div>
            <?php
                }
            }
            ?>
            <!-- </div> -->
            <div class="col-md-1">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editTargetModal<?= $masks[$m]['orme_id']; ?>">Choose new target</button>
                <div class="modal fade" id="editTargetModal<?= $masks[$m]['orme_id']; ?>" tabindex="-1" aria-labelledby="editTargetModalLabel<?= $masks[$m]['orme_id']; ?>"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editTargetModalLabel<?= $masks[$m]['orme_id']; ?>">Choose targets for Mask ID <?= $masks[$m]['orme_id']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form name="update_targets_form<?php echo $masks[$m]['orme_id'];?>" id="update_targets_form<?php echo $masks[$m]['orme_id'];?>" method="post">
                                        <input type="hidden" name="orme_id" value="<?php echo $masks[$m]['orme_id'];?>">
                                        <?php
                                        $targets=$prod->get_all_targets_for_o_id($o_id);
                                        $existing_target_ids=explode("|",$masks[$m]['ort_id']);
                                        
                                        for($t=0;$t<count($targets);$t++)
                                        {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-1">
                                            <input type="checkbox" class="form-control form-control-sm target_ids" id="ort_id<?php 
                                            echo $targets[$t]['ort_id'];?>" name="ort_id[]" value="<?php 
                                            echo $targets[$t]['ort_id']."|";?>" <?php 
                                            if(in_array($targets[$t]['ort_id'],$existing_target_ids))
                                            {
                                                echo "checked";
                                            }
                                            ?>>
                                            </div>
                                            <div class="col-md-auto">
                                            <?php echo $targets[$t]['ort_url'];?><?php echo $targets[$t]['second_ort_url'];?>
                                            </div>
                                            <div class="col-md-4"><?php 
                                            echo $targets[$t]['ort_text'];
                                            ?></div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="save_targets_btn<?php echo $masks[$m]['orme_id'];?>" class="btn btn-primary">Save changes</button>
                                    <script type="text/javascript">
                                        $('#save_targets_btn<?php echo $masks[$m]['orme_id'];?>').click(function(){
                                            
                                            formData= new FormData($('#update_targets_form<?php echo $masks[$m]['orme_id'];?>')[0]);
                                            let orf_id=<?php echo $orf_id; ?>;
                                            let o_id=<?php echo $o_id; ?>;

                                            $.ajax({
                                                url: "<?php echo $base_url;?>ajax/update_mask_target.php",
                                                type: 'POST',
                                                data: formData,
                                                cache: false,
                                                dataType: 'text',
                                                processData: false, 
                                                contentType: false,
                                                enctype: 'multipart/form-data',
                                                dataType:"html",
                                                success:function(data) {
                                                    //$('#target<?php echo $masks[$m]['orme_id'];?>').val(data);
                                                    get_masks_for_orf_id(orf_id,o_id);
                                                    
                                                    //get_new_targets(<?= $masks[$m]['orme_id']; ?>);
                                                    
                                                }
                                            });
                                            $('#editTargetModal<?= $masks[$m]['orme_id']; ?>').modal('hide');
                                        });
                                        
                                        // function get_new_targets(orme_id)
                                        // {
                                        //     $('#targets_row'+orme_id).html("Refresh page");
                                        // }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <br>
        </div> <!-- end col- 12 -->
    </div> <!-- end row mask -->
    <?php
}
?>
