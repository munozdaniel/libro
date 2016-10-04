{{ content() }}
{{ form("detallesector/save", "method":"post") }}


<div align="center">
    <h1>Editar Sector</h1>
</div>
<div  align="center">

<table width="50%">
    <tr>
        <td align="right">
            <label for="detalleSector_sectorId">Sector</label>
        </td>
        <td align="left" >
            {{ text_field("detalleSector_sectorId", 'class':'form-control','readOnly':'true') }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="detalleSector_expediente">Expediente</label>
        </td>
        <td align="left">
            {{ numeric_field("detalleSector_expediente",'class':'form-control' , 'min':0, 'max':1) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="detalleSector_resolucion">Resolucion</label>
        </td>
        <td align="left">
            {{ numeric_field("detalleSector_resolucion",'class':'form-control', 'min':0, 'max':1) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="detalleSector_disposicion">Disposicion</label>
        </td>
        <td align="left">
            {{ numeric_field("detalleSector_disposicion",  'class':'form-control', 'min':0, 'max':1) }}
        </td>
    </tr>



    <tr>
        <td>{{ hidden_field("detalleSector_id") }}</td>
        <td>{{ submit_button("Guardar Cambios",'class':"btn btn-primary btn-flat ") }}</td>
    </tr>
</table>

</form>
</div>