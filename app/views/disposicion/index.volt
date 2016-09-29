<section>
    <div class="col-md-12  bg-gray">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#busquedaGeneral" data-toggle="tab">Búsqueda General</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="busquedaGeneral">
                    {{ form('disposicion/search','method':'POST','class':'form-horizontal') }}
                    {{ content() }}
                    {{ flashSession.output() }}

                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Ingrese únicamente los campos necesario. No son obligatorios</div>
                    <div class="form-group">
                        <label for="nro_disposicion_inicial" class="col-sm-2 control-label">Nro Disposicion</label>

                        <div class="col-sm-4">
                            {{ text_field('nro_disposicion_inicial','class': 'form-control','placeholder':'Nro de Disposicion Inicial') }}
                        </div>
                        <div class="col-sm-4">
                            {{ text_field('nro_disposicion_final','class': 'form-control','placeholder':'Nro de Disposicion Final') }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ form.label('fecha',['class': 'col-sm-2 control-label']) }}
                        <div class="col-sm-4">
                            {{ date_field('fecha_inicial','class': 'form-control ') }}
                        </div>
                        <div class="col-sm-4">
                            {{ date_field('fecha_final','class': 'form-control ') }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ form.label('sector_id_oid',['class': 'col-sm-2 control-label']) }}
                        <div class="col-sm-4">
                            {{ form.render('sector_id_oid',['class': 'form-control autocompletar']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ form.label('descripcion',['class': 'col-sm-2 control-label']) }}
                        <div class="col-sm-4">
                            {{ form.render('descripcion',['class': 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ form.label('creadopor',['class': 'col-sm-2 control-label']) }}
                        <div class="col-sm-4">
                            {{ text_field('creadopor','class': 'form-control','placeholder':'Ingrese el usuario') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger btn-flat">BUSCAR</button>
                        </div>
                    </div>
                    {{ end_form() }}

                </div>

            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->

</section>