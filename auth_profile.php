<?php 
    $page_title=(isset($_GET['user_id'])) ? 'Edit User' : 'Create User';
    include("includes/header.php");
    require("includes/lb_helper.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
    
    if(!isset($_SESSION['admin_type'])){
        if($_SESSION['admin_type'] == 0){
            session_destroy();
            header( "Location:index.php");
            exit;
        }
    }
    
    $page_save=(isset($_GET['user_id'])) ? 'Save' : 'Create';
    
    if(isset($_POST['submit']) and isset($_GET['add'])){
        
        if($_FILES['image']['name']!=""){
            
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image=rand(0,99999)."_admin.".$ext;
            $tpath1='images/'.$category_image;
            
            if($ext!='png')  {
                $pic1=compress_image($_FILES["image"]["tmp_name"], $tpath1, 80);
            } else {
                $tmp = $_FILES['image']['tmp_name'];
                move_uploaded_file($tmp, $tpath1);
            }
            
        } else {
            $image='';
        }
        
        if($_POST['password']!=""){
            $data = array( 
                'username'  =>  $_POST['username'],
                'email'  =>  $_POST['email'],
                'admin_type'  =>  $_POST['admin_type'],
                'password'  =>  md5(trim($_POST['password'])),
                'image'  =>  $image
            );
        } else {
            $data = array( 
                'username'  =>  $_POST['username'],
                'email'  =>  $_POST['email'],
                'admin_type'  =>  $_POST['admin_type'],
                'image'  =>  $image
            );
        }
        
        $qry = Insert('tbl_admin',$data);
        
        $_SESSION['msg']="10";
        $_SESSION['class']='success';
        header( "Location:manage_admin.php");
        exit;
    }
    
    if(isset($_GET['user_id'])){
        $qry="SELECT * FROM tbl_admin where id='".$_GET['user_id']."'";
        $result=mysqli_query($mysqli,$qry);
        $row=mysqli_fetch_assoc($result);
    }
    
    if(isset($_POST['submit']) and isset($_POST['user_id'])){
        
        if($_FILES['image']['name']!=""){
            
            if($row['image']!=""){
                unlink('images/'.$row['image']);
            }
            
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image=rand(0,99999)."_admin.".$ext;
            $tpath1='images/'.$category_image;
            
            if($ext!='png')  {
                $pic1=compress_image($_FILES["image"]["tmp_name"], $tpath1, 80);
            } else {
                $tmp = $_FILES['image']['tmp_name'];
                move_uploaded_file($tmp, $tpath1);
            }

        } else {
            $image = $row['image'];
        }
        
        if($_POST['password']!=""){
            $data = array( 
                'username'  =>  $_POST['username'],
                'email'  =>  $_POST['email'],
                'admin_type'  =>  $_POST['admin_type'],
                'password'  =>  md5(trim($_POST['password'])),
                'image'  =>  $image
            );
        } else {
            $data = array( 
                'username'  =>  $_POST['username'],
                'email'  =>  $_POST['email'],
                'admin_type'  =>  $_POST['admin_type'],
                'image'  =>  $image
            );
        }
        
        $category_edit=Update('tbl_admin', $data, "WHERE id = '".$_POST['user_id']."'");
        
        $_SESSION['msg']="11";
        $_SESSION['class']='success';
        header( "Location:auth_profile.php?user_id=".$_POST['user_id']);
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
            
        <div class="row g-4">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><?=$page_title ?></h5>
                        <form action="" name="addeditcategory" method="POST" enctype="multipart/form-data">
                            <input  type="hidden" name="user_id" value="<?=(isset($_GET['user_id'])) ? $_GET['user_id'] : ''?>" />
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Admin Type</label>
                                <div class="col-sm-10">
                                    <select name="admin_type" id="admin_type" class="form-control" required>
                                        <?php if(isset($_GET['user_id'])){ ?>
                                            <?php if($row['admin_type'] != '3') { ?>
                                                <option value="1" <?php if($row['admin_type']=='1'){?>selected<?php }?>>ADMIN</option>
                                                <option value="0" <?php if($row['admin_type']=='0'){?>selected<?php }?>>EDITOR</option>
                                            <?php } else { ?>
                                                <option value="3" <?php if($row['admin_type']=='3'){?>selected<?php }?>>SUPER ADMIN</option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="1">ADMIN</option>
                                            <option value="0">EDITOR</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">User name</label>
                                <div class="col-sm-10">
                                     <input type="text" name="username" class="form-control" value="<?php if(isset($_GET['user_id'])){echo $row['username'];}?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                     <input type="text" name="email" class="form-control" value="<?php if(isset($_GET['user_id'])){echo $row['email'];}?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                     <input type="text" name="password" id="password" class="form-control"  autocomplete="off" <?php if(!isset($_GET['user_id'])){?>required<?php } ?>>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Select Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control-file" name="image"   accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload" <?php if(!isset($_GET['user_id'])){?>required<?php } ?>>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                        <div class="fileupload_img" id="imagePreview">
                                            <?php if(isset($_GET['user_id'])) {?>
                                                <?php if($row['image']!='' AND file_exists('images/'.$row['image'])) {?>
                                                    <img class="col-sm-2 img-thumbnail" type="image" src="images/<?php echo $row['image'];?>" alt="image" />
                                                <?php } else {?>
                                                  <img class="col-sm-2 img-thumbnail" type="image" src="assets/images/300x300.jpg" alt="image" />
                                                <?php } ?>
                                            <?php } else {?>
                                              <img class="col-sm-2 img-thumbnail" type="image" src="assets/images/300x300.jpg" alt="image" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                        <button type="submit" name="submit" class="btn btn-primary" style="min-width: 120px;"><?=$page_save?></button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- End: main -->
    
<?php include("includes/footer.php");?> 