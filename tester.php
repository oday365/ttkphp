<?php
require_once("loader.php");
$config=array(
		'host'=>'127.0.0.1',
		'username'=>'root',
		'password'=>'123456',
		'database'=>'it70'
);
$mysql=new \TTkPHP\Db\Mysql($config);
$sql="SELECT * FROM it_article LIMIT 10";
$rows=$mysql->query($sql);
echo $mysql->queryCount."<br>";
var_dump($rows);
