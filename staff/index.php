<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If staff member is already logged in, redirect straight to dashboard
if (isset($_SESSION['staff_id']) || isset($_SESSION['staff_number'])) {
    header("Location: pages_dashboard.php");
    exit;
}

// Otherwise redirect to the staff login page
header("Location: pages_staff_index.php");
exit;
