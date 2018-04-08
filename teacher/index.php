<?php

session_start();
if (empty($_SESSION['username']) ){
    header("Location: auth.php");
    die();
}else{
    header("Location: site.php");
    die();
}
?>
