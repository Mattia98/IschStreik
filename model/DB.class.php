<?php
// DB Singleton

class DB {
	private static $db = null;

	// Make constructor private so it can't be accessed
	private function __construct() {
		;
	}

	public static function getDB() {
		if (self::$db == null) {
			try {
				$host = getenv("DB_HOST") ?: 'localhost';
				$passwd = getenv("DB_PASSWD") ?: 'Nilpferd62!';
				
				self::$db = new PDO('pgsql:host='.$host.';dbname=ischstreik', 'ischstreik', $passwd);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->exec("SET datestyle TO European;");
			}
			catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		return self::$db;
	}

}
?>
