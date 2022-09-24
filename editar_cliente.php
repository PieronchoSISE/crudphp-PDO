<?php

$db = new PDO('mysql:host=localhost; dbname=financiera', 'sise','sise123');

$id=$_GET['id'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    echo 'Enviado por el metodo post';
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $razon_social = $nombres.' '.$apellidos;
    $tipo_cliente = $_POST['tipoCliente'];
    $tipo_documento = $_POST['tipoDocumento'];
    $numero_documento = $_POST['numeroDocumento'];
    $direccion = $_POST['direccion'];
    $referencia = $_POST['referencia'];
    
    $sql = "UPDATE cliente SET nombres = '$nombres', apellidos = '$apellidos',razon_social='$razon_social',
    direccion='$direccion',referencia='$referencia',id_tipo_cliente='$tipo_cliente',
    id_tipo_documento = '$tipo_documento', numero_documento='$numero_documento'
    WHERE id=$id";
    $resultado = $db->query($sql);
    if($resultado){
        header('location:index.php');
    }
    
    exit;
}





$query = $db->prepare("SELECT*FROM cliente WHERE id=:id");
$query->execute(['id' => $id]);
$num = $query->rowCount();
if ($num > 0) {
    $cliente = $query->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: index.php");
}


$sql = "SELECT*FROM tipo_cliente";
$resultado = $db->query($sql);
$tipos_cliente=[];
foreach($resultado as $tipo){
    $tipos_cliente[]=$tipo;
}


$sql = "SELECT*FROM tipo_documento";
$resultado = $db->query($sql);
$tipos_documento=[];
foreach($resultado as $tipo){
    $tipos_documento[]=$tipo;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <h1 class="header">Editar Cliente</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombres:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $cliente['nombres'] ?>">

            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellidos:</label>
                <input type="text" name="apellido" id="apellido" class="form-control" value="<?php echo $cliente['apellidos'] ?>">

            </div>

            <div class="mb-3">
            <label for="tipoCliente" class="form-label">Tipo Cliente:</label>
            <select class="form-control" id="tipoCliente" name="tipoCliente">
                <option value="0">--SELECCIONE--</option>
                <?php
                foreach($tipos_cliente as $tipo):
                ?>    
                    <option value="<?php echo $tipo['id'] ?>"
                    <?php echo $tipo['id'] === $cliente['id_tipo_cliente'] ? 'selected' : '' ?>>
                    <?php echo $tipo['nombre']?>
                    </option>
                <?php
                    endforeach;
                ?>
            </select>
            </div>

            <div class="mb-3">
            <label for="tipoDocumento" class="form-label">Tipo Documento:</label>
            <select class="form-control" id="tipoDocumento" name="tipoDocumento">
                <option value="0">--SELECCIONE--</option>
                <?php
                foreach($tipos_documento as $tipo):
                ?>    
                    <option value="<?php echo $tipo['id'] ?>"
                    <?php echo $tipo['id'] === $cliente['id_tipo_documento'] ? 'selected' : '' ?>>
                    <?php echo $tipo['nombre']?></option>
                <?php
                    endforeach;
                ?>
            </select>
            </div>

            <div class="mb-3">
                <label for="numeroDocumento" class="form-label">N° Documento</label>
                <input type="text" name="numeroDocumento" id="numeroDocumento" class="form-control" value="<?php echo $cliente['numero_documento'] ?>">


            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $cliente['direccion'] ?>">

            </div>
            <div class="mb-3">
                <label for="referencia" class="form-label">Referencia:</label>
                <textarea name="referencia" id="referencia" cols="30" rows="5" class="form-control"><?php echo $cliente['referencia'] ?></textarea>

            </div>
            <input type="submit" value="Grabar" class="btn btn-primary">
        </form>

    </div>
</body>
</html>

