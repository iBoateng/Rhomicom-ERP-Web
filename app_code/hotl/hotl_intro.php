<?php

$menuItems = array("Summary Dashboard", "Reservations / Check-Ins",
                           "Facility Types", "Restaurant",
                           "Gym / Pool/ Sports","Complaints / Issues", "General Rentals"
    );
$menuImages = array("dashboard220.png", "booking.png", "categories.png", "menu.ico",  "sports.png"
    , "list.jpg", "rent1.png");

$mdlNm = "Hospitality Management";
$ModuleName = $mdlNm;

$dfltPrvldgs = array( 
        /*1*/ "View Hospitality Manager", "View Rooms Dashboard",
        /*2*/ "View Reservations", "View Check Ins", "View Service Types", 
        /*5*/ "View Restaurant","View Gym",
        /*7*/ "Add Service Types","Edit Service Types","Delete Service Types",
        /*10*/"Add Check Ins","Edit Check Ins","Delete Check Ins", 
        /*13*/"Add Applications","Edit Applications","Delete Applications",
        /*16*/"Add Gym Types","Edit Gym Types","Delete Gym Types",
        /*19*/"Add Gym Registration","Edit Gym Registration","Delete Gym Registration",
        /*22*/"View SQL","View Record History", 
        /*24*/"Add Table Order","Edit Table Order","Delete Table Order", "Setup Tables",
        /*28*/"View Complaints/Observations","Add Complaints/Observations","Edit Complaints/Observations","Delete Complaints/Observations",
        /*32*/"View only Self-Created Sales","Cancel Documents","Take Payments","Apply Adhoc Discounts", "Apply Pre-defined Discounts", 
        /*37*/"View Rental Item", "Can Edit Unit Price");

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
						<span style=\"text-decoration:none;\">Hospitality Menu</span>
					</li>";
        if ($pgNo == 0) {
            $cntent .= " </ul></div>
                <div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
                    <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This module helps you to manage your organization's Hospitality Needs! The module has the ff areas:</span>
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
            require "sales_invc.php";
        } else if ($pgNo == 2) {
            require "purchases.php";
        } else if ($pgNo == 3) {
            require "item_list.php";
        } else if ($pgNo == 4) {
            require "prdct_ctgries.php";
        } else if ($pgNo == 5) {
            require "stores.php";
        } else if ($pgNo == 6) {
            require "receipts.php";
        } else if ($pgNo == 7) {
            require "rcpts_returns.php";
        } else if ($pgNo == 8) {
            require "itm_tmplts.php";
        } else if ($pgNo == 9) {
            require "itm_balances.php";
        } else if ($pgNo == 10) {
            require "uom.php";
        } else if ($pgNo == 11) {
            require "stock_trnsfr.php";
        } else if ($pgNo == 12) {
            require "misc_adjstmnts.php";
        } else if ($pgNo == 13) {
            require "gl_intrfc.php";
        } else if ($pgNo == 14) {
            require "production.php";
        } else {
            restricted();
        }
    }
} else {
    restricted();
}
?>
