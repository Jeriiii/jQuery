<?php

$id_spojeni = mysql_connect('localhost','root','a10b0618p');

if (!$id_spojeni)
die('Spojeni s MySQL databazi se nezdarilo.');

$vysledek_vybrani = mysql_select_db('cinema',$id_spojeni);
if (!$vysledek_vybrani)
die('Databazi pokus se nam nepodarilo vybrat.');

unset($_POST["Zarezervovat"]);
$string = "";
foreach ($_POST as $value)
{
	$serie_and_seat = explode("_", $value );
	$serie = $serie_and_seat[1];
	$seat = $serie_and_seat[0];
	$query = "
		INSERT INTO seats (id_hall, serie, seat)
		VALUES (1," . $serie . ",". $seat ." );
	";
	
	$vysledek = mysql_query($query,$id_spojeni);
	$string = $string . $query;
	if (!$vysledek)
	die('Nepodarilo se zarezervovat sedadlo: ' . $seat . ' v rade:' . $serie);
}
//die($string."");
mysql_close($id_spojeni);

header('Location: index.php');

?>