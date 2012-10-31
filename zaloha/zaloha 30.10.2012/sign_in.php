<?php
session_start();
error_reporting(E_ALL);

include("PFBC/Form.php");

if(isset($_POST["form"])) {
	PFBC\Form::isValid($_POST["form"]);
	if (isset($_POST["mail"])) {
		include("model_db.inc.php");
		$id_user = mysql_result($model_db->query("SELECT id FROM users WHERE mail = '" . $_POST["mail"] . "' AND password = '" . md5($_POST["password"]) . "'"), 0);
		
		if ($id_user) {
			session_regenerate_id(); // ochrana před Session Fixation
			$_SESSION["logged"] = true;
			$_SESSION["id_user"] = $id_user;
			header("Location: " . $_SERVER["PHP_SELF"] . "/../index.php");
			exit();
		}else{
			$_SESSION["message"] = "Uživatelské jméno nebo heslo je chybné.";
			$_SESSION["message_type"] = "error";
		}
	}	
}
if (isset($_SESSION["logged"])) {
	header("Location: index.php");
}

include("message.php");
include("header.php");

$active = "sign_in.php";
include('navigation.php');
echo $navigation;

$form = new PFBC\Form("login");
$form->addElement(new PFBC\Element\HTML('<legend>Přihlášení</legend>'));
$form->addElement(new PFBC\Element\Hidden("form", "login"));
$form->addElement(new PFBC\Element\Email("Emailová adresa:", "mail", array("required" => 1)));
$form->addElement(new PFBC\Element\Password("Heslo:", "password", array("required" => 1)));
$form->addElement(new PFBC\Element\Button("Přihlášení"));
$form->render();
?>

nejsteli zaregistrovaní, <a href="registration.php">registrujte se nyní</a>

<?php include("foot.php");