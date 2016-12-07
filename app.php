<?php
if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num <= 0) {
        //echo $lgn_num; 
        ?>
        <?php
    } else {
        $prsnid = $_SESSION['PRSN_ID'];
        $orgID = $_SESSION['ORG_ID'];
        $lnkdFirmID = getGnrlRecNm("prs.prsn_names_nos", "person_id", "lnkd_firm_org_id", $prsnid);
        $nwFileName = $myImgFileName;
        $fullTmpDest = $fldrPrfx . $tmpDest . $nwFileName;
        $fullPemDest = $fldrPrfx . $pemDest . $nwFileName;
        $ftp_src = $ftp_base_db_fldr . "/Person/$prsnid" . '.png';
        if (file_exists($ftp_src) && !file_exists($fullPemDest)) {
            copy("$ftp_src", "$fullPemDest");
            //echo $fullPemDest;
        } else if (!file_exists($fullPemDest)) {
            $ftp_src = $fldrPrfx . 'cmn_images/image_up.png';
            copy("$ftp_src", "$fullPemDest");
            //echo $ftp_src;
        }
        ?> 
        <link href="cmn_scrpts/carousel.css?v=501234" rel="stylesheet">
        <link href="cmn_scrpts/bootstrap337/bootstrap3-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
        <link href="cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />  
        <link href="cmn_scrpts/bootstrap337/bootstrap-dtimepckr/css/bootstrap-datetimepicker.min.css"  rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="cmn_scrpts/jquery-ui-1121/jquery-ui.min.css">
        <link href="cmn_scrpts/summernote081/summernote.css" rel="stylesheet" type="text/css"/>
        <style>
            .icon-bar{<?php echo $bckcolorshv; ?>}
            .nav.navbar-top-links > li > a:hover,
            .nav.navbar-top-links > li > a:focus{
                <?php echo $forecolors; ?>
                <?php echo $bckcolorshv; ?>
                text-decoration: none;
            }
            .nav.navbar-top-links > li > a{
                <?php echo $forecolors; ?>
                <?php echo $bckcolors_home; ?>
                text-decoration: none;
            }
            .nav.nav-tabs > li > a:hover,
            .nav.nav-tabs > li > a:focus{
                <?php echo $forecolors; ?>
                <?php echo $bckcolorshv; ?>
                text-decoration: none;
            }
            .nav.nav-tabs>li.active>a, 
            .nav.nav-tabs>li.active>a:focus, 
            .nav.nav-tabs>li.active>a:hover {
                <?php echo $forecolors; ?>
                <?php echo $bckcolors_home; ?>
                border:1px solid <?php echo $bckcolorOnly; ?>
            }

            .page-header.navbar {
                <?php echo $bckcolors_home; ?>
                <?php echo $forecolors; ?>
                border-bottom: 1px solid #fff;
            }
            .page-top {
                <?php echo $bckcolors_home; ?>
                <?php echo $forecolors; ?>
            }
            .page-sidebar, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover {
                <?php echo $bckcolors_home; ?>
            }
            .page-sidebar .page-sidebar-menu>li.open>a, 
            .page-sidebar .page-sidebar-menu>li:hover>a, 
            .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li.open>a, 
            .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li:hover>a {
                <?php echo $bckcolorshv; ?>
                <?php echo $forecolors; ?>
            }
            .page-sidebar .page-sidebar-menu .sub-menu li>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu li>a {
                display: block;
                margin: 0;
                padding: 9px 14px 9px 30px;
                text-decoration: none;
                font-size: 14px;
                font-weight: 400;
                <?php echo $bckcolors_home; ?>
                <?php echo $forecolors; ?>
            }
            .page-sidebar .page-sidebar-menu .sub-menu>li.active>a, .page-sidebar .page-sidebar-menu .sub-menu>li.open>a, .page-sidebar .page-sidebar-menu .sub-menu>li:hover>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li.active>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li.open>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li:hover>a {
                <?php echo $bckcolorshv; ?>
                <?php echo $forecolors; ?>
            }
            @media (max-width: 767px){
                .page-top {
                    <?php echo $bckcolorshv; ?>
                    <?php echo $forecolors; ?>
                }
                .nav.navbar-top-links > li > a{
                    <?php echo $forecolors; ?>
                    <?php echo $bckcolorshv; ?>
                    text-decoration: none;
                }
            }
        </style>
        </head>
        <body class="rhBody mdlloading page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo" style="background-color:white;min-width: 360px;height:100% !important;width:100%  !important;">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <div style="float:left;left: 0.5%; min-width:90%;">
                            <a href="index.php"><img src="cmn_images/<?php echo $app_image1; ?>" style="float:left;height:60px; width:auto; margin:5px; position: relative; vertical-align: middle;" id="mainLogo"/></a>
                            <a class="navbar-brand" href="index.php" style="<?php echo $forecolors; ?>"><?php echo $app_name; ?></a>
                        </div> 
                        <div class="menu-toggler sidebar-toggler" style="float:right;">
                            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->                 
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN PAGE TOP -->
                    <div class="page-top">
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu">
                            <ul class="nav navbar-top-links navbar-right navbar-nav">                               
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="Forums/Chat Rooms">
                                        <i class="fa fa-wechat fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                        <span class="badge bg-success" style="background-color: red;float:right;">15</span>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:openATab('#profile', 'grp=40&typ=4&pg=0');" class="dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="Roles/Priviledges!">
                                        <i class="fa fa-user fa-fw" style="<?php echo $forecolors; ?>font-size: 19px;"></i> 
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:doAjax('q=changepassword','allmodules','OverwritePage','','','');" class="dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="Change Password!">
                                        <i class="fa fa-gear fa-fw" style="<?php echo $forecolors; ?>font-size: 19px;"></i> 
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript: logOutFunc();" class="dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="Logout!">
                                        <i class="fa fa-sign-out fa-fw" style="<?php echo $forecolors; ?>font-size: 19px;"></i> 
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:openATab('#allmodules', 'grp=8&typ=1&pg=1&vtyp=0');"  data-toggle="tooltip" title="User Profile!" data-placement="bottom" >
                                        <span class="username" style="<?php echo $forecolors; ?>font-weight: bold;"> <?php echo $usrName; ?> </span>
                                        <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                        <img alt="" class="img-circle" src="<?php echo $pemDest . $nwFileName; ?>" style="height: 45px !important; width: auto !important;"> 
                                    </a>
                                    <!-- /.dropdown-user -->
                                </li>
                                <!-- /.dropdown -->
                            </ul>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                    <!-- END PAGE TOP -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                            <li class="nav-item ">
                                <a href="javascript:;" style="<?php echo $forecolors; ?>min-height:45px !important;">
                                    <i class="fa fa-search-plus fa-fw" style="<?php echo $forecolors; ?>float:left;"></i> 
                                    <span class="title" style="float:right;max-width:88%;">
                                        <div class="input-group custom-search-form" style="float:right;margin-top:-7px;">
                                            <input type="text" class="form-control" placeholder="Search Articles...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </span>
                                </a>
                                <!-- /input-group -->
                            </li>
                            <li class="nav-item  ">
                                <a href="index.php" style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-home fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Home Page</span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-bar-chart-o fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Charts/Reports</span>
                                    <span class="fa arrow" style="<?php echo $forecolors; ?>"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">My Charts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">General Charts</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">Reports/Processes</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript: logOutFunc();" style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-sign-out fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Logout (<?php echo $usrName; ?>)</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-envelope fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Inbox/Worklist</span>
                                    <span class="badge bg-success" style="background-color: lime;float:right;">7</span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-wrench fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Self-Service</span>
                                    <span class="fa arrow" style="<?php echo $forecolors; ?>"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">Personal Records</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">Bills/Payments</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">Events/Attendances</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-files-o fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">e-Systems</span>
                                    <span class="fa arrow" style="<?php echo $forecolors; ?>"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">e-Voting</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">e-Library</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                            <span class="title">e-Learning</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-sitemap fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">All Other Modules</span>
                                    <span class="fa arrow" style="<?php echo $forecolors; ?>"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                            <i class="fa fa-key fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                            <span class="title">Administration</span> 
                                            <span class="fa arrow" style="<?php echo $forecolors; ?>"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">  
                                                    <i class="fa fa-user fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                                    <span class="title">System Administration</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">  
                                                    <i class="fa fa-group fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                                    <span class="title">Organisation Setup</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">  
                                                    <i class="fa fa-list-ul fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                                    <span class="title">Value Lists Setup</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">  
                                                    <i class="fa fa-globe fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                                    <span class="title">Workflow Administration</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                            <i class="fa fa-anchor fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                            <span class="title">Core Modules</span> 
                                            <span class="fa arrow" style="<?php echo $forecolors; ?>"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Accounting</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Basic Person Data</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Internal Payments</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Sales/Inventory</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Visits/Appointments</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Events/Attendance</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                            <i class="fa fa-desktop fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                            <span class="title">Specialty Modules</span> 
                                            <span class="fa arrow" style="<?php echo $forecolors; ?>"></span>
                                        </a>
                                        <ul class="sub-menu">                                                
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Hospitality Management</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Clinic/Hospital</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Banking/Microfinance</span>
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>"> 
                                                    <span class="title">Performance Management</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>

                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-comment fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Comments/Feedback</span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-wechat fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Forums/Chat Rooms</span>
                                    <span class="badge bg-success" style="background-color: red;float:right;">15</span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;"  class="nav-link " style="<?php echo $forecolors; ?>">
                                    <i class="fa fa-file-text-o fa-fw" style="<?php echo $forecolors; ?>"></i> 
                                    <span class="title">Help</span>
                                </a>
                            </li>
                        </ul>
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content" style="min-height:1080px">
                        <!-- BEGIN PAGE HEAD-->
                        <div class="page-head">
                        </div>
                        <!-- END PAGE HEAD-->
                        <!-- BEGIN PAGE BASE CONTENT -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs rho-hideable-tabs" role="tablist" style="padding-top:0px;" id="navtabheaders">
                            <li class="active"><a href="#home" id="hometab" data-toggle="tab" data-rhodata="1"><i class="fa fa-home fa-fw"></i><span class="nav-label">Home</span><span class="badge bg-success" style="background: none;">&nbsp;</span></a></li>
                            <li><a href="#myinbox" id="myinboxtab" data-toggle="tabajax" data-rhodata="2"><i class="fa fa-envelope fa-fw"></i><span class="nav-label">My Inbox&nbsp;&nbsp;</span><span class="badge bg-success" style="background-color: lime;">7</span></a></li>
                            <li><a href="#allarticles" id="allarticlestab" data-toggle="tabajax" data-rhodata="3"><i class="fa fa-file-text-o fa-fw"></i><span class="nav-label">All Articles&nbsp;&nbsp;</span><span class="badge bg-success" style="background-color: #f0ad4e;">24</span></a></li>
                            <li><a href="#profile" id="profiletab" data-toggle="tabajax" data-rhodata="4"><i class="fa fa-user fa-fw"></i><span class="nav-label">Profile&nbsp;&nbsp;</span><span class="badge bg-success" style="background: none;">&nbsp;</span></a></li>
                            <li><a href="#allmodules" id="allmodulestab" data-toggle="tabajax" data-rhodata="5"><i class="fa fa-sitemap fa-fw"></i><span class="nav-label">All Apps/Modules&nbsp;&nbsp;</span><span class="badge bg-success" style="background-color: cyan;color:#333;" id="appsMdlsCnt">13</span></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <?php require 'app_code/cmncde/home.php'; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="myinbox"></div>
                            <div role="tabpanel" class="tab-pane" id="allarticles"></div>
                            <div role="tabpanel" class="tab-pane" id="profile"></div>
                            <div role="tabpanel" class="tab-pane" id="allmodules"></div>
                            <!-- END PAGE BASE CONTENT -->
                        </div>
                        <!-- END CONTENT BODY -->
                    </div>
                    <!-- END CONTENT -->
                    <br/>
                </div>
                <!-- END CONTAINER -->

                <!-- BEGIN FOOTER -->
                <div class="page-footer">
                    <div style="min-height:20px;" style="<?php echo $bckcolors_home; ?>">
                        <div class="col-md-12" style="<?php echo $bckcolors_home; ?>color:#FFF;font-family: Times;font-style: italic;font-size:12px;text-align:center;border-top:1px solid #FFF;padding-top:5px;">
                            <p>Copyright &COPY; <?php echo date('Y'); ?> <a style="color:#FFF" href="<?php echo $about_url; ?>" target="_blank"><?php echo $app_org; ?></a>.</p>
                        </div>
                    </div>
                </div>
                <div class="modalLdng"></div>
                <!-- END FOOTER -->
                <!--[if lt IE 9]>

                <!-- jQuery -->
                <script src="cmn_scrpts/jquery-1.12.3.min.js"></script>
                <script type="text/javascript" src="cmn_scrpts/jquery-ui-1121/jquery-ui.min.js"></script>
                <!-- Bootstrap Core JavaScript -->
                <script src="cmn_scrpts/bootstrap337/js/bootstrap.min.js"></script>
                <script src="cmn_scrpts/bootstrap337/bootstrap3-dialog/js/bootstrap-dialog.min.js"></script>
                <script type="application/javascript" src="cmn_scrpts/global_scripts.js?v=50123456"></script> 
                <script src="cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
                <script src="cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/dataTables.bootstrap.min.js"></script>        
                <script type="text/javascript" src="cmn_scrpts/bootstrap337/bootstrap-dtimepckr/js/bootstrap-datetimepicker.min.js"></script>
                <script type="text/javascript" src="cmn_scrpts/summernote081/summernote.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                        $('[data-toggle="tabajax"]').click(function (e) {
                            var $this = $(this);
                            var targ = $this.attr('href');
                            var dttrgt = $this.attr('data-rhodata');
                            var linkArgs = 'grp=40&typ=' + dttrgt;
                            return openATab(targ, linkArgs);
                        });
                    });
                    $body = $("body");
                    $body.removeClass("mdlloading");
                </script>
        </body>

        </html>

        <?php
    }
}?>