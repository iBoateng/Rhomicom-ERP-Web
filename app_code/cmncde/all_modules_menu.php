<?php
$menuItems = array("Personal Records", "Bills/Payments", "Events & Attendance",
    "Elections Centre", "e-Library", "Accounting",
    "Sales & Inventory", "Hospitality Management", "Visits & Appointments",
    "Performance Management", "Projects Management", "Clinic & Hospital",
    "Banking & Micro-finance", "Summary Dashboard");
$menuImages = array("person.png", "invcBill.png", "calendar2.png",
    "election.png", "addresses_wbg_64x64.png", "GL-256.png",
    "Inventory.png", "rent1.png", "Calander.png",
    "education.png", "engineer.png", "medical.png",
    "bank_256.png", "dashboard220.png");
$menuLinks = array("grp=8&typ=1", "grp=7&typ=1", "grp=16&typ=1",
    "grp=19&typ=10", "grp=19&typ=12", "grp=6&typ=1",
    "grp=12&typ=1", "grp=18&typ=1", "grp=14&typ=1",
    "grp=15&typ=1", "grp=13&typ=1", "grp=14&typ=1&mdl=Clinic/Hospital",
    "grp=17&typ=1", "grp=40&typ=4");
$mdlNms = array("Basic Person Data", "Internal Payments", "Events And Attendance",
    "e-Voting", "e-Library", "Accounting",
    "Stores And Inventory Manager", "Hospitality Management", "Visits and Appointments",
    "Learning/Performance Management", "Projects Management", "Clinic/Hospital",
    "Basic Person Data", "Self Service");

$dfltPrvldgs = array(
    "View Person", "View Internal Payments", "View Events And Attendance",
    "View e-Voting", "View e-Library", "View Accounting",
    "View Inventory Manager", "View Hospitality Manager", "View Visits and Appointments",
    "View Learning/Performance Management", "View Projects Management", "View Clinic/Hospital",
    "View Person", "View Self-Service");

$canview = test_prmssns($dfltPrvldgs[0], $mdlNms[0]) || test_prmssns("View Self-Service", "Self Service");
$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
                                                <i class=\"fa fa-home\" aria-hidden=\"true\"></i>
						<span style=\"text-decoration:none;\">Home</span>
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>
					<li onclick=\"openATab('#allmodules', 'grp=40&typ=5');\">
						<span style=\"text-decoration:none;\">All Modules</span>
					</li>
				</ul>
			</div>";
if ($lgn_num > 0 && $canview === true) {
    $grpcntr = 0;
    $appCntr = 0;
    $cntent .= "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em; padding:5px 10px 15px 10px;border:1px solid #ccc;\">";
    for ($i = 0; $i < count($menuItems); $i++) {
        if ($i > 0) {
            if (test_prmssns($dfltPrvldgs[$i], $mdlNms[$i]) == FALSE) {
                continue;
            }
        }
        if ($grpcntr == 0) {
            $cntent .= "<div class=\"row\">";
        }

        $cntent .= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allmodules', '$menuLinks[$i]');\">
            <img src=\"cmn_images/$menuImages[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItems[$i]) . "</span>
        </button>
    </div>";
        $appCntr += 1;
        if ($grpcntr == 3 || $i == count($menuItems) - 1) {
            $cntent .= "</div>";
            $grpcntr = 0;
        } else {
            $grpcntr = $grpcntr + 1;
        }
    }
    echo "</div>" . $cntent;


    $menuItemsAdmn = array("System Administration", "Organization Setup",
        "Value Lists Setup", "Workflow Administration", "Notices & Content Management", "Reports / Processes");
    $menuImagesAdmn = array("ma-logo.png", "Home.png",
        "viewIcon.png", "bb_flow.gif",
        "Notebook.png", "settings.png");
    $menuLinksAdmn = array("grp=3&typ=1", "grp=5&typ=1",
        "grp=4&typ=1", "grp=11&typ=1", "grp=40&typ=3&vtyp=1",
        "grp=9&typ=1");
    $mdlNmsAdmn = array("System Administration", "Organization Setup",
        "General Setup", "Workflow Manager", "System Administration",
        "Reports And Processes");

    $dfltPrvldgsAdmn = array("View System Administration",
        "View Organization Setup", "View General Setup",
        "View Workflow Manager", "View Notices Admin",
        "View Reports And Processes");

    $canViewSysAdmin = test_prmssns("View System Administration", "System Administration");
    $canViewOrgStp = test_prmssns("View Organization Setup", "Organization Setup");
    $canViewLov = test_prmssns("View General Setup", "General Setup");
    $canViewWkf = test_prmssns("View Workflow Manager", "Workflow Manager");
    $canViewArtclAdmn = test_prmssns("View Notices Admin", "System Administration");
    $canViewRpts = test_prmssns("View Reports And Processes", "Reports And Processes");

    if ($canViewSysAdmin || $canViewOrgStp || $canViewLov || $canViewWkf || $canViewArtclAdmn || $canViewRpts) {
        $canview = test_prmssns($dfltPrvldgsAdmn[0], $mdlNmsAdmn[0]);
        $grpcntrAdmn = 0;
        $appCntrAdmn = 0;
        $cntentAdmn = "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 14px; padding:5px 10px 5px 10px;border:1px solid #ccc;margin-top:10px;\">";
        for ($i = 0; $i < count($menuItemsAdmn); $i++) {
            if ($i == 0 && $canViewSysAdmin == FALSE) {
                continue;
            } else if ($i == 1 && $canViewOrgStp == FALSE) {
                continue;
            } else if ($i == 2 && $canViewLov == FALSE) {
                continue;
            } else if ($i == 3 && $canViewWkf == FALSE) {
                continue;
            } else if ($i == 4 && $canViewArtclAdmn == FALSE) {
                continue;
            } else if ($i == 5 && $canViewRpts == FALSE) {
                continue;
            }
            if ($grpcntrAdmn == 0) {
                $cntentAdmn .= "<div class=\"row\">";
            }
            if ($i == 4) {
                $cntentAdmn .= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allnotices', '$menuLinksAdmn[$i]');\">
            <img src=\"cmn_images/$menuImagesAdmn[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItemsAdmn[$i]) . "</span>
        </button>
    </div>";
            } else {
                $cntentAdmn .= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allmodules', '$menuLinksAdmn[$i]');\">
            <img src=\"cmn_images/$menuImagesAdmn[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItemsAdmn[$i]) . "</span>
        </button>
    </div>";
            }
            $appCntrAdmn += 1;
            if ($grpcntrAdmn == 3 || $i == count($menuItemsAdmn) - 1) {
                $cntentAdmn .= "</div>";
                $grpcntrAdmn = 0;
            } else {
                $grpcntrAdmn = $grpcntrAdmn + 1;
            }
        }
        echo "</div>" . $cntentAdmn;
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#appsMdlsCnt").html("<?php echo $appCntr; ?>");
        });
    </script>
    <?php
}
?>