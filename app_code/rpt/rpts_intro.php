<?php

$menuItems = array("Run Reports / Processes", "Run Alerts");
$menuImages = array("rho_arrow1.png", "alert.png");

$mdlNm = "Reports And Processes";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Reports And Processes",
    /* 1 */ "View Report Definitions", "View Report Runs", "View SQL", "View Record History",
    /* 5 */ "Add Report/Process", "Edit Report/Process", "Delete Report/Process",
    /* 8 */ "Run Reports/Process", "Delete Report/Process Runs", "View Runs from Others",
    /* 11 */ "Delete Run Output File", "Add Alert", "Edit Alert", "Delete Alert");
$canview = test_prmssns($dfltPrvldgs[0], $ModuleName) || test_prmssns("View Self-Service", "Self Service");
$caneditRpts = test_prmssns($dfltPrvldgs[6], $ModuleName);
$canaddRpts = test_prmssns($dfltPrvldgs[5], $ModuleName);
$candelRpts = test_prmssns($dfltPrvldgs[7], $ModuleName);
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
            echo deleteReportRun($pKeyID);
        }
    } else if ($qstr == "UPDATE") {
        
    } else if ($pgNo == 0) {
        $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">Reports Menu</span>
					</li>
                                       </ul>
                                     </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
      <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is where all reports and background processes are created and run . The module has the ff areas:</span>
                    </div>
      <p>";
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if (($i == 0 || $i == 1) && test_prmssns($dfltPrvldgs[2], $mdlNm) == FALSE && test_prmssns("View Self-Service", "Self Service") == FALSE) {
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
        //Report Runner   
        require 'rpts_rnnr.php';
    } else if ($pgNo == 2) {
        require "rpts_alrts.php";
    } else {
        restricted();
    }
} else {
    restricted();
}

function generateReportRun($rptID, $slctdParams, $alrtID) {
    global $usrID;
    global $ftp_base_db_fldr;
    global $host;
    global $port;
    global $db_usr;
    global $db_pwd;
    global $database;

    $rptRunID = -1;
    $rptRnnrNm = "";
    $rnnrPrcsFile = "";
    $slctdParamsRows = explode("|", $slctdParams);
    $paramIDs = "";
    $paramVals = "";
    $outputUsd = "";
    $orntn = "";

    for ($i = 0; $i < count($slctdParamsRows); $i++) {
        $slctdParamsCols = explode("~", $slctdParamsRows[$i]);
        $paramIDs = $paramIDs . cleanInputData($slctdParamsCols[0]) . "|";
        $paramVals = $paramVals . cleanInputData($slctdParamsCols[1]) . "|";
        if (cleanInputData($slctdParamsCols[0]) == "-190") {
            $outputUsd = cleanInputData($slctdParamsCols[1]);
        } else if (cleanInputData($slctdParamsCols[0]) == "-200") {
            $orntn = cleanInputData($slctdParamsCols[1]);
        }
    }

    $paramIDs = substr($paramIDs, 0, -1);//trim($paramIDs, "| ");
    $paramVals = substr($paramVals, 0, -1);//trim($paramVals, "| ");
    if ($paramIDs != "" && $paramVals != "" && $outputUsd != "") {
        $datestr = getDB_Date_time();
        createRptRn($usrID, $datestr, $rptID, "", "", "", "", $alrtID);
        $rptRunID = getRptRnID($rptID, $usrID, $datestr);
        $msg_id = getLogMsgID("rpt.rpt_run_msgs", "Process Run", $rptRunID);
        if ($msg_id <= 0) {
            createLogMsg($datestr .
                    " .... Report/Process Run is about to Start...(Being run by " .
                    getUserName($usrID) . ")", "rpt.rpt_run_msgs", "Process Run", $rptRunID, $datestr);
            $msg_id = getLogMsgID("rpt.rpt_run_msgs", "Process Run", $rptRunID);
        }
        updateLogMsg($msg_id, "\r\n\r\n" . $paramIDs . "\r\n" . $paramVals .
                "\r\n\r\nOUTPUT FORMAT: " . $outputUsd . "\r\nORIENTATION: " . $orntn, "rpt.rpt_run_msgs", $datestr);
        updateRptRnParams($rptRunID, $paramIDs, $paramVals, $outputUsd, $orntn);

        //Launch appropriate process runner
        $rptRnnrNm = getGnrlRecNm("rpt.rpt_reports", "report_id", "process_runner", $rptID);
        $rnnrPrcsFile = $ftp_base_db_fldr . "/bin/REMSProcessRunner.jar";
        updatePrcsRnnrCmd($rptRnnrNm, "0");
        updateRptRnStopCmd($rptRunID, "0");
        //PHP Command to start jar file
        $strArgs = "\"" . $host . "\" " .
                "\"" . $port . "\" " .
                "\"" . $db_usr . "\" " .
                "\"" . $db_pwd . "\" " .
                "\"" . $database . "\" " .
                "\"" . $rptRnnrNm . "\" " .
                "\"" . $rptRunID . "\" " .
                "\"" . $ftp_base_db_fldr . "/bin" . "\" " .
                "WEB" . " " .
                "\"" . $ftp_base_db_fldr . "\"";
        //$strArgs = implode(" ", $args);
        $cmd = "java -jar " . $rnnrPrcsFile . " " . $strArgs;
        execInBackground($cmd, $msg_id, $rptRunID);
    } else {
        echo "Invalid Parameters";
    }
    return $rptRunID;
}

function reRunReport($rptID, $rptRunID) {
    global $usrID;
    global $ftp_base_db_fldr;
    global $host;
    global $port;
    global $db_usr;
    global $db_pwd;
    global $database;
    $outputUsd = "";
    $orntn = "";
    $rptRnnrNm = getGnrlRecNm("rpt.rpt_reports", "report_id", "process_runner", $rptID);
    $rnnrPrcsFile = $ftp_base_db_fldr . "/bin/REMSProcessRunner.jar";
    $msg_id = getLogMsgID("rpt.rpt_run_msgs", "Process Run", $rptRunID);
    $datestr = getDB_Date_time();
    if ($msg_id <= 0) {
        createLogMsg($datestr .
                " .... Report/Process Run is about to Start...(Being run by " .
                getUserName($usrID) . ")", "rpt.rpt_run_msgs", "Process Run", $rptRunID, $datestr);
        $msg_id = getLogMsgID("rpt.rpt_run_msgs", "Process Run", $rptRunID);
    }
    updateLogMsg($msg_id, "\r\n\r\nRe-run of program about to start...", "rpt.rpt_run_msgs", $datestr);
    updatePrcsRnnrCmd($rptRnnrNm, "0");
    updateRptRnStopCmd($rptRunID, "0");
    updateRptRnActvTme($rptRunID, $datestr);
    //PHP Command to start jar file
    $strArgs = "\"" . $host . "\" " .
            "\"" . $port . "\" " .
            "\"" . $db_usr . "\" " .
            "\"" . $db_pwd . "\" " .
            "\"" . $database . "\" " .
            "\"" . $rptRnnrNm . "\" " .
            "\"" . $rptRunID . "\" " .
            "\"" . $ftp_base_db_fldr . "/bin" . "\" " .
            "WEB" . " " .
            "\"" . $ftp_base_db_fldr . "\"";
    //$strArgs = implode(" ", $args);
    $cmd = "java -jar " . $rnnrPrcsFile . " " . $strArgs;
    execInBackground($cmd, $msg_id, $rptRunID);
    return $rptRunID;
}

function execInBackground($cmd, $msg_id, $rptRunID) {
    global $ftp_base_db_fldr;
    $output = array("");
    $retval = 0;
    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B " . $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null &");
        //echo $cmd;
        //" >> " . $ftp_base_db_fldr . "/Rpts/" . $rptRunID . "_" . $msg_id . ".log"
    }
    return "Success";
    /*
      $domain_bad = "google.com";
      $output = array("");
      $return_var = -1;
      exec("ping -c 1 $domain_bad >> file_list.txt", $output, $return_var); //2>&1  /dev/null &
      var_dump($return_var);
      echo "return_var is: $return_var" . "\n";
      var_dump($output);
      exit();
      // */
}

function deleteReportRun($hdrid) {
    $insSQL = "DELETE FROM rpt.rpt_report_runs WHERE rpt_run_id = " . $hdrid;
    $affctd = execUpdtInsSQL($insSQL);
    $insSQL1 = "DELETE FROM rpt.rpt_run_msgs WHERE process_id = " . $hdrid . " and process_typ='Process Run'";
    $affctd1 = execUpdtInsSQL($insSQL1);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Report Run(s)!";
        $dsply .= "<br/>$affctd1 Report Run Log(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">

    $dsply</p>";
    }
}

function loadRptRqrmnts() {
    global $dfltPrvldgs;
    $DefaultPrvldgs = $dfltPrvldgs;

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";

    $myName = "Reports And Processes";
    $myDesc = "This module helps you to manage all reports in the software!";
    $audit_tbl_name = "rpt.rpt_audit_trail_tbl";

    $smplRoleName = "Reports And Processes Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    createRqrdLOVs();
    echo "<p style=\"font-size:12px;\">Completed Checking & Requirements load for <b>$myName!</b></p>";
}

function createRqrdLOVs() {

    $sysLovs = array("Report Output Formats", "Report Orientations", "Report/Process Runs", "Reports and Processes", "Background Process Runners");
    $sysLovsDesc = array("Report Output Formats", "Report Orientations", "Report/Process Runs", "Reports and Processes", "Background Process Runners");
    $sysLovsDynQrys = array("", "",
        "select distinct trim(to_char(rpt_run_id,'999999999999999999999999999999')) a, (run_status_txt || '-' || run_by || '-' || run_date) b, '' c, report_id d, run_by e, rpt_run_id f from rpt.rpt_report_runs order by rpt_run_id DESC",
        "select distinct trim(to_char(report_id,'999999999999999999999999999999')) a, report_name b, '' c from rpt.rpt_reports order by report_name",
        "select distinct trim(to_char(prcss_rnnr_id,'999999999999999999999999999999')) a, rnnr_name b, '' c from rpt.rpt_prcss_rnnrs where rnnr_name != 'REQUESTS LISTENER PROGRAM' order by rnnr_name");
    $pssblVals = array(
        "0", "None", "None"
        , "0", "MICROSOFT EXCEL", "MICROSOFT EXCEL"
        , "0", "HTML", "HTML"
        , "0", "STANDARD", "STANDARD"
        , "0", "PDF", "PDF"
        , "0", "MICROSOFT WORD", "MICROSOFT WORD"
        , "0", "CHARACTER SEPARATED FILE (CSV)", "DELIMITER SEPARATED FILE (CSV)"
        , "0", "COLUMN CHART", "COLUMN CHART"
        , "0", "PIE CHART", "PIE CHART"
        , "0", "LINE CHART", "LINE CHART"
        , "1", "Portrait", "Portrait"
        , "1", "Landscape", "Landscape");

    createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
    createSysLovsPssblVals($pssblVals, $sysLovs);

    $prgmID = getGnrlRecID2("rpt.rpt_prcss_rnnrs", "rnnr_name", "prcss_rnnr_id", "REQUESTS LISTENER PROGRAM");
    if ($prgmID <= 0) {
        createPrcsRnnr("REQUESTS LISTENER PROGRAM", "This is the main Program responsible for making sure that " .
                "your reports and background processes are run by their respective " .
                "programs when a request is submitted for them to be run.", "2013-01-01 00:00:00", "Not Running", "3-Normal", "\\bin\\ProcessRunner.exe");
    } else {
        updatePrcsRnnrNm($prgmID, "REQUESTS LISTENER PROGRAM", "This is the main Program responsible for making sure that " .
                "your reports and background processes are run by their respective " .
                "programs when a request is submitted for them to be run.", "\\bin\\ProcessRunner.exe");
    }

    $prgmID = getGnrlRecID2("rpt.rpt_prcss_rnnrs", "rnnr_name", "prcss_rnnr_id", "Standard Process Runner");
    if ($prgmID <= 0) {
        createPrcsRnnr("Standard Process Runner", "This is a standard runner that can run almost all kinds of reports and processes in the background.", "2013-01-01 00:00:00", "Not Running", "3-Normal", "\\bin\\ProcessRunner.exe");
    }
}

function createPrcsRnnr($rnnrNm, $rnnrDesc, $lstActvTm, $stats, $rnnPryty, $execFile) {
    global $usrID;

    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO rpt.rpt_prcss_rnnrs(
            rnnr_name, rnnr_desc, rnnr_lst_actv_dtetme, created_by, 
            creation_date, last_update_by, last_update_date, rnnr_status, 
            crnt_rnng_priority, executbl_file_nm) " .
            "VALUES ('" . loc_db_escape_string($rnnrNm) . "', '" . loc_db_escape_string($rnnrDesc) .
            "', '" . loc_db_escape_string($lstActvTm) . "', " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "', '" . loc_db_escape_string($stats) . "', '" . loc_db_escape_string($rnnPryty) .
            "', '" . loc_db_escape_string($execFile) . "')";
    execUpdtInsSQL($insSQL);
}

function updatePrcsRnnr($rnnrID, $rnnrNm, $rnnrDesc, $lstActvTm, $stats, $rnnPryty, $execFile) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE rpt.rpt_prcss_rnnrs SET 
            rnnr_name='" . loc_db_escape_string($rnnrNm) . "', rnnr_desc='" . loc_db_escape_string($rnnrDesc) .
            "', rnnr_lst_actv_dtetme='" . loc_db_escape_string($lstActvTm) .
            "', last_update_by=" . $usrID . ", last_update_date='" . $dateStr .
            "', rnnr_status='" . loc_db_escape_string($stats) .
            "', crnt_rnng_priority='" . loc_db_escape_string($rnnPryty) .
            "', executbl_file_nm='" . loc_db_escape_string($execFile) .
            "' WHERE prcss_rnnr_id = " . $rnnrID;
    execUpdtInsSQL($insSQL);
}

function updatePrcsRnnrNm($rnnrID, $rnnrNm, $rnnrDesc, $execFile) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE rpt.rpt_prcss_rnnrs SET 
            rnnr_name='" . loc_db_escape_string($rnnrNm) .
            "', rnnr_desc='" . loc_db_escape_string($rnnrDesc) .
            "', last_update_by=-1, last_update_date='" . $dateStr .
            "', executbl_file_nm='" . loc_db_escape_string($execFile) .
            "' WHERE prcss_rnnr_id = " . $rnnrID;
    execUpdtInsSQL($insSQL);
}

function isDteTmeWthnIntrvl($in_date, $intrval) {
    //
    $sqlStr = "SELECT age(now(), to_timestamp('$in_date', 'YYYY-MM-DD HH24:MI:SS')) " .
            "<= interval '$intrval'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        if ("$row[0]" == 't') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function doesDteTmeExceedIntrvl($in_date, $intrval) {
    //
    $sqlStr = "SELECT age(now(), to_timestamp('$in_date', 'YYYY-MM-DD HH24:MI:SS')) " .
            "> interval '$intrval'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        if ("$row[0]" == 't') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function findArryIdx($arry1, $srch) {
    for ($i = 0; $i < count($arry1); $i++) {
        if ($arry1[$i] == $srch) {
            return $i;
        }
    }
    return -1;
}

function createRptRn($runBy, $runDate, $rptID, $paramIDs, $paramVals, $outptUsd, $orntUsd, $alrtID) {
    //$datestr = getDB_Date_time();
    $insSQL = "INSERT INTO rpt.rpt_report_runs(
            run_by, run_date, rpt_run_output, run_status_txt, 
            run_status_prct, report_id, rpt_rn_param_ids, rpt_rn_param_vals, 
            output_used, orntn_used, last_actv_date_tme, is_this_from_schdler, alert_id) 
            VALUES ($runBy, '$runDate', '', 'Not Started!', 0, $rptID, 
            '" . loc_db_escape_string($paramIDs) . "', 
            '" . loc_db_escape_string($paramVals) . "', 
            '" . loc_db_escape_string($outptUsd) . "', 
            '" . loc_db_escape_string($orntUsd) . "', '$runDate', '0', " . loc_db_escape_string($alrtID) . ")";
    execUpdtInsSQL($insSQL);
}

function getRptRnID($rptID, $runBy, $runDate) {
    $sqlStr = "select rpt_run_id from rpt.rpt_report_runs where run_by = 
        $runBy and report_id = $rptID and run_date = '$runDate' order by rpt_run_id DESC";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function createLogMsg($logmsg, $logTblNm, $procstyp, $procsID, $dateStr) {
    global $usrID;
    $insSQL = "INSERT INTO " . $logTblNm . "(" .
            "log_messages, process_typ, process_id, created_by, creation_date, " .
            "last_update_by, last_update_date) " .
            "VALUES ('" . loc_db_escape_string($logmsg) .
            "','" . loc_db_escape_string($procstyp) . "'," . $procsID .
            ", " . $usrID . ", '" . $dateStr .
            "', " . $usrID . ", '" . $dateStr .
            "')";
    execUpdtInsSQL($insSQL);
}

function updateLogMsg($msgid, $logmsg, $logTblNm, $dateStr) {
    global $usrID;
    $updtSQL = "UPDATE " . $logTblNm . " " .
            "SET log_messages=log_messages || '" . loc_db_escape_string($logmsg) .
            "', last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "' WHERE msg_id = " . $msgid;
    execUpdtInsSQL($updtSQL);
}

function updateRptRnParams($rptrnid, $paramIDs, $paramVals, $outputUsd, $orntn) {
    $updtSQL = "UPDATE rpt.rpt_report_runs SET " .
            "rpt_rn_param_ids = '" . loc_db_escape_string($paramIDs) .
            "', rpt_rn_param_vals = '" . loc_db_escape_string($paramVals) .
            "', output_used = '" . loc_db_escape_string($outputUsd) .
            "', orntn_used= '" . loc_db_escape_string($orntn) .
            "' WHERE (rpt_run_id = " . $rptrnid . ")";
    execUpdtInsSQL($updtSQL);
}

function updatePrcsRnnrCmd($rnnrNm, $cmdStr) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE rpt.rpt_prcss_rnnrs SET 
            shld_rnnr_stop='" . loc_db_escape_string($cmdStr) .
            "', last_update_by=" . $usrID . ", last_update_date='" . $dateStr .
            "' WHERE rnnr_name = '" . loc_db_escape_string($rnnrNm) . "'";
    execUpdtInsSQL($updtSQL);
}

function updateRptRnActvTme($rptrnid, $actvTme) {
    $updtSQL = "UPDATE rpt.rpt_report_runs SET " .
            "last_actv_date_tme = '" . loc_db_escape_string($actvTme) .
            "' WHERE (rpt_run_id = " . $rptrnid . ")";
    execUpdtInsSQL($updtSQL);
}

function updateRptRnStopCmd($rptrnid, $cmdStr) {
    $updtSQL = "UPDATE rpt.rpt_report_runs SET " .
            "shld_run_stop = '" . loc_db_escape_string($cmdStr) .
            "' WHERE (rpt_run_id = " . $rptrnid . ")";
    execUpdtInsSQL($updtSQL);
}

function get_RptsDet($pkeyID) {
    $strSql = "SELECT distinct a.report_id mt, a.report_name, a.report_desc mt
    FROM rpt.rpt_reports a
    WHERE (a.report_id = $pkeyID)";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RptsTblr($searchWord, $searchIn, $offset, $limit_size) {
    global $caneditRpts;

    $whereCls = "";
    if ($searchIn == "Report Name") {
        $whereCls = "(a.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Report Description") {
        $whereCls = "(a.report_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Owner Module") {
        $whereCls = "(a.owner_module ilike '" . loc_db_escape_string($searchWord) . "')";
    } else {
        $whereCls = "(a.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "";
    if ($caneditRpts == false) {
        $strSql = "SELECT distinct a.report_id mt, a.report_name, a.report_desc mt
    FROM rpt.rpt_reports a,
    rpt.rpt_reports_allwd_roles b
    WHERE ((a.report_id = b.report_id) and (b.user_role_id IN (" . concatCurRoleIDs() . ")) and $whereCls)
    ORDER BY a.report_id DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    } else {
        $strSql = "SELECT distinct a.report_id mt, a.report_name, a.report_desc mt
    FROM rpt.rpt_reports a
    WHERE ($whereCls)
    ORDER BY a.report_id DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    }
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RptsTtl($searchWord, $searchIn) {
    global $caneditRpts;

    $whereCls = "";
    if ($searchIn == "Report Name") {
        $whereCls = "(a.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Report Description") {
        $whereCls = "(a.report_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Owner Module") {
        $whereCls = "(a.owner_module ilike '" . loc_db_escape_string($searchWord) . "')";
    } else {
        $whereCls = "(a.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "";
    if ($caneditRpts == false) {
        $strSql = "SELECT count(1) FROM 
            (SELECT distinct a.report_id mt, a.report_name, a.report_desc mt
    FROM rpt.rpt_reports a,
    rpt.rpt_reports_allwd_roles b
    WHERE ((a.report_id = b.report_id) and (b.user_role_id IN (" . concatCurRoleIDs() . ")) and $whereCls)) tbl1";
    } else {
        $strSql = "SELECT count(1) FROM 
            (SELECT distinct a.report_id mt, a.report_name, a.report_desc mt
    FROM rpt.rpt_reports a
    WHERE ($whereCls)) tbl1";
    }
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_ASchdlRuns($searchWord, $searchIn, $offset, $limit_size) {
    global $dfltPrvldgs;
    global $usrID;
    global $mdlNm;

    $whereCls = "";
    $extrWhrcls = "";
    if (test_prmssns($dfltPrvldgs[10], $mdlNm) == false) {
        $extrWhrcls = " and (a.created_by = $usrID)";
    }
    if ($searchIn == "Report Name") {
        $whereCls = " and (b.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Start Date") {
        $whereCls = " and (to_char(to_timestamp(a.start_dte_tme, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Repeat Interval") {
        $whereCls = " and ('' || a.repeat_every ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Created By") {
        $whereCls = " and (sec.get_usr_name(a.created_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT a.schedule_id, a.report_id mt, b.report_name,
    to_char(to_timestamp(a.start_dte_tme, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') start_date,
    a.repeat_every, a.repeat_uom, sec.get_usr_name(a.created_by) created_by
    FROM rpt.rpt_run_schdules a, rpt.rpt_reports b
    WHERE a.report_id = b.report_id" . $whereCls . $extrWhrcls .
            " ORDER BY a.schedule_id DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    //echo $strSql;
    return $result;
}

function get_ASchdlRunsTtl($searchWord, $searchIn) {
    global $dfltPrvldgs;
    global $usrID;
    global $mdlNm;

    $whereCls = "";
    $extrWhrcls = "";
    if (test_prmssns($dfltPrvldgs[10], $mdlNm) == false) {
        $extrWhrcls = " and (a.created_by = $usrID)";
    }
    if ($searchIn == "Report Name") {
        $whereCls = " and (b.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Start Date") {
        $whereCls = " and (to_char(to_timestamp(a.start_dte_tme, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Repeat Interval") {
        $whereCls = " and ('' || a.repeat_every ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Created By") {
        $whereCls = " and (sec.get_usr_name(a.created_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT count(1) 
    FROM rpt.rpt_run_schdules a, rpt.rpt_reports b
    WHERE a.report_id = b.report_id" . $whereCls . $extrWhrcls;
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_RptRuns($pkID, $searchWord, $searchIn, $offset, $limit_size) {
    global $dfltPrvldgs;
    global $usrID;
    global $mdlNm;

    $whereCls = "";
    if ($searchIn == "Report Run ID") {
        $whereCls = " and (trim(to_char(a.rpt_run_id, '99999999999999999999999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Date") {
        $whereCls = " and (to_char(to_timestamp(a.date_sent, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run By") {
        $whereCls = " and ((select b.user_name from
    sec.sec_users b where b.user_id = a.run_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Status") {
        $whereCls = " and (a.run_status_txt ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $extrWhrcls = "";
    if (test_prmssns($dfltPrvldgs[10], $mdlNm) == false) {
        $extrWhrcls = " and (a.run_by = $usrID)";
    }
    $strSql = "SELECT a.rpt_run_id \"Run ID\", 
        a.run_by mt, 
        (select b.user_name from sec.sec_users b where b.user_id = a.run_by) \"Run By\", 
        to_char(to_timestamp(a.run_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') date_run, 
          a.run_status_txt run_status_text, 
          a.run_status_prct \"Progress (%)\", 
          a.rpt_rn_param_ids mt, 
          a.rpt_rn_param_vals mt, 
          a.output_used, 
          a.orntn_used mt, 
    CASE WHEN a.last_actv_date_tme='' or a.last_actv_date_tme IS NULL THEN '' 
    ELSE to_char(to_timestamp(a.last_actv_date_tme,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') END last_time_active, 
    CASE WHEN is_this_from_schdler='1' THEN 'SCHEDULER' ELSE 'USER' END run_source ,
    a.rpt_run_id \"Open Output File\", 
    b.report_name mt, a.alert_id mt
      FROM rpt.rpt_report_runs a, rpt.rpt_reports b 
        WHERE (a.report_id = b.report_id and (a.report_id = $pkID and a.alert_id<=0)$whereCls" . "$extrWhrcls) 
        ORDER BY a.rpt_run_id DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RptRunsTtl($pkID, $searchWord, $searchIn) {
    global $dfltPrvldgs;
    global $usrID;
    global $mdlNm;

    $whereCls = "";
    if ($searchIn == "Report Run ID") {
        $whereCls = " and (trim(to_char(a.rpt_run_id, '99999999999999999999999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Date") {
        $whereCls = " and (to_char(to_timestamp(a.date_sent, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run By") {
        $whereCls = " and ((select b.user_name from
    sec.sec_users b where b.user_id = a.run_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Status") {
        $whereCls = " and (a.run_status_txt ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $extrWhrcls = "";
    if (test_prmssns($dfltPrvldgs[10], $mdlNm) == false) {
        $extrWhrcls = " and (a.run_by = $usrID)";
    }
    $strSql = "SELECT count(1) 
      FROM rpt.rpt_report_runs a 
        WHERE ((a.report_id = $pkID and a.alert_id<=0)$whereCls" . "$extrWhrcls)";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_AlrtRuns($pkID, $searchWord, $searchIn, $offset, $limit_size) {
    global $dfltPrvldgs;
    global $usrID;
    global $mdlNm;

    $whereCls = "";
    if ($searchIn == "Report Run ID") {
        $whereCls = " and (trim(to_char(a.rpt_run_id, '99999999999999999999999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Date") {
        $whereCls = " and (to_char(to_timestamp(a.date_sent, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run By") {
        $whereCls = " and ((select b.user_name from
    sec.sec_users b where b.user_id = a.run_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Status") {
        $whereCls = " and (a.run_status_txt ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $extrWhrcls = "";
    if (test_prmssns($dfltPrvldgs[10], $mdlNm) == false) {
        $extrWhrcls = " and (a.run_by = $usrID)";
    }
    $strSql = "SELECT a.rpt_run_id \"Run ID\", 
        a.run_by mt, 
        (select b.user_name from sec.sec_users b where b.user_id = a.run_by) \"Run By\", 
        to_char(to_timestamp(a.run_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') date_run, 
          a.run_status_txt run_status_text, 
          a.run_status_prct \"Progress (%)\", 
          a.rpt_rn_param_ids mt, 
          a.rpt_rn_param_vals mt, 
          a.output_used, 
          a.orntn_used mt, 
          CASE WHEN a.last_actv_date_tme='' or a.last_actv_date_tme IS NULL THEN '' ELSE to_char(to_timestamp(a.last_actv_date_tme,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') END last_time_active, 
          CASE WHEN is_this_from_schdler='1' THEN 'SCHEDULER' ELSE 'USER' END run_source,
          a.rpt_run_id \"Open Output File\", 
          b.report_name mt, 
          a.alert_id, 
          a.msg_sent_id
      FROM rpt.rpt_report_runs a, rpt.rpt_reports b 
        WHERE (a.report_id = b.report_id and (a.alert_id = $pkID)$whereCls" . "$extrWhrcls) 
        ORDER BY a.rpt_run_id DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_AlrtRunsTtl($pkID, $searchWord, $searchIn) {
    global $dfltPrvldgs;
    global $usrID;
    global $mdlNm;

    $whereCls = "";
    if ($searchIn == "Report Run ID") {
        $whereCls = " and (trim(to_char(a.rpt_run_id, '99999999999999999999999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Date") {
        $whereCls = " and (to_char(to_timestamp(a.date_sent, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run By") {
        $whereCls = " and ((select b.user_name from
    sec.sec_users b where b.user_id = a.run_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Run Status") {
        $whereCls = " and (a.run_status_txt ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $extrWhrcls = "";
    if (test_prmssns($dfltPrvldgs[10], $mdlNm) == false) {
        $extrWhrcls = " and (a.run_by = $usrID)";
    }
    $strSql = "SELECT count(1) 
      FROM rpt.rpt_report_runs a 
        WHERE ((a.alert_id = $pkID)$whereCls" . "$extrWhrcls)";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_RptAlerts($searchWord, $searchIn, $offset, $limit_size) {
    global $caneditRpts;
    $whereCls = "";

    if ($searchIn == "Alert Name") {
        $whereCls = " and (a.alert_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Report Name") {
        $whereCls = " and (b.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $strSql = "";
    if ($caneditRpts == false) {
        $strSql = "SELECT distinct a.alert_id, a.report_id, b.report_name, a.alert_name 
   FROM alrt.alrt_alerts a , rpt.rpt_reports b,
    rpt.rpt_reports_allwd_roles c
    WHERE a.report_id = b.report_id and b.report_id = c.report_id and (c.user_role_id IN (" . concatCurRoleIDs() . "))" . "$whereCls" .
                " ORDER BY 1 DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    } else {
        $strSql = "SELECT distinct a.alert_id, a.report_id, b.report_name, a.alert_name 
   FROM alrt.alrt_alerts a , rpt.rpt_reports b
    WHERE a.report_id = b.report_id" . "$whereCls" .
                " ORDER BY 1 DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    }

    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RptAlertsDet($pkID) {
    $strSql = "SELECT a.alert_id, a.alert_name, a.report_id, b.report_name, 
       a.alert_desc, a.to_mail_num_list_mnl, a.cc_mail_num_list_mnl, 
       a.alert_msg_body_mnl, a.alert_type, a.is_enabled, a.msg_sbjct_mnl, a.bcc_mail_num_list_mnl, 
       a.paramtr_sets_gnrtn_sql, a.shd_rpt_be_run, 
       to_char(to_timestamp(a.start_dte_tme,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') start_dte_tme, 
       a.repeat_uom, a.repeat_every, a.run_at_spcfd_hour, a.attchment_urls, a.end_hour 
      FROM alrt.alrt_alerts a, rpt.rpt_reports b 
      WHERE a.report_id = b.report_id and a.alert_id = $pkID";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_OneAlertsMsgDet($pkID) {
    $strSql = "SELECT a.msg_sent_id mt, a.to_list \"To\", a.cc_list \"Cc\", a.bcc_list \"Bcc\", 
        a.msg_type \"Message Type\", a.msg_sbjct \"Subject\", a.msg_body \"Message\", 
        a.date_sent, a.sending_status \"Status\", a.err_msg \"Error Message\", 
       a.attch_urls \"Atachments\", a.report_id mt, a.person_id mt, a.cstmr_spplr_id mt, 
       a.alert_id mt
  FROM alrt.alrt_msgs_sent a
      WHERE a.msg_sent_id = $pkID";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RptAlertsTtl($searchWord, $searchIn) {
    global $caneditRpts;
    $whereCls = "";

    if ($searchIn == "Alert Name") {
        $whereCls = " and (a.alert_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Report Name") {
        $whereCls = " and (b.report_name ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $strSql = "";
    if ($caneditRpts == false) {
        $strSql = "SELECT count(distinct a.alert_id)   
   FROM alrt.alrt_alerts a , rpt.rpt_reports b,
    rpt.rpt_reports_allwd_roles c
    WHERE a.report_id = b.report_id and b.report_id = c.report_id and (c.user_role_id IN (" . concatCurRoleIDs() . "))" . "$whereCls";
    } else {
        $strSql = "SELECT count(distinct a.alert_id)   
   FROM alrt.alrt_alerts a , rpt.rpt_reports b
    WHERE a.report_id = b.report_id" . "$whereCls";
    }
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_OneSchdlRun($pkID) {
    $strSql = "SELECT a.schedule_id, a.report_id mt, b.report_name,
    to_char(to_timestamp(a.start_dte_tme, 'YYYY-MM-DD HH24:MI:SS'), 'DD-Mon-YYYY HH24:MI:SS') start_date,
    a.repeat_every, a.repeat_uom, a.run_at_spcfd_hour 
    FROM rpt.rpt_run_schdules a, rpt.rpt_reports b
    WHERE a.report_id = b.report_id and a.schedule_id = $pkID ORDER BY a.schedule_id DESC";
    $result = executeSQLNoParams($strSql);
    //echo $strSql;
    return $result;
}

function get_OneRptRun($pkID) {

    $strSql = "SELECT a.rpt_run_id \"Run ID\", a.run_by mt, (select b.user_name from 
          sec.sec_users b where b.user_id = a.run_by) \"Run By\", 
        to_char(to_timestamp(a.run_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') date_run, 
          a.run_status_txt run_status_text, a.run_status_prct \"Progress (%)\", a.rpt_rn_param_ids mt, a.rpt_rn_param_vals mt, 
          a.output_used , a.orntn_used orientation_used, 
    CASE WHEN a.last_actv_date_tme='' or a.last_actv_date_tme IS NULL THEN '' 
    ELSE to_char(to_timestamp(a.last_actv_date_tme,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') END last_time_active, 
    CASE WHEN is_this_from_schdler='1' THEN 'SCHEDULER' ELSE 'USER' END run_source ,
    a.rpt_run_id \"Open Output File\", a.report_id mt, a.last_actv_date_tme 
      FROM rpt.rpt_report_runs a 
        WHERE ((a.rpt_run_id = $pkID ))";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_AllParams($rptID) {
    $strSql = "SELECT parameter_id , parameter_name, paramtr_rprstn_nm_in_query mt, default_value, 
 is_required mt, lov_name_id, lov_name, param_data_type, date_format FROM rpt.rpt_report_parameters WHERE report_id = $rptID ORDER BY parameter_name";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_AllSchdldParams($schdlID) {
    $strSql = "SELECT a.schdl_param_id mt, a.parameter_id mt, b.parameter_name, a.parameter_value, lov_name_id
      FROM rpt.rpt_run_schdule_params a, rpt.rpt_report_parameters b  
      WHERE a.parameter_id = b.parameter_id and a.schedule_id=$schdlID ORDER BY a.parameter_id";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SchdldParamVal($schdlID, $paramID) {
    $strSql = "SELECT a.parameter_value
      FROM rpt.rpt_run_schdule_params a, rpt.rpt_report_parameters b  
      WHERE a.parameter_id = $paramID and a.schedule_id=$schdlID";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_SchdldAlrtParamVal($alrtID, $paramID) {
    $strSql = "SELECT a.parameter_value
      FROM rpt.rpt_run_schdule_params a, rpt.rpt_report_parameters b  
      WHERE a.parameter_id = $paramID and a.alert_id=$alrtID";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_Rpt_ColsToAct($rptID) {
    $strSql = "SELECT report_name, cols_to_group, cols_to_count, cols_to_sum, cols_to_average, cols_to_no_frmt,
        output_type, portrait_lndscp
      FROM rpt.rpt_reports WHERE report_id = $rptID";
    $result = executeSQLNoParams($strSql);
    return $result;
}

?>
