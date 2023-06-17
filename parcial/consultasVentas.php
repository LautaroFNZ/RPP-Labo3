<?php
/*
4-
(1 pts.)ConsultasVentas.php: necesito saber :
a- La cantidad de Hamburguesas vendidas en un día en particular, si no se pasa fecha, se muestran sólo las
del día de ayer.
b- El listado de ventas entre dos fechas ordenado por nombre.
c- El listado de ventas de un usuario ingresado.
d- El listado de ventas de un tipo ingresado.
e- Listado de ventas de aderezo “Ketchup”
*/

require_once "Usuario.php";
require_once "Hamburguesa.php";

if(isset($_GET['tipo']) && isset($_GET['usuario']) && isset($_GET['fechaIngresada']) && isset($_GET['fecha1']) && isset($_GET['fecha2']))
{
    if(!empty($_GET['tipo']) && !empty($_GET['usuario']))
    {
        Usuario::mostrarVentasUsuario($_GET['usuario']);
        
        Usuario::mostrarTipoIngresado($_GET['tipo']);
        
        Usuario::mostrarSaborIngresado("ketchup");

    }else{
        echo "Verifique que ningun dato esta vacio<br>";
    }
    

    if(!empty($_GET['fechaIngresada']))
    {
        echo Usuario::buscarVentasFecha($_GET['fechaIngresada']);
    }else{
        echo Usuario::mostrarVentasAyer();
    }

    if(!empty($_GET['fecha1']) && !empty($_GET['fecha2']))
    {
        Usuario::ventasEnRango($_GET['fecha1'],$_GET['fecha2']);
    }else{
        echo "Ingrese las fechas correspondientes";
    }

}







?>