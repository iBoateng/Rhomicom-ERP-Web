<?php
$mdlNm = "System Administration";
$ModuleName = $mdlNm;
$dfltPrvldgs = array("View System Administration", "View Users & their Roles",
    /* 2 */ "View Roles & their Priviledges", "View Registered Modules & their Priviledges",
    /* 4 */ "View Security Policies", "View Server Settings", "View User Logins",
    /* 7 */ "View Audit Trail Tables", "Add New Users & their Roles", "Edit Users & their Roles",
    /* 10 */ "Add New Roles & their Priviledges", "Edit Roles & their Priviledges",
    /* 12 */ "Add New Security Policies", "Edit Security Policies", "Add New Server Settings",
    /* 15 */ "Edit Server Settings", "Set manual password for users",
    /* 17 */ "Send System Generated Passwords to User Mails",
    /* 18 */ "View SQL", "View Record History", "Add/Edit Extra Info Labels", "Delete Extra Info Labels",
    /* 22 */ "Add Notices", "Edit Notices", "Delete Notices", "View Notices Admin");

$qstr = "";
$dsply = "";
$actyp = "";
$PKeyID = -1;
$vwtyp = isset($_POST['vtyp']) ? cleanInputData($_POST['vtyp']) : "0";
$usrID = $_SESSION['USRID'];
$prsnid = $_SESSION['PRSN_ID'];
$orgID = $_SESSION['ORG_ID'];
$error = "";
$searchAll = true;

$srchFor = isset($_POST['searchfor']) ? cleanInputData($_POST['searchfor']) : '';
$srchIn = isset($_POST['searchin']) ? cleanInputData($_POST['searchin']) : 'All';
$pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
$lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
$sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = "%" . str_replace(" ", "%", $srchFor) . "%";
    $srchFor = str_replace("%%", "%", $srchFor);
}



if (isset($_POST['vtyp'])) {
    $vwtyp = cleanInputData($_POST['vtyp']);
}

if (isset($_POST['actyp'])) {
    $actyp = cleanInputData($_POST['actyp']);
}

$qStrtDte = "";
$qEndDte = "";
$artCategory = "";
$isMaster = "0";

if (isset($_POST['qStrtDte'])) {
    $qStrtDte = cleanInputData($_POST['qStrtDte']);
    if (strlen($qStrtDte) == 19) {
        $qStrtDte = substr($qStrtDte, 0, 10) . " 00:00:00";
    } else {
        $qStrtDte = "";
    }
}

if (isset($_POST['qEndDte'])) {
    $qEndDte = cleanInputData($_POST['qEndDte']);
    if (strlen($qEndDte) == 19) {
        $qEndDte = substr($qEndDte, 0, 10) . " 23:59:59";
    } else {
        $qEndDte = "";
    }
}

if (isset($_POST['artCategory'])) {
    $artCategory = cleanInputData($_POST['artCategory']);
}

if (isset($_POST['isMaster'])) {
    $isMaster = cleanInputData($_POST['isMaster']);
}

$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
                                                <i class=\"fa fa-home\" aria-hidden=\"true\"></i>
						<span style=\"text-decoration:none;\">Home</span>
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>
					<li onclick=\"openATab('#allnotices', 'grp=40&typ=3&vtyp=0');\">
						<span style=\"text-decoration:none;\">All Notices</span>
					</li>";
$canview = test_prmssns($dfltPrvldgs[0], $mdlNm) || (($vwtyp <= 1 || $vwtyp >= 4) && test_prmssns("View Self-Service", "Self Service"));
$canAddNotices = test_prmssns($dfltPrvldgs[22], $mdlNm);
$canEdtNotices = test_prmssns($dfltPrvldgs[23], $mdlNm);
$canDelNotices = test_prmssns($dfltPrvldgs[24], $mdlNm);

if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0 && $canview === true) {
        if ($qstr == "DELETE") {
            if ($actyp == 1) {
                
            }
        } else if ($qstr == "UPDATE") {
            if ($actyp == 1) {
                //Notices
                //var_dump($_POST);
                header("content-type:application/json");
                //categoryCombo
                $articleID = cleanInputData($_POST['articleID']);
                $artclCatgry = cleanInputData($_POST['categoryCombo']);
                $hdrURL = cleanInputData($_POST['titleURL']);
                $artBody = cleanInputData($_POST['articleBody']);

                $artTitle = cleanInputData($_POST['titleDetails']);
                $isPblshed = (cleanInputData(isset($_POST['isPublished']) ? $_POST['isPublished'] : '') == "on") ? "1" : "0";
                $datePublished = cleanInputData($_POST['publishingDate']);
                $AuthorName = cleanInputData($_POST['AuthorName']);
                $AuthorEmail = cleanInputData($_POST['AuthorEmail']);
                $authorPrsnID = getPersonID(cleanInputData($_POST['authorPrsnID']));
                if ($datePublished != "") {
                    $datePublished = cnvrtDMYTmToYMDTm($datePublished);
                }
                //echo $datePublished;
                $oldNoticeID = getGnrlRecID2("self.self_articles", "article_header", "article_id", $artTitle);

                if ($artclCatgry != "" && $artTitle != "" && ($oldNoticeID <= 0 || $oldNoticeID == $articleID)) {
                    if ($articleID <= 0) {
                        createNotice($artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $AuthorName, $AuthorEmail, $authorPrsnID);
                    } else {
                        updateNotice($articleID, $artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $AuthorName, $AuthorEmail, $authorPrsnID);
                    }
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Saved Successfully',
                        'data' => array('src' => 'Notice Successfully Saved!'),
                        'total' => '1',
                        'errors' => ''
                    ));
                    exit();
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Error Occured',
                        'data' => array('src' => 'Failed to Save Notice!'),
                        'total' => '0',
                        'errors' => 'Incomplete Data'
                    ));
                    exit();
                }
            } else if ($actyp == 2) {
                
            }
        } else {
            if ($pgNo == 0) {
                if ($vwtyp == 0) {
                    $isMaster = "0";
                    echo $cntent . "<li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Notices Home</span>
					</li>
                                       </ul>
                                     </div>";
                    $total = get_NoticeTtls($srchFor, $srchIn);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    } else if ($pageNo < 1) {
                        $pageNo = ceil($total / $lmtSze);
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_Notices($srchFor, $srchIn, $curIdx, $lmtSze);
                    $cntr = 0;
                    $colClassType1 = "col-lg-2";
                    $colClassType2 = "col-lg-4";
                    $colClassType3 = "col-lg-1";
                    $colClassType4 = "col-lg-3";
                    ?> 
                    <form id='allnoticesForm' action='' method='post' accept-charset='UTF-8'>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                                <div class="input-group">
                                    <input class="form-control" id="allnoticesSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncNotices(event, '', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                    <input id="allnoticesPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllNotices('clear', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </label>
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllNotices('', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                    <!--<select data-placeholder="Select..." class="form-control chosen-select" id="allnoticesSrchIn">
                                    <?php
                                    $valslctdArry = array("", "", "");
                                    $srchInsArrys = array("Category", "Title", "Content");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                                                                                                                                                                                                                <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                    </select>-->
                                    <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allnoticesDsplySze" style="min-width:70px !important;">                            
                                        <?php
                                        $valslctdArry = array("", "", "", "", "", "", "", "");
                                        $dsplySzeArry = array(1, 5, 10, 15, 30, 50, 100, 500, 1000);
                                        for ($y = 0; $y < count($dsplySzeArry); $y++) {
                                            if ($lmtSze == $dsplySzeArry[$y]) {
                                                $valslctdArry[$y] = "selected";
                                            } else {
                                                $valslctdArry[$y] = "";
                                            }
                                            ?>
                                            <option value="<?php echo $dsplySzeArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $dsplySzeArry[$y]; ?></option>                            
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="<?php echo $colClassType2; ?>">
                                <div class="input-group">                        
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-attributes"></span></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allnoticesSortBy">
                                        <?php
                                        $valslctdArry = array("", "", "", "");
                                        $srchInsArrys = array("Date Published", "No. of Hits", "Category", "Title");
                                        for ($z = 0; $z < count($srchInsArrys); $z++) {
                                            if ($srchIn == $srchInsArrys[$z]) {
                                                $valslctdArry[$z] = "selected";
                                            }
                                            ?>
                                            <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                        <?php } ?>
                                    </select>                                    
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllNotices('', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-th-list"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="margin: 0px !important;">
                                        <li>
                                            <a href="javascript:getAllNotices('previous', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:getAllNotices('next', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>');" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="row" style="padding:0px 15px 0px 15px !important;">
                            <!-- Main jumbotron for a primary marketing message or call to action -->
                            <div class="jumbotron" style="border: 1px solid #ddd;border-radius: 2px;">
                                <div class="container-fluid" style="padding:0px 10px 0px 20px !important;">
                                    <h2>Hello, world!</h2>
                                    <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
                                    <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
                                </div>
                            </div>
                            <div class="" style="border: 1px solid #ddd;border-radius: 2px;">
                                <div class="container-fluid">
                                    <!-- Example row of columns -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div style="">
                                                <h2>Heading</h2>
                                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                                            </div></div>
                                        <div class="col-md-4">
                                            <div style="">
                                                <h2>Heading</h2>
                                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                                            </div></div>
                                        <div class="col-md-4">
                                            <div style="">
                                                <h2>Heading</h2>
                                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                                            </div></div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </form>
                    <?php
                } else if ($vwtyp == 1) {
                    $isMaster = "0";
                    echo $cntent . "<li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Notices List</span>
					</li>
                                       </ul>
                                     </div>";
                    $total = get_NoticeTtls($srchFor, $srchIn);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    } else if ($pageNo < 1) {
                        $pageNo = ceil($total / $lmtSze);
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_Notices($srchFor, $srchIn, $curIdx, $lmtSze);
                    $cntr = 0;
                    $colClassType1 = "col-lg-2";
                    $colClassType2 = "col-lg-3";
                    $colClassType3 = "col-lg-1";
                    $colClassType4 = "col-lg-3";
                    ?>
                    <form id='allnoticesForm' action='' method='post' accept-charset='UTF-8'>
                        <div class="row" style="margin-bottom:10px;">
                            <?php
                            if ($canAddNotices === true) {
                                $isMaster = "1";
                                ?> 
                                <div class="<?php echo $colClassType1; ?>" style="padding:0px 1px 0px 15px !important;">                    
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getOneNoticeForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'allnoticesForm', 'Add New Notice', -1, 2, 0)">
                                        <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                        New Notice
                                    </button>
                                </div>
                                <?php
                            } else {
                                $isMaster = "0";
                                $colClassType1 = "col-lg-2";
                                $colClassType2 = "col-lg-4";
                                $colClassType3 = "col-lg-1";
                                $colClassType4 = "col-lg-3";
                            }
                            ?>
                            <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                                <div class="input-group">
                                    <input class="form-control" id="allnoticesSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncNotices(event, '', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                    <input id="allnoticesPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllNotices('clear', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </label>
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllNotices('', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                    <!--<select data-placeholder="Select..." class="form-control chosen-select" id="allnoticesSrchIn">
                                    <?php
                                    $valslctdArry = array("", "", "");
                                    $srchInsArrys = array("Category", "Title", "Content");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                                                                                                                                                                                                                <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                    </select>-->
                                    <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allnoticesDsplySze" style="min-width:70px !important;">                            
                                        <?php
                                        $valslctdArry = array("", "", "", "", "", "", "", "");
                                        $dsplySzeArry = array(1, 5, 10, 15, 30, 50, 100, 500, 1000);
                                        for ($y = 0; $y < count($dsplySzeArry); $y++) {
                                            if ($lmtSze == $dsplySzeArry[$y]) {
                                                $valslctdArry[$y] = "selected";
                                            } else {
                                                $valslctdArry[$y] = "";
                                            }
                                            ?>
                                            <option value="<?php echo $dsplySzeArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $dsplySzeArry[$y]; ?></option>                            
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="<?php echo $colClassType2; ?>">
                                <div class="input-group">                        
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-attributes"></span></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allnoticesSortBy">
                                        <?php
                                        $valslctdArry = array("", "", "", "");
                                        $srchInsArrys = array("Date Published", "No. of Hits", "Category", "Title");
                                        for ($z = 0; $z < count($srchInsArrys); $z++) {
                                            if ($srchIn == $srchInsArrys[$z]) {
                                                $valslctdArry[$z] = "selected";
                                            }
                                            ?>
                                            <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                        <?php } ?>
                                    </select>                                    
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllNotices('', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-th-large"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="margin: 0px !important;">
                                        <li>
                                            <a href="javascript:getAllNotices('previous', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:getAllNotices('next', '#allnotices', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>');" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="row"> 
                            <div  class="col-md-12">
                                <table class="table table-striped table-bordered table-responsive" id="allnoticesTable" cellspacing="0" width="100%" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <?php if ($canEdtNotices === true) { ?>
                                                <th>...</th>
                                            <?php } ?>
                                            <th>Notice Category</th>
                                            <th>Title</th>
                                            <th>Author Email</th>
                                            <th>No. of Hits</th>
                                            <th>...</th>
                                            <?php if ($canEdtNotices === true) { ?>
                                                <th>Published?</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = loc_db_fetch_array($result)) {
                                            $cntr += 1;
                                            ?>
                                            <tr id="allnoticesRow<?php echo $cntr; ?>">                                    
                                                <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <?php if ($canEdtNotices === true) { ?>                                    
                                                    <td>
                                                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit Notice" 
                                                                onclick="getOneNoticeForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'allnoticesForm', 'View/Edit Notice', <?php echo $row[0]; ?>, 3, 0)" style="padding:2px !important;" style="padding:2px !important;">
                                                            <img src="cmn_images/edit32.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                        </button>
                                                    </td>
                                                <?php } ?>
                                                <td><?php echo $row[1]; ?></td>
                                                <td><?php echo $row[2]; ?></td>
                                                <td><?php echo $row[8]; ?></td>
                                                <td><?php echo $row[10]; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Notice" onclick="openATab('#allnotices', 'grp=40&typ=3&pg=0&vtyp=4&sbmtdNoticeID=<?php echo $row[0]; ?>');" style="padding:2px !important;" style="padding:2px !important;">
                                                        <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                        <img src="cmn_images/kghostview.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                </td>
                                                <?php
                                                if ($canEdtNotices === true) {
                                                    if ($row[5] == 1) {
                                                        ?>
                                                        <td>
                                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Click to Unpublish" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                                                <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                                <img src="cmn_images/success.gif" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                            </button>
                                                        </td>
                                                    <?php } else {
                                                        ?>
                                                        <td>
                                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Click to Publish" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                                                <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                                <img src="cmn_images/90.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                            </button>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>                     
                        </div>
                    </form>
                    <?php
                } else if ($vwtyp == 2) {
                    /* New Notice Form */
                    ?>
                    <div class="">
                        <div class="row">                  
                            <div class="col-md-12">
                                <form class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <fieldset class="basic_person_fs1" style="min-height:240px !important;">
                                                        <legend class="basic_person_lg">Topic/Notice Attributes</legend>
                                                        <div class="row" style="padding:0px 15px 0px 15px !important;">
                                                            <div class="col-md-12" style="padding:0px 15px 0px 15px !important;">
                                                                <div class="row"> 
                                                                    <div class="form-group form-group-sm">
                                                                        <label for="articleCategory" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Category:</label>
                                                                        <div  class="col-md-9">
                                                                            <select class="form-control" id="articleCategory" >
                                                                                <?php
                                                                                $valslctdArry = array("", "", "", "", "", "", "", "", "", "", "");
                                                                                $valuesArry = array("Notices/Announcements", "Welcome Message", "Latest News", "Useful Links",
                                                                                    "System Help", "Write-Ups/Research Papers", "Operational Manuals", "About Organisation",
                                                                                    "Other Notices", "Forum Topic", "Chat Room");
                                                                                for ($y = 0; $y < count($valuesArry); $y++) {
                                                                                    /* if ($lmtSze == $valuesArry[$y]) {
                                                                                      $valslctdArry[$y] = "selected";
                                                                                      } else {
                                                                                      $valslctdArry[$y] = "";
                                                                                      } */
                                                                                    ?>
                                                                                    <option value="<?php echo $valuesArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $valuesArry[$y]; ?></option>                            
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">                                                                        
                                                                    <div class="form-group form-group-sm">
                                                                        <label for="articleLoclClsfctn" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Local Classification:</label>
                                                                        <div  class="col-md-9">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" aria-label="..." id="articleLoclClsfctn" value="">
                                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Notice Classifications', 'gnrlOrgID', '', '', 'radio', true, '', 'articleLoclClsfctn', 'articleLoclClsfctn', 'clear', 1, '');">
                                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group form-group-sm">
                                                                        <label for="grpType" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Allowed Group Type:</label>
                                                                        <div  class="col-md-9">
                                                                            <select class="form-control" id="grpType" >
                                                                                <?php
                                                                                $valslctdArry = array("", "", "", "", "", "", "");
                                                                                $valuesArry = array("Everyone", "Divisions/Groups", "Grade", "Job",
                                                                                    "Position", "Site/Location", "Person Type");
                                                                                for ($y = 0; $y < count($valuesArry); $y++) {
                                                                                    /* if ($lmtSze == $valuesArry[$y]) {
                                                                                      $valslctdArry[$y] = "selected";
                                                                                      } else {
                                                                                      $valslctdArry[$y] = "";
                                                                                      } */
                                                                                    ?>
                                                                                    <option value="<?php echo $valuesArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $valuesArry[$y]; ?></option>                            
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group form-group-sm">
                                                                        <label for="groupName" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Allowed Group Name:</label>
                                                                        <div  class="col-md-9">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" aria-label="..." id="groupName" value="" readonly="">
                                                                                <input type="hidden" id="gnrlOrgID" value="<?php echo $orgID; ?>">
                                                                                <input type="hidden" id="groupID" value="-1">
                                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'groupID', 'groupName', 'clear', 1, '');">
                                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row"> 
                                                                    <div class="form-group form-group-sm">
                                                                        <label for="datePublished" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Publishing Date:</label>
                                                                        <div  class="col-md-9">
                                                                            <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy hh:ii:ss" data-link-field="dtp_input3" data-link-format="yyyy-mm-dd hh:ii:ss">
                                                                                <input class="form-control" size="16" type="text" id="datePublished" value="" readonly="">
                                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group form-group-sm">
                                                                        <label for="authorName" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Author Name:</label>
                                                                        <div  class="col-md-9">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" aria-label="..." id="authorName" value="">
                                                                                <input type="hidden" id="authorPrsnLocID" value="-1">
                                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'authorPrsnLocID', 'authorName', 'clear', 1, '');">
                                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row"> 
                                                                    <div class="form-group form-group-sm">
                                                                        <label for="authorEmail" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Author Email:</label>
                                                                        <div  class="col-md-9">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" aria-label="..." id="authorEmail" value="">
                                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'authorEmail', 'authorEmail', 'clear', 1, '');">
                                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div> 
                                        </div>                                         
                                        <div class="col-md-8">
                                            <fieldset class="basic_person_fs"><legend class="basic_person_lg">Notice/Forum Intro Message</legend>
                                                <div class="row" style="margin: 1px 0px 0px 0px !important;padding:0px 15px 0px 15px !important;"> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="articleTitle" class="control-label col-md-2">Topic/Title:</label>
                                                        <div  class="col-md-10" style="padding:0px 1px 0px 15px !important;">
                                                            <input class="form-control" id="articleTitle" type = "text" placeholder="Title"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding:0px 15px 0px 15px !important;">
                                                    <div id="articleIntroMsg"></div> 
                                                </div> 
                                            </fieldset>

                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Notice/Forum Full Message Text</legend>                                                
                                                <div class="row" style="padding:0px 15px 0px 15px !important;">
                                                    <div id="articleBodyText"></div> 
                                                </div> 
                                                <div class="row" style="margin: -5px 0px 0px 0px !important;"> 
                                                    <div class="col-md-6" style="padding:0px 0px 0px 1px !important;">&nbsp;</div>
                                                    <div class="col-md-6" style="padding:0px 0px 0px 0px">
                                                        <div class="col-md-6" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/reload.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">CLOSE</button></div>
                                                        <div class="col-md-6" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/Emailcon.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">SAVE</button></div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                        </div>
                                    </div>
                                </form>                                   
                            </div>                
                        </div>          
                    </div> 
                    <?php
                } else if ($vwtyp == 3) {
                    /* Edit Notice Form */
                    $sbmtdNoticeID = isset($_POST['sbmtdNoticeID']) ? cleanInputData($_POST['sbmtdNoticeID']) : -1;
                    $result = get_OneNotice($sbmtdNoticeID);
                    while ($row = loc_db_fetch_array($result)) {
                        ?>
                        <div class="">
                            <div class="row">                  
                                <div class="col-md-12">
                                    <form class="form-horizontal">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <fieldset class="basic_person_fs1" style="min-height:240px !important;">
                                                            <legend class="basic_person_lg">Topic/Notice Attributes</legend>
                                                            <div class="row" style="padding:0px 15px 0px 15px !important;">
                                                                <div class="col-md-12" style="padding:0px 15px 0px 15px !important;">
                                                                    <div class="row"> 
                                                                        <div class="form-group form-group-sm">
                                                                            <label for="articleCategory" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Category:</label>
                                                                            <div  class="col-md-9">
                                                                                <select class="form-control" id="articleCategory" >
                                                                                    <?php
                                                                                    $valslctdArry = array("", "", "", "", "", "", "", "", "", "", "");
                                                                                    $valuesArry = array("Notices/Announcements", "Welcome Message", "Latest News", "Useful Links",
                                                                                        "System Help", "Write-Ups/Research Papers", "Operational Manuals", "About Organisation",
                                                                                        "Other Notices", "Forum Topic", "Chat Room");
                                                                                    for ($y = 0; $y < count($valuesArry); $y++) {
                                                                                        if ($row[1] == $valuesArry[$y]) {
                                                                                            $valslctdArry[$y] = "selected";
                                                                                        } else {
                                                                                            $valslctdArry[$y] = "";
                                                                                        }
                                                                                        ?>
                                                                                        <option value="<?php echo $valuesArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $valuesArry[$y]; ?></option>                            
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                        
                                                                        <div class="form-group form-group-sm">
                                                                            <label for="articleLoclClsfctn" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Local Classification:</label>
                                                                            <div  class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" aria-label="..." id="articleLoclClsfctn" value="">
                                                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Notice Classifications', 'gnrlOrgID', '', '', 'radio', true, '', 'articleLoclClsfctn', 'articleLoclClsfctn', 'clear', 1, '');">
                                                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group form-group-sm">
                                                                            <label for="grpType" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Allowed Group Type:</label>
                                                                            <div  class="col-md-9">
                                                                                <select class="form-control" id="grpType" >
                                                                                    <?php
                                                                                    $valslctdArry = array("", "", "", "", "", "", "");
                                                                                    $valuesArry = array("Everyone", "Divisions/Groups", "Grade", "Job",
                                                                                        "Position", "Site/Location", "Person Type");
                                                                                    for ($y = 0; $y < count($valuesArry); $y++) {
                                                                                        if ($row[12] == $valuesArry[$y]) {
                                                                                            $valslctdArry[$y] = "selected";
                                                                                        } else {
                                                                                            $valslctdArry[$y] = "";
                                                                                        }
                                                                                        ?>
                                                                                        <option value="<?php echo $valuesArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $valuesArry[$y]; ?></option>                            
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group form-group-sm">
                                                                            <label for="groupName" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Allowed Group Name:</label>
                                                                            <div  class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" aria-label="..." id="groupName" value="<?php echo $row[14]; ?>" readonly="">
                                                                                    <input type="hidden" id="gnrlOrgID" value="<?php echo $orgID; ?>">
                                                                                    <input type="hidden" id="groupID" value="<?php echo $row[13]; ?>">
                                                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'groupID', 'groupName', 'clear', 1, '');">
                                                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row"> 
                                                                        <div class="form-group form-group-sm">
                                                                            <label for="datePublished" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Publishing Date:</label>
                                                                            <div  class="col-md-9">
                                                                                <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input3" data-link-format="yyyy-mm-dd hh:ii:ss">
                                                                                    <input class="form-control" size="16" type="text" id="datePublished" value="<?php echo $row[6]; ?>" readonly="">
                                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group form-group-sm">
                                                                            <label for="authorName" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Author Name:</label>
                                                                            <div  class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" aria-label="..." id="authorName" value="<?php echo $row[7]; ?>">
                                                                                    <input type="hidden" id="authorPrsnLocID" value="<?php echo $row[9]; ?>">
                                                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'authorPrsnLocID', 'authorName', 'clear', 1, '');">
                                                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row"> 
                                                                        <div class="form-group form-group-sm">
                                                                            <label for="authorEmail" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Author Email:</label>
                                                                            <div  class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" aria-label="..." id="authorEmail" value="<?php echo $row[8]; ?>">
                                                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'authorEmail', 'authorEmail', 'clear', 1, '');">
                                                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                    </div>    
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div> 
                                            </div>                                         
                                            <div class="col-md-8">
                                                <fieldset class="basic_person_fs"><legend class="basic_person_lg">Notice/Forum Intro Message</legend>
                                                    <div class="row" style="margin: 1px 0px 0px 0px !important;padding:0px 15px 0px 15px !important;"> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="articleTitle" class="control-label col-md-2">Topic/Title:</label>
                                                            <div  class="col-md-10" style="padding:0px 1px 0px 15px !important;">
                                                                <input class="form-control" id="articleTitle" type = "text" placeholder="Title" value="<?php echo $row[2]; ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding:0px 15px 0px 15px !important;">
                                                        <div id="articleIntroMsg"></div> 
                                                    </div> 
                                                </fieldset>

                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Notice/Forum Full Message Text</legend>                                                
                                                    <div class="row" style="padding:0px 15px 0px 15px !important;">
                                                        <div id="articleBodyText"></div> 
                                                    </div> 
                                                    <div class="row" style="margin: -5px 0px 0px 0px !important;"> 
                                                        <div class="col-md-6" style="padding:0px 0px 0px 1px !important;">&nbsp;</div>
                                                        <div class="col-md-6" style="padding:0px 0px 0px 0px">
                                                            <div class="col-md-6" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/reload.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">CLOSE</button></div>
                                                            <div class="col-md-6" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/Emailcon.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">SAVE</button></div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                            </div>
                                        </div>
                                    </form>                                   
                                </div>                
                            </div>          
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function () {

                                $('#articleIntroMsg').summernote({
                                    minHeight: 145,
                                    focus: true
                                });
                                $('#articleBodyText').summernote({
                                    minHeight: 270,
                                    focus: true
                                });
                                var markupStr1 = '<?php echo str_replace("'", "\'", str_replace("\n", " \ ", str_replace("&#13;", " \ ", str_replace("&#10;", " \ ", $row[11])))); ?>';
                                var markupStr2 = '<?php echo str_replace("'", "\'", str_replace("\n", " \ ", str_replace("&#13;", " \ ", str_replace("&#10;", " \ ", $row[4])))); ?>';
                                $('#articleIntroMsg').summernote('code', markupStr1);
                                $('#articleBodyText').summernote('code', markupStr2);
                            });
                        </script> 
                        <?php
                    }
                } else if ($vwtyp == 4) {
                    /* Display one Full Notice ReadOnly */
                    $sbmtdNoticeID = isset($_POST['sbmtdNoticeID']) ? cleanInputData($_POST['sbmtdNoticeID']) : -1;
                    $result = get_OneNotice($sbmtdNoticeID);
                    while ($row = loc_db_fetch_array($result)) {
                        echo $cntent . "<li onclick=\"openATab('#allnotices', 'grp=40&typ=3&vtyp=1');\">
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Notices List</span>
					</li>
                                        <li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">" . $row[2] . "</span>
					</li>
                                       </ul>
                                     </div>";
                        ?>
                        <!-- Main jumbotron for a primary marketing message or call to action -->
                        <div class="jumbotron" style="border: 1px solid #ddd;border-radius: 2px;">
                            <div class="container-fluid" style="padding:0px 10px 0px 20px !important;">
                                <!--<h2><?php echo $row[2]; ?></h2>-->
                                <p><?php echo $row[4]; ?></p>
                            </div>
                        </div>
                        <div class="row container-fluid">
                            <p style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;font-size:16px;padding:5px;"><a href="#" style="font-size:16px;padding:5px;">Show Comments (
                                    <span style="color:red;">3</span> ): Post Your Comments &gt;&gt;</a></p>
                        </div>
                        <div class="row container-fluid">
                            <form class="form-inline">
                                <div class="form-group col-md-12" style="padding:0px 1px 0px 25px !important;">
                                    <div class="col-md-11" style="padding:0px 1px 0px 15px !important;">
                                        <input type="text" class="form-control" placeholder="Type your message here..." style="width:100% !important;">
                                    </div>
                                    <div class="col-md-1" style="padding:0px 1px 0px 15px !important;">
                                        <button type="submit" class="btn btn-info" style="width:100% !important;">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                } else if ($vwtyp == 5) {
                    //Comments/Feedback Email Form
                    echo $cntent . "<li onclick=\"openATab('#allnotices', 'grp=40&typ=3&vtyp=1');\">
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Notices List</span>
					</li>
                                        <li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Send Feedback</span>
					</li>
                                       </ul>
                                     </div>";
                    ?>
                    <form class="form-horizontal" id="cmntsFdbckForm">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class = "basic_person_fs"><legend class = "basic_person_lg">Addresses / Subject / Attachments</legend>
                                    <div class="form-group form-group-sm">
                                        <label for="fdbckMailCc" class="control-label col-md-2">Cc:</label>
                                        <div  class="col-md-10">
                                            <input class="form-control" id="fdbckMailCc" name="fdbckMailCc" type = "text" placeholder="Cc"/>                                    
                                        </div>
                                    </div> 
                                    <div class="form-group form-group-sm">
                                        <label for="fdbckSubject" class="control-label col-md-2">Subject:</label>
                                        <div  class="col-md-10">
                                            <input class="form-control" id="fdbckSubject" type = "text" placeholder="Subject"/>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <label for="fdbckMailAttchmnts" class="control-label col-md-2">Attached Files <span class="glyphicon glyphicon-paperclip"></span>:</label>
                                        <div  class="col-md-10">
                                            <div  class="col-xs-10" style="padding:0px 1px 0px 0px !important;">
                                                <textarea class="form-control" id="fdbckMailAttchmnts" cols="2" placeholder="Attachments" rows="3"></textarea>
                                            </div>
                                            <div  class="col-xs-2" style="padding:0px 1px 0px 5px !important;">
                                                <button type="button" class="btn btn-default btn-sm" style="float:right;"><span class="glyphicon glyphicon-paperclip"></span>Browse...</button>
                                            </div>
                                        </div>

                                    </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="basic_person_fs"><legend class="basic_person_lg">Message Body</legend>
                                    <div id="fdbckMsgBody"></div> 
                                </fieldset>
                            </div>
                        </div>
                        <div class="row" style="margin: -5px 0px 0px 0px !important;"> 
                            <div class="col-md-6" style="padding:0px 0px 0px 1px !important;">&nbsp;</div>
                            <div class="col-md-6" style="padding:0px 0px 0px 0px">
                                <div class="col-md-5" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/reload.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">RESET</button></div>
                                <div class="col-md-7" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/Emailcon.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">SEND MESSAGE</button></div>
                            </div>
                        </div>
                    </form>
                    <?php
                } else if ($vwtyp == 6) {
                    //Forums/Chat Rooms
                    echo $cntent . "<li onclick=\"openATab('#allnotices', 'grp=40&typ=3&vtyp=1');\">
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Notices List</span>
					</li>
                                        <li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Forums and Chat Rooms</span>
					</li>
                                       </ul>
                                     </div>";
                    ?>
                    <button type="button" class="btn btn-default btn-sm" style="width:100% !important;" onclick="openATab('#allnotices', 'grp=40&typ=3&vtyp=7');"><img src="cmn_images/Emailcon.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">SAMPLE CHAT</button>
                    <div class="container-fluid">
                        <div class="row">   
                            <div class="col-md-12">
                                <table class="table table-striped table-responsive" id="allForumsTable" style="width:100% !important;">
                                    <thead>
                                        <tr>
                                            <th>2015 IRS Forum</th>
                                            <th>IRS Forum Dates</th>        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Washington DC<br/><a href="https://aws.passkey.com/g/42238120" target="_blank">Gaylord National Hotel Convention Center</a><br/><i class="fa fa-map-marker"></i> 201 Waterfront Street<br/>National Harbor, MD 20745</td>
                                            <td>July 7 - 9, 2015</td>
                                        </tr>
                                        <tr class="active">    
                                            <td><strong>NSTP Annual Federal Tax Refresher Course</strong><br/><a href="https://aws.passkey.com/g/42238120" target="_blank">Gaylord National Hotel Convention Center</a><br/><i class="fa fa-map-marker"></i> 201 Waterfront Street<br/>National Harbor, MD 20745</td>
                                            <td><strong>AFTR Date & Registration</strong><br/>July 10, 2015<br/><br/><a class="btn btn-hot btn-block " href="/course/2015-Annual-Federal-Tax-Refresher-Course---National-Harbor%2C-MD" target="_blank"><i class="fa fa-hand-o-right"></i> Register Here</a></td>
                                        </tr>           
                                        <!--Denbver-->
                                        <tr>
                                            <td>Denver , CO <br/><a href="https://aws.passkey.com/g/34249128"target="_blank">Hyatt Regency Denver at Colorado Convention Center</a><br/><i class="fa fa-map-marker"></i> 650 15th Street<br/>Denver, CO 80202</td>
                                            <td>July 28 - 30, 2015</td>
                                        </tr>
                                        <tr class="active">       
                                            <td><strong>NSTP Annual Federal Tax Refresher Course</strong> <br/><a href="http://embassysuites3.hilton.com/en/hotels/colorado/embassy-suites-denver-downtown-convention-center-DENESES/index.html"target="_blank">Embassy Suites Denver</a><br/><i class="fa fa-map-marker"></i> 1420 Stout St<br/>Denver, CO 80202</td>
                                            <td><strong>AFTR Date & Registration</strong><br/>July 31, 2015<br/><br/><a class="btn btn-hot btn-block " href="/course/2015-Annual-Federal-Tax-Refresher-Course---Denver%2C-CO" target="_blank"><i class="fa fa-hand-o-right"></i> Register Here</a></td>
                                        </tr>
                                        <!--Denver-->
                                        <tr>
                                            <td>San Diego, CA <br/><a href="https://aws.passkey.com/g/42502120"target="_blank">San Diego Town & Country</a><br/><i class="fa fa-map-marker"></i> 500 Hotel Circle North <br/>San Diego, CA , 92108</td>
                                            <td>August 11 - 13, 2015</td>
                                        </tr>
                                        <tr class="active">
                                            <td><strong>NSTP Annual Federal Tax Refresher Course</strong> <br/><a href="https://aws.passkey.com/g/42502120"target="_blank">San Diego Town & Country</a><br/><i class="fa fa-map-marker"></i> 500 Hotel Circle North <br/>San Diego, CA , 92108</td>
                                            <td><strong>AFTR Date & Registration</strong><br/>August 14, 2015<br/><br/><a class="btn btn-hot btn-block " href="/course/2015-Annual-Federal-Tax-Refresher-Course---San-Diego%2C-CA" target="_blank"><i class="fa fa-hand-o-right"></i> Register Here</a></td>
                                        </tr>
                                        <!--washington-->
                                        <tr>
                                            <td>Atlanta, GA <br/><a href="https://aws.passkey.com/event/13001814/owner/321/home"target="_blank">Atlanta Marriott Marquis</a><br/><i class="fa fa-map-marker"></i> 265 Peachtree Center Avenue <br/>Atlanta, GA , 30303</td>
                                            <td>August 25 - 27, 2015</td>
                                        </tr>
                                        <tr class="active">   
                                            <td><strong>NSTP Annual Federal Tax Refresher Course</strong><br/><a href="https://aws.passkey.com/event/13001814/owner/321/home"target="_blank">Atlanta Marriott Marquis</a><br/><i class="fa fa-map-marker"></i> 265 Peachtree Center Avenue  <br/>Atlanta, GA , 30303</td>
                                            <td><strong>AFTR Date & Registration</strong><br/>August 28, 2015<br/><br/><a class="btn btn-hot btn-block " href="/course/2015-Annual-Federal-Tax-Refresher-Course---Atlanta%2C-GA" target="_blank"><i class="fa fa-hand-o-right"></i> Register Here</a></td>
                                        </tr>
                                        <!--washington-->
                                        <tr>
                                            <td>Orlando, FL<br/><a href="https://aws.passkey.com/g/30187120"target="_blank">Hyatt Regency Orlando</a><br/><i class="fa fa-map-marker"></i> 9801 International Drive <br/>Orlando, FL , 32819</td>
                                            <td>September 1 - 3, 2015</td>
                                        </tr>
                                        <tr class="active">
                                            <td><strong>NSTP Annual Federal Tax Refresher Course</strong><br/><a href="https://aws.passkey.com/g/30187120"target="_blank">Hyatt Regency Orlando</a><br/><i class="fa fa-map-marker"></i> 9801 International Drive <br/>Orlando, FL , 32819</td>
                                            <td><strong>AFTR Date & Registration</strong><br/>September 4, 2015<br/><br/><a class="btn btn-hot btn-block " href="/course/2015-Annual-Federal-Tax-Refresher-Course---Orlando%2C-FL" target="_blank"><i class="fa fa-hand-o-right"></i> Register Here</a></td>
                                        </tr>
                                        <!--washington-->
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                    <?php
                } else if ($vwtyp == 7) {
                    //Forums / Chats Messages Posted
                    echo $cntent . "<li onclick=\"openATab('#allnotices', 'grp=40&typ=3&vtyp=1');\">
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Notices List</span>
					</li>
                                        <li onclick=\"openATab('#allnotices', 'grp=40&typ=3&vtyp=6');\">
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Forums and Chat Rooms</span>
					</li>
                                        <li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">One Chat Room</span>
					</li>
                                       </ul>
                                     </div>";
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="pull-left">Message</div>
                            <div class="widget-icons pull-right">
                                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
                                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                            </div>  
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <!-- Widget content -->
                            <div class="padd sscroll">
                                <ul class="chats">
                                    <!-- Chat by us. Use the class "by-me". -->
                                    <li class="by-me">
                                        <!-- Use the class "pull-left" in avatar -->
                                        <div class="avatar pull-left">
                                            <img src="cmn_images/user.jpg" alt="">
                                        </div>
                                        <div class="chat-content">
                                            <!-- In meta area, first include "name" and then "time" -->
                                            <div class="chat-meta">John Smith <span class="pull-right">3 hours ago</span></div>
                                            Vivamus diam elit diam, consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li> 
                                    <!-- Chat by other. Use the class "by-other". -->
                                    <li class="by-other">
                                        <!-- Use the class "pull-right" in avatar -->
                                        <div class="avatar pull-right">
                                            <img src="cmn_images/user22.png" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <!-- In the chat meta, first include "time" then "name" -->
                                            <div class="chat-meta">3 hours ago <span class="pull-right">Jenifer Smith</span></div>
                                            Vivamus diam elit diam, consectetur fconsectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>
                                    <li class="by-me">
                                        <div class="avatar pull-left">
                                            <img src="cmn_images/user.jpg" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <div class="chat-meta">John Smith <span class="pull-right">4 hours ago</span></div>
                                            Vivamus diam elit diam, consectetur fermentum sed dapibus eget, Vivamus consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>
                                    <li class="by-other">
                                        <!-- Use the class "pull-right" in avatar -->
                                        <div class="avatar pull-right">
                                            <img src="cmn_images/user22.png" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <!-- In the chat meta, first include "time" then "name" -->
                                            <div class="chat-meta">3 hours ago <span class="pull-right">Jenifer Smith</span></div>
                                            Vivamus diam elit diam, consectetur fermentum sed dapibus eget, Vivamus consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li> <!-- Chat by us. Use the class "by-me". -->
                                    <li class="by-me">
                                        <!-- Use the class "pull-left" in avatar -->
                                        <div class="avatar pull-left">
                                            <img src="cmn_images/user.jpg" alt="">
                                        </div>
                                        <div class="chat-content">
                                            <!-- In meta area, first include "name" and then "time" -->
                                            <div class="chat-meta">John Smith <span class="pull-right">3 hours ago</span></div>
                                            Vivamus diam elit diam, consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li> 
                                    <!-- Chat by other. Use the class "by-other". -->
                                    <li class="by-other">
                                        <!-- Use the class "pull-right" in avatar -->
                                        <div class="avatar pull-right">
                                            <img src="cmn_images/user22.png" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <!-- In the chat meta, first include "time" then "name" -->
                                            <div class="chat-meta">3 hours ago <span class="pull-right">Jenifer Smith</span></div>
                                            Vivamus diam elit diam, consectetur fconsectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>
                                    <li class="by-me">
                                        <div class="avatar pull-left">
                                            <img src="cmn_images/user.jpg" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <div class="chat-meta">John Smith <span class="pull-right">4 hours ago</span></div>
                                            Vivamus diam elit diam, consectetur fermentum sed dapibus eget, Vivamus consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>
                                    <li class="by-other">
                                        <!-- Use the class "pull-right" in avatar -->
                                        <div class="avatar pull-right">
                                            <img src="cmn_images/user22.png" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <!-- In the chat meta, first include "time" then "name" -->
                                            <div class="chat-meta">3 hours ago <span class="pull-right">Jenifer Smith</span></div>
                                            Vivamus diam elit diam, consectetur fermentum sed dapibus eget, Vivamus consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li> <!-- Chat by us. Use the class "by-me". -->
                                    <li class="by-me">
                                        <!-- Use the class "pull-left" in avatar -->
                                        <div class="avatar pull-left">
                                            <img src="cmn_images/user.jpg" alt="">
                                        </div>
                                        <div class="chat-content">
                                            <!-- In meta area, first include "name" and then "time" -->
                                            <div class="chat-meta">John Smith <span class="pull-right">3 hours ago</span></div>
                                            Vivamus diam elit diam, consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li> 
                                    <!-- Chat by other. Use the class "by-other". -->
                                    <li class="by-other">
                                        <!-- Use the class "pull-right" in avatar -->
                                        <div class="avatar pull-right">
                                            <img src="cmn_images/user22.png" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <!-- In the chat meta, first include "time" then "name" -->
                                            <div class="chat-meta">3 hours ago <span class="pull-right">Jenifer Smith</span></div>
                                            Vivamus diam elit diam, consectetur fconsectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>
                                    <li class="by-me">
                                        <div class="avatar pull-left">
                                            <img src="cmn_images/user.jpg" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <div class="chat-meta">John Smith <span class="pull-right">4 hours ago</span></div>
                                            Vivamus diam elit diam, consectetur fermentum sed dapibus eget, Vivamus consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>
                                    <li class="by-other">
                                        <!-- Use the class "pull-right" in avatar -->
                                        <div class="avatar pull-right">
                                            <img src="cmn_images/user22.png" alt="">
                                        </div>

                                        <div class="chat-content">
                                            <!-- In the chat meta, first include "time" then "name" -->
                                            <div class="chat-meta">3 hours ago <span class="pull-right">Jenifer Smith</span></div>
                                            Vivamus diam elit diam, consectetur fermentum sed dapibus eget, Vivamus consectetur dapibus adipiscing elit.
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>   
                                </ul>
                            </div>
                            <!-- Widget footer -->
                            <div class="widget-foot" style="margin-top:10px;">
                                <form class="form-inline">
                                    <div class="form-group col-md-12" style="padding:0px 1px 0px 25px !important;">
                                        <div class="col-md-11" style="padding:0px 1px 0px 15px !important;">
                                            <input type="text" class="form-control" placeholder="Type your message here..." style="width:100% !important;">
                                        </div>
                                        <div class="col-md-1" style="padding:0px 1px 0px 15px !important;">
                                            <button type="submit" class="btn btn-info" style="width:100% !important;">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(function ()
                        {
                            $('.sscroll').jScrollPane({showArrows: false});
                        });
                    </script>
                    <?php
                } else if ($vwtyp == 20) {
                    //Help Notices Tabular
                    echo $cntent . "<li onclick=\"openATab('#allnotices', 'grp=40&typ=3&vtyp=1');\">
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Notices List</span>
					</li>
                                        <li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Help</span>
					</li>
                                       </ul>
                                     </div>";
                    ?>
                    <div class="container-fluid">
                        <div class="row">   
                            <div class="col-md-12">
                                Help Notices Tabular
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
    }
}

function get_Notices($searchFor, $searchIn, $offset, $limit_size) {
    global $qStrtDte;
    global $qEndDte;
    global $artCategory;
    global $isMaster;

    $wherecls = "";
    $extrWhr = "";

    if ($artCategory != "" && $artCategory != "All") {
        $extrWhr = " AND (a.article_category ilike '" . loc_db_escape_string($artCategory) . "')";
    }
    if ($isMaster != "1") {
        $extrWhr .= " AND (a.is_published = '1')";
    }
    if ($searchIn === "Title") {
        $wherecls = " AND (a.article_header ilike '" . loc_db_escape_string($searchFor) . "' "
                . "or a.header_url ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn === "Category") {
        $wherecls = " AND (a.article_category ilike '" . loc_db_escape_string($searchFor) . "')";
    } else {
        $wherecls = " AND (a.article_body ilike '" . loc_db_escape_string($searchFor) . "')";
    }

    if ($qStrtDte != "") {
        //$qStrtDte = cnvrtDMYTmToYMDTm($qStrtDte);
        $wherecls .= " AND (a.publishing_date >= '" . loc_db_escape_string($qStrtDte) . "')";
    }
    if ($qEndDte != "") {
        //$qEndDte = cnvrtDMYTmToYMDTm($qEndDte);
        $wherecls .= " AND (a.publishing_date <= '" . loc_db_escape_string($qEndDte) . "')";
    }

    $sqlStr = "SELECT a.article_id, a.article_category, a.article_header, a.header_url, a.article_body,  
       a.is_published, a.publishing_date, a.author_name, a.author_email, prs.get_prsn_loc_id(a.author_prsn_id), 
       (select count(distinct b.created_by) from self.self_articles_hits b where a.article_id = b.article_id) hits  
  FROM self.self_articles a 
WHERE (1=1" . $extrWhr . "$wherecls) ORDER BY a.article_id DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) <= 0) {
        //echo $sqlStr;'<a href=\"\">'|| ||'</a>'
    }
    return $result;
}

function get_OneNotice($articleID) {
    $sqlStr = "SELECT a.article_id, 
        a.article_category, 
        a.article_header, 
        a.header_url, 
        a.article_body,  
       a.is_published, 
       to_char(to_timestamp(a.publishing_date, 'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') publishing_date,
       CASE WHEN a.author_prsn_id>0 THEN prs.get_prsn_name(a.author_prsn_id) ELSE a.author_name END author_name, 
       a.author_email, 
       prs.get_prsn_loc_id(a.author_prsn_id), 
       (select count(distinct b.created_by) from self.self_articles_hits b where a.article_id = b.article_id) hits,
       a.article_intro_msg,
       a.allowed_group_type,
       a.allowed_group_id,
       org.get_criteria_name(a.allowed_group_id, a.allowed_group_type) group_name
     FROM self.self_articles a 
     WHERE article_id = " . $articleID;
    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function deleteNotice($articleID) {
    $affctd1 = 0;

    $insSQL = "DELETE FROM self.self_articles WHERE article_id = " . $articleID;
    $affctd1 += execUpdtInsSQL($insSQL);

    if ($affctd1 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 Notice(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
}

function createNotice($artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $authorNm, $authorEmail, $authorID) {
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

function updateNotice($articleID, $artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $authorNm, $authorEmail, $authorID) {
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

function get_NoticeTtls($searchFor, $searchIn) {
    //global $usrID;
    global $qStrtDte;
    global $qEndDte;
    global $artCategory;
    global $isMaster;

    $wherecls = "";
    $extrWhr = "";

    if ($artCategory != "" && $artCategory != "All") {
        $extrWhr = " AND (a.article_category ilike '" . loc_db_escape_string($artCategory) . "')";
    }
    if ($isMaster != "1") {
        $extrWhr .= " AND (a.is_published = '1')";
    }
    if ($searchIn === "Title") {
        $wherecls = " AND (article_header ilike '" . loc_db_escape_string($searchFor) . "' "
                . " or header_url ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn === "Category") {
        $wherecls = " AND (article_category ilike '" . loc_db_escape_string($searchFor) . "')";
    } else {
        $wherecls = " AND (article_body ilike '" . loc_db_escape_string($searchFor) . "')";
    }

    if ($qStrtDte != "") {
        $qStrtDte = cnvrtDMYTmToYMDTm($qStrtDte);
        $wherecls .= " AND (a.publishing_date >= '" . loc_db_escape_string($qStrtDte) . "')";
    }
    if ($qEndDte != "") {
        $qEndDte = cnvrtDMYTmToYMDTm($qEndDte);
        $wherecls .= " AND (a.publishing_date <= '" . loc_db_escape_string($qEndDte) . "')";
    }

    $sqlStr = "SELECT count(1) 
  FROM self.self_articles a 
WHERE (1=1" . $extrWhr . "$wherecls)";
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function getLtstNoticeID($articleCtgry) {
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

function getNoticeBody($articleID) {
    $sqlStr = "select article_body from self.self_articles where article_id = " . $articleID;
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        $artBody = str_replace("{:articleID}", $articleID, $row[0]);
        return $artBody;
    }
    return "";
}

function getNoticeHeaderUrl($articleID) {
    $sqlStr = "select header_url from self.self_articles where article_id = " . $articleID;
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "";
}

function getNoticeHeader($articleID) {
    $sqlStr = "select article_header from self.self_articles where article_id = " . $articleID;
//echo $sqlStr;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        $hdrUrl = str_replace("{:articleID}", $articleID, getNoticeHeaderUrl($articleID));
        if ($hdrUrl == "") {
            return "$row[0]";
        } else {
            return "<a href=\"" . $hdrUrl . "\">" . $row[0] . "</a>";
        }
    }
    return "";
}

function getNoticeHitID($artclID) {
    global $usrID;
    $sqlStr = "select article_hit_id from self.self_articles_hits "
            . "where created_by = " . $usrID . " and article_id = " . $artclID;
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return -1;
}

function createNoticeHit($artclID) {
    global $usrID;
    global $lgn_num;

    $dateStr = getDB_Date_time();
    $insSQL = "INSERT INTO self.self_articles_hits(
            article_id, created_by, creation_date, login_number) VALUES ("
            . loc_db_escape_string($artclID) . ", "
            . $usrID . ", '" . $dateStr . "', " . $lgn_num . ")";
    execUpdtInsSQL($insSQL);
}
