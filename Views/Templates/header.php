<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    
    <title>Biblioteca || Home</title>
       <link rel="shortcut icon" href="../Assets/img/logo.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link href="<?php echo base_url; ?>Assets/css/main.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/datatables.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/font-awesome.min.css">
</head>
      <style>
.swal2-popup{
  font-size:0.7rem !important;
}
</style>
<body class="app sidebar-mini"> 
    <!-- Navbar-->
    <header class="app-header">
        <a class="app-header__logo" href="<?php echo base_url; ?>Configuracion/admin">SYSGEBIB</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!--Notification Menu-->
              <li class="dropdown"><a class="app-nav__item" href="#" id="modalPass"><i class="fa fa-key"></i></a>
            </li>
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications" ><i class="fa fa-bell-o fa-lg"></i> <span class="me-1 badge badge-pill bg-danger" id="notificationCount">0</span>

            

         </a>
                <ul class="app-notification dropdown-menu dropdown-menu-right">
                    <li class="app-notification__title">Libros no entregados.</li>
                    <div class="app-notification__content">
                        <li id="nombre_estudiante">
                            
                        </li>
                    </div>
                    <li class="app-notification__footer"><a href="<?php echo base_url; ?>Configuracion/libros" target="_blank">Generar Reporte.</a></li>
                </ul>
            </li>
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    
                    <li><a class="dropdown-item" href="<?php echo base_url; ?>Usuarios/salir"><i class="fa fa-sign-out fa-lg"></i> Salir</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user">

         <img class="app-sidebar__user-avatar" src="<?php echo base_url; ?>Assets/img/bibliotecaria.png" alt="User Image" style="width: 70px;height: 50px">
            <div>
                <p class="app-sidebar__user-name"><?php echo $_SESSION['nombre'] ?></p>
                <p class="app-sidebar__user-designation"><?php echo $_SESSION['usuario']; ?></p>
            </div>
        </div>
        <ul class="app-menu">
           
            <li><a class="app-menu__item active" href="<?php echo base_url; ?>Configuracion/admin"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

            <li><a class="app-menu__item" href="<?php echo base_url; ?>Prestamos"><i class="app-menu__icon fa fa-hourglass-start"></i><span class="app-menu__label">Prestamos</span></a></li>

            <li><a class="app-menu__item" href="<?php echo base_url; ?>Estudiantes"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Estudiantes</span></a></li>

            <li><a class="app-menu__item" href="<?php echo base_url; ?>Materia"><i class="app-menu__icon fa fa-list-alt"></i><span class="app-menu__label">Materias</span></a></li>


             <li><a class="app-menu__item" href="<?php echo base_url; ?>Autor"><i class="app-menu__icon fa fa-address-book-o"></i></i><span class="app-menu__label">Autor</span></a></li>


             <li><a class="app-menu__item" href="<?php echo base_url; ?>Editorial"><i class="app-menu__icon fa fa-tags"></i><span class="app-menu__label"> Editorial</span></a></li>

             
             <li><a class="app-menu__item" href="<?php echo base_url; ?>Libros"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label"> Libros</span></a></li>
            
            
        </ul>
    </aside>
    <main class="app-content">

  <script type="text/javascript"> 

// Obtenemos la ruta actual después del nombre de dominio
var rutaActual =  window.location.href;
// Obtenemos todos los enlaces del sidebar
var enlacesSidebar = document.querySelectorAll(".app-menu a");
// Iteramos sobre los enlaces para activar el menú correspondiente
enlacesSidebar.forEach(function(enlace) {
  // Obtenemos la ruta del enlace actual del sidebar
  var rutaEnlace = enlace.getAttribute("href");
  // Comparamos si la ruta del enlace coincide con la ruta actual
  if (rutaEnlace === rutaActual) {
    // Si coincide, activamos el menú (puedes aplicar estilos o clases CSS aquí)
    enlace.classList.add("active");
  } else {
    // Si no coincide, desactivamos el menú (puedes eliminar estilos o clases CSS aquí)
    enlace.classList.remove("active");
  }
});



 </script>