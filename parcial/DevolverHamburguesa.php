<?php
/*
7-
(2 pts.) DevolverHamburguesa.php
Guardar en el archivo (devoluciones.json y cupones.json):
a- Se ingresa el número de pedido y la causa de la devolución. El número de pedido debe existir, se ingresa una
foto del cliente enojado,esto debe generar un cupón de descuento con el 10% de descuento para la próxima
compra con un vencimiento de 3 días.
*/

require_once "Usuario.php";


Usuario::DevolverHamburguesa($_POST['nroPedido'],$_POST['razon']);


?>