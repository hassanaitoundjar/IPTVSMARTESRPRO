



<?php
error_reporting(0);
ob_start();
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header("Content-Type: text/html;charset=UTF-8");

$common_db_details = [
    'DB_USER' => 'u775625162_iptvsmarters',
    'DB_PASSWORD' => '147Hassan@',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'u775625162_iptvsmarters',
];

if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.1.125") {
    // Localhost or development environment
    $db_details = $common_db_details;
} else {
    // Live server or production environment
    $db_details = $common_db_details;
    // You can override specific details for the live server if needed
}

foreach ($db_details as $constant => $value) {
    define($constant, $value);
}

$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_errno) {
    /* Use your preferred error logging method here */
    error_log('Connection error: ' . $mysqli->connect_errno);
} else {
    mysqli_query($mysqli, "SET NAMES 'utf8'");

    $setting_qry = "SELECT * FROM tbl_settings where id='1'";
    $setting_result = mysqli_query($mysqli, $setting_qry);
    $settings_details = mysqli_fetch_assoc($setting_result);

    define("APP_API_KEY", 'UzCbzsPZhsH8aeh1JlsK0gR0nYtmpgwcjtXm9g9lAUt4p');
    define("ONESIGNAL_APP_ID", $settings_details['onesignal_app_id']);
    define("ONESIGNAL_REST_KEY", $settings_details['onesignal_rest_key']);

    define("APP_NAME", $settings_details['app_name']);
    define("APP_LOGO", $settings_details['app_logo']);

    if (isset($_SESSION['id'])) {

        $profile_qry = "SELECT * FROM tbl_admin where id='" . $_SESSION['id'] . "'";
        $profile_result = mysqli_query($mysqli, $profile_qry);
        $profile_details = mysqli_fetch_assoc($profile_result);

        define("PROFILE_IMG", $profile_details['image']);
    }
}
?>
