<?php

// Check if PHP 5.3 or later
if (phpversion() < "5.3.0") die("This script requires PHP 5.3 or later. You are running " . phpversion() . ".");

require("connection.php");


if (empty($_REQUEST)) {
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    echo "<title>404 Not Found</title>";
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found."; 
    exit();
    
}
    
    
if ($_REQUEST['Token']){
    $TA = $_REQUEST['Token'];
    $Action = $_REQUEST['Action'];
    if(vToken($TA) == 0 AND $Action != '1003'){
        $header = json_response();
        $reply = array('Error Code' => 400, 'Detail' => "I have been waiting for you too long." );
    } else {
        
        $User = vToken($TA);
        $PartNo = $_REQUEST['PartNo'];
        $SerialNo = $_REQUEST['SerialNo'];
        $PO = $_REQUEST['PO'];
        $Cost = $_REQUEST['Cost'];
        $Waranty = $_REQUEST['Waranty'];
        $Activae = $_REQUEST['Activate'];
        $LocCode = $_REQUEST['LOC'];
        $TransactionType = $_REQUEST['Transaction'];
        
        
        switch ($Action) {
    
            case '1001': //Add new products
                $reply = addPorduct($User, $PartNo, $SerialNo , $PO, $Cost, $Waranty, $TransactionType, $LocCode, $Activate);
                break;
            case '1003': // Relocate Warehouse 
                if (vToken($TA, 30, TRUE, 120000) == 0){
                    $reply = array('Error Code' => 400, 'Detail'=>'Really sorry!, I cannot wait for you');
                } else {
                    echo "---";
                    echo vToken($TA, 10, TRUE); 
                    $reply = array('Error Code' => 200, 'Detai'=>'OK');
                }
                break;
            
            default:
                $reply = array('Error Code' => $Action, 'Detail' => 'Baby!,What you want me to do?...bla bla...');
                break;
        }
        
    }
} else {
    $reply = cToken($_REQUEST['login'],$_REQUEST['passwd'],$_REQUEST['API']);
}


$A = json_response();
echo json_encode($reply);





?>