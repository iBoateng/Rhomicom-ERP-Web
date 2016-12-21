
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
        } else if (lnkArgs.indexOf("&pg=2&vtyp=0") !== -1)
        {
            var table1 = $('#allRolesTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allRolesTable').wrap('<div class="dataTables_scroll"/>');
            $('#allRolesForm').submit(function (e) {
                e.preventDefault();
                return false;
            });

            $(function () {
                $('.form_date_tme').datetimepicker({
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
        } else if (lnkArgs.indexOf("&pg=3&vtyp=0") !== -1)
        {
            var table1 = $('#allMdlsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allMdlsTable').wrap('<div class="dataTables_scroll"/>');
            $('#allMdlsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        } else if (lnkArgs.indexOf("&pg=4&vtyp=0") !== -1)
        {
            var table1 = $('#allSbgrpsTable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('#allSbgrpsTable').wrap('<div class="dataTables_scroll"/>');
            $('#allSbgrpsForm').submit(function (e) {
                e.preventDefault();
                return false;
            });
        } else if (lnkArgs.indexOf("&pg=5&vtyp=0") !== -1)
        {
            $(document).ready(function () {
                var cntr = 0;
                var table1 = $('#allSecPlcysTable').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "bFilter": false,
                    "scrollX": false
                });
                $('#allSecPlcysTable').wrap('<div class="dataTables_scroll"/>');
                var table2 = $('#secPlcyAdtTblsTable').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "bFilter": false,
                    "scrollX": false
                });
                $('#secPlcyAdtTblsTable').wrap('<div class="dataTables_scroll"/>');

                $('#allSecPlcysForm').submit(function (e) {
                    e.preventDefault();
                    return false;
                });

                $('#allSecPlcysTable tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');

                    } else {
                        table1.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');

                    }
                    var rndmNum = $(this).attr('id').split("_")[1];
                    var curPlcyID = typeof $('#allSecPlcysRow' + rndmNum + '_PlcyID').val() === 'undefined' ? '%' : $('#allSecPlcysRow' + rndmNum + '_PlcyID').val();
                    //alert(curPlcyID);
                    getOneSecPlcyForm(curPlcyID, 1);
                });
                $('#allSecPlcysTable tbody')
                        .on('mouseenter', 'tr', function () {
                            if ($(this).hasClass('highlight')) {
                                $(this).removeClass('highlight');
                            } else {
                                table1.$('tr.highlight').removeClass('highlight');
                                $(this).addClass('highlight');
                            }
                        });
            });
        } else if (lnkArgs.indexOf("&pg=6&vtyp=0") !== -1)
        {
            $(document).ready(function () {
                var cntr = 0;
                var table1 = $('#allSrvrStngsTable').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "bFilter": false,
                    "scrollX": false
                });
                $('#allSrvrStngsTable').wrap('<div class="dataTables_scroll"/>');
                var table2 = $('#srvrStngSmsApiTable').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "bFilter": false,
                    "scrollX": false
                });
                $('#srvrStngSmsApiTable').wrap('<div class="dataTables_scroll"/>');

                $('#allSrvrStngsForm').submit(function (e) {
                    e.preventDefault();
                    return false;
                });

                $('#allSrvrStngsTable tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                    } else {
                        table1.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                    var rndmNum = $(this).attr('id').split("_")[1];
                    var curSrvrID = typeof $('#allSrvrStngsRow' + rndmNum + '_SrvrID').val() === 'undefined' ? '%' : $('#allSrvrStngsRow' + rndmNum + '_SrvrID').val();
                    
                    getOneSrvrStngForm(curSrvrID, 1);
                });
                $('#allSrvrStngsTable tbody')
                        .on('mouseenter', 'tr', function () {
                            if ($(this).hasClass('highlight')) {
                                $(this).removeClass('highlight');
                            } else {
                                table1.$('tr.highlight').removeClass('highlight');
                                $(this).addClass('highlight');
                            }
                        });
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
                    $('.form_date_tme').datetimepicker({
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

function saveUserNRoleForm()
{
    var lnkArgs = "";
    var usrPrflAccountName = typeof $("#usrPrflAccountName").val() === 'undefined' ? '%' : $("#usrPrflAccountName").val();
    var usrPrflAccountID = typeof $("#usrPrflAccountID").val() === 'undefined' ? '%' : $("#usrPrflAccountID").val();
    var usrPrflAcntOwnerLocID = typeof $("#usrPrflAcntOwnerLocID").val() === 'undefined' ? '%' : $("#usrPrflAcntOwnerLocID").val();
    var usrPrflModulesNeeded = typeof $("#usrPrflModulesNeeded").val() === 'undefined' ? '%' : $("#usrPrflModulesNeeded").val();
    var usrPrflVldtyStartDate = typeof $("#usrPrflVldtyStartDate").val() === 'undefined' ? '%' : $("#usrPrflVldtyStartDate").val();
    var usrPrflVldtyEndDate = typeof $("#usrPrflVldtyEndDate").val() === 'undefined' ? '%' : $("#usrPrflVldtyEndDate").val();

    if (usrPrflAccountName === "" || usrPrflAccountName === null)
    {
        $('#modal-7 .modal-body').html('User Name cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        return false;
    }
    if (usrPrflAcntOwnerLocID === "" || usrPrflAcntOwnerLocID === null)
    {
        $('#modal-7 .modal-body').html('Account Owner cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        return false;
    }
    lnkArgs = "grp=3&typ=1&q=UPDATE&actyp=2&usrPrflAccountName=" + usrPrflAccountName + "&usrPrflAccountID=" +
            usrPrflAccountID + "&usrPrflAcntOwnerLocID=" + usrPrflAcntOwnerLocID +
            "&usrPrflModulesNeeded=" + usrPrflModulesNeeded + "&usrPrflVldtyStartDate=" + usrPrflVldtyStartDate +
            "&usrPrflVldtyEndDate=" + usrPrflVldtyEndDate;
    var slctdUsrPrflRoles = "";
    $('#userRolesTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            /*var $tds1 = $(this).find('td');*/
            slctdUsrPrflRoles = slctdUsrPrflRoles + $('#usrPrflEdtRow' + rndmNum + '_RoleID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#usrPrflEdtRow' + rndmNum + '_RoleNm').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#usrPrflEdtRow' + rndmNum + '_DfltRowID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#usrPrflEdtRow' + rndmNum + '_StrtDte').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#usrPrflEdtRow' + rndmNum + '_EndDte').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdUsrPrflRoles=" + slctdUsrPrflRoles.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}


function getAllRoles(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allRolesSrchFor").val() === 'undefined' ? '%' : $("#allRolesSrchFor").val();
    var srchIn = typeof $("#allRolesSrchFor").val() === 'undefined' ? 'Both' : $("#allRolesSrchFor").val();
    var pageNo = typeof $("#allRolesPageNo").val() === 'undefined' ? 1 : $("#allRolesPageNo").val();
    var limitSze = typeof $("#allRolesDsplySze").val() === 'undefined' ? 10 : $("#allRolesDsplySze").val();
    var sortBy = typeof $("#allRolesSortBy").val() === 'undefined' ? '' : $("#allRolesSortBy").val();
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

function enterKeyFuncAllRoles(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllRoles(actionText, slctr, linkArgs);
    }
}


function saveAllRolesForm()
{
    var lnkArgs = "grp=3&typ=1&q=UPDATE&actyp=6";
    var slctdRoles = "";
    $('#allRolesTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            var curRoleNm = typeof $('#allRolesEdtRow' + rndmNum + '_RoleNm').val() === 'undefined' ? '%' : $('#allRolesEdtRow' + rndmNum + '_RoleNm').val();

            if (curRoleNm === "" || curRoleNm === null)
            {
                /*$('#modal-7 .modal-body').html('Role Name cannot be empty!');
                 $('#modal-7').modal('show', {backdrop: 'static'});
                 return false;*/
            } else {
                slctdRoles = slctdRoles + $('#allRolesEdtRow' + rndmNum + '_RoleID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                        + curRoleNm.replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                        + $('#allRolesEdtRow' + rndmNum + '_CanAdmn').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                        + $('#allRolesEdtRow' + rndmNum + '_StrtDte').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                        + $('#allRolesEdtRow' + rndmNum + '_EndDte').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
            }
        }
    });
    lnkArgs = lnkArgs + "&slctdAllRoles=" + slctdRoles.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}

function getOneRoleForm(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, roleID, vtyp, pgNo, actionText)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");

        var srchFor = typeof $("#rolePrvldgsSrchFor").val() === 'undefined' ? '%' : $("#rolePrvldgsSrchFor").val();
        var srchIn = typeof $("#rolePrvldgsSrchIn").val() === 'undefined' ? 'Both' : $("#rolePrvldgsSrchIn").val();
        var pageNo = typeof $("#rolePrvldgsPageNo").val() === 'undefined' ? 1 : $("#rolePrvldgsPageNo").val();
        var limitSze = typeof $("#rolePrvldgsDsplySze").val() === 'undefined' ? 10 : $("#rolePrvldgsDsplySze").val();
        var sortBy = typeof $("#rolePrvldgsSortBy").val() === 'undefined' ? '' : $("#rolePrvldgsSortBy").val();
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
                if (formTitle != '')
                {
                    $('#' + titleElementID).html(formTitle);
                }
                $('#' + modalBodyID).html(xmlhttp.responseText);
                /*$('.modal-dialog').draggable();*/
                if (vtyp == 1)
                {
                    var table1 = $('#rolePrvldgsTable').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#rolePrvldgsTable').wrap('<div class="dataTables_scroll" />');

                    $('#rolePrvldgsForm').submit(function (e) {
                        e.preventDefault();
                        return false;
                    });
                }
                $(function () {
                    $('.form_date_tme').datetimepicker({
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
        xmlhttp.send("grp=3&typ=1&pg=" + pgNo + "&vtyp=" + vtyp + "&sbmtdRoleID=" + roleID + linkArgs);
    });
}


function saveRolesPrvldgsForm()
{
    var lnkArgs = "grp=3&typ=1&q=UPDATE&actyp=7";
    var slctdRolesPrvldgs = "";
    $('#rolePrvldgsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            var curPrvldgNm = typeof $('#rolePrvldgsEdtRow' + rndmNum + '_PrvldgNm').val() === 'undefined' ? '%' : $('#rolePrvldgsEdtRow' + rndmNum + '_PrvldgNm').val();

            if (curPrvldgNm === "" || curPrvldgNm === null)
            {
                /*$('#modal-7 .modal-body').html('Role Name cannot be empty!');
                 $('#modal-7').modal('show', {backdrop: 'static'});
                 return false;*/
            } else {
                slctdRolesPrvldgs = slctdRolesPrvldgs + $('#rolePrvldgsEdtRow' + rndmNum + '_PrvldgID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                        + curPrvldgNm.replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                        + $('#rolePrvldgsEdtRow' + rndmNum + '_StrtDte').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                        + $('#rolePrvldgsEdtRow' + rndmNum + '_EndDte').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
            }
        }
    });
    lnkArgs = lnkArgs + "&slctdRolesPrvldgs=" + slctdRolesPrvldgs.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}

function enterKeyFuncOneRole(e, elementID, modalBodyID, titleElementID, formElementID,
        formTitle, userID, vtyp, pgNo, actionText)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getOneRoleForm(elementID, modalBodyID, titleElementID, formElementID,
                formTitle, userID, vtyp, pgNo, actionText);
    }
}

function getAllMdls(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allMdlsSrchFor").val() === 'undefined' ? '%' : $("#allMdlsSrchFor").val();
    var srchIn = typeof $("#allMdlsSrchFor").val() === 'undefined' ? 'Both' : $("#allMdlsSrchFor").val();
    var pageNo = typeof $("#allMdlsPageNo").val() === 'undefined' ? 1 : $("#allMdlsPageNo").val();
    var limitSze = typeof $("#allMdlsDsplySze").val() === 'undefined' ? 10 : $("#allMdlsDsplySze").val();
    var sortBy = typeof $("#allMdlsSortBy").val() === 'undefined' ? '' : $("#allMdlsSortBy").val();
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

function enterKeyFuncAllMdls(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllMdls(actionText, slctr, linkArgs);
    }
}


function getOneMdlForm(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, mdlID, vtyp, pgNo, actionText)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");

        var srchFor = typeof $("#mdlPrvldgsSrchFor").val() === 'undefined' ? '%' : $("#mdlPrvldgsSrchFor").val();
        var srchIn = typeof $("#mdlPrvldgsSrchIn").val() === 'undefined' ? 'Both' : $("#mdlPrvldgsSrchIn").val();
        var pageNo = typeof $("#mdlPrvldgsPageNo").val() === 'undefined' ? 1 : $("#mdlPrvldgsPageNo").val();
        var limitSze = typeof $("#mdlPrvldgsDsplySze").val() === 'undefined' ? 10 : $("#mdlPrvldgsDsplySze").val();
        var sortBy = typeof $("#mdlPrvldgsSortBy").val() === 'undefined' ? '' : $("#mdlPrvldgsSortBy").val();
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
                if (formTitle != '')
                {
                    $('#' + titleElementID).html(formTitle);
                }
                $('#' + modalBodyID).html(xmlhttp.responseText);
                /*$('.modal-dialog').draggable();*/
                if (vtyp == 1)
                {
                    var table1 = $('#mdlPrvldgsTable').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#mdlPrvldgsTable').wrap('<div class="dataTables_scroll" />');

                    $('#mdlPrvldgsForm').submit(function (e) {
                        e.preventDefault();
                        return false;
                    });
                }

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
        xmlhttp.send("grp=3&typ=1&pg=" + pgNo + "&vtyp=" + vtyp + "&sbmtdMdlID=" + mdlID + linkArgs);
    });
}

function enterKeyFuncOneMdl(e, elementID, modalBodyID, titleElementID, formElementID,
        formTitle, userID, vtyp, pgNo, actionText)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getOneMdlForm(elementID, modalBodyID, titleElementID, formElementID,
                formTitle, userID, vtyp, pgNo, actionText);
    }
}

function getAllSbgrps(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allSbgrpsSrchFor").val() === 'undefined' ? '%' : $("#allSbgrpsSrchFor").val();
    var srchIn = typeof $("#allSbgrpsSrchFor").val() === 'undefined' ? 'Both' : $("#allSbgrpsSrchFor").val();
    var pageNo = typeof $("#allSbgrpsPageNo").val() === 'undefined' ? 1 : $("#allSbgrpsPageNo").val();
    var limitSze = typeof $("#allSbgrpsDsplySze").val() === 'undefined' ? 10 : $("#allSbgrpsDsplySze").val();
    var sortBy = typeof $("#allSbgrpsSortBy").val() === 'undefined' ? '' : $("#allSbgrpsSortBy").val();
    var sbmtdMdlID = typeof $("#allMdlsToSlct").val() === 'undefined' ? -1 : $("#allMdlsToSlct").val();
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
            "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&sortBy=" + sortBy + "&sbmtdMdlID=" + sbmtdMdlID;
    openATab(slctr, linkArgs);
}

function enterKeyFuncAllSbgrps(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllSbgrps(actionText, slctr, linkArgs);
    }
}

function getOneSbgrpForm(elementID, modalBodyID, titleElementID, formElementID,
        formTitle, tblID, vtyp, pgNo, actionText)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        $body.addClass("mdlloadingDiag");

        var srchFor = typeof $("#sbgrpsLblsSrchFor").val() === 'undefined' ? '%' : $("#sbgrpsLblsSrchFor").val();
        var srchIn = typeof $("#sbgrpsLblsSrchIn").val() === 'undefined' ? 'Both' : $("#sbgrpsLblsSrchIn").val();
        var pageNo = typeof $("#sbgrpsLblsPageNo").val() === 'undefined' ? 1 : $("#sbgrpsLblsPageNo").val();
        var limitSze = typeof $("#sbgrpsLblsDsplySze").val() === 'undefined' ? 10 : $("#sbgrpsLblsDsplySze").val();
        var sortBy = typeof $("#sbgrpsLblsSortBy").val() === 'undefined' ? '' : $("#sbgrpsLblsSortBy").val();
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
                if (formTitle != '')
                {
                    $('#' + titleElementID).html(formTitle);
                }
                $('#' + modalBodyID).html(xmlhttp.responseText);
                /*$('.modal-dialog').draggable();*/
                if (vtyp == 1)
                {
                    var table1 = $('#sbgrpsLblsTable').DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": false
                    });
                    $('#sbgrpsLblsTable').wrap('<div class="dataTables_scroll" />');

                    $('#sbgrpsLblsForm').submit(function (e) {
                        e.preventDefault();
                        return false;
                    });
                }

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
        xmlhttp.send("grp=3&typ=1&pg=" + pgNo + "&vtyp=" + vtyp + "&sbmtdTblID=" + tblID + linkArgs);
    });
}

function enterKeyFuncOneSbgrp(e, elementID, modalBodyID, titleElementID, formElementID,
        formTitle, tblID, vtyp, pgNo, actionText)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getOneSbgrpForm(elementID, modalBodyID, titleElementID, formElementID,
                formTitle, tblID, vtyp, pgNo, actionText);
    }
}

function getAllSecPlcys(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allSecPlcysSrchFor").val() === 'undefined' ? '%' : $("#allSecPlcysSrchFor").val();
    var srchIn = typeof $("#allSecPlcysSrchIn").val() === 'undefined' ? 'Both' : $("#allSecPlcysSrchIn").val();
    var pageNo = typeof $("#allSecPlcysPageNo").val() === 'undefined' ? 1 : $("#allSecPlcysPageNo").val();
    var limitSze = typeof $("#allSecPlcysDsplySze").val() === 'undefined' ? 10 : $("#allSecPlcysDsplySze").val();
    var sortBy = typeof $("#allSecPlcysSortBy").val() === 'undefined' ? '' : $("#allSecPlcysSortBy").val();
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

function enterKeyFuncAllSecPlcys(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllSecPlcys(actionText, slctr, linkArgs);
    }
}

function getOneSecPlcyForm(plcyID, vwtype)
{
    var lnkArgs = 'grp=3&typ=1&pg=5&vtyp=' + vwtype + '&sbmtdPlcyID=' + plcyID;
    doAjax(lnkArgs, 'secPlcsDetailInfo', 'PasteDirect', '', '', '');
}

function saveSecPlcyForm()
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
    var slctdAdtTbls = "";
    $('#secPlcyAdtTblsTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            slctdAdtTbls = slctdAdtTbls + $('#secPlcyAdtTblsRow' + rndmNum + '_EnblTrckng').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#secPlcyAdtTblsRow' + rndmNum + '_ActnsToTrck').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#secPlcyAdtTblsRow' + rndmNum + '_MdlID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#secPlcyAdtTblsRow' + rndmNum + '_DfltRwID').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdAdtTbls=" + slctdAdtTbls.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}

function getAllSrvrStngs(actionText, slctr, linkArgs)
{
    var srchFor = typeof $("#allSrvrStngsSrchFor").val() === 'undefined' ? '%' : $("#allSrvrStngsSrchFor").val();
    var srchIn = typeof $("#allSrvrStngsSrchIn").val() === 'undefined' ? 'Both' : $("#allSrvrStngsSrchIn").val();
    var pageNo = typeof $("#allSrvrStngsPageNo").val() === 'undefined' ? 1 : $("#allSrvrStngsPageNo").val();
    var limitSze = typeof $("#allSrvrStngsDsplySze").val() === 'undefined' ? 10 : $("#allSrvrStngsDsplySze").val();
    var sortBy = typeof $("#allSrvrStngsSortBy").val() === 'undefined' ? '' : $("#allSrvrStngsSortBy").val();
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

function enterKeyFuncAllSrvrStngs(e, actionText, slctr, linkArgs)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getAllSrvrStngs(actionText, slctr, linkArgs);
    }
}

function getOneSrvrStngForm(srvrID, vwtype)
{
    var lnkArgs = 'grp=3&typ=1&pg=6&vtyp=' + vwtype + '&sbmtdSrvrStngID=' + srvrID;
    doAjax(lnkArgs, 'srvrStngsDetailInfo', 'PasteDirect', '', '', '');
}

function saveSrvrStngForm()
{
    var lnkArgs = "";
    var srvrStnSmtpClnt = typeof $("#srvrStnSmtpClnt").val() === 'undefined' ? '' : $("#srvrStnSmtpClnt").val();
    var srvrStnSmtpClntID = typeof $("#srvrStnSmtpClntID").val() === 'undefined' ? -1 : $("#srvrStnSmtpClntID").val();
    var srvrStnIsDflt = typeof $("input[name='srvrStnIsDflt']:checked").val() === 'undefined' ? '' : $("input[name='srvrStnIsDflt']:checked").val();
    var srvrStnSndrsEmail = typeof $("#srvrStnSndrsEmail").val() === 'undefined' ? '' : $("#srvrStnSndrsEmail").val();
    var srvrStnSndrsPswd = typeof $("#srvrStnSndrsPswd").val() === 'undefined' ? '' : $("#srvrStnSndrsPswd").val();
    var srvrStnSmtPort = typeof $("#srvrStnSmtPort").val() === 'undefined' ? '' : $("#srvrStnSmtPort").val();
    var srvrStnDomainNm = typeof $("#srvrStnDomainNm").val() === 'undefined' ? '' : $("#srvrStnDomainNm").val();
    var srvrStnFTPUrl = typeof $("#srvrStnFTPUrl").val() === 'undefined' ? '' : $("#srvrStnFTPUrl").val();
    var srvrStnFTPUsrNm = typeof $("#srvrStnFTPUsrNm").val() === 'undefined' ? '' : $("#srvrStnFTPUsrNm").val();
    var srvrStnFTPPswd = typeof $("#srvrStnFTPPswd").val() === 'undefined' ? '' : $("#srvrStnFTPPswd").val();
    var srvrStnFTPPort = typeof $("#srvrStnFTPPort").val() === 'undefined' ? '' : $("#srvrStnFTPPort").val();
    var srvrStnFTPStrtDir = typeof $("#srvrStnFTPStrtDir").val() === 'undefined' ? '' : $("#srvrStnFTPStrtDir").val();
    var srvrStnFTPBaseDir = typeof $("#srvrStnFTPBaseDir").val() === 'undefined' ? '' : $("#srvrStnFTPBaseDir").val();
    var srvrStnEnforceFTP = typeof $("input[name='srvrStnEnforceFTP']:checked").val() === 'undefined' ? '' : $("input[name='srvrStnEnforceFTP']:checked").val();
    var srvrStnComPort = typeof $("#srvrStnComPort").val() === 'undefined' ? '' : $("#srvrStnComPort").val();
    var srvrStnBaudRate = typeof $("#srvrStnBaudRate").val() === 'undefined' ? '' : $("#srvrStnBaudRate").val();
    var srvrStnTimeout = typeof $("#srvrStnTimeout").val() === 'undefined' ? '' : $("#srvrStnTimeout").val();
    var srvrStnPGDumpDir = typeof $("#srvrStnPGDumpDir").val() === 'undefined' ? '' : $("#srvrStnPGDumpDir").val();
    var srvrStnBkpDir = typeof $("#srvrStnBkpDir").val() === 'undefined' ? '' : $("#srvrStnBkpDir").val();

    if (srvrStnSmtpClnt === "" || srvrStnSmtpClnt === null)
    {
        $('#modal-7 .modal-body').html('SMTP Client cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        return false;
    }
    if (srvrStnSndrsEmail === "" || srvrStnSndrsEmail === null)
    {
        $('#modal-7 .modal-body').html('Sender\'s Email cannot be empty!');
        $('#modal-7').modal('show', {backdrop: 'static'});
        return false;
    }
    lnkArgs = "grp=3&typ=1&q=UPDATE&actyp=11" +
            "&srvrStnSmtpClntID=" + srvrStnSmtpClntID +
            "&srvrStnSmtpClnt=" + srvrStnSmtpClnt +
            "&srvrStnIsDflt=" + srvrStnIsDflt +
            "&srvrStnSndrsEmail=" + srvrStnSndrsEmail +
            "&srvrStnSndrsPswd=" + srvrStnSndrsPswd +
            "&srvrStnSmtPort=" + srvrStnSmtPort +
            "&srvrStnDomainNm=" + srvrStnDomainNm +
            "&srvrStnFTPUrl=" + srvrStnFTPUrl +
            "&srvrStnFTPUsrNm=" + srvrStnFTPUsrNm +
            "&srvrStnFTPPswd=" + srvrStnFTPPswd +
            "&srvrStnFTPPort=" + srvrStnFTPPort +
            "&srvrStnFTPStrtDir=" + srvrStnFTPStrtDir +
            "&srvrStnFTPBaseDir=" + srvrStnFTPBaseDir +
            "&srvrStnEnforceFTP=" + srvrStnEnforceFTP +
            "&srvrStnComPort=" + srvrStnComPort +
            "&srvrStnBaudRate=" + srvrStnBaudRate +
            "&srvrStnTimeout=" + srvrStnTimeout +
            "&srvrStnPGDumpDir=" + srvrStnPGDumpDir;
    var slctdApiVals = "";
    $('#srvrStngSmsApiTable').find('tr').each(function (i, el) {
        if (i > 0)
        {
            var rndmNum = $(el).attr('id').split("_")[1];
            slctdApiVals = slctdApiVals + $('#srvrStngSmsApiRow' + rndmNum + '_Param').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "~"
                    + $('#srvrStngSmsApiRow' + rndmNum + '_Value').val().replace(/(~)+/g, "{-;-;}").replace(/(\|)+/g, "{:;:;}") + "|";
        }
    });
    lnkArgs = lnkArgs + "&slctdApiVals=" + slctdApiVals.slice(0, -1);
    doAjax(lnkArgs, 'myFormsModal', 'ShowDialog', 'System Alert!', 'myFormsModalTitle', 'myFormsModalBody');
}