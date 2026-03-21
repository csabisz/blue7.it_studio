<?php
session_start();
include('../functions.php');

$prod = new Production;

$base_url = "https://cseven.eu/studio/";

$all_ft_objects = $prod->get_all_ft_objects();
$all_ft_traders = $prod->get_all_ft_traders();
$all_fto_categories = $prod->get_all_fto_categories();
$all_fto_producers = $prod->get_all_fto_producers();

?>

<?php foreach ($all_ft_objects as $index => $ft_object): ?>
  <tr id="row<?= $ft_object['fto_id']; ?>">
    <th scope="row"><?= $ft_object['fto_id'] ?></th>
    <td><?= $ft_object['fto_name'] ?></td>
    <td><?= $ft_object['fto_description'] ?></td>
    <td><?= $ft_object['fto_price'] ?></td>
    <td><a href="<?=$base_url . '/furniture_objects/categories/index.php?ftoc_id=' . $ft_object['ftoc_id']?>"><?= $prod->get_translated_ftoc($ft_object['ftoc_id'], 1) ?></a></td>
    <td><a href="#"><?= $ft_object['ftop_name'] ?></a></td>
    <td><a href="#"><?= $ft_object['ftt_name'] ?></a></td>
    <td><a href="<?= $ft_object['ftto_page'] ?>" target="_blank"><?= $ft_object['ftto_page'] ?></a></td>
    <td><?php 
    $f_source=$prod->get_f_source($ft_object['f_source']);
    echo $f_source['fs_name'];
    ?></td>
    <td><?= $ft_object['fs_date'] ?></td>
    <td><?= $ft_object['fs_price'] ?></td>
    <td><?= $ft_object['fs_remarks'] ?></td>
    <td><img src="<?= $base_url.$ft_object['fs_thumbnail'] ?>" alt="thumbnail"></td>
    <td><?php 
    $main_client=$prod->get_main_client($ft_object['owner']);
    echo $main_client['clientname'];
     ?></td>
    <td><?php 
    $creator=$prod->get_client($ft_object['creator']);
    echo $creator['c_first_name'].", ".$creator['c_last_name'];
     ?></td>
    <td>
      <button type="button" class="btn btn-sm btn-warning mb-md-2 mb-lg-0 edit-fto-btn" data-toggle="modal"
              data-target="#editFurnitureObjectModal"
              data-fto-id="<?= $ft_object['fto_id'] ?>"
              data-fto-name="<?= $ft_object['fto_name'] ?>"
              data-fto-description="<?= $ft_object['fto_description'] ?>"
              data-fto-price="<?= $ft_object['fto_price'] ?>"
              data-fto-category="<?= $ft_object['ftoc_id'] ?>"
              data-fto-producer="<?= $ft_object['ftop_id'] ?>"
              data-fto-trader="<?= $ft_object['ftt_id'] ?>"
              data-ftto_page="<?= $ft_object['ftto_page'] ?>"
              data-f_source="<?= $ft_object['f_source'] ?>"
              data-fs_date="<?= $ft_object['fs_date'] ?>"
              data-fs_price="<?= $ft_object['fs_price'] ?>"
              data-fs_remarks="<?= $ft_object['fs_remarks'] ?>"
              data-fs_thumbnail="<?= $ft_object['fs_thumbnail'] ?>"
              data-owner="<?= $ft_object['owner'] ?>"
              data-creator="<?= $ft_object['creator'] ?>"
      >
        Edit
      </button>
      <button name="delete_btn" data-fto_id="<?= $ft_object['fto_id']; ?>"
              type="button" class="btn btn-sm btn-danger delete_btn">Delete
      </button>
      <script type="text/javascript">

      </script>
    </td>
  </tr>
<?php endforeach; ?>

<script>

  $('.delete_btn').click(function (e) {

    if (confirm('Are you sure you want to delete ?')) {
      let fto_id = $(this).data('fto_id');

      $.ajax({
        url: "<?php echo $base_url;?>ajax/delete_ft_object.php",
        method: "post",
        data: {fto_id: fto_id},
        dataType: "html",
        success: function () {
          $('#row'+fto_id).fadeOut(2000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr.status);
          console.log(thrownError);
        }
      });

    }
  });

  $('.edit-fto-btn').click((e) => {

    $('#editFurnitureObjectModalLabel').text('Edit Furniture Object: ' + e.target.dataset.ftoName);
    $('#edit_fto_name_input').val(e.target.dataset.ftoName);
    $('#edit_fto_description_input').val(e.target.dataset.ftoDescription);
    $('#edit_fto_price_input').val(e.target.dataset.ftoPrice);
    $('#edit_fto_category_input').val(e.target.dataset.ftoCategory).change();
    $('#edit_fto_producer_input').val(e.target.dataset.ftoProducer);
    $('#edit_fto_trader_input').val(e.target.dataset.ftoTrader);
    $('#edit_link_to_trader_input').val(e.target.dataset.ftto_page);
    $('#edit_f_source_input').val(e.target.dataset.f_source);
    $('#edit_fs_date_input').val(e.target.dataset.fs_date);
    $('#edit_fs_price_input').val(e.target.dataset.fs_price);
    $('#edit_fs_remarks_input').val(e.target.dataset.fs_remarks);
    $('#edit_fs_price_input').val(e.target.dataset.fs_price);
    $('#model_thumbnail_file').attr("src","https://cseven.eu/studio/"+e.target.dataset.fs_thumbnail);
    $('#edit_owner_input').val(e.target.dataset.owner);
    $('#edit_creator_input').val(e.target.dataset.creator);
    $('#edit_fto_id').val(e.target.dataset.ftoId);

  });
</script>

