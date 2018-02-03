<?php
define('PATH',dirname(__FILE__).'/../');
define('APP',PATH.'app/');
date_default_timezone_set('PRC');
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors','On');

//加载函数
require PATH.'function.php';

//加载核心文件
require PATH.'bootstrap.php';

//加载Autoload
require PATH.'vendor/autoload.php';

//允许跨域
header("Access-Control-Allow-Origin: *");

//根据命名空间自动加载php文件
spl_autoload_register('bootstrap::autoload');

bootstrap::run();
