<?php include "Views/Templates/header.php"; ?>
<div class="row">
        <div class="col-md-12">
          <div class="tile" style="border-radius: 5px;padding: 10px;">
           <div class="tile-body">
               <div class="row invoice-info d-flex">
                <div class="col-8">
                    <h5 class=""><i class="fa fa-dashboard"></i>&nbsp;Panel de Administración</h5>
                </div>

                <div class="col-4 text-right ">
             </div>

              </div>
            </div>
           
          </div>
        </div>
      </div>

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-book fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Libros">
                <h4>Libros</h4>
                <p><b><?php echo $data['libros']['total'] ?></b></p>
            </a>
        </div>
    </div>
   
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-graduation-cap fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Estudiantes">
                <h4>Estudiantes</h4>
                <p><b><?php echo $data['estudiantes']['total'] ?></b></p>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-hourglass-start fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Prestamos">
                <h4>Prestamos</h4>
                <p><b><?php echo $data['prestamos']['total'] ?></b></p>
            </a>
        </div>
    </div>
  
</div>
<div class="row">
    <div class="col-md-6">
        <div class="tile">
           
             <h5 class="algin-center">Libros Prestados</h5>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="reportePrestamo"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="tile">
            <h5 class="d-inline mx-3 text-center">Libros Pendientes</h5>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="repoplibrosPendientes"></canvas>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>