<?php

/* destroy session data */
session_start();
session_destroy();
$_SESSION = array();

/* redirect to public page */
header('Location: front.php');

?>
