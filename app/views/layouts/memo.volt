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
                    <strong style="    font-size: 32px;"> MEMO</strong>
                </h3>
                <div class="box-tools pull-right">
                    {{ link_to('memo','<i class="fa fa-search"></i> Búscar MEMO','class':'btn btn-default btn-flat') }}
                    {{ link_to('memo/new','<i class="fa fa-plus-square"></i> Agregar MEMO','class':'btn btn-default btn-flat') }}
                    {{ link_to('memo/listarData','<i class="fa fa-list"></i> Listar MEMO','class':'btn btn-default btn-flat') }}
                </div>
            </div>
            <div class="box-body">
                {{ content() }}
            </div>

        </div>
        <!-- /.box -->

    </section>
</div>