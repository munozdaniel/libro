
{{ content() }}
{{ flashSession.output() }}

<table id="tabla" class="table table-bordered table-hover" align="center">
    <thead>
        <tr style="background-color: #2a3e47; color: #FFF;">
            <th>Controlador</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
        {% for acceso in page.items %}
            <tr>

                <td>{{ acceso.getPagina().getPaginaNombrecontrolador() }}</td>
                <td>{{ acceso.getPagina().getPaginaNombreaccion()}}</td>
            </tr>
        {% endfor %}
    {% endif %}
    </tbody>
    <tbody>

    <tr>
        <td colspan="12" align="right" style="background-color: #2a3e47; color: #FFF;">
            <table align="center">
                <tr>
                    <td>{{ link_to("rol/search", " << " ,'class':'btn-primary btn btn-flat') }}</td>
                    <td>{{ link_to("rol/search?page="~page.before, " < ",'class':'btn-primary btn  btn-flat') }}</td>
                    <td><div class="btn-primary btn  btn-flat   ">{{ page.current~"/"~page.total_pages }}</div></td>
                    <td>{{ link_to("rol/search?page="~page.next, " > ",'class':'btn-primary btn  btn-flat') }}</td>
                    <td>{{ link_to("rol/search?page="~page.last, " >> ",'class':'btn-primary btn  btn-flat') }}</td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
