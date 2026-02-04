<?php
include("../functions.php");

$prod = new Production;


$plansets = $prod->get_all_plansets2();
$owners = $prod->get_owner();

$planset_data = [];

foreach ($plansets as $planset) {
    $pdf_count = 0;
    $cad_count = 0;
    foreach ($owners as $owner) {
        if ($planset['pls_owner'] == $owner['client_ID']) {
            $plansets_files = $prod->get_pls_files_by_pls_id($planset['pls_id']);
            foreach ($plansets_files as $file){
                if ($file['filetype'] == 'pdf'){
                    $pdf_count++;
                }
                if ($file['filetype'] == 'cad'){
                    $cad_count++;
                }
            }
            $planset_data[] = [
                'pls_id' => $planset['pls_id'],
                'pls_name' => $planset['pls_name'],
                'pls_description' => $planset['pls_description'],
                'pls_presentation_id' => $planset['pls_presentation_id'],
                'pls_price' => $planset['pls_price'],
                'pls_pdf_count' => $pdf_count,
                'pls_cad_count' => $cad_count,
                'pls_dimensions' => [
                    'pls_length' => $planset['pls_length'],
                    'pls_width' => $planset['pls_width'],
                    'pls_height' => $planset['pls_height'],
                    'pls_surface' => $planset['pls_surface'],
                ],
                'pls_owner' => [
                    'owner_id' => $planset['pls_owner_id'],
                    'owner_first_name' => $owner['c_first_name'],
                    'owner_middle_name' => $owner['c_middle_name'],
                    'owner_last_name' => $owner['c_last_name'],
                ],

            ];
        }
    }
}


$search_type = $_POST['type'];
$filterBy = $_POST['key'];


if ($filterBy != '') {
    switch ($search_type) {
        case 'pls_id':
            $planset_data = array_filter($planset_data, function ($var) use ($filterBy, $search_type) {
                $checking = strpos(strtolower($var[$search_type]), strtolower($filterBy));
                if ($checking === 0){
                    return true;
                }elseif ($checking > 0){
                    return true;
                }else{
                    return $checking;
                }
            });
            usort($planset_data, function ($a, $b) {
                return $a['pls_id'] - $b['pls_id'];
            });
            break;

        case 'pls_name':
            $planset_data = array_filter($planset_data, function ($var) use ($filterBy, $search_type) {
                $checking = strpos(strtolower($var[$search_type]), strtolower($filterBy));
                if ($checking === 0){
                    return true;
                }elseif ($checking > 0){
                    return true;
                }else{
                    return $checking;
                }
            });
            usort($planset_data, function ($a, $b) {
                return strcmp($a['pls_name'], $b['pls_name']);
            });
            break;

        case 'owner_first_name':
            $planset_data = array_filter($planset_data, function ($var) use ($filterBy, $search_type) {
                $checking = strpos(strtolower($var['pls_owner'][$search_type]), strtolower($filterBy));
                if ($checking === 0){
                    return true;
                }elseif ($checking > 0){
                    return true;
                }else{
                    return $checking;
                }
            });
            usort($planset_data, function ($a, $b) {
                return strcmp($a['pls_owner']['owner_first_name'], $b['pls_owner']['owner_first_name']);
            });
            break;

        case 'pls_surface':
            $planset_data = array_filter($planset_data, function ($var) use ($filterBy, $search_type) {
                $checking = strpos(strtolower($var['pls_dimensions'][$search_type]), strtolower($filterBy));
                if ($checking === 0){
                    return true;
                }elseif ($checking > 0){
                    return true;
                }else{
                    return $checking;
                }
            });

            usort($planset_data, function ($a, $b) {
                return $a['pls_dimensions']['pls_surface'] - $b['pls_dimensions']['pls_surface'];
            });
            break;

        case 'pls_price':
            $planset_data = array_filter($planset_data, function ($var) use ($filterBy, $search_type) {
                $checking = strpos(strtolower($var[$search_type]), strtolower($filterBy));
                if ($checking === 0){
                    return true;
                }elseif ($checking > 0){
                    return true;
                }else{
                    return $checking;
                }
            });
            usort($planset_data, function ($a, $b) {
                return $a['pls_price'] - $b['pls_price'];
            });
            break;
    }
}
?>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>ID</th>
            <th>Owner Name</th>
            <th>Planset Name</th>
            <th>Dimensions(l/w/h)</th>
            <th>Surface</th>
            <th>CADs</th>
            <th>PDFs</th>
            <th>Price</th>
            <th>Presentation</th>
            <th class="text-right">Action</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($planset_data as $planset) { ?>

            <tr>
                <td><?php echo $planset['pls_id'] ?></td>
                <td><?php echo $planset['pls_owner']['owner_first_name'] . ' ' . $planset['pls_owner']['owner_middle_name'] . ' ' . $planset['pls_owner']['owner_last_name']; ?></td>
                <td><?php echo $planset['pls_name'] ?></td>
                <td><?php echo $planset['pls_dimensions']['pls_length'] . '/' . $planset['pls_dimensions']['pls_width'] . '/' . $planset['pls_dimensions']['pls_height']; ?></td>
                <td><?php echo $planset['pls_dimensions']['pls_surface'] ?></td>
                <td><?php echo $planset['pls_cad_count'] ?></td>
                <td><?php echo $planset['pls_pdf_count'] ?></td>
                <td><?php echo $planset['pls_price'] ?></td>
                <td><?php echo $planset['pls_presentation_id'] ?></td>
                <td class="text-right">
                    <button class="btn btn-primary btn-sm mr-3">Edit</button>
                    <button class="btn btn-danger btn-sm mr-3">Delete</button>
                    <a target="_blank" class="btn btn-info btn-sm mr-3"
                       href="https://blue7.it/<?php echo $planset['pls_presentation_id'] ?>">Presentation</a></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>
