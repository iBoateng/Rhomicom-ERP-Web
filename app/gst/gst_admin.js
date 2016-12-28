
function prepareGstAdmin(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $(function () {
            /*var numelms=$('[data-toggle="tabajxgst"]').size();*/
            $('[data-toggle="tabajxgst"]').click(function (e) {
                var $this = $(this);
                var targ = $this.attr('href');
                var dttrgt = $this.attr('data-rhodata');
                var linkArgs = 'grp=4&typ=1' + dttrgt;
                return openATab(targ, linkArgs);
            });
        });
        if (lnkArgs.indexOf("&pg=1&vtyp=0") !== -1)
        {
            var table1 = $('#allLovStpsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allLovStpsTable').wrap('<div class="dataTables_scroll"/>');
            $('#allLovStpsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });

            $('#allLovStpsTable tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');

                } else {
                    table1.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
                var rndmNum = $(this).attr('id').split("_")[1];
                var curLovID = typeof $('#allLovStpsRow' + rndmNum + '_LovID').val() === 'undefined' ? '%' : $('#allLovStpsRow' + rndmNum + '_LovID').val();
                getOneLovStpForm(curLovID, 1);
            });
            $('#allLovStpsTable tbody')
                    .on('mouseenter', 'tr', function () {
                        if ($(this).hasClass('highlight')) {
                            $(this).removeClass('highlight');
                        } else {
                            table1.$('tr.highlight').removeClass('highlight');
                            $(this).addClass('highlight');
                        }
                    });
        } else if (lnkArgs.indexOf("&pg=1&vtyp=3") !== -1)
        {
            var table1 = $('#psblValsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#psblValsTable').wrap('<div class="dataTables_scroll"/>');
            $('#psblValsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        }
        htBody.removeClass("mdlloading");
    });
}

function getOneLovStpForm(lovID, vwtype)
{
    var lnkArgs = 'grp=4&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdLovID=' + lovID;
    doAjaxWthCallBck(lnkArgs, 'lovStpsDetailInfo', 'PasteDirect', '', '', '', function () {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $(function () {
                $('[data-toggle="tabajxgst"]').click(function (e) {
                    var $this = $(this);
                    var targ = $this.attr('href');
                    var dttrgt = $this.attr('data-rhodata');
                    var linkArgs = 'grp=4&typ=1' + dttrgt;
                    return openATab(targ, linkArgs);
                });
            });
        });
    });
}
function saveLovStpForm()
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
function getAllLovStps(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allLovStpsSrchFor").val() === 'undefined' ? '%' : $("#allLovStpsSrchFor").val();
    var srchIn = typeof $("#allLovStpsSrchIn").val() === 'undefined' ? 'Both' : $("#allLovStpsSrchIn").val();
    var pageNo = typeof $("#allLovStpsPageNo").val() === 'undefined' ? 1 : $("#allLovStpsPageNo").val();
    var limitSze = typeof $("#allLovStpsDsplySze").val() === 'undefined' ? 10 : $("#allLovStpsDsplySze").val();
    var sortBy = typeof $("#allLovStpsSortBy").val() === 'undefined' ? '' : $("#allLovStpsSortBy").val();
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

function enterKeyFuncLovStps(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllLovStps(actionText, slctr, linkArgs);
    }
}
function getAllPsblVals(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#psblValsSrchFor").val() === 'undefined' ? '%' : $("#psblValsSrchFor").val();
    var srchIn = typeof $("#psblValsSrchIn").val() === 'undefined' ? 'Both' : $("#psblValsSrchIn").val();
    var pageNo = typeof $("#psblValsPageNo").val() === 'undefined' ? 1 : $("#psblValsPageNo").val();
    var limitSze = typeof $("#psblValsDsplySze").val() === 'undefined' ? 10 : $("#psblValsDsplySze").val();
    var sortBy = typeof $("#psblValsSortBy").val() === 'undefined' ? '' : $("#psblValsSortBy").val();
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

function enterKeyFuncPsblVals(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllPsblVals(actionText, slctr, linkArgs);
    }
}

function savePsblValsForm()
{
    var lnkArgs = "grp=4&typ=1&q=UPDATE&actyp=2";
    var slctdPsblVals = "";
    $('#psblValsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            /*var $tds1 = $(this).find('td');*/
            var isEnabled = typeof $("input[name='psblValsRow" + rndmNum + "_IsEnabled']:checked").val() === 'undefined' ? 'No' : 'Yes';
            slctdPsblVals = slctdPsblVals + $('#psblValsRow' + rndmNum + '_PValID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#psblValsRow' + rndmNum + '_PValNm').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#psblValsRow' + rndmNum + '_AlwdOrgs').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#psblValsRow' + rndmNum + '_PValDesc').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdPsblVals=" + slctdPsblVals.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}