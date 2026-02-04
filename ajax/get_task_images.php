<?php
include('../functions.php');
$prod = new Production;

$o_id = $_GET["o_id"];
$k = $_GET["k"];
$validextensions = array("jpeg", "jpg", "png");


$b3_interior_products_with_extensions = $prod->get_b3_interior_products_with_extensions($o_id);
$task_full_name = $b3_interior_products_with_extensions[$k]['o_id'] . "_" . $b3_interior_products_with_extensions[$k]['osub_id'] . "_" . $b3_interior_products_with_extensions[$k]['prod_id'];





if ($b3_interior_products_with_extensions[$k]['om_id'] != 0) {

    $result_files = $prod->show_results($b3_interior_products_with_extensions[$k]['o_id'], $b3_interior_products_with_extensions[$k]['osub_id'], $b3_interior_products_with_extensions[$k]['prod_id']);

} else {

    $result_files = $prod->show_results($o_id, $b3_interior_products_with_extensions[$k]['osub_id'], $b3_interior_products_with_extensions[$k]['prod_id']);

}

$nv_counter = 0; //Not visible files
$vcl_counter = 0; //Clients visible files
$tot_counter = 0; //Total files counter
for ($i = 0; $i < count($result_files); $i++) {


    if ($result_files[$i]['orf_status'] == 0) {
        $nv_counter++;
    }
    if ($result_files[$i]['orf_status'] == 8 || $result_files[$i]['orf_status'] == 6) {
        $vcl_counter++;
    }
    $tot_counter++;

    ?>

    <!--                  Rolout Class   <div class="collapse" id="rollout_--><?php //echo $task_full_name ?><!--">-->

    <div class="row w-100 mx-0 border-top border-white <?php echo ($result_files[$i]['orf_status'] == 0) ? "grey-dark" : "light-green"; ?>"
         id="result_file<?php echo $result_files[$i]['orf_id']; ?>">

        <div class="col-6 py-2 text-center px-0 d-flex align-items-start">

            <div class="row mx-0 w-100 d-flex justify-content-center align-items-start">

                <div class="col-2 p-0 d-flex align-items-center">


                    <?php

                    if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) {

                        ?>

                        <div id="image_tooltip_container_<?php echo $image_preview_counter; ?>">

                            <?php

                            if (!empty($result_files[$i]['orf_thumbnail_path'])) {

                                ?>

                                <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                   target="_blank"><img
                                            src="https://bauvorschau.com/index.php/images/optimized/100/100/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                            alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                            width="60"
                                            heigth="33.78"
                                            class="img-responsive d-inline img-fluid"></a>

                                <?php

                            } else {

                                ?>

                                <a href="https://bauvorschau.com/index.php/images/optimized/100/1000/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                   target="_blank"><img
                                            src="https://bauvorschau.com/index.php/images/optimized/100/100/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                            alt="<?php echo $result_files[$i]['orf_name']; ?>"
                                            width="60"
                                            heigth="33.78"
                                            class="img-responsive d-inline img-fluid"></a>

                                <?php

                            }

                            ?>

                        </div>


                        <?php

                    }

                    ?>

                </div>

                <div class="col-10 px-0 d-flex align-items-center flex-row">

                    <div class="justify-content-center w-100">

                        <div class="file-name w-100 text-center d-flex flex-column justify-content-center">

                            <p class="mb-0 pt-0 d-flex justify-content-center align-items-center"
                               style="font-size: 13px;">

                                <?php

                                $file_name1 = explode("-", $result_files[$i]['orf_name']);

                                $file_name2 = explode(".", $result_files[$i]['orf_name']);


                                $first_part_with_space = $file_name1[0];

                                $first_part = str_replace(' ', '', $first_part_with_space);

                                echo $first_part;

                                ?>

                                <input type="text" style="max-height: 18px;max-width: 70px;"
                                       name="file_name"
                                       id="file_name<?php echo $result_files[$i]['orf_id'] ?>"
                                       value="<?php

                                       $middle_part_with_space = explode('.', $file_name1[1]);

                                       $middle_part = str_replace(' ', '', $middle_part_with_space);

                                       echo $middle_part[0];

                                       ?>" data-file_name_first_part="<?php

                                echo $first_part . " - ";

                                ?>" data-file_name_last_part="<?php

                                $last_part = end($file_name2);

                                echo "." . $last_part;

                                ?>" class="form-control form-control-sm"><?php

                                echo "." . $last_part;

                                ?>

                            </p>
                            <div class="row w-100 mx-0 px-0 d-flex justify-content-center">
                                <button id="rename_btn<?php echo $result_files[$i]['orf_id'] ?>"
                                        class="btn btn-sm btn-primary mt-1 d-inline rounded-0"
                                        style="font-size: 13px;">Rename
                                </button>
                            </div>
                            <script type="text/javascript">

                                $('#rename_btn<?php echo $result_files[$i]['orf_id']?>').click(function () {

                                    $.ajax({
                                        url: "<?php echo $base_url;?>ajax/rename_result_file.php",
                                        method: "post",
                                        data: {
                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                            file_name: $('#file_name<?php echo $result_files[$i]['orf_id']?>').val(),
                                            file_name_first_part: $('#file_name<?php echo $result_files[$i]['orf_id']?>').data('file_name_first_part'),
                                            file_name_last_part: $('#file_name<?php echo $result_files[$i]['orf_id']?>').data('file_name_last_part')
                                        },

                                        dataType: "html",
                                        success: function (data) {

                                        }

                                    });

                                });

                            </script>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 px-0 py-2">

            <p class="w-100 text-center mb-0" style="font-size: 12px;"><?php

                $creator = $prod->get_client($result_files[$i]['uca_id']);

                if (!empty($creator['c_last_name'])) {

                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];

                } else {

                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];

                }

                $uploaded_date_time = explode(" ", $result_files[$i]['orf_upload_date']);

                echo " " . $uploaded_date_time[0] . ", " . $uploaded_date_time[1] . " UTC+0"; ?></p>

            <div class="w-100 d-flex justify-content-center">

                <div class="form-group mb-0">

                    <select name="result_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                            id="result_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                            class="form-control form-control-sm">

                        <option value="0" <?php echo ($result_files[$i]['orf_status'] == 0) ? "selected" : ""; ?>>
                            Not visible
                        </option>

                        <option value="7" <?php echo ($result_files[$i]['orf_status'] == 7) ? "selected" : ""; ?>>
                            Visible for checkers
                        </option>

                        <option value="8" <?php echo ($result_files[$i]['orf_status'] == 8) ? "selected" : ""; ?>>
                            Visible for client
                        </option>

                    </select>

                    <script type="text/javascript">

                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                            $.ajax({

                                url: "../ajax/change_results_file_visibility.php",

                                method: "get",

                                data: {
                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                    orf_status: $(this).val()
                                },

                                dataType: "html",

                                success: function (data) {

                                    if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8) {

                                        $('#result_file<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark").addClass("light-green");

                                    } else {

                                        $('#result_file<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green").addClass("grey-dark");

                                    }

                                }

                            });

                        });

                    </script>

                </div>

                <a href="../image.php?filecategory=creatorfiles&orfid=<?php echo $result_files[$i]['orf_id']; ?>"
                   class="btn btn-sm btn-primary align-self-center ml-1">Download</a>

                <button id="delete_btn<?php echo $result_files[$i]['orf_id']; ?>"
                        class="btn btn-sm btn-danger text-white align-self-center ml-1">x
                </button>

                <script type="text/javascript">

                    $('#delete_btn<?php echo $result_files[$i]['orf_id']?>').click(function () {

                        if (confirm('Are you sure want to delete ?')) {

                            $.ajax({

                                url: "../ajax/delete_result_file.php",

                                method: "post",

                                data: {orf_id:<?php echo $result_files[$i]['orf_id'];?>},

                                dataType: "html",

                                success: function (data) {

                                    $('#result_file<?php echo $result_files[$i]['orf_id'];?>').fadeOut(3000);

                                }

                            });

                        }

                    });

                </script>

            </div>

        </div>

        <div class="col-6 px-2 py-0">

            <p class="my-0 d-flex" style="font-size:12px;">
                <span class="pt-1 d-flex">Title:</span>
                <input id="title<?php echo $result_files[$i]['orf_id']; ?>"
                       list="img_categ2_<?php echo $result_files[$i]['orf_id']; ?>"
                       class="form-control form-control-sm" type="text"
                       value="<?php echo $result_files[$i]['pict_categ_name']; ?>">
                <?php
                if ((substr($result_files[$i]['prod_id'], -2) === '00') ||
                    (substr($result_files[$i]['prod_id'], -2) === '01') ||
                    (substr($result_files[$i]['prod_id'], -2) === '02') ||
                    (substr($result_files[$i]['prod_id'], -2) === '03') ||
                    (substr($result_files[$i]['prod_id'], -2) === '21') ||
                    (substr($result_files[$i]['prod_id'], -2) === '22') ||
                    (substr($result_files[$i]['prod_id'], -2) === '23') ||
                    (substr($result_files[$i]['prod_id'], -2) === '41') ||
                    (substr($result_files[$i]['prod_id'], -2) === '42') ||
                    (substr($result_files[$i]['prod_id'], -2) === '43')
                ) {
                    ?>
                    <datalist id="img_categ2_<?php echo $result_files[$i]['orf_id']; ?>"
                              data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
                        <option value="EG">EG</option>
                        <option value="OG">OG</option>
                        <option value="OG 1">OG 1</option>
                        <option value="OG 2">OG 2</option>
                        <option value="DG">DG</option>
                        <option value="KG">KG</option>
                    </datalist>
                    <?php
                }
                ?>
                <script type="text/javascript">
                    $('#title<?php echo $result_files[$i]['orf_id'];?>').on("keyup", function () {
                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                            method: "post",
                            data: {
                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                img_categ: $(this).val()
                            },
                            dataType: "html",
                            success: function (data) {

                            }
                        });
                    });
                </script>
            </p>

        </div>

        <div class="col-6 px-0 py-0 text-right">

            <p class="my-0 pr-5" style="font-size:12px;">
                size: <?php echo $filesize = $prod->filesize_formatted("../result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']); ?></p>

        </div>

    </div> <!-- end result files -->

    <!--                    </div> Rolout Class END-->
    <?php

    $image_preview_counter++;

}
?>
<script>
    document.getElementById("btn_rollout_<?php echo $task_full_name ?>").innerText = "Show files <?php echo $tot_counter?>";
    document.getElementById("counter_rollout_<?php echo $task_full_name ?>").innerText = "<?php echo 'Not visible: ' . $nv_counter . ' Visible: ' . $vcl_counter?>";
</script>