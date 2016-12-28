<?php

$menuItems = array("Organization Setup");
$menuImages = array("BuildingManagement.png");

$mdlNm = "Organization Setup";
$ModuleName = $mdlNm;

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
            //Org Details
        }else if ($actyp == 2) {
            //Div Details
            var_dump($_POST);
        }else if ($actyp == 3) {
            //Site Details
            var_dump($_POST);
        }else if ($actyp == 4) {
            //Jobs Details
            var_dump($_POST);
        }else if ($actyp == 5) {
            //Grades Details
            var_dump($_POST);
        }else if ($actyp == 6) {
            //Position Details
            var_dump($_POST);
        }
    } else {
        if ($pgNo == 0) {
            $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">Organization Setup Menu</span>
					</li>
                                       </ul>
                                     </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
      <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is where Organizations are defined and basic Data about the Organisation Captured. The module has the ff areas:</span>
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
            require "org_setups.php";
        } else {
            restricted();
        }
    }
}

function get_OrgLstsTblr($searchWord, $searchIn, $offset, $limit_size) {
    $whereCls = "1=1";
    if ($searchIn == "Organization Name") {
        $whereCls = "(a.org_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Parent Organisation Name") {
        $whereCls = "((select b.org_name FROM org.org_details b where b.org_id = a.parent_org_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $strSql = "SELECT a.org_id mt, a.org_name FROM org.org_details a 
    WHERE ($whereCls) ORDER BY a.org_name LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_OrgLstsTblrTtl($searchWord, $searchIn) {
    $whereCls = "1=1";
    if ($searchIn == "Organization Name") {
        $whereCls = "(a.org_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Parent Organisation Name") {
        $whereCls = "((select b.org_name FROM org.org_details b where b.org_id = a.parent_org_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT count(1) FROM org.org_details a 
    WHERE ($whereCls)";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_OrgStpsDet($pkID) {
    $strSql = "SELECT a.org_id mt, a.org_name \"organisation's name\", org_logo, a.parent_org_id mt,
       (select b.org_name FROM 
    org.org_details b where b.org_id = a.parent_org_id) parent_organisation, 
    res_addrs residential_address, pstl_addrs postal_address, 
    email_addrsses email_addresses, websites, cntct_nos contact_nos, org_typ_id mt, 
    (select c.pssbl_value from gst.gen_stp_lov_values 
    c where c.pssbl_value_id = a.org_typ_id) organisation_type, 
    CASE WHEN is_enabled='1' THEN 'Yes' ELSE 'No' END \"is_enabled?\", oprtnl_crncy_id mt, 
    (select d.pssbl_value from gst.gen_stp_lov_values 
    d where d.pssbl_value_id = a.oprtnl_crncy_id) currency_code, org_desc \"organisation's_description\"
    , org_slogan \"organisation's slogan\" 
    FROM org.org_details a 
    WHERE (a.org_id=$pkID) ORDER BY a.org_name";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_DivsGrps($pkID, $searchWord, $searchIn, $offset, $limit_size) {
    $whereCls = "";
    if ($searchIn == "Division Name") {
        $whereCls = " and (a.div_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Parent Division Name") {
        $whereCls = " and ((select b.div_code_name FROM org.org_divs_groups b where b.div_id = a.prnt_div_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT a.div_id mt, a.div_code_name \"group_code/name\", a.prnt_div_id mt, (select b.div_code_name FROM 
        org.org_divs_groups b where b.div_id = a.prnt_div_id) \"parent group\", div_typ_id mt, 
        (select c.pssbl_value from gst.gen_stp_lov_values 
        c where c.pssbl_value_id = a.div_typ_id) group_type, 
        div_logo,          
        div_desc \"description/comments\",
        CASE WHEN is_enabled='1' THEN 'Yes' ELSE 'No' END \"is_enabled?\"
        FROM org.org_divs_groups a 
    WHERE ((a.org_id = $pkID)$whereCls) ORDER BY a.div_code_name LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_DivsGrpsTtl($pkID, $searchWord, $searchIn) {
    $whereCls = "";
    if ($searchIn == "Division Name") {
        $whereCls = " and (a.div_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Parent Division Name") {
        $whereCls = " and ((select b.div_code_name FROM org.org_divs_groups b where b.div_id = a.prnt_div_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }
    $strSql = "SELECT count(1) 
        FROM org.org_divs_groups a 
    WHERE ((a.org_id = $pkID)$whereCls)";
    $result = executeSQLNoParams($strSql);
     while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_SitesLocs($pkID, $searchWord, $searchIn, $offset, $limit_size) {
    $whereCls = "";
    if ($searchIn == "Site Name") {
        $whereCls = " and (a.location_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Site Description") {
        $whereCls = " and (a.site_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT a.location_id mt, a.location_code_name \"location_code/name\", a.site_desc \"description/comments\", 
        CASE WHEN a.is_enabled='1' THEN 'Yes' ELSE 'No' END \"is_enabled?\" 
        FROM org.org_sites_locations a
        WHERE ((a.org_id = $pkID)$whereCls) 
        ORDER BY a.location_code_name LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SitesLocsTtl($pkID, $searchWord, $searchIn) {
    $whereCls = "";
    if ($searchIn == "Site Name") {
        $whereCls = " and (a.location_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Site Description") {
        $whereCls = " and (a.site_desc ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT count(1)  
        FROM org.org_sites_locations a
        WHERE ((a.org_id = $pkID)$whereCls)";
    $result = executeSQLNoParams($strSql);
     while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_Jobs($pkID, $searchWord, $searchIn, $offset, $limit_size) {
    $whereCls = "";
    if ($searchIn == "Job Name") {
        $whereCls = " and (a.job_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Parent Job Name") {
        $whereCls = " and ((select b.job_code_name FROM 
        org.org_jobs b where b.job_id = a.parnt_job_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT a.job_id mt, a.job_code_name \"job code/description\", a.parnt_job_id mt, 
        (select b.job_code_name FROM 
         org.org_jobs b where b.job_id = a.parnt_job_id) parent_job, job_comments, 
         CASE WHEN a.is_enabled='1' THEN 'Yes' ELSE 'No' END \"is_enabled?\" 
         FROM org.org_jobs a
        WHERE ((a.org_id = $pkID)$whereCls) 
        ORDER BY a.job_code_name LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_JobsTtl($pkID, $searchWord, $searchIn) {
    $whereCls = "";
    if ($searchIn == "Job Name") {
        $whereCls = " and (a.job_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Parent Job Name") {
        $whereCls = " and ((select b.job_code_name FROM 
        org.org_jobs b where b.job_id = a.parnt_job_id) ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT count(1) 
         FROM org.org_jobs a
        WHERE ((a.org_id = $pkID)$whereCls)";
    $result = executeSQLNoParams($strSql);
   while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_Grades($pkID, $searchWord, $searchIn, $offset, $limit_size) {
    $whereCls = "";
    if ($searchIn == "Grade Name") {
        $whereCls = " and (a.grade_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Grade Description") {
        $whereCls = " and (a.grade_comments ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT a.grade_id mt, a.grade_code_name \"grade code/name\", 
         a.parnt_grade_id mt, (select b.grade_code_name FROM 
         org.org_grades b where b.grade_id = a.parnt_grade_id) parent_grade
         , a.grade_comments, 
         CASE WHEN a.is_enabled='1' THEN 'Yes' ELSE 'No' END \"is_enabled?\" 
         FROM org.org_grades a
         WHERE ((a.org_id = $pkID)$whereCls) 
         ORDER BY a.grade_code_name LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_GradesTtl($pkID, $searchWord, $searchIn) {
    $whereCls = "";
    if ($searchIn == "Grade Name") {
        $whereCls = " and (a.grade_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Grade Description") {
        $whereCls = " and (a.grade_comments ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT count(1) 
         FROM org.org_grades a
         WHERE ((a.org_id = $pkID)$whereCls)";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_Pos($pkID, $searchWord, $searchIn, $offset, $limit_size) {
    $whereCls = "";
    if ($searchIn == "Position Name") {
        $whereCls = " and (a.position_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Position Description") {
        $whereCls = " and (position_comments ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT a.position_id mt, a.position_code_name \"position code/name\"
        , a.prnt_position_id mt, (select b.position_code_name FROM 
         org.org_positions b where b.position_id = a.prnt_position_id) parent_position  
        , a.position_comments, 
        CASE WHEN a.is_enabled='1' THEN 'Yes' ELSE 'No' END \"is_enabled?\" 
        FROM org.org_positions a
        WHERE ((a.org_id = $pkID)$whereCls) 
        ORDER BY a.position_code_name LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PosTtl($pkID, $searchWord, $searchIn) {
    $whereCls = "";
    if ($searchIn == "Position Name") {
        $whereCls = " and (a.position_code_name ilike '" . loc_db_escape_string($searchWord) . "')";
    } else if ($searchIn == "Position Description") {
        $whereCls = " and (position_comments ilike '" . loc_db_escape_string($searchWord) . "')";
    }

    $strSql = "SELECT count(1) 
        FROM org.org_positions a
        WHERE ((a.org_id = $pkID)$whereCls)";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}
?>
