<?php
include("model_db.inc.php");

$model_db->query("DELETE FROM elements WHERE id = '" . $_GET["id_element"] . "'");
?>
