<?php
$base_url="https://blue7.it/studio/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="apple-touch-icon" sizes="180x180" href="https://blue7.it/icoblue7/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://blue7.it/icoblue7/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://blue7.it/icoblue7/favicon-16x16.png">
    <link rel="manifest" href="https://blue7.it/icoblue7/site.webmanifest">
    <link rel="mask-icon" href="https://blue7.it/icoblue7/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <link rel="stylesheet" href="<?php echo $base_url;?>css/newstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery-ui1.12.1.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.uploadfile.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.datetimepicker.full.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/moment.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo $base_url;?>js/moment-timezone-with-data-2012-2022.min.js"></script>-->
    <script type="text/javascript" src="<?php echo $base_url;?>js/moment-timezone-with-data-1970-2030.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/jquery.countdown.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/panellum.js"></script>
    <!-- <script type="text/javascript" src="../js/jquery.qtip.js"></script> -->
    <script type="text/javascript" src="<?php echo $base_url;?>js/app.js"></script>
    <script src="<?php echo $base_url;?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $base_url;?>js/ckeditor/ckeditor.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js "></script>
    
    <script defer>
       document.addEventListener("DOMContentLoaded", function() {

            setTimeout(function() {
                let selectedPanoramaDiv = document.getElementById("panorama");
                let overlay = document.getElementById("fullscreen-overlay");

                // Select all elements with the class 'popup-trigger'
                var popupTriggers = document.querySelectorAll('img.img-responsive');
                // var popupTriggers = document.querySelectorAll('img:not(#fullscreen-image):not(.configurator_pictures)');
                // popupTriggers = document.querySelectorAll('img:not(#fullscreen-image):not(.door_shapes)');
                console.log(popupTriggers);


                popupTriggers.forEach(function(popupTrigger) {
                    var popup = createPopup(popupTrigger);
                    var popupImage = popup.querySelector('.popup-image');

                    console.log("test");
                    console.log(popupTriggers[0])
                    popupTrigger.addEventListener('mousemove', function(event) {

                        var x = event.clientX;
                        var y = event.clientY + window.scrollY; // Adjust for scroll position

                        // Adjust position if the popup goes out of viewport horizontally
                        if (x + popup.offsetWidth > window.innerWidth) {
                            x = window.innerWidth - popup.offsetWidth;
                        }
                        // Adjust position if the popup goes out of viewport vertically, considering scroll position
                        if (y + popup.offsetHeight > window.innerHeight + window.scrollY) {
                            y = window.innerHeight + window.scrollY - popup.offsetHeight;
                        }


                        popup.style.display = 'flex';
                        popup.style.left = '50%';
                        popup.style.transform = 'translateX(-50%)';
                        popup.style.top = y + 'px';

                        let imageDiv = document.getElementsByClassName("popup-image");

                        imageDiv[0].style.display = "block";
                        popupImage.src = popupTrigger.src;
                    });

                    popupTrigger.addEventListener('mouseout', function() {
                        popup.style.display = 'none';
                    });
                });


                function createPopup(trigger) {
                    console.log(trigger);
                    var popup = document.createElement('div');
                    popup.className = 'popup';
                    popup.style.flexDirection = "column";
                    popup.innerHTML = '<img style="width: 0;" src="your-image.jpg" class="popup-image">';

                    // Append the popup element to the body element
                    document.body.appendChild(popup);

                    return popup;
                }
            }, 3000);

        });

    </script>
    <style>
        #preview_img > img {
            height: auto !important;
            object-fit: contain;

        }

        #preview_img {
            max-height: unset !important;
            height: inherit !important;
        }

        .popup {
            z-index:2;
            display: none;
            min-width: max-content;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            pointer-events: none; /* Allows mouse events to pass through the popup */
        }

        .popup-image {
            position: relative;
            max-width: 100%;
            max-height: 100%;
            height: 40vw !important;
            width: 40vw !important;
            object-fit: contain;
        }

        .popup-trigger:hover + .popup {
            display: block;
        }
    </style>

    <title>7s <?php echo (!empty($page_title))?" - ".$page_title:""; ?></title>
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
