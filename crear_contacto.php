<?php

include_once("conexion.php");

/*  //Configuramos zona horaria   
    date_default_timezone_set('America/Bogota');

    //Mostrar registros
    $query = "SELECT * FROM categorias";
    $stmt = $conn->query($query );

    $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

    var_dump($categorias); */

?>
<?php
//Obtener las categorias para el dropdown
$query = "SELECT * FROM categorias";
$stmt = $conn->prepare($query);

$stmt->execute();

$categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

//insertamos datos 
if (isset($_POST["crearContacto"])) {

    //Obtener los valores 
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $categoria = $_POST["categoria"];

    //Validar si está vacío
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($email) || empty($categoria)) {
        $error = "Error, algunos campos obligatorios están vacíos";
        header('Location: crear_contacto.php?error=' . $error);
    } else {

        //Si entra por aquí es por que se puede ingresar el nuevo registro
        $query = "INSERT INTO contactos ( nombre,apellido,telefono,email,categoria )
            values ( :nombre,:apellido,:telefono,:email,:categoria )";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":categoria", $categoria, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if ($resultado) {
            $mensaje = "Contacto creado correcatamente";
            header('Location: contactos.php?mensaje=' . $mensaje);
        } else {
            $error = "No se pudo crear el registro";
            header('Location: contactos.php?error=' . $error);
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
        <div class="col-sm-12">
            <h3>Crear un nuevo contacto</h3>
        </div>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Ingresa los apellidos">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Categoría:</label>
                <select class="form-select" aria-label="Default select example" name="categoria">
                    <option value="">--Selecciona una Categoría--</option>
                    <?php foreach ($categorias as $fila) : ?>
                        <option value="<?php echo $fila->id; ?>"><?php echo $fila->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br />
            <button type="submit" name="crearContacto" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Contacto</button>
        </form>
    </div>
</div>