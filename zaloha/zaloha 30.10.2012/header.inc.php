<?php
$directory = dirname(__FILE__);

$bootstrapPath = "PFBC/Resources/bootstrap/";
if(strpos(getcwd(), "/examples") !== false) {
	$bootstrapPath = "../" . $bootstrapPath;
	$examplePath = "";
	$indexPath = "../index.php";
}
else {
	$examplePath = "examples/";
	$indexPath = "";
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Kapitola 6</title>
<!--		<link href="<?php echo $bootstrapPath; ?>css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo $bootstrapPath; ?>css/bootstrap-responsive.min.css" rel="stylesheet" />-->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
		<div class="container-fluid">
		<?php if(isset($message)) echo $message?>