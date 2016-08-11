<style>
    .example-modal .modal {
        position: relative;
        top: auto;
        bottom: auto;
        right: auto;
        left: auto;
        display: block;
        z-index: 1;
    }

    .example-modal .modal {
        background: transparent !important;
    }
</style>
<section class="content">
     {{ content() }}
    <div class="example-modal">
        <div class="modal modal-danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar</h4>
                    </div>
                    <div class="modal-body">
                        <p>Está seguro de eliminar el documento? </p>
                        {{ form('nota/eliminarLogico','id':'eliminar','method':'POST') }}
                            {{ hidden_field('id_documento','value':id_documento) }}
                        {{ end_form() }}
                    </div>
                    <div class="modal-footer">
                        {{ link_to('nota/listar','Cerrar','class':'btn btn-outline pull-left') }}
                        {{ submit_button('Eliminar','class':'btn btn-outline','form':'eliminar') }}
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /.example-modal -->
</section>