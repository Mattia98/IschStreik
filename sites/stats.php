<?php
	include_once "../scripts/chartPrinter.php";
?>
<p>Die Website hat bist jetzt <?= Viewer::getAmount(); ?> Besucher gezählt. Benutzer werden dank Cookies wiedererkannt.<p>
<p>Die Diagramme beziehen sich auf den Besuchen der letzten 14 Tagen. Die Cookies verfallen nach 14 Tagen.</p>


<p>Diagramme der letzten 14 Tagen:</p><section>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> <!--Load Library-->
	<script type="text/javascript">google.charts.load("current", {packages:["corechart"]});</script><!--Initialize Chart API-->
   <?php
   	createChart("OS distribution", "osChart", Viewer::getStats("os"));
   	createChart("Browser distribution", "browserChart", Viewer::getStats("browser"));
   	createChart("Device distribution", "deviceChart", Viewer::getStats("device"));
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
		<tr><th>User-agent</th><td><?= $viewer->getUserAgent(); ?></td></tr>
		<?php if(!empty($viewer->getBrowser())): ?>
			<tr><th>Browser</th><td><img src="../media/stats_icons/browser/<?= $viewer->getBrowserCode(); ?>.png" alt="<?= $viewer->getBrowserCode(); ?>" style="height: 1em; width: 1em;"><?= $viewer->getBrowser(); ?></td></tr>
		<?php endif; ?>
		<?php if(!empty($viewer->getOs())): ?>
			<tr><th>OS</th><td><img src="../media/stats_icons/os/<?= $viewer->getOsCode(); ?>.png" alt="<?= $viewer->getOsCode(); ?>" style="height: 1em; width: 1em;"><?= $viewer->getOs(); ?></td></tr>
		<?php endif; ?>
		<?php if(!empty($viewer->getDevice())): ?>
			<tr><th>Device</th><td><?= $viewer->getDevice(); ?></td></tr>
		<?php endif; ?>
	</table>
	</article>
<?php endforeach; ?>
