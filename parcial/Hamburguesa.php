<?php

class Hamburguesa{
    public $_nombre;
    public $_precio;
    public $_tipo;
    public $_aderezo;
    public $_cantidad;
    public $_id;

    public function __construct($nombre,$precio,$tipo,$aderezo,$cantidad)
    {
        $this->_id = $this->generarId();
        $this->_nombre = $nombre;
        $this->_precio = $precio;
        $this->_tipo = Hamburguesa::ValidarTipo($tipo);
        $this->_aderezo = Hamburguesa::ValidarAderezo($aderezo);
        $this->_cantidad = $cantidad;
    }

    public static function ValidarAderezo($aderezo)
    {   
        $retorno = "mayonesa";
        switch($aderezo)
        {
            case 'mayonesa':
            case 'ketchup':
            case 'mostaza':
                $retorno = $aderezo;
            break;
        }

        return $retorno;
    }

    public static function ValidarTipo($tipo)
    {   
        $retorno = "simple";
        switch($tipo)
        {
            case 'simple':
            case 'doble':
                $retorno = $tipo;
            break;
        }

        return $retorno;
    }
    
    public static function LeerInfo(){

        $ar = fopen("Hamburguesas.json", "a+");
        $linea = fgets($ar);
        fclose($ar);
        $decode = json_decode($linea);
        
        if($decode != "")
        {
            return $decode;
        }              
        return array();
    }

    public function generarId()
    {
        return count(Hamburguesa::LeerInfo()) + 1;   
    }

    public static function GuardarImagen($burger)
    {
        $nombreDeArchivo = "{$burger->_tipo}-{$burger->_nombre}";
        $destino = "ImagenesDeHamburguesas/2023/";
        is_dir($destino) ?: mkdir($destino,0777,true);
        
        $destinoFinal = $destino . $nombreDeArchivo . ".jpg";

        $tmpName = $_FILES['img']['tmp_name'];
        
        return move_uploaded_file($tmpName, $destinoFinal);
    }

    public static function GuardarBurger($burgers)
    {
        if($burgers != null)
        {
            $ar = fopen("Hamburguesas.json", "w");

            $retorno = fwrite($ar,json_encode($burgers));

            fclose($ar);
        
        }else{
            echo "La lista esta vacia";
        }
            
    }
    
    public static function GenerarBurger($burger)
    {
        $array = Hamburguesa::LeerInfo();
        $exist = false;

        foreach($array as $b)
        {
            if($burger->_nombre == $b->_nombre && $burger->_tipo == $b->_tipo)
            {
                $b->_precio = $burger->_precio;
                $b->_cantidad += $burger->_cantidad;
                $exist = true;
                echo "Hamburguesa actualizada con exito!<br>";
                break;             
            }
        }

        if(!$exist){
            array_push($array,$burger);
            Hamburguesa::GuardarImagen($burger);
            echo "Carga de Hamburguesa satisfactoria!";
        }

        Hamburguesa::GuardarBurger($array);
        
    }

    public static function modificarStock($cantidad,$key,$modificacion)
    {
        $array = Hamburguesa::LeerInfo();
        $retorno = false;
        
        foreach($array as $p)
        {
            if($p->_id == $key)
            {
                if($modificacion == "restar")
                {   
                    $valor = $p->_cantidad - intval($cantidad); 
                    //echo $valor;
                    if($valor >= 0)
                    {
                        $p->_cantidad -= intval($cantidad);
                        $retorno = true;
                    }else{
                      
                        echo "No tenemos stock";
                    }

                       
                }else{
                    $p->_cantidad += intval($cantidad);
                    $retorno = true;
                }   
                
                
            }
        }

        
        Hamburguesa::GuardarBurger($array);
        
        return $retorno;
    }

    
public static function HayStock($nombre,$tipo,$aderezo)
{
    $array = Hamburguesa::LeerInfo();
    //var_dump($array);
    $existenciaNombre = "No hay {$nombre}<br>";
    $existenciaTipo = "<br>No hay {$tipo}";
    $id = -1000;
    $stock = -1;
    $precio = -1;
    $tipo = Hamburguesa::ValidarTipo($tipo);

    foreach($array as $b)
    {
        if($b->_nombre == $nombre)
        {       
            if($b->_cantidad > 0)
            {
                $existenciaNombre = "Si hay {$nombre}";
                //$stock = $b->_cantidad;
            }
            

            if($tipo == $b->_tipo)
            {
                if($b->_cantidad > 0)
                {
                    $existenciaTipo = ", y hay {$tipo}";
                    if($aderezo == $b->_aderezo)
                    {
                        
                        $stock = $b->_cantidad;
                        $id = $b->_id;
                        $precio = $b->_precio;
                    }
                    
                }
                break;
            }
                      
        }
    }

    $retorno = array(
        'nombre' => $existenciaNombre,
        'tipo' => $existenciaTipo,
        'id' => $id,
        'stock' => $stock,
        'precio' => $precio
    );

    return json_encode($retorno);
}

}

?>