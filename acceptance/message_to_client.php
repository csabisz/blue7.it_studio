<?php
//session_set_cookie_params(14400,"/acceptance");
session_start();
include('../functions.php');
include('../notifications.php');
include('../../../cseven.eu/public_html/domenia/domenia.php');


$prod=new Production;
$notifications=new Notifications;
$domenia=new Domenia;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');
include('../menu.php');

?>
<section class="top_section">
	<article>
		<div class="container pagecontent px-0 py-4 bg-white">
		<?php
		if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
		{
			$o_id=$prod->xss_fix($_GET['o_id']);
			$order=$prod->get_order($o_id);
			
			$clientid=$order['u_client_ID'];
			$client=$prod->get_client($clientid);
			
			if(isset($_POST['send_btn']))
			{
                $message=$prod->xss_fix($_POST['message']);
                //$message=$_POST['message'];
				$uca_id=$prod->xss_fix($_POST['uca_id']);
				$o_id=$prod->xss_fix($_POST['o_id']);
				
                $prod->send_trader_purchaser_message($o_id,$uca_id,$message);

                $notifications->send_trader_purchaser_email($o_id,$message);


				//$signature=$prod->add_email_signature($o_id);
				//$message.=$signature;
				//echo $_COOKIE['username'];
				//echo $_COOKIE['email'];
				//$licence_taker=$prod->get_licence_taker($o_id);
				//$from_email=$licence_taker['Email'];
				//$from_name=$licence_taker['mailnick'];
				//$sent=$prod->send_message_customer($email,$subject,$message,$from_name,$from_email);
				/*if($sent)
				{
					?>
					<div class="center_message">
						<div class="success">Message sent !</div>
					</div>
					<meta http-equiv="refresh" content="3; url=index.php">
					<?php
				}
				else
				{
					?>
					<div class="error">Error ! Message could not be sent, try later.</div>
					<?php
				}*/
			}
				
			//$orders=$prod->show_orders();
			?>
			<div class="text-center" style="width: 650px; margin: 0 auto;">
            <h2>Send message to <?php 
            if(!empty($client['c_last_name']))
            {
                echo $client['l_title']." ".$client['c_first_name']." ".$client['c_last_name'];
            }
            else
            {
                echo $client['l_title']." ".$client['l_first_name']." ".$client['l_last_name'];
            } ?> - <?php echo $order['order_name']; ?></h2>	
				<label for="allmessages" class="mt-4">Trader - Purchaser messages:</label>
						<textarea id="allmessages" class="form-control" name="allmessages" rows="8" cols="50" placeholder="No messages yet" readonly><?php
						$allmessages=$prod->get_all_trader_purchaser_messages($o_id);
						
						for($i=0;$i<count($allmessages);$i++)
						{
							$uca_id=$allmessages[$i]['uca_id'];
							$client_id=$allmessages[$i]['client_id'];
							
							if($uca_id!=0)
							{
                                $uca_name=$prod->get_client($uca_id);
                                if(!empty($uca_name['c_last_name']))
                                {
                                    echo $uca_name['c_first_name']." ".$uca_name['c_last_name'].": ".$allmessages[$i]['message']."&#13;&#10;";
                                }
                                else
                                {
                                    echo $uca_name['l_first_name']." ".$uca_name['l_last_name'].": ".$allmessages[$i]['message']."&#13;&#10;";
                                }
							}
							if($client_id!=0)
							{
								$client_name=$prod->get_client($client_id);
								echo $client_name['c_title']." ".$client_name['c_first_name']." ".$client_name['c_last_name'].": ".$allmessages[$i]['message']."&#13;&#10;";
							}
							
						}
						?>
						</textarea>
					<br />
				<form name="send_message" action="message_to_client.php?o_id=<?php echo $o_id; ?>" method="post">
				<input type="hidden" name="o_id" value="<?php echo $o_id; ?>">
				<input type="hidden" name="uca_id" value="<?php echo $_COOKIE['client_id']; ?>">
				<div class="form-group">
					<textarea id="message" class="form-control" name="message" rows="6" cols="50" placeholder="Click here to write a message."></textarea>
					<div class="center_message mt-2">
						<button type="submit" name="send_btn" class="btn btn-primary btn-sm">Send</button>					
					</div>
				</div>	
				</form>				
			</div>
			<?php
		}
		else
		{
            session_unset();
            session_destroy();
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>login.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>login.php">
			<?php
		}
		?>
		</div>
	</article>
</section>
<?php
include('footer.php');
?>