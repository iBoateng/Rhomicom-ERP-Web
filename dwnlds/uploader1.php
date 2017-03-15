<?php

session_start();
//$dwnldfile = $_GET['q'];
header('Expires: Mon, 26 Jul 1990 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

ini_set("display_errors", FALSE);
ini_set("html_errors", FALSE);

require '../app_code/cmncde/connect_pg.php';
if (!isset($_SESSION['UNAME'])) {
    $_SESSION['UNAME'] = "";
}
if (!isset($_SESSION['USRID'])) {
    $_SESSION['USRID'] = -1;
}
if (!isset($_SESSION['LGN_NUM'])) {
    $_SESSION['LGN_NUM'] = -1;
}
if (!isset($_SESSION['ORG_NAME'])) {
    $_SESSION['ORG_NAME'] = "";
}
if (!isset($_SESSION['ORG_ID'])) {
    $_SESSION['ORG_ID'] = -1;
}
if (!isset($_SESSION['ROOT_FOLDER'])) {
    $_SESSION['ROOT_FOLDER'] = "";
}
if (!isset($_SESSION['PRV_OFFST'])) {
    $_SESSION['PRV_OFFST'] = 0;
}
if (!isset($_SESSION['FILES_NAME_PRFX'])) {
    $_SESSION['FILES_NAME_PRFX'] = "";
}
if (!isset($_SESSION['ROLE_SET_IDS'])) {
    $_SESSION['ROLE_SET_IDS'] = "";
}

if (!isset($_SESSION['CUR_TAB'])) {
    $_SESSION['CUR_TAB'] = "C1";
}
if (!isset($_SESSION['CUR_RPT_FILES'])) {
    $_SESSION['CUR_RPT_FILES'] = "";
}
if (!isset($_SESSION['CUR_IFRM_SRC'])) {
    $_SESSION['CUR_IFRM_SRC'] = "";
}

if (!isset($_SESSION['CUR_PRSN_ID'])) {
    $_SESSION['CUR_PRSN_ID'] = -1;
}

if (!isset($_SESSION['PRSN_ID'])) {
    $_SESSION['PRSN_ID'] = -1;
}
if (!isset($_SESSION['MUST_CHNG_PWD'])) {
    $_SESSION['MUST_CHNG_PWD'] = "0";
}
if (!isset($_SESSION['PRSN_FNAME'])) {
    $_SESSION['PRSN_FNAME'] = "";
}
/**
 * PROSPECTIVE MEMBER SESSION VARIABLES
 */
if (!isset($_SESSION['UNAMEPM'])) {
    $_SESSION['UNAMEPM'] = "";
}
if (!isset($_SESSION['USRIDPM'])) {
    $_SESSION['USRIDPM'] = -1;
}

if (!isset($_SESSION['PRSN_ID_PM'])) {
    $_SESSION['PRSN_ID_PM'] = -1;
}

if (!isset($_SESSION['PRSN_FNAME_PM'])) {
    $_SESSION['PRSN_FNAME_PM'] = "";
}
if (!isset($_SESSION['SCREEN_WIDTH'])) {
    $_SESSION['SCREEN_WIDTH'] = 0;
}
/**
 * END OF PM
 */
if (isset($_SESSION['LAST_ACTIVITY'])) {
    if ((time() - $_SESSION['LAST_ACTIVITY'] > 1800) && $_SESSION['LGN_NUM'] > 0) {
// last request was more than 50 minates ago
        destroySession();
        if (count($_POST) <= 0) {
            header("Location: index.php");
        } else {
            sessionInvalid();
            exit();
        }
    } else {
        $_SESSION['LAST_ACTIVITY'] = time();
    }
} else {
    $_SESSION['LAST_ACTIVITY'] = time();
}

require '../app_code/cmncde/globals.php';
require '../app_code/cmncde/admin_funcs.php';


$allowed = array('png', 'jpg', 'gif', 'jpeg', 'bmp', 'zip', 'pdf', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'csv');
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if (!in_array(strtolower($extension), $allowed)) {
        echo '[Error Occurred:Unpermitted File Type!]';
        exit();
    }
    $filename = str_replace(" ", "_", basename($_FILES["file"]["name"]));
    $destination_path = getcwd() . DIRECTORY_SEPARATOR . "pem" . DIRECTORY_SEPARATOR;
    $target_path = $destination_path . $filename;
    /*
      if (!file_exists(dirname($target_path))) {
      mkdir('path/to/directory', 0777, true);
      }
     */

    $res = move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
    if ($res) {
        echo $app_url . 'dwnlds/pem/' . $filename;
        exit();
    }
}
echo '[Error:Unknown]';
exit();
?>