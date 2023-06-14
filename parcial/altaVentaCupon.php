<?php
/*
8-
(2 pts.) AltaVenta.php, ...(continuación) Todo lo anterior más...
a- Debe recibir el cupón de descuento (si existe) y guardar el importe final y el descuento aplicado en el archivo.
b- Validar que el cupón no se encuentre vencido
c- Debe marcarse el cupón como ya usado
*/
require_once "Usuario.php";


if(isset($_POST['mail']) && isset($_POST['nombre']) && isset($_POST['aderezo']) && isset($_POST['tipo']) && $_POST['cantidad'] && $_POST['idCupon'])
{
    $usuario = new Usuario($_POST['mail'],$_POST['nombre'],$_POST['aderezo'],$_POST['tipo'],$_POST['cantidad']);

    Usuario::generarVenta($usuario,intval($_POST['idCupon']));
    
}

?>

