function prepareInbox(lnkArgs, htBody, targ, rspns)
{    
    loadCss("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/css/dataTables.bootstrap.min.css", function () {
    });
    loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/jquery.dataTables.min.js", function () {
        loadScript("cmn_scrpts/bootstrap337/datatables/DataTables-1.10.11/js/dataTables.bootstrap.min.js", function () {
            $(targ).html(rspns);
            $(document).ready(function () {
                var table = $('#example').DataTable({
                    "scrollX": true
                });
                $('#example tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                    } else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
                $('#example tbody')
                        .on('mouseenter', 'tr', function () {
                            if ($(this).hasClass('highlight')) {
                                $(this).removeClass('highlight');
                            } else {
                                table.$('tr.highlight').removeClass('highlight');
                                $(this).addClass('highlight');
                            }
                        });
                $("#example td").eq(2).html(
                        "<button type=\"button\" class=\"btn btn-primary btn-sm\">" +
                        "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span></button>");
            });

                
                htBody.removeClass("mdlloading");
        });

    });
}