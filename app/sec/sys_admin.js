
function prepareSysAdmin(lnkArgs, htBody, targ, rspns)
{
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&pg=1&vtyp=0") !== -1)
        {
            var table1 = $('#allUsersTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allUsersTable').wrap('<div class="dataTables_scroll"/>');
            $('#allUsersForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        }
        htBody.removeClass("mdlloading");
    });
}

function getAllUsers(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allUsersSrchFor").val() === 'undefined' ? '%' : $("#allUsersSrchFor").val();
    var srchIn = typeof $("#allUsersSrchIn").val() === 'undefined' ? 'Both' : $("#allUsersSrchIn").val();
    var pageNo = typeof $("#allUsersPageNo").val() === 'undefined' ? 1 : $("#allUsersPageNo").val();
    var limitSze = typeof $("#allUsersDsplySze").val() === 'undefined' ? 10 : $("#allUsersDsplySze").val();
    var sortBy = typeof $("#allUsersSortBy").val() === 'undefined' ? '' : $("#allUsersSortBy").val();
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

function enterKeyFuncAllUsers(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllUsers(actionText, slctr, linkArgs);
    }
}


function getOneUserForm(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, userID, vtyp, pgNo, actionText)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");

        var srchFor = typeof $("#userRolesSrchFor").val() === 'undefined' ? '%' : $("#userRolesSrchFor").val();
        var srchIn = typeof $("#userRolesSrchIn").val() === 'undefined' ? 'Both' : $("#userRolesSrchIn").val();
        var pageNo = typeof $("#userRolesPageNo").val() === 'undefined' ? 1 : $("#userRolesPageNo").val();
        var limitSze = typeof $("#userRolesDsplySze").val() === 'undefined' ? 10 : $("#userRolesDsplySze").val();
        var sortBy = typeof $("#userRolesSortBy").val() === 'undefined' ? '' : $("#userRolesSortBy").val();
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
        var linkArgs = "&searchfor=" + srchFor + "&searchin=" + srchIn +
                "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&sortBy=" + sortBy;
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
                /*$('.modal-dialog').draggable();*/
                if (vtyp == 1)
                {
                    var table1 = $('#userRolesTable').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#userRolesTable').wrap('<div class="dataTables_scroll" />');

                    $('#userRolesForm').submit(function (e) {
                        e.preventDefault();
                        return false;
                    });
                }
                $(function () {
                    $('.form_date').datetimepicker({
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

                $('#' + elementID).on('show.bs.modal', function (e) {
                    $(this).find('.modal-body').css({
                        'max-height': '100%'
                    });
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
        xmlhttp.send("grp=3&typ=1&pg=" + pgNo + "&vtyp=" + vtyp + "&sbmtdUserID=" + userID + linkArgs);
    });
}

function saveOneUserForm(elementID, userID, tableElementID)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
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
                $body.removeClass("mdlloading");
                $('#' + elementID).modal('hide');
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("grp=3&typ=1&pg=0&q=UPDATE&actyp=4" +
                "&divGrpName=" + divGrpName +
                "&divGrpTyp=" + divGrpTyp +
                "&divGrpStartDate=" + divGrpStartDate +
                "&divGrpEndDate=" + divGrpEndDate +
                "&divsGrpsPkeyID=" + userID);
    });
}

function enterKeyFuncOneUser(e, elementID, modalBodyID, titleElementID, formElementID,
        formTitle, userID, vtyp, pgNo, actionText)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getOneUserForm(elementID, modalBodyID, titleElementID, formElementID,
                formTitle, userID, vtyp, pgNo, actionText);
    }
}