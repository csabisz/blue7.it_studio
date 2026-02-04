<div class="row w-100 mx-0 border-bottom border-dark">
                                <div class="col-md-3">
                                    <p class="w-100 mb-0 text-center"><b>Internal name</b></p>
                                </div>
                                
                                <div class="col-md-2 border-left border-dark">
                                    &nbsp;
                                </div>
                                <div class="col-md-1">
                                    &nbsp;
                                </div>
                                
                                <div class="col-md-3 border-left border-dark">
                                    <p class="w-100 mb-0 text-center"><b>Client´s file name:</b></p>
                                </div>
                            </div>
                            <?php
                            
                            //new sub id check

                            $subnames_data['o_id'] = $o_id;
                            $subnames_data['o_sub_id'] = $osub_id;

                            $validextensions = array("jpeg", "jpg", "png","webp");
                            $image_preview_counter = 0;

                            $orders_subnames = $prod->check_existing_subid(json_encode($subnames_data));

                            $all_sub_id_customer_files = explode(';', $orders_subnames['cf_id']);
                            

                            for ($i = 0; $i < count($all_sub_id_customer_files); $i++) 
                            {
                                if (!empty($all_sub_id_customer_files[$i])) 
                                {
                                    $customer_file = $prod->get_customer_file($all_sub_id_customer_files[$i]);
                                    if(!empty($customer_file['of_subtitle']))
                                    {
                                    ?>
                                    <div class="row colorline mx-0 w-100 border-bottom border-dark">
                                        <div class="col-md-3">
                                        <?php echo $customer_file['of_subtitle']; ?>
                                        </div>
                                        
                                        <?php
                                        $tempfile = explode(".", $customer_file['of_name_client']);
                                        $file_extension = strtolower(end($tempfile));

                                        if ($file_extension == "pdf") {
                                            ?>
                                            <div class="col-md-2 border-left border-dark py-1">
                                                <img class="img-responsive" style="width:40px;cursor:pointer;"
                                                src="<?php echo $base_url;?>img/adobe-pdf-icon.png" alt="pdf file">
                                            </div>
                                            <?php
                                        } 
                                        if ($file_extension == "dxf") {
                                            ?>
                                            <div class="col-md-2 border-left border-dark py-1">
                                                <img class="img-responsive" style="width:40px;cursor:pointer;"
                                                src="<?php echo $base_url;?>img/dxf_icon.jpg" alt="dxf file">
                                            </div>
                                            <?php
                                        }
                                        else 
                                        {

                                        if (in_array($customer_file['of_type_dom'], $validextensions)) 
                                        {
                                            ?>
                                            <div class="col-md-2 border-left border-dark py-1">
                                                <div id="image_tooltip_container_<?php
                                                echo $image_preview_counter;
                                                ?>"><img class="img-responsive" style="width:60px;cursor:pointer;"
                                                        src="<?php echo $base_url;?>client_files/<?php echo $customer_file['of_path_dom'] . $customer_file['of_internal_name_dom']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                        }

                                        }
                                        /*
                                        if (strpos($osub_id, 'n') !== false) {
                                            ?>
                                            <div class="col-md-1 py-1 border-left border-dark">
                                                <?php echo $customer_file['of_position']; ?>
                                            </div>
                                            <?php
                                        }
                                        if (strpos($osub_id, 'x') !== false) {
                                            ?>
                                            <div class="col-md-1 py-1 border-left border-dark">
                                                <?php echo $customer_file['of_exterior_position']; ?>
                                            </div>
                                            <?php
                                        } */ /*
                                        ?>
                                        <div class="col-md-2 py-1 border-left border-dark">
                                            <?php
                                            if (strpos($osub_id, 'n') !== false) {
                                                echo $customer_file['of_name'];
                                            } else {
                                                echo $customer_file['of_name_ex'];
                                            } ?>
                                        </div> <?php */  /* ?>
                                        <div class="col-md-2 ellipsis py-1 border-left border-dark">
                                            <?php
                                            $note = $customer_file['of_kind'];
                                            if ($note == 1) {
                                                echo "Order! Main file";
                                            }
                                            if ($note == 8) {
                                                echo "NO ORDER! Only for understanding";
                                            }
                                            ?>
                                        </div> <?php */ ?>
                                        <div class="col-md-1 py-1 border-right border-dark">
                                            <a href="<?php echo $base_url;?>image.php?filecategory=customerfiles&imageid=<?php echo $customer_file['of_id']; ?>"
                                            class="btn btn-primary btn-sm mr-1" target="_blank"><i class="fas fa-arrow-circle-down"></i></a>
                                        </div>
                                        <?php
                                        if (in_array($customer_file['of_type_dom'], $validextensions)) {
                                            ?>
                                            <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                                                        class="img-responsive" width="600"
                                                        src="<?php echo $base_url;?>client_files/<?php echo $customer_file['of_path_dom'] . $customer_file['of_internal_name_dom']; ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-md-3 ellipsis py-1">
                                            <span title="<?php echo $customer_file['of_name_client']; ?>"><?php echo $customer_file['of_name_client']; ?></span>
                                        </div>
                                    </div>
                                    <?php
                                    $image_preview_counter++;
                                    }
                                }
                            }