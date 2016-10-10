<?php

$menuItems = array("Chart of Accounts",
                "Accounting Transactions", "Transactions Search", 
    "Financial Statements", "Budgets", "Transaction Templates",
    "Payables and Receivables", "Accounting Periods");

require $base_dir."admin_funcs.php";

$vwtyp1 = 0;
//echo $vwtyp1;
if (isset($_REQUEST['vwtyp']))
    $vwtyp1 = $_REQUEST['vwtyp'];
//echo $vwtyp1;
if ($vwtyp1 <= 100) {
    require $base_dir."rho_header.php";
}
$pgNo = 0;
$grp = 6;
$typ = 1;

$mdlNm = "Accounting";
$ModuleName = $mdlNm;
if (isset($_REQUEST['pg']))
    $pgNo = $_REQUEST['pg'];
if (isset($_REQUEST['q']))
    $mdlNm = $_REQUEST['q'];
if (isset($_REQUEST['grp']))
    $grp = $_REQUEST['grp'];
if (isset($_REQUEST['typ']))
    $typ = $_REQUEST['typ'];


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
    "View Payables and Receivables","View Accounting Periods","View Financial Statements");

$canview = test_prmssns($dfltPrvldgs[0], $mdlNm);

if ($lgn_num > 0 && $canview === true) {
    if ($pgNo == 0) {
        $cntent = "<div id='rho_form' style=\"min-height:150px;\">
            <form id='orgStpForm' action='' method='post' accept-charset='UTF-8'>
                <fieldset style=\"padding:10px 20px 20px 20px;\">
                    <legend>   $mdlNm                
                    </legend>
                    <div style=\"margin-bottom:10px;\">
                    <h2>Welcome to the Accounting/Finance Module</h2>
                    </div>                    
                    <div class='rho_form1' style=\"background-color:#e3e3e3;border: 1px solid #999;padding:10px;\" class=\"rho-postcontent rho-postcontent-0 clearfix\">                    
      <h5>FUNCTIONALITIES OF THE ACCOUNTING/FINANCE MODULE</h5>
      <p>This module helps you manage all financial matters in your organisation. The module has the ff areas:";
        
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($grpcntr == 0) {
                $cntent.= "<div style=\"float:left;\">"
                        . "<ul class=\"no_bullet\">";
            }
            $cntent.= "<li class=\"leaf\" style=\"background: url('cmn_images/start.png') no-repeat 3px 4px; background-size:20px 20px;\">"
                    . "<a onclick=\"modules('$mdlNm', $No);\">$menuItems[$i]</a></li>";

            if ($grpcntr == 2) {
                $cntent.= "</ul>"
                        . "</div>";
                $grpcntr = 0;
            } else {
                $grpcntr = $grpcntr + 1;
            }
        }
        $cntent.= "</p>
    </div>
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
        require "accnts_chrt.php";
    }else if ($pgNo == 2) {
        require "accnt_trns.php";
    }else if ($pgNo == 3) {
        require "trns_srch.php";
    }else if ($pgNo == 4) {
        require "fin_stmnts.php";
    }else if ($pgNo == 5) {
        require "bdgts.php";
    }else if ($pgNo == 6) {
        require "trns_tmplts.php";
    }else if ($pgNo == 7) {
        require "pybls_rcvbls.php";
    }else if ($pgNo == 8) {
        require "accnt_periods.php";
    } else {
        restricted();
    }
} else {
    restricted();
}

if ($vwtyp1 <= 100) {
    require $base_dir.'rho_footer.php';
}
?>
