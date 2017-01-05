<?php

$page_title = "Rhomicom Systems Tech. Ltd. - Partnership Portal";
$radomNo = rand(0, 999999999);
$themeType = "ext-theme-crisp";
$base_dir = "";
$year = date('Y');
$fulldte = date('d-M-Y H:i:s');
$app_url = "http://192.168.56.250/rho_erp/";
$admin_email = "info@rhomicom.com";
$smplPwd = "AoP12@34";
$jsCssFileVrsn = "1015";
//More than 62 Characters Recommended
$smplTokenWord = "eRRTRhbnsdGeneral Key for Rhomi|com Systems "
        . "Tech. !Ltd Enterpise/Organization @763542orbjkasdbhi68103weuikfjnsdf";
$smplTokenWord1 = "xewe19fs58rte21This is a General Key for Rhomi|com Systems "
        . "Tech. !Ltd Web/Mobile Portal @7612364kjebdfjwegyr78236429orbjkasdbhi";
$ModuleName = "";
$database = "ecog_live";
$db_folder = "ecng";
$script_folder = "scripts7";
$base_folder = "";
$fldrPrfx = '/var/www/html/rho_erp/';
//$tmpDest = 'C:\\wamp\\www\\portal\\dwnlds\\ghie_test\\Person\\Request\\';
$tmpDest = 'dwnlds/' . $db_folder . '/Person/Request/'; ///var/www/html/portal/
//$prsnDocDest = 'dwnlds/' . $db_folder . '/PrsnDoc/';      
$pemDest = 'dwnlds/' . $db_folder . '/Person/'; ///var/www/html/portal/
//$dest = "dwnlds/$db_folder/Person/";
//$base_dir = "C:/xampp/htdocs/rems_pg/app_code/cmncde/";
//$ftp_base_db_fldr = "/home/oracle/Databases/test_database";
$ftp_base_db_fldr = "/home/portaladmin/" . $db_folder; //"/home/rhoportal/ghie_ftp/" . $db_folder;
$db_pwd = 'Password1';
$db_usr = "postgres";
$port = "5432";
$host = "localhost";
$database_type = "PostgreSQL";
$database_Version = "9.3";
$app_name = "Rhomicom Systems Tech. Ltd.";
$app_version = "V1 P24";
$app_org = "Rhomicom Systems Tech. Ltd";
$app_cstmr = "Rhomicom Systems Tech. Ltd."; //Clients Name
$app_cstmr_url = "http://www.rhomicom.com";
$app_slogan = "Building Dreams";
$app_image = "3.png";
$app_image1 = "3.png";
$lgn_image = "data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="; /*cmn_images/bkg4.jpeg*/
$app_favicon = "Icon.ico";
$about_app = "About Rhomicom";
$about_url = "http://www.rhomicom.com";
$bckcolors = "background-repeat: repeat;background-color: #336578 !important;background-image:url('cmn_images/bkg5.jpeg'); background-size:100% 100%;";
$bckcolorsChngPwd = "background-color: #FFFFFF !important;background: url('cmn_images/bkg5.jpeg') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;";
$bckcolors_home = "background-repeat: repeat;background-color: #003245 !important;background-size:100% 100%;";
$bckcolorOnly = "#00779D";
$bckcolorshv = "background-color: #5a8f9d !important;"; //#00AACF
$forecolors = "color:#FFFFFF !important;";
$bckcolors1 = "#FFF";
$bckcolors2 = "background-color: #00779D !important;";
$breadCrmbBckclr = "
    border: 1px solid #336578;
    background-color: #003245;
    background-image: -moz-linear-gradient(top, #336578, #003245);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#336578), to(#003245));
    background-image: -webkit-linear-gradient(top, #336578, #003245);
    background-image: -o-linear-gradient(top, #336578, #003245);
    background-image: linear-gradient(to bottom, #336578, #003245);
    filter: progid:dximagetransform.microsoft.gradient(startColorstr='#336578', endColorstr='#003245', GradientType=0);";

$loginPgNotice = "<p>Rhomicom Head Quarters, Achimota-ABC, Accra-Ghana</p>";
$goBackButtonMsg = "Go Back to Rhomicom Website";
$placeHolder1 = "Username or ID No.";
$loginTitle = "LOGIN TO THE PARTNERSHIP PORTAL";
$showAboutRho = "0";
$introWdth = 1050;
$subArtWdth = 524;
$introToPrtlArtBody = "<div class=\"rho_form1\" style=\"max-width:{:introWdth}px;font-family:Arial !important; padding-left:20px\">
                    <h3><a href=\"javascript: showNoticeDetails({:articleID},'Notices/Announcements');\" style=\"font-weight:bold;text-decoration:underline;\">INTRODUCTION TO THE PORTAL</a></h3>
                                <p style=\"line-height: 162%;\">
                                <a href=\"$app_cstmr_url\" target=\"_blank\">
                                <img style=\"float:right; height:125px; margin-top:-5px; margin-left:10px;\" alt=\"MEMBERS\" src=\"cmn_images/members.png\" >
                                </a>
                                <a href=\"$app_cstmr_url\" target=\"_blank\">
                                <img style=\"float:left; height:125px;  margin-top:-5px;margin-right:1px;\" alt=\"ORG LOGO\" src=\"cmn_images/3.png\" />
                                </a>
                                This is the Information Resource Centre for all Members of the " . $app_cstmr . ". 
                                It is the central depot for all Notices, Announcements, Notices and Research Papers. A member who logs in can view all directly Related Records held by the Institution.
                                Course Bills and Dues Payments can be checked from here.
                                CPD Points, Examination Scores as well as all other Information on Seminars and Workshops attended are available here. 
                                Annual dues subscriptions can be paid to designated banks and the pay-in-slip submitted on this platform. 
                                Voting and Checking of Election Results can all be done from here...{:RMS} <br/>There is also a live and vibrant forum here where members can share knowledge
            and expertise on areas of importance. Notices and research papers can be
            submitted to the Institution via this platform as well.{:RME}</p></div>";
$ltstNewArtBody = "<div class=\"rho_form1\" style=\"float:left;padding-left:20px;margin:5px;max-width:{:subArtWdth}px;min-height:170px;line-height: 162%;font-family:Arial !important;font-size:13px !important;\">
                                <h3><a href=\"javascript: showNoticeDetails({:articleID},'Latest News');\" style=\"font-weight:bold;text-decoration:underline;\">LATEST NEWS AND HIGHLIGHTS</a></h3>
                                <ul style=\"list-style-image: url(cmn_images/rho_arrow2.png);list-style-position:outside;padding-left:40px;\">
                                <li style=\"list-style-image: url(cmn_images/new.gif) !important;\"><a href=\"#\">User friendly Interface.</a></li>
                                <li>It can run on a variety of computer hardware and network configuration.</li>
                                <li>It employs a centralized robust database as a repository of information.</li>
                                <li>Data Import/Export to Excel and Word.</li>
                                <li>Supports multiple users.</li>
                                </ul>
                                </div>";
$usefulLnksArtBody = "<div class=\"rho_form1\" style=\"float:left;padding-left:20px;margin:5px;max-width:{:subArtWdth}px;min-height:170px;line-height: 162%;font-family:Arial !important;font-size:13px !important;\">
                                <h3><a href=\"javascript: showNoticeDetails({:articleID},'Useful Links');\" style=\"font-weight:bold;text-decoration:underline;\">USEFUL QUICK LINKS & RESOURCES</a></h3>
                                <ul style=\"list-style-image: url(cmn_images/rho_arrow2.png);list-style-position:outside;list-style-type:circle;padding-left:40px;\">
                                <li style=\"list-style-image: url(cmn_images/new.gif) !important;\">Database backup and restore from application.</li>
                                <li>Robust application and information security management system.</li>
                                <li>In-built Templates for performing common tasks.</li>
                                <li>Easily Customized and Expandable to meet specific business needs</li>
                                <li>Display reports in Word, Html and PDF formats.</li>
                                </ul>
                        </div>";

$aboutRho = "
    <div id=\"rho_form\" style=\"min-height:477px;max-width:{:introWdth}px;font-family:Tahoma !important;\"> 
<fieldset style=\"padding:5px;\"><h2 style=\"padding-left:25px;\">
Welcome to the Rhomicom Enterprise Management System Suite of Applications/Solutions!</h2>
<div class=\"rho-postcontent rho-postcontent-0 clearfix\">
<div style=\"float:left;padding:1px;margin-bottom:5px;\"><div style=\"float:left\">
<p>
<a href=\"$about_url\" target=\"_blank\">
<img style=\"float:right; height:100px; margin-left:10px;\" alt=\"RHOMICOM LOGO\" src=\"cmn_images/rho.png\" >
</a>
<a href=\"$about_url\" target=\"_blank\">
<img style=\"float:left; height:100px; margin-right:1px;\" alt=\"POSTGRE LOGO\" src=\"cmn_images/investor-icon.png\" />
</a>
Rhomicom has developed an Enterprise Resource Planning (ERP) System which automates
the management of information across an entire organization and facilitates information
flow between all business functions inside the organization. The ERP System is a
suite of the following applications: Organization Manager, Personnel Manager, Internal
Payments (Payroll/Dues & Contributions) Manager, Reports And Processes Manager,
Finance/Accounting Manager, Procurement Manager and Stores And Inventory Manager. This software
is user friendly, can be used by persons with little or no IT background after a
short training and also supports the five (5) characteristics of a Management Information
System which are: Timeliness, Accuracy, Consistency, Completeness and Relevance.
</p></div>
<div class=\"rho_form1\" style=\"float:left;padding-left:10px;padding-bottom:5px;margin:5px;max-width:49%;min-height:170px;background-color:<?php echo $bckcolors1; ?>;\">
<h3>&nbsp;&nbsp;&nbsp;KEY FEATURES OF OUR ERP SYSTEM:</h3>
<ul style=\"list-style-image: url('cmn_images/a_rt.gif');list-style-position:outside;padding-left:40px;\">
<li>User friendly Interface.</li>
<li>It can run on a variety of computer hardware and network configuration.</li>
<li>It employs a centralized robust database as a repository of information.</li>
<li>Data Import/Export to Excel and Word.</li>
<li>Supports multiple users.</li>
</ul>
</div>    
<div class=\"rho_form1\" style=\"float:left;padding-left:10px;padding-bottom:5px;margin:5px;max-width:49%;min-height:170px;background-color:<?php echo $bckcolors1; ?>;\">
<h3>&nbsp;&nbsp;&nbsp;KEY FEATURES OF OUR ERP SYSTEM:</h3>
<ul style=\"list-style-image: url('cmn_images/a_rt.gif');list-style-position:outside;padding-left:40px;\">
<li>Database backup and restore from application.</li>
<li>Robust application and information security management system.</li>
<li>In-built Templates for performing common tasks.</li>
<li>Easily Customized and Expandable to meet specific business needs</li>
<li>Display reports in Word, Html and PDF formats.</li>
</ul>
</div>    
</div>
</div></fieldset></div>";

$aboutOrgArtBody = "<div class=\"rho_form1\" style=\"float:left;padding-left:20px;margin:5px;max-width:{:introWdth}px;min-height:170px;line-height: 162%;font-family:Arial !important;font-size:13px !important;\">
                " . $aboutRho . "</div>";

function destroySession() {
    $_SESSION['UNAME'] = "";
    $_SESSION['USRID'] = -1;
    $_SESSION['LGN_NUM'] = -1;
    $_SESSION['ORG_NAME'] = "";
    $_SESSION['ORG_ID'] = -1;
    $_SESSION['ROOT_FOLDER'] = "";
    $_SESSION['ROLE_SET_IDS'] = "";
    $_SESSION['MUST_CHNG_PWD'] = "0";
    session_destroy();   // destroy session data in storage
    session_unset();     // unset $_SESSION variable for the runtime	
}

function sessionInvalid() {
    echo "
<div id='rho_form'><H1 style=\"text-align:center; color:red;\">INVALID SESSION!!!</H1>
<p style=\"text-align:center; color:red;\"><span style=\"font-weight:bold;font-style:italic;\">
Sorry, your session has become Invalid. <br/>
Click <a class=\"rho-button\" style=\"text-decoraction:underline;color:blue;\" 
href=\"javascript: window.location='index.php';\">here to login again!</a></span></p></div>";
}

function get_CurPlcy_SessnTmOut() {
    $sqlStr = "SELECT session_timeout FROM 
    sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLMain($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 300;
}

function executeSQLMain($selSQL) {
    $conn = getConn();
    $result = loc_db_query($conn, $selSQL);
//echo "<br/>SQL--".$selSQL;
    if (!$result) {
        echo "An error occurred. <br/> " . loc_db_result_error($result);
    }
    loc_db_close($conn);
    return $result;
//$conn
}

function getConn() {
    global $database;
    global $db_pwd;
    global $db_usr;
    global $port;
    global $host;

    $conn_string = "host=$host port=$port dbname=$database user=$db_usr password=$db_pwd";
    $conn = pg_connect($conn_string) or die("Failed to connect to the Database");
    return $conn;
}

function loc_db_escape_string($str) {
    return pg_escape_string($str);
}

function loc_db_affected_rows($result) {
    return pg_affected_rows($result);
}

function loc_db_query($conn, $inSQL) {
    //echo $inSQL;
    return pg_query($conn, $inSQL);
}

function loc_db_close($conn) {
    pg_close($conn);
}

function loc_db_fetch_array($result) {
    return pg_fetch_array($result);
}

function loc_db_num_rows($result) {
    return pg_num_rows($result);
}

function loc_db_result_error($result) {
    return pg_result_error($result);
}

function loc_db_field_name($result, $c) {
    return pg_field_name($result, $c);
}

function loc_db_num_fields($result) {
    return pg_num_fields($result);
}

?>
