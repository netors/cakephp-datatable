<?php if (!isset($model)) $model = Inflector::classify($this->params['controller']); ?>
<?php if (!isset($controller)) $controller = $this->params['controller']; ?>
<script type="text/javascript">
    // settings
    var dataTableSettings = [];
    dataTableSettings['<?php echo $model; ?>'] = {
        "bJQueryUI": true,
        "sScrollX": "",
        "bSortClasses": false,
        "aaSorting": [[0,"asc"]],
        "bAutoWidth": true,
        "bInfo": true,
        //"sScrollX": "101%",
        "bScrollCollapse": true,
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page"
        },
        "bRetrieve": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/admin/<?php echo $controller; ?>?model=<?php echo $model; ?>",
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "fnInitComplete": function () {
            //$('.dataTable').addClass('table table-striped table-bordered bootstrap-datatable');
        },
        "fnDrawCallback": function () {
            //updateActions();
        }
    };

    // init
    $(document).ready(function() {
        $('.dataTable').each(function() {
            var table = $(this);
            var model = table.attr('data-model');
            var settings = dataTableSettings[model];
            var datatable = table.dataTable(settings);
        });
    });
</script>