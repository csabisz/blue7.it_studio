<?php
include('../functions.php');
include('../../../../blue7.it/public_html/domenia/domenia.php');
include('../domenia3n_db.php');

$prod=new Production;
$domenia=new Domenia;
$domenia3n=new Domenia3n;

$base_url="https://blue7.it/studio/";
$total_interior_amount=$prod->xss_fix($_POST['total_interior_amount']);
$o_id=$prod->xss_fix($_POST['o_id']);
$order=$prod->get_order($o_id);

$all_object_types=$prod->get_all_object_types();

$all_interior_entities=$prod->get_all_interior_entities($o_id);

for($i=1;$i<=$total_interior_amount;$i++)
{
    if($i<10)
    {
        $data['o_sub_id']="n0".$i;
    }
    else
    {
        $data['o_sub_id']="n".$i;
    }

    $data['o_id']=$o_id;
    
    $existing_subid=$prod->check_existing_subid(json_encode($data));
    
    if(empty($existing_subid))
    {
        $prod->add_sub_id_to_customer_file(json_encode($data));
    }
}

$all_subids=$prod->get_all_subids_by_o_id($o_id);

for($i=0;$i<count($all_subids);$i++)
{
    if (strpos($all_subids[$i]['o_sub_id'], 'n') !== false) 
    {
    ?>
    <div id="row_subname<?php echo $all_subids[$i]['subo_id'];?>" class="row">
        
        <div class="col p-0">
        <?php
        echo $all_subids[$i]['o_sub_id']."&nbsp;";
        ?>
        </div>
    <div class="col-md-auto">
    <input type="text" list="interior_subid_list<?php echo $all_subids[$i]['subo_id'];?>" id="subo_id<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" value="<?php echo $all_subids[$i]['subo_name'];?>" placeholder="Name" class="form-control form-control-sm">
    <datalist id="interior_subid_list<?php echo $all_subids[$i]['subo_id'];?>">
        <option value="Grundrisse">
        <option value="Innen">
    </datalist>
    <script type="text/javascript">
    
    $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
        $.ajax({
            url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
            method: "get",
            data: {
                subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                interior_subname:$(this).val(),
                option:"rename_interior_osn_file"},
            dataType:"html",
            success:function(data) {
                console.log(data);										
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
            
        }); 
    });

    </script>
    </div>
    
    <div class="col">
        <select id="object_type<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="form-control form-control-sm">
            <option value="">--Object type--</option>
            <?php
            for($o=0;$o<count($all_object_types);$o++)
            {
                ?>
                <option value="<?php echo $all_object_types[$o]['ot_id'];?>" <?php echo ($all_subids[$i]['object_type']==$all_object_types[$o]['ot_id'])?"selected":"";?>><?php echo $all_object_types[$o]['ot_description'];?></option>
                <?php
            }
            ?>
        </select>
        <script type="text/javascript">
            $('#object_type<?php echo $all_subids[$i]['subo_id'];?>').on('change',function(){
            $.ajax({
                url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                method: "get",
                data: {
                    subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                    object_type:$(this).val(),
                    option:"change_object_type"},
                dataType:"html",
                success:function(data) {
                    console.log(data);										
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
                
            }); 
        });
        </script>
    </div>
    <div class="col">
        <select id="entities_n<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="form-control form-control-sm">
            <option value="">--Entities--</option>
            <?php
            for($o=0;$o<count($all_interior_entities);$o++)
            {
                ?>
                <option value="<?php echo $all_interior_entities[$o]['e_n_id'];?>" <?php echo ($all_subids[$i]['e_n_id']==$all_interior_entities[$o]['e_n_id'])?"selected":"";?>><?php echo $all_interior_entities[$o]['e_n_name'];?></option>
                <?php
            }
            ?>
        </select>
        <script type="text/javascript">
            $('#entities_n<?php echo $all_subids[$i]['subo_id'];?>').on('change',function(){
            $.ajax({
                url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                method: "get",
                data: {
                    subo_id: $('#subo_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                    entities_n:$(this).val(),
                    option:"change_entities_n"},
                dataType:"html",
                success:function(data) {
                    console.log(data);										
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
                
            }); 
        });
        </script>
    </div>
    <div class="col">
        <?php 
        $stairs=$domenia3n->get_all_stairs();
        
        ?>
        <select id ="st_id0" name="st_id0" class="form-control form-control-sm" form="order_details">
            <option value="">--Choose stairs--</option>
            <?php
            for($s=0;$s<count($stairs);$s++)
            {							
            ?>
            <option value="<?php echo $stairs[$s]['st_id'];?>" <?php echo ($stairs[$s]['st_id']==$order['st_id'])?"selected":"";?>><?php echo $stairs[$s]['st_name'];?></option>
            <?php								
            }
            ?>
        </select><!-- <img src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/256/sign-question-icon.png" width="40"> -->
        <script type="text/javascript">
            $('#st_id0').click(function(){
                $('#st_id1').val($(this).val());
            });
        </script>
    </div>
    <div class="col">
        <a href="<?php echo $base_url;?>rooms/index.php?o_id=<?php echo $o_id;?>&osub_id=<?php echo $all_subids[$i]['o_sub_id'];?>" class="btn btn-sm btn-success" target="_blank" >(<?php 
        $rooms_data['o_id']=$o_id;
        $rooms_data['osub_id']=$all_subids[$i]['o_sub_id'];

        $rooms=$prod->get_all_rooms_for_this_sub_id(json_encode($rooms_data));
        echo count($rooms);
        ?>):Edit or create</a>
    </div>
    <div class="col">
        <input type="text" id="connection_id<?php echo $all_subids[$i]['subo_id'];?>" name="connection_id<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" placeholder="Connection id" class="form-control form-control-sm" value="<?php echo $all_subids[$i]['connection_id'];?>">
        <script type="text/javascript">
            $('#connection_id<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
                    $.ajax({
                    url: "<?php echo $base_url;?>ajax/change_orders_subnames.php",
                    method: "get",
                    data: {
                        subo_id: $('#connection_id<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                        connection_id:$(this).val(),
                        option:"change_connection_id"
                    },
                    dataType:"html",
                    success:function(data) {
                        console.log(data);										
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                    
                }); 
            });
        </script>
    </div>
    <div class="col">
        <textarea class="form-control form-control-sm" id="subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" placeholder="Explanation" style="height: 30px;"><?php 
        echo $all_subids[$i]['subo_more_infos'];?></textarea>
        <script type="text/javascript">
            $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').on('blur',function(){
        $.ajax({
            url: "<?php echo $base_url;?>ajax/change_orders_subnames_more_infos.php",
            method: "get",
            data: {
                subo_id: $('#subo_more_infos<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                interior_subo_more_infos:$(this).val(),
                option:"rename_interior_more_infos"
            },
            dataType:"html",
            success:function(data) {
                console.log(data);										
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
            
        }); 
    });
        </script>
    </div>
    <div class="col">
        <button type="button" id="del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>" data-subo_id="<?php echo $all_subids[$i]['subo_id'];?>" class="btn btn-sm btn-danger">X</button>
        <script type="text/javascript">
        $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').click(function(){
            if(confirm('Are you sure want to delete ?'))
            {
                $.ajax({
                    url: "<?php echo $base_url;?>ajax/delete_orders_subnames.php",
                    method: "post",
                    data: {
                        subo_id: $('#del_subname_btn<?php echo $all_subids[$i]['subo_id'];?>').data('subo_id'),
                        },
                    dataType:"html",
                    success:function(data) {
                        $('#row_subname<?php echo $all_subids[$i]['subo_id'];?>').fadeOut(3000);										
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                    
                });

            }
        });
        </script>
    </div>
    </div>
    <?php
    }
}
?>