
{{ content() }}
{{ flashSession.output() }}

<table id="tabla" class="table table-bordered table-hover" align="center">
    <thead>
    <tr style="background-color: #2a3e47; color: #FFF;">
        <th><i class="fa fa-pencil"></i> </th>
        <th>Nombre</th>
        <th>Resolucion</th>
        <th>Disposicion</th>
        <th>Expediente</th>
    </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
        {% for sector in page.items %}
            <tr>
                <td>{{ link_to('detallesector/edit/'~sector.getDetallesectorId(),'Editar') }}</td>
                <td>{{ sector.getSectores().getSectorNombre() }}</td>
                <td>{{ sector.getDetallesectorResolucion() }}</td>
                <td>{{ sector.getDetallesectorDisposicion() }}</td>
                <td>{{ sector.getDetallesectorExpediente() }}</td>
            </tr>
        {% endfor %}
    {% endif %}
    </tbody>
    <tbody>

    <tr>
        <td colspan="12" align="right" style="background-color: #2a3e47; color: #FFF;">
            <table align="center">
                <tr>
                    <td>{{ link_to("sector/search", " << " ,'class':'btn-primary btn btn-flat') }}</td>
                    <td>{{ link_to("sector/search?page="~page.before, " < ",'class':'btn-primary btn  btn-flat') }}</td>
                    <td><div class="btn-primary btn  btn-flat   ">{{ page.current~"/"~page.total_pages }}</div></td>
                    <td>{{ link_to("sector/search?page="~page.next, " > ",'class':'btn-primary btn  btn-flat') }}</td>
                    <td>{{ link_to("sector/search?page="~page.last, " >> ",'class':'btn-primary btn  btn-flat') }}</td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
