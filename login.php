<?php
session_start();

include('functions.php');

$prod=new Production;

$_SESSION['start']=gmdate("Y-m-d H:i:s");
$_COOKIIE['start']=gmdate("Y-m-d H:i:s");

$email=$prod->xss_fix($_POST['email']);
$password=$prod->xss_fix($_POST['password']);

$client=$prod->client_login($email,$password);

if(!empty($client))
{
    $client_rights=$prod->get_client_rights($client['client_ID']);

    if($client_rights['u_status']=="active")
    {
        $_SESSION['client_id']=$client['client_ID'];
        $_SESSION['client']=$client_rights['client'];
        $_SESSION['own_tasks']=$client_rights['own_tasks'];
        $_SESSION['cdesign']=$client_rights['cdesign'];
        $_SESSION['change_vat']=$client_rights['change_vat'];
        $_SESSION['l_first_name']=$client['l_first_name'];
        $_SESSION['l_last_name']=$client['l_last_name'];
        $_SESSION['c_first_name']=$client['c_first_name'];
        $_SESSION['c_last_name']=$client['c_last_name'];
        $_SESSION['email']=$client['email'];
        $_SESSION['useradmin']=$client_rights['user_admin'];
        $_SESSION['programs_of_employees']=$client_rights['programs_of_employees'];
        $_SESSION['contracting']=$client_rights['contracting'];
        $_SESSION['bookkeeping']=$client_rights['bookkeeping'];
        $_SESSION['coordination']=$client_rights['coordination'];
        $_SESSION['plansets']=$client_rights['plansets'];
        $_SESSION['housesets']=$client_rights['housesets'];
        $_SESSION['plots']=$client_rights['plots'];
        $_SESSION['view_all_orders']=$client_rights['view_all_orders'];
        $_SESSION['activity_view']=$client_rights['activity_view'];
        $_SESSION['apu_lists']=$client_rights['APU_lists'];
        $_SESSION['examples_db']=$client_rights['examples_db'];
        //$_SESSION['translations']=$client_rights['translations'];

        $options=array(
            'expires' => time() + (16 * 60 * 60), //16 hours 
            'path' => "/",
            'domain' => "cseven.eu",
            'secure' => false,
            'httponly' => false,
            'samesite' => "Lax"
        );
        setcookie("client_id", $client['client_ID'], $options);

        $_COOKIE['client']=$client_rights['client'];
        $_COOKIE['own_tasks']=$client_rights['own_tasks'];
        $_COOKIE['cdesign']=$client_rights['cdesign'];
        $_COOKIE['change_vat']=$client_rights['change_vat'];
        $_COOKIE['l_first_name']=$client['l_first_name'];
        $_COOKIE['l_last_name']=$client['l_last_name'];
        $_COOKIE['c_first_name']=$client['c_first_name'];
        $_COOKIE['c_last_name']=$client['c_last_name'];
        $_COOKIE['email']=$client['email'];
        $_COOKIE['useradmin']=$client_rights['user_admin'];
        $_COOKIE['programs_of_employees']=$client_rights['programs_of_employees'];
        $_COOKIE['contracting']=$client_rights['contracting'];
        $_COOKIE['bookkeeping']=$client_rights['bookkeeping'];
        $_COOKIE['coordination']=$client_rights['coordination'];
        $_COOKIE['plansets']=$client_rights['plansets'];
        $_COOKIE['housesets']=$client_rights['housesets'];
        $_COOKIE['plots']=$client_rights['plots'];
        $_COOKIE['view_all_orders']=$client_rights['view_all_orders'];
        $_COOKIE['activity_view']=$client_rights['activity_view'];
        $_COOKIE['apu_lists']=$client_rights['APU_lists'];
        $_COOKIE['examples_db']=$client_rights['examples_db'];
        //$_COOKIE['translations']=$client_rights['translations'];

        if($client['lt_id']>0)
        {
        $_SESSION['company']=$prod->get_company($client['lt_id'])['Company'];
        $_SESSION['lt_id']=$client['lt_id'];

        $_COOKIE['company']=$prod->get_company($client['lt_id'])['Company'];
        $_COOKIE['lt_id']=$client['lt_id'];

        }
        $_SESSION['ip_address']=$_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent']=$_SERVER['HTTP_USER_AGENT'];    

        $_COOKIE['ip_address']=$_SERVER['REMOTE_ADDR'];
        $_COOKIE['user_agent']=$_SERVER['HTTP_USER_AGENT'];

        $creator_end_time=$prod->get_creator_end_time($_SESSION['client_id']);

        if(!empty($creator_end_time))
        {
            if($_SESSION['start']>$creator_end_time['end_time'])
            {
                //if session expired we let the creator log in with default working hours
                $_SESSION['expire']=gmdate("Y-m-d H:i:s",strtotime("+8 hours"));// default 8 hours
            }
            else
            {
                $_SESSION['expire']=$creator_end_time['end_time'];
            }
        }
        else
        {
            $_SESSION['expire']=gmdate("Y-m-d H:i:s",strtotime("+8 hours"));// default 8 hours
        }
        echo "0";
    }
    else
    {
        ?>
        <div class="alert alert-danger" role="alert">User is not active anymore !</div>
        <?php
    }
}
else
{
    ?>
    <div class="alert alert-danger" role="alert">Invalid e-mail address or password !</div>
    <?php
}
?>