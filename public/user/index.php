<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost";
$usuario = "jesusfernandez";
$contrasenia = "&xrK2g86";
$nombreBaseDatos = "jesusfernandez";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

//------------------SECCION DE USUARIOS/CLIENTES-----------------------

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])) {

    $sqlUsuarios = mysqli_query($conexionBD, "SELECT * FROM cliente WHERE idcliente = '" . $_GET["consultar"] . "'");
    if (mysqli_num_rows($sqlUsuarios) > 0) {
        $Usuarios = mysqli_fetch_all($sqlUsuarios, MYSQLI_ASSOC);
        echo json_encode($Usuarios);
        exit();
    } else {
        echo json_encode(false);
    }
}

if (isset($_GET["cliente1"]) && isset($_GET["cliente2"]) && isset($_GET["fechaInicio"]) && isset($_GET["fechaFin"]) && isset($_GET["estado"])) {

    // Escapar los parámetros para evitar inyección de SQL
    $cliente1 = mysqli_real_escape_string($conexionBD, $_GET["cliente1"]);
    $cliente2 = mysqli_real_escape_string($conexionBD, $_GET["cliente2"]);
    $fechaInicio = mysqli_real_escape_string($conexionBD, $_GET["fechaInicio"]);
    $fechaFin = mysqli_real_escape_string($conexionBD, $_GET["fechaFin"]);
    $estado = mysqli_real_escape_string($conexionBD, $_GET["estado"]);

    if ($estado == "") {
        $sql = "SELECT * FROM poliza WHERE cliente_idcliente BETWEEN LEAST('$cliente1', '$cliente2') AND GREATEST('$cliente1', '$cliente2') AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
    } else {
        // Construir la consulta SQL
        $sql = "SELECT * FROM poliza WHERE estado = '$estado' AND cliente_idcliente BETWEEN LEAST('$cliente1', '$cliente2') AND GREATEST('$cliente1', '$cliente2') AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
    }

    // Ejecutar la consulta y guardar los resultados en un array asociativo
    $resultado = $conexionBD->query($sql);

    $polizas = array();

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $polizas[] = $fila;
        }
    }

    echo json_encode($polizas);
    exit();
}

if (isset($_GET["cliente1"]) && isset($_GET["cliente2"]) && isset($_GET["fechaInicio"]) && isset($_GET["fechaFin"])) {

    // Escapar los parámetros para evitar inyección de SQL
    $cliente1 = mysqli_real_escape_string($conexionBD, $_GET["cliente1"]);
    $cliente2 = mysqli_real_escape_string($conexionBD, $_GET["cliente2"]);
    $fechaInicio = mysqli_real_escape_string($conexionBD, $_GET["fechaInicio"]);
    $fechaFin = mysqli_real_escape_string($conexionBD, $_GET["fechaFin"]);

    // Construir la consulta SQL
    $sql = "SELECT * FROM poliza WHERE cliente_idcliente BETWEEN LEAST('$cliente1', '$cliente2') AND GREATEST('$cliente1', '$cliente2') AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

    // Ejecutar la consulta y guardar los resultados en un array asociativo
    $resultado = $conexionBD->query($sql);

    $polizas = array();

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $polizas[] = $fila;
        }
    }

    echo json_encode($polizas);
    exit();
}

//login enviando los datos del formulario
if (isset($_GET["login"])) {
    $data = json_decode(file_get_contents("php://input"));
    $correo = $data->correo;
    $pass = $data->pass;
    $sqlUsuarios = mysqli_query($conexionBD, "SELECT * FROM usuario WHERE correo = '" . $correo . "' AND pass = '" . $pass . "'");
    if (mysqli_num_rows($sqlUsuarios) > 0) {
        $Usuarios = mysqli_fetch_all($sqlUsuarios, MYSQLI_ASSOC);
        echo json_encode(true);
        exit();
    } else {
        echo json_encode(false);
    }
}

//Inserta un nuevo registro y recepciona en método post los datos de correo y contraseña
if (isset($_GET["insertar"])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombre = $data->nombre;
    $apellido = $data->apellido;
    $telefono = $data->telefono;
    $provincia = $data->provincia;
    $codigo_postal = $data->codigo_postal;
    $municipio = $data->municipio;
    $tipo = $data->tipo;

    $resultadoProvincia = mysqli_query($conexionBD, "SELECT provincia FROM provincias WHERE id = $provincia");
    $provinciaNombre = mysqli_fetch_assoc($resultadoProvincia)['provincia'];
    $resultadoMunicipio = mysqli_query($conexionBD, "SELECT municipio FROM municipios WHERE id = $municipio");
    $municipioNombre = mysqli_fetch_assoc($resultadoMunicipio)['municipio'];

    if (validarNombreApellido($nombre) == 1 && validarNombreApellido($apellido) == 1 && comprobarCodigo($codigo_postal) == 1 &&  validarTelefono($telefono) == 1) {
        $sqlUsuarios = mysqli_query($conexionBD, "INSERT INTO cliente(nombre, apellido, telefono, provincia, codigo_postal, municipio, tipo) VALUES('$nombre', '$apellido', '$telefono', '$provinciaNombre', '$codigo_postal', '$municipioNombre', '$tipo')");

        echo json_encode(true);
        exit();
    } else {
        echo json_encode(false);
        exit();
    }
}

// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if (isset($_GET["actualizar"])) {

    $data = json_decode(file_get_contents("php://input"));

    $idcliente = (isset($data->idcliente)) ? $data->idcliente : $_GET["actualizar"];
    $nombre = $data->nombre;
    $apellido = $data->apellido;
    $telefono = $data->telefono;
    $provincia = $data->provincia;
    $codigo_postal = $data->codigo_postal;
    $municipio = $data->municipio;
    $tipo = $data->tipo;

    if ($provincia == "" || $municipio == "") {

        $resultadoProvincia = mysqli_query($conexionBD, "SELECT provincia FROM cliente WHERE idcliente = $idcliente");
        $provinciaNombre = mysqli_fetch_assoc($resultadoProvincia)['provincia'];
        $resultadoMunicipio = mysqli_query($conexionBD, "SELECT municipio FROM cliente WHERE idcliente = $idcliente");
        $municipioNombre = mysqli_fetch_assoc($resultadoMunicipio)['municipio'];
    } else {

        $resultadoProvincia = mysqli_query($conexionBD, "SELECT provincia FROM provincias WHERE id = $provincia");
        $provinciaNombre = mysqli_fetch_assoc($resultadoProvincia)['provincia'];
        $resultadoMunicipio = mysqli_query($conexionBD, "SELECT municipio FROM municipios WHERE id = $municipio");
        $municipioNombre = mysqli_fetch_assoc($resultadoMunicipio)['municipio'];
    }

    $sqlUsuarios = mysqli_query($conexionBD, "UPDATE cliente SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', provincia = '$provinciaNombre', codigo_postal = '$codigo_postal', municipio = '$municipioNombre', tipo = '$tipo' WHERE idcliente = '$idcliente'");
    echo json_encode(true);
    exit();
}

//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])) {
    mysqli_query($conexionBD, "DELETE FROM poliza WHERE cliente_idcliente = '" . $_GET["borrar"] . "'");
    $sqlUsuarios = mysqli_query($conexionBD, "DELETE FROM cliente WHERE idcliente = '" . $_GET["borrar"] . "'");
    if ($sqlUsuarios) {
        echo json_encode(true);
        exit();
    } else {
        echo json_encode(false);
    }
}

// Consulta todos los registros de la tabla empleados
$sqlUsuarios = mysqli_query($conexionBD, "SELECT * FROM cliente ");
if (mysqli_num_rows($sqlUsuarios) > 0) {
    $Usuarios = mysqli_fetch_all($sqlUsuarios, MYSQLI_ASSOC);
    echo json_encode($Usuarios);
} else {
    echo json_encode([false]);
}


function validarNombreApellido($nombre)
{
    $pattern = "/^[a-z]+$/i";

    if ((preg_match($pattern, $nombre))) {

        return 1;
    } else {

        return 0;
    }
}

function comprobarCodigo($codigo)
{

    if (preg_match('/^[0-9]{5,5}$/', $codigo)) {
        return 1;
    } else {
        return 0;
    }
}

function validarTelefono($numero)
{
    $reg = '/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/';
    if (preg_match($reg, $numero)) {

        return 1;
    } else {

        return 0;
    }
}


    //------------------SECCION DE POLIZAS-----------------------
