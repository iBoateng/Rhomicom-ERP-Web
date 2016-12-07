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
                                                            <div class="col-md-6">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="msgType" class="control-label col-md-6">Message Type:</label>
                                                                    <div  class="col-md-6">
                                                                        <select class="form-control" id="msgType" >
                                                                            <option value=""></option>                                            
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                            <option value="Miss">Miss</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
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
                                                                    <label for="grpType" class="control-label col-md-3">Group Type:</label>
                                                                    <div  class="col-md-9">
                                                                        <select class="form-control" id="grpType" >
                                                                            <option value=""></option>                                            
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                            <option value="Miss">Miss</option>
                                                                        </select>
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="grpName" class="control-label col-md-3">Group Name:</label>
                                                                    <div  class="col-md-9">
                                                                        <select class="form-control" id="grpName" >
                                                                            <option value=""></option>                                            
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                            <option value="Miss">Miss</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">                                                              
                                                            <div class="col-md-8">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="wkplcName" class="control-label col-md-4">Workplace:</label>
                                                                    <div  class="col-md-8">
                                                                        <select class="form-control" id="wkplcName" >
                                                                            <option value=""></option>                                            
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                            <option value="Miss">Miss</option>
                                                                        </select>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group form-group-sm">
                                                                    <!--<label for="wkplcSite" class="control-label col-md-1">&nbsp;</label>-->
                                                                    <div  class="col-md-12">
                                                                        <select class="form-control" id="wkplcSite" >
                                                                            <option value=""></option>                                            
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                            <option value="Miss">Miss</option>
                                                                        </select>
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
                                                                <textarea class="form-control" id="mailTo" cols="2" placeholder="To" rows="3"></textarea>
                                                            </div>
                                                        </div>                                         
                                                        <div class="form-group form-group-sm">
                                                            <label for="mailCc" class="control-label col-md-2">Cc:</label>
                                                            <div  class="col-md-10">
                                                                <input class="form-control" id="mailCc" type = "text" placeholder="Cc"/>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group form-group-sm">
                                                            <label for="mailBcc" class="control-label col-md-2">Bcc:</label>
                                                            <div  class="col-md-10">
                                                                <input class="form-control" id="mailBcc" type = "text" placeholder="Bcc"/>
                                                            </div>
                                                        </div>       
                                                        <div class="form-group form-group-sm">
                                                            <label for="mailSubject" class="control-label col-md-4">Subject:</label>
                                                            <div  class="col-md-8">
                                                                <input class="form-control" id="mailSubject" type = "text" placeholder="Bcc"/>
                                                            </div>
                                                        </div>                                         
                                                        <div class="form-group form-group-sm">
                                                            <label for="mailAttchmnts" class="control-label col-md-4">Attachments:</label>
                                                            <div  class="col-md-8">
                                                                <textarea class="form-control" id="mailAttchmnts" cols="2" placeholder="Attachments" rows="2"></textarea>
                                                            </div>
                                                        </div> 
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>                                         
                                        <div class="col-md-8">
                                            <fieldset class="basic_person_fs2"><legend class="basic_person_lg">Message Body</legend>
                                                <div id="summernote"></div> 
                                                <div style="margin-top: 10px;">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/reload.png" style="left: 0.5%; padding-right: 1em; height:20px; width:auto; position: relative; vertical-align: middle;"> RESET</button>
                                                        <button type="button" class="btn btn-default btn-sm"><img src="cmn_images/Emailcon.png" style="left: 0.5%; padding-right: 1em; height:20px; width:auto; position: relative; vertical-align: middle;"> SEND MESSAGE</button>
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
                minHeight: 370,
                focus:true
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
        });
    </script>            

    <?php
}
?>
