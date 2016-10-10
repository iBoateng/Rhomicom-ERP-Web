<?php

$mdlNm = "Self Service";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Self-Service",
    /* 1 */ "View Internal Payments", "View Payables Invoices", "View Receivables Invoices",
    /* 4 */ "View Leave of Absence", "View Events/Attendances", "View Elections",
    /* 7 */ "View Forums", "View E-Library", "View E-Learning",
    /* 10 */ "View Elections Administration", "View Personal Records Administration", "View Forum Administration",
    /* 13 */ "View Self-Service Administration",
    /* 14 */ "View SQL", "View Record History",
    /* 16 */ "Administer Elections",
    /* 17 */ "Administer Leave",
    /* 18 */ "Administer Self-Service", "Make Requests for Others", "Administer Other's Inbox");

$vwtyp = "0";
$qstr = "";
$dsply = "";
$actyp = "";
$qActvOnly = "true";
$srchFor = "";
$srchIn = "";
$RoutingID = -1;
$qNonLgn = "true";
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

if (isset($_POST['qNonLgn'])) {
    $qNonLgn = cleanInputData($_POST['qNonLgn']);
}
if (isset($_POST['qActvOnly'])) {
    $qActvOnly = cleanInputData($_POST['qActvOnly']);
}
if (isset($_POST['RoutingID'])) {
    $RoutingID = cleanInputData($_POST['RoutingID']);
}
if (isset($_POST['qStrtDte'])) {
    $qStrtDte = cleanInputData($_POST['qStrtDte']);
    if (strlen($qStrtDte) == 19) {
        $qStrtDte = substr($qStrtDte, 0, 10) . " 00:00:00";
    } else {
        $qStrtDte = "";
    }
}

if (isset($_POST['qEndDte'])) {
    $qEndDte = cleanInputData($_POST['qEndDte']);
    if (strlen($qEndDte) == 19) {
        $qEndDte = substr($qEndDte, 0, 10) . " 23:59:59";
    } else {
        $qEndDte = "";
    }
}

if (isset($_POST['query'])) {
    $srchFor = cleanInputData($_POST['query']);
}

if (strpos($srchFor, "%") === FALSE) {
    $srchFor = " " . $srchFor . " ";
    $srchFor = str_replace(" ", "%", $srchFor);
}

if (isset($_POST['queryIn'])) {
    $srchIn = cleanInputData($_POST['queryIn']);
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

$isMaster = 0;
if (isset($_POST['qMaster'])) {
    $isMaster = cleanInputData($_POST['qMaster']);
}

if ($isMaster == 1) {
    if (test_prmssns($dfltPrvldgs[20], $mdlNm) == FALSE) {
        restricted();
        exit();
    }
}

function createInbxRecsDtl($result, $startIdx, $srchIn, $srchFor, $lmtSze) {
    global $isMaster;
    $cmpID = 'myInboxGridPnl';
    if ($isMaster == 1) {
        $cmpID = 'wkfInboxGridPnl';
    }
    $output = "";
    $output .= "<div class='container222'><table id=\"rhotable222\" class=\"rhotableClass222\" width=\"100%\" cellspacing=\"2\" cellpadding=\"2\">";

    $i = $startIdx;
    $b = 0;
    $colsCnt = loc_db_num_fields($result);
    while ($row = loc_db_fetch_array($result)) {
        $style = "";

        for ($d = 0; $d < $colsCnt; $d++) {
            $style = "";
            $style2 = "";
            if (trim(loc_db_field_name($result, $d)) == "mt") {
                $style = "style=\"display:none;\"";
            }
            if ($row[$d] == 'No') {
                $style2 = "style=\"color:red;font-weight:bold;\"";
            } else if ($row[$d] == 'Yes') {
                $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
            }
            $indx = $i - 1;
            $hrf1 = "";
            $hrf2 = "";
            $labl = ucwords(str_replace("_", " ", loc_db_field_name($result, $d)));
            $output.="<tr $style>";
            $output.= "<td width=\"20%\" style=\"font-weight:bold;vertical-align:top;\">" . $labl . ":</td>";

            if ($d == 14 && $row[15] == '0') {
//                $hrf1 = "<a class=\"rho-button\" href=\"index1.php?ajx=1&grp=1&typ=10&searchin=$srchIn&searchfor=$srchFor&dsplySze=$lmtSze&q=act&vtyp=1&idx=$indx&id=$row[0]\">";
//                $hrf2 = "</a>";
                $arry1 = explode(";", $row[$d]);
                $output.= "<td $style>";
                for ($r = 0; $r < count($arry1); $r++) {
                    if ($arry1[$r] !== "" && $arry1[$r] != "None") {
                        $isadmnonly = getActionAdminOnly($row[0], $arry1[$r]);
                        if ($isadmnonly == '0' || $isMaster == 1) {
                            $webUrlDsply = getActionUrlDsplyTyp($row[0], $arry1[$r]);
                            $hrf1 = "<div style=\"padding:2px;float:left;\">"
                                    . "<a class=\"x-btn-default-small\" style=\"color:#fff;text-decoration:none;\" "
                                    . "href=\"javascript: actionProcess('$cmpID', '$row[0]','$arry1[$r]','$webUrlDsply','$row[24]','$row[5]','$row[8]','$row[7]');\">";
                            $hrf2 = "</a></div>";
                            $output.="$hrf1" . $arry1[$r] . "$hrf2";
                        }
                    }

                    if ($r == count($arry1) - 1) {
                        $webUrlDsply="";
                        $hrf1 = "<div style=\"padding:2px;float:left;\">"
                                . "<a class=\"x-btn-default-small\" style=\"color:#fff;text-decoration:none;\" "
                                . "href=\"javascript: actionProcess('$cmpID', '$row[0]','View Attachments','$webUrlDsply','$row[24]','$row[5]','$row[8]','$row[7]');\">";
                        $hrf2 = "</a></div>";
                        $output.="$hrf1" . 'View Attachments' . "$hrf2";
                    }
                }

                $output.="</td>";
            } else {
                $output.= "<td width=\"70%\" $style2>$hrf1" . $row[$d] . "$hrf2</td>";
            }
            $output.="</tr>";
        }

        $i++;
        $b++;
    }

    $output.=" </table></div>";
    return $output;
}

function get_MyInbx($searchFor, $searchIn, $offset, $limit_size) {
//global $usrID;
    global $user_Name;
    global $qStrtDte;
    global $qEndDte;
    global $qActvOnly;
    global $qNonLgn;
    global $isMaster;
    $user_Name = $_SESSION['UNAME'];

    $prsnID = getUserPrsnID($user_Name);
    $wherecls = "";

    if ($searchIn === "Status") {
        $wherecls = " AND (CASE WHEN a.is_action_done='0' THEN a.msg_status ELSE a.status_aftr_action END ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn === "Source App") {
        $wherecls = " AND ((c.app_name ilike '%" . loc_db_escape_string($searchFor) . "%')"
                . " or (c.source_module ilike '%" . loc_db_escape_string($searchFor) . "%'))";
    } else if ($searchIn === "Subject") {
        $wherecls = " AND (b.msg_hdr ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Person From") {
        $wherecls = " AND ((prs.get_prsn_name(a.from_prsn_id) || ' (' || prs.get_prsn_loc_id(a.from_prsn_id) || ')') ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Message Type") {
        $wherecls = " AND (b.msg_typ ilike '%" . loc_db_escape_string($searchFor) . "%')";
    }

    if ($qStrtDte != "") {
//$qStrtDte = cnvrtDMYTmToYMDTm($qStrtDte);
        $wherecls .= " AND (a.date_sent >= '" . loc_db_escape_string($qStrtDte) . "')";
    }
    if ($qEndDte != "") {
//$qEndDte = cnvrtDMYTmToYMDTm($qEndDte);
        $wherecls .= " AND (a.date_sent <= '" . loc_db_escape_string($qEndDte) . "')";
    }
    if ($qActvOnly == "true") {
        $wherecls .= " AND (a.is_action_done = '0')";
    }
    if ($qNonLgn == "true") {
        $wherecls .= " AND (lower(c.app_name) NOT like lower('Login'))";
    }
    $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    if ($isMaster == 2) {
        $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    } else if ($isMaster == 1) {
        $extrWhr = "";
    }
    $sqlStr = "SELECT  a.routing_id mt, a.msg_id mt, b.msg_hdr message_header, "
            . "CASE WHEN a.from_prsn_id<=0 THEN 'System Administrator' 
        ELSE prs.get_prsn_name(a.from_prsn_id) || ' (' || prs.get_prsn_loc_id(a.from_prsn_id) || ')' 
        END \"from\", a.to_prsn_id mt, to_char(to_timestamp(a.date_sent,
        'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') \"Date_sent\", a.created_by mt, a.creation_date mt, 
      CASE WHEN a.is_action_done='0' THEN a.msg_status ELSE a.status_aftr_action END message_status,  
      CASE WHEN a.is_action_done='0' THEN a.action_to_perform ELSE a.nxt_action_to_prfm END \"Action(s) To Perform\", 
      a.is_action_done mt, c.app_name mt, c.source_module mt, 
      CASE WHEN a.to_prsn_id<=0 THEN 'System Administrator' 
        ELSE prs.get_prsn_name(a.to_prsn_id) || ' (' || prs.get_prsn_loc_id(a.to_prsn_id) || ')' 
        END \"to\", b.msg_typ message_type, prs.get_prsn_loc_id(a.from_prsn_id) locid 
  FROM wkf.wkf_actual_msgs_routng a, wkf.wkf_actual_msgs_hdr b, wkf.wkf_apps c
WHERE ((c.app_id=b.app_id) AND (a.msg_id=b.msg_id)" . $extrWhr . "$wherecls) ORDER BY a.date_sent DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) <= 0) {
//echo $sqlStr;'<a href=\"\">'|| ||'</a>'
    }
    return $result;
}

function get_MyInbxTtls($searchFor, $searchIn) {
//global $usrID;
    global $user_Name;
    global $qStrtDte;
    global $qEndDte;
    global $qActvOnly;
    global $qNonLgn;
    global $isMaster;

    $user_Name = $_SESSION['UNAME'];

    $prsnID = getUserPrsnID($user_Name);
    $wherecls = "";

    if ($searchIn === "Status") {
        $wherecls = " AND (CASE WHEN a.is_action_done='0' THEN a.msg_status ELSE a.status_aftr_action END ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn === "Source App") {
        $wherecls = " AND ((c.app_name ilike '%" . loc_db_escape_string($searchFor) . "%')"
                . " or (c.source_module ilike '%" . loc_db_escape_string($searchFor) . "%'))";
    } else if ($searchIn === "Subject") {
        $wherecls = " AND (b.msg_hdr ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Person From") {
        $wherecls = " AND (prs.get_prsn_name(a.from_prsn_id) ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Message Type") {
        $wherecls = " AND (b.msg_typ ilike '%" . loc_db_escape_string($searchFor) . "%')";
    }

    if ($qStrtDte != "") {
//$qStrtDte = cnvrtDMYTmToYMDTm($qStrtDte);
        $wherecls .= " AND (a.date_sent >= '" . loc_db_escape_string($qStrtDte) . "')";
    }
    if ($qEndDte != "") {
//$qEndDte = cnvrtDMYTmToYMDTm($qEndDte);
        $wherecls .= " AND (a.date_sent <= '" . loc_db_escape_string($qEndDte) . "')";
    }
    if ($qActvOnly == "true") {
        $wherecls .= " AND (a.is_action_done = '0')";
    }
    if ($qNonLgn == "true") {
        $wherecls .= " AND (lower(c.app_name) NOT like lower('Login'))";
    }
    $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    if ($isMaster == 2) {
        $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    } else if ($isMaster == 1) {
        $extrWhr = "";
    }
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

function get_MyInbxDetl($routingID, $searchFor, $searchIn, $offset, $limit_size) {
    $wherecls = "";
    $wherecls = " AND (a.routing_id = " . loc_db_escape_string($routingID) . ")";

    $sqlStr = "SELECT  a.routing_id mt, a.msg_id mt, 
        c.app_name source_app_name, c.source_module, b.msg_typ message_type,
        CASE WHEN a.from_prsn_id<0 THEN 'System Administrator' 
        ELSE prs.get_prsn_name(a.from_prsn_id) 
        END \"from\", prs.get_prsn_name(a.to_prsn_id) \"to\", to_char(to_timestamp(a.date_sent,
        'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') \"Date_sent\", b.msg_hdr message_header, 
       a.action_comments, 
        b.msg_body message_body,  a.created_by mt, a.creation_date mt, 
       a.msg_status message_status, a.action_to_perform \"Action(s) To Perform\", a.is_action_done mt, 
       CASE WHEN a.is_action_done='1' THEN 'Yes' ELSE 'No' END \"Has Message Been Acted On?\", 
       prs.get_prsn_name(a.who_prfmd_action) \"Action Performed By\", 
       CASE WHEN a.date_action_ws_prfmd='' THEN '' ELSE to_char(to_timestamp(a.date_action_ws_prfmd,
        'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') END date_action_was_performed, 
       a.status_aftr_action new_message_status_after_action, 
       a.nxt_action_to_prfm next_action_to_perform, 
       a.who_prfms_next_action \"Who Performes Next Action\", 
       a.last_update_by mt, a.last_update_date mt,
       prs.get_prsn_loc_id(a.from_prsn_id) mt
  FROM wkf.wkf_actual_msgs_routng a, wkf.wkf_actual_msgs_hdr b, wkf.wkf_apps c
WHERE ((c.app_id=b.app_id) AND (a.msg_id=b.msg_id)$wherecls) ORDER BY a.date_sent DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function advncSrchForm() {
    global $srcApp;
    global $srcMdl;
    global $prsnFrmLocID;
    global $prsnToLocID;
    global $prsnFrm;
    global $prsnTo;
    global $msgTyp;
    global $qStrtDte;
    global $qEndDte;
    global $msgHdr;
    global $rtngSts;
    global $vwtyp;

    $prsnFrmNm = getPrsnFullNm($prsnFrm);
    $prsnToNm = getPrsnFullNm($prsnTo);
//echo $qStrtDte;
//echo $qEndDte;
    $dte1 = cnvrtYMDTmToDMYTm($qStrtDte); // cnvrtYMDTmToDMYTm(add_date(getDB_Date_time(), -1));
    $dte2 = cnvrtYMDTmToDMYTm($qEndDte); //getFrmtdDB_Date_time();
    $todDte1 = substr($dte1, 0, 11);
    $todDte2 = substr($dte2, 0, 11);
//echo $qStrtDte;
//echo $qEndDte;
    $res = "<div class='container' id=\"advancedSearch\">
                <fieldset style=\"max-width:900px;\">
                    <legend>Advanced Search</legend>

                    <table style=\"margin-top:5px;\">
                        <tbody>
                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">Source App:</td>
                                                <td width=\"180px\">
                                                    <input type=\"hidden\" id=\"inptsrch11\" name=\"inptsrch11\"  value=\"\" />
                                                    <input style=\"width:180px;\" type=\"text\" id=\"inptsrch12\" name=\"inptsrch12\"  value=\"$srcApp\" readonly=\"readonly\" />
                                                </td>
                                                <td width=\"50px\"><span class=\"rho-button-wrapper\"><span class=\"rho-button-l\"> </span><span class=\"rho-button-r\"> </span><a name=\"srcAppBtn\" id=\"srcAppBtn\" class=\"rho-button\" onclick=\"getLovsPage('nav_lovs',
                                                                'first', 'Workflow Apps', 'mydialog', '-1', '', '', 'radio', '0', '', '-1|', 'inptsrch11', 'inptsrch12');\">...</a></span>
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">Person From:</td>
                                                <td width=\"180px\">
                                                    <input type=\"hidden\" id=\"inptsrch31\" name=\"inptsrch31\"  value=\"$prsnFrmLocID\" />
                                                    <input style=\"width:180px;\" type=\"text\" id=\"inptsrch32\" name=\"inptsrch32\"  value=\"$prsnFrmNm\" readonly=\"readonly\" />
                                                </td>
                                                <td width=\"50px\"><span class=\"rho-button-wrapper\"><span class=\"rho-button-l\"> </span><span class=\"rho-button-r\"> </span><a name=\"fromPrsn\" id=\"fromPrsn\" class=\"rho-button\" onclick=\"getLovsPage('nav_lovs',
                                                                'first', 'Active Persons', 'mydialog', '-1', '', '', 'radio', '0', '', '-1|', 'inptsrch31', 'inptsrch32');\">...</a></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">Person To:</td>
                                                <td width=\"180px\">
                                                    <input type=\"hidden\" id=\"inptsrch41\" name=\"inptsrch41\"  value=\"$prsnToLocID\" />
                                                    <input style=\"width:180px;\" type=\"text\" id=\"inptsrch42\" name=\"inptsrch42\"  value=\"$prsnToNm\" readonly=\"readonly\" />
                                                </td>
                                                <td width=\"50px\"><span class=\"rho-button-wrapper\"><span class=\"rho-button-l\"> </span><span class=\"rho-button-r\"> </span><a name=\"toPrsn\" id=\"toPrsn\" class=\"rho-button\" onclick=\"getLovsPage('nav_lovs',
                                                                'first', 'Active Persons', 'mydialog', '-1', '', '', 'radio', '0', '', '-1|', 'inptsrch41', 'inptsrch42');\">...</a></span>
                                                </td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tbody>                
                                            <tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">From Date:</td>
                                                <td width=\"180px\">
                                                    <input style=\"width:180px;\" type=\"text\" id=\"inptsrch61\" name=\"inptsrch61\" onchange=\"inputValidator('inptsrch61', 'Date', '$todDte1 00:00:00');\"  value=\"$todDte1 00:00:00\" />
                                                </td>
                                                <td width=\"50px\">
                                                    <a onclick=\"displayDatePicker('inptsrch61', this, 'ymd', '-', '00:00:00');\">
                                                        <img src=\"cmn_images/date.png\" style=\"height:23px; width:25px; float:left;\"/>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">To Date:</td>
                                                <td width=\"180px\">
                                                    <input style=\"width:180px;\" type=\"text\" id=\"inptsrch71\" name=\"inptsrch71\" onchange=\"inputValidator('inptsrch71', 'Date', '$todDte2 23:59:59');\"  value=\"$todDte2 23:59:59\" />
                                                </td>
                                                <td width=\"50px\">
                                                    <a onclick=\"displayDatePicker('inptsrch71', this, 'ymd', '-', '23:59:59');\">
                                                        <img src=\"cmn_images/date.png\" style=\"height:23px; width:25px; float:left;\" />
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">Message Header:</td>
                                                <td width=\"180px\">
                                                    <input style=\"width:180px;\" type=\"text\" id=\"inptsrch81\" name=\"inptsrch81\"  value=\"$msgHdr\" />
                                                </td>
                                                <td width=\"50px\"></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tbody>                
                                            <tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">Message Type:</td>
                                                <td width=\"180px\">
                                                    <select id=\"inptsrch51\" name=\"inptsrch51\" >";
    $msgtyp1 = "";
    $msgtyp2 = "";
    $msgtyp3 = "";
    $msgtyp4 = "";
    if ($msgTyp == "None") {
        $msgtyp1 = "selected=\"selected\"";
    } else if ($msgTyp == "Informational") {
        $msgtyp2 = "selected=\"selected\"";
    } else if ($msgTyp == "Work Document") {
        $msgtyp3 = "selected=\"selected\"";
    } else if ($msgTyp == "Approval Document") {
        $msgtyp4 = "selected=\"selected\"";
    }
    $res.="<option value=\"None\" $msgtyp1 >--Select--</option>
                                                        <option value=\"Informational\" $msgtyp2 >Informational</option>
                                                        <option value=\"Work Document\" $msgtyp3 >Work Document</option>
                                                        <option value=\"Approval Document\" $msgtyp4 >Approval Document</option>
                                                    </select>
                                                </td>
                                                <td width=\"50px\"></td>
                                            </tr>

<tr>
                                                <td width=\"120px\" style=\"font-weight:bold;vertical-align:middle;\">Status:</td>
                                                <td width=\"180px\">";
    $sts1 = "";
    $sts2 = "";
    $sts3 = "";
    if ($rtngSts == "None") {
        $sts1 = "selected=\"selected\"";
    } else if ($rtngSts == "0") {
        $sts2 = "selected=\"selected\"";
    } else if ($rtngSts == "1") {
        $sts3 = "selected=\"selected\"";
    }
    $res.="
                                                    <select id=\"inptsrch91\" name=\"inptsrch91\" >
                                                        <option value=\"None\" $sts1 >--Select--</option>
                                                        <option value=\"0\" $sts2 >Open</option>
                                                        <option value=\"1\" $sts3 >Closed</option>
                                                    </select>
                                                </td>
                                                <td width=\"50px\"></td>
                                            </tr>
                                            <tr>
                                                <td width=\"120px\" colspan=\"3\" style=\"text-align: center;\">
                                                    <a name=\"clearSrchBtn\" id=\"clearSrchBtn\" class=\"rho-button\" href=\"index1.php?ajx=1&amp;grp=1&amp;typ=10&amp;q=view&vtyp=$vwtyp\">Clear</a>
                                                    <a name=\"searchWkfBtn\" id=\"searchWkfBtn\" class=\"rho-button\" onclick=\"getMyInbxPage('nav_inbx', 'first',$vwtyp,'refresh');\">Search</a>
                                                </td>                    
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>           
        </div>";
    return $res;
}

function saveReassignForm() {
    global $usrID;
    global $user_Name;
    global $formArray;

    $inptSlctdRtngs = isset($formArray['routingIDs']) ? cleanInputData($formArray['routingIDs']) : "";
//$formName = isset($formArray['formNme']) ? cleanInputData($formArray['formNme']) : "";
    $nwPrsnLocID = isset($formArray['prsnLocID']) ? cleanInputData($formArray['prsnLocID']) : "";
    $raCmmnts = isset($formArray['noticeDetails']) ? cleanInputData($formArray['noticeDetails']) : "";

    $fromPrsnID = getUserPrsnID($user_Name);
    $usrFullNm = getPrsnFullNm($fromPrsnID);

    $nwPrsnID = getPersonID($nwPrsnLocID);
    $nwPrsnFullNm = getPrsnFullNm($nwPrsnID);
    $arry1 = preg_split('/\|/', $inptSlctdRtngs, -1, PREG_SPLIT_NO_EMPTY); //explode("|", $inptSlctdRtngs);
    $affctd = 0;
    $affctd1 = 0;
    $datestr = getFrmtdDB_Date_time();
    for ($i = 0; $i < count($arry1); $i++) {
        $slctRtngID = (float) $arry1[$i];

        $orgPrsnID = (float) getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "to_prsn_id", $slctRtngID);
        $orgPrsnNm = getPrsnFullNm($orgPrsnID);
        $rtngMsgID = (float) getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "msg_id", $slctRtngID);
        $isActionDone = getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "is_action_done", $slctRtngID);

        if ($isActionDone == '0') {
            $affctd+=updtWkfMsgReasgnRtng($slctRtngID, $fromPrsnID, $nwPrsnID, $usrID);
            $msgbodyAddOn = "";
            $msgbodyAddOn.="RE-ASSIGNMENT ON $datestr:- This document has been re-assigned from " . $orgPrsnNm . "'s Inbox to $nwPrsnFullNm" . "'s Inbox by $usrFullNm with the ff Message:<br/>";
            $msgbodyAddOn.=$raCmmnts . "<br/><br/>";
            $affctd1+=updtWkfMsgRtngCmnts($slctRtngID, $msgbodyAddOn, $usrID);
        }
    }

    $msg = "";
    $dsply = "";
    $res = "";
    if ($affctd > 0) {
        $dsply .= "<br/>$affctd Workflow Document(s) Successfully Re-routed to $nwPrsnFullNm!";
        $dsply .= "<br/>$affctd1 Workflow Document(s) Message Comments Successfully Updated!";
        /* if ($formName == "myInbxForm") {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"getMyInbxPage('nav_inbx', 'first',0,'refresh');\">Click Here to finish!</a>";
          } else {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"closeMydialog();\">Click Here to finish!</a>";
          } */
        $msg = "<p style = \"text-align:left; color:#32CD32;\"><b><i>$dsply</i></b></p>"; //#32CD32
    } else {
        $dsply .= "<br/>Update Failed! No Workflow Document(s) Re-routed";
        /* if ($formName == "myInbxForm") {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"getMyInbxPage('nav_inbx', 'first',0,'refresh');\">Click Here to Close!</a>";
          } else {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"closeMydialog();\">Click Here to Close!</a>";
          } */
        $msg = "<p style = \"text-align:left; color:#ff0000;\"><b><i>$dsply</i></b></p>";
    }
    $res .= $msg;
    return $res;
}

function actOnMsgSQL($routingID, $usr_ID, $actyp) {
    $dsply = "";
    if ($routingID > 0) {
        /*
         * 1. Get sql_behind_action_to_be_performed 
         * E.g. "select wkf.action_sql_for_login({:routing_id},{:userID});"
         * 2. Replace {:routing_id} with $routingID and {:userID} with $usr_ID
         * 3. execute this new sql statement
         * 4. if return is |SUCCESS| display success msg and echo table or detail view
         */
        $sql = getActionSQL($routingID, $actyp);
        $sql = str_replace("{:routing_id}", "$routingID", $sql);
        $sql = str_replace("{:userID}", "$usr_ID", $sql);
        $sql = str_replace("{:actToPrfm}", "$actyp", $sql);
//echo $sql;{:actToPrfm}
        $rtrn_msg = executeActionOnMsg($sql);
        $dsply = str_replace("|SUCCESS|", "", $rtrn_msg);
        $dsply = str_replace("|ERROR|", "", $rtrn_msg);
        if (strpos($rtrn_msg, "|SUCCESS|") === FALSE) {
            $dsply = "<p style=\"text-align:left;font-weight:bold;font-style:italic; color:red;\">$dsply</p>";
        } else {
            $dsply = "<p style=\"text-align:left;font-weight:bold;font-style:italic; color:green;\">$dsply</p>";
        }
        echo $dsply;
    }
}

function downloadForm() {
    global $RoutingID;
    global $smplTokenWord1;

    $msgID = getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "msg_id", $RoutingID);
    $attchmnts = getGnrlRecNm("wkf.wkf_actual_msgs_hdr", "msg_id", "attchments", $msgID);
    $attchments_desc = getGnrlRecNm("wkf.wkf_actual_msgs_hdr", "msg_id", "attchments_desc", $msgID);

    $output = "<!-- Form Code Start -->
<div id='rho_form222'>";
    $output .= "<table style=\"width:100%;border-collapse: collapse;border-spacing: 0;margin-top:10px;\" class=\"gridtable\"><tbody>";
    $arry1 = explode(";", $attchmnts);
    $arry2 = explode(";", $attchments_desc);
    for ($r = 0; $r < count($arry1); $r++) {
        if ($arry1[$r] !== "") {
            $arry1[$r] = encrypt1($arry1[$r], $smplTokenWord1);
            $hrf1 = "<tr><td><div style=\"padding:2px;float:none;\">"
                    . "<a class=\"x-btn-default-small\" style=\"color:#fff;text-decoration:none;\" "
                    . "href=\"javascript: dwnldAjxCall('grp=1&typ=11&q=Download&fnm=$arry1[$r]','FileNo$r');\">" . "File No." . ($r + 1) . "-" . $arry2[$r] . " ";
            $hrf2 = "</a></div></td><td><div id=\"FileNo$r\"></div></td></tr>";
            $output.="$hrf1" . "" . "$hrf2";
        }
    }
    $output .= "</tbody></table>";
    echo $output;
}

function inbxFormDetl($dsply) {
    global $RoutingID;
    $srchFor = "%";
    $srchIn = "Message Status";
    $lmtSze = "1";
    $navPos = "first";
    $curIdx = "0";
    $result1 = get_MyInbxDetl($RoutingID, $srchFor, $srchIn, $curIdx, $lmtSze);

    $recCnt = loc_db_num_rows($result1);
    $startIdx = 0;
    $endIdx = 0;
    if ($recCnt > 0) {
        $startIdx = ($curIdx * $lmtSze) + 1;
        $endIdx = $startIdx + $recCnt - 1;
    }
    $output = "<!-- Form Code Start -->
<div id='rho_form222'>
<form id='myInbxForm' action='' method='post' accept-charset='UTF-8'>

<span>$dsply</span>
<input type='hidden' name='submitted' id='submitted' value='1'/>
";
    $output .= createInbxRecsDtl($result1, $startIdx, $srchIn, $srchFor, $lmtSze);
    $output.="<div id=\"mydialog\" title=\"Basic dialog\" style=\"display:none;\">
</div>";
    echo $output;
}

if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0) {
        if ($qstr == "view") {
            $in_org_id = getUserOrgID($user_Name);
            if ($_SESSION['ROLE_SET_IDS'] == "" && $in_org_id > 0 && $srctyp == "lgn") {

                $result1 = get_Users_Roles("%", "Role Name", 0, 10000000);
                $selectedRoles = "";
                while ($row = loc_db_fetch_array($result1)) {
                    $selectedRoles.= $row[0] . ";";
                }
                $in_org_nm = getOrgName($in_org_id);
                $_SESSION['ROLE_SET_IDS'] = rtrim($selectedRoles, ";");
                $_SESSION['ORG_NAME'] = $in_org_nm;
                $_SESSION['ORG_ID'] = $in_org_id;
//echo "Load Inbox";
            }
//var_dump($_POST);
            if ($vwtyp == "0") {
//inbxFormTblr($dsply);
                $total = get_MyInbxTtls($srchFor, $srchIn);

                $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
                $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
                $start = isset($_POST['start']) ? $_POST['start'] : 0;
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                }

                $curIdx = $pageNo - 1;
                $result = get_MyInbx($srchFor, $srchIn, $curIdx, $lmtSze);
                $ntfctns = array();
                while ($row = loc_db_fetch_array($result)) {
                    $chckd = FALSE;
                    $ntfctn = array(
                        'checked' => var_export($chckd, TRUE),
                        'RoutingID' => $row[0],
                        'MsgID' => $row[1],
                        'MsgSubject' => $row[2],
                        'MsgSource' => $row[11],
                        'fromPerson' => $row[3],
                        'DateSent' => $row[5],
                        'MsgStatus' => $row[8],
                        'ActionsToPerform' => $row[9],
                        'isActionDone' => $row[10],
                        'toPersonName' => $row[13],
                        'MsgType' => $row[14],
                        'fromPersonLocID' => $row[15]);
                    $ntfctns[] = $ntfctn;
                }

                echo json_encode(array('success' => true,
                    'total' => $total,
                    'rows' => $ntfctns));
            } else if ($vwtyp == "1") {
                inbxFormDetl($dsply);
            } else if ($vwtyp == "2") {
                downloadForm();
            } else if ($vwtyp == "101") {
                //echo reassignForm();
            } else if ($vwtyp == "102") {
                //var_dump($formArray);
                echo saveReassignForm();
            } else {
                //echo "Please Login First!"; 
                //restricted();
            }
        } else if ($qstr == "act" && $RoutingID > 0) {
            /* 1. Get web url behind this action
             * 2. if Web url is direct use header location
             * 3. else if dialog use ajax call into 
             */
            $usrID = $_SESSION['USRID'];
            $arry1 = explode(";", $actyp);
            for ($r = 0; $r < count($arry1); $r++) {
                if ($arry1[$r] !== "") {
                    actOnMsgSQL($RoutingID, $usrID, $arry1[$r]);
                }
            }
        } else {
            //var_dump($_POST);
        }
    } else {
        sessionInvalid();
    }
}
?>
