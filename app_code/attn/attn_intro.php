<?php

$menuItems = array("My Events Attended", "My Assigned Events",
    "Attendance Registers", "Time Tables", "Activities/Events",
    "Venues", "Attendance Search");
$menuImages = array("calendar2.png", "Calander.png", "openfileicon.png", "chcklst1.png",
    "Folder.png", "house_72.png", "search.png", "98.png");

$mdlNm = "Events And Attendance";
$ModuleName = $mdlNm;
$pageHtmlID = "eventsPage";

$dfltPrvldgs = array("View Events And Attendance",
    /* 1 */ "View Attendance Records", "View Time Tables", "View Events",
    /* 4 */ "View Venues", "View Attendance Search", "View SQL", "View Record History",
    /* 8 */ "Add Attendance Records", "Edit Attendance Records", "Delete Attendance Records",
    /* 11 */ "Add Time Tables", "Edit Time Tables", "Delete Time Tables",
    /* 14 */ "Add Events", "Edit Events", "Delete Events",
    /* 17 */ "Add Venues", "Edit Venues", "Delete Venues",
    /* 20 */ "Add Event Results", "Edit Event Results", "Delete Event Results",
    /* 23 */ "View Adhoc Registers", "Add Adhoc Registers", "Edit Adhoc Registers", "Delete Adhoc Registers",
    /* 27 */ "View Event Cost", "Add Event Cost", "Edit Event Cost", "Delete Event Cost");
$canview = test_prmssns($dfltPrvldgs[0], $mdlNm) || test_prmssns("View Events/Attendances", "Self Service");

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
        $cntent = "<div id='rho_form' style=\"min-height:150px;width:90%;\">
                <fieldset style=\"padding:5px 5px 5px 5px;margin:0px 0px 0px 0px !important;\">
                    <div style=\"margin-bottom:2px;\">
                    <!--<h2>Welcome to the Events/Attendance Records Manager Module</h2>-->
                    </div>                    
                    <div class='rho_form3' style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:5px 30px 5px 40px;\" class=\"rho-postcontent rho-postcontent-0 clearfix\">                    
      <h3>FUNCTIONS UNDER THE EVENTS/ATTENDANCE RECORDS MANAGER</h3>
      <div class='rho_form44' style=\"padding:5px 30px 5px 10px;margin-bottom:1px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">Events assigned to you, Your Attendance History and CPD Points Earned as well as Exam Scores can be seen here. The module has the ff areas:</span>
                    </div> 
      <p>";
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($i == 0) {
                
            } else if ($i == 1) {
                //continue;
            } else if ($i == 2 && test_prmssns($dfltPrvldgs[1], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 3 && test_prmssns($dfltPrvldgs[2], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 4 && test_prmssns($dfltPrvldgs[3], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 5 && test_prmssns($dfltPrvldgs[4], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 6 && test_prmssns($dfltPrvldgs[5], $mdlNm) == FALSE) {
                continue;
            }
            if ($grpcntr == 0) {
                $cntent.= "<div style=\"float:none;\">"
                        . "<ul class=\"no_bullet\" style=\"float:none;\">";
            }

            $cntent.= "<li class=\"leaf\" style=\"margin:5px 2px 5px 2px;\">"
                    . "<a href=\"javascript: showPageDetails('$pageHtmlID', $No);\" class=\"x-btn x-unselectable x-btn-default-large\" "
                    . "style=\"padding:0px;height:90px;width:140px;margin:5px 2px 5px 2px;\" "
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
    } else if ($pgNo == 1) {

        //Get My Events Attended
        $prsnid = $_SESSION['PRSN_ID'];
        if ($vwtyp == 0) {

            $total = get_MyEvntsAttndTtl($srchFor, $srchIn, $prsnid);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_MyEvntsAttndTblr($srchFor, $srchIn, $curIdx, $lmtSze, $prsnid);
            $myEvntsAttnds = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                $chckd = ($cntr == 0) ? TRUE : FALSE;
                $myEvntsAttnd = array(
                    'checked' => var_export($chckd, TRUE),
                    'AttnRecID' => $row[0],
                    'AttnRqstID' => -1,
                    'AttnRgstrID' => $row[1],
                    'RegNameNum' => $row[2],
                    'EventNameDesc' => $row[3],
                    'EventStartDate' => $row[4],
                    'EventEndDate' => $row[5],
                    'TimeIn' => $row[9],
                    'TimeOut' => $row[10],
                    'IsPresent' => $row[11],
                    'LnkdFirm' => $row[12],
                    'InvoiceNumber' => $row[13],
                    'InvcTtl' => $row[14],
                    'OutstndngBalance' => $row[16],
                    'CPDPoints' => $row[19],
                    'Remarks' => $row[17],
                    'WkfMsgID' => -1,
                    'Status' => 'Completed Successfully',
                    'Attachments' => '');
                $myEvntsAttnds[] = $myEvntsAttnd;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $myEvntsAttnds));
        } else {
            restricted();
        }
    } else if ($pgNo == 2) {
        //require "prs_data_chng_rqst.php";
    } else {
        restricted();
    }
} else {
    restricted();
}

function get_MyEvntsAttndTblr($searchFor, $searchIn, $offset, $limit_size, $prsnID) {
    $wherecls = "";
    $wherecls1 = "";
    $orgID = $_SESSION['ORG_ID'];
//"Message Header", "Message Date", "Message Status", "Source App", "Source Module"
    if ($searchIn === "Name/Number") {
        $wherecls = "(c.recs_hdr_name ilike '" .
                loc_db_escape_string($searchFor) . "' or c.recs_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
        $wherecls1 = "('' || a.pymnt_req_hdr_id ilike '" .
                loc_db_escape_string($searchFor) . "' or a.pymnt_req_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }

    $strSql = "SELECT attnd_rec_id mt, a.recs_hdr_id m1, 
        c.recs_hdr_name reg_name, 
        c.recs_hdr_desc hdrdesc, c.event_date, c.end_date, person_id m2, 
	'''' || prs.get_prsn_loc_id(a.person_id) id_no, 
      CASE WHEN a.customer_id <= 0 and a.person_id <= 0 THEN a.visitor_name_desc 
           WHEN a.person_id>0 THEN prs.get_prsn_surname(a.person_id) || ' (' || prs.get_prsn_loc_id(a.person_id) || ')' 
            ELSE scm.get_cstmr_splr_name(a.customer_id) END partcpnt_name, 
      CASE WHEN a.date_time_in != '' THEN to_char(to_timestamp(a.date_time_in,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') ELSE '' END timein, 
      CASE WHEN a.date_time_out != '' THEN to_char(to_timestamp(a.date_time_out,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') ELSE '' END timeout,
      CASE WHEN a.is_present='1' THEN 'YES' ELSE 'NO' END ispresent, 
	scm.get_cstmr_splr_name(a.sponsor_id) linked_firm,
      tbl1.invc_number invc_num, 
	COALESCE(tbl1.invoice_amnt,0) invc_ttl, 
	COALESCE(tbl1.amnt_paid,0) amnt_paid, 
	COALESCE(tbl1.amnt_left,0) balance, 
	a.attn_comments remarks,
      a.visitor_classfctn classification,
      a.point_scored1 cpd_points, 
	a.no_of_persons m3, 0 m4, a.customer_id m5, a.sponsor_id m6
  FROM attn.attn_attendance_recs a
  LEFT OUTER JOIN attn.attn_attendance_recs_hdr c ON (a.recs_hdr_id = c.recs_hdr_id) 
  LEFT OUTER JOIN (SELECT DISTINCT w.check_in_id, w.doc_num, y.invc_number, w.customer_id, 
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','5Grand Total') invoice_amnt,
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','6Total Payments Received')+
	    scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','8Deposits') amnt_paid,
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','9Actual_Change/Balance') amnt_left 
	FROM hotl.checkins_hdr w 
	LEFT OUTER JOIN hotl.service_types d ON (w.service_type_id=d.service_type_id )
	LEFT OUTER JOIN hotl.rooms b ON (w.service_det_id = b.room_id)
	LEFT OUTER JOIN scm.scm_sales_invc_hdr y ON ((w.check_in_id = y.other_mdls_doc_id or 	(w.prnt_chck_in_id=y.other_mdls_doc_id and y.other_mdls_doc_id>0))
	and (w.doc_type=y.other_mdls_doc_type or (w.prnt_doc_typ=y.other_mdls_doc_type and w.prnt_doc_typ != ''))) 
	WHERE (w.sponsor_id IN (select c.cust_sup_id from scm.scm_cstmr_suplr c where c.cust_sup_name ilike '%') or 
	w.customer_id IN (select c.cust_sup_id from scm.scm_cstmr_suplr c where c.cust_sup_name ilike '%')) 
	and COALESCE(d.org_id, 1)=$orgID and w.doc_type IN ('Booking','Check-In') 
	and w.fclty_type IN ('Event')) tbl1  ON (a.customer_id = tbl1.customer_id)
   WHERE($wherecls(a.person_id = $prsnID) and ((CASE WHEN a.customer_id <= 0 and a.person_id <= 0 THEN a.visitor_name_desc 
           WHEN a.person_id>0 THEN prs.get_prsn_surname(a.person_id) || ' (' || prs.get_prsn_loc_id(a.person_id) || ')' 
            ELSE scm.get_cstmr_splr_name(a.customer_id)||scm.get_cstmr_splr_name(a.sponsor_id) END) ilike '%')) 
	ORDER BY 5, 4, 1 LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    //echo $strSql;
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_MyEvntsAttndTtl($searchFor, $searchIn, $prsnID) {
    $wherecls = "";
    $wherecls1 = "";
    $orgID = $_SESSION['ORG_ID'];
//"Message Header", "Message Date", "Message Status", "Source App", "Source Module"
    if ($searchIn === "Name/Number") {
        $wherecls = "(c.recs_hdr_name ilike '" .
                loc_db_escape_string($searchFor) . "' or c.recs_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";

        $wherecls1 = "('' || a.pymnt_req_hdr_id ilike '" .
                loc_db_escape_string($searchFor) . "' or a.pymnt_req_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }

    $strSql = "SELECT count(1) 
  FROM attn.attn_attendance_recs a
  LEFT OUTER JOIN attn.attn_attendance_recs_hdr c ON (a.recs_hdr_id = c.recs_hdr_id) 
  LEFT OUTER JOIN (SELECT DISTINCT w.check_in_id, w.doc_num, y.invc_number, w.customer_id, 
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','5Grand Total') invoice_amnt,
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','6Total Payments Received')+
	    scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','8Deposits') amnt_paid,
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','9Actual_Change/Balance') amnt_left 
	FROM hotl.checkins_hdr w 
	LEFT OUTER JOIN hotl.service_types d ON (w.service_type_id=d.service_type_id )
	LEFT OUTER JOIN hotl.rooms b ON (w.service_det_id = b.room_id)
	LEFT OUTER JOIN scm.scm_sales_invc_hdr y ON ((w.check_in_id = y.other_mdls_doc_id or 	(w.prnt_chck_in_id=y.other_mdls_doc_id and y.other_mdls_doc_id>0))
	and (w.doc_type=y.other_mdls_doc_type or (w.prnt_doc_typ=y.other_mdls_doc_type and w.prnt_doc_typ != ''))) 
	WHERE (w.sponsor_id IN (select c.cust_sup_id from scm.scm_cstmr_suplr c where c.cust_sup_name ilike '%') or 
	w.customer_id IN (select c.cust_sup_id from scm.scm_cstmr_suplr c where c.cust_sup_name ilike '%')) 
	and COALESCE(d.org_id, 1)=$orgID and w.doc_type IN ('Booking','Check-In') 
	and w.fclty_type IN ('Event')) tbl1  ON (a.customer_id = tbl1.customer_id)
   WHERE($wherecls(a.person_id = $prsnID) and ((CASE WHEN a.customer_id <= 0 and a.person_id <= 0 THEN a.visitor_name_desc 
           WHEN a.person_id>0 THEN prs.get_prsn_surname(a.person_id) || ' (' || prs.get_prsn_loc_id(a.person_id) || ')' 
            ELSE scm.get_cstmr_splr_name(a.customer_id)||scm.get_cstmr_splr_name(a.sponsor_id) END) ilike '%')) ";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

?>
