<?php include('include/common.php'); ?>

<?php
ob_start();
include('include/header.php');

?>
<title>Client Information</title>
</head>
<body>
    <div class="container">
        <?php include('include/site_menu.php'); ?>
        <br>
        <table class="table table-hover">
		<thead>
            <tr>
            <td><b>Id Number</b></td>
            <td><b>Name</b></td>
            <td><b>Phone Number</b></td>
            <td><b>Email</b></td>
            </tr>
			</thead>
			<tbody>
      <?php

        $FirstName = $_POST['first'];

				$ClientId = $_POST['id'];

                //$PersonID = $_SESSION['person_id'];
				$query_1 = "SELECT count(*) AS client_number FROM users WHERE name LIKE '%$FirstName%' AND id LIKE '%$ClientId%'";

                $result_1 = mysqli_query($db, $query_1);

                if (!empty($result_1) && (mysqli_num_rows($result_1) == 0) ) {
                    array_push($error_msg,  "SELECT ERROR: find site info" . __FILE__ ." : ". __LINE__ );
                    }
				if($row = mysqli_fetch_assoc($result_1)){
					//echo $row['client_number'];
					if ((int)$row['client_number']>4){
						echo "More than four results, please re-search or create an new one";
						print "<br><br><a href=\"client.php\"><span class='btn btn-primary' aria-hidden='true'>Back To Search</span></a>";
					}elseif((int)$row['client_number']==0 ){
						echo "Cannot find result, please re-search or create an new one";
						print "<br><br><a href=\"client.php\"><span class='btn btn-primary' aria-hidden='true'>Back To Search</span></a>";
					}else{
						$query = "SELECT * FROM users WHERE name LIKE '%$FirstName%'  AND id LIKE '%$ClientId%' LIMIT 4";

						$result = mysqli_query($db, $query);

						if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
							array_push($error_msg,  "SELECT ERROR: find site info" . __FILE__ ." : ". __LINE__ );
						}

						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){

							print "<tr>";
              print "<td>{$row['id']}</td>";
              print "<td>{$row['name']}</td>";
							print "<td>{$row['phone']}</td>";
							print "<td>{$row['email']}</td>";
							print "<td><a href=\"clientDetail.php?id=$row[id]\"><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>";
							print "</tr>";
						}
					}
				}
    ?>
		</tbody>
        </table>

        <form action="addClient.php" method="POST">
            <br>
            <p><b>Put client name you want add</b></p>
            <br>
            <input type="text" name="student_id" placeholder="Student ID"><br><br>
            <input type="text" name="first" placeholder="Name"><br><br>
            <input type="text" name="phone" placeholder="Phone Number"><br><br>
            <input type="text" name="email" placeholder="Email"><br><br>
            <input type="text" name="username" placeholder="Username"><br><br>
            <input type="text" name="password" placeholder="Password"><br><br>

            <button type="submit" class="btn btn-primary">ADD</button>
        </form>
        <br>
        <?php include('include/error.php'); ?>
    </div>
    <?php include('include/footer.php'); ?>
