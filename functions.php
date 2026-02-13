<?php

class Production
{
    public function dbconnect()
    {
        $dbhost = "localhost";
        $dbuser = "adminhdd_domenia1";
        $dbpassword = "p@MjdhfBSmbXWv68";
        $database = "adminhdd_domenia1";

        $mysqli = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Sorry, Can't connect to database. Try later !");
        mysqli_set_charset($mysqli, 'utf8');

        return $mysqli;
    }

    public function dbdomenia0()
    {
        $dbhost = "localhost";
        $dbuser = "adminhdd_domenia0";
        $dbpassword = "p@MjdhfBSmbXWv68";
        $database = "adminhdd_domenia0";

        $mysqli = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Sorry, Can't connect to database. Try later !");
        mysqli_set_charset($mysqli, 'utf8');

        return $mysqli;
    }

    public function landing()
    {
        $dbhost = "localhost";
        $dbuser = "adminhdd_landing";
        $dbpassword = "p@MjdhfBSmbXWv68";
        $database = "adminhdd_landing";

        $mysqli = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Sorry, Can't connect to database. Try later !");
        mysqli_set_charset($mysqli, 'utf8');

        return $mysqli;
    }

    public function dbsuperplan()
    {
        $dbhost = "localhost";
        $dbuser = "adminhdd_superplan";
        $dbpassword = "p@MjdhfBSmbXWv68";
        $database = "adminhdd_superplan";

        $mysqli = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("are u joking?! there is no DB connection.");
        mysqli_set_charset($mysqli, 'utf8');

        return $mysqli;
    }

    public function dbdomenia2()
    {
        $dbhost = "localhost";
        $dbuser = "adminhdd_domenia2";
        $dbpassword = "p@MjdhfBSmbXWv68";
        $database = "adminhdd_domenia2";

        $mysqli = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("are u joking?! there is no DB connection.");
        mysqli_set_charset($mysqli, 'utf8');

        return $mysqli;
    }

    public function dbdomenia3n()
    {
        $dbhost = "localhost";
        $dbuser = "adminhdd_domenia3n";
        $dbpassword = "p@MjdhfBSmbXWv68";
        $database = "adminhdd_domenia3n";

        $mysqli = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("are u joking?! there is no DB connection.");
        mysqli_set_charset($mysqli, 'utf8');

        return $mysqli;
    }

    public function get_house_by_o_id_and_osub_id($o_id, $osub_id)
    {
        $mysqli = $this->dbsuperplan();
        $presentation_id = $o_id . '.' . $osub_id;
        $query = "SELECT * FROM `houses_types` WHERE `presentation_id` = '$presentation_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_house_gltf_model_path($o_id)
    {
        $mysqli = $this->dbconnect();
        $query = "SELECT * FROM `o_results` WHERE `o_id` = '$o_id' AND `orf_type_dom`='glb' AND `prod_id` = 'p156x' AND `orf_status` = '8'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_house_by_o_id($o_id)
    {
        $mysqli = $this->dbsuperplan();
        $presentation_id = $o_id;
        $query = "SELECT * FROM `houses_types` WHERE `presentation_id` = '$presentation_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_ck_id($mc_id)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `configurator_keys` WHERE `mc_id` = '$mc_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_ho_id_by_ck_id($house_id, $configurator_key)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `house_orders_configurator` WHERE `ck_id` = '$configurator_key' AND `house_id` = '$house_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_o_files($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $osub_id = substr($osub_id, 1);
        if ($osub_id[0] == '0') $osub_id = substr($osub_id, 1);
        $query = "SELECT * FROM `o_files` WHERE `o_id` = '$o_id' AND `of_exterior_position` = '$osub_id' AND `of_name_ex` != ''";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }


    public function get_ho_default_elements($ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `house_options` WHERE `ho_id` = '$ho_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_me_name($me_id)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT `element_name` FROM `model_elements` WHERE `me_id` = '$me_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }


    public function join_colors_on_col_pics()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `adminhdd_domenia2`.`colors` join `adminhdd_domenia2`.`col-pics` ON `adminhdd_domenia2`.`colors`.`col_id` = `adminhdd_domenia2`.`col-pics`.`col_id` join `adminhdd_domenia1`.`x-texts` ON  `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`col-pics`.`clp_id` WHERE `adminhdd_domenia1`.`x-texts`.`lang_id` = 1";
        print $query;
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }


    public function get_col_pics()
    {
        $mysqli = $this->dbdomenia2();
        $query = "SELECT * FROM `col-pics` ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_colors()
    {
        $mysqli = $this->dbdomenia2();
        $query = "SELECT * FROM `colors` ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_commissions()
    {
        $mysqli = $this->dbconnect();

        $query = "SELECT * FROM `commissions` order by `com_id` asc";
        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_commission($com_id)
    {
        $mysqli = $this->dbconnect();
        $com_id = mysqli_real_escape_string($mysqli, $com_id);

        $query = "SELECT * FROM `commissions` where `com_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $com_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);           

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_al_model_elements()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `model_elements` ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_data_from_superplan_table($table)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `" . $table . "`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_data_from_superplan_order_table($table, $ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `" . $table . "` WHERE `ho_id` = '" . $ho_id . "'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }


    public function add_new_me_id_to_ho_id($ho_id, $me_ids)
    {
        $mysqli = $this->dbsuperplan();

        $old_elements_arr = $this->get_ho_default_elements($ho_id);
        $old_elements = $old_elements_arr['default_elements'];

        $ho_id = mysqli_real_escape_string($mysqli, $ho_id);

        $new_data = $old_elements . ',' . $me_ids;

        $new_data = mysqli_real_escape_string($mysqli, $new_data);

        $query = "update  `house_options` set `default_elements`=?  where `ho_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ss", $new_data, $ho_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

    }


    public function get_house_orders_configurator($house_id)
    {
        $mysqli = $this->dbsuperplan();

        $house_id = mysqli_real_escape_string($mysqli, $house_id);
        $translation_table = mysqli_real_escape_string($mysqli, $translation_table);

        $stmt = mysqli_prepare($mysqli, "select * from `house_orders_configurator` where `house_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $house_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;

    }

    public function get_house_id_by_ho_id($ho_id)
    {
        $mysqli = $this->dbsuperplan();

        $ho_id = mysqli_real_escape_string($mysqli, $ho_id);
        $translation_table = mysqli_real_escape_string($mysqli, $translation_table);

        $stmt = mysqli_prepare($mysqli, "select * from `house_orders_configurator` where `ho_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;

    }

    public function remove_me_id_from_ho_id($ho_id, $me_ids)
    {
        $mysqli = $this->dbsuperplan();

        $old_elements_arr = $this->get_ho_default_elements($ho_id);
        $old_elements = $old_elements_arr['default_elements'];

        $ho_id = mysqli_real_escape_string($mysqli, $ho_id);

        $new_data = str_replace($me_ids . ',', '', $old_elements, $count);
        if ($count == 0) {
            $new_data = str_replace($me_ids, '', $old_elements);
        }

        $new_data = mysqli_real_escape_string($mysqli, $new_data);

        $query = "update  `house_options` set `default_elements`=?  where `ho_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ss", $new_data, $ho_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

    }


    public function change_house_status($house_id, $status)
    {
        $mysqli = $this->dbsuperplan();

        $house_id = mysqli_real_escape_string($mysqli, $house_id);
        $status = mysqli_real_escape_string($mysqli, $status);

        $query = "update  `houses_types` set `status`=? where `house_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ii", $status, $house_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

    }

    public function get_all_plan_orders()
    {
        $mysqli = $this->dbsuperplan();

        $query = "SELECT * FROM `orders_plansets` ORDER BY `orders_plansets`.`order_id` DESC";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function update_order_plansets($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);

        $order_id = mysqli_real_escape_string($mysqli, $data->order_id);
        $plans_amount = mysqli_real_escape_string($mysqli, $data->plans_amount);
        $order_price = mysqli_real_escape_string($mysqli, $data->order_price);
        $total_price = mysqli_real_escape_string($mysqli, $data->total_price);

        $query = "update `orders_plansets` set `plans_amount`='$plans_amount',`order_price`='$order_price',`total_price`='$total_price' where `order_id`='$order_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_all_data_from_domennia2_table($table)
    {
        $mysqli = $this->dbdomenia2();
        $query = "SELECT * FROM `" . $table . "`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_configurator_prices($table, $ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `" . $table . "` WHERE `ho_id` = $ho_id";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function change_configurator_price($table, $item_id_name, $item_id, $new_price)
    {
        $mysqli = $this->dbsuperplan();

        $item_id = mysqli_real_escape_string($mysqli, $item_id);
        $new_price = mysqli_real_escape_string($mysqli, $new_price);

        $stmt = "UPDATE `" . $table . "` SET `price`='$new_price' WHERE `" . $item_id_name . "` ='$item_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_configurator_price($ho_id, $table, $item_id_name, $item_id, $new_price)
    {
        $mysqli = $this->dbsuperplan();

        $ho_id = mysqli_real_escape_string($mysqli, $ho_id);
        $item_id = mysqli_real_escape_string($mysqli, $item_id);
        $new_price = mysqli_real_escape_string($mysqli, $new_price);

//        if ($mm_id)
//            $stmt = "INSERT INTO `" . $table . "`(`ho_id`, `" . $item_id_name . "`, `price`, `mm_id`) VALUES('$ho_id','$item_id','$new_price', '$mm_id')";
//        else
        $stmt = "INSERT INTO `" . $table . "`(`ho_id`, `" . $item_id_name . "`, `price`) VALUES('$ho_id','$item_id','$new_price')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        print $stmt;
        mysqli_close($mysqli);
    }

    public function check_configurator_price($h_id, $table, $item_id_name, $item_id)
    {
        $mysqli = $this->dbsuperplan();

        $h_id = mysqli_real_escape_string($mysqli, $h_id);
        $item_id = mysqli_real_escape_string($mysqli, $item_id);

        $stmt = "SELECT * FROM `" . $table . "`  WHERE `" . $item_id_name . "` ='$item_id' AND `h_id`='$h_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function activate_configurator_swatch($ho_id, $table, $item_id_name, $item_id, $status)
    {
        $mysqli = $this->dbsuperplan();

        $ho_id = mysqli_real_escape_string($mysqli, $ho_id);
        $item_id = mysqli_real_escape_string($mysqli, $item_id);

        $query = "UPDATE `" . $table . "` SET `status`='$status' WHERE `" . $item_id_name . "` ='$item_id' AND `ho_id`='$ho_id'";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_ho_menu_data($cm_id)
    {
        $mysqli = $this->dbsuperplan();
        $id = mysqli_real_escape_string($mysqli, $hom_id);
        $query = "SELECT * FROM `configurator_menu` WHERE `cm_id`=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $cm_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_plan_object_count($plan_kind, $house_id)
    {
        $mysqli = $this->dbsuperplan();
        $plan_kind = mysqli_real_escape_string($mysqli, $plan_kind);
        $house_id = mysqli_real_escape_string($mysqli, $house_id);

        $query = "SELECT count(*)  FROM pls_files WHERE plan_kind=? and house_id = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "si", $plan_kind, $house_id);
        // mysqli_stmt_bind_param($stmt,"i",$house_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row['count(*)'];
    }

    public function client_login($email, $password)
    {
        $mysqli = $this->dbconnect();
        $email = mysqli_real_escape_string($mysqli, $email);
        $password = sha1($password);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where (`u_username`=? or `email`=?) and `password`=?");
        mysqli_stmt_bind_param($stmt, "sss", $email, $email, $password);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_pict_categ_name($orf_name)
    {
        $mysqli = $this->dbconnect();
        $orf_name = mysqli_real_escape_string($mysqli, $orf_name);

        $stmt = mysqli_prepare($mysqli, "select pict_categ_name from `o_results` where `orf_name`=? ");
        mysqli_stmt_bind_param($stmt, "s", $orf_name);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_colorsss()
    {
        $mysqli = $this->landing();
        $query = "SELECT * FROM `u_clients_colors`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    function get_all_translations_by_lang($lang_id)
    {
        $mysqli = $this->dbsuperplan();
        $lang_id = mysqli_real_escape_string($mysqli, $lang_id);

        $stmt = mysqli_prepare($mysqli, "select * from `translations` where `lang_id`=? order by `id_translation` desc");
        mysqli_stmt_bind_param($stmt, "s", $lang_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function get_tof_by_house_id($house_id)
    {
        $mysqli = $this->dbsuperplan();
        $house_id = mysqli_real_escape_string($mysqli, $house_id);

        $stmt = mysqli_prepare($mysqli, "select * from `pls_files` where `house_id`=? ");
        mysqli_stmt_bind_param($stmt, "s", $house_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function update_translation_superplan($trans_id, $lang_id, $lang_name, $lang_description, $translation)
    {
        $mysqli = $this->dbsuperplan();
        $trans_id = mysqli_real_escape_string($mysqli, $trans_id);
        $lang_id = mysqli_real_escape_string($mysqli, $lang_id);
        $lang_name = mysqli_real_escape_string($mysqli, $lang_name);
        $lang_description = mysqli_real_escape_string($mysqli, $lang_description);
        $translation = mysqli_real_escape_string($mysqli, $translation);

        $sql = "update `translations` set `id_translation`='$trans_id',`lang_id`='$lang_id',`lang_name`='$lang_name',`description_engl`='$lang_description',`text`='$translation' where `id_translation`='$trans_id' and `lang_id`='$lang_id'";
        mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    function update_o_special_agreement_price_changed_by($o_id, $client_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $sql = "update `orders` set `o_special_agreement_price_changed_by`='$client_id' where `order_ID`='$o_id'";

        mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function update_order_client_id($o_id, $client_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $mc_id = $this->get_client($client_id)['mc_id'];

        $sql = "update `orders` set `u_client_ID`='$client_id',`mc_id`='$mc_id' where `order_ID`='$o_id'";

        mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function update_order_lic_id($o_id, $lic_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $lic_id = mysqli_real_escape_string($mysqli, $lic_id);
        $licence = $this->get_licence($lic_id);
        $currencies = explode(';', $licence['currencies']);
        $currency = $currencies[0];

        $sql = "update `orders` set `lic_ID`='$lic_id',`cur_id`='$currency' where `order_ID`='$o_id'";

        mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function delete_translation_superplan($trans_id, $lang_id)
    {
        $mysqli = $this->dbsuperplan();

        $trans_id = mysqli_real_escape_string($mysqli, $trans_id);
        $lang_id = mysqli_real_escape_string($mysqli, $lang_id);


        $stmt = mysqli_prepare($mysqli, "DELETE FROM `translations` WHERE `id_translation`=? AND `lang_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $trans_id, $lang_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    function delete_invoice($lic_id, $i_id)
    {
        $mysqli = $this->dbdomenia0();

        $i_id = mysqli_real_escape_string($mysqli, $i_id);
        $lic_id = mysqli_real_escape_string($mysqli, $lic_id);


        $stmt = mysqli_prepare($mysqli, "DELETE FROM `" . $lic_id . "_i` WHERE `i_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $i_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_invoice_by_invid($lic_id, $i_id)
    {
        $mysqli = $this->dbdomenia0();

        $lic_id = mysqli_real_escape_string($mysqli, $lic_id);
        $i_id = mysqli_real_escape_string($mysqli, $i_id);

        $get_invoice_sql = "select * from `" . $lic_id . "_i` where `i_id`='$i_id'";

        $get_invoice_result = mysqli_query($mysqli, $get_invoice_sql) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($get_invoice_result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    function delete_plot($plot_id)
    {
        $mysqli = $this->dbsuperplan();

        $plot_id = mysqli_real_escape_string($mysqli, $plot_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `plots` WHERE `plot_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $plot_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    function get_translation_text_superplan($lang_id, $text_id)
    {
        $mysqli = $this->dbsuperplan();
        $lang_id = mysqli_real_escape_string($mysqli, $lang_id);
        $text_id = mysqli_real_escape_string($mysqli, $text_id);

        $sql = 'SELECT * FROM translations WHERE lang_id=? AND id_translation=?';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "is", $lang_id, $text_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }


    function add_translation_superplan($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);
        $trans_id = mysqli_real_escape_string($mysqli, $data->trans_id);
        $lang_id = mysqli_real_escape_string($mysqli, $data->lang_id);
        $lang_name = mysqli_real_escape_string($mysqli, $data->lang_name);
        $lang_description = mysqli_real_escape_string($mysqli, $data->lang_description);
        $translation = mysqli_real_escape_string($mysqli, $data->translation);


        $stmt = "insert into `translations`(`id_translation`,`lang_id`,`lang_name`,`description_engl`,`text`) values('$trans_id','$lang_id','$lang_name','$lang_description','$translation')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function add_room_ids($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data = json_decode($data);

        $trans_id = mysqli_real_escape_string($mysqli, $data->rk_id);
        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $room_number = mysqli_real_escape_string($mysqli, $data->room_number);
        $room_name = mysqli_real_escape_string($mysqli, $data->room_name);
        $room_description = mysqli_real_escape_string($mysqli, $data->room_description); 

        $stmt = "insert into `room_ids`(`o_id`,`osub_id`,`room_number`,`rk_id`,`room_name`,`room_description`) values('$o_id','$osub_id','$room_number','$trans_id','$room_name','$room_description')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function add_interior_entities($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $e_n_level = mysqli_real_escape_string($mysqli, $data->e_n_level);
        $e_n_name = mysqli_real_escape_string($mysqli, $data->e_n_name);
        $e_n_size_total = mysqli_real_escape_string($mysqli, $data->e_n_size_total);
        $e_n_size_usable = mysqli_real_escape_string($mysqli, $data->e_n_size_usable);
        $e_n_price = mysqli_real_escape_string($mysqli, $data->e_n_price); 
        $e_n_status=mysqli_real_escape_string($mysqli, $data->e_n_status);

        $stmt = "insert into `entities_n`(`o_id`,`e_n_level`,`e_n_name`,`e_n_size_total`,`e_n_size_usable`,`e_n_price`,`e_n_status`) values('$o_id','$e_n_level','$e_n_name','$e_n_size_total','$e_n_size_usable','$e_n_price','$e_n_status')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function update_room_ids($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data = json_decode($data);

        $room_id = mysqli_real_escape_string($mysqli, $data->room_id);
        $trans_id = mysqli_real_escape_string($mysqli, $data->rk_id);
        $room_number = mysqli_real_escape_string($mysqli, $data->room_number);
        $room_name = mysqli_real_escape_string($mysqli, $data->room_name);
        $room_description = mysqli_real_escape_string($mysqli, $data->room_description);

        $stmt = "update `room_ids` set `room_number`='$room_number',`rk_id`='$trans_id',`room_name`='$room_name',`room_description`='$room_description' where `room_id`='$room_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function add_perspective_ids($data)
    {
        $mysqli = $this->dbdomenia2();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $per_kind = mysqli_real_escape_string($mysqli, $data->per_kind);
        $per_name = mysqli_real_escape_string($mysqli, $data->per_name);
        $per_description = mysqli_real_escape_string($mysqli, $data->per_description); 

        $stmt = "insert into `perspective_ids`(`o_id`,`osub_id`,`per_kind`,`per_name`,`per_description`) values('$o_id','$osub_id','$per_kind','$per_name','$per_description')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function update_per_ids($data)
    {
        $mysqli = $this->dbdomenia2();
        $data = json_decode($data);

        $per_id = mysqli_real_escape_string($mysqli, $data->per_id);
        $per_kind = mysqli_real_escape_string($mysqli, $data->per_kind);
        $per_name = mysqli_real_escape_string($mysqli, $data->per_name);
        $per_description = mysqli_real_escape_string($mysqli, $data->per_description);

        $stmt = "update `perspective_ids` set `per_kind`='$per_kind',`per_name`='$per_name',`per_description`='$per_description' where `per_id`='$per_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function delete_per_ids($per_id)
    {
        $mysqli = $this->dbdomenia2();

        $per_id = mysqli_real_escape_string($mysqli, $per_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `perspective_ids` WHERE `per_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $per_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    function delete_room_ids($room_id)
    {
        $mysqli = $this->dbdomenia3n();

        $room_id = mysqli_real_escape_string($mysqli, $room_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `room_ids` WHERE `room_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $room_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    function delete_main_client_position($ucb_id)
    {
        $mysqli = $this->dbconnect();

        $ucb_id = mysqli_real_escape_string($mysqli, $ucb_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `u_clients_bosses` WHERE `ucb_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $ucb_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    function delete_interior_entity($e_n_id)
    {
        $mysqli = $this->dbconnect();

        $e_n_id = mysqli_real_escape_string($mysqli, $e_n_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `entities_n` WHERE `e_n_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $e_n_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    function check_existing_room_kind_special($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $trans_id = mysqli_real_escape_string($mysqli, $data->trans_id);
        $room_number = mysqli_real_escape_string($mysqli, $data->room_number);

        $sql = 'SELECT * FROM `room_kind_special` WHERE `o_id`=? AND `room_number`=? AND `rm_tx`=?';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $o_id, $room_number, $trans_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function get_all_room_kind_special($o_id)
    {
        $mysqli = $this->dbdomenia3n();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $sql = 'SELECT * FROM `room_ids` WHERE `o_id`=?';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function get_all_rooms_for_this_sub_id($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data=json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);

        $sql = 'SELECT * FROM `room_ids` WHERE `o_id`=? AND `osub_id`=? ORDER BY `room_ids`.`osub_id`,`room_ids`.`room_number` ASC';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "is", $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function get_all_perspectives_for_this_sub_id($data)
    {
        $mysqli = $this->dbdomenia2();
        $data=json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);

        $sql = 'SELECT * FROM `perspective_ids` WHERE `o_id`=? AND `osub_id`=? ORDER BY `perspective_ids`.`osub_id` ASC';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "is", $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function get_all_room_kind()
    {
        $mysqli = $this->dbdomenia3n();

        $sql = 'SELECT * FROM `room_kinds_all` ORDER BY `room_kinds_all`.`rk_name_english` ASC';

        $stmt = mysqli_prepare($mysqli, $sql);
        //mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function get_room_kind($rk_id)
    {
        $mysqli = $this->dbdomenia3n();

        $rk_id = mysqli_real_escape_string($mysqli, $rk_id);

        $sql = 'SELECT * FROM `room_kinds_all` WHERE `rk_id`=?';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $rk_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function get_all_furniture_set_4_units()
    {
        $mysqli = $this->dbdomenia3n();

        $sql = 'SELECT * FROM `lt_3_sets_4_units` ORDER BY `ft_3_id` DESC';

        $stmt = mysqli_prepare($mysqli, $sql);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function get_room_kind_special($rks_id)
    {
        $mysqli = $this->dbdomenia3n();

        $rks_id = mysqli_real_escape_string($mysqli, $rks_id);

        $sql = 'SELECT * FROM `room_kind_special` WHERE `rks_id`=?';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $rks_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function delete_from_plansets($house_id)
    {
        $mysqli = $this->dbsuperplan();

        $house_id = mysqli_real_escape_string($mysqli, $house_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `houses_types` WHERE `house_id` =?");

        mysqli_stmt_bind_param($stmt, "i", $house_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_plan_by_id($plan_id)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `pls_files` WHERE `plan_id` =?");

        mysqli_stmt_bind_param($stmt, "i", $plan_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_planset_order($o_id)
    {
        $mysqli = $this->dbsuperplan();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_plansets` WHERE `order_id` =?");

        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_planset_by_pls_id($pls_id)
    {
        $mysqli = $this->dbsuperplan();

        $pls_id = mysqli_real_escape_string($mysqli, $pls_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `plansets` WHERE `pls_id` =?");

        mysqli_stmt_bind_param($stmt, "i", $pls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function delete_from_planset_spseven($house_id)
    {
        $mysqli = $this->dbsuperplan();

        $house_id = mysqli_real_escape_string($mysqli, $house_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `pls_files` WHERE `house_id` =?");

        mysqli_stmt_bind_param($stmt, "i", $house_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_from_o_infos_all_prod($pres_id)
    {
        $mysqli = $this->dbconnect();

        $pres_id = mysqli_real_escape_string($mysqli, $pres_id);

        $stmt = mysqli_prepare($mysqli, "DELETE FROM `o_desc_allproducts` WHERE `o_id` =?");

        mysqli_stmt_bind_param($stmt, "i", $pres_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function creator_login($email, $password)
    {
        $mysqli = $this->dbconnect();
        $email = mysqli_real_escape_string($mysqli, $email);
        $password = sha1($password);

        $stmt = mysqli_prepare($mysqli, "select * from `u_creators` where `uca_email`=? and `uca_password`=?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_main_client_options($mc_id)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $query = "SELECT * FROM `u_clients_main_options_shown` WHERE `mc_id`=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $mc_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_picture_areas()
    {
        $mysqli = $this->dbdomenia2();
        $query = "SELECT * FROM `picture_areas` ORDER BY `picture_areas`.`pa_id` ASC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_picture_area($pa_id)
    {
        $mysqli = $this->dbdomenia2();
        $pa_id = mysqli_real_escape_string($mysqli, $pa_id);

        $query = "SELECT * FROM `picture_areas` WHERE `pa_id`=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $pa_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_roof_shapes()
    {
        $mysqli = $this->dbdomenia2();
        $query = "SELECT * FROM `roof-shapes`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_configurator_menu_items()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `configurator_menu` ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_type_of_stairs()
    {
        $mysqli = $this->dbdomenia3n();
        $query = "SELECT * FROM `stairs` ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_planset($id)
    {
        $mysqli = $this->dbsuperplan();
        $id = mysqli_real_escape_string($mysqli, $id);
        $query = "SELECT * FROM houses_types WHERE presentation_id=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_planset2($id) //not to be used in the future
    {
        $mysqli = $this->dbsuperplan();
        $id = mysqli_real_escape_string($mysqli, $id);
        $query = "SELECT * FROM houses_types WHERE house_id=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_house_type($house_id)
    {
        $mysqli = $this->dbsuperplan();
        $house_id = mysqli_real_escape_string($mysqli, $house_id);

        $query = "SELECT * FROM `houses_types` WHERE house_id=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $house_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_plans_sp7($id)
    {
        $mysqli = $this->dbsuperplan();
        $id = mysqli_real_escape_string($mysqli, $id);
        $query = "SELECT * FROM pls_files WHERE house_id=? ORDER BY plan_kind ASC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    /* not used anymore, the database was modified
        public function get_all_plansets()
        {
            $mysqli = $this->dbsuperplan();
            $query = "SELECT * FROM plansets ORDER BY house_id DESC";
            $stmt = mysqli_prepare($mysqli, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $rows = array();
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            return $rows;
        }
    */
    public function get_all_plansets()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM plansets ORDER BY pls_id DESC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_houses_types()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM houses_types ORDER BY house_id DESC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_house_types_by_parameters($data)
    {
        $mysqli = $this->dbsuperplan();
        $data=json_decode($data);

        $depth1=mysqli_real_escape_string($mysqli, $data->depth1);
        $depth2=mysqli_real_escape_string($mysqli, $data->depth2);

        $width1=mysqli_real_escape_string($mysqli, $data->width1);
        $width2=mysqli_real_escape_string($mysqli, $data->width2);

        $surface1=mysqli_real_escape_string($mysqli, $data->surface1);
        $surface2=mysqli_real_escape_string($mysqli, $data->surface2);

        $height1=mysqli_real_escape_string($mysqli, $data->height1);
        $height2=mysqli_real_escape_string($mysqli, $data->height2);

        $roof_tilt1=mysqli_real_escape_string($mysqli, $data->roof_tilt1);
        $roof_tilt2=mysqli_real_escape_string($mysqli, $data->roof_tilt2);

        $stories1=mysqli_real_escape_string($mysqli, $data->stories1);
        $stories2=mysqli_real_escape_string($mysqli, $data->stories2);

        $building_company=mysqli_real_escape_string($mysqli, $data->building_company);

        $order_option=mysqli_real_escape_string($mysqli, $data->order_option);
        $order_id=mysqli_real_escape_string($mysqli, $data->order_id);

        $order_by=mysqli_real_escape_string($mysqli, $data->order_by);

        $query = "SELECT * FROM `houses_types` ";

        if((!empty($roof_tilt1))&&(!empty($roof_tilt2)))
        {
            $query .=" LEFT JOIN `adminhdd_domenia1`.`o_desc_allproducts` ON `houses_types`.`presentation_id`=`adminhdd_domenia1`.`o_desc_allproducts`.`o_id` ";
        }
        
        if(
            ((!empty($depth1))&&(!empty($depth2)))||
            ((!empty($surface1))&&(!empty($surface2)))||
            ((!empty($width1))&&(!empty($width2)))||
            ((!empty($height1))&&(!empty($height2)))||
            ((!empty($stories1))&&(!empty($stories2)))||
            ((!empty($roof_tilt1))&&(!empty($roof_tilt2)))||
            (!empty($order_id))||
            (!empty($building_company))
        )
        {
            $query .=" where ";
        }

        if((!empty($depth1))&&(!empty($depth2)))
        {
            $query .=" `length` between '$depth1' and '$depth2' and ";
        }
        if((!empty($surface1))&&(!empty($surface2)))
        {
            $query .=" `surface` between '$surface1' and '$surface2' and ";
        }
        if(((!empty($height1))&&(!empty($height2))))
        {
            $query .=" `height` between '$height1' and '$height2' and ";
        }
        if((!empty($width1))&&(!empty($width2)))
        {
            $query .=" `width` between '$width1' and '$width2' and ";
        }
        if(((!empty($stories1))&&(!empty($stories2))))
        {
            $query .=" `stories` between '$stories1' and '$stories2' and ";
        }
        if((!empty($roof_tilt1))&&(!empty($roof_tilt2)))
        {
            $query .="  `adminhdd_domenia1`.`o_desc_allproducts`.`roof_tilt` BETWEEN '$roof_tilt1' and '$roof_tilt2' and ";
        }
        
        if(($order_option=="example_id")&&(!empty($order_id)))
        {
            $query .=" `presentation_id`='$order_id' and ";
        }
        if(($order_option=="material_id")&&(!empty($order_id)))
        {
            $query .=" `material_id`='$order_id' and ";
        }

        if(!empty($building_company))
        {        
            $query .=" `builders_id`='$building_company' ";
        }

        if($order_by=="house_id")
        {
            $query .=" ORDER BY `house_id` DESC";
        }
        else
        {
            $query .=" ORDER BY `house_name` ASC";
        }

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_plansets_for_configurator()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM houses_types WHERE configurator != 0 ORDER BY house_id DESC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function create_order_info_id($id)
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);


        $stmt = "insert into `o_desc_allproducts`(`o_id`) values('$id')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function create_ho($house_id)
    {

        $mysqli = $this->dbsuperplan();

        $last_ho_id = $this->get_last_ho_id()['ho_id'];

        $ho_id = explode('_', $last_ho_id)[1];

        $ho_id = $ho_id + 1;

        if (strlen($ho_id) < 5) {
            while (strlen($ho_id) != 5) {
                $ho_id = '0' . $ho_id;
            }
        }

        $ho_id = 'ho_' . $ho_id;
        $house_id = mysqli_real_escape_string($mysqli, $house_id);


        $stmt = "insert into `house_orders_configurator`(`house_id`,`ho_id`) values('$house_id','$ho_id')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));


        $stmt = "INSERT INTO `ho_door-shape` (`ho_ds_id`, `ho_id`, `dsp_id`, `price`, `description`, `status`) VALUES (NULL, '$ho_id', 'dsp_002', '0', '', '1'), (NULL, '$ho_id', 'dsp_004', '1000', '', '1'), (NULL, '$ho_id', 'dsp_008', '1000', '', '1'), (NULL, '$ho_id', 'dsp_010', '1000', '', '1');";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $stmt = "INSERT INTO `ho_doors` (`ho_d_id`, `ho_id`, `col_id`, `me_id`, `mm_id`, `size`, `price`, `status`, `description`) VALUES (NULL, '$ho_id', 'col_8007', 'me_055,me_057,me_059,me_061', 'mm_0304', '0.06', '200', '1', ''), (NULL, '$ho_id', 'col_9016', 'me_055,me_057,me_059,me_061', 'mm_0203', '1', '0', '1', ''), (NULL, '$ho_id', 'col_7016', 'me_055,me_057,me_059,me_061', 'mm_0203', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0011', 'me_055,me_057,me_059,me_061', 'mm_0203', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0013', 'me_055,me_057,me_059,me_061', 'mm_0203', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0020', 'me_055,me_057,me_059,me_061', 'mm_0203', '1', '0', '1', '');";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $stmt = "INSERT INTO `ho_gutters` (`ho_gu_id`, `ho_id`, `gut_id`, `me_id`, `mm_id`, `size`, `price`, `status`, `description`) VALUES (NULL, '$ho_id', 'gut_001', 'me_016,me_020,me_025,me_030,me_034,me_037', 'mm_0204', '1', '0', '1', 'metal'), (NULL, '$ho_id', 'gut_002', 'me_016,me_020,me_025,me_030,me_034,me_037', 'mm_0205', '1', '1500', '1', 'Cooper'), (NULL, '$ho_id', 'gut_003', 'me_016,me_020,me_025,me_030,me_034,me_037', 'mm_0206', '1', '500', '0', 'White'), (NULL, '$ho_id', 'gut_007', 'me_016,me_020,me_025,me_030,me_034,me_037', 'mm_0207', '1', '700', '1', 'Green');";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $stmt = "INSERT INTO `ho_roof-tiles` (`ho_rt_id`, `ho_id`, `rmp_id`, `mm_id`, `price`, `size`, `description`, `status`) VALUES (NULL, '$ho_id', '2', 'mm_0106', '2100', '0.25', 'Flat TIles', '1'), (NULL, '$ho_id', '6', 'mm_0107', '2000', '0.25', 'Flat TIles', '1'), (NULL, '$ho_id', '7', 'mm_0108', '2500', '0.25', 'Flat TIles', '0'), (NULL, '$ho_id', '5', 'mm_0103', '2000', '0.25', 'Flat Tiles', '1'), (NULL, '$ho_id', '3', 'mm_0105', '2500', '0.25', 'Flat TIles', '0'), (NULL, '$ho_id', '16', 'mm_0102', '0', '1', 'Monk', '1'), (NULL, '$ho_id', '17', 'mm_0109', '0', '1', 'Monk', '1'), (NULL, '$ho_id', '18', 'mm_0110', '0', '1', 'Monk', '1');";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $stmt = "INSERT INTO `ho_walls` (`ho_wa_id`, `ho_id`, `col_id`, `me_id`, `size`, `price`, `status`, `description`) VALUES (NULL, '$ho_id', 'col_0002', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0003', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0004', 'me_006', '1', '0', '0', ''), (NULL, '$ho_id', 'col_0006', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0007', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0008', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0009', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0010', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0011', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0012', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0013', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0014', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0015', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0016', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0017', 'me_006', '1', '0', '1', ''), (NULL, '$ho_id', 'col_0018', 'me_006', '1', '0', '0', '');";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $stmt = "INSERT INTO `ho_walls-second` (`ho_ws_id`, `ho_id`, `col_id`, `mm_id`, `price`, `size`, `status`, `description`) VALUES (NULL, '$ho_id', 'col_9016', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0002', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0003', 'mm_0001', '0', '1', '1', ''), (NULL, '$ho_id', 'col_0004', 'mm_0001', '1000', '1', '0', ''), (NULL, '$ho_id', 'col_0006', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0007', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0008', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0009', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0010', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0011', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0012', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0013', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0014', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0015', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0016', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0017', 'mm_0001', '1000', '1', '1', ''), (NULL, '$ho_id', 'col_0018', 'mm_0001', '1000', '1', '0', '');";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $stmt = "INSERT INTO `ho_windows` (`ho_wi_id`, `ho_id`, `col_id`, `me_id`, `mm_id`, `size`, `price`, `description`, `status`) VALUES (NULL, '$ho_id', 'col_7016', 'me_009', 'mm_0201', '1', '0', '', '1'), (NULL, '$ho_id', 'col_8007', 'me_009', 'mm_0304', '0.06', '700', '', '1'), (NULL, '$ho_id', 'col_9016', 'me_009', 'mm_0201', '1', '200', '', '1');";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_last_ho_id()
    {

        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `house_orders_configurator` ORDER BY `ho_id` DESC LIMIT 1 ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function add_o_desc_allproducts($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $length = mysqli_real_escape_string($mysqli, $data->length ?? '');
        $width = mysqli_real_escape_string($mysqli, $data->width ?? '');
        $roof_type = mysqli_real_escape_string($mysqli, $data->roof_type ?? '');
        $roof_tilt = mysqli_real_escape_string($mysqli, $data->roof_tilt ?? '');
        $knee_wall = mysqli_real_escape_string($mysqli, $data->knee_wall ?? '');
        $stairs_id = mysqli_real_escape_string($mysqli, $data->stairs_id ?? '');
        $basement = mysqli_real_escape_string($mysqli, $data->basement ?? '0');
        $photovoltaic = mysqli_real_escape_string($mysqli, $data->photovoltaic ?? '0');
        $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground ?? '0');
        $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id ?? '');
        $roof_material = mysqli_real_escape_string($mysqli, $data->roof_material ?? '');
        $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id ?? '');
        $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id ?? '');
        $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id ?? '');
        $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture ?? '');
        $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id ?? '');
        $door_color = mysqli_real_escape_string($mysqli, $data->door_color ?? '');
        $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id ?? '');
        $gc_length = mysqli_real_escape_string($mysqli, (float) $data->gc_length ?? '0.0');
        $gc_width = mysqli_real_escape_string($mysqli, (float) $data->gc_width ?? '0.0');
        $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id ?? '');

        $stmt = "insert into `o_desc_allproducts`(`o_id`,`length`,`width`,`height`,`stories`,`surface`,`roof_type`,`roof_material`,
        `rop_id`,`wlc_id`,`roof_tilt`,`knee_wall`,`ww_id`,`gc_id`,`gc_length`,`gc_width`,`gc_height`,`wc_id`,`door_color`,`door_texture`,
        `dsp_id`,`pbp_id`,`basement`,`photovoltaic`,`levels_over_ground`,`stairs_id`,`rooms`,`bedrooms`,`bathrooms`,`build_in_garag`,`product_status`) 
        values('$o_id','$length','$width','','0.0','0','$roof_type','$roof_material','$rop_id','$wlc_id','$roof_tilt','$knee_wall',
        '$ww_id','$gc_id','$gc_length','$gc_width','2.5','$wc_id','$door_color','$door_texture','$dsp_id','$pbp_id','$basement',
        '$photovoltaic','$levels_over_ground','$stairs_id','','','','','1')";
       
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    /**
     * get o_infos_allproducts by oreder_id
     */
    public function get_o_infos_allproducts($id)
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);
        $query = "SELECT * FROM `o_desc_allproducts` WHERE `o_id`=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }


    public function get_image_of_categ($o_id, $o_subid)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $o_subid = mysqli_real_escape_string($mysqli, $o_subid);
        $query = "SELECT * FROM `o_results` WHERE (`o_id`=? or `om_id`=?)AND  `osub_id`=? AND (`orf_type_dom` = 'jpg' OR `orf_type_dom` = 'png') and 
        (`orf_status`='8')  ORDER BY `orf_name` ASC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id, $o_subid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_image_of_categ_furnished_first($o_id, $o_subid)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $o_subid = mysqli_real_escape_string($mysqli, $o_subid);
        $query = "SELECT * FROM `o_results` WHERE `o_id`=? AND  `osub_id`=? AND (`orf_type_dom` = 'jpg' OR `orf_type_dom` = 'png') and 
        (`orf_status`='8') and(
			`prod_id` = 'p1723' ||
			`prod_id` = 'p1724' ||
			`prod_id` = 'p1725' ||
			`prod_id` = 'p1726'
		)  ORDER BY `orf_name` ASC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "is", $o_id, $o_subid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_image_of_categ_int($o_id, $o_subid)
    {
        return   /*$this->get_image_of_categ_furnished_first($o_id,$o_subid) ? $this->get_image_of_categ_furnished_first($o_id,$o_subid) :*/ $this->get_image_of_categ($o_id, $o_subid);
    }

    public function get_image_of_categ_panorama_int($o_id, $o_subid)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $o_subid = mysqli_real_escape_string($mysqli, $o_subid);
        $query = "SELECT * FROM `o_results` WHERE (`o_id`=? or `om_id`=?) AND  `osub_id`=? AND (`orf_type_dom` = 'jpg' OR `orf_type_dom` = 'png') and 
        (`orf_status`='8')
        and (
            `prod_id` = 'p1506' || `prod_id` = 'p1526' || `prod_id` = 'p1546'  ||
            `prod_id` = 'p1606' || `prod_id` = 'p1626' || `prod_id` = 'p1646' ||
            `prod_id` = 'p1706' || `prod_id` = 'p1726' || `prod_id` = 'p1746' ||
            `prod_id` = 'p1806' || `prod_id` = 'p1826' || `prod_id` = 'p1846' 
        
        )  
          ORDER BY `orf_name` ASC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id, $o_subid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function check_id($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $query = "SELECT * FROM `o_results` WHERE `o_id`=? ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $o_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_all_presentation_id()
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);
        $query = "SELECT  * FROM `o_desc_allproducts` ORDER BY o_id DESC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function advanced_search_orders($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $length = mysqli_real_escape_string($mysqli, $data->length);
        $width = mysqli_real_escape_string($mysqli, $data->width);
        $rs_id = mysqli_real_escape_string($mysqli, $data->roof_shape);

        if ((empty($width)) && (empty($rs_id))) {
            $query = "SELECT  * FROM `o_desc_allproducts` where `length`='$length'";
        }

        if ((empty($length)) && (empty($rs_id))) {
            $query = "SELECT  * FROM `o_desc_allproducts` where `width`='$width'";
        }

        if ((!empty($length)) && (!empty($width)) && (!empty($rs_id))) {
            $query = "SELECT  * FROM `o_desc_allproducts` where `length`='$length' and `width`='$width' and `roof_type`='$rs_id'";
        }

        if ((empty($length)) && (empty($width)) && (!empty($rs_id))) {
            $query = "SELECT  * FROM `o_desc_allproducts` where `roof_type`='$rs_id' order by `o_id` desc";
        }

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_o_infos_allprod($id)
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);
        $query = "SELECT * FROM `o_desc_allprod` WHERE `o_id`=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_pl_obj_abbr($id)
    {
        $mysqli = $this->dbsuperplan();
        $id = mysqli_real_escape_string($mysqli, $id);
        $query = "SELECT * FROM plan_objects WHERE pl_object_ID=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }


    public function get_company($lt_id)
    {
        $mysqli = $this->dbconnect();
        $lt_id = mysqli_real_escape_string($mysqli, $lt_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_licence_takers` where `lt_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $lt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    /**
     * edit method
     * by presentation ID
     */
    public function edit_planset_general_info($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);
        $house_name = mysqli_real_escape_string($mysqli, $data->house_name);

        $material_id = mysqli_real_escape_string($mysqli, $data->material_id ?? 0);
        $object_type = mysqli_real_escape_string($mysqli, $data->object_type ?? 0);
        $presentation_id = mysqli_real_escape_string($mysqli, $data->presentation_id ?? 0);
        $planset_id = mysqli_real_escape_string($mysqli, $data->planset_id ?? 0);
        $house_description = mysqli_real_escape_string($mysqli, $data->house_description ?? '');

        $price_building = mysqli_real_escape_string($mysqli, $data->price_building ?? 0);
        $b_price_1 = mysqli_real_escape_string($mysqli, $data->b_price_1 ?? 0);
        $b_price_2 = mysqli_real_escape_string($mysqli, $data->b_price_2 ?? 0);
        $b_price_3 = mysqli_real_escape_string($mysqli, $data->b_price_3 ?? 0);
        $b_price_4 = mysqli_real_escape_string($mysqli, $data->b_price_4 ?? 0);
        $b_price_5 = mysqli_real_escape_string($mysqli, $data->b_price_5 ?? 0);
        $building_company = mysqli_real_escape_string($mysqli, $data->building_company ?? 0);
        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id ?? 0);
        $id = mysqli_real_escape_string($mysqli, $data->id);

        $stmt = "UPDATE  `houses_types` SET `house_name` = '$house_name',`planset_id` = '$planset_id',`price_building` = '$price_building',`b_price_1` = '$b_price_1',`b_price_2` = '$b_price_2',`b_price_3` = '$b_price_3',`b_price_4` = '$b_price_4',`b_price_5` = '$b_price_5',`builders_id` = '$building_company',`presentation_id`='$presentation_id', `object_type`='$object_type',`house_description` = '$house_description', `mc_id` = '$mc_id', `material_id` = '$material_id'  where `house_id`='$id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_houseset_general_info($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);

        $house_name = mysqli_real_escape_string($mysqli, $data->house_name ?? '');
        $presentation_id = mysqli_real_escape_string($mysqli, $data->presentation_id ?? 0);
        $material_id = mysqli_real_escape_string($mysqli, $data->material_id ?? 0);
        $planset_id = mysqli_real_escape_string($mysqli, $data->planset_id ?? 0);
        $house_description = mysqli_real_escape_string($mysqli, $data->house_description ?? '');
        $price_building = mysqli_real_escape_string($mysqli, $data->price_building ?? 0);
        $b_price_1 = mysqli_real_escape_string($mysqli, $data->b_price_1 ?? 0);
        $b_price_2 = mysqli_real_escape_string($mysqli, $data->b_price_2 ?? 0);
        $b_price_3 = mysqli_real_escape_string($mysqli, $data->b_price_3 ?? 0);
        $b_price_4 = mysqli_real_escape_string($mysqli, $data->b_price_4 ?? 0);
        $b_price_5 = mysqli_real_escape_string($mysqli, $data->b_price_5 ?? 0);
        $building_company = mysqli_real_escape_string($mysqli, $data->building_company ?? 0);
        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id ?? 0);

        $stmt = "INSERT `houses_types`(`house_name`,`planset_id`,`price_building`,`b_price_1`,`b_price_2`,`b_price_3`,`b_price_4`,`b_price_5`,`building_company_id`,`presentation_id`,`house_description`,`mc_id`,`material_id`,`builders_id`) values('$house_name','$planset_id','$price_building','$b_price_1','$b_price_2','$b_price_3','$b_price_4','$b_price_5','$building_company','$presentation_id','$house_description','$mc_id','$material_id','$building_company')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function edit_planset_measures_info($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);
        $surface = mysqli_real_escape_string($mysqli, $data->surface);
        $width = mysqli_real_escape_string($mysqli, $data->width);
        $length = mysqli_real_escape_string($mysqli, $data->length);
        $height = mysqli_real_escape_string($mysqli, $data->height);
        $sqm_usable_space = mysqli_real_escape_string($mysqli, $data->sqm_usable_space);
        $stories = mysqli_real_escape_string($mysqli, $data->stories);
        $house_id = mysqli_real_escape_string($mysqli, $data->id);

        $stmt = "UPDATE  `houses_types` SET `width`='$width', `length` = '$length', `surface` = '$surface',`height`='$height',`sqm_usable_space`='$sqm_usable_space',`stories`='$stories'  where `house_id`='$house_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function change_planset_status($status, $pres_id)
    {
        $mysqli = $this->dbsuperplan();
        $status = mysqli_real_escape_string($mysqli, $status);
        $pres_id = mysqli_real_escape_string($mysqli, $pres_id);

        $stmt = "UPDATE `houses_types` SET `status` = '$status'  where `house_id`='$pres_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function change_planset_status_for_configurator($status, $pres_id)
    {
        $mysqli = $this->dbsuperplan();
        $status = mysqli_real_escape_string($mysqli, $status);
        $pres_id = mysqli_real_escape_string($mysqli, $pres_id);

        $stmt = "UPDATE `houses_types` SET `configurator` = '$status'  where `house_id`='$pres_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function edit_planset_about_order($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $length = mysqli_real_escape_string($mysqli, $data->length);
        $width = mysqli_real_escape_string($mysqli, $data->width);
        $heigth = mysqli_real_escape_string($mysqli, $data->heigth);
        $presentation_id = mysqli_real_escape_string($mysqli, $data->presentation_id);
        $roof_type = mysqli_real_escape_string($mysqli, $data->roof_type);
        $roof_tilt = mysqli_real_escape_string($mysqli, $data->roof_tilt);
        $stairs = mysqli_real_escape_string($mysqli, $data->stairs);
        $rooms = mysqli_real_escape_string($mysqli, $data->rooms);
        $bedrooms = mysqli_real_escape_string($mysqli, $data->bedrooms);
        $knee_wall = mysqli_real_escape_string($mysqli, $data->knee_wall);
        $bathrooms = mysqli_real_escape_string($mysqli, $data->bathrooms);
        $build_in_garag = mysqli_real_escape_string($mysqli, $data->build_in_garag);
        $id = mysqli_real_escape_string($mysqli, $data->id);

        $stmt = "UPDATE  `o_desc_allproducts` SET `length` = '$length', `width` = '$width', `height` = '$heigth', 
        `roof_type` = '$roof_type', `roof_tilt` = '$roof_tilt' ,`knee_wall` = '$knee_wall' , `stairs_id` = '$stairs', `rooms` = '$rooms', `bedrooms` = '$bedrooms', `bathrooms` = '$bathrooms', `build_in_garag` = '$build_in_garag'  where `o_id`='$presentation_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }


    public function update_o_desc_allproducts($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $length = mysqli_real_escape_string($mysqli, $data->length);
        $width = mysqli_real_escape_string($mysqli, $data->width);
        $roof_type = mysqli_real_escape_string($mysqli, $data->roof_type);
        $roof_tilt = mysqli_real_escape_string($mysqli, $data->roof_tilt);
        $knee_wall = mysqli_real_escape_string($mysqli, $data->knee_wall);
        $stairs_id = mysqli_real_escape_string($mysqli, $data->stairs_id);
        $basement = mysqli_real_escape_string($mysqli, $data->basement);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground);
        $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id);
        $roof_material = mysqli_real_escape_string($mysqli, $data->roof_material);
        $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id);
        $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id);
        $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id);
        $gutter = mysqli_real_escape_string($mysqli, $data->gutter);
        $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture);
        $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id);
        $door_color = mysqli_real_escape_string($mysqli, $data->door_color);
        $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id);
        $gc_length = mysqli_real_escape_string($mysqli, $data->gc_length);
        $gc_width = mysqli_real_escape_string($mysqli, $data->gc_width);
        $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id);
        $gc_height = mysqli_real_escape_string($mysqli, $data->gc_height);

        $stmt = "UPDATE  `o_desc_allproducts` SET `length` = '$length', `width` = '$width', `roof_type` = '$roof_type', `roof_tilt` = '$roof_tilt' ,`basement` = '$basement',`gutter` = '$gutter', `levels_over_ground` = '$levels_over_ground', `rop_id`='$rop_id', `knee_wall`='$knee_wall',`roof_material`='$roof_material',`wlc_id`='$wlc_id',`ww_id`='$ww_id',`wc_id`='$wc_id',`door_texture`='$door_texture',`dsp_id`='$dsp_id',`door_color`='$door_color',`gc_id`='$gc_id',`gc_length`='$gc_length',`gc_width`='$gc_width',`gc_height`='$gc_height',`pbp_id`='$pbp_id', `stairs_id` = '$stairs_id' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    //we might not need this function
    public function show_producer(/*$email,*/ $lic_id)
    {
        $mysqli = $this->dbconnect();
        //$email=mysqli_real_escape_string($mysqli,$email); //might not need the logged in user email just show all producers
        $lic_id = mysqli_real_escape_string($mysqli, $lic_id);
        $uprod_id = mysqli_real_escape_string($mysqli, $uprod_id);
        //$stmt1=mysqli_prepare($mysqli,"select * from `u_creators` where `uca_email`=?");
        //mysqli_stmt_bind_param($stmt1,"s",$email);

        //mysqli_stmt_execute($stmt1);

        //$result=mysqli_stmt_get_result($stmt1);

        //$row1=mysqli_fetch_array($result,MYSQLI_ASSOC);

        $stmt2 = mysqli_prepare($mysqli, "select * from `licences` where `lic_id`=?");
        //$param="%".$row1['lt_id']."%";
        $param = "%" . $uprod_id . "%";
        mysqli_stmt_bind_param($stmt2, "ss", $param, $lic_id);

        mysqli_stmt_execute($stmt2);

        $result2 = mysqli_stmt_get_result($stmt2);


        $row = mysqli_fetch_array($result2, MYSQLI_ASSOC);

        //mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_apus()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `credits-kinds`");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_apu($cd_kind)
    {
        $mysqli = $this->dbconnect();
        $cd_kind = mysqli_real_escape_string($mysqli, $cd_kind);

        $stmt = mysqli_prepare($mysqli, "select * from `credits-kinds` where `cd_kind`=?");
        mysqli_stmt_bind_param($stmt, "i", $cd_kind);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_workstep_credits()
    {
        $mysqli = $this->dbconnect();
        $get_workstep_credits_sql = "select * from  `credits-worksteps-skp`";
        $get_workstep_credits_result = mysqli_query($mysqli, $get_workstep_credits_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($get_workstep_credits_result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_workstep_credit($cdws_id)
    {
        $mysqli = $this->dbconnect();
        $cdws_id = mysqli_real_escape_string($mysqli, $cdws_id);

        $stmt = mysqli_prepare($mysqli, "select * from  `credits-worksteps-skp` where `cdws_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $cdws_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    //order budget

    public function get_order_budget($ucm_budget_id)
    {
        $mysqli = $this->dbconnect();
        $ucm_budget_id = mysqli_real_escape_string($mysqli, $ucm_budget_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main_budgets` where `ucm_budget_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $ucm_budget_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_order_budget()
    {
        $mysqli = $this->dbconnect();

        //$stmt=mysqli_prepare($mysqli,"select * from `u_clients_main_budgets` order by `cl_name_unused` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main_budgets` join `u_clients` where `u_clients_main_budgets`.`client_id`=`u_clients`.`client_ID` and `u_clients`.`c_status`='active' order by `u_clients`.`clientname` asc, `u_clients`.`c_last_name` asc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_clients_ordered_by_clientname()
    {
        $mysqli = $this->dbconnect();

        //$stmt=mysqli_prepare($mysqli,"select * from `u_clients_main_budgets` order by `cl_name_unused` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `u_clients`.`c_status`='active' order by `u_clients`.`clientname` asc, `u_clients`.`c_last_name` asc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_order_budget_by_ls_id($ls_id)
    {
        $mysqli = $this->dbconnect();
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $param = "%" . $ls_id . "%";

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `u_clients_main_budgets` join `u_clients` where `u_clients_main_budgets`.`client_id`=`u_clients`.`client_ID` and `u_clients`.`ls_ids` like ? order by `cl_name_unused` asc");
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_order_budget_by_client_id($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $current_date = date('Y-m-d');

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main_budgets` where `client_id`=? and curdate() between `bs_date` and `be_date`"); //and curdate() between `bs_date` and `be_date`
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_order_budget_for_client_id($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $current_date = date('Y-m-d');

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main_budgets` where `client_id`=? ORDER BY `u_clients_main_budgets`.`be_date` DESC"); //and curdate() between `bs_date` and `be_date`
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function create_order_budget($budget_title, $budget_description, $amount, $client_id, $bs_date, $be_date)
    {
        $mysqli = $this->dbconnect();
        $budget_title = mysqli_real_escape_string($mysqli, $budget_title);
        $budget_description = mysqli_real_escape_string($mysqli, $budget_description);
        $amount = mysqli_real_escape_string($mysqli, $amount);
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $bs_date = mysqli_real_escape_string($mysqli, $bs_date);
        $be_date = mysqli_real_escape_string($mysqli, $be_date);

        $client = $this->get_client($client_id);
        $client_name = $client['l_last_name'] . ", " . $client['l_first_name'];

        $stmt = "insert into `u_clients_main_budgets`(`client_id`,`cl_name_unused`,`amount`,`bs_date`,`be_date`,`budget_name`,`budget_explanation`) values('$client_id','$client_name','$amount','$bs_date','$be_date','$budget_title','$budget_description')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_order_budget($ucm_budget_id, $budget_title, $budget_description, $amount, $client_id, $bs_date, $be_date)
    {
        $mysqli = $this->dbconnect();
        $ucm_budget_id = mysqli_real_escape_string($mysqli, $ucm_budget_id);
        $budget_title = mysqli_real_escape_string($mysqli, $budget_title);
        $budget_description = mysqli_real_escape_string($mysqli, $budget_description);
        $amount = mysqli_real_escape_string($mysqli, $amount);
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $bs_date = mysqli_real_escape_string($mysqli, $bs_date);
        $be_date = mysqli_real_escape_string($mysqli, $be_date);

        $client = $this->get_client($client_id);
        $client_name = $client['l_last_name'] . ", " . $client['l_first_name'];

        $stmt = "update `u_clients_main_budgets` set `client_id`='$client_id',`cl_name_unused`='$client_name',`amount`='$amount',`bs_date`='$bs_date',`be_date`='$be_date',`budget_name`='$budget_title',`budget_explanation`='$budget_description' where `ucm_budget_id`='$ucm_budget_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_orders_by_date_no_o_extension($client_id, $start_date, $end_date)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $start_date = mysqli_real_escape_string($mysqli, $start_date);
        $end_date = mysqli_real_escape_string($mysqli, $end_date);

        // $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `om_id`='0' and `o_date` between ? and ? and `o_status`<='8'");
        // mysqli_stmt_bind_param($stmt, "iss", $client_id, $start_date, $end_date);
        // mysqli_stmt_execute($stmt);

        //$result = mysqli_stmt_get_result($stmt);
        $stmt="select * from `orders` where `u_client_ID`='$client_id' and `om_id`='0' and `o_date` between '$start_date' and '$end_date' and `o_status`<='8'";
        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_orders_by_plot_id($plot_id)
    {
        $mysqli = $this->dbconnect();
        $plot_id = mysqli_real_escape_string($mysqli, $plot_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `plot_id` like '%|$plot_id|%'");
        //mysqli_stmt_bind_param($stmt, "i", $plot_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_plots()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select * from `plots` order by `city`,`street`,`house_no` asc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_plots_reverse_order_by_id()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select * from `plots` order by `plot_id` desc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function update_order_plot_id($o_id, $plot_id)
    {
        $mysqli = $this->dbconnect();
        $plot_id = mysqli_real_escape_string($mysqli, $plot_id);
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `plot_id`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "si", $plot_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_creators_company($email)
    {
        $mysqli = $this->dbconnect();
        $get_creators_company_sql = "select * from `u_licence_takers` where `lt_id`=(select `lt_id` from `u_creators` where `uca_email`='$email')";
        $get_creators_company_result = mysqli_query($mysqli, $get_creators_company_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($get_creators_company_result, MYSQLI_BOTH);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_licence_mailnick($lt_id)
    {
        $mysqli = $this->dbconnect();
        $get_creators_company_sql = "select `mailnick` from `u_licence_takers` where `lt_id`='$lt_id'";
        $get_creators_company_result = mysqli_query($mysqli, $get_creators_company_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($get_creators_company_result, MYSQLI_BOTH);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_cur_factor($order_id)
    {
        $mysqli = $this->dbconnect();
        $get_currency_sql = "select `cur_fac` from `licences` where `lic_id`=(select `lic_ID` from `orders` where `order_ID`='$order_id')";
        $get_currency_result = mysqli_query($mysqli, $get_currency_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($get_currency_result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_licence_taker_by_lic_id($lic_id)
    {
        $mysqli = $this->dbconnect();
        $lic_id = mysqli_real_escape_string($mysqli, $lic_id);

        $licence = $this->get_licence($lic_id);

        $licence_taker = $this->get_company($licence['licence-taker']);

        mysqli_close($mysqli);

        return $licence_taker;
    }

    public function get_licence_taker($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt1 = mysqli_prepare($mysqli, "select * from `orders` where `order_ID`=?");
        mysqli_stmt_bind_param($stmt1, "i", $orderid);

        mysqli_stmt_execute($stmt1);

        $result1 = mysqli_stmt_get_result($stmt1);

        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

        $stmt2 = mysqli_prepare($mysqli, "select * from `licences` where `lic_id`=?");
        mysqli_stmt_bind_param($stmt2, "s", $row1['lic_ID']);

        mysqli_stmt_execute($stmt2);

        $result2 = mysqli_stmt_get_result($stmt2);

        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

        $stmt3 = mysqli_prepare($mysqli, "select * from `u_licence_takers` where `lt_id`=?");

        mysqli_stmt_bind_param($stmt3, "i", $row2['licence-taker']);

        mysqli_stmt_execute($stmt3);

        $result3 = mysqli_stmt_get_result($stmt3);

        $row = mysqli_fetch_array($result3, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_client_orders($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `o_status`<'9' order by `order_ID` DESC");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function coordination_search_by_last_name($c_last_name)
    {
        $mysqli = $this->dbconnect();
        $c_last_name = mysqli_real_escape_string($mysqli, $c_last_name);
        $param = "%" . $c_last_name . "%";

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` right join `orders` on `u_clients`.`client_ID`=`orders`.`u_client_ID` where `u_clients`.`c_last_name` like ? and `orders`.`o_status`<'9' order by `orders`.`order_ID` DESC");
        mysqli_stmt_bind_param($stmt, "s", $c_last_name);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_active_orders_by_order_name($order_name)
    {
        $mysqli = $this->dbconnect();
        $order_name = mysqli_real_escape_string($mysqli, $order_name);

        $param = "%$order_name%";
        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `order_name` like ? and `o_status`<'9' order by `order_ID` DESC");
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_active_orders_by_plot_id($plot_id)
    {
        $mysqli = $this->dbconnect();
        $plot_id = mysqli_real_escape_string($mysqli, $plot_id);

        $param = "%|$plot_id|%";
        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `plot_id` like ? and `o_status`<'9' order by `order_ID` DESC");
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creator_search_orders_by_order_name($uca_id, $order_name)
    {
        $mysqli = $this->dbconnect();
        $order_name = mysqli_real_escape_string($mysqli, $order_name);
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $param = "%$order_name%";
        $stmt = mysqli_prepare($mysqli, "select distinct `o_prods`.`o_id` FROM `o_prods` left join `orders` on `orders`.`order_ID`=`o_prods`.`o_id` WHERE `o_prods`.`uca_id` =? and `orders`.`order_name` like ? and `orders`.`o_status`<'9' order by `o_prods`.`o_id` DESC");
        mysqli_stmt_bind_param($stmt, "is", $uca_id, $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creator_search_orders_by_plot_id($uca_id, $plot_id)
    {
        $mysqli = $this->dbconnect();
        $plot_id = mysqli_real_escape_string($mysqli, $plot_id);
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        //$param = "%$order_name%";
        $stmt = mysqli_prepare($mysqli, "select distinct `o_prods`.`o_id` FROM `o_prods` left join `orders` on `orders`.`order_ID`=`o_prods`.`o_id` WHERE `o_prods`.`uca_id` =? and `orders`.`plot_id`=? and `orders`.`o_status`<'9' order by `o_prods`.`o_id` DESC");
        mysqli_stmt_bind_param($stmt, "ii", $uca_id, $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_licence_taker_info($email)
    {
        $mysqli = $this->dbconnect();
        $get_licence_taker_sql = "select * from `u_licence_takers` where `Email`='$email'";
        $get_licence_taker_result = mysqli_query($mysqli, $get_licence_taker_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($get_licence_taker_result, MYSQLI_BOTH);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_creator($email)
    {
        $mysqli = $this->dbconnect();
        $email = mysqli_real_escape_string($mysqli, $email);

        $stmt = mysqli_prepare($mysqli, "select * from `u_creators` where `uca_email`=?");
        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    /*public function add_creator($lt_id,$uca_name,$uca_address,$uca_email,$phone,$uca_password)
	{
		$mysqli=$this->dbconnect();
		$lt_id=mysqli_real_escape_string($mysqli,$lt_id);
		$uca_name=mysqli_real_escape_string($mysqli,$uca_name);
		$uca_address=mysqli_real_escape_string($mysqli,$uca_address);
		$uca_email=mysqli_real_escape_string($mysqli,$uca_email);
		$phone=mysqli_real_escape_string($mysqli,$phone);
		$uca_password=mysqli_real_escape_string($mysqli,$uca_password);

		$stmt="insert into `u_creators`(`lt_id`,`uca_name`,`uca_address`,`uca_email`,`phone_off`,`uca_password`) values('$lt_id','$uca_name','$uca_address','$uca_email','$phone','$uca_password')";

		mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));

		mysqli_close($mysqli);

	}*/

    public function add_planset($planset_name, $presentation_id, $client_id, $mc_id, $base_price, $price_building, $planset_description, $lang_of_document, $country_planset_made)
    {
        $mysqli = $this->dbsuperplan();
        $planset_name = mysqli_real_escape_string($mysqli, $planset_name);
        $presentation_id = mysqli_real_escape_string($mysqli, $presentation_id);
        $base_price = mysqli_real_escape_string($mysqli, $base_price);
        $price_building = mysqli_real_escape_string($mysqli, $price_building);
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $planset_description = mysqli_real_escape_string($mysqli, $planset_description);
        $lang_of_document = mysqli_real_escape_string($mysqli, $lang_of_document);
        $country_planset_made = mysqli_real_escape_string($mysqli, $country_planset_made);

        $stmt = "INSERT INTO houses_types(house_name,presentation_id,pls_owner,mc_id,base_price,price_building,house_description,lang_of_document,country) VALUES('$planset_name','$presentation_id', '$client_id' ,'$mc_id' ,'$base_price','$price_building','$planset_description','$lang_of_document','$country_planset_made')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }


    /*public function update_creator($uca_id,$lt_id,$uca_name,$uca_address,$uca_email,$phone)
	{
		$mysqli=$this->dbconnect();
		$lt_id=mysqli_real_escape_string($mysqli,$lt_id);
		$uca_name=mysqli_real_escape_string($mysqli,$uca_name);
		$uca_address=mysqli_real_escape_string($mysqli,$uca_address);
		$uca_email=mysqli_real_escape_string($mysqli,$uca_email);
		$phone=mysqli_real_escape_string($mysqli,$phone);
		$uca_id=mysqli_real_escape_string($mysqli,$uca_id);

		$stmt="update `u_creators` set `lt_id`='$lt_id',`uca_name`='$uca_name',`uca_address`='$uca_address',`uca_email`='$uca_email',`phone_off`='$phone' where `uca_id`='$uca_id'";

		mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));

		mysqli_close($mysqli);

    }*/

    public function get_order($id)
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_configurator_lang($o_id)
    {
        $mysqli = $this->dbconnect();

        $ids = explode('.', $o_id);

        if (count($ids) == 2) {
            $o_id = $ids[0];
        }

        $stmt = mysqli_prepare($mysqli, "select `client_language_id` from `orders` where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

//create_order page

    public function calculateProductlabc($prod_id)
    {
        $mysqli = $this->dbconnect();
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $product = $this->get_product($prod_id);

        $cdws_ids = explode(',', $product['cdws_ids']);

        $total_labc = 0;
        //echo count($cdws_ids);
        for ($i = 0; $i < count($cdws_ids); $i++) {

            if (/*(substr($cdws_ids[$i],1)>1300)&&*/ (!empty($cdws_ids[$i]))) {
                $workstep_credit = $this->get_workstep_credit($cdws_ids[$i]);
                if(!empty($workstep_credit['cd_kind']))
                {
                    $credits_kinds = $this->get_apu($workstep_credit['cd_kind']);
                }
                else
                {
                    $credits_kinds = $this->get_apu(0);
                }

                if(!empty($workstep_credit['cd_kind']))
                {
                    $labc = $credits_kinds['labc'] * $workstep_credit['cdk_amount'];
                }
                else
                {
                    $labc = $credits_kinds['labc'] * 0;
                }
                $total_labc += $labc;
            }

        }

        mysqli_close($mysqli);

        return $total_labc;
    }

    public function get_currency($cur_id)
    {
        $mysqli = $this->dbconnect();
        $cur_id = mysqli_real_escape_string($mysqli, $cur_id);

        $stmt = mysqli_prepare($mysqli, "select * from `currencies` where `cur_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $cur_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function get_currency2($cur_short)
    {
        $mysqli = $this->dbconnect();
        $cur_short = mysqli_real_escape_string($mysqli, $cur_short);

        $stmt = mysqli_prepare($mysqli, "select * from `currencies` where `cur_short`=?");
        mysqli_stmt_bind_param($stmt, "s", $cur_short);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_client_colors($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_colors` WHERE `client_id` = ?");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_main_client_colors($mc_id)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_colors` WHERE `mc_id` = ?");
        mysqli_stmt_bind_param($stmt, "i", $mc_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_client_color($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_colors` where `client_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_client_name($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select `c_first_name`, `c_last_name` from `u_clients_colors` where `client_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_client_order_right($col_name, $state, $client_id)
    {
        $mysqli = $this->dbconnect();
        $stmt = "update `u_clients_order_rights` set `$col_name`='$state' where `client_id`='$client_id'";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }


    public function update_client_color($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $color_1 = mysqli_real_escape_string($mysqli, $data->color_1);
        $color_1a = mysqli_real_escape_string($mysqli, $data->color_1a);
        $color_2 = mysqli_real_escape_string($mysqli, $data->color_2);
        $color_3 = mysqli_real_escape_string($mysqli, $data->color_3);
        $color_4 = mysqli_real_escape_string($mysqli, $data->color_4);
        $color_5 = mysqli_real_escape_string($mysqli, $data->color_5);
        $color_6 = mysqli_real_escape_string($mysqli, $data->color_6);

        if ($client_id != 0) {
            $stmt = "update `u_clients_colors` set `color_1`='$color_1',`color_1a`='$color_1a',`color_2`='$color_2',`color_3`='$color_3',`color_4`='$color_4',`color_5`='$color_5',`color_6`='$color_6' where `client_id`='$client_id'";

            $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        }
        mysqli_close($mysqli);
    }

    public function update_main_client_color($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $color_1 = mysqli_real_escape_string($mysqli, $data->color_1);
        $color_1a = mysqli_real_escape_string($mysqli, $data->color_1a);
        $color_2 = mysqli_real_escape_string($mysqli, $data->color_2);
        $color_3 = mysqli_real_escape_string($mysqli, $data->color_3);
        $color_4 = mysqli_real_escape_string($mysqli, $data->color_4);
        $color_5 = mysqli_real_escape_string($mysqli, $data->color_5);
        $color_6 = mysqli_real_escape_string($mysqli, $data->color_6);
        $color_7 = mysqli_real_escape_string($mysqli, $data->color_7);
        $color_8 = mysqli_real_escape_string($mysqli, $data->color_8);
        $color_9 = mysqli_real_escape_string($mysqli, $data->color_9);
        $color_10 = mysqli_real_escape_string($mysqli, $data->color_10);
        $color_11 = mysqli_real_escape_string($mysqli, $data->color_11);
        $font_family = mysqli_real_escape_string($mysqli, $data->font_family);
        $sl_id = mysqli_real_escape_string($mysqli, $data->sl_id);
        $cls_id = mysqli_real_escape_string($mysqli, $data->cls_id);

        if ($mc_id != 0) {
            $stmt = "update `u_clients_colors` set `color_1`='$color_1',`color_1a`='$color_1a',`color_2`='$color_2',`color_3`='$color_3',
            `color_4`='$color_4',`color_5`='$color_5',`color_6`='$color_6',`color_7`='$color_7',`color_8`='$color_8',`color_9`='$color_9',
            `color_10`='$color_10',`color_11`='$color_11',`font_family`='$font_family',`sl_id`='$sl_id',`cls_id`='$cls_id' where `mc_id`='$mc_id'";

            $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        }
        mysqli_close($mysqli);
    }

    public function update_main_client_texts($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $text_1_name = mysqli_real_escape_string($mysqli, $data->text_1_name);
        $text_1_long = mysqli_real_escape_string($mysqli, $data->text_1_long);
        $text_2_name = mysqli_real_escape_string($mysqli, $data->text_2_name);
        $text_2_long = mysqli_real_escape_string($mysqli, $data->text_2_long);
       

        if ($mc_id != 0) {
            $stmt = "update `u_clients_colors` set `text_1_name`='$text_1_name',`text_1_long`='$text_1_long',
            `text_2_name`='$text_2_name',`text_2_long`='$text_2_long'
            where `mc_id`='$mc_id'";

            $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        }
        mysqli_close($mysqli);
    }

    public function update_client_logo($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $logo_path = mysqli_real_escape_string($mysqli, $data->logo_path);
        $favicon_path = mysqli_real_escape_string($mysqli, $data->favicon_path);

        $stmt = "update `u_clients` set `logo_path`='$logo_path',`favicon_path`='$favicon_path' where `client_ID`='$client_id'";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_client_profile_picture($client_id,$profile_picture_link)
    {
        $mysqli = $this->dbconnect();

        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $profile_picture_link = mysqli_real_escape_string($mysqli, $profile_picture_link);

        $this->delete_client_profile_picture($client_id);

        $stmt = "update `u_clients` set `profile_picture_path`='$profile_picture_link' where `client_ID`='$client_id'";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function delete_client_profile_picture($client_id)
    {
        $mysqli = $this->dbconnect();

        $client_id = mysqli_real_escape_string($mysqli, $client_id);        

        $old_profile_picture_path=$this->get_client($client_id);

        if(file_exists("../".$old_profile_picture_path['profile_picture_path']))
        {
            unlink("../".$old_profile_picture_path['profile_picture_path']);
        }

        $stmt = "update `u_clients` set `profile_picture_path`='' where `client_ID`='$client_id'";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_main_client_logo($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $logo_path = mysqli_real_escape_string($mysqli, $data->mc_logo);

        $stmt = "update `u_clients_main` set `mc_logo`='$logo_path' where `mc_id`='$mc_id'";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_main_client_favicon($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);

        $mc_favicon_path = mysqli_real_escape_string($mysqli, $data->mc_favicon_path);

        $stmt = "update `u_clients_main` set `mc_favicon_path`='$mc_favicon_path' where `mc_id`='$mc_id'";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function create_client_color($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $color_1 = mysqli_real_escape_string($mysqli, $data->color_1);
        $color_1a = mysqli_real_escape_string($mysqli, $data->color_1a);
        $color_2 = mysqli_real_escape_string($mysqli, $data->color_2);
        $color_3 = mysqli_real_escape_string($mysqli, $data->color_3);
        $color_4 = mysqli_real_escape_string($mysqli, $data->color_4);
        $color_5 = mysqli_real_escape_string($mysqli, $data->color_5);
        $color_6 = mysqli_real_escape_string($mysqli, $data->color_6);

        $stmt = "insert into `u_clients_colors`(`client_id`,`color_1`,`color_1a`,`color_2`,`color_3`,`color_4`,`color_5`,`color_6`) values('$client_id','$color_1','$color_1a','$color_2','$color_3','$color_4','$color_5','$color_6')";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function create_main_client_color($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id ?? 0);
        $color_1 = mysqli_real_escape_string($mysqli, $data->color_1 ?? '');
        $color_1a = mysqli_real_escape_string($mysqli, $data->color_1a ?? '');
        $color_2 = mysqli_real_escape_string($mysqli, $data->color_2 ?? '');
        $color_3 = mysqli_real_escape_string($mysqli, $data->color_3 ?? '');
        $color_4 = mysqli_real_escape_string($mysqli, $data->color_4 ?? '');
        $color_5 = mysqli_real_escape_string($mysqli, $data->color_5 ?? '');
        $color_6 = mysqli_real_escape_string($mysqli, $data->color_6 ?? '');
        $color_7 = mysqli_real_escape_string($mysqli, $data->color_7 ?? '');
        $color_8 = mysqli_real_escape_string($mysqli, $data->color_8 ?? '');
        $color_9 = mysqli_real_escape_string($mysqli, $data->color_9 ?? '');
        $color_10 = mysqli_real_escape_string($mysqli, $data->color_10 ?? '');
        $color_11 = mysqli_real_escape_string($mysqli, $data->color_11 ?? '');
        $font_family = mysqli_real_escape_string($mysqli, $data->font_family ?? '');
        $sl_id = mysqli_real_escape_string($mysqli, $data->sl_id ?? '');
        $cls_id = mysqli_real_escape_string($mysqli, $data->cls_id ?? '');

        $stmt = "insert into `u_clients_colors`(`mc_id`,`color_1`,`color_1a`,`color_2`,`color_3`,`color_4`,`color_5`,`color_6`,`color_7`,`color_8`,`color_9`,`color_10`,`color_11`,`font_family`,`sl_id`,`cls_id`) values('$mc_id','$color_1','$color_1a','$color_2','$color_3','$color_4','$color_5','$color_6','$color_7','$color_8','$color_9','$color_10','$color_11','$font_family','$sl_id','$cls_id')";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function create_main_client_texts($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $text_1_name = mysqli_real_escape_string($mysqli, $data->text_1_name);
        $text_1_long = mysqli_real_escape_string($mysqli, $data->text_1_long);
        $text_2_name = mysqli_real_escape_string($mysqli, $data->text_2_name);
        $text_2_long = mysqli_real_escape_string($mysqli, $data->text_2_long);

        $stmt = "insert into `u_clients_colors`(`mc_id`,`text_1_name`,`text_1_long`,`text_2_name`,`text_2_long`) values('$mc_id','$text_1_name','$text_1_long','$text_2_name','$text_2_long')";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_all_currencies()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `currencies`");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b3_colorset_examples($sl_id,$cls_id)
    {
        $mysqli = $this->dbdomenia3n();

        $sl_id = mysqli_real_escape_string($mysqli, $sl_id);
        $cls_id = mysqli_real_escape_string($mysqli, $cls_id);

        $stmt =  "select * from `b3-examples` where `sl_id`='$sl_id' and `cls_id`='$cls_id' order by `use_id` asc";

        $result =mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }        

        mysqli_close($mysqli);

        return $rows;
    }

    public function create_order($currentdatetime, $ls_id, $o_extension, $o_deadline_utc, $order_name, $lic_ID, $client_language_id, $mc_id, $u_client_ID, $collection, $o_price, $total_special_agreement_price, $vat_percent, $vat_amount, $vat_a_id, $brut_price, $clients_extras, $client_extras_ex_b5, $op_remarks, $op_remarks_ex_b5, $environment_address, $o_status, $u_prod_id)
    {

        $mysqli = $this->dbconnect();
        $currentdatetime = mysqli_real_escape_string($mysqli, $currentdatetime);
        $o_deadline_utc = mysqli_real_escape_string($mysqli, $o_deadline_utc);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $o_extension = mysqli_real_escape_string($mysqli, $o_extension);
        $order_name = mysqli_real_escape_string($mysqli, $order_name);
        $lic_ID = mysqli_real_escape_string($mysqli, $lic_ID);
        $client_language_id = mysqli_real_escape_string($mysqli, $client_language_id);
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $u_client_ID = mysqli_real_escape_string($mysqli, $u_client_ID);
        $collection = mysqli_real_escape_string($mysqli, $collection);
        $o_price = mysqli_real_escape_string($mysqli, $o_price);
        $total_special_agreement_price = mysqli_real_escape_string($mysqli, $total_special_agreement_price);
        $vat_percent = mysqli_real_escape_string($mysqli, $vat_percent);
        $vat_amount = mysqli_real_escape_string($mysqli, $vat_amount);
        $vat_a_id = mysqli_real_escape_string($mysqli, $vat_a_id);
        $brut_price = mysqli_real_escape_string($mysqli, $brut_price);
        $clients_extras = mysqli_real_escape_string($mysqli, $clients_extras);
        $client_extras_ex_b5 = mysqli_real_escape_string($mysqli, $client_extras_ex_b5);
        $op_remarks = mysqli_real_escape_string($mysqli, $op_remarks);
        $op_remarks_ex_b5 = mysqli_real_escape_string($mysqli, $op_remarks_ex_b5);
        $u_prod_id = mysqli_real_escape_string($mysqli, $u_prod_id);
        $environment_address = mysqli_real_escape_string($mysqli, $environment_address);

        $stmt = "insert into `orders`(`o_date`,`ls_id`,`o_extension`,`o_deadline`,`order_name`,`lic_ID`,`client_language_id`,`mc_id`,`u_client_ID`,`collection`,`o_price`,`o_special_agreement_price`,`vat_percent`,`vat_amount`,`vat_a_id`,`brut_price`,`clients-extras`,`client_extras_ex_b5`,`op-remarks`,`op_remarks_ex_b5`,`environment_address`,`o_status`,`u_prod_id`) values('$currentdatetime','$ls_id','$o_extension','$o_deadline_utc','$order_name','$lic_ID','$client_language_id','$mc_id','$u_client_ID','$collection','$o_price','$total_special_agreement_price','$vat_percent','$vat_amount','$vat_a_id','$brut_price','$clients_extras','$client_extras_ex_b5','$op_remarks','$op_remarks_ex_b5','$environment_address','$o_status','$u_prod_id')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function create_order2($data)
    {

        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $currentdatetime = mysqli_real_escape_string($mysqli, $data->currentdatetime ?? gmdate("Y-m-d H:i:s"));
        $o_deadline_utc = mysqli_real_escape_string($mysqli, $data->o_deadline_utc ?? '0000-00-00 00:00:00');
        $ls_id = mysqli_real_escape_string($mysqli, $data->ls_id ?? 0);
        $om_id = mysqli_real_escape_string($mysqli, $data->om_id ?? 0);
        $order_name = $data->order_name;
        $lic_ID = mysqli_real_escape_string($mysqli, $data->lic_ID ?? 0);
        $cur_id = mysqli_real_escape_string($mysqli, $data->cur_id ?? 0);
        $accepted_by = mysqli_real_escape_string($mysqli, $data->accepted_by ?? 0);
        $client_language_id = mysqli_real_escape_string($mysqli, $data->client_language_id ?? 0);
        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id ?? 0);
        $u_client_ID = mysqli_real_escape_string($mysqli, $data->u_client_ID ?? 0);
        $collection = mysqli_real_escape_string($mysqli, $data->collection ?? '');
        $o_price = mysqli_real_escape_string($mysqli, $data->o_price ?? 0);
        $total_special_agreement_price = mysqli_real_escape_string($mysqli, $data->total_special_agreement_price ?? 0);
        $vat_percent = mysqli_real_escape_string($mysqli, $data->vat_percent ?? 0);
        $vat_amount = mysqli_real_escape_string($mysqli, $data->vat_amount ?? 0);
        $vat_a_id = mysqli_real_escape_string($mysqli, $data->vat_a_id ?? 0);
        $brut_price = mysqli_real_escape_string($mysqli, $data->brut_price ?? 0);
        $clients_extras = mysqli_real_escape_string($mysqli, $data->clients_extras ?? '');
        $client_extras_ex_b5 = mysqli_real_escape_string($mysqli, $data->client_extras_ex_b5 ?? '');
        $op_remarks = mysqli_real_escape_string($mysqli, $data->op_remarks ?? '');
        $op_remarks_ex_b5 = mysqli_real_escape_string($mysqli, $data->op_remarks_ex_b5 ?? '');
        $u_prod_id = mysqli_real_escape_string($mysqli, $data->u_prod_id ?? 0);
        $environment_address = mysqli_real_escape_string($mysqli, $data->environment_address ?? '');        
        $invoice_explanations = mysqli_real_escape_string($mysqli, $data->invoice_explanations ?? '');
        $o_extension = mysqli_real_escape_string($mysqli, $data->o_extension ?? '0');
        $o_correction = mysqli_real_escape_string($mysqli, $data->o_correction ?? 0);
        $o_amendment = mysqli_real_escape_string($mysqli, $data->o_amendment ?? 0);
        $on_stock = mysqli_real_escape_string($mysqli, $data->on_stock ?? 0);
        $public = mysqli_real_escape_string($mysqli, $data->public ?? 0);
        $o_status = mysqli_real_escape_string($mysqli, $data->o_status ?? 0);
        $no_upload_files = mysqli_real_escape_string($mysqli, $data->no_upload_files ?? 0);
        $browser_user_agent = mysqli_real_escape_string($mysqli, $data->browser_user_agent ?? '');

        $stmt = "insert into `orders`(`o_date`,`ls_id`,`om_id`,`o_deadline`,`order_name`,
        `lic_ID`,`cur_id`,`accepted_by`,`client_language_id`,`mc_id`,`u_client_ID`,`collection`,
        `o_price`,`o_special_agreement_price`,`vat_percent`,`vat_amount`,`vat_a_id`,`brut_price`,
        `clients-extras`,`client_extras_ex_b5`,`op-remarks`,`op_remarks_ex_b5`,`environment_address`,
        `invoice_explanations`,`o_extension`,`o_correction`,`o_amendment`,`on_stock`,`public`,`o_status`,`u_prod_id`,
        `browser_user_agent`,`no_upload_files`,`plot_id`,`house_id`,`col_apus`,`col_price`,`col_labc`,`fac_cl`,`o_apus`,`o_special_agreement_price_changed_by`,
        `o_labcs`,`st_id`,`layout_id`,`window_id`,`longitude`,`latitude`,`suntour`,`geoportal_link`,`suntour_link`,`show_on_map`,`vr_link`,`street_view_link`,`commission`,
        `google_earth_link`,`homepage_url`,`domain_homepage_url`,`payment_way`,`materials_order`,`team_id`,`hp_id`) values('$currentdatetime','$ls_id','$om_id','$o_deadline_utc',
        '$order_name','$lic_ID','$cur_id','$accepted_by','$client_language_id','$mc_id',
        '$u_client_ID','$collection','$o_price','$total_special_agreement_price','$vat_percent',
        '$vat_amount','$vat_a_id','$brut_price','$clients_extras','$client_extras_ex_b5',
        '$op_remarks','$op_remarks_ex_b5','$environment_address','$invoice_explanations',
        '$o_extension','$o_correction','$o_amendment','$on_stock','$public','$o_status','$u_prod_id',
        '$browser_user_agent','$no_upload_files','','0','0.0','0.0','0.0','0.0','0.0','0','0.0','','0','0','0.0','0.0','0','','','0','','','',
        '','','','0','0','0','0')";
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function show_last_order()
    {
        $mysqli = $this->dbconnect();
        $sql = "select * from `orders` order by `order_ID` desc limit 0,1";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_owner()
    {
        $mysqli = $this->dbconnect();
        $query = "SELECT * FROM `u_clients` where `house_owner`='1' and `c_status`='active' ORDER BY `l_last_name`  ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_configurator_options()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `configurator_menu` ORDER BY `name`  ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_ho_id($h_id)
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `house_orders_configurator` WHERE `house_id`='$h_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_house_options_list()
    {
        $mysqli = $this->dbsuperplan();
        $query = "SELECT * FROM `h_options_list`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_building_company()
    {
        $mysqli = $this->dbconnect();
        $query = "SELECT * FROM `u_clients` WHERE homepage <> ''  group by clientname ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_building_company2()
    {
        $mysqli = $this->dbconnect();
        $query = "SELECT * FROM `u_clients_builders` LEFT JOIN `u_clients` ON u_clients_builders.client_id = u_clients.client_ID ORDER BY `u_clients`.`clientname` ASC ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_builder_from_mc_id($mc_id)
    {
        $mysqli = $this->dbconnect();

        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $query = "SELECT * FROM `u_clients_builders` where `mc_id`=? ";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $mc_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
           
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_house_types_by_builders_id($builders_id)
    {
        $mysqli = $this->dbsuperplan();
        $builders_id = mysqli_real_escape_string($mysqli, $builders_id);

        $query = "SELECT * FROM `houses_types` WHERE `builders_id` = ? ORDER BY `houses_types`.`house_name` ASC";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $builders_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
        return $rows;
    }

    public function show_last_creator()
    {
        $mysqli = $this->dbconnect();
        $sql = "select * from `u_creators` order by `uca_id` desc limit 0,1";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    public function add_client_rights($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $uca_name = mysqli_real_escape_string($mysqli, $data->uca_name);
        $client = mysqli_real_escape_string($mysqli, $data->client);
        $own_tasks = mysqli_real_escape_string($mysqli, $data->own_tasks);
        $cdesign = mysqli_real_escape_string($mysqli, $data->cdesign);
        $cmeasures = mysqli_real_escape_string($mysqli, $data->cmeasures);
        $change_vat = mysqli_real_escape_string($mysqli, $data->change_vat);
        $view_all_orders = mysqli_real_escape_string($mysqli, $data->view_all_orders);
        $user_admin = mysqli_real_escape_string($mysqli, $data->user_admin);
        $main_client_admin = mysqli_real_escape_string($mysqli, $data->main_client_admin);
        $programs_of_employees = mysqli_real_escape_string($mysqli, $data->programs_of_employees);
        $plots = mysqli_real_escape_string($mysqli, $data->plots);
        $contracting = mysqli_real_escape_string($mysqli, $data->contracting);
        $bookkeeping = mysqli_real_escape_string($mysqli, $data->bookkeeping);
        $coordination = mysqli_real_escape_string($mysqli, $data->coordination);
        $housesets = mysqli_real_escape_string($mysqli, $data->housesets);
        $plansets = mysqli_real_escape_string($mysqli, $data->plansets);
        $activity_view = mysqli_real_escape_string($mysqli, $data->activity_view);
        $apu_list = mysqli_real_escape_string($mysqli, $data->APU_lists);
        $examples_db = mysqli_real_escape_string($mysqli, $data->examples_db);
        $trans_languages = mysqli_real_escape_string($mysqli, $data->trans_languages);
        $tutorials = mysqli_real_escape_string($mysqli, $data->tutorials);

        $stmt = "insert into `u_clients_rights`(`client_id`,`uca_name`,`own_tasks`,`user_admin`,`main_client_admin`,`programs_of_employees`,`contracting`,`cdesign`,`cmeasures`,`change_vat`,`bookkeeping`,`coordination`,`plansets`,`housesets`,`plots`,`view_all_orders`,`activity_view`,`APU_lists`,`examples_db`,`trans_languages`,`tutorials`) values('$client_id','$own_tasks','$uca_name','$user_admin','$main_client_admin','$programs_of_employees','$contracting','$cdesign','$cmeasures','$change_vat','$bookkeeping','$coordination','$plansets','$housesets','$plots','$view_all_orders','$activity_view','$apu_list','$examples_db','$trans_languages','$tutorials')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_client_order_rights($data)
    {
        $mysqli = $this->dbconnect();

        $client_id = $data['client_id'];
        $roof_type = $data['roof_type'];
        $roof_material = $data['roof_material'];
        $roof_tilt = $data['roof_tilt'];
        $roof_overstand = $data['roof_overstand'];
        $knee_wall = $data['knee_wall'];
        $gutters = $data['gutters'];
        $walls_material = $data['walls_material'];
        $walls_second_material = $data['walls_second_material'];
        $windows_material = $data['windows_material'];
        $door_material = $data['door_material'];
        $door_type = $data['door_type'];


        $stmt = "insert into `u_clients_order_rights`
        (`client_id`,`roof_type`,`roof_material`,`roof_tilt`,`roof_overstand`,`knee_wall`,`gutters`,`walls_material`,`walls_second_material`,`windows_material`,`door_material`,`door_type`)
        values
        ('$client_id','$roof_type','$roof_material','$roof_tilt','$roof_overstand','$knee_wall','$gutters','$walls_material','$walls_second_material','$windows_material','$door_material','$door_type')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        print $stmt;

        mysqli_close($mysqli);
    }

    public function update_client_rights_status($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $u_status = mysqli_real_escape_string($mysqli, $data->u_status);

        $stmt = "update `u_clients_rights` set `u_status`='$u_status' where `client_id`='$client_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function insert_client_rights_status($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $u_status = mysqli_real_escape_string($mysqli, $data->u_status);

        $stmt = "insert into `u_clients_rights`(`client_id`,`u_status`) values('$client_id','$u_status')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_creator_languages($uca_id, $ln_id, $skills_level)
    {
        $mysqli = $this->dbconnect();

        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);
        $skills_level = mysqli_real_escape_string($mysqli, $skills_level);

        $stmt = "insert into `u_clients_languages`(`client_id`,`ln_id`,`skills_level`) values('$uca_id','$ln_id','$skills_level')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function delete_creator_languages($uca_id)
    {
        $mysqli = $this->dbconnect();

        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $stmt = "delete from `u_clients_languages` where `client_id`='$uca_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_client_qualifications($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $uca_name = mysqli_real_escape_string($mysqli, $data->uca_name);

        $b1_floorplans = mysqli_real_escape_string($mysqli, $data->b1_floorplans);
        $b1_pictures = mysqli_real_escape_string($mysqli, $data->b1_pictures);
        $b1_360 = mysqli_real_escape_string($mysqli, $data->b1_360);
        $b1_videos = mysqli_real_escape_string($mysqli, $data->b1_videos);
        $b1_base_picture = mysqli_real_escape_string($mysqli, $data->b1_base_picture);
        $b1_masks = mysqli_real_escape_string($mysqli, $data->b1_masks);
        $b1_targets = mysqli_real_escape_string($mysqli, $data->b1_targets);
        $b1_suntour_model = mysqli_real_escape_string($mysqli, $data->b1_suntour_model);
        $b1_vr = mysqli_real_escape_string($mysqli, $data->b1_vr);

        $b3_walls = mysqli_real_escape_string($mysqli, $data->b3_walls);
        $b3_windows_doors = mysqli_real_escape_string($mysqli, $data->b3_windows_doors);
        $b3_furniture = mysqli_real_escape_string($mysqli, $data->b3_furniture);
        $b3_check = mysqli_real_escape_string($mysqli, $data->b3_check);

        $b5_make_object = mysqli_real_escape_string($mysqli, $data->b5_make_object);
        $b5_walls = mysqli_real_escape_string($mysqli, $data->b5_walls);
        $b5_windows_doors = mysqli_real_escape_string($mysqli, $data->b5_windows_doors);
        $b5_furniture = mysqli_real_escape_string($mysqli, $data->b5_furniture);
        $b5_environment = mysqli_real_escape_string($mysqli, $data->b5_environment);
        $b5_render_stills = mysqli_real_escape_string($mysqli, $data->b5_render_stills);
        $b5_render_360 = mysqli_real_escape_string($mysqli, $data->b5_render_360);
        $b5_render_slideshow = mysqli_real_escape_string($mysqli, $data->b5_render_slideshow);
        $b5_render_movie = mysqli_real_escape_string($mysqli, $data->b5_render_movie);
        $b5_2d_configurator = mysqli_real_escape_string($mysqli, $data->b5_2d_configurator);
        $b5_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b5_2d_konfig_renders);
        $b5_3d_configurator = mysqli_real_escape_string($mysqli, $data->b5_3d_configurator);
        $b5_vr = mysqli_real_escape_string($mysqli, $data->b5_vr);
        $b5_check = mysqli_real_escape_string($mysqli, $data->b5_check);

        $b6_make_object = mysqli_real_escape_string($mysqli, $data->b6_make_object);
        $b6_walls = mysqli_real_escape_string($mysqli, $data->b6_walls);
        $b6_windows_doors = mysqli_real_escape_string($mysqli, $data->b6_windows_doors);
        $b6_furniture = mysqli_real_escape_string($mysqli, $data->b6_furniture);
        $b6_environment = mysqli_real_escape_string($mysqli, $data->b6_environment);
        $b6_render_stills = mysqli_real_escape_string($mysqli, $data->b6_render_stills);
        $b6_render_360 = mysqli_real_escape_string($mysqli, $data->b6_render_360);
        $b6_render_slideshow = mysqli_real_escape_string($mysqli, $data->b6_render_slideshow);
        $b6_render_movie = mysqli_real_escape_string($mysqli, $data->b6_render_movie);
        $b6_2d_configurator = mysqli_real_escape_string($mysqli, $data->b6_2d_configurator);
        $b6_premium_pictures = mysqli_real_escape_string($mysqli, $data->b6_premium_pictures);
        $b6_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b6_2d_konfig_renders);
        $b6_3d_configurator = mysqli_real_escape_string($mysqli, $data->b6_3d_configurator);
        $b6_vr = mysqli_real_escape_string($mysqli, $data->b6_vr);
        $b6_check = mysqli_real_escape_string($mysqli, $data->b6_check);

        $b7_make_object = mysqli_real_escape_string($mysqli, $data->b7_make_object);
        $b7_walls = mysqli_real_escape_string($mysqli, $data->b7_walls);
        $b7_windows_doors = mysqli_real_escape_string($mysqli, $data->b7_windows_doors);
        $b7_furniture = mysqli_real_escape_string($mysqli, $data->b7_furniture);
        $b7_environment = mysqli_real_escape_string($mysqli, $data->b7_environment);
        $b7_render_stills = mysqli_real_escape_string($mysqli, $data->b7_render_stills);
        $b7_render_360 = mysqli_real_escape_string($mysqli, $data->b7_render_360);
        $b7_render_slideshow = mysqli_real_escape_string($mysqli, $data->b7_render_slideshow);
        $b7_render_movie = mysqli_real_escape_string($mysqli, $data->b7_render_movie);
        $b7_in_2d_configurator = mysqli_real_escape_string($mysqli, $data->b7_in_2d_configurator);
        $b7_in_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b7_in_2d_konfig_renders);
        $b7_2d_configurator = mysqli_real_escape_string($mysqli, $data->b7_2d_configurator);
        $b7_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b7_2d_konfig_renders);
        $b7_3d_configurator = mysqli_real_escape_string($mysqli, $data->b7_3d_configurator);
        $b7_vr = mysqli_real_escape_string($mysqli, $data->b7_vr);
        $b7_check = mysqli_real_escape_string($mysqli, $data->b7_check);

        $b8_make_object = mysqli_real_escape_string($mysqli, $data->b8_make_object);
        $b8_walls = mysqli_real_escape_string($mysqli, $data->b8_walls);
        $b8_windows_doors = mysqli_real_escape_string($mysqli, $data->b8_windows_doors);
        $b8_furniture = mysqli_real_escape_string($mysqli, $data->b8_furniture);
        $b8_environment = mysqli_real_escape_string($mysqli, $data->b8_environment);
        $b8_render_stills = mysqli_real_escape_string($mysqli, $data->b8_render_stills);
        $b8_render_360 = mysqli_real_escape_string($mysqli, $data->b8_render_360);
        $b8_render_slideshow = mysqli_real_escape_string($mysqli, $data->b8_render_slideshow);
        $b8_render_movie = mysqli_real_escape_string($mysqli, $data->b8_render_movie);
        $b8_2d_configurator = mysqli_real_escape_string($mysqli, $data->b8_2d_configurator);
        $b8_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b8_2d_konfig_renders);
        $b8_3d_configurator = mysqli_real_escape_string($mysqli, $data->b8_3d_configurator);
        $b8_vr = mysqli_real_escape_string($mysqli, $data->b8_vr);
        $b8_check = mysqli_real_escape_string($mysqli, $data->b8_check);

        $stmt = "insert into `u_clients_qualifications`(`client_id`,`uca_name`,`b1_floorplans`,`b1_pictures`,`b1_360`,`b1_videos`,`b1_base_picture`,`b1_masks`,`b1_targets`,`b1_suntour_model`,`b1_vr`,`b3_walls`,`b3_windows_doors`,`b3_furniture`,`b3_check`,`b5_make_object`,`b5_walls`,`b5_windows_doors`, `b5_furniture`,`b5_environment`,`b5_render_stills`,`b5_render_360`,`b5_render_slideshow`,`b5_render_movie`,`b5_2d_configurator`,`b5_2d_konfig_renders`,`b5_3d_configurator`,`b5_vr`,`b5_check`,`b6_make_object`,`b6_walls`,`b6_windows_doors`,`b6_furniture`, `b6_environment`,`b6_render_stills`,`b6_render_360`,`b6_render_slideshow`,`b6_render_movie`,`b6_2d_configurator`,`b6_premium_pictures`,`b6_2d_konfig_renders`,`b6_3d_configurator`,`b6_vr`,`b6_check`,`b7_make_object`,`b7_walls`,`b7_windows_doors`,`b7_furniture`,`b7_environment`,`b7_render_stills`, `b7_render_360`,`b7_render_slideshow`,`b7_render_movie`,`b7_2d_configurator`,`b7_2d_konfig_renders`,`b7_in_2d_configurator`,`b7_in_2d_konfig_renders`,`b7_3d_configurator`,`b7_vr`,`b7_check`,`b8_make_object`,`b8_walls`,`b8_windows_doors`,`b8_furniture`,`b8_environment`,`b8_render_stills`, `b8_render_360`,`b8_render_slideshow`,`b8_render_movie`,`b8_2d_configurator`,`b8_2d_konfig_renders`,`b8_3d_configurator`,`b8_vr`,`b8_check`) values('$client_id','$uca_name','$b1_floorplans','$b1_pictures','$b1_360','$b1_videos','$b1_base_picture','$b1_masks','$b1_targets','$b1_suntour_model','$b1_vr','$b3_walls','$b3_windows_doors','$b3_furniture','$b3_check','$b5_make_object','$b5_walls','$b5_windows_doors','$b5_furniture','$b5_environment','$b5_render_stills','$b5_render_360','$b5_render_slideshow','$b5_render_movie','$b5_2d_configurator','$b5_2d_konfig_renders','$b5_3d_configurator','$b5_vr','$b5_check','$b6_make_object','$b6_walls','$b6_windows_doors','$b6_furniture','$b6_environment','$b6_render_stills','$b6_render_360','$b6_render_slideshow','$b6_render_movie','$b6_2d_configurator','$b6_premium_pictures','$b6_2d_konfig_renders','$b6_3d_configurator','$b6_vr','$b6_check','$b7_make_object','$b7_walls','$b7_windows_doors','$b7_furniture','$b7_environment','$b7_render_stills','$b7_render_360','$b7_render_slideshow','$b7_render_movie','$b7_2d_configurator','$b7_2d_konfig_renders','$b7_in_2d_configurator','$b7_in_2d_konfig_renders','$b7_3d_configurator','$b7_vr','$b7_check','$b8_make_object','$b8_walls','$b8_windows_doors','$b8_furniture','$b8_environment','$b8_render_stills','$b8_render_360','$b8_render_slideshow','$b8_render_movie','$b8_2d_configurator','$b8_2d_konfig_renders','$b8_3d_configurator','$b8_vr','$b8_check')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function get_client_rights($clientid)
    {
        $mysqli = $this->dbconnect();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_rights` where `client_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $clientid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_client_order_rights($clientid)
    {
        $mysqli = $this->dbconnect();
        $clientid = mysqli_real_escape_string($mysqli, 'u_' . $clientid);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_order_rights` where `client_id`='$clientid'");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_client_qualifications($clientid)
    {
        $mysqli = $this->dbconnect();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_qualifications` where `client_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $clientid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_client_languages($clientid, $ln_id)
    {
        $mysqli = $this->dbconnect();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_languages` where `client_id`=? and `ln_id`=?");
        mysqli_stmt_bind_param($stmt, "ii", $clientid, $ln_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }


    public function get_2d_configurator_pictures($o_id)
    {
        $mysqli = $this->dbconnect();

        $ids = explode('.', $o_id);

        if (count($ids) == 2) {
            $o_id = $ids[0];
            $osub_id = $ids[1];
        } else {
            $o_id = $o_id;
            $osub_id = 'x01';
        }


        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `orf_status`='6' and `orf_type_dom`='jpg' and `prod_id` like '%6y' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }


    public function get_all_2d_configurator_pictures($o_id)
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and (`orf_status`='6' or `orf_status`='8') and (`orf_type_dom`='jpg' or `orf_type_dom`='png') and `prod_id` like '%6y' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "i", $o_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }


    public function get_all_3d_configurator_models($o_id)
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `orf_status`='8' and  `orf_type_dom`='glb' and `prod_id` like '%6x' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "i", $o_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function get_2d_configurator_pictures_by_id_and_sub_id($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and (`orf_status`='6' or `orf_status`='8') and `orf_type_dom`='jpg' and `prod_id` like '%6y' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function get_2d_configurator_svg($o_id)
    {
        $mysqli = $this->dbconnect();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`='x01' and `orf_status`='6' and `orf_type_dom`='svg' and `prod_id` like '%6z' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function get_2d_configurator_svgs_by_id_and_sub_id($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `orf_status`='6' and `orf_type_dom`='svg' and `prod_id` like '%6z' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function get_2d_configurator_colors($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `orf_status`='6' and `orf_type_dom`='txt' and `prod_id` like '%6z' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function get_2d_configurator_colors_by_id_and_sub_id($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `orf_status`='6' and `orf_type_dom`='txt' and `prod_id` like '%6z' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function get_roof_material_swatches($ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select `adminhdd_domenia2`.`rm-pics`.`rmp_id`, `adminhdd_domenia2`.`rm-pics`.`rmp_colorname`, `adminhdd_domenia2`.`rm-pics`.`rm_id`, `adminhdd_domenia2`.`rm-pics`.`rmp_pic`, `adminhdd_domenia1`.`x-texts`.`text`, `ho_roof-tiles`.*, `model_materials`.* 
        from `ho_roof-tiles` left join `adminhdd_domenia2`.`rm-pics` on `ho_roof-tiles`.`rmp_id`=`adminhdd_domenia2`.`rm-pics`.`rmp_id` left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_roof-tiles`.`mm_id`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`rm-pics`.`rmp_colorname`
        where `ho_id`=? and `status`='1' and `adminhdd_domenia1`.`x-texts`.`lang_id`='49' 
        order by `ho_roof-tiles`.`price` asc,`adminhdd_domenia2`.`rm-pics`.`rm_id` desc,`model_materials`.`color` desc");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_free_roof_material_swatches()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select * 
        from `adminhdd_superplan`.`ho_roof-tiles` left join `adminhdd_domenia2`.`rm-pics` on `ho_roof-tiles`.`rmp_id`=`adminhdd_domenia2`.`rm-pics`.`rmp_id` left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_roof-tiles`.`mm_id`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`rm-pics`.`rmp_colorname`
        where `price`='0' and `status`='1' and `adminhdd_domenia1`.`x-texts`.`lang_id`='49' and `adminhdd_domenia2`.`rm-pics`.`rm_id`='rm_001' group by `adminhdd_domenia2`.`rm-pics`.`rmp_id`
        order by `ho_roof-tiles`.`price` asc,`adminhdd_domenia2`.`rm-pics`.`rm_id` desc,`model_materials`.`color` desc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }


    public function get_all_roof_materials()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select * 
        from `adminhdd_domenia2`.`rm-pics` left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`rm-pics`.`rmp_colorname`
        and `adminhdd_domenia1`.`x-texts`.`lang_id`='49'
        order by `adminhdd_domenia2`.`rm-pics`.`rm_id` desc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_gutters_swatches($ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select `adminhdd_domenia2`.`gutters`.`gut_id`,`adminhdd_domenia2`.`gutters`.`gut_pic`, `adminhdd_domenia2`.`gutters`.`gut_name_db`, `adminhdd_domenia1`.`x-texts`.`text`, `ho_gutters`.*, `model_materials`.*
        from `ho_gutters` 
        left join `adminhdd_domenia2`.`gutters` on `ho_gutters`.`gut_id`=`adminhdd_domenia2`.`gutters`.`gut_id` 
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_gutters`.`mm_id`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`gutters`.`gut_id`
        where `ho_id`=? and `status`='1' and `adminhdd_domenia1`.`x-texts`.`lang_id`='49' 
        order by `adminhdd_superplan`.`ho_gutters`.`price` asc");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_free_gutters_swatches()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select *
        from `adminhdd_superplan`.`ho_gutters` 
        left join `adminhdd_domenia2`.`gutters` on `ho_gutters`.`gut_id`=`adminhdd_domenia2`.`gutters`.`gut_id` 
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_gutters`.`mm_id`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`gutters`.`gut_id`
        where `price`='0' and `status`='1' and `adminhdd_domenia1`.`x-texts`.`lang_id`='49' 
        group by `adminhdd_superplan`.`ho_gutters`.`gut_id`
        order by `adminhdd_superplan`.`ho_gutters`.`price` asc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_gutters()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia2`.`gutters`
        join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`gutters`.`gut_id`
        where `adminhdd_domenia1`.`x-texts`.`lang_id`='49'");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_walls_swatches($ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select `adminhdd_domenia2`.`colors`.`col_id`, `adminhdd_domenia2`.`colors`.`mm_id`, `adminhdd_domenia2`.`colors`.`hexdec`, `adminhdd_domenia2`.`col-pics`.`clp_id` ,`adminhdd_domenia2`.`col-pics`.`clp_name_db`,`adminhdd_domenia2`.`col-pics`.`clp_pic`, `ho_walls`.*, `model_materials`.*
        from `ho_walls` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_walls`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_domenia2`.`colors`.`mm_id`
        where `ho_id`=? and `status`='1' ");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

//        $walls_response = array();
//        foreach ($rows as $temp) {
//
//            if ($temp['clp_id'] === 'clp_00011') {
//                $walls_response[0] = $temp;
//                $walls_response[0]['order'] = 0;
//            }
//            if ($temp['clp_id'] === 'clp_00031') {
//                $walls_response[1] = $temp;
//                $walls_response[1]['order'] = 1;
//            }
//
//            if ($temp['clp_id'] === 'clp_00071') {
//                $walls_response[2] = $temp;
//                $walls_response[2]['order'] = 2;
//            }
//
//            if ($temp['clp_id'] === 'clp_00041') {
//                $walls_response[3] = $temp;
//                $walls_response[3]['order'] = 3;
//            }
//
//            if ($temp['clp_id'] === 'clp_00051') {
//                $walls_response[4] = $temp;
//                $walls_response[4]['order'] = 4;
//            }
//
//            if ($temp['clp_id'] === 'clp_00081') {
//                $walls_response[5] = $temp;
//                $walls_response[5]['order'] = 5;
//            }
//
//            if ($temp['clp_id'] === 'clp_00061') {
//                $walls_response[6] = $temp;
//                $walls_response[6]['order'] = 6;
//            }
//
//            if ($temp['clp_id'] === 'clp_00151') {
//                $walls_response[7] = $temp;
//                $walls_response[7]['order'] = 7;
//            }
//
//            if ($temp['clp_id'] === 'clp_00141') {
//                $walls_response[8] = $temp;
//                $walls_response[8]['order'] = 8;
//            }
//
//            if ($temp['clp_id'] === 'clp_00111') {
//                $walls_response[9] = $temp;
//                $walls_response[9]['order'] = 9;
//            }
//
//            if ($temp['clp_id'] === 'clp_00131') {
//                $walls_response[10] = $temp;
//                $walls_response[10]['order'] = 10;
//            }
//
//            if ($temp['clp_id'] === 'clp_00191') {
//                $walls_response[11] = $temp;
//                $walls_response[11]['order'] = 11;
//            }
//
//
//        }
//
//        function sortByOrder($a, $b)
//        {
//            return $a['order'] - $b['order'];
//        }
//
//
//        usort($walls_response, 'sortByOrder');
//
//
//        return array_values($walls_response);

        return $rows;
    }

    public function get_free_walls_swatches()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select *
        from `adminhdd_superplan`.`ho_walls` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_walls`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_domenia2`.`colors`.`mm_id`
        where `price`='0' and `status`='1'
        group by `clp_id`");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        $walls_response = array();
        foreach ($rows as $temp) {

            if ($temp['clp_id'] === 'clp_00011') {
                $walls_response[1] = $temp;
                $walls_response[1]['order'] = 0;
            }
            if ($temp['clp_id'] === 'clp_00031') {
                $walls_response[2] = $temp;
                $walls_response[2]['order'] = 1;
            }

            if ($temp['clp_id'] === 'clp_00041') {
                $walls_response[3] = $temp;
                $walls_response[3]['order'] = 3;
            }

            if ($temp['clp_id'] === 'clp_00051') {
                $walls_response[4] = $temp;
                $walls_response[4]['order'] = 4;
            }

            if ($temp['clp_id'] === 'clp_00061') {
                $walls_response[5] = $temp;
                $walls_response[5]['order'] = 6;
            }

            if ($temp['clp_id'] === 'clp_00071') {
                $walls_response[6] = $temp;
                $walls_response[6]['order'] = 2;
            }

            if ($temp['clp_id'] === 'clp_00081') {
                $walls_response[7] = $temp;
                $walls_response[7]['order'] = 5;
            }

            if ($temp['clp_id'] === 'clp_00131') {
                $walls_response[9] = $temp;
                $walls_response[9]['order'] = 10;
            }
            if ($temp['clp_id'] === 'clp_00141') {
                $walls_response[10] = $temp;
                $walls_response[10]['order'] = 8;
            }
            if ($temp['clp_id'] === 'clp_00151') {
                $walls_response[11] = $temp;
                $walls_response[11]['order'] = 7;
            }
            if ($temp['clp_id'] === 'clp_00111') {
                $walls_response[12] = $temp;
                $walls_response[12]['order'] = 9;
            }
            if ($temp['clp_id'] === 'clp_00191') {
                $walls_response[13] = $temp;
                $walls_response[13]['order'] = 11;
            }

        }


        usort($walls_response, 'sortByOrder');


        return array_values($walls_response);

    }

    public function get_walls_second_swatches($ho_id)
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select `adminhdd_domenia2`.`colors`.`col_id`, `adminhdd_domenia2`.`colors`.`hexdec`, `adminhdd_domenia2`.`col-pics`.`clp_pic`, `adminhdd_domenia2`.`col-pics`.`clp_id`,`adminhdd_domenia2`.`col-pics`.`clp_name_db`, `ho_walls-second`.*, `model_materials`.*
        from `ho_walls-second` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_walls-second`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_walls-second`.`mm_id`
        where `ho_id`=? and `status`='1' ");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

//        $walls_response = array();
//        foreach ($rows as $temp) {
//
//            if ($temp['clp_id'] === 'clp_00011') {
//                $walls_response[1] = $temp;
//                $walls_response[1]['order'] = 0;
//            }
//            if ($temp['clp_id'] === 'clp_00031') {
//                $walls_response[2] = $temp;
//                $walls_response[2]['order'] = 1;
//            }
//
//            if ($temp['clp_id'] === 'clp_00041') {
//                $walls_response[3] = $temp;
//                $walls_response[3]['order'] = 3;
//            }
//
//            if ($temp['clp_id'] === 'clp_00051') { // -
//                $walls_response[4] = $temp;
//                $walls_response[4]['order'] = 4;
//            }
//
//            if ($temp['clp_id'] === 'clp_00061') {
//                $walls_response[5] = $temp;
//                $walls_response[5]['order'] = 6;
//            }
//
//            if ($temp['clp_id'] === 'clp_00071') {
//                $walls_response[6] = $temp;
//                $walls_response[6]['order'] = 2;
//            }
//
//            if ($temp['clp_id'] === 'clp_00081') {
//                $walls_response[7] = $temp;
//                $walls_response[7]['order'] = 5;
//            }
//
//            if ($temp['clp_id'] === 'clp_00131') {
//                $walls_response[9] = $temp;
//                $walls_response[9]['order'] = 10;
//            }
//            if ($temp['clp_id'] === 'clp_00141') {
//                $walls_response[10] = $temp;
//                $walls_response[10]['order'] = 8;
//            }
//            if ($temp['clp_id'] === 'clp_00151') {
//                $walls_response[11] = $temp;
//                $walls_response[11]['order'] = 7;
//            }
//            if ($temp['clp_id'] === 'clp_00111') {
//                $walls_response[12] = $temp;
//                $walls_response[12]['order'] = 9;
//            }
//            if ($temp['clp_id'] === 'clp_00191') {
//                $walls_response[13] = $temp;
//                $walls_response[13]['order'] = 11;
//            }
//
//        }
//
//
//        usort($walls_response, 'sortByOrder');
//
//
//        return array_values($walls_response);

        return $rows;
    }

    public function get_free_walls_second_swatches()
    {
        $mysqli = $this->dbsuperplan();


        $stmt = mysqli_prepare($mysqli, "select *
        from `adminhdd_superplan`.`ho_walls-second` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_walls-second`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_walls-second`.`mm_id`
        where `price`='0' and `status`='1'
        group by `clp_id`");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        $walls_response = array();
        foreach ($rows as $temp) {

            if ($temp['clp_id'] === 'clp_00011') {
                $walls_response[1] = $temp;
                $walls_response[1]['order'] = 0;
            }
            if ($temp['clp_id'] === 'clp_00031') {
                $walls_response[2] = $temp;
                $walls_response[2]['order'] = 1;
            }

            if ($temp['clp_id'] === 'clp_00041') {
                $walls_response[3] = $temp;
                $walls_response[3]['order'] = 3;
            }

            if ($temp['clp_id'] === 'clp_00051') {
                $walls_response[4] = $temp;
                $walls_response[4]['order'] = 4;
            }

            if ($temp['clp_id'] === 'clp_00061') {
                $walls_response[5] = $temp;
                $walls_response[5]['order'] = 6;
            }

            if ($temp['clp_id'] === 'clp_00071') {
                $walls_response[6] = $temp;
                $walls_response[6]['order'] = 2;
            }

            if ($temp['clp_id'] === 'clp_00081') {
                $walls_response[7] = $temp;
                $walls_response[7]['order'] = 5;
            }

            if ($temp['clp_id'] === 'clp_00131') {
                $walls_response[9] = $temp;
                $walls_response[9]['order'] = 10;
            }
            if ($temp['clp_id'] === 'clp_00141') {
                $walls_response[10] = $temp;
                $walls_response[10]['order'] = 8;
            }
            if ($temp['clp_id'] === 'clp_00151') {
                $walls_response[11] = $temp;
                $walls_response[11]['order'] = 7;
            }
            if ($temp['clp_id'] === 'clp_00111') {
                $walls_response[12] = $temp;
                $walls_response[12]['order'] = 9;
            }
            if ($temp['clp_id'] === 'clp_00191') {
                $walls_response[13] = $temp;
                $walls_response[13]['order'] = 11;
            }

        }


        usort($walls_response, 'sortByOrder');


        return array_values($walls_response);

    }

    public function get_windows_swatches($ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select `adminhdd_domenia2`.`colors`.`col_id`, `adminhdd_domenia2`.`colors`.`hexdec`, `adminhdd_domenia2`.`col-pics`.`clp_pic`, `adminhdd_domenia2`.`col-pics`.`clp_id`,`adminhdd_domenia2`.`col-pics`.`clp_name_db`, `ho_windows`.*, `model_materials`.*
        from `ho_windows` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_windows`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_windows`.`mm_id`
        where `ho_id`=? and `status`='1' ");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function get_free_windows_swatches()
    {
        $mysqli = $this->dbsuperplan();

        $stmt = mysqli_prepare($mysqli, "select *
        from `adminhdd_superplan`.`ho_windows` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_windows`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_windows`.`mm_id`
        where `adminhdd_superplan`.`ho_windows`.`price`='0' and `status`='1'
        group by `adminhdd_superplan`.`ho_windows`.`col_id`");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function add_sub_id_to_customer_file($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        if(!empty($data->cf_id))
        {
            $cf_id = mysqli_real_escape_string($mysqli, $data->cf_id);
        }
        else
        {
            $cf_id = "";
        }
        if(!empty($data->subo_name))
        {
            $subo_name = mysqli_real_escape_string($mysqli, $data->subo_name);
        }
        else
        {
            $subo_name = "";
        }
        
        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $o_sub_id = mysqli_real_escape_string($mysqli, $data->o_sub_id);

        $stmt = "insert into `orders_subnames`
        (`o_id`,
        `cf_id`,
        `subo_name`,
        `subo_more_infos`,
        `object_type`,
        `e_n_id`,
        `e_x_id`,
        `connection_id`,
        `o_sub_id`) 
        values
        ('$o_id',
        '$cf_id',
        '$subo_name',
        '',
        '0',
        '0',
        '0',
        '',
        '$o_sub_id')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function change_orders_subnames_interior_position($subo_id, $o_sub_id)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);
        $o_sub_id = mysqli_real_escape_string($mysqli, $o_sub_id);

        $stmt = "update `orders_subnames`
        set `o_sub_id`='$o_sub_id' 
        where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function rename_orders_subnames_interior_subo_more_infos($subo_id, $interior_subo_more_infos)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);
        $interior_subo_more_infos = mysqli_real_escape_string($mysqli, $interior_subo_more_infos);

        $stmt = "update `orders_subnames`
        set `subo_more_infos`='$interior_subo_more_infos' 
        where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function rename_orders_subnames_exterior_subo_more_infos($subo_id, $exterior_subo_more_infos)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);
        $exterior_subo_more_infos = mysqli_real_escape_string($mysqli, $exterior_subo_more_infos);

        $stmt = "update `orders_subnames`
        set `subo_more_infos`='$exterior_subo_more_infos' 
        where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function change_orders_subnames_cf_id($subo_id, $cf_id)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);
        $cf_id = mysqli_real_escape_string($mysqli, $cf_id);

        $stmt = "update `orders_subnames`
        set `cf_id`='$cf_id' 
        where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function delete_orders_subnames_subo_id($subo_id)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);

        $stmt = "delete from `orders_subnames` where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function get_last_subid_to_customer_file($of_id)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `of_id` = ? ORDER BY `osn_id` DESC ");
        mysqli_stmt_bind_param($stmt, "i", $of_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function check_existing_subid($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $o_sub_id = mysqli_real_escape_string($mysqli, $data->o_sub_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `o_id` = ? and `o_sub_id` like ?");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $o_sub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_orders_subname($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $subo_id = mysqli_real_escape_string($mysqli, $data->subo_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `subo_id` = ?");
        mysqli_stmt_bind_param($stmt, "i", $subo_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_subids_by_o_id($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `o_id` = ? ORDER BY `o_sub_id` ASC ");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function rename_orders_subnames_file($subo_id, $interior_subname)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);
        $interior_subname = mysqli_real_escape_string($mysqli, $interior_subname);

        $stmt = "update `orders_subnames`
        set `subo_name`='$interior_subname' 
        where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function change_object_type($subo_id, $object_type)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);
        $object_type = mysqli_real_escape_string($mysqli, $object_type);

        $stmt = "update `orders_subnames`
        set `object_type`='$object_type' 
        where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function change_connection_id($subo_id, $connection_id)
    {
        $mysqli = $this->dbconnect();

        $subo_id = mysqli_real_escape_string($mysqli, $subo_id);
        $connection_id = mysqli_real_escape_string($mysqli, $connection_id);

        $stmt = "update `orders_subnames`
        set `connection_id`='$connection_id' 
        where `subo_id`='$subo_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_all_orders_subnames_by_o_id_o_sub_id_cf_id($o_id, $o_sub_id, $cf_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $o_sub_id = mysqli_real_escape_string($mysqli, $o_sub_id);
        $cf_id = mysqli_real_escape_string($mysqli, $cf_id);        

        $stmt = "select * from `orders_subnames` where `o_id`='$o_id' and `o_sub_id`='$o_sub_id' and `cf_id`='$cf_id'";        

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_interior_subids_to_customer_files($of_id)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `of_id` = ? and `osub_id` like 'n%' ORDER BY `osub_id` ASC ");
        mysqli_stmt_bind_param($stmt, "i", $of_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_orders_subnames_interior_subids($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `o_id` = ? and `osub_id` like 'n%' ORDER BY `osub_id` ASC ");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_orders_subnames_exterior_subids($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `o_id` = ? and `osub_id` like 'x%' ORDER BY `osub_id` ASC ");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_exterior_subids_to_customer_files($of_id)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `orders_subnames` WHERE `of_id` = ? and `osub_id` like 'x%' ORDER BY `osub_id` ASC ");
        mysqli_stmt_bind_param($stmt, "i", $of_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_doors_swatches($ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select `adminhdd_domenia2`.`colors`.`col_id`, `adminhdd_domenia2`.`colors`.`hexdec`, `adminhdd_domenia2`.`col-pics`.`clp_pic`, `adminhdd_domenia2`.`col-pics`.`clp_id`,`adminhdd_domenia2`.`col-pics`.`clp_name_db`, `ho_doors`.*, `model_materials`.*
        from `ho_doors` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_doors`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_doors`.`mm_id`
        where `ho_id`=? and `status`='1' 
        order by `adminhdd_domenia2`.`colors`.`hexdec` DESC");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_free_doors_swatches()
    {
        $mysqli = $this->dbsuperplan();


        $stmt = mysqli_prepare($mysqli, "select *
        from `adminhdd_superplan`.`ho_doors` 
        left join `adminhdd_domenia2`.`col-pics` on `ho_doors`.`col_id`=`adminhdd_domenia2`.`col-pics`.`col_id`
        left join `adminhdd_domenia2`.`colors` on `adminhdd_domenia2`.`col-pics`.`col_id`=`adminhdd_domenia2`.`colors`.`col_id`
        left join `model_materials` on `model_materials`.`mm_id`=`adminhdd_superplan`.`ho_doors`.`mm_id`
        where `price`='0' and `status`='1' 
        group by `adminhdd_superplan`.`ho_doors`.`col_id`
        order by `adminhdd_domenia2`.`colors`.`hexdec` DESC");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_door_shape_swatches($ho_id)
    {
        $mysqli = $this->dbsuperplan();
        $clientid = mysqli_real_escape_string($mysqli, $clientid);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select adminhdd_domenia2`.`door-shapes`.`ds_name_db`, `adminhdd_domenia2`.`door-shapes`.`ds_name_world`, adminhdd_domenia2`.`ds-pics`.`dsp_id`, `adminhdd_domenia2`.`ds-pics`.`dsp_pic`,  `adminhdd_domenia2`.`ds-pics`.`me_ids`, `adminhdd_domenia1`.`x-texts`.`text`, `adminhdd_superplan`.`ho_door-shape`.*
        from `ho_door-shape` 
        left join `adminhdd_domenia2`.`ds-pics` on `adminhdd_superplan`.`ho_door-shape`.`dsp_id`=`adminhdd_domenia2`.`ds-pics`.`dsp_id`
        left join `adminhdd_domenia2`.`door-shapes` on `adminhdd_domenia2`.`door-shapes`.`ds_id`=`adminhdd_domenia2`.`ds-pics`.`ds_id`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`door-shapes`.`ds_name_world`
        where `ho_id`=? and `status`='1' and `adminhdd_domenia1`.`x-texts`.`lang_id`='1'
        order by `adminhdd_superplan`.`ho_door-shape`.`price` ASC,`adminhdd_superplan`.`ho_door-shape`.`ho_ds_id` ASC");
        mysqli_stmt_bind_param($stmt, "s", $ho_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_free_door_shape_swatches()
    {
        $mysqli = $this->dbsuperplan();


        $stmt = mysqli_prepare($mysqli, "select *
        from `adminhdd_superplan`.`ho_door-shape` 
        left join `adminhdd_domenia2`.`ds-pics` on `adminhdd_superplan`.`ho_door-shape`.`dsp_id`=`adminhdd_domenia2`.`ds-pics`.`dsp_id`
        left join `adminhdd_domenia2`.`door-shapes` on `adminhdd_domenia2`.`door-shapes`.`ds_id`=`adminhdd_domenia2`.`ds-pics`.`ds_id`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`door-shapes`.`ds_name_world`
        where  `status`='1' and `adminhdd_domenia1`.`x-texts`.`lang_id`='1'
        group by `adminhdd_superplan`.`ho_door-shape`.`dsp_id`
        order by `adminhdd_superplan`.`ho_door-shape`.`price` ASC,`adminhdd_superplan`.`ho_door-shape`.`ho_ds_id` ASC");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_door_shapes()
    {
        $mysqli = $this->dbsuperplan();


        $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia2`.`door-shapes`
        left join `adminhdd_domenia2`.`ds-pics` on `adminhdd_domenia2`.`door-shapes`.`ds_id`=`adminhdd_domenia2`.`ds-pics`.`ds_id`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`door-shapes`.`ds_name_world`
        where `adminhdd_domenia1`.`x-texts`.`lang_id`='1'");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_plot_borders()
    {
        $mysqli = $this->dbsuperplan();


        $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia2`.`pb-pics`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`pb-pics`.`pbp_look_world`
        where `adminhdd_domenia1`.`x-texts`.`lang_id`='1'");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_roof_overstands()
    {
        $mysqli = $this->dbsuperplan();


        $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia2`.`ro-pics`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`ro-pics`.`ro_look_world`
        where `adminhdd_domenia1`.`x-texts`.`lang_id`='1'");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }


    public function get_all_walls_wood()
    {
        $mysqli = $this->dbsuperplan();


        $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia2`.`waw-pics`
        left join `adminhdd_domenia1`.`x-texts` on `adminhdd_domenia1`.`x-texts`.`text_id`=`adminhdd_domenia2`.`waw-pics`.`wwp_name_world`
        where `adminhdd_domenia1`.`x-texts`.`lang_id`='1'");


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }



    /*public function get_creator_qualifications($creatorid)
	{
		$mysqli=$this->dbconnect();
		$creatorid=mysqli_real_escape_string($mysqli,$creatorid);

		$stmt=mysqli_prepare($mysqli,"select * from `u_creators_qualifications` where `uca_id`=?");
		mysqli_stmt_bind_param($stmt,"i",$creatorid);

		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);

		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $row;
    }*/

    /*public function get_creator_languages($creatorid,$ln_id)
	{
		$mysqli=$this->dbconnect();
		$creatorid=mysqli_real_escape_string($mysqli,$creatorid);
		$ln_id=mysqli_real_escape_string($mysqli,$ln_id);

		$stmt=mysqli_prepare($mysqli,"select * from `u_creators_languages` where `uca_id`=? and `ln_id`=?");
		mysqli_stmt_bind_param($stmt,"ii",$creatorid,$ln_id);

		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);

		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $row;
    }*/

    public function update_planset($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);

        $pls_id = mysqli_real_escape_string($mysqli, $data->pls_id);
        $pls_presentation_id = mysqli_real_escape_string($mysqli, $data->pls_presentation_id);
        $pls_owner = mysqli_real_escape_string($mysqli, $data->pls_owner);
        $pls_owner1 = mysqli_real_escape_string($mysqli, $data->pls_owner1);
        $pls_name = mysqli_real_escape_string($mysqli, $data->pls_name);
        $pls_description = mysqli_real_escape_string($mysqli, $data->pls_description);
        $pls_depth = mysqli_real_escape_string($mysqli, $data->pls_depth);
        $pls_width = mysqli_real_escape_string($mysqli, $data->pls_width);
        $pls_height = mysqli_real_escape_string($mysqli, $data->pls_height);
        $pls_surface = mysqli_real_escape_string($mysqli, $data->pls_surface);
        $pls_price = mysqli_real_escape_string($mysqli, $data->pls_price);

        $stmt = "update `plansets` set `pls_presentation_id`='$pls_presentation_id',`pls_owner`='$pls_owner',`pls_owner1`='$pls_owner1',`pls_name`='$pls_name',`pls_description`='$pls_description',`pls_depth`='$pls_depth',`pls_width`='$pls_width',`pls_height`='$pls_height',`pls_surface`='$pls_surface',`pls_price`='$pls_price' where `pls_id`='$pls_id'";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_client_rights($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $uca_name = mysqli_real_escape_string($mysqli, $data->uca_name ?? '');
        $client = mysqli_real_escape_string($mysqli, $data->client ?? 0);
        $own_tasks = mysqli_real_escape_string($mysqli, $data->own_tasks ?? 0);
        $view_all_orders = mysqli_real_escape_string($mysqli, $data->view_all_orders ?? 0);
        $user_admin = mysqli_real_escape_string($mysqli, $data->user_admin ?? 0);
        $main_client_admin = mysqli_real_escape_string($mysqli, $data->main_client_admin ?? 0);
        $cdesign = mysqli_real_escape_string($mysqli, $data->cdesign ?? 0);
        $cmeasures = mysqli_real_escape_string($mysqli, $data->cmeasures ?? 0);
        $change_vat = mysqli_real_escape_string($mysqli, $data->change_vat ?? 0);
        $programs_of_employees = mysqli_real_escape_string($mysqli, $data->programs_of_employees ?? 0);
        $plots = mysqli_real_escape_string($mysqli, $data->plots ?? 0);
        $contracting = mysqli_real_escape_string($mysqli, $data->contracting ?? 0);
        $bookkeeping = mysqli_real_escape_string($mysqli, $data->bookkeeping ?? 0);
        $coordination = mysqli_real_escape_string($mysqli, $data->coordination ?? 0);
        $housesets = mysqli_real_escape_string($mysqli, $data->housesets ?? 0);
        $plansets = mysqli_real_escape_string($mysqli, $data->plansets ?? 0);
        $activity_view = mysqli_real_escape_string($mysqli, $data->activity_view ?? 0);
        $apu_list = mysqli_real_escape_string($mysqli, $data->APU_lists ?? 0);
        $examples_db = mysqli_real_escape_string($mysqli, $data->examples_db ?? 0);
        $trans_languages = mysqli_real_escape_string($mysqli, $data->trans_languages ?? 0);
        $tutorials = mysqli_real_escape_string($mysqli, $data->tutorials ?? 0);

        $stmt = "update `u_clients_rights` set `uca_name`='$uca_name',`own_tasks`='$own_tasks',`client`='$client',`plansets`='$plansets',`housesets`='$housesets',`plots`='$plots',`view_all_orders`='$view_all_orders',`user_admin`='$user_admin',`main_client_admin`='$main_client_admin',`cdesign`='$cdesign',`cmeasures`='$cmeasures',`change_vat`='$change_vat',`programs_of_employees`='$programs_of_employees',`contracting`='$contracting',`bookkeeping`='$bookkeeping',`coordination`='$coordination',`activity_view`='$activity_view',`APU_lists`='$apu_list',`examples_db`='$examples_db',`trans_languages`='$trans_languages',`tutorials`='$tutorials' where `client_id`='$client_id'";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_creator_languages($uca_id, $ln_id, $skills_level)
    {
        $mysqli = $this->dbconnect();

        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);
        $skills_level = mysqli_real_escape_string($mysqli, $skills_level);

        $stmt = "update `u_creators_languages` set `skills_level`='$skills_level' where `uca_id`='$uca_id' and `ln_id`='$ln_id'";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_client_qualifications($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $uca_name = mysqli_real_escape_string($mysqli, $data->uca_name);

        $b1_floorplans = mysqli_real_escape_string($mysqli, $data->b1_floorplans);
        $b1_pictures = mysqli_real_escape_string($mysqli, $data->b1_pictures);
        $b1_360 = mysqli_real_escape_string($mysqli, $data->b1_360);
        $b1_videos = mysqli_real_escape_string($mysqli, $data->b1_videos);
        $b1_base_picture = mysqli_real_escape_string($mysqli, $data->b1_base_picture);
        $b1_masks = mysqli_real_escape_string($mysqli, $data->b1_masks);
        $b1_targets = mysqli_real_escape_string($mysqli, $data->b1_targets);
        $b1_suntour_model = mysqli_real_escape_string($mysqli, $data->b1_suntour_model);
        $b1_vr = mysqli_real_escape_string($mysqli, $data->b1_vr);

        $b3_walls = mysqli_real_escape_string($mysqli, $data->b3_walls);
        $b3_windows_doors = mysqli_real_escape_string($mysqli, $data->b3_windows_doors);
        $b3_furniture = mysqli_real_escape_string($mysqli, $data->b3_furniture);
        $b3_check = mysqli_real_escape_string($mysqli, $data->b3_check);

        $b5_make_object = mysqli_real_escape_string($mysqli, $data->b5_make_object);
        $b5_walls = mysqli_real_escape_string($mysqli, $data->b5_walls);
        $b5_windows_doors = mysqli_real_escape_string($mysqli, $data->b5_windows_doors);
        $b5_furniture = mysqli_real_escape_string($mysqli, $data->b5_furniture);
        $b5_environment = mysqli_real_escape_string($mysqli, $data->b5_environment);
        $b5_render_stills = mysqli_real_escape_string($mysqli, $data->b5_render_stills);
        $b5_render_360 = mysqli_real_escape_string($mysqli, $data->b5_render_360);
        $b5_render_slideshow = mysqli_real_escape_string($mysqli, $data->b5_render_slideshow);
        $b5_render_movie = mysqli_real_escape_string($mysqli, $data->b5_render_movie);
        $b5_2d_configurator = mysqli_real_escape_string($mysqli, $data->b5_2d_configurator);
        $b5_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b5_2d_konfig_renders);
        $b5_3d_configurator = mysqli_real_escape_string($mysqli, $data->b5_3d_configurator);
        $b5_vr = mysqli_real_escape_string($mysqli, $data->b5_vr);
        $b5_check = mysqli_real_escape_string($mysqli, $data->b5_check);

        $b6_make_object = mysqli_real_escape_string($mysqli, $data->b6_make_object);
        $b6_walls = mysqli_real_escape_string($mysqli, $data->b6_walls);
        $b6_windows_doors = mysqli_real_escape_string($mysqli, $data->b6_windows_doors);
        $b6_furniture = mysqli_real_escape_string($mysqli, $data->b6_furniture);
        $b6_environment = mysqli_real_escape_string($mysqli, $data->b6_environment);
        $b6_render_stills = mysqli_real_escape_string($mysqli, $data->b6_render_stills);
        $b6_render_360 = mysqli_real_escape_string($mysqli, $data->b6_render_360);
        $b6_render_slideshow = mysqli_real_escape_string($mysqli, $data->b6_render_slideshow);
        $b6_render_movie = mysqli_real_escape_string($mysqli, $data->b6_render_movie);
        $b6_2d_configurator = mysqli_real_escape_string($mysqli, $data->b6_2d_configurator);
        $b6_premium_pictures = mysqli_real_escape_string($mysqli, $data->b6_premium_pictures);
        $b6_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b6_2d_konfig_renders);
        $b6_3d_configurator = mysqli_real_escape_string($mysqli, $data->b6_3d_configurator);
        $b6_vr = mysqli_real_escape_string($mysqli, $data->b6_vr);
        $b6_check = mysqli_real_escape_string($mysqli, $data->b6_check);

        $b7_make_object = mysqli_real_escape_string($mysqli, $data->b7_make_object);
        $b7_walls = mysqli_real_escape_string($mysqli, $data->b7_walls);
        $b7_windows_doors = mysqli_real_escape_string($mysqli, $data->b7_windows_doors);
        $b7_furniture = mysqli_real_escape_string($mysqli, $data->b7_furniture);
        $b7_environment = mysqli_real_escape_string($mysqli, $data->b7_environment);
        $b7_render_stills = mysqli_real_escape_string($mysqli, $data->b7_render_stills);
        $b7_render_360 = mysqli_real_escape_string($mysqli, $data->b7_render_360);
        $b7_render_slideshow = mysqli_real_escape_string($mysqli, $data->b7_render_slideshow);
        $b7_render_movie = mysqli_real_escape_string($mysqli, $data->b7_render_movie);
        $b7_in_2d_configurator = mysqli_real_escape_string($mysqli, $data->b7_in_2d_configurator);
        $b7_in_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b7_in_2d_konfig_renders);
        $b7_2d_configurator = mysqli_real_escape_string($mysqli, $data->b7_2d_configurator);
        $b7_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b7_2d_konfig_renders);
        $b7_3d_configurator = mysqli_real_escape_string($mysqli, $data->b7_3d_configurator);
        $b7_vr = mysqli_real_escape_string($mysqli, $data->b7_vr);
        $b7_check = mysqli_real_escape_string($mysqli, $data->b7_check);

        $b8_make_object = mysqli_real_escape_string($mysqli, $data->b8_make_object);
        $b8_walls = mysqli_real_escape_string($mysqli, $data->b8_walls);
        $b8_windows_doors = mysqli_real_escape_string($mysqli, $data->b8_windows_doors);
        $b8_furniture = mysqli_real_escape_string($mysqli, $data->b8_furniture);
        $b8_environment = mysqli_real_escape_string($mysqli, $data->b8_environment);
        $b8_render_stills = mysqli_real_escape_string($mysqli, $data->b8_render_stills);
        $b8_render_360 = mysqli_real_escape_string($mysqli, $data->b8_render_360);
        $b8_render_slideshow = mysqli_real_escape_string($mysqli, $data->b8_render_slideshow);
        $b8_render_movie = mysqli_real_escape_string($mysqli, $data->b8_render_movie);
        $b8_2d_configurator = mysqli_real_escape_string($mysqli, $data->b8_2d_configurator);
        $b8_2d_konfig_renders = mysqli_real_escape_string($mysqli, $data->b8_2d_konfig_renders);
        $b8_3d_configurator = mysqli_real_escape_string($mysqli, $data->b8_3d_configurator);
        $b8_vr = mysqli_real_escape_string($mysqli, $data->b8_vr);
        $b8_check = mysqli_real_escape_string($mysqli, $data->b8_check);

        $stmt = "update `u_clients_qualifications` 
        set 
        `uca_name`='$uca_name',
        `b1_floorplans`='$b1_floorplans',
        `b1_pictures`='$b1_pictures',
        `b1_360`='$b1_360',
        `b1_videos`='$b1_videos',
        `b1_base_picture`='$b1_base_picture',
        `b1_masks`='$b1_masks',
        `b1_targets`='$b1_targets',
        `b1_suntour_model`='$b1_suntour_model',
        `b1_vr`='$b1_vr',
        `b3_walls`='$b3_walls',
        `b3_windows_doors`='$b3_windows_doors',
        `b3_furniture`='$b3_furniture',
        `b3_check`='$b3_check',
        `b5_make_object`='$b5_make_object',
        `b5_walls`='$b5_walls',
        `b5_windows_doors`='$b5_windows_doors',
        `b5_furniture`='$b5_furniture',
        `b5_environment`='$b5_environment',
        `b5_render_stills`='$b5_render_stills',
        `b5_render_360`='$b5_render_360',
        `b5_render_slideshow`='$b5_render_slideshow',
        `b5_render_movie`='$b5_render_movie',
        `b5_2d_configurator`='$b5_2d_configurator',
        `b5_2d_konfig_renders`='$b5_2d_konfig_renders',
        `b5_3d_configurator`='$b5_3d_configurator',
        `b5_vr`='$b5_vr',
        `b5_check`='$b5_check',
        `b6_make_object`='$b6_make_object',
        `b6_walls`='$b6_walls',
        `b6_windows_doors`='$b6_windows_doors',
        `b6_furniture`='$b6_furniture',
        `b6_environment`='$b6_environment',
        `b6_render_stills`='$b6_render_stills',
        `b6_render_360`='$b6_render_360',
        `b6_render_slideshow`='$b6_render_slideshow',
        `b6_render_movie`='$b6_render_movie',
        `b6_2d_configurator`='$b6_2d_configurator',
        `b6_premium_pictures`='$b6_premium_pictures',
        `b6_2d_konfig_renders`='$b6_2d_konfig_renders',
        `b6_3d_configurator`='$b6_3d_configurator',
        `b6_vr`='$b6_vr',
        `b6_check`='$b6_check',
        `b7_make_object`='$b7_make_object',
        `b7_walls`='$b7_walls',
        `b7_windows_doors`='$b7_windows_doors',
        `b7_furniture`='$b7_furniture',
        `b7_environment`='$b7_environment',
        `b7_render_stills`='$b7_render_stills',
        `b7_render_360`='$b7_render_360',
        `b7_render_slideshow`='$b7_render_slideshow',
        `b7_render_movie`='$b7_render_movie',
        `b7_in_2d_configurator`='$b7_in_2d_configurator',
        `b7_in_2d_konfig_renders`='$b7_in_2d_konfig_renders',
        `b7_2d_configurator`='$b7_2d_configurator',
        `b7_2d_konfig_renders`='$b7_2d_konfig_renders',
        `b7_3d_configurator`='$b7_3d_configurator',
        `b7_vr`='$b7_vr',
        `b7_check`='$b7_check',
        `b8_make_object`='$b8_make_object',
        `b8_walls`='$b8_walls',
        `b8_windows_doors`='$b8_windows_doors',
        `b8_furniture`='$b8_furniture',
        `b8_environment`='$b8_environment',
        `b8_render_stills`='$b8_render_stills',
        `b8_render_360`='$b8_render_360',
        `b8_render_slideshow`='$b8_render_slideshow',
        `b8_render_movie`='$b8_render_movie',
        `b8_2d_configurator`='$b8_2d_configurator',
        `b8_2d_konfig_renders`='$b8_2d_konfig_renders',
        `b8_3d_configurator`='$b8_3d_configurator',
        `b8_vr`='$b8_vr',
        `b8_check`='$b8_check'
            where 
            `client_id`='$client_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    


    function save_planset($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);

        $pls_presentation_id = mysqli_real_escape_string($mysqli, $data->pls_presentation_id);
        $pls_owner = mysqli_real_escape_string($mysqli, $data->pls_owner);
        $pls_owner1 = mysqli_real_escape_string($mysqli, $data->pls_owner1);
        $pls_name = mysqli_real_escape_string($mysqli, $data->pls_name);
        $pls_description = mysqli_real_escape_string($mysqli, $data->pls_description);
        $pls_depth = mysqli_real_escape_string($mysqli, $data->pls_depth);
        $pls_width = mysqli_real_escape_string($mysqli, $data->pls_width);
        $pls_height = mysqli_real_escape_string($mysqli, $data->pls_height);
        $pls_surface = mysqli_real_escape_string($mysqli, $data->pls_surface);
        $pls_price = mysqli_real_escape_string($mysqli, $data->pls_price);

        $stmt = "insert into `plansets`(`pls_presentation_id`,`pls_owner`,`pls_owner1`,`pls_name`,`pls_description`,`pls_depth`,`pls_width`,`pls_height`,`pls_surface`,`pls_price`) 
        values('$pls_presentation_id','$pls_owner','$pls_owner1','$pls_name','$pls_description','$pls_depth','$pls_width','$pls_height','$pls_surface','$pls_price')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    function add_order_files($o_id, $of_level,$of_kind, $of_subtitle, $of_position, $of_exterior_position, $of_name_client, $of_path_dom, $of_internal_name_dom, $of_type_dom)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $of_kind = mysqli_real_escape_string($mysqli, $of_kind ?? '0');
        $of_subtitle = mysqli_real_escape_string($mysqli, $of_subtitle);
        $of_position = mysqli_real_escape_string($mysqli, $of_position);
        $of_exterior_position = mysqli_real_escape_string($mysqli, $of_exterior_position);
        $of_name_client = mysqli_real_escape_string($mysqli, $of_name_client);
        $of_path_dom = mysqli_real_escape_string($mysqli, $of_path_dom);
        $of_internal_name_dom = mysqli_real_escape_string($mysqli, $of_internal_name_dom);
        $of_type_dom = mysqli_real_escape_string($mysqli, $of_type_dom);
        $of_level = mysqli_real_escape_string($mysqli, $of_level);

        $stmt = "insert into `o_files`(`o_id`,`osn_id`,`of_level`,`of_name`,`of_name_ex`,`of_kind`,`of_subtitle`,`of_position`,`of_exterior_position`,`of_name_client`,`of_path_dom`,`of_internal_name_dom`,`of_type_dom`,`of_upload_date_time`) 
        values('$o_id','','$of_level','','','$of_kind','$of_subtitle','$of_position','$of_exterior_position','$of_name_client','$of_path_dom','$of_internal_name_dom','$of_type_dom','0000-00-00 00:00:00')";        

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        
        mysqli_close($mysqli);
    }

    function add_order_files2($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $of_kind = mysqli_real_escape_string($mysqli, $data->of_kind ?? '0');
        $of_subtitle = mysqli_real_escape_string($mysqli, $data->of_subtitle ?? '');
        $temp_assigned_subids = mysqli_real_escape_string($mysqli, $data->temp_assigned_subids ?? '');
        $of_position = mysqli_real_escape_string($mysqli, $data->of_position ?? '0');
        $of_exterior_position = mysqli_real_escape_string($mysqli, $data->of_exterior_position ?? '0');
        $of_name_client = mysqli_real_escape_string($mysqli, $data->of_name_client ?? '');
        $of_name = mysqli_real_escape_string($mysqli, $data->of_name ?? '');
        $of_name_ex = mysqli_real_escape_string($mysqli, $data->of_name_ex ?? '');
        $of_level = mysqli_real_escape_string($mysqli, $data->of_level ?? '0');
        $of_path_dom = mysqli_real_escape_string($mysqli, $data->of_path_dom ?? '');
        $of_internal_name_dom = mysqli_real_escape_string($mysqli, $data->of_internal_name_dom ?? '');
        $of_type_dom = mysqli_real_escape_string($mysqli, $data->of_type_dom ?? '');

        $stmt = "insert into `o_files`(`o_id`,`osn_id`,`of_level`,`temp_assigned_subids`,`of_name`,`of_name_ex`,`of_kind`,`of_subtitle`,`of_position`,`of_exterior_position`,`of_name_client`,`of_path_dom`,`of_internal_name_dom`,`of_type_dom`,`of_upload_date_time`) 
        values('$o_id','','$of_level','$temp_assigned_subids','','','$of_kind','$of_subtitle','$of_position','$of_exterior_position','$of_name_client','$of_path_dom','$of_internal_name_dom','$of_type_dom','0000-00-00 00:00:00')";        

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_special_price($mc_id)
    {
        $mysqli = $this->dbconnect();
        $sql = "select * from `prices_special` where `mc_id`='$mc_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }


//end create_order page

    public function get_product($id)
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);

        $stmt = mysqli_prepare($mysqli, "select * from `products` where `prod_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_status($id)
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_status` where `ost_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_status_like($id)
    {
        $mysqli = $this->dbconnect();
        $id = mysqli_real_escape_string($mysqli, $id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_status` where `ost_id` LIKE ?");
        mysqli_stmt_bind_param($stmt, "s", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function show_creators($lt_id)
    {
        $mysqli = $this->dbconnect();
        $lt_id = mysqli_real_escape_string($mysqli, $lt_id);

        //$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? order by `lt_id`,`uca_name` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `u_clients`.`lt_id`=? and `u_clients_rights`.`u_status`='active' order by `u_clients`.`c_first_name` asc");

        mysqli_stmt_bind_param($stmt, "i", $lt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creators_names($lt_id)
    {
        $mysqli = $this->dbconnect();
        $lt_id = mysqli_real_escape_string($mysqli, $lt_id);

        //$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? order by `lt_id`,`uca_name` asc");
//        $stmt = mysqli_prepare($mysqli, "select `u_clients`.`client_ID`, `c_first_name`, `c_last_name`, `l_first_name`, `l_last_name` from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `u_clients`.`lt_id`=? and `u_clients_rights`.`u_status`='active' order by `u_clients`.`c_first_name` asc");
        $stmt = mysqli_prepare($mysqli, "select `u_clients`.`client_ID`, `c_first_name`, `c_last_name` from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `u_clients`.`lt_id`=? and `u_clients_rights`.`u_status`='active' order by `u_clients`.`c_first_name` asc");

        mysqli_stmt_bind_param($stmt, "i", $lt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creators_order_by_id($lt_id)
    {
        $mysqli = $this->dbconnect();
        $lt_id = mysqli_real_escape_string($mysqli, $lt_id);

        //$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? order by `lt_id`,`uca_name` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `lt_id`=? and `own_tasks`='1' order by `u_clients`.`client_ID` DESC");

        mysqli_stmt_bind_param($stmt, "i", $lt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_clients_by_ls_ids_order_by_id($ls_ids_array)
    {

        $mysqli = $this->dbconnect();

        // $ls_ids=implode(",",$ls_ids_array);


        //$stmt="select * from `u_clients` where `ls_ids` in ($ls_ids) order by `client_ID` DESC";
        $stmt = "select * from `u_clients` where `ls_ids` like '%$ls_ids_array[0]%'";

        for ($l = 1; $l < count($ls_ids_array); $l++) {
            if (!empty($ls_ids_array[$l])) {
                $stmt .= "or `ls_ids` like '%$ls_ids_array[$l]%'";
            }
        }

        $stmt .= "order by `client_ID` DESC";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function show_clients_by_ls_ids_order_by_enterprise($ls_ids_array)
    {

        $mysqli = $this->dbconnect();

        // $ls_ids=implode(",",$ls_ids_array);


        //$stmt="select * from `u_clients` where `ls_ids` in ($ls_ids) order by `client_ID` DESC";
        $stmt = "select * from `u_clients` where `ls_ids` like '%$ls_ids_array[0]%'";

        for ($l = 1; $l < count($ls_ids_array); $l++) {
            if (!empty($ls_ids_array[$l])) {
                $stmt .= "or `ls_ids` like '%$ls_ids_array[$l]%'";
            }
        }

        $stmt .= "order by `clientname` asc,`c_last_name` ASC";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creators_order_by_enterprise($lt_id)
    {
        $mysqli = $this->dbconnect();
        $lt_id = mysqli_real_escape_string($mysqli, $lt_id);

        //$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? order by `lt_id`,`uca_name` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `lt_id`=? and `own_tasks`='1' order by `u_clients`.`clientname`,`u_clients`.`l_last_name` ASC");

        mysqli_stmt_bind_param($stmt, "i", $lt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creators_other_companies($lt_id)
    {
        $mysqli = $this->dbconnect();
        $lt_id = mysqli_real_escape_string($mysqli, $lt_id);

        //$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`<>? order by `lt_id`,`uca_name` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `u_clients`.`lt_id`<>? and `u_clients_rights`.`u_status`='active' order by `u_clients`.`c_first_name` asc");

        mysqli_stmt_bind_param($stmt, "i", $lt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }


    public function show_creators_other_companies_names($lt_id)
    {
        $mysqli = $this->dbconnect();
        $lt_id = mysqli_real_escape_string($mysqli, $lt_id);

        //$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`<>? order by `lt_id`,`uca_name` asc");
        $stmt = mysqli_prepare($mysqli, "select `u_clients`.`client_ID`, `lt_id`, `c_first_name`, `c_last_name` from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `u_clients`.`lt_id`<>? and `u_clients_rights`.`u_status`='active' order by `u_clients`.`c_first_name` asc");

        mysqli_stmt_bind_param($stmt, "i", $lt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    /*
	public function get_walls_doors_windows_creators_default_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? and `walls`>'0' and `doors-windows`>'0'");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_furnishing_creators_default_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? and `furnishing`>'0'");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_corel_b3_creators_default_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? and `corel_b3`>'0'");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_corel_b3_creators_other_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`<>? and `corel_b3`>'0' order by `lt_id` asc");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_render_still_creators_default_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? and `render_still`>'0'");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_render_360_creators_default_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`=? and `render_360`>'0'");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_walls_doors_windows_creators_other_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`<>? and `walls`>'0' and `doors-windows`>'0' order by `lt_id` asc");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_furnishing_creators_other_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`<>? and `furnishing`>'0' order by `lt_id` asc");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_render_still_creators_other_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`<>? and `render_still`>'0' order by `lt_id` asc");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_render_360_creators_other_company($lt_id)
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `lt_id`<>? and `render_360`>'0' order by `lt_id` asc");
		mysqli_stmt_bind_param($stmt,"i",$lt_id);
		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}
	*/
    public function get_customer_files($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $get_customer_files_sql = "select * from `o_files` where `o_id`='$orderid'";
        $get_customer_files_result = mysqli_query($mysqli, $get_customer_files_sql) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($get_customer_files_result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_customer_pdf_file($orderid,$pdf_file)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $sql = "SELECT * FROM `o_files` WHERE `o_id` = $orderid AND `of_name_client` LIKE '$pdf_file' ";

        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_newest_customer_pdf_file($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $sql = "SELECT * FROM `o_files` WHERE `o_id` = $orderid AND `of_type_dom` LIKE '%pdf%' ORDER BY `o_files`.`of_id` DESC limit 0,1 ";

        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_customer_files_by_sub_id($orderid, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $get_customer_files_sql = "select * from `o_files` where `o_id`='$orderid' and `of_position`='$osub_id'";
        $get_customer_files_result = mysqli_query($mysqli, $get_customer_files_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($get_customer_files_result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_customer_file($imageid)
    {
        $mysqli = $this->dbconnect();
        // $orderid = mysqli_real_escape_string($mysqli, $orderid);
        // $imageid = mysqli_real_escape_string($mysqli, $imageid);

        $get_customer_file_sql = "select * from `o_files` where `of_id`='$imageid'";
        $get_customer_file_result = mysqli_query($mysqli, $get_customer_file_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($get_customer_file_result, MYSQLI_BOTH);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_customer_file_by_internal_name($o_id,$of_internal_name_dom)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $of_internal_name_dom = mysqli_real_escape_string($mysqli, $of_internal_name_dom);

        $get_customer_file_sql = "select * from `o_files` where `o_id`='$o_id' and `of_internal_name_dom` like '%$of_internal_name_dom%'";
        $get_customer_file_result = mysqli_query($mysqli, $get_customer_file_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($get_customer_file_result, MYSQLI_BOTH);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_creator_images($ids)
    {
        $mysqli = $this->dbconnect();

        $params = implode(",", array_fill(0, count($ids), "?"));
        $get_customer_file_sql = "select CONCAT(orf_path_dom, orf_internal_name_dom) from o_results where orf_id in ($params)";
        $stmt = $mysqli->prepare($get_customer_file_sql);

        $types = str_repeat("i", count($ids));
        $args = array_merge(array($types), $ids);

        call_user_func_array(array($stmt, 'bind_param'), $this->ref($args));
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $path);

        $paths = [];
        while (mysqli_stmt_fetch($stmt)) {
            $paths[] = $path;
        }

        mysqli_close($mysqli);
        return $paths;
    }

    public function ref($arr)
    {
        $refs = array();
        foreach ($arr as $key => $val) $refs[$key] = &$arr[$key];
        return $refs;
    }

    //
    public function get_orf_name_by_filename($filename = null)
    {

        $mysqli = $this->dbconnect();

        $filename = mysqli_real_escape_string($mysqli, $filename);
        $stmt = mysqli_prepare($mysqli, "select (orf_name) from `o_results` where `orf_internal_name_dom`=?");
        mysqli_stmt_bind_param($stmt, "s", $filename);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result->fetch_row()[0];

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }
    //

    /* public function get_creator_name($creator_id)
	{
		$mysqli=$this->dbconnect();
		$creator_id=mysqli_real_escape_string($mysqli,$creator_id);

		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` where `uca_id`=?");
		mysqli_stmt_bind_param($stmt,"i",$creator_id);

		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);

		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $row;
    } */

    public function get_creator_qualification($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_creators_qualifications` where `uca_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_price_factorial($ls_id)
    {
        $mysqli = $this->dbconnect();
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `price_factorials` where `ls_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $ls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_main_client_price_remarks($mc_id, $price_remarks)
    {
        $mysqli = $this->dbconnect();

        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $stmt = mysqli_prepare($mysqli, "update `u_clients_main` set `price_remarks`='$price_remarks' where `mc_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $mc_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

    }

    public function update_simple_client_price_remarks($client_id, $client_price_remarks)
    {
        $mysqli = $this->dbconnect();

        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "update `u_clients` set `client_price_remarks`='$client_price_remarks' where `client_ID`=?");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_creator_right($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_creators_rights` where `uca_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function creator_products($orderid, $creator_id)
    {
        $mysqli = $this->dbconnect();
        $creator_products_sql = "select * from `o_prods` where `o_id`='$orderid' and `uca_id`='$creator_id' order by `osub_id` asc,`prod_id` asc";
        $creator_products_result = mysqli_query($mysqli, $creator_products_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($creator_products_result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creator_unfinished_orders($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        //$stmt=mysqli_prepare($mysqli,"select distinct `o_id` from `o_prods` where `uca_id`=? and `p_status`<8 order by `o_id` DESC");
        $stmt = mysqli_prepare($mysqli, "select distinct `o_id` from `o_prods` where `uca_id`=? order by `o_id` DESC");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creator_search_orders_by_o_id($uca_id, $o_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select distinct `o_id` from `o_prods` where `uca_id`=? and `o_id`=? order by `o_id` DESC");
        mysqli_stmt_bind_param($stmt, "ii", $uca_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    public function show_finished_distinct_osub_id_panorams_int($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        //$stmt=mysqli_prepare($mysqli,"select distinct `osub_id` from `o_prods` where `o_id`=? and `p_status`='8' order by `osub_id`,`prod_id` ASC");
        $stmt = mysqli_prepare($mysqli, "select distinct `osub_id` from `o_results` where 
        (`o_id`=? or `om_id`=?) and 
        ( `prod_id`='p1526' || `prod_id`='p1626' || `prod_id`='p1726' || `prod_id`='p1826' ||
        `prod_id`='p1506' || `prod_id`='p1606' || `prod_id`='p1706' || `prod_id`='p1806' ||
        `prod_id`='p1546' || `prod_id`='p1646' || `prod_id`='p1746' || `prod_id`='p1846' 
        ) and 
        (`orf_status`='8') order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_distinct_osub_id_panorams($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        //$stmt=mysqli_prepare($mysqli,"select distinct `osub_id` from `o_prods` where `o_id`=? and `p_status`='8' order by `osub_id`,`prod_id` ASC");
        $stmt = mysqli_prepare($mysqli, "select distinct `osub_id` from `o_results` where 
        (`o_id`=? or `om_id`=?) and 
        ( `prod_id`='p1506' || `prod_id`='p1526' || `prod_id`='p1546' || `prod_id`='p1566' ||
          `prod_id`='p1606' || `prod_id`='p1626' || `prod_id`='p1646' || `prod_id`='p1666' ||
          `prod_id`='p1706' || `prod_id`='p1726' || `prod_id`='p1746' || `prod_id`='p1766' ||
          `prod_id`='p1806' || `prod_id`='p1826' || `prod_id`='p1846'  || `prod_id`='p1866'
        ) and 
        (`orf_status`='8') order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_videos($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`orf_status`='8')
		and (`prod_id` like 'p1%67' || `prod_id` like 'p1%68') and (`orf_type_dom`='mp4' || `orf_type_dom`='mov' )
		order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_videos_interior($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`orf_status`='8')
        and (`prod_id`='p1507' || `prod_id`='p1527' || `prod_id`='p1528' ||`prod_id`='p1607' || `prod_id`='p1627' || `prod_id`='p1628'
        ||`prod_id`='p1707' || `prod_id`='p1727' || `prod_id`='p1728'
        ||`prod_id`='p1807' || `prod_id`='p1827' || `prod_id`='p1828') and `orf_type_dom`='mp4'
		order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_distinct_osub_id_videos_ext($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        
        $stmt = mysqli_prepare($mysqli, "select distinct `osub_id` from `o_results` where (`o_id`=? or `om_id`=?) and (`orf_status`='8')
		and (`prod_id` like 'p1%7' || `prod_id` like 'p1%8')
		order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_distinct_osub_id_videos_int($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        
        $stmt = mysqli_prepare($mysqli, "select distinct `osub_id` from `o_results` where (`o_id`=? or `om_id`=?) and (`orf_status`='8')
        and (`prod_id`='p1507' || `prod_id`='p1527' || `prod_id`='p1528' || `prod_id`='p1607' || `prod_id`='p1627' || `prod_id`='p1628' 
        || `prod_id`='p1707' || `prod_id`='p1727' || `prod_id`='p1728' 
        || `prod_id`='p1807' || `prod_id`='p1827' || `prod_id`='p1828')
		order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_distinct_osub_id_int($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select distinct `osub_id` from `o_results` where (`o_id`=? or `om_id`=?) and (`orf_status`='8')
        and (`prod_id` like 'p1%2' || `prod_id` like 'p1%3' || `prod_id` like 'p1%4')
		order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_distinct_osub_id($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select distinct `osub_id` from `o_results` where (`o_id`=? or `om_id`=?) and ( `prod_id` != 'p1868' and `prod_id` != 'p1768' and `prod_id` != 'p1668' and `prod_id` != 'p1568') and (`orf_status`='8') order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_creator_finished_orders($uca_id, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);

        $stmt = mysqli_prepare($mysqli, "select distinct `o_id` from `o_prods` where `uca_id`=? order by `o_id` DESC limit $startpoint,$limit");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            //$count_prods=$this->get_prods($row['o_id']);
            //$count_finished_prods=$this->get_finished_number_prods($row['o_id'],8);
            //if(count($count_prods)==count($count_finished_prods))
            //{
            $rows[] = $row;
            //}
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function update_the_other_o_prods_status($o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        if ($prod_id == "p1301") {

            $stmt1 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and `uca_id`='0' and (`prod_id` between 'p1302' and 'p1307')");
            $stmt2 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and `prod_id`='p1321' and `uca_id`='0'");
            $stmt3 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and `prod_id`='p1341' and `uca_id`='0'");

            $stmt4 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and (`prod_id` between 'p1302' and 'p1307') and `uca_id`<>'0'");
            $stmt5 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and `prod_id`='p1321' and `uca_id`<>'0'");
            $stmt6 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and `prod_id`='p1341' and `uca_id`<>'0'");


            mysqli_stmt_bind_param($stmt1, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt1);

            mysqli_stmt_bind_param($stmt2, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt2);

            mysqli_stmt_bind_param($stmt3, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt3);

            mysqli_stmt_bind_param($stmt4, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt4);

            mysqli_stmt_bind_param($stmt5, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt5);

            mysqli_stmt_bind_param($stmt6, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt6);

            mysqli_stmt_close($stmt1);
            mysqli_stmt_close($stmt2);
            mysqli_stmt_close($stmt3);
            mysqli_stmt_close($stmt4);
            mysqli_stmt_close($stmt5);
            mysqli_stmt_close($stmt6);
        }

        if ($prod_id == "p1501") {

            $stmt1 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and `uca_id`='0' and (`prod_id` between 'p1502' and 'p1507')");
            $stmt2 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and `prod_id`='p1521' and `uca_id`='0'");
            $stmt3 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and `prod_id`='p1541' and `uca_id`='0'");

            $stmt4 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and (`prod_id` between 'p1502' and 'p1507') and `uca_id`<>'0'");
            $stmt5 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and `prod_id`='p1521' and `uca_id`<>'0'");
            $stmt6 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and `prod_id`='p1541' and `uca_id`<>'0'");


            mysqli_stmt_bind_param($stmt1, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt1);

            mysqli_stmt_bind_param($stmt2, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt2);

            mysqli_stmt_bind_param($stmt3, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt3);

            mysqli_stmt_bind_param($stmt4, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt4);

            mysqli_stmt_bind_param($stmt5, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt5);

            mysqli_stmt_bind_param($stmt6, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt6);

            mysqli_stmt_close($stmt1);
            mysqli_stmt_close($stmt2);
            mysqli_stmt_close($stmt3);
            mysqli_stmt_close($stmt4);
            mysqli_stmt_close($stmt5);
            mysqli_stmt_close($stmt6);
        }

        if ($prod_id == "p1521") {
            $stmt1 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and (`prod_id` between 'p1522' and 'p1527') and `uca_id`='0'");
            $stmt2 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and (`prod_id` between 'p1522' and 'p1527') and `uca_id`<>'0'");

            mysqli_stmt_bind_param($stmt1, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt1);

            mysqli_stmt_bind_param($stmt2, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt2);

            mysqli_stmt_close($stmt1);
            mysqli_stmt_close($stmt2);
        }

        if ($prod_id == "p1541") {
            $stmt1 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='3' where `o_id`=? and `osub_id`=? and (`prod_id` between 'p1542' and 'p1547') and `uca_id`='0'");
            $stmt2 = mysqli_prepare($mysqli, "update `o_prods` set `p_status`='4' where `o_id`=? and `osub_id`=? and (`prod_id` between 'p1542' and 'p1547') and `uca_id`<>'0'");

            mysqli_stmt_bind_param($stmt1, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt1);

            mysqli_stmt_bind_param($stmt2, "is", $o_id, $osub_id);
            mysqli_stmt_execute($stmt2);

            mysqli_stmt_close($stmt1);
            mysqli_stmt_close($stmt2);
        }


        mysqli_close($mysqli);
    }

    public function update_o_prods_status($orderid, $osub_id, $prod_id, $p_status)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $p_status = mysqli_real_escape_string($mysqli, $p_status);
        $finish_date = date("Y-m-d H:i:s");

        if ($p_status == 1) {
            $sql = "update `o_prods` set `p_status`='$p_status',`uca_id`='0' where `o_id`='$orderid' and `osub_id`='$osub_id' and `prod_id`='$prod_id'";
        }
        if ($p_status == 8) {
            $sql = "update `o_prods` set `p_status`='$p_status',`prod_finish_date`='$finish_date' where `o_id`='$orderid' and `osub_id`='$osub_id' and `prod_id`='$prod_id'";
        }
        if (($p_status != 1) && ($p_status != 8)) {
            $sql = "update `o_prods` set `p_status`='$p_status' where `o_id`='$orderid' and `osub_id`='$osub_id' and `prod_id`='$prod_id'";
        }
        $update_status_result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_results_status($orf_id, $p_status)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $p_status = mysqli_real_escape_string($mysqli, $p_status);

        $sql = "update `o_results` set `orf_status`='$p_status' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_results_verified($orf_id, $result_file_verified)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $result_file_verified = mysqli_real_escape_string($mysqli, $result_file_verified);

        $sql = "update `o_results` set `result_file_verified`='$result_file_verified' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_results_hover_status($orf_id, $hover_status)
    {
        $mysqli = $this->dbconnect();
        
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $hover_status = mysqli_real_escape_string($mysqli, $hover_status);

        $sql = "update `o_results` set `hover_status`='$hover_status' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_results_show_in_panorama_status($orf_id, $show_in_panorama_status)
    {
        $mysqli = $this->dbconnect();
        
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $show_in_panorama_status = mysqli_real_escape_string($mysqli, $show_in_panorama_status);

        $sql = "update `o_results` set `show_in_panorama_status`='$show_in_panorama_status' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_result_file_room_id($orf_id, $room_id)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $room_id = mysqli_real_escape_string($mysqli, $room_id);

        $sql = "update `o_results` set `room_id`='$room_id' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_result_file_per_id($orf_id, $per_id)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $per_id = mysqli_real_escape_string($mysqli, $per_id);

        $sql = "update `o_results` set `per_id`='$per_id' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_results_bd_status($orf_id, $bd_status)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $bd_status = mysqli_real_escape_string($mysqli, $bd_status);

        $sql = "update `o_results` set `bd_status`='$bd_status' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_img_nr($orf_id, $pict_number)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $pict_number = mysqli_real_escape_string($mysqli, $pict_number);

        $sql = "update `o_results` set `pict_number`='$pict_number' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_img_categ($orf_id, $pict_categ_name)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $pict_categ_name = mysqli_real_escape_string($mysqli, $pict_categ_name);

        $sql = "update `o_results` set `pict_categ_name`='$pict_categ_name' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
       
    }

    public function update_orf_name($orf_id, $orf_name)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $orf_name = mysqli_real_escape_string($mysqli, $orf_name);

        $sql = "update `o_results` set `orf_name`='$orf_name' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function auto_update_o_results_status($o_id, $osub_id, $prod_id, $p_status)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $p_status = mysqli_real_escape_string($mysqli, $p_status);

        $sql = "update `o_results` set `orf_status`='$p_status' where `o_id`='$o_id' and `osub_id`='$osub_id' and `prod_id`='$prod_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function insert_no_result_file($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id=mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id=mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id=mysqli_real_escape_string($mysqli, $data->prod_id);
        $uca_id=mysqli_real_escape_string($mysqli, $data->uca_id);
        $no_result_file=1;
        $orf_upload_date=gmdate("Y-m-d H:i:s");
        $orf_status=0;

        $upload_file_sql = "insert into `o_results`(`o_id`,`osub_id`,`prod_id`,`uca_id`,`no_result_file`,`orf_status`,`orf_upload_date`) values ('$o_id','$osub_id','$prod_id','$uca_id','$no_result_file','$orf_status','$orf_upload_date')";
        
        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function delete_no_result_file($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id=mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id=mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id=mysqli_real_escape_string($mysqli, $data->prod_id);

        $stmt = mysqli_prepare($mysqli, "delete from `o_results` where `o_id`=? and `osub_id`=? and `prod_id`=? and `no_result_file`='1'");
        mysqli_stmt_bind_param($stmt, "iss", $o_id,$osub_id,$prod_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function upload_creator_result_file($o_id, $om_id, $osub_id, $prod_id, $uca_id, $original_file_name, $internal_file_name, $file_extension, $file_path, $orf_upload_date)
    {
        $mysqli = $this->dbconnect();
        $upload_file_sql = "insert into `o_results`(`o_id`,`om_id`,`osub_id`,`prod_id`,`uca_id`,`orf_name`,`orf_internal_name_dom`,`orf_type_dom`,`orf_path_dom`,`orf_upload_date`) values ('$o_id','$om_id','$osub_id','$prod_id','$uca_id','$original_file_name','$internal_file_name','$file_extension','$file_path','$orf_upload_date')";
        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function upload_plans($data)
    {
        $mysqli = $this->dbsuperplan();
        $data = json_decode($data);
        $house_id = mysqli_real_escape_string($mysqli, $data->house_id);
        $pls_id = mysqli_real_escape_string($mysqli, $data->pls_id);
        $plan_object = mysqli_real_escape_string($mysqli, $data->plan_object);
        $file_name = mysqli_real_escape_string($mysqli, $data->file_name);
        $file_type = mysqli_real_escape_string($mysqli, $data->file_type);
        $file_path = mysqli_real_escape_string($mysqli, $data->file_path);

        $sql = "INSERT INTO pls_files(`house_id`,`pls_id`,`plan_kind`,`file_name`,`filetype`,`file_path`) VALUES ('$house_id','$pls_id','$plan_object','$file_name','$file_type','$file_path') ";


        mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function upload_creator_result_file2($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $om_id = mysqli_real_escape_string($mysqli, $data->om_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);
        $uca_id = mysqli_real_escape_string($mysqli, $data->uca_id);
        $original_file_name = $data->orf_name;
        $internal_file_name = $data->orf_internal_name_dom;
        $file_extension = $data->orf_type_dom;
        $file_path = $data->orf_path_dom;
        $orf_upload_date = $data->orf_upload_date;
        $orf_thumbnail_path = $data->orf_thumbnail_path;

        $upload_file_sql = "insert into `o_results`(`o_id`,`om_id`,`osub_id`,`prod_id`,`uca_id`,`orf_name`,`orf_internal_name_dom`,`orf_type_dom`,`orf_path_dom`,`orf_thumbnail_path`,`orf_upload_date`) values ('$o_id','$om_id','$osub_id','$prod_id','$uca_id','$original_file_name','$internal_file_name','$file_extension','$file_path','$orf_thumbnail_path','$orf_upload_date')";
        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function copy_creator_result_file($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $om_id = mysqli_real_escape_string($mysqli, $data->om_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);
        $uca_id = mysqli_real_escape_string($mysqli, $data->uca_id);
        $main_picture = mysqli_real_escape_string($mysqli, $data->main_picture);
        $orf_name = mysqli_real_escape_string($mysqli, $data->orf_name);
        $orf_path_dom = mysqli_real_escape_string($mysqli, $data->orf_path_dom);
        $orf_internal_name_dom = mysqli_real_escape_string($mysqli, $data->orf_internal_name_dom);
        $orf_type_dom = mysqli_real_escape_string($mysqli, $data->orf_type_dom);
        $optimized_image_path = mysqli_real_escape_string($mysqli, $data->optimized_image_path);
        $orf_thumbnail_path = mysqli_real_escape_string($mysqli, $data->orf_thumbnail_path);
        $orf_compress_path = mysqli_real_escape_string($mysqli, $data->orf_compress_path);
        $orf_upload_date = mysqli_real_escape_string($mysqli, $data->orf_upload_date);
        $orf_status = mysqli_real_escape_string($mysqli, $data->orf_status);
        $pict_categ_name = mysqli_real_escape_string($mysqli, $data->pict_categ_name);
        $pict_number = mysqli_real_escape_string($mysqli, $data->pict_number);

        $upload_file_sql = "insert into `o_results`(`o_id`,`om_id`,`osub_id`,`prod_id`,`uca_id`,`main_picture`,`orf_name`,`orf_internal_name_dom`,`orf_type_dom`,`orf_path_dom`,`orf_thumbnail_path`,`orf_upload_date`,`orf_compress_path`,`orf_status`,`pict_categ_name`,`pict_number`,`optimized_image_path`) values ('$o_id','$om_id','$osub_id','$prod_id','$uca_id','$main_picture','$orf_name','$orf_internal_name_dom','$orf_type_dom','$orf_path_dom','$orf_thumbnail_path','$orf_upload_date','$orf_compress_path','$orf_status','$pict_categ_name','$pict_number','$optimized_image_path')";
        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function insert_o_results_configurator_plus($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id_full = mysqli_real_escape_string($mysqli, $data->o_id_full);
        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $pa_id = $data->pa_id;
        $pa_symbol = $data->pa_symbol;
        $connected_to = $data->connected_to;        

        $upload_file_sql = "insert into `o_results_configurator_plus`(`o_id_full`,`orf_id`,`pa_id`,`pa_symbol`,`connected_to`,`price`,`name`) values ('$o_id_full','$orf_id','$pa_id','$pa_symbol','$connected_to','0','')";
        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function update_o_results_configurator_plus($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id_full = mysqli_real_escape_string($mysqli, $data->o_id_full ?? '');
        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id ?? '0');
        $pa_id = mysqli_real_escape_string($mysqli, $data->pa_id ?? '');
        $pa_symbol = mysqli_real_escape_string($mysqli, $data->pa_symbol ?? '');
        $connected_to = mysqli_real_escape_string($mysqli, $data->connected_to ?? '0');        

        $upload_file_sql = "update `o_results_configurator_plus` set `o_id_full`='$o_id_full',`pa_id`='$pa_id',`pa_symbol`='$pa_symbol',`connected_to`='$connected_to' where  `orf_id`='$orf_id'";
        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function get_o_results_configurator_plus($orf_id)
    {
        $mysqli = $this->dbconnect();

        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);                

        $stmt = mysqli_prepare($mysqli, "select * from `o_results_configurator_plus` where `orf_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orf_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function upload_creator_result_file3($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $om_id = mysqli_real_escape_string($mysqli, $data->om_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);
        $uca_id = mysqli_real_escape_string($mysqli, $data->uca_id);
        $config_level = $data->config_level;
        $pict_categ_name=$data->pict_categ_name;
        $original_file_name = $data->orf_name;
        $internal_file_name = $data->orf_internal_name_dom;
        $file_extension = $data->orf_type_dom;
        $file_path = $data->orf_path_dom;
        $orf_upload_date = $data->orf_upload_date;
        $orf_status = $data->orf_status;
        $orf_thumbnail_path = $data->orf_thumbnail_path;
        $orf_compress_path = $data->orf_compress_path;

        $upload_file_sql = "insert into `o_results`(`o_id`,`om_id`,`osub_id`,`prod_id`,`config_level`,`pict_categ_name`,`per_id`,`room_id`,`suntour_model_id`,`vr_link`,`main_picture`,`optimized_image_path`,`orf_watermark_path`,`orf_thumbnail_watermark_path`,`orf_compress_watermark_path`,`uca_id`,`orf_youtube_link`,`orf_vimeo_link`,`bd_status`,`hover_status`,`show_in_panorama_status`,`orf_name`,`result_file_verified`,`no_result_file`,`pict_number`,`orf_internal_name_dom`,`orf_type_dom`,`orf_path_dom`,`orf_thumbnail_path`,`orf_compress_path`,`orf_upload_date`,`orf_status`) 
        values ('$o_id','$om_id','$osub_id','$prod_id','$config_level','$pict_categ_name','0','0','','','0','','','','','$uca_id','','','0','0','0','$original_file_name','0','0','0','$internal_file_name','$file_extension','$file_path','$orf_thumbnail_path','$orf_compress_path','$orf_upload_date','$orf_status')";

        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function update_orf_id_config_level($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $config_level = $data->config_level;

        $upload_file_sql = "update `o_results` set `config_level`='$config_level' where `orf_id`='$orf_id'";

        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function update_thumbnail_path($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $orf_thumbnail_path = $data->orf_thumbnail_path;

        $upload_file_sql = "update `o_results` set `orf_thumbnail_path`='$orf_thumbnail_path' where `orf_id`='$orf_id'";

        $upload_file_result = mysqli_query($mysqli, $upload_file_sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function create_new_thumbnail($o_id)
    {
        $year = date("Y");

        $thumbnail_validextensions = array("jpg", "jpeg", "png");

        $thumbnail_files_dir = "../../cseven.eu/public_html/result_thumbnail_files/";


        $original_file = $this->show_results_by_order($o_id);

        for ($i = 0; $i < count($original_file); $i++) {
            $thumbnail_output_dir = $thumbnail_files_dir . $year . "/" . $o_id . "/" . $o_id . "." . $original_file[$i]['osub_id'] . "." . $original_file[$i]['prod_id'];
            $thumbnail_file_path = $year . "/" . $o_id . "/" . $o_id . "." . $original_file[$i]['osub_id'] . "." . $original_file[$i]['prod_id'] . "/";
            $result_file = "../../cseven.eu/public_html/result_files/" . $original_file[$i]['orf_path_dom'] . $original_file[$i]['orf_internal_name_dom'];

            $file_extension = $original_file[$i]['orf_type_dom'];

            $thumbnail_file_name = $original_file[$i]['orf_internal_name_dom'] . "_thumb." . $file_extension;

            //thumbnail stuff
            if (in_array($file_extension, $thumbnail_validextensions)) {
                if (!file_exists($thumbnail_output_dir)) {
                    mkdir($thumbnail_output_dir, 0755, true);
                }

                $what = getimagesize($result_file);

                $width = $what[0];
                $height = $what[1];

                // $desired_width=400;
                // $desired_height = floor($height * ($desired_width / $width));
                $desired_height = 308;
                $desired_width = floor($width * ($desired_height / $height));


                switch (strtolower($what['mime'])) {
                    case 'image/png':
                        $img = imagecreatefrompng($result_file);
                        $new = imagecreatetruecolor($desired_width, $desired_height);
                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                        header('Content-Type: image/png');
                        break;
                    case 'image/jpeg':
                        $img = imagecreatefromjpeg($result_file);
                        $new = imagecreatetruecolor($desired_width, $desired_height);
                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                        header('Content-Type: image/jpeg');
                        break;
                    case 'image/gif':
                        $img = imagecreatefromgif($result_file);
                        $new = imagecreatetruecolor($desired_width, $desired_height);
                        imagecopyresampled($new, $img, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                        header('Content-Type: image/gif');
                        break;
                    default:
                        die();
                }

                imagejpeg($new, $thumbnail_output_dir . "/" . $thumbnail_file_name);
                imagedestroy($new);
            }
            if (in_array($file_extension, $thumbnail_validextensions)) {
                $data['orf_thumbnail_path'] = $thumbnail_file_path . $thumbnail_file_name;
            } else {
                $data['orf_thumbnail_path'] = "";
            }

            $data['orf_id'] = $original_file[$i]['orf_id'];

            $this->update_thumbnail_path(json_encode($data));
        }
    }

    // own tasks

    public function get_b5_ex_ordered_results($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `prod_id` between 'p1560' and 'p1590' order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_ex_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1560' and 'p1590') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_ex_results_with_osub_id_and_extensions($o_id,$osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`=? and (`prod_id` between 'p1560' and 'p1590') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_ex_results_with_osub_id_and_extensions($o_id,$osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`=? and (`prod_id` between 'p1760' and 'p1790') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_exterior_results_with_osub_id_extensions($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`= ? and `prod_id` like '%63' and `orf_status`='8' order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_interior_results_with_osub_id_extensions($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`= ? and (`prod_id` like '%23' or `prod_id` like '%22' or `prod_id` like '%02' or `prod_id` like '%03' or `prod_id` like '%42' or `prod_id` like '%43') and `orf_status`='8' order by `orf_name` ASC ");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_exterior_panorama_results_with_osub_id_extensions($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`= ? and (`prod_id` like '%66') and `orf_status`='8' order by `orf_name` ASC ");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_interior_panorama_results_with_osub_id_extensions($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`= ? and (`prod_id` like '%06' or `prod_id` like '%26' or `prod_id` like '%46') and `orf_status`='8' order by `orf_name` ASC ");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_ex_360_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1560' and 'p1590') order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_ex_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1660' and 'p1690' or `prod_id` like '%66p') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_ex_360_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1660' and 'p1690') order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_ex_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1760' and 'p1791') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_360_ex_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1760' and 'p1791') order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_ex_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1860' and 'p1891') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_360_ex_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1860' and 'p1891') order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b3_in_ordered_results($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `prod_id` between 'p1300' and 'p1360' order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b3_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1300' and 'p1360') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b3_in_results_with_osub_id_and_extensions($o_id,$osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        
        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`=? and (`prod_id` between 'p1300' and 'p1360') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b1_in_results_with_osub_id_and_extensions($o_id,$osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        
        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`=? and (`prod_id` between 'p1100' and 'p1160') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_in_ordered_results($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `prod_id` between 'p1500' and 'p1560' order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `prod_id` between 'p1600' and 'p1659' order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_360_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `prod_id` between 'p1600' and 'p1659' order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1500' and 'p1560') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_in_results_with_osub_id_and_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`=? and (`prod_id` between 'p1500' and 'p1560') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_360_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1500' and 'p1560') order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1700' and 'p1760') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_in_results_with_osub_id_and_extensions($o_id,$osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and `osub_id`=? and (`prod_id` between 'p1700' and 'p1760') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "iis", $o_id, $o_id,$osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_360_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1700' and 'p1760') order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1800' and 'p1860') order by `orf_name` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_360_in_results_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1800' and 'p1860') order by `pict_number` ASC");

        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_product_tutorials($cdws_id)
    {
        $mysqli = $this->dbconnect();
        $cdws_id = mysqli_real_escape_string($mysqli, $cdws_id);

        $stmt = mysqli_prepare($mysqli, "select * from `tutorials` where `cdws_ids` like ? order by `t_title` asc");
        $param = "%" . $cdws_id . "%";
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_tutorial_by_id($t_id)
    {
        $mysqli = $this->dbconnect();
        $t_id = mysqli_real_escape_string($mysqli, $t_id);

        $stmt = mysqli_prepare($mysqli, "select * from `tutorials` where `t_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $t_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function calculateProductlabc_by_orderid($prod_id, $orderid)
    {
        $mysqli = $this->dbconnect();
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $product = $this->get_product($prod_id);
        $order = $this->get_order($orderid);

        $cdws_ids = explode(',', $product['cdws_ids']);

        $total_labc = 0;
        //echo count($cdws_ids);
        for ($i = 0; $i < count($cdws_ids); $i++) {

            if (/*(substr($cdws_ids[$i],1)>1300)&&*/ (!empty($cdws_ids[$i]))) {
                $workstep_credit = $this->get_workstep_credit($cdws_ids[$i]);
                $credits_kinds = $this->get_apu($workstep_credit['cd_kind']);
                $labc = $credits_kinds['labc'] * $workstep_credit['cdk_amount'];
                $total_labc += $labc;
            }

        }

        if ((substr($prod_id, 1) > 1300) && (substr($prod_id, 1) < 1360)) {
            $fac_labc_in_b3 = $this->get_o_desc_in_b3($orderid);

            $final_labc = $total_labc * $fac_labc_in_b3['fac_labc_in_b3'];
        }

        if ((substr($prod_id, 1) > 1500) && (substr($prod_id, 1) < 1560)) {
            $fac_labc_in_b5 = $this->get_o_desc_in_b5($orderid);

            $final_labc = $total_labc * $fac_labc_in_b5['fac_labc_in_b5'];
        }

        if ((substr($prod_id, 1) >= 1600) && (substr($prod_id, 1) < 1660)) {
            $fac_labc_in_b6 = $this->get_o_desc_in_b6($orderid);

            $final_labc = $total_labc * $fac_labc_in_b6['fac_labc_in_b6'];
        }

        if ((substr($prod_id, 1) >= 1700) && (substr($prod_id, 1) < 1760)) {
            $fac_labc_in_b7 = $this->get_o_desc_in_b7($orderid);

            $final_labc = $total_labc * $fac_labc_in_b7['fac_labc_in_b7'];
        }

        if ((substr($prod_id, 1) >= 1800) && (substr($prod_id, 1) < 1860)) {
            $fac_labc_in_b8 = $this->get_o_desc_in_b8($orderid);

            $final_labc = $total_labc * $fac_labc_in_b8['fac_labc_in_b8'];
        }

        if ((substr($prod_id, 1) > 1560) && (substr($prod_id, 1) < 1590)) {
            $fac_labc_ex_b5 = $this->get_o_desc_ex_b5($orderid);

            $final_labc = $total_labc * $fac_labc_ex_b5['fac_labc_ex_b5'];
        }

        if ((substr($prod_id, 1) > 1660) && (substr($prod_id, 1) < 1690)) {
            $fac_labc_ex_b6 = $this->get_o_desc_ex_b6($orderid);

            $final_labc = $total_labc * $fac_labc_ex_b6['fac_labc_ex_b6'];
        }

        if ((substr($prod_id, 1) >= 1760) && (substr($prod_id, 1) < 1791)) {
            $fac_labc_ex_b7 = $this->get_o_desc_ex_b7($orderid);

            $final_labc = $total_labc * $fac_labc_ex_b7['fac_labc_ex_b7'];
        }

        if ((substr($prod_id, 1) >= 1860) && (substr($prod_id, 1) < 1891)) {
            $fac_labc_ex_b8 = $this->get_o_desc_ex_b8($orderid);

            $final_labc = $total_labc * $fac_labc_ex_b8['fac_labc_ex_b8'];
        }

        mysqli_close($mysqli);

        return $final_labc;
    }

    public function check_existing_working_hours($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $starttime = gmdate("Y-m-d");
        $stmt = mysqli_prepare($mysqli, "select * from `creator_working_hours` where `uca_id`=? and `start_time` like '%$starttime%'");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        $row = mysqli_stmt_num_rows($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_creator_start_time($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $endtime = gmdate("Y-m-d");

        $stmt = mysqli_prepare($mysqli, "select * from `creator_working_hours` where `uca_id`=? and `start_time` like '%$endtime%'");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_creator_login_time($uca_id, $start_date, $end_date)
    {
        $mysqli = $this->dbconnect();

        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $start_date = mysqli_real_escape_string($mysqli, $start_date);
        $end_date = mysqli_real_escape_string($mysqli, $end_date);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `creator_working_hours` WHERE `uca_id`=? and `start_time` between '$start_date 00:00:00' and '$end_date 23:59:00'");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_creator_end_time($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $endtime = gmdate("Y-m-d");

        $stmt = mysqli_prepare($mysqli, "select * from `creator_working_hours` where `uca_id`=? and `end_time` like '%$endtime%'");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_creator_end_time2($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $stmt = mysqli_prepare($mysqli, "select * from `creator_working_hours` where `uca_id`=? order asc");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_working_hours($cwh_id, $start_time, $end_time, $ip_address, $user_agent)
    {
        $mysqli = $this->dbconnect();
        $cwh_id = mysqli_real_escape_string($mysqli, $cwh_id);
        $start_time = mysqli_real_escape_string($mysqli, $start_time);
        $end_time = mysqli_real_escape_string($mysqli, $end_time);
        $ip_address = mysqli_real_escape_string($mysqli, $ip_address);
        $user_agent = mysqli_real_escape_string($mysqli, $user_agent);

        $stmt = mysqli_prepare($mysqli, "update `creator_working_hours` set `start_time`=?,`end_time`=?,`ip_address`=?,`user_agent`=? where `cwh_id`=?");
        mysqli_stmt_bind_param($stmt, "ssssi", $start_time, $end_time, $ip_address, $user_agent, $cwh_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function insert_working_hours($uca_id, $start_time, $end_time, $ip_address, $user_agent)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $start_time = mysqli_real_escape_string($mysqli, $start_time);
        $end_time = mysqli_real_escape_string($mysqli, $end_time);
        $ip_address = mysqli_real_escape_string($mysqli, $ip_address);
        $user_agent = mysqli_real_escape_string($mysqli, $user_agent);

        $stmt = mysqli_prepare($mysqli, "insert into `creator_working_hours`(`uca_id`,`start_time`,`end_time`,`ip_address`,`user_agent`) values(?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "issss", $uca_id, $start_time, $end_time, $ip_address, $user_agent);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_todays_working_hours($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $starttime = date("Y-m-d");

        $stmt = mysqli_prepare($mysqli, "select * from `creator_working_hours` where `uca_id`=? and `start_time` like '%$starttime%'");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_todays_working_hours_gm($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $starttime = gmdate("Y-m-d");

        $stmt = mysqli_prepare($mysqli, "select * from `creator_working_hours` where `uca_id`=? and `start_time` like '%$starttime%'");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function count_total_tasks($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `uca_id`=? and `p_status`<'9'");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        $row = mysqli_stmt_num_rows($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function count_total_tasks_coordination($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `p_status`<'9'");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        $row = mysqli_stmt_num_rows($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_prods_by_order_id($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `p_status`<'9' order by `osub_id`,`prod_id` ASC");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function count_working_tasks($uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `uca_id`=? and `p_status` between '2' and '7' order by `o_id` desc");
        mysqli_stmt_bind_param($stmt, "i", $uca_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function count_available_tasks_by_orderid($o_id, $uca_id)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `uca_id`=? and `p_status` between '3' and '6'");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $uca_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        $row = mysqli_stmt_num_rows($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function count_finished_tasks_by_orderid_coordination($o_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `p_status`>'7'");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        $row = mysqli_stmt_num_rows($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function show_results($orderid, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `prod_id`=? order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "iss", $orderid, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_base_pictures_for_this_osub_id($orderid,$osub_id,$prod_id)
    {
        $mysqli = $this->dbconnect();
        
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $sql = "select * from `o_results` where `o_id`='$orderid' and `osub_id`='$osub_id' and `prod_id`='$prod_id' and `config_level`='pa0000' order by `orf_name` asc";

        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        // $stmt = mysqli_prepare($mysqli, $sql);
        // mysqli_stmt_bind_param($stmt, "iss", $orderid, $osub_id, $prod_id);

        // mysqli_stmt_execute($stmt);

        //$result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_results_with_rooms($orderid, $osub_id, $prod_id,$room_id="")
    {
        //$mysqli = $this->dbconnect();
        $mysqli = $this->dbdomenia3n();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $room_id = mysqli_real_escape_string($mysqli, $room_id);

        if($room_id=="")
        {
            if(substr($prod_id, -1) === 'y')
            {
                $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia1`.`o_results` right join `adminhdd_domenia2`.`picture_areas` on `adminhdd_domenia2`.`picture_areas`.`pa_id`=`adminhdd_domenia1`.`o_results`.`config_level` where `adminhdd_domenia1`.`o_results`.`o_id`=? and `adminhdd_domenia1`.`o_results`.`osub_id`=? and `adminhdd_domenia1`.`o_results`.`prod_id`=? ORDER BY `adminhdd_domenia2`.`picture_areas`.`pa_id` ASC,`adminhdd_domenia1`.`o_results`.`orf_name` ASC");
            }
            else
            {
                $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia1`.`o_results` where `adminhdd_domenia1`.`o_results`.`o_id`=? and `adminhdd_domenia1`.`o_results`.`osub_id`=? and `adminhdd_domenia1`.`o_results`.`prod_id`=? ORDER BY `adminhdd_domenia1`.`o_results`.`orf_name` ASC");
            }
            mysqli_stmt_bind_param($stmt, "iss", $orderid, $osub_id, $prod_id);
        }
        else
        {
            $stmt = mysqli_prepare($mysqli, "select * from `adminhdd_domenia1`.`o_results` where `adminhdd_domenia1`.`o_results`.`o_id`=? and `adminhdd_domenia1`.`o_results`.`osub_id`=? and `adminhdd_domenia1`.`o_results`.`prod_id`=? and `room_id`=? order by `adminhdd_domenia1`.`o_results`.`orf_name` asc");
            mysqli_stmt_bind_param($stmt, "issi", $orderid, $osub_id, $prod_id,$room_id);
        }
        

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_results_from_base_picture($orderid, $osub_id, $prod_id,$orf_id)
    {
        $mysqli = $this->dbdomenia3n();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        
        $sql = "select * from `adminhdd_domenia1`.`o_results` right join `adminhdd_domenia2`.`picture_areas` on `adminhdd_domenia2`.`picture_areas`.`pa_id`=`adminhdd_domenia1`.`o_results`.`config_level` where `adminhdd_domenia1`.`o_results`.`o_id`='$orderid' and `adminhdd_domenia1`.`o_results`.`osub_id`='$osub_id' and `adminhdd_domenia1`.`o_results`.`prod_id`='$prod_id' and `adminhdd_domenia1`.`o_results`.`pict_categ_name` LIKE '%$orf_id%' or `adminhdd_domenia1`.`o_results`.`orf_id`='$orf_id' ORDER BY `adminhdd_domenia2`.`picture_areas`.`pa_id` ASC,`adminhdd_domenia1`.`o_results`.`orf_name` ASC";
        
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_results_by_date_reverse_order($orderid, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `prod_id`=? order by `orf_upload_date` desc");
        mysqli_stmt_bind_param($stmt, "iss", $orderid, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_results_by_order($orderid)
    {
        $mysqli = $this->dbconnect();
        $show_results_sql = "select * from `o_results` where `o_id`='$orderid'";
        $show_results_result = mysqli_query($mysqli, $show_results_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($show_results_result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_creator_file($orfid)
    {
        $mysqli = $this->dbconnect();
        $show_results_sql = "select * from `o_results` where `orf_id`='$orfid'";
        $show_results_result = mysqli_query($mysqli, $show_results_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($show_results_result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    // acceptance page

    function get_o_desc_b0_by_client($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_b0` where `u_client_ID`=?");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    function get_o_desc_b0($o_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_b0` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function update_o_desc_b0($o_id, $col_amount_b0)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $col_amount_b0 = mysqli_real_escape_string($mysqli, $col_amount_b0);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_b0` set `col_amount_b0`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "di", $col_amount_b0, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

    }

    public function update_o_desc_in_b3($o_id, $sl_id, $cls_id, $col_amount1_in_b3, $col_price_in_b3, $fac_cl_in_b3, $o_price_in_b3, $col_apus_in_b3, $fac_prod_in_b3, $o_apus_in_b3, $col_labc_in_b3, $fac_labc_in_b3, $total_labcs_in_b3)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $sl_id = mysqli_real_escape_string($mysqli, $sl_id);
        $cls_id = mysqli_real_escape_string($mysqli, $cls_id);
        $col_amount1_in_b3 = mysqli_real_escape_string($mysqli, $col_amount1_in_b3);
        $col_price_in_b3 = mysqli_real_escape_string($mysqli, $col_price_in_b3);
        $fac_cl_in_b3 = mysqli_real_escape_string($mysqli, $fac_cl_in_b3);
        $o_price_in_b3 = mysqli_real_escape_string($mysqli, $o_price_in_b3);
        $col_apus_in_b3 = mysqli_real_escape_string($mysqli, $col_apus_in_b3);
        $fac_prod_in_b3 = mysqli_real_escape_string($mysqli, $fac_prod_in_b3);
        $o_apus_in_b3 = mysqli_real_escape_string($mysqli, $o_apus_in_b3);
        $col_labc_in_b3 = mysqli_real_escape_string($mysqli, $col_labc_in_b3);
        $fac_labc_in_b3 = mysqli_real_escape_string($mysqli, $fac_labc_in_b3);
        $total_labcs_in_b3 = mysqli_real_escape_string($mysqli, $total_labcs_in_b3);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_in_b3` set `sl_id`=?, `cls_id`=?, `col_amount_in_b3`=?, `col_price_in_b3`=?, `fac_cl_in_b3`=?, `o_price_in_b3`=?, `col_apus_in_b3`=?, `fac_prod_in_b3`=?, `o_apus_in_b3`=?, `col_labc_in_b3`=?, `fac_labc_in_b3`=?,`total_labcs_in_b3`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "ssidddddddddi", $sl_id, $cls_id, $col_amount1_in_b3, $col_price_in_b3, $fac_cl_in_b3, $o_price_in_b3, $col_apus_in_b3, $fac_prod_in_b3, $o_apus_in_b3, $col_labc_in_b3, $fac_labc_in_b3, $total_labcs_in_b3, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b1($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
      
        $col_amount_in_b1 = mysqli_real_escape_string($mysqli, $data->col_amount_in_b1);

        $p1103_fac = mysqli_real_escape_string($mysqli, $data->p1103_fac);
        $p1104_fac = mysqli_real_escape_string($mysqli, $data->p1104_fac);
        $p1106_fac = mysqli_real_escape_string($mysqli, $data->p1106_fac);
        $p1108_fac = mysqli_real_escape_string($mysqli, $data->p1108_fac);
       
        $col_price_in_b1 = mysqli_real_escape_string($mysqli, $data->col_price_in_b1);
        $fac_cl_in_b1 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b1);
        $o_price_in_b1 = mysqli_real_escape_string($mysqli, $data->o_price_in_b1);
        $col_apus_in_b1 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b1);
        $fac_prod_in_b1 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b1);
        $o_apus_in_b1 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b1);
        $col_labc_in_b1 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b1);
        $fac_labc_in_b1 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b1);
        $total_labcs_in_b1 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b1);

        $stmt = "update `o_desc_in_b1` set `col_amount_in_b1`='$col_amount_in_b1',`p1103_fac`='$p1103_fac',`p1104_fac`='$p1104_fac',`p1106_fac`='$p1106_fac',`p1108_fac`='$p1108_fac',`col_price_in_b1`='$col_price_in_b1', `fac_cl_in_b1`='$fac_cl_in_b1', `o_price_in_b1`='$o_price_in_b1', `col_apus_in_b1`='$col_apus_in_b1', `fac_prod_in_b1`='$fac_prod_in_b1', `o_apus_in_b1`='$o_apus_in_b1', `col_labc_in_b1`='$col_labc_in_b1', `fac_labc_in_b1`='$fac_labc_in_b1',`total_labcs_in_b1`='$total_labcs_in_b1' where `o_id`='$o_id'";
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        
        mysqli_close($mysqli);
    }

    public function add_o_desc_in_b1($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);

        $col_amount_in_b1 = mysqli_real_escape_string($mysqli, $data->col_amount_in_b1);

        $p1103_fac = mysqli_real_escape_string($mysqli, $data->p1103_fac ?? 1.0);
        $p1104_fac = mysqli_real_escape_string($mysqli, $data->p1104_fac ?? 1.0);
        $p1106_fac = mysqli_real_escape_string($mysqli, $data->p1106_fac ?? 1.0);
        $p1108_fac = mysqli_real_escape_string($mysqli, $data->p1108_fac ?? 1.0);
       
        $col_price_in_b1 = mysqli_real_escape_string($mysqli, $data->col_price_in_b1 ?? 0.0);
        $fac_cl_in_b1 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b1 ?? 1.0);
        $o_price_in_b1 = mysqli_real_escape_string($mysqli, $data->o_price_in_b1 ?? 0.0);
        $col_apus_in_b1 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b1 ?? 0.0);
        $fac_prod_in_b1 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b1 ?? 1.0);
        $o_apus_in_b1 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b1 ?? 0.0);
        $col_labc_in_b1 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b1 ?? 0.0);
        $fac_labc_in_b1 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b1 ?? 1.0);
        $total_labcs_in_b1 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b1 ?? 0.0);

        $stmt = "insert into `o_desc_in_b1`(`o_id`,`usage`,`col_amount_in_b1`,`p1103_fac`,`p1104_fac`,`p1106_fac`,`p1108_fac`,`col_price_in_b1`,`fac_cl_in_b1`,`o_price_in_b1`,`col_apus_in_b1`,`fac_prod_in_b1`,`o_apus_in_b1`,`col_labc_in_b1`,`fac_labc_in_b1`,`total_labcs_in_b1`) 
        values('$o_id','','$col_amount_in_b1','$p1103_fac','$p1104_fac','$p1106_fac','$p1108_fac','$col_price_in_b1','$fac_cl_in_b1','$o_price_in_b1','$col_apus_in_b1','$fac_prod_in_b1','$o_apus_in_b1','$col_labc_in_b1','$fac_labc_in_b1','$total_labcs_in_b1')";
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b32($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $sl_id = mysqli_real_escape_string($mysqli, $data->sl_id ?? '');
        $cls_id = mysqli_real_escape_string($mysqli, $data->cls_id ?? '');
        $col_amount_in_b3 = mysqli_real_escape_string($mysqli, $data->col_amount_in_b3 ?? 0.0);

        $p1301_fac = mysqli_real_escape_string($mysqli, $data->p1301_fac ?? 1.0);
        $p1302_fac = mysqli_real_escape_string($mysqli, $data->p1302_fac ?? 1.0);
        $p1321_fac = mysqli_real_escape_string($mysqli, $data->p1321_fac ?? 1.0);
        $p1322_fac = mysqli_real_escape_string($mysqli, $data->p1322_fac ?? 1.0);

        $col_price_in_b3 = mysqli_real_escape_string($mysqli, $data->col_price_in_b3 ?? 0.0);
        $fac_cl_in_b3 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b3 ?? 1.0);
        $o_price_in_b3 = mysqli_real_escape_string($mysqli, $data->o_price_in_b3 ?? 0.0);
        $col_apus_in_b3 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b3 ?? 0.0);
        $fac_prod_in_b3 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b3 ?? 1.0);
        $o_apus_in_b3 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b3 ?? 0.0);
        $col_labc_in_b3 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b3 ?? 0.0);
        $fac_labc_in_b3 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b3 ?? 1.0);
        $total_labcs_in_b3 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b3 ?? 0.0);

        $stmt = "update `o_desc_in_b3` set `sl_id`='$sl_id', `cls_id`='$cls_id', `col_amount_in_b3`='$col_amount_in_b3',`p1301_fac`='$p1301_fac',`p1302_fac`='$p1302_fac',`p1321_fac`='$p1321_fac',`p1322_fac`='$p1322_fac',`col_price_in_b3`='$col_price_in_b3', `fac_cl_in_b3`='$fac_cl_in_b3', `o_price_in_b3`='$o_price_in_b3', `col_apus_in_b3`='$col_apus_in_b3', `fac_prod_in_b3`='$fac_prod_in_b3', `o_apus_in_b3`='$o_apus_in_b3', `col_labc_in_b3`='$col_labc_in_b3', `fac_labc_in_b3`='$fac_labc_in_b3',`total_labcs_in_b3`='$total_labcs_in_b3' where `o_id`='$o_id'";
        //mysqli_stmt_bind_param($stmt,"ssidddddddddi",$sl_id,$cls_id,$col_amount1_in_b3,$col_price_in_b3,$fac_cl_in_b3,$o_price_in_b3,$col_apus_in_b3,$fac_prod_in_b3,$o_apus_in_b3,$col_labc_in_b3,$fac_labc_in_b3,$total_labcs_in_b3,$o_id);

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        //mysqli_stmt_execute($stmt);

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b5($o_id, $layout_id, $window_id, $col_amount1_in_b5, $col_price_in_b5, $fac_cl_in_b5, $o_price_in_b5, $col_apus_in_b5, $fac_prod_in_b5, $o_apus_in_b5, $col_labc_in_b5, $fac_labc_in_b5, $o_labcs_in_b5)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $layout_id);
        $window_id = mysqli_real_escape_string($mysqli, $window_id);
        $col_amount1_in_b5 = mysqli_real_escape_string($mysqli, $col_amount1_in_b5);
        $col_price_in_b5 = mysqli_real_escape_string($mysqli, $col_price_in_b5);
        $fac_cl_in_b5 = mysqli_real_escape_string($mysqli, $fac_cl_in_b5);
        $o_price_in_b5 = mysqli_real_escape_string($mysqli, $o_price_in_b5);
        $col_apus_in_b5 = mysqli_real_escape_string($mysqli, $col_apus_in_b5);
        $fac_prod_in_b5 = mysqli_real_escape_string($mysqli, $fac_prod_in_b5);
        $o_apus_in_b5 = mysqli_real_escape_string($mysqli, $o_apus_in_b5);
        $col_labc_in_b5 = mysqli_real_escape_string($mysqli, $col_labc_in_b5);
        $fac_labc_in_b5 = mysqli_real_escape_string($mysqli, $fac_labc_in_b5);
        $total_labcs_in_b5 = mysqli_real_escape_string($mysqli, $total_labcs_in_b5);

        $stmt = "update `o_desc_in_b5` set `layout_id`='$layout_id', `window_id`='$window_id', `col_amount_in_b5`='$col_amount1_in_b5', `col_price_in_b5`='$col_price_in_b5', `fac_cl_in_b5`='$fac_cl_in_b5', `o_price_in_b5`='$o_price_in_b5', `col_apus_in_b5`='$col_apus_in_b5', `fac_prod_in_b5`='$fac_prod_in_b5', `o_apus_in_b5`='$o_apus_in_b5', `col_labc_in_b5`='$col_labc_in_b5', `fac_labc_in_b5`='$fac_labc_in_b5',`total_labcs_in_b5`='$o_labcs_in_b5' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b52($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '0');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '0');

        $col_amount_in_b5 = mysqli_real_escape_string($mysqli, $data->col_amount_in_b5 ?? 0.0);
        $col_price_in_b5 = mysqli_real_escape_string($mysqli, $data->col_price_in_b5 ?? 0.0);
        $fac_cl_in_b5 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b5 ?? 1.0);
        $o_price_in_b5 = mysqli_real_escape_string($mysqli, $data->o_price_in_b5 ?? 0.0);

        $col_apus_in_b5 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b5 ?? 0.0);
        $fac_prod_in_b5 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b5 ?? 1.0);
        $o_apus_in_b5 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b5 ?? 0.0);

        $col_labc_in_b5 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b5 ?? 0.0);
        $fac_labc_in_b5 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b5 ?? 1.0);
        $total_labcs_in_b5 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b5 ?? 0.0);

        $p1501_fac = mysqli_real_escape_string($mysqli, $data->p1501_fac ?? 1.0);
        $p1502_fac = mysqli_real_escape_string($mysqli, $data->p1502_fac ?? 1.0);
        $p1503_fac = mysqli_real_escape_string($mysqli, $data->p1503_fac ?? 1.0);
        $p1504_fac = mysqli_real_escape_string($mysqli, $data->p1504_fac ?? 1.0);
        $p1506_fac = mysqli_real_escape_string($mysqli, $data->p1506_fac ?? 1.0);
        $p1507_fac = mysqli_real_escape_string($mysqli, $data->p1507_fac ?? 1.0);
        $p1508_fac = mysqli_real_escape_string($mysqli, $data->p1508_fac ?? 1.0);

        $p1521_fac = mysqli_real_escape_string($mysqli, $data->p1521_fac ?? 1.0);
        $p1522_fac = mysqli_real_escape_string($mysqli, $data->p1522_fac ?? 1.0);
        $p1523_fac = mysqli_real_escape_string($mysqli, $data->p1523_fac ?? 1.0);
        $p1524_fac = mysqli_real_escape_string($mysqli, $data->p1524_fac ?? 1.0);
        $p1526_fac = mysqli_real_escape_string($mysqli, $data->p1526_fac ?? 1.0);
        $p1527_fac = mysqli_real_escape_string($mysqli, $data->p1527_fac ?? 1.0);
        $p1528_fac = mysqli_real_escape_string($mysqli, $data->p1528_fac ?? 1.0);

        $p1541_fac = mysqli_real_escape_string($mysqli, $data->p1541_fac ?? 1.0);
        $p1542_fac = mysqli_real_escape_string($mysqli, $data->p1542_fac ?? 1.0);
        $p1543_fac = mysqli_real_escape_string($mysqli, $data->p1543_fac ?? 1.0);
        $p1544_fac = mysqli_real_escape_string($mysqli, $data->p1544_fac ?? 1.0);
        $p1546_fac = mysqli_real_escape_string($mysqli, $data->p1546_fac ?? 1.0);
        $p1547_fac = mysqli_real_escape_string($mysqli, $data->p1547_fac ?? 1.0);
        $p1548_fac = mysqli_real_escape_string($mysqli, $data->p1548_fac ?? 1.0);

        $stmt = "update `o_desc_in_b5` set `layout_id`='$layout_id', `window_id`='$window_id', `col_amount_in_b5`='$col_amount_in_b5', `col_price_in_b5`='$col_price_in_b5', `fac_cl_in_b5`='$fac_cl_in_b5', `o_price_in_b5`='$o_price_in_b5', `col_apus_in_b5`='$col_apus_in_b5',`p1501_fac`='$p1501_fac',`p1502_fac`='$p1502_fac',`p1503_fac`='$p1503_fac',`p1504_fac`='$p1504_fac',`p1506_fac`='$p1506_fac',`p1507_fac`='$p1507_fac',`p1508_fac`='$p1508_fac',`p1521_fac`='$p1521_fac',`p1522_fac`='$p1522_fac',`p1523_fac`='$p1523_fac',`p1524_fac`='$p1524_fac',`p1526_fac`='$p1526_fac',`p1527_fac`='$p1527_fac',`p1528_fac`='$p1528_fac',`p1541_fac`='$p1541_fac',`p1542_fac`='$p1542_fac',`p1543_fac`='$p1543_fac',`p1544_fac`='$p1544_fac',`p1546_fac`='$p1546_fac',`p1547_fac`='$p1547_fac',`p1548_fac`='$p1548_fac',`fac_prod_in_b5`='$fac_prod_in_b5', `o_apus_in_b5`='$o_apus_in_b5', `col_labc_in_b5`='$col_labc_in_b5', `fac_labc_in_b5`='$fac_labc_in_b5',`total_labcs_in_b5`='$total_labcs_in_b5' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b6($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '0');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '0');

        $col_amount_in_b6 = mysqli_real_escape_string($mysqli, $data->col_amount_in_b6 ?? 0.0);
        $col_price_in_b6 = mysqli_real_escape_string($mysqli, $data->col_price_in_b6 ?? 0.0);
        $fac_cl_in_b6 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b6 ?? 1.0);
        $o_price_in_b6 = mysqli_real_escape_string($mysqli, $data->o_price_in_b6 ?? 0.0);

        $col_apus_in_b6 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b6 ?? 0.0);
        $fac_prod_in_b6 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b6 ?? 1.0);
        $o_apus_in_b6 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b6 ?? 0.0);

        $col_labc_in_b6 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b6 ?? 0.0);
        $fac_labc_in_b6 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b6 ?? 1.0);
        $total_labcs_in_b6 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b6 ?? 0.0);

        $p1600_fac = mysqli_real_escape_string($mysqli, $data->p1600_fac ?? 1.0);
        $p1601_fac = mysqli_real_escape_string($mysqli, $data->p1601_fac ?? 1.0);
        $p1604_fac = mysqli_real_escape_string($mysqli, $data->p1604_fac ?? 1.0);
        $p1621_fac = mysqli_real_escape_string($mysqli, $data->p1621_fac ?? 1.0);
        $p1624_fac = mysqli_real_escape_string($mysqli, $data->p1624_fac ?? 1.0);
        $p1641_fac = mysqli_real_escape_string($mysqli, $data->p1641_fac ?? 1.0);
        $p1644_fac = mysqli_real_escape_string($mysqli, $data->p1644_fac ?? 1.0);
        $p1606_fac = mysqli_real_escape_string($mysqli, $data->p1606_fac ?? 1.0);
        $p1626_fac = mysqli_real_escape_string($mysqli, $data->p1626_fac ?? 1.0);
        $p1646_fac = mysqli_real_escape_string($mysqli, $data->p1646_fac ?? 1.0);

        $stmt = "update `o_desc_in_b6` set `layout_id`='$layout_id', `window_id`='$window_id', `col_amount_in_b6`='$col_amount_in_b6', `col_price_in_b6`='$col_price_in_b6', `fac_cl_in_b6`='$fac_cl_in_b6', `o_price_in_b6`='$o_price_in_b6', `col_apus_in_b6`='$col_apus_in_b6',`p1600_fac`='$p1600_fac',`p1601_fac`='$p1601_fac',`p1604_fac`='$p1604_fac',`p1621_fac`='$p1621_fac',`p1624_fac`='$p1624_fac',`p1641_fac`='$p1641_fac',`p1644_fac`='$p1644_fac',`p1606_fac`='$p1606_fac',`p1626_fac`='$p1626_fac',`p1646_fac`='$p1646_fac', `fac_prod_in_b6`='$fac_prod_in_b6', `o_apus_in_b6`='$o_apus_in_b6', `col_labc_in_b6`='$col_labc_in_b6', `fac_labc_in_b6`='$fac_labc_in_b6',`total_labcs_in_b6`='$total_labcs_in_b6' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b7($o_id, $layout_id, $window_id, $col_amount1_in_b5, $col_price_in_b5, $fac_cl_in_b5, $o_price_in_b5, $col_apus_in_b5, $fac_prod_in_b5, $o_apus_in_b5, $col_labc_in_b5, $fac_labc_in_b5, $o_labcs_in_b5)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $layout_id);
        $window_id = mysqli_real_escape_string($mysqli, $window_id);
        $col_amount1_in_b5 = mysqli_real_escape_string($mysqli, $col_amount1_in_b5);
        $col_price_in_b5 = mysqli_real_escape_string($mysqli, $col_price_in_b5);
        $fac_cl_in_b5 = mysqli_real_escape_string($mysqli, $fac_cl_in_b5);
        $o_price_in_b5 = mysqli_real_escape_string($mysqli, $o_price_in_b5);
        $col_apus_in_b5 = mysqli_real_escape_string($mysqli, $col_apus_in_b5);
        $fac_prod_in_b5 = mysqli_real_escape_string($mysqli, $fac_prod_in_b5);
        $o_apus_in_b5 = mysqli_real_escape_string($mysqli, $o_apus_in_b5);
        $col_labc_in_b5 = mysqli_real_escape_string($mysqli, $col_labc_in_b5);
        $fac_labc_in_b5 = mysqli_real_escape_string($mysqli, $fac_labc_in_b5);
        $total_labcs_in_b5 = mysqli_real_escape_string($mysqli, $total_labcs_in_b5);

        $stmt = "update `o_desc_in_b7` set `layout_id`='$layout_id', `window_id`='$window_id', `col_amount_in_b7`='$col_amount1_in_b5', `col_price_in_b7`='$col_price_in_b5', `fac_cl_in_b7`='$fac_cl_in_b5', `o_price_in_b7`='$o_price_in_b5', `col_apus_in_b7`='$col_apus_in_b5', `fac_prod_in_b7`='$fac_prod_in_b5', `o_apus_in_b7`='$o_apus_in_b5', `col_labc_in_b7`='$col_labc_in_b5', `fac_labc_in_b7`='$fac_labc_in_b5',`total_labcs_in_b7`='$o_labcs_in_b5' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b72($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '0');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '0');

        $col_amount_in_b7 = mysqli_real_escape_string($mysqli, $data->col_amount_in_b7 ?? 0.0);
        $col_price_in_b7 = mysqli_real_escape_string($mysqli, $data->col_price_in_b7 ?? 0.0);
        $fac_cl_in_b7 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b7 ?? 1.0);
        $o_price_in_b7 = mysqli_real_escape_string($mysqli, $data->o_price_in_b7 ?? 0.0);
        $col_apus_in_b7 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b7 ?? 0.0);
        $fac_prod_in_b7 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b7 ?? 1.0);
        $o_apus_in_b7 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b7 ?? 0.0);
        $col_labc_in_b7 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b7 ?? 0.0);
        $fac_labc_in_b7 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b7 ?? 1.0);
        $total_labcs_in_b7 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b7 ?? 0.0);

        $p1700_fac = mysqli_real_escape_string($mysqli, $data->p1700_fac ?? 1.0);
        $p1701_fac = mysqli_real_escape_string($mysqli, $data->p1701_fac ?? 1.0);
        $p1702_fac = mysqli_real_escape_string($mysqli, $data->p1702_fac ?? 1.0);
        $p1703_fac = mysqli_real_escape_string($mysqli, $data->p1703_fac ?? 1.0);
        $p1704_fac = mysqli_real_escape_string($mysqli, $data->p1704_fac ?? 1.0);
        $p1706_fac = mysqli_real_escape_string($mysqli, $data->p1706_fac ?? 1.0);
        $p1707_fac = mysqli_real_escape_string($mysqli, $data->p1707_fac ?? 1.0);
        $p1708_fac = mysqli_real_escape_string($mysqli, $data->p1708_fac ?? 1.0);

        $p1721_fac = mysqli_real_escape_string($mysqli, $data->p1721_fac ?? 1.0);
        $p1722_fac = mysqli_real_escape_string($mysqli, $data->p1722_fac ?? 1.0);
        $p1723_fac = mysqli_real_escape_string($mysqli, $data->p1723_fac ?? 1.0);
        $p1724_fac = mysqli_real_escape_string($mysqli, $data->p1724_fac ?? 1.0);
        $p1726_fac = mysqli_real_escape_string($mysqli, $data->p1726_fac ?? 1.0);
        $p1727_fac = mysqli_real_escape_string($mysqli, $data->p1727_fac ?? 1.0);
        $p1728_fac = mysqli_real_escape_string($mysqli, $data->p1728_fac ?? 1.0);

        $p1741_fac = mysqli_real_escape_string($mysqli, $data->p1741_fac ?? 1.0);
        $p1742_fac = mysqli_real_escape_string($mysqli, $data->p1742_fac ?? 1.0);
        $p1743_fac = mysqli_real_escape_string($mysqli, $data->p1743_fac ?? 1.0);
        $p1744_fac = mysqli_real_escape_string($mysqli, $data->p1744_fac ?? 1.0);
        $p1746_fac = mysqli_real_escape_string($mysqli, $data->p1746_fac ?? 1.0);
        $p1747_fac = mysqli_real_escape_string($mysqli, $data->p1747_fac ?? 1.0);
        $p1748_fac = mysqli_real_escape_string($mysqli, $data->p1748_fac ?? 1.0);

        $stmt = "update `o_desc_in_b7` set `layout_id`='$layout_id', `window_id`='$window_id', `col_amount_in_b7`='$col_amount_in_b7',`p1700_fac`='$p1700_fac',`p1701_fac`='$p1701_fac',`p1702_fac`='$p1702_fac',`p1703_fac`='$p1703_fac',`p1704_fac`='$p1704_fac',`p1706_fac`='$p1706_fac',`p1707_fac`='$p1707_fac',`p1708_fac`='$p1708_fac',`p1721_fac`='$p1721_fac',`p1722_fac`='$p1722_fac',`p1723_fac`='$p1723_fac',`p1724_fac`='$p1724_fac',`p1726_fac`='$p1726_fac',`p1727_fac`='$p1727_fac',`p1728_fac`='$p1728_fac',`p1741_fac`='$p1741_fac',`p1742_fac`='$p1742_fac',`p1743_fac`='$p1743_fac',`p1744_fac`='$p1744_fac',`p1746_fac`='$p1746_fac',`p1747_fac`='$p1747_fac',`p1748_fac`='$p1748_fac', `col_price_in_b7`='$col_price_in_b7', `fac_cl_in_b7`='$fac_cl_in_b7', `o_price_in_b7`='$o_price_in_b7', `col_apus_in_b7`='$col_apus_in_b7', `fac_prod_in_b7`='$fac_prod_in_b7', `o_apus_in_b7`='$o_apus_in_b7', `col_labc_in_b7`='$col_labc_in_b7', `fac_labc_in_b7`='$fac_labc_in_b7',`total_labcs_in_b7`='$total_labcs_in_b7' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_in_b8($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '0');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '0');

        $col_amount_in_b8 = mysqli_real_escape_string($mysqli, $data->col_amount_in_b8 ?? 0.0);
        $col_price_in_b8 = mysqli_real_escape_string($mysqli, $data->col_price_in_b8 ?? 0.0);
        $fac_cl_in_b8 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b8 ?? 1.0);
        $o_price_in_b8 = mysqli_real_escape_string($mysqli, $data->o_price_in_b8 ?? 0.0);
        $col_apus_in_b8 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b8 ?? 0.0);
        $fac_prod_in_b8 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b8 ?? 1.0);
        $o_apus_in_b8 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b8 ?? 0.0);
        $col_labc_in_b8 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b8 ?? 0.0);
        $fac_labc_in_b8 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b8 ?? 1.0);
        $total_labcs_in_b8 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b8 ?? 0.0);

        $p1800_fac = mysqli_real_escape_string($mysqli, $data->p1800_fac ?? 1.0);
        $p1801_fac = mysqli_real_escape_string($mysqli, $data->p1801_fac ?? 1.0);
        $p1802_fac = mysqli_real_escape_string($mysqli, $data->p1802_fac ?? 1.0);
        $p1803_fac = mysqli_real_escape_string($mysqli, $data->p1803_fac ?? 1.0);
        $p1804_fac = mysqli_real_escape_string($mysqli, $data->p1804_fac ?? 1.0);
        $p1806_fac = mysqli_real_escape_string($mysqli, $data->p1806_fac ?? 1.0);
        $p1807_fac = mysqli_real_escape_string($mysqli, $data->p1807_fac ?? 1.0);
        $p1808_fac = mysqli_real_escape_string($mysqli, $data->p1808_fac ?? 1.0);

        $p1821_fac = mysqli_real_escape_string($mysqli, $data->p1821_fac ?? 1.0);
        $p1822_fac = mysqli_real_escape_string($mysqli, $data->p1822_fac ?? 1.0);
        $p1823_fac = mysqli_real_escape_string($mysqli, $data->p1823_fac ?? 1.0);
        $p1824_fac = mysqli_real_escape_string($mysqli, $data->p1824_fac ?? 1.0);
        $p1826_fac = mysqli_real_escape_string($mysqli, $data->p1826_fac ?? 1.0);
        $p1827_fac = mysqli_real_escape_string($mysqli, $data->p1827_fac ?? 1.0);
        $p1828_fac = mysqli_real_escape_string($mysqli, $data->p1828_fac ?? 1.0);

        $p1841_fac = mysqli_real_escape_string($mysqli, $data->p1841_fac ?? 1.0);
        $p1842_fac = mysqli_real_escape_string($mysqli, $data->p1842_fac ?? 1.0);
        $p1843_fac = mysqli_real_escape_string($mysqli, $data->p1843_fac ?? 1.0);
        $p1844_fac = mysqli_real_escape_string($mysqli, $data->p1844_fac ?? 1.0);
        $p1846_fac = mysqli_real_escape_string($mysqli, $data->p1846_fac ?? 1.0);
        $p1847_fac = mysqli_real_escape_string($mysqli, $data->p1847_fac ?? 1.0);
        $p1848_fac = mysqli_real_escape_string($mysqli, $data->p1848_fac ?? 1.0);

        $stmt = "update `o_desc_in_b8` set `layout_id`='$layout_id', `window_id`='$window_id', `col_amount_in_b8`='$col_amount_in_b8',`p1800_fac`='$p1800_fac',`p1801_fac`='$p1801_fac',
        `p1802_fac`='$p1802_fac',`p1803_fac`='$p1803_fac',`p1804_fac`='$p1804_fac',`p1806_fac`='$p1806_fac',`p1807_fac`='$p1807_fac',
        `p1808_fac`='$p1808_fac',`p1821_fac`='$p1821_fac',`p1822_fac`='$p1822_fac',`p1823_fac`='$p1823_fac',`p1824_fac`='$p1824_fac',
        `p1826_fac`='$p1826_fac',`p1827_fac`='$p1827_fac',`p1828_fac`='$p1828_fac',`p1841_fac`='$p1841_fac',`p1842_fac`='$p1842_fac',
        `p1843_fac`='$p1843_fac',`p1844_fac`='$p1844_fac',`p1846_fac`='$p1846_fac',`p1847_fac`='$p1847_fac',`p1848_fac`='$p1848_fac',
         `col_price_in_b8`='$col_price_in_b8', `fac_cl_in_b8`='$fac_cl_in_b8', `o_price_in_b8`='$o_price_in_b8', 
         `col_apus_in_b8`='$col_apus_in_b8', `fac_prod_in_b8`='$fac_prod_in_b8', `o_apus_in_b8`='$o_apus_in_b8', 
         `col_labc_in_b8`='$col_labc_in_b8', `fac_labc_in_b8`='$fac_labc_in_b8',`total_labcs_in_b8`='$total_labcs_in_b8' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_clients_by_ls_id($co_ls_id)
    {
        $mysqli = $this->dbconnect();
        $co_ls_id = mysqli_real_escape_string($mysqli, $co_ls_id);
        $param = "%" . $co_ls_id . "%";

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `ls_ids` like ?");
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_clients_by_l_last_name($l_last_name)
    {
        $mysqli = $this->dbconnect();
        $l_last_name = mysqli_real_escape_string($mysqli, $l_last_name);
        $param = "%" . $l_last_name . "%";

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `l_last_name` like ?");
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_clients_by_l_last_name_c_last_name($l_last_name)
    {
        $mysqli = $this->dbconnect();
        $l_last_name = mysqli_real_escape_string($mysqli, $l_last_name);
        $param = "%" . $l_last_name . "%";

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where (`l_last_name` like ?) or (`c_last_name` like ?)");
        mysqli_stmt_bind_param($stmt, "ss", $param, $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_clients_by_mc_id($mc_id)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `mc_id`=? and `c_status`='active'");
        mysqli_stmt_bind_param($stmt, "i", $mc_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_order_extension($om_id)
    {
        $mysqli = $this->dbconnect();
        $om_id = mysqli_real_escape_string($mysqli, $om_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `om_id`=? and `o_status`<'10' order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $om_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_order_website($ls_id)
    {
        $mysqli = $this->dbconnect();
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = "select * from `lic_sites` where `ls_id`='$ls_id'";
        //mysqli_stmt_bind_param($stmt,"s",$ls_id);

        //mysqli_stmt_execute($stmt);

        //$result=mysqli_stmt_get_result($stmt);
        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_ex_b5($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_ex_b5` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_ex_b1($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_ex_b1` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_g_b1($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_g_b1` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_ex_b6($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_ex_b6` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_ex_b7($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_ex_b7` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_ex_b8($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_ex_b8` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_o_desc_ex_b5($o_id, $levels_over_ground, $col_amount1_ex_b5, $col_price_ex_b5, $fac_cl_ex_b5, $o_price_ex_b5, $col_apus_ex_b5, $fac_prod_ex_b5, $o_apus_ex_b5, $col_labc_ex_b5, $fac_labc_ex_b5, $total_labcs_ex_b5)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $levels_over_ground);
        $col_amount1_ex_b5 = mysqli_real_escape_string($mysqli, $col_amount1_ex_b5);
        $col_price_ex_b5 = mysqli_real_escape_string($mysqli, $col_price_ex_b5);
        $fac_cl_ex_b5 = mysqli_real_escape_string($mysqli, $fac_cl_ex_b5);
        $o_price_ex_b5 = mysqli_real_escape_string($mysqli, $o_price_ex_b5);
        $col_apus_ex_b5 = mysqli_real_escape_string($mysqli, $col_apus_ex_b5);
        $fac_prod_ex_b5 = mysqli_real_escape_string($mysqli, $fac_prod_ex_b5);
        $o_apus_ex_b5 = mysqli_real_escape_string($mysqli, $o_apus_ex_b5);
        $col_labc_ex_b5 = mysqli_real_escape_string($mysqli, $col_labc_ex_b5);
        $fac_labc_ex_b5 = mysqli_real_escape_string($mysqli, $fac_labc_ex_b5);
        $total_labcs_ex_b5 = mysqli_real_escape_string($mysqli, $total_labcs_ex_b5);

        $stmt = "update `o_desc_ex_b5` set `levels_over_ground`='$levels_over_ground',`col_amount_ex_b5`='$col_amount1_ex_b5',`col_price_ex_b5`='$col_price_ex_b5',`fac_cl_ex_b5`='$fac_cl_ex_b5',`o_price_ex_b5`='$o_price_ex_b5',`col_apus_ex_b5`='$col_apus_ex_b5',`fac_prod_ex_b5`='$fac_prod_ex_b5',`o_apus_ex_b5`='$o_apus_ex_b5',`col_labc_ex_b5`='$col_labc_ex_b5',`fac_labc_ex_b5`='$fac_labc_ex_b5',`total_labcs_ex_b5`='$total_labcs_ex_b5' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt);

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b52($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground ?? 0);

        $p1561_fac = mysqli_real_escape_string($mysqli, $data->p1561_fac ?? 1.0);
        $p1563_fac = mysqli_real_escape_string($mysqli, $data->p1563_fac ?? 1.0);
        $p1566_fac = mysqli_real_escape_string($mysqli, $data->p1566_fac ?? 1.0);

        $col_amount1_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b5 ?? 0.0);
        $col_price_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b5 ?? 0.0);
        $fac_cl_ex_b5 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b5 ?? 1.0);
        $o_price_ex_b5 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b5 ?? 0.0);
        $col_apus_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b5 ?? 0.0);
        $fac_prod_ex_b5 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b5 ?? 1.0);
        $o_apus_ex_b5 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b5 ?? 0.0);
        $col_labc_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b5 ?? 0.0);
        $fac_labc_ex_b5 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b5 ?? 1.0);
        $total_labcs_ex_b5 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b5 ?? 0.0);

        $stmt = "update `o_desc_ex_b5` set `levels_over_ground`='$levels_over_ground',`col_amount_ex_b5`='$col_amount1_ex_b5',`p1561_fac`='$p1561_fac',`p1563_fac`='$p1563_fac',`p1566_fac`='$p1566_fac',`col_price_ex_b5`='$col_price_ex_b5',`fac_cl_ex_b5`='$fac_cl_ex_b5',`o_price_ex_b5`='$o_price_ex_b5',`col_apus_ex_b5`='$col_apus_ex_b5',`fac_prod_ex_b5`='$fac_prod_ex_b5',`o_apus_ex_b5`='$o_apus_ex_b5',`col_labc_ex_b5`='$col_labc_ex_b5',`fac_labc_ex_b5`='$fac_labc_ex_b5',`total_labcs_ex_b5`='$total_labcs_ex_b5' where `o_id`='$o_id'";
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b1($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground);

        $p1168_fac = mysqli_real_escape_string($mysqli, $data->p1168_fac);
        $p1163_fac = mysqli_real_escape_string($mysqli, $data->p1163_fac);
        $p1166_fac = mysqli_real_escape_string($mysqli, $data->p1166_fac);
        $p116m_fac = mysqli_real_escape_string($mysqli, $data->p116m_fac);
        $p116b_fac = mysqli_real_escape_string($mysqli, $data->p116b_fac);
        $p116t_fac = mysqli_real_escape_string($mysqli, $data->p116t_fac);
        $p118s_fac = mysqli_real_escape_string($mysqli, $data->p118s_fac);

        $col_amount1_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b1);
        $col_price_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b1);
        $fac_cl_ex_b1 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b1);
        $o_price_ex_b1 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b1);
        $col_apus_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b1);
        $fac_prod_ex_b1 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b1);
        $o_apus_ex_b1 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b1);
        $col_labc_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b1);
        $fac_labc_ex_b1 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b1);
        $total_labcs_ex_b1 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b1);

        $stmt = "update `o_desc_ex_b1` set `levels_over_ground`='$levels_over_ground',`col_amount_ex_b1`='$col_amount1_ex_b1',`p1168_fac`='$p1168_fac',`p116m_fac`='$p116m_fac',`p116b_fac`='$p116b_fac',`p116t_fac`='$p116t_fac',`p118s_fac`='$p118s_fac',`p1163_fac`='$p1163_fac',`p1166_fac`='$p1166_fac',`col_price_ex_b1`='$col_price_ex_b1',`fac_cl_ex_b1`='$fac_cl_ex_b1',`o_price_ex_b1`='$o_price_ex_b1',`col_apus_ex_b1`='$col_apus_ex_b1',`fac_prod_ex_b1`='$fac_prod_ex_b1',`o_apus_ex_b1`='$o_apus_ex_b1',`col_labc_ex_b1`='$col_labc_ex_b1',`fac_labc_ex_b1`='$fac_labc_ex_b1',`total_labcs_ex_b1`='$total_labcs_ex_b1' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_g_b1($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        

        $p11g8_fac = mysqli_real_escape_string($mysqli, $data->p11g8_fac);
        $p11g3_fac = mysqli_real_escape_string($mysqli, $data->p11g3_fac);
        $p11g6_fac = mysqli_real_escape_string($mysqli, $data->p11g6_fac);
        $p11gm_fac = mysqli_real_escape_string($mysqli, $data->p11gm_fac);
        $p11gb_fac = mysqli_real_escape_string($mysqli, $data->p11gb_fac);
        $p11gt_fac = mysqli_real_escape_string($mysqli, $data->p11gt_fac);
        $p11gs_fac = mysqli_real_escape_string($mysqli, $data->p11gs_fac);

        $col_amount1_g_b1 = mysqli_real_escape_string($mysqli, $data->col_amount_g_b1);
        $col_price_g_b1 = mysqli_real_escape_string($mysqli, $data->col_price_g_b1);
        $fac_cl_g_b1 = mysqli_real_escape_string($mysqli, $data->fac_cl_g_b1);
        $o_price_g_b1 = mysqli_real_escape_string($mysqli, $data->o_price_g_b1);
        $col_apus_g_b1 = mysqli_real_escape_string($mysqli, $data->col_apus_g_b1);
        $fac_prod_g_b1 = mysqli_real_escape_string($mysqli, $data->fac_prod_g_b1);
        $o_apus_g_b1 = mysqli_real_escape_string($mysqli, $data->o_apus_g_b1);
        $col_labc_g_b1 = mysqli_real_escape_string($mysqli, $data->col_labc_g_b1);
        $fac_labc_g_b1 = mysqli_real_escape_string($mysqli, $data->fac_labc_g_b1);
        $total_labcs_g_b1 = mysqli_real_escape_string($mysqli, $data->total_labcs_g_b1);

        $stmt = "update `o_desc_g_b1` set `col_amount_g_b1`='$col_amount1_g_b1',`p11g8_fac`='$p11g8_fac',`p11gm_fac`='$p11gm_fac',`p11gb_fac`='$p11gb_fac',`p11gt_fac`='$p11gt_fac',`p11gs_fac`='$p11gs_fac',`p11g3_fac`='$p11g3_fac',`p11g6_fac`='$p11g6_fac',`col_price_g_b1`='$col_price_g_b1',`fac_cl_g_b1`='$fac_cl_g_b1',`o_price_g_b1`='$o_price_g_b1',`col_apus_g_b1`='$col_apus_g_b1',`fac_prod_g_b1`='$fac_prod_g_b1',`o_apus_g_b1`='$o_apus_g_b1',`col_labc_g_b1`='$col_labc_g_b1',`fac_labc_g_b1`='$fac_labc_g_b1',`total_labcs_g_b1`='$total_labcs_g_b1' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b6($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        //$levels_over_ground=mysqli_real_escape_string($mysqli,$data->levels_over_ground);

        $p1661_fac = mysqli_real_escape_string($mysqli, $data->p1661_fac ?? 1.0);
        $p1663_fac = mysqli_real_escape_string($mysqli, $data->p1663_fac ?? 1.0);
        $p1666_fac = mysqli_real_escape_string($mysqli, $data->p1666_fac ?? 1.0);
        $p166p_fac = mysqli_real_escape_string($mysqli, $data->p166p_fac ?? 1.0);

        $col_amount1_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b6 ?? 0.0);
        $col_price_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b6 ?? 0.0);
        $fac_cl_ex_b6 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b6 ?? 1.0);
        $o_price_ex_b6 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b6 ?? 0.0);
        $col_apus_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b6 ?? 0.0);
        $fac_prod_ex_b6 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b6 ?? 1.0);
        $o_apus_ex_b6 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b6 ?? 0.0);
        $col_labc_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b6 ?? 0.0);
        $fac_labc_ex_b6 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b6 ?? 1.0);
        $total_labcs_ex_b6 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b6 ?? 0.0);

        $stmt = "update `o_desc_ex_b6` set `col_amount_ex_b6`='$col_amount1_ex_b6',`p1661_fac`='$p1661_fac',`p1663_fac`='$p1663_fac',`p1666_fac`='$p1666_fac',`p166p_fac`='$p166p_fac',`col_price_ex_b6`='$col_price_ex_b6',`fac_cl_ex_b6`='$fac_cl_ex_b6',`o_price_ex_b6`='$o_price_ex_b6',`col_apus_ex_b6`='$col_apus_ex_b6',`fac_prod_ex_b6`='$fac_prod_ex_b6',`o_apus_ex_b6`='$o_apus_ex_b6',`col_labc_ex_b6`='$col_labc_ex_b6',`fac_labc_ex_b6`='$fac_labc_ex_b6',`total_labcs_ex_b6`='$total_labcs_ex_b6' where `o_id`='$o_id'";
       
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b7($o_id, $levels_over_ground, $col_amount1_ex_b5, $col_price_ex_b5, $fac_cl_ex_b5, $o_price_ex_b5, $col_apus_ex_b5, $fac_prod_ex_b5, $o_apus_ex_b5, $col_labc_ex_b5, $fac_labc_ex_b5, $total_labcs_ex_b5)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $levels_over_ground);
        $col_amount1_ex_b5 = mysqli_real_escape_string($mysqli, $col_amount1_ex_b5);
        $col_price_ex_b5 = mysqli_real_escape_string($mysqli, $col_price_ex_b5);
        $fac_cl_ex_b5 = mysqli_real_escape_string($mysqli, $fac_cl_ex_b5);
        $o_price_ex_b5 = mysqli_real_escape_string($mysqli, $o_price_ex_b5);
        $col_apus_ex_b5 = mysqli_real_escape_string($mysqli, $col_apus_ex_b5);
        $fac_prod_ex_b5 = mysqli_real_escape_string($mysqli, $fac_prod_ex_b5);
        $o_apus_ex_b5 = mysqli_real_escape_string($mysqli, $o_apus_ex_b5);
        $col_labc_ex_b5 = mysqli_real_escape_string($mysqli, $col_labc_ex_b5);
        $fac_labc_ex_b5 = mysqli_real_escape_string($mysqli, $fac_labc_ex_b5);
        $total_labcs_ex_b5 = mysqli_real_escape_string($mysqli, $total_labcs_ex_b5);

        $stmt = "update `o_desc_ex_b7` set `levels_over_ground`='$levels_over_ground',`col_amount_ex_b7`='$col_amount1_ex_b5',`col_price_ex_b7`='$col_price_ex_b5',`fac_cl_ex_b7`='$fac_cl_ex_b5',`o_price_ex_b7`='$o_price_ex_b5',`col_apus_ex_b7`='$col_apus_ex_b5',`fac_prod_ex_b7`='$fac_prod_ex_b5',`o_apus_ex_b7`='$o_apus_ex_b5',`col_labc_ex_b7`='$col_labc_ex_b5',`fac_labc_ex_b7`='$fac_labc_ex_b5',`total_labcs_ex_b7`='$total_labcs_ex_b5' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt);

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b72($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        
        $col_amount_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b7 ?? 0.0);

        $p1761_fac = mysqli_real_escape_string($mysqli, $data->p1761_fac ?? 1.0);
        $p1762_fac = mysqli_real_escape_string($mysqli, $data->p1762_fac ?? 1.0);
        $p1763_fac = mysqli_real_escape_string($mysqli, $data->p1763_fac ?? 1.0);
        $p1766_fac = mysqli_real_escape_string($mysqli, $data->p1766_fac ?? 1.0);

        $col_price_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b7 ?? 0.0);
        $fac_cl_ex_b7 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b7 ?? 1.0);
        $o_price_ex_b7 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b7 ?? 0.0);
        $col_apus_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b7 ?? 0.0);
        $fac_prod_ex_b7 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b7 ?? 1.0);
        $o_apus_ex_b7 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b7 ?? 0.0);
        $col_labc_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b7 ?? 0.0);
        $fac_labc_ex_b7 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b7 ?? 1.0);
        $total_labcs_ex_b7 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b7 ?? 0.0);

        $stmt = "update `o_desc_ex_b7` set `col_amount_ex_b7`='$col_amount_ex_b7',`p1761_fac`='$p1761_fac',`p1762_fac`='$p1762_fac',`p1763_fac`='$p1763_fac',`p1766_fac`='$p1766_fac',`col_price_ex_b7`='$col_price_ex_b7',`fac_cl_ex_b7`='$fac_cl_ex_b7',`o_price_ex_b7`='$o_price_ex_b7',`col_apus_ex_b7`='$col_apus_ex_b7',`fac_prod_ex_b7`='$fac_prod_ex_b7',`o_apus_ex_b7`='$o_apus_ex_b7',`col_labc_ex_b7`='$col_labc_ex_b7',`fac_labc_ex_b7`='$fac_labc_ex_b7',`total_labcs_ex_b7`='$total_labcs_ex_b7' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt);

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b8($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        
        $col_amount_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b8 ?? 0.0);

        $p1861_fac = mysqli_real_escape_string($mysqli, $data->p1861_fac ?? 1.0);
        $p1863_fac = mysqli_real_escape_string($mysqli, $data->p1863_fac ?? 1.0);
        $p1866_fac = mysqli_real_escape_string($mysqli, $data->p1866_fac ?? 1.0);

        $col_price_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b8 ?? 0.0);
        $fac_cl_ex_b8 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b8 ?? 1.0);
        $o_price_ex_b8 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b8 ?? 0.0);
        $col_apus_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b8 ?? 0.0);
        $fac_prod_ex_b8 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b8 ?? 1.0);
        $o_apus_ex_b8 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b8 ?? 0.0);
        $col_labc_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b8 ?? 0.0);
        $fac_labc_ex_b8 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b8 ?? 1.0);
        $total_labcs_ex_b8 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b8 ?? 0.0);

        $stmt = "update `o_desc_ex_b8` set `col_amount_ex_b8`='$col_amount_ex_b8',`p1861_fac`='$p1861_fac',`p1863_fac`='$p1863_fac',`p1866_fac`='$p1866_fac',`col_price_ex_b8`='$col_price_ex_b8',`fac_cl_ex_b8`='$fac_cl_ex_b8',`o_price_ex_b8`='$o_price_ex_b8',`col_apus_ex_b8`='$col_apus_ex_b8',`fac_prod_ex_b8`='$fac_prod_ex_b8',`o_apus_ex_b8`='$o_apus_ex_b8',`col_labc_ex_b8`='$col_labc_ex_b8',`fac_labc_ex_b8`='$fac_labc_ex_b8',`total_labcs_ex_b8`='$total_labcs_ex_b8' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt);

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_column($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $column_name = mysqli_real_escape_string($mysqli, $data->column_name);
        $value = mysqli_real_escape_string($mysqli, $data->value);

        $stmt = "update `o_desc_ex_b5` set `" . $column_name . "`='$value' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function ajax_update_o_desc_allproducts($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $column_name = mysqli_real_escape_string($mysqli, $data->column_name);
        $value = mysqli_real_escape_string($mysqli, $data->value);

        $stmt = "update `o_desc_allproducts` set `" . $column_name . "`='$value' where `o_id`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b7_column($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $column_name = mysqli_real_escape_string($mysqli, $data->column_name);
        $value = mysqli_real_escape_string($mysqli, $data->value);

        $stmt = "update `o_desc_ex_b7` set `" . $column_name . "`='$value' where `o_id`='$o_id'";
        //mysqli_stmt_bind_param($stmt,"si",$basement,$o_id);
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        //mysqli_stmt_execute($stmt);

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    //these function will be removed in the future and used
    public function update_o_desc_ex_b5_basement($o_id, $basement)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $basement = mysqli_real_escape_string($mysqli, $basement);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `basement`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $basement, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_levels_over_ground($o_id, $levels_over_ground)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $levels_over_ground);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `levels_over_ground`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $levels_over_ground, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_wlc_id($o_id, $wlc_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $wlc_id = mysqli_real_escape_string($mysqli, $wlc_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `wlc_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $wlc_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_order_st_id($o_id, $st_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $st_id = mysqli_real_escape_string($mysqli, $st_id);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `st_id`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "si", $st_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_rmp_id($o_id, $rmp_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $rmp_id = mysqli_real_escape_string($mysqli, $rmp_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `rmp_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $rmp_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_e_lenght($o_id, $e_length)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $e_length = mysqli_real_escape_string($mysqli, $e_length);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `e_length`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $e_length, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_e_width($o_id, $e_width)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $e_width = mysqli_real_escape_string($mysqli, $e_width);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `e_width`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $e_width, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_r_tilt($o_id, $r_tilt)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $r_tilt = mysqli_real_escape_string($mysqli, $r_tilt);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `r_tilt`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "ii", $r_tilt, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_r_kneewall($o_id, $r_kneewall)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $r_kneewall = mysqli_real_escape_string($mysqli, $r_kneewall);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `r_kneewall`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "ii", $r_kneewall, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_rs_id($o_id, $rs_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $rs_id = mysqli_real_escape_string($mysqli, $rs_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `rs_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $rs_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_rop_id($o_id, $rop_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $rop_id = mysqli_real_escape_string($mysqli, $rop_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `rop_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $rop_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_ww_id($o_id, $ww_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $ww_id = mysqli_real_escape_string($mysqli, $ww_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `ww_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $ww_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_wc_id($o_id, $wc_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $wc_id = mysqli_real_escape_string($mysqli, $wc_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `wc_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $wc_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_pbp_id($o_id, $pbp_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $pbp_id = mysqli_real_escape_string($mysqli, $pbp_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `pbp_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $pbp_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_door_texture($o_id, $door_texture)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $door_texture = mysqli_real_escape_string($mysqli, $door_texture);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `door_texture`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $door_texture, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_dps_id($o_id, $dsp_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $dsp_id = mysqli_real_escape_string($mysqli, $dsp_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `dsp_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $dsp_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_door_color($o_id, $door_color)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $door_color = mysqli_real_escape_string($mysqli, $door_color);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `door_color`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $door_color, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_gc_id($o_id, $gc_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $gc_id = mysqli_real_escape_string($mysqli, $gc_id);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `gc_id`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $gc_id, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_desc_ex_b5_garage_size($o_id, $gc_length, $gc_width)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $gc_length = mysqli_real_escape_string($mysqli, $gc_length);
        $gc_width = mysqli_real_escape_string($mysqli, $gc_width);

        $stmt = mysqli_prepare($mysqli, "update `o_desc_ex_b5` set `gc_length`=?, `gc_width`=? where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "iii", $gc_length, $gc_width, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function change_of_level($of_id, $of_level)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);
        $of_level = mysqli_real_escape_string($mysqli, $of_level);
        $stmt = mysqli_prepare($mysqli, "update `o_files` set `of_level`=? where `of_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $of_level, $of_id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function change_of_kind($of_id, $of_kind)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);
        $of_kind = mysqli_real_escape_string($mysqli, $of_kind);
        $stmt = mysqli_prepare($mysqli, "update `o_files` set `of_kind`=? where `of_id`=?");
        mysqli_stmt_bind_param($stmt, "ii", $of_kind, $of_id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_customer_files_title_intern($of_id, $title_intern)
    {
        $mysqli = $this->dbconnect();

        $of_id = mysqli_real_escape_string($mysqli, $of_id);
        $title_intern = mysqli_real_escape_string($mysqli, $title_intern);

        $stmt = mysqli_prepare($mysqli, "update `o_files` set `of_subtitle`=? where `of_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $title_intern, $of_id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_iframe_link($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $orf_path_dom = mysqli_real_escape_string($mysqli, $data->orf_path_dom);

        $stmt = mysqli_prepare($mysqli, "update `o_results` set `orf_path_dom`=? where `orf_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $orf_path_dom, $orf_id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function change_of_position($of_id, $of_position)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);
        $of_position = mysqli_real_escape_string($mysqli, $of_position);
        $stmt = mysqli_prepare($mysqli, "update `o_files` set `of_position`=? where `of_id`=?");
        mysqli_stmt_bind_param($stmt, "ii", $of_position, $of_id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function change_of_exterior_position($of_id, $of_position)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);
        $of_position = mysqli_real_escape_string($mysqli, $of_position);
        $stmt = mysqli_prepare($mysqli, "update `o_files` set `of_exterior_position`=? where `of_id`=?");
        mysqli_stmt_bind_param($stmt, "ii", $of_position, $of_id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function rename_in_client_file($of_id, $of_name)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);
        $of_name = mysqli_real_escape_string($mysqli, $of_name);

        $sql = "update `o_files` set `of_name`='$of_name' where `of_id`='$of_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function plan_object_file_rename($plan_id, $file_name)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);
        $file_name = mysqli_real_escape_string($mysqli, $file_name);

        $sql = "update `pls_files` set `file_name`='$file_name' where `plan_id`='$plan_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function plan_object_title_rename($plan_id, $title)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);
        $title = mysqli_real_escape_string($mysqli, $title);

        $sql = "update `pls_files` set `title`='$title' where `plan_id`='$plan_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function plan_object_pls_id_rename($plan_id, $pls_id)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);
        $pls_id = mysqli_real_escape_string($mysqli, $pls_id);

        $sql = "update `pls_files` set `pls_id`='$pls_id' where `plan_id`='$plan_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function plan_object_change_country($plan_id, $a_id)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);
        $a_id = mysqli_real_escape_string($mysqli, $a_id);

        $sql = "update `pls_files` set `a_id`='$a_id' where `plan_id`='$plan_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function plan_object_change_kind($plan_id, $plan_kind)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);
        $plan_kind = mysqli_real_escape_string($mysqli, $plan_kind);

        $sql = "update `pls_files` set `plan_kind`='$plan_kind' where `plan_id`='$plan_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }


    public function plan_object_change_language($plan_id, $lang_id)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);
        $lang_id = mysqli_real_escape_string($mysqli, $lang_id);

        $sql = "update `pls_files` set `lang_id`='$lang_id' where `plan_id`='$plan_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function rename_ex_client_file($of_id, $of_name_ex)
    {
        $mysqli = $this->dbconnect();
        $of_id = mysqli_real_escape_string($mysqli, $of_id);
        $of_name_ex = mysqli_real_escape_string($mysqli, $of_name_ex);

        $sql = "update `o_files` set `of_name_ex`='$of_name_ex' where `of_id`='$of_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function result_file_rename($orf_id, $orf_name)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $orf_name = mysqli_real_escape_string($mysqli, $orf_name);
        $sql = "update `o_results` set `orf_name`='$orf_name' where `orf_id`='$orf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_optimized_result_file_path($orf_id, $optimized_image_path)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $optimized_image_path = mysqli_real_escape_string($mysqli, $optimized_image_path);

        $sql = "update `o_results` set `optimized_image_path`='$optimized_image_path' where `orf_id`='$orf_id'";

        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function send_trader_purchaser_message($orderid, $uca_id, $message)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $message = mysqli_real_escape_string($mysqli, $message);
        $sql = "insert into `trader_purchaser_messages`(`o_id`,`client_id`,`uca_id`,`message`,`msg_status`) values('$orderid','0','$uca_id','$message','0')";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function send_client_trader_message($orderid, $client_id, $message)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "insert into `trader_purchaser_messages`(`o_id`,`client_id`,`message`) values(?,?,?)");
        mysqli_stmt_bind_param($stmt, "iis", $orderid, $client_id, $message);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_all_trader_purchaser_messages($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $sql = "select * from `trader_purchaser_messages` where `o_id`='$orderid' order by `msg_id` desc";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function send_email_customer($to, $subject, $message, $name, $from)
    {
        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $header .= "from: " . $name . " <" . $from . ">";


        $body .= "<p>" . $message . "</p>";
        $message_sent = mail($to, $subject, $body, $header);

        return $message_sent;
    }

    public function check_num_products($orderid, $product)
    {
        $mysqli = $this->dbconnect();
        $sql = "select * from `o_prods` where `o_id`='$orderid' and `prod_id`='$product'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $row = mysqli_num_rows($result);

        mysqli_close($mysqli);

        return $row;
    }

    public function delete_creator_file($orfid)
    {
        $row = $this->get_creator_file($orfid);

        if (!empty($row['orf_path_dom'])) {
            $directory_path = "../result_files/" . $row['orf_path_dom'];

            if (!empty($row['orf_internal_name_dom'])) {
                $file_path = "../result_files/" . $row['orf_path_dom'] . $row['orf_internal_name_dom'];
            }
        }

        if (!empty($row['orf_thumbnail_path'])) {
            $thunbnail_file_path = "../result_thumbnail_files/" .$row['orf_thumbnail_path'];
        }

        if (!empty($row['orf_compress_path'])) {
            $compress_file_path = "../result_compress_files/" .$row['orf_compress_path'];
        }

        if (file_exists($file_path)) {
            if ($row['orf_type_dom'] == "html") {
                //echo "1 ".$directory_path;
                $this->clear_directory($directory_path);
            } else {
                unlink($file_path);
            }
        }

        if (file_exists($thunbnail_file_path)) 
        {
            unlink($thunbnail_file_path);
        }

        if (file_exists($compress_file_path)) 
        {
            unlink($compress_file_path);
        }

        $mysqli = $this->dbconnect();

        $orfid = mysqli_real_escape_string($mysqli, $orfid);
        $sql = "delete from `o_results` where `orf_id`=?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $orfid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_o_results_configurator_plus($orfid)
    {
        $mysqli = $this->dbconnect();

        $orfid = mysqli_real_escape_string($mysqli, $orfid);

        $sql = "delete from `o_results_configurator_plus` where `orf_id`=?";
        $stmt = mysqli_prepare($mysqli, $sql);

        mysqli_stmt_bind_param($stmt, "i", $orfid);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_optimized_image($orf_id)
    {
        $mysqli = $this->dbconnect();

        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);

        $row = $this->get_creator_file($orf_id);

        if (!empty($row['optimized_image_path'])) {
            $file_path = "../" . $row['optimized_image_path'];
        }

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $stmt = mysqli_prepare($mysqli, "update `o_results` set `optimized_image_path`='' where `orf_id`=?");

        mysqli_stmt_bind_param($stmt, "i", $orf_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function clear_directory($dir)
    {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                //echo $obj;
                is_dir($obj) ? $this->clear_directory($obj) : unlink($obj);
            }
        }

        $folders = glob($dir . "/*");
        foreach ($folders as $folder) {
            if (!is_file($folder)) {
                //echo $folder;
                rmdir($folder);
            }
        }
    }

    public function delete_customer_file($ofid)
    {
        $mysqli = $this->dbconnect();

        $deleted = 0;
        $local_document_root = "/home/adminhdd/domains/blue7.it/public_html/studio";

        $row = $this->get_customer_file($ofid);

        //$filename=$this->get_creator_file($orfid,$oid,$prodid,$osubid);
        $path = $local_document_root . "/client_files/" . $row['of_path_dom'] . $row['of_internal_name_dom'];
        if (file_exists($path)) {
            unlink($path);
            $deleted = 1;
        }
        else //file was probably already deleted, so we delete it from db
        {
            $deleted = 1; 
        }

        if ($deleted == 1) {
            $delete_creator_file_sql = "delete from `o_files` where `of_id`='$ofid'";
            $delete_creator_file_result = mysqli_query($mysqli, $delete_creator_file_sql) or die(mysqli_error($mysqli));
        }
        mysqli_close($mysqli);
    }

    public function delete_client($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "delete from `u_clients` where `client_ID`=?");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_main_client($mc_id)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $stmt = mysqli_prepare($mysqli, "delete from `u_clients_main` where `mc_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $mc_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_client($user_id)
    {
        $mysqli = $this->dbconnect();
        $user_id = mysqli_real_escape_string($mysqli, $user_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `client_ID`=?");
        mysqli_stmt_bind_param($stmt, "i", $user_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_main_client_position($ucb_id)
    {
        $mysqli = $this->dbconnect();
        $ucb_id = mysqli_real_escape_string($mysqli, $ucb_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_bosses` where `ucb_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $ucb_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_main_client_boss_by_position_nr($postition_nr)
    {
        $mysqli = $this->dbconnect();
        $postition_nr = mysqli_real_escape_string($mysqli, $postition_nr);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_bosses` where `position_nr`=?");
        mysqli_stmt_bind_param($stmt, "i", $postition_nr);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_clients()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` order by `clientname` asc,`c_last_name` asc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_active_clients()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `c_status`='active' order by `clientname` asc,`c_last_name` asc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_licence($licence_id)
    {
        $mysqli = $this->dbconnect();
        $licence_id = mysqli_real_escape_string($mysqli, $licence_id);
        $stmt = mysqli_prepare($mysqli, "select * from `licences` where `lic_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $licence_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function get_licence2($site, $lang, $currency)
    {
        $mysqli = $this->dbconnect();
        $site = mysqli_real_escape_string($mysqli, $site);
        $lang = mysqli_real_escape_string($mysqli, $lang);
        $currency = mysqli_real_escape_string($mysqli, $currency);

        $stmt = "select * from `licences` where `homepages_for_sale` like '%$site%' and `languages_on_page` like '%$lang%' and `currencies` like '%$currency%'";
        //mysqli_stmt_bind_param($stmt,"s",$licence_id);

        //mysqli_stmt_execute($stmt);

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function get_licence_by_site($site)
    {
        $mysqli = $this->dbconnect();
        $site = mysqli_real_escape_string($mysqli, $site);

        $stmt = "select * from `licences` where `homepages_for_sale` like '%$site%'";
        //mysqli_stmt_bind_param($stmt,"s",$licence_id);

        //mysqli_stmt_execute($stmt);

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_status_name($o_status)
    {
        $mysqli = $this->dbconnect();
        $o_status = mysqli_real_escape_string($mysqli, $o_status);

        $stmt = mysqli_prepare($mysqli, "select * from `o_status` where `ost_id` like ?");
        mysqli_stmt_bind_param($stmt, "d", $o_status);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function show_finished_orders($startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status`='8' order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "ii", $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_orders_by_on_stock($on_stock=0, $startpoint=0, $limit=10)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `on_stock`=? and `o_status`='8' order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "iii", $on_stock, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_all_finished_orders()
    {
        $mysqli = $this->dbconnect();
        // $startpoint=mysqli_real_escape_string($mysqli,$startpoint);
        // $limit=mysqli_real_escape_string($mysqli,$limit);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status`='8' order by `order_ID` desc");

        //mysqli_stmt_bind_param($stmt,"ii",$startpoint,$limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_unfinished_orders_by_on_stock($on_stock = 0)
    {
        $mysqli = $this->dbconnect();

        //$ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `on_stock`=? and `o_status` between 1 and 7 order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $on_stock);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_unfinished_orders_by_on_stock_limit($on_stock = 0,$startpoint=0, $limit=10)
    {
        $mysqli = $this->dbconnect();

        //$ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        
        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `on_stock`=? and `o_status` between 1 and 7 order by `order_ID` desc limit ?,?");
        mysqli_stmt_bind_param($stmt, "iii", $on_stock, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_unfinished_materials_orders($materials_orders=1)
    {
        $mysqli = $this->dbconnect();

        //$ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $materials_orders = mysqli_real_escape_string($mysqli, $materials_orders);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `materials_order`=? and `o_status` between 1 and 7 order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $materials_orders);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_unfinished_orders_by_on_stock2($on_stock = 0)
    {
        $mysqli = $this->dbconnect();

        //$ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = mysqli_prepare($mysqli, "select `order_ID` from `orders` where `on_stock`=? and `o_status` between 1 and 7 order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $on_stock);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_unfinished_orders_by_ls_id($ls_id)
    {
        $mysqli = $this->dbconnect();

        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        //$on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status` between 1 and 7 order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "s", $ls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_orders_by_ls_id_on_stock($ls_id, $startpoint, $limit, $on_stock = 0)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `on_stock`=? and `ls_id`=? and `o_status`='8' order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "isii", $on_stock, $ls_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_orders_by_lic_ids_on_stock($lic_ids_array, $startpoint, $limit, $on_stock = 0)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        //$ls_id=mysqli_real_escape_string($mysqli,$ls_id);
        $lic_ids = implode(",", $lic_ids_array);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = "select * from `orders` where `on_stock`='$on_stock' and `lic_ID` in ($lic_ids) and `o_status`='8' order by `order_ID` desc limit $startpoint,$limit";

        //mysqli_stmt_bind_param($stmt,"isii",$on_stock,$ls_id,$startpoint,$limit);

        //mysqli_stmt_execute($stmt);

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_orders_by_ls_id($ls_id, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status`='8' order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "sii", $ls_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_orders_by_mc_id($mc_id, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `mc_id`=? and `o_status`='8' order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "sii", $mc_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_finished_orders_by_lic_ids($lic_ids_array, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        //$ls_id=mysqli_real_escape_string($mysqli,$ls_id);
        $lic_ids = implode(",", $lic_ids_array);

        $stmt = "select * from `orders` where `lic_ID` in ($lic_ids) and `o_status`='8' order by `order_ID` desc limit $startpoint,$limit";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function show_all_finished_orders_by_ls_id($ls_id)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status`='8' order by `order_ID` desc");

        mysqli_stmt_bind_param($stmt, "s", $ls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_all_order_request_orders()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status`='0' order by `order_ID` desc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_1_9_orders()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status` between 1 and 9 order by `order_ID` desc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_unfinished_orders()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status` between 1 and 7 order by `order_ID` desc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    /*public function show_unfinished_orders_by_ls_id($ls_id)
	{
		$mysqli=$this->dbconnect();

        $ls_id=mysqli_real_escape_string($mysqli,$ls_id);

		$stmt=mysqli_prepare($mysqli,"select * from `orders` where `ls_id`=? and `o_status` between 1 and 7 order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt,"s",$ls_id);

		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);

		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
    }*/

    public function show_unfinished_orders_by_ls_id_on_stock($ls_id, $on_stock = 0)
    {
        $mysqli = $this->dbconnect();

        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `on_stock`=? and `ls_id`=? and `o_status` between 1 and 7 order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "is", $on_stock, $ls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_unfinished_orders_by_lic_ids_on_stock($lic_ids_array, $on_stock = 0)
    {
        $mysqli = $this->dbconnect();

        //$lic_ids_array=mysqli_real_escape_string($mysqli,$lic_ids_array);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);
        $lic_ids = implode(",", $lic_ids_array);

        //$stmt = "select * from `orders` where `on_stock`='$on_stock' and `lic_ID` in ($lic_ids) and `o_status` between 1 and 7 order by `order_ID` desc";
        $stmt = "select * from `orders` where `on_stock`='$on_stock' and `o_status` between 1 and 7 order by `order_ID` desc";
        //mysqli_stmt_bind_param($stmt,"i",$on_stock);

        //mysqli_stmt_execute($stmt);

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }


    public function show_unfinished_orders_by_lic_ids_on_stock2($on_stock = 0)
    {
        $mysqli = $this->dbconnect();

        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = "select `order_ID` from `orders` where `on_stock`='$on_stock' and `o_status` between 1 and 7 order by `order_ID` desc";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function show_client_unfinished_orders($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `o_status` between 0 and 7 order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_client_finished_orders($client_id, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `o_status`='8' order by `order_ID` desc limit ?,?");
        mysqli_stmt_bind_param($stmt, "iii", $client_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_all_deleted_orders()
    {
        $mysqli = $this->dbconnect();

        // $startpoint=mysqli_real_escape_string($mysqli,$startpoint);
        // $limit=mysqli_real_escape_string($mysqli,$limit);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status` between 10 and 12 order by `order_ID` desc");

        //mysqli_stmt_bind_param($stmt,"ii",$startpoint,$limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_deleted_orders_by_ls_id($ls_id, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();

        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status` between 10 and 12 order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "sii", $ls_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_deleted_orders_by_lic_ids($lic_ids_array, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();

        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        //$ls_id=mysqli_real_escape_string($mysqli,$ls_id);
        $lic_ids = implode(",", $lic_ids_array);

        $stmt = "select * from `orders` where `lic_ID` in ($lic_ids) and `o_status` between 10 and 12 order by `order_ID` desc limit $startpoint,$limit";

        // mysqli_stmt_bind_param($stmt,"sii",$ls_id,$startpoint,$limit);

        // mysqli_stmt_execute($stmt);

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_unfinished_orders_by_mc_id($mc_id)
    {
        $mysqli = $this->dbconnect();

        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        
        $stmt = "select * from `orders` where `mc_id`=$mc_id and `o_status` between 1 and 7 ORDER BY `orders`.`order_ID` DESC";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
       
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_all_deleted_orders_by_ls_id($ls_id)
    {
        $mysqli = $this->dbconnect();

        // $startpoint=mysqli_real_escape_string($mysqli,$startpoint);
        // $limit=mysqli_real_escape_string($mysqli,$limit);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status` between 10 and 12 order by `order_ID` desc");

        mysqli_stmt_bind_param($stmt, "s", $ls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function check_creators_team($client_id)
    {
        $mysqli = $this->dbconnect();

        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_teams` where `u_id`=?");

        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_team_member($ut_id)
    {
        $mysqli = $this->dbconnect();

        $ut_id = mysqli_real_escape_string($mysqli, $ut_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_teams` where `ut_id`=?");

        mysqli_stmt_bind_param($stmt, "i", $ut_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_team_member($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $ut_id = mysqli_real_escape_string($mysqli, $data->ut_id);
        $team_id = mysqli_real_escape_string($mysqli, $data->team_id);
        $team_name = mysqli_real_escape_string($mysqli, $data->team_name);
        $team_leader_quality = mysqli_real_escape_string($mysqli, $data->team_leader_quality);
        $u_name = mysqli_real_escape_string($mysqli, $data->u_name);
        $u_id = mysqli_real_escape_string($mysqli, $data->u_id);

        $stmt = "update `u_teams` set `team_id`='$team_id', `team_name`='$team_name', `team_leader_quality`='$team_leader_quality', `u_name`='$u_name',`u_id`='$u_id' where `ut_id`='$ut_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_team_member($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $team_id = mysqli_real_escape_string($mysqli, $data->team_id);
        $team_name = mysqli_real_escape_string($mysqli, $data->team_name);
        $team_leader_quality = mysqli_real_escape_string($mysqli, $data->team_leader_quality);
        $u_name = mysqli_real_escape_string($mysqli, $data->u_name);
        $u_id = mysqli_real_escape_string($mysqli, $data->u_id);

        $stmt = "insert into `u_teams`(`team_id`,`team_name`,`team_leader_quality`,`u_name`,`u_id`) values('$team_id','$team_name','$team_leader_quality','$u_name','$u_id')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function delete_team_member($ut_id)
    {
        $mysqli = $this->dbconnect();

        $ut_id = mysqli_real_escape_string($mysqli, $ut_id);

        $stmt = mysqli_prepare($mysqli, "delete from `u_teams` where `ut_id`=?");

        mysqli_stmt_bind_param($stmt, "i", $ut_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_team($team_id)
    {
        $mysqli = $this->dbconnect();

        $team_id = mysqli_real_escape_string($mysqli, $team_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_teams` where `team_id`=?");

        mysqli_stmt_bind_param($stmt, "i", $team_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_creator_teams()
    {
        $mysqli = $this->dbconnect();

        //$team_id=mysqli_real_escape_string($mysqli,$team_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_teams` order by `team_id` asc");

        //mysqli_stmt_bind_param($stmt,"i",$team_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_teams($prod_id)
    {
        $mysqli = $this->dbconnect();

        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `teams` where `lt_id`=? order by `team_id` asc");

        mysqli_stmt_bind_param($stmt, "i", $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_other_teams($prod_id)
    {
        $mysqli = $this->dbconnect();

        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `teams` where `lt_id`<>? order by `team_id` asc");

        mysqli_stmt_bind_param($stmt, "i", $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_order_requests_by_ls_id($ls_id, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status`='0' order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "sii", $ls_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_order_requests_by_lic_ids($lic_ids_array, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        //$lic_ids_array=mysqli_real_escape_string($mysqli,$lic_ids_array);
        $lic_ids = implode(',', $lic_ids_array);
        $stmt = "select * from `orders` where `lic_ID` in ($lic_ids) and `o_status`='0' order by `order_ID` desc limit $startpoint,$limit";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function show_all_order_requests_by_ls_id($ls_id)
    {
        $mysqli = $this->dbconnect();
        // $startpoint=mysqli_real_escape_string($mysqli,$startpoint);
        // $limit=mysqli_real_escape_string($mysqli,$limit);
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status`='0' order by `order_ID` desc");

        mysqli_stmt_bind_param($stmt, "s", $ls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function count_client_finished_orders($client_id)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `o_status`='8' order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_can_not_do_orders()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status`='9' order by `order_ID` desc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_deleted_orders($startpoint, $limit)
    {
        $mysqli = $this->dbconnect();

        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status` between 10 and 12 order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "ii", $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_order_requests($startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `o_status`='0' order by `order_ID` desc limit ?,?");

        mysqli_stmt_bind_param($stmt, "ii", $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function add_order_products($orderid, $osub_id, $prod_id, $p_status)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $p_status = mysqli_real_escape_string($mysqli, $p_status);

        $stmt = mysqli_prepare($mysqli, "insert into `o_prods`(`o_id`,`osub_id`,`prod_id`,`p_status`) values(?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "iisi", $orderid, $osub_id, $prod_id, $p_status);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function add_order_products2($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $om_id = mysqli_real_escape_string($mysqli, $data->om_id ?? '0');
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id ?? '');
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id ?? '');
        $om_correction = mysqli_real_escape_string($mysqli, $data->om_correction ?? 0);
        $om_amendment = mysqli_real_escape_string($mysqli, $data->om_amendment ?? 0);
        $om_extension = mysqli_real_escape_string($mysqli, $data->om_extension ?? 0);
        $uca_id = mysqli_real_escape_string($mysqli, $data->uca_id ?? 0);
        $p_status = mysqli_real_escape_string($mysqli, $data->p_status ?? 0);

        $stmt = "insert into `o_prods`(`o_id`,`om_id`,`om_correction`,`om_amendment`,`om_extension`,`osub_id`,`prod_id`,`uca_id`,`p_fac_ct`,`p_fac_ca`,`prod_finish_date`,`p_status`,`crc_reason`) values('$o_id','$om_id','$om_correction','$om_amendment','$om_extension','$osub_id','$prod_id','$uca_id','0.0','0.0','0000-00-00 00:00:00','$p_status','')";
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_order_product($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `osub_id`=? and `prod_id`=?");
        mysqli_stmt_bind_param($stmt, "iss", $o_id, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_order_products_count($o_id)
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select COUNT(`o_id`) from `o_prods` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row['COUNT(`o_id`)'];
    }

    public function get_all_order_products($o_id)
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function delete_order_product($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);

        $stmt = mysqli_prepare($mysqli, "delete from `o_prods` where `o_id`=? and `osub_id`=? and `prod_id`=?");
        mysqli_stmt_bind_param($stmt, "iss", $o_id, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_order_product($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $om_id = mysqli_real_escape_string($mysqli, $data->om_id ?? 0);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id ?? '');
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id ?? '');
        $om_correction = mysqli_real_escape_string($mysqli, $data->om_correction ?? 0);
        $om_amendment = mysqli_real_escape_string($mysqli, $data->om_amendment ?? 0);
        $om_extension = mysqli_real_escape_string($mysqli, $data->om_extension ?? 0);

        $stmt = "update `o_prods` set `om_correction`='$om_correction', `om_amendment`='$om_amendment', `om_extension`='$om_extension', `om_id`='$om_id' where `o_id`='$o_id' and `osub_id`='$osub_id' and `prod_id`='$prod_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function delete_order_products($orderid, $product)
    {
        $mysqli = $this->dbconnect();
        $sql = "delete from `o_prods` where `o_id`='$orderid' and `prod_id`='$product'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function delete_products_by_o_id($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "delete from `o_prods` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    /*
	public function get_layoutline_id($selected_layoutline)
	{
		$mysqli=$this->dbconnect();
		$selected_layoutline=mysqli_real_escape_string($mysqli,$selected_layoutline);
		$get_layoutline_id_sql="select `id` from `layouts` where `layoutline-name`='$selected_layoutline'";
		$get_layoutline_id_result=mysqli_query($mysqli,$get_layoutline_id_sql) or die(mysqli_error($mysqli));
		$row=mysqli_fetch_array($get_layoutline_id_result,MYSQLI_BOTH);

		mysqli_close($mysqli);

		return $row;
	}
	*/

    public function update_order($orderid, $order_name, $collection, $o_price, $o_special_agreement_price, $vat_percent, $vat_amount, $vat_a_id, $brut_price, $customer_remarks, $client_extras_ex_b5, $op_remarks, $op_remarks_ex_b5, $environment_address, $o_status, $producers)
    {
        $mysqli = $this->dbconnect();

        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $order_name = mysqli_real_escape_string($mysqli, $order_name);
        $collection = mysqli_real_escape_string($mysqli, $collection);
        $vat_a_id = mysqli_real_escape_string($mysqli, $vat_a_id);
        $o_price = mysqli_real_escape_string($mysqli, $o_price);
        $o_special_agreement_price = mysqli_real_escape_string($mysqli, $o_special_agreement_price);
        $vat_percent = mysqli_real_escape_string($mysqli, $vat_percent);
        $vat_amount = mysqli_real_escape_string($mysqli, $vat_amount);
        $brut_price = mysqli_real_escape_string($mysqli, $brut_price);
        $customer_remarks = mysqli_real_escape_string($mysqli, $customer_remarks);
        $client_extras_ex_b5 = mysqli_real_escape_string($mysqli, $client_extras_ex_b5);
        $op_remarks = mysqli_real_escape_string($mysqli, $op_remarks);
        $op_remarks_ex_b5 = mysqli_real_escape_string($mysqli, $op_remarks_ex_b5);
        $environment_address = mysqli_real_escape_string($mysqli, $environment_address);
        $o_status = mysqli_real_escape_string($mysqli, $o_status);
        $producers = mysqli_real_escape_string($mysqli, $producers);

        $stmt = "update `orders` set `order_name`='$order_name',`collection`='$collection', `op-remarks`='$op_remarks', `clients-extras`='$customer_remarks', `client_extras_ex_b5`='$client_extras_ex_b5', `op_remarks_ex_b5`='$op_remarks_ex_b5', `o_price`='$o_price', `o_special_agreement_price`='$o_special_agreement_price',`vat_percent`='$vat_percent',`vat_amount`='$vat_amount',`vat_a_id`='$vat_a_id',`brut_price`='$brut_price',`environment_address`='$environment_address',`o_status`='$o_status',`u_prod_id`='$producers' where `order_ID`='$orderid'";

        $result = mysqli_query($mysqli, $stmt);

        mysqli_close($mysqli);
    }

    public function update_order2($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orderid = mysqli_real_escape_string($mysqli, $data->o_id);
        $order_name = mysqli_real_escape_string($mysqli, $data->order_name ?? '');
        $o_deadline_utc = mysqli_real_escape_string($mysqli, $data->o_deadline_utc ?? '0000-00-00 00:00:00');
        $st_id = mysqli_real_escape_string($mysqli, $data->st_id ?? 0);
        $collection = mysqli_real_escape_string($mysqli, $data->collection ?? '');
        $vat_a_id = mysqli_real_escape_string($mysqli, $data->vat_a_id ?? 0);
        $o_price = mysqli_real_escape_string($mysqli, $data->o_price ?? 0);
        $o_special_agreement_price = mysqli_real_escape_string($mysqli, $data->o_special_agreement_price ?? 0);
        $vat_percent = mysqli_real_escape_string($mysqli, $data->vat_percent ?? 0);
        $vat_amount = mysqli_real_escape_string($mysqli, $data->vat_amount ?? 0);
        $brut_price = mysqli_real_escape_string($mysqli, $data->brut_price ?? 0);
        $customer_remarks =  str_replace("\n",PHP_EOL,$data->customer_remarks ?? '');
        $client_extras_ex_b5 = str_replace("\n",PHP_EOL, $data->client_extras_ex_b5 ?? '');
        $op_remarks = str_replace("\n",PHP_EOL, $data->op_remarks ?? '');
        $accepted_by = mysqli_real_escape_string($mysqli, $data->accepted_by ?? 0);
        $op_remarks_ex_b5 = str_replace("\n",PHP_EOL, $data->op_remarks_ex_b5 ?? '');
        $cur_id = mysqli_real_escape_string($mysqli, $data->cur_id ?? 0);
        $client_language_id = mysqli_real_escape_string($mysqli, $data->client_language_id ?? 0);
        $environment_address = mysqli_real_escape_string($mysqli,$data->environment_address ?? '');
        $longitude = mysqli_real_escape_string($mysqli, $data->longitude ?? 0);
        $latitude = mysqli_real_escape_string($mysqli, $data->latitude ?? 0);
        $suntour = mysqli_real_escape_string($mysqli, $data->suntour ?? 0);
        $geoportal_link = mysqli_real_escape_string($mysqli, $data->geoportal_link ?? '');
        
        $earth_link = mysqli_real_escape_string($mysqli, $data->earth_link ?? '');
        $show_on_map = mysqli_real_escape_string($mysqli, $data->show_on_map ?? 0);
        $vr_link = mysqli_real_escape_string($mysqli, $data->vr_link ?? '');
        $street_view_link = mysqli_real_escape_string($mysqli, $data->street_view_link ?? '');
        $invoice_explanations = mysqli_real_escape_string($mysqli, $data->invoice_explanations ?? '');
        $o_status = mysqli_real_escape_string($mysqli, $data->o_status ?? 0);
        $producers = mysqli_real_escape_string($mysqli, $data->u_prod_id ?? 0);
        $public = mysqli_real_escape_string($mysqli, $data->public ?? 0);
        $house_id = mysqli_real_escape_string($mysqli, $data->house_id ?? 0);
        $commission = mysqli_real_escape_string($mysqli, $data->commission ?? 0);

        $stmt = "update `orders` set `order_name`='$order_name',`o_deadline`='$o_deadline_utc',`collection`='$collection', `st_id`='$st_id',`house_id`='$house_id',`commission`='$commission',`cur_id`='$cur_id',`accepted_by`='$accepted_by',`client_language_id`='$client_language_id',`op-remarks`='$op_remarks', `clients-extras`='$customer_remarks', `client_extras_ex_b5`='$client_extras_ex_b5', `op_remarks_ex_b5`='$op_remarks_ex_b5', `o_price`='$o_price',`vr_link`='$vr_link', `show_on_map`='$show_on_map',`street_view_link`='$street_view_link',`o_special_agreement_price`='$o_special_agreement_price',`vat_percent`='$vat_percent',`vat_amount`='$vat_amount',`vat_a_id`='$vat_a_id',`brut_price`='$brut_price',`environment_address`='$environment_address',`longitude`='$longitude',`latitude`='$latitude',`suntour`='$suntour',`public`='$public',`geoportal_link`='$geoportal_link',`earth_link`='$earth_link',`invoice_explanations`='$invoice_explanations',`o_status`='$o_status',`u_prod_id`='$producers' where `order_ID`='$orderid'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_all_products()
    {
        $mysqli = $this->dbconnect();
        $sql = "select * from `products` order by `prod_id` asc";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function get_vat($licence_taker_a_id)
    {
        $mysqli = $this->dbconnect();
        $licence_taker_a_id = mysqli_real_escape_string($mysqli, $licence_taker_a_id);
        $stmt = mysqli_prepare($mysqli, "select * from `areas` where `a_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $licence_taker_a_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_order_status($orderid)
    {
        $mysqli = $this->dbconnect();
        $status = -1; // means, that order not found, or unknown error

        if ($stmt = $mysqli->prepare("select o_status from orders where order_ID=? ")) {
            $stmt->bind_param("i", $orderid);
            $stmt->execute();
            $stmt->bind_result($status);
            $stmt->fetch();

            $stmt->close();
        }

        return $status;
    }

    public function update_order_status($orderid, $o_status)
    {

        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $orderid);
        $o_status = mysqli_real_escape_string($mysqli, $o_status);

        $update_order_status_sql = "update `orders` set `o_status`='$o_status' where `order_ID`='$o_id'";
        $update_order_status_result = mysqli_query($mysqli, $update_order_status_sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function update_order_homepage_url($orderid, $homepage_url)
    {

        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $orderid);
        $homepage_url = mysqli_real_escape_string($mysqli, $homepage_url);

        $update_order_status_sql = "update `orders` set `homepage_url`='$homepage_url' where `order_ID`='$o_id'";
        $update_order_status_result = mysqli_query($mysqli, $update_order_status_sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function update_order_domain_homepage_url($orderid, $domain_homepage_url)
    {

        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $orderid);
        $domain_homepage_url = mysqli_real_escape_string($mysqli, $domain_homepage_url);

        $update_order_status_sql = "update `orders` set `domain_homepage_url`='$domain_homepage_url' where `order_ID`='$o_id'";
        $update_order_status_result = mysqli_query($mysqli, $update_order_status_sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);

    }

    public function update_order_creator_team($o_id, $team_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $team_id = mysqli_real_escape_string($mysqli, $team_id);

        $stmt = "update `orders` set `team_id`='$team_id' where `order_ID`='$o_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function show_result_files($orderid)
    {
        $mysqli = $this->dbconnect();
        $show_result_files_sql = "select * from `o_results` where `o_id`='$orderid' order by `osub_id`,`prod_id` asc";
        $show_result_files = mysqli_query($mysqli, $show_result_files_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($show_result_files, MYSQLI_BOTH)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    //creator administration

    /*public function get_all_creators_by_id()
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` order by `uca_id` ASC");

		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);

		$rows=array();
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
	}

	public function get_all_creators_by_lt_id()
	{
		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `u_creators` order by `lt_id` ASC");

		mysqli_stmt_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);

		$rows=array();
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

		return $rows;
    } */

    public function get_all_creators()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` join `u_clients_qualifications` on `u_clients`.`client_ID`=`u_clients_qualifications`.`client_id` where `u_clients_rights`.`u_status`='active' order by `u_clients`.`c_first_name` asc");
        //select * from `u_clients` join `u_clients_rights` on `u_clients`.`client_ID`=`u_clients_rights`.`client_id` where `u_clients`.`lt_id`=? and `u_clients_rights`.`u_status`='active' order by `u_clients`.`c_first_name` asc
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    // client administration

    public function show_areas()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `areas` order by `area` ASC");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_main_client_measures()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_measures` where `mc_id`<>0");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_default_client_measures()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_measures` where `mc_id`=0 and `client_id`=0");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_client_measure($ucm_id)
    {
        $mysqli = $this->dbconnect();

        $ucm_id = mysqli_real_escape_string($mysqli, $ucm_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_measures` where `ucm_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $ucm_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function verify_existing_email($email)
    {
        $mysqli = $this->dbconnect();
        $email = mysqli_real_escape_string($mysqli, $email);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `email`=?");
        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function customer_register($clientname, $mc_id, $specials, $client_credibility, $ls_ids, $country, $registration, $l_title, $l_first_name, $l_middle_name, $l_last_name, $l_gender, $leaders_status, $contact_status,$c_title, $c_first_name, $c_middle_name, $c_last_name, $c_gender, $phone, $email, $VAT_tax_no, $iban, $street, $no_or_housename, $postcode, $city, $homepage, $password, $date_registered)
    {
        $mysqli = $this->dbconnect();
        $clientname = mysqli_real_escape_string($mysqli, $clientname);
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $specials = mysqli_real_escape_string($mysqli, $specials);
        $client_credibility = mysqli_real_escape_string($mysqli, $client_credibility);
        $ls_ids = mysqli_real_escape_string($mysqli, $ls_ids);
        $country = mysqli_real_escape_string($mysqli, $country);
        $registration = mysqli_real_escape_string($mysqli, $registration);
        $l_title = mysqli_real_escape_string($mysqli, $l_title);
        $l_first_name = mysqli_real_escape_string($mysqli, $l_first_name);
        $l_middle_name = mysqli_real_escape_string($mysqli, $l_middle_name);
        $l_last_name = mysqli_real_escape_string($mysqli, $l_last_name);
        $l_gender = mysqli_real_escape_string($mysqli, $l_gender);
        $leaders_status = mysqli_real_escape_string($mysqli, $leaders_status);
        $contact_status = mysqli_real_escape_string($mysqli, $contact_status);
        $c_title = mysqli_real_escape_string($mysqli, $c_title);
        $c_first_name = mysqli_real_escape_string($mysqli, $c_first_name);
        $c_middle_name = mysqli_real_escape_string($mysqli, $c_middle_name);
        $c_last_name = mysqli_real_escape_string($mysqli, $c_last_name);
        $c_gender = mysqli_real_escape_string($mysqli, $c_gender);
        $phone = mysqli_real_escape_string($mysqli, $phone);
        $email = mysqli_real_escape_string($mysqli, $email);
        $VAT_tax_no = mysqli_real_escape_string($mysqli, $VAT_tax_no);
        $street = mysqli_real_escape_string($mysqli, $street);
        $no_or_housename = mysqli_real_escape_string($mysqli, $no_or_housename);
        $postcode = mysqli_real_escape_string($mysqli, $postcode);
        $city = mysqli_real_escape_string($mysqli, $city);
        $homepage = mysqli_real_escape_string($mysqli, $homepage);
        $password = sha1($password);
        $date_registered = mysqli_real_escape_string($mysqli, $date_registered);

        if((!empty($email))&&(!empty($password)))
        {
            if (strpos($email, 'rightbliss.beauty') === false) 
            {            
                $stmt = "insert into `u_clients`(`clientname`,`mc_id`,`specials`,`client_credibility`,`ls_ids`,`a_id`,`registration`,`l_title`,`l_first_name`,`l_middle_name`,`l_last_name`,`l_gender`,`leaders_status`,`contact_status`,`c_title`,`c_first_name`,`c_middle_name`,`c_last_name`,`c_gender`,`phone`,`email`,`vat_tax_no`,`iban`,`street`,`no_or_housename`,`postcode`,`city`,`homepage`,`password`,`date_registered`) values('$clientname','$mc_id','$specials','$client_credibility','$ls_ids','$country','$registration','$l_title','$l_first_name','$l_middle_name','$l_last_name','$l_gender','$leaders_status','$contact_status','$c_title','$c_first_name','$c_middle_name','$c_last_name','$c_gender','$phone','$email','$VAT_tax_no','$iban','$street','$no_or_housename','$postcode','$city','$homepage','$password','$date_registered')";
                
                $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
            }
        }
        mysqli_close($mysqli);

        
    }

    public function customer_register2($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $referrer_id = mysqli_real_escape_string($mysqli, $data->referrer_id ?? "0");
        $clientname = mysqli_real_escape_string($mysqli, $data->clientname);
        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id ?? "0");
        $specials = mysqli_real_escape_string($mysqli, $data->specials ?? "");
        $client_credibility = mysqli_real_escape_string($mysqli, $data->client_credibility ?? "0");
        $ls_ids = mysqli_real_escape_string($mysqli, $data->ls_ids ?? "");
        $country = mysqli_real_escape_string($mysqli, $data->country ?? "0");
        $registration = mysqli_real_escape_string($mysqli, $data->registration ?? "");
        $l_title = mysqli_real_escape_string($mysqli, $data->l_title ?? "");
        $l_first_name = mysqli_real_escape_string($mysqli, $data->l_first_name ?? "");
        $l_middle_name = mysqli_real_escape_string($mysqli, $data->l_middle_name ?? "");
        $l_last_name = mysqli_real_escape_string($mysqli, $data->l_last_name ?? "");
        $l_gender = mysqli_real_escape_string($mysqli, $data->l_gender ?? "");
        $leaders_status = mysqli_real_escape_string($mysqli, $data->leaders_status);
        $c_title = mysqli_real_escape_string($mysqli, $data->c_title ?? "");
        $c_first_name = mysqli_real_escape_string($mysqli, $data->c_first_name ?? "");
        $c_middle_name = mysqli_real_escape_string($mysqli, $data->c_middle_name ?? "");
        $c_last_name = mysqli_real_escape_string($mysqli, $data->c_last_name ?? "");
        $c_gender = mysqli_real_escape_string($mysqli, $data->c_gender ?? "");
        $phone = mysqli_real_escape_string($mysqli, $data->phone ?? "");
        $email = mysqli_real_escape_string($mysqli, $data->email);
        $VAT_tax_no = mysqli_real_escape_string($mysqli, $data->VAT_tax_no ?? "");
        $iban = mysqli_real_escape_string($mysqli, $data->iban ?? "");
        $street = mysqli_real_escape_string($mysqli, $data->street ?? "");
        $no_or_housename = mysqli_real_escape_string($mysqli, $data->no_or_housename ?? "");
        $postcode = mysqli_real_escape_string($mysqli, $data->postcode ?? "");
        $city = mysqli_real_escape_string($mysqli, $data->city ?? "");
        $homepage = mysqli_real_escape_string($mysqli, $data->homepage ?? "");
        $timezone = mysqli_real_escape_string($mysqli, $data->timezone ?? "");
        $register_script = mysqli_real_escape_string($mysqli, $data->register_script ?? "");
        $password = sha1($data->password);
        $date_registered = mysqli_real_escape_string($mysqli, $data->date_registered);

        if((!empty($email))&&(!empty($password)))
        {
            if (strpos($email, 'rightbliss.beauty') === false) 
            { 
                $stmt = "insert into `u_clients`(`referrer_id`,`clientname`,`mc_id`,`specials`,`client_credibility`,`ls_ids`,`a_id`,`registration`,`l_title`,`l_first_name`,`l_middle_name`,`l_last_name`,`l_gender`,`leaders_status`,`c_title`,`c_first_name`,`c_middle_name`,`c_last_name`,`c_gender`,`phone`,`email`,`vat_tax_no`,`iban`,`street`,`no_or_housename`,`postcode`,`city`,`homepage`,`timezone`,`register_script`,`password`,`date_registered`) values('$referrer_id','$clientname','$mc_id','$specials','$client_credibility','$ls_ids','$country','$registration','$l_title','$l_first_name','$l_middle_name','$l_last_name','$l_gender','$leaders_status','$c_title','$c_first_name','$c_middle_name','$c_last_name','$c_gender','$phone','$email','$VAT_tax_no','$iban','$street','$no_or_housename','$postcode','$city','$homepage','$timezone','$register_script','$password','$date_registered')";
                
                $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
            }
        }
        mysqli_close($mysqli);
        
    }

    public function create_main_client_position($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $position_nr = mysqli_real_escape_string($mysqli, $data->position_nr);
        $boss_c_id = mysqli_real_escape_string($mysqli, $data->boss_c_id);        
    
        $stmt = "insert into `u_clients_bosses`(`mc_id`,`position_nr`,`boss_c_id`) values('$mc_id','$position_nr','$boss_c_id')";
        
        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));          
        
        mysqli_close($mysqli);
        
    }

    public function update_main_client_position($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $ucb_id = mysqli_real_escape_string($mysqli, $data->ucb_id);
        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $position_nr = mysqli_real_escape_string($mysqli, $data->position_nr);
        $boss_c_id = mysqli_real_escape_string($mysqli, $data->boss_c_id);        

        $stmt = "update `u_clients_bosses` set `mc_id`='$mc_id',`position_nr`='$position_nr',`boss_c_id`='$boss_c_id' where `ucb_id`='$ucb_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_client($client_id, $mc_id, $specials, $client_credibility, $ls_ids, $clientname, $country, $registration, $l_title, $l_first_name, $l_middle_name, $l_last_name, $l_gender, $leaders_status, $c_title, $c_first_name, $c_middle_name, $c_last_name, $c_gender, $phone, $email, $vat_tax_no, $iban, $street, $no_or_housename, $postcode, $city, $homepage)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $specials = mysqli_real_escape_string($mysqli, $specials);
        $client_credibility = mysqli_real_escape_string($mysqli, $client_credibility);
        $ls_ids = mysqli_real_escape_string($mysqli, $ls_ids);
        $country = mysqli_real_escape_string($mysqli, $country);
        $registration = mysqli_real_escape_string($mysqli, $registration);
        $leaders_name = mysqli_real_escape_string($mysqli, $leaders_name);
        $leaders_status = mysqli_real_escape_string($mysqli, $leaders_status);
        $contact_at_client = mysqli_real_escape_string($mysqli, $contact_at_client);
        $phone = mysqli_real_escape_string($mysqli, $phone);
        $email = mysqli_real_escape_string($mysqli, $email);
        $VAT_tax_no = mysqli_real_escape_string($mysqli, $VAT_tax_no);
        $street = mysqli_real_escape_string($mysqli, $street);
        $number = mysqli_real_escape_string($mysqli, $number);
        $postcode = mysqli_real_escape_string($mysqli, $postcode);
        $city = mysqli_real_escape_string($mysqli, $city);
        $homepage = mysqli_real_escape_string($mysqli, $homepage);

        $stmt = mysqli_prepare($mysqli, "update `u_clients` set `clientname`=?,`mc_id`=?,`specials`=?,`client_credibility`=?,`ls_ids`=?,`l_title`=?,`l_first_name`=?, `l_middle_name`=?, `l_last_name`=?, `l_gender`=?,`leaders_status`=?,`c_title`=?, `c_first_name`=?,`c_middle_name`=?, `c_last_name`=?,`c_gender`=?,`a_id`=?,`postcode`=?,`street`=?,`no_or_housename`=?,`city`=?,`phone`=?,`email`=?,`homepage`=?,`vat_tax_no`=?,`iban`=?,`registration`=? where `client_ID`=?");
        mysqli_stmt_bind_param($stmt, "siiissssssssssssissssssssssi", $clientname, $mc_id, $specials, $client_credibility, $ls_ids, $l_title, $l_first_name, $l_middle_name, $l_last_name, $l_gender, $leaders_status, $c_title, $c_first_name, $c_middle_name, $c_last_name, $c_gender, $country, $postcode, $street, $no_or_housename, $city, $phone, $email, $homepage, $vat_tax_no, $iban, $registration, $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_client_measures($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $ucm_id = mysqli_real_escape_string($mysqli, $data->ucm_id);
        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $wall_height = mysqli_real_escape_string($mysqli, $data->wall_height);
        $wall_out_thickness = mysqli_real_escape_string($mysqli, $data->wall_out_thickness);
        $wall_in_thickness = mysqli_real_escape_string($mysqli, $data->wall_in_thickness);
        $wall_middle_thickness = mysqli_real_escape_string($mysqli, $data->wall_middle_thickness);
        $windows_top = mysqli_real_escape_string($mysqli, $data->windows_top);
        $in_doors_top = mysqli_real_escape_string($mysqli, $data->in_doors_top);
        $ex_doors_top = mysqli_real_escape_string($mysqli, $data->ex_doors_top);
        $foundation = mysqli_real_escape_string($mysqli, $data->foundation);
        $ceiling = mysqli_real_escape_string($mysqli, $data->ceiling);

        $stmt = "update `u_clients_measures` set `mc_id`='$mc_id',`wall_height`='$wall_height',`wall_out_thickness`='$wall_out_thickness',`wall_in_thickness`='$wall_in_thickness',`wall_middle_thickness`='$wall_middle_thickness',`windows_top`='$windows_top',`ex_doors_top`='$ex_doors_top',`in_doors_top`='$in_doors_top',`foundation`='$foundation',`ceiling`='$ceiling' where `ucm_id`='$ucm_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_client2($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $clientname = mysqli_real_escape_string($mysqli, $data->clientname ?? '');
        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id ?? '0');
        $lt_id = mysqli_real_escape_string($mysqli, $data->lt_id ?? '0');
        $specials = mysqli_real_escape_string($mysqli, $data->specials ?? '');
        $client_credibility = mysqli_real_escape_string($mysqli, $data->client_credibility ?? '0');
        $referrer = mysqli_real_escape_string($mysqli, $data->referrer ?? '0');
        $partner_since = mysqli_real_escape_string($mysqli, $data->partner_since ?? '0000-00-00');
        $ls_ids = mysqli_real_escape_string($mysqli, $data->ls_ids ?? '');
        $country = mysqli_real_escape_string($mysqli, $data->country ?? '0');
        $registration = mysqli_real_escape_string($mysqli, $data->registration ?? '');
        $supervisors = mysqli_real_escape_string($mysqli, $data->supervisors ?? '');
        $l_title = mysqli_real_escape_string($mysqli, $data->l_title ?? '');
        $l_first_name = mysqli_real_escape_string($mysqli, $data->l_first_name ?? '');
        $l_middle_name = mysqli_real_escape_string($mysqli, $data->l_middle_name ?? '');
        $l_last_name = mysqli_real_escape_string($mysqli, $data->l_last_name ?? '');
        $l_gender = mysqli_real_escape_string($mysqli, $data->l_gender ?? '');
        $leaders_status = mysqli_real_escape_string($mysqli, $data->leaders_status ?? '');
        $contact_status = mysqli_real_escape_string($mysqli, $data->contact_status ?? '');
        $c_title = mysqli_real_escape_string($mysqli, $data->c_title ?? '');
        $c_first_name = mysqli_real_escape_string($mysqli, $data->c_first_name ?? '');
        $c_middle_name = mysqli_real_escape_string($mysqli, $data->c_middle_name ?? '');
        $c_last_name = mysqli_real_escape_string($mysqli, $data->c_last_name ?? '');
        $c_gender = mysqli_real_escape_string($mysqli, $data->c_gender ?? '');
        $phone = mysqli_real_escape_string($mysqli, $data->phone ?? '');
        $email = mysqli_real_escape_string($mysqli, $data->email ?? '');
        $additional_emails = mysqli_real_escape_string($mysqli, $data->additional_emails ?? '');
        $VAT_tax_no = mysqli_real_escape_string($mysqli, $data->VAT_tax_no ?? '');
        $iban = mysqli_real_escape_string($mysqli, $data->iban ?? '');
        $street = mysqli_real_escape_string($mysqli, $data->street ?? '');
        $no_or_housename = mysqli_real_escape_string($mysqli, $data->no_or_housename ?? '');
        $postcode = mysqli_real_escape_string($mysqli, $data->postcode ?? '');
        $city = mysqli_real_escape_string($mysqli, $data->city ?? '');
        $homepage = mysqli_real_escape_string($mysqli, $data->homepage ?? '');
        $client_price_remarks = mysqli_real_escape_string($mysqli, $data->client_price_remarks ?? '');
        $remarks_internal = mysqli_real_escape_string($mysqli, $data->remarks_internal ?? '');
        $see_all_orders = mysqli_real_escape_string($mysqli, $data->see_all_orders ?? '0');
        $house_owner = mysqli_real_escape_string($mysqli, $data->house_owner ?? '0');
        $public_presentation = mysqli_real_escape_string($mysqli, $data->public_presentation ?? '0');
        $c_status = mysqli_real_escape_string($mysqli, $data->c_status ?? '');

        $stmt = "update `u_clients` set `clientname`='$clientname',`mc_id`='$mc_id',`contact_status`='$contact_status',`lt_id`='$lt_id',`house_owner`='$house_owner',`public_presentation`='$public_presentation',`specials`='$specials',`client_credibility`='$client_credibility',`ls_ids`='$ls_ids',`referrer_id`='$referrer',`partner_since`='$partner_since',`l_title`='$l_title',`l_first_name`='$l_first_name', `l_middle_name`='$l_middle_name', `l_last_name`='$l_last_name', `l_gender`='$l_gender',`leaders_status`='$leaders_status',`c_title`='$c_title', `c_first_name`='$c_first_name',`c_middle_name`='$c_middle_name', `c_last_name`='$c_last_name',`c_gender`='$c_gender',`a_id`='$country',`postcode`='$postcode',`street`='$street',`no_or_housename`='$no_or_housename',`city`='$city',`phone`='$phone',`email`='$email',`additional_emails`='$additional_emails',`client_price_remarks`='$client_price_remarks',`remarks_internal`='$remarks_internal',`homepage`='$homepage',`vat_tax_no`='$VAT_tax_no',`iban`='$iban',`registration`='$registration',`supervisors`='$supervisors',`see_all_orders`='$see_all_orders',`c_status`='$c_status' where `client_ID`='$client_id'";
        
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_area($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $a_vat = mysqli_real_escape_string($mysqli, $data->a_vat);
        $vat_since = mysqli_real_escape_string($mysqli, $data->vat_since);
        $a_eu = mysqli_real_escape_string($mysqli, $data->a_eu);
        $eu_in = mysqli_real_escape_string($mysqli, $data->eu_in);
        $eu_out = mysqli_real_escape_string($mysqli, $data->eu_out);
        $a_id = mysqli_real_escape_string($mysqli, $data->a_id);

        $stmt = "update `areas` set `a_vat`='$a_vat',`vat_since`='$vat_since',`a_eu`='$a_eu',`eu_in`='$eu_in',`eu_out`='$eu_out' where `a_id`='$a_id'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_streif_client($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $clientname = mysqli_real_escape_string($mysqli, $data->clientname);
        // $mc_id=mysqli_real_escape_string($mysqli,$data->mc_id);
        // $lt_id=mysqli_real_escape_string($mysqli,$data->lt_id);
        // $specials=mysqli_real_escape_string($mysqli,$data->specials);
        // $client_credibility=mysqli_real_escape_string($mysqli,$data->client_credibility);
        // $ls_ids=mysqli_real_escape_string($mysqli,$data->ls_ids);
        $country = mysqli_real_escape_string($mysqli, $data->country);
        $registration = mysqli_real_escape_string($mysqli, $data->registration);
        // $supervisors=mysqli_real_escape_string($mysqli,$data->supervisors);
        $l_title = mysqli_real_escape_string($mysqli, $data->l_title);
        $l_first_name = mysqli_real_escape_string($mysqli, $data->l_first_name);
        $l_middle_name = mysqli_real_escape_string($mysqli, $data->l_middle_name);
        $l_last_name = mysqli_real_escape_string($mysqli, $data->l_last_name);
        $l_gender = mysqli_real_escape_string($mysqli, $data->l_gender);
        $leaders_status = mysqli_real_escape_string($mysqli, $data->leaders_status);
        $c_title = mysqli_real_escape_string($mysqli, $data->c_title);
        $c_first_name = mysqli_real_escape_string($mysqli, $data->c_first_name);
        $c_middle_name = mysqli_real_escape_string($mysqli, $data->c_middle_name);
        $c_last_name = mysqli_real_escape_string($mysqli, $data->c_last_name);
        $c_gender = mysqli_real_escape_string($mysqli, $data->c_gender);
        $phone = mysqli_real_escape_string($mysqli, $data->phone);
        $email = mysqli_real_escape_string($mysqli, $data->email);
        $VAT_tax_no = mysqli_real_escape_string($mysqli, $data->VAT_tax_no);
        //$iban=mysqli_real_escape_string($mysqli,$data->iban);
        $street = mysqli_real_escape_string($mysqli, $data->street);
        $no_or_housename = mysqli_real_escape_string($mysqli, $data->no_or_housename);
        $postcode = mysqli_real_escape_string($mysqli, $data->postcode);
        $city = mysqli_real_escape_string($mysqli, $data->city);
        $homepage = mysqli_real_escape_string($mysqli, $data->homepage);
        // $remarks_internal=mysqli_real_escape_string($mysqli,$data->remarks_internal);
        // $house_owner=mysqli_real_escape_string($mysqli,$data->house_owner);
        // $c_status=mysqli_real_escape_string($mysqli,$data->c_status);

        $stmt = "update `u_clients` set `clientname`='$clientname',`l_title`='$l_title',`l_first_name`='$l_first_name', `l_middle_name`='$l_middle_name', `l_last_name`='$l_last_name', `l_gender`='$l_gender',`leaders_status`='$leaders_status',`c_title`='$c_title', `c_first_name`='$c_first_name',`c_middle_name`='$c_middle_name', `c_last_name`='$c_last_name',`c_gender`='$c_gender',`a_id`='$country',`postcode`='$postcode',`street`='$street',`no_or_housename`='$no_or_housename',`city`='$city',`phone`='$phone',`email`='$email',`homepage`='$homepage',`vat_tax_no`='$VAT_tax_no',`registration`='$registration' where `client_ID`='$client_id'";
        //mysqli_stmt_bind_param($stmt,"siiissssssssssssissssssssssi",$clientname,$mc_id,$specials,$client_credibility,$ls_ids,$l_title,$l_first_name,$l_middle_name,$l_last_name,$l_gender,$leaders_status,$c_title,$c_first_name,$c_middle_name,$c_last_name,$c_gender,$country,$postcode,$street,$no_or_housename,$city,$phone,$email,$homepage,$vat_tax_no,$iban,$registration,$client_id);

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_main_client($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $mc_id = mysqli_real_escape_string($mysqli, $data->mc_id);
        $clientname = mysqli_real_escape_string($mysqli, $data->clientname);
        $client_credibility=mysqli_real_escape_string($mysqli,$data->client_credibility);
        $price_request_at_superior=mysqli_real_escape_string($mysqli,$data->price_request_at_superior ?? 0);
        $country = mysqli_real_escape_string($mysqli, $data->a_id);
        $registration = mysqli_real_escape_string($mysqli, $data->registration);
        $supervisory_authority = mysqli_real_escape_string($mysqli, $data->supervisory_authority);
        $leaders_status = mysqli_real_escape_string($mysqli, $data->leaders_status);
        $leaders_name = mysqli_real_escape_string($mysqli, $data->leaders_name);
        $contact_at_client = mysqli_real_escape_string($mysqli, $data->contact_at_client);
        $phone = mysqli_real_escape_string($mysqli, $data->phone);
        $email = mysqli_real_escape_string($mysqli, $data->email);
        $VAT_tax_no = mysqli_real_escape_string($mysqli, $data->VAT_tax_no);
        $tax_number = mysqli_real_escape_string($mysqli, $data->tax_number);
        $iban=mysqli_real_escape_string($mysqli,$data->iban);
        $street = mysqli_real_escape_string($mysqli, $data->street);
        $no_or_housename = mysqli_real_escape_string($mysqli, $data->no_or_housename);
        $postcode = mysqli_real_escape_string($mysqli, $data->postcode);
        $city = mysqli_real_escape_string($mysqli, $data->city);
        $homepage = mysqli_real_escape_string($mysqli, $data->homepage);
        $remarks_internal=mysqli_real_escape_string($mysqli,$data->remarks_internal);
        $price_remarks = mysqli_real_escape_string($mysqli, $data->price_remarks);

        $stmt = "update `u_clients_main` set `clientname`='$clientname',`leaders_name`='$leaders_name',`leaders_status`='$leaders_status',`supervisory_authority`='$supervisory_authority', `contact-at-client`='$contact_at_client',`client_credibility`='$client_credibility',`price_request_at_superior`='$price_request_at_superior',`a_id`='$country',`postcode`='$postcode',`street`='$street',`no-or-housename`='$no_or_housename',`city`='$city',`phone`='$phone',`email`='$email',`homepage`='$homepage',`vat-tax-no`='$VAT_tax_no',`tax_number`='$tax_number',`registration`='$registration',`remarks_internal`='$remarks_internal',`iban`='$iban',`price_remarks`='$price_remarks' where `mc_id`='$mc_id'";
        

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function create_main_client($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $price_remarks = mysqli_real_escape_string($mysqli, $data->price_remarks);
        $clientname = mysqli_real_escape_string($mysqli, $data->clientname);
        $client_credibility=mysqli_real_escape_string($mysqli,$data->client_credibility);
        $country = mysqli_real_escape_string($mysqli, $data->a_id);
        $registration = mysqli_real_escape_string($mysqli, $data->registration);
        $supervisory_authority = mysqli_real_escape_string($mysqli, $data->supervisory_authority);
        $leaders_status = mysqli_real_escape_string($mysqli, $data->leaders_status);
        $leaders_name = mysqli_real_escape_string($mysqli, $data->leaders_name);
        $contact_at_client = mysqli_real_escape_string($mysqli, $data->contact_at_client);
        $phone = mysqli_real_escape_string($mysqli, $data->phone);
        $email = mysqli_real_escape_string($mysqli, $data->email);
        $VAT_tax_no = mysqli_real_escape_string($mysqli, $data->VAT_tax_no);
        $iban=mysqli_real_escape_string($mysqli,$data->iban);
        $street = mysqli_real_escape_string($mysqli, $data->street);
        $no_or_housename = mysqli_real_escape_string($mysqli, $data->no_or_housename);
        $postcode = mysqli_real_escape_string($mysqli, $data->postcode);
        $city = mysqli_real_escape_string($mysqli, $data->city);
        $homepage = mysqli_real_escape_string($mysqli, $data->homepage);
        $remarks_internal=mysqli_real_escape_string($mysqli,$data->remarks_internal);

        $stmt = "insert into `u_clients_main`(`clientname`,`leaders_name`,`leaders_status`, `contact-at-client`,`client_credibility`,`a_id`,`postcode`,`street`,`no-or-housename`,
        `city`,`phone`,`email`,`homepage`,`vat-tax-no`,`registration`,`supervisory_authority`,`remarks_internal`,`iban`,`price_remarks`) values('$clientname','$leaders_name','$leaders_status','$contact_at_client',
        '$client_credibility','$country','$postcode','$street','$no_or_housename','$city','$phone','$email',
        '$homepage','$VAT_tax_no','$registration','$supervisory_authority','$remarks_internal','$iban','$price_remarks')";
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_client_password($client_id, $password)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $password = sha1($password);

        $stmt = mysqli_prepare($mysqli, "update `u_clients` set `password`=? where `client_ID`=?");

        mysqli_stmt_bind_param($stmt, "si", $password, $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_client_status($client_id, $status)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $status = mysqli_real_escape_string($mysqli, $status);

        $stmt = mysqli_prepare($mysqli, "update `u_clients` set `c_status`=? where `client_ID`=?");

        mysqli_stmt_bind_param($stmt, "si", $status, $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_creator_password($creatorid, $password)
    {
        $mysqli = $this->dbconnect();
        $creatorid = mysqli_real_escape_string($mysqli, $creatorid);
        $password = sha1($password);

        $stmt = mysqli_prepare($mysqli, "update `u_creators` set `uca_password`=? where `uca_id`=?");

        mysqli_stmt_bind_param($stmt, "si", $password, $creatorid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_all_clients_by_id()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` order by `client_ID` DESC");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_clients_by_enterprise()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` order by `clientname` asc,`c_last_name` ASC");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    //bookkeeping public functions

    public function get_all_cumulative_orders($mc_id, $start_date, $end_date)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $start_date = mysqli_real_escape_string($mysqli, $start_date);
        $end_date = mysqli_real_escape_string($mysqli, $end_date);

        //$stmt=mysqli_prepare($mysqli,"select * from `orders` where `mc_id`=? and `o_status`<='8' and `o_date` between ? and ? order by `o_date` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `orders` right join `u_clients` on `orders`.`u_client_ID`=`u_clients`.`client_ID` where `orders`.`mc_id`=? and `orders`.`o_status`<='8' and cast(`orders`.`o_date` as date) between ? and ? order by `u_clients`.`specials` desc, `orders`.`o_date` asc");
        mysqli_stmt_bind_param($stmt, "iss", $mc_id, $start_date, $end_date);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_cumulative_orders_order_by_date($mc_id, $start_date, $end_date)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $start_date = mysqli_real_escape_string($mysqli, $start_date);
        $end_date = mysqli_real_escape_string($mysqli, $end_date);

        //$stmt=mysqli_prepare($mysqli,"select * from `orders` where `mc_id`=? and `o_status`<='8' and `o_date` between ? and ? order by `o_date` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `orders` right join `u_clients` on `orders`.`u_client_ID`=`u_clients`.`client_ID` where `orders`.`mc_id`=? and `orders`.`o_status`<='8' and cast(`orders`.`o_date` as date) between ? and ? order by `orders`.`o_date` desc");
        mysqli_stmt_bind_param($stmt, "iss", $mc_id, $start_date, $end_date);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_cumulative_orders_simple_client($client_id, $start_date, $end_date)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $start_date = mysqli_real_escape_string($mysqli, $start_date);
        $end_date = mysqli_real_escape_string($mysqli, $end_date);

        //$stmt=mysqli_prepare($mysqli,"select * from `orders` where `mc_id`=? and `o_status`<='8' and `o_date` between ? and ? order by `o_date` asc");
        $stmt = mysqli_prepare($mysqli, "select * from `orders` right join `u_clients` on `orders`.`u_client_ID`=`u_clients`.`client_ID` where `orders`.`u_client_ID`=? and `orders`.`o_status`<='8' and `orders`.`o_date` between ? and ? order by `u_clients`.`specials` desc, `orders`.`o_date` asc");
        mysqli_stmt_bind_param($stmt, "iss", $client_id, $start_date, $end_date);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_main_client($mc_id)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main` where `mc_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $mc_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_main_client_by_clientname($client_name)
    {
        $mysqli = $this->dbconnect();
        $client_name = mysqli_real_escape_string($mysqli, $client_name);
        $param="%".$client_name."%";
        
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main` where `clientname` like ?");
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_main_clients()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main` where `inactive`='0' order by `clientname` ASC");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_client_bosses()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `u_clients_bosses`");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_active_inactive_main_clients()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_main` order by `clientname` ASC");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_licences($licence_taker_id)
    {
        $mysqli = $this->dbconnect();
        $licence_taker_id = mysqli_real_escape_string($mysqli, $licence_taker_id);

        $licence_sql = "select * from `licences` where `licence-taker`='$licence_taker_id'";

        $licence_result = mysqli_query($mysqli, $licence_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($licence_result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_licences2($licence_taker_id)
    {
        $mysqli = $this->dbconnect();
        $licence_taker_id = mysqli_real_escape_string($mysqli, $licence_taker_id);

        $licence_sql = "select * from `licences` where `licence-taker`='$licence_taker_id' or `uprod_id` like '%" . $licence_taker_id . ";%'"; //why is there also `uprod_id` ?

        //$licence_sql="select * from `licences` where `licence-taker`='$licence_taker_id'";

        $licence_result = mysqli_query($mysqli, $licence_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($licence_result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_country($a_id)
    {
        $mysqli = $this->dbconnect();
        $a_id = mysqli_real_escape_string($mysqli, $a_id);

        $stmt = mysqli_prepare($mysqli, "select * from `areas` where `a_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $a_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_licence_ids()
    {
        $mysqli = $this->dbconnect();
        $get_licence_takers_sql = "select * from `licences` order by `lic_id` asc";
        $get_licence_taker_result = mysqli_query($mysqli, $get_licence_takers_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($get_licence_taker_result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_licence_account($licenceid)
    {
        $mysqli = $this->dbconnect();
        $licenceid = mysqli_real_escape_string($mysqli, $licenceid);

        $stmt = mysqli_prepare($mysqli, "select * from `lic_accounts` where `lic_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $licenceid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_order_by_licid($licid)
    {
        $mysqli = $this->dbconnect();
        $show_order_by_licid_sql = "select * from `orders` where `lic_ID`='$licid' order by `order_ID` desc";
        $show_order_by_licid_result = mysqli_query($mysqli, $show_order_by_licid_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($show_order_by_licid_result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_client_by_licid_order($licenceid, $orderid)
    {
        $mysqli = $this->dbconnect();
        $get_client_by_licid_order_sql = "select * from `orders` where `lic_ID`='$licenceid' and `order_ID`='$orderid'";
        $get_client_by_licid_order_result = mysqli_query($mysqli, $get_client_by_licid_order_sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($get_client_by_licid_order_result, MYSQLI_BOTH);

        mysqli_close($mysqli);

        return $row;
    }

    //acceptance page

    public function update_o_notifications($o_id, $notifications)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $notifications = mysqli_real_escape_string($mysqli, $notifications);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `notifications`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "ii", $notifications, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_on_stock($o_id, $on_stock)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $on_stock = mysqli_real_escape_string($mysqli, $on_stock);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `on_stock`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "ii", $on_stock, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_materials_order($o_id, $materials_order)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $materials_order = mysqli_real_escape_string($mysqli, $materials_order);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `materials_order`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "ii", $materials_order, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_deadline($o_id, $o_deadline)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $o_deadline = mysqli_real_escape_string($mysqli, $o_deadline);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `o_deadline`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "si", $o_deadline, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_public($o_id, $public)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $public = mysqli_real_escape_string($mysqli, $public);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `public`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "ii", $public, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_suntour($o_id, $suntour)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $suntour = mysqli_real_escape_string($mysqli, $suntour);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `suntour`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "ii", $suntour, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_orf_youtube_link($orf_id, $orf_youtube_link)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $orf_youtube_link = mysqli_real_escape_string($mysqli, $orf_youtube_link);

        $stmt = mysqli_prepare($mysqli, "update `o_results` set `orf_youtube_link`=? where `orf_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $orf_youtube_link, $orf_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_orf_vimeo_link($orf_id, $orf_vimeo_link)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        $orf_vimeo_link = mysqli_real_escape_string($mysqli, $orf_vimeo_link);

        $stmt = mysqli_prepare($mysqli, "update `o_results` set `orf_vimeo_link`=? where `orf_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $orf_vimeo_link, $orf_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_correction($o_id, $correction)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $correction = mysqli_real_escape_string($mysqli, $correction);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `o_correction`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "ii", $correction, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_o_amendment($o_id, $amendment)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $amendment = mysqli_real_escape_string($mysqli, $amendment);

        $stmt = mysqli_prepare($mysqli, "update `orders` set `o_amendment`=? where `order_ID`=?");
        mysqli_stmt_bind_param($stmt, "ii", $amendment, $o_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }


    public function get_lic_site($ls_id)
    {
        $mysqli = $this->dbconnect();
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);

        $stmt = mysqli_prepare($mysqli, "select * from `lic_sites` where `ls_id`=?");
        mysqli_stmt_bind_param($stmt, "s", $ls_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_licences_by_lic_sites_id($ls_id)
    {
        $mysqli = $this->dbconnect();
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $param = "%" . $ls_id . ";%";
        $stmt = mysqli_prepare($mysqli, "select * from `licences` where `homepages_for_sale` like ?");
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function check_order_status($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $param = "%" . $o_id . ";%";
        $stmt = mysqli_prepare($mysqli, "select * from `orders` where order_id=$o_id AND `public`=1");
        mysqli_stmt_bind_param($stmt, "is", $param);


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        // return $row;
        if (!empty($row)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_currencies_from_licences($ls_id, $client_language)
    {
        $mysqli = $this->dbconnect();
        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $client_language = mysqli_real_escape_string($mysqli, $client_language);

        $param = "%" . $ls_id . ";%";
        $param2 = "%" . $client_language . ";%";
        $stmt = mysqli_prepare($mysqli, "select * from `licences` where `homepages_for_sale` like ? and `languages_on_page` like ?");
        mysqli_stmt_bind_param($stmt, "ss", $param, $param2);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_websites()
    {
        $mysqli = $this->dbconnect();
        $stmt = mysqli_prepare($mysqli, "select * from `lic_sites` order by `ls_name` asc");

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_window($window_id)
    {
        $mysqli = $this->dbconnect();
        $window_id = mysqli_real_escape_string($mysqli, $window_id);

        $stmt = mysqli_prepare($mysqli, "select * from `windows` where `window_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $window_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_layouts()
    {
        $mysqli = $this->dbconnect();
        $displayfloorcolors_sql = "select * from `layouts` order by `id` asc";
        $displayfloorcolors_result = mysqli_query($mysqli, $displayfloorcolors_sql) or die(mysqli_error($mysqli));
        $rows = array();
        $num = mysqli_num_rows($displayfloorcolors_result);

        while ($row = mysqli_fetch_array($displayfloorcolors_result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    function get_layouts_by_quality_id($quality_id)
    {
        $mysqli = $this->dbconnect();

        $quality_id = mysqli_real_escape_string($mysqli, $quality_id);

        $stmt = mysqli_prepare($mysqli, "select * from `layouts` where `quality_id`=? order by `id` asc");
        mysqli_stmt_bind_param($stmt, "s", $quality_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_layout($id, $quality_id, $window_id)
    {
        $mysqli = $this->dbconnect();

        $id = mysqli_real_escape_string($mysqli, $id);
        $quality_id = mysqli_real_escape_string($mysqli, $quality_id);
        $window_id = mysqli_real_escape_string($mysqli, $window_id);

        $stmt = mysqli_prepare($mysqli, "select * from `layouts` where `id`=? and `quality_id`=? and `window_id`=?");
        mysqli_stmt_bind_param($stmt, "sss", $id, $quality_id, $window_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_layout_by_name($layoutline_name, $quality_id, $window_id)
    {
        $mysqli = $this->dbconnect();
        $layoutline_name = mysqli_real_escape_string($mysqli, $layoutline_name);
        $window_id = mysqli_real_escape_string($mysqli, $window_id);
        $quality_id = mysqli_real_escape_string($mysqli, $quality_id);

        $sql = "select * from `layouts` where `layoutline_name`='$layoutline_name' and `window_id`='$window_id' and `quality_id`='$quality_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_close($mysqli);

        return $row;
    }

    public function filesize_formatted($path)
    {
        $size = filesize($path);
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    //activity page

    public function show_all_activity()
    {
        $mysqli = $this->dbconnect();
        $show_activity_sql = "select * from `u_activity` order by `date` desc limit 0,1000";
        $show_activity_result = mysqli_query($mysqli, $show_activity_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($show_activity_result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function get_product_last_change($o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `u_activity` WHERE `o_id` = ? AND `osub_id` LIKE ? AND `prod_id` LIKE ? ORDER BY `date` DESC");
        mysqli_stmt_bind_param($stmt, "iss", $o_id, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_this_product_all_changes($o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `u_activity` WHERE `o_id` = ? AND `osub_id` LIKE ? AND `prod_id` LIKE ? ORDER BY `date` DESC");
        mysqli_stmt_bind_param($stmt, "iss", $o_id, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function create_activity($logged_in_user_id, $description, $o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $create_activity_sql = "insert into `u_activity`(`uca_id`,`description`,`o_id`,`osub_id`,`prod_id`) values('$logged_in_user_id','$description','$o_id','$osub_id','$prod_id')";
        $create_activity_result = mysqli_query($mysqli, $create_activity_sql) or die(mysqli_error($mysqli));
        //$row=mysql_fetch_array($create_activity_result);

        mysqli_close($mysqli);

        //return $row;
    }

    public function get_activity_from_uca_id($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $stmt = mysqli_prepare($mysqli, "SELECT * FROM `u_activity` where `date`>= ( CURDATE() - INTERVAL 3 DAY ) and `uca_id`=? order by `date` DESC");

        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    //coordination page

    public function update_client_remarks_internal($client_ID, $remarks_internal)
    {
        $mysqli = $this->dbconnect();
        $client_ID = mysqli_real_escape_string($mysqli, $client_ID);
        $remarks_internal = mysqli_real_escape_string($mysqli, $remarks_internal);

        $stmt = mysqli_prepare($mysqli, "update `u_clients` set `remarks_internal`=? where `client_ID`=?");
        mysqli_stmt_bind_param($stmt, "si", $remarks_internal, $client_ID);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_main_client_remarks_internal($mc_id, $main_client_remarks_internal)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $main_client_remarks_internal = mysqli_real_escape_string($mysqli, $main_client_remarks_internal);

        $stmt = mysqli_prepare($mysqli, "update `u_clients_main` set `remarks_internal`=? where `mc_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $main_client_remarks_internal, $mc_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_main_client_status($mc_id, $status)
    {
        $mysqli = $this->dbconnect();
        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $status = mysqli_real_escape_string($mysqli, $status);

        $stmt = mysqli_prepare($mysqli, "update `u_clients_main` set `inactive`=? where `mc_id`=?");
        mysqli_stmt_bind_param($stmt, "ii", $status, $mc_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function show_coordination_can_not_do_orders($u_prod_id)
    {
        $mysqli = $this->dbconnect();
        $u_prod_id = mysqli_real_escape_string($mysqli, $u_prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_prod_id`=? and `o_status`='9' order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $u_prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_coordination_unfinished_orders($u_prod_id)
    {
        $mysqli = $this->dbconnect();
        $u_prod_id = mysqli_real_escape_string($mysqli, $u_prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_prod_id`=? and `o_status` between '1' and '7' order by `order_ID` desc");
        mysqli_stmt_bind_param($stmt, "i", $u_prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_coordination_finished_orders($u_prod_id, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $u_prod_id = mysqli_real_escape_string($mysqli, $u_prod_id);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);

        $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_prod_id`=? and `o_status`='8' order by `order_ID` desc limit ?,?");
        mysqli_stmt_bind_param($stmt, "iii", $u_prod_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_prods($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }


    public function get_b5_ex_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1561' and 'p1589' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b1_exterior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1161' and 'p1300') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_exterior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1561' and 'p1589') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }


    public function get_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }


    public function get_all_orders_products_with_extensions($orders)
    {
        $mysqli = $this->dbconnect();


        for ($i = 0; $i < count($orders); $i++) {

            $o_id = $orders[$i]['order_ID'];

            $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) order by `osub_id`,`prod_id` asc");
            mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $orders[$i]['products'] = array();

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $orders[$i]['products'][] = $row;
            }

            mysqli_stmt_close($stmt);


        }

        mysqli_close($mysqli);

        return $orders;
    }


    public function get_unfinished_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) AND (`p_status` != 8  and `p_status` != 12 and `p_status` != 11 and `p_status` != 10) order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_exterior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1660' and 'p1689' or `prod_id` like '%68s') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_exterior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1760' and 'p1799') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_exterior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1860' and 'p1900') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_ex_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1660' and 'p1699' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_ex_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1760' and 'p1799' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_ex_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1860' and 'p1899' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b3_in_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1301' and 'p1360' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b1_interior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1101' and 'p1160') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b3_interior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1301' and 'p1360') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b3_interior_products_with_extensions_scroll($o_id, $start, $limit)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $start = mysqli_real_escape_string($mysqli, $start);
        $limit = mysqli_real_escape_string($mysqli, $limit);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1301' and 'p1360') order by `osub_id`,`prod_id` asc limit ?,?");
        mysqli_stmt_bind_param($stmt, "iiii", $o_id, $o_id, $start, $limit);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_in_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1501' and 'p1560' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b5_interior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1501' and 'p1560') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_interior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1600' and 'p1659') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_interior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1700' and 'p1759') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_interior_products_with_extensions($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where (`o_id`=? or `om_id`=?) and (`prod_id` between 'p1800' and 'p1859') order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "ii", $o_id, $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b6_in_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1600' and 'p1659' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b7_in_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1700' and 'p1759' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_b8_in_ordered_products($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `prod_id` between 'p1800' and 'p1859' order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_o_prods($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_o_extension_prods($om_id)
    {
        $mysqli = $this->dbconnect();
        $om_id = mysqli_real_escape_string($mysqli, $om_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `om_id`=? order by `osub_id`,`prod_id` asc");
        mysqli_stmt_bind_param($stmt, "i", $om_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_finished_number_prods($orderid, $p_status)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);
        $p_status = mysqli_real_escape_string($mysqli, $p_status);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `p_status`=?");
        mysqli_stmt_bind_param($stmt, "ii", $orderid, $p_status);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function showallstatus()
    {
        $mysqli = $this->dbconnect();
        $showallstatus_sql = "select * from `o_status` order by `ost_id` asc";
        $showallstatus_result = mysqli_query($mysqli, $showallstatus_sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($showallstatus_result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_close($mysqli);

        return $rows;
    }

    public function show_activity_by_date_and_status($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $start_date = mysqli_real_escape_string($mysqli, $data->start_date);
        $end_date = mysqli_real_escape_string($mysqli, $data->end_date);
        $status = mysqli_real_escape_string($mysqli, $data->status);

        $sql = "SELECT * FROM `u_activity` WHERE CAST(`date` AS DATE) between ? and ? and `description` like '%$status%'";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;

    }

    public function create_status_remark($o_id, $osub_id, $prod_id, $status_id_before, $status_id_after, $remark_text, $person_id)
    {
        $mysqli = $this->dbconnect();
        $sql = "insert into `o_prod_remarks`(`o_id`,`osub_id`,`prod_id`,`status_id_before`,`status_id_after`,`remark_text`,`person_id`) values('$o_id','$osub_id','$prod_id','$status_id_before','$status_id_after','$remark_text','$person_id')";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    //this function already exists - has to be removed in the future
    public function check_assigned_status($o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_prods` where `o_id`=? and `osub_id`=? and `prod_id`=?");
        mysqli_stmt_bind_param($stmt, "iss", $o_id, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function assign_to_creator($o_id, $osub_id, $prod_id, $creator_id, $p_fac_ct, $p_fac_ca, $p_status)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $creator_id = mysqli_real_escape_string($mysqli, $creator_id);
        $p_status = mysqli_real_escape_string($mysqli, $p_status);

        $stmt = mysqli_prepare($mysqli, "update `o_prods` set `uca_id`=?, `p_status`=? where `o_id`=? and `osub_id`=? and `prod_id`=?");
        mysqli_stmt_bind_param($stmt, "iiiss", $creator_id, $p_status, $o_id, $osub_id, $prod_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    //tasksdetails page

    public function show_all_messages($o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $sql = "select * from `u_messages` where `o_id`='$o_id' and `osub_id`='$osub_id' and `prod_id`='$prod_id' order by `msg_id` desc";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function insert_message($o_id, $osub_id, $prod_id, $user_id, $message)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $user_id = mysqli_real_escape_string($mysqli, $user_id);
        $message = mysqli_real_escape_string($mysqli, $message);

        $date = gmdate("Y-m-d H:i:s");
        $sql = "insert into `u_messages`(`date`,`o_id`,`osub_id`,`prod_id`,`user_id`,`message`) values('$date','$o_id','$osub_id','$prod_id','$user_id','$message')";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function update_creator_message($msg_id, $message, $user_id)
    {
        $mysqli = $this->dbconnect();
        $msg_id = mysqli_real_escape_string($mysqli, $msg_id);
        $message = mysqli_real_escape_string($mysqli, $message);
        $user_id = mysqli_real_escape_string($mysqli, $user_id);
        $date = gmdate("Y-m-d H:i:s");

        $stmt = mysqli_prepare($mysqli, "update `u_messages` set `date`=?, `message`=?, `user_id`=? where `msg_id`=?");
        mysqli_stmt_bind_param($stmt, "ssii", $date, $message, $user_id, $msg_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_cnf_custom_internal_name($cnf_id,$cnf_custom_internal_name)
    {
        $mysqli = $this->dbconnect();
        $cnf_id = mysqli_real_escape_string($mysqli, $cnf_id);
        $cnf_custom_internal_name = mysqli_real_escape_string($mysqli, $cnf_custom_internal_name);

        $stmt = mysqli_prepare($mysqli, "update `correction_needed_files` set `cnf_custom_internal_name`=? where `cnf_id`=?");
        mysqli_stmt_bind_param($stmt, "si", $cnf_custom_internal_name, $cnf_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_language($ln_id)
    {
        $mysqli = $this->dbconnect();
        $ln_id = mysqli_real_escape_string($mysqli, $ln_id);

        $stmt = mysqli_prepare($mysqli, "select * from `languages` where `ln_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $ln_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_languages()
    {
        $mysqli = $this->dbconnect();

        $stmt = mysqli_prepare($mysqli, "select * from `languages` order by `ln_name` asc");

        mysqli_stmt_execute($stmt);

        $rows = array();

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    //bauvorchau

    public function show_all_creators()
    {
        $mysqli = $this->dbconnect();
        $sql = "select * from `u_creators`";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    //users page

    public function get_user_products_by_date($uca_id, $users_start_date, $users_end_date)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $sql = "select * from `o_prods` where `uca_id`='$uca_id' and `p_status`='8' and cast(`prod_finish_date` as date) between '$users_start_date' and '$users_end_date'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function show_all_planobjects()
    {
        $mysqli = $this->dbsuperplan();
        $query = "select * from `plan_objects`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_pls_files_by_pls_id($pls_id)
    {
        $mysqli = $this->dbsuperplan();
        $query = "select * from `pls_files` where `pls_id`='$pls_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }


    public function get_pls_file_by_plan_id($plan_id)
    {
        $mysqli = $this->dbsuperplan();

        $plan_id = mysqli_real_escape_string($mysqli, $plan_id);

        $query = "select * from `pls_files` where `plan_id`='$plan_id'";

        $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_close($mysqli);

        return $row;
    }

    public function show_all_licence_takers()

    {
        $mysqli = $this->dbconnect();
        //$uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $sql = "select * from `u_licence_takers` order by `Company` asc";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    /*public function show_all_producers()
	{
		$mysqli=$this->dbconnect();
		$uca_id=mysqli_real_escape_string($mysqli,$uca_id);
		$sql="select * from `u_licence_takers` where `producer`='1'";
		$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
		$rows=array();

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}

		mysqli_close($mysqli);

		return $rows;
    } */

    public function get_trader_producer_orders_by_date($selected_trader, $selected_producer, $traders_start_date, $traders_end_date)
    {
        $mysqli = $this->dbconnect();
        $licences = $this->get_trader_producer_licences($selected_trader, $selected_producer);

        $trader_producer_orders = array();

        for ($i = 0; $i < count($licences); $i++) {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_prod_id`=? and `lic_ID`='" . $licences[$i]['lic_id'] . "' and `o_status`<9 and cast(`o_date` as date) between ? and ?");
            mysqli_stmt_bind_param($stmt, "iss", $selected_producer, $traders_start_date, $traders_end_date);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $rows = array();

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $trader_producer_orders[] = $row;
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($mysqli);

        return $trader_producer_orders;
    }

    public function get_trader_orders_by_date($selected_trader, $traders_start_date, $traders_end_date)
    {
        $mysqli = $this->dbconnect();

        $traders_start_date = mysqli_real_escape_string($mysqli, $traders_start_date);
        $traders_end_date = mysqli_real_escape_string($mysqli, $traders_end_date);

        $licences = $this->get_licences($selected_trader);

        $trader_producer_orders = array();

        for ($i = 0; $i < count($licences); $i++) {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `lic_ID`='" . $licences[$i]['lic_id'] . "' and `o_status`<9 and cast(`o_date` as date) between ? and ?");
            mysqli_stmt_bind_param($stmt, "ss", $traders_start_date, $traders_end_date);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $rows = array();

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $trader_producer_orders[] = $row;
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($mysqli);

        return $trader_producer_orders;
    }

    public function get_trader_orders_by_finish_date($selected_trader, $traders_start_date, $traders_end_date)
    {
        $mysqli = $this->dbconnect();

        $traders_start_date = mysqli_real_escape_string($mysqli, $traders_start_date);
        $traders_end_date = mysqli_real_escape_string($mysqli, $traders_end_date);

        $licences = $this->get_licences($selected_trader);

        $trader_producer_orders = array();

        for ($i = 0; $i < count($licences); $i++) {
            //$stmt = mysqli_prepare($mysqli, "select * from `orders` where `lic_ID`='" . $licences[$i]['lic_id'] . "' and `o_status`<9 and cast(`o_date` as date) between ? and ?");
            $stmt = mysqli_prepare($mysqli, "select * from `orders` right join `o_prods` on `o_prods`.`o_id`=`orders`.`order_ID` where `lic_ID`='" . $licences[$i]['lic_id'] . "' and `o_prods`.`p_status`='8' and cast(`o_prods`.`prod_finish_date` as date) between ? and ? ORDER BY `orders`.`order_ID` DESC");
            mysqli_stmt_bind_param($stmt, "ss", $traders_start_date, $traders_end_date);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $rows = array();

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $trader_producer_orders[] = $row;
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($mysqli);

        return $trader_producer_orders;
    }

    public function get_trader_producer_licences($trader_lt_id, $producer_lt_id)
    {
        $mysqli = $this->dbconnect();
        $trader_lt_id = mysqli_real_escape_string($mysqli, $trader_lt_id);
        $producer_lt_id = mysqli_real_escape_string($mysqli, $producer_lt_id);

        $stmt = mysqli_prepare($mysqli, "select * from `licences` where `licence-taker`=? and `uprod_id` like ?");
        $uprod_id = "%" . $producer_lt_id . ";%";
        mysqli_stmt_bind_param($stmt, "is", $trader_lt_id, $uprod_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }


    function calculateProductAPU($productid)
    {
        $mysqli = $this->dbconnect();
        $productid = mysqli_real_escape_string($mysqli, $productid);

        $stmt1 = mysqli_prepare($mysqli, "select * from `products` where `prod_id`=?");
        mysqli_stmt_bind_param($stmt1, "s", $productid);

        mysqli_stmt_execute($stmt1);

        $result = mysqli_stmt_get_result($stmt1);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $cdws_ids = explode(",", $row['cdws_ids']);
        $product_apu = 0;

        for ($i = 0; $i < count($cdws_ids); $i++) {
            if ($cdws_ids[$i] != "") {
                $sql2 = "select * from `credits-worksteps-skp` where `cdws_id`='$cdws_ids[$i]'";
                $result2 = mysqli_query($mysqli, $sql2) or die(mysqli_error($mysqli));
                $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

                if(!empty($row2['cd_kind']))
                {
                    $sql3 = "select * from `credits-kinds` where `cd_kind`='" . $row2['cd_kind'] . "'";
                }
                else
                {
                    $sql3 = "select * from `credits-kinds` where `cd_kind`='0'";
                }

                $result3 = mysqli_query($mysqli, $sql3) or die(mysqli_error($mysqli));
                $row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);

                if(!empty($row2['cd_kind']))
                {
                    $apu = $row2['cdk_amount'] * ($row3['labc'] + $row3['capc']);
                }
                else
                {
                    $apu = 0 * ($row3['labc'] + $row3['capc']);
                }
                $product_apu += $apu;
            }
        }

        mysqli_stmt_close($stmt1);
        mysqli_close($mysqli);

        return $product_apu;
    }

    function calculateProductPrice($ls_id, $prod_id, $cur_factor)
    {
        $productAPU = bcdiv($this->calculateProductAPU($prod_id), 1, 2);

        if ($ls_id == "s007") {
            //interior
            $price_factorial = $this->get_price_factorial($ls_id);

            $pr_fac_uf_model = $price_factorial['b7_uf_model'];
            $pr_fac_layer = $price_factorial['b7_layer'];
            $pr_fac_render_total = $price_factorial['b7_render_total'];
            $pr_fac_render_detail = $price_factorial['b7_render_detail'];
            $pr_fac_360 = $price_factorial['b7_in_360_degree'];
            $pr_fac_movie = $price_factorial['b7_in_movie'];

            //exterior

            $pr_fac_house_model = $price_factorial['b7_house_model'];
            $pr_fac_special_environment = $price_factorial['b7_special_environment'];
            $pr_set_3_pictures_on_environment = $price_factorial['b7_set_3_pictures_on_environment'];
            $pr_fac_set_3_pictures_house_alone = $price_factorial['b7_set_3_pictures_house_alone'];
            $pr_fac_ex_360 = $price_factorial['b7_ex_360_degree'];
            $pr_fac_ex_movie = $price_factorial['b7_ex_movie'];


            if ($prod_id == "p1701") {
                $productPrice = bcdiv($productAPU * $pr_fac_uf_model * $cur_factor, 1, 2);
            } elseif (($prod_id == "p1702") || ($prod_id == "p1703") || ($prod_id == "p1722") || ($prod_id == "p1723") || ($prod_id == "p1742") || ($prod_id == "p1743")) {
                $productPrice = bcdiv($productAPU * $pr_fac_render_total * $cur_factor, 1, 2);
            } elseif (($prod_id == "p1704") || ($prod_id == "p1705") || ($prod_id == "p1724") || ($prod_id == "p1725") || ($prod_id == "p1744") || ($prod_id == "p1745")) {
                $productPrice = bcdiv($productAPU * $pr_fac_render_detail * $cur_factor, 1, 2);
            } elseif (($prod_id == "p1706") || ($prod_id == "p1726") || ($prod_id == "p1746")) {
                $productPrice = bcdiv($productAPU * $pr_fac_360 * $cur_factor, 1, 2);
            } elseif (($prod_id == "p1707") || ($prod_id == "p1727") || ($prod_id == "p1747")) {
                $productPrice = bcdiv($productAPU * $pr_fac_movie * $cur_factor, 1, 2);
            } elseif ($prod_id == "p1761") {
                $productPrice = bcdiv($productAPU * $pr_fac_house_model * $cur_factor, 1, 2);
            } elseif ($prod_id == "p1781") {
                $productPrice = bcdiv($productAPU * $pr_fac_special_environment * $cur_factor, 1, 2);
            } elseif ($prod_id == "p1762") {
                $productPrice = bcdiv($productAPU * $pr_set_3_pictures_on_environment * $cur_factor, 1, 2);
            } elseif ($prod_id == "p1763") {
                $productPrice = bcdiv($productAPU * $pr_fac_set_3_pictures_house_alone * $cur_factor, 1, 2);
            } elseif ($prod_id == "p1766") {
                $productPrice = bcdiv($productAPU * $pr_fac_ex_360 * $cur_factor, 1, 2);
            } elseif ($prod_id == "p1767") {
                $productPrice = bcdiv($productAPU * $pr_fac_ex_movie * $cur_factor, 1, 2);
            } else {
                $productPrice = bcdiv($productAPU * $cur_factor, 1, 2);
            }
        } else {
            $productPrice = bcdiv($productAPU * $cur_factor, 1, 2);
        }

        return $productPrice;
    }

    public function upload_correction_needed_file($o_id, $osub_id, $prod_id, $uca_id, $original_file_name, $file_path, $internal_file_name, $upload_date)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);

        $sql = "insert into `correction_needed_files`(`o_id`,`osub_id`,`prod_id`,`uca_id`,`cnf_name`,`cnf_path_dom`,`cnf_internal_name_dom`,`cnf_upload_date`) values('$o_id','$osub_id','$prod_id','$uca_id','$original_file_name','$file_path','$internal_file_name','$upload_date')";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_correction_needed_files($o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $prod_id);

        $sql = "select * from `correction_needed_files` where `o_id`='$o_id' and `osub_id`='$osub_id' and `prod_id`='$prod_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $rows[] = $row;
        }

        mysqli_close($mysqli);

        return $rows;
    }

    public function delete_correction_needed_file($cnf_id)
    {
        $mysqli = $this->dbconnect();
        $cnf_id = mysqli_real_escape_string($mysqli, $cnf_id);

        $row = $this->get_correction_needed_file($cnf_id);

        $path = $_SERVER['DOCUMENT_ROOT'] . "correction_needed_files/" . $row['cnf_path_dom'] . $row['cnf_internal_name_dom'];
        if (file_exists($path)) {
            unlink($path);
        }

        $sql = "delete from `correction_needed_files` where `cnf_id`='$cnf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function get_correction_needed_file($cnf_id)
    {
        $mysqli = $this->dbconnect();
        $cnf_id = mysqli_real_escape_string($mysqli, $cnf_id);

        $sql = "select * from `correction_needed_files` where `cnf_id`='$cnf_id'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_BOTH);

        mysqli_close($mysqli);

        return $row;
    }


    //programs of employees

    public function convert_date_to_utc_time($the_date, $client_timezone)
    {
        $server_timezone = date_default_timezone_get();
        date_default_timezone_set($client_timezone);

        $the_date = strtotime($the_date); //format "2017-11-15 10:00"

        date_default_timezone_set("UTC");
        $new_utc_time = date("H:i", $the_date);
        date_default_timezone_set($server_timezone);

        return $new_utc_time;
    }

    public function get_day_name($year, $month, $day)
    {
        $selected_date = $year . "-" . $month . "-" . $day;
        $selected_day = date('l', strtotime($selected_date));
        return $selected_day;
    }

    public function get_deadline_without_weekends($original_deadline)
    {
        $today = new DateTime(gmdate("Y-m-d H:i:s"));
        $deadline = new DateTime($original_deadline);
        //$deadline->modify('-1 day');

        $diff = $deadline->diff($today);

        $period = new DatePeriod($today, new DateInterval('P1D'), $deadline);

        $weekend_days = 0;

        foreach ($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $weekend_days++;
            }
        }
        $deadline->modify("-" . $weekend_days . " days");
        return $new_deadline = $deadline->format("Y-m-d H:i:s");
    }

    public function create_uca_program($uca_id, $year, $month, $start_time_data, $end_time_data)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $month = mysqli_real_escape_string($mysqli, $month);
        $year = mysqli_real_escape_string($mysqli, $year);
        $start_time_data = json_decode($start_time_data);
        $end_time_data = json_decode($end_time_data);

        $work_start_time1 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time1);
        $work_end_time1 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time1);
        $work_start_time2 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time2);
        $work_end_time2 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time2);
        $work_start_time3 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time3);
        $work_end_time3 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time3);
        $work_start_time4 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time4);
        $work_end_time4 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time4);
        $work_start_time5 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time5);
        $work_end_time5 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time5);
        $work_start_time6 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time6);
        $work_end_time6 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time6);
        $work_start_time7 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time7);
        $work_end_time7 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time7);
        $work_start_time8 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time8);
        $work_end_time8 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time8);
        $work_start_time9 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time9);
        $work_end_time9 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time9);
        $work_start_time10 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time10);
        $work_end_time10 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time10);
        $work_start_time11 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time11);
        $work_end_time11 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time11);
        $work_start_time12 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time12);
        $work_end_time12 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time12);
        $work_start_time13 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time13);
        $work_end_time13 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time13);
        $work_start_time14 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time14);
        $work_end_time14 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time14);
        $work_start_time15 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time15);
        $work_end_time15 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time15);
        $work_start_time16 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time16);
        $work_end_time16 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time16);
        $work_start_time17 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time17);
        $work_end_time17 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time17);
        $work_start_time18 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time18);
        $work_end_time18 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time18);
        $work_start_time19 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time19);
        $work_end_time19 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time19);
        $work_start_time20 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time20);
        $work_end_time20 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time20);
        $work_start_time21 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time21);
        $work_end_time21 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time21);
        $work_start_time22 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time22);
        $work_end_time22 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time22);
        $work_start_time23 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time23);
        $work_end_time23 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time23);
        $work_start_time24 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time24);
        $work_end_time24 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time24);
        $work_start_time25 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time25);
        $work_end_time25 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time25);
        $work_start_time26 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time26);
        $work_end_time26 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time26);
        $work_start_time27 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time27);
        $work_end_time27 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time27);
        $work_start_time28 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time28);
        $work_end_time28 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time28);
        $work_start_time29 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time29);
        $work_end_time29 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time29);
        $work_start_time30 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time30);
        $work_end_time30 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time30);
        $work_start_time31 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time31);
        $work_end_time31 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time31);

        $stmt = "insert into `programs_of_employees`(`uca_id`,`year`,`month`,`work_start_time1`,`work_end_time1`,`work_start_time2`,`work_end_time2`,`work_start_time3`,`work_end_time3`,`work_start_time4`,`work_end_time4`,`work_start_time5`,`work_end_time5`,`work_start_time6`,`work_end_time6`,`work_start_time7`,`work_end_time7`,`work_start_time8`,`work_end_time8`,`work_start_time9`,`work_end_time9`,`work_start_time10`,`work_end_time10`,`work_start_time11`,`work_end_time11`,`work_start_time12`,`work_end_time12`,`work_start_time13`,`work_end_time13`,`work_start_time14`,`work_end_time14`,`work_start_time15`,`work_end_time15`,`work_start_time16`,`work_end_time16`,`work_start_time17`,`work_end_time17`,`work_start_time18`,`work_end_time18`,`work_start_time19`,`work_end_time19`,`work_start_time20`,`work_end_time20`,`work_start_time21`,`work_end_time21`,`work_start_time22`,`work_end_time22`,`work_start_time23`,`work_end_time23`,`work_start_time24`,`work_end_time24`,`work_start_time25`,`work_end_time25`,`work_start_time26`,`work_end_time26`,`work_start_time27`,`work_end_time27`,`work_start_time28`,`work_end_time28`,`work_start_time29`,`work_end_time29`,`work_start_time30`,`work_end_time30`,`work_start_time31`,`work_end_time31`) values('$uca_id','$year','$month','$work_start_time1','$work_end_time1','$work_start_time2','$work_end_time2','$work_start_time3','$work_end_time3','$work_start_time4','$work_end_time4','$work_start_time5','$work_end_time5','$work_start_time6','$work_end_time6','$work_start_time7','$work_end_time7','$work_start_time8','$work_end_time8','$work_start_time9','$work_end_time9','$work_start_time10','$work_end_time10','$work_start_time11','$work_end_time11','$work_start_time12','$work_end_time12','$work_start_time13','$work_end_time13','$work_start_time14','$work_end_time14','$work_start_time15','$work_end_time15','$work_start_time16','$work_end_time16','$work_start_time17','$work_end_time17','$work_start_time18','$work_end_time18','$work_start_time19','$work_end_time19','$work_start_time20','$work_end_time20','$work_start_time21','$work_end_time21','$work_start_time22','$work_end_time22','$work_start_time23','$work_end_time23','$work_start_time24','$work_end_time24','$work_start_time25','$work_end_time25','$work_start_time26','$work_end_time26','$work_start_time27','$work_end_time27','$work_start_time28','$work_end_time28','$work_start_time29','$work_end_time29','$work_start_time30','$work_end_time30','$work_start_time31','$work_end_time31')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_next_day_program($uca_id, $year, $month, $nextday, $start_time_data, $end_time_data)
    {
        $mysqli = $this->dbconnect();

        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $month = mysqli_real_escape_string($mysqli, $month);
        $year = mysqli_real_escape_string($mysqli, $year);
        $nextday = mysqli_real_escape_string($mysqli, $nextday);
        $start_time_data = mysqli_real_escape_string($mysqli, $start_time_data);
        $end_time_data = mysqli_real_escape_string($mysqli, $end_time_data);

        $stmt = "update `programs_of_employees` set `work_start_time" . $nextday . "`='$start_time_data',`work_end_time" . $nextday . "`='$end_time_data' where `uca_id`='$uca_id' and `year`='$year' and `month`='$month'";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function insert_next_day_program($uca_id, $year, $month, $nextday, $start_time_data, $end_time_data)
    {
        $mysqli = $this->dbconnect();

        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $month = mysqli_real_escape_string($mysqli, $month);
        $year = mysqli_real_escape_string($mysqli, $year);
        $nextday = mysqli_real_escape_string($mysqli, $nextday);
        $start_time_data = mysqli_real_escape_string($mysqli, $start_time_data);
        $end_time_data = mysqli_real_escape_string($mysqli, $end_time_data);

        $stmt = "insert into `programs_of_employees` (`uca_id`,`year`,`month`,`work_start_time" . $nextday . "`,`work_end_time" . $nextday . "`) values('$uca_id','$year','$month','$start_time_data','$end_time_data')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function update_uca_program($uca_id, $year, $month, $start_time_data, $end_time_data)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $month = mysqli_real_escape_string($mysqli, $month);
        $year = mysqli_real_escape_string($mysqli, $year);
        $start_time_data = json_decode($start_time_data);
        $end_time_data = json_decode($end_time_data);

        $work_start_time1 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time1);
        $work_end_time1 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time1);
        $work_start_time2 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time2);
        $work_end_time2 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time2);
        $work_start_time3 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time3);
        $work_end_time3 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time3);
        $work_start_time4 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time4);
        $work_end_time4 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time4);
        $work_start_time5 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time5);
        $work_end_time5 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time5);
        $work_start_time6 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time6);
        $work_end_time6 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time6);
        $work_start_time7 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time7);
        $work_end_time7 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time7);
        $work_start_time8 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time8);
        $work_end_time8 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time8);
        $work_start_time9 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time9);
        $work_end_time9 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time9);
        $work_start_time10 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time10);
        $work_end_time10 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time10);
        $work_start_time11 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time11);
        $work_end_time11 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time11);
        $work_start_time12 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time12);
        $work_end_time12 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time12);
        $work_start_time13 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time13);
        $work_end_time13 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time13);
        $work_start_time14 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time14);
        $work_end_time14 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time14);
        $work_start_time15 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time15);
        $work_end_time15 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time15);
        $work_start_time16 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time16);
        $work_end_time16 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time16);
        $work_start_time17 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time17);
        $work_end_time17 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time17);
        $work_start_time18 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time18);
        $work_end_time18 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time18);
        $work_start_time19 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time19);
        $work_end_time19 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time19);
        $work_start_time20 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time20);
        $work_end_time20 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time20);
        $work_start_time21 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time21);
        $work_end_time21 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time21);
        $work_start_time22 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time22);
        $work_end_time22 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time22);
        $work_start_time23 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time23);
        $work_end_time23 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time23);
        $work_start_time24 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time24);
        $work_end_time24 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time24);
        $work_start_time25 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time25);
        $work_end_time25 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time25);
        $work_start_time26 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time26);
        $work_end_time26 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time26);
        $work_start_time27 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time27);
        $work_end_time27 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time27);
        $work_start_time28 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time28);
        $work_end_time28 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time28);
        $work_start_time29 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time29);
        $work_end_time29 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time29);
        $work_start_time30 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time30);
        $work_end_time30 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time30);
        $work_start_time31 = mysqli_real_escape_string($mysqli, $start_time_data->work_start_time31);
        $work_end_time31 = mysqli_real_escape_string($mysqli, $end_time_data->work_end_time31);

        $stmt = mysqli_prepare($mysqli, "update `programs_of_employees` set `work_start_time1`=?,`work_end_time1`=?,`work_start_time2`=?,`work_end_time2`=?,`work_start_time3`=?,`work_end_time3`=?,`work_start_time4`=?,`work_end_time4`=?,`work_start_time5`=?,`work_end_time5`=?,`work_start_time6`=?,`work_end_time6`=?,`work_start_time7`=?,`work_end_time7`=?,`work_start_time8`=?,`work_end_time8`=?,`work_start_time9`=?,`work_end_time9`=?,`work_start_time10`=?,`work_end_time10`=?,`work_start_time11`=?,`work_end_time11`=?,`work_start_time12`=?,`work_end_time12`=?,`work_start_time13`=?,`work_end_time13`=?,`work_start_time14`=?,`work_end_time14`=?,`work_start_time15`=?,`work_end_time15`=?,`work_start_time16`=?,`work_end_time16`=?,`work_start_time17`=?,`work_end_time17`=?,`work_start_time18`=?,`work_end_time18`=?,`work_start_time19`=?,`work_end_time19`=?,`work_start_time20`=?,`work_end_time20`=?,`work_start_time21`=?,`work_end_time21`=?,`work_start_time22`=?,`work_end_time22`=?,`work_start_time23`=?,`work_end_time23`=?,`work_start_time24`=?,`work_end_time24`=?,`work_start_time25`=?,`work_end_time25`=?,`work_start_time26`=?,`work_end_time26`=?,`work_start_time27`=?,`work_end_time27`=?,`work_start_time28`=?,`work_end_time28`=?,`work_start_time29`=?,`work_end_time29`=?,`work_start_time30`=?,`work_end_time30`=?,`work_start_time31`=?,`work_end_time31`=? where `uca_id`=? and `year`=? and `month`=?");

        mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssiii", $work_start_time1, $work_end_time1, $work_start_time2, $work_end_time2, $work_start_time3, $work_end_time3, $work_start_time4, $work_end_time4, $work_start_time5, $work_end_time5, $work_start_time6, $work_end_time6, $work_start_time7, $work_end_time7, $work_start_time8, $work_end_time8, $work_start_time9, $work_end_time9, $work_start_time10, $work_end_time10, $work_start_time11, $work_end_time11, $work_start_time12, $work_end_time12, $work_start_time13, $work_end_time13, $work_start_time14, $work_end_time14, $work_start_time15, $work_end_time15, $work_start_time16, $work_end_time16, $work_start_time17, $work_end_time17, $work_start_time18, $work_end_time18, $work_start_time19, $work_end_time19, $work_start_time20, $work_end_time20, $work_start_time21, $work_end_time21, $work_start_time22, $work_end_time22, $work_start_time23, $work_end_time23, $work_start_time24, $work_end_time24, $work_start_time25, $work_end_time25, $work_start_time26, $work_end_time26, $work_start_time27, $work_end_time27, $work_start_time28, $work_end_time28, $work_start_time29, $work_end_time29, $work_start_time30, $work_end_time30, $work_start_time31, $work_end_time31, $uca_id, $year, $month);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function check_uca_program($uca_id, $month, $year)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $month = mysqli_real_escape_string($mysqli, $month);
        $year = mysqli_real_escape_string($mysqli, $year);

        $stmt = "select * from `programs_of_employees` where `uca_id`='$uca_id' and `year`='$year' and `month`='$month'";

        $result = mysqli_query($mysqli, $stmt);

        $row = mysqli_fetch_array($result);

        mysqli_close($mysqli);

        return $row;
    }

    public function get_uca_program($uca_id, $month, $year)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $month = mysqli_real_escape_string($mysqli, $month);
        $year = mysqli_real_escape_string($mysqli, $year);

        $stmt = mysqli_prepare($mysqli, "select * from `programs_of_employees` where `uca_id`=? and `year`=? and `month`=?");
        mysqli_stmt_bind_param($stmt, "iis", $uca_id, $year, $month);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_uca_program_on_day($uca_id, $month, $year, $day)
    {
        $mysqli = $this->dbconnect();
        $uca_id = mysqli_real_escape_string($mysqli, $uca_id);
        $month = mysqli_real_escape_string($mysqli, $month);
        $year = mysqli_real_escape_string($mysqli, $year);

        $stmt = mysqli_prepare($mysqli, "select * from `programs_of_employees` where `uca_id`=? and `year`=? and `month`=? and `work_end_time".$day."` != null");
        mysqli_stmt_bind_param($stmt, "iis", $uca_id, $year, $month);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    //translation

    public function get_translation_text($lang_id, $text_id)
    {
        $mysqli = $this->dbconnect();
        $lang_id = mysqli_real_escape_string($mysqli, $lang_id);
        $text_id = mysqli_real_escape_string($mysqli, $text_id);

        $stmt = mysqli_prepare($mysqli, "select * from `x-texts` where `lang_id`=? and `text_id`=?");
        mysqli_stmt_bind_param($stmt, "is", $lang_id, $text_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function get_translation_text_api($lang_id, $text_id, $translation_table)
    {
        $mysqli = $this->dbconnect();
        $lang_id = mysqli_real_escape_string($mysqli, $lang_id);
        $text_id = mysqli_real_escape_string($mysqli, $text_id);
        $translation_table = mysqli_real_escape_string($mysqli, $translation_table);

        $stmt = mysqli_prepare($mysqli, "select * from `" . $translation_table . "` where `lang_id`=? and `text_id`=?");
        mysqli_stmt_bind_param($stmt, "ss", $lang_id, $text_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    function lang_api($text_id, $language = null)
    {
        if ($language === null) {
            $language = 1;
        }

        $result = $this->get_translation_text_api($language, $text_id, 'x-texts')['text'];
        if ($result === null) {
            $result = $this->get_translation_text_api($language, $text_id, 'x-texts2')['text'];
            if ($result === null) {
                $result = $this->get_translation_text_api(1, $text_id, 'x-texts')['text'];
                if ($result === null) {
                    $result = $this->get_translation_text_api(1, $text_id, 'x-texts2')['text'];
                    if ($result === null) {
                        $result = "";
                    }
                }
            }
        }
        return $result;
    }

    public function get_finished_result_files($orderid)
    {
        $mysqli = $this->dbconnect();
        $orderid = mysqli_real_escape_string($mysqli, $orderid);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where (`o_id`=? or `om_id`=?) and (`orf_status`='8') order by `orf_name` desc");
        mysqli_stmt_bind_param($stmt, "ii", $orderid, $orderid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_finished_b3_in_result_files($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `orf_status`='8' and `prod_id` between 'p1300' and 'p1330' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_finished_b5_in_result_files($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `orf_status`='8' and `prod_id` between 'p1500' and 'p1560' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_finished_b7_in_result_files($o_id, $osub_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $osub_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_results` where `o_id`=? and `osub_id`=? and `orf_status`='8' and `prod_id` between 'p1700' and 'p1760' order by `orf_name` asc");
        mysqli_stmt_bind_param($stmt, "is", $o_id, $osub_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_client_orders($client_id, $startpoint, $limit, $order_by_status = false)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $order_by_status = $order_by_status ? '`o_status` ASC,' : '';

        //echo $stmt2="select * from `orders` where `u_client_ID`='$client_id' order by `order_ID` desc limit $startpoint,$limit";
        $stmt2 = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? order by $order_by_status `order_ID` desc limit ?,?");
        mysqli_stmt_bind_param($stmt2, "iii", $client_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt2);

        //$result2=mysqli_query($mysqli,$stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        $rows = array();

        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
            $rows[] = $row2;
        }

        mysqli_stmt_close($stmt2);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_client_orders_without_deleted($client_id, $startpoint, $limit, $order_by_status = false)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $order_by_status = $order_by_status ? '`o_status` ASC,' : '';

        //echo $stmt2="select * from `orders` where `u_client_ID`='$client_id' order by `order_ID` desc limit $startpoint,$limit";
        $stmt2 = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `o_status`<9 order by $order_by_status `order_ID` desc limit ?,?");
        mysqli_stmt_bind_param($stmt2, "iii", $client_id, $startpoint, $limit);

        mysqli_stmt_execute($stmt2);

        //$result2=mysqli_query($mysqli,$stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        $rows = array();

        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
            $rows[] = $row2;
        }

        mysqli_stmt_close($stmt2);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_searched_client_orders($client_id, $search, $search_type, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $search = mysqli_real_escape_string($mysqli, $search);
        $search_type = mysqli_real_escape_string($mysqli, $search_type);

        if ($search_type == "order_id") {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `order_ID`=? limit ?,?");

            mysqli_stmt_bind_param($stmt, "iiii", $client_id, $search, $startpoint, $limit);
        }

        if ($search_type == "order_name") {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `u_client_ID`=? and `o_status`<'9' and `order_name` like ? order by `order_ID` desc limit ?,?");
            $search = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "isii", $client_id, $search, $startpoint, $limit);
        }


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_searched_client_orders_by_ls_id($ls_id, $search, $search_type, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();

        $ls_id = mysqli_real_escape_string($mysqli, $ls_id);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $search = mysqli_real_escape_string($mysqli, $search);
        $search_type = mysqli_real_escape_string($mysqli, $search_type);

        if ($search_type == "order_id") {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `order_ID`=? limit ?,?");

            mysqli_stmt_bind_param($stmt, "siii", $ls_id, $search, $startpoint, $limit);
        }

        if ($search_type == "order_name") {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `ls_id`=? and `o_status`<'9' and `order_name` like ? order by `order_ID` desc limit ?,?");
            $search = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "ssii", $ls_id, $search, $startpoint, $limit);
        }


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_searched_client_orders_by_mc_id($mc_id, $search, $search_type, $startpoint, $limit)
    {
        $mysqli = $this->dbconnect();

        $mc_id = mysqli_real_escape_string($mysqli, $mc_id);
        $startpoint = mysqli_real_escape_string($mysqli, $startpoint);
        $limit = mysqli_real_escape_string($mysqli, $limit);
        $search = mysqli_real_escape_string($mysqli, $search);
        $search_type = mysqli_real_escape_string($mysqli, $search_type);

        if ($search_type == "order_id") {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `mc_id`=? and `order_ID`=? limit ?,?");

            mysqli_stmt_bind_param($stmt, "siii", $mc_id, $search, $startpoint, $limit);
        }

        if ($search_type == "order_name") {
            $stmt = mysqli_prepare($mysqli, "select * from `orders` where `mc_id`=? and `o_status`<'9' and `order_name` like ? order by `order_ID` desc limit ?,?");
            $search = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "ssii", $mc_id, $search, $startpoint, $limit);
        }


        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_o_desc_in_b3($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_in_b3` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_in_b1($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_in_b1` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc($o_id, $osub_id, $prod_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $side = '';

        if ($osub_id[0] == 'n') {
            $side = 'in';
        }
        if ($osub_id[0] == 'x') {
            $side = 'ex';
        }

        $prod_kind = $prod_id[2];
        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_" . $side . "_b" . $prod_kind . "` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_in_b5($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_in_b5` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_in_b6($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_in_b6` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_in_b7($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_in_b7` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_o_desc_in_b8($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_desc_in_b8` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }


    //old function, in future won't be used
    public function add_o_desc_in_b3($o_id, $sl_id, $cls_id, $b3_col_amount, $usage, $col_price_in_b3, $fac_cl_in_b3, $o_price_in_b3, $col_apus_in_b3, $fac_prod_in_b3, $o_apus_in_b3, $col_labc_in_b3, $fac_labc_in_b3, $total_labcs_in_b3)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $sl_id = mysqli_real_escape_string($mysqli, $sl_id);
        $usage = mysqli_real_escape_string($mysqli, $usage);
        $b3_col_amount = mysqli_real_escape_string($mysqli, $b3_col_amount);
        $col_price_in_b3 = mysqli_real_escape_string($mysqli, $col_price_in_b3);
        $fac_cl_in_b3 = mysqli_real_escape_string($mysqli, $fac_cl_in_b3);
        $o_price_in_b3 = mysqli_real_escape_string($mysqli, $o_price_in_b3);
        $col_apus_in_b3 = mysqli_real_escape_string($mysqli, $col_apus_in_b3);
        $fac_prod_in_b3 = mysqli_real_escape_string($mysqli, $fac_prod_in_b3);
        $o_apus_in_b3 = mysqli_real_escape_string($mysqli, $o_apus_in_b3);
        $col_labc_in_b3 = mysqli_real_escape_string($mysqli, $col_labc_in_b3);
        $fac_labc_in_b3 = mysqli_real_escape_string($mysqli, $fac_labc_in_b3);
        $total_labcs_in_b3 = mysqli_real_escape_string($mysqli, $total_labcs_in_b3);

        $stmt = "insert into `o_desc_in_b3`(`o_id`,`sl_id`,`cls_id`,`col_amount_in_b3`,`usage`,`col_price_in_b3`,`fac_cl_in_b3`,`o_price_in_b3`,`col_apus_in_b3`,`fac_prod_in_b3`,`o_apus_in_b3`,`col_labc_in_b3`,`fac_labc_in_b3`,`total_labcs_in_b3`) values('$o_id','$sl_id','$cls_id','$b3_col_amount','$usage','$col_price_in_b3','$fac_cl_in_b3','$o_price_in_b3','$col_apus_in_b3','$fac_prod_in_b3','$o_apus_in_b3','$col_labc_in_b3','$fac_labc_in_b3','$total_labcs_in_b3')";
        //mysqli_stmt_bind_param($stmt,"issis",$o_id,$sl_id,$cls_id,$b3_col_amount,$usage);

        //mysqli_stmt_execute($stmt);
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function add_o_desc_in_b32($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $sl_id = mysqli_real_escape_string($mysqli, $data->sl_id ?? '');
        $cls_id = mysqli_real_escape_string($mysqli, $data->cls_id ?? '');
        $usage = mysqli_real_escape_string($mysqli, $data->usage ?? '');
        $b3_col_amount = mysqli_real_escape_string($mysqli, $data->col_amount_in_b3 ?? 0);

        $p1301_fac = mysqli_real_escape_string($mysqli, $data->p1301_fac ?? 1);
        $p1302_fac = mysqli_real_escape_string($mysqli, $data->p1302_fac ?? 1);
        $p1321_fac = mysqli_real_escape_string($mysqli, $data->p1321_fac ?? 1);
        $p1322_fac = mysqli_real_escape_string($mysqli, $data->p1322_fac ?? 1);

        $col_price_in_b3 = mysqli_real_escape_string($mysqli, $data->col_price_in_b3 ?? 0);
        $fac_cl_in_b3 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b3 ?? 1);
        $o_price_in_b3 = mysqli_real_escape_string($mysqli, $data->o_price_in_b3 ?? 0);
        $col_apus_in_b3 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b3 ?? 0);
        $fac_prod_in_b3 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b3 ?? 1);
        $o_apus_in_b3 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b3 ?? 0);
        $col_labc_in_b3 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b3 ?? 0);
        $fac_labc_in_b3 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b3 ?? 1);
        $total_labcs_in_b3 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b3 ?? 0);

        $stmt = "insert into `o_desc_in_b3`(`o_id`,`sl_id`,`cls_id`,`col_amount_in_b3`,`st_id`,`usage`,`p1301_fac`,`p1302_fac`,`p1321_fac`,`p1322_fac`,`col_price_in_b3`,`fac_cl_in_b3`,`o_price_in_b3`,`col_apus_in_b3`,`fac_prod_in_b3`,`o_apus_in_b3`,`col_labc_in_b3`,`fac_labc_in_b3`,`total_labcs_in_b3`) 
        values('$o_id','$sl_id','$cls_id','$b3_col_amount','','$usage','$p1301_fac','$p1302_fac','$p1321_fac','$p1322_fac','$col_price_in_b3','$fac_cl_in_b3','$o_price_in_b3','$col_apus_in_b3','$fac_prod_in_b3','$o_apus_in_b3','$col_labc_in_b3','$fac_labc_in_b3','$total_labcs_in_b3')";
                
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        
        mysqli_close($mysqli);
    }

    public function add_o_desc_in_b5($o_id, $layout_id, $window_id, $b5_col_amount, $col_price_in_b5, $fac_cl_in_b5, $o_price_in_b5, $col_apus_in_b5, $fac_prod_in_b5, $o_apus_in_b5, $col_labc_in_b5, $fac_labc_in_b5, $total_labc_in_b5)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $layout_id);
        $window_id = mysqli_real_escape_string($mysqli, $window_id);
        $b5_col_amount = mysqli_real_escape_string($mysqli, $b5_col_amount);
        $col_price_in_b5 = mysqli_real_escape_string($mysqli, $col_price_in_b5);
        $fac_cl_in_b5 = mysqli_real_escape_string($mysqli, $fac_cl_in_b5);
        $o_price_in_b5 = mysqli_real_escape_string($mysqli, $o_price_in_b5);
        $col_apus_in_b5 = mysqli_real_escape_string($mysqli, $col_apus_in_b5);
        $fac_prod_in_b5 = mysqli_real_escape_string($mysqli, $fac_prod_in_b5);
        $o_apus_in_b5 = mysqli_real_escape_string($mysqli, $o_apus_in_b5);
        $col_labc_in_b5 = mysqli_real_escape_string($mysqli, $col_labc_in_b5);
        $fac_labc_in_b5 = mysqli_real_escape_string($mysqli, $fac_labc_in_b5);
        $total_labc_in_b5 = mysqli_real_escape_string($mysqli, $total_labc_in_b5);

        $stmt = "insert into `o_desc_in_b5`(`o_id`,`layout_id`,`window_id`,`col_amount_in_b5`,`col_price_in_b5`,`fac_cl_in_b5`,`o_price_in_b5`,`col_apus_in_b5`,`fac_prod_in_b5`,`o_apus_in_b5`,`col_labc_in_b5`,`fac_labc_in_b5`,`total_labcs_in_b5`) values('$o_id','$layout_id','$window_id','$b5_col_amount','$col_price_in_b5','$fac_cl_in_b5','$o_price_in_b5','$col_apus_in_b5','$fac_prod_in_b5','$o_apus_in_b5','$col_labc_in_b5','$fac_labc_in_b5','$total_labc_in_b5')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_o_desc_in_b52($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '');
        $b5_col_amount = mysqli_real_escape_string($mysqli, $data->b5_col_amount ?? 0);

        $col_price_in_b5 = mysqli_real_escape_string($mysqli, $data->col_price_in_b5 ?? 0);
        $fac_cl_in_b5 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b5 ?? 1);
        $o_price_in_b5 = mysqli_real_escape_string($mysqli, $data->o_price_in_b5 ?? 0);
        $col_apus_in_b5 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b5 ?? 0);
        $fac_prod_in_b5 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b5 ?? 1);
        $o_apus_in_b5 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b5 ?? 0);
        $col_labc_in_b5 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b5 ?? 0);
        $fac_labc_in_b5 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b5 ?? 1);
        $total_labc_in_b5 = mysqli_real_escape_string($mysqli, $data->total_labc_in_b5 ?? 0);

        $p1501_fac = mysqli_real_escape_string($mysqli, $data->p1501_fac ?? 1.0);
        $p1502_fac = mysqli_real_escape_string($mysqli, $data->p1502_fac ?? 1.0);
        $p1503_fac = mysqli_real_escape_string($mysqli, $data->p1503_fac ?? 1.0);
        $p1504_fac = mysqli_real_escape_string($mysqli, $data->p1504_fac ?? 1.0);
        $p1506_fac = mysqli_real_escape_string($mysqli, $data->p1506_fac ?? 1.0);
        $p1507_fac = mysqli_real_escape_string($mysqli, $data->p1507_fac ?? 1.0);
        $p1508_fac = mysqli_real_escape_string($mysqli, $data->p1508_fac ?? 1.0);

        $p1521_fac = mysqli_real_escape_string($mysqli, $data->p1521_fac ?? 1.0);
        $p1522_fac = mysqli_real_escape_string($mysqli, $data->p1522_fac ?? 1.0);
        $p1523_fac = mysqli_real_escape_string($mysqli, $data->p1523_fac ?? 1.0);
        $p1524_fac = mysqli_real_escape_string($mysqli, $data->p1524_fac ?? 1.0);
        $p1526_fac = mysqli_real_escape_string($mysqli, $data->p1526_fac ?? 1.0);
        $p1527_fac = mysqli_real_escape_string($mysqli, $data->p1527_fac ?? 1.0);
        $p1528_fac = mysqli_real_escape_string($mysqli, $data->p1528_fac ?? 1.0);

        $p1541_fac = mysqli_real_escape_string($mysqli, $data->p1541_fac ?? 1.0);
        $p1542_fac = mysqli_real_escape_string($mysqli, $data->p1542_fac ?? 1.0);
        $p1543_fac = mysqli_real_escape_string($mysqli, $data->p1543_fac ?? 1.0);
        $p1544_fac = mysqli_real_escape_string($mysqli, $data->p1544_fac ?? 1.0);
        $p1546_fac = mysqli_real_escape_string($mysqli, $data->p1546_fac ?? 1.0);
        $p1547_fac = mysqli_real_escape_string($mysqli, $data->p1547_fac ?? 1.0);
        $p1548_fac = mysqli_real_escape_string($mysqli, $data->p1548_fac ?? 1.0);

        $stmt = "insert into `o_desc_in_b5`(`o_id`,`layout_id`,`window_id`,`floor`,`st_id`,`col_amount_in_b5`,`p1501_fac`,`p1502_fac`,`p1503_fac`,`p1504_fac`,`p1506_fac`,`p1507_fac`,`p1508_fac`,`p1521_fac`,`p1522_fac`,`p1523_fac`,`p1524_fac`,`p1526_fac`,`p1527_fac`,`p1528_fac`,`p1541_fac`,`p1542_fac`,`p1543_fac`,`p1544_fac`,`p1546_fac`,`p1547_fac`,`p1548_fac`,`col_price_in_b5`,`fac_cl_in_b5`,`o_price_in_b5`,`col_apus_in_b5`,`fac_prod_in_b5`,`o_apus_in_b5`,`col_labc_in_b5`,`fac_labc_in_b5`,`total_labcs_in_b5`) 
        values('$o_id','$layout_id','$window_id','','','$b5_col_amount','$p1501_fac','$p1502_fac','$p1503_fac','$p1504_fac','$p1506_fac','$p1507_fac','$p1508_fac','$p1521_fac','$p1522_fac','$p1523_fac','$p1524_fac','$p1526_fac','$p1527_fac','$p1528_fac','$p1541_fac','$p1542_fac','$p1543_fac','$p1544_fac','$p1546_fac','$p1547_fac','$p1548_fac','$col_price_in_b5','$fac_cl_in_b5','$o_price_in_b5','$col_apus_in_b5','$fac_prod_in_b5','$o_apus_in_b5','$col_labc_in_b5','$fac_labc_in_b5','$total_labc_in_b5')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_o_desc_in_b6($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '');
        $b6_col_amount = mysqli_real_escape_string($mysqli, $data->b6_col_amount ?? 0);

        $col_price_in_b6 = mysqli_real_escape_string($mysqli, $data->col_price_in_b6 ?? 0.0);
        $fac_cl_in_b6 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b6 ?? 1.0);
        $o_price_in_b6 = mysqli_real_escape_string($mysqli, $data->o_price_in_b6 ?? 0.0);
        $col_apus_in_b6 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b6 ?? 0.0);
        $fac_prod_in_b6 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b6 ?? 1.0);
        $o_apus_in_b6 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b6 ?? 0.0);
        $col_labc_in_b6 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b6 ?? 0.0);
        $fac_labc_in_b6 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b6 ?? 1.0);
        $total_labcs_in_b6 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b6 ?? 0.0);

        $p1600_fac = mysqli_real_escape_string($mysqli, $data->p1600_fac ?? 1.0);
        $p1601_fac = mysqli_real_escape_string($mysqli, $data->p1601_fac ?? 1.0);
        $p1604_fac = mysqli_real_escape_string($mysqli, $data->p1604_fac ?? 1.0);
        $p1621_fac = mysqli_real_escape_string($mysqli, $data->p1621_fac ?? 1.0);
        $p1624_fac = mysqli_real_escape_string($mysqli, $data->p1624_fac ?? 1.0);
        $p1641_fac = mysqli_real_escape_string($mysqli, $data->p1641_fac ?? 1.0);
        $p1644_fac = mysqli_real_escape_string($mysqli, $data->p1644_fac ?? 1.0);

        $p1606_fac = mysqli_real_escape_string($mysqli, $data->p1606_fac ?? 1.0);
        $p1626_fac = mysqli_real_escape_string($mysqli, $data->p1626_fac ?? 1.0);
        $p1646_fac = mysqli_real_escape_string($mysqli, $data->p1646_fac ?? 1.0);

        $stmt = "insert into `o_desc_in_b6`(`o_id`,`floor`,`layout_id`,`window_id`,`st_id`,`col_amount_in_b6`,`p1600_fac`,`p1601_fac`,`p1604_fac`,`p1621_fac`,`p1624_fac`,`p1641_fac`,`p1644_fac`,`p1606_fac`,`p1626_fac`,`p1646_fac`,`col_price_in_b6`,`fac_cl_in_b6`,`o_price_in_b6`,`col_apus_in_b6`,`fac_prod_in_b6`,`o_apus_in_b6`,`col_labc_in_b6`,`fac_labc_in_b6`,`total_labcs_in_b6`) values('$o_id','','$layout_id','$window_id','','$b6_col_amount','$p1600_fac','$p1601_fac','$p1604_fac','$p1621_fac','$p1624_fac','$p1641_fac','$p1644_fac','$p1606_fac','$p1626_fac','$p1646_fac','$col_price_in_b6','$fac_cl_in_b6','$o_price_in_b6','$col_apus_in_b6','$fac_prod_in_b6','$o_apus_in_b6','$col_labc_in_b6','$fac_labc_in_b6','$total_labcs_in_b6')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }


    //this old function won't be used in the future
    public function add_o_desc_in_b7($o_id, $layout_id, $window_id, $b5_col_amount, $col_price_in_b5, $fac_cl_in_b5, $o_price_in_b5, $col_apus_in_b5, $fac_prod_in_b5, $o_apus_in_b5, $col_labc_in_b5, $fac_labc_in_b5, $total_labc_in_b5)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $layout_id);
        $window_id = mysqli_real_escape_string($mysqli, $window_id);

        $b5_col_amount = mysqli_real_escape_string($mysqli, $b5_col_amount);
        $col_price_in_b5 = mysqli_real_escape_string($mysqli, $col_price_in_b5);
        $fac_cl_in_b5 = mysqli_real_escape_string($mysqli, $fac_cl_in_b5);
        $o_price_in_b5 = mysqli_real_escape_string($mysqli, $o_price_in_b5);
        $col_apus_in_b5 = mysqli_real_escape_string($mysqli, $col_apus_in_b5);
        $fac_prod_in_b5 = mysqli_real_escape_string($mysqli, $fac_prod_in_b5);
        $o_apus_in_b5 = mysqli_real_escape_string($mysqli, $o_apus_in_b5);
        $col_labc_in_b5 = mysqli_real_escape_string($mysqli, $col_labc_in_b5);
        $fac_labc_in_b5 = mysqli_real_escape_string($mysqli, $fac_labc_in_b5);
        $total_labc_in_b5 = mysqli_real_escape_string($mysqli, $total_labc_in_b5);

        $stmt = "insert into `o_desc_in_b7`(`o_id`,`layout_id`,`window_id`,`col_amount_in_b7`,`col_price_in_b7`,`fac_cl_in_b7`,`o_price_in_b7`,`col_apus_in_b7`,`fac_prod_in_b7`,`o_apus_in_b7`,`col_labc_in_b7`,`fac_labc_in_b7`,`total_labcs_in_b7`) values('$o_id','$layout_id','$window_id','$b5_col_amount','$col_price_in_b5','$fac_cl_in_b5','$o_price_in_b5','$col_apus_in_b5','$fac_prod_in_b5','$o_apus_in_b5','$col_labc_in_b5','$fac_labc_in_b5','$total_labc_in_b5')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_o_desc_in_b72($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);
        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '');

        $b7_col_amount = mysqli_real_escape_string($mysqli, $data->col_amount_in_b7);
        $col_price_in_b7 = mysqli_real_escape_string($mysqli, $data->col_price_in_b7 ?? 0.0);
        $fac_cl_in_b7 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b7 ?? 1.0);
        $o_price_in_b7 = mysqli_real_escape_string($mysqli, $data->o_price_in_b7 ?? 0.0);
        $col_apus_in_b7 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b7 ?? 0.0);
        $fac_prod_in_b7 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b7 ?? 1.0);
        $o_apus_in_b7 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b7 ?? 0.0);
        $col_labc_in_b7 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b7 ?? 0.0);
        $fac_labc_in_b7 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b7 ?? 1.0);
        $total_labcs_in_b7 = mysqli_real_escape_string($mysqli, $data->total_labcs_in_b7 ?? 0.0);

        $p1700_fac = mysqli_real_escape_string($mysqli, $data->p1700_fac ?? 1.0);
        $p1701_fac = mysqli_real_escape_string($mysqli, $data->p1701_fac ?? 1.0);
        $p1702_fac = mysqli_real_escape_string($mysqli, $data->p1702_fac ?? 1.0);
        $p1703_fac = mysqli_real_escape_string($mysqli, $data->p1703_fac ?? 1.0);
        $p1704_fac = mysqli_real_escape_string($mysqli, $data->p1704_fac ?? 1.0);
        $p1706_fac = mysqli_real_escape_string($mysqli, $data->p1706_fac ?? 1.0);
        $p1707_fac = mysqli_real_escape_string($mysqli, $data->p1707_fac ?? 1.0);
        $p1708_fac = mysqli_real_escape_string($mysqli, $data->p1708_fac ?? 1.0);

        $p1721_fac = mysqli_real_escape_string($mysqli, $data->p1721_fac ?? 1.0);
        $p1722_fac = mysqli_real_escape_string($mysqli, $data->p1722_fac ?? 1.0);
        $p1723_fac = mysqli_real_escape_string($mysqli, $data->p1723_fac ?? 1.0);
        $p1724_fac = mysqli_real_escape_string($mysqli, $data->p1724_fac ?? 1.0);
        $p1726_fac = mysqli_real_escape_string($mysqli, $data->p1726_fac ?? 1.0);
        $p1727_fac = mysqli_real_escape_string($mysqli, $data->p1727_fac ?? 1.0);
        $p1728_fac = mysqli_real_escape_string($mysqli, $data->p1728_fac ?? 1.0);

        $p1741_fac = mysqli_real_escape_string($mysqli, $data->p1741_fac ?? 1.0);
        $p1742_fac = mysqli_real_escape_string($mysqli, $data->p1742_fac ?? 1.0);
        $p1743_fac = mysqli_real_escape_string($mysqli, $data->p1743_fac ?? 1.0);
        $p1744_fac = mysqli_real_escape_string($mysqli, $data->p1744_fac ?? 1.0);
        $p1746_fac = mysqli_real_escape_string($mysqli, $data->p1746_fac ?? 1.0);
        $p1747_fac = mysqli_real_escape_string($mysqli, $data->p1747_fac ?? 1.0);
        $p1748_fac = mysqli_real_escape_string($mysqli, $data->p1748_fac ?? 1.0);

        $stmt = "insert into `o_desc_in_b7`(`o_id`,`r_kneewall`,`floor`,`layout_id`,`window_id`,`st_id`,`col_amount_in_b7`,`p1700_fac`,`p1701_fac`,`p1702_fac`,`p1703_fac`,`p1704_fac`,`p1706_fac`,`p1707_fac`,`p1708_fac`,`p1721_fac`,`p1722_fac`,`p1723_fac`,`p1724_fac`,`p1726_fac`,`p1727_fac`,`p1728_fac`,`p1741_fac`,`p1742_fac`,`p1743_fac`,`p1744_fac`,`p1746_fac`,`p1747_fac`,`p1748_fac`,`col_price_in_b7`,`fac_cl_in_b7`,`o_price_in_b7`,`col_apus_in_b7`,`fac_prod_in_b7`,`o_apus_in_b7`,`col_labc_in_b7`,`fac_labc_in_b7`,`total_labcs_in_b7`) values('$o_id','','','$layout_id','$window_id','','$b7_col_amount','$p1700_fac','$p1701_fac','$p1702_fac','$p1703_fac','$p1704_fac','$p1706_fac','$p1707_fac','$p1708_fac','$p1721_fac','$p1722_fac','$p1723_fac','$p1724_fac','$p1726_fac','$p1727_fac','$p1728_fac','$p1741_fac','$p1742_fac','$p1743_fac','$p1744_fac','$p1746_fac','$p1747_fac','$p1748_fac','$col_price_in_b7','$fac_cl_in_b7','$o_price_in_b7','$col_apus_in_b7','$fac_prod_in_b7','$o_apus_in_b7','$col_labc_in_b7','$fac_labc_in_b7','$total_labcs_in_b7')";
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_o_desc_in_b8($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);
        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $layout_id = mysqli_real_escape_string($mysqli, $data->layout_id ?? '');
        $window_id = mysqli_real_escape_string($mysqli, $data->window_id ?? '');

        $b8_col_amount = mysqli_real_escape_string($mysqli, $data->col_amount_in_b8 ?? 0.0);
        $col_price_in_b8 = mysqli_real_escape_string($mysqli, $data->col_price_in_b8 ?? 0.0);
        $fac_cl_in_b8 = mysqli_real_escape_string($mysqli, $data->fac_cl_in_b8 ?? 1.0);
        $o_price_in_b8 = mysqli_real_escape_string($mysqli, $data->o_price_in_b8 ?? 0.0);
        $col_apus_in_b8 = mysqli_real_escape_string($mysqli, $data->col_apus_in_b8 ?? 0.0);
        $fac_prod_in_b8 = mysqli_real_escape_string($mysqli, $data->fac_prod_in_b8 ?? 1.0);
        $o_apus_in_b8 = mysqli_real_escape_string($mysqli, $data->o_apus_in_b8 ?? 0.0);
        $col_labc_in_b8 = mysqli_real_escape_string($mysqli, $data->col_labc_in_b8 ?? 0.0);
        $fac_labc_in_b8 = mysqli_real_escape_string($mysqli, $data->fac_labc_in_b8 ?? 1.0);
        $total_labc_in_b8 = mysqli_real_escape_string($mysqli, $data->total_labc_in_b8 ?? 0.0);

        $p1800_fac = mysqli_real_escape_string($mysqli, $data->p1800_fac ?? 1.0);
        $p1801_fac = mysqli_real_escape_string($mysqli, $data->p1801_fac ?? 1.0);
        $p1802_fac = mysqli_real_escape_string($mysqli, $data->p1802_fac ?? 1.0);
        $p1803_fac = mysqli_real_escape_string($mysqli, $data->p1803_fac ?? 1.0);
        $p1804_fac = mysqli_real_escape_string($mysqli, $data->p1804_fac ?? 1.0);
        $p1806_fac = mysqli_real_escape_string($mysqli, $data->p1806_fac ?? 1.0);
        $p1807_fac = mysqli_real_escape_string($mysqli, $data->p1807_fac ?? 1.0);
        $p1808_fac = mysqli_real_escape_string($mysqli, $data->p1808_fac ?? 1.0);

        $p1821_fac = mysqli_real_escape_string($mysqli, $data->p1821_fac ?? 1.0);
        $p1822_fac = mysqli_real_escape_string($mysqli, $data->p1822_fac ?? 1.0);
        $p1823_fac = mysqli_real_escape_string($mysqli, $data->p1823_fac ?? 1.0);
        $p1824_fac = mysqli_real_escape_string($mysqli, $data->p1824_fac ?? 1.0);
        $p1826_fac = mysqli_real_escape_string($mysqli, $data->p1826_fac ?? 1.0);
        $p1827_fac = mysqli_real_escape_string($mysqli, $data->p1827_fac ?? 1.0);
        $p1828_fac = mysqli_real_escape_string($mysqli, $data->p1828_fac ?? 1.0);

        $p1841_fac = mysqli_real_escape_string($mysqli, $data->p1841_fac ?? 1.0);
        $p1842_fac = mysqli_real_escape_string($mysqli, $data->p1842_fac ?? 1.0);
        $p1843_fac = mysqli_real_escape_string($mysqli, $data->p1843_fac ?? 1.0);
        $p1844_fac = mysqli_real_escape_string($mysqli, $data->p1844_fac ?? 1.0);
        $p1846_fac = mysqli_real_escape_string($mysqli, $data->p1846_fac ?? 1.0);
        $p1847_fac = mysqli_real_escape_string($mysqli, $data->p1847_fac ?? 1.0);
        $p1848_fac = mysqli_real_escape_string($mysqli, $data->p1848_fac ?? 1.0);

        $stmt = "insert into `o_desc_in_b8`(`o_id`,`layout_id`,`window_id`,`st_id`,`col_amount_in_b8`,`p1800_fac`,`p1801_fac`,`p1802_fac`,`p1803_fac`,`p1804_fac`,`p1806_fac`,`p1807_fac`,`p1808_fac`,`p1821_fac`,`p1822_fac`,`p1823_fac`,`p1824_fac`,`p1826_fac`,`p1827_fac`,`p1828_fac`,`p1841_fac`,`p1842_fac`,`p1843_fac`,`p1844_fac`,`p1846_fac`,`p1847_fac`,`p1848_fac`,`col_price_in_b8`,`fac_cl_in_b8`,`o_price_in_b8`,`col_apus_in_b8`,`fac_prod_in_b8`,`o_apus_in_b8`,`col_labc_in_b8`,`fac_labc_in_b8`,`total_labcs_in_b8`) 
        values('$o_id','$layout_id','$window_id','','$b8_col_amount','$p1800_fac','$p1801_fac','$p1802_fac','$p1803_fac','$p1804_fac','$p1806_fac','$p1807_fac','$p1808_fac','$p1821_fac','$p1822_fac','$p1823_fac','$p1824_fac','$p1826_fac','$p1827_fac','$p1828_fac','$p1841_fac','$p1842_fac','$p1843_fac','$p1844_fac','$p1846_fac','$p1847_fac','$p1848_fac','$col_price_in_b8','$fac_cl_in_b8','$o_price_in_b8','$col_apus_in_b8','$fac_prod_in_b8','$o_apus_in_b8','$col_labc_in_b8','$fac_labc_in_b8','$total_labc_in_b8')";
        
        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_o_desc_ex_b5($o_id, $rs_id, $rmp_id, $r_tilt, $r_kneewall, $rop_id, $r_gutter_id, $e_length, $e_width, $wlc_id, $st_id, $ww_id, $gc_id, $gc_length, $gc_width, $gc_height, $reelings_id, $wc_id, $door_color, $door_texture, $dsp_id, $pbp_id, $basement, $levels_over_ground, $col_amount_ex_b5, $col_price_ex_b5, $fac_cl_ex_b5, $o_price_ex_b5, $col_apus_ex_b5, $fac_prod_ex_b5, $o_apus_ex_b5, $col_labc_ex_b5, $fac_labc_ex_b5, $total_labcs_ex_b5)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $rs_id = mysqli_real_escape_string($mysqli, $rs_id);
        $rmp_id = mysqli_real_escape_string($mysqli, $rmp_id);
        $r_tilt = mysqli_real_escape_string($mysqli, $r_tilt);
        $r_kneewall = mysqli_real_escape_string($mysqli, $r_kneewall);
        $rop_id = mysqli_real_escape_string($mysqli, $rop_id);
        $r_gutter_id = mysqli_real_escape_string($mysqli, $r_gutter_id);
        $e_length = mysqli_real_escape_string($mysqli, $e_length);
        $e_width = mysqli_real_escape_string($mysqli, $e_width);
        $wlc_id = mysqli_real_escape_string($mysqli, $wlc_id);
        $st_id = mysqli_real_escape_string($mysqli, $st_id);
        $ww_id = mysqli_real_escape_string($mysqli, $ww_id);
        $gc_id = mysqli_real_escape_string($mysqli, $gc_id);
        $gc_length = mysqli_real_escape_string($mysqli, $gc_length);
        $gc_width = mysqli_real_escape_string($mysqli, $gc_width);
        $gc_height = mysqli_real_escape_string($mysqli, $gc_height);
        $reelings_id = mysqli_real_escape_string($mysqli, $reelings_id);
        $wc_id = mysqli_real_escape_string($mysqli, $wc_id);
        $door_color = mysqli_real_escape_string($mysqli, $door_color);
        $door_texture = mysqli_real_escape_string($mysqli, $door_texture);
        $dsp_id = mysqli_real_escape_string($mysqli, $dsp_id);
        $pbp_id = mysqli_real_escape_string($mysqli, $pbp_id);
        $basement = mysqli_real_escape_string($mysqli, $basement);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $levels_over_ground);

        $col_price_ex_b5 = mysqli_real_escape_string($mysqli, $col_price_ex_b5);
        $fac_cl_ex_b5 = mysqli_real_escape_string($mysqli, $fac_cl_ex_b5);
        $o_price_ex_b5 = mysqli_real_escape_string($mysqli, $o_price_ex_b5);
        $col_apus_ex_b5 = mysqli_real_escape_string($mysqli, $col_apus_ex_b5);
        $fac_prod_ex_b5 = mysqli_real_escape_string($mysqli, $fac_prod_ex_b5);
        $o_apus_ex_b5 = mysqli_real_escape_string($mysqli, $o_apus_ex_b5);
        $col_labc_ex_b5 = mysqli_real_escape_string($mysqli, $col_labc_ex_b5);
        $fac_labc_ex_b5 = mysqli_real_escape_string($mysqli, $fac_labc_ex_b5);
        $total_labcs_ex_b5 = mysqli_real_escape_string($mysqli, $total_labcs_ex_b5);

        $stmt = "insert into `o_desc_ex_b5`(`o_id`,`rs_id`,`rmp_id`,`r_tilt`,`r_kneewall`,`rop_id`,`r_gutter_id`,`e_length`,`e_width`,`wlc_id`,`st_id`,`ww_id`,`gc_id`,`gc_length`,`gc_width`,`gc_height`,`reelings_id`,`wc_id`,`door_color`,`door_texture`,`dsp_id`,`pbp_id`,`basement`,`levels_over_ground`,`col_amount_ex_b5`,`col_price_ex_b5`,`fac_cl_ex_b5`,`o_price_ex_b5`,`col_apus_ex_b5`,`fac_prod_ex_b5`,`o_apus_ex_b5`,`col_labc_ex_b5`,`fac_labc_ex_b5`,`total_labcs_ex_b5`) values('$o_id','$rs_id','$rmp_id','$r_tilt','$r_kneewall','$rop_id','$r_gutter_id','$e_length','$e_width','$wlc_id','st_id','$ww_id','$gc_id','$gc_length','$gc_width','$gc_height','$reelings_id','$wc_id','$door_color','$door_texture','$dsp_id','$pbp_id','$basement','$levels_over_ground','$col_amount_ex_b5','$col_price_ex_b5','$fac_cl_ex_b5','$o_price_ex_b5','$col_apus_ex_b5','$fac_prod_ex_b5','$o_apus_ex_b5','$col_labc_ex_b5','$fac_labc_ex_b5','$total_labcs_ex_b5')";
        //$stmt=mysqli_prepare($mysqli,"insert into `o_desc_ex_b5`(`o_id`,`rs_id`,`rmp_id`,`r_tilt`,`r_kneewall`,`rop_id`,`r_gutter_id`,`e_length`,`e_width`,`wlc_id`,`ww_id`,`gc_id`,`gc_length`,`gc_width`,`gc_height`,`reelings_id`,`wc_id`,`door_texture`,`dsp_id`,`pbp_id`) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        //mysqli_stmt_bind_param($stmt,"issdsssssssdddssssss",$o_id,$rs_id,$rmp_id,$r_tilt,$r_kneewall,$rop_id,$r_gutter_id,$e_lenght,$e_width,$wlc_id,$ww_id,$gc_id,$gc_length,$gc_width,$gc_height,$reelings_id,$wc_id,$door_texture,$dsp_id,$pbp_id);

        //mysqli_stmt_execute($stmt);

        mysqli_query($mysqli, $stmt);

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function add_o_desc_ex_b52($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $rs_id = mysqli_real_escape_string($mysqli, $data->rs_id ?? '');
        $rmp_id = mysqli_real_escape_string($mysqli, $data->rmp_id ?? '');
        $r_tilt = mysqli_real_escape_string($mysqli, $data->r_tilt ?? '0.0');
        $r_kneewall = mysqli_real_escape_string($mysqli, $data->r_kneewall ?? '');
        $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id ?? '');
        $r_gutter_id = mysqli_real_escape_string($mysqli, $data->r_gutter_id ?? '');
        $e_length = mysqli_real_escape_string($mysqli, $data->e_length ?? '');
        $e_width = mysqli_real_escape_string($mysqli, $data->e_width ?? '');
        $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id ?? '');
        $st_id = mysqli_real_escape_string($mysqli, $data->st_id ?? '');
        $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id ?? '');
        $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id ?? '');
        $gc_length = mysqli_real_escape_string($mysqli, $data->gc_length ?? '0.0');
        $gc_width = mysqli_real_escape_string($mysqli, $data->gc_width ?? '0.0');
        $gc_height = mysqli_real_escape_string($mysqli, $data->gc_height ?? '2.5');
        $reelings_id = mysqli_real_escape_string($mysqli, $data->reelings_id ?? '');
        $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id ?? '');
        $door_color = mysqli_real_escape_string($mysqli, $data->door_color ?? '');
        $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture ?? '');
        $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id ?? '');
        $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id ?? '');
        $basement = mysqli_real_escape_string($mysqli, $data->basement ?? '0');
        $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground ?? '0');

        $p1561_fac = mysqli_real_escape_string($mysqli, $data->p1561_fac ?? 1.0);
        $p1563_fac = mysqli_real_escape_string($mysqli, $data->p1563_fac ?? 1.0);
        $p1566_fac = mysqli_real_escape_string($mysqli, $data->p1566_fac ?? 1.0);
        $p1581_fac = mysqli_real_escape_string($mysqli, $data->p1581_fac ?? 1.0);

        $col_amount_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b5 ?? 0.0);
        $col_price_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b5 ?? 0.0);
        $fac_cl_ex_b5 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b5 ?? 1.0);
        $o_price_ex_b5 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b5 ?? 0.0);
        $col_apus_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b5 ?? 0.0);
        $fac_prod_ex_b5 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b5 ?? 1.0);
        $o_apus_ex_b5 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b5 ?? 0.0);
        $col_labc_ex_b5 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b5 ?? 0.0);
        $fac_labc_ex_b5 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b5 ?? 1.0);
        $total_labcs_ex_b5 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b5 ?? 0.0);

        $stmt = "insert into `o_desc_ex_b5`(`o_id`,`rs_id`,`rmp_id`,`r_tilt`,`r_kneewall`,`rop_id`,`r_gutter_id`,`e_length`,`e_width`,`wlc_id`,`st_id`,`ww_id`,`gc_id`,`gc_length`,`gc_width`,`gc_height`,`reelings_id`,`wc_id`,`door_color`,`door_texture`,`dsp_id`,`pbp_id`,`basement`,`levels_over_ground`,`col_amount_ex_b5`,`p1561_fac`,`p1563_fac`,`p1566_fac`,`p1581_fac`,`col_price_ex_b5`,`fac_cl_ex_b5`,`o_price_ex_b5`,`col_apus_ex_b5`,`fac_prod_ex_b5`,`o_apus_ex_b5`,`col_labc_ex_b5`,`fac_labc_ex_b5`,`total_labcs_ex_b5`) 
        values('$o_id','$rs_id','$rmp_id','$r_tilt','$r_kneewall','$rop_id','$r_gutter_id','$e_length','$e_width','$wlc_id','$st_id','$ww_id','$gc_id','$gc_length','$gc_width','$gc_height','$reelings_id','$wc_id','$door_color','$door_texture','$dsp_id','$pbp_id','$basement','$levels_over_ground','$col_amount_ex_b5','$p1561_fac','$p1563_fac','$p1566_fac','$p1581_fac','$col_price_ex_b5','$fac_cl_ex_b5','$o_price_ex_b5','$col_apus_ex_b5','$fac_prod_ex_b5','$o_apus_ex_b5','$col_labc_ex_b5','$fac_labc_ex_b5','$total_labcs_ex_b5')";
        
        mysqli_query($mysqli, $stmt);

        mysqli_close($mysqli);
    }

    public function add_o_desc_ex_b1($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        // $rs_id = mysqli_real_escape_string($mysqli, $data->rs_id);
        // $rmp_id = mysqli_real_escape_string($mysqli, $data->rmp_id);
        // $r_tilt = mysqli_real_escape_string($mysqli, $data->r_tilt);
        // $r_kneewall = mysqli_real_escape_string($mysqli, $data->r_kneewall);
        // $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id);
        // $r_gutter_id = mysqli_real_escape_string($mysqli, $data->r_gutter_id);
        // $e_length = mysqli_real_escape_string($mysqli, $data->e_length);
        // $e_width = mysqli_real_escape_string($mysqli, $data->e_width);
        // $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id);
        // $st_id = mysqli_real_escape_string($mysqli, $data->st_id);
        // $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id);
        // $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id);
        // $gc_length = mysqli_real_escape_string($mysqli, $data->gc_length);
        // $gc_width = mysqli_real_escape_string($mysqli, $data->gc_width);
        // $gc_height = mysqli_real_escape_string($mysqli, $data->gc_height);
        // $reelings_id = mysqli_real_escape_string($mysqli, $data->reelings_id);
        // $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id);
        // $door_color = mysqli_real_escape_string($mysqli, $data->door_color);
        // $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture);
        // $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id);
        // $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id);
        // $basement = mysqli_real_escape_string($mysqli, $data->basement);
        // $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground);

        $p1168_fac = mysqli_real_escape_string($mysqli, $data->p1168_fac ?? 1.0);
        $p1163_fac = mysqli_real_escape_string($mysqli, $data->p1163_fac ?? 1.0);
        $p1166_fac = mysqli_real_escape_string($mysqli, $data->p1166_fac ?? 1.0);
        $p1181_fac = mysqli_real_escape_string($mysqli, $data->p1181_fac ?? 1.0);
        $p116m_fac = mysqli_real_escape_string($mysqli, $data->p116m_fac ?? 1.0);
        $p116b_fac = mysqli_real_escape_string($mysqli, $data->p116b_fac ?? 1.0);
        $p116t_fac = mysqli_real_escape_string($mysqli, $data->p116t_fac ?? 1.0);
        $p118s_fac = mysqli_real_escape_string($mysqli, $data->p118s_fac ?? 1.0);

        $col_amount_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b1 ?? 0.0);
        $col_price_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b1 ?? 0.0);
        $fac_cl_ex_b1 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b1 ?? 1.0);
        $o_price_ex_b1 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b1 ?? 0.0);
        $col_apus_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b1 ?? 0.0);
        $fac_prod_ex_b1 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b1 ?? 1.0);
        $o_apus_ex_b1 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b1 ?? 0.0);
        $col_labc_ex_b1 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b1 ?? 0.0);
        $fac_labc_ex_b1 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b1 ?? 1.0);
        $total_labcs_ex_b1 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b1 ?? 0.0);

        $stmt = "insert into `o_desc_ex_b1`(`o_id`,`rs_id`,`rmp_id`,`r_tilt`,`r_kneewall`,`rop_id`,`r_gutter_id`,`e_length`,`e_width`,`wlc_id`,`st_id`,`ww_id`,`socket`,`gc_id`,`gc_length`,`gc_width`,`gc_height`,`reelings_id`,`wc_id`,`door_color`,`door_texture`,`dsp_id`,`pbp_id`,`basement`,`levels_over_ground`,`col_amount_ex_b1`,`p1168_fac`,`p1163_fac`,`p1166_fac`,`p1181_fac`,`p116b_fac`,`p116m_fac`,`p116t_fac`,`p118s_fac`,`col_price_ex_b1`,`fac_cl_ex_b1`,`o_price_ex_b1`,`col_apus_ex_b1`,`fac_prod_ex_b1`,`o_apus_ex_b1`,`col_labc_ex_b1`,`fac_labc_ex_b1`,`total_labcs_ex_b1`) 
        values('$o_id','','','0.0','','','','','','','','','','','0.0','0.0','0.0','','','','','','','0','0','$col_amount_ex_b1','$p1168_fac','$p1163_fac','$p1166_fac','$p1181_fac','$p116b_fac','$p116m_fac','$p116t_fac','$p118s_fac','$col_price_ex_b1','$fac_cl_ex_b1','$o_price_ex_b1','$col_apus_ex_b1','$fac_prod_ex_b1','$o_apus_ex_b1','$col_labc_ex_b1','$fac_labc_ex_b1','$total_labcs_ex_b1')";
        
        mysqli_query($mysqli, $stmt);

        mysqli_close($mysqli);
    }

    public function add_o_desc_g_b1($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        // $rs_id = mysqli_real_escape_string($mysqli, $data->rs_id);
        // $rmp_id = mysqli_real_escape_string($mysqli, $data->rmp_id);
        // $r_tilt = mysqli_real_escape_string($mysqli, $data->r_tilt);
        // $r_kneewall = mysqli_real_escape_string($mysqli, $data->r_kneewall);
        // $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id);
        // $r_gutter_id = mysqli_real_escape_string($mysqli, $data->r_gutter_id);
        // $e_length = mysqli_real_escape_string($mysqli, $data->e_length);
        // $e_width = mysqli_real_escape_string($mysqli, $data->e_width);
        // $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id);
        // $st_id = mysqli_real_escape_string($mysqli, $data->st_id);
        // $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id);
        // $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id);
        // $gc_length = mysqli_real_escape_string($mysqli, $data->gc_length);
        // $gc_width = mysqli_real_escape_string($mysqli, $data->gc_width);
        // $gc_height = mysqli_real_escape_string($mysqli, $data->gc_height);
        // $reelings_id = mysqli_real_escape_string($mysqli, $data->reelings_id);
        // $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id);
        // $door_color = mysqli_real_escape_string($mysqli, $data->door_color);
        // $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture);
        // $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id);
        // $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id);
        // $basement = mysqli_real_escape_string($mysqli, $data->basement);
        // $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground);

        $p11g8_fac = mysqli_real_escape_string($mysqli, $data->p11g8_fac);
        $p11g3_fac = mysqli_real_escape_string($mysqli, $data->p11g3_fac);
        $p11g6_fac = mysqli_real_escape_string($mysqli, $data->p11g6_fac);
        $p11gm_fac = mysqli_real_escape_string($mysqli, $data->p11gm_fac);
        $p11gb_fac = mysqli_real_escape_string($mysqli, $data->p11gb_fac);
        $p11gt_fac = mysqli_real_escape_string($mysqli, $data->p11gt_fac);
        $p11gs_fac = mysqli_real_escape_string($mysqli, $data->p11gs_fac);
        
        $col_amount_g_b1 = mysqli_real_escape_string($mysqli, $data->col_amount_g_b1);
        $col_price_g_b1 = mysqli_real_escape_string($mysqli, $data->col_price_g_b1);
        $fac_cl_g_b1 = mysqli_real_escape_string($mysqli, $data->fac_cl_g_b1);
        $o_price_g_b1 = mysqli_real_escape_string($mysqli, $data->o_price_g_b1);
        $col_apus_g_b1 = mysqli_real_escape_string($mysqli, $data->col_apus_g_b1);
        $fac_prod_g_b1 = mysqli_real_escape_string($mysqli, $data->fac_prod_g_b1);
        $o_apus_g_b1 = mysqli_real_escape_string($mysqli, $data->o_apus_g_b1);
        $col_labc_g_b1 = mysqli_real_escape_string($mysqli, $data->col_labc_g_b1);
        $fac_labc_g_b1 = mysqli_real_escape_string($mysqli, $data->fac_labc_g_b1);
        $total_labcs_g_b1 = mysqli_real_escape_string($mysqli, $data->total_labcs_g_b1);

        $stmt = "insert into `o_desc_g_b1`(`o_id`,`col_amount_g_b1`,`p11g8_fac`,`p11g3_fac`,`p11g6_fac`,`p11gb_fac`,`p11gm_fac`,`p11gt_fac`,`p11gs_fac`,`col_price_g_b1`,`fac_cl_g_b1`,`o_price_g_b1`,`col_apus_g_b1`,`fac_prod_g_b1`,`o_apus_g_b1`,`col_labc_g_b1`,`fac_labc_g_b1`,`total_labcs_g_b1`) 
        values('$o_id','$col_amount_g_b1','$p11g8_fac','$p11g3_fac','$p11g6_fac','$p11gb_fac','$p11gm_fac','$p11gt_fac','$p11gs_fac','$col_price_g_b1','$fac_cl_g_b1','$o_price_g_b1','$col_apus_g_b1','$fac_prod_g_b1','$o_apus_g_b1','$col_labc_g_b1','$fac_labc_g_b1','$total_labcs_g_b1')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        mysqli_close($mysqli);
    }

    public function add_o_desc_ex_b6($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        // $rs_id = mysqli_real_escape_string($mysqli, $data->rs_id);
        // $rmp_id = mysqli_real_escape_string($mysqli, $data->rmp_id);
        // $r_tilt = mysqli_real_escape_string($mysqli, $data->r_tilt);
        // $r_kneewall = mysqli_real_escape_string($mysqli, $data->r_kneewall);
        // $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id);
        // $r_gutter_id = mysqli_real_escape_string($mysqli, $data->r_gutter_id);
        // $e_length = mysqli_real_escape_string($mysqli, $data->e_length);
        // $e_width = mysqli_real_escape_string($mysqli, $data->e_width);
        // $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id);
        // $st_id = mysqli_real_escape_string($mysqli, $data->st_id);
        // $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id);
        // $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id);
        // $gc_length = mysqli_real_escape_string($mysqli, $data->gc_length);
        // $gc_width = mysqli_real_escape_string($mysqli, $data->gc_width);
        // $gc_height = mysqli_real_escape_string($mysqli, $data->gc_height);
        // $reelings_id = mysqli_real_escape_string($mysqli, $data->reelings_id);
        // $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id);
        // $door_color = mysqli_real_escape_string($mysqli, $data->door_color);
        // $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture);
        // $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id);
        // $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id);
        // $basement = mysqli_real_escape_string($mysqli, $data->basement);
        // $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground);

        $p1661_fac = mysqli_real_escape_string($mysqli, $data->p1661_fac ?? 1.0);
        $p1663_fac = mysqli_real_escape_string($mysqli, $data->p1663_fac ?? 1.0);
        $p1666_fac = mysqli_real_escape_string($mysqli, $data->p1666_fac ?? 1.0);
        $p1681_fac = mysqli_real_escape_string($mysqli, $data->p1681_fac ?? 1.0);
        $p166p_fac = mysqli_real_escape_string($mysqli, $data->p166p_fac ?? 1.0);

        $col_amount_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b6);
        $col_price_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b6 ?? 0.0);
        $fac_cl_ex_b6 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b6 ?? 1.0);
        $o_price_ex_b6 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b6 ?? 0.0);
        $col_apus_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b6 ?? 0.0);
        $fac_prod_ex_b6 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b6 ?? 1.0);
        $o_apus_ex_b6 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b6 ?? 0.0);
        $col_labc_ex_b6 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b6 ?? 0.0);
        $fac_labc_ex_b6 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b6 ?? 1.0);
        $total_labcs_ex_b6 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b6 ?? 0.0);

        $stmt = "insert into `o_desc_ex_b6`(`o_id`,`col_amount_ex_b6`,`p1661_fac`,`p1663_fac`,`p1666_fac`,`p1681_fac`,`p166p_fac`,`col_price_ex_b6`,`fac_cl_ex_b6`,`o_price_ex_b6`,`col_apus_ex_b6`,`fac_prod_ex_b6`,`o_apus_ex_b6`,`col_labc_ex_b6`,`fac_labc_ex_b6`,`total_labcs_ex_b6`) 
        values('$o_id','$col_amount_ex_b6','$p1661_fac','$p1663_fac','$p1666_fac','$p1681_fac','$p166p_fac','$col_price_ex_b6','$fac_cl_ex_b6','$o_price_ex_b6','$col_apus_ex_b6','$fac_prod_ex_b6','$o_apus_ex_b6','$col_labc_ex_b6','$fac_labc_ex_b6','$total_labcs_ex_b6')";       

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        
        mysqli_close($mysqli);
    }

    public function add_o_desc_ex_b7($o_id, $rs_id, $rmp_id, $r_tilt, $r_kneewall, $rop_id, $r_gutter_id, $e_length, $e_width, $wlc_id, $st_id, $ww_id, $gc_id, $gc_length, $gc_width, $gc_height, $reelings_id, $wc_id, $door_color, $door_texture, $dsp_id, $pbp_id, $basement, $levels_over_ground, $col_amount_ex_b5, $col_price_ex_b5, $fac_cl_ex_b5, $o_price_ex_b5, $col_apus_ex_b5, $fac_prod_ex_b5, $o_apus_ex_b5, $col_labc_ex_b5, $fac_labc_ex_b5, $total_labcs_ex_b5)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        $rs_id = mysqli_real_escape_string($mysqli, $rs_id);
        $rmp_id = mysqli_real_escape_string($mysqli, $rmp_id);
        $r_tilt = mysqli_real_escape_string($mysqli, $r_tilt);
        $r_kneewall = mysqli_real_escape_string($mysqli, $r_kneewall);
        $rop_id = mysqli_real_escape_string($mysqli, $rop_id);
        $r_gutter_id = mysqli_real_escape_string($mysqli, $r_gutter_id);
        $e_length = mysqli_real_escape_string($mysqli, $e_length);
        $e_width = mysqli_real_escape_string($mysqli, $e_width);
        $wlc_id = mysqli_real_escape_string($mysqli, $wlc_id);
        $st_id = mysqli_real_escape_string($mysqli, $st_id);
        $ww_id = mysqli_real_escape_string($mysqli, $ww_id);
        $gc_id = mysqli_real_escape_string($mysqli, $gc_id);
        $gc_length = mysqli_real_escape_string($mysqli, $gc_length);
        $gc_width = mysqli_real_escape_string($mysqli, $gc_width);
        $gc_height = mysqli_real_escape_string($mysqli, $gc_height);
        $reelings_id = mysqli_real_escape_string($mysqli, $reelings_id);
        $wc_id = mysqli_real_escape_string($mysqli, $wc_id);
        $door_color = mysqli_real_escape_string($mysqli, $door_color);
        $door_texture = mysqli_real_escape_string($mysqli, $door_texture);
        $dsp_id = mysqli_real_escape_string($mysqli, $dsp_id);
        $pbp_id = mysqli_real_escape_string($mysqli, $pbp_id);
        $basement = mysqli_real_escape_string($mysqli, $basement);
        $levels_over_ground = mysqli_real_escape_string($mysqli, $levels_over_ground);

        $col_price_ex_b5 = mysqli_real_escape_string($mysqli, $col_price_ex_b5);
        $fac_cl_ex_b5 = mysqli_real_escape_string($mysqli, $fac_cl_ex_b5);
        $o_price_ex_b5 = mysqli_real_escape_string($mysqli, $o_price_ex_b5);
        $col_apus_ex_b5 = mysqli_real_escape_string($mysqli, $col_apus_ex_b5);
        $fac_prod_ex_b5 = mysqli_real_escape_string($mysqli, $fac_prod_ex_b5);
        $o_apus_ex_b5 = mysqli_real_escape_string($mysqli, $o_apus_ex_b5);
        $col_labc_ex_b5 = mysqli_real_escape_string($mysqli, $col_labc_ex_b5);
        $fac_labc_ex_b5 = mysqli_real_escape_string($mysqli, $fac_labc_ex_b5);
        $total_labcs_ex_b5 = mysqli_real_escape_string($mysqli, $total_labcs_ex_b5);

        $stmt = "insert into `o_desc_ex_b7`(`o_id`,`rs_id`,`rmp_id`,`r_tilt`,`r_kneewall`,`rop_id`,`r_gutter_id`,`e_length`,`e_width`,`wlc_id`,`st_id`,`ww_id`,`gc_id`,`gc_length`,`gc_width`,`gc_height`,`reelings_id`,`wc_id`,`door_color`,`door_texture`,`dsp_id`,`pbp_id`,`basement`,`levels_over_ground`,`col_amount_ex_b7`,`col_price_ex_b7`,`fac_cl_ex_b7`,`o_price_ex_b7`,`col_apus_ex_b7`,`fac_prod_ex_b7`,`o_apus_ex_b7`,`col_labc_ex_b7`,`fac_labc_ex_b7`,`total_labcs_ex_b7`) values('$o_id','$rs_id','$rmp_id','$r_tilt','$r_kneewall','$rop_id','$r_gutter_id','$e_length','$e_width','$wlc_id','$st_id','$ww_id','$gc_id','$gc_length','$gc_width','$gc_height','$reelings_id','$wc_id','$door_color','$door_texture','$dsp_id','$pbp_id','$basement','$levels_over_ground','$col_amount_ex_b5','$col_price_ex_b5','$fac_cl_ex_b5','$o_price_ex_b5','$col_apus_ex_b5','$fac_prod_ex_b5','$o_apus_ex_b5','$col_labc_ex_b5','$fac_labc_ex_b5','$total_labcs_ex_b5')";
        //$stmt=mysqli_prepare($mysqli,"insert into `o_desc_ex_b5`(`o_id`,`rs_id`,`rmp_id`,`r_tilt`,`r_kneewall`,`rop_id`,`r_gutter_id`,`e_length`,`e_width`,`wlc_id`,`ww_id`,`gc_id`,`gc_length`,`gc_width`,`gc_height`,`reelings_id`,`wc_id`,`door_texture`,`dsp_id`,`pbp_id`) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        //mysqli_stmt_bind_param($stmt,"issdsssssssdddssssss",$o_id,$rs_id,$rmp_id,$r_tilt,$r_kneewall,$rop_id,$r_gutter_id,$e_lenght,$e_width,$wlc_id,$ww_id,$gc_id,$gc_length,$gc_width,$gc_height,$reelings_id,$wc_id,$door_texture,$dsp_id,$pbp_id);

        //mysqli_stmt_execute($stmt);

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        //mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function add_o_desc_ex_b72($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        // $rs_id = mysqli_real_escape_string($mysqli, $data->rs_id);
        // $rmp_id = mysqli_real_escape_string($mysqli, $data->rmp_id);
        // $r_tilt = mysqli_real_escape_string($mysqli, $data->r_tilt);
        // $r_kneewall = mysqli_real_escape_string($mysqli, $data->r_kneewall);
        // $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id);
        // $r_gutter_id = mysqli_real_escape_string($mysqli, $data->r_gutter_id);
        // $e_length = mysqli_real_escape_string($mysqli, $data->e_length);
        // $e_width = mysqli_real_escape_string($mysqli, $data->e_width);
        // $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id);
        // $st_id = mysqli_real_escape_string($mysqli, $data->st_id);
        // $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id);
        // $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id);
        // $gc_length = mysqli_real_escape_string($mysqli, $data->gc_length);
        // $gc_width = mysqli_real_escape_string($mysqli, $data->gc_width);
        // $gc_height = mysqli_real_escape_string($mysqli, $data->gc_height);
        // $reelings_id = mysqli_real_escape_string($mysqli, $data->reelings_id);
        // $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id);
        // $door_color = mysqli_real_escape_string($mysqli, $data->door_color);
        // $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture);
        // $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id);
        // $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id);
        // $basement = mysqli_real_escape_string($mysqli, $data->basement);
        // $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground);

        $p1761_fac = mysqli_real_escape_string($mysqli, $data->p1761_fac ?? 1.0);
        $p1762_fac = mysqli_real_escape_string($mysqli, $data->p1762_fac ?? 1.0);
        $p1763_fac = mysqli_real_escape_string($mysqli, $data->p1763_fac ?? 1.0);
        $p1766_fac = mysqli_real_escape_string($mysqli, $data->p1766_fac ?? 1.0);
        $p1781_fac = mysqli_real_escape_string($mysqli, $data->p1781_fac ?? 1.0);

        $col_amount_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b7 ?? 0.0);
        $col_price_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b7 ?? 0.0);
        $fac_cl_ex_b7 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b7 ?? 1.0);
        $o_price_ex_b7 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b7 ?? 0.0);
        $col_apus_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b7 ?? 0.0);
        $fac_prod_ex_b7 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b7 ?? 1.0);
        $o_apus_ex_b7 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b7 ?? 0.0);
        $col_labc_ex_b7 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b7 ?? 0.0);
        $fac_labc_ex_b7 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b7 ?? 1.0);
        $total_labcs_ex_b7 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b7 ?? 0.0);

        $stmt = "insert into `o_desc_ex_b7`(`o_id`,`col_amount_ex_b7`,`p1761_fac`,`p1762_fac`,`p1763_fac`,`p1766_fac`,`p1781_fac`,`col_price_ex_b7`,`fac_cl_ex_b7`,`o_price_ex_b7`,`col_apus_ex_b7`,`fac_prod_ex_b7`,`o_apus_ex_b7`,`col_labc_ex_b7`,`fac_labc_ex_b7`,`total_labcs_ex_b7`) 
        values('$o_id','$col_amount_ex_b7','$p1761_fac','$p1762_fac','$p1763_fac','$p1766_fac','$p1781_fac','$col_price_ex_b7','$fac_cl_ex_b7','$o_price_ex_b7','$col_apus_ex_b7','$fac_prod_ex_b7','$o_apus_ex_b7','$col_labc_ex_b7','$fac_labc_ex_b7','$total_labcs_ex_b7')";
        

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        
        mysqli_close($mysqli);
    }

    public function add_o_desc_ex_b8($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        // $rs_id = mysqli_real_escape_string($mysqli, $data->rs_id);
        // $rmp_id = mysqli_real_escape_string($mysqli, $data->rmp_id);
        // $r_tilt = mysqli_real_escape_string($mysqli, $data->r_tilt);
        // $r_kneewall = mysqli_real_escape_string($mysqli, $data->r_kneewall);
        // $rop_id = mysqli_real_escape_string($mysqli, $data->rop_id);
        // $r_gutter_id = mysqli_real_escape_string($mysqli, $data->r_gutter_id);
        // $e_length = mysqli_real_escape_string($mysqli, $data->e_length);
        // $e_width = mysqli_real_escape_string($mysqli, $data->e_width);
        // $wlc_id = mysqli_real_escape_string($mysqli, $data->wlc_id);
        // $st_id = mysqli_real_escape_string($mysqli, $data->st_id);
        // $ww_id = mysqli_real_escape_string($mysqli, $data->ww_id);
        // $gc_id = mysqli_real_escape_string($mysqli, $data->gc_id);
        // $gc_length = mysqli_real_escape_string($mysqli, $data->gc_length);
        // $gc_width = mysqli_real_escape_string($mysqli, $data->gc_width);
        // $gc_height = mysqli_real_escape_string($mysqli, $data->gc_height);
        // $reelings_id = mysqli_real_escape_string($mysqli, $data->reelings_id);
        // $wc_id = mysqli_real_escape_string($mysqli, $data->wc_id);
        // $door_color = mysqli_real_escape_string($mysqli, $data->door_color);
        // $door_texture = mysqli_real_escape_string($mysqli, $data->door_texture);
        // $dsp_id = mysqli_real_escape_string($mysqli, $data->dsp_id);
        // $pbp_id = mysqli_real_escape_string($mysqli, $data->pbp_id);
        // $basement = mysqli_real_escape_string($mysqli, $data->basement);
        // $levels_over_ground = mysqli_real_escape_string($mysqli, $data->levels_over_ground);

        $p1861_fac = mysqli_real_escape_string($mysqli, $data->p1861_fac ?? 1.0);
        $p1863_fac = mysqli_real_escape_string($mysqli, $data->p1863_fac ?? 1.0);
        $p1866_fac = mysqli_real_escape_string($mysqli, $data->p1866_fac ?? 1.0);
        $p1881_fac = mysqli_real_escape_string($mysqli, $data->p1881_fac ?? 1.0);

        $col_amount_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_amount_ex_b8 ?? 0.0);
        $col_price_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_price_ex_b8 ?? 0.0);
        $fac_cl_ex_b8 = mysqli_real_escape_string($mysqli, $data->fac_cl_ex_b8 ?? 1.0);
        $o_price_ex_b8 = mysqli_real_escape_string($mysqli, $data->o_price_ex_b8 ?? 0.0);
        $col_apus_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_apus_ex_b8 ?? 0.0);
        $fac_prod_ex_b8 = mysqli_real_escape_string($mysqli, $data->fac_prod_ex_b8 ?? 1.0);
        $o_apus_ex_b8 = mysqli_real_escape_string($mysqli, $data->o_apus_ex_b8 ?? 0.0);
        $col_labc_ex_b8 = mysqli_real_escape_string($mysqli, $data->col_labc_ex_b8 ?? 0.0);
        $fac_labc_ex_b8 = mysqli_real_escape_string($mysqli, $data->fac_labc_ex_b8 ?? 1.0);
        $total_labcs_ex_b8 = mysqli_real_escape_string($mysqli, $data->total_labcs_ex_b8 ?? 0.0);

        $stmt = "insert into `o_desc_ex_b8`(`o_id`,`col_amount_ex_b8`,`p1861_fac`,`p1863_fac`,`p1866_fac`,`p1881_fac`,`col_price_ex_b8`,`fac_cl_ex_b8`,`o_price_ex_b8`,`col_apus_ex_b8`,`fac_prod_ex_b8`,`o_apus_ex_b8`,`col_labc_ex_b8`,`fac_labc_ex_b8`,`total_labcs_ex_b8`) 
        values('$o_id','$col_amount_ex_b8','$p1861_fac','$p1863_fac','$p1866_fac','$p1881_fac','$col_price_ex_b8','$fac_cl_ex_b8','$o_price_ex_b8','$col_apus_ex_b8','$fac_prod_ex_b8','$o_apus_ex_b8','$col_labc_ex_b8','$fac_labc_ex_b8','$total_labcs_ex_b8')";

        mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
        mysqli_close($mysqli);
    }

    public function reset_client_account_password($password, $recovery_string)
    {
        if (!empty($recovery_string)) {
            $mysqli = $this->dbconnect();
            $password = mysqli_real_escape_string($mysqli, $password);
            $recovery_string = mysqli_real_escape_string($mysqli, $recovery_string);
            $password = sha1($password);

            $stmt = mysqli_prepare($mysqli, "update `u_clients` set `password`=? ,`account_recovery_string`='' where `account_recovery_string`=?");
            mysqli_stmt_bind_param($stmt, "ss", $password, $recovery_string);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
        }
    }

    public function check_expired_recovery_string($recovery_string)
    {

        $mysqli = $this->dbconnect();

        $recovery_string = mysqli_real_escape_string($mysqli, $recovery_string);

        $sql = "SELECT *  FROM `u_clients` WHERE `account_recovery_string` like '$recovery_string'";

        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;

    }

    function add_client_account_recovery_string($email, $recovery_string)
    {
        $mysqli = $this->dbconnect();
        $email = mysqli_real_escape_string($mysqli, $email);

        $stmt = mysqli_prepare($mysqli, "update `u_clients` set `account_recovery_string`=? where `email`=?");
        mysqli_stmt_bind_param($stmt, "ss", $recovery_string, $email);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    function verify_client_recovery_string($recovery_string)
    {
        $mysqli = $this->dbconnect();
        $recovery_string = mysqli_real_escape_string($mysqli, $recovery_string);

        $stmt = mysqli_prepare($mysqli, "select * from `u_clients` where `account_recovery_string`=?");
        mysqli_stmt_bind_param($stmt, "s", $recovery_string);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    //security

    public function xss_fix($data)
    {
        // Fix &entity\n;
        $data = htmlspecialchars($data, ENT_QUOTES);
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }


    /* SHARES FUNCTIONS*/

    public function get_all_partners()
    {

        $mysqli = $this->dbconnect();
        $query = "SELECT * FROM `u_clients` where `partner_since` is not null and `c_status`='active' order by `email` ";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;

    }

    public function get_user_by_email($email)
    {
        $mysqli = $this->dbconnect();
        $email = mysqli_real_escape_string($mysqli, $email);

        $stmt = "select * from `u_clients` where `email`='$email'";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_user_by_id($id)
    {
        $mysqli = $this->dbconnect();
        $email = mysqli_real_escape_string($mysqli, $id);

        $stmt = "select * from `u_clients` where `client_ID`='$id'";

        $result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_orders_by_daterange($from, $to)
    {
        $mysqli = $this->dbconnect();
        $plot_id = mysqli_real_escape_string($mysqli, $plot_id);

        $stmt = mysqli_prepare($mysqli, "select order_ID, o_date, order_name, u_client_ID, o_price, o_special_agreement_price, vat_percent, vat_amount, vat_a_id, brut_price from `orders` WHERE o_date BETWEEN ? AND ? ORDER BY o_date ASC");

        mysqli_stmt_bind_param($stmt, "ss", $from, $to);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_orders_group($g_id)
    {
        $mysqli = $this->dbconnect();
        $g_id = mysqli_real_escape_string($mysqli, $g_id);

        $stmt = mysqli_prepare($mysqli, "select order_ID as o_id from `orders` WHERE group_id=?");

        mysqli_stmt_bind_param($stmt, "i", $g_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_group_by_id($g_id)
    {
        $mysqli = $this->dbconnect();
        $g_id = mysqli_real_escape_string($mysqli, $g_id);

        $stmt = mysqli_prepare($mysqli, "select * from `groups` WHERE g_id=?");

        mysqli_stmt_bind_param($stmt, "i", $g_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_all_room_kinds_by_language($lang_id)
    {

        $mysqli = $this->dbconnect();
        $query = "select * from `adminhdd_domenia1`.`x-texts` WHERE `text_id` LIKE 'rm_%' AND lang_id = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $lang_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_furniture_types_by_language($lang_id)
    {

        $mysqli = $this->dbconnect();
        $query = "select * from `adminhdd_domenia1`.`x-texts` WHERE `text_id` LIKE 'ft_%' AND lang_id = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $lang_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_all_ft_objects()
    {
        $mysqli = $this->dbdomenia3n();
        $query = "select * from `lt_1_objects` JOIN `fto_producers` on `fto_producer` = `ftop_id` JOIN `fto_categories` on `fto_category` = `ftoc_id` JOIN `ft_traders` on `ft_trader` = `ftt_id` order by `lt_1_objects`.`fto_id` desc";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_ft_object($fto_id)
    {
        $mysqli = $this->dbdomenia3n();
        $fto_id = mysqli_real_escape_string($mysqli, $fto_id);

        $query = "select * from `lt_1_objects` where `fto_id`=?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $fto_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
        return $row;
    }

    public function get_all_ft_objects_by_category($fto_category)
    {
        $mysqli = $this->dbdomenia3n();
        $fto_category = mysqli_real_escape_string($mysqli, $fto_category);

        $query = "select * from `lt_1_objects` where `fto_category`=?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $fto_category);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
        return $rows;
    }

    public function get_all_ft_traders()
    {
        $mysqli = $this->dbdomenia3n();
        $query = "select * from `adminhdd_domenia3n`.`ft_traders` JOIN `adminhdd_domenia1`.`u_clients_main` on `ft_traders`.`mc_id` = `u_clients_main`.`mc_id` order by `clientname`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_ft_trader($ftt_id)
    {
        $mysqli = $this->dbdomenia3n();
        $ftt_id=mysqli_real_escape_string($mysqli, $ftt_id);

        $query = "select * from `adminhdd_leonarda`.`ft_traders` JOIN `adminhdd_domenia1`.`u_clients_main` on `ft_traders`.`mc_id` = `u_clients_main`.`mc_id` where `ft_traders`.`ftt_id`=? order by `clientname`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $ftt_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function get_all_fto_categories()
    {
        $mysqli = $this->dbdomenia3n();
        $query = "select * from `fto_categories` JOIN `adminhdd_domenia1`.`x-texts` on `text_id`=CONCAT('ftoc_', `ftoc_id`) WHERE `lang_id`=1 order by `adminhdd_domenia1`.`x-texts`.`text`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_fto_category($ftoc_id)
    {
        $mysqli = $this->dbdomenia3n();

        $ftoc_id=mysqli_real_escape_string($mysqli, $ftoc_id);

        $query = "select * from `fto_categories` JOIN `adminhdd_domenia1`.`x-texts` on `text_id`=CONCAT('ftoc_', `ftoc_id`) where `x-texts`.`lang_id`=1 and `fto_categories`.`ftoc_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $ftoc_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_lt_rooms()
    {
        $mysqli = $this->dbdomenia3n();
        
        $query = "select * from `lt_2_sets_4_rooms`";
        
        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
        return $rows;
    }

    public function get_all_room_names($room_name)
    {
        $mysqli = $this->dbdomenia3n();
        
        $room_name=mysqli_real_escape_string($mysqli, $room_name);
        $param="%".$room_name."%";

        $query = "select * from `lt_2_sets_4_rooms` where `ltr_name` like ?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $param);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
        return $rows;
    }

    public function get_lt_2_sets_4_rooms($ltr_id)
    {
        $mysqli = $this->dbdomenia3n();
        
        $ltr_id=mysqli_real_escape_string($mysqli, $ltr_id);

        $query = "select * from `lt_2_sets_4_rooms` where `ltr_id`=?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $ltr_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
        return $row;
    }

    public function get_translated_ftoc($ftoc_id, $lang_id)
    {
        $mysqli = $this->dbconnect();
        $query = "select * from `x-texts` WHERE `text_id`='ftoc_$ftoc_id' AND `lang_id` = '$lang_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row['text'];
    }

    public function add_ftoc($name, $description, $translation)
    {

        $mysqli = $this->dbdomenia3n();

        $query = "INSERT INTO `fto_categories` (`ftoc_description`) VALUES ('$description')";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);

        $last_id = mysqli_insert_id($mysqli);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        $this->insert_ftoc_translations($last_id, $name, $translation);

    }

    public function insert_ftoc_translations($id, $name, $translation)
    {
        $mysqli = $this->dbconnect();

        $query = "INSERT INTO `x-texts` (`text_id`, `lang_id`, `text`, `lang_name`, `description_engl`) VALUES ('ftoc_$id', 1, '$name', 'English-US', '$name')";

        if ($translation != '') {
            $query .= ", ('ftoc_$id', 49, '$translation', 'German', '$name');";
        }

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }


    public function get_all_fto_producers()
    {
        $mysqli = $this->dbdomenia3n();
        $query = "select * from `fto_producers` order by `ftop_name`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_fto_producer($ftop_id)
    {
        $mysqli = $this->dbdomenia3n();
        $ftop_id=mysqli_real_escape_string($mysqli, $ftop_id);

        $query = "select * from `fto_producers` where `ftop_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $ftop_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function add_ft_object($data)
    {
        $data = json_decode($data, true);

        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $producer = $data['producer'];
        $category = $data['category'];
        $trader = $data['trader'];
        $ftto_page = $data['ftto_page'];
        $f_source = $data['f_source'];
        $fs_date = $data['fs_date'];
        $fs_price = $data['fs_price'];
        $fs_remarks = $data['fs_remarks'];
        $fs_thumbnail = $data['fs_thumbnail'];
        $owner = $data['owner'];
        $creator = $data['creator'];

        $mysqli = $this->dbdomenia3n();

        $query = "INSERT INTO `lt_1_objects` (`fto_name`, `fto_description`, `fto_price`, `fto_category`, `fto_producer`, `ft_trader`,`ftto_page`,`f_source`,`fs_date`,`fs_price`,`fs_remarks`,`fs_thumbnail`,`owner`,`creator`)VALUES ('$name', '$description', '$price', '$category', '$producer', '$trader','$ftto_page','$f_source','$fs_date','$fs_price','$fs_remarks','$fs_thumbnail','$owner','$creator')";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_ft_object($fto_id)
    {
        $mysqli = $this->dbdomenia3n();

        $fto_id = mysqli_real_escape_string($mysqli, $fto_id);

        $query = "delete from `lt_1_objects` where `fto_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $fto_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_furniture_set_4_units($ft_3_id)
    {
        $mysqli = $this->dbdomenia3n();

        $ft_3_id = mysqli_real_escape_string($mysqli, $ft_3_id);

        $query = "delete from `lt_3_sets_4_units` where `ft_3_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $ft_3_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_lt_room($ltr_id)
    {
        $mysqli = $this->dbdomenia3n();

        $ltr_id = mysqli_real_escape_string($mysqli, $ltr_id);

        $query = "delete from `lt_2_sets_4_rooms` where `ltr_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $ltr_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function edit_ft_object($data)
    {
        $data = json_decode($data, true);

        $id = $data['id'];
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $producer = $data['producer'];
        $category = $data['category'];
        $trader = $data['trader'];
        $ftto_page = $data['ftto_page'];
        $f_source = $data['f_source'];
        $fs_date = $data['fs_date'];
        $fs_price = $data['fs_price'];
        $fs_remarks = $data['fs_remarks'];
        $fs_thumbnail = $data['fs_thumbnail'];
        $owner = $data['owner'];
        $creator = $data['creator'];

        $mysqli = $this->dbdomenia3n();
        $query = "UPDATE `lt_1_objects` SET `fto_name` = '$name' , `fto_description` = '$description', `fto_price` = '$price', `fto_category` = '$category', `fto_producer` = '$producer', `ft_trader` = '$trader',`ftto_page`='$ftto_page',`f_source`='$f_source',`fs_date`='$fs_date',`fs_price`='$fs_price',`fs_remarks`='$fs_remarks',`fs_thumbnail`='$fs_thumbnail',`owner`='$owner',`creator`='$creator' WHERE `fto_id` = $id";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_ft_layer_from_orf_id($orf_id)
    {
        $mysqli = $this->dbdomenia3n();

        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);

        $query = "select * from `ft_layers` where `orf_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $orf_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
       
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_ft_layers($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data = json_decode($data);

        
        $ftl_id = mysqli_real_escape_string($mysqli, $data->existing_ftl_id);
        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $rks_id = mysqli_real_escape_string($mysqli, $data->rks_id);
        $camera_position = mysqli_real_escape_string($mysqli,$data->camera_view);
        $zlevel = mysqli_real_escape_string($mysqli,$data->z_index);
        $fto_content = mysqli_real_escape_string($mysqli,$data->fto_content);
                
        $query = "UPDATE `ft_layers` SET `orf_id` = '$orf_id' , `rks_id` = '$rks_id', `camera_position` = '$camera_position', `zlevel` = '$zlevel',`fto_content`='$fto_content' WHERE `ftl_id` = '$ftl_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
    }

    public function add_ft_layers($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data = json_decode($data);

        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $rks_id = mysqli_real_escape_string($mysqli, $data->rks_id);
        $camera_position = mysqli_real_escape_string($mysqli,$data->camera_view);
        $zlevel = mysqli_real_escape_string($mysqli,$data->z_index);
        $fto_content = mysqli_real_escape_string($mysqli,$data->fto_content);
                
        $query = "INSERT INTO `ft_layers`(`orf_id`,`rks_id`,`camera_position`,`zlevel`,`fto_content`) values('$orf_id','$rks_id','$camera_position','$zlevel','$fto_content')";
        $stmt = mysqli_prepare($mysqli, $query);
        
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
    }

    public function add_lt_room($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data = json_decode($data);

        $ltr_name = mysqli_real_escape_string($mysqli, $data->ltr_name);
        $ltr_description = mysqli_real_escape_string($mysqli, $data->ltr_description);
        $rk_ids = mysqli_real_escape_string($mysqli,$data->rk_ids);
        $ft_objects = mysqli_real_escape_string($mysqli,$data->ft_objects);
                
        $query = "INSERT INTO `lt_2_sets_4_rooms`(`ltr_name`,`ltr_description`,`rk_ids`,`lt_1_objects`) values('$ltr_name','$ltr_description','$rk_ids','$ft_objects')";
        $stmt = mysqli_prepare($mysqli, $query);
        
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        
    }

    public function edit_lt_room($data)
    {
        $mysqli = $this->dbdomenia3n();
        $data = json_decode($data);

        $ltr_id = mysqli_real_escape_string($mysqli, $data->ltr_id);
        $ltr_name = mysqli_real_escape_string($mysqli, $data->ltr_name);
        $ltr_description = mysqli_real_escape_string($mysqli, $data->ltr_description);
        $rk_ids = mysqli_real_escape_string($mysqli,$data->rk_ids);
        $ft_objects = mysqli_real_escape_string($mysqli,$data->ft_objects);
        
        $query = "UPDATE `lt_2_sets_4_rooms` SET `ltr_name` = '$ltr_name' , `ltr_description` = '$ltr_description', `rk_ids` = '$rk_ids', `ft_objects` = '$ft_objects' WHERE `ltr_id` = $ltr_id";
        
        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_all_f_sources()
    {
        $mysqli = $this->dbdomenia3n();
        $query = "select * from `f_sources` order by `fs_name` asc";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $rows;
    }

    public function get_f_source($fs_id)
    {
        $mysqli = $this->dbdomenia3n();

        $fs_id = mysqli_real_escape_string($mysqli, $fs_id);

        $query = "select * from `f_sources` where `fs_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $fs_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_object_types()
    {
        $mysqli = $this->dbconnect();
        $query = "select * from `object_types`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_all_entities_status()
    {
        $mysqli = $this->dbconnect();
        $query = "select * from `entities_status`";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_entities_status($est_id)
    {
        $mysqli = $this->dbconnect();

        $est_id = mysqli_real_escape_string($mysqli, $est_id);

        $query = "select * from `entities_status` where `est_id`=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $est_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_all_interior_entities($o_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $query = "select * from `entities_n` where `o_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function update_interior_entity($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $e_n_id = mysqli_real_escape_string($mysqli, $data->e_n_id);
        $e_n_level = mysqli_real_escape_string($mysqli, $data->e_n_level);
        $e_n_name = mysqli_real_escape_string($mysqli, $data->e_n_name);
        $e_n_size_total = mysqli_real_escape_string($mysqli, $data->e_n_size_total);
        $e_n_size_usable = mysqli_real_escape_string($mysqli,$data->e_n_size_usable);
        $e_n_price = mysqli_real_escape_string($mysqli,$data->e_n_price);
        $e_n_status = mysqli_real_escape_string($mysqli,$data->e_n_status);

        $query = "UPDATE `entities_n` SET `e_n_level` = '$e_n_level',`e_n_name` = '$e_n_name',`e_n_size_total` = '$e_n_size_total', `e_n_size_usable` = '$e_n_size_usable',`e_n_price` = '$e_n_price',`e_n_status`='$e_n_status' WHERE `e_n_id` = $e_n_id";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_all_user_tracking_page($client_id,$o_id)
    {
        $mysqli = $this->dbconnect();

        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $query = "select * from `u_clients_tracking` where `client_id`=?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $client_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function get_valid_user_tracking_taskdetails($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);
        $date_visited = mysqli_real_escape_string($mysqli, $data->date_visited);

        $query = "select * from `u_clients_tracking` WHERE `o_id`=? and `osub_id` LIKE ? and `prod_id` LIKE ? and `date_visited` >= ?";

        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "isss", $o_id,$osub_id,$prod_id,$date_visited);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_user_tracking_page($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $page_name = mysqli_real_escape_string($mysqli, $data->page_name);
        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli,$data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli,$data->prod_id);
        
        $query = "UPDATE `u_clients_tracking` SET `page_name` = '$page_name' ,`o_id` = '$o_id', `osub_id` = '$osub_id',`prod_id` = '$prod_id' WHERE `client_id` = $client_id";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function insert_user_tracking_page($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli,$data->prod_id);
        $date_visited = mysqli_real_escape_string($mysqli,$data->date_visited);
        
        $query = "INSERT `u_clients_tracking`(`client_id`,`page_name`,`o_id`,`osub_id`,`prod_id`,`date_visited`) values('$client_id','','$o_id','$osub_id','$prod_id','$date_visited')";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_user_tracking_page($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);       
        
        $query = "DELETE FROM `u_clients_tracking` WHERE `client_id`='$client_id' and `o_id`='$o_id'";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_all_masks_for_orf_id($orf_id)
    {
        $mysqli = $this->dbconnect();
        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_r_masks_values` where `orf_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orf_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_base_picture_mask($orme_id)
    {
        $mysqli = $this->dbconnect();
        $orme_id = mysqli_real_escape_string($mysqli, $orme_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_r_masks_values` where `orme_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $orme_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function update_mask_coordinates($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orme_id = mysqli_real_escape_string($mysqli, $data->orme_id);
        $mask_coordinates = mysqli_real_escape_string($mysqli, $data->mask_coordinates);

        $query = "update `o_r_masks_values` set `mask_coordinates`='$mask_coordinates' where `orme_id`='$orme_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_mask_target($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orme_id = mysqli_real_escape_string($mysqli, $data->orme_id);
        $ort_id = mysqli_real_escape_string($mysqli, $data->ort_id);

        $query = "update `o_r_masks_values` set `ort_id`='$ort_id' where `orme_id`='$orme_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_suntour_model_id($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $suntour_model_id = mysqli_real_escape_string($mysqli, $data->suntour_model_id);

        $query = "update `o_results` set `suntour_model_id`='$suntour_model_id' where `orf_id`='$orf_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_vr_link($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orf_id = mysqli_real_escape_string($mysqli, $data->orf_id);
        $vr_link = mysqli_real_escape_string($mysqli, $data->vr_link);

        $query = "update `o_results` set `vr_link`='$vr_link' where `orf_id`='$orf_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_mask_plot($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $orme_id = mysqli_real_escape_string($mysqli, $data->orme_id);
        $plot_id = mysqli_real_escape_string($mysqli, $data->plot_id);

        $query = "update `o_r_masks_values` set `plot_id`='$plot_id' where `orme_id`='$orme_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function create_masks_for_orf_id($orf_id)
    {
        $mysqli = $this->dbconnect();

        $orf_id = mysqli_real_escape_string($mysqli, $orf_id);
        
        $query = "INSERT `o_r_masks_values`(`orf_id`) values('$orf_id')";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_mask_coordinates($orme_id)
    {
        $mysqli = $this->dbconnect();

        $orme_id = mysqli_real_escape_string($mysqli, $orme_id);    
        
        $query = "DELETE FROM `o_r_masks_values` WHERE `orme_id`='$orme_id'";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_all_targets_for_o_id($o_id)
    {
        $mysqli = $this->dbconnect();
        $o_id = mysqli_real_escape_string($mysqli, $o_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_r_targets` where `o_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $o_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_target_url($ort_id)
    {
        $mysqli = $this->dbconnect();
        $ort_id = mysqli_real_escape_string($mysqli, $ort_id);

        $stmt = mysqli_prepare($mysqli, "select * from `o_r_targets` where `ort_id`=?");
        mysqli_stmt_bind_param($stmt, "i", $ort_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $row;
    }

    public function create_targets_for_o_id($o_id)
    {
        $mysqli = $this->dbconnect();

        $o_id = mysqli_real_escape_string($mysqli, $o_id);
        
        $query = "INSERT `o_r_targets`(`o_id`) values('$o_id')";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function create_suntour_model($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);
        $uca_id = mysqli_real_escape_string($mysqli, $data->uca_id);

        $query = "INSERT `o_results`(`o_id`,`osub_id`,`prod_id`,`uca_id`) values('$o_id','$osub_id','$prod_id','$uca_id')";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function create_vr_link($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $o_id = mysqli_real_escape_string($mysqli, $data->o_id);
        $osub_id = mysqli_real_escape_string($mysqli, $data->osub_id);
        $prod_id = mysqli_real_escape_string($mysqli, $data->prod_id);
        $uca_id = mysqli_real_escape_string($mysqli, $data->uca_id);

        $query = "INSERT `o_results`(`o_id`,`osub_id`,`prod_id`,`uca_id`) values('$o_id','$osub_id','$prod_id','$uca_id')";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function delete_target($ort_id)
    {
        $mysqli = $this->dbconnect();

        $ort_id = mysqli_real_escape_string($mysqli, $ort_id);    
        
        $query = "DELETE FROM `o_r_targets` WHERE `ort_id`='$ort_id'";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_ort_url($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $ort_url = mysqli_real_escape_string($mysqli, $data->ort_url);
        $ort_id = mysqli_real_escape_string($mysqli, $data->ort_id);

        $query = "update `o_r_targets` set `ort_url`='$ort_url' where `ort_id`='$ort_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_second_ort_url($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $second_ort_url = mysqli_real_escape_string($mysqli, $data->second_ort_url);
        $ort_id = mysqli_real_escape_string($mysqli, $data->ort_id);

        $query = "update `o_r_targets` set `second_ort_url`='$second_ort_url' where `ort_id`='$ort_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function update_ort_text($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $ort_text = mysqli_real_escape_string($mysqli, $data->ort_text);
        $ort_id = mysqli_real_escape_string($mysqli, $data->ort_id);

        $query = "update `o_r_targets` set `ort_text`='$ort_text' where `ort_id`='$ort_id'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }

    public function get_lt_2_sets_4_rooms_by_rk_id($rk_id)
    {
        $mysqli = $this->dbdomenia3n();

        $query = "select * from `lt_2_sets_4_rooms` where rk_ids like '%$rk_id%'";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_ft_objects_list($fto_ids)
    {
        $mysqli = $this->dbdomenia3n();
        $param = mysqli_real_escape_string($mysqli, implode(',', $fto_ids));

        $query = "select * from `lt_1_objects` where `fto_id` in ($param)";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $rows = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        return $rows;
    }

    public function get_token($client_id)
    {
        $mysqli = $this->dbconnect();
        $client_id = mysqli_real_escape_string($mysqli, $client_id);

        $now=gmdate("Y-m-d H:i:s");
        $stmt = mysqli_prepare($mysqli, "select * from `u_clients_tokens` where `client_id`=? AND `expires_at` > '$now'");
        mysqli_stmt_bind_param($stmt, "i", $client_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        return $row;
    }

    public function insert_token($data)
    {
        $mysqli = $this->dbconnect();
        $data = json_decode($data);

        $client_id = mysqli_real_escape_string($mysqli, $data->client_id);
        $token = mysqli_real_escape_string($mysqli, $data->token);
        $ip_address = mysqli_real_escape_string($mysqli, $data->ip_address);
        $expires_at = mysqli_real_escape_string($mysqli, $data->expires_at);

        $query = "INSERT `u_clients_tokens`(`client_id`,`token`,`ip_address`,`expires_at`) values('$client_id','$token','$ip_address','$expires_at')";

        $stmt = mysqli_prepare($mysqli, $query);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }
}

?>
