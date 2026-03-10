<?php
session_set_cookie_params(36000,"/");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="apple-touch-icon" sizes="180x180" href="../icoblue7/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../icoblue7/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../icoblue7/favicon-16x16.png">
    <link rel="manifest" href="../icoblue7/site.webmanifest">
    <link rel="mask-icon" href="../icoblue7/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a1d61848bd.js" crossorigin="anonymous"></script>
    <link href="css/jquery.fancybox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main_page_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js "></script>
    <title>Blue7.it Studio</title>
</head>


<body data-spy="scroll" data-target="#navbarNav" data-offset="50">
    <section id="header" class="fixed-top bg-intro">
        <div class="row w-100 mx-0">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#">Cseven</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse py-2" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item px-2">
                                <a class="nav-link" href="#intro">Home</a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link" href="#services">Services</a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link" href="#contact">Contact</a>
                            </li>
                           
                                <?php
                                if(!isset($_COOKIE['client_id']))
                                {
                                ?>
                                <li class="nav-item px-2">
                                <form id="login_form" method="post" action="" class="d-flex">
                                    <div class="input-group input-group-sm mr-2 pt-1">
                                        <input type="email" id="email" name="email" class="form-control" aria-label="Username" aria-describedby="Username" placeholder="E-mail">
                                    </div>
                                    <div class="input-group input-group-sm pt-1">
                                        <input type="password" id="password" name="password" class="form-control" aria-label="Password" aria-describedby="Password" placeholder="Password">
                                    </div>
                                    <a id="login_btn" class="nav-link ml-2" href="#">Login</a>
                                </form>
                                </li>
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <li class="nav-item px-2">
                                    <a class="nav-link ml-2" href="own_tasks.php">Own tasks</a>
                                    </li>
                                    <li class="nav-item px-2">
                                    <a class="nav-link ml-2" href="logout.php">Logout</a>
                                    </li>
                                    <?php
                                }
                                ?>
                            
                        </ul>
                    </div>
                </nav>
                <div id="login_message" class="text-center">
                
                </div>
            </div>
        </div>
    </section>
    <section id="intro" class="bg-intro">
        <div class="row w-100 mx-0">
            <div class="col-lg-6 col-12 pl-xl-5 area" id="title-text">
                <div class="parentBg pl-xl-5">
                    C7
                </div>
                <div class="animated-title text-right w-100 d-flex justify-content-end">
                    <div class="text-top">
                        <div class="py-0 w-100 text-right pr-5">
                            <span>CreativSeven</span>
                        </div>
                    </div>
                    <div class="text-bottom">
                        <div class="py-0 w-100 text-right">Company</div>
                    </div>
                </div>
                <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <div class="col-lg-6 col-12 d-flex align-items-center text-right px-0" id="second">
                <img src="img/Landing_page.png" alt="landing page image" id="landing">
                <div class="bg-right"></div>
            </div>
            <div class="col-12" id="centerMainText">
                <h1 class="text-center">Obliged to beauty!</h1>
            </div>
        </div>
    </section>
    <section id="services">
        <div class="row bg-blue w-100 mx-0">
            <div class="container">
                <div class="row w-100 mx-0">
                    <h1 class="w-100 text-left text-white pt-5 pb-3">We create webpages, mainly by:</h1>
                    <div class="col-md-6 col-12 col-lg-4 my-5 p-2 text-white">
                        <h3 class="text-left w-100"><span><i class="far fa-images mr-5 fa-2x"></i></span><strong>Images</strong></h3>
                    </div>
                    <div class="col-md-6 col-12 col-lg-4 my-5 p-2 text-white">
                        <h3 class="text-left w-100"><span><i class="fas fa-cube mr-5 fa-2x"></i></span><strong>Panoramas</strong></h3>
                    </div>
                    <div class="col-md-6 col-12 col-lg-4 my-5 p-2 text-white">
                        <h3 class="text-left w-100"><span><i class="fas fa-video mr-5 fa-2x"></i></span><strong>Videos</strong></h3>
                    </div>
                </div>
            </div>
        </div>
    </section> 
    
    <section id="some">
        <div class="container">
            <h1 class="w-100 text-center pt-5">Examples</h1>
        </div>
        <div class="container-c7">
            <div class="box">
                <img alt="boxImage" src="result_files/2020/2099/2099.n01.p1524/880bfadc7c38e27a35aabc85cd3afddaeea48e6c.jpg">
                <span>Interior</span>
            </div>
            <div class="box">
                <img alt="boxImage" src="https://bauvorschau.com/assets/images/news/v2-3people.jpg">
                <span>Exterior</span>
            </div>
            <div class="box">
                <img alt="boxImage" src="result_files/2020/2099/2099.n01.p1523/e491b1d980ce07399d063974cdfcd4987c6a2e76.jpg">
                <span>Floorplan</span>
            </div>
            <div class="box">
                <img alt="boxImage" src="https://bauvorschau.com/assets/images/news/v1-2041-red.white-1-2.jpg">
                <span>Video</span>
            </div>
        </div>
    </section>

    <footer class="bg-dark py-5" id="contact">
        <div class="container-footer">
            <div class="row w-100 mx-0">
                <h2 class="w-100 text-left py-1 text-white">Contact us</h2>
                <h5 class="text-white my-3">CreativSeven</h5>
                <div class="row w-100 mx-0 my-5">
                <!-- https://bauvorschau.com/assets/images/news/v2-3people.jpg -->
                
                    <div class="col-6 col-md-4 col-xl-2 fancy py-2">
                        <div data-fancybox="standard" data-type="image" href="https://bauvorschau.com/assets/images/news/v2-3people.jpg">
                            <img src="https://bauvorschau.com/assets/images/news/v2-3people.jpg" alt="footer image" class="img-fluid img-footer hvr-grow">
                        </div>  
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 fancy py-2">
                        <div data-fancybox="standard" data-type="image" href="https://bauvorschau.com/assets/images/news/v1-2-people.jpg">
                            <img src="https://bauvorschau.com/assets/images/news/v1-2-people.jpg" alt="footer image" class="img-fluid img-footer hvr-grow">
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 fancy py-2">
                        <div data-fancybox="standard" data-type="image" href="https://bauvorschau.com/assets/images/news/v2-3.jpg">
                            <img src="https://bauvorschau.com/assets/images/news/v2-3.jpg" alt="footer image" class="img-fluid img-footer hvr-grow">
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 fancy py-2">
                        <div data-fancybox="standard" data-type="image" href="https://bauvorschau.com/assets/images/news/v1-2041-red.white-1-2.jpg">
                            <img src="https://bauvorschau.com/assets/images/news/v1-2041-red.white-1-2.jpg" alt="footer image" class="img-fluid img-footer hvr-grow">
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 fancy py-2">
                        <div data-fancybox="standard" data-type="image" href="https://bauvorschau.com/assets/images/news/v2-3_warm.jpg">
                            <img src="https://bauvorschau.com/assets/images/news/v2-3_warm.jpg" alt="footer image" class="img-fluid img-footer hvr-grow">
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 fancy py-2">
                        <div data-fancybox="standard" data-type="image" href="https://bauvorschau.com/assets/images/news/v1-2.jpg">
                            <img src="https://bauvorschau.com/assets/images/news/v1-2.jpg" alt="footer image" class="img-fluid img-footer hvr-grow">
                        </div>
                    </div>
                </div>
                <div class="row w-100 mx-0">
                    <div class="col-6 col-md-4 col-xl-3 text-white">
                        <h5>Office</h5>
                        <p class="py-2 text-block mb-0">Registered in Romania, Cluj Napoca <br>Street Poet Grigore Alexandrescu, Nr. 37, Bl. F3, Ap. 10 </p>
                        <p class="py-2 mb-0 text-block">Registration & tax no.: RO37301606</p>
                        <p class="py-2 mb-0 text-block">Nr.: J12/3439/2019</p>
                    </div>
                    <div class="col-6 col-md-4 col-xl-3 text-white">
                        <h5>Start a conversation</h5>
                        <p class="py-2 text-block mb-0">Administrator - <br>Franz-Anton Plitt</p>
                        <p class="py-2 text-block mb-0">Email - info@innovation7.net</p>
                    </div>
                    <div class="col-6 col-md-4 col-xl-3 text-white">
                        <h5>Languages</h5>
                        <p class="py-2 text-block">Ro - Romanian <br> En - English <br> De - German <br> Ru - Russian</p>
                    </div>
                    <!-- <div class="col-6 col-md-4 col-xl-3 text-white">
                        <h5>Latest projects</h5>
                        <div class="row w-100 mx-0">
                            <div class="col-6 py-2">
                                <img src="https://bauvorschau.com/assets/images/news/v2-3people.jpg" alt="img footer" class="img-fluid">
                            </div>
                            <div class="col-6 py-2">
                                <img src="https://bauvorschau.com/assets/images/news/v2-3people.jpg" alt="img footer" class="img-fluid">
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </footer>

    <section id="navbarNav" class="fixed-bottom pb-2 up">
        <div class="row mx-0 text-right px-0 d-none" id="up">
            <div class="col-lg-2 offset-10 px-0 pb-2">
                <a href="#intro" class="pr-2 mr-1" id="upLink">
                    <i class="fas fa-chevron-circle-up fa-2x"></i>
                </a>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script>
        window.onscroll = function() {
            if (window.pageYOffset > 1) {
                $('#header').addClass('bg-white').removeClass("bg-intro");
                $("#up").removeClass("d-none");
            } else {
                $('#header').removeClass('bg-white').addClass("bg-intro");
                $("#up").addClass("d-none");
            }
        }
        $('[data-fancybox="standard"]').fancybox({
            margin: [44, 0, 22, 0],
            thumbs: {
                autoStart: true,
                axis: 'y'
            },
            buttons: [
                "slideShow",
                "zoom",
                "fullScreen",
                "thumbs",
                "close",
            ],
            video: {
                tpl: '<video class="fancybox-video" controls controlsList="nodownload" poster="{{poster}}">' +
                    '<source src="{{src}}" type="{{format}}" />' +
                    'Sorry, your browser doesn\'t support embedded videos, <a href="{{src}}">download</a> and watch with your favorite video player!' +
                    "</video>",
                format: "",
                autoStart: false
            },
            youtube: {
                controls: 0,
                showinfo: 0
            },
        });

        $('body').scrollspy({
            target: '#navbarNav'
        });

        $("#navbarNav a").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();

                const hash = this.hash;

                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function() {

                    window.location.hash = hash;
                });
            }
        });

        $('#login_btn').click(function(){
            login();
        });
        
        $('#password').on('keypress',function(e) {
            if(e.which == 13) {
                login();
            }
        });

        $('#email').on('keypress',function(e) {
            if(e.which == 13) {
                login();
            }
        });

        function login()
        {
            var frm=new FormData($('#login_form')[0]);

            var email=$('#email').val();
            var password=$('#password').val();
            let session_id="<?php echo sha1(uniqid(mt_rand(), true));?>";

            if((email!="")&&(password!=""))
            {
                /*
                $.ajax({
                    url: "login.php",
                    method: "post",
                    data: frm,
                    processData: false,
                    contentType: false,
                    dataType:"html",
                    success:function(data) {
                        if(data==0)
                        {
                            // let current_date = new Date();
                            // let minutes = 960; //16 hours
                            // current_date.setTime(current_date.getTime() + minutes * 60 * 1000);

                            // Cookies.set("session_id", session_id, {
                            // expires: current_date,
                            // path: "/",
                            // SameSite: "Lax",
                            // });

                            //setTimeout(function(){window.location = "own_tasks.php"},1000);
                        }
                        else
                        {
                            $('#login_message').html(data);	
                        }
                    }
                }); */

                $.ajax({
                    url: "login2.php",
                    method: "post",
                    data: frm,
                    processData: false,
                    contentType: false,
                    dataType:"html",
                    success:function(data) {
                        const results=JSON.parse(data);
                        if(results.message=="0")
                        {
                            let current_date = new Date();
                            let minutes = 720; //16 hours
                            current_date.setTime(current_date.getTime() + minutes * 60 * 1000);

                            Cookies.set("session_id", session_id, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("start", results.start, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("client_id", results.client_id, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("client", results.client, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("own_tasks", results.own_tasks, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("cdesign", results.cdesign, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("change_vat", results.change_vat, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("l_first_name", results.l_first_name, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("l_last_name", results.l_last_name, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("c_first_name", results.c_first_name, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("c_last_name", results.c_last_name, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("email", results.email, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("useradmin", results.useradmin, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("programs_of_employees", results.programs_of_employees, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("contracting", results.contracting, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("bookkeeping", results.bookkeeping, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("coordination", results.coordination, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("plansets", results.plansets, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("housesets", results.housesets, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("plots", results.plots, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("view_all_orders", results.view_all_orders, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("activity_view", results.activity_view, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("apu_lists", results.apu_lists, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("examples_db", results.examples_db, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                             Cookies.set("token", results.token, {
                             expires: current_date,
                             path: "/",
                             SameSite: "Lax",
                             });

                            Cookies.set("company", results.company, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("lt_id", results.lt_id, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("ip_address", results.ip_address, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("user_agent", results.user_agent, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                            Cookies.set("expire", results.expire, {
                            expires: current_date,
                            path: "/",
                            SameSite: "Lax",
                            });

                           
                            setTimeout(function(){window.location = "own_tasks.php"},1000);
                        }
                        else
                        {
                            let html_message = `<div class="alert alert-danger" role="alert">${results.message}</div>`;
                            $('#login_message').html(html_message);	
                        }
                        
                        
                    }
                });

            }
        }
    </script>
</body>

</html>
