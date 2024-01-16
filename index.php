<?php 
    include("includes/db_helper.php");
    include("language/language.php");
    
    $license_filename="includes/.lic";
    if(!file_exists($license_filename)){
        header("Location:install/index.php");
        exit;
    }

    if(isset($_SESSION['admin_name']) AND isset($_SESSION['admin_type'])) {
        header("Location:dashboard.php");
        exit;
    }
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Seo Meta -->
    <meta name="description" content="Admin panel | Dashboard">
    <meta name="keywords" content="css3, html5">
    
    <!-- Website Title -->
    <title>Login | <?php echo APP_NAME;?></title>
    
    <!-- Favicon --> 
    <link href="images/<?php echo APP_LOGO;?>" rel="icon" sizes="32x32">
    <link href="images/<?php echo APP_LOGO;?>" rel="icon" sizes="192x192">

    <!-- IOS Touch Icons -->
    <link rel="apple-touch-icon" href="images/<?php echo APP_LOGO;?>">
    <link rel="apple-touch-icon" sizes="152x152" href="images/<?php echo APP_LOGO;?>">
    <link rel="apple-touch-icon" sizes="180x180" href="images/<?php echo APP_LOGO;?>">
    <link rel="apple-touch-icon" sizes="167x167" href="images/<?php echo APP_LOGO;?>">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor styles -->
    <link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.css" type="text/css">
    <link rel="stylesheet" href="assets/vendors/remixicon/remixicon.min.css" type="text/css">
    <link rel="stylesheet" href="assets/vendors/quill/quill.min.css" type="text/css">
    <link rel="stylesheet" href="assets/vendors/select2/select2.min.css" type="text/css">

    <!-- Main style -->
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    
    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<style>
    body.nsofts-theme-dark:before {
        background-color: rgb(16 19 22) !important;
    }
</style>
<body>
    
    <!-- Loader -->
    <div id="nsofts_loader">
        <div class="text-center">
            <i class="ri-3x ri-donut-chart-line nsofts-loader-icon"></i>
            <span class="d-block">Loading</span>
        </div>
    </div>


    <!-- Start: 404 -->
    <main class="d-flex justify-content-center align-items-center py-5 min-vh-100">
        <div class="container">
            <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9 mx-auto">
                <div class="nsofts-auth position-relative">
                    <img src="assets/images/pattern-1.svg" class="nsofts-auth__pattern-1 position-absolute" alt="">
                    <img src="assets/images/pattern-2.svg" class="nsofts-auth__pattern-2 position-absolute" alt="">
                    <div class="card position-relative">
                        <div class="card-body px-4 py-4">
                            <form action="login_db.php" method="post">
                                <div class="text-center mb-3">
                                    <a href="index.php" class="fs-4 fw-semibold text-decoration-none"><?php echo APP_NAME;?></a>
                                </div>
                                <div class="mb-4">
                                    <h5>Welcome to <?php echo APP_NAME;?>!</h5>
                                    <p>Please sign-in to your account and start the adventure.</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email or Username</label>
                                    <div class="nsofts-input-icon nsofts-input-icon--left">
                                        <label for="email" class="nsofts-input-icon__left">
                                            <i class="ri-user-line"></i>
                                        </label>
                                        <input type="text" name="user_login" id="user_login"  class="form-control" autocomplete="off" placeholder="Enter your email or username" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="nsofts_password_input" class="form-label fw-semibold mb-0">Password</label>
                                        <a href="auth_pass_recovery.php" class="text-decoration-none">Forgot Password?</a>
                                    </div>
                                    <div class="nsofts-input-icon nsofts-input-icon--both">
                                        <label for="nsofts_password_input" class="nsofts-input-icon__left">
                                            <i class="ri-door-lock-line"></i>
                                        </label>
                                        <input type="password" name="nsofts_password_input" id="nsofts_password_input" class="form-control" autocomplete="off" placeholder="Enter your password" required>
                                        <button type="button" id="nsofts_password_toggler" class="nsofts-input-icon__right btn p-0 border-0 lh-1">
                                            <i class="ri-eye-line nsofts-eye-open"></i>
                                            <i class="ri-eye-off-line nsofts-eye-close d-none"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button  type="submit" class="btn btn-primary btn-lg w-100">Sign in</button>
                                </div>
                                <p class="text-center">New on our platform? <a href="auth_register.php" class="text-decoration-none">Create an account</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End: 404 -->
    

    <!-- Vendor scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="assets/vendors/notify/notify.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/vendors/quill/quill.min.js"></script>
    <script src="assets/vendors/select2/select2.min.js"></script>

    <!-- Main script -->
    <script src="assets/js/main.js"></script>
    
    <?php if (isset($_SESSION['msg'])) { ?>
        <script type="text/javascript">
            $('.notifyjs-corner').empty();
            $.notify(
            '<?php echo $client_lang[$_SESSION["msg"]]; ?>', {
                position: "top right",
                className: '<?= $_SESSION["class"] ?>'
            }
            );
        </script>
        <?php
        unset($_SESSION['msg']);
        unset($_SESSION['class']);
    }?>

</body>
</html>