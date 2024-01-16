<?php $page_title="Settings Extream codes";
    include("includes/header.php");
    require("includes/lb_helper.php");
    require("language/language.php");

    $qry="SELECT * FROM tbl_settings where id='1'";
    $result=mysqli_query($mysqli,$qry);
    $settings_data=mysqli_fetch_assoc($result);
    
    if(isset($_POST['app_submit'])){
        
        $data = array('is_xui_dns'  =>  ($_POST['is_xui_dns']) ? 'true' : 'false');
        $settings_edit = Update('tbl_settings', $data, "WHERE id = '1'");
        
        $_SESSION['msg'] = "11";
        $_SESSION['class'] = "success";
        header("Location:settings_xui.php");
        exit;
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
            
        <div class="card">
            <div class="card-body p-0">                    
                <div class="nsofts-setting">
                    <div class="nsofts-setting__sidebar">
                        <a class="d-inline-flex align-items-center text-decoration-none fw-semibold mb-4">
                            <span class="ps-2 lh-1"><?php echo (isset($page_title)) ? $page_title : "" ?></span>
                        </a>
                        <div class="nav flex-column nav-pills" id="nsofts_setting" role="tablist" aria-orientation="vertical">
                            
                            <button class="nav-link active" id="nsofts_setting_1" data-bs-toggle="pill" data-bs-target="#nsofts_setting_content_1" type="button" role="tab" aria-controls="nsofts_setting_2" aria-selected="true">
                                <i class="ri-settings-5-line"></i>
                                <span>DNS</span>
                            </button>
                            
                        </div>
                    </div>
                    <div class="nsofts-setting__content">
                        <div class="tab-content">
                            
                            <!--DNS Settings-->
                            <div class="tab-pane fade show active" id="nsofts_setting_content_1" role="tabpanel" aria-labelledby="nsofts_setting_1" tabindex="0">
                                <form action="" name="settings_app" method="POST" enctype="multipart/form-data">
                                    <h4 class="mb-4">DNS Settings</h4>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Active DNS</label>
                                        <div class="col-sm-10">
                                            <div class="nsofts-switch d-flex align-items-center">
                                                <input type="checkbox" id="is_xui_dns" name="is_xui_dns" value="true" class="cbx hidden" <?php if($settings_data['is_xui_dns']=='true'){ echo 'checked'; }?>/>
                                                <label for="is_xui_dns" class="nsofts-switch__label"></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" name="app_submit" class="btn btn-primary" style="min-width: 120px;">Save</button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</main>
<!-- End: main -->
<?php include("includes/footer.php");?>