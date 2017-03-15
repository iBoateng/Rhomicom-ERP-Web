<?php

$menuItems = array("My Bills/Payment Slips", "Linked Customer Invoices", "Linked Supplier Invoices",
    "Quick Payments & Pay Setups", "Pay Item Sets",
    "Person Sets", "Bulk Pay / Bill Runs", "Payment Transactions",
    "GL Interface Table", "Pay Items", "Global Values");
$menuImages = array("bills.png", "invcBill.png", "invoice1.png", "pay.png",
    "wallet.png", "staffs.png", "bulkPay.png", "search.png",
    "GL-256.png", "chcklst4.png", "world_48.png");
$mdlNm = "Internal Payments";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Internal Payments",
    /* 1 */ "View Manual Payments", "View Pay Item Sets", "View Person Sets",
    /* 4 */ "View Mass Pay Runs", "View Payment Transactions", "View GL Interface Table",
    /* 7 */ "View Record History", "View SQL",
    /* 9 */ "Add Manual Payments", "Reverse Manual Payments",
    /* 11 */ "Add Pay Item Sets", "Edit Pay Item Sets", "Delete Pay Item Sets",
    /* 14 */ "Add Person Sets", "Edit Person Sets", "Delete Person Sets",
    /* 17 */ "Add Mass Pay", "Edit Mass Pay", "Delete Mass Pay", "Send Mass Pay Transactions to Actual GL",
    /* 21 */ "Send All Transactions to Actual GL", "Run Mass Pay",
    /* 23 */ "Rollback Mass Pay Run", "Send Selected Transactions to Actual GL",
    /* 25 */ "View Pay Items", "Add Pay Items", "Edit Pay Items", "Delete Pay Items",
    /* 29 */ "View Person Pay Item Assignments", "View Banks", "Add Pay Item Assignments",
    /* 32 */ "Edit Pay Item Assignments", "Delete Pay Item Assignments",
    /* 34 */ "View Global Values", "Add Global Values", "Edit Global Values", "Delete Global Values",
    /* 38 */ "View other User's Mass Pays");

$canview = test_prmssns($dfltPrvldgs[0], $mdlNm) || test_prmssns("View Internal Payments", "Self Service");

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

$srcMdl = isset($_POST['srcMdl']) ? $_POST['srcMdl'] : "pay";
$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
                                                <i class=\"fa fa-home\" aria-hidden=\"true\"></i>
						<span style=\"text-decoration:none;\">Home</span>
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>
					<li onclick=\"openATab('#allmodules', 'grp=40&typ=5');\">
						<span style=\"text-decoration:none;\">All Modules&nbsp;</span>
					</li>";

if ($lgn_num > 0 && $canview === true) {
    if ($srcMdl == "eVote") {
        $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=19&typ=10');\">
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
						<span style=\"text-decoration:none;\">e-Voting Menu</span>
					</li>";
    } else {
        $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
						<span style=\"text-decoration:none;\">Bills/Payments Menu</span>
					</li>";
    }
    if ($pgNo == 0) {
        $cntent .= "</ul>
                    </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
      <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is where Internal Payments and Bills in the Organisation are Captured and Managed. 
      For Customers, Suppliers and Registered Firms in the Organisation, your Invoices can be seen from here also. The module has the ff areas:</span>
                    </div>
      <p>";
        $grpcntr = 0;

        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            $sndVwTyp = 0;
            if ($i == 0) {
                
            } else if ($i == 1) {
                $sndVwTyp = 2;
            } else if ($i == 2) {
                $sndVwTyp = 4;
                //continue;
            } else if ($i == 3 && test_prmssns($dfltPrvldgs[1], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 4 && test_prmssns($dfltPrvldgs[2], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 5 && test_prmssns($dfltPrvldgs[3], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 6 && test_prmssns($dfltPrvldgs[4], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 7 && test_prmssns($dfltPrvldgs[5], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 8 && test_prmssns($dfltPrvldgs[6], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 9 && test_prmssns($dfltPrvldgs[25], $mdlNm) == FALSE) {
                continue;
            } else if ($i == 10 && test_prmssns($dfltPrvldgs[37], $mdlNm) == FALSE) {
                continue;
            }
            if ($grpcntr == 0) {
                $cntent .= "<div class=\"row\">";
            }

            $cntent .= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allmodules', 'grp=$group&typ=$type&pg=$No&vtyp=$sndVwTyp');\">
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
        flush();
        if ($usrName == "admin") {
            createPayDfltSets();
            createPayRqrdLOVs();
            createRqrdPayItems();
        }
    } else if ($pgNo == 1 || $pgNo == 2 || $pgNo == 3) {
        //Get My Bills/Payment Slips
        require 'my_bills_slips.php';
    } else if ($pgNo == 4) {
        require "quick_pymnts.php";
    } else if ($pgNo == 5) {
        require "pay_itm_sets.php";
    } else if ($pgNo == 6) {
        require "prsn_sets.php";
    } else if ($pgNo == 7) {
        require "bulk_pymnts.php";
    } else if ($pgNo == 8) {
        require "pymnt_trns.php";
    } else if ($pgNo == 9) {
        require "pymnts_gl_intrfc.php";
    } else if ($pgNo == 10) {
        require "pay_items.php";
    } else if ($pgNo == 11) {
        require "global_values.php";
    } else {
        restricted();
    }
} else {
    restricted();
}

function get_MyPyRnsDt($pyReqID, $mspyID, $prsnID) {
    $sqlStr = "SELECT tbl1.* FROM 
        (SELECT pymnt_req_id, payer_person_id, mass_pay_hdr_id, pymnt_req_hdr_id, 
       pymnt_trns_id, pay_item_id, org.get_payitm_nm(pay_item_id) itmNm, 
       round(a.amount_paid, 2), 
       to_char(to_timestamp(a.payment_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') payment_date, 
       line_description,
       org.get_payitm_effct(pay_item_id) effct,
       org.get_payitm_mintyp(pay_item_id) mintyp
  FROM self.self_prsn_intrnl_pymnts a
  WHERE (a.pymnt_req_id = " . $pyReqID . " and payer_person_id = " . $prsnID . ") "
            . " UNION "
            . "SELECT -1, a.person_id, a.mass_pay_id, -1, 
                a.pay_trns_id, a.item_id, org.get_payitm_nm(a.item_id) itmNm, 
                round(a.amount_paid, 2), 
                to_char(to_timestamp(a.paymnt_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') paymnt_date, 
                a.pymnt_desc,
       org.get_payitm_effct(a.item_id) effct,
       org.get_payitm_mintyp(a.item_id) mintyp
FROM pay.pay_itm_trnsctns a 
WHERE(a.mass_pay_id = " . $mspyID . " and person_id = " . $prsnID . " and a.pymnt_vldty_status='VALID' and a.src_py_trns_id<=0)) tbl1 "
            . " ORDER BY tbl1.pymnt_trns_id ASC";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_CumltiveBals($prsnID) {
    $sqlStr = "SELECT -1, a.person_id, -1, -1, -1, a.bals_itm_id, b.item_code_name itmNm, "
            . "round(a.bals_amount, 2) amount_paid, "
            . "to_char(to_timestamp(a.bals_date|| ' 12:00:00','YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') balsdte, "
            . "b.item_code_name,"
            . "b.effct_on_org_debt, "
            . "b.item_maj_type " .
            "FROM pay.pay_balsitm_bals a, org.org_pay_items b " .
            "WHERE((a.person_id = " . $prsnID . ") and (b.item_maj_type='Balance Item' "
            . "and b.balance_type='Cumulative' and a.bals_itm_id = b.item_id)"
            . " and (b.is_enabled = '1') and a.bals_date = (SELECT MAX(c.bals_date) FROM pay.pay_balsitm_bals c "
            . "WHERE c.person_id = " . $prsnID . " and a.bals_itm_id = c.bals_itm_id) "
            . "and (CASE WHEN a.bals_amount!=0 THEN 1 ELSE 0 END)=1) "
            . "ORDER BY a.bals_date DESC, b.item_code_name, b.pay_run_priority";
    /* WHEN b.item_code_name ilike '%2016%' "
      . "or b.item_code_name ilike '%2015%' "
      . "or b.item_code_name ilike '%2014%' THEN 1 "
      . " */
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getBatchItmTypCnt($pyReqID, $mspyID, $prsnID) {
    $sqlStr = "Select distinct org.get_payitm_mintyp(a.item_id) from pay.pay_itm_trnsctns a 
     WHERE(a.mass_pay_id = " . $mspyID . " and a.person_id = " . $prsnID . ")"
            . " UNION "
            . " Select distinct org.get_payitm_mintyp(a.pay_item_id) from self.self_prsn_intrnl_pymnts a 
     WHERE(a.pymnt_req_hdr_id = " . $pyReqID . " and a.payer_person_id = " . $prsnID . " and a.mass_pay_hdr_id<=0)";
    $result = executeSQLNoParams($sqlStr);
    return loc_db_num_rows($result);
}

$fnlColorAmntDffrnc = 0;

function getBatchNetAmnt($itmTypCnt, $itmTyp, $itmNm, $effctOnOrgDbt, $amnt, &$brghtTotal, &$prpsdTtlSpnColor) {
    /* Items Net Effect on Person's Organisational Debt
     * if(same itemtype in batch then + throughout)
     * Dues/Bills/Charges - (red) - increase
     * Dues/Bills/Charges Payments - (green) - decrease
     * 
     * Earnings - (green) - decrease
     * Payroll Deductions - (red) - increase
     * Payroll Staff Liability Balance - green - decrease
     * Employer Charges (None) (black)
     * Purely Informational (None) (black)
     * */
    global $fnlColorAmntDffrnc;
    $spnColor = "black";
    $mltplr = "+";
    if ($effctOnOrgDbt == "None") {
        $spnColor = "black";
    } else if ($effctOnOrgDbt == "Increase") {
        $spnColor = "red";
        $fnlColorAmntDffrnc = $fnlColorAmntDffrnc - $amnt;
        if ($itmTyp == "Bills/Charges") {
            $spnColor = "red";
            $brghtTotal = $brghtTotal + $amnt;
        } else {
            if ($itmTypCnt > 1 || $itmTyp == "Balance Item") {
                $mltplr = "-";
                $brghtTotal = $brghtTotal - $amnt;
            } else {
                $brghtTotal = $brghtTotal + $amnt;
            }
        }
    } else if ($effctOnOrgDbt == "Decrease") {
        $spnColor = "green";
        $fnlColorAmntDffrnc = $fnlColorAmntDffrnc + $amnt;
        $brghtTotal = $brghtTotal + $amnt;
    } else {
        if ($itmTyp == "Bills/Charges") {
            $spnColor = "red";
            $fnlColorAmntDffrnc = $fnlColorAmntDffrnc - $amnt;
            $brghtTotal = $brghtTotal + $amnt;
        } else if ($itmTyp == "Deductions") {
            if (strpos($itmNm, "(Payment)") !== FALSE || $itmNm == "Advance Payments Amount Kept") {
                $spnColor = "green";
                $fnlColorAmntDffrnc = $fnlColorAmntDffrnc + $amnt;
            } else {
                $spnColor = "red";
                $fnlColorAmntDffrnc = $fnlColorAmntDffrnc - $amnt;
            }
            if ($itmTypCnt > 1) {
                $mltplr = "-";
                $brghtTotal = $brghtTotal - $amnt;
            } else {
                $brghtTotal = $brghtTotal + $amnt;
            }
        } else if ($itmTyp == "Earnings") {
            $spnColor = "green";
            $fnlColorAmntDffrnc = $fnlColorAmntDffrnc + $amnt;
            if ($itmNm == "Advance Payments Amount Applied") {
                if ($itmTypCnt > 1) {
                    $mltplr = "-";
                    $brghtTotal = $brghtTotal - $amnt;
                } else {
                    $brghtTotal = $brghtTotal + $amnt;
                }
            } else {
                $brghtTotal = $brghtTotal + $amnt;
            }
        } else {
            $spnColor = "black";
        }
    }
    if ($brghtTotal >= 0 && $fnlColorAmntDffrnc >= 0) {
        $prpsdTtlSpnColor = "green";
    } else {
        $prpsdTtlSpnColor = "red";
    }
    if ($mltplr == "-") {
        return "<span style=\"color:$spnColor;\">" . round((float) (-1 * $amnt), 2) . "</span>";
    } else {
        return "<span style=\"color:$spnColor;\">" . $amnt . "</span>";
    }
}

function get_MyPyHdrDet($pyReqID, $mspyID, $prsnID) {
    $strSql = "SELECT tbl1.* FROM (
        SELECT -1 pay_red_hdr_id, -1 mass_pay_hdr_id, 
        'CUMULATIVE BALANCES' mspy_name, 
        'ALL-TIME OUTSTANDING BALANCES', 
        -1 wkfMsgID,
        'Completed Succesfully' status, 
        to_char(now(),'DD-MMM-YYYY HH24:MI:SS') pay_date, 
        '' attachments "
            . " UNION "
            . " SELECT -1 pay_red_hdr_id, a.mass_pay_id, 
        REPLACE((CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END),'Quick Pay Run','Quick Run of Items') mspy_name, 
        REPLACE((CASE WHEN a.mass_pay_desc!='' THEN a.mass_pay_desc ELSE (CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END) END),'Quick Pay Run','Quick Run of Items'), 
        -1 wkfMsgID,
        CASE WHEN a.run_status='1' AND a.sent_to_gl='1' THEN 'Completed Succesfully' ELSE 'Incomplete' END status, 
        to_char(to_timestamp(a.mass_pay_trns_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') pay_date, '' attachments 
      FROM pay.pay_mass_pay_run_hdr a 
      WHERE (((Select count(1) from pay.pay_itm_trnsctns z where z.person_id = " . $prsnID .
            " and z.mass_pay_id = a.mass_pay_id and z.pymnt_vldty_status='VALID' and z.src_py_trns_id<=0)>=1) AND (org_id = " . $_SESSION['ORG_ID'] .
            ")) "
            . " UNION "
            . "SELECT pymnt_req_hdr_id, mass_pay_hdr_id, ''||pymnt_req_hdr_id, pymnt_req_hdr_desc, 
       wkf_msg_id, status, to_char(to_timestamp(a.payment_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS'), attachments
  FROM self.self_prsn_intrnl_pymnts_hdr a 
  WHERE (((Select count(1) from self.self_prsn_intrnl_pymnts z where z.payer_person_id = " . $prsnID .
            " and z.pymnt_req_hdr_id = a.pymnt_req_hdr_id)>=1))) tbl1 "
            . "WHERE tbl1.pay_red_hdr_id=$pyReqID and tbl1.mass_pay_hdr_id =$mspyID ";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_MyPyRnsTblr($searchFor, $searchIn, $offset, $limit_size, $prsnID) {
    $wherecls = "";
    $wherecls1 = "";
    if ($searchIn === "Name/Number") {
        $wherecls = "(a.mass_pay_name ilike '" .
                loc_db_escape_string($searchFor) . "' or a.mass_pay_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
        $wherecls1 = "('' || a.pymnt_req_hdr_id ilike '" .
                loc_db_escape_string($searchFor) . "' or a.pymnt_req_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }

    $strSql = "SELECT tbl1.* FROM (
        SELECT -1 pay_red_hdr_id, -1, 
        'CUMULATIVE BALANCES' mspy_name, 
        'ALL TIME ITEM BALANCES', 
        -1 wkfMsgID,
        'Completed Succesfully' status, 
        to_char(now(),'YYYY-MM-DD HH24:MI:SS') pay_date, 
        '' attachments,-1,-1,'1','','', '0' "
            . " UNION "
            . " SELECT -1 pay_red_hdr_id, 
                a.mass_pay_id, 
        CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END mspy_name, 
        a.mass_pay_desc, 
        -1 wkfMsgID,
        CASE WHEN a.run_status='1' AND a.sent_to_gl='1' THEN 'Completed Succesfully' ELSE 'Incomplete' END status, 
        a.mass_pay_trns_date pay_date, 
        '' attachments,
        a.prs_st_id,
        a.itm_st_id,
        pay.get_prs_st_name(a.prs_st_id),
        pay.get_itm_st_name(a.itm_st_id),
        a.run_status,
        a.sent_to_gl
      FROM pay.pay_mass_pay_run_hdr a 
      WHERE ($wherecls((Select count(1) from pay.pay_itm_trnsctns z where z.person_id = " . $prsnID .
            " and z.mass_pay_id = a.mass_pay_id and z.pymnt_vldty_status='VALID' and z.src_py_trns_id<=0)>=1) AND (org_id = " . $_SESSION['ORG_ID'] .
            ")) "
            . " UNION "
            . "SELECT pymnt_req_hdr_id, mass_pay_hdr_id, ''||pymnt_req_hdr_id, pymnt_req_hdr_desc, 
       wkf_msg_id, status, payment_date, attachments,-1,-1,'','', CASE WHEN mass_pay_hdr_id>0 THEN '1' ELSE '0' END,COALESCE((select z.sent_to_gl from pay.pay_mass_pay_run_hdr z where z.mass_pay_id=a.mass_pay_hdr_id),'0')
  FROM self.self_prsn_intrnl_pymnts_hdr a 
  WHERE ($wherecls1((Select count(1) from self.self_prsn_intrnl_pymnts z where z.payer_person_id = " . $prsnID .
            " and z.pymnt_req_hdr_id = a.pymnt_req_hdr_id)>=1) and a.mass_pay_hdr_id<=0)) tbl1 "
            . "ORDER BY tbl1.pay_date DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    //echo $strSql;
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_MyPyRnsTtl($searchFor, $searchIn, $prsnID) {
    $wherecls = "";
    $wherecls1 = "";
//"Message Header", "Message Date", "Message Status", "Source App", "Source Module"
    if ($searchIn === "Name/Number") {
        $wherecls = "(a.mass_pay_name ilike '" .
                loc_db_escape_string($searchFor) . "' or a.mass_pay_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
        $wherecls1 = "('' || a.pymnt_req_hdr_id ilike '" .
                loc_db_escape_string($searchFor) . "' or a.pymnt_req_hdr_desc ilike '" .
                loc_db_escape_string($searchFor) . "') and ";
    }

    $strSql = "SELECT count(1) FROM (
        SELECT -1 pay_red_hdr_id, -1, 
        'CUMULATIVE BALANCES' mspy_name, 
        'ALL TIME ITEM BALANCES', 
        -1 wkfMsgID,
        'Completed Succesfully' status, 
        to_char(now(),'YYYY-MM-DD HH24:MI:SS') pay_date, 
        '' attachments,-1,-1,'1','','', '0' "
            . " UNION "
            . " SELECT -1 pay_red_hdr_id, 
                a.mass_pay_id, 
        CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END mspy_name, 
        a.mass_pay_desc, 
        -1 wkfMsgID,
        CASE WHEN a.run_status='1' AND a.sent_to_gl='1' THEN 'Completed Succesfully' ELSE 'Incomplete' END status, 
        a.mass_pay_trns_date pay_date, 
        '' attachments,
        a.prs_st_id,
        a.itm_st_id,
        pay.get_prs_st_name(a.prs_st_id),
        pay.get_itm_st_name(a.itm_st_id),
        a.run_status,
        a.sent_to_gl
      FROM pay.pay_mass_pay_run_hdr a 
      WHERE ($wherecls((Select count(1) from pay.pay_itm_trnsctns z where z.person_id = " . $prsnID .
            " and z.mass_pay_id = a.mass_pay_id and z.pymnt_vldty_status='VALID' and z.src_py_trns_id<=0)>=1) AND (org_id = " . $_SESSION['ORG_ID'] .
            ")) "
            . " UNION "
            . "SELECT pymnt_req_hdr_id, mass_pay_hdr_id, ''||pymnt_req_hdr_id, pymnt_req_hdr_desc, 
       wkf_msg_id, status, payment_date, attachments,-1,-1,'','', CASE WHEN mass_pay_hdr_id>0 THEN '1' ELSE '0' END,COALESCE((select z.sent_to_gl from pay.pay_mass_pay_run_hdr z where z.mass_pay_id=a.mass_pay_hdr_id),'0')
  FROM self.self_prsn_intrnl_pymnts_hdr a 
  WHERE ($wherecls1((Select count(1) from self.self_prsn_intrnl_pymnts z where z.payer_person_id = " . $prsnID .
            " and z.pymnt_req_hdr_id = a.pymnt_req_hdr_id)>=1) and a.mass_pay_hdr_id<=0)) tbl1 ";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_Basic_QuickPy(
$searchWord, $searchIn, $offset, $limit_size, $prsnID) {
    $strSql = "";
    $whereCls = "";
    if ($searchIn == "Mass Pay Run Name") {
        $whereCls = "(a.mass_pay_name ilike '" . loc_db_escape_string($searchWord) .
                "' or a.mass_pay_id<=0)and ";
    } else if (searchIn == "Mass Pay Run Description") {
        $whereCls = "(a.mass_pay_desc ilike '" . loc_db_escape_string($searchWord) .
                "' or a.mass_pay_id<=0) and ";
    }

    $strSql = "SELECT a.mass_pay_id, CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END, a.mass_pay_desc, a.run_status, 
        to_char(to_timestamp(a.mass_pay_trns_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS')
      , a.prs_st_id, a.itm_st_id, a.sent_to_gl, to_char(to_timestamp(a.gl_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') 
      FROM pay.pay_mass_pay_run_hdr a WHERE (($whereCls(Select count(1) from pay.pay_itm_trnsctns z where z.person_id = " . $prsnID .
            " and z.mass_pay_id = a.mass_pay_id)>=1) AND (org_id = " . $_SESSION['ORG_ID'] .
            ") AND (prs_st_id<=0)) ORDER BY a.mass_pay_id DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);

    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_One_MsPyDet($offset, $limit_size, $mspyid) {
    $strSql = "SELECT a.pay_trns_id, a.person_id, a.item_id, a.amount_paid, 
to_char(to_timestamp(a.paymnt_date,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS')
, a.paymnt_source, a.pay_trns_type, a.pymnt_desc, -1, a.crncy_id, c.local_id_no, trim(c.title || ' ' || c.sur_name || 
', ' || c.first_name || ' ' || c.other_names) fullname, b.item_code_name, a.pymnt_vldty_status 
FROM (pay.pay_itm_trnsctns a LEFT OUTER JOIN org.org_pay_items b ON a.item_id = b.item_id) 
LEFT OUTER JOIN prs.prsn_names_nos c on a.person_id = c.person_id 
WHERE(a.mass_pay_id = " . $mspyid . ") ORDER BY a.pay_trns_id LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);

    $result = executeSQLNoParams($strSql);
    /* @var $result type */
    return $result;
}

function get_RcvblsDocHdr($searchWord, $searchIn, $offset, $limit_size, $orgID, $shwUnpstdOnly, $cstmrID = -1) {
    $strSql = "";
    $whrcls = "";
    /* Document Number
      Document Description
      Document Classification
      Customer Name
      Customer's Doc. Number
      Source Doc Number
      Approval Status
      Created By
      Currency */
    $unpstdCls = "";
    if ($shwUnpstdOnly) {
        $unpstdCls = " AND (round(a.invoice_amount-a.amnt_paid,2)>0 or a.approval_status IN ('Not Validated','Validated','Reviewed'))";
    }
    if ($searchIn == "Document Number") {
        $whrcls = " and (a.rcvbls_invc_number ilike '" . loc_db_escape_string($searchWord) . "' or trim(to_char(a.rcvbls_invc_hdr_id, '99999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "')";
    } else if ($searchIn == "Document Description") {
        $whrcls = " and (a.comments_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Document Classification") {
        $whrcls = " and (a.doc_tmplt_clsfctn ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Customer Name") {
        $whrcls = " and (a.customer_id IN (select c.cust_sup_id from 
scm.scm_cstmr_suplr c where c.cust_sup_name ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Customer's Doc. Number") {
        $whrcls = " and (a.cstmrs_doc_num ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Source Doc Number") {
        $whrcls = " and (a.src_doc_hdr_id IN (select d.invc_hdr_id from scm.scm_sales_invc_hdr d 
where d.invc_number ilike '" . loc_db_escape_string($searchWord) .
                "') or a.src_doc_hdr_id IN (select f.rcvbls_invc_hdr_id from accb.accb_rcvbls_invc_hdr f
where f.rcvbls_invc_number ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Approval Status") {
        $whrcls = " and (a.approval_status ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Created By") {
        $whrcls = " and (sec.get_usr_name(a.created_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Currency") {
        $whrcls = " and (gst.get_pssbl_val(a.invc_curr_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $whrcls .= " and (a.customer_id IN ($cstmrID))";
    $strSql = "SELECT rcvbls_invc_hdr_id, rcvbls_invc_number, 
rcvbls_invc_type, round(a.invoice_amount-a.amnt_paid,2),
 a.approval_status, a.src_doc_hdr_id, a.src_doc_type
        FROM accb.accb_rcvbls_invc_hdr a 
        WHERE((a.org_id = " . $orgID . ")" . $whrcls . $unpstdCls .
            ") ORDER BY rcvbls_invc_hdr_id DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);

    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RcvblsDocHdrTtl($searchWord, $searchIn, $orgID, $shwUnpstdOnly, $cstmrID = -1) {
    $strSql = "";
    $whrcls = "";
    /* Document Number
      Document Description
      Document Classification
      Customer Name
      Customer's Doc. Number
      Source Doc Number
      Approval Status
      Created By
      Currency */
    $unpstdCls = "";
    if ($shwUnpstdOnly) {
        $unpstdCls = " AND (round(a.invoice_amount-a.amnt_paid,2)>0 or a.approval_status IN ('Not Validated','Validated','Reviewed'))";
    }
    if ($searchIn == "Document Number") {
        $whrcls = " and (a.rcvbls_invc_number ilike '" . loc_db_escape_string($searchWord) . "' or trim(to_char(a.rcvbls_invc_hdr_id, '99999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "')";
    } else if ($searchIn == "Document Description") {
        $whrcls = " and (a.comments_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Document Classification") {
        $whrcls = " and (a.doc_tmplt_clsfctn ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Customer Name") {
        $whrcls = " and (a.customer_id IN (select c.cust_sup_id from 
scm.scm_cstmr_suplr c where c.cust_sup_name ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Customer's Doc. Number") {
        $whrcls = " and (a.cstmrs_doc_num ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Source Doc Number") {
        $whrcls = " and (a.src_doc_hdr_id IN (select d.invc_hdr_id from scm.scm_sales_invc_hdr d 
where d.invc_number ilike '" . loc_db_escape_string($searchWord) .
                "') or a.src_doc_hdr_id IN (select f.rcvbls_invc_hdr_id from accb.accb_rcvbls_invc_hdr f
where f.rcvbls_invc_number ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Approval Status") {
        $whrcls = " and (a.approval_status ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Created By") {
        $whrcls = " and (sec.get_usr_name(a.created_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Currency") {
        $whrcls = " and (gst.get_pssbl_val(a.invc_curr_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $whrcls .= " and (a.customer_id IN ($cstmrID))";
    $strSql = "SELECT count(1) 
        FROM accb.accb_rcvbls_invc_hdr a 
        WHERE((a.org_id = " . $orgID . ")" . $whrcls . $unpstdCls .
            ")";

    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_One_RcvblsDocHdr($hdrID) {
    $strSql = "";

    $strSql = "SELECT rcvbls_invc_hdr_id, 
        to_char(to_timestamp(rcvbls_invc_date,'YYYY-MM-DD'),'DD-Mon-YYYY'), 
       created_by, 
       sec.get_usr_name(a.created_by), 
       rcvbls_invc_number, 
       rcvbls_invc_type, 
       comments_desc, 
       src_doc_hdr_id, 
       a.src_doc_type, 
       customer_id, 
       scm.get_cstmr_splr_name(a.customer_id),
       customer_site_id, 
       scm.get_cstmr_splr_site_name(a.customer_site_id), 
       approval_status, 
       next_aproval_action, 
       invoice_amount, 
       payment_terms, 
       pymny_method_id, 
       accb.get_pymnt_mthd_name(a.pymny_method_id), 
       amnt_paid, 
       gl_batch_id, 
       accb.get_gl_batch_name(a.gl_batch_id),
       cstmrs_doc_num, 
       doc_tmplt_clsfctn, 
       invc_curr_id, 
       gst.get_pssbl_val(a.invc_curr_id), 
       scm.get_src_doc_num(a.src_doc_hdr_id, a.src_doc_type),
        event_rgstr_id, 
        evnt_cost_category, 
        event_doc_type,
        a.invc_amnt_appld_elswhr,
        CASE WHEN a.event_doc_type='Attendance Register' and a.event_rgstr_id>0 THEN 
            (select z.recs_hdr_name from attn.attn_attendance_recs_hdr z where z.recs_hdr_id=a.event_rgstr_id)
            WHEN a.event_doc_type='Production Process Run' and a.event_rgstr_id>0 THEN 
            (select z.batch_code_num from scm.scm_process_run z where z.process_run_id=a.event_rgstr_id)
            ELSE 
            ''
        END event_num
  FROM accb.accb_rcvbls_invc_hdr a " .
            "WHERE((a.rcvbls_invc_hdr_id = " . $hdrID . "))";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RcvblsDocLines($docHdrID) {
    $strSql = "";
    $whrcls = " and (a.rcvbl_smmry_type !='6Grand Total' and 
a.rcvbl_smmry_type !='7Total Payments Made' and a.rcvbl_smmry_type !='8Outstanding Balance')";
    $strSql = "SELECT 
        rcvbl_smmry_id, 
        rcvbl_smmry_type, 
        rcvbl_smmry_desc, 
        rcvbl_smmry_amnt, 
       code_id_behind, 
       auto_calc, 
       incrs_dcrs1, 
       rvnu_acnt_id, 
       incrs_dcrs2, 
       rcvbl_acnt_id, 
       appld_prepymnt_doc_id, 
       entrd_curr_id, gst.get_pssbl_val(a.entrd_curr_id), 
       func_curr_id, gst.get_pssbl_val(a.func_curr_id), 
      accnt_curr_id, gst.get_pssbl_val(a.accnt_curr_id), 
      func_curr_rate, accnt_curr_rate, 
       func_curr_amount, accnt_curr_amnt, initial_amnt_line_id, 
       REPLACE(REPLACE(a.rcvbl_smmry_type,'2Tax','3Tax'),'3Discount','2Discount') smtyp 
  FROM accb.accb_rcvbl_amnt_smmrys a " .
            "WHERE((a.src_rcvbl_hdr_id = " . $docHdrID . ")" . $whrcls . ") ORDER BY 23 ASC ";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_One_SalesDcLines($dochdrID) {
    $strSql = "SELECT a.invc_det_ln_id, a.itm_id, 
              a.doc_qty, a.unit_selling_price, (a.doc_qty * a.unit_selling_price) amnt, 
              a.store_id, a.crncy_id, (a.doc_qty - a.qty_trnsctd_in_dest_doc) avlbl_qty, 
              a.src_line_id, a.tax_code_id, a.dscnt_code_id, a.chrg_code_id, a.rtrn_reason, 
              a.consgmnt_ids, a.orgnl_selling_price, b.base_uom_id, b.item_code, b.item_desc, 
      c.uom_name, a.is_itm_delivered, REPLACE(a.extra_desc || ' (' || a.other_mdls_doc_type || ')',' ()','')
        , a.other_mdls_doc_id, a.other_mdls_doc_type, a.lnkd_person_id, 
      REPLACE(prs.get_prsn_surname(a.lnkd_person_id) || ' (' 
      || prs.get_prsn_loc_id(a.lnkd_person_id) || ')', ' ()', '') fullnm, 
      CASE WHEN a.alternate_item_name='' THEN b.item_desc ELSE a.alternate_item_name END, d.cat_name " .
            "FROM scm.scm_sales_invc_det a, inv.inv_itm_list b, inv.unit_of_measure c, inv.inv_product_categories d " .
            "WHERE(a.invc_hdr_id = " . $dochdrID .
            " and a.invc_hdr_id>0 and a.itm_id = b.item_id and b.base_uom_id = c.uom_id and d.cat_id = b.category_id) ORDER BY a.invc_det_ln_id, b.category_id";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PyblsDocSmryLns($dochdrID, $docTyp) {
    $whrcls = " and (a.pybls_smmry_type IN ('6Grand Total','7Total Payments Made','8Outstanding Balance'))";
    $strSql = "SELECT a.pybls_smmry_id, a.pybls_smmry_desc, 
             a.pybls_smmry_amnt, a.code_id_behind, a.pybls_smmry_type, a.auto_calc 
             FROM accb.accb_pybls_amnt_smmrys a 
             WHERE((a.src_pybls_hdr_id = " . $dochdrID .
            ") and (a.src_pybls_type='" . $docTyp . "')$whrcls) ORDER BY a.pybls_smmry_type";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RcvblsDocSmryLns($dochdrID, $docTyp) {
    $whrcls = " and (a.rcvbl_smmry_type IN ('6Grand Total','7Total Payments Made','8Outstanding Balance'))";
    $strSql = "SELECT a.rcvbl_smmry_id, a.rcvbl_smmry_desc, 
             a.rcvbl_smmry_amnt, a.code_id_behind, a.rcvbl_smmry_type, a.auto_calc 
             FROM accb.accb_rcvbl_amnt_smmrys a 
             WHERE((a.src_rcvbl_hdr_id = " . $dochdrID .
            ") and (a.src_rcvbl_type='" . $docTyp . "')$whrcls) ORDER BY a.rcvbl_smmry_type";
    $result = executeSQLNoParams($strSql);
    //echo $strSql;
    return $result;
}

function get_SalesDocSmryLns($dochdrID, $docTyp) {
    $strSql = "SELECT a.smmry_id, CASE WHEN a.smmry_type='3Discount' THEN 'Discount' ELSE a.smmry_name END, 
             a.smmry_amnt, a.code_id_behind, a.smmry_type, a.auto_calc,REPLACE(REPLACE(a.smmry_type,'2Tax','3Tax'),'3Discount','2Discount') smtyp 
             FROM scm.scm_doc_amnt_smmrys a 
             WHERE((a.src_doc_hdr_id = " . $dochdrID . "
             ) and (a.src_doc_type='" . $docTyp . "')) ORDER BY 7";
    $result = executeSQLNoParams($strSql);
    //echo $strSql;
    return $result;
}

function get_PyblsDocHdr($searchWord, $searchIn, $offset, $limit_size, $orgID, $shwUnpstdOnly, $cstmrID = -1) {
    $strSql = "";
    $whrcls = "";
    $unpstdCls = "";
    if ($shwUnpstdOnly) {
        $unpstdCls = " AND (round(a.invoice_amount-a.amnt_paid,2)>0 or a.approval_status IN ('Not Validated','Validated','Reviewed'))";
    }
    if ($searchIn == "Document Number") {
        $whrcls = " and (a.pybls_invc_number ilike '" . loc_db_escape_string($searchWord) . "' or trim(to_char(a.pybls_invc_hdr_id, '99999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "')";
    } else if ($searchIn == "Document Description") {
        $whrcls = " and (a.comments_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Document Classification") {
        $whrcls = " and (a.doc_tmplt_clsfctn ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Supplier Name") {
        $whrcls = " and (a.customer_id IN (select c.cust_sup_id from 
scm.scm_cstmr_suplr c where c.cust_sup_name ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Supplier's Invoice Number") {
        $whrcls = " and (a.spplrs_invc_num ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Source Doc Number") {
        $whrcls = "  and (trim(to_char(a.src_doc_hdr_id, '9999999999999999999999999')) 
IN (select trim(to_char(d.rcpt_id, '9999999999999999999999999')) from inv.inv_consgmt_rcpt_hdr d 
where trim(to_char(d.rcpt_id, '9999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "') or trim(to_char(a.src_doc_hdr_id, '9999999999999999999999999')) 
IN (select trim(to_char(e.rcpt_rtns_id, '9999999999999999999999999')) from inv.inv_consgmt_rcpt_rtns_hdr e 
where trim(to_char(e.rcpt_rtns_id, '9999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "') or a.src_doc_hdr_id IN (select f.pybls_invc_hdr_id from accb.accb_pybls_invc_hdr f
where f.pybls_invc_number ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Approval Status") {
        $whrcls = " and (a.approval_status ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Created By") {
        $whrcls = " and (sec.get_usr_name(a.created_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Currency") {
        $whrcls = " and (gst.get_pssbl_val(a.invc_curr_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $whrcls .= " and (a.supplier_id IN ($cstmrID))";

    $strSql = "SELECT pybls_invc_hdr_id, pybls_invc_number, pybls_invc_type
, round(a.invoice_amount-a.amnt_paid,2),
 a.approval_status 
        FROM accb.accb_pybls_invc_hdr a 
        WHERE((a.org_id = " . $orgID . ")" . $whrcls . $unpstdCls .
            ") ORDER BY pybls_invc_hdr_id DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);

    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PyblsDocHdrTtl($searchWord, $searchIn, $orgID, $shwUnpstdOnly, $cstmrID = -1) {
    $strSql = "";
    $whrcls = "";
    $unpstdCls = "";
    if ($shwUnpstdOnly) {
        $unpstdCls = " AND (round(a.invoice_amount-a.amnt_paid,2)>0 or a.approval_status IN ('Not Validated','Validated','Reviewed'))";
    }
    if ($searchIn == "Document Number") {
        $whrcls = " and (a.pybls_invc_number ilike '" . loc_db_escape_string($searchWord) . "' or trim(to_char(a.pybls_invc_hdr_id, '99999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "')";
    } else if ($searchIn == "Document Description") {
        $whrcls = " and (a.comments_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Document Classification") {
        $whrcls = " and (a.doc_tmplt_clsfctn ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Supplier Name") {
        $whrcls = " and (a.customer_id IN (select c.cust_sup_id from 
scm.scm_cstmr_suplr c where c.cust_sup_name ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Supplier's Invoice Number") {
        $whrcls = " and (a.spplrs_invc_num ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Source Doc Number") {
        $whrcls = "  and (trim(to_char(a.src_doc_hdr_id, '9999999999999999999999999')) 
IN (select trim(to_char(d.rcpt_id, '9999999999999999999999999')) from inv.inv_consgmt_rcpt_hdr d 
where trim(to_char(d.rcpt_id, '9999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "') or trim(to_char(a.src_doc_hdr_id, '9999999999999999999999999')) 
IN (select trim(to_char(e.rcpt_rtns_id, '9999999999999999999999999')) from inv.inv_consgmt_rcpt_rtns_hdr e 
where trim(to_char(e.rcpt_rtns_id, '9999999999999999999999999')) ilike '" . loc_db_escape_string($searchWord) .
                "') or a.src_doc_hdr_id IN (select f.pybls_invc_hdr_id from accb.accb_pybls_invc_hdr f
where f.pybls_invc_number ilike '" . loc_db_escape_string($searchWord) .
                "'))";
    } else if ($searchIn == "Approval Status") {
        $whrcls = " and (a.approval_status ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Created By") {
        $whrcls = " and (sec.get_usr_name(a.created_by) ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Currency") {
        $whrcls = " and (gst.get_pssbl_val(a.invc_curr_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $whrcls .= " and (a.supplier_id IN ($cstmrID))";
    $strSql = "SELECT count(1) 
        FROM accb.accb_pybls_invc_hdr a 
        WHERE((a.org_id = " . $orgID . ")" . $whrcls . $unpstdCls .
            ")";

    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_One_PyblsDocHdr($hdrID) {
    $strSql = "";

    $strSql = "SELECT pybls_invc_hdr_id, 
        to_char(to_timestamp(pybls_invc_date,'YYYY-MM-DD'),'DD-Mon-YYYY'), 
       created_by, 
       sec.get_usr_name(a.created_by), 
       pybls_invc_number, 
       pybls_invc_type, 
       comments_desc, 
       src_doc_hdr_id, 
       a.src_doc_type, 
       supplier_id, 
       scm.get_cstmr_splr_name(a.supplier_id),
       supplier_site_id, 
       scm.get_cstmr_splr_site_name(a.supplier_site_id), 
       approval_status, 
       next_aproval_action, 
       invoice_amount, 
       payment_terms, 
       pymny_method_id, 
       accb.get_pymnt_mthd_name(a.pymny_method_id), 
       amnt_paid, 
       gl_batch_id, 
       accb.get_gl_batch_name(a.gl_batch_id),
       spplrs_invc_num, 
       doc_tmplt_clsfctn, 
       invc_curr_id, 
       gst.get_pssbl_val(a.invc_curr_id), 
       scm.get_src_doc_num(a.src_doc_hdr_id, a.src_doc_type),
        event_rgstr_id, 
        evnt_cost_category, 
        event_doc_type,
        a.invc_amnt_appld_elswhr,
        CASE WHEN a.event_doc_type='Attendance Register' and a.event_rgstr_id>0 THEN 
            (select z.recs_hdr_name from attn.attn_attendance_recs_hdr z where z.recs_hdr_id=a.event_rgstr_id)
            WHEN a.event_doc_type='Production Process Run' and a.event_rgstr_id>0 THEN 
            (select z.batch_code_num from scm.scm_process_run z where z.process_run_id=a.event_rgstr_id)
            ELSE 
            ''
        END event_num
  FROM accb.accb_pybls_invc_hdr a " .
            "WHERE((a.pybls_invc_hdr_id = " . $hdrID . "))";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PyblsDocLines($docHdrID) {
    $strSql = "";
    $whrcls = " and (a.pybls_smmry_type !='6Grand Total' and 
a.pybls_smmry_type !='7Total Payments Made' and a.pybls_smmry_type !='8Outstanding Balance')";
    $strSql = "SELECT 
        pybls_smmry_id, 
        pybls_smmry_type, 
        pybls_smmry_desc, 
        pybls_smmry_amnt, 
       code_id_behind, 
       auto_calc, 
       incrs_dcrs1, 
       asset_expns_acnt_id, 
       incrs_dcrs2, 
       liability_acnt_id, 
       appld_prepymnt_doc_id, 
       entrd_curr_id, gst.get_pssbl_val(a.entrd_curr_id), 
       func_curr_id, gst.get_pssbl_val(a.func_curr_id), 
      accnt_curr_id, gst.get_pssbl_val(a.accnt_curr_id), 
      func_curr_rate, accnt_curr_rate, 
       func_curr_amount, accnt_curr_amnt, initial_amnt_line_id, 
       REPLACE(REPLACE(a.pybls_smmry_type,'2Tax','3Tax'),'3Discount','2Discount') smtyp 
  FROM accb.accb_pybls_amnt_smmrys a " .
            "WHERE((a.src_pybls_hdr_id = " . $docHdrID . ")" . $whrcls . ") ORDER BY 23 ASC ";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function createPayDfltSets() {
    global $orgID;
    if (getItmStID("Bill Items SQL", $orgID) <= 0) {
        $query1 = "/* Created on 12/27/2012 10:18:43 AM By Rhomicom */ " .
                "SELECT a.item_id, a.item_code_name, a.item_value_uom, " .
                "(CASE WHEN a.item_min_type='Earnings' or a.item_min_type='Employer Charges' " .
                "THEN 'Payment by Organisation' WHEN a.item_min_type='Bills/Charges' or " .
                "a.item_min_type='Deductions' THEN 'Payment by Person' ELSE 'Purely Informational' END) trns_typ " .
                "FROM org.org_pay_items a " .
                "WHERE a.local_classfctn = 'Bill Item' AND a.org_id = (SELECT org_id " .
                "FROM org.org_details " .
                "WHERE org_name = '" . loc_db_escape_string(getOrgName($orgID)) . "')";
        createItmSt($orgID, "Bill Items SQL", "Bill Items SQL", true, false, true, $query1);
    }

    if (getItmStID("All Pay Items", $orgID) <= 0) {
        $query1 = "/* Created on 12/27/2012 10:18:43 AM By Rhomicom */ " .
                "SELECT a.item_id, a.item_code_name, a.item_value_uom, " .
                "(CASE WHEN a.item_min_type='Earnings' or a.item_min_type='Employer Charges' " .
                "THEN 'Payment by Organisation' WHEN a.item_min_type='Bills/Charges' or " .
                "a.item_min_type='Deductions' THEN 'Payment by Person' ELSE 'Purely Informational' END) trns_typ " .
                "FROM org.org_pay_items a " .
                "WHERE a.org_id = (SELECT org_id " .
                "FROM org.org_details " .
                "WHERE org_name = '" . loc_db_escape_string(getOrgName($orgID)) . "')";
        createItmSt($orgID, "All Pay Items", "All Pay Items", true, true, true, $query1);
    }
    if (getPrsStID("One Person SQL", $orgID) <= 0) {
        $query1 = "/* Created on 12/27/2012 10:18:43 AM By Rhomicom */ " .
                "SELECT DISTINCT " .
                "a.person_id, " .
                "a.local_id_no, " .
                "trim(a.title || ' ' || a.sur_name || ', ' || a.first_name || ' ' || a.other_names) full_name, a.img_location " .
                "FROM prs.prsn_names_nos a, pasn.prsn_prsntyps b " .
                "WHERE     a.person_id = b.person_id " .
                "AND a.org_id = (SELECT org_id " .
                "FROM org.org_details " .
                "WHERE org_name = '" . loc_db_escape_string(getOrgName($orgID)) . "') " .
                "AND a.local_id_no IN ('M0001') " .
                "AND (now () BETWEEN TO_TIMESTAMP (b.valid_start_date || ' 00:00:00', " .
                "'YYYY-MM-DD HH24:MI:SS' " .
                ") " .
                "AND  TO_TIMESTAMP (b.valid_end_date || ' 23:59:59', " .
                "'YYYY-MM-DD HH24:MI:SS' " .
                "))";
        createPrsSt($orgID, "One Person SQL", "One Person SQL", true, $query1, false, true);
    }

    if (getPrsStID("All Active Employees", $orgID) <= 0) {
        $query1 = "/* Created on 12/27/2012 10:18:43 AM By Rhomicom */ " .
                "SELECT DISTINCT " .
                "a.person_id, " .
                "a.local_id_no, " .
                "trim(a.title || ' ' || a.sur_name || ', ' || a.first_name || ' ' || a.other_names) full_name, a.img_location " .
                "FROM prs.prsn_names_nos a, pasn.prsn_prsntyps b " .
                "WHERE     a.person_id = b.person_id " .
                "AND a.org_id = (SELECT org_id " .
                "FROM org.org_details " .
                "WHERE org_name = '" . loc_db_escape_string(getOrgName($orgID)) . "') " .
                "AND b.prsn_type = 'Employee' " .
                "AND (now () BETWEEN TO_TIMESTAMP (b.valid_start_date || ' 00:00:00', " .
                "'YYYY-MM-DD HH24:MI:SS' " .
                ") " .
                "AND  TO_TIMESTAMP (b.valid_end_date || ' 23:59:59', " .
                "'YYYY-MM-DD HH24:MI:SS' " .
                "))";
        createPrsSt($orgID, "All Active Employees", "All Active Employees", true, $query1, false, true);
    }
    if (getPrsStID("All Persons", $orgID) <= 0) {
        $query1 = "/* Created on 12/27/2012 10:18:43 AM By Rhomicom */ " .
                "SELECT DISTINCT " .
                "a.person_id, " .
                "a.local_id_no, " .
                "trim(a.title || ' ' || a.sur_name || ', ' || a.first_name || ' ' || a.other_names) full_name, a.img_location " .
                "FROM prs.prsn_names_nos a " .
                "WHERE 1 = 1";
        createPrsSt($orgID, "All Persons", "All Persons", true, $query1, true, true);
    }
}

function createRqrdPayItems() {
    global $orgID;
    $itmNm = array("Total Advance Payments Balance", "Advance Payments Amount Kept", "Advance Payments Amount Applied");
    $itmDesc = array("Total Advance Payments Balance", "Advance Payments Amount Kept", "Advance Payments Amount Applied");
    $itmMajTyp = array("Balance Item", "Pay Value Item", "Pay Value Item");
    $itmMinTyp = array("Purely Informational", "Deductions", "Earnings");
    $itmUOM = array("Money", "Money", "Money");
    $payFreq = array("Adhoc", "Adhoc", "Adhoc");
    $payPryty = array("99999999.97", "99999999.98", "99999999.99");
    $usesSQL = array("NO", "NO", "YES");
    $localClass = array("Advance Items", "Advance Items", "Advance Items");
    $balsTyp = array("Cumulative", "", "");
    $inc_dc_cost = array("", "Increase", "Decrease");
    $effctOnOrgDbt = array("Decrease", "Decrease", "Increase");
    $costAccntNo = array("", "", "");
    $inc_dc_bals = array("", "Increase", "Decrease");
    $balsAccntNo = array("", "", "");
    $feedIntoNM = array("", "Total Advance Payments Balance", "Total Advance Payments Balance");
    $add_subtract = array("", "Adds", "Subtracts");
    $scale_fctr = array("", "1.00", "1.00");
    $isRetro = array("NO", "NO", "NO");
    $retroItmNm = array("", "", "");
    $invItmCode = array("", "", "");
    $allwEdit = array("YES", "YES", "YES");
    $creatsAcctng = array("NO", "YES", "YES");
    $valNm = array("Total Advance Payments Balance Value", "Advance Payments Amount Kept Value", "Advance Payments Amount Applied Value");
    $amnt = array("0", "0", "0");
    $valSQL = array("", "", "select pay.get_ltst_blsitm_bals({:person_id},org.get_payitm_id('Total Advance Payments Balance'),'{:pay_date}')");
    for ($i = 0; $i < count($itmNm); $i++) {
        $itm_id_in = getItmID($itmNm[$i], $orgID);
        $pryty = floatval($payPryty[$i]);
        $itmMnTypID = -1;
        $scl = floatval($scale_fctr[$i]);
        if ($itmMinTyp[$i] == "Earnings") {
            $itmMnTypID = 1;
        } else if ($itmMinTyp[$i] == "Employer Charges") {
            $itmMnTypID = 2;
        } else if ($itmMinTyp[$i] == "Deductions") {
            $itmMnTypID = 3;
        } else if ($itmMinTyp[$i] == "Bills/Charges") {
            $itmMnTypID = 4;
        } else if ($itmMinTyp[$i] == "Purely Informational") {
            $itmMnTypID = 5;
        }
        $isRetroElmnt = false;
        $allwEditing = false;
        $creatsActng = false;
        $retrItmID = getItmID($retroItmNm[$i], $orgID);
        $invItmID = getInvItmID($invItmCode[$i], $orgID);
        if ($isRetro[$i] == "YES") {
            $isRetroElmnt = true;
        }
        if ($allwEdit[$i] == "YES") {
            $allwEditing = true;
        }
        if ($creatsAcctng[$i] == "YES") {
            $creatsActng = true;
        }
        if ($itm_id_in <= 0 && $orgID > 0) {
            createItm($orgID, $itmNm[$i], $itmDesc[$i], $itmMajTyp[$i], $itmMinTyp[$i], $itmUOM[$i], cnvrtYNToBool($usesSQL[$i]), true, getAccntID($costAccntNo[$i], $orgID), getAccntID($balsAccntNo[$i], $orgID), $payFreq[$i], $localClass[$i], $pryty, $inc_dc_cost[$i], $inc_dc_bals[$i], $balsTyp[$i], $itmMnTypID, $isRetroElmnt, $retrItmID, $invItmID, $allwEditing, $creatsActng, $effctOnOrgDbt[$i]);
            $nwItmID = getItmID($itmNm[$i], $orgID);
            $feedIntoItmID = getItmID($feedIntoNM[$i], $orgID);
            $feedItmMayTyp = getGnrlRecNm("org.org_pay_items", "item_id", "item_maj_type", $feedIntoItmID);
            if ($itmMajTyp[$i] == "Balance Item") {
                createItmVal($nwItmID, 0, "", $itmNm[$i] + " Value");
            } else if ($feedItmMayTyp == "Balance Item") {
                if ($feedIntoItmID > 0) {
                    if ($add_subtract[$i] != "Adds" && $add_subtract[$i] != "Subtracts") {
                        $add_subtract[$i] = "Adds";
                    }
                    createItmFeed($nwItmID, $feedIntoItmID, $add_subtract[$i], $scl);
                }
            }
        }

        $val_id_in = getItmValID($valNm[$i], $itm_id_in);
        $amntFig = floatval($amnt[$i]);

        if ($itm_id_in > 0 && $val_id_in <= 0) {
            createItmVal($itm_id_in, $amntFig, $valSQL[$i], $valNm[$i]);
        } else if ($val_id_in > 0) {
            updateItmVal($val_id_in, $itm_id_in, $amntFig, $valSQL[$i], $valNm[$i]);
        }
    }
}

function getItmStID($itmstname, $orgid) {
    $sqlStr = "select hdr_id from pay.pay_itm_sets_hdr where lower(itm_set_name) = '"
            . loc_db_escape_string($itmstname) . "' and org_id = " . loc_db_escape_string($orgid);
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getPrsStID($prsstname, $orgid) {
    $sqlStr = "select prsn_set_hdr_id from pay.pay_prsn_sets_hdr where lower(prsn_set_hdr_name) = '" .
            loc_db_escape_string(strtolower($prsstname)) . "' and org_id = " . loc_db_escape_string($orgid);
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getPrsStName($prsstid) {
    $sqlStr = "select prsn_set_hdr_name from pay.pay_prsn_sets_hdr where prsn_set_hdr_id = " .
            $prsstid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getPrsStSQL($prsstid) {
    $sqlStr = "select sql_query from pay.pay_prsn_sets_hdr where prsn_set_hdr_id = " .
            $prsstid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getItmStName($itmstid) {
    $sqlStr = "select itm_set_name from pay.pay_itm_sets_hdr where hdr_id = " .
            $itmstid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getMsPyName($mspyid) {
    $sqlStr = "select mass_pay_name from pay.pay_mass_pay_run_hdr where mass_pay_id = " .
            $mspyid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getMsPyID($mspyname, $orgid) {
    $sqlStr = "select mass_pay_id from pay.pay_mass_pay_run_hdr where lower(mass_pay_name) = '" .
            loc_db_escape_string(strtolower($mspyname)) . "' and org_id = " . $orgid;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getItmValueAmnt($itmvalid) {
    $sqlStr = "select pssbl_amount from org.org_pay_items_values where pssbl_value_id = " .
            $itmvalid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return 0;
}

function getItmValSQL($itmvalid) {
    $sqlStr = "select pssbl_value_sql from org.org_pay_items_values where pssbl_value_id = " .
            $itmvalid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getItmValName($itmvalid) {
    $sqlStr = "select pssbl_value_code_name from org.org_pay_items_values where pssbl_value_id = " .
            $itmvalid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getItmName($itmid) {
    $sqlStr = "select item_code_name from org.org_pay_items where item_id = " .
            $itmid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getItmID($itmname, $orgid) {
    $sqlStr = "select item_id from org.org_pay_items where lower(item_code_name) = '" .
            loc_db_escape_string(strtolower($itmname)) . "' and org_id = " . $orgid;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getInvItmID($itmname, $orgid) {
    $sqlStr = "select item_id from inv.inv_itm_list where lower(item_code) = '" .
            loc_db_escape_string(strtolower($itmname)) . "' and org_id = " . $orgid;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getItmMinType($itmid) {
    $sqlStr = "select item_min_type from org.org_pay_items where item_id = " .
            $itmid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getItmMajType($itmid) {
    $sqlStr = "select item_maj_type from org.org_pay_items where item_id = " .
            $itmid . "";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function getItmValID($itmvalname, $itmid) {
    $sqlStr = "select pssbl_value_id from org.org_pay_items_values where lower(pssbl_value_code_name) = '" .
            loc_db_escape_string(strtolower($itmvalname)) . "' and item_id = " . $itmid;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function exctItmValSQL($itemSQL, $prsn_id, $org_id, $dateStr) {
    $dateStr = cnvrtDMYTmToYMDTm($dateStr);
    if (strlen($dateStr) > 10) {
        $dateStr = substr($dateStr, 0, 10);
    }
    $nwSQL = str_replace("{:pay_date}", $dateStr, str_replace("{:org_id}", $org_id, str_replace("{:person_id}", $prsn_id, $itemSQL)));
    $result = executeSQLNoParams($nwSQL);

    while ($row = loc_db_fetch_array($result)) {
        return floatval($row[0]);
    }
    return 0;
}

function isItmValSQLValid($itemSQL, $prsn_id, $org_id, $dateStr) {
    $dateStr = cnvrtDMYTmToYMDTm($dateStr);
    if (strlen($dateStr) > 10) {
        $dateStr = substr($dateStr, 0, 10);
    }
    $nwSQL = str_replace("{:pay_date}", $dateStr, str_replace("{:org_id}", $org_id, str_replace("{:person_id}", $prsn_id, $itemSQL)));
    $nwSQL = itemSQL . Replace("{:person_id}", prsn_id . ToString()) . Replace("{:org_id}", org_id . ToString()) . Replace("{:pay_date}", dateStr);
    $result = executeSQLNoParams($nwSQL);
    if ($result !== NULL) {
        return true;
    } else {
        return false;
    }
}

function isPrsnSetSQLValid($prsStSQL, &$errMsg) {
    try {
        $testSQL = "SELECT DISTINCT " .
                "a.person_id, " .
                "a.local_id_no, " .
                "trim(a.title || ' ' || a.sur_name || ', ' || a.first_name || ' ' || a.other_names) full_name, a.img_location";
        if (strpos(str_replace(" ", "", str_replace("\n", "", (str_replace("\r", "", str_replace("\r\n", "", strtolower($prsStSQL)))))), str_replace(" ", "", strtolower($testSQL))) === FALSE) {
            $errMsg = "Person Set SQL Query must start with<br/><br/>" . $testSQL;
            return FALSE;
        } else {
            $conn = getConn();
            $result = loc_db_query($conn, $prsStSQL);
            if (!$result) {
                $errMsg = "An error occurred. <br/> " . loc_db_result_error($result);
            }
            loc_db_close($conn);
            return TRUE;
        }
    } catch (Exception $ex) {
        $errMsg = "An error occurred. <br/>" . $ex->getMessage() . " Invalid Person Set SQL Query!";
        return FALSE;
    }
}

function updateItmVal($pssblvalid, $itmid, $amnt, $sqlFormula, $valNm) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE org.org_pay_items_values " .
            "SET item_id=" . $itmid . ", pssbl_amount=" . $amnt .
            ", pssbl_value_sql='" . loc_db_escape_string($sqlFormula) . "', " .
            "last_update_by=" . $usrID . ", last_update_date='" . $dateStr . "', " .
            "pssbl_value_code_name='" . loc_db_escape_string($valNm) . "' " .
            "WHERE pssbl_value_id = " . $pssblvalid;
    execUpdtInsSQL($updtSQL);
}

function updateItmFeed($feedid, $itmid, $balsItmID, $addSub, $scaleFctr) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE org.org_pay_itm_feeds " .
            "SET balance_item_id=" . $balsItmID . ", fed_by_itm_id=" . $itmid .
            ", adds_subtracts='" . loc_db_escape_string($addSub) . "', " .
            "last_update_by=" . $usrID . ", last_update_date='" . $dateStr . "', " .
            "scale_factor=" . $scaleFctr .
            " WHERE feed_id = " . $feedid;
    execUpdtInsSQL($updtSQL);
}

function clearTakeHomes() {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE org.org_pay_items SET is_take_home_pay = '0', last_update_by = " . $usrID . ", " .
            "last_update_date = '" . $dateStr . "' " +
            "WHERE (is_take_home_pay = '1')";
    execUpdtInsSQL($updtSQL);
}

function updateItm($orgid, $itmid, $itnm, $itmDesc, $itmMajTyp, $itmMinTyp, $itmUOMTyp, $useSQL, $isenbld, $costAcnt, $balsAcnt, $freqncy, $locClass, $priorty, $inc_dc_cost, $inc_dc_bals, $balstyp, $itmMnID, $isRetro, $retroID, $invItmID, $allwEdit, $createsAcctng, $effctOnOrgDbt) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE org.org_pay_items " .
            "SET item_code_name='" . loc_db_escape_string($itnm) .
            "', item_desc='" . loc_db_escape_string($itmDesc) .
            "', item_maj_type='" . loc_db_escape_string($itmMajTyp) .
            "', item_min_type='" . loc_db_escape_string($itmMinTyp) .
            "', item_value_uom='" . loc_db_escape_string($itmUOMTyp) .
            "', uses_sql_formulas='" . loc_db_escape_string(cnvrtBoolToBitStr($useSQL)) .
            "', cost_accnt_id=" . $costAcnt .
            ", bals_accnt_id=" . $balsAcnt . ", " .
            "is_enabled='" . loc_db_escape_string(cnvrtBoolToBitStr($isenbld)) .
            "', org_id=" . $orgid .
            ", last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "', pay_frequency = '" . loc_db_escape_string($freqncy) .
            "', local_classfctn = '" . loc_db_escape_string($locClass) .
            "', pay_run_priority = " . loc_db_escape_string($priorty) .
            ", incrs_dcrs_cost_acnt ='" . loc_db_escape_string($inc_dc_cost) .
            "', incrs_dcrs_bals_acnt='" . loc_db_escape_string($inc_dc_bals) .
            "', balance_type='" . loc_db_escape_string($balstyp) .
            "', report_line_no= " . $itmMnID .
            ", is_retro_element='" . loc_db_escape_string(cnvrtBoolToBitStr($isRetro)) .
            "', retro_item_id= " . $retroID .
            ", inv_item_id= " . $invItmID .
            ", allow_value_editing='" . loc_db_escape_string(cnvrtBoolToBitStr($allwEdit)) .
            "', creates_accounting='" . loc_db_escape_string(cnvrtBoolToBitStr($createsAcctng)) .
            "', effct_on_org_debt='" . loc_db_escape_string($effctOnOrgDbt) .
            "' WHERE item_id=" . $itmid;
    execUpdtInsSQL($updtSQL);
}

function createItm($orgid, $itnm, $itmDesc, $itmMajTyp, $itmMinTyp, $itmUOMTyp, $useSQL, $isenbld, $costAcnt, $balsAcnt, $freqncy, $locClass, $priorty, $inc_dc_cost, $inc_dc_bals, $balstyp, $itmMnID, $isRetro, $retroID, $invItmID, $allwEdit, $createsAcctng, $effctOnOrgDbt) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO org.org_pay_items(" .
            "item_code_name, item_desc, item_maj_type, item_min_type, " .
            "item_value_uom, uses_sql_formulas, cost_accnt_id, bals_accnt_id, " .
            "is_enabled, org_id, created_by, creation_date, last_update_by, " .
            "last_update_date, pay_frequency, local_classfctn, pay_run_priority, " .
            "incrs_dcrs_cost_acnt, incrs_dcrs_bals_acnt, balance_type, report_line_no," .
            " is_retro_element,retro_item_id,inv_item_id, allow_value_editing, creates_accounting,effct_on_org_debt) " .
            "VALUES ('" . loc_db_escape_string($itnm) .
            "', '" . loc_db_escape_string($itmDesc) .
            "', '" . loc_db_escape_string($itmMajTyp) .
            "', '" . loc_db_escape_string($itmMinTyp) .
            "', '" . loc_db_escape_string($itmUOMTyp) .
            "', '" . loc_db_escape_string(cnvrtBoolToBitStr($useSQL)) .
            "', " . $costAcnt .
            ", " . $balsAcnt .
            ", '" . loc_db_escape_string(cnvrtBoolToBitStr($isenbld)) .
            "', " . $orgid .
            ", " . $usrID .
            ", '" . $dateStr .
            "', " . $usrID .
            ", '" . $dateStr .
            "', '" . loc_db_escape_string($freqncy) .
            "', '" . loc_db_escape_string($locClass) .
            "', " . $priorty .
            ",'" . loc_db_escape_string($inc_dc_cost) . "','" .
            loc_db_escape_string($inc_dc_bals) .
            "','" . loc_db_escape_string($balstyp) .
            "', " . $itmMnID .
            ", '" . loc_db_escape_string(cnvrtBoolToBitStr($isRetro)) .
            "', " . $retroID .
            ", " . $invItmID .
            ",'" . loc_db_escape_string(cnvrtBoolToBitStr($allwEdit)) .
            "','" . loc_db_escape_string(cnvrtBoolToBitStr($createsAcctng)) .
            "','" . loc_db_escape_string($effctOnOrgDbt) . "')";
    execUpdtInsSQL($insSQL);
}

function createItmVal($itmid, $amnt, $sqlFormula, $valNm) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO org.org_pay_items_values(" .
            "item_id, pssbl_amount, pssbl_value_sql, created_by, " .
            "creation_date, last_update_by, last_update_date, pssbl_value_code_name) " .
            "VALUES (" . $itmid . ", " . $amnt .
            ", '" . loc_db_escape_string($sqlFormula) . "', " . $usrID . ", '" . $dateStr . "', " .
            $usrID . ", '" . $dateStr . "', '" . loc_db_escape_string($valNm) . "')";
    execUpdtInsSQL($insSQL);
}

function createItmFeed($itmid, $balsItmID, $addSub, $scaleFctr) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO org.org_pay_itm_feeds(" .
            "balance_item_id, fed_by_itm_id, adds_subtracts, created_by, " .
            "creation_date, last_update_by, last_update_date, scale_factor) " .
            "VALUES (" . $balsItmID . ", " . $itmid .
            ", '" . loc_db_escape_string($addSub) . "', " . $usrID . ", '" . $dateStr . "', " .
            $usrID . ", '" . $dateStr . "', " . $scaleFctr . ")";
    execUpdtInsSQL($insSQL);
}

function doesItmFeedExists($itmid, $blsItmID) {
    $selSQL = "SELECT a.feed_id " .
            "FROM org.org_pay_itm_feeds a WHERE ((a.fed_by_itm_id = " . $itmid .
            ") and (a.balance_item_id = " . $blsItmID .
            ")) ORDER BY a.feed_id ";
    $result = executeSQLNoParams($selSQL);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function createItmSt($orgid, $itmsetname, $itmstdesc, $isenbled, $isdflt, $usesSQL, $sqlTxt) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO pay.pay_itm_sets_hdr(" .
            "itm_set_name, itm_set_desc, is_enabled, created_by, creation_date, " .
            "last_update_by, last_update_date, org_id, is_default, uses_sql, sql_query) " .
            "VALUES ('" . loc_db_escape_string($itmsetname) .
            "', '" . loc_db_escape_string($itmstdesc) .
            "', '" . loc_db_escape_string(cnvrtBoolToBitStr($isenbled)) .
            "', " . loc_db_escape_string($usrID) .
            ", '" . loc_db_escape_string($dateStr) .
            "', " . loc_db_escape_string($usrID) .
            ", '" . loc_db_escape_string($dateStr) .
            "', " . loc_db_escape_string($orgid) .
            ", '" . loc_db_escape_string(cnvrtBoolToBitStr($isdflt)) .
            "', '" . loc_db_escape_string($usesSQL) .
            "', '" . loc_db_escape_string($sqlTxt) .
            "')";
    execUpdtInsSQL($insSQL);
}

function createPrsSt($orgid, $prssetname, $prsstdesc, $isenbled, $sqlQry, $isdflt, $usesSQL) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO pay.pay_prsn_sets_hdr(" .
            "prsn_set_hdr_name, prsn_set_hdr_desc, is_enabled, " .
            "created_by, creation_date, last_update_by, last_update_date, " .
            "sql_query, org_id, is_default, uses_sql) " .
            "VALUES ('" . loc_db_escape_string($prssetname) .
            "', '" . loc_db_escape_string($prsstdesc) .
            "', '" . loc_db_escape_string(cnvrtBoolToBitStr($isenbled)) .
            "', " . loc_db_escape_string($usrID) .
            ", '" . loc_db_escape_string($dateStr) .
            "', " . loc_db_escape_string($usrID) .
            ", '" . loc_db_escape_string($dateStr) .
            "', '" . loc_db_escape_string($sqlQry) .
            "', " . loc_db_escape_string($orgid) .
            ", '" . loc_db_escape_string(cnvrtBoolToBitStr($isdflt)) .
            "', '" . loc_db_escape_string(cnvrtBoolToBitStr($usesSQL)) .
            "')";
    execUpdtInsSQL($insSQL);
}

function updatePersonSet($hdrid, $prssetname, $prsstdesc, $isenbled, $sqlQry, $isdflt, $usesSQL) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE pay.pay_prsn_sets_hdr " .
            "SET prsn_set_hdr_name='" . loc_db_escape_string($prssetname) .
            "', prsn_set_hdr_desc='" . loc_db_escape_string($prsstdesc) .
            "', is_enabled = '" . loc_db_escape_string(cnvrtBoolToBitStr($isenbled)) .
            "', sql_query = '" . loc_db_escape_string($sqlQry) .
            "', is_default = '" . loc_db_escape_string(cnvrtBoolToBitStr($isdflt)) .
            "', uses_sql = '" . loc_db_escape_string(cnvrtBoolToBitStr($usesSQL)) .
            "', last_update_by=" . $usrID .
            ", last_update_date='" . $dateStr .
            "' WHERE prsn_set_hdr_id = " . $hdrid;

    execUpdtInsSQL($insSQL);
}

function get_Org_DfltPrsSt($orgID) {
    $res = array("-1", "");
    $strSql = "SELECT a.prsn_set_hdr_id, a.prsn_set_hdr_name " .
            "FROM pay.pay_prsn_sets_hdr a, pay.pay_sets_allwd_roles b " .
            "WHERE (a.prsn_set_hdr_id = b.prsn_set_id and (a.org_id = " . $orgID .
            ") and (a.is_default = '1') and (is_enabled = '1')) ORDER BY a.prsn_set_hdr_id LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        $res[0] = $row[0];
        $res[1] = $row[1];
    }
    return $res;
}

function get_Org_DfltItmSt($orgID) {
    $res = array("-1", "");
    $strSql = "SELECT a.hdr_id, a.itm_set_name, a.itm_set_desc, a.is_enabled " .
            "FROM pay.pay_itm_sets_hdr a , pay.pay_sets_allwd_roles b " .
            "WHERE (a.hdr_id = b.itm_set_id and (a.org_id = " . $orgID .
            ") and (a.is_default = '1') and (a.is_enabled = '1')) ORDER BY a.hdr_id LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        $res[0] = $row[0];
        $res[1] = $row[1];
    }
    return $res;
}

function get_SlctdPrsnsInSet($searchWord, $searchIn, $offset, $limit_size, $orgID, $prsStID) {
    $prsSQL = getPrsStSQL($prsStID);

    $mnlSQL = "Select distinct a.person_id, a.local_id_no, trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) full_name, b.prsn_set_det_id " .
            "from prs.prsn_names_nos a, pay.pay_prsn_sets_det b " .
            "WHERE ((a.person_id = b.person_id) and (b.prsn_set_hdr_id = " . $prsStID .
            ") and (trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) ilike '" . loc_db_escape_string($searchWord) .
            "' or a.local_id_no ilike '" . loc_db_escape_string($searchWord) .
            "') AND (a.org_id = " . $orgID . ")) ORDER BY a.local_id_no DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    $strSql = "select * from (" . $prsSQL . ") tbl1 where tbl1.full_name ilike '" . loc_db_escape_string($searchWord) .
            "' or tbl1.local_id_no ilike '" . loc_db_escape_string($searchWord) .
            "' ORDER BY tbl1.local_id_no ASC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    if ($prsSQL == "") {
        $strSql = $mnlSQL;
    }
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SlctdPrsnsInSetTtl($searchWord, $searchIn, $orgID, $prsStID) {
    $prsSQL = getPrsStSQL($prsStID);
    $mnlSQL = "Select count(distinct a.person_id) " .
            "from prs.prsn_names_nos a, pay.pay_prsn_sets_det b " .
            "WHERE ((a.person_id = b.person_id) and (b.prsn_set_hdr_id = " . $prsStID .
            ") and (trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) ilike '" . loc_db_escape_string($searchWord) .
            "' or a.local_id_no ilike '" . loc_db_escape_string($searchWord) .
            "') AND (a.org_id = " . $orgID . "))";
    $strSql = "select count(distinct tbl1.person_id) from (" . $prsSQL .
            ") tbl1 where tbl1.full_name ilike '" . loc_db_escape_string($searchWord) .
            "' or tbl1.local_id_no ilike '" . loc_db_escape_string($searchWord) .
            "'";
    if ($prsSQL == "") {
        $strSql = $mnlSQL;
    }
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return 0;
}

function get_PrsnDet($pkID) {
    $strSql = "SELECT    MAX(a.person_id) mt, 
	  MAX(local_id_no), 
	  CASE WHEN MAX(img_location)='' THEN MAX(a.person_id)||'.png' ELSE MAX(img_location) END, 
          MAX(title), 
          MAX(first_name), 
          MAX(sur_name) , 
          MAX(other_names), 
          org.get_org_name(MAX(org_id)) organisation, 
          MAX(gender), 
          MAX(marital_status), 
          to_char(to_timestamp(MAX(date_of_birth),'YYYY-MM-DD'),'DD-Mon-YYYY') || ' (' || extract('years' from age(now(), to_timestamp(MAX(date_of_birth),'YYYY-MM-DD'))) || ' yr(s)' || ')' , 
          MAX(place_of_birth), 
          MAX(religion), 
          MAX(res_address) residential_address, 
          MAX(pstl_addrs) postal_address, 
          MAX(email), 
          MAX(cntct_no_tel) tel, 
          MAX(cntct_no_mobl) mobile, 
          MAX(cntct_no_fax) fax, 
          MAX(hometown), 
          MAX(nationality), 
          (CASE WHEN MAX(lnkd_firm_org_id)>0 THEN 
          scm.get_cstmr_splr_name(MAX(lnkd_firm_org_id))
              ELSE 
              MAX(new_company)
              END) \"Linked Firm/ Workplace \", 
          (CASE WHEN MAX(lnkd_firm_org_id)>0 THEN 
           scm.get_cstmr_splr_site_name(MAX(lnkd_firm_site_id))
              ELSE 
              MAX(new_company_loc)
              END) \"Branch \", 
          MAX(b.prsn_type) \"Relation Type\", 
          MAX(b.prn_typ_asgnmnt_rsn) \"Cause of Relation\", 
            MAX(b.further_details) \"Further Details\", 
            to_char(to_timestamp(MAX(b.valid_start_date),'YYYY-MM-DD'),'DD-Mon-YYYY') \"Start Date \", 
            to_char(to_timestamp(MAX(b.valid_end_date),'YYYY-MM-DD'),'DD-Mon-YYYY') \"End Date \",
            MAX(a.lnkd_firm_org_id),
            string_agg(distinct org.get_div_name(g.div_id),', '),
            string_agg(distinct org.get_site_name(h.location_id),', '),
            string_agg(distinct org.get_job_name(c.job_id),', '),
            string_agg(distinct org.get_grade_name(d.grade_id),', '),
            string_agg(distinct org.get_pos_name(e.position_id),', '),
            string_agg(distinct prs.get_prsn_name(f.supervisor_prsn_id),', '),
            prs.get_prsn_name(MAX(a.person_id))
            FROM prs.prsn_names_nos a  
            LEFT OUTER JOIN pasn.prsn_prsntyps b ON (a.person_id = b.person_id and 
           b.valid_start_date = (SELECT MAX(z.valid_start_date) from pasn.prsn_prsntyps z where z.person_id = a.person_id))  
            LEFT OUTER JOIN pasn.prsn_jobs c  ON (a.person_id = c.person_id and (now() between to_timestamp(c.valid_start_date,'YYYY-MM-DD') and to_timestamp(c.valid_end_date,'YYYY-MM-DD'))) 
            LEFT OUTER JOIN pasn.prsn_grades d    ON (a.person_id = d.person_id and (now() between to_timestamp(d.valid_start_date,'YYYY-MM-DD') and to_timestamp(d.valid_end_date,'YYYY-MM-DD'))) 
            LEFT OUTER JOIN pasn.prsn_positions e ON (a.person_id = e.person_id and (now() between to_timestamp(e.valid_start_date,'YYYY-MM-DD') and to_timestamp(e.valid_end_date,'YYYY-MM-DD')))   
            LEFT OUTER JOIN pasn.prsn_supervisors f ON (a.person_id = f.person_id and (now() between to_timestamp(f.valid_start_date,'YYYY-MM-DD') and to_timestamp(f.valid_end_date,'YYYY-MM-DD')))    
            LEFT OUTER JOIN pasn.prsn_divs_groups g  ON (a.person_id = g.person_id and (now() between to_timestamp(g.valid_start_date,'YYYY-MM-DD') and to_timestamp(g.valid_end_date,'YYYY-MM-DD')))  
            LEFT OUTER JOIN pasn.prsn_locations h ON (a.person_id = h.person_id and (now() between to_timestamp(h.valid_start_date,'YYYY-MM-DD') and to_timestamp(h.valid_end_date,'YYYY-MM-DD')))      
    WHERE (a.person_id=$pkID)";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function getAllBnftsPrs($searchWord, $offset, $limit_size, $prsnid) {
    $strSql = "SELECT a.item_id, a.item_pssbl_value_id, 
to_char(to_timestamp(a.valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY'), 
to_char(to_timestamp(a.valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY'), 
a.row_id, b.item_maj_type, b.pay_run_priority, b.item_code_name,
org.get_payitm_valnm(a.item_pssbl_value_id) 
            FROM pasn.prsn_bnfts_cntrbtns a, org.org_pay_items b 
            WHERE ((a.item_id=b.item_id) and (a.person_id = " . $prsnid .
            ") and (b.item_code_name ilike '" . loc_db_escape_string($searchWord) .
            "' or org.get_payitm_valnm(a.item_pssbl_value_id) ilike '" . loc_db_escape_string($searchWord) .
            "')) ORDER BY b.item_maj_type, b.pay_run_priority, b.item_code_name LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);

    $result = executeSQLNoParams($strSql);
    return $result;
}

function getAllBnftsPrsTtl($searchWord, $prsnid) {
    $strSql = "SELECT count(1) 
            FROM pasn.prsn_bnfts_cntrbtns a, org.org_pay_items b  
            WHERE ((a.item_id=b.item_id) and (a.person_id = " . $prsnid .
            ") and (b.item_code_name ilike '" . loc_db_escape_string($searchWord) .
            "' or org.get_payitm_valnm(a.item_pssbl_value_id) ilike '" . loc_db_escape_string($searchWord) .
            "'))";

    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return 0;
}

function getBlsItmLtstDailyBalsPrs($balsItmID, $prsn_id, $balsDate, $orgID) {
    $balsDate = cnvrtDMYToYMD($balsDate);
    $res = 0;
    $strSql = "";
    $usesSQL = getGnrlRecNm("org.org_pay_items", "item_id", "uses_sql_formulas", $balsItmID);
    if ($usesSQL != "1") {
        $strSql = "SELECT a.bals_amount " .
                "FROM pay.pay_balsitm_bals a " .
                "WHERE(to_timestamp(a.bals_date,'YYYY-MM-DD') <=  to_timestamp('" . $balsDate .
                "','YYYY-MM-DD') and a.bals_itm_id = " . $balsItmID . " and a.person_id = " . $prsn_id .
                ") ORDER BY to_timestamp(a.bals_date,'YYYY-MM-DD') DESC LIMIT 1 OFFSET 0";

        $result = executeSQLNoParams($strSql);
        while ($row = loc_db_fetch_array($result)) {
            $res = (float) $row[0];
        }
    } else {
        $valSQL = getItmValSQL(getPrsnItmVlIDPrs($prsn_id, $balsItmID));
        if ($valSQL == "") {
            
        } else {
            try {
                $res = exctItmValSQL(
                        $valSQL, $prsn_id, $orgID, $balsDate);
            } catch (Exception $ex) {
                
            }
        }
    }
    return $res;
}

function getPrsnItmVlIDPrs($prsnID, $itmID) {
    $dateStr = getDB_Date_time();
    $strSql = "Select a.item_pssbl_value_id FROM pasn.prsn_bnfts_cntrbtns a where((a.person_id = " .
            $prsnID . ") and (a.item_id = " . $itmID . ") and (to_timestamp('" . $dateStr . "'," .
            "'YYYY-MM-DD HH24:MI:SS') between to_timestamp(valid_start_date," .
            "'YYYY-MM-DD 00:00:00') AND to_timestamp(valid_end_date,'YYYY-MM-DD 23:59:59')))";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -100000;
}

function getAllAccounts($prsnid) {
    $strSql = "SELECT bank_name, bank_branch, account_name, account_number, " .
            "account_type, net_pay_portion, portion_uom, prsn_accnt_id " .
            "FROM pasn.prsn_bank_accounts WHERE ((person_id = " . $prsnid .
            ")) ORDER BY prsn_accnt_id DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
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

function doesItmSetHvRole($setID, $role_id) {
    $strSql = "SELECT pay_roles_id FROM pay.pay_sets_allwd_roles " .
            "WHERE itm_set_id = " . $setID . " and user_role_id = " . $role_id;
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function doesPrsnSetHvRole($setID, $role_id) {
    $strSql = "SELECT pay_roles_id FROM pay.pay_sets_allwd_roles " .
            "WHERE prsn_set_id = " . $setID . " and user_role_id = " . $role_id;
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function createPayRole($itmSetID, $prsSetID, $roleID) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO pay.pay_sets_allwd_roles(" .
            "prsn_set_id, itm_set_id, user_role_id, created_by, creation_date) " .
            "VALUES (" . $prsSetID . ", " . $itmSetID . ", " . $roleID .
            ", " . $usrID . ", '" . $dateStr .
            "')";
    execUpdtInsSQL($insSQL);
}

function get_AllRoles($itmsetID) {
    $strSql = "SELECT a.user_role_id, b.role_name, a.pay_roles_id " .
            "FROM pay.pay_sets_allwd_roles a, sec.sec_roles b " .
            "WHERE a.itm_set_id = " . $itmsetID . " and a.user_role_id = b.role_id";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function get_AllRoles1($prssetID) {
    $strSql = "SELECT a.user_role_id, b.role_name, a.pay_roles_id " .
            "FROM pay.pay_sets_allwd_roles a, sec.sec_roles b " .
            "WHERE a.prsn_set_id = " . $prssetID . " and a.user_role_id = b.role_id";
    $result = executeSQLNoParams($strSql);

    return $result;
}

function deletePersonSet($hdrid, $setNm) {
    $insSQL = "DELETE FROM pay.pay_prsn_sets_hdr WHERE prsn_set_hdr_id = " . $hdrid;
    $affctd = execUpdtInsSQL($insSQL, "Person Set Name=$setNm");
    $insSQL1 = "DELETE FROM pay.pay_prsn_sets_det WHERE prsn_set_hdr_id = " . $hdrid;
    $affctd1 = execUpdtInsSQL($insSQL1, "Person Set Name=$setNm");

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

function deletePersonSetRole($hdrid, $roleNm) {
    $affctd = deleteGnrlRecs($hdrid, "pay.pay_sets_allwd_roles", "pay_roles_id", "Linked Role Set Name = " . $roleNm);

    if ($affctd > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd Linked Role Set(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted!";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">

    $dsply</p>";
    }
}

function deletePersonSetDet($detID, $prsnLocID) {
    $insSQL = "DELETE FROM pay.pay_prsn_sets_det WHERE prsn_set_det_id = " . $detID;
    $affctd = execUpdtInsSQL($insSQL, "Person Loc. ID:$prsnLocID");

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

function isItmStInUse($itmstID) {
    $strSql = "SELECT a.mass_pay_id " .
            "FROM pay.pay_mass_pay_run_hdr a " .
            "WHERE(a.itm_st_id = " . $itmstID . ") LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSql);
    if (loc_db_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function isPrsStInUse($prsstID) {
    $strSql = "SELECT a.mass_pay_id " .
            "FROM pay.pay_mass_pay_run_hdr a " .
            "WHERE(a.prs_st_id = " . $prsstID . ") LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSql);
    if (loc_db_num_rows($result) > 0) {
        return true;
    }
    $strSql = "SELECT a.srvy_id " .
            "FROM self.self_surveys a " .
            "WHERE(a.eligible_prsn_set_id = " . $prsstID . " or a.exclsn_lst_prsn_set_id = " . $prsstID . ") LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSql);
    if (loc_db_num_rows($result) > 0) {
        return true;
    }
    return false;
}

?>
