
function changeImgSrc(input, imgId, imgSrcLocID) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            //$('#img1Test')
            $(imgId).attr('src', e.target.result);
            $(imgSrcLocID).attr('value', $(input).val());
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function prepareProfile(lnkArgs, htBody, targ, rspns)
{
    if (lnkArgs.indexOf("&pg=1") !== -1)
    {
        prepareProfileRO(lnkArgs, htBody, targ, rspns);
    } else if (lnkArgs.indexOf("&pg=2") !== -1)
    {
        prepareProfileEDT(lnkArgs, htBody, targ, rspns);
    } else {
        $(targ).html(rspns);
        htBody.removeClass("mdlloading");
    }
}
function prepareProfileRO(lnkArgs, htBody, targ, rspns)
{

    //alert(targ+"<br/>"+rspns);
    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=0") !== -1)
        {
            var table1 = $('#nationalIDTblRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="tabajxprflro"]').click(function (e) {
                    var $this = $(this);
                    var targ = $this.attr('href');
                    var dttrgt = $this.attr('data-rhodata');
                    var linkArgs = 'grp=8&typ=1' + dttrgt;
                    //alert(linkArgs);
                    return openATab(targ, linkArgs);
                });
            });
        } else if (lnkArgs.indexOf("&vtyp=1") !== -1)
        {
            var table2 = $('.extPrsnDataTblRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
        } else if (lnkArgs.indexOf("&vtyp=2") !== -1)
        {
            var table2 = $('.orgAsgnmentsTblsRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
        } else if (lnkArgs.indexOf("&vtyp=3") !== -1)
        {
            var table2 = $('.cvTblsRO').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
        } else if (lnkArgs.indexOf("&vtyp=4") !== -1)
        {
            var table2 = $('.otherInfoTblsRO').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "bFilter": true,
                "scrollX": true
            });
        }
        htBody.removeClass("mdlloading");
    });
    /*loadCss("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/css/dataTables.bootstrap.min.css", function () {
     });
     loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/jquery.dataTables.min.js", function () {
     loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/dataTables.bootstrap.min.js", function () {
     });
     });*/
}


function prepareProfileEDT(lnkArgs, htBody, targ, rspns)
{


    $(targ).html(rspns);
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if (lnkArgs.indexOf("&vtyp=0") !== -1)
        {
            var table1 = $('#nationalIDTblEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": true
            });
            /*$('#nationalIDTblEDT').wrap('<div class="dataTables_scroll" />');*/
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
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
                $('[data-toggle="tabajxprfledt"]').click(function (e) {
                    var $this = $(this);
                    var targ = $this.attr('href');
                    var dttrgt = $this.attr('data-rhodata');
                    var linkArgs = 'grp=8&typ=1' + dttrgt;
                    //alert(linkArgs);
                    return openATab(targ, linkArgs);
                });
            });
        } else if (lnkArgs.indexOf("&vtyp=1") !== -1)
        {
            var table2 = $('.extPrsnDataTblEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('.extPrsnDataTblEDT').wrap('<div class="dataTables_scroll"/>');
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
        } else if (lnkArgs.indexOf("&vtyp=2") !== -1)
        {
            var table2 = $('.orgAsgnmentsTblsEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('.orgAsgnmentsTblsEDT').wrap('<div class="dataTables_scroll"/>');
        } 
        else if (lnkArgs.indexOf("&vtyp=3") !== -1)
        {
            var table2 = $('.cvTblsEDT').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false,
                "scrollX": false
            });
            $('.cvTblsEDT').wrap('<div class="dataTables_scroll"/>');
        } 
        else if (lnkArgs.indexOf("&vtyp=4") !== -1)
        {
            var table2 = $('.otherInfoTblsEDT').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "bFilter": true,
                "scrollX": false
            });
            $('.otherInfoTblsEDT').wrap('<div class="dataTables_scroll"/>');
        }
        htBody.removeClass("mdlloading");
    });

    /*loadCss("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/css/dataTables.bootstrap.min.css", function () {
     });
     loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/jquery.dataTables.min.js", function () {
     loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/dataTables.bootstrap.min.js", function () {});
     });*/
}

function getNtnlIDForm(elementID, modalBodyID, titleElementID, formElementID, tRowElementID, formTitle, vtyp, addOrEdit, pKeyID)
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
            /*$('.modal-content').resizable({
             //alsoResize: ".modal-dialog",
             minHeight: 600,
             minWidth: 300
             });*/
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
                $('#ntnlIDCardsCountry').val($.trim($tds.eq(1).text()));
                $('#ntnlIDCardsIDTyp').val($.trim($tds.eq(2).text()));
                $('#ntnlIDCardsIDNo').val($.trim($tds.eq(3).text()));
                $('#ntnlIDCardsDateIssd').val($.trim($tds.eq(4).text()));
                $('#ntnlIDCardsExpDate').val($.trim($tds.eq(5).text()));
                $('#ntnlIDCardsOtherInfo').val($.trim($tds.eq(6).text()));
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
    xmlhttp.send("grp=8&typ=1&pg=2&vtyp=" + vtyp + "&ntnlIDpKey=" + pKeyID);
}

function saveNtnlIDForm(elementID, ntnlIDPersonID)
{
    $body = $("body");
    $body.addClass("mdlloadingDiag");
    var nicCountry = typeof $("#ntnlIDCardsCountry").val() === 'undefined' ? '%' : $("#ntnlIDCardsCountry").val();
    var nicIDType = typeof $("#ntnlIDCardsIDTyp").val() === 'undefined' ? 'Both' : $("#ntnlIDCardsIDTyp").val();
    var nicIDNo = typeof $("#ntnlIDCardsIDNo").val() === 'undefined' ? 1 : $("#ntnlIDCardsIDNo").val();
    var nicDateIssd = typeof $("#ntnlIDCardsDateIssd").val() === 'undefined' ? 10 : $("#ntnlIDCardsDateIssd").val();
    var nicExpDate = typeof $("#ntnlIDCardsExpDate").val() === 'undefined' ? 1 : $("#ntnlIDCardsExpDate").val();
    var nicOtherInfo = typeof $("#ntnlIDCardsOtherInfo").val() === 'undefined' ? 10 : $("#ntnlIDCardsOtherInfo").val();
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
            $('#nationalIDTblEDT').append('<tr><td></td><td colspan="6">' + xmlhttp.responseText + '</td></tr>');
            $body.removeClass("mdlloadingDiag");
            $('#' + elementID).modal('hide');
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("grp=8&typ=1&pg=2&q=UPDATE&actyp=2" +
            "&ntnlIDCardsCountry=" + nicCountry +
            "&ntnlIDCardsIDTyp=" + nicIDType +
            "&ntnlIDCardsIDNo=" + nicIDNo +
            "&ntnlIDCardsDateIssd=" + nicDateIssd +
            "&ntnlIDCardsExpDate=" + nicExpDate +
            "&ntnlIDCardsOtherInfo=" + nicOtherInfo +
            "&ntnlIDPersonID=" + ntnlIDPersonID);
}