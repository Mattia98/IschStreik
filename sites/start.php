<?php
    include_once("../model/Company.class.php");
    include_once("../model/Strike.class.php");
    $companies = Company::findAll();
?>
<div class="box-container">
<?php for($i=0; $i<count($companies); $i++): ?>
    <?php
        $colourClass = "red";
        if(Strike::findBySomethingAmount($companies[$i]->getId(), "companyId")==0)
            $colourClass = "green";
    ?>
    <a href="?site=company&id=<?= $companies[$i]->getId() ?>">
    <div class="box <?= $colourClass ?>">
        <div class="imgBox">
            <img class="logo" src="../media/logos/companies/<?= $companies[$i]->getNameCode() ?>.svg" alt="<?= $companies[$i]->getNameCode() ?>"/>
        </div>
        <span><?= $companies[$i]->getName() ?></span>
    </div>
    <div class="separatorDiv"></div>
    </a>
<?php endfor; ?>
</div>
<br/>

<?php
	if(isset($parse))
		var_dump($parse);
?>