{{ content() }}

<div class="col-md-6">
    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {{ element.label(['class': 'btn-block']) }}
                {{ element.render() }}
            </div>
        {% endif %}
    {% endfor %}
    <label for="nota_adjunto" class="btn-block"> Adjunto</label>

    <div class="input-group ">
        <div class="input-group-btn">
            {% if nota.getNotaAdjunto() != null %}
                {{ link_to(nota.getNotaAdjunto(),'Abrir ','class':'btn btn-danger btn-flat','target':'_blank') }}
            {% else %}
                <a class="btn btn-danger btn-flat" target="_blank"><i class="fa fa-remove"></i></a>
            {% endif %}
        </div>
        <!-- /btn-group -->
        {{ text_field('nota_adjunto','value':nota.getNotaAdjunto(),'class':'form-control','readOnly':'','placeholder':'SIN ADJUNTO') }}
    </div>


</div>

<div class="col-md-5 col-md-offset-1">
    <!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Operaciones</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    {{ link_to('caratula/nota/'~nota.getIdDocumento(),'<i class="fa fa-file"></i> Generar Caratula','class':'btn btn-flat btn-block btn-social btn-tumblr', 'target':'_blank') }}
                </div>
                {% if nota.getHabilitado()==1 %}
                    <div class="form-group">
                        {{ link_to('nota/editar/'~nota.getIdDocumento(),'<i class="fa fa-pencil"></i> Editar Nota','class':'btn btn-flat btn-block btn-social btn-twitter') }}
                    </div>
                    <div class="form-group">
                        {{ link_to('nota/eliminar/'~nota.getIdDocumento(),'<i class="fa fa-remove"></i> Eliminar Nota','class':'btn btn-block btn-flat btn-social btn-google') }}
                    </div>
                {% else %}
                    <div class="form-group">
                        <a class="btn btn-flat btn-block btn-social btn-danger"><i class="fa fa-trash"></i> *** NOTA
                            ELIMINADA ***</a>
                    </div>
                {% endif %}
            </div>
        </form>
    </div>
    <!-- /.box -->
</div>