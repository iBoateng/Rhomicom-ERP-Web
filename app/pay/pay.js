function preparePay(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&pg=1&vtyp=0") !== -1)
        {
            var table1 = $('#myPayRnsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#myPayRnsTable').wrap('<div class="dataTables_scroll"/>');
            $('#myPayRnsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
            var table2 = $('#myPayRnLinesTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#myPayRnLinesTable').wrap('<div class="dataTables_scroll"/>');
            $('#myPayRnsTable tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');

                } else {
                    table1.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
                var rndmNum = $(this).attr('id').split("_")[1];
                var pkeyID = typeof $('#myPayRnsRow' + rndmNum + '_PyReqID').val() === 'undefined' ? '%' : $('#myPayRnsRow' + rndmNum + '_PyReqID').val();
                var pkeyID1 = typeof $('#myPayRnsRow' + rndmNum + '_MspyID').val() === 'undefined' ? '%' : $('#myPayRnsRow' + rndmNum + '_MspyID').val();
                getOneMyPyRnsForm(pkeyID, pkeyID1, 1);
            });
            $('#myPayRnsTable tbody')
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

function getMyPayRns(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#myPayRnsSrchFor").val() === 'undefined' ? '%' : $("#myPayRnsSrchFor").val();
    var srchIn = typeof $("#myPayRnsSrchIn").val() === 'undefined' ? 'Both' : $("#myPayRnsSrchIn").val();
    var pageNo = typeof $("#myPayRnsPageNo").val() === 'undefined' ? 1 : $("#myPayRnsPageNo").val();
    var limitSze = typeof $("#myPayRnsDsplySze").val() === 'undefined' ? 10 : $("#myPayRnsDsplySze").val();
    var sortBy = typeof $("#myPayRnsSortBy").val() === 'undefined' ? '' : $("#myPayRnsSortBy").val();
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

function enterKeyFuncMyPayRns(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getMyPayRns(actionText, slctr, linkArgs);
    }
}

function getOneMyPyRnsForm(pKeyID, pKeyID1, vwtype)
{
    var lnkArgs = 'grp=7&typ=1&pg=1&vtyp=' + vwtype + '&sbmtdPyReqID=' + pKeyID + '&sbmtdMspyID=' + pKeyID1;
    doAjaxWthCallBck(lnkArgs, 'myPayRnsDetailInfo', 'PasteDirect', '', '', '', function () {
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
