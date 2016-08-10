<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">NOTAS</h3>
                <div class="box-tools pull-right">
                    {{ link_to('nota','<i class="fa fa-search"></i> Búscar Nota','class':'btn btn-primary') }}
                    {{ link_to('nota/new','<i class="fa fa-plus-square"></i> Agregar Nota','class':'btn btn-primary') }}
                </div>
            </div>
            <div class="box-body">
                {{ content() }}
            </div>

        </div>
        <!-- /.box -->

    </section>
</div>