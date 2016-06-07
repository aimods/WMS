<?php
require("connection.php");

$tAPI = new APIDB();
$sql = "SELECT * FROM session";
$ret = $tAPI->query($sql);

while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
       print_r($row);
       echo "<br>";
    }

?> 