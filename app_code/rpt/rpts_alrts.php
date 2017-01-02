<?php
$canRunRpts = test_prmssns($dfltPrvldgs[8], $mdlNm);
$canDelRptRuns = test_prmssns($dfltPrvldgs[9], $mdlNm);
$canVwOthrsRuns = test_prmssns($dfltPrvldgs[10], $mdlNm);

$pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
$lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
$sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";

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
            if ($vwtyp == 0) {
                $pkID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">Reports Menu</span>
					</li>
                                        <li>
                                    <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                    <span style=\"text-decoration:none;\">Run Report/Process</span>
				</li>
                               </ul>
                              </div>";
                $total = get_RptsTtl($srchFor, $srchIn);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result = get_RptsTblr($srchFor, $srchIn, $curIdx, $lmtSze);
                $cntr = 0;
                $colClassType3 = "col-lg-4";
                $colClassType1 = "col-lg-3";
                $colClassType2 = "col-lg-5";
                ?>
                <form id='allRptsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row" style="margin-bottom:5px;">
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="allRptsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncAllRpts(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="allRptsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllRpts('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllRpts('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType3; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allRptsSrchIn">
                                    <?php
                                    $valslctdArry = array("", "", "");
                                    $srchInsArrys = array("Report Name", "Report Description", "Owner Module");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allRptsDsplySze" style="min-width:70px !important;">                            
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
                                        <a href="javascript:getAllRpts('previous', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:getAllRpts('next', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row"  style="padding:1px 15px 1px 15px !important;"><hr style="margin:1px 0px 3px 0px;"></div>
                    <div class="row" style="padding:0px 15px 0px 15px !important"> 
                        <div  class="col-lg-3" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs">                                        
                                <table class="table table-striped table-bordered table-responsive" id="allRptsTable" cellspacing="0" width="100%" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Report/Process Name</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = loc_db_fetch_array($result)) {
                                            if ($pkID <= 0 && $cntr <= 0) {
                                                $pkID = $row[0];
                                            }
                                            $cntr += 1;
                                            ?>
                                            <tr id="allRptsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <td class="lovtd"><?php echo $row[1]; ?><input type="hidden" class="form-control" aria-label="..." id="allRptsRow<?php echo $cntr; ?>_RptID" value="<?php echo $row[0]; ?>"></td>
                                                <td class="lovtd">
                                                    <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="getOneRptsParamsForm(<?php echo $row[0]; ?>, -1, '<?php echo $row[1]; ?>', 2);" data-toggle="tooltip" data-placement="bottom" title="Run Report/Process">
                                                        <img src="cmn_images/98.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>                        
                            </fieldset>
                        </div>                        
                        <div  class="col-lg-9" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                <div class="container-fluid" id="rptsDetailInfo">
                                    <?php
                                    if ($pkID > 0) {
                                        $sbmtdRptID = $pkID;
                                        $result1 = get_RptsDet($pkID);
                                        while ($row1 = loc_db_fetch_array($result1)) {
                                            ?>
                                            <div class="row">
                                                <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="rptsRptNm" class="control-label col-lg-4">Report Name:</label>
                                                            <div  class="col-lg-8">
                                                                <span><?php echo $row1[1]; ?></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="rptsRptDesc" class="control-label col-lg-4">Description:</label>
                                                            <div  class="col-lg-8">
                                                                <span><?php echo $row1[2]; ?></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <?php
                                                $pageNo = 1;
                                                $lmtSze = 10;
                                                $srchFor = "%";
                                                $srchIn = "Report Run ID";
                                                $colClassType1 = "col-lg-2";
                                                $colClassType2 = "col-lg-3";
                                                $colClassType3 = "col-lg-5";
                                                ?>
                                                <div class="<?php echo $colClassType1; ?>" style="padding:0px 3px 0px 3px !important;">     
                                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getOneRptsParamsForm(<?php echo $row1[0]; ?>, -1, '<?php echo $row1[1]; ?>', 2);" data-toggle="tooltip" data-placement="bottom" title="Run Selected Report/Process">
                                                        <img src="cmn_images/98.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getAllSchdls('', '', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=5');" data-toggle="tooltip" data-placement="bottom" title="Schedule Selected Report/Process">
                                                        <img src="cmn_images/Calander.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                </div>
                                                <div class="<?php echo $colClassType2; ?>" style="padding:0px 3px 0px 3px !important;">
                                                    <div class="input-group">
                                                        <input class="form-control" id="rptRunsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncRptRuns(event, '', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=1&sbmtdRptID=<?php echo $sbmtdRptID; ?>');">
                                                        <input id="rptRunsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getAllRptRuns('clear', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=1&sbmtdRptID=<?php echo $sbmtdRptID; ?>');">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </label>
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getAllRptRuns('', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=1&sbmtdRptID=<?php echo $sbmtdRptID; ?>');">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </label> 
                                                    </div>
                                                </div>
                                                <div class="<?php echo $colClassType3; ?>" style="padding:0px 3px 0px 3px !important;">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                                        <select data-placeholder="Select..." class="form-control chosen-select" id="rptRunsSrchIn">
                                                            <?php
                                                            $valslctdArry = array("", "", "", "");
                                                            $srchInsArrys = array("Report Run ID", "Run By", "Run Date", "Run Status");

                                                            for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                                if ($srchIn == $srchInsArrys[$z]) {
                                                                    $valslctdArry[$z] = "selected";
                                                                }
                                                                ?>
                                                                <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                                        <select data-placeholder="Select..." class="form-control chosen-select" id="rptRunsDsplySze" style="min-width:70px !important;">                            
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
                                                <div class="<?php echo $colClassType1; ?>" style="padding:0px 3px 0px 3px !important;">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination" style="margin: 0px !important;">
                                                            <li>
                                                                <a href="javascript:getAllRptRuns('previous', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=1&sbmtdRptID=<?php echo $sbmtdRptID; ?>');" aria-label="Previous">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:getAllRptRuns('next', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=1&sbmtdRptID=<?php echo $sbmtdRptID; ?>');" aria-label="Next">
                                                                    <span aria-hidden="true">&raquo;</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class="basic_person_fs">                                       
                                                        <table class="table table-striped table-bordered table-responsive" id="rptRunsTable" cellspacing="0" width="100%" style="width:100%;min-width: 730px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Report Run ID</th>
                                                                    <th style="min-width:90px !important;">Run Status</th>
                                                                    <th style="min-width:160px !important;">Last Time Active</th>
                                                                    <th>Open Output File</th>
                                                                    <th>Log Files</th>
                                                                    <th>Run By</th>
                                                                    <!--<th>Progress (%)</th>
                                                                    <th>Date Run</th>
                                                                    <th>Output Used</th>-->
                                                                    <th>Run Source</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $total = get_RptRunsTtl($pkID, $srchFor, $srchIn);
                                                                if ($pageNo > ceil($total / $lmtSze)) {
                                                                    $pageNo = 1;
                                                                } else if ($pageNo < 1) {
                                                                    $pageNo = ceil($total / $lmtSze);
                                                                }

                                                                $curIdx = $pageNo - 1;
                                                                $result2 = get_RptRuns($pkID, $srchFor, $srchIn, $curIdx, $lmtSze);
                                                                $cntr = 0;
                                                                while ($row2 = loc_db_fetch_array($result2)) {
                                                                    $cntr += 1;

                                                                    //$chckd = FALSE; 
                                                                    $outptUsd = $row2[8];
                                                                    $rpt_src_encrpt = "";
                                                                    if ($outptUsd == "HTML" || $outptUsd == "COLUMN CHART" || $outptUsd == "SIMPLE COLUMN CHART" || $outptUsd == "BAR CHART" || $outptUsd == "PIE CHART" || $outptUsd == "LINE CHART") {
                                                                        $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/amcharts_2100/samples/$row2[0].html";
                                                                        $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                                        if (file_exists($rpt_src)) {
                                                                            //file exists!
                                                                        } else {
                                                                            //file does not exist.
                                                                            $rpt_src_encrpt = "None";
                                                                        }
                                                                    } else if ($outptUsd == "STANDARD") {
                                                                        $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].txt";
                                                                        $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                                        if (file_exists($rpt_src)) {
                                                                            //file exists!
                                                                        } else {
                                                                            //file does not exist.
                                                                            $rpt_src_encrpt = "None";
                                                                        }
                                                                    } else if ($outptUsd == "PDF") {
                                                                        $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].pdf";
                                                                        $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                                        if (file_exists($rpt_src)) {
                                                                            //file exists!
                                                                        } else {
                                                                            //file does not exist.
                                                                            $rpt_src_encrpt = "None";
                                                                        }
                                                                    } else if ($outptUsd == "MICROSOFT WORD") {
                                                                        $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].rtf";
                                                                        $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                                        if (file_exists($rpt_src)) {
                                                                            //file exists!
                                                                        } else {
                                                                            //file does not exist.
                                                                            $rpt_src_encrpt = "None";
                                                                        }
                                                                    } else if ($outptUsd == "MICROSOFT EXCEL") {
                                                                        $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].xls";
                                                                        $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                                        if (file_exists($rpt_src)) {
                                                                            //file exists!
                                                                        } else {
                                                                            //file does not exist.
                                                                            $rpt_src_encrpt = "None";
                                                                        }
                                                                    } else if ($outptUsd == "CHARACTER SEPARATED FILE (CSV)") {
                                                                        $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].csv";
                                                                        $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                                        if (file_exists($rpt_src)) {
                                                                            //file exists!
                                                                        } else {
                                                                            //file does not exist.
                                                                            $rpt_src_encrpt = "None";
                                                                        }
                                                                    } else {
                                                                        $rpt_src_encrpt = "None";
                                                                    }
                                                                    ?>
                                                                    <tr id="rptRunsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                                        <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                                        <td class="lovtd"><a href="javascript:getOneRptsRnStsForm(<?php echo $pkID; ?>, <?php echo $row2[0]; ?>, 3,'0');" style="color:blue;font-weight:bold;"><?php echo $row2[0]; ?></a></td>
                                                                        <td class="lovtd"><span <?php
                                                                            $style2 = "";
                                                                            if ($row2[4] == "Not Started!") {
                                                                                $style2 = "style=\"background-color: #E8D68C;padding:5px !important;\"";
                                                                            } else if ($row2[4] == "Preparing to Start...") {
                                                                                $style2 = "style=\"background-color: yellow;padding:5px !important;\"";
                                                                            } else if ($row2[4] == "Running SQL...") {
                                                                                $style2 = "style=\"background-color: lightgreen;padding:5px !important;\"";
                                                                            } else if ($row2[4] == "Formatting Output...") {
                                                                                $style2 = "style=\"background-color: lime;padding:5px !important;\"";
                                                                            } else if ($row2[4] == "Storing Output...") {
                                                                                $style2 = "style=\"background-color: cyan;padding:5px !important;\"";
                                                                            } else if ($row2[4] == "Completed!") {
                                                                                $style2 = "style=\"background-color: gainsboro;padding:5px !important;\"";
                                                                            } else if (strpos($row2[4], "Error") !== FALSE) {
                                                                                $style2 = "style=\"background-color: red;padding:5px !important;\"";
                                                                            }
                                                                            echo $style2;
                                                                            ?>><?php echo $row2[4]; ?></span></td>
                                                                        <td class="lovtd"><span <?php
                                                                            $tst = isDteTmeWthnIntrvl(cnvrtDMYTmToYMDTm($row2[10]), '40 second');
                                                                            $style2 = "";
                                                                            if ($tst == true) {
                                                                                $style2 = "style=\"background-color: limegreen;color: white; font-size:12px;padding:2px;\"";
                                                                            }
                                                                            echo $style2;
                                                                            ?>><?php echo $row2[10]; ?></span></td>
                                                                        <td class="lovtd">
                                                                            <?php
                                                                            if ($rpt_src_encrpt == "None") {
                                                                                ?>
                                                                                <span style="font-weight: bold;color:#FF0000;">
                                                                                    <?php
                                                                                    echo $rpt_src_encrpt;
                                                                                    ?>
                                                                                </span>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="doAjax('grp=1&typ=11&q=Download&fnm=<?php echo $rpt_src_encrpt; ?>', '', 'Redirect', '', '', '');" data-toggle="tooltip" data-placement="bottom" title="OPEN OUTPUT FILE">
                                                                                    <img src="cmn_images/dwldicon.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> View Output
                                                                                </button>
                                                                            <?php }
                                                                            ?>
                                                                        </td>
                                                                        <td class="lovtd">
                                                                            <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="getOneRptsLogForm(<?php echo $row2[0]; ?>);" data-toggle="tooltip" data-placement="bottom" title="VIEW PROCESS LOG FILE INFO">
                                                                                <img src="cmn_images/vwlog.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> View Log
                                                                            </button>
                                                                        </td>
                                                                        <td class="lovtd"><?php echo $row2[2]; ?></td>
                                                                        <!--<td><?php echo $row2[5]; ?></td>
                                                                        <td><span><?php echo $row2[3]; ?></span></td>
                                                                        <td><span><?php echo $row2[8]; ?></span></td>-->
                                                                        <td class="lovtd"><span><?php echo $row2[11]; ?></span></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </fieldset>
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
                $pkID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                if ($pkID > 0) {
                    $sbmtdRptID = $pkID;
                    $result1 = get_RptsDet($pkID);
                    while ($row1 = loc_db_fetch_array($result1)) {
                        ?>
                        <div class="row">
                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="rptsRptNm" class="control-label col-lg-4">Report Name:</label>
                                        <div  class="col-lg-8">
                                            <span><?php echo $row1[1]; ?></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="rptsRptDesc" class="control-label col-lg-4">Description:</label>
                                        <div  class="col-lg-8">
                                            <span><?php echo $row1[2]; ?></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            /* $pageNo = 1;
                              $lmtSze = 10;
                              $srchFor = "%";
                              $srchIn = "Report Run ID"; */
                            $colClassType1 = "col-lg-2";
                            $colClassType2 = "col-lg-3";
                            $colClassType3 = "col-lg-5";
                            ?>
                            <div class="<?php echo $colClassType1; ?>" style="padding:0px 3px 0px 3px !important;">     
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getOneRptsParamsForm(<?php echo $row1[0]; ?>, -1, '<?php echo $row1[1]; ?>', 2);" data-toggle="tooltip" data-placement="bottom" title="Run Selected Report/Process">
                                    <img src="cmn_images/98.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                </button>
                                <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getAllSchdls('', '', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=5');" data-toggle="tooltip" data-placement="bottom" title="Schedule Selected Report/Process">
                                    <img src="cmn_images/Calander.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                </button>
                            </div>
                            <div class="<?php echo $colClassType2; ?>" style="padding:0px 3px 0px 3px !important;">
                                <div class="input-group">
                                    <input class="form-control" id="rptRunsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncRptRuns(event, '', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdRptID=<?php echo $sbmtdRptID; ?>');">
                                    <input id="rptRunsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllRptRuns('clear', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdRptID=<?php echo $sbmtdRptID; ?>');">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </label>
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllRptRuns('', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdRptID=<?php echo $sbmtdRptID; ?>');">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType3; ?>" style="padding:0px 3px 0px 3px !important;">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="rptRunsSrchIn">
                                        <?php
                                        $valslctdArry = array("", "", "", "");
                                        $srchInsArrys = array("Report Run ID", "Run By", "Run Date", "Run Status");

                                        for ($z = 0; $z < count($srchInsArrys); $z++) {
                                            if ($srchIn == $srchInsArrys[$z]) {
                                                $valslctdArry[$z] = "selected";
                                            }
                                            ?>
                                            <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="rptRunsDsplySze" style="min-width:70px !important;">                            
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
                            <div class="<?php echo $colClassType1; ?>" style="padding:0px 3px 0px 3px !important;">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="margin: 0px !important;">
                                        <li>
                                            <a href="javascript:getAllRptRuns('previous', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdRptID=<?php echo $sbmtdRptID; ?>');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:getAllRptRuns('next', '#rptsDetailInfo', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>&sbmtdRptID=<?php echo $sbmtdRptID; ?>');" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                                <fieldset class="basic_person_fs">                                       
                                    <table class="table table-striped table-bordered table-responsive" id="rptRunsTable" cellspacing="0" width="100%" style="width:100%;min-width: 730px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Report Run ID</th>
                                                <th style="min-width:90px !important;">Run Status</th>
                                                <th style="min-width:160px !important;">Last Time Active</th>
                                                <th>Open Output File</th>
                                                <th>Log Files</th>
                                                <th>Run By</th>
                                                <!--<th>Progress (%)</th>
                                                <th>Date Run</th>
                                                <th>Output Used</th>-->
                                                <th>Run Source</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = get_RptRunsTtl($pkID, $srchFor, $srchIn);
                                            if ($pageNo > ceil($total / $lmtSze)) {
                                                $pageNo = 1;
                                            } else if ($pageNo < 1) {
                                                $pageNo = ceil($total / $lmtSze);
                                            }

                                            $curIdx = $pageNo - 1;
                                            $result2 = get_RptRuns($pkID, $srchFor, $srchIn, $curIdx, $lmtSze);
                                            $cntr = 0;
                                            while ($row2 = loc_db_fetch_array($result2)) {
                                                $cntr += 1;

                                                //$chckd = FALSE; 
                                                $outptUsd = $row2[8];
                                                $rpt_src_encrpt = "";
                                                if ($outptUsd == "HTML" || $outptUsd == "COLUMN CHART" || $outptUsd == "SIMPLE COLUMN CHART" || $outptUsd == "BAR CHART" || $outptUsd == "PIE CHART" || $outptUsd == "LINE CHART") {
                                                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/amcharts_2100/samples/$row2[0].html";
                                                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                    if (file_exists($rpt_src)) {
                                                        //file exists!
                                                    } else {
                                                        //file does not exist.
                                                        $rpt_src_encrpt = "None";
                                                    }
                                                } else if ($outptUsd == "STANDARD") {
                                                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].txt";
                                                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                    if (file_exists($rpt_src)) {
                                                        //file exists!
                                                    } else {
                                                        //file does not exist.
                                                        $rpt_src_encrpt = "None";
                                                    }
                                                } else if ($outptUsd == "PDF") {
                                                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].pdf";
                                                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                    if (file_exists($rpt_src)) {
                                                        //file exists!
                                                    } else {
                                                        //file does not exist.
                                                        $rpt_src_encrpt = "None";
                                                    }
                                                } else if ($outptUsd == "MICROSOFT WORD") {
                                                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].rtf";
                                                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                    if (file_exists($rpt_src)) {
                                                        //file exists!
                                                    } else {
                                                        //file does not exist.
                                                        $rpt_src_encrpt = "None";
                                                    }
                                                } else if ($outptUsd == "MICROSOFT EXCEL") {
                                                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].xls";
                                                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                    if (file_exists($rpt_src)) {
                                                        //file exists!
                                                    } else {
                                                        //file does not exist.
                                                        $rpt_src_encrpt = "None";
                                                    }
                                                } else if ($outptUsd == "CHARACTER SEPARATED FILE (CSV)") {
                                                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row2[0].csv";
                                                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                                    if (file_exists($rpt_src)) {
                                                        //file exists!
                                                    } else {
                                                        //file does not exist.
                                                        $rpt_src_encrpt = "None";
                                                    }
                                                } else {
                                                    $rpt_src_encrpt = "None";
                                                }
                                                ?>
                                                <tr id="rptRunsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                    <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                    <td class="lovtd"><a href="javascript:getOneRptsRnStsForm(<?php echo $pkID; ?>, <?php echo $row2[0]; ?>, 3,'0');" style="color:blue;font-weight:bold;"><?php echo $row2[0]; ?></a></td>
                                                    <td class="lovtd">
                                                        <span <?php
                                                        $style2 = "";
                                                        if ($row2[4] == "Not Started!") {
                                                            $style2 = "style=\"background-color: #E8D68C;padding:5px !important;\"";
                                                        } else if ($row2[4] == "Preparing to Start...") {
                                                            $style2 = "style=\"background-color: yellow;padding:5px !important;\"";
                                                        } else if ($row2[4] == "Running SQL...") {
                                                            $style2 = "style=\"background-color: lightgreen;padding:5px !important;\"";
                                                        } else if ($row2[4] == "Formatting Output...") {
                                                            $style2 = "style=\"background-color: lime;padding:5px !important;\"";
                                                        } else if ($row2[4] == "Storing Output...") {
                                                            $style2 = "style=\"background-color: cyan;padding:5px !important;\"";
                                                        } else if ($row2[4] == "Completed!") {
                                                            $style2 = "style=\"background-color: gainsboro;padding:5px !important;\"";
                                                        } else if (strpos($row2[4], "Error") !== FALSE) {
                                                            $style2 = "style=\"background-color: red;padding:5px !important;\"";
                                                        }
                                                        echo $style2;
                                                        ?>><?php echo $row2[4]; ?>
                                                        </span>
                                                    </td>
                                                    <td class="lovtd">
                                                        <span <?php
                                                        $tst = isDteTmeWthnIntrvl(cnvrtDMYTmToYMDTm($row2[10]), '40 second');
                                                        $style2 = "";
                                                        if ($tst == true) {
                                                            $style2 = "style=\"background-color: limegreen;color: white; font-size:12px;padding:2px;\"";
                                                        }
                                                        echo $style2;
                                                        ?>><?php echo $row2[10]; ?>
                                                        </span>
                                                    </td>
                                                    <td class="lovtd">
                                                        <?php
                                                        if ($rpt_src_encrpt == "None") {
                                                            ?>
                                                            <span style="font-weight: bold;color:#FF0000;">
                                                                <?php
                                                                echo $rpt_src_encrpt;
                                                                ?>
                                                            </span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="doAjax('grp=1&typ=11&q=Download&fnm=<?php echo $rpt_src_encrpt; ?>', '', 'Redirect', '', '', '');" data-toggle="tooltip" data-placement="bottom" title="OPEN OUTPUT FILE">
                                                                <img src="cmn_images/dwldicon.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> View Output
                                                            </button>
                                                        <?php }
                                                        ?>
                                                    </td>
                                                    <td class="lovtd">
                                                        <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="getOneRptsLogForm(<?php echo $row2[0]; ?>);" data-toggle="tooltip" data-placement="bottom" title="VIEW PROCESS LOG FILE INFO">
                                                            <img src="cmn_images/vwlog.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> View Log
                                                        </button>
                                                    </td>
                                                    <td class="lovtd"><?php echo $row2[2]; ?></td>
                                                    <!--<td><?php echo $row2[5]; ?></td>
                                                    <td><span><?php echo $row2[3]; ?></span></td>
                                                    <td><span><?php echo $row2[8]; ?></span></td>-->
                                                    <td class="lovtd"><span><?php echo $row2[11]; ?></span></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </fieldset>
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
                //Report Run Parameter Form
                $rptID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                $prvRunID = isset($_POST['sbmtdPrvRunID']) ? $_POST['sbmtdPrvRunID'] : -1;
                $pkID = $rptID;
                if ($canRunRpts === true) {
                    
                } else {
                    exit();
                }

                $reportName = getGnrlRecNm("rpt.rpt_reports", "report_id", "report_name", $pkID);
                $rptOutPut = getGnrlRecNm("rpt.rpt_reports", "report_id", "output_type", $pkID);
                $rptOrntn = getGnrlRecNm("rpt.rpt_reports", "report_id", "portrait_lndscp", $pkID);
                $result = get_AllParams($pkID);
                $sysParaIDs = array("-130", "-140", "-150", "-160", "-170", "-180", "-190", "-200");
                $sysParaNames = array("Report Title:", "Cols Nos To Group or Width & Height (Px) for Charts:",
                    "Cols Nos To Count or Use in Charts:", "Columns To Sum:", "Columns To Average:",
                    "Columns To Format Numerically:", "Report Output Formats", "Report Orientations");

                $paramIDs = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "rpt_rn_param_ids", $prvRunID);
                $paramVals = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "rpt_rn_param_vals", $prvRunID);
                $prvRunNm = "";
                if ($prvRunID > 0) {
                    $prvRunNm = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "(run_status_txt || '-' || run_by || '-' || run_date)", $prvRunID);
                }
                $arry1 = explode("|", $paramIDs);
                $arry2 = explode("|", $paramVals);
                $cntr = 0;
                $curIdx = 0;
                ?>
                <form id='rptParamsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                            <label for="rptParamPrvRun" class="control-label col-md-3">Copy Previous Values:</label>
                            <div  class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="..." id="rptParamPrvRun" name="rptParamPrvRun" value="<?php echo $prvRunNm ?>" readonly="true">
                                    <input type="hidden" class="form-control" aria-label="..." id="rptParamPrvRunID" name="rptParamPrvRunID" value="<?php echo $prvRunID; ?>">
                                    <input type="hidden" class="form-control" aria-label="..." id="rptParamRptID" name="rptParamRptID" value="<?php echo $pkID; ?>">
                                    <input type="hidden" class="form-control" aria-label="..." id="rptParamRptName" name="rptParamRptName" value="<?php echo $reportName; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Report/Process Runs', 'rptParamRptID', '', '', 'radio', true, '<?php echo $prvRunID; ?>', 'rptParamPrvRunID', 'rptParamPrvRun', 'clear', 0, '',function(){reloadParams();});">
                                        <span class="glyphicon glyphicon-th-list"></span>
                                    </label>
                                </div>
                            </div>
                            <div  class="col-md-4">
                                <div class="row" style="float:right;">
                                    <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="getOneRptsRnStsForm(<?php echo $pkID; ?>, -1, 3, '0');" data-toggle="tooltip" data-placement="bottom" title="Submit Report/Process">
                                        <img src="cmn_images/98.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Submit Report/Process
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                                                             
                        <table class="table table-striped table-bordered table-responsive" id="rptParamsTable" cellspacing="0" width="100%" style="width:100%;min-width: 330px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Parameter Name</th>
                                    <th style="min-width:180px !important;">Parameter Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = loc_db_fetch_array($result)) {
                                    $cntr += 1;
                                    $isrqrd = "";
                                    if ($row[4] == "1") {
                                        $isrqrd = "rqrdFld";
                                    }
                                    $nwval1 = $row[3];
                                    if ($prvRunID > 0) {
                                        $h1 = findArryIdx($arry1, $row[0]);
                                        if ($h1 >= 0) {
                                            $nwval1 = $arry2[$h1];
                                        }
                                    }
                                    $lovnm = $row[6];
                                    $dataTyp = $row[7];
                                    $dtFrmt = $row[8];
                                    ?>
                                    <tr id="rptParamsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                        <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                        <td class="lovtd"><?php echo $row[1]; ?><input type="hidden" class="form-control" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $row[0]; ?>"></td>
                                        <td class="lovtd">
                                            <?php if ($lovnm !== "") { ?>
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group"  style="width:100%;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'rptParamsRow<?php echo $cntr; ?>_ParamVal', 'rptParamsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            } else if ($dataTyp == "DATE") {
                                                $dtFrmtCls = "form_date_tme";
                                                if ($dtFrmt == "yyyy-MM-dd") {
                                                    $dtFrmt = "yyyy-mm-dd";
                                                    $dtFrmt1 = "yyyy-mm-dd";
                                                    $dtFrmtCls = "form_date1";
                                                } else if ($dtFrmt == "yyyy-MM-dd HH:mm:ss") {
                                                    $dtFrmt = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmtCls = "form_date_tme1";
                                                } else if ($dtFrmt == "dd-MMM-yyyy HH:mm:ss") {
                                                    $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                    $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmtCls = "form_date_tme";
                                                } else if ($dtFrmt == "dd-MMM-yyyy") {
                                                    $dtFrmt = "dd-M-yyyy";
                                                    $dtFrmt1 = "yyyy-mm-dd";
                                                    $dtFrmtCls = "form_date";
                                                } else {
                                                    $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                }
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group date <?php echo $dtFrmtCls; ?>" data-date="" data-date-format="<?php echo $dtFrmt; ?>" data-link-field="dtp_input2" data-link-format="<?php echo $dtFrmt1; ?>" style="width:100%;">
                                                        <input class="form-control <?php echo $isrqrd ?>" size="16" type="text" id="rptParamsRow<?php echo $cntr; ?>_ParamVal" name="rptParamsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" readonly="">
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                    </div>                                                                
                                                </div>
                                                <?php
                                            } else if ($dataTyp == "NUMBER") {
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <input type="number" min="-999999999999" max="999999999999" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamVal" name="rptParamsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100%;">
                                                </div>
                                                <?php
                                            } else {
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100% !important;">
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                $result1 = get_Rpt_ColsToAct($pkID);
                                $colNoVals = array("", "", "", "", "", "", "", "");
                                $colsCnt = loc_db_num_fields($result1);
                                while ($row1 = loc_db_fetch_array($result1)) {
                                    for ($d = 0; $d < $colsCnt; $d++) {
                                        if ($prvRunID > 0) {
                                            $h1 = findArryIdx($arry1, $sysParaIDs[$d]);
                                            if ($h1 >= 0) {
                                                $colNoVals[$d] = $arry2[$h1];
                                            } else {
                                                $colNoVals[$d] = $row1[$d];
                                            }
                                        } else {
                                            $colNoVals[$d] = $row1[$d];
                                        }
                                    }
                                }
                                for ($d = 0; $d < count($colNoVals); $d++) {
                                    $cntr ++;
                                    $isrqrd = "";
                                    ?>
                                    <tr id="rptParamsRow_<?php echo $cntr; ?>" class="hand_cursor">
                                        <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                        <td class="lovtd"><?php echo $sysParaNames[$d]; ?><input type="hidden" class="form-control" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $sysParaIDs[$d]; ?>"></td>
                                        <td class="lovtd">  
                                            <?php
                                            if ($sysParaIDs[$d] == "-190") {
                                                $lovnm = "Report Output Formats";
                                                ?>
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group"  style="width:100%;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'rptParamsRow<?php echo $cntr; ?>_ParamVal', 'rptParamsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            } else if ($sysParaIDs[$d] == "-200") {
                                                $lovnm = "Report Orientations";
                                                ?>
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group"  style="width:100%;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'rptParamsRow<?php echo $cntr; ?>_ParamVal', 'rptParamsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="rptParamsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>" style="width:100% !important;">
                                                </div>
                                            <?php }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row" style="float:right;">
                        <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="getOneRptsRnStsForm(<?php echo $pkID; ?>, -1, 3, '0');" data-toggle="tooltip" data-placement="bottom" title="Submit Report/Process">
                            <img src="cmn_images/98.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Submit Report/Process
                        </button>
                    </div>
                </form>
                <?php
            } else if ($vwtyp == 3) {
                //Report Run Progress Status Form                
                if ($canRunRpts === true) {
                    
                } else {
                    exit();
                }
                $rptID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                $prvRunID = isset($_POST['sbmtdRunID']) ? $_POST['sbmtdRunID'] : -1;
                $slctdParams = isset($_POST['slctdParams']) ? $_POST['slctdParams'] : "";
                $autoRfrsh = isset($_POST['autoRfrsh']) ? $_POST['autoRfrsh'] : "0";
                $mustReRun = isset($_POST['mustReRun']) ? $_POST['mustReRun'] : "0";
                $rptRunID = $prvRunID;
                if ($prvRunID <= 0) {
                    //Create Report Run and Launch
                    $prvRunID = generateReportRun($rptID, $slctdParams);
                } else if ($mustReRun == "1") {
                    $runStatus = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "run_status_txt", $prvRunID);
                    $runActvTme = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "last_actv_date_tme", $prvRunID);
                    if ($runStatus != 'Completed!' && $runStatus != 'Cancelled!' && $runStatus != 'Error!' && doesDteTmeExceedIntrvl($runActvTme, '30 second') == TRUE && $mustReRun == "1") {
                        reRunReport($rptID, $rptRunID);
                    }
                    //Launch Report Run is idle
                }
                $pkID = $rptID;
                $rptRunID = $prvRunID;
                $reportName = getGnrlRecNm("rpt.rpt_reports", "report_id", "report_name", $pkID);
                $rptOutPut = getGnrlRecNm("rpt.rpt_reports", "report_id", "output_type", $pkID);
                $rptOrntn = getGnrlRecNm("rpt.rpt_reports", "report_id", "portrait_lndscp", $pkID);
                $result = get_AllParams($pkID);
                $sysParaIDs = array("-130", "-140", "-150", "-160", "-170", "-180", "-190", "-200");
                $sysParaNames = array("Report Title:", "Cols Nos To Group or Width & Height (Px) for Charts:",
                    "Cols Nos To Count or Use in Charts:", "Columns To Sum:", "Columns To Average:",
                    "Columns To Format Numerically:", "Report Output Formats", "Report Orientations");

                $paramIDs = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "rpt_rn_param_ids", $prvRunID);
                $paramVals = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "rpt_rn_param_vals", $prvRunID);
                $prvRunNm = "";
                if ($prvRunID > 0) {
                    $prvRunNm = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "(run_status_txt || '-' || run_by || '-' || run_date)", $prvRunID);
                }
                $arry1 = explode("|", $paramIDs);
                $arry2 = explode("|", $paramVals);
                $cntr = 0;
                $curIdx = 0;
                $result1 = get_OneRptRun($prvRunID);
                while ($row1 = loc_db_fetch_array($result1)) {
                    $runStatus = $row1[4];
                    $runActvTme = $row1[14];
                    if ((integer) $row1[5] >= 100) {
                        $autoRfrsh = "0";
                    }
                    ?>
                    <form id='rptParamsStsForm' action='' method='post' accept-charset='UTF-8'>                    
                        <div class="row" style="margin-bottom:5px;">
                            <?php if ($autoRfrsh == "1") { ?>
                                <button type="button" class="btn btn-default" style="margin-bottom: 0px;margin-right:5px;" onclick="autoRfrshRptsRnSts(<?php echo $pkID; ?>, <?php echo $prvRunID ?>, 1);" data-toggle="tooltip" data-placement="bottom" title="Stop Auto-Refresh Report/Process Status">
                                    <img src="cmn_images/90.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Stop Auto-Refresh
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-default" style="margin-bottom: 0px;margin-right:5px;" onclick="autoRfrshRptsRnSts(<?php echo $pkID; ?>, <?php echo $prvRunID ?>, 0);" data-toggle="tooltip" data-placement="bottom" title="Auto-Refresh Report/Process Status">
                                    <img src="cmn_images/clock.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Auto-Refresh
                                </button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" style="margin-bottom: 0px;margin-right:5px;" onclick="getOneRptsRnStsForm(<?php echo $pkID; ?>, <?php echo $prvRunID ?>, 3, '0');" data-toggle="tooltip" data-placement="bottom" title="Refresh Report/Process Status">
                                <img src="cmn_images/refresh.bmp" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Refresh
                            </button>
                            <?php
                            if ($runStatus != 'Completed!' && $runStatus != 'Cancelled!' && $runStatus != 'Error!' && doesDteTmeExceedIntrvl($runActvTme, '30 second') == TRUE) {
                                ?>                            
                                <button type="button" class="btn btn-default" style="margin-bottom: 0px;margin-right:5px;" onclick="getOneRptsRnStsForm(<?php echo $pkID; ?>, <?php echo $prvRunID ?>, 3, '1');" data-toggle="tooltip" data-placement="bottom" title="Re-run Report/Process">
                                    <img src="cmn_images/reload.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> RE-RUN
                                </button>
                                <?php
                            } else if ($runStatus != 'Completed!' && $runStatus != 'Cancelled!' && $runStatus != 'Error!' && isDteTmeWthnIntrvl($runActvTme, '30 second') == TRUE) {
                                ?>                            
                                <button type="button" class="btn btn-default" style="margin-bottom: 0px;margin-right:5px;" onclick="cancelRptRun(<?php echo $pkID; ?>, <?php echo $prvRunID ?>);" data-toggle="tooltip" data-placement="bottom" title="Cancel Report/Process Run">
                                    <img src="cmn_images/90.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> CANCEL RUN
                                </button>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                <div  class="col-md-6" style="padding:0px !important;">
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsRunID" class="control-label col-lg-5">Run ID:</label>
                                        <div  class="col-lg-7">
                                            <span><?php echo $row1[0]; ?><input type="hidden" id="rptParamsStsRunID" name="rptParamsStsRunID" value="<?php echo $row1[0]; ?>"></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsDtRn" class="control-label col-lg-5">Date Run:</label>
                                        <div  class="col-lg-7">
                                            <span><?php echo $row1[3]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsPrgrs" class="control-label col-lg-5">Progress (%):</label>
                                        <div  class="col-lg-7">
                                            <span><?php echo $row1[5]; ?><input type="hidden" id="rptParamsStsPrgrs" name="rptParamsStsPrgrs" value="<?php echo $row1[5]; ?>"></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsOrntn" class="control-label col-lg-5">Orientation Used:</label>
                                        <div  class="col-lg-7">
                                            <span><?php echo $row1[9]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsRnSrc" class="control-label col-lg-5">Run Source:</label>
                                        <div  class="col-lg-7">
                                            <span><?php echo $row1[11]; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-md-6" style="padding:0px !important;">
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsRnBy" class="control-label col-lg-5">Run By:</label>
                                        <div  class="col-lg-7">
                                            <span><?php echo $row1[2]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsRun" class="control-label col-lg-5">Run Status Text:</label>
                                        <div  class="col-lg-7">
                                            <span <?php
                                            $style2 = "";
                                            if ($row1[4] == "Not Started!") {
                                                $style2 = "style=\"background-color: #E8D68C;padding:5px !important;\"";
                                            } else if ($row1[4] == "Preparing to Start...") {
                                                $style2 = "style=\"background-color: yellow;padding:5px !important;\"";
                                            } else if ($row1[4] == "Running SQL...") {
                                                $style2 = "style=\"background-color: lightgreen;padding:5px !important;\"";
                                            } else if ($row1[4] == "Formatting Output...") {
                                                $style2 = "style=\"background-color: lime;padding:5px !important;\"";
                                            } else if ($row1[4] == "Storing Output...") {
                                                $style2 = "style=\"background-color: cyan;padding:5px !important;\"";
                                            } else if ($row1[4] == "Completed!") {
                                                $style2 = "style=\"background-color: gainsboro;padding:5px !important;\"";
                                            } else if (strpos($row1[4], "Error") !== FALSE) {
                                                $style2 = "style=\"background-color: red;padding:5px !important;\"";
                                            }
                                            echo $style2;
                                            ?>><?php echo $row1[4]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsOutpt" class="control-label col-lg-5">Output Used:</label>
                                        <div  class="col-lg-7">
                                            <span><?php echo $row1[8]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <label for="rptParamsStsLstActv" class="control-label col-lg-5">Last Time Active:</label>
                                        <div  class="col-lg-7">
                                            <span <?php
                                            $tst = isDteTmeWthnIntrvl(cnvrtDMYTmToYMDTm($row1[10]), '40 second');
                                            $style2 = "";
                                            if ($tst == true) {
                                                $style2 = "style=\"background-color: limegreen;color: white; font-size:12px;padding:2px;\"";
                                            }
                                            echo $style2;
                                            ?>><?php echo $row1[10]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;margin-bottom:1px !important;">
                                        <?php
                                        $outptUsd = $row1[8];
                                        $rpt_src_encrpt = "";
                                        if ($outptUsd == "HTML" || $outptUsd == "COLUMN CHART" || $outptUsd == "SIMPLE COLUMN CHART" || $outptUsd == "BAR CHART" || $outptUsd == "PIE CHART" || $outptUsd == "LINE CHART") {
                                            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/amcharts_2100/samples/$row1[0].html";
                                            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                            if (file_exists($rpt_src)) {
                                                //file exists!
                                            } else {
                                                //file does not exist.
                                                $rpt_src_encrpt = "None";
                                            }
                                        } else if ($outptUsd == "STANDARD") {
                                            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row1[0].txt";
                                            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                            if (file_exists($rpt_src)) {
                                                //file exists!
                                            } else {
                                                //file does not exist.
                                                $rpt_src_encrpt = "None";
                                            }
                                        } else if ($outptUsd == "PDF") {
                                            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row1[0].pdf";
                                            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                            if (file_exists($rpt_src)) {
                                                //file exists!
                                            } else {
                                                //file does not exist.
                                                $rpt_src_encrpt = "None";
                                            }
                                        } else if ($outptUsd == "MICROSOFT WORD") {
                                            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row1[0].rtf";
                                            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                            if (file_exists($rpt_src)) {
                                                //file exists!
                                            } else {
                                                //file does not exist.
                                                $rpt_src_encrpt = "None";
                                            }
                                        } else if ($outptUsd == "MICROSOFT EXCEL") {
                                            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row1[0].xls";
                                            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                            if (file_exists($rpt_src)) {
                                                //file exists!
                                            } else {
                                                //file does not exist.
                                                $rpt_src_encrpt = "None";
                                            }
                                        } else if ($outptUsd == "CHARACTER SEPARATED FILE (CSV)") {
                                            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row1[0].csv";
                                            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                                            if (file_exists($rpt_src)) {
                                                //file exists!
                                            } else {
                                                //file does not exist.
                                                $rpt_src_encrpt = "None";
                                            }
                                        } else {
                                            $rpt_src_encrpt = "None";
                                        }
                                        ?>
                                        <label for="rptParamsStsRslts" class="control-label col-lg-4">Results:</label>
                                        <div  class="col-lg-4">
                                            <?php
                                            if ($rpt_src_encrpt == "None") {
                                                ?>
                                                <div class="row" style="padding:1px 10px 15px 47px;font-weight: bold;color:#FF0000;">
                                                    <?php
                                                    echo $rpt_src_encrpt;
                                                    ?>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="doAjax('grp=1&typ=11&q=Download&fnm=<?php echo $rpt_src_encrpt; ?>', '', 'Redirect', '', '', '');" data-toggle="tooltip" data-placement="bottom" title="OPEN OUTPUT FILE">
                                                    <img src="cmn_images/dwldicon.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> View Output
                                                </button>
                                            <?php }
                                            ?>
                                        </div>
                                        <div  class="col-lg-4">
                                            <button type="button" class="btn btn-default" style="margin-bottom: 0px;" onclick="getOneRptsLogForm(<?php echo $row1[0]; ?>);" data-toggle="tooltip" data-placement="bottom" title="VIEW PROCESS LOG FILE INFO">
                                                <img src="cmn_images/vwlog.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"> View Log
                                            </button>
                                        </div>
                                    </div>
                                </div>                                
                            </fieldset>
                        </div>
                        <div class="row">                                                             
                            <table class="table table-striped table-bordered table-responsive" id="rptParamsStsTable" cellspacing="0" width="100%" style="width:100%;min-width: 330px;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Parameter Name</th>
                                        <th style="min-width:180px !important;">Parameter Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = loc_db_fetch_array($result)) {
                                        $cntr += 1;
                                        $isrqrd = "";
                                        if ($row[4] == "1") {
                                            $isrqrd = "rqrdFld";
                                        }
                                        $nwval1 = $row[3];
                                        if ($prvRunID > 0) {
                                            $h1 = findArryIdx($arry1, $row[0]);
                                            if ($h1 >= 0) {
                                                $nwval1 = $arry2[$h1];
                                            }
                                        }
                                        $lovnm = $row[6];
                                        $dataTyp = $row[7];
                                        $dtFrmt = $row[8];
                                        ?>
                                        <tr id="rptParamsStsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                            <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                            <td class="lovtd"><?php echo $row[1]; ?></td>
                                            <td class="lovtd"><?php echo $nwval1; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    $result2 = get_Rpt_ColsToAct($pkID);
                                    $colNoVals = array("", "", "", "", "", "", "", "");
                                    $colsCnt = loc_db_num_fields($result2);
                                    while ($row2 = loc_db_fetch_array($result2)) {
                                        for ($d = 0; $d < $colsCnt; $d++) {
                                            if ($prvRunID > 0) {
                                                $h1 = findArryIdx($arry1, $sysParaIDs[$d]);
                                                if ($h1 >= 0) {
                                                    $colNoVals[$d] = $arry2[$h1];
                                                } else {
                                                    $colNoVals[$d] = $row2[$d];
                                                }
                                            } else {
                                                $colNoVals[$d] = $row2[$d];
                                            }
                                        }
                                    }
                                    for ($d = 0; $d < count($colNoVals); $d++) {
                                        $cntr ++;
                                        $isrqrd = "";
                                        ?>
                                        <tr id="rptParamsStsRow_<?php echo $cntr; ?>" class="hand_cursor">
                                            <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                            <td class="lovtd"><?php echo $sysParaNames[$d]; ?></td>
                                            <td class="lovtd"><?php echo $colNoVals[$d]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <?php
                }
            } else if ($vwtyp == 4) {
                //Cancel Report Run Progress  
                $rptID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                $rptRunID = isset($_POST['sbmtdRunID']) ? $_POST['sbmtdRunID'] : -1;
                if ($canRunRpts === true && $rptRunID > 0 && $rptID > 0) {
                    
                } else {
                    exit();
                }
                $rptRnnrNm = getGnrlRecNm("rpt.rpt_reports", "report_id", "process_runner", $rptID);
                $msg_id = getLogMsgID("rpt.rpt_run_msgs", "Process Run", $rptRunID);
                $datestr = getDB_Date_time();
                updateLogMsg($msg_id, "\r\n\r\nProgram Cancelled by User " . $usrName, "rpt.rpt_run_msgs", $datestr);
                updateRptRnStopCmd($rptRunID, "1");
                ?>
                <div class="container-fluid"  style="float:none;width:100%;text-align: center;padding:0px 0px 0px 25px !important;">
                    <div class="row" style="float:none;width:100%;text-align: center;">
                        <span style="color:green;font-weight:bold;font-size:16px;font-style: italic;font-family: Georgia;width:100%;text-align: center;">Cancellation Request Submitted Successfully!</span>
                    </div>
                    <div class="row" style="float:none;width:100%;text-align: center;">
                        <span style="color:green;font-weight:bold;font-size:12px;font-style: italic;font-family: Georgia;width:100%;text-align: center;">Keep refreshing till status changes!</span>
                    </div>
                    <div class="row" style="float:none;width:100%;text-align: center;">
                        <button type="button" class="btn btn-default" style="margin-bottom: 0px;width:100%;text-align: center;" onclick="rfrshCncldRptRun(<?php echo $rptID; ?>);" data-toggle="tooltip" data-placement="bottom" title="Refresh Report/Process Status">
                            <img src="cmn_images/refresh.bmp" style="height:20px; width:auto; position: relative; vertical-align: middle;"> Refresh Report Runs Table
                        </button>
                    </div>
                </div>
                <?php
            } else if ($vwtyp == 5) {
                //Scheduled Reports/Processes
                $pkID = isset($_POST['sbmtdSchdlID']) ? $_POST['sbmtdSchdlID'] : -1;
                $sbmtdRptID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                $total = get_ASchdlRunsTtl($srchFor, $srchIn);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result = get_ASchdlRuns($srchFor, $srchIn, $curIdx, $lmtSze);
                $cntr = 0;
                $colClassType3 = "col-lg-5";
                $colClassType1 = "col-lg-2";
                $colClassType2 = "col-lg-3";
                ?>
                <form id='allSchdlsForm' action='' method='post' accept-charset='UTF-8'>
                    <input type="hidden" id="nwRptSchdlRptID" name="nwRptSchdlRptID" value="-1">
                    <input type="hidden" id="nwRptSchdlRptNm" name="nwRptSchdlRptNm" value="">
                    <div class="row" style="margin-bottom:5px;">                        
                        <div class="<?php echo $colClassType1; ?>" style="padding:0px 3px 0px 3px !important;">     
                            <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Reports and Processes', '', '', '', 'radio', true, '', 'nwRptSchdlRptID', 'nwRptSchdlRptNm', 'clear', 0, '',function(){getOneSchdlsNwForm();});" data-toggle="tooltip" data-placement="bottom" title="Schedule a Selected Report/Process">
                                <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">New Schedule
                            </button>
                            <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="saveOneSchdlsForm();" data-toggle="tooltip" data-placement="bottom" title="Schedule Selected Report/Process">
                                <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                            </button>
                        </div>
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="allSchdlsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncAllSchdls(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="allSchdlsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllSchdls('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllSchdls('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType3; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allSchdlsSrchIn">
                                    <?php
                                    $valslctdArry = array("", "", "", "");
                                    $srchInsArrys = array("Report Name", "Start Date", "Repeat Interval", "Created By");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allSchdlsDsplySze" style="min-width:70px !important;">                            
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
                                        <a href="javascript:getAllSchdls('previous', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:getAllSchdls('next', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row"  style="padding:1px 15px 1px 15px !important;"><hr style="margin:1px 0px 3px 0px;"></div>
                    <div class="row" style="padding:0px 15px 0px 15px !important"> 
                        <div  class="col-lg-3" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs">                                        
                                <table class="table table-striped table-bordered table-responsive" id="allSchdlsTable" cellspacing="0" width="100%" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Scheduled By</th>
                                            <th>Report Name (Schedule ID)</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = loc_db_fetch_array($result)) {
                                            if ($pkID <= 0 && $cntr <= 0) {
                                                $pkID = $row[0];
                                                $sbmtdRptID = $row[1];
                                            }
                                            $cntr += 1;
                                            ?>
                                            <tr id="allSchdlsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <td class="lovtd"><?php echo $row[6]; ?>
                                                    <input type="hidden" class="form-control" aria-label="..." id="allSchdlsRow<?php echo $cntr; ?>_RptID" value="<?php echo $row[1]; ?>">
                                                    <input type="hidden" class="form-control" aria-label="..." id="allSchdlsRow<?php echo $cntr; ?>_SchdlID" value="<?php echo $row[0]; ?>">
                                                </td>
                                                <td class="lovtd"><?php echo $row[2] . " (" . $row[0] . ")"; ?>
                                                <td class="lovtd">
                                                    <button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" onclick="getOneRptsParamsForm(<?php echo $row[0]; ?>, -1, '<?php echo $row[1]; ?>', 2);" data-toggle="tooltip" data-placement="bottom" title="Run Report/Process">
                                                        <img src="cmn_images/no.png" style="height:15px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>                        
                            </fieldset>
                        </div>                        
                        <div  class="col-lg-9" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                <div class="container-fluid" id="allSchdlsDetailInfo">
                                    <?php
                                    if ($pkID > 0) {
                                        $sbmtdSchdlID = $pkID;
                                        $result1 = get_OneSchdlRun($pkID);
                                        while ($row1 = loc_db_fetch_array($result1)) {
                                            ?>
                                            <div class="row">
                                                <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="allSchdlsRptID" class="control-label col-lg-4">Schedule ID:</label>
                                                            <div  class="col-lg-8">
                                                                <span><?php echo $row1[0]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="allSchdlsRptNm" class="control-label col-lg-4">Report Name:</label>
                                                            <div  class="col-lg-8">
                                                                <span><?php echo $row1[2]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="allSchdlsStrtDte" class="control-label col-lg-4">Start Date:</label>
                                                            <div class="col-lg-8">
                                                                <div class="input-group date form_date_tme" data-date="" data-date-format="dd-M-yyyy hh:ii:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd hh:ii:ss" style="width:100%;">
                                                                    <input class="form-control rqrdFld" size="16" type="text" id="allSchdlsStrtDte" name="allSchdlsStrtDte" value="<?php echo $row1[3]; ?>" readonly="">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="allSchdlsIntrvl" class="control-label col-lg-9">Repeat Interval (After End of Prior Run):</label>
                                                            <div class="col-lg-3">
                                                                <input type="number" min="-999999999999" max="999999999999" class="form-control rqrdFld" aria-label="..." id="allSchdlsIntrvl" name="allSchdlsIntrvl" value="<?php echo $row1[4]; ?>" style="width:100%;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="allSchdlsIntvlUom" class="control-label col-lg-8">UOM:</label>
                                                            <div class="col-lg-4">
                                                                <select data-placeholder="Select..." class="form-control chosen-select" id="allSchdlsIntvlUom" name="allSchdlsIntvlUom">
                                                                    <?php
                                                                    $valslctdArry = array("", "", "", "", "", "", "");
                                                                    $srchInsArrys = array("Second(s)", "Minute(s)", "Hour(s)", "Day(s)", "Week(s)", "Month(s)", "Year(s)");
                                                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                                        if ($row1[5] == $srchInsArrys[$z]) {
                                                                            $valslctdArry[$z] = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>                                                        
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="allSchdlsRnAtHr" class="control-label col-lg-7">Run Only at Hour Specified?:</label>
                                                            <div  class="col-lg-5">
                                                                <?php
                                                                $chkdYes = "";
                                                                $chkdNo = "checked=\"\"";
                                                                if ($row1[6] == "1") {
                                                                    $chkdNo = "";
                                                                    $chkdYes = "checked=\"\"";
                                                                }
                                                                ?>
                                                                <label class="radio-inline"><input type="radio" name="allSchdlsRnAtHr" value="YES" <?php echo $chkdYes; ?>>YES</label>
                                                                <label class="radio-inline"><input type="radio" name="allSchdlsRnAtHr" value="NO" <?php echo $chkdNo; ?>>NO</label>                                                                
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">                                                             
                                                <table class="table table-striped table-bordered table-responsive" id="allSchdlPrmsTable" cellspacing="0" width="100%" style="width:100%;min-width: 330px;">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Parameter Name</th>
                                                            <th style="min-width:180px !important;">Parameter Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $rptID = $sbmtdRptID;
                                                        $pkID = $rptID;
                                                        if ($canRunRpts === true) {
                                                            
                                                        } else {
                                                            exit();
                                                        }

                                                        $reportName = getGnrlRecNm("rpt.rpt_reports", "report_id", "report_name", $pkID);
                                                        $rptOutPut = getGnrlRecNm("rpt.rpt_reports", "report_id", "output_type", $pkID);
                                                        $rptOrntn = getGnrlRecNm("rpt.rpt_reports", "report_id", "portrait_lndscp", $pkID);
                                                        $result = get_AllParams($pkID);
                                                        $sysParaIDs = array("-130", "-140", "-150", "-160", "-170", "-180", "-190", "-200");
                                                        $sysParaNames = array("Report Title:", "Cols Nos To Group or Width & Height (Px) for Charts:",
                                                            "Cols Nos To Count or Use in Charts:", "Columns To Sum:", "Columns To Average:",
                                                            "Columns To Format Numerically:", "Report Output Formats", "Report Orientations");

                                                        $cntr = 0;
                                                        $curIdx = 0;
                                                        while ($row = loc_db_fetch_array($result)) {
                                                            $cntr += 1;
                                                            $isrqrd = "";
                                                            if ($row[4] == "1") {
                                                                $isrqrd = "rqrdFld";
                                                            }
                                                            $nwval1 = $row[3];
                                                            if ($sbmtdSchdlID > 0) {
                                                                $nwval1 = get_SchdldParamVal($sbmtdSchdlID, $row[0]);
                                                            }
                                                            $lovnm = $row[6];
                                                            $dataTyp = $row[7];
                                                            $dtFrmt = $row[8];
                                                            ?>
                                                            <tr id="allSchdlPrmsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                                <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                                <td class="lovtd"><?php echo $row[1]; ?><input type="hidden" class="form-control" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $row[0]; ?>"></td>
                                                                <td class="lovtd">
                                                                    <?php if ($lovnm !== "") { ?>
                                                                        <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                            <div class="input-group"  style="width:100%;">
                                                                                <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>">
                                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    } else if ($dataTyp == "DATE") {
                                                                        $dtFrmtCls = "form_date_tme";
                                                                        if ($dtFrmt == "yyyy-MM-dd") {
                                                                            $dtFrmt = "yyyy-mm-dd";
                                                                            $dtFrmt1 = "yyyy-mm-dd";
                                                                            $dtFrmtCls = "form_date1";
                                                                        } else if ($dtFrmt == "yyyy-MM-dd HH:mm:ss") {
                                                                            $dtFrmt = "yyyy-mm-dd hh:ii:ss";
                                                                            $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                                            $dtFrmtCls = "form_date_tme1";
                                                                        } else if ($dtFrmt == "dd-MMM-yyyy HH:mm:ss") {
                                                                            $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                                            $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                                            $dtFrmtCls = "form_date_tme";
                                                                        } else if ($dtFrmt == "dd-MMM-yyyy") {
                                                                            $dtFrmt = "dd-M-yyyy";
                                                                            $dtFrmt1 = "yyyy-mm-dd";
                                                                            $dtFrmtCls = "form_date";
                                                                        } else {
                                                                            $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                                            $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                                        }
                                                                        ?>                                            
                                                                        <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                            <div class="input-group date <?php echo $dtFrmtCls; ?>" data-date="" data-date-format="<?php echo $dtFrmt; ?>" data-link-field="dtp_input2" data-link-format="<?php echo $dtFrmt1; ?>" style="width:100%;">
                                                                                <input class="form-control <?php echo $isrqrd ?>" size="16" type="text" id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" name="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" readonly="">
                                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                            </div>                                                                
                                                                        </div>
                                                                        <?php
                                                                    } else if ($dataTyp == "NUMBER") {
                                                                        ?>                                            
                                                                        <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                            <input type="number" min="-999999999999" max="999999999999" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" name="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100%;">
                                                                        </div>
                                                                        <?php
                                                                    } else {
                                                                        ?>                                            
                                                                        <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                            <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100% !important;">
                                                                        </div>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        $result1 = get_Rpt_ColsToAct($pkID);
                                                        $colNoVals = array("", "", "", "", "", "", "", "");
                                                        $colsCnt = loc_db_num_fields($result1);
                                                        while ($row1 = loc_db_fetch_array($result1)) {
                                                            for ($d = 0; $d < $colsCnt; $d++) {
                                                                if ($sbmtdSchdlID > 0) {
                                                                    $colNoVals[$d] = get_SchdldParamVal($sbmtdSchdlID, $sysParaIDs[$d]);
                                                                } else {
                                                                    $colNoVals[$d] = $row1[$d];
                                                                }
                                                            }
                                                        }
                                                        for ($d = 0; $d < count($colNoVals); $d++) {
                                                            $cntr ++;
                                                            $isrqrd = "";
                                                            ?>
                                                            <tr id="allSchdlPrmsRow_<?php echo $cntr; ?>" class="hand_cursor">
                                                                <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                                <td class="lovtd"><?php echo $sysParaNames[$d]; ?><input type="hidden" class="form-control" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $sysParaIDs[$d]; ?>"></td>
                                                                <td class="lovtd">  
                                                                    <?php
                                                                    if ($sysParaIDs[$d] == "-190") {
                                                                        $lovnm = "Report Output Formats";
                                                                        ?>
                                                                        <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                            <div class="input-group"  style="width:100%;">
                                                                                <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    } else if ($sysParaIDs[$d] == "-200") {
                                                                        $lovnm = "Report Orientations";
                                                                        ?>
                                                                        <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                            <div class="input-group"  style="width:100%;">
                                                                                <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    } else {
                                                                        ?>                                            
                                                                        <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                                            <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>" style="width:100% !important;">
                                                                        </div>
                                                                    <?php }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
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
            } else if ($vwtyp == 6) {
                //One Scheduled Report/Processe
                $pkID = isset($_POST['sbmtdSchdlID']) ? $_POST['sbmtdSchdlID'] : -1;
                $sbmtdRptID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                if ($pkID > 0) {
                    $sbmtdSchdlID = $pkID;
                    $result1 = get_OneSchdlRun($pkID);
                    while ($row1 = loc_db_fetch_array($result1)) {
                        ?>
                        <div class="row">
                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="allSchdlsRptID" class="control-label col-lg-4">Schedule ID:</label>
                                        <div  class="col-lg-8">
                                            <span><?php echo $row1[0]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="allSchdlsRptNm" class="control-label col-lg-4">Report Name:</label>
                                        <div  class="col-lg-8">
                                            <span><?php echo $row1[2]; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="allSchdlsStrtDte" class="control-label col-lg-4">Start Date:</label>
                                        <div class="col-lg-8">
                                            <div class="input-group date form_date_tme" data-date="" data-date-format="dd-M-yyyy hh:ii:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd hh:ii:ss" style="width:100%;">
                                                <input class="form-control rqrdFld" size="16" type="text" id="allSchdlsStrtDte" name="allSchdlsStrtDte" value="<?php echo $row1[3]; ?>" readonly="">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div> 
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="allSchdlsIntrvl" class="control-label col-lg-9">Repeat Interval (After End of Prior Run):</label>
                                        <div class="col-lg-3">
                                            <input type="number" min="-999999999999" max="999999999999" class="form-control rqrdFld" aria-label="..." id="allSchdlsIntrvl" name="allSchdlsIntrvl" value="<?php echo $row1[4]; ?>" style="width:100%;">
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="allSchdlsIntvlUom" class="control-label col-lg-8">UOM:</label>
                                        <div class="col-lg-4">
                                            <select data-placeholder="Select..." class="form-control chosen-select" id="allSchdlsIntvlUom" name="allSchdlsIntvlUom">
                                                <?php
                                                $valslctdArry = array("", "", "", "", "", "", "");
                                                $srchInsArrys = array("Second(s)", "Minute(s)", "Hour(s)", "Day(s)", "Week(s)", "Month(s)", "Year(s)");
                                                for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                    if ($row1[5] == $srchInsArrys[$z]) {
                                                        $valslctdArry[$z] = "selected";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>                                                        
                                    <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                        <label for="allSchdlsRnAtHr" class="control-label col-lg-7">Run Only at Hour Specified?:</label>
                                        <div  class="col-lg-5">
                                            <?php
                                            $chkdYes = "";
                                            $chkdNo = "checked=\"\"";
                                            if ($row1[6] == "1") {
                                                $chkdNo = "";
                                                $chkdYes = "checked=\"\"";
                                            }
                                            ?>
                                            <label class="radio-inline"><input type="radio" name="allSchdlsRnAtHr" value="YES" <?php echo $chkdYes; ?>>YES</label>
                                            <label class="radio-inline"><input type="radio" name="allSchdlsRnAtHr" value="NO" <?php echo $chkdNo; ?>>NO</label>                                                                
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">                                                             
                            <table class="table table-striped table-bordered table-responsive" id="allSchdlPrmsTable" cellspacing="0" width="100%" style="width:100%;min-width: 330px;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Parameter Name</th>
                                        <th style="min-width:180px !important;">Parameter Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rptID = $sbmtdRptID;
                                    $pkID = $rptID;
                                    if ($canRunRpts === true) {
                                        
                                    } else {
                                        exit();
                                    }

                                    $reportName = getGnrlRecNm("rpt.rpt_reports", "report_id", "report_name", $pkID);
                                    $rptOutPut = getGnrlRecNm("rpt.rpt_reports", "report_id", "output_type", $pkID);
                                    $rptOrntn = getGnrlRecNm("rpt.rpt_reports", "report_id", "portrait_lndscp", $pkID);
                                    $result = get_AllParams($pkID);
                                    $sysParaIDs = array("-130", "-140", "-150", "-160", "-170", "-180", "-190", "-200");
                                    $sysParaNames = array("Report Title:", "Cols Nos To Group or Width & Height (Px) for Charts:",
                                        "Cols Nos To Count or Use in Charts:", "Columns To Sum:", "Columns To Average:",
                                        "Columns To Format Numerically:", "Report Output Formats", "Report Orientations");

                                    $cntr = 0;
                                    $curIdx = 0;
                                    while ($row = loc_db_fetch_array($result)) {
                                        $cntr += 1;
                                        $isrqrd = "";
                                        if ($row[4] == "1") {
                                            $isrqrd = "rqrdFld";
                                        }
                                        $nwval1 = $row[3];
                                        if ($sbmtdSchdlID > 0) {
                                            $nwval1 = get_SchdldParamVal($sbmtdSchdlID, $row[0]);
                                        }
                                        $lovnm = $row[6];
                                        $dataTyp = $row[7];
                                        $dtFrmt = $row[8];
                                        ?>
                                        <tr id="allSchdlPrmsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                            <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                            <td class="lovtd"><?php echo $row[1]; ?><input type="hidden" class="form-control" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $row[0]; ?>"></td>
                                            <td class="lovtd">
                                                <?php if ($lovnm !== "") { ?>
                                                    <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                        <div class="input-group"  style="width:100%;">
                                                            <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>">
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else if ($dataTyp == "DATE") {
                                                    $dtFrmtCls = "form_date_tme";
                                                    if ($dtFrmt == "yyyy-MM-dd") {
                                                        $dtFrmt = "yyyy-mm-dd";
                                                        $dtFrmt1 = "yyyy-mm-dd";
                                                        $dtFrmtCls = "form_date1";
                                                    } else if ($dtFrmt == "yyyy-MM-dd HH:mm:ss") {
                                                        $dtFrmt = "yyyy-mm-dd hh:ii:ss";
                                                        $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                        $dtFrmtCls = "form_date_tme1";
                                                    } else if ($dtFrmt == "dd-MMM-yyyy HH:mm:ss") {
                                                        $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                        $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                        $dtFrmtCls = "form_date_tme";
                                                    } else if ($dtFrmt == "dd-MMM-yyyy") {
                                                        $dtFrmt = "dd-M-yyyy";
                                                        $dtFrmt1 = "yyyy-mm-dd";
                                                        $dtFrmtCls = "form_date";
                                                    } else {
                                                        $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                        $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                    }
                                                    ?>                                            
                                                    <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                        <div class="input-group date <?php echo $dtFrmtCls; ?>" data-date="" data-date-format="<?php echo $dtFrmt; ?>" data-link-field="dtp_input2" data-link-format="<?php echo $dtFrmt1; ?>" style="width:100%;">
                                                            <input class="form-control <?php echo $isrqrd ?>" size="16" type="text" id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" name="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" readonly="">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>                                                                
                                                    </div>
                                                    <?php
                                                } else if ($dataTyp == "NUMBER") {
                                                    ?>                                            
                                                    <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                        <input type="number" min="-999999999999" max="999999999999" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" name="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100%;">
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>                                            
                                                    <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100% !important;">
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $result1 = get_Rpt_ColsToAct($pkID);
                                    $colNoVals = array("", "", "", "", "", "", "", "");
                                    $colsCnt = loc_db_num_fields($result1);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        for ($d = 0; $d < $colsCnt; $d++) {
                                            if ($sbmtdSchdlID > 0) {
                                                $colNoVals[$d] = get_SchdldParamVal($sbmtdSchdlID, $sysParaIDs[$d]);
                                            } else {
                                                $colNoVals[$d] = $row1[$d];
                                            }
                                        }
                                    }
                                    for ($d = 0; $d < count($colNoVals); $d++) {
                                        $cntr ++;
                                        $isrqrd = "";
                                        ?>
                                        <tr id="allSchdlPrmsRow_<?php echo $cntr; ?>" class="hand_cursor">
                                            <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                            <td class="lovtd"><?php echo $sysParaNames[$d]; ?><input type="hidden" class="form-control" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $sysParaIDs[$d]; ?>"></td>
                                            <td class="lovtd">  
                                                <?php
                                                if ($sysParaIDs[$d] == "-190") {
                                                    $lovnm = "Report Output Formats";
                                                    ?>
                                                    <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                        <div class="input-group"  style="width:100%;">
                                                            <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else if ($sysParaIDs[$d] == "-200") {
                                                    $lovnm = "Report Orientations";
                                                    ?>
                                                    <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                        <div class="input-group"  style="width:100%;">
                                                            <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>                                            
                                                    <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>" style="width:100% !important;">
                                                    </div>
                                                <?php }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <?php
                    }
                } else {
                    ?>
                    <span>No Results Found</span>

                    <?php
                }
            } else if ($vwtyp == 7) {
                //New Scheduled Report/Processe Form
                $sbmtdRptID = isset($_POST['sbmtdRptID']) ? $_POST['sbmtdRptID'] : -1;
                $pkID = $sbmtdRptID;
                if ($pkID > 0) {
                    $sbmtdSchdlID = -1;

                    $rptID = $sbmtdRptID;
                    $pkID = $rptID;
                    if ($canRunRpts === true) {
                        
                    } else {
                        exit();
                    }

                    $reportName = getGnrlRecNm("rpt.rpt_reports", "report_id", "report_name", $pkID);
                    $rptOutPut = getGnrlRecNm("rpt.rpt_reports", "report_id", "output_type", $pkID);
                    $rptOrntn = getGnrlRecNm("rpt.rpt_reports", "report_id", "portrait_lndscp", $pkID);
                    $result = get_AllParams($pkID);
                    $sysParaIDs = array("-130", "-140", "-150", "-160", "-170", "-180", "-190", "-200");
                    $sysParaNames = array("Report Title:", "Cols Nos To Group or Width & Height (Px) for Charts:",
                        "Cols Nos To Count or Use in Charts:", "Columns To Sum:", "Columns To Average:",
                        "Columns To Format Numerically:", "Report Output Formats", "Report Orientations");

                    $cntr = 0;
                    $curIdx = 0;
                    ?>
                    <div class="row">
                        <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;"> 
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="allSchdlsRptID" class="control-label col-lg-4">Schedule ID:</label>
                                    <div  class="col-lg-8">
                                        <span>-1</span>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="allSchdlsRptNm" class="control-label col-lg-4">Report Name:</label>
                                    <div  class="col-lg-8">
                                        <span><?php echo $reportName; ?></span>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="allSchdlsStrtDte" class="control-label col-lg-4">Start Date:</label>
                                    <div class="col-lg-8">
                                        <div class="input-group date form_date_tme" data-date="" data-date-format="dd-M-yyyy hh:ii:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd hh:ii:ss" style="width:100%;">
                                            <input class="form-control rqrdFld" size="16" type="text" id="allSchdlsStrtDte" name="allSchdlsStrtDte" value="" readonly="">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div> 
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="allSchdlsIntrvl" class="control-label col-lg-9">Repeat Interval (After End of Prior Run):</label>
                                    <div class="col-lg-3">
                                        <input type="number" min="-999999999999" max="999999999999" class="form-control rqrdFld" aria-label="..." id="allSchdlsIntrvl" name="allSchdlsIntrvl" value="" style="width:100%;">
                                    </div>
                                </div>
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="allSchdlsIntvlUom" class="control-label col-lg-8">UOM:</label>
                                    <div class="col-lg-4">
                                        <select data-placeholder="Select..." class="form-control chosen-select" id="allSchdlsIntvlUom" name="allSchdlsIntvlUom">
                                            <?php
                                            $valslctdArry = array("", "", "", "", "", "", "");
                                            $srchInsArrys = array("Second(s)", "Minute(s)", "Hour(s)", "Day(s)", "Week(s)", "Month(s)", "Year(s)");
                                            for ($z = 0; $z < count($srchInsArrys); $z++) {
                                                ?>
                                                <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>                                                        
                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                    <label for="allSchdlsRnAtHr" class="control-label col-lg-7">Run Only at Hour Specified?:</label>
                                    <div  class="col-lg-5">
                                        <?php
                                        $chkdYes = "";
                                        $chkdNo = "checked=\"\"";
                                        ?>
                                        <label class="radio-inline"><input type="radio" name="allSchdlsRnAtHr" value="YES" <?php echo $chkdYes; ?>>YES</label>
                                        <label class="radio-inline"><input type="radio" name="allSchdlsRnAtHr" value="NO" <?php echo $chkdNo; ?>>NO</label>                                                                
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">                                                             
                        <table class="table table-striped table-bordered table-responsive" id="allSchdlPrmsTable" cellspacing="0" width="100%" style="width:100%;min-width: 330px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Parameter Name</th>
                                    <th style="min-width:180px !important;">Parameter Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = loc_db_fetch_array($result)) {
                                    $cntr += 1;
                                    $isrqrd = "";
                                    if ($row[4] == "1") {
                                        $isrqrd = "rqrdFld";
                                    }
                                    $nwval1 = $row[3];
                                    $lovnm = $row[6];
                                    $dataTyp = $row[7];
                                    $dtFrmt = $row[8];
                                    ?>
                                    <tr id="allSchdlPrmsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                        <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                        <td class="lovtd"><?php echo $row[1]; ?><input type="hidden" class="form-control" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $row[0]; ?>"></td>
                                        <td class="lovtd">
                                            <?php if ($lovnm !== "") { ?>
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group"  style="width:100%;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            } else if ($dataTyp == "DATE") {
                                                $dtFrmtCls = "form_date_tme";
                                                if ($dtFrmt == "yyyy-MM-dd") {
                                                    $dtFrmt = "yyyy-mm-dd";
                                                    $dtFrmt1 = "yyyy-mm-dd";
                                                    $dtFrmtCls = "form_date1";
                                                } else if ($dtFrmt == "yyyy-MM-dd HH:mm:ss") {
                                                    $dtFrmt = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmtCls = "form_date_tme1";
                                                } else if ($dtFrmt == "dd-MMM-yyyy HH:mm:ss") {
                                                    $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                    $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmtCls = "form_date_tme";
                                                } else if ($dtFrmt == "dd-MMM-yyyy") {
                                                    $dtFrmt = "dd-M-yyyy";
                                                    $dtFrmt1 = "yyyy-mm-dd";
                                                    $dtFrmtCls = "form_date";
                                                } else {
                                                    $dtFrmt1 = "yyyy-mm-dd hh:ii:ss";
                                                    $dtFrmt = "dd-M-yyyy hh:ii:ss";
                                                }
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group date <?php echo $dtFrmtCls; ?>" data-date="" data-date-format="<?php echo $dtFrmt; ?>" data-link-field="dtp_input2" data-link-format="<?php echo $dtFrmt1; ?>" style="width:100%;">
                                                        <input class="form-control <?php echo $isrqrd ?>" size="16" type="text" id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" name="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" readonly="">
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                    </div>                                                                
                                                </div>
                                                <?php
                                            } else if ($dataTyp == "NUMBER") {
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <input type="number" min="-999999999999" max="999999999999" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" name="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100%;">
                                                </div>
                                                <?php
                                            } else {
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $nwval1; ?>" style="width:100% !important;">
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                $result1 = get_Rpt_ColsToAct($pkID);
                                $colNoVals = array("", "", "", "", "", "", "", "");
                                $colsCnt = loc_db_num_fields($result1);
                                while ($row1 = loc_db_fetch_array($result1)) {
                                    for ($d = 0; $d < $colsCnt; $d++) {
                                        $colNoVals[$d] = $row1[$d];
                                    }
                                }
                                for ($d = 0; $d < count($colNoVals); $d++) {
                                    $cntr ++;
                                    $isrqrd = "";
                                    ?>
                                    <tr id="allSchdlPrmsRow_<?php echo $cntr; ?>" class="hand_cursor">
                                        <td class="lovtd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                        <td class="lovtd"><?php echo $sysParaNames[$d]; ?><input type="hidden" class="form-control" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamID" value="<?php echo $sysParaIDs[$d]; ?>"></td>
                                        <td class="lovtd">  
                                            <?php
                                            if ($sysParaIDs[$d] == "-190") {
                                                $lovnm = "Report Output Formats";
                                                ?>
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group"  style="width:100%;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            } else if ($sysParaIDs[$d] == "-200") {
                                                $lovnm = "Report Orientations";
                                                ?>
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <div class="input-group"  style="width:100%;">
                                                        <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>">
                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', '<?php echo $lovnm; ?>', '', '', '', 'radio', true, '<?php echo $nwval1; ?>', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal', 'clear', 0, '');">
                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>                                            
                                                <div class="form-group form-group-sm" style="width:100% !important;margin-bottom:0px !important;">
                                                    <input type="text" class="form-control <?php echo $isrqrd ?>" aria-label="..." id="allSchdlPrmsRow<?php echo $cntr; ?>_ParamVal" value="<?php echo $colNoVals[$d]; ?>" style="width:100% !important;">
                                                </div>
                                            <?php }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
            }
        }
    }
}    

?>