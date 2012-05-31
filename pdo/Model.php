<?php 

require_once "DatabasePDO.php"; 

class Model {
	
	static $dbConn = null;
	
	static function connect ()
	{
	        if (is_null(self::$dbConn)) {
	            self::$dbConn = DatabasePDO::getInstance();
	        }
	}
	
	static function utf8 ()
	{
	    $statement = self::$dbConn->prepare("SET NAMES utf8");
		$statement->execute();
	}
	
}