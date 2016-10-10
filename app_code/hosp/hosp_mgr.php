<?php

$menuItems = array(
    "Visits & Appointments", "Appointment Data",
    "Service Types & Providers", "List of Diagnosis",
    "Lab Investigations List", "Provider Groups");
// require $base_dir."admin_funcs.php";
$vwtyp1 = 0;
//echo $vwtyp1;
if (isset($_REQUEST['vwtyp'])) {
    $vwtyp1 = $_REQUEST['vwtyp'];
}
//echo $vwtyp1;
if ($vwtyp1 <= 100) {
    //require $base_dir . "rho_header.php";
}
$pgNo = 0;
$grp = 14;
$typ = 1;

$mdlNm = "Clinic/Hospital";
$ModuleName = $mdlNm;
if (isset($_REQUEST['pg']))
    $pgNo = $_REQUEST['pg'];
if (isset($_REQUEST['q']))
    $mdlNm = $_REQUEST['q'];
if (isset($_REQUEST['grp']))
    $grp = $_REQUEST['grp'];
if (isset($_REQUEST['typ']))
    $typ = $_REQUEST['typ'];

$dfltPrvldgs = array("View Visits & Appointments", "View Appointment Data", "View Service Types & Providers",
    /* 3 */ "View List of Diagnosis", "Add Visits & Appointments", "Edit Appointment Data",
    /* 6 */ "Delete Appointment Data", "Add Appointment Data", "Edit Appointment Data",
    /* 9 */ "Delete Appointment Data", "Add Service Types & Providers", "Edit Service Types & Providers",
    /* 12 */ "Delete Service Types & Providers", "Add List of Diagnosis", "Edit List of Diagnosis",
    /* 15 */ "View Lab Investigations List", "Edit Lab Investigations List", "Delete Lab Investigations List",
    /* 18 */ "Delete List of Diagnosis", "View Record History", "View SQL");

function createRqrdLOVs() {

    $sysLovs = array("Service Types", "Service Providers", "Provider Groups", "Dosage Methods", "Inventory Services"
        , "Diagnosis Types", "Investigation Types", "Laboratory Locations", "Inventory Items", "Recommended Services",
        "Service Provider Groups", "Item UOM"
    );
    $sysLovsDesc = array("Service Types", "Service Providers", "Provider Groups", "Dosage Methods", "Inventory Services"
        , "Diagnosis Types", "Investigation Types", "Laboratory Locations", "Inventory Items", "Recommended Services",
        "Service Provider Groups", "Item UOM"
    );
    $sysLovsDynQrys = array("select distinct trim(to_char(type_id,'999999999999999999999999999999')) a, trim(type_name ||' ('||type_desc||')') b, '' c from hosp.srvs_types order by 2",
        "SELECT distinct trim(to_char(x.prsn_id,'999999999999999999999999999999')) a, 
    (SELECT trim(title || ' ' || sur_name || ', ' || first_name || ' ' || other_names) FROM prs.prsn_names_nos WHERE person_id = x.prsn_id)
    ||'('||(SELECT type_name from hosp.srvs_types WHERE type_id = x.srvs_type_id)||')' b, '' c, srvs_type_id d FROM hosp.srvs_prvdrs x order by 2",
        "SELECT distinct trim(to_char(prvdr_grp_id,'999999999999999999999999999999')) a, prvdr_grp_name b, '' c FROM hosp.prvdr_grps order by 2",
        "",
        "SELECT distinct trim(to_char(item_id,'999999999999999999999999999999')) a, item_code||' ('||item_desc||')' b, '' c FROM inv.inv_itm_list WHERE item_type = 'Services' AND org_id = 6 order by 2",
        "SELECT distinct trim(disease_name) a, symtms b, '' c  FROM hosp.diseases order by 1",
        "SELECT distinct trim(to_char(invstgtn_list_id,'999999999999999999999999999999')) a, invstgtn_name||' ('||invstgtn_desc||')' b, '' c  FROM hosp.invstgtn_list order by 2",
        "",
        "SELECT distinct trim(item_code) a, item_desc b, '' c FROM inv.inv_itm_list WHERE org_id = 6 order by 2",
        "select distinct trim(to_char(type_id,'999999999999999999999999999999')) a, trim(type_name ||' ('||type_desc||')') b, '' c from hosp.srvs_types where sys_code not in ('1-Consultation','2-Investigations','3-Vitals','4-Pharmacy') order by 2",
        "SELECT distinct trim(to_char(prvdr_grp_id,'999999999999999999999999999999')) a, (SELECT prvdr_grp_name FROM hosp.prvdr_grps WHERE prvdr_grp_id = x.prvdr_grp_id) b, '' c, type_id d FROM hosp.prvdr_grp_srvs x order by 2",
        "SELECT (SELECT v.uom_name FROM inv.unit_of_measure v WHERE v.uom_id = x.uom_id) a, (SELECT w.uom_desc FROM inv.unit_of_measure w WHERE w.uom_id = x.uom_id) b,
            '' c, z.org_id d, (SELECT w.item_code FROM inv.inv_itm_list w WHERE w.item_id = x.item_id) e
            FROM inv.inv_itm_list z, inv.itm_uoms x WHERE z.item_id = x.item_id 
            union
            SELECT (SELECT y.uom_name FROM inv.unit_of_measure y WHERE y.uom_id = x.base_uom_id) a, (SELECT y.uom_desc FROM inv.unit_of_measure y WHERE y.uom_id = x.base_uom_id) b,
            '' c, x.org_id d, x.item_code e FROM inv.inv_itm_list x  ORDER BY 1"
    );

    $pssblVals = array(
        "3", "Oral", "To be taken my mouth"
        , "3", "Suppository", "To be taken through the anus, urethra"
        , "3", "External", "External applications"
        , "3", "Injection", "To be injected"
        , "3", "Intra-venous Infusion", "To be infused into the veins"
        , "7", "BOG Clinic", "Bank Of Ghana Clinic Laboratory"
        , "7", "Ridge Hospital", "Ridge Hospital Laboratory"
    );

    createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
    createSysLovsPssblVals($pssblVals, $sysLovs);
}

function loadHospRqrmnts() {
    global $dfltPrvldgs;
    $DefaultPrvldgs = $dfltPrvldgs;

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";

    $myName = "Clinic/Hospital";
    $myDesc = "This module helps you to manage your Hospital Operations!";
    $audit_tbl_name = "rpt.rpt_audit_trail_tbl";

    $smplRoleName = "Clinic/Hospital Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    createRqrdLOVs();
    echo "<p style=\"font-size:12px;\">Completed Checking & Requirements load for <b>$myName!</b></p>";
}

function getAppntmntRecmmddServID($cnsltnId, $srvsTypeId) {
    //used for recommended services created by doctor
    $sqlStr = "SELECT rcmd_srv_id FROM hosp.rcmd_srvs 
        WHERE cnsltn_id = $cnsltnId
        AND srv_type_id = $srvsTypeId";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getAppntmntStatus($parAppntmntID) {
    $sqlStr = "SELECT a.appntmnt_status from hosp.appntmnt a
          WHERE a.appntmnt_id = $parAppntmntID";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPrvdrGrpIDilike($prvdrGrpName) {
    $sqlStr = "SELECT prvdr_grp_id from hosp.prvdr_grps WHERE lower(prvdr_grp_name) ilike lower('" .
            loc_db_escape_string($prvdrGrpName) . "')";
    $result = executeSQLNoParams($sqlStr);
    $ftchrslt = "'";
    $ftchrslt1 = "'";
    while ($row = loc_db_fetch_array($result)) {
        $ftchrslt1.=$row[0] . "','";
    }

    if ($ftchrslt1 != "'") {
        $finrst = $ftchrslt1 . $ftchrslt;
        return str_ireplace(",''", "", $finrst);
    }

    return -1;
}

function getPssblValIDUsnDescNLovName($pssblValDesc, $lovName) {
    $sqlStr = "SELECT pssbl_value_id FROM gst.gen_stp_lov_values WHERE lower(pssbl_value) = lower('" .
            loc_db_escape_string($pssblValDesc) . "') AND value_list_id = 
                (SELECT value_list_id from gst.gen_stp_lov_names where (value_list_name = '$lovName'))";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }

    return -1;
}

function getVstIDforAppntmnt($apptmntID) {
    //Checks whether the visist already has an appointment of an unclosed status
    $sqlStr = "SELECT vst_id FROM hosp.appntmnt
                WHERE  appntmnt_id= $apptmntID";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getPrvdrTypforAppntmnt($apptmntID) {
    //Checks whether the visist already has an appointment of an unclosed status
    $sqlStr = "SELECT prvdr_type FROM hosp.appntmnt
                WHERE  appntmnt_id= $apptmntID";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getVstPrsnID($vstID) {
    $strSql = "SELECT prsn_id
    FROM hosp.visit WHERE vst_id =  $vstID";
    $result = executeSQLNoParams($strSql);
    $row = loc_db_fetch_array($result);
    return $row[0];
}

function getSrvsType($inpkID) {
    $sqlStr = "SELECT c.type_name FROM hosp.srvs_types c WHERE c.type_id = 
        (SELECT srvs_type_id from hosp.appntmnt WHERE appntmnt_id = " . $inpkID . ")";
    $result = executeSQLNoParams($sqlStr);
    $row = loc_db_fetch_array($result);
    return $row[0];
}

function addRqrdServsTypeItmsServs($srvsTypeId, $appntmntId) {
    global $usrID;
    $datestr = getDB_Date_time();
    $result = get_RqrdItmsServs_Rcds($srvsTypeId);
    while ($row = loc_db_fetch_array($result)) {

        $qty = (float) $row[4];
        $itmCode = $row[1];
        $itmId = $row[7];

        $appntmntDataItmId = getAppntmntDataItmID($appntmntId, $itmCode);
        if ($appntmntDataItmId < 0) {
            $insSQL = "INSERT INTO hosp.appntmnt_data_items(
               appntmnt_id, qty, created_by, creation_date, 
               last_update_by, last_update_date, item_id)
               VALUES ($appntmntId, $qty, $usrID, '$datestr', $usrID, '$datestr', $itmId)";
            execUpdtInsSQL($insSQL);
        }
    }
}

function getAppntmntDataItmID($appntmntId, $itmCode) {
    $itemId = getGnrlRecID2("inv.inv_itm_list", "item_code", "item_id", $itmCode);
    $sqlStr = "SELECT appdt_itm_id FROM hosp.appntmnt_data_items 
        WHERE appntmnt_id = $appntmntId
        AND item_id = $itemId";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function get_RqrdItmsServs_Rcds($pkID) {
    $sqlStr = "SELECT a.itmservs_rqrd_id mt, (SELECT c.item_code FROM inv.inv_itm_list c WHERE c.item_id = a.itm_id) \"item/service code\", 
        (SELECT b.item_desc FROM inv.inv_itm_list b WHERE b.item_id = a.itm_id) \"description\",
        (SELECT uom_name FROM inv.unit_of_measure WHERE uom_id = (SELECT base_uom_id FROM inv.inv_itm_list WHERE item_id = a.itm_id)) \"base uom\",
        a.quantity \"quantity\", cmnts \"comments\", 
        a.servs_type_id mt, a.itm_id mt
        FROM hosp.itms_servs_rqrd a
        WHERE a.servs_type_id = " . $pkID . " ORDER BY 2";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getSrvsPrvdrsInGrp($inpkID) {
    $sqlStr = "SELECT prsn_id from hosp.srvs_prvdrs WHERE prvdr_grp_id = " . $inpkID . "";
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function updateApptmntSts($apptmntID, $nwvalue) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE hosp.appntmnt SET appntmnt_status = '" .
            loc_db_escape_string($nwvalue) . "', last_update_by = " .
            $usrID . ", last_update_date = '" . $dateStr . "' " .
            "WHERE((appntmnt_id = " . $apptmntID . "))";
    //echo $sqlStr;
    return execUpdtInsSQL($sqlStr);
}

function CreateApptmntMsg() {
    global $user_Name;
    $apptmntID = isset($_REQUEST['aptmntid']) ? $_REQUEST['aptmntid'] : "-1";
    if ($apptmntID > 0) {

        $msg_id = getWkfMsgID();
        $appID = getAppID('Clinical Appointments', 'Clinic/Hospital');
        //Patient Data
        $srvsType = getSrvsType($apptmntID);
        $srvsTypeId = getGnrlRecID2("hosp.srvs_types", "type_name", "type_id", $srvsType);
        $vstID = getVstIDforAppntmnt($apptmntID);

        $aptmtDte = getGnrlRecNm("hosp.appntmnt", "appntmnt_id", "to_char(to_timestamp(appntmnt_date, 'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS')", $apptmntID);
        $vstPrsnID = getVstPrsnID($vstID);
        $vstPrsnFullNm = getPrsnFullNm($vstPrsnID);
        $vstPrsnLocID = getPersonLocID($vstPrsnID);

        //Appointment Booker
        $prsnid = getUserPrsnID($user_Name);
        $fullNm = getPrsnFullNm($prsnid);
        $prsnLocID = getPersonLocID($prsnid);
        $userID = getUserID($user_Name);

        //Message Header & Details
        $msghdr = "Patient $vstPrsnFullNm ($vstPrsnLocID) Requires your Service ($srvsType)";
        $msgbody = "CLINICAL APPOINTMENT ON ($aptmtDte):- An appointment has been booked with you by $fullNm ($prsnLocID) on behalf of a Patient called $vstPrsnFullNm ($vstPrsnLocID).
                <br/>The service being requested for is $srvsType.
                <br/>Please open the attached Work Document and attend to this Patient.
                <br/>Thank you.";
        $msgtyp = "Work Document";
        $msgsts = "0";
        $srcdoctyp = "Clinical Appointments";
        $srcdocid = $apptmntID;
        $hrchyid = -1;

        createWkfMsg($msg_id, $msghdr, $msgbody, $userID, $appID, $msgtyp, $msgsts, $srcdoctyp, $srcdocid, $hrchyid);
        //Service Provider(s)
        $prvdrType = getPrvdrTypforAppntmnt($apptmntID);
        if ($prvdrType == "0") {
            //IND
            $prvdrPrsnID = (float) getGnrlRecNm("hosp.appntmnt", "appntmnt_id", "srvs_prvdr_prsn_id", $apptmntID);
            if ($prvdrPrsnID > 0) {
                routWkfMsg($msg_id, $prsnid, $prvdrPrsnID, $userID, 'Initiated', 'Open;Reject;Request for Information;Change Provider;Close');
            }
        } else if ($prvdrType == "1") {
            $prvdrGrpID = (float) getGnrlRecNm("hosp.appntmnt", "appntmnt_id", "prvdr_grp_id", $apptmntID);
            $result = getSrvsPrvdrsInGrp($prvdrGrpID);
            while ($row = loc_db_fetch_array($result)) {
                $prvdrPrsnID = (float) $row[0];
                if ($prvdrPrsnID > 0) {
                    routWkfMsg($msg_id, $prsnid, $prvdrPrsnID, $userID, 'Initiated', 'Open;Reject;Request for Information;Change Provider;Close');
                }
            }
        }
        //Update Appointment Status to In Process
        updateApptmntSts($apptmntID, "In Process");

        //insert items/services for service type
        addRqrdServsTypeItmsServs($srvsTypeId, $apptmntID);
    }
}

function CreateApptmntMsgForServs($apptmntID) {
    global $user_Name;
    //$apptmntID = isset($_REQUEST['aptmntid']) ? $_REQUEST['aptmntid'] : "-1";
    if ($apptmntID > 0) {

        $msg_id = getWkfMsgID();
        $appID = getAppID('Clinical Appointments', 'Clinic/Hospital');
        //Patient Data
        $srvsType = getSrvsType($apptmntID);
        $srvsTypeId = getGnrlRecID2("hosp.srvs_types", "type_name", "type_id", $srvsType);
        $vstID = getVstIDforAppntmnt($apptmntID);

        $aptmtDte = getGnrlRecNm("hosp.appntmnt", "appntmnt_id", "to_char(to_timestamp(appntmnt_date, 'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS')", $apptmntID);
        $vstPrsnID = getVstPrsnID($vstID);
        $vstPrsnFullNm = getPrsnFullNm($vstPrsnID);
        $vstPrsnLocID = getPersonLocID($vstPrsnID);

        //Appointment Booker
        $prsnid = getUserPrsnID($user_Name);
        $fullNm = getPrsnFullNm($prsnid);
        $prsnLocID = getPersonLocID($prsnid);
        $userID = getUserID($user_Name);

        //Message Header & Details
        $msghdr = "Patient $vstPrsnFullNm ($vstPrsnLocID) Requires your Service ($srvsType)";
        $msgbody = "CLINICAL APPOINTMENT ON ($aptmtDte):- An appointment has been booked with you by $fullNm ($prsnLocID) on behalf of a Patient called $vstPrsnFullNm ($vstPrsnLocID).
                <br/>The service being requested for is $srvsType.
                <br/>Please open the attached Work Document and attend to this Patient.
                <br/>Thank you.";
        $msgtyp = "Work Document";
        $msgsts = "0";
        $srcdoctyp = "Clinical Appointments";
        $srcdocid = $apptmntID;
        $hrchyid = -1;

        createWkfMsg($msg_id, $msghdr, $msgbody, $userID, $appID, $msgtyp, $msgsts, $srcdoctyp, $srcdocid, $hrchyid);
        //Service Provider(s)
        $prvdrType = getPrvdrTypforAppntmnt($apptmntID);
        if ($prvdrType == "0") {
            //IND
            $prvdrPrsnID = (float) getGnrlRecNm("hosp.appntmnt", "appntmnt_id", "srvs_prvdr_prsn_id", $apptmntID);
            if ($prvdrPrsnID > 0) {
                routWkfMsg($msg_id, $prsnid, $prvdrPrsnID, $userID, 'Initiated', 'Open;Reject;Request for Information;Change Provider;Close');
            }
        } else if ($prvdrType == "1") {
            $prvdrGrpID = (float) getGnrlRecNm("hosp.appntmnt", "appntmnt_id", "prvdr_grp_id", $apptmntID);
            $result = getSrvsPrvdrsInGrp($prvdrGrpID);
            while ($row = loc_db_fetch_array($result)) {
                $prvdrPrsnID = (float) $row[0];
                if ($prvdrPrsnID > 0) {
                    routWkfMsg($msg_id, $prsnid, $prvdrPrsnID, $userID, 'Initiated', 'Open;Reject;Request for Information;Change Provider;Close');
                }
            }
        }

        //Update Appointment Status to In Process
        updateApptmntSts($apptmntID, "In Process");

        //insert items/services for service type
        addRqrdServsTypeItmsServs($srvsTypeId, $apptmntID);
    }
}

$canview = test_prmssns($dfltPrvldgs[0], $mdlNm);

if ($lgn_num > 0 && $canview === true) {
    if ($pgNo == 0) {

        if (isset($_SESSION['CUR_TAB'])) {
            $_SESSION['CUR_TAB'] = "C1";
        }
        //createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
        //createSysLovsPssblVals($pssblVals, $sysLovs);
        $cntent = "<div id='rho_form' style=\"min-height:150px;\">
            <form id='sysAdminForm' action='' method='post' accept-charset='UTF-8'>
                <fieldset style=\"padding:10px 20px 20px 20px;\">
                    <legend>   $mdlNm                
                    </legend>
                    <div style=\"margin-bottom:10px;\">
                    <h2>Welcome to the Hospital Management Module</h2>
                    </div>
                    
                    <div class='rho_form1' style=\"background-color:#e3e3e3;border: 1px solid #999;padding:10px;\" class=\"rho-postcontent rho-postcontent-0 clearfix\">                    
      <h5>FUNCTIONALITIES OF THE HOSPITAL MANAGEMENT MODULE</h5>
      <p>This module automates all hospital processes. The module has the ff areas:
      ";
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($grpcntr == 0) {
                $cntent.= "<div style=\"float:left;\">"
                        . "<ul class=\"no_bullet\">";
            }
            $cntent.= "<li class=\"leaf\" style=\"background: url('cmn_images/start.png') no-repeat 3px 4px; background-size:20px 20px;\"><a onclick=\"modules('$mdlNm', $No);\">$menuItems[$i]</a></li>";

            if ($grpcntr == 2) {
                $cntent.= "</ul>"
                        . "</div>";
                $grpcntr = 0;
            } else {
                $grpcntr = $grpcntr + 1;
            }
        }
        $cntent.= "<div style=\"float:left;\">"
                . "<ul class=\"no_bullet\">";
        $cntent.= "<li class=\"leaf\" style=\"background: url('cmn_images/start.png') no-repeat 3px 4px; background-size:20px 20px;\"><a onclick=\"gnrlMsgAjxCall('mydialog', 'Checking & Loading Requirements', 'ajx=1&grp=$grp&typ=$typ&pg=7&q=$mdlNm&vwtyp=120');\">Check & Load Requirements</a></li>";
        $cntent.= "</ul>"
                . "</div>";
        $cntent.= "
    </p></div>
    </fieldset>
            </form>
        </div>
<div id=\"mydialog\" title=\"Basic dialog\" style=\"display:none;\">
</div>";
        echo $cntent;
        echo "<script type=\"text/javascript\"> 
        load('$mdlNm');
              </script>";
    } else if ($pgNo == 1) {
        /* if initiate param is set to 1
         * 1. Call CreateApptmntMsg()
         * 2. Create Routing Msg to Service Provider or all Service Providers if it's Group
         * 3. In this routing give providers chance to Open/Reject/Request Information/Close/
         * 4. Update Src Doc Status
         */
        $shdInit = isset($_REQUEST['shdint']) ? $_REQUEST['shdint'] : "0";
        if ($shdInit == "1") {
            echo CreateApptmntMsg();
        }
        require "visits.php";
    } else if ($pgNo == 2) {
        require "appntmnts.php";
    } else if ($pgNo == 3) {
        require "srvs_typs.php";
    } else if ($pgNo == 4) {
        require "diseases.php";
    } else if ($pgNo == 5) {
        require "lab_invstgtns.php";
    } else if ($pgNo == 6) {
        require "prvdr_grps.php";
    } else if ($pgNo == 7) {
        echo "<p style=\"font-size:12px;\">calling functions for checking and creating requirements</p>";
        loadHospRqrmnts();
    } else {
        restricted();
    }
} else {
    restricted();
}

if ($vwtyp1 <= 100) {
    //require $base_dir . 'rho_footer.php';
}
?>
