<?php
session_start();

// Only logout if explicitly confirmed via query parameter or POST
if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    unset($_SESSION['staff_id']);
    unset($_SESSION['staff_number']);
    session_destroy();
    header("Location: pages_staff_index.php");
    exit;
}

// If crawler or user visits directly without ?confirm=true, bounce them back safely
header("Location: pages_dashboard.php");
exit;
