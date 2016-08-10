
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("nota/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("nota/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Id Of Documento</th>
            <th>Destino</th>
            <th>Nro Of Nota</th>
            <th>Adjunto</th>
            <th>Adjuntar</th>
            <th>Adjuntar Of 0</th>
            <th>Creadopor</th>
            <th>Descripcion</th>
            <th>Fecha</th>
            <th>Habilitado</th>
            <th>Sector Of Id Of Oid</th>
            <th>Tipo</th>
            <th>Ultimo</th>
            <th>Ultimodelanio</th>
            <th>Version</th>
            <th>Nro</th>
            <th>Nota Of UltimaModificacion</th>
            <th>Nota Of SectorOrigenId</th>
            <th>Nota Of Adjunto</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for nota in page.items %}
        <tr>
            <td>{{ nota.getIdDocumento() }}</td>
            <td>{{ nota.getDestino() }}</td>
            <td>{{ nota.getNroNota() }}</td>
            <td>{{ nota.getAdjunto() }}</td>
            <td>{{ nota.getAdjuntar() }}</td>
            <td>{{ nota.getAdjuntar0() }}</td>
            <td>{{ nota.getCreadopor() }}</td>
            <td>{{ nota.getDescripcion() }}</td>
            <td>{{ nota.getFecha() }}</td>
            <td>{{ nota.getHabilitado() }}</td>
            <td>{{ nota.getSectorIdOid() }}</td>
            <td>{{ nota.getTipo() }}</td>
            <td>{{ nota.getUltimo() }}</td>
            <td>{{ nota.getUltimodelanio() }}</td>
            <td>{{ nota.getVersion() }}</td>
            <td>{{ nota.getNro() }}</td>
            <td>{{ nota.getNotaUltimamodificacion() }}</td>
            <td>{{ nota.getNotaSectororigenid() }}</td>
            <td>{{ nota.getNotaAdjunto() }}</td>
            <td>{{ link_to("nota/edit/"~nota.getIdDocumento(), "Edit") }}</td>
            <td>{{ link_to("nota/delete/"~nota.getIdDocumento(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("nota/search", "First") }}</td>
                        <td>{{ link_to("nota/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("nota/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("nota/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
