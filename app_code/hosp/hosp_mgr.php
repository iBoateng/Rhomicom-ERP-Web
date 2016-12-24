<?php

$menuItems = array("Summary Dashboard",
    "Visits & Appointments", "Appointment Data",
    "Services Offered", "Service Providers", "List of Diagnosis",
    "Lab Investigations List");
$menuImages = array("dashboard220.png","alarm-clock.png","appoint.png",
    "chcklst2.png","practioner.jpg","chcklst1.png","checklist1.jpg");

$brghtMdl = isset($_POST['mdl']) ? cleanInputData($_POST['mdl']) : 'Visits and Appointments';
$mdlNm = $brghtMdl;
$ModuleName = $mdlNm;
$viewRoleName = "View $brghtMdl";

$dfltPrvldgs = array(/* 0 */ $viewRoleName,
    /* 1 */ "View Visits/Appointments", "View Appointments Data", "View Service Providers", "View Services Offered",
    /* 5 */ "View SQL", "View Record History",
    /* 7 */ "Add Visits/Appointments", "Edit Visits/Appointments", "Delete Visits/Appointments",
    /* 10 */ "Add Appointment Data", "Edit Appointment Data", "Delete Appointment Data",
    /* 13 */ "Add Services Offered", "Edit Services Offered", "Delete Services Offered",
    /* 16 */ "Add Service Providers", "Edit Service Providers", "Delete Service Providers",
    /* 19 */ "View only Self-Created Sales", "Cancel Documents", "Take Payments",
    /* 22 */ "Apply Adhoc Discounts", "Apply Pre-defined Discounts",
    /* 24 */ "Can Edit Unit Price", "View Other Provider's Data",
    /* 26 */ "Add List of Diagnosis", "Edit List of Diagnosis", "Delete List of Diagnosis",
    /* 29 */ "View Lab Investigations List", "Edit Lab Investigations List", "Delete Lab Investigations List");


$canview = test_prmssns($dfltPrvldgs[0], $ModuleName);

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
						<span style=\"text-decoration:none;\">$brghtMdl Menu</span>
					</li>
                                       </ul>
                                     </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
      <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This module helps you to manage your organization's Client Visits and Appointments Scheduling!. The module has the ff areas:</span>
                    </div>
      <p>";
            $grpcntr = 0;
            for ($i = 0; $i < count($menuItems); $i++) {
                $No = $i + 1;
                if ($i >=5 && $brghtMdl !="Clinic/Hospital") {
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
            //require "org_setups.php";
        } else {
            restricted();
        }
    }
}
?>
