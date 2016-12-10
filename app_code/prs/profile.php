<?php
if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($vwtyp == "0") {
        /* onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\" */
        echo $cntent . "<li>
						<span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span><span style=\"text-decoration:none;\">Personal Profile</span>
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
                <div class="row" style="margin: 0px 0px 10px 0px !important;"> 
                    <div class="col-md-8" style="padding:0px 0px 0px 15px !important;">&nbsp;</div>
                    <div class="col-md-4" style="padding:0px 0px 0px 0px">
                        <div class="col-md-6" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm"  style="width:100% !important;" onclick="openATab('#allmodules', 'grp=8&typ=1&pg=2&vtyp=0');"><img src="cmn_images/edit32.png" style="left: 0.5%; padding-right: 1em; height:20px; width:auto; position: relative; vertical-align: middle;"> EDIT</button></div>
                        <div class="col-md-6" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/pdf.png" style="left: 0.5%; padding-right: 1em; height:20px; width:auto; position: relative; vertical-align: middle;"> GET PDF</button></div>
                    </div>
                </div>
                <div class="row" style="margin: 0px 0px 10px 0px !important;">
                    <div class="col-md-12" style="padding:0px 0px 0px 0px !important;">
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#allmodules', 'grp=8&typ=1&pg=1&vtyp=0');">Basic Data</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflAddPrsnDataRO', 'grp=8&typ=1&pg=1&vtyp=1');">Additional Data</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflOrgAsgnRO', 'grp=8&typ=1&pg=1&vtyp=2');">Organisational Assignments</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflCVRO', 'grp=8&typ=1&pg=1&vtyp=3');">Curriculum Vitae</button>
                        <button type="button" class="btn btn-default btn-sm phone-only-btn" onclick="openATab('#prflOthrInfoRO', 'grp=8&typ=1&pg=1&vtyp=4');">Other Information</button>
                    </div>
                </div>
                <div class="">
                    <ul class="nav nav-tabs rho-hideable-tabs" style="margin-top:-10px !important;">
                        <li class="active"><a data-toggle="tab" data-rhodata="&pg=1&vtyp=0" href="#prflHomeRO" id="prflHomeROtab">Basic Data</a></li>
                        <li><a data-toggle="tabajxprflro" data-rhodata="&pg=1&vtyp=1" href="#prflAddPrsnDataRO" id="prflAddPrsnDataROtab">Additional Data</a></li>
                        <li><a data-toggle="tabajxprflro" data-rhodata="&pg=1&vtyp=2" href="#prflOrgAsgnRO" id="prflOrgAsgnROtab">Organisational Assignments</a></li>
                        <li><a data-toggle="tabajxprflro" data-rhodata="&pg=1&vtyp=3" href="#prflCVRO" id="prflCVROtab">CV</a></li>
                        <li><a data-toggle="tabajxprflro" data-rhodata="&pg=1&vtyp=4" href="#prflOthrInfoRO" id="prflOthrInfoROtab">Other Information</a></li>
                    </ul>
                    <div class="row">                  
                        <div class="col-md-12">
                            <div class="custDiv"> 
                                <div class="tab-content">
                                    <div id="prflHomeRO" class="tab-pane fadein active" style="border:none !important;">                          
                                        <form class="form-horizontal">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs1"><legend class="basic_person_lg">Person's Picture</legend>
                                                        <div style="margin-bottom: 10px;">
                                                            <img src="<?php echo $pemDest . $myImgFileName; ?>" alt="..." id="img1Test" class="img-rounded center-block img-responsive" style="height: 200px !important; width: auto !important;">                                            
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
                                                                <span><?php echo $row[3]; ?></span>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="firstName" class="control-label col-md-4">First Name:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[4]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="surName" class="control-label col-md-4">Surname:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[5]; ?></span>
                                                            </div>
                                                        </div>     
                                                        <div class="form-group form-group-sm">
                                                            <label for="otherNames" class="control-label col-md-4">Other Names:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[6]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="gender" class="control-label col-md-4">Gender:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[8]; ?></span>
                                                            </div>
                                                        </div> 
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4"> 
                                                    <fieldset class="basic_person_fs1"><legend class="basic_person_lg">Personal Data</legend>
                                                        <div class="form-group form-group-sm">
                                                            <label for="maritalStatus" class="control-label col-md-4">Marital Status:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[9]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="dob" class="control-label col-md-4">Date of Birth</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row[10]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="pob" class="control-label col-md-4">Place of Birth:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[11]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="nationality" class="control-label col-md-4">Nationality:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[20]; ?></span>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="homeTown" class="control-label col-md-4">Home Town:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[19]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="religion" class="control-label col-md-4">Religion:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[12]; ?></span>
                                                            </div>
                                                        </div>                                              
                                                    </fieldset>   
                                                </div>
                                            </div>    
                                            <div class="row"><!-- ROW 1 -->
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs2"><legend class="basic_person_lg">QR Code</legend>
                                                        <div>
                                                            <img src="cmn_images/no_image.png" alt="..." id="imgQrCode" class="img-thumbnail center-block img-responsive" style="height: 200px !important; width: auto !important;">                                            
                                                        </div>                                       
                                                    </fieldset>
                                                </div>                                
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Contact Information</legend>
                                                        <div class="form-group form-group-sm">
                                                            <label for="linkedFirm" class="control-label col-md-4">Linked Firm/ Workplace</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[21]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="branch" class="control-label col-md-4">Site/Branch:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[22]; ?></span>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="email" class="control-label col-md-4">Email:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[15]; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="telephone" class="control-label col-md-4">Contact Nos:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo trim($row[16] . ", " . $row[17], ", ") ?></span>
                                                            </div>                                       
                                                        </div>     
                                                        <div class="form-group form-group-sm">
                                                            <label for="fax" class="control-label col-md-4">Fax:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[18]; ?></span>
                                                            </div>
                                                        </div> 
                                                    </fieldset>                                                
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Relationship with Organization</legend>                                    
                                                        <div class="form-group form-group-sm">
                                                            <label for="relation" class="control-label col-md-4">Relation:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[23]; ?></span>
                                                            </div>
                                                        </div>                                            
                                                        <div class="form-group form-group-sm">
                                                            <label for="causeOfRelation" class="control-label col-md-4">Cause of Relation:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[24]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="furtherDetails" class="control-label col-md-4">Further Details:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[25]; ?></span>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group form-group-sm">
                                                            <label for="startDate" class="control-label col-md-4">Start Date:</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row[26]; ?></span>
                                                            </div>
                                                        </div>      
                                                        <div class="form-group form-group-sm">
                                                            <label for="endDate" class="control-label col-md-4">End Date:</label>
                                                            <div class="col-md-8">
                                                                <span><?php echo $row[27]; ?></span>
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
                                                                <span><?php echo $row[14]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <label for="residentialAddress" class="control-label col-md-4">Residential Address:</label>
                                                            <div  class="col-md-8">
                                                                <span><?php echo $row[13]; ?></span>
                                                            </div>
                                                        </div> 
                                                    </fieldset>                                        
                                                </div>
                                                <div class="col-lg-8"> 
                                                    <fieldset class="basic_person_fs3"><legend class="basic_person_lg">National ID Cards</legend> 
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
                                                                <!--<tfoot>
                                                                    <tr>
                                                                        <th>Country</th>
                                                                        <th>ID Type</th>
                                                                        <th>ID No.</th>
                                                                        <th>Date Issued</th>
                                                                        <th>Expiry Date</th>
                                                                        <th>Other Information</th>
                                                                    </tr>
                                                                </tfoot>-->
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
                                                                    while ($row1 = loc_db_fetch_array($result1)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row1[1]; ?></td>
                                                                            <td><?php echo $row1[2]; ?></td>
                                                                            <td><?php echo $row1[3]; ?></td>
                                                                            <td><?php echo $row1[4]; ?></td>
                                                                            <td><?php echo $row1[5]; ?></td>
                                                                            <td><?php echo $row1[6]; ?></td>
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
                                    <div id="prflAddPrsnDataRO" class="tab-pane fadein" style="border:none !important;"></div>
                                    <div id="prflOrgAsgnRO" class="tab-pane fadein" style="border:none !important;"></div>    
                                    <div id="prflCVRO" class="tab-pane fadein" style="border:none !important;"></div>     
                                    <div id="prflOthrInfoRO" class="tab-pane fadein" style="border:none !important;"></div>   
                                </div>                        
                            </div>                         
                        </div>                
                    </div>          
                </div>
                <?php
            }
        }
    } else if ($vwtyp == "1") {
        /* Additional Person Data */
        $prsnid = $_SESSION['PRSN_ID'];
        $orgID = $_SESSION['ORG_ID'];
        $lnkdFirmID = getGnrlRecNm("prs.prsn_names_nos", "person_id", "lnkd_firm_org_id", $prsnid);
        $pkID = $prsnid;
        if ($pkID > 0) {
            $rcrdExst = prsn_Record_Exist($pkID);
            $result = get_PrsExtrDataGrps($orgID);
            ?>
            <form class="form-horizontal">
                <?php
                while ($row = loc_db_fetch_array($result)) {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="basic_person_fs4"><legend class="basic_person_lg"><?php echo $row[0]; ?></legend>
                                <?php
                                $result1 = get_PrsExtrDataGrpCols($row[0], $orgID);
                                $cntr1 = 0;
                                $gcntr1 = 0;
                                $cntr1Ttl = loc_db_num_rows($result1);
                                while ($row1 = loc_db_fetch_array($result1)) {
                                    /* POSSIBLE FIELDS
                                     * label
                                     * textbox (for now only this)
                                     * textarea (for now only this)
                                     * readonly textbox with button
                                     * readonly textbox with date
                                     * textbox with number validation
                                     */
                                    if ($row1[7] == "Tabular") {
                                        ?>
                                        <div class="row">
                                            <div  class="col-md-12">
                                                <table id="extDataTblCol<?php echo $row1[1]; ?>" class="table table-striped table-bordered table-responsive extPrsnDataTblRO"  cellspacing="0" width="100%" style="width:100%;"><thead><th>No.</th>
                                                    <?php
                                                    $fieldHdngs = $row1[11];
                                                    $arry1 = explode(",", $fieldHdngs);
                                                    $cntr = count($arry1);
                                                    for ($i = 0; $i < $row1[9]; $i++) {
                                                        if ($i <= $cntr - 1) {
                                                            ?>
                                                            <th><?php echo $arry1[$i]; ?></th>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <th>&nbsp;</th>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($rcrdExst === true) {
                                                            $chngRqstExst = prsn_ChngRqst_Exist($pkID);

                                                            if ($chngRqstExst > 0) {
                                                                $fldVal = get_PrsExtrData_Self($pkID, $row1[1]);
                                                            } else {
                                                                $fldVal = get_PrsExtrData($pkID, $row1[1]);
                                                            }
                                                        } else {
                                                            $fldVal = get_PrsExtrData($pkID, $row1[1]);
                                                        }

                                                        $arry3 = explode("|", $fldVal);
                                                        $cntr3 = count($arry3);
                                                        $maxsze = (int) 320 / $row1[9];
                                                        if ($maxsze > 100 || $maxsze < 80) {
                                                            $maxsze = 100;
                                                        }
                                                        for ($j = 0; $j < $cntr3; $j++) {
                                                            ?>
                                                            <tr><td><?php echo ($j + 1); ?></td>
                                                                <?php
                                                                $arry2 = explode("~", $arry3[$j]);
                                                                $cntr2 = count($arry2);
                                                                for ($i = 0; $i < $row1[9]; $i++) {
                                                                    if ($i <= $cntr2 - 1) {
                                                                        ?>
                                                                        <td><?php echo $arry2[$i]; ?></td>
                                                                    <?php } else { ?>
                                                                        <td>&nbsp;</td>
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
                                        <?php
                                    } else {
                                        if ($gcntr1 == 0) {
                                            $gcntr1 += 1;
                                        }
                                        if (($cntr1 % 2) == 0) {
                                            ?> 
                                            <div class="row"> 
                                                <?php
                                            }
                                            ?>
                                            <div class="col-md-6"> 
                                                <div class="form-group form-group-sm"> 
                                                    <label class="control-label col-md-4"><?php echo $row1[2]; ?>:</label>
                                                    <div  class="col-md-8">
                                                        <span>
                                                            <?php
                                                            if ($rcrdExst == true) {
                                                                $chngRqstExst = prsn_ChngRqst_Exist($pkID);

                                                                if ($chngRqstExst > 0) {
                                                                    echo get_PrsExtrData_Self($pkID, $row1[1]);
                                                                } else {
                                                                    echo get_PrsExtrData($pkID, $row1[1]);
                                                                }
                                                            } else {
                                                                echo get_PrsExtrData($pkID, $row1[1]);
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $cntr1 += 1;
                                            if (($cntr1 % 2) == 0 || $cntr1 == ($cntr1Ttl)) {
                                                $cntr1 = 0;
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                if ($gcntr1 == 1) {
                                    $gcntr1 = 0;
                                }
                                ?>
                            </fieldset>
                        </div>

                        <?php ?>
                    </div>
                    <?php
                }
            }
            ?>
        </form>
        <?php
    } else if ($vwtyp == "2") {
        /* Org Assignments */
        $prsnid = $_SESSION['PRSN_ID'];
        $orgID = $_SESSION['ORG_ID'];
        $pkID = $prsnid;
        $cntr = 0;
        ?> 
        <div class="row">
            <div class="col-lg-6"> 
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">DIVISIONS/GROUPS</legend> 
                    <div  class="col-md-12">
                        <table id="divsGroupsRO" class="table table-striped table-bordered table-responsive orgAsgnmentsTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Group Name</th>
                                    <th>Group Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $result1 = get_DivsGrps($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[6]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>
            <div class="col-lg-6"> 
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">IMMEDIATE SUPERVISORS</legend> 
                    <div  class="col-md-12">
                        <table id="immdteSprvsrsRO" class="table table-striped table-bordered table-responsive orgAsgnmentsTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID No. of Supervisor</th>
                                    <th>Name of Supervisor</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $cntr = 0;

                                    $result1 = get_Spvsrs($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                            <td><?php echo $row1[5]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">SITES/LOCATIONS</legend> 
                    <div  class="col-md-12">
                        <table id="sitesLocsRO" class="table table-striped table-bordered table-responsive orgAsgnmentsTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Site/Branch Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $cntr = 0;

                                    $result1 = get_SitesLocs($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>
            <div class="col-lg-6">
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">JOBS</legend> 
                    <div  class="col-md-12">
                        <table id="jobsRO" class="table table-striped table-bordered table-responsive orgAsgnmentsTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Job Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $cntr = 0;

                                    $result1 = get_Jobs($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>                                        
        </div>
        <div class="row">
            <div class="col-lg-6">
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">GRADES</legend> 
                    <div  class="col-md-12">
                        <table id="gradesRO" class="table table-striped table-bordered table-responsive orgAsgnmentsTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Grade Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $cntr = 0;

                                    $result1 = get_Grades($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>
            <div class="col-lg-6">
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">POSITIONS</legend> 
                    <div  class="col-md-12">
                        <table id="positionsRO" class="table table-striped table-bordered table-responsive orgAsgnmentsTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Position Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $cntr = 0;
                                    $result1 = get_Pos($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>                                        
        </div>
        <?php
    } else if ($vwtyp == "3") {
        /* Curiculumn Vitae */
        $prsnid = $_SESSION['PRSN_ID'];
        $orgID = $_SESSION['ORG_ID'];
        $pkID = $prsnid;
        $cntr = 0;
        ?> 
        <div class="row">
            <div class="col-md-12"> 
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">EDUCATIONAL BACKGROUND</legend> 
                    <div  class="col-md-12">
                        <table class="table table-striped table-bordered table-responsive cvTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>		
                                    <th>Course Name</th>
                                    <th>School/Institution</th>
                                    <th>School Location</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Certificate Obtained</th>
                                    <th>Certificate Type</th>
                                    <th>Date Awarded</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $result1 = get_EducBkgrd($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[1]; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                            <td><?php echo $row1[5]; ?></td>
                                            <td><?php echo $row1[6]; ?></td>
                                            <td><?php echo $row1[7]; ?></td>
                                            <td><?php echo $row1[8]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>
            <div class="col-md-12"> 
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">WORKING EXPERIENCE</legend> 
                    <div  class="col-md-12">
                        <table class="table table-striped table-bordered table-responsive cvTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>		
                                    <th>Job Name/Title</th>
                                    <th>Institution Name</th>
                                    <th>Job Location</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Job Description</th>
                                    <th>Feats/Achievements</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $result1 = get_WrkBkgrd($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[1]; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                            <td><?php echo $row1[5]; ?></td>
                                            <td><?php echo $row1[6]; ?></td>
                                            <td><?php echo $row1[7]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>
            <div class="col-md-12"> 
                <fieldset class="basic_person_fs4"><legend class="basic_person_lg">SKILLS/NATURE</legend> 
                    <div  class="col-md-12">
                        <table class="table table-striped table-bordered table-responsive cvTblsRO" cellspacing="0" width="100%" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>		
                                    <th>Languages</th>
                                    <th>Hobbies</th>
                                    <th>Interests</th>
                                    <th>Conduct</th>
                                    <th>Attitude</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pkID > 0) {
                                    $result1 = get_SkillNature($pkID);
                                    while ($row1 = loc_db_fetch_array($result1)) {
                                        $cntr += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $cntr; ?></td>
                                            <td><?php echo $row1[1]; ?></td>
                                            <td><?php echo $row1[2]; ?></td>
                                            <td><?php echo $row1[3]; ?></td>
                                            <td><?php echo $row1[4]; ?></td>
                                            <td><?php echo $row1[5]; ?></td>
                                            <td><?php echo $row1[6]; ?></td>
                                            <td><?php echo $row1[7]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </fieldset>
            </div>
        </div>
        <?php
    } else if ($vwtyp == "4") {
        /* Other Information */
        $prsnid = $_SESSION['PRSN_ID'];
        $orgID = $_SESSION['ORG_ID'];
        $pkID = $prsnid;
        $cntr = 0;
        $table_id = getMdlGrpID("Person Data", $mdlNm);
        $ext_inf_tbl_name = "prs.prsn_all_other_info_table";
        $ext_inf_seq_name = "prs.prsn_all_other_info_table_dflt_row_id_seq";
        $row_pk_id = $pkID;
        ?>
        <div  class="col-md-12">
            <table class="table table-striped table-bordered table-responsive otherInfoTblsRO" cellspacing="0" width="100%" style="width:100%;">
                <thead>
                    <tr>
                        <!--<th>No.</th>-->
                        <th>Category</th>
                        <th>Label</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($pkID > 0) {
                        $brghtsqlStr = "";
                        $result1 = getAllwdExtInfosNVals("%", "Extra Info Label", 0, 1000000000, $brghtsqlStr, $table_id, $row_pk_id, $ext_inf_tbl_name, $orgID);
                        while ($row1 = loc_db_fetch_array($result1)) {
                            $cntr += 1;
                            ?>
                            <tr>
                                <!--<td><?php echo $cntr; ?></td>-->
                                <td><?php echo $row1[0]; ?></td>
                                <td><?php echo $row1[1]; ?></td>
                                <td><?php echo $row1[2]; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
?>