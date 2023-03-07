<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "jesusfernandez"; $contrasenia = "&xrK2g86"; $nombreBaseDatos = "jesusfernandez";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

//------------------SECCION DE USUARIOS/polizaS-----------------------

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM poliza WHERE cliente_idcliente = '" . $_GET["consultar"] . "'");
    if(mysqli_num_rows($sqlUsuarios) > 0){
        $Usuarios = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
        echo json_encode($Usuarios);
        exit();
    }
    else{  echo json_encode(false); }
}

if (isset($_GET["consultarCrear"])){
    $sqlUsuarios = mysqli_query($conexionBD,"SELECT nombre FROM cliente WHERE idcliente = '" . $_GET["consultarCrear"] . "'");
    if(mysqli_num_rows($sqlUsuarios) > 0){
        $Usuarios = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
        echo json_encode($Usuarios);
        exit();
    }
    else{  echo json_encode(false); }
}

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultarModificar"])){
    $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM poliza WHERE idpoliza = '" . $_GET["consultarModificar"] . "'");
    if(mysqli_num_rows($sqlUsuarios) > 0){
        $Usuarios = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
        echo json_encode($Usuarios);
        exit();
    }
    else{  echo json_encode(false); }
}

if (isset($_GET["consultarBorrar"])){
    $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM poliza WHERE idpoliza = '" . $_GET["consultarBorrar"] . "'");
    if(mysqli_num_rows($sqlUsuarios) > 0){
        $Usuarios = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
        echo json_encode($Usuarios);
        exit();
    }
    else{  echo json_encode(false); }
}

//Inserta un nuevo registro y recepciona en método post los datos de correo y contraseña
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $importe=$data->importe;
    $fecha=$data->fecha;
    $estado=$data->estado;
    $observaciones=$data->observaciones;
    $cliente_idcliente=$data->cliente_idcliente;

    $cli = mysqli_query($conexionBD,"SELECT idcliente FROM cliente WHERE nombre = '". $cliente_idcliente . "'");
    $cliente = mysqli_fetch_all($cli,MYSQLI_ASSOC);
    $cliente_id = $cliente[0]['idcliente'];

        $sqlUsuarios = mysqli_query($conexionBD,"INSERT INTO poliza(importe, fecha, estado, observaciones, cliente_idcliente) VALUES('$importe', '$fecha', '$estado', '$observaciones', '$cliente_id')");

        echo json_encode(true);    
        exit();
}

// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $idpoliza=(isset($data->idpoliza))?$data->idpoliza:$_GET["actualizar"];
    $importe=$data->importe;
    $fecha=$data->fecha;
    $estado=$data->estado;
    $observaciones=$data->observaciones;
    
    if($sqlUsuarios = mysqli_query($conexionBD,"UPDATE poliza SET importe = '$importe', fecha = '$fecha', estado = '$estado', observaciones = '$observaciones' WHERE idpoliza = '$idpoliza'")){
        echo json_encode(true);
        exit();
    } else {
        echo json_encode(false);
        exit();
    }
    
}

//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlUsuarios = mysqli_query($conexionBD,"DELETE FROM poliza WHERE idpoliza = '".$_GET["borrar"] . "'");
    if($sqlUsuarios){
        echo json_encode(true);
        exit();
    }
    else{  echo json_encode(false); }
}

// Consulta todos los registros de la tabla empleados
$sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM poliza");
if(mysqli_num_rows($sqlUsuarios) > 0){
    $Usuarios = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
    echo json_encode($Usuarios);
}
else{ echo json_encode([false]); }