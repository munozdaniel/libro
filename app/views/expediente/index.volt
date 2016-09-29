<section>
    <div class="col-md-12  bg-gray">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#busquedaGeneral" data-toggle="tab">Búsqueda General</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="busquedaGeneral">
                    {{ form('expediente/search','method':'POST','class':'form-horizontal') }}
                    {{ content() }}
                    {{ flashSession.output() }}

                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Ingrese únicamente los campos necesario. No son obligatorios</div>
                    <div class="form-group">
                        <label for="nro_expediente_inicial" class="col-sm-2 control-label">Entre Números</label>

                        <div class="col-sm-4">
                            {{ text_field('nro_expediente_inicial','class': 'form-control','placeholder':'Nro de Expediente Inicial') }}
                        </div>
                        <div class="col-sm-4">
                            {{ text_field('nro_expediente_final','class': 'form-control','placeholder':'Nro de Expediente Final') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fecha_inicial" class="col-sm-2 control-label">Entre Fechas</label>
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
                        <label for="expte_cod_letra" class="col-sm-2 control-label"> Código</label>
                        <div class="col-sm-4">
                            <input type="text" id="expte_cod_letra" name="expte_cod_letra"  class="form-control only-text user-success" placeholder="Ingrese una Letra" maxlength="1"  >
                        </div>
                        <script>
                            $(".only-text").on('keyup', function(e) {
                                var val = $(this).val();
                                if (val.match(/[^a-zA-Z]/g)) {
                                    $(this).val(val.replace(/[^a-zA-Z]/g, ''));
                                }
                            });
                        </script>
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

                <div class="tab-pane" id="porSectorYFecha">
                    {{ form('expediente/searchEntreFechas','method':'POST','class':'form-horizontal') }}
                    <div class="form-group">
                        {{ form.label('sector_id_oid',['class': 'col-sm-2 control-label']) }}
                        <div class="col-sm-4">
                            {{ form.render('sector_id_oid',['class': 'form-control autocompletar','required':'true']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fechaDesde" class="col-sm-2 control-label">Desde</label>

                        <div class="col-sm-4">
                            {{ date_field('fecha_desde','class': 'form-control','required':'true') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fechaHasta" class="col-sm-2 control-label">Hasta</label>

                        <div class="col-sm-4">
                            {{ date_field('fecha_hasta','class': 'form-control ','required':'true') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger btn-flat">BUSCAR</button>
                        </div>
                    </div>
                    {{ end_form() }}
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="EntreFechas">
                    {{ form('expediente/searchEntreFechas','method':'POST','class':'form-horizontal') }}

                    <div class="form-group">
                        <label for="fechaDesde" class="col-sm-2 control-label">Desde</label>

                        <div class="col-sm-4">
                            {{ date_field('fecha_desde','class': 'form-control','required':'true') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fechaHasta" class="col-sm-2 control-label">Hasta</label>

                        <div class="col-sm-4">
                            {{ date_field('fecha_hasta','class': 'form-control ','required':'true') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger btn-flat">BUSCAR</button>
                        </div>
                    </div>
                    {{ end_form() }}
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="EntreNumeros">
                    {{ form('expediente/searchEntreNumeros','method':'POST','class':'form-horizontal') }}

                    <div class="form-group">
                        <label for="nroInicial" class="col-sm-2 control-label">Nro Inicial</label>

                        <div class="col-sm-4">
                            {{ text_field('nroInicial','class': 'form-control','placeholder':'Ingrese el Mínimo','required':'true') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nroFinal" class="col-sm-2 control-label">Nro Final</label>
                        <div class="col-sm-4">
                            {{ text_field('nroFinal','class': 'form-control','placeholder':'Ingrese el Máximo','required':'true') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger btn-flat">BUSCAR</button>
                        </div>
                    </div>
                    {{ end_form() }}
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->

</section>