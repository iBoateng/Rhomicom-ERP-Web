function prepareInbox(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        var table = $('#myInbxTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "scrollX": false
        });
        $('#myInbxTable').wrap('<div class="dataTables_scroll"/>');

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
        $('#myInbxTable tbody')
                .on('mouseenter', 'tr', function () {
                    if ($(this).hasClass('highlight')) {
                        $(this).removeClass('highlight');
                    } else {
                        table.$('tr.highlight').removeClass('highlight');
                        $(this).addClass('highlight');
                    }
                });
    });
    htBody.removeClass("mdlloading");
}


function getMyInbx(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#myInbxSrchFor").val() === 'undefined' ? '%' : $("#myInbxSrchFor").val();
    var srchIn = typeof $("#myInbxSrchIn").val() === 'undefined' ? 'Both' : $("#myInbxSrchIn").val();
    var pageNo = typeof $("#myInbxPageNo").val() === 'undefined' ? 1 : $("#myInbxPageNo").val();
    var limitSze = typeof $("#myInbxDsplySze").val() === 'undefined' ? 10 : $("#myInbxDsplySze").val();
    var sortBy = typeof $("#myInbxSortBy").val() === 'undefined' ? '' : $("#myInbxSortBy").val();
    var qStrtDte = typeof $("#myInbxStrtDate").val() === 'undefined' ? '' : $("#myInbxStrtDate").val();
    var qEndDte = typeof $("#myInbxEndDate").val() === 'undefined' ? '' : $("#myInbxEndDate").val();
    var qActvOnly = $('#myInbxShwActvNtfs:checked').length > 0;
    var qNonLgn = $('#myInbxShwNonLgnNtfs:checked').length > 0;
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
            "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&sortBy=" + sortBy
            + "&qStrtDte=" + qStrtDte + "&qEndDte=" + qEndDte + "&qActvOnly=" + qActvOnly + "&qNonLgn=" + qNonLgn;

    openATab(slctr, linkArgs);
}

function enterKeyFuncMyInbx(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getMyInbx(actionText, slctr, linkArgs);
    }
}

function getOneMyInbxForm(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, routingID, vtyp, pgNo)
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

                $('#' + elementID).on('show.bs.modal', function (e) {
                    $(this).find('.modal-body').css({
                        'max-height': '100%'
                    });
                });

                $(document).ready(function () {
                    $('#myInbxDetTable').wrap('<div class="dataTables_scroll"/>');
                    var table1 = $('#myInbxActionsTable').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#myInbxActionsTable').wrap('<div class="dataTables_scroll"/>');
                });
                $body.removeClass("mdlloadingDiag");
                $('#' + elementID).modal('show');
                $body.removeClass("mdlloading");

                $('#' + formElementID).submit(function (e) {
                    e.preventDefault();
                    return false;
                });
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=40&typ=2&pg=" + pgNo + "&vtyp=" + vtyp + "&RoutingID=" + routingID);
    });
}