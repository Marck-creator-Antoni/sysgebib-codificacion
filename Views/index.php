<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/font-awesome.min.css">
    <title>Iniciar | Sesión</title>
</head>
<style type="text/css">

#body_fonnd:before {
    content: '';
    position: fixed;
    width: 100vw;
    height: 100vh;
    background-image: url(Assets/img/background1.jpg);
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}
   #namesistem{
  font-size: 13px;
}
    
</style>

<body id="body_fonnd">
    
    <section class="login-content">
        
        <div class="login-box" style="">


            <form class="login-form" id="frmLogin" onsubmit="frmLogin(event);">
                <h3 class="login-head">
            <img src="Assets/img/logo1.jpg" style="width: 90px;height: 90px;">

            <p id="namesistem" class="semibold-text mt-2 mb-2"><strong>SysGebib</strong>- Escuela Profesional de Ingenieria de Sistemas</p></h3>
             <div class="alert alert-danger d-none" role="alert" id="alerta">
                    
                </div>
                <div class="form-group">
                    <label class="control-label">USUARIO</label>
                    <input class="form-control" type="text" placeholder="Usuario" id="usuario" name="usuario" autofocus required>
                </div>
                <div class="form-group">
                    <label class="control-label">CONTRASEÑA</label>
                    <input class="form-control" type="password" placeholder="Contraseña" id="clave" name="clave" required>
                </div>
               
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" style="background-color:rgb(0, 8, 255); border-color:rgb(26, 14, 255);" type="submit">
                        <i class="fa fa-sign-in fa-lg fa-fw"></i>Iniciar Sesión
                    </button>
                </div>
            </form>

            
        </div>
    </section>
    <!-- javascripts-->
    <script src="<?php echo base_url; ?>Assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/main.js"></script>
    <!-- end Javascripts-->
 
    <script>
        const base_url = '<?php echo base_url; ?>';
    </script>
    <script src="<?php echo base_url; ?>Assets/js/login.js"></script>
    
   
</body>

</html>