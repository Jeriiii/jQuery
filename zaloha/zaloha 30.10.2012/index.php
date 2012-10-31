<?php 
	session_start();
	include("message.php");
	include("authorization.php");
	include("PFBC/Form.php");
	// jednoradkovy
	if(isset($_POST["form"])) {
		PFBC\Form::isValid($_POST["form"]);
		$input = $_POST["place"];
	}else{
		$input = 1;
	}

	$place = array(
		"1" => "sál 1",
		"2" => "sál 2",
		"3" => "sál 3",
	);
	
	include("header.php");
	
	include("model_db.inc.php");
	$model_db->query("SELECT * FROM places WHERE id=" . $input);
	
	$active = "index.php";
	$type = "navbar-inverse";
	include('navigation.php');
	echo $navigation;
	
	$form = new PFBC\Form("select_place");
	$form->configure(array(
		"prevent" => array("bootstrap", "jQuery", "focus"),
		"view" => new PFBC\View\Search
	));
	$form->addElement(new PFBC\Element\Hidden("form", "select_place"));
	$form->addElement(new PFBC\Element\Select("", "place", $place));
	$form->addElement(new PFBC\Element\Button("Vybrat místo"));
	$form->render();
?>
		<div class="xls">
			<?php 
				echo $input_file;
			?></div>
		<div id="reserved_system">
			<div id="left"><img src="images/leva_strana_kina.png" alt="left_img"></div>
			<div id="middle">
				<div id="head"></div>
				<div id="cinema"></div>
				<div id="foot"></div>
			</div>
			<div id="right"><img src="images/prava_strana_kina.png" alt="right_img"></div>
			<div style="clear: both"></div>
		</div>
		<div id="reserved"><ul>
			<?php 
				$id_spojeni = mysql_connect($host,$user,$password);
				$vysledek_vybrani = mysql_select_db($dbname,$id_spojeni);
				$query = "SELECT * FROM elements";
				$vysledek = mysql_query($query,$id_spojeni);
				while ($reserved= mysql_fetch_assoc($vysledek))
				{
					echo "<li>" . $reserved['element'] . "_" . $reserved['serie'] . "</li>";
				}
				mysql_close($id_spojeni);
			?>
		</ul></div>
		<div id="selected">
			<form action="save.php" method="post">
				<input type="hidden" name="id_user" value="<?php echo $_SESSION["id_user"] ?>" />
				<div class="span3 offset12"><input type='submit' value='Zarezervovat' class="bnt btn-large btn-success" /></div>
			</form>
		</div>

		<!--script type="text/JavaScript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script-->
		<script type="text/JavaScript" src="jquery.js"></script>
		<script type="text/JavaScript" src="jquery.cinemaPlugin.js"></script>	
		<script type="text/JavaScript" src="test.js"></script>
		
<?php include("foot.php");