
{{ content() }}

<div align="right">
    {{ link_to("nota/new", "Create nota") }}
</div>

{{ form("nota/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search nota</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="id_documento">Id Of Documento</label>
        </td>
        <td align="left">
            {{ text_field("id_documento", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="destino">Destino</label>
        </td>
        <td align="left">
            {{ text_field("destino", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="nro_nota">Nro Of Nota</label>
        </td>
        <td align="left">
            {{ text_field("nro_nota", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="adjunto">Adjunto</label>
        </td>
        <td align="left">
            {{ text_field("adjunto", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="adjuntar">Adjuntar</label>
        </td>
        <td align="left">
            {{ text_field("adjuntar", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="adjuntar_0">Adjuntar Of 0</label>
        </td>
        <td align="left">
            {{ text_field("adjuntar_0", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="creadopor">Creadopor</label>
        </td>
        <td align="left">
            {{ text_field("creadopor", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="descripcion">Descripcion</label>
        </td>
        <td align="left">
            {{ text_field("descripcion", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="fecha">Fecha</label>
        </td>
        <td align="left">
                {{ text_field("fecha", "type" : "date") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="habilitado">Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("habilitado", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="sector_id_oid">Sector Of Id Of Oid</label>
        </td>
        <td align="left">
            {{ text_field("sector_id_oid", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tipo">Tipo</label>
        </td>
        <td align="left">
            {{ text_field("tipo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="ultimo">Ultimo</label>
        </td>
        <td align="left">
            {{ text_field("ultimo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="ultimodelanio">Ultimodelanio</label>
        </td>
        <td align="left">
            {{ text_field("ultimodelanio", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="version">Version</label>
        </td>
        <td align="left">
            {{ text_field("version", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="nro">Nro</label>
        </td>
        <td align="left">
            {{ text_field("nro", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="nota_ultimaModificacion">Nota Of UltimaModificacion</label>
        </td>
        <td align="left">
            {{ text_field("nota_ultimaModificacion", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="nota_sectorOrigenId">Nota Of SectorOrigenId</label>
        </td>
        <td align="left">
            {{ text_field("nota_sectorOrigenId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="nota_adjunto">Nota Of Adjunto</label>
        </td>
        <td align="left">
            {{ text_field("nota_adjunto", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
