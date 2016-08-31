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

                    RESOLUCIONES</h3>
                <div class="box-tools pull-right">
                    {{ link_to('resoluciones','<i class="fa fa-search"></i> Búscar RESOLUCIÓN','class':'btn btn-primary btn-flat') }}
                    {{ link_to('resoluciones/new','<i class="fa fa-plus-square"></i> Agregar RESOLUCIÓN','class':'btn btn-primary btn-flat') }}
                    {{ link_to('resoluciones/listar','<i class="fa fa-list"></i> Listar RESOLUCIÓN','class':'btn btn-primary btn-flat') }}
                </div>
            </div>
            <div class="box-body">
                {{ content() }}
            </div>

        </div>
        <!-- /.box -->

    </section>
</div>