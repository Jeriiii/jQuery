<?php
function get_navigation($active, $type)
{
	$navigation = '<div class="navbar ' . $type . '"><div class="navbar-inner"><ul class="nav">';
	
	$nav_list = array(
		"sign_in.php" => "Přihlášení",
		"registration.php" => "Registrace",
		"index.php" => "Rezervace",
		"preview.php" => "Shrnutí",
		"sign_out.php" => "Odhlášení",
	);
	
	foreach($nav_list as $key => $item)
	{
		if($key == $active)
		{
			$navigation = $navigation . '<li class="active"><a href="' . $key . '">' . $item . '</a></li>';
		}else{
			$navigation = $navigation . '<li><a href="' . $key . '">' . $item . '</a></li>';
		}
	}
	$navigation = $navigation . '</ul></div></div>';
	
	return $navigation;
}
if(!isset($type)) $type = "";
$navigation = get_navigation($active, $type);
?>
