<div class="row w-100 mx-0">
    <div class="col-md-12">
        <p class="w-100 text-center"><b><a id="all_uploaded_result_files">Result file(s) for <?php echo $o_id . "." . $osub_id . "." . $prod_id; ?> - <?php
        $subid_data['o_id']=$o_id;
        $subid_data['o_sub_id']=$osub_id;

        $subo_name=$prod->check_existing_subid(json_encode($subid_data));

        echo $subo_name['subo_name'];
        ?></a></b></p>
    </div>
</div>
<?php
if(strpos($osub_id, 'n') !== false)
{
    ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id;?>&prod_id=<?php echo $prod_id;?>" class="btn btn-sm btn-primary">Total</a>
            <a href="<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id;?>&prod_id=<?php echo $prod_id;?>&room_id=0" class="btn btn-sm btn-primary">Unspecified</a>
            <?php
            $room_data['o_id']=$o_id;
            $room_data['osub_id']=$osub_id;

            $all_rooms=$prod->get_all_rooms_for_this_sub_id(json_encode($room_data));
            for($r=0;$r<count($all_rooms);$r++)
            {
            ?>
            <a href="<?php echo $_SERVER['PHP_SELF'];?>?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id;?>&prod_id=<?php echo $prod_id;?>&room_id=<?php echo $all_rooms[$r]['room_id'];?>" class="btn btn-sm btn-primary">R <?php
            echo $all_rooms[$r]['room_number']; ?> - <?php echo $all_rooms[$r]['room_name'];
            ?></a>
            <?php
            }
            ?>
        </div>
    </div>
    <br>
    <?php
}

if(
    (substr($prod_id, -2)=="6m")||(substr($prod_id, -2)=="gm")
)
{
    ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <b>Base picture</b>
            </div>
            <div class="col-md-4">
                <b>Mask coordinates</b>
            </div>

            <div class="col-md-1">
            </div>
        </div>
        <?php
        $base_picture_results = $prod->show_results($o_id, $osub_id, substr($prod_id, 0,4)."b");

        for($b=0;$b<count($base_picture_results);$b++)
        {
        ?>
        <div class="row">
            <div class="col-md-2">
                <a href="<?php echo $base_url;?>result_compress_files/<?php echo $base_picture_results[$b]['orf_compress_path'];?>" target="_blank"><img src="<?php echo $base_url;?>result_compress_files/<?php echo $base_picture_results[$b]['orf_compress_path'];?>" alt="<?php echo $base_picture_results[$b]['orf_name'];?>" class="img-fluid"></a>
                <?php echo $base_picture_results[$b]['pict_categ_name'];?>
            </div>
            <div class="col-md-10">
                <div id="masks<?php echo $base_picture_results[$b]['orf_id'];?>"></div>
                <div class="row">
                    <div class="col-md-12 text-left">
                        <button id="new_mask_btn<?php echo $base_picture_results[$b]['orf_id'];?>" data-orf_id="<?php echo $base_picture_results[$b]['orf_id'];?>" data-o_id="<?php echo $base_picture_results[$b]['o_id'];?>" class="btn btn-sm btn-primary">New mask 4 this picture</button>
                        <script type="text/javascript">
                            $('#new_mask_btn<?php echo $base_picture_results[$b]['orf_id'];?>').click(function(){
                                let orf_id=$(this).data('orf_id');
                                let o_id=$(this).data('o_id');

                                $.ajax({
                                url: "<?php echo $base_url;?>ajax/create_masks_for_orf_id.php",
                                method: "post",
                                data: {
                                    orf_id: orf_id
                                },
                                dataType: "html",
                                success: function (data) {

                                    get_masks_for_orf_id(orf_id,o_id);

                                }
                                });

                            });

                            $(document).ready(function(){
                                get_masks_for_orf_id(<?php echo $base_picture_results[$b]['orf_id'];?>,<?php echo $base_picture_results[$b]['o_id'];?>);
                            });

                            function get_masks_for_orf_id(orf_id,o_id)
                            {
                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/get_masks_for_orf_id.php",
                                    method: "GET",
                                    data: {
                                        orf_id: orf_id,
                                        o_id:o_id
                                    },
                                    dataType: "html",
                                    success: function (data) {
                                    $('#masks'+orf_id).html(data);

                                    }
                                });
                            }

                        </script>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div style="border-width: 3px;border-style: solid;"></div>
        <br>
        <?php
        }
        ?>
    </div>
    <?php
}

if(substr($prod_id, -2)=="6t")
{
    ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-1">
                <b>Target ID</b>
            </div>
            <div class="col-md-5">
                <b>Link</b>
            </div>
            <div class="col-md-5">
                <b>Text 4 hover</b>
            </div>
            <div class="col-md-1">
            </div>
        </div>
        <div id="targets">

        </div>
        <div class="row">
            <div class="col-md-12">
                <button id="new_targets_btn" data-o_id="<?php echo $o_id;?>" class="btn btn-sm btn-primary">New target</button>
                <script type="text/javascript">
                    $('#new_targets_btn').click(function(){
                        let o_id=$(this).data('o_id');

                        $.ajax({
                        url: "<?php echo $base_url;?>ajax/create_targets_for_o_id.php",
                        method: "post",
                        data: {
                            o_id: o_id
                        },
                        dataType: "html",
                        success: function (data) {

                            get_targets_for_o_id(o_id);

                        }
                        });

                    });

                    $(document).ready(function(){
                        get_targets_for_o_id(<?php echo $o_id;?>);
                    });

                    function get_targets_for_o_id(o_id)
                    {
                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/get_targets_for_o_id.php",
                            method: "GET",
                            data: {
                                o_id: o_id
                            },
                            dataType: "html",
                            success: function (data) {

                                $('#targets').html(data);

                            }
                        });
                    }

                </script>
            </div>
        </div>
    </div>
    <?php
}

if(
    (substr($prod_id, -2)=="8s")||(substr($prod_id, -2)=="gs")
    )
{
    ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <b>Suntour model ID</b>
            </div>
            <div class="col-md-5">
                <b>Customer view</b>
            </div>
        </div>
        <div id="suntour_models">
        </div>
        <div class="row">
                <div class="col-md-12">
                    <button id="new_suntour_model_btn" data-o_id="<?php
                    echo $o_id;?>" data-osub_id="<?php
                    echo $osub_id;?>" data-prod_id="<?php
                    echo $prod_id;?>" data-uca_id="<?php
                    echo $_COOKIE['client_id'];?>" class="btn btn-sm btn-primary">New suntour model</button>
                    <script type="text/javascript">
                        $('#new_suntour_model_btn').click(function(){
                            let o_id=$(this).data('o_id');
                            let osub_id=$(this).data('osub_id');
                            let prod_id=$(this).data('prod_id');
                            let uca_id=$(this).data('uca_id');

                            $.ajax({
                            url: "<?php echo $base_url;?>ajax/create_suntour_model.php",
                            method: "post",
                            data: {
                                o_id: o_id,
                                osub_id: osub_id,
                                prod_id: prod_id,
                                uca_id: uca_id
                            },
                            dataType: "html",
                            success: function (data) {

                                get_suntour_models(o_id,osub_id,prod_id);

                            }
                            });

                        });

                        $(document).ready(function(){
                            get_suntour_models(<?php echo $o_id;?>,"<?php echo $osub_id;?>","<?php echo $prod_id;?>");
                        });

                        function get_suntour_models(o_id,osub_id,prod_id)
                        {
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/get_suntour_models.php",
                                method: "GET",
                                data: {
                                    o_id: o_id,
                                    osub_id: osub_id,
                                    prod_id: prod_id
                                },
                                dataType: "html",
                                success: function (data) {

                                    $('#suntour_models').html(data);

                                }
                            });
                        }

                    </script>
                </div>
            </div>
        </div>
    <?php
}

if(substr($prod_id, -1)=="v")
{
    ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <b>VR link</b>
            </div>
            <div class="col-md-5">
                <b>Customer view</b>
            </div>
        </div>
        <div id="vr_links">
        </div>
        <div class="row">
                <div class="col-md-12">
                    <button id="new_vr_link_btn" data-o_id="<?php
                    echo $o_id;?>" data-osub_id="<?php
                    echo $osub_id;?>" data-prod_id="<?php
                    echo $prod_id;?>" data-uca_id="<?php
                    echo $_COOKIE['client_id'];?>" class="btn btn-sm btn-primary">New VR link</button>
                    <script type="text/javascript">
                        $('#new_vr_link_btn').click(function(){
                            let o_id=$(this).data('o_id');
                            let osub_id=$(this).data('osub_id');
                            let prod_id=$(this).data('prod_id');
                            let uca_id=$(this).data('uca_id');

                            $.ajax({
                            url: "<?php echo $base_url;?>ajax/create_vr_link.php",
                            method: "post",
                            data: {
                                o_id: o_id,
                                osub_id: osub_id,
                                prod_id: prod_id,
                                uca_id: uca_id
                            },
                            dataType: "html",
                            success: function (data) {

                                get_vr_links(o_id,osub_id,prod_id);

                            }
                            });

                        });

                        $(document).ready(function(){
                            get_vr_links(<?php echo $o_id;?>,"<?php echo $osub_id;?>","<?php echo $prod_id;?>");
                        });

                        function get_vr_links(o_id,osub_id,prod_id)
                        {
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/get_vr_links.php",
                                method: "GET",
                                data: {
                                    o_id: o_id,
                                    osub_id: osub_id,
                                    prod_id: prod_id
                                },
                                dataType: "html",
                                success: function (data) {

                                    $('#vr_links').html(data);

                                }
                            });
                        }

                    </script>
                </div>
            </div>
        </div>
    <?php
}

if(
    (substr($prod_id, -2)!="6t")&&(substr($prod_id, -2)!="6m")&&(substr($prod_id, -2)!="8s")&&(substr($prod_id, -1)!="v")&&
    (substr($prod_id, -2)!="gt")&&(substr($prod_id, -2)!="gm")&&(substr($prod_id, -2)!="gs")
    )
{
    ?>
    <div class="col-md-12">
        <?php
        $result_files = $prod->show_results_with_rooms($o_id, $osub_id, $prod_id,$room_id);
        // print_r($result_files);
        $count_prev_img = 0;
        for ($i = 0; $i < count($result_files); $i++) {
            $count_prev_img = 0;

            if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) {
                $count_prev_img++;
            }
        }
        ?>
        <div class="row mx-0 w-100 border-top border-dark">
            <div class="col-3 border-right border-left border-dark px-0">Name + Title</div>
            <div class="col-2 border-right border-dark px-0">Image</div>
            <?php
            if((substr($prod_id, -1) === '8'))
            {
                ?>
                <div class="col-2 border-right border-dark px-0">External link</div>
                <?php
            }
            else
            {
                ?>
                <div class="col-2 border-right border-dark px-0">&nbsp;</div>
                <?php
            }
            ?>
            <!--<div class="col-2 border-right border-dark px-0"></div> -->
            <?php /* <div class="col-1 border-right border-dark px-0">Img Nr</div> */ ?>
            <div class="col-5 border-right border-dark px-0">Customer View</div>
        </div>
    </div> <!--end table header -->
    <div class="col-md-12">
    <?php
    $result_files = $prod->show_results_with_rooms($o_id, $osub_id, $prod_id,$room_id);
    if(
        ($prod_id!="p168s")||(substr($prod_id, -2)!="gs")
        )
    {

    for ($i = 0; $i < count($result_files); $i++)
    {

        if($result_files[$i]['no_result_file']!=1)
        {
        ?>
        <div class="row w-100 mx-0 border-dark dark-gray" style="border-color:#000;border-style:solid;border-bottom-width: 3px;border-left-width: 1px;border-right-width: 1px;border-top-width: 1px;" id="result_file_row<?php echo $result_files[$i]['orf_id']; ?>">
            <div class="col-md-3 border-right border-dark px-0 py-1">
                <div class="d-flex">

                    <?php if(substr($result_files[$i]['prod_id'], -2) == '2y'):?>

                        <?php include '2d_konfigurator_nameing_tool.php'; ?>

                    <?php else:?>

                    <?php

                    $file_name1 = explode("-", $result_files[$i]['orf_name']);
                    $file_name2 = explode(".", $result_files[$i]['orf_name']);

                    $input_file_name = explode('.', $file_name1[1]);
                    unset($input_file_name[count($input_file_name) - 1]);
                    $input_file_name = implode('.', $input_file_name);
                    $input_file_name = str_replace(' ', '', $input_file_name);

                    $first_part_with_space = $file_name1[0];
                    $first_part = str_replace(' ', '', $first_part_with_space);

                    echo $first_part . " - ";
                    ?>
                    &nbsp;<input type="text" id="orf_name<?php echo $result_files[$i]['orf_id']; ?>"
                                    class="form-control form-control-sm"
                                    data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>"
                                    value="<?php echo $input_file_name ?>" data-file_name_first_part="<?php
                    echo $first_part . " - ";
                    ?>" data-file_name_last_part="<?php
                    $last_part = end($file_name2);
                    echo "." . $last_part;
                    ?>" style="width:9em;"><?php
                    echo "." . $last_part;
                    ?>

                    <?php endif;?>

                </div>

                <?php
                $creator = $prod->get_client($result_files[$i]['uca_id']);
                if (!empty($creator['c_last_name'])) {
                    echo $creator['c_first_name'] . " " . $creator['c_last_name'];
                } else {
                    echo $creator['l_first_name'] . " " . $creator['l_last_name'];
                }
                ?>

                <?php echo $result_files[$i]['orf_upload_date'] . " UTC+0"; ?>
                <script type="text/javascript">
                    $('#orf_name<?php echo $result_files[$i]['orf_id'];?>').on('blur', function () {
                        var orf_id = $(this).data("orf_id");
                        var orf_name = $(this).val();
                        var file_name_first_part = $(this).data("file_name_first_part");
                        var file_name_last_part = $(this).data("file_name_last_part");

                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/update_orf_name.php",
                            method: "POST",
                            data: {
                                orf_id: orf_id,
                                orf_name: orf_name,
                                file_name_first_part: file_name_first_part,
                                file_name_last_part: file_name_last_part
                            },
                            dataType: "text",
                            success: function (data) {
                                // Swal.fire({
                                //     position: 'center',
                                //     icon: 'success',
                                //     title: 'File name Updated',
                                //     showConfirmButton: false,
                                //     timer: 1500
                                // })
                            }
                        });
                    });
                </script>
                <?php
                $pict_categ_name = $prod->get_pict_categ_name($result_files[$i]['orf_name']);
                ?>
                <form class="" action="<?php echo $base_url . htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
                    <?php
                    if(substr($result_files[$i]['prod_id'], -1) === 'y')
                    {
                        ?>
                        <div class="row">
                            <?php
                            $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                            $pict_categ_name_array=explode(".",$result_files[$i]['pict_categ_name']);                                                       
                            $countMainImage = 0;
                            $countDoorShapeImage = 0;

                            if($result_files[$i]['orf_type_dom']=="jpg")
                            {
                                ?>
                            
                                <div class="col-md-auto text-truncate">
                                
                                    <div id="change_existing_classification<?php echo $result_files[$i]['orf_id']?>" class="existing_classification">    
                                        <?php
                                        if(!empty($result_files[$i]['config_level']))
                                        {
                                            $picture_area=$prod->get_picture_area($result_files[$i]['config_level']);
                                            echo (!empty($picture_area['pa_description']))?$picture_area['pa_description']:"Classify ?";
                                        }
                                        else
                                        {
                                            echo "Classify ?";
                                        }
                                        ?>
                                    </div>
                                    <script type="text/javascript">
                                        $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                            
                                            $(this).css('cursor','pointer'); 
                                                                                                        
                                        });

                                    </script>        
                                    <input type="hidden" name="pa_id" id="pa_id<?php echo $result_files[$i]['orf_id']?>" value="<?php echo $result_files[$i]['config_level']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <img id="selected_shape_picture<?php echo $result_files[$i]['orf_id'];?>" src="<?php 
                                    $door_shapes_pictures=$prod->get_all_door_shapes();

                                    for($p=0;$p<count($door_shapes_pictures);$p++)
                                    {
                                        if($pict_categ_name_array[1]==$door_shapes_pictures[$p]['dsp_id'])
                                        {
                                            $countDoorShapeImage++;
                                            echo "https://domenia.blue7.it/".$door_shapes_pictures[$p]['dsp_pic'];
                                        }
                                    }

                                    $roof_shapes_pictures=$prod->get_all_roof_shapes();

                                    for($p=0;$p<count($roof_shapes_pictures);$p++)
                                    {
                                        if($pict_categ_name_array[1]==$roof_shapes_pictures[$p]['rs_id'])
                                        {
                                            $countDoorShapeImage++;
                                            echo "https://domenia.blue7.it/".$roof_shapes_pictures[$p]['rs_pic'];
                                        }
                                    }

                                    $gutters_shapes_pictures=$prod->get_all_gutters();

                                    for($p=0;$p<count($gutters_shapes_pictures);$p++)
                                    {
                                        if($pict_categ_name_array[1]==$gutters_shapes_pictures[$p]['gut_id'])
                                        {
                                            $countDoorShapeImage++;
                                            echo "https://domenia.blue7.it/".$gutters_shapes_pictures[$p]['gut_pic'];
                                        }
                                    }
                                    ?>" alt="<?php 
                                    if(count($pict_categ_name_array)==1)
                                    {
                                        echo ucfirst($pict_categ_name_array[0]);
                                    }
                                    if(count($pict_categ_name_array)==2)
                                    {
                                        if(strpos($pict_categ_name_array[1],"_org")!== false)
                                        {
                                            echo "Original";
                                        }
                                        else
                                        { 
                                            echo "What is it ?";
                                        }
                                    }
                                    
                                    ?>" class="door_shapes <?php 
                                    if($countDoorShapeImage === 0) echo 'broken_door_shape_image' ?>" data-pa_id="<?php echo $picture_area['pa_id']; ?>" style="width:50px;height:50px;" whidth="50" height="50">
                                </div>
                                <?php
                            }

                            if($result_files[$i]['orf_type_dom']!="jpg")
                            {
                                ?>
                                <!-- <div class="float-left" style=""> -->
                                <div class="col-md-3" style="">
                                    <img id="selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>" src="<?php 
                                    for($p=0;$p<count($configurator_pictures);$p++)
                                    {
                                        if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id'])
                                        {
                                            $countMainImage++;
                                            echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];
                                        }
                                    }
                                    ?>" alt="Choose main picture" class="configurator_pictures <?php if($countMainImage === 0) echo 'broken_image_main' ?>" style="width:50px;height:50px;">
                                    <script type="text/javascript">
                                        <?php
                                        if(substr($result_files[$i]['prod_id'], -1) === 'y')
                                        {
                                            ?>
                                            $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                                                $('#picture_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                                            });    

                                            $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                                    $(this).css('cursor','pointer');                                                    
                                            });
                                            <?php
                                        }
                                        ?>
                                    </script>
                                </div>
                                <!-- <div class="float-right" style="display: flex;"> -->
                                <div class="col-md-auto text-truncate">
                                
                                    <div id="change_existing_classification<?php echo $result_files[$i]['orf_id']?>" class="existing_classification">    
                                        <?php
                                        if(!empty($result_files[$i]['config_level']))
                                        {
                                            $picture_area=$prod->get_picture_area($result_files[$i]['config_level']);
                                            echo (!empty($picture_area['pa_description']))?$picture_area['pa_description']:"Classify ?";
                                        }
                                        else
                                        {
                                            echo "Classify ?";
                                        }
                                        ?>
                                    </div>
                                    <script type="text/javascript">
                                        $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                            
                                            $(this).css('cursor','pointer'); 
                                                                                                        
                                        });

                                    </script>        
                                    <input type="hidden" name="pa_id" id="pa_id<?php echo $result_files[$i]['orf_id']?>" value="<?php echo $result_files[$i]['config_level']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <img id="selected_shape_picture<?php echo $result_files[$i]['orf_id'];?>" src="<?php 
                                    $door_shapes_pictures=$prod->get_all_door_shapes();

                                    for($p=0;$p<count($door_shapes_pictures);$p++)
                                    {
                                        if($pict_categ_name_array[1]==$door_shapes_pictures[$p]['dsp_id'])
                                        {
                                            $countDoorShapeImage++;
                                            echo "https://domenia.blue7.it/".$door_shapes_pictures[$p]['dsp_pic'];
                                        }
                                    }

                                    $roof_shapes_pictures=$prod->get_all_roof_shapes();

                                    for($p=0;$p<count($roof_shapes_pictures);$p++)
                                    {
                                        if($pict_categ_name_array[1]==$roof_shapes_pictures[$p]['rs_id'])
                                        {
                                            $countDoorShapeImage++;
                                            echo "https://domenia.blue7.it/".$roof_shapes_pictures[$p]['rs_pic'];
                                        }
                                    }

                                    $gutters_shapes_pictures=$prod->get_all_gutters();

                                    for($p=0;$p<count($gutters_shapes_pictures);$p++)
                                    {
                                        if($pict_categ_name_array[1]==$gutters_shapes_pictures[$p]['gut_id'])
                                        {
                                            $countDoorShapeImage++;
                                            echo "https://domenia.blue7.it/".$gutters_shapes_pictures[$p]['gut_pic'];
                                        }
                                    }
                                    ?>" alt="<?php 
                                    
                                    if(strpos($pict_categ_name_array[1],"_org")!== false)
                                    {
                                        echo "Original";
                                    }
                                    else
                                    { echo "What is it ?";}?>" class="door_shapes <?php 
                                    if($countDoorShapeImage === 0) echo 'broken_door_shape_image' ?>" data-pa_id="<?php echo $picture_area['pa_id']; ?>" style="width:50px;height:50px;" whidth="50" height="50">
                                </div>
                                <?php
                            }
                            ?>
                            <input id="img_categ<?php echo $result_files[$i]['orf_id']; ?>"
                            data-id1="<?php echo $result_files[$i]['orf_id']; ?>"
                            class="form-control" type="hidden"
                            value="<?php 
                            echo $pict_categ_name_array[0];                                                
                                ?>">
                            <script type="text/javascript">
                                $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').click(function(){
                                    $('#existing_classifyModal<?php echo $result_files[$i]['orf_id'];?>').modal('show');
                                });
                            </script>
                            <!-- Modal -->
                            <div class="modal fade" id="existing_classifyModal<?php echo $result_files[$i]['orf_id'];?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="existing_classifyModalLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="existing_classifyModalLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose clasification</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">                                                    
                                        <?php
                                        $all_classifications=$prod->get_all_picture_areas();
                                        $classification_counter=0;
                                        for($s=0;$s<count($all_classifications);$s++)
                                        {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pa_id[]" id="existing_pa_id_<?php echo $result_files[$i]['orf_id'];?>_<?php echo $classification_counter;?>" value="<?php 
                                                        echo $all_classifications[$s]['pa_id'];?>" data-pa_description="<?php echo $all_classifications[$s]['pa_description'];?>" <?php 
                                                        echo ($all_classifications[$s]['pa_id']==$result_files[$i]['config_level'])?"checked":"";
                                                        ?>>
                                                        <label class="form-check-label" for="existing_pa_id_<?php echo $result_files[$i]['orf_id'];?>_<?php echo $classification_counter;?>">
                                                            <?php echo $all_classifications[$s]['pa_id'];?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php echo $all_classifications[$s]['pa_description'];?>
                                                </div>                                                    
                                            </div>
                                            <script type="text/javascript">
                                                $('#existing_pa_id_<?php echo $result_files[$i]['orf_id'];?>_<?php echo $classification_counter;?>').click(function(){
                                                    let pa_id=$(this).val();
                                                    let pa_description=$(this).data('pa_description');
                                                    let o_id=<?php echo $o_id;?>;
                                                    let osub_id="<?php echo $osub_id;?>";
                                                    let prod_id="<?php echo $prod_id;?>";
                                                    let orf_id=<?php echo $result_files[$i]['orf_id'];?>;

                                                    $('#change_existing_classification<?php echo $result_files[$i]['orf_id']?>').text(pa_description);
                                                    $('#pa_id<?php echo $result_files[$i]['orf_id']?>').val(pa_id);

                                                    $.ajax({
                                                        url: "<?php echo $base_url;?>ajax/update_orf_id_config_level.php",
                                                        method: "post",
                                                        data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,orf_id:orf_id,config_level:pa_id},
                                                        dataType:"html",
                                                        success:function(data) {

                                                            

                                                        }
                                                    });

                                                    
                                                });
                                            </script>
                                            <?php
                                            $classification_counter++;
                                        }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                    </div>
                                    </div>
                                </div>
                            </div> <!-- end Modal -->
                            <script type="text/javascript">
                                $('#existing_classifyModal<?php echo $result_files[$i]['orf_id'];?>').on('hidden.bs.modal', function () {
                                    setTimeout(function () {
                                                                
                                        var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                        window.location.href = redirectToURL;
                                        window.location.reload(true);

                                    }, 100);
                                });
                            </script>
                            <!-- Modal -->
                            <div class="modal fade" id="picture_select<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose picture</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                        
                                        for($p=0;$p<count($configurator_pictures);$p++)
                                        {
                                            ?>
                                            <div class="row p-3">
                                                <div class="col-md-6">
                                                    <img id="configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>" class="configurator_pictures <?php if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id']){echo "configurator_pictures_clicked";}?>" src="<?php echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];?>" data-orf_id="<?php echo $configurator_pictures[$p]['orf_id'];?>" alt="No picture">
                                                    <script type="text/javascript">
                                                        

                                                        $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').hover(function(){
                                                            $(this).css('cursor','pointer');
                                                            
                                                        });

                                                        $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').click(function(){
                                                            
                                                            $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').attr('value',$('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').data('orf_id'));
                                                            
                                                            $('.configurator_pictures').removeClass('configurator_pictures_clicked');
                                                            $(this).addClass('configurator_pictures_clicked');
                                                            
                                                            
                                                                let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".dsp_002";
                                                                //let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                                let img_categ=img_categ1;
                                                            
                                                            
                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                        img_categ:img_categ
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {

                                                                    }
                                                                }).done(function(){

                                                                    let srcValue = $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').attr('src');
                                                                    $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                });

                                                        });

                                                    </script>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="door_shape_select<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="door_shape_selectLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="door_shape_selectLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose what shall be shown</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                if($result_files[$i]['config_level']=="pa0000")
                                                {
                                                    
                                                    ?>
                                                    <div class="row">    
                                                        <div class="col-md-6">            
                                                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Interior" data-base_render_id="interior" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Interior
                                                            </div>                
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Exterior" data-base_render_id="exterior" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Exterior
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        $('.original_shape').hover(function(){
                                                            $(this).css('cursor','pointer');                        
                                                        });
                                                    </script>
                                                    <br>
                                                    <script type="text/javascript">
                                                        $('.shape_pictures').hover(function(){
                                                            $(this).css('cursor','pointer');                        
                                                        });
                                                
                                                        $('.shape_pictures').click(function(){
                                                            let srcValue = $(this).attr('src');
                                                            let altValue = $(this).attr('alt');
                                                
                                                            // $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
                                                            // $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
                                                            // $('#chosen_shape_id<?php echo $f;?>').val($(this).data('base_render_id'));
                                                
                                                            $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                            $(this).addClass('shape_pictures_clicked');
                                                            
                                                            
                                                            //let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                            let img_categ2=$(this).data('base_render_id');
                                                            let orf_id=$(this).data('orf_id');
                                                            
                                                        
                                                            $.ajax({
                                                                url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                method: "post",
                                                                data: {
                                                                    orf_id:orf_id,
                                                                    img_categ:img_categ2
                                                                },
                                                                dataType: "html",
                                                                success: function (data) {

                                                                }
                                                            }).done(function(){

                                    
                                                                $('#selected_shape_picture'+orf_id).attr('src', srcValue);
                                                                $('#selected_shape_picture'+orf_id).attr('alt', altValue);

                                                                $.ajax({
                                                                    url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                    method: "post",
                                                                    data: {
                                                                        orf_id:orf_id,
                                                                        o_id:<?php echo $o_id;?>,
                                                                        osub_id:"<?php echo $osub_id;?>",
                                                                        prod_id:"<?php echo $prod_id;?>",
                                                                        pa_symbol:img_categ2,
                                                                        connected_to:0,
                                                                        pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                    },
                                                                    dataType: "html",
                                                                    success: function (data) {

                                                                    }
                                                                }).done(function(){

                                                                    
                                                                });
                                                                
                                                            });

                                                            // $('#new_upload_btn').removeClass('btn-default');
                                                            // $('#new_upload_btn').addClass('btn-success');
                                                            // $("#new_upload_btn").prop("disabled", false);
                                                        });
                                                
                                                    </script>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa0110")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='wall_area_main_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').attr('src');
                                                                            let altValue = $('#wall_area_main_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_main_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa0120")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='wall_area_2_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').attr('src');
                                                                            let altValue = $('#wall_area_2_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_2_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa0130")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='wall_area_3_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').attr('src');
                                                                            let altValue = $('#wall_area_3_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_wall_area_3_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa0140")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='floor_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('src');
                                                                            let altValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa0180")
                                                {
                                                    $door_shape_pictures=$prod->get_all_door_shapes();
                                                    $door_shape_counter=0;
                                                    for($p=0;$p<count($door_shape_pictures);$p++)
                                                    {
                                                        if(($door_shape_pictures[$p]['dsp_color_db']=="blue dark")&&(!empty($door_shape_pictures[$p]['dsp_pic']))&&($door_shape_counter<4))
                                                        {
                                                            ?>
                                                            <div class="row p-3">
                                                                <div class="col-md-6">
                                                                    <img id="door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php 
                                                                    echo $door_shape_pictures[$p]['dsp_id'];?>" class="door_shape_pictures <?php 
                                                                    if($pict_categ_name_array[1]==$door_shape_pictures[$p]['dsp_id']){echo "door_shape_pictures_clicked";}?>" src="<?php 
                                                                    echo "https://domenia.blue7.it/".$door_shape_pictures[$p]['dsp_pic'];?>" data-dsp_id="<?php 
                                                                    echo $door_shape_pictures[$p]['dsp_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                                    <script type="text/javascript">
                                                                        

                                                                        $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').hover(function(){
                                                                            $(this).css('cursor','pointer');
                                                                            
                                                                        });

                                                                        $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').click(function(){
                                                                            
                                                                            //$('#selected_door_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('value',$('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').data('dsp_id'));
                                                                            
                                                                            $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                            $(this).addClass('door_shape_pictures_clicked');
                                                                            
                                                                            
                                                                                let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                                let img_categ2=$(this).data('dsp_id');
                                                                                let img_categ=img_categ1+img_categ2;
                                                                            
                                                                            
                                                                                $.ajax({
                                                                                    url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                                    method: "post",
                                                                                    data: {
                                                                                        orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                        img_categ:img_categ
                                                                                    },
                                                                                    dataType: "html",
                                                                                    success: function (data) {

                                                                                    }
                                                                                }).done(function(){

                                                                                    let srcValue = $('#door_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $door_shape_pictures[$p]['dsp_id'];?>').attr('src');
                                                                                    $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                                    $.ajax({
                                                                                        url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                        method: "post",
                                                                                        data: {
                                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                            o_id:<?php echo $o_id;?>,
                                                                                            osub_id:"<?php echo $osub_id;?>",
                                                                                            prod_id:"<?php echo $prod_id;?>",
                                                                                            pa_symbol:img_categ2,
                                                                                            connected_to:img_categ1,
                                                                                            pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                        },
                                                                                        dataType: "html",
                                                                                        success: function (data) {

                                                                                        }
                                                                                    }).done(function(){

                                                                                        
                                                                                    });

                                                                                });

                                                                        });

                                                                    </script>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $door_shape_counter++;
                                                        }    
                                                    }
                                                }

                                                if($result_files[$i]['config_level']=="pa0170")
                                                {
                                                    $roof_shape_pictures=$prod->get_all_roof_shapes();
                                                    
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });


                                                                $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='rs_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').attr('src');
                                                                            let altValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_rs_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });

                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                    for($r=0;$r<count($roof_shape_pictures);$r++)
                                                    {
                                                        ?>
                                                        <div class="row p-3">
                                                            <div class="col-md-6">
                                                                
                                                                <img id="roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>" src="<?php 
                                                            echo "https://domenia.blue7.it/".$roof_shape_pictures[$r]['rs_pic'];?>" data-rs_id="<?php 
                                                            echo $roof_shape_pictures[$r]['rs_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                            </div>
                                                        </div>
                                                        <script type="text/javascript">
                                                                        

                                                            $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').hover(function(){
                                                                $(this).css('cursor','pointer');
                                                                
                                                            });

                                                            $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').click(function(){
                                                                
                                                                
                                                                
                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                $(this).addClass('door_shape_pictures_clicked');
                                                                
                                                                
                                                                    let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                    let img_categ2=$(this).data('rs_id');
                                                                    let img_categ=img_categ1+img_categ2;
                                                                
                                                                
                                                                    $.ajax({
                                                                        url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                        method: "post",
                                                                        data: {
                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                            img_categ:img_categ
                                                                        },
                                                                        dataType: "html",
                                                                        success: function (data) {

                                                                        }
                                                                    }).done(function(){

                                                                        let srcValue = $('#roof_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $roof_shape_pictures[$r]['rs_id'];?>').attr('src');
                                                                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                o_id:<?php echo $o_id;?>,
                                                                                osub_id:"<?php echo $osub_id;?>",
                                                                                prod_id:"<?php echo $prod_id;?>",
                                                                                pa_symbol:img_categ2,
                                                                                connected_to:img_categ1,
                                                                                pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            
                                                                        });

                                                                    });

                                                            });

                                                        </script>
                                                        <?php
                                                        
                                                    }
                                                }

                                                if($result_files[$i]['config_level']=="pa0140")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='floor_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('src');
                                                                            let altValue = $('#floor_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_floor_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa0200")
                                                {
                                                    $gutters_shape_pictures=$prod->get_all_gutters();
                                                    
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });


                                                                $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='gut_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').attr('src');
                                                                            let altValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_gut_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });

                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                    for($r=0;$r<count($gutters_shape_pictures);$r++)
                                                    {
                                                        ?>
                                                        <div class="row p-3">
                                                            <div class="col-md-6">
                                                                
                                                                <img id="gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>" src="<?php 
                                                            echo "https://domenia.blue7.it/".$gutters_shape_pictures[$r]['gut_pic'];?>" data-gut_id="<?php 
                                                            echo $gutters_shape_pictures[$r]['gut_id'];?>" class="door_shape_pictures" alt="No picture" style="width:auto;height:150px;">
                                                            </div>
                                                        </div>
                                                        <script type="text/javascript">
                                                                        

                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').hover(function(){
                                                                $(this).css('cursor','pointer');
                                                                
                                                            });

                                                            $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').click(function(){
                                                                
                                                                
                                                                
                                                                $('.door_shape_pictures').removeClass('door_shape_pictures_clicked');
                                                                $(this).addClass('door_shape_pictures_clicked');
                                                                
                                                                
                                                                    let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                    let img_categ2=$(this).data('gut_id');
                                                                    let img_categ=img_categ1+img_categ2;
                                                                
                                                                
                                                                    $.ajax({
                                                                        url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                        method: "post",
                                                                        data: {
                                                                            orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                            img_categ:img_categ
                                                                        },
                                                                        dataType: "html",
                                                                        success: function (data) {

                                                                        }
                                                                    }).done(function(){

                                                                        let srcValue = $('#gutters_shape_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $gutters_shape_pictures[$r]['gut_id'];?>').attr('src');
                                                                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);

                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                o_id:<?php echo $o_id;?>,
                                                                                osub_id:"<?php echo $osub_id;?>",
                                                                                prod_id:"<?php echo $prod_id;?>",
                                                                                pa_symbol:img_categ2,
                                                                                connected_to:img_categ1,
                                                                                pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            
                                                                        });

                                                                    });

                                                            });

                                                        </script>
                                                        <?php
                                                        
                                                    }
                                                }

                                                if($result_files[$i]['config_level']=="pa1010")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='extra_layer_1_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').attr('src');
                                                                            let altValue = $('#extra_layer_1_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_1_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa1020")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='extra_layer_2_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').attr('src');
                                                                            let altValue = $('#extra_layer_2_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_2_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa1030")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='extra_layer_3_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').attr('src');
                                                                            let altValue = $('#extra_layer_3_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_3_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($result_files[$i]['config_level']=="pa1040")
                                                {                                                                        
                                                    ?>
                                                    <div class="row p-3">
                                                        <div class="col-md-6">                                                                                
                                                            <div id="extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org" class="shape_pictures original_shape border border-rounded" src="#" alt="Original" style="width:150px;height:200px;background-color:#f0f0f0;">
                                                                Original
                                                            </div>
                                                            <script type="text/javascript">
                                                                $('.original_shape').hover(function(){
                                                                    $(this).css('cursor','pointer');                        
                                                                });

                                                                $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').hover(function(){
                                                                    $(this).css('cursor','pointer');
                                                                    
                                                                });

                                                                $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').click(function(){                                                                                       
                                                                    
                                                                    
                                                                    $('.shape_pictures').removeClass('shape_pictures_clicked');
                                                                    $(this).addClass('shape_pictures_clicked');
                                                                    
                                                                    
                                                                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".";
                                                                        let img_categ2='extra_layer_4_org';
                                                                        let img_categ=img_categ1+img_categ2;
                                                                    
                                                                    
                                                                        $.ajax({
                                                                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                            method: "post",
                                                                            data: {
                                                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                img_categ:img_categ
                                                                            },
                                                                            dataType: "html",
                                                                            success: function (data) {

                                                                            }
                                                                        }).done(function(){

                                                                            let srcValue = $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').attr('src');
                                                                            let altValue = $('#extra_layer_4_picture_<?php echo $result_files[$i]['orf_id']; ?>_extra_layer_4_org').attr('alt');
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                                            $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').attr('alt', altValue);

                                                                            $.ajax({
                                                                                url: "<?php echo $base_url;?>ajax/insert_or_update_o_results_configurator_plus.php",
                                                                                method: "post",
                                                                                data: {
                                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                                    o_id:<?php echo $o_id;?>,
                                                                                    osub_id:"<?php echo $osub_id;?>",
                                                                                    prod_id:"<?php echo $prod_id;?>",
                                                                                    pa_symbol:img_categ2,
                                                                                    connected_to:img_categ1,
                                                                                    pa_id:"<?php echo $result_files[$i]['config_level'];?>"
                                                                                },
                                                                                dataType: "html",
                                                                                success: function (data) {

                                                                                }
                                                                            }).done(function(){

                                                                                
                                                                            });
                                                                            
                                                                        });

                                                                });

                                                            </script>        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                ?>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        <?php
                    }
                    elseif(substr($result_files[$i]['prod_id'], -1) === 'z')
                    {
                        $pict_categ_name_array=explode(".",$result_files[$i]['pict_categ_name']);
                        ?>
                        <input id="img_categ_part2<?php echo $result_files[$i]['orf_id']; ?>" class="form-control" type="text" value="<?php echo $pict_categ_name_array[2];?>" style="">
                        <?php
                    }
                    else
                    {
                        ?>
                        <input id="img_categ<?php echo $result_files[$i]['orf_id']; ?>"
                            list="img_categ2" data-id1="<?php echo $result_files[$i]['orf_id']; ?>"
                            class="form-control" type="text"
                            value="<?php echo $result_files[$i]['pict_categ_name']; ?>">
                        <?php
                    }

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
                        <datalist id="img_categ2"
                                    data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
                            <option value="EG">EG</option>
                            <option value="OG">OG</option>
                            <option value="OG 1">OG 1</option>
                            <option value="DG">DG</option>
                            <option value="KG">KG</option>
                        </datalist>
                        <?php
                    }

                    if ((substr($result_files[$i]['prod_id'], -2) === '04') ||
                        (substr($result_files[$i]['prod_id'], -2) === '06') ||
                        (substr($result_files[$i]['prod_id'], -2) === '24') ||
                        (substr($result_files[$i]['prod_id'], -2) === '26')
                    ) {
                        ?>
                        <datalist id="img_categ2"
                        data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
                        <option value="Bad">Bad</option>
                        <option value="Büro">Büro</option>
                        <option value="Essen">Essen</option>
                        <option value="Flur">Flur</option>
                        <option value="Hobby">Hobby</option>
                        <option value="Küche">Küche</option>
                        <option value="Schlafen">Schlafen</option>
                        <option value="WC">WC</option>
                        <option value="WEK">WEK</option>
                        <option value="Wohnen">Wohnen</option>
                        </datalist>
                        <?php
                    }

                    if (($result_files[$i]['prod_id'] == "p1563") || ($result_files[$i]['prod_id'] == "p1583") ||
                        ($result_files[$i]['prod_id'] == "p1663") || ($result_files[$i]['prod_id'] == "p1683") ||
                        ($result_files[$i]['prod_id'] == "p1763") || ($result_files[$i]['prod_id'] == "p1783") ||
                        ($result_files[$i]['prod_id'] == "p1863") || ($result_files[$i]['prod_id'] == "p1883")) 
                    {
                        ?>
                        <datalist id="img_categ2"
                                    data-id1="<?php echo $result_files[$i]['orf_id']; ?>">
                            <option value="1-2-terra">1-2-terra</option>
                            <option value="1-2-normal">1-2-normal</option>
                            <option value="1-2-plus">1-2-plus</option>
                            <option value="1-2-top">1-2-top</option>
                            <option value="2-3-terra">2-3-terra</option>
                            <option value="2-3-normal">2-3-normal</option>
                            <option value="2-3-plus">2-3-plus</option>
                            <option value="2-3-top">2-3-top</option>
                            <option value="3-4-terra">3-4-terra</option>
                            <option value="3-4-normal">3-4-normal</option>
                            <option value="3-4-plus">3-4-plus</option>
                            <option value="3-4-top">3-4-top</option>
                            <option value="4-1-terra">4-1-terra</option>
                            <option value="4-1-normal">4-1-normal</option>
                            <option value="4-1-plus">4-1-plus</option>
                            <option value="4-1-top">4-1-top</option>
                        </datalist>
                        <?php
                    }
                    ?>
                </form>

                <script type="text/javascript">
                    <?php
                    if(substr($result_files[$i]['prod_id'], -1) === 'y')
                    {
                        ?>
                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                            $('#door_shape_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                        });    

                        $('#selected_shape_picture<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                $(this).css('cursor','pointer');                                                    
                        });
                        <?php
                    }                                        
                    ?>
                    $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').on("keyup focusout change", function () {

                        <?php
                        if(substr($result_files[$i]['prod_id'], -1) === 'y')
                        {
                            ?>
                            let img_categ=$(this).val()+".total";
                            <?php
                        }
                        elseif(substr($result_files[$i]['prod_id'], -1) === 'z')
                        {
                            ?>
                            let img_categ1=$(this).val()+".colors.";
                            let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                            let img_categ=img_categ1+img_categ2;
                            <?php
                        }
                        else
                        {
                            ?>
                            let img_categ=$(this).val();
                            <?php
                        }
                        ?>
                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                            method: "post",
                            data: {
                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                img_categ:img_categ
                            },
                            dataType: "html",
                            success: function (data) {

                            }
                        });
                    });

                    <?php
                    if(substr($result_files[$i]['prod_id'], -1) === 'z')
                    {
                    ?>
                    $('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').on("keyup focusout", function () {
                        
                        let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".colors.";
                        let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                        let img_categ=img_categ1+img_categ2;
                            
                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                            method: "post",
                            data: {
                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                img_categ:img_categ
                            },
                            dataType: "html",
                            success: function (data) {

                            }
                        });
                        });
                    <?php
                    }
                    ?>
                </script>
                <?php
                if(
                ((substr($prod_id,1)>1100)&&(substr($prod_id,1)<1160))||
                ((substr($prod_id,1)>1299)&&(substr($prod_id,1)<1360))||
                ((substr($prod_id,1)>1499)&&(substr($prod_id,1)<1560))||
                ((substr($prod_id,1)>1599)&&(substr($prod_id,1)<1660))||
                ((substr($prod_id,1)>1699)&&(substr($prod_id,1)<1760))||
                ((substr($prod_id,1)>1799)&&(substr($prod_id,1)<1860))||
                (substr($prod_id, -2)=="2y")
                )
                {
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <b>Assign to room number:</b>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control form-control-sm" id="room_id<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" name="room_id">
                                <option value="0">Unspecified</option>
                                <?php
                                $rooms_data['o_id']=$o_id;
                                $rooms_data['osub_id']=$osub_id;

                                $rooms=$prod->get_all_rooms_for_this_sub_id(json_encode($rooms_data));

                                for($r=0;$r<count($rooms);$r++)
                                {
                                    ?>
                                    <option value="<?php echo $rooms[$r]['room_id'];?>" <?php echo ($rooms[$r]['room_id']==$result_files[$i]['room_id'])?"selected":"";?>><?php
                                    echo $rooms[$r]['room_number']." - ";
                                    echo $translation=$prod->get_translation_text(1, $rooms[$r]['rk_id'])['text'];
                                    ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                            $('#room_id<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                let orf_id=$(this).data('orf_id');
                                let room_id=$(this).val();

                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/assign_room_id_to_result_file.php",
                                    method: "post",
                                    data: {
                                        orf_id:orf_id,
                                        room_id: room_id
                                    },
                                    dataType: "html",
                                    success: function (data) {

                                    }
                                });
                            });
                        </script>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if(
                (substr($prod_id, -2)=="6b")||(substr($prod_id, -2)=="gb")
                )
                {
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <b>Assign to perspective:</b>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control form-control-sm" id="per_id<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" name="per_id">
                                <option value="0">Unspecified</option>
                                <?php
                                $perspective_data['o_id']=$o_id;
                                $perspective_data['osub_id']=$osub_id;

                                $perspective=$prod->get_all_perspectives_for_this_sub_id(json_encode($perspective_data));

                                for($r=0;$r<count($perspective);$r++)
                                {
                                    ?>
                                    <option value="<?php echo $perspective[$r]['per_id'];?>" <?php echo ($perspective[$r]['per_id']==$result_files[$i]['per_id'])?"selected":"";?>><?php
                                    echo $perspective[$r]['per_kind'];
                                    ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                            $('#per_id<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                let orf_id=$(this).data('orf_id');
                                let per_id=$(this).val();

                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/assign_per_id_to_result_file.php",
                                    method: "post",
                                    data: {
                                        orf_id:orf_id,
                                        per_id: per_id
                                    },
                                    dataType: "html",
                                    success: function (data) {

                                    }
                                });
                            });
                        </script>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="col-md-2 border-right border-dark px-0 py-1">
                <?php
                if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) {
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                    <div id="image_tooltip_container_<?php
                    echo $image_preview_counter;
                    ?>">
                        <img class="img-responsive" style="width:60px;cursor:pointer;"
                                src="<?php echo $base_url;?>result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                                alt="<?php echo $result_files[$i]['orf_name']; ?>">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <?php 
                    if(strpos($_SERVER['REQUEST_URI'],"coordination") !== false)
                    {
                        echo $filesize = $prod->filesize_formatted("../result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']);
                    }
                    else
                    {
                        echo $filesize = $prod->filesize_formatted("result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']);
                    } ?>
                    </div>
                    </div>
                    <?php
                } else { ?>

                    <?php
                    $file_path = $result_files[$i]['orf_internal_name_dom'];

                    // Get the file extension
                    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

                    // Define an array of supported file extensions and their corresponding icon filenames
                    $extension_icons = array(
                        'dxf' => 'dxf_icon.jpg',
                        'jpeg' => 'jpg_icon.png',
                        'jpg' => 'jpg_icon.png',
                        'png' => 'png_icon.png',
                        'gif' => 'gif_icon.png',
                        'dwg' => 'dwg_icon.jpg',
                        'eps' => 'eps_icon.webp',
                        'pdf' => 'pdf_icon.jpg',
                        'svg' => 'svg_icon.png',
                        'cdr' => 'cdr_icon.jpg',
                        'skp' => 'skp_icon.jpg',
                        'txt' => 'txt_icon.jpg'
                        // Add more extensions and their corresponding icons as needed
                    );

                        // Check if the file extension is in the extension_icons array
                    if (array_key_exists($file_extension, $extension_icons)) {
                        // Construct the src attribute with the corresponding icon filename
                        $icon_src = "img/" . $extension_icons[$file_extension];
                        // Output the img tag with the constructed src attribute
                        echo "<img class='img-responsive' style='width:60px;cursor:pointer;' src='../$icon_src' alt='File icon'>";
                    } else {
                        // If the file extension is not supported, use a default icon
                        echo "<img class='img-responsive' style='width:60px;cursor:pointer;' src='img/default-icon.png' alt='Default file icon'>";
                    }
                    ?>

                    <?php 
                    if(strpos($_SERVER['REQUEST_URI'],"coordination") !== false)
                    {
                        echo $filesize = $prod->filesize_formatted("../result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']);
                    }
                    else
                    {
                        echo $filesize = $prod->filesize_formatted("result_files/" . $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']);
                    } ?>
                <?php 
                }
                ?>
                <form name="deletecreatorfile"
                        action="taskdetails.php?o_id=<?php echo $o_id; ?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id; ?>"
                        method="post">
                    <input type="hidden" name="orf_id"
                            value="<?php echo $result_files[$i]['orf_id']; ?>">

                    <a href="<?php echo $base_url;?>image.php?filecategory=creatorfiles&orfid=<?php echo $result_files[$i]['orf_id']; ?>"
                        alt="<?php echo $result_files[$i]['orf_name']; ?>"
                        class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-down mr-2"></i>Download</a>

                    <button type="button" id="res_delete_btn<?php echo $result_files[$i]['orf_id']; ?>" name="res_delete_btn" data-orf_id="<?php echo $result_files[$i]['orf_id']; ?>" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i></button>
                    <script type="text/javascript">
                    $('#res_delete_btn<?php echo $result_files[$i]['orf_id']; ?>').click(function(){
                        let orf_id=$(this).data("orf_id");

                        if(confirm('Are you sure want do delete ?'))
                        {

                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/delete_result_file.php",
                                method: "post",
                                data: {orf_id:orf_id},
                                dataType:"html",
                                success:function(data) {
                                    $('#result_file_row<?php echo $result_files[$i]['orf_id']; ?>').fadeOut(3000);
                                }
                            });

                        }
                    });
                    </script>
                </form>


                

            </div>
            <div class="col-md-2 border-right border-dark px-0 py-1">                                    
                <?php
                if(substr($result_files[$i]['prod_id'], -1) === 'z')
                {
                    $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                    $pict_categ_name_array=explode(".",$result_files[$i]['pict_categ_name']);                                                       
                    
                    ?>
                    <img id="selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>" src="<?php 
                    for($p=0;$p<count($configurator_pictures);$p++)
                    {
                        if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id'])
                        {
                            echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];
                        }
                    }
                    ?>" alt="Choose picture" class="configurator_pictures" style="width:50px;height:50px;">
                    
                    <input id="img_categ<?php echo $result_files[$i]['orf_id']; ?>"
                        data-id1="<?php echo $result_files[$i]['orf_id']; ?>"
                        class="form-control" type="hidden"
                        value="<?php 
                        echo $pict_categ_name_array[0];                                                
                        ?>" style="width:6em"><span class="pl-2 pt-2 pr-2"></span>
                        

                        <!-- Modal -->
                        <div class="modal fade" id="picture_select<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="picture_selectLabel<?php echo $result_files[$i]['orf_id']; ?>">Choose picture</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $configurator_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                                    
                                    for($p=0;$p<count($configurator_pictures);$p++)
                                    {
                                        ?>
                                        <div class="row p-3">
                                            <div class="col-md-6">
                                                <img id="configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>" class="configurator_pictures <?php if($pict_categ_name_array[0]==$configurator_pictures[$p]['orf_id']){echo "configurator_pictures_clicked";}?>" src="<?php echo $base_url."result_thumbnail_files/".$configurator_pictures[$p]['orf_thumbnail_path'];?>" data-orf_id="<?php echo $configurator_pictures[$p]['orf_id'];?>" alt="No picture">
                                                <script type="text/javascript">
                                                    

                                                    $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').hover(function(){
                                                        $(this).css('cursor','pointer');
                                                        
                                                    });

                                                    $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').click(function(){
                                                        
                                                        $('#img_categ<?php echo $result_files[$i]['orf_id'];?>').attr('value',$('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').data('orf_id'));
                                                        
                                                        $('.configurator_pictures').removeClass('configurator_pictures_clicked');
                                                        $(this).addClass('configurator_pictures_clicked');
                                                        
                                                        
                                                            let img_categ1=$('#img_categ<?php echo $result_files[$i]['orf_id'];?>').val()+".colors.";
                                                            let img_categ2=$('#img_categ_part2<?php echo $result_files[$i]['orf_id'];?>').val();
                                                            let img_categ=img_categ1+img_categ2;
                                                        
                                                        
                                                            $.ajax({
                                                                url: "<?php echo $base_url;?>ajax/img_categ_set.php",
                                                                method: "post",
                                                                data: {
                                                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                                    img_categ:img_categ
                                                                },
                                                                dataType: "html",
                                                                success: function (data) {

                                                                }
                                                            }).done(function(){

                                                                let srcValue = $('#configurator_picture_<?php echo $result_files[$i]['orf_id']; ?>_<?php echo $configurator_pictures[$p]['orf_id'];?>').attr('src');
                                                                $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').attr('src', srcValue);
                                                            });

                                                    });

                                                </script>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                                </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            <?php
                            if((substr($result_files[$i]['prod_id'], -1) === 'z')||(substr($result_files[$i]['prod_id'], -1) === 'y'))
                            {
                                ?>
                                $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id'];?>').on("click", function () {
                                    $('#picture_select<?php echo $result_files[$i]['orf_id']; ?>').modal('show');
                                });    

                                $('#selected_configurator_picture<?php echo $result_files[$i]['orf_id']?>').hover(function(){
                                        $(this).css('cursor','pointer');                                                    
                                });
                                <?php
                            }
                            ?>
                        </script>
                    <?php
                }

                if((substr($prod_id, -1) !== '8')&&(substr($prod_id, -1) !== '7'))
                {

                    if ($result_files[$i]['orf_type_dom'] == 'jpg' or $result_files[$i]['orf_type_dom'] == 'jpeg' or $result_files[$i]['orf_type_dom'] == 'png'): ?>
                        <?php if ($result_files[$i]['orf_compress_path']): ?>
                            <a target="_blank"
                                href="https://cseven.eu/studio/result_compress_files/<?= $result_files[$i]['orf_compress_path'] ?>"
                                class="btn btn-primary btn-sm mt-2">Compressed file</a>
                                <?php 
                                if(strpos($_SERVER['REQUEST_URI'],"coordination") !== false)
                                {
                                    echo $filesize = $prod->filesize_formatted("../result_compress_files/" . $result_files[$i]['orf_compress_path']);
                                }
                                else
                                {
                                    echo $filesize = $prod->filesize_formatted("result_compress_files/" . $result_files[$i]['orf_compress_path']);
                                } ?>
                        <?php else: ?>
                            <p class="text-danger text-sm">Please reupload file, compressed copy is
                                missing!</p>
                        <?php endif; ?>
                    <?php endif; 

                
                }
                else
                {
                    ?>
                    <div class="form-group">
                        <label for="orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>">www.youtube.com/embed/</label>
                        <input type="text" class="form-control form-control-sm" title="Add only the last 11 characters" placeholder="Add only the last 11 characters" id="orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>" name="orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" value="<?php
                        if(!empty($result_files[$i]['orf_youtube_link']))
                        {
                            //echo $result_files[$i]['orf_youtube_link'];
                            $youtube_link=explode("/embed/",$result_files[$i]['orf_youtube_link']);
                            echo $youtube_link[1];
                        }
                        ?>">
                        <script type="text/javascript">
                            $('#orf_youtube_link<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                let orf_id=$(this).data('orf_id');
                                let orf_youtube_link="";

                                if($(this).val()!="")
                                {
                                    orf_youtube_link="https://www.youtube.com/embed/"+$(this).val();
                                }

                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_youtube_link.php",
                                    method: "post",
                                    data: {
                                        orf_id:orf_id,
                                        orf_youtube_link: orf_youtube_link
                                    },
                                    dataType: "html",
                                    success: function (data) {

                                    }
                                });
                            });
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>">player.vimeo.com/video/</label>
                        <input type="text" class="form-control form-control-sm" title="Add only the last 11 characters" placeholder="Add only the last 11 characters" id="orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>" name="orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" value="<?php
                        if(!empty($result_files[$i]['orf_vimeo_link']))
                        {
                            //echo $result_files[$i]['orf_vimeo_link'];
                            $video_link=explode("/video/",$result_files[$i]['orf_vimeo_link']);
                            echo $video_link[1];
                        }
                        ?>">
                        <script type="text/javascript">
                            $('#orf_vimeo_link<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {

                                let orf_id=$(this).data('orf_id');
                                let orf_vimeo_link="";

                                if($(this).val()!="")
                                {
                                    orf_vimeo_link="https://player.vimeo.com/video/"+$(this).val();
                                }

                                $.ajax({
                                    url: "<?php echo $base_url;?>ajax/change_vimeo_link.php",
                                    method: "post",
                                    data: {
                                        orf_id:orf_id,
                                        orf_vimeo_link: orf_vimeo_link
                                    },
                                    dataType: "html",
                                    success: function (data) {

                                    }
                                });
                            });
                        </script>
                    </div>
                    <?php
                }
                ?>

            </div>
            <!--<div class="col-md-2 border-right border-dark px-0 py-1">

            </div> -->

            <div class="col-md-5 border-dark px-3 py-1">
                <?php

                // if(strpos($result_files[$i]['prod_id'], "p11") !== false)
                // {
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <b>Building status</b>
                    </div>
                    <div class="col-md-6">
                    <select id="bd_status_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                        name="bd_status_files_visibility"
                        class="form-control form-control-sm <?php echo ($result_files[$i]['bd_status'] == 8) ? "blue" : ""; ?>">
                    <option value="0" <?php echo ($result_files[$i]['bd_status'] == 0) ? "selected" : ""; ?>>
                        Not visible
                    </option>
                    <?php
                    if (($result_files[$i]['prod_id'] != "p156y") && ($result_files[$i]['prod_id'] != "p156z") &&
                        ($result_files[$i]['prod_id'] != "p166y") && ($result_files[$i]['prod_id'] != "p166z") &&
                        ($result_files[$i]['prod_id'] != "p176y") && ($result_files[$i]['prod_id'] != "p176z") &&
                        ($result_files[$i]['prod_id'] != "p186y") && ($result_files[$i]['prod_id'] != "p186z")) {
                        ?>
                        <option value="7" <?php echo ($result_files[$i]['bd_status'] == 7) ? "selected" : ""; ?>>
                            Visible for production
                        </option>
                        <option value="8" <?php echo ($result_files[$i]['bd_status'] == 8) ? "selected" : ""; ?>>
                            Visible to the customer
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <script type="text/javascript">
                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                        $.ajax({
                            url: "<?php echo $base_url;?>ajax/change_bd_status_file_visibility.php",
                            method: "get",
                            data: {
                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                bd_status: $(this).val()
                            },
                            dataType: "html",
                            success: function (data) {
                                if(($('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8)
                                {
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue-light");
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("blue");
                                }
                                else if(($('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 7)
                                {
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue");
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("blue-light");
                                }
                                else
                                {
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue");
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("blue-light");
                                    $('#bd_status_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                }
                            }
                        });
                    });
                </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <b>Sales status</b>
                    </div>
                    <div class="col-md-5">
                        <select id="result_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                                name="result_files_visibility"
                                class="form-control form-control-sm <?php
                                echo ($result_files[$i]['orf_status'] == 1) ? "grey" : "";
                                echo ($result_files[$i]['orf_status'] == 8) ? "light-green" : "";
                                echo ($result_files[$i]['orf_status'] == 6) ? "yellow" : "";
                                ?>">
                            <option value="0" <?php echo ($result_files[$i]['orf_status'] == 0) ? "selected" : ""; ?>>
                                Not visible
                            </option>
                            <?php
                            if (($result_files[$i]['prod_id'] != "p156y") && ($result_files[$i]['prod_id'] != "p156z") &&
                                ($result_files[$i]['prod_id'] != "p166y") && ($result_files[$i]['prod_id'] != "p166z") &&
                                ($result_files[$i]['prod_id'] != "p176y") && ($result_files[$i]['prod_id'] != "p176z") &&
                                ($result_files[$i]['prod_id'] != "p186y") && ($result_files[$i]['prod_id'] != "p186z")) {
                                ?>
                                <option value="1" <?php echo ($result_files[$i]['orf_status'] == 1) ? "selected" : ""; ?>>
                                    Old
                                </option>
                                <option value="7" <?php echo ($result_files[$i]['orf_status'] == 7) ? "selected" : ""; ?>>
                                    Visible for production
                                </option>
                                <option value="8" <?php echo ($result_files[$i]['orf_status'] == 8) ? "selected" : ""; ?>>
                                    Visible to the customer
                                </option>
                                <?php
                            }

                            if(
                                (substr($result_files[$i]['prod_id'], -1) == 'y')||(substr($result_files[$i]['prod_id'], -1) == 'z')
                                )
                                {
                                ?>
                                <option value="7" <?php echo ($result_files[$i]['orf_status'] == 7) ? "selected" : ""; ?>>
                                    Visible for production
                                </option>
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
                                        }
                                        else if (($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 6) {
                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("yellow");
                                        }
                                        else {
                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                            $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                        }
                                    }
                                });
                            });
                        </script>

                    </div>
                    <div class="col-md-1">
                        <input type="checkbox" id="result_file_verified<?php echo $result_files[$i]['orf_id'];?>" data-orf_id="<?php echo $result_files[$i]['orf_id'];?>" name="result_file_verified" class="form-check-input" style="width:100%;height:20px;" title="Verified by creator" value="1" <?php
                        echo ($result_files[$i]['result_file_verified']==1)?"checked":"";
                        ?>>
                        <script type="text/javascript">

                            $('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').click(function(){

                                let orf_id=$(this).data('orf_id');
                                let result_file_verified=0;

                                if($('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').is(":checked"))
                                {
                                    result_file_verified=1;
                                }

                                $.ajax({
                                url: "<?php echo $base_url;?>ajax/change_result_file_verified.php",
                                method: "post",
                                data: {
                                    orf_id:orf_id,
                                    result_file_verified: result_file_verified
                                },
                                dataType: "html",
                                success: function (data) {
                                    if($('#result_file_verified<?php echo $result_files[$i]['orf_id'];?>').is(":checked"))
                                    {
                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val(8);

                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("light-green");

                                        $.ajax({
                                            url: "<?php echo $base_url;?>ajax/change_results_file_visibility.php",
                                            method: "get",
                                            data: {
                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                orf_status: 8
                                            },
                                            dataType: "html",
                                            success: function (data) {

                                            }
                                        });


                                    }
                                    else
                                    {
                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val(0);

                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("orange");
                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green");
                                        $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");

                                        $.ajax({
                                            url: "<?php echo $base_url;?>ajax/change_results_file_visibility.php",
                                            method: "get",
                                            data: {
                                                orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                                orf_status: 0
                                            },
                                            dataType: "html",
                                            success: function (data) {

                                            }
                                        });
                                    }
                                }
                            });
                            });
                        </script>
                    </div>
                </div>
                <?php
                if (($result_files[$i]['prod_id'] == "p1322") || ($result_files[$i]['prod_id'] == "1302"))
                {
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <b>Show in tour</b>
                    </div>
                    <div class="col-md-6">
                    <select id="hover_files_visibility<?php echo $result_files[$i]['orf_id']; ?>"
                            name="hover_files_visibility"
                            class="form-control form-control-sm <?php echo ($result_files[$i]['hover_status'] == 8) ? "red" : ""; ?>">
                            <option value="0" <?php echo ($result_files[$i]['hover_status'] == 0) ? "selected" : ""; ?>>
                                Not visible
                            </option>
                            <option value="8" <?php echo ($result_files[$i]['hover_status'] == 8) ? "selected" : ""; ?>>
                                Visible
                            </option>
                    </select>
                    <script type="text/javascript">
                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/change_hover_file_visibility.php",
                                method: "get",
                                data: {
                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                    hover_status: $(this).val()
                                },
                                dataType: "html",
                                success: function (data) {
                                    if (($('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val()) == 8)
                                    {
                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("red");
                                    }
                                    else
                                    {
                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').removeClass("red");
                                        $('#hover_files_visibility<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                    }
                                }
                            });
                        });
                    </script>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <b>Show in panorama</b>
                    </div>
                    <div class="col-md-6">
                    <select id="show_in_panorama<?php echo $result_files[$i]['orf_id']; ?>"
                            name="show_in_panorama"
                            class="form-control form-control-sm <?php echo ($result_files[$i]['show_in_panorama_status'] == 8) ? "red" : ""; ?>">
                            <option value="0" <?php echo ($result_files[$i]['show_in_panorama_status'] == 0) ? "selected" : ""; ?>>
                                Not visible
                            </option>
                            <option value="8" <?php echo ($result_files[$i]['show_in_panorama_status'] == 8) ? "selected" : ""; ?>>
                                Visible
                            </option>
                    </select>
                    <script type="text/javascript">
                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').on("change", function () {
                            $.ajax({
                                url: "<?php echo $base_url;?>ajax/show_in_panorama_visibility.php",
                                method: "get",
                                data: {
                                    orf_id:<?php echo $result_files[$i]['orf_id'];?>,
                                    show_in_panorama_status: $(this).val()
                                },
                                dataType: "html",
                                success: function (data) {
                                    if (($('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').val()) == 8)
                                    {
                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark");
                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').addClass("red");
                                    }
                                    else
                                    {
                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').removeClass("red");
                                        $('#show_in_panorama<?php echo $result_files[$i]['orf_id'];?>').addClass("grey-dark");
                                    }
                                }
                            });
                        });
                    </script>

                    </div>
                </div>
                <?php
                }
                ?>
                </div> <!-- end row -->
            <?php
            if (in_array($result_files[$i]['orf_type_dom'], $validextensions)) 
            {
                ?>
                <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                            class="img-responsive" style="width:900px;"
                            src="<?php echo $base_url;?>result_files/<?php echo $result_files[$i]['orf_path_dom'] . $result_files[$i]['orf_internal_name_dom']; ?>"
                            alt="<?php echo $result_files[$i]['orf_name']; ?>"></div>
                <?php
            }
            ?>
        </div>
        <?php
        $image_preview_counter++;
        }
    } //end for
}

    ?>
</div>
<?php

if(
    (($prod_id!="p168s")||(substr($prod_id, -2)!="gs"))
)                    
{
    if(substr($prod_id, -1) !== 'y')
    {
    ?>
    <div class="col-md-12">

        <div class="row w-100 mx-0 d-flex justify-content-center mt-3">
            <div class="col-md-8">

                <div id="fileuploader_<?php echo $o_id . "_" . $osub_id . "_" . $prod_id; ?>"></div>
            </div>
            <div class="col-md-4" style="display: flex; align-items: center;">

                <div id="fileuploader_message"></div>
                <button id="start_upload_btn" type="button" class="btn btn-sm btn-success">Start upload</button>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {

                    let file_upload_obj=$("#fileuploader_<?php echo $o_id . "_" . $osub_id . "_" . $prod_id;?>").uploadFile({
                        url: "<?php echo $base_url;?>upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id']; ?>",
                        fileName: "myfile",
                        showAbort: true,
                        showStatusAfterSuccess: true,
                        showStatusAfterError: true,
                        statusBarWidth: 350,
                        dragdropWidth: 350,
                        autoSubmit:false,
                        uploadStr: "Upload result files",
                        extraHTML:function()
                        {
                                console.log($('.ajax-file-upload-filename').text());

                                var html = "<div><b>Test test<br>";
                                html += "<b>test test";
                                html += "</div>";
                                return html;
                        },
                        afterUploadAll: function (data) {
                            setTimeout(function () {
                                //window.location = "taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>";
                                // setTimeout(function () {
                                // window.scrollTo(0, document.body.scrollHeight);
                                // },1000);
                                var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                window.location.href = redirectToURL;
                                window.location.reload(true);

                            }, 1000);
                        }
                    });



                    $("#start_upload_btn").click(function()
                    {
                        console.log($("input[name=myfile]"));
                        file_upload_obj.startUpload();
                        // setTimeout(function () {
                        //         window.location = "taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>"
                        // }, 3000);
                    });

                });


            </script>
        </div>
        
    </div>
    <?php
    }
}


} //end 6m 6t

if(substr($prod_id, -1) === 'y')
{
?>
<div class="col-md-12 border my-3 py-2">
    <form name="new_upload_file" id="new_upload_file" method="post" enctype="multipart/form-data"></form>
    <div id="new_uploaded_files">
        <?php
        for($f=0;$f<3;$f++)
        {
        ?>
        <div class="row">
            <div class="col-md-3">
                <input type="file" name="myfile[]" class="form-control form-control-sm" form="new_upload_file">
            </div>
            <div class="col-md-1">
                <button class="btn btn-sm btn-warning" id="classify_btn<?php echo $f;?>" data-toggle="modal"
                data-target="#classifyModal<?php echo $f;?>">Classify</button>

                <!-- Modal -->
                <div class="modal fade" id="classifyModal<?php echo $f;?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="classifyModalLabel<?php echo $f; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="classifyModalLabel<?php echo $f; ?>">Choose clasification</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">                                                    
                            <?php
                            $all_classifications=$prod->get_all_picture_areas();
                            $classification_counter=0;
                            for($s=0;$s<count($all_classifications);$s++)
                            {
                                ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pa_id[]" id="pa_id_<?php echo $f;?>_<?php echo $classification_counter;?>" value="<?php 
                                            echo $all_classifications[$s]['pa_id'];?>" data-pa_description="<?php echo $all_classifications[$s]['pa_description'];?>">
                                            <label class="form-check-label" for="pa_id_<?php echo $f;?>_<?php echo $classification_counter;?>">
                                                <?php echo $all_classifications[$s]['pa_id'];?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo $all_classifications[$s]['pa_description'];?>
                                    </div>                                                    
                                </div>
                                <script type="text/javascript">
                                    $('#pa_id_<?php echo $f;?>_<?php echo $classification_counter;?>').click(function(){
                                        let pa_id=$(this).val();
                                        let pa_description=$(this).data('pa_description');
                                        let f=<?php echo $f;?>;

                                        $('#chosen_clasification_text<?php echo $f;?>').text(pa_description);
                                        $('#chosen_classification_id<?php echo $f;?>').val(pa_id);

                                        if(pa_id=="pa0-10")
                                        {
                                            $('#what_btn<?php echo $f;?>').addClass('d-none');
                                            $('#main_img_btn<?php echo $f;?>').addClass('d-none');
                                            $('#new_upload_btn').removeClass('btn-default');
                                            $('#new_upload_btn').addClass('btn-success');
                                            $("#new_upload_btn").prop("disabled", false);
                                        }
                                        else
                                        {
                                            $('#what_btn<?php echo $f;?>').removeClass('d-none');
                                            $('#main_img_btn<?php echo $f;?>').removeClass('d-none');

                                            let mc_id=<?php echo $order['mc_id']?>;

                                            $.ajax({
                                                url: "<?php echo $base_url;?>ajax/get_u_clients_main_options_html.php",
                                                method: "get",
                                                data: {mc_id:mc_id,pa_id:pa_id,f:f},
                                                dataType:"html",
                                                success:function(data) {

                                                    $('#what_option_is_it<?php echo $f;?>').html(data);
                                                }
                                            });
                                        }
                                    });
                                </script>
                                <?php
                                $classification_counter++;
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                        </div>
                        </div>
                    </div>
                </div> <!-- end Modal -->
            </div>
            <div class="col-md-auto">
                <div id="chosen_clasification_text<?php echo $f;?>">
                </div>
                <input type="hidden" name="chosen_classification_id[]" id="chosen_classification_id<?php echo $f;?>" value="" form="new_upload_file">
            </div>
            <div class="col-md-auto">
                <button class="btn btn-sm btn-warning d-none" id="what_btn<?php echo $f;?>" data-toggle="modal"
                data-target="#whatModal<?php echo $f;?>">What shall be shown ?</button>
                    
                <!-- Modal -->
                    <div class="modal fade" id="whatModal<?php echo $f;?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="whatModalLabel<?php echo $f; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="whatModalLabel<?php echo $f; ?>">Choose what shall be shown ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">                                                    
                            <div id="what_option_is_it<?php echo $f;?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                        </div>
                        </div>
                    </div>
                </div> <!-- end Modal -->

            </div>
            <div class="col-md-2">
                <img id="chosen_shape_img<?php echo $f;?>" class="img-fluid" src="" alt="" style="width:60px;height:auto;">
                <input type="hidden" name="chosen_shape_id[]" id="chosen_shape_id<?php echo $f;?>" value="" form="new_upload_file">
            </div>
            <div class="col-md-1">
                <button class="btn btn-sm btn-warning d-none" id="main_img_btn<?php echo $f;?>" data-toggle="modal"
                data-target="#main_imgModal<?php echo $f;?>">Main image</button>

                <!-- Modal -->
                <div class="modal fade" id="main_imgModal<?php echo $f; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="main_imgModalLabel<?php echo $f; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="main_imgModalLabel<?php echo $f; ?>">Choose main picture</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $main_pictures=$prod->get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id);
                            
                            for($p=0;$p<count($main_pictures);$p++)
                            {
                                ?>
                                <div class="row p-3">
                                    <div class="col-md-6">
                                        <img id="main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>" class="configurator_pictures <?php //if($pict_categ_name_array[0]==$main_pictures[$p]['orf_id']){echo "configurator_pictures_clicked";}?>" src="<?php echo $base_url."result_thumbnail_files/".$main_pictures[$p]['orf_thumbnail_path'];?>" data-orf_id="<?php echo $main_pictures[$p]['orf_id'];?>" alt="No picture">
                                        <script type="text/javascript">
                                            

                                            $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').hover(function(){
                                                $(this).css('cursor','pointer');
                                                
                                            });

                                            $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').click(function(){
                                                                                                                

                                                let srcValue = $('#main_picture_<?php echo $f; ?>_<?php echo $main_pictures[$p]['orf_id'];?>').attr('src');
                                                $('#chosen_main_img<?php echo $f;?>').attr('src', srcValue);
                                                $('#chosen_main_img_id<?php echo $f;?>').val($(this).data('orf_id'));   
                                                $('#new_upload_btn').removeClass('btn-default');
                                                $('#new_upload_btn').addClass('btn-success');
                                                $("#new_upload_btn").prop("disabled", false);
                                            });

                                        </script>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                        
                        </div>
                        </div>
                    </div>
                </div><!-- end modal -->
            </div>
            <div class="col-md-2">
                <img id="chosen_main_img<?php echo $f;?>" class="img-fluid" src="" style="width:60px;height:auto;">
                <input type="hidden" name="chosen_main_img_id[]" id="chosen_main_img_id<?php echo $f;?>" value="" form="new_upload_file">
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 text-left">
            <button class="btn btn-sm btn-primary">Add more files</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 text-center">
            <div id="loading_spinner" class="d-none">
                <img src="<?php echo $base_url;?>img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-sm btn-default" id="new_upload_btn" form="new_upload_file" type="button" disabled>Start Upload</button>
            <script type="text/javascript">
                $('#new_upload_btn').click(function(){
                    $('#loading_spinner').removeClass('d-none');
                    formData= new FormData($('#new_upload_file')[0]);

                    $.ajax({
                        url: "<?php echo $base_url;?>upload_files_beta.php?filecategory=creatorfiles&o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id;?>&prod_id=<?php echo $prod_id;?>&uca_id=<?php echo $_COOKIE['client_id'];?>",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        dataType: 'text',
                        processData: false, 
                        contentType: false,
                        enctype: 'multipart/form-data',
                        dataType:"html",
                        success:function(data) {
                            console.log(data);	
                            $('#loading_spinner').addClass('d-none');
                            setTimeout(function () {
                                
                                var redirectToURL = 'taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>#all_uploaded_result_files';
                                window.location.href = redirectToURL;
                                window.location.reload(true);

                            }, 1000);
                        }
                    });

                })
            </script>
        </div>
    </div>
</div>
<?php
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="form-check" style="display: flex; flex-direction: column">
            <div style="width: fit-content;
                            display: flex;
                            justify-content: center;
                            align-items: center;">
            <input type="checkbox" id="no_result_file" class="form-control-sm form-control" value="1" style="width: 2vw;" <?php
            $found_no_result_file=0;

            for($i=0;$i<count($result_files);$i++)
            {
                if(($found_no_result_file==0)&&($result_files[$i]['no_result_file']==1))
                {
                    echo "checked";
                    $found_no_result_file++;
                }
            }
            ?>>
            <label class="form-check-label" for="no_result_file" style="width: fit-content;">No result file shall be uploaded</label>
            <script type="text/javascript">
                $('#no_result_file').click(function(){

                    let o_id=<?php echo $o_id;?>;
                    let osub_id="<?php echo $osub_id; ?>";
                    let prod_id="<?php echo $prod_id;?>";
                    let uca_id=<?php echo $_COOKIE['client_id'];?>;

                    if($(this).is(':checked'))
                    {
                        $.ajax({
                                url: "<?php echo $base_url;?>ajax/create_no_result_file.php",
                                method: "post",
                                data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id,uca_id:uca_id},
                                dataType:"html",
                                success:function(data) {

                                }
                            });


                    }
                    else
                    {
                        $.ajax({
                                url: "<?php echo $base_url;?>ajax/delete_no_result_file.php",
                                method: "post",
                                data: {o_id:o_id,osub_id:osub_id,prod_id:prod_id},
                                dataType:"html",
                                success:function(data) {

                                }
                            });
                    }

                });
            </script>
                </div>
        </div>
    </div>
</div>