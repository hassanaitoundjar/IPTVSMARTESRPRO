<?php 
    $page_title='Envato Verify Purchase';
    include("includes/header.php");
    require("includes/lb_helper.php");
    require("language/language.php");
    
    if(!isset($_SESSION['admin_type'])){
        if($_SESSION['admin_type'] == 0){
            session_destroy();
            header( "Location:index.php");
            exit;
        }
    }
    
    $qry="SELECT * FROM tbl_settings where id='1'";
    $result=mysqli_query($mysqli,$qry);
    $settings_row=mysqli_fetch_assoc($result);
    
    if(isset($_POST['submit'])){
        
        $key = generateStrongPassword();
        
        $envato = verify_envato_purchase_code(trim($_POST['envato_purchase_code']), '47641297');
        
        if($envato['status'] != true){
            
            $data = array(
                'envato_buyer_name' => trim($_POST['envato_buyer_name']),
                'envato_purchase_code' => trim($_POST['envato_purchase_code']),
                'envato_package_name' => trim($_POST['envato_package_name'])
            );
            
            $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");
            
            $_SESSION['class']="error";
            $_SESSION['msg']="18";
            header( "Location:verification.php");
            exit;
            
        } else {
            
            $apikey = $key;
            
            $verify_server = verify_license_android(trim($_POST['envato_purchase_code']), $apikey, trim($_POST['envato_package_name']));
            
            if($verify_server['status'] != true){
                $data = array(
                    'envato_buyer_name' => trim($_POST['envato_buyer_name']),
                    'envato_purchase_code' => trim($_POST['envato_purchase_code']),
                    'envato_package_name' => trim($_POST['envato_package_name'])
                );
                
                $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");
                
                $_SESSION['class']="error";
                $_SESSION['msg']="18";
            } else {
                $data = array(
                    'envato_buyer_name' => trim($_POST['envato_buyer_name']),
                    'envato_purchase_code' => trim($_POST['envato_purchase_code']),
                    'envato_api_key' => $apikey,
                    'envato_package_name' => trim($_POST['envato_package_name'])
                );
                
                $settings_edit =Update('tbl_settings', $data, "WHERE id = '1'");
                 
                $_SESSION['class']="success";
                $_SESSION['msg']="19";
            }
            header( "Location:verification.php");
            exit;
            
        }
    }
    
?>

<!-- Start: main -->
<main id="nsofts_main">
    <div class="nsofts-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center">
                <li class="breadcrumb-item d-inline-flex"><a href="dashboard.php"><i class="ri-home-4-fill"></i></a></li>
                <li class="breadcrumb-item d-inline-flex active" aria-current="page"><?php echo (isset($page_title)) ? $page_title : "" ?></li>
            </ol>
        </nav>
            
        <div class="row g-4">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><?=$page_title ?></h5>
                        <form action="" name="addverify" method="POST" enctype="multipart/form-data">
 
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Envato Username</label>
                                <div class="col-sm-10">
                                     <input type="text" name="envato_buyer_name" class="form-control" placeholder="Enter your envato user name" value="<?php echo $settings_row['envato_buyer_name'];?>" autocomplete="off" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Envato Purchase Code</label>
                                <div class="col-sm-10">
                                    <input type="text" name="envato_purchase_code"class="form-control" placeholder="Enter your item purchase code" value="<?php echo $settings_row['envato_purchase_code'];?>" autocomplete="off" required>
                                    <small id="sh-text1" class="form-text text-muted"><a style="color: #f44336c7;" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where Is My Purchase Code?</a></small>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">ApiKey</label>
                                <div class="col-sm-10">
                                    <input type="text" name="envato_api_key" class="form-control" placeholder="<?php echo $settings_row['envato_api_key'];?>"  disabled readonly>
                                    <small id="sh-text1" class="form-text text-muted col-md-6" style="padding: 0px;">Click the Save button This key will be generated automatically.</small>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Android Package Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="envato_package_name"class="form-control" placeholder="Enter your android application id" value="<?php echo $settings_row['envato_package_name'];?>" autocomplete="off" required>
                                    <small id="sh-text1" class="form-text text-muted">(More info in Android Doc)</small>
                                </div>
                            </div>
                            
                            <button type="submit" name="submit" class="btn btn-primary" style="min-width: 120px;">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-3">License</h5>
                        
                        <div class="alert alert-primary alert-dismissible" role="alert">
                          <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Regular License</h6>
                          <p class="mb-0">Only one app can be active at a time. If you register new package name previous app cant be access by users.</p>
                        </div>
                        
                        <div class="alert alert-primary alert-dismissible" role="alert">
                          <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Extended License</h6>
                          <p class="mb-0">Unlimited apps can be created and publish at same time.</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</main>
<!-- End: main -->
    
<?php include("includes/footer.php");?> 