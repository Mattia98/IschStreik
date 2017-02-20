<?php
    switch($_GET["action"]) {
        case "getCompaniesByRegion":
            getCompaniesByRegion($_GET["argument"]);
            break;
        default:
            echo "Error";
            break;
    }

    /* Actions */
    function getCompaniesByRegion($region) {
        include_once("../model/Company.class.php");
        include_once("../model/Strike.class.php");
        $companies = Company::findByRegion($region);
        for($i=0; $i<count($companies); $i++): ?>
            <?php
                $colourClass = "green";
                if(Strike::findBySomethingAmount($companies[$i]->getId(), "companyId")>0) {
                    $colourClass = "orange";
                    if($companies[$i]->getTimeToNextStrike()<2) {
                        $colourClass = "red";
                    }
                }
            ?>
            <a href="?site=company&id=<?= $companies[$i]->getId() ?>">
            <div class="box <?= $colourClass ?>">
                <div class="imgBox">
                    <img class="logo" src="../media/logos/companies/<?= $companies[$i]->getNameCode() ?>.svg" alt="<?= $companies[$i]->getNameCode() ?>" />
                </div>
                <span><?= $companies[$i]->getName() ?></span>
            </div>
            <div class="separator-div"></div>
            </a>
        <?php
        endfor;
    }
?>