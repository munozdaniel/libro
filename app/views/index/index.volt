<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Libro </b>de Notas</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Iniciar Sesión</p>

            {{ form('sesion/ingresar','method':'POST') }}
            <div class="form-group has-feedback">
                {{ text_field('sesion_nombre',"class":"form-control","placeholder":"Usuario",'required':'',"autofocus":"") }}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {{ password_field('sesion_contrasena',"class":"form-control","placeholder":"Contraseña",'required':'') }}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4 pull-right">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                </div>
                <!-- /.col -->
            </div>
        {{ end_form() }}

        <div class="social-auth-links text-center">
            {{ link_to('sesion/recuperar','<i class="fa fa-envelope"></i>  Recuperar Contraseña','class':'btn btn-block btn-social btn-facebook btn-flat') }}
        </div>

    </div>
    <!-- /.login-box-body -->
</div>