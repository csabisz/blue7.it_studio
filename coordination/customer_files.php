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
        <p class="w-100 mb-0 text-center"><b>Note</b></p>
    </div>
    <div class="col-md-3 border-left border-dark">
        <p class="w-100 mb-0 text-center"><b>Client´s file name:</b></p>
    </div>
</div>


<?php


for ($i = 0; $i < count($customer_files); $i++) 
{
    if($customer_files[$i]['of_type_dom']!="pdf")
    {
    ?>
    <div class="row colorline mx-0 w-100 border-bottom border-dark">
        <div class="col-md-3 ellipsis border-dark border-right py-1">
            <span title="<?php echo $customer_files[$i]['of_subtitle']; ?>"><?php echo $customer_files[$i]['of_subtitle']; ?></span>
        </div>
        
        <?php
        $tempfile = explode(".", $customer_files[$i]['of_name_client']);
        $file_extension = strtolower(end($tempfile));

        if ($file_extension == "pdf") 
        {
            ?>
            <div class="col-md-2 border-dark py-1">
                <img class="img-responsive" style="width:40px;cursor:pointer;"
                        src="<?php echo $base_url;?>img/adobe-pdf-icon.png" alt="pdf file">
            </div>
            <?php
        } 
        elseif($file_extension == "dxf")
        {
            ?>
            <div class="col-md-2 border-dark py-1">
                <img class="img-responsive" style="width:40px;cursor:pointer;"
                        src="<?php echo $base_url;?>img/dxf_icon.jpg" alt="dxf file">
            </div>
            <?php
        }
        else 
        {

            if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
                ?>
                <div class="col-md-2 py-1">
                    <div id="image_tooltip_container_<?php
                    echo $image_preview_counter;
                    ?>"><img class="img-responsive" style="width:60px;cursor:pointer;"
                                src="<?php echo $base_url;?>client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="col-md-1 py-1">
            <a href="<?php echo $base_url;?>image.php?filecategory=customerfiles&imageid=<?php echo $customer_files[$i]['of_id']; ?>"
                class="btn btn-primary btn-sm mr-1" target="_blank"><i class="fas fa-arrow-circle-down"></i></a>
        </div>
        <div class="col-md-3 py-1 border-left border-dark">
            <?php
            $note = $customer_files[$i]['of_kind'];
            if ($note == 1) {
                echo "Order! Main file";
            }
            if ($note == 2) {
                echo "Outview-Photo";
            }

            if ($note == 8) {
                echo "NO ORDER! Only for understanding";
            }
            ?>

            <?php
            if(strpos($customer_files[$i]['of_internal_name_dom'],'pdfid_')!==false)
            {
					
				?>
				<div class="row">
					<div class="col-md-12 text-center">
						<?php 					
						
						$pdf_array=explode('pdfid_',$customer_files[$i]['of_internal_name_dom']);
						$pdf_id_array=explode('_',$pdf_array[1]);					
						
						?>
						<a href="<?php
						if(!empty($pdf_id_array))
						{
						?>
						../image.php?filecategory=customerfiles&imageid=<?php echo $pdf_id_array[0]; 
						}
						else
						{
							echo "#";
						}?>" target="_blank">
							<img src="<?php echo $base_url;?>img/adobe-pdf-icon.png" alt="<?php echo $customer_files[$i]['of_name_client'];?>" style="width:60px;">
						</a>
					</div>
				</div>
				<?php
			}
				?>
        </div> 
        
        <?php
        if (in_array($customer_files[$i]['of_type_dom'], $validextensions)) {
            ?>
            <div id="image_tooltip_<?php echo $image_preview_counter; ?>"><img
                        class="img-responsive" width="600"
                        src="<?php echo $base_url;?>client_files/<?php echo $customer_files[$i]['of_path_dom'] . $customer_files[$i]['of_internal_name_dom']; ?>">
            </div>
            <?php
        }
        ?>
        <div class="col-md-3 border-dark border-left ellipsis py-1">
            <span title="<?php echo $customer_files[$i]['of_name_client']; ?>"><?php echo $customer_files[$i]['of_name_client']; ?></span>
        </div>
    </div>
    <?php
    $image_preview_counter++;
    }
}
?>