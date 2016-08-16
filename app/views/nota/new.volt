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
<div class="col-md-4 col-md-offset-1" style="margin-top:2em;">
    <div class="modal modal-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">GUARDAR NUEVA NOTA</h4>
                </div>
                <div class="modal-body">
                    {{ link_to('nota/listar','<i class="fa fa-remove"></i> Cancelar ','class':'btn btn-outline ') }}
                    {{ submit_button('Guardar ','class':'btn btn-outline pull-right','form':'nuevo') }}

                </div>
            </div>
        <!-- /.modal-dialog -->
    </div>
</div>