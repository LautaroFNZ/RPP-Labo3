<?php
/*
B- (1 pt.) HamburguesaCarga.php: (por POST) se ingresa Nombre, Precio, Tipo (“simple” o “doble”), Aderezo
(“Mostaza”, “Mayonesa”, “Ketchup”) y Cantidad( de unidades). Se guardan los datos en en el archivo de texto
Hamburguesas.json, tomando un id autoincremental como identificador(emulado) .Sí el nombre y tipo ya existen
, se actualiza el precio y se suma al stock existente.
completar el alta con imagen de la hamburguesa, guardando la imagen con el tipo y el nombre como
identificación en la carpeta /ImagenesDeHamburguesas/2023.
*/

require_once "Hamburguesa.php";

if(isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['aderezo']) && isset($_POST['cantidad']))
{
    if(!empty($_POST['nombre']) && !empty($_POST['precio']) && !empty($_POST['tipo']) && !empty($_POST['aderezo']) && !empty($_POST['cantidad']))
    {
        $burger = new Hamburguesa($_POST['nombre'],intval($_POST['precio']),$_POST['tipo'],$_POST['aderezo'],intval($_POST['cantidad']));

        Hamburguesa::GenerarBurger($burger);
    }else{
        echo "Verifique que ningun dato esta vacio<br>";
    }
  
}



?>