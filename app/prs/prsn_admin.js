
function prepareDataAdmin(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=0") !== -1)
        {
            var table1 = $('#dataAdminTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
        }
        htBody.removeClass("mdlloading");
    });
}

function getDataAdmin(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#dataAdminSrchFor").val() === 'undefined' ? '%' : $("#dataAdminSrchFor").val();
    var srchIn = typeof $("#dataAdminSrchIn").val() === 'undefined' ? 'Both' : $("#dataAdminSrchIn").val();
    var pageNo = typeof $("#dataAdminPageNo").val() === 'undefined' ? 1 : $("#dataAdminPageNo").val();
    var limitSze = typeof $("#dataAdminDsplySze").val() === 'undefined' ? 10 : $("#dataAdminDsplySze").val();
    var sortBy = typeof $("#dataAdminSortBy").val() === 'undefined' ? '' : $("#dataAdminSortBy").val();
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
            "&pageNo=" + pageNo + "&limitSze=" + limitSze+"&sortBy="+sortBy;
    openATab(slctr, linkArgs);
}

function enterKeyFuncDtAdmn(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getDataAdmin(actionText, slctr, linkArgs);
    }
}

function getDivsGroupsForm(elementID, modalBodyID, titleElementID, formElementID,
        tRowElementID, formTitle, vtyp, addOrEdit, pKeyID, personID)
{
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
            $('.modal-dialog').draggable();
            $(function () {
                $('.form_date').datetimepicker({
                    format: "d-M-yyyy",
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

            if (addOrEdit === 'EDIT')
            {
                /*Get various field element IDs and populate values*/
                var $tds = $('#' + tRowElementID).find('td');
                $('#divGrpName').val($.trim($tds.eq(1).text()));
                $('#divGrpTyp').val($.trim($tds.eq(2).text()));
                $('#divGrpStartDate').val($.trim($tds.eq(3).text()));
                $('#divGrpEndDate').val($.trim($tds.eq(4).text()));
            }
            $('#' + elementID).on('show.bs.modal', function (e) {
                $(this).find('.modal-body').css({
                    'max-height': '100%'
                });
            });
            $body.removeClass("mdlloadingDiag");
            $('#' + elementID).modal('show');
            $(document).ready(function () {
                $('#' + formElementID).submit(function (e) {
                    e.preventDefault();
                    return false;
                });

            });
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&divsGrpsPkeyID=" + pKeyID + "&sbmtdPersonID=" + personID);
}

function saveDivsGroupsForm(elementID, pKeyID, personID, tableElementID)
{
    $body = $("body");
    $body.addClass("mdlloadingDiag");
    var divGrpName = typeof $("#divGrpName").val() === 'undefined' ? '%' : $("#divGrpName").val();
    var divGrpTyp = typeof $("#divGrpTyp").val() === 'undefined' ? 'Both' : $("#divGrpTyp").val();
    var divGrpStartDate = typeof $("#divGrpStartDate").val() === 'undefined' ? 1 : $("#divGrpStartDate").val();
    var divGrpEndDate = typeof $("#divGrpEndDate").val() === 'undefined' ? 10 : $("#divGrpEndDate").val();
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
            $('#' + tableElementID).append('<tr><td></td><td colspan="6">' + xmlhttp.responseText + '</td></tr>');
            $body.removeClass("mdlloadingDiag");
            $('#' + elementID).modal('hide');
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=4" +
            "&divGrpName=" + divGrpName +
            "&divGrpTyp=" + divGrpTyp +
            "&divGrpStartDate=" + divGrpStartDate +
            "&divGrpEndDate=" + divGrpEndDate +
            "&divsGrpsPkeyID=" + pKeyID +
            "&sbmtdPersonID=" + personID);
}