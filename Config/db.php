<?php

class Database
{
    private static $bdd = null;

    // private function __construct() {
    // }

    /** Gets the connection object needed for any database transaction
     * 
     * @return PDO database connection object
     */
    public static function getBdd() {
        
        if(is_null(self::$bdd)) {
            self::$bdd = new PDO("mysql:host=".$GLOBALS["config"]["DB_HOST"].";dbname=".$GLOBALS["config"]["DB_NAME"], $GLOBALS["config"]["DB_USER"], $GLOBALS["config"]["DB_PASS"]);
        }

        return self::$bdd;
    }
}
?>