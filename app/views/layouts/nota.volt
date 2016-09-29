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

                   <strong style="    font-size: 32px;">NOTAS</strong></h3>
                <div class="box-tools pull-right">
                    {{ link_to('nota','<i class="fa fa-search"></i> Búscar Nota','class':'btn btn-default btn-flat') }}
                    {{ link_to('nota/new','<i class="fa fa-plus-square"></i> Agregar Nota','class':'btn btn-default btn-flat') }}
                    {{ link_to('nota/listarData','<i class="fa fa-list"></i> Listar Notas','class':'btn btn-default btn-flat') }}
                </div>
            </div>
            <div class="box-body">
                {{ content() }}
            </div>

        </div>
        <!-- /.box -->

    </section>
</div>