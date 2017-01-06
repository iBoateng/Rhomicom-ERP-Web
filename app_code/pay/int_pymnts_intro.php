<?php

$menuItems = array("My Bills/Payment Slips", "Linked Customer Invoices", "Linked Supplier Invoices",
    "Manual Payments", "Pay Item Sets",
    "Person Sets", "Mass Pay Runs", "Payment Transactions",
    "GL Interface Table", "Pay Items", "Global Values");
$menuImages = array("bills.png", "invcBill.png", "invoice1.png", "pay.png",
    "wallet.png", "staffs.png", "bulkPay.png", "search.png", "GL-256.png", "chcklst4.png", "world_48.png");

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
    /* 34 */ "Add Pay Item Assignments", "Edit Pay Item Assignments", "Delete Pay Item Assignments",
    /* 37 */ "View Global Values", "Add Global Values", "Edit Global Values", "Delete Global Values",
    /* 41 */ "View other User's Mass Pays");

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

$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
                                                <i class=\"fa fa-home\" aria-hidden=\"true\"></i>
						<span style=\"text-decoration:none;\">Home</span>
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>
					<li onclick=\"openATab('#allmodules', 'grp=40&typ=5');\">
						<span style=\"text-decoration:none;\">All Modules</span>
					</li>";

if ($lgn_num > 0 && $canview === true) {
    $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
						<span style=\"text-decoration:none;\">Bills/Payments Menu</span>
					</li>";
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
    } else if ($pgNo == 1 || $pgNo == 2 || $pgNo == 3) {
        //Get My Bills/Payment Slips
        require 'my_bills_slips.php';
    } else if ($pgNo == 4) {
        require "individual_pymnts.php";
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
        'ALL-TIME OUTSTANDING BALANCES', 
        -1 wkfMsgID,
        'Completed Succesfully' status, 
        to_char(now(),'YYYY-MM-DD HH24:MI:SS') pay_date, 
        '' attachments "
            . " UNION "
            . " SELECT -1 pay_red_hdr_id, a.mass_pay_id, 
        REPLACE((CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END),'Quick Pay Run','Quick Run of Items') mspy_name, 
        REPLACE((CASE WHEN a.mass_pay_desc!='' THEN a.mass_pay_desc ELSE (CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END) END),'Quick Pay Run','Quick Run of Items'), 
        -1 wkfMsgID,
        CASE WHEN a.run_status='1' AND a.sent_to_gl='1' THEN 'Completed Succesfully' ELSE 'Incomplete' END status, 
        a.mass_pay_trns_date pay_date, '' attachments 
      FROM pay.pay_mass_pay_run_hdr a 
      WHERE ($wherecls((Select count(1) from pay.pay_itm_trnsctns z where z.person_id = " . $prsnID .
            " and z.mass_pay_id = a.mass_pay_id and z.pymnt_vldty_status='VALID' and z.src_py_trns_id<=0)>=1) AND (org_id = " . $_SESSION['ORG_ID'] .
            ")) "
            . " UNION "
            . "SELECT pymnt_req_hdr_id, mass_pay_hdr_id, ''||pymnt_req_hdr_id, pymnt_req_hdr_desc, 
       wkf_msg_id, status, payment_date, attachments
  FROM self.self_prsn_intrnl_pymnts_hdr a 
  WHERE ($wherecls1((Select count(1) from self.self_prsn_intrnl_pymnts z where z.payer_person_id = " . $prsnID .
            " and z.pymnt_req_hdr_id = a.pymnt_req_hdr_id)>=1))) tbl1 "
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
        '' attachments "
            . " UNION "
            . " SELECT -1 pay_red_hdr_id, a.mass_pay_id, 
        CASE WHEN a.mass_pay_id<=0 THEN 'Manual/Direct Payment' ELSE a.mass_pay_name END mspy_name, 
        a.mass_pay_desc, 
        -1 wkfMsgID,
        CASE WHEN a.run_status='1' AND a.sent_to_gl='1' THEN 'Completed Succesfully' ELSE 'Incomplete' END status, 
        a.mass_pay_trns_date pay_date, '' attachments 
      FROM pay.pay_mass_pay_run_hdr a 
      WHERE ($wherecls((Select count(1) from pay.pay_itm_trnsctns z where z.person_id = " . $prsnID .
            " and z.mass_pay_id = a.mass_pay_id and z.pymnt_vldty_status='VALID' and z.src_py_trns_id<=0)>=1) AND (org_id = " . $_SESSION['ORG_ID'] .
            ")) "
            . " UNION "
            . "SELECT pymnt_req_hdr_id, mass_pay_hdr_id, ''||pymnt_req_hdr_id, pymnt_req_hdr_desc, 
       wkf_msg_id, status, payment_date, attachments
  FROM self.self_prsn_intrnl_pymnts_hdr a 
  WHERE ($wherecls1((Select count(1) from self.self_prsn_intrnl_pymnts z where z.payer_person_id = " . $prsnID .
            " and z.pymnt_req_hdr_id = a.pymnt_req_hdr_id)>=1))) tbl1 ";
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

function get_RcvblsDocHdr($searchWord, $searchIn, $offset, $limit_size, $orgID, $shwUnpstdOnly) {
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
    $strSql = "SELECT rcvbls_invc_hdr_id, rcvbls_invc_number, 
rcvbls_invc_type, round(a.invoice_amount-a.amnt_paid,2),
 a.approval_status
        FROM accb.accb_rcvbls_invc_hdr a 
        WHERE((a.org_id = " . $orgID . ")" . $whrcls . $unpstdCls .
            ") ORDER BY rcvbls_invc_hdr_id DESC LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);

    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_RcvblsDocHdrTtl($searchWord, $searchIn, $orgID, $shwUnpstdOnly) {
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

?>
