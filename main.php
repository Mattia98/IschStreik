<!DOCTYPE html>
<?php
	date_default_timezone_set("Europe/Rome");
	session_start();
	include_once("scripts/prerun.php");
?>
<html lang="<?= SHORT_LANG ?>">
	<head>
		<!--Browser and document meta-tags-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="UTF-8" />
		
		<!--Informational meta-tags-->
		<meta name="description" content="<?= _("site-description") ?>" />
		<meta name="keywords" content="IschStreik, Streik" />

		<!--Languages-->
		<link rel="alternate" href="https://sciopero.news/en/<?= substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1) ?>" hreflang="en" />
		<link rel="alternate" href="https://sciopero.news/de/<?= substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1) ?>" hreflang="de" />
		<link rel="alternate" href="https://sciopero.news/it/<?= substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1) ?>" hreflang="it" />
		
		<!--OpenGraph data-->
		<meta property="og:title" content="<?= $GLOBALS["site-name"] ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:image" content="https://sciopero.news/media/icons/favicon/512.png" />
		<meta property="og:site_name" content="<?= _("sitename") ?>" />
		
		<!--Mobile meta-tags-->
		<meta name="theme-color" content="#849824" />
		<link rel="icon" sizes="64x64" href="../media/icons/favicon/64.png" />
		<link rel="icon" sizes="128x128" href="../media/icons/favicon/128.png" />
		<link rel="icon" sizes="256x256" href="../media/icons/favicon/256.png" />
		<link rel="icon" sizes="512x512" href="../media/icons/favicon/512.png" />
		<link rel="manifest" href="manifest.json" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		
		<!--Style-->
		<link rel="stylesheet" type="text/css" href="../style/main.css" />
		<link rel="stylesheet" type="text/css" href="../style/colors.css" />
		<link rel="icon" href="../favicon.png" type="image/png" />
		<link rel="icon" href="../media/icons/favicon/favicon.svg" type="image/svg+xml" />
        
        <!--Fonts-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=ABeeZee" rel="stylesheet" type='text/css' />
		
		<!--JScripts-->
		<!--
		<script type="text/javascript" src="../js/init.js" async defer></script>
		<script type="text/javascript" src="../js/sandwitch.js" async defer></script>
		<script type="text/javascript" src="../js/notifications.js" async defer></script>
		-->

		<?php if(!isset($_GET["legacy"])): ?>
		<script type="text/javascript">
			function check() {
				"use strict";
				if (typeof Symbol == "undefined") return false;
				try {
					eval("class Foo {}");
					eval("var bar = (x) => x+1");
				} catch (e) { return false; }
				return true;
			}
			if (!check()) {
				window.location = "?legacy=true";
			}
		</script>
		<?php endif; ?>

		<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
		<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
		<script>
			window.addEventListener("load", function(){
			window.cookieconsent.initialise({
			"palette": {
				"popup": {
				"background": "#333"
				},
				"button": {
				"background": "#859F0E"
				}
			},
			"theme": "edgeless",
			"position": "bottom-right"
			})});
		</script>

		<title><?= $GLOBALS["site-name"] ?> | <?= _("sitename") ?></title>
	</head>
	<body>
		<header>
			<div id="sandwitch"><img src="../media/sandwitch.svg" alt="MENU"></div>
			<a href="./">
                <img src="../media/logos/<?= LANG ?>.svg" alt="LOGO <?= LANG ?>" />
            </a>
            <i id="description-selector" class="material-icons">help_outline</i>
			<i id="language-selector" class="material-icons">language</i>
		</header>
		<nav>
		<ul class="list-up">
            <li><i class="material-icons">notifications</i><?= _("notifications") ?>
                <div class="onoffswitch">
                    <input type="checkbox" name="onoffswitch" id="settingsswitcher" checked>
                    <label class="onoffswitch-label" for="settingsswitcher"></label>
                </div>
            </li>
			<a href="?site=stats"><li><i class="material-icons">timeline</i><?= _("stats") ?></li></a>
			<li id="li-feedback"><i class="material-icons">feedback</i>Feedback<i class="material-icons arrow">arrow_drop_down</i></li>
            <ul id="list-feedback" class="dropdown-closed">
                <a href="mailto:sciopero.news@gmail.com"><li><i class="material-icons">email</i>E-Mail</li></a>
                <a href="https://github.com/Mattia98/IschStreik/issues"><li><i class="material-icons">bug_report</i>GitHub</li></a>
            </ul>
            <a href="?site=about"><li><i class="material-icons">info</i><?= _("about") ?></li></a>
		</ul>
        <ul class="list-down">
            <li>
				<?=
					$GLOBALS["views"]." Views"
				?>
			</li>
			<li><?php echo date('Y'); ?> IschStreik-Team</li>    
        </ul>    
		</nav>

		<div id="curtain" class="curtain-open"></div>

        <div id="description-popup" class="popup-closed">
            <i class="material-icons">highlight_off</i>
                <table>
                    <tr>
                        <th><img src="../media/icons/green.svg"/></th>
                        <td><?= _("no_strike") ?></td>
                    </tr>
                    <tr>
                        <th><img src="../media/icons/orange.svg"/></th>
                        <td><?= _("strike_near_future") ?></td>
                    </tr>
                    <tr>
                        <th><img src="../media/icons/red.svg"/></th>
                        <td><?= _("strike_2days") ?></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <th><img src="../media/icons/warning.svg"/></th>
                        <td><?= _("beta_alert") ?></td>
                    </tr>
                </table>
        </div>

        <div id="language-popup" class="popup-closed">
            <i class="material-icons">highlight_off</i>
                <a href="../en/<?= substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1) ?>" onclick="document.cookie = 'lang=en; expires='+new Date(9999999999999).toUTCString()+'; path=/'" style="text-decoration: none;">
                    <figure>
                        <img src="../media/flags/en.svg"/>
                        <figcaption>EN</figcaption>
                    </figure>
                </a>
                <a href="../it/<?= substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1) ?>" onclick="document.cookie = 'lang=it; expires='+new Date(9999999999999).toUTCString()+'; path=/'" style="text-decoration: none;">
                    <figure>
                        <img src="../media/flags/it.svg"/>
                        <figcaption>IT</figcaption>
                    </figure>
                </a>
                <a href="../de/<?= substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1) ?>" onclick="document.cookie = 'lang=de; expires='+new Date(9999999999999).toUTCString()+'; path=/'" style="text-decoration: none;">
                    <figure>
                        <img src="../media/flags/de.svg"/>
                        <figcaption>DE</figcaption>
                    </figure>
                </a>
        </div>

		<?php if(isset($_GET["legacy"])): ?>
			<div id="legacy-popup" class="popup-closed">
				<i id="legacy-popup-close" class="material-icons">&#xE888;</i>
				<div>
					<a href="../de/"><h2>Deutsch:</h2></a>
					<p>Dieser Browser wird nicht vollständig unterstützt! Einige Funktionen könnten nicht oder nur teilweise verfügbar sein.</p>
					<a href="../it/"><h2>Italiano:</h2></a>
					<p>Questo browser non viene supportato! Certe funzioni poterebbero non essere disponibili o solo funzionare parzialmente.</p>
					<a href="../en/"><h2>English:</h2></a>
					<p>This browser is not supported! Some features may not work properly or at all.</p>
				</div>
			</div>
			<style>
				#legacy-popup {
					background-color: #ececec;
					position: fixed;
					top: 5rem;
					bottom: 5rem;
					right: 5rem;
					left: 5rem;
					z-index: 3;
				}
				#legacy-popup-close {
					background-color: #ececec;
					position: relative;
					font-size: 40px;
					border-radius: 25px;
					color: #333;
					left: calc(100% - 0.25ex);
					top: -1.5ex;
				}
				#legacy-popup div {
					margin: 1rem;
				}
			</style>
			<script type="text/javascript" src="../js/legacy.js"></script>
		<?php endif; ?>

        <a href="#">
            <div class="back-to-the-top" ></div>
        </a>

		<main>
			<?php
				if(isset($_GET["site"]))
					include("sites/".$_GET["site"].".php");
				else
					include("sites/start.php");
			?>
		</main>

		<script type="text/javascript" src="../js/sandwitch.js" async defer></script>
		<script type="text/javascript" src="../js/notifications.js" async defer></script>
	</body>
</html>
