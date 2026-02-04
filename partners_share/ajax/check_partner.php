<?php 
include('../../functions.php');

$prod=new Production;

$sponsor=$_POST['sponsor'];

$user=$prod->get_user_by_email($sponsor);

$message='<div class="alert alert-danger m-0 p-1 text-center">Invalid Partner</div>';

if($user)
{
	if($user['partner_since'] !== null)
	{
		$message='<div class="alert alert-success m-0 p-1 text-center">Correct Partner</div>';
	}
}

if(empty($sponsor))
{
	$message='';
}

echo $message;