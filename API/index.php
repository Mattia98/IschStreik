<?php
    //header("Content-Type:application/json; charset=UTF-8");
    switch($_GET["action"]) {
        case "getCompanies":
            getCompanies();
            break;
        default:
            echo "Error";
            break;
    }

    /* Actions */
    function getCompanies() {
        include_once("../model/Company.class.php");
        $companies = Company::findAllByTimeToNextStrike(2);
        $outputCompanies = array();
        for($i=0;$i<count($companies);$i++) {
            $outputCompanies[$i]["cid"] = $companies[$i]->getId();
            $outputCompanies[$i]["name"] = $companies[$i]->getName();
            $outputCompanies[$i]["nameCode"] = $companies[$i]->getNameCode();
        }
        echo json_encode($outputCompanies);
    }
?>