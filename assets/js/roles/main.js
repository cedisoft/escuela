$(document).ready(function() {
    $(document).ready(function() {
        $('#paginado_roles').dataTable({
            "sAjaxSource": $("#paginado").attr("source"),
            "aoColumns": [
                {
                    "bSortable": true
                },
                {
                    "bSortable": false,
                    "bSearchable": false
                }
            ]
        });
    });
});

