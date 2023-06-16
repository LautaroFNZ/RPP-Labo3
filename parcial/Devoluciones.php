<?php
require_once "Usuario.php";

class Devolucion extends Usuario{
    public $_razon;
    public $_tieneCupon;

    public function __construct($mail, $nombre, $aderezo, $tipo, $cantidad, $razon, $cupon = null)
    {
        parent::__construct($mail, $nombre, $aderezo, $tipo, $cantidad);
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

    //CONSULTAS DEVOLUCIONES

    
    public static function parseDevolucion($devolucion)
    {
        $devolucionNueva = new Devolucion($devolucion->_mail,$devolucion->_nombre,$devolucion->_aderezo,$devolucion->_tipo,$devolucion->_cantidad,$devolucion->_razon,$devolucion->_tieneCupon);
        $devolucionNueva->Devolucion($devolucionNueva,$devolucion->_nroPedido,$devolucion->_id);

        return $devolucionNueva;
    }

    public function __toString()
    {
        return "Id:{$this->_id}|Mail:{$this->_mail}|Nombre:{$this->_nombre}|Aderezo:{$this->_aderezo}|Tipo:{$this->_tipo}|Cantidad:{$this->_cantidad}|Razón:{$this->_razon}|Tiene cupón:" . ($this->_tieneCupon ? 'Si' : 'No') . "<br>";

    }


    

    public static function DevolucionCuponTrue($mostrar)
    {
        $devoluciones = parent::leerVentas(DEVOLUCIONES);
        $toShow = array();

        if(count($devoluciones)>0)
        {
            foreach($devoluciones as $devolucion)
            {       
               if($devolucion->_tieneCupon)
               {
                array_push($toShow,$devolucion);
               } 
            }

            if(count($toShow)>0)
            {
                if($mostrar)
                {
                    echo "Mostrando devoluciones con cupón<br>";
                    foreach($toShow as $devolucion)
                    {
                        $mostrar = Devolucion::parseDevolucion($devolucion);
                        echo $mostrar;
                    }
                
                }
                
                return $toShow;

            }else{
                echo "No existen devoluciones con cupón.<br>";
            }


        }



    }

    public static function mostrarCupon($cupon)
    {
        return "Id:{$cupon->_id}|Mail:{$cupon->_usuario}|Vencimiento:{$cupon->_fechaVencimiento}|Descuento:10%|Esta activo:" . ($cupon->_activo ? 'Si' : 'No') ."<br>"; 
    }

    public static function ListarCupones()
    {
        $cupones = parent::leerVentas(CUPONES);

        if(count($cupones)>0)
        {   
            echo "Mostrando Cupones:<br>";
            foreach($cupones as $cupon)
            {   
                
                echo Devolucion::mostrarCupon($cupon);
            }
            echo "<br><br>";
        }
    }

    public static function ListarDevolucionYCupon()
    {
        $DevolucionConCupon = Devolucion::DevolucionCuponTrue(false);

        if(count($DevolucionConCupon)>0)
        {
            $cupones = parent::leerVentas(CUPONES);

            foreach($DevolucionConCupon as $devolucion)
            {
                foreach($cupones as $cupon)
                {
                    if($devolucion->_id == $cupon->_id && $cupon->_activo)
                    {
                        echo "-Devolución:<br>";
                        $mostrar = Devolucion::parseDevolucion($devolucion);
                        echo $mostrar;
                        echo "\tY su cupón:\t<br>" . Devolucion::mostrarCupon($cupon);
                    }
                }
            }
        }else{
            echo "No hay devoluciones que contengan un cupón actualmente";
        }

    }

}

?>