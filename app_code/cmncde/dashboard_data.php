<?php

$vwtyp = "0";
$qstr = "";
$dsply = "";
$actyp = "";
$srchFor = "";
$srchIn = "Name";
$wkfAppID = -1;
$wkfAppActionID = -1;
if (isset($formArray)) {
    if (count($formArray) > 0) {
        $vwtyp = isset($formArray['vtyp']) ? cleanInputData($formArray['vtyp']) : "0";
        $qstr = isset($formArray['q']) ? cleanInputData($formArray['q']) : '';
    } else {
        $vwtyp = isset($_POST['vtyp']) ? cleanInputData($_POST['vtyp']) : "0";
    }
} else {
    $vwtyp = isset($_POST['vtyp']) ? cleanInputData($_POST['vtyp']) : "0";
}

if (isset($_POST['appID'])) {
    $wkfAppID = cleanInputData($_POST['appID']);
}

if (isset($_POST['appActionID'])) {
    $wkfAppActionID = cleanInputData($_POST['appActionID']);
}

if (isset($_POST['searchfor'])) {
    $srchFor = cleanInputData($_POST['searchfor']);
}

if (isset($_POST['searchin'])) {
    $srchIn = cleanInputData($_POST['searchin']);
}

if (isset($_POST['q'])) {
    $qstr = cleanInputData($_POST['q']);
}

if (isset($_POST['vtyp'])) {
    $vwtyp = cleanInputData($_POST['vtyp']);
}
if (isset($_POST['actyp'])) {
    $actyp = cleanInputData($_POST['actyp']);
}
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = " " . $srchFor . " ";
    $srchFor = str_replace(" ", "%", $srchFor);
}
$canview = true;
$_jsonOutput = "";
if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0 && $canview === true) {
        if ($qstr == 'view') {
            if ($vwtyp == 0) {
                $total = 500;
                $result = getTechDivDist();

                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $wkfapp = array(
                        'name' => $row[0],
                        'g1' => $row[1],
                        'g2' => $row[2],
                        'g3' => (int) '0',
                        'g4' => (int) '0',
                        'g5' => (int) '0',
                        'g6' => (int) '0',
                        'desc' => "-");
                    $_jsonOutput .= json_encode($wkfapp) . ",";
                }
                $_jsonOutput = '[' . trim($_jsonOutput, ",");
                $_jsonOutput .= ']';
                echo $_jsonOutput;
            } else if ($vwtyp == 1) {
                $total = 500;
                $result = getGradeDist();

                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $strt = strpos($row[0], "(");
                    $ln = strpos($row[0], ")") - $strt - 1;
                    $wkfapp = array(
                        'name' => substr($row[0], $strt + 1, $ln),
                        'g1' => $row[1],
                        'g2' => $row[2],
                        'g3' => (int) '0',
                        'g4' => (int) '0',
                        'g5' => (int) '0',
                        'g6' => (int) '0',
                        'desc' => $row[0]);
                    $_jsonOutput .= json_encode($wkfapp) . ",";
                }
                $_jsonOutput = '[' . trim($_jsonOutput, ",");
                $_jsonOutput .= ']';
                echo $_jsonOutput;
            } else if ($vwtyp == 2) {
                $total = 500;
                $result = getPortDist();

                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $wkfapp = array(
                        'name' => $row[0],
                        'g1' => $row[1],
                        'g2' => $row[2],
                        'g3' => (int) '0',
                        'g4' => (int) '0',
                        'g5' => (int) '0',
                        'g6' => (int) '0',
                        'desc' => "-");
                    $_jsonOutput .= json_encode($wkfapp) . ",";
                }
                $_jsonOutput = '[' . trim($_jsonOutput, ",");
                $_jsonOutput .= ']';
                echo $_jsonOutput;
            } else if ($vwtyp == 3) {
                $total = 500;
                $result = getGSDist();

                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $wkfapp = array(
                        'g1' => (double) $row[0],
                        'desc' => $row[1],
                        'g2' => (int) '2345',
                        'g3' => (int) '0',
                        'g4' => (int) '0',
                        'g5' => (int) '0',
                        'g6' => (int) '0',
                        'name' => "-");
                    $_jsonOutput .= json_encode($wkfapp) . ",";
                }
                $_jsonOutput = '[' . trim($_jsonOutput, ",");
                $_jsonOutput .= ']';
                //var_dump($_jsonOutput);
                echo $_jsonOutput;
            } else if ($vwtyp == 4) {
                $total = 500;
                $result = getMyKPI();

                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $wkfapp = array(
                        'name' => "-",
                        'g1' => (int) $row[0],
                        'g2' => (int) $row[1],
                        'g3' => (int) $row[2],
                        'g4' => (int) $row[3],
                        'g5' => (int) $row[4],
                        'g6' => (int) $row[5],
                        'desc' => "-");
                    $_jsonOutput .= json_encode($wkfapp) . ",";
                }

                $_jsonOutput = '[' . trim($_jsonOutput, ",");
                $_jsonOutput .= ']';
                //var_dump($_jsonOutput);
                echo $_jsonOutput;
            } else if ($vwtyp == 5) {
                //Get Reports Submitted Early
                $total = 500;
                $result = getSbmtdRptsDaysElpsd();
                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $wkfapp = array(
                        'name' => $row[0],
                        'g1' => $row[1],
                        'g2' => $row[2],
                        'g3' => (int) '0',
                        'g4' => (int) '0',
                        'g5' => (int) '0',
                        'g6' => (int) '0',
                        'desc' => $row[0]);
                    $_jsonOutput .= json_encode($wkfapp) . ",";
                }
                $_jsonOutput = '[' . trim($_jsonOutput, ",");
                $_jsonOutput .= ']';
                echo $_jsonOutput;
            } else if ($vwtyp == 6) {
                //Get No. of Reports Submitted
                $total = 500;
                $result = getNoOfSbmtdRpts();
                while ($row = loc_db_fetch_array($result)) {
                    //$chckd = FALSE;
                    $wkfapp = array(
                        'name' => $row[0],
                        'g1' => $row[1],
                        'g2' => (int) '0',
                        'g3' => (int) '0',
                        'g4' => (int) '0',
                        'g5' => (int) '0',
                        'g6' => (int) '0',
                        'desc' => $row[0]);
                    $_jsonOutput .= json_encode($wkfapp) . ",";
                }
                $_jsonOutput = '[' . trim($_jsonOutput, ",");
                $_jsonOutput .= ']';
                echo $_jsonOutput;
            }
        }
    }
}

function getMyKPI() {
    $sqlStr = "select 3, 75, 125, 6000, 5000, 2000";
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getGSDist() {
    $sqlStr = "select 47.55, '2357/4356 Reg. Members'";
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getPortDist() {
    $sqlStr = "select 
(case when (trim(res_address||''||pstl_addrs) != '' AND trim(email) != '' 
AND trim(cntct_no_tel||''||cntct_no_mobl) != '') then 'Grade A' 
when (trim(email) != '' AND trim(cntct_no_tel||''||cntct_no_mobl) != '') then 'Grade B'  
when trim(cntct_no_tel||''||cntct_no_mobl) != '' then 'Grade C'  
when trim(email) != '' then 'Grade D' 
 else 'Grade E'  end) || '-' || count(1) portability1, 
count(1), 1, case when (trim(res_address||''||pstl_addrs) != '' AND trim(email) != '' 
AND trim(cntct_no_tel||''||cntct_no_mobl) != '') then 'Grade A' 
when (trim(email) != '' AND trim(cntct_no_tel||''||cntct_no_mobl) != '') then 'Grade B'  
when trim(cntct_no_tel||''||cntct_no_mobl) != '' then 'Grade C' 
when trim(email) != '' then 'Grade D'  
 else 'Grade E'   end portability 
FROM prs.prsn_names_nos pnn 
left outer join pasn.prsn_prsntyps ppt
 on pnn.person_id = ppt.person_id
 where '' || coalesce(ppt.prsn_type,'-1') = coalesce(NULLIF('',''), '' || coalesce(ppt.prsn_type,'-1')) 
 AND pnn.org_id = " . $_SESSION['ORG_ID'] .
            " group by 4,3";
//Registered Member {:pstntyp}
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getGradeDist() {
    $sqlStr = "
 select 
 (select substring(grade_code_name from 1 for 30) from org.org_grades og where og.grade_id = pg.grade_id) grade, count(1) countt,1    
 from pasn.prsn_grades pg  
 left outer join pasn.prsn_prsntyps ppt
 on (pg.person_id = ppt.person_id
  and now() between to_timestamp(ppt.valid_start_date,'YYYY-MM-DD HH24:MI:SS') 
 AND to_timestamp(ppt.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))
 left outer join prs.prsn_names_nos pnn ON (pnn.person_id  = ppt.person_id) 
 WHERE  ppt.prsn_type ilike 'Registered Member%'
 AND pnn.org_id = " . $_SESSION['ORG_ID'] .
            "AND (coalesce(pg.valid_start_date, to_char((select now()),'YYYY-MM-DD')) is not null 
 and ( pg.valid_end_date is null OR ((SELECT NOW())
  between to_timestamp(pg.valid_start_date,'YYYY-MM-DD HH24:MI:SS') 
  AND to_timestamp(pg.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))
  group by 1,3 Order By 2 DESC LIMIT 10 offset 0";
//Registered Member
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getTechDivDist() {
    $sqlStr = "
        select div_code_name division, 
        count(1) countt, 1, div_code_name  
from pasn.prsn_divs_groups pdg 
inner join org.org_divs_groups odg 
  on pdg.div_id = odg.div_id   
  inner join prs.prsn_names_nos pnn ON (pnn.person_id  = pdg.person_id) 
  inner join pasn.prsn_prsntyps ppt
 on (pnn.person_id = ppt.person_id
  and now() between to_timestamp(ppt.valid_start_date,'YYYY-MM-DD HH24:MI:SS') 
 AND to_timestamp(ppt.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))
 WHERE  ppt.prsn_type ilike '%'
 AND pnn.org_id = " . $_SESSION['ORG_ID'] .
            " AND (coalesce(pdg.valid_start_date, to_char((select now()),'YYYY-MM-DD')) is not null and ( pdg.valid_end_date is null OR ((SELECT NOW())
  between to_timestamp(pdg.valid_start_date,'YYYY-MM-DD HH24:MI:SS') 
  AND to_timestamp(pdg.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))
  AND UPPER(div_code_name) in ('CIVIL','ELECTRICAL/ELECTRONIC','MECH/AGRIC/MARINE','CHEMICAL/MINING') /**/
  AND gst.get_pssbl_val(div_typ_id)='Technical Division'
  group by 4, 3";
//Registered Member
    $result = executeSQLNoParams($sqlStr);
    return $result;
    /* || '-' || count(1) || '' 
      || ' (' || round(((count(1)::numeric/(Select count(1)::numeric
      from pasn.prsn_divs_groups pdg1
      inner join org.org_divs_groups odg1
      on pdg1.div_id = odg1.div_id
      inner join prs.prsn_names_nos pnn1 ON (pnn1.person_id  = pdg1.person_id)
      inner join pasn.prsn_prsntyps ppt1
      on (pnn1.person_id = ppt1.person_id
      and now() between to_timestamp(ppt1.valid_start_date,'YYYY-MM-DD HH24:MI:SS')
      AND to_timestamp(ppt1.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))
      WHERE  ppt1.prsn_type ilike '%'
      AND pnn1.org_id = ".$_SESSION['ORG_ID'].
      " AND (coalesce(pdg1.valid_start_date, to_char((select now()),'YYYY-MM-DD')) is not null
      and ( pdg1.valid_end_date is null OR ((SELECT NOW())
      between to_timestamp(pdg1.valid_start_date,'YYYY-MM-DD HH24:MI:SS')
      AND to_timestamp(pdg1.valid_end_date,'YYYY-MM-DD HH24:MI:SS'))))
      AND UPPER(odg1.div_code_name) in ('CIVIL','ELECTRICAL','MECH/AGRIC','CHEM/MINING')
      AND gst.get_pssbl_val(odg1.div_typ_id)='Technical Division'))*100),2) || '%)' */
}

function getSbmtdRptsDaysElpsd() {
    $sqlStr = "
 select tbl1.* from 
 (select 'PSB1' as name, 19 countt, 1 ordr
 UNION
 select 'PSB2', 2, 2 
 UNION
 select 'PSB3', 1, 3 
 UNION
 select 'PSB4', 8, 4 
 UNION
 select 'PSB5', 17, 5 
 UNION
 select 'PSB6', 9, 6 
 UNION
 select 'PSB7', 0, 7 
 UNION
 select 'PSB8', 5, 8 
 UNION
 select 'PSB9', 15, 9 
 UNION
 select 'PSB10', 20, 10) tbl1 ORDER BY 3 ASC ";
//Registered Member
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function getNoOfSbmtdRpts() {
    $sqlStr = "
 select tbl1.* from 
 (select 'PSB1' as name, 5 countt, 1 ordr
 UNION
 select 'PSB2', 20, 2 
 UNION
 select 'PSB3', 13, 3 
 UNION
 select 'PSB4', 25, 4 
 UNION
 select 'PSB5', 14, 5 
 UNION
 select 'PSB6', 19, 6 
 UNION
 select 'PSB7', 30, 7 
 UNION
 select 'PSB8', 12, 8 
 UNION
 select 'PSB9', 6, 9 
 UNION
 select 'PSB10', 2, 10) tbl1 ORDER BY 3 ASC ";
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

?>
