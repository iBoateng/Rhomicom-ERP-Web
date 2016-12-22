<?php

if ($vwtyp == 0) {
    $total = get_RptsTtl($srchFor, $srchIn);

    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
    $start = isset($_POST['start']) ? $_POST['start'] : 0;

    if ($pageNo > ceil($total / $lmtSze)) {
        $pageNo = 1;
    }

    $curIdx = $pageNo - 1;
    $result = get_RptsTblr($srchFor, $srchIn, $curIdx, $lmtSze);
    $prntArray = array();
    $cntr = 0;
    while ($row = loc_db_fetch_array($result)) {
        $chckd = ($cntr == 0) ? TRUE : FALSE;
        $childArray = array(
            'checked' => var_export($chckd, TRUE),
            'ReportID' => $row[0],
            'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
            'ReportName' => $row[1],
            'Description' => $row[2]);
        $prntArray[] = $childArray;
        $cntr++;
    }

    echo json_encode(array('success' => true,
        'total' => $total,
        'rows' => $prntArray));
} else if ($vwtyp == 1) {
    //var_dump($_POST);
    $pkID = isset($_POST['rptHdrID']) ? $_POST['rptHdrID'] : -1;
    $total = get_RptRunsTtl($pkID, $srchFor, $srchIn);

    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
    $start = isset($_POST['start']) ? $_POST['start'] : 0;

    if ($pageNo > ceil($total / $lmtSze)) {
        $pageNo = 1;
    }

    $curIdx = $pageNo - 1;
    $result = get_RptRuns($pkID, $srchFor, $srchIn, $curIdx, $lmtSze);
    $prntArray = array();
    $cntr = 0;
    while ($row = loc_db_fetch_array($result)) {
        //$chckd = FALSE; 
        $outptUsd = $row[8];
        $rpt_src_encrpt = "";
        if ($outptUsd == "HTML" || $outptUsd == "COLUMN CHART" || $outptUsd == "SIMPLE COLUMN CHART" || $outptUsd == "BAR CHART" || $outptUsd == "PIE CHART" || $outptUsd == "LINE CHART") {
            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/amcharts_2100/samples/$row[0].html";
            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
            if (file_exists($rpt_src)) {
                //file exists!
            } else {
                //file does not exist.
                $rpt_src_encrpt = "No Output File";
            }
        } else if ($outptUsd == "STANDARD") {
            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[0].txt";
            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
            if (file_exists($rpt_src)) {
                //file exists!
            } else {
                //file does not exist.
                $rpt_src_encrpt = "No Output File";
            }
        } else if ($outptUsd == "PDF") {
            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[0].pdf";
            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
            if (file_exists($rpt_src)) {
                //file exists!
            } else {
                //file does not exist.
                $rpt_src_encrpt = "No Output File";
            }
        } else if ($outptUsd == "MICROSOFT WORD") {
            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[0].rtf";
            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
            if (file_exists($rpt_src)) {
                //file exists!
            } else {
                //file does not exist.
                $rpt_src_encrpt = "No Output File";
            }
        } else if ($outptUsd == "MICROSOFT EXCEL") {
            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[0].xls";
            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
            if (file_exists($rpt_src)) {
                //file exists!
            } else {
                //file does not exist.
                $rpt_src_encrpt = "No Output File";
            }
        } else if ($outptUsd == "CHARACTER SEPARATED FILE (CSV)") {
            $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[0].csv";
            $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
            if (file_exists($rpt_src)) {
                //file exists!
            } else {
                //file does not exist.
                $rpt_src_encrpt = "No Output File";
            }
        } else {
            $rpt_src_encrpt = "No Output File";
        }
        $childArray = array(
            'ReportRunID' => $row[0],
            'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
            'RunBy' => $row[2],
            'DateRun' => $row[3],
            'RunStatusText' => $row[4],
            'RunStatusPrcnt' => $row[5],
            'RunSource' => $row[11],
            'OutputUsed' => $row[8],
            'LastTimeActive' => $row[10],
            'ReportName' => $row[13],
            'OutFileName' => 'grp=1&typ=11&q=Download&fnm=' . $rpt_src_encrpt);
        $prntArray[] = $childArray;
        $cntr++;
    }

    echo json_encode(array('success' => true,
        'total' => $total,
        'rows' => $prntArray));
} else if ($vwtyp == 2) {
    //Run Detail
    $pkID = isset($_POST['reportRunID']) ? $_POST['reportRunID'] : -1;
    $result = get_OneRptRun($pkID);
    $colsCnt = loc_db_num_fields($result);
    $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\" class=\"gridtable\">
            <caption>REPORT RUN DETAILS</caption>";
    $cntent .= "<thead><tr>";
    $cntent .= "<th width=\"40%\" style=\"font-weight:bold;\">LABEL</th>";
    $cntent .= "<th width=\"60%\" style=\"font-weight:bold;\">VALUE</th>";
    $cntent .= "</tr></thead>";
    $cntent .= "<tbody>";
    $i = 0;

    $labl = "";
    $labl1 = "";
    $outptUsd = "";
    while ($row = loc_db_fetch_array($result)) {
        for ($d = 0; $d < $colsCnt; $d++) {
            $style = "";
            $style2 = "";
            if (trim(loc_db_field_name($result, $d)) == "output_used") {
                $outptUsd = $row[$d];
            }
            if (trim(loc_db_field_name($result, $d)) == "mt") {
                $style = "style=\"display:none;\"";
            }
            if (strtoupper($row[$d]) == 'NO') {
                $style2 = "style=\"color:red;font-weight:bold;\"";
            } else if (strtoupper($row[$d]) == 'YES') {
                $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
            }
            $lbl = ucwords(str_replace("_", " ", trim(loc_db_field_name($result, $d))));
            $val = $row[$d];
            if ($lbl == "Run Status Text") {
                if ($row[$d] == "Not Started!") {
                    $style2 = "style=\"background-color: #E8D68C;\"";
                } else if ($row[$d] == "Preparing to Start...") {
                    $style2 = "style=\"background-color: yellow;\"";
                } else if ($row[$d] == "Running SQL...") {
                    $style2 = "style=\"background-color: lightgreen;\"";
                } else if ($row[$d] == "Formatting Output...") {
                    $style2 = "style=\"background-color: lime;\"";
                } else if ($row[$d] == "Storing Output...") {
                    $style2 = "style=\"background-color: cyan;\"";
                } else if ($row[$d] == "Completed!") {
                    $style2 = "style=\"background-color: gainsboro;\"";
                } else if (strpos($row[$d], "Error!") !== FALSE) {
                    $style2 = "style=\"background-color: red;\"";
                } else {
                    $style2 = "style=\"background-color: gainsboro;\"";
                }
            } else if ($lbl == "Last Time Active") {
                $tst = isDteTmeWthnIntrvl(cnvrtDMYTmToYMDTm($row[$d]), '10 second');
                if ($tst == true) {
                    $style2 = "style=\"color: lime; font-weight:bold;font-style: italic;\"";
                } else {
                    $style2 = "";
                }
            } else if ($lbl == "Open Output File") {
                if ($outptUsd == "HTML" || $outptUsd == "COLUMN CHART" || $outptUsd == "SIMPLE COLUMN CHART" || $outptUsd == "BAR CHART" || $outptUsd == "PIE CHART" || $outptUsd == "LINE CHART") {
                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/amcharts_2100/samples/$row[$d].html";
                    $rpt_src1 = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/amcharts_2100/images/";
                    $rpt_dest1 = $fldrPrfx . "dwnlds/amcharts_2100/images/";
                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                    $nwhref = "javascript: dwnldAjxCall1('grp=1&typ=11&q=Download&fnm=$rpt_src_encrpt');";
                    $rpt_link = "<div class=\"divButtons1\">
                        <a href=\"$nwhref\">
                        <img class=\"divButtons1imgdsply\" src=\"cmn_images/kghostview.png\" alt=\"VIEW OUTPUT\" title=\"VIEW OUTPUT\" /><span>VIEW OUTPUT&nbsp;&nbsp;</span></a></div>";
                    /* var_dump( file_exists($rpt_src)); */
                    if ($rpt_dest1 != "") {
                        recurse_copy($rpt_src1, $rpt_dest1);
                    }
                    if (file_exists($rpt_src)) {
                        //file exists!
                    } else {
                        //file does not exist.
                        $rpt_link = "No Output File";
                    }
                    $val = $rpt_link;
                } else if ($outptUsd == "STANDARD") {
                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[$d].txt";
                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                    $nwhref = "javascript: dwnldAjxCall1('grp=1&typ=11&q=Download&fnm=$rpt_src_encrpt');";
                    $rpt_link = "<div class=\"divButtons1\">
                        <a href=\"$nwhref\">
                        <img class=\"divButtons1imgdsply\" src=\"cmn_images/dwldicon.png\" alt=\"DOWNLOAD FILE\" title=\"DOWNLOAD FILE\" /><span>DOWNLOAD FILE&nbsp;&nbsp;</span></a></div>";
                    if (file_exists($rpt_src)) {
                        //file exists!
                    } else {
                        //file does not exist.
                        $rpt_link = "No Output File";
                    }
                    $val = $rpt_link;
                } else if ($outptUsd == "PDF") {
                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[$d].pdf";
                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                    $nwhref = "javascript: dwnldAjxCall1('grp=1&typ=11&q=Download&fnm=$rpt_src_encrpt');";
                    $rpt_link = "<div class=\"divButtons1\">
                        <a href=\"$nwhref\">
                        <img class=\"divButtons1imgdsply\" src=\"cmn_images/dwldicon.png\" alt=\"DOWNLOAD FILE\" title=\"DOWNLOAD FILE\" /><span>DOWNLOAD FILE&nbsp;&nbsp;</span></a></div>";
                    if (file_exists($rpt_src)) {
                        //file exists!
                    } else {
                        //file does not exist.
                        $rpt_link = "No Output File";
                    }
                    $val = $rpt_link;
                } else if ($outptUsd == "MICROSOFT WORD") {
                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[$d].rtf";
                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                    $nwhref = "javascript: dwnldAjxCall1('grp=1&typ=11&q=Download&fnm=$rpt_src_encrpt');";
                    $rpt_link = "<div class=\"divButtons1\">
                        <a href=\"$nwhref\">
                        <img class=\"divButtons1imgdsply\" src=\"cmn_images/dwldicon.png\" alt=\"DOWNLOAD FILE\" title=\"DOWNLOAD FILE\" /><span>DOWNLOAD FILE&nbsp;&nbsp;</span></a></div>";
                    if (file_exists($rpt_src)) {
                        //file exists!
                    } else {
                        //file does not exist.
                        $rpt_link = "No Output File";
                    }
                    $val = $rpt_link;
                } else if ($outptUsd == "MICROSOFT EXCEL") {
                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[$d].xls";
                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                    $nwhref = "javascript: dwnldAjxCall1('grp=1&typ=11&q=Download&fnm=$rpt_src_encrpt');";
                    $rpt_link = "<div class=\"divButtons1\">
                        <a href=\"$nwhref\">
                        <img class=\"divButtons1imgdsply\" src=\"cmn_images/dwldicon.png\" alt=\"DOWNLOAD FILE\" title=\"DOWNLOAD FILE\" /><span>DOWNLOAD FILE&nbsp;&nbsp;</span></a></div>";
                    //echo "testing".$rpt_src;
                    if (file_exists($rpt_src)) {
                        //file exists!
                    } else {
                        //file does not exist.
                        $rpt_link = "No Output File";
                    }
                    $val = $rpt_link;
                } else if ($outptUsd == "CHARACTER SEPARATED FILE (CSV)") {
                    $rpt_src = str_replace("\\", "/", $ftp_base_db_fldr . "/Rpts") . "/$row[$d].csv";
                    $rpt_src_encrpt = encrypt1($rpt_src, $smplTokenWord1);
                    $nwhref = "javascript: dwnldAjxCall1('grp=1&typ=11&q=Download&fnm=$rpt_src_encrpt');";
                    $rpt_link = "<div  class=\"divButtons1\">
                        <a href=\"$nwhref\">
                        <img class=\"divButtons1imgdsply\" src=\"cmn_images/dwldicon.png\" alt=\"DOWNLOAD FILE\" title=\"DOWNLOAD FILE\" /><span>DOWNLOAD FILE&nbsp;&nbsp;</span></a></div>";
                    if (file_exists($rpt_src)) {
                        //file exists!
                    } else {
                        //file does not exist.
                        $rpt_link = "No Output File";
                    }
                    $val = $rpt_link;
                } else {
                    $val = "No Output File";
                }
            }

            $cntent .= "<tr $style>";
            $cntent .= "<td width=\"40%\" style=\"font-weight:bold;vertical-align:top;\" class=\"likeheader\">" . $lbl . "</td>";
            $cntent .= "<td width=\"60%\" $style2>" . $val . "</td>";
            $cntent .= "</tr>";
        }
        $i++;
    }
    $cntent .= "</tbody></table>";

    $sysParaIDs = array("-130", "-140", "-150", "-160", "-170", "-180", "-190", "-200");
    $sysParaNames = array("Report Title:", "Cols Nos To Group or Width & Height (Px) for Charts:",
        "Cols Nos To Count or Use in Charts:", "Columns To Sum:", "Columns To Average:",
        "Columns To Format Numerically:", "Report Output Formats", "Report Orientations");

    $paramIDs = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "rpt_rn_param_ids", $pkID);
    $paramVals = getGnrlRecNm("rpt.rpt_report_runs", "rpt_run_id", "rpt_rn_param_vals", $pkID);

    $arry1 = explode("|", $paramIDs);
    $arry2 = explode("|", $paramVals);

    $cntent .= "<table style=\"margin-top:10px;width:100%;border-collapse: collapse;border-spacing: 0;\" class=\"gridtable\">"
            . "<caption>RUN PARAMETERS</caption>"
            . "<thead><th>No.</th><th>Parameter Name</th><th>Parameter Value</th></thead><tbody>";
    for ($i = 0; $i < count($arry1); $i++) {
        $pID = -1;
        if (is_numeric($arry1[$i])) {
            $pID = (int) $arry1[$i];
        }
        $prNm = getGnrlRecNm("rpt.rpt_report_parameters", "parameter_id", "parameter_name", $pID);
        $prVal = "";
        if ($prNm == "") {
            $h1 = findArryIdx($sysParaIDs, $arry1[$i]);
            if ($h1 >= 0) {
                $prNm = $sysParaNames[$h1];
            }
        }
        if ($i < count($arry2)) {
            $prVal = $arry2[$i];
        }
        $cntent .= "<tr><td>" . ($i + 1) . "</td><td>" . $prNm . "</td><td>" . $prVal . "</td></tr>"; //<td>" . $pID . "</td>
    }
    $cntent .= "</tbody></table></div>";
    echo $cntent;
} else if ($vwtyp == 3) {
    //Run Detail
    $pkID = isset($_POST['reportRunID']) ? $_POST['reportRunID'] : -1;
    $cntent = "<div style=\"padding:2px;width:100%;\">" . str_replace("\r\n", "<br/>", getGnrlRecNm("rpt.rpt_run_msgs", "process_id", "log_messages", $pkID)) . "</div>";
    echo $cntent;
} else if ($vwtyp == 4) {
    //var_dump($_POST);
    $pkID = isset($_POST['rptHdrID']) ? $_POST['rptHdrID'] : -1;
    $total = get_RptAlertsTtl($pkID, $srchFor, $srchIn);

    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
    $start = isset($_POST['start']) ? $_POST['start'] : 0;

    if ($pageNo > ceil($total / $lmtSze)) {
        $pageNo = 1;
    }

    $curIdx = $pageNo - 1;
    $result = get_RptAlerts($pkID, $srchFor, $srchIn, $curIdx, $lmtSze);
    $prntArray = array();
    $cntr = 0;
    while ($row = loc_db_fetch_array($result)) {
        //$chckd = FALSE; 
        $childArray = array(
            'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
            'ReportID' => $row[1],
            'AlertID' => $row[0],
            'AlertName' => $row[2]);
        $prntArray[] = $childArray;
        $cntr++;
    }

    echo json_encode(array('success' => true,
        'total' => $total,
        'rows' => $prntArray));
} else if ($vwtyp == 5) {
    //var_dump($_POST);
    $pkID = isset($_POST['rptHdrID']) ? $_POST['rptHdrID'] : -1;
    $total = 500;

    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
    $start = isset($_POST['start']) ? $_POST['start'] : 0;

    if ($pageNo > ceil($total / $lmtSze)) {
        $pageNo = 1;
    }

    $curIdx = $pageNo - 1;
    $result = get_AllParams($pkID);
    $prntArray = array();
    $cntr = 0;

    while ($row = loc_db_fetch_array($result)) {
        $chckd = ($cntr == 0) ? TRUE : FALSE;
        $childArray = array(
            'checked' => var_export($chckd, TRUE),
            'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
            'ParameterID' => $row[0],
            'ParameterName' => $row[1],
            'DefaultValue' => $row[3],
            'ParamRepInQuery' => $row[2],
            'LovName' => $row[6],
            'ParamDataType' => $row[7],
            'ParamDateFormat' => $row[8],
            'IsRequired' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE));
        $prntArray[] = $childArray;
        $cntr++;
    }
    $rptNm = getGnrlRecNm("rpt.rpt_reports", "report_id", "report_name", $pkID);
    $rptOutput = getGnrlRecNm("rpt.rpt_reports", "report_id", "output_type", $pkID);
    $rptOrntn = getGnrlRecNm("rpt.rpt_reports", "report_id", "portrait_lndscp", $pkID);
    $childArray = array(
        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
        'ParameterID' => -130,
        'ParameterName' => "Report Title:",
        'DefaultValue' => $rptNm,
        'ParamRepInQuery' => "{:report_title}",
        'LovName' => "",
        'ParamDataType' => "TEXT",
        'ParamDateFormat' => "",
        'IsRequired' => var_export(FALSE, TRUE));
    $prntArray[] = $childArray;
    $cntr++;

    $result1 = get_Rpt_ColsToAct($pkID);
    $colsTtl = loc_db_num_fields($result1);

    while ($row1 = loc_db_fetch_array($result1)) {
        for ($d = 0; $d < $colsCnt; $d++) {
            switch ($d) {
                case 0:
                    $childArray = array(
                        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                        'ParameterID' => -140,
                        'ParameterName' => "Cols Nos To Group or Width & Height (Px) for Charts:",
                        'DefaultValue' => $row1[$d],
                        'ParamRepInQuery' => "{:cols_to_group}",
                        'LovName' => "",
                        'ParamDataType' => "TEXT",
                        'ParamDateFormat' => "",
                        'IsRequired' => var_export(FALSE, TRUE));
                    $prntArray[] = $childArray;
                    break;
                case 1:
                    $childArray = array(
                        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                        'ParameterID' => -150,
                        'ParameterName' => "Cols Nos To Count or Use in Charts:",
                        'DefaultValue' => $row1[$d],
                        'ParamRepInQuery' => "{:cols_to_count}",
                        'LovName' => "",
                        'ParamDataType' => "TEXT",
                        'ParamDateFormat' => "",
                        'IsRequired' => var_export(FALSE, TRUE));
                    $prntArray[] = $childArray;
                    break;
                case 2:$childArray = array(
                        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                        'ParameterID' => -160,
                        'ParameterName' => "Columns To Sum:",
                        'DefaultValue' => $row1[$d],
                        'ParamRepInQuery' => "{:cols_to_sum}",
                        'LovName' => "",
                        'ParamDataType' => "TEXT",
                        'ParamDateFormat' => "",
                        'IsRequired' => var_export(FALSE, TRUE));
                    $prntArray[] = $childArray;
                    break;
                case 3:
                    $childArray = array(
                        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                        'ParameterID' => -170,
                        'ParameterName' => "Columns To Average:",
                        'DefaultValue' => $row1[$d],
                        'ParamRepInQuery' => "{:cols_to_average}",
                        'LovName' => "",
                        'ParamDataType' => "TEXT",
                        'ParamDateFormat' => "",
                        'IsRequired' => var_export(FALSE, TRUE));
                    $prntArray[] = $childArray;
                    break;
                case 4:
                    $childArray = array(
                        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                        'ParameterID' => -180,
                        'ParameterName' => "Columns To Format Numerically:",
                        'DefaultValue' => $row1[$d],
                        'ParamRepInQuery' => "{:cols_to_frmt}",
                        'LovName' => "",
                        'ParamDataType' => "TEXT",
                        'ParamDateFormat' => "",
                        'IsRequired' => var_export(FALSE, TRUE));
                    $prntArray[] = $childArray;
                    break;
            }
            $cntr++;
        }
    }

    $childArray = array(
        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
        'ParameterID' => -190,
        'ParameterName' => "Output Format:",
        'DefaultValue' => $rptOutput,
        'ParamRepInQuery' => "{:output_frmt}",
        'LovName' => "Report Output Formats",
        'ParamDataType' => "TEXT",
        'ParamDateFormat' => "",
        'IsRequired' => var_export(FALSE, TRUE));
    $prntArray[] = $childArray;
    $cntr++;

    $childArray = array(
        'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
        'ParameterID' => -200,
        'ParameterName' => "Orientation:",
        'DefaultValue' => $rptOrntn,
        'ParamRepInQuery' => "{:orientation_frmt}",
        'LovName' => "Report Orientations",
        'ParamDataType' => "TEXT",
        'ParamDateFormat' => "",
        'IsRequired' => var_export(FALSE, TRUE));
    $prntArray[] = $childArray;
    $cntr++;
    echo json_encode(
            array('success' => true,
                'total' => $total,
                'rows' => $prntArray));
}
?>

