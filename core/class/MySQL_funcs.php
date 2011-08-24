<?php

/* Common MySQL connectivity Wizard
  Author: Shafiul Azam
  ishafiul@gmail.com
 * Version: 1.0
 */

// Configuration
require_once( dirname(__FILE__) . '/mysql_config.php');

/////////////// functions ////////////////

function sql_error($line_id="N/A") {
    // Prints an Error on screen!
    global $my_errno, $my_err;
    if (empty($my_err)) {
        $my_errno = mysql_errno();
        $my_err = mysql_error();
    }
    return "MySQL Error $my_errno: <b>$my_err</b> on snippet $line_id";
}

function db_connect($dbname = "") {
    // If connected succesfully, returns link ID. Else, dies printing an error message.
    global $db_host, $db_username, $db_pass, $default_db_name, $my_errno, $my_err;

    $linkid = mysql_connect($db_host, $db_username, $db_pass);
    if (!$linkid) {
        $my_errno = 0;
        $my_err = "Connection Failed!";
        die(sql_error());
    }
    if ($dbname)
        $default_db_name = $dbname;
    if ($default_db_name && !mysql_select_db($default_db_name, $linkid)) {
        $my_errno = mysql_errno();
        $my_err = mysql_error();
        die(sql_error());
    }
    return $linkid;
}

function mysql_insert_array($table, $data, $password_key="", $password_value="") {
    // inserts given key-value array $data to $table
    $fields = $values = array();

 
    foreach ($data as $key => $val) {
        $fields[] = "`$key`";
        $values[] = "'" . mysql_real_escape_string($val) . "'";
    }

    $fields = implode(",", $fields);
    $values = implode(",", $values);
    // Check for password types
    if ($password_key && $password_value) {
        $fields = $fields . ", $password_key";
        $values = $values . ", SHA('$password_value')"; // stored using secured hash algorithm
    }
    $query = "INSERT INTO `$table` ($fields) VALUES ($values)";
    if (DB_DEBUG_MODE_ON) {
        echo "<br />$query <br />";
    }
    if (mysql_query($query)) {
        return mysql_insert_id();
    } else {
        return false;
    }
}

function mysql_update_array($table, $data, $identifier_column, $identifier_value) {
    // updates given $table by $data array, where $indentifier_column = $identifier_value
    $fields = $values = array();
    $query = "UPDATE `$table` SET ";
    foreach (array_keys($data) as $key) {
        $query .= "`$key` = ";
        $query .= "'" . mysql_real_escape_string($data[$key]) . "', ";
    }
    $query = substr($query, 0, strlen($query) - 2);
    $query .= " WHERE `$identifier_column` = '" . $identifier_value . "'";
    if (DB_DEBUG_MODE_ON) {
        echo "<br />$query <br />";
    }
    if (mysql_query($query)) {
        return true;
    } else {
        return false;
    }
}

function mysql_update_array_standard($table, $data, $identifier, $rest = "", $joiner = "AND") {
    // NOT TESTED!!!
    // updates given $table by $data array, where $indentifier_column = $identifier_value
    $fields = $values = array();
    $query = "UPDATE `$table` SET ";
    foreach (array_keys($data) as $key) {
        $query .= "`$key` = ";
        $query .= "'" . mysql_real_escape_string($data[$key]) . "', ";
    }
    $query = substr($query, 0, strlen($query) - 2);
    $query .= " WHERE ";
    $where = array();
    foreach ($identifier as $k => $v) {
        $where[] = "`$k` = '" . mysql_real_escape_string($v) . "'";
    }
    $query .= implode(" $joiner ", $where);
    $query .= " $rest";
    if (DB_DEBUG_MODE_ON) {
        echo "<br />$query <br />";
    }
    if (mysql_query($query)) {
        return true;
    } else {
        return false;
    }
}

function mysql_update_array_straight($table, $data, $where) {
    // updates given $table by $data array, where $indentifier_column = $identifier_value
    $fields = $values = array();
    $query = "UPDATE `$table` SET ";
    foreach (array_keys($data) as $key) {
        $query .= "`$key` = ";
        $query .= "'" . mysql_real_escape_string($data[$key]) . "', ";
    }
    $query = substr($query, 0, strlen($query) - 2);
    $query .= "$where";
    if (DB_DEBUG_MODE_ON) {
        echo "<br />$query <br />";
    }
    if (mysql_query($query)) {
        return true;
    } else {
        return false;
    }
}


function mysql_delete($table,$identifier,$rest = "",$joiner="AND"){
    $query = "DELETE FROM `$table` WHERE";
    $where = array();
    foreach($identifier as $k=>$v){
        $where[] = "`$k` = '" . mysql_real_escape_string($v) . "'";
    }
    $query .= implode($joiner, $where) . $rest;
    
    if(DB_DEBUG_MODE_ON)
        echo $query;
//    die();
    if(mysql_query($query))
        return true;
    else
        return false;
}

function time_sql2php($sqltime) {
    return strtotime($sqltime . " GMT");
}

function time_php2sql($unixtime) {
    return gmdate("Y-m-d H:i:s", $unixtime);
}

function mysql_return_array($table, $select="", $where="", $return_pointer=true, $rest="", $joiner = "AND") {
    $query = "SELECT ";
    if (!$select) {
        $query .= "*";
    } else {
        $query .= implode($select, " , ");
    }
    $query .= " FROM `$table`";
    if ($where) {
        $query .= " WHERE ";
        $sqll = "";
        foreach ($where as $key => $i) {
            $sqll[] = "`$key` = '$i'";
        }
        $query .= implode($sqll, " $joiner ");
    }
    if ($rest)
        $query .= " $rest";
    if (DB_DEBUG_MODE_ON) {
        echo "<br />$query <br />";
    }
    if ($return_pointer) {
        return mysql_query($query);
    } else {
        // Return only the first result
        return mysql_fetch_array(mysql_query($query));
    }
}

function mysql_return_array_straight($table, $select="", $rest="", $return_pointer=true) {
    $query = "SELECT ";
    if (!$select) {
        $query .= "*";
    } else {
        $query .= $select;
    }
    $query .= " FROM `$table` " . $rest;
    if (DB_DEBUG_MODE_ON) {
        echo "<br />$query <br />";
    }
    if ($return_pointer) {
        return mysql_query($query);
    } else {
        // Return only the first result
        return mysql_fetch_array(mysql_query($query));
    }
}

?>