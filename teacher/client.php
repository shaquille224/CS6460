<?php include('include/common.php'); ?>
<?php include('include/header.php'); ?>
<title>Client</title>

</head>
<body>
	<div class="container">
		<?php include('include/site_menu.php'); ?>
        <?php
                $PersonID = $_SESSION['person_id'];
                echo "PersonID: $PersonID";
        ?>
        <form action="clientInfo.php" method="POST">
            <br>
            <p><b>Type in the client name you want to search</b></p>
            <br>
            <input type="text" name="first" placeholder="Name"><br><br>
						<input type="text" name="id" placeholder="Client ID"><br><br>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

		<br>


		<?php include('include/error.php'); ?>
	</div>

	<?php include('include/footer.php'); ?>
