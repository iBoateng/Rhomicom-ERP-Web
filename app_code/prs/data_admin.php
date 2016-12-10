<?php
if (array_key_exists('lgn_num', get_defined_vars())) {
    $usrID = $_SESSION['USRID'];
    $prsnid = $_SESSION['PRSN_ID'];
    $orgID = $_SESSION['ORG_ID'];
    $error = "";
    $searchAll = true;

    $srchFor = isset($_POST['searchfor']) ? cleanInputData($_POST['searchfor']) : '';
    $srchIn = isset($_POST['searchin']) ? cleanInputData($_POST['searchin']) : 'Both';
    $pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
    $lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
    $sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";
    if (strpos($srchFor, "%") === FALSE) {
        $srchFor = "%" . str_replace(" ", "%", $srchFor) . "%";
        $srchFor = str_replace("%%", "%", $srchFor);
    }

    $lnkdFirmID = getGnrlRecNm("prs.prsn_names_nos", "person_id", "lnkd_firm_org_id", $prsnid);
    $pkID = $prsnid;
    if ($vwtyp == 0) {
        echo $cntent . "<li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Data Administration</span>
					</li>
                                       </ul>
                                     </div>";
        $total = get_BscPrsnTtl($srchFor, $srchIn, $orgID, $searchAll, $fltrTypValue, $fltrTyp);
        if ($pageNo > ceil($total / $lmtSze)) {
            $pageNo = 1;
        } else if ($pageNo < 1) {
            $pageNo = ceil($total / $lmtSze);
        }

        $curIdx = $pageNo - 1;
        $result = get_BscPrsn($srchFor, $srchIn, $curIdx, $lmtSze, $orgID, $searchAll, $sortBy, $fltrTypValue, $fltrTyp);
        $cntr = 0;
        ?> 
        <form id='dataAdminForm' action='' method='post' accept-charset='UTF-8'>
            <div class="row" style="margin-bottom:10px;">
                <div class="col-lg-2" style="padding:0px 1px 0px 15px !important;">                    
                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getEducBkgrdForm('myFormsModal', 'myFormsModalBody', 'myFormsModalTitle', 'educBkgrdForm', '', 'Add/Edit Educational Background', 20, 'ADD', -1, <?php echo $prsnid; ?>);">
                        <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                        New Person
                    </button>
                </div>
                <div class="col-lg-3" style="padding:0px 15px 0px 15px !important;">
                    <div class="input-group">
                        <input class="form-control" id="dataAdminSrchFor" type = "text" placeholder="Search For" value="<?php echo $srchFor; ?>" onkeyup="enterKeyFuncDtAdmn(event, '', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0')">
                        <input id="dataAdminPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                        <label class="btn btn-primary btn-file input-group-addon" onclick="getDataAdmin('clear', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0')">
                            <span class="glyphicon glyphicon-remove"></span>
                        </label>
                        <label class="btn btn-primary btn-file input-group-addon" onclick="getDataAdmin('', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0')">
                            <span class="glyphicon glyphicon-search"></span>
                        </label> 
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                        <select data-placeholder="Select..." class="form-control chosen-select" id="dataAdminSrchIn">
                            <?php
                            $valslctdArry = array("", "", "", "", "", "", "", "", "", "");
                            $srchInsArrys = array("ID", "Full Name", "Residential Address"
                                , "Contact Information", "Linked Firm/Workplace", "Person Type", "Date of Birth",
                                "Home Town", "Gender", "Marital Status");
                            for ($z = 0; $z < count($srchInsArrys); $z++) {
                                if ($srchIn == $srchInsArrys[$z]) {
                                    $valslctdArry[$z] = "selected";
                                }
                                ?>
                                <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                            <?php } ?>
                        </select>
                        <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                        <select data-placeholder="Select..." class="form-control chosen-select" id="dataAdminDsplySze" style="min-width:70px !important;">                            
                            <?php
                            $valslctdArry = array("", "", "", "", "", "", "", "");
                            $dsplySzeArry = array(1, 5, 10, 15, 30, 50, 100, 500, 1000);
                            for ($y = 0; $y < count($dsplySzeArry); $y++) {
                                if ($lmtSze == $dsplySzeArry[$y]) {
                                    $valslctdArry[$y] = "selected";
                                } else {
                                    $valslctdArry[$y] = "";
                                }
                                ?>
                                <option value="<?php echo $dsplySzeArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $dsplySzeArry[$y]; ?></option>                            
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-group">                        
                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-attributes"></span></span>
                        <select data-placeholder="Select..." class="form-control chosen-select" id="dataAdminSortBy">
                            <?php
                            $valslctdArry = array("", "", "", "", "");
                            $srchInsArrys = array("ID ASC", "ID DESC", "Date Added DESC", "Date of Birth", "Full Name");
                            for ($z = 0; $z < count($srchInsArrys); $z++) {
                                if ($srchIn == $srchInsArrys[$z]) {
                                    $valslctdArry[$z] = "selected";
                                }
                                ?>
                                <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" style="margin: 0px !important;">
                            <li>
                                <a href="javascript:getDataAdmin('previous', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0');" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:getDataAdmin('next', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0');" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="row"> 
                <div  class="col-md-12">
                    <table class="table table-striped table-bordered table-responsive cvTblsEDT" id="dataAdminTable" cellspacing="0" width="100%" style="width:100%;">
                        <thead>
                            <tr>
                                <th>...</th>	
                                <th>No.</th>		
                                <th>ID No.</th>
                                <th>Full Name</th>
                                <th>Linked Firm</th>
                                <th>Email</th>
                                <th>Contact Nos.</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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
                                $cntr += 1;

                                /* $childArray = array(
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
                                  'EndDate' => $row[30]); */
                                ?>
                                <tr id="educBkgrdRow<?php echo $cntr; ?>">
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm" onclick="getEducBkgrdForm('myFormsModal', 'myFormsModalBody', 'myFormsModalTitle', 'educBkgrdForm', 'educBkgrdRow<?php echo $cntr; ?>', 'Add/Edit Educational Background', 20, 'EDIT', <?php echo $row[0]; ?>, <?php echo $prsnid; ?>);" style="padding:2px !important;" style="padding:2px !important;">
                                            <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                            <img src="cmn_images/edit32.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                        </button>
                                    </td>
                                    <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                    <td><?php echo $row[1]; ?></td>
                                    <td><?php echo $row[2]; ?></td>
                                    <td><?php echo str_replace("()", "", $row[22] . " (" . $row[24] . ")"); ?></td>
                                    <td><?php echo $row[14]; ?></td>
                                    <td><?php echo trim($row[15] . ", " . $row[16], ", "); ?></td>
                                    <td><?php echo trim($row[13] . " " . $row[12], " "); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>                     
            </div>
        </form>
        <?php
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
        $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
        $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
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

                $cntent .= "<tr $style>";
                $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . trim(loc_db_field_name($result, $d)) . "</td>";

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
                    $cntent .= "<td  width=\"60%\" $style2><img style=\"border:1px solid #eee;height:180px;padding:5px;\" src=\"$img_src?v=" . $radomNo . "\" /></td>";
                } else {
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                }
                $cntent .= "</tr>";
            }
            $i++;
        }
        $cntent .= "</tbody></table></div>";
        echo $cntent;
    }
}
?>
