<?php
include('../functions.php');

$prod=new Production;
$base_url="https://blue7.it/studio/";

$o_id=$prod->xss_fix($_GET['o_id']);
$osub_id=$prod->xss_fix($_GET['osub_id']);
$prod_id=$prod->xss_fix($_GET['prod_id']);

$result_files=$prod->show_results($o_id,$osub_id,$prod_id);

for($i=0;$i<count($result_files);$i++)
{
    ?>
    <div class="row" id="row<?php echo $result_files[$i]['orf_id']; ?>">
        <div class="col-md-5">
            <input type="text" id="suntour_model_id<?php echo $result_files[$i]['orf_id']; ?>" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" class="form-control form-control-sm" value="<?php echo $result_files[$i]['suntour_model_id'];?>" placeholder="Add model ID here">
            <script type="text/javascript">
                $('#suntour_model_id<?php echo $result_files[$i]['orf_id']; ?>').on('focusout',function(){

                    let orf_id=$(this).data('orf_id');
                    let suntour_model_id=$(this).val();

                    $.ajax({
                        url: "<?php echo $base_url;?>ajax/update_suntour_model_id.php",
                        method: "post",
                        data: {
                            orf_id:orf_id,
                            suntour_model_id: suntour_model_id
                        },
                        dataType: "html",
                        success: function (data) {
                            
                        }
                        });                    

                });
            </script>
        </div>
        <div class="col-md-5">

        <div class="row">
            <div class="col-md-6">
                <b>Sales status</b>                                
            </div>
            <div class="col-md-6">
            <select id="result_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                    name="result_files_visibility"
                    class="form-control form-control-sm <?php echo ($result_files[$i]['orf_status'] == 8) ? "light-green" : ""; ?>">
                <option value="0" <?php echo ($result_files[$i]['orf_status'] == 0) ? "selected" : ""; ?>>
                    Not visible
                </option>
                <?php
                if (($result_files[$i]['prod_id'] != "p156y") && ($result_files[$i]['prod_id'] != "p156z") &&
                    ($result_files[$i]['prod_id'] != "p166y") && ($result_files[$i]['prod_id'] != "p166z") &&
                    ($result_files[$i]['prod_id'] != "p176y") && ($result_files[$i]['prod_id'] != "p176z") &&
                    ($result_files[$i]['prod_id'] != "p186y") && ($result_files[$i]['prod_id'] != "p186z")) {
                    ?>
                    <option value="7" <?php echo ($result_files[$i]['orf_status'] == 7) ? "selected" : ""; ?>>
                        Visible for checkers
                    </option>
                    <option value="8" <?php echo ($result_files[$i]['orf_status'] == 8) ? "selected" : ""; ?>>
                        Visible to the customer
                    </option>
                    <?php
                }

                if /*(($result_files[$i]['prod_id'] == "p156y") || ($result_files[$i]['prod_id'] == "p156z") ||
                    ($result_files[$i]['prod_id'] == "p166y") || ($result_files[$i]['prod_id'] == "p166z") ||
                    ($result_files[$i]['prod_id'] == "p176y") || ($result_files[$i]['prod_id'] == "p176z") ||
                    ($result_files[$i]['prod_id'] == "p186y") || ($result_files[$i]['prod_id'] == "p186z")) */
                    (substr($result_files[$i]['prod_id'], -1) == 'y')
                    {
                    ?>
                    <option value="6" <?php echo ($result_files[$i]['orf_status'] == 6) ? "selected" : ""; ?>>
                        Configurator-2D
                    </option>
                    <?php
                }
                ?>
            </select>
            <script type="text/javascript">
                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                    $.ajax({
                        url: "<?php echo $base_url;?>ajax/change_results_file_visibility.php",
                        method: "get",
                        data: {
                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                            orf_status: $(this).val()
                        },
                        dataType: "html",
                        success: function (data) {
                            if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8) {
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("light-green");
                            } else if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 7) {
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("orange");
                            } else {
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                            }
                        }
                    });
                });
            </script>
            
            </div>
            </div>

        </div>
        <div class="col-md-1">
            <button class="btn btn-sm btn-danger" id="delete_btn<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" type="button">X</button>
            <script type="text/javascript">
            $('#delete_btn<?php echo $result_files[$i]['orf_id'];?>').click(function(){
                
                if(confirm('Are you sure you want to delete ?'))
                {
                    let orf_id=$(this).data('orf_id');

                    $.ajax({
                        url: "<?php echo $base_url;?>ajax/delete_result_file.php",
                        method: "post",
                        data: {
                            orf_id:orf_id                            
                        },
                        dataType: "html",
                        success: function (data) {
                            $('#row<?php echo $result_files[$i]['orf_id']; ?>').fadeOut(2000);
                        }
                    });  

                }
            })
            </script>
        </div>
    </div>
    <?php
}
?>