<?php

// Check if PHP 5.3 or later
if (phpversion() < "5.3.0") die("This script requires PHP 5.3 or later. You are running " . phpversion() . ".");


$EW_RELATIVE_PATH = "../";
$SESSION_VALID = "+ 10 minutes";
include_once $EW_RELATIVE_PATH . "ewcfg12.php";
$EW_ROOT_RELATIVE_PATH = "../";
include_once $EW_RELATIVE_PATH . ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php");
include_once $EW_RELATIVE_PATH . "phpfn12.php";
include_once $EW_RELATIVE_PATH . "main_user_info.php";
include_once $EW_RELATIVE_PATH . "userfn12.php";
include_once $EW_RELATIVE_PATH . "ewdbhelper12.php";


class APIDB extends SQLite3
{
    function __construct()
    {
        $this->open('session.db');
    }
}

function generateRandomString($length = 128) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function cToken($login, $passwd, $UUID){

    $db =& DbHelper();

    $sql = "SELECT u_UUID, u_ID as Token FROM main_User WHERE u_LoginName = '$login' AND u_Passwd = MD5('$passwd')";
    $token = json_decode($db->ExecuteJsonArray($sql));
    $key =  $token[0][0];
    $u_ID = $token[0][1];

    if ($key) {
        if ($UUID == null) {
            $reply = array('Token'=> FALSE, 'ID'=> '', 'ERROR'=>'Invalid API Token');
        } else {
            if($UUID == $key){
                $msg = crypt(generateRandomString(),$key);
                $encrypt = hash('sha256',$msg);
                $api = new APIDB();
                
                if(!$api){
                    $reply = array('Token'=>FALSE, 'ID'=>'', 'ERROR'=> 'Cannot start verifcation process!');
                } else {
                    $sql = "INSERT INTO session (TOKEN, ID,EXPIRE) VALUES ('$encrypt', $u_ID, datetime('now'))";
                    $ret = $api->exec($sql);
                    if(!$ret){
                        $reply = array('Token'=>FALSE, 'ID'=>'', 'ERROR'=> 'Cannot start verifcation process!');
                    } else {
                        $reply = array('Token'=>TRUE, 'ID'=>$encrypt, 'EXPIRE'=>$SESSION_VALID);
                    }
                    $api->close();
                }            
            } else {
                $reply = array('Token' => FALSE, 'ID'=>'', 'ERROR'=>'Invalid API Token');
            }
        }
        
    } else {
        $reply = array('Token' => FALSE, 'ID'=>'', 'ERROR'=>'Invalid Username or Password');     
    }


    return $reply;
}


function vToken($Token, $min = 30, $renew = FALSE, $window=0){

    $tAPI = new APIDB();
    $sql = "SELECT * FROM session WHERE TOKEN='$Token'";
    $ret = $tAPI->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        $Expire = strtotime($row['EXPIRE']);
        $ID = $row['ID'];
    }
    
    $now = time();
    if(!$Expire) return 0;
    $session = (($now - $Expire)/60);
    if($session >= $min){
        //$reply = array('Token' => FALSE,'ID'=>'', 'Error'=>'Session Timeout!' );
        if($renew AND $session < $min + $window){
            $sql = "UPDATE session SET EXPIRE = datetime('now') WHERE TOKEN = '$Token'";
            $ret = $tAPI->query($sql);
            if($ret) {
                return ID;
            } else {
                return 0;
            }
        } else {
            return 0;   
        }
   } else {
       if($renew){
            $sql = "UPDATE session SET EXPIRE = datetime('now') WHERE TOKEN = '$Token'";
            $ret = $tAPI->query($sql);                
       }
        return $ID;
   }
   $tAPI->close(); 
}



function json_response($message = null, $code = 200)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error',
        404 => 'HTTP/1.0 404 Not Found',
        408 => '408 Request Timeout'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
        ));
}


function GetClientIP($validate = False){
  $ipkeys = array(
  'REMOTE_ADDR', 
  'HTTP_CLIENT_IP', 
  'HTTP_X_FORWARDED_FOR', 
  'HTTP_X_FORWARDED', 
  'HTTP_FORWARDED_FOR', 
  'HTTP_FORWARDED', 
  'HTTP_X_CLUSTER_CLIENT_IP'
  );

  /*
  now we check each key against $_SERVER if contain such value
  */
  $ip = array();
  foreach($ipkeys as $keyword){
    if( isset($_SERVER[$keyword]) ){
      if($validate){
        if( ValidatePublicIP($_SERVER[$keyword]) ){
          $ip[] = $_SERVER[$keyword];
        }
      }else{
        $ip[] = $_SERVER[$keyword];
      }
    }
  }

  $ip = ( empty($ip) ? 'Unknown' : implode(", ", $ip) );
  return $ip;

}

function ValidatePublicIP($ip){
  if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
    return true;
  }
  else {
    return false;
  }
} 

function addPorduct($User, $PartNo, $SerialNo , $PO, $Cost, $Waranty=1, $TransactionType=1, $LocCode=0,$Activate){

    $db =& DbHelper();
    
    if (!$Activate) {
        // if Activated date not provide consider + 90 days
        $Activated = date('Y-m-d H:i:s', (strtotime('+45 days')));
        
    } else {
        $Activated =  date ('Y-m-d H:i:s', strtotime($_REQUEST['Activate']));
    }
    
    if (!$TransactionType){
        $Transaction = 1; // Receiving Data only
        $Note = "Auto submit information from IP:";
        $Note .= getClientIP();
    } else {
        $Transaction = 2;
        if(!$LocCode){
            $reply = array('Error Code' => 400, 'Detail' => 'Not all those who wander are lost.' );
            return $reply ;
        } else {
            $sql = "SELECT s_ID FROM main_Stock WHERE s_LOC = $LocCode";
            $LocationID = $db->ExecuteScalar($sql);
            $Note = "Auto submit information from IP:";
            $Note .= getClientIP();
        }
    }



    # Get pn_ID from PartNo.Barcode
    $sql = "SELECT pn_ID FROM main_PartNum WHERE pn_Barcode='$PartNo'";
    $PartNoID = $db->ExecuteScalar($sql);

    $sql = "INSERT INTO main_Product(pn_ID, pr_Barcode, pr_Cost, pr_PO, pr_Activated)";
    $sql .= "VALUES ('$PartNoID', '$SerialNo', '$Cost', '$PO', '$Activated')";

    $results = $db->ExecuteRow($sql);

    $sql = "SELECT pr_ID FROM main_Product WHERE pr_Barcode = $SerialNo";
    $SerialNoID = $db->ExecuteScalar($sql);

    $sql = "INSERT INTO `transaction_Movement` (pr_ID, tr_type, tran_Detail, u_ID";

    if($LocationID) {
        $sql .= ",s_ID"; 
    }

    $sql .= ") VALUES ('$SerialNoID', $Transaction, '$Note', '$User'";

    if($LocationID) {
        $sql .= ", '$LocationID'";
    }
    $sql .= ")";
    
    
    
    $reply = array('Serial' => $SerialNo, 'Control' =>$SerialNoID, 'Transaction' => $db->ExecuteScalar($sql));
    return $reply;
    
}
?>