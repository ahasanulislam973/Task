<?php

$string = $_REQUEST['input'];

if (strpos($string, "payment") !== false) {
    if (strpos($string, "payment") !== false && strpos($string, "received") !== false) {
        $dataArray = processReceivePayment($string);
    } elseif (strpos($string, "payment") !== false) {
        $dataArray = processPayment($string);
    }

} else {
    if (strpos($string, "received") !== false && strpos($string, "airtime") !== false) {
        $dataArray = processReceivedAirtime($string);
    } elseif (strpos($string, "received") !== false) {
        $dataArray = processReceived($string);
    } elseif (strpos($string, "send money") !== false) {
        $dataArray = processSendMoney($string);
    } elseif (strpos($string, "buy airtime") !== false) {
        $dataArray = processBuyAirtime($string);
    } elseif (strpos($string, "cash in") !== false) {
        $dataArray = processCashIn($string);
    }

}

print "<pre>";
print_r($dataArray);
print "</pre>";
exit;


//received payment
function processReceivePayment($string)
{

    // echo "The main string message is:"."<br>".$string;

    $newstring = explode(' ', $string);
    /* return array(
         'transaction_amount' => $newstring[5] . ' ' . $newstring[4],
         'from_account_number' => $newstring[7],
         'to_account_number' => "N/A",
         'transaction_fee' => $newstring[14] . ' ' . $newstring[13],
         'account_balance' => $newstring[17] . ' ' . $newstring[16],
         'transaction_id' => $newstring[19],
         'transaction_date_time' => $newstring[21] . ' ' . $newstring[22],
         'transaction_type' => $newstring[2] . ' ' . $newstring[3],
         'message' => "N/A");*/


    $transaction_amount = rtrim($newstring[5], '.');
    $newtransaction_amount=str_replace(",","","$transaction_amount");
    $from_account_number = $newstring[7];
    $to_account_number = "N/A";
    $transaction_fee = $newstring[14] . ' ' . $newstring[13];
    $account_balance = rtrim($newstring[17], '.');
    $newaccountbalance=str_replace(",","","$account_balance");

    $transaction_id = $newstring[19];
    $transaction_date_time = $newstring[21];
    $transaction_type = $newstring[2] . ' ' . $newstring[3];
    $message = "N/A";
    $dateArray = explode('/', $transaction_date_time);

    $modifyDate = $dateArray[0] . '-' . $dateArray[1] . '-' . $dateArray[2];

    $newdate = date('y-m-d', strtotime($modifyDate)) . ' ' . $newstring[22];
    require_once 'database.php';
    $sql = "INSERT INTO `bkashsmsdb`(transaction_amount,from_account_number,to_account_number,transaction_fee,account_balance,transaction_id,transaction_date_time,transaction_type,message)
    VALUES('$newtransaction_amount','$from_account_number','$to_account_number','$transaction_fee','$newaccountbalance','$transaction_id','$newdate','$transaction_type','$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}


//cash in
function processCashIn($string)
{
    // echo "The main string message is:"."<br>".$string;

    $newstring = explode(' ', $string);
    /*return array(
         'transaction_amount' => $newstring[3] . ' ' . $newstring[2],
         'from_account_number' => $newstring[5],
         'to_account_number' => "N/A",
         'transaction_fee' => $newstring[9] . ' ' . $newstring[8],
         'account_balance' => $newstring[12] . ' ' . $newstring[11],
         'transaction_id' => $newstring[14],
         'transaction_date_time' => $newstring[16] . ' ' . $newstring[17],
         'created_date_time' => "N/A",
         'transaction_type' => $newstring[0] . ' ' . $newstring[1],
         'message' => "N/A"
     );*/
    $transaction_amount = rtrim($newstring[3], '.');
    $newtransaction_amount=str_replace(",","","$transaction_amount");
    $from_account_number = $newstring[5];
    $to_account_number = "N/A";
    $transaction_fee = $newstring[9] . ' ' . $newstring[8];
    $account_balance = rtrim($newstring[12], '.');
    $newaccountbalance=str_replace(",","","$account_balance");
    $transaction_id = $newstring[14];
    $transaction_date_time = $newstring[16];
    $transaction_type = $newstring[0] . ' ' . $newstring[1];
    $message = "N/A";

    $dateArray = explode('/', $transaction_date_time);

    $modifyDate = $dateArray[0] . '-' . $dateArray[1] . '-' . $dateArray[2];

    $newdate = date('y-m-d', strtotime($modifyDate)) . ' ' . $newstring[17];
    require_once 'database.php';
    $sql = "INSERT INTO `bkashsmsdb`(transaction_amount,from_account_number,to_account_number,transaction_fee,account_balance,transaction_id,transaction_date_time,transaction_type,message)
    VALUES('$newtransaction_amount','$from_account_number','$to_account_number','$transaction_fee','$newaccountbalance','$transaction_id','$newdate','$transaction_type','$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}


//payment
function processPayment($string)
{
    $newstring = explode(' ', $string);
    /*    return array(
            'transaction_amount' => $newstring[2] . ' ' . $newstring[1],
            'from_account_number' => "N/A",
            'to_account_number' => $newstring[4],
            'transaction_fee' => $newstring[11] . ' ' . $newstring[12],
            'account_balance' => $newstring[15] . ' ' . $newstring[14],
            'transaction_id' => $newstring[17],
            'transaction_date_time' => $newstring[19] . ' ' . $newstring[20],
            'created_date_time' => "N/A",
            'transaction_type' => $newstring[0],
            'message' => "N/A"
        );*/

    $transaction_amount = rtrim($newstring[2], '.');
    $newtransaction_amount=str_replace(",","","$transaction_amount");
    $from_account_number = "N/A";
    $to_account_number = $newstring[4];
    $transaction_fee = $newstring[11] . ' ' . $newstring[12];
    $account_balance = rtrim($newstring[15], '.');
    $newaccountbalance=str_replace(",","","$account_balance");
    $transaction_id = $newstring[17];
    $transaction_date_time = $newstring[19];
    $transaction_type = $newstring[0];
    $message = "N/A";
    $dateArray = explode('/', $transaction_date_time);

    $modifyDate = $dateArray[0] . '-' . $dateArray[1] . '-' . $dateArray[2];

    $newdate = date('y-m-d', strtotime($modifyDate)) . ' ' . $newstring[20];
    require_once 'database.php';
    $sql = "INSERT INTO `bkashsmsdb`(transaction_amount,from_account_number,to_account_number,transaction_fee,account_balance,transaction_id,transaction_date_time,transaction_type,message)
    VALUES('$newtransaction_amount','$from_account_number','$to_account_number','$transaction_fee','$newaccountbalance','$transaction_id','$newdate','$transaction_type','$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}

//received
function processReceived($string)
{
    $newstring = explode(' ', $string);
    /*   return array(
           'transaction_amount' => $newstring[4] . ' ' . $newstring[3],
           'from_account_number' => $newstring[6],
           'to_account_number' => "N/A",
           'transaction_fee' => $newstring[11] . ' ' . $newstring[10],
           'account_balance' => $newstring[14] . ' ' . $newstring[13],
           'transaction_id' => $newstring[16],
           'transaction_date_time' => $newstring[18] . ' ' . $newstring[19],
           'created_date_time' => "N/A",
           'transaction_type' => $newstring[2],
           'message' => "N/A"
       );*/

    $transaction_amount = rtrim($newstring[4], '.');
    $newtransaction_amount=str_replace(",","","$transaction_amount");
    $from_account_number = $newstring[6];
    $to_account_number = "N/A";
    $transaction_fee = $newstring[11] . ' ' . $newstring[10];
    $account_balance = rtrim($newstring[14], '.');
    $newaccountbalance=str_replace(",","","$account_balance");
    $transaction_id = $newstring[16];
    $transaction_date_time = $newstring[18] . ' ' . $newstring[19];
    $transaction_type = $newstring[2];
    $message = "N/A";
    $dateArray = explode('/', $transaction_date_time);

    $modifyDate = $dateArray[0] . '-' . $dateArray[1] . '-' . $dateArray[2];

    $newdate = date('y-m-d', strtotime($modifyDate)) . ' ' . $newstring[19];
    require_once 'database.php';
    $sql = "INSERT INTO `bkashsmsdb`(transaction_amount,from_account_number,to_account_number,transaction_fee,account_balance,transaction_id,transaction_date_time,transaction_type,message)
    VALUES('$newtransaction_amount','$from_account_number','$to_account_number','$transaction_fee','$newaccountbalance','$transaction_id','$newdate','$transaction_type','$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}

//sendmoney
function processSendMoney($string)
{
    $newstring = explode(' ', $string);
    /* return array(
         'transaction_amount' => $newstring[3] . ' ' . $newstring[2],
         'from_account_number' => "N/A",
         'to_account_number' => $newstring[5],
         'transaction_fee' => $newstring[11] . ' ' . $newstring[10],
         'account_balance' => $newstring[14] . ' ' . $newstring[13],
         'transaction_id' => $newstring[16],
         'transaction_date_time' => $newstring[18] . ' ' . $newstring[19],
         'created_date_time' => "N/A",
         'transaction_type' => $newstring[0] . $newstring[1],
         'message' => "N/A"
     );*/
    $transaction_amount = rtrim($newstring[3], '.');
    $newtransaction_amount=str_replace(",","","$transaction_amount");;
    $from_account_number = "N/A";
    $to_account_number = $newstring[5];
    $transaction_fee = $newstring[11] . ' ' . $newstring[10];
    $account_balance = rtrim($newstring[14], '.');
    $newaccountbalance=str_replace(",","","$account_balance");
    $transaction_id = $newstring[16];
    $transaction_date_time = $newstring[18];
    $transaction_type = $newstring[0] . $newstring[1];
    $message = "N/A";

    $dateArray = explode('/', $transaction_date_time);

    $modifyDate = $dateArray[0] . '-' . $dateArray[1] . '-' . $dateArray[2];

    $newdate = date('y-m-d', strtotime($modifyDate)) . ' ' . $newstring[19];
    require_once 'database.php';
    $sql = "INSERT INTO `bkashsmsdb`(transaction_amount,from_account_number,to_account_number,transaction_fee,account_balance,transaction_id,transaction_date_time,transaction_type,message)
    VALUES('$newtransaction_amount','$from_account_number','$to_account_number','$transaction_fee','$newaccountbalance','$transaction_id','$newdate','$transaction_type','$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}

//BuyAirtime
function processBuyAirtime($string)
{
    $newstring = explode(' ', $string);
    /* return array(
         'transaction_amount' => $newstring[7] . ' ' . $newstring[6],
         'from_account_number' => "N/A",
         'to_account_number' => $newstring[9],
         'transaction_fee' => "N/A",
         'account_balance' => "N/A",
         'transaction_id' => "N/A",
         'transaction_date_time' => "N/A",
         'created_date_time' => "N/A",
         'transaction_type' => $newstring[2] . $newstring[3],
         'message' => $newstring[11]
     );*/


    $transaction_amount = rtrim($newstring[7], '.');
    $newtransaction_amount=str_replace(",","","$transaction_amount");
    $from_account_number = "N/A";
    $to_account_number = $newstring[9];
    $transaction_fee = "N/A";
    $account_balance = "N/A";
    $transaction_id = "N/A";
    $transaction_date_time = "N/A";
    $transaction_type = $newstring[2] . $newstring[3];
    $message = $newstring[11];

    require_once 'database.php';
    $sql = "INSERT INTO `bkashsmsdb`(transaction_amount,from_account_number,to_account_number,transaction_fee,account_balance,transaction_id,transaction_date_time,transaction_type,message)
    VALUES('$newtransaction_amount','$from_account_number','$to_account_number','$transaction_fee','$account_balance','$transaction_id','$transaction_date_time','$transaction_type','$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}

//Received Airtime

function processReceivedAirtime($string)
{
    $newstring = explode(' ', $string);
    /*    return array(
            'transaction_amount' => $newstring[5] . ' ' . $newstring[4],
            'from_account_number' => "N/A",
            'to_account_number' => $newstring[7],
            'transaction_fee' => $newstring[10] . ' ' . $newstring[9],
            'account_balance' => $newstring[13] . ' ' . $newstring[12],
            'transaction_id' => $newstring[15],
            'transaction_date_time' => $newstring[17] . ' ' . $newstring[18],
            'created_date_time' => "N/A",
            'transaction_type' => $newstring[0] . $newstring[1],
            'message' => $newstring[19] . ' ' . $newstring[20] . ' ' . $newstring[21]
        );*/
    $transaction_amount = rtrim($newstring[5], '.');
    $newtransaction_amount=str_replace(",","","$transaction_amount");
    $from_account_number = "N/A";
    $to_account_number = $newstring[7];
    $transaction_fee = $newstring[10] . ' ' . $newstring[9];
    $account_balance = rtrim($newstring[13], '.');
    $newaccountbalance=str_replace(",","","$account_balance");
    $transaction_id = $newstring[15];
    $transaction_date_time = $newstring[17];
    $transaction_type = $newstring[0] . $newstring[1];
    $message = $newstring[19] . ' ' . $newstring[20] . ' ' . $newstring[21];

    $dateArray = explode('/', $transaction_date_time);

    $modifyDate = $dateArray[0] . '-' . $dateArray[1] . '-' . $dateArray[2];

    $newdate = date('y-m-d', strtotime($modifyDate)) . ' ' . $newstring[18];
    require_once 'database.php';
    $sql = "INSERT INTO `bkashsmsdb`(transaction_amount,from_account_number,to_account_number,transaction_fee,account_balance,transaction_id,transaction_date_time,transaction_type,message)
    VALUES('$newtransaction_amount','$from_account_number','$to_account_number','$transaction_fee','$newaccountbalance','$transaction_id','$newdate','$transaction_type','$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}