<?php
/*
3-
a- (1 pts.) AltaVenta.php: (por POST)se recibe el email del usuario y el nombre, tipo, aderezo y cantidad ,si el ítem
existe en Hamburguesas.json, y hay stock guardar en el archivo con la fecha, número de pedido y id
autoincremental ) y se debe descontar la cantidad vendida del stock .


*/
require_once "Hamburguesa.php";
//require_once "HamburguesaConsultar.php";
require_once "Usuario.php";


if(isset($_POST['mail']) && isset($_POST['nombre']) && isset($_POST['aderezo']) && isset($_POST['tipo']) && isset($_POST['cantidad']))
{
    $usuario = new Usuario($_POST['mail'],$_POST['nombre'],$_POST['aderezo'],$_POST['tipo'],$_POST['cantidad']);

    Usuario::generarVenta($usuario,-1);
    
}


?>

