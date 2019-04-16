<?php
	include_once("../model/Strike.class.php");
	include_once("../model/Company.class.php");
	
	$region = (isset($_GET["region"]))?$_GET["region"]:"";
	$regions = Company::getRegions();

	$isScioperoGenerale = Strike::findBySomethingAmount("0", "companyId")>0;
?>

<script type="text/javascript" src="../js/content.js" async defer></script>

<div id="dropdown-menu">
	<form method="GET" action="./" >
		<label for="region"><?= _("region").":" ?></label>
		<select name="region">
			<option value="all">..</option>
			<?php for($i=0; $i<count($regions); $i++): ?>
			<option <?= ($region == $regions[$i]) ? "selected" : "" ?> value="<?= $regions[$i] ?>"><?= $regions[$i] ?></option>
			<?php endfor; ?>
		</select>
	</form>
</div>

<?php if($isScioperoGenerale): ?>
<div id="sciopero-generale">
	<p><a href="?site=company&id=0"><?= _("alert_sciopero_generale")?></a></p>
</div>
<?php endif; ?>

<div class="box-container">
	<h3>Loading...</h3>
</div>
