<?php
	//require_once 'scripts/database.php';
	require_once 'scripts/chartPrinter.php';
?>
<p>Die Website hat bist jetzt <?= Viewer::getAmount(); ?> Besucher gezählt. Benutzer werden dank Cookies wiedererkannt.<p>
<p>Die Diagramme beziehen sich auf den Besuchen der letzten 14 Tagen. Die Cookies verfallen nach 14 Tagen.</p>


<p>Diagramme der letzten 14 Tagen:</p><section>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> <!--Load Library-->
	<script type="text/javascript">google.charts.load("current", {packages:["corechart"]});</script><!--Initialize Chart API-->
   <?php
   	createChart("OS distribution", "osChart", Viewer::getStats("operating_system"));
   	createChart("Browser distribution", "browserChart", Viewer::getStats("browser"));
   	createChart("Device distribution", "deviceChart", Viewer::getStats("simple_operating_platform_string"));
   ?>
   <div id="osChart" style="width: 100%; height: 500px;"></div>
   <div id="browserChart" style="width: 100%; height: 500px;"></div>
   <div id="deviceChart" style="width: 100%; height: 500px;"></div>
</section>


<p>Liste der Besucher der letzten 30 Tagen:</p>
<?php
$viewers = Viewer::findAll();
foreach($viewers as $viewer): ?>
	<article>
	<table>
		<tr><th>Timestamp</th><td><?= $viewer->getPrettyTimestamp(); ?></td></tr>
		<tr><th>User-agent</th><td><?= $viewer->getUser_agent(); ?></td></tr>
		<?php if(!empty($viewer->getBrowser())): ?>
			<tr><th>Browser</th><td><img src="media/stats_icons/browser/<?= $viewer->getBrowser_name_code(); ?>.png" alt="<?= $viewer->getBrowser_name_code(); ?>" style="height: 1em; width: 1em;"><?= $viewer->getBrowser(); ?></td></tr>
		<?php endif; ?>
		<?php if(!empty($viewer->getOperating_system())): ?>
			<tr><th>OS</th><td><img src="media/stats_icons/os/<?= $viewer->getOperating_system_name_code(); ?>.png" alt="<?= $viewer->getOperating_system_name_code(); ?>" style="height: 1em; width: 1em;"><?= $viewer->getOperating_system(); ?></td></tr>
		<?php endif; ?>
		<?php if(!empty($viewer->getSimple_operating_platform_string())): ?>
			<tr><th>Device</th><td><?= $viewer->getSimple_operating_platform_string(); ?></td></tr>
		<?php endif; ?>
	</table>
	</article>
<?php endforeach; ?>
