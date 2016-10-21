<?php

function cleanInputData($data) {
    return $data;
}

function cleanOutputData($data) {
    return trim(htmlentities(strip_tags($data)));
}

function is_multi($a) {
    foreach ($a as $v) {
        if (is_array($v)) {
            return true;
        }
    }
    return false;
}

function executeSQLNoParams($selSQL) {
    $conn = getConn();
    $result = loc_db_query($conn, $selSQL);
//echo "<br/>SQL--".$selSQL;
    if (!$result) {
        echo "An error occurred. <br/> " . loc_db_result_error($result);
    }
    loc_db_close($conn);
    return $result;
//$conn
}

function execUpdtInsSQL($inSQL, $extrMsg = '', $src = 0) {
    $conn = getConn();
    $result = loc_db_query($conn, $inSQL);
//echo "<br/>SQL--".$selSQL;
    if (!$result) {
        echo "An error occurred. <br/> " . loc_db_result_error($result);
    }
    loc_db_close($conn);
    if ($src == 0) {
        if (trim(strtoupper(substr($inSQL, 0, 11))) == 'DELETE FROM') {
            storeAdtTrailInfo($inSQL, 1, $extrMsg);
        } else if (trim(strtoupper(substr($inSQL, 0, 6))) == 'UPDATE') {
            storeAdtTrailInfo($inSQL, 0, $extrMsg);
        }
    }
    return loc_db_affected_rows($result);
//$conn
}

function storeAdtTrailInfo($infoStmnt, $actntype, $extrMsg) {
    global $ModuleName;
    $ModuleAdtTbl = getGnrlRecNm('sec.sec_modules', 'module_id', 'audit_trail_tbl_name', getModuleID($ModuleName));
    global $usrID;
    global $lgn_num;
    $action_types = array("UPDATE STATEMENTS", "DELETE STATEMENTS");
    if ($ModuleAdtTbl == null || $ModuleAdtTbl == "") {
        return;
    }
    if (doesCrPlcTrckThisActn($action_types[$actntype]) == false) {
        return;
    }
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO " . $ModuleAdtTbl . " (" .
            "user_id, action_type, action_details, action_time, login_number) " .
            "VALUES (" . $usrID . ", '" . $action_types[$actntype] .
            "', '" . loc_db_escape_string($extrMsg) . "" .
            loc_db_escape_string($infoStmnt) . "', '" . $dateStr . "', " . $lgn_num . ")";
    execUpdtInsSQL($sqlStr, '', 1);
}

function getOrgFuncCurID($orgid) {

    $strSql = "select oprtnl_crncy_id from org.org_details where org_id = $orgid ";
    $result = executeSQLNoParams($strSql);

    if (loc_db_num_rows($result) > 0) {
        $row = loc_db_fetch_array($result);
        return $row[0];
    }
    return -1;
}

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";
    $ub = "";
//First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

// Next get the name of the useragent yes seperately and for good reason

    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

// finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
// we have no matching number just continue
    }

// see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
//we will have two since we are not using 'other' argument yet
//see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

// check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

function concatCurRoleIDs() {
    $nwStr = str_replace(";", ",", $_SESSION['ROLE_SET_IDS']);
    return $nwStr;
}

function doesCrPlcTrckThisActn($actionTyp) {
    global $ModuleName;
// Checks whether the current policy tracks a particular action in the current module
    $sqlStr = "SELECT policy_id FROM " .
            "sec.sec_audit_trail_tbls_to_enbl WHERE ((policy_id = " . getCurPlcyID() .
            ") AND (module_id = " . getModuleID($ModuleName) .
            ") AND (action_typs_to_track ilike '%" .
            $actionTyp . "%') AND (enable_tracking = TRUE))";
    $result = executeSQLNoParams($sqlStr);
    while (loc_db_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function deleteGnrlRecs($rowID, $tblnm, $pk_nm, $extrInf = '') {
    $delSQL = "DELETE FROM " . $tblnm . " WHERE " . $pk_nm . " = " . $rowID;
    execUpdtInsSQL($delSQL, $extrInf);
}

function getLogMsgID($logTblNm, $procstyp, $procsID) {
    $sqlStr = "select msg_id from $logTblNm where process_typ = '" . loc_db_escape_string($procstyp) .
            "' and process_id = $procsID";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getCurPlcyID() {
    $sqlStr = "select policy_id from sec.sec_security_policies where is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getOrgName($orgID) {
    $strSQL = "SELECT org_name FROM org.org_details WHERE org_id = $orgID";
    $result = executeSQLNoParams($strSQL);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
//$conn
}

function getOrgSlogan($orgID) {
    $strSQL = "SELECT org_slogan FROM org.org_details WHERE org_id = $orgID";
    $result = executeSQLNoParams($strSQL);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
//$conn
}

function getDfltOrgID() {
    $strSQL = "SELECT org_id FROM org.org_details 
        ORDER BY org_id LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSQL);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getAppID($appnm, $srcmodule) {
    $sqlStr = "select app_id from wkf.wkf_apps where 
        lower(app_name)=lower('" . loc_db_escape_string($appnm) . "') and 
        lower(source_module)=lower('" . loc_db_escape_string($srcmodule) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function get_MyActiveInbxTtls() {
//global $usrID;
    global $user_Name;

    $user_Name = $_SESSION['UNAME'];

    $prsnID = getUserPrsnID($user_Name);
    $wherecls = "";

    $wherecls .= " AND (a.is_action_done = '0')";
    $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    $sqlStr = "SELECT count(1) 
  FROM wkf.wkf_actual_msgs_routng a, wkf.wkf_actual_msgs_hdr b, wkf.wkf_apps c
WHERE ((c.app_id=b.app_id) AND (a.msg_id=b.msg_id)" . $extrWhr . "$wherecls)";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function createWkfApp($applNm, $srcMdl, $appdesc) {
    global $usrID;

    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO wkf.wkf_apps(
            app_name, source_module, app_desc, created_by, creation_date) " .
            "VALUES ('" . loc_db_escape_string($applNm) . "', '" . loc_db_escape_string($srcMdl) .
            "', '" . loc_db_escape_string($appdesc) . "', " . $usrID . ", '" . $dateStr . "')";
    execUpdtInsSQL($insSQL);
}

function updateWkfApp($appID, $applNm, $srcMdl, $appdesc) {
//    global $usrID;
//    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE wkf.wkf_apps SET 
            app_name='" . loc_db_escape_string($applNm) . "', source_module='" . loc_db_escape_string($srcMdl) .
            "', app_desc='" . loc_db_escape_string($appdesc) .
            "' WHERE app_id = " . $appID;
    execUpdtInsSQL($insSQL);
}

function deleteWkfApp($appID) {
    $affctd1 = 0;
    $affctd2 = 0;
    $affctd3 = 0;

    $insSQL = "DELETE FROM wkf.wkf_apps_n_hrchies WHERE app_id = " . $appID;
    $affctd1 +=execUpdtInsSQL($insSQL);
    $insSQL = "DELETE FROM wkf.wkf_apps_actions WHERE app_id = " . $appID;
    $affctd2 +=execUpdtInsSQL($insSQL);
    $insSQL = "DELETE FROM wkf.wkf_apps WHERE app_id = " . $appID;
    $affctd3 +=execUpdtInsSQL($insSQL);

    if ($affctd3 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 App Hierarchy(ies)!";
        $dsply .= "<br/>$affctd2 App Action(s)!";
        $dsply .= "<br/>$affctd3 App Header(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createWkfAppAction($actionNm, $sqlStmnt, $appID, $exctbl, $webURL, $isdiag, $desc, $isadmnonly = "0") {
    global $usrID;

    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO wkf.wkf_apps_actions(
            action_performed_nm, sql_stmnt, created_by, creation_date, 
            last_update_by, last_update_date, app_id, executable_file_nm, 
            web_url, is_web_dsply_diag, action_desc, is_admin_only) " .
            "VALUES ('" . loc_db_escape_string($actionNm) . "', '" . loc_db_escape_string($sqlStmnt) .
            "', " . $usrID . ", '" . $dateStr . "', " . $usrID . ", '" . $dateStr . "', $appID, 
            '" . loc_db_escape_string($exctbl) . "', '" . loc_db_escape_string($webURL) .
            "', '$isdiag','" . loc_db_escape_string($desc) . "','" . loc_db_escape_string($isadmnonly) . "')";
    execUpdtInsSQL($insSQL);
}

function updateWkfAppAction($actionID, $actionNm, $sqlStmnt, $appID, $exctbl, $webURL, $isdiag, $desc, $isadmnonly = "0") {
    global $usrID; //action_sql_id
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE wkf.wkf_apps_actions SET 
            action_performed_nm='" . loc_db_escape_string($actionNm) . "', 
            sql_stmnt='" . loc_db_escape_string($sqlStmnt) . "',
            last_update_by=" . $usrID . ",
            last_update_date='" . loc_db_escape_string($dateStr) . "',
            app_id=" . $appID . ",
            executable_file_nm='" . loc_db_escape_string($exctbl) . "',
            is_web_dsply_diag='" . loc_db_escape_string($isdiag) . "',
            action_desc='" . loc_db_escape_string($desc) . "',
            is_admin_only='" . loc_db_escape_string($isadmnonly) . "',
            web_url='" . loc_db_escape_string($webURL) .
            "' WHERE action_sql_id = " . $actionID;
    execUpdtInsSQL($insSQL);
}

function deleteWkfAppAction($actionID) {
    $insSQL = "DELETE FROM wkf.wkf_apps_actions WHERE action_sql_id = " . $actionID;
    $affctd1 +=execUpdtInsSQL($insSQL);
    if ($affctd1 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 App Action(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function getWkfMsgID() {
//echo "uname_".$username;
    $sqlStr = "select nextval('wkf.ntf_actual_msgs_hdr_msg_id_seq'::regclass);";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getWkfMsgHdrData($wfkMsgID) {
//echo "uname_".$username;
    $sqlStr = "select msg_id, msg_hdr, msg_body, created_by, creation_date, herchy_id, 
       msg_typ, app_id, msg_status, src_doc_type, src_doc_id, last_update_by, 
       last_update_date, attchments, attchments_desc  
       from wkf.wkf_actual_msgs_hdr where msg_id = " . $wfkMsgID;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getWkfMsgRtngData($wfkRtngID) {
//echo "uname_".$username;
    $sqlStr = "select msg_id, from_prsn_id, to_prsn_id, date_sent, created_by, creation_date, 
       routing_id, msg_status, action_to_perform, is_action_done, who_prfmd_action, 
       date_action_ws_prfmd, status_aftr_action, nxt_action_to_prfm, 
       last_update_by, last_update_date, who_prfms_next_action, action_comments, 
       to_prsns_hrchy_level 
       from wkf.wkf_actual_msgs_routng where routing_id = " . $wfkRtngID;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getNextApprvrInMnlHrchy($hrchyID, $curHrchyLvl) {
    $sqlStr = "SELECT person_id from wkf.wkf_manl_hierarchy_details " .
            "where ((is_enabled = '1' and hrchy_level > " . $curHrchyLvl . ") AND (hierarchy_id = " . $hrchyID . ")) "
            . "ORDER BY hrchy_level ASC LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function add_date($givendate, $day = 0, $mth = 0, $yr = 0) {
    $cd = strtotime($givendate);
    $newdate = date('Y-m-d h:i:s', mktime(date('h', $cd), date('i', $cd), date('s', $cd), date('m', $cd) + $mth, date('d', $cd) + $day, date('Y', $cd) + $yr));
    return $newdate;
}

function createWelcomeMsg($username) {
    global $app_name;
    $msg_id = getWkfMsgID();
    $appID = getAppID('Login', 'System Administration');

    $prsnid = getUserPrsnID($username);
    $fullNm = getPrsnFullNm($prsnid);
    $userID = getUserID($username);
    $sccflLg = getLastSccflLgnMsg($userID);
    $fldLg = getLastFailedLgn($userID);
    $msghdr = "Welcome $fullNm";
    $msgbody = "Welcome $fullNm to $app_name. 
        <br/><br/>Your last successful login was $sccflLg .
        <br/><br/>Your last failed login was $fldLg";
    $msgtyp = "Informational";
    $msgsts = "0";
    $srcdoctyp = "Login";
    $srcdocid = -1;
    $hrchyid = -1;
    createWkfMsg($msg_id, $msghdr, $msgbody, $userID, $appID, $msgtyp, $msgsts, $srcdoctyp, $srcdocid, $hrchyid);
    routWkfMsg($msg_id, -1, $prsnid, $userID, 'Initiated', 'Acknowledge');
}

function createWkfMsg($msg_id, $msghdr, $msgbody, $userID, $appID, $msgtyp, $msgsts, $srcdoctyp, $srcdocid, $hrchyid, $attchmnts = "", $attchmnts_desc = "") {
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO wkf.wkf_actual_msgs_hdr(
            msg_id, msg_hdr, msg_body, created_by, creation_date, herchy_id, 
            msg_typ, app_id, msg_status, src_doc_type, src_doc_id, last_update_by, 
            last_update_date, attchments, attchments_desc) " .
            "VALUES ($msg_id, '" . loc_db_escape_string($msghdr) . "', '" . loc_db_escape_string($msgbody) . "', 
            $userID, '" . $dateStr . "', $hrchyid, '" . loc_db_escape_string($msgtyp) . "', 
            $appID, '$msgsts','" . loc_db_escape_string($srcdoctyp) . "',$srcdocid, 
            $userID, '" . $dateStr . "', '" . loc_db_escape_string($attchmnts) .
            "', '" . loc_db_escape_string($attchmnts_desc) . "')";
    return execUpdtInsSQL($sqlStr);
}

function updateWkfMsg($msg_id, $msghdr, $msgbody, $userID, $appID, $msgtyp, $msgsts, $srcdoctyp, $srcdocid, $hrchyid, $attchmnts = "", $attchmnts_desc = "") {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_hdr SET
            msg_hdr='" . loc_db_escape_string($msghdr) . "', msg_body='" . loc_db_escape_string($msgbody) .
            "', herchy_id=$hrchyid, msg_typ='" . loc_db_escape_string($msgtyp) .
            "', app_id=$appID, msg_status='$msgsts', src_doc_type='" . loc_db_escape_string($srcdoctyp) .
            "', src_doc_id=$srcdocid, last_update_by = " . $userID .
            ", last_update_date = '" . $dateStr . "', "
            . "attchments = '" . loc_db_escape_string($attchmnts) . "', "
            . "attchments_desc = '" . loc_db_escape_string($attchmnts_desc) . "' WHERE msg_id = $msg_id";
    return execUpdtInsSQL($sqlStr);
}

function updateWkfMsgStatus($msg_id, $msgsts, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_hdr SET
        msg_status='$msgsts', 
            last_update_by = " . $userID .
            ", last_update_date = '" . $dateStr . "' WHERE msg_id = $msg_id";
    return execUpdtInsSQL($sqlStr);
}

function updateWkfMsgBdy($msg_id, $msgbodyAddOn, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_hdr SET
            msg_body='" . loc_db_escape_string($msgbodyAddOn) .
            "' || msg_body, last_update_by = " . $userID .
            ", last_update_date = '" . $dateStr . "' WHERE msg_id = $msg_id";
    return execUpdtInsSQL($sqlStr);
}

function routWkfMsg($msg_id, $frmID, $toID, $userID, $curStatus, $actnToPrfm, $hrchylvl = 1, $actCmmnts = "") {
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO wkf.wkf_actual_msgs_routng(
            msg_id, from_prsn_id, to_prsn_id, date_sent, 
            created_by, creation_date, msg_status, action_to_perform, last_update_by, 
            last_update_date, to_prsns_hrchy_level, action_comments) 
            VALUES ($msg_id, $frmID, $toID, '$dateStr', $userID, 
            '$dateStr', '" . loc_db_escape_string($curStatus) . "', '" .
            loc_db_escape_string($actnToPrfm) . "', $userID, '$dateStr', $hrchylvl, 
                '" . loc_db_escape_string($actCmmnts) . "')";
    return execUpdtInsSQL($sqlStr);
}

function updtWkfMsgRtng($rtngID, $usrPrsnID, $nwstatus, $nwAction, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_routng SET is_action_done = '1', who_prfmd_action = $usrPrsnID, 
        date_action_ws_prfmd = '$dateStr', 
    status_aftr_action = '" . loc_db_escape_string($nwstatus) . "', 
        nxt_action_to_prfm = '" . loc_db_escape_string($nwAction) . "', 
            last_update_by = $userID, 
    last_update_date = '$dateStr' WHERE routing_id = " . $rtngID;
    return execUpdtInsSQL($sqlStr);
}

function updtWkfMsgRtngUsngLvl($msgID, $hrchylvl, $usrPrsnID, $nwstatus, $nwAction, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_routng SET is_action_done = '1', who_prfmd_action = $usrPrsnID, 
        date_action_ws_prfmd = '$dateStr', 
    status_aftr_action = '" . loc_db_escape_string($nwstatus) . "', 
        nxt_action_to_prfm = '" . loc_db_escape_string($nwAction) . "', 
            last_update_by = $userID, 
    last_update_date = '$dateStr' WHERE msg_id = " . $msgID . " and to_prsns_hrchy_level = $hrchylvl";
    return execUpdtInsSQL($sqlStr);
}

function updtWkfMsgReasgnRtng($rtngID, $fromID, $toID, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_routng 
            SET from_prsn_id=$fromID, to_prsn_id=$toID, last_update_date = '$dateStr', last_update_by = $userID
            , date_sent='" . $dateStr . "'
            WHERE routing_id=" . $rtngID;
    return execUpdtInsSQL($sqlStr);
}

function updtWkfMsgRtngCmnts($rtngID, $msgCmmnts, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_routng 
            SET action_comments = '" . loc_db_escape_string($msgCmmnts) . "' || action_comments, last_update_date = '$dateStr', last_update_by = $userID
            WHERE routing_id=" . $rtngID;
    return execUpdtInsSQL($sqlStr);
}

function updtWkfMsgRtngStatus($rtngID, $msgStst, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_routng 
            SET is_action_done = '" . loc_db_escape_string($msgStst) . "', last_update_date = '$dateStr', last_update_by = $userID
            WHERE routing_id=" . $rtngID;
    return execUpdtInsSQL($sqlStr);
}

function updtWkfMsgAllUnclsdRtng($msgID, $usrPrsnID, $nwstatus, $nwAction, $userID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE wkf.wkf_actual_msgs_routng SET is_action_done = '1', who_prfmd_action = $usrPrsnID, 
        date_action_ws_prfmd = '$dateStr', 
    status_aftr_action = '" . loc_db_escape_string($nwstatus) . "', 
        nxt_action_to_prfm = '" . loc_db_escape_string($nwAction) . "', 
            last_update_by = $userID, 
    last_update_date = '$dateStr' WHERE msg_id = " . $msgID . " and is_action_done = '0'";
    return execUpdtInsSQL($sqlStr);
}

function getUserID($username) {
//echo "uname_".$username;
    $sqlStr = "select user_id from sec.sec_users where 
        lower(user_name)=lower('" . loc_db_escape_string($username) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getUserName($userid) {
//echo "uname_".$username;
    $sqlStr = "select user_name from sec.sec_users where 
        user_id= $userid";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getUserPrsnID($username) {
    $sqlStr = "select person_id from sec.sec_users where 
        lower(user_name)=lower('" . loc_db_escape_string($username) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getUserPrsnID1($userID) {
    $sqlStr = "select person_id from sec.sec_users where 
        user_id=$userID";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getNewUserPrsnID($username) {
    $sqlStr = "select person_id from prs.prsn_names_nos a where lower(a.local_id_no) = lower('"
            . loc_db_escape_string($username) . "') and lower(a.local_id_no) NOT IN "
            . "(Select lower(b.user_name) from sec.sec_users b) ";
    //. "and person_id NOT IN (Select c.person_id from sec.sec_users c)";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getLastSccflLgnMsg($userID) {
    $sqlStr = "select trim(to_char(to_timestamp(login_time,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') || '-Machine Details(' || host_mach_details || ')')  from sec.sec_track_user_logins where 
        user_id=" . $userID . " and was_lgn_atmpt_succsful='t' ORDER BY login_number DESC LIMIT 1 OFFSET 1";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getLastFailedLgn($userID) {
    $sqlStr = "select trim(to_char(to_timestamp(login_time,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') || '-Machine Details(' || host_mach_details || ')')  from sec.sec_track_user_logins where 
        user_id=" . $userID . " and was_lgn_atmpt_succsful='f' ORDER BY login_number DESC LIMIT 1 OFFSET 1";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPrsnFullNm($prsnID) {
    $sqlStr = "select trim(title || ' ' || first_name || ' ' || other_names || ' ' || sur_name) from prs.prsn_names_nos where 
        person_id=" . $prsnID . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPrsnOrgID($prsnID) {
//echo "uname_".$username;
    $sqlStr = "select org_id from prs.prsn_names_nos where 
        person_id=" . $prsnID . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getUserOrgID($username) {
    return getPrsnOrgID(getUserPrsnID($username));
}

function getPersonID($locidno) {
    $sqlStr = "select person_id from prs.prsn_names_nos where (local_id_no = '" .
            loc_db_escape_string($locidno) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getPersonLocID($prsnID) {
    $sqlStr = "select local_id_no from prs.prsn_names_nos where (person_id = " .
            $prsnID . ")";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPersonSlfSrvcsImg($pkID) {
    $sqlStr = "select img_location from self.self_prsn_names_nos WHERE (person_id=$pkID)";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return '';
}

function getRoleID($locidno) {
    $sqlStr = "select role_id from sec.sec_roles where (role_name = '" .
            loc_db_escape_string($locidno) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getFrmtdDB_Date_time() {
    $sqlStr = "select to_char(now(), 'DD-Mon-YYYY HH24:MI:SS')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function getDB_Date_time() {
    $sqlStr = "select to_char(now(), 'YYYY-MM-DD HH24:MI:SS')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function getDB_Date_TimeIntvl($intrvl) {
    $sqlStr = "select to_char(now()- interval '$intrvl', 'YYYY-MM-DD HH24:MI:SS')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function getDB_Date_TmIntvlAdd($intrvl) {
    $sqlStr = "select to_char(now()+ interval '$intrvl', 'YYYY-MM-DD HH24:MI:SS')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function cnvrtYMDTmToDMYTm($inptDte) {
    $sqlStr = "select to_char(to_timestamp('$inptDte',
        'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function cnvrtDMYTmToYMDTm($inptDte) {
    $sqlStr = "select to_char(to_timestamp('$inptDte',
        'DD-Mon-YYYY HH24:MI:SS'),'YYYY-MM-DD HH24:MI:SS')";
    //echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function cnvrtDMYToYMD($inptDte) {
    /* $original_date = "06 Apr 25 13:36";
      $pieces = explode(" ", $original_date);
      $new_date = date("Y-m-d",strtotime($pieces[2]." ".$pieces[1]." ".$pieces[0]));
     */
    $sqlStr = "select to_char(to_timestamp('$inptDte',
        'DD-Mon-YYYY'),'YYYY-MM-DD')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function cnvrtBoolToBitStr($testval) {
    if ($testval) {
        return "1";
    } else {
        return "0";
    }
}

function cnvrtBitStrToBool($testval) {
    if ($testval == "0") {
        return false;
    } else {
        return true;
    }
}

function findCharIndx($inp_char, $inpArry) {
    $arrlength = count($inpArry);
    for ($i = 0; $i < $arrlength; $i++) {
        if ($inpArry[$i] == $inp_char) {
            return $i;
        }
    }
    return -1;
}

function restricted() {
    $usrID = $_SESSION['USRID'];
    if ($usrID > 0) {
        echo "
<div id='rho_form'><H1 style=\"text-align:center; color:red;\">RESTRICTED AREA!!!</H1>
<p style=\"text-align:center; color:red;\"><b><i>Sorry, 
you do not have permission to access this page. 
Click to go <a class=\"rho-button\" href=\"javascript: showRoles();\">back</a> to your Priviledges</i></b></p></div>";
    } else {
        echo "
<div id='rho_form'><H1 style=\"text-align:center; color:red;\">RESTRICTED AREA!!!</H1>
<p style=\"text-align:center; color:red;\"><b><i>Sorry, 
you do not have permission to access this page. 
Click to go <a class=\"rho-button\" href=\"javascript: window.location='index.php';\">[Back]</a></i></b></p></div>";
    }
}

function getLovValuesItm($searchWord, $searchIn, $offset, $limit_size, &$brghtsqlStr, $lovID, &$is_dynamic, $criteriaID, $criteriaID2, $criteriaID3) {
    global $orgID;
    $lovNm = getLovNm($lovID);
    $strSql = "";
    $is_dynamic = false;
    $extrWhere = "";
    $ordrBy = "ORDER BY 1";

    if ($searchIn == "Item Code") {
        $extrWhere = "and item_code ilike '" . loc_db_escape_string($searchWord) . "'";
    } else {
        $extrWhere = "and item_desc ilike '" . loc_db_escape_string($searchWord) . "'";
    }

    $strSql = "SELECT item_code \"item code\", item_desc \"description\", 
        (SELECT uom_name FROM inv.unit_of_measure WHERE uom_id = base_uom_id) \"base uom\",
        selling_price \"selling price\", (SELECT code_name FROM scm.scm_tax_codes WHERE code_id = tax_code_id) \"tax code\",
        (SELECT code_name FROM scm.scm_tax_codes WHERE code_id = dscnt_code_id) \"discount code\",
        (SELECT code_name FROM scm.scm_tax_codes WHERE code_id = extr_chrg_id) \"extra charge\",
        total_qty \"total qty\", reservations, available_balance, item_id mt
  FROM inv.inv_itm_list WHERE 1=1 AND org_id = $orgID " . $extrWhere . "" . $ordrBy . " LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);

    $brghtsqlStr = $strSql;
//echo $strSql;
//echo $strSql;
    $result = executeSQLNoParams($strSql);
    return $result;
}

function getUomCnvsnFactor($itmUomId, $valToCnvt) {
//echo "uname_".$username;

    $sqlStr = "SELECT COALESCE(cnvsn_factor,0)*$valToCnvt
  FROM inv.itm_uoms WHERE itm_uom_id = $itmUomId";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return (int) 1 * $valToCnvt;
}

function getItmUomLovs($uomItemCode) {
    $strSql = "SELECT a.itm_uom_id mt, (SELECT b.uom_name FROM inv.unit_of_measure b WHERE b.uom_id = a.uom_id)\"uom\",
            a.uom_id mt
            FROM inv.itm_uoms a WHERE a.item_id = (SELECT item_id FROM inv.inv_itm_list WHERE item_code = 
            '" . loc_db_escape_string($uomItemCode) . "') 
            union
            SELECT -1 mt, (SELECT b.uom_name FROM inv.unit_of_measure b WHERE b.uom_id = a.base_uom_id) uom, base_uom_id mt
            FROM inv.inv_itm_list a WHERE a.item_code = '" . loc_db_escape_string($uomItemCode) . "'";
//echo $strSql;
    $result = executeSQLNoParams($strSql);
    return $result;
}

function insertSpaces($str, $insChar, $maxChrWidth) {
    $arrystr = str_split($str);
    $res = "";
    for ($i = 0; $i < count($arrystr); $i++) {
        $res .= $arrystr[$i];
        if ($i > 0 && !($i % $maxChrWidth)) {
            $res .= $insChar;
//echo $res . $i % $maxChrWidth . $insChar . 'test';
        }
    }

    return $res;
}

function getModuleID($mdl_name) {
//Example module name 'Security'
    $sqlStr = "select module_id from sec.sec_modules where module_name = '" .
            loc_db_escape_string($mdl_name) . "'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getPrvldgID($prvldg_name, $ModuleName) {
    //Example priviledge 'View Security Module'
    $sqlStr = "SELECT prvldg_id from sec.sec_prvldgs where (prvldg_name = '" .
            loc_db_escape_string($prvldg_name) . "' AND module_id = " .
            getModuleID($ModuleName) . ")";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function doSlctdRolesHvThisPrvldg($inp_prvldg_id) {
    //Checks whether a given role 'system administrator' has a given priviledge
    global $ssnRoles;
    $slctdRl = ";" . $ssnRoles . ";";
    $sqlStr = "SELECT role_id FROM sec.sec_roles_n_prvldgs WHERE ((prvldg_id = " .
            $inp_prvldg_id . ") AND (trim('$slctdRl') ilike trim('%;' || role_id || ';%')) 
                AND (now() between to_timestamp(valid_start_date|| ' 00:00:00','YYYY-MM-DD HH24:MI:SS') " .
            "AND to_timestamp(valid_end_date || ' 23:59:59','YYYY-MM-DD HH24:MI:SS')))";
    $result = executeSQLNoParams($sqlStr);
    //echo $sqlStr;
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function doesRoleHvThisPrvldg($inp_role_id, $inp_prvldg_id) {
//Checks whether a given role 'system administrator' has a given priviledge
    $sqlStr = "SELECT role_id FROM sec.sec_roles_n_prvldgs WHERE ((prvldg_id = " .
            $inp_prvldg_id . ") AND (role_id = " . $inp_role_id .
            ") AND (now() between to_timestamp(valid_start_date|| ' 00:00:00','YYYY-MM-DD HH24:MI:SS') " .
            "AND to_timestamp(valid_end_date || ' 23:59:59','YYYY-MM-DD HH24:MI:SS')))";
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function doCurRolesHvThsPrvldgs($prvldgnames, $mdlNm) {
    global $Role_Set_IDs;
    $chkRslts = array_fill(0, count($prvldgnames), false);

    for ($i = 0; $i < count($Role_Set_IDs); $i++) {
        for ($j = 0; $j < count($prvldgnames); $j++) {
            if (doesRoleHvThisPrvldg($Role_Set_IDs[$i], getPrvldgID($prvldgnames[$j], $mdlNm)) == true) {
                $chkRslts[$j] = true;
            }
        }
    }
    for ($n = 0; $n < count($chkRslts); $n++) {
        if ($chkRslts[$n] == false) {
            return false;
        }
    }
    return true;
}

function test_prmssns($testdata, $mdlNm) {
    $dlmtrs = '~';
    $prldgs_to_test = explode($dlmtrs, $testdata);
    $chkRslts = array_fill(0, count($prldgs_to_test), false);
    for ($j = 0; $j < count($prldgs_to_test); $j++) {
        if (doSlctdRolesHvThisPrvldg(getPrvldgID($prldgs_to_test[$j], $mdlNm)) == true) {
            $chkRslts[$j] = true;
        }
    }
    for ($n = 0; $n < count($chkRslts); $n++) {
        if ($chkRslts[$n] == false) {
            return false;
        }
    }
    return true;
}

function getLovID($lovName) {
    $sqlStr = "SELECT value_list_id from gst.gen_stp_lov_names where (value_list_name = '" .
            loc_db_escape_string($lovName) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getLovNm($lovID) {
    $sqlStr = "SELECT value_list_name from gst.gen_stp_lov_names " .
            "where (value_list_id = " . $lovID . ")";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPssblValID($pssblVal, $lovID) {
    $sqlStr = "SELECT pssbl_value_id from gst.gen_stp_lov_values " .
            "where ((pssbl_value = '" .
            loc_db_escape_string($pssblVal) . "') AND (value_list_id = " . $lovID . "))";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getPssblValID2($pssblVal, $lovID, $pssblValDesc) {
    $sqlStr = "SELECT pssbl_value_id from gst.gen_stp_lov_values " .
            "where ((pssbl_value = '" .
            loc_db_escape_string($pssblVal) . "') AND (pssbl_value_desc = '" .
            loc_db_escape_string($pssblValDesc) . "') AND (value_list_id = " . $lovID . "))";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function getPssblValNm($pssblVlID) {
    $sqlStr = "SELECT pssbl_value from gst.gen_stp_lov_values " .
            "where ((pssbl_value_id = " . $pssblVlID . "))";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPssblValDesc($pssblVlID) {
    $sqlStr = "SELECT pssbl_value_desc from gst.gen_stp_lov_values " .
            "where ((pssbl_value_id = " . $pssblVlID . "))";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getEnbldPssblValDesc($pssblVal, $lovID) {
    $sqlStr = "SELECT pssbl_value_desc from gst.gen_stp_lov_values " .
            "where ((upper(pssbl_value) = upper('" .
            loc_db_escape_string($pssblVal) . "')) AND (value_list_id = " . $lovID .
            ") AND (is_enabled='1')) ORDER BY pssbl_value_id LIMIT 1";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function isVlLstDynamic($lovID) {
    $strSql = "select is_list_dynamic from gst.gen_stp_lov_names " .
            "where is_list_dynamic='1' and value_list_id = " . $lovID;
//echo $strSql;
    $result = executeSQLNoParams($strSql);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function getSQLForDynamicVlLst($lovID) {
    $strSql = "select sqlquery_if_dyn from gst.gen_stp_lov_names " .
            "where value_list_id = " . $lovID;
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getLovValues($searchWord, $searchIn, $offset, $limit_size, &$brghtsqlStr, $lovID, &$is_dynamic, $criteriaID, $criteriaID2, $criteriaID3, $addtnlWhere = "") {
    $lovNm = getLovNm($lovID);
    $strSql = "";
    $is_dynamic = false;
    $extrWhere = "";
    $ordrBy = "ORDER BY 1";
    $selLst = "tbl1.a,tbl1.b,tbl1.c";
    if ($lovNm == "Report/Process Runs") {
        $ordrBy = "ORDER BY 5 DESC";
        $selLst = "tbl1.a,tbl1.b,tbl1.c,tbl1.d,tbl1.e";
    }
    if ($searchIn == "Value") {
        $extrWhere = "and tbl1.a ilike '" . loc_db_escape_string($searchWord) . "'";
    } else if ($searchIn == "Description") {
        $extrWhere = "and tbl1.b ilike '" . loc_db_escape_string($searchWord) . "'";
    } else {
        $extrWhere = "and (tbl1.a ilike '" . loc_db_escape_string($searchWord) .
                "%' or tbl1.b ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    if (isVlLstDynamic($lovID) == true) {
        if ($criteriaID <= 0 && $criteriaID2 == "" && $criteriaID3 == "") {
            $strSql = "select * from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE 1=1 " . $extrWhere . $addtnlWhere . " " . $ordrBy . " LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        } else if ($criteriaID >= 0 && $criteriaID2 == "" && $criteriaID3 == "") {
            $strSql = "select " . $selLst . " from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE tbl1.d = " . $criteriaID . " " . $extrWhere . $addtnlWhere . " " . $ordrBy . " LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        } else if ($criteriaID >= 0 && $criteriaID2 != "" && $criteriaID3 == "") {
            $strSql = "select " . $selLst . " from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (tbl1.d = " . $criteriaID . " and tbl1.e = '" .
                    loc_db_escape_string($criteriaID2) . "' " . $extrWhere . $addtnlWhere . ") " . $ordrBy . " LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        } else if ($criteriaID >= 0 && $criteriaID2 != "" && $criteriaID3 != "") {
            $strSql = "select " . $selLst . " from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (tbl1.d = " . $criteriaID . " and tbl1.e = '" .
                    loc_db_escape_string($criteriaID2) . "' and tbl1.f = '" . loc_db_escape_string($criteriaID3) .
                    "' " . $extrWhere . $addtnlWhere . ") " . $ordrBy . " LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        } else if ($criteriaID < 0 && $criteriaID2 != "" && $criteriaID3 == "") {
            $strSql = "select " . $selLst . " from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (tbl1.e = '" .
                    loc_db_escape_string($criteriaID2) . "' " . $extrWhere . $addtnlWhere . ") " . $ordrBy . " LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        } else {
            $strSql = "select " . $selLst . " from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (1=1 " . $extrWhere . $addtnlWhere . ") " . $ordrBy . " LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        }
        $is_dynamic = true;
    } else {
        if ($searchIn == "Value") {
            $strSql = "SELECT pssbl_value, pssbl_value_desc, pssbl_value_id " .
                    "FROM gst.gen_stp_lov_values WHERE ((is_enabled != '0') AND (pssbl_value ilike '" .
                    loc_db_escape_string($searchWord) . "') AND (value_list_id = " . $lovID .
                    ")" . $addtnlWhere . ") $ordrBy LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        } else if ($searchIn == "Description") {
            $strSql = "SELECT pssbl_value, pssbl_value_desc, pssbl_value_id " .
                    "FROM gst.gen_stp_lov_values WHERE ((is_enabled != '0') AND (pssbl_value_desc ilike '" .
                    loc_db_escape_string($searchWord) . "') AND (value_list_id = " . $lovID .
                    ")" . $addtnlWhere . ") $ordrBy LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        } else {
            $strSql = "SELECT pssbl_value, pssbl_value_desc, pssbl_value_id " .
                    "FROM gst.gen_stp_lov_values WHERE ((is_enabled != '0') AND (pssbl_value ilike '" .
                    loc_db_escape_string($searchWord) . "' or pssbl_value_desc ilike '" .
                    loc_db_escape_string($searchWord) . "') AND (value_list_id = " . $lovID .
                    ")" . $addtnlWhere . ") $ordrBy LIMIT " . $limit_size .
                    " OFFSET " . abs($offset * $limit_size);
        }
    }

    $brghtsqlStr = $strSql;
//echo $strSql;
//echo $strSql;
    $result = executeSQLNoParams($strSql);
    return $result;
}

function getTtlLovValues($searchWord, $searchIn, &$brghtsqlStr, $lovID, &$is_dynamic, $criteriaID, $criteriaID2, $criteriaID3, $addtnlWhere = "") {
    $lovNm = getLovNm($lovID);
    $strSql = "";
    $is_dynamic = false;
    $extrWhere = "";
//$ordrBy = "";
//$selLst = "count(1)";
    if ($lovNm == "Report/Process Runs") {
        $ordrBy = "";
        $selLst = "tbl1.a,tbl1.b,tbl1.c,tbl1.d,tbl1.e";
    }
    if ($searchIn == "Value") {
        $extrWhere = "and tbl1.a ilike '" . loc_db_escape_string($searchWord) . "'";
    } else if ($searchIn == "Description") {
        $extrWhere = "and tbl1.b ilike '" . loc_db_escape_string($searchWord) . "'";
    } else {
        $extrWhere = "and (tbl1.a ilike '" . loc_db_escape_string($searchWord) .
                "%' or tbl1.b ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    if (isVlLstDynamic($lovID) == true) {
        if ($criteriaID <= 0 && $criteriaID2 == "" && $criteriaID3 == "") {
            $strSql = "select count(1) from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE 1=1 " . $extrWhere . $addtnlWhere . " ";
        } else if ($criteriaID >= 0 && $criteriaID2 == "" && $criteriaID3 == "") {
            $strSql = "select count(1) from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE tbl1.d = " . $criteriaID . " " . $extrWhere . $addtnlWhere . " ";
        } else if ($criteriaID >= 0 && $criteriaID2 != "" && $criteriaID3 == "") {
            $strSql = "select count(1) from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (tbl1.d = " . $criteriaID . " and tbl1.e = '" .
                    loc_db_escape_string($criteriaID2) . "' " . $extrWhere . $addtnlWhere . ") ";
        } else if ($criteriaID >= 0 && $criteriaID2 != "" && $criteriaID3 != "") {
            $strSql = "select count(1) from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (tbl1.d = " . $criteriaID . " and tbl1.e = '" .
                    loc_db_escape_string($criteriaID2) . "' and tbl1.f = '" . loc_db_escape_string($criteriaID3) .
                    "' " . $extrWhere . $addtnlWhere . ") ";
        } else if ($criteriaID < 0 && $criteriaID2 != "" && $criteriaID3 == "") {
            $strSql = "select count(1) from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (tbl1.e = '" .
                    loc_db_escape_string($criteriaID2) . "' " . $extrWhere . $addtnlWhere . ") ";
        } else {
            $strSql = "select count(1) from (" . getSQLForDynamicVlLst($lovID) .
                    ") tbl1 WHERE (1=1 " . $extrWhere . $addtnlWhere . ") ";
        }
        $is_dynamic = true;
    } else {
        if ($searchIn == "Value") {
            $strSql = "SELECT count(1) " .
                    "FROM gst.gen_stp_lov_values WHERE ((is_enabled != '0') AND (pssbl_value ilike '" .
                    loc_db_escape_string($searchWord) . "') AND (value_list_id = " . $lovID .
                    ")" . $addtnlWhere . ") ";
        } else if ($searchIn == "Description") {
            $strSql = "SELECT count(1) " .
                    "FROM gst.gen_stp_lov_values WHERE ((is_enabled != '0') AND (pssbl_value_desc ilike '" .
                    loc_db_escape_string($searchWord) . "') AND (value_list_id = " . $lovID .
                    ")" . $addtnlWhere . ") ";
        } else {
            $strSql = "SELECT count(1) " .
                    "FROM gst.gen_stp_lov_values WHERE ((is_enabled != '0') AND (pssbl_value ilike '" .
                    loc_db_escape_string($searchWord) . "' or pssbl_value_desc ilike '" .
                    loc_db_escape_string($searchWord) . "') AND (value_list_id = " . $lovID .
                    ")" . $addtnlWhere . ") ";
        }
    }

    $brghtsqlStr = $strSql;
//echo $strSql;
//echo $strSql;
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function getPrsnEmail($prsnid) {
    $sqlStr = "select a.email from prs.prsn_names_nos a where a.person_id = " .
            $prsnid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPrsnMobile($prsnid) {
    $sqlStr = "select a.cntct_no_mobl || ';' || a.cntct_no_tel from prs.prsn_names_nos a where a.person_id = " .
            $prsnid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function decrypt($inpt, $key) {
    try {
        $fnl_str = "";
        $charset1 = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L",
            "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
            "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",
            "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x",
            "y", "z");
        $charset2 = str_split(getNewKey($key), 1);
        /* $charset2 = array("e", "q", "0", "P", "3", "i", "D", "O", "V", "8", "E", "6",
          "B", "Z", "A", "W", "5", "g", "G", "F", "H", "u", "t", "s",
          "C", "K", "d", "p", "r", "w", "z", "x", "a", "c", "1", "m",
          "I", "f", "Q", "L", "v", "Y", "j", "S", "R", "o", "J", "4",
          "9", "h", "7", "M", "b", "X", "k", "N", "l", "n", "2", "y",
          "T", "U"); */

        $wldChars = array("`", "¬", "!", "\"", "£", "$", "%", "^", "&", "*", "(", ")",
            "-", "_", "=", "+", "{", "[", "]", "}", ":", ";", "@", "'",
            "#", "~", "/", "?", ">", ".", "<", ",", "\\", "|", " ");
        $wldChrLen = count($wldChars);
//$charset2Len = count($charset1);
//$charset2Len = count($charset2);

        $inptLen = strlen($inpt);
        for ($i = $inptLen - 1; $i >= 0; $i--) {
            $tst_str = substr($inpt, $i, 1);
            if ($tst_str == "_") {
                continue;
            }
            $j = findCharIndx($tst_str, $charset2);
            if ($j == -1) {
                $fnl_str .= $tst_str;
            } else {
                if ($i < $inptLen - 1) {
                    if (substr($inpt, $i + 1, 1) == "_" && $j < $wldChrLen) {
                        $fnl_str .= $wldChars[$j];
                    } else {
                        $fnl_str .= $charset1[$j];
                    }
                } else {
                    $fnl_str .= $charset1[$j];
                }
            }
        }
        $nwStr1 = substr($fnl_str, 0, 4);
        $nwStr2 = substr($fnl_str, 4, 4);
        $stringLn = (int) $nwStr2 - (int) $nwStr1;
        $nwStr3 = substr($fnl_str, 8, $stringLn);
        return $nwStr3;
        //return $fnl_str;
    } catch (Exception $e) {
        return $inpt;
    }
}

function getNewKey($key) {
    $charset1 = str_split($key, 1);
    $charset2 = array(
        "e", "q", "0", "P", "3", "i", "D", "O", "V", "8", "E", "6",
        "B", "Z", "A", "W", "5", "g", "G", "F", "H", "u", "t", "s",
        "C", "K", "d", "p", "r", "w", "z", "x", "a", "c", "1", "m",
        "I", "f", "Q", "L", "v", "Y", "j", "S", "R", "o", "J", "4",
        "9", "h", "7", "M", "b", "X", "k", "N", "l", "n", "2", "y",
        "T", "U");
    $wldChars = array("`", "¬", "!", "\"", "£", "$", "%", "^", "&", "*", "(", ")",
        "-", "_", "=", "+", "{", "[", "]", "}", ":", ";", "@", "'",
        "#", "~", "/", "?", ">", ".", "<", ",", "\\", "|", " ");
    $keyLength = count($charset1);
    $newKey = "";
    for ($i = $keyLength - 1; $i >= 0; $i--) {
        if (findCharIndx($charset1[$i], $wldChars) > -1) {
            continue;
        }
        if (strpos($newKey, $charset1[$i]) === FALSE) {
            $newKey.= $charset1[$i];
        }
        if (strlen($newKey) >= 62) {
            break;
        }
    }

    if (strlen($newKey) < 62) {
        $keyLength = count($charset2);
        for ($i = $keyLength - 1; $i >= 0; $i--) {
            if (strpos($newKey, $charset2[$i]) === FALSE) {
                $newKey.= $charset2[$i];
            }
            if (strlen($newKey) >= 62) {
                break;
            }
        }
    }
    return $newKey;
}

function getRandomPswd() {
    $charset1 = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L",
        "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
        "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",
        "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x",
        "y", "z");
    $charset2 = array("e", "q", "0", "P", "3", "i", "D", "O", "V", "8", "E", "6",
        "B", "Z", "A", "W", "5", "g", "G", "F", "H", "u", "t", "s",
        "C", "K", "d", "p", "r", "w", "z", "x", "a", "c", "1", "m",
        "I", "f", "Q", "L", "v", "Y", "j", "S", "R", "o", "J", "4",
        "9", "h", "7", "M", "b", "X", "k", "N", "l", "n", "2", "y",
        "T", "U");
    $wldChars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $pswd = "";

    $idx = -1;
    for ($i = 1; $i < 10; $i++) {
        if ($i == 1 || $i == 4 || $i == 7) {
            $idx = rand(0, count($charset1) - 1);
            $pswd .= $charset1[$idx];
        } else if ($i == 2 || $i == 5) {
            $idx = rand(0, count($charset2) - 1);
            $pswd .= $charset2[$idx];
        } else if ($i == 3 || $i == 6) {
            $idx = rand(0, count($wldChars) - 1);
            $pswd .= $wldChars[$idx];
        }
    }
    return $pswd;
}

function getRandomTxt($numChars) {
    $charset1 = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L",
        "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
        "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",
        "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x",
        "y", "z");
    $charset2 = array("e", "q", "0", "P", "3", "i", "D", "O", "V", "8", "E", "6",
        "B", "Z", "A", "W", "5", "g", "G", "F", "H", "u", "t", "s",
        "C", "K", "d", "p", "r", "w", "z", "x", "a", "c", "1", "m",
        "I", "f", "Q", "L", "v", "Y", "j", "S", "R", "o", "J", "4",
        "9", "h", "7", "M", "b", "X", "k", "N", "l", "n", "2", "y",
        "T", "U");
    $wldChars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $pswd = "";

    $idx = -1;
    $setNum = 1;
    for ($i = 1; $i <= $numChars; $i++) {
        $setNum = rand(0, 4);
        if ($setNum == 1) {
            $idx = rand(0, count($charset1) - 1);
            $pswd .= $charset1[$idx];
        } else if ($setNum == 2) {
            $idx = rand(0, count($charset2) - 1);
            $pswd .= $charset2[$idx];
        } else if ($setNum == 3) {
            $idx = rand(0, count($wldChars) - 1);
            $pswd .= $wldChars[$idx];
        } else {
            $idx = rand(0, count($charset2) - 1);
            $pswd .= $charset2[$idx];
        }
    }
    return $pswd;
}

function sendSMS($msgBody, $rcpntNo, &$errMsg) {
    $msgBody = str_replace("|", "/", str_replace("\n", " ", str_replace("\r", " ", str_replace("\r\n", " ", $msgBody))));
    $dtstResult = executeSQLNoParams("select sms_param1, sms_param2, sms_param3, 
                                                sms_param4, sms_param5, sms_param6, 
                                                sms_param7, sms_param8, sms_param9, sms_param10 
                                                from sec.sec_email_servers where is_default='t'");

    $rvsdMsgBdy = "";
    for ($z = 0; $z < strlen($msgBody); $z++) {
        if ($z > 0 && ($z % 160) == 0) {
            $rvsdMsgBdy .= substr($msgBody, $z, 1) . "|";
        } else {
            $rvsdMsgBdy .= substr($msgBody, $z, 1);
        }
    }
    $nwMsgBdy = explode("|", $rvsdMsgBdy);
    $url = '';
    $fields = array();
    $sendRes = "1";
    for ($z = 0; $z < count($nwMsgBdy); $z++) {

        $paramNms = array();
        $paramVals = array();
        $tmpStr = "";
        $tmpArry = array();
        $i = 0;
        while ($row = loc_db_fetch_array($dtstResult)) {
            $tmpStr = trim($row[0], " | ");
            $tmpArry = explode("|", $tmpStr);

            if ($tmpStr == "" || count($tmpArry) != 2) {
                $paramNms[$i] = "";
                $paramVals[$i] = "";
            } else {
                $paramNms[$i] = $tmpArry[0];
                $paramVals[$i] = $tmpArry[1];
            }

            if ($paramNms[$i] == "url") {
                $url = $paramVals[$i];
            } else if ($paramNms[$i] == "success txt") {
                $succsTxt = $paramVals[$i];
            } else if ($paramNms[$i] != "" && $paramVals[$i] != "") {
                $fields[$paramNms[$i]] = str_replace("{:to}", $rcpntNo, str_replace("{:msg}", $nwMsgBdy[$z], $paramVals[$i]));
            }
        }
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        $sendRes = $data->error;
        if ($data->error == "0") {
            $errMsg = "Message was successfully sent";
        } else {
            $errMsg = "Message failed to send. Error: " . $data->error;
        }
    }

    if ($sendRes == "0") {
        return true;
    } else {
        return false;
    }
}

function sendEMail($to, $nameto, $subject, $message, &$errMsg, $ccMail = "", $bccMail = "", $attchmnts = "", $namefrom = "Portal Administrator") {
    global $admin_email;
    global $app_url;
    global $smplTokenWord;
    try {
        $selSql = "SELECT smtp_client, mail_user_name, mail_password, smtp_port FROM sec.sec_email_servers WHERE (is_default = 't')";
        $selDtSt = executeSQLNoParams($selSql);
        $m = loc_db_num_rows($selDtSt);
        $smtpClnt = "";
        $fromEmlNm = "";
        $fromPswd = "";
        $portNo = 0;
        while ($row = loc_db_fetch_array($selDtSt)) {
            $smtpClnt = $row[0];
            $fromEmlNm = $row[1];
            $fromPswd = decrypt($row[2], $smplTokenWord);
            $portNo = 587; //$row[3];
        }
//error_reporting(E_USER_ERROR);"ssl://" . 
        $smtpServer = $smtpClnt;   //smtp.gmail.com ip address of the mail server.  This can also be the local domain name
        $port = $portNo;      // should be 25 by default, but needs to be whichever port the mail server will be using for smtp 
        $timeout = "145";     // typical timeout. try 45 for slow servers
        $username = $fromEmlNm; // the login for your smtp
        $password = $fromPswd;   // the password for your smtp
        $localhost = "127.0.0.1";    // Defined for the web server.  Since this is where we are gathering the details for the email
        $newLine = "<br/>";    // aka, carrage return line feed. var just for newlines in MS
        $secure = 1;   // change to 1 if your server is running under SSL
        $from = $fromEmlNm;
// Swift Mailer Library
        require_once 'swiftmailer/lib/swift_required.php';

// Mail Transport
        $transport = Swift_SmtpTransport::newInstance($smtpServer, $port)
                ->setUsername($username) // Your Gmail Username
                ->setPassword($password) // Your Gmail Password
                ->setEncryption('tls');

// Mailer
        $mailer = Swift_Mailer::newInstance($transport);
// Create a message setBcc()
        $swmessage = Swift_Message::newInstance("$subject");

        $doc = new DOMDocument();
        @$doc->loadHTML($message);

        $tags = $doc->getElementsByTagName('img');

        foreach ($tags as $tag) {
            $src1 = $tag->getAttribute('src');
//echo $src1;
            str_replace("src=\"" . $src1 . "\"", "src=\"" .
                    $swmessage->embed(Swift_Image::fromPath(str_replace($app_url . "/", "", $src1))) . "\"", $message);
        }
        if ($ccMail != "" && $bccMail != "") {
            $swmessage->setFrom(array("$from" => "$namefrom")) // can be $_POST['email'] etc...
                    ->setTo(explode(",", $to)) // your email / multiple supported.
                    ->setCc(explode(";", $ccMail))
                    ->setBcc(explode(";", $bccMail))
                    ->setBody("$message", 'text/html')
                    ->addPart(cleanOutputData($message), 'text/plain');
        } else if ($ccMail != "" && $bccMail == "") {
            $swmessage->setFrom(array("$from" => "$namefrom")) // can be $_POST['email'] etc...
                    ->setTo(explode(",", $to)) // your email / multiple supported.
                    ->setCc(explode(";", $ccMail))
                    ->setBody("$message", 'text/html')
                    ->addPart(cleanOutputData($message), 'text/plain');
        } else if ($ccMail == "" && $bccMail != "") {
            $swmessage->setFrom(array("$from" => "$namefrom")) // can be $_POST['email'] etc...
                    ->setTo(explode(",", $to)) // your email / multiple supported.
                    ->setBcc(explode(";", $bccMail))
                    ->setBody("$message", 'text/html')
                    ->addPart(cleanOutputData($message), 'text/plain');
        } else {
            $swmessage->setFrom(array("$from" => "$namefrom")) // can be $_POST['email'] etc...
                    ->setTo(explode(",", $to)) // your email / multiple supported.
                    ->setBody("$message", 'text/html')
                    ->addPart(cleanOutputData($message), 'text/plain');
        }

        $attchFiles = explode(";", $attchmnts);
//var_dump($attchFiles);
        for ($i = 0; $i < count($attchFiles); $i++) {
            if ($attchFiles[$i] != "") {
//echo str_replace($app_url . "/", "", $attchFiles[$i]);
                $swmessage->attach(Swift_Attachment::fromPath(str_replace($app_url . "/", "", $attchFiles[$i])));
            }
        }
// Send the message
        $swmessage->setMaxLineLength(1000);
        if ($mailer->send($swmessage)) {
            $errMsg = 'Mail sent successfully!';
        } else {
            $errMsg = "Failed to Send Mail!";
        }
        return TRUE;
    } catch (Exception $e) {
        $eMsg = substr($e->getMessage(), 0, 40);
        if (strpos($eMsg, 'Connection could not be established') !== FALSE) {
            $eMsg = "Connection could not be established!";
        } else if (strpos($eMsg, 'Address in mailbox given') !== FALSE) {
            $eMsg = "Your Registered Email Address is Invalid!<br/>"
                    . "Send a Complaint to <a href=\"mailto:" . $admin_email . "\">$admin_email</a> for Assistance!<br/>";
        }
        $errMsg = "<span style=\"color:red !important;\">Failed to Send Mail! " . $eMsg . "</span>";
        return FALSE;
    }
}

function getGnrlRecID2($tblNm, $srchcol, $rtrnCol, $recname) {
    $sqlStr = "select " . $rtrnCol . " from " . $tblNm . " where lower(" . $srchcol . ") = lower('" .
            loc_db_escape_string($recname) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getGnrlRecID($tblNm, $srchcol, $rtrnCol, $recname, $orgid) {
    $sqlStr = "select " . $rtrnCol . " from " . $tblNm . " where lower(" . $srchcol . ") = lower('" .
            loc_db_escape_string($recname) . "') and org_id = " . $orgid;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getGnrlRecNm($tblNm, $srchcol, $rtrnCol, $recid) {
    $sqlStr = "select " . $rtrnCol . " from " . $tblNm . " where " . $srchcol . " = " . $recid;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getGnrlRecNm2($tblNm, $srchcol, $rtrnCol, $recnm) {
    $sqlStr = "select " . $rtrnCol . " from " . $tblNm . " where " . $srchcol . " = '" . loc_db_escape_string($recnm) . "'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getGnrlRecIDExtr($tblNm, $srchcolForNM, $srchcolForID, $rtrnCol, $recname, $recID) {
    $sqlStr = "select " . $rtrnCol . " from " . $tblNm . " where lower(" . $srchcolForNM . ") = lower('" .
            loc_db_escape_string($recname) . "') and " . $srchcolForID . " = " . $recID;
    $result = executeSQLNoParams($sqlStr);
//echo $sqlStr;
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getGnrlRecIDExtr1($tblNm, $srchcolForNM, $srchcolForNM1, $rtrnCol, $recname, $recname1) {
    $sqlStr = "select " . $rtrnCol . " from " . $tblNm . " where lower(" . $srchcolForNM . ") = lower('" .
            loc_db_escape_string($recname) . "') and lower(" . $srchcolForNM1 . ") = '" .
            loc_db_escape_string($recname1) . "'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getActionSQL($routingID, $actyp) {
    $sqlStr = "select a.sql_stmnt 
from wkf.wkf_apps_actions a, wkf.wkf_actual_msgs_routng b, wkf.wkf_actual_msgs_hdr c
where a.action_performed_nm='" . loc_db_escape_string($actyp) . "' 
and a.app_id=c.app_id
and b.msg_id = c.msg_id
and b.routing_id=$routingID";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getActionUrl($routingID, $actyp) {
    $sqlStr = "select a.web_url 
from wkf.wkf_apps_actions a, wkf.wkf_actual_msgs_routng b, wkf.wkf_actual_msgs_hdr c
where a.action_performed_nm='" . loc_db_escape_string($actyp) . "' 
and a.app_id=c.app_id
and b.msg_id = c.msg_id
and b.routing_id=$routingID";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getActionUrlDsplyTyp($routingID, $actyp) {
    $sqlStr = "select a.is_web_dsply_diag 
from wkf.wkf_apps_actions a, wkf.wkf_actual_msgs_routng b, wkf.wkf_actual_msgs_hdr c
where a.action_performed_nm='" . loc_db_escape_string($actyp) . "' 
and a.app_id=c.app_id
and b.msg_id = c.msg_id
and b.routing_id=$routingID";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getActionAdminOnly($routingID, $actyp) {
    $sqlStr = "select a.is_admin_only 
from wkf.wkf_apps_actions a, wkf.wkf_actual_msgs_routng b, wkf.wkf_actual_msgs_hdr c
where a.action_performed_nm='" . loc_db_escape_string($actyp) . "' 
and a.app_id=c.app_id
and b.msg_id = c.msg_id
and b.routing_id=$routingID";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function executeActionOnMsg($sqlStr) {
    if ($sqlStr != "") {
        $result = executeSQLNoParams($sqlStr);
        while ($row = loc_db_fetch_array($result)) {
            return $row[0];
        }
    } else {
        return "|ERROR|No SQL";
    }
}

function getSlogan() {
    global $org_name;
    global $app_slogan;
    global $orgID;
    if ($orgID !== -1) {
        echo getOrgSlogan($orgID) . "               " . getFrmtdDB_Date_time();
    } else {
        echo "$app_slogan" . getFrmtdDB_Date_time();
    }
}

function getShapes() {
    global $org_name;
    global $app_image;
    global $orgID;
    global $database;
    global $orgID;
    GLOBAL $ftp_base_db_fldr;

    if ($orgID > 0) {
        $img_src = "app_data/$database/Org/$orgID.png";
        $ftp_src = $ftp_base_db_fldr . "/Org/$orgID.png";
        if (file_exists($ftp_src)) {
            copy("$ftp_src", "$img_src");
        }
        echo "<img src=\"$img_src\" style=\"left: 0.5%; margin:2px; padding-right: 1em; height:65px; width:auto; position: relative; vertical-align: middle;\"/>";
    } else {
        echo "<img src=\"cmn_images/$app_image\" style=\"left: 0.5%; margin:2px; padding-right: 1em; height:65px; width:auto; position: relative; vertical-align: middle;\"/>";
    }
}

function getHeadline() {
    global $org_name;
    global $orgID;
    global $app_name;
    if ($orgID !== -1) {
        echo $org_name;
    } else {
        echo "$app_name";
    }
}

function getRptDrctry() {
//\\172.25.10.96\bog_applsys project\RICHARD\Images\Org
    $sqlStr = "select pssbl_value from gst.gen_stp_lov_values where ((value_list_id = " .
            getLovID("Reports Directory") . ") AND (is_enabled='1')) ORDER BY pssbl_value_id DESC LIMIT 1";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function recurse_copy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ( $file = readdir($dir))) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function get_string_between($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return '';
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function validateDateTme($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function storeLogoutTime($lgn_num) {
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE sec.sec_track_user_logins SET logout_time = '" . $dateStr .
            "' WHERE (login_number = " . $lgn_num . ")";
    $result = executeSQLNoParams($sqlStr);
}

function logoutActions() {
    global $usrID;
    global $orgID;
    global $lgn_num;

    $usrID = $_SESSION['USRID'];
    $orgID = $_SESSION['ORG_ID'];
    $lgn_num = $_SESSION['LGN_NUM'];
    storeLogoutTime($lgn_num);

    $_SESSION['UNAME'] = "";
    $_SESSION['USRID'] = -1;
    $_SESSION['LGN_NUM'] = -1;
    $_SESSION['ORG_NAME'] = "";
    $_SESSION['ORG_ID'] = -1;
    $_SESSION['ROOT_FOLDER'] = "";
    $_SESSION['ROLE_SET_IDS'] = "";
    $_SESSION['MUST_CHNG_PWD'] = "0";
    $usrID = $_SESSION['USRID'];
    $user_Name = $_SESSION['UNAME'];
    $orgID = $_SESSION['ORG_ID'];
    $lgn_num = $_SESSION['LGN_NUM'];
    $ifrmeSrc = $_SESSION['CUR_IFRM_SRC'];


    $org_name = $_SESSION['ORG_NAME'];
    $ssnRoles = $_SESSION['ROLE_SET_IDS'];
    $Role_Set_IDs = explode(";", $ssnRoles);
    $ModuleName = "";
    session_destroy();   // destroy session data in storage
    session_unset();     // unset $_SESSION variable for the runtime	
}

/**
 * PROSPECTIVE MEMBER GLOBAL FUNCTIONS
 */
function getUserIDPM($username) {
//echo "uname_".$username;
    $sqlStr = "select user_id from prspt.prspt_user where 
        lower(user_name)=lower('" . loc_db_escape_string($username) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getUserNamePM($userid) {
//echo "uname_".$username;
    $sqlStr = "select user_name from prspt.prspt_user where 
        user_id= $userid";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getUserPrsnIDPM($username) {
    $sqlStr = "select person_id from prspt.prspt_user where 
        lower(user_name)=lower('" . loc_db_escape_string($username) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getUserPrsnID1PM($userID) {
    $sqlStr = "select person_id from prspt.prspt_user where 
        user_id=$userID";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getPrsnFullNmPM($prsnID) {
    $sqlStr = "select trim(title || ' ' || first_name || ' ' || middle_name || ' ' || last_name) from prspt.prspt_person_info where 
        person_id=" . $prsnID . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPssblValDescPM($pssblVlNm, $VlstNm) {
    $sqlStr = "select pssbl_value_desc
from gst.gen_stp_lov_names a, gst.gen_stp_lov_values b
where ((a.value_list_id = b.value_list_id
and value_list_name = '" . loc_db_escape_string($VlstNm) . "'
and pssbl_value = '" . loc_db_escape_string($pssblVlNm) . "'))";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

/**
 * PROSPECTIVE MEMBER VARIABLES
 */
$usrIDPM = $_SESSION['USRIDPM'];
$user_NamePM = $_SESSION['UNAMEPM'];
$prsnidPM = $_SESSION['PRSN_ID_PM'];

/**
 * END PROSPECTIVE MEMBER VARIABLES
 */
$usrID = $_SESSION['USRID'];
$user_Name = $_SESSION['UNAME'];
$orgID = $_SESSION['ORG_ID'];
$lgn_num = $_SESSION['LGN_NUM'];
$ifrmeSrc = $_SESSION['CUR_IFRM_SRC'];
$prsnid = $_SESSION['PRSN_ID'];
$fullNm = $_SESSION['PRSN_FNAME'];

if ($lgn_num <= 0) {
    $_SESSION['ORG_NAME'] = "$app_name";
} else {
    $_SESSION['ORG_NAME'] = getOrgName($orgID);
}
$org_name = $_SESSION['ORG_NAME'];
$ssnRoles = $_SESSION['ROLE_SET_IDS'];
$Role_Set_IDs = explode(";", $ssnRoles);
$ModuleName = "";
$os = php_uname('s');
$delFiles = $_SESSION['CUR_RPT_FILES'];
$indv_files_to_del = explode("|", $delFiles);
$filepth = "";
$args = "";
if (strpos($os, "Window") !== FALSE) {
    for ($i = 0; $i < count($indv_files_to_del); $i++) {
        if (file_exists($indv_files_to_del[$i])) {
            if (strpos($os, "Window") !== FALSE) {
                $bsdbfldr = str_replace("/", "\\", trim($_SERVER['DOCUMENT_ROOT'], " |")) . "\\$base_folder\\" . str_replace("/", "\\", trim($indv_files_to_del[$i], " |"));
                $filepth .=" " . escapeshellarg($bsdbfldr);
            } else {
                
            }
        }
    }
    $args = " /F /Q " . $filepth;
//echo escapeshellcmd("ERASE") . $args;
    $output = shell_exec(escapeshellcmd("ERASE") . " " . $args);
//echo $output;
} else {
    
}
$_SESSION['CUR_RPT_FILES'] = "";
?>