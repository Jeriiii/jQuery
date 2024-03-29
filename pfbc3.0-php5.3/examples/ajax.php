<?php
session_start();
error_reporting(E_ALL);
include("../PFBC/Form.php");

if(isset($_POST["form"])) {
	if(PFBC\Form::isValid($_POST["form"])) {
		header("Content-type: application/json");
		echo file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . urlencode($_POST["Address"]) . "&sensor=false");
	}
	else
		PFBC\Form::renderAjaxErrorResponse($_POST["form"]);
	exit();
}	

include("../header.php");
?>

<div class="page-header">
	<h1>Ajax</h1>
</div>

<p>PFBC provides several properties/methods for facilitating ajax submissions.  To get started, you'll first need to set the ajax property in
the form's configure method.  The ajaxCallback property can also be included in the configure method if you'd like a javascript function to called
after the form's data has been submitted.  In the example belew a callback function has been set to extract the latitude/longitude information from a
json response.</p>

<p>The validation process for an ajax submission also differs slightly from that of a standard submission.  If the form's isValid method 
returns false, you will need to invoke the renderAjaxErrorResponse method, which returns a json response containing the appropriate error messages.  
These errors will then be displayed in the form so the user can correct and resubmit.</p>

<?php
$form = new PFBC\Form("ajax");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery"),
	"ajax" => 1,
	"ajaxCallback" => "parseJSONResponse",
	"novalidate" => ""
));
$form->addElement(new PFBC\Element\Hidden("form", "ajax"));
$form->addElement(new PFBC\Element\HTML('<legend>Using the Google Geocoding API</legend>'));
$form->addElement(new PFBC\Element\Textbox("Address:", "Address", array("required" => 1)));
$form->addElement(new PFBC\Element\HTML('<div id="GoogleGeocodeAPIReaponse" style="display: none;">'));
$form->addElement(new PFBC\Element\Textbox("Latitude/Longitude:", "LatitudeLongitude", array("readonly" => "readonly")));
$form->addElement(new PFBC\Element\HTML('</div>'));
$form->addElement(new PFBC\Element\Button("Geocode", "submit", array("icon" => "search")));
$form->render();
?>

<script type="text/javascript">
	function parseJSONResponse(latlng) {
		var form = document.getElementById("ajax");
		if(latlng.status == "OK") {
			var result = latlng.results[0];
			form.LatitudeLongitude.value = result.geometry.location.lat + ', ' + result.geometry.location.lng;
		}
		else
			form.LatitudeLongitude.value = "N/A";

		document.getElementById("GoogleGeocodeAPIReaponse").style.display = "block";
	}
</script>

<?php
echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("ajax");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery"),
	"ajax" => 1,
	"ajaxCallback" => "parseJSONResponse",
));
$form->addElement(new PFBC\Element\Hidden("form", "ajax"));
$form->addElement(new PFBC\Element\Textbox("Address:", "Address", array("required" => 1)));
$form->addElement(new PFBC\Element\HTMLExternal(\'<div id="GoogleGeocodeAPIReaponse" style="display: none;">\'));
$form->addElement(new PFBC\Element\Textbox("Latitude/Longitude:", "LatitudeLongitude", array("readonly" => "readonly")));
$form->addElement(new PFBC\Element\HTMLExternal(\'</div>\'));
$form->addElement(new PFBC\Element\Button("Geocode", "submit", array("icon" => "search")));
$form->render();
?>

<script type="text/javascript">
	function parseJSONResponse(latlng) {
		var form = document.getElementById("ajax");
		if(latlng.status == "OK") {
			var result = latlng.results[0];
			form.LatitudeLongitude.value = result.geometry.location.lat + \', \' + result.geometry.location.lng;
		}
		else
			form.LatitudeLongitude.value = "N/A";

		document.getElementById("GoogleGeocodeAPIReaponse").style.display = "block";
	}
</script>

<?php
//----------AFTER THE FORM HAS BEEN SUBMITTED----------
if(isset($_POST["form"])) {
	if(PFBC\Form::isValid($_POST["form"])) {
		header("Content-type: application/json");
		echo file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . urlencode($_POST["Address"]) . "&sensor=false");
	}
	else
		PFBC\Form::renderAjaxErrorResponse($_POST["form"]);
	exit();
}	
?>', true), '</pre>';

include("../footer.php");
