
function prepareWkfAdmin(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&pg=1&vtyp=0") !== -1)
        {
            var table1 = $('#allWkfAppsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allWkfAppsTable').wrap('<div class="dataTables_scroll"/>');
            var table2 = $('#wkfAppActnsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#wkfAppActnsTable').wrap('<div class="dataTables_scroll"/>');
            $('#allWkfAppsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });

            $('#allWkfAppsTable tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');

                } else {
                    table1.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
                var rndmNum = $(this).attr('id').split("_")[1];
                var curAppID = typeof $('#allWkfAppsRow' + rndmNum + '_AppID').val() === 'undefined' ? '%' : $('#allWkfAppsRow' + rndmNum + '_AppID').val();
                getOneWkfAppForm(curAppID, 1);
            });
            $('#allWkfAppsTable tbody')
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

function getOneWkfAppForm(appID, vwtype)
{
    var lnkArgs = 'grp=11&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdAppID=' + appID;
    doAjaxWthCallBck(lnkArgs, 'wkfAppsDetailInfo', 'PasteDirect', '', '', '', function () {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $(function () {
                var table2 = $('#wkfAppActnsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#wkfAppActnsTable').wrap('<div class="dataTables_scroll"/>');
            });
        });
    });
}
function saveWkfAppForm()
{
    var lnkArgs = "";
    var scPlcysPlcyNm = typeof $("#scPlcysPlcyNm").val() === 'undefined' ? '' : $("#scPlcysPlcyNm").val();
    var scPlcysPlcyID = typeof $("#scPlcysPlcyID").val() === 'undefined' ? -1 : $("#scPlcysPlcyID").val();
    var scPlcysIsDflt = typeof $("input[name='scPlcysIsDflt']:checked").val() === 'undefined' ? '' : $("input[name='scPlcysIsDflt']:checked").val();
    var scPlcysPwdExpryDys = typeof $("#scPlcysPwdExpryDys").val() === 'undefined' ? '' : $("#scPlcysPwdExpryDys").val();
    var scPlcysNoOfRecs = typeof $("#scPlcysNoOfRecs").val() === 'undefined' ? '' : $("#scPlcysNoOfRecs").val();
    var scPlcysPwdMinLen = typeof $("#scPlcysPwdMinLen").val() === 'undefined' ? '' : $("#scPlcysPwdMinLen").val();
    var scPlcysPwdMaxLen = typeof $("#scPlcysPwdMaxLen").val() === 'undefined' ? '' : $("#scPlcysPwdMaxLen").val();
    var scPlcysPwdOldAlwd = typeof $("#scPlcysPwdOldAlwd").val() === 'undefined' ? '' : $("#scPlcysPwdOldAlwd").val();
    var scPlcysPwdUnmAlwd = typeof $("input[name='scPlcysPwdUnmAlwd']:checked").val() === 'undefined' ? '' : $("input[name='scPlcysPwdUnmAlwd']:checked").val();
    var scPlcysPwdRptngChars = typeof $("input[name='scPlcysPwdRptngChars']:checked").val() === 'undefined' ? '' : $("input[name='scPlcysPwdRptngChars']:checked").val();
    var scPlcysAlwdFailedLgs = typeof $("#scPlcysAlwdFailedLgs").val() === 'undefined' ? '' : $("#scPlcysAlwdFailedLgs").val();
    var scPlcysAutoUnlkTme = typeof $("#scPlcysAutoUnlkTme").val() === 'undefined' ? '' : $("#scPlcysAutoUnlkTme").val();
    var scPlcysChckBlkLtrs = typeof $("input[name='scPlcysChckBlkLtrs']:checked").val() === 'undefined' ? '' : $("input[name='scPlcysChckBlkLtrs']:checked").val();
    var scPlcysChkSmllLtrs = typeof $("input[name='scPlcysChkSmllLtrs']:checked").val() === 'undefined' ? '' : $("input[name='scPlcysChkSmllLtrs']:checked").val();
    var scPlcysChkDgts = typeof $("input[name='scPlcysChkDgts']:checked").val() === 'undefined' ? '' : $("input[name='scPlcysChkDgts']:checked").val();
    var scPlcysChkWild = typeof $("input[name='scPlcysChkWild']:checked").val() === 'undefined' ? '' : $("input[name='scPlcysChkWild']:checked").val();
    var scPlcysCombinations = typeof $("#scPlcysCombinations").val() === 'undefined' ? '' : $("#scPlcysCombinations").val();
    var scPlcysSesnTmeOut = typeof $("#scPlcysSesnTmeOut").val() === 'undefined' ? '' : $("#scPlcysSesnTmeOut").val();

    if (scPlcysPlcyNm === "" || scPlcysPlcyNm === null)
    {
        $('#modal-7 .modal-body').html('Policy Name cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        return false;
    }
    if (scPlcysCombinations === "" || scPlcysCombinations === null)
    {
        $('#modal-7 .modal-body').html('Combinations cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        return false;
    }
    lnkArgs = "grp=3&typ=1&q=UPDATE&actyp=2" +
            "&scPlcysPlcyID=" + scPlcysPlcyID +
            "&scPlcysPlcyNm=" + scPlcysPlcyNm +
            "&scPlcysIsDflt=" + scPlcysIsDflt +
            "&scPlcysPwdExpryDys=" + scPlcysPwdExpryDys +
            "&scPlcysNoOfRecs=" + scPlcysNoOfRecs +
            "&scPlcysPwdMinLen=" + scPlcysPwdMinLen +
            "&scPlcysPwdMaxLen=" + scPlcysPwdMaxLen +
            "&scPlcysPwdOldAlwd=" + scPlcysPwdOldAlwd +
            "&scPlcysPwdUnmAlwd=" + scPlcysPwdUnmAlwd +
            "&scPlcysPwdRptngChars=" + scPlcysPwdRptngChars +
            "&scPlcysAlwdFailedLgs=" + scPlcysAlwdFailedLgs +
            "&scPlcysAutoUnlkTme=" + scPlcysAutoUnlkTme +
            "&scPlcysChckBlkLtrs=" + scPlcysChckBlkLtrs +
            "&scPlcysChkSmllLtrs=" + scPlcysChkSmllLtrs +
            "&scPlcysChkDgts=" + scPlcysChkDgts +
            "&scPlcysChkWild=" + scPlcysChkWild +
            "&scPlcysCombinations=" + scPlcysCombinations +
            "&scPlcysSesnTmeOut=" + scPlcysSesnTmeOut;
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}
function getAllWkfApps(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allWkfAppsSrchFor").val() === 'undefined' ? '%' : $("#allWkfAppsSrchFor").val();
    var srchIn = typeof $("#allWkfAppsSrchIn").val() === 'undefined' ? 'Both' : $("#allWkfAppsSrchIn").val();
    var pageNo = typeof $("#allWkfAppsPageNo").val() === 'undefined' ? 1 : $("#allWkfAppsPageNo").val();
    var limitSze = typeof $("#allWkfAppsDsplySze").val() === 'undefined' ? 10 : $("#allWkfAppsDsplySze").val();
    var sortBy = typeof $("#allWkfAppsSortBy").val() === 'undefined' ? '' : $("#allWkfAppsSortBy").val();
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

function enterKeyFuncWkfApps(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllWkfApps(actionText, slctr, linkArgs);
    }
}