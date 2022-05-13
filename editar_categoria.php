<?php include("includes/header.php") ?>
<?php

//Validar si recibimos el id de la categoria por URL
if (isset($_POST['id_categoria'])) {
    $idCategoria = $_POST['id_categoria'];
}

//Obtener la categoria actual
$query = "SELECT * FROM  categorias WHERE id = :id";
$stmt = $conn->prepare($query);

$stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);
$stmt->execute();

$categoria = $stmt->fetch(PDO::FETCH_OBJ);

//Editamos datos 
if (isset($_POST["editarCategoria"])) {

    //Obtener los valores 
    $nombre = $_POST["nombre"];

    //Validar si está vacío
    if (empty($nombre)) {
        $error = "Error, algunos campos obligatorios están vacíos";
        header('Location: editar_categoria.php?error=' . $error);
    } else {
        //Configuramos la fecha para la inserción
        $fechaActual =  date("Y-m-d");

        //Si entra por aquí es por que se puede ingresar el nuevo registro
        $query = "UPDATE categorias SET nombre=:nombre WHERE id=:id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);

        $resultado = $stmt->execute();

        if ($resultado) {
            $mensaje = "Categoría actualizada correcatamente";
            header('Location: categorias.php?mensaje=' . $mensaje);
        } else {
            $error = "No se pudo actualizar el registro";
            header('Location: categorias.php?error=' . $error);
            exit();
        }
    }
}

?>
<div class="row">
    <div class="col-sm-12">
        <?php if (isset($_GET["error"])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET["error"]; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>
    </div>
</div>
<div class="row">
</div>
<div class="row">
    <div class="col-sm-6 container">
        <div class="col-sm-8">
            <h3>Editar Categoría</h3>
        </div>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php if ($categoria) echo $categoria->nombre; ?>">
            </div>
            <button type="submit" name="editarCategoria" class="btn btn-primary w-100">Editar Categoría</button>
        </form>
    </div>
</div>
<?php include("includes/footer.php") ?>