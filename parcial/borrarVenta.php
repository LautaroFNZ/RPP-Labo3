<?php
/*
6-
(1 pts.) borrarVenta.php (por DELETE), debe recibir un número de pedido,se borra la venta y la foto se mueve a la
carpeta /BACKUPVENTAS/2023.
*/
require_once "Usuario.php";

parse_str(file_get_contents("php://input"), $params);

if(isset($params['nroPedido']))
{
    if(!empty($params['nroPedido']))
    {
        Usuario::borrarVenta($params['nroPedido']);

    }else{
        echo "Verifique que ningun dato esta vacio<br>";
    }
}






?>