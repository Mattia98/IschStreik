<?php
    include_once("../model/Company.class.php");
    include_once("../model/Strike.class.php");
    
    
    $region = "";
    if(!isset($_GET["region"]))
    	$companies = Company::findAllAndOrder();
    else {
    	$companies = Company::findByRegion($_GET["region"]);
    	$region = $_GET["region"];
    }
    
    $regions = Company::getRegions();
?>

<div id="dropdown-menu">
	<form method="GET" action="./" >
		<label for="region"><?= _("region").":" ?></label>
		<select  name="region" onchange="if(this.value != 0) { this.form.submit(); }">
            <option value="all">..</option>
			<?php for($i=0; $i<count($regions); $i++): ?>
			<option <?= ($region == $regions[$i]) ? "selected" : "" ?>><?= $regions[$i] ?></option>
			<?php endfor; ?>
		</select>
	</form>
</div>

<div class="box-container">
<?php for($i=0; $i<count($companies); $i++): ?>
    <?php
        $colourClass = "green";
        if(Strike::findBySomethingAmount($companies[$i]->getId(), "companyId")>0) {
            $colourClass = "orange";
            if($companies[$i]->getTimeToNextStrike()>-2) {
                $colourClass = "red";
            }
        }
    ?>
    <a href="?site=company&id=<?= $companies[$i]->getId() ?>">
    <div class="box <?= $colourClass ?>">
        <div class="imgBox">
            <img class="logo" src="../media/logos/companies/<?= $companies[$i]->getNameCode() ?>.svg" alt="<?= $companies[$i]->getNameCode() ?>"/>
        </div>
        <span><?= $companies[$i]->getName() ?></span>
    </div>
    <div class="separator-div"></div>
    </a>
<?php endfor; ?>
</div>
