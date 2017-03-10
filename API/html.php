<?php
    include_once("../model/Company.class.php");
    include_once("../model/Strike.class.php");

    switch($_GET["action"]) {
        case "getCompaniesByRegion":
            printFormattedCompanies(Company::findByRegion($_GET["argument"]));
            break;
        case "getCompanies":
            printFormattedCompanies(Company::findAllAndOrder());
            break;
        default:
            echo "Error";
            break;
    }

    /* Actions */
    function printFormattedCompanies($companies) {
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
                <div class="separator-div"></div>
            </div>
            </a>
        <?php
        endfor;
    }
?>