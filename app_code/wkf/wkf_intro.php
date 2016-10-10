<?php

//var_dump($_POST);
$menuItems = array("Workflow Apps", "Workflow Hierarchies", "Workflow Notifications");
$menuImages = array("chcklst4.png", "bb_flow.gif", "openfileicon.png", "98.png");

$mdlNm = "Workflow Manager";
$ModuleName = $mdlNm;
$pageHtmlID = "wkfAdminPage";

$dfltPrvldgs = array("View Workflow Manager", "View Workflow Apps",
    /* 2 */ "View Workflow Hierarchies", "View Workflow Notifications",
    "View Record History", "View SQL");

$canview = test_prmssns($dfltPrvldgs[0], $mdlNm);

$vwtyp = "0";
$qstr = "";
$dsply = "";
$actyp = "";
$srchFor = "";
$srchIn = "Name";
$wkfAppID = -1;
$wkfAppActionID = -1;
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

if (isset($_POST['appID'])) {
    $wkfAppID = cleanInputData($_POST['appID']);
}

if (isset($_POST['appActionID'])) {
    $wkfAppActionID = cleanInputData($_POST['appActionID']);
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

if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0 && $canview === true) {
        if ($qstr == 'UPDATE') {
            if ($actyp == 1) {
                //Workflow Apps
                //var_dump($_POST);
                header("content-type:application/json");
                $rowsToUpdte = json_decode($_POST['rows'], true);
                if (is_multi($rowsToUpdte) == FALSE) {
                    $appID = cleanInputData($rowsToUpdte['AppID']);
                    $apNm = cleanInputData($rowsToUpdte['AppName']);
                    $oldAppID = getGnrlRecID2("wkf.wkf_apps", "app_name", "app_id", $apNm);
                    $srcMdl = cleanInputData($rowsToUpdte['SourceModule']);
                    $desc = cleanInputData($rowsToUpdte['Description']);
                    if ($apNm != "" && $srcMdl != "" && ($oldAppID <= 0 || $oldAppID == $appID)) {
                        if ($appID <= 0) {
                            createWkfApp($apNm, $srcMdl, $desc);
                        } else {
                            updateWkfApp($appID, $apNm, $srcMdl, $desc);
                        }
                    } else {
                        echo json_encode(array('success' => false));
                        exit();
                    }
                } else {
                    for ($i = 0; $i < count($rowsToUpdte); $i++) {
                        $rowToUpdte = $rowsToUpdte[$i];
                        $apNm = cleanInputData($rowToUpdte['AppName']);
                        $oldAppID = getGnrlRecID2("wkf.wkf_apps", "app_name", "app_id", $apNm);
                        $appID = cleanInputData($rowToUpdte['AppID']);
                        $srcMdl = cleanInputData($rowToUpdte['SourceModule']);
                        $desc = cleanInputData($rowToUpdte['Description']);
                        if ($apNm != "" && $srcMdl != "" && ($oldAppID <= 0 || $oldAppID == $appID)) {
                            if ($appID <= 0) {
                                createWkfApp($apNm, $srcMdl, $desc);
                            } else {
                                updateWkfApp($appID, $apNm, $srcMdl, $desc);
                            }
                        } else {
                            echo json_encode(array('success' => false));
                            exit();
                        }
                    }
                }
                //var_dump($rowsToUpdte);
                echo json_encode(array('success' => true));
            } else if ($actyp == 2) {
                //var_dump($_POST);
                //Workflow App Actions
                header("content-type:application/json");
                $rowsToUpdte = json_decode($_POST['rows'], true);
                $appID = cleanInputData($_POST['appID']);
                if (is_multi($rowsToUpdte) == FALSE) {
                    $actnNm = cleanInputData($rowsToUpdte['ActionName']);
                    $oldAppActionID = getGnrlRecIDExtr("wkf.wkf_apps_actions", "action_performed_nm", "app_id", "action_sql_id", $actnNm, $appID);
                    $appActionID = cleanInputData($rowsToUpdte['ActionID']);
                    $sqlActn = cleanInputData($rowsToUpdte['SQLAction']);
                    $execFileNm = cleanInputData($rowsToUpdte['ExecFileName']);
                    $webURL = cleanInputData($rowsToUpdte['WebURLParams']);
                    $dsplyType = cnvrtBoolToBitStr(cleanInputData($rowsToUpdte['WebDisplayType']));
                    $desc = cleanInputData($rowsToUpdte['Description']);
                    $adminOnly = cnvrtBoolToBitStr(cleanInputData($rowsToUpdte['AdminOnly']));
                    if ($actnNm != "" && $webURL != "" && ($oldAppActionID <= 0 || $oldAppActionID == $appActionID)) {
                        if ($appActionID <= 0) {
                            createWkfAppAction($actnNm, $sqlActn, $appID, $execFileNm, $webURL, $dsplyType, $desc, $adminOnly);
                        } else {
                            updateWkfAppAction($appActionID, $actnNm, $sqlActn, $appID, $execFileNm, $webURL, $dsplyType, $desc, $adminOnly);
                        }
                    } else {
                        echo json_encode(array('success' => false));
                        exit();
                    }
                } else {
                    for ($i = 0; $i < count($rowsToUpdte); $i++) {
                        $rowToUpdte = $rowsToUpdte[$i];
                        $actnNm = cleanInputData($rowToUpdte['ActionName']);
                        $oldAppActionID = getGnrlRecIDExtr("wkf.wkf_apps_actions", "action_performed_nm", "app_id", "action_sql_id", $actnNm, $appID);
                        $appActionID = cleanInputData($rowToUpdte['ActionID']);
                        $sqlActn = cleanInputData($rowToUpdte['SQLAction']);
                        $execFileNm = cleanInputData($rowToUpdte['ExecFileName']);
                        $webURL = cleanInputData($rowToUpdte['WebURLParams']);
                        $dsplyType = cnvrtBoolToBitStr(cleanInputData($rowToUpdte['WebDisplayType']));
                        $desc = cleanInputData($rowToUpdte['Description']);
                        $adminOnly = cnvrtBoolToBitStr(cleanInputData($rowToUpdte['AdminOnly']));
                        if ($actnNm != "" && $webURL != "" && ($oldAppActionID <= 0 || $oldAppActionID == $appActionID)) {
                            if ($appActionID <= 0) {
                                createWkfAppAction($actnNm, $sqlActn, $appID, $execFileNm, $webURL, $dsplyType, $desc, $adminOnly);
                            } else {
                                updateWkfAppAction($appActionID, $actnNm, $sqlActn, $appID, $execFileNm, $webURL, $dsplyType, $desc, $adminOnly);
                            }
                        } else {
                            echo json_encode(array('success' => false));
                            exit();
                        }
                    }
                }
                //var_dump($rowsToUpdte);
                echo json_encode(array('success' => true));
            } else if ($actyp == 3) {
                //Workflow App Hierarchies
                header("content-type:application/json");
                $rowsToUpdte = json_decode($_POST['rows'], true);
                $appID = cleanInputData($_POST['appID']);
                if (is_multi($rowsToUpdte) == FALSE) {
                    $hrchyNm = cleanInputData($rowsToUpdte['HrchyName']);
                    $hrchyID = getGnrlRecID2("wkf.wkf_hierarchy_hdr", "hierarchy_name", "hierarchy_id", $hrchyNm);
                    $appHrchyID = cleanInputData($rowsToUpdte['AppHrchyID']);
                    $hrchyEnbld = cnvrtBoolToBitStr(cleanInputData($rowsToUpdte['HrchyEnabled']));
                    $linkageEnbld = cnvrtBoolToBitStr(cleanInputData($rowsToUpdte['LinkageEnabled']));
                    $oldAppHrchyID = get_WkfAppHrchyID($appID, $hrchyID);

                    if ($hrchyID > 0 && $appID > 0 && ($oldAppHrchyID <= 0 || $oldAppHrchyID == $appHrchyID)) {
                        if ($appHrchyID <= 0) {
                            createWkfAppHrchy($appID, $hrchyID, $linkageEnbld);
                        } else {
                            updateWkfAppHrchy($appHrchyID, $appID, $hrchyID, $linkageEnbld);
                        }
                    } else {
                        echo json_encode(array('success' => false));
                        exit();
                    }
                } else {
                    for ($i = 0; $i < count($rowsToUpdte); $i++) {
                        $rowToUpdte = $rowsToUpdte[$i];
                        $hrchyID = cleanInputData($rowToUpdte['HrchyID']);
                        $appHrchyID = cleanInputData($rowToUpdte['AppHrchyID']);
                        $hrchyEnbld = cnvrtBoolToBitStr(cleanInputData($rowToUpdte['HrchyEnabled']));
                        $linkageEnbld = cnvrtBoolToBitStr(cleanInputData($rowToUpdte['LinkageEnabled']));
                        $oldAppHrchyID = get_WkfAppHrchyID($appID, $hrchyID);

                        if ($hrchyID > 0 && $appID > 0 && ($oldAppHrchyID <= 0 || $oldAppHrchyID == $appHrchyID)) {
                            if ($appHrchyID <= 0) {
                                createWkfAppHrchy($appID, $hrchyID, $linkageEnbld);
                            } else {
                                updateWkfAppHrchy($appHrchyID, $appID, $hrchyID, $linkageEnbld);
                            }
                        } else {
                            echo json_encode(array('success' => false));
                            exit();
                        }
                    }
                }
                //var_dump($rowsToUpdte);
                echo json_encode(array('success' => true));
            } else if ($actyp == 4) {
                //Workflow Hierarchies
                //var_dump($_POST);
                header("content-type:application/json");
                $rowsToUpdte = json_decode($_POST['rows'], true);
                if (is_multi($rowsToUpdte) == FALSE) {
                    $hrchyID = cleanInputData($rowsToUpdte['HrchyID']);
                    $hrchyNm = cleanInputData($rowsToUpdte['HrchyName']);
                    $oldHrchyID = getGnrlRecID2("wkf.wkf_hierarchy_hdr", "hierarchy_name", "hierarchy_id", $hrchyNm);
                    $hrchyTyp = cleanInputData($rowsToUpdte['HrchyType']);
                    $desc = cleanInputData($rowsToUpdte['HrchyDesc']);
                    $sqlStmnt = cleanInputData($rowsToUpdte['SQLStmnt']);
                    $isEnbld = cnvrtBoolToBitStr(cleanInputData($rowsToUpdte['IsEnabled']));
                    if ($hrchyNm != "" && $hrchyTyp != "" && ($oldHrchyID <= 0 || $oldHrchyID == $hrchyID)) {
                        if ($hrchyID <= 0) {
                            createWkfHrchy($hrchyNm, $desc, $hrchyTyp, $sqlStmnt, $isEnbld);
                        } else {
                            updateWkfHrchy($hrchyID, $hrchyNm, $desc, $hrchyTyp, $sqlStmnt, $isEnbld);
                        }
                    } else {
                        $errMsg = "Please fill all required Fields and Make Sure New Entries don't exist already!";
                        echo json_encode(array('success' => false,
                            'message' => $errMsg));
                        exit();
                    }
                } else {
                    for ($i = 0; $i < count($rowsToUpdte); $i++) {
                        $rowToUpdte = $rowsToUpdte[$i];
                        $hrchyID = cleanInputData($rowToUpdte['HrchyID']);
                        $hrchyNm = cleanInputData($rowToUpdte['HrchyName']);
                        $oldHrchyID = getGnrlRecID2("wkf.wkf_hierarchy_hdr", "hierarchy_name", "hierarchy_id", $hrchyNm);
                        $hrchyTyp = cleanInputData($rowToUpdte['HrchyType']);
                        $desc = cleanInputData($rowToUpdte['HrchyDesc']);
                        $sqlStmnt = cleanInputData($rowToUpdte['SQLStmnt']);
                        $isEnbld = cnvrtBoolToBitStr(cleanInputData($rowToUpdte['IsEnabled']));
                        if ($hrchyNm != "" && $hrchyTyp != "" && ($oldHrchyID <= 0 || $oldHrchyID == $hrchyID)) {
                            if ($hrchyID <= 0) {
                                createWkfHrchy($hrchyNm, $desc, $hrchyTyp, $sqlStmnt, $isEnbld);
                            } else {
                                updateWkfHrchy($hrchyID, $hrchyNm, $desc, $hrchyTyp, $sqlStmnt, $isEnbld);
                            }
                        } else {
                            $errMsg = "Please fill all required Fields and Make Sure New Entries don't exist already!";
                            echo json_encode(array('success' => false,
                                'message' => $errMsg));
                            exit();
                        }
                    }
                }
                //var_dump($rowsToUpdte);
                echo json_encode(array('success' => true));
            } else if ($actyp == 5) {
                //Workflow Manual Hierarchies
                //var_dump($_POST);
                header("content-type:application/json");
                $hrchyID = cleanInputData($_POST['hrchyID']);
                $rowsToUpdte = json_decode($_POST['rows'], true);
                if (is_multi($rowsToUpdte) == FALSE) {
                    $hrchyDetID = cleanInputData($rowsToUpdte['MnlHrchyDetID']);
                    $prsnID = getPersonID(cleanInputData($rowsToUpdte['PersonLocID']));
                    $hrchyLvl = cleanInputData($rowsToUpdte['HrchyLevel']);
                    $isEnbld = cnvrtBoolToBitStr(cleanInputData($rowsToUpdte['IsEnabled']));
                    $oldHrchyDetID = get_MnlHrchyDetID($hrchyID, $prsnID, $hrchyLvl);
                    if ($prsnID > 0 && is_int($hrchyLvl) && ($oldHrchyDetID <= 0 || $oldHrchyDetID == $hrchyDetID)) {
                        if ($hrchyDetID <= 0) {
                            createWkfMnlHrchy($hrchyID, $prsnID, $hrchyLvl, $isEnbld);
                        } else {
                            updateWkfMnlHrchy($hrchyDetID, $prsnID, $hrchyLvl, $isEnbld);
                        }
                    } else {
                        echo json_encode(array('success' => false));
                        exit();
                    }
                } else {
                    for ($i = 0; $i < count($rowsToUpdte); $i++) {
                        $rowToUpdte = $rowsToUpdte[$i];
                        $hrchyDetID = cleanInputData($rowToUpdte['MnlHrchyDetID']);
                        $prsnID = getPersonID(cleanInputData($rowToUpdte['PersonLocID']));
                        $hrchyLvl = cleanInputData($rowToUpdte['HrchyLevel']);
                        $isEnbld = cnvrtBoolToBitStr(cleanInputData($rowToUpdte['IsEnabled']));
                        $oldHrchyDetID = get_MnlHrchyDetID($hrchyID, $prsnID, $hrchyLvl);
                        if ($prsnID > 0 && is_int($hrchyLvl) && ($oldHrchyDetID <= 0 || $oldHrchyDetID == $hrchyDetID)) {
                            if ($hrchyDetID <= 0) {
                                createWkfMnlHrchy($hrchyID, $prsnID, $hrchyLvl, $isEnbld);
                            } else {
                                updateWkfMnlHrchy($hrchyDetID, $prsnID, $hrchyLvl, $isEnbld);
                            }
                        } else {
                            echo json_encode(array('success' => false));
                            exit();
                        }
                    }
                }
                //var_dump($rowsToUpdte);
                echo json_encode(array('success' => true));
            } else if ($actyp == 6) {
                //Workflow Position Hierarchies
                header("content-type:application/json");
                $hrchyID = cleanInputData($_POST['hrchyID']);
                $rowsToUpdte = json_decode($_POST['rows'], true);
                if (is_multi($rowsToUpdte) == FALSE) {
                    $hrchyDetID = cleanInputData($rowsToUpdte['PosHrchyDetID']);
                    $postnID = cleanInputData($rowsToUpdte['PositionID']);
                    $hrchyLvl = cleanInputData($rowsToUpdte['HrchyLevel']);
                    $isEnbld = cnvrtBoolToBitStr(cleanInputData($rowsToUpdte['IsEnabled']));
                    $oldHrchyDetID = get_PosHrchyDetID($hrchyID, $postnID, $hrchyLvl);
                    if ($postnID > 0 && is_int($hrchyLvl) && ($oldHrchyDetID <= 0 || $oldHrchyDetID == $hrchyDetID)) {
                        if ($hrchyDetID <= 0) {
                            createWkfPosHrchy($hrchyID, $postnID, $hrchyLvl, $isEnbld);
                        } else {
                            updateWkfPosHrchy($hrchyDetID, $postnID, $hrchyLvl, $isEnbld);
                        }
                    } else {
                        echo json_encode(array('success' => false));
                        exit();
                    }
                } else {
                    for ($i = 0; $i < count($rowsToUpdte); $i++) {
                        $rowToUpdte = $rowsToUpdte[$i];
                        $hrchyDetID = cleanInputData($rowToUpdte['PosHrchyDetID']);
                        $postnID = cleanInputData($rowToUpdte['PositionID']);
                        $hrchyLvl = cleanInputData($rowToUpdte['HrchyLevel']);
                        $isEnbld = cnvrtBoolToBitStr(cleanInputData($rowToUpdte['IsEnabled']));
                        $oldHrchyDetID = get_PosHrchyDetID($hrchyID, $postnID, $hrchyLvl);
                        if ($postnID > 0 && is_int($hrchyLvl) && ($oldHrchyDetID <= 0 || $oldHrchyDetID == $hrchyDetID)) {
                            if ($hrchyDetID <= 0) {
                                createWkfPosHrchy($hrchyID, $postnID, $hrchyLvl, $isEnbld);
                            } else {
                                updateWkfPosHrchy($hrchyDetID, $postnID, $hrchyLvl, $isEnbld);
                            }
                        } else {
                            echo json_encode(array('success' => false));
                            exit();
                        }
                    }
                }
                //var_dump($rowsToUpdte);
                echo json_encode(array('success' => true));
            }
        } else if ($qstr == 'DELETE') {
            if ($actyp == 1) {
                $PKeyID = cleanInputData($_POST['appID']);
                if ($PKeyID > 0) {
                    echo deleteWkfApp($PKeyID);
                }
            } else if ($actyp == 2) {
                $PKeyID = cleanInputData($_POST['actionID']);
                if ($PKeyID > 0) {
                    echo deleteWkfAppAction($PKeyID);
                }
            } else if ($actyp == 3) {
                $PKeyID = cleanInputData($_POST['appHrchyID']);
                if ($PKeyID > 0) {
                    echo deleteWkfAppHrchy($PKeyID);
                }
            } else if ($actyp == 4) {
                $PKeyID = cleanInputData($_POST['hrchyID']);
                if ($PKeyID > 0) {
                    echo deleteWkfHrchy($PKeyID);
                }
            } else if ($actyp == 5) {
                $PKeyID = cleanInputData($_POST['mnlHrchyDetID']);
                if ($PKeyID > 0) {
                    echo deleteWkfMnlHrchy($PKeyID);
                }
            } else if ($actyp == 6) {
                $PKeyID = cleanInputData($_POST['posHrchyDetID']);
                if ($PKeyID > 0) {
                    echo deleteWkfPosHrchy($PKeyID);
                }
            }
        } else {
            if ($pgNo == 0) {
                /*<div style=\"margin-bottom:10px;\">
                    <h3>WORKFLOW MANAGER MODULE</h3>
                        <span>&nbsp;&nbsp;&nbsp;This is where the workflow behind the application is configured. The module has the ff areas:
                        </span>
                    </div>
                    <!--<div class='rho_form1' style=\"background-color:#e3e3e3;border: 1px solid #999;
            padding:5px 30px 5px 10px;max-height:50px;\">
                    <span style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    font-weight:bold;\">WORKFLOW MANAGER MODULE</span>
                    </div>-->  <legend>   WORKFLOW MANAGER MODULE                
                    </legend>
                 * background-color:#e3e3e3;border: 1px solid #999;            
                    */
                $cntent = "<div id='rho_form' style=\"min-height:150px;width:100%;\">                
                    <fieldset style=\"padding:10px 20px 20px 20px;margin:0px 0px 0px 0px !important;\"> 
                    <div class='rho_form3' style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:20px 30px 30px 20px;\"> 
                    <h3>WELCOME TO THE WORKFLOW MANAGER</h3>
                    <div class='rho_form44' style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is where the workflow behind the application is configured. The module has the ff areas:</span>
                    </div> 
      <p>";
//<a onclick=\"showPageDetails('$pageHtmlID', $No);\">$menuItems[$i]</a>
                //style=\"background: url('cmn_images/start.png') no-repeat 3px 4px; background-size:20px 20px;\"
                $grpcntr = 0;
                for ($i = 0; $i < count($menuItems); $i++) {
                    $No = $i + 1;
                    if ($i == 0 && test_prmssns($dfltPrvldgs[1], $mdlNm) == FALSE) {
                        continue;
                    } else if ($i == 1 && test_prmssns($dfltPrvldgs[2], $mdlNm) == FALSE) {
                        continue;
                    } else if ($i == 2 && test_prmssns($dfltPrvldgs[3], $mdlNm) == FALSE) {
                        continue;
                    }
                    if ($grpcntr == 0) {
                        $cntent.= "<div style=\"float:none;\">"
                                . "<ul class=\"no_bullet\" style=\"float:none;\">";
                    }
                    //
                    $cntent.= "<li class=\"leaf\" style=\"margin:5px 2px 5px 2px;\">"
                            . "<a href=\"javascript: showPageDetails('$pageHtmlID', $No);\" class=\"x-btn x-unselectable x-btn-default-large\" "
                            . "style=\"padding:0px;height:90px;width:130px;\" "
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

                    if ($grpcntr == 3) {
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
                echo "";
            } else if ($pgNo == 1) {
                //require "wkf_apps.php";
                if ($vwtyp == 0) {
                    $total = get_WkfAppsTtl($srchFor, $srchIn);

                    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
                    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
                    $start = isset($_POST['start']) ? $_POST['start'] : 0;
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_WkfAppsTblr($srchFor, $srchIn, $curIdx, $lmtSze);
                    $wkfapps = array();
                    $cntr = 0;
                    while ($row = loc_db_fetch_array($result)) {
                        $chckd = ($cntr == 0) ? TRUE : FALSE;
                        $wkfapp = array(
                            'checked' => var_export($chckd, TRUE),
                            'AppID' => $row[0],
                            'AppName' => $row[1],
                            'SourceModule' => $row[2],
                            'Description' => $row[3]);
                        $wkfapps[] = $wkfapp;
                        $cntr++;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                } else if ($vwtyp == 1) {
                    $total = 500;

                    $pkID = isset($_POST['appID']) ? $_POST['appID'] : -1;
                    $result = get_WkfAppsActns($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'ActionID' => $row[0],
                            'ActionName' => $row[1],
                            'SQLAction' => $row[3],
                            'Description' => $row[2],
                            'ExecFileName' => $row[9],
                            'WebURLParams' => $row[10],
                            'WebDisplayType' => var_export(($row[11] == 'Dialog' ? TRUE : FALSE), TRUE),
                            'AdminOnly' => var_export(($row[12] == 'YES' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                } else if ($vwtyp == 2) {
                    $total = 500;

                    $pkID = isset($_POST['appID']) ? $_POST['appID'] : -1;
                    $result = get_WkfAppsHrchies($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'AppHrchyID' => $row[0],
                            'HrchyName' => $row[1],
                            'HrchyType' => $row[2],
                            'HrchyEnabled' => var_export(($row[3] == '1' ? TRUE : FALSE), TRUE),
                            'LinkageEnabled' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                }
            } else if ($pgNo == 2) {
                //require "wkf_hrchy.php";
                if ($vwtyp == 0) {
                    $total = get_WkfHrchyTtl($srchFor, $srchIn);

                    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
                    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
                    $start = isset($_POST['start']) ? $_POST['start'] : 0;
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_WkfHrchyTblr($srchFor, $srchIn, $curIdx, $lmtSze);
                    $wkfhrchys = array();
                    $cntr = 0;
                    while ($row = loc_db_fetch_array($result)) {
                        $chckd = ($cntr == 0) ? TRUE : FALSE;
                        $wkfhrchy = array(
                            'checked' => var_export($chckd, TRUE),
                            'HrchyID' => $row[0],
                            'HrchyName' => $row[1],
                            'HrchyDesc' => $row[2],
                            'HrchyType' => $row[3],
                            'SQLStmnt' => $row[4],
                            'IsEnabled' => var_export(($row[5] == '1' ? TRUE : FALSE), TRUE));
                        $wkfhrchys[] = $wkfhrchy;
                        $cntr++;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfhrchys));
                } else if ($vwtyp == 1) {
                    $total = 500;

                    $pkID = isset($_POST['hrchyID']) ? $_POST['hrchyID'] : -1;
                    $result = get_HrchyCntntMnl($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'MnlHrchyDetID' => $row[0],
                            'PersonName' => $row[2],
                            'PersonLocID' => $row[1],
                            'HrchyLevel' => $row[3],
                            'IsEnabled' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                } else if ($vwtyp == 2) {
                    $total = 500;

                    $pkID = isset($_POST['hrchyID']) ? $_POST['hrchyID'] : -1;
                    $result = get_HrchyCntntPos($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'PosHrchyDetID' => $row[0],
                            'PositionName' => $row[2],
                            'PositionID' => $row[1],
                            'HrchyLevel' => $row[3],
                            'IsEnabled' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                }
            } else if ($pgNo == 3) {
                //require "wkf_msgs.php";
            } else {
                /* else if ($pgNo == 4) {
                  echo "<p style=\"font-size:12px;\">calling functions for checking and creating requirements</p>";
                  loadWkfRqrmnts();
                  } */
                restricted();
            }
        }
    } else {
        restricted();
    }
}

function get_WkfAppsTblr($searchFor, $searchIn, $offset, $limit_size) {

    $wherecls = "";
//"Message Header", "Message Date", "Message Status", "Source App", "Source Module"
    if ($searchIn === "Name") {
        $wherecls = "app_name ilike '" .
                loc_db_escape_string($searchFor) . "'";
    } else if ($searchIn === "Description") {
        $wherecls = "app_desc ilike '" .
                loc_db_escape_string($searchFor) . "'";
    }

    $sqlStr = "SELECT app_id mt, app_name, source_module, app_desc application_description, 
        created_by mt, creation_date mt " .
            "FROM wkf.wkf_apps " .
            "WHERE ($wherecls) ORDER BY app_name 
 LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_WkfAppsTtl($searchFor, $searchIn) {

    $wherecls = "";
//"Message Header", "Message Date", "Message Status", "Source App", "Source Module"
    if ($searchIn === "Name") {
        $wherecls = "app_name ilike '" .
                loc_db_escape_string($searchFor) . "'";
    } else if ($searchIn === "Description") {
        $wherecls = "app_desc ilike '" .
                loc_db_escape_string($searchFor) . "'";
    }

    $sqlStr = "SELECT count(1) " .
            "FROM wkf.wkf_apps " .
            "WHERE ($wherecls)";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_WkfAppsActns($pkID) {
    $sqlStr = "SELECT action_sql_id mt, action_performed_nm name_of_action_performed,
        action_desc description,
        sql_stmnt sql_statement, created_by mt, creation_date mt, 
       last_update_by mt, last_update_date mt, app_id mt, 
       executable_file_nm executable_file_name_for_desktop_applications, 
       web_url web_url_for_web_applications, 
       CASE WHEN is_web_dsply_diag='1' THEN 'Dialog' ELSE 'Direct' END web_display,
       CASE WHEN is_admin_only='1' THEN 'YES' ELSE 'NO' END \"For Administrators Only?\"
  FROM wkf.wkf_apps_actions a
  WHERE (a.app_id = " . $pkID . ") ORDER BY a.action_performed_nm";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_WkfAppsHrchies($pkID) {
    $sqlStr = "SELECT a.app_hrchy_id, b.hierarchy_name, b.hierchy_type, b.is_enabled is_hierarchy_enabled, a.is_enabled is_linkage_enabled
        FROM  wkf.wkf_apps_n_hrchies a, wkf.wkf_hierarchy_hdr b
        WHERE (a.app_id = " . $pkID . " and a.hierarchy_id = b.hierarchy_id) ORDER BY 1";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function loadWkfRqrmnts() {
    global $dfltPrvldgs;
    global $pageHtmlID;
    $DefaultPrvldgs = $dfltPrvldgs;

    $subGrpNames = ""; //, "Accounting Transactions"
    $mainTableNames = ""; //, "accb.accb_trnsctn_details"
    $keyColumnNames = ""; //, "transctn_id" 
    $myName = "Workflow Manager";
    $myDesc = "This module helps you to configure the application's workflow system!";
    $audit_tbl_name = "wkf.wkf_audit_trail_tbl";
    $smplRoleName = "Workflow Manager Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    createWkfRqrdLOVs();
    echo "<p style=\"font-size:12px;\">Completed Checking & Requirements load for <b>$myName"
    . "!</b><br/>Click <a href=\"javascript: showPageDetails('$pageHtmlID', 0);\"> here to Go Home</a></p>";
}

function createWkfAppHrchy($appID, $hrchyID, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();

    $insSQL = "INSERT INTO wkf.wkf_apps_n_hrchies(
            app_id, hierarchy_id, is_enabled, created_by, creation_date, 
            last_update_by, last_update_date) " .
            "VALUES ($appID, $hrchyID, '" . loc_db_escape_string($isEnbld) .
            "', " . $usrID .
            ", '" . $dateStr . "', " . $usrID . ", '" . $dateStr . "')";

    execUpdtInsSQL($insSQL);
}

function updateWkfAppHrchy($apphrchyID, $appID, $hrchyID, $isEnbld) {
//    global $usrID;
//    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE wkf.wkf_apps_n_hrchies SET 
            app_id=$appID, 
            hierarchy_id=$hrchyID, 
            is_enabled='" . loc_db_escape_string($isEnbld) .
            "' WHERE app_hrchy_id = " . $apphrchyID;
    execUpdtInsSQL($insSQL);
}

function deleteWkfAppHrchy($apphrchyID) {
    $insSQL = "DELETE FROM wkf.wkf_apps_n_hrchies WHERE app_hrchy_id = " . $apphrchyID;
    $affctd1 +=execUpdtInsSQL($insSQL);
    if ($affctd1 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 App Hierarchy(ies)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createWkfHrchy($hrchyNm, $desc, $hrchyTyp, $sqlStmnt, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();

    $insSQL = "INSERT INTO wkf.wkf_hierarchy_hdr(
             hierarchy_name, description, is_enabled, created_by, 
            creation_date, last_update_by, last_update_date, hierchy_type, 
            sql_select_stmnt) " .
            "VALUES ('" . loc_db_escape_string($hrchyNm)
            . "', '" . loc_db_escape_string($desc)
            . "', '" . loc_db_escape_string($isEnbld)
            . "'," . $usrID . ", '" . $dateStr
            . "', " . $usrID . ", '" . $dateStr
            . "', '" . loc_db_escape_string($hrchyTyp)
            . "', '" . loc_db_escape_string($sqlStmnt) . "')";

    execUpdtInsSQL($insSQL);
}

function updateWkfHrchy($hrchyID, $hrchyNm, $desc, $hrchyTyp, $sqlStmnt, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE wkf.wkf_hierarchy_hdr SET 
            hierarchy_name='" . loc_db_escape_string($hrchyNm)
            . "', description='" . loc_db_escape_string($desc)
            . "', last_update_by=$usrID, last_update_date='$dateStr', 
                hierchy_type='" . loc_db_escape_string($hrchyTyp)
            . "',  sql_select_stmnt='" . loc_db_escape_string($sqlStmnt) . "', 
            is_enabled='" . loc_db_escape_string($isEnbld) .
            "' WHERE hierarchy_id = " . $hrchyID;
    execUpdtInsSQL($insSQL);
}

function deleteWkfHrchy($hrchyID) {
    $affctd1 = 0;
    $affctd2 = 0;
    $affctd3 = 0;

    $insSQL = "DELETE FROM wkf.wkf_pstn_hierarchy_details WHERE hierarchy_id = " . $hrchyID;
    $affctd1 +=execUpdtInsSQL($insSQL);
    $insSQL = "DELETE FROM wkf.wkf_manl_hierarchy_details WHERE hierarchy_id = " . $hrchyID;
    $affctd2 +=execUpdtInsSQL($insSQL);
    $insSQL = "DELETE FROM wkf.wkf_hierarchy_hdr WHERE hierarchy_id = " . $hrchyID;
    $affctd3 +=execUpdtInsSQL($insSQL);
    if ($affctd3 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 Position Hierarchies Deleted!";
        $dsply .= "<br/>$affctd2 Manual Hierarchies Deleted!";
        $dsply .= "<br/>$affctd3 Hierarchy Headers Deleted!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createWkfMnlHrchy($hrchyID, $prsnID, $hrchyLvl, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();

    $insSQL = "INSERT INTO wkf.wkf_manl_hierarchy_details(
            hierarchy_id, person_id, hrchy_level, created_by, 
            creation_date, last_update_by, last_update_date, is_enabled) " .
            "VALUES ($hrchyID, $prsnID, $hrchyLvl," . $usrID . ", '" . $dateStr
            . "', " . $usrID . ", '" . $dateStr
            . "', '" . loc_db_escape_string($isEnbld) . "')";

    execUpdtInsSQL($insSQL);
}

function updateWkfMnlHrchy($hrchyDetID, $prsnID, $hrchyLvl, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE wkf.wkf_manl_hierarchy_details SET 
            person_id=$prsnID, hrchy_level=$hrchyLvl, "
            . "last_update_by=$usrID, last_update_date='$dateStr', 
            is_enabled='" . loc_db_escape_string($isEnbld) .
            "' WHERE mnl_hrchy_det_id = " . $hrchyDetID;
    execUpdtInsSQL($insSQL);
}

function deleteWkfMnlHrchy($hrchyDetID) {
    $insSQL = "DELETE FROM wkf.wkf_manl_hierarchy_details WHERE mnl_hrchy_det_id = " . $hrchyDetID;
    $affctd1 +=execUpdtInsSQL($insSQL);
    if ($affctd1 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 Manual Hierarchy(ies)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createWkfPosHrchy($hrchyID, $postnID, $hrchyLvl, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();

    $insSQL = "INSERT INTO wkf.wkf_pstn_hierarchy_details(
            hierarchy_id, position_id, hrchy_level, created_by, 
            creation_date, last_update_by, last_update_date, is_enabled) " .
            "VALUES ($hrchyID, $postnID, $hrchyLvl," . $usrID . ", '" . $dateStr
            . "', " . $usrID . ", '" . $dateStr
            . "', '" . loc_db_escape_string($isEnbld) . "')";

    execUpdtInsSQL($insSQL);
}

function updateWkfPosHrchy($hrchyDetID, $postnID, $hrchyLvl, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE wkf.wkf_pstn_hierarchy_details SET 
            position_id=$postnID, hrchy_level=$hrchyLvl, "
            . "last_update_by=$usrID, last_update_date='$dateStr', 
            is_enabled='" . loc_db_escape_string($isEnbld) .
            "' WHERE hierarchy_det_id = " . $hrchyDetID;
    execUpdtInsSQL($insSQL);
}

function deleteWkfPosHrchy($hrchyDetID) {
    $insSQL = "DELETE FROM wkf.wkf_pstn_hierarchy_details WHERE hierarchy_det_id = " . $hrchyDetID;
    $affctd1 +=execUpdtInsSQL($insSQL);
    if ($affctd1 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 Position Hierarchy(ies)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function get_WkfAppHrchyID($pkID, $hrchyID) {
    $sqlStr = "SELECT app_hrchy_id 
  FROM wkf.wkf_apps_n_hrchies a
  WHERE (a.app_id = " . $pkID . " and hierarchy_id=" . $hrchyID .
            ")";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function get_MnlHrchyDetID($pkID, $prsnID, $hrchyLvl) {
    $sqlStr = "SELECT mnl_hrchy_det_id 
  FROM wkf.wkf_manl_hierarchy_details a
  WHERE (a.hierarchy_id = " . $pkID . " and person_id=" . $prsnID .
            " and hrchy_level = " . $hrchyLvl . ") ORDER BY a.hrchy_level";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function get_PosHrchyDetID($pkID, $postnID, $hrchyLvl) {
    $sqlStr = "SELECT hierarchy_det_id 
  FROM wkf.wkf_pstn_hierarchy_details a
  WHERE (a.hierarchy_id = " . $pkID . " and position_id=" . $postnID .
            " and hrchy_level = " . $hrchyLvl . ") ORDER BY a.hrchy_level";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function get_HrchyCntntMnl($pkID) {
    $sqlStr = "SELECT mnl_hrchy_det_id mt, 
        prs.get_prsn_loc_id(person_id) \"ID No.\", 
        prs.get_prsn_name(person_id) full_name, 
        hrchy_level,is_enabled
  FROM wkf.wkf_manl_hierarchy_details a
  WHERE (a.hierarchy_id = " . $pkID . ") ORDER BY a.hrchy_level";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_HrchyCntntPos($pkID) {
    $sqlStr = "SELECT hierarchy_det_id mt, 
        position_id , 
        org.get_pos_name(position_id) pos_name, 
        hrchy_level, is_enabled
  FROM wkf.wkf_pstn_hierarchy_details a
  WHERE (a.hierarchy_id = " . $pkID . ") ORDER BY a.hrchy_level";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_WkfHrchyDet($pkID) {
    $sqlStr = "SELECT hierarchy_id mt, hierarchy_name, description, 
        CASE WHEN is_enabled='1' THEN 'Yes' ELSE 'No' END \"is_enabled\", 
        hierchy_type, sql_select_stmnt
  FROM wkf.wkf_hierarchy_hdr 
        WHERE (hierarchy_id = $pkID)";
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_WkfHrchyTblr($searchFor, $searchIn, $offset, $limit_size) {

    $wherecls = "";
//"Message Header", "Message Date", "Message Status", "Source App", "Source Module"
    if ($searchIn === "Name") {
        $wherecls = "hierarchy_name ilike '" .
                loc_db_escape_string($searchFor) . "'";
    } else if ($searchIn === "Description") {
        $wherecls = "description ilike '" .
                loc_db_escape_string($searchFor) . "'";
    }

    $sqlStr = "SELECT hierarchy_id , hierarchy_name, description, hierchy_type, sql_select_stmnt, is_enabled " .
            "FROM wkf.wkf_hierarchy_hdr " .
            "WHERE ($wherecls) ORDER BY hierarchy_name 
 LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_WkfHrchyTtl($searchFor, $searchIn) {
    $wherecls = "";
//"Message Header", "Message Date", "Message Status", "Source App", "Source Module"
    if ($searchIn === "Name") {
        $wherecls = "hierarchy_name ilike '" .
                loc_db_escape_string($searchFor) . "'";
    } else if ($searchIn === "Description") {
        $wherecls = "description ilike '" .
                loc_db_escape_string($searchFor) . "'";
    }

    $sqlStr = "SELECT count(1) " .
            "FROM wkf.wkf_hierarchy_hdr " .
            "WHERE ($wherecls)";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

?>
