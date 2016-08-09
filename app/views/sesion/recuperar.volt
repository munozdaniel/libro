<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Libro </b>de Notas</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Recuperar Contraseña</p>
        <p class=" alert alert-warning"><i class="fa fa-warning"></i> Ingrese su email institucional para recibir el usuario y la contraseña</p>

        {{ form('sesion/enviarContrasena','method':'POST') }}
        <div class="form-group has-feedback">
            {{ text_field('sesion_email',"class":"form-control","placeholder":"Email",'required':'',"autofocus":"") }}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-4 pull-right">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Recuperar</button>
            </div>
            <!-- /.col -->
        </div>
        {{ end_form() }}

    </div>
    <!-- /.login-box-body -->
</div>