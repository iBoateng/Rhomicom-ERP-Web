<?php

$menuItems = array("My Bills/Payment Slips", "Linked Customer Invoices", "Linked Supplier Invoices",
    "Manual Payments", "Pay Item Sets",
    "Person Sets", "Mass Pay Runs", "Payment Transactions",
    "GL Interface Table", "Pay Items", "Global Values");
$menuImages = array("bills.png", "invcBill.png", "invoice1.png", "pay.png",
    "wallet.png", "staffs.png", "bulkPay.png", "search.png", "GL-256.png", "chcklst4.png", "world_48.png");

$mdlNm = "Internal Payments";
$ModuleName = $mdlNm;
$pageHtmlID = "intPymntsPage";

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
        /*      <div class='rho_form1' style=\"background-color:#e3e3e3;border: 1px solid #999;
          padding:5px 30px 5px 10px;max-height:50px;margin-bottom:2px;\">
          <span style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
          font-weight:bold;\">BILLS/PAYMENTS RECORDS MANAGER MODULE</span>
          </div><!--<span>&nbsp;&nbsp;&nbsp;This is where Internal Payments and Bills in the Organisation are Captured and Managed.
          For Customers, Suppliers and Registered Firms in the Organisation, your Invoices can be seen from here also. The module has the ff areas:</span>-->
          <legend>   Bills/Payments Records Manager
          </legend>max-height:80px; <legend>   BILLS/PAYMENTS RECORDS MANAGER MODULE
          </legend> */
        $cntent = "<div id='rho_form' style=\"min-height:150px;width:100%;\">
                <fieldset style=\"padding:2px 2px 2px 2px;margin:0px 0px 0px 0px !important;\">
                    <div class='rho_form3' style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:2px 30px 5px 20px;\" class=\"rho-postcontent rho-postcontent-0 clearfix\">        
                    <h3>WELCOME TO THE BILLS/PAYMENTS RECORDS MANAGER</h3>
                    <div class='rho_form44' style=\"padding:5px 30px 5px 10px;margin-bottom:1px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is where Internal Payments and Bills in the Organisation are Captured and Managed. 
      For Customers, Suppliers and Registered Firms in the Organisation, your Invoices can be seen from here also. The module has the ff areas:</span>
                    </div> 
      <p>";
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($i == 0) {
                
            } else if ($i == 1) {
                
            } else if ($i == 2) {
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
                $cntent.= "<div style=\"float:none;\">"
                        . "<ul class=\"no_bullet\" style=\"float:none;\">";
            }
            //
//            if($i==3 && strpos(get_LtstPrsnType(getUserPrsnID1($usrID)),'')===FALSE)
//            {
//                continue;
//            }
            $cntent .= "<li class=\"leaf\" style=\"margin:2px 2px 2px 2px;\">"
                    . "<a href=\"javascript: showPageDetails('$pageHtmlID', $No);\" class=\"x-btn x-unselectable x-btn-default-large\" "
                    . "style=\"padding:0px;height:90px;width:140px;\" "
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
        //Get My Bills/Payment Slips
        $prsnid = $_SESSION['PRSN_ID'];
        if ($vwtyp == 0) {

            $total = get_MyPyRnsTtl($srchFor, $srchIn, $prsnid);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_MyPyRnsTblr($srchFor, $srchIn, $curIdx, $lmtSze, $prsnid);
            $myPyRns = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                $chckd = ($cntr == 0) ? TRUE : FALSE;
                $myPyRn = array(
                    'checked' => var_export($chckd, TRUE),
                    'PayReqHdrID' => $row[0],
                    'MassPayID' => $row[1],
                    'MassPayName' => $row[2],
                    'MassPayDesc' => $row[3],
                    'WkfMsgID' => $row[4],
                    'Status' => $row[5],
                    'Attachments' => $row[7]);
                $myPyRns[] = $myPyRn;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $myPyRns));
        } else if ($vwtyp == 1) {
            $total = 500;
            //var_dump($_POST);
            $pkID = isset($_POST['pyReqHdrID']) ? $_POST['pyReqHdrID'] : -1;
            if ($pkID <= 0) {
                $pkID = isset($_POST['mspyHdrID']) ? $_POST['mspyHdrID'] : -1;
            }
            $result = null;
            if ($pkID <= 0) {
                $result = get_CumltiveBals($prsnid);
            } else {
                $result = get_MyPyRnsDt($pkID, $prsnid);
            }
            $myPyRnDts = array();
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $myPyRnDt = array(
                    'PymntReqId' => $row[0],
                    'PayItemID' => $row[5],
                    'PayItemName' => $row[6],
                    'PayItemAmount' => $row[7],
                    'PayTrnsDate' => $row[8],
                    'LineDescription' => $row[9]);
                $myPyRnDts[] = $myPyRnDt;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $myPyRnDts));
        }
    } else if ($pgNo == 2) {
        //require "prs_data_chng_rqst.php";
    } else {
        restricted();
    }
} else {
    restricted();
}

function get_MyPyRnsDt($pkID, $prsnID) {
    $sqlStr = "SELECT tbl1.* FROM 
        (SELECT pymnt_req_id, payer_person_id, mass_pay_hdr_id, pymnt_req_hdr_id, 
       pymnt_trns_id, pay_item_id, org.get_payitm_nm(pay_item_id) itmNm, 
       amount_paid, payment_date, line_description
  FROM self.self_prsn_intrnl_pymnts a
  WHERE (a.pymnt_req_id = " . $pkID . " and payer_person_id = " . $prsnID . ") "
            . " UNION "
            . "SELECT -1, a.person_id, a.mass_pay_id, -1, 
                a.pay_trns_id, a.item_id, org.get_payitm_nm(a.item_id) itmNm, 
                a.amount_paid, a.paymnt_date, a.pymnt_desc 
FROM pay.pay_itm_trnsctns a 
WHERE(a.mass_pay_id = " . $pkID . " and person_id = " . $prsnID . " and a.pymnt_vldty_status='VALID' and a.src_py_trns_id<=0)) tbl1 "
            . " ORDER BY tbl1.pymnt_trns_id ASC";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_CumltiveBals($prsnID) {
    $sqlStr = "SELECT -1, a.person_id, -1, -1, -1, a.bals_itm_id, b.item_code_name itmNm, "
            . "a.bals_amount amount_paid, "
            . "a.bals_date|| ' 12:00:00' balsdte, b.item_code_name " .
            "FROM pay.pay_balsitm_bals a, org.org_pay_items b " .
            "WHERE((a.person_id = " . $prsnID . ") and (b.item_maj_type='Balance Item' "
            . "and b.balance_type='Cumulative' and a.bals_itm_id = b.item_id)"
            . " and (b.is_enabled = '1') and a.bals_date = (SELECT MAX(c.bals_date) FROM pay.pay_balsitm_bals c "
            . "WHERE c.person_id = " . $prsnID . " and a.bals_itm_id = c.bals_itm_id) "
            . "and (CASE WHEN b.item_code_name ilike '%2016%' "
            . "or b.item_code_name ilike '%2015%' "
            . "or b.item_code_name ilike '%2014%' THEN 1 "
            . "WHEN a.bals_amount!=0 THEN 1 ELSE 0 END)=1) "
            . "ORDER BY a.bals_date DESC, b.item_code_name, b.pay_run_priority";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_MyPyRnsTblr($searchFor, $searchIn, $offset, $limit_size, $prsnID) {
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

?>
