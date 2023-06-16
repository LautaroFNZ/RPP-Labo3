<?php
/*
1-
A- (1 pt.) index.php:
Recibe todas las peticiones que realiza el postman, y administra a qué archivo se debe incluir.
*/

switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':

        switch($_GET['request'])
        {
            case "ConsultasVentas":
                require_once "consultasVentas.php";
            break;
                
            case "ConsultasDevoluciones":
                require_once "ConsultasDevoluciones.php";
            break;
        }
         
    break;

    case 'POST':
        
        switch($_POST['request'])
        {
            case "HamburguesaCarga":
                require_once "HamburguesaCarga.php";
            break;

            case "HamburguesaConsultar":
                require_once "HamburguesaConsultar.php";
            break;

            case "AltaVenta":
                require_once "altaVenta.php";
            break;

            case "DevolverHamburguesa":
                require_once "DevolverHamburguesa.php";
            break;
            
            case "AltaVentaCupon":
                require_once "altaVentaCupon.php";
            break;
        }
        
        break;

    case 'PUT':
        require_once "modificarVenta.php";

        break;

    case 'DELETE':
        require_once "borrarVenta.php";
        break;

}

?>