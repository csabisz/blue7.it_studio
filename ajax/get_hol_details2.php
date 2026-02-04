<style>
    .sw_price {
        border: none;
        outline: none;
        width: 35%;
    }

    .sw_price:focus {
        border: 1px solid #c4c4c4;
    }

    .sw_pic {
        box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.25);
    }

</style>

<?php

include('../functions.php');
$prod = new Production;

$cm_id = $_GET['cm_id'];
$ho_id = $_GET['ho_id'];

$cm_id_data = $prod->get_ho_menu_data($cm_id);
?>
<div class="d-inline d-flex flex-wrap mt-4">
    <input type="hidden" id="ho_id" value="<?php echo $ho_id ?>">

    <?php
    $active_options = array();
    $pictures_array = array();
    $prices_array = array();

    $table = '';
    $item_id_name = '';
    $item_id = '';


    $table = $cm_id_data['items_table_name'];
    $price_table = $cm_id_data['items_table_price'];
    $item_id_name = $cm_id_data['items_id_name'];

    $pictures_array = $prod->get_all_data_from_domennia2_table($table);
    $prices_array = $prod->get_all_data_from_superplan_order_table($price_table, $ho_id);

        print '<pre>';
        print_r($prices_array);
        print '</pre>';


    for ($i = 0; $i < count($pictures_array); $i++) {
        array_push($active_options, $pictures_array[$i]);
        for ($j = 0; $j < count($prices_array); $j++) {
            if ($pictures_array[$i][$item_id_name] == $prices_array[$j][$item_id_name]) {
                if ($prices_array[$j]['status'] == 1) {
                    $active_options[$i]['active'] = 'true';
                }
                if ($prices_array[$j]['mm_id']) {
                    $active_options[$i]['mm_id'] = $prices_array[$j]['mm_id'];
                }
                $active_options[$i]['price'] = $prices_array[$j]['price'];
            }
        }
    }

    print '<pre>';
    print_r($active_options);
    print '</pre>';

    for ($i = 0; $i < count($active_options); $i++) {

        $item_id = $active_options[$i][$cm_id_data['items_id_name']];
        $sw_name = $active_options[$i][$cm_id_data['items_name']];
        $sw_pic = $active_options[$i][$cm_id_data['items_pic']];
        $sw_price = $active_options[$i]['price'];
        $sw_status = $active_options[$i]['active'];


        ?>


        <div class="col-sm-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <img width="20%" src="https://domenia.blue7.it/<?php echo $sw_pic ?>"
                         class="sw_pic" alt="No picture">
                    <input class="ml-3" type="checkbox" name="<?php echo $item_id ?>"
                           id="sw_check_box_<?php echo $item_id ?>" <?php if ($sw_status === 'true') echo ' checked' ?>>
                    <label for="<?php echo $item_id ?>"><?php echo $sw_name ?></label><br>
                    <?php if ($sw_status === 'true') { ?>
                        <div class="price_div d-flex d-inline wrap flex-row">
                            <label class="mr-3 mt-2 font-weight-bold" for="sw_price">Price:</label>
                            <input type="text" id="sw_price_<?php echo $item_id ?>"
                                   class="mr-3 sw_price" value="<?php echo $sw_price ?>">
                            <button type="button" id="sw_price_btn_<?php echo $item_id ?>" class="btn btn-primary">
                                Change
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            $("#sw_price_btn_<?php echo $item_id?>").click(function () {
                console.log('Price Changed');
                if ($("#sw_price_<?php echo $item_id?>").val() !== '') {
                    console.log('Price Changed for #sw_price_<?php echo $item_id?> to: ' + $("#sw_price_<?php echo $item_id?>").val());
                    $.ajax({
                        url: '../ajax/change_configurator_price.php',
                        method: 'GET',
                        data: {
                            ho_id: '<?php echo $ho_id ?>',
                            table: '<?php echo $price_table ?>',
                            item_id_name: '<?php echo $item_id_name ?>',
                            item_id: '<?php echo $item_id ?>',
                            price: $("#sw_price_<?php echo $item_id?>").val()
                        },
                        dataType: 'html',
                        success: function (data) {
                            $('#swatches_container').prepend(data);
                        }
                    });
                }
            });

            $("#sw_check_box_<?php echo $item_id?>").click(function () {
                console.log($("#sw_price_<?php echo $item_id?>"))
                console.log("Price:<?php echo $sw_price?>")
                if ($("#sw_price_<?php echo $item_id?>").length === 0 && "<?php echo $sw_price?>" === '') {
                    let price_prompt = prompt('Please enter price for new swatch: ', '0');
                    $.ajax({
                        url: '../ajax/add_configurator_price.php',
                        method: 'GET',
                        data: {
                            ho_id: '<?php echo $ho_id ?>',
                            table: '<?php echo $price_table ?>',
                            item_id_name: '<?php echo $item_id_name ?>',
                            item_id: '<?php echo $item_id ?>',
                            //mm_id: '<?php //echo $mm_id ?>//',
                            price: price_prompt
                        },
                        dataType: 'html',
                        success: function (data) {
                            $('#swatches_container').prepend(data);
                        }
                    });

                }


                let status;
                if ($(this).prop("checked") === true) {

                    console.log("Checkbox is checked.");
                    status = 1;
                    console.log(status);

                } else if ($(this).prop("checked") === false) {

                    console.log("Checkbox is unchecked.");
                    status = 0;
                    console.log(status);
                }

                $.ajax({
                    url: '../ajax/activate_configurator_swatch.php',
                    method: 'GET',
                    data: {
                        ho_id: '<?php echo $ho_id ?>',
                        table: '<?php echo $price_table ?>',
                        item_id_name: '<?php echo $item_id_name ?>',
                        item_id: '<?php echo $item_id ?>',
                        status: status
                    },
                    dataType: 'html',
                    success: function (data) {
                        $('#swatches_container').prepend(data);
                    }
                });

                //$.ajax({
                //    url: '../ajax/get_hol_details2.php',
                //    method: 'get',
                //    // data: {cm_id: $('#cm_id option:selected').val(), ho_id: $('#ho_id').val()},
                //    data: {cm_id: '<?php //echo $cm_id?>//', ho_id: '<?php //echo $ho_id?>//'},
                //    dataType: 'html',
                //    success: function (data) {
                //        console.log(data)
                //        $('#swatches_container').html(data);
                //    }
                //});

            });


        </script>


        <?php
    }

    ?>
</div>



