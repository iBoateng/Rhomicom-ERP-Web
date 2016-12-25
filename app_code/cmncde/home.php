
                <!--<div class="col-md-3 colmd3special1">
                    <button type="button" class="btn btn-default btn-lg btn-block otherButton" onclick="openATab('#myinbox', 'grp=40&typ=2');">
                        <img src="cmn_images/openfileicon.png" style="margin:5px; padding-right: 1em; height:55px; width:auto; position: relative; vertical-align: middle;float:left;">
                        <span class="wordwrap1"> Inbox & Worklist</span>
                    </button>
                </div>
                <div class="col-md-3 colmd3special1">
                    <button type="button" class="btn btn-default btn-lg btn-block otherButton" onclick="openATab('#allnotices', 'grp=40&typ=3');">
                        <img src="cmn_images/Notebook.png" style="margin:5px; padding-right: 1em; height:55px; width:auto; position: relative; vertical-align: middle;float:left;">
                        <span class="wordwrap1"> Notices</span>
                    </button>
                </div>-->


<div class="row">
    <div class="col-md-12">
        <!-- Carousel-->
        <div class="row">
            <div class="col-md-12" style="padding:0px 16px 0px 15px;margin-top:1px;">
                <div id="myCarousel" class="carousel slide" data-ride="carousel" style="border: 1px solid #ccc;border-radius: 2px;padding:0px;background-color:#fff;">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img class="first-slide" src="<?php echo $lgn_image; ?>" alt="First slide" style="height: 250px !important;width: auto !important;">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h3>Example headline.</h3>
                                    <p><a class="btn btn-sm btn-primary" href="#" role="button">Sign up today</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h3>Another example headline.</h3>
                                    <p><a class="btn btn-sm btn-primary" href="#" role="button">Learn more</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h3>One more for good measure.</h3>
                                    <p><a class="btn btn-sm btn-primary" href="#" role="button">Browse gallery</a></p>
                                </div>
                            </div>
                        </div>
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding:0px 14px 0px 15px;margin-top:5px;">
                <div class="introMsg" style="">Welcome, MR. SYSTEM USER SETUP (RHO0002012) to the <?php echo $app_name; ?>!</div>
            </div>
        </div>
        <div class="row" style="padding:1px 1px 0px 1px;margin: -1px -15px 0px -15px;">
            <div class="col-md-3" style="padding:0px 13px 0px 15px;">
                <div class="panel" style="color:white;background-color:#5cb85c;border-radius:2px;border:1px solid #5cb85c;">
                    <a href="javascript:openATab('#myinbox', 'grp=40&typ=2');">
                        <div class="panel-heading" style="color:white;background-color:#5cb85c;border-radius:5px;border:1px solid #5cb85c;">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-envelope fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div class="huge">12</div>
                                    <div>My Inbox!</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer" style="color:white;background-color:#5cb85c;border-top:1px solid #5cb85c;">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3" style="padding:0px 13px 0px 15px;">
                <div class="panel panel-default" style="color:white;background-color:#337ab7;border-radius:2px;border:1px solid #337ab7;" >
                    <a href="javascript:openATab('#allnotices', 'grp=40&typ=3');">
                        <div class="panel-heading" style="color:white;background-color:#337ab7;border-radius:5px;border:1px solid #337ab7;">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div class="huge">26</div>
                                    <div>Unread Notices!</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer" style="color:white;background-color:#337ab7;border-top:1px solid #337ab7;">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3" style="padding:0px 13px 0px 15px;">
                <div class="panel panel-default" style="color:white;background-color:#f0ad4e;border-radius:2px;border:1px solid #f0ad4e;">
                    <a href="javascript:openATab('#allmodules', 'grp=8&typ=1&pg=1&vtyp=0');">
                        <div class="panel-heading" style="color:white;background-color:#f0ad4e;border-radius:5px;border:1px solid #f0ad4e;">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div class="huge">1</div>
                                    <div>Personal Profile!</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer" style="color:white;background-color:#f0ad4e;border-top:1px solid #f0ad4e;">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3" style="padding:0px 13px 0px 15px;">
                <div class="panel panel-default" style="color:white;background-color:#d9534f;border-radius:2px;border:1px solid #d9534f;">
                    <a href="javascript:openATab('#allmodules', 'grp=40&typ=5');">
                        <div class="panel-heading" style="color:white;background-color:#d9534f;border-radius:5px;border:1px solid #d9534f;">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-desktop fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div class="huge">13</div>
                                    <div>Apps/Modules!</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer" style="color:white;background-color:#d9534f;border-top:1px solid #d9534f;">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding:0px 1px 0px 1px;margin-top: -20px;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-default btn-lg btn-block otherButton" onclick="openATab('#allmodules', 'grp=8&typ=1');">
                        <img src="cmn_images/person.png" style="margin:5px; padding-right: 1em; height:55px; width:auto; position: relative; vertical-align: middle;float:left;">
                        <span class="wordwrap1"> Personal Records</span>
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-default btn-lg btn-block otherButton" onclick="openATab('#allmodules', 'grp=19&typ=10');">
                        <img src="cmn_images/election.png" style="margin:5px; padding-right: 1em; height:55px; width:auto; position: relative; vertical-align: middle;float:left;">
                        <span class="wordwrap1"> Elections Centre</span>
                    </button>
                </div>
                <!--id="gnrlDshBrd"
                 id="otherMdls"-->
                <div class="col-md-3">
                    <button type="button" class="btn btn-default btn-lg btn-block otherButton" onclick="openATab('#allmodules', 'grp=40&typ=4');">
                        <img src="cmn_images/dashboard220.png" style="margin:5px; padding-right: 1em; height:55px; width:auto; position: relative; vertical-align: middle;float:left;">
                        <span class="wordwrap1"> Summary Dashboard</span>
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-default btn-lg btn-block otherButton" onclick="openATab('#allmodules', 'grp=40&typ=5');">
                        <img src="cmn_images/Home.png" style="margin:5px; padding-right: 1em; height:55px; width:auto; position: relative; vertical-align: middle;float:left;">
                        <span class="wordwrap1"> All Other Modules</span>
                    </button>
                </div>
            </div>
        </div>
       
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
    <!-- /container --> 
</div>