
{{ content() }}
{{ flashSession.output() }}

<table id="tabla" class="table table-bordered table-hover  table-striped" align="center">
    <thead>
    <tr style="background-color: #2a3e47; color: #FFF;">
        <th></th>
        <th>Nro</th>
        <th>Fecha</th>
        <th>Origen</th>
        <th>Descripcion</th>

    </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
        {% for documento in page.items %}
            <tr>
                <td>
                    {% if documento.getHabilitado()==1 %}
                        {{ link_to('disposicion/ver/'~documento.getIdDocumento(),'<i class="fa fa-file"></i> ','class':'btn btn-primary btn-flat','style':'border-width: 4px;') }}
                    {% else %}
                        {{ link_to('disposicion/ver/'~documento.getIdDocumento(),'<i class="fa fa-file"></i> ','class':'btn btn-danger btn-flat','style':'border-width: 4px;') }}
                    {% endif %}
                </td>
                <td>{{ documento.getNroDisposicion() }}</td>
                <td>{{ date('d/m/Y',(documento.getFecha()) | strtotime) }}</td>
                <td>
                    {% if documento.getSectores() != null %}
                        {{ documento.getSectores().getSectorNombre() }}
                    {% else %}
                        INCOMPLETO
                    {% endif %}
                </td>
                <td>{{ documento.getDescripcion() }}</td>
            </tr>
        {% endfor %}
    {% endif %}
    </tbody>
    <tbody>

    <tr>
        <td colspan="12" align="right" style="background-color: #2a3e47; color: #FFF;">
            <table align="center">
                <tr>
                    <td>{{ link_to("disposicion/search", " << " ,'class':'btn-primary btn btn-flat') }}</td>
                    <td>{{ link_to("disposicion/search?page="~page.before, " < ",'class':'btn-primary btn  btn-flat') }}</td>
                    <td><div class="btn-primary btn  btn-flat   ">{{ page.current~"/"~page.total_pages }}</div></td>
                    <td>{{ link_to("disposicion/search?page="~page.next, " > ",'class':'btn-primary btn  btn-flat') }}</td>
                    <td>{{ link_to("disposicion/search?page="~page.last, " >> ",'class':'btn-primary btn  btn-flat') }}</td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
