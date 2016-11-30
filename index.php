<!DOCTYPE html>
<?php
	date_default_timezone_set("Europe/Rome");
	session_start();
	include_once("scripts/prerun.php");
?>
<html>
	<head>
		<!--Browser and document meta-tags-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="UTF-8" />
		
		<!--Informational meta-tags-->
		<meta name="description" content="W.I.P." />
		<meta name="keywords" content="IschStreik, Streik" />
		
		<!--OpenGraph data-->
		<meta property="og:title" content="Seitenname"	/>
		<meta property="og:site_name" content="IschStreik?" />
		<meta property="og:image" content="./media/favicon/512.png" />
		<meta property="og:description" content="desc" />
		
		<!--Android meta-tags-->
		<meta name="theme-color" content="#009688" />
		<link rel="icon" sizes="128x128" href="./media/favicon/128.png" />
		<link rel="icon" sizes="256x256" href="./media/favicon/256.png" />
		<link rel="manifest" href="data/manifest.json" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		
		<!--Style-->
		<link rel="stylesheet" type="text/css" href="./style/main.css" />
		<link rel="stylesheet" type="text/css" href="./style/colors.css" />
		<link rel="icon" href="/media/favicon/128.png" type="image/png" />
		<link href='//fonts.googleapis.com/css?family=Ubuntu:400,700,400italic' rel='stylesheet' type='text/css' />

		<!--GPlus-->
		<link rel="canonical" href="https://ischstreik.duckdns.org/" />
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		
		<!--Sandwitch script-->
		<script type="text/javascript" src="js/sandwitch.js" async defer></script>
		
		<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
		<script type="text/javascript">
		    window.cookieconsent_options = {"message":"This website uses cookies and whoever thought up this law is an idiot","dismiss":"Got it!","learnMore":"More info","link":null,"theme":"dark-floating"};
		</script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>

		<title><?= $GLOBALS["site-name"] ?> | IschStreik?</title>
	</head>
	<body>
		<header>
			<div id="sandwitch"><img src="./media/sandwitch.svg" alt="MENU"></div>
			<img src="media/logos/LOGO_ISCHSTREIK.svg"/>
		</header>
		<nav>
		<ul>
			<li><a href="?site=stats" title="Lorem Ipsum">Stats</a></li>
			<li><a href="?site=about" title="Lorem Ipsum">About</a></li>
			<li>
				<?=
					$GLOBALS["views"]." Views"
				?>
				<g:plusone></g:plusone>
			</li>
			<li><?php echo date('Y'); ?> IschStreik-Team</li>
			<li>
				<div>
				<table><tr><td>
					<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">
						<img alt="Creative Commons Licence" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" />
					</a>
					</td><td>
					This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.
				</td></tr></table>
				</div>
			</li>
		</ul>
		</nav>
		<main>
			<?php
				if(isset($_GET["site"]))
					include("sites/".$_GET["site"].".php");
				else
					include("sites/start.php");
			?>
		</main>
		<div id="curtain" class="curtain-open"></div>
	</body>
</html>
