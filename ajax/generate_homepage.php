<?php
include('../functions.php');
include('../httpsocket.php');

$prod = new Production;
$sock = new HTTPSocket;

$o_id=$prod->xss_fix($_POST['o_id']);

$homepage_url=explode('.',$prod->xss_fix($_POST['homepage_url']));

if((!empty($homepage_url))&&(count($homepage_url)==3))
{
$subdomain=$homepage_url[0];
$domain=$homepage_url[1].".".$homepage_url[2];

$source_path="/home/admin/domains/bauvorschau.com/public_html/aa-p4p-template";
$destination_path="/home/admin/domains/".$domain."/public_html/".$subdomain;
$variables_file="assets/homepage/variables.json";

if(!is_dir($destination_path))
{
    $status=null;
    $output=null;
    exec("cp -r $source_path $destination_path",$output, $status);

    if($status==0)
    {
        if (file_exists($destination_path."/".$variables_file)) 
        {
            ?>
            <div class="alert alert-success">Files copied successfully !</div>
            <?php
            //changing o_id

            $variables_data=json_decode(file_get_contents($destination_path."/".$variables_file), TRUE);

            $new_data=array();
            foreach($variables_data as $key => $value) 
            {
                
                if($key=="o_id")
                {
                    $new_data['o_id']=$o_id;
                }
                else
                {
                    $new_data[$key]=$value;
                }
            }

       
            file_put_contents($destination_path."/".$variables_file, json_encode($new_data));

            //creating new subdomain with DirectAdmin

            
            $sock->connect('178.17.166.234',2222);

            $sock->set_login("admin","6gpc6bXMVJ[Da[[\"");

            $sock->set_method('POST');

            $sock->query('/CMD_API_SUBDOMAINS',
                array(
                    'action' => 'create',
                    'domain' => $domain,
                    'subdomain' => $subdomain
                ));
            $result = $sock->fetch_body();

            parse_str($result, $output2);

            if($output2['error']==0)
            {
                ?>
                <div class="alert alert-success"><?php echo $output2['text'];?></div>
                <?php                
            }
            else
            {
                ?>
                <div class="alert alert-danger"><?php echo $output2['text'];?></div>
                <?php
            }   
        }
    }
    else
    {
        ?>
        <div class="alert alert-danger">Some errors occured copying the files !</div>
        <?php
    }
}
else
{
    ?>
    <div class="alert alert-danger">Subdomain already exists. Nothing copied !</div>
    <?php
}
}
?>