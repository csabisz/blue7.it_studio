<?php
include('../functions.php');
$prod = new Production;

$ho_id = $_GET['ho_id'];
$h_id = $_GET['h_id'];

$ho_data = $prod->get_ho_default_elements($ho_id);

$default_elements = $ho_data['default_elements'];

$default_elements_arr = explode(',', $default_elements);

$model_elements = $prod->get_al_model_elements();

?>

<div class="row justify-content-left mt-4">
    <div class="col-md-6">
        <input id="search_model_elements" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    </div>
</div>

<div class="d-inline d-flex flex-wrap mt-4">
    <input id="def_el" type="hidden" value="<?php implode($default_elements_arr) ?>">

    <?php

    foreach ($model_elements as $model_element) {
        $model_element_id = $model_element['me_id'];
        $model_element_name = $model_element['element_name'];
        $model_element_active = $model_element['active'];


        ?>
        <div id="<?php echo $model_element_name ?>" class="col-sm-4 mb-2 card-column">
            <div class="card">
                <div class="card-body">
                    <input class="ml-3" type="checkbox" value="<?php echo $model_element_id ?>"
                           id="check_box_<?php echo $model_element_id ?>"
                        <?php foreach ($default_elements_arr as $default_element) {
                            if ($model_element['me_id'] === $default_element) {
                                echo ' checked';
                            }
                        }
                        ?>>
                    <label for="check_box_<?php echo $model_element_id ?>"><?php echo $model_element_name ?></label><br>
                </div>
            </div>
        </div>

        <script>
            $('#check_box_<?php echo $model_element_id ?>').click(function () {


                if ($(this).prop("checked") === true) {
                    console.log($(this).prop("value"));
                    console.log($(this));
                    $.ajax({
                        url: '../ajax/insert_new_me_ids_checked.php',
                        method: 'GET',
                        data: {
                            elements_arr: $('#def_el').prop('value'),
                            new_me_id: $(this).prop("value"),
                            ho_id: '<?php echo $ho_id ?>'
                        },
                        dataType: 'html',
                        success: function (data) {
                            $('#model_default_elements').prepend(data);
                            $('#def_el').prop('value', '<?php echo implode($default_elements_arr)?>' + ',' + $('#check_box_<?php echo $model_element_id ?>').prop("value"));

                        }
                    });

                    console.log("Checkbox is checked.");


                } else if ($(this).prop("checked") === false) {

                    $.ajax({
                        url: '../ajax/insert_new_me_ids_unchecked.php',
                        method: 'GET',
                        data: {
                            elements_arr: $('#def_el').prop('value'),
                            new_me_id: $(this).prop("value"),
                            ho_id: '<?php echo $ho_id ?>'
                        },
                        dataType: 'html',
                        success: function (data) {
                            $('#model_default_elements').prepend(data);
                            $('#def_el').prop('value', '<?php echo implode($default_elements_arr)?>' + ',' + $('#check_box_<?php echo $model_element_id ?>').prop("value"));

                        }
                    });
                    console.log("Checkbox is unchecked.");
                }

            })
        </script>

    <?php }
    ?>

    <script>

        $('#search_model_elements').on('input', function () {

            for (let card of $('.card-column')){
                if (card.id.toUpperCase().includes($('#search_model_elements').val().toUpperCase())){
                    console.log(card.id);
                    card.classList.add('d-block')
                    card.classList.remove('d-none')
                }
                else{
                    card.classList.remove('d-block')
                    card.classList.add('d-none')
                }
            }
        })
    </script>

</div>

