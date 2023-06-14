<?php
require_once "Hamburguesa.php";
require_once "Devoluciones.php";

const VENTAS = 'ventas.json';
const CUPONES = 'cupones.json';
const DEVOLUCIONES = 'devoluciones.json';

class Usuario{
    public $_id;
    public $_mail;
    public $_nombre;
    public $_aderezo;
    public $_tipo;
    public $_cantidad;
    public $_fecha;
    public $_nroPedido;
    public $_status;

    public $_precio;

    public function __construct($email,$nombre,$aderezo,$tipo,$cantidad)
    {
        $this->_id = Usuario::generarId();
        $this->_nroPedido = $this->generarNroPedido();
        $this->_mail = $email;
        $this->_nombre = $nombre;

        if(strcasecmp($tipo,"simple")==0 || strcasecmp($tipo,"doble")==0)
        {
            $this->_tipo = $tipo;
        }else $this->_tipo = "simple";

        if(strcasecmp($aderezo,"mayonesa")==0 || strcasecmp($aderezo,"ketchup")==0 || strcasecmp($aderezo,"mostaza")==0)
        {
            $this->_aderezo = $aderezo;
        }else $this->_tipo = "mayonesa";

        $this->_cantidad = intval($cantidad);
        $this->_fecha = date("d-m-y");
        $this->_status = true;
        $this->_precio = 0;

    }

    //ALTA VENTA


    public function generarNroPedido()
    {
        $listaUsuarios = Usuario::leerVentas(VENTAS);

        $nroP=0;

        foreach($listaUsuarios as $user)
        {
            $nroP = $user->_nroPedido +1;
        }

        if($nroP != 0)
        {
            return $nroP;
        }else{
            return count(Usuario::leerVentas(VENTAS)) + 1; 
        }
    }

    //GENERAR VENTAS

    public static function leerVentas($path){

        $ar = fopen($path, "a+");
        $linea = fgets($ar);
        fclose($ar);
        $decode = json_decode($linea);
        
        if($decode != "")
        {
            return $decode;
        }              
        return array();
    }


    public static function generarId()
    {
        return rand(1,1000);
    }

    

    public static function GuardarInfo($users,$path)
    {
        if($users != null)
        {        
            $ar = fopen($path, "w");
    
            $retorno = fwrite($ar,json_encode($users));

            fclose($ar);
        }else{
            echo "ERROR, el array no existe<br>";
        }

    }

    public static function GuardarImagen($user){
        $nombreUsuario = explode("@",$user->_mail);       
        $nombreDeArchivo = "$user->_nombre - $user->_tipo - $nombreUsuario[0]";
        $destino = "ImagenesDeLaVenta/2023/";
        is_dir($destino) ?: mkdir($destino,0777,true);

        $nombreFinal = $destino . $nombreDeArchivo . ".jpg";

        $tmpName = $_FILES["imagen"]["tmp_name"];
        
        return move_uploaded_file($tmpName, $nombreFinal);
    }

    public static function generarVenta($user,$idCupon)
    {   
        $ventas = Usuario::leerVentas(VENTAS);
        $key = json_decode(Hamburguesa::HayStock($user->_nombre,$user->_tipo));

        if($key->stock > 0)
        {
            
            if(Hamburguesa::modificarStock($user->_cantidad,$key->id,"restar"))
            {   
                $precio = intval($key->precio) * $user->_cantidad;
                if(($cupon = Usuario::ValidarCupon($idCupon)))
                {
                    $user->_precio = $precio - ($precio * $cupon);
                   
                    echo "Descuento aplicado con exito! El cupón dejará de estar activo<br>";
                }else{
                    $user->_precio = $precio;
                }
                
                array_push($ventas,$user);
                Usuario::GuardarInfo($ventas,VENTAS);
                Usuario::GuardarImagen($user);
                echo "Venta generada con exito!";

            }else{
                echo "No se pudo realizar la venta <br>";
            }
            

        }else{
            echo "No tenemos stock!!";
          
        }
       

    }

    //MODIFICAR VENTA

    public static function modificarVenta($nombre,$nroPedido,$mail,$aderezo,$tipo,$cantidad)
    {
        $pedidos = Usuario::leerVentas(VENTAS);
        $flag = false;
        $stock = json_decode(Hamburguesa::HayStock($nombre,$tipo));
        
        foreach($pedidos as $u)
        {
            
            if($u->_nroPedido == $nroPedido)
            {
                
                Hamburguesa::modificarStock($u->_cantidad,$stock->id,"sumar");

                if(Hamburguesa::modificarStock($cantidad,$stock->id,"restar"))
                {  
                    $u->_mail = $mail;
                    $u->_aderezo = $aderezo;
                    $u->_tipo = $tipo;
                    $u->_nombre = $nombre;
                    $u->_cantidad = $cantidad;
                    $flag = true;
                    break;
                }else{
                    Hamburguesa::modificarStock($u->_cantidad,$stock->id,"restar");
                    
                }
                
               
            }
        }

        if($flag)
        {   
            echo "Pedido modificado!";
            Usuario::GuardarInfo($pedidos,VENTAS);
          
        }else{
            echo "No pudimos modificar tu pedido!";
        }
    }

    //CONSULTAS VENTAS

    public static function convertirUsuario($u)
    {
        $Usuario = new Usuario($u->_mail,$u->_nombre,$u->_aderezo,$u->_tipo,$u->_cantidad);
        $Usuario->_id = $u->_id;
        $Usuario->_nroPedido = $u->_nroPedido;
        $Usuario->_fecha = $u->_fecha;

        return $Usuario;
    }

    public function mostrarUsuario()
    {
        return "<br>". $this->_id . "-" . $this->_mail . "-".$this->_nombre .  "-" . $this->_aderezo . "-" . $this->_tipo . "-" . $this->_cantidad . "-" . $this->_nroPedido . "-" . $this->_fecha . "<br>";
    }

    public static function mostrarSaborIngresado($aderezo)
    {
        $ventas = Usuario::leerVentas(VENTAS);
        $equals = array();

        foreach($ventas as $v)
        {
            if($v->_aderezo == $aderezo)
            {
                array_push($equals,Usuario::convertirUsuario($v));
            }
        }

        if(count($equals)>0)
        {
            echo "Mostrando las ventas del aderezo '{$aderezo}' <br>";

            foreach($equals as $Usuario)
            {
                
                echo $Usuario->mostrarUsuario();
                
            }
        }else{
            echo "No hay ventas con del aderezo '{$aderezo}' <br>";
        }
    }

    public static function mostrarVentasUsuario($mail)
    {
        $ventas = Usuario::leerVentas(VENTAS);
        $equals = array();

        foreach($ventas as $v)
        {
            if($v->_mail == $mail)
            {
                array_push($equals,Usuario::convertirUsuario($v));
            }
        }

        if(count($equals)>0)
        {
            echo "Mostrando las ventas del usuario '{$mail}' <br>";

            foreach($equals as $Usuario)
            {
                
                echo $Usuario->mostrarUsuario();
                
            }
        }else{
            echo "No hay ventas con del usuario '{$mail}' <br>";
        }
    }

    public static function mostrarTipoIngresado($tipo)
    {
        $ventas = Usuario::leerVentas(VENTAS);
        $equals = array();

        foreach($ventas as $v)
        {
            if($v->_tipo == $tipo)
            {
                array_push($equals,Usuario::convertirUsuario($v));
            }
        }

        if(count($equals)>0)
        {
            echo "Mostrando las ventas del tipo '{$tipo}' <br>";

            foreach($equals as $Usuario)
            {
                
                echo $Usuario->mostrarUsuario();
                
            }
        }else{
            echo "No hay ventas con del tipo '{$tipo}' <br>";
        }
    }


    //BORRAR VENTA

    public static function moveToBackUp($usuario)
    {
        $nombreUsuario = explode("@",$usuario->_mail);       
        $nombreDeArchivo = "$usuario->_nombre - $usuario->_tipo - $nombreUsuario[0]";
        $origen = "ImagenesDeLaVenta/2023/" . $nombreDeArchivo . ".jpg";
        $destino = "BackUpVentas/2023/";
        is_dir($destino) ?: mkdir($destino,0777,true);
        $destinoFinal = $destino . $nombreDeArchivo . ".jpg";

        return Usuario::moveFile($origen,$destinoFinal);
    }

    public static function moveFile($origen,$destino)
    {   
        $retorno = false;
        
        if (file_exists($origen)) {
            if (rename($origen, $destino)) {
                echo "Pedido eliminado. Archivo enviado al sistema de Backups.<br>";
                $retorno = true;
            } else {
                echo "No se pudo mover el archivo.";
            }
        } else {
            echo "El archivo de origen no existe.";
        }

        return $retorno;       
    }


    public static function borrarVenta($nroPedido)
    {
        $ventas = Usuario::leerVentas(VENTAS);    

        $retorno = false;

        foreach($ventas as $v)
        {
            if($v->_nroPedido == $nroPedido && $v->_status != false)
            {   
                $v->_status = false;
                $retorno = Usuario::moveToBackUp($v);
            }
        }

        if(!$retorno)
        {
            echo "No se encontró el pedido.";
        }

        Usuario::GuardarInfo($ventas,VENTAS);

        return $retorno;
    }

    //DEVOLVER HAMBURGUESA

    public static function imgExist()
    {   
        $retorno = false;
        if(!empty($_FILES['imgEnojado']['name']) && $_FILES['imgEnojado']['error'] === UPLOAD_ERR_OK){ 
            $retorno = true;
        }

        return $retorno;
    }

    public static function DevolverHamburguesa($nroPedido,$razon)
    {   
        $pedidos = Usuario::leerVentas(VENTAS);
        $devoluciones = Usuario::leerVentas(DEVOLUCIONES);
        $cupones = Usuario::leerVentas(CUPONES);
        $equals = false;

        foreach($pedidos as $pedido)
        {
            if($pedido->_nroPedido == $nroPedido && $pedido->_status == true)
            {   
                $devolucion = new Devolucion($pedido,$razon,false);
                
                echo "Devolución generada.<br>";
                if(Usuario::imgExist())
                {
                    array_push($cupones,array(
                        '_usuario' => $pedido->_mail,
                        '_id' => Usuario::generarId(),
                        '_fechaVencimiento' => $fecha = (new DateTime())->add(new DateInterval('P3D'))->format('d-m-y'),
                        '_descuento' => 0.10,
                        '_activo' => true
                    ));
                    echo "Cupon generado.<br>";
                    $devolucion->_tieneCupon = true;
                }

                array_push($devoluciones,$devolucion->Devolucion($devolucion,$pedido->_nroPedido,$pedido->_id));  
                $equals = true;
                $pedido->_status = false;
                break;
            }
        }
        
        if($equals)
        {
            Usuario::GuardarInfo($devoluciones,DEVOLUCIONES);
            Usuario::GuardarInfo($cupones,CUPONES);
            Usuario::GuardarInfo($pedidos,VENTAS);
        }else{
            echo "ERROR al devolver el pedido. Verifica el número del mismo.";
        }   

        

    }

    public static function ValidarCupon($idCupon)
    {
        $cupones = Usuario::leerVentas(CUPONES);
        $retorno = false;

        if(count($cupones) != 0)
        {
            foreach($cupones as $cupon)
            {
                if($cupon->_id == $idCupon)
                {
                    if($cupon->_activo && date("d-m-y") <= $cupon->_fechaVencimiento)
                    {   
                        $cupon->_activo = false;
                        $retorno = $cupon->_descuento;
                       

                    }else{
                        echo "El cupon ya no esta activo.";
                    }
                    break;
                }
            }

            Usuario::GuardarInfo($cupones,CUPONES);
        }

        return $retorno;
    }
    

}


?>