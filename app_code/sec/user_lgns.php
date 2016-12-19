<?php
if ($vwtyp == 0) {
                    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
                    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
                    $start = isset($_POST ['start']) ? $_POST['start'] : 0;
                    $shwFld = isset($_POST ['qShwFailedOnly']) ? cleanInputData($_POST['qShwFailedOnly']) : true;
                    $shw_sccfl = isset($_POST ['qShwSccflOnly']) ? cleanInputData($_POST['qShwSccflOnly']) : true;
                    $total = get_UserLgnsTtl($srchFor, $srchIn, $shwFld, $shw_sccfl);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_UserLgns($srchFor, $srchIn, $curIdx, $lmtSze, $shwFld, $shw_sccfl);
                    $parentArry = array();
                    $cntr = 0;
                    while ($row = loc_db_fetch_array($result)) {
                        $chckd = ($cntr == 0) ? TRUE : FALSE;
                        $childArray = array(
                            'checked' => var_export($chckd, TRUE),
                            'UserID' => $row[5],
                            'RowNum' => ($curIdx * $lmtSze) + ($cntr + 1),
                            'UserName' => $row[0],
                            'LoginTime' => $row[1],
                            'LogoutTime' => $row[2],
                            'MachineDetails' => $row[3],
                            'LoginNumber' => $row[6],
                            'WasLgnAttmpSuccfl' => ($row[4] == '1' ? "TRUE" : "FALSE"));
                        $parentArry[] = $childArray;
                        $cntr++;
                    } echo json_encode(array('success' => true,
                        'total' => $total,
                        'rows' => $parentArry));
                }