<?php include("includes/header.php") ?>

<?php
//Configurar zona horaria
date_default_timezone_set('America/Bogota');

//Mostrar registros
$query = "SELECT * FROM categorias";
$stmt = $conn->query($query);
$categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

/*  var_dump($categorias);  */

?>

<div class="row">
    <div class="col-sm-12">
        <?php if (isset($_GET["mensaje"])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET["mensaje"]; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="col-sm-3 mt-2">
    <a href="crear_categoria.php" class="btn btn-primary w-100"> Nueva Categoría</a>
</div>
<div class="col-sm-6 mt-2">
    <h3>Lista de Categorías</h3>
</div>
<div class="row col-sm-12 mt-2 container table-responsive">
    <table id="tblCategorias" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $fila) : ?>
                <tr>
                    <td><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->nombre; ?></td>
                    <td><?php echo $fila->fecha_creacion; ?></td>
                    <td>
                    <form method="POST" action="editar_categoria.php"> 
                        <input name="id_categoria" type="hidden" value="<?php echo $fila->id; ?>">
                        <button class="btn btn-primary configurar" title='Editar'>
                            <i class="bi bi-pencil-fill"></i></button>
                    </form>
                    <form method="POST" action="borrar_categoria.php"> 
                        <input name="id_categoria" type="hidden" value="<?php echo $fila->id; ?>">
                        <button class="btn btn-danger eliminar" title='Eiminar'>
                            <i class="bi bi-x-circle-fill"></i></button>
                    </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<?php include("includes/footer.php") ?>

<script>
    $(document).ready(function() {
        $('#tblCategorias').DataTable();
    });
</script>