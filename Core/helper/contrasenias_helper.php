<?php
    /**Encriptar un valor */
    function encriptar($valor)
    {
        $tipo='ripemd160';

        $str = $valor;
        return hash($tipo, $str);
    }//Fin de la funcion
?>