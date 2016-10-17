<?php
if (array_key_exists('lgn_num', get_defined_vars())) {
    echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=8&typ=1&pg=$pgNo');\">
						<span class=\"divider\"> / </span><span style=\"text-decoration:none;\">Data Change Requests</span>
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
                    <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/edit32.png" style="left: 0.5%; padding-right: 1em; height:20px; width:auto; position: relative; vertical-align: middle;"> EDIT</button>
                    <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/FloppyDisk.png" style="left: 0.5%; padding-right: 1em; height:20px; width:auto; position: relative; vertical-align: middle;"> SAVE FOR LATER</button>
                    <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/Emailcon.png" style="left: 0.5%; padding-right: 1em; height:20px; width:auto; position: relative; vertical-align: middle;"> SUBMIT CHANGES</button>
                </div>
            </div>
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#prsnHome">Basic Person Data</a></li>
                    <li><a data-toggle="tab" href="#menu1">Additional Person Data</a></li>
                    <li><a data-toggle="tab" href="#menu2">Organization Assignments</a></li>
                    <li><a data-toggle="tab" href="#menu3">Curriculum Vitae</a></li>
                </ul>  

                <div class="row">                  
                    <div class="col-md-12">
                        <div class="custDiv"> 
                            <div class="tab-content">
                                <div id="prsnHome" class="tab-pane fadein active" style="border:none !important;">                          
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
                                                        <div  class="col-md-3">
                                                            <select class="form-control" id="idNo">
                                                                <option value=""></option>                                            
                                                                <option value="C">C</option>
                                                                <option value="E">E</option>
                                                                <option value="M">M</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input class="form-control" id="idNo" placeholder="ID No." value="<?php echo $row[1];?>">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="title" class="control-label col-md-4">Title:</label>
                                                        <div  class="col-md-8">
                                                            <select class="form-control" id="title" >
                                                                <option value=""></option>                                            
                                                                <option value="Mr.">Mr.</option>
                                                                <option value="Mrs.">Mrs.</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group form-group-sm">
                                                        <label for="firstName" class="control-label col-md-4">First Name:</label>
                                                        <div  class="col-md-8">
                                                            <input class="form-control" id="firstName" type = "text" placeholder="First Name"/>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="surName" class="control-label col-md-4">Surname:</label>
                                                        <div  class="col-md-8">
                                                            <input class="form-control" id="surName" type = "text" placeholder="Surname"/>
                                                        </div>
                                                    </div>     
                                                    <div class="form-group form-group-sm">
                                                        <label for="otherNames" class="control-label col-md-4">Other Names:</label>
                                                        <div  class="col-md-8">
                                                            <textarea class="form-control" id="otherNames" cols="2" placeholder="Other Names" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label for="gender" class="control-label col-md-4">Gender:</label>
                                                        <div  class="col-md-8">
                                                            <select class="form-control" id="gender" >
                                                                <option value=""></option>                                            
                                                                <option value="Male">Male</option>
                                                                <option value="Male">Female</option>
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
                                                                <option value=""></option>                                            
                                                                <option value="Single">Single</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Divorced">Divorced</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label for="dob" class="control-label col-md-4">Date of Birth</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type ="date" id="dob" value="2011-08-19">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="pob" class="control-label col-md-4">Place of Birth:</label>
                                                        <div  class="col-md-8">
                                                            <textarea class="form-control" id="pob" cols="2" placeholder="Place of Birth" rows="2"></textarea>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="nationality" class="control-label col-md-4">Nationality:</label>
                                                        <div  class="col-md-8">
                                                            <select class="form-control" id="title" >
                                                                <option value=""></option>                                            
                                                                <option value="Ghana">Ghana</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="United States">United States</option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group form-group-sm">
                                                        <label for="homeTown" class="control-label col-md-4">Home Town:</label>
                                                        <div  class="col-md-8">
                                                            <textarea class="form-control" id="pob" cols="2" placeholder="Home Town" rows="2"></textarea>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="religion" class="control-label col-md-4">Religion:</label>
                                                        <div  class="col-md-8">
                                                            <input class="form-control" id="surName" type = "text" placeholder="Religion"/>
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
                                                            <select class="form-control" id="linkedFirm" >
                                                                <option value=""></option>                                            
                                                                <option value="Mr.">Mr.</option>
                                                                <option value="Mrs.">Mrs.</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label for="branch" class="control-label col-md-4">Site/Branch:</label>
                                                        <div  class="col-md-8">
                                                            <select class="form-control" id="branch" >
                                                                <option value=""></option>                                            
                                                                <option value="Mr.">Mr.</option>
                                                                <option value="Mrs.">Mrs.</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group form-group-sm">
                                                        <label for="email" class="control-label col-md-4">Email:</label>
                                                        <div  class="col-md-8">
                                                            <input class="form-control" id="firstName" type = "email" placeholder="kofi@email.com"/>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="telephone" class="control-label col-md-4">Contact Nos:</label>
                                                        <div  class="col-md-4">
                                                            <input class="form-control" id="surName" type = "text" placeholder="Telephone"/>
                                                        </div>
                                                        <div  class="col-md-4">
                                                            <input class="form-control" id="surName" type = "text" placeholder="Mobile"/>
                                                        </div>                                        
                                                    </div>     
                                                    <div class="form-group form-group-sm">
                                                        <label for="fax" class="control-label col-md-4">Fax:</label>
                                                        <div  class="col-md-8">
                                                            <input class="form-control" id="surName" type = "text" placeholder="Fax"/>
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
                                                                <option value=""></option>                                            
                                                                <option value="Mr.">Mr.</option>
                                                                <option value="Mrs.">Mrs.</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>                                            
                                                    <div class="form-group form-group-sm">
                                                        <label for="causeOfRelation" class="control-label col-md-4">Cause of Relation:</label>
                                                        <div  class="col-md-8">
                                                            <select class="form-control" id="causeOfRelation" >
                                                                <option value=""></option>                                            
                                                                <option value="Mr.">Mr.</option>
                                                                <option value="Mrs.">Mrs.</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label for="furtherDetails" class="control-label col-md-4">Further Details:</label>
                                                        <div  class="col-md-8">
                                                            <select class="form-control" id="furtherDetails" >
                                                                <option value=""></option>                                            
                                                                <option value="Mr.">Mr.</option>
                                                                <option value="Mrs.">Mrs.</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group form-group-sm">
                                                        <label for="startDate" class="control-label col-md-4">Start Date:</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type ="date" id="startDate" value="2011-08-19">
                                                        </div>
                                                    </div>      
                                                    <div class="form-group form-group-sm">
                                                        <label for="endDate" class="control-label col-md-4">End Date:</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type ="date" id="endDate" value="2011-08-19">
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
                                                            <textarea class="form-control" id="pob" cols="2" placeholder="Postal Address" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label for="residentialAddress" class="control-label col-md-4">Residential Address:</label>
                                                        <div  class="col-md-8">
                                                            <textarea class="form-control" id="pob" cols="2" placeholder="Residential Address" rows="4"></textarea>
                                                        </div>
                                                    </div> 
                                                </fieldset>                                        
                                            </div>
                                            <div class="col-lg-8"> 
                                                <fieldset class="basic_person_fs3"><legend class="basic_person_lg">National ID Cards</legend>                                     
                                                    <div class="form-group form-group-sm">
                                                        <label for="natIDCards" class="control-label col-md-2 col-sm-2">National ID Cards:</label>
                                                        <div  class="col-md-8">National ID Cards
                                                            <!--<textarea class="form-control" id="natIDCards" cols="3" placeholder="National ID Cards" rows="9"></textarea>-->
                                                        </div>
                                                    </div> 
                                                </fieldset>
                                            </div>
                                        </div>  
                                    </form>  
                                </div>
                                <div id="menu1" class="tab-pane fade">Hello</div>
                                <div id="menu2" class="tab-pane fade">Hi</div>    
                                <div id="menu3" class="tab-pane fade">Hi One</div>   
                            </div>                        
                        </div>                         
                    </div>                
                </div>          
            </div>
            <?php
        }
    }
}
?>
