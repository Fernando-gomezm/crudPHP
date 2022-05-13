<?php include("includes/header.php") ?>
<?php

//Validar si recibimos el id de el contacto por URL
if (isset($_POST['id_categoria'])) {
    $idCategoria = $_POST['id_categoria'];
}
//Obtener la categoria actual
$query = "SELECT * FROM  categorias WHERE id = :id";
$stmt = $conn->prepare($query);

$stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);
$stmt->execute();

$categoria = $stmt->fetch(PDO::FETCH_OBJ);

//Borrar datos 
if (isset($_POST["borrarCategoria"])) {

    //Si entra por aquí es por que se puede ingresar el nuevo registro
    $query = "DELETE FROM categorias WHERE id = :id";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);

    $resultado = $stmt->execute();

    if ($resultado) {
        $mensaje = "Categoría borrada correcatamente";
        header('Location: categorias.php?mensaje=' . $mensaje);
    } else {
        $error = "No se pudo borrar el registro";
        header('Location: categorias.php?error=' . $error);
        exit();
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
    <div class="col-sm-6 container">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="col-sm-8">
                <h3>Borrar Categoría</h3>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php if ($categoria) echo $categoria->nombre; ?>" readonly>
            </div>
            <button type="submit" name="borrarCategoria" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Borrar categoria</button>
        </form>
    </div>
</div>
<?php include("includes/footer.php") ?>