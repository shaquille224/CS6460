<?php
 
//creating response array
$response = array();
 
if($_SERVER['REQUEST_METHOD']=='POST'){
 
    //getting values
    $id = $_POST['id'];
    $library = $_POST['library'];
    $gym = $_POST['gym'];
    $activitycenter = $_POST['activitycenter'];
    //including the db operation file
    require_once '../includes/DbOperation.php';
 
    $db = new DbOperation();
    $result = $db->createLocation($id, $library, $gym, $activitycenter);

    //inserting values 
    if($result == DATA_ADDED){
        $response['error']=false;
        $response['message']='Data added successfully';
    }elseif ($result == DATA_NOT_ADDED){
 
        $response['error']=true;
        $response['message']='Could not add data';
    }elseif($result == DATA_CREATED) {
        $response['error']=false;
        $response['message']='Data created';
    }else {
        $response['error']=true;
        $response['message']='Could not create data';
    }
 
}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);