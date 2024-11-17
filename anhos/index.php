<?php include '../conexion.php';
    $conexion = Conexion::conectar();
    $datos = pg_fetch_all(pg_query($conexion, "select * from anhos order by id_anho")); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SARAD</title>
        <link rel="stylesheet" href="/sarad/estilo/css/bootstrap.min.css">
        <link rel="stylesheet" href="/sarad/estilo/iconos/css/font-awesome.min.css">
        <style>
            body {
                background: linear-gradient(to bottom, #4b79a1 25%, #283e51 75%);
                color: white;
                font-family: 'Arial', sans-serif;
                margin: 0;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            main {
                flex: 1;
                padding: 20px;
                text-align: center;
                background: rgba(0, 0, 0, 0.7);
                border-radius: 20px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
                margin: 20px;
            }

            h5 {
                margin: 20px 0;
                font-family: 'Verdana', sans-serif;
                overflow-wrap: break-word;
                color: white;
            }

            .btn-custom {
                background: linear-gradient(to bottom, #4b79a1, #283e51);
                color: white;
                border: 2px solid black;
                border-radius: 20px;
                transition: background-color 0.3s, transform 0.3s;
                padding: 15px 20px;
                margin: 10px;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                width: 200px;
            }

            .btn-custom:hover {
                background-color: #2a2a4d;
                transform: translateY(-3px);
            }

            .input-group-text {
                background: transparent;
                border: none;
                color: white;
                font-size: 1.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            footer {
                text-align: center;
                padding: 20px;
                background: linear-gradient(to bottom, #4b79a1, #283e51);
                color: white;
                border-radius: 15px;
                border: 3px solid black;
                margin-top: auto;
            }

            .modal-content {
                background: rgba(0, 0, 0, 0.8);
                border: 2px solid black;
            }

            .modal-header, .modal-footer {
                border-bottom: 1px solid black;
            }

            .text-muted {
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="text-white">
                <h5 class="display-2 fw-bold">Años Lectivos</h5>
                <div class="p-1 m-1 text-end">
                    <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#modal-agregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                </div>
                <?php foreach($datos as $d){ ?>
                    <div class="p-1 m-1 input-group">
                        <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <button onclick="modificar(<?php echo $d['id_anho']; ?>,'<?php echo $d['anho_descrip']; ?>')" class="btn btn-custom">
                            <?php echo $d['anho_descrip']; ?>
                        </button>
                    </div>
                <?php } ?>
                <div class="p-1 m-1 text-end">
                    <a href="/sarad/inicio" class="btn btn-custom"><i class="fa fa-arrow-left"></i> Volver</a>
                </div>
            </div>
            <input type="hidden" data-bs-toggle="modal" data-bs-target="#modal-modificar" id="btn-modal-modificar">
        </main>

        <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar" aria-hidden="true">
            <form action="agregar.php" method="POST">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Agregar</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="form-control text-success" name="descripcion" required="" placeholder="Descripción">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-custom"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                  </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="modal-modificar" tabindex="-1" aria-labelledby="modal-agregar" aria-hidden="true">
            <form action="modificar.php" method="POST">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Actualizar</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">Descripción</label>
                          <div class="input-group">
                              <span class="input-group-text">
                                  <i class="fa fa-calendar"></i>
                              </span>
                              <input type="text" class="form-control text-success" id="modificar_descripcion" name="descripcion" required="" placeholder="Descripción">
                          </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" id="modificar_codigo" name="codigo" value="">
                        <button type="submit" name="operacion" value="MODIFICAR" class="btn btn-warning text-white"><i class="fa fa-edit"></i> Modificar</button>
                        <button type="submit" name="operacion" value="ELIMINAR" class="btn btn-dark"><i class="fa fa-minus-circle"></i> Eliminar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                  </div>
                </div>
            </form>
        </div>

        <script src="/sarad/estilo/js/bootstrap.min.js"></script>
        <script src="/sarad/estilo/js/jquery-3.7.1.min.js"></script>
        <script>
            function modificar(codigo, descripcion){
                $("#modificar_codigo").val(codigo);
                $("#modificar_descripcion").val(descripcion);
                $("#btn-modal-modificar").click();
            }
        </script>
    </body>
</html>
