<?php
session_start();
error_reporting(E_ALL);
include("../PFBC/Form.php");

if(isset($_POST["form"])) {
	PFBC\Form::isValid($_POST["form"]);
	header("Location: " . $_SERVER["PHP_SELF"]);
	exit();	
}

include("../header.php");
?>

<div class="page-header">
	<h1>Validation</h1>
</div>

<p>In PFBC, php validation is achieved in a two step process.  The first step is to apply 
validation rules to your form elements via the element's validation property.  Some elements
including Captcha, Color, Date, Email, jQueryUIDate, Month, Number, Url, and Week have validation
rules applied by default.</p>

<p>Secondly, you need to call the Form class' isValid static method once the form's data has been submitted.
This function will return true/false.  If false is returned, it indicates that one or more errors
occurred.  You will then need to redirect users back to the form to correct and resubmit.  Here's an example
of the isValid method.</p>

<?php
echo '<pre>', highlight_string('<?php
//----------AFTER THE FORM HAS BEEN SUBMITTED----------
if(PFBC\Form::isValid("<replace with unique form identifier>")) {
	/*The form\'s submitted data has been validated.  Your script can now proceed with any 
	further processing required.*/
}
else {
	header("Location: <replace with form url>");
	/*Validation errors have been found.  We now need to redirect back to the 
	script where your form exists so the errors can be corrected and the form
	re-submitted.*/
}	
?>', true), '</pre>';
?>

<p>PFBC supports 8 types of validation rules: AlphaNumeric, Captcha, Date, Email, Numeric, RegExp, Required, and Url.  Here's
how they are applied to elements.</p>

<?php
$form = new PFBC\Form("validation");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new PFBC\Element\Hidden("form", "validation"));
$form->addElement(new PFBC\Element\Textbox("Require:", "Required", array(
	"required" => 1,
	"longDesc" => "The required property provides a shortcut for applying the Required class to the element's
	validation property.  If supported, the HTML5 required attribute will also provide client-side validation."
)));
$form->addElement(new PFBC\Element\Textbox("Regular Expression:", "RegularExpression", array(
	"validation" => new PFBC\Validation\RegExp("/pfbc/", "Error: The %element% field must contain following keyword - \"pfbc\"."),
	"longDesc" => "The RegExp validation class provides the means to apply custom validation to an element.  Its constructor includes two parameters: the regular expression pattern to test and the error message to display if the pattern is not matched."
)));
$form->addElement(new PFBC\Element\Email("Email:", "Email", array(
	"longDesc" => "The Email element applies the Email validation rule by default.  If supported, HTML5
	validation will also be provided client-side."
)));
$form->addElement(new PFBC\Element\Number("Numeric:", "Numeric", array(
	"longDesc" => "The Number element applies the Numeric validation rule by default.  If supported, HTML5
	validation will also be provided client-side."
)));
$form->addElement(new PFBC\Element\Url("Url:", "Url", array(
	"longDesc" => "The Url element applies the Url validation rule by default.  If supported, HTML5
	validation will also be provided client-side."
)));
$form->addElement(new PFBC\Element\Date("Date:", "Date", array(
	"longDesc" => "The Date element applies the RegExp validation rule by default - ensuring the following date format YYYY-MM-DD
	is adhered to."
)));
$form->addElement(new PFBC\Element\jQueryUIDate("", "Date2", array(
	"longDesc" => "The jQueryUIDate element applies the Date validation rule by default - ensuring the submitted value satisfies <a href=\"http://us3.php.net/manual/en/datetime.construct.php\">PHP's DateTime
	class constructor</a>."
)));
$form->addElement(new PFBC\Element\Textbox("AlphaNumeric:", "AlphaNumberic", array(
	"validation" => new PFBC\Validation\AlphaNumeric,
	"longDesc" => "The AlphaNumeric validation class will verify that the element's submitted value contains only letters, numbers, underscores, and/or hyphens."
)));
$form->addElement(new PFBC\Element\Captcha("Captcha:", array(
	"longDesc" => "The Captcha element applies the Captcha validation, which uses <a href=\"http://www.google.com/recaptcha\">reCaptcha's anti-bot service</a> to reduce spam submissions."
)));
$form->addElement(new PFBC\Element\Email("Multiple Rules:", "Email2", array(
	"validation" => new PFBC\Validation\RegExp("/.*@gmail.com$/", "Error: The %element% field must contain a Gmail address."),
	"longDesc" => "Multiple validation rules can be attached to an element by passing the validation property an array of validation 
	class instances.  This Email element also applies the RegExp validation rule to ensure the supplied email address is from Gmail."
)));
$form->addElement(new PFBC\Element\Button);
$form->addElement(new PFBC\Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("validation");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new PFBC\Element\Hidden("form", "validation"));
$form->addElement(new PFBC\Element\Textbox("Require:", "Required", array(
	"required" => 1,
	"longDesc" => "The required property provides a shortcut for applying the Required class to the element\'s
	validation property.  If supported, the HTML5 required attribute will also provide client-side validation."
)));
$form->addElement(new PFBC\Element\Textbox("Regular Expression:", "RegularExpression", array(
	"validation" => new PFBC\Validation\RegExp("/pfbc/", "Error: The %element% field must contain following keyword - \"pfbc\"."),
	"longDesc" => "The RegExp validation class provides the means to apply custom validation to an element.  Its constructor includes two parameters: the regular expression pattern to test and the error message to display if the pattern is not matched."
)));
$form->addElement(new PFBC\Element\Email("Email:", "Email", array(
	"longDesc" => "The Email element applies the Email validation rule by default.  If supported, HTML5
	validation will also be provided client-side."
)));
$form->addElement(new PFBC\Element\Number("Numeric:", "Numeric", array(
	"longDesc" => "The Number element applies the Numeric validation rule by default.  If supported, HTML5
	validation will also be provided client-side."
)));
$form->addElement(new PFBC\Element\Url("Url:", "Url", array(
	"longDesc" => "The Url element applies the Url validation rule by default.  If supported, HTML5
	validation will also be provided client-side."
)));
$form->addElement(new PFBC\Element\Date("Date:", "Date", array(
	"longDesc" => "The Date element applies the RegExp validation rule by default - ensuring the following date format YYYY-MM-DD
	is adhered to."
)));
$form->addElement(new PFBC\Element\jQueryUIDate("", "Date2", array(
	"longDesc" => "The jQueryUIDate element applies the Date validation rule by default - ensuring the submitted value satisfies <a href=\"http://us3.php.net/manual/en/datetime.construct.php\">PHP\'s DateTime
	class constructor</a>."
)));
$form->addElement(new PFBC\Element\Textbox("AlphaNumeric:", "AlphaNumberic", array(
	"validation" => new PFBC\Validation\AlphaNumeric,
	"longDesc" => "The AlphaNumeric validation class will verify that the element\'s submitted value contains only letters, numbers, underscores, and/or hyphens."
)));
$form->addElement(new PFBC\Element\Captcha("Captcha:", array(
	"longDesc" => "The Captcha element applies the Captcha validation, which uses <a href=\"http://www.google.com/recaptcha\">reCaptcha\'s anti-bot service</a> to reduce spam submissions."
)));
$form->addElement(new PFBC\Element\Email("Multiple Rules:", "Email2", array(
	"validation" => new PFBC\Validation\RegExp("/.*@gmail.com$/", "Error: The %element% field must contain a Gmail address."),
	"longDesc" => "Multiple validation rules can be attached to an element by passing the validation property an array of validation 
	class instances.  This Email element also applies the RegExp validation rule to ensure the supplied email address is from Gmail."
)));
$form->addElement(new PFBC\Element\Button);
$form->addElement(new PFBC\Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>', true), '</pre>';

?>
<a name="custom-validation"></a>
<h2>Custom Validation</h2>
<p>Often times, you'll find that you need to apply custom validation to your forms' submitted data.  For instance, if you create a login
form, you'll need to validate user entered credentials against your system.  PFBC has several methods that support this type of scenario.
Let's take a look at an example implementation.</p>

<?php
echo '<pre>', highlight_string('<?php
//----------AFTER THE FORM HAS BEEN SUBMITTED----------
if(PFBC\Form::isValid("login", false)) {
	if(isValidUser($_POST["Email"], $_POST["Password"])) {
		PFBC\Form::clearValues("login");
		header("Location: profile.php");
	}
	else {
		PFBC\Form::setError("login", "Error: Invalid Email Address / Password");
		header("Location: login.php");
	}
}
else
	header("Location: login.php");
exit();
?>', true), '</pre>';
?>

<p>The isValid method has a second optional parameter that controls whether or not the form's submitted data is cleared from the PHP session
if the form validates without errors.  In the example above, false is passed allowing us to authenticate the potential user with
the fictional isValidUser function.  If the user's credentials are valid, the session data is cleared manually with the clearValues method,
and we redirect the user to their profile page.  If invalid credentials were supplied, we use the setError method to manually set a custom
error message and redirect back to the login form so the user can resubmit.</p>

<?php
include("../footer.php");
