<?php
if ($vwtyp == 0) {

            $total = get_LovsTtl($srchFor, $srchIn);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_LovsTblr($srchFor, $srchIn, $curIdx, $lmtSze);
            $lovss = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                $chckd = ($cntr == 0) ? TRUE : FALSE;
                $lovs = array(
                    'checked' => var_export($chckd, TRUE),
                    'ValListID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ( $cntr + 1),
                    'ValListName' => $row[1],
                    'ValListDesc' => $row[2],
                    'SQLQuery' => $row[3],
                    'DefinedBy' => $row[4],
                    'IsListDynmc' => var_export(($row[5] == '1' ? TRUE : FALSE), TRUE),
                    'IsEnabled' => var_export(($row[6] == '1' ? TRUE : FALSE), TRUE));
                $lovss[] = $lovs;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $lovss));
        } else if ($vwtyp == 1) {
            //Get LOV Possible Values 
            //$brghtsqlStr = "";
            //$is_dynamic = FALSE;
            $pkID = isset($_POST['valListID']) ? $_POST['valListID'] : -1;

            $total = get_TtlLovsPssblVals($srchFor, $srchIn, $pkID);
            //$total = getTtlLovValues($srchFor, $srchIn, $brghtsqlStr, $pkID, $is_dynamic, -1, "", "");
            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }
            $curIdx = $pageNo - 1;
            //$result = getLovValues($srchFor, $srchIn, $curIdx, $lmtSze, $brghtsqlStr, $pkID, $is_dynamic, -1, "", "");
            $result = get_LovsPssblVals($srchFor, $srchIn, $curIdx, $lmtSze, $pkID);
            $lovsDts = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $lovsDt = array(
                    'PssblValID' => $row[0],
                    'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                    'PssblVal' => $row[2],
                    'PssblValDesc' => $row[3],
                    'IsEnabled' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE),
                    'AllwdOrgIDs' => $row[5]);
                $lovsDts[] = $lovsDt;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $lovsDts));
        } else if ($vwtyp == 3) {
            $pkID = isset($_POST['valListID']) ? $_POST['valListID'] : -1;
            $result = get_LovsDetail($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>VALUE LIST DETAILS</caption>";
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
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }
            $cntent .= "</tbody></table></div>";
            echo $cntent;
        } else if ($vwtyp == 4) {
            $pkID = isset($_POST['pssblValID']) ? $_POST['pssblValID'] : -1;
            $result = get_LovsPssblValsDet($pkID);
            $colsCnt = loc_db_num_fields($result);
            $cntent = "<div style=\"padding:2px;width:100%;\">
        <table style=\"width:100%;border-collapse: collapse;border-spacing: 0;\"class=\"gridtable\">
            <caption>POSSIBLE VALUE DETAILS</caption>";
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
                    $cntent .= "<td width=\"60%\" $style2>" . $row[$d] . "</td>";
                    $cntent .= "</tr>";
                }
                $i++;
            }

            $cntent .= "</tbody></table></div>";
            echo $cntent;
        }
    ?>