<?php
    $linea = fgets(STDIN);
    $valores = explode(" ", trim($linea));

    // Si es numero apila, si es operador coje los dos ultimos numeros y realiza la operacion que indiquemos

    $resultado = '';

    $pila = [];

    // 1º bucle para recorrer el array
    for($i = 0; $i < count($valores); $i++){
        $elemento = $valores[$i];

        if(is_numeric($elemento)) {
            $pila = is_numeric($elemento); 
        } else{

            if(count($pila) >= 2) {
                $resultado = '(Error) El usuario ha introducido demasiados elementos.';
                exit;
            }
            $valorUno = array_pop($pila);
            $valorUno = array_pop($pila);

            switch($elemento[$i]) {
                case '+':
                    $resultado = $valorUno + $valorDos;
                    break;
                case ':':
                    $resultado = $valorUno / $valorDos;
                    break;
                case 'x':
                    $resultado = $valorUno * $valorDos;
                    break;
                case '-':
                    $resultado = $valorUno - $valorDos;
                    break;
            }

        }
    }

        if(!count($pila) = 1) {
            $resultado = '(Error) El usuario ha introducido demasiados elementos.';
        } else {
            $resultado = 'El resultado es: ' . $elemento;
        }

    echo $resultado;
?>
