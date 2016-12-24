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
        $canAddPrsn = test_prmssns($dfltPrvldgs[7], $mdlNm);
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
        $colClassType1 = "col-lg-2";
        $colClassType2 = "col-lg-3";
        ?> 
        <form id='dataAdminForm' action='' method='post' accept-charset='UTF-8'>
            <div class="row" style="margin-bottom:10px;">
                <?php
                if ($canAddPrsn === true) {
                    ?>   
                    <div class="<?php echo $colClassType1; ?>" style="padding:0px 1px 0px 15px !important;">                    
                        <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'Add Person Basic Profile', -1, 23, 2, 'ADD')">
                            <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                            New Person
                        </button>
                    </div>
                <?php
                } else {
                    $colClassType1 = "col-lg-2";
                    $colClassType2 = "col-lg-4";
                }
                ?>
                <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                    <div class="input-group">
                        <input class="form-control" id="dataAdminSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncDtAdmn(event, '', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0')">
                        <input id="dataAdminPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                        <label class="btn btn-primary btn-file input-group-addon" onclick="getDataAdmin('clear', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0')">
                            <span class="glyphicon glyphicon-remove"></span>
                        </label>
                        <label class="btn btn-primary btn-file input-group-addon" onclick="getDataAdmin('', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0')">
                            <span class="glyphicon glyphicon-search"></span>
                        </label> 
                    </div>
                </div>
                <div class="<?php echo $colClassType2; ?>">
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
                <div class="<?php echo $colClassType1; ?>">
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
                <div class="<?php echo $colClassType1; ?>">
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
                    <table class="table table-striped table-bordered table-responsive" id="dataAdminTable" cellspacing="0" width="100%" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <?php if ($canAddPrsn === true) { ?>
                                    <th>...</th>
                                <?php } ?>
                                <th>...</th>		
                                <th>ID No.</th>
                                <th>Full Name</th>
                                <th>Linked Firm</th>
                                <th>Email</th>
                                <th>Contact Nos.</th>
                                <th>Address</th>
                                <th>...</th>
                                <!--<th>...</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = loc_db_fetch_array($result)) {
                                /**/
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
                                <tr id="dtAdmnBscPrsnPrflRow<?php echo $cntr; ?>">                                    
                                    <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                    <?php if ($canAddPrsn === true) { ?>                                    
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit Basic Profile" 
                                                    onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'View/Edit Person Basic Profile', <?php echo $row[0]; ?>, 0, 2, 'EDIT')" style="padding:2px !important;" style="padding:2px !important;">
                                                <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                <img src="cmn_images/edit32.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                            </button>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Print Profile" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                            <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                            <img src="cmn_images/pdf.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                        </button>
                                    </td>
                                    <td><?php echo $row[1]; ?></td>
                                    <td><?php echo $row[2]; ?></td>
                                    <td><?php echo str_replace("()", "", $row[22] . " (" . $row[24] . ")"); ?></td>
                                    <td><?php echo $row[14]; ?></td>
                                    <td><?php echo trim($row[15] . ", " . $row[16], ", "); ?></td>
                                    <td><?php echo trim($row[13] . " " . $row[12], " "); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Basic Profile" onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'View Person Basic Profile', <?php echo $row[0]; ?>, 0, 1, 'VIEW')" style="padding:2px !important;" style="padding:2px !important;">
                                            <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                            <img src="cmn_images/kghostview.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                        </button>
                                    </td>
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
        /* Get Institutions Under me */
        $canAddPrsn = test_prmssns($dfltPrvldgs[7], $mdlNm);
        echo $cntent . "<li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span><span style=\"text-decoration:none;\">Self-Service Managers</span>
					</li>
                                       </ul>
                                     </div>";
        $extrWhere = " and a.lnkd_firm_org_id=" . $lnkdFirmID;
        $total = get_BscPrsnTtl($srchFor, $srchIn, $orgID, $searchAll, $fltrTypValue, $fltrTyp, $extrWhere);
        if ($pageNo > ceil($total / $lmtSze)) {
            $pageNo = 1;
        } else if ($pageNo < 1) {
            $pageNo = ceil($total / $lmtSze);
        }

        $curIdx = $pageNo - 1;
        $result = get_BscPrsn($srchFor, $srchIn, $curIdx, $lmtSze, $orgID, $searchAll, $sortBy, $fltrTypValue, $fltrTyp, $extrWhere);
        $cntr = 0;
        ?> 
        <form id='dataAdminForm' action='' method='post' accept-charset='UTF-8'>
            <div class="row" style="margin-bottom:10px;">
                <div class="col-lg-2" style="padding:0px 1px 0px 15px !important;">                    
                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getBscProfile1Form('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'Add Person Basic Profile', -1, 24, 2, 'ADD')">
                        <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                        New Person
                    </button>
                </div>
                <div class="col-lg-3" style="padding:0px 15px 0px 15px !important;">
                    <div class="input-group">
                        <input class="form-control" id="dataAdminSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncDtAdmn(event, '', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=1')">
                        <input id="dataAdminPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                        <label class="btn btn-primary btn-file input-group-addon" onclick="getDataAdmin('clear', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=1')">
                            <span class="glyphicon glyphicon-remove"></span>
                        </label>
                        <label class="btn btn-primary btn-file input-group-addon" onclick="getDataAdmin('', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=1')">
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
                                <a href="javascript:getDataAdmin('previous', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=1');" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:getDataAdmin('next', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=1');" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="row"> 
                <div  class="col-md-12">
                    <table class="table table-striped table-bordered table-responsive" id="dataAdminTable" cellspacing="0" width="100%" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <?php if ($canAddPrsn === true) { ?>
                                    <th>...</th>
                                <?php } ?>
                                <th>...</th>		
                                <th>ID No.</th>
                                <th>Full Name</th>
                                <th>Linked Firm</th>
                                <th>Email</th>
                                <th>Contact Nos.</th>
                                <th>Address</th>
                                <th>...</th>
                                <!--<th>...</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = loc_db_fetch_array($result)) {
                                /**/
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
                                <tr id="dtAdmnBscPrsnPrflRow<?php echo $cntr; ?>">                                    
                                    <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                    <?php if ($canAddPrsn === true) { ?>                                    
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit Basic Profile" 
                                                    onclick="getBscProfile1Form('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'View/Edit Person Basic Profile', <?php echo $row[0]; ?>, 0, 2, 'EDIT')" style="padding:2px !important;" style="padding:2px !important;">
                                                <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                <img src="cmn_images/edit32.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                            </button>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Print Profile" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                            <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                            <img src="cmn_images/pdf.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                        </button>
                                    </td>
                                    <td><?php echo $row[1]; ?></td>
                                    <td><?php echo $row[2]; ?></td>
                                    <td><?php echo str_replace("()", "", $row[22] . " (" . $row[24] . ")"); ?></td>
                                    <td><?php echo $row[14]; ?></td>
                                    <td><?php echo trim($row[15] . ", " . $row[16], ", "); ?></td>
                                    <td><?php echo trim($row[13] . " " . $row[12], " "); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Basic Profile" onclick="getBscProfile1Form('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'View Person Basic Profile', <?php echo $row[0]; ?>, 0, 1, 'VIEW')" style="padding:2px !important;" style="padding:2px !important;">
                                            <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                            <img src="cmn_images/kghostview.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                        </button>
                                    </td>
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
    }
}
?>
