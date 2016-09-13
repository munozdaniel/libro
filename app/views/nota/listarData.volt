<style>

</style>
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th></th>
        <th>NRO</th>
        <th>FECHA</th>
        <th>ORIGEN</th>
        <th>DESTINO</th>
        <th>DESCRIPCION</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th></th>
        <th>NRO</th>
        <th>FECHA</th>
        <th>ORIGEN</th>
        <th>DESTINO</th>
        <th>DESCRIPCION</th>
    </tr>
    </tfoot>
</table>
<script>
    /* Formatting function for row details - modify as you need */
    function format ( d ) {
        // `d` is the original data object for the row
        var estado = "";//'<td><a class="btn btn-success"><i class="fa fa-check"></i> Habilitado </a></td>';
        if(d.habilitado!=1)
        {
            estado = '<td><a class="btn btn-danger"><i class="fa fa-remove"></i> Inhabilitado </a></td>';
        }

        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                 estado +
                '<td><a class="btn btn-default" href="/libro/nota/ver/'+ d.id_documento+'" target="_blank"> <i class="fa fa-file"></i> Ver Detalles </a></td>'+
                '<td></td>'+
                '<td> <a class="btn btn-default" href="/libro/caratula/nota/'+ d.id_documento+'" target="_blank"> <i class="fa fa-file-o"></i> Caratula </a></td>'+
                '</table>';
    }
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/libro/nota/listarDataAjax",
                "type": "POST"
            },
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "nro_nota" ,'searchable':true },
                { "data": "fecha",'searchable':true  },
                { "data": "sector_nombre",'searchable':true },
                { "data": "destino",'searchable':true  },
                { "data": "descripcion",'searchable':true  },
                { "data": "habilitado","visible": false,'searchable':false },
                { "data": "id_documento","visible": false,'searchable':false }
            ]
        } );
        // Add event listener for opening and closing details
        $('#example tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );

    } );
    /*
    $(document).ready(function() {
        $('#example').DataTable( {
            "ajax": "/libro/nota/listarDataAjax",
            "columns": [
                { "data": "name" ,"width": "10%"},
                { "data": "position" },
                { "data": "office" },
                { "data": "extn" },
                { "data": "start_date" },
                { "data": "salary" }
            ]
        } );
    } );*/
</script>