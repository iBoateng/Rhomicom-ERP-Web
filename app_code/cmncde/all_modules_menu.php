<?php

//session_start();
$menuItems = array("Summary Dashboard", "Personal Records", "Bills/Payments", "Events & Attendance",
    "Elections Centre", "e-Library & e-Learning", "Accounting",
    "Sales & Inventory", "Visits & Appointments", "Hospitality Management",
    "Performance Management", "Projects Management", "Clinic & Hospital",
    "Banking & Micro-finance", "System Administration", "Organisation Setup",
    "Value Lists Setup", "Workflow Administration");
$menuImages = array("dashboard220.png", "person.png", "invcBill.png", "calendar2.png",
    "election.png", "addresses_wbg_64x64.png", "GL-256.png",
    "Inventory.png", "Calander.png", "rent1.png",
    "education.png", "engineer.png", "medical.png",
    "bank_256.png", "ma-logo.png", "Home.png",
    "viewIcon.png", "bb_flow.gif");
$menuLinks = array("grp=40&typ=5", "grp=8&typ=1", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5");
$mdlNms = array("Basic Person Data", "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data");

$dfltPrvldgs = array("View Person", "View Person", "View Person", "View Person",
    "View Person", "View Person", "View Person",
    "View Person", "View Person", "View Person",
    "View Person", "View Person", "View Person",
    "View Person", "View Person", "View Person",
    "View Person", "View Person");
$canview = test_prmssns($dfltPrvldgs[0], $mdlNms[0]) || test_prmssns("View Self-Service", "Self Service");
$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
						<span style=\"text-decoration:none;\">Home</span><span class=\"divider\"> / </span>
					</li>
					<li onclick=\"openATab('#allmodules', 'grp=40&typ=5');\">
						<span style=\"text-decoration:none;\">All Modules</span>
					</li>
				</ul>
			</div>";
if ($lgn_num > 0 && $canview === true) {
    $grpcntr = 0;
    $cntent.="<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em; padding:5px 10px 15px 10px;border:1px solid #ccc;\">";
    for ($i = 0; $i < count($menuItems); $i++) {
        if ($i > 0) {
            if (test_prmssns($dfltPrvldgs[$i], $mdlNms[$i]) == FALSE) {
                continue;
            }
        }
        if ($grpcntr == 0) {
            $cntent.= "<div class=\"row\">";
        }
        $cntent.= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allmodules', '$menuLinks[$i]]');\">
            <img src=\"cmn_images/$menuImages[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItems[$i]) . "</span>
        </button>
    </div>";

        if ($grpcntr == 3 || $i == count($menuItems) - 1) {
            $cntent.= "</div>";
            $grpcntr = 0;
        } else {
            $grpcntr = $grpcntr + 1;
        }
    }
    echo "</div>" . $cntent;
}
?>