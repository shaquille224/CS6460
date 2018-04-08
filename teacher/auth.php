<?php include('include/common.php');

if( $_SERVER['REQUEST_METHOD'] == 'POST') {

	$enteredUserName = mysqli_real_escape_string($db, $_POST['username']);
	$enteredPassword = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($enteredUserName)) {
            array_push($error_msg,  "Please enter a username.");
    }

	if (empty($enteredPassword)) {
			array_push($error_msg,  "Please enter a password.");
	}

    if ( !empty($enteredUserName) && !empty($enteredPassword) )   {

        $query = "SELECT * " .
		         "FROM teacher " .
		         "WHERE username='$enteredUserName'";

        $result = mysqli_query($db, $query);
        include('include/show_queries.php');
        $count = mysqli_num_rows($result);

        if (!empty($result) && ($count > 0) ) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $storedPassword = $row['password'];

            $options = [
                'cost' => 8,
            ];

             //convert the plaintext passwords to their respective hashses
             // 'michael123' = $2y$08$kr5P80A7RyA0FDPUa8cB2eaf0EqbUay0nYspuajgHRRXM9SgzNgZO
            $storedHash = password_hash($storedPassword, PASSWORD_DEFAULT , $options);   //may not want this if $storedPassword are stored as hashes (don't rehash a hash)
            $enteredHash = password_hash($enteredPassword, PASSWORD_DEFAULT , $options);

            if($showQueries){
                array_push($query_msg, "Plaintext entered password: ". $enteredPassword);
                //Note: because of salt, the entered and stored password hashes will appear different each time
                array_push($query_msg, "Entered Hash:". $enteredHash);
                array_push($query_msg, "Stored Hash:  ". $storedPassword . NEWLINE);  //note: change to storedHash if tables store the plaintext password value
                //unsafe, but left as a learning tool uncomment if you want to log passwords with hash values
                //error_log('username: '. $enteredUserName  . ' password: '. $enteredPassword . ' hash:'. $enteredHash);
            }

            //depends on if you are storing the hash $storedHash or plaintext $storedPassword
            if (password_verify($enteredPassword, $storedHash) ) {

                array_push($query_msg, "Password is Valid! ");
                $_SESSION['username'] = $enteredUserName;
                $_SESSION['person_id'] = $row['id'];
                //$_SESSION['site_id'] = $row['site_id'];
                array_push($query_msg, "logging in... ");
                header(REFRESH_TIME . 'url=site.php');		//to view the password hashes and login success/failure

            } else {
                array_push($error_msg, "Login failed: " . $enteredUserName . NEWLINE);
                array_push($error_msg, "To demo enter: ". NEWLINE . "michael@bluthco.com". NEWLINE ."michael123");
            }

        } else {
                array_push($error_msg, "The username entered does not exist: " . $enteredUserName);
            }
    }
}
?>

	<?php include 'include/header.php'; ?>
	<title>Login</title>
</head>
<div class="container">
	<?php include('include/front_menu.php'); ?>
	<form action="#" method="post">
		<div class="form-group">
			<label for="username">Username:</label>
			<input type="text" name="username" value="Teacher2" class="form-control" />
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" value="198806" class="form-control" />
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
		<button type="reset" class="btn btn-primary">Reset</button>
	</form>
	<?php include('include/error.php'); ?>
</div>

<?php include('include/footer.php'); ?>
