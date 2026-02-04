<?php
//echo $_SERVER['REQUEST_URI'];

?>
<style>
    .nav-item {
        padding: 0 !important;
        border-right: 1px solid rgba(0, 0, 0, 0.25);
        margin: 0 3px 0 0;
    }

    .nav-item:last-child {
        border-right: 0;
    }

    .nav-link {
        padding: 0 3px 0 0 !important;
    }

    .dropdown-menu > .nav-item {
        border-right: 0;
    }

    .dropdown {
        margin: 0 auto 0 0;
    }
    .active_menu a{
        color: #ad00ff;
    }
    .user-name {
        font-weight: 700;
        background: linear-gradient(270deg, #f64f59, #c471ed, #12c2e9);
        background-size: 600% 600%;

        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        -webkit-animation: NameGradient 3s ease infinite;
        -moz-animation: NameGradient 3s ease infinite;
        -o-animation: NameGradient 3s ease infinite;
        animation: NameGradient 3s ease infinite;
    }

    .top_menu {
        height:73px;
        position:fixed;
        z-index:10;
    }

    .containerss 
    {
        height:75px;
        position:fixed;
        z-index:10;
    }

    .top_menu_header {
        height:75px;
        position:fixed;
        z-index:10;
    }

    .top_section {
        padding-top:100px;
    }

    @-webkit-keyframes NameGradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @-moz-keyframes NameGradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @-o-keyframes NameGradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @keyframes NameGradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @media (max-width: 766px) {
        .navbar-collapse .nav-item {
            border-right: 0;
        }

        .navbar-collapse {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    }

    #dropdown-body {
        z-index: 2000;
    }


</style>
<div class="containerss ">
    <header class="navbar navbar-expand-md navbar-light bg-light w-100 border-bottom top_menu_header">

        <nav class="navbar navbar-expand-md navbar-light bg-light float-right ml-auto w-100 top_menu">
            <div class="form-inline my-lg-0 m-1">
                <img src="<?php echo $base_url; ?>img/Blue7Logo.png" style="width:40px;" alt="logo">
            </div>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
                <div class="dropdown float-left">
                    <?php 
                    
                    if( $_COOKIE['useradmin'] > 0 || $_COOKIE['cdesign'] > 0 || $_COOKIE['coordination'] > 0 || $_COOKIE['contracting'] > 0 || $_COOKIE['bookkeeping'] > 0
                    && $_COOKIE['change_vat'] > 0 || $_COOKIE['programs_of_employees'] > 0 || $_COOKIE['activity_view'] > 0 || $_COOKIE['apu_lists'] > 0 || $_COOKIE['examples_db'] > 0){ ?>
                    <button class="btn btn-secondary dropdown-toggle bg-primary" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:250px;">
                        Additional menu
                    </button>
                    <?php } ?>
                    <ul id="dropdown-body" class="dropdown-menu p-2" aria-labelledby="dropdownMenu2" style="width:250px;">
                        <?php
                        if (isset($_COOKIE['client_id']))
                        {
                        // if($_COOKIE['own_tasks']==1)
                        // {

                        if ($_COOKIE['activity_view'] > 0) 
                        {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/activity.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>activity.php">Activity view</a></li>
                            <?php
                        }

                        if ($_COOKIE['contracting'] > 0) {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/advanced_search/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>advanced_search/index.php">Advanced
                                    search</a></li>
                            <?php
                        }

                        if ($_COOKIE['apu_lists'] > 0) {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/users/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>users/index.php?page=users">APEs:
                                    Creators/Traders</a></li>
                            <?php
                        }

                        if ($_COOKIE['bookkeeping'] > 0) {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/books/book.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>books/book.php">Books</a></li>
                            <?php
                        }

                        

                        if ($_COOKIE['change_vat'] > 0) {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/books/change_vat.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>books/change_vat.php">Change VAT</a>
                            </li>
                            <?php
                        }

                        if ($_COOKIE['useradmin'] > 0) 
                        {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/client_administration/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>client_administration/index.php">Clients</a>
                            </li>
                            
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/main_client_administration/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>main_client_administration/index.php">Clients - Main</a>
                            </li>

                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/main_client_positions/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>main_client_positions/index.php">Clients - Main Positions</a>
                            </li>
                            <?php
                        }
                        
                        if ($_COOKIE['cdesign'] > 0) {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/client_administration/client_measures.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link"
                                     href="<?php echo $base_url; ?>client_administration/client_measures.php">CMeasures</a>
                            </li>
                            <?php
                        }

                        if ($_COOKIE['coordination'] > 0) {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/coordination/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link"
                                     href="<?php echo $base_url; ?>coordination/index.php">Coordination</a></li>
                            <?php
                        }

                        if ($_COOKIE['examples_db'] > 0) {
                            ?>
                            <li class="nav-item"><a class="nav-link"
                            href="https://domenia.blue7.it/examples/index.php?client_id=<?php echo $_COOKIE['client_id']; ?>"
                            target="_blank">Examples-DB</a></li>
                            <?php
                        }
                        
                        //if ($_COOKIE['furniture_objects'] > 0) : ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo $base_url; ?>furniture_1_objects/index.php">Furniture 1 Objects</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo $base_url; ?>furniture_2_sets_4_rooms/index.php">Furniture 2 sets 4 rooms</a>
                        </li>
                        
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo $base_url; ?>furniture_3_sets_4_units/index.php">Furniture 3 sets 4 units</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo $base_url; ?>furniture_layouts/index.php">Furniture 4 layouts complete</a>
                        </li>
                        <?php //endif; 

                        if ($_COOKIE['housesets'] > 0) : ?>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?php echo $base_url; ?>housesets/index.php">House-sets</a>
                            </li>
                        <?php endif; 
                        
                        if ($_COOKIE['plansets'] > 0) : ?>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?php echo $base_url; ?>plansets/index.php">Plan-sets</a>
                            </li>
                        <?php endif; 

                        if ($_COOKIE['plots'] > 0) : ?>
                        <li class="nav-item ">
                        <a class="nav-link" href="<?php echo $base_url; ?>plots/index.php">Plots</a>
                        </li>
                        <?php endif; 

                        if ($_COOKIE['programs_of_employees'] > 0) {
                            ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/programs_of_employees/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>programs_of_employees/index.php">Programs
                                    of employees</a></li>
                            <?php

                        }

                        
                        if ($_COOKIE['activity_view'] > 0) 
                        {
                        ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/order_changes.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>order_changes.php">Task changes</a>
                            </li>
                        <?php
                        }

                        if ($_COOKIE['activity_view'] > 0) 
                        {
                        ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/tasks_list/tasks_list.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link"
                                     href="<?php echo $base_url; ?>tasks_list/tasks_list.php">Tasklist</a></li>
                        <?php
                        }

                        if ($_COOKIE['activity_view'] > 0) 
                        {
                        ?>
                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/creator_teams/index.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>creator_teams/index.php">Teams</a>
                            </li>
                            <?php
                        }
                        
                        
                        

                        if ($_COOKIE['client'] == 1) {
                            ?>

                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/myorders.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>myorders.php">My orders</a></li>

                            <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/acceptance/create_order.php") {
                                echo "active_menu";
                            } ?>"><a class="nav-link" href="<?php echo $base_url; ?>acceptance/create_order.php?<?php
                                /* if($_COOKIE['lt_id']==9)
                                 {
                                     echo "ls_id=".$licence_sites[0];
                                 }*/

                                $licences = $prod->get_licences2($_COOKIE['lt_id']);

                                //print_r($licences);

                                //preselected website
                                $websites="";
                                for ($w = 0; $w < count($licences); $w++) {
                                    if (!empty($licences[$w]['homepages_for_sale'])) {
                                        $all_websites = explode(";", $licences[$w]['homepages_for_sale']);
                                        // print_r($all_websites);
                                        for ($k = 0; $k < count($all_websites); $k++) {
                                            if (!empty($all_websites[$k])) {
                                                $websites .= $all_websites[$k] . ";";
                                            }
                                        }
                                    }
                                }

                                $all_websites2 = explode(";", $websites);

                                $all_websites = array_values(array_unique($all_websites2));

                                $website_counter = 0;

                                for ($w = 0; $w < count($all_websites); $w++) {
                                    if ((!empty($all_websites[$w])) && ($all_websites[$w] != "s099")) {
                                        $website = $prod->get_order_website($all_websites[$w]);
                                        $alphabetical_websites[$website_counter]['ls_id'] = $website['ls_id'];
                                        $alphabetical_websites[$website_counter]['ls_name'] = $website['ls_name'];
                                        $website_counter++;
                                    }
                                }

                                usort($alphabetical_websites, 'compareSiteByName');

                                //preselected language

                                $licence_languages = $prod->get_licences_by_lic_sites_id($alphabetical_websites[0]['ls_id']);

                                $all_extracted_languages="";
                                if(!empty($licence_languages))
                                {
                                for ($l = 0; $l < count($licence_languages); $l++) {
                                    $all_extracted_languages .= $licence_languages[$l]['languages_on_page'];
                                    }
                                }
                                else
                                {
                                    $all_extracted_languages = ";";
                                }
                                $extracted_languages = explode(';', $all_extracted_languages);

                                $all_languages = array_values(array_unique($extracted_languages));

                                //preselected currency

                                $licence_currencies = $prod->get_currencies_from_licences($alphabetical_websites[0]['ls_id'], $all_languages[0]);

                                $all_extracted_currencies="";

                                if(!empty($licence_currencies))
                                {
                                    for ($c = 0; $c < count($licence_currencies); $c++) {
                                        $all_extracted_currencies .= $licence_currencies[$c]['currencies'];
                                    }
                                }
                                else
                                {
                                    $all_extracted_currencies = ";";
                                }

                                $extracted_currencies = explode(';', $all_extracted_currencies);

                                $all_currencies = array_values(array_unique($extracted_currencies));

                                $currency_counter = 0;

                                for ($c = 0; $c < count($all_currencies); $c++) {
                                    if (!empty($all_currencies[$c])) {
                                        $currency2 = $prod->get_currency($all_currencies[$c]);
                                        $alphabetical_currencies[$currency_counter]['cur_id'] = $currency2['cur_id'];
                                        $alphabetical_currencies[$currency_counter]['cur_short'] = $currency2['cur_short'];
                                        $currency_counter++;
                                    }
                                }

                                usort($alphabetical_currencies, 'compareCurrencyByName');

                                echo "ls_id=" . $alphabetical_websites[0]['ls_id'] . "&client_language=" . $all_languages[0] . "&currency=" . $alphabetical_currencies[0]['cur_id'];
                                ?>">Create orders</a></li>

                            <?php 
                            } 
                            ?>
                    </ul>
                </div>


                <?php if ($_COOKIE['coordination'] > 0) 
                    { ?>
                    <div class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/acceptance/index.php?orderstatus=0") {
                    echo "active_menu";
                    } ?>"><a class="nav-link" href="<?php echo $base_url; ?>acceptance/index.php?orderstatus=0">
                    Contracting ( <?php
                    if ($_COOKIE['view_all_orders'] == 1) 
                    {
                    $orders_with_status_0 = $prod->show_all_order_request_orders();
                    $orders_with_status_9 = $prod->show_can_not_do_orders();
                    $orders_with_status_1_7 = $prod->show_unfinished_orders();
                    } else {
                    $orders_with_status_0=array();
                    $order_requests = $prod->show_all_order_requests_by_ls_id($licence_sites[0]);//1 website for now
                    $orders_with_status_9 = array();//maybe we change here 1 day
                    $orders_with_status_1_7 = $prod->show_unfinished_orders_by_ls_id($licence_sites[0]);
                    }
                    echo count($orders_with_status_0) . " / " . (count($orders_with_status_1_7) + count($orders_with_status_9));
                    ?> )
                    </a></div>
                    <div class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/coordination/index.php") {
                        echo "active_menu";
                    } ?>"><a class="nav-link" href="<?php echo $base_url; ?>coordination/index.php">Coordination</a>
                    </div>
                    
                <?php } ?>






                <div class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/own_tasks.php") {
                    echo "active_menu";
                } ?>">
                    <a class="nav-link" href="<?php echo $base_url; ?>own_tasks.php">Own tasks ( <?php
                        echo count($count_working_tasks = $prod->count_working_tasks($_COOKIE['client_id']));
                        ?> / <?php
                        echo $count_total_tasks = $prod->count_total_tasks($_COOKIE['client_id']); ?> )
                    </a>
                </div>
<?php if ($_COOKIE['useradmin'] > 0) {
?>
                <div class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/partners_share/index.php") {
                    echo "active_menu";
                } ?>"><a class="nav-link" href="<?php echo $base_url; ?>partners_share/index.php">Partner's share</a>
                </div>
<?php }?>

                <div class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/myprogram.php") {
                    echo "active_menu";
                } ?>"><a class="nav-link" href="<?php echo $base_url; ?>myprogram.php">My program</a></div>
                <div class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/mylabc.php?page=users") {
                    echo "active_menu";
                } ?>"><a class="nav-link" href="<?php echo $base_url; ?>mylabc.php?page=users">Own labcs</a></div>

                <div class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/studio/profile.php") {
                    echo "active_menu";
                } ?>"><a class="nav-link" href="<?php echo $base_url; ?>profile.php">My profile</a></div>
                <?php if (isset($_COOKIE['client_id'])) : ?>
                    <?php
                    if (!empty($_COOKIE['c_first_name']) || (!empty($_COOKIE['c_last_name']))) {
                        ?>
                        <div class="nav-item">You are logged in as: <span
                                    class="user-name"> <?php echo $_COOKIE['c_first_name'] . " " . $_COOKIE['c_last_name'] . " (ID: " . $_COOKIE['client_id'] . ")"; ?> </span>
                            <a href="<?php echo $base_url; ?>logout.php" class="text-secondary pl-2"
                               style="text-decoration: none;"><b>Logout</b></a></div>
                        <?php
                    } else {
                        ?>
                        <div class="nav-item">You are logged in as: <span
                                    class="user-name"> <?php echo $_COOKIE['l_first_name'] . " " . $_COOKIE['l_last_name'] . " (ID: " . $_COOKIE['client_id'] . ")"; ?> </span>
                            <a href="<?php echo $base_url; ?>logout.php" class="text-secondary pl-2"
                               style="text-decoration: none;"><b>Logout</b></a></div>

                        <?php
                    }
                    ?>
                <?php endif; ?>

                <?php
                }
                ?>


                <?php
                $company = $prod->get_company($_COOKIE['lt_id']);
                ?>

            </div>
        </nav>

    </header>
</div> <!-- end menu container -->
<!-- end main menu -->
