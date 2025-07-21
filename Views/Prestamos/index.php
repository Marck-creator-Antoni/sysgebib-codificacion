<?php include "Views/Templates/header.php"; ?>
 <div class="row">
        <div class="col-md-12">
          <div class="tile" style="border-radius: 5px;padding: 10px;">
           <div class="tile-body">
               <div class="row invoice-info d-flex">
                <div class="col-8 text-left input-group" id="botonesContainer">
                </div>

                <div class="col-4 text-right d-flex">
               <h5 class="title_max-width992 "><i class="fa fa-list"></i>&nbsp;Lista de Préstamos/</h5>
               <button class="btn btn-primary btn-sm ml-auto" onclick="frmPrestar()">
                 <i class="fa fa-plus-circle" aria-hidden="true" style="color: white;"></i>&nbsp;Nuevo
               </button>
             </div>

              </div>
            </div>
           
          </div>
        </div>
      </div>

 <div class="row">
  <div class="col-md-12">
   <div class="tile clase_header" style="border-radius: 5px;padding: 10px;">
    <h5 class="title_max-width767 text-center" ><i class="fa fa-list"></i>&nbsp;Lista de Préstamos</h5>
     <div class="tile-body">
        
            <table class="display responsive nowrap table table-sm" id="tblPrestar" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>N°</th>
                        <th>Libro</th>
                        <th>Estudiante</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Devolución</th>
                        <th>Cant(Uni.)</th>
                        <th>Observación</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
       
    </div>
   </div>
 </div>
</div>


<div id="prestar" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Prestar Libro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmPrestar" onsubmit="registroPrestamos(event)">
                    <div class="form-group">
                        <label for="libro">Libro</label><br>
                        <select id="libro" class="form-control libro" name="libro" onchange="verificarLibro()" required style="width: 100%;">

                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="estudiante">Estudiante</label><br>
                                <select name="estudiante" id="estudiante" class="form-control estudiante" required style="width: 100%;">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cantidad">Cant</label>
                                <input id="cantidad" class="form-control" min="1" type="number" name="cantidad" min="1" required onkeyup="verificarLibro()">
                                <strong id="msg_error"></strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_prestamo">Fecha de Prestamo</label>
                                <input id="fecha_prestamo" class="form-control" type="date" name="fecha_prestamo" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_devolucion">Fecha de Devolución</label>
                                <input id="fecha_devolucion" class="form-control" type="date" name="fecha_devolucion" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <textarea id="observacion" class="form-control" placeholder="Observación" name="observacion" rows="3"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit" id="btnAccion">Prestar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>


<nav aria-label="Navegación de páginas" _mstaria-label="258947" _msthash="41">
        <ul class="pagination justify-content-end pagination-sm" style="margin-bottom: 0px; margin-top: 0px;">
            <li class="page-item">
                <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=1">
                    <div class="valign-center">
                        <i class="material-icons" style="line-height:0.7;" _msttexthash="183456" _msthash="42">fast_rewind</i>
                    </div>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=1">
                    <div class="valign-center ">
                        <i class="material-icons" style="line-height:0.7;" _msttexthash="242307" _msthash="43">skip_previous</i>
                    </div>
                </a>
            </li>

                    <li class="page-item active">
                        <a class="page-link" href="" _msttexthash="4459" _msthash="44">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=2" _msttexthash="4550" _msthash="45">2</a>
                    </li>


        <li class="page-item"><a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=3" _msttexthash="4641" _msthash="46">3</a></li>







            
<li class="page-item">
    <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=2" aria-label="Próximo" _mstaria-label="46722" _msthash="47">
        <div class="valign-center ">
            <i class="material-icons" style="line-height:0.7;" _msttexthash="140712" _msthash="48">skip_next</i>
        </div>
    </a>
</li>
<li class="page-item">
    <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=3" aria-label="Próximo" _mstaria-label="46722" _msthash="49">
        <div class="valign-center ">
            <i class="material-icons" style="line-height:0.7;" _msttexthash="208884" _msthash="50">fast_forward</i>
        </div>
    </a>
</li>

           
        </ul>
    </nav>