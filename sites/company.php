<?php
    include_once "../model/Company.class.php";
    $company = Company::find($_GET["id"]);

    include_once "../model/Strike.class.php";
    $strikes = Strike::findBySomething($_GET["id"], "companyId");
?>

<div class="company-logo-div">
    <a href="<?= $company->getWebsite() ?>">
        <img src="../media/logos/companies/<?= $company->getNameCode() ?>.svg" alt="<?= $company->getNameCode() ?>" />
    </a>
</div>
<!--<?php
    $guaranteed_routes='<?= _("guaranteed_routes") ?>';
    $guaranteed_routes_url='<?= $strikes[$i]->getGuaranteedRoutesUrl() ?>';
    echo'<div id="guarenteed-routes-div">
        <p id="when-where-tag">'.guaranteed_routes.':</p>
        <a>'.guaranteed_routes_url.'</a>
    </div>';
?>-->
<?php for($i=0; $i<count($strikes); $i++): ?>
<div class="strike-box">
    <div id="content-div">
        <p  id="when-where-tag"><?= _("region") ?>:</p>
        <p><?= $strikes[$i]->getRegion() ?></p>
    </div>
    <div class="first-separator-div"></div>
    <div id="content-div">
        <p  id="when-where-tag"><?= _("province") ?>:</p>
        <p><?= $strikes[$i]->getProvince() ?></p>
    </div>
    <div>
    <div class="first-separator-div"></div>
    <div id="content-div">
        <p id="when-where-tag"><?= _("date") ?>:</p>
        <p><?= $strikes[$i]->getStartDate() ?></p>
        <p><?= $strikes[$i]->getEndDate() ?></p>
    </div>
    <div class="first-separator-div"></div>
    <div id="content-div">
        <p  id="when-where-tag"><?= _("description") ?>:</p>
        <p><?= $strikes[$i]->getDescription() ?></p>
    </div>
    </div>
    <div class="second-separator-div"></div>
</div>
<?php endfor; ?>