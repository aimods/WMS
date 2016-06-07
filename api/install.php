<?php

class MyDB extends SQLite3
{
    function __construct()
    {
         $this->open('session.db');
    }
}


$filename = 'session.db';
if (file_exists($filename)) {
    If (date ("F d Y", filectime($filename)) < date ("F d Y")){
        unlink($filename);
    } else {
        echo "File creation date is stil valid";
        exit(0);
    }
}

$api = new MyDB();

if(!$api){
    echo "DB Error";
} 

$sql =<<<EOF
CREATE TABLE session( 
TOKEN VARCHAR(256) NOT NULL , 
ID INT NOT NULL,
EXPIRE DATETIME NOT NULL , PRIMARY KEY (TOKEN));
EOF;

$ret = $api->exec($sql);
if(!$ret){
    echo $api->lastErrorMsg();
} else {
    echo "Table created successfully\n";
}
$db->close();

chmod($filename, 755)

?>