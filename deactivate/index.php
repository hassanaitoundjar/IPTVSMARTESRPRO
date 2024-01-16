<?php
require("../includes/lb_helper.php");
$installFile="../includes/.lic";
$errors = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Website Title -->
    <title>Script - Deactivator</title>

    <!-- Favicon --> 
    <link href="https://assets.nemosofts.com/install/logo.jpg" rel="icon" sizes="32x32">
    <link href="https://assets.nemosofts.com/install/logo.jpg" rel="icon" sizes="192x192">

    <!-- IOS Touch Icons -->
    <link rel="apple-touch-icon" href="https://assets.nemosofts.com/install/logo.jpg">
    <link rel="apple-touch-icon" sizes="152x152" href="https://assets.nemosofts.com/install/logo.jpg">
    <link rel="apple-touch-icon" sizes="180x180" href="https://assets.nemosofts.com/install/logo.jpg">
    <link rel="apple-touch-icon" sizes="167x167" href="https://assets.nemosofts.com/install/logo.jpg">
    
	<!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->  
    <link rel="stylesheet" href="https://assets.nemosofts.com/install/css/styles.css" media="all">    
    
    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<!-- Scripts -->
<script>
	window.onload = (event) => {
		var card = document.getElementById('card');
		card.classList.add('show');
	};
</script>


<body>
 	<div id="wrapper">
		<div class="container">
			<div class="setup">
                <div id="card" class="card">
					<div class="card__body">
					    <div class="card__image">
							<img src="https://assets.nemosofts.com/install/images/script.png" alt="">
						</div>
						<div class="card__content">
							<div class="card__content__head">
								<h3 class="card__title">
									<span>Script Deactivator</span>
								</h3>
							</div>
							<div class="card__fade">
							    <?php if(is_writeable($installFile)){ ?>
                                    <article class="message is-success">
                                        <div class="message-body">
                                            Click on deactivate license to deactivate and remove the currently installed license from this installation, So that you can activate the same license on some other domain.
                                        </div>
                                      </article>
                                <?php } ?>
                
								<?php
								
								    // Add or remove your script's requirements below
						            if(is_writeable($installFile)){
						                echo "<div class='notify notify--success mb-2' style'margin-bottom: 10px !important;'>
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'>
                                        <path fill='none' d='M0 0h24v24H0z'/>
                                        <path fill='currentColor' d='M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z'/>
                                        </svg> 
                                        <span class='notify__text'>Ready to Deactivate process</span>
                                        </div>";
                                    
                                    } else {
                                        echo "<div class='notify notify--error mb-2' style'margin-bottom: 10px !important;'>
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'>
                                        <path fill='none' d='M0 0h24v24H0z'/>
                                        <path fill='currentColor' d='M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z'/>
                                        </svg>
                                        <span class='notify__text'>The Deactivator process is already complete !</span>
                                        </div>";
                                    }
                                ?>
                                </br>
                                
                                <?php
                                    if(!empty($_POST)){
                                        $deactivate_password = strip_tags(trim($_POST["pass"]));
                                        $deactivate_response = deactivate_license($deactivate_password);
                                        if(empty($deactivate_response)){
                                            $msg='Server is unavailable.';
                                        }else{
                                            $msg=$deactivate_response['message'];
                                        }
                                        if($deactivate_response['status'] != true){ ?>
                                            <form action="index.php" method="POST">
                                                <div class="notification is-danger is-light"><?php echo ucfirst($msg); ?></div>
                                              <input type="hidden" name="something">
                                              <center>
                                                <?php if($errors==true){ ?>
            								        <button type="button" class="btn  btn--slide is-danger" style="min-width: 124px;" disabled>Deactivate License</button>
                                                <?php }else{ ?>
                                                    <button type="submit" class="btn btn--slide is-danger" style="min-width: 124px;">Deactivate License</button>
                                                <?php } ?>
                                              </center>
                                            </form><?php
                                        }else{ ?>
                                            <div class="notification is-success is-light"><?php echo ucfirst($msg); ?></div>
                                        <?php 
                                        }
                                    } else { ?>
                                      <form action="index.php" method="POST">
                                        <input type="hidden" name="something">
                                            <label for="code" class="form-label">Deactivate Password</label>
        									<div class="form-group">
        										<svg class="form-group__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
        											<path fill="none" d="M0 0h24v24H0z"/>
        											<path d="M12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976L12 1zm0 2.049L5 4.604v9.185a4 4 0 0 0 1.781 3.328L12 20.597l5.219-3.48A4 4 0 0 0 19 13.79V4.604L12 3.05zM12 7a2 2 0 0 1 1.001 3.732L13 15h-2v-4.268A2 2 0 0 1 12 7z"/>
        										</svg>
        										 <input class="form-control mb-8" type="text" id="pass" placeholder="Enter your deactivate password" name="pass" autocomplete="off" required>
        									</div>
                                        <center>
                                            <?php if($errors==true){ ?>
        								        <button type="button" class="btn  btn--slide is-danger" style="min-width: 124px;" disabled>Deactivate License</button>
                                            <?php }else{ ?>
                                                <button type="submit" class="btn  btn--slide is-danger" style="min-width: 124px;">Deactivate License</button>
                                            <?php } ?>
                                        </center>
                                      </form><?php 
                                    } ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>