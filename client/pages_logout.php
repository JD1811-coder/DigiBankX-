<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only logout if explicitly requested with ?confirm=true
if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    unset($_SESSION['client_id']);
    unset($_SESSION['name']);
    session_destroy();
    header("Location: pages_client_index.php");
    exit();
}

// If an automated scanner hits this endpoint without ?confirm=true, keep session safe
header("Location: pages_dashboard.php");
exit();
