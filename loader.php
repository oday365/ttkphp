<?php
defined("LIB_PATH") or define("LIB_PATH",__DIR__.'/TTkPHP/');
defined("APP_DEBUG") or define("APP_DEBUG",true);
require_once(LIB_PATH."Common/functions.php");
require_once(LIB_PATH."Exception.class.php");
require_once(LIB_PATH."Log.class.php");
require_once(LIB_PATH."TTkPHP.class.php");
require_once(LIB_PATH."Db/Mysql.class.php");
TTkPHP\TTkPHP::boot();