<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
</head>
<style>

</style>
<body style="border: 4px solid #000000;">
{{ content() }}
<div align="center">
    {{ image('img/caratula/header.jpg','alt':'Header ') }}
</div>
<p style="font-size: 18px; margin: 80px 0 20px 60px;">
    Documento: <strong>NOTA ( Número: {% if nro is defined %}  {{ nro }} {% endif %})</strong>
</p>

<p style="font-size: 18px; margin: 80px 0 20px 60px;">
    Fecha de Ingreso:<strong>{% if  fecha is defined %}  {{ fecha }}{% endif %}</strong>
</p>

<p style="font-size: 18px; margin: 40px 0 20px 60px;">
    De:<strong> {% if origen is defined %}  {{ origen }} {% endif %}</strong>
</p>

<p style="font-size: 18px; margin: 40px 0 20px 60px;">
    Motivo:<strong>{% if  descripcion is defined %} {{ descripcion }} {% endif %}</strong>
</p>

<p style="font-size: 18px; margin: 40px 0 20px 60px;">
    Destino:<strong> {% if destino is defined %}  {{ destino }} {% endif %}</strong>
</p>
<footer style="vertical-align: bottom; bottom: 40px; position: absolute; right: 20px;">
    <p><em>Instituto Municipal de Previsión Social</em></p>

    <p><em>Bouquet Roldán 355 - Neuquén Capital</em></p>
</footer>
</body>
</html>