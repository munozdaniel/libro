<style>
    .modal {
        position: relative;
        top: auto;
        bottom: auto;
        right: auto;
        left: auto;
        display: block;
        z-index: 1;
    }

     .modal {
        background: transparent !important;
    }
</style>
{{ form("nota/create", "method":"post",'id':'nuevo','enctype':'multipart/form-data') }}
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
        <label for="nota_adjunto">Adjuntar Archivo</label>
        <input type="file"  id="nota_adjunto" name="nota_adjunto">
        <p class="help-block">Los archivos permitidos son: PDF - EXCEL - WORD.</p>
    </div>
</div>
{{ end_form() }}
<div class="col-md-5 col-md-offset-1">
    <!-- Horizontal Form -->
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Guardar Nueva Nota</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    {{ link_to('nota/listar','<i class="fa fa-remove"></i> Cancelar','class':'btn btn-flat btn-block btn-social btn-tumblr') }}
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

