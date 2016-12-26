
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
        }else if (lnkArgs.indexOf("&pg=1&vtyp=5") !== -1)
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
        }
        htBody.removeClass("mdlloading");
    });
}

function getOneOrgStpForm(orgID, vwtype)
{
    var lnkArgs = 'grp=5&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdOrgID=' + orgID;
    doAjax(lnkArgs, 'orgStpsDetailInfo', 'PasteDirect', '', '', '');
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
            slctdDivsGrps = slctdDivsGrps + $('#divsGrpsRow' + rndmNum + '_GroupID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_GroupNm').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_PrntID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_DivTypNm').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#divsGrpsRow' + rndmNum + '_GroupDesc').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
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
            slctdSitesLocs = slctdSitesLocs + $('#sitesLocsRow' + rndmNum + '_SiteID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#sitesLocsRow' + rndmNum + '_SiteNm').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#sitesLocsRow' + rndmNum + '_SiteDesc').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
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
            slctdOrgJobs = slctdOrgJobs + $('#orgJobsRow' + rndmNum + '_JobID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#orgJobsRow' + rndmNum + '_JobNm').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#orgJobsRow' + rndmNum + '_PrntID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#orgJobsRow' + rndmNum + '_JobDesc').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + isEnabled.replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdOrgJobs=" + slctdOrgJobs.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}