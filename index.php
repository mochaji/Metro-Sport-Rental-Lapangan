<?php
require_once('config/connection.php');
require_once('helpers/helpers.php');
// Page content
$app_logo = mysqli_fetch_array(mysqli_query($connect,"SELECT data from global_variable where variable = 'app_logo'"));
$app_name = mysqli_fetch_array(mysqli_query($connect,"SELECT data from global_variable where variable = 'app_name'"));

require_once('app/auth/check_login.php');
require_once('pages/layout/header.php');
require_once('pages/layout/sidebar.php');
require_once('routes/routes.php');
require_once('pages/layout/footer.php'); 
?>