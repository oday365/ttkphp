<?php
namespace TTkPHP;
class Log{
	static function write($log){
		error_log(date("[Y-m-d H:i:s]").$log.PHP_EOL, 3,LIB_PATH."log.txt");
	}
}