<?php

$menuItems = array("Chart of Accounts", "Journal Entries", "Petty Cash Vouchers","Transactions Search",
    "Financial Statements", "Budgets", "Transaction Templates",
    "Payables and Receivables", "Accounting Periods");
$menuImages = array("rho_arrow1.png", "rho_arrow1.png", "rho_arrow1.png"
    , "rho_arrow1.png", "rho_arrow1.png", "rho_arrow1.png", "rho_arrow1.png"
    , "rho_arrow1.png");

$mdlNm = "Accounting";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Accounting", "View Chart of Accounts",
    "View Account Transactions", "View Transactions Search", /* 4 */ "View/Generate Trial Balance",
    "View/Generate Profit & Loss Statement", "View/Generate Balance Sheet", "View Budgets",
    "View Transaction Templates", "View Record History", "View SQL", /* 11 */ "Add Chart of Accounts",
    "Edit Chart of Accounts", "Delete Chart of Accounts", /* 14 */ "Add Batch for Transactions",
    "Edit Batch for Transactions", "Void/Delete Batch for Transactions", /* 17 */ "Add Transactions Directly",
    "Edit Transactions", "Delete Transactions", /* 20 */ "Add Transactions Using Template", "Post Transactions",
    /* 22 */ "Add Budgets", "Edit Budgets", "Delete Budgets",
    /* 25 */ "Add Transaction Templates", "Edit Transaction Templates",
    "Delete Transaction Templates", "View Only Self-Created Transaction Batches",
    "View Payables and Receivables", "View Accounting Periods", "View Financial Statements");

$canview = test_prmssns($dfltPrvldgs[0], $mdlNm);
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
        
    } else if ($qstr == "UPDATE") {
        if ($actyp == 1) {
            
        }
    } else {
        if ($pgNo == 0) {

            $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">Accounting Menu</span>
					</li>
                                       </ul>
                                     </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
                    <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This module helps you manage all financial matters in your organisation. The module has the ff areas:</span>
                    </div>
        <p>";
            $grpcntr = 0;
            for ($i = 0; $i < count($menuItems); $i++) {
                $No = $i + 1;
                if ($i == 0) {
                    
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
        } else if ($pgNo == 1) {
            require "accnts_chrt.php";
        } else if ($pgNo == 2) {
            require "accnt_trns.php";
        } else if ($pgNo == 3) {
            require "trns_srch.php";
        } else if ($pgNo == 4) {
            require "fin_stmnts.php";
        } else if ($pgNo == 5) {
            require "bdgts.php";
        } else if ($pgNo == 6) {
            require "trns_tmplts.php";
        } else if ($pgNo == 7) {
            require "pybls_rcvbls.php";
        } else if ($pgNo == 8) {
            require "accnt_periods.php";
        } else {
            restricted();
        }
    }
} else {
    restricted();
}
?>
