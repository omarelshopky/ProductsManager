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
            self::$bdd = new PDO("mysql:host=".$GLOBALS["DB_HOST"].";dbname=".$GLOBALS["DB_NAME"], $GLOBALS["DB_USER"], $GLOBALS["DB_PASS"]);
        }

        return self::$bdd;
    }
}
?>