<?php
require_once "Usuario.php";

class Devolucion extends Usuario{
    public $_razon;
    public $_tieneCupon;

    public function __construct($pedido,$razon,$cupon = null)
    {
        parent::__construct($pedido->_mail, $pedido->_nombre, $pedido->_aderezo, $pedido->_tipo, $pedido->_cantidad);
        $this->_razon = $razon;
        if($cupon)
        {
            $this->_tieneCupon = $cupon;
        }else $this->_tieneCupon = false;
    }

    public function Devolucion($devolucion, $nroPedido,$id)
    {
        $devolucion->_nroPedido = $nroPedido;
        $devolucion->_id = $id;
        $devolucion->_fecha = date("d-m-y");

        return $devolucion;
    }

}

?>