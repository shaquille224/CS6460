<?php
ob_start();
include('include/common.php');
include('include/header.php');
$StudentID = $_POST['student_id'];
$Name = $_POST['first'];
$Phone_number = $_POST['phone'];
$Email = $_POST['email'];
$Username = $_POST['username'];
$Password = $_POST['password'];
$sql_3 = "INSERT INTO users (id, username, password, email, name, phone) VALUES('$StudentID', '$Username', MD5('$Password'), '$Email', '$Name', '$Phone_number')";
$result_3 = mysqli_query($db,$sql_3);
sleep(1);
$sql_2 = "INSERT INTO personlocation (person_id, library, gym, activitycenter) VALUES('$StudentID', 0, 0, 0)";
$result_2 = mysqli_query($db,$sql_2);
header("Location: client.php");
exit;
?>
