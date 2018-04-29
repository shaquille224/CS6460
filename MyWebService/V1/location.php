<?php
/**
 * Created by PhpStorm.
 * User: Belal
 * Date: 29/05/17
 * Time: 8:39 PM
 */
 
require_once '../includes/DbOperation.php';
 
$response = array();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    if (isset($_POST['username']) ){
 
        $db = new DbOperation();
        $response['error'] = false;
        $response['location'] = $db->getLocationById($_POST['username']);
 
    } else {
        $response['error'] = true;
        $response['message'] = 'Parameters are missing';
    }
 
} else {
    $response['error'] = true;
    $response['message'] = "Request not allowed";
}
 
echo json_encode($response);