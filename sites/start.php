<?php
    include_once("../model/Company.class.php");
    include_once("../model/Strike.class.php");
    
    $region = "";
    if(!isset($_GET["region"]) || $_GET["region"] == "")
    	$companies = Company::findAllAndOrder();
    else {
    	$companies = Company::findByRegion($_GET["region"]);
    	$region = $_GET["region"];
    }
    $regions = Company::getRegions();

    $isScioperoGenerale = Strike::findBySomethingAmount(0, "companyId")>0;
?>

<script type="text/javascript" src="../js/content.js" async defer></script>

<?php if(!isset($_GET["nojs"])): ?>
    <noscript><meta http-equiv="refresh" content="0; url=?nojs=true"></noscript>
<?php endif; ?>

<div id="dropdown-menu">
    <form method="GET" action="./" >
        <label for="region"><?= _("region").":" ?></label>
        <select name="region" <?php if(isset($_GET["nojs"])): ?>onchange="if(this.value != 0) { this.form.submit(); }"<?php endif; ?>>
            <option value="all">..</option>
            <?php for($i=0; $i<count($regions); $i++): ?>
            <option <?= ($region == $regions[$i]) ? "selected" : "" ?> value="<?= $regions[$i] ?>"><?= $regions[$i] ?></option>
            <?php endfor; ?>
        </select>
        <?php if(isset($_GET["nojs"])): ?>
            <input type="hidden" name="nojs" value="true" />
        <?php endif; ?>
        <noscript>
            <input type="submit" value="Go!" />
        </noscript>
    </form>
</div>

<?php if($isScioperoGenerale): ?>
<div id="sciopero-generale">
    <p><a href="?site=company&id=0<?php if(isset($_GET["nojs"])): ?>&nojs=true<?php endif; ?>"><?= _("alert_sciopero_generale")?></a></p>
</div>
<?php endif; ?>

<div class="box-container">
    <?php if(isset($_GET["nojs"])): ?>
        <?php for($i=0; $i<count($companies); $i++): ?>
            <?php
                $colourClass = "green";
                if(Strike::findBySomethingAmount($companies[$i]->getId(), "companyId")>0) {
                    $colourClass = "orange";
                    if($companies[$i]->getTimeToNextStrike()<2) {
                        $colourClass = "red";
                    }
                }
            ?>
            <a href="?site=company&id=<?= $companies[$i]->getId() ?>&nojs=true">
            <div class="box <?= $colourClass ?>">
                <div class="imgBox">
                    <img class="logo" src="../media/logos/companies/<?= $companies[$i]->getNameCode() ?>.svg" alt="<?= $companies[$i]->getNameCode() ?>"/>
                </div>
                <span><?= $companies[$i]->getName() ?></span>
                <div class="separator-div"></div>
            </div>
            </a>
        <?php endfor; ?>
    <?php endif; ?>
</div>