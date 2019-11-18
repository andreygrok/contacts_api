<?php

namespace app\db;

class DbConnect
{
    private static $_instance = null;

    const DB_HOST = 'localhost';
    const DB_NAME = 'db name';
    const DB_USER = 'db user';
    const DB_PASS = 'user pass';

	private function __construct () {

        $this->_instance = new \PDO(
            'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME,
            self::DB_USER,
            self::DB_PASS,
            [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
        );

    }

	public static function getInstance()
    {
        if (self::$_instance != null) {
            return self::$_instance;
        }

        return new self;
    }

    public function query($sql)
    {
        $result = $this->_instance->query($sql);
        
        return $result;
    }
}
