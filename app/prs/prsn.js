
function changeImgSrc(input, imgId, imgSrcLocID) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            //$('#img1Test')
            $(imgId).attr('src', e.target.result);
            $(imgSrcLocID).attr('value', $(input).val());
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function prepareProfile(lnkArgs, htBody, targ, rspns)
{
    if (lnkArgs.indexOf("&pg=1") !== -1)
    {
        prepareProfileRO(lnkArgs, htBody, targ, rspns);
    } else if (lnkArgs.indexOf("&pg=2") !== -1)
    {
        prepareProfileEDT(lnkArgs, htBody, targ, rspns);
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
                "scrollX": true
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="tabajxprflro"]').click(function (e) {
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
                "scrollX": true
            });
            /*$('#nationalIDTblEDT').wrap('<div class="dataTables_scroll" />');*/
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
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

function getNtnlIDForm(elementID, modalBodyID, titleElementID, formElementID, tRowElementID, formTitle, vtyp, addOrEdit, pKeyID)
{
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
            $('.modal-dialog').draggable();
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
            $('#' + elementID).modal('show');
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
    xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&ntnlIDpKey=" + pKeyID);
}

function saveNtnlIDForm(elementID, ntnlIDPersonID)
{
    $body = $("body");
    $body.addClass("mdlloadingDiag");
    var nicCountry = typeof $("#ntnlIDCardsCountry").val() === 'undefined' ? '%' : $("#ntnlIDCardsCountry").val();
    var nicIDType = typeof $("#ntnlIDCardsIDTyp").val() === 'undefined' ? 'Both' : $("#ntnlIDCardsIDTyp").val();
    var nicIDNo = typeof $("#ntnlIDCardsIDNo").val() === 'undefined' ? 1 : $("#ntnlIDCardsIDNo").val();
    var nicDateIssd = typeof $("#ntnlIDCardsDateIssd").val() === 'undefined' ? 10 : $("#ntnlIDCardsDateIssd").val();
    var nicExpDate = typeof $("#ntnlIDCardsExpDate").val() === 'undefined' ? 1 : $("#ntnlIDCardsExpDate").val();
    var nicOtherInfo = typeof $("#ntnlIDCardsOtherInfo").val() === 'undefined' ? 10 : $("#ntnlIDCardsOtherInfo").val();
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
            $('#nationalIDTblEDT').append('<tr><td></td><td colspan="6">' + xmlhttp.responseText + '</td></tr>');
            $body.removeClass("mdlloadingDiag");
            $('#' + elementID).modal('hide');
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=2" +
            "&ntnlIDCardsCountry=" + nicCountry +
            "&ntnlIDCardsIDTyp=" + nicIDType +
            "&ntnlIDCardsIDNo=" + nicIDNo +
            "&ntnlIDCardsDateIssd=" + nicDateIssd +
            "&ntnlIDCardsExpDate=" + nicExpDate +
            "&ntnlIDCardsOtherInfo=" + nicOtherInfo +
            "&ntnlIDPersonID=" + ntnlIDPersonID);
}


function getAddtnlDataForm(elementID, modalBodyID, titleElementID, formElementID,
        tRowElementID, formTitle, vtyp, addOrEdit, pKeyID, pipeSprtdFieldIDs, extDtColNum, tableElmntID)
{
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
            $('.modal-dialog').draggable();
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
            $('#' + elementID).modal('show');
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
}

function saveAddtnlDataForm(modalBodyID, addtnlPrsPkey, pipeSprtdFieldIDs, extDtColNum, tableElmntID, tRowElementID, addOrEdit)
{
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
            $('#' + modalBodyID).html(xmlhttp.responseText);
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=3&addtnlPrsPkey=" + addtnlPrsPkey
            + "&extDtColNum=" + extDtColNum + "&tableElmntID=" + tableElmntID + "&allTblValues=" + allTblValues);
}