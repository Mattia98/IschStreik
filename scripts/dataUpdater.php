<?php
	echo "===Data updater script===\n";
	echo date("r");
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
	
	echo "Processing data...\n";
	include_once '../model/Company.class.php';
	$companyObj = Company::findAll();

	include_once '../model/Strike.class.php';
	$strikes = array();
	for($i=0; $i<count($array); $i++) {
		$startDate = explode(" ", $array[$i]["title"], 4)[2];
		$endDate = $array[$i]["description"]["Data fine"];
		$companyId = null;
		for($j=0; $j<count($companyObj); $j++) {
			$cNames = [$companyObj[$j]->getNameCode()]; //Company Names, standard -> original name
			if(strpos($companyObj[$j]->getNameCode(), "-") !== false) { //Check if it has multiple names, --> put them in the array
				$cNames = explode("-", $companyObj[$j]->getNameCode());
			}
			for($k=0; $k<count($cNames); $k++) {
				if(strpos(strtolower($array[$i]["description"]["Categoria interessata"]), $cNames[$k]) !== false) {
					$companyId = $companyObj[$j]->getId();
					break 2;
				}
			}
		}
		/*
		echo $array[$i]["description"]["modalità"]."\n";
		echo (strpos($array[$i]["description"]["modalità"], "VARIE MODALITA'") === false)."\n";
		if($array[$i]["description"]["modalità"] == "24 ORE") {
			$endDate .= " 24:00";
		} else if(strpos($array[$i]["description"]["modalità"], " ORE: ") !== false && strpos($array[$i]["description"]["modalità"], "VARIE MODALITA'") === false && strpos($array[$i]["description"]["modalità"], "DEL") === false) {
			//$from_to = explode(" ORE: ", $array[$i]["description"]["modalità"], 2)[1]; 
			$timeData = explode(" ", $array[$i]["description"]["modalità"]);
			$from = str_replace(".", ":", $timeData[3]);
			$to = str_replace(".", ":", $timeData[5]);
			$startDate .= " ".$from;
			$endDate .= " ".$to;
		}
		Code for parsing time. Information not consistent -> parsing not consistent.
		*/
		
		$strikes[] = new Strike(array(
					"workersUnion" => $array[$i]["description"]["Sindacati"],
					"startDate" => $startDate,
					"endDate" => $endDate,
					"timespan" => $array[$i]["description"]["modalità"],
					"region" => $array[$i]["description"]["Regione"],
					"province" => $array[$i]["description"]["Provincia"],
					"description" => $array[$i]["description"]["Categoria interessata"],
					"companyId" => $companyId
				));
	}
	echo "done.\n";

	/* Insertion Phase */
	echo "Inserting data to DB...\n";
	Strike::clearTable();
	for($i=0; $i<count($strikes); $i++) {
		$strikes[$i]->upsert();
	}
	echo "done.\n";
	
	//print_r($strikes);
	
?>
