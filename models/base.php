<?php

class Model_Base
{
	protected static $_db;

	public static function set_db(PDO $db) {
		self::$_db = $db;
	}
}
