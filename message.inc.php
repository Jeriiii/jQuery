<?php
function get_message(){
	if(isset($_SESSION["message"]))
	{
		if(isset($_SESSION["message_type"]))
		{
			switch ($_SESSION["message_type"])
			{
				case "info":
					return '<div class="alert alert-info">' . $_SESSION["message"] . '</div>';
				case "error":
					return '<div class="alert alert-error">' . $_SESSION["message"] . '</div>';
				case "success":
					return '<div class="alert alert-success">' . $_SESSION["message"] . '</div>';	
			}
			unset($_SESSION["message_type"]);
		}else{
			return '<div class="alert alert-info">' . $_SESSION["message"] . '</div>';
		}
		
	}
	return NULL;
}
$message = get_message();
/* smazani zpravy ze secny */
if(isset($_SESSION["message"])) unset($_SESSION["message"]);
?>
