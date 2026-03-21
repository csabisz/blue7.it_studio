<?php

include("../functions.php");

$prod = new Production;



//For tomorrow

//Get company name

//get_licence_mailnick



$u_prod_id = $_GET['u_prod_id'];

$o_id = $_GET['o_id'];

$osub_id = $_GET['osub_id'];

$prod_id = $_GET['prod_id'];

$timezone = $_GET['timezone'];



if (!empty($u_prod_id)) {



    function filter_useless_qualifications($qualifications)

    {



        foreach ($qualifications as $key => $value) {

            if ($value == 0) unset($qualifications[$key]);

        }



        if (count($qualifications) > 1) return $qualifications; else return null;

//    return $qualifications;

    }





    $all_creators = $prod->show_creators_names($u_prod_id);

    $all_other_creators = $prod->show_creators_other_companies_names($u_prod_id);



//Assign qualification to creators

    for ($i = 0; $i < count($all_creators); $i++) {

        $all_creators[$i]['qualification'] = array();

        $all_creators[$i]['qualification'] = filter_useless_qualifications($prod->get_client_qualifications($all_creators[$i]['client_ID']));



        $working_hours = json_decode(file_get_contents('https://cseven.eu/studio/api/creator.php?uca_id=' . $all_creators[$i]['client_ID'] . '&timezone='.$timezone), true);

        $all_creators[$i]['shifts'] = $working_hours['shifts'];

//    if ($all_creators[$i]['qualification'] == null) unset($all_creators[$i]);

    }



    for ($j = 0; $j < count($all_other_creators); $j++) {

        $all_other_creators[$j]['qualification'] = array();

        $all_other_creators[$j]['qualification'] = filter_useless_qualifications($prod->get_client_qualifications($all_other_creators[$j]['client_ID']));

        $working_hours = json_decode(file_get_contents('https://cseven.eu/studio/api/creator.php?uca_id=' . $all_creators[$j]['client_ID'] . '&timezone='.$timezone), true);

        $all_other_creators[$j]['shifts'] = $working_hours['shifts'];



        //    if ($all_other_creators[$j]['qualification'] == null) unset($all_other_creators[$j]);

    }





    $CREATORS['debug'] = $u_prod_id;

//    $CREATORS['main_company'] = $all_creators;

//    $CREATORS['other_companies'] = $all_other_creators;





    $all_products = $prod->get_all_products();

    $companies = ['main_company', 'other_companies'];



    foreach ($all_products as $product) {

        foreach ($companies as $company) {



            $CREATORS[$company][$product['prod_id']] = array();

        }

    }



    $order_data = ['o_id'=>$o_id,'osub_id'=>$osub_id, 'prod_id'=>$prod_id];

//    print '<pre>';

//    print_r($order_data);

//    print '</pre>';

    $selected_creator = $prod->get_order_product(json_encode($order_data))['uca_id'];



    $CREATORS['selected'] = $selected_creator;



    foreach ($companies as $company) {



        if ($company == 'main_company') $creators = $all_creators;

        if ($company == 'other_companies') $creators = $all_other_creators;



        for ($i = 0; $i < count($creators); $i++) {



            $creator = $creators[$i];



            $creator_name = $creator['c_first_name'] . ' ' . $creator['c_last_name'];

            $creator_desc = '';



            if ($company == 'other_companies') {

                $creator_desc .= ' - ' . $prod->get_licence_mailnick($creator['lt_id'])['mailnick'] . ' - ';

            }



            $creator_desc .= ' Left: ' . $creator['shifts']['today']['left'];

            $creator_desc .= ' - Next: ' . $creator['shifts']['next']['start'].' - End: ' . $creator['shifts']['next']['end'];





            /**

             * B3 Interior

             */



            if ($creator['qualification']['b3_walls'] || $creator['qualification']['b3_windows_doors']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b3_walls'] . ')(' . $creator['qualification']['b3_windows_doors'] . ')' . $creator_desc;

//                array_push($CREATORS[$company]['p1301'], $creator);

            }



            if ($creator['qualification']['b3_furniture']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b3_furniture'] . ')' . $creator_desc;

//                array_push($CREATORS[$company]['p1321'], $creator);

                array_push($CREATORS[$company]['p1302'], $creator);

                array_push($CREATORS[$company]['p1322'], $creator);

            }





            /**

             * Prod Types B5, B6, B7, B8 and so on if new appear wit same products

             */



            $type = $prod_id['2'];

            $CREATORS['debug'] = $type;



            if ($creator['qualification']['b' . $type . '_walls'] || $creator['qualification']['b' . $type . '_windows_doors']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b' . $type . '_walls'] . ')(' . $creator['qualification']['b' . $type . '_windows_doors'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '61'], $creator);



                //Interior

                array_push($CREATORS[$company]['p1' . $type . '01'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_2d_configurator']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b' . $type . '_2d_configurator'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '6z'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_3d_configurator']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_3d_configurator'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '6x'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_2d_konfig_renders']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_2d_konfig_renders'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '6y'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_render_stills']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_render_stills'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '62'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '63'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '82'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '83'], $creator);



                //Interior

                array_push($CREATORS[$company]['p1' . $type . '02'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '03'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '04'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '05'], $creator);



                array_push($CREATORS[$company]['p1' . $type . '22'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '23'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '24'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '25'], $creator);



                array_push($CREATORS[$company]['p1' . $type . '42'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '43'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '44'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '45'], $creator);





            }



            if ($creator['qualification']['b' . $type . '_render_360']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_render_360'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '66'], $creator);



                //Interior

                array_push($CREATORS[$company]['p1' . $type . '06'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '26'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '46'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_render_slideshow']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_render_slideshow'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '67'], $creator);



                //Interior

                array_push($CREATORS[$company]['p1' . $type . '07'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '27'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '47'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_render_movie']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_render_movie'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '68'], $creator);



                //Interior

                array_push($CREATORS[$company]['p1' . $type . '08'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '28'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '48'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_environment']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_environment'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '81'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_furniture']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_furniture'] . ')' . $creator_desc;

                //Interior

                array_push($CREATORS[$company]['p1' . $type . '21'], $creator);

                array_push($CREATORS[$company]['p1' . $type . '41'], $creator);

            }



            if ($creator['qualification']['b' . $type . '_walls']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_walls'] . ')' . $creator_desc;

                //Interior

                array_push($CREATORS[$company]['p1' . $type . '00'], $creator);

            }

        }



    }



    if (!empty($prod_id)) {



        foreach ($companies as $company) {

//            for ($i=0; $i<count($CREATORS[$company][$prod_id]); $i++){

//                unset($CREATORS[$company][$prod_id][$i]['qualification']);

//            }

            $CREATORS[$company] = $CREATORS[$company][$prod_id];





        }

    }



} else {

    $CREATORS['error']['message'] = 'Set `u_prod_id`';

}





header('Content-type:application/json');



echo json_encode($CREATORS);