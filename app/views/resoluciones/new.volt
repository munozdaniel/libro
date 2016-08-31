{{ form("resoluciones/create", "method":"post",'id':'nuevo','enctype':'multipart/form-data') }}
{{ content() }}
{{ flashSession.output() }}

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
    <div class="form-group">
        <label for="resoluciones_adjunto">Adjuntar Archivo</label>
        <input type="file"  id="resoluciones_adjunto" name="resoluciones_adjunto">
        <p class="help-block">Los archivos permitidos son: PDF - EXCEL - WORD.</p>
    </div>
</div>
{{ end_form() }}
<div class="col-md-5 col-md-offset-1">
    <!-- Horizontal Form -->
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Guardar Nueva Resolucion</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    {{ link_to('resoluciones/listar','<i class="fa fa-remove"></i> Cancelar','class':'btn btn-flat btn-block btn-social btn-tumblr') }}
                </div>
                <div class="form-group">
                    <button type="submit" form="nuevo" class="btn btn-flat btn-block btn-social btn-twitter">
                        <i class="fa fa-check"></i> Guardar Nota
                    </button>
                </div>

            </div>
        </form>
    </div>
    <!-- /.box -->
</div>

