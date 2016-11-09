<?php
	require_once 'scripts/DatabaseAccess.php';
	$db = new DatabaseAccess();
	echo ''. $db->getViewersCount() ."&nbsp;Visitors ";
	if($_SESSION["login"] == "true") {
		echo 'Logged&nbsp;in&nbsp;as:&nbsp;'.$_SESSION["user"]["Nickname"]."";
	}
?>