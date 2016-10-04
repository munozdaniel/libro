<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Libro </b>de Notas</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Recuperar Contraseña</p>
        {{ content() }}
        <p class=" alert alert-warning"><i class="fa fa-warning"></i> Ingrese su email institucional para recibir el usuario y la contraseña</p>

        {{ form('sesion/enviarContrasena','method':'POST') }}
        <div class="form-group has-feedback">
            {{ text_field('sesion_email',"class":"form-control","placeholder":"Email",'required':'',"autofocus":"") }}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-4 pull-left">
                {{ link_to('index','class':'btn btn-default btn-block btn-flat pull-left','<i class="fa fa-home"></i> Volver') }}
            </div>
            <div class="col-xs-4 pull-right">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Recuperar</button>
            </div>
        </div>
        {{ end_form() }}

    </div>
    <!-- /.login-box-body -->
</div>