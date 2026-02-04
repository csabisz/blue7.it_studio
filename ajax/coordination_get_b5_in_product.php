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
                        if($customer_files[$c]['of_position']==$osub_id)
                        {
                            echo $customer_files[$c]['of_name'];
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
                                    if($o_prod['prod_id']=="p1501")
                                    {
                                        if(($creator_qualification['b5_walls']>0)||($creator_qualification['b5_windows_doors']>0))
                                        {
                                ?>
                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="walls_windows_creator_task_count offline" data-creator_task_count="<?php 
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
                                    

                                    if(((substr($o_prod['prod_id'],1)>1501)&&(substr($o_prod['prod_id'],1)<1506))||((substr($o_prod['prod_id'],1)>1521)&&(substr($o_prod['prod_id'],1)<1526))||((substr($o_prod['prod_id'],1)>1541)&&(substr($o_prod['prod_id'],1)<1546)))
                                    {
                                        if($creator_qualification['b5_render_stills']>0)
                                        {
                                ?>
                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="b5_render_stills_creator_task_count offline" data-creator_task_count="<?php 
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

                                    if(($o_prod['prod_id']=="p1521")||($o_prod['prod_id']=="p1541"))
                                    {
                                        if($creator_qualification['b5_furniture']>0)
                                        {
                                ?>
                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="b5_furniture_creator_task_count offline" data-creator_task_count="<?php 
                                        $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                                        echo count($count_working_tasks);?>" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                        if(!empty($all_creators[$i]['c_last_name']))
                                        {
                                        echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_furniture'].")";
                                        }
                                        else
                                        {
                                        echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_furniture'].")";
                                        }?> </option>
                    
                                <?php
                                        }
                                    }

                                    if(($o_prod['prod_id']=="p1506")||($o_prod['prod_id']=="p1526")||($o_prod['prod_id']=="p1546"))
                                    {
                                        if($creator_qualification['b5_render_360']>0)
                                        {
                                ?>
                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="b5_render_360_creator_task_count offline" data-creator_task_count="<?php 
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

                                    if(($o_prod['prod_id']=="p1507")||($o_prod['prod_id']=="p1527")||($o_prod['prod_id']=="p1547"))
                                    {
                                        if($creator_qualification['b5_render_movie']>0)
                                        {
                                ?>
                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="b5_render_movie_creator_task_count offline" data-creator_task_count="<?php 
                                        $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                                        echo count($count_working_tasks);?>" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                        if(!empty($all_creators[$i]['c_last_name']))
                                        {
                                        echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_render_movie'].")";
                                        }
                                        else
                                        {
                                        echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_render_movie'].")";
                                        }?> </option>
                                    
                                <?php
                                        }
                                    }

                                    if(($o_prod['prod_id']=="p1508")||($o_prod['prod_id']=="p1528")||($o_prod['prod_id']=="p1548"))
                                    {
                                        if($creator_qualification['b5_vr']>0)
                                        {
                                ?>
                                    <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="b5_render_movie_creator_task_count offline" data-creator_task_count="<?php 
                                        $count_working_tasks=$prod->count_working_tasks($all_creators[$i]['client_ID']);
                                        echo count($count_working_tasks);?>" value="<?php echo $all_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_creators[$i]['client_ID'])?"selected":""?>><?php 
                                        if(!empty($all_creators[$i]['c_last_name']))
                                        {
                                        echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b5_vr'].")";
                                        }
                                        else
                                        {
                                        echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b5_vr'].")";
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
                                    if($o_prod['prod_id']=="p1501")
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
                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="b5_walls_windows_creator_task_count offline"  data-creator_task_count="<?php 
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
                                    

                                    if(((substr($o_prod['prod_id'],1)>1501)&&(substr($o_prod['prod_id'],1)<1506))||((substr($o_prod['prod_id'],1)>1521)&&(substr($o_prod['prod_id'],1)<1526))||((substr($o_prod['prod_id'],1)>1541)&&(substr($o_prod['prod_id'],1)<1546)))
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
                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="b5_render_stills_creator_task_count offline" data-creator_task_count="<?php 
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

                                    if(($o_prod['prod_id']=="p1521")||($o_prod['prod_id']=="p1541"))
                                    {														
                                        if($creator_qualification['b5_furniture']>0)
                                        {	
                                            if($other_resources_counter==0)
                                            {
                                                ?>
                                                <option style="color:red;">Resources from other companies</option>
                                                <?php
                                                $other_resources_counter++;
                                            }
                                ?>
                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="b5_furniture_creator_task_count offline" data-creator_task_count="<?php 
                                        $count_working_tasks=$prod->count_working_tasks($all_other_creators[$i]['client_ID']);
                                        echo count($count_working_tasks);?>" value="<?php echo $all_other_creators[$i]['client_ID'];?>" <?php echo ($o_prod['uca_id']==$all_other_creators[$i]['client_ID'])?"selected":""?>><?php 
                                        if(!empty($all_other_creators[$i]['c_last_name']))
                                        {
                                        echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_furniture'].")";
                                        }
                                        else
                                        {
                                        echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b5_furniture'].")";
                                        }?> </option>
                                    
                                <?php
                                        }
                                    }

                                    if(($o_prod['prod_id']=="p1506")||($o_prod['prod_id']=="p1526")||($o_prod['prod_id']=="p1546"))
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
                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="b5_render_360_creator_task_count offline" data-creator_task_count="<?php 
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

                                    if(($o_prod['prod_id']=="p1507")||($o_prod['prod_id']=="p1527")||($o_prod['prod_id']=="p1547"))
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
                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="b5_render_movie_creator_task_count offline" data-creator_task_count="<?php 
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

                                    if(($o_prod['prod_id']=="p1508")||($o_prod['prod_id']=="p1528")||($o_prod['prod_id']=="p1548"))
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
                                    <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="b5_render_movie_creator_task_count offline" data-creator_task_count="<?php 
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
                                        if($('#creators_<?php echo $global_creator_counter;?>').data("prod_id")=="p1501")
                                        {
                                            $('#task<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center dark-green');
                                            $('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').val(4);					
                                        }
                                        else
                                        {
                                            $('#task<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center blue');
                                            $('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').val(2);					
                                        }
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
                                    
                                    var status=$('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').val();
                                                                        
                                    var clasa=$('#product_status<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?> option:selected').data('status');
                                    //console.log(clasa);
                                    $('#task<?php echo $o_prod['o_id']."_".$o_prod['osub_id']."_".$o_prod['prod_id'];?>').removeClass().addClass('row w-100 mx-0 py-2 d-flex justify-content-center '+clasa);
                                     
                                    var p;

                                    for(p=0;p<collection.length;p++)
                                    {
                                        console.log(collection[p]);
                                        if(collection[p]!="")
                                        {
                                            let product=collection[p];

                                            var prod = product.substring(1, product.lenght);

                                            if((prod>1501)&&(prod<1560))
                                            {
                                                $.ajax({
                                                url: "../ajax/coordination_get_b5_in_product.php",
                                                method: "get",
                                                data: {o_id:current_o_id,osub_id:current_osub_id,prod_id:product},
                                                dataType:"html",
                                                success:function(data2) {
                                                    //console.log(data2);

                                                    $("#row"+current_o_id+"_"+current_osub_id+"_"+product).html(data2);
                                                    //console.log("row"+current_o_id+"_"+current_osub_id+"_"+product);
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
<?php
if($o_prod['om_id']!=0)
{
    $result_files=$prod->show_results($o_prod['o_id'],$o_prod['osub_id'],$o_prod['prod_id']);
}
else
{
    $result_files=$prod->show_results($o_id,$o_prod['osub_id'],$o_prod['prod_id']);
}
for($i=0;$i<count($result_files);$i++)
{
?>
    <div class="row w-100 mx-0 border-top border-white <?php echo ($result_files[$i]['orf_status']==0)?"grey-dark":"light-green"; ?>" id="result_file<?php echo $result_files[$i]['orf_id'];?>">
        <div class="col-12 px-0 py-2 text-center">
            <div class="row mx-0 w-100 d-flex justify-content-center">
                <div class="col-xs-8">
                    <div class="d-flex justify-content-center mt-3">
                            <div class="file-name bg-light text-dark px-1 d-inline">
                            <p class="mb-0 pt-1 d-inline">      
                                <input type="textbox" name="file_name" id="file_name<?php echo $result_files[$i]['orf_id']?>" value="<?php echo $result_files[$i]['orf_name'];?>" class="form-control form-control-sm">
                            </p>
                        </div>
                        <button id="rename_btn<?php echo $result_files[$i]['orf_id']?>" class="btn btn-sm btn-primary ml-2 d-inline">Rename</button>
                    </div>
                </div>
                <div class="col-xs-4 pt-2 pl-4">
                    <script type="text/javascript">
                    $('#rename_btn<?php echo $result_files[$i]['orf_id']?>').click(function(){
                        $.ajax({
                        url: "../ajax/rename_result_file.php",
                        method: "post",
                        data: {orf_id:<?php echo $result_files[$i]['orf_id'];?>, file_name:$('#file_name<?php echo $result_files[$i]['orf_id'];?>').val()},
                        dataType:"html",
                        success:function(data) {												
                    
                        }
                        });
                    });
                    </script>
                <?php						
                if(in_array($result_files[$i]['orf_type_dom'],$validextensions))
                {

                    if(($result_files[$i]['prod_id']=="p1506")||($result_files[$i]['prod_id']=="p1526")||($result_files[$i]['prod_id']=="p1546")||($result_files[$i]['prod_id']=="p1566"))
                    {
                    ?>     
                    <style>
                        #panorama<?php echo $image_preview_counter;?>
                        {
                            width:100%;
                            height:308px;
                        }
                    </style>   
                    <script>
                    $(document).ready(function(){

                    pannellum.viewer('panorama<?php echo $image_preview_counter;?>', {   
                        "default": {
                            "firstScene": "circle",
                            "sceneFadeDuration": 1000
                        },

                        "scenes": {
                            "circle": {
                                /*"title": "Interior",*/
                                "autoLoad":true,
                                "hfov": 110,
                                "pitch": -3,
                                "yaw": 360,
                                "type": "equirectangular",
                                "panorama": "https://cseven.eu/result_files/<?php echo $result_files[$i]['orf_path_dom'].$result_files[$i]['orf_internal_name_dom'];?>"
                                /*"panorama": "../result_files/<?php echo $result_files[$i]['orf_path_dom'].$result_files[$i]['orf_internal_name_dom'];?>"*/
                                /*"hotSpots": [
                                    {
                                        "pitch": -2.1,
                                        "yaw": 360.9,
                                        "type": "scene",
                                        "text": "Exterior",
                                        "sceneId": "house"
                                    }
                                ] */
                            }

                        /* "house": {
                                "title": "Exterior",
                                "hfov": 110,
                                "yaw": 5,
                                "type": "equirectangular",
                                "panorama": "img/3.jpg",
                                "hotSpots": [
                                    {
                                        "pitch": -0.6,
                                        "yaw": -10.1,
                                        "type": "scene",
                                        "text": "Interior",
                                        "sceneId": "circle",
                                        "targetYaw": -20,
                                        "targetPitch": 1
                                    }
                                ]
                            } */
                        }
                    });

                    /*$('#img<?php echo $image_preview_counter; ?>').click(function(){
                        $("#panorama<?php echo $image_preview_counter; ?>").dialog("open");
                    });

                    var wHeight = $(window).height();
                    var dHeight = wHeight * 0.8;

                    $( "#panorama<?php echo $image_preview_counter; ?>" ).dialog({
                        autoOpen: false, 
                        modal: true,
                        width: "90%",
                        height: dHeight
                    });*/

                    });
                    </script>
                    <?php
                    if(!empty($result_files[$i]['orf_thumbnail_path']))
                    {
                    ?>
                    <img data-toggle="modal" data-target="#pic360_<?php echo $image_preview_counter; ?>" src="../result_thumbnail_files/<?php echo $result_files[$i]['orf_thumbnail_path']; ?>" alt="<?php echo $result_files[$i]['orf_name'];?>" width="60" heigth="33.78" class="img-responsive d-inline">
                    <?php
                    }
                    else
                    {
                    ?>    
                    <img data-toggle="modal" data-target="#pic360_<?php echo $image_preview_counter; ?>" src="../result_files/<?php echo $result_files[$i]['orf_path_dom'].$result_files[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $result_files[$i]['orf_name'];?>" width="60" heigth="33.78" class="img-responsive d-inline">
                    <?php
                    }
                    ?>
                    <!-- Modal -->
                    <div class="modal fade" id="pic360_<?php echo $image_preview_counter; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="panorama<?php echo $image_preview_counter;?>"></div>
                            </div>
        
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    }
                    else
                    {
                    ?>
                    <div id="image_tooltip_container_<?php echo $image_preview_counter;?>">
                    <?php
                    if(!empty($result_files[$i]['orf_thumbnail_path']))
                    {
                    ?>    
                        <img src="../result_thumbnail_files/<?php echo $result_files[$i]['orf_thumbnail_path']; ?>" alt="<?php echo $result_files[$i]['orf_name'];?>" width="60" heigth="33.78" class="d-inline">
                    <?php    
                    }
                    else
                    {
                    ?>    
                        <img src="../result_files/<?php echo $result_files[$i]['orf_path_dom'].$result_files[$i]['orf_internal_name_dom']; ?>" alt="<?php echo $result_files[$i]['orf_name'];?>" width="60" heigth="33.78" class="d-inline">
                    <?php
                    }
                    ?>
                    </div>    
                    <!-- <script type="text/javascript">
                    $('#image_tooltip_container_<?php 							
                            echo $image_preview_counter;							
                        ?>').qtip({
                        content: {
                            text: '<img src="../img/loading.gif" alt="Loading...">', // The text to use whilst the AJAX request is loading
                            ajax: {
                                url: '../show_popup_image.php', // URL to the local file
                                type: 'GET', // POST or GET
                                data: {filecategory:'creatorfiles',orfid:'<?php echo $result_files[$i]['orf_id'];?>'} // Data to pass along with your request
                            }
                        },
                        position: {
                            target: $(window),
                            my: 'center', 
                            at: 'center'
                        },
                        show: { delay: 1000 },
                        hide: { delay: 5000 },
                        /*style: { /*classes: 'mytooltip', 
                            tip: {
                                width: 800,
                                height: 600
                            } }*/
                    });
                    </script> -->
                    <?php
                    }
                }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12 px-0 py-2">
            <p class="w-100 text-center mb-0" style="font-size: 12px;"><?php
            $creator=$prod->get_client($result_files[$i]['uca_id']);
            if(!empty($creator['c_last_name']))
            {
                echo $creator['c_first_name']." ".$creator['c_last_name'];
            }
            else
            {
                echo $creator['l_first_name']." ".$creator['l_last_name'];
            }
            $uploaded_date_time=explode(" ",$result_files[$i]['orf_upload_date']);
            echo " ".$uploaded_date_time[0].", ".$uploaded_date_time[1]." UTC+0";?></p>
            <div class="w-100 d-flex justify-content-center">
                <div class="form-group mb-0">
                    <select name="result_files_visibility<?php echo $result_files[$i]['orf_id'];?>" id="result_files_visibility<?php echo $result_files[$i]['orf_id'];?>" class="form-control form-control-sm">
                        <option value="0" <?php echo ($result_files[$i]['orf_status']==0)?"selected":""; ?>>Not visible</option>
                        <option value="7" <?php echo ($result_files[$i]['orf_status']==7)?"selected":""; ?>>Visible for checkers</option>
                        <option value="8" <?php echo ($result_files[$i]['orf_status']==8)?"selected":""; ?>>Visible for client</option>
                    </select>
                    <script type="text/javascript">
                    $('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').on("change",function(){
                        
                        $.ajax({
                        url: "../ajax/change_results_file_visibility.php",
                        method: "get",
                        data: {orf_id:<?php echo $result_files[$i]['orf_id'];?>,orf_status:$(this).val()},
                        dataType:"html",
                        success:function(data) {	
                            console.log(data);											
                        if(($('#result_files_visibility<?php echo $result_files[$i]['orf_id'];?>').val())==8)
                        {
                            $('#result_file<?php echo $result_files[$i]['orf_id'];?>').removeClass("grey-dark").addClass("light-green");
                        }
                        else
                        {
                            $('#result_file<?php echo $result_files[$i]['orf_id'];?>').removeClass("light-green").addClass("grey-dark");
                        }
                        }
                        });
                    });
                    </script>
                </div>
                <?php
                if(($result_files[$i]['prod_id']=="p1508")||($result_files[$i]['prod_id']=="p1528")||($result_files[$i]['prod_id']=="p1548"))
                {
                ?>
                <a href="<?php echo $base_url."result_files/".$result_files[$i]['orf_path_dom'].$result_files[$i]['orf_internal_name_dom'];?>" class="btn btn-sm btn-primary align-self-center ml-1" target="_blank">View Virtual Reality</a>
                <?php
                }
                else
                {
                ?>
                <a href="../image.php?filecategory=creatorfiles&orfid=<?php echo $result_files[$i]['orf_id'];?>" class="btn btn-sm btn-primary align-self-center ml-1">Download</a>
                <?php
                }
                ?>
                <button id="delete_btn<?php echo $result_files[$i]['orf_id'];?>" class="btn btn-sm btn-danger text-white align-self-center ml-1">x</button>
                <script type="text/javascript">
                $('#delete_btn<?php echo $result_files[$i]['orf_id']?>').click(function(){
                    if(confirm('Are you sure want to delete ?'))
                    {
                    $.ajax({
                    url: "../ajax/delete_result_file.php",
                    method: "post",
                    data: {orf_id:<?php echo $result_files[$i]['orf_id'];?>},
                    dataType:"html",
                    success:function(data) {	
                        console.log(data);
                        $('#result_file<?php echo $result_files[$i]['orf_id'];?>').fadeOut(3000);
                    }
                    });
                    }
                });
                </script>
            </div>
        </div>
    </div> <!-- end result files -->
<?php
$image_preview_counter++;
}
?>    
