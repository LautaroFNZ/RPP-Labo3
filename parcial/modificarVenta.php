<?php
/*
5-
(1 pts.) ModificarVenta.php (por PUT), debe recibir el número de pedido, el email del usuario, el nombre, tipo,
aderezo y cantidad, si existe se modifica , de lo contrario informar.
*/

require_once "Usuario.php";

parse_str(file_get_contents("php://input"), $params);

if (
    isset($params['nroPedido']) &&
    isset($params['mail']) &&
    isset($params['aderezo']) &&
    isset($params['tipo']) &&
    isset($params['nombre']) &&
    isset($params['cantidad'])
) {
    $nroPedido = $params['nroPedido'];
    $mail = $params['mail'];
    $aderezo = $params['aderezo'];
    $tipo = $params['tipo'];
    $nombre = $params['nombre'];
    $cantidad = $params['cantidad'];

    // Validar los datos según sea necesario
    // ...

    // Llamar a la función Usuario::modificarVenta()
    Usuario::modificarVenta($nombre, intval($nroPedido), $mail, $aderezo, $tipo, intval($cantidad));

    
    
}








?>