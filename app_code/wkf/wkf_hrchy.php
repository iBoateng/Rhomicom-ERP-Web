<?php

                if ($vwtyp == 0) {
                    $total = get_WkfHrchyTtl($srchFor, $srchIn);

                    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
                    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
                    $start = isset($_POST['start']) ? $_POST['start'] : 0;
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_WkfHrchyTblr($srchFor, $srchIn, $curIdx, $lmtSze);
                    $wkfhrchys = array();
                    $cntr = 0;
                    while ($row = loc_db_fetch_array($result)) {
                        $chckd = ($cntr == 0) ? TRUE : FALSE;
                        $wkfhrchy = array(
                            'checked' => var_export($chckd, TRUE),
                            'HrchyID' => $row[0],
                            'HrchyName' => $row[1],
                            'HrchyDesc' => $row[2],
                            'HrchyType' => $row[3],
                            'SQLStmnt' => $row[4],
                            'IsEnabled' => var_export(($row[5] == '1' ? TRUE : FALSE), TRUE));
                        $wkfhrchys[] = $wkfhrchy;
                        $cntr++;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfhrchys));
                } else if ($vwtyp == 1) {
                    $total = 500;

                    $pkID = isset($_POST['hrchyID']) ? $_POST['hrchyID'] : -1;
                    $result = get_HrchyCntntMnl($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'MnlHrchyDetID' => $row[0],
                            'PersonName' => $row[2],
                            'PersonLocID' => $row[1],
                            'HrchyLevel' => $row[3],
                            'IsEnabled' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                } else if ($vwtyp == 2) {
                    $total = 500;

                    $pkID = isset($_POST['hrchyID']) ? $_POST['hrchyID'] : -1;
                    $result = get_HrchyCntntPos($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'PosHrchyDetID' => $row[0],
                            'PositionName' => $row[2],
                            'PositionID' => $row[1],
                            'HrchyLevel' => $row[3],
                            'IsEnabled' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                }
                ?>
