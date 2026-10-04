<?php
$host   = "gateway01.ap-northeast-1.prod.aws.tidbcloud.com";
$port   = 4000;
$dbuser = "4695f95N4JfHCH1.root";
$dbpass = "yT4CGwaysxeuZj2C";
$db     = "internetbanking";

$mysqli = mysqli_init();

// Enable SSL encryption (required for TiDB Cloud Serverless)
$mysqli->ssl_set(NULL, NULL, NULL, NULL, NULL);

// Establish the connection
if (!@$mysqli->real_connect($host, $dbuser, $dbpass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Database Connection failed: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['admin_level'] = 'staff';