<?php
    include_once "model/Company.class.php";
    $company = Company::find($_GET["id"]);

    include_once "model/Strike.class.php";
    $strikes = Strike::findBySomething($_GET["id"], "companyId");
?>

<p><a href="<?= $company->getWebsite() ?>"><b>Name:</b></a> <i><?= $company->getName() ?></i></p>
<p><b>Region:</b> <i><?= $company->getRegion() ?></i></p>
<p><b>Province:</b> <i><?= $company->getProvince() ?></i></p>
<p><a href="<?= $company->getGuaranteedRoutesUrl() ?>"><b>Guaranteed Routes</b></a></p>
<br />

<table border="1">
    <tr>
        <th>WorkersUnion</th><th>StartDate</th><th>EndDate</th><th>Region</th><th>Province</th><th>Description</th>
    </tr>
<?php for($i=0; $i<count($strikes); $i++): ?>
    <tr>
        <td><?= $strikes[$i]->getWorkersUnion() ?></td><td><?= $strikes[$i]->getStartDate() ?></td><td><?= $strikes[$i]->getEndDate() ?></td><td><?= $strikes[$i]->getRegion() ?></td><td><?= $strikes[$i]->getProvince() ?></td><td><?= $strikes[$i]->getDescription() ?></td>
    </tr>
<?php endfor; ?>
</table>