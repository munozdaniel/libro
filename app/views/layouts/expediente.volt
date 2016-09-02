<div class="content-wrapper">
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><button onclick="goBack()"><i class="fa fa-chevron-circle-left"></i></button>
                    <strong> EXPEDIENTE</strong>
                </h3>
                <div class="box-tools pull-right">
                    {{ link_to('expediente','<i class="fa fa-search"></i> Búscar Expediente','class':'btn btn-primary btn-flat') }}
                    {{ link_to('expediente/new','<i class="fa fa-plus-square"></i> Agregar Expediente','class':'btn btn-primary btn-flat') }}
                    {{ link_to('expediente/listar','<i class="fa fa-list"></i> Listar Expediente','class':'btn btn-primary btn-flat') }}
                </div>
            </div>
            <div class="box-body">
                {{ content() }}
            </div>

        </div>
        <!-- /.box -->

    </section>
</div>