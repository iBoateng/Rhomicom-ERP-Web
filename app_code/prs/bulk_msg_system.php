<?php
if (array_key_exists('lgn_num', get_defined_vars())) {

    $prsnid = $_SESSION['PRSN_ID'];
    $orgID = $_SESSION['ORG_ID'];
    $lnkdFirmID = getGnrlRecNm("prs.prsn_names_nos", "person_id", "lnkd_firm_org_id", $prsnid);
    $pkID = $prsnid;
    ?>

    <div class="modal fade" id="sndBlkMsgForm" tabindex="-1" role="dialog" aria-labelledby="sndBlkMsgFormTitle">
        <div class="modal-dialog" role="document"  style="width:90% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sndBlkMsgFormTitle">Send Bulk Email/SMS</h4>
                </div>
                <div class="modal-body" id="sndBlkMsgFormBody" style="border-bottom: none !important;">
                    <div class="">
                        <div class="row">                  
                            <div class="col-md-12">
                                <!--<div class="custDiv">-->                          
                                <form class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <fieldset class="basic_person_fs1" style="min-height:240px !important;">
                                                        <legend class="basic_person_lg">Destination Group</legend>
                                                        <div class="row">                                                        
                                                            <div class="col-md-7">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="msgType" class="control-label col-md-5" style="padding:0px 0px 0px 15px !important;">Message Type:</label>
                                                                    <div  class="col-md-7">
                                                                        <select class="form-control" id="msgType" style="min-width:75px !important;">
                                                                            <option value="Email">Email</option>                                            
                                                                            <option value="SMS">SMS</option>
                                                                            <option value="Inbox">System Inbox</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-check" style="font-size: 12px !important;">
                                                                    <label class="form-check-label">
                                                                        <input type="checkbox" class="form-check-input" id="sndMsgOneByOne" checked="true">
                                                                        Send Individually
                                                                    </label>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="grpType" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Group Type:</label>
                                                                    <div  class="col-md-9">
                                                                        <select class="form-control" id="grpType" >
                                                                            <option value="Everyone">Everyone</option>                                            
                                                                            <option value="Divisions/Groups">Divisions/Groups</option>
                                                                            <option value="Grade">Grade</option>
                                                                            <option value="Job">Job</option>
                                                                            <option value="Position">Position</option>
                                                                            <option value="Site/Location">Site/Location</option>
                                                                            <option value="Person Type">Person Type</option>
                                                                        </select>
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="groupName" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Group Name:</label>
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
                                                        </div>
                                                        <div class="row">                                                              
                                                            <div class="col-md-12">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="workPlaceName" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Workplace Name:</label>
                                                                    <div  class="col-md-9">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" aria-label="..." id="workPlaceName" value="" readonly="">
                                                                            <input type="hidden" id="workPlaceID" value="-1">
                                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'workPlaceID', 'workPlaceName', 'clear', 1, '');">
                                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="row">                                                              
                                                            <div class="col-md-12">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="workPlaceSiteName" class="control-label col-md-3" style="padding:0px 0px 0px 15px !important;">Site:</label>
                                                                    <div  class="col-md-9">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" aria-label="..." id="workPlaceSiteName" value="" readonly="">
                                                                            <input type="hidden" id="workPlaceSiteID" value="-1">
                                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'All Customers and Suppliers', 'gnrlOrgID', '', '', 'radio', true, '', 'workPlaceSiteID', 'workPlaceSiteName', 'clear', 1, '');">
                                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary" style="float:right;">Auto-Load E-mails</button>
                                                    </fieldset>
                                                </div>
                                            </div>                                               
                                            <div class="row">                                          
                                                <div class="col-md-12">
                                                    <fieldset class="basic_person_fs1">
                                                        <legend class="basic_person_lg">Message Parameters</legend>
                                                        <div class="form-group form-group-sm">
                                                            <label for="mailTo" class="control-label col-md-2">To:</label>
                                                            <div  class="col-md-10">
                                                                <div  class="col-xs-10" style="padding:0px 1px 0px 0px !important;">
                                                                    <textarea class="form-control" id="mailTo" cols="2" placeholder="To" rows="4"></textarea>
                                                                </div>
                                                                <div  class="col-xs-2" style="padding:0px 1px 0px 5px !important;">
                                                                    <button type="button" class="btn btn-default btn-sm" style="float:right;"><span class="glyphicon glyphicon-th-list"></span></button>
                                                                </div>
                                                            </div>
                                                        </div>                                         
                                                        <div class="form-group form-group-sm">
                                                            <label for="mailCc" class="control-label col-md-2">Cc:</label>
                                                            <div  class="col-md-10">
                                                                <div  class="col-xs-10" style="padding:0px 1px 0px 0px !important;">
                                                                    <input class="form-control" id="mailCc" type = "text" placeholder="Cc"/>
                                                                </div>
                                                                <div  class="col-xs-2" style="padding:0px 1px 0px 5px !important;">
                                                                    <button type="button" class="btn btn-default btn-sm" style="float:right;"><span class="glyphicon glyphicon-th-list"></span></button>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="mailBcc" class="control-label col-md-2">Bcc:</label>
                                                            <div  class="col-md-10">
                                                                <div  class="col-xs-10" style="padding:0px 1px 0px 0px !important;">
                                                                    <input class="form-control" id="mailBcc" type = "text" placeholder="Bcc"/>
                                                                </div>
                                                                <div  class="col-xs-2" style="padding:0px 1px 0px 5px !important;">
                                                                    <button type="button" class="btn btn-default btn-sm" style="float:right;"><span class="glyphicon glyphicon-th-list"></span></button>
                                                                </div>
                                                            </div>
                                                        </div>       

                                                        <div class="form-group form-group-sm">
                                                            <label for="mailAttchmnts" class="control-label col-md-2">Attached Files <span class="glyphicon glyphicon-paperclip"></span>:</label>
                                                            <div  class="col-md-10">
                                                                <div  class="col-xs-10" style="padding:0px 1px 0px 0px !important;">
                                                                    <textarea class="form-control" id="mailAttchmnts" cols="2" placeholder="Attachments" rows="3"></textarea>
                                                                </div>
                                                                <div  class="col-xs-2" style="padding:0px 1px 0px 5px !important;">
                                                                    <button type="button" class="btn btn-default btn-sm" style="float:right;"><span class="glyphicon glyphicon-th-list"></span></button>
                                                                </div>
                                                            </div>

                                                        </div> 
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>                                         
                                        <div class="col-md-8">
                                            <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Message Body</legend>
                                                <div class="row" style="margin: -5px 0px 0px 0px !important;padding:0px 15px 0px 15px !important;"> 
                                                    <div class="form-group form-group-sm">
                                                        <label for="mailSubject" class="control-label col-md-2">Subject:</label>
                                                        <div  class="col-md-10" style="padding:0px 1px 0px 15px !important;">
                                                            <input class="form-control" id="mailSubject" type = "text" placeholder="Subject"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding:0px 15px 0px 15px !important;">
                                                    <div id="summernote"></div> 
                                                </div> 
                                                <div class="row" style="margin: -5px 0px 0px 0px !important;"> 
                                                    <div class="col-md-6" style="padding:0px 0px 0px 1px !important;">&nbsp;</div>
                                                    <div class="col-md-6" style="padding:0px 0px 0px 0px">
                                                        <div class="col-md-5" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/reload.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">RESET</button></div>
                                                        <div class="col-md-7" style="padding:0px 1px 0px 1px !important;"><button type="button" class="btn btn-default btn-sm" style="width:100% !important;"><img src="cmn_images/Emailcon.png" style="left: 0.05%; padding-right: 2px; height:20px; width:auto; position: relative; vertical-align: middle;">SEND MESSAGE</button></div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                        </div>
                                    </div>   
                                </form>                           
                                <!--</div>-->                         
                            </div>                
                        </div>          
                    </div>                                          
                </div>
                <div class="modal-footer" style="border-top: none !important;">
                </div>
            </div>
        </div>
    </div> 

    <script type="text/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                minHeight: 375,
                focus: true
                        /*height: 100%//, // set editor height
                         // set minimum height of editor
                         //maxHeight: null, // set maximum height of editor
                         //focus: true*/
            });
            $('.note-editable').trigger('focus');
            /*$('.note-editable').focus();
             $('#summernote').find('.note-editable').focus();
             $('.summernote').summernote('focus');
             $('.modal-content').resizable({
             //alsoResize: ".modal-dialog",
             minHeight: 660,
             minWidth: 500
             });
             $('.modal-dialog').draggable();*/
            $('#sndBlkMsgForm').on('show.bs.modal', function (e) {
                $(this).find('.modal-body').css({
                    'max-height': '100%'
                });
            });
            $body.removeClass("mdlloadingDiag");
            $('#sndBlkMsgForm').modal('show');
            $body.removeClass("mdlloading");
        });
    </script>            

    <?php
}
?>
