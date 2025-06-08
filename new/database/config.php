<?php
//Database Class
class Database {
    public static $database = null;
    public static $db = null;

    public static function initialize() {
        mysqli_report(MYSQLI_REPORT_OFF);
		// Database Connection
        self::$database = new \mysqli(
            'localhost',
            'root',
            '',
            'op'
        );

        /* Debugging */
        if(self::$database->connect_error) {
            die('The connection to the database failed! Check the config.php file and make sure your database connection details are correct and your server is running.');
        }

        self::$database->set_charset('utf8mb4');

        return self::$database;
    }

   
    public static function close() {

        if(!self::$database) return;

        self::$database->close();
    }
}
//Database global function
function db() {
    if(!\Database::$database) {
        \Database::initialize();
    }
    return \Database::$database;
}