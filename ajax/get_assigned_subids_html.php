<?php
include('../functions.php');

$prod=new Production;

$of_id=$prod->xss_fix($_GET['of_id']);
$o_id=$prod->xss_fix($_GET['o_id']);

$base_url="https://cseven.eu/studio/";
?>
SubIDs for client file ID <?php 

echo $of_id;

$all_subids=$prod->get_all_subids_by_o_id($o_id);


?>
<input type="hidden" id="this_of_id" value="<?php echo $of_id;?>">
<div class="row">
    <div class="col-md-6">
        <b>Interior</b>
    </div>
    <div class="col-md-6">
        <b>Exterior</b>
    </div>
</div> 
<div class="row">
    <div class="col-md-6">
        <?php
        for($i=0;$i<count($all_subids);$i++)
        {
            
        ?>
        <div class="row">
        <div class="col-md-12"><?php
        if(strpos($all_subids[$i]['o_sub_id'], 'n') !== false)
        {
        ?>
        <input type="checkbox" id="subo_id_cbx<?php echo $all_subids[$i]['subo_id'];?>" data-cf_id="<?php echo $of_id;?>" class="form-input" value="<?php echo $of_id;?>" <?php 
        if (strpos($all_subids[$i]['cf_id'], $of_id) !== false) 
        {
            echo "checked";
        }
        ?>>
        <label for="subo_id_cbx<?php echo $all_subids[$i]['subo_id'];?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
        <?php
        }
        ?>
        </div> <!-- end col-md-12 -->
    </div> <!--end interior row -->
    <script type="text/javascript">
        $('#subo_id_cbx<?php echo $all_subids[$i]['subo_id'];?>').click(function(){
            let cf_id=<?php echo $of_id;?>;
            let subo_id=<?php echo $all_subids[$i]['subo_id'];?>;
            let checked=0;
            let o_id=<?php echo $o_id;?>;
            
            if($(this).is(':checked'))
            {
                checked=1;
            }
            $.ajax({
            url: "<?php echo $base_url;?>ajax/update_orders_subnames_cf_id.php",
            method: "post",
            data: {
                subo_id: subo_id,
                cf_id:cf_id,
                checked:checked
                },
            dataType:"html",
            success:function(data) {

                /*$.ajax({
            url: "<?php echo $base_url;?>ajax/get_existing_assigned_osub_ids_html.php",
            method: "get",
            data: {
                o_id: o_id,
                of_id:cf_id                
                },
            dataType:"html",
            success:function(data) {
                $('#selected_sub_ids'+cf_id).html(data);    										
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
            
            });*/ //end show result		

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
            
            }); //end done
        });
    </script>
        <?php
        }
        ?>
    </div> <!-- end col-md-6 -->
    <div class="col-md-6"><?php
        for($i=0;$i<count($all_subids);$i++)
        {            
        ?>
        <div class="row">
        <div class="col-md-12"><?php
        if(strpos($all_subids[$i]['o_sub_id'], 'x') !== false)
        {
        ?>
        <input type="checkbox" id="subo_id_cbx<?php echo $all_subids[$i]['subo_id'];?>" data-cf_id="<?php echo $of_id;?>" class="form-input" value="<?php echo $of_id;?>" <?php 
        if (strpos($all_subids[$i]['cf_id'], $of_id) !== false) 
        {
            echo "checked";
        }
        ?>>
        <label for="subo_id_cbx<?php echo $all_subids[$i]['subo_id'];?>"><?php echo $all_subids[$i]['o_sub_id'];?></label>
        <?php
        }
        ?></div> <!-- end col-md-12 -->
        </div> <!-- end exterior row -->
        <script type="text/javascript">
        $('#subo_id_cbx<?php echo $all_subids[$i]['subo_id'];?>').click(function(){
            let cf_id=<?php echo $of_id;?>;
            let subo_id=<?php echo $all_subids[$i]['subo_id'];?>;
            let checked=0;

            if($(this).is(':checked'))
            {
                checked=1;
            }
            $.ajax({
            url: "<?php echo $base_url;?>ajax/update_orders_subnames_cf_id.php",
            method: "post",
            data: {
                subo_id: subo_id,
                cf_id:cf_id,
                checked:checked
                },
            dataType:"html",
            success:function(data) {

                /*$.ajax({
            url: "<?php echo $base_url;?>ajax/get_existing_assigned_osub_ids_html.php",
            method: "get",
            data: {
                o_id: o_id,
                of_id:cf_id                
                },
            dataType:"html",
            success:function(data) {
                $('#selected_sub_ids'+cf_id).html(data);    										
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
            
            }); *///end update result

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
            
            }); //end done
        });
    </script>
        <?php
        }
        ?>
    </div> <!-- end col-md-6 -->       
</div> <!-- end row -->