<?php

if (getcwd() == dirname(__FILE__)) {
    require '../System/ErrorPage.php';
    die(ShowError());
}
include __DIR__ . '/SQLEXECUTE.php';

class SQLClass {

    // Base variables
    public $lastError;         // Holds the last error
    public $lastQuery;         // Holds the last query
    public $result;            // Holds the MySQL query result
    public $records;           // Holds the total number of records returned
    public $affected;          // Holds the total number of records affected
    public $rawResults;        // Holds raw 'arrayed' results
    public $arrayedResult;     // Holds an array of the result
    private $CreateDB = null;
    protected $hostname;          // MySQL Hostname
    protected $username;          // MySQL Username
    protected $password;          // MySQL Password
    protected $database;          // MySQL Database
    protected $databaseLink;      // Database Connection Link

    /*     * ******************
     * Class Constructor *
     * ****************** */

    function __construct($database, $username, $password, $hostname = 'localhost', $port = 3306, $persistant = false) {
        if (getcwd() == dirname(__FILE__)) {
            die(ShowError());
        }
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->hostname = $hostname . ':' . $port;
        $this->CreateDB = new SQLEXECUTE();
        return $this->Connect($persistant);
    }

    /*     * ******************
     * Class Destructor  *
     * ****************** */

    function __destruct() {
        $this->closeConnection();
        unset($this->lastError);
        unset($this->CreateDB);
        unset($this->Filter);
        unset($this->affected);
        unset($this->arrayedResult);
        unset($this->database);
        unset($this->databaseLink);
        unset($this->hostname);
        unset($this->lastQuery);
        unset($this->rawResults);
        unset($this->records);
        unset($this->result);
    }

//    function __sleep() {
//        $this->ReturnError();
//    }
//
//    function __wakeup() {
//        $this->Connect();
//    }

    /*     * ******************
     * Private Functions *
     * ****************** */

    // Connects class to database
    // $persistant (boolean) - Use persistant connection?
    private function Connect($persistant = false) {

//        $this->CloseConnection();

        if ($persistant) {
            $this->databaseLink = mysql_pconnect($this->hostname, $this->username, $this->password);
        } else {
            $this->databaseLink = mysql_connect($this->hostname, $this->username, $this->password);
        }

        if (!$this->databaseLink) {
            $this->lastError = 'Could not connect to server: ' . mysql_error($this->databaseLink);
            return false;
        }

        if (!$this->UseDB()) {
            $this->lastError = 'Could not connect to database: ' . mysql_error($this->databaseLink);
            return false;
        }

        $this->setCharset(); // TODO: remove forced charset find out a specific management
        return true;
    }

    // Select database to use
    private function UseDB() {
        if (!mysql_select_db($this->database, $this->databaseLink)) {
            $this->lastError = 'Cannot select database: ' . mysql_error($this->databaseLink);
            if ($this->CreateDB->run_sql_file(DATABASE_SCRIPT_PATH)) {
                call_user_func('UseDB');
            }
            return false;
        } else {
            return true;
        }
    }

    // Performs a 'mysql_real_escape_string' on the entire array/string
    private function SecureData($data, $types = array()) {
        if (is_array($data)) {
            $i = 0;
            foreach ($data as $key => $val) {
                if (!is_array($val)) {

                    if (is_string($val)) {
                        $types[$i] = "string";
                    } elseif (is_numeric($val)) {
                        $types[$i] = "integer";
                    } elseif (is_float($val)) {
                        $types[$i] = "float";
                    } elseif (is_bool($val)) {
                        $types[$i] = "boolean";
                    } elseif (is_object($val)) {
                        $types[$i] = "blob";
                    } else {
                        $types[$i] = "null";
                    }
                    $data[$key] = $this->CleanData($val, $types[$i]);
                    if (is_string($val)) {
                        $data[$key] = mysql_real_escape_string($val, $this->databaseLink);
                    }
                    $i++;
                }
            }
        } else {
            $data = $this->CleanData($data, $types);
            $data = mysql_real_escape_string($data, $this->databaseLink);
        }
        return $data;
    }

    // clean the variable with given types
    // possible types: none, str, int, float, bool, datetime, ts2dt (given timestamp convert to mysql datetime)
    // bonus types: hexcolor, email
    private function CleanData($data, $type = '') {
        switch ($type) {
            case 'null':
                $data = $data;
                break;
            case 'string':
                settype($data, 'string');
                break;
            case 'integer':
                settype($data, 'integer');
                break;
            case 'float':
                settype($data, 'float');
                break;
            case 'boolean':
                settype($data, 'boolean');
                break;
            default:
                break;
        }
        return $data;
    }

    /*     * *****************
     * Public Functions *
     * ***************** */

    // Executes MySQL query
    public function executeSQL($query) {
        if (strlen($query) > 1) {
            $this->lastQuery = $query;
            if ($this->result = mysql_query($query, $this->databaseLink)) {
                if (gettype($this->result) === 'resource') {
                    $this->records = @mysql_num_rows($this->result);
                } else {
                    $this->records = 0;
                }
                $this->affected = @mysql_affected_rows($this->databaseLink);
                if ($this->records > 0) {
                    $this->arrayResults();
                    return $this->arrayedResult;
                } else {
                    if ($GLOBALS[CLASS_TOOLS]->isDebug()) {
                        $GLOBALS[CLASS_TOOLS]->Show("Done In Database : " . $query);
                    }
                    return true;
                }
            } else {
                $this->lastError = mysql_error($this->databaseLink);
                if ($GLOBALS[CLASS_TOOLS]->isDebug()) {
                    $GLOBALS[CLASS_TOOLS]->Show($this->lastError);
                }
                return false;
            }
        } else {
            if ($GLOBALS[CLASS_TOOLS]->isDebug()) {
                $GLOBALS[CLASS_TOOLS]->Show("Done In Database : " . $query);
            }
            return true;
        }
    }

    public function commit() {
        return mysql_query("COMMIT", $this->databaseLink);
    }

    public function rollback() {
        return mysql_query("ROLLBACK", $this->databaseLink);
    }

    public function setCharset($charset = 'UTF8') {
        return mysql_set_charset($this->SecureData($charset, 'string'), $this->databaseLink);
    }

    // Adds a record to the database based on the array key names
    public function insert($table, $vars, $exclude = '', $datatypes = array()) {

        // Catch Exclusions
        if ($exclude == '') {
            $exclude = array();
        }
        array_push($exclude, 'MAX_FILE_SIZE'); // Automatically exclude this one
        // Prepare Variables
//        $vars = $this->SecureData($vars, $datatypes);

        $query = "INSERT INTO `{$table}` SET ";
        foreach ($vars as $key => $value) {
            if (in_array($key, $exclude)) {
                continue;
            }
            $result = mysql_query("SELECT $key FROM $table");
            $type = mysql_field_type($result, 0);
            if ($type == "int") {
                $query .= "`{$key}` = {$value}, ";
            } elseif ($type == "date") {
                $query .= "`{$key}` = NOW(), ";
            } elseif ($type == "datetime") {
                $query .= "`{$key}` = NOW(), ";
            } elseif ($type == 'boolean') {
                $query .= "`{$key}` = {$value}, ";
            } else {
                $query .= "`{$key}` = '{$value}', ";
            }
        }
        $query = trim($query, ', ');
        return $this->executeSQL($query);
    }

    // Deletes a record from the database
    public function delete($table, $where = '', $limit = '', $like = false, $wheretypes = array()) {
        $query = "DELETE FROM `{$table}` WHERE ";
        if (is_array($where) && $where != '') {
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);
            foreach ($where as $key => $value) {
                if ($like) {
                    $query .= "`{$key}` LIKE '%{$value}%' AND ";
                } else {
                    $query .= "`{$key}` = '{$value}' AND ";
                }
            }
            $query = substr($query, 0, -5);
        }
        if ($limit != '') {
            $query .= ' LIMIT ' . $limit;
        }
        return $this->executeSQL($query);
    }

    public function select_between($from, $where = '', $operand = 'AND', $between_1, $between_2) {
        if (trim($from) == '') {
            return false;
        }
        $query = "SELECT * FROM `{$from}` WHERE ";
        if (is_array($where) && $where != '') {
            // Prepare Variables
            $where = $this->SecureData($where);
            foreach ($where as $key => $value) {
                $query .= "`{$key}` = '{$value}' {$operand} ";
            }
            $query .= " BETWEEN " . $between_1 . " AND " . $between_2;
            $result = $this->executeSQL($query);
            if (is_array($result)) {
                return $result;
            }
        }
        return null;
    }

    // Gets a single row from $from where $where is true
    public function select($from, $where = '', $orderBy = '', $limit = '', $like = false, $operand = 'AND', $cols = '*', $wheretypes = array()) {
        // Catch Exceptions
        if (trim($from) == '') {
            return false;
        }
        $query = "SELECT {$cols} FROM `{$from}` WHERE ";
        if (is_array($where) && $where != '') {
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);
            foreach ($where as $key => $value) {
                if ($like) {
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                } else {
                    if (is_string($value)) {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    } elseif (is_numeric($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } elseif (is_bool($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } else {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    }
                }
            }
            $query = substr($query, 0, -(strlen($operand) + 2));
        } else {
            $query = substr($query, 0, -6);
        }
        if ($orderBy != '') {
            $query .= ' ORDER BY ' . $orderBy;
        }
        if ($limit != '') {
            $query .= ' LIMIT ' . $limit;
        }
        $result = $this->executeSQL($query);
        if (is_array($result))
            return $result;
        return null;
    }

    public function select_join($table1, $table2, $cols_1, $cols_2, $cols = '*', $where = '', $orderBy = '', $limit = '', $like = false, $operand = 'AND', $wheretypes = array()) {
        $query = "SELECT {$cols} FROM `{$table1}` INNER JOIN `{$table2}` ON {$table1}.{$cols_1}={$table2}.{$cols_2}";

        if (is_array($where) && $where != '') {
            $query .= ' WHERE ';
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);
            foreach ($where as $key => $value) {
                if ($like) {
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                } else {
                    if (is_string($value)) {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    } elseif (is_numeric($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } elseif (is_bool($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } else {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    }
                }
            }
            $query = substr($query, 0, -(strlen($operand) + 2));
        }

        if ($orderBy != '') {
            $query .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != '') {
            $query .= ' LIMIT ' . $limit;
        }

        $result = $this->executeSQL($query);
        if (is_array($result)) {
            return $result;
        }
        return null;
    }

    public function select_left_outer_join($table1, $table2, $cols_1, $cols_2, $cols = '*', $where = '', $orderBy = '', $limit = '', $like = false, $operand = 'AND', $wheretypes = array()) {
        $query = "SELECT {$cols} FROM `{$table1}` LEFT OUTER JOIN `{$table2}` ON {$table1}.{$cols_1}={$table2}.{$cols_2}";
        if (is_array($where) && $where != '') {
            $query .= ' WHERE ';
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);
            foreach ($where as $key => $value) {
                if ($like) {
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                } else {
                    if (is_string($value)) {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    } elseif (is_numeric($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } elseif (is_bool($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } else {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    }
                }
            }
            $query = substr($query, 0, -(strlen($operand) + 2));
        }

        if ($orderBy != '') {
            $query .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != '') {
            $query .= ' LIMIT ' . $limit;
        }

        $result = $this->executeSQL($query);
        if (is_array($result)) {
            return $result;
        }
        return null;
    }

    public function select_right_outer_join($table1, $table2, $cols_1, $cols_2, $cols = '*', $where = '', $orderBy = '', $limit = '', $like = false, $operand = 'AND', $wheretypes = array()) {
        $query = "SELECT {$cols} FROM `{$table1}` RIGHT OUTER JOIN `{$table2}` ON {$table1}.{$cols_1}={$table2}.{$cols_2}";
        if (is_array($where) && $where != '') {
            $query .= ' WHERE ';
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);
            foreach ($where as $key => $value) {
                if ($like) {
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                } else {
                    if (is_string($value)) {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    } elseif (is_numeric($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } elseif (is_bool($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } else {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    }
                }
            }
            $query = substr($query, 0, -(strlen($operand) + 2));
        }

        if ($orderBy != '') {
            $query .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != '') {
            $query .= ' LIMIT ' . $limit;
        }

        $result = $this->executeSQL($query);
        if (is_array($result)) {
            return $result;
        }
        return null;
    }

    public function select_full_outer_join($table1, $table2, $cols_1, $cols_2, $cols = '*', $where = '', $orderBy = '', $limit = '', $like = false, $operand = 'AND', $wheretypes = array()) {
        $query = "SELECT {$cols} FROM `{$table1}` FULL OUTER JOIN `{$table2}` ON {$table1}.{$cols_1}={$table2}.{$cols_2}";
        if (is_array($where) && $where != '') {
            $query .= ' WHERE ';
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);
            foreach ($where as $key => $value) {
                if ($like) {
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                } else {
                    if (is_string($value)) {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    } elseif (is_numeric($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } elseif (is_bool($value)) {
                        $query .= "`{$key}` = {$value} {$operand} ";
                    } else {
                        $query .= "`{$key}` = '{$value}' {$operand} ";
                    }
                }
            }
            $query = substr($query, 0, -(strlen($operand) + 2));
        }

        if ($orderBy != '') {
            $query .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != '') {
            $query .= ' LIMIT ' . $limit;
        }

        $result = $this->executeSQL($query);
        if (is_array($result)) {
            return $result;
        }
        return null;
    }

    public function isExist($from, $where = '', $orderBy = '', $limit = '', $like = false, $operand = 'AND', $cols = '*', $wheretypes = array()) {
        $ret = $this->select($from, $where, $orderBy, $limit, $like, $operand, $cols, $wheretypes);
        if (count($ret) > 0) {
            return true;
        } else {
            return false;
        }
    }

// Updates a record in the database based on WHERE
    public function update($table, $set, $where, $exclude = '', $datatypes = array(), $wheretypes = array()) {
// Catch Exceptions
        if (trim($table) == '' || !is_array($set) || !is_array($where)) {
            return false;
        }
        if ($exclude == '') {
            $exclude = array();
        }
        array_push($exclude, 'MAX_FILE_SIZE'); // Automatically exclude this one
        $set = $this->SecureData($set, $datatypes);
        $where = $this->SecureData($where, $wheretypes);
// SET
        $query = "UPDATE `{$table}` SET ";
        foreach ($set as $key => $value) {
            if (in_array($key, $exclude)) {
                continue;
            }
            $result = mysql_query("SELECT $key FROM $table");
            $type = mysql_field_type($result, 0);
            if ($type == "int") {
                $query .= "`{$key}` = {$value}, ";
            } elseif ($type == "date") {
                $query .= "`{$key}` = NOW(), ";
            } elseif ($type == "datetime") {
                $query .= "`{$key}` = NOW(), ";
            } elseif ($type == 'boolean' || $type == 'bool') {
                $query .= "`{$key}` = {$value}, ";
            } else {
                $query .= "`{$key}` = '{$value}', ";
            }
        }
        $query = substr($query, 0, -2);
// WHERE
        $query .= ' WHERE ';
        foreach ($where as $key => $value) {
            $query .= "`{$key}` = '{$value}' AND ";
        }
        $query = substr($query, 0, -5);
        return $this->executeSQL($query);
    }

// 'Arrays' a single result
    public function arrayResult() {
        $this->arrayedResult = mysql_fetch_assoc($this->result) or die(mysql_error($this->databaseLink));
        return $this->arrayedResult;
    }

// 'Arrays' multiple result
    public function arrayResults() {
        if ($this->records == 1) {
            return $this->arrayResult();
        }
        $this->arrayedResult = array();
        while ($data = mysql_fetch_assoc($this->result)) {
            $this->arrayedResult[] = $data;
        }
        return $this->arrayedResult;
    }

// 'Arrays' multiple results with a key
    public function arrayResultsWithKey($key = 'id') {
        if (isset($this->arrayedResult)) {
            unset($this->arrayedResult);
        }
        $this->arrayedResult = array();
        while ($row = mysql_fetch_assoc($this->result)) {
            foreach ($row as $theKey => $theValue) {
                $this->arrayedResult[$row[$key]][$theKey] = $theValue;
            }
        }
        return $this->arrayedResult;
    }

// Returns last insert ID
    public function lastInsertID() {
        return mysql_insert_id($this->databaseLink);
    }

// Return number of rows
    public function countRows($from, $where = '', $like = false) {
        $result = $this->select($from, $where, '', '', $like, 'AND', 'count(*)');
        return $result["count(*)"];
    }

// Closes the connections
    public function closeConnection() {
        if ($this->databaseLink) {
// Commit before closing just in case :)
            $this->commit();
            mysql_close($this->databaseLink);
        }
    }

    public function ReturnError() {
        return $this->lastError;
    }

}
