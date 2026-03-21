<?php
$base_url="https://cseven.eu/studio/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- <link rel="apple-touch-icon" sizes="180x180" href="/icoblue7/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icoblue7/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icoblue7/favicon-16x16.png">
    <link rel="manifest" href="/icoblue7/site.webmanifest">
    <link rel="mask-icon" href="/icoblue7/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff"> -->
    <link rel="icon" type="image/png" sizes="32x32" href="https://cseven.eu/studio/img/cseven_icon.png">


    <link rel="stylesheet" href="<?php echo $base_url;?>css/newstylecoordination3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $base_url;?>css/pannellum.css">
    <!-- <link rel="stylesheet" href="../css/jquery.qtip.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/uploadfile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery-ui.theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery.datetimepicker.css">
    <!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="<?php echo $base_url;?>css/dataTables.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.4/js/tether.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery-ui1.12.1.js"></script>
    <!-- <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.uploadfile.js"></script> -->
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.datetimepicker.full.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> -->
    <script type="text/javascript" src="<?php echo $base_url;?>js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/moment-timezone-with-data-2012-2022.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.countdown.js"></script>
    <!-- <script type="text/javascript" src="<?php echo $base_url;?>js/panellum.js"></script>  -->
    <!-- <script type="text/javascript" src="../js/jquery.qtip.js"></script> -->
    <script type="text/javascript" src="<?php echo $base_url;?>js/app.js"></script>
    <!-- <script src="<?php echo $base_url;?>js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="<?php echo $base_url;?>js/ckeditor/ckeditor.js"></script> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script> 
    
 
    <title><?php echo (!empty($page_title))?$page_title:""; ?></title>
</head>
<body id="home" data-target="#back2Top" data-spy="scroll">
<?php
$client=$prod->get_client($_COOKIE['client_id']);

$licence_sites=explode(";",$client['ls_ids']);

function compareSiteByName($alphabetical_websites, $b) 
{
    return strcmp($alphabetical_websites["ls_name"], $b["ls_name"]);
}

function compareCurrencyByName($alphabetical_currencies, $b) 
{
    return strcmp($alphabetical_currencies["cur_short"], $b["cur_short"]);
}

function compareLanguageByName($alphabetical_languages, $b) 
{
    return strcmp($alphabetical_languages["ln_name"], $b["ln_name"]);
}
?>
