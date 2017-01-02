
function prepareRpts(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=0") !== -1)
        {
            var table1 = $('#allRptsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allRptsTable').wrap('<div class="dataTables_scroll"/>');
            $('#allRptsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
            var table2 = $('#rptRunsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#rptRunsTable').wrap('<div class="dataTables_scroll"/>');
            $('#allRptsTable tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');

                } else {
                    table1.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
                var rndmNum = $(this).attr('id').split("_")[1];
                var pkeyID = typeof $('#allRptsRow' + rndmNum + '_RptID').val() === 'undefined' ? '%' : $('#allRptsRow' + rndmNum + '_RptID').val();
                //alert(curPlcyID);
                getOneRptsForm(pkeyID, 1);
            });
            $('#allRptsTable tbody')
                    .on('mouseenter', 'tr', function () {
                        if ($(this).hasClass('highlight')) {
                            $(this).removeClass('highlight');
                        } else {
                            table1.$('tr.highlight').removeClass('highlight');
                            $(this).addClass('highlight');
                        }
                    });
        }
        htBody.removeClass("mdlloading");
    });
}

function getAllRpts(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allRptsSrchFor").val() === 'undefined' ? '%' : $("#allRptsSrchFor").val();
    var srchIn = typeof $("#allRptsSrchIn").val() === 'undefined' ? 'Both' : $("#allRptsSrchIn").val();
    var pageNo = typeof $("#allRptsPageNo").val() === 'undefined' ? 1 : $("#allRptsPageNo").val();
    var limitSze = typeof $("#allRptsDsplySze").val() === 'undefined' ? 10 : $("#allRptsDsplySze").val();
    var sortBy = typeof $("#allRptsSortBy").val() === 'undefined' ? '' : $("#allRptsSortBy").val();
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

function enterKeyFuncAllRpts(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllRpts(actionText, slctr, linkArgs);
    }
}

function getOneRptsForm(pKeyID, vwtype)
{
    var lnkArgs = 'grp=9&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdRptID=' + pKeyID;
    var srchFor = typeof $("#rptRunsSrchFor").val() === 'undefined' ? '%' : $("#rptRunsSrchFor").val();
    var srchIn = typeof $("#rptRunsSrchIn").val() === 'undefined' ? 'Both' : $("#rptRunsSrchIn").val();
    var pageNo = typeof $("#rptRunsPageNo").val() === 'undefined' ? 1 : $("#rptRunsPageNo").val();
    var limitSze = typeof $("#rptRunsDsplySze").val() === 'undefined' ? 10 : $("#rptRunsDsplySze").val();
    var sortBy = typeof $("#rptRunsSortBy").val() === 'undefined' ? '' : $("#rptRunsSortBy").val();
    srchFor = "%";
    pageNo = 1;
    lnkArgs = lnkArgs + "&searchfor=" + srchFor + "&searchin=" + srchIn + "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&sortBy=" + sortBy;


    doAjaxWthCallBck(lnkArgs, 'rptsDetailInfo', 'PasteDirect', '', '', '', function () {
        var table1 = $('#rptRunsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#rptRunsTable').wrap('<div class="dataTables_scroll"/>');
        $('#allRptsForm').submit(function (e) {
            e.preventDefault();
            return false;
        });
    });

}

function getAllRptRuns(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#rptRunsSrchFor").val() === 'undefined' ? '%' : $("#rptRunsSrchFor").val();
    var srchIn = typeof $("#rptRunsSrchIn").val() === 'undefined' ? 'Both' : $("#rptRunsSrchIn").val();
    var pageNo = typeof $("#rptRunsPageNo").val() === 'undefined' ? 1 : $("#rptRunsPageNo").val();
    var limitSze = typeof $("#rptRunsDsplySze").val() === 'undefined' ? 10 : $("#rptRunsDsplySze").val();
    var sortBy = typeof $("#rptRunsSortBy").val() === 'undefined' ? '' : $("#rptRunsSortBy").val();
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

function enterKeyFuncRptRuns(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllRptRuns(actionText, slctr, linkArgs);
    }
}

function getOneRptsLogForm(pKeyID)
{
    var lnkArgs = 'grp=1&typ=11&q=Report Log Message&run_id=' + pKeyID;
    doAjaxWthCallBck(lnkArgs, 'myFormsModalLg', 'ShowDialog', 'REPORT/PROCESS RUN LOGS FOR (' + pKeyID + ')', 'myFormsModalTitleLg', 'myFormsModalBodyLg', function () {
        var table1 = $('#rptParamsLogTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#rptParamsLogTable').wrap('<div class="dataTables_scroll"/>');
    });
}

function getOneRptsParamsForm(pKeyID, prvRunID, rptName, vwtype)
{
    var lnkArgs = 'grp=9&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdRptID=' + pKeyID + "&sbmtdPrvRunID=" + prvRunID;
    doAjaxWthCallBck(lnkArgs, 'myFormsModalNrml', 'ShowDialog', 'PARAMETERS FOR (' + rptName + ')', 'myFormsModalNrmlTitle', 'myFormsModalNrmlBody', function () {
        var table1 = $('#rptParamsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#rptParamsTable').wrap('<div class="dataTables_scroll"/>');
        $('#rptParamsForm').submit(function (e) {
            e.preventDefault();
            return false;
        });

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
        $('.form_date_tme1').datetimepicker({
            format: "yyyy-mm-dd hh:ii:ss",
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

        $('.form_date1').datetimepicker({
            format: "yyyy-mm-dd",
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

}

function reloadParams()
{
    var pKeyID = typeof $("#rptParamRptID").val() === 'undefined' ? -1 : $("#rptParamRptID").val();
    var valValue = typeof $("#rptParamPrvRunID").val() === 'undefined' ? -1 : $("#rptParamPrvRunID").val();
    var rptName = typeof $("#rptParamRptName").val() === 'undefined' ? '' : $("#rptParamRptName").val();
    getOneRptsParamsForm(pKeyID, valValue, rptName, 2);
}

function getOneRptsRnStsForm(pKeyID, prvRunID, vwtype, mustReRun)
{
    var lnkArgs = 'grp=9&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdRptID=' + pKeyID + "&sbmtdRunID=" + prvRunID + "&mustReRun=" + mustReRun;

    var slctdParams = "";
    $('#rptParamsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            slctdParams = slctdParams + $('#rptParamsRow' + rndmNum + '_ParamID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#rptParamsRow' + rndmNum + '_ParamVal').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";

        }
    });
    lnkArgs = lnkArgs + "&slctdParams=" + slctdParams.slice(0, -1);
    doAjaxWthCallBck(lnkArgs, 'myFormsModalNrml', 'ShowDialog', 'Report Run Details FOR (' + prvRunID + ')', 'myFormsModalNrmlTitle', 'myFormsModalNrmlBody', function () {
        var table1 = $('#rptParamsStsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#rptParamsStsTable').wrap('<div class="dataTables_scroll"/>');
        $('#rptParamsStsForm').submit(function (e) {
            e.preventDefault();
            return false;
        });
        if (prvRunID <= 0)
        {
            getAllRptRuns('', '#rptsDetailInfo', 'grp=9&typ=1&pg=1&vtyp=1&sbmtdRptID=' + pKeyID);
            prvRunID = typeof $("#rptParamsStsRunID").val() === 'undefined' ? -1 : $("#rptParamsStsRunID").val();
            if (prvRunID > 0)
            {
                autoRfrshRptsRnSts(pKeyID, prvRunID, 0);
            }
        } else if (prvRunID > 0 && mustReRun == '1')
        {
            autoRfrshRptsRnSts(pKeyID, prvRunID, 0);
        }
    });
}

var globaltmer;
var globaltmerCntr = 0;

function autoRfrshRptsRnSts(pKeyID, prvRunID, mstStop)
{
    if (mstStop > 0)
    {
        globaltmer = window.clearInterval(globaltmer);
        globaltmerCntr = 0;
    }
    var runPrcnt = typeof $("#rptParamsStsPrgrs").val() === 'undefined' ? -1 : parseInt($("#rptParamsStsPrgrs").val());
    if (runPrcnt < 100 && mstStop <= 0)
    {
        var lnkArgs = 'grp=9&typ=1&pg=1&vtyp=3&sbmtdRptID=' + pKeyID + "&sbmtdRunID=" + prvRunID + "&autoRfrsh=1";
        doAjaxWthCallBck(lnkArgs, 'myFormsModalNrml', 'ShowDialog', 'Report Run Details FOR (' + prvRunID + ')', 'myFormsModalNrmlTitle', 'myFormsModalNrmlBody', function () {
            var table1 = $('#rptParamsStsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#rptParamsStsTable').wrap('<div class="dataTables_scroll"/>');
            $('#rptParamsStsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
            runPrcnt = typeof $("#rptParamsStsPrgrs").val() === 'undefined' ? -1 : parseInt($("#rptParamsStsPrgrs").val());
            if ((runPrcnt < 100 && globaltmerCntr <= 0 && mstStop <= 0))
            {
                globaltmerCntr = globaltmerCntr + 1;
                globaltmer = window.setInterval(function () {
                    autoRfrshRptsRnSts(pKeyID, prvRunID, mstStop);
                }, 5000);
            } else if (runPrcnt >= 100 || mstStop > 0) {
                globaltmer = window.clearInterval(globaltmer);
                globaltmerCntr = 0;
                getAllRptRuns('', '#rptsDetailInfo', 'grp=9&typ=1&pg=1&vtyp=1&sbmtdRptID=' + pKeyID);
            }
        });
    } else
    {
        globaltmer = window.clearInterval(globaltmer);
        globaltmerCntr = 0;
        getAllRptRuns('', '#rptsDetailInfo', 'grp=9&typ=1&pg=1&vtyp=1&sbmtdRptID=' + pKeyID);
    }
}

function cancelRptRun(pKeyID, prvRunID)
{
    globaltmer = window.clearInterval(globaltmer);
    var lnkArgs = 'grp=9&typ=1&pg=1&vtyp=4&sbmtdRptID=' + pKeyID + "&sbmtdRunID=" + prvRunID + "";
    doAjaxWthCallBck(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody', function () {
        getAllRptRuns('', '#rptsDetailInfo', 'grp=9&typ=1&pg=1&vtyp=1&sbmtdRptID=' + pKeyID);
        globaltmer = window.clearInterval(globaltmer);
        globaltmerCntr = 0;
        $('#myFormsModalNrml').modal('hide');
    });
}
function rfrshCncldRptRun(pKeyID)
{
    $('#myFormsModal').modal('hide');
    getAllRptRuns('', '#rptsDetailInfo', 'grp=9&typ=1&pg=1&vtyp=1&sbmtdRptID=' + pKeyID);
}

function getAllSchdls(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allSchdlsSrchFor").val() === 'undefined' ? '%' : $("#allSchdlsSrchFor").val();
    var srchIn = typeof $("#allSchdlsSrchIn").val() === 'undefined' ? 'Both' : $("#allSchdlsSrchIn").val();
    var pageNo = typeof $("#allSchdlsPageNo").val() === 'undefined' ? 1 : $("#allSchdlsPageNo").val();
    var limitSze = typeof $("#allSchdlsDsplySze").val() === 'undefined' ? 10 : $("#allSchdlsDsplySze").val();
    var sortBy = typeof $("#allSchdlsSortBy").val() === 'undefined' ? '' : $("#allSchdlsSortBy").val();
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
    doAjaxWthCallBck(linkArgs, 'myFormsModalLg', 'ShowDialog', 'Report/Process Schedules', 'myFormsModalTitleLg', 'myFormsModalBodyLg', function () {
        var table1 = $('#allSchdlPrmsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#allSchdlPrmsTable').wrap('<div class="dataTables_scroll"/>');
        $('#allSchdlsForm').submit(function (e) {
            e.preventDefault();
            return false;
        });
        var table2 = $('#allSchdlsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#allSchdlsTable').wrap('<div class="dataTables_scroll"/>');
        $('#allSchdlsTable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');

            } else {
                table1.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

            }
            var rndmNum = $(this).attr('id').split("_")[1];
            var pkeyID = typeof $('#allSchdlsRow' + rndmNum + '_RptID').val() === 'undefined' ? '%' : $('#allSchdlsRow' + rndmNum + '_RptID').val();
            var pkeyID1 = typeof $('#allSchdlsRow' + rndmNum + '_SchdlID').val() === 'undefined' ? '%' : $('#allSchdlsRow' + rndmNum + '_SchdlID').val();
            //alert(curPlcyID);
            getOneSchdlsForm(pkeyID, pkeyID1, 6);
        });
        $('#allSchdlsTable tbody')
                .on('mouseenter', 'tr', function () {
                    if ($(this).hasClass('highlight')) {
                        $(this).removeClass('highlight');
                    } else {
                        table1.$('tr.highlight').removeClass('highlight');
                        $(this).addClass('highlight');
                    }
                });
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

function enterKeyFuncAllSchdls(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllSchdls(actionText, slctr, linkArgs);
    }
}
function getOneSchdlsNwForm()
{
    var pkeyID = typeof $("#nwRptSchdlRptID").val() === 'undefined' ? -1 : $("#nwRptSchdlRptID").val();
    var pkeyID1 = -1;
    getOneSchdlsForm(pkeyID, pkeyID1, 7);
}

function getOneSchdlsForm(pKeyID, pKeyID1, vwtype)
{    
    var lnkArgs = 'grp=9&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdRptID=' + pKeyID + "&sbmtdSchdlID=" + pKeyID1;
    doAjaxWthCallBck(lnkArgs, 'allSchdlsDetailInfo', 'PasteDirect', '', '', '', function () {
        var table1 = $('#allSchdlPrmsTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#allSchdlPrmsTable').wrap('<div class="dataTables_scroll"/>');
        $('#allSchdlsForm').submit(function (e) {
            e.preventDefault();
            return false;
        });
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
