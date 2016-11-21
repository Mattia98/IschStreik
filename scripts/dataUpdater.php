<?php
	echo "===Data updater script===\n";
	//echo date();
	echo "\n";
	
	$feedURL = 'http://scioperi.mit.gov.it/mit2/public/scioperi/rss';
	
	echo "Getting data from \"$feedURL\"\n";
	$feed = file_get_contents($feedURL);
	//echo $feed;
	
	if(!$feed) {
		echo "An error occurred during the getting of the feed!\n";
		return;
	} else {
		echo "done.\n";
	}
	
	echo "Parsing feed...\n";
	$xml = simplexml_load_string($feed, null, LIBXML_NOCDATA);
	$json = json_encode($xml);
	//echo $json;
	$array = json_decode($json,TRUE)["channel"]["item"];
	
	for($i=0; $i<count($array); $i++) {
		$descriptionList = array();
		$descriptionList = explode("<br/>", $array[$i]["description"]);
		for($j=0; $j<count($descriptionList); $j++) {
			$descriptionExp = explode(": ", $descriptionList[$j], 2);
			$description[$descriptionExp[0]] = $descriptionExp[1];
		}
		$array[$i]["description"] = $description;
	}
	echo "done.\n";
	
	include_once '../model/Strike.class.php';
	$strikes = array();
	for($i=0; $i<count($array); $i++) {
		$startDate = explode(" ", $array[$i]["title"], 4)[2];
		$strikes[] = new Strike(array(
					"workersUnion" => $array[$i]["description"]["Sindacati"],
					"startDate" => $startDate,
					"endDate" => $array[$i]["description"]["Data fine"],
					"region" => $array[$i]["description"]["Regione"],
					"province" => $array[$i]["description"]["Provincia"],
					"description" => $array[$i]["description"]["Categoria interessata"]
				));
	}
	
	print_r($strikes);
	
?>