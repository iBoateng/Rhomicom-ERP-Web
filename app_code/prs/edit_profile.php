<?php
if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($vwtyp == "0") {
        echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\">
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                                <span style=\"text-decoration:none;\">Data Change Requests</span>
					</li>
                                       </ul>
                                     </div>";
        $prsnid = $_SESSION['PRSN_ID'];
        $orgID = $_SESSION['ORG_ID'];
        $lnkdFirmID = getGnrlRecNm("prs.prsn_names_nos", "person_id", "lnkd_firm_org_id", $prsnid);
        $pkID = $prsnid;
        if ($pkID > 0) {
            $rcrdExst = prsn_Record_Exist($pkID);

            if ($rcrdExst == true) {
                $chngRqstExst = prsn_ChngRqst_Exist($pkID);

                if ($chngRqstExst > 0) {
                    $result = get_SelfPrsnDet($pkID);
                } else {
                    $result = get_PrsnDet($pkID);
                }
            } else {
                $result = get_PrsnDet($pkID);
            }

            while ($row = loc_db_fetch_array($result)) {
                ?>
                <div style="margin-bottom: 10px;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/FloppyDisk.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">SAVE</button>
                        <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/Emailcon.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">SUBMIT</button>
                        <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/info.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;"><span style="font-weight: bold;">STATUS: </span><span style="color:red;font-weight: bold;">Approved</span></button>
                    </div>
                </div>
                <div style="margin-bottom: 10px;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#allmodules', 'grp=8&typ=1&pg=2&vtyp=0');">Basic Data</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflAddPrsnDataEDT', 'grp=8&typ=1&pg=2&vtyp=1');">Additional Data</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflOrgAsgnEDT', 'grp=8&typ=1&pg=2&vtyp=2');">Organisational Assignments</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflCVEDT', 'grp=8&typ=1&pg=2&vtyp=3');">Curriculum Vitae</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflOthrInfoEDT', 'grp=8&typ=1&pg=2&vtyp=4');">Other Information</button>
                    </div>
                </div>
                <div class="">
                    <ul class="nav nav-tabs rho-hideable-tabs" style="margin-top:-30px !important;">
                        <li class="active"><a data-toggle="tab" data-rhodata="&pg=2&vtyp=0" href="#prflHomeEDT" id="prflHomeEDTtab">Basic Data</a></li>
                        <li><a data-toggle="tabajxprfledt" data-rhodata="&pg=2&vtyp=1" href="#prflAddPrsnDataEDT" id="prflAddPrsnDataEDTtab">Additional Data</a></li>
                        <li><a data-toggle="tabajxprfledt" data-rhodata="&pg=2&vtyp=2" href="#prflOrgAsgnEDT" id="prflOrgAsgnEDTtab">Organisational Assignments</a></li>
                        <li><a data-toggle="tabajxprfledt" data-rhodata="&pg=2&vtyp=3" href="#prflCVEDT" id="prflCVEDTtab">CV</a></li>
                        <li><a data-toggle="tabajxprfledt" data-rhodata="&pg=2&vtyp=4" href="#prflOthrInfoEDT" id="prflOthrInfoEDTtab">Other Information</a></li>
                    </ul>
                    <div class="row">                  
                        <div class="col-md-12">
                            <div class="custDiv"> 
                                <div class="tab-content">
                                    <div id="prflHomeEDT" class="tab-pane fadein active" style="border:none !important;">                          
                                        <form class="form-horizontal">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs1"><legend class="basic_person_lg">Person's Picture</legend>
                                                        <div style="margin-bottom: 10px;">
                                                            <img src="<?php echo $pemDest . $myImgFileName; ?>" alt="..." id="img1Test" class="img-rounded center-block img-responsive" style="height: 250px !important; width: auto !important;">                                            
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <label class="btn btn-primary btn-file input-group-addon">
                                                                        Browse... <input type="file" id="input1Test" name="input1Test" onchange="changeImgSrc(this, '#img1Test', '#img1SrcLoc');" class="btn btn-default"  style="display: none;">
                                                                    </label>
                                                                    <input type="text" class="form-control" aria-label="..." id="img1SrcLoc" value="">                                                        
                                                                </div>                                                    
                                                            </div>                                            
                                                        </div>                                        
                                                    </fieldset>
                                                </div>                                
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs1"><legend class="basic_person_lg">Names</legend>
                                                        <div class="form-group form-group-sm">
                                                            <label for="idNo" class="control-label col-md-4">ID No:</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row[1]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="title" class="control-label col-md-4">Title:</label>
                                                            <div  class="col-md-8">
                                                                <select class="form-control" id="title" >
                                                                    <?php
                                                                    $brghtStr = "";
                                                                    $isDynmyc = FALSE;
                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("Person Titles"), $isDynmyc, -1, "", "");
                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                        $selectedTxt = "";
                                                                        if ($titleRow[0] == $row[3]) {
                                                                            $selectedTxt = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="firstName" class="control-label col-md-4">First Name:</label>
                                                            <div  class="col-md-8">
                                                                <input class="form-control" id="firstName" type = "text" placeholder="First Name" value="<?php echo $row[4]; ?>"/>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="surName" class="control-label col-md-4">Surname:</label>
                                                            <div  class="col-md-8">
                                                                <input class="form-control" id="surName" type = "text" placeholder="Surname" value="<?php echo $row[5]; ?>"/>
                                                            </div>
                                                        </div>     
                                                        <div class="form-group form-group-sm">
                                                            <label for="otherNames" class="control-label col-md-4">Other Names:</label>
                                                            <div  class="col-md-8">
                                                                <textarea class="form-control" id="otherNames" cols="2" placeholder="Other Names" rows="3"><?php echo $row[6]; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="gender" class="control-label col-md-4">Gender:</label>
                                                            <div  class="col-md-8">
                                                                <select class="form-control" id="gender" >
                                                                    <?php
                                                                    $brghtStr = "";
                                                                    $isDynmyc = FALSE;
                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("Gender"), $isDynmyc, -1, "", "");
                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                        $selectedTxt = "";
                                                                        if ($titleRow[0] == $row[8]) {
                                                                            $selectedTxt = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div> 
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4"> 
                                                    <fieldset class="basic_person_fs1"><legend class="basic_person_lg">Personal Data</legend>
                                                        <div class="form-group form-group-sm">
                                                            <label for="maritalStatus" class="control-label col-md-4">Marital Status:</label>
                                                            <div  class="col-md-8">
                                                                <select class="form-control" id="maritalStatus" >
                                                                    <?php
                                                                    $brghtStr = "";
                                                                    $isDynmyc = FALSE;
                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("Marital Status"), $isDynmyc, -1, "", "");
                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                        $selectedTxt = "";
                                                                        if ($titleRow[0] == $row[9]) {
                                                                            $selectedTxt = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="dob" class="control-label col-md-4">Date of Birth</label>
                                                            <div class="col-md-8">
                                                                <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                    <input class="form-control" size="16" type="text" id="dob" value="<?php echo $row[10]; ?>" readonly="">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="pob" class="control-label col-md-4">Place of Birth:</label>
                                                            <div  class="col-md-8">
                                                                <textarea class="form-control" id="pob" cols="2" placeholder="Place of Birth" rows="2"><?php echo $row[11]; ?></textarea>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="nationality" class="control-label col-md-4">Nationality:</label>
                                                            <div class="col-md-8">
                                                                <select class="form-control" id="title" >
                                                                    <?php
                                                                    $brghtStr = "";
                                                                    $isDynmyc = FALSE;
                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("Nationalities"), $isDynmyc, -1, "", "");
                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                        $selectedTxt = "";
                                                                        if ($titleRow[0] == $row[20]) {
                                                                            $selectedTxt = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="homeTown" class="control-label col-md-4">Home Town:</label>
                                                            <div  class="col-md-8">
                                                                <textarea class="form-control" id="pob" cols="2" placeholder="Home Town" rows="2"><?php echo $row[19]; ?></textarea>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="religion" class="control-label col-md-4">Religion:</label>
                                                            <div  class="col-md-8">
                                                                <input class="form-control" id="religion" type = "text" placeholder="Religion" value="<?php echo $row[12]; ?>"/>
                                                            </div>
                                                        </div>                                              
                                                    </fieldset>   
                                                </div>
                                            </div>    
                                            <div class="row"><!-- ROW 1 -->
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs2"><legend class="basic_person_lg">QR Code</legend>
                                                        <div>
                                                            <img src="cmn_images/no_image.png" alt="..." id="imgQrCode" class="img-thumbnail center-block img-responsive" style="height: 250px !important; width: auto !important;">                                            
                                                        </div>                                       
                                                    </fieldset>
                                                </div>                                
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Contact Information</legend>
                                                        <div class="form-group form-group-sm">
                                                            <label for="linkedFirm" class="control-label col-md-4">Linked Firm/ Workplace</label>
                                                            <div  class="col-md-8">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" aria-label="..." id="lnkdFirmName" value="<?php echo $row[21]; ?>">
                                                                    <input type="hidden" id="gnrlOrgID" value="<?php echo $orgID; ?>">
                                                                    <input type="hidden" id="lnkdFirmID" value="<?php echo $row[28]; ?>">
                                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '<?php echo $row[21]; ?>', 'lnkdFirmID', 'lnkdFirmName', 'clear', 1, '');">
                                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="branch" class="control-label col-md-4">Site/Branch:</label>
                                                            <div  class="col-md-8">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" aria-label="..." id="lnkdFirmLoc" value="<?php echo $row[22]; ?>">  
                                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Customer/Supplier Sites', 'lnkdFirmID', '', '', 'radio', true, '<?php echo $row[21]; ?>', 'valueElmntID', 'lnkdFirmLoc', 'clear', 1, '');">
                                                                        <span class="glyphicon glyphicon-th-list"></span>                                                                            
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="email" class="control-label col-md-4">Email:</label>
                                                            <div  class="col-md-8">
                                                                <input class="form-control" id="prsEmail" type = "email" placeholder="<?php echo $admin_email; ?>" value="<?php echo $row[15]; ?>"/>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="telephone" class="control-label col-md-4">Contact Nos:</label>
                                                            <div  class="col-md-4">
                                                                <input class="form-control" id="telNo" type = "text" placeholder="Telephone" value="<?php echo $row[16]; ?>"/>
                                                            </div>
                                                            <div  class="col-md-4">
                                                                <input class="form-control" id="mobileNo" type = "text" placeholder="Mobile" value="<?php echo $row[17]; ?>"/>
                                                            </div>                                        
                                                        </div>     
                                                        <div class="form-group form-group-sm">
                                                            <label for="fax" class="control-label col-md-4">Fax:</label>
                                                            <div  class="col-md-8">
                                                                <input class="form-control" id="faxNo" type = "text" placeholder="Fax" value="<?php echo $row[18]; ?>"/>
                                                            </div>
                                                        </div> 
                                                    </fieldset>                                                
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Relationship with Organization</legend>                                    
                                                        <div class="form-group form-group-sm">
                                                            <label for="relation" class="control-label col-md-4">Relation:</label>
                                                            <div  class="col-md-8">
                                                                <select class="form-control" id="relation" >
                                                                    <?php
                                                                    $brghtStr = "";
                                                                    $isDynmyc = FALSE;
                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("Person Types"), $isDynmyc, -1, "", "");
                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                        $selectedTxt = "";
                                                                        if ($titleRow[0] == $row[23]) {
                                                                            $selectedTxt = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                            
                                                        <div class="form-group form-group-sm">
                                                            <label for="causeOfRelation" class="control-label col-md-4">Cause of Relation:</label>
                                                            <div  class="col-md-8">
                                                                <select class="form-control" id="relationCause" >
                                                                    <?php
                                                                    $brghtStr = "";
                                                                    $isDynmyc = FALSE;
                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("Person Type Change Reasons"), $isDynmyc, -1, "", "");
                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                        $selectedTxt = "";
                                                                        if ($titleRow[0] == $row[24]) {
                                                                            $selectedTxt = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="furtherDetails" class="control-label col-md-4">Further Details:</label>
                                                            <div  class="col-md-8">
                                                                <div class="input-group">
                                                                    <textarea class="form-control" aria-label="..." id="relationDetails"><?php echo $row[25]; ?></textarea>
                                                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Person Types-Further Details', '', '', '', 'radio', true, '<?php echo $row[25]; ?>', '', 'relationDetails', 'clear', 1, '');">
                                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="startDate" class="control-label col-md-4">Start Date:</label>
                                                            <div  class="col-md-8">
                                                                <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input3" data-link-format="yyyy-mm-dd">
                                                                    <input class="form-control" size="16" type="text" id="startDate" value="<?php echo $row[26]; ?>" readonly="">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div>
                                                            </div>
                                                        </div>      
                                                        <div class="form-group form-group-sm">
                                                            <label for="endDate" class="control-label col-md-4">End Date:</label>
                                                            <div  class="col-md-8">
                                                                <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input4" data-link-format="yyyy-mm-dd">
                                                                    <input class="form-control" size="16" type="text" id="endDate" value="<?php echo $row[27]; ?>" readonly="">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </fieldset>                                                
                                                </div>
                                            </div> 
                                            <div class="row"><!-- ROW 3 -->
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs3"><legend class="basic_person_lg">Address</legend> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="postalAddress" class="control-label col-md-4">Postal Address:</label>
                                                            <div  class="col-md-8">
                                                                <textarea class="form-control" id="pob" cols="2" placeholder="Postal Address" rows="4"><?php echo $row[14]; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="residentialAddress" class="control-label col-md-4">Residential Address:</label>
                                                            <div  class="col-md-8">
                                                                <textarea class="form-control" id="pob" cols="2" placeholder="Residential Address" rows="4"><?php echo $row[13]; ?></textarea>
                                                            </div>
                                                        </div> 
                                                    </fieldset>                                        
                                                </div>
                                                <div class="col-lg-8"> 
                                                    <fieldset class="basic_person_fs3 noshowOnPhones"><legend class="basic_person_lg">National ID Cards</legend> 
                                                        <div  class="col-md-12">
                                                            <table id="nationalIDTblRO" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%" style="width:100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Country</th>
                                                                        <th>ID Type</th>
                                                                        <th>ID No.</th>
                                                                        <th>Date Issued</th>
                                                                        <th>Expiry Date</th>
                                                                        <th>Other Information</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $rcrdExst = prsn_Record_Exist($pkID);
                                                                    if ($rcrdExst == true) {
                                                                        $chngRqstExst = prsn_ChngRqst_Exist($pkID);
                                                                        if ($chngRqstExst > 0) {
                                                                            $result1 = get_AllNtnlty_Self($pkID);
                                                                        } else {
                                                                            $result1 = get_AllNtnlty($pkID);
                                                                        }
                                                                    } else {
                                                                        $result1 = get_AllNtnlty($pkID);
                                                                    }
                                                                    $cntr = 0;
                                                                    while ($row1 = loc_db_fetch_array($result1)) {
                                                                        $cntr++;
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="form-control" id="ntnlIDCardsCountry<?php echo $cntr; ?>" >
                                                                                    <?php
                                                                                    $brghtStr = "";
                                                                                    $isDynmyc = FALSE;
                                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("Countries"), $isDynmyc, -1, "", "");
                                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                                        $selectedTxt = "";
                                                                                        if ($titleRow[0] == $row1[1]) {
                                                                                            $selectedTxt = "selected";
                                                                                        }
                                                                                        ?>
                                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control" id="ntnlIDCardsIDTyp<?php echo $cntr; ?>" >
                                                                                    <?php
                                                                                    $brghtStr = "";
                                                                                    $isDynmyc = FALSE;
                                                                                    $titleRslt = getLovValues("%", "Both", 0, 100, $brghtStr, getLovID("National ID Types"), $isDynmyc, -1, "", "");
                                                                                    while ($titleRow = loc_db_fetch_array($titleRslt)) {
                                                                                        $selectedTxt = "";
                                                                                        if ($titleRow[0] == $row1[2]) {
                                                                                            $selectedTxt = "selected";
                                                                                        }
                                                                                        ?>
                                                                                        <option value="<?php echo $titleRow[0]; ?>" <?php echo $selectedTxt; ?>><?php echo $titleRow[0]; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td><input class="form-control" id="ntnlIDCardsIDNo<?php echo $cntr; ?>" type = "text" placeholder="ID No." value="<?php echo $row1[3]; ?>"/></td>
                                                                            <td><input class="form-control" id="ntnlIDCardsDateIssd<?php echo $cntr; ?>" type = "text" placeholder="Date Issued" value="<?php echo $row1[4]; ?>"/></td>
                                                                            <td><input class="form-control" id="ntnlIDCardsExpDate<?php echo $cntr; ?>" type = "text" placeholder="Expiry Date" value="<?php echo $row1[5]; ?>"/></td>
                                                                            <td><textarea class="form-control" id="ntnlIDCardsCountry<?php echo $cntr; ?>" cols="2" placeholder="Other Information" rows="2"><?php echo $row1[6]; ?></textarea></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div> 
                                                    </fieldset>
                                                </div>
                                            </div>  
                                        </form>  
                                    </div>
                                    <div id="prflAddPrsnDataEDT" class="tab-pane fade"></div>
                                    <div id="prflOrgAsgnEDT" class="tab-pane fade"></div>    
                                    <div id="prflCVEDT" class="tab-pane fade"></div>    
                                    <div id="prflOthrInfoEDT" class="tab-pane fade"></div>   
                                </div>                        
                            </div>                         
                        </div>                
                    </div>          
                </div>
                <!--  style="min-width: 1000px;left:-35%;"-->
                <div class="modal fade" id="myLovModal" tabindex="-1" role="dialog" aria-labelledby="myLovModalTitle">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLovModalTitle"></h4>
                            </div>
                            <div class="modal-body" id="myLovModalBody" style="min-height: 300px;border-bottom: none !important;"></div>
                            <div class="modal-footer" style="border-top: none !important;">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    } else if ($vwtyp == 1) {
        
    }
}
?>
