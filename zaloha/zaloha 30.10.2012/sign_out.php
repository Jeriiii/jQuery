<?php
session_start();
session_destroy();
session_start();
$_SESSION["message"] = "Byl jste úspěšně odhlášen";
$_SESSION["message_type"] = "success";
header("Location: sign_in.php")
?>
