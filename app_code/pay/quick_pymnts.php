<?php
$pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
$lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
$sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";
$curIdx = 0;
$orgID = $_SESSION['ORG_ID'];
$usrID = $_SESSION['USRID'];
$canview = test_prmssns($dfltPrvldgs[1], $mdlNm);
$canAddQckPay = test_prmssns($dfltPrvldgs[9], $mdlNm);
$canRvrsQckPay = test_prmssns($dfltPrvldgs[10], $mdlNm);
$canVwOthrsQckPay = test_prmssns($dfltPrvldgs[38], $mdlNm);

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
            $dfltStoreID = getUserStoreID($usrID, $orgID);
            $dfltStoreNm = getGnrlRecNm("inv.inv_itm_subinventories", "subinv_id", "subinv_name", $dfltStoreID);
            if ($vwtyp == 0) {
                $sbmtdPrsnSetID = isset($_POST['sbmtdPrsnSetID']) ? $_POST['sbmtdPrsnSetID'] : -1;
                $sbmtdItmSetID = isset($_POST['sbmtdItmSetID']) ? $_POST['sbmtdItmSetID'] : -1;
                $sbmtdPrsnSetMmbrID = isset($_POST['sbmtdPrsnSetMmbrID']) ? $_POST['sbmtdPrsnSetMmbrID'] : -1;
                $sbmtdPrsnSetNm = "";
                $sbmtdItmSetNm = "";
                echo $cntent . "<li>
                                    <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                    <span style=\"text-decoration:none;\">Person Payments & Setups</span>
				</li>
                               </ul>
                              </div>";
                if ($sbmtdPrsnSetID <= 0) {
                    $vl = get_Org_DfltPrsSt($orgID);
                    $sbmtdPrsnSetID = $vl[0];
                    $sbmtdPrsnSetNm = $vl[1];
                }
                if ($sbmtdItmSetID <= 0) {
                    $vl = get_Org_DfltItmSt($orgID);
                    $sbmtdItmSetID = $vl[0];
                    $sbmtdItmSetNm = $vl[1];
                }
                $total = get_SlctdPrsnsInSetTtl($srchFor, $srchIn, $orgID, $sbmtdPrsnSetID);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result = get_SlctdPrsnsInSet($srchFor, $srchIn, $curIdx, $lmtSze, $orgID, $sbmtdPrsnSetID);
                $cntr = 0;
                $colClassType1 = "col-lg-2";
                $colClassType2 = "col-lg-6";
                $colClassType3 = "col-lg-4";
                ?>
                <form id='qckPayPrsnsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row rhoRowMargin">
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="qckPayPrsnsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncQckPayPrsns(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="qckPayPrsnsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getQckPayPrsns('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getQckPayPrsns('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType3; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="qckPayPrsnsSrchIn">
                                    <?php
                                    $valslctdArry = array("");
                                    $srchInsArrys = array("Full Name/ID");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="qckPayPrsnsDsplySze" style="min-width:70px !important;">                            
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
                                        <a class="rhopagination" href="javascript:getQckPayPrsns('previous', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="rhopagination" href="javascript:getQckPayPrsns('next', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>                    
                    <div class="row " style="margin-bottom:2px;padding:2px 15px 2px 15px !important">   
                        <div class="col-lg-12" style="padding:2px 0px 1px 0px !important;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">
                            <div class="form-group form-group-sm col-lg-6" style="padding:0px 15px 0px 0px!important;">
                                <div  class="col-lg-7" style="padding:0px 1px 0px 0px !important;">
                                    <div class="input-group" style="padding:0px !important;">
                                        <label for="qckPayPrsnSetNm" class="btn input-group-addon" style="min-width: 78px;">Person Set:</label>
                                        <input type="text" class="form-control" aria-label="..." id="qckPayPrsnSetNm" name="qckPayPrsnSetNm" value="<?php echo $sbmtdPrsnSetNm; ?>" readonly="true">
                                        <input type="hidden" class="form-control" aria-label="..." id="qckPayPrsnSetID" name="qckPayPrsnSetID" value="<?php echo $sbmtdPrsnSetID; ?>">
                                        <input type="hidden" class="form-control" aria-label="..." id="qckPayOrgID" name="qckPayOrgID" value="<?php echo $orgID; ?>">
                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Person Sets for Payments(Enabled)', 'qckPayOrgID', '', '', 'radio', true, '<?php echo $sbmtdPrsnSetID; ?>', 'qckPayPrsnSetID', 'qckPayPrsnSetNm', 'clear', 0, '', function () {
                                                    reloadPrsnsInSet();
                                                });">
                                            <span class="glyphicon glyphicon-th-list"></span>
                                        </label>
                                    </div>
                                </div>
                                <div  class="col-lg-5" style="padding:0px !important;">
                                    <div class="input-group">
                                        <label for="qckPayItmSetNm" class="btn input-group-addon" style="min-width: 78px;">Item Set:</label>
                                        <input type="text" class="form-control" aria-label="..." id="qckPayItmSetNm" name="qckPayItmSetNm" value="<?php echo $sbmtdItmSetNm; ?>" readonly="true">
                                        <input type="hidden" class="form-control" aria-label="..." id="qckPayItmSetID" name="qckPayItmSetID" value="<?php echo $sbmtdItmSetID; ?>">
                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Item Sets for Payments(Enabled)', 'qckPayOrgID', '', '', 'radio', true, '<?php echo $sbmtdItmSetID; ?>', 'qckPayItmSetID', 'qckPayItmSetNm', 'clear', 0, '', function () {});">
                                            <span class="glyphicon glyphicon-th-list"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="padding:0px 15px 0px 15px !important;">
                                <button type="button" class="btn btn-default btn-sm" onclick="">
                                    <img src="cmn_images/pay.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    New Bill/Payment
                                </button>
                                <button type="button" class="btn btn-default btn-sm" onclick="">
                                    <img src="cmn_images/payment_256.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    New Invoice
                                </button>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="row" style="padding:0px 15px 0px 15px !important"> 
                    <div  class="col-md-3" style="padding:0px 1px 0px 1px !important">
                        <fieldset class="basic_person_fs">                                        
                            <table class="table table-striped table-bordered table-responsive" id="qckPayPrsnsTable" cellspacing="0" width="100%" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Full Name (ID)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = loc_db_fetch_array($result)) {
                                        if ($sbmtdPrsnSetMmbrID <= 0 && $cntr <= 0) {
                                            $sbmtdPrsnSetMmbrID = $row[0];
                                        }
                                        $cntr += 1;
                                        ?>
                                        <tr id="qckPayPrsnsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                            <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                            <td class="lovtd"><?php echo $row[2] . " (" . $row[1] . ")"; ?>
                                                <input type="hidden" class="form-control" aria-label="..." id="qckPayPrsnsRow<?php echo $cntr; ?>_PrsnID" value="<?php echo $row[0]; ?>">
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                        
                        </fieldset>
                    </div>                        
                    <div  class="col-md-9" style="padding:0px 1px 0px 1px !important">
                        <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                            <div class="rho-container-fluid" id="qckPayPrsnsDetailInfo">
                                <?php
                                if ($sbmtdPrsnSetMmbrID > 0) {
                                    $result1 = get_PrsnDet($sbmtdPrsnSetMmbrID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $nwFileName = "";
                                        $temp = explode(".", $row1[2]);
                                        $extension = end($temp);
                                        $nwFileName = encrypt1($row1[2], $smplTokenWord1) . "." . $extension;
                                        $ftp_src = $ftp_base_db_fldr . "/Person/" . $row1[2];
                                        $fullPemDest = $fldrPrfx . $tmpDest . $nwFileName;
                                        if (file_exists($ftp_src)) {
                                            copy("$ftp_src", "$fullPemDest");
                                            //echo $fullPemDest;
                                        } else if (!file_exists($fullPemDest)) {
                                            $ftp_src = $fldrPrfx . 'cmn_images/image_up.png';
                                            copy("$ftp_src", "$fullPemDest");
                                            //echo $ftp_src;
                                        }
                                        ?>
                                        <div class="row phone-only-btn" style="margin: 0px 0px 10px 0px !important;">
                                            <div class="col-md-12" style="padding:0px 0px 0px 0px !important;">
                                                <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#qckPayPrsnsDetailInfo', 'grp=7&typ=1&pg=4&vtyp=1&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">Payment History</button>
                                                <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prsnPyItmsAsgndPage', 'grp=7&typ=1&pg=4&vtyp=3&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">Pay Items Assigned</button>
                                                <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prsnBankAcntsPage', 'grp=7&typ=1&pg=4&vtyp=4&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">Person Bank Accounts</button>
                                            </div>
                                        </div>
                                        <ul class="nav nav-tabs rho-hideable-tabs" style="margin-top:-5px !important;">
                                            <li class="active"><a data-toggle="tab" data-rhodata="&pg=4&vtyp=1&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>" href="#prsnPyHstryPage" id="prsnPyHstryPagetab">Payment History</a></li>
                                            <li><a data-toggle="tabajxqpay" data-rhodata="&pg=4&vtyp=3&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>" href="#prsnPyItmsAsgndPage" id="prsnPyItmsAsgndPagetab">Pay Items Assigned</a></li>
                                            <li><a data-toggle="tabajxqpay" data-rhodata="&pg=4&vtyp=4&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>" href="#prsnBankAcntsPage" id="prsnBankAcntsPagetab">Person Bank Accounts</a></li>
                                        </ul>
                                        <div class="row">                  
                                            <div class="col-md-12">
                                                <div class="custDiv" style="padding:2px 10px 2px 10px !important;"> 
                                                    <div class="tab-content">
                                                        <div id="prsnPyHstryPage" class="tab-pane fadein active" style="border:none !important;"> 
                                                            <div class="row">
                                                                <fieldset class="basic_person_fs">
                                                                    <div class="col-lg-2" style="padding:0px 3px 0px 3px !important;">
                                                                        <fieldset class="basic_person_fs">
                                                                            <div style="margin-bottom: 10px;">
                                                                                <img src="<?php echo $tmpDest . $nwFileName; ?>" alt="..." id="img1Test" class="img-rounded center-block img-responsive" style="height: 100px !important; width: auto !important;">                                            
                                                                            </div>                                       
                                                                        </fieldset>
                                                                    </div>                                
                                                                    <div class="col-lg-5" style="padding:0px 3px 0px 3px !important;">
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="idNo" class="control-label col-md-4">ID No:</label>
                                                                            <div class="col-md-8">
                                                                                <span><?php echo $row1[1]; ?></span>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="fullname" class="control-label col-md-4">Title:</label>
                                                                            <div  class="col-md-8">
                                                                                <span><?php echo $row1[35]; ?></span>
                                                                            </div>
                                                                        </div>  
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="gender" class="control-label col-md-4">Gender:</label>
                                                                            <div  class="col-md-8">
                                                                                <span><?php echo $row1[8]; ?></span>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="dob" class="control-label col-md-4">Age (DOB):</label>
                                                                            <div class="col-md-8">
                                                                                <span><?php echo $row1[10]; ?></span>
                                                                            </div>
                                                                        </div>  
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="dob" class="control-label col-md-4">Mobile No.:</label>
                                                                            <div class="col-md-8">
                                                                                <span><?php echo trim($row1[17] . " " . $row1[16], " "); ?></span>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="dob" class="control-label col-md-4">Email:</label>
                                                                            <div class="col-md-8">
                                                                                <span><?php echo $row1[15]; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="linkdFirm" class="control-label col-md-4">Linked Firm:</label>
                                                                            <div  class="col-md-8">
                                                                                <span><?php echo $row1[21] . " (" . $row1[22] . ")"; ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5" style="padding:0px 3px 0px 3px !important;"> 
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="nationality" class="control-label col-md-4">Groups:</label>
                                                                            <div  class="col-md-8">
                                                                                <span><?php echo $row1[29]; ?></span>
                                                                            </div>
                                                                        </div>  
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="homeTown" class="control-label col-md-4">Locations:</label>
                                                                            <div  class="col-md-8">
                                                                                <span><?php echo $row1[30]; ?></span>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="jobs" class="control-label col-md-4">Jobs:</label>
                                                                            <div  class="col-md-8">
                                                                                <span><?php echo $row1[31]; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="dob" class="control-label col-md-4">Grades:</label>
                                                                            <div class="col-md-8">
                                                                                <span><?php echo $row1[32]; ?></span>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                            <label for="pob" class="control-label col-md-4">Positions:</label>
                                                                            <div  class="col-md-8">
                                                                                <span><?php echo $row1[33]; ?></span>
                                                                            </div>
                                                                        </div>    
                                                                    </div>                                                                                                         
                                                                </fieldset>
                                                            </div> 

                                                            <?php
                                                            $pageNo = 1;
                                                            $lmtSze = 10;
                                                            $srchFor = "%";
                                                            $srchIn = "Name/Number";
                                                            $total = get_MyPyRnsTtl($srchFor, $srchIn, $sbmtdPrsnSetMmbrID);
                                                            if ($pageNo > ceil($total / $lmtSze)) {
                                                                $pageNo = 1;
                                                            } else if ($pageNo < 1) {
                                                                $pageNo = ceil($total / $lmtSze);
                                                            }

                                                            $curIdx = $pageNo - 1;
                                                            $result2 = get_MyPyRnsTblr($srchFor, $srchIn, $curIdx, $lmtSze, $sbmtdPrsnSetMmbrID);
                                                            $colClassType1 = "col-lg-2";
                                                            $colClassType3 = "col-lg-5";
                                                            $vwtyp = 2;
                                                            ?>
                                                            <div class="row" id="prsnPyHstrysList" style="padding:0px 1px 0px 1px !important">
                                                                <div class="row">
                                                                    <div class="<?php echo $colClassType3; ?>" style="padding:0px 15px 0px 15px !important;">
                                                                        <div class="input-group">
                                                                            <input class="form-control" id="prsnPyHstrysSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncPrsnPyHstrys(event, '', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                                                            <input id="prsnPyHstrysPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getPrsnPyHstrys('clear', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                                                                <span class="glyphicon glyphicon-remove"></span>
                                                                            </label>
                                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getPrsnPyHstrys('', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                                                                <span class="glyphicon glyphicon-search"></span>
                                                                            </label> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="<?php echo $colClassType3; ?>">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                                                            <select data-placeholder="Select..." class="form-control chosen-select" id="prsnPyHstrysSrchIn">
                                                                                <?php
                                                                                $valslctdArry = array("");
                                                                                $srchInsArrys = array("Name/Number");

                                                                                for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                                                    if ($srchIn == $srchInsArrys[$z]) {
                                                                                        $valslctdArry[$z] = "selected";
                                                                                    }
                                                                                    ?>
                                                                                    <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                                                            <select data-placeholder="Select..." class="form-control chosen-select" id="prsnPyHstrysDsplySze" style="min-width:70px !important;">                            
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
                                                                                    <a class="rhopagination" href="javascript:getPrsnPyHstrys('previous', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Previous">
                                                                                        <span aria-hidden="true">&laquo;</span>
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="rhopagination" href="javascript:getPrsnPyHstrys('next', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Next">
                                                                                        <span aria-hidden="true">&raquo;</span>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </nav>
                                                                    </div>
                                                                </div>
                                                                <div class="row"> 
                                                                    <div class="col-md-12">
                                                                        <table class="table table-striped table-bordered table-responsive" id="prsnPyHstrysTable" cellspacing="0" width="100%" style="width:100%;min-width: 600px !important;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No.</th>
                                                                                    <th>Batch Name/Number</th>
                                                                                    <th>Description</th>
                                                                                    <th>Person Set</th>
                                                                                    <th>Item Set</th>
                                                                                    <th>Has Been Run?</th>
                                                                                    <th>Sent to GL?</th>
                                                                                    <th>&nbsp;</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $cntr = 0;
                                                                                while ($row2 = loc_db_fetch_array($result2)) {
                                                                                    $cntr += 1;
                                                                                    ?>
                                                                                    <tr id="prsnPyHstrysRow_<?php echo $cntr; ?>">                                    
                                                                                        <td class="lovtd"><span><?php echo ($curIdx * $lmtSze) + ($cntr); ?></span></td>
                                                                                        <td class="lovtd">                                                                   
                                                                                            <span><?php echo $row2[2]; ?></span>
                                                                                            <input type="hidden" class="form-control" aria-label="..." id="prsnPyHstrysRow<?php echo $cntr; ?>_MsPyID" value="<?php echo $row2[1]; ?>" style="width:100% !important;">
                                                                                            <input type="hidden" class="form-control" aria-label="..." id="prsnPyHstrysRow<?php echo $cntr; ?>_PyReqID" value="<?php echo $row2[0]; ?>">                                                         
                                                                                        </td>                                                
                                                                                        <td class="lovtd">
                                                                                            <span><?php echo $row2[3]; ?></span>                                                       
                                                                                        </td>                                               
                                                                                        <td class="lovtd">
                                                                                            <span><?php echo $row2[10]; ?></span>                                                       
                                                                                        </td>                                               
                                                                                        <td class="lovtd">
                                                                                            <span><?php echo $row2[11]; ?></span>                                                       
                                                                                        </td>
                                                                                        <td class="lovtd">
                                                                                            <?php
                                                                                            $isChkd = "";
                                                                                            if ($row2[12] == "1") {
                                                                                                $isChkd = "checked=\"true\"";
                                                                                            }
                                                                                            ?>                                                                    
                                                                                            <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                                                <div class="form-check" style="font-size: 12px !important;">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="checkbox" class="form-check-input" id="prsnPyHstrysRow<?php echo $cntr; ?>_BeenRun" name="prsnPyHstrysRow<?php echo $cntr; ?>_BeenRun" <?php echo $isChkd ?> disabled="true">
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="lovtd">
                                                                                            <?php
                                                                                            $isChkd = "";
                                                                                            if ($row2[13] == "1") {
                                                                                                $isChkd = "checked=\"true\"";
                                                                                            }
                                                                                            ?>                                                                    
                                                                                            <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                                                <div class="form-check" style="font-size: 12px !important;">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="checkbox" class="form-check-input" id="prsnPyHstrysRow<?php echo $cntr; ?>_ToGL" name="prsnPyHstrysRow<?php echo $cntr; ?>_ToGL" <?php echo $isChkd ?> disabled="true">
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="lovtd">
                                                                                            <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="getOnePrsnPyHstrysForm(<?php echo $row2[1]; ?>, <?php echo $row2[0]; ?>, 1, <?php echo $sbmtdPrsnSetMmbrID; ?>, '<?php echo $row2[2]; ?>');" data-toggle="tooltip" data-placement="bottom" title="View Details">
                                                                                                <img src="cmn_images/kghostview.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
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
                                                            </div>
                                                        </div>
                                                        <div id="prsnPyItmsAsgndPage" class="tab-pane fade" style="border:none !important;padding:1px !important;"></div>
                                                        <div id="prsnBankAcntsPage" class="tab-pane fade" style="border:none !important;padding:1px !important;"></div>
                                                    </div>                        
                                                </div>                         
                                            </div>                
                                        </div> 
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <span>No Results Found</span>
                                    <?php
                                }
                                ?>
                            </div>
                        </fieldset>
                    </div>
                </div>
                </form>
                <?php
            } else if ($vwtyp == 1) {
                $sbmtdPrsnSetMmbrID = isset($_POST['sbmtdPrsnSetMmbrID']) ? $_POST['sbmtdPrsnSetMmbrID'] : -1;
                if ($sbmtdPrsnSetMmbrID > 0) {
                    $result1 = get_PrsnDet($sbmtdPrsnSetMmbrID);
                    while ($row1 = loc_db_fetch_array($result1)) {
                        $nwFileName = "";
                        $temp = explode(".", $row1[2]);
                        $extension = end($temp);
                        $nwFileName = encrypt1($row1[2], $smplTokenWord1) . "." . $extension;
                        $ftp_src = $ftp_base_db_fldr . "/Person/" . $row1[2];
                        $fullPemDest = $fldrPrfx . $tmpDest . $nwFileName;
                        if (file_exists($ftp_src)) {
                            copy("$ftp_src", "$fullPemDest");
                            //echo $fullPemDest;
                        } else if (!file_exists($fullPemDest)) {
                            $ftp_src = $fldrPrfx . 'cmn_images/image_up.png';
                            copy("$ftp_src", "$fullPemDest");
                            //echo $ftp_src;
                        }
                        ?>
                        <div class="row phone-only-btn" style="margin: 0px 0px 10px 0px !important;">
                            <div class="col-md-12" style="padding:0px 0px 0px 0px !important;">
                                <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#qckPayPrsnsDetailInfo', 'grp=7&typ=1&pg=4&vtyp=1&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">Payment History</button>
                                <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prsnPyItmsAsgndPage', 'grp=7&typ=1&pg=4&vtyp=3&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">Pay Items Assigned</button>
                                <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prsnBankAcntsPage', 'grp=7&typ=1&pg=4&vtyp=4&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">Person Bank Accounts</button>
                            </div>
                        </div>
                        <ul class="nav nav-tabs rho-hideable-tabs" style="margin-top:-5px !important;">
                            <li class="active"><a data-toggle="tab" data-rhodata="&pg=4&vtyp=1&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>" href="#prsnPyHstryPage" id="prsnPyHstryPagetab">Payment History</a></li>
                            <li><a data-toggle="tabajxqpay" data-rhodata="&pg=4&vtyp=3&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>" href="#prsnPyItmsAsgndPage" id="prsnPyItmsAsgndPagetab">Pay Items Assigned</a></li>
                            <li><a data-toggle="tabajxqpay" data-rhodata="&pg=4&vtyp=4&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>" href="#prsnBankAcntsPage" id="prsnBankAcntsPagetab">Person Bank Accounts</a></li>
                        </ul>
                        <div class="row">                  
                            <div class="col-md-12">
                                <div class="custDiv" style="padding:2px 10px 2px 10px !important;"> 
                                    <div class="tab-content">
                                        <div id="prsnPyHstryPage" class="tab-pane fadein active" style="border:none !important;"> 
                                            <div class="row">
                                                <fieldset class="basic_person_fs">
                                                    <div class="col-lg-2" style="padding:0px 3px 0px 3px !important;">
                                                        <fieldset class="basic_person_fs">
                                                            <div style="margin-bottom: 10px;">
                                                                <img src="<?php echo $tmpDest . $nwFileName; ?>" alt="..." id="img1Test" class="img-rounded center-block img-responsive" style="height: 100px !important; width: auto !important;">                                            
                                                            </div>                                       
                                                        </fieldset>
                                                    </div>                                
                                                    <div class="col-lg-5" style="padding:0px 3px 0px 3px !important;">
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="idNo" class="control-label col-md-4">ID No:</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row1[1]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="fullname" class="control-label col-md-4">Title:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row1[35]; ?></span>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="gender" class="control-label col-md-4">Gender:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row1[8]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="dob" class="control-label col-md-4">Age (DOB):</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row1[10]; ?></span>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="dob" class="control-label col-md-4">Mobile No.:</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo trim($row1[17] . " " . $row1[16], " "); ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="dob" class="control-label col-md-4">Email:</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row1[15]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="linkdFirm" class="control-label col-md-4">Linked Firm:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row1[21] . " (" . $row1[22] . ")"; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5" style="padding:0px 3px 0px 3px !important;"> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="nationality" class="control-label col-md-4">Groups:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row1[29]; ?></span>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="homeTown" class="control-label col-md-4">Locations:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row1[30]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="jobs" class="control-label col-md-4">Jobs:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row1[31]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="dob" class="control-label col-md-4">Grades:</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row1[32]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="pob" class="control-label col-md-4">Positions:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row1[33]; ?></span>
                                                            </div>
                                                        </div>    
                                                    </div>                                                                                                         
                                                </fieldset>
                                            </div> 

                                            <?php
                                            $pageNo = 1;
                                            $lmtSze = 10;
                                            $srchFor = "%";
                                            $srchIn = "Name/Number";
                                            $total = get_MyPyRnsTtl($srchFor, $srchIn, $sbmtdPrsnSetMmbrID);
                                            if ($pageNo > ceil($total / $lmtSze)) {
                                                $pageNo = 1;
                                            } else if ($pageNo < 1) {
                                                $pageNo = ceil($total / $lmtSze);
                                            }

                                            $curIdx = $pageNo - 1;
                                            $result2 = get_MyPyRnsTblr($srchFor, $srchIn, $curIdx, $lmtSze, $sbmtdPrsnSetMmbrID);
                                            $colClassType1 = "col-lg-2";
                                            $colClassType3 = "col-lg-5";
                                            $vwtyp = 2;
                                            ?>
                                            <div class="row" id="prsnPyHstrysList" style="padding:0px 1px 0px 1px !important">
                                                <div class="row">
                                                    <div class="<?php echo $colClassType3; ?>" style="padding:0px 15px 0px 15px !important;">
                                                        <div class="input-group">
                                                            <input class="form-control" id="prsnPyHstrysSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncPrsnPyHstrys(event, '', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                                            <input id="prsnPyHstrysPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getPrsnPyHstrys('clear', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                            </label>
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getPrsnPyHstrys('', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                                                <span class="glyphicon glyphicon-search"></span>
                                                            </label> 
                                                        </div>
                                                    </div>
                                                    <div class="<?php echo $colClassType3; ?>">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                                            <select data-placeholder="Select..." class="form-control chosen-select" id="prsnPyHstrysSrchIn">
                                                                <?php
                                                                $valslctdArry = array("");
                                                                $srchInsArrys = array("Name/Number");

                                                                for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                                    if ($srchIn == $srchInsArrys[$z]) {
                                                                        $valslctdArry[$z] = "selected";
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                                            <select data-placeholder="Select..." class="form-control chosen-select" id="prsnPyHstrysDsplySze" style="min-width:70px !important;">                            
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
                                                                    <a class="rhopagination" href="javascript:getPrsnPyHstrys('previous', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Previous">
                                                                        <span aria-hidden="true">&laquo;</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="rhopagination" href="javascript:getPrsnPyHstrys('next', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Next">
                                                                        <span aria-hidden="true">&raquo;</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                                <div class="row"> 
                                                    <div class="col-md-12">
                                                        <table class="table table-striped table-bordered table-responsive" id="prsnPyHstrysTable" cellspacing="0" width="100%" style="width:100%;min-width: 600px !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Batch Name/Number</th>
                                                                    <th>Description</th>
                                                                    <th>Person Set</th>
                                                                    <th>Item Set</th>
                                                                    <th>Has Been Run?</th>
                                                                    <th>Sent to GL?</th>
                                                                    <th>&nbsp;</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $cntr = 0;
                                                                while ($row2 = loc_db_fetch_array($result2)) {
                                                                    $cntr += 1;
                                                                    ?>
                                                                    <tr id="prsnPyHstrysRow_<?php echo $cntr; ?>">                                    
                                                                        <td class="lovtd"><span><?php echo ($curIdx * $lmtSze) + ($cntr); ?></span></td>
                                                                        <td class="lovtd">                                                                   
                                                                            <span><?php echo $row2[2]; ?></span>
                                                                            <input type="hidden" class="form-control" aria-label="..." id="prsnPyHstrysRow<?php echo $cntr; ?>_MsPyID" value="<?php echo $row2[1]; ?>" style="width:100% !important;">
                                                                            <input type="hidden" class="form-control" aria-label="..." id="prsnPyHstrysRow<?php echo $cntr; ?>_PyReqID" value="<?php echo $row2[0]; ?>">                                                         
                                                                        </td>                                                
                                                                        <td class="lovtd">
                                                                            <span><?php echo $row2[3]; ?></span>                                                       
                                                                        </td>                                               
                                                                        <td class="lovtd">
                                                                            <span><?php echo $row2[10]; ?></span>                                                       
                                                                        </td>                                               
                                                                        <td class="lovtd">
                                                                            <span><?php echo $row2[11]; ?></span>                                                       
                                                                        </td>
                                                                        <td class="lovtd">
                                                                            <?php
                                                                            $isChkd = "";
                                                                            if ($row2[12] == "1") {
                                                                                $isChkd = "checked=\"true\"";
                                                                            }
                                                                            ?>                                                                    
                                                                            <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                                <div class="form-check" style="font-size: 12px !important;">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" class="form-check-input" id="prsnPyHstrysRow<?php echo $cntr; ?>_BeenRun" name="prsnPyHstrysRow<?php echo $cntr; ?>_BeenRun" <?php echo $isChkd ?> disabled="true">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="lovtd">
                                                                            <?php
                                                                            $isChkd = "";
                                                                            if ($row2[13] == "1") {
                                                                                $isChkd = "checked=\"true\"";
                                                                            }
                                                                            ?>                                                                    
                                                                            <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                                <div class="form-check" style="font-size: 12px !important;">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" class="form-check-input" id="prsnPyHstrysRow<?php echo $cntr; ?>_ToGL" name="prsnPyHstrysRow<?php echo $cntr; ?>_ToGL" <?php echo $isChkd ?> disabled="true">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="lovtd">
                                                                            <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="getOnePrsnPyHstrysForm(<?php echo $row2[1]; ?>, <?php echo $row2[0]; ?>, 1, <?php echo $sbmtdPrsnSetMmbrID; ?>, '<?php echo $row2[2]; ?>');" data-toggle="tooltip" data-placement="bottom" title="View Details">
                                                                                <img src="cmn_images/kghostview.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
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
                                            </div>
                                        </div>
                                        <div id="prsnPyItmsAsgndPage" class="tab-pane fade" style="border:none !important;padding:1px !important;"></div>
                                        <div id="prsnBankAcntsPage" class="tab-pane fade" style="border:none !important;padding:1px !important;"></div>
                                    </div>                        
                                </div>                         
                            </div>                
                        </div> 
                        <?php
                    }
                } else {
                    ?>
                    <span>No Results Found</span>
                    <?php
                }
            } else if ($vwtyp == 2) {
                $sbmtdPrsnSetMmbrID = isset($_POST['sbmtdPrsnSetMmbrID']) ? $_POST['sbmtdPrsnSetMmbrID'] : -1;
                $total = get_MyPyRnsTtl($srchFor, $srchIn, $sbmtdPrsnSetMmbrID);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result2 = get_MyPyRnsTblr($srchFor, $srchIn, $curIdx, $lmtSze, $sbmtdPrsnSetMmbrID);
                $colClassType1 = "col-lg-2";
                $colClassType3 = "col-lg-5";
                $vwtyp = 2;
                ?>
                <div class="row">
                    <div class="<?php echo $colClassType3; ?>" style="padding:0px 15px 0px 15px !important;">
                        <div class="input-group">
                            <input class="form-control" id="prsnPyHstrysSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncPrsnPyHstrys(event, '', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                            <input id="prsnPyHstrysPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                            <label class="btn btn-primary btn-file input-group-addon" onclick="getPrsnPyHstrys('clear', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                <span class="glyphicon glyphicon-remove"></span>
                            </label>
                            <label class="btn btn-primary btn-file input-group-addon" onclick="getPrsnPyHstrys('', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                <span class="glyphicon glyphicon-search"></span>
                            </label> 
                        </div>
                    </div>
                    <div class="<?php echo $colClassType3; ?>">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                            <select data-placeholder="Select..." class="form-control chosen-select" id="prsnPyHstrysSrchIn">
                                <?php
                                $valslctdArry = array("");
                                $srchInsArrys = array("Name/Number");

                                for ($z = 0; $z < count($srchInsArrys); $z++) {
                                    if ($srchIn == $srchInsArrys[$z]) {
                                        $valslctdArry[$z] = "selected";
                                    }
                                    ?>
                                    <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                <?php } ?>
                            </select>
                            <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                            <select data-placeholder="Select..." class="form-control chosen-select" id="prsnPyHstrysDsplySze" style="min-width:70px !important;">                            
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
                                    <a class="rhopagination" href="javascript:getPrsnPyHstrys('previous', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="rhopagination" href="javascript:getPrsnPyHstrys('next', '#prsnPyHstrysList', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-responsive" id="prsnPyHstrysTable" cellspacing="0" width="100%" style="width:100%;min-width: 600px !important;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Batch Name/Number</th>
                                    <th>Description</th>
                                    <th>Person Set</th>
                                    <th>Item Set</th>
                                    <th>Has Been Run?</th>
                                    <th>Sent to GL?</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cntr = 0;
                                while ($row2 = loc_db_fetch_array($result2)) {
                                    $cntr += 1;
                                    ?>
                                    <tr id="prsnPyHstrysRow_<?php echo $cntr; ?>">                                    
                                        <td class="lovtd"><span><?php echo ($curIdx * $lmtSze) + ($cntr); ?></span></td>
                                        <td class="lovtd">                                                                   
                                            <span><?php echo $row2[2]; ?></span>
                                            <input type="hidden" class="form-control" aria-label="..." id="prsnPyHstrysRow<?php echo $cntr; ?>_MsPyID" value="<?php echo $row2[1]; ?>" style="width:100% !important;">
                                            <input type="hidden" class="form-control" aria-label="..." id="prsnPyHstrysRow<?php echo $cntr; ?>_PyReqID" value="<?php echo $row2[0]; ?>">                                                         
                                        </td>                                                
                                        <td class="lovtd">
                                            <span><?php echo $row2[3]; ?></span>                                                       
                                        </td>                                               
                                        <td class="lovtd">
                                            <span><?php echo $row2[10]; ?></span>                                                       
                                        </td>                                               
                                        <td class="lovtd">
                                            <span><?php echo $row2[11]; ?></span>                                                       
                                        </td>
                                        <td class="lovtd">
                                            <?php
                                            $isChkd = "";
                                            if ($row2[12] == "1") {
                                                $isChkd = "checked=\"true\"";
                                            }
                                            ?>                                                                    
                                            <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                <div class="form-check" style="font-size: 12px !important;">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" id="prsnPyHstrysRow<?php echo $cntr; ?>_BeenRun" name="prsnPyHstrysRow<?php echo $cntr; ?>_BeenRun" <?php echo $isChkd ?> disabled="true">
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="lovtd">
                                            <?php
                                            $isChkd = "";
                                            if ($row2[13] == "1") {
                                                $isChkd = "checked=\"true\"";
                                            }
                                            ?>                                                                    
                                            <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                <div class="form-check" style="font-size: 12px !important;">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" id="prsnPyHstrysRow<?php echo $cntr; ?>_ToGL" name="prsnPyHstrysRow<?php echo $cntr; ?>_ToGL" <?php echo $isChkd ?> disabled="true">
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="lovtd">
                                            <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="getOnePrsnPyHstrysForm(<?php echo $row2[1]; ?>, <?php echo $row2[0]; ?>, 1, <?php echo $sbmtdPrsnSetMmbrID; ?>, '<?php echo $row2[2]; ?>');" data-toggle="tooltip" data-placement="bottom" title="View Details">
                                                <img src="cmn_images/kghostview.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
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
                <?php
            } else if ($vwtyp == 3) {
                //prsnPyItmsAsgndPage                
                $canAddPrsItm = test_prmssns($dfltPrvldgs[31], $mdlNm);
                $canEdtPrsItm = test_prmssns($dfltPrvldgs[32], $mdlNm);
                $canDelPrsItm = test_prmssns($dfltPrvldgs[33], $mdlNm);
                $sbmtdPrsnSetMmbrID = isset($_POST['sbmtdPrsnSetMmbrID']) ? $_POST['sbmtdPrsnSetMmbrID'] : -1;
                $curIdx = 0;
                $pkID = $sbmtdPrsnSetMmbrID;
                if ($pkID > 0) {
                    $total = getAllBnftsPrsTtl($srchFor, $pkID);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    } else if ($pageNo < 1) {
                        $pageNo = ceil($total / $lmtSze);
                    }

                    $curIdx = $pageNo - 1;
                    $result1 = getAllBnftsPrs($srchFor, $curIdx, $lmtSze, $pkID);
                    $colClassType1 = "col-lg-2";
                    $colClassType2 = "col-lg-3";
                    $colClassType3 = "col-lg-4";
                    ?>
                    <form id='prsnItmsForm' action='' method='post' accept-charset='UTF-8'> 
                        <div class="row" style="padding-top:10px;">
                            <?php
                            if ($canEdtPrsItm === true) {
                                $nwRowHtml = "<tr id=\"prsnItmsRow__WWW123WWW\">"
                                        . "<td class=\"lovtd\"><span class=\"normaltd\">New</span></td>"
                                        . "<td class=\"lovtd\">
                                              <div class=\"form-group form-group-sm\" style=\"width:100% !important;\">
                                                            <div class=\"input-group\"  style=\"width:100%;\">
                                                                <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsnItmsRow_WWW123WWW_PrsItmNm\" value=\"\">
                                                                <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsnItmsRow_WWW123WWW_PrsItmID\" value=\"-1\">
                                                                <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Pay Items', '', '', '', 'radio', true, '', 'prsnItmsRow_WWW123WWW_PrsItmID', 'prsnItmsRow_WWW123WWW_PrsItmNm', 'clear', 0, '');\">
                                                                    <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                </label>
                                                            </div>
                                              </div>
                                          </td>
                                          <td class=\"lovtd\">
                                              <div class=\"form-group form-group-sm\" style=\"width:100% !important;\">
                                                            <div class=\"input-group\"  style=\"width:100%;\">
                                                                <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsnItmsRow_WWW123WWW_PrsItmValNm\" value=\"\">   
                                                                <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsnItmsRow_WWW123WWW_PrsItmValID\" value=\"-1\">
                                                                <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Pay Item Values', 'prsnItmsRow_WWW123WWW_PrsItmID', '', '', 'radio', true, '', 'prsnItmsRow_WWW123WWW_PrsItmValID', 'prsnItmsRow_WWW123WWW_PrsItmValNm', 'clear', 0, '');\">
                                                                    <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                </label>
                                                            </div>
                                              </div>
                                          </td>
                                          <td class=\"lovtd\">&nbsp;</td>
                                           <td class=\"lovtd\"><div class=\"form-group form-group-sm col-md-12\" style=\"padding:1px 1px 0px 1px !important;\">
                                                                <div class=\"input-group date form_date\" data-date=\"\" data-date-format=\"dd-M-yyyy\" data-link-field=\"dtp_input2\" data-link-format=\"yyyy-mm-dd\" style=\"width:100%\">
                                                                    <input class=\"form-control\" size=\"16\" type=\"text\" id=\"prsnItmsRow_WWW123WWW_StrtDte\" name=\"prsnItmsRow_WWW123WWW_StrtDte\" value=\"\" readonly=\"\">
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-remove\"></span></span>
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
                                                                </div>                                                                
                                                            </div></td>"
                                        . "<td class=\"lovtd\"><div class=\"form-group form-group-sm col-md-12\" style=\"padding:1px 1px 0px 1px !important;\">
                                                                <div class=\"input-group date form_date\" data-date=\"\" data-date-format=\"dd-M-yyyy\" data-link-field=\"dtp_input2\" data-link-format=\"yyyy-mm-dd\" style=\"width:100%\">
                                                                    <input class=\"form-control\" size=\"16\" type=\"text\" id=\"prsnItmsRow_WWW123WWW_EndDte\" name=\"prsnItmsRow_WWW123WWW_EndDte\" value=\"\" readonly=\"\">
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-remove\"></span></span>
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
                                                                </div>                                                                
                                                            </div>
                                                            </td>";
                                if ($canDelPrsItm === true) {
                                    $nwRowHtml .= "<td class=\"lovtd\">
                                                        <button type=\"button\" class=\"btn btn-default\" style=\"margin: 0px !important;padding:0px 3px 2px 4px !important;\" onclick=\"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Delete Person Item\">
                                                            <img src=\"cmn_images/no.png\" style=\"height:15px; width:auto; position: relative; vertical-align: middle;\">
                                                        </button>
                                                    </td>";
                                }
                                $nwRowHtml .= "</tr>";
                                $nwRowHtml = urlencode($nwRowHtml);
                                ?> 
                                <div class="<?php echo $colClassType3; ?>" style="padding:0px 1px 0px 15px !important;">     
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('prsnItmsTable', 0, '<?php echo $nwRowHtml; ?>');" data-toggle="tooltip" data-placement="bottom" title="New Pay Item">
                                        <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                    </button>
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="savePrsnItmsForm();" data-toggle="tooltip" data-placement="bottom" title="Save Pay Items">
                                        <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                    </button>     
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('prsnItmsTable', 0, '<?php echo $nwRowHtml; ?>');" data-toggle="tooltip" data-placement="bottom" title="Bulk Assignments">
                                        <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">Bulk Assignments
                                    </button>
                                </div>
                                <?php
                            } else {
                                $colClassType1 = "col-lg-4";
                                $colClassType2 = "col-lg-4";
                                $colClassType3 = "col-lg-4";
                            }
                            ?>
                            <div class="<?php echo $colClassType3; ?>" style="padding:0px 10px 0px 10px !important;">
                                <div class="input-group">
                                    <input class="form-control" id="prsnItmsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncPrsnItms(event, '', '#prsnPyItmsAsgndPage', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                    <input id="prsnItmsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsnItms('clear', '#prsnPyItmsAsgndPage', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </label>
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllPrsnItms('', '#prsnPyItmsAsgndPage', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>" style="padding:0px 10px 0px 10px !important;">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="prsnItmsDsplySze" style="min-width:70px !important;">                            
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
                            <div class="<?php echo $colClassType1; ?>" style="padding:0px 10px 0px 10px !important;">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="margin: 0px !important;">
                                        <li>
                                            <a class="rhopagination" href="javascript:getAllPrsnItms('previous', '#prsnPyItmsAsgndPage', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="rhopagination" href="javascript:getAllPrsnItms('next', '#prsnPyItmsAsgndPage', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdPrsnSetMmbrID=<?php echo $sbmtdPrsnSetMmbrID; ?>');" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="row"> 
                            <div  class="col-md-12" style="padding:0px 10px 0px 10px !important;">
                                <table class="table table-striped table-bordered table-responsive" id="prsnItmsTable" cellspacing="0" width="100%" style="width:100%;min-width: 600px !important;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item Code / Name</th>
                                            <th>Value Code / Name</th>
                                            <th style="text-align: right;">Latest Balance</th>
                                            <th>Valid From</th>
                                            <th>Valid Till</th>
                                            <?php
                                            if ($canDelPrsItm === true) {
                                                ?>
                                                <th>&nbsp;</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cntr = 0;
                                        $dateStr = getFrmtdDB_Date_time();
                                        while ($row1 = loc_db_fetch_array($result1)) {
                                            $cntr += 1;
                                            $itmName = $row1[7];
                                            $itmValName = $row1[8];
                                            $ltstBalance = "-";
                                            if ($row1[5] == "Balance Item") {
                                                $itmName = strtoupper($itmName);
                                                $itmValName = strtoupper($itmValName);
                                                $ltstBalance = number_format(getBlsItmLtstDailyBalsPrs($row1[0], $sbmtdPrsnSetMmbrID, substr($dateStr, 0, 11), $orgID), 2, '.', ',');
                                            }
                                            ?>
                                            <tr id="prsnItmsRow_<?php echo $cntr; ?>">                                    
                                                <td class="lovtd"><span class="normaltd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></span></td>
                                                <td class="lovtd">
                                                    <span><?php echo $itmName; ?></span>
                                                    <input type="hidden" class="form-control" aria-label="..." id="prsnItmsRow<?php echo $cntr; ?>_PrsItmID" value="<?php echo $row1[0]; ?>">   
                                                    <input type="hidden" class="form-control" aria-label="..." id="prsnItmsRow<?php echo $cntr; ?>_PrsItmValID" value="<?php echo $row1[1]; ?>">                                                       
                                                </td>   
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <div class="input-group"  style="width:100%;">
                                                                <input type="text" class="form-control" aria-label="..." id="prsnItmsRow<?php echo $cntr; ?>_PrsItmValNm" value="<?php echo $row1[8]; ?>">
                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Pay Item Values', 'prsnItmsRow<?php echo $cntr; ?>_PrsItmID', '', '', 'radio', true, '<?php echo $row1[1]; ?>', 'prsnItmsRow<?php echo $cntr; ?>_PrsItmValID', 'prsnItmsRow<?php echo $cntr; ?>_PrsItmValNm', 'clear', 0, '');">
                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[8]; ?></span>
                                                    <?php } ?>   
                                                </td>
                                                <td class="lovtd" style="text-align: right;">
                                                    <span><?php echo $ltstBalance; ?></span>                                                          
                                                </td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:1px 1px 0px 1px !important;">
                                                            <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%;">
                                                                <input class="form-control" size="16" type="text" id="prsnItmsRow<?php echo $cntr; ?>_StrtDte" name="prsnItmsRow<?php echo $cntr; ?>_StrtDte" value="<?php echo $row1[2]; ?>" readonly="">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>                                                                
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[2]; ?></span>
                                                    <?php } ?>                                                         
                                                </td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:1px 1px 0px 1px !important;">
                                                            <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%;">
                                                                <input class="form-control" size="16" type="text" id="prsnItmsRow<?php echo $cntr; ?>_EndDte" name="prsnItmsRow<?php echo $cntr; ?>_EndDte" value="<?php echo $row1[3]; ?>" readonly="">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>                                                                
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[3]; ?></span>
                                                    <?php } ?>                                                         
                                                </td>
                                                <?php
                                                if ($canDelPrsItm === true) {
                                                    ?>
                                                    <td class="lovtd">
                                                        <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="" data-toggle="tooltip" data-placement="bottom" title="Delete Person Item">
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
                    </form>
                    <?php
                }
            } else if ($vwtyp == 4) {
//              //prsnBankAcntsPage                               
                $canAddPrsItm = test_prmssns($dfltPrvldgs[31], $mdlNm);
                $canEdtPrsItm = test_prmssns($dfltPrvldgs[32], $mdlNm);
                $canDelPrsItm = test_prmssns($dfltPrvldgs[33], $mdlNm);
                $sbmtdPrsnSetMmbrID = isset($_POST['sbmtdPrsnSetMmbrID']) ? $_POST['sbmtdPrsnSetMmbrID'] : -1;
                $curIdx = 0;
                $pkID = $sbmtdPrsnSetMmbrID;
                if ($pkID > 0) {
                    $result1 = getAllAccounts($pkID);
                    $colClassType3 = "col-lg-6";
                    ?>
                    <form id='prsnBanksForm' action='' method='post' accept-charset='UTF-8'> 
                        <div class="row" style="padding-top:10px;">
                            <?php
                            if ($canEdtPrsItm === true) {
                                $nwRowHtml = "<tr id=\"prsnBanksRow__WWW123WWW\">"
                                        . "<td class=\"lovtd\"><span class=\"normaltd\">New</span></td>"
                                        . "<td class=\"lovtd\">
                                              <div class=\"form-group form-group-sm\" style=\"width:100% !important;\">
                                                            <div class=\"input-group\"  style=\"width:100%;\">
                                                                <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsnBanksRow_WWW123WWW_PrsItmNm\" value=\"\">
                                                                <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsnBanksRow_WWW123WWW_PrsItmID\" value=\"-1\">
                                                                <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Pay Items', '', '', '', 'radio', true, '', 'prsnBanksRow_WWW123WWW_PrsItmID', 'prsnBanksRow_WWW123WWW_PrsItmNm', 'clear', 0, '');\">
                                                                    <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                </label>
                                                            </div>
                                              </div>
                                          </td>
                                          <td class=\"lovtd\">
                                              <div class=\"form-group form-group-sm\" style=\"width:100% !important;\">
                                                            <div class=\"input-group\"  style=\"width:100%;\">
                                                                <input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"prsnBanksRow_WWW123WWW_PrsItmValNm\" value=\"\">   
                                                                <input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"prsnBanksRow_WWW123WWW_PrsItmValID\" value=\"-1\">
                                                                <label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Pay Item Values', 'prsnBanksRow_WWW123WWW_PrsItmID', '', '', 'radio', true, '', 'prsnBanksRow_WWW123WWW_PrsItmValID', 'prsnBanksRow_WWW123WWW_PrsItmValNm', 'clear', 0, '');\">
                                                                    <span class=\"glyphicon glyphicon-th-list\"></span>
                                                                </label>
                                                            </div>
                                              </div>
                                          </td>
                                          <td class=\"lovtd\">&nbsp;</td>
                                           <td class=\"lovtd\"><div class=\"form-group form-group-sm col-md-12\" style=\"padding:1px 1px 0px 1px !important;\">
                                                                <div class=\"input-group date form_date\" data-date=\"\" data-date-format=\"dd-M-yyyy\" data-link-field=\"dtp_input2\" data-link-format=\"yyyy-mm-dd\" style=\"width:100%\">
                                                                    <input class=\"form-control\" size=\"16\" type=\"text\" id=\"prsnBanksRow_WWW123WWW_StrtDte\" name=\"prsnBanksRow_WWW123WWW_StrtDte\" value=\"\" readonly=\"\">
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-remove\"></span></span>
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
                                                                </div>                                                                
                                                            </div></td>"
                                        . "<td class=\"lovtd\"><div class=\"form-group form-group-sm col-md-12\" style=\"padding:1px 1px 0px 1px !important;\">
                                                                <div class=\"input-group date form_date\" data-date=\"\" data-date-format=\"dd-M-yyyy\" data-link-field=\"dtp_input2\" data-link-format=\"yyyy-mm-dd\" style=\"width:100%\">
                                                                    <input class=\"form-control\" size=\"16\" type=\"text\" id=\"prsnBanksRow_WWW123WWW_EndDte\" name=\"prsnBanksRow_WWW123WWW_EndDte\" value=\"\" readonly=\"\">
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-remove\"></span></span>
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
                                                                </div>                                                                
                                                            </div>
                                                            </td>";
                                if ($canDelPrsItm === true) {
                                    $nwRowHtml .= "<td class=\"lovtd\">
                                                        <button type=\"button\" class=\"btn btn-default\" style=\"margin: 0px !important;padding:0px 3px 2px 4px !important;\" onclick=\"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Delete Account\">
                                                            <img src=\"cmn_images/no.png\" style=\"height:15px; width:auto; position: relative; vertical-align: middle;\">
                                                        </button>
                                                    </td>";
                                }
                                $nwRowHtml .= "</tr>";
                                $nwRowHtml = urlencode($nwRowHtml);
                                ?> 
                                <div class="<?php echo $colClassType3; ?>" style="padding:0px 1px 0px 15px !important;">     
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('prsnBanksTable', 0, '<?php echo $nwRowHtml; ?>');" data-toggle="tooltip" data-placement="bottom" title="New Personal Account">
                                        <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> New Bank Account 
                                    </button>
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="savePrsnItmsForm();" data-toggle="tooltip" data-placement="bottom" title="Save Personal Accounts">
                                        <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Save Accounts 
                                    </button>
                                </div>
                                <?php
                            } else {
                                $colClassType3 = "col-lg-6";
                            }
                            ?>
                        </div>
                        <div class="row"> 
                            <div  class="col-md-12" style="padding:0px 10px 0px 10px !important;">
                                <table class="table table-striped table-bordered table-responsive" id="prsnBanksTable" cellspacing="0" width="100%" style="width:100%;min-width: 600px !important;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Bank Name</th>
                                            <th>Bank Branch</th>
                                            <th>Account Name</th>
                                            <th>Account Number</th>
                                            <th>Account Type</th>
                                            <th style="text-align: right;">Net Pay Portion to Transfer</th>
                                            <th>Portion's UOM</th>
                                            <?php
                                            if ($canDelPrsItm === true) {
                                                ?>
                                                <th>&nbsp;</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cntr = 0;
                                        $dateStr = getFrmtdDB_Date_time();
                                        while ($row1 = loc_db_fetch_array($result1)) {
                                            $cntr += 1;
                                            ?>
                                            <tr id="prsnBanksRow_<?php echo $cntr; ?>">                                    
                                                <td class="lovtd"><span class="normaltd"><?php echo ($cntr); ?></span></td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <div class="input-group"  style="width:100%;">
                                                                <input type="text" class="form-control" aria-label="..." id="prsnBanksRow<?php echo $cntr; ?>_BankNm" value="<?php echo $row1[0]; ?>">
                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Banks', '', '', '', 'radio', true, '<?php echo $row1[0]; ?>', 'prsnBanksRow<?php echo $cntr; ?>_BankNm', '', 'clear', 0, '');">
                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[0]; ?></span>
                                                    <?php } ?> 
                                                </td>   
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <div class="input-group"  style="width:100%;">
                                                                <input type="text" class="form-control" aria-label="..." id="prsnBanksRow<?php echo $cntr; ?>_BankBrnchs" value="<?php echo $row1[1]; ?>">
                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Bank Branches', '', '', '', 'radio', true, '<?php echo $row1[1]; ?>', 'prsnBanksRow<?php echo $cntr; ?>_BankBrnchs', '', 'clear', 0, '');">
                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[1]; ?></span>
                                                    <?php } ?>   
                                                </td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <input type="text" class="form-control" aria-label="..." id="prsnBanksRow<?php echo $cntr; ?>_AcntNm" value="<?php echo $row1[2]; ?>">
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[2]; ?></span>
                                                    <?php } ?>                                                           
                                                </td>                                                
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <input type="text" class="form-control" aria-label="..." id="prsnBanksRow<?php echo $cntr; ?>_AcntNum" value="<?php echo $row1[3]; ?>">
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[3]; ?></span>
                                                    <?php } ?>                                                           
                                                </td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <div class="input-group"  style="width:100%;">
                                                                <input type="text" class="form-control" aria-label="..." id="prsnBanksRow<?php echo $cntr; ?>_AcntTyp" value="<?php echo $row1[4]; ?>">
                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Bank Account Types', '', '', '', 'radio', true, '<?php echo $row1[4]; ?>', 'prsnBanksRow<?php echo $cntr; ?>_AcntTyp', '', 'clear', 0, '');">
                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[4]; ?></span>
                                                    <?php } ?>                                                           
                                                </td>                                                
                                                <td class="lovtd" style="text-align: right;">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <input type="number" class="form-control" aria-label="..." id="prsnBanksRow<?php echo $cntr; ?>_NetPrtn" value="<?php echo $row1[5]; ?>">
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[5]; ?></span>
                                                    <?php } ?>                                                           
                                                </td>                                                
                                                <td class="lovtd">
                                                    <?php if ($canEdtPrsItm === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">                                                            
                                                            <select data-placeholder="Select..." class="form-control chosen-select" id="prsnBanksRow<?php echo $cntr; ?>_PrtnUOM" name="prsnBanksRow<?php echo $cntr; ?>_PrtnUOM">
                                                                <?php
                                                                $valslctdArry = array("", "");
                                                                $srchInsArrys = array("Percent", "Money");
                                                                for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                                    if ($row1[6] == $srchInsArrys[$z]) {
                                                                        $valslctdArry[$z] = "selected";
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span><?php echo $row1[6]; ?></span>
                                                    <?php } ?>                                                           
                                                </td>
                                                <?php
                                                if ($canDelPrsItm === true) {
                                                    ?> 
                                                    <td class="lovtd">
                                                        <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="" data-toggle="tooltip" data-placement="bottom" title="Delete Account">
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
                    </form>
                    <?php
                }
            } else if ($vwtyp == 5) {
                
            }
        }
    }
}    