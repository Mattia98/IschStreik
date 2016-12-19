<?php
	include_once("../model/Viewer.class.php");

	//Defining some variables
	$message = "No messages 4u";
	$vIDname = "ViewerID";
	
	//Defining global variables
	if(isset($_GET["site"]))
		$GLOBALS["site-name"] = ucfirst($_GET["site"]);
	else
		$GLOBALS["site-name"] = "Home";
	
	$GLOBALS["views"] = Viewer::getAmount();
	
	//Setting up translation
	putenv('LANG='.LANG);
	setlocale(LC_ALL, LANG);
	bindtextdomain("is", "../locale");
	textdomain("is");

	//Doing some thoughts...
	$firsttime = !isset($_COOKIE[$vIDname]);
	if(!isset($_SESSION["login"])) {
		$_SESSION["login"] = false;
	}
	
	//Restore session-variables from cookie
	if(isset($_COOKIE[$vIDname])) {
		$_SESSION["ViewerID"] = $_COOKIE[$vIDname];
	}
	
	//Temporarily disable stat counter
	//$firsttime = false;
	
	if($firsttime) {
		//Whatismybrowser.com Parser
		$data = array('user_key' => 'aade6271bb15f1c12bd4709fafc64820', 'user_agent' => $_SERVER['HTTP_USER_AGENT']);
		$options = array(
		        'http' => array(
		            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		            'method'  => 'POST',
		            'content' => http_build_query($data),
		        ),
		    );
		$context  = stream_context_create($options);
		$json = @file_get_contents("https://api.whatismybrowser.com/api/v1/user_agent_parse", false, $context); 
		$result = json_decode($json, true);
		//print_r($result);
		
		if($result["result"] == "success") {		
			//Mobile check
			//$_COOKIE['mobile'] = ($result['parse']['device_name'] == "Smartphone"
			//									||$result['parse']['device_name'] == "Tablet");
			$parse = $result["parse"];
			
			//Machine-check
			$human = ($_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)" 
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (Windows NT 6.1; rv:6.0) Gecko/20110814 Firefox/6.0 Google favicon"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko; Google Web Preview) Chrome/27.0.1453 Safari/537.36"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (compatible) Feedfetcher-Google;(+http://www.google.com/feedfetcher.html)"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)"		
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (compatible; Google-Site-Verification/1.0)"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (Windows NT 6.1; rv:6.0) Gecko/20110814 Firefox/6.0 Google (+https://developers.google.com/+/web/snippet/)"
			&& $_SERVER['HTTP_USER_AGENT'] != "netscan.gtisc.gatech.edu"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (Windows NT 5.1; rv:9.0.1) Gecko/20100101 Firefox/9.0.1"
			&& $_SERVER['HTTP_USER_AGENT'] != "SSL Labs (https://www.ssllabs.com/about/assessment.html)"
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (compatible; Nmap Scripting Engine; http://nmap.org/book/nse.html)"
			&& $_SERVER['HTTP_USER_AGENT'] != ""
			&& $_SERVER['HTTP_USER_AGENT'] != "Mozilla/5.0 (iPhone CPU iPhone OS 8_1_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML like Gecko) Version/8.0 Mobile/12B435 Safari/600.1.4");
			//&& $_SERVER['HTTP_USER_AGENT'] != ""
			
			//Temporarily disable check
			//$human = true;
			
			if($human) {
				$viewer = new Viewer(array("userAgent"=>$_SERVER['HTTP_USER_AGENT'], "os"=>$parse["operating_system"], "osCode"=>$parse["operating_system_name_code"], "browser"=>$parse["browser"], "browserCode"=>$parse["browser_name_code"], "device"=>$parse["simple_operating_platform_string"]));
				$viewer->upsert();
				$_SESSION["ViewerID"] = $viewer->getId();
			} else {
				//not...
			}
			setcookie($vIDname, $_SESSION["ViewerID"], time() + (86400 * 30), "/");
			
		} else { //Something happened.. Display error and print array
			$message = "<b>Parsing Error!</b><br />";
			$message .= $result["message"];
		}
	}
?>
