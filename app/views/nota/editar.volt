{{ content() }}

{{ form('nota/save','id':'editar','method':'POST') }}
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
                {{ link_to('nota/editar/'~nota_id,'<i class="fa fa-remove"></i> Cancelar Cambios','class':'pull-right') }}
            </div>
        </form>
    </div>
    <!-- /.box -->

</div>