<?php include "Views/Templates/header.php"; ?>



<div class="row">
        <div class="col-md-12">
          <div class="tile" style="border-radius: 5px;padding: 10px;">
           <div class="tile-body">
               <div class="row invoice-info d-flex">
                <div class="col-8 text-left input-group" id="botonesContainer">
                </div>

                <div class="col-4 text-right d-flex">
               <h5 class="title_max-width992 "><i class="fa fa-list"></i>&nbsp;Lista de Editorial/</h5>
               <button class="btn btn-primary btn-sm ml-auto" onclick="frmEditorial()">
                 <i class="fa fa-plus-circle" aria-hidden="true" style="color: white;"></i>&nbsp;Nuevo
               </button>
             </div>

              </div>
            </div>
           
          </div>
        </div>
      </div>



<div class="row">
    <div class="col-lg-12">
        <div class="tile clase_header" style="border-radius: 5px;padding: 10px;">
    <h5 class="title_max-width767 text-center" ><i class="fa fa-list"></i>&nbsp;Lista de Editorial</h5>
            <div class="tile-body">

            
                <table class="display responsive nowrap table table-sm" id="tblEditorial" style="width: 100%">
                    
                        <thead class="thead-dark">
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
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

<!-- Modal para registrar/editar editorial -->
<div id="nuevoEditorial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Editorial</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEditorial">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="editorial">Nombre</label>
                                <input type="hidden" id="id" name="id">
                                <input id="editorial" class="form-control" type="text" name="editorial" required placeholder="Nombre de Editorial">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" onclick="registrarEditorial(event)" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>