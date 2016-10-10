<?php

$menuItems = array("Organization Setup");

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
$grp = 3;
$typ = 1;

$mdlNm = "Organization Setup";
$ModuleName = $mdlNm;
if (isset($_REQUEST['pg']))
    $pgNo = $_REQUEST['pg'];
if (isset($_REQUEST['q']))
    $mdlNm = $_REQUEST['q'];
if (isset($_REQUEST['grp']))
    $grp = $_REQUEST['grp'];
if (isset($_REQUEST['typ']))
    $typ = $_REQUEST['typ'];


$dfltPrvldgs = array("View Organization Setup",
        "View Org Details", "View Divisions/Groups", "View Sites/Locations",
        /* 4 */ "View Jobs", "View Grades", "View Positions", "View Benefits",
        /* 8 */ "View Pay Items", "View Remunerations", "View Working Hours",
        /* 11 */ "View Gathering Types", "View SQL", "View Record History",
        /* 14 */ "Add Org Details", "Edit Org Details",
        /* 16 */ "Add Divisions/Groups", "Edit Divisions/Groups", "Delete Divisions/Groups",
        /* 19 */ "Add Sites/Locations", "Edit Sites/Locations", "Delete Sites/Locations",
        /* 22 */ "Add Jobs", "Edit Jobs", "Delete Jobs",
        /* 25 */ "Add Grades", "Edit Grades", "Delete Grades",
        /* 28 */ "Add Positions", "Edit Positions", "Delete Positions");
$canview = test_prmssns($dfltPrvldgs[0], $mdlNm);

if ($lgn_num > 0 && $canview === true) {
    if ($pgNo == 0) {
        $cntent = "<div id='rho_form' style=\"min-height:150px;\">
            <form id='orgStpForm' action='' method='post' accept-charset='UTF-8'>
                <fieldset style=\"padding:10px 20px 20px 20px;\">
                    <legend>   $mdlNm                
                    </legend>
                    <div style=\"margin-bottom:10px;\">
                    <h2>Welcome to the Organisational Setup Module</h2>
                    </div>                    
                    <div class='rho_form1' style=\"background-color:#e3e3e3;border: 1px solid #999;padding:10px;\" class=\"rho-postcontent rho-postcontent-0 clearfix\">                    
      <h5>FUNCTIONALITIES OF THE ORGANISATIONAL SETUP MODULE</h5>
      <p>This is where Organisations are defined and basic Data about the Organisation Captured. The module has the ff areas:";

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
        $cntent.= "
      </p>
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
        require "org_det.php";
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
