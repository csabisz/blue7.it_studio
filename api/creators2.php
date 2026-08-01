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



if (!empty($u_prod_id)) 
{
    function filter_useless_qualifications($qualifications)
    {
        foreach ($qualifications as $key => $value) {

            if ($value == 0) unset($qualifications[$key]);

        }

        if (!empty($qualifications)) return $qualifications; else return null;

    }


    $all_creators = $prod->show_creators($lt_id);

    $all_other_creators = $prod->show_creators_other_companies($lt_id);
    ?>
    <option style="font-weight: bold; background-color: grey; color: white;">-- Choose creator --</option>
    <?php
    for($c=0;$c<count($all_creators);$c++)
    {
        $client_rights = $prod->get_client_rights($all_creators[$c]['client_ID']);
        if($client_rights['u_status']=="active")
        {
            $all_creators[$c]['qualification'] = filter_useless_qualifications($prod->get_client_qualifications($all_creators[$c]['client_ID']));

            $type = $prod_id['2'];

            if((substr($prod_id, -2) == "01"))
            {
                if ($all_creators[$c]['qualification']['b' . $type . '_walls']>0 || $all_creators[$c]['qualification']['b' . $type . '_windows_doors']>0) 
                {

                    $qualification_text = ' (' . $all_creators[$c]['qualification']['b' . $type . '_walls'] . ')(' . $all_creators[$c]['qualification']['b' . $type . '_windows_doors'] . ')';               
                    $qualification_check = 1;
                }
            }

            if((substr($prod_id, -2) == "21")||(substr($prod_id, -2) == "41"))
            {
                if ($all_creators[$c]['qualification']['b' . $type . '_furniture']>0) 
                {

                    $qualification_text = ' (' . $all_creators[$c]['qualification']['b' . $type . '_furniture'] . ')';
                    $qualification_check = 1;
                }

                
            }

            if((substr($prod_id, -3) == "302")||(substr($prod_id, -3) == "322"))
            {                   

                    $qualification_text = ' (1)';    
                    $qualification_check = 1;
            }

            if($qualification_check == 1)
            {
                ?>
                <option value="<?php echo $all_creators[$c]['client_ID'];?>"><?php  
                $creator_name = $all_creators[$c]['c_first_name'];
                if(!empty($all_creators[$c]['c_middle_name'])) $creator_name .= ' ' . $all_creators[$c]['c_middle_name'];
                $creator_name .= ' ' . $all_creators[$c]['c_last_name'];

                echo $creator_name;

                $company_name = $prod->get_company($all_creators[$c]['lt_id']);
                echo " - ".$company_name['mailnick'];

                
                /*
                if ($all_creators[$c]['qualification']['b1_pictures']) 
                {

                    echo  ' (' . $all_creators[$c]['qualification']['b1_pictures'] . ')';
                    
                }
        
                if ($all_creators[$c]['qualification']['b1_360']) 
                {

                    echo ' (' . $all_creators[$c]['qualification']['b1_360'] . ')'. $creator_desc;
                    
                }
        
                if ($all_creators[$c]['qualification']['b1_videos']) 
                {

                    echo ' (' . $all_creators[$c]['qualification']['b1_videos'] . ')';
                
                }
        
                if ($all_creators[$c]['qualification']['b1_base_picture']) 
                {

                    echo ' (' . $all_creators[$c]['qualification']['b1_base_picture'] . ')';
                
                }
        
                if ($all_creators[$c]['qualification']['b1_masks']) 
                {

                    echo ' (' . $all_creators[$c]['qualification']['b1_masks'] . ')';
                    
                }
        
                if ($all_creators[$c]['qualification']['b1_targets']) 
                {

                    echo ' (' . $all_creators[$c]['qualification']['b1_targets'] . ')';
                
                }
        
                if ($all_creators[$c]['qualification']['b1_suntour_model']) 
                {

                    echo ' (' . $all_creators[$c]['qualification']['b1_suntour_model'] . ')';
                    
                }
        
                if ($all_creators[$c]['qualification']['b1_vr']) 
                {

                    echo ' (' . $all_creators[$c]['qualification']['b1_vr'] . ')';
                    
                }*/
                /**

                    * B3 Interior

                    */ /*


                
                if ($all_creators[$c]['qualification']['b3_walls'] || $all_creators[$c]['qualification']['b3_windows_doors']) {

                    echo ' (' . $all_creators[$c]['qualification']['b3_walls'] . ')(' . $all_creators[$c]['qualification']['b3_windows_doors'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b3_furniture']) {

                    echo ' (' . $all_creators[$c]['qualification']['b3_furniture'] . ')' ;                

                }*/
        
        
        
        
        
                /**

                    * Prod Types B5, B6, B7, B8 and so on if new appear wit same products

                    */

                

                

                
    /*


                


                if ($all_creators[$c]['qualification']['b' . $type . '_in_2d_configurator']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_2d_configurator'] . ')' ;    
                    

                }


                if ($all_creators[$c]['qualification']['b' . $type . '_in_2d_konfig_renders']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_2d_konfig_renders'] . ')' ;    
                    

                }

                if ($all_creators[$c]['qualification']['b' . $type . '_2d_configurator']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_2d_configurator'] . ')' ;

                    

                }

                if ($all_creators[$c]['qualification']['b' . $type . '_premium_pictures']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_premium_pictures'] . ')' ;

                    

                }

                if ($all_creators[$c]['qualification']['b' . $type . '_3d_configurator']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_3d_configurator'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b' . $type . '_2d_konfig_renders']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_2d_konfig_renders'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b' . $type . '_render_stills']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_render_stills'] . ')' ;                 


                }



                if ($all_creators[$c]['qualification']['b' . $type . '_render_360']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_render_360'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b' . $type . '_render_slideshow']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_render_slideshow'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b' . $type . '_render_movie']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_render_movie'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b' . $type . '_environment']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_environment'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b' . $type . '_furniture']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_furniture'] . ')' ;

                    

                }



                if ($all_creators[$c]['qualification']['b' . $type . '_walls']) {

                    echo ' (' . $all_creators[$c]['qualification']['b' . $type . '_walls'] . ')' ;

                    

                } */

                ?></option>
                <?php
            }
        }
    }
    ?>
    <option disabled="" style="font-weight: bold; background-color: grey; color: white;">Other Companies</option>
    <?php
    for($c=0;$c<count($all_other_creators);$c++)
    {
        $client_rights = $prod->get_client_rights($all_other_creators[$c]['client_ID']);
        if($client_rights['u_status']=="active")
        {
            $qualification_check=0;
            $all_other_creators[$c]['qualification'] = filter_useless_qualifications($prod->get_client_qualifications($all_other_creators[$c]['client_ID']));

            $type = $prod_id['2'];

            if((substr($prod_id, -2) == "01"))
            {
                if ($all_other_creators[$c]['qualification']['b' . $type . '_walls']>0 || $all_other_creators[$c]['qualification']['b' . $type . '_windows_doors']>0) 
                {

                    $qualification_text = ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_walls'] . ')(' . $all_other_creators[$c]['qualification']['b' . $type . '_windows_doors'] . ')';               
                    $qualification_check = 1;
                }
            }

            if((substr($prod_id, -2) == "21")||(substr($prod_id, -2) == "41"))
            {
                if ($all_other_creators[$c]['qualification']['b' . $type . '_furniture']>0) 
                {

                    $qualification_text = ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_furniture'] . ')';
                    $qualification_check = 1;
                }

                
            }

            if((substr($prod_id, -3) == "302")||(substr($prod_id, -3) == "322"))
            {                   

                    $qualification_text = ' (1)';    
                    $qualification_check = 1;
            }

            if((substr($prod_id, -2) == "02")||(substr($prod_id, -2) == "03")||(substr($prod_id, -2) == "04")||(substr($prod_id, -2) == "05")||
                (substr($prod_id, -2) == "22")||(substr($prod_id, -2) == "23")||(substr($prod_id, -2) == "24")||(substr($prod_id, -2) == "25")||
                (substr($prod_id, -2) == "42")||(substr($prod_id, -2) == "43")||(substr($prod_id, -2) == "44")||(substr($prod_id, -2) == "45")
                )
            {
                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_stills']>0) 
                {

                    $qualification_text = ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_stills'] . ')';
                    $qualification_check = 1;
                }                
            }

            if((substr($prod_id, -2) == "06")||(substr($prod_id, -2) == "26")||(substr($prod_id, -2) == "46"))
            {
                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_360']>0) 
                {

                    $qualification_text = ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_360'] . ')';
                    $qualification_check = 1;
                }                
            }

            if((substr($prod_id, -2) == "07")||(substr($prod_id, -2) == "27")||(substr($prod_id, -2) == "47"))
            {
                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_slideshow']>0) 
                {

                    $qualification_text = ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_slideshow'] . ')';
                    $qualification_check = 1;
                }                
            }

            if((substr($prod_id, -2) == "08")||(substr($prod_id, -2) == "28")||(substr($prod_id, -2) == "48"))
            {
                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_movie']>0) 
                {

                    $qualification_text = ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_movie'] . ')';
                    $qualification_check = 1;
                }                
            }

            if($qualification_check == 1)
            {
                ?>
                <option value="<?php echo $all_other_creators[$c]['client_ID'];?>"><?php  
                $creator_name = $all_other_creators[$c]['c_first_name'];
                if(!empty($all_other_creators[$c]['c_middle_name'])) $creator_name .= ' ' . $all_other_creators[$c]['c_middle_name'];
                $creator_name .= ' ' . $all_other_creators[$c]['c_last_name'];

                echo $creator_name;

                $company_name = $prod->get_company($all_other_creators[$c]['lt_id']);
                echo " - ".$company_name['mailnick'];

                echo $qualification_text;
                /*
                if ($all_other_creators[$c]['qualification']['b1_floorplans']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_floorplans'] . ')';
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_pictures']) 
                {

                    echo  ' (' . $all_other_creators[$c]['qualification']['b1_pictures'] . ')';
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_360']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_360'] . ')'. $creator_desc;
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_videos']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_videos'] . ')';
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_base_picture']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_base_picture'] . ')';
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_masks']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_masks'] . ')';
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_targets']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_targets'] . ')';
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_suntour_model']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_suntour_model'] . ')';
                    
                }
        
                if ($all_other_creators[$c]['qualification']['b1_vr']) 
                {

                    echo ' (' . $all_other_creators[$c]['qualification']['b1_vr'] . ')';
                    
                }
                /**

                    * B3 Interior

                    


                
                if ($all_other_creators[$c]['qualification']['b3_walls'] || $all_other_creators[$c]['qualification']['b3_windows_doors']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b3_walls'] . ')(' . $all_other_creators[$c]['qualification']['b3_windows_doors'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b3_furniture']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b3_furniture'] . ')' ;                

                }
        
        
        
        
        
                /**

                    * Prod Types B5, B6, B7, B8 and so on if new appear wit same products

                    

                

                $type = $prod_id['2'];

                



                if ($all_other_creators[$c]['qualification']['b' . $type . '_walls'] || $all_other_creators[$c]['qualification']['b' . $type . '_windows_doors']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_walls'] . ')(' . $all_other_creators[$c]['qualification']['b' . $type . '_windows_doors'] . ')';

                    

                }


                if ($all_other_creators[$c]['qualification']['b' . $type . '_in_2d_configurator']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_2d_configurator'] . ')' ;    
                    

                }


                if ($all_other_creators[$c]['qualification']['b' . $type . '_in_2d_konfig_renders']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_2d_konfig_renders'] . ')' ;    
                    

                }

                if ($all_other_creators[$c]['qualification']['b' . $type . '_2d_configurator']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_2d_configurator'] . ')' ;

                    

                }

                if ($all_other_creators[$c]['qualification']['b' . $type . '_premium_pictures']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_premium_pictures'] . ')' ;

                    

                }

                if ($all_other_creators[$c]['qualification']['b' . $type . '_3d_configurator']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_3d_configurator'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_2d_konfig_renders']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_2d_konfig_renders'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_stills']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_stills'] . ')' ;                 


                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_360']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_360'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_slideshow']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_slideshow'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_render_movie']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_render_movie'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_environment']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_environment'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_furniture']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_furniture'] . ')' ;

                    

                }



                if ($all_other_creators[$c]['qualification']['b' . $type . '_walls']) {

                    echo ' (' . $all_other_creators[$c]['qualification']['b' . $type . '_walls'] . ')' ;

                    

                } */
                ?></option>
                <?php
            }
        }
    }
}
    /*
    function filter_useless_qualifications($qualifications)

    {



        foreach ($qualifications as $key => $value) {

            if ($value == 0) unset($qualifications[$key]);

        }



        if (count($qualifications) > 1) return $qualifications; else return null;



    }





    $all_creators = $prod->show_creators_names($u_prod_id);

    $all_other_creators = $prod->show_creators_other_companies_names($u_prod_id);
*/
    
    
//Assign qualification to creators
/*
    for ($i = 0; $i < count($all_creators); $i++) 
    {

        $all_creators[$i]['qualification'] = array();

        $all_creators[$i]['qualification'] = filter_useless_qualifications($prod->get_client_qualifications($all_creators[$i]['client_ID']));

        
        

        $working_hours = json_decode(file_get_contents('https://cseven.eu/studio/api/creator.php?uca_id=' . $all_creators[$i]['client_ID'] . '&timezone='.$timezone), true);

        
        $all_creators[$i]['shifts'] = $working_hours['shifts'];



    }*/


/*
    for ($j = 0; $j < count($all_other_creators); $j++) 
    {

        $all_other_creators[$j]['qualification'] = array();

        

        if(!empty($all_other_creators[$j]['client_ID']))
        {
            $all_other_creators[$j]['qualification'] = filter_useless_qualifications($prod->get_client_qualifications($all_other_creators[$j]['client_ID']));
            //$working_hours = json_decode(file_get_contents('https://cseven.eu/studio/api/creator.php?uca_id=' . $all_other_creators[$j]['client_ID'] . '&timezone='.$timezone), true);
        }

        if(empty($working_hours))
        {
            $all_other_creators[$j]['shifts'] = array();
        }
        else
        {
            $all_other_creators[$j]['shifts'] = $working_hours['shifts'];
        }
        

    }*/


    
    

    // $CREATORS['debug'] = $u_prod_id;

    // $CREATORS['main_company'] = $all_creators;

    // $CREATORS['other_companies'] = $all_other_creators;





    // $all_products = $prod->get_all_products();
    

    // $companies = ['main_company', 'other_companies'];



    // foreach ($all_products as $product) {

    //     foreach ($companies as $company) {



    //         $CREATORS[$company][$product['prod_id']] = array();

    //     }

    // }



   // $order_data = ['o_id'=>$o_id,'osub_id'=>$osub_id, 'prod_id'=>$prod_id];

//    print '<pre>';

//    print_r($order_data);

//    print '</pre>';
/*
    $selected_creator = $prod->get_order_product(json_encode($order_data))['uca_id'];

   

    $CREATORS['selected'] = $selected_creator;



    foreach ($companies as $company) 
    {



        if ($company == 'main_company') $creators = $all_creators;

        if ($company == 'other_companies') $creators = $all_other_creators;

        

        for ($i = 0; $i < count($creators); $i++) 
        {



            $creator = $creators[$i];



            $creator_name = $creator['c_first_name'];
            if(!empty($creator['c_middle_name'])) $creator_name .= ' ' . $creator['c_middle_name'];
            $creator_name .= ' ' . $creator['c_last_name'];

            array_push($CREATORS[$company], $creator);
            $creator_desc = '';



            if ($company == 'other_companies') {

                $creator_desc .= ' - ' . $prod->get_licence_mailnick($creator['lt_id'])['mailnick'] . ' - ';

            }


            // if($creator['shifts']['today']['left']!="No shift")
            // {
            //     $creator_desc .= ' Left: ' . $creator['shifts']['today']['left'];
            // }
            // $creator_desc .= ' - Next: ' . $creator['shifts']['next']['start'].' - End: ' . $creator['shifts']['next']['end'];


            //B1 in ex
            /*
            if ($creator['qualification']['b1_floorplans']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_floorplans'] . ')'. $creator_desc;
                array_push($CREATORS[$company]['p1103'], $creator);

                // array_push($CREATORS[$company]['p1163'], $creator);
            }

            if ($creator['qualification']['b1_pictures']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_pictures'] . ')'. $creator_desc;
                array_push($CREATORS[$company]['p1104'], $creator);
                array_push($CREATORS[$company]['p1163'], $creator);
                array_push($CREATORS[$company]['p11g3'], $creator);
            }

            if ($creator['qualification']['b1_360']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_360'] . ')'. $creator_desc;
                array_push($CREATORS[$company]['p1106'], $creator);
                array_push($CREATORS[$company]['p1166'], $creator);
                array_push($CREATORS[$company]['p11g6'], $creator);
            }

            if ($creator['qualification']['b1_videos']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_videos'] . ')'. $creator_desc;
                array_push($CREATORS[$company]['p1108'], $creator);
                array_push($CREATORS[$company]['p1168'], $creator);
                array_push($CREATORS[$company]['p11g8'], $creator);
            }

            if ($creator['qualification']['b1_base_picture']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_base_picture'] . ')'. $creator_desc;
                //array_push($CREATORS[$company]['p1108'], $creator);
                array_push($CREATORS[$company]['p11gb'], $creator);
                array_push($CREATORS[$company]['p116b'], $creator);
            }

            if ($creator['qualification']['b1_masks']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_masks'] . ')'. $creator_desc;
                //array_push($CREATORS[$company]['p1108'], $creator);
                array_push($CREATORS[$company]['p11gm'], $creator);
                array_push($CREATORS[$company]['p116m'], $creator);
            }

            if ($creator['qualification']['b1_targets']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_targets'] . ')'. $creator_desc;
                //array_push($CREATORS[$company]['p1108'], $creator);
                array_push($CREATORS[$company]['p11gt'], $creator);
                array_push($CREATORS[$company]['p116t'], $creator);
            }

            if ($creator['qualification']['b1_suntour_model']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_suntour_model'] . ')'. $creator_desc;
                //array_push($CREATORS[$company]['p1108'], $creator);
                array_push($CREATORS[$company]['p11gs'], $creator);
                array_push($CREATORS[$company]['p118s'], $creator);
                array_push($CREATORS[$company]['p168s'], $creator);
            }

            if ($creator['qualification']['b1_vr']) 
            {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b1_vr'] . ')'. $creator_desc;
                //array_push($CREATORS[$company]['p1108'], $creator);

                array_push($CREATORS[$company]['p110v'], $creator);
                array_push($CREATORS[$company]['p116v'], $creator);
            }
            /**

             * B3 Interior

             */


            /*
            if ($creator['qualification']['b3_walls'] || $creator['qualification']['b3_windows_doors']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b3_walls'] . ')(' . $creator['qualification']['b3_windows_doors'] . ')' . $creator_desc;

               //                array_push($CREATORS[$company]['p1301'], $creator);

            }



            if ($creator['qualification']['b3_furniture']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b3_furniture'] . ')' . $creator_desc;

                    //                array_push($CREATORS[$company]['p1321'], $creator);

                array_push($CREATORS[$company]['p1302'], $creator);

                array_push($CREATORS[$company]['p1322'], $creator);

            }*/





            /**

             * Prod Types B5, B6, B7, B8 and so on if new appear wit same products

             */

            /*

            $type = $prod_id['2'];

            $CREATORS['debug'] = $type;



            if ($creator['qualification']['b' . $type . '_walls'] || $creator['qualification']['b' . $type . '_windows_doors']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b' . $type . '_walls'] . ')(' . $creator['qualification']['b' . $type . '_windows_doors'] . ')' . $creator_desc;

                //Exterior
                array_push($CREATORS[$company]['p1' . $type . '60'], $creator);
                array_push($CREATORS[$company]['p1' . $type . '61'], $creator);



                //Interior

                array_push($CREATORS[$company]['p1' . $type . '01'], $creator);

            }


            if ($creator['qualification']['b' . $type . '_in_2d_configurator']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b' . $type . '_2d_configurator'] . ')' . $creator_desc;

                //Interior

                array_push($CREATORS[$company]['p1' . $type . '0z'], $creator);
                array_push($CREATORS[$company]['p1' . $type . '2z'], $creator);
                array_push($CREATORS[$company]['p1' . $type . '4z'], $creator);

            }


            if ($creator['qualification']['b' . $type . '_in_2d_konfig_renders']) {

                $creator['text'] = $creator_name . ' ' . ' (' . $creator['qualification']['b' . $type . '_2d_konfig_renders'] . ')' . $creator_desc;

                //Interior

                array_push($CREATORS[$company]['p1' . $type . '0y'], $creator);
                array_push($CREATORS[$company]['p1' . $type . '2y'], $creator);
                array_push($CREATORS[$company]['p1' . $type . '4y'], $creator);

            }

            if ($creator['qualification']['b' . $type . '_2d_configurator']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b' . $type . '_2d_configurator'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '6z'], $creator);

            }

            if ($creator['qualification']['b' . $type . '_premium_pictures']) {

                $creator['text'] = $creator_name . ' (' . $creator['qualification']['b' . $type . '_premium_pictures'] . ')' . $creator_desc;

                //Exterior

                array_push($CREATORS[$company]['p1' . $type . '6p'], $creator);

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

            } *//*

        }



    }*/

    //print_r($CREATORS);

    // if (!empty($prod_id)) 
    // {



    //     foreach ($companies as $company) {



    //         $CREATORS[$company] = $CREATORS[$company][$prod_id];





    //     }

    // }

//     echo json_encode($CREATORS);

// } 
// else 
// {

//     $CREATORS['error']['message'] = 'Set `u_prod_id`';
//     echo json_encode($CREATORS);
// }





//header('Content-type:application/json');



