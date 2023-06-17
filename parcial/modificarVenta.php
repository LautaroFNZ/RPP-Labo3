<?php
/*
5-
(1 pts.) ModificarVenta.php (por PUT), debe recibir el número de pedido, el email del usuario, el nombre, tipo,
aderezo y cantidad, si existe se modifica , de lo contrario informar.
*/

require_once "Usuario.php";

parse_str(file_get_contents("php://input"), $params);

if (isset($params['nroPedido']) && isset($params['mail']) && isset($params['aderezo']) && isset($params['tipo']) && isset($params['nombre']) &&isset($params['cantidad'])) 
{
    if(!empty($params['nroPedido']) && !empty($params['mail']) && !empty($params['aderezo']) && !empty($params['tipo']) && !empty($params['nombre']) && !empty($params['cantidad']))
    {
        Usuario::modificarVenta($params['nombre'], $params['nroPedido'], $params['mail'], $params['aderezo'], $params['tipo'], intval($params['cantidad']));

    }
    else{
        echo "Verifique que ningun dato esta vacio<br>";
    }
}








?>