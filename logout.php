<?php
session_start();
unset($_SESSION["admin_name"]);
unset($_SESSION["admin_type"]);
session_destroy();
header( "Location:index.php");
exit;
?>