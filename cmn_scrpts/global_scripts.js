function isMyScriptLoaded(url) {
    var scripts = document.getElementsByTagName('script');
    for (var i = scripts.length; i--; ) {
        var cururl = scripts[i].src;
        if (cururl.indexOf(url) >= 0)
        {
            return true;
        }
    }
    return false;
}

function isMyCssLoaded(url) {
    var scripts = document.getElementsByTagName('link');
    for (var i = scripts.length; i--; ) {
        var cururl = scripts[i].href;
        if (cururl.indexOf(url) >= 0)
        {
            return true;
        }
    }
    return false;
}

function loadScript(url, callback) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    if (script.readyState) {
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {
        script.onload = function () {
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

function loadCss(url, callback) {
    var script = document.createElement("link");
    script.type = "text/css";
    script.rel = "stylesheet";
    if (script.readyState) {
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {
        script.onload = function () {
            callback();
        };
    }
    script.href = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

function showRoles()
{
    openATab('#profile', 'grp=3&typ=1&pg=1&vtyp=4');
}

function getLovsPage(elementID, titleElementID, modalBodyID, lovNm, criteriaID,
        criteriaID2, criteriaID3, chkOrRadio, mustSelSth,
        selVals, valueElmntID, descElemntID, actionText, colNoForChkBxCmprsn, addtnlWhere)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");
        if (criteriaID == '')
        {
            criteriaID = "RhoUndefined";
        }
        if (criteriaID2 == '')
        {
            criteriaID2 = "RhoUndefined";
        }
        if (criteriaID3 == '')
        {
            criteriaID3 = "RhoUndefined";
        }
        var srchFor = typeof $("#lovSrchFor").val() === 'undefined' ? '%' : $("#lovSrchFor").val();
        var srchIn = typeof $("#lovSrchIn").val() === 'undefined' ? 'Both' : $("#lovSrchIn").val();
        var pageNo = typeof $("#lovPageNo").val() === 'undefined' ? 1 : $("#lovPageNo").val();
        var limitSze = typeof $("#lovDsplySze").val() === 'undefined' ? 10 : $("#lovDsplySze").val();

        var criteriaIDVal = typeof $("#" + criteriaID).val() === 'undefined' ? -1 : $("#" + criteriaID).val();
        var criteriaID2Val = typeof $("#" + criteriaID2).val() === 'undefined' ? '' : $("#" + criteriaID2).val();
        var criteriaID3Val = typeof $("#" + criteriaID3).val() === 'undefined' ? '' : $("#" + criteriaID3).val();
        if (colNoForChkBxCmprsn == 1)
        {
            selVals = typeof $("#" + descElemntID).val() === 'undefined' ? selVals : $("#" + descElemntID).val();
        } else if (colNoForChkBxCmprsn == 0)
        {
            selVals = typeof $("#" + valueElmntID).val() === 'undefined' ? selVals : $("#" + valueElmntID).val();
        }
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
                $('#' + titleElementID).html(lovNm);

                $('#' + modalBodyID).html(xmlhttp.responseText);
                $('#myLovModalDiag').draggable();

                $('#' + elementID).on('show.bs.modal', function (e) {
                    $(this).find('.modal-body').css({
                        'max-height': '100%'
                    });
                });
                $body.removeClass("mdlloadingDiag");
                $('#' + elementID).modal('show');
                $body.removeClass("mdlloading");
                $(document).ready(function () {
                    $("#lovForm").submit(function (e) {
                        e.preventDefault();
                        return false;
                    });
                    var cntr = 0;
                    var table = $('#lovTblRO').DataTable({
                        retrieve: true,
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#lovTblRO').wrap('<div class="dataTables_scroll"/>');
                    $('#lovTblRO tbody').on('dblclick', 'tr', function () {

                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');

                        $checkedBoxes = $(this).find('input[type=checkbox]');
                        $checkedBoxes.each(function (i, checkbox) {
                            checkbox.checked = true;
                        });
                        $radioBoxes = $(this).find('input[type=radio]');
                        $radioBoxes.each(function (i, radio) {
                            radio.checked = true;
                        });
                        applySlctdLov(elementID, 'lovForm', valueElmntID, descElemntID);
                    });

                    $('#lovTblRO tbody').on('click', 'tr', function () {
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                            $checkedBoxes = $(this).find('input[type=checkbox]');
                            $checkedBoxes.each(function (i, checkbox) {
                                checkbox.checked = false;
                            });
                            $radioBoxes = $(this).find('input[type=radio]');
                            $radioBoxes.each(function (i, radio) {
                                radio.checked = false;
                            });
                        } else {
                            table.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');

                            $checkedBoxes = $(this).find('input[type=checkbox]');
                            $checkedBoxes.each(function (i, checkbox) {
                                checkbox.checked = true;
                            });
                            $radioBoxes = $(this).find('input[type=radio]');
                            $radioBoxes.each(function (i, radio) {
                                radio.checked = true;
                            });
                        }
                    });
                    $('#lovTblRO tbody')
                            .on('mouseenter', 'tr', function () {
                                if ($(this).hasClass('highlight')) {
                                    $(this).removeClass('highlight');
                                } else {
                                    table.$('tr.highlight').removeClass('highlight');
                                    $(this).addClass('highlight');
                                }
                            });
                });
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //alert(criteriaIDVal);
        xmlhttp.send("grp=2&typ=1&lovNm=" + lovNm +
                "&criteriaID=" + criteriaID + "&criteriaID2=" + criteriaID2 +
                "&criteriaID3=" + criteriaID3 + "&criteriaIDVal=" + criteriaIDVal + "&criteriaID2Val=" + criteriaID2Val +
                "&criteriaID3Val=" + criteriaID3Val + "&chkOrRadio=" + chkOrRadio +
                "&mustSelSth=" + mustSelSth + "&selvals=" + selVals +
                "&valElmntID=" + valueElmntID + "&descElmntID=" + descElemntID +
                "&modalElementID=" + elementID + "&lovModalBody=" + modalBodyID +
                "&lovModalTitle=" + titleElementID + "&searchfor=" + srchFor + "&searchin=" + srchIn +
                "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&colNoForChkBxCmprsn=" + colNoForChkBxCmprsn + "&addtnlWhere=" + addtnlWhere + "");
    });

}

function enterKeyFuncLov(e, elementID, titleElementID, modalBodyID, lovNm, criteriaID,
        criteriaID2, criteriaID3, chkOrRadio, mustSelSth,
        selVals, valueElmntID, descElemntID, actionText, colNoForChkBxCmprsn, addtnlWhere)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getLovsPage(elementID, titleElementID, modalBodyID, lovNm, criteriaID,
                criteriaID2, criteriaID3, chkOrRadio, mustSelSth,
                selVals, valueElmntID, descElemntID, actionText, colNoForChkBxCmprsn, addtnlWhere);
    }
}

function applySlctdLov(modalElementID, formElmntID, valueElmntID, descElemntID) {
    var form = document.getElementById(formElmntID);
    var cbResults = '';
    var radioResults = '';
    var fnl_res = '';
    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].type === 'checkbox') {
            if (form.elements[i].checked === true) {
                cbResults += form.elements[i].value + '|';
            }
        }
        if (form.elements[i].type === 'radio') {
            if (form.elements[i].checked === true) {
                radioResults += form.elements[i].value + '|';
            }
        }
    }
    if (cbResults.length > 1)
    {
        fnl_res = cbResults.slice(0, -1);
    }
    if (radioResults.length > 1)
    {
        fnl_res = radioResults.slice(0, -1);
    }
    var bigArry = [];
    var tempArry = [];
    bigArry = fnl_res.split("|");
    var i = 0;
    var descValue = "";
    var valValue = "";

    for (i = 0; i < bigArry.length; i++) {
        tempArry = bigArry[i].split(";");
        if (tempArry.length > 1)
        {
            if (cbResults.length > 1)
            {
                descValue = descValue + tempArry[2] + ",";
                valValue = valValue + tempArry[1] + ",";
            } else
            {
                descValue = tempArry[2];
                valValue = tempArry[1];
            }
        }
    }
    if (cbResults.length > 1)
    {
        descValue = descValue.slice(0, -1);
        valValue = valValue.slice(0, -1);
    }
    if (typeof ($('#' + descElemntID).val()) !== 'undefined')
    {
        document.getElementById(descElemntID).value = descValue;
    }
    if (typeof ($('#' + valueElmntID).val()) !== 'undefined')
    {
        document.getElementById(valueElmntID).value = valValue;
    }
    $('#' + modalElementID).modal('hide');
}

function doAjax(linkArgs, elementID, actionAfter, titleMsg, titleElementID, modalBodyID)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");

        $body.addClass("mdlloading");
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        } else
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                if (actionAfter == 'Redirect')
                {
                    $body.removeClass("mdlloading");
                    window.open(xmlhttp.responseText, '_blank');
                } else if (actionAfter == 'ShowDialog')
                {
                    $body.removeClass("mdlloading");
                    $('#' + titleElementID).html(titleMsg);
                    $('#' + modalBodyID).html(xmlhttp.responseText);
                    $('#' + elementID).on('show.bs.modal', function (e) {
                        console.debug('modal shown!');
                    });
                    $('#' + elementID).modal('show');
                } else
                {
                    document.getElementById(elementID).innerHTML = xmlhttp.responseText;
                    $body.removeClass("mdlloading");
                }
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(linkArgs.trim());
    });
}

function openATab(slctr, linkArgs)
{
    $body = $("body");
    var $this = $(slctr + 'tab');
    var targ = slctr;

    if ($.trim($(targ).text()) !== ""
            && (slctr.match("^#prfl")
                    || slctr.match("^#profile")))
    {
        $this.tab('show');
        $body.removeClass("mdlloading");
    } else {
        getMsgAsync('grp=1&typ=11&q=Check Session', function () {
            $body = $("body");
            var $this = $(slctr + 'tab');
            var targ = slctr;
            var xmlhttp;
            if (window.XMLHttpRequest)
            {
                xmlhttp = new XMLHttpRequest();
            } else
            {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
                {
                    if (linkArgs.indexOf("grp=40&typ=2") !== -1)
                    {
                        loadScript("app/cmncde/myinbox.js", function () {
                            $this.tab('show');
                            prepareInbox(linkArgs, $body, targ, xmlhttp.responseText);
                        });
                    } else if (linkArgs.indexOf("grp=8&typ=1") !== -1)
                    {
                        loadScript("app/prs/prsn.js?v=110", function () {
                            $this.tab('show');
                            prepareProfile(linkArgs, $body, targ, xmlhttp.responseText);
                        });
                    } else if (linkArgs.indexOf("grp=40&typ=3") !== -1)
                    {
                        $this.tab('show');
                        prepareArticles(linkArgs, $body, targ, xmlhttp.responseText);
                    } else if (linkArgs.indexOf("grp=3&typ=1") !== -1)
                    {
                        if (linkArgs.indexOf("pg=1&vtyp=4") !== -1)
                        {
                            $this.tab('show');
                            prepareUsrPrfl(linkArgs, $body, targ, xmlhttp.responseText);
                        } else {
                            loadScript("app/sec/sys_admin.js?v=110", function () {
                                $this.tab('show');
                                prepareSysAdmin(linkArgs, $body, targ, xmlhttp.responseText);
                            });
                        }
                    } else
                    {
                        $(targ).html(xmlhttp.responseText);
                        $this.tab('show');
                        $body.removeClass("mdlloading");
                    }
                }
            };
            xmlhttp.open("POST", "index.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(linkArgs.trim());
        });
    }
}

function openATab1(slctr, linkArgs)
{
    $body = $("body");
    var $this = $(slctr + 'tab');
    var targ = slctr;
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        var $this = $(slctr + 'tab');
        var targ = slctr;
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        } else
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                if (linkArgs.indexOf("grp=40&typ=2") !== -1)
                {
                    loadScript("app/cmncde/myinbox.js", function () {
                        $this.tab('show');
                        prepareInbox(linkArgs, $body, targ, xmlhttp.responseText);
                    });
                } else if (linkArgs.indexOf("grp=8&typ=1") !== -1)
                {
                    loadScript("app/prs/prsn.js?v=110", function () {
                        $this.tab('show');
                        prepareProfile(linkArgs, $body, targ, xmlhttp.responseText);
                    });
                } else if (linkArgs.indexOf("grp=40&typ=3") !== -1)
                {
                    $this.tab('show');
                    prepareArticles(linkArgs, $body, targ, xmlhttp.responseText);
                } else if (linkArgs.indexOf("grp=3&typ=1") !== -1)
                {
                    if (linkArgs.indexOf("pg=1&vtyp=4") !== -1)
                    {
                        $this.tab('show');
                        prepareUsrPrfl(linkArgs, $body, targ, xmlhttp.responseText);
                    } else {
                        loadScript("app/sec/sys_admin.js?v=110", function () {
                            $this.tab('show');
                            prepareSysAdmin(linkArgs, $body, targ, xmlhttp.responseText);
                        });
                    }
                } else
                {
                    $(targ).html(xmlhttp.responseText);
                    $this.tab('show');
                    $body.removeClass("mdlloading");
                }
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(linkArgs.trim());
    });

}

function prepareUsrPrfl(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=4") !== -1)
        {
            var table1 = $('#usrPrflTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#usrPrflTable').wrap('<div class="dataTables_scroll" />');

            $('#usrPrflForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        }
        htBody.removeClass("mdlloading");
    });
}

function getUsrPrfl(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#usrPrflSrchFor").val() === 'undefined' ? '%' : $("#usrPrflSrchFor").val();
    var srchIn = 'Role Name';
    var pageNo = typeof $("#usrPrflPageNo").val() === 'undefined' ? 1 : $("#usrPrflPageNo").val();
    var limitSze = typeof $("#usrPrflDsplySze").val() === 'undefined' ? 10 : $("#usrPrflDsplySze").val();
    var sortBy = typeof $("#usrPrflSortBy").val() === 'undefined' ? '' : $("#usrPrflSortBy").val();
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
    openATab1(slctr, linkArgs);
}

function enterKeyFuncUsrPrfl(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getUsrPrfl(actionText, slctr, linkArgs);
    }
}

function prepareArticles(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=1") !== -1)
        {
            var table1 = $('#allArticlesTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allArticlesTable').wrap('<div class="dataTables_scroll"/>');
            $('#allArticlesForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        }else if (lnkArgs.indexOf("&vtyp=5") !== -1)
        {
            $('#fdbckMsgBody').summernote({
                minHeight: 375,
                focus: true
            });
            $('.note-editable').trigger('focus');
            $('#cmntsFdbckForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        }
        else if (lnkArgs.indexOf("&vtyp=6") !== -1)
        {
            var table1 = $('#allForumsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allForumsTable').wrap('<div class="dataTables_scroll"/>');
        }
        htBody.removeClass("mdlloading");
    });
}

function getAllArticles(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allArticlesSrchFor").val() === 'undefined' ? '%' : $("#allArticlesSrchFor").val();
    /*var srchIn = typeof $("#allArticlesSrchIn").val() === 'undefined' ? 'Both' : $("#allArticlesSrchIn").val();*/
    var pageNo = typeof $("#allArticlesPageNo").val() === 'undefined' ? 1 : $("#allArticlesPageNo").val();
    var limitSze = typeof $("#allArticlesDsplySze").val() === 'undefined' ? 10 : $("#allArticlesDsplySze").val();
    var sortBy = typeof $("#allArticlesSortBy").val() === 'undefined' ? '' : $("#allArticlesSortBy").val();
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
    linkArgs = linkArgs + "&searchfor=" + srchFor + "&searchin=All&pageNo=" + pageNo + "&limitSze=" + limitSze + "&sortBy=" + sortBy;
    openATab(slctr, linkArgs);
}

function enterKeyFuncArticles(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllArticles(actionText, slctr, linkArgs);
    }
}

function getOneArticleForm(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, articleID, vtyp, pgNo)
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

                $(function () {
                    $('.form_date').datetimepicker({
                        format: "dd-M-yyyy hh:ii:ss",
                        language: 'en',
                        weekStart: 0,
                        todayBtn: true,
                        autoclose: true,
                        todayHighlight: true,
                        keyboardNavigation: true,
                        startView: 2,
                        minView: 0,
                        maxView: 4,
                        forceParse: true
                    });
                });
                if (vtyp != 3)
                {
                    $('#articleIntroMsg').summernote({
                        minHeight: 145,
                        focus: true
                    });
                    $('#articleBodyText').summernote({
                        minHeight: 270,
                        focus: true
                    });
                }
                $('.note-editable').trigger('focus');

                $('#' + elementID).on('show.bs.modal', function (e) {
                    $(this).find('.modal-body').css({
                        'max-height': '100%'
                    });
                });
                $body.removeClass("mdlloadingDiag");
                $('#' + elementID).modal('show');
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
        xmlhttp.send("grp=40&typ=3&pg=" + pgNo + "&vtyp=" + vtyp + "&sbmtdArticleID=" + articleID);
    });
}

function saveOneArticleForm(elementID, pKeyID, personID, tableElementID)
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

function insertNewRowBe4(tableElmntID, position, inptHtml)
{
    var nwRndm = Math.floor((Math.random() * 9999999) + 1000000);
    var nwInptHtml = urldecode(inptHtml.replace(/(_WWW123WWW_)+/g, nwRndm + "_").replace(/(_WWW123WWW)+/g, nwRndm));
    $('#' + tableElmntID + ' > tbody > tr').eq(position).before(nwInptHtml);

    $(function () {
        $('.form_date_tme').datetimepicker({
            format: "dd-M-yyyy hh:ii:ss",
            language: 'en',
            weekStart: 0,
            todayBtn: true,
            autoclose: true,
            todayHighlight: true,
            keyboardNavigation: true,
            startView: 2,
            minView: 0,
            maxView: 4,
            forceParse: true
        });
    });
}

function urldecode(str) {
    return unescape(decodeURIComponent(str.replace(/\+/g, ' ')));
}

function logOutFunc()
{
    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        type: BootstrapDialog.TYPE_DEFAULT,
        title: 'System Alert!',
        message: 'Are you sure you want to Logout?',
        animate: true,
        onshow: function (dialog) {
        },
        buttons: [{
                label: 'Cancel',
                icon: 'glyphicon glyphicon-ban-circle',
                action: function (dialogItself) {
                    dialogItself.close();
                }
            }, {
                label: 'Logout',
                icon: 'glyphicon glyphicon-menu-left',
                cssClass: 'btn-primary',
                action: function (dialogItself) {
                    $.ajax({
                        method: "POST",
                        url: "index.php",
                        data: {q: 'logout'},
                        success: function (result) {
                            window.location = "index.php";
                        }});
                }
            }]
    });
}
var isLgnSccfl = 0;
var curDialogItself = null;
var curCallBack = null;
function getMsgAsync(linkArgs, callback) {
    $body = $("body");
    $body.addClass("mdlloading");
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            var sessionvld = xmlhttp.responseText;
            //alert(sessionvld);
            if (sessionvld != 1
                    || sessionvld == ''
                    || (typeof sessionvld === 'undefined'))
            {
                sessionvld = '<div class="login"><form role="form">' +
                        '<fieldset>' +
                        '<div class="form-group">' +
                        '<div class="input-group">' +
                        '<span class="input-group-addon" id="basic-addon1">' +
                        '<i class="fa fa-user fa-fw fa-border"></i></span>' +
                        '<input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" id="usrnm" name="usrnm"  onkeyup="enterKeyFuncLgn(event);" autofocus>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<div class="input-group">' +
                        '<span class="input-group-addon" id="basic-addon1"><i class="fa fa-key fa-fw fa-border"></i></span>' +
                        '<input class="form-control" placeholder="Password" id="pwd" name="pwd" type="password" value=""  onkeyup="enterKeyFuncLgn(event);">' +
                        '<input type="hidden" id="machdet" name="machdet" value="Unknown">' +
                        '</div>' +
                        '</div>' +
                        '<p class="label" id="msgArea">' +
                        '<label style="color:red;font-size:12px;text-align: center;">' +
                        '&nbsp;' +
                        '</label>' +
                        '</p>' +
                        '</fieldset>' +
                        '</form></div>';
            }

            if (sessionvld != 1)
            {
                $body.removeClass("mdlloading");
                BootstrapDialog.show({
                    size: BootstrapDialog.SIZE_SMALL,
                    type: BootstrapDialog.TYPE_DEFAULT,
                    title: 'Session Expired!',
                    message: sessionvld,
                    animate: true,
                    onshow: function (dialogItself) {
                        curDialogItself = dialogItself;
                        curCallBack = callback;
                    },
                    buttons: [{
                            label: 'Logout',
                            icon: 'glyphicon glyphicon-menu-left',
                            cssClass: 'btn-default',
                            action: function (dialogItself) {
                                $.ajax({
                                    method: "POST",
                                    url: "index.php",
                                    data: {q: 'logout'},
                                    success: function (result) {
                                        window.location = "index.php";
                                    }});
                            }
                        }, {
                            label: 'Login',
                            icon: 'glyphicon glyphicon-menu-right',
                            cssClass: 'btn-primary',
                            action: function (dialogItself) {
                                curDialogItself = dialogItself;
                                curCallBack = callback;
                                homePageLgn(dialogItself, callback);
                            }
                        }]
                });
            } else {
                callback();
            }
        } else
        {

        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(linkArgs.trim());
}

function enterKeyFuncLgn(e)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        homePageLgn(curDialogItself, curCallBack);
    }
    //return false;
}

function homePageLgn(dialogItself, callback)
{
    //alert("test" + myCountry() + myIP());
    var xmlhttp;
    var usrNm = "";
    var old_pswd = "";
    var lnkArgs = "";
    var machdet = "";
    usrNm = document.getElementById("usrnm").value;
    old_pswd = document.getElementById("pwd").value;
    machdet = document.getElementById("machdet").value;

    if (usrNm === "" || usrNm === null)
    {
        $('#modal-7 .modal-body').html('User Name cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        //alert('User Name cannot be empty!');
        return false;
    }
    if (old_pswd === "" || old_pswd === null)
    {
        $('#modal-7 .modal-body').html('Password cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        //alert('Password cannot be empty!');
        return false;
    }
    lnkArgs = "usrnm=" + usrNm + "&pwd=" + old_pswd + "&machdet=" + machdet + "&screenwdth=" + screen.width;

    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else
    {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        //var newDoc = document.open("text/html", "replace");
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            //newDoc.close();
            var rspns = xmlhttp.responseText;
            if (rspns.indexOf('change password') > -1
                    || rspns.indexOf('select role') > -1)
            {
                //window.location = 'index.php';
                isLgnSccfl = 1;
                dialogItself.close();
                $body = $("body");
                $body.addClass("mdlloading");
                callback();
            } else
            {
                isLgnSccfl = 0;
                document.getElementById("msgArea").innerHTML = "<span style=\"color:red;font-size:12px;text-align: center;margin-top:0px;\">&nbsp;" + rspns + "</span>";
            }
        } else
        {
            isLgnSccfl = 0;
            document.getElementById("msgArea").innerHTML = "<img style=\"width:105px;height:20px;display:inline;float:left;margin-left:3px;margin-right:3px;margin-top:-2px;clear: left;\" src='cmn_images/ajax-loader2.gif'/><span style=\"color:blue;font-size:11px;text-align: center;margin-top:0px;\">Loading...Please Wait...</span>";
        }
    };

    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(lnkArgs);//+ "&machdetls=" + machDet
}

function dwnldAjxCall(linkArgs, elemtnID) {
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        } else
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                document.getElementById(elemtnID).innerHTML = "&nbsp;";
                window.open(xmlhttp.responseText, '_blank');
            } else
            {
                document.getElementById(elemtnID).innerHTML = "<p><img style=\"width:80px;height:25px;display:inline;float:left;margin-right:5px;clear: left;\" src='cmn_images/animated_loading.gif'/>Loading...Please Wait...</p>";
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(linkArgs.trim());
    });
}

function myIP() {
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open("GET", "http://api.hostip.info/get_html.php", false);
    var res = "";
    var hostipInfo, ipAddress;
    var t = setTimeout(function () {
        xmlhttp.abort();
        xmlhttp = null;
        res = "Unknown";
    }, 3000);
    xmlhttp.send();
    if (res === "Unknown")
    {
        return res;
    } else if (xmlhttp.readyState === 4)
    {
        var i = 0;
        hostipInfo = xmlhttp.responseText.split("\n");
        for (i = 0; hostipInfo.length >= i; i++) {
            ipAddress = hostipInfo[i].split(":");
            if (ipAddress[0] === "IP")
            {
                return ipAddress[1];
            }
        }
    }
}

function myCountry() {
    var res = "";
    var xmlhttp;
    var hostipInfo, ipAddress;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open("GET", "http://api.hostip.info/get_html.php", false);
    var t = setTimeout(function () {
        xmlhttp.abort();
        xmlhttp = null;
        res = "Unknown";
    }, 3000);
    xmlhttp.send();
    if (res === "Unknown")
    {
        return res;
    } else if (xmlhttp.readyState === 4)
    {
        var i;
        hostipInfo = xmlhttp.responseText.split("\n");
        for (i = 0; hostipInfo.length >= i; i++) {
            ipAddress = hostipInfo[i].split(":");
            if (ipAddress[0] === "Country")
            {
                return ipAddress[1];
            }
        }
    }
}

function checkAllBtns(elmntID) {
    var form = document.getElementById(elmntID);

    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].type === 'checkbox') {
            form.elements[i].checked = true;
        }
    }
}

function unCheckAllBtns(elmntID) {
    var form = document.getElementById(elmntID);

    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].type === 'checkbox') {
            form.elements[i].checked = false;
        }
    }
}
