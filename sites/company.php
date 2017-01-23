<?php
    include_once "../model/Company.class.php";
    $company = Company::find($_GET["id"]);

    include_once "../model/Strike.class.php";
    $strikes = Strike::findBySomething($_GET["id"], "companyId");
?>

<div class="company-logo-div">
    <a href="<?= $company->getWebsite() ?>">
        <img src="../media/logos/companies/<?= $company->getNameCode() ?>.svg" alt="<?= $company->getName() ?>" class="logo-cp" />
    </a>
</div>
<div id="guarenteed-routes-div">
    <a href="<?= $company->getGuaranteedRoutesUrl() ?>"><?= _("guaranteed_routes") ?></a>
</div>
<div class="strike-box-desktop">
    <table>
        <tr>
            <th><?= _("region") ?></th>
            <th><?= _("province") ?></th>
            <th><?= _("date") ?></th>
            <th><?= _("timespan") ?></th>
            <th><?= _("description") ?></th>
        </tr>
        <?php for($i=0; $i<count($strikes); $i++): ?>
        <tr>
            <td><?= $strikes[$i]->getRegion() ?></td>
            <td><?= $strikes[$i]->getProvince() ?></td>
            <td><?= $strikes[$i]->getStartDate() ?> <?= $strikes[$i]->getEndDate() ?></td>
            <td><?= $strikes[$i]->getTimespan() ?></td>
            <td><?= $strikes[$i]->getDescription() ?></td>
        </tr>
        <?php endfor; ?>
    </table>
</div>
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
        <p id="when-where-tag"><?= _("timespan") ?>:</p>
        <p><?= $strikes[$i]->getTimespan() ?></p>
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