<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'yytest');
define('DB_USER', 'yytest');
define('DB_PASS', 'yytest');
define('DB_TABLE_BANNERS_LOGS', 'banners_logs');

require_once '../classes/DbHelper.php';
require_once '../classes/BannerHelper.php';
require_once '../classes/UserHelper.php';

@error_reporting(E_ALL);
@ini_set('display_errors', true);
@ini_set('html_errors', true);
@ini_set('error_reporting', E_ALL); // E_ALL, E_STRICT

//date_default_timezone_set('Europe/Kiev');
date_default_timezone_set('UTC');
