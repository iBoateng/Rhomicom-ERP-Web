<?php

        $prsnid = $_SESSION['PRSN_ID'];
        if ($vwtyp == 0) {

            $total = get_MyPyRnsTtl($srchFor, $srchIn, $prsnid);

            $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
            $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
            $start = isset($_POST['start']) ? $_POST['start'] : 0;

            if ($pageNo > ceil($total / $lmtSze)) {
                $pageNo = 1;
            }

            $curIdx = $pageNo - 1;
            $result = get_MyPyRnsTblr($srchFor, $srchIn, $curIdx, $lmtSze, $prsnid);
            $myPyRns = array();
            $cntr = 0;
            while ($row = loc_db_fetch_array($result)) {
                $chckd = ($cntr == 0) ? TRUE : FALSE;
                $myPyRn = array(
                    'checked' => var_export($chckd, TRUE),
                    'PayReqHdrID' => $row[0],
                    'MassPayID' => $row[1],
                    'MassPayName' => $row[2],
                    'MassPayDesc' => $row[3],
                    'WkfMsgID' => $row[4],
                    'Status' => $row[5],
                    'Attachments' => $row[7]);
                $myPyRns[] = $myPyRn;
                $cntr++;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $myPyRns));
        } else if ($vwtyp == 1) {
            $total = 500;
            //var_dump($_POST);
            $pkID = isset($_POST['pyReqHdrID']) ? $_POST['pyReqHdrID'] : -1;
            if ($pkID <= 0) {
                $pkID = isset($_POST['mspyHdrID']) ? $_POST['mspyHdrID'] : -1;
            }
            $result = null;
            if ($pkID <= 0) {
                $result = get_CumltiveBals($prsnid);
            } else {
                $result = get_MyPyRnsDt($pkID, $prsnid);
            }
            $myPyRnDts = array();
            while ($row = loc_db_fetch_array($result)) {
                //$chckd = FALSE;
                $myPyRnDt = array(
                    'PymntReqId' => $row[0],
                    'PayItemID' => $row[5],
                    'PayItemName' => $row[6],
                    'PayItemAmount' => $row[7],
                    'PayTrnsDate' => $row[8],
                    'LineDescription' => $row[9]);
                $myPyRnDts[] = $myPyRnDt;
            }

            echo json_encode(array('success' => true,
                'total' => $total,
                'rows' => $myPyRnDts));
        }
        ?>