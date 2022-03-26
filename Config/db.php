<?php

class Database
{
    private static $bdd = null;

    private function __construct() {
    }

    /** Gets the connection object needed for any database transaction
     * 
     * @return PDO database connection object
     */
    public static function getBdd() {
        $config = parse_ini_file(ROOT . "Config/config.ini");
        
        if(is_null(self::$bdd)) {
            self::$bdd = new PDO("mysql:host=".$config["DB_HOST"].";dbname=".$config["DB_NAME"], $config["DB_USER"], $config["DB_PASS"]);
        }

        return self::$bdd;
    }
}
?>