<?php $page_title="Dashboard";
    include("includes/header.php");
    require("includes/lb_helper.php");

    $qry_admin="SELECT COUNT(*) as num FROM tbl_admin";
    $total_admin = mysqli_fetch_array(mysqli_query($mysqli,$qry_admin));
    $total_admin = $total_admin['num'];

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
            <style>
                .nsofts-icon i {
                    font-size: 45px;
                }
                .social_img {
                    position: absolute;
                    width: 20px !important;
                    height: 20px !important;
                    z-index: 1;
                    left: 13px;
                }
            </style>
 
            <div class="col-xxl-3 col-md-6">
                <div class="card card-raised border-start border-success border-4">
                    <div class="card-body px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-2">
                                <div class="display-6"><?php echo thousandsNumberFormat($total_admin); ?></div>
                                <div class="d-block mb-1 text-muted">Admin Users</div>
                            </div>
                            <div class="d-inline-flex text-success nsofts-icon"><i class="ri-admin-line"></i></div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</main>
<!-- End: main -->
<?php include("includes/footer.php");?> 