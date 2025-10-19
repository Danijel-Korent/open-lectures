<?php
//Database Class
class Database {
    public static $database = null;

    public static function initialize() {
        mysqli_report(MYSQLI_REPORT_OFF);
		// Database Connection
        // SECURITY ISSUE: HARDCODED DATABASE CREDENTIALS
        // Credentials are exposed in source code and version control
        // FIX: Use environment variables or config files outside web root
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

    public static function fetch_assoc($res) {
       $arr =[];
		while($row = $res->fetch_assoc()){
			$arr[] = $row;
		}
		return $arr;
    }

    public static function error() {
        return self::$database->error;
    }
}

// SQLite Database Class
class DatabaseSqlite {
    public static $database = null;

    public static function initialize() {
        $db_path = defined('SITE_PATH') ? SITE_PATH . '/database/op.sqlite' : __DIR__ . '/op.sqlite';
        $db_exists = file_exists($db_path);

        // Create database connection
        self::$database = new \SQLite3($db_path);
        if (!self::$database) {
            die('The connection to the SQLite database failed!');
        }

        // If the DB didn't exist before, set permissions and load schema
        if (!$db_exists) {
            chmod($db_path, 0666); // Full read/write

            $sql_file = defined('SITE_PATH') ? SITE_PATH . '/database/sqlite_schema.sql' : __DIR__ . '/sqlite_schema.sql';
            if (file_exists($sql_file)) {
                $sql = file_get_contents($sql_file);
                if (!$sql) {
                    die('Failed to read schema file.');
                }

                // Split and execute each SQL statement
                foreach (explode(';', $sql) as $statement) {
                    $stmt = trim($statement);
                    if ($stmt) {
                        $result = self::$database->exec($stmt);
                        if (!$result) {
                            die('Error executing schema statement: ' . self::$database->lastErrorMsg());
                        }
                    }
                }

                chmod($db_path, 0666); // Ensure it's still writable
            } else {
                die('SQLite schema file not found: ' . $sql_file);
            }
        }

        return self::$database;
    }

    public static function fetch_assoc($res) {
        $arr = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $arr[] = $row;
        }
        return $arr;
    }

    public static function error() {
        $error = self::$database->lastErrorMsg();
        return ($error === 'not an error') ? '' : $error;
    }

}

// Unified Statement Wrapper
class DBStatement {
    private $stmt;
    private $dbType;
    private $db;
    public $error = '';
    public $insert_id = null;

    public function __construct($stmt, $dbType, $db) {
        $this->stmt = $stmt;
        $this->dbType = $dbType;
        $this->db = $db;
    }

    // Unified bind_param: for SQLite, ignore type string and use 1-based index
    public function bind_param($types, &...$vars) {
        if ($this->dbType === 'sqlite') {
            for ($i = 0; $i < count($vars); $i++) {
                $this->stmt->bindValue($i + 1, $vars[$i]);
            }
        } else {
            $this->stmt->bind_param($types, ...$vars);
        }
    }

    public function execute() {
        if ($this->dbType === 'sqlite') {
            $result = $this->stmt->execute();
            if ($result === false) {
                $this->error = $this->db->lastErrorMsg();
            } else {
                $this->insert_id = $this->db->lastInsertRowID();
            }
            return $result;
        } else {
            $result = $this->stmt->execute();
            $this->error = $this->stmt->error;
            $this->insert_id = $this->db->insert_id;
            return $result;
        }
    }

    public function __get($name) {
        // Allow access to error and insert_id
        if ($name === 'error') return $this->error;
        if ($name === 'insert_id') return $this->insert_id;
        return null;
    }
}

//Database global function
class DBClass {
    public static $db = null;
    
    public static function initialize() {
        if (defined('DB') && DB === 'sqlite') {
            if (!\DatabaseSqlite::$database) {
                \DatabaseSqlite::initialize();
            }
            self::$db = \DatabaseSqlite::$database;
        } else {
            if (!\Database::$database) {
                \Database::initialize();
            }
            self::$db = \Database::$database;
        }
    }
    
    public static function query($sql) {
        if (!self::$db) {
            self::initialize();
        }
        return self::$db->query($sql);
    }
    
    public static function prepare($sql) {
        if (!self::$db) {
            self::initialize();
        }
        $dbType = (defined('DB') && DB === 'sqlite') ? 'sqlite' : 'mysql';
        $stmt = self::$db->prepare($sql);
        return new DBStatement($stmt, $dbType, self::$db);
    }
    
    public static function error() {
        if (!self::$db) {
            self::initialize();
        }
        if (defined('DB') && DB === 'sqlite') {
            $error = self::$db->lastErrorMsg();
            return ($error === 'not an error') ? '' : $error;
        } else {
            return self::$db->error;
        }
    }
    
    public static function insert_id() {
        if (!self::$db) {
            self::initialize();
        }
        if (defined('DB') && DB === 'sqlite') {
            return self::$db->lastInsertRowID();
        } else {
            return self::$db->insert_id;
        }
    }
    
    public static function fetch_assoc($result) {
        if (!$result) return [];
        
        $arr = [];
        if (defined('DB') && DB === 'sqlite') {
            // SQLite result
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $arr[] = $row;
            }
        } else {
            // MySQL result
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
        return $arr;
    }
    
    public static function fetch_single($result) {
        if (!$result) return null;
        
        if (defined('DB') && DB === 'sqlite') {
            // SQLite result
            return $result->fetchArray(SQLITE3_ASSOC);
        } else {
            // MySQL result
            return $result->fetch_assoc();
        }
    }
}

//Database global function
function db() {
    if (!DBClass::$db) {
        DBClass::initialize();
    }
    return DBClass::$db;
}