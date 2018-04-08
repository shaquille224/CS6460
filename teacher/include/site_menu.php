
<?php
	$PersonID = $_SESSION['person_id'];

	$query = "SELECT * " .
			"FROM teacher " .
			"WHERE id={$PersonID}";

	$result = mysqli_query($db, $query);

	if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
		array_push($error_msg,  "SELECT ERROR: find user info" . __FILE__ ." : ". __LINE__ );
	}

    $count = mysqli_num_rows($result);

	if (!empty($result) && ($count > 0) ) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            print("<div class='row'>");
	            print("<div class='col-md-6'>");
		            print("Authenticated User: {$row['name']} ");
	            print("</div>");
            print("<div class='col-md-6' align='right'>");
            print("<form action='logout.php'>");
		    print("<input type='submit' value='Logout' class='btn btn-primary' />");
			print("</form>");
            print("</div>");
            print("</div>");
    }

?>

<ul class="nav nav-tabs">
  <li role="presentation" <?php if($current_filename=='site.php') echo "class='active'"; ?>><a href="site.php">Dashboard</a></li>
  <li role="presentation" <?php if($current_filename=='client.php') echo "class='active'"; ?>><a href="client.php">Client</a></li>
</ul>
