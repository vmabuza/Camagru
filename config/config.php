<?php
//set if debug is on or off
define('DEBUG', false);
//default controller if none is given
define('DEFAULT_CONTROLLER', 'Home');
//if no layout is defined in the controller use this.
define('DEFAULT_LAYOUT', 'default');
//set to '/' for live server.
define('PROOT', '/camagru/');
//default site title
define('SITE_TITLE', 'Vmabuza MVC');
define('MENU_BRAND', 'Camagru'); //This is the brand text in the menu
//define hostname
define('HOST', 'localhost');
define('SQL_UNAME', 'root');
define('PASS', 'Bilberry@123');
define('DB_NAME', 'framework');

define('CURRENT_USER_SESSION_NAME', 'khgkhfhgjJKHGDHFJKHfhgfhjkKF'); //session name for logged in user
define('REMEMBER_ME_COOKIE_NAME', 'dhf;kldsjfl;kdjfl;kjdlfj;ldkjf;d'); //cookie name for logged in user 'remember me'
define('REMEMBER_COOKIE_EXPIRY', 604800); 

//controllername for the restricted controller.
define('ACCESS_RESTRICTED', 'Restricted');

define('PAGE_SIZE', 10);
define('LIKE_MAIL', 'like message');
define('COM_MAIL', 'comment maid');