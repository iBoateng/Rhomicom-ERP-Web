<?php

$menuItems = array("Chart of Accounts", "Journal Entries", "Petty Cash Vouchers", "Transactions Search",
    "Financial Statements", "Budgets", "Transaction Templates", "Accounting Periods",
    "Assets/Investments", "Payables Invoices", "Receivables Invoices", "Invoice Payments",
    "Business Partners/Firms", "Tax Codes", "Default Accounts", "Account Reconciliation");
$menuImages = array("GL-256.png", "generaljournal.png", "cashbook_big_icon.png"
    , "CustomIcon.png", "dfltAccnts1.jpg", "budget.jpg", "templates.jpg"
    , "calendar2.ico", "assets1.jpg", "bills.png", "rcvbls1.jpg"
    , "pymnts1.jpg", "cstmrs1.jpg", "tax1.jpg", "settings.png"
    , "mi_scare_report.png");

$mdlNm = "Accounting";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Accounting", "View Chart of Accounts",
    /* 2 */ "View Account Transactions", "View Transactions Search",
    /* 4 */ "View/Generate Trial Balance", "View/Generate Profit & Loss Statement",
    /* 6 */ "View/Generate Balance Sheet", "View Budgets",
    /* 8 */ "View Transaction Templates", "View Record History", "View SQL",
    /* 11 */ "Add Chart of Accounts", "Edit Chart of Accounts", "Delete Chart of Accounts",
    /* 14 */ "Add Batch for Transactions", "Edit Batch for Transactions", "Void/Delete Batch for Transactions",
    /* 17 */ "Add Transactions Directly", "Edit Transactions", "Delete Transactions",
    /* 20 */ "Add Transactions Using Template", "Post Transactions",
    /* 22 */ "Add Budgets", "Edit Budgets", "Delete Budgets",
    /* 25 */ "Add Transaction Templates", "Edit Transaction Templates", "Delete Transaction Templates",
    /* 28 */ "View Only Self-Created Transaction Batches",
    /* 29 */ "View Financial Statements", "View Accounting Periods", "View Payables",
    /* 32 */ "View Receivables", "View Customers/Suppliers", "View Tax Codes",
    /* 35 */ "View Default Accounts", "View Account Reconciliation",
    /* 37 */ "Add Accounting Periods", "Edit Accounting Periods", "Delete Accounting Periods",
    /* 40 */ "View Fixed Assets", "View Payments",
    /* 42 */ "Add Payment Methods", "Edit Payment Methods", "Delete Payment Methods",
    /* 45 */ "Add Supplier Standard Payments", "Edit Supplier Standard Payments", "Delete Supplier Standard Payments",
    /* 48 */ "Add Supplier Advance Payments", "Edit Supplier Advance Payments", "Delete Supplier Advance Payments",
    /* 51 */ "Setup Exchange Rates", "Setup Document Templates", "Review/Approve Payables Documents", "Review/Approve Receivables Documents",
    /* 55 */ "Add Direct Refund from Supplier", "Edit Direct Refund from Supplier", "Delete Direct Refund from Supplier",
    /* 58 */ "Add Supplier Credit Memo (InDirect Refund)", "Edit Supplier Credit Memo (InDirect Refund)", "Delete Supplier Credit Memo (InDirect Refund)",
    /* 61 */ "Add Direct Topup for Supplier", "Edit Direct Topup for Supplier", "Delete Direct Topup for Supplier",
    /* 64 */ "Add Supplier Debit Memo (InDirect Topup)", "Edit Supplier Debit Memo (InDirect Topup)", "Delete Supplier Debit Memo (InDirect Topup)",
    /* 67 */ "Cancel Payables Documents", "Cancel Receivables Documents",
    /* 69 */ "Reject Payables Documents", "Reject Receivables Documents",
    /* 71 */ "Pay Payables Documents", "Pay Receivables Documents",
    /* 73 */ "Add Customer Standard Payments", "Edit Customer Standard Payments", "Delete Customer Standard Payments",
    /* 76 */ "Add Customer Advance Payments", "Edit Customer Advance Payments", "Delete Customer Advance Payments",
    /* 79 */ "Add Direct Refund to Customer", "Edit Direct Refund to Customer", "Delete Direct Refund to Customer",
    /* 82 */ "Add Customer Credit Memo (InDirect Topup)", "Edit Customer Credit Memo (InDirect Topup)", "Delete Customer Credit Memo (InDirect Topup)",
    /* 85 */ "Add Direct Topup from Customer", "Edit Direct Topup from Customer", "Delete Direct Topup from Customer",
    /* 88 */ "Add Customer Debit Memo (InDirect Refund)", "Edit Customer Debit Memo (InDirect Refund)", "Delete Customer Debit Memo (InDirect Refund)",
    /* 91 */ "Add Customers/Suppliers", "Edit Customers/Suppliers", "Delete Customers/Suppliers",
    /* 94 */ "Add Fixed Assets", "Edit Fixed Assets", "Delete Fixed Assets"
    /* 97 */, "View Petty Cash Vouchers", "View Petty Cash Payments", "Add Petty Cash Payments", "Edit Petty Cash Payments", "Delete Petty Cash Payments"
    /* 102 */, "View Petty Cash Re-imbursements", "Add Petty Cash Re-imbursements", "Edit Petty Cash Re-imbursements", "Delete Petty Cash Re-imbursements");

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
						<span style=\"text-decoration:none;\">All Modules&nbsp;</span><span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>";
if ($lgn_num > 0 && $canview === true) {
    if ($qstr == "DELETE") {
        
    } else if ($qstr == "UPDATE") {
        if ($actyp == 1) {
            
        }
    } else {
        $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">Accounting Menu</span>
					</li>";
        if ($pgNo == 0) {
            $cntent .= " </ul></div>
                <div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
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
            echo $cntent;
        } else if ($pgNo == 1) {
            require "accnts_chrt.php";
        } else if ($pgNo == 2) {
            require "journal_entries.php";
        } else if ($pgNo == 3) {
            require "ptty_cash.php";
        } else if ($pgNo == 4) {
            require "trns_srch.php";
        } else if ($pgNo == 5) {
            require "fin_stmnts.php";
        } else if ($pgNo == 6) {
            require "bdgts.php";
        } else if ($pgNo == 7) {
            require "trns_tmplts.php";
        } else if ($pgNo == 8) {
            require "accnt_periods.php";
        } else if ($pgNo == 9) {
            require "assets_rgstr.php";
        } else if ($pgNo == 10) {
            require "pybls_invc.php";
        } else if ($pgNo == 11) {
            require "rcvbls_invc.php";
        } else if ($pgNo == 12) {
            require "invc_pymnts.php";
        }  else if ($pgNo == 13) {
            require "business_prtnrs.php";
        }  else if ($pgNo == 14) {
            require "tax_codes.php";
        }  else if ($pgNo == 15) {
            require "dflt_accnts.php";
        }  else if ($pgNo == 16) {
            require "accnt_rcncl.php";
        }  else {
            restricted();
        }
    }
} else {
    restricted();
}
?>
