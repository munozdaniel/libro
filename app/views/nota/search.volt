
{{ content() }}
{{ flashSession.output() }}

<table id="tabla" class="table table-bordered table-hover  table-striped" align="center">
    <thead>
        <tr style="background-color: #2a3e47; color: #FFF;">
            <th></th>
            <th>Nro</th>
            <th>Fecha</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Descripcion</th>

         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for nota in page.items %}
        <tr>
            <td>
                {% if nota.getHabilitado()==1 %}
                {{ link_to('nota/ver/'~nota.getIdDocumento(),'<i class="fa fa-file"></i> ','class':'btn btn-primary btn-flat') }}
                {% else %}
                    {{ link_to('nota/ver/'~nota.getIdDocumento(),'<i class="fa fa-file"></i> ','class':'btn btn-danger btn-flat') }}
                {% endif %}
            </td>
            <td>{{ nota.getNroNota() }}</td>
            <td>{{ date('d/m/Y',(nota.getFecha()) | strtotime) }}</td>
            <td>
                {% if nota.getSectores() != null %}
                {{ nota.getSectores().getSectorNombre() }}
                {% else %}
                    INCOMPLETO
                {% endif %}
            </td>
            <td>{{ nota.getDestino() }}</td>
            <td>{{ nota.getDescripcion() }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>

        <tr>
            <td colspan="12" align="right" style="background-color: #2a3e47; color: #FFF;">
                <table align="center">
                    <tr>
                        <td>{{ link_to("nota/search", " << " ,'class':'btn-primary btn btn-flat') }}</td>
                        <td>{{ link_to("nota/search?page="~page.before, " < ",'class':'btn-primary btn  btn-flat') }}</td>
                        <td><div class="btn-primary btn  btn-flat   ">{{ page.current~"/"~page.total_pages }}</div></td>
                        <td>{{ link_to("nota/search?page="~page.next, " > ",'class':'btn-primary btn  btn-flat') }}</td>
                        <td>{{ link_to("nota/search?page="~page.last, " >> ",'class':'btn-primary btn  btn-flat') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
