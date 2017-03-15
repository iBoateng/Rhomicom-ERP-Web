
function prepareProfile(lnkArgs, htBody, targ, rspns)
{
    if (lnkArgs.indexOf("&pg=1") !== -1)
    {
        prepareProfileRO(lnkArgs, htBody, targ, rspns);
    } else if (lnkArgs.indexOf("&pg=2") !== -1)
    {
        prepareProfileEDT(lnkArgs, htBody, targ, rspns);
    } else if (lnkArgs.indexOf("&pg=5") !== -1
            || lnkArgs.indexOf("&pg=6") !== -1
            || lnkArgs.indexOf("&pg=7") !== -1
            || lnkArgs.indexOf("&pg=8") !== -1)
    {
        loadScript("app/prs/prsn_admin.js?v=110", function () {
            prepareDataAdmin(lnkArgs, htBody, targ, rspns);
        });
    } else {
        $(targ).html(rspns);
        htBody.removeClass("mdlloading");
    }
}

function prepareProfileRO(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=0") !== -1)
        {
            var table1 = $('#nationalIDTblRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#nationalIDTblRO').wrap('<div class="dataTables_scroll" />');
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="tabajxprflro"]').click(function (e) {
                    var $this = $(this);
                    var targ = $this.attr('href');
                    var dttrgt = $this.attr('data-rhodata');
                    var linkArgs = 'grp=8&typ=1' + dttrgt;
                    return openATab(targ, linkArgs);
                });
            });
        } else if (lnkArgs.indexOf("&vtyp=1") !== -1)
        {
            var table2 = $('.extPrsnDataTblRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
        } else if (lnkArgs.indexOf("&vtyp=2") !== -1)
        {
            var table2 = $('.orgAsgnmentsTblsRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
        } else if (lnkArgs.indexOf("&vtyp=3") !== -1)
        {
            var table2 = $('.cvTblsRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
        } else if (lnkArgs.indexOf("&vtyp=4") !== -1)
        {
            var table1 = $('#attchdDocsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#attchdDocsTable').wrap('<div class="dataTables_scroll"/>');
            $('#attchdDocsTblForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
            var table2 = $('.otherInfoTblsRO').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "bFilter": true,
                "scrollX": true
            });
        }
        htBody.removeClass("mdlloading");
    });
}


function prepareProfileEDT(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=0") !== -1)
        {
            var table1 = $('#nationalIDTblEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#nationalIDTblEDT').wrap('<div class="dataTables_scroll" />');
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
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
                    forceParse: false
                });
                $('[data-toggle="tabajxprfledt"]').click(function (e) {
                    var $this = $(this);
                    var targ = $this.attr('href');
                    var dttrgt = $this.attr('data-rhodata');
                    var linkArgs = 'grp=8&typ=1' + dttrgt;
                    //alert(linkArgs);
                    return openATab(targ, linkArgs);
                });
            });
        } else if (lnkArgs.indexOf("&vtyp=1") !== -1)
        {
            var table2 = $('.extPrsnDataTblEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('.extPrsnDataTblEDT').wrap('<div class="dataTables_scroll"/>');
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
        } else if (lnkArgs.indexOf("&vtyp=2") !== -1)
        {
            var table2 = $('.orgAsgnmentsTblsEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('.orgAsgnmentsTblsEDT').wrap('<div class="dataTables_scroll"/>');
        } else if (lnkArgs.indexOf("&vtyp=3") !== -1)
        {
            var table2 = $('.cvTblsEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('.cvTblsEDT').wrap('<div class="dataTables_scroll"/>');
        } else if (lnkArgs.indexOf("&vtyp=4") !== -1)
        {
            var table1 = $('#attchdDocsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#attchdDocsTable').wrap('<div class="dataTables_scroll"/>');
            $('#attchdDocsTblForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
            var table2 = $('.otherInfoTblsEDT').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "bFilter": true,
                "scrollX": false
            });
            $('.otherInfoTblsEDT').wrap('<div class="dataTables_scroll"/>');
        }
        htBody.removeClass("mdlloading");
    });
}

function getNtnlIDForm(elementID, modalBodyID, titleElementID, formElementID, tRowElementID, formTitle, vtyp, addOrEdit, pKeyID, ntnlIDPrsn)
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
                /*$('.modal-content').resizable({
                 //alsoResize: ".modal-dialog",
                 minHeight: 600,
                 minWidth: 300
                 });*/
                $('#myFormsModalDiag').draggable();
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
                    $('#ntnlIDpKey').val(pKeyID);
                    $('#ntnlIDCardsCountry').val($.trim($tds.eq(1).text()));
                    $('#ntnlIDCardsIDTyp').val($.trim($tds.eq(2).text()));
                    $('#ntnlIDCardsIDNo').val($.trim($tds.eq(3).text()));
                    $('#ntnlIDCardsDateIssd').val($.trim($tds.eq(4).text()));
                    $('#ntnlIDCardsExpDate').val($.trim($tds.eq(5).text()));
                    $('#ntnlIDCardsOtherInfo').val($.trim($tds.eq(6).text()));
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
        xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&ntnlIDpKey=" + pKeyID + "&ntnlIDPersonID=" + ntnlIDPrsn + "&tRowElmntNm=" + tRowElementID);
    });
}

function saveNtnlIDForm(elementID, tRowElementID, ntnlIDpKey, ntnlIDPersonID)
{
    getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
        var nicCountry = $("#ntnlIDCardsCountry").val() ? $("#ntnlIDCardsCountry").val() : '';
        var nicIDType = $("#ntnlIDCardsIDTyp").val() ? $("#ntnlIDCardsIDTyp").val() : '';
        var nicIDNo = typeof $("#ntnlIDCardsIDNo").val() === 'undefined' ? '' : $("#ntnlIDCardsIDNo").val();
        var nicDateIssd = typeof $("#ntnlIDCardsDateIssd").val() === 'undefined' ? '' : $("#ntnlIDCardsDateIssd").val();
        var nicExpDate = typeof $("#ntnlIDCardsExpDate").val() === 'undefined' ? '' : $("#ntnlIDCardsExpDate").val();
        var nicOtherInfo = typeof $("#ntnlIDCardsOtherInfo").val() === 'undefined' ? '' : $("#ntnlIDCardsOtherInfo").val();
        var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';


        var errMsg = "";
        if (nicCountry.trim().length <= 0)
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Country cannot be empty!</span></p>';
        }
        if (nicIDType.trim().length <= 0)
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">ID Type cannot be empty!</span></p>';
        }
        if (nicIDNo.trim() === '')
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">ID Number cannot be empty!</span></p>';
        }
        if (nicDateIssd.trim().length === 10)
        {
            nicDateIssd = '0' + nicDateIssd;
            $("#ntnlIDCardsDateIssd").val(nicDateIssd);
        }
        if (nicExpDate.trim().length === 10)
        {
            nicExpDate = '0' + nicExpDate;
            $("#ntnlIDCardsDateIssd").val(nicExpDate);
        }
        if (rhotrim(errMsg, '; ') !== '')
        {
            bootbox.alert({
                title: 'System Alert!',
                size: 'small',
                message: errMsg});
            return false;
        }
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
                $body.removeClass("mdlloadingDiag");
                $body.removeClass("mdlloading");
                if (xmlhttp.responseText.indexOf("Error") !== -1) {
                    /*Do Nothing*/
                    bootbox.alert({
                        title: 'System Alert!',
                        size: 'small',
                        message: xmlhttp.responseText});
                } else {
                    if (ntnlIDpKey <= 0) {
                        $('#nationalIDTblEDT').append(xmlhttp.responseText);
                    } else {
                        var $tds = $('#' + tRowElementID).find('td');
                        $tds.eq(1).text(nicCountry);
                        $tds.eq(2).text(nicIDType);
                        $tds.eq(3).text(nicIDNo);
                        $tds.eq(4).text(nicDateIssd);
                        $tds.eq(5).text(nicExpDate);
                        $tds.eq(6).text(nicOtherInfo);
                    }
                    var msg = '<span style="font-weight:bold;">Status: </span>' +
                            '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                    $("#mySelfStatusBtn").html(msg);
                    $('#' + elementID).modal('hide');
                }
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=3" +
                "&ntnlIDCardsCountry=" + nicCountry +
                "&ntnlIDCardsIDTyp=" + nicIDType +
                "&ntnlIDCardsIDNo=" + nicIDNo +
                "&ntnlIDCardsDateIssd=" + nicDateIssd +
                "&ntnlIDCardsExpDate=" + nicExpDate +
                "&ntnlIDCardsOtherInfo=" + nicOtherInfo +
                "&ntnlIDPersonID=" + ntnlIDPersonID +
                "&ntnlIDpKey=" + ntnlIDpKey +
                "&srcForm=" + srcForm);
    });
}

function delNtnlID(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
    var pKeyID = -1;
    if (typeof $('#ntnlIDCardsRow' + rndmNum + '_NtnlIDpKey').val() === 'undefined')
    {
        /*Do Nothing allnoticesRow<?php echo $cntr; ?> */
    } else {
        pKeyID = $('#ntnlIDCardsRow' + rndmNum + '_NtnlIDpKey').val();
    }
    var dialog = bootbox.confirm({
        title: 'Delete ID?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">DELETE</span> this ID?<br/>Action cannot be Undone!</p>',
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
                    title: 'Delete ID?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Deleting ID...Please Wait...</p>'
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
                                    pg: 2,
                                    q: 'DELETE',
                                    actyp: 3,
                                    ntnlIDpKey: pKeyID,
                                    srcForm: srcForm
                                },
                                success: function (result1) {
                                    setTimeout(function () {
                                        dialog1.find('.bootbox-body').html(result1);
                                        if (result1.indexOf("Success") !== -1) {
                                            $("#" + rowIDAttrb).remove();
                                            var msg = '<span style="font-weight:bold;">Status: </span>' +
                                                    '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                                            $("#mySelfStatusBtn").html(msg);
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

function getAddtnlDataForm(elementID, modalBodyID, titleElementID, formElementID,
        tRowElementID, formTitle, vtyp, addOrEdit, pKeyID, pipeSprtdFieldIDs, extDtColNum, tableElmntID)
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
                    var str_flds_array = pipeSprtdFieldIDs.split('|');
                    var $tds = $('#' + tRowElementID).find('td');
                    for (var i = 0; i < str_flds_array.length; i++) {
                        // Trim the excess whitespace.
                        var fldID = str_flds_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
                        $('#' + fldID).val($.trim($tds.eq(i + 1).text()));
                    }
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
        xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&addtnlPrsPkey=" + pKeyID +
                "&extDtColNum=" + extDtColNum
                + "&pipeSprtdFieldIDs=" + pipeSprtdFieldIDs +
                "&tableElmntID=" + tableElmntID + "&tRowElementID=" + tRowElementID
                + "&addOrEdit=" + addOrEdit);
    });
}

function saveAddtnlDataForm(modalBodyID, addtnlPrsPkey, pipeSprtdFieldIDs, extDtColNum, tableElmntID, tRowElementID, addOrEdit)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");
        var str_flds_array = pipeSprtdFieldIDs.split('|');
        var str_flds_array_val = pipeSprtdFieldIDs.split('|');
        var lnkArgs = "";
        var tdsAppend = "";
        var $tds = $('#' + tRowElementID).find('td');
        var rndmNum = Math.floor((Math.random() * 99999) + parseInt(extDtColNum));
        for (var i = 0; i < str_flds_array.length; i++) {
            // Trim the excess whitespace.
            var fldID = str_flds_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
            str_flds_array[i] = fldID;
            str_flds_array_val[i] = typeof $('#' + fldID).val() === 'undefined' ? '%' : $('#' + fldID).val();
            lnkArgs = lnkArgs + "&" + fldID + "=" + str_flds_array_val[i];
            if (addOrEdit === 'EDIT')
            {
                $tds.eq(i + 1).html(str_flds_array_val[i]);
            } else
            {
                tdsAppend = tdsAppend + "<td>" + str_flds_array_val[i] + "</td>";
            }
        }
        if (addOrEdit === 'ADD')
        {
            var btnHtml = '<td><button type="button" class="btn btn-default btn-sm" onclick="getAddtnlDataForm(\'myFormsModal\', \'myFormsModalBody\', \'myFormsModalTitle\', \'addtnlPrsnTblrDataForm\',' +
                    '\'prsExtrTblrDtCol_' + extDtColNum + '_Row' + rndmNum + '\', \'Add/Edit Data\', 12, \'EDIT\', ' + addtnlPrsPkey + ', \'' + pipeSprtdFieldIDs + '\', ' + extDtColNum + ', \'extDataTblCol_' + extDtColNum + '\');">' +
                    '<img src="cmn_images/edit32.png" style="height:20px; width:auto; position: relative; vertical-align: middle;"></button></td>';
            $('#' + tableElmntID).append('<tr id="prsExtrTblrDtCol_' + extDtColNum + '_Row' + rndmNum + '">' + btnHtml + tdsAppend + '</tr>');
        }
        var allTblValues = "";
        $('#' + tableElmntID).find('tr').each(function (i, el) {
            var $tds1 = $(this).find('td');
            for (var i = 0; i < str_flds_array.length; i++) {
                if (i == str_flds_array.length - 1)
                {
                    allTblValues = allTblValues + $tds1.eq(i + 1).text();
                } else {
                    allTblValues = allTblValues + $tds1.eq(i + 1).text() + "~";
                }
            }
            allTblValues = allTblValues + "|";
        });

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
                $body.removeClass("mdlloadingDiag");
                $body.removeClass("mdlloading");
                $('#' + modalBodyID).html(xmlhttp.responseText);
                var msg = '<span style="font-weight:bold;">Status: </span>' +
                        '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                $("#mySelfStatusBtn").html(msg);
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=4&addtnlPrsPkey=" + addtnlPrsPkey
                + "&extDtColNum=" + extDtColNum + "&tableElmntID=" + tableElmntID + "&allTblValues=" + allTblValues);
    });
}

function getEducBkgrdForm(elementID, modalBodyID, titleElementID, formElementID,
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
                    $('#educBkgrdCourseName').val($.trim($tds.eq(1).text()));
                    $('#educBkgrdSchool').val($.trim($tds.eq(2).text()));
                    $('#educBkgrdLoc').val($.trim($tds.eq(3).text()));
                    $('#educBkgrdStartDate').val($.trim($tds.eq(4).text()));
                    $('#educBkgrdEndDate').val($.trim($tds.eq(5).text()));
                    $('#educBkgrdCertObtnd').val($.trim($tds.eq(6).text()));
                    $('#educBkgrdCertTyp').val($.trim($tds.eq(7).text()));
                    $('#educBkgrdDateAwrded').val($.trim($tds.eq(8).text()));
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
        xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&educBkgrdPkeyID=" + pKeyID + "&sbmtdPersonID=" + personID + "&tRowElmntNm=" + tRowElementID);
    });
}

function saveEducBkgrdForm(elementID, pKeyID, personID, tRowElementID)
{
    getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
        var educBkgrdCourseName = typeof $("#educBkgrdCourseName").val() === 'undefined' ? '' : $("#educBkgrdCourseName").val();
        var educBkgrdSchool = typeof $("#educBkgrdSchool").val() === 'undefined' ? '' : $("#educBkgrdSchool").val();
        var educBkgrdLoc = typeof $("#educBkgrdLoc").val() === 'undefined' ? '' : $("#educBkgrdLoc").val();
        var educBkgrdStartDate = typeof $("#educBkgrdStartDate").val() === 'undefined' ? '' : $("#educBkgrdStartDate").val();
        var educBkgrdEndDate = typeof $("#educBkgrdEndDate").val() === 'undefined' ? '' : $("#educBkgrdEndDate").val();
        var educBkgrdCertObtnd = $("#educBkgrdCertObtnd").val() ? $("#educBkgrdCertObtnd").val() : '';
        var educBkgrdCertTyp = $("#educBkgrdCertTyp").val() ? $("#educBkgrdCertTyp").val() : '';
        var educBkgrdDateAwrded = typeof $("#educBkgrdDateAwrded").val() === 'undefined' ? '' : $("#educBkgrdDateAwrded").val();
        var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
        var errMsg = "";
        if (educBkgrdCourseName.trim().length <= 0)
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Course Name cannot be empty!</span></p>';
        }
        if (educBkgrdSchool.trim().length <= 0)
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">School/Institution cannot be empty!</span></p>';
        }
        if (educBkgrdLoc.trim() === '')
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Location cannot be empty!</span></p>';
        }
        if (educBkgrdStartDate.trim() === '')
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Start Date cannot be empty!</span></p>';
        }
        if (educBkgrdStartDate.trim().length === 10)
        {
            educBkgrdStartDate = '0' + educBkgrdStartDate;
            $("#educBkgrdStartDate").val(educBkgrdStartDate);
        }
        if (educBkgrdEndDate.trim().length === 10)
        {
            educBkgrdEndDate = '0' + educBkgrdEndDate;
            $("#educBkgrdEndDate").val(educBkgrdEndDate);
        }
        if (educBkgrdDateAwrded.trim().length === 10)
        {
            educBkgrdDateAwrded = '0' + educBkgrdDateAwrded;
            $("#educBkgrdDateAwrded").val(educBkgrdDateAwrded);
        }
        if (rhotrim(errMsg, '; ') !== '')
        {
            bootbox.alert({
                title: 'System Alert!',
                size: 'small',
                message: errMsg});
            return false;
        }
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
                $body.removeClass("mdlloadingDiag");
                $body.removeClass("mdlloading");
                if (xmlhttp.responseText.indexOf("Error") !== -1) {
                    /*Do Nothing*/
                    bootbox.alert({
                        title: 'System Alert!',
                        size: 'small',
                        message: xmlhttp.responseText});
                } else {
                    if (pKeyID <= 0) {
                        $('#educBkgrdTable').append(xmlhttp.responseText);
                    } else {
                        var $tds = $('#' + tRowElementID).find('td');
                        $tds.eq(1).text(educBkgrdCourseName);
                        $tds.eq(2).text(educBkgrdSchool);
                        $tds.eq(3).text(educBkgrdLoc);
                        $tds.eq(4).text(educBkgrdStartDate);
                        $tds.eq(5).text(educBkgrdEndDate);
                        $tds.eq(6).text(educBkgrdCertObtnd);
                        $tds.eq(7).text(educBkgrdCertTyp);
                        $tds.eq(8).text(educBkgrdDateAwrded);
                    }
                    var msg = '<span style="font-weight:bold;">Status: </span>' +
                            '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                    $("#mySelfStatusBtn").html(msg);
                    $('#' + elementID).modal('hide');
                }
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=11" +
                "&educBkgrdCourseName=" + educBkgrdCourseName +
                "&educBkgrdSchool=" + educBkgrdSchool +
                "&educBkgrdLoc=" + educBkgrdLoc +
                "&educBkgrdStartDate=" + educBkgrdStartDate +
                "&educBkgrdEndDate=" + educBkgrdEndDate +
                "&educBkgrdCertObtnd=" + educBkgrdCertObtnd +
                "&educBkgrdCertTyp=" + educBkgrdCertTyp +
                "&educBkgrdDateAwrded=" + educBkgrdDateAwrded +
                "&educBkgrdPkeyID=" + pKeyID +
                "&sbmtdPersonID=" + personID +
                "&srcForm=" + srcForm);
    });
}

function delEducID(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
    var pKeyID = -1;
    if (typeof $('#educBkgrdRow' + rndmNum + '_PKeyID').val() === 'undefined')
    {
        /*Do Nothing allnoticesRow<?php echo $cntr; ?> */
    } else {
        pKeyID = $('#educBkgrdRow' + rndmNum + '_PKeyID').val();
    }
    var dialog = bootbox.confirm({
        title: 'Delete Educ. Background?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">DELETE</span> this Educ. Background?<br/>Action cannot be Undone!</p>',
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
                    title: 'Delete Educ. Background?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Deleting Educ. Background...Please Wait...</p>'
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
                                    pg: 2,
                                    q: 'DELETE',
                                    actyp: 11,
                                    educBkgrdPkeyID: pKeyID,
                                    srcForm: srcForm
                                },
                                success: function (result1) {
                                    setTimeout(function () {
                                        dialog1.find('.bootbox-body').html(result1);
                                        if (result1.indexOf("Success") !== -1) {
                                            $("#" + rowIDAttrb).remove();
                                            var msg = '<span style="font-weight:bold;">Status: </span>' +
                                                    '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                                            $("#mySelfStatusBtn").html(msg);
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

function getWorkBkgrdForm(elementID, modalBodyID, titleElementID, formElementID,
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
                    $('#workBkgrdJobName').val($.trim($tds.eq(1).text()));
                    $('#workBkgrdInstitution').val($.trim($tds.eq(2).text()));
                    $('#workBkgrdLoc').val($.trim($tds.eq(3).text()));
                    $('#workBkgrdStartDate').val($.trim($tds.eq(4).text()));
                    $('#workBkgrdEndDate').val($.trim($tds.eq(5).text()));
                    $('#workBkgrdJobDesc').val($.trim($tds.eq(6).text()));
                    $('#workBkgrdAchvmnts').val($.trim($tds.eq(7).text()));
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
        xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&workBkgrdPkeyID=" + pKeyID + "&sbmtdPersonID=" + personID + "&tRowElmntNm=" + tRowElementID);
    });
}

function saveWorkBkgrdForm(elementID, pKeyID, personID, tRowElementID)
{
    getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
        var workBkgrdJobName = typeof $("#workBkgrdJobName").val() === 'undefined' ? '' : $("#workBkgrdJobName").val();
        var workBkgrdInstitution = typeof $("#workBkgrdInstitution").val() === 'undefined' ? '' : $("#workBkgrdInstitution").val();
        var workBkgrdLoc = typeof $("#workBkgrdLoc").val() === 'undefined' ? '' : $("#workBkgrdLoc").val();
        var workBkgrdStartDate = typeof $("#workBkgrdStartDate").val() === 'undefined' ? '' : $("#workBkgrdStartDate").val();

        var workBkgrdEndDate = typeof $("#workBkgrdEndDate").val() === 'undefined' ? '' : $("#workBkgrdEndDate").val();
        var workBkgrdJobDesc = typeof $("#workBkgrdJobDesc").val() === 'undefined' ? '' : $("#workBkgrdJobDesc").val();
        var workBkgrdAchvmnts = typeof $("#workBkgrdAchvmnts").val() === 'undefined' ? '' : $("#workBkgrdAchvmnts").val();
        var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';

        var errMsg = "";
        if (workBkgrdJobName.trim().length <= 0)
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Job Name cannot be empty!</span></p>';
        }
        if (workBkgrdInstitution.trim().length <= 0)
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Institution/Work place cannot be empty!</span></p>';
        }
        if (workBkgrdLoc.trim() === '')
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Location cannot be empty!</span></p>';
        }
        if (workBkgrdStartDate.trim() === '')
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Start Date cannot be empty!</span></p>';
        }
        if (workBkgrdStartDate.trim().length === 10)
        {
            workBkgrdStartDate = '0' + workBkgrdStartDate;
            $("#workBkgrdStartDate").val(workBkgrdStartDate);
        }
        if (workBkgrdEndDate.trim().length === 10)
        {
            workBkgrdEndDate = '0' + workBkgrdEndDate;
            $("#workBkgrdEndDate").val(workBkgrdEndDate);
        }
        if (rhotrim(errMsg, '; ') !== '')
        {
            bootbox.alert({
                title: 'System Alert!',
                size: 'small',
                message: errMsg});
            return false;
        }
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
                $body.removeClass("mdlloadingDiag");
                $body.removeClass("mdlloading");
                if (xmlhttp.responseText.indexOf("Error") !== -1) {
                    bootbox.alert({
                        title: 'System Alert!',
                        size: 'small',
                        message: xmlhttp.responseText});
                } else {
                    if (pKeyID <= 0) {
                        $('#workBkgrdTable').append(xmlhttp.responseText);
                    } else {
                        var $tds = $('#' + tRowElementID).find('td');
                        $tds.eq(1).text(workBkgrdJobName);
                        $tds.eq(2).text(workBkgrdInstitution);
                        $tds.eq(3).text(workBkgrdLoc);
                        $tds.eq(4).text(workBkgrdStartDate);
                        $tds.eq(5).text(workBkgrdEndDate);
                        $tds.eq(6).text(workBkgrdJobDesc);
                        $tds.eq(7).text(workBkgrdAchvmnts);
                    }
                    var msg = '<span style="font-weight:bold;">Status: </span>' +
                            '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                    $("#mySelfStatusBtn").html(msg);
                    $('#' + elementID).modal('hide');
                }
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=12" +
                "&workBkgrdJobName=" + workBkgrdJobName +
                "&workBkgrdInstitution=" + workBkgrdInstitution +
                "&workBkgrdLoc=" + workBkgrdLoc +
                "&workBkgrdStartDate=" + workBkgrdStartDate +
                "&workBkgrdEndDate=" + workBkgrdEndDate +
                "&workBkgrdJobDesc=" + workBkgrdJobDesc +
                "&workBkgrdAchvmnts=" + workBkgrdAchvmnts +
                "&workBkgrdPkeyID=" + pKeyID +
                "&sbmtdPersonID=" + personID +
                "&srcForm=" + srcForm);
    });
}

function delWorkID(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
    var pKeyID = -1;
    if (typeof $('#workBkgrdRow' + rndmNum + '_PKeyID').val() === 'undefined')
    {
        /*Do Nothing allnoticesRow<?php echo $cntr; ?> */
    } else {
        pKeyID = $('#workBkgrdRow' + rndmNum + '_PKeyID').val();
    }
    var dialog = bootbox.confirm({
        title: 'Delete Work Background?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">DELETE</span> this Work Background?<br/>Action cannot be Undone!</p>',
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
                    title: 'Delete Work Background?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Deleting Work Background...Please Wait...</p>'
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
                                    pg: 2,
                                    q: 'DELETE',
                                    actyp: 12,
                                    workBkgrdPkeyID: pKeyID,
                                    srcForm: srcForm
                                },
                                success: function (result1) {
                                    setTimeout(function () {
                                        dialog1.find('.bootbox-body').html(result1);
                                        if (result1.indexOf("Success") !== -1) {
                                            $("#" + rowIDAttrb).remove();
                                            var msg = '<span style="font-weight:bold;">Status: </span>' +
                                                    '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                                            $("#mySelfStatusBtn").html(msg);
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

function getSkillsForm(elementID, modalBodyID, titleElementID, formElementID,
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
                    $('#skillsLanguages').val($.trim($tds.eq(1).text()));
                    $('#skillsHobbies').val($.trim($tds.eq(2).text()));
                    $('#skillsInterests').val($.trim($tds.eq(3).text()));
                    $('#skillsConduct').val($.trim($tds.eq(4).text()));
                    $('#skillsAttitudes').val($.trim($tds.eq(5).text()));
                    $('#skillsStartDate').val($.trim($tds.eq(6).text()));
                    $('#skillsEndDate').val($.trim($tds.eq(7).text()));
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
        xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&skillsPkeyID=" + pKeyID + "&sbmtdPersonID=" + personID + "&tRowElmntNm=" + tRowElementID);
    });
}

function saveSkillsForm(elementID, pKeyID, personID, tRowElementID)
{
    getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
        var skillsLanguages = typeof $("#skillsLanguages").val() === 'undefined' ? '' : $("#skillsLanguages").val();
        var skillsHobbies = typeof $("#skillsHobbies").val() === 'undefined' ? '' : $("#skillsHobbies").val();
        var skillsInterests = typeof $("#skillsInterests").val() === 'undefined' ? '' : $("#skillsInterests").val();
        var skillsConduct = typeof $("#skillsConduct").val() === 'undefined' ? '' : $("#skillsConduct").val();

        var skillsAttitudes = typeof $("#skillsAttitudes").val() === 'undefined' ? '' : $("#skillsAttitudes").val();
        var skillsStartDate = typeof $("#skillsStartDate").val() === 'undefined' ? '' : $("#skillsStartDate").val();
        var skillsEndDate = typeof $("#skillsEndDate").val() === 'undefined' ? '' : $("#skillsEndDate").val();
        var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
        var errMsg = "";
        if (skillsLanguages.trim().length <= 0)
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Languages cannot be empty!</span></p>';
        }
        if (skillsStartDate.trim().length === 10)
        {
            skillsStartDate = '0' + skillsStartDate;
            $("#skillsStartDate").val(skillsStartDate);
        }
        if (skillsEndDate.trim().length === 10)
        {
            skillsEndDate = '0' + skillsEndDate;
            $("#skillsEndDate").val(skillsEndDate);
        }
        if (rhotrim(errMsg, '; ') !== '')
        {
            bootbox.alert({
                title: 'System Alert!',
                size: 'small',
                message: errMsg});
            return false;
        }

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
                $body.removeClass("mdlloadingDiag");
                $body.removeClass("mdlloading");
                if (xmlhttp.responseText.indexOf("Error") !== -1) {
                    bootbox.alert({
                        title: 'System Alert!',
                        size: 'small',
                        message: xmlhttp.responseText});
                } else {
                    if (pKeyID <= 0) {
                        $('#skillsTable').append(xmlhttp.responseText);
                    } else {
                        var $tds = $('#' + tRowElementID).find('td');
                        $tds.eq(1).text(skillsLanguages);
                        $tds.eq(2).text(skillsHobbies);
                        $tds.eq(3).text(skillsInterests);
                        $tds.eq(4).text(skillsConduct);
                        $tds.eq(5).text(skillsAttitudes);
                        $tds.eq(6).text(skillsStartDate);
                        $tds.eq(7).text(skillsEndDate);
                    }
                    var msg = '<span style="font-weight:bold;">Status: </span>' +
                            '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                    $("#mySelfStatusBtn").html(msg);
                    $('#' + elementID).modal('hide');
                }
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=13" +
                "&skillsLanguages=" + skillsLanguages +
                "&skillsHobbies=" + skillsHobbies +
                "&skillsInterests=" + skillsInterests +
                "&skillsConduct=" + skillsConduct +
                "&skillsAttitudes=" + skillsAttitudes +
                "&skillsStartDate=" + skillsStartDate +
                "&skillsEndDate=" + skillsEndDate +
                "&skillsPkeyID=" + pKeyID +
                "&sbmtdPersonID=" + personID +
                "&srcForm=" + srcForm);
    });
}

function delSkillID(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
    var pKeyID = -1;
    if (typeof $('#skillsTblRow' + rndmNum + '_PKeyID').val() === 'undefined')
    {
        /*Do Nothing allnoticesRow<?php echo $cntr; ?> */
    } else {
        pKeyID = $('#skillsTblRow' + rndmNum + '_PKeyID').val();
    }
    var dialog = bootbox.confirm({
        title: 'Delete Skill?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">DELETE</span> this Skill?<br/>Action cannot be Undone!</p>',
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
                    title: 'Delete Skill?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Deleting Skill...Please Wait...</p>'
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
                                    pg: 2,
                                    q: 'DELETE',
                                    actyp: 13,
                                    skillsPkeyID: pKeyID,
                                    srcForm: srcForm
                                },
                                success: function (result1) {
                                    setTimeout(function () {
                                        dialog1.find('.bootbox-body').html(result1);
                                        if (result1.indexOf("Success") !== -1) {
                                            $("#" + rowIDAttrb).remove();
                                            var msg = '<span style="font-weight:bold;">Status: </span>' +
                                                    '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                                            $("#mySelfStatusBtn").html(msg);
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

function saveBasicPrsnData(actTyp, shdSbmt)
{
    if (typeof shdSbmt === 'undefined' || shdSbmt === null)
    {
        shdSbmt = 0;
    }
    var daPersonID = typeof $("#daPersonID").val() === 'undefined' ? -1 : $("#daPersonID").val();
    var daPrsnLocalID = typeof $("#daPrsnLocalID").val() === 'undefined' ? '' : $("#daPrsnLocalID").val();
    var daTitle = $("#daTitle").val() ? $("#daTitle").val() : '';
    var daFirstName = typeof $("#daFirstName").val() === 'undefined' ? '' : $("#daFirstName").val();
    var daSurName = typeof $("#daSurName").val() === 'undefined' ? '' : $("#daSurName").val();
    var daOtherNames = typeof $("#daOtherNames").val() === 'undefined' ? '' : $("#daOtherNames").val();
    var daGender = $("#daGender").val() ? $("#daGender").val() : '';

    var daMaritalStatus = $("#daMaritalStatus").val() ? $("#daMaritalStatus").val() : '';
    var daDOB = typeof $("#daDOB").val() === 'undefined' ? '' : $("#daDOB").val();
    var daPOB = typeof $("#daPOB").val() === 'undefined' ? '' : $("#daPOB").val();
    var daNationality = $("#daNationality").val() ? $("#daNationality").val() : '';
    var daHomeTown = typeof $("#daHomeTown").val() === 'undefined' ? '' : $("#daHomeTown").val();
    var daReligion = typeof $("#daReligion").val() === 'undefined' ? '' : $("#daReligion").val();

    var daCompany = typeof $("#daCompany").val() === 'undefined' ? '' : $("#daCompany").val();
    var daCompanyLoc = typeof $("#daCompanyLoc").val() === 'undefined' ? '' : $("#daCompanyLoc").val();
    var daEmail = typeof $("#daEmail").val() === 'undefined' ? '' : $("#daEmail").val();
    var daTelNos = typeof $("#daTelNos").val() === 'undefined' ? '' : $("#daTelNos").val();
    var daMobileNos = typeof $("#daMobileNos").val() === 'undefined' ? '' : $("#daMobileNos").val();
    var daFaxNo = typeof $("#daFaxNo").val() === 'undefined' ? '' : $("#daFaxNo").val();

    var daPostalAddress = typeof $("#daPostalAddress").val() === 'undefined' ? '' : $("#daPostalAddress").val();
    var daResAddress = typeof $("#daResAddress").val() === 'undefined' ? '' : $("#daResAddress").val();

    var daRelType = $("#daRelType").val() ? $("#daRelType").val() : '';
    var daRelCause = $("#daRelCause").val() ? $("#daRelCause").val() : '';
    var daRelDetails = typeof $("#daRelDetails").val() === 'undefined' ? '' : $("#daRelDetails").val();
    var daRelStartDate = typeof $("#daRelStartDate").val() === 'undefined' ? '' : $("#daRelStartDate").val();
    var daRelEndDate = typeof $("#daRelEndDate").val() === 'undefined' ? '' : $("#daRelEndDate").val();
    var errMsg = "";
    if (daPrsnLocalID.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">ID No. cannot be empty!</span></p>';
    }
    if (daTitle.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Title cannot be empty!</span></p>';
    }
    if (daFirstName.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">First Name cannot be empty!</span></p>';
    }
    if (daSurName.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Surname cannot be empty!</span></p>';
    }
    if (daGender.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Gender cannot be empty!</span></p>';
    }
    if (daMaritalStatus.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Marital Status cannot be empty!</span></p>';
    }

    if (daDOB.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Date of Birth cannot be empty!</span></p>';
    }

    if (daNationality.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Nationality cannot be empty!</span></p>';
    }
    if (daMobileNos.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Mobile No. cannot be empty!</span></p>';
    }
    if (daEmail.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Mobile No. cannot be empty!</span></p>';
    }
    if (actTyp === 2)
    {
        if (daRelType.trim() === '')
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Relation type cannot be empty!</span></p>';
        }

        if (daRelCause.trim() === '')
        {
            errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;color:red;">Relation cause cannot be empty!</span></p>';
        }
    }
    if (rhotrim(errMsg, '; ') !== '')
    {
        bootbox.alert({
            title: 'System Alert!',
            /*size: 'small',*/
            message: errMsg});
        return false;
    }

    var addtnlPrsnDataCol1 = typeof $("#addtnlPrsnDataCol1").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol1").val();
    var addtnlPrsnDataCol2 = typeof $("#addtnlPrsnDataCol2").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol2").val();
    var addtnlPrsnDataCol3 = typeof $("#addtnlPrsnDataCol3").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol3").val();
    var addtnlPrsnDataCol4 = typeof $("#addtnlPrsnDataCol4").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol4").val();
    var addtnlPrsnDataCol5 = typeof $("#addtnlPrsnDataCol5").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol5").val();
    var addtnlPrsnDataCol6 = typeof $("#addtnlPrsnDataCol6").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol6").val();
    var addtnlPrsnDataCol7 = typeof $("#addtnlPrsnDataCol7").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol7").val();
    var addtnlPrsnDataCol8 = typeof $("#addtnlPrsnDataCol8").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol8").val();
    var addtnlPrsnDataCol9 = typeof $("#addtnlPrsnDataCol9").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol9").val();
    var addtnlPrsnDataCol10 = typeof $("#addtnlPrsnDataCol10").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol10").val();
    var addtnlPrsnDataCol11 = typeof $("#addtnlPrsnDataCol11").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol11").val();
    var addtnlPrsnDataCol12 = typeof $("#addtnlPrsnDataCol12").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol12").val();
    var addtnlPrsnDataCol13 = typeof $("#addtnlPrsnDataCol13").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol13").val();
    var addtnlPrsnDataCol14 = typeof $("#addtnlPrsnDataCol14").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol14").val();
    var addtnlPrsnDataCol15 = typeof $("#addtnlPrsnDataCol15").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol15").val();
    var addtnlPrsnDataCol16 = typeof $("#addtnlPrsnDataCol16").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol16").val();
    var addtnlPrsnDataCol17 = typeof $("#addtnlPrsnDataCol17").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol17").val();
    var addtnlPrsnDataCol18 = typeof $("#addtnlPrsnDataCol18").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol18").val();
    var addtnlPrsnDataCol19 = typeof $("#addtnlPrsnDataCol19").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol19").val();
    var addtnlPrsnDataCol20 = typeof $("#addtnlPrsnDataCol20").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol20").val();
    var addtnlPrsnDataCol21 = typeof $("#addtnlPrsnDataCol21").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol21").val();
    var addtnlPrsnDataCol22 = typeof $("#addtnlPrsnDataCol22").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol22").val();
    var addtnlPrsnDataCol23 = typeof $("#addtnlPrsnDataCol23").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol23").val();
    var addtnlPrsnDataCol24 = typeof $("#addtnlPrsnDataCol24").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol24").val();
    var addtnlPrsnDataCol25 = typeof $("#addtnlPrsnDataCol25").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol25").val();
    var addtnlPrsnDataCol26 = typeof $("#addtnlPrsnDataCol26").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol26").val();
    var addtnlPrsnDataCol27 = typeof $("#addtnlPrsnDataCol27").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol27").val();
    var addtnlPrsnDataCol28 = typeof $("#addtnlPrsnDataCol28").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol28").val();
    var addtnlPrsnDataCol29 = typeof $("#addtnlPrsnDataCol29").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol29").val();
    var addtnlPrsnDataCol30 = typeof $("#addtnlPrsnDataCol30").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol30").val();
    var addtnlPrsnDataCol31 = typeof $("#addtnlPrsnDataCol31").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol31").val();
    var addtnlPrsnDataCol32 = typeof $("#addtnlPrsnDataCol32").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol32").val();
    var addtnlPrsnDataCol33 = typeof $("#addtnlPrsnDataCol33").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol33").val();
    var addtnlPrsnDataCol34 = typeof $("#addtnlPrsnDataCol34").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol34").val();
    var addtnlPrsnDataCol35 = typeof $("#addtnlPrsnDataCol35").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol35").val();
    var addtnlPrsnDataCol36 = typeof $("#addtnlPrsnDataCol36").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol36").val();
    var addtnlPrsnDataCol37 = typeof $("#addtnlPrsnDataCol37").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol37").val();
    var addtnlPrsnDataCol38 = typeof $("#addtnlPrsnDataCol38").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol38").val();
    var addtnlPrsnDataCol39 = typeof $("#addtnlPrsnDataCol39").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol39").val();
    var addtnlPrsnDataCol40 = typeof $("#addtnlPrsnDataCol40").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol40").val();
    var addtnlPrsnDataCol41 = typeof $("#addtnlPrsnDataCol41").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol41").val();
    var addtnlPrsnDataCol42 = typeof $("#addtnlPrsnDataCol42").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol42").val();
    var addtnlPrsnDataCol43 = typeof $("#addtnlPrsnDataCol43").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol43").val();
    var addtnlPrsnDataCol44 = typeof $("#addtnlPrsnDataCol44").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol44").val();
    var addtnlPrsnDataCol45 = typeof $("#addtnlPrsnDataCol45").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol45").val();
    var addtnlPrsnDataCol46 = typeof $("#addtnlPrsnDataCol46").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol46").val();
    var addtnlPrsnDataCol47 = typeof $("#addtnlPrsnDataCol47").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol47").val();
    var addtnlPrsnDataCol48 = typeof $("#addtnlPrsnDataCol48").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol48").val();
    var addtnlPrsnDataCol49 = typeof $("#addtnlPrsnDataCol49").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol49").val();
    var addtnlPrsnDataCol50 = typeof $("#addtnlPrsnDataCol50").val() === 'undefined' ? '' : $("#addtnlPrsnDataCol50").val();
    var dialog = bootbox.alert({
        title: 'Save Person',
        size: 'small',
        message: '<div id="myInformation"><i class="fa fa-spin fa-spinner"></i> Saving Person...Please Wait...</div>',
        callback: function () {
        }
    });
    dialog.init(function () {
        getMsgAsyncSilent('grp=1&typ=11&q=Check Session', function () {
            $body = $("body");
            $body.removeClass("mdlloadingDiag");
            $body.removeClass("mdlloading");
            var obj;
            var formData = new FormData();
            formData.append('daPrsnPicture', $('#daPrsnPicture')[0].files[0]);
            formData.append('grp', 8);
            formData.append('typ', 1);
            formData.append('pg', 2);
            formData.append('q', 'UPDATE');
            formData.append('shdSbmt', shdSbmt);
            formData.append('actyp', actTyp);
            formData.append('daPersonID', daPersonID);
            formData.append('daPrsnLocalID', daPrsnLocalID);
            formData.append('daTitle', daTitle);

            formData.append('daFirstName', daFirstName);
            formData.append('daSurName', daSurName);
            formData.append('daOtherNames', daOtherNames);
            formData.append('daGender', daGender);

            formData.append('daMaritalStatus', daMaritalStatus);
            formData.append('daDOB', daDOB);
            formData.append('daPOB', daPOB);
            formData.append('daNationality', daNationality);

            formData.append('daHomeTown', daHomeTown);
            formData.append('daReligion', daReligion);
            formData.append('daCompany', daCompany);
            formData.append('daCompanyLoc', daCompanyLoc);

            formData.append('daEmail', daEmail);
            formData.append('daTelNos', daTelNos);
            formData.append('daMobileNos', daMobileNos);
            formData.append('daFaxNo', daFaxNo);

            formData.append('daPostalAddress', daPostalAddress);
            formData.append('daResAddress', daResAddress);
            formData.append('daRelType', daRelType);
            formData.append('daRelCause', daRelCause);
            formData.append('daRelDetails', daRelDetails);
            formData.append('daRelStartDate', daRelStartDate);
            formData.append('daRelEndDate', daRelEndDate);


            formData.append('addtnlPrsnDataCol1', addtnlPrsnDataCol1);
            formData.append('addtnlPrsnDataCol2', addtnlPrsnDataCol2);
            formData.append('addtnlPrsnDataCol3', addtnlPrsnDataCol3);
            formData.append('addtnlPrsnDataCol4', addtnlPrsnDataCol4);
            formData.append('addtnlPrsnDataCol5', addtnlPrsnDataCol5);
            formData.append('addtnlPrsnDataCol6', addtnlPrsnDataCol6);
            formData.append('addtnlPrsnDataCol7', addtnlPrsnDataCol7);
            formData.append('addtnlPrsnDataCol8', addtnlPrsnDataCol8);
            formData.append('addtnlPrsnDataCol9', addtnlPrsnDataCol9);
            formData.append('addtnlPrsnDataCol10', addtnlPrsnDataCol10);
            formData.append('addtnlPrsnDataCol11', addtnlPrsnDataCol11);
            formData.append('addtnlPrsnDataCol12', addtnlPrsnDataCol12);
            formData.append('addtnlPrsnDataCol13', addtnlPrsnDataCol13);
            formData.append('addtnlPrsnDataCol14', addtnlPrsnDataCol14);
            formData.append('addtnlPrsnDataCol15', addtnlPrsnDataCol15);
            formData.append('addtnlPrsnDataCol16', addtnlPrsnDataCol16);
            formData.append('addtnlPrsnDataCol17', addtnlPrsnDataCol17);
            formData.append('addtnlPrsnDataCol18', addtnlPrsnDataCol18);
            formData.append('addtnlPrsnDataCol19', addtnlPrsnDataCol19);
            formData.append('addtnlPrsnDataCol20', addtnlPrsnDataCol20);
            formData.append('addtnlPrsnDataCol21', addtnlPrsnDataCol21);
            formData.append('addtnlPrsnDataCol22', addtnlPrsnDataCol22);
            formData.append('addtnlPrsnDataCol23', addtnlPrsnDataCol23);
            formData.append('addtnlPrsnDataCol24', addtnlPrsnDataCol24);
            formData.append('addtnlPrsnDataCol25', addtnlPrsnDataCol25);
            formData.append('addtnlPrsnDataCol26', addtnlPrsnDataCol26);
            formData.append('addtnlPrsnDataCol27', addtnlPrsnDataCol27);
            formData.append('addtnlPrsnDataCol28', addtnlPrsnDataCol28);
            formData.append('addtnlPrsnDataCol29', addtnlPrsnDataCol29);
            formData.append('addtnlPrsnDataCol30', addtnlPrsnDataCol30);
            formData.append('addtnlPrsnDataCol31', addtnlPrsnDataCol31);
            formData.append('addtnlPrsnDataCol32', addtnlPrsnDataCol32);
            formData.append('addtnlPrsnDataCol33', addtnlPrsnDataCol33);
            formData.append('addtnlPrsnDataCol34', addtnlPrsnDataCol34);
            formData.append('addtnlPrsnDataCol35', addtnlPrsnDataCol35);
            formData.append('addtnlPrsnDataCol36', addtnlPrsnDataCol36);
            formData.append('addtnlPrsnDataCol37', addtnlPrsnDataCol37);
            formData.append('addtnlPrsnDataCol38', addtnlPrsnDataCol38);
            formData.append('addtnlPrsnDataCol39', addtnlPrsnDataCol39);
            formData.append('addtnlPrsnDataCol40', addtnlPrsnDataCol40);
            formData.append('addtnlPrsnDataCol41', addtnlPrsnDataCol41);
            formData.append('addtnlPrsnDataCol42', addtnlPrsnDataCol42);
            formData.append('addtnlPrsnDataCol43', addtnlPrsnDataCol43);
            formData.append('addtnlPrsnDataCol44', addtnlPrsnDataCol44);
            formData.append('addtnlPrsnDataCol45', addtnlPrsnDataCol45);
            formData.append('addtnlPrsnDataCol46', addtnlPrsnDataCol46);
            formData.append('addtnlPrsnDataCol47', addtnlPrsnDataCol47);
            formData.append('addtnlPrsnDataCol48', addtnlPrsnDataCol48);
            formData.append('addtnlPrsnDataCol49', addtnlPrsnDataCol49);
            formData.append('addtnlPrsnDataCol50', addtnlPrsnDataCol50);
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#myInformation").html(data.message);
                    if (data.message.indexOf("Success") !== -1) {
                        var msg = '<span style="font-weight:bold;">Status: </span>' +
                                '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                        $("#mySelfStatusBtn").html(msg);
                    }
                    setTimeout(function () {
                        dialog.modal('hide');
                        var dialog2 = bootbox.alert({
                            title: 'Submit Records Change Request',
                            size: 'large',
                            message: data.sbmt_message,
                            callback: function () {
                                if (shdSbmt > 0)
                                {
                                    openATab('#allmodules', 'grp=8&typ=1&pg=2&vtyp=0');
                                }
                            }
                        });
                    }, 800);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + " " + errorThrown);
                    console.warn(jqXHR.responseText);
                }
            });

        });
    });
}

function wthdrwRqst()
{
    var pKeyID = typeof $("#daChngRqstID").val() === 'undefined' ? -1 : $("#daChngRqstID").val();
    var dialog = bootbox.confirm({
        title: 'Withdraw Request?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">WITHDRAW</span> this Request?<br/>Action cannot be Undone!</p>',
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
                    title: 'Withdraw Request?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Withdrawing Request...Please Wait...</p>',
                    callback: function () {
                        if (pKeyID > 0)
                        {
                            openATab('#allmodules', 'grp=8&typ=1&pg=2&vtyp=0');
                        }
                    }
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
                                    pg: 2,
                                    q: 'DELETE',
                                    actyp: 40,
                                    daChngRqstID: pKeyID
                                },
                                success: function (result1) {
                                    setTimeout(function () {
                                        dialog1.find('.bootbox-body').html(result1);
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
                            dialog1.find('.bootbox-body').html('<span style="color:red;">Nothing to Withdraw!</span>');
                        }, 500);
                    }
                });
            }
        }
    });
}

function uploadFileToPrsnDocs(inptElmntID, attchIDElmntID, docNmElmntID, sbmtdPrsID, rowIDAttrb)
{
    var docCtrgrName = $('#' + docNmElmntID).val();
    var errMsg = "";
    if (docCtrgrName.trim() === '')
    {
        errMsg += '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                'font-weight:bold;color:red;">Doc. Name/Description cannot be empty!</span></p>';
    }
    if (rhotrim(errMsg, '; ') !== '')
    {
        bootbox.alert({
            title: 'System Alert!',
            size: 'small',
            message: errMsg});
        return false;
    }
    $("#" + inptElmntID).val('');
    $("#" + inptElmntID).off('change');
    $("#" + inptElmntID).change(function () {
        var fileName = $(this).val();
        var input = document.getElementById(inptElmntID);
        sendFileToPrsnDocs(input.files[0], docNmElmntID, attchIDElmntID, sbmtdPrsID, function (data) {
            $("#" + attchIDElmntID).val(data.attchID);
            var dialog = bootbox.alert({
                title: 'Server Response!',
                size: 'small',
                message: '<div id="myInformation">' + data.message + '</div>',
                callback: function () {
                    if (data.message.indexOf("Success") !== -1) {
                        var $tds = $('#' + rowIDAttrb).find('td');
                        $tds.eq(1).html(docCtrgrName);
                        var dwvldBtn = '<button type="button" class="btn btn-default" style="margin: 0px !important;padding:0px 3px 2px 4px !important;" ' +
                                'onclick="doAjax(\'grp=1&amp;typ=11&amp;q=Download&amp;fnm=' + data.crptpath + '\', \'\', \'Redirect\', \'\', \'\', \'\');" ' +
                                'data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Download Document">' +
                                '<img src="cmn_images/dwldicon.png" style="height:15px; width:auto; position: relative; vertical-align: middle;"> Download ' +
                                '</button>';
                        $tds.eq(2).html(dwvldBtn);
                        var msg = '<span style="font-weight:bold;">Status: </span>' +
                                '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                        $("#mySelfStatusBtn").html(msg);
                    }
                }
            });
        });
    });
    performFileClick(inptElmntID);
}

function sendFileToPrsnDocs(file, docNmElmntID, attchIDElmntID, sbmtdPrsID, callBackFunc) {
    var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
    var data1 = new FormData();
    data1.append('daPrsnAttchmnt', file);
    data1.append('grp', 8);
    data1.append('typ', 1);
    data1.append('pg', 2);
    data1.append('q', 'UPDATE');
    data1.append('actyp', 15);
    data1.append('docCtrgrName', $('#' + docNmElmntID).val());
    data1.append('attchmentID', $('#' + attchIDElmntID).val());
    data1.append('sbmtdPersonID', sbmtdPrsID);
    data1.append('srcForm', srcForm);
    $.ajax({
        url: "index.php",
        type: 'POST',
        data: data1,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            callBackFunc(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + " " + errorThrown);
            console.warn(jqXHR.responseText);
        }
    });
}

function getAttchdDocs(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#attchdDocsSrchFor").val() === 'undefined' ? '%' : $("#attchdDocsSrchFor").val();
    var srchIn = typeof $("#attchdDocsSrchIn").val() === 'undefined' ? 'Both' : $("#attchdDocsSrchIn").val();
    var pageNo = typeof $("#attchdDocsPageNo").val() === 'undefined' ? 1 : $("#attchdDocsPageNo").val();
    var limitSze = typeof $("#attchdDocsDsplySze").val() === 'undefined' ? 10 : $("#attchdDocsDsplySze").val();
    var sortBy = typeof $("#attchdDocsSortBy").val() === 'undefined' ? '' : $("#attchdDocsSortBy").val();
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
    linkArgs = linkArgs + "&searchfor=" + srchFor + "&searchin=" + srchIn + "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&sortBy=" + sortBy;
    doAjaxWthCallBck(linkArgs, 'attchdDocsList', 'PasteDirect', '', '', '', function () {
        var table1 = $('#attchdDocsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#attchdDocsTable').wrap('<div class="dataTables_scroll"/>');
        $('#attchdDocsTblForm').submit(function (e) {
            e.preventDefault();
            return false;
        });
    });
}

function enterKeyFuncAttchdDocs(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAttchdDocs(actionText, slctr, linkArgs);
    }
}

function delAttchdDoc(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var srcForm = $("#allAdminsSrcForm").val() ? $("#allAdminsSrcForm").val() : '0';
    var pKeyID = -1;
    if (typeof $('#attchdDocsRow' + rndmNum + '_AttchdDocsID').val() === 'undefined')
    {
        /*Do Nothing allnoticesRow<?php echo $cntr; ?> */
    } else {
        pKeyID = $('#attchdDocsRow' + rndmNum + '_AttchdDocsID').val();
    }
    var dialog = bootbox.confirm({
        title: 'Delete Document?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">DELETE</span> this Document?<br/>Action cannot be Undone!</p>',
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
                    title: 'Delete Document?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Deleting Document...Please Wait...</p>'
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
                                    pg: 2,
                                    q: 'DELETE',
                                    actyp: 15,
                                    attchmentID: pKeyID,
                                    srcForm: srcForm
                                },
                                success: function (result1) {
                                    setTimeout(function () {
                                        dialog1.find('.bootbox-body').html(result1);
                                        if (result1.indexOf("Success") !== -1) {
                                            $("#" + rowIDAttrb).remove();
                                            var msg = '<span style="font-weight:bold;">Status: </span>' +
                                                    '<span style="color:red;font-weight: bold;">Requires Approval </span>';
                                            $("#mySelfStatusBtn").html(msg);
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
