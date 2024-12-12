<?php
require_once __DIR__ . '/../Classes/init.php';

if (!isset($_GET['pg'])) {
    $pg = '';
}
$sesi = isset($_SESSION['user']) ? $_SESSION['user'] : '';

switch ($pg) {
    case '':
        $current_page = basename($_SERVER['PHP_SELF']);

        if ($current_page == 'index.php') {
            include('home.php');
        } elseif ($current_page == 'auth-page.php') {
            include('./../services/signin.php');
        }
        break;
    case 'signup':
        include('./../services/signup.php');
        break;
    case 'category':

        if (!isset($_GET['id'])) {
            include('./../services/add_category.php');
        } else {
            include('./../services/edit_category.php');
        }
        break;
    case 'tags':
        if (!isset($_GET['id'])) {
            include('./../services/add_tags.php');
        } else {
            include('./../services/edit_tags.php');
        }
        break;
    case 'profile':
        include('./../services/profile.php');
        break;
    case 'edit-profile':
        include('./../services/edit-profile.php');
        break;
    case 'posts':
        include('./../services/add_post.php');
        break;
    case 'edit_post':
        include('./../services/edit_post.php');
        break;
    default:
        include('./../404.html');
        break;
}