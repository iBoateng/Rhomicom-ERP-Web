<?php

                if ($vwtyp == 0) {
                    $total = get_WkfAppsTtl($srchFor, $srchIn);

                    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
                    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
                    $start = isset($_POST['start']) ? $_POST['start'] : 0;
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_WkfAppsTblr($srchFor, $srchIn, $curIdx, $lmtSze);
                    $wkfapps = array();
                    $cntr = 0;
                    while ($row = loc_db_fetch_array($result)) {
                        $chckd = ($cntr == 0) ? TRUE : FALSE;
                        $wkfapp = array(
                            'checked' => var_export($chckd, TRUE),
                            'AppID' => $row[0],
                            'AppName' => $row[1],
                            'SourceModule' => $row[2],
                            'Description' => $row[3]);
                        $wkfapps[] = $wkfapp;
                        $cntr++;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                } else if ($vwtyp == 1) {
                    $total = 500;

                    $pkID = isset($_POST['appID']) ? $_POST['appID'] : -1;
                    $result = get_WkfAppsActns($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'ActionID' => $row[0],
                            'ActionName' => $row[1],
                            'SQLAction' => $row[3],
                            'Description' => $row[2],
                            'ExecFileName' => $row[9],
                            'WebURLParams' => $row[10],
                            'WebDisplayType' => var_export(($row[11] == 'Dialog' ? TRUE : FALSE), TRUE),
                            'AdminOnly' => var_export(($row[12] == 'YES' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                } else if ($vwtyp == 2) {
                    $total = 500;

                    $pkID = isset($_POST['appID']) ? $_POST['appID'] : -1;
                    $result = get_WkfAppsHrchies($pkID);
                    $wkfapps = array();
                    while ($row = loc_db_fetch_array($result)) {
                        //$chckd = FALSE;
                        $wkfapp = array(
                            'AppHrchyID' => $row[0],
                            'HrchyName' => $row[1],
                            'HrchyType' => $row[2],
                            'HrchyEnabled' => var_export(($row[3] == '1' ? TRUE : FALSE), TRUE),
                            'LinkageEnabled' => var_export(($row[4] == '1' ? TRUE : FALSE), TRUE));
                        $wkfapps[] = $wkfapp;
                    }

                    echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $wkfapps));
                }
                ?>