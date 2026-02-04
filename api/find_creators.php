<?php

$prod_types = [5, 6, 7, 8];

foreach ($prod_types as $type) {

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
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_3d_configurator'] . ')' . $creator_desc;
        //Exterior
        array_push($CREATORS[$company]['p1' . $type . '6x'], $creator);
    }

    if ($creator['qualification']['b' . $type . '_2d_konfig_renders']) {
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_2d_konfig_renders'] . ')' . $creator_desc;
        //Exterior
        array_push($CREATORS[$company]['p1' . $type . '6y'], $creator);
    }

    if ($creator['qualification']['b' . $type . '_render_stills']) {
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_render_stills'] . ')' . $creator_desc;
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
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_render_360'] . ')' . $creator_desc;
        //Exterior
        array_push($CREATORS[$company]['p1' . $type . '66'], $creator);

        //Interior
        array_push($CREATORS[$company]['p1' . $type . '06'], $creator);
        array_push($CREATORS[$company]['p1' . $type . '26'], $creator);
        array_push($CREATORS[$company]['p1' . $type . '46'], $creator);
    }

    if ($creator['qualification']['b' . $type . '_render_slideshow']) {
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_render_slideshow'] . ')' . $creator_desc;
        //Exterior
        array_push($CREATORS[$company]['p1' . $type . '67'], $creator);

        //Interior
        array_push($CREATORS[$company]['p1' . $type . '07'], $creator);
        array_push($CREATORS[$company]['p1' . $type . '27'], $creator);
        array_push($CREATORS[$company]['p1' . $type . '47'], $creator);
    }

    if ($creator['qualification']['b' . $type . '_render_movie']) {
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_render_movie'] . ')' . $creator_desc;
        //Exterior
        array_push($CREATORS[$company]['p1' . $type . '68'], $creator);

        //Interior
        array_push($CREATORS[$company]['p1' . $type . '08'], $creator);
        array_push($CREATORS[$company]['p1' . $type . '28'], $creator);
        array_push($CREATORS[$company]['p1' . $type . '48'], $creator);
    }

    if ($creator['qualification']['b' . $type . '_environment']) {
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_environment'] . ')' . $creator_desc;
        //Exterior
        array_push($CREATORS[$company]['p1' . $type . '81'], $creator);
    }

    if ($creator['qualification']['b' . $type . '_environment']) {
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_environment'] . ')' . $creator_desc;
        //Exterior
        array_push($CREATORS[$company]['p1' . $type . '81'], $creator);
    }

    if ($creator['qualification']['b' . $type . '_furniture']) {
        $creator['text'] = $creator_name . ' ' . $creator['c_last_name'] . ' (' . $creator['qualification']['b' . $type . '_environment'] . ')' . $creator_desc;
        //Interior
        array_push($CREATORS[$company]['p1' . $type . '21'], $creator);
        array_push($CREATORS[$company]['p1' . $type . '41'], $creator);
    }
}