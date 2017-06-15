<?php
	echo "===Data updater script===\n";
	echo date("r");
	echo "\n";
	
	$feedURL = 'http://scioperi.mit.gov.it/mit2/public/scioperi/rss';
	
	echo "Getting data from \"$feedURL\"\n";
	$feed = file_get_contents($feedURL);
	
	if(!$feed) {
		die("An error occurred during the getting of the feed!\n");
	} else {
		echo "done.\n";
	}
	
	echo "Parsing feed...\n";
	$xml = simplexml_load_string($feed, null, LIBXML_NOCDATA);
	$json = json_encode($xml);
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
					$companyId = $companyObj[$j]->getId(); //Insert the companyId and then create a strike object and put it in the array
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
					break; //Break only once so it can create muliple strikes in the case that a strike has multiple companies
				}
			}
		}
	}
	echo "done.\n";

	/* Insertion Phase */
	echo "Inserting data to DB...\n";
	Strike::clearTable();
	for($i=0; $i<count($strikes); $i++) {
		$strikes[$i]->upsert();
	}
	echo "done.\n";
?>
