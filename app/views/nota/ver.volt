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
                    {{ link_to('caratula/nota/'~nota_id,'<i class="fa fa-file"></i> Generar Caratula','class':'btn btn-block btn-social btn-tumblr', 'target':'_blank') }}
                </div>
                <div class="form-group">
                    {{ link_to('nota/editar/'~nota_id,'<i class="fa fa-pencil"></i> Editar Nota','class':'btn btn-block btn-social btn-twitter') }}
                </div>
                <div class="form-group">
                    {{ link_to('nota/eliminar/'~nota_id,'<i class="fa fa-remove"></i> Eliminar Nota','class':'btn btn-block btn-social btn-google') }}
                </div>
            </div>
        </form>
    </div>
    <!-- /.box -->

</div>