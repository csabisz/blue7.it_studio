<?php
session_start();
include('../functions.php');
$prod=new Production;

//include('../header2.php'); //not needed at the end

$data['o_id']=$prod->xss_fix($_GET['o_id']);
$data['osub_id']=$prod->xss_fix($_GET['osub_id']);
$data['prod_id']=$prod->xss_fix($_GET['prod_id']);

$o_prod=$prod->get_order_product(json_encode($data));
$allstatus=$prod->showallstatus();
$customer_files=$prod->get_customer_files($data['o_id']);
$product=$prod->get_product($data['prod_id']);
$order=$prod->get_order($data['o_id']);
?>

<div class="row w-100 mx-0 py-2 <?php
    for($i=0;$i<count($allstatus);$i++)
    {
        if($allstatus[$i]['ost_id']==$o_prod['p_status'])
        {
            echo $allstatus[$i]['ost_color'];
        }
    }?>" id="task<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>">
    <div id="fileuploader_<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>">
    </div>
    <div class="col-4 my-1 text-center">
        <div class="file-name p-2 bg-light text-dark">
            <p class="text-danger mb-0"><strong><?php 
            if($o_prod['om_id']==0)
            {
                echo $o_prod['o_id'].".".$o_prod['osub_id'].".".$o_prod['prod_id'];
            }
            else
            {
                echo $o_prod['om_id'].".".$o_prod['osub_id'].".".$o_prod['prod_id'].".".$o_prod['o_id'];
            }?></strong></p>
        
            <p class="housemodel mb-0"><?php echo $product['prod_name'];?></p>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#fileuploader_<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>").uploadFile({
            url:"../upload_file.php?filecategory=creatorfiles&o_id=<?php echo $o_prod['o_id'];?>&osub_id=<?php echo $o_prod['osub_id']; ?>&prod_id=<?php echo $o_prod['prod_id'];?>&uca_id=<?php echo $_COOKIE['client_id']; ?>",
            fileName:"myfile",					
            showAbort: true,
            showStatusAfterSuccess: true,
            showStatusAfterError: true,
            statusBarWidth: 500,
            dragdropWidth: 500,
            //uploadStr:"",
            afterUploadAll: function()
            {
                //setTimeout(function(){window.location = "taskdetails.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $osub_id; ?>&prod_id=<?php echo $prod_id;?>"},1000);
            }
        });

        $('body').find('div.ajax-file-upload').each(function(){
                $(this).css('display', 'none').parent().addClass('text-center text-dark border-dark py-2 my-1').parent().parent().addClass('d-flex justify-content-center');
            });

    });
    </script>
    <div class="col-8 my-1">
        <div class="row mx-0">
            <div class="col-12 col-xl-6 my-1 d-flex justify-content-center">
            <?php
                for($c=0;$c<count($customer_files);$c++)
                {
                    $osub_id=substr($o_prod['osub_id'],1);
                    if($customer_files[$c]['of_exterior_position']==$osub_id)
                    {
                        echo $customer_files[$c]['of_name_ex'];
                    }
                }
            ?>
            </div>
            <div class="col-12 col-xl-6 my-1 px-0 d-flex">
                <div class="row mx-0 w-100 align-self-center mb-0 justify-content-center d-flex ">
                    <div class="form-group align-self-center mb-0 w-100 d-flex">
                        <select name="creators_<?php echo $global_creator_counter;?>" data-prod_id="<?php echo $o_prod['prod_id'];?>" id="creators_<?php echo $global_creator_counter;?>" data-selected_creator="<?php echo $o_prod['uca_id'];?>" class="creator col-7 form-control form-control-sm align-self-center">
                        <option value="">-- Choose creator --</option>
                        <?php
                        $all_creators=$prod->show_creators($order['u_prod_id']);
                        $all_other_creators=$prod->show_creators_other_companies($order['u_prod_id']);
                        
                        for($i=0;$i<count($all_creators);$i++)
                        {
                            $creator_qualification=$prod->get_client_qualifications($all_creators[$i]['client_ID']);
                            $creator_right=$prod->get_client_rights($all_creators[$i]['client_ID']);
                            
                            if($creator_right['u_status']=="active")
                            {
                                if($o_prod['prod_id']=="p1561")
                                {
                                    if(($creator_qualification['b5_walls']>0)||($creator_qualification['b5_windows_doors']>0))
                                    {
                            ?>
                                <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_creators[$i]['c_last_name']))
                                    {
                                    echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_walls'].")(".$creator_qualification['b5_windows_doors'].")";
                                    }
                                    else
                                    {
                                    echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_walls'].")(".$creator_qualification['b5_windows_doors'].")";
                                    }?> </option>
                            <?php
                                    }
                                }	
                                
                                
                                if(((substr($o_prod['prod_id'],1)>1561)&&(substr($o_prod['prod_id'],1)<1566))||((substr($o_prod['prod_id'],1)>1581)&&(substr($o_prod['prod_id'],1)<1590)))
                                {
                                    if($creator_qualification['b5_render_stills']>0)
                                    {
                            ?>
                                <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_creators[$i]['c_last_name']))
                                    {
                                    echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_render_stills'].")";
                                    }
                                    else
                                    {
                                    echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_render_stills'].")";
                                    }?> </option>
                            <?php
                                    }
                                }

                                if($o_prod['prod_id']=="p1566")
                                {
                                    if($creator_qualification['b5_render_360']>0)
                                    {
                            ?>
                                <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_creators[$i]['c_last_name']))
                                    {
                                    echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_render_360'].")";
                                    }
                                    else
                                    {
                                    echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_render_360'].")";
                                    }?> </option>
                            <?php
                                    }
                                }

                    
                                if($o_prod['prod_id']=="p1567")
                                {
                                    if($creator_qualification['b5_render_movie']>0)
                                    {
                            ?>
                                <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                if(!empty($all_creators[$i]['c_last_name']))
                                {
                                    echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_render_movie'].")";
                                }
                                else
                                {
                                    echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_render_movie'].")";
                                }?> <?php 
                                
                                ?></option>
                            <?php
                                    }
                                }


                                if($o_prod['prod_id']=="p1568")
                                {
                                    if($creator_qualification['b5_vr']>0)
                                    {
                            ?>
                                <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                if(!empty($all_creators[$i]['c_last_name']))
                                {
                                    echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_vr'].")";
                                }
                                else
                                {
                                    echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_vr'].")";
                                }?> <?php 
                                
                                ?></option>
                            <?php
                                    }
                                }

                                if($o_prod['prod_id']=="p1581")
                                {
                                    if($creator_qualification['b5_environment']>0)
                                    {
                            ?>
                                <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_creators[$i]['c_last_name']))
                                    {
                                    echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_environment'].")";
                                    }
                                    else
                                    {
                                    echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_environment'].")";
                                    }?> </option>
                            <?php
                                    }
                                }



                            }
                        }
                        
                        $other_resources_counter=0;
                        for($i=0;$i<count($all_other_creators);$i++)
                        {
                            $creator_qualification=$prod->get_client_qualifications($all_other_creators[$i]['client_ID']);
                            $creator_right=$prod->get_client_rights($all_other_creators[$i]['client_ID']);
                                    
                            if($creator_right['u_status']=="active")
                            {
                                if($o_prod['prod_id']=="p1561")
                                {
                                    if(($creator_qualification['b5_walls']>0)||($creator_qualification['b5_windows_doors']>0))
                                    {
                                        if($other_resources_counter==0)
                                        {
                                            ?>
                                            <option style="color:red;">Resources from other companies</option>
                                            <?php
                                            $other_resources_counter++;
                                        }
                            ?>
                                <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_other_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_other_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_other_creators[$i]['c_last_name']))
                                    {
                                    echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_walls'].")(".$creator_qualification['b5_windows_doors'].")";
                                    }
                                    else
                                    {
                                    echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_walls'].")(".$creator_qualification['b5_windows_doors'].")";
                                    }?> </option>
                            <?php
                                    }
                                }	
                                
                                
                                if(((substr($o_prod['prod_id'],1)>1561)&&(substr($o_prod['prod_id'],1)<1566))||((substr($o_prod['prod_id'],1)>1581)&&(substr($o_prod['prod_id'],1)<1590)))
                                {
                                    if($creator_qualification['b5_render_stills']>0)
                                    {
                                        if($other_resources_counter==0)
                                        {
                                            ?>
                                            <option style="color:red;">Resources from other companies</option>
                                            <?php
                                            $other_resources_counter++;
                                        }
                            ?>
                                <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_other_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_other_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_other_creators[$i]['c_last_name']))
                                    {
                                    echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_render_stills'].")";
                                    }
                                    else
                                    {
                                    echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_render_stills'].")";
                                    }?> </option>
                            <?php
                                    }
                                }	

                                if($o_prod['prod_id']=="p1566")
                                {
                                    if($creator_qualification['b5_render_360']>0)
                                    {
                                        if($other_resources_counter==0)
                                        {
                                            ?>
                                            <option style="color:red;">Resources from other companies</option>
                                            <?php
                                            $other_resources_counter++;
                                        }
                            ?>
                                <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_other_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_other_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_other_creators[$i]['c_last_name']))
                                    {
                                    echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_render_360'].")";
                                    }
                                    else
                                    {
                                    echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_render_360'].")";
                                    }?> </option>
                            <?php
                                    }
                                }

                                if($o_prod['prod_id']=="p1567")
                                {
                                    if($creator_qualification['b5_render_movie']>0)
                                    {
                                        if($other_resources_counter==0)
                                        {
                                            ?>
                                            <option style="color:red;">Resources from other companies</option>
                                            <?php
                                            $other_resources_counter++;
                                        }
                            ?>
                                <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_other_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_other_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_other_creators[$i]['c_last_name']))
                                    {
                                    echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_render_movie'].")";
                                    }
                                    else
                                    {
                                    echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_render_movie'].")";
                                    }?> </option>
                            <?php
                                    }
                                }

                                if($o_prod['prod_id']=="p1568")
                                {
                                    if($creator_qualification['b5_vr']>0)
                                    {
                                        if($other_resources_counter==0)
                                        {
                                            ?>
                                            <option style="color:red;">Resources from other companies</option>
                                            <?php
                                            $other_resources_counter++;
                                        }
                            ?>
                                <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_other_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_other_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_other_creators[$i]['c_last_name']))
                                    {
                                    echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_vr'].")";
                                    }
                                    else
                                    {
                                    echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_vr'].")";
                                    }?> </option>
                            <?php
                                    }
                                }

                                if($o_prod['prod_id']=="p1581")
                                {
                                    if($creator_qualification['b5_environment']>0)
                                    {
                                        if($other_resources_counter==0)
                                        {
                                            ?>
                                            <option style="color:red;">Resources from other companies</option>
                                            <?php
                                            $other_resources_counter++;
                                        }
                            ?>
                                <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" data-creator_task_count="<?php 
                                    $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                                    echo count($count_working_tasks);?>" value="<?php echo $all_other_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_other_creators[$i]['client_ID'])?"selected":""?>><?php 
                                    if(!empty($all_other_creators[$i]['c_last_name']))
                                    {
                                    echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_environment'].")";
                                    }
                                    else
                                    {
                                    echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_environment'].")";
                                    }?> </option>
                            <?php
                                    }
                                }

                            }
                        }
                        
                        
                        ?>                                                
                        </select>
                        <script type="text/javascript">
                            $('#creators_<?php echo $global_creator_counter;?>').on("change",function(){
                                $.ajax({
                                url: "../ajax/assign_creator.php",
                                method: "get",
                                data: {o_id:<?php echo $o_prod['o_id'];?>,osub_id:"<?php echo $o_prod['osub_id'];?>",prod_id:"<?php echo $o_prod['prod_id'];?>",creatorid:$(this).val()},
                                dataType:"html",
                                success:function(data) {
                                    console.log(data);
                                    $('#task<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 blue');
                                    $('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').val(2);					
                                }
                                });
                            });
                        </script>	
                        <a href="taskdetails.php?o_id=<?php echo $o_prod['o_id'];?>&osub_id=<?php echo $o_prod['osub_id']; ?>&prod_id=<?php echo $o_prod['prod_id'];?>" class="btn btn-sm btn-primary col-5 align-self-center mx-1">Details</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group align-self-center mb-0">
                    <select class="form-control form-control-sm" name="" data-osub_id="<?php echo $o_prod['osub_id'];?>" data-prod_id="<?php echo $o_prod['prod_id'];?>" id="product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>">
                    <?php 
                    for($j=1;$j<count($allstatus);$j++)
                    {
                    ?>
                        <option value="<?php echo $allstatus[$j]['ost_id'];?>" data-status="<?php echo $allstatus[$j]['ost_color'];?>" <?php echo ($allstatus[$j]['ost_id']==$o_prod['p_status'])?"selected":"";?>><?php echo ucfirst($allstatus[$j]['ost_name']);?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <script type="text/javascript">
                        $('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').on("change",function(){
                            var collection=$('#collection').val().split(";");
                            var current_osub_id=$('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').data('osub_id');
                            var current_o_id=<?php echo $o_prod['o_id'];?>;

                            $.ajax({
                            url: "../ajax/change_product_status.php",
                            method: "get",
                            data: {o_id:<?php echo $o_prod['o_id'];?>,osub_id:"<?php echo $o_prod['osub_id'];?>",prod_id:"<?php echo $o_prod['prod_id'];?>",p_status:$(this).val()},
                            dataType:"html",
                            success:function(data) {
                                //console.log(data);
                                var status=$('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').val();
                                
                                
                                var clasa=$('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?> option:selected').data('status');
                                console.log($('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?> option:selected').data('status'));
                                $('#task<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 '+clasa);
                                
                                var p;

                                for(p=0;p<collection.length;p++)
                                {
                                    //console.log(collection[p]);
                                    if(collection[p]!="")
                                    {
                                        let product=collection[p];

                                        var prod = product.substring(1, product.lenght);

                                        if((prod>=1560)&&(prod<1599))
                                        {
                                            $.ajax({
                                            url: "../ajax/coordination_get_b5_ex_product.php",
                                            method: "get",
                                            data: {o_id:current_o_id,osub_id:current_osub_id,prod_id:product},
                                            dataType:"html",
                                            success:function(data2) {
                                                //console.log(data2);

                                                $("#row"+current_o_id+"_"+current_osub_id+"_"+product).html(data2);
                                                console.log("row"+current_o_id+"_"+current_osub_id+"_"+product);
                                            }
                                            });
                                        }
                                    }
                                }
                            }
                            });
                        });
                    </script>
                </div>
            </div>    
            <div class="col-6 text-center">
                <p class="mb-0">labc: <?php echo $labc=$prod->calculateProductlabc_by_orderid($o_prod['prod_id'],$o_prod['o_id']);?></p>
            </div>
        </div>
    </div>
</div>