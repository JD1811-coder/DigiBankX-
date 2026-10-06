<?php
function check_login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['client_id'])) {
        $host = $_SERVER['HTTP_HOST'];
        $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = "pages_client_index.php";
        header("Location: http://$host$uri/$extra");
        exit();
    }
}
