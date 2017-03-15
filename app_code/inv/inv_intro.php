<?php

$menuItems = array("Sales/Item Issues", "Purchases", "Item List", "Product Categories", "Stores/Warehouses"
    , "Receipts", "Receipt Returns", "Item Type Templates", "Item Balances", "Unit of Measures", "Stock Transfers",
    "Misc. Adjustments", "GL Interface Table", "Product Creation");
$menuImages = array("sale.jpg", "purchases.jpg", "menu.ico", "categories.png", "WareHouseMgmtIcon.png"
    , "receipt.jpg", "receipt_return.jpg", "item_template.jpg"
    , "invoice.ico", "MeasurementUnitsDegrees.ico", "stock_trnsfr.png", "adjustments.png",
    "GL-256.png", "menu.ico");

$mdlNm = "Stores And Inventory Manager";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Inventory Manager",
    /* 1 */ "View Item List", "View Product Categories", "View Stores/Warehouses"
    /* 4 */, "View Receipts", "View Receipt Returns", "View Item Type Templates",
    /* 7 */ "View Item Balances",
    /* 8 */ "Add Items", "Update Items",
    /* 10 */ "Add Item Stores", "Update Item Stores", "Delete Item Stores",
    /* 13 */ "Add Product Category", "Update Product Category",
    /* 15 */ "Add Stores", "Update Stores",
    /* 17 */ "Add Store Users", "Update Store Users", "Delete Store Users",
    /* 20 */ "Add Store Shelves", "Delete Store Shelves",
    /* 22 */ "Add Receipt", "Delete Receipt",
    /* 24 */ "Add Receipt Return", "Delete Receipt Return",
    /* 26 */ "Add Item Template", "Update Item Template",
    /* 28 */ "Add Template Stores", "Update Template Stores",
    /* 30 */ "View GL Interface",
    /* 31 */ "View SQL", "View Record History", "Send To GL Interface Table",
    /* 34 */ "View Purchases", "View Sales/Item Issues", "View Sales Returns",
    /* 37 */ "View Payments Received",
    /* 38 */ "View Purchase Requisitions", "Add Purchase Requisitions", "Edit Purchase Requisitions", "Delete Purchase Requisitions",
    /* 42 */ "View Purchase Orders", "Add Purchase Orders", "Edit Purchase Orders", "Delete Purchase Orders",
    /* 46 */ "View Pro-Forma Invoices", "Add Pro-Forma Invoices", "Edit Pro-Forma Invoices", "Delete Pro-Forma Invoices",
    /* 50 */ "View Sales Orders", "Add Sales Orders", "Edit Sales Orders", "Delete Sales Orders",
    /* 54 */ "View Sales Invoices", "Add Sales Invoices", "Edit Sales Invoices", "Delete Sales Invoices",
    /* 58 */ "View Internal Item Requests", "Add Internal Item Requests", "Edit Internal Item Requests", "Delete Internal Item Requests",
    /* 62 */ "View Item Issues-Unbilled", "Add Item Issues-Unbilled", "Edit Item Issues-Unbilled", "Delete Item Issues-Unbilled",
    /* 66 */ "View Sales Returns", "Add Sales Return", "Edit Sales Return", "Delete Sales Return",
    /* 70 */ "Send GL Interface Records to GL", "Cancel Documents", "View only Self-Created Documents",
    /* 73 */ "View UOM", "Add UOM", "Edit UOM", "Delete UOM", "Make Payments", "Delete Product Category",
    /* 79 */ "View UOM Conversion", "Add UOM Conversion", "Edit UOM Conversion", "Delete UOM Conversion",
    /* 83 */ "View Drug Interactions", "Add Drug Interactions", "Edit Drug Interactions", "Delete Drug Interactions",
    /* 87 */ "Edit Receipt", "Edit Returns", "Edit Store Transfers", "Edit Adjustments",
    /* 91 */ "Clear Stock Balance", "Do Quick Receipt",
    /* 93 */ "View Item Production", "Add Item Production", "Edit Item Production", "Delete Item Production",
    /* 97 */ "Setup Production Processes", "Apply Adhoc Discounts",
    /* 99 */ "View Production Runs", "Add Production Runs", "Edit Production Runs", "Delete Production Runs",
    /* 103 */ "Can Edit Unit Price");

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
						<span style=\"text-decoration:none;\">Sales/Inventory Menu</span>
					</li>";
        if ($pgNo == 0) {
            $cntent .= " </ul></div>
                <div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
                    <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This module helps you to manage your organization's Inventory System! The module has the ff areas:</span>
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
