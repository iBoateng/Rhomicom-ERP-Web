<?php
$pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
$lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
$sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";
$curIdx = 0;
$orgID = $_SESSION['ORG_ID'];
$usrID = $_SESSION['USRID'];
$canAddItmSet = test_prmssns($dfltPrvldgs[11], $mdlNm);
$canEdtItmSet = test_prmssns($dfltPrvldgs[12], $mdlNm);
$canDelItmSet = test_prmssns($dfltPrvldgs[13], $mdlNm);

if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0 && $canview === true) {
        if ($qstr == "DELETE") {
            if ($actyp == 1) {
                
            }
        } else if ($qstr == "UPDATE") {
            if ($actyp == 1) {
                
            } else if ($actyp == 2) {
                
            }
        } else {
            $prsnid = $_SESSION['PRSN_ID'];
            if ($vwtyp == 0) {
                $sbmtdPrsnSetHdrID = isset($_POST['sbmtdPrsnSetHdrID']) ? $_POST['sbmtdPrsnSetHdrID'] : -1;
                echo $cntent . "<li>
                                    <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                    <span style=\"text-decoration:none;\">Person Sets</span>
				</li>
                               </ul>
                              </div>";
                $total = get_PrsnSetsTtl($srchFor, $srchIn, $orgID);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }
                $curIdx = $pageNo - 1;
                $result = get_PrsnSets($srchFor, $srchIn, $curIdx, $lmtSze, $orgID);
                $cntr = 0;
                $colClassType1 = "col-lg-2";
                $colClassType2 = "col-lg-3";
                $colClassType3 = "col-lg-4";
                ?>
                <form id='allPrsSetsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row rhoRowMargin">
                        <?php if ($canAddItmSet === true) { ?>
                            <div class="<?php echo $colClassType2; ?>" style="padding:0px 1px 0px 1px !important;"> 
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getOnePrsSetForm(-1, 3);" style="width:100% !important;">
                                        <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                        New Person Set
                                    </button>
                                </div>
                            </div>
                            <?php
                        } else {
                            $colClassType1 = "col-lg-4";
                            $colClassType2 = "col-lg-4";
                            $colClassType3 = "col-lg-4";
                        }
                        ?>
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="allPrsSetsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncAllPrsSets(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="allPrsSetsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsSets('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsSets('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType3; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allPrsSetsSrchIn">
                                    <?php
                                    $valslctdArry = array("");
                                    $srchInsArrys = array("Name");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allPrsSetsDsplySze" style="min-width:70px !important;">                            
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
                            <nav aria-label="Page navigation">
                                <ul class="pagination" style="margin: 0px !important;">
                                    <li>
                                        <a class="rhopagination" href="javascript:getAllPrsSets('previous', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="rhopagination" href="javascript:getAllPrsSets('next', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>   
                </div>
                <div class="row" style="padding:0px 15px 0px 15px !important"> 
                    <div class="col-md-5" style="padding:0px 1px 0px 1px !important">
                        <fieldset class="basic_person_fs">                                        
                            <table class="table table-striped table-bordered table-responsive" id="allPrsSetsTable" cellspacing="0" width="100%" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Person Set Name</th>   
                                        <th>Enabled?</th>   
                                        <th>Is Default?</th> 
                                        <th>&nbsp;</th>                                       
                                        <?php if ($canDelItmSet === true) { ?>
                                            <th>&nbsp;</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usesSQL = "0";
                                    while ($row = loc_db_fetch_array($result)) {
                                        if ($sbmtdPrsnSetHdrID <= 0 && $cntr <= 0) {
                                            $sbmtdPrsnSetHdrID = $row[0];
                                            $usesSQL = $row[6];
                                        }
                                        $cntr += 1;
                                        ?>
                                        <tr id="allPrsSetsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                            <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                            <td class="lovtd"><?php echo $row[1]; ?>
                                                <input type="hidden" class="form-control" aria-label="..." id="allPrsSetsRow<?php echo $cntr; ?>_PrsSetID" value="<?php echo $row[0]; ?>">
                                            </td>
                                            <td class="lovtd">
                                                <?php
                                                $isChkd = "";
                                                $isRdOnly = "disabled=\"true\"";
                                                if ($row[3] == "1") {
                                                    $isChkd = "checked=\"true\"";
                                                }
                                                ?>   
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="form-check" style="font-size: 12px !important;">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" id="allPrsSetsRow<?php echo $cntr; ?>_IsEnbld" name="allPrsSetsRow<?php echo $cntr; ?>_IsEnbld" <?php echo $isChkd . " " . $isRdOnly; ?> >
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="lovtd">
                                                <?php
                                                $isChkd = "";
                                                $isRdOnly = "disabled=\"true\"";
                                                if ($row[5] == "1") {
                                                    $isChkd = "checked=\"true\"";
                                                }
                                                ?>   
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="form-check" style="font-size: 12px !important;">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" id="allPrsSetsRow<?php echo $cntr; ?>_IsDflt" name="allPrsSetsRow<?php echo $cntr; ?>_IsDflt" <?php echo $isChkd . " " . $isRdOnly; ?> >
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="lovtd">
                                                <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="getOnePrsSetForm(<?php echo $row[0]; ?>, 2);" data-toggle="tooltip" data-placement="bottom" title="View Details">
                                                    <img src="cmn_images/kghostview.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                            </td>
                                            <?php if ($canDelItmSet === true) { ?>
                                                <td class="lovtd">
                                                    <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="alert('del');" data-toggle="tooltip" data-placement="bottom" title="Delete Question">
                                                        <img src="cmn_images/no.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                        
                        </fieldset>
                    </div>                        
                    <div  class="col-md-7" style="padding:0px 1px 0px 1px !important">
                        <fieldset class="basic_person_fs" style="padding-top:5px !important;">
                            <div class="" id="allPrsSetsDetailInfo">
                                <?php
                                $srchFor = "%";
                                $srchIn = "Name";
                                $pageNo = 1;
                                $lmtSze = 10;
                                $vwtyp = 1;
                                if ($sbmtdPrsnSetHdrID > 0) {
                                    $total = get_PrsnSetsDtTtl($srchFor, $srchIn, $sbmtdPrsnSetHdrID);
                                    if ($pageNo > ceil($total / $lmtSze)) {
                                        $pageNo = 1;
                                    } else if ($pageNo < 1) {
                                        $pageNo = ceil($total / $lmtSze);
                                    }

                                    $curIdx = $pageNo - 1;
                                    $result2 = get_PrsnSetsDt($srchFor, $srchIn, $curIdx, $lmtSze, $sbmtdPrsnSetHdrID);
                                    ?>
                                    <div class="row">
                                        <?php
                                        if ($canEdtItmSet === true && $usesSQL != "1") {
                                            $colClassType1 = "col-lg-2";
                                            $colClassType2 = "col-lg-3";
                                            $colClassType3 = "col-lg-4";
                                            $nwRowHtml = urlencode("<tr id=\"prsSetPrsnsRow__WWW123WWW\">"
                                                    . "<td class=\"lovtd\"><span class=\"normaltd\">New</span></td>"
                                                    . "<td class=\"lovtd\">
                                                                    <div class=\"input-group\">
                                                                        <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsSetPrsnsRow_WWW123WWW_PrsnLocID\" name=\"prsSetPrsnsRow_WWW123WWW_PrsnLocID\" value=\"\" readonly=\"true\">
                                                                        <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Active Persons', 'prsSetOrgID', '', '', 'radio', true, '', 'prsSetPrsnsRow_WWW123WWW_PrsnLocID', 'prsSetPrsnsRow_WWW123WWW_PrsnNm', 'clear', 1, '');\">
                                                                            <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                        </label>
                                                                    </div>
                                                                <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsSetPrsnsRow_WWW123WWW_PrsnID\" value=\"-1\" style=\"width:100% !important;\">                                              
                                                            </td>                                             
                                                            <td class=\"lovtd\">
                                                                <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsSetPrsnsRow_WWW123WWW_PrsnNm\" name=\"prsSetPrsnsRow_WWW123WWW_PrsnNm\" value=\"\" readonly=\"true\">                                                               
                                                            </td>
                                                                <td class=\"lovtd\">
                                                                    <button type=\"button\" class=\"btn btn-default\" style=\"margin: 0px !important;padding:0px 3px 2px 4px !important;\" onclick=\"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Delete Person\">
                                                                        <img src=\"cmn_images/no.png\" style=\"height:15px; width:auto; position: relative; vertical-align: middle;\">
                                                                    </button>
                                                                </td>
                                        </tr>");
                                            ?> 
                                            <div class="<?php echo $colClassType1; ?>" style="padding:0px 1px 0px 15px !important;">     
                                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('prsSetPrsnsTable', 0, '<?php echo $nwRowHtml; ?>');" data-toggle="tooltip" data-placement="bottom" title="New Possible Value">
                                                    <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="savePrsSetPrsnsForm();" data-toggle="tooltip" data-placement="bottom" title="Save Possible Values">
                                                    <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                            </div>
                                            <?php
                                        } else {
                                            $colClassType1 = "col-lg-4";
                                            $colClassType2 = "col-lg-4";
                                            $colClassType3 = "col-lg-4";
                                        }
                                        ?>
                                        <div class="<?php echo $colClassType3; ?>" style="padding:0px 15px 0px 15px !important;">
                                            <div class="input-group">
                                                <input class="form-control" id="prsSetPrsnsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncPrsSetPrsns(event, '', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');">
                                                <input id="prsSetPrsnsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsSetPrsns('clear', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </label>
                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsSetPrsns('', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </label> 
                                            </div>
                                        </div>
                                        <div class="<?php echo $colClassType2; ?>">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                                <!--<select data-placeholder="Select..." class="form-control chosen-select" id="prsSetPrsnsSrchIn">
                                                <?php
                                                $valslctdArry = array("");
                                                $srchInsArrys = array("Name");

                                                for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                    if ($srchIn == $srchInsArrys[$z]) {
                                                        $valslctdArry[$z] = "selected";
                                                    }
                                                    ?>
                                                                                                                                                                                                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                                <?php } ?>
                                                </select>-->
                                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                                <select data-placeholder="Select..." class="form-control chosen-select" id="prsSetPrsnsDsplySze" style="min-width:70px !important;">                            
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
                                        <div class="<?php echo $colClassType2; ?>">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination" style="margin: 0px !important;">
                                                    <li>
                                                        <a class="rhopagination" href="javascript:getAllPrsSetPrsns('previous', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="rhopagination" href="javascript:getAllPrsSetPrsns('next', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <input type="hidden" class="form-control" aria-label="..." id="prsSetOrgID" name="prsSetOrgID" value="<?php echo $orgID; ?>">
                                        </div>
                                    </div>
                                    <div class="row" style="padding:0px 15px 0px 15px !important">                  
                                        <div class="col-md-12" style="padding:0px 1px 0px 1px !important">
                                            <table class="table table-striped table-bordered table-responsive" id="prsSetPrsnsTable" cellspacing="0" width="100%" style="width:100%;min-width: 300px !important;">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Person ID</th>
                                                        <th>Full Name</th>
                                                        <?php if ($usesSQL != "1") { ?>
                                                            <th>&nbsp;</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cntr = 0;
                                                    while ($row2 = loc_db_fetch_array($result2)) {
                                                        $cntr += 1;
                                                        ?>
                                                        <tr id="prsSetPrsnsRow_<?php echo $cntr; ?>">                                    
                                                            <td class="lovtd"><span><?php echo ($curIdx * $lmtSze) + ($cntr); ?></span></td>
                                                            <td class="lovtd">
                                                                <?php if ($canEdtItmSet === true && $usesSQL != "1") { ?>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" aria-label="..." id="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnLocID" name="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnLocID" value="<?php echo $row2[1]; ?>" readonly="true">
                                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Active Persons', 'prsSetOrgID', '', '', 'radio', true, '<?php echo $row2[1]; ?>', 'prsSetPrsnsRow<?php echo $cntr; ?>_PrsnLocID', 'prsSetPrsnsRow<?php echo $cntr; ?>_PrsnNm', 'clear', 1, '');">
                                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                                        </label>
                                                                    </div>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row2[1]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" class="form-control" aria-label="..." id="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnID" value="<?php echo $row2[0]; ?>" style="width:100% !important;">                                              
                                                            </td>                                             
                                                            <td class="lovtd">  
                                                                <?php if ($canEdtItmSet === true && $usesSQL != "1") { ?>
                                                                    <input type="text" class="form-control" aria-label="..." id="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnNm" name="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnNm" value="<?php echo $row2[2]; ?>" readonly="true">
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row2[2]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php if ($usesSQL != "1") { ?>
                                                                <td class="lovtd">
                                                                    <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="" data-toggle="tooltip" data-placement="bottom" title="Delete Question from Survey">
                                                                        <img src="cmn_images/no.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                                    </button>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>                        
                                        </div>                
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <span>No Results Found</span>
                                <?php
                            }
                            ?>
                        </fieldset>
                    </div>
                </div>
                </form>
                <?php
            } else if ($vwtyp == 1) {
                $sbmtdPrsnSetHdrID = isset($_POST['sbmtdPrsnSetHdrID']) ? $_POST['sbmtdPrsnSetHdrID'] : -1;
                if ($sbmtdPrsnSetHdrID > 0) {
                    $total = get_PrsnSetsDtTtl($srchFor, $srchIn, $sbmtdPrsnSetHdrID);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    } else if ($pageNo < 1) {
                        $pageNo = ceil($total / $lmtSze);
                    }
                    $curIdx = $pageNo - 1;
                    $result2 = get_PrsnSetsDt($srchFor, $srchIn, $curIdx, $lmtSze, $sbmtdPrsnSetHdrID);
                    $usesSQL = getGnrlRecNm("pay.pay_prsn_sets_hdr", "prsn_set_hdr_id", "uses_sql", $sbmtdPrsnSetHdrID);
                    ?>
                    <div class="row">
                        <?php
                        if ($canEdtItmSet === true && $usesSQL != "1") {
                            $colClassType1 = "col-lg-2";
                            $colClassType2 = "col-lg-3";
                            $colClassType3 = "col-lg-4";
                            $nwRowHtml = urlencode("<tr id=\"prsSetPrsnsRow__WWW123WWW\">"
                                    . "<td class=\"lovtd\"><span class=\"normaltd\">New</span></td>"
                                    . "<td class=\"lovtd\">
                                                                    <div class=\"input-group\">
                                                                        <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsSetPrsnsRow_WWW123WWW_PrsnLocID\" name=\"prsSetPrsnsRow_WWW123WWW_PrsnLocID\" value=\"\" readonly=\"true\">
                                                                        <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Active Persons', 'prsSetOrgID', '', '', 'radio', true, '', 'prsSetPrsnsRow_WWW123WWW_PrsnLocID', 'prsSetPrsnsRow_WWW123WWW_PrsnNm', 'clear', 1, '');\">
                                                                            <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                        </label>
                                                                    </div>
                                                                <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsSetPrsnsRow_WWW123WWW_PrsnID\" value=\"-1\" style=\"width:100% !important;\">                                              
                                                            </td>                                             
                                                            <td class=\"lovtd\">
                                                                <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsSetPrsnsRow_WWW123WWW_PrsnNm\" name=\"prsSetPrsnsRow_WWW123WWW_PrsnNm\" value=\"\" readonly=\"true\">                                                               
                                                            </td>
                                                                <td class=\"lovtd\">
                                                                    <button type=\"button\" class=\"btn btn-default\" style=\"margin: 0px !important;padding:0px 3px 2px 4px !important;\" onclick=\"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Delete Person\">
                                                                        <img src=\"cmn_images/no.png\" style=\"height:15px; width:auto; position: relative; vertical-align: middle;\">
                                                                    </button>
                                                                </td>
                                        </tr>");
                            ?> 
                            <div class="<?php echo $colClassType1; ?>" style="padding:0px 1px 0px 15px !important;">     
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('prsSetPrsnsTable', 0, '<?php echo $nwRowHtml; ?>');" data-toggle="tooltip" data-placement="bottom" title="New Possible Value">
                                    <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                </button>
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="savePrsSetPrsnsForm();" data-toggle="tooltip" data-placement="bottom" title="Save Possible Values">
                                    <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                </button>
                            </div>
                            <?php
                        } else {
                            $colClassType1 = "col-lg-4";
                            $colClassType2 = "col-lg-4";
                            $colClassType3 = "col-lg-4";
                        }
                        ?>
                        <div class="<?php echo $colClassType3; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="prsSetPrsnsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncPrsSetPrsns(event, '', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');">
                                <input id="prsSetPrsnsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsSetPrsns('clear', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsSetPrsns('', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType2; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <!--<select data-placeholder="Select..." class="form-control chosen-select" id="prsSetPrsnsSrchIn">
                                <?php
                                $valslctdArry = array("");
                                $srchInsArrys = array("Name");

                                for ($z = 0; $z < count($srchInsArrys); $z++) {
                                    if ($srchIn == $srchInsArrys[$z]) {
                                        $valslctdArry[$z] = "selected";
                                    }
                                    ?>
                                                                                                                                                                                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                <?php } ?>
                                </select>-->
                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="prsSetPrsnsDsplySze" style="min-width:70px !important;">                            
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
                        <div class="<?php echo $colClassType2; ?>">
                            <nav aria-label="Page navigation">
                                <ul class="pagination" style="margin: 0px !important;">
                                    <li>
                                        <a class="rhopagination" href="javascript:getAllPrsSetPrsns('previous', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="rhopagination" href="javascript:getAllPrsSetPrsns('next', '#allPrsSetsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetHdrID=<?php echo $sbmtdPrsnSetHdrID; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <input type="hidden" class="form-control" aria-label="..." id="prsSetOrgID" name="prsSetOrgID" value="<?php echo $orgID; ?>">
                        </div>
                    </div>
                    <div class="row" style="padding:0px 15px 0px 15px !important">                  
                        <div class="col-md-12" style="padding:0px 1px 0px 1px !important">
                            <table class="table table-striped table-bordered table-responsive" id="prsSetPrsnsTable" cellspacing="0" width="100%" style="width:100%;min-width: 300px !important;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Person ID</th>
                                        <th>Full Name</th>
                                        <?php if ($usesSQL != "1") { ?>
                                            <th>&nbsp;</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cntr = 0;
                                    while ($row2 = loc_db_fetch_array($result2)) {
                                        $cntr += 1;
                                        ?>
                                        <tr id="prsSetPrsnsRow_<?php echo $cntr; ?>">                                    
                                            <td class="lovtd"><span><?php echo ($curIdx * $lmtSze) + ($cntr); ?></span></td>
                                            <td class="lovtd">
                                                <?php if ($canEdtItmSet === true && $usesSQL != "1") { ?>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" aria-label="..." id="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnLocID" name="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnLocID" value="<?php echo $row2[1]; ?>" readonly="true">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Active Persons', 'prsSetOrgID', '', '', 'radio', true, '<?php echo $row2[1]; ?>', 'prsSetPrsnsRow<?php echo $cntr; ?>_PrsnLocID', 'prsSetPrsnsRow<?php echo $cntr; ?>_PrsnNm', 'clear', 1, '');">
                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                        </label>
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <span><?php echo $row2[1]; ?></span>
                                                    <?php
                                                }
                                                ?>
                                                <input type="hidden" class="form-control" aria-label="..." id="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnID" value="<?php echo $row2[0]; ?>" style="width:100% !important;">                                              
                                            </td>                                             
                                            <td class="lovtd">  
                                                <?php if ($canEdtItmSet === true && $usesSQL != "1") { ?>
                                                    <input type="text" class="form-control" aria-label="..." id="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnNm" name="prsSetPrsnsRow<?php echo $cntr; ?>_PrsnNm" value="<?php echo $row2[2]; ?>" readonly="true">
                                                <?php } else {
                                                    ?>
                                                    <span><?php echo $row2[2]; ?></span>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <?php if ($usesSQL != "1") { ?>
                                                <td class="lovtd">
                                                    <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="" data-toggle="tooltip" data-placement="bottom" title="Delete Question from Survey">
                                                        <img src="cmn_images/no.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                        
                        </div>                
                    </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <span>No Results Found</span>
                    <?php
                }
            } else if ($vwtyp == 2) {
                //Prsn Set Detail                
                $sbmtdPrsnSetHdrID = isset($_POST['sbmtdPrsnSetHdrID']) ? $_POST['sbmtdPrsnSetHdrID'] : -1;
                $result = get_PrsnSetDetail($sbmtdPrsnSetHdrID);
                while ($row = loc_db_fetch_array($result)) {
                    ?>
                    <form class="form-horizontal" id='prsSetDetailsForm' action='' method='post' accept-charset='UTF-8'>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-md-4">
                                    <label for="prsnSetNm" class="control-label">Person Set Name:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="prsnSetNm" id="prsnSetNm" class="form-control" value="<?php echo $row[1]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-md-4">
                                    <label for="prsnSetDesc" class="control-label">Person Set Description:</label>
                                </div>
                                <div class="col-md-8">     
                                    <textarea rows="2" name="prsnSetDesc" id="prsnSetDesc" class="form-control"><?php echo $row[2]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="prsnSetUsesSQL" class="control-label">
                                            <?php
                                            $isChkd = "";
                                            $isRdOnly = "";
                                            ?>
                                            <input type="checkbox" name="prsnSetUsesSQL" id="prsnSetUsesSQL" <?php echo $isChkd . " " . $isRdOnly; ?>>Uses SQL</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="prsnSetEnbld" class="control-label">
                                            <?php
                                            $isChkd = "";
                                            $isRdOnly = "";
                                            ?>
                                            <input type="checkbox" name="prsnSetEnbld" id="prsnSetEnbld" <?php echo $isChkd . " " . $isRdOnly; ?>>Enabled?</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="prsnSetIsDflt" class="control-label">
                                            <?php
                                            $isChkd = "";
                                            $isRdOnly = "";
                                            ?>
                                            <input type="checkbox" name="prsnSetIsDflt"  id="prsnSetIsDflt" <?php echo $isChkd . " " . $isRdOnly; ?>>Default Person Set?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">                                
                                <div class="col-md-12" style="margin-bottom:5px;">
                                    <label for="prsnSetSQL" class="control-label">Person Set SQL Query: </label>
                                </div>
                                <div class="col-md-12" style="margin-bottom:5px;">
                                    <textarea rows="10" name="prsnSetSQL" id="prsnSetSQL" class="form-control"><?php echo $row[4]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-md-12">
                                    <?php
                                    if ($canEdtItmSet === true) {
                                        $nwRowHtml = urlencode("<tr id=\"prsSetAlwdRlsRow__WWW123WWW\">"
                                                . "<td class=\"lovtd\"><span class=\"normaltd\">New</span></td>"
                                                . "<td class=\"lovtd\">
                                                                <div class=\"input-group\" style=\"width:100% !important;\">
                                                                    <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsSetAlwdRlsRow_WWW123WWW_RoleNm\" name=\"prsSetAlwdRlsRow_WWW123WWW_RoleNm\" value=\"\" readonly=\"true\" style=\"width:100% !important;\">
                                                                    <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsSetAlwdRlsRow_WWW123WWW_RoleID\" value=\"-1\" style=\"width:100% !important;\">                                              
                                                                    <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'User Roles', '', '', '', 'radio', true, '', 'prsSetAlwdRlsRow_WWW123WWW_RoleID', 'prsSetAlwdRlsRow_WWW123WWW_RoleNm', 'clear', 1, '');\">
                                                                        <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                    </label>
                                                                </div> 
                                                            <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsSetAlwdRlsRow_WWW123WWW_PayRoleID\" value=\"-1\" style=\"width:100% !important;\">                                                             
                                                            </td>  
                                                            <td class=\"lovtd\">
                                                                <button type=\"button\" class=\"btn btn-default\" style=\"margin: 0px !important;padding:0px 3px 2px 4px !important;\" onclick=\"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Delete Role Set\">
                                                                    <img src=\"cmn_images/no.png\" style=\"height:15px; width:auto; position: relative; vertical-align: middle;\">
                                                                </button>
                                                            </td>
                                        </tr>");
                                        ?> 
                                        <div class="" style="float:right !important;padding-right: 1px;">
                                            <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('prsSetAllwdRolesTable', 0, '<?php echo $nwRowHtml; ?>');" data-toggle="tooltip" data-placement="bottom" title = "New Role">
                                                <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Add Role Set
                                            </button>
                                            <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="" data-toggle="tooltip" data-placement="bottom" title = "Saves Person Set">
                                                <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Save Person Set
                                            </button>
                                        </div>
                                    <?php } else { ?>                                        
                                        <label class="control-label">Permitted / Allowed Role Sets:</label>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-responsive" id="prsSetAllwdRolesTable" cellspacing="0" width="100%" style="width:100%;min-width: 300px !important;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Role Set Name</th>
                                                <?php if ($canEdtItmSet === true) { ?>
                                                    <th>&nbsp;</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cntr = 0;
                                            $result2 = get_AllRoles1($sbmtdPrsnSetHdrID);
                                            while ($row2 = loc_db_fetch_array($result2)) {
                                                $cntr += 1;
                                                ?>
                                                <tr id="prsSetAlwdRlsRow_<?php echo $cntr; ?>">                                    
                                                    <td class="lovtd"><span><?php echo ($cntr); ?></span></td>
                                                    <td class="lovtd">
                                                        <span><?php echo $row2[1]; ?></span>
                                                        <input type="hidden" class="form-control" aria-label="..." id="prsSetAlwdRlsRow<?php echo $cntr; ?>_PayRoleID" value="<?php echo $row2[2]; ?>" style="width:100% !important;">                                              
                                                    </td>     
                                                    <?php if ($canEdtItmSet === true) { ?>
                                                        <td class="lovtd">
                                                            <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="" data-toggle="tooltip" data-placement="bottom" title="Delete Role Set">
                                                                <img src="cmn_images/no.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                            </button>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>   
                                </div>
                            </div>
                        </div>
                    </form>                    
                    <?php
                }
            } else if ($vwtyp == 3) {
                //New Person Set
                ?>              
                <form class="form-horizontal" id='prsSetDetailsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-md-4">
                                <label for="prsnSetNm" class="control-label">Person Set Name:</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="prsnSetNm" id="prsnSetNm" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-md-4">
                                <label for="prsnSetDesc" class="control-label">Person Set Description:</label>
                            </div>
                            <div class="col-md-8">   
                                <textarea rows="2" name="prsnSetDesc" id="prsnSetDesc" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="prsnSetUsesSQL" class="control-label">
                                        <?php
                                        $isChkd = "";
                                        $isRdOnly = "";
                                        ?>
                                        <input type="checkbox" name="prsnSetUsesSQL" id="prsnSetUsesSQL" <?php echo $isChkd . " " . $isRdOnly; ?>>Uses SQL</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="prsnSetEnbld" class="control-label">
                                        <?php
                                        $isChkd = "";
                                        $isRdOnly = "";
                                        ?>
                                        <input type="checkbox" name="prsnSetEnbld" id="prsnSetEnbld" <?php echo $isChkd . " " . $isRdOnly; ?>>Enabled?</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="prsnSetIsDflt" class="control-label">
                                        <?php
                                        $isChkd = "";
                                        $isRdOnly = "";
                                        ?>
                                        <input type="checkbox" name="prsnSetIsDflt"  id="prsnSetIsDflt" <?php echo $isChkd . " " . $isRdOnly; ?>>Default Person Set?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">                                
                            <div class="col-md-12" style="margin-bottom:5px;">
                                <label for="prsnSetSQL" class="control-label">Person Set SQL Query: </label>
                            </div>
                            <div class="col-md-12" style="margin-bottom:5px;">
                                <textarea rows="10" name="prsnSetSQL" id="prsnSetSQL" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-md-12">
                                <?php
                                $nwRowHtml = urlencode("<tr id=\"prsSetAlwdRlsRow__WWW123WWW\">"
                                        . "<td class=\"lovtd\"><span class=\"normaltd\">New</span></td>"
                                        . "<td class=\"lovtd\">
                                                                <div class=\"input-group\" style=\"width:100% !important;\">
                                                                    <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsSetAlwdRlsRow_WWW123WWW_RoleNm\" name=\"prsSetAlwdRlsRow_WWW123WWW_RoleNm\" value=\"\" readonly=\"true\" style=\"width:100% !important;\">
                                                                    <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsSetAlwdRlsRow_WWW123WWW_RoleID\" value=\"-1\" style=\"width:100% !important;\">                                              
                                                                    <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'User Roles', '', '', '', 'radio', true, '', 'prsSetAlwdRlsRow_WWW123WWW_RoleID', 'prsSetAlwdRlsRow_WWW123WWW_RoleNm', 'clear', 1, '');\">
                                                                        <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                    </label>
                                                                </div> 
                                                            <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsSetAlwdRlsRow_WWW123WWW_PayRoleID\" value=\"-1\" style=\"width:100% !important;\">                                                             
                                                            </td>  
                                                            <td class=\"lovtd\">
                                                                <button type=\"button\" class=\"btn btn-default\" style=\"margin: 0px !important;padding:0px 3px 2px 4px !important;\" onclick=\"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Delete Role Set\">
                                                                    <img src=\"cmn_images/no.png\" style=\"height:15px; width:auto; position: relative; vertical-align: middle;\">
                                                                </button>
                                                            </td>
                                        </tr>");
                                ?> 
                                <div class="" style="float:right !important;padding-right: 1px;">
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('prsSetAllwdRolesTable', 0, '<?php echo $nwRowHtml; ?>');" data-toggle="tooltip" data-placement="bottom" title = "New Role">
                                        <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Add Role Set
                                    </button>
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="" data-toggle="tooltip" data-placement="bottom" title = "Saves Person Set">
                                        <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Save Person Set
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-responsive" id="prsSetAllwdRolesTable" cellspacing="0" width="100%" style="width:100%;min-width: 300px !important;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Role Set Name</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cntr = 0;
                                        $cntr += 1;
                                        ?>
                                        <tr id="prsSetAlwdRlsRow_<?php echo $cntr; ?>">                                    
                                            <td class="lovtd"><span><?php echo ($cntr); ?></span></td>
                                            <td class="lovtd">
                                                <div class="input-group" style="width:100% !important;">
                                                    <input type="text" class="form-control" aria-label="..." id="prsSetAlwdRlsRow<?php echo $cntr; ?>_RoleNm" name="prsSetAlwdRlsRow<?php echo $cntr; ?>_RoleNm" value="" readonly="true" style="width:100% !important;">
                                                    <input type="hidden" class="form-control" aria-label="..." id="prsSetAlwdRlsRow<?php echo $cntr; ?>_RoleID" value="-1" style="width:100% !important;">                                              
                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'User Roles', '', '', '', 'radio', true, '', 'prsSetAlwdRlsRow<?php echo $cntr; ?>_RoleID', 'prsSetAlwdRlsRow<?php echo $cntr; ?>_RoleNm', 'clear', 1, '');">
                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                    </label>
                                                </div> 
                                                <input type="hidden" class="form-control" aria-label="..." id="prsSetAlwdRlsRow<?php echo $cntr; ?>_PayRoleID" value="" style="width:100% !important;">                                              
                                            </td> 
                                            <td class="lovtd">
                                                <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="" data-toggle="tooltip" data-placement="bottom" title="Delete Role Set">
                                                    <img src="cmn_images/no.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>   
                            </div>
                        </div>
                    </div>
                </form>   
                <?php
            }
        }
    }
}    
