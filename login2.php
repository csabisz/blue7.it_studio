<?php
session_start();

include('functions.php');

$prod=new Production;

$data['start']=gmdate("Y-m-d H:i:s");


$email=$prod->xss_fix($_POST['email']);
$password=$prod->xss_fix($_POST['password']);

$client=$prod->client_login($email,$password);


if(!empty($client))
{
    $client_rights=$prod->get_client_rights($client['client_ID']);

    if($client_rights['u_status']=="active")
    {
        $data['client_id']=$client['client_ID'];
        $data['client']=$client_rights['client'];
        $data['own_tasks']=$client_rights['own_tasks'];
        $data['cdesign']=$client_rights['cdesign'];
        $data['change_vat']=$client_rights['change_vat'];
        $data['l_first_name']=$client['l_first_name'];
        $data['l_last_name']=$client['l_last_name'];
        $data['c_first_name']=$client['c_first_name'];
        $data['c_last_name']=$client['c_last_name'];
        $data['email']=$client['email'];
        $data['useradmin']=$client_rights['user_admin'];
        $data['programs_of_employees']=$client_rights['programs_of_employees'];
        $data['contracting']=$client_rights['contracting'];
        $data['bookkeeping']=$client_rights['bookkeeping'];
        $data['coordination']=$client_rights['coordination'];
        $data['plansets']=$client_rights['plansets'];
        $data['housesets']=$client_rights['housesets'];
        $data['plots']=$client_rights['plots'];
        $data['view_all_orders']=$client_rights['view_all_orders'];
        $data['activity_view']=$client_rights['activity_view'];
        $data['apu_lists']=$client_rights['APU_lists'];
        $data['examples_db']=$client_rights['examples_db'];
        //$data['translations']=$client_rights['translations'];

        // $options=array(
        //     'expires' => time() + (16 * 60 * 60), //16 hours 
        //     'path' => "/",
        //     'domain' => "blue7.it",
        //     'secure' => false,
        //     'httponly' => false,
        //     'samesite' => "Lax"
        // );
        // setcookie("client_id", $client['client_ID'], $options);

        

        if($client['lt_id']>0)
        {
        $data['company']=$prod->get_company($client['lt_id'])['Company'];
        $data['lt_id']=$client['lt_id'];
        }
        $data['ip_address']=$_SERVER['REMOTE_ADDR'];
        $data['user_agent']=$_SERVER['HTTP_USER_AGENT'];    

        $existing_token=$prod->get_token($data['client_id']);

        if(empty($existing_token))        
        {
            $data['token']=sha1(uniqid(mt_rand(), true));
            $data['expires_at']=gmdate("Y-m-d H:i:s",strtotime("+8 hours"));
            $prod->insert_token(json_encode($data));
        }
        
        $creator_end_time=$prod->get_creator_end_time($data['client_id']);

        if(!empty($creator_end_time))
        {
            if($data['start']>$creator_end_time['end_time'])
            {
                //if session expired we let the creator log in with default working hours
                $data['expire']=gmdate("Y-m-d H:i:s",strtotime("+8 hours"));// default 8 hours
            }
            else
            {
                $data['expire']=$creator_end_time['end_time'];
            }
        }
        else
        {
            $data['expire']=gmdate("Y-m-d H:i:s",strtotime("+8 hours"));// default 8 hours
        }
        $data['message']="0";
    }
    else
    {    
        $data['message']="User is not active anymore !";
    }
}
else
{
    $data['message']="Invalid e-mail address or password !";
}

echo json_encode($data);
?>