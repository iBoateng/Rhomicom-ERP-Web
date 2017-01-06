<?php
$pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
$lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
$sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";
$curIdx = 0;
$orgID = $_SESSION['ORG_ID'];
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
                $fnlColorAmntDffrnc = 0;
                $pkID = isset($_POST['sbmtdMspyID']) ? $_POST['sbmtdMspyID'] : -1;
                $sbmtdMspyID = -1;
                $sbmtdPyReqID = -1;
                echo $cntent . "<li>
                                    <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                    <span style=\"text-decoration:none;\">Bills & Pay Slips</span>
				</li>
                               </ul>
                              </div>";
                $total = get_MyPyRnsTtl($srchFor, $srchIn, $prsnid);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result = get_MyPyRnsTblr($srchFor, $srchIn, $curIdx, $lmtSze, $prsnid);
                $cntr = 0;
                $colClassType1 = "col-lg-2";
                $colClassType2 = "col-lg-3";
                $colClassType3 = "col-lg-4";
                ?>
                <form id='myPayRnsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row rhoRowMargin">                        
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 1px 0px 1px !important;"> 
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getOneMyRcvblInvcForm(-1, 2);" style="width:100% !important;">
                                    <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    New Payment
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="saveMyPayRnyForm();" style="width:100% !important;">
                                    <img src="cmn_images/FloppyDisk.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    Save
                                </button>
                            </div>
                        </div>
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="myPayRnsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncMyPayRns(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="myPayRnsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getMyPayRns('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getMyPayRns('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType3; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="myPayRnsSrchIn">
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
                                <select data-placeholder="Select..." class="form-control chosen-select" id="myPayRnsDsplySze" style="min-width:70px !important;">                            
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
                                        <a class="rhopagination" href="javascript:getMyPayRns('previous', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="rhopagination" href="javascript:getMyPayRns('next', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row"  style="padding:1px 15px 1px 15px !important;"><hr style="margin:1px 0px 3px 0px;"></div>
                    <div class="row" style="padding:0px 15px 0px 15px !important"> 
                        <div  class="col-md-3" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs">                                        
                                <table class="table table-striped table-bordered table-responsive" id="myPayRnsTable" cellspacing="0" width="100%" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Batch Name / Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = loc_db_fetch_array($result)) {
                                            if ($pkID <= 0 && $cntr <= 0) {
                                                $pkID = $row[1];
                                                $sbmtdMspyID = $pkID;
                                                $sbmtdPyReqID = $row[0];
                                            }
                                            $cntr += 1;
                                            ?>
                                            <tr id="myPayRnsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <td><?php echo $row[2]; ?>
                                                    <input type="hidden" class="form-control" aria-label="..." id="myPayRnsRow<?php echo $cntr; ?>_PyReqID" value="<?php echo $row[0]; ?>">
                                                    <input type="hidden" class="form-control" aria-label="..." id="myPayRnsRow<?php echo $cntr; ?>_MspyID" value="<?php echo $row[1]; ?>">
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
                                <div class="container-fluid" id="myPayRnsDetailInfo">
                                    <?php
                                    $result1 = get_MyPyHdrDet($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        ?>
                                        <div class="row">
                                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnNm" class="control-label col-lg-4">Batch Name:</label>
                                                        <div  class="col-lg-8">
                                                            <span><?php echo $row1[2]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnDesc" class="control-label col-lg-4">Batch Description:</label>
                                                        <div  class="col-lg-8">
                                                            <span><?php echo $row1[3]; ?></span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnDate" class="control-label col-lg-5">Date:</label>
                                                        <div  class="col-lg-7">
                                                            <span><?php echo $row1[6]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnDesc" class="control-label col-lg-5">Batch Status:</label>
                                                        <div  class="col-lg-7">
                                                            <span><?php echo $row1[5]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnNetAmnt" class="control-label col-lg-5" style="color:blue;">Net Amount (GHS):</label>
                                                        <div  class="col-lg-7">
                                                            <span id="myPyRnTotal1"><?php echo "0.00"; ?></span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                <fieldset class="basic_person_fs">                                       
                                                    <table class="table table-striped table-bordered table-responsive" id="myPayRnLinesTable" cellspacing="0" width="100%" style="width:100%;min-width: 700px;">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Item Name</th>
                                                                <th style="text-align: right;">Amount (GHS)</th>
                                                                <th>Effective Date</th>
                                                                <th>Line Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $result2 = null;
                                                            if ($sbmtdMspyID <= 0 && $sbmtdPyReqID <= 0) {
                                                                $result2 = get_CumltiveBals($prsnid);
                                                            } else {
                                                                $result2 = get_MyPyRnsDt($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                                            }
                                                            $cntr = 0;
                                                            $curIdx = 0;
                                                            $brghtTotal = 0;
                                                            $prpsdTtlSpnColor = "black";
                                                            $itmTypCnt = getBatchItmTypCnt($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                                            while ($row2 = loc_db_fetch_array($result2)) {
                                                                $cntr += 1;
                                                                ?>
                                                                <tr id="myPayRnLinesRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                                    <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                                    <td class="lovtd"><?php echo $row2[6]; ?></td>
                                                                    <td class="lovtd" style="text-align: right;"><?php echo getBatchNetAmnt($itmTypCnt, $row2[11], $row2[6], $row2[10], $row2[7], $brghtTotal, $prpsdTtlSpnColor); ?></td>
                                                                    <td class="lovtd"><span><?php echo $row2[8]; ?></span></td>
                                                                    <td class="lovtd"><span><?php echo $row2[9]; ?></span></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>                                                            
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th style="text-align: right;">Net Amount (GHS):</th>
                                                                <th style="text-align: right;"><?php echo "<span style=\"color:$prpsdTtlSpnColor;\">" . number_format($brghtTotal, 2, '.', ',') . "</span>"; ?></th>
                                                                <th>&nbsp;</th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            $("#myPyRnTotal1").html('<?php echo "<span style=\"color:$prpsdTtlSpnColor;font-weight:bold;font-size:12px;\">" . number_format($brghtTotal, 2, '.', ',') . "</span>"; ?>');
                                                        });
                                                    </script>
                                                </fieldset>
                                            </div>
                                        </div>
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
                $curIdx = 0;
                $fnlColorAmntDffrnc = 0;
                $sbmtdMspyID = isset($_POST['sbmtdMspyID']) ? $_POST['sbmtdMspyID'] : -1;
                $sbmtdPyReqID = isset($_POST['sbmtdPyReqID']) ? $_POST['sbmtdPyReqID'] : -1;
                ?>
                <?php
                $result1 = get_MyPyHdrDet($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                while ($row1 = loc_db_fetch_array($result1)) {
                    ?>
                    <div class="row">
                        <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="myPayRnNm" class="control-label col-lg-4">Batch Name:</label>
                                    <div  class="col-lg-8">
                                        <span><?php echo $row1[2]; ?></span>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="myPayRnDesc" class="control-label col-lg-4">Batch Description:</label>
                                    <div  class="col-lg-8">
                                        <span><?php echo $row1[3]; ?></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="myPayRnDate" class="control-label col-lg-5">Date:</label>
                                    <div  class="col-lg-7">
                                        <span><?php echo $row1[6]; ?></span>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="myPayRnDesc" class="control-label col-lg-5">Batch Status:</label>
                                    <div  class="col-lg-7">
                                        <span><?php echo $row1[5]; ?></span>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="myPayRnNetAmnt" class="control-label col-lg-5" style="color:blue;">Net Amount (GHS):</label>
                                    <div  class="col-lg-7">
                                        <span id="myPyRnTotal1"><?php echo "0.00"; ?></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                            <fieldset class="basic_person_fs">                                       
                                <table class="table table-striped table-bordered table-responsive" id="myPayRnLinesTable" cellspacing="0" width="100%" style="width:100%;min-width: 700px;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item Name</th>
                                            <th style="text-align: right;">Amount (GHS)</th>
                                            <th>Effective Date</th>
                                            <th>Line Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result2 = null;
                                        if ($sbmtdMspyID <= 0 && $sbmtdPyReqID <= 0) {
                                            $result2 = get_CumltiveBals($prsnid);
                                        } else {
                                            $result2 = get_MyPyRnsDt($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                        }
                                        $cntr = 0;
                                        $brghtTotal = 0;
                                        $prpsdTtlSpnColor = "black";
                                        $itmTypCnt = getBatchItmTypCnt($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                        while ($row2 = loc_db_fetch_array($result2)) {
                                            $cntr += 1;
                                            ?>
                                            <tr id="myPayRnLinesRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <td class="lovtd"><?php echo $row2[6]; ?></td>
                                                <td class="lovtd" style="text-align: right;"><?php echo getBatchNetAmnt($itmTypCnt, $row2[11], $row2[6], $row2[10], $row2[7], $brghtTotal, $prpsdTtlSpnColor); ?></td>
                                                <td class="lovtd"><span><?php echo $row2[8]; ?></span></td>
                                                <td class="lovtd"><span><?php echo $row2[9]; ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>                                                            
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th style="text-align: right;">Net Amount (GHS):</th>
                                            <th style="text-align: right;"><?php echo "<span style=\"color:$prpsdTtlSpnColor;\">" . number_format($brghtTotal, 2, '.', ',') . "</span>"; ?></th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div><input type="hidden" id="myPyRnTotal2" value="<?php echo urlencode("<span style=\"color:$prpsdTtlSpnColor;font-weight:bold;font-size:12px;\">" . number_format($brghtTotal, 2, '.', ',') . "</span>"); ?>"></div>                                
                            </fieldset>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
            } else if ($vwtyp == 2) {
                //My Receivable Invoices 
                $pkID = isset($_POST['sbmtdRcvblInvcID']) ? $_POST['sbmtdRcvblInvcID'] : -1;
                $sbmtdRcvblInvcID = -1;
                $sbmtdSalesInvcID = -1;
                echo $cntent . "<li>
                                    <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                    <span style=\"text-decoration:none;\">Customer Invoices</span>
				</li>
                               </ul>
                              </div>";
                $shwUnpstdOnly = FALSE;
                $total = get_RcvblsDocHdrTtl($srchFor, $srchIn, $orgID, $shwUnpstdOnly);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result = get_RcvblsDocHdr($srchFor, $srchIn, $curIdx, $lmtSze, $orgID, $shwUnpstdOnly);
                $cntr = 0;
                $colClassType1 = "col-lg-2";
                $colClassType2 = "col-lg-3";
                $colClassType3 = "col-lg-4";
                ?>
                <form id='myRcvblInvcsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row rhoRowMargin">                        
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 1px 0px 1px !important;"> 
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getOneMyPayRnyForm(-1, 2);" style="width:100% !important;">
                                    <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    New Payment
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="saveMyRcvblInvcForm();" style="width:100% !important;">
                                    <img src="cmn_images/FloppyDisk.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    Save
                                </button>
                            </div>
                        </div>
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="myPayRnsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncMyRcvblInvcs(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="myPayRnsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getMyRcvblInvcs('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getMyRcvblInvcs('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType3; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="myPayRnsSrchIn">
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
                                <select data-placeholder="Select..." class="form-control chosen-select" id="myPayRnsDsplySze" style="min-width:70px !important;">                            
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
                                        <a class="rhopagination" href="javascript:getMyRcvblInvcs('previous', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="rhopagination" href="javascript:getMyRcvblInvcs('next', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row"  style="padding:1px 15px 1px 15px !important;"><hr style="margin:1px 0px 3px 0px;"></div>
                    <div class="row" style="padding:0px 15px 0px 15px !important"> 
                        <div  class="col-md-3" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs">                                        
                                <table class="table table-striped table-bordered table-responsive" id="myPayRnsTable" cellspacing="0" width="100%" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Batch Name / Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = loc_db_fetch_array($result)) {
                                            if ($pkID <= 0 && $cntr <= 0) {
                                                $pkID = $row[1];
                                                $sbmtdMspyID = $pkID;
                                                $sbmtdPyReqID = $row[0];
                                            }
                                            $cntr += 1;
                                            ?>
                                            <tr id="myPayRnsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <td><?php echo $row[2]; ?>
                                                    <input type="hidden" class="form-control" aria-label="..." id="myPayRnsRow<?php echo $cntr; ?>_PyReqID" value="<?php echo $row[0]; ?>">
                                                    <input type="hidden" class="form-control" aria-label="..." id="myPayRnsRow<?php echo $cntr; ?>_MspyID" value="<?php echo $row[1]; ?>">
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
                                <div class="container-fluid" id="myPayRnsDetailInfo">
                                    <?php
                                    $result1 = get_MyPyHdrDet($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        ?>
                                        <div class="row">
                                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnNm" class="control-label col-lg-4">Batch Name:</label>
                                                        <div  class="col-lg-8">
                                                            <span><?php echo $row1[2]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnDesc" class="control-label col-lg-4">Batch Description:</label>
                                                        <div  class="col-lg-8">
                                                            <span><?php echo $row1[3]; ?></span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnDate" class="control-label col-lg-5">Date:</label>
                                                        <div  class="col-lg-7">
                                                            <span><?php echo $row1[6]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnDesc" class="control-label col-lg-5">Batch Status:</label>
                                                        <div  class="col-lg-7">
                                                            <span><?php echo $row1[5]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                        <label for="myPayRnNetAmnt" class="control-label col-lg-5" style="color:blue;">Net Amount (GHS):</label>
                                                        <div  class="col-lg-7">
                                                            <span id="myPyRnTotal1"><?php echo "0.00"; ?></span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                <fieldset class="basic_person_fs">                                       
                                                    <table class="table table-striped table-bordered table-responsive" id="myPayRnLinesTable" cellspacing="0" width="100%" style="width:100%;min-width: 700px;">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Item Name</th>
                                                                <th style="text-align: right;">Amount (GHS)</th>
                                                                <th>Effective Date</th>
                                                                <th>Line Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $result2 = null;
                                                            if ($sbmtdMspyID <= 0 && $sbmtdPyReqID <= 0) {
                                                                $result2 = get_CumltiveBals($prsnid);
                                                            } else {
                                                                $result2 = get_MyPyRnsDt($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                                            }
                                                            $cntr = 0;
                                                            $curIdx = 0;
                                                            $brghtTotal = 0;
                                                            $prpsdTtlSpnColor = "black";
                                                            $itmTypCnt = getBatchItmTypCnt($sbmtdPyReqID, $sbmtdMspyID, $prsnid);
                                                            while ($row2 = loc_db_fetch_array($result2)) {
                                                                $cntr += 1;
                                                                ?>
                                                                <tr id="myPayRnLinesRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                                    <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                                    <td class="lovtd"><?php echo $row2[6]; ?></td>
                                                                    <td class="lovtd" style="text-align: right;"><?php echo getBatchNetAmnt($itmTypCnt, $row2[11], $row2[6], $row2[10], $row2[7], $brghtTotal, $prpsdTtlSpnColor); ?></td>
                                                                    <td class="lovtd"><span><?php echo $row2[8]; ?></span></td>
                                                                    <td class="lovtd"><span><?php echo $row2[9]; ?></span></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>                                                            
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th style="text-align: right;">Net Amount (GHS):</th>
                                                                <th style="text-align: right;"><?php echo "<span style=\"color:$prpsdTtlSpnColor;\">" . number_format($brghtTotal, 2, '.', ',') . "</span>"; ?></th>
                                                                <th>&nbsp;</th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            $("#myPyRnTotal1").html('<?php echo "<span style=\"color:$prpsdTtlSpnColor;font-weight:bold;font-size:12px;\">" . number_format($brghtTotal, 2, '.', ',') . "</span>"; ?>');
                                                        });
                                                    </script>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
                <?php            
            } else if ($vwtyp == 3) {
                //My Receivable Invoices Detail
            } else if ($vwtyp == 4) {
                //My Payable Invoices
            } else if ($vwtyp == 5) {
                //My Payable Invoices Detail
            } else if ($vwtyp == 6) {
                
            }
        }
    }
}    