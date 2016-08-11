<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
</head>
<style>

</style>
<body>
{{ content() }}
<div align="center">
    {{ image('img/caratula/header.jpg','alt':'Header ') }}
</div>
<h2>
    <strong>Documento:</strong> NOTA ( Número: {% if nro_nota is defined %}  {{ nro_nota }} {% endif %})
</h2>

<h2>
    <strong>Fecha de Ingreso:</strong>{% if  fecha is defined %}  {{ fecha }}{% endif %}
</h2>

<h2>
    <strong>De:</strong> {% if origen is defined %}  {{ origen }} {% endif %}
</h2>

<h2>
    <strong>Motivo:</strong>{% if  descripcion is defined %} {{ descripcion }} {% endif %}
</h2>

<h2>
    <strong>Destino:</strong>{% if  destino is defined %} {{ destino }} {% endif %}
</h2>
<footer style="vertical-align: bottom; margin-top:40%; text-align: center">
    <p><em>Ante cualquier consulta, Ud. puede comunicarse al I.M.P.S. al teléfono <strong> 0299 4433978 int
                25.</strong></em></p>
</footer>
</body>
</html>