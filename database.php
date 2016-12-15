<?php

/*******************************************************
* database -- PHP Class to simplify DB Query           *
*                                                      *
* Author:  CJ, Eller                                   *
*                                                      *
* Purpose:  Simplify PHP database query process        *
*                                                      *
* Usage:                                               *
*   connect to a mysql DB and query data via object    *
********************************************************/

class Database {
    /*
     * DB connection object
     *
     * @var mysqli_connection_object
     */
    private $dbc = null;

    /*
     * object constructor for connecting to DB
     *
     * @params
     * $host  - DB Host name (Usually 'localhost')
     * $user  - DB Username
     * $pw    - DB Password
     * $db    - DB to use
     */
    function __construct($host, $user, $pw, $db){
        //connect to db
        $this->dbc = mysqli_connect($host,$user,$pw,$db)
        or die('MYSQL Connect Error! [MYSQL SERVER]: ' . mysqli_connect_error());
    }

    /*
     * DB SELECT Query
     *
     * @params
     * $table                   - DB table | example: 'final'
     * $fields                  - array of fields or NULL for '*' | example: array('userid','pword')
     * $conditions (optional)   - associative array of WHERE conditions | example:  array('userid'=>'test','pword'=>'password')
     *
     * @return      - array of Selected rows
     */
    function select($table, $fields, $conditions = NULL){
        //init select statement & where clause
        $select = '';
        $where = '';

        //BUILD SELECT FIELDS if null = * else fields
        if($fields == null){
            $select = '*';
        }
        else{

            $index = 0;
            foreach($fields as $field){
                //print commas before every index that isn't 0
                if ($index == 0){
                    $select .= "`$field`";
                }
                else{
                    $select .= ",`$field`";
                }
                //add to index
                $index++;
            }

        }

        //BUILD WHERE CLAUSE if array has values
        if($conditions != null){
            $index = 0;
            foreach($conditions as $con => $value){
                //print WHERE before first index and && before others
                if ($index == 0){
                    $where .= "WHERE `$con` = '$value'";
                }
                else{
                    $where .= "&& `$con` = '$value'";
                }
                //add to index
                $index++;
            }
        }

        //build query
        $sql = "SELECT $select FROM $table $where;";

        //run query
        $result = mysqli_query($this->dbc, $sql) OR die(mysqli_error($this->dbc));

        //get result and return
        return mysqli_fetch_assoc($result);

    }

    /*
     * DB UPDATE Query
     *
     * @params
     * $table                   - DB table | example: 'final'
     * $fields                  - associative array of fields | example: array('userid'=>'test','pword'=>'password')
     * $conditions (optional)   - associative array of WHERE conditions | example:  array('userid'=>'test','pword'=>'password')
     */
    function update($table, $fields, $conditions = NULL){
        //init select statement & where clause
        $set = '';
        $where = '';

        //BUILD SELECT FIELDS
        if($fields != null){
            $index = 0;
            foreach($fields as $field => $value){
                //print commas before every index that isn't 0
                if ($index == 0){
                    $set .= "`$field`='$value'";
                }
                else{
                    $set .= ", `$field`='$value' ";
                }
                //add to index
                $index++;
            }

        }

        //BUILD WHERE CLAUSE if array has values
        $where = '';
        if($conditions != null){
            $index = 0;
            foreach($conditions as $con => $value){
                //print WHERE before first index and && before others
                if ($index == 0){
                    $where .= "WHERE `$con` = '$value'";
                }
                else{
                    $where .= "&& `$con` = '$value'";
                }
                //add to index
                $index++;
            }
        }

        //build query
        $sql = "UPDATE $table SET $set $where;";
        echo $sql . "<br>";

        //run query
        $result = mysqli_query($this->dbc, $sql) OR die(mysqli_error($this->dbc));

    }

    /*
     * DB INSERT Query
     *
     * @params
     * $table       - DB table | example: 'final'
     * $fields      - associative array of fields | example: array('userid'=>'test','pword'=>'password')
     */
    function insert($table, $fields){

        //init set & values
        $set = '';
        $vals = '';

        //BUILD INSERT ($set) FIELDS
        if($fields != null){
            $index = 0;
            foreach($fields as $field => $value){
                //print commas before every index that isn't 0
                if ($index == 0){
                    $set .= "$field";
                }
                else{
                    $set .= ", $field";
                }
                //add to index
                $index++;
            }

        }

        //BUILD VALUES ($vals) CLAUSE if array has values
        if($fields != null){
            $index = 0;
            foreach($fields as $field => $value){
                //print WHERE before first index and && before others
                if ($index == 0){
                    $vals .= "'$value'";
                }
                else{
                    $vals .= ", '$value'";
                }
                //add to index
                $index++;
            }
        }

        //sql select statement to get user by username & password
        $sql = "INSERT INTO $table ($set) VALUES ($vals);";

        //run query
        $result = mysqli_query($this->dbc, $sql) OR die(mysqli_error($this->dbc));

    }

    /*
     * DB Escape String
     *
     * @params
     * $value   - Value field you are trying to DB escape
     *
     * @return  - MYSQLI escape string
     */
    function escape($value){
        return mysqli_real_escape_string($this->dbc, $value);
    }

    /*
     * Object Destructor for closing the DB connection when object is done
     */
    function __destruct(){
        mysqli_close($this->$dbc);
        $this->dbc = null;
    }
}


/* TEST CASES */

//sample new connection
//$myconnection = new Database('localhost','root','root', 'database');

//sample get all users
//$allusers = $myconnection->select('table', null, null);

//sample get specific user and values
//$user = $myconnection->select('table', array('userid'), array('userid' => '1'));

//sample escape
//$escapedValue = $myconnection->escape('Some value');

//sample insert
//$insert = $myconnection->insert('table', array('userid' => '1', 'pword' => 'password', 'email' => 'test@email.com'));

//sample update
//$update = $myconnection->update('table', array('pword' => 'password', 'email' => 'test@email.com'), array('id' => 2));

?>
