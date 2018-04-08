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


        <?php

            $PersonID = $_SESSION['person_id'];
            $id = $_GET['id'];

            $sql = "SELECT id, name, email, phone FROM users WHERE id = $id";
            $result = mysqli_query($db, $sql);

            if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                array_push($error_msg,  "SELECT ERROR: find site info" . __FILE__ ." : ". __LINE__ );
            }

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                print "<b>{$row['name']}  </b><br>";
                print "<b>Phone Number:</b> {$row['phone']}<br>";
                print "<b>ID:</b>           {$row['id']}<br>";
                print "<b>Email:</b>  {$row['email']}<br>";
                print "<hr />";

            }
        ?>

        <form>
            <?php

            $PersonID = $_SESSION['person_id'];
            $id = $_GET['id'];

            print "<a href=\"editClient.php?id=$id\" class=\"btn btn-primary\">Edit</a>"
            ?>
        </form>

        <br>
        <p><b>Student Location Information</b></p>
        <br>
        <table class="table table-hover">
		<thead>
				<tr>
          <th>Person ID</th>
					<th>Library</th>
          <th>Gym</th>
					<th>Activity Center</th>
				</tr>
			</thead>
			<tbody>
            <?php
            $PersonID = $_SESSION['person_id'];
            $id = $_GET['id'];

            $sql = "SELECT person_id, library, gym, activitycenter FROM personlocation WHERE person_id = $id";
            $result = mysqli_query($db, $sql);

            if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                array_push($error_msg,  "SELECT ERROR: find site info" . __FILE__ ." : ". __LINE__ );
            }

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                print "<tr>";
                print "<td>{$row['person_id']}</td>";
                print "<td>{$row['library']}</td>";
                print "<td>{$row['gym']}</td>";
				        print "<td>{$row['activitycenter']}</td>";
                print "</tr>";

            }

        ?>
		</tbody>
        </table>
        <hr />
        <br>

        <?php include('include/error.php'); ?>
    </div>
    <?php include('include/footer.php'); ?>
