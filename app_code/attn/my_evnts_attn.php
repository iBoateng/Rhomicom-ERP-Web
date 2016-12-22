<?php

$prsnid = $_SESSION['PRSN_ID'];
if ($vwtyp == 0) {

    $total = get_MyEvntsAttndTtl($srchFor, $srchIn, $prsnid);

    $pageNo = isset($_POST['page']) ? $_POST['page'] : 1;
    $lmtSze = isset($_POST['limit']) ? $_POST['limit'] : 1;
    $start = isset($_POST['start']) ? $_POST['start'] : 0;

    if ($pageNo > ceil($total / $lmtSze)) {
        $pageNo = 1;
    }

    $curIdx = $pageNo - 1;
    $result = get_MyEvntsAttndTblr($srchFor, $srchIn, $curIdx, $lmtSze, $prsnid);
    $myEvntsAttnds = array();
    $cntr = 0;
    while ($row = loc_db_fetch_array($result)) {
        $chckd = ($cntr == 0) ? TRUE : FALSE;
        $myEvntsAttnd = array(
            'checked' => var_export($chckd, TRUE),
            'AttnRecID' => $row[0],
            'AttnRqstID' => -1,
            'AttnRgstrID' => $row[1],
            'RegNameNum' => $row[2],
            'EventNameDesc' => $row[3],
            'EventStartDate' => $row[4],
            'EventEndDate' => $row[5],
            'TimeIn' => $row[9],
            'TimeOut' => $row[10],
            'IsPresent' => $row[11],
            'LnkdFirm' => $row[12],
            'InvoiceNumber' => $row[13],
            'InvcTtl' => $row[14],
            'OutstndngBalance' => $row[16],
            'CPDPoints' => $row[19],
            'Remarks' => $row[17],
            'WkfMsgID' => -1,
            'Status' => 'Completed Successfully',
            'Attachments' => '');
        $myEvntsAttnds[] = $myEvntsAttnd;
        $cntr++;
    }

    echo json_encode(array('success' => true,
        'total' => $total,
        'rows' => $myEvntsAttnds));
}
?>