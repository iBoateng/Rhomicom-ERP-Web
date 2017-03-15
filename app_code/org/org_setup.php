<?php

$menuItems = array("Organization Setup");
$menuImages = array("rho_arrow1.png");

$mdlNm = "Organization Setup";
$ModuleName = $mdlNm;
$pageHtmlID = "orgSetupPage";

$dfltPrvldgs = array("View Organization Setup",
        "View Org Details", "View Divisions/Groups", "View Sites/Locations",
        /* 4 */ "View Jobs", "View Grades", "View Positions", "View Benefits",
        /* 8 */ "View Pay Items", "View Remunerations", "View Working Hours",
        /* 11 */ "View Gathering Types", "View SQL", "View Record History",
        /* 14 */ "Add Org Details", "Edit Org Details",
        /* 16 */ "Add Divisions/Groups", "Edit Divisions/Groups", "Delete Divisions/Groups",
        /* 19 */ "Add Sites/Locations", "Edit Sites/Locations", "Delete Sites/Locations",
        /* 22 */ "Add Jobs", "Edit Jobs", "Delete Jobs",
        /* 25 */ "Add Grades", "Edit Grades", "Delete Grades",
        /* 28 */ "Add Positions", "Edit Positions", "Delete Positions");

$canview = test_prmssns($dfltPrvldgs[0], $ModuleName);

$vwtyp = "0";
$qstr = "";
$dsply = "";
$actyp = "";
$srchFor = "";
$srchIn = "Name";
$PKeyID = -1;
if (isset($formArray)) {
    if (count($formArray) > 0) {
        $vwtyp = isset($formArray['vtyp']) ? cleanInputData($formArray['vtyp']) : "0";
        $qstr = isset($formArray['q']) ? cleanInputData($formArray['q']) : '';
    } else {
        $vwtyp = isset($_POST['vtyp']) ? cleanInputData($_POST['vtyp']) : "0";
    }
} else {
    $vwtyp = isset($_POST['vtyp']) ? cleanInputData($_POST['vtyp']) : "0";
}

if (isset($_POST['PKeyID'])) {
    $PKeyID = cleanInputData($_POST['PKeyID']);
}

if (isset($_POST['searchfor'])) {
    $srchFor = cleanInputData($_POST['searchfor']);
}

if (isset($_POST['searchin'])) {
    $srchIn = cleanInputData($_POST['searchin']);
}

if (isset($_POST['q'])) {
    $qstr = cleanInputData($_POST['q']);
}

if (isset($_POST['vtyp'])) {
    $vwtyp = cleanInputData($_POST['vtyp']);
}
if (isset($_POST['actyp'])) {
    $actyp = cleanInputData($_POST['actyp']);
}
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = " " . $srchFor . " ";
    $srchFor = str_replace(" ", "%", $srchFor);
}

if ($lgn_num > 0 && $canview === true) {
    if ($pgNo == 0) {
        $cntent = "<div id='rho_form' style=\"min-height:150px;\">
                <fieldset style=\"padding:10px 20px 20px 20px;margin:0px 0px 0px 0px !important;\">
                    <!--<legend>$mdlNm</legend>-->                   
                    <div class='rho_form1' style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    background-color:#e3e3e3;border: 1px solid #999;padding:20px 30px 30px 40px;\">                    
      <h3>FUNCTIONALITIES OF THE ORGANISATIONAL SETUP MODULE</h3>
      <div class='rho_form44' style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is where Organisations are defined and basic Data about the Organisation Captured. The module has the ff areas:</span>
                    </div> 
      <p>";

        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($i == 0 && test_prmssns($dfltPrvldgs[2], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 1 && test_prmssns($dfltPrvldgs[1], $mdlNm) == FALSE) {
                continue;
            }
            if ($grpcntr == 0) {
                $cntent.= "<div style=\"float:left;\">"
                        . "<ul class=\"no_bullet\">";
            }
            $cntent.= "<li class=\"leaf\" style=\"margin:5px 2px 5px 2px;\">"
                    . "<a href=\"javascript: showPageDetails('$pageHtmlID', $No);\" class=\"x-btn x-unselectable x-btn-default-large\" "
                    . "style=\"padding:0px;height:90px;width:140px;\" "
                    . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                    . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                    . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                    . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                    . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                    . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                    . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                    . "style=\"background-image:url(cmn_images/$menuImages[$i]);\">&nbsp;</span>"
                    . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                    . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                    . strtoupper($menuItems[$i])
                    . "</span></span></span></a>"
                    . "</li>";

            if ($grpcntr == 3 || $i == (count($menuItems) - 1)) {
                $cntent.= "</ul>"
                        . "</div>";
                $grpcntr = 0;
            } else {
                $grpcntr = $grpcntr + 1;
            }
        }

        $cntent.= "
       </p>
    </div>
    </fieldset>
        </div>";
        echo $cntent;
    } else if ($pgNo == 1) {
        //require "rpts_rnnr.php";
    } else if ($pgNo == 2) {
        //require "rpts_crtr.php";
    } else {
        /*else if ($pgNo == 3) {
        echo "<p style=\"font-size:12px;\">calling functions for checking and creating requirements</p>";
        loadRptRqrmnts();
    }  echo "<p style=\"font-size:12px;\">No Page No</p>"; */
        restricted();
    }
} else {
    /* echo "<p style=\"font-size:12px;\">$mdlNm No Permission No</p>"; */
    restricted();
}

?>
