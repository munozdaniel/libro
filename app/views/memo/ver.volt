{{ content() }}
{{ flashSession.output() }}
<div class="row">
    <div class="col-md-4">

        <div class="form-group">
            {{ form.label('nro_memo') }}
            {{ form.render('nro_memo') }}
        </div>
        <div class="form-group">
            {{ form.label('fecha') }}
            {{ form.render('fecha') }}
        </div>
        <div class="form-group">
            {{ form.label('creadopor',{'class':'btn-block'}) }}
            {{ form.render('creadopor') }}
        </div>
        <label for="memo_adjunto" class="btn-block"> Adjunto</label>

        <div class="input-group ">
            <div class="input-group-btn">
                {% if memo.getMemoAdjunto() != null %}
                    {{ link_to(memo.getMemoAdjunto(),'Abrir ','class':'btn btn-danger btn-flat','target':'_blank') }}
                {% else %}
                    <a class="btn btn-danger btn-flat" target="_blank"><i class="fa fa-remove"></i></a>
                {% endif %}
            </div>
            <!-- /btn-group -->
            {{ text_field('memo_adjunto','value':memo.getMemoAdjunto(),'class':'form-control','readOnly':'','placeholder':'SIN ADJUNTO') }}
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ form.label('sector_id_oid',{'class':'btn-block'}) }}
            {{ form.render('sector_id_oid') }}
        </div>
        <div class="form-group">
            {{ form.label('destinosector_id_oid',{'class':'btn-block'}) }}
            {{ form.render('destinosector_id_oid') }}
        </div>
        <div class="form-group">
            {% if form.getEntity().otrodestino != null %}
            {{ form.label('otrodestino',{'class':'btn-block'}) }}
            {{ form.render('otrodestino') }}
            {% endif %}
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
                        {{ link_to('caratula/memo/'~memo.getIdDocumento(),'<i class="fa fa-file"></i> Generar Caratula','class':'btn btn-flat btn-block btn-social btn-tumblr', 'target':'_blank') }}
                    </div>
                    {% if memo.getHabilitado()==1 %}
                        <div class="form-group">
                            {{ link_to('memo/editar/'~memo.getIdDocumento(),'<i class="fa fa-pencil"></i> Editar memo','class':'btn btn-flat btn-block btn-social btn-twitter') }}
                        </div>
                        <div class="form-group">
                            {{ link_to('memo/eliminar/'~memo.getIdDocumento(),'<i class="fa fa-remove"></i> Eliminar memo','class':'btn btn-block btn-flat btn-social btn-google') }}
                        </div>
                    {% else %}
                        <div class="form-group">
                            <a class="btn btn-flat btn-block btn-social btn-danger"><i class="fa fa-trash"></i> *** memo
                                ELIMINADO ***</a>
                        </div>
                    {% endif %}
                </div>
            </form>
        </div>
    </div>
</div>


