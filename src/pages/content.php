<?php
$pg = $_GET['pg'] ?? '';

switch ($pg) {
    case '':
        include('./src/pages/home.php');
        break;
    case 'category' :
        include('./src/pages/categories.php');
        break;
    case 'post' :
        include('./src/pages/single_blog.php');
        break;
    case 'about-author' :
        include('./src/pages/about_author.php');
        break;
    case 'single_category' : 
        include('./src/pages/single_category.php');
        break;
    case 'contact-us' :
        include('./src/pages/contact_us.php');
        break;
    case 'about-us' :
        include('./src/pages/about_us.php');
        break;
}