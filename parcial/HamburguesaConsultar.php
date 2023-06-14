<?php
/*
2-
(1pt.) HamburguesaConsultar.php: (por POST)Se ingresa Nombre, Tipo, si coincide con algún registro del archivo
Hamburguesas.json, retornar “Si Hay”. De lo contrario informar si no existe el tipo o el nombre.
*/

require_once "Hamburguesa.php";

function ConsultarStock($tipo,$nombre)
{
    $informacion = json_decode(Hamburguesa::HayStock($nombre,$tipo));

    echo $informacion->nombre . $informacion->tipo;
}

if(isset($_POST['nombre']) && isset($_POST['tipo']))
{
    ConsultarStock($_POST['tipo'],$_POST['nombre']);
}
    



?>


