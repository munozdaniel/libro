<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        {{ getTitle() }}
        {{ stylesheet_link('bootstrap/css/bootstrap.min.css') }}
        {{ stylesheet_link('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',false) }}
        {{ stylesheet_link('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',false) }}
        {{ stylesheet_link('dist/css/AdminLTE.min.css') }}
        {{ stylesheet_link('dist/css/skins/skin-green.min.css') }}
        {{ javascript_include('plugins/jQuery/jquery-2.2.3.min.js') }}

        <!-- Main structure css file -->
        {% if (assets.collection("headerCss")) %}
            {{ assets.outputCss("headerCss") }}
        {% endif %}
        {% if (assets.collection("headerJs")) %}
            {{ assets.outputJs("headerJs") }}
        {% endif %}
        {% if (assets.collection("headerInlineJs")) %}
            {{ assets.outputInlineJs("headerInlineJs") }}
        {% endif %}
    </head>
    <body class="sidebar-mini skin-green layout-boxed">
        {{ content() }}
    </body>
    {{ javascript_include('bootstrap/js/bootstrap.min.js') }}
    {{ javascript_include('plugins/slimScroll/jquery.slimscroll.min.js') }}
    {{ javascript_include('plugins/fastclick/fastclick.js') }}
    {{ javascript_include('dist/js/app.min.js') }}
    {{ javascript_include('dist/js/demo.js') }}
    {% if (assets.collection("footerJs")) %}
        {{ assets.outputJs("footerJs") }}
    {% endif %}
    {% if (assets.collection("footerInlineJs")) %}
        {{ assets.outputInlineJs("footerInlineJs") }}
    {% endif %}
</html>
