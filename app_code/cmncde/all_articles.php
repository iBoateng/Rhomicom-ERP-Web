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
    /* 22 */ "Add Articles", "Edit Articles", "Delete Articles");

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
					<li onclick=\"openATab('#allarticles', 'grp=40&typ=3&vtyp=0');\">
						<span style=\"text-decoration:none;\">All Articles</span>
					</li>";
$canview = test_prmssns($dfltPrvldgs[0], $mdlNm) || ($vwtyp <= 2 && test_prmssns("View Self-Service", "Self Service"));
$canAddArticles = test_prmssns($dfltPrvldgs[22], $mdlNm);
$canEdtArticles = test_prmssns($dfltPrvldgs[23], $mdlNm);
$canDelArticles = test_prmssns($dfltPrvldgs[24], $mdlNm);

if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0 && $canview === true) {
        if ($qstr == "DELETE") {
            if ($actyp == 1) {
                
            }
        } else if ($qstr == "UPDATE") {
            if ($actyp == 1) {
                //Articles
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
                $oldArticleID = getGnrlRecID2("self.self_articles", "article_header", "article_id", $artTitle);

                if ($artclCatgry != "" && $artTitle != "" && ($oldArticleID <= 0 || $oldArticleID == $articleID)) {
                    if ($articleID <= 0) {
                        createArticle($artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $AuthorName, $AuthorEmail, $authorPrsnID);
                    } else {
                        updateArticle($articleID, $artclCatgry, $artTitle, $hdrURL, $artBody, $isPblshed, $datePublished, $AuthorName, $AuthorEmail, $authorPrsnID);
                    }
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Saved Successfully',
                        'data' => array('src' => 'Article Successfully Saved!'),
                        'total' => '1',
                        'errors' => ''
                    ));
                    exit();
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Error Occured',
                        'data' => array('src' => 'Failed to Save Article!'),
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
                                                <span style=\"text-decoration:none;\">Articles Home</span>
					</li>
                                       </ul>
                                     </div>";
                    $total = get_ArticleTtls($srchFor, $srchIn);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    } else if ($pageNo < 1) {
                        $pageNo = ceil($total / $lmtSze);
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_Articles($srchFor, $srchIn, $curIdx, $lmtSze);
                    $cntr = 0;
                    $colClassType1 = "col-lg-2";
                    $colClassType2 = "col-lg-4";
                    $colClassType3 = "col-lg-1";
                    $colClassType4 = "col-lg-3";
                    ?> 
                    <form id='allArticlesForm' action='' method='post' accept-charset='UTF-8'>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                                <div class="input-group">
                                    <input class="form-control" id="allArticlesSrchFor" type = "text" placeholder="Search For" value="<?php echo $srchFor; ?>" onkeyup="enterKeyFuncArticles(event, '', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                    <input id="allArticlesPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllArticles('clear', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </label>
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllArticles('', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                    <!--<select data-placeholder="Select..." class="form-control chosen-select" id="allArticlesSrchIn">
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
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allArticlesDsplySze" style="min-width:70px !important;">                            
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
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allArticlesSortBy">
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
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllArticles('', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-th-list"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="margin: 0px !important;">
                                        <li>
                                            <a href="javascript:getAllArticles('previous', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:getAllArticles('next', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>');" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="row" style="padding:0px 15px 0px 15px !important;">
                            <div class="jumbotron" style="border: 1px solid #ddd;border-radius: 2px;">
                                <div class="container-fluid">
                                    <!-- Example row of columns -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div style="">
                                                <h2>Heading</h2>
                                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="">
                                                <h2>Heading</h2>
                                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
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
                                                <span style=\"text-decoration:none;\">Articles List</span>
					</li>
                                       </ul>
                                     </div>";
                    $total = get_ArticleTtls($srchFor, $srchIn);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    } else if ($pageNo < 1) {
                        $pageNo = ceil($total / $lmtSze);
                    }

                    $curIdx = $pageNo - 1;
                    $result = get_Articles($srchFor, $srchIn, $curIdx, $lmtSze);
                    $cntr = 0;
                    $colClassType1 = "col-lg-2";
                    $colClassType2 = "col-lg-3";
                    $colClassType3 = "col-lg-1";
                    $colClassType4 = "col-lg-3";
                    ?>
                    <form id='allArticlesForm' action='' method='post' accept-charset='UTF-8'>
                        <div class="row" style="margin-bottom:10px;">
                            <?php
                            if ($canAddArticles === true) {
                                $isMaster = "1";
                                ?> 
                                <div class="<?php echo $colClassType1; ?>" style="padding:0px 1px 0px 15px !important;">                    
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'Add Person Basic Profile', -1, 0, 2, 'ADD')">
                                        <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                        New Article
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
                                    <input class="form-control" id="allArticlesSrchFor" type = "text" placeholder="Search For" value="<?php echo $srchFor; ?>" onkeyup="enterKeyFuncArticles(event, '', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                    <input id="allArticlesPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllArticles('clear', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </label>
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllArticles('', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                    <!--<select data-placeholder="Select..." class="form-control chosen-select" id="allArticlesSrchIn">
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
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allArticlesDsplySze" style="min-width:70px !important;">                            
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
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="allArticlesSortBy">
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
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllArticles('', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=0&isMaster=<?php echo $isMaster; ?>')">
                                        <span class="glyphicon glyphicon-th-large"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="margin: 0px !important;">
                                        <li>
                                            <a href="javascript:getAllArticles('previous', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:getAllArticles('next', '#allarticles', 'grp=40&typ=3&pg=0&vtyp=1&isMaster=<?php echo $isMaster; ?>');" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="row"> 
                            <div  class="col-md-12">
                                <table class="table table-striped table-bordered table-responsive" id="allArticlesTable" cellspacing="0" width="100%" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <?php if ($canEdtArticles === true) { ?>
                                                <th>...</th>
                                            <?php } ?>
                                            <th>Article Category</th>
                                            <th>Title</th>
                                            <th>Author Email</th>
                                            <th>No. of Hits</th>
                                            <th>...</th>
                                            <?php if ($canEdtArticles === true) { ?>
                                                <th>Published?</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = loc_db_fetch_array($result)) {
                                            $cntr += 1;
                                            ?>
                                            <tr id="allArticlesRow<?php echo $cntr; ?>">                                    
                                                <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <?php if ($canEdtArticles === true) { ?>                                    
                                                    <td>
                                                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit Article" 
                                                                onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'allArticlesForm', 'View/Edit Person Basic Profile', <?php echo $row[0]; ?>, 0, 2, 'EDIT')" style="padding:2px !important;" style="padding:2px !important;">
                                                            <img src="cmn_images/edit32.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                        </button>
                                                    </td>
                                                <?php } ?>
                                                <td><?php echo $row[1]; ?></td>
                                                <td><?php echo $row[2]; ?></td>
                                                <td><?php echo $row[8]; ?></td>
                                                <td><?php echo $row[10]; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Article" onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'View Person Basic Profile', <?php echo $row[0]; ?>, 0, 1, 'VIEW')" style="padding:2px !important;" style="padding:2px !important;">
                                                        <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                        <img src="cmn_images/kghostview.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                    </button>
                                                </td>
                                                <?php
                                                if ($canEdtArticles === true) {
                                                    if ($row[5] == 1) {
                                                        ?>
                                                        <td>
                                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Click to Unpublish" onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'View Person Basic Profile', <?php echo $row[0]; ?>, 0, 1, 'VIEW')" style="padding:2px !important;" style="padding:2px !important;">
                                                                <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                                <img src="cmn_images/success.gif" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                            </button>
                                                        </td>
                                                    <?php } else {
                                                        ?>
                                                        <td>
                                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Click to Publish" onclick="getBscProfileForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'dtAdmnBscPrsnPrflForm', 'View Person Basic Profile', <?php echo $row[0]; ?>, 0, 1, 'VIEW')" style="padding:2px !important;" style="padding:2px !important;">
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
                    
                }
            }
        }
    }
}

function get_Articles($searchFor, $searchIn, $offset, $limit_size) {
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

function deleteArticle($articleID) {
    $affctd1 = 0;

    $insSQL = "DELETE FROM self.self_articles WHERE article_id = " . $articleID;
    $affctd1 += execUpdtInsSQL($insSQL);

    if ($affctd1 > 0) {
        $dsply = "Successfully Deleted the ff Records-";
        $dsply .= "<br/>$affctd1 Article(s)!";
        return "<p style = \"text-align:left; color:#32CD32;font-weight:bold;font-style:italic;\">$dsply</p>";
    } else {
        $dsply = "No Record Deleted";
        return "<p style = \"text-align:left; color:red;font-weight:bold;font-style:italic;\">$dsply</p>";
    }
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

function get_ArticleTtls($searchFor, $searchIn) {
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
