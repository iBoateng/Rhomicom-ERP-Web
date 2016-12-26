
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
        }else if (lnkArgs.indexOf("&pg=1&vtyp=3") !== -1)
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