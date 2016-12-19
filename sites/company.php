<?php
    include_once "../model/Company.class.php";
    $company = Company::find($_GET["id"]);

    include_once "../model/Strike.class.php";
    $strikes = Strike::findBySomething($_GET["id"], "companyId");
?>

<p><a href="<?= $company->getWebsite() ?>"><i><?= $company->getName() ?></i></a></p>
<p><b><?= _("region") ?>:</b> <i><?= $company->getRegion() ?></i></p>
<p><b><?= _("province") ?>:</b> <i><?= $company->getProvince() ?></i></p>
<p><a href="<?= $company->getGuaranteedRoutesUrl() ?>"><b><?= _("guaranteed_routes") ?></b></a></p>
<br />

<table border="1">
    <tr>
        <th><?= _("workers_union") ?></th><th><?= _("start_date") ?></th><th><?= _("end_date") ?></th><th><?= _("region") ?></th><th><?= _("province") ?></th><th><?= _("description") ?></th>
    </tr>
<?php for($i=0; $i<count($strikes); $i++): ?>
    <tr>
        <td><?= $strikes[$i]->getWorkersUnion() ?></td><td><?= $strikes[$i]->getStartDate() ?></td><td><?= $strikes[$i]->getEndDate() ?></td><td><?= $strikes[$i]->getRegion() ?></td><td><?= $strikes[$i]->getProvince() ?></td><td><?= $strikes[$i]->getDescription() ?></td>
    </tr>
<?php endfor; ?>
</table>