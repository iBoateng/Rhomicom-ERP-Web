<?php

$mdlNm = "Self Service";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Self-Service",
    /* 1 */ "View Leave of Absence", "View Internal Payments",
    /* 3 */ "View Events/Attendances", "View Elections",
    /* 5 */ "View Forums", "View E-Library", "View E-Learning",
    /* 8 */ "View Elections Administration", "View Personal Records Administration", "View Forum Administration",
    /* 11 */ "View Self-Service Administration",
    /* 12 */ "View SQL", "View Record History",
    /* 14 */ "Administer Elections", "Administer Leave",
    /* 16 */ "Administer Self-Service", "Make Requests for Others", "Administer Other's Inbox");


if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0) {
        $canview = test_prmssns($dfltPrvldgs[0], $mdlNm) || test_prmssns("View System Administration", "System Administration");
        $menuItems = array("Home Page", "My Inbox/ Worklist", /* "My Dashboard", */
            "Main Dashboard", "Personal Records", "Bills/Payments", "Elections Centre", "All Articles and Notices",
            "Change Password", "Logout", "Comments/ Feedback"/* , $about_app */);
        $menuImages = array("Home.png", "openfileicon.png", /* "dashboard220.png", */ "statistics_32.png", //"ezwich.png"
            "person.png", "pay.png", "election.png", "Notebook.png", "change-password.png", "logout.png",
            "info.png"/* , $app_image */);
        $pageHtmlID = "welcomeTabPage";
        $cntent = "<div style=\"margin-bottom:1px;\">";
        $grpcntr = 0;
        for ($i = 0; $i < count($menuItems); $i++) {
            $No = $i; // + 1;
            if ($grpcntr == 0) {
                $cntent.= "<div style=\"float:none;\">"
                        . "<ul class=\"no_bullet\" style=\"float:none;\">";
            }
            $width = 95;
            $height = 90;
            $extrWdth = 0;
            $extrHgth = 0;

            if ($i == 1) {
                $width = 110;
            } else if ($i == 2) {
                $width = 105;
            } else if ($i == 4) {
                $width = 110;
            } else if ($i == 5) {
                $width = 110;
            } else if ($i == 7) {
                $width = 80;
            } else if ($i == 8) {
                $width = 85;
            } else if ($i == 9) {
                $width = 90;
            }

            if ($screenwdth <= 800) {
                $introWdth = 500;
                $subArtWdth = 500;
            } else {
                $introWdth = ceil($screenwdth * 0.77);
                $subArtWdth = ceil(($screenwdth * 0.77) / 2.0) - 3;
                $extrWdth = ceil(($screenwdth * 0.69) / 10) - 95;
                $extrHgth = ceil(($screenwdth * 0.70) / 10) - 90;
                $width += $extrWdth;
                $height += $extrHgth;
                if ($height < 90) {
                    $height = 90;
                }
            }

            $cntent.= "<li class=\"leaf\" style=\"margin:1px 4px 1px 0px;padding:1px;\">"
                    . "<a href=\"javascript: showPageDetails1('$pageHtmlID', '$menuItems[$i]');\" class=\"x-btn x-unselectable x-btn-default-large\" "
                    . "style=\"padding:0px;height:" . $height . "px;width:" . $width . "px;\" "
                    . "hidefocus=\"on\" unselectable=\"on\" id=\"loadRolesButton\" tabindex=\"0\" componentid=\"loadRolesButton\">"
                    . "<span id=\"loadRolesButton-btnWrap\" data-ref=\"btnWrap\" role=\"presentation\" unselectable=\"on\" "
                    . " class=\"x-btn-wrap x-btn-wrap-default-large \"><span id=\"loadRolesButton-btnEl\" "
                    . "data-ref=\"btnEl\" role=\"presentation\" unselectable=\"on\" style=\"\" "
                    . "class=\"x-btn-button x-btn-button-default-large x-btn-text  x-btn-icon x-btn-icon-top x-btn-button-center \">"
                    . "<span id=\"loadRolesButton-btnIconEl\" data-ref=\"btnIconEl\" role=\"presentation\" unselectable=\"on\" "
                    . "class=\"x-btn-icon-el x-btn-icon-el-default-large iconButton \" "
                    . "style=\"background-image:url(cmn_images/$menuImages[$i]);\">&nbsp;</span>"
                    . "<span id=\"loadRolesButton-btnInnerEl\" style=\"white-space: normal;overflow:hidden;\" "
                    . "data-ref=\"btnInnerEl\" unselectable=\"on\" class=\"x-btn-inner x-btn-inner-default-large\">";
            if ($i == 9) {
                $cntent.= ($menuItems[$i]);
            } else {
                $cntent.= strtoupper($menuItems[$i]);
            }
            $cntent.= "</span></span></span></a>"
                    . "</li>";
            if ($grpcntr == 9 || $i == (count($menuItems) - 1)) {
                $cntent.= "</ul>"
                        . "</div>";
                $grpcntr = 0;
            } else {
                $grpcntr = $grpcntr + 1;
            }
        }

        $cntent.= "</div>";

        $introMsg = "<div class=\"rho_form1\" style=\"max-width:{:introWdth}px;font-size:12px;font-family:Tahoma !important; padding:5px;padding-left:10px;\">"
                . ("Welcome ") . "<span style=\"font-weight:bold;font-size:14px;color:blue;text-shadow: 0px 1px #ccccff;\">" . strtoupper($_SESSION['PRSN_FNAME']) .
                "</span>" . (" to the " . $app_name . "!") . " You have " . "<span> "
                . "<a style=\"font-weight:bold;font-size:14px;color:red;text-shadow: 0px 1px #ffcccc;text-decoration:underline;\" "
                . "href=\"javascript: showPageDetails1('welcomeTabPage', 'My Inbox/ Worklist');\">"
                . get_MyActiveInbxTtls() . " Notification(s)</a></span>" . " pending your action!</div>";

        $subHeader = "<div class=\"rho_form1\" style=\"max-width:{:introWdth}px;font-family:Tahoma !important; padding:5px;padding-left:10px;\">
                               <span style=\"font-weight:bold;color:green;text-shadow: 0px 0px #ddd;font-size:12px;\">"
                . "<a href=\"javascript: showArticleDetails(-1,'Notices/Announcements');\">NOTICES & ANNOUNCEMENTS</a>|"
                . "<a href=\"javascript: showArticleDetails(-1,'Other Articles');\">ARTICLES</a>|"
                . "<a href=\"javascript: showArticleDetails(-1,'Write-Ups/Research Papers');\">WRITE-UPS & RESEARCH PAPERS</a>|"
                . "<a href=\"javascript: showArticleDetails(-1,'Operational Manuals');\">OPERATIONAL MANUALS</a>|"
                . "<a class=\"x-btn-default-small\" style=\"color:#fff;text-decoration:none;font-weight:normal !important;height:22px !important;margin-top:5px !important;\" "
                . "href=\"javascript: showArticleDetails(-1,'All');\">ALL ARTICLES</a>
                               </span></div>";

        $artclMsgID = getGnrlRecID2("self.self_articles", "article_header", "article_id", "INTRODUCTION TO THE PORTAL");
        /*  */
        if ($artclMsgID <= 0) {
            $artBody = $introToPrtlArtBody;
            createArticle("Welcome Message", "INTRODUCTION TO THE PORTAL", "javascript: showArticleDetails({:articleID},'Welcome Message');", $artBody, "1", getDB_Date_time(), "System Administrator", $admin_email, -1);
        }
        $artclMsgID = getGnrlRecID2("self.self_articles", "article_header", "article_id", "LATEST NEWS AND HIGHLIGHTS");

        if ($artclMsgID <= 0) {
            $artBody = $ltstNewArtBody;
            createArticle("Latest News", "LATEST NEWS AND HIGHLIGHTS", "javascript: showArticleDetails({:articleID},'Latest News');", $artBody, "1", getDB_Date_time(), "System Administrator", $admin_email, -1);
        }

        $artclMsgID = getGnrlRecID2("self.self_articles", "article_header", "article_id", "USEFUL QUICK LINKS & RESOURCES");
        if ($artclMsgID <= 0) {
            $artBody = $usefulLnksArtBody;
            createArticle("Useful Links", "USEFUL QUICK LINKS & RESOURCES", "javascript: showArticleDetails({:articleID},'Useful Links');", $artBody, "1", getDB_Date_time(), "System Administrator", $admin_email, -1);
        }

        $artclMsgID = getGnrlRecID2("self.self_articles", "article_header", "article_id", "ABOUT ORGANISATION/INSTITUTION");
        if ($artclMsgID <= 0) {
            $artBody = "<div class=\"rho_form1\" style=\"float:left;padding-left:20px;margin:5px;max-width:1020px;min-height:170px;line-height: 162%;font-family:Arial !important;font-size:13px !important;\">
                " . $aboutRho . "</div>";
            createArticle("About Organisation", "ABOUT ORGANISATION/INSTITUTION", "javascript: showArticleDetails({:articleID},'About Organisation');", $artBody, "1", getDB_Date_time(), "System Administrator", $admin_email, -1);
        }

        $welcomID = getLtstArticleID("Welcome Message");
        $wMsg = getArticleBody($welcomID);
        $readMore = "...<a class=\"x-btn-default-small\" style=\"color:#fff;text-decoration:none;font-weight:normal !important;height:22px !important;margin-top:5px !important;\" "
                . "href=\"javascript: showArticleDetails(" . $welcomID . ",'All');\">Read More...</a>";
        //echo get_string_between($wMsg, "{:RMS}", "{:RME}");
        $welcomBody = str_replace("{:RMS}" . get_string_between($wMsg, "{:RMS}", "{:RME}") . "{:RME}", $readMore, $wMsg);

        $welcomeMsg = "<div style=\"max-width:100%;max-height:100%;\">" . str_replace("{:introWdth}", $introWdth, str_replace("{:subArtWdth}", $subArtWdth, $cntent . $introMsg
                                . $welcomBody
                                . getArticleBody(getLtstArticleID("Latest News"))
                                . getArticleBody(getLtstArticleID("Useful Links"))
                                . $subHeader)) . "</div>";

        $qryStr = "";
        if (isset($_POST['q'])) {
            $qryStr = $_POST['q'];
        }
        $articleID = -1;
        if (isset($_POST['articleID'])) {
            $articleID = $_POST['articleID'];
        }

        if ($qryStr == "AboutRho") {
            echo str_replace("{:introWdth}", $introWdth, str_replace("{:subArtWdth}", $subArtWdth, $aboutRho));
        } else if ($qryStr == "AboutOrg") {
            $outptCntnt = str_replace("rho_form1", "rho_form21312", str_replace("{:RMS}", "", str_replace("{:RME}", "", getArticleBody(getLtstArticleID("About Organisation")))));
            //$outptCntnt .= "</div>";
            echo str_replace("{:introWdth}", $introWdth, str_replace("{:subArtWdth}", $subArtWdth, $outptCntnt));
        } elseif ($qryStr == "WelcomeMsg") {
            echo $welcomeMsg;
        } elseif ($qryStr != "view" && $qryStr != "" && $qryStr != "AllModules" && $qryStr != "HelpMenu") {
            if ($articleID > 0) {
                $outptCntnt = "<div class=\"rho_form1\" style=\"padding:20px;margin:5px !important;\">".str_replace("rho_form1", "rho_form21312", str_replace("{:RMS}", "", str_replace("{:RME}", "", getArticleBody($articleID))));
                $outptCntnt .= "</div>";
                echo str_replace("{:introWdth}", $introWdth, str_replace("{:subArtWdth}", $subArtWdth, $outptCntnt));
                if (getArticleHitID($articleID) <= 0) {
                    createArticleHit($articleID);
                }
            }
        } else {
            if ($canview == FALSE) {
                echo json_encode(array('success' => FALSE, 'error' => null,
                    'results' => "null"));
                exit();
            }
            if ($qryStr == "HelpMenu") {
                $menus = array();
                $childMenus = array();
                $menuItems = array("Self-Service", "My Account", "Administration", "About Rhomicom");
                $adminMenus = array('System Administration', 'Organisation Setup', 'General Setup', 'Workflow Administration');
                $selfSrvcMenus = array("Notifications", "Change Records", "Submit Payment",
                    "Grade Progression", "E-Voting", "E-Library", "Forum", "Run Reports");
                $myAccntMenus = array("Change Password", "Roles/Priviledges", "Send Feedback", "Log-Out");

                for ($i = 0; $i < count($menuItems); $i++) {
                    $childMenus = array();
                    $childMenu = array();
                    /* if ($i >= 5 && $i <= 10) {
                      continue;
                      } */
                    if ($menuItems[$i] == "Administration") {
                        $isadmn = test_prmssns("View System Administration", "System Administration");
                        for ($j = 0; $j < count($adminMenus); $j++) {
                            if ($isadmn == TRUE) {
                                $childMenu = array(
                                    'text' => ($adminMenus[$j]),
                                    "results" => "null");
                                $childMenus[] = $childMenu;
                            }
                        }
                        if (count($childMenus) > 0) {
                            $menu = array(
                                'text' => ($menuItems[$i]),
                                'results' => $childMenus);
                            $menus[] = $menu;
                        }
                    } elseif ($menuItems[$i] == "Self-Service") {
                        $cnVw = TRUE;
                        for ($j = 0; $j < count($selfSrvcMenus); $j++) {
                            if ($cnVw == TRUE) {
                                $childMenu = array(
                                    'text' => ($selfSrvcMenus[$j]),
                                    "results" => "null");
                                $childMenus[] = $childMenu;
                            }
                        }
                        if (count($childMenus) > 0) {
                            $menu = array(
                                'text' => ($menuItems[$i]),
                                'results' => $childMenus);
                            $menus[] = $menu;
                        }
                    } elseif ($menuItems[$i] == "My Account") {
                        $cnVw = TRUE;
                        for ($j = 0; $j < count($myAccntMenus); $j++) {
                            if ($cnVw == TRUE) {
                                $childMenu = array(
                                    'text' => ($myAccntMenus[$j]),
                                    "results" => "null");
                                $childMenus[] = $childMenu;
                            }
                        }
                        if (count($childMenus) > 0) {
                            $menu = array(
                                'text' => ($menuItems[$i]),
                                'results' => $childMenus);
                            $menus[] = $menu;
                        }
                    } elseif ($menuItems[$i] == "About Rhomicom" && $showAboutRho == "1") {
                        $cnVw = TRUE;
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    }
                }
                //var_dump($menus);
                echo json_encode(array('success' => true, 'error' => null,
                    'results' => $menus));
            } else if ($qryStr == "AllModules") {
                $menus = array();
                $childMenus = array();
                $menuItems = array("Accounting", "Internal Payments", "Basic Person Data", "Stores/Inventory",
                    "Clinic/Hospital", "Learning/Performance", "Events and Attendance"
                    , "Banking/Micro-Finance", "Hospitality Management", "Project Management",
                    "Visits/Appointments", "Administration");
                $adminMenus = array('System Administration', 'Organisation Setup', 'Value Lists Setup', 'Workflow Administration');
//                $accountingMenus = array("Introduction");
//                $intrnlPayMenus = array("Introduction");
//
//                $prsnMenus = array("Introduction");
//                $invMenus = array("Introduction");
//                $clinicMenus = array("Introduction");
//                $acaMenus = array("Introduction");
//                $attnMenus = array("Introduction");
//                $mcfMenus = array("Introduction");
//                $hotlMenus = array("Introduction");
//                $projMenus = array("Introduction");
//                $appntMenus = array("Introduction");

                for ($i = 0; $i < count($menuItems); $i++) {
                    $childMenus = array();
                    $childMenu = array();
                    /* if ($i >= 5 && $i <= 10) {
                      continue;
                      } */
                    if ($menuItems[$i] == "Administration") {
                        $isadmn = test_prmssns("View System Administration", "System Administration");
                        for ($j = 0; $j < count($adminMenus); $j++) {
//$isleaf = TRUE;
                            if ($isadmn == TRUE) {
                                $childMenu = array(
                                    'text' => ($adminMenus[$j]),
                                    "results" => "null");
                                $childMenus[] = $childMenu;
                            }
                        }
                        if (count($childMenus) > 0) {
                            $menu = array(
                                'text' => ($menuItems[$i]),
                                'results' => $childMenus);
                            $menus[] = $menu;
                        }
                    } elseif ($menuItems[$i] == "Accounting") {
                        $cnVw = test_prmssns("View Accounting", "Accounting");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Internal Payments") {
                        $cnVw = test_prmssns("View Internal Payments", "Internal Payments");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Basic Person Data") {
                        $cnVw = test_prmssns("View Basic Person Data", "Basic Person Data");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Stores/Inventory") {
                        $cnVw = test_prmssns("View Inventory Manager", "Stores And Inventory Manager");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Clinic/Hospital") {
                        $cnVw = test_prmssns("View Visits & Appointments", "Clinic/Hospital");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Learning/Performance") {
                        $cnVw = test_prmssns("View Learning/Performance Management", "Learning/Performance Management");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Events and Attendance") {
                        $cnVw = test_prmssns("View Events And Attendance", "Events And Attendance");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Banking/Micro-Finance") {
                        $cnVw = test_prmssns("View Banking/Micro-Finance", "Banking/Micro-Finance");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Hospitality Management") {
                        $cnVw = test_prmssns("View Hospitality Manager", "Hospitality Management");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Project Management") {
                        $cnVw = test_prmssns("View Project Management", "Project Management");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    } elseif ($menuItems[$i] == "Appointments Management") {
                        $cnVw = test_prmssns("View Visits and Appointment", "Visits And Appointment");
                        if ($cnVw == TRUE) {
                            $childMenu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $childMenu;
                        }
                    }
                }
                //var_dump($menus);
                echo json_encode(array('success' => true, 'error' => null,
                    'results' => $menus));
            } else {
                $menus = array();
                $childMenus = array();
                $menuItems = array(
                    'Home Page', 'Log-Out', /* 'My Dashboard', */ 'Main Dashboard', 'Inbox/Worklist',
                    /* 'PSB Forms', */ 'Reports & Dashboards', 'Self-Service Items', "e-Systems",
                    'My Account');
                //, 'Leave of Absence'
                $slfSrvcsMenus = array('Personal Records', 'Bills/Payments', 'Events/Attendances', 'Forums');
                $eSysMenus = array('e-Voting', 'e-Library', 'e-Learning');
                $accountMenus = array('Log-Out', 'Roles/Priviledges', 'Change My Password', 'Comments/Feedback');

                for ($i = 0; $i < count($menuItems); $i++) {
                    $childMenus = array();
                    $childMenu = array();
                    if ($menuItems[$i] == "My Account") {
                        for ($j = 0; $j < count($accountMenus); $j++) {
                            $childMenu = array(
                                'text' => ($accountMenus[$j]),
                                "results" => "null");
                            $childMenus[] = $childMenu;
                        }
                        if ($canview == TRUE) {
                            $menu = array(
                                'text' => ($menuItems[$i] . " (" . strtoupper($_SESSION['UNAME']) . ")"),
                                'results' => $childMenus);
                            $menus[] = $menu;
                        }
                    } else if ($menuItems[$i] == "Self-Service Items") {
                        for ($j = 0; $j < count($slfSrvcsMenus); $j++) {
                            $isallwd = $canview;
                            if ($j >= 1 && $j <= 2) {
                                $isallwd = test_prmssns($dfltPrvldgs[$j + 1], $mdlNm);
                            } else if ($j >= 3) {
                                $isallwd = test_prmssns($dfltPrvldgs[$j + 2], $mdlNm);
                            }
                            $childMenu = array(
                                'text' => ($slfSrvcsMenus[$j]),
                                "results" => "null");
                            if ($isallwd == TRUE) {
                                $childMenus[] = $childMenu;
                            }
                        }
                        if ($canview == TRUE) {
                            $menu = array(
                                'text' => ($menuItems[$i]),
                                'results' => $childMenus);
                            $menus[] = $menu;
                        }
                    } else if ($menuItems[$i] == "e-Systems") {
                        for ($j = 0; $j < count($eSysMenus); $j++) {
                            $isallwd = $canview;
                            if ($j == 0) {
                                $isallwd = test_prmssns($dfltPrvldgs[$j + 4], $mdlNm);
                            } else if ($j >= 1) {
                                $isallwd = test_prmssns($dfltPrvldgs[$j + 5], $mdlNm);
                            }
                            $childMenu = array(
                                'text' => ($eSysMenus[$j]),
                                "results" => "null");
                            if ($isallwd == TRUE) {
                                $childMenus[] = $childMenu;
                            }
                        }
                        if ($canview == TRUE) {
                            $menu = array(
                                'text' => ($menuItems[$i]),
                                'results' => $childMenus);
                            $menus[] = $menu;
                        }
                    } else {
                        $isallwd = $canview;
                        if ($i == 5) {
                            $isallwd = $canview; //test_prmssns($dfltPrvldgs[$j], $mdlNm);
                        }
                        if ($isallwd == TRUE) {
                            $menu = array(
                                'text' => ($menuItems[$i]),
                                "results" => "null");
                            $menus[] = $menu;
                        }
                    }
                }

                echo json_encode(array('success' => true, 'error' => null,
                    'results' => $menus));
            }
        }
    }
}

function getLtstArticleID($articleCtgry) {
    $sqlStr = "select article_id from self.self_articles "
            . "where is_published='1' and (now() >= to_timestamp(publishing_date,'YYYY-MM-DD HH24:MI:SS')) "
            . "and article_category = '" . loc_db_escape_string($articleCtgry)
            . "' ORDER BY publishing_date DESC LIMIT 1 OFFSET 0";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function getArticleBody($articleID) {
    $sqlStr = "select article_body from self.self_articles where article_id = " . $articleID;
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        $artBody = str_replace("{:articleID}", $articleID, $row[0]);
        return $artBody;
    }
    return "";
}

function getArticleHeaderUrl($articleID) {
    $sqlStr = "select header_url from self.self_articles where article_id = " . $articleID;
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function getArticleHeader($articleID) {
    $sqlStr = "select article_header from self.self_articles where article_id = " . $articleID;
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        $hdrUrl = str_replace("{:articleID}", $articleID, getArticleHeaderUrl($articleID));
        if ($hdrUrl == "") {
            return "$row[0]";
        } else {
            return "<a href=\"" . $hdrUrl . "\">" . $row[0] . "</a>";
        }
    }
    return "";
}

function getArticleHitID($artclID) {
    global $usrID;
    $sqlStr = "select article_hit_id from self.self_articles_hits "
            . "where created_by = " . $usrID . " and article_id = " . $artclID;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function createArticleHit($artclID) {
    global $usrID;
    global $lgn_num;

    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_articles_hits(
            article_id, created_by, creation_date, login_number) VALUES ("
            . loc_db_escape_string($artclID) . ", "
            . $usrID . ", '" . $dateStr . "', " . $lgn_num . ")";
    execUpdtInsSQL($insSQL);
}

function createArticle($artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $authorNm, $authorEmail, $authorID) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_articles(
            article_category, article_header, article_body, header_url, 
            is_published, publishing_date, created_by, creation_date, last_update_by, 
            last_update_date, author_name, author_email, author_prsn_id) VALUES ("
            . "'" . loc_db_escape_string($artclCatgry)
            . "', '" . loc_db_escape_string($artTitle)
            . "', '" . loc_db_escape_string($artBody)
            . "', '" . loc_db_escape_string($hdrURL)
            . "', '" . loc_db_escape_string($isPblshed)
            . "', '" . loc_db_escape_string($datePublished)
            . "', " . $usrID . ", '" . $dateStr . "', " . $usrID . ", '" . $dateStr
            . "', '" . loc_db_escape_string($authorNm)
            . "', '" . loc_db_escape_string($authorEmail)
            . "', " . loc_db_escape_string($authorID) . ")";
    execUpdtInsSQL($insSQL);
}

function updateArticle($articleID, $artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $authorNm, $authorEmail, $authorID) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $insSQL = "UPDATE self.self_articles SET 
            article_category='" . loc_db_escape_string($artclCatgry)
            . "', article_header='" . loc_db_escape_string($artTitle) .
            "', article_body='" . loc_db_escape_string($artBody) .
            "', header_url='" . loc_db_escape_string($hdrURL) .
            "', is_published='" . loc_db_escape_string($isPblshed) .
            "' , publishing_date='" . loc_db_escape_string($datePublished)
            . "', author_name = '" . loc_db_escape_string($authorNm)
            . "', author_email = '" . loc_db_escape_string($authorEmail)
            . "', author_prsn_id = " . loc_db_escape_string($authorID)
            . ", last_update_by=" . $usrID .
            " , last_update_date='" . loc_db_escape_string($dateStr) .
            "'   WHERE article_id = " . $articleID;
    execUpdtInsSQL($insSQL);
}

?>