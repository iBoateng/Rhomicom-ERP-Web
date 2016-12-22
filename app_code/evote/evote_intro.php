<?php

$menuItems = array("Available Elections", "All Elections", "Questions Bank", "Person Sets");
$menuImages = array("election.png", "world_48.png", "chcklst4.png", "person.png", "approve1.png");

$mdlNm = "e-Voting";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View e-Voting",
    /* 1 */ "View All Surveys/Elections", "View Questions Bank", "View Person Sets",
    /* 4 */ "View Record History", "View SQL",
    /* 6 */ "Add Surveys/Elections", "Edit Surveys/Elections", "Delete Surveys/Elections",
    /* 9 */ "Add Questions Bank", "Edit Questions Bank", "Delete Questions Bank");

$canview = test_prmssns($dfltPrvldgs[0], $mdlNm) || test_prmssns("View Elections", "Self Service");

$vwtyp = "0";
$qstr = "";
$dsply = "";
$actyp = "";
$srchFor = "";
$srchIn = "Name";
$PKeyID = -1;
$sortBy = "ID ASC";
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
if (isset($_POST['sortBy'])) {
    $sortBy = cleanInputData($_POST['sortBy']);
}
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = " " . $srchFor . " ";
    $srchFor = str_replace(" ", "%", $srchFor);
}

$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
                                                <i class=\"fa fa-home\" aria-hidden=\"true\"></i>
						<span style=\"text-decoration:none;\">Home</span>
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>
					<li onclick=\"openATab('#allmodules', 'grp=40&typ=5');\">
						<span style=\"text-decoration:none;\">All Modules</span><span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>";

if ($lgn_num > 0 && $canview === true) {
    if ($qstr == "DELETE") {
        if ($actyp == 1) {
            $pKeyID = isset($_POST['pKeyID']) ? cleanInputData($_POST['pKeyID']) : -1;
            echo deletePersonSet($pKeyID);
        } else if ($actyp == 2) {
            $pKeyID = isset($_POST['pKeyID']) ? cleanInputData($_POST['pKeyID']) : -1;
            echo deletePersonSetDet($pKeyID);
        } else if ($actyp == 3) {
            $pKeyID = isset($_POST['pKeyID']) ? cleanInputData($_POST['pKeyID']) : -1;
            echo deleteQuestion($pKeyID);
        } else if ($actyp == 4) {
            $pKeyID = isset($_POST['pKeyID']) ? cleanInputData($_POST['pKeyID']) : -1;
            echo deleteQuestionAns($pKeyID);
        } else if ($actyp == 5) {
            $pKeyID = isset($_POST['pKeyID']) ? cleanInputData($_POST['pKeyID']) : -1;
            echo deleteSurvey($pKeyID);
        } else if ($actyp == 6) {
            $pKeyID = isset($_POST['pKeyID']) ? cleanInputData($_POST['pKeyID']) : -1;
            echo deleteSurveyQstns($pKeyID);
        } else if ($actyp == 7) {
            $pKeyID = isset($_POST['pKeyID']) ? cleanInputData($_POST['pKeyID']) : -1;
            echo deleteSurvyQstnAns($pKeyID);
        }
    } else if ($qstr == "UPDATE") {
        if ($actyp == 1) {
            //Person Sets
            //var_dump($_POST);
            //exit();
            header("content-type:application/json");
            //categoryCombo
            $orgid = $_SESSION['ORG_ID'];
            $inptPrsnSetHdrID = isset($_POST['prsnSetHdrID']) ? cleanInputData($_POST['prsnSetHdrID']) : -1;
            $prsnSetName = isset($_POST['prsnSetName']) ? cleanInputData($_POST['prsnSetName']) : "";
            $prsnSetDesc = isset($_POST['prsnSetDesc']) ? cleanInputData($_POST['prsnSetDesc']) : "";
            $pSetSqlQuery = isset($_POST['pSetSqlQuery']) ? cleanInputData($_POST['pSetSqlQuery']) : "";
            $isPsetDefault = ((isset($_POST['isPsetDefault']) ? cleanInputData($_POST['isPsetDefault']) : "off") == "on") ? "1" : "0";
            $isPsetEnabled = ((isset($_POST['isPsetEnabled']) ? cleanInputData($_POST['isPsetEnabled']) : "off") == "on") ? "1" : "0";
            $pSetUsesSQL = ((isset($_POST['pSetUsesSQL']) ? cleanInputData($_POST['pSetUsesSQL']) : "off") == "on") ? "1" : "0";

            $oldPrsnSetHdrID = getGnrlRecID2("pay.pay_prsn_sets_hdr", "prsn_set_hdr_name", "prsn_set_hdr_id", $prsnSetName);

            if ($prsnSetName != "" && ($oldPrsnSetHdrID <= 0 || $oldPrsnSetHdrID == $inptPrsnSetHdrID)) {
                if ($inptPrsnSetHdrID <= 0) {
                    createPersonSet($orgid, $prsnSetName, $prsnSetDesc, $isPsetEnabled, $pSetSqlQuery, $isPsetDefault, $pSetUsesSQL);
                } else {
                    updatePersonSet($inptPrsnSetHdrID, $prsnSetName, $prsnSetDesc, $isPsetEnabled, $pSetSqlQuery, $isPsetDefault, $pSetUsesSQL);
                }
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;width:30px;height:30px;"/>Person Set Successfully Saved!!</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Person Set!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>Either the New Person Set Name is in Use <br/>or Data Supplied is Incomplete!</div>'
                ));
                exit();
            }
        } else if ($actyp == 2) {
            //Person Set Details
            $inptPrsnSetHdrID = isset($_POST['prsnSetID']) ? cleanInputData($_POST['prsnSetID']) : -1;
            $prsnLocIDs = trim(isset($_POST['prsnLocIDs']) ? cleanInputData($_POST['prsnLocIDs']) : "", "|");
            $arry1 = explode('|', $prsnLocIDs);
            $affctd = 0;
            $cntr = 0;
            for ($i = 0; $i < count($arry1); $i++) {
                $inPrsnID = getPersonID($arry1[$i]);
                if (doesPrsStHvPrs($inptPrsnSetHdrID, $inPrsnID) == false) {
                    $affctd += createPersonSetDet($inptPrsnSetHdrID, $inPrsnID);
                }
                $cntr++;
            }
            if ($affctd > 0) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;width:30px;height:30px;"/>' . $affctd . ' out of ' . $cntr . 'Persons Successfully Saved!</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Persons!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>Either the Selected Person(s) exist Already <br/>or Data Supplied is Incomplete!</div>'
                ));
                exit();
            }
        } else if ($actyp == 3) {
            //Questions
            //var_dump($_POST);
            //exit();
            header("content-type:application/json");
            //categoryCombo
            $orgid = $_SESSION['ORG_ID'];
            $inptQuestionHdrID = isset($_POST['questionHdrID']) ? cleanInputData($_POST['questionHdrID']) : -1;
            $questionDesc = isset($_POST['questionDesc']) ? cleanInputData($_POST['questionDesc']) : "";
            $questionAnsTyp = isset($_POST['questionAnsTyp']) ? cleanInputData($_POST['questionAnsTyp']) : "";
            $qCategory = isset($_POST['qCategory']) ? cleanInputData($_POST['qCategory']) : "";
            $allwdNumSlctns = isset($_POST['allwdNumSlctns']) ? cleanInputData($_POST['allwdNumSlctns']) : "";
            $qImageLoc = isset($_POST['qImageLoc']) ? cleanInputData($_POST['qImageLoc']) : "";
            $qstnHint = isset($_POST['questionHint']) ? cleanInputData($_POST['questionHint']) : "";
            $oldQuestionHdrID = getGnrlRecID2("self.self_question_bank", "qstn_desc", "qstn_id", $questionDesc);

            if ($questionDesc != "" && ($oldQuestionHdrID <= 0 || $oldQuestionHdrID == $inptQuestionHdrID)) {
                if ($inptQuestionHdrID <= 0) {
                    createQuestion($questionDesc, $questionAnsTyp, $qImageLoc, $allwdNumSlctns, $qCategory, $qstnHint);
                } else {
                    updateQuestion($inptQuestionHdrID, $questionDesc, $questionAnsTyp, $qImageLoc, $allwdNumSlctns, $qCategory, $qstnHint);
                }
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;width:30px;height:30px;"/>Question Successfully Saved!!</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Question!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>Either the New Question Exists Already <br/>or Data Supplied is Incomplete!</div>'
                ));
                exit();
            }
        } else if ($actyp == 4) {
            //Question Possible Answers
            //var_dump($_POST);
            //exit();
            header("content-type:application/json");
            //categoryCombo
            $orgid = $_SESSION['ORG_ID'];
            $inptQuestionHdrID = isset($_POST['questionHdrID']) ? cleanInputData($_POST['questionHdrID']) : -1;
            $inptPssblAnsID = isset($_POST['pssblAnsID']) ? cleanInputData($_POST['pssblAnsID']) : -1;
            $answerDesc = isset($_POST['answerDesc']) ? cleanInputData($_POST['answerDesc']) : "";
            $answerHintText = isset($_POST['answerHintText']) ? cleanInputData($_POST['answerHintText']) : "";
            $aImageLoc = isset($_POST['aImageLoc']) ? cleanInputData($_POST['aImageLoc']) : "";
            $answerHint = isset($_POST['answerHint']) ? cleanInputData($_POST['answerHint']) : "";
            $isCorrectAns = ((isset($_POST['isCorrectAns']) ? cleanInputData($_POST['isCorrectAns']) : "off") == "on") ? "1" : "0";
            $ansOrderNo = isset($_POST['ansOrderNo']) ? cleanInputData($_POST['ansOrderNo']) : 1;
            $isAnsEnabled = ((isset($_POST['isAnsEnabled']) ? cleanInputData($_POST['isAnsEnabled']) : "off") == "on") ? "1" : "0";

            $oldPssblAnsID = getQstnAnsID($inptQuestionHdrID, $answerDesc);

            if ($answerDesc != "" && ($oldPssblAnsID <= 0 || $oldPssblAnsID == $inptPssblAnsID)) {
                if ($inptPssblAnsID <= 0) {
                    createQuestionAns($inptQuestionHdrID, $answerDesc, $ansOrderNo, $isCorrectAns, $aImageLoc, $answerHintText, $answerHint, $isAnsEnabled);
                } else {
                    updateQuestionAns($inptPssblAnsID, $answerDesc, $ansOrderNo, $isCorrectAns, $aImageLoc, $answerHintText, $answerHint, $isAnsEnabled);
                }
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;width:30px;height:30px;"/>Possible Answer Successfully Saved!!</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Possible Answer!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>Either the New Possible Answer Exists Already <br/>or Data Supplied is Incomplete!</div>'
                ));
                exit();
            }
        } else if ($actyp == 5) {
            //Surveys/Elections
            //var_dump($_POST);
            //exit();
            header("content-type:application/json");
            //categoryCombo
            $orgid = $_SESSION['ORG_ID'];
            $inptSurveyID = isset($_POST['surveyID']) ? cleanInputData($_POST['surveyID']) : -1;
            $surveyName = isset($_POST['surveyName']) ? cleanInputData($_POST['surveyName']) : "";
            $surveyDesc = isset($_POST['surveyDesc']) ? cleanInputData($_POST['surveyDesc']) : "";
            $surveyInstructions = isset($_POST['surveyInstructions']) ? cleanInputData($_POST['surveyInstructions']) : "";
            $surveyType = isset($_POST['surveyType']) ? cleanInputData($_POST['surveyType']) : "";
            $sStartDate = isset($_POST['sStartDate']) ? cleanInputData($_POST['sStartDate']) : "";
            $sEndDate = isset($_POST['sEndDate']) ? cleanInputData($_POST['sEndDate']) : "";
            $includePrsnSetID = isset($_POST['includePrsnSetID']) ? cleanInputData($_POST['includePrsnSetID']) : -1;
            $excludePrsnSetID = isset($_POST['excludePrsnSetID']) ? cleanInputData($_POST['excludePrsnSetID']) : -1;

            $oldSurveyID = getGnrlRecID2("self.self_surveys", "srvy_name", "srvy_id", $surveyName);
            if ($sStartDate != "") {
                $sStartDate = cnvrtDMYTmToYMDTm($sStartDate);
            }
            if ($sEndDate != "") {
                $sEndDate = cnvrtDMYTmToYMDTm($sEndDate);
            }
            if ($surveyName != "" && ($oldSurveyID <= 0 || $oldSurveyID == $inptSurveyID)) {
                if ($inptSurveyID <= 0) {
                    createSurvey($surveyName, $surveyDesc, $surveyInstructions, $sStartDate, $sEndDate, $includePrsnSetID, $excludePrsnSetID, $surveyType);
                } else {
                    updateSurvey($inptSurveyID, $surveyName, $surveyDesc, $surveyInstructions, $sStartDate, $sEndDate, $includePrsnSetID, $excludePrsnSetID, $surveyType);
                }
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;width:30px;height:30px;"/>Survey/Election Successfully Saved!!</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Survey!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>Either the New Survey/Election Exists Already <br/>or Data Supplied is Incomplete!</div>'
                ));
                exit();
            }
        } else if ($actyp == 6) {
            //Surveys/Elections Questions
            //var_dump($_POST);
            //exit();
            header("content-type:application/json");
            //categoryCombo
            $orgid = $_SESSION['ORG_ID'];
            $inptSurveyID = isset($_POST['surveyID']) ? cleanInputData($_POST['surveyID']) : -1;
            $inptSurveyQstnID = isset($_POST['surveyQstnID']) ? cleanInputData($_POST['surveyQstnID']) : -1;
            $sQuestionID = isset($_POST['sQuestionID']) ? cleanInputData($_POST['sQuestionID']) : -1;
            $questionDsplySQL = isset($_POST['questionDsplySQL']) ? cleanInputData($_POST['questionDsplySQL']) : "";
            $questionOrderNo = isset($_POST['questionOrderNo']) ? cleanInputData($_POST['questionOrderNo']) : "";

            $oldSurveyQstnID = getSurveyQstnID($inptSurveyID, $sQuestionID);

            if ($questionDsplySQL != "" && ($oldSurveyQstnID <= 0 || $oldSurveyQstnID == $inptSurveyQstnID)) {
                if ($inptSurveyQstnID <= 0) {
                    createSurveyQstns($inptSurveyID, $sQuestionID, $questionOrderNo, $questionDsplySQL);
                } else {
                    updateSurveyQstns($inptSurveyQstnID, $questionOrderNo, $questionDsplySQL);
                }
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;width:30px;height:30px;"/>Survey/Election Question Successfully Saved!!</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Survey Question!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>Either the New Survey/Election Question Exists Already <br/>or Data Supplied is Incomplete!</div>'
                ));
                exit();
            }
        } else if ($actyp == 7) {
            //Surveys/Elections Question Answers
            //var_dump($_POST);
            //exit();
            header("content-type:application/json");
            //categoryCombo
            $orgid = $_SESSION['ORG_ID'];
            $srvyID = isset($_POST['surveyHdrID']) ? $_POST['surveyHdrID'] : -1;
            $sQuestionID = isset($_POST['questionHdrID']) ? $_POST['questionHdrID'] : -1;

            $inptSrvyQstnAnsID = isset($_POST['srvyQstnAnsID']) ? cleanInputData($_POST['srvyQstnAnsID']) : -1;
            $sqstnPssblAnsID = isset($_POST['sqstnPssblAnsID']) ? cleanInputData($_POST['sqstnPssblAnsID']) : -1;
            $sqstnDsplyCndtnSQL = isset($_POST['sqstnDsplyCndtnSQL']) ? cleanInputData($_POST['sqstnDsplyCndtnSQL']) : "";
            $sqstnAnsOrderNo = isset($_POST['sqstnAnsOrderNo']) ? cleanInputData($_POST['sqstnAnsOrderNo']) : 1;
            $isSqstnCorrectAns = ((isset($_POST['isSqstnCorrectAns']) ? cleanInputData($_POST['isSqstnCorrectAns']) : "off") == "on") ? "1" : "0";

            $oldSrvyQstnAnsID = getSurveyQstnAnsID($srvyID, $sQuestionID, $sqstnPssblAnsID);

            if ($sqstnDsplyCndtnSQL != "" && ($oldSrvyQstnAnsID <= 0 || $oldSrvyQstnAnsID == $inptSrvyQstnAnsID)) {
                if ($inptSrvyQstnAnsID <= 0) {
                    createSurvyQstnAns($srvyID, $sQuestionID, $sqstnPssblAnsID, $sqstnAnsOrderNo, $isSqstnCorrectAns, $sqstnDsplyCndtnSQL);
                } else {
                    updateSurvyQstnAns($inptSrvyQstnAnsID, $sqstnAnsOrderNo, $isSqstnCorrectAns, $sqstnDsplyCndtnSQL);
                }
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;width:30px;height:30px;"/>Survey/Election Question Answer Successfully Saved!!</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Survey Question Answer!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>Either the New Survey/Election Question Answer Exists Already <br/>or Data Supplied is Incomplete!</div>'));
                exit();
            }
        }
    } else if ($pgNo == 0) {
        $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">e-Voting Menu</span>
					</li>
                                       </ul>
                                     </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
      <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is where Elections/Polls/Surveys in the Institution are Conducted and Managed. The module has the ff areas:</span>
                    </div>
      <p>";
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($i == 0) {
                
            } else if ($i == 1 && test_prmssns($dfltPrvldgs[1], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 2 && test_prmssns($dfltPrvldgs[2], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 3 && test_prmssns($dfltPrvldgs[3], $mdlNm) == FALSE) {
                continue;
            }
            if ($grpcntr == 0) {
                $cntent .= "<div class=\"row\">";
            }

            $cntent .= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allmodules', 'grp=$group&typ=$type&pg=$No&vtyp=0');\">
            <img src=\"cmn_images/$menuImages[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItems[$i]) . "</span>
        </button>
            </div>";

            if ($grpcntr == 3) {
                $cntent .= "</div>";
                $grpcntr = 0;
            } else {
                $grpcntr = $grpcntr + 1;
            }
        }

        $cntent .= "
      </p>
    </div>";
        echo $cntent;
    } else if ($pgNo == 1) {
        //Get My Linked Elections/Surveys        
        if ($vwtyp == 0) {
            $result = get_MyActvSrvysTblr($prsnid);
            $grpcntr = 0;
            $i = 0;
            $cntent = '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' .
                    'font-weight:normal;">Sorry, there are currently no Elections/Surveys Available.<br/>Thank you for expressing interest in it.<br/>We will alert you as soon as there are Surveys or Elections Available.<br/><br/>Warm Regards...<br/><br/>Portal Administrator</span></p>';
            if (loc_db_num_rows($result) > 0) {
                $cntent = "";
            }
            while ($row = loc_db_fetch_array($result)) {
                $No = 5;
                if ($grpcntr == 0) {
                    $cntent .= "<div style=\"float:none;\">"
                            . "<ul class=\"no_bullet\" style=\"float:none;\">";
                }
                $cntent .= "<li class=\"leaf\" style=\"margin:2px 2px 2px 2px;\">"
                        . "<a href=\"javascript: showPageDetails2('$pageHtmlID', $No,'$row[1]',$row[0],0,'');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                        . "style=\"padding:0px;height:100px;width:150px;\" "
                        . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                        . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                        . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                        . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                        . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                        . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                        . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                        . "style=\"background-image:url(cmn_images/approve1.png);\">&nbsp;</span>"
                        . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                        . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                        . ($row[1])
                        . "</span></span></span></a>"
                        . "</li>";

                if ($grpcntr == 3) {
                    $cntent .= "</ul>"
                            . "</div>";
                    $grpcntr = 0;
                } else {
                    $grpcntr = $grpcntr + 1;
                }
            }


            $buttons = "";
            $cntent .= "
    </p>
    </div>
    </fieldset>
        " . $buttons . "</div>";
            echo $cntent;
        } else if ($vwtyp == 1) {
            
        }
    } else if ($pgNo == 2) {
        //Get Surveys
        if ($vwtyp == 0) {
            $total = get_SurveysTtl($srchFor, $srchIn);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_Surveys($srchFor, $srchIn, $curIdx, $lmtSze);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                $chckd = ($cntr == 0) ? TRUE : FALSE;
                $childArray = array(
                    'checked' => var_export($chckd, TRUE),
                    'SurveyID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'SurveyName' => $row[1],
                    'SurveyDesc' => $row[2],
                    'SurveyInstructions' => $row[3],
                    'StartDate' => $row[4],
                    'EndDate' => $row[5],
                    'IncludePrsnSetID' => $row[6],
                    'IncludePrsnSetName' => $row[7],
                    'ExcludePrsnSetID' => $row[9],
                    'ExcludePrsnSetName' => $row[10],
                    'SurveyType' => $row[8]);
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        } else if ($vwtyp == 1) {
            //var_dump($_POST);
            $pkID = isset($_POST['surveysHdrID']) ? $_POST['surveysHdrID'] : -1;
            $total = get_SrvyQuestionsTtl($pkID);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_SrvyQuestions($curIdx, $lmtSze, $pkID);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $childArray = array(
                    'SurveyQstnID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'QuestionDesc' => $row[1],
                    'QuestionDsplySQL' => $row[2],
                    'QuestionID' => $row[3],
                    'SurveyID' => $pkID,
                    'QuestionOrderNo' => $row[4]);
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        } else if ($vwtyp == 2) {
            //var_dump($_POST);
            $srvyID = isset($_POST['surveyHdrID']) ? $_POST['surveyHdrID'] : -1;
            $pkID = isset($_POST['questionHdrID']) ? $_POST['questionHdrID'] : -1;
            $total = get_SrvyQstnAnsTtl($pkID, $srvyID);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_SrvyQstnAns($curIdx, $lmtSze, $pkID, $srvyID);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $childArray = array(
                    'SrvyQstnAnsID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'SurveyID' => $row[1],
                    'QuestionID' => $row[2],
                    'PssblAnsID' => $row[3],
                    'AnsOrderNo' => $row[5],
                    'IsCorrectAns' => $row[6],
                    'AnsDsplySQL' => $row[10],
                    'AnswerDesc' => $row[4],
                    'ImageLoc' => $row[7],
                    'AnswerHintText' => $row[8],
                    'AnswerHint' => $row[9],
                    'IsEnabled' => $row[11]);
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        } else if ($vwtyp == 3) {
            //Get Survey Answers Chosen
            //var_dump($_POST);
            $pkID = isset($_POST['surveysHdrID']) ? $_POST['surveysHdrID'] : -1;
            $total = get_SrvyAnsChosenTtl($srchFor, $srchIn, $pkID);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_SrvyAnsChosen($srchFor, $srchIn, $curIdx, $lmtSze, $pkID);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $childArray = array(
                    'PrsnAnsID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'PersonName' => $row[4],
                    'QuestionDesc' => $row[2],
                    'AnsDesc' => $row[6],
                    'QuestionID' => $row[1],
                    'AnsID' => $row[5],
                    'PersonID' => $row[3],
                    'SurveyID' => $pkID,
                    'IsSubmitted' => var_export(($row[7] == '1' ? TRUE : FALSE), TRUE));
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        }
    } else if ($pgNo == 3) {
        //Get Question Bank
        if ($vwtyp == 0) {
            $total = get_QuestionsTtl($srchFor, $srchIn);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_Questions($srchFor, $srchIn, $curIdx, $lmtSze);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                $chckd = ($cntr == 0) ? TRUE : FALSE;
                $childArray = array(
                    'checked' => var_export($chckd, TRUE),
                    'QuestionHdrID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'QuestionDesc' => $row[1],
                    'QuestionAnsTyp' => $row[2],
                    'ImageLoc' => $row[3],
                    'AllwdNumSlctns' => $row[4],
                    'Category' => $row[5],
                    'QuestionHint' => $row[6]);
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        } else if ($vwtyp == 1) {
            //var_dump($_POST);
            $pkID = isset($_POST['questionHdrID']) ? $_POST['questionHdrID'] : -1;
            $total = get_AnswersTtl($pkID);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_Answers($curIdx, $lmtSze, $pkID);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $childArray = array(
                    'PssblAnsID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'AnswerDesc' => $row[1],
                    'ImageLoc' => $row[3],
                    'AnswerHintText' => $row[4],
                    'AnswerHint' => $row[5],
                    'AnsOrderNo' => $row[6],
                    'IsCorrectAns' => var_export(($row[2] == '1' ? TRUE : FALSE), TRUE),
                    'IsEnabled' => var_export(($row[7] == '1' ? TRUE : FALSE), TRUE));
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        }
    } else if ($pgNo == 4) {
        //Get Person Sets
        if ($vwtyp == 0) {
            $total = get_PrsnSetsTtl($srchFor, $srchIn, $orgID);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_PrsnSets($srchFor, $srchIn, $curIdx, $lmtSze, $orgID);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                $chckd = ($cntr == 0) ? TRUE : FALSE;
                $childArray = array(
                    'checked' => var_export($chckd, TRUE),
                    'PrsnSetHdrID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'PrsnSetName' => $row[1],
                    'PrsnSetDesc' => $row[2],
                    'IsEnabled' => var_export(($row[3] == '1' ? TRUE : FALSE), TRUE),
                    'SQLQuery' => $row[4],
                    'IsDefault' => var_export(($row[5] == '1' ? TRUE : FALSE), TRUE),
                    'UsesSQL' => var_export(($row[6] == '1' ? TRUE : FALSE), TRUE));
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        } else if ($vwtyp == 1) {
            //var_dump($_POST);
            $pkID = isset($_POST['prsnSetHdrID']) ? $_POST['prsnSetHdrID'] : -1;
            $total = get_PrsnSetsDtTtl($srchFor, $srchIn, $pkID);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_PrsnSetsDt($srchFor, $srchIn, $curIdx, $lmtSze, $pkID);
            $prntArray = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $childArray = array(
                    'PrsnSetDetID' => $row[3],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'PersonID' => $row[0],
                    'LocIDNo' => $row[1],
                    'FullName' => $row[2]);
                $prntArray[] = $childArray;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        } else if ($vwtyp == 2) {
            //Prsn Set Detail
            $pkID = isset($_POST['prsnSetID']) ? $_POST['prsnSetID'] : -1;
            $result = get_PrsnSetDetail($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>PERSON SET DETAILS</caption>";
            $cntent .= "<thead><tr>";
            $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
            $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
            $cntent .= "</tr></thead>";
            $cntent .= "<tbody>";
            $i = 0;

            $labl = "";
            $labl1 = "";
            while ($row = loc_db_fetch_array($result)) {
                for ($d = 0; $d < $colsCnt; $d++) {
                    $style = "";
                    $style2 = "";
                    if (trim(loc_db_field_name($result, $d)) == "mt") {
                        $style = "style=\"display:none;\"";
                    }
                    if (strtoupper($row[$d]) == 'NO') {
                        $style2 = "style=\"color:red;font-weight:bold;\"";
                    } else if (strtoupper($row[$d]) == 'YES') {
                        $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                    }

                    $cntent .= "<tr $style>";
                    $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }
            $cntent .= "</tbody></table></div>";
            echo $cntent;
        } else if ($vwtyp == 3) {
            //Question Detail
            $pkID = isset($_POST['questionID']) ? $_POST['questionID'] : -1;
            $result = get_QuestionDetail($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>QUESTION DETAILS</caption>";
            $cntent .= "<thead><tr>";
            $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
            $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
            $cntent .= "</tr></thead>";
            $cntent .= "<tbody>";
            $i = 0;

            $labl = "";
            $labl1 = "";
            while ($row = loc_db_fetch_array($result)) {
                for ($d = 0; $d < $colsCnt; $d++) {
                    $style = "";
                    $style2 = "";
                    if (trim(loc_db_field_name($result, $d)) == "mt") {
                        $style = "style=\"display:none;\"";
                    }
                    if (strtoupper($row[$d]) == 'NO') {
                        $style2 = "style=\"color:red;font-weight:bold;\"";
                    } else if (strtoupper($row[$d]) == 'YES') {
                        $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                    }

                    $cntent .= "<tr $style>";
                    $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }
            $cntent .= "</tbody></table></div>";
            echo $cntent;
        } else if ($vwtyp == 4) {
            //Answer Detail
            $pkID = isset($_POST['pssblAnsID']) ? $_POST['pssblAnsID'] : -1;
            $result = get_AnswerDetail($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>POSSIBLE ANSWER DETAILS</caption>";
            $cntent .= "<thead><tr>";
            $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
            $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
            $cntent .= "</tr></thead>";
            $cntent .= "<tbody>";
            $i = 0;

            $labl = "";
            $labl1 = "";
            while ($row = loc_db_fetch_array($result)) {
                for ($d = 0; $d < $colsCnt; $d++) {
                    $style = "";
                    $style2 = "";
                    if (trim(loc_db_field_name($result, $d)) == "mt") {
                        $style = "style=\"display:none;\"";
                    }
                    if (strtoupper($row[$d]) == 'NO') {
                        $style2 = "style=\"color:red;font-weight:bold;\"";
                    } else if (strtoupper($row[$d]) == 'YES') {
                        $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                    }

                    $cntent .= "<tr $style>";
                    $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }
            $cntent .= "</tbody></table></div>";
            echo $cntent;
        } else if ($vwtyp == 5) {
            //Survey/Election Detail 
            $pkID = isset($_POST['surveyID']) ? $_POST['surveyID'] : -1;
            $result = get_SurveyDetail($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>ELECTION DETAILS</caption>";
            $cntent .= "<thead><tr>";
            $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
            $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
            $cntent .= "</tr></thead>";
            $cntent .= "<tbody>";
            $i = 0;

            $labl = "";
            $labl1 = "";
            while ($row = loc_db_fetch_array($result)) {
                for ($d = 0; $d < $colsCnt; $d++) {
                    $style = "";
                    $style2 = "";
                    if (trim(loc_db_field_name($result, $d)) == "mt") {
                        $style = "style=\"display:none;\"";
                    }
                    if (strtoupper($row[$d]) == 'NO') {
                        $style2 = "style=\"color:red;font-weight:bold;\"";
                    } else if (strtoupper($row[$d]) == 'YES') {
                        $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                    }

                    $cntent .= "<tr $style>";
                    $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }
            $cntent .= "</tbody></table></div>";
            echo $cntent;
        } else if ($vwtyp == 6) {
            //Survey Questions
            $pkID = isset($_POST['srvyQstnID']) ? $_POST['srvyQstnID'] : -1;
            $result = get_SurveyQstnsDetail($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>SURVEY QUESTION DETAILS</caption>";
            $cntent .= "<thead><tr>";
            $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
            $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
            $cntent .= "</tr></thead>";
            $cntent .= "<tbody>";
            $i = 0;

            $labl = "";
            $labl1 = "";
            while ($row = loc_db_fetch_array($result)) {
                for ($d = 0; $d < $colsCnt; $d++) {
                    $style = "";
                    $style2 = "";
                    if (trim(loc_db_field_name($result, $d)) == "mt") {
                        $style = "style=\"display:none;\"";
                    }
                    if (strtoupper($row[$d]) == 'NO') {
                        $style2 = "style=\"color:red;font-weight:bold;\"";
                    } else if (strtoupper($row[$d]) == 'YES') {
                        $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                    }

                    $cntent .= "<tr $style>";
                    $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }
            $cntent .= "</tbody></table></div>";
            echo $cntent;
        } else if ($vwtyp == 7) {
            $result = get_QstnCtgries();
            $total = loc_db_num_rows($result);
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $childArray = array(
                    'pssblValue' => $row[0],
                    'pssblValueDesc' => $row[1]);
                $prntArray[] = $childArray;
                //$cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
        } else if ($vwtyp == 8) {
            $srvyID = isset($_POST['surveyID']) ? $_POST['surveyID'] : -1;
            $rslt1 = get_SrvyDet($srvyID);
            $cntent = "<div style=\"padding:5px;\">Sorry this Survey/Electronic Voting has been Closed or is Yet to be Opened!";
            while ($row = loc_db_fetch_array($rslt1)) {
                //Get Query to Display Election Results Rather if Permitted else
                $rslt2 = get_SurveyResults($srvyID);
                $colsCnt = loc_db_num_fields($rslt2);
                $cntent = "<div style=\"padding:2px;width:820px;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>PROVISIONAL RESULTS OF " . ($row[1]) . " (Submitted Electronic Votes Only)</caption>";
                $cntent .= "<thead><tr>";
                $cntent .= "<th width=\"200px\" style=\"font-weight:bold;\">ELECTION ITEM OR QUESTION</th>";
                $cntent .= "<th width=\"250px\" style=\"font-weight:bold;\">POSSIBLE OPTIONS</th>";
                $cntent .= "<th width=\"50px\" style=\"font-weight:bold;\">NUMBER OF VOTES</th>";
                $cntent .= "<th width=\"50px\" style=\"font-weight:bold;\">PERCENTAGE OF VOTES</th>";
                $cntent .= "</tr></thead>";
                $cntent .= "<tbody>";
                $i = 0;
                $labl = "";
                $labl1 = "";
                while ($row1 = loc_db_fetch_array($rslt2)) {
                    $cntent .= "<tr>";
                    $labl1 = "";
                    if ($i == 0) {
                        $labl = "(" . $row1[1] . ") " . $row1[2];
                        $labl1 = $labl;
                    } else if ($labl != "(" . $row1 [1] . ") " . $row1 [2]) {
                        $labl = "(" . $row1[1] . ") " . $row1[2];
                        $labl1 = $labl;
                    } else {
                        $labl1 = "";
                    }
                    $cntent .= "<td width=\"200px\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . $labl1 . "</td>";
                    $cntent .= "<td width=\"250px\">" . $row1[6] . "</td>";
                    $cntent .= "<td width=\"50px\">$row1[8]</td>";
                    $cntent .= "<td width=\"50px\">" . $row1[9] . "%</td>";
                    $cntent .= "</tr>";
                    $i++;
                }
                $cntent .= "</tbody></table></div>";
            }
            echo $cntent;
        } else if ($vwtyp == 9) {
            //Survey Questions
            $pkID = isset($_POST['srvyQstnAnsID']) ? $_POST['srvyQstnAnsID'] : -1;
            $result = get_SrvyQstnAnsDetail($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>SURVEY QUESTION ANSWER DETAILS</caption>";
            $cntent .= "<thead><tr>";
            $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
            $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
            $cntent .= "</tr></thead>";
            $cntent .= "<tbody>";
            $i = 0;

            $labl = "";
            $labl1 = "";
            while ($row = loc_db_fetch_array($result)) {
                for ($d = 0; $d < $colsCnt; $d++) {
                    $style = "";
                    $style2 = "";
                    if (trim(loc_db_field_name($result, $d)) == "mt") {
                        $style = "style=\"display:none;\"";
                    }
                    if (strtoupper($row[$d]) == 'NO') {
                        $style2 = "style=\"color:red;font-weight:bold;\"";
                    } else if (strtoupper($row[$d]) == 'YES') {
                        $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                    }

                    $cntent .= "<tr $style>";
                    $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }
            $cntent .= "</tbody></table></div>";
            echo $cntent;
        }
    } else if ($pgNo == 5) {
//Insert/Update Provided Answer
        /*
         * if Multiple Answers Allowed, Delete all Previous annswers and insert new ones
         * else check if prsn_ansr_id exists and update else insert
         */

        $dateStr = getDB_Date_time();
        $srvyID = isset($_POST['pkeyID']) ? cleanInputData($_POST['pkeyID']) : -1;
        $questionID = isset($_POST['questionID']) ? cleanInputData($_POST['questionID']) : 0;
        $answerIDs = isset($_POST['answer']) ? cleanInputData($_POST['answer']) : 0;
        $answerTxts = isset($_POST['answerTxt']) ? cleanInputData($_POST['answerTxt']) : 0;
        $srvyNm = get_SrvyNm($srvyID);
        $shdSbmt = isset($_POST['shdSubmit']) ? cleanInputData($_POST['shdSubmit']) : 0;

        if ($questionID > 0) {
            $qstnAnsTyp = get_QstnAnsTyp($questionID);
            $qstnCtgry = get_QstnCtgry($questionID);
            $qstnCtgryTtl = get_QstnCtgryTtl($qstnCtgry, $srvyID);

            if ($qstnCtgryTtl >= 2 || $qstnAnsTyp = "Multiple-Select Answers (Checkbox)") {
                $delSQL = "DELETE FROM self.self_person_question_answers "
                        . "WHERE prsn_id=" . $prsnid . " and (qstn_id=" . $questionID .
                        " or qstn_id IN (SELECT qstn_id from self.self_question_bank where category_clsfctn = '" . loc_db_escape_string($qstnCtgry) . "')) and srvy_id=" . $srvyID;
                execUpdtInsSQL($delSQL);
                $arryAnsIDs = explode("|", trim($answerIDs, "|"));
                $arryAnsTxts = explode("|", trim($answerTxts, "|"));
                for ($i = 0; $i < count($arryAnsIDs); $i++) {
                    if ($arryAnsTxts[$i] != "") {
                        $insSQL = "INSERT INTO self.self_person_question_answers(
            qstn_id, prsn_id, psbl_ansr_id, ansr_desc, created_by, 
            creation_date, last_update_by, last_update_date, srvy_id)
    VALUES ($questionID, $prsnid, $arryAnsIDs[$i], '$arryAnsTxts[$i]', $usrID, '$dateStr', 
            $usrID, '$dateStr', $srvyID)";
                        execUpdtInsSQL($insSQL);
                    }
                }
            } else {
                $arryAnsIDs = explode("|", trim($answerIDs, "|"));
                $arryAnsTxts = explode("|", trim($answerTxts, "|"));
                for ($i = 0; $i < count($arryAnsIDs); $i++) {
                    $prsnAnsID = getPrsnsAnswerIDSlctd($questionID, $prsnid, $srvyID);
                    if ($prsnAnsID > 0) {
                        $updtSQL = "UPDATE self.self_person_question_answers
   SET qstn_id=$questionID, prsn_id=$prsnid, psbl_ansr_id=$arryAnsIDs[$i], ansr_desc='$arryAnsTxts[$i]', 
       last_update_by=$usrID, last_update_date='$dateStr' WHERE prsn_ansr_id=$prsnAnsID";
                        execUpdtInsSQL($updtSQL);
                    } else if ($arryAnsTxts[$i] != "") {
                        $insSQL = "INSERT INTO self.self_person_question_answers(
            qstn_id, prsn_id, psbl_ansr_id, ansr_desc, created_by, 
            creation_date, last_update_by, last_update_date, srvy_id)
    VALUES ($questionID, $prsnid, $arryAnsIDs[$i], '$arryAnsTxts[$i]', $usrID, '$dateStr', 
            $usrID, '$dateStr', $srvyID)";
                        execUpdtInsSQL($insSQL);
                    }
                }
            }
        } else if ($shdSbmt == 1) {
            $updtSQL = "UPDATE self.self_person_question_answers
   SET is_submitted='1', 
       last_update_by=$usrID, last_update_date='$dateStr' WHERE prsn_id=$prsnid and srvy_id = $srvyID";
            $afctd = execUpdtInsSQL($updtSQL);
            echo "<p>Successfully Finalised $afctd Selected Answers!</p>";
        }

        if (hasSrvyBeenClosed($srvyID) > 0) {
            $rslt1 = get_SrvyDet($srvyID);
            $cntent = "<div style=\"padding:5px;\">Sorry this Survey/Electronic Voting has been Closed or is Yet to be Opened!";
            while ($row = loc_db_fetch_array($rslt1)) {
                //Get Query to Display Election Results Rather if Permitted else
                $rslt2 = get_SurveyResults($srvyID);
                $colsCnt = loc_db_num_fields($rslt2);
                $cntent = "<div style=\"padding:2px;width:820px;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>PROVISIONAL RESULTS OF " . ($row[1]) . " (Submitted Electronic Votes Only)</caption>";
                $cntent .= "<thead><tr>";
                $cntent .= "<th width=\"200px\" style=\"font-weight:bold;\">ELECTION ITEM OR QUESTION</th>";
                $cntent .= "<th width=\"250px\" style=\"font-weight:bold;\">POSSIBLE OPTIONS</th>";
                $cntent .= "<th width=\"50px\" style=\"font-weight:bold;\">NUMBER OF VOTES</th>";
                $cntent .= "<th width=\"50px\" style=\"font-weight:bold;\">PERCENTAGE OF VOTES</th>";
                $cntent .= "</tr></thead>";
                $cntent .= "<tbody>";
                $i = 0;
                $labl = "";
                $labl1 = "";
                while ($row1 = loc_db_fetch_array($rslt2)) {
                    $cntent .= "<tr>";
                    $labl1 = "";
                    if ($i == 0) {
                        $labl = "(" . $row1[1] . ") " . $row1[2];
                        $labl1 = $labl;
                    } else if ($labl != "(" . $row1 [1] . ") " . $row1 [2]) {
                        $labl = "(" . $row1[1] . ") " . $row1[2];
                        $labl1 = $labl;
                    } else {
                        $labl1 = "";
                    }
                    $cntent .= "<td width=\"200px\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . $labl1 . "</td>";
                    $cntent .= "<td width=\"250px\">" . $row1[6] . "</td>";
                    $cntent .= "<td width=\"50px\">$row1[8]</td>";
                    $cntent .= "<td width=\"50px\">" . $row1[9] . "%</td>";
                    $cntent .= "</tr>";
                    $i++;
                }
                $No = 5;
                $buttons = "<br/><div style=\"float:right;min-width:50%;\">"
                        . "<ul class=\"no_bullet\" style=\"float:right;\">";
                $buttons .= "<li class=\"leaf\" style=\"margin:2px 2px 2px 2px;\">"
                        . "<a href=\"javascript: showPageDetails2('$pageHtmlID',1,'$srvyNm',$srvyID,0,'GO BACK');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                        . "style=\"padding:0px;height:80px;width:140px;\" "
                        . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                        . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                        . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                        . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                        . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                        . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                        . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                        . "style=\"background-image:url(cmn_images/approve1.png);\">&nbsp;</span>"
                        . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                        . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                        . "GO BACK"
                        . "</span></span></span></a>"
                        . "</li>";
                $buttons .= "</ul>"
                        . "</div>";
                $cntent .= "</tbody></table>" . $buttons . "</div>";
            }
        } else if (getPrsnsUnSbmttdAnswerTtl($prsnid, $srvyID) <= 0 && getPrsnsAnswersTtl($prsnid, $srvyID) > 0) {
            $cntent = "<div class=\"rho_form1\" style=\"padding:10px;max-width:816px;margin-bottom:10px;\">You have submitted this Survey/Electronic Voting!<br/>Please wait for the Election to be Over to View the Results!<br/>Thank you!<br/><br/>Should you have any genuine concerns please do not hesitate to contact the Electoral Commissioner for further Clarifications!</div>";
            $rslt1 = get_SrvyDet($srvyID);
            //$cntent .= "<div style=\"padding:5px;\">Sorry this Survey/Electronic Voting has been Closed or is Yet to be Opened!";
            while ($row = loc_db_fetch_array($rslt1)) {
                //Get Query to Display Election Results Rather if Permitted else
                $rslt2 = get_SurveyRslts($srvyID, $prsnid);
                $colsCnt = loc_db_num_fields($rslt2);
                $cntent .= "<div class=\"rho_form1\" style=\"padding:2px;width:820px;margin-top:10px;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>SUMMARY OF YOUR VOTES/OPTIONS CHOSEN (" . ($row[1]) . ")</caption>";
                $cntent .= "<thead><tr>";
                $cntent .= "<th width=\"200px\" style=\"font-weight:bold;\">ELECTION ITEM OR QUESTION</th>";
                $cntent .= "<th width=\"250px\" style=\"font-weight:bold;\">POSSIBLE OPTIONS</th>";
                $cntent .= "<th width=\"50px\" style=\"font-weight:bold;\">NUMBER OF VOTES</th>";
                //$cntent.= "<th width=\"50px\" style=\"font-weight:bold;\">PERCENTAGE OF VOTES</th>";
                $cntent .= "</tr></thead>";
                $cntent .= "<tbody>";
                $i = 0;
                $labl = "";
                $labl1 = "";
                while ($row1 = loc_db_fetch_array($rslt2)) {
                    $cntent .= "<tr>";
                    $labl1 = "";
                    if ($i == 0) {
                        $labl = "(" . $row1[1] . ") " . $row1[2];
                        $labl1 = $labl;
                    } else if ($labl != "(" . $row1 [1] . ") " . $row1 [2]) {
                        $labl = "(" . $row1[1] . ") " . $row1[2];
                        $labl1 = $labl;
                    } else {
                        $labl1 = "";
                    }
                    $cntent .= "<td width=\"200px\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . $labl1 . "</td>";
                    $cntent .= "<td width=\"250px\">" . $row1[6] . "</td>";
                    $cntent .= "<td width=\"50px\">$row1[8]</td>";
                    //$cntent.= "<td width=\"50px\">" . $row1[9] . "%</td>";
                    $cntent .= "</tr>";
                    $i++;
                }
                $No = 5;
                $buttons = "<br/><div style=\"float:right;min-width:50%;\">"
                        . "<ul class=\"no_bullet\" style=\"float:right;\">";
                $buttons .= "<li class=\"leaf\" style=\"margin:2px 2px 2px 2px;\">"
                        . "<a href=\"javascript: showPageDetails2('$pageHtmlID',1,'$srvyNm',$srvyID,0,'GO BACK');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                        . "style=\"padding:0px;height:80px;width:140px;\" "
                        . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                        . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                        . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                        . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                        . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                        . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                        . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                        . "style=\"background-image:url(cmn_images/approve1.png);\">&nbsp;</span>"
                        . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                        . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                        . "GO BACK"
                        . "</span></span></span></a>"
                        . "</li>";
                $buttons .= "</ul>"
                        . "</div>";
                $cntent .= "</tbody></table>" . $buttons . "</div>";
            }
        } else {
            $nxQstnIdx = isset($_POST['nxQstnIdx']) ? cleanInputData($_POST['nxQstnIdx']) : 0;
            $ttlQstns = get_SrvyQstnsTtl($srvyID);
            $cntent = "";
            if ($nxQstnIdx == 0) {
                $cntent = "<div class=\"rho_form1\" style=\"padding:5px;\">Sorry this Survey/Electronic Voting has been Closed or is Yet to be Opened!";
                $rslt = get_ActvSrvyDet($srvyID);
                if (loc_db_num_rows($rslt) <= 0) {
                    
                } else {
                    while ($row = loc_db_fetch_array($rslt)) {
                        $cntent = "<div class=\"rho_form1\" style=\"max-width:600px;padding:20px;\">"
                                . "<p style=\"margin-bottom:10px;\"><span style=\"font-weight:bold;font-size:24px;color:blue;text-shadow: 0px 1px #ccccff;\">" . $row[1] . "</span></p>";
                        $cntent .= "<p style=\"margin-bottom:10px;\"><span style=\"font-weight:bold;font-style:italic;font-family:Times;font-size:16px;color:green;text-shadow: 0px 1px #ccffcc;padding-bottom:10px;\">" . $row[2] . "</span></p>";
                        $cntent .= "<p style=\"font-weight:bold;font-style:italic;font-family:Times;font-size:14px;color:#000000;margin:10px;\">" . $row[3] . "</p></div>";
                    }
                    $No = 5;
                    $buttons = "<br/><div style=\"float:left;min-width:50%;\">"
                            . "<ul class=\"no_bullet\" style=\"float:none;\">";
                    $buttons .= "<li class=\"leaf\" style=\"margin:2px 150px 2px 2px;\">"
                            . "<a href=\"javascript: showPageDetails2('$pageHtmlID',1,'$srvyNm',$srvyID,0,'BACK');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                            . "style=\"padding:0px;height:80px;width:140px;\" "
                            . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                            . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                            . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                            . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                            . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                            . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                            . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                            . "style=\"background-image:url(cmn_images/Backward.png);\">&nbsp;</span>"
                            . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                            . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                            . "BACK"
                            . "</span></span></span></a>"
                            . "</li>";
                    $buttons .= "<li class=\"leaf\" style=\"margin:2px 2px 2px 150px;\">"
                            . "<a href=\"javascript: showPageDetails2('$pageHtmlID',$No,'$srvyNm',$srvyID," . ($nxQstnIdx + 1) . ",'NEXT');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                            . "style=\"padding:0px;height:80px;width:140px;\" "
                            . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                            . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                            . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                            . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                            . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                            . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                            . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                            . "style=\"background-image:url(cmn_images/Forward.png);\">&nbsp;</span>"
                            . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                            . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                            . "NEXT"
                            . "</span></span></span></a>"
                            . "</li>";
                    $buttons .= "</ul>"
                            . "</div>";
                    $cntent .= "</div>" . $buttons;
                    $_SESSION ['PRV_OFFST'] = 0;
                }
            } else if ($nxQstnIdx > 0 && $nxQstnIdx <= $ttlQstns) {
                $offst = $nxQstnIdx - 1;
                $rslt = get_SrvyNxtQstn($srvyID, $offst);
                $cntent .= "<div class=\"rho_form1\" style=\"max-width:816px;padding:20px;\">"
                        . "<p style=\"margin-bottom:10px;\"><span style=\"font-weight:bold;font-size:24px;color:blue;text-shadow: 0px 1px #ccccff;\">" . $srvyNm . "</span></p>";
                if (loc_db_num_rows($rslt) <= 0) {
                    $cntent .= "<form><p>Congratulations! You have successfully completed all Sections of this Survey/Election!<br/>"
                            . "Please click on FINISH to end your Voting Session<br/>"
                            . "NB: Once you click on FINISH you cannot review your Options Selected!<br/>"
                            . "<span style=\"color:red;font-weight:bold;font-style:italic;\">Also only FULLY SUBMITTED and FINALISED ballots will be counted!</span></p><input type=\"hidden\" name=\"shdSubmit\" value=\"1\"></form></div>";
                    $No = 5;
                    $buttons = "<br/><div style=\"float:left;min-width:50%;margin-top:5px;margin-bottom:10px;\">"
                            . "<ul class=\"no_bullet\" style=\"float:none;\">";
                    $buttons .= "<li class=\"leaf\" style=\"margin:2px 500px 2px 2px;\">"
                            . "<a href=\"javascript: showPageDetails2('$pageHtmlID',$No,'$srvyNm',$srvyID," . ($_SESSION['PRV_OFFST'] + 1) . ",'PREVIOUS');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                            . "style=\"padding:0px;height:80px;width:140px;\" "
                            . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                            . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                            . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                            . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                            . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                            . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                            . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                            . "style=\"background-image:url(cmn_images/Backward.png);\">&nbsp;</span>"
                            . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                            . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                            . "PREVIOUS"
                            . "</span></span></span></a>"
                            . "</li>";
                    $buttons .= "<li class=\"leaf\" style=\"margin:2px 10px 2px 2px;\">"
                            . "<a href=\"javascript: showPageDetails2('$pageHtmlID',5,'$srvyNm',$srvyID,0,'FINISH');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                            . "style=\"padding:0px;height:80px;width:140px;\" "
                            . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                            . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                            . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                            . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                            . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                            . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                            . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                            . "style=\"background-image:url(cmn_images/approve1.png);\">&nbsp;</span>"
                            . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                            . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                            . "FINISH"
                            . "</span></span></span></a>"
                            . "</li>";
                    $buttons .= "</ul>"
                            . "</div>";
                    $cntent .= "" . $buttons;
                    $nxQstnIdx = $ttlQstns;
                    $rslt1 = get_SrvyDet($srvyID);
                    //$cntent .= "<div style=\"padding:5px;\">Sorry this Survey/Electronic Voting has been Closed or is Yet to be Opened!";
                    while ($row = loc_db_fetch_array($rslt1)) {
                        //Get Query to Display Election Results Rather if Permitted else
                        $rslt2 = get_SurveyRslts($srvyID, $prsnid);
                        $colsCnt = loc_db_num_fields($rslt2);
                        $cntent .= "<div class=\"rho_form1\" style=\"padding:2px;width:820px;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>SUMMARY OF YOUR VOTES/OPTIONS CHOSEN (" . ($row[1]) . ")</caption>";
                        $cntent .= "<thead><tr>";
                        $cntent .= "<th width=\"200px\" style=\"font-weight:bold;\">ELECTION ITEM OR QUESTION</th>";
                        $cntent .= "<th width=\"250px\" style=\"font-weight:bold;\">POSSIBLE OPTIONS</th>";
                        $cntent .= "<th width=\"50px\" style=\"font-weight:bold;\">NUMBER OF VOTES</th>";
                        //$cntent.= "<th width=\"50px\" style=\"font-weight:bold;\">PERCENTAGE OF VOTES</th>";
                        $cntent .= "</tr></thead>";
                        $cntent .= "<tbody>";
                        $i = 0;
                        $labl = "";
                        $labl1 = "";
                        while ($row1 = loc_db_fetch_array($rslt2)) {
                            $cntent .= "<tr>";
                            $labl1 = "";
                            if ($i == 0) {
                                $labl = "(" . $row1[1] . ") " . $row1[2];
                                $labl1 = $labl;
                            } else if ($labl != "(" . $row1 [1] . ") " . $row1 [2]) {
                                $labl = "(" . $row1[1] . ") " . $row1[2];
                                $labl1 = $labl;
                            } else {
                                $labl1 = "";
                            }
                            $cntent .= "<td width=\"200px\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . $labl1 . "</td>";
                            $cntent .= "<td width=\"250px\">" . $row1[6] . "</td>";
                            $cntent .= "<td width=\"50px\">$row1[8]</td>";
                            //$cntent.= "<td width=\"50px\">" . $row1[9] . "%</td>";
                            $cntent .= "</tr>";
                            $i++;
                        }
                        $cntent .= "</tbody></table></div>";
                    }
                } else {
                    $_SESSION['PRV_OFFST'] = $offst;
                    while ($row = loc_db_fetch_array($rslt)) {
                        $hntTxt = "<button onclick=\"showPageDetails2('$pageHtmlID',7,'$srvyNm',$row[0],0,'QUESTION');\" class=\"btnExample\" type=\"button\" value=\"Further Info!\"><img src=\"cmn_images/alert_info.gif\" width=\"18\" height=\"18\" style=\"height:18px !important;\"/> Further Info!</button>";
                        $cntent .= "<p style=\"margin-bottom:10px;\"><span style=\"font-weight:bold;font-style:italic;font-family:Times;font-size:16px;color:green;text-shadow: 0px 1px #ccffcc;\">" . $row[7] . "</span></p>";
                        $cntent .= "<form action=\"index.php\" method=\"post\">"
                                . "<div><p>(" . $row[1] . ") " . $row[3] . "&nbsp;&nbsp;" . $hntTxt . "</p></div><div><p>"
                                . "<input type=\"hidden\" name=\"grp\" value=\"19\">"
                                . "<input type=\"hidden\" name=\"typ\" value=\"10\">"
                                . "<input type=\"hidden\" name=\"vwtyp\" value=\"0\">"
                                . "<input type=\"hidden\" name=\"pg\" value=\"5\">"
                                . "<input type=\"hidden\" name=\"questionID\" value=\"$row[0]\">"
                                . "<input type=\"hidden\" name=\"pkeyID\" value=\"$row[0]\"><table><tbody>";
                        $rslt1 = get_QstnPssblAnswers($row[0], $srvyID);
                        $ansTagType = "";
                        $checked = "";
                        // if ($row[4] == "Multiple-Text Answers (Textarea)")
                        if ($row[4] == "Single Answer (Radio)") {
                            while ($row1 = loc_db_fetch_array($rslt1)) {
                                $checked = "";
                                $ansTagType .= "<tr>";
                                if (getPrsnChosenAnswerID($row[0], $prsnid, $srvyID, $row1[0]) > 0) {
                                    $checked = "checked=\"checked\"";
                                }
                                $hntTxt = "<button onclick=\"showPageDetails2('$pageHtmlID',7,'$srvyNm',$row1[0],0,'ANSWER');\" class=\"btnExample\" type=\"button\" value=\"$row[5]\"><img src=\"cmn_images/alert_info.gif\" width=\"18\" height=\"18\" style=\"height:18px !important;\"/>$row[5]</button>";
                                $ansTagType .= "<td><input type=\"radio\" name=\"answer\" value=\"$row1[0]\" $checked> $row1[1]</td><td>&nbsp;</td><td>$hntTxt</td>";
                                $ansTagType .= "</tr>";
                            }
                        } else if ($row[4] == "Multiple-Select Answers (Checkbox)") {
                            while ($row1 = loc_db_fetch_array($rslt1)) {
                                $checked = "";
                                $ansTagType .= "<tr>";
                                if (getPrsnChosenAnswerID($row[0], $prsnid, $srvyID, $row1 [0]) > 0) {
                                    $checked = "checked=\"checked\"";
                                }
                                $hntTxt = "<button onclick=\"showPageDetails2('$pageHtmlID',7,'$srvyNm',$row1[0],0,'ANSWER');\" class=\"btnExample\" type=\"button\" value=\"$row[5]\"><img src=\"cmn_images/alert_info.gif\" width=\"18\" height=\"18\" style=\"height:18px !important;\"/>$row[5]</button>";
                                $ansTagType .= "<td><input type=\"checkbox\" name=\"answer\" value=\"$row1[0]\" $checked> $row1[1]</td><td>&nbsp;</td><td>$hntTxt</td>";
                                $ansTagType .= "</tr>";
                            }
                        } else if ($row[4] == "Single-Text Answer (Textfield)") {
                            $prvAnswer = getPrsnChosenAnswer($row[0], $prsnid, $srvyID, -1);
                            $ansTagType = "<input type=\"text\" name=\"answer\" value=\"$prvAnswer\"><br>";
                        } else {
                            $prvAnswer = getPrsnChosenAnswer($row[0], $prsnid, $srvyID, -1);
                            $ansTagType = "<textarea rows=\"4\" cols=\"50\" name=\"answer\">$prvAnswer</textarea><br>";
                        }
                        $No = 5;
                        $srvyNm = get_SrvyNm($srvyID);
                        $buttons = "<br/><div style=\"float:left;min-width:50%;\">"
                                . "<ul class=\"no_bullet\" style=\"float:none;\">";
                        $buttons .= "<li class=\"leaf\" style=\"margin:2px 150px 2px 2px;\">"
                                . "<a href=\"javascript: showPageDetails2('$pageHtmlID',$No,'$srvyNm',$srvyID," . ($_SESSION['PRV_OFFST'] ) . ",'PREVIOUS');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                                . "style=\"padding:0px;height:80px;width:140px;\" "
                                . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                                . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                                . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                                . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                                . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                                . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                                . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                                . "style=\"background-image:url(cmn_images/Backward.png);\">&nbsp;</span>"
                                . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                                . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                                . "PREVIOUS"
                                . "</span></span></span></a>"
                                . "</li>";
                        $buttons .= "<li class=\"leaf\" style=\"margin:2px 2px 2px 150px;\">"
                                . "<a href=\"javascript: showPageDetails2('$pageHtmlID',$No,'$srvyNm',$srvyID," . ($nxQstnIdx + 1) . ",'NEXT');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                                . "style=\"padding:0px;height:80px;width:140px;\" "
                                . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                                . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                                . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                                . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                                . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                                . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                                . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                                . "style=\"background-image:url(cmn_images/Forward.png);\">&nbsp;</span>"
                                . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                                . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                                . "NEXT"
                                . "</span></span></span></a>"
                                . "</li>";
                        $buttons .= "</ul>"
                                . "</div>";
                        $cntent .= $ansTagType . "</tbody></table></p></div></form>" . "</div>$buttons";
                    }
                }
            } else if ($nxQstnIdx >= $ttlQstns + 1) {
                $cntent .= "<div class=\"rho_form1\" style=\"max-width:500px;padding:20px;\">"
                        . "<p style=\"margin-bottom:10px;\"><span style=\"font-weight:bold;font-size:24px;color:blue;text-shadow: 0px 1px #ccccff;\">" . $srvyNm . "</span></p>";
                $cntent .= "<form><p>Congratulations! You have successfully completed all Sections of this Survey/Election!<br/>"
                        . "Please click on FINISH to end your Voting Session<br/>"
                        . "NB: Once you click on FINISH you cannot review your Options Selected!</p><input type=\"hidden\" name=\"shdSubmit\" value=\"1\"></form>";

                $No = 5;
                $nxQstnIdx = $ttlQstns;
                $buttons = "<br/><div style=\"float:left;min-width:50%;margin-top:5px;\">"
                        . "<ul class=\"no_bullet\" style=\"float:none;\">";
                $buttons .= "<li class=\"leaf\" style=\"margin:2px 150px 2px 2px;\">"
                        . "<a href=\"javascript: showPageDetails2('$pageHtmlID',$No,'$srvyNm',$srvyID," . ( $_SESSION['PRV_OFFST'] + 1 ) . ",'PREVIOUS');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                        . "style=\"padding:0px;height:80px;width:140px;\" "
                        . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                        . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                        . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                        . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                        . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                        . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                        . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                        . "style=\"background-image:url(cmn_images/Backward.png);\">&nbsp;</span>"
                        . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                        . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                        . "PREVIOUS"
                        . "</span></span></span></a>"
                        . "</li>";
                $buttons .= "<li class=\"leaf\" style=\"margin:2px 150px 2px 2px;\">"
                        . "<a href=\"javascript: showPageDetails2('$pageHtmlID',5,'$srvyNm',$srvyID,0,'FINISH');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                        . "style=\"padding:0px;height:80px;width:140px;\" "
                        . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                        . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                        . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                        . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                        . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                        . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                        . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                        . "style=\"background-image:url(cmn_images/approve1.png);\">&nbsp;</span>"
                        . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                        . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">"
                        . "FINISH"
                        . "</span></span></span></a>"
                        . "</li>";
                $buttons .= "</ul>"
                        . "</div>";
                $cntent .= "</div>" . $buttons;
            }
        }
        echo $cntent;
    } else if ($pgNo == 6) {
        $inptPrsnAnsID = isset($_POST['prsnAnsID']) ? cleanInputData($_POST['prsnAnsID']) : -1;

        $updtSQL1 = "UPDATE self.self_person_question_answers SET is_submitted='0' WHERE prsn_ansr_id=" . $inptPrsnAnsID;
        $afctd1 = execUpdtInsSQL($updtSQL1);
        echo "<p>Successfully Re-Opened $afctd1 Selected Submitted Votes!</p>";

        /* $actionNm = $answerTxts = isset($_POST['actionNm']) ? cleanInputData($_POST['actionNm']) : '';
          if ($actionNm == "OPEN ELECTION") {
          $updtSQL = "UPDATE self.self_surveys
          SET srvy_end_date='4000-12-31 23:59:59',
          eligible_prsn_set_id = 4
          WHERE srvy_id=1;";
          $afctd = execUpdtInsSQL($updtSQL);
          $updtSQL1 = "UPDATE self.self_person_question_answers SET is_submitted='0'  WHERE srvy_id=1;";
          $afctd1 = execUpdtInsSQL($updtSQL1);
          echo "<p>Successfully Opened $afctd Selected Election and $afctd1 Submitted Votes!</p>";
          } else {
          $updtSQL = "UPDATE self.self_surveys
          SET srvy_end_date=to_char(now(),'YYYY-MM-DD HH24:MI:SS'),
          eligible_prsn_set_id = 4
          WHERE srvy_id=1;";
          $afctd = execUpdtInsSQL($updtSQL);
          echo "<p>Successfully Closed $afctd Selected Election!</p>";
          } */
    } else if ($pgNo == 7) {
        $actionNm = isset($_POST['actionNm']) ? cleanInputData($_POST['actionNm']) : '';
        $pkeyID = isset($_POST['pkeyID']) ? cleanInputData($_POST['pkeyID']) : 0;
        if ($actionNm == "ANSWER") {
            echo "<p>" . get_AnsHint($pkeyID) . "</p>";
        } else {
            echo "<p>" . get_QstnHint($pkeyID) . "</p>";
        }
    } else {
        restricted();
    }
} else {
    restricted();
}

/*
 * Create/Update/Delete Person Set/Person Set Det
 * Create/Update/Delete Question Bank/Answers
 * Create/Update/Delete Elections/Question Sets
 */

function deleteSurveyQstns($hdrid) {
    $insSQL = "DELETE FROM self.self_srvy_qustns WHERE srvy_qstn_id = " . $hdrid;
    $affctd = execUpdtInsSQL($insSQL);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Survey/Election Question(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createSurveyQstns($srvyID, $qstnID, $qstnOrder, $qstnDsplCondtn) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_srvy_qustns(
            srvy_id, qstn_id, qstn_order, created_by, creation_date, 
            last_update_by, last_update_date, qstn_dsply_condtn_sql) " .
            "VALUES (" . $srvyID .
            "," . $qstnID .
            "," . $qstnOrder .
            ", " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "', '" . loc_db_escape_string($qstnDsplCondtn) .
            "')";
    execUpdtInsSQL($insSQL);
}

function updateSurveyQstns($srvyQstnID, $qstnOrder, $qstnDsplCondtn) {
    global $usrID;
    $dateStr = getDB_Date_time();

    $insSQL = "UPDATE self.self_srvy_qustns " .
            "SET qstn_dsply_condtn_sql='" . loc_db_escape_string($qstnDsplCondtn) .
            "', qstn_order = " . $qstnOrder .
            ", last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "' WHERE srvy_qstn_id = " . $srvyQstnID;
    execUpdtInsSQL($insSQL);
}

function deleteSurvey($hdrid) {
    $insSQL = "DELETE FROM self.self_surveys WHERE srvy_id = " . $hdrid;
    $affctd = execUpdtInsSQL($insSQL);
    $insSQL1 = "DELETE FROM self.self_srvy_qustns WHERE srvy_id = " . $hdrid;
    $affctd1 = execUpdtInsSQL($insSQL1);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Survey/Election(s)!";
        $dsply .= "<br/>$affctd1 Survey/Election Question(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createSurvey($srvyNm, $srvyDesc, $srvyInstrctns, $srvyStartDte, $srvyEndDte, $inclPrsnSetID, $exclPrsnSetID, $srvyType) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_surveys(
            srvy_name, srvy_desc, srvy_instrctns, created_by, creation_date, 
            last_update_by, last_update_date, srvy_start_date, srvy_end_date, 
            eligible_prsn_set_id, survey_type, exclsn_lst_prsn_set_id) " .
            "VALUES ('" . loc_db_escape_string($srvyNm) .
            "', '" . loc_db_escape_string($srvyDesc) .
            "', '" . loc_db_escape_string($srvyInstrctns) .
            "', " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "', '" . loc_db_escape_string($srvyStartDte) .
            "', '" . loc_db_escape_string($srvyEndDte) .
            "', " . $inclPrsnSetID .
            ", '" . loc_db_escape_string($srvyType) .
            "', " . $exclPrsnSetID .
            ")";
    execUpdtInsSQL($insSQL);
}

function updateSurvey($srvyID, $srvyNm, $srvyDesc, $srvyInstrctns, $srvyStartDte, $srvyEndDte, $inclPrsnSetID, $exclPrsnSetID, $srvyType) {
    global $usrID;
    $dateStr = getDB_Date_time();

    $insSQL = "UPDATE self.self_surveys " .
            "SET srvy_name='" . loc_db_escape_string($srvyNm) .
            "', srvy_desc='" . loc_db_escape_string($srvyDesc) .
            "', srvy_instrctns = '" . loc_db_escape_string($srvyInstrctns) .
            "', eligible_prsn_set_id = " . $inclPrsnSetID .
            ", exclsn_lst_prsn_set_id = " . $exclPrsnSetID .
            ", srvy_start_date = '" . loc_db_escape_string($srvyStartDte) .
            "', srvy_end_date = '" . loc_db_escape_string($srvyEndDte) .
            "', survey_type = '" . loc_db_escape_string($srvyType) .
            "', last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "' WHERE srvy_id = " . $srvyID;
    execUpdtInsSQL($insSQL);
}

function deleteQuestionAns($pssblAnsId) {
    $insSQL = "DELETE FROM self.self_question_possible_answers WHERE psbl_ansr_id = " . $pssblAnsId;
    $affctd = execUpdtInsSQL($insSQL);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Possible Answer(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createQuestionAns($qstnID, $ansdesc, $ansOrdrNo, $isCorrectAns, $ansImgLoc, $ansHintTxt, $ansHint, $isAnsEnabled) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_question_possible_answers(
            qstn_id, psbl_ansr_desc, psbl_ansr_order_no, correct_ansr, 
            created_by, creation_date, last_update_by, last_update_date, 
            answer_img_loc, answer_hint_link_txt, answer_hint, is_enabled) " .
            "VALUES (" . $qstnID . ", '" . loc_db_escape_string($ansdesc) .
            "', " . $ansOrdrNo . ",  '" . loc_db_escape_string($isCorrectAns) .
            "', " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "', '" . loc_db_escape_string($ansImgLoc) .
            "', '" . loc_db_escape_string($ansHintTxt) .
            "', '" . loc_db_escape_string($ansHint) . "','" . loc_db_escape_string($isAnsEnabled) . "')";

    execUpdtInsSQL($insSQL);
}

function updateQuestionAns($pssblAnsID, $ansdesc, $ansOrdrNo, $isCorrectAns, $ansImgLoc, $ansHintTxt, $ansHint, $isAnsEnabled) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE self.self_question_possible_answers " .
            "SET psbl_ansr_desc='" . loc_db_escape_string($ansdesc) .
            "', correct_ansr='" . loc_db_escape_string($isCorrectAns) .
            "', answer_img_loc = '" . loc_db_escape_string($ansImgLoc) .
            "', psbl_ansr_order_no = " . $ansOrdrNo .
            ", answer_hint_link_txt = '" . loc_db_escape_string($ansHintTxt) .
            "', answer_hint = '" . loc_db_escape_string($ansHint) .
            "', last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "', is_enabled='" . loc_db_escape_string($isAnsEnabled) .
            "' WHERE psbl_ansr_id = " . $pssblAnsID;

    execUpdtInsSQL($insSQL);
}

function deleteSurvyQstnAns($srvQstnAnsId) {
    $insSQL = "DELETE FROM self.self_srvy_qustns_ans WHERE srvy_qstn_ans_id = " . $srvQstnAnsId;
    $affctd = execUpdtInsSQL($insSQL);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Survey Question Answer(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createSurvyQstnAns($srvyID, $qstnID, $ansID, $ansOrdrNo, $isCorrectAns, $ansDsplyCondition) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_srvy_qustns_ans(
            srvy_id, qstn_id, pssbl_ans_id, ans_order, correct_ansr, 
            created_by, creation_date, last_update_by, last_update_date, 
            ans_dsply_condtn_sql) " .
            "VALUES (" . $srvyID . ", " . $qstnID . ", " . $ansID . ", " . $ansOrdrNo .
            ", '" . loc_db_escape_string($isCorrectAns) .
            "', " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "', '" . loc_db_escape_string($ansDsplyCondition) . "')";
    execUpdtInsSQL($insSQL);
}

function updateSurvyQstnAns($srvyQstnAnsID, $ansOrdrNo, $isCorrectAns, $ansDsplyCondition) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE self.self_srvy_qustns_ans " .
            "SET ans_dsply_condtn_sql='" . loc_db_escape_string($ansDsplyCondition) .
            "', correct_ansr='" . loc_db_escape_string($isCorrectAns) .
            "', ans_order = " . $ansOrdrNo .
            ", last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "' WHERE srvy_qstn_ans_id = " . $srvyQstnAnsID;
    execUpdtInsSQL($insSQL);
}

function deleteQuestion($hdrid) {
    $insSQL = "DELETE FROM self.self_question_bank WHERE qstn_id = " . $hdrid;
    $affctd = execUpdtInsSQL($insSQL);
    $insSQL1 = "DELETE FROM self.self_question_possible_answers WHERE qstn_id = " . $hdrid;
    $affctd1 = execUpdtInsSQL($insSQL1);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Person Set(s)!";
        $dsply .= "<br/>$affctd1 Person Set Detail(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">

    $dsply</p>";
    }
}

function createQuestion($qstndesc, $qstnAnsType, $imgLoc, $allwdAns, $qstnClsfctn, $qstnHint) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_question_bank(
            qstn_desc, qstn_ansr_type, created_by, creation_date, 
            last_update_by, last_update_date, qstn_img_loc, allwd_num_slctd_ans, 
            category_clsfctn, question_hint) " .
            "VALUES ('" . loc_db_escape_string($qstndesc) .
            "', '" . loc_db_escape_string($qstnAnsType) .
            "', " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "', '" . loc_db_escape_string($imgLoc) .
            "', " . $allwdAns .
            ", '" . loc_db_escape_string($qstnClsfctn) .
            "', '" . loc_db_escape_string($qstnHint) . "')";

    execUpdtInsSQL($insSQL);
}

function updateQuestion($qstnID, $qstndesc, $qstnAnsType, $imgLoc, $allwdAns, $qstnClsfctn, $qstnHint) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE self.self_question_bank " .
            "SET qstn_desc='" . loc_db_escape_string($qstndesc) .
            "', qstn_ansr_type='" . loc_db_escape_string($qstnAnsType) .
            "', qstn_img_loc = '" . loc_db_escape_string($imgLoc) .
            "', allwd_num_slctd_ans = " . $allwdAns .
            ", category_clsfctn = '" . loc_db_escape_string($qstnClsfctn) .
            "', question_hint = '" . loc_db_escape_string($qstnHint) .
            "', last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "' WHERE qstn_id = " . $qstnID;

    execUpdtInsSQL($insSQL);
}

function get_QstnCtgries() {
    $sqlStr = "Select row_number() OVER (ORDER BY tbl1.category) AS \"No.  \", 
tbl1.category AS \"Question Category  \"
 FROM (select distinct category_clsfctn category 
from self.self_question_bank where category_clsfctn != '') tbl1 
order by 2";

    $result = executeSQLNoParams($sqlStr);

    return $result;
}

function deletePersonSetDet($detID) {
    $insSQL = "DELETE FROM pay.pay_prsn_sets_det WHERE prsn_set_det_id = " . $detID;
    $affctd = execUpdtInsSQL($insSQL);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Person Set Detail(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">

    $dsply</p>";
    }
}

function createPersonSetDet($hdrID, $prsID) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO pay.pay_prsn_sets_det(" .
            "prsn_set_hdr_id, person_id, created_by, creation_date, " .
            "last_update_by, last_update_date) " .
            "VALUES (" . $hdrID .
            ", " . $prsID .
            ", " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "')";
    return

            execUpdtInsSQL($insSQL);
}

function doesPrsStHvPrs($hdrID, $prsnID) {
    $strSql = "Select a.prsn_set_det_id FROM pay.pay_prsn_sets_det a where((a.prsn_set_hdr_id = " .
            $hdrID . ") and (a.person_id = " . $prsnID . "))";
    $result = executeSQLNoParams($strSql);
    if (loc_db_num_rows($result) > 0) {
        return true;
    }

    return false;
}

function getQstnAnsID($qstnID, $pssblAns) {
    $strSql = "Select a.psbl_ansr_id "
            . "FROM self.self_question_possible_answers a where((a.qstn_id  = " .
            $qstnID . ") and (a.psbl_ansr_desc = '" . loc_db_escape_string($pssblAns) . "'))";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function getSurveyQstnID($surveyID, $qstnID) {
    $strSql = "Select a.srvy_qstn_id "
            . "FROM self.self_srvy_qustns a where((a.qstn_id  = " .
            $qstnID . ") and (a.srvy_id = " . $surveyID . "))";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function getSurveyQstnAnsID($surveyID, $qstnID, $pssblAnsID) {
    $strSql = "Select a.srvy_qstn_ans_id "
            . "FROM self.self_srvy_qustns_ans a where((a.qstn_id  = " .
            $qstnID . ") and (a.srvy_id = " . $surveyID . ") and (a.pssbl_ans_id = " . $pssblAnsID . "))";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function deletePersonSet($hdrid) {
    $insSQL = "DELETE FROM pay.pay_prsn_sets_hdr WHERE prsn_set_hdr_id = " . $hdrid;
    $affctd = execUpdtInsSQL($insSQL);
    $insSQL1 = "DELETE FROM pay.pay_prsn_sets_det WHERE prsn_set_hdr_id = " . $hdrid;
    $affctd1 = execUpdtInsSQL($insSQL1);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Person Set(s)!";
        $dsply .= "<br/>$affctd1 Person Set Detail(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">

    $dsply</p>";
    }
}

function createPersonSet($orgid, $prssetname, $prsstdesc, $isenbled, $sqlQry, $isdflt, $usesSQL) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO pay.pay_prsn_sets_hdr(
            prsn_set_hdr_name, prsn_set_hdr_desc, is_enabled, 
            created_by, creation_date, last_update_by, last_update_date, 
            sql_query, org_id, is_default, uses_sql) " .
            "VALUES ('" . loc_db_escape_string($prssetname) .
            "', '" . loc_db_escape_string($prsstdesc) .
            "', '" . loc_db_escape_string($isenbled) .
            "', " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "', '" . loc_db_escape_string($sqlQry) .
            "', " . $orgid . ", '" . loc_db_escape_string($isdflt) .
            "', '" . loc_db_escape_string($usesSQL) . "')";

    execUpdtInsSQL($insSQL);
}

function updatePersonSet($hdrid, $prssetname, $prsstdesc, $isenbled, $sqlQry, $isdflt, $usesSQL) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE pay.pay_prsn_sets_hdr " .
            "SET prsn_set_hdr_name='" . loc_db_escape_string($prssetname) .
            "', prsn_set_hdr_desc='" . loc_db_escape_string($prsstdesc) .
            "', is_enabled = '" . loc_db_escape_string($isenbled) .
            "', sql_query = '" . loc_db_escape_string($sqlQry) .
            "', is_default = '" . loc_db_escape_string($isdflt) .
            "', uses_sql = '" . loc_db_escape_string($usesSQL) .
            "', last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "' WHERE prsn_set_hdr_id = " . $hdrid;

    execUpdtInsSQL($insSQL);
}

function get_Surveys($searchFor, $searchIn, $offset, $limit_size) {
    $wherecls = "";
    if ($searchIn === "Name") {
        $wherecls = "(a.srvy_name ilike '" .
                loc_db_escape_string($searchFor) . "' or a.srvy_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else if ($searchIn === "Instructions") {
        $wherecls = "(a.srvy_instrctns ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else {
        $wherecls = "(a.survey_type ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }
    $strSql = "SELECT a.srvy_id, a.srvy_name, a.srvy_desc, a.srvy_instrctns, a.srvy_start_date, "
            . "a.srvy_end_date, a.eligible_prsn_set_id, COALESCE(b.prsn_set_hdr_name,''), "
            . "a.survey_type, a.exclsn_lst_prsn_set_id, COALESCE(c.prsn_set_hdr_name,'') " .
            "FROM self.self_surveys a "
            . "LEFT OUTER JOIN pay.pay_prsn_sets_hdr b ON (a.eligible_prsn_set_id = b.prsn_set_hdr_id) "
            . "LEFT OUTER JOIN pay.pay_prsn_sets_hdr c ON (a.exclsn_lst_prsn_set_id = c.prsn_set_hdr_id) "
            . "WHERE " . $wherecls .
            "(1=1) ORDER BY a.srvy_id DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    //echo $strSql;
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_PrsnSetDetail($prsnSetID) {
    $strSql = "SELECT 
        prsn_set_hdr_id \"Person Set ID\", 
        prsn_set_hdr_name \"Person Set Name\", 
        prsn_set_hdr_desc \"Person Set Description\", 
       (CASE WHEN uses_sql='1' THEN 'YES' ELSE 'NO' END) \"Uses SQL?\", 
        sql_query \"SQL Query\", 
       (CASE WHEN is_default='1' THEN 'YES' ELSE 'NO' END) \"Is Default Set?\", 
       (CASE WHEN is_enabled='1' THEN 'YES' ELSE 'NO' END) \"Is Enabled?\" 
       FROM pay.pay_prsn_sets_hdr a " .
            "WHERE (prsn_set_hdr_id = $prsnSetID)";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_QuestionDetail($qstn_id) {
    $strSql = "SELECT 
        qstn_id \"Question ID\", 
        qstn_desc \"Question\", 
        qstn_ansr_type \"Answer Type\", 
       qstn_img_loc \"Image Location\", 
        allwd_num_slctd_ans \"Max. No. of Selected Answers\", 
       category_clsfctn \"Question Category\", 
       question_hint \"Question Hint/Further Info.\" 
       FROM self.self_question_bank a " .
            "WHERE (qstn_id = $qstn_id)";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_AnswerDetail($ans_id) {
    $strSql = "SELECT 
        psbl_ansr_id \"Possible Answer ID\", 
        psbl_ansr_desc \"Answer\", 
        psbl_ansr_order_no \"Answer Order No.\", 
        (CASE WHEN correct_ansr='1' THEN 'YES' ELSE 'NO' END) \"Is Correct Answer?\",
       answer_img_loc \"Image Location\", 
        answer_hint_link_txt \"Hint Link Text\", 
      answer_hint \"Answer Hint/Further Info.\" 
       FROM self.self_question_possible_answers a " .
            "WHERE (psbl_ansr_id = $ans_id)";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_SrvyQstnAnsDetail($srvyQstnID) {
    $strSql = "SELECT b.srvy_qstn_ans_id \"Survey Question Answer ID\", 
        b.srvy_id \"Survey ID\", 
        a.qstn_id \"Question ID\", 
        a.psbl_ansr_id \"Possible Answer ID\", 
        a.psbl_ansr_desc \"Answer \", 
        b.ans_order \"Answer Sort No. \", 
        (CASE WHEN b.correct_ansr='1' THEN 'YES' ELSE 'NO' END) \"Is Correct Answer?\", 
        a.answer_img_loc \"Answer Image Location \", 
        a.answer_hint_link_txt \"Answer Hint Link Text \", 
        a.answer_hint \"Answer Hint\", 
        b.ans_dsply_condtn_sql \"Answer Display Condition \", 
        (CASE WHEN a.is_enabled='1' THEN 'YES' ELSE 'NO' END) \"Is Enabled?\" 
        FROM self.self_question_possible_answers a, self.self_srvy_qustns_ans b  
        WHERE b.srvy_qstn_ans_id = " . $srvyQstnID .
            " and a.qstn_id = b.qstn_id and a.psbl_ansr_id = b.pssbl_ans_id";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_SurveyDetail($srvy_id) {
    $strSql = "SELECT 
        a.srvy_id \"Survey/Election ID\", 
        a.srvy_name \"Survey/Election Name\", 
        a.srvy_desc \"Survey/Election Description\", 
        a.srvy_instrctns \"Survey/Election Instructions\",
        to_char(to_timestamp(a.srvy_start_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') \"Start Date \", 
        to_char(to_timestamp(a.srvy_end_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') \"End Date \", 
        a.survey_type \"Survey/Election Type\",
      b.prsn_set_hdr_name \"Eligible Persons' Set \",
      c.prsn_set_hdr_name \"Exclusion List Person Set \"
       FROM self.self_surveys a 
       LEFT OUTER JOIN pay.pay_prsn_sets_hdr b ON (a.eligible_prsn_set_id=b.prsn_set_hdr_id)
       LEFT OUTER JOIN pay.pay_prsn_sets_hdr c ON (a.exclsn_lst_prsn_set_id=c.prsn_set_hdr_id)  " .
            "WHERE (srvy_id = $srvy_id)";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_SurveyQstnsDetail($srvy_qstn_id) {
    $strSql = "SELECT 
        a.srvy_id \"Survey/Election ID \", 
        a.srvy_qstn_id \"Primary Key\",
        a.qstn_id \"Question ID \", 
        b.qstn_desc \"Question \", 
        a.qstn_order \"Question Order No. \", 
        a.qstn_dsply_condtn_sql \"Question Display Condition \"
       FROM self.self_srvy_qustns a 
       LEFT OUTER JOIN self.self_question_bank b ON (a.qstn_id=b.qstn_id) " .
            "WHERE (srvy_qstn_id = $srvy_qstn_id)";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_SurveysTtl($searchFor, $searchIn) {
    $wherecls = "";
    if ($searchIn === "Name") {
        $wherecls = "(a.srvy_name ilike '" .
                loc_db_escape_string($searchFor) . "' or a.srvy_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else if ($searchIn === "Instructions") {
        $wherecls = "(a.srvy_instrctns ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else {
        $wherecls = "(a.survey_type ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }
    $strSql = "SELECT count(1) from self.self_surveys a WHERE " . $wherecls .
            "(1=1)";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_SrvyQuestions($offset, $limit_size, $srvyID) {
    $strSql = "SELECT a.srvy_qstn_id, b.qstn_desc, a.qstn_dsply_condtn_sql, a.qstn_id, a.qstn_order " .
            "FROM self.self_srvy_qustns a, self.self_question_bank b "
            . "WHERE a.qstn_id = b.qstn_id and a.srvy_id= " . $srvyID
            . " ORDER BY a.qstn_order LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_SrvyQuestionsTtl($srvyID) {
    $strSql = "SELECT count(1) " .
            "FROM self.self_srvy_qustns a WHERE a.srvy_id= " . $srvyID
            . "";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_SrvyAnsChosen($searchFor, $searchIn, $offset, $limit_size, $srvyID) {
    $whrcls = "";
    if ($searchIn == "Answer") {
        $whrcls = " and (trim(a.ansr_desc) ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Question") {
        $whrcls = " and (trim(b.qstn_desc) ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Person Name") {
        $whrcls = " and ((prs.get_prsn_name(a.prsn_id) || ' (' || prs.get_prsn_loc_id(a.prsn_id) || ')') ilike '" . loc_db_escape_string($searchFor) . "')";
    }
    $strSql = "SELECT a.prsn_ansr_id, a.qstn_id, b.qstn_desc, a.prsn_id, 
        prs.get_prsn_name(a.prsn_id) || ' (' || prs.get_prsn_loc_id(a.prsn_id) || ')',
        a.psbl_ansr_id, trim(a.ansr_desc), a.is_submitted
  FROM self.self_person_question_answers a, 
  self.self_question_bank b 
  where a.qstn_id = b.qstn_id and a.srvy_id = " . $srvyID . $whrcls .
            " ORDER BY a.prsn_ansr_id ASC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SrvyAnsChosenTtl($searchFor, $searchIn, $srvyID) {
    $whrcls = "";
    if ($searchIn == "Answer") {
        $whrcls = " and (trim(a.ansr_desc) ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Question") {
        $whrcls = " and (trim(b.qstn_desc) ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Person Name") {
        $whrcls = " and ((prs.get_prsn_name(a.prsn_id) || ' (' || prs.get_prsn_loc_id(a.prsn_id) || ')') ilike '" . loc_db_escape_string($searchFor) . "')";
    }
    $strSql = "SELECT count(1) 
  FROM self.self_person_question_answers a, 
  self.self_question_bank b 
  where a.qstn_id = b.qstn_id and a.srvy_id = " . $srvyID . $whrcls;

    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_Questions($searchFor, $searchIn, $offset, $limit_size) {
    $wherecls = "";
    if ($searchIn === "Question") {
        $wherecls = "(a.qstn_desc ilike '" .
                loc_db_escape_string($searchFor) . "' or a.question_hint ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else if ($searchIn === "Category") {
        $wherecls = "(a.category_clsfctn ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else {
        $wherecls = "(a.question_hint ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }

    $strSql = "SELECT a.qstn_id, a.qstn_desc, a.qstn_ansr_type, a.qstn_img_loc, a.allwd_num_slctd_ans, a.category_clsfctn, a.question_hint " .
            "FROM self.self_question_bank a WHERE " . $wherecls .
            "(1=1) "
            . "ORDER BY a.qstn_id DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    //echo $strSql;
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_QuestionsTtl($searchFor, $searchIn) {
    $wherecls = "";
    if ($searchIn === "Question") {
        $wherecls = "(a.qstn_desc ilike '" .
                loc_db_escape_string($searchFor) . "' or a.question_hint ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else if ($searchIn === "Category") {
        $wherecls = "(a.category_clsfctn ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else {
        $wherecls = "(a.question_hint ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }
    $strSql = "SELECT count(1) from self.self_question_bank a WHERE " . $wherecls .
            "(1=1)";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_Answers($offset, $limit_size, $questionID) {
    $strSql = "SELECT a.psbl_ansr_id, a.psbl_ansr_desc, a.correct_ansr, "
            . "a.answer_img_loc, a.answer_hint_link_txt, a.answer_hint, "
            . "a.psbl_ansr_order_no, a.is_enabled " .
            "FROM self.self_question_possible_answers a WHERE a.qstn_id= " . $questionID
            . " ORDER BY a.psbl_ansr_order_no LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_AnswersTtl($questionID) {
    $strSql = "SELECT count(1) " .
            "FROM self.self_question_possible_answers a "
            . "WHERE a.qstn_id= " . $questionID
            . "";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_PrsnSets($searchFor, $searchIn, $offset, $limit_size, $orgID) {
    $wherecls = "";
    if ($searchIn === "Name") {
        $wherecls = "(a.prsn_set_hdr_name ilike '" .
                loc_db_escape_string($searchFor) . "' or a.prsn_set_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else {
        $wherecls = "(a.prsn_set_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }

    $strSql = "SELECT a.prsn_set_hdr_id, a.prsn_set_hdr_name, a.prsn_set_hdr_desc, a.is_enabled, a.sql_query, a.is_default, a.uses_sql " .
            "FROM pay.pay_prsn_sets_hdr a WHERE " . $wherecls .
            "(a.org_id = " . $orgID . ") "
            . "ORDER BY a.prsn_set_hdr_id DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    //echo $strSql;
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_PrsnSetsTtl($searchFor, $searchIn, $orgID) {
    $wherecls = "";
    if ($searchIn === "Name") {
        $wherecls = "(a.prsn_set_hdr_name ilike '" .
                loc_db_escape_string($searchFor) . "' or a.prsn_set_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    } else {
        //Description
        $wherecls = "(a.prsn_set_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }
    $strSql = "SELECT count(1) from pay.pay_prsn_sets_hdr a WHERE " . $wherecls .
            "(org_id = " . $orgID . ")";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function getPrsStSQL($prsStID) {
    $strSql = "select sql_query from pay.pay_prsn_sets_hdr where prsn_set_hdr_id = " .
            $prsStID . "";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_PrsnSetsDt($searchFor, $searchIn, $offset, $limit_size, $prsStID) {
    $prsSQL = getPrsStSQL($prsStID);
    $strSql = "";
    $mnlSQL = "Select distinct a.person_id, a.local_id_no, trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) full_name, b.prsn_set_det_id " .
            "from prs.prsn_names_nos a, pay.pay_prsn_sets_det b " .
            "WHERE ((a.person_id = b.person_id) and (b.prsn_set_hdr_id = " . $prsStID .
            " ) and (a.local_id_no ilike '" .
            loc_db_escape_string($searchFor) . "' or trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) ilike '" .
            loc_db_escape_string($searchFor) . "')) ORDER BY a.local_id_no DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    $strSql = "select * from (" . $prsSQL . ") tbl1 "
            . "WHERE (tbl1.local_id_no ilike '" .
            loc_db_escape_string($searchFor) . "' or tbl1.full_name ilike '" .
            loc_db_escape_string($searchFor) . "') ORDER BY tbl1.local_id_no DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    if ($prsSQL == "") {
        $strSql = $mnlSQL;
    }
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_PrsnSetsDtTtl($searchFor, $searchIn, $prsStID) {
    $prsSQL = getPrsStSQL($prsStID);
    $strSql = "";
    $mnlSQL = "Select distinct a.person_id, a.local_id_no, trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) full_name, b.prsn_set_det_id " .
            "from prs.prsn_names_nos a, pay.pay_prsn_sets_det b " .
            "WHERE ((a.person_id = b.person_id) and (b.prsn_set_hdr_id = " . $prsStID .
            " ))";
    $strSql = "select count(1) from (" . $prsSQL . ") tbl1 "
            . "WHERE (tbl1.local_id_no ilike '" .
            loc_db_escape_string($searchFor) . "' or tbl1.full_name ilike '" .
            loc_db_escape_string($searchFor) . "') ";
    if ($prsSQL == "") {
        $strSql = "select count(1) from (" . $mnlSQL . ") tbl1 "
                . "WHERE (tbl1.local_id_no ilike '" .
                loc_db_escape_string($searchFor) . "' or tbl1.full_name ilike '" .
                loc_db_escape_string($searchFor) . "') ";
    }
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_MyActvSrvysTblr($prsnID) {
    $strSql = "SELECT srvy_id, srvy_name, srvy_desc, srvy_instrctns, srvy_start_date, srvy_end_date, 
       eligible_prsn_set_id, survey_type 
  FROM self.self_surveys y
  WHERE (survey_type IN ('ELECTION', 'SURVEY')) 
  and pay.does_prsn_exist_in_prs_st(y.eligible_prsn_set_id, $prsnID)>=1 "
            . " and pay.does_prsn_exist_in_prs_st(y.exclsn_lst_prsn_set_id, $prsnID)<=0"
            . " ORDER BY srvy_start_date DESC LIMIT 20 OFFSET 0";
    //echo $strSql;
    /* now() between to_timestamp(srvy_start_date, 'YYYY-MM-DD HH24:MI:SS') 
      and to_timestamp(srvy_end_date, 'YYYY-MM-DD HH24:MI:SS') and */
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_ActvSrvyDet($srvyID) {
    $strSql = "SELECT srvy_id, srvy_name, srvy_desc, 
        srvy_instrctns, srvy_start_date, srvy_end_date, 
       eligible_prsn_set_id, survey_type 
  FROM self.self_surveys y
  WHERE (now() between to_timestamp(srvy_start_date, 'YYYY-MM-DD HH24:MI:SS') 
      and to_timestamp(srvy_end_date, 'YYYY-MM-DD HH24:MI:SS') and 
      y.srvy_id = $srvyID

            )

            ";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function hasSrvyBeenClosed($srvyID) {
    $strSql = "SELECT srvy_id 
  FROM self.self_surveys y
  WHERE (now() > to_timestamp(srvy_end_date, 'YYYY-MM-DD HH24:MI:SS') and 
      y.srvy_id = $srvyID)";
    $result = executeSQLNoParams($strSql);

    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function get_SrvyDet($srvyID) {
    $strSql = "SELECT srvy_id, srvy_name, srvy_desc, 
        srvy_instrctns, srvy_start_date, srvy_end_date, 
       eligible_prsn_set_id, survey_type 
  FROM self.self_surveys y
  WHERE (y.srvy_id = $srvyID

            )";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_SrvyNm($srvyID) {
    $strSql = "SELECT srvy_name 
  FROM self.self_surveys y
  WHERE (y.srvy_id = $srvyID)";
    $result = executeSQLNoParams($strSql);


    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_SrvyQstnsTtl($pkeyID) {
    $strSql = "SELECT count(1) FROM self.self_srvy_qustns 
        WHERE srvy_id = " . $pkeyID;
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_SrvyNxtQstn($pkeyID, $offset) {
    global $prsnid;

    $strSql = "SELECT a.qstn_id, a.qstn_order, a.qstn_dsply_condtn_sql,
        b.qstn_desc, b.qstn_ansr_type, b.qstn_img_loc, b.allwd_num_slctd_ans, 
        b.category_clsfctn, b.question_hint  
        FROM self.self_srvy_qustns a, self.self_question_bank b
        WHERE a.qstn_id = b.qstn_id and a.srvy_id = " . $pkeyID .
            " and self.does_qstn_cndtn_exst(a.srvy_qstn_id, $prsnid)>=1 "
            . "ORDER BY a.qstn_order, a.qstn_id LIMIT 1 OFFSET $offset

            ";

    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_QstnCtgry($questionID) {
    $strSql = "SELECT b.category_clsfctn   
        FROM self.self_question_bank b
        WHERE b.qstn_id = " . $questionID;
    $result = executeSQLNoParams($strSql);

    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_QstnCtgryTtl($questionCtgry, $srvyID) {
    $strSql = "SELECT count(1)   
        FROM self.self_question_bank b, self.self_srvy_qustns c 
        WHERE b.qstn_id = c.qstn_id and b.category_clsfctn = 
        '" . loc_db_escape_string($questionCtgry) . "' and c.srvy_id =" . $srvyID;
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_QstnAnsTyp($questionID) {
    $strSql = "SELECT b.qstn_ansr_type   
        FROM self.self_question_bank b
        WHERE b.qstn_id = " . $questionID;
    $result = executeSQLNoParams($strSql);


    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_QstnHint($questionID) {
    $strSql = "SELECT b.question_hint   
        FROM self.self_question_bank b
        WHERE b.qstn_id = " . $questionID;
    $result = executeSQLNoParams($strSql);


    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_AnsHint($ansID) {
    $strSql = "SELECT b.answer_hint   
        FROM self.self_question_possible_answers b
        WHERE b.psbl_ansr_id = " . $ansID;
    $result = executeSQLNoParams($strSql);


    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_SrvyQstnAns($offset, $limit_size, $pkeyID, $srvyID) {
    $strSql = "SELECT b.srvy_qstn_ans_id, b.srvy_id, a.qstn_id, a.psbl_ansr_id, a.psbl_ansr_desc, b.ans_order, b.correct_ansr, 
        a.answer_img_loc, a.answer_hint_link_txt, a.answer_hint, b.ans_dsply_condtn_sql, a.is_enabled  
        FROM self.self_question_possible_answers a, self.self_srvy_qustns_ans b  
        WHERE a.qstn_id = " . $pkeyID .
            " and a.qstn_id = b.qstn_id and a.psbl_ansr_id = b.pssbl_ans_id and b.srvy_id= " . $srvyID .
            " ORDER BY a.psbl_ansr_order_no, a.psbl_ansr_id LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SrvyQstnAnsTtl($pkeyID, $srvyID) {
    $strSql = "SELECT count(1)   
        FROM self.self_question_possible_answers a, 
        self.self_srvy_qustns_ans b  
        WHERE a.qstn_id = " . $pkeyID .
            " and a.qstn_id = b.qstn_id and a.psbl_ansr_id = b.pssbl_ans_id and b.srvy_id= " . $srvyID . "";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_QstnPssblAnswers($pkeyID, $srvyID) {
    $strSql = "SELECT a.psbl_ansr_id, a.psbl_ansr_desc, b.ans_order, b.correct_ansr, 
        a.answer_img_loc, a.answer_hint_link_txt, a.answer_hint, b.ans_dsply_condtn_sql  
        FROM self.self_question_possible_answers a, self.self_srvy_qustns_ans b  
        WHERE a.qstn_id = " . $pkeyID .
            " and a.qstn_id = b.qstn_id and a.psbl_ansr_id = b.pssbl_ans_id and b.srvy_id= " . $srvyID .
            " ORDER BY a.psbl_ansr_order_no, a.psbl_ansr_id";

    $result = executeSQLNoParams($strSql);

    return $result;
}

function getPrsnChosenAnswerID($qstnID, $prsnID, $srvyID, $answerID) {
    $strSql = "SELECT a.prsn_ansr_id 
        FROM self.self_person_question_answers a 
        WHERE a.qstn_id = " . $qstnID .
            " and a.prsn_id = $prsnID "
            . "and a.psbl_ansr_id = $answerID "
            . "and a.srvy_id = $srvyID";
    $result = executeSQLNoParams($strSql);


    while ($row = loc_db_fetch_array($result)) {
        return $row [0]

        ;
    } return -1;
}

function getPrsnChosenAnswer($qstnID, $prsnID, $srvyID, $answerID) {
    $strSql = "SELECT a.ansr_desc 
        FROM self.self_person_question_answers a 
        WHERE a.qstn_id = " . $qstnID .
            " and a.prsn_id = $prsnID "
            . "and a.psbl_ansr_id = $answerID "
            . "and a.srvy_id = $srvyID";
    $result = executeSQLNoParams($strSql);


    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPrsnsAnswerIDSlctd($qstnID, $prsnID, $srvyID) {
    $strSql = "SELECT a.prsn_ansr_id 
        FROM self.self_person_question_answers a 
        WHERE a.qstn_id = " . $qstnID .
            " and a.prsn_id = $prsnID "
            . "and a.srvy_id = $srvyID";
    $result = executeSQLNoParams($strSql);


    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPrsnsUnSbmttdAnswerTtl($prsnID, $srvyID) {
    $strSql = "SELECT count(1) 
        FROM self.self_person_question_answers a 
        WHERE a.prsn_id = $prsnID "
            . "and a.srvy_id = $srvyID"
            . " and is_submitted != '1'";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function getPrsnsAnswersTtl($prsnID, $srvyID) {
    $strSql = "SELECT count(1) 
        FROM self.self_person_question_answers a 
        WHERE a.prsn_id = $prsnID "
            . "and a.srvy_id = $srvyID";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_SurveyResults($pkeyID) {
    $strSql = "SELECT a.qstn_id, a.qstn_order,
        b.qstn_desc, b.qstn_img_loc, c.psbl_ansr_id,
       d.ans_order, 
        c.psbl_ansr_desc, c.answer_img_loc, 
        count(y.prsn_ansr_id),
        round((round(count(y.prsn_ansr_id),2)/round((COALESCE(NULLIF((Select count(1) from 
        self.self_person_question_answers z where z.qstn_id = a.qstn_id and z.srvy_id = a.srvy_id and z.is_submitted='1'),0),1)),2))*100.00,2),
        a.srvy_id
        FROM self.self_srvy_qustns a 
        LEFT OUTER JOIN self.self_question_bank b ON (a.qstn_id = b.qstn_id)
        LEFT OUTER JOIN self.self_srvy_qustns_ans d ON (d.qstn_id = a.qstn_id and a.srvy_id = d.srvy_id)
        LEFT OUTER JOIN self.self_question_possible_answers c ON (c.qstn_id = b.qstn_id and d.pssbl_ans_id = c.psbl_ansr_id) 
        LEFT OUTER JOIN self.self_person_question_answers y ON (y.qstn_id = a.qstn_id and y.srvy_id = a.srvy_id 
        and y.psbl_ansr_id = c.psbl_ansr_id and y.is_submitted='1') 
        WHERE a.srvy_id = " . $pkeyID .
            " GROUP BY 2,1,3,4,6,5,7,8,11" .
            " ORDER BY a.qstn_order, a.qstn_id, d.ans_order, c.psbl_ansr_id";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SurveyRslts($pkeyID, $prsnID) {
    $strSql = "SELECT a.qstn_id, a.qstn_order,
        b.qstn_desc, b.qstn_img_loc, c.psbl_ansr_id,
       d.ans_order, 
        c.psbl_ansr_desc, c.answer_img_loc, 
        count(y.prsn_ansr_id),
        round((round(count(y.prsn_ansr_id),2)/round((COALESCE(NULLIF((Select count(1) from 
        self.self_person_question_answers z where z.qstn_id = a.qstn_id and z.srvy_id = a.srvy_id),0),1)),2))*100.00,2),
        a.srvy_id
        FROM self.self_srvy_qustns a 
        LEFT OUTER JOIN self.self_question_bank b ON (a.qstn_id = b.qstn_id)
        LEFT OUTER JOIN self.self_srvy_qustns_ans d ON (d.qstn_id = a.qstn_id and a.srvy_id = d.srvy_id)
        LEFT OUTER JOIN self.self_question_possible_answers c ON (c.qstn_id = b.qstn_id and d.pssbl_ans_id = c.psbl_ansr_id) 
        LEFT OUTER JOIN self.self_person_question_answers y ON (y.qstn_id = a.qstn_id and y.srvy_id = a.srvy_id 
        and y.psbl_ansr_id = c.psbl_ansr_id) 
        WHERE a.srvy_id = " . $pkeyID .
            " and y.prsn_id = $prsnID GROUP BY 2,1,3,4,6,5,7,8,11" .
            " ORDER BY a.qstn_order, a.qstn_id, d.ans_order, c.psbl_ansr_id";
    $result = executeSQLNoParams($strSql);
    return $result;
    // and y.is_submitted='1'
    // and z.is_submitted='1'
}

?>
