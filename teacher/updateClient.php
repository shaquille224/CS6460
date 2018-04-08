<?php
		//session_start();
    ob_start();
    include('include/common.php');
    include('include/header.php');
		$PersonID = $_SESSION['person_id'];
		$FirstName = $_POST['first'];
		$Phone_number = $_POST['phone'];
		$Id_number = $_POST['id_number'];
		$Email = $_POST['email'];


		$id = $_SESSION['client_id'];

		$sql_2 = "UPDATE users  SET name = '$FirstName', phone='$Phone_number',  email = '$Email' WHERE id = $Id_number";
		$result_2 = mysqli_query($db, $sql_2);
		header("location:clientDetail.php?id=$id")
?>
