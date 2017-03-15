function prepareAttn(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&pg=1&vtyp=0") !== -1)
        {
            var table1 = $('#myEvntsAtndTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#myEvntsAtndTable').wrap('<div class="dataTables_scroll"/>');
            $('#myEvntsAtndForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        }
        htBody.removeClass("mdlloading");
    });
}

function getMyEvntsAtnd(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#myEvntsAtndSrchFor").val() === 'undefined' ? '%' : $("#myEvntsAtndSrchFor").val();
    var srchIn = typeof $("#myEvntsAtndSrchIn").val() === 'undefined' ? 'Both' : $("#myEvntsAtndSrchIn").val();
    var pageNo = typeof $("#myEvntsAtndPageNo").val() === 'undefined' ? 1 : $("#myEvntsAtndPageNo").val();
    var limitSze = typeof $("#myEvntsAtndDsplySze").val() === 'undefined' ? 10 : $("#myEvntsAtndDsplySze").val();
    var sortBy = typeof $("#myEvntsAtndSortBy").val() === 'undefined' ? '' : $("#myEvntsAtndSortBy").val();
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

function enterKeyFuncMyEvntsAtnd(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getMyEvntsAtnd(actionText, slctr, linkArgs);
    }
}

function getOneMyEvntsAtndForm(pKeyID, pKeyID1, vwtype)
{
    var lnkArgs = 'grp=16&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdPyReqID=' + pKeyID + '&sbmtdMspyID=' + pKeyID1;
    doAjaxWthCallBck(lnkArgs, 'myEvntsAtndDetailInfo', 'PasteDirect', '', '', '', function () {
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