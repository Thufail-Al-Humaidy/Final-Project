<?php
require_once __DIR__ . '/../Classes/init.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION)) {
    session_destroy();
}

header('Location: ./../views/auth-page.php'); 
exit;
