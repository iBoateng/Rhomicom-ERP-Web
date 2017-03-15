
function prepareOrgAdmin(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="tabajxorg"]').click(function (e) {
                var $this = $(this);
                var targ = $this.attr('href');
                var dttrgt = $this.attr('data-rhodata');
                var linkArgs = 'grp=5&typ=1' + dttrgt;
                return openATab(targ, linkArgs);
            });
        });
        if (lnkArgs.indexOf("&pg=1&vtyp=0") !== -1)
        {
            var table1 = $('#allOrgStpsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allOrgStpsTable').wrap('<div class="dataTables_scroll"/>');
            $('#allOrgStpsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });

            $('#allOrgStpsTable tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');

                } else {
                    table1.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
                var rndmNum = $(this).attr('id').split("_")[1];
                var curOrgID = typeof $('#allOrgStpsRow' + rndmNum + '_OrgID').val() === 'undefined' ? '%' : $('#allOrgStpsRow' + rndmNum + '_OrgID').val();
                getOneOrgStpForm(curOrgID, 1);
            });
            $('#allOrgStpsTable tbody')
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
            var table1 = $('#divsGrpsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#divsGrpsTable').wrap('<div class="dataTables_scroll"/>');
            $('#divsGrpsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        } else if (lnkArgs.indexOf("&pg=1&vtyp=4") !== -1)
        {
            var table1 = $('#sitesLocsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#sitesLocsTable').wrap('<div class="dataTables_scroll"/>');
            $('#sitesLocsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        } else if (lnkArgs.indexOf("&pg=1&vtyp=5") !== -1)
        {
            var table1 = $('#orgJobsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#orgJobsTable').wrap('<div class="dataTables_scroll"/>');
            $('#orgJobsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        } else if (lnkArgs.indexOf("&pg=1&vtyp=6") !== -1)
        {
            var table1 = $('#orgGradesTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#orgGradesTable').wrap('<div class="dataTables_scroll"/>');
            $('#orgGradesForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        } else if (lnkArgs.indexOf("&pg=1&vtyp=7") !== -1)
        {
            var table1 = $('#orgPositionsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#orgPositionsTable').wrap('<div class="dataTables_scroll"/>');
            $('#orgPositionsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        }
        htBody.removeClass("mdlloading");
    });
}

function getOneOrgStpForm(orgID, vwtype)
{
    var lnkArgs = 'grp=5&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdOrgID=' + orgID;
    doAjaxWthCallBck(lnkArgs, 'orgStpsDetailInfo', 'PasteDirect', '', '', '', function () {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $(function () {
                $('[data-toggle="tabajxorg"]').click(function (e) {
                    var $this = $(this);
                    var targ = $this.attr('href');
                    var dttrgt = $this.attr('data-rhodata');
                    var linkArgs = 'grp=5&typ=1' + dttrgt;
                    return openATab(targ, linkArgs);
                });
            });
        });
    });
}

function saveOrgStpForm()
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
function getAllOrgStps(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allOrgStpsSrchFor").val() === 'undefined' ? '%' : $("#allOrgStpsSrchFor").val();
    var srchIn = typeof $("#allOrgStpsSrchIn").val() === 'undefined' ? 'Both' : $("#allOrgStpsSrchIn").val();
    var pageNo = typeof $("#allOrgStpsPageNo").val() === 'undefined' ? 1 : $("#allOrgStpsPageNo").val();
    var limitSze = typeof $("#allOrgStpsDsplySze").val() === 'undefined' ? 10 : $("#allOrgStpsDsplySze").val();
    var sortBy = typeof $("#allOrgStpsSortBy").val() === 'undefined' ? '' : $("#allOrgStpsSortBy").val();
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

function enterKeyFuncOrgStps(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllOrgStps(actionText, slctr, linkArgs);
    }
}

function getAllDivsGrps(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#divsGrpsSrchFor").val() === 'undefined' ? '%' : $("#divsGrpsSrchFor").val();
    var srchIn = typeof $("#divsGrpsSrchIn").val() === 'undefined' ? 'Both' : $("#divsGrpsSrchIn").val();
    var pageNo = typeof $("#divsGrpsPageNo").val() === 'undefined' ? 1 : $("#divsGrpsPageNo").val();
    var limitSze = typeof $("#divsGrpsDsplySze").val() === 'undefined' ? 10 : $("#divsGrpsDsplySze").val();
    var sortBy = typeof $("#divsGrpsSortBy").val() === 'undefined' ? '' : $("#divsGrpsSortBy").val();
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

function enterKeyFuncDivsGrps(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllDivsGrps(actionText, slctr, linkArgs);
    }
}

function saveDivsGrpsForm()
{
    var lnkArgs = "grp=5&typ=1&q=UPDATE&actyp=2";
    var slctdDivsGrps = "";
    $('#divsGrpsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            /*var $tds1 = $(this).find('td');*/
            var isEnabled = typeof $("input[name='divsGrpsRow" + rndmNum + "_IsEnabled']:checked").val() === 'undefined' ? 'No' : 'Yes';
            slctdDivsGrps = slctdDivsGrps + $('#divsGrpsRow' + rndmNum + '_GroupID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_GroupNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_PrntID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_DivTypNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_GroupDesc').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdDivsGrps=" + slctdDivsGrps.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}

function getAllSitesLocs(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#sitesLocsSrchFor").val() === 'undefined' ? '%' : $("#sitesLocsSrchFor").val();
    var srchIn = typeof $("#sitesLocsSrchIn").val() === 'undefined' ? 'Both' : $("#sitesLocsSrchIn").val();
    var pageNo = typeof $("#sitesLocsPageNo").val() === 'undefined' ? 1 : $("#sitesLocsPageNo").val();
    var limitSze = typeof $("#sitesLocsDsplySze").val() === 'undefined' ? 10 : $("#sitesLocsDsplySze").val();
    var sortBy = typeof $("#sitesLocsSortBy").val() === 'undefined' ? '' : $("#sitesLocsSortBy").val();
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

function enterKeyFuncSitesLocs(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllSitesLocs(actionText, slctr, linkArgs);
    }
}

function saveSitesLocsForm()
{
    var lnkArgs = "grp=5&typ=1&q=UPDATE&actyp=3";
    var slctdSitesLocs = "";
    $('#sitesLocsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            /*var $tds1 = $(this).find('td');*/
            var isEnabled = typeof $("input[name='sitesLocsRow" + rndmNum + "_IsEnabled']:checked").val() === 'undefined' ? 'No' : 'Yes';
            slctdSitesLocs = slctdSitesLocs + $('#sitesLocsRow' + rndmNum + '_SiteID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#sitesLocsRow' + rndmNum + '_SiteNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#sitesLocsRow' + rndmNum + '_SiteDesc').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdSitesLocs=" + slctdSitesLocs.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}

function getAllOrgJobs(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#orgJobsSrchFor").val() === 'undefined' ? '%' : $("#orgJobsSrchFor").val();
    var srchIn = typeof $("#orgJobsSrchIn").val() === 'undefined' ? 'Both' : $("#orgJobsSrchIn").val();
    var pageNo = typeof $("#orgJobsPageNo").val() === 'undefined' ? 1 : $("#orgJobsPageNo").val();
    var limitSze = typeof $("#orgJobsDsplySze").val() === 'undefined' ? 10 : $("#orgJobsDsplySze").val();
    var sortBy = typeof $("#orgJobsSortBy").val() === 'undefined' ? '' : $("#orgJobsSortBy").val();
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

function enterKeyFuncOrgJobs(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllOrgJobs(actionText, slctr, linkArgs);
    }
}

function saveOrgJobsForm()
{
    var lnkArgs = "grp=5&typ=1&q=UPDATE&actyp=4";
    var slctdOrgJobs = "";
    $('#orgJobsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            /*var $tds1 = $(this).find('td');*/
            var isEnabled = typeof $("input[name='orgJobsRow" + rndmNum + "_IsEnabled']:checked").val() === 'undefined' ? 'No' : 'Yes';
            slctdOrgJobs = slctdOrgJobs + $('#orgJobsRow' + rndmNum + '_JobID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgJobsRow' + rndmNum + '_JobNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgJobsRow' + rndmNum + '_PrntID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgJobsRow' + rndmNum + '_JobDesc').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdOrgJobs=" + slctdOrgJobs.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}

function getAllOrgGrades(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#orgGradesSrchFor").val() === 'undefined' ? '%' : $("#orgGradesSrchFor").val();
    var srchIn = typeof $("#orgGradesSrchIn").val() === 'undefined' ? 'Both' : $("#orgGradesSrchIn").val();
    var pageNo = typeof $("#orgGradesPageNo").val() === 'undefined' ? 1 : $("#orgGradesPageNo").val();
    var limitSze = typeof $("#orgGradesDsplySze").val() === 'undefined' ? 10 : $("#orgGradesDsplySze").val();
    var sortBy = typeof $("#orgGradesSortBy").val() === 'undefined' ? '' : $("#orgGradesSortBy").val();
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

function enterKeyFuncOrgGrades(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllOrgGrades(actionText, slctr, linkArgs);
    }
}

function saveOrgGradesForm()
{
    var lnkArgs = "grp=5&typ=1&q=UPDATE&actyp=5";
    var slctdOrgGrades = "";
    $('#orgGradesTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            /*var $tds1 = $(this).find('td');*/
            var isEnabled = typeof $("input[name='orgGradesRow" + rndmNum + "_IsEnabled']:checked").val() === 'undefined' ? 'No' : 'Yes';
            slctdOrgGrades = slctdOrgGrades + $('#orgGradesRow' + rndmNum + '_GradeID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgGradesRow' + rndmNum + '_GradeNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgGradesRow' + rndmNum + '_PrntID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgGradesRow' + rndmNum + '_GradeDesc').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdOrgGrades=" + slctdOrgGrades.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}

function getAllOrgPositions(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#orgPositionsSrchFor").val() === 'undefined' ? '%' : $("#orgPositionsSrchFor").val();
    var srchIn = typeof $("#orgPositionsSrchIn").val() === 'undefined' ? 'Both' : $("#orgPositionsSrchIn").val();
    var pageNo = typeof $("#orgPositionsPageNo").val() === 'undefined' ? 1 : $("#orgPositionsPageNo").val();
    var limitSze = typeof $("#orgPositionsDsplySze").val() === 'undefined' ? 10 : $("#orgPositionsDsplySze").val();
    var sortBy = typeof $("#orgPositionsSortBy").val() === 'undefined' ? '' : $("#orgPositionsSortBy").val();
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

function enterKeyFuncOrgPositions(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllOrgPositions(actionText, slctr, linkArgs);
    }
}

function saveOrgPositionsForm()
{
    var lnkArgs = "grp=5&typ=1&q=UPDATE&actyp=6";
    var slctdOrgPositions = "";
    $('#orgPositionsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            /*var $tds1 = $(this).find('td');*/
            var isEnabled = typeof $("input[name='orgPositionsRow" + rndmNum + "_IsEnabled']:checked").val() === 'undefined' ? 'No' : 'Yes';
            slctdOrgPositions = slctdOrgPositions + $('#orgPositionsRow' + rndmNum + '_PosID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgPositionsRow' + rndmNum + '_PosNm').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgPositionsRow' + rndmNum + '_PrntID').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + $('#orgPositionsRow' + rndmNum + '_PosDesc').val().replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)/g, "{-;-;}").replace(/(\|)/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdOrgPositions=" + slctdOrgPositions.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}