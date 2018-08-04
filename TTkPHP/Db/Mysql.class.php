<?php
namespace TTkPHP\Db;

class Mysql {
    private $_id;
    public $queryCount;
    public $executeCount;
	protected $config=array(
		'host'=>'127.0.0.1',
		'username'=>'',
		'password'=>'',
		'database'=>'',
		'charset'=>'utf8'
	);
    public function __construct($config2=array()) {
        $this->queryCount=0;
        $this->executeCount=0;
        $this->config=array_merge($this->config,$config2);
        $this->connect($this->config['host'],$this->config['username'],$this->config['password']);
        $this->useDb($this->config['database']);
        $this->setCharset($this->config['charset']);
    }
    private function connect($h,$u,$p) {
        $this->_id = mysql_connect($h,$u,$p);
    }
    public function doQuery($sql) {
        return mysql_query($sql,$this->_id);
    }
    public function useDb($db) {
        $sql = 'use ' . $db;
        $this->doQuery($sql);
    }
    public function setCharset($char) {
        $sql = 'set names ' .  $char;
        $this->doQuery($sql);
    }
	public function query($sql){
        $this->queryCount+=1;
		$rows=array();
		$result=$this->doQuery($sql);
		if(!$result){
			return $rows;
		}
		while($row=mysql_fetch_assoc($result)){
			$rows[]=$row;
		}
		return $rows;
	}
	public function execute($sql){
        $this->executeCount+=1;
		return $this->doQuery($sql);
	}
    public function close() {
        mysql_close($this->_id);
    }
}