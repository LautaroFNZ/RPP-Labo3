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


Usuario::mostrarSaborIngresado($_GET['aderezo']);

Usuario::mostrarVentasUsuario($_GET['usuario']);

Usuario::mostrarTipoIngresado($_GET['tipo']);



?>