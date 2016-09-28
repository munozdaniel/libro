{{ content() }}
{{ flashSession.output() }}
<div class="row">
    <div class="col-md-4">

        <div class="form-group">
            {{ form.label('nro_resolucion') }}
            {{ form.render('nro_resolucion') }}
        </div>
        <div class="form-group">
            {{ form.label('fecha') }}
            {{ form.render('fecha') }}
        </div>
        <div class="form-group">
            {{ form.label('creadopor',{'class':'btn-block'}) }}
            {{ form.render('creadopor') }}
        </div>
        <label for="resolucion_adjunto" class="btn-block"> Adjunto</label>

        <div class="input-group ">
            <div class="input-group-btn">
                {% if resolucion.getResolucionesAdjunto() != null %}
                    {{ link_to(resolucion.getResolucionesAdjunto(),'Abrir ','class':'btn btn-danger btn-flat','target':'_blank') }}
                {% else %}
                    <a class="btn btn-danger btn-flat" target="_blank"><i class="fa fa-remove"></i></a>
                {% endif %}
            </div>
            <!-- /btn-group -->
            {{ text_field('resolucion_adjunto','value':resolucion.getResolucionesAdjunto(),'class':'form-control','readOnly':'','placeholder':'SIN ADJUNTO') }}
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ form.label('sector_id_oid',{'class':'btn-block'}) }}
            {{ form.render('sector_id_oid') }}
        </div>
        <div class="form-group">
            {{ form.label('descripcion',{'class':'btn-block'}) }}
            {{ form.render('descripcion') }}
        </div>
        <div class="form-group">
            {{ form.render('id_documento') }}
        </div>
    </div>
    <div class="col-md-4" style="margin-top: 20px;">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Operaciones</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        {{ link_to('caratula/resoluciones/'~resolucion.getIdDocumento(),'<i class="fa fa-file"></i> Generar Caratula','class':'btn btn-flat btn-block btn-social btn-tumblr', 'target':'_blank') }}
                    </div>
                    {% if resolucion.getHabilitado()==1 %}
                        <div class="form-group">
                            {{ link_to('resoluciones/editar/'~resolucion.getIdDocumento(),'<i class="fa fa-pencil"></i> Editar resolucion','class':'btn btn-flat btn-block btn-social btn-twitter') }}
                        </div>
                        <div class="form-group">
                            {{ link_to('resoluciones/eliminar/'~resolucion.getIdDocumento(),'<i class="fa fa-remove"></i> Eliminar resolucion','class':'btn btn-block btn-flat btn-social btn-google') }}
                        </div>
                    {% else %}
                        <div class="form-group">
                            <a class="btn btn-flat btn-block btn-social btn-danger"><i class="fa fa-trash"></i> *** resolucion
                                ELIMINADO ***</a>
                        </div>
                    {% endif %}
                </div>
            </form>
        </div>
    </div>
</div>


