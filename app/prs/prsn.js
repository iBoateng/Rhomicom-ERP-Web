
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

function prepareProfileRO(lnkArgs, htBody, targ, rspns)
{
    loadCss("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/css/dataTables.bootstrap.min.css", function () {
    });
    loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/jquery.dataTables.min.js", function () {
        loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/dataTables.bootstrap.min.js", function () {
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
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "bFilter": false,
                        "scrollX": true
                    });
                }
                htBody.removeClass("mdlloading");
            });
        });
    });
}