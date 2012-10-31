<?php
if (!isset($_SESSION["logged"])) {
	$_SESSION["message"] = "Nejdřív se musíte přihlásit.";
	$_SESSION["message_type"] = "error";
	header("Location: sign_in.php");
}
?>
