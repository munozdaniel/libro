<section>
    <div class="col-md-12  bg-gray">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#busquedaGeneral" data-toggle="tab">Búsqueda </a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="busquedaGeneral">
                    {{ form('nota/search','method':'POST','class':'form-horizontal') }}
                    {{ content() }}
                    {{ flashSession.output() }}

                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Ingrese únicamente los campos
                        necesario. No son obligatorios
                    </div>
                    <div class="form-group">
                        <label for="nro_nota" class="col-sm-2 control-label">Entre Nros</label>

                        <div class="col-sm-4">
                            {{ text_field('nro_nota_inicial','class': 'form-control','placeholder':'Nro de Nota Inicial') }}
                        </div>
                        <div class="col-sm-4">
                            {{ text_field('nro_nota_final','class': 'form-control','placeholder':'Nro de Nota Final') }}
                            <script>
                                $('#nro_nota_final').on('input', function () {
                                    // Si se ingresa el numero de nota final entonces es obligatorio que se ingrese el numero de nota inicial
                                    if ($(this).val()) {
                                        $("#nro_nota_inicial").prop('required', true);
                                    }
                                    else {
                                        $("#nro_nota_inicial").prop('required', false);
                                    }
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fecha" class="col-sm-2 control-label">Entre Fechas</label>
                        <div class="col-sm-4">
                            {{ date_field('fecha_inicial','class': 'form-control ') }}
                            <script>
                                $('#fecha').prop("readOnly", false); // Quitamos el solo lectura.
                            </script>
                        </div>
                        <div class="col-sm-4">
                            {{ date_field('fecha_final','class': 'form-control ') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nota_sectorOrigenId" class="col-sm-2 control-label">Entre Sectores</label>
                        <div class="col-sm-4">
                            {{ form.render('nota_sectorOrigenId',['class': 'form-control autocompletar']) }}
                        </div>
                        <div class="col-sm-4">
                            {{ form.render('destino',['class': 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ form.label('descripcion',['class': 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
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
