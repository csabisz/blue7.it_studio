<?php
include('../functions.php');

$prod=new Production;

$mc_id=$prod->xss_fix($_GET['mc_id']);
$pa_id=$prod->xss_fix($_GET['pa_id']);
$f=$prod->xss_fix($_GET['f']);

$main_client_options=$prod->get_main_client_options($mc_id);

if($pa_id=="pa0000")
{
    $floor_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">            
            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Interior" data-base_render_id="interior" style="width:150px;height:200px;background-color:#f0f0f0;">
                Interior
            </div>                
        </div>
        <div class="col-md-6">
            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Exterior" data-base_render_id="exterior" style="width:150px;height:200px;background-color:#f0f0f0;">
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

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('base_render_id'));

            $('#new_upload_btn').removeClass('btn-default');
            $('#new_upload_btn').addClass('btn-success');
            $("#new_upload_btn").prop("disabled", false);
        });

    </script>
    <?php
}

if($pa_id=="pa0001")
{
    $floor_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">            
            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Interior" data-base_render_id="interior" style="width:150px;height:200px;background-color:#f0f0f0;">
                Interior
            </div>                
        </div>
        <div class="col-md-6">
            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Exterior" data-base_render_id="exterior" style="width:150px;height:200px;background-color:#f0f0f0;">
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

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('base_render_id'));

            $('#new_upload_btn').removeClass('btn-default');
            $('#new_upload_btn').addClass('btn-success');
            $("#new_upload_btn").prop("disabled", false);
        });

    </script>
    <?php
}

if($pa_id=="pa0121") //wall 2
{
    $wall_area_2_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">
            <?php
            if($wall_area_2_counter==0)
            {
                ?>
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-wall_area_2_id="wall_area_2_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                <?php
                $wall_area_2_counter++;
            }
            ?>
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('wall_area_2_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0131") //wall 3
{
    $wall_area_3_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">
            <?php
            if($wall_area_3_counter==0)
            {
                ?>
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-wall_area_3_id="wall_area_3_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                <?php
                $wall_area_3_counter++;
            }
            ?>
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('wall_area_3_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0200")
{
    $main_client_gutters_array=explode(",",$main_client_options['gutters']);

    $all_db_gutters=$prod->get_all_gutters();
    $gutter_counter=0;
    for($g=0;$g<count($all_db_gutters);$g++)
    {
        for($m=0;$m<count($main_client_gutters_array);$m++)
        {
            if($all_db_gutters[$g]['gut_id']==$main_client_gutters_array[$m])
            {
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <img src="https://domenia.cseven.eu/<?php echo $all_db_gutters[$g]['gut_pic'];?>" class="img-fluid shape_pictures" data-gut_id="<?php echo $all_db_gutters[$g]['gut_id'];?>" alt="">
                    </div>
                    <div class="col-md-6">
                        <?php
                        if($gutter_counter==0)
                        {
                            ?>
                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-gut_id="gut_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                                Original
                            </div>
                            <script type="text/javascript">
                                $('.original_shape').hover(function(){
                                    $(this).css('cursor','pointer');                        
                                });
                            </script>
                            <?php
                            $gutter_counter++;
                        }
                        ?>
                    </div>
                </div>
                <br>
                <script type="text/javascript">
                    $('.shape_pictures').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });

                    $('.shape_pictures').click(function(){
                        let srcValue = $(this).attr('src');
                        let altValue = $(this).attr('alt');

                        $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
                        $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
                        $('#chosen_shape_id<?php echo $f;?>').val($(this).data('gut_id'));
                    });

                </script>
                <?php
            }
        }
    }
    ?>
    
    <?php
}

if($pa_id=="pa0201")
{
    $main_client_gutters_array=explode(",",$main_client_options['gutters']);

    $all_db_gutters=$prod->get_all_gutters();
    $gutter_counter=0;
    for($g=0;$g<count($all_db_gutters);$g++)
    {
        for($m=0;$m<count($main_client_gutters_array);$m++)
        {
            if($all_db_gutters[$g]['gut_id']==$main_client_gutters_array[$m])
            {
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <img src="https://domenia.cseven.eu/<?php echo $all_db_gutters[$g]['gut_pic'];?>" class="img-fluid shape_pictures" data-gut_id="<?php echo $all_db_gutters[$g]['gut_id'];?>" alt="">
                    </div>
                    <div class="col-md-6">
                        <?php
                        if($gutter_counter==0)
                        {
                            ?>
                            <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-gut_id="gut_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                                Original
                            </div>
                            <script type="text/javascript">
                                $('.original_shape').hover(function(){
                                    $(this).css('cursor','pointer');                        
                                });
                            </script>
                            <?php
                            $gutter_counter++;
                        }
                        ?>
                    </div>
                </div>
                <br>
                <script type="text/javascript">
                    $('.shape_pictures').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });

                    $('.shape_pictures').click(function(){
                        let srcValue = $(this).attr('src');
                        let altValue = $(this).attr('alt');

                        $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
                        $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
                        $('#chosen_shape_id<?php echo $f;?>').val($(this).data('gut_id'));
                    });

                </script>
                <?php
            }
        }
    }
    ?>
    
    <?php
}

if($pa_id=="pa0180")
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
                    <img id="" class="img-fluid shape_pictures" src="<?php 
                    echo "https://domenia.cseven.eu/".$door_shape_pictures[$p]['dsp_pic'];?>" data-dsp_id="<?php 
                    echo $door_shape_pictures[$p]['dsp_id'];?>" alt="No picture" style="width:auto;height:150px;">                    
                </div>
            </div>
            <script type="text/javascript">
                        
                $('.shape_pictures').hover(function(){
                    $(this).css('cursor','pointer');                        
                });

                $('.shape_pictures').click(function(){
                    let srcValue = $(this).attr('src');
                    $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
                    $('#chosen_shape_id<?php echo $f;?>').val($(this).data('dsp_id'));
                });                       

            </script>
            <?php
        $door_shape_counter++;
        }    
    }
}

if($pa_id=="pa0181")
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
                    <img id="" class="img-fluid shape_pictures" src="<?php 
                    echo "https://domenia.cseven.eu/".$door_shape_pictures[$p]['dsp_pic'];?>" data-dsp_id="<?php 
                    echo $door_shape_pictures[$p]['dsp_id'];?>" alt="No picture" style="width:auto;height:150px;">                    
                </div>
            </div>
            <script type="text/javascript">
                        
                $('.shape_pictures').hover(function(){
                    $(this).css('cursor','pointer');                        
                });

                $('.shape_pictures').click(function(){
                    let srcValue = $(this).attr('src');
                    $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
                    $('#chosen_shape_id<?php echo $f;?>').val($(this).data('dsp_id'));
                });                       

            </script>
            <?php
        $door_shape_counter++;
        }    
    }
}

if($pa_id=="pa0140")
{
    $floor_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">
            <?php
            if($floor_counter==0)
            {
                ?>
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-floor_id="floor_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                <?php
                $floor_counter++;
            }
            ?>
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('floor_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0141")
{
    $floor_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">
            <?php
            if($floor_counter==0)
            {
                ?>
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-floor_id="floor_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                <?php
                $floor_counter++;
            }
            ?>
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('floor_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0150")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-skirting_id="skirting_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('skirting_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0151")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-skirting_id="skirting_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('skirting_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0160")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-electric_switches_id="electric_switches_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('electric_switches_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0161")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-electric_switches_id="electric_switches_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('electric_switches_id'));
        });

    </script>
    <?php
}


if($pa_id=="pa0170")
{
    $roof_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">
            <?php
            if($roof_counter==0)
            {
                ?>
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-rs_id="rs_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                <?php
                $roof_counter++;
            }
            ?>
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('rs_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0171")
{
    $roof_counter=0;
    ?>
    <div class="row">    
        <div class="col-md-6">
            <?php
            if($roof_counter==0)
            {
                ?>
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-rs_id="rs_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                <?php
                $roof_counter++;
            }
            ?>
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('rs_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0190")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-window_frames_id="window_frames_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('window_frames_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0191")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-window_frames_id="window_frames_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('window_frames_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0210")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-window_sills_id="window_sills_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('window_sills_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa0211")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-window_sills_id="window_sills_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('window_sills_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1010")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_1_id="extra_layer_1_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_1_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1011")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_1_id="extra_layer_1_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_1_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1020")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_2_id="extra_layer_2_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_2_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1021")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_2_id="extra_layer_2_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_2_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1030")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_3_id="extra_layer_3_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_3_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1031")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_3_id="extra_layer_3_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_3_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1040")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_4_id="extra_layer_4_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_4_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1041")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_4_id="extra_layer_4_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_4_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1050")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_5_id="extra_layer_5_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_5_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1051")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_5_id="extra_layer_5_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_5_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1060")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_6_id="extra_layer_6_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_6_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1061")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_6_id="extra_layer_6_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_6_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1070")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_7_id="extra_layer_7_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_7_id'));
        });

    </script>
    <?php
}

if($pa_id=="pa1071")
{
    
    ?>
    <div class="row">    
        <div class="col-md-6">
            
                <div class="shape_pictures original_shape border border-rounded" src="#" alt="Original" data-extra_layer_7_id="extra_layer_7_org" style="width:150px;height:200px;background-color:#f0f0f0;">
                    Original
                </div>
                <script type="text/javascript">
                    $('.original_shape').hover(function(){
                        $(this).css('cursor','pointer');                        
                    });
                </script>
                
        </div>
    </div>
    <br>
    <script type="text/javascript">
        $('.shape_pictures').hover(function(){
            $(this).css('cursor','pointer');                        
        });

        $('.shape_pictures').click(function(){
            let srcValue = $(this).attr('src');
            let altValue = $(this).attr('alt');

            $('#chosen_shape_img<?php echo $f;?>').attr('src', srcValue);
            $('#chosen_shape_img<?php echo $f;?>').attr('alt', altValue);
            $('#chosen_shape_id<?php echo $f;?>').val($(this).data('extra_layer_7_id'));
        });

    </script>
    <?php
}

?>


