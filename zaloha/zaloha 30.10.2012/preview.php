<?php
session_start();
include("message.php");
include("authorization.php");

include("header.php");

$active = "preview.php";
include('navigation.php');
echo $navigation;

include("model_db.inc.php");
$elements = $model_db->query("SELECT * FROM elements WHERE id_user = '" . $_SESSION["id_user"] . "'");

echo "<h2>Zarezervovaná sedadla:</h2>";
echo "<table class='table'>";
echo "<thead><th>sál</th><th>řada</th><th>sedadlo</th></thead>";

while($element = mysql_fetch_assoc($elements))
{
	echo "<tr>";
	echo	"<td>" . $element["id_place"] . "</td>
		<td>" . $element["serie"] . "</td>
		<td>" . $element["element"] . "</td><td>
		<a class='btn btn-danger' href='cancel_reservation.php?id_element=" . $element["id"] . "'>zrušit rezervaci</a></td>";
	echo "</tr>";
}

echo "</table>";
?>
