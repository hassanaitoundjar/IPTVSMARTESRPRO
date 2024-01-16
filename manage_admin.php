<?php $page_title="Manage Admin Users";
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
    
    $tableName="tbl_admin";   
    $targetpage = "manage_admin.php"; 
    $limit = 15; 
    $keyword='';
    
    if(!isset($_GET['keyword'])){
        $query = "SELECT COUNT(*) as num FROM $tableName";
        
    } else{
    
        $keyword=addslashes(trim($_GET['keyword']));
        $query = "SELECT COUNT(*) as num FROM $tableName WHERE (`username` LIKE '%$keyword%' OR `email` LIKE '%$keyword%')";
        $targetpage = "manage_admin.php?keyword=".$_GET['keyword'];
    }
    
    $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
    $total_pages = $total_pages['num'];
    
    $stages = 3;
    $page=0;
    if(isset($_GET['page'])){
        $page = mysqli_real_escape_string($mysqli,$_GET['page']);
    }
    if($page){
        $start = ($page - 1) * $limit; 
    }else{
        $start = 0; 
    } 
    
    if(!isset($_GET['keyword'])){
        $sql_query="SELECT * FROM tbl_admin ORDER BY tbl_admin.`id` DESC LIMIT $start, $limit"; 
    }
    else{
        $sql_query="SELECT * FROM tbl_admin WHERE (`username` LIKE '%$keyword%' OR `email` LIKE '%$keyword%') ORDER BY tbl_users.`id` DESC LIMIT $start, $limit"; 
    }
    $result=mysqli_query($mysqli,$sql_query) or die(mysqli_error($mysqli));
    
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
            
        <div class="card h-100">
            <div class="card-header d-md-inline-flex align-items-center justify-content-between py-3 px-4">
                <a href="<?php echo (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : "dashboard.php" ?>" class="d-inline-flex align-items-center text-decoration-none fw-semibold nsofts-link">
                    <i class="ri-arrow-left-line text-danger fw-bold"></i>
                    <span class="ps-2 lh-1"><?=$page_title ?></span>
                </a>
                <span class="ps-2 lh-1">Total Users (<?=$total_pages ?>)</span>
                <div class="d-flex mt-2 mt-md-0">
                    <form method="get" id="searchForm" action="" class="me-2">
                        <div class="input-group">
                            <input type="text" id="search_input" class="form-control" placeholder="Search here..." name="keyword" value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword'];} ?>" required="required">
                            <button class="btn btn-outline-default d-inline-flex align-items-center" type="search">
                                <i class="ri-search-2-line"></i>
                            </button>
                        </div>
                    </form>
                    <a href="auth_profile.php?add=yes" class="btn btn-primary d-inline-flex align-items-center justify-content-center">
                        <i class="ri-add-line"></i>
                        <span class="ps-1 text-nowrap d-none d-sm-block">Create User</span>
                    </a>
                </div>
            </div>
            
            <div class="card-body p-4">
                <?php if(mysqli_num_rows($result) > 0){ ?>
                    <div class="row g-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Status</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; while($row=mysqli_fetch_array($result)) { ?>
                                    <tr>
                                        <td>
                                            <div class="text-center">
                                        	    <?php if($row['image']!="" AND file_exists("images/".$row['image'])){?>
                                                    <img src="images/<?php echo $row['image']?>"alt="">
                                                <?php } else {?>
                                                    <img src="assets/images/user_photo.png" alt="">
                                                <?php }?>
                                            </div>
                                        </td>
                                        
                                        <td><?php echo $row['username'];?></td>
                                        <td><?php echo $row['email'];?></td>
                                        
                                        <td class="text-center">
                                            <?php if($row['admin_type'] == '3') { ?>
                                                <span class="nsofts-badge nsofts-badge-primary">SUPER ADMIN</span>
                                            <?php } else if($row['admin_type'] == '1') { ?>
                                                <span class="nsofts-badge nsofts-badge-primary">ADMIN</span>
                                            <?php } else if($row['admin_type'] == '0') { ?>
                                                <span class="nsofts-badge nsofts-badge-primary">EDITOR</span>
                                            <?php } ?>
                                        </td>
                                        
                                        <td class="text-center" >
                                            <?php if($row['admin_type'] == '3') { ?>
                                                <div class="nsofts-switch" data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                    
                                                </div>
                                            <?php } else { ?>
                                                <div class="nsofts-switch enable_disable" data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                    <input type="checkbox" id="enable_disable_check_<?= $i ?>" data-id="<?= $row['id'] ?>" data-table="<?=$tableName ?>" data-column="status" class="cbx hidden btn_enable_disable" <?php if ($row['status'] == 1) { echo 'checked'; } ?>>
                                                    <label for="enable_disable_check_<?= $i ?>" class="nsofts-switch__label"></label>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        
                                        <td class="text-center">
                                            <a href="auth_profile.php?user_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-icon" style="padding: 10px 10px !important;  margin-right: 10px !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <?php if($row['admin_type'] == '3') { ?>
                                                <a class="btn btn-secondary btn-icon" style="padding: 10px 10px !important;">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0)" class="btn btn-danger btn-icon btn_delete" data-id="<?php echo $row['id'];?>" data-table="<?=$tableName ?>" style="padding: 10px 10px !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                 <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                     <?php include("pagination.php"); ?>
                <?php } else { ?>
                
                    <ul class="p-5">
                        <h1 class="text-center">No data found</h1>
                    </ul>
                    
                <?php } ?>
                </nav>
            </div>
        </div>
        
        
    </div>
</main>
<!-- End: main -->
    
<?php include("includes/footer.php");?> 