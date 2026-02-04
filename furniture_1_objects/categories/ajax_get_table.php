<?php
session_start();
include('../../functions.php');

$prod = new Production;
$all_fto_categories = $prod->get_all_fto_categories();

?>

<?php foreach ($all_fto_categories as $category): ?>

  <?php $category_in_german = $prod->get_translated_ftoc($category['ftoc_id'], 49); ?>


  <tr id="row<?= $category['ftoc_id']; ?>">
    <td><?= $category['ftoc_id'] ?></td>
    <td><?= $category['text'] ?></td>
    <td><?= $category['ftoc_description'] ?></td>
    <td>
      <?= $category_in_german ?? '<span class="text-danger">Missing!</span>' ?>
    </td>
    <td class="text-right">
      <a
        href="https://domenia.blue7.it/translations/index.php?option=create&text_id=<?= 'ftoc_' . $category['ftoc_id'] ?>&lang_id=49&translation_table=x-texts"
        target="_blank"
        class="btn btn-sm mb-md-2 mb-lg-0 edit-fto-btn <?= isset($category_in_german) ? 'btn-primary' : 'btn-warning' ?> ">
        <i class="fa  fa-language"></i>
        <?= isset($category_in_german) ? 'Edit' : 'Set' ?> Translation
      </a>
    </td>
  </tr>
<?php endforeach; ?>

<script>


  if (new URLSearchParams(window.location.search).has('ftoc_id')) {
    let searchedRowID = new URLSearchParams(window.location.search).get('ftoc_id');
    $("#table-body tr").each(function () {
      if ($(this).attr('id') === 'row' + searchedRowID) {
        $(this).addClass('table-primary');

        document.querySelector('#row'+searchedRowID).scrollIntoView({
          behavior: 'smooth'
        });

        setTimeout(function () {
          $("#table-body tr").removeClass('table-primary');
        }, 3000);

      }
    });
  }

</script>



