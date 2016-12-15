# easy-PHP-mysql
Easy object-oriented way of connecting and querying a mysql database from PHP

## Code Examples

```PHP
//sample new connection
$myconnection = new Database('localhost','root','root', 'database');

//sample get all users
$allusers = $myconnection->select('users', null, null);

OR 

$allusers = $myconnection->select('users', null);

//sample get specific user and values
$user = $myconnection->select('users', array('userid'), array('userid' => '2'));

//sample escape
$escapedValue = $myconnection->escape('Some value');

//sample insert
$insert = $myconnection->insert('users', array('userid' => '1', 'pword' => 'password', 'activity' => 'jogging'));

//sample update
$update = $myconnection->update('users', array('userid' => '1', 'pword' => 'password', 'activity' => 'jogging'), array('finalkey' => 2));

OR 

$update = $myconnection->update('reports', array('reportYear' => '2016'));
```

## Motivation
I wrote this to simplify the MYSQL DB process. This creates a mysql connection object and simplifies the query process.

## Installation
To install, simply include the database.php file in your project and use a php include in php files needing the database.

```PHP
<?php
    include ('database.php');
?>
```
## API Reference

all parameters requesting an associative array should be formatted as follows: 

    array('key' => 'value', 'key2' => 'value2')
    
### Methods
```
constructor (host, username, password, database)
escape (value to be escaped)
select (table, associative array of select values or null for *, [optional] associative array of where conditions)
insert (table, associative array of values)
update (table, associative array of set values, [optional] associative array of where conditions)
```

## License

MIT License

Copyright (c) 2016 CJ Eller

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.