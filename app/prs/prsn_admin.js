
function prepareDataAdmin(lnkArgs, htBody, targ, rspns)
{
    $body = htBody;
    if (lnkArgs.indexOf("&pg=7") !== -1)
    {
        $("#allOtherContent").html(rspns);
        $(document).ready(function () {
            var fileLink = function (context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="fa fa-file"/> Upload',
                    tooltip: 'Upload File',
                    click: function () {
                        $(function () {
                            $("#allOtherFileInput1").change(function () {
                                var fileName = $(this).val();
                                var input = document.getElementById('allOtherFileInput1');
                                sendNoticesFile(input.files[0], "", "", "OTHERS", function () {
                                    var inptUrl = $("#allOtherInputData1").val();
                                    var inptText = $("#allOtherInputData2").val();
                                    var inptNwWndw = $("#allOtherInputData2").val();
                                    if (inptText === "")
                                    {
                                        inptText = "Read More...";
                                    }
                                    if (inptNwWndw === "")
                                    {
                                        inptNwWndw = true;
                                    }
                                    $('#bulkMessageBody').summernote('createLink', {
                                        text: inptText,
                                        url: inptUrl,
                                        newWindow: inptNwWndw
                                    });
                                });
                            });
                        });
                        performFileClick('allOtherFileInput1');
                    }
                });
                return button.render();
            };
            $('#bulkMessageBody').summernote({
                minHeight: 375,
                focus: true,
                disableDragAndDrop: false,
                dialogsInBody: true,
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                    ['misc', ['print']],
                    ['mybutton', ['upload']]
                ],
                buttons: {
                    upload: fileLink
                },
                callbacks:
                        {
                            onImageUpload: function (file, editor, welEditable)
                            {
                                sendNoticesFile(file[0], editor, welEditable, "IMAGES", function () {
                                    var inptUrl = $("#allOtherInputData1").val();
                                    $('#bulkMessageBody').summernote("insertImage", inptUrl, 'filename');
                                });
                            }
                        }
            });
            $('.note-editable').trigger('focus');
            $('#sndBlkMsgForm').on('show.bs.modal', function (e) {
                $(this).find('.modal-body').css({
                    'max-height': '100%'
                });
            });
            $body.removeClass("mdlloadingDiag");
            $('#sndBlkMsgForm').modal({backdrop: 'static', keyboard: false});
            $body.removeClass("mdlloading");
        });
    } else {
        $(targ).html(rspns);
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            if (lnkArgs.indexOf("&pg=5&vtyp=0") !== -1
                    || lnkArgs.indexOf("&pg=6&vtyp=0") !== -1)
            {
                var table1 = $('#dataAdminTable').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "bFilter": false,
                    "scrollX": false
                });
                $('#dataAdminTable').wrap('<div class="dataTables_scroll"/>');
                $('#dataAdminForm').submit(function (e) {
                    e.preventDefault();
                    return false;
                });
            } else if (lnkArgs.indexOf("&pg=8&vtyp=0") !== -1)
            {
                var table1 = $('#extrDtColsTable').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "bFilter": false,
                    "scrollX": false
                });
                $('#extrDtColsTable').wrap('<div class="dataTables_scroll"/>');
                $('#extrDtColsForm').submit(function (e) {
                    e.preventDefault();
                    return false;
                });
            }
            htBody.removeClass("mdlloading");
        });
    }
}

function getDataAdmin(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#dataAdminSrchFor").val() === 'undefined' ? '%' : $("#dataAdminSrchFor").val();
    var srchIn = typeof $("#dataAdminSrchIn").val() === 'undefined' ? 'Both' : $("#dataAdminSrchIn").val();
    var pageNo = typeof $("#dataAdminPageNo").val() === 'undefined' ? 1 : $("#dataAdminPageNo").val();
    var limitSze = typeof $("#dataAdminDsplySze").val() === 'undefined' ? 10 : $("#dataAdminDsplySze").val();
    var sortBy = typeof $("#dataAdminSortBy").val() === 'undefined' ? '' : $("#dataAdminSortBy").val();
    if (actionText == 'clear')
    {
        srchFor = "%";
        pageNo = 1;
    } else if (actionText == 'next')
    {
        pageNo = parseInt(pageNo) + 1;
    } else if (actionText == 'previous')
    {
        pageNo = parseInt(pageNo) - 1;
    }
    linkArgs = linkArgs + "&searchfor=" + srchFor + "&searchin=" + srchIn +
            "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&sortBy=" + sortBy;
    openATab(slctr, linkArgs);
}

function enterKeyFuncDtAdmn(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getDataAdmin(actionText, slctr, linkArgs);
    }
}

function getBscProfileForm(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, personID, vtyp, pgNo, addOrEdit)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");
        $('#' + modalBodyID).html("");
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            /*code for IE7+, Firefox, Chrome, Opera, Safari*/
            xmlhttp = new XMLHttpRequest();
        } else
        {
            /*code for IE6, IE5*/
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                $('#' + titleElementID).html(formTitle);
                $('#' + modalBodyID).html(xmlhttp.responseText);
                /*$('.modal-dialog').draggable();*/
                if (pgNo == 1)
                {
                    var table1 = $('#nationalIDTblRO').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#nationalIDTblRO').wrap('<div class="dataTables_scroll" />');

                    $('[data-toggle="tabajxprflro"]').click(function (e) {
                        var $this = $(this);
                        var targ = $this.attr('href');
                        var dttrgt = $this.attr('data-rhodata');
                        var linkArgs = 'grp=8&typ=1' + dttrgt;
                        return openATab(targ, linkArgs);
                    });
                } else if (pgNo == 2)
                {
                    var table1 = $('#nationalIDTblEDT').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#nationalIDTblEDT').wrap('<div class="dataTables_scroll" />');
                    $('[data-toggle="tabajxprfledt"]').click(function (e) {
                        var $this = $(this);
                        var targ = $this.attr('href');
                        var dttrgt = $this.attr('data-rhodata');
                        var linkArgs = 'grp=8&typ=1' + dttrgt;
                        return openATab(targ, linkArgs);
                    });
                }
                $(function () {
                    $('.form_date').datetimepicker({
                        format: "dd-M-yyyy",
                        language: 'en',
                        weekStart: 0,
                        todayBtn: true,
                        autoclose: true,
                        todayHighlight: true,
                        keyboardNavigation: true,
                        startView: 2,
                        minView: 2,
                        maxView: 4,
                        forceParse: true
                    });
                });
                $('#' + elementID).off('show.bs.modal');
                $('#' + elementID).on('show.bs.modal', function (e) {
                    $(this).find('.modal-body').css({
                        'max-height': '100%'
                    });
                });
                $('#' + elementID).off('hidden.bs.modal');
                $('#' + elementID).on("hidden.bs.modal", function () {
                    getDataAdmin('', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=0');
                });
                $body.removeClass("mdlloadingDiag");
                $('#' + elementID).modal({backdrop: 'static', keyboard: false});
                $body.removeClass("mdlloading");
                $(document).ready(function () {
                    $('#' + formElementID).submit(function (e) {
                        e.preventDefault();
                        return false;
                    });

                });
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=8&typ=1&pg=" + pgNo + "&vtyp=" + vtyp + "&sbmtdPersonID=" + personID + "&addOrEdit=" + addOrEdit);
    });
}

function getBscProfile1Form(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, personID, vtyp, pgNo, addOrEdit)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            /*code for IE7+, Firefox, Chrome, Opera, Safari*/
            xmlhttp = new XMLHttpRequest();
        } else
        {
            /*code for IE6, IE5*/
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                $('#' + titleElementID).html(formTitle);
                $('#' + modalBodyID).html(xmlhttp.responseText);
                /*$('.modal-dialog').draggable();*/
                if (pgNo == 1)
                {
                    var table1 = $('#nationalIDTblRO').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#nationalIDTblRO').wrap('<div class="dataTables_scroll" />');

                    $('[data-toggle="tabajxprflro"]').click(function (e) {
                        var $this = $(this);
                        var targ = $this.attr('href');
                        var dttrgt = $this.attr('data-rhodata');
                        var linkArgs = 'grp=8&typ=1' + dttrgt;
                        return openATab(targ, linkArgs);
                    });
                } else if (pgNo == 2)
                {
                    var table1 = $('#nationalIDTblEDT').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#nationalIDTblEDT').wrap('<div class="dataTables_scroll" />');
                    $('[data-toggle="tabajxprfledt"]').click(function (e) {
                        var $this = $(this);
                        var targ = $this.attr('href');
                        var dttrgt = $this.attr('data-rhodata');
                        var linkArgs = 'grp=8&typ=1' + dttrgt;
                        return openATab(targ, linkArgs);
                    });
                }
                $(function () {
                    $('.form_date').datetimepicker({
                        format: "d-M-yyyy",
                        language: 'en',
                        weekStart: 0,
                        todayBtn: true,
                        autoclose: true,
                        todayHighlight: true,
                        keyboardNavigation: true,
                        startView: 2,
                        minView: 2,
                        maxView: 4,
                        forceParse: true
                    });
                });

                $('#' + elementID).off('show.bs.modal');
                $('#' + elementID).on('show.bs.modal', function (e) {
                    $(this).find('.modal-body').css({
                        'max-height': '100%'
                    });
                });
                $('#' + elementID).off('hidden.bs.modal');
                $('#' + elementID).on("hidden.bs.modal", function () {
                    getDataAdmin('', '#allmodules', 'grp=8&typ=1&pg=5&vtyp=1');
                });
                $body.removeClass("mdlloadingDiag");
                $('#' + elementID).modal({backdrop: 'static', keyboard: false});
                $body.removeClass("mdlloading");
                $(document).ready(function () {
                    $('#' + formElementID).submit(function (e) {
                        e.preventDefault();
                        return false;
                    });

                });
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=8&typ=1&pg=" + pgNo + "&vtyp=" + vtyp + "&sbmtdPersonID=" + personID + "&addOrEdit=" + addOrEdit);
    });
}

function getDivsGroupsForm(elementID, modalBodyID, titleElementID, formElementID,
        tRowElementID, formTitle, vtyp, addOrEdit, pKeyID, personID)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            /*code for IE7+, Firefox, Chrome, Opera, Safari*/
            xmlhttp = new XMLHttpRequest();
        } else
        {
            /*code for IE6, IE5*/
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                $('#' + titleElementID).html(formTitle);
                $('#' + modalBodyID).html(xmlhttp.responseText);
                $('#' + modalBodyID + 'Diag').draggable();
                $(function () {
                    $('.form_date').datetimepicker({
                        format: "d-M-yyyy",
                        language: 'en',
                        weekStart: 0,
                        todayBtn: true,
                        autoclose: true,
                        todayHighlight: true,
                        keyboardNavigation: true,
                        startView: 2,
                        minView: 2,
                        maxView: 4,
                        forceParse: true
                    });
                });

                if (addOrEdit === 'EDIT')
                {
                    /*Get various field element IDs and populate values*/
                    var $tds = $('#' + tRowElementID).find('td');
                    $('#divGrpName').val($.trim($tds.eq(1).text()));
                    $('#divGrpTyp').val($.trim($tds.eq(2).text()));
                    $('#divGrpStartDate').val($.trim($tds.eq(3).text()));
                    $('#divGrpEndDate').val($.trim($tds.eq(4).text()));
                }
                $('#' + elementID).on('show.bs.modal', function (e) {
                    $(this).find('.modal-body').css({
                        'max-height': '100%'
                    });
                });
                $body.removeClass("mdlloadingDiag");
                $('#' + elementID).modal({backdrop: 'static', keyboard: false});
                $body.removeClass("mdlloading");
                $(document).ready(function () {
                    $('#' + formElementID).submit(function (e) {
                        e.preventDefault();
                        return false;
                    });

                });
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&divsGrpsPkeyID=" + pKeyID + "&sbmtdPersonID=" + personID);
    });
}

function saveDivsGroupsForm(elementID, pKeyID, personID, tableElementID)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");
        var divGrpName = typeof $("#divGrpName").val() === 'undefined' ? '%' : $("#divGrpName").val();
        var divGrpTyp = typeof $("#divGrpTyp").val() === 'undefined' ? 'Both' : $("#divGrpTyp").val();
        var divGrpStartDate = typeof $("#divGrpStartDate").val() === 'undefined' ? 1 : $("#divGrpStartDate").val();
        var divGrpEndDate = typeof $("#divGrpEndDate").val() === 'undefined' ? 10 : $("#divGrpEndDate").val();
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            /*code for IE7+, Firefox, Chrome, Opera, Safari*/
            xmlhttp = new XMLHttpRequest();
        } else
        {
            /*code for IE6, IE5*/
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                $('#' + tableElementID).append('<tr><td></td><td colspan="6">' + xmlhttp.responseText + '</td></tr>');
                $body.removeClass("mdlloadingDiag");
                $body.removeClass("mdlloading");
                $('#' + elementID).modal('hide');
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=4" +
                "&divGrpName=" + divGrpName +
                "&divGrpTyp=" + divGrpTyp +
                "&divGrpStartDate=" + divGrpStartDate +
                "&divGrpEndDate=" + divGrpEndDate +
                "&divsGrpsPkeyID=" + pKeyID +
                "&sbmtdPersonID=" + personID);
    });
}

var prgstimerid;
var prgstimerid1;
function autoLoadAddresses()
{
    var msgType = typeof $("#msgType").val() === 'undefined' ? '' : $("#msgType").val();
    var sndMsgOneByOne = typeof $("#sndMsgOneByOne").val() === 'undefined' ? '' : $("#sndMsgOneByOne").val();
    var grpType = typeof $("#grpType").val() === 'undefined' ? '' : $("#grpType").val();
    var groupID = typeof $("#groupID").val() === 'undefined' ? '' : $("#groupID").val();
    var grpName = typeof $("#groupName").val() === 'undefined' ? '' : $("#groupName").val();
    var workPlaceID = typeof $("#workPlaceID").val() === 'undefined' ? -1 : $("#workPlaceID").val();
    var workPlaceSiteID = typeof $("#workPlaceSiteID").val() === 'undefined' ? -1 : $("#workPlaceSiteID").val();

    var mailTo = typeof $("#mailTo").val() === 'undefined' ? '' : $("#mailTo").val();
    var mailCc = typeof $("#mailCc").val() === 'undefined' ? '' : $("#mailCc").val();
    var mailBcc = typeof $("#mailBcc").val() === 'undefined' ? '' : $("#mailBcc").val();
    var mailAttchmnts = typeof $("#mailAttchmnts").val() === 'undefined' ? '' : $("#mailAttchmnts").val();
    var mailSubject = typeof $("#mailSubject").val() === 'undefined' ? '' : $("#mailSubject").val();

    var bulkMessageBody = typeof $("#bulkMessageBody").val() === 'undefined' ? '' : ($('#bulkMessageBody').summernote('code'));

    var dialog = bootbox.alert({
        title: 'Get Addresses',
        size: 'small',
        message: '<div id="myProgress"><div id="myBar"></div></div><div id="myInformation"><i class="fa fa-spin fa-spinner"></i> Getting Addresses...Please Wait...</div>',
        callback: function () {
            clearInterval(prgstimerid);
        }
    });
    dialog.init(function () {
        getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
            $body = $("body");
            $body.removeClass("mdlloading");
            $.ajax({
                method: "POST",
                url: "index.php",
                data: {
                    grp: 8,
                    typ: 1,
                    pg: 7,
                    q: 'UPDATE',
                    actyp: 1,
                    msgType: msgType,
                    sndMsgOneByOne: sndMsgOneByOne,
                    grpType: grpType,
                    grpName: grpName,
                    groupID: groupID,
                    workPlaceID: workPlaceID,
                    workPlaceSiteID: workPlaceSiteID,
                    mailTo: mailTo,
                    mailCc: mailCc,
                    mailBcc: mailBcc,
                    mailAttchmnts: mailAttchmnts,
                    mailSubject: mailSubject,
                    bulkMessageBody: bulkMessageBody
                }
            });
            prgstimerid = window.setInterval(rfrshGetAdrsPrgrs, 1000);
        });
    });
}

function rfrshGetAdrsPrgrs() {
    $.ajax({
        method: "POST",
        url: "index.php",
        data: {
            grp: 8,
            typ: 1,
            pg: 7,
            q: 'UPDATE',
            actyp: 2
        },
        success: function (data) {
            var elem = document.getElementById('myBar');
            elem.style.width = data.percent + '%';
            $("#myInformation").html(data.message);
            if (data.percent == 100) {
                window.clearInterval(prgstimerid);
                $('#mailTo').val(data.addresses);
            }
        }
    });
}

function autoQueueMsgs()
{
    var msgType = typeof $("#msgType").val() === 'undefined' ? '' : $("#msgType").val();
    var sndMsgOneByOne = typeof $("input[name='sndMsgOneByOne']:checked").val() === 'undefined' ? 'NO' : 'YES';
    var grpType = typeof $("#grpType").val() === 'undefined' ? '' : $("#grpType").val();
    var groupID = typeof $("#groupID").val() === 'undefined' ? '' : $("#groupID").val();
    var grpName = typeof $("#groupName").val() === 'undefined' ? '' : $("#groupName").val();
    var workPlaceID = typeof $("#workPlaceID").val() === 'undefined' ? -1 : $("#workPlaceID").val();
    var workPlaceSiteID = typeof $("#workPlaceSiteID").val() === 'undefined' ? -1 : $("#workPlaceSiteID").val();

    var mailTo = typeof $("#mailTo").val() === 'undefined' ? '' : $("#mailTo").val();
    var mailCc = typeof $("#mailCc").val() === 'undefined' ? '' : $("#mailCc").val();
    var mailBcc = typeof $("#mailBcc").val() === 'undefined' ? '' : $("#mailBcc").val();
    var mailAttchmnts = typeof $("#mailAttchmnts").val() === 'undefined' ? '' : $("#mailAttchmnts").val();
    var mailSubject = typeof $("#mailSubject").val() === 'undefined' ? '' : $("#mailSubject").val();
    var bulkMessageBody = typeof $("#bulkMessageBody").val() === 'undefined' ? '' : ($('#bulkMessageBody').summernote('code'));

    if (msgType === "SMS") {
        bulkMessageBody = bulkMessageBody.replace(/<\/p>/gi, " ")
                .replace(/<br\/?>/gi, " ")
                .replace(/<\/?[^>]+(>|$)/g, "");
        /*bulkMessageBody = bulkMessageBody.replace(/<\/p>/gi, "\n")
         .replace(/<br\/?>/gi, "\n")
         .replace(/<\/?[^>]+(>|$)/g, "");*/
    }
    if (mailSubject.trim() === '')
    {
        bootbox.alert({
            title: 'System Alert!',
            size: 'small',
            message: '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;">Subject cannot be empty!</span></p>'
        });
        return false;
    }
    if (bulkMessageBody.trim() === '')
    {
        bootbox.alert({
            title: 'System Alert!',
            size: 'small',
            message: '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;">Message Body cannot be empty!</span></p>'});
        return false;
    }
    if (rhotrim(mailTo, '; ') === '')
    {
        bootbox.alert({
            title: 'System Alert!',
            size: 'small',
            message: '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;">Mail To cannot be empty!</span></p>'});
        return false;
    }
    var dialog1 = bootbox.confirm({
        title: 'Queue Messages?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:green;font-weight:bold;font-style:italic;">SEND THIS MESSAGE</span> to the Indicated Receipients?<br/>Action cannot be Undone!</p>',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i> Yes',
                className: 'btn-success'
            },
            cancel: {
                label: '<i class="fa fa-times"></i> No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result === true)
            {
                var dialog = bootbox.alert({
                    title: 'Queue Messages',
                    size: 'small',
                    message: '<div id="myProgress"><div id="myBar"></div></div><div id="myInformation"><i class="fa fa-spin fa-spinner"></i> Queuing Messages...Please Wait...</div>',
                    callback: function () {
                        clearInterval(prgstimerid1);
                    }
                });
                dialog.init(function () {
                    getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
                        $body = $("body");
                        $body.removeClass("mdlloading");
                        $.ajax({
                            method: "POST",
                            url: "index.php",
                            data: {
                                grp: 8,
                                typ: 1,
                                pg: 7,
                                q: 'UPDATE',
                                actyp: 3,
                                msgType: msgType,
                                sndMsgOneByOne: sndMsgOneByOne,
                                grpType: grpType,
                                grpName: grpName,
                                groupID: groupID,
                                workPlaceID: workPlaceID,
                                workPlaceSiteID: workPlaceSiteID,
                                mailTo: mailTo,
                                mailCc: mailCc,
                                mailBcc: mailBcc,
                                mailAttchmnts: mailAttchmnts,
                                mailSubject: mailSubject,
                                bulkMessageBody: bulkMessageBody
                            }
                        });
                        prgstimerid1 = window.setInterval(rfrshQueueMsgsPrgrs, 1000);
                    });
                });
            }
        }
    });
}

function rfrshQueueMsgsPrgrs() {
    $.ajax({
        method: "POST",
        url: "index.php",
        data: {
            grp: 8,
            typ: 1,
            pg: 7,
            q: 'UPDATE',
            actyp: 4
        },
        success: function (data) {
            var elem = document.getElementById('myBar');
            elem.style.width = data.percent + '%';
            $("#myInformation").html(data.message);
            if (data.percent == 100) {
                window.clearInterval(prgstimerid1);
            }
        }
    });
}

function clearMsgForm()
{
    var dialog = bootbox.confirm({
        title: 'Clear Form?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">CLEAR</span> this Form?<br/>Action cannot be Undone!</p>',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i> Yes',
                className: 'btn-success'
            },
            cancel: {
                label: '<i class="fa fa-times"></i> No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result === true)
            {
                $("#mailTo").val('');
                $("#mailCc").val('');
                $("#mailBcc").val('');
                $("#mailAttchmnts").val('');
                $("#mailSubject").val('');
                $('#bulkMessageBody').summernote('code', '<p></p>');
            }
        }
    });
}

function attchFileToMsg()
{
    var crntAttchMnts = $("#mailAttchmnts").val();
    $("#allOtherFileInput3").change(function () {
        var fileName = $(this).val();
        var input = document.getElementById('allOtherFileInput3');
        sendMsgsFile(input.files[0], function () {
            var inptUrl = $("#allOtherInputData3").val();
            crntAttchMnts = crntAttchMnts + ";" + inptUrl;
            $("#mailAttchmnts").val(crntAttchMnts);
        });
    });
    performFileClick('allOtherFileInput3');
}

function sendMsgsFile(file, callBackFunc) {
    var data1 = new FormData();
    data1.append("file", file);
    $.ajax({
        url: "dwnlds/uploader1.php",
        data: data1,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            $("#allOtherInputData3").val(data);
            callBackFunc();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + " " + errorThrown);
        }
    });
}

function saveExtrDataCol(slctr, linkArgs)
{
    var slctdExtrDataCols = "";
    var isVld = true;
    var errMsg = "";
    $('#extrDtColsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            if (typeof $(el).attr('id') === 'undefined')
            {
                /*Do Nothing*/
            } else {
                var rndmNum = $(el).attr('id').split("_")[1];
                var fieldLbl = $('#extrDtColsRow' + rndmNum + '_FieldLbl').val();
                var colNum = $('#extrDtColsRow' + rndmNum + '_ColNum').val();
                if (typeof $('#extrDtColsRow' + rndmNum + '_ColNum').val() === 'undefined')
                {
                    isVld = false;
                }
                if (colNum.trim() === '')
                {
                    isVld = false;
                } else {
                    if (fieldLbl.trim() !== '') {
                        var dtTyp = $('#extrDtColsRow' + rndmNum + '_DtTyp').val();
                        if (dtTyp.trim() === '')
                        {
                            isVld = false;
                            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                                    'font-weight:bold;color:red;">Data Type for Column No. ' + colNum + ' cannot be empty!</span></p>';
                            $('#extrDtColsRow' + rndmNum + '_DtTyp').addClass('rho-error');
                        } else {
                            $('#extrDtColsRow' + rndmNum + '_DtTyp').removeClass('rho-error');
                        }
                        var ctgry = $('#extrDtColsRow' + rndmNum + '_Ctgry').val();
                        if (ctgry.trim() === '')
                        {
                            isVld = false;
                            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                                    'font-weight:bold;color:red;">Category for Column No. ' + colNum + ' cannot be empty!</span></p>';
                            $('#extrDtColsRow' + rndmNum + '_Ctgry').addClass('rho-error');
                        } else {
                            $('#extrDtColsRow' + rndmNum + '_Ctgry').removeClass('rho-error');
                        }
                        var dspTyp = $('#extrDtColsRow' + rndmNum + '_DspTyp').val();
                        if (dspTyp.trim() === '')
                        {
                            isVld = false;
                            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                                    'font-weight:bold;color:red;">Display Type for Column No. ' + colNum + ' cannot be empty!</span></p>';
                            $('#extrDtColsRow' + rndmNum + '_DspTyp').addClass('rho-error');
                        } else {
                            $('#extrDtColsRow' + rndmNum + '_DspTyp').removeClass('rho-error');
                        }
                        var dtLen = $('#extrDtColsRow' + rndmNum + '_DtLen').val();
                        if (dtLen.trim() === '')
                        {
                            $('#extrDtColsRow' + rndmNum + '_DtLen').val(200);
                        }
                        var order = $('#extrDtColsRow' + rndmNum + '_Order').val();
                        if (order.trim() === '')
                        {
                            $('#extrDtColsRow' + rndmNum + '_Order').val(1);
                        }
                        var tblColsNum = $('#extrDtColsRow' + rndmNum + '_TblColsNum').val();
                        if (tblColsNum.trim() === '')
                        {
                            if (dspTyp === 'Tabular')
                            {
                                $('#extrDtColsRow' + rndmNum + '_TblColsNum').val(1);
                            } else {
                                $('#extrDtColsRow' + rndmNum + '_TblColsNum').val(0);
                            }
                        }
                        var tblrColNms = $('#extrDtColsRow' + rndmNum + '_TblrColNms').val();
                        if (tblrColNms.trim() === '' && dspTyp === 'Tabular')
                        {
                            isVld = false;
                            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                                    'font-weight:bold;color:red;">Tabular Column Names for Column No. ' + colNum + ' cannot be empty!</span></p>';
                            $('#extrDtColsRow' + rndmNum + '_TblrColNms').addClass('rho-error');
                        } else {
                            $('#extrDtColsRow' + rndmNum + '_TblrColNms').removeClass('rho-error');
                            $('#extrDtColsRow' + rndmNum + '_TblrColNms').val('');
                        }
                    }
                }
                if (isVld === false)
                {
                    /*Do Nothing*/
                } else {
                    var isRqrd = typeof $("input[name='extrDtColsRow" + rndmNum + "_IsRqrd']:checked").val() === 'undefined' ? 'NO' : 'YES';
                    slctdExtrDataCols = slctdExtrDataCols + $('#extrDtColsRow' + rndmNum + '_ColNum').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_ExtrDtID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_FieldLbl').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_LovNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_DtTyp').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_Ctgry').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_DtLen').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_DspTyp').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_TblColsNum').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_Order').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#extrDtColsRow' + rndmNum + '_TblrColNms').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + isRqrd.replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
                }
            }
        }
    });
    if (rhotrim(errMsg, '; ') !== '')
    {
        bootbox.alert({
            title: 'System Alert!',
            /*size: 'small',*/
            message: errMsg});
        return false;
    }
    var dialog = bootbox.alert({
        title: 'Save Fields/Columns',
        size: 'small',
        message: '<p><i class="fa fa-spin fa-spinner"></i> Saving Fields/Columns...Please Wait...</p>',
        callback: function () {
            openATab(slctr, linkArgs);
        }
    });
    dialog.init(function () {
        getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
            $body = $("body");
            $body.removeClass("mdlloading");
            $.ajax({
                method: "POST",
                url: "index.php",
                data: {
                    grp: 8,
                    typ: 1,
                    pg: 8,
                    q: 'UPDATE',
                    actyp: 1,
                    slctdExtrDataCols: slctdExtrDataCols
                },
                success: function (result) {
                    setTimeout(function () {
                        dialog.find('.bootbox-body').html(result);
                    }, 500);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    /*dialog.find('.bootbox-body').html(errorThrown);*/
                    console.warn(jqXHR.responseText);
                }
            });
        });
    });
}

function delExtrDataCol(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var pKeyID = -1;
    var colNum = '';
    if (typeof $('#extrDtColsRow' + rndmNum + '_ExtrDtID').val() === 'undefined')
    {
        /*Do Nothing*/
    } else {
        pKeyID = $('#extrDtColsRow' + rndmNum + '_ExtrDtID').val();
        colNum = $('#extrDtColsRow' + rndmNum + '_ColNum').val();
    }
    var dialog = bootbox.confirm({
        title: 'Remove Field/Column?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">REMOVE</span> this Field/Column?<br/>Action cannot be Undone!</p>',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i> Yes',
                className: 'btn-success'
            },
            cancel: {
                label: '<i class="fa fa-times"></i> No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result === true)
            {
                var dialog1 = bootbox.alert({
                    title: 'Remove Field/Column?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Removing Field/Column...Please Wait...</p>'
                });
                dialog1.init(function () {
                    if (pKeyID > 0) {
                        getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
                            $body = $("body");
                            $body.removeClass("mdlloading");
                            $.ajax({
                                method: "POST",
                                url: "index.php",
                                data: {
                                    grp: 8,
                                    typ: 1,
                                    pg: 8,
                                    q: 'DELETE',
                                    actyp: 1,
                                    colNum: colNum,
                                    extrdataID: pKeyID
                                },
                                success: function (result1) {
                                    setTimeout(function () {
                                        dialog1.find('.bootbox-body').html(result1);
                                        if (result1.indexOf("Success") !== -1) {
                                            $("#" + rowIDAttrb).remove();
                                        }
                                    }, 500);
                                },
                                error: function (jqXHR1, textStatus1, errorThrown1)
                                {
                                    dialog1.find('.bootbox-body').html(errorThrown1);
                                }
                            });
                        });
                    } else
                    {
                        setTimeout(function () {
                            $("#" + rowIDAttrb).remove();
                            dialog1.find('.bootbox-body').html('Row Removed Successfully!');
                        }, 500);
                    }
                });
            }
        }
    });
}