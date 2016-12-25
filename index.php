<?php

session_start();
//$base_dir = "C:/xampp/htdocs/ghieportal/app_code/";
//$cmnCdePth = ".;C:/xampp/htdocs/ghieportal/app_code/;C:/xampp/php/PEAR";
//$cmnCdePth = ".;/var/www/html/bogportal/app_code/cmncde/;/usr/share/php";
//$base_dir = "/opt/lampp/htdocs/rems_pg/app_code/cmncde/";
//$cmnCdePth = ".;/opt/lampp/htdocs/rems_pg/app_code/cmncde/;/usr/local/src/php-5.6.1/pear";
//$cmnCdePth = ".;c:/php/includes;C:/wamp/www/rem_php/app_code/cmncde/;";
//$directories = array($cmnCdePth);
//set_include_path($cmnCdePth);
header('Expires: Mon, 26 Jul 1990 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

ini_set("display_errors", TRUE);
ini_set("html_errors", TRUE);
require 'app_code/cmncde/connect_pg.php';
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
if (!isset($_SESSION['SESSION_TIMEOUT'])) {
    $_SESSION['SESSION_TIMEOUT'] = get_CurPlcy_SessnTmOut();
}
/**
 * END OF PM
 */
if (isset($_SESSION['LAST_ACTIVITY'])) {
    $sessnTimeOut = floatval($_SESSION['SESSION_TIMEOUT']);
    if ((time() - $_SESSION['LAST_ACTIVITY'] > $sessnTimeOut) && $_SESSION['LGN_NUM'] > 0) {
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
?>
<?php

/*
  if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "") {
  $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  header("HTTP/1.1 301 Moved Permanently");
  header("Location: $redirect");
  }
 */

require 'app_code/cmncde/globals.php';
require 'app_code/cmncde/admin_funcs.php';
require 'loginController.php';

$gDcrpt = isset($_GET['g']) ? cleanInputData($_GET['g']) : '';
$mstChngPwd = isset($_GET['cp']) ? cleanInputData($_GET['cp']) : '';
$screenwdth = isset($_POST['screenwdth']) ? cleanInputData($_POST['screenwdth']) : $_SESSION['SCREEN_WIDTH'];
$_SESSION['SCREEN_WIDTH'] = $screenwdth;
$gUNM = '';
$notAllowed = "";
$error = "";
$qryStr = "";
$type = 0;
$group = 0;
$pgNo = 0;
$usrID = $_SESSION['USRID'];
$usrName = $_SESSION['UNAME'];
$prsnid = $_SESSION['PRSN_ID'];
$lgn_num = $_SESSION['LGN_NUM'];
$orgID = $_SESSION['ORG_ID'];
$orgName = $_SESSION['ORG_NAME'];
$myImgFileName = $_SESSION['FILES_NAME_PRFX'] . '.png';

$formArray = array();
if ($gDcrpt != '') {
    $gDcrpt = decrypt($gDcrpt, $smplTokenWord1);
    $arrayParams = explode("|", $gDcrpt);
    if (count($arrayParams) == 7) {
        $numChars = intval($arrayParams[1]);
        $numChars1 = intval($arrayParams[5]);

        $numTxt = ($arrayParams[0]);
        $numTxt1 = ($arrayParams[6]);

        $expDte = $arrayParams[2];
        if (getDB_Date_time() >= $expDte || strlen($numTxt) != $numChars || strlen($numTxt1) != $numChars1) {
            sessionInvalid();
            exit();
        }
        $qryStr = $arrayParams[3];
        $gUNM = $arrayParams[4];
    } else {
        sessionInvalid();
        exit();
    }
} else if (isset($HTTP_RAW_POST_DATA) && count($_POST) <= 0) {
    $formArray = json_decode($HTTP_RAW_POST_DATA, true);
    //var_dump($formArray);
    $group = isset($formArray['grp']) ? $formArray['grp'] : 0;
    $type = isset($formArray['typ']) ? $formArray['typ'] : 0;
    $qryStr = isset($formArray['q']) ? cleanInputData($formArray['q']) : '';
    $pgNo = isset($formArray['pg']) ? cleanInputData($formArray['pg']) : 0;
} else {
    $group = isset($_POST['grp']) ? cleanInputData($_POST['grp']) : 0;
    $type = isset($_POST['typ']) ? cleanInputData($_POST['typ']) : 0;
    $qryStr = isset($_POST['q']) ? cleanInputData($_POST['q']) : '';
    $pgNo = isset($_POST['pg']) ? cleanInputData($_POST['pg']) : 0;
    if ($mstChngPwd !== "") {
        $qryStr = "changepassword";
    }
}
if ($group > 0 && $type > 0) {
    if ($group == 1) {
        if ($type == 1) {
            require 'app_code/cmncde/rho_shapes.php';
        } else if ($type == 2) {
            require 'app_code/cmncde/rho_headline.php';
        } else if ($type == 3) {
            require 'app_code/cmncde/rho_slogan.php';
        } else if ($type == 4) {
            require 'app_code/cmncde/selfServiceMenu.php';
        } else if ($type == 5) {
            require 'app_code/cmncde/rho_welcome.php';
        } else if ($type == 6) {
            require 'app_code/cmncde/login.php';
        } else if ($type == 7) {
            require 'app_code/cmncde/my_pswd_chnge.php';
        } else if ($type == 8) {
            require 'app_code/cmncde/my_roles.php';
        } else if ($type == 9) {
            require 'app_code/cmncde/rho_header.php';
        } else if ($type == 10) {
            require 'app_code/cmncde/myInbx.php';
        } else if ($type == 11) {
            require 'app_code/cmncde/rho_qry_infos.php';
        } else if ($type == 12) {
            //require 'app_code/cmncde/top_menu.php';
        } else if ($type == 13) {
            require 'app_code/cmncde/dashboard_data.php';
        } else if ($type == 14) {
            require 'app/ux/cmnFileUpload.php';
        } else {
            header('location: index.php');
        }
    } else if ($group == 2) {
        if ($type == 1) {
            require 'app_code/cmncde/lovDialogs.php';
        }
    } else if ($group == 3) {
//System Administration
        if ($type == 1) {
            require 'app_code/sec/sys_admin_intro.php';
        }
    } else if ($group == 4) {
//General Setup
        if ($type == 1) {
            require 'app_code/gst/gst_intro.php';
        }
    } else if ($group == 5) {
//Organisation Setup
        if ($type == 1) {
            require 'app_code/org/org_intro.php';
        }
    } else if ($group == 6) {
//Accounting
        if ($type == 1) {
            require 'app_code/accb/accounting.php';
        }
    } else if ($group == 7) {
//Internal Payments
        if ($type == 1) {
            require 'app_code/pay/int_pymnts_intro.php';
        }
    } else if ($group == 8) {
//Basic Person Data
        if ($type == 1) {
            require 'app_code/prs/prs_intro.php';
        }
    } else if ($group == 9) {
//Reports And Processes        
        if ($type == 1) {
            require 'app_code/rpt/rpts_intro.php';
        }
    } else if ($group == 10) {
//Alerts Manager
        if ($type == 1) {
            require 'app_code/alrt/alrt_intro.php';
        }
    } else if ($group == 11) {
//Workflow Manager
        if ($type == 1) {
            require 'app_code/wkf/wkf_intro.php';
        }
    } else if ($group == 12) {
//Inventory
        if ($type == 1) {
            require 'app_code/inv/inv_intro.php';
        }
    } else if ($group == 13) {
//Projects
        if ($type == 1) {
            require 'app_code/proj/proj_intro.php';
        }
    } else if ($group == 14) {
//var_dump($_POST);
//Clinic/Hospital
        if ($type == 1) {
            require 'app_code/hosp/hosp_mgr.php';
        }
    } else if ($group == 15) {
//var_dump($_POST);
//Academics
        if ($type == 1) {
            require 'app_code/aca/aca_intro.php';
        }
    } else if ($group == 16) {
//var_dump($_POST);
//Events & Attendance
        if ($type == 1) {
            require 'app_code/attn/attn_intro.php';
        }
    } else if ($group == 17) {
//var_dump($_POST);
//Banking/Microfinance
        if ($type == 1) {
            require 'app_code/mcf/mcf_intro.php';
        }
    } else if ($group == 18) {
//var_dump($_POST);
//Hospitality Management
        if ($type == 1) {
            require 'app_code/hotl/hotl_intro.php';
        }
    } else if ($group == 19) {
//var_dump($_POST);
//Self-Service
        if ($type == 1) {
            require 'app_code/self/self_intro.php';
        } else if ($type == 2) {
            require 'app_code/self/my_prsnl_data.php';
//require 'ext-5/index.html';
        } else if ($type == 3) {
            require 'app_code/self/my_intnl_pay.php';
        } else if ($type == 4) {
            require 'app_code/self/my_pay_docs.php';
        } else if ($type == 5) {
            require 'app_code/self/my_htl_books.php';
        } else if ($type == 6) {
            require 'app_code/self/my_evnts_attn.php';
        } else if ($type == 7) {
            require 'app_code/self/my_acdmc_data.php';
        } else if ($type == 8) {
            require 'app_code/self/my_clnc_data.php';
        } else if ($type == 9) {
            require 'app_code/self/my_bank_data.php';
        } else if ($type == 10) {
            require 'app_code/evote/evote_intro.php';
        } else if ($type == 11) {
            require 'app_code/self/self_service_setups.php';
        } else if ($type == 12) {
            require 'app_code/elibry/elibry_intro.php';
        }
    } else if ($group == 20) {
//Basic Person Data
        if ($type == 1) {
            //require 'app_code/epay/epay_intro.php';
        } else if ($type == 2) {
            require 'app_code/epay/lovDialogs.php';
        }
    } else if ($group == 21) {
        //Personalle Data
        if ($type == 1) {
            require 'app_code/prs/my_personal_data.php';
        }
    } else if ($group == 40) {
        //Personalle Data
        if ($type == 1) {
            require 'app_code/cmncde/home.php';
        } else if ($type == 2) {
            require 'app_code/cmncde/myInbx.php';
        } else if ($type == 3) {
            require 'app_code/cmncde/all_notices.php';
        } else if ($type == 4) {
            require 'app_code/cmncde/dashboard_data.php';
        } else if ($type == 5) {
            require 'app_code/cmncde/all_modules_menu.php';
        } else {
            restricted();
        }
    } else {
        header('location: index.php');
    }
    exit();
} else {
    if ($notAllowed == "") {
        if ($lgn_num <= 0) {
            $login_result = "";
            $uname = "";
            $pswd = "";

            if (isset($_POST['err'])) {
                $error = cleanInputData($_POST['err']);
            }

            if (isset($_POST['usrnm']) && isset($_POST['pwd'])) {
                $uname = cleanInputData($_POST['usrnm']);
                $pswd = cleanInputData($_POST['pwd']);
            }

            if ($uname != "" && $pswd != "") {
                $brwsr = getBrowser();
                $macDet = "";
                if (isset($_POST['machdet'])) {
                    $macDet = cleanInputData($_POST['machdet']);
                }
                $machdetail = $macDet . "/" . kh_getUserIP() . "/Browser:" . $brwsr['name'] . " v" . $brwsr['version'] . "/OS:" . $brwsr['platform'] . "/Session ID:" . session_id();
                $msg = "";
                if (getUserID("admin") <= 0) {
                    loadSysAdminMdl();
                }
                checkB4LgnRequireMents();
                $login_result = checkLogin($uname, $pswd, $machdetail, $msg);
                if ($login_result === "select role") {
                    $usrID = $_SESSION['USRID'];
                    $user_Name = $_SESSION['UNAME'];
                    $orgID = $_SESSION['ORG_ID'];
                    $lgn_num = $_SESSION['LGN_NUM'];
                    $ifrmeSrc = $_SESSION['CUR_IFRM_SRC'];
                    if ($lgn_num <= 0) {
                        $_SESSION['ORG_NAME'] = "$app_name";
                    } else {
                        $_SESSION['ORG_NAME'] = getOrgName($orgID);
                    }
                    $org_name = $_SESSION['ORG_NAME'];
                    $ssnRoles = $_SESSION['ROLE_SET_IDS'];
                    $Role_Set_IDs = explode(";", $ssnRoles);
                    $ModuleName = "";
                    echo $login_result;
                    exit();
                } else if ($login_result === "change password" || $_SESSION['MUST_CHNG_PWD'] == "1") {
                    $usrID = $_SESSION['USRID'];
                    $user_Name = $_SESSION['UNAME'];
                    $orgID = $_SESSION['ORG_ID'];
                    $lgn_num = $_SESSION['LGN_NUM'];
                    $ifrmeSrc = $_SESSION['CUR_IFRM_SRC'];

                    if ($lgn_num <= 0) {
                        $_SESSION['ORG_NAME'] = "$app_name";
                    } else {
                        $_SESSION['ORG_NAME'] = getOrgName($orgID);
                    }
                    $org_name = $_SESSION['ORG_NAME'];
                    $ssnRoles = $_SESSION['ROLE_SET_IDS'];
                    $Role_Set_IDs = explode(";", $ssnRoles);
                    $ModuleName = "";
                    echo $login_result;
                    exit();
                } else if ($login_result === "logout") {
                    logoutActions();
                    $error = "Successfully Logged Out";
                    echo $error;
                    exit();
                } else {
                    $error = $login_result;
                    echo $error;
                    exit();
                }
            } else if ($qryStr == "changepassword" || $_SESSION['MUST_CHNG_PWD'] == "1") {
                require 'header.php';
                require 'chngpwd.php';
                exit();
            } else if ($qryStr == "forgotpwd") {
                require 'header.php';
                require 'frgtpwd.php';
                exit();
            } else if ($qryStr == "logout") {
                $error = "";
                require 'header.php';
                require 'login.php';
            } else if ($qryStr == "timeout") {
                logoutActions();
                $error = "Session Timed Out! Please login again!";
                require 'header.php';
                require 'login.php';
            } else {
                $error = "";
                require 'header.php';
                require 'login.php';
            }
        } else {
            if ($qryStr == "logout") {
                logoutActions();
                $error = "Successfully Logged Out";
                require 'header.php';
                require 'login.php';
                exit();
            } else if ($qryStr == "timeout") {
                logoutActions();
                $error = "Session Timed Out! Please login again!";
                require 'header.php';
                require 'login.php';
            } else if ($qryStr == "changepassword" || $_SESSION['MUST_CHNG_PWD'] == "1") {
                require 'header.php';
                require 'chngpwd.php';
                exit();
            } else {
                require 'header.php';
                require 'app.php';
            }
        }
    } else {
        echo "<html>
        <head>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"cmn_scrpts/rho_form.css?v=12\" />        
            </head>
            <body><div id=\"rho_form\" style=\"width: 500px;position: absolute; top:20%; bottom: 20%; left: 20%; right: 20%; margin: auto;\">
            <div class='rho_form44' style=\"font-family: Tahoma, Arial, sans-serif;font-size: 1.3em;
                    background-color:#e3e3e3;border: 1px solid #999;padding:20px 30px 30px 20px;\"> 
            " . $notAllowed . " not Supported! <br/> Please upgrade to the latest version! 
                    <br/> Alternatively, you can download and Install the ff Recommended Browsers...
                    <ul>
                    <li><a href=\"https://www.google.com/chrome/browser/desktop/index.html\">Google Chrome</a></li>
                    <li><a href=\"https://www.mozilla.org/en-US/firefox/new/\">Firefox</a></li>
                    <li><a href=\"index.php\">Or You can click here to Try Again!</a></li>
                    </ul>
                    </div></div></body><html>";
        exit();
    }
}
?>

