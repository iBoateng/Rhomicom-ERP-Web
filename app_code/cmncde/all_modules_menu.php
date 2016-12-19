<?php
//session_start();
$menuItems = array("Personal Records", "Bills/Payments", "Events & Attendance",
    "Elections Centre", "e-Library & e-Learning", "Accounting",
    "Sales & Inventory", "Hospitality Management", "Visits & Appointments",
    "Performance Management", "Projects Management", "Clinic & Hospital",
    "Banking & Micro-finance"/*, "Summary Dashboard", "System Administration", "Organisation Setup",
    "Value Lists Setup", "Workflow Administration", "Articles & Content Management", "Reports / Processes"*/);
$menuImages = array("person.png", "invcBill.png", "calendar2.png",
    "election.png", "addresses_wbg_64x64.png", "GL-256.png",
    "Inventory.png", "rent1.png", "Calander.png",
    "education.png", "engineer.png", "medical.png",
    "bank_256.png", "dashboard220.png", "ma-logo.png", "Home.png",
    "viewIcon.png", "bb_flow.gif",
    "Notebook.png", "settings.png");
$menuLinks = array("grp=8&typ=1", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=5",
    "grp=17&typ=1", "grp=40&typ=5", "grp=3&typ=1", "grp=40&typ=5",
    "grp=40&typ=5", "grp=40&typ=5", "grp=40&typ=3&vtyp=1",
    "grp=40&typ=5");
$mdlNms = array("Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "System Administration", "Basic Person Data",
    "Basic Person Data", "Basic Person Data", "Basic Person Data",
    "Basic Person Data");

$dfltPrvldgs = array(
    "View Person", "View Person", "View Person",
    "View Person", "View Person", "View Person",
    "View Person", "View Person", "View Person",
    "View Person", "View Person", "View Person",
    "View Person", "View Person", "View System Administration",
    "View Person", "View Person", "View Person", "View Person",
    "View Person");

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
        if ($i == 18) {
            $cntent .= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allarticles', '$menuLinks[$i]]');\">
            <img src=\"cmn_images/$menuImages[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItems[$i]) . "</span>
        </button>
    </div>";
        } else {
            $cntent .= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allmodules', '$menuLinks[$i]]');\">
            <img src=\"cmn_images/$menuImages[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItems[$i]) . "</span>
        </button>
    </div>";
        }
        $appCntr += 1;
        if ($grpcntr == 3 || $i == count($menuItems) - 1) {
            $cntent .= "</div>";
            $grpcntr = 0;
        } else {
            $grpcntr = $grpcntr + 1;
        }
    }
    echo "</div>" . $cntent;
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#appsMdlsCnt").html("<?php echo $appCntr; ?>");
        });
    </script>
    <?php
}
?>