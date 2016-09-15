<style>
  tr {
      background-color: #2a3e47;
      color: #FFF;
  }
    tr > td {
        color: #000;
    }
  .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
      border: 1px solid #d9d9d9;
  }
  table.dataTable thead .sorting {
      background-image: none;
  }
</style>
<table id="example" class="table-bordered display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th></th>
        <th>NRO</th>
        <th>FECHA</th>
        <th>ORIGEN</th>
        <th>DESCRIPCION</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th></th>
        <th>NRO</th>
        <th>FECHA</th>
        <th>ORIGEN</th>
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
                '<td><a class="btn btn-default" href="/libro/disposicion/ver/'+ d.id_documento+'" target="_blank"> <i class="fa fa-file"></i> Ver Detalles </a></td>'+
                '<td></td>'+
                '<td> <a class="btn btn-default" href="/libro/caratula/disposicion/'+ d.id_documento+'" target="_blank"> <i class="fa fa-file-o"></i> Caratula </a></td>'+
                '</table>';
    }
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            "language": {
                "url": "/libro/public/plugins/datatables/extensions/language/Spanish.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/libro/disposicion/listarDataAjax",
                "type": "POST"
            },
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "nro_disposicion",'searchable':true },
                { "data": "fecha",'searchable':true  },
                { "data": "origen",'searchable':true },
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
</script>