<?php
require_once './Function/viewData.php';
$request=$_SERVER['REQUEST_METHOD'];

switch ($request){
    case 'GET':
        getMethod();
        break;

    case 'DELETE':
        deleteMethod();
        break;

    case 'PUT':
        echo "Update";
        break;
    case 'POST':
        $data= json_decode(file_get_contents('php://input'), true);
        postMethod($data);
        break;
    default:
        echo "no switch touched!";
}

