<?php
session_start();

include("PFBC/Form.php");

if(isset($_POST["form"])) {
	PFBC\Form::isValid($_POST["form"]);
	include("model_db.inc.php");
	$model_db->query("INSERT INTO users (mail, password) VALUES ('" . $_POST['mail'] . "', '" . md5($_POST["password"]) . "')");
	header("Location: sign_in.php");
	exit();	
}

include("header.php");

$active = "registration.php";
include('navigation.php');
echo $navigation;

$form = new PFBC\Form("registration");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus")
));
$form->addElement(new PFBC\Element\HTML('<legend>Registrace</legend>'));
$form->addElement(new PFBC\Element\Hidden("form", "registration"));
$form->addElement(new PFBC\Element\Email("Email:", "mail", array("required" => 1)));
$form->addElement(new PFBC\Element\Password("Heslo:", "password", array("required" => 1)));
$form->addElement(new PFBC\Element\Button("Registrovat"));
$form->addElement(new PFBC\Element\Button("Zpět", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>
jeste již zaregistrován, <a href="sign_in.php">přihlašte se</a>
<?php include("foot.php");