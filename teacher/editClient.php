<?php include('include/common.php'); ?>

<?php include('include/header.php'); ?>

<title>Client Information</title>
</head>
<body>
    <div class="container">
        <?php include('include/site_menu.php'); ?>
        <br>
        <?php
            $PersonID = $_SESSION['person_id'];
            $id = $_GET['id'];
            $sql = "SELECT name, phone, id, email FROM users WHERE id = $id";
            $result = mysqli_query($db, $sql);

            if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                array_push($error_msg,  "SELECT ERROR: find site info" . __FILE__ ." : ". __LINE__ );
            }

            if($row = mysqli_fetch_assoc($result)){

				print '<br>';
				print '<form action="updateClient.php" method="POST">';
				print '<br>';
				print '<p><b>Put client name you want add</b></p>';
				print '<br>';
				echo("<table>");
				echo("<tr>");
				echo("<td>");
				echo("<label for='first_name'>First Name:</label>");
				echo("</td>");
				print "<td><input type='text' class='form-control' name='first'  placeholder='FirstName' value={$row['name']}></td>";
				print "</tr>";
				print "<tr>";
				print "<td><label for='phone_number'>Phone Number:</label></td>";
				print "<td><input type='text' class='form-control' name='phone'  placeholder='Phone Number' value={$row['phone']}></td>";
				print "</tr>";
				print "<tr>";
				print "<td><label for='id_number'>ID Number:</label></td>";
				print "<td><input type='text' class='form-control' name='id_number'  placeholder='ID' value={$row['id']} readonly></td>";
				print "</tr>";
				print "<tr>";
				print "<td><label for='email'>Email:</label></td>";
				print "<td><input type='text' class='form-control' name='email' placeholder='Email' value={$row['email']}></td>";
				print "</tr>";
				print "<tr>";
				print "<td> <button type='submit' href='updateClient.php?id=$id' class='btn btn-primary'>UPDATE</button></td>";
				print "</tr>";
				echo("</table>");
            }
        ?>



                <?php

                    $id = $_GET['id'];
                    $_SESSION['client_id'] = $id;

                ?>

               <!-- <a href="updateClient.php?id=$id" class="btn btn-primary">UPDATE</button>-->


        </form>
        <br>

        <?php include('include/error.php'); ?>
    </div>
    <?php include('include/footer.php'); ?>
