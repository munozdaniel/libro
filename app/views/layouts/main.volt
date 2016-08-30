<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>L</b>N</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Libro</b> de Notas</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ image('img/entorno/user.jpeg','alt':'usuario','class':'user-image') }}
                            <span class="hidden-xs">{{ session.get('auth')['usuario_nombreCompleto'] }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                {{ image('img/entorno/user.jpeg','alt':'usuario','class':'img-circle') }}
                                <p>
                                    {{ session.get('auth')['usuario_nombreCompleto'] }}
                                    <small>{{ session.get('auth')['rol_nombre'] }}</small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Salir</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    {# Acceso para los administradores#}
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                    {# Fin: Acceso para los administradores#}
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    {{ image('img/entorno/user.jpeg','alt':'usuario','class':'img-circle') }}
                </div>
                <div class="pull-left info">
                    <p> {{ session.get('auth')['usuario_nick'] }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online </a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MENÚ PRINCIPAL</li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-folder-o text-red"></i> <span>NOTAS</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('nota/listar','<i class="fa fa-circle-o "></i> <span>Listado</span>') }}</li>
                        <li>{{ link_to('nota/new','<i class="fa fa-circle-o "></i> <span>Nuevo</span>') }}</li>
                        <li>{{ link_to('nota/index','<i class="fa fa-circle-o "></i> <span>Buscar</span>') }}</li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-folder-o text-yellow"></i> <span>MEMO</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('memo/listar','<i class="fa fa-circle-o "></i> <span>Listado</span>') }}</li>
                        <li>{{ link_to('memo/new','<i class="fa fa-circle-o "></i> <span>Nuevo</span>') }}</li>
                        <li>{{ link_to('memo/index','<i class="fa fa-circle-o "></i> <span>Buscar</span>') }}</li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-folder-o text-blue"></i> <span>RESOLUCIONES</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('resoluciones/listar','<i class="fa fa-circle-o "></i> <span>Listado</span>') }}</li>
                        <li>{{ link_to('resoluciones/new','<i class="fa fa-circle-o "></i> <span>Nuevo</span>') }}</li>
                        <li>{{ link_to('resoluciones/index','<i class="fa fa-circle-o "></i> <span>Buscar</span>') }}</li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-folder-o text-gray"></i> <span>DISPOSICIONES</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('disposicion/listar','<i class="fa fa-circle-o "></i> <span>Listado</span>') }}</li>
                        <li>{{ link_to('disposicion/new','<i class="fa fa-circle-o "></i> <span>Nuevo</span>') }}</li>
                        <li>{{ link_to('disposicion/index','<i class="fa fa-circle-o "></i> <span>Buscar</span>') }}</li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-folder-o text-green"></i> <span>EXPEDIENTES</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('expediente/listar','<i class="fa fa-circle-o "></i> <span>Listado</span>') }}</li>
                        <li>{{ link_to('expediente/new','<i class="fa fa-circle-o "></i> <span>Nuevo</span>') }}</li>
                        <li>{{ link_to('expediente/index','<i class="fa fa-circle-o "></i> <span>Buscar</span>') }}</li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- =============================================== -->

    {{ content() }}
    <!-- =============================================== -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 3.0
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="http://imps.org.ar">IMPS</a>.</strong> Todos los derechos
        reservados.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">Configuración General</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Ver Roles
                            {{ link_to('','<i class="fa fa-arrow-right"></i>','class':'pull-right') }}
                        </label>

                        <p>
                            Listado de todos los roles.
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Ver Permisos
                            {{ link_to('','<i class="fa fa-arrow-right"></i>','class':'pull-right') }}
                        </label>

                        <p>
                            Listado de todos los permisos existentes.
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Ver Usuarios
                            {{ link_to('','<i class="fa fa-arrow-right"></i>','class':'pull-right') }}
                        </label>

                        <p>
                            Listado de todos los usuarios registrados.
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->