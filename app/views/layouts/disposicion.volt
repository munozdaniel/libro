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
                    <strong style="font-size: 32px;"> DISPOSICION</strong>
                </h3>
                <div class="box-tools pull-right">
                    {{ link_to('disposicion','<i class="fa fa-search"></i> Búscar Disposicion','class':'btn btn-default btn-flat') }}
                    {{ link_to('disposicion/new','<i class="fa fa-plus-square"></i> Agregar Disposicion','class':'btn btn-default btn-flat') }}
                    {{ link_to('disposicion/listarData','<i class="fa fa-list"></i> Listar Disposicion','class':'btn btn-default btn-flat') }}
                </div>
            </div>
            <div class="box-body">
                {{ content() }}
            </div>

        </div>
        <!-- /.box -->

    </section>
</div>