<?php
if(isset($_COOKIE["lang"]))
	$lang = $_COOKIE["lang"];
else
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch ($lang){
    case "it":
        header("location: it/".substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1));
        break;
    case "de":
        header("location: de/".substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1));
        break;       
    default:
        header("location: en/".substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1));
        break;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<!--Browser and document meta-tags-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="UTF-8" />
	</head>
	<body>
		<a href="it">IT</a></br>
		<a href="de">DE</a></br>
		<a href="en">EN</a></br>
	</body>
</html>
