{{ form("memo/create", "method":"post",'id':'nuevo','enctype':'multipart/form-data') }}
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


</div>
<div class="col-md-4">
    <div class="form-group">
        {{ form.label('sector_id_oid',{'class':'btn-block'}) }}
        {{ form.render('sector_id_oid') }}
    </div>
    <div class="form-group">
        {{ form.label('destinosector_id_oid',{'class':'btn-block'}) }}
        {{ form.render('destinosector_id_oid') }}
        <script>
            function controlarOtroSector(seleccionado)
            {
                if(seleccionado.value==1)
                {
                    $("#otro").removeClass("ocultar");
                    $("#otrodestino").attr("required",'true');
                }else
                {
                    $("#otro").addClass("ocultar");
                    $("#otrodestino").removeAttr("required");
                }
            }
        </script>
    </div>
    <div id="otro" class="form-group ocultar" style="width: 100%">
        <label for="otrodestino" class="btn-block"><strong class="text-danger "> * </strong>Otro Destino</label>
        <input type="text" id="otrodestino" name="otrodestino" list="otrodestino-list" placeholder="Ingrese el nuevo sector" class="form-control">
        <datalist id="otrodestino-list"></datalist>
        <script>
            // Get the <datalist> and <input> elements.
            var dataList = document.getElementById('otrodestino-list');
            var input = document.getElementById('otrodestino');

            // Create a new XMLHttpRequest.
            var request = new XMLHttpRequest();

            // Handle state changes for the request.
            request.onreadystatechange = function(response) {
                if (request.readyState === 4) {
                    if (request.status === 200) {
                        // Parse the JSON
                        var jsonOptions = JSON.parse(request.responseText);

                        // Loop over the JSON array.
                        jsonOptions.forEach(function(item) {
                            console.log(item);
                            // Create a new <option> element.
                            var option = document.createElement('option');
                            // Set the value using the item in the JSON array.
                            option.value = item;
                            // Add the <option> element to the <datalist>.
                            dataList.appendChild(option);
                        });

                        // Update the placeholder text.
                        input.placeholder = "Ingrese el nuevo Sector";
                    } else {
                        // An error occured :(
                        input.placeholder = "Ingrese el nuevo Sector";
                    }
                }
            };

            // Update the placeholder text.
            input.placeholder = "Cargando...";

            // Set up and make the request.
            request.open('GET', '/libro/sectores/cargarSectoresAjax', true);
            request.send();
        </script>

    </div>
    <div class="form-group">
        {{ form.label('descripcion',{'class':'btn-block'}) }}
        {{ form.render('descripcion') }}
    </div>
    </div>
    <div class="col-md-4">

    <div class="form-group">
        <label for="memo_adjunto">Adjuntar Archivo</label>
        <input type="file"  id="memo_adjunto" name="nota_adjunto">
        <p class="help-block">PDF - EXCEL - WORD.</p>
    </div>

    <div class="form-group">
        {{ form.render('id_documento') }}
    </div>
</div>
</div>
<div class="row">
    <hr>
<div align="center">
    <button type="submit" form="nuevo" class="btn btn-flat btn-lg btn-social btn-twitter">
        <i class="fa fa-check"></i> GUARDAR MEMO
    </button>
</div>
</div>

{{ end_form() }}

