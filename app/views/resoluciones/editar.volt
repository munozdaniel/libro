{{ content() }}

{{ form('resoluciones/save','id':'editar','method':'POST','enctype':'multipart/form-data') }}
<div class="col-md-6">
    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group has-success">
                {{ element.label(['class': 'btn-block']) }}
                {{ element.render() }}
            </div>

        {% endif %}
    {% endfor %}
    <div class="form-group">
        <label for="nota_adjunto">Adjunto</label>
        {{ text_field('resoluciones_adjunto_prev','value':resoluciones.getResolucionesAdjunto(),'class':'form-control','readOnly':'','placeholder':'SIN ADJUNTO') }}
    </div>
    <div class="form-group text-red">
        <label for="resoluciones_adjunto">Reemplazar Adjunto</label>
        <input type="file"  id="resoluciones_adjunto" name="resoluciones_adjunto">
        <p class="help-block text-red"><i class="fa fa-warning"></i> Recuerde que los archivos adjuntos se reemplazarán definitivamente</p>
    </div>
</div>
{{ end_form() }}
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
                {{ submit_button('Guardar Cambios','class':' ','form':'editar') }}
                {{ link_to('resoluciones/listarData','<i class="fa fa-remove"></i> Cancelar Cambios','class':'pull-right') }}
            </div>
        </form>
    </div>
    <!-- /.box -->

</div>