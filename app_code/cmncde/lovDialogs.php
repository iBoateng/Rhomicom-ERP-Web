<?php

$qryStr = isset($_POST['q']) ? cleanInputData($_POST['q']) : '';
$usrID = $_SESSION['USRID'];
$srchFor = isset($_POST['searchfor']) ? cleanInputData($_POST['searchfor']) : '';
$srchIn = isset($_POST['searchin']) ? cleanInputData($_POST['searchin']) : 'Both';
$lmtSze = isset($_POST['limit']) ? cleanInputData($_POST['limit']) : 30;
$navPos = isset($_POST['nv']) ? cleanInputData($_POST['nv']) : '';
$curIdx = isset($_POST['idx']) ? cleanInputData($_POST['idx']) : 0;
$chkOrRadio = isset($_POST['chkOrRadio']) ? cleanInputData($_POST['chkOrRadio']) : '';
$mustSelSth = isset($_POST['mustSelSth']) ? cleanInputData($_POST['mustSelSth']) : '';
$lov_res_action_nm = isset($_POST['lov_res_action_nm']) ? cleanInputData($_POST['lov_res_action_nm']) : '';
$selvals = isset($_POST['selvals']) ? cleanInputData($_POST['selvals']) : '-1';
$srcTyp = isset($_POST['srcTyp']) ? cleanInputData($_POST['srcTyp']) : '';
$showValOrDesc = isset($_POST['showValOrDesc']) ? cleanInputData($_POST['showValOrDesc']) : '';
$lovNm = isset($_POST['lovNm']) ? cleanInputData($_POST['lovNm']) : '';
$criteriaID = isset($_POST['criteriaID']) ? cleanInputData($_POST['criteriaID']) : '';
$criteriaID2 = isset($_POST['criteriaID2']) ? cleanInputData($_POST['criteriaID2']) : '';
$criteriaID3 = isset($_POST['criteriaID3']) ? cleanInputData($_POST['criteriaID3']) : '';
$valueElmntID = isset($_POST['valElmntID']) ? cleanInputData($_POST['valElmntID']) : '';
$descElemntID = isset($_POST['descElmntID']) ? cleanInputData($_POST['descElmntID']) : '';
$addtnlWhere = isset($_POST['addtnlWhere']) ? cleanInputData($_POST['addtnlWhere']) : '';
$lovID = getLovID($lovNm);
$sqlMsg = "";
$isDynmc = "";
$selvals = "|" . $selvals;
//var_dump($_POST);
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = "%" . str_replace(" ", "%", $srchFor) . "%";
}

function lovsForm($error) {
    global $srchFor;
    global $srchIn;
    global $lmtSze;
    global $navPos;
    global $curIdx;
    global $chkOrRadio;
    global $mustSelSth;
    global $lov_res_action_nm;
    global $selvals;
    global $srcTyp;
    global $showValOrDesc;
    global $lovNm;
    global $criteriaID;
    global $criteriaID2;
    global $criteriaID3;
    global $valueElmntID;
    global $descElemntID;
    global $lovID;
    global $sqlMsg;
    global $isDynmc;
    global $selvals;

    $result = getLovValues($srchFor, $srchIn, $curIdx, $lmtSze, $sqlMsg, $lovID, $isDynmc, $criteriaID, $criteriaID2, $criteriaID3);
    $recCnt = loc_db_num_rows($result);
    $startIdx = 0;
    $endIdx = 0;
    if ($recCnt > 0) {
        $startIdx = ($curIdx * $lmtSze) + 1;
        $endIdx = $startIdx + $recCnt - 1;
    }
    $output = "<!-- Form Code Start -->
<div id='rho_form'>
<form id='lovForm' action='' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>$lovNm</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>";
    $srchInArry = array("Value", "Description");
    $output.=getLovNavBar($srchInArry, $srchIn, $recCnt, $navPos, $lmtSze, $startIdx, $endIdx, $srchFor, "getLovsPage", "nav_lovs", $lovNm, "mydialog", $criteriaID, $criteriaID2, $criteriaID3, $chkOrRadio, $mustSelSth, $lov_res_action_nm, $selvals, $valueElmntID, $descElemntID, $srcTyp);
//onclick=\"getLovsPage('nav_lovs', 'first', 'Organisations', 'mydialog','-1','','');\"
    $output .= createLovRecsTbl($result, $startIdx, $chkOrRadio, 0, $selvals);
    $output.="<div class=\"divButtons1\" style=\"margin-top:5px;\">
    <a name='lov_submit' id='lov_submit' onclick=\"loopChecksRadios('lovForm', '$valueElmntID', '$descElemntID', '$srcTyp', '$showValOrDesc');\">
    <img class=\"divButtons1imgdsply\" src=\"cmn_images/FloppyDisk.png\" alt=\"SAVE\" title=\"SAVE\"><span>Submit&nbsp;&nbsp;</span></a>   
</div>
</fieldset>
</form>";
    echo $output;
}

$error = "";

if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0) {
        if ($qryStr === "load_selection") {
            
        } else {
            //lovsForm($error);
            $total = getTtlLovValues($srchFor, $srchIn, $sqlMsg, $lovID, $isDynmc, $criteriaID, $criteriaID2, $criteriaID3, $addtnlWhere);
            //echo $total;
            $pageNo = isset($_POST['page']) ? cleanInputData($_POST['page']) : 1;
            $lmtSze = isset($_POST['limit']) ? cleanInputData($_POST['limit']) : 1;
            $start = isset($_POST['start']) ? cleanInputData($_POST['start']) : 0;
            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $sqlMsg = "";
            $result = getLovValues($srchFor, $srchIn, $curIdx, $lmtSze
                    , $sqlMsg, $lovID, $isDynmc, $criteriaID, $criteriaID2, $criteriaID3, $addtnlWhere);
            //echo "Start:".$total ."/". $sqlMsg;
            $pssblValues = array();
            while ($row = loc_db_fetch_array($result)) {
                $chckd = FALSE;
                $pssblVal = array(
                    'checked' => var_export($chckd, TRUE),
                    'pssblValID' => $row[2],
                    'pssblValue' => $row[0],
                    'pssblValueDesc' => $row[1],
                    'lovID' => $lovID);
                $pssblValues[] = $pssblVal;
            }

            echo json_encode(array('success' => true, 'total' => $total,
                'rows' => $pssblValues));
        }
    } else {
        //echo "Please Login First!"; 
        //restricted();
    }
}
?>
