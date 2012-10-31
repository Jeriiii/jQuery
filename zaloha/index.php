<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Kapitola 6</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body id="single">
		<div class="xls"><?php 
				//echo json_encode(file_get_contents("input.xls"));
								//echo file_get_contents("input.xls");
				
			//echo str_replace("\r\n", ";", str_replace("\t", ",", file_get_contents("input.xls"))); 
			echo file_get_contents("input.xls");
			?></div>
		<div id="cinema"></div>
		<script type="text/JavaScript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/JavaScript" src="jquery.cinemaPlugin.js"></script>	
		<script type="text/JavaScript" src="test.js"></script>
	</body>
</html>