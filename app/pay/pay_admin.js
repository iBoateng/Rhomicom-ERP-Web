function preparePrsSetPrsns()
{
    var table2 = $('#prsSetPrsnsTable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "bFilter": false,
        "scrollX": false
    });
    $('#prsSetPrsnsTable').wrap('<div class="dataTables_scroll"/>');
}

function preparePrsSets()
{
    var table1 = $('#allPrsSetsTable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "bFilter": false,
        "scrollX": false
    });
    $('#allPrsSetsTable').wrap('<div class="dataTables_scroll"/>');
    var table2 = $('#prsSetPrsnsTable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "bFilter": false,
        "scrollX": false
    });
    $('#prsSetPrsnsTable').wrap('<div class="dataTables_scroll"/>');

    $('#allPrsSetsTable tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');

        } else {
            table1.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');

        }
        var rndmNum = $(this).attr('id').split("_")[1];
        var pkeyID = typeof $('#allPrsSetsRow' + rndmNum + '_PrsSetID').val() === 'undefined' ? '%' : $('#allPrsSetsRow' + rndmNum + '_PrsSetID').val();
        getOnePrsnSetPrsns(pkeyID, 1);
    });
    $('#allPrsSetsTable tbody')
            .on('mouseenter', 'tr', function () {
                if ($(this).hasClass('highlight')) {
                    $(this).removeClass('highlight');
                } else {
                    table1.$('tr.highlight').removeClass('highlight');
                    $(this).addClass('highlight');
                }
            });
}

function preparePrsAcnts()
{
    if (!$.fn.DataTable.isDataTable('#prsnBanksTable')) {
        var table1 = $('#prsnBanksTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#prsnBanksTable').wrap('<div class="dataTables_scroll"/>');
    }
}
function preparePrsItmAsgn()
{
    if (!$.fn.DataTable.isDataTable('#prsnItmsTable')) {
        var table1 = $('#prsnItmsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#prsnItmsTable').wrap('<div class="dataTables_scroll"/>');
    }
    $('#prsnItmsForm').submit(function (e) {
        e.preventDefault();
        return false;
    });
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
}
function prepareQckPay()
{
    $(function () {
        /*var numelms=$('[data-toggle="tabajxgst"]').size();*/
        $('[data-toggle="tabajxqpay"]').click(function (e) {
            var $this = $(this);
            var targ = $this.attr('href');
            var dttrgt = $this.attr('data-rhodata');
            var linkArgs = 'grp=7&typ=1' + dttrgt;
            return openATab(targ, linkArgs);
        });
    });

    var table1 = $('#qckPayPrsnsTable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "bFilter": false,
        "scrollX": false
    });
    $('#qckPayPrsnsTable').wrap('<div class="dataTables_scroll"/>');
    $('#qckPayPrsnsForm').submit(function (e) {
        e.preventDefault();
        return false;
    });
    var table2 = $('#prsnPyHstrysTable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "bFilter": false,
        "scrollX": false
    });
    $('#prsnPyHstrysTable').wrap('<div class="dataTables_scroll"/>');
    $('#qckPayPrsnsTable tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');

        } else {
            table1.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');

        }
        var rndmNum = $(this).attr('id').split("_")[1];
        var pkeyID = typeof $('#qckPayPrsnsRow' + rndmNum + '_PrsnID').val() === 'undefined' ? '%' : $('#qckPayPrsnsRow' + rndmNum + '_PrsnID').val();
        getOneQckPayPrsnForm(pkeyID, 1);
    });
    $('#qckPayPrsnsTable tbody')
            .on('mouseenter', 'tr', function () {
                if ($(this).hasClass('highlight')) {
                    $(this).removeClass('highlight');
                } else {
                    table1.$('tr.highlight').removeClass('highlight');
                    $(this).addClass('highlight');
                }
            });
    $('#prsnPyHstrysTable tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');

        } else {
            table2.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');

        }
    });
    $('#prsnPyHstrysTable tbody')
            .on('mouseenter', 'tr', function () {
                if ($(this).hasClass('highlight')) {
                    $(this).removeClass('highlight');
                } else {
                    table2.$('tr.highlight').removeClass('highlight');
                    $(this).addClass('highlight');
                }
            });
}
function getQckPayPrsns(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#qckPayPrsnsSrchFor").val() === 'undefined' ? '%' : $("#qckPayPrsnsSrchFor").val();
    var srchIn = typeof $("#qckPayPrsnsSrchIn").val() === 'undefined' ? 'Both' : $("#qckPayPrsnsSrchIn").val();
    var pageNo = typeof $("#qckPayPrsnsPageNo").val() === 'undefined' ? 1 : $("#qckPayPrsnsPageNo").val();
    var limitSze = typeof $("#qckPayPrsnsDsplySze").val() === 'undefined' ? 10 : $("#qckPayPrsnsDsplySze").val();
    var sortBy = typeof $("#qckPayPrsnsSortBy").val() === 'undefined' ? '' : $("#qckPayPrsnsSortBy").val();
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
    openATab(slctr, linkArgs);
}

function enterKeyFuncQckPayPrsns(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getQckPayPrsns(actionText, slctr, linkArgs);
    }
}

function getOneQckPayPrsnForm(pKeyID, vwtype)
{
    var lnkArgs = 'grp=7&typ=1&pg=4&vtyp=' + vwtype + '&sbmtdPrsnSetMmbrID=' + pKeyID;
    doAjaxWthCallBck(lnkArgs, 'qckPayPrsnsDetailInfo', 'PasteDirect', '', '', '', function () {
        $(function () {
            /*var numelms=$('[data-toggle="tabajxgst"]').size();*/
            $('[data-toggle="tabajxqpay"]').click(function (e) {
                var $this = $(this);
                var targ = $this.attr('href');
                var dttrgt = $this.attr('data-rhodata');
                var linkArgs = 'grp=7&typ=1' + dttrgt;
                return openATab(targ, linkArgs);
            });
        });
        var table1 = $('#prsnPyHstrysTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#prsnPyHstrysTable').wrap('<div class="dataTables_scroll"/>');
        $('#prsnPyHstrysTable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');

            } else {
                table1.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

            }
        });
        $('#prsnPyHstrysTable tbody')
                .on('mouseenter', 'tr', function () {
                    if ($(this).hasClass('highlight')) {
                        $(this).removeClass('highlight');
                    } else {
                        table1.$('tr.highlight').removeClass('highlight');
                        $(this).addClass('highlight');
                    }
                });
    });
}


function getPrsnPyHstrys(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#prsnPyHstrysSrchFor").val() === 'undefined' ? '%' : $("#prsnPyHstrysSrchFor").val();
    var srchIn = typeof $("#prsnPyHstrysSrchIn").val() === 'undefined' ? 'Both' : $("#prsnPyHstrysSrchIn").val();
    var pageNo = typeof $("#prsnPyHstrysPageNo").val() === 'undefined' ? 1 : $("#prsnPyHstrysPageNo").val();
    var limitSze = typeof $("#prsnPyHstrysDsplySze").val() === 'undefined' ? 10 : $("#prsnPyHstrysDsplySze").val();
    var sortBy = typeof $("#prsnPyHstrysSortBy").val() === 'undefined' ? '' : $("#prsnPyHstrysSortBy").val();
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
    doAjaxWthCallBck(linkArgs, 'prsnPyHstrysList', 'PasteDirect', '', '', '', function () {
        var table1 = $('#prsnPyHstrysTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#prsnPyHstrysTable').wrap('<div class="dataTables_scroll"/>');
        $('#prsnPyHstrysTable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');

            } else {
                table1.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

            }
        });
        $('#prsnPyHstrysTable tbody')
                .on('mouseenter', 'tr', function () {
                    if ($(this).hasClass('highlight')) {
                        $(this).removeClass('highlight');
                    } else {
                        table1.$('tr.highlight').removeClass('highlight');
                        $(this).addClass('highlight');
                    }
                });
    });
}

function enterKeyFuncPrsnPyHstrys(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getPrsnPyHstrys(actionText, slctr, linkArgs);
    }
}

function getOnePrsnPyHstrysForm(pKeyID, pKeyID1, vwtype, sbmtdPrsnSetMmbrID, dialogTitle)
{
    var lnkArgs = 'grp=7&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdPyReqID=' + pKeyID1 + '&sbmtdMspyID=' + pKeyID + '&sbmtdPrsnSetMmbrID=' + sbmtdPrsnSetMmbrID;
    doAjaxWthCallBck(lnkArgs, 'myFormsModalLg', 'ShowDialog', dialogTitle, 'myFormsModalTitleLg', 'myFormsModalBodyLg', function () {
        var table1 = $('#myPayRnLinesTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#myPayRnLinesTable').wrap('<div class="dataTables_scroll"/>');
        $("#myPyRnTotal1").html(urldecode($("#myPyRnTotal2").val()));
    });

}

function getAllPrsnItms(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#prsnItmsSrchFor").val() === 'undefined' ? '%' : $("#prsnItmsSrchFor").val();
    var srchIn = typeof $("#prsnItmsSrchIn").val() === 'undefined' ? 'Both' : $("#prsnItmsSrchIn").val();
    var pageNo = typeof $("#prsnItmsPageNo").val() === 'undefined' ? 1 : $("#prsnItmsPageNo").val();
    var limitSze = typeof $("#prsnItmsDsplySze").val() === 'undefined' ? 10 : $("#prsnItmsDsplySze").val();
    var sortBy = typeof $("#prsnItmsSortBy").val() === 'undefined' ? '' : $("#prsnItmsSortBy").val();
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
    openATab(slctr, linkArgs);
}

function enterKeyFuncPrsnItms(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllPrsnItms(actionText, slctr, linkArgs);
    }
}

function getAllPrsSets(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allPrsSetsSrchFor").val() === 'undefined' ? '%' : $("#allPrsSetsSrchFor").val();
    var srchIn = typeof $("#allPrsSetsSrchIn").val() === 'undefined' ? 'Both' : $("#allPrsSetsSrchIn").val();
    var pageNo = typeof $("#allPrsSetsPageNo").val() === 'undefined' ? 1 : $("#allPrsSetsPageNo").val();
    var limitSze = typeof $("#allPrsSetsDsplySze").val() === 'undefined' ? 10 : $("#allPrsSetsDsplySze").val();
    var sortBy = typeof $("#allPrsSetsSortBy").val() === 'undefined' ? '' : $("#allPrsSetsSortBy").val();
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
    openATab(slctr, linkArgs);
}

function enterKeyFuncAllPrsSets(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllPrsSets(actionText, slctr, linkArgs);
    }
}

function getOnePrsnSetPrsns(pKeyID, vwtype)
{
    var lnkArgs = 'grp=7&typ=1&pg=6&vtyp=' + vwtype + '&sbmtdPrsnSetHdrID=' + pKeyID;
    doAjaxWthCallBck(lnkArgs, 'allPrsSetsDetailInfo', 'PasteDirect', '', '', '', function () {
        var table1 = $('#prsSetPrsnsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#prsSetPrsnsTable').wrap('<div class="dataTables_scroll"/>');

    });
}

function getAllPrsSetPrsns(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#prsSetPrsnsSrchFor").val() === 'undefined' ? '%' : $("#prsSetPrsnsSrchFor").val();
    var srchIn = typeof $("#prsSetPrsnsSrchIn").val() === 'undefined' ? 'Both' : $("#prsSetPrsnsSrchIn").val();
    var pageNo = typeof $("#prsSetPrsnsPageNo").val() === 'undefined' ? 1 : $("#prsSetPrsnsPageNo").val();
    var limitSze = typeof $("#prsSetPrsnsDsplySze").val() === 'undefined' ? 10 : $("#prsSetPrsnsDsplySze").val();
    var sortBy = typeof $("#prsSetPrsnsSortBy").val() === 'undefined' ? '' : $("#prsSetPrsnsSortBy").val();
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
    openATab(slctr, linkArgs);
}

function enterKeyFuncPrsSetPrsns(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllPrsSetPrsns(actionText, slctr, linkArgs);
    }
}
function getOnePrsSetForm(pKeyID, vwtype)
{
    var lnkArgs = 'grp=7&typ=1&pg=6&vtyp=' + vwtype + '&sbmtdPrsnSetHdrID=' + pKeyID;
    doAjaxWthCallBck(lnkArgs, 'myFormsModalNrml', 'ShowDialog', 'Person Set Details (ID:' + pKeyID + ')', 'myFormsModalNrmlTitle', 'myFormsModalNrmlBody', function () {
        var table1 = $('#prsSetAllwdRolesTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#prsSetAllwdRolesTable').wrap('<div class="dataTables_scroll"/>');
    });
    $('#prsSetDetailsForm').submit(function (e) {
        e.preventDefault();
        return false;
    });

}

function savePrsnSetForm(actionText, slctr, linkArgs)
{
    var prsnSetNm = typeof $("#prsnSetNm").val() === 'undefined' ? '' : $("#prsnSetNm").val();
    var prsnSetID = typeof $("#prsnSetID").val() === 'undefined' ? '-1' : $("#prsnSetID").val();
    var prsnSetDesc = typeof $("#prsnSetDesc").val() === 'undefined' ? '' : $("#prsnSetDesc").val();
    var prsnSetUsesSQL = typeof $("input[name='prsnSetUsesSQL']:checked").val() === 'undefined' ? 'NO' : 'YES';
    var prsnSetEnbld = typeof $("input[name='prsnSetEnbld']:checked").val() === 'undefined' ? 'NO' : 'YES';
    var prsnSetIsDflt = typeof $("input[name='prsnSetIsDflt']:checked").val() === 'undefined' ? 'NO' : 'YES';
    var prsnSetSQL = typeof $("#prsnSetSQL").val() === 'undefined' ? '' : $("#prsnSetSQL").val();

    if (prsnSetNm === "" || prsnSetNm === null)
    {
        bootbox.alert({
            title: 'System Alert!',
            size: 'small',
            message: '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;">Person Set Name cannot be empty!</span></p>'});
        return false;
    }
    if (prsnSetUsesSQL !== 'NO' && prsnSetSQL === "")
    {
        bootbox.alert({
            title: 'System Alert!',
            size: 'small',
            message: '<p><span style="font-family: georgia, times;font-size: 12px;font-style:italic;' +
                    'font-weight:bold;">Person Set Query cannot be empty if this Set Uses SQL!</span></p>'});
        return false;
    }
    var slctdPrsnSetRoles = "";
    $('#prsSetAllwdRolesTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            if (typeof $(el).attr('id') === 'undefined')
            {
                /*Do Nothing*/
            } else {
                var rndmNum = $(el).attr('id').split("_")[1];
                if (typeof $('#prsSetAlwdRlsRow' + rndmNum + '_RoleID').val() === 'undefined')
                {
                    /*Do Nothing*/
                } else {
                    slctdPrsnSetRoles = slctdPrsnSetRoles + $('#prsSetAlwdRlsRow' + rndmNum + '_PayRoleID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#prsSetAlwdRlsRow' + rndmNum + '_RoleNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#prsSetAlwdRlsRow' + rndmNum + '_RoleID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
                }
            }
        }
    });
    var dialog = bootbox.alert({
        title: 'Save Person Set',
        size: 'small',
        message: '<p><i class="fa fa-spin fa-spinner"></i> Saving Person Set...Please Wait...</p>',
        callback: function () {
            $('#myFormsModalNrml').modal('hide');
            getAllPrsSets(actionText, slctr, linkArgs);
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
                    grp: 7,
                    typ: 1,
                    pg: 6,
                    q: 'UPDATE',
                    actyp: 1,
                    prsnSetNm: prsnSetNm,
                    prsnSetID: prsnSetID,
                    prsnSetDesc: prsnSetDesc,
                    prsnSetUsesSQL: prsnSetUsesSQL,
                    prsnSetEnbld: prsnSetEnbld,
                    prsnSetIsDflt: prsnSetIsDflt,
                    prsnSetSQL: prsnSetSQL,
                    slctdPrsnSetRoles: slctdPrsnSetRoles
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
                }});
        });
    });
}

function delRoleSet(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var pKeyID = -1;
    if (typeof $('#prsSetAlwdRlsRow' + rndmNum + '_PayRoleID').val() === 'undefined')
    {
        /*Do Nothing*/
    } else {
        pKeyID = $('#prsSetAlwdRlsRow' + rndmNum + '_PayRoleID').val();
    }
    var dialog = bootbox.confirm({
        title: 'Delete Role Set?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">DELETE</span> this linked role set?<br/>Action cannot be Undone!</p>',
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
                    title: 'Delete Role Set?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Deleting Role Set...Please Wait...</p>'
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
                                    grp: 7,
                                    typ: 1,
                                    pg: 6,
                                    q: 'DELETE',
                                    actyp: 3,
                                    payRoleID: pKeyID
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

function savePrsnSetPrsns(actionText, slctr, linkArgs)
{
    var sbmtdPrsnSetHdrID = typeof $("#sbmtdPrsnSetHdrID").val() === 'undefined' ? '-1' : $("#sbmtdPrsnSetHdrID").val();
    var slctdPrsnSetPrsns = "";
    $('#prsSetPrsnsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            if (typeof $(el).attr('id') === 'undefined')
            {
                /*Do Nothing*/
            } else {
                var rndmNum = $(el).attr('id').split("_")[1];
                if (typeof $('#prsSetPrsnsRow' + rndmNum + '_PrsnLocID').val() === 'undefined')
                {
                    /*Do Nothing*/
                } else {
                    slctdPrsnSetPrsns = slctdPrsnSetPrsns + $('#prsSetPrsnsRow' + rndmNum + '_PrsnLocID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                            + $('#prsSetPrsnsRow' + rndmNum + '_PrsnNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
                }
            }
        }
    });
    var dialog = bootbox.alert({
        title: 'Save Persons',
        size: 'small',
        message: '<p><i class="fa fa-spin fa-spinner"></i> Saving Persons...Please Wait...</p>',
        callback: function () {
            getAllPrsSetPrsns(actionText, slctr, linkArgs);
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
                    grp: 7,
                    typ: 1,
                    pg: 6,
                    q: 'UPDATE',
                    actyp: 2,
                    sbmtdPrsnSetHdrID: sbmtdPrsnSetHdrID,
                    slctdPrsnSetPrsns: slctdPrsnSetPrsns
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

function delPrsnSetPrsn(rowIDAttrb)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var pKeyID = -1;
    var prsnLocID = '';
    if (typeof $('#prsSetPrsnsRow' + rndmNum + '_PrsnLocID').val() === 'undefined')
    {
        /*Do Nothing*/
    } else {
        pKeyID = $('#prsSetPrsnsRow' + rndmNum + '_PrsnSetDetID').val();
        prsnLocID = $('#prsSetPrsnsRow' + rndmNum + '_PrsnLocID').val();
    }
    var dialog = bootbox.confirm({
        title: 'Remove Person?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">REMOVE</span> this Person from the Set?<br/>Action cannot be Undone!</p>',
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
                    title: 'Remove Person?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Removing Person...Please Wait...</p>'
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
                                    grp: 7,
                                    typ: 1,
                                    pg: 6,
                                    q: 'DELETE',
                                    actyp: 2,
                                    prsnLocID: prsnLocID,
                                    prsnSetDetID: pKeyID
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

function delPersonSet(rowIDAttrb, actionText, slctr, linkArgs)
{
    var rndmNum = rowIDAttrb.split("_")[1];
    var pKeyID = -1;
    if (typeof $('#allPrsSetsRow' + rndmNum + '_PrsSetID').val() === 'undefined')
    {
        /*Do Nothing*/
    } else {
        pKeyID = $('#allPrsSetsRow' + rndmNum + '_PrsSetID').val();
    }
    var dialog = bootbox.confirm({
        title: 'Delete Person Set?',
        size: 'small',
        message: '<p style="text-align:center;">Are you sure you want to <span style="color:red;font-weight:bold;font-style:italic;">DELETE</span> this Person Set?<br/>Action cannot be Undone!</p>',
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
                    title: 'Delete Person Set?',
                    size: 'small',
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Deleting Person Set...Please Wait...</p>',
                    callback: function (result) {
                        getAllPrsSets(actionText, slctr, linkArgs);
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
                                    grp: 7,
                                    typ: 1,
                                    pg: 6,
                                    q: 'DELETE',
                                    actyp: 1,
                                    prsSetID: pKeyID
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
                            dialog1.find('.bootbox-body').html('Person Set Removed Successfully!');
                        }, 500);
                    }
                });
            }
        }
    });
}