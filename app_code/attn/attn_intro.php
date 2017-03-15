<?php

$menuItems = array("My Events Attended"/*, "My Assigned Events"*/,
    "Attendance Registers", "Time Tables", "Activities/Events",
    "Venues", "Attendance Search");
$menuImages = array("calendar2.png"/*, "Calander.png"*/, "openfileicon.png", "chcklst1.png",
    "Folder.png", "house_72.png", "search.png", "98.png");

$mdlNm = "Events And Attendance";
$ModuleName = $mdlNm;

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
						<span style=\"text-decoration:none;\">All Modules&nbsp;</span><span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>"
                                      . "<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">Events & Attendance Menu</span>
					</li>";

if ($lgn_num > 0 && $canview === true) {
    if ($pgNo == 0) {

        $cntent .= "</ul>
                                     </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
      <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">Events assigned to you, Your Attendance History and CPD Points Earned as well as Exam Scores can be seen here. The module has the ff areas:</span>
                    </div>
      <p>";
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($i == 0) {
                
            } /*else if ($i == 1) {
                //continue;
            }*/ else if ($i == 1 && test_prmssns($dfltPrvldgs[1], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 2 && test_prmssns($dfltPrvldgs[2], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 3 && test_prmssns($dfltPrvldgs[3], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 4 && test_prmssns($dfltPrvldgs[4], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 5 && test_prmssns($dfltPrvldgs[5], $mdlNm) == FALSE) {
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
        //Get My Events Attended
        require 'my_evnts_attn.php';
    } else if ($pgNo == 2) {
        //Events Assigned;
        require 'my_evnts_asgnd.php';
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

    $strSql = "SELECT attnd_rec_id mt, 
        a.recs_hdr_id m1, 
        c.recs_hdr_name reg_name, 
        c.recs_hdr_desc hdrdesc, 
        to_char(to_timestamp(c.event_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS'), 
        to_char(to_timestamp(c.end_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS'), 
        person_id m2, 
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
	a.no_of_persons m3, 
        0 m4, 
        a.customer_id m5, 
        a.sponsor_id m6,
        attn.getevntamntbilled(a.recs_hdr_id, a.customer_id), 
        attn.getEvntAmntPaid(a.recs_hdr_id, a.customer_id)
  FROM attn.attn_attendance_recs a
  LEFT OUTER JOIN attn.attn_attendance_recs_hdr c ON (a.recs_hdr_id = c.recs_hdr_id) 
  LEFT OUTER JOIN (SELECT DISTINCT w.check_in_id, w.doc_num, y.invc_number, w.customer_id, 
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','5Grand Total') invoice_amnt,
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','6Total Payments Received')+
	    scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','8Deposits') amnt_paid,
            scm.get_doc_smry_typ_amnt(y.invc_hdr_id,'Sales Invoice','9Actual_Change/Balance') amnt_left,
            y.event_doc_type,
            y.event_rgstr_id
	FROM hotl.checkins_hdr w 
	LEFT OUTER JOIN hotl.service_types d ON (w.service_type_id=d.service_type_id )
	LEFT OUTER JOIN hotl.rooms b ON (w.service_det_id = b.room_id)
	LEFT OUTER JOIN scm.scm_sales_invc_hdr y ON ((w.check_in_id = y.other_mdls_doc_id or 	(w.prnt_chck_in_id=y.other_mdls_doc_id and y.other_mdls_doc_id>0))
	and (w.doc_type=y.other_mdls_doc_type or (w.prnt_doc_typ=y.other_mdls_doc_type and w.prnt_doc_typ != ''))) 
	WHERE (w.sponsor_id IN (select c.cust_sup_id from scm.scm_cstmr_suplr c where c.cust_sup_name ilike '%') or 
	w.customer_id IN (select c.cust_sup_id from scm.scm_cstmr_suplr c where c.cust_sup_name ilike '%')) 
	and COALESCE(d.org_id, 1)=$orgID and w.doc_type IN ('Booking','Check-In') 
	and w.fclty_type IN ('Event')) tbl1  ON (a.customer_id = tbl1.customer_id  and tbl1.event_doc_type='Attendance Register' and tbl1.event_rgstr_id=a.recs_hdr_id)
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
