<?php
class Connection
{
    private static $_instance = null;

	public function __construct()
	{
		self::$_instance = $this->realConnect();
	}

	public static function connect()
	{
		if (!self::$_instance instanceof Connection && self::$_instance == null) {
			new Connection();
		}

		return self::$_instance;
	}

	protected function realConnect()
	{
		$dbh = new PDO('mysql:host=' . \Login\Database\HOST . ';dbname=' . \Login\Database\NAME, \Login\Database\LOGIN, \Login\Database\PASSWORD);
		return $dbh;
	}
}