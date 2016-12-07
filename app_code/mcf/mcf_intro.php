<?php

//session_start();
$menuItems = array("Customers", "Transactions","Products");
$menuImages = array("person.png", "edit32.png", "bb_flow.gif");
$vwtyp1 = 0;
//echo $vwtyp1;
$mdlNm = "Basic Person Data";
$ModuleName = $mdlNm;
$pageHtmlID = "prsnDataPage";

$dfltPrvldgs = array("View Person", "View Basic Person Data",
    /* 2 */ "View Curriculum Vitae", "View Basic Person Assignments",
    /* 4 */ "View Person Pay Item Assignments", "View SQL", "View Record History",
    /* 7 */ "Add Person Info", "Edit Person Info", "Delete Person Info",
    /* 10 */ "Add Basic Assignments", "Edit Basic Assignments", "Delete Basic Assignments",
    /* 13 */ "Add Pay Item Assignments", "Edit Pay Item Assignments", "Delete Pay Item Assignments", "View Banks",
    /* 17 */ "Define Assignment Templates", "Edit Assignment Templates", "Delete Assignment Templates",
    /* 20 */ "View Assignment Templates", "Manage My Firm");
$canview = test_prmssns($dfltPrvldgs[0], $mdlNm) || test_prmssns("View Self-Service", "Self Service");

$vwtyp = "0";
$qstr = "";
$dsply = "";
$actyp = "";
$srchFor = "";
$srchIn = "Name";
$PKeyID = -1;
$fltrTypValue = "All";
$fltrTyp = "Relation Type";
$sortBy = "ID ASC";
if (isset($formArray)) {
    if (count($formArray) > 0) {
        $vwtyp = isset($formArray['vtyp']) ? cleanInputData($formArray['vtyp']) : "0";
        $qstr = isset($formArray['q']) ? cleanInputData($formArray['q']) : '';
    } else {
        $vwtyp = isset($_POST['vtyp']) ? cleanInputData($_POST['vtyp']) : "0";
    }
} else {
    $vwtyp = isset($_POST['vtyp']) ? cleanInputData($_POST['vtyp']) : "0";
}
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
if (isset($_POST['fltrTypValue'])) {
    $fltrTypValue = cleanInputData($_POST['fltrTypValue']);
}
if (isset($_POST['fltrTyp'])) {
    $fltrTyp = cleanInputData($_POST['fltrTyp']);
}
if (isset($_POST['sortBy'])) {
    $sortBy = cleanInputData($_POST['sortBy']);
}
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = " " . $srchFor . " ";
    $srchFor = str_replace(" ", "%", $srchFor);
}

//grp=40&typ=5
$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
						<span style=\"text-decoration:none;\">Home</span><span class=\"divider\"> | </span>
					</li>
					<li onclick=\"openATab('#allmodules', 'grp=40&typ=5');\">
						<span style=\"text-decoration:none;\">All Modules</span><span class=\"divider\"> | </span>
					</li>";
if ($lgn_num > 0 && $canview === true) {
    //echo $pgNo;
    $prsnid = $_SESSION['PRSN_ID'];
    if ($qstr == "DELETE") {
        
    } else if ($qstr == "UPDATE") {
        if ($actyp == 1) {
            //Person Sets
            //var_dump($_POST);
            //var_dump($_FILES);
            //exit();
            header("content-type:application/json");
            //categoryCombo
            $orgid = $_SESSION['ORG_ID'];
            $inptDaPersonID = isset($_POST['daPersonID']) ? cleanInputData($_POST['daPersonID']) : -1;
            $daPrsnLocalID = isset($_POST['daPrsnLocalID']) ? cleanInputData($_POST['daPrsnLocalID']) : "";
            $daTitle = isset($_POST['daTitle']) ? cleanInputData($_POST['daTitle']) : "";
            $daFirstName = isset($_POST['daFirstName']) ? cleanInputData($_POST['daFirstName']) : "";
            //$pSetUsesSQL = ((isset($_POST['pSetUsesSQL']) ? cleanInputData($_POST['pSetUsesSQL']) : "off") == "on") ? "1" : "0";
            $daOtherNames = isset($_POST['daOtherNames']) ? cleanInputData($_POST['daOtherNames']) : "";
            $daSurName = isset($_POST['daSurName']) ? cleanInputData($_POST['daSurName']) : "";
            $daGender = isset($_POST['daGender']) ? cleanInputData($_POST['daGender']) : "";
            $daMaritalStatus = isset($_POST['daMaritalStatus']) ? cleanInputData($_POST['daMaritalStatus']) : "";
            $daDOB = isset($_POST['daDOB']) ? cleanInputData($_POST['daDOB']) : "";
            $daNationality = isset($_POST['daNationality']) ? cleanInputData($_POST['daNationality']) : "";
            $daCompany = isset($_POST['daCompany']) ? cleanInputData($_POST['daCompany']) : "";
            $daCompanyID = getGnrlRecID2("scm.scm_cstmr_suplr", "cust_sup_name", "cust_sup_id", $daCompany);
            $daCompanyLoc = isset($_POST['daCompanyLoc']) ? cleanInputData($_POST['daCompanyLoc']) : "";
            $daCompanyLocID = getGnrlRecIDExtr("scm.scm_cstmr_suplr_sites", "site_name", "cust_supplier_id", "cust_sup_site_id", $daCompanyLoc, $daCompanyID);

            $daEmail = isset($_POST['daEmail']) ? cleanInputData($_POST['daEmail']) : "";
            $daMobileNos = isset($_POST['daMobileNos']) ? cleanInputData($_POST['daMobileNos']) : "";
            $daPOB = isset($_POST['daPOB']) ? cleanInputData($_POST['daPOB']) : "";
            $daHomeTown = isset($_POST['daHomeTown']) ? cleanInputData($_POST['daHomeTown']) : "";
            $daReligion = isset($_POST['daReligion']) ? cleanInputData($_POST['daReligion']) : "";
            $daPostalAddress = isset($_POST['daPostalAddress']) ? cleanInputData($_POST['daPostalAddress']) : "";
            $daResAddress = isset($_POST['daResAddress']) ? cleanInputData($_POST['daResAddress']) : "";
            $daRelType = isset($_POST['daRelType']) ? cleanInputData($_POST['daRelType']) : "";
            $daRelCause = isset($_POST['daRelCause']) ? cleanInputData($_POST['daRelCause']) : "";
            $daRelDetails = isset($_POST['daRelDetails']) ? cleanInputData($_POST['daRelDetails']) : "";
            $daRelStartDate = isset($_POST['daRelStartDate']) ? cleanInputData($_POST['daRelStartDate']) : "";
            $daRelEndDate = isset($_POST['daRelEndDate']) ? cleanInputData($_POST['daRelEndDate']) : "";
            $daFax = "";
            $oldDaPersonID = getPersonID($daPrsnLocalID);

            if ($daPrsnLocalID != "" && $daTitle != "" &&
                    $daFirstName != "" &&
                    $daSurName != "" &&
                    $daGender != "" &&
                    $daMaritalStatus != "" &&
                    $daDOB != "" &&
                    $daNationality != "" &&
                    $daRelType != "" &&
                    $daRelCause != "" &&
                    ($oldDaPersonID <= 0 || $oldDaPersonID == $inptDaPersonID)) {
                if ($inptDaPersonID <= 0) {
                    createPrsnBasic($daFirstName, $daSurName, $daOtherNames, $daTitle, $daPrsnLocalID, $orgID, $daGender, $daMaritalStatus, $daDOB, $daPOB, $daReligion, $daResAddress, $daPostalAddress, $daEmail, "", $daMobileNos, $daFax, $daHomeTown, $daNationality, ""
                            , $daCompanyID, $daCompanyLocID, $daCompany, $daCompanyLoc);
                    $inptDaPersonID = getPersonID($daPrsnLocalID);
                    createPrsnsType($inptDaPersonID, $daRelCause, $daRelStartDate, $daRelEndDate, $daRelDetails, $daRelType);
                } else {
                    updatePrsnBasic($inptDaPersonID, $daFirstName, $daSurName, $daOtherNames, $daTitle, $daPrsnLocalID, $orgID, $daGender, $daMaritalStatus, $daDOB, $daPOB, $daReligion, $daResAddress, $daPostalAddress, $daEmail, "", $daMobileNos, $daFax, $daHomeTown, $daNationality
                            , $daCompanyID, $daCompanyLocID, $daCompany, $daCompanyLoc);
                    $prsntypRowID = -1;
                    if (checkPrsnType($inptDaPersonID, $daRelType, $daRelStartDate, $prsntypRowID) == false) {
                        endOldPrsnTypes($inptDaPersonID, $daRelStartDate);
                        createPrsnsType($inptDaPersonID, $daRelCause, $daRelStartDate, $daRelEndDate, $daRelDetails, $daRelType);
                    } else if ($prsntypRowID > 0) {
                        updtPrsnsType($prsntypRowID, $inptDaPersonID, $daRelCause, $daRelStartDate, $daRelEndDate, $daRelDetails, $daRelType);
                    }
                }
                $nwImgLoc = "";
                if ($inptDaPersonID > 0) {
                    uploadDaImage($inptDaPersonID, $nwImgLoc);
                }
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Saved Successfully',
                    'data' => array('src' => '<div style="float:left;"><img src="cmn_images/info.png" style="float:left;margin-right:5px;'
                        . 'width:30px;height:30px;"/>Person Successfully Saved!<br/>' . $nwImgLoc . '</div>'),
                    'total' => '1',
                    'errors' => ''
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Save Failed!',
                    'data' => array('src' => 'Failed to Save Person!'),
                    'total' => '0',
                    'errors' => '<div style="float:left;"><img src="cmn_images/error.gif" style="float:left;margin-right:5px;width:30px;height:30px;"/>'
                    . 'Either the New Person ID No. is in Use <br/>or Data Supplied is Incomplete!<br/>' . $nwImgLoc . '</div>'
                ));
                exit();
            }
        }
    } else if ($pgNo == 0) {
        $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=8&typ=1');\">
						<span style=\"text-decoration:none;\">Customers Menu</span>
					</li>
                                       </ul>
                                     </div>" . "<div style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    padding:10px 15px 15px 20px;border:1px solid #ccc;\">                    
      <h3>FUNCTIONS UNDER THE BANKING & MICROFINANCE MANAGER</h3>
      <div style=\"padding:5px 30px 5px 10px;margin-bottom:2px;\">
                    <span style=\"font-family: georgia, times;font-size: 12px;font-style:italic;
                    font-weight:normal;\">This is the module for Managing Banking and Microfinance. The module has the ff areas:</span>
                    </div> 
      <p>";
        $grpcntr = 0;
        $prsnType = get_LtstPrsnType($prsnid);
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i + 1;
            if ($i == 0) {
                
            } else if ($i == 1) {
                //continue;
            } else if ($i == 2) {
                if (strpos($prsnType, "Registered Member") !== FALSE) {
                    //
                } else {
                    //continue;
                }
            } else if ($i == 3) {
                if (strpos($prsnType, "Staff") !== FALSE) {
                    //
                } else {
                    //continue;
                }
            } else if ($i == 4 && test_prmssns($dfltPrvldgs[7], $mdlNm) == FALSE) {
                //continue;
            } else if ($i == 5 && test_prmssns($dfltPrvldgs[21], $mdlNm) == FALSE) {
                //continue;
            } else if ($i == 6 && test_prmssns($dfltPrvldgs[7], $mdlNm) == FALSE) {
                //continue;
            }
            if ($grpcntr == 0) {
                $cntent.= "<div class=\"row\">";
            }
            //showPageDetails('$pageHtmlID', $No);
            $cntent.= "<div class=\"col-md-3 colmd3special2\">
        <button type=\"button\" class=\"btn btn-default btn-lg btn-block modulesButton\" onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$No&vtyp=0');\">
            <img src=\"cmn_images/$menuImages[$i]\" style=\"margin:5px; padding-right: 1em; height:58px; width:auto; position: relative; vertical-align: middle;float:left;\">
            <span class=\"wordwrap2\">" . ($menuItems[$i]) . "</span>
        </button>
    </div>";
            if ($grpcntr == 3) {
                $cntent.= "</div>";
                $grpcntr = 0;
            } else {
                $grpcntr = $grpcntr + 1;
            }
        }

        $cntent.= "
      </p>
    </div>";
        echo $cntent;
    } else {
        $cntent .= "
					<li onclick=\"openATab('#allmodules', 'grp=8&typ=1');\">
						<span style=\"text-decoration:none;\">Person Records Menu</span>
    </li>";
        if ($pgNo == 1) {
            require "profile.php";
        } else if ($pgNo == 2) {
            require "edit_profile.php";
        } else if ($pgNo == 3) {
            echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\">
						<span class=\"divider\"> | </span><span style=\"text-decoration:none;\">Grade Progression Requests</span>
					</li>
                                       </ul>
                                     </div>" . "Grade Progression Requests";
        } else if ($pgNo == 4) {
            echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\">
						<span class=\"divider\"> | </span><span style=\"text-decoration:none;\">Leave of Absence Requests</span>
					</li>
                                       </ul>
                                     </div>" . "Leave of Absence Requests";
        } else if ($pgNo == 5) {
            echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\">
						<span class=\"divider\"> | </span><span style=\"text-decoration:none;\">Data Administrator</span>
					</li>
                                       </ul>
                                     </div>" . "Data Administrator";
            //Get Basic Person
            $orgID = $_SESSION['ORG_ID'];
            $searchAll = true;
            if ($vwtyp == 0) {
                $total = get_BscPrsnTtl($srchFor, $srchIn, $orgID, $searchAll, $fltrTypValue, $fltrTyp);
                $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
                $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
                $start = isset($_POST['start']) ? $_POST['start'] : 0;

                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                }
                $curIdx = $pageNo - 1;
                $result = get_BscPrsn($srchFor, $srchIn, $curIdx, $lmtSze, $orgID, $searchAll, $sortBy, $fltrTypValue, $fltrTyp);
                $prntArray = array();
                $cntr = 0;
                while ($row = loc_db_fetch_array($result)) {
                    $temp = explode(".", $row[3]);
                    $extension = end($temp);
                    $nwFileName = encrypt1($row[3], $smplTokenWord1) . "." . $extension;
                    $ftp_src = $ftp_base_db_fldr . "/Person/" . $row[3];
                    $fullPemDest = $fldrPrfx . $pemDest . $nwFileName;
                    if (file_exists($ftp_src)) {
                        copy("$ftp_src", "$fullPemDest");
                        //echo $fullPemDest;
                    } else if (!file_exists($fullPemDest)) {
                        $ftp_src = $fldrPrfx . 'cmn_images/image_up.png';
                        copy("$ftp_src", "$fullPemDest");
                        //echo $ftp_src;
                    }

                    $chckd = ($cntr == 0) ? TRUE : FALSE;
                    $childArray = array(
                        'checked' => var_export($chckd, TRUE),
                        'PersonID' => $row[0],
                        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                        'LocIDNo' => $row[1],
                        'FullName' => $row[2],
                        'DateOfBirth' => $row[9],
                        'WorkPlace' => str_replace("()", "", $row[22] . " (" . $row[24] . ")"),
                        'Email' => $row[14],
                        'TelNos' => trim($row[15] . "," . $row[16], ","),
                        'PostalResAddress' => trim($row[13] . " " . $row[12], " "),
                        'Title' => $row[25],
                        'FirstName' => $row[4],
                        'Surname' => $row[5],
                        'OtherNames' => $row[6],
                        'ImageLoc' => $nwFileName,
                        'Gender' => $row[7],
                        'MaritalStatus' => $row[8],
                        'PlaceOfBirth' => $row[10],
                        'Religion' => $row[11],
                        'ResidentialAddress' => $row[12],
                        'PostalAddress' => $row[13],
                        'TelNo' => $row[15],
                        'MobileNo' => $row[16],
                        'FaxNo' => $row[17],
                        'HomeTown' => $row[19],
                        'Nationality' => $row[20],
                        'LinkedFirmOrgID' => $row[21],
                        'LinkedFirmSiteID' => $row[23],
                        'LinkedFirmName' => $row[22],
                        'LinkedSiteName' => $row[24],
                        'PrsnType' => $row[26],
                        'PrnTypRsn' => $row[27],
                        'FurtherDetails' => $row[28],
                        'StartDate' => $row[29],
                        'EndDate' => $row[30]);

                    $prntArray[] = $childArray;
                    $cntr++;
                }

                echo json_encode(array('success' => true,
                    'total' => $total,
                    'rows' => $prntArray));
            } else if ($vwtyp == 1) {
                $result = get_FilterValues($fltrTyp, $orgID);
                $total = loc_db_num_rows($result);
                $childArray = array(
                    'pssblValue' => 'All',
                    'pssblValueDesc' => 'All');
                $prntArray[] = $childArray;
                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $childArray = array(
                        'pssblValue' => $row[0],
                        'pssblValueDesc' => $row[0]);
                    $prntArray[] = $childArray;
                    //$cntr++;
                }
                echo json_encode(array('success' => true,
                    'total' => $total,
                    'rows' => $prntArray));
            } else if ($vwtyp == 2) {
                //Prsn Detail
                $pkID = isset($_POST['personID']) ? $_POST['personID'] : -1;
                $result = get_BscPrsnDetail($pkID);
                $colsCnt = loc_db_num_fields($result);
                $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>PERSON DETAILS</caption>";
                $cntent .= "<thead><tr>";
                $cntent.= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
                $cntent.= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
                $cntent .= "</tr></thead>";
                $cntent .= "<tbody>";
                $i = 0;

                $labl = "";
                $labl1 = "";
                while ($row = loc_db_fetch_array($result)) {
                    for ($d = 0; $d < $colsCnt; $d++) {
                        $style = "";
                        $style2 = "";
                        if (trim(loc_db_field_name($result, $d)) == "mt") {
                            $style = "style=\"display:none;\"";
                        }
                        if (strtoupper($row[$d]) == 'NO') {
                            $style2 = "style=\"color:red;font-weight:bold;\"";
                        } else if (strtoupper($row[$d]) == 'YES') {
                            $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                        }

                        $cntent.="<tr $style>";
                        $cntent.= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";

                        if (trim(loc_db_field_name($result, $d)) == "Person's Picture") {
                            $temp = explode(".", $row[$d]);
                            $extension = end($temp);
                            $nwFileName = encrypt1($row[$d], $smplTokenWord1) . "." . $extension;
                            $img_src = $pemDest . $nwFileName;
                            $ftp_src = $ftp_base_db_fldr . "/Person/" . $row[$d];
                            if ($row[$d] != "") {
                                if (file_exists($ftp_src)) {
                                    copy("$ftp_src", $fldrPrfx . "$img_src");
                                }
                            }
                            if (file_exists($fldrPrfx . $img_src)) {//image exists!
                            } else {
                                //image does not exist.
                                $img_src = "cmn_images/image_up.png";
                            }
                            $radomNo = rand(0, 500);
                            $cntent.= "<td  width=\"60%\" $style2><img style=\"border:1px solid #eee;height:180px;padding:5px;\" src=\"$img_src?v=" . $radomNo . "\" /></td>";
                        } else {
                            $cntent.= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                        }
                        $cntent.="</tr>";
                    }
                    $i++;
                }
                $cntent.="</tbody></table></div>";
                echo $cntent;
            }
        } else if ($pgNo == 6) {
            echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\">
						<span class=\"divider\"> | </span><span style=\"text-decoration:none;\">Self-Service Managers</span>
					</li>
                                       </ul>
                                     </div>" . "Self-Service Managers";
        } else if ($pgNo == 7) {
            echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\">
						<span class=\"divider\"> | </span><span style=\"text-decoration:none;\">Send Bulk Messages</span>
					</li>
                                       </ul>
                                     </div>" . "Send Bulk Messages";
        } else {
            restricted();
        }
    }
} else {
    restricted();
}

function get_LtstPrsnType($pkID) {
    $strSql = "SELECT prsn_type 
            FROM pasn.prsn_prsntyps WHERE ((person_id =  $pkID)) 
                ORDER BY valid_end_date DESC, valid_start_date DESC LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return '';
}

function get_BscPrsnTtl($searchFor, $searchIn, $orgID, $searchAll, $fltrTypValue, $fltrTyp) {
    $extra1 = "";
    $extra2 = "";
    $extra3 = "";
    $aldPrsTyp = getAllwdPrsnTyps();
    $aldPrsTyp = "'" . trim($aldPrsTyp, "'") . "'";
    if ($aldPrsTyp != "'All'") {
        $extra3 = " and ((SELECT z.prsn_type FROM pasn.prsn_prsntyps z WHERE (z.person_id = a.person_id) 
ORDER BY z.valid_end_date DESC, z.valid_start_date DESC LIMIT 1 OFFSET 0) IN (" . $aldPrsTyp . "))";
    }

    if ($searchAll == true) {
        $extra1 = "or 1 = 1";
    }
    if ($fltrTypValue == "All") {
        $extra2 = " and 1 = 1";
    } else {
        if ($fltrTyp == "Relation Type") {
            $extra2 = " and ((SELECT z.prsn_type FROM pasn.prsn_prsntyps z WHERE (z.person_id = a.person_id) 
ORDER BY z.valid_end_date DESC, z.valid_start_date DESC LIMIT 1 OFFSET 0)='" . $fltrTypValue . "')";
        } else if ($fltrTyp == "Division/Group") {
            $extra2 = " and (EXISTS(SELECT w.div_code_name FROM pasn.prsn_divs_groups z, org.org_divs_groups w 
WHERE (z.person_id = a.person_id and w.div_id = z.div_id and w.div_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        } else if ($fltrTyp == "Job") {
            $extra2 = " and (EXISTS(SELECT w.job_code_name FROM pasn.prsn_jobs z, org.org_jobs w 
WHERE (z.person_id = a.person_id and w.job_id = z.job_id and w.job_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        } else if ($fltrTyp == "Grade") {
            $extra2 = " and (EXISTS(SELECT w.grade_code_name FROM pasn.prsn_grades z, org.org_grades w 
WHERE (z.person_id = a.person_id and w.grade_id = z.grade_id and w.grade_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        } else if ($fltrTyp == "Position") {
            $extra2 = " and (EXISTS(SELECT w.position_code_name FROM pasn.prsn_positions z, org.org_positions w 
WHERE (z.person_id = a.person_id and w.position_id = z.position_id and w.position_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        }
    }
    $strSql = "";
    $whrcls = "";
    if ($searchIn == "ID") {
        $whrcls = " AND (a.local_id_no ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Full Name") {
        $whrcls = " AND (trim(a.title || ' ' || a.sur_name || " .
                "', ' || a.first_name || ' ' || a.other_names) ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Residential Address") {
        $whrcls = " AND (a.res_address ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Contact Information") {
        $whrcls = " AND (a.pstl_addrs ilike '" . loc_db_escape_string($searchFor) .
                "' or a.email ilike '" . loc_db_escape_string($searchFor) .
                "' or a.cntct_no_tel ilike '" . loc_db_escape_string($searchFor) .
                "' or a.cntct_no_mobl ilike '" . loc_db_escape_string($searchFor) .
                "' or a.cntct_no_fax ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Linked Firm/Workplace") {
        $whrcls = " AND (scm.get_cstmr_splr_name(a.lnkd_firm_org_id) ilike '" . loc_db_escape_string($searchFor) .
                "' or scm.get_cstmr_splr_site_name(a.lnkd_firm_site_id) ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Person Type") {
        $whrcls = " AND ((Select g.prsn_type || ' ' || g.prn_typ_asgnmnt_rsn "
                . "|| ' ' || g.further_details from pasn.prsn_prsntyps g "
                . "where g.person_id=a.person_id ORDER BY g.valid_start_date DESC "
                . "LIMIT 1 OFFSET 0) ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Date of Birth") {
        $whrcls = " AND (to_char(to_timestamp(a.date_of_birth,"
                . "'YYYY-MM-DD'),'DD-Mon-YYYY') ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Home Town") {
        $whrcls = " AND (a.hometown ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Gender") {
        $whrcls = " AND (a.gender ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Marital Status") {
        $whrcls = " AND (a.marital_status ilike '" . loc_db_escape_string($searchFor) .
                "')";
    }

    $strSql = "SELECT count(1) " .
            "FROM prs.prsn_names_nos a "
            . "LEFT OUTER JOIN pasn.prsn_prsntyps b " .
            "ON (a.person_id = b.person_id and "
            . "b.valid_start_date = (SELECT MAX(c.valid_start_date) from pasn.prsn_prsntyps c where c.person_id = a.person_id)) " .
            "WHERE ((a.org_id = " . $orgID . " " . $extra1 . ")" . $whrcls . $extra2 . $extra3 .
            ")";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_BscPrsn($searchFor, $searchIn, $offset, $limit_size, $orgID, $searchAll, $sortBy
, $fltrTypValue, $fltrTyp) {
    $extra1 = "";
    $extra2 = "";
    $extra3 = "";
    $aldPrsTyp = getAllwdPrsnTyps();
    $aldPrsTyp = "'" . trim($aldPrsTyp, "'") . "'";
    if ($aldPrsTyp != "'All'") {
        $extra3 = " and ((SELECT z.prsn_type FROM pasn.prsn_prsntyps z WHERE (z.person_id = a.person_id) 
ORDER BY z.valid_end_date DESC, z.valid_start_date DESC LIMIT 1 OFFSET 0) IN (" . $aldPrsTyp . "))";
    }

    if ($searchAll == true) {
        $extra1 = "or 1 = 1";
    }
    if ($fltrTypValue == "All") {
        $extra2 = " and 1 = 1";
    } else {
        if ($fltrTyp == "Relation Type") {
            $extra2 = " and ((SELECT z.prsn_type FROM pasn.prsn_prsntyps z WHERE (z.person_id = a.person_id) 
ORDER BY z.valid_end_date DESC, z.valid_start_date DESC LIMIT 1 OFFSET 0)='" . $fltrTypValue . "')";
        } else if ($fltrTyp == "Division/Group") {
            $extra2 = " and (EXISTS(SELECT w.div_code_name FROM pasn.prsn_divs_groups z, org.org_divs_groups w 
WHERE (z.person_id = a.person_id and w.div_id = z.div_id and w.div_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        } else if ($fltrTyp == "Job") {
            $extra2 = " and (EXISTS(SELECT w.job_code_name FROM pasn.prsn_jobs z, org.org_jobs w 
WHERE (z.person_id = a.person_id and w.job_id = z.job_id and w.job_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        } else if ($fltrTyp == "Grade") {
            $extra2 = " and (EXISTS(SELECT w.grade_code_name FROM pasn.prsn_grades z, org.org_grades w 
WHERE (z.person_id = a.person_id and w.grade_id = z.grade_id and w.grade_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        } else if ($fltrTyp == "Position") {
            $extra2 = " and (EXISTS(SELECT w.position_code_name FROM pasn.prsn_positions z, org.org_positions w 
WHERE (z.person_id = a.person_id and w.position_id = z.position_id and w.position_code_name='" . $fltrTypValue . "'  
and now() between to_timestamp(z.valid_start_date,'YYYY-MM-DD HH24:MI:SS') and 
to_timestamp(z.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))";
        }
    }
    $strSql = "";
    $whrcls = "";
    $ordrBy = "";
    if ($searchIn == "ID") {
        $whrcls = " AND (a.local_id_no ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Full Name") {
        $whrcls = " AND (trim(a.title || ' ' || a.sur_name || " .
                "', ' || a.first_name || ' ' || a.other_names) ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Residential Address") {
        $whrcls = " AND (a.res_address ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Contact Information") {
        $whrcls = " AND (a.pstl_addrs ilike '" . loc_db_escape_string($searchFor) .
                "' or a.email ilike '" . loc_db_escape_string($searchFor) .
                "' or a.cntct_no_tel ilike '" . loc_db_escape_string($searchFor) .
                "' or a.cntct_no_mobl ilike '" . loc_db_escape_string($searchFor) .
                "' or a.cntct_no_fax ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn == "Linked Firm/Workplace") {
        $whrcls = " AND (scm.get_cstmr_splr_name(a.lnkd_firm_org_id) ilike '" . loc_db_escape_string($searchFor) .
                "' or scm.get_cstmr_splr_site_name(a.lnkd_firm_site_id) ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Person Type") {
        $whrcls = " AND ((Select g.prsn_type || ' ' || g.prn_typ_asgnmnt_rsn "
                . "|| ' ' || g.further_details from pasn.prsn_prsntyps g "
                . "where g.person_id=a.person_id ORDER BY g.valid_start_date DESC "
                . "LIMIT 1 OFFSET 0) ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Date of Birth") {
        $whrcls = " AND (to_char(to_timestamp(a.date_of_birth,"
                . "'YYYY-MM-DD'),'DD-Mon-YYYY') ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Home Town") {
        $whrcls = " AND (a.hometown ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Gender") {
        $whrcls = " AND (a.gender ilike '" . loc_db_escape_string($searchFor) .
                "')";
    } else if ($searchIn == "Marital Status") {
        $whrcls = " AND (a.marital_status ilike '" . loc_db_escape_string($searchFor) .
                "')";
    }

    if ($sortBy == "Date Added DESC") {
        $ordrBy = "a.creation_date DESC";
    } else if ($sortBy == "Date of Birth") {
        $ordrBy = "a.date_of_birth ASC";
    } else if ($sortBy == "Full Name") {
        $ordrBy = "trim(a.sur_name || " .
                "', ' || a.first_name || ' ' || a.other_names) ASC";
    } else if ($sortBy == "ID ASC") {
        $ordrBy = "a.local_id_no ASC";
    } else if ($sortBy == "ID DESC") {
        $ordrBy = "a.local_id_no DESC";
    }

    $strSql = "SELECT a.person_id, a.local_id_no, trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) fullname, "
            . "a.img_location, a.first_name, a.sur_name, a.other_names,
                gender, marital_status,date_of_birth,
          place_of_birth, religion, res_address, pstl_addrs, email, cntct_no_tel, 
          trim(cntct_no_tel) || trim(cntct_no_mobl), 
          cntct_no_fax, img_location, hometown, nationality, 
          lnkd_firm_org_id, 
          CASE WHEN lnkd_firm_org_id <=0 THEN new_company ELSE scm.get_cstmr_splr_name(lnkd_firm_org_id) END, 
          lnkd_firm_site_id, 
          CASE WHEN lnkd_firm_site_id <=0 THEN new_company_loc ELSE scm.get_cstmr_splr_site_name(lnkd_firm_site_id) END, 
          a.title, 
          b.prsn_type, b.prn_typ_asgnmnt_rsn, " .
            "b.further_details, b.valid_start_date, b.valid_end_date  " .
            "FROM prs.prsn_names_nos a "
            . "LEFT OUTER JOIN pasn.prsn_prsntyps b " .
            "ON (a.person_id = b.person_id and "
            . "b.valid_start_date = (SELECT MAX(c.valid_start_date) from pasn.prsn_prsntyps c where c.person_id = a.person_id)) " .
            "WHERE ((a.org_id = " . $orgID . " " . $extra1 . ")" . $whrcls . $extra2 . $extra3 .
            ") ORDER BY " . $ordrBy . " LIMIT " . $limit_size .
            " OFFSET " . abs($offset * $limit_size);
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_BscPrsnDetail($person_id) {
    $strSql = "SELECT  
                a.img_location \"Person's Picture\", 
                a.person_id \"Person ID\", "
            . "a.local_id_no \"ID No. \", "
            . "trim(a.title || ' ' || a.sur_name || " .
            "', ' || a.first_name || ' ' || a.other_names) \"Full Name \",
                a.gender \"Gender \", 
                a.marital_status \"Marital Status \", 
                to_char(to_timestamp(a.date_of_birth,'YYYY-MM-DD'),'DD-Mon-YYYY') \"Date of Birth \",
          a.place_of_birth \"Place of Birth \", 
          a.religion \"Religion \", 
          a.res_address \"Residential Address \", 
          a.pstl_addrs \"Postal Address \", 
          a.email \"Email \", 
          a.cntct_no_tel \"Tel No. \", 
          a.cntct_no_mobl \"Mobile No. \", 
          a.cntct_no_fax \"Fax \", 
          a.hometown \"Home Town \", 
          a.nationality \"Nationality \", 
          a.lnkd_firm_org_id mt, 
          scm.get_cstmr_splr_name(a.lnkd_firm_org_id) \"Workplace/Firm \", 
          a.lnkd_firm_site_id mt, 
          scm.get_cstmr_splr_site_name(a.lnkd_firm_site_id) \"Site/Branch \", 
          b.prsn_type \"Relation Type\", 
          b.prn_typ_asgnmnt_rsn \"Cause of Relation\", " .
            "b.further_details \"Further Details\", "
            . "to_char(to_timestamp(b.valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"Start Date \", "
            . "to_char(to_timestamp(b.valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"End Date \" " .
            "FROM prs.prsn_names_nos a "
            . "LEFT OUTER JOIN pasn.prsn_prsntyps b " .
            "ON (a.person_id = b.person_id and "
            . "b.valid_start_date = (SELECT MAX(c.valid_start_date) from pasn.prsn_prsntyps c where c.person_id = a.person_id)) " .
            "WHERE (a.person_id = $person_id)";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function getAllwdPrsnTyps() {
    $strSql = "select a.pssbl_value_desc from gst.gen_stp_lov_values a, gst.gen_stp_lov_names b, sec.sec_roles c
WHERE a.value_list_id = b.value_list_id and a.pssbl_value = c.role_name 
and b.value_list_name = 'Allowed Person Types for Roles' and a.is_enabled='1' 
and c.role_id IN (" . concatCurRoleIDs() . ") ORDER BY a.pssbl_value_id LIMIT 1 OFFSET 0";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_FilterValues($fltrTyp, $orgID) {
    $result = null;
    if ($fltrTyp == "Position") {
        //Positions
        $result = executeSQLNoParams("Select position_code_name from org.org_positions where org_id=" . $orgID);
    } else if ($fltrTyp == "Division/Group") {
        //Div Groups
        $result = executeSQLNoParams("Select div_code_name from org.org_divs_groups where org_id=" . $orgID);
    } else if ($fltrTyp == "Grade") {
        //Grade
        $result = executeSQLNoParams("Select grade_code_name from org.org_grades where org_id=" . $orgID);
    } else if ($fltrTyp == "Job") {
        //Job
        $result = executeSQLNoParams("Select job_code_name from org.org_jobs where org_id=" . $orgID);
    } else {
        //Person Types
        $aldPrsTyp = getAllwdPrsnTyps();
        $extra3 = "";
        $aldPrsTyp = "'" . trim($aldPrsTyp, "'") . "'";
        if ($aldPrsTyp != "'All'") {
            $extra3 = " and pssbl_value IN (" . $aldPrsTyp . ")";
        }
        $result = getAllEnbldPssblVals("Person Types", $extra3);
    }
    return $result;
}

function getAllEnbldPssblVals($lovNm, $extrWhr) {
    global $orgID;
    $sqlStr = "select pssbl_value from gst.gen_stp_lov_values " .
            "WHERE is_enabled='1' and value_list_id = " . getLovID($lovNm) .
            " and allowed_org_ids ilike '%," . $orgID .
            ",%'" . $extrWhr . " ORDER BY 1";
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function endOldPrsnTypes($prsnid, $nwStrtDte) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE pasn.prsn_prsntyps " .
            "SET last_update_by=" . $usrID . ", " .
            "last_update_date='" . $dateStr . "', valid_end_date='" . $nwStrtDte . "' " .
            "WHERE ((person_id=" . $prsnid .
            ") and (to_timestamp(valid_end_date || ' 23:59:59','YYYY-MM-DD HH24:MI:SS') " .
            ">= to_timestamp('" . $nwStrtDte . " 00:00:00','YYYY-MM-DD HH24:MI:SS')))";
    execUpdtInsSQL($updtSQL);
}

function checkPrsnType($prsnid, $prsntyp, $nwStrtDte, &$rowID) {
    $strSql = "SELECT prsntype_id " .
            "FROM pasn.prsn_prsntyps WHERE ((person_id = " . $prsnid .
            ") and (((prsn_type = '" . loc_db_escape_string($prsntyp) .
            "') and (to_timestamp(valid_start_date || ' 00:00:00','YYYY-MM-DD HH24:MI:SS') " .
            ">= to_timestamp('" . $nwStrtDte . "','YYYY-MM-DD HH24:MI:SS'))) or (to_timestamp(valid_start_date || ' 00:00:00','YYYY-MM-DD HH24:MI:SS') " .
            "= to_timestamp('" . $nwStrtDte . "','YYYY-MM-DD HH24:MI:SS'))))";

    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        $rowID = $row[0];
        return true;
    }
    return false;
}

function createPrsnsType($prsnid, $rsn, $date1, $date2, $futhDet, $prsntyp) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO pasn.prsn_prsntyps(" .
            "person_id, prn_typ_asgnmnt_rsn, valid_start_date, valid_end_date, " .
            "created_by, creation_date, last_update_by, last_update_date, " .
            "further_details, prsn_type)" .
            "VALUES (" . $prsnid . ", '" . loc_db_escape_string($rsn) .
            "', '" . loc_db_escape_string($date1) . "', '" . loc_db_escape_string($date2) . "', " .
            "" . $usrID . ", '" . $dateStr . "', " . $usrID . ", '" . $dateStr . "', " .
            "'" . loc_db_escape_string($futhDet) . "', '" . loc_db_escape_string($prsntyp) . "')";
    execUpdtInsSQL($insSQL);
}

function updtPrsnsType($rowid, $prsnid, $rsn, $date1, $date2, $futhDet, $prsntyp) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE pasn.prsn_prsntyps " .
            "SET person_id=" . $prsnid . ", prn_typ_asgnmnt_rsn='" . loc_db_escape_string($rsn) .
            "', valid_start_date='" . loc_db_escape_string($date1) .
            "', valid_end_date='" . loc_db_escape_string($date2) . "', " .
            "last_update_by=" . $usrID . ", last_update_date='" . $dateStr . "', " .
            "further_details='" . loc_db_escape_string($futhDet) .
            "', prsn_type='" . loc_db_escape_string($prsntyp) . "' " .
            "WHERE prsntype_id= " . $rowid;
    execUpdtInsSQL($updtSQL);
}

function createPrsnBasic($frstnm, $surname, $othnm, $title
, $loc_id, $orgid, $gender, $marsts, $dob, $pob, $rlgn, $resaddrs, $pstladrs, $email, $tel, $mobl, $fax, $hometwn, $ntnlty, $imgLoc, $lnkdFrmID, $lnkdFrmSiteID, $lnkdFirmNm, $lnkdFirmSiteName) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO prs.prsn_names_nos(" .
            "created_by, creation_date, last_update_by, last_update_date, " .
            "first_name, sur_name, other_names, title, local_id_no, org_id, " .
            "gender, marital_status, date_of_birth, place_of_birth, religion, " .
            "res_address, pstl_addrs, email, cntct_no_tel, cntct_no_mobl, " .
            "cntct_no_fax, hometown, nationality, img_location, lnkd_firm_org_id, 
            lnkd_firm_site_id, new_company, new_company_loc)" .
            "VALUES (" . $usrID . ", '" . $dateStr . "', " .
            $usrID . ", '" . $dateStr . "', '" . loc_db_escape_string($frstnm) . "', " .
            "'" . loc_db_escape_string($surname) . "', '" . loc_db_escape_string($othnm) .
            "', '" . loc_db_escape_string($title) . "', '" . loc_db_escape_string($loc_id) .
            "', " . $orgid . ", '" . loc_db_escape_string($gender) . "', " .
            "'" . loc_db_escape_string($marsts) . "', '" . $dob .
            "', '" . loc_db_escape_string($pob) . "', '" . loc_db_escape_string($rlgn) .
            "', '" . loc_db_escape_string($resaddrs) . "', " .
            "'" . loc_db_escape_string($pstladrs) . "', '" . loc_db_escape_string($email) .
            "', '" . loc_db_escape_string($tel) . "', '" . loc_db_escape_string($mobl) .
            "', '" . loc_db_escape_string($fax) . "', '" . loc_db_escape_string($hometwn) .
            "', '" . loc_db_escape_string($ntnlty) . "', '" . loc_db_escape_string($imgLoc) .
            "', " . $lnkdFrmID . ", " . $lnkdFrmSiteID .
            ", '" . loc_db_escape_string($lnkdFirmNm) . "', '" . loc_db_escape_string($lnkdFirmSiteName) . "')";
    execUpdtInsSQL($insSQL);
}

function updatePrsnBasic($prsnid, $frstnm, $surname, $othnm, $title
, $loc_id, $orgid, $gender, $marsts, $dob, $pob, $rlgn, $resaddrs, $pstladrs, $email, $tel, $mobl, $fax, $hometwn, $ntnlty, $lnkdFrmID, $lnkdFrmSiteID, $lnkdFirmNm, $lnkdFirmSiteName) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $updtSQL = "UPDATE prs.prsn_names_nos " .
            "SET last_update_by=" . $usrID . ", " .
            "last_update_date='" . $dateStr .
            "', first_name='" . loc_db_escape_string($frstnm) .
            "', sur_name='" . loc_db_escape_string($surname) .
            "', other_names='" . loc_db_escape_string($othnm) .
            "', title='" . loc_db_escape_string($title) .
            "', local_id_no='" . loc_db_escape_string($loc_id) .
            "', org_id=" . $orgid . ", gender='" . loc_db_escape_string($gender) .
            "', marital_status='" . loc_db_escape_string($marsts) . "', date_of_birth='" . $dob .
            "', place_of_birth='" . loc_db_escape_string($pob) .
            "', religion='" . loc_db_escape_string($rlgn) .
            "', res_address='" . loc_db_escape_string($resaddrs) .
            "', pstl_addrs='" . loc_db_escape_string($pstladrs) .
            "', email='" . loc_db_escape_string($email) .
            "', cntct_no_tel='" . loc_db_escape_string($tel) .
            "', cntct_no_mobl='" . loc_db_escape_string($mobl) .
            "', cntct_no_fax='" . loc_db_escape_string($fax) .
            "', hometown='" . loc_db_escape_string($hometwn) .
            "', nationality='" . loc_db_escape_string($ntnlty) .
            "', lnkd_firm_org_id=" . $lnkdFrmID .
            ", lnkd_firm_site_id=" . $lnkdFrmSiteID .
            ", new_company='" . loc_db_escape_string($lnkdFirmNm) .
            "', new_company_loc='" . loc_db_escape_string($lnkdFirmSiteName) .
            "' WHERE person_id=" . $prsnid;
    execUpdtInsSQL($updtSQL);
}

function uploadDaImage($prsnid, &$nwImgLoc) {
    global $database;
    global $ftp_base_db_fldr;
    global $usrID;
    global $fldrPrfx;
    global $smplTokenWord1;

    $msg = "";
    if (isset($_FILES["daPrsnPicture"])) {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
//$files = multiple($_FILES);
        $flnm = $_FILES["daPrsnPicture"]["name"];
        $msg.= $flnm;
        $temp = explode(".", $flnm);
        $extension = end($temp);
        if ($_FILES["daPrsnPicture"]["error"] > 0) {
            $msg.= "Return Code: " . $_FILES["daPrsnPicture"]["error"] . "<br>";
        } else {
            $msg.= "Upload: " . $_FILES["daPrsnPicture"]["name"] . "<br>";
            $msg.= "Type: " . $_FILES["daPrsnPicture"]["type"] . "<br>";
            $msg.= "Size: " . ($_FILES["daPrsnPicture"]["size"]) . " bytes<br>";
            $msg.= "Temp file: " . $_FILES["daPrsnPicture"]["tmp_name"] . "<br>";
            if ((($_FILES["daPrsnPicture"]["type"] == "image/gif") ||
                    ($_FILES["daPrsnPicture"]["type"] == "image/jpeg") ||
                    ($_FILES["daPrsnPicture"]["type"] == "image/jpg") ||
                    ($_FILES["daPrsnPicture"]["type"] == "image/pjpeg") ||
                    ($_FILES["daPrsnPicture"]["type"] == "image/x-png") ||
                    ($_FILES["daPrsnPicture"]["type"] == "image/png") ||
                    in_array($extension, $allowedExts)) &&
                    ($_FILES["daPrsnPicture"]["size"] < 6000000)) {
                $nwFileName = encrypt1($prsnid . "." . $extension, $smplTokenWord1) . ".png";
                $img_src = $fldrPrfx . "app_data/$database/Person/$nwFileName";
                move_uploaded_file($_FILES["daPrsnPicture"]["tmp_name"], $img_src);
                $ftp_src = $ftp_base_db_fldr . "/Person/$prsnid" . "." . $extension;
                if (file_exists($img_src)) {
                    copy("$img_src", "$ftp_src");

                    $dateStr = getDB_Date_time();
                    $updtSQL = "UPDATE prs.prsn_names_nos " .
                            "SET last_update_by=" . $usrID . ", " .
                            "last_update_date='" . $dateStr .
                            "', img_location = '" . $prsnid . "." . $extension . "' WHERE person_id=" . $prsnid;
                    execUpdtInsSQL($updtSQL);
                }
                $msg.= "Stored in: " . "uploaded/" . $_FILES["daPrsnPicture"]["name"][0];
                $nwImgLoc = "$prsnid" . "." . $extension;
                return TRUE;
            } else {
                $msg.= "<br/>Invalid file";
                $nwImgLoc = $msg;
            }
        }
    }
    return FALSE;
}

function prsn_ChngRqst_Exist($pkID) {
    $sqlStr = "select 1 from self.self_prsn_chng_rqst WHERE (person_id=$pkID)
           and rqst_status in ('Initiated','Requires Approval')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return -1;
}

function prsn_Record_Exist($pkID) {
    $sqlStr = "select person_id FROM self.self_prsn_names_nos WHERE (person_id=$pkID)";
    //echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while (loc_db_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function get_RqstStatus($pkID) {
    $sqlStr = "select rqst_status from self.self_prsn_chng_rqst WHERE (person_id=$pkID)
           and rqst_id = (select coalesce(max(rqst_id),0) from self.self_prsn_chng_rqst WHERE (person_id=$pkID))";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 'Approved';
}

function get_SelfPrsnDet($pkID) {
    $strSql = "SELECT a.person_id mt, local_id_no \"ID No.\", img_location \"Person's Picture\", 
          title, first_name, sur_name \"surname\", other_names, org.get_org_name(org_id) organisation, 
          gender, marital_status, 
          to_char(to_timestamp(date_of_birth,'YYYY-MM-DD'),'DD-Mon-YYYY') \"Date of Birth\", 
          place_of_birth, religion, 
          res_address residential_address, pstl_addrs postal_address, email, 
          cntct_no_tel tel, cntct_no_mobl mobile, 
          cntct_no_fax fax, hometown, nationality, 
          (CASE WHEN lnkd_firm_org_id>0 THEN 
          scm.get_cstmr_splr_name(lnkd_firm_org_id)
              ELSE 
              new_company
              END) \"Linked Firm/ Workplace \", 
          (CASE WHEN lnkd_firm_org_id>0 THEN 
           scm.get_cstmr_splr_site_name(lnkd_firm_site_id)
              ELSE 
              new_company_loc
              END) \"Branch \", 
          b.prsn_type \"Relation Type\", 
          b.prn_typ_asgnmnt_rsn \"Cause of Relation\", 
            b.further_details \"Further Details\", 
            to_char(to_timestamp(b.valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"Start Date \", 
            to_char(to_timestamp(b.valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"End Date \" 
            FROM self.self_prsn_names_nos a 
            LEFT OUTER JOIN pasn.prsn_prsntyps b 
            ON (a.person_id = b.person_id and 
           b.valid_start_date = (SELECT MAX(c.valid_start_date) from pasn.prsn_prsntyps c where c.person_id = a.person_id)) 
    WHERE (a.person_id=$pkID)";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PrsnDet($pkID) {
    $strSql = "SELECT a.person_id mt, local_id_no \"ID No.\", img_location \"Person's Picture\", 
          title, first_name, sur_name \"surname\", other_names, org.get_org_name(org_id) organisation, 
          gender, marital_status, 
          to_char(to_timestamp(date_of_birth,'YYYY-MM-DD'),'DD-Mon-YYYY') \"Date of Birth\", 
          place_of_birth, religion, 
          res_address residential_address, pstl_addrs postal_address, email, 
          cntct_no_tel tel, cntct_no_mobl mobile, 
          cntct_no_fax fax, hometown, nationality, 
          (CASE WHEN lnkd_firm_org_id>0 THEN 
          scm.get_cstmr_splr_name(lnkd_firm_org_id)
              ELSE 
              new_company
              END) \"Linked Firm/ Workplace \", 
          (CASE WHEN lnkd_firm_org_id>0 THEN 
           scm.get_cstmr_splr_site_name(lnkd_firm_site_id)
              ELSE 
              new_company_loc
              END) \"Branch \", 
          b.prsn_type \"Relation Type\", 
          b.prn_typ_asgnmnt_rsn \"Cause of Relation\", 
            b.further_details \"Further Details\", 
            to_char(to_timestamp(b.valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"Start Date \", 
            to_char(to_timestamp(b.valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"End Date \" 
            FROM prs.prsn_names_nos a  
            LEFT OUTER JOIN pasn.prsn_prsntyps b 
            ON (a.person_id = b.person_id and 
           b.valid_start_date = (SELECT MAX(c.valid_start_date) from pasn.prsn_prsntyps c where c.person_id = a.person_id))  
    WHERE (a.person_id=$pkID)";
    $result = executeSQLNoParams($strSql);
    return $result;
}


function get_AllNtnlty($pkID) {
    $strSql = "SELECT ntnlty_id mt, nationality \"Country\", national_id_typ national_id_type, 
        id_number, date_issued, expiry_date, other_info other_information 
          FROM prs.prsn_national_ids WHERE ((person_id = $pkID))";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_AllNtnlty_Self($pkID) {
    $strSql = "SELECT ntnlty_id mt, nationality \"Country\", national_id_typ national_id_type, 
        id_number, date_issued, expiry_date, other_info other_information 
          FROM self.self_prsn_national_ids WHERE ((person_id = $pkID))";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function getAllRltvs($pkID) {
    $strSql = "SELECT a.local_id_no \"Relative's ID No.\", 
        trim(a.title || ' ' || a.sur_name || 
           ', ' || a.first_name || ' ' || a.other_names) \"Relative's full_name\", 
            b.relationship_type, b.relative_prsn_id mt, b.rltv_id mt
               FROM prs.prsn_relatives b 
                   LEFT OUTER JOIN prs.prsn_names_nos a 
                   ON b.relative_prsn_id = a.person_id 
                   WHERE ((b.person_id = $pkID)) ORDER BY b.relationship_type, a.local_id_no";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PrsnTypes($pkID) {
    $strSql = "SELECT person_id mt, prsn_type person_type, 
        prn_typ_asgnmnt_rsn reason_for_this_person_type, 
        further_details, 
to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date
            FROM pasn.prsn_prsntyps WHERE ((person_id =  $pkID)) 
                ORDER BY valid_end_date DESC, valid_start_date DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_EducBkgrd($pkID) {
    $strSql = "SELECT educ_id mt, course_name, school_institution \"school/institution\", 
        school_location, 
       to_char(to_timestamp(course_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
        to_char(to_timestamp(course_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date, 
        cert_obtained certificate_obtained, cert_type certificate_type, 
        date_cert_awarded date_awarded  
      FROM prs.prsn_education a WHERE ((person_id = $pkID)) 
      ORDER BY a.course_end_date DESC, a.course_start_date DESC, 1 DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_WrkBkgrd($pkID) {
    $strSql = "SELECT wrk_exprnc_id mt, job_name_title \"job name/title\", institution_name, job_location, 
        to_char(to_timestamp(job_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
        to_char(to_timestamp(job_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date, job_description, 
        feats_achvments \"feats/achievements\"
        FROM prs.prsn_work_experience a 
        WHERE ((person_id = $pkID)) 
        ORDER BY a.job_end_date DESC, a.job_start_date DESC, 1 DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SkillNature($pkID) {
    $strSql = "SELECT skills_id mt, languages, hobbies, interests, 
       conduct, attitude, to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"valid_start_date\", 
        to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') \"valid_end_date\"
        FROM prs.prsn_skills_nature a WHERE ((person_id = $pkID)) 
        ORDER BY a.valid_end_date DESC, a.valid_start_date DESC, 1 DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PrsExtrDataGrpCols($grpnm, $org_ID) {
    $strSql = "SELECT extra_data_cols_id, column_no, column_label, attchd_lov_name, 
       column_data_type, column_data_category, data_length, 
       CASE WHEN data_dsply_type='T' THEN 'Tabular' ELSE 'Detail' END, 
       org_id, no_cols_tblr_dsply, col_order, csv_tblr_col_nms 
        FROM prs.prsn_extra_data_cols 
        WHERE column_data_category= '" . loc_db_escape_string($grpnm) .
            "' and org_id = " . $org_ID . " and column_label !='' ORDER BY col_order, column_no, extra_data_cols_id";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PrsExtrDataGrps($org_ID) {
    $strSql = "SELECT column_data_category, MIN(extra_data_cols_id) , MIN(col_order)  
        FROM prs.prsn_extra_data_cols 
        WHERE org_id =$org_ID and column_label !='' 
            GROUP BY column_data_category ORDER BY 3, 2, 1";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_PrsExtrData($pkID, $colNum = "1") {
    $colNms = array("data_col1", "data_col2", "data_col3", "data_col4",
        "data_col5", "data_col6", "data_col7", "data_col8", "data_col9", "data_col10",
        "data_col11", "data_col12", "data_col13", "data_col14", "data_col15", "data_col16",
        "data_col17", "data_col18", "data_col19", "data_col20", "data_col21", "data_col22",
        "data_col23", "data_col24", "data_col25", "data_col26", "data_col27", "data_col28",
        "data_col29", "data_col30", "data_col31", "data_col32", "data_col33", "data_col34",
        "data_col35", "data_col36", "data_col37", "data_col38", "data_col39", "data_col40",
        "data_col41", "data_col42", "data_col43", "data_col44", "data_col45", "data_col46",
        "data_col47", "data_col48", "data_col49", "data_col50");
    $strSql = "SELECT " . $colNms[$colNum - 1] . ", extra_data_id 
  FROM prs.prsn_extra_data a WHERE ((person_id = $pkID))";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_PrsExtrData_Self($pkID, $colNum = "1") {
    $colNms = array("data_col1", "data_col2", "data_col3", "data_col4",
        "data_col5", "data_col6", "data_col7", "data_col8", "data_col9", "data_col10",
        "data_col11", "data_col12", "data_col13", "data_col14", "data_col15", "data_col16",
        "data_col17", "data_col18", "data_col19", "data_col20", "data_col21", "data_col22",
        "data_col23", "data_col24", "data_col25", "data_col26", "data_col27", "data_col28",
        "data_col29", "data_col30", "data_col31", "data_col32", "data_col33", "data_col34",
        "data_col35", "data_col36", "data_col37", "data_col38", "data_col39", "data_col40",
        "data_col41", "data_col42", "data_col43", "data_col44", "data_col45", "data_col46",
        "data_col47", "data_col48", "data_col49", "data_col50");
    $strSql = "SELECT " . $colNms[$colNum - 1] . ", extra_data_id 
  FROM self.self_prsn_extra_data a WHERE ((person_id = $pkID))";
    $result = executeSQLNoParams($strSql);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function get_DivsGrps($pkID) {
    $strSql = "SELECT a.prsn_div_id mt, a.div_id mt, org.get_div_name(a.div_id) group_name, 
        to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date, 
COALESCE((select b.div_typ_id from org.org_divs_groups b where a.div_id = b.div_id),-1) mt,
gst.get_pssbl_val(COALESCE((select b.div_typ_id from org.org_divs_groups b where a.div_id = b.div_id),-1)) group_type
       FROM pasn.prsn_divs_groups a WHERE ((person_id = $pkID)) 
           ORDER BY a.valid_end_date DESC, a.valid_start_date DESC, 1 DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_SitesLocs($pkID) {
    $strSql = "SELECT a.prsn_loc_id mt, a.location_id mt, 
(select b.location_code_name from org.org_sites_locations b where b.location_id = a.location_id) site_name,       
to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date  
            FROM pasn.prsn_locations a 
            WHERE ((person_id = $pkID))
                ORDER BY a.valid_end_date DESC, a.valid_start_date DESC, 1 DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_Spvsrs($pkID) {
    $strSql = "SELECT row_id mt, supervisor_prsn_id mt, 
        prs.get_prsn_loc_id(supervisor_prsn_id) id_of_supervisor,
        prs.get_prsn_name(supervisor_prsn_id) name_of_supervisor,
        to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date
      FROM pasn.prsn_supervisors a WHERE ((person_id = $pkID))
                ORDER BY a.valid_end_date DESC, a.valid_start_date DESC, 1 DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_Jobs($pkID) {
    $strSql = "SELECT a.row_id mt, a.job_id mt, 
        (select b.job_code_name from org.org_jobs b where b.job_id = a.job_id) job_name,
        to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date 
      FROM pasn.prsn_jobs a
       WHERE ((person_id = $pkID)) 
                ORDER BY a.valid_end_date DESC, a.valid_start_date DESC, 1 DESC";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_Grades($pkID) {
    $strSql = "SELECT a.row_id mt, a.grade_id mt, 
        (select b.grade_code_name from org.org_grades b where b.grade_id = a.grade_id) grade_name,
        to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date
     FROM pasn.prsn_grades a WHERE ((person_id = $pkID))";
    $result = executeSQLNoParams($strSql);
    return $result;
}

function get_Pos($pkID) {
    $strSql = "SELECT a.row_id mt, a.position_id mt, 
        (select b.position_code_name from org.org_positions b where b.position_id = a.position_id) pos_name,
        to_char(to_timestamp(valid_start_date,'YYYY-MM-DD'),'DD-Mon-YYYY') start_date, 
        to_char(to_timestamp(valid_end_date,'YYYY-MM-DD'),'DD-Mon-YYYY') end_date
      FROM pasn.prsn_positions a WHERE ((person_id = $pkID))";
    $result = executeSQLNoParams($strSql);
    return $result;
}
?>
