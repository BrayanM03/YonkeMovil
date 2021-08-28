<!DOCTYPE html>
<html lang="es">

<head>
    <title>Iniciar sesion | Yonkemovil </title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="CodedThemes">
    <meta name="keywords" content=" Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="CodedThemes">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!---Librerias---->
    <link rel="stylesheet" type="text/css" href="app/frontend/node_modules/sweetalert2/dist/sweetalert2.min.css">
    
    <link rel="stylesheet" type="text/css" href="app/frontend/node_modules/@fortawesome/fontawesome-free/css/all.min.css"> 
    <!-- Style.css -->
   <!--  <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
   <style>
       body{
        background-color: #e22f22;
       }
   </style>
</head>

<body class="fix-menu">
    <!-- Pre-loader start -->
    <div class="theme-loader">
    <div class="ball-scale">
        <div class='contain'>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
        </div>
    </div>
</div>
    <!-- Pre-loader end -->

    <section class="text-center mt-5" style="background-color: #e22f22; height:88vh;">
        <!-- Container-fluid starts -->
        <div class="container d-flex justify-content-center">
            <div class="row">
                <div class="col-12 col-md-12">
                    <!-- Authentication card start -->
                      
                            <div class="text-center" style="width: 350px;">
                                <img src="assets/images/logo.png" style="width: 150px; margin: auto;" alt="logo.png"></br>
                                <span style="color: yellow;"><b>¡Tus piezas al instante!</b></span>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" style="border-radius: 7px;" id="username" placeholder="Usuario">
                                <div class="input-group  mt-3">
                                <input type="password" class="form-control" style="border-radius: 7px 0px 0px 7px;" id="password" placeholder="Contraseña">
                                <button id="show_password"  style="border-radius: 0px 7px 7px 0px;" class="btn btn-primary btn-sm" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                </div>                                
                                <div class="btn btn-warning text-dark mt-3" style="border-radius: 7px;" onclick="iniciarSesion();">Iniciar Sesión</div>
                            </div>
                        
                   
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->

        

    </section>
    <footer class="sticky-footer" style="color:antiquewhite;">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; YonkeMovil  <?php print_r(date("Y")) ?></span><br><br>
                    </div>
                </div>
    </footer>
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 9]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    
<script src="app/frontend/node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/modernizr/modernizr.js"></script>
    <script type="text/javascript" src="assets/js/modernizr/css-scrollbars.js"></script>
    <script type="text/javascript" src="assets/js/common-pages.js"></script>

    <!----Mis librerias----->
    <script src="app/frontend/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    
    <!----Mis scripts----->
    <script type="text/javascript" src="app/frontend/js/login/iniciar-sesion.js"></script>
</body>

</html> 
