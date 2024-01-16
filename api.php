<?php 
include("includes/db_helper.php");
include("includes/lb_helper.php"); 
include("language/api_language.php"); 

error_reporting(0);

$file_path = getBaseUrl();

$mysqli->set_charset('utf8mb4');

date_default_timezone_set("Asia/Colombo");

define("PACKAGE_NAME",$settings_details['envato_package_name']);

// For Api header
$API_NAME = 'NEMOSOFTS_APP';

// // Purchase code verification
// if($settings_details['envato_buyer_name']=='' OR $settings_details['envato_purchase_code']=='' OR $settings_details['envato_api_key']=='') {
//     $set[$API_NAME][]=array('MSG'=> 'Purchase code verification failed!','success'=>'0');
// 	header( 'Content-Type: application/json; charset=utf-8' );
// 	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
// 	die();
// }

$get_helper = get_api_data($_POST['data']);

// App details
if($get_helper['helper_name']=="app_details"){
    
    $jsonObj= array();
	$data_arr= array();
    
    $sql="SELECT * FROM tbl_settings WHERE id='1'";
    $result = mysqli_query($mysqli, $sql);
    while($data = mysqli_fetch_assoc($result)){
        
        // App Details
        $data_arr['app_email'] = $data['app_email'];
        $data_arr['app_author'] = $data['app_author'];
        $data_arr['app_contact'] = $data['app_contact'];
        $data_arr['app_website'] = $data['app_website'];
        $data_arr['app_description'] = $data['app_description'];
        $data_arr['app_developed_by'] = $data['app_developed_by'];
        
        // Envato
        $data_arr['envato_api_key'] = $data['envato_api_key'];
        
        // is_
        $data_arr['is_rtl'] = $data['is_rtl'];
        $data_arr['is_maintenance'] = $data['is_maintenance'];
        $data_arr['is_screenshot'] = $data['is_screenshot'];
        $data_arr['is_apk'] = $data['is_apk'];
        $data_arr['is_vpn'] = $data['is_vpn'];
        $data_arr['is_xui_dns'] = $data['is_xui_dns'];
        
        // AppUpdate
        $data_arr['app_update_status'] = $data['app_update_status'];
        $data_arr['app_new_version'] = $data['app_new_version'];
        $data_arr['app_update_desc'] = $data['app_update_desc'];
        $data_arr['app_redirect_url'] = $data['app_redirect_url'];
        
        // Custom Ads
        $data_arr['custom_ads'] = $data['custom_ads'];
        $data_arr['custom_ads_clicks'] = $data['custom_ads_clicks'];
        
        // App Themes
        $data_arr['is_theme'] = $data['is_theme'];
        
        array_push($jsonObj,$data_arr);
    }
    $row['details'] = $jsonObj;
    
    mysqli_free_result($result);
	$jsonObj = array();
	$data_arr = array();
	
	$sql="SELECT * FROM tbl_xui_dns WHERE tbl_xui_dns.status='1' ORDER BY tbl_xui_dns.id DESC";
    $result = mysqli_query($mysqli, $sql);
    while ($data = mysqli_fetch_assoc($result)){
        
        $data_arr['id'] = $data['id'];
        $data_arr['dns_title'] = $data['dns_title'];
        $data_arr['dns_base'] = $data['dns_base'];
        
		array_push($jsonObj, $data_arr);
	}
	$row['xui_dns'] = $jsonObj;

    mysqli_free_result($result);
	$jsonObj = array();
	$data_arr = array();
	
	$sql="SELECT * FROM tbl_custom_ads WHERE tbl_custom_ads.status='1' AND tbl_custom_ads.ads_type ='popup' ORDER BY RAND() DESC LIMIT 1";
    $result = mysqli_query($mysqli, $sql);
    while ($data = mysqli_fetch_assoc($result)){
        
        $data_arr['ads_type'] = $data['ads_type'];
        $data_arr['ads_title'] = $data['ads_title'];
        $data_arr['ads_image'] =  $file_path.'images/'.$data['ads_image'];
        $data_arr['ads_redirect_type'] = $data['ads_redirect_type'];
        $data_arr['ads_redirect_url'] = $data['ads_redirect_url'];
        
		array_push($jsonObj, $data_arr);
	}
	$row['popup_ads'] = $jsonObj;
	
    $set[$API_NAME] = $row;
	header( 'Content-Type: application/json; charset=utf-8' );
    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
}

else if($get_helper['helper_name']=="get_interstitial") {

	$jsonObj= array();	

    $sql="SELECT * FROM tbl_custom_ads WHERE tbl_custom_ads.status='1' AND tbl_custom_ads.ads_type ='interstitial' ORDER BY RAND() DESC LIMIT 1";
	$result = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	while($data = mysqli_fetch_assoc($result)){
	    
      	$row['ads_image'] = $file_path.'images/'.$data['ads_image'];
      	$row['ads_redirect_type'] = $data['ads_redirect_type'];
      	$row['ads_redirect_url'] = $data['ads_redirect_url'];
		
		array_push($jsonObj,$row);
	}
	   
	$set[$API_NAME] = $jsonObj;
	header( 'Content-Type: application/json; charset=utf-8' );
    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
}
else {
    $get_helper = get_api_data($_POST['data']);
}