<?php
/*
(2 pts.) ConsultasDevoluciones.php:-
a- Listar las devoluciones con cupones.
b- Listar solo los cupones y su estado
c- Listar devoluciones y sus cupones y si fueron usados
*/


require_once "Devoluciones.php";


//a.
Devolucion::DevolucionCuponTrue(true);

//b.
Devolucion::ListarCupones();

//c.
Devolucion::ListarDevolucionYCupon();



?>