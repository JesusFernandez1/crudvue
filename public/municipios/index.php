<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "jesusfernandez"; $contrasenia = "&xrK2g86"; $nombreBaseDatos = "jesusfernandez";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


if (isset($_GET["consultarMunicipio"])){
    
    $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM municipios WHERE provincia = '" . $_GET["consultarMunicipio"] . "'");
    if(mysqli_num_rows($sqlUsuarios) > 0){
        $Usuarios = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
        echo json_encode($Usuarios);
        exit();
    }
    else{ echo json_encode([false]); }
}